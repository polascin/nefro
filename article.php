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
    '@type'    => ['Article', 'MedicalWebPage'],
    'headline' => $articleTitleRaw,
    'description' => $metaDescriptionRaw,
    'inLanguage'  => 'sk-SK',
    'mainEntityOfPage' => $canonicalUrlRaw,
    'url'         => $canonicalUrlRaw,
    'datePublished' => toIso8601((string) ($article['published_at'] ?? '')),
    'dateModified'  => toIso8601((string) ($article['updated_at'] ?? ($article['published_at'] ?? ''))),
    'medicalSpecialty' => 'Nephrology',
    'audience' => [
      '@type'       => 'MedicalAudience',
      'audienceType' => 'Clinician',
    ],
    'author' => [
      '@type'  => 'Person',
      'name'   => $articleAuthorRaw,
      'sameAs' => 'https://polascin.com/',
    ],
    'publisher' => [
      '@type' => 'MedicalOrganization',
      'name'  => $siteName,
      'logo'  => [
        '@type' => 'ImageObject',
        'url'   => $baseUrl . 'img/nps-logo.gif',
        'width' => 200,
        'height' => 200,
      ],
    ],
    'image' => [
      '@type'  => 'ImageObject',
      'url'    => $baseUrl . 'img/nps-logo.gif',
      'width'  => 200,
      'height' => 200,
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
  <meta name="author" content="MUDr. Ľubomír Polaščín">
  <meta name="keywords" content="nefrológia, CKD, chronické ochorenie obličiek, KDIGO, dialýza, transplantácia obličiek, Slovensko, <?= htmlspecialchars(mb_substr($articleTitleRaw, 0, 60), ENT_QUOTES) ?>">
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
  <meta property="og:image:width" content="200">
  <meta property="og:image:height" content="200">

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

          <?= $article['content'] /* Dôverované HTML — správuje iba admin */ ?>

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
          <li><a href="https://www.era-online.org/era-guidance/" target="_blank" rel="noopener noreferrer">ERA Guidance</a></li>
          <li><a href="https://www.theisn.org/" target="_blank" rel="noopener noreferrer">International Society of Nephrology</a></li>
          <li><a href="https://www.kidney.org/professionals/guidelines" target="_blank" rel="noopener noreferrer">National Kidney Foundation (KDOQI)</a></li>
          <li><a href="https://pubmed.ncbi.nlm.nih.gov/?term=nephrology" target="_blank" rel="noopener noreferrer">PubMed: Nephrology</a></li>
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
          <li><a href="https://www.nephro.no/" target="_blank" rel="noopener noreferrer">Nórsko (NNF)</a></li>
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
</body>
</html>
