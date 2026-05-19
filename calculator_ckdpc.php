<?php
require_once "auth.php";
require_once "db_config.php";
require_once "calculators_common.php";

/**
 * CKD-PC model — Grams et al. Diabetes Care 2022;45:2055–2063.
 * doi: 10.2337/dc22-0698 | PMID: 35856507
 *
 * Predikuje 3-ročné riziko kompozitného endpointu:
 *   ≥40 % pokles eGFR ALEBO zlyhanie obličiek (KRT).
 *
 * Metóda: complementary log-log (clog-log) regresia.
 * Vzorec: P = 1 - exp(-exp(η))
 *
 * 4 sub-modely podľa: prítomnosti DM × eGFR (≥60 vs <60).
 *
 * Model 3 (DM, eGFR≥60) bol overený oproti ckdpcrisk.org/gfrdecline40/
 * s defaultnými hodnotami (60r, M, DM, eGFR=85, ACR=30mg/g, SBP=130, BMI=30,
 * HbA1c=7, bez komorbidít) → výsledok 1,9 % ✓
 *
 * Poznámka: Koeficienty modelov 1, 2 a 4 sú odvodené z publikovaných dát
 * a neboli nezávisle overené. Pre klinické rozhodovanie odporúčame použiť
 * oficiálny kalkulátor na https://ckdpcrisk.org/gfrdecline40/
 */

/**
 * Vypočíta 3-ročné riziko pomocou Grams 2022 clog-log modelu.
 *
 * @param int    $age         Vek (20–80)
 * @param string $sex         'male' alebo 'female'
 * @param float  $egfr        eGFR v ml/min/1,73 m²
 * @param float  $uacrMgG     uACR v mg/g (pozitívna hodnota)
 * @param bool   $diabetes    Prítomnosť DM
 * @param float  $sbp         Systolický TK (mmHg)
 * @param bool   $antihtn     Antihypertenzívna liečba
 * @param bool   $hf          Anamnéza srdcového zlyhania
 * @param bool   $chd         Anamnéza ICHS
 * @param bool   $afib        Anamnéza fibrilácie predsiení
 * @param float  $bmi         BMI (kg/m²)
 * @param string $smoking     'never', 'former' alebo 'current'
 * @param float  $hba1c       HbA1c v % (len pri DM, default 7.0)
 * @param bool   $insulin     Inzulínová liečba (len pri DM)
 * @param bool   $oralDm      Perorálna antidiabetická liečba (len pri DM)
 * @return array{risk_3yr: float, model: string}
 */
function ckdpcRisk(
    int $age,
    string $sex,
    float $egfr,
    float $uacrMgG,
    bool $diabetes,
    float $sbp,
    bool $antihtn,
    bool $hf,
    bool $chd,
    bool $afib,
    float $bmi,
    string $smoking,
    float $hba1c = 7.0,
    bool $insulin = false,
    bool $oralDm = false,
): array {
    $male = $sex === "male" ? 1 : 0;
    $lnEgfr = log($egfr);
    $lnUacr = log($uacrMgG);
    $antihtnV = $antihtn ? 1 : 0;
    $hfV = $hf ? 1 : 0;
    $chdV = $chd ? 1 : 0;
    $afibV = $afib ? 1 : 0;
    $smokCurrent = $smoking === "current" ? 1 : 0;
    $smokFormer = $smoking === "former" ? 1 : 0;
    $insulinV = $insulin ? 1 : 0;
    $oralDmV = $oralDm ? 1 : 0;

    if (!$diabetes && $egfr >= 60.0) {
        // Model 1: Bez DM, eGFR ≥ 60
        $modelName = "Bez DM, eGFR ≥ 60 ml/min/1,73 m²";
        $eta =
            -4.9505 +
            0.0172 * $age +
            0.1546 * $male +
            -0.8767 * $lnEgfr +
            0.2861 * $lnUacr +
            0.009 * $sbp +
            0.1894 * $antihtnV +
            0.4359 * $hfV +
            0.1871 * $chdV +
            0.1623 * $afibV +
            0.0136 * $bmi +
            0.2356 * $smokCurrent +
            0.0894 * $smokFormer;
    } elseif (!$diabetes && $egfr < 60.0) {
        // Model 2: Bez DM, eGFR < 60
        $modelName = "Bez DM, eGFR < 60 ml/min/1,73 m²";
        $eta =
            -2.9083 +
            0.0038 * $age +
            0.211 * $male +
            -0.557 * $lnEgfr +
            0.3262 * $lnUacr +
            0.004 * $sbp +
            0.0795 * $antihtnV +
            0.3462 * $hfV +
            0.139 * $chdV +
            0.113 * $afibV +
            0.0108 * $bmi +
            0.1983 * $smokCurrent +
            0.058 * $smokFormer;
    } elseif ($diabetes && $egfr >= 60.0) {
        // Model 3: DM, eGFR ≥ 60  [OVERENÝ: default ckdpcrisk.org → 1,9 %]
        $modelName = "DM, eGFR ≥ 60 ml/min/1,73 m²";
        $eta =
            -5.9015 +
            0.0161 * $age +
            0.1229 * $male +
            -0.5023 * $lnEgfr +
            0.2902 * $lnUacr +
            0.0083 * $sbp +
            0.1335 * $antihtnV +
            0.4174 * $hfV +
            0.1398 * $chdV +
            0.1596 * $afibV +
            0.0139 * $bmi +
            0.2289 * $smokCurrent +
            0.0768 * $smokFormer +
            0.0877 * $hba1c +
            0.1551 * $insulinV +
            -0.026 * $oralDmV;
    } else {
        // Model 4: DM, eGFR < 60
        $modelName = "DM, eGFR < 60 ml/min/1,73 m²";
        $eta =
            -2.3985 +
            0.001 * $age +
            0.2025 * $male +
            -0.4527 * $lnEgfr +
            0.3323 * $lnUacr +
            0.0039 * $sbp +
            0.0502 * $antihtnV +
            0.3378 * $hfV +
            0.1234 * $chdV +
            0.1262 * $afibV +
            0.0089 * $bmi +
            0.1925 * $smokCurrent +
            0.0446 * $smokFormer +
            0.0603 * $hba1c +
            0.1288 * $insulinV +
            -0.0079 * $oralDmV;
    }

    $risk3yr = (1.0 - exp(-exp($eta))) * 100.0;
    $risk3yr = max(0.0, min(99.9, $risk3yr));

    return [
        "risk_3yr" => round($risk3yr, 1),
        "model_name" => $modelName,
    ];
}

/**
 * Klinická interpretácia 3-ročného rizika.
 *
 * @param float $risk3yr Riziko v %
 * @return array{interpretation: list<string>, warnings: list<string>}
 */
function ckdpcInterpretation(float $risk3yr): array
{
    $interpretation = [];
    $warnings = [];

    if ($risk3yr < 5.0) {
        $interpretation[] =
            "3-ročné riziko " .
            number_format($risk3yr, 1, ",", " ") .
            " % — nízke riziko progresie obličkového ochorenia.";
    } elseif ($risk3yr < 10.0) {
        $interpretation[] =
            "3-ročné riziko " .
            number_format($risk3yr, 1, ",", " ") .
            " % — stredne zvýšené riziko, odporúča sa intenzívnejší monitoring eGFR a uACR.";
    } elseif ($risk3yr < 20.0) {
        $interpretation[] =
            "3-ročné riziko " .
            number_format($risk3yr, 1, ",", " ") .
            " % — zvýšené riziko progresie CKD, zvážiť konzultáciu nefrológa.";
        $warnings[] =
            "Riziko ≥10 % — zvážiť intenzívnejší/multidisciplinárny model starostlivosti (analogicky s prahom pre 2-ročné riziko z KFRE).";
    } else {
        $interpretation[] =
            "3-ročné riziko " .
            number_format($risk3yr, 1, ",", " ") .
            " % — vysoké riziko rýchlej progresie, prioritne zvážiť konzultáciu nefrológa a optimalizáciu terapie.";
        $warnings[] =
            "Riziko ≥20 % — zvážiť včasné plánovanie náhrady funkcie obličiek a odoslanie na nefrologickú ambulanciu.";
    }

    return [
        "interpretation" => $interpretation,
        "warnings" => $warnings,
    ];
}

/* ─────────────────────────────────────────────────────
   Inicializácia
   ───────────────────────────────────────────────────── */
$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "age_years" => (string) ($_POST["age_years"] ?? ""),
    "sex" => (string) ($_POST["sex"] ?? "female"),
    "egfr" => (string) ($_POST["egfr"] ?? ""),
    "uacr_value" => (string) ($_POST["uacr_value"] ?? ""),
    "uacr_unit" => (string) ($_POST["uacr_unit"] ?? "mg_g"),
    "diabetes" => (string) ($_POST["diabetes"] ?? "0"),
    "sbp" => (string) ($_POST["sbp"] ?? ""),
    "antihtn" => (string) ($_POST["antihtn"] ?? "0"),
    "hf" => (string) ($_POST["hf"] ?? "0"),
    "chd" => (string) ($_POST["chd"] ?? "0"),
    "afib" => (string) ($_POST["afib"] ?? "0"),
    "bmi" => (string) ($_POST["bmi"] ?? ""),
    "smoking" => (string) ($_POST["smoking"] ?? "never"),
    "hba1c" => (string) ($_POST["hba1c"] ?? ""),
    "insulin" => (string) ($_POST["insulin"] ?? "0"),
    "oral_dm" => (string) ($_POST["oral_dm"] ?? "0"),
    "patient_first_name" => (string) ($_POST["patient_first_name"] ?? ""),
    "patient_last_name" => (string) ($_POST["patient_last_name"] ?? ""),
    "patient_birth_date" => (string) ($_POST["patient_birth_date"] ?? ""),
    "patient_birth_number" => (string) ($_POST["patient_birth_number"] ?? ""),
    "patient_insurance_code" =>
        (string) ($_POST["patient_insurance_code"] ?? ""),
];

if (isLoggedIn() && isset($_GET["load_id"])) {
    $loadId = (int) $_GET["load_id"];
    $loadedRow = calculatorFetchSavedResultById($pdo, $loadId, (int) $_SESSION["user_id"]);
    if ($loadedRow) {
        $form["patient_first_name"]   = (string) ($loadedRow["patient_first_name"]   ?? "");
        $form["patient_last_name"]    = (string) ($loadedRow["patient_last_name"]    ?? "");
        $form["patient_birth_date"]   = (string) ($loadedRow["patient_birth_date"]   ?? "");
        $form["patient_birth_number"] = (string) ($loadedRow["patient_birth_number"] ?? "");
        $form["patient_insurance_code"] = (string) ($loadedRow["patient_insurance_code"] ?? "");
        if (is_array($loadedRow["input_payload"])) {
            foreach ($loadedRow["input_payload"] as $k => $v) {
                if (array_key_exists($k, $form)) $form[$k] = (string) $v;
            }
        }
        $messages[] = "Údaje z histórie boli načítané do formulára. Môžete ich upraviť a vykonať nový výpočet.";
    }
}

/* ─────────────────────────────────────────────────────
   POST spracovanie
   ───────────────────────────────────────────────────── */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = (string) ($_POST["action"] ?? "");

    if (!validateCsrfToken((string) ($_POST["csrf_token"] ?? ""))) {
        $errors[] = "Neplatný CSRF token.";
    } elseif ($action === "delete_saved") {
        if (!isLoggedIn()) {
            $errors[] = "Na mazanie výsledkov je potrebné prihlásenie.";
        } else {
            $resultId = (int) ($_POST["result_id"] ?? 0);
            if ($resultId <= 0) {
                $errors[] = "Neplatné ID záznamu.";
            } else {
                try {
                    if (
                        calculatorDeleteSavedResult(
                            $pdo,
                            $resultId,
                            (int) $_SESSION["user_id"],
                        )
                    ) {
                        $messages[] = "Uložený výsledok bol vymazaný.";
                    } else {
                        $errors[] =
                            "Záznam sa nepodarilo vymazať alebo neexistuje.";
                    }
                } catch (\PDOException $e) {
                    $errors[] = "Databázová chyba pri mazaní záznamu.";
                    error_log(
                        "calculator_ckdpc delete error: " . $e->getMessage(),
                    );
                }
            }
        }
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        // Vek — auto-doplnenie z dát. narodenia / rodného čísla
        if ($form["age_years"] === "") {
            $derived = calculatorAgeFromPatient($patient);
            if ($derived !== null) {
                $form["age_years"] = (string) $derived;
            }
        }
        $ageYears = filter_var($form["age_years"], FILTER_VALIDATE_INT, [
            "options" => ["min_range" => 20, "max_range" => 80],
        ]);
        if ($ageYears === false) {
            $errors[] =
                "Vek musí byť celé číslo od 20 do 80 rokov (validačný rozsah modelu).";
        }

        // Pohlavie
        $sex = in_array($form["sex"], ["female", "male"], true)
            ? $form["sex"]
            : "";
        if ($sex === "") {
            $errors[] = "Vyberte pohlavie.";
        }

        // eGFR
        $egfr = calculatorParsePositiveFloat($form["egfr"]);
        if ($egfr === null || $egfr > 200) {
            $errors[] =
                "eGFR musí byť kladné číslo v rozsahu 0–200 ml/min/1,73 m².";
        }

        // uACR
        $uacrUnit = in_array($form["uacr_unit"], ["mg_g", "mg_mmol"], true)
            ? $form["uacr_unit"]
            : "";
        if ($uacrUnit === "") {
            $errors[] = "Vyberte jednotku UACR.";
        }
        $uacrValue = calculatorParsePositiveFloat($form["uacr_value"]);
        if ($uacrValue === null || $uacrValue > 15000) {
            $errors[] = "UACR musí byť kladné číslo v rozumnom rozsahu.";
        }

        // DM
        $diabetes = $form["diabetes"] === "1";

        // SBP
        $sbp = calculatorParsePositiveFloat($form["sbp"]);
        if ($sbp === null || $sbp < 70 || $sbp > 250) {
            $errors[] = "Systolický TK musí byť číslo v rozsahu 70–250 mmHg.";
        }

        // Booleany
        $antihtn = $form["antihtn"] === "1";
        $hf = $form["hf"] === "1";
        $chd = $form["chd"] === "1";
        $afib = $form["afib"] === "1";

        // BMI
        $bmi = calculatorParsePositiveFloat($form["bmi"]);
        if ($bmi === null || $bmi < 10 || $bmi > 80) {
            $errors[] = "BMI musí byť číslo v rozsahu 10–80 kg/m².";
        }

        // Fajčenie
        $smoking = in_array(
            $form["smoking"],
            ["never", "former", "current"],
            true,
        )
            ? $form["smoking"]
            : "";
        if ($smoking === "") {
            $errors[] = "Vyberte status fajčenia.";
        }

        // DM-špecifické vstupy
        $hba1c = 7.0;
        $insulin = false;
        $oralDm = false;
        if ($diabetes) {
            $hba1cRaw = calculatorParsePositiveFloat($form["hba1c"]);
            if ($hba1cRaw === null || $hba1cRaw < 4.0 || $hba1cRaw > 20.0) {
                $errors[] =
                    "HbA1c musí byť číslo v rozsahu 4–20 % (len pri DM).";
            } else {
                $hba1c = $hba1cRaw;
            }
            $insulin = $form["insulin"] === "1";
            $oralDm = $form["oral_dm"] === "1";
        }

        if (empty($errors)) {
            $uacrMgG = $uacrUnit === "mg_mmol" ? $uacrValue * 8.84 : $uacrValue;
            if ($uacrMgG < 0.5 || !is_finite($uacrMgG)) {
                $errors[] =
                    "Hodnota UACR je príliš nízka alebo neplatná po konverzii.";
            } else {
                $riskResult = ckdpcRisk(
                    (int) $ageYears,
                    $sex,
                    (float) $egfr,
                    $uacrMgG,
                    $diabetes,
                    (float) $sbp,
                    $antihtn,
                    $hf,
                    $chd,
                    $afib,
                    (float) $bmi,
                    $smoking,
                    $hba1c,
                    $insulin,
                    $oralDm,
                );
                $interpResult = ckdpcInterpretation($riskResult["risk_3yr"]);

                $calculated = [
                    "age_years" => (int) $ageYears,
                    "sex" => $sex,
                    "egfr" => round((float) $egfr, 1),
                    "uacr_input" => round((float) $uacrValue, 2),
                    "uacr_unit" => $uacrUnit,
                    "uacr_mg_g" => round($uacrMgG, 2),
                    "diabetes" => $diabetes,
                    "sbp" => round((float) $sbp, 0),
                    "antihtn" => $antihtn,
                    "hf" => $hf,
                    "chd" => $chd,
                    "afib" => $afib,
                    "bmi" => round((float) $bmi, 1),
                    "smoking" => $smoking,
                    "hba1c" => $diabetes ? $hba1c : null,
                    "insulin" => $diabetes ? $insulin : null,
                    "oral_dm" => $diabetes ? $oralDm : null,
                    "risk_3yr" => $riskResult["risk_3yr"],
                    "model_name" => $riskResult["model_name"],
                    "interpretation" => $interpResult["interpretation"],
                    "warnings" => $interpResult["warnings"],
                ];

                if ($action === "save") {
                    if (!isLoggedIn()) {
                        $errors[] =
                            "Pre uloženie výsledku sa najskôr prihláste.";
                    } else {
                        $inputPayload = [
                            "age_years" => $calculated["age_years"],
                            "sex" => $calculated["sex"],
                            "egfr" => $calculated["egfr"],
                            "uacr_value" => $calculated["uacr_input"],
                            "uacr_unit" => $calculated["uacr_unit"],
                            "diabetes" => $calculated["diabetes"],
                            "sbp" => $calculated["sbp"],
                            "antihtn" => $calculated["antihtn"],
                            "hf" => $calculated["hf"],
                            "chd" => $calculated["chd"],
                            "afib" => $calculated["afib"],
                            "bmi" => $calculated["bmi"],
                            "smoking" => $calculated["smoking"],
                        ];
                        if ($diabetes) {
                            $inputPayload["hba1c"] = $calculated["hba1c"];
                            $inputPayload["insulin"] = $calculated["insulin"];
                            $inputPayload["oral_dm"] = $calculated["oral_dm"];
                        }

                        $resultPayload = [
                            "risk_3yr" => $calculated["risk_3yr"],
                            "model_name" => $calculated["model_name"],
                            "uacr_mg_g" => $calculated["uacr_mg_g"],
                            "interpretation" => $calculated["interpretation"],
                            "warnings" => $calculated["warnings"],
                        ];

                        try {
                            if (
                                calculatorSaveResult(
                                    $pdo,
                                    (int) $_SESSION["user_id"],
                                    "ckdpc_grams_2022",
                                    "CKD-PC (Grams 2022 – 3-ročné riziko)",
                                    $patient,
                                    $inputPayload,
                                    $resultPayload,
                                )
                            ) {
                                $messages[] =
                                    "Výsledok bol uložený do databázy.";
                            } else {
                                $errors[] = "Výsledok sa nepodarilo uložiť.";
                            }
                        } catch (\PDOException $e) {
                            $errors[] =
                                "Databázová chyba pri ukladaní výsledku.";
                            error_log(
                                "calculator_ckdpc save error: " .
                                    $e->getMessage(),
                            );
                        }
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    try {
        $savedResults = calculatorFetchSavedResults(
            $pdo,
            (int) $_SESSION["user_id"],
            "ckdpc_grams_2022",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_ckdpc fetch history error: " . $e->getMessage());
    }
}

/* ─────────────────────────────────────────────────────
   Pomocné funkcie pre zobrazenie
   ───────────────────────────────────────────────────── */
function boolLabel(bool $v): string
{
    return $v ? "Áno" : "Nie";
}
function smokingLabel(string $v): string
{
    return match ($v) {
        "current" => "Fajčí",
        "former" => "Ex-fajčiar",
        default => "Nefajčí",
    };
}
function sexLabel(string $v): string
{
    return $v === "male" ? "Muž" : "Žena";
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle =
      "CKD-PC — Riziko progresie CKD | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_ckdpc.php";
  $seoDescription =
      "Nefrologická kalkulačka a nástroj: CKD-PC — Riziko progresie CKD. CKD Prognosis Consortium — 3-ročné riziko progresie CKD (Grams 2022). Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
  $structuredData = [
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
                  "name" => "Kalkulačky",
                  "item" => $baseUrl . "calculators.php",
              ],
              [
                  "@type" => "ListItem",
                  "position" => 3,
                  "name" => "CKD-PC — Riziko progresie CKD",
                  "item" => $baseUrl . "calculator_ckdpc.php",
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
    $headerTitle = "CKD-PC Kalkulačka";
    $headerIntro =
        "CKD Prognosis Consortium — 3-ročné riziko progresie CKD (Grams 2022)";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">

                <h2>CKD-PC — Riziko progresie CKD</h2>
                <p class="auth-subtitle">
                    3-ročné riziko kompozitného endpointu: ≥40 % pokles eGFR alebo zlyhanie obličiek
                    (KRT). Model je validovaný pre <strong>všetky štádiá CKD</strong> vrátane G1–G2
                    (kde KFRE nemusí byť presný).
                </p>

                <div class="info-box-blue">
                    <strong>Zdroj:</strong> Grams ME et al. <em>Diabetes Care.</em> 2022;45(9):2055–2063.
                    <a href="https://pubmed.ncbi.nlm.nih.gov/35856507/" target="_blank" rel="noopener noreferrer">PMID 35856507</a>.
                    Oficiálny kalkulátor:
                    <a href="https://ckdpcrisk.org/gfrdecline40/" target="_blank" rel="noopener noreferrer">ckdpcrisk.org/gfrdecline40/</a>.
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec — CKD-PC / Grams 2022 (clog-log)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ P = 1 - \exp(-\exp(\eta)) \]</div>
                        <div class="calc-formula-line">\[ \begin{aligned} \eta = \beta_0 &+ \beta_1 \cdot \text{Vek} + \beta_2 \cdot \text{muž} + \beta_3 \cdot \ln(\text{eGFR}) \\ &+ \beta_4 \cdot \ln(\text{uACR}) + \beta_5 \cdot \text{SBP} + \beta_6 \cdot \text{antihyp} + \beta_7 \cdot \text{SZ} \\ &+ \beta_8 \cdot \text{ICHS} + \beta_9 \cdot \text{FP} + \beta_{10} \cdot \text{BMI} + \beta_{11} \cdot \text{fajč.} \\ &+ [\beta_{12} \cdot \text{HbA1c} + \beta_{13} \cdot \text{inzulín} + \beta_{14} \cdot \text{PAD}] \text{ (len pri DM)} \end{aligned} \]</div>
                        <div class="calc-formula-line">\[ \text{UACR [mg/g]} = \text{UACR [mg/mmol]} \times 8.84 \]</div>
                        <div class="calc-formula-vars">
                            $P = \text{3-ročné riziko (}\ge 40\% \text{ pokles eGFR alebo zlyhanie obličiek)}$ &bull;
                            4 sub-modely: DM / bez DM $\times$ eGFR $\ge 60$ / $\lt 60$ &bull;
                            uACR v mg/g, SBP v mmHg
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Porovnanie s referenčnými kalkulátormi:</strong>
                    <a href="https://ckdpcrisk.org/gfrdecline40/" target="_blank" rel="noopener noreferrer">ckdpcrisk.org/gfrdecline40/</a> (CKD-PC Grams, oficiálny) &ensp;&bull;&ensp;
                    <a href="https://kidneyfailurerisk.com/" target="_blank" rel="noopener noreferrer">kidneyfailurerisk.com</a> (KFRE, Tangri)
                </div>

                <?php foreach ($messages as $msg): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars(
                        $msg,
                    ) ?></p></div>
                <?php endforeach; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <ul>
                            <?php foreach ($errors as $e): ?>
                                <li><?= htmlspecialchars($e) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- ── FORMULÁR ─────────────────────────────────── -->
                <form method="POST" action="calculator_ckdpc.php" id="ckdpc-form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                        generateCsrfToken(),
                    ) ?>">

                    <!-- Voliteľné identifikačné údaje -->
                    <div class="form-section">
                        <h3>Voliteľné identifikačné údaje pacienta</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="patient_first_name">Meno</label>
                                <input type="text" id="patient_first_name" name="patient_first_name" class="form-control" value="<?= htmlspecialchars(
                                    $form["patient_first_name"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_last_name">Priezvisko</label>
                                <input type="text" id="patient_last_name" name="patient_last_name" class="form-control" value="<?= htmlspecialchars(
                                    $form["patient_last_name"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_birth_date">Dátum narodenia</label>
                                <input type="date" id="patient_birth_date" name="patient_birth_date" class="form-control" value="<?= htmlspecialchars(
                                    $form["patient_birth_date"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_birth_number">Rodné číslo</label>
                                <input type="text" id="patient_birth_number" name="patient_birth_number" class="form-control" placeholder="000000/0000" value="<?= htmlspecialchars(
                                    $form["patient_birth_number"],
                                ) ?>">
                            </div>

                            <?php include __DIR__ .
                                "/patient_insurance_select.php"; ?>


                        </div>
                    </div>
                    <div class="form-section">
                        <h3>Povinné vstupy na výpočet</h3>
                        <div class="form-grid">

                            <div class="form-group">
                                <label for="age_years">Vek (roky, 20–80)</label>
                                <input type="number" id="age_years" name="age_years"
                                       min="20" max="80" required class="form-control"
                                       value="<?= htmlspecialchars(
                                           $form["age_years"],
                                       ) ?>"
                                       placeholder="automaticky z dát. nar. / RČ">
                            </div>

                            <div class="form-group">
                                <label for="sex">Pohlavie</label>
                                <select id="sex" name="sex" class="form-control" required>
                                    <option value="female" <?= $form["sex"] ===
                                    "female"
                                        ? "selected"
                                        : "" ?>>Žena</option>
                                    <option value="male"   <?= $form["sex"] ===
                                    "male"
                                        ? "selected"
                                        : "" ?>>Muž</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="egfr">eGFR (ml/min/1,73 m²)</label>
                                <input type="text" id="egfr" name="egfr" required class="form-control"
                                       value="<?= htmlspecialchars(
                                           $form["egfr"],
                                       ) ?>">
                            </div>

                            <div class="form-group">
                                <label for="uacr_value">UACR</label>
                                <div class="flex-gap-8">
                                    <input type="text" id="uacr_value" name="uacr_value" required
                                           class="form-control flex-1"
                                           value="<?= htmlspecialchars(
                                               $form["uacr_value"],
                                           ) ?>">
                                    <select name="uacr_unit" class="form-control flex-08">
                                        <option value="mg_g"    <?= $form[
                                            "uacr_unit"
                                        ] === "mg_g"
                                            ? "selected"
                                            : "" ?>>mg/g</option>
                                        <option value="mg_mmol" <?= $form[
                                            "uacr_unit"
                                        ] === "mg_mmol"
                                            ? "selected"
                                            : "" ?>>mg/mmol</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sbp">Systolický TK (mmHg)</label>
                                <input type="text" id="sbp" name="sbp" required class="form-control"
                                       value="<?= htmlspecialchars(
                                           $form["sbp"],
                                       ) ?>">
                            </div>

                            <div class="form-group">
                                <label for="bmi">BMI (kg/m²)</label>
                                <input type="text" id="bmi" name="bmi" required class="form-control"
                                       value="<?= htmlspecialchars(
                                           $form["bmi"],
                                       ) ?>">
                            </div>

                        </div><!-- /.form-grid -->
                    </div><!-- /.form-section -->

                    <!-- Anamnéza a lifestyle -->
                    <div class="form-section">
                        <h3>Klinická anamnéza a lifestyle</h3>
                        <div class="form-grid">

                            <div class="form-group">
                                <label for="antihtn">Antihypertenzívna liečba</label>
                                <select id="antihtn" name="antihtn" class="form-control">
                                    <option value="0" <?= $form["antihtn"] ===
                                    "0"
                                        ? "selected"
                                        : "" ?>>Nie</option>
                                    <option value="1" <?= $form["antihtn"] ===
                                    "1"
                                        ? "selected"
                                        : "" ?>>Áno</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="hf">Srdcové zlyhanie (HF)</label>
                                <select id="hf" name="hf" class="form-control">
                                    <option value="0" <?= $form["hf"] === "0"
                                        ? "selected"
                                        : "" ?>>Nie</option>
                                    <option value="1" <?= $form["hf"] === "1"
                                        ? "selected"
                                        : "" ?>>Áno</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="chd">ICHS / CHD</label>
                                <select id="chd" name="chd" class="form-control">
                                    <option value="0" <?= $form["chd"] === "0"
                                        ? "selected"
                                        : "" ?>>Nie</option>
                                    <option value="1" <?= $form["chd"] === "1"
                                        ? "selected"
                                        : "" ?>>Áno</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="afib">Fibrilácia predsiení (AFib)</label>
                                <select id="afib" name="afib" class="form-control">
                                    <option value="0" <?= $form["afib"] === "0"
                                        ? "selected"
                                        : "" ?>>Nie</option>
                                    <option value="1" <?= $form["afib"] === "1"
                                        ? "selected"
                                        : "" ?>>Áno</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="smoking">Status fajčenia</label>
                                <select id="smoking" name="smoking" class="form-control">
                                    <option value="never"   <?= $form[
                                        "smoking"
                                    ] === "never"
                                        ? "selected"
                                        : "" ?>>Nefajčí</option>
                                    <option value="former"  <?= $form[
                                        "smoking"
                                    ] === "former"
                                        ? "selected"
                                        : "" ?>>Ex-fajčiar</option>
                                    <option value="current" <?= $form[
                                        "smoking"
                                    ] === "current"
                                        ? "selected"
                                        : "" ?>>Fajčí</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="diabetes">Diabetes mellitus</label>
                                <select id="diabetes" name="diabetes" class="form-control"
                                        onchange="document.getElementById('dm-fields').classList.toggle('d-none', this.value !== '1')">
                                    <option value="0" <?= $form["diabetes"] ===
                                    "0"
                                        ? "selected"
                                        : "" ?>>Nie</option>
                                    <option value="1" <?= $form["diabetes"] ===
                                    "1"
                                        ? "selected"
                                        : "" ?>>Áno</option>
                                </select>
                            </div>

                        </div><!-- /.form-grid -->
                    </div><!-- /.form-section -->

                    <!-- DM-špecifické polia -->
                    <div class="form-section<?= $form["diabetes"] === "1" ? "" : " d-none" ?>" id="dm-fields">
                        <h3>Liečba a laboratórium pri DM</h3>
                        <div class="form-grid">

                            <div class="form-group">
                                <label for="hba1c">HbA1c (%)</label>
                                <input type="text" id="hba1c" name="hba1c" class="form-control"
                                       value="<?= htmlspecialchars(
                                           $form["hba1c"],
                                       ) ?>"
                                       placeholder="napr. 7,5">
                            </div>

                            <div class="form-group">
                                <label for="insulin">Inzulínová liečba</label>
                                <select id="insulin" name="insulin" class="form-control">
                                    <option value="0" <?= $form["insulin"] ===
                                    "0"
                                        ? "selected"
                                        : "" ?>>Nie</option>
                                    <option value="1" <?= $form["insulin"] ===
                                    "1"
                                        ? "selected"
                                        : "" ?>>Áno</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="oral_dm">Perorálna antidiabetická liečba</label>
                                <select id="oral_dm" name="oral_dm" class="form-control">
                                    <option value="0" <?= $form["oral_dm"] ===
                                    "0"
                                        ? "selected"
                                        : "" ?>>Nie</option>
                                    <option value="1" <?= $form["oral_dm"] ===
                                    "1"
                                        ? "selected"
                                        : "" ?>>Áno</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <?php if (isLoggedIn()): ?>
                            <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                        <?php else: ?>
                            <a href="login.php" class="btn-secondary">Prihláste sa pre uloženie</a>
                        <?php endif; ?>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>

                </form>

                <!-- ── VÝSLEDOK ─────────────────────────────────── -->
                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block ckdpc-result">
                        <h3>Výsledok CKD-PC</h3>
                        <p class="helper-text">Model: <strong><?= htmlspecialchars(
                            $calculated["model_name"],
                        ) ?></strong></p>

                        <div class="ckdpc-risk-display">
                            <div class="risk-item risk-3yr">
                                <div class="risk-label">3-ročné riziko progresie</div>
                                <div class="risk-value">
                                    <?= htmlspecialchars(
                                        number_format(
                                            (float) $calculated["risk_3yr"],
                                            1,
                                            ",",
                                            " ",
                                        ),
                                    ) ?> %
                                </div>
                                <div class="risk-sublabel">≥40 % pokles eGFR alebo KRT</div>
                            </div>
                        </div>

                        <div class="kfre-interpretation">
                            <h4>Klinické hodnotenie</h4>
                            <?php foreach (
                                $calculated["interpretation"]
                                as $line
                            ): ?>
                                <p><?= htmlspecialchars($line) ?></p>
                            <?php endforeach; ?>

                            <?php if (!empty($calculated["warnings"])): ?>
                                <div class="alert alert-error calc-result-mt12">
                                    <ul>
                                        <?php foreach (
                                            $calculated["warnings"]
                                            as $warning
                                        ): ?>
                                            <li><?= htmlspecialchars(
                                                $warning,
                                            ) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Vstupné hodnoty -->
                        <details class="ckdpc-inputs-summary">
                            <summary>Použité vstupné hodnoty</summary>
                            <table class="admin-table mt-8">
                                <tr><th>Vek</th><td><?= (int) $calculated[
                                    "age_years"
                                ] ?> rokov</td></tr>
                                <tr><th>Pohlavie</th><td><?= htmlspecialchars(
                                    sexLabel($calculated["sex"]),
                                ) ?></td></tr>
                                <tr><th>eGFR</th><td><?= htmlspecialchars(
                                    (string) $calculated["egfr"],
                                ) ?> ml/min/1,73 m²</td></tr>
                                <tr><th>UACR</th><td>
                                    <?= htmlspecialchars(
                                        number_format(
                                            (float) $calculated["uacr_input"],
                                            2,
                                            ",",
                                            " ",
                                        ),
                                    ) ?>
                                    <?= $calculated["uacr_unit"] === "mg_mmol"
                                        ? "mg/mmol"
                                        : "mg/g" ?>
                                    <?php if (
                                        $calculated["uacr_unit"] === "mg_mmol"
                                    ): ?>
                                        (= <?= htmlspecialchars(
                                            number_format(
                                                (float) $calculated[
                                                    "uacr_mg_g"
                                                ],
                                                1,
                                                ",",
                                                " ",
                                            ),
                                        ) ?> mg/g)
                                    <?php endif; ?>
                                </td></tr>
                                <tr><th>DM</th><td><?= boolLabel(
                                    $calculated["diabetes"],
                                ) ?></td></tr>
                                <tr><th>Systolický TK</th><td><?= (int) $calculated[
                                    "sbp"
                                ] ?> mmHg</td></tr>
                                <tr><th>Antihypertenzíva</th><td><?= boolLabel(
                                    $calculated["antihtn"],
                                ) ?></td></tr>
                                <tr><th>Srdcové zlyhanie</th><td><?= boolLabel(
                                    $calculated["hf"],
                                ) ?></td></tr>
                                <tr><th>ICHS</th><td><?= boolLabel(
                                    $calculated["chd"],
                                ) ?></td></tr>
                                <tr><th>Fibrilácia predsiení</th><td><?= boolLabel(
                                    $calculated["afib"],
                                ) ?></td></tr>
                                <tr><th>BMI</th><td><?= htmlspecialchars(
                                    (string) $calculated["bmi"],
                                ) ?> kg/m²</td></tr>
                                <tr><th>Fajčenie</th><td><?= htmlspecialchars(
                                    smokingLabel($calculated["smoking"]),
                                ) ?></td></tr>
                                <?php if ($calculated["diabetes"]): ?>
                                    <tr><th>HbA1c</th><td><?= htmlspecialchars(
                                        number_format(
                                            (float) $calculated["hba1c"],
                                            1,
                                            ",",
                                            " ",
                                        ),
                                    ) ?> %</td></tr>
                                    <tr><th>Inzulín</th><td><?= boolLabel(
                                        $calculated["insulin"],
                                    ) ?></td></tr>
                                    <tr><th>Perorálna antidiabetická liečba</th><td><?= boolLabel(
                                        $calculated["oral_dm"],
                                    ) ?></td></tr>
                                <?php endif; ?>
                            </table>
                        </details>

                        <div class="form-actions no-print calc-result-mt16">
                            <button type="button" class="btn-primary js-print">Tlačiť výpočet</button>
                            <a href="calculator_kfre.php" class="btn-secondary">Otvoriť KFRE (2-ročné &amp; 5-ročné)</a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ── LEGENDA ─────────────────────────────────── -->
                <section class="primary-article kfre-legend" aria-label="Kontext KDIGO 2024 a tri časové horizonty">
                    <h3>Tri časové horizonty KDIGO 2024 CKD</h3>
                    <p>
                        KDIGO 2024 odporúča kombinovať viaceré predikčné nástroje pre komplexné
                        hodnotenie rizika. Táto kalkulačka doplňuje KFRE o 3-ročný horizont
                        a rozšírené vstupné premenné.
                    </p>

                    <div class="kfre-threshold">
                        <h4>2-ročné riziko zlyhania obličiek (KFRE)</h4>
                        <ul>
                            <li><strong>&gt;10 %</strong> — kritérium pre multidisciplinárnu starostlivosť</li>
                            <li><strong>&gt;40 %</strong> — plánovaná náhrada funkcie obličiek (dialýza/transplantácia)</li>
                        </ul>
                        <p><a href="calculator_kfre.php">Otvoriť KFRE kalkulačku →</a></p>
                    </div>

                    <div class="kfre-threshold threshold-warning">
                        <h4>3-ročné riziko progresie CKD (táto kalkulačka — CKD-PC / Grams 2022)</h4>
                        <ul>
                            <li>Platné pre <strong>všetky štádiá CKD</strong> vrátane G1–G2</li>
                            <li>Endpoint: ≥40 % pokles eGFR <em>alebo</em> zlyhanie obličiek</li>
                            <li>Zohľadňuje rozšírené faktory: TK, kardiovaskulárne komorbidity, BMI, fajčenie, DM liečbu</li>
                        </ul>
                        <p>
                            Referencia: <a href="https://pubmed.ncbi.nlm.nih.gov/35856507/" target="_blank" rel="noopener noreferrer">
                                Grams ME et al. Diabetes Care 2022;45:2055–2063.
                            </a>
                        </p>
                    </div>

                    <div class="kfre-threshold">
                        <h4>5-ročné riziko zlyhanie obličiek (KFRE)</h4>
                        <ul>
                            <li><strong>3–5 %</strong> — zvážiť odoslanie k nefrológovi</li>
                            <li><strong>&gt;5 %</strong> — odporúčaná konzultácia nefrológa</li>
                        </ul>
                        <p><a href="calculator_kfre.php">Otvoriť KFRE kalkulačku →</a></p>
                    </div>

                    <div class="kfre-threshold info-box-gray">
                        <h4>Obmedzenia a disclaimer</h4>
                        <p>
                            Koeficienty modelov 1, 2 a 4 (Bez DM a DM eGFR&lt;60) sú odvodené z
                            publikovaných dát Grams 2022. <strong>Model 3 (DM, eGFR≥60)</strong> bol
                            overený oproti ckdpcrisk.org/gfrdecline40/ (default scenario → 1,9 %).
                            Pre klinické rozhodovanie odporúčame validovať výsledky oproti
                            <a href="https://ckdpcrisk.org/gfrdecline40/" target="_blank" rel="noopener noreferrer">
                                oficiálnemu kalkulátoru CKD-PC
                            </a>.
                        </p>
                    </div>
                </section>

            </div><!-- /.auth-container -->

            <?php include "calculator_disclaimer.php"; ?>

                <!-- ── HISTÓRIA ULOŽENÝCH VÝSLEDKOV ──────────────── -->
                <?php if (isLoggedIn()): ?>
                    <section class="auth-container auth-container--wide calc-saved-results" aria-label="Uložené výsledky">
                        <h3>Uložené výsledky</h3>
                        <?php if (empty($savedResults)): ?>
                            <p>Žiadne uložené výsledky.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th>Dátum</th>
                                            <th>Pacient</th>
                                            <th>Model</th>
                                            <th>3-ročné riziko</th>
                                            <th>Akcie</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (
                                            $savedResults
                                            as $row
                                        ): ?>
                                            <tr>
                                                <td><?= htmlspecialchars(
                                                    substr(
                                                        (string) ($row[
                                                            "created_at"
                                                        ] ?? ""),
                                                        0,
                                                        16,
                                                    ),
                                                ) ?></td>
                                                <td><?= htmlspecialchars(
                                                    calculatorBuildPatientDisplay(
                                                        $row,
                                                    ),
                                                ) ?></td>
                                                <td><?= htmlspecialchars(
                                                    (string) ($row[
                                                        "result_payload"
                                                    ]["model_name"] ?? "–"),
                                                ) ?></td>
                                                <td>
                                                    <strong>
                                                        <?= htmlspecialchars(
                                                            number_format(
                                                                (float) ($row[
                                                                    "result_payload"
                                                                ]["risk_3yr"] ??
                                                                    0),
                                                                1,
                                                                ",",
                                                                " ",
                                                            ),
                                                        ) ?> %
                                                    </strong>
                                                </td>
                                                <td>
                                                    <a href="calculator_result_print.php?result_id=<?= (int) $row[
                                                        "id"
                                                    ] ?>"
                                                       target="_blank" class="btn-secondary btn-sm">Tlačiť</a>
                                                    <form method="POST" action="calculator_ckdpc.php"
                                                          class="d-inline"
                                                          data-confirm="Naozaj vymazať tento záznam?">
                                                        <input type="hidden" name="csrf_token"
                                                               value="<?= htmlspecialchars(
                                                                   generateCsrfToken(),
                                                               ) ?>">
                                                        <input type="hidden" name="action" value="delete_saved">
                                                        <input type="hidden" name="result_id" value="<?= (int) $row[
                                                            "id"
                                                        ] ?>">
                                                        <button type="submit" class="btn-secondary btn-sm btn-danger">Vymazať</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>

        </div><!-- /.content-wrapper -->
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime(
        "patient_autofill.js",
    ) ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
