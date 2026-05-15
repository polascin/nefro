<?php
require_once 'auth.php';
require_once 'db_config.php';

header_remove('X-Powered-By');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=()');

$csp = "default-src 'self'; "
  . "img-src 'self' data: https:; "
  . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
  . "font-src 'self' https://fonts.gstatic.com; "
  . "script-src 'self' https://www.googletagmanager.com https://www.google-analytics.com; "
  . "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com https://analytics.google.com https://*.analytics.google.com https://stats.g.doubleclick.net; "
  . "base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; upgrade-insecure-requests";
header('Content-Security-Policy: ' . $csp);

$pageLastUpdated = date('d.m.Y H:i', filemtime(__FILE__));
$pageTimeZone = date('T') . ' (' . date_default_timezone_get() . ')';

$siteName  = 'Nefro-projekt Slovensko';
$baseUrl   = 'https://nefro.polascin.net/';
$pageUrl   = $baseUrl . 'calculators.php';
$pageTitle = 'Kalkulačky KDIGO 2024 CKD | ' . $siteName;
$pageDesc  = 'Klinické kalkulačky pre CKD podľa KDIGO 2024: eGFR (CKD-EPI 2021), KDIGO G/A riziko, KFRE predikcia dialýzy a CKD-PC Grams 2022. Určené pre zdravotníckych pracovníkov na Slovensku.';
$ogImage   = $baseUrl . 'img/nps-logo.gif';

$schemaWebApp = [
  '@context'    => 'https://schema.org',
  '@type'       => ['WebApplication', 'MedicalWebPage'],
  'name'        => 'Kalkulačky KDIGO 2024 — Nefro-projekt Slovensko',
  'description' => $pageDesc,
  'url'         => $pageUrl,
  'inLanguage'  => 'sk-SK',
  'applicationCategory' => 'HealthApplication',
  'operatingSystem'     => 'Web',
  'medicalSpecialty'    => 'Nephrology',
  'audience'    => [
    '@type' => 'MedicalAudience',
    'audienceType' => 'Clinician',
  ],
  'publisher' => [
    '@type' => 'MedicalOrganization',
    'name'  => $siteName,
    'url'   => $baseUrl,
    'logo'  => ['@type' => 'ImageObject', 'url' => $ogImage],
  ],
  'hasPart' => [
    ['@type' => 'WebApplication', 'name' => 'eGFR kalkulačka (CKD-EPI 2021)',       'url' => $baseUrl . 'calculator_egfr.php'],
    ['@type' => 'WebApplication', 'name' => 'KDIGO G/A riziko CKD',                  'url' => $baseUrl . 'calculator_kdigo_risk.php'],
    ['@type' => 'WebApplication', 'name' => 'KFRE — Kidney Failure Risk Equation',   'url' => $baseUrl . 'calculator_kfre.php'],
    ['@type' => 'WebApplication', 'name' => 'CKD-PC — Grams 2022 (3-ročné riziko)', 'url' => $baseUrl . 'calculator_ckdpc.php'],
  ],
];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <!-- SEO & Metadata -->
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDesc, ENT_QUOTES) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="author" content="MUDr. Ľubomír Polaščín">
    <meta name="keywords" content="eGFR kalkulačka, KDIGO 2024, CKD riziko, KFRE, CKD-PC, nefrológia, chronické ochorenie obličiek, Slovensko">
    <link rel="canonical" href="<?= htmlspecialchars($pageUrl, ENT_QUOTES) ?>">
    <link rel="alternate" hreflang="sk-SK" href="<?= htmlspecialchars($pageUrl, ENT_QUOTES) ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDesc, ENT_QUOTES) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($pageUrl, ENT_QUOTES) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($siteName, ENT_QUOTES) ?>">
    <meta property="og:locale" content="sk_SK">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
    <meta property="og:image:alt" content="Logo Nefro-projekt Slovensko">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDesc, ENT_QUOTES) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
    <meta name="twitter:image:alt" content="Logo Nefro-projekt Slovensko">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json"><?= json_encode($schemaWebApp, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>

    <!-- Favikony (PWA, Apple, Android, Windows) -->
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
    <link rel="shortcut icon" href="./favicon.ico">

    <!-- Preload kritických zdrojov -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap"></noscript>

    <!-- Logika pre Tmavý režim (na začiatku kvôli prevencii FOUC) -->
    <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">

    <!-- Skript pre Privacy Manager (Cookies) -->
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>

<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Kalkulačky';
    $headerIntro = 'Klinické výpočty podľa KDIGO 2024 pre CKD';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="index.php#sluzby">Služby</a></li>
                <li><a href="index.php#o-nas">O nás</a></li>
                <li><a href="index.php#kontakt">Kontakt</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulačky</a></li>
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

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <section class="primary-article">
                <h1>Kalkulačky KDIGO 2024 CKD</h1>
                <p>
                    Výpočty sú určené na orientačnú podporu klinického rozhodovania. Údaje pacienta
                    (meno, priezvisko, dátum narodenia, rodné číslo, kód zdravotnej poisťovne) sú voliteľné.
                    Údaje potrebné pre výpočet sú povinné.
                </p>
                <p>
                    Prihlásený používateľ môže výsledok uložiť do databázy. Uložené výsledky sa zobrazia
                    v spodnej časti každej kalkulačky s možnosťou vytlačenia alebo vymazania.
                </p>
            </section>

            <section class="features-section" aria-labelledby="calculators-heading">
                <h2 id="calculators-heading">Dostupné kalkulačky</h2>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h3>eGFR (CKD-EPI 2021)</h3>
                        <p>Výpočet odhadovanej glomerulovej filtrácie z veku, pohlavia a kreatinínu.</p>
                        <a href="calculator_egfr.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h3>KDIGO G/A riziko CKD</h3>
                        <p>Zaradenie do G a A kategórie a orientačný rizikový stupeň podľa KDIGO mapy.</p>
                        <a href="calculator_kdigo_risk.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h3>KFRE — Kidney Failure Risk Equation</h3>
                        <p>Predikcia rizika potreby dialýzy alebo transplantácie obličky na 2 a 5 rokov (Tangri 4-parametrová).</p>
                        <a href="calculator_kfre.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h3>CKD-PC — Grams 2022 (3-ročné riziko)</h3>
                        <p>Odhad 3-ročného rizika poklesu eGFR o ≥40 % alebo zlyhania obličiek — platné pre všetky štádiá CKD vrátane G1–G2. Rozšírený model s 13+ vstupmi.</p>
                        <a href="calculator_ckdpc.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                </div>
            </section>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
