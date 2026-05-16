<?php
require_once 'auth.php';
require_once 'db_config.php';
// Bezpečnostné HTTP hlavičky
header_remove("X-Powered-By");
header("X-Frame-Options: SAMEORIGIN"); // Ochrana pred Clickjackingom
header("X-XSS-Protection: 0"); // Legacy hlavička, moderné prehliadače používajú CSP
header("X-Content-Type-Options: nosniff"); // Zabránenie MIME-sniffingu
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Vynútenie HTTPS
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

$monthsLocative = [
  1 => 'januári',
  2 => 'februári',
  3 => 'marci',
  4 => 'apríli',
  5 => 'máji',
  6 => 'júni',
  7 => 'júli',
  8 => 'auguste',
  9 => 'septembri',
  10 => 'októbri',
  11 => 'novembri',
  12 => 'decembri',
];
$currentMonth = (int) date('n');
$currentYear = date('Y');
$currentMonthYearLocative = ($monthsLocative[$currentMonth] ?? '') . ' ' . $currentYear;
$pageLastUpdated = date('d.m.Y H:i', filemtime(__FILE__));
$pageTimeZone = date('T') . ' (' . date_default_timezone_get() . ')';

function formatArticleDate(string $datetime): string {
    $months = [
        1 => 'januára', 2 => 'februára', 3 => 'marca',    4 => 'apríla',
        5 => 'mája',    6 => 'júna',     7 => 'júla',     8 => 'augusta',
        9 => 'septembra', 10 => 'októbra', 11 => 'novembra', 12 => 'decembra',
    ];
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

  function buildSeoExcerpt(string $preferredText, string $fallbackText = '', int $maxLen = 170): string {
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

$topArticles   = [];
$otherArticles = [];
$otherArticlesPerPage = 10;
$otherArticlesTotal = 0;
$otherArticlesTotalPages = 1;
$otherArticlesPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($otherArticlesPage < 1) {
  $otherArticlesPage = 1;
}
try {
    $stmtTop = $pdo->query(
        "SELECT id, title, slug, author, excerpt, published_at
         FROM articles WHERE is_top = 1 AND is_published = 1
         ORDER BY sort_order ASC, published_at DESC"
    );
    $topArticles = $stmtTop->fetchAll();

  $stmtOtherCount = $pdo->query(
    "SELECT COUNT(*)
     FROM articles WHERE is_top = 0 AND is_published = 1"
  );
  $otherArticlesTotal = (int) $stmtOtherCount->fetchColumn();
  $otherArticlesTotalPages = max(1, (int) ceil($otherArticlesTotal / $otherArticlesPerPage));
  if ($otherArticlesPage > $otherArticlesTotalPages) {
    $otherArticlesPage = $otherArticlesTotalPages;
  }
  $otherArticlesOffset = ($otherArticlesPage - 1) * $otherArticlesPerPage;

  $stmtOther = $pdo->prepare(
    "SELECT id, title, slug, author, excerpt, published_at
     FROM articles WHERE is_top = 0 AND is_published = 1
     ORDER BY sort_order ASC, published_at DESC
     LIMIT :limit OFFSET :offset"
  );
  $stmtOther->bindValue(':limit', $otherArticlesPerPage, \PDO::PARAM_INT);
  $stmtOther->bindValue(':offset', $otherArticlesOffset, \PDO::PARAM_INT);
  $stmtOther->execute();
    $otherArticles = $stmtOther->fetchAll();
} catch (\PDOException $e) {
    error_log('index.php – chyba pri načítaní článkov: ' . $e->getMessage());
}

$siteName = 'Nefro-projekt Slovensko';
$baseUrl = 'https://nefro.polascin.net/';
$isPaginated = $otherArticlesPage > 1;
$firstArticleForSeo = $topArticles[0] ?? $otherArticles[0] ?? null;

$defaultDescription = 'Nefrologické články a odborné analýzy o CKD, dialýze a moderných odporúčaniach pre klinickú prax na Slovensku.';
$seoDescription = $defaultDescription;
if (is_array($firstArticleForSeo)) {
  $seoDescription = buildSeoExcerpt((string) ($firstArticleForSeo['excerpt'] ?? ''), '', 165);
  if ($seoDescription === '') {
    $seoDescription = $defaultDescription;
  }
}

$pageTitle = $isPaginated
  ? 'Nefrologické články – strana ' . $otherArticlesPage . ' | ' . $siteName
  : $siteName;
$canonicalUrl = $isPaginated ? ($baseUrl . '?page=' . $otherArticlesPage) : $baseUrl;
$prevUrl = $otherArticlesPage > 1
  ? ($otherArticlesPage === 2 ? $baseUrl : ($baseUrl . '?page=' . ($otherArticlesPage - 1)))
  : '';
$nextUrl = $otherArticlesPage < $otherArticlesTotalPages
  ? ($baseUrl . '?page=' . ($otherArticlesPage + 1))
  : '';

$itemListElements = [];
$allPageArticles = array_merge($topArticles, $otherArticles);
foreach ($allPageArticles as $idx => $art) {
  $slug = (string) ($art['slug'] ?? '');
  $title = normalizePlainText((string) ($art['title'] ?? ''));
  if ($slug === '' || $title === '') {
    continue;
  }
  $itemListElements[] = [
    '@type' => 'ListItem',
    'position' => count($itemListElements) + 1,
    'url' => $baseUrl . 'article.php?slug=' . $slug,
    'name' => $title,
  ];
}

$structuredData = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'MedicalOrganization',
    'name' => $siteName,
    'url' => $baseUrl,
    'logo' => [
      '@type'  => 'ImageObject',
      'url'    => $baseUrl . 'img/nps-logo.gif',
      'width'  => 200,
      'height' => 200,
    ],
    'description' => 'Dynamická renesancia nefrológie: od molekulárnej biológie po umelú inteligenciu.',
    'medicalSpecialty' => 'Nephrology',
    'inLanguage' => 'sk-SK',
    'sameAs' => [
      'https://polascin.com/',
      'https://nefro.sk/',
    ],
    'founder' => [
      '@type'    => 'Person',
      'name'     => 'MUDr. Ľubomír Polaščín',
      'jobTitle' => 'Lekár, Nefrológ',
      'url'      => 'https://polascin.com/',
      'sameAs'   => ['https://polascin.com/', 'https://nefro.sk/'],
    ],
    'contactPoint' => [
      '@type'       => 'ContactPoint',
      'email'       => 'nefro@polascin.net',
      'contactType' => 'customer support',
      'availableLanguage' => ['Slovak', 'Czech', 'English'],
    ],
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => $siteName,
    'url' => $baseUrl,
    'inLanguage' => 'sk-SK',
    'description' => $seoDescription,
    'potentialAction' => [
      '@type'       => 'SearchAction',
      'target'      => ['@type' => 'EntryPoint', 'urlTemplate' => $baseUrl . '?s={search_term_string}'],
      'query-input' => 'required name=search_term_string',
    ],
  ],
];

if (!empty($itemListElements)) {
  $structuredData[] = [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => $isPaginated ? ('Články – strana ' . $otherArticlesPage) : 'Články',
    'itemListElement' => $itemListElements,
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
  <!-- Logika pre Tmavý režim (na začiatku kvôli prevencii FOUC) -->
  <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bezpečnostné hlavičky (Security) -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="referrer" content="strict-origin-when-cross-origin">

  <!-- SEO & Metadata -->
  <meta name="description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES) ?>">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <meta name="author" content="MUDr. Ľubomír Polaščín">
  <meta name="keywords" content="nefrológia, CKD, chronické ochorenie obličiek, KDIGO 2024, eGFR, dialýza, transplantácia obličiek, nefrologické kalkulačky, Slovensko">
  <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES) ?>">
  <link rel="alternate" hreflang="sk-SK" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES) ?>">
  <?php if ($prevUrl !== ''): ?>
  <link rel="prev" href="<?= htmlspecialchars($prevUrl, ENT_QUOTES) ?>">
  <?php endif; ?>
  <?php if ($nextUrl !== ''): ?>
  <link rel="next" href="<?= htmlspecialchars($nextUrl, ENT_QUOTES) ?>">
  <?php endif; ?>

  <!-- Open Graph (Social SEO) -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES) ?>">
  <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES) ?>">
  <meta property="og:site_name" content="Nefro-projekt Slovensko">
  <meta property="og:locale" content="sk_SK">
  <meta property="og:image" content="https://nefro.polascin.net/img/nps-logo.gif">
  <meta property="og:image:alt" content="Logo Nefro-projekt Slovensko">
  <meta property="og:image:width" content="200">
  <meta property="og:image:height" content="200">

  <!-- Twitter Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES) ?>">
  <meta name="twitter:image" content="https://nefro.polascin.net/img/nps-logo.gif">
  <meta name="twitter:image:alt" content="Logo Nefro-projekt Slovensko">

  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?></title>

  <?php foreach ($structuredData as $schema): ?>
  <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
  <?php endforeach; ?>

  <!-- Favikony (PWA, Apple, Android, Windows) -->
  <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
  <link rel="manifest" href="./site.webmanifest">
  <link rel="shortcut icon" href="./favicon.ico">

  <!-- Prepojenie na externý CSS súbor pre moderný dizajn -->
  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">

  <!-- Google Fonts pre modernú typografiu (non-blocking preload) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap"></noscript>

  <!-- Skript pre Privacy Manager (Cookies) -->
  <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
  <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>

<body>
  <!-- Skip to content (A11y) -->
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

  <!-- <header>: Hlavička stránky alebo sekcie, zvyčajne obsahuje logo a hlavný nadpis -->
  <?php
  $headerTitle = 'Nefro-projekt Slovensko';
  $headerIntro = 'Dynamická renesancia nefrológie: Od molekulárnej biológie po umelú inteligenciu.';
  $showLogo = true;
  include 'header.php';
  ?>

  <!-- <nav>: Hlavná navigácia stránky (menu) -->
  <nav class="main-nav" aria-label="Hlavná navigácia">
    <div class="container">
      <ul>
        <li><a href="#domov" class="active" aria-current="page">Domov</a></li>
        <li><a href="#sluzby">Služby</a></li>
        <li><a href="#o-nas">O nás</a></li>
        <li><a href="#kontakt">Kontakt</a></li>
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

  <!-- <main>: Hlavný obsah stránky, ktorý je pre daný dokument unikátny -->
  <main id="main-content" class="container main-content" role="main">
    <div class="content-wrapper">

      <?php if (!empty($topArticles)): ?>
      <!-- Top články -->
      <section class="articles-top-section" id="domov" aria-labelledby="top-articles-heading">
        <h2 id="top-articles-heading" class="section-heading">Odporúčané články</h2>
        <?php foreach ($topArticles as $art):
          $artSlug    = htmlspecialchars((string) $art['slug'], ENT_QUOTES);
          $artTitle   = htmlspecialchars((string) $art['title']);
          $artExc     = htmlspecialchars(buildSeoExcerpt((string) ($art['excerpt'] ?? ''), '', 220));
          $artDate    = htmlspecialchars(formatArticleDate((string) $art['published_at']));
          $artDateIso = htmlspecialchars(substr((string) $art['published_at'], 0, 10));
        ?>
        <article class="primary-article">
          <span class="badge-top" aria-label="Odporúčaný článok">&#9733; TOP</span>
          <header>
            <h2><a href="article.php?slug=<?= $artSlug ?>" class="article-title-link"><?= $artTitle ?></a></h2>
            <p class="meta">
              Publikované:&nbsp; <time datetime="<?= $artDateIso ?>"><?= $artDate ?></time>
            </p>
          </header>
          <p class="article-excerpt"><?= $artExc ?></p>
          <a href="article.php?slug=<?= $artSlug ?>" class="read-more">Čítať ďalej &rarr;</a>
        </article>
        <?php endforeach; ?>
      </section>
      <?php endif; ?>

      <?php if (!empty($otherArticles)): ?>
      <!-- Ďalšie články -->
      <section class="articles-list-section" aria-labelledby="all-articles-heading">
        <div class="primary-article">
          <h2 id="all-articles-heading">Ďalšie články</h2>
          <ul class="articles-list" role="list">
            <?php foreach ($otherArticles as $art):
              $artSlug    = htmlspecialchars((string) $art['slug'], ENT_QUOTES);
              $artTitle   = htmlspecialchars((string) $art['title']);
              $artExc     = htmlspecialchars(buildSeoExcerpt((string) ($art['excerpt'] ?? ''), '', 220));
              $artDate    = htmlspecialchars(formatArticleDate((string) $art['published_at']));
              $artDateIso = htmlspecialchars(substr((string) $art['published_at'], 0, 10));
            ?>
            <li class="article-list-item">
              <div class="article-list-item__header">
                <a href="article.php?slug=<?= $artSlug ?>" class="article-list-item__title"><?= $artTitle ?></a>
                <time class="article-list-item__date" datetime="<?= $artDateIso ?>"><?= $artDate ?></time>
              </div>
              <p class="article-list-item__excerpt"><?= $artExc ?></p>
            </li>
            <?php endforeach; ?>
          </ul>

          <?php if ($otherArticlesTotalPages > 1): ?>
            <nav class="articles-pagination" aria-label="Stránkovanie ďalších článkov">
              <span class="articles-pagination__label">Stránky:</span>
              <div class="articles-pagination__links">
                <?php for ($p = 1; $p <= $otherArticlesTotalPages; $p++): ?>
                  <?php if ($p === $otherArticlesPage): ?>
                    <span class="articles-page-link is-active" aria-current="page"><?= $p ?></span>
                  <?php else: ?>
                    <a class="articles-page-link" href="?page=<?= $p ?>#all-articles-heading"><?= $p ?></a>
                  <?php endif; ?>
                <?php endfor; ?>
              </div>
            </nav>
          <?php endif; ?>
        </div>
      </section>
      <?php endif; ?>

      <?php if (empty($topArticles) && empty($otherArticles)): ?>
      <div class="primary-article">
        <p>Žiadne články ešte neboli zverejnené.</p>
        <?php if (isAdmin()): ?>
          <a href="admin_articles.php" class="btn-primary">Pridať prvý článok</a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <!-- Sekcia Služby -->
      <section class="features-section" id="sluzby">
        <h2>Poskytované služby a expertíza</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Nefrológia a Dialýza</h3>
            <p>
              Komplexná starostlivosť. Špecializácia na liečbu obličkových chorôb, renálnu nahradzujúcu liečbu (hemodialýza, hemodiafiltrácia, peritoneálna dialýza), ultrasonografiu orgánov brucha so zameraním na uropoetický systém, ultrasonografiu cievnych prístupov a mimotelové eliminačné metódy.
            </p>
          </div>
          <div class="feature-card">
            <h3>Lektorstvo a vzdelávanie</h3>
            <p>
              Rozsiahle skúsenosti s výučbou a odborným prednášaním predovšetkým v oblasti nefrológie a vnútorného lekárstva pre odbornú ale aj laickú verejnosť. Dlhodobá spolupráca s univerzitnými pracoviskami ako aj so spoločnosťami zaoberajúcimi sa vzdelávaním zdravotníckeho personálu.
            </p>
          </div>
          <div class="feature-card">
            <h3>Medicínske preklady</h3>
            <p>
              Špecializované preklady medicínskych dokumentov a lokalizácia softvéru (AJ/SJ) s maximálnym dôrazom na presnú klinickú terminológiu. Preklady sú vždy na vysokej odbornej úrovni, bez gramatických chýb a s dôrazom na detail.
            </p>
          </div>
          <div class="feature-card">
            <h3>IT a AI riešenia</h3>
            <p>
              Vývoj na mieru šitých medicínskych aplikácií, integrácia AI nástrojov pre spracovanie dát a modernizácia zdravotníckych systémov.
            </p>
          </div>
        </div>
      </section>

      <!-- Sekcia O nás -->
      <section class="features-section" id="o-nas">
        <h2>O mne</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Kto som</h3>
            <p>
              Som <strong>MUDr. Ľubomír Polaščín</strong> — lekár so špecializáciou v nefrológii a vnútornom lekárstve. Okrem medicíny sa aktívne venujem písaniu beletrie i odbornej literatúry a s vášňou vyvíjam webové riešenia a aplikácie. Moja práca stojí na prieniku zdravotníctva, literatúry a moderných IT technológií.
            </p>
          </div>
          <div class="feature-card">
            <h3>Odborná prax</h3>
            <p>
              Promoval som v odbore Všeobecné lekárstvo (1995), mám atestáciu z interného lekárstva (1998) a špecializáciu v nefrológii (2009). Dlhodobo sa zameriavam na dialýzu a o.i. som od roku 2013 do 2022 pôsobil ako primár a vedúci lekár v dvoch dialyzačných strediskách v Bratislave.
            </p>
          </div>
        </div>
      </section>

      <!-- Ďalšia nezávislá <section> v hlavnom obsahu -->
      <section class="features-section" id="kontakt">
        <h2>Kontakty a spolupráca</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Máte otázky alebo sa chcete zapojiť?</h3>
            <p>
              Radi uvítame akúkoľvek formu diskusie, spolupráce či dotazov. Neváhajte nás kedykoľvek kontaktovať.
            </p>
            <a href="mailto:nefro@polascin.net" class="btn-primary">Napísať e-mail</a>
          </div>
          <div class="feature-card">
            <h3>Staňte sa súčasťou komunity</h3>
            <p>
              Zaregistrujte sa a získajte prístup k obsahu. Pri registrácii si môžete zvoliť súhlas so zasielaním noviniek a my vás budeme ihneď informovať o najnovších príspevkoch a analýzach.
            </p>
            <?php if (!isLoggedIn()): ?>
              <br><a href="register.php" class="btn-primary mt-15 d-inline-block">Registrovať sa</a>
            <?php else: ?>
              <div class="badge-highlight">Ste prihlásený</div>
            <?php endif; ?>
          </div>
        </div>
      </section>
    </div>

    <!-- <aside>: Bočný panel, obsah, ktorý len okrajovo súvisí s hlavným obsahom -->
    <aside class="sidebar">
      <div class="widget">
        <h3>Náhodný obrázok</h3>
        <?php
        // Získanie všetkých obrázkov zodpovedajúcich štruktúre
        $images = glob('./img/nefro_*.png');
        if ($images && count($images) > 0) {
          // Výber náhodného obrázka
          $randomIndex = array_rand($images);
          $randomImagePath = $images[$randomIndex];

          echo '<a href="' . htmlspecialchars($randomImagePath) . '" id="randomImageLink" target="_blank" rel="noopener noreferrer" title="Zobraziť obrázok v plnej veľkosti" aria-label="Zobraziť náhodný abstraktný obrázok v plnej veľkosti">';
          echo '<img id="randomImage" src="' . htmlspecialchars($randomImagePath) . '" alt="Náhodný abstraktný obrázok Nefro">';
          echo '</a>';
        } else {
          echo "<p>\n";
          echo "Žiadne obrázky neboli nájdené.\n";
          echo "</p>";
        }
        ?>
      </div>

      <div class="widget">
        <img src="./img/nps.gif" alt="Nefro-projekt Slovensko Logo" class="header-logo">
        <h3>O projekte</h3>
        <p>
          Ako nefrológa a nadšenca pre internú medicínu ma fascinuje, akou obrovskou a dynamickou renesanciou prechádza naša nefrologická špecializácia. Sme v <?= htmlspecialchars($currentMonthYearLocative, ENT_QUOTES, 'UTF-8') ?> a nefrológia sa rozvíja míľovými krokmi. Nie je to už len o manažovaní terminálneho zlyhania obličiek a čakaní na transplantáciu. Zažívame doslova explóziu inovácií, od molekulárnej biológie až po umelú inteligenciu.
        </p>
      </div>
      <div class="widget">
        <h3>Užitočné odkazy</h3>
        <ul>
          <li><a href="https://kdigo.org/guidelines/" target="_blank" rel="noopener noreferrer">KDIGO Guidelines</a></li>
          <li><a href="https://www.era-online.org/era-guidance/" target="_blank" rel="noopener noreferrer">ERA Guidance</a></li>
          <li><a href="https://www.theisn.org/" target="_blank" rel="noopener noreferrer">International Society of Nephrology (ISN)</a></li>
          <li><a href="https://www.kidney.org/professionals/guidelines" target="_blank" rel="noopener noreferrer">National Kidney Foundation (KDOQI)</a></li>
          <li><a href="https://www.niddk.nih.gov/health-information/kidney-disease" target="_blank" rel="noopener noreferrer">NIDDK: Kidney Disease Resources</a></li>
          <li><a href="https://www.escardio.org/Guidelines" target="_blank" rel="noopener noreferrer">ESC Guidelines</a></li>
          <li><a href="https://pubmed.ncbi.nlm.nih.gov/?term=nephrology" target="_blank" rel="noopener noreferrer">PubMed: Nephrology</a></li>
          <li><a href="https://clinicaltrials.gov/search?cond=Kidney%20Diseases" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov: Kidney Diseases</a></li>
          <li class="sidebar-list-header" style="margin-top: 15px; font-weight: 700; color: var(--text-primary); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Kalkulačky</li>
          <li><a href="https://www.mdcalc.com/specialties/nephrology" target="_blank" rel="noopener noreferrer">MDCalc: Nephrology</a></li>
          <li><a href="https://qxmd.com/calculate" target="_blank" rel="noopener noreferrer">Calculate by QxMD</a></li>
          <li><a href="https://nephcalc.com/" target="_blank" rel="noopener noreferrer">NephCalc</a></li>
          <li><a href="https://www.era-online.org/clinical-practice/calculators/" target="_blank" rel="noopener noreferrer">ERA Clinical Calculators</a></li>
          <li><a href="https://clincalc.com/nephrology/" target="_blank" rel="noopener noreferrer">ClinCalc: Nephrology</a></li>
        </ul>
      </div>
      <div class="widget">
        <h3>Národné nefrologické spoločnosti</h3>
        <ul>
          <li><a href="https://www.nefro.sk/" target="_blank" rel="noopener noreferrer">Slovensko (SNS)</a></li>
          <li><a href="https://www.nefrol.cz/" target="_blank" rel="noopener noreferrer">Česko (ČNS)</a></li>
          <li><a href="https://www.asn-online.org/" target="_blank" rel="noopener noreferrer">USA (ASN)</a></li>
          <li><a href="https://www.csn-scn.ca/" target="_blank" rel="noopener noreferrer">Kanada (CSN)</a></li>
          <!-- Susedia Slovenska podľa počtu obyvateľov -->
          <li><a href="https://ptnefro.com.pl/" target="_blank" rel="noopener noreferrer">Poľsko (PTN)</a></li>
          <li><a href="http://www.nephrologia.hu/" target="_blank" rel="noopener noreferrer">Maďarsko (MANET)</a></li>
          <li><a href="https://www.nephrologie.at/" target="_blank" rel="noopener noreferrer">Rakúsko (ÖGN)</a></li>
          <!-- Ostatné krajiny podľa počtu obyvateľov -->
          <li><a href="https://nefroloji.org.tr/" target="_blank" rel="noopener noreferrer">Turecko (TND)</a></li>
          <li><a href="https://www.dgfn.eu/" target="_blank" rel="noopener noreferrer">Nemecko (DGfN)</a></li>
          <li><a href="https://www.sfndt.org/" target="_blank" rel="noopener noreferrer">Francúzsko (SFNDT)</a></li>
          <li><a href="https://sinitaly.org/" target="_blank" rel="noopener noreferrer">Taliansko (SIN)</a></li>
          <li><a href="https://www.senefro.org/" target="_blank" rel="noopener noreferrer">Španielsko (S.E.N.)</a></li>
          <li><a href="https://www.srnefro.ro/" target="_blank" rel="noopener noreferrer">Rumunsko (SRN)</a></li>
          <li><a href="https://www.nefro.nl/" target="_blank" rel="noopener noreferrer">Holandsko (NfN)</a></li>
          <li><a href="https://bvn-sbn.be/" target="_blank" rel="noopener noreferrer">Belgicko (BVN/SBN)</a></li>
          <li><a href="http://www.ene.gr/" target="_blank" rel="noopener noreferrer">Grécko (ENE)</a></li>
          <li><a href="https://njurmed.com/" target="_blank" rel="noopener noreferrer">Švédsko (SNF)</a></li>
          <li><a href="https://www.spnefro.pt/" target="_blank" rel="noopener noreferrer">Portugalsko (SPN)</a></li>
          <li><a href="http://bgnephrology.com/" target="_blank" rel="noopener noreferrer">Bulharsko (BNA)</a></li>
          <li><a href="https://nephrology.dk/" target="_blank" rel="noopener noreferrer">Dánsko (DNS)</a></li>
          <li><a href="https://www.sny.fi/" target="_blank" rel="noopener noreferrer">Fínsko (SNY)</a></li>
          <li><a href="https://www.nephro.no/" target="_blank" rel="noopener noreferrer">Nórsko (NNF)</a></li>
          <li><a href="https://irishnephrology.ie/" target="_blank" rel="noopener noreferrer">Írsko (INS)</a></li>
          <li><a href="https://www.hdndt.org/" target="_blank" rel="noopener noreferrer">Chorvátsko (HDNDT)</a></li>
          <li><a href="https://www.lndta.lt/" target="_blank" rel="noopener noreferrer">Litva (LNDTA)</a></li>
          <li><a href="http://www.nephro-slovenia.si/" target="_blank" rel="noopener noreferrer">Slovinsko (SND)</a></li>
          <li><a href="https://nefrologs.lv/" target="_blank" rel="noopener noreferrer">Lotyšsko (LNA)</a></li>
          <li><a href="https://nefro.ee/" target="_blank" rel="noopener noreferrer">Estónsko (ENS)</a></li>
          <li><a href="https://www.nek.org.cy/" target="_blank" rel="noopener noreferrer">Cyprus (CRA)</a></li>
        </ul>
      </div>

      <div class="widget">
        <h3>Organizácie nefrologických sestier</h3>
        <ul>
          <li><a href="https://www.sksapa.sk/odborne-sekcie/sekcia-sestier-pracujucich-v-nefrologii-sksapa/" target="_blank" rel="noopener noreferrer">Slovensko (SKSaPA)</a></li>
          <li><a href="https://www.cnna.cz/sekce-a-regiony/sekce-nefrologicko-urologicka/" target="_blank" rel="noopener noreferrer">Česko (ČAS)</a></li>
          <li><a href="https://www.annanurse.org/" target="_blank" rel="noopener noreferrer">USA (ANNA)</a></li>
          <li><a href="https://cannt.ca/" target="_blank" rel="noopener noreferrer">Kanada (CANNT)</a></li>
          <!-- Susedia Slovenska podľa počtu obyvateľov -->
          <li><a href="https://pspn.pl/" target="_blank" rel="noopener noreferrer">Poľsko (PSPN)</a></li>
          <li><a href="http://www.nephrologia.hu/" target="_blank" rel="noopener noreferrer">Maďarsko (MANET)</a></li>
          <li><a href="https://www.nephrologie.at/" target="_blank" rel="noopener noreferrer">Rakúsko (ÖGN)</a></li>
          <!-- Ostatné krajiny podľa počtu obyvateľov -->
          <li><a href="http://www.nefrohemsireleri.org.tr/" target="_blank" rel="noopener noreferrer">Turecko (TNDTHD)</a></li>
          <li><a href="https://www.fnb-ev.de/" target="_blank" rel="noopener noreferrer">Nemecko (fnb)</a></li>
          <li><a href="https://www.afidtn.com/" target="_blank" rel="noopener noreferrer">Francúzsko (AFIDTN)</a></li>
          <li><a href="https://www.siin.it/" target="_blank" rel="noopener noreferrer">Taliansko (SIIN)</a></li>
          <li><a href="https://www.seden.org/" target="_blank" rel="noopener noreferrer">Španielsko (SEDEN)</a></li>
          <li><a href="https://www.srnefro.ro/" target="_blank" rel="noopener noreferrer">Rumunsko (SRN)</a></li>
          <li><a href="https://www.venvn.nl/afdelingen/nefrologie/" target="_blank" rel="noopener noreferrer">Holandsko (V&VN)</a></li>
          <li><a href="https://www.bvnv.be/" target="_blank" rel="noopener noreferrer">Belgicko (BVNV)</a></li>
          <li><a href="http://www.helnna.gr/" target="_blank" rel="noopener noreferrer">Grécko (HELNNA)</a></li>
          <li><a href="https://www.snsf.eu/" target="_blank" rel="noopener noreferrer">Švédsko (SNSF)</a></li>
          <li><a href="https://www.apen.org.pt/" target="_blank" rel="noopener noreferrer">Portugalsko (APEN)</a></li>
          <li><a href="https://nursing-bg.com/" target="_blank" rel="noopener noreferrer">Bulharsko (BAHPN)</a></li>
          <li><a href="https://www.lns-nefro.dk/" target="_blank" rel="noopener noreferrer">Dánsko (DNS)</a></li>
          <li><a href="http://www.snhy.fi/" target="_blank" rel="noopener noreferrer">Fínsko (SNHY)</a></li>
          <li><a href="https://www.nsf.no/faggrupper/nefrologiske" target="_blank" rel="noopener noreferrer">Nórsko (NSF)</a></li>
          <li><a href="https://inna-ireland.com/" target="_blank" rel="noopener noreferrer">Írsko (INNA)</a></li>
          <li><a href="https://www.hdndt.org/" target="_blank" rel="noopener noreferrer">Chorvátsko (HDNDT)</a></li>
          <li><a href="https://lndta.lt/" target="_blank" rel="noopener noreferrer">Litva (LNDTA)</a></li>
          <li><a href="https://www.zbornica-zveza.si/" target="_blank" rel="noopener noreferrer">Slovinsko (Zbornica)</a></li>
          <li><a href="https://masuasociacija.lv/" target="_blank" rel="noopener noreferrer">Lotyšsko (LMA)</a></li>
          <li><a href="https://www.ena.ee/" target="_blank" rel="noopener noreferrer">Estónsko (ENA)</a></li>
          <li><a href="https://cynma.com/" target="_blank" rel="noopener noreferrer">Cyprus (CYNMA)</a></li>
        </ul>
      </div>

      <div class="widget">
        <h3>Pacientske organizácie</h3>
        <ul>
          <li><a href="https://sdat.sk/" target="_blank" rel="noopener noreferrer">Slovensko (SDaT)</a></li>
          <li><a href="https://www.ledviny.cz/" target="_blank" rel="noopener noreferrer">Česko (Společnost RTCH)</a></li>
          <li><a href="https://www.kidney.org/" target="_blank" rel="noopener noreferrer">USA (NKF)</a></li>
          <li><a href="https://kidney.ca/" target="_blank" rel="noopener noreferrer">Kanada (Kidney Foundation)</a></li>
          <!-- Susedia Slovenska podľa počtu obyvateľov -->
          <li><a href="https://osod.info/" target="_blank" rel="noopener noreferrer">Poľsko (OSOD)</a></li>
          <li><a href="https://vese-alapitvany.hu/" target="_blank" rel="noopener noreferrer">Maďarsko (MVA)</a></li>
          <li><a href="https://www.argeniere.at/" target="_blank" rel="noopener noreferrer">Rakúsko (ARGE Niere)</a></li>
          <!-- Ostatné krajiny podľa počtu obyvateľov -->
          <li><a href="https://www.tbv.com.tr/" target="_blank" rel="noopener noreferrer">Turecko (TBV)</a></li>
          <li><a href="https://www.bundesverband-niere.de/" target="_blank" rel="noopener noreferrer">Nemecko (BV Niere)</a></li>
          <li><a href="https://www.francerein.org/" target="_blank" rel="noopener noreferrer">Francúzsko (France Rein)</a></li>
          <li><a href="https://www.aned-onlus.it/" target="_blank" rel="noopener noreferrer">Taliansko (ANED)</a></li>
          <li><a href="https://alcer.org/" target="_blank" rel="noopener noreferrer">Španielsko (ALCER)</a></li>
          <li><a href="https://apar.ro/" target="_blank" rel="noopener noreferrer">Rumunsko (APAR)</a></li>
          <li><a href="https://nierstichting.nl/" target="_blank" rel="noopener noreferrer">Holandsko (Nierstichting)</a></li>
          <li><a href="http://www.fenier-fabir.be/" target="_blank" rel="noopener noreferrer">Belgicko (Fenier-Fabir)</a></li>
          <li><a href="http://www.pasynef.gr/" target="_blank" rel="noopener noreferrer">Grécko (PASYNEF)</a></li>
          <li><a href="https://njurforbundet.se/" target="_blank" rel="noopener noreferrer">Švédsko (Njurförbundet)</a></li>
          <li><a href="https://www.apir.org.pt/" target="_blank" rel="noopener noreferrer">Portugalsko (APIR)</a></li>
          <li><a href="http://www.bgri-bg.org/" target="_blank" rel="noopener noreferrer">Bulharsko (BUTD)</a></li>
          <li><a href="https://nyreforeningen.dk/" target="_blank" rel="noopener noreferrer">Dánsko (Nyreforeningen)</a></li>
          <li><a href="https://www.munuaisjamaksaliitto.fi/" target="_blank" rel="noopener noreferrer">Fínsko (Munuais- ja maksaliitto)</a></li>
          <li><a href="https://www.lnt.no/" target="_blank" rel="noopener noreferrer">Nórsko (LNT)</a></li>
          <li><a href="https://ika.ie/" target="_blank" rel="noopener noreferrer">Írsko (IKA)</a></li>
          <li><a href="https://transplant.hr/" target="_blank" rel="noopener noreferrer">Chorvátsko (HUT)</a></li>
          <li><a href="https://geraviltis.lt/" target="_blank" rel="noopener noreferrer">Litva (Gera viltis)</a></li>
          <li><a href="https://www.zveza-ledvica.si/" target="_blank" rel="noopener noreferrer">Slovinsko (ZDLBS)</a></li>
          <li><a href="http://www.nieras.lv/" target="_blank" rel="noopener noreferrer">Lotyšsko (Nieras.lv)</a></li>
          <li><a href="https://www.neeruliit.ee/" target="_blank" rel="noopener noreferrer">Estónsko (ENL)</a></li>
          <li><a href="http://www.nefropathes.org.cy/" target="_blank" rel="noopener noreferrer">Cyprus (CKA)</a></li>
        </ul>
      </div>
    </aside>
  </main>

  <?php include 'footer.php'; ?>
  