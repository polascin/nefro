<?php

declare(strict_types=1);
/**
 * admin_drugs.php
 * Fáza 6 — kurátorská správa databázy liekov (drugs).
 *
 * Sync (`sync_drugs.php`) napĺňa technické/farmakologické polia z ChEMBL a vytvára
 * lieky ako NEZVEREJNENÉ. Tu odborník dopĺňa klinické polia (renálne dávkovanie,
 * nefrotoxicita, dialyzovateľnosť, upozornenia, monitorovanie, slovenský kontext)
 * a liek ZVEREJNÍ. Možno aj ručne pridať liek bez ChEMBL.
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/drugs_common.php';

requireAdmin();

const DG_ERR_INVALID_ID = 'Neplatné ID lieku.';
const DG_ERR_NOT_FOUND  = 'Liek nenájdený.';
const DG_TEXT_MAXLEN    = 8000;

$catLabels = dgCategoryLabels();

$actionResult = null;
$actionError  = null;
$editDrug     = null;

/** Zabezpečí unikátnosť slugu v tabuľke drugs. */
function dgUniqueSlug(PDO $pdo, string $slug, int $excludeId = 0): string
{
    $base = $slug !== '' ? $slug : 'liek';
    $slug = $base;
    $n = 2;
    while (true) {
        $stmt = $pdo->prepare("SELECT id FROM drugs WHERE slug = :slug AND id != :id LIMIT 1");
        $stmt->execute(['slug' => $slug, 'id' => $excludeId]);
        if ($stmt->fetch() === false) {
            return $slug;
        }
        $slug = $base . '-' . $n;
        $n++;
    }
}

/** Orezanie textového poľa na limit (alebo null ak prázdne). */
function dgClip(string $v): ?string
{
    $v = trim($v);
    if ($v === '') {
        return null;
    }
    return mb_strlen($v) > DG_TEXT_MAXLEN ? mb_substr($v, 0, DG_TEXT_MAXLEN) : $v;
}

/** Synonymá: vstup CSV → JSON pole reťazcov (alebo null). */
function dgSynonymsToJson(string $raw): ?string
{
    $parts = array_values(array_filter(array_map(
        static fn ($s): string => trim((string) $s),
        explode(',', $raw)
    ), static fn (string $s): bool => $s !== ''));
    if ($parts === []) {
        return null;
    }
    return json_encode(array_slice($parts, 0, 40), JSON_UNESCAPED_UNICODE) ?: null;
}

/** Zdroje: vstup „názov|url“ na riadok → JSON pole {label,url} (len https). */
function dgSourcesToJson(string $raw): ?string
{
    $out = [];
    foreach (preg_split('/\r\n|\r|\n/', $raw) ?: [] as $line) {
        $line = trim((string) $line);
        if ($line === '' || !str_contains($line, '|')) {
            continue;
        }
        [$label, $url] = array_map('trim', explode('|', $line, 2));
        if ($label === '' || !preg_match('#^https://#', $url)) {
            continue;
        }
        $out[] = ['label' => mb_substr($label, 0, 120), 'url' => mb_substr($url, 0, 300)];
    }
    if ($out === []) {
        return null;
    }
    return json_encode(array_slice($out, 0, 20), JSON_UNESCAPED_UNICODE) ?: null;
}

/** JSON pole reťazcov → CSV pre formulár. */
function dgSynonymsToText(?string $json): string
{
    $d = dgDecodeJsonList($json);
    return implode(', ', array_map('strval', $d));
}

/** JSON pole {label,url} → „názov|url“ na riadok pre formulár. */
function dgSourcesToText(?string $json): string
{
    $lines = [];
    foreach (dgDecodeJsonList($json) as $s) {
        if (is_array($s) && !empty($s['label']) && !empty($s['url'])) {
            $lines[] = (string) $s['label'] . '|' . (string) $s['url'];
        }
    }
    return implode("\n", $lines);
}

/** Spoločné čítanie a validácia polí formulára (create aj update). */
function dgReadForm(array $catLabels): array
{
    $nameSk = trim((string) ($_POST['name_sk'] ?? ''));
    $category = (string) ($_POST['category'] ?? 'other');
    if (!array_key_exists($category, $catLabels)) {
        $category = 'other';
    }
    $maxPhaseRaw = trim((string) ($_POST['max_phase'] ?? ''));
    $maxPhase = $maxPhaseRaw === '' ? null : max(0, min(4, (int) $maxPhaseRaw));
    $approvalRaw = trim((string) ($_POST['first_approval'] ?? ''));
    $approval = $approvalRaw === '' ? null : (int) $approvalRaw;
    if ($approval !== null && ($approval < 1900 || $approval > (int) date('Y') + 1)) {
        $approval = null;
    }
    return [
        'name_sk'        => $nameSk,
        'name_intl'      => (($v = trim((string) ($_POST['name_intl'] ?? ''))) !== '') ? mb_substr($v, 0, 200) : null,
        'chembl_id'      => (($v = trim((string) ($_POST['chembl_id'] ?? ''))) !== '') ? mb_substr($v, 0, 20) : null,
        'atc_code'       => (($v = trim((string) ($_POST['atc_code'] ?? ''))) !== '') ? mb_substr($v, 0, 16) : null,
        'drug_class'     => (($v = trim((string) ($_POST['drug_class'] ?? ''))) !== '') ? mb_substr($v, 0, 200) : null,
        'routes'         => (($v = trim((string) ($_POST['routes'] ?? ''))) !== '') ? mb_substr($v, 0, 100) : null,
        'category'       => $category,
        'max_phase'      => $maxPhase,
        'first_approval' => $approval,
        'black_box_warning' => isset($_POST['black_box_warning']) ? 1 : 0,
        'withdrawn'      => isset($_POST['withdrawn']) ? 1 : 0,
        'mechanism'      => dgClip((string) ($_POST['mechanism'] ?? '')),
        'indications'    => dgClip((string) ($_POST['indications'] ?? '')),
        'renal_dosing'   => dgClip((string) ($_POST['renal_dosing'] ?? '')),
        'nephrotoxicity' => dgClip((string) ($_POST['nephrotoxicity'] ?? '')),
        'dialyzability'  => dgClip((string) ($_POST['dialyzability'] ?? '')),
        'warnings'       => dgClip((string) ($_POST['warnings'] ?? '')),
        'monitoring'     => dgClip((string) ($_POST['monitoring'] ?? '')),
        'sk_note'        => dgClip((string) ($_POST['sk_note'] ?? '')),
        'synonyms'       => dgSynonymsToJson((string) ($_POST['synonyms'] ?? '')),
        'source_refs'    => dgSourcesToJson((string) ($_POST['source_refs'] ?? '')),
        'is_published'   => isset($_POST['is_published']) ? 1 : 0,
    ];
}

// ── Spracovanie POST akcií ────────────────────────────────────────────────────
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!checkFormRateLimit($pdo, 'admin_post_' . basename(__FILE__), getClientIpAddress(), 60, 300)) {
        $actionError = 'Príliš veľa požiadaviek. Skúste to neskôr.';
    } elseif (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $actionError = 'Neplatný CSRF token.';
    } else {
        $action = (string) ($_POST['action'] ?? '');
        switch ($action) {
            case 'create':
            case 'update':
                $data = dgReadForm($catLabels);
                if ($data['name_sk'] === '') {
                    $actionError = 'Slovenský názov lieku je povinný.';
                    break;
                }
                $slug = trim((string) ($_POST['slug'] ?? ''));
                $slug = $slug !== '' ? dgSlugify($slug) : dgSlugify($data['name_sk']);
                $id = (int) ($_POST['drug_id'] ?? 0);

                if ($action === 'update' && $id <= 0) {
                    $actionError = DG_ERR_INVALID_ID;
                    break;
                }
                $data['slug'] = dgUniqueSlug($pdo, $slug, $action === 'update' ? $id : 0);

                try {
                    if ($action === 'create') {
                        $cols = array_keys($data);
                        $place = array_map(static fn (string $c): string => ':' . $c, $cols);
                        $stmt = $pdo->prepare(
                            'INSERT INTO drugs (' . implode(', ', $cols) . ') VALUES (' . implode(', ', $place) . ')'
                        );
                        $stmt->execute($data);
                        $newDrugId = (int) $pdo->lastInsertId();
                        logAdminAction($pdo, 'drug_create', 'drug', $newDrugId, ['name_sk' => $data['name_sk'], 'slug' => $data['slug']]);
                        $actionResult = 'Liek „' . $data['name_sk'] . '“ bol vytvorený' . ($data['is_published'] ? ' a zverejnený.' : ' (nezverejnený).');
                    } else {
                        $chk = $pdo->prepare('SELECT id FROM drugs WHERE id = :id LIMIT 1');
                        $chk->execute(['id' => $id]);
                        if ($chk->fetch() === false) {
                            $actionError = DG_ERR_NOT_FOUND;
                            break;
                        }
                        $set = implode(', ', array_map(static fn (string $c): string => "$c = :$c", array_keys($data)));
                        $data['id'] = $id;
                        $stmt = $pdo->prepare("UPDATE drugs SET $set WHERE id = :id");
                        $stmt->execute($data);
                        logAdminAction($pdo, 'drug_update', 'drug', $id, ['name_sk' => $data['name_sk'], 'slug' => $data['slug']]);
                        $actionResult = 'Liek „' . $data['name_sk'] . '“ bol aktualizovaný.';
                    }
                } catch (\PDOException $e) {
                    error_log('admin_drugs save error: ' . $e->getMessage());
                    $actionError = 'Chyba pri ukladaní lieku (možný duplicitný ChEMBL ID alebo slug).';
                }
                break;

            case 'toggle_publish':
                requireAdminReauth();
                $id = (int) ($_POST['drug_id'] ?? 0);
                $setPub = (int) ($_POST['set_pub'] ?? -1);
                if ($id <= 0) {
                    $actionError = DG_ERR_INVALID_ID;
                    break;
                }
                if (!in_array($setPub, [0, 1], true)) {
                    $actionError = 'Neplatná hodnota viditeľnosti.';
                    break;
                }
                try {
                    $pdo->prepare('UPDATE drugs SET is_published = :pub WHERE id = :id')
                        ->execute(['pub' => $setPub, 'id' => $id]);
                    logAdminAction($pdo, 'drug_toggle_publish', 'drug', $id, ['is_published' => $setPub]);
                    $actionResult = $setPub === 1 ? 'Liek bol zverejnený.' : 'Liek bol skrytý.';
                } catch (\PDOException $e) {
                    error_log('admin_drugs toggle error: ' . $e->getMessage());
                    $actionError = 'Chyba pri zmene viditeľnosti.';
                }
                break;

            case 'delete':
                requireAdminReauth();
                $id = (int) ($_POST['drug_id'] ?? 0);
                if ($id <= 0) {
                    $actionError = DG_ERR_INVALID_ID;
                    break;
                }
                try {
                    $chk = $pdo->prepare('SELECT name_sk FROM drugs WHERE id = :id LIMIT 1');
                    $chk->execute(['id' => $id]);
                    $row = $chk->fetch(\PDO::FETCH_ASSOC);
                    if ($row === false) {
                        $actionError = DG_ERR_NOT_FOUND;
                        break;
                    }
                    $pdo->prepare('DELETE FROM drugs WHERE id = :id')->execute(['id' => $id]);
                    logAdminAction($pdo, 'drug_delete', 'drug', $id, ['name_sk' => (string) $row['name_sk']]);
                    $actionResult = 'Liek „' . (string) $row['name_sk'] . '“ bol odstránený.';
                } catch (\PDOException $e) {
                    error_log('admin_drugs delete error: ' . $e->getMessage());
                    $actionError = 'Chyba pri mazaní lieku.';
                }
                break;

            default:
                $actionError = 'Neznáma akcia.';
                break;
        }
    }
}

// ── Načítanie lieku na editáciu (GET) ─────────────────────────────────────────
$editId = (int) ($_GET['id'] ?? 0);
if (($_GET['action'] ?? '') === 'edit' && $editId > 0) {
    try {
        $stmt = $pdo->prepare('SELECT * FROM drugs WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $editId]);
        $editDrug = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    } catch (\PDOException $e) {
        error_log('admin_drugs edit load error: ' . $e->getMessage());
    }
}

// ── Filtre + zoznam ───────────────────────────────────────────────────────────
$fCat = (string) ($_GET['kat'] ?? '');
if ($fCat !== '' && !array_key_exists($fCat, $catLabels)) {
    $fCat = '';
}
$fPub = (string) ($_GET['pub'] ?? '');
if (!in_array($fPub, ['', 'published', 'hidden'], true)) {
    $fPub = '';
}
$fQuery = trim((string) ($_GET['q'] ?? ''));
if (mb_strlen($fQuery) > 100) {
    $fQuery = mb_substr($fQuery, 0, 100);
}

$where = ' WHERE 1=1';
$params = [];
if ($fCat !== '') {
    $where .= ' AND category = :cat';
    $params['cat'] = $fCat;
}
if ($fPub === 'published') {
    $where .= ' AND is_published = 1';
} elseif ($fPub === 'hidden') {
    $where .= ' AND is_published = 0';
}
if ($fQuery !== '') {
    $where .= ' AND (name_sk LIKE :q ESCAPE \'!\' OR name_intl LIKE :q ESCAPE \'!\' OR drug_class LIKE :q ESCAPE \'!\' OR atc_code LIKE :q ESCAPE \'!\')';
    $params['q'] = likeSearchPattern($fQuery);
}

$drugs = [];
$total = 0;
$lastSync = null;
$missingDosing = 0;
try {
    $countStmt = $pdo->prepare('SELECT COUNT(*) FROM drugs' . $where);
    $countStmt->execute($params);
    $total = (int) $countStmt->fetchColumn();

    $listStmt = $pdo->prepare(
        'SELECT id, slug, name_sk, name_intl, drug_class, atc_code, category, is_published,
                renal_dosing, chembl_id
         FROM drugs' . $where . ' ORDER BY name_sk ASC'
    );
    $listStmt->execute($params);
    $drugs = $listStmt->fetchAll(\PDO::FETCH_ASSOC);

    $lastSync = dgLastSync($pdo);
    $missingDosing = (int) $pdo->query(
        "SELECT COUNT(*) FROM drugs WHERE is_published = 1 AND (renal_dosing IS NULL OR renal_dosing = '')"
    )->fetchColumn();
} catch (\PDOException $e) {
    error_log('admin_drugs list error: ' . $e->getMessage());
}

$csrfToken = generateCsrfToken();

/** Hodnota poľa editovaného lieku pre formulár. */
function dgEditVal(?array $drug, string $key): string
{
    return htmlspecialchars((string) ($drug[$key] ?? ''));
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Správa liekov – Nefro-projekt Slovensko</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
  <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>"></script>
  <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
  <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
  <?php
  $headerTitle = 'Správa liekov';
  $headerIntro = 'Kurácia databázy liekov (ChEMBL + SPC)';
  $showLogo = false;
    include_once 'header.php';
    include_once 'admin_menu.php';
  ?>

  <main id="main-content" class="container container--wide admin-page-main" role="main">
    <div class="auth-container auth-container--wide">
      <h2>Správa liekov</h2>
      <p class="auth-subtitle">
        Farmakológiu napĺňa synchronizácia z ChEMBL (lieky vznikajú ako <strong>nezverejnené</strong>).
        Klinické polia (renálne dávkovanie, nefrotoxicita, dialyzovateľnosť, upozornenia) dopĺňajte ručne
        z SPC a liek zverejnite až po odbornej kontrole.
        <?php if ($lastSync !== null): ?> Posledná synchronizácia: <strong><?= htmlspecialchars($lastSync) ?></strong>.<?php endif; ?>
      </p>
      <p><a href="admin_drugs_review.php" class="btn-primary">📋 Kontrola a zverejňovanie (prehľad + tlač)</a></p>

      <?php if ($actionResult !== null): ?>
        <div class="alert alert-success"><p><?= htmlspecialchars((string) $actionResult) ?></p></div>
      <?php endif; ?>
      <?php if ($actionError !== null): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($actionError) ?></p></div>
      <?php endif; ?>

      <!-- ── FORMULÁR (create / edit) ─────────────────────────────────── -->
      <div class="primary-article">
        <h3><?= $editDrug ? 'Upraviť liek' : 'Pridať liek' ?></h3>
        <?php if ($editDrug && !empty($editDrug['chembl_id'])): ?>
          <p class="calc-result-detail">ChEMBL: <a href="<?= htmlspecialchars(dgChemblUrl((string) $editDrug['chembl_id'])) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars((string) $editDrug['chembl_id']) ?> ↗</a>
            <?php if (!empty($editDrug['slug'])): ?> &ensp;&bull;&ensp; <a href="liek.php?slug=<?= urlencode((string) $editDrug['slug']) ?>" target="_blank" rel="noopener">Verejný detail ↗</a><?php endif; ?>
          </p>
        <?php endif; ?>

        <form method="POST" action="admin_drugs.php">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <input type="hidden" name="action" value="<?= $editDrug ? 'update' : 'create' ?>">
          <?php if ($editDrug): ?>
            <input type="hidden" name="drug_id" value="<?= (int) $editDrug['id'] ?>">
          <?php endif; ?>

          <div class="article-form-grid">
            <div class="form-row">
              <label for="f_name_sk">Slovenský názov <span class="text-error">*</span></label>
              <input type="text" id="f_name_sk" name="name_sk" required maxlength="200" value="<?= dgEditVal($editDrug, 'name_sk') ?>" placeholder="napr. Dapagliflozín">
            </div>
            <div class="form-row">
              <label for="f_slug">Slug (URL)</label>
              <input type="text" id="f_slug" name="slug" maxlength="120" value="<?= dgEditVal($editDrug, 'slug') ?>" placeholder="nechajte prázdne pre automatické generovanie">
            </div>
            <div class="form-row">
              <label for="f_name_intl">Medzinárodný názov (INN)</label>
              <input type="text" id="f_name_intl" name="name_intl" maxlength="200" value="<?= dgEditVal($editDrug, 'name_intl') ?>" placeholder="napr. Dapagliflozin">
            </div>
            <div class="form-row">
              <label for="f_drug_class">Lieková trieda</label>
              <input type="text" id="f_drug_class" name="drug_class" maxlength="200" value="<?= dgEditVal($editDrug, 'drug_class') ?>" placeholder="napr. SGLT2 inhibítor">
            </div>
            <div class="form-row">
              <label for="f_category">Kategória</label>
              <?php $editCat = (string) ($editDrug['category'] ?? 'nephroprotect'); ?>
              <select id="f_category" name="category">
                <?php foreach ($catLabels as $slug => $label): ?>
                  <option value="<?= htmlspecialchars($slug) ?>" <?= $editCat === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-row">
              <label for="f_atc">ATC kód</label>
              <input type="text" id="f_atc" name="atc_code" maxlength="16" value="<?= dgEditVal($editDrug, 'atc_code') ?>" placeholder="napr. A10BK01">
            </div>
            <div class="form-row">
              <label for="f_chembl">ChEMBL ID</label>
              <input type="text" id="f_chembl" name="chembl_id" maxlength="20" value="<?= dgEditVal($editDrug, 'chembl_id') ?>" placeholder="napr. CHEMBL429910">
            </div>
            <div class="form-row">
              <label for="f_routes">Cesty podania (CSV)</label>
              <input type="text" id="f_routes" name="routes" maxlength="100" value="<?= dgEditVal($editDrug, 'routes') ?>" placeholder="oral,parenteral">
            </div>
            <div class="form-row">
              <label for="f_maxphase">Max. fáza (0–4)</label>
              <input type="number" id="f_maxphase" name="max_phase" min="0" max="4" value="<?= dgEditVal($editDrug, 'max_phase') ?>">
            </div>
            <div class="form-row">
              <label for="f_approval">Rok schválenia</label>
              <input type="number" id="f_approval" name="first_approval" min="1900" max="<?= (int) date('Y') + 1 ?>" value="<?= dgEditVal($editDrug, 'first_approval') ?>">
            </div>

            <div class="form-row">
              <label for="f_mechanism">Mechanizmus účinku</label>
              <textarea id="f_mechanism" name="mechanism" rows="2" maxlength="<?= DG_TEXT_MAXLEN ?>"><?= dgEditVal($editDrug, 'mechanism') ?></textarea>
            </div>
            <div class="form-row">
              <label for="f_indications">Indikácie (nefrologicky relevantné)</label>
              <textarea id="f_indications" name="indications" rows="2" maxlength="<?= DG_TEXT_MAXLEN ?>"><?= dgEditVal($editDrug, 'indications') ?></textarea>
            </div>
            <div class="form-row">
              <label for="f_renal">🫘 Dávkovanie podľa funkcie obličiek</label>
              <textarea id="f_renal" name="renal_dosing" rows="4" maxlength="<?= DG_TEXT_MAXLEN ?>" placeholder="Úprava dávky podľa eGFR / CrCl (z SPC)."><?= dgEditVal($editDrug, 'renal_dosing') ?></textarea>
            </div>
            <div class="form-row">
              <label for="f_nephrotox">Nefrotoxicita</label>
              <textarea id="f_nephrotox" name="nephrotoxicity" rows="2" maxlength="<?= DG_TEXT_MAXLEN ?>"><?= dgEditVal($editDrug, 'nephrotoxicity') ?></textarea>
            </div>
            <div class="form-row">
              <label for="f_dial">Dialyzovateľnosť</label>
              <textarea id="f_dial" name="dialyzability" rows="2" maxlength="<?= DG_TEXT_MAXLEN ?>"><?= dgEditVal($editDrug, 'dialyzability') ?></textarea>
            </div>
            <div class="form-row">
              <label for="f_warn">Upozornenia</label>
              <textarea id="f_warn" name="warnings" rows="2" maxlength="<?= DG_TEXT_MAXLEN ?>"><?= dgEditVal($editDrug, 'warnings') ?></textarea>
            </div>
            <div class="form-row">
              <label for="f_mon">Monitorovanie</label>
              <textarea id="f_mon" name="monitoring" rows="2" maxlength="<?= DG_TEXT_MAXLEN ?>"><?= dgEditVal($editDrug, 'monitoring') ?></textarea>
            </div>
            <div class="form-row">
              <label for="f_sknote">Slovenský kontext / poznámka</label>
              <textarea id="f_sknote" name="sk_note" rows="2" maxlength="<?= DG_TEXT_MAXLEN ?>"><?= dgEditVal($editDrug, 'sk_note') ?></textarea>
            </div>
            <div class="form-row">
              <label for="f_syn">Obchodné názvy (oddelené čiarkou)</label>
              <input type="text" id="f_syn" name="synonyms" maxlength="1000" value="<?= htmlspecialchars(dgSynonymsToText($editDrug['synonyms'] ?? null)) ?>" placeholder="Forxiga, Farxiga">
            </div>
            <div class="form-row">
              <label for="f_src">Zdroje (jeden na riadok: <code>názov|https://url</code>)</label>
              <textarea id="f_src" name="source_refs" rows="2" maxlength="2000" placeholder="SPC (EMA)|https://www.ema.europa.eu/..."><?= htmlspecialchars(dgSourcesToText($editDrug['source_refs'] ?? null)) ?></textarea>
            </div>

            <div class="form-row-inline">
              <label><input type="checkbox" name="black_box_warning" value="1" <?= (int) ($editDrug['black_box_warning'] ?? 0) === 1 ? 'checked' : '' ?>> ⚠ Black box warning</label>
              <label><input type="checkbox" name="withdrawn" value="1" <?= (int) ($editDrug['withdrawn'] ?? 0) === 1 ? 'checked' : '' ?>> Stiahnutý z trhu</label>
              <label><input type="checkbox" name="is_published" value="1" <?= (int) ($editDrug['is_published'] ?? 0) === 1 ? 'checked' : '' ?>> Zverejnený</label>
            </div>
          </div>

          <div class="form-actions admin-action-mt">
            <button type="submit" class="btn-primary"><?= $editDrug ? '💾 Uložiť zmeny' : '➕ Pridať liek' ?></button>
            <?php if ($editDrug): ?>
              <a href="admin_drugs.php" class="btn-secondary-small">Zrušiť editáciu</a>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <hr class="section-divider">

      <!-- ── ZOZNAM ──────────────────────────────────────────────────── -->
      <div class="primary-article">
        <h3>Lieky (<?= (int) $total ?>)</h3>
        <p class="helper-text">Zverejnené lieky bez renálneho dávkovania: <strong><?= (int) $missingDosing ?></strong>.</p>

        <form method="GET" action="admin_drugs.php" class="form-row-inline admin-filter-form">
          <label for="kat">Kategória:</label>
          <select id="kat" name="kat" class="form-control admin-select-md">
            <option value="">Všetky</option>
            <?php foreach ($catLabels as $slug => $label): ?>
              <option value="<?= htmlspecialchars($slug) ?>" <?= $fCat === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
          </select>
          <label for="pub">Stav:</label>
          <select id="pub" name="pub" class="form-control admin-select-sm">
            <option value="" <?= $fPub === '' ? 'selected' : '' ?>>Všetky</option>
            <option value="published" <?= $fPub === 'published' ? 'selected' : '' ?>>Zverejnené</option>
            <option value="hidden" <?= $fPub === 'hidden' ? 'selected' : '' ?>>Skryté</option>
          </select>
          <label for="q">Hľadať:</label>
          <input type="search" id="q" name="q" class="form-control admin-select-md" maxlength="100" value="<?= htmlspecialchars($fQuery) ?>" placeholder="názov, trieda, ATC">
          <button type="submit" class="btn-secondary-small">Filtrovať</button>
          <a href="admin_drugs.php" class="btn-secondary-small">Reset</a>
        </form>

        <?php if (empty($drugs)): ?>
          <p class="calc-result-mt12">Žiadne lieky pre zvolený filter. Pridajte liek vyššie alebo spustite synchronizáciu.</p>
        <?php else: ?>
          <div class="overflow-x-auto">
            <table class="admin-articles-table" aria-label="Zoznam liekov">
              <thead>
                <tr>
                  <th scope="col">Názov</th>
                  <th scope="col">Trieda / ATC</th>
                  <th scope="col">Kategória</th>
                  <th scope="col">Stav</th>
                  <th scope="col">Dávk.</th>
                  <th scope="col">Akcie</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($drugs as $d):
                    $dId = (int) $d['id'];
                    $dPub = (int) ($d['is_published'] ?? 0) === 1;
                    $hasDosing = trim((string) ($d['renal_dosing'] ?? '')) !== '';
                ?>
                <tr>
                  <td>
                    <a href="liek.php?slug=<?= urlencode((string) $d['slug']) ?>" target="_blank" rel="noopener"><?= htmlspecialchars((string) $d['name_sk']) ?></a>
                    <?php if (!empty($d['name_intl'])): ?><br><span class="calc-result-detail"><?= htmlspecialchars((string) $d['name_intl']) ?></span><?php endif; ?>
                  </td>
                  <td>
                    <?= htmlspecialchars((string) ($d['drug_class'] ?? '')) ?>
                    <?php if (!empty($d['atc_code'])): ?><br><span class="calc-result-detail"><?= htmlspecialchars((string) $d['atc_code']) ?></span><?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars(dgCategoryLabel((string) $d['category'])) ?></td>
                  <td><?= $dPub ? '<span class="badge-pub">Zverejnený</span>' : '<span class="badge-draft">Skrytý</span>' ?></td>
                  <td><?= $hasDosing ? '<span class="badge-top-sm" title="Má renálne dávkovanie">🫘</span>' : '<span class="calc-result-detail" title="Chýba renálne dávkovanie">—</span>' ?></td>
                  <td>
                    <a href="admin_drugs.php?action=edit&id=<?= $dId ?>" class="btn-secondary-small">✏️ Upraviť</a>
                    <form method="POST" action="admin_drugs.php" class="d-inline">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="action" value="toggle_publish">
                      <input type="hidden" name="drug_id" value="<?= $dId ?>">
                      <input type="hidden" name="set_pub" value="<?= $dPub ? 0 : 1 ?>">
                      <button type="submit" class="btn-secondary-small"><?= $dPub ? '🙈 Skryť' : '👁 Zverejniť' ?></button>
                    </form>
                    <form method="POST" action="admin_drugs.php" class="d-inline" data-confirm="Naozaj odstrániť tento liek?">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="drug_id" value="<?= $dId ?>">
                      <button type="submit" class="btn-secondary-small btn-danger-outline">🗑 Zmazať</button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

    </div><!-- /.auth-container -->
  </main>

  <?php include_once 'footer.php'; ?>

</body>
</html>
