<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

requireAdmin();

$actionResult = null;
$actionError  = null;

// ── Stránkovanie a filtre ─────────────────────────────────────────────────────
$perPage     = 50;
$currentPage = max(1, (int) ($_GET['page'] ?? 1));
// $offset sa vypočíta definitívne až po orezaní $currentPage na $totalPages

$allowedFilters = ['all', 'visible', 'hidden', 'deleted', 'pinned'];
$filter = strtolower(trim((string) ($_GET['filter'] ?? 'all')));
if (!in_array($filter, $allowedFilters, true)) {
    $filter = 'all';
}

// ── Spracovanie POST akcií ────────────────────────────────────────────────────
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $postedCsrf = (string) ($_POST['csrf_token'] ?? '');
    if (!checkFormRateLimit($pdo, 'admin_post_' . basename(__FILE__), getClientIpAddress(), 60, 300)) {
        $actionError = 'Príliš veľa požiadaviek. Skúste to neskôr.';
    } elseif (!validateCsrfToken($postedCsrf)) {
        $actionError = 'Neplatný CSRF token.';
    } else {
        $action = (string) ($_POST['action'] ?? '');
        $postId = (int) ($_POST['post_id'] ?? 0);

        if ($postId <= 0) {
            $actionError = 'Neplatné ID príspevku.';
        } else {
            requireAdminReauth();
            try {
                switch ($action) {
                    case 'delete':
                        $pdo->prepare("UPDATE discussion_posts SET is_deleted = 1 WHERE id = :id")
                            ->execute(['id' => $postId]);
                        logAdminAction($pdo, 'discussion_delete', 'discussion_post', $postId, []);
                        $actionResult = 'Príspevok bol vymazaný (soft-delete).';
                        break;

                    case 'undelete':
                        $pdo->prepare("UPDATE discussion_posts SET is_deleted = 0 WHERE id = :id")
                            ->execute(['id' => $postId]);
                        logAdminAction($pdo, 'discussion_undelete', 'discussion_post', $postId, []);
                        $actionResult = 'Príspevok bol obnovený.';
                        break;

                    case 'hide':
                        $pdo->prepare("UPDATE discussion_posts SET is_hidden = 1 WHERE id = :id")
                            ->execute(['id' => $postId]);
                        logAdminAction($pdo, 'discussion_hide', 'discussion_post', $postId, []);
                        $actionResult = 'Príspevok bol skrytý pred verejnosťou.';
                        break;

                    case 'unhide':
                        $pdo->prepare("UPDATE discussion_posts SET is_hidden = 0, moderation_note = NULL WHERE id = :id")
                            ->execute(['id' => $postId]);
                        logAdminAction($pdo, 'discussion_unhide', 'discussion_post', $postId, []);
                        $actionResult = 'Príspevok je opäť viditeľný.';
                        break;

                    case 'pin':
                        // Pin len pre top-level príspevky
                        $pdo->prepare("UPDATE discussion_posts SET is_pinned = 1 WHERE id = :id AND parent_id IS NULL")
                            ->execute(['id' => $postId]);
                        logAdminAction($pdo, 'discussion_pin', 'discussion_post', $postId, []);
                        $actionResult = 'Príspevok bol pripnutý na vrch diskusie.';
                        break;

                    case 'unpin':
                        $pdo->prepare("UPDATE discussion_posts SET is_pinned = 0 WHERE id = :id")
                            ->execute(['id' => $postId]);
                        logAdminAction($pdo, 'discussion_unpin', 'discussion_post', $postId, []);
                        $actionResult = 'Príspevok bol odopnutý.';
                        break;

                    case 'set_note':
                        $note = trim(mb_substr((string) ($_POST['moderation_note'] ?? ''), 0, 500));
                        $pdo->prepare("UPDATE discussion_posts SET moderation_note = :note WHERE id = :id")
                            ->execute(['id' => $postId, 'note' => $note !== '' ? $note : null]);
                        logAdminAction($pdo, 'discussion_set_note', 'discussion_post', $postId, ['note_length' => mb_strlen($note)]);
                        $actionResult = 'Moderátorská poznámka bola uložená.';
                        break;

                    default:
                        $actionError = 'Neznáma akcia.';
                }
            } catch (\PDOException $e) {
                error_log('admin_discussion action error: ' . $e->getMessage());
                $actionError = 'Databázová chyba pri akcii.';
            }
        }
    }
}

// ── Zostavenie WHERE podmienky podľa filtra ───────────────────────────────────
$whereClause = match ($filter) {
    'visible'  => 'dp.is_deleted = 0 AND dp.is_hidden = 0',
    'hidden'   => 'dp.is_deleted = 0 AND dp.is_hidden = 1',
    'deleted'  => 'dp.is_deleted = 1',
    'pinned'   => 'dp.is_deleted = 0 AND dp.is_pinned = 1',
    default    => '1=1',
};

// ── Načítanie príspevkov ──────────────────────────────────────────────────────
$posts = [];
$totalPosts = 0;
$totalPages = 1;

try {
    $countStmt = $pdo->query(
        "SELECT COUNT(*) FROM discussion_posts dp WHERE $whereClause"
    );
    $totalPosts = (int) $countStmt->fetchColumn();
    $totalPages  = max(1, (int) ceil($totalPosts / $perPage));
    $currentPage = min($currentPage, $totalPages);
    $offset      = ($currentPage - 1) * $perPage;

    $stmt = $pdo->prepare(
        "SELECT dp.id, dp.parent_id, dp.content, dp.created_at, dp.updated_at,
                dp.is_deleted, dp.is_hidden, dp.is_pinned, dp.moderation_note,
                dp.user_id,
                TRIM(CONCAT_WS(' ',
                    NULLIF(TRIM(u.title_before), ''),
                    NULLIF(TRIM(u.first_name), ''),
                    NULLIF(TRIM(u.last_name), ''),
                    NULLIF(TRIM(u.title_after), '')
                )) AS display_name,
                u.username
         FROM discussion_posts dp
         JOIN users u ON dp.user_id = u.id
         WHERE $whereClause
         ORDER BY dp.created_at DESC
         LIMIT :limit OFFSET :offset"
    );
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    error_log('admin_discussion list error: ' . $e->getMessage());
    $actionError = trim(($actionError ?? '') . ' Chyba pri načítaní príspevkov.');
}

// ── Súhrnné štatistiky ────────────────────────────────────────────────────────
$stats = ['all' => 0, 'visible' => 0, 'hidden' => 0, 'deleted' => 0, 'pinned' => 0];
try {
    $sStmt = $pdo->query(
        "SELECT
            COUNT(*) AS all_count,
            SUM(CASE WHEN is_deleted = 0 AND is_hidden = 0 THEN 1 ELSE 0 END) AS visible_count,
            SUM(CASE WHEN is_deleted = 0 AND is_hidden = 1 THEN 1 ELSE 0 END) AS hidden_count,
            SUM(CASE WHEN is_deleted = 1                  THEN 1 ELSE 0 END) AS deleted_count,
            SUM(CASE WHEN is_deleted = 0 AND is_pinned = 1 THEN 1 ELSE 0 END) AS pinned_count
         FROM discussion_posts"
    );
    $sRow = $sStmt->fetch(PDO::FETCH_ASSOC);
    $stats = [
        'all'     => (int) ($sRow['all_count'] ?? 0),
        'visible' => (int) ($sRow['visible_count'] ?? 0),
        'hidden'  => (int) ($sRow['hidden_count'] ?? 0),
        'deleted' => (int) ($sRow['deleted_count'] ?? 0),
        'pinned'  => (int) ($sRow['pinned_count'] ?? 0),
    ];
} catch (\PDOException $e) {
    error_log('admin_discussion stats error: ' . $e->getMessage());
}

$csrfToken = generateCsrfToken();

// ── Pomocná funkcia — skrátenie textu ─────────────────────────────────────────
if (!function_exists('truncatePost')) {
    function truncatePost(string $text, int $max = 200): string
    {
        $text = trim($text);
        if (mb_strlen($text) <= $max) {
            return $text;
        }
        return mb_substr($text, 0, $max) . '…';
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Moderovanie diskusie – Nefro-projekt Slovensko</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
  <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>"></script>
  <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
  <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
<a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
<?php
$headerTitle = 'Moderovanie diskusie';
$headerIntro = 'Správa príspevkov — skrytie, mazanie, pin';
$showLogo = false;
include 'header.php';
include 'admin_menu.php';
?>

<main id="main-content" class="container container--wide admin-page-main" role="main">
  <div class="auth-container auth-container--wide">
    <h2>Moderovanie diskusie</h2>
    <p class="auth-subtitle">Prehľad a správa príspevkov diskusie.</p>

    <?php if ($actionResult !== null): ?>
      <div class="alert alert-success"><p><?= htmlspecialchars($actionResult) ?></p></div>
    <?php endif; ?>
    <?php if ($actionError !== null): ?>
      <div class="alert alert-error"><p><?= htmlspecialchars($actionError) ?></p></div>
    <?php endif; ?>

    <!-- ── ŠTATISTIKY ────────────────────────────────────────────────── -->
    <div class="form-row-inline admin-tag-section mb-16">
      <a href="admin_discussion.php?filter=all"     class="badge-pub   <?= $filter === 'all'     ? 'badge-active' : '' ?>">Všetky: <?= $stats['all'] ?></a>
      <a href="admin_discussion.php?filter=visible" class="badge-pub   <?= $filter === 'visible' ? 'badge-active' : '' ?>">Viditeľné: <?= $stats['visible'] ?></a>
      <a href="admin_discussion.php?filter=hidden"  class="badge-draft <?= $filter === 'hidden'  ? 'badge-active' : '' ?>">Skryté: <?= $stats['hidden'] ?></a>
      <a href="admin_discussion.php?filter=deleted" class="badge-draft <?= $filter === 'deleted' ? 'badge-active' : '' ?>">Vymazané: <?= $stats['deleted'] ?></a>
      <a href="admin_discussion.php?filter=pinned"  class="badge-top-sm <?= $filter === 'pinned' ? 'badge-active' : '' ?>">Pripnuté: <?= $stats['pinned'] ?></a>
    </div>

    <!-- ── TABUĽKA PRÍSPEVKOV ─────────────────────────────────────────── -->
    <?php if (empty($posts)): ?>
      <p class="calc-result-mt12">Žiadne príspevky pre zvolený filter.</p>
    <?php else: ?>
    <div class="admin-table-overflow">
      <table class="admin-articles-table" aria-label="Príspevky diskusie">
        <thead>
          <tr>
            <th scope="col" class="disc-col-id">#</th>
            <th scope="col" class="disc-col-author">Autor</th>
            <th scope="col">Obsah</th>
            <th scope="col" class="disc-col-date">Dátum</th>
            <th scope="col" class="disc-col-status">Stav</th>
            <th scope="col" class="disc-col-actions">Akcie</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($posts as $p):
            $pid      = (int) $p['id'];
            $isTop    = $p['parent_id'] === null;
            $deleted  = (int) $p['is_deleted'] === 1;
            $hidden   = (int) $p['is_hidden'] === 1;
            $pinned   = (int) $p['is_pinned'] === 1;
            $note     = (string) ($p['moderation_note'] ?? '');
            $author   = trim((string) $p['display_name']) ?: (string) $p['username'];
            $content  = htmlspecialchars(truncatePost((string) $p['content']));
            $date     = substr((string) $p['created_at'], 0, 10);
          ?>
          <tr<?= $deleted ? ' class="row-deleted"' : '' ?>>
            <td>
              <?= $pid ?>
              <?php if (!$isTop): ?>
                <br><span class="helper-text" title="Odpoveď na príspevok #<?= (int) $p['parent_id'] ?>">↳ #<?= (int) $p['parent_id'] ?></span>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($author) ?></td>
            <td>
              <?= $content ?>
              <?php if ($note !== ''): ?>
                <br><em class="helper-text">📝 <?= htmlspecialchars($note) ?></em>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($date) ?></td>
            <td>
              <?php if ($deleted): ?>
                <span class="badge-draft">Vymazaný</span>
              <?php elseif ($hidden): ?>
                <span class="badge-draft">Skrytý</span>
              <?php else: ?>
                <span class="badge-pub">Viditeľný</span>
              <?php endif; ?>
              <?php if ($pinned && !$deleted): ?>
                <br><span class="badge-top-sm">📌 Pin</span>
              <?php endif; ?>
            </td>
            <td>
              <div class="flex-wrap-gap4">

              <?php if (!$deleted): ?>
                <?php if (!$hidden): ?>
                  <!-- Skryť -->
                  <form method="POST" action="admin_discussion.php?filter=<?= htmlspecialchars($filter) ?>&page=<?= $currentPage ?>" class="d-inline">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    <input type="hidden" name="action"  value="hide">
                    <input type="hidden" name="post_id" value="<?= $pid ?>">
                    <button type="submit" class="btn-secondary-small" title="Skryť pred verejnosťou">🙈 Skryť</button>
                  </form>
                <?php else: ?>
                  <!-- Zobraziť -->
                  <form method="POST" action="admin_discussion.php?filter=<?= htmlspecialchars($filter) ?>&page=<?= $currentPage ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    <input type="hidden" name="action"  value="unhide">
                    <input type="hidden" name="post_id" value="<?= $pid ?>">
                    <button type="submit" class="btn-secondary-small">👁 Zobraziť</button>
                  </form>
                <?php endif; ?>

                <?php if ($isTop): ?>
                  <?php if (!$pinned): ?>
                    <!-- Pin -->
                    <form method="POST" action="admin_discussion.php?filter=<?= htmlspecialchars($filter) ?>&page=<?= $currentPage ?>">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="action"  value="pin">
                      <input type="hidden" name="post_id" value="<?= $pid ?>">
                      <button type="submit" class="btn-secondary-small" title="Pripnúť na vrch diskusie">📌 Pin</button>
                    </form>
                  <?php else: ?>
                    <!-- Odopnúť -->
                    <form method="POST" action="admin_discussion.php?filter=<?= htmlspecialchars($filter) ?>&page=<?= $currentPage ?>">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="action"  value="unpin">
                      <input type="hidden" name="post_id" value="<?= $pid ?>">
                      <button type="submit" class="btn-secondary-small">📌 Odopnúť</button>
                    </form>
                  <?php endif; ?>
                <?php endif; ?>

                <!-- Vymazať -->
                <form method="POST" action="admin_discussion.php?filter=<?= htmlspecialchars($filter) ?>&page=<?= $currentPage ?>"
                      data-confirm="Naozaj chcete vymazať tento príspevok?">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                  <input type="hidden" name="action"  value="delete">
                  <input type="hidden" name="post_id" value="<?= $pid ?>">
                  <button type="submit" class="btn-secondary-small btn-danger-outline">🗑 Zmazať</button>
                </form>

              <?php else: ?>
                <!-- Obnoviť (undelete) -->
                <form method="POST" action="admin_discussion.php?filter=<?= htmlspecialchars($filter) ?>&page=<?= $currentPage ?>">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                  <input type="hidden" name="action"  value="undelete">
                  <input type="hidden" name="post_id" value="<?= $pid ?>">
                  <button type="submit" class="btn-secondary-small">↩ Obnoviť</button>
                </form>
              <?php endif; ?>

              <!-- Poznámka -->
              <details class="w-100">
                <summary class="btn-secondary-small summary-reset">📝 Poznámka</summary>
                <form method="POST" action="admin_discussion.php?filter=<?= htmlspecialchars($filter) ?>&page=<?= $currentPage ?>" class="mt-6">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                  <input type="hidden" name="action"  value="set_note">
                  <input type="hidden" name="post_id" value="<?= $pid ?>">
                  <textarea name="moderation_note" rows="2" maxlength="500"
                            class="admin-note-textarea"
                            placeholder="Interná poznámka (max 500 znakov)…"><?= htmlspecialchars($note) ?></textarea>
                  <button type="submit" class="btn-secondary-small mt-4">Uložiť</button>
                </form>
              </details>

              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- ── STRÁNKOVANIE ───────────────────────────────────────────────── -->
    <?php if ($totalPages > 1): ?>
    <nav class="articles-pagination admin-pagination" aria-label="Stránkovanie diskusie">
      <span class="articles-pagination__label">Stránky:</span>
      <div class="articles-pagination__links">
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
          <?php if ($p === $currentPage): ?>
            <span class="articles-page-link is-active" aria-current="page"><?= $p ?></span>
          <?php else: ?>
            <a class="articles-page-link" href="admin_discussion.php?filter=<?= htmlspecialchars($filter) ?>&page=<?= $p ?>"><?= $p ?></a>
          <?php endif; ?>
        <?php endfor; ?>
      </div>
    </nav>
    <?php endif; ?>

    <p class="helper-text mt-8">Celkom: <?= $totalPosts ?> príspevkov v tomto filtri.</p>

    <?php endif; ?>

  </div><!-- /.auth-container -->
</main>

<?php include 'footer.php'; ?>
</body>
</html>
