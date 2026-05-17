<?php
/**
 * search.php — Komplexné hĺbkové vyhľadávanie v článkoch
 * Funkcie: FULLTEXT + LIKE, slovenské diakritiky, stop slová,
 *          relevančné skórovanie, zvýraznenie výrazov, snippety, stránkovanie.
 */
require_once 'auth.php';
require_once 'db_config.php';

// Bezpečnostné hlavičky
header_remove('X-Powered-By');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

// ── Konštanty ────────────────────────────────────────────────────────────────
const SEARCH_PER_PAGE   = 10;
const SEARCH_SNIPPET    = 230;   // znakov pre ukážku
const SEARCH_MIN_LEN    = 2;     // minimálna dĺžka slova
const SEARCH_MAX_TOKENS = 8;     // max počet slov v dopyte

// ── Stop slová (slovenčina + angličtina) ─────────────────────────────────────
const SK_STOP_WORDS = [
    'a','aby','aj','ak','ale','ani','ako','alebo','az','ba','bez','bol','bola',
    'boli','byť','by','čo','či','ďalej','do','dolu','ho','hoci','ich','je',
    'jej','im','k','kde','keď','kedy','keďže','kto','ktory','ku','lebo','len',
    'medzi','mi','my','na','nad','nám','nie','nielen','no','o','od','okolo',
    'on','oni','po','pod','podľa','pokiaľ','pre','pri','s','sa','si','sme',
    'sú','tak','taktiež','teda','tejto','to','toho','tom','tu','u','v','viac',
    'vo','voči','vždy','z','za','zo','že','než','iba','toto','táto','tento',
    'the','and','for','that','are','with','this','was','but','not',
];

// ── Pomocné funkcie ───────────────────────────────────────────────────────────

/**
 * Odstráni slovenské diakritické znaky a prevedie na malé písmená.
 * Výsledok použijeme ako fallback pre vyhľadávanie.
 */
function searchNormalizeSk(string $text): string
{
    static $map = [
        'á'=>'a','ä'=>'a','č'=>'c','ď'=>'d','é'=>'e','í'=>'i','ĺ'=>'l','ľ'=>'l',
        'ň'=>'n','ó'=>'o','ô'=>'o','ŕ'=>'r','š'=>'s','ť'=>'t','ú'=>'u','ý'=>'y','ž'=>'z',
        'Á'=>'a','Ä'=>'a','Č'=>'c','Ď'=>'d','É'=>'e','Í'=>'i','Ĺ'=>'l','Ľ'=>'l',
        'Ň'=>'n','Ó'=>'o','Ô'=>'o','Ŕ'=>'r','Š'=>'s','Ť'=>'t','Ú'=>'u','Ý'=>'y','Ž'=>'z',
    ];
    return strtolower(strtr($text, $map));
}

/**
 * Rozloží dopyt na tokeny, odfiltruje stop slová a krátke slová.
 * Vracia pole unikátnych tokenov v pôvodnom a normalizovanom tvare.
 */
function searchTokenize(string $rawQuery): array
{
    // Odstráň špeciálne DB znaky a normalizuj whitespace
    $clean = preg_replace('/[+\-*~<>()\"@]+/', ' ', $rawQuery) ?? $rawQuery;
    $clean = preg_replace('/\s+/u', ' ', trim($clean)) ?? $clean;

    $rawTokens = explode(' ', $clean);
    $tokens    = [];

    foreach ($rawTokens as $tok) {
        $tok = trim($tok);
        if (mb_strlen($tok, 'UTF-8') < SEARCH_MIN_LEN) {
            continue;
        }
        $normalized = searchNormalizeSk($tok);
        if (in_array($normalized, SK_STOP_WORDS, true)) {
            continue;
        }
        $tokens[$normalized] = $tok; // normalized → original
    }

    // Limit počtu tokenov
    $tokens = array_slice($tokens, 0, SEARCH_MAX_TOKENS, true);
    return $tokens; // ['normalized' => 'original', ...]
}

/**
 * Skontroluje, či FULLTEXT index existuje na tabuľke articles.
 */
function searchFtIndexExists(PDO $pdo): bool
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    try {
        $s = $pdo->prepare(
            "SELECT COUNT(*) FROM information_schema.STATISTICS
             WHERE table_schema = DATABASE()
               AND table_name   = 'articles'
               AND index_name   = 'ft_articles_search'
               AND index_type   = 'FULLTEXT'"
        );
        $s->execute();
        $cache = ((int) $s->fetchColumn()) > 0;
    } catch (\PDOException) {
        $cache = false;
    }
    return $cache;
}

/**
 * Hlavná vyhľadávacia funkcia.
 * Vracia ['items' => [...], 'total' => int, 'strategy' => string]
 *
 * Stratégie (v poradí priority):
 *   1. FULLTEXT BOOLEAN (ak index existuje)
 *   2. LIKE s pôvodným dopytom (utf8mb4_unicode_ci → SK diakritiky zdarma)
 *   3. LIKE s normalizovaným dopytom (de-accented fallback)
 */
function doArticleSearch(
    PDO    $pdo,
    string $rawQuery,
    array  $tokens,       // ['normalized' => 'original']
    int    $page,
    int    $perPage
): array {
    $offset   = ($page - 1) * $perPage;
    $strategy = 'none';

    if (empty($tokens)) {
        return ['items' => [], 'total' => 0, 'strategy' => $strategy];
    }

    // ── Pokus 1: FULLTEXT BOOLEAN mode ───────────────────────────────────────
    if (searchFtIndexExists($pdo)) {
        $ftResult = searchViaFullText($pdo, $rawQuery, $tokens, $offset, $perPage);
        if ($ftResult['total'] > 0) {
            $ftResult['strategy'] = 'fulltext';
            return $ftResult;
        }
    }

    // ── Pokus 2: LIKE s pôvodným dopytom ─────────────────────────────────────
    // utf8mb4_unicode_ci automaticky rieši SK diakritiky aj veľké/malé písmená
    $likeResult = searchViaLike($pdo, $tokens, $offset, $perPage, false);
    if ($likeResult['total'] > 0) {
        $likeResult['strategy'] = 'like';
        return $likeResult;
    }

    // ── Pokus 3: LIKE s de-akcento­vaným dopytom ─────────────────────────────
    // Fallback: ak DB collation z nejakého dôvodu nespáruje diakritiku
    $likeNormResult = searchViaLike($pdo, $tokens, $offset, $perPage, true);
    if ($likeNormResult['total'] > 0) {
        $likeNormResult['strategy'] = 'like-normalized';
        return $likeNormResult;
    }

    return ['items' => [], 'total' => 0, 'strategy' => 'none'];
}

/**
 * FULLTEXT BOOLEAN vyhľadávanie.
 * Query format: "token1* token2*" (prefix matching, OR logic)
 */
function searchViaFullText(
    PDO    $pdo,
    string $rawQuery,
    array  $tokens,
    int    $offset,
    int    $perPage
): array {
    // Zostavíme BOOLEAN query: každý token s wildcard (prefix matching)
    $ftParts = [];
    foreach ($tokens as $norm => $orig) {
        // Escape špeciálnych znakov pre BOOLEAN mode
        $safe = str_replace(['*','@','~','+','-','<','>','(',')','\"'], '', $orig);
        if ($safe !== '') {
            $ftParts[] = $safe . '*';
        }
    }
    if (empty($ftParts)) {
        return ['items' => [], 'total' => 0];
    }

    $ftQuery = implode(' ', $ftParts);

    try {
        // Počet výsledkov
        $cntStmt = $pdo->prepare(
            "SELECT COUNT(*) FROM articles
             WHERE is_published = 1
               AND MATCH(title, excerpt, content) AGAINST(:q IN BOOLEAN MODE)"
        );
        $cntStmt->execute(['q' => $ftQuery]);
        $total = (int) $cntStmt->fetchColumn();

        if ($total === 0) {
            return ['items' => [], 'total' => 0];
        }

        // Načítanie výsledkov so skóre
        $stmt = $pdo->prepare(
            "SELECT id, title, slug, author, excerpt, published_at,
                    LEFT(content, 2000) AS content_preview,
                    (
                        MATCH(title)   AGAINST(:q IN BOOLEAN MODE) * 5.0 +
                        MATCH(excerpt) AGAINST(:q IN BOOLEAN MODE) * 2.5 +
                        MATCH(content) AGAINST(:q IN BOOLEAN MODE) * 1.0
                    ) AS ft_score
             FROM articles
             WHERE is_published = 1
               AND MATCH(title, excerpt, content) AGAINST(:q IN BOOLEAN MODE)
             ORDER BY ft_score DESC, published_at DESC
             LIMIT :lim OFFSET :off"
        );
        // Tri MATCH(...) calls potrebujú tri separate AGAINST — spoj iba v bodovaní,
        // ale WHERE stačí jeden kombinovaný index.
        // Oprava: použijeme jeden index pre WHERE a bodujeme PHP-side
        $stmt2 = $pdo->prepare(
            "SELECT id, title, slug, author, excerpt, published_at,
                    LEFT(content, 3000) AS content_preview
             FROM articles
             WHERE is_published = 1
               AND MATCH(title, excerpt, content) AGAINST(:q IN BOOLEAN MODE)
             ORDER BY MATCH(title, excerpt, content) AGAINST(:q IN BOOLEAN MODE) DESC,
                      published_at DESC
             LIMIT :lim OFFSET :off"
        );
        $stmt2->bindValue(':q',   $ftQuery,  PDO::PARAM_STR);
        $stmt2->bindValue(':lim', $perPage,  PDO::PARAM_INT);
        $stmt2->bindValue(':off', $offset,   PDO::PARAM_INT);
        $stmt2->execute();
        $rows = $stmt2->fetchAll();

        return ['items' => $rows, 'total' => $total];
    } catch (\PDOException) {
        return ['items' => [], 'total' => 0];
    }
}

/**
 * LIKE vyhľadávanie — dynamicky zostavený SQL podľa tokenov.
 * Skóruje na DB strane: title=10, excerpt=5, content=1.
 *
 * @param bool $useNormalized Ak true, použije de-akcentované tokeny
 */
function searchViaLike(
    PDO   $pdo,
    array $tokens,
    int   $offset,
    int   $perPage,
    bool  $useNormalized
): array {
    if (empty($tokens)) {
        return ['items' => [], 'total' => 0];
    }

    $params = [];
    $whereParts  = [];
    $scoreParts  = [];
    $idx = 0;

    foreach ($tokens as $norm => $orig) {
        $term    = $useNormalized ? $norm : $orig;
        $pattern = '%' . $term . '%';
        $pTitle  = 'pt' . $idx;
        $pExc    = 'pe' . $idx;
        $pCont   = 'pc' . $idx;

        $params[$pTitle] = $pattern;
        $params[$pExc]   = $pattern;
        $params[$pCont]  = $pattern;

        $whereParts[] = "(title LIKE :{$pTitle} OR excerpt LIKE :{$pExc} OR content LIKE :{$pCont})";

        // Skóre: title match = 10, excerpt = 5, content = 1
        $scoreParts[] = "(CASE WHEN title   LIKE :{$pTitle} THEN 10 ELSE 0 END)";
        $scoreParts[] = "(CASE WHEN excerpt  LIKE :{$pExc}  THEN  5 ELSE 0 END)";
        $scoreParts[] = "(CASE WHEN content  LIKE :{$pCont} THEN  1 ELSE 0 END)";

        $idx++;
    }

    // AND medzi tokenmi: všetky musia byť niekde prítomné
    $whereClause = implode(' AND ', $whereParts);
    $scoreExpr   = implode(' + ', $scoreParts);

    try {
        // Celkový počet
        $cntSql  = "SELECT COUNT(*) FROM articles WHERE is_published = 1 AND ({$whereClause})";
        $cntStmt = $pdo->prepare($cntSql);
        $cntStmt->execute($params);
        $total = (int) $cntStmt->fetchColumn();

        if ($total === 0) {
            return ['items' => [], 'total' => 0];
        }

        // Výsledky s relevančným skóre
        $selSql = "SELECT id, title, slug, author, excerpt, published_at,
                          LEFT(content, 3000) AS content_preview,
                          ({$scoreExpr}) AS score
                   FROM articles
                   WHERE is_published = 1
                     AND ({$whereClause})
                   ORDER BY score DESC, published_at DESC
                   LIMIT :lim OFFSET :off";

        $selStmt = $pdo->prepare($selSql);
        foreach ($params as $k => $v) {
            $selStmt->bindValue(':' . $k, $v, PDO::PARAM_STR);
        }
        $selStmt->bindValue(':lim', $perPage, PDO::PARAM_INT);
        $selStmt->bindValue(':off', $offset,  PDO::PARAM_INT);
        $selStmt->execute();
        $rows = $selStmt->fetchAll();

        return ['items' => $rows, 'total' => $total];
    } catch (\PDOException $e) {
        error_log('search.php LIKE error: ' . $e->getMessage());
        return ['items' => [], 'total' => 0];
    }
}

/**
 * Extrahuje textový úryvok z HTML obsahu okolo prvého výskytu niektorého tokenu.
 * Vracia plain-text snippet so zvýraznenými výrazmi.
 */
function buildSearchSnippet(
    string $htmlContent,
    array  $tokens,          // ['normalized' => 'original']
    int    $snippetLen = SEARCH_SNIPPET
): string {
    // Strip HTML → plain text
    $text = html_entity_decode(strip_tags($htmlContent), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = preg_replace('/\s+/u', ' ', trim($text)) ?? $text;

    if ($text === '') {
        return '';
    }

    $textLower = mb_strtolower($text, 'UTF-8');
    $firstPos  = mb_strlen($text, 'UTF-8'); // začneme od konca (worst case)

    // Nájdi najskoršiu pozíciu ľubovoľného tokenu
    foreach ($tokens as $norm => $orig) {
        // Skús pôvodný token
        $pos = mb_stripos($text, $orig, 0, 'UTF-8');
        if ($pos !== false && $pos < $firstPos) {
            $firstPos = $pos;
        }
        // Fallback: normalizovaný
        $pos2 = mb_stripos($textLower, $norm, 0, 'UTF-8');
        if ($pos2 !== false && $pos2 < $firstPos) {
            $firstPos = $pos2;
        }
    }

    // Ak nebol nájdený žiaden výraz, vráť začiatok textu
    if ($firstPos >= mb_strlen($text, 'UTF-8')) {
        $firstPos = 0;
    }

    // Výber kontextu (symetricky okolo prvého výskytu)
    $half  = (int) ($snippetLen / 2);
    $start = max(0, $firstPos - $half);

    // Posun na začiatok slova
    while ($start > 0 && mb_substr($text, $start - 1, 1, 'UTF-8') !== ' ') {
        $start--;
    }

    $snippet = mb_substr($text, $start, $snippetLen, 'UTF-8');

    // Pridaj elipsy
    $prefix = $start > 0 ? '…' : '';
    $suffix = ($start + $snippetLen) < mb_strlen($text, 'UTF-8') ? '…' : '';

    $snippet = $prefix . trim($snippet) . $suffix;

    // Zvýraznenie tokenov
    return highlightSearchTerms($snippet, $tokens);
}

/**
 * Obalí všetky výskyty tokenov v texte tagom <mark class="search-hl">.
 * Rieši diakritiku aj veľké/malé písmená cez regex s Unicode flagmi.
 */
function highlightSearchTerms(string $text, array $tokens): string
{
    // Zoradíme tokeny od najdlhšieho (greedy matching)
    $allTerms = [];
    foreach ($tokens as $norm => $orig) {
        $allTerms[] = $orig;
        if ($norm !== $orig) {
            $allTerms[] = $norm;
        }
    }
    usort($allTerms, fn($a, $b) => mb_strlen($b, 'UTF-8') - mb_strlen($a, 'UTF-8'));

    foreach ($allTerms as $term) {
        if (mb_strlen($term, 'UTF-8') < SEARCH_MIN_LEN) {
            continue;
        }
        $escaped = preg_quote($term, '/');
        // Regex s /ui flagmi: case-insensitive + unicode
        $text = preg_replace(
            '/(' . $escaped . ')/ui',
            '<mark class="search-hl">$1</mark>',
            $text
        ) ?? $text;
    }

    return $text;
}

/**
 * Detekuje, v ktorých poliach sa dopyt zhoduje (pre badge zobrazenie).
 * Vracia pole reťazcov: ['title', 'excerpt', 'content']
 */
function detectMatchFields(array $row, array $tokens): array
{
    $fields = [];
    foreach ($tokens as $norm => $orig) {
        if (!in_array('title', $fields, true)
            && (mb_stripos((string)($row['title'] ?? ''), $orig) !== false
                || mb_stripos((string)($row['title'] ?? ''), $norm) !== false)) {
            $fields[] = 'title';
        }
        if (!in_array('excerpt', $fields, true)
            && (mb_stripos((string)($row['excerpt'] ?? ''), $orig) !== false
                || mb_stripos((string)($row['excerpt'] ?? ''), $norm) !== false)) {
            $fields[] = 'excerpt';
        }
        if (!in_array('content', $fields, true)
            && (mb_stripos((string)($row['content_preview'] ?? ''), $orig) !== false
                || mb_stripos((string)($row['content_preview'] ?? ''), $norm) !== false)) {
            $fields[] = 'content';
        }
    }
    return $fields;
}

// ── Spracovanie vstupu ────────────────────────────────────────────────────────

$rawQuery = trim((string) ($_GET['s'] ?? ''));
$page     = max(1, (int) ($_GET['page'] ?? 1));

// Sanitácia: max 200 znakov
if (mb_strlen($rawQuery, 'UTF-8') > 200) {
    $rawQuery = mb_substr($rawQuery, 0, 200, 'UTF-8');
}

$tokens      = [];   // ['normalized' => 'original']
$results     = [];
$totalItems  = 0;
$totalPages  = 1;
$strategy    = 'none';
$searchTime  = 0.0;
$hasQuery    = $rawQuery !== '';

if ($hasQuery) {
    $tokens = searchTokenize($rawQuery);

    if (!empty($tokens)) {
        $t0 = microtime(true);
        $sr = doArticleSearch($pdo, $rawQuery, $tokens, $page, SEARCH_PER_PAGE);
        $searchTime = round((microtime(true) - $t0) * 1000, 1); // ms

        $results    = $sr['items'];
        $totalItems = $sr['total'];
        $strategy   = $sr['strategy'];
        $totalPages = max(1, (int) ceil($totalItems / SEARCH_PER_PAGE));

        if ($page > $totalPages) {
            $page       = $totalPages;
            $results    = [];
        }
    }
}

// ── SEO meta ─────────────────────────────────────────────────────────────────

$baseUrl = 'https://nefro.polascin.net/';
$siteName = 'Nefro-projekt Slovensko';

$pageTitle = $hasQuery
    ? 'Výsledky hľadania: ' . $rawQuery . ' | ' . $siteName
    : 'Vyhľadávanie | ' . $siteName;

$seoDescription = $hasQuery
    ? 'Výsledky vyhľadávania pre: ' . $rawQuery . ' — odborné nefrologické články, kalkulačky a analýzy.'
    : 'Prehľadávajte odborné nefrologické články, kalkulačky CKD, eGFR, KFRE a ďalší obsah portálu Nefro-projekt Slovensko.';

$robotsMeta   = 'noindex, follow';
$canonicalUrl = $baseUrl . 'search.php' . ($hasQuery ? '?s=' . urlencode($rawQuery) : '');

$prevUrl = '';
$nextUrl = '';
if ($page > 1) {
    $prevUrl = $baseUrl . 'search.php?s=' . urlencode($rawQuery) . '&page=' . ($page - 1);
}
if ($page < $totalPages) {
    $nextUrl = $baseUrl . 'search.php?s=' . urlencode($rawQuery) . '&page=' . ($page + 1);
}

// Pomocná funkcia na formátovanie dátumu
function formatSearchDate(string $datetime): string
{
    $months = [
        1=>'januára',2=>'februára',3=>'marca',4=>'apríla',
        5=>'mája',6=>'júna',7=>'júla',8=>'augusta',
        9=>'septembra',10=>'októbra',11=>'novembra',12=>'decembra',
    ];
    $ts = strtotime($datetime);
    if (!$ts) {
        return htmlspecialchars($datetime);
    }
    return (int)date('j',$ts) . '. ' . ($months[(int)date('n',$ts)] ?? '') . ' ' . date('Y',$ts);
}

$fieldLabels = ['title' => 'Nadpis', 'excerpt' => 'Perex', 'content' => 'Obsah'];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php include 'head_meta.php'; ?>
  <?php if ($prevUrl): ?>
  <link rel="prev" href="<?= htmlspecialchars($prevUrl) ?>">
  <?php endif; ?>
  <?php if ($nextUrl): ?>
  <link rel="next" href="<?= htmlspecialchars($nextUrl) ?>">
  <?php endif; ?>
</head>
<body>
  <a href="#search-results" class="skip-link">Preskočiť na výsledky</a>

  <?php
  $headerTitle = 'Nefro-projekt Slovensko';
  $showLogo    = false;
  include 'header.php';
  ?>

  <nav class="main-nav" aria-label="Hlavná navigácia">
    <div class="container">
      <button class="menu-toggle" id="menuToggle" aria-label="Otvoriť menu" aria-expanded="false">
        <span>Menu</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <ul>
        <li><a href="index.php">Domov</a></li>
        <li><a href="calculators.php">Kalkulačky</a></li>
        <li><a href="search.php" class="active" aria-current="page">Vyhľadávanie</a></li>
        <?php if (isLoggedIn()): ?>
          <?php if (isAdmin()): ?>
            <li><a href="admin.php">Admin</a></li>
            <li><a href="admin_articles.php">Správa článkov</a></li>
          <?php endif; ?>
          <li><a href="logout.php">Odhlásiť sa</a></li>
        <?php else: ?>
          <li><a href="login.php">Prihlásenie</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <main id="search-results" class="container" style="padding-top:48px;padding-bottom:64px;">
    <div class="main-content main-content--single-col">
      <div class="primary-article">

        <!-- ── Nadpis stránky ──────────────────────────────────────── -->
        <h2 style="margin-bottom:1.5rem;">
          <?php if ($hasQuery): ?>
            Výsledky hľadania
          <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-5px;margin-right:8px;opacity:0.7;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Vyhľadávanie
          <?php endif; ?>
        </h2>

        <!-- ── Formulár vyhľadávania ──────────────────────────────── -->
        <form method="GET" action="search.php" role="search" aria-label="Vyhľadávanie v článkoch">
          <div class="search-form-wrap">
            <label for="search-input" class="visually-hidden">Vyhľadať v článkoch</label>
            <input
              type="search"
              id="search-input"
              name="s"
              class="search-input"
              value="<?= htmlspecialchars($rawQuery) ?>"
              placeholder="Hľadajte napr. eGFR, hyponatriémia, dyslipidémia…"
              autocomplete="off"
              autofocus
              maxlength="200"
              aria-label="Vyhľadávací výraz"
            >
            <button type="submit" class="search-btn" aria-label="Spustiť vyhľadávanie">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              Hľadať
            </button>
          </div>

          <?php if ($hasQuery && !empty($tokens)): ?>
            <p style="font-size:0.8rem;color:var(--text-tertiary);margin-top:-12px;margin-bottom:0;">
              Vyhľadávané výrazy:
              <?php foreach ($tokens as $norm => $orig): ?>
                <span class="search-meta__term"><?= htmlspecialchars($orig) ?></span>
              <?php endforeach; ?>
            </p>
          <?php endif; ?>
        </form>

        <?php if ($hasQuery): ?>

          <!-- ── Metadáta výsledkov ────────────────────────────────── -->
          <div class="search-meta" aria-live="polite" aria-atomic="true">
            <?php if ($totalItems > 0): ?>
              <span>
                Nájdených: <strong class="search-meta__count"><?= $totalItems ?></strong>
                <?= $totalItems === 1 ? 'výsledok' : ($totalItems < 5 ? 'výsledky' : 'výsledkov') ?>
              </span>
              <?php if ($totalPages > 1): ?>
                <span style="color:var(--text-tertiary);">·</span>
                <span>Strana <?= $page ?> z <?= $totalPages ?></span>
              <?php endif; ?>
              <span style="color:var(--text-tertiary);">·</span>
              <span class="search-meta__time"><?= $searchTime ?>&nbsp;ms</span>
            <?php else: ?>
              <span>Žiadne výsledky pre <span class="search-meta__term"><?= htmlspecialchars($rawQuery) ?></span></span>
            <?php endif; ?>
          </div>

          <?php if (!empty($results)): ?>

            <!-- ── Zoznam výsledkov ─────────────────────────────────── -->
            <div role="list" aria-label="Výsledky vyhľadávania">
              <?php foreach ($results as $row):
                $matchFields = detectMatchFields($row, $tokens);
                $snippet     = buildSearchSnippet(
                    (string) ($row['content_preview'] ?? $row['excerpt'] ?? ''),
                    $tokens
                );
                $titleHl     = highlightSearchTerms(
                    htmlspecialchars((string) ($row['title'] ?? '')),
                    $tokens
                );
                $articleUrl  = 'article.php?slug=' . rawurlencode((string) ($row['slug'] ?? ''));
              ?>
              <article class="search-result" role="listitem">
                <a href="<?= htmlspecialchars($articleUrl) ?>" class="search-result__title">
                  <?= $titleHl ?>
                </a>

                <div class="search-result__meta">
                  <time datetime="<?= htmlspecialchars(substr((string)($row['published_at']??''),0,10)) ?>">
                    <?= formatSearchDate((string) ($row['published_at'] ?? '')) ?>
                  </time>
                  <?php if (!empty($row['author'])): ?>
                    <span style="color:var(--text-tertiary);">·</span>
                    <span><?= htmlspecialchars((string) $row['author']) ?></span>
                  <?php endif; ?>
                  <?php foreach ($matchFields as $field): ?>
                    <span class="search-result__field-badge"><?= htmlspecialchars($fieldLabels[$field] ?? $field) ?></span>
                  <?php endforeach; ?>
                </div>

                <?php if ($snippet !== ''): ?>
                  <div class="search-result__snippet" aria-label="Ukážka z článku">
                    <?= $snippet ?>
                  </div>
                <?php elseif (!empty($row['excerpt'])): ?>
                  <div class="search-result__snippet">
                    <?= highlightSearchTerms(htmlspecialchars(mb_substr((string)$row['excerpt'], 0, SEARCH_SNIPPET, 'UTF-8')), $tokens) ?>
                  </div>
                <?php endif; ?>
              </article>
              <?php endforeach; ?>
            </div>

            <!-- ── Stránkovanie ─────────────────────────────────────── -->
            <?php if ($totalPages > 1): ?>
              <nav class="search-pagination" aria-label="Stránkovanie výsledkov vyhľadávania">
                <?php if ($prevUrl): ?>
                  <a href="<?= htmlspecialchars($prevUrl) ?>"
                     class="articles-page-link"
                     rel="prev"
                     aria-label="Predchádzajúca strana">← Predošlá</a>
                <?php endif; ?>

                <?php
                $startP = max(1, $page - 2);
                $endP   = min($totalPages, $page + 2);
                for ($p = $startP; $p <= $endP; $p++):
                    $pUrl = $baseUrl . 'search.php?s=' . urlencode($rawQuery) . '&page=' . $p;
                ?>
                  <a href="<?= htmlspecialchars($pUrl) ?>"
                     class="articles-page-link<?= $p === $page ? ' is-active' : '' ?>"
                     <?= $p === $page ? 'aria-current="page"' : '' ?>
                     aria-label="Strana <?= $p ?>"><?= $p ?></a>
                <?php endfor; ?>

                <?php if ($nextUrl): ?>
                  <a href="<?= htmlspecialchars($nextUrl) ?>"
                     class="articles-page-link"
                     rel="next"
                     aria-label="Nasledujúca strana">Ďalšia →</a>
                <?php endif; ?>
              </nav>
            <?php endif; ?>

          <?php else: ?>

            <!-- ── Nulové výsledky ──────────────────────────────────── -->
            <div class="search-empty" role="status" aria-live="polite">
              <div class="search-empty__icon" aria-hidden="true">🔍</div>
              <div class="search-empty__title">Žiadne výsledky</div>
              <p class="search-empty__text">
                Pre výraz <strong><?= htmlspecialchars($rawQuery) ?></strong>
                nebol nájdený žiadny článok.
              </p>

              <?php if (empty($tokens)): ?>
                <p class="search-empty__text" style="font-size:0.85rem;">
                  Zadaný výraz obsahuje iba krátke alebo bežné slovenské slová.
                  Skúste konkrétnejší odborný výraz.
                </p>
              <?php endif; ?>

              <div style="margin-top:1.5rem;">
                <p style="font-size:0.88rem;color:var(--text-tertiary);margin-bottom:0.75rem;">Skúste napríklad:</p>
                <div style="display:flex;flex-wrap:wrap;gap:8px;justify-content:center;">
                  <?php foreach (['eGFR','CKD','KFRE','hyponatriémia','dyslipidémia','dialýza','statín','vitamín D'] as $sugg): ?>
                    <a href="search.php?s=<?= urlencode($sugg) ?>"
                       class="search-meta__term"
                       style="text-decoration:none;cursor:pointer;"><?= htmlspecialchars($sugg) ?></a>
                  <?php endforeach; ?>
                </div>
              </div>

              <div style="margin-top:2rem;">
                <a href="index.php" class="btn-primary" style="display:inline-block;">
                  ← Späť na zoznam článkov
                </a>
              </div>
            </div>

          <?php endif; ?>

        <?php else: ?>

          <!-- ── Úvodná stránka vyhľadávania (bez dopytu) ─────────── -->
          <div style="text-align:center;padding:2rem 0;">
            <p style="color:var(--text-secondary);font-size:1.05rem;max-width:520px;margin:0 auto 2rem;">
              Prehľadávajte odborné nefrologické články, analýzy a komentáre.
              Vyhľadávanie je jazykovo inteligentné — rozumie slovenčine, diakritike aj medicínskym skratkám.
            </p>

            <p style="font-size:0.88rem;color:var(--text-tertiary);margin-bottom:1rem;">Obľúbené témy:</p>
            <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin-bottom:2.5rem;">
              <?php foreach (['eGFR','CKD','KFRE','KDIGO','hyponatriémia','dyslipidémia','dialýza','AKI','lymfóm','prediabetes','statín','vitamín D','ADPKD','IgA nefropatia'] as $sugg): ?>
                <a href="search.php?s=<?= urlencode($sugg) ?>"
                   class="search-meta__term"
                   style="text-decoration:none;cursor:pointer;font-size:0.9rem;padding:5px 12px;">
                  <?= htmlspecialchars($sugg) ?>
                </a>
              <?php endforeach; ?>
            </div>

            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
              <a href="index.php" class="btn-secondary" style="display:inline-block;padding:10px 22px;border-radius:8px;">
                📄 Všetky články
              </a>
              <a href="calculators.php" class="btn-secondary" style="display:inline-block;padding:10px 22px;border-radius:8px;">
                🧮 Kalkulačky
              </a>
            </div>
          </div>

        <?php endif; ?>

      </div><!-- /.primary-article -->
    </div><!-- /.main-content -->
  </main>

  <?php include 'footer.php'; ?>

  <script>
  // Hamburger menu
  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('menuToggle');
    const nav = document.querySelector('.main-nav ul');
    if (btn && nav) {
      btn.addEventListener('click', () => {
        const open = nav.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    }
  });
  </script>
</body>
</html>
