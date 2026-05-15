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
    'logo' => $baseUrl . 'img/nps-logo.gif',
    'description' => 'Dynamická renesancia nefrológie: od molekulárnej biológie po umelú inteligenciu.',
    'medicalSpecialty' => 'Nephrology',
    'founder' => [
      '@type' => 'Person',
      'name' => 'MUDr. Ľubomír Polaščín',
      'jobTitle' => 'Lekár, Nefrológ',
      'url' => 'https://polascin.com/',
    ],
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => $siteName,
    'url' => $baseUrl,
    'inLanguage' => 'sk-SK',
    'description' => $seoDescription,
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
  <meta name="author" content="Dr. Ľubomír Polaščín">
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

  <!-- Twitter Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES) ?>">
  <meta name="twitter:image" content="https://nefro.polascin.net/img/nps-logo.gif">

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

  <!-- Google Fonts pre modernú typografiu -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">

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
          <li><a href="https://www.era-online.org/guidelines/" target="_blank" rel="noopener noreferrer">ERA Guidelines</a></li>
          <li><a href="https://www.theisn.org/" target="_blank" rel="noopener noreferrer">International Society of Nephrology (ISN)</a></li>
          <li><a href="https://www.kidney.org/professionals/guidelines" target="_blank" rel="noopener noreferrer">National Kidney Foundation (KDOQI)</a></li>
          <li><a href="https://www.niddk.nih.gov/health-information/kidney-disease" target="_blank" rel="noopener noreferrer">NIDDK: Kidney Disease Resources</a></li>
          <li><a href="https://www.escardio.org/Guidelines" target="_blank" rel="noopener noreferrer">ESC Guidelines</a></li>
          <li><a href="https://pubmed.ncbi.nlm.nih.gov/?term=nephrology" target="_blank" rel="noopener noreferrer">PubMed: Nephrology</a></li>
          <li><a href="https://clinicaltrials.gov/search?cond=Kidney%20Diseases" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov: Kidney Diseases</a></li>
        </ul>
      </div>
    </aside>
  </main>

  <?php include 'footer.php'; ?>
  