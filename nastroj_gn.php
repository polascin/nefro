<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Interaktívny sprievodca diagnostikou glomerulonefritíd | Nástroje | " . $siteName;
  $canonicalUrl = $baseUrl . "nastroj_gn.php";
  $seoDescription =
      "Interaktívny diferenciálne-diagnostický sprievodca glomerulonefritídami: nefritický vs nefrotický obraz, RPGN (ANCA, anti-GBM, imunokomplexová), rozdelenie podľa komplementu (postinfekčná, lupus, MPGN/C3G, kryoglobulinemická, IgA) a nefrotické jednotky (MCD, membranózna, FSGS, diabetická, sekundárne) s odporúčaným vyšetrením a manažmentom.";
  $seoKeywords =
      "glomerulonefritída, GN, diferenciálna diagnostika, nefritický syndróm, nefrotický syndróm, RPGN, ANCA, anti-GBM, IgA nefropatia, lupusová nefritída, membranózna nefropatia, FSGS, komplement, interaktívny nástroj, nefrológia, Slovensko";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => ["WebApplication", "MedicalWebPage"],
          "name" => "Interaktívny sprievodca diagnostikou glomerulonefritíd",
          "description" => $seoDescription,
          "url" => $canonicalUrl,
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
          ],
      ],
      [
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
                  "item" => $baseUrl . "nastroje.php",
              ],
              [
                  "@type" => "ListItem",
                  "position" => 3,
                  "name" => "Sprievodca diagnostikou glomerulonefritíd",
                  "item" => $canonicalUrl,
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Sprievodca diagnostikou GN";
    $headerIntro = "Interaktívny diferenciálne-diagnostický nástroj pre glomerulonefritídy";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Diferenciálna diagnostika glomerulonefritíd (GN)</h2>
                <p class="auth-subtitle">Interaktívny krok-za-krokom sprievodca: nefritický vs nefrotický obraz, tempo progresie (RPGN), komplement a konkrétne jednotky s odporúčaným vyšetrením a manažmentom.</p>

                <p>
                    Nástroj vás prevedie štruktúrovaným postupom podľa odpovedí na cielené otázky.
                    Slúži ako orientačná pomôcka pre klinické rozhodovanie — <strong>nenahrádza</strong>
                    renálnu biopsiu, sérológiu, močový sediment ani individuálne posúdenie. Mnohé
                    glomerulopatie majú prekrývajúce sa prejavy.
                </p>

                <!-- Interaktívny sprievodca (vyžaduje JavaScript) -->
                <section class="tool-widget" aria-labelledby="gn-tool-heading">
                    <h3 id="gn-tool-heading" class="visually-hidden">Interaktívny sprievodca</h3>
                    <div id="gn-tool" class="tool-mount" role="region" aria-live="polite" aria-label="Interaktívny sprievodca diagnostikou glomerulonefritíd"></div>
                    <noscript>
                        <div class="alert alert-error">
                            <p>Interaktívny sprievodca vyžaduje zapnutý JavaScript. Nižšie nájdete statickú
                            referenčnú verziu diagnostického algoritmu.</p>
                        </div>
                    </noscript>
                </section>

                <!-- Statická referencia: nefritický vs nefrotický -->
                <section class="form-section" aria-labelledby="syndrom-heading">
                    <h3 id="syndrom-heading">Nefritický vs nefrotický syndróm</h3>
                    <table class="tool-table">
                        <caption class="visually-hidden">Porovnanie nefritického a nefrotického syndrómu</caption>
                        <thead>
                            <tr><th scope="col">Znak</th><th scope="col">Nefritický</th><th scope="col">Nefrotický</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">Proteinúria</th><td>zvyčajne &lt; 3,5 g/deň</td><td>≥ 3,5 g/deň</td></tr>
                            <tr><th scope="row">Sediment</th><td>aktívny: dysmorfné ERY, ERY valce</td><td>neaktívny („bland"), tukové telieska</td></tr>
                            <tr><th scope="row">Hematúria</th><td>výrazná (glomerulárna)</td><td>mierna alebo žiadna</td></tr>
                            <tr><th scope="row">Hypertenzia / pokles GFR</th><td>časté</td><td>premenlivé</td></tr>
                            <tr><th scope="row">Albumín / lipidy / edémy</th><td>premenlivé</td><td>hypoalbuminémia, hyperlipidémia, edémy</td></tr>
                        </tbody>
                    </table>
                </section>

                <!-- Statická referencia: nefritída podľa komplementu -->
                <section class="form-section" aria-labelledby="komplement-heading">
                    <h3 id="komplement-heading">Nefritída podľa komplementu</h3>
                    <table class="tool-table">
                        <caption class="visually-hidden">Diferenciálna diagnostika nefritídy podľa hladiny komplementu</caption>
                        <thead>
                            <tr><th scope="col">Nízky komplement</th><th scope="col">Normálny komplement</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Postinfekčná GN (↓C3, normalizuje sa)</td><td>IgA nefropatia / IgA vaskulitída</td></tr>
                            <tr><td>Lupusová nefritída (↓C3 aj C4)</td><td>ANCA-asociovaná vaskulitída (pauci-imunitná)</td></tr>
                            <tr><td>MPGN / C3 glomerulopatia (perzistentne ↓C3)</td><td>Anti-GBM choroba</td></tr>
                            <tr><td>Kryoglobulinemická GN (↓↓C4, často HCV)</td><td>Hereditárna (Alport) / tenké membrány</td></tr>
                        </tbody>
                    </table>
                </section>

                <!-- Statická referencia: algoritmus -->
                <section class="form-section" aria-labelledby="algo-heading">
                    <h3 id="algo-heading">Diagnostický algoritmus — prehľad</h3>
                    <ol class="tool-step__list">
                        <li><strong>Zaradiť obraz</strong> — nefritický (aktívny sediment) vs nefrotický (proteinúria ≥ 3,5 g, hypoalbuminémia).</li>
                        <li><strong>Posúdiť tempo</strong> — rýchly vzostup kreatinínu (dni–týždne) = RPGN: urgentná imunológia a biopsia.</li>
                        <li><strong>RPGN podľa imunológie</strong> — pauci-imunitná (ANCA), anti-GBM (lineárny IF), imunokomplexová (granulárny IF).</li>
                        <li><strong>Stabilná nefritída podľa komplementu</strong> — nízky vs normálny zužuje diferenciál (pozri tabuľku).</li>
                        <li><strong>Nefrotický</strong> — najprv diabetická nefropatia (najčastejšia), potom podľa veku/kontextu MCD, membranózna (anti-PLA2R), FSGS, sekundárne (amyloid, paraproteín).</li>
                    </ol>
                    <div class="info-box-green">
                        <strong>Spoločné renoprotektívne opatrenia:</strong> kontrola TK a proteinúrie (RAAS blokáda),
                        SGLT2 inhibítor podľa indikácie, manažment edémov, lipidov a kardiovaskulárneho rizika,
                        revízia nefrotoxínov a — pri aktívnej alebo rýchlo progredujúcej GN — včasná nefrologická
                        konzultácia a biopsia.
                    </div>
                </section>

                <div class="form-actions no-print">
                    <a href="nastroje.php" class="btn-secondary">← Späť na nástroje</a>
                    <a href="calculators.php" class="btn-secondary">Kalkulačky</a>
                </div>
            </div>

            <?php include "calculator_disclaimer.php"; ?>

            <section class="form-section" aria-labelledby="zdroje-heading">
                <h3 id="zdroje-heading">Zdroje</h3>
                <ul class="tool-step__list">
                    <li>KDIGO 2024 Clinical Practice Guideline for the Management of Glomerular Diseases. <em>Kidney Int.</em> 2024.</li>
                    <li>Sethi S, Fervenza FC. Standardized Classification and Reporting of Glomerulonephritis. <em>Nephrol Dial Transplant.</em> 2019;34(2):193–199.</li>
                    <li>Hebert LA, et al. Diagnostic significance of hypocomplementemia. <em>Kidney Int.</em> 1991;39(5):811–821.</li>
                </ul>
            </section>
        </div>
    </main>

    <script src="nastroj_engine.js?v=<?= filemtime(__DIR__ . '/nastroj_engine.js') ?>" defer></script>
    <script src="nastroj_gn.js?v=<?= filemtime(__DIR__ . '/nastroj_gn.js') ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
