<?php

declare(strict_types=1);
/**
 * admin_trials.php
 * Fáza 6 — kurátorská správa registra klinických štúdií (clinical_trials).
 *
 * Sync (`sync_clinical_trials.php`) napĺňa technické polia z ClinicalTrials.gov a
 * NEprepisuje ručné kurátorské polia: `sk_note` (slovenský kontext, zobrazený na
 * studia.php), `is_published` (viditeľnosť) a `category` (sync nastaví len pri prvom
 * vložení; admin override pretrváva). Tu ich admin upravuje.
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/clinical_trials_common.php';

requireAdmin();

const CT_SK_NOTE_MAXLEN = 8000;
const CT_ERR_INVALID_ID = 'Neplatné ID štúdie.';
const CT_ERR_NOT_FOUND  = 'Štúdia nenájdená.';

$actionResult = null; // plain text — escapuje sa pri výpise
$actionError  = null;
$editTrial    = null;

$catLabels = ctCategoryLabels();

// ── Spracovanie POST akcií ────────────────────────────────────────────────────
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!checkFormRateLimit($pdo, 'admin_post_' . basename(__FILE__), getClientIpAddress(), 60, 300)) {
        $actionError = 'Príliš veľa požiadaviek. Skúste to neskôr.';
    } elseif (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $actionError = 'Neplatný CSRF token.';
    } else {
        $action = (string) ($_POST['action'] ?? '');
        switch ($action) {
            // ── Uloženie kurátorských polí ──────────────────────────────────
            case 'save':
                $id       = (int) ($_POST['trial_id'] ?? 0);
                $category = (string) ($_POST['category'] ?? '');
                $isPub    = isset($_POST['is_published']) ? 1 : 0;
                $skNote   = trim((string) ($_POST['sk_note'] ?? ''));
                if (mb_strlen($skNote) > CT_SK_NOTE_MAXLEN) {
                    $skNote = mb_substr($skNote, 0, CT_SK_NOTE_MAXLEN);
                }
                if ($id <= 0) {
                    $actionError = CT_ERR_INVALID_ID;
                    break;
                }
                if (!array_key_exists($category, $catLabels)) {
                    $actionError = 'Neplatná kategória.';
                    break;
                }
                try {
                    $chk = $pdo->prepare('SELECT brief_title FROM clinical_trials WHERE id = :id LIMIT 1');
                    $chk->execute(['id' => $id]);
                    $row = $chk->fetch(\PDO::FETCH_ASSOC);
                    if ($row === false) {
                        $actionError = CT_ERR_NOT_FOUND;
                        break;
                    }
                    $upd = $pdo->prepare(
                        'UPDATE clinical_trials SET category = :cat, is_published = :pub, sk_note = :note WHERE id = :id'
                    );
                    $upd->execute([
                        'cat'  => $category,
                        'pub'  => $isPub,
                        'note' => $skNote !== '' ? $skNote : null,
                        'id'   => $id,
                    ]);
                    logAdminAction($pdo, 'trial_save', 'clinical_trial', $id, ['category' => $category, 'is_published' => $isPub]);
                    $actionResult = 'Štúdia „' . (string) $row['brief_title'] . '“ bola aktualizovaná.';
                } catch (\PDOException $e) {
                    error_log('admin_trials save error: ' . $e->getMessage());
                    $actionError = 'Chyba pri ukladaní štúdie.';
                }
                break;

            // ── Rýchle prepnutie viditeľnosti ──────────────────────────────
            case 'toggle_publish':
                $id     = (int) ($_POST['trial_id'] ?? 0);
                $setPub = (int) ($_POST['set_pub'] ?? -1);
                if ($id <= 0) {
                    $actionError = CT_ERR_INVALID_ID;
                    break;
                }
                if (!in_array($setPub, [0, 1], true)) {
                    $actionError = 'Neplatná hodnota viditeľnosti.';
                    break;
                }
                try {
                    $upd = $pdo->prepare('UPDATE clinical_trials SET is_published = :pub WHERE id = :id');
                    $upd->execute(['pub' => $setPub, 'id' => $id]);
                    logAdminAction($pdo, 'trial_toggle_publish', 'clinical_trial', $id, ['is_published' => $setPub]);
                    $actionResult = $setPub === 1
                        ? 'Štúdia bola zverejnená.'
                        : 'Štúdia bola skrytá z verejného registra.';
                } catch (\PDOException $e) {
                    error_log('admin_trials toggle error: ' . $e->getMessage());
                    $actionError = 'Chyba pri zmene viditeľnosti.';
                }
                break;

            default:
                $actionError = 'Neznáma akcia.';
                break;
        }
    }
}

// ── Načítanie štúdie na editáciu (GET) ────────────────────────────────────────
$editId = (int) ($_GET['id'] ?? 0);
if (($_GET['action'] ?? '') === 'edit' && $editId > 0) {
    try {
        $stmt = $pdo->prepare('SELECT * FROM clinical_trials WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $editId]);
        $editTrial = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    } catch (\PDOException $e) {
        error_log('admin_trials edit load error: ' . $e->getMessage());
    }
}

// ── Filtre + zoznam ───────────────────────────────────────────────────────────
$fCat = (string) ($_GET['kat'] ?? '');
if ($fCat !== '' && !array_key_exists($fCat, $catLabels)) {
    $fCat = '';
}
$fPub = (string) ($_GET['pub'] ?? ''); // '', 'published', 'hidden'
if (!in_array($fPub, ['', 'published', 'hidden'], true)) {
    $fPub = '';
}
$fQuery = trim((string) ($_GET['q'] ?? ''));
if (mb_strlen($fQuery) > 100) {
    $fQuery = mb_substr($fQuery, 0, 100);
}

$perPage = 50;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

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
    $where .= ' AND (brief_title LIKE :q ESCAPE \'!\' OR conditions LIKE :q ESCAPE \'!\' OR lead_sponsor LIKE :q ESCAPE \'!\' OR nct_id LIKE :q ESCAPE \'!\')';
    $params['q'] = likeSearchPattern($fQuery);
}

$trials = [];
$total = 0;
$totalPages = 1;
$lastSync = null;
try {
    $countStmt = $pdo->prepare('SELECT COUNT(*) FROM clinical_trials' . $where);
    $countStmt->execute($params);
    $total = (int) $countStmt->fetchColumn();
    $totalPages = max(1, (int) ceil($total / $perPage));

    $listStmt = $pdo->prepare(
        'SELECT id, nct_id, brief_title, overall_status, phase, category, is_published, sk_note,
                lead_sponsor, last_update_posted
         FROM clinical_trials' . $where . '
         ORDER BY last_update_posted DESC, id DESC
         LIMIT :limit OFFSET :offset'
    );
    foreach ($params as $k => $v) {
        $listStmt->bindValue(':' . $k, $v);
    }
    $listStmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
    $listStmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
    $listStmt->execute();
    $trials = $listStmt->fetchAll(\PDO::FETCH_ASSOC);

    $lastSync = ctLastSync($pdo);
} catch (\PDOException $e) {
    error_log('admin_trials list error: ' . $e->getMessage());
}

// Počet bez kurátorskej poznámky (informatívne).
$missingNotes = 0;
try {
    $missingNotes = (int) $pdo->query(
        "SELECT COUNT(*) FROM clinical_trials WHERE is_published = 1 AND (sk_note IS NULL OR sk_note = '')"
    )->fetchColumn();
} catch (\PDOException $e) {
    error_log('admin_trials missing-notes error: ' . $e->getMessage());
}

$csrfToken = generateCsrfToken();

/** Pomocník: zostaví query string pre stránkovacie odkazy so zachovaním filtrov. */
function ctAdminQs(array $extra = []): string
{
    global $fCat, $fPub, $fQuery;
    $qs = array_filter([
        'kat' => $fCat,
        'pub' => $fPub,
        'q'   => $fQuery,
    ], static fn ($v): bool => $v !== '');
    $qs = array_merge($qs, $extra);
    return $qs === [] ? '' : '?' . http_build_query($qs);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Správa klinických štúdií – Nefro-projekt Slovensko</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
  <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>"></script>
  <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
  <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
  <?php
  $headerTitle = 'Správa klinických štúdií';
  $headerIntro = 'Kurácia registra ClinicalTrials.gov';
  $showLogo = false;
    include_once 'header.php';
    include_once 'admin_menu.php';
  ?>

  <main id="main-content" class="container container--wide admin-page-main" role="main">
    <div class="auth-container auth-container--wide">
      <h2>Správa klinických štúdií</h2>
      <p class="auth-subtitle">
        Kurácia registra: viditeľnosť, kategória a slovenský kontext (poznámka). Technické údaje
        napĺňa synchronizácia z <a href="https://clinicaltrials.gov/" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>
        a tieto kurátorské polia neprepisuje.
        <?php if ($lastSync !== null): ?> Posledná synchronizácia: <strong><?= htmlspecialchars($lastSync) ?></strong>.<?php endif; ?>
      </p>

      <?php if ($actionResult !== null): ?>
        <div class="alert alert-success"><p><?= htmlspecialchars((string) $actionResult) ?></p></div>
      <?php endif; ?>
      <?php if ($actionError !== null): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($actionError) ?></p></div>
      <?php endif; ?>

      <?php if ($editTrial !== null): ?>
        <!-- ── EDITÁCIA KURÁTORSKÝCH POLÍ ───────────────────────────── -->
        <div class="primary-article">
          <h3>Upraviť štúdiu</h3>
          <p class="calc-result-detail">
            <abbr title="ClinicalTrials.gov identifikátor"><?= htmlspecialchars((string) $editTrial['nct_id']) ?></abbr>
            &ensp;&bull;&ensp; <?= htmlspecialchars(ctStatusLabel($editTrial['overall_status'] ?? null)) ?>
            &ensp;&bull;&ensp; <?= htmlspecialchars(ctPhaseLabel($editTrial['phase'] ?? null)) ?>
            &ensp;&bull;&ensp; <a href="<?= htmlspecialchars(ctSourceUrl((string) $editTrial['nct_id'])) ?>" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov ↗</a>
            &ensp;&bull;&ensp; <a href="studia.php?nct=<?= urlencode((string) $editTrial['nct_id']) ?>" target="_blank" rel="noopener">Verejný detail ↗</a>
          </p>
          <p><strong><?= htmlspecialchars((string) $editTrial['brief_title']) ?></strong></p>

          <form method="POST" action="admin_trials.php">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="trial_id" value="<?= (int) $editTrial['id'] ?>">

            <div class="article-form-grid">
              <div class="form-row">
                <label for="f_category">Kategória</label>
                <?php $editCat = (string) ($editTrial['category'] ?? 'other'); ?>
                <select id="f_category" name="category">
                  <?php foreach ($catLabels as $slug => $label): ?>
                    <option value="<?= htmlspecialchars($slug) ?>" <?= $editCat === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                  <?php endforeach; ?>
                </select>
                <span class="helper-text">Sync nastaví kategóriu len pri prvom vložení; tu uložená hodnota pretrváva aj po ďalších synchronizáciách.</span>
              </div>

              <div class="form-row">
                <label for="f_sk_note">Slovenský kontext / poznámka</label>
                <textarea id="f_sk_note" name="sk_note" rows="5" maxlength="<?= CT_SK_NOTE_MAXLEN ?>"
                          placeholder="Voliteľná slovenská poznámka zobrazená vo verejnom detaile štúdie (čistý text)."><?= htmlspecialchars((string) ($editTrial['sk_note'] ?? '')) ?></textarea>
                <span class="helper-text">Čistý text (riadkovanie zachované). Zobrazí sa návštevníkom v detaile štúdie ako „Slovenský kontext“.</span>
              </div>

              <div class="form-row-inline">
                <label>
                  <input type="checkbox" name="is_published" value="1" <?= (int) ($editTrial['is_published'] ?? 0) === 1 ? 'checked' : '' ?>>
                  Zverejnená (viditeľná vo verejnom registri)
                </label>
              </div>
            </div>

            <div class="form-actions admin-action-mt">
              <button type="submit" class="btn-primary">💾 Uložiť zmeny</button>
              <a href="admin_trials.php<?= ctAdminQs() ?>" class="btn-secondary-small">Zrušiť editáciu</a>
            </div>
          </form>
        </div>
        <hr class="section-divider">
      <?php endif; ?>

      <!-- ── FILTRE ──────────────────────────────────────────────────── -->
      <div class="primary-article">
        <h3>Štúdie (<?= (int) $total ?>)</h3>
        <p class="helper-text">Zverejnené štúdie bez slovenskej poznámky: <strong><?= (int) $missingNotes ?></strong>.</p>

        <form method="GET" action="admin_trials.php" class="form-row-inline admin-filter-form">
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
          <input type="search" id="q" name="q" class="form-control admin-select-md" maxlength="100"
                 value="<?= htmlspecialchars($fQuery) ?>" placeholder="názov, ochorenie, sponzor, NCT">

          <button type="submit" class="btn-secondary-small">Filtrovať</button>
          <a href="admin_trials.php" class="btn-secondary-small">Reset</a>
        </form>

        <?php if (empty($trials)): ?>
          <p class="calc-result-mt12">Pre zvolený filter sa nenašli žiadne štúdie.</p>
        <?php else: ?>
          <div class="overflow-x-auto">
            <table class="admin-articles-table" aria-label="Zoznam klinických štúdií">
              <thead>
                <tr>
                  <th scope="col">NCT</th>
                  <th scope="col">Názov</th>
                  <th scope="col">Kategória</th>
                  <th scope="col">Stav</th>
                  <th scope="col">SK</th>
                  <th scope="col">Akcie</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($trials as $t):
                    $tId    = (int) $t['id'];
                    $tNct   = (string) $t['nct_id'];
                    $tPub   = (int) ($t['is_published'] ?? 0) === 1;
                    $hasNote = trim((string) ($t['sk_note'] ?? '')) !== '';
                ?>
                <tr>
                  <td><a href="<?= htmlspecialchars(ctSourceUrl($tNct)) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($tNct) ?></a></td>
                  <td>
                    <a href="studia.php?nct=<?= urlencode($tNct) ?>" target="_blank" rel="noopener"><?= htmlspecialchars((string) $t['brief_title']) ?></a>
                    <?php if (!empty($t['lead_sponsor'])): ?><br><span class="calc-result-detail"><?= htmlspecialchars((string) $t['lead_sponsor']) ?></span><?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars(ctCategoryLabel((string) $t['category'])) ?></td>
                  <td>
                    <?php if ($tPub): ?>
                      <span class="badge-pub">Zverejnená</span>
                    <?php else: ?>
                      <span class="badge-draft">Skrytá</span>
                    <?php endif; ?>
                  </td>
                  <td><?= $hasNote ? '<span class="badge-top-sm" title="Má slovenskú poznámku">SK</span>' : '<span class="calc-result-detail">—</span>' ?></td>
                  <td>
                    <a href="admin_trials.php?action=edit&id=<?= $tId ?>" class="btn-secondary-small">✏️ Upraviť</a>
                    <form method="POST" action="admin_trials.php" class="d-inline">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="action" value="toggle_publish">
                      <input type="hidden" name="trial_id" value="<?= $tId ?>">
                      <input type="hidden" name="set_pub" value="<?= $tPub ? 0 : 1 ?>">
                      <button type="submit" class="btn-secondary-small" title="<?= $tPub ? 'Skryť z verejného registra' : 'Zverejniť' ?>"><?= $tPub ? '🙈 Skryť' : '👁 Zverejniť' ?></button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <?php if ($totalPages > 1): ?>
            <nav class="articles-pagination admin-pagination" aria-label="Stránkovanie štúdií">
              <span class="articles-pagination__label">Stránky:</span>
              <div class="articles-pagination__links">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                  <?php if ($p === $page): ?>
                    <span class="articles-page-link is-active" aria-current="page"><?= $p ?></span>
                  <?php else: ?>
                    <a class="articles-page-link" href="admin_trials.php<?= ctAdminQs(['page' => $p]) ?>" aria-label="Strana <?= $p ?>"><?= $p ?></a>
                  <?php endif; ?>
                <?php endfor; ?>
              </div>
            </nav>
          <?php endif; ?>
        <?php endif; ?>
      </div>

    </div><!-- /.auth-container -->
  </main>

  <?php include_once 'footer.php'; ?>

</body>
</html>
