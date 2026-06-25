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
  $pageTitle = "Interaktívny sprievodca syndrómom rozpadu nádoru (TLS) | Nástroje | " . $siteName;
  $canonicalUrl = $baseUrl . "nastroj_tls.php";
  $seoDescription =
      "Interaktívny sprievodca syndrómom rozpadu nádoru (TLS): stratifikácia rizika podľa typu a nálože nádoru aj faktorov pacienta, voľba profylaxie (hydratácia, alopurinol, rasburikáza) a manažment etablovaného TLS vrátane indikácií dialýzy. Cairo–Bishop, Howard 2011.";
  $seoKeywords =
      "syndróm rozpadu nádoru, TLS, tumor lysis syndrome, rasburikáza, alopurinol, hyperkaliémia, hyperfosfatémia, hyperurikémia, urátová nefropatia, Cairo-Bishop, onkonefrológia, interaktívny nástroj, nefrológia, Slovensko";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => ["WebApplication", "MedicalWebPage"],
          "name" => "Interaktívny sprievodca syndrómom rozpadu nádoru (TLS)",
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
              ["@type" => "ListItem", "position" => 3, "name" => "Sprievodca syndrómom rozpadu nádoru (TLS)", "item" => $canonicalUrl],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Sprievodca TLS";
    $headerIntro = "Interaktívny nástroj — riziko, profylaxia a manažment syndrómu rozpadu nádoru";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Syndróm rozpadu nádoru (TLS) — riziko, profylaxia a manažment</h2>
                <p class="auth-subtitle">Interaktívny krok-za-krokom sprievodca: stratifikácia rizika podľa nádoru a pacienta, voľba profylaxie a manažment etablovaného TLS vrátane indikácií dialýzy.</p>

                <p>
                    Nástroj vás prevedie štruktúrovaným postupom podľa odpovedí na cielené otázky.
                    Slúži ako orientačná pomôcka pre klinické rozhodovanie — <strong>nenahrádza</strong>
                    individuálne posúdenie rizika, aktuálne onkologické a nefrologické odporúčania ani
                    klinický úsudok. Na klasifikáciu etablovaného TLS použite kalkulačku Cairo–Bishop.
                </p>

                <!-- Interaktívny sprievodca (vyžaduje JavaScript) -->
                <section class="tool-widget" aria-labelledby="tls-tool-heading">
                    <h3 id="tls-tool-heading" class="visually-hidden">Interaktívny sprievodca</h3>
                    <div id="tls-tool" class="tool-mount" role="region" aria-live="polite" aria-label="Interaktívny sprievodca syndrómom rozpadu nádoru"></div>
                    <noscript>
                        <div class="alert alert-error">
                            <p>Interaktívny sprievodca vyžaduje zapnutý JavaScript. Nižšie nájdete statickú
                            referenčnú verziu stratifikácie rizika a profylaxie.</p>
                        </div>
                    </noscript>
                </section>

                <!-- Statická referencia: stratifikácia rizika a profylaxia -->
                <section class="form-section" aria-labelledby="risk-heading">
                    <h3 id="risk-heading">Stratifikácia rizika a profylaxia</h3>
                    <table class="tool-table">
                        <caption class="visually-hidden">Rizikové kategórie TLS a odporúčaná profylaxia</caption>
                        <thead>
                            <tr><th scope="col">Riziko</th><th scope="col">Typický kontext</th><th scope="col">Profylaxia</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">Vysoké</th><td>Burkitt, ALL/lymfoblastový lymfóm, vysoký WBC, bulky, vysoké LDH; + rizikový pacient</td><td>Hydratácia + <strong>rasburikáza</strong>, častý monitoring</td></tr>
                            <tr><th scope="row">Stredné</th><td>Väčšina agresívnych NHL, AML, cielená liečba CLL</td><td>Hydratácia + <strong>alopurinol</strong>, eskalácia podľa potreby</td></tr>
                            <tr><th scope="row">Nízke</th><td>Väčšina solídnych nádorov, indolentné hematologické</td><td>Hydratácia + sledovanie</td></tr>
                        </tbody>
                    </table>
                </section>

                <!-- Statická referencia: metabolické poruchy -->
                <section class="form-section" aria-labelledby="lab-heading">
                    <h3 id="lab-heading">Metabolické poruchy pri TLS</h3>
                    <ul class="tool-step__list">
                        <li><strong>Hyperurikémia</strong> → urátová kryštálová nefropatia; rasburikáza rozkladá urát, alopurinol len bráni jeho tvorbe.</li>
                        <li><strong>Hyperkaliémia</strong> → najnebezpečnejšia akútna porucha (arytmie); stabilizácia, presun, odstránenie.</li>
                        <li><strong>Hyperfosfatémia</strong> → kalcium-fosfátová precipitácia (nefrokalcinóza); viazače, hypokalciémiu korigovať len pri symptómoch.</li>
                        <li><strong>Hypokalciémia</strong> → tetánia, arytmie; opatrne korigovať (riziko precipitácie s fosfátom).</li>
                    </ul>
                    <div class="info-box-green">
                        <strong>Princíp:</strong> rozhodujúca je hydratácia, voľba urátového lieku podľa rizika a častý
                        laboratórny aj kardiálny monitoring. Pri refraktérnych poruchách alebo oligoanúrii včas zvážte
                        dialýzu a konzultáciu s nefrológiou.
                    </div>
                </section>

                <div class="form-actions no-print">
                    <a href="nastroje.php" class="btn-secondary">← Späť na nástroje</a>
                    <a href="calculator_tls.php" class="btn-secondary">Kalkulačka TLS (Cairo–Bishop)</a>
                </div>
            </div>

            <?php include "calculator_disclaimer.php"; ?>

            <section class="form-section" aria-labelledby="zdroje-heading">
                <h3 id="zdroje-heading">Zdroje</h3>
                <ul class="tool-step__list">
                    <li>Howard SC, Jones DP, Pui CH. The tumor lysis syndrome. <em>N Engl J Med.</em> 2011;364(19):1844–1854.</li>
                    <li>Coiffier B, et al. Guidelines for the management of pediatric and adult tumor lysis syndrome. <em>J Clin Oncol.</em> 2008;26(16):2767–2778.</li>
                    <li>Cairo MS, Bishop M. Tumour lysis syndrome: classification and grading system. <em>Br J Haematol.</em> 2004;127(1):3–11.</li>
                </ul>
            </section>
        </div>
    </main>

    <script src="nastroj_engine.js?v=<?= filemtime(__DIR__ . '/nastroj_engine.js') ?>" defer></script>
    <script src="nastroj_tls.js?v=<?= filemtime(__DIR__ . '/nastroj_tls.js') ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
