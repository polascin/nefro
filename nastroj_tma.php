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
  $pageTitle = "Interaktívny sprievodca trombotickou mikroangiopatiou (TMA) | Nástroje | " . $siteName;
  $canonicalUrl = $baseUrl . "nastroj_tma.php";
  $seoDescription =
      "Interaktívny diferenciálne-diagnostický sprievodca trombotickou mikroangiopatiou (TMA): potvrdenie MAHA a trombocytopénie, odlíšenie TTP (ADAMTS13/PLASMIC), STEC-HUS, atypického HUS (komplement) a sekundárnej TMA s princípmi manažmentu (plazmaferéza, eculizumab).";
  $seoKeywords =
      "trombotická mikroangiopatia, TMA, TTP, ADAMTS13, PLASMIC, HUS, STEC, atypický HUS, aHUS, komplement, eculizumab, MAHA, schistocyty, plazmaferéza, interaktívny nástroj, nefrológia, Slovensko";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => ["WebApplication", "MedicalWebPage"],
          "name" => "Interaktívny sprievodca trombotickou mikroangiopatiou (TMA)",
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
              ["@type" => "ListItem", "position" => 1, "name" => "Domov", "item" => $baseUrl],
              ["@type" => "ListItem", "position" => 2, "name" => "Nástroje", "item" => $baseUrl . "nastroje.php"],
              ["@type" => "ListItem", "position" => 3, "name" => "Sprievodca trombotickou mikroangiopatiou (TMA)", "item" => $canonicalUrl],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Sprievodca TMA";
    $headerIntro = "Interaktívny diferenciálne-diagnostický nástroj pre trombotickú mikroangiopatiu";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Trombotická mikroangiopatia (TMA) — diferenciálna diagnostika</h2>
                <p class="auth-subtitle">Interaktívny krok-za-krokom sprievodca: potvrdenie MAHA a trombocytopénie, odlíšenie TTP, STEC-HUS, atypického HUS a sekundárnej TMA s princípmi manažmentu.</p>

                <p>
                    Nástroj vás prevedie štruktúrovaným postupom podľa odpovedí na cielené otázky.
                    Slúži ako orientačná pomôcka — <strong>nenahrádza</strong> ADAMTS13, komplementové a STEC
                    vyšetrenie ani klinický úsudok. <strong>TMA je urgentná:</strong> pri podozrení na TTP odoberte
                    ADAMTS13 ešte pred podaním plazmy a neodkladajte plazmaferézu.
                </p>

                <!-- Interaktívny sprievodca (vyžaduje JavaScript) -->
                <section class="tool-widget" aria-labelledby="tma-tool-heading">
                    <h3 id="tma-tool-heading" class="visually-hidden">Interaktívny sprievodca</h3>
                    <div id="tma-tool" class="tool-mount" role="region" aria-live="polite" aria-label="Interaktívny sprievodca trombotickou mikroangiopatiou"></div>
                    <noscript>
                        <div class="alert alert-error">
                            <p>Interaktívny sprievodca vyžaduje zapnutý JavaScript. Nižšie nájdete statickú
                            referenčnú verziu diferenciálnej diagnostiky.</p>
                        </div>
                    </noscript>
                </section>

                <!-- Statická referencia: odlíšenie jednotiek -->
                <section class="form-section" aria-labelledby="dif-heading">
                    <h3 id="dif-heading">Odlíšenie hlavných jednotiek TMA</h3>
                    <table class="tool-table">
                        <caption class="visually-hidden">Diferenciálna diagnostika TTP, STEC-HUS, aHUS a sekundárnej TMA</caption>
                        <thead>
                            <tr><th scope="col">Jednotka</th><th scope="col">Kľúčové znaky</th><th scope="col">Test</th><th scope="col">Liečba</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">TTP</th><td>Výrazná trombocytopénia, neurológia, obličky relatívne ušetrené</td><td>ADAMTS13 &lt; 10 %</td><td>Plazmaferéza + steroidy, kaplacizumab</td></tr>
                            <tr><th scope="row">STEC-HUS</th><td>Krvavá hnačka, dieťa, dominuje AKI</td><td>Stolica STEC / Shiga toxín</td><td>Podporná; nie ATB/antimotiliká</td></tr>
                            <tr><th scope="row">Atypický HUS</th><td>Renálne dominantné, bez hnačky, relapsy/rodinná anamnéza</td><td>Komplement, genetika, anti-CFH</td><td>Eculizumab/ravulizumab</td></tr>
                            <tr><th scope="row">Sekundárna</th><td>Liek, malignita, ťažká HTN, gravidita/HELLP, sepsa, autoimunita</td><td>Podľa spúšťača</td><td>Liečiť príčinu</td></tr>
                        </tbody>
                    </table>
                </section>

                <!-- Statická referencia: algoritmus -->
                <section class="form-section" aria-labelledby="algo-heading">
                    <h3 id="algo-heading">Diagnostický algoritmus — prehľad</h3>
                    <ol class="tool-step__list">
                        <li><strong>Potvrdiť TMA</strong> — MAHA (schistocyty, ↑LDH, ↓haptoglobín, negat. Coombs) + trombocytopénia.</li>
                        <li><strong>Odobrať pred liečbou</strong> — ADAMTS13 (pred plazmou), komplement, stolica STEC; tehotenský test, autoprotilátky, revízia liekov, TK.</li>
                        <li><strong>Posúdiť pravdepodobnosť TTP</strong> — PLASMIC skóre; pri vysokej pravdepodobnosti neodkladná plazmaferéza.</li>
                        <li><strong>Odlíšiť (a)HUS a sekundárne</strong> — STEC vs komplement vs identifikovateľný spúšťač.</li>
                        <li><strong>Cielená liečba</strong> — TTP: PLEX; aHUS: eculizumab; STEC-HUS: podporná; sekundárna: liečba príčiny.</li>
                    </ol>
                    <div class="info-box-green">
                        <strong>Pozor:</strong> transfúzia trombocytov pri TTP len pri život ohrozujúcom krvácaní;
                        eculizumab vyžaduje predchádzajúcu vakcináciu proti meningokokom (± antibiotická profylaxia).
                    </div>
                </section>

                <div class="form-actions no-print">
                    <a href="nastroje.php" class="btn-secondary">← Späť na nástroje</a>
                    <a href="calculator_plasmic.php" class="btn-secondary">Kalkulačka PLASMIC (TTP)</a>
                    <a href="article.php?slug=cheatsheet-komplement" class="btn-secondary">Ťahák: komplement</a>
                </div>
            </div>

            <?php include "calculator_disclaimer.php"; ?>

            <section class="form-section" aria-labelledby="zdroje-heading">
                <h3 id="zdroje-heading">Zdroje</h3>
                <ul class="tool-step__list">
                    <li>George JN, Nester CM. Syndromes of thrombotic microangiopathy. <em>N Engl J Med.</em> 2014;371(7):654–666.</li>
                    <li>Bendapudi PK, et al. Derivation and validation of the PLASMIC score. <em>Lancet Haematol.</em> 2017;4(4):e157–e164.</li>
                    <li>Brocklebank V, Wood KM, Kavanagh D. Thrombotic Microangiopathy and the Kidney. <em>Clin J Am Soc Nephrol.</em> 2018;13(2):300–317.</li>
                </ul>
            </section>
        </div>
    </main>

    <script src="nastroj_engine.js?v=<?= filemtime(__DIR__ . '/nastroj_engine.js') ?>" defer></script>
    <script src="nastroj_tma.js?v=<?= filemtime(__DIR__ . '/nastroj_tma.js') ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
