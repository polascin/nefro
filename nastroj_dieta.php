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
  $pageTitle = "Plánovač renálnej diéty | Nástroje | " . $siteName;
  $canonicalUrl = $baseUrl . "nastroj_dieta.php";
  $seoDescription =
      "Plánovač renálnej diéty — z telesnej hmotnosti a kategórie (CKD bez dialýzy, hemodialýza, peritoneálna dialýza) vypočíta orientačné denné cieľové limity bielkovín, sodíka, draslíka, fosforu a energie podľa KDOQI 2020.";
  $seoKeywords =
      "renálna diéta, CKD diéta, bielkoviny, sodík, draslík, fosfor, KDOQI, dialýza, výživa pri ochorení obličiek, nefrológia, Slovensko";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => ["WebApplication", "MedicalWebPage"],
          "name" => "Plánovač renálnej diéty",
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
                  "name" => "Plánovač renálnej diéty",
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
    $headerTitle = "Plánovač renálnej diéty";
    $headerIntro = "Orientačné denné cieľové limity živín";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Plánovač renálnej diéty — cieľové denné limity</h2>
                <p class="auth-subtitle">Z telesnej hmotnosti a klinickej kategórie vypočíta orientačné denné ciele pre bielkoviny, energiu, sodík, draslík a fosfor podľa KDOQI 2020.</p>

                <p>
                    Nástroj je orientačná pomôcka a <strong>nenahrádza</strong> individuálne nutričné
                    poradenstvo. Hodnoty vždy prispôsobte reziduálnej funkcii obličiek, laboratóriu,
                    komorbiditám a nutričnému stavu — ideálne v spolupráci s renálnym dietológom.
                </p>

                <form id="dieta-form" class="tool-widget" novalidate>
                    <div class="form-section">
                        <h3>Vstupné údaje</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="dieta-weight">Telesná hmotnosť (kg) <span class="required">*</span></label>
                                <input type="text" inputmode="decimal" id="dieta-weight" class="form-control" placeholder="napr. 70" autocomplete="off">
                                <p class="tool-option__hint">Ideálne ideálna/upravená telesná hmotnosť.</p>
                            </div>
                            <div class="form-group">
                                <label for="dieta-category">Klinická kategória <span class="required">*</span></label>
                                <select id="dieta-category" class="form-control">
                                    <option value="">— vyberte —</option>
                                    <option value="ckd_nd">CKD G3–G5 bez dialýzy, bez diabetu</option>
                                    <option value="ckd_nd_dm">CKD G3–G5 bez dialýzy, s diabetom</option>
                                    <option value="hd">Hemodialýza</option>
                                    <option value="pd">Peritoneálna dialýza</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group form-group--check">
                                <label><input type="checkbox" id="dieta-hyperk"> Prítomná hyperkaliémia</label>
                            </div>
                            <div class="form-group form-group--check">
                                <label><input type="checkbox" id="dieta-hyperp"> Prítomná hyperfosfatémia</label>
                            </div>
                        </div>
                        <div class="form-actions no-print">
                            <button type="button" id="dieta-calc-btn" class="btn-primary">Vypočítať limity</button>
                            <a href="nastroje.php" class="btn-secondary">← Späť na nástroje</a>
                        </div>
                        <div id="dieta-error" class="dieta-error" role="alert" aria-live="assertive"></div>
                    </div>
                </form>

                <div id="dieta-result" class="tool-mount" role="status" aria-live="polite" aria-label="Vypočítané cieľové limity"></div>

                <noscript>
                    <div class="alert alert-error">
                        <p>Plánovač vyžaduje zapnutý JavaScript. Nižšie nájdete statickú referenčnú
                        tabuľku cieľových limitov podľa KDOQI 2020.</p>
                    </div>
                </noscript>

                <!-- Statická referencia -->
                <section class="form-section" aria-labelledby="ref-heading">
                    <h3 id="ref-heading">Referenčné cieľové limity (KDOQI 2020)</h3>
                    <table class="tool-table">
                        <caption class="visually-hidden">Cieľové denné limity živín podľa kategórie</caption>
                        <thead>
                            <tr><th scope="col">Kategória</th><th scope="col">Bielkoviny</th><th scope="col">Energia</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">CKD G3–G5 ND, bez diabetu</th><td>0,55–0,60 g/kg/deň</td><td rowspan="4">25–35 kcal/kg/deň</td></tr>
                            <tr><th scope="row">CKD G3–G5 ND, s diabetom</th><td>0,60–0,80 g/kg/deň</td></tr>
                            <tr><th scope="row">Hemodialýza</th><td>1,0–1,2 g/kg/deň</td></tr>
                            <tr><th scope="row">Peritoneálna dialýza</th><td>1,0–1,2 g/kg/deň</td></tr>
                        </tbody>
                    </table>
                    <div class="info-box-blue">
                        <strong>Spoločné ciele:</strong> sodík &lt; 2 300 mg/deň (&lt; 100 mmol; ≈ &lt; 5–6 g soli);
                        fosfor ≈ 800–1 000 mg/deň (prednostne obmedziť anorganické aditíva); draslík
                        individualizovať podľa kalémie (pri hyperkaliémii ≈ 2 000–3 000 mg/deň).
                    </div>
                    <div class="info-box-green">
                        <strong>Dôležité:</strong> dostatočný energetický príjem je nevyhnutný na prevenciu
                        malnutrície a katabolizmu bielkovín. Veľmi nízkobielkovinová diéta s keto-analógmi
                        patrí pod odborný dohľad.
                    </div>
                </section>

                <div class="form-actions no-print">
                    <a href="calculator_egfr.php" class="btn-secondary">eGFR kalkulačka</a>
                    <a href="calculators.php" class="btn-secondary">Kalkulačky</a>
                </div>
            </div>

            <?php include "calculator_disclaimer.php"; ?>

            <section class="form-section" aria-labelledby="zdroje-heading">
                <h3 id="zdroje-heading">Zdroje</h3>
                <ul class="tool-step__list">
                    <li>Ikizler TA, et al. KDOQI Clinical Practice Guideline for Nutrition in CKD: 2020 Update. <em>Am J Kidney Dis.</em> 2020;76(3 Suppl 1):S1–S107.</li>
                    <li>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of CKD. <em>Kidney Int.</em> 2024;105(4S):S117–S314.</li>
                </ul>
            </section>
        </div>
    </main>

    <script src="nastroj_dieta.js?v=<?= filemtime(__DIR__ . '/nastroj_dieta.js') ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
