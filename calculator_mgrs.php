<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/**
 * Klasifikácia podľa konsenzu IKMG (Leung 2019) — hierarchické určenie kategórie.
 *
 * MGRS = klon B-buniek / plazmocytov produkujúci monoklonálny imunoglobulín, ktorý
 * spôsobuje obličkové poškodenie, ALE nespĺňa kritériá hematologickej malignity
 * vyžadujúcej cielenú liečbu. Biopsia s monoklonálnymi depozitmi dokladá klon aj
 * pri negatívnom sére/moči (~30 % MGRS).
 *
 * @return array{code: string, label: string, risk_class: string}
 */
function mgrsClassify(bool $cloneEvidence, bool $biopsyMGRS, bool $clinicalRenal, bool $hasMalignancy): array
{
    $hasClone = $cloneEvidence || $biopsyMGRS;
    $hasRenal = $biopsyMGRS || $clinicalRenal;

    if ($hasMalignancy) {
        if ($hasRenal) {
            return [
                'code' => 'Malignita',
                'label' => 'paraproteinémická renálna lézia pri hematologickej malignite (mimo definície MGRS)',
                'risk_class' => 'risk-high',
            ];
        }
        return [
            'code' => 'Malignita',
            'label' => 'hematologická malignita vyžadujúca cielenú liečbu',
            'risk_class' => 'risk-high',
        ];
    }
    if ($hasClone && $hasRenal) {
        if ($biopsyMGRS) {
            return [
                'code' => 'MGRS',
                'label' => 'MGRS — potvrdená obličkovou biopsiou',
                'risk_class' => 'risk-high',
            ];
        }
        return [
            'code' => 'MGRS?',
            'label' => 'MGRS pravdepodobná — nutné potvrdenie obličkovou biopsiou',
            'risk_class' => 'risk-high',
        ];
    }
    if ($hasClone) {
        return [
            'code' => 'MGUS',
            'label' => 'monoklonálna gamapatia bez doloženého renálneho významu (MGUS)',
            'risk_class' => 'risk-low',
        ];
    }
    if ($hasRenal) {
        return [
            'code' => 'Klon?',
            'label' => 'renálne postihnutie bez doloženého klonu — hľadaj okultnú monoklonálnu gamapatiu',
            'risk_class' => 'risk-moderate',
        ];
    }
    return [
        'code' => '—',
        'label' => 'nedostatok kritérií na klasifikáciu',
        'risk_class' => 'risk-low',
    ];
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "m_protein" => isset($_POST["m_protein"]) ? "1" : "",
    "abnormal_flc" => isset($_POST["abnormal_flc"]) ? "1" : "",
    "marrow_clone" => isset($_POST["marrow_clone"]) ? "1" : "",
    "biopsy_mgrs" => isset($_POST["biopsy_mgrs"]) ? "1" : "",
    "clinical_renal" => isset($_POST["clinical_renal"]) ? "1" : "",
    "mm_criteria" => isset($_POST["mm_criteria"]) ? "1" : "",
    "lymphoma_criteria" => isset($_POST["lymphoma_criteria"]) ? "1" : "",
    "end_organ" => isset($_POST["end_organ"]) ? "1" : "",
    "patient_first_name" => (string) ($_POST["patient_first_name"] ?? ""),
    "patient_last_name" => (string) ($_POST["patient_last_name"] ?? ""),
    "patient_birth_date" => (string) ($_POST["patient_birth_date"] ?? ""),
    "patient_birth_number" => (string) ($_POST["patient_birth_number"] ?? ""),
    "patient_insurance_code" => (string) ($_POST["patient_insurance_code"] ?? ""),
    "examination_date" => (string) ($_POST["examination_date"] ?? date("Y-m-d")),
];

calculatorHandleLoadId($pdo, $form, $messages);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = (string) ($_POST["action"] ?? "");

    if (!validateCsrfToken((string) ($_POST["csrf_token"] ?? ""))) {
        $errors[] = "Neplatný CSRF token.";
    } elseif ($action === "delete_saved") {
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_mgrs');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        if (empty($errors)) {
            $mProtein = $form["m_protein"] === "1";
            $abnormalFlc = $form["abnormal_flc"] === "1";
            $marrowClone = $form["marrow_clone"] === "1";
            $biopsyMgrs = $form["biopsy_mgrs"] === "1";
            $clinicalRenal = $form["clinical_renal"] === "1";
            $mmCriteria = $form["mm_criteria"] === "1";
            $lymphomaCriteria = $form["lymphoma_criteria"] === "1";
            $endOrgan = $form["end_organ"] === "1";

            $cloneEvidence = $mProtein || $abnormalFlc || $marrowClone;
            $hasMalignancy = $mmCriteria || $lymphomaCriteria || $endOrgan;

            $class = mgrsClassify($cloneEvidence, $biopsyMgrs, $clinicalRenal, $hasMalignancy);

            $calculated = [
                "code" => $class["code"],
                "label" => $class["label"],
                "risk_class" => $class["risk_class"],
                "clone_evidence" => $cloneEvidence,
                "biopsy_mgrs" => $biopsyMgrs,
                "clinical_renal" => $clinicalRenal,
                "has_renal" => $biopsyMgrs || $clinicalRenal,
                "has_malignancy" => $hasMalignancy,
                "m_protein" => $mProtein,
                "abnormal_flc" => $abnormalFlc,
                "marrow_clone" => $marrowClone,
                "mm_criteria" => $mmCriteria,
                "lymphoma_criteria" => $lymphomaCriteria,
                "end_organ" => $endOrgan,
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "m_protein" => $mProtein,
                            "abnormal_flc" => $abnormalFlc,
                            "marrow_clone" => $marrowClone,
                            "biopsy_mgrs" => $biopsyMgrs,
                            "clinical_renal" => $clinicalRenal,
                            "mm_criteria" => $mmCriteria,
                            "lymphoma_criteria" => $lymphomaCriteria,
                            "end_organ" => $endOrgan,
                        ];
                        $resultPayload = [
                            "code" => $class["code"],
                            "label" => $class["label"],
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "mgrs_class",
                                "MGRS — klasifikácia (renálny význam)",
                                $patient,
                                $inputPayload,
                                $resultPayload,
                            )
                        ) {
                            $messages[] = "Výsledok bol uložený do databázy.";
                        } else {
                            $errors[] = "Výsledok sa nepodarilo uložiť.";
                        }
                    } catch (\PDOException $e) {
                        $errors[] = "Databázová chyba pri ukladaní výsledku.";
                        error_log("calculator_mgrs save error: " . $e->getMessage());
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
            "mgrs_class",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_mgrs fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "MGRS — klasifikácia (monoklonálna gamapatia renálneho významu) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_mgrs.php";
  $seoDescription =
      "Klasifikačná pomôcka MGRS (monoklonálna gamapatia renálneho významu) podľa konsenzu IKMG (Leung 2019): odlíši MGRS od MGUS a od hematologickej malignity vyžadujúcej liečbu. MGRS = klon spôsobujúci obličkové poškodenie bez kritérií malignity — vyžaduje renálnu biopsiu, hematológa a klon-cielenú liečbu napriek nízkej náloži.";
  $baseUrl = "https://nefro.polascin.net/";
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
                  "name" => "MGRS — klasifikácia (renálny význam)",
                  "item" => $baseUrl . "calculator_mgrs.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="mgrs_class">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "MGRS — klasifikácia";
    $headerIntro = "Monoklonálna gamapatia renálneho významu (IKMG, Leung 2019)";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>MGRS — klasifikácia (renálny význam)</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + dôkaz klonu, renálne postihnutie a kritériá malignity pre zaradenie.</p>

                <div class="info-box">
                    <strong>Čo robí:</strong> <strong>MGRS</strong> (monoklonálna gamapatia
                    <em>renálneho</em> významu) je klon B-buniek alebo plazmocytov, ktorý produkuje
                    nefrotoxický monoklonálny imunoglobulín a <strong>spôsobuje obličkové
                    poškodenie</strong>, no <strong>nespĺňa kritériá</strong> mnohopočetného myelómu
                    ani inej hematologickej malignity vyžadujúcej liečbu. Tento klasifikátor odlíši
                    MGRS od <a href="calculator_mgus.php">MGUS</a> (bez renálneho významu) a od
                    malignity. Pri MGRS je liečba cielená na klon indikovaná <em>napriek nízkej
                    nádorovej náloži</em> — kvôli záchrane obličiek.
                </div>

                <div class="info-box-yellow">
                    <strong>Pozor:</strong> ide o <strong>edukačnú operacionalizáciu</strong>
                    konsenzu — diagnóza MGRS stojí na <strong>obličkovej biopsii</strong>
                    (imunofluorescencia / elektrónová mikroskopia / typizácia ľahkých reťazcov)
                    a na <strong>hematologickej konzultácii</strong>. Až ~30 % prípadov má
                    negatívnu sérovú aj močovú imunofixáciu — diagnózu vtedy nesie biopsia.
                    Nástroj nenahrádza biopsiu ani odborné posúdenie.
                </div>

                <details open class="calc-formula-box">
                    <summary>Logika klasifikácie (hierarchicky)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-vars">
                            <strong>Malignita</strong> — splnené kritériá hematologickej malignity vyžadujúcej liečbu (renálna lézia sa rieši v jej kontexte, nie ako MGRS) &bull;
                            <strong>MGRS</strong> — dôkaz klonu <em>a zároveň</em> renálne postihnutie pripísateľné paraproteínu, bez kritérií malignity &bull;
                            <strong>MGUS</strong> — dôkaz klonu bez renálneho postihnutia &bull;
                            <strong>Klon?</strong> — renálne postihnutie bez doloženého klonu (hľadaj okultný klon) &bull;
                            <strong>—</strong> — nedostatok kritérií
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroj:</strong>
                    <a href="https://pubmed.ncbi.nlm.nih.gov/30401957/" target="_blank" rel="noopener noreferrer">Leung N. et&nbsp;al., International Kidney and Monoclonal Gammopathy Research Group (IKMG) consensus, Nat Rev Nephrol 2019;15(1):45–59</a>
                </div>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars($message) ?></p></div>
                <?php endforeach; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="calculator_mgrs.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Dátum vyšetrenia</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <fieldset class="form-fieldset">
                            <legend>1. Dôkaz monoklonálneho klonu</legend>
                            <div class="form-check-grid">
                                <label class="form-check"><input type="checkbox" name="m_protein" value="1" <?= $form["m_protein"] === "1" ? "checked" : "" ?>> Monoklonálny proteín v sére alebo moči (SPEP/UPEP + imunofixácia) <span class="form-check-pts">(klon)</span></label>
                                <label class="form-check"><input type="checkbox" name="abnormal_flc" value="1" <?= $form["abnormal_flc"] === "1" ? "checked" : "" ?>> Abnormálny pomer voľných ľahkých reťazcov (κ/λ mimo normy) <span class="form-check-pts">(klon)</span></label>
                                <label class="form-check"><input type="checkbox" name="marrow_clone" value="1" <?= $form["marrow_clone"] === "1" ? "checked" : "" ?>> Klonálna populácia v kostnej dreni (plazmocyty / B-lymfocyty) <span class="form-check-pts">(klon)</span></label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="form-section">
                        <fieldset class="form-fieldset">
                            <legend>2. Renálne postihnutie pripísateľné paraproteínu</legend>
                            <div class="form-check-grid">
                                <label class="form-check"><input type="checkbox" name="biopsy_mgrs" value="1" <?= $form["biopsy_mgrs"] === "1" ? "checked" : "" ?>> Obličková biopsia: lézia s monoklonálnymi depozitmi (AL amyloidóza, MIDD, PGNMID, fibrilárna/imunotaktoidná GN, C3G s gamapatiou, light-chain proximálna tubulopatia, kryoglobulinemická GN typ I) <span class="form-check-pts">(renálne + dôkaz klonu)</span></label>
                                <label class="form-check"><input type="checkbox" name="clinical_renal" value="1" <?= $form["clinical_renal"] === "1" ? "checked" : "" ?>> Klinické renálne prejavy (proteinúria/albuminúria, pokles eGFR alebo AKI, glomerulárna hematúria) bez inej jasnej príčiny <span class="form-check-pts">(renálne)</span></label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="form-section">
                        <fieldset class="form-fieldset">
                            <legend>3. Kritériá malignity vyžadujúcej liečbu (vylučujú MGRS)</legend>
                            <div class="form-check-grid">
                                <label class="form-check"><input type="checkbox" name="mm_criteria" value="1" <?= $form["mm_criteria"] === "1" ? "checked" : "" ?>> ≥ 10 % klonálnych plazmocytov v dreni + myelóm-definujúca udalosť (SLiM: ≥ 60 % plazmocytov / FLC pomer ≥ 100 / &gt; 1 fokálna MRI lézia — renálne kritérium tu nerozhoduje) <span class="form-check-pts">(malignita)</span></label>
                                <label class="form-check"><input type="checkbox" name="lymphoma_criteria" value="1" <?= $form["lymphoma_criteria"] === "1" ? "checked" : "" ?>> Symptomatický lymfóm / Waldenströmova makroglobulinémia / CLL spĺňajúci kritériá na liečbu <span class="form-check-pts">(malignita)</span></label>
                                <label class="form-check"><input type="checkbox" name="end_organ" value="1" <?= $form["end_organ"] === "1" ? "checked" : "" ?>> Hyperkalciémia, osteolytické lézie alebo anémia jasne z plazmocelulárnej dyskrázie <span class="form-check-pts">(malignita)</span></label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Klasifikovať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Klasifikovať a uložiť</button>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </form>

                <?php if ($calculated !== null):
                    $riskCls = (string) $calculated["risk_class"];
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($riskCls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok klasifikácie</h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= htmlspecialchars((string) $calculated["code"]) ?></span>
                                <span class="calc-result-unit">kategória</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars((string) $calculated["label"]) ?>
                            </div>
                        </div>
                        <p class="calc-result-detail"><strong>Zachytené komponenty:</strong>
                            dôkaz klonu: <?= $calculated["clone_evidence"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; biopsia s monoklonálnymi depozitmi: <?= $calculated["biopsy_mgrs"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; klinické renálne prejavy: <?= $calculated["clinical_renal"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; kritériá malignity: <?= $calculated["has_malignancy"] ? "✓" : "✗" ?>
                        </p>
                        <?php if ($calculated["code"] === "MGRS" || $calculated["code"] === "MGRS?"): ?>
                            <p class="calc-result-detail"><strong>MGRS.</strong> Indikovaná <strong>klon-cielená liečba</strong> (podľa typu klonu — plazmocelulárny vs. B-lymfocytový) v spolupráci s hematológom, <em>napriek nízkej nádorovej náloži</em>, s cieľom zachovať funkciu obličiek a znížiť riziko recidívy po prípadnej transplantácii.
                            <?php if ($calculated["code"] === "MGRS?"): ?>
                                Pred liečbou je nutné <strong>potvrdenie obličkovou biopsiou</strong> — typizovať léziu a depozity.
                            <?php endif; ?>
                            </p>
                        <?php elseif ($calculated["code"] === "Malignita"): ?>
                            <p class="calc-result-detail"><strong>Mimo definície MGRS.</strong> Klon spĺňa kritériá hematologickej malignity vyžadujúcej liečbu — manažment vedie <strong>hematológ/onkológ</strong> podľa danej diagnózy.
                            <?php if ($calculated["has_renal"]): ?>
                                Renálna lézia je paraproteinémická, no rieši sa v rámci liečby malignity.
                            <?php endif; ?>
                            </p>
                        <?php elseif ($calculated["code"] === "MGUS"): ?>
                            <p class="calc-result-detail"><strong>MGUS.</strong> Bez doloženého renálneho významu — sledovanie podľa <a href="calculator_mgus.php">Mayo rizikovej stratifikácie</a>. Pri objavení sa renálnych prejavov (proteinúria, pokles eGFR) prehodnoť na MGRS vrátane biopsie.</p>
                        <?php elseif ($calculated["code"] === "Klon?"): ?>
                            <p class="calc-result-detail"><strong>Renálne postihnutie bez doloženého klonu.</strong> Ak biopsia ukazuje monoklonálne depozity, hľadaj <strong>okultný klon</strong> (citlivá sérová FLC, imunofixácia séra aj moču, prietoková cytometria dreňe, prípadne PET/CT) — až ~30 % MGRS má negatívne sérum/moč. Inak zváž inú príčinu obličkového postihnutia.</p>
                        <?php else: ?>
                            <p class="calc-result-detail"><strong>Nedostatok kritérií.</strong> Doplň dôkaz klonu (imunofixácia, FLC, kostná dreň) a posúdenie renálneho postihnutia.</p>
                        <?php endif; ?>
                        <p class="calc-result-detail">Klasifikácia je <strong>pomôcka</strong>, nie diagnostický test — definitívna diagnóza MGRS stojí na obličkovej biopsii a hematologickom posúdení.</p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výsledok</button>
                            <a href="calculator_history.php?calc=mgrs_class" class="btn-secondary">História MGRS</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_mgrs.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $code  = (string) ($result['code'] ?? '');
                    $label = (string) ($result['label'] ?? '');
                    echo htmlspecialchars($code !== '' ? $code : '?');
                    if ($label !== '') {
                        echo ' (' . htmlspecialchars($label) . ')';
                    }
                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
