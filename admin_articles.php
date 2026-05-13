<?php
require_once 'auth.php';
require_once 'db_config.php';

requireAdmin();

$currentAdminId = (int) ($_SESSION['user_id'] ?? 0);
$actionResult   = null;
$actionError    = null;
$editArticle    = null;

// ── Pomocné funkcie ───────────────────────────────────────────────────────────

/**
 * Generuje URL-friendly slug z titulku článku.
 * Translit. diakritiky, malé písmená, pomlčky namiesto medzier a spec. znakov.
 */
function generateSlug(string $title): string {
    $map = [
        'á'=>'a','ä'=>'a','č'=>'c','ď'=>'d','é'=>'e','í'=>'i','ĺ'=>'l','ľ'=>'l',
        'ň'=>'n','ó'=>'o','ô'=>'o','ŕ'=>'r','š'=>'s','ť'=>'t','ú'=>'u','ý'=>'y','ž'=>'z',
        'Á'=>'a','Ä'=>'a','Č'=>'c','Ď'=>'d','É'=>'e','Í'=>'i','Ĺ'=>'l','Ľ'=>'l',
        'Ň'=>'n','Ó'=>'o','Ô'=>'o','Ŕ'=>'r','Š'=>'s','Ť'=>'t','Ú'=>'u','Ý'=>'y','Ž'=>'z',
    ];
    $title = strtr($title, $map);
    $title = strtolower($title);
    $title = preg_replace('/[^a-z0-9]+/', '-', $title) ?? '';
    $title = trim($title, '-');
    return mb_substr($title, 0, 200);
}

/**
 * Zabezpečí unikátnosť slugu v DB.
 * Ak slug existuje, pripojí -2, -3, atď.
 */
function uniqueSlug(PDO $pdo, string $slug, int $excludeId = 0): string {
    $base  = $slug;
    $n     = 2;
    while (true) {
        $stmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug AND id != :id LIMIT 1");
        $stmt->execute(['slug' => $slug, 'id' => $excludeId]);
        if ($stmt->fetch() === false) {
            return $slug;
        }
        $slug = $base . '-' . $n;
        $n++;
    }
}

$csrfToken = generateCsrfToken();

// ── Spracovanie POST akcií ────────────────────────────────────────────────────
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $postedCsrf = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($postedCsrf)) {
        $actionError = 'Neplatný CSRF token.';
    } else {
        $action = $_POST['action'] ?? '';

        switch ($action) {
            // ── CREATE ──────────────────────────────────────────────────────
            case 'create':
                $title      = trim((string) ($_POST['title'] ?? ''));
                $slug       = trim((string) ($_POST['slug'] ?? ''));
                $author     = trim((string) ($_POST['author'] ?? 'Dr. Ľubomír Polaščín'));
                $content    = trim((string) ($_POST['content'] ?? ''));
                $excerpt    = trim((string) ($_POST['excerpt'] ?? ''));
                $pubAt      = trim((string) ($_POST['published_at'] ?? ''));
                $isTop      = isset($_POST['is_top']) ? 1 : 0;
                $isPub      = isset($_POST['is_published']) ? 1 : 0;

                if ($title === '') { $actionError = 'Titulok je povinný.'; break; }
                if ($content === '') { $actionError = 'Obsah článku je povinný.'; break; }
                if ($excerpt === '') { $actionError = 'Perex (excerpt) je povinný.'; break; }
                if ($pubAt === '' || !preg_match('/^\d{4}-\d{2}-\d{2}/', $pubAt)) {
                    $actionError = 'Dátum publikácie je neplatný.'; break;
                }
                // Automatický slug ak prázdny
                if ($slug === '') { $slug = generateSlug($title); }
                $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug)) ?? '';
                $slug = uniqueSlug($pdo, $slug);

                try {
                    $stmt = $pdo->prepare(
                        "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
                         VALUES (:title,:slug,:author,:content,:excerpt,:published_at,:is_top,:is_published)"
                    );
                    $stmt->execute([
                        'title'        => $title,
                        'slug'         => $slug,
                        'author'       => $author !== '' ? $author : 'Dr. Ľubomír Polaščín',
                        'content'      => $content,
                        'excerpt'      => $excerpt,
                        'published_at' => $pubAt,
                        'is_top'       => $isTop,
                        'is_published' => $isPub,
                    ]);
                    $newId        = (int) $pdo->lastInsertId();
                    $actionResult = 'Článok bol úspešne vytvorený. <a href="article.php?id=' . $newId . '" target="_blank">Zobraziť →</a>';
                } catch (\PDOException $e) {
                    error_log('admin_articles create error: ' . $e->getMessage());
                    $actionError = 'Chyba pri ukladaní článku.';
                }
                break;

            // ── UPDATE ──────────────────────────────────────────────────────
            case 'update':
                $id         = (int) ($_POST['article_id'] ?? 0);
                $title      = trim((string) ($_POST['title'] ?? ''));
                $slug       = trim((string) ($_POST['slug'] ?? ''));
                $author     = trim((string) ($_POST['author'] ?? ''));
                $content    = trim((string) ($_POST['content'] ?? ''));
                $excerpt    = trim((string) ($_POST['excerpt'] ?? ''));
                $pubAt      = trim((string) ($_POST['published_at'] ?? ''));
                $isTop      = isset($_POST['is_top']) ? 1 : 0;
                $isPub      = isset($_POST['is_published']) ? 1 : 0;

                if ($id <= 0)     { $actionError = 'Neplatné ID článku.'; break; }
                if ($title === '') { $actionError = 'Titulok je povinný.'; break; }
                if ($content === '') { $actionError = 'Obsah článku je povinný.'; break; }
                if ($excerpt === '') { $actionError = 'Perex (excerpt) je povinný.'; break; }
                if ($pubAt === '' || !preg_match('/^\d{4}-\d{2}-\d{2}/', $pubAt)) {
                    $actionError = 'Dátum publikácie je neplatný.'; break;
                }

                if ($slug === '') { $slug = generateSlug($title); }
                $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug)) ?? '';
                $slug = uniqueSlug($pdo, $slug, $id);

                try {
                    $stmt = $pdo->prepare(
                        "UPDATE articles SET title=:title, slug=:slug, author=:author, content=:content,
                         excerpt=:excerpt, published_at=:published_at, is_top=:is_top, is_published=:is_published
                         WHERE id=:id"
                    );
                    $stmt->execute([
                        'title'        => $title,
                        'slug'         => $slug,
                        'author'       => $author !== '' ? $author : 'Dr. Ľubomír Polaščín',
                        'content'      => $content,
                        'excerpt'      => $excerpt,
                        'published_at' => $pubAt,
                        'is_top'       => $isTop,
                        'is_published' => $isPub,
                        'id'           => $id,
                    ]);
                    $actionResult = 'Článok bol úspešne aktualizovaný. <a href="article.php?id=' . $id . '" target="_blank">Zobraziť →</a>';
                } catch (\PDOException $e) {
                    error_log('admin_articles update error: ' . $e->getMessage());
                    $actionError = 'Chyba pri aktualizácii článku.';
                }
                break;

            // ── DELETE ──────────────────────────────────────────────────────
            case 'delete':
                $id = (int) ($_POST['article_id'] ?? 0);
                if ($id <= 0) { $actionError = 'Neplatné ID článku.'; break; }
                try {
                    $chk = $pdo->prepare("SELECT title FROM articles WHERE id = :id LIMIT 1");
                    $chk->execute(['id' => $id]);
                    $row = $chk->fetch();
                    if (!$row) { $actionError = 'Článok nenájdený.'; break; }
                    $pdo->prepare("DELETE FROM articles WHERE id = :id")->execute(['id' => $id]);
                    $actionResult = 'Článok „' . htmlspecialchars((string) $row['title']) . '" bol odstránený.';
                } catch (\PDOException $e) {
                    error_log('admin_articles delete error: ' . $e->getMessage());
                    $actionError = 'Chyba pri mazaní článku.';
                }
                break;
        }
    }
}

// ── Načítanie článku na editáciu (GET) ────────────────────────────────────────
$editId = (int) ($_GET['id'] ?? 0);
if (($_GET['action'] ?? '') === 'edit' && $editId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $editId]);
        $editArticle = $stmt->fetch() ?: null;
    } catch (\PDOException $e) {
        error_log('admin_articles edit load error: ' . $e->getMessage());
    }
}

// ── Načítanie všetkých článkov pre zoznam ────────────────────────────────────
$articles = [];
try {
    $articles = $pdo->query(
        "SELECT id, title, slug, author, published_at, is_top, is_published, created_at
         FROM articles ORDER BY published_at DESC, id DESC"
    )->fetchAll();
} catch (\PDOException $e) {
    error_log('admin_articles list error: ' . $e->getMessage());
}

$pageLastUpdated = date('d.m.Y H:i', filemtime(__FILE__));
$pageTimeZone    = date('T') . ' (' . date_default_timezone_get() . ')';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Správa článkov – Nefro-projekt Slovensko</title>
  <meta name="robots" content="noindex, nofollow">
  <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
  <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
  <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
  <style>
    .admin-articles-table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 0.9rem; }
    .admin-articles-table th, .admin-articles-table td { padding: 10px 12px; border-bottom: 1px solid var(--border-color); text-align: left; vertical-align: top; }
    .admin-articles-table th { font-weight: 600; color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .admin-articles-table tr:hover td { background: rgba(59,130,246,0.04); }
    .article-form-grid { display: grid; gap: 18px; }
    .form-row { display: flex; flex-direction: column; gap: 5px; }
    .form-row label { font-weight: 600; font-size: 0.88rem; color: var(--text-secondary); }
    .form-row input[type="text"], .form-row input[type="date"],
    .form-row textarea, .form-row select {
      width: 100%; padding: 10px 12px; border: 1px solid var(--border-color);
      border-radius: 8px; background: var(--bg-color); color: var(--text-primary);
      font-family: inherit; font-size: 0.95rem; transition: border-color 0.2s;
    }
    .form-row textarea { min-height: 420px; font-family: 'Courier New', monospace; font-size: 0.85rem; resize: vertical; }
    .form-row input:focus, .form-row textarea:focus { outline: none; border-color: var(--primary-color); }
    .form-row-inline { display: flex; gap: 20px; flex-wrap: wrap; align-items: center; }
    .form-row-inline label { display: flex; align-items: center; gap: 6px; font-weight: 500; cursor: pointer; }
    .form-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 8px; }
    .badge-pub   { background:#d1fae5;color:#065f46; padding:2px 8px;border-radius:10px;font-size:0.75rem;font-weight:600; }
    .badge-draft { background:#fef3c7;color:#92400e; padding:2px 8px;border-radius:10px;font-size:0.75rem;font-weight:600; }
    .badge-top-sm { background: var(--primary-gradient);color:#fff; padding:2px 8px;border-radius:10px;font-size:0.75rem;font-weight:600; }
    .section-divider { border: none; border-top: 2px solid var(--border-color); margin: 36px 0; }
    .helper-text { font-size: 0.8rem; color: var(--text-secondary); margin-top: 3px; }
    @media(max-width:600px){.admin-articles-table th:nth-child(3),.admin-articles-table td:nth-child(3){display:none;}}
  </style>
</head>
<body>
  <?php
  $headerTitle = 'Správa článkov';
  $headerIntro = 'CRUD rozhranie pre správu článkov';
  $showLogo    = false;
  include 'header.php';
  ?>

  <nav class="main-nav" aria-label="Hlavná navigácia">
    <div class="container">
      <ul>
        <li><a href="index.php">Domov</a></li>
        <li><a href="admin.php">Admin panel</a></li>
        <li><a href="admin_articles.php" class="active" aria-current="page">Správa článkov</a></li>
        <li><a href="logout.php">Odhlásiť sa (<?= htmlspecialchars($_SESSION['username'] ?? '') ?>)</a></li>
      </ul>
    </div>
  </nav>

  <main class="container" style="padding-top:40px;padding-bottom:60px;">
    <div class="auth-container auth-container--wide">
      <h2>Správa článkov</h2>
      <p class="auth-subtitle">Pridávanie, úprava a mazanie článkov na hlavnej stránke.</p>

      <?php if ($actionResult !== null): ?>
        <div class="alert alert-success"><p><?= $actionResult /* contains safe HTML (links) */ ?></p></div>
      <?php endif; ?>
      <?php if ($actionError !== null): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($actionError) ?></p></div>
      <?php endif; ?>

      <!-- ── FORMULÁR (pridanie / editácia) ─────────────────────────── -->
      <div class="primary-article">
        <h3><?= $editArticle ? 'Upraviť článok' : 'Pridať nový článok' ?></h3>

        <form method="POST" action="admin_articles.php" id="articleForm">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <input type="hidden" name="action"     value="<?= $editArticle ? 'update' : 'create' ?>">
          <?php if ($editArticle): ?>
            <input type="hidden" name="article_id" value="<?= (int) $editArticle['id'] ?>">
          <?php endif; ?>

          <div class="article-form-grid">
            <div class="form-row">
              <label for="f_title">Titulok článku <span style="color:red">*</span></label>
              <input type="text" id="f_title" name="title" required maxlength="500"
                     value="<?= htmlspecialchars((string) ($editArticle['title'] ?? '')) ?>"
                     placeholder="Titulok článku">
            </div>

            <div class="form-row">
              <label for="f_slug">Slug (URL identifikátor)</label>
              <input type="text" id="f_slug" name="slug" maxlength="500"
                     value="<?= htmlspecialchars((string) ($editArticle['slug'] ?? '')) ?>"
                     placeholder="napr. moj-clanok-o-nefrologii (nechajte prázdne pre automatické generovanie)">
              <span class="helper-text">Používajte len malé písmená, číslice a pomlčky. Ak necháte prázdne, slug sa vygeneruje automaticky z titulku.</span>
            </div>

            <div class="form-row">
              <label for="f_author">Autor</label>
              <input type="text" id="f_author" name="author" maxlength="255"
                     value="<?= htmlspecialchars((string) ($editArticle['author'] ?? 'Dr. Ľubomír Polaščín')) ?>">
            </div>

            <div class="form-row">
              <label for="f_excerpt">Perex / excerpt <span style="color:red">*</span></label>
              <textarea id="f_excerpt" name="excerpt" required rows="3"
                        placeholder="Krátky úvodný text zobrazovaný v zozname článkov (čistý text, bez HTML)"><?= htmlspecialchars((string) ($editArticle['excerpt'] ?? '')) ?></textarea>
              <span class="helper-text">Čistý text, bez HTML tagov. Zobrazí sa ako úryvok v zozname článkov na hlavnej stránke.</span>
            </div>

            <div class="form-row">
              <label for="f_content">Obsah článku (HTML) <span style="color:red">*</span></label>
              <textarea id="f_content" name="content" required
                        placeholder="Plný HTML obsah článku (odseky, h3 nadpisy, zoznamy atď.)"><?= htmlspecialchars((string) ($editArticle['content'] ?? '')) ?></textarea>
              <span class="helper-text">Zadajte HTML obsah článku bez obaľujúcich tagov &lt;article&gt;, &lt;header&gt; a &lt;footer&gt;. Tieto sa generujú automaticky.</span>
            </div>

            <div class="form-row">
              <label for="f_published_at">Dátum publikácie <span style="color:red">*</span></label>
              <input type="date" id="f_published_at" name="published_at" required
                     value="<?= htmlspecialchars(substr((string) ($editArticle['published_at'] ?? date('Y-m-d')), 0, 10)) ?>">
            </div>

            <div class="form-row-inline">
              <label>
                <input type="checkbox" name="is_top" value="1"
                  <?= (!empty($editArticle) && (int) $editArticle['is_top'] === 1) ? 'checked' : '' ?>>
                ★ Odporúčaný článok (TOP sekcia)
              </label>
              <label>
                <input type="checkbox" name="is_published" value="1"
                  <?= (empty($editArticle) || (int) $editArticle['is_published'] === 1) ? 'checked' : '' ?>>
                Zverejnený
              </label>
            </div>
          </div>

          <div class="form-actions" style="margin-top:20px;">
            <button type="submit" class="btn-primary">
              <?= $editArticle ? '💾 Uložiť zmeny' : '➕ Pridať článok' ?>
            </button>
            <?php if ($editArticle): ?>
              <a href="admin_articles.php" class="btn-secondary-small">Zrušiť editáciu</a>
              <a href="article.php?id=<?= (int) $editArticle['id'] ?>" target="_blank" class="btn-secondary-small">👁 Zobraziť</a>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <hr class="section-divider">

      <!-- ── ZOZNAM ČLÁNKOV ──────────────────────────────────────────── -->
      <div class="primary-article">
        <h3>Všetky články (<?= count($articles) ?>)</h3>

        <?php if (empty($articles)): ?>
          <p>Zatiaľ žiadne články. Pridajte prvý vyššie.</p>
        <?php else: ?>
          <div style="overflow-x:auto;">
            <table class="admin-articles-table" aria-label="Zoznam článkov">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Titulok</th>
                  <th>Dátum</th>
                  <th>Stav</th>
                  <th>Akcie</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($articles as $a):
                  $aId    = (int) $a['id'];
                  $aTitle = htmlspecialchars((string) $a['title']);
                  $aDate  = htmlspecialchars(substr((string) $a['published_at'], 0, 10));
                  $aTop   = (int) $a['is_top'] === 1;
                  $aPub   = (int) $a['is_published'] === 1;
                ?>
                <tr>
                  <td><?= $aId ?></td>
                  <td>
                    <a href="article.php?id=<?= $aId ?>" target="_blank"><?= $aTitle ?></a>
                    <?php if ($aTop): ?><br><span class="badge-top-sm">★ TOP</span><?php endif; ?>
                  </td>
                  <td><?= $aDate ?></td>
                  <td>
                    <?php if ($aPub): ?>
                      <span class="badge-pub">Zverejnený</span>
                    <?php else: ?>
                      <span class="badge-draft">Skrytý</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="admin_articles.php?action=edit&id=<?= $aId ?>" class="btn-secondary-small">✏️ Upraviť</a>
                    &nbsp;
                    <form method="POST" action="admin_articles.php" style="display:inline"
                          onsubmit="return confirm('Naozaj chcete odstrániť článok „<?= addslashes($aTitle) ?>"?');">
                      <input type="hidden" name="csrf_token"  value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="action"      value="delete">
                      <input type="hidden" name="article_id"  value="<?= $aId ?>">
                      <button type="submit" class="btn-secondary-small" style="border-color:#ef4444;color:#ef4444;">🗑 Zmazať</button>
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

  <?php include 'footer.php'; ?>

  <script>
    // Automatické generovanie slugu z titulku
    (function () {
      const titleInput = document.getElementById('f_title');
      const slugInput  = document.getElementById('f_slug');
      if (!titleInput || !slugInput) return;

      titleInput.addEventListener('input', function () {
        if (slugInput.dataset.manualEdit === 'true') return;
        const map = {
          'á':'a','ä':'a','č':'c','ď':'d','é':'e','í':'i','ĺ':'l','ľ':'l',
          'ň':'n','ó':'o','ô':'o','ŕ':'r','š':'s','ť':'t','ú':'u','ý':'y','ž':'z'
        };
        let s = titleInput.value.toLowerCase();
        s = s.replace(/[áäčďéíĺľňóôŕšťúýž]/g, c => map[c] || c);
        s = s.replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        slugInput.value = s.substring(0, 200);
      });

      slugInput.addEventListener('input', function () {
        slugInput.dataset.manualEdit = slugInput.value.length > 0 ? 'true' : 'false';
      });
    })();
  </script>
</body>
</html>
