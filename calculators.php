<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/calculators_common.php'; // calculatorRenderRegisterCta()
/** @var \PDO $pdo */

$pageLastUpdated = date("d.m.Y H:i", filemtime(__FILE__));
$pageTimeZone = date("T") . " (" . date_default_timezone_get() . ")";

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";
$pageUrl = $baseUrl . "calculators.php";
$pageTitle = "Nefrologické kalkulačky | " . $siteName;
$pageDesc =
    "Klinické kalkulačky pre nefrológiu podľa KDIGO 2024: eGFR (CKD-EPI 2021), KDIGO G/A riziko, KFRE predikcia dialýzy, CKD-PC Grams 2022, IgAN Prediction Tool a Mayo ADPKD klasifikácia. Pre zdravotníckych pracovníkov na Slovensku.";
$schemaWebApp = [
    "@context" => "https://schema.org",
    "@type" => ["WebApplication", "MedicalWebPage"],
    "name" => "Nefrologické kalkulačky — Nefro-projekt Slovensko",
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
    "publisher" => [
        "@type" => "MedicalOrganization",
        "name" => $siteName,
        "url" => $baseUrl,
        "logo" => ["@type" => "ImageObject", "url" => $baseUrl . "img/nps-logo.png"],
    ],
    "hasPart" => [
        [
            "@type" => "WebApplication",
            "name" => "eGFR kalkulačka (CKD-EPI 2021)",
            "url" => $baseUrl . "calculator_egfr.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "eGFR (CKD-EPI kreatinín–cystatín C 2021)",
            "url" => $baseUrl . "calculator_egfr_cys.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "24-h klírens kreatinínu (meraný)",
            "url" => $baseUrl . "calculator_crcl_24h.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "CRRT — efluentová dávka",
            "url" => $baseUrl . "calculator_crrt.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Mehran skóre (kontrastom indukované AKI)",
            "url" => $baseUrl . "calculator_mehran.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Prevodník laboratórnych jednotiek (SI ⇄ konvenčné)",
            "url" => $baseUrl . "calculator_units.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "nPCR / nPNA (katabolizmus bielkovín pri dialýze)",
            "url" => $baseUrl . "calculator_npcr.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "KDIGO G/A riziko CKD",
            "url" => $baseUrl . "calculator_kdigo_risk.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "KFRE — Kidney Failure Risk Equation",
            "url" => $baseUrl . "calculator_kfre.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "CKD-PC — Grams 2022 (3-ročné riziko)",
            "url" => $baseUrl . "calculator_ckdpc.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "PREVENT — AHA 2024 (kardiovaskulárne riziko)",
            "url" => $baseUrl . "calculator_prevent.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "IgAN Prediction Tool (Barbour 2019)",
            "url" => $baseUrl . "calculator_igan.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Mayo ADPKD klasifikácia (Irazabal 2015)",
            "url" => $baseUrl . "calculator_adpkd.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "FENa / FEUrea (AKI)",
            "url" => $baseUrl . "calculator_aki.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Cockcroft-Gault (Klírens kreatinínu)",
            "url" => $baseUrl . "calculator_cg.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Korigovaný vápnik pri hypoalbuminémii",
            "url" => $baseUrl . "calculator_ca.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Poruchy sodíka a vody",
            "url" => $baseUrl . "calculator_na.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Aniónová medzera a Delta Ratio",
            "url" => $baseUrl . "calculator_acidbase.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Klírens voľnej vody (CH₂O a EFWC)",
            "url" => $baseUrl . "calculator_free_water.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Furstov pomer (reštrikcia tekutín pri hyponatriémii)",
            "url" => $baseUrl . "calculator_furst.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Recirkulácia cievneho prístupu (ureová metóda)",
            "url" => $baseUrl . "calculator_recirculation.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Rýchlosť poklesu eGFR (Slope)",
            "url" => $baseUrl . "calculator_egfr_slope.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Kt/V a URR (Adekvátnosť HD)",
            "url" => $baseUrl . "calculator_ktv.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "UACR a KDIGO klasifikácia",
            "url" => $baseUrl . "calculator_uacr.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "MGUS — Mayo riziková stratifikácia a κ/λ pomer",
            "url" => $baseUrl . "calculator_mgus.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Syndróm rozpadu nádoru (TLS) — Cairo–Bishop klasifikácia",
            "url" => $baseUrl . "calculator_tls.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "PLASMIC skóre (TTP / ADAMTS13)",
            "url" => $baseUrl . "calculator_plasmic.php",
        ],
        [
            "@type" => "WebApplication",
            "name" => "Staging CKM syndrómu (AHA 2023)",
            "url" => $baseUrl . "calculator_ckm.php",
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  // Mapovanie premenných pre head_meta.php
  $seoDescription = $pageDesc;
  $seoKeywords =
      "eGFR kalkulačka, KDIGO 2024, CKD riziko, KFRE, CKD-PC, nefrológia, chronické ochorenie obličiek, Slovensko";
  $canonicalUrl = $pageUrl;

  $structuredData = [];
  if (isset($schemaWebApp)) {
      $structuredData[] = $schemaWebApp;
  }

  // Pridanie Breadcrumbs
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
              "name" => "Kalkulačky",
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
    $headerTitle = "Nefrologické kalkulačky";
    $headerIntro = "";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

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

            <?php calculatorRenderRegisterCta('hub'); ?>

            <section class="features-section" aria-labelledby="calculators-heading">
                <h2 id="calculators-heading">Dostupné kalkulačky</h2>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h3>eGFR (CKD-EPI 2021)</h3>
                        <p>Výpočet odhadovanej glomerulovej filtrácie z veku, pohlavia a kreatinínu.</p>
                        <a href="calculator_egfr.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h3>eGFR (kreatinín–cystatín C 2021)</h3>
                        <p>Presnejší odhad filtrácie a potvrdenie CKD podľa KDIGO 2024 — kombinovaný vzorec CKD-EPI 2021 z kreatinínu a cystatínu C (bez rasy).</p>
                        <a href="calculator_egfr_cys.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h3>24-h klírens kreatinínu (meraný)</h3>
                        <p>Meraný klírens kreatinínu zo zberu moču a séra, s voliteľnou normalizáciou na povrch tela (1,73 m²). Vhodný pri atypickej svalovej hmote či neistom eGFR.</p>
                        <a href="calculator_crcl_24h.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h3>CRRT — efluentová dávka</h3>
                        <p>Dávka kontinuálnej náhrady funkcie obličiek v mL/kg/h z prietokov dialyzátu, substitúcie a ultrafiltrácie; cieľ KDIGO 20–25 mL/kg/h a odhad dodanej dávky pri výpadkoch.</p>
                        <a href="calculator_crrt.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h3>Mehran skóre (CI-AKI)</h3>
                        <p>Predprocedurálne riziko kontrastom indukovaného akútneho poškodenia obličiek pred koronarografiou/PCI alebo CT s kontrastom (Mehran 2004).</p>
                        <a href="calculator_mehran.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h3>Prevodník jednotiek (SI ⇄ konvenčné)</h3>
                        <p>Obojsmerná živá konverzia laboratórnych jednotiek — kreatinín, urea/BUN, glukóza, vápnik, fosfát, cholesterol, urát a ďalšie.</p>
                        <a href="calculator_units.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h3>nPCR / nPNA (dialýza)</h3>
                        <p>Normalizovaná miera katabolizmu bielkovín z dvoch hodnôt močoviny a Watsonovho objemu — nutričný ukazovateľ, ktorý dopĺňa Kt/V.</p>
                        <a href="calculator_npcr.php" class="btn-primary">Otvoriť kalkulačku</a>
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

            <section class="features-section" aria-labelledby="cvrisk-calculators-heading">
                <h2 id="cvrisk-calculators-heading">Kardiovaskulárne riziko</h2>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h3>PREVENT — AHA 2024</h3>
                        <p>10- a 30-ročné riziko pre Total CVD, ASCVD a srdcové zlyhávanie (Khan 2024). Nahrádza starý PCE; zahŕňa eGFR a voliteľne UACR, HbA1c a SDI. S interpretáciou rizikovej kategórie a cieľa LDL podľa odporúčaní 2026.</p>
                        <a href="calculator_prevent.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                    <article class="feature-card calculator-card">
                        <h3>Staging CKM syndrómu</h3>
                        <p>Kardiovaskulárno-renálno-metabolický syndróm, štádium 0 – 4 (AHA 2023): adipozita → metabolické RF a/alebo CKD → subklinické → klinické KV ochorenie (4a/4b). Hierarchická klasifikácia s integráciou CKD pre prevenciu.</p>
                        <a href="calculator_ckm.php" class="btn-primary">Otvoriť kalkulačku</a>
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
                    <article class="feature-card calculator-card">
                        <h3>Klírens voľnej vody (CH₂O / EFWC)</h3>
                        <p>Klasický klírens voľnej vody z osmolality a elektrolytový klírens (EFWC) z Na/K — či obličky čistú vodu vylučujú alebo zadržiavajú. Pomôcka pri hyponatrémii a hypernatrémii.</p>
                        <a href="calculator_free_water.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                    <article class="feature-card calculator-card">
                        <h3>Furstov pomer (reštrikcia tekutín)</h3>
                        <p>Pomer (U<sub>Na</sub>+U<sub>K</sub>)/S<sub>Na</sub> predpovedá, či pri hyponatrémii (SIADH) postačí reštrikcia tekutín: &lt; 0,5 účinná &lt; 1000 mL/deň, 0,5 – 1,0 prísna &lt; 500 mL/deň, &gt; 1,0 neúčinná.</p>
                        <a href="calculator_furst.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                    <article class="feature-card calculator-card">
                        <h3>Syndróm rozpadu nádoru (TLS)</h3>
                        <p>Cairo–Bishop klasifikácia: laboratórny TLS = ≥ 2 metabolické odchýlky (kys. močová, draslík, fosfát, vápnik); klinický TLS + obličkové postihnutie, arytmia alebo kŕče. Častá príčina akútneho poškodenia obličiek v onko-nefrológii.</p>
                        <a href="calculator_tls.php" class="btn-primary">Otvoriť kalkulačku</a>
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
                    <article class="feature-card calculator-card">
                        <h3>Recirkulácia prístupu</h3>
                        <p>Ureová trojvzorková metóda (systémová/arteriálna/venózna koncentrácia) na detekciu recirkulácie cievneho prístupu, ktorá znižuje účinnú dávku dialýzy. Hranica významnosti 5 – 10 %.</p>
                        <a href="calculator_recirculation.php" class="btn-primary">Otvoriť kalkulačku</a>
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
                    <article class="feature-card calculator-card">
                        <h3>MGUS — riziko progresie a κ/λ</h3>
                        <p>Mayo riziková stratifikácia (Rajkumar 2005): M-proteín, izotyp a pomer voľných ľahkých reťazcov → 20-ročné riziko progresie. S poznámkou k MGRS (renálny význam) a renálnemu rozpätiu FLC.</p>
                        <a href="calculator_mgus.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                </div>
            </section>

            <section class="features-section" aria-labelledby="spec-calculators-heading">
                <h2 id="spec-calculators-heading">Kalkulačky pre špecifické diagnózy</h2>
                <p class="calc-intro-text">KDIGO 2024 odporúča pre niektoré ochorenia obličiek použiť externálne validované, diagnózovo špecifické prognostické nástroje.</p>
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

    <?php include "footer.php"; ?>
</body>
</html>
