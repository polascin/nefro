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
  $pageTitle = "Interaktívny algoritmus hyponatrémie | Nástroje | " . $siteName;
  $canonicalUrl = $baseUrl . "nastroj_hyponatremia.php";
  $seoDescription =
      "Interaktívny diagnostický algoritmus hyponatrémie krok za krokom: osmolalita (pravá vs. nehypotonická), závažnosť/symptómy, objemový stav, močový sodík a osmolalita — s diferenciálnou diagnostikou (SIADH, hypovolémia, hypervolémia) a manažmentom vrátane rizika ODS.";
  $seoKeywords =
      "hyponatrémia, algoritmus, SIADH, osmotický demyelinizačný syndróm, ODS, objemový stav, močový sodík, Adrogue-Madias, Katz, nefrológia, Slovensko";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => ["WebApplication", "MedicalWebPage"],
          "name" => "Interaktívny algoritmus hyponatrémie",
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
                  "name" => "Algoritmus hyponatrémie",
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
    $headerTitle = "Algoritmus hyponatrémie";
    $headerIntro = "Interaktívny diagnostický sprievodca";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Diagnostický algoritmus hyponatrémie</h2>
                <p class="auth-subtitle">Interaktívny krok-za-krokom sprievodca: tonicita → závažnosť → objemový stav → močový sodík a osmolalita, s diferenciálnou diagnostikou a princípmi manažmentu.</p>

                <p>
                    Nástroj vás prevedie štruktúrovaným postupom podľa odpovedí na cielené otázky.
                    Slúži ako orientačná pomôcka pre klinické rozhodovanie — <strong>nenahrádza</strong>
                    vyšetrenie pacienta, laboratórium ani individuálne posúdenie. Pri korekcii vždy
                    rešpektujte limity a <strong>riziko osmotického demyelinizačného syndrómu (ODS)</strong>.
                </p>

                <!-- Interaktívny sprievodca (vyžaduje JavaScript) -->
                <section class="tool-widget" aria-labelledby="hypona-tool-heading">
                    <h3 id="hypona-tool-heading" class="visually-hidden">Interaktívny sprievodca</h3>
                    <div id="hyponatremia-tool" class="tool-mount" role="region" aria-live="polite" aria-label="Interaktívny algoritmus hyponatrémie"></div>
                    <noscript>
                        <div class="alert alert-error">
                            <p>Interaktívny sprievodca vyžaduje zapnutý JavaScript. Nižšie nájdete statickú
                            referenčnú verziu celého diagnostického algoritmu.</p>
                        </div>
                    </noscript>
                </section>

                <!-- Statická referencia: algoritmus -->
                <section class="form-section" aria-labelledby="algo-heading">
                    <h3 id="algo-heading">Diagnostický algoritmus — prehľad</h3>
                    <ol class="tool-step__list">
                        <li><strong>Potvrdiť pravú (hypotonickú) hyponatrémiu</strong> — sérová osmolalita: nízka (&lt; 275) = pravá; normálna/vysoká = pseudo- alebo hypertonická (korekcia Na na glykémiu).</li>
                        <li><strong>Posúdiť závažnosť a rýchlosť vzniku</strong> — ťažké symptómy (kŕče, kóma, vracanie) = urgentná liečba 3 % NaCl bez ohľadu na príčinu; rešpektovať limity korekcie (ODS).</li>
                        <li><strong>Posúdiť objemový stav</strong> — hypovolémia / euvolémia / hypervolémia.</li>
                        <li><strong>Doplniť kľúčové laboratórium</strong> — močový sodík a močová osmolalita podľa objemu.</li>
                    </ol>
                    <table class="tool-table">
                        <caption class="visually-hidden">Diferenciálna diagnostika hypotonickej hyponatrémie podľa objemu a moču</caption>
                        <thead>
                            <tr><th scope="col">Objemový stav</th><th scope="col">Kľúčové laboratórium</th><th scope="col">Typické príčiny</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">Hypovolémia</th><td>U-Na &lt; 30 (extrarenálne) / U-Na &gt; 30 (renálne)</td><td>GIT straty, tretí priestor / diuretiká, Addison, CSW</td></tr>
                            <tr><th scope="row">Euvolémia</th><td>U-osm &gt; 100 / U-osm &lt; 100</td><td>SIADH (vylúčiť hypotyreózu a hypokortizolizmus) / primárna polydipsia, nízky príjem solútov</td></tr>
                            <tr><th scope="row">Hypervolémia</th><td>U-Na zvyčajne &lt; 30 (okrem CKD/diuretík)</td><td>srdcové zlyhávanie, cirhóza, nefrotický syndróm, pokročilé CKD</td></tr>
                        </tbody>
                    </table>
                    <div class="info-box-green">
                        <strong>Limity korekcie (ODS):</strong> spravidla neprekročiť ~8–10 mmol/l za 24 h
                        (pri vysokom riziku ≤ 6–8 mmol/l/24 h). Rizikoví: chronická hyponatrémia, alkoholizmus,
                        malnutrícia, hypokaliémia, choroba pečene. Na plánovanie korekcie využite kalkulačku
                        porúch sodíka (Adrogue-Madias).
                    </div>
                </section>

                <div class="form-actions no-print">
                    <a href="nastroje.php" class="btn-secondary">← Späť na nástroje</a>
                    <a href="calculator_na.php" class="btn-secondary">Kalkulačka porúch sodíka a vody</a>
                </div>
            </div>

            <?php include "calculator_disclaimer.php"; ?>

            <section class="form-section" aria-labelledby="zdroje-heading">
                <h3 id="zdroje-heading">Zdroje</h3>
                <ul class="tool-step__list">
                    <li>Spasovski G, et al. Clinical practice guideline on diagnosis and treatment of hyponatraemia. <em>Nephrol Dial Transplant.</em> 2014;29(Suppl 2):i1–i39.</li>
                    <li>Verbalis JG, et al. Diagnosis, evaluation, and treatment of hyponatremia: expert panel recommendations. <em>Am J Med.</em> 2013;126(10 Suppl 1):S1–S42.</li>
                    <li>Adrogué HJ, Madias NE. Hyponatremia. <em>N Engl J Med.</em> 2000;342(21):1581–1589.</li>
                </ul>
            </section>
        </div>
    </main>

    <script src="nastroj_engine.js?v=<?= filemtime(__DIR__ . '/nastroj_engine.js') ?>" defer></script>
    <script src="nastroj_hyponatremia.js?v=<?= filemtime(__DIR__ . '/nastroj_hyponatremia.js') ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
