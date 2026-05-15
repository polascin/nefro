<?php
require_once 'auth.php';
require_once 'db_config.php';

// Bezpečnostné HTTP hlavičky
header_remove("X-Powered-By");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 0");
header("X-Content-Type-Options: nosniff");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=()");
header("Cross-Origin-Opener-Policy: same-origin");
header("X-Permitted-Cross-Domain-Policies: none");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, private");
header("Pragma: no-cache");
header("Expires: 0");
header("Surrogate-Control: no-store");

$csp = "default-src 'self'; "
  . "img-src 'self' data: https:; "
  . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
  . "font-src 'self' https://fonts.gstatic.com; "
  . "script-src 'self' https://www.googletagmanager.com https://www.google-analytics.com; "
  . "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com https://analytics.google.com https://*.analytics.google.com https://stats.g.doubleclick.net; "
  . "base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; upgrade-insecure-requests";
header("Content-Security-Policy: " . $csp);

// Načítanie parametra – akceptujeme len slug alebo id
$article = null;
$notFound = false;

$rawSlug = trim((string) ($_GET['slug'] ?? ''));
$rawId   = (int) ($_GET['id'] ?? 0);

try {
    if ($rawSlug !== '') {
        // Validácia: slug smie obsahovať len písmená, číslice a pomlčky
        if (!preg_match('/^[a-z0-9\-]{1,500}$/i', $rawSlug)) {
            $notFound = true;
        } else {
            $stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = :slug AND is_published = 1 LIMIT 1");
            $stmt->execute(['slug' => $rawSlug]);
            $article = $stmt->fetch() ?: null;
        }
    } elseif ($rawId > 0) {
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id AND is_published = 1 LIMIT 1");
        $stmt->execute(['id' => $rawId]);
        $article = $stmt->fetch() ?: null;
    } else {
        $notFound = true;
    }
} catch (\PDOException $e) {
    error_log('article.php DB error: ' . $e->getMessage());
    $notFound = true;
}

if ($article === null && !$notFound) {
    $notFound = true;
}

if ($notFound || $article === null) {
    http_response_code(404);
  header('X-Robots-Tag: noindex, follow', true);
}

// Formátovanie dátumu
$months = [
    1 => 'januára', 2 => 'februára', 3 => 'marca',    4 => 'apríla',
    5 => 'mája',    6 => 'júna',     7 => 'júla',     8 => 'augusta',
    9 => 'septembra', 10 => 'októbra', 11 => 'novembra', 12 => 'decembra',
];

function formatArticleDate(string $datetime, array $months): string {
    $ts = strtotime($datetime);
    if (!$ts) { return htmlspecialchars($datetime); }
    return (int) date('j', $ts) . '. ' . ($months[(int) date('n', $ts)] ?? '') . ' ' . date('Y', $ts);
}

function normalizePlainText(string $text): string {
  $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  $stripped = strip_tags($decoded);
  $normalized = preg_replace('/\s+/u', ' ', $stripped) ?? $stripped;
  return trim($normalized);
}

function buildSeoExcerpt(string $preferredText, string $fallbackText = '', int $maxLen = 165): string {
  $source = normalizePlainText($preferredText);
  if ($source === '') {
    $source = normalizePlainText($fallbackText);
  }
  if ($source === '') {
    return '';
  }
  if (mb_strlen($source) <= $maxLen) {
    return $source;
  }

  $slice = mb_substr($source, 0, $maxLen + 1);
  $slice = preg_replace('/\s+\S*$/u', '', $slice) ?? $slice;
  $slice = rtrim($slice, " \t\n\r\0\x0B,.;:-");
  return $slice . '…';
}

function toIso8601(string $datetime): string {
  $ts = strtotime($datetime);
  if (!$ts) {
    return date(DATE_ATOM);
  }
  return date(DATE_ATOM, $ts);
}

$siteName = 'Nefro-projekt Slovensko';
$baseUrl = 'https://nefro.polascin.net/';

$articleTitleRaw = $article ? (string) ($article['title'] ?? '') : '';
$articleAuthorRaw = $article ? (string) ($article['author'] ?? 'Dr. Ľubomír Polaščín') : 'Dr. Ľubomír Polaščín';
$canonicalUrlRaw = $article ? ($baseUrl . 'article.php?slug=' . (string) ($article['slug'] ?? '')) : '';

$metaDescriptionRaw = $article
  ? buildSeoExcerpt((string) ($article['excerpt'] ?? ''), (string) ($article['content'] ?? ''), 165)
  : 'Požadovaný článok neexistuje alebo bol odstránený.';
if ($metaDescriptionRaw === '') {
  $metaDescriptionRaw = 'Odborný článok z oblasti nefrológie.';
}

$pageTitleRaw = $article ? ($articleTitleRaw . ' | ' . $siteName) : ('Článok nenájdený | ' . $siteName);
$pageTitle = htmlspecialchars($pageTitleRaw, ENT_QUOTES);
$pageLastUpdated = $article
    ? date('d.m.Y H:i', strtotime((string) $article['updated_at']))
    : date('d.m.Y H:i', filemtime(__FILE__));
$pageTimeZone    = date('T') . ' (' . date_default_timezone_get() . ')';
$canonicalUrl = htmlspecialchars($canonicalUrlRaw, ENT_QUOTES);
$metaDescription = htmlspecialchars($metaDescriptionRaw, ENT_QUOTES);
$robotsMeta = $article ? 'index, follow, max-image-preview:large' : 'noindex, follow, noarchive';

$articleSchema = null;
if ($article) {
  $articleSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $articleTitleRaw,
    'description' => $metaDescriptionRaw,
    'inLanguage' => 'sk-SK',
    'mainEntityOfPage' => $canonicalUrlRaw,
    'url' => $canonicalUrlRaw,
    'datePublished' => toIso8601((string) ($article['published_at'] ?? '')),
    'dateModified' => toIso8601((string) ($article['updated_at'] ?? ($article['published_at'] ?? ''))),
    'author' => [
      '@type' => 'Person',
      'name' => $articleAuthorRaw,
    ],
    'publisher' => [
      '@type' => 'MedicalOrganization',
      'name' => $siteName,
      'logo' => [
        '@type' => 'ImageObject',
        'url' => $baseUrl . 'img/nps-logo.gif',
      ],
    ],
    'image' => [
      '@type' => 'ImageObject',
      'url' => $baseUrl . 'img/nps-logo.gif',
    ],
  ];
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="referrer" content="strict-origin-when-cross-origin">

  <meta name="description" content="<?= $metaDescription ?>">
  <meta name="robots" content="<?= htmlspecialchars($robotsMeta, ENT_QUOTES) ?>">
  <meta name="author" content="Dr. Ľubomír Polaščín">
  <?php if ($article): ?>
  <link rel="canonical" href="<?= $canonicalUrl ?>">
  <link rel="alternate" hreflang="sk-SK" href="<?= $canonicalUrl ?>">
  <?php endif; ?>

  <!-- Open Graph -->
  <meta property="og:type" content="<?= $article ? 'article' : 'website' ?>">
  <meta property="og:title" content="<?= $pageTitle ?>">
  <meta property="og:description" content="<?= $metaDescription ?>">
  <meta property="og:url" content="<?= $article ? $canonicalUrl : htmlspecialchars($baseUrl . 'article.php', ENT_QUOTES) ?>">
  <meta property="og:site_name" content="Nefro-projekt Slovensko">
  <meta property="og:locale" content="sk_SK">
  <meta property="og:image" content="https://nefro.polascin.net/img/nps-logo.gif">
  <meta property="og:image:alt" content="Nefro-projekt Slovensko">

  <?php if ($article): ?>
  <meta property="article:published_time" content="<?= htmlspecialchars(toIso8601((string) ($article['published_at'] ?? '')), ENT_QUOTES) ?>">
  <meta property="article:modified_time" content="<?= htmlspecialchars(toIso8601((string) ($article['updated_at'] ?? ($article['published_at'] ?? ''))), ENT_QUOTES) ?>">
  <meta property="article:author" content="<?= htmlspecialchars($articleAuthorRaw, ENT_QUOTES) ?>">
  <?php endif; ?>

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= $pageTitle ?>">
  <meta name="twitter:description" content="<?= $metaDescription ?>">
  <meta name="twitter:image" content="https://nefro.polascin.net/img/nps-logo.gif">
  <meta name="twitter:image:alt" content="Nefro-projekt Slovensko">

  <title><?= $pageTitle ?></title>

  <?php if ($articleSchema !== null): ?>
  <script type="application/ld+json"><?= json_encode($articleSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
  <?php endif; ?>

  <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
  <link rel="manifest" href="./site.webmanifest">
  <link rel="shortcut icon" href="./favicon.ico">

  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
  <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
  <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>

<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

  <?php
  $headerTitle = 'Nefro-projekt Slovensko';
  $headerIntro = 'Dynamická renesancia nefrológie: Od molekulárnej biológie po umelú inteligenciu.';
  $showLogo = true;
  include 'header.php';
  ?>

  <nav class="main-nav" aria-label="Hlavná navigácia">
    <div class="container">
      <ul>
        <li><a href="index.php">Domov</a></li>
        <li><a href="index.php#sluzby">Služby</a></li>
        <li><a href="index.php#o-nas">O nás</a></li>
        <li><a href="index.php#kontakt">Kontakt</a></li>
        <li><a href="calculators.php">Kalkulačky</a></li>
        <?php if (isLoggedIn()): ?>
          <?php if (isAdmin()): ?>
            <li><a href="admin.php">Admin panel</a></li>
            <li><a href="admin_articles.php">Správa článkov</a></li>
          <?php endif; ?>
          <li><a href="logout.php">Odhlásiť sa (<?= htmlspecialchars($_SESSION['username'] ?? 'Profil') ?>)</a></li>
        <?php else: ?>
          <li><a href="login.php">Prihlásenie</a></li>
          <li><a href="register.php">Registrácia</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <main id="main-content" class="container main-content" role="main">
    <div class="content-wrapper">
      <?php if ($notFound || $article === null): ?>
        <article class="primary-article">
          <header>
            <h2>Článok nenájdený</h2>
          </header>
          <p>Požadovaný článok neexistuje alebo bol odstránený.</p>
          <a href="index.php" class="btn-primary">← Späť na úvodnú stránku</a>
        </article>

      <?php else:
        $pubDate    = (string) $article['published_at'];
        $pubDateIso = htmlspecialchars(substr($pubDate, 0, 10));
        $pubDateSk  = formatArticleDate($pubDate, $months);
        $isTop      = (int) $article['is_top'] === 1;
      ?>

        <article class="primary-article" itemscope itemtype="https://schema.org/Article">
          <?php if ($isTop): ?>
            <span class="badge-top" aria-label="Odporúčaný článok">★ TOP</span>
          <?php endif; ?>
          <header>
            <h2 itemprop="headline"><?= htmlspecialchars((string) $article['title']) ?></h2>
            <p class="meta">
              Publikované:&nbsp;
              <time datetime="<?= $pubDateIso ?>" itemprop="datePublished"><?= htmlspecialchars($pubDateSk) ?></time>
              &nbsp;|&nbsp;
              <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                <span itemprop="name"><?= htmlspecialchars((string) $article['author']) ?></span>
              </span>
            </p>
          </header>

          <?= $article['content'] /* Trusted HTML — managed exclusively by admin */ ?>

          <footer>
            <p class="author">
              Autor: <span class="authorname"><?= htmlspecialchars((string) $article['author']) ?></span>
            </p>
            <?php if (isAdmin()): ?>
              <p class="article-admin-actions">
                <a href="admin_articles.php?action=edit&id=<?= (int) $article['id'] ?>" class="btn-secondary-small">✏️ Upraviť článok</a>
              </p>
            <?php endif; ?>
          </footer>
        </article>

        <nav class="article-nav" aria-label="Navigácia článkov">
          <a href="index.php" class="btn-secondary-small">← Späť na zoznam článkov</a>
        </nav>

      <?php endif; ?>
    </div>

    <aside class="sidebar">
      <div class="widget">
        <h3>O projekte</h3>
        <p>
          Nefrológia sa rozvíja míľovými krokmi — od molekulárnej biológie po umelú inteligenciu.
          Sledujte najnovšie poznatky a analýzy.
        </p>
        <a href="index.php" class="btn-primary" style="display:inline-block;margin-top:10px;">Všetky články</a>
      </div>
      <div class="widget">
        <h3>Užitočné odkazy</h3>
        <ul>
          <li><a href="https://kdigo.org/guidelines/" target="_blank" rel="noopener noreferrer">KDIGO Guidelines</a></li>
          <li><a href="https://www.era-online.org/guidelines/" target="_blank" rel="noopener noreferrer">ERA Guidelines</a></li>
          <li><a href="https://www.theisn.org/" target="_blank" rel="noopener noreferrer">International Society of Nephrology</a></li>
          <li><a href="https://www.kidney.org/professionals/guidelines" target="_blank" rel="noopener noreferrer">National Kidney Foundation (KDOQI)</a></li>
          <li><a href="https://pubmed.ncbi.nlm.nih.gov/?term=nephrology" target="_blank" rel="noopener noreferrer">PubMed: Nephrology</a></li>
        </ul>
      </div>
    </aside>
  </main>

  <?php include 'footer.php'; ?>
</body>
</html>
