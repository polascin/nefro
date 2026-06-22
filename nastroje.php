<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";
$pageUrl = $baseUrl . "nastroje.php";
$pageTitle = "Interaktívne nefrologické nástroje | " . $siteName;
$pageDesc =
    "Interaktívne klinické nástroje pre nefrológiu — krok-za-krokom diagnostické a rozhodovacie sprievodcovia. Diferenciálna diagnostika akútneho poškodenia obličiek (AKI) podľa KDIGO; ďalšie nástroje pripravujeme.";

$schemaWebApp = [
    "@context" => "https://schema.org",
    "@type" => ["WebApplication", "MedicalWebPage"],
    "name" => "Interaktívne nefrologické nástroje — " . $siteName,
    "description" => $pageDesc,
    "url" => $pageUrl,
    "inLanguage" => "sk-SK",
    "applicationCategory" => "HealthApplication",
    "operatingSystem" => "Web",
    "medicalSpecialty" => "Nephrology",
    "audience" => [
        "@type" => "MedicalAudience",
        "audienceType" => "Clinician",
    ],
    "isAccessibleForFree" => true,
    "publisher" => [
        "@type" => "MedicalOrganization",
        "name" => $siteName,
        "url" => $baseUrl,
        "logo" => ["@type" => "ImageObject", "url" => $baseUrl . "img/nps-logo.png"],
    ],
    "hasPart" => [
        [
            "@type" => "WebApplication",
            "name" => "Sprievodca diagnostikou AKI",
            "url" => $baseUrl . "nastroj_aki.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Algoritmus hyponatrémie",
            "url" => $baseUrl . "nastroj_hyponatremia.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Sprievodca hypokaliémiou",
            "url" => $baseUrl . "nastroj_hypokalemia.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Plánovač renálnej diéty",
            "url" => $baseUrl . "nastroj_dieta.php",
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $seoDescription = $pageDesc;
  $seoKeywords =
      "interaktívne nástroje, AKI, akútne poškodenie obličiek, diagnostický algoritmus, KDIGO, nefrológia, rozhodovací strom, Slovensko";
  $canonicalUrl = $pageUrl;

  $structuredData = [$schemaWebApp];
  $structuredData[] = [
      "@context" => "https://schema.org",
      "@type" => "BreadcrumbList",
      "itemListElement" => [
          [
              "@type" => "ListItem",
              "position" => 1,
              "name" => "Domov",
              "item" => $baseUrl,
          ],
          [
              "@type" => "ListItem",
              "position" => 2,
              "name" => "Nástroje",
              "item" => $pageUrl,
          ],
      ],
  ];

  include "head_meta.php";
  ?>
</head>

<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Interaktívne nástroje";
    $headerIntro = "";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <section class="calculator-hero">
                <img src="img/nefro_14.png" alt="Interaktívne nefrologické nástroje - rozhodovacie sprievodcovia" class="calculator-hero__img" loading="eager">
            </section>

            <section class="primary-article">
                <h1 class="visually-hidden">Interaktívne nefrologické nástroje</h1>
                <p>
                    Interaktívne nástroje vás krok za krokom prevedú diagnostickým alebo rozhodovacím
                    postupom. Na rozdiel od kalkulačiek nepočítajú jednu hodnotu — kladú cielené otázky
                    a podľa odpovedí navrhujú pravdepodobnú kategóriu, odporúčané vyšetrenie a princípy
                    manažmentu. Sú orientačnou pomôckou a <strong>nenahrádzajú</strong> klinické vyšetrenie.
                </p>
            </section>

            <section class="features-section" aria-labelledby="tools-heading">
                <h2 id="tools-heading">Dostupné nástroje</h2>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h3>Sprievodca diagnostikou AKI</h3>
                        <p>Diferenciálna diagnostika akútneho poškodenia obličiek podľa KDIGO — potvrdenie AKI a triáž príčin (postrenálne, prerenálne, ATN, AIN, glomerulárne, vaskulárne) s odporúčaným vyšetrením a manažmentom.</p>
                        <a href="nastroj_aki.php" class="btn-primary">Otvoriť nástroj</a>
                    </article>
                    <article class="feature-card calculator-card">
                        <h3>Algoritmus hyponatrémie</h3>
                        <p>Diagnostický postup pri hyponatrémii — tonicita (osmolalita), závažnosť/symptómy, objemový stav a močové parametre (U-Na, U-osm) s diferenciálnou diagnostikou (SIADH, hypovolémia, hypervolémia) a limitmi korekcie (ODS).</p>
                        <a href="nastroj_hyponatremia.php" class="btn-primary">Otvoriť nástroj</a>
                    </article>
                    <article class="feature-card calculator-card">
                        <h3>Sprievodca hypokaliémiou</h3>
                        <p>Diagnostika a manažment hypokaliémie — závažnosť/EKG, transcelulárny presun, močový draslík, acidobáza, krvný tlak a močový chlorid; diferenciálna diagnostika (RTA, hyperaldosteronizmus, Bartter/Gitelman) s dôrazom na korekciu magnézia.</p>
                        <a href="nastroj_hypokalemia.php" class="btn-primary">Otvoriť nástroj</a>
                    </article>
                    <article class="feature-card calculator-card">
                        <h3>Plánovač renálnej diéty</h3>
                        <p>Z telesnej hmotnosti a kategórie (CKD bez dialýzy, hemodialýza, peritoneálna dialýza) vypočíta orientačné denné cieľové limity bielkovín, energie, sodíka, draslíka a fosforu podľa KDOQI 2020.</p>
                        <a href="nastroj_dieta.php" class="btn-primary">Otvoriť nástroj</a>
                    </article>
                </div>
            </section>
        </div>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>
