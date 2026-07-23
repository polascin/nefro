<?php

declare(strict_types=1);
/**
 * admin_drugs_review.php
 * Fáza 6 — podpora zverejňovania: kontrolný a tlačiteľný prehľad liekov.
 *
 * Odborník tu vidí VŠETKY lieky (predvolene nezverejnené) s celým kurátorským obsahom
 * naraz — renálne dávkovanie, dialyzovateľnosť, nefrotoxicita, upozornenia… — môže ich
 * pohodlne skontrolovať proti SPC (na obrazovke alebo vytlačené) a priamo zverejniť/skryť.
 * Doplnok k admin_drugs.php (editácia jednotlivých polí). Read-only + akcia zverejnenia.
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/drugs_common.php';

requireAdmin();

$catLabels = dgCategoryLabels();
$actionResult = null;
$actionError = null;

// ── Akcia: zverejniť / skryť jeden liek (rovnaký kontrakt ako admin_drugs.php) ──
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!checkFormRateLimit($pdo, 'admin_post_' . basename(__FILE__), getClientIpAddress(), 60, 300)) {
        $actionError = 'Príliš veľa požiadaviek. Skúste to neskôr.';
    } elseif (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $actionError = 'Neplatný CSRF token.';
    } elseif (($_POST['action'] ?? '') === 'toggle_publish') {
        requireAdminReauth();
        $id = (int) ($_POST['drug_id'] ?? 0);
        $setPub = (int) ($_POST['set_pub'] ?? -1);
        if ($id <= 0 || !in_array($setPub, [0, 1], true)) {
            $actionError = 'Neplatný vstup.';
        } else {
            try {
                $pdo->prepare('UPDATE drugs SET is_published = :pub WHERE id = :id')
                    ->execute(['pub' => $setPub, 'id' => $id]);
                logAdminAction($pdo, 'drug_review_toggle_publish', 'drug', $id, ['is_published' => $setPub]);
                $actionResult = $setPub === 1 ? 'Liek bol zverejnený.' : 'Liek bol skrytý.';
            } catch (\PDOException $e) {
                error_log('admin_drugs_review toggle error: ' . $e->getMessage());
                $actionError = 'Chyba pri zmene viditeľnosti.';
            }
        }
    }
}

// ── Filtre ────────────────────────────────────────────────────────────────────
// Filtre čítame z GET, po akcii (POST) z POST, aby sa zachovali. Predvolene nezverejnené.
$fPub = (string) ($_GET['pub'] ?? $_POST['pub'] ?? 'hidden');
if (!in_array($fPub, ['', 'hidden', 'published'], true)) {
    $fPub = 'hidden';
}
$fCat = (string) ($_GET['kat'] ?? $_POST['kat'] ?? '');
if ($fCat !== '' && !array_key_exists($fCat, $catLabels)) {
    $fCat = '';
}

$where = ' WHERE 1=1';
$params = [];
if ($fPub === 'hidden') {
    $where .= ' AND is_published = 0';
} elseif ($fPub === 'published') {
    $where .= ' AND is_published = 1';
}
if ($fCat !== '') {
    $where .= ' AND category = :cat';
    $params['cat'] = $fCat;
}

$drugs = [];
try {
    $stmt = $pdo->prepare('SELECT * FROM drugs' . $where . ' ORDER BY category ASC, name_sk ASC');
    $stmt->execute($params);
    $drugs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    error_log('admin_drugs_review list error: ' . $e->getMessage());
}

// ── Globálne počty pre súhrn ──────────────────────────────────────────────────
$cntTotal = 0;
$cntPublished = 0;
$cntNoDosing = 0;
try {
    $cntTotal = (int) $pdo->query('SELECT COUNT(*) FROM drugs')->fetchColumn();
    $cntPublished = (int) $pdo->query('SELECT COUNT(*) FROM drugs WHERE is_published = 1')->fetchColumn();
    $cntNoDosing = (int) $pdo->query("SELECT COUNT(*) FROM drugs WHERE renal_dosing IS NULL OR renal_dosing = ''")->fetchColumn();
} catch (\PDOException $e) {
    error_log('admin_drugs_review counts error: ' . $e->getMessage());
}

$csrfToken = generateCsrfToken();

/** Kurátorské klinické polia, ktoré kontrolujeme na úplnosť (label → stĺpec). */
const DGR_FIELDS = [
    'indications'    => 'Indikácie',
    'renal_dosing'   => '🫘 Dávkovanie podľa funkcie obličiek',
    'nephrotoxicity' => 'Nefrotoxicita',
    'dialyzability'  => 'Dialyzovateľnosť',
    'warnings'       => 'Upozornenia',
    'monitoring'     => 'Monitorovanie',
];

/** Počet vyplnených kurátorských klinických polí (z DGR_FIELDS). */
function dgrFilledCount(array $drug): int
{
    $n = 0;
    foreach (array_keys(DGR_FIELDS) as $col) {
        if (trim((string) ($drug[$col] ?? '')) !== '') {
            $n++;
        }
    }
    return $n;
}

/** Vykreslí jednu kurátorskú sekciu (ak má obsah). */
function dgrSection(string $title, ?string $body, bool $highlight = false): void
{
    if (trim((string) $body) === '') {
        return;
    }
    $cls = $highlight ? 'info-box-blue' : 'review-section';
    echo '<div class="' . $cls . '"><strong>' . htmlspecialchars($title) . ':</strong> '
        . nl2br(htmlspecialchars((string) $body)) . '</div>';
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontrola a zverejňovanie liekov – Nefro-projekt Slovensko</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
  <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>"></script>
  <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
  <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body class="drug-review-page">
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
  <?php
  $headerTitle = 'Kontrola a zverejňovanie liekov';
  $headerIntro = 'Prehľad kurácie na odbornú kontrolu proti SPC a zverejnenie';
  $showLogo = false;
  include_once 'header.php';
  ?>
  <div class="no-print"><?php include_once 'admin_menu.php'; ?></div>

  <main id="main-content" class="container container--wide admin-page-main" role="main">
    <div class="auth-container auth-container--wide">

      <?php if ($actionResult !== null): ?>
        <div class="alert alert-success no-print"><p><?= htmlspecialchars((string) $actionResult) ?></p></div>
      <?php endif; ?>
      <?php if ($actionError !== null): ?>
        <div class="alert alert-error no-print"><p><?= htmlspecialchars($actionError) ?></p></div>
      <?php endif; ?>

      <div class="info-box">
        <strong>Spolu liekov:</strong> <?= $cntTotal ?> &ensp;&bull;&ensp;
        <strong>Zverejnených:</strong> <?= $cntPublished ?> &ensp;&bull;&ensp;
        <strong>Nezverejnených:</strong> <?= $cntTotal - $cntPublished ?> &ensp;&bull;&ensp;
        <strong>Bez renálneho dávkovania:</strong> <?= $cntNoDosing ?>
      </div>

      <p class="helper-text no-print">
        Skontrolujte obsah proti aktuálnemu SPC (ŠÚKL/EMA). Drobné úpravy textu robte
        v <a href="admin_drugs.php">Správe liekov</a>; tu liek po kontrole rovno zverejníte.
        Stránku možno vytlačiť (akcie a navigácia sa netlačia).
      </p>

      <form method="GET" action="admin_drugs_review.php" class="form-row-inline admin-filter-form no-print">
        <label for="pub">Stav:</label>
        <select id="pub" name="pub" class="form-control admin-select-sm">
          <option value="hidden" <?= $fPub === 'hidden' ? 'selected' : '' ?>>Nezverejnené</option>
          <option value="published" <?= $fPub === 'published' ? 'selected' : '' ?>>Zverejnené</option>
          <option value="" <?= $fPub === '' ? 'selected' : '' ?>>Všetky</option>
        </select>
        <label for="kat">Kategória:</label>
        <select id="kat" name="kat" class="form-control admin-select-md">
          <option value="">Všetky</option>
          <?php foreach ($catLabels as $slug => $label): ?>
            <option value="<?= htmlspecialchars($slug) ?>" <?= $fCat === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="btn-secondary-small">Filtrovať</button>
        <a href="admin_drugs_review.php" class="btn-secondary-small">Reset</a>
        <button type="button" class="btn-secondary-small js-print">🖨 Vytlačiť</button>
      </form>

      <p class="helper-text">Zobrazených: <strong><?= count($drugs) ?></strong> liekov<?= $fPub === 'hidden' ? ' (nezverejnené)' : '' ?>.</p>

      <?php if (empty($drugs)): ?>
        <p>Žiadne lieky pre zvolený filter.</p>
      <?php else:
          $lastCat = null;
          foreach ($drugs as $d):
              $cat = (string) $d['category'];
              if ($cat !== $lastCat):
                  $lastCat = $cat;
                  echo '<h2 class="review-cat-h">' . htmlspecialchars(dgCategoryLabel($cat)) . '</h2>';
              endif;
              $filled = dgrFilledCount($d);
              $pub = (int) ($d['is_published'] ?? 0) === 1;
              $sources = dgDecodeJsonList($d['source_refs'] ?? null);
      ?>
        <article class="review-drug">
          <h3>
            <?= htmlspecialchars((string) $d['name_sk']) ?>
            <?= $pub ? '<span class="badge-pub">Zverejnený</span>' : '<span class="badge-draft">Nezverejnený</span>' ?>
          </h3>
          <div class="review-meta">
            <?php if (!empty($d['name_intl'])): ?>INN: <?= htmlspecialchars((string) $d['name_intl']) ?> &bull; <?php endif; ?>
            <?php if (!empty($d['drug_class'])): ?><?= htmlspecialchars((string) $d['drug_class']) ?> &bull; <?php endif; ?>
            <?php if (!empty($d['atc_code'])): ?>ATC <?= htmlspecialchars((string) $d['atc_code']) ?> &bull; <?php endif; ?>
            <?php if (!empty($d['chembl_id'])): ?><?= htmlspecialchars((string) $d['chembl_id']) ?> &bull; <?php endif; ?>
            <span class="review-complete <?= $filled === count(DGR_FIELDS) ? 'ok' : 'warn' ?>">kurácia <?= $filled ?>/<?= count(DGR_FIELDS) ?></span>
          </div>

          <?php if ((int) ($d['black_box_warning'] ?? 0) === 1 || (int) ($d['withdrawn'] ?? 0) === 1): ?>
            <div class="info-box-yellow">
              <?php if ((int) ($d['black_box_warning'] ?? 0) === 1): ?><strong>⚠ FDA black box warning</strong><?php endif; ?>
              <?php if ((int) ($d['withdrawn'] ?? 0) === 1): ?> &bull; <strong>Stiahnutý z trhu</strong> (niektoré krajiny)<?php endif; ?>
            </div>
          <?php endif; ?>

          <?php
          dgrSection(DGR_FIELDS['renal_dosing'], $d['renal_dosing'] ?? null, true);
          dgrSection('Mechanizmus', $d['mechanism'] ?? null);
          dgrSection(DGR_FIELDS['indications'], $d['indications'] ?? null);
          dgrSection(DGR_FIELDS['nephrotoxicity'], $d['nephrotoxicity'] ?? null);
          dgrSection(DGR_FIELDS['dialyzability'], $d['dialyzability'] ?? null);
          dgrSection(DGR_FIELDS['warnings'], $d['warnings'] ?? null);
          dgrSection(DGR_FIELDS['monitoring'], $d['monitoring'] ?? null);
          dgrSection('Slovenský kontext', $d['sk_note'] ?? null);
          ?>

          <?php if ($sources !== []): ?>
            <div class="review-section"><strong>Zdroje:</strong>
              <?php foreach ($sources as $src):
                  if (!is_array($src) || empty($src['url']) || empty($src['label'])) { continue; }
                  $u = (string) $src['url'];
                  if (!preg_match('#^https://#', $u)) { continue; }
              ?>
                <a href="<?= htmlspecialchars($u) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars((string) $src['label']) ?></a>&ensp;
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <div class="review-actions no-print">
            <form method="POST" action="admin_drugs_review.php" class="d-inline">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
              <input type="hidden" name="action" value="toggle_publish">
              <input type="hidden" name="drug_id" value="<?= (int) $d['id'] ?>">
              <input type="hidden" name="set_pub" value="<?= $pub ? 0 : 1 ?>">
              <input type="hidden" name="pub" value="<?= htmlspecialchars($fPub) ?>">
              <input type="hidden" name="kat" value="<?= htmlspecialchars($fCat) ?>">
              <button type="submit" class="<?= $pub ? 'btn-secondary-small' : 'btn-primary' ?>"><?= $pub ? '🙈 Skryť' : '👁 Zverejniť' ?></button>
            </form>
            <a href="admin_drugs.php?action=edit&id=<?= (int) $d['id'] ?>" class="btn-secondary-small">✏️ Upraviť</a>
            <a href="liek.php?slug=<?= urlencode((string) $d['slug']) ?>" target="_blank" rel="noopener" class="btn-secondary-small">🔎 Verejný detail</a>
          </div>
        </article>
      <?php endforeach; endif; ?>

      <p class="mt-30 no-print"><a href="admin_drugs.php" class="btn-secondary">← Späť na Správu liekov</a></p>

    </div>
  </main>

  <?php include_once 'footer.php'; ?>
</body>
</html>
