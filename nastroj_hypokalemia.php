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
  $pageTitle = "Interaktívny sprievodca hypokaliémiou | Nástroje | " . $siteName;
  $canonicalUrl = $baseUrl . "nastroj_hypokalemia.php";
  $seoDescription =
      "Interaktívny diagnostický a manažmentový sprievodca hypokaliémiou krok za krokom: závažnosť/EKG, transcelulárny presun, močový draslík, acidobáza, krvný tlak a močový chlorid — s diferenciálnou diagnostikou (RTA, hyperaldosteronizmus, Bartter/Gitelman) a dôrazom na korekciu magnézia.";
  $seoKeywords =
      "hypokaliémia, draslík, algoritmus, TTKG, močový draslík, renálna tubulárna acidóza, hyperaldosteronizmus, Bartter, Gitelman, magnézium, nefrológia, Slovensko";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => ["WebApplication", "MedicalWebPage"],
          "name" => "Interaktívny sprievodca hypokaliémiou",
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
                  "name" => "Sprievodca hypokaliémiou",
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
    $headerTitle = "Sprievodca hypokaliémiou";
    $headerIntro = "Interaktívny diagnostický a manažmentový nástroj";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Diagnostika a manažment hypokaliémie</h2>
                <p class="auth-subtitle">Interaktívny krok-za-krokom sprievodca: závažnosť → transcelulárny presun → močový draslík → acidobáza → krvný tlak → močový chlorid, s diferenciálnou diagnostikou a princípmi liečby.</p>

                <p>
                    Nástroj vás prevedie štruktúrovaným postupom podľa odpovedí na cielené otázky.
                    Slúži ako orientačná pomôcka pre klinické rozhodovanie — <strong>nenahrádza</strong>
                    vyšetrenie pacienta, EKG, laboratórium ani individuálne posúdenie. Pri každej
                    hypokaliémii <strong>zmerajte a korigujte magnézium</strong> (hypomagneziémia spôsobuje
                    refraktérnu hypokaliémiu).
                </p>

                <!-- Interaktívny sprievodca (vyžaduje JavaScript) -->
                <section class="tool-widget" aria-labelledby="hypok-tool-heading">
                    <h3 id="hypok-tool-heading" class="visually-hidden">Interaktívny sprievodca</h3>
                    <div id="hypokalemia-tool" class="tool-mount" role="region" aria-live="polite" aria-label="Interaktívny sprievodca hypokaliémiou"></div>
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
                        <li><strong>Posúdiť závažnosť a naliehavosť</strong> — K &lt; 2,5, symptómy, EKG zmeny alebo digoxín = urgentná i.v. substitúcia pod monitoringom.</li>
                        <li><strong>Vylúčiť transcelulárny presun</strong> — inzulín, β2-agonisty, alkalóza, refeeding, periodická paralýza (celkový telesný K býva normálny).</li>
                        <li><strong>Močový draslík</strong> — nízky (U-K &lt; 15, U-K:Cr &lt; 1,5) = extrarenálna strata/nízky príjem; vysoký = renálna strata.</li>
                        <li><strong>Pri renálnej strate acidobáza</strong> — acidóza (RTA, DKA) vs alkalóza.</li>
                        <li><strong>Pri alkalóze krvný tlak</strong> — hypertenzia = mineralokortikoidový nadbytok (ARR); normotenzia → močový chlorid.</li>
                        <li><strong>Močový chlorid</strong> — nízky = chloridom responzívna (vracanie, predošlé diuretiká); vysoký = rezistentná (aktuálne diuretiká, Bartter/Gitelman, deplécia Mg).</li>
                    </ol>
                    <table class="tool-table">
                        <caption class="visually-hidden">Diferenciálna diagnostika renálnej straty draslíka</caption>
                        <thead>
                            <tr><th scope="col">Acidobáza / TK</th><th scope="col">Ďalší rozlišovač</th><th scope="col">Typické príčiny</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">Metabolická acidóza</th><td>pH moču, anión-gap, ketolátky</td><td>RTA (typ 1/2), diabetická ketoacidóza, diverzie moču</td></tr>
                            <tr><th scope="row">Alkalóza + hypertenzia</th><td>aldosterón : renín (ARR)</td><td>primárny hyperaldosteronizmus, Cushing, Liddle, drievko</td></tr>
                            <tr><th scope="row">Alkalóza + normotenzia</th><td>močový chlorid</td><td>U-Cl nízky: vracanie, predošlé diuretiká · U-Cl vysoký: aktuálne diuretiká, Bartter/Gitelman</td></tr>
                        </tbody>
                    </table>
                    <div class="info-box-green">
                        <strong>Vždy magnézium:</strong> hypomagneziémia (časté pri diuretikách, hnačke,
                        alkoholizme) zvyšuje renálnu stratu draslíka a robí hypokaliémiu refraktérnou na
                        samotnú substitúciu K — bez korekcie Mg sa kalémia neupraví.
                    </div>
                </section>

                <div class="form-actions no-print">
                    <a href="nastroje.php" class="btn-secondary">← Späť na nástroje</a>
                    <a href="calculator_acidbase.php" class="btn-secondary">Kalkulačka acidobázy</a>
                </div>
            </div>

            <?php include "calculator_disclaimer.php"; ?>

            <section class="form-section" aria-labelledby="zdroje-heading">
                <h3 id="zdroje-heading">Zdroje</h3>
                <ul class="tool-step__list">
                    <li>Gennari FJ. Hypokalemia. <em>N Engl J Med.</em> 1998;339(7):451–458.</li>
                    <li>Viera AJ, Wouk N. Potassium Disorders: Hypokalemia and Hyperkalemia. <em>Am Fam Physician.</em> 2015;92(6):487–495.</li>
                    <li>Kardalas E, et al. Hypokalemia: a clinical update. <em>Endocr Connect.</em> 2018;7(4):R135–R146.</li>
                </ul>
            </section>
        </div>
    </main>

    <script src="nastroj_engine.js?v=<?= filemtime(__DIR__ . '/nastroj_engine.js') ?>" defer></script>
    <script src="nastroj_hypokalemia.js?v=<?= filemtime(__DIR__ . '/nastroj_hypokalemia.js') ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
