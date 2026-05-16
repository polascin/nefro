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
$pageTitle = 'Nefrologické kalkulačky | ' . $siteName;
$pageDesc  = 'Klinické kalkulačky pre nefrológiu podľa KDIGO 2024: eGFR (CKD-EPI 2021), KDIGO G/A riziko, KFRE predikcia dialýzy, CKD-PC Grams 2022, IgAN Prediction Tool a Mayo ADPKD klasifikácia. Pre zdravotníckych pracovníkov na Slovensku.';
$ogImage   = $baseUrl . 'img/nps-logo.gif';

$schemaWebApp = [
  '@context'    => 'https://schema.org',
  '@type'       => ['WebApplication', 'MedicalWebPage'],
  'name'        => 'Nefrologické kalkulačky — Nefro-projekt Slovensko',
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
    ['@type' => 'WebApplication', 'name' => 'IgAN Prediction Tool (Barbour 2019)',  'url' => $baseUrl . 'calculator_igan.php'],
    ['@type' => 'WebApplication', 'name' => 'Mayo ADPKD klasifikácia (Irazabal 2015)', 'url' => $baseUrl . 'calculator_adpkd.php'],
    ['@type' => 'WebApplication', 'name' => 'FENa / FEUrea (AKI)', 'url' => $baseUrl . 'calculator_aki.php'],
    ['@type' => 'WebApplication', 'name' => 'Cockcroft-Gault (Klírens kreatinínu)', 'url' => $baseUrl . 'calculator_cg.php'],
    ['@type' => 'WebApplication', 'name' => 'Korigovaný vápnik pri hypoalbuminémii', 'url' => $baseUrl . 'calculator_ca.php'],
    ['@type' => 'WebApplication', 'name' => 'Poruchy sodíka a vody', 'url' => $baseUrl . 'calculator_na.php'],
    ['@type' => 'WebApplication', 'name' => 'Aniónová medzera a Delta Ratio', 'url' => $baseUrl . 'calculator_acidbase.php'],
    ['@type' => 'WebApplication', 'name' => 'Rýchlosť poklesu eGFR (Slope)', 'url' => $baseUrl . 'calculator_egfr_slope.php'],
    ['@type' => 'WebApplication', 'name' => 'Kt/V a URR (Adekvátnosť HD)', 'url' => $baseUrl . 'calculator_ktv.php'],
    ['@type' => 'WebApplication', 'name' => 'UACR a KDIGO klasifikácia', 'url' => $baseUrl . 'calculator_uacr.php'],
  ],
];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  // Mapovanie premenných pre head_meta.php
  $seoDescription = $pageDesc;
  $seoKeywords = "eGFR kalkulačka, KDIGO 2024, CKD riziko, KFRE, CKD-PC, nefrológia, chronické ochorenie obličiek, Slovensko";
  $canonicalUrl = $pageUrl;
  
  $structuredData = [];
  if (isset($schemaWebApp)) {
      $structuredData[] = $schemaWebApp;
  }
  
  // Pridanie Breadcrumbs
  $structuredData[] = [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
          [
              '@type' => 'ListItem',
              'position' => 1,
              'name' => 'Domov',
              'item' => $baseUrl
          ],
          [
              '@type' => 'ListItem',
              'position' => 2,
              'name' => 'Kalkulačky',
              'item' => $pageUrl
          ]
      ]
  ];

  include 'head_meta.php';
  ?>
</head>

<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Nefrologické kalkulačky';
    $headerIntro = '';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <button class="menu-toggle" id="menuToggle" aria-label="Otvoriť menu" aria-expanded="false">
                <span>Menu</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
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
            <section class="calculator-hero">
                <img src="img/nefro_13.png" alt="Nefrologické kalkulačky - Nástroje pre klinickú prax" class="calculator-hero__img" loading="eager">
            </section>

            <section class="primary-article">
                <h1 class="visually-hidden">Nefrologické kalkulačky</h1>
                <p>
                    Klinické výpočty sú určené na orientačnú podporu klinického rozhodovania. Údaje pacienta
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

            <section class="features-section" aria-labelledby="aki-calculators-heading">
                <h2 id="aki-calculators-heading">Akútne poškodenie obličiek (AKI)</h2>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h3>FENa a FEUrea</h3>
                        <p>Frakčná exkrécia sodíka a urey pre diferenciálnu diagnostiku AKI (prerenálne vs. renálne zlyhanie).</p>
                        <a href="calculator_aki.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                </div>
            </section>

            <section class="features-section" aria-labelledby="dosing-calculators-heading">
                <h2 id="dosing-calculators-heading">Úprava dávkovania liekov</h2>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h3>Cockcroft-Gault</h3>
                        <p>Odhad klírensu kreatinínu, historický štandard pre farmakokinetickú úpravu dávkovania liekov.</p>
                        <a href="calculator_cg.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                </div>
            </section>

            <section class="features-section" aria-labelledby="lytes-calculators-heading">
                <h2 id="lytes-calculators-heading">Elektrolytové a acidobázické poruchy</h2>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h3>Korigovaný vápnik</h3>
                        <p>Prepočet celkového vápnika vzhľadom na hladinu albumínu (časté pri CKD-MBD s hypoalbuminémiou).</p>
                        <a href="calculator_ca.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                    <article class="feature-card calculator-card">
                        <h3>Poruchy sodíka a vody</h3>
                        <p>Deficit voľnej vody pri hypernatrémii a Adrogue-Madiasova rovnica pre bezpečnú korekciu hyponatrémie.</p>
                        <a href="calculator_na.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                    <article class="feature-card calculator-card">
                        <h3>Aniónová medzera a &Delta;/&Delta;</h3>
                        <p>Základný nástroj na diferenciálnu diagnostiku a identifikáciu zmiešaných porúch acidobázickej rovnováhy.</p>
                        <a href="calculator_acidbase.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                </div>
            </section>

            <section class="features-section" aria-labelledby="progression-calculators-heading">
                <h2 id="progression-calculators-heading">Progresia CKD a Dialýza</h2>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h3>eGFR Slope</h3>
                        <p>Výpočet lineárneho trendu (rýchlosti poklesu eGFR) z viacerých meraní v čase (identifikácia rýchlych progresorov).</p>
                        <a href="calculator_egfr_slope.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                    <article class="feature-card calculator-card">
                        <h3>Kt/V a URR</h3>
                        <p>Hodnotenie adekvátnosti hemodialýzy podľa Daugirdasovej rovnice (2. generácia) a pomeru redukcie urey.</p>
                        <a href="calculator_ktv.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                </div>
            </section>

            <section class="features-section" aria-labelledby="proteinuria-calculators-heading">
                <h2 id="proteinuria-calculators-heading">Analýza proteinúrie</h2>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h3>UACR a KDIGO klasifikácia</h3>
                        <p>Univerzálny prevodník jednotiek pre UACR s okamžitým zaradením do KDIGO kategórií (A1-A3).</p>
                        <a href="calculator_uacr.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                </div>
            </section>

            <section class="features-section" aria-labelledby="spec-calculators-heading">
                <h2 id="spec-calculators-heading">Diagnózovo špecifické kalkulačky</h2>
                <p style="margin-bottom:16px;font-size:0.92rem;opacity:0.8;">KDIGO 2024 odporúča pre niektoré ochorenia obličiek použiť externálne validované, diagnózovo špecifické prognostické nástroje.</p>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h3>IgAN Prediction Tool</h3>
                        <p>Odhad 5-ročného rizika poklesu eGFR o ≥50 % alebo ESKD pri IgA nefropatii. Klinický model (Barbour 2019) bez požiadavky na histológiu.</p>
                        <a href="calculator_igan.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h3>Mayo ADPKD klasifikácia</h3>
                        <p>Zaradenie pacienta s ADPKD do tried 1A–1E podľa HtTKV a veku (Irazabal 2015). Pomáha pri indikácii tolvaptanu a sledovaní progresie.</p>
                        <a href="calculator_adpkd.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                </div>
            </section>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
