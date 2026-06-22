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
  $pageTitle = "Interaktívny sprievodca diagnostikou AKI | Nástroje | " . $siteName;
  $canonicalUrl = $baseUrl . "nastroj_aki.php";
  $seoDescription =
      "Interaktívny diferenciálne-diagnostický sprievodca akútnym poškodením obličiek (AKI) podľa KDIGO: krok za krokom prerenálne, renálne (ATN, AIN, glomerulárne, vaskulárne) a postrenálne príčiny s odporúčaným vyšetrením a manažmentom.";
  $seoKeywords =
      "AKI, akútne poškodenie obličiek, diferenciálna diagnostika, KDIGO, prerenálne, ATN, intersticiálna nefritída, RPGN, interaktívny nástroj, nefrológia, Slovensko";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => ["WebApplication", "MedicalWebPage"],
          "name" => "Interaktívny sprievodca diagnostikou AKI",
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
                  "name" => "Sprievodca diagnostikou AKI",
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
    $headerTitle = "Sprievodca diagnostikou AKI";
    $headerIntro = "Interaktívny diferenciálne-diagnostický nástroj (KDIGO)";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Diferenciálna diagnostika akútneho poškodenia obličiek (AKI)</h2>
                <p class="auth-subtitle">Interaktívny krok-za-krokom sprievodca: potvrdenie AKI a triáž príčin (postrenálne → prerenálne → intrinsické) s odporúčaným vyšetrením a manažmentom.</p>

                <p>
                    Nástroj vás prevedie štruktúrovaným postupom podľa odpovedí na cielené otázky.
                    Slúži ako orientačná pomôcka pre klinické rozhodovanie — <strong>nenahrádza</strong>
                    vyšetrenie pacienta, močový sediment, laboratórium ani individuálne posúdenie.
                </p>

                <!-- Interaktívny sprievodca (vyžaduje JavaScript) -->
                <section class="tool-widget" aria-labelledby="aki-tool-heading">
                    <h3 id="aki-tool-heading" class="visually-hidden">Interaktívny sprievodca</h3>
                    <div id="aki-tool" class="tool-mount" role="region" aria-live="polite" aria-label="Interaktívny sprievodca diagnostikou AKI"></div>
                    <noscript>
                        <div class="alert alert-error">
                            <p>Interaktívny sprievodca vyžaduje zapnutý JavaScript. Nižšie nájdete statickú
                            referenčnú verziu celého diagnostického algoritmu.</p>
                        </div>
                    </noscript>
                </section>

                <!-- Statická referencia: KDIGO definícia a štádiá -->
                <section class="form-section" aria-labelledby="kdigo-heading">
                    <h3 id="kdigo-heading">Definícia a štádiá AKI (KDIGO 2012)</h3>
                    <div class="info-box-blue">
                        <p><strong>AKI</strong> = aspoň jedno z kritérií: vzostup S-kreatinínu o ≥ 26,5 µmol/l
                        (0,3 mg/dl) za 48 h; alebo na ≥ 1,5-násobok východiska za 7 dní; alebo diuréza
                        &lt; 0,5 ml/kg/h počas ≥ 6 h.</p>
                    </div>
                    <table class="tool-table">
                        <caption class="visually-hidden">Štádiá AKI podľa KDIGO</caption>
                        <thead>
                            <tr><th scope="col">Štádium</th><th scope="col">Sérový kreatinín</th><th scope="col">Diuréza</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">1</th><td>1,5–1,9× východisko alebo ↑ ≥ 26,5 µmol/l</td><td>&lt; 0,5 ml/kg/h počas 6–12 h</td></tr>
                            <tr><th scope="row">2</th><td>2,0–2,9× východisko</td><td>&lt; 0,5 ml/kg/h počas ≥ 12 h</td></tr>
                            <tr><th scope="row">3</th><td>≥ 3,0× východisko, alebo SCr ≥ 353,6 µmol/l, alebo začatie KRT</td><td>&lt; 0,3 ml/kg/h počas ≥ 24 h alebo anúria ≥ 12 h</td></tr>
                        </tbody>
                    </table>
                </section>

                <!-- Statická referencia: algoritmus -->
                <section class="form-section" aria-labelledby="algo-heading">
                    <h3 id="algo-heading">Diagnostický algoritmus — prehľad</h3>
                    <ol class="tool-step__list">
                        <li><strong>Potvrdiť AKI a štádium</strong> (KDIGO; odlíšiť od CKD / AKI on CKD).</li>
                        <li><strong>Vylúčiť postrenálnu (obštrukčnú) príčinu</strong> — USG (hydronefróza), močový katéter. Často rýchlo reverzibilné.</li>
                        <li><strong>Posúdiť prerenálnu (hypoperfúznu) príčinu</strong> — volémia, FENa &lt; 1 % / FEUrea &lt; 35 %, bland sediment, reakcia na korekciu perfúzie.</li>
                        <li><strong>Intrinsické (renálne) AKI</strong> podľa kompartmentu:
                            <ul class="tool-step__list">
                                <li><strong>Tubulárne (ATN)</strong> — granulárne valce; ischemické/toxické/pigmentové.</li>
                                <li><strong>Intersticiálne (AIN)</strong> — leukocytové valce, eozinofília, lieky (PPI, NSA, ATB).</li>
                                <li><strong>Glomerulárne (nefritické/RPGN)</strong> — erytrocytové valce, dysmorfné erytrocyty, proteinúria; urgentná imunológia + biopsia.</li>
                                <li><strong>Vaskulárne/mikroangiopatické</strong> — TMA (TTP/HUS/aHUS), ateroembolizmus; schistocyty, ↑LDH.</li>
                            </ul>
                        </li>
                    </ol>
                    <div class="info-box-green">
                        <strong>Spoločné opatrenia pri každom AKI:</strong> revízia a vysadenie nefrotoxínov,
                        úprava dávkovania liekov podľa funkcie obličiek, manažment volémie, draslíka a
                        acidobázy, vyhnúť sa kontrastným látkam ak je to možné a sledovať indikácie KRT.
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
                    <li>KDIGO Clinical Practice Guideline for Acute Kidney Injury. <em>Kidney Int Suppl.</em> 2012;2(1):1–138.</li>
                    <li>Mehta RL, et al. Acute Kidney Injury Network (AKIN). <em>Crit Care.</em> 2007;11:R31.</li>
                    <li>Rahman M, Shad F, Smith MC. Acute Kidney Injury: A Guide to Diagnosis and Management. <em>Am Fam Physician.</em> 2012;86(7):631–639.</li>
                </ul>
            </section>
        </div>
    </main>

    <script src="nastroj_aki.js?v=<?= filemtime(__DIR__ . '/nastroj_aki.js') ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
