<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: Mehran skóre CI-AKI.
 *
 * Mehran R a kol. (J Am Coll Cardiol 2004;44(7):1393–1399, PMID 15464318):
 * hypotenzia / IABP / CHF = 5; vek > 75 = 4; anémia / DM = 3; kontrast ≈ 1 / 100 mL;
 * eGFR ≥ 60 = 0, 40 až < 60 = 2, 20 až < 40 = 4, < 20 = 6.
 * Kategórie CIN: ≤ 5 → 7,5 %; 6–10 → 14,0 %; 11–15 → 26,1 %; ≥ 16 → 57,3 %.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function mehranRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

// Renálne pásma (hranice sú ≥)
mehranRefTest(mehranRenalPoints(60.0) === 0, 'eGFR 60 → 0 bodov.');
mehranRefTest(mehranRenalPoints(59.9) === 2, 'eGFR 59,9 → 2 body.');
mehranRefTest(mehranRenalPoints(40.0) === 2, 'eGFR 40 → 2 body.');
mehranRefTest(mehranRenalPoints(39.9) === 4, 'eGFR 39,9 → 4 body.');
mehranRefTest(mehranRenalPoints(20.0) === 4, 'eGFR 20 → 4 body.');
mehranRefTest(mehranRenalPoints(19.9) === 6, 'eGFR 19,9 → 6 bodov.');

// Vek: ostrá hranica > 75
$age75 = mehranScore(75, 90.0, 0.0, false, false, false, false, false);
mehranRefTest($age75['age_pts'] === 0 && $age75['score'] === 0, 'Vek 75 bez ďalších faktorov → 0.');
$age76 = mehranScore(76, 90.0, 0.0, false, false, false, false, false);
mehranRefTest($age76['age_pts'] === 4 && $age76['score'] === 4, 'Vek 76 → 4 body.');

// Kontrast: round(ml / 100)
$c150 = mehranScore(60, 90.0, 150.0, false, false, false, false, false);
mehranRefTest($c150['contrast_pts'] === 2 && $c150['score'] === 2, 'Kontrast 150 mL → 2 body.');
$c149 = mehranScore(60, 90.0, 149.0, false, false, false, false, false);
mehranRefTest($c149['contrast_pts'] === 1, 'Kontrast 149 mL → 1 bod (zaokrúhlenie).');

// Binárne body
$hypo = mehranScore(60, 90.0, 0.0, true, false, false, false, false);
mehranRefTest($hypo['hypotension_pts'] === 5 && $hypo['score'] === 5, 'Hypotenzia → 5.');
$iabp = mehranScore(60, 90.0, 0.0, false, true, false, false, false);
mehranRefTest($iabp['iabp_pts'] === 5 && $iabp['score'] === 5, 'IABP → 5.');
$chf = mehranScore(60, 90.0, 0.0, false, false, true, false, false);
mehranRefTest($chf['chf_pts'] === 5 && $chf['score'] === 5, 'CHF → 5.');
$anemia = mehranScore(60, 90.0, 0.0, false, false, false, true, false);
mehranRefTest($anemia['anemia_pts'] === 3 && $anemia['score'] === 3, 'Anémia → 3.');
$dm = mehranScore(60, 90.0, 0.0, false, false, false, false, true);
mehranRefTest($dm['diabetes_pts'] === 3 && $dm['score'] === 3, 'Diabetes → 3.');

// Zložený príklad: vek 80, eGFR 35, kontrast 200 mL, DM + anémia
// 4 + 4 + 2 + 3 + 3 = 16 → veľmi vysoké
$high = mehranScore(80, 35.0, 200.0, false, false, false, true, true);
mehranRefTest(
    $high['score'] === 16
        && $high['age_pts'] === 4
        && $high['renal_pts'] === 4
        && $high['contrast_pts'] === 2
        && $high['anemia_pts'] === 3
        && $high['diabetes_pts'] === 3,
    'Zložený príklad → skóre 16.',
);
[$cls, $label, $cin, $dial] = mehranCategory($high['score']);
mehranRefTest($cls === 'risk-very-high' && $cin === '57,3 %' && $dial === '12,6 %', 'Skóre 16 je veľmi vysoké.');
mehranRefTest(str_contains($label, 'Veľmi vysoké'), 'Štítok veľmi vysokého rizika.');

// Kategórie na hraniciach
[$cls5] = mehranCategory(5);
[$cls6] = mehranCategory(6);
[$cls10] = mehranCategory(10);
[$cls11] = mehranCategory(11);
[$cls15] = mehranCategory(15);
mehranRefTest($cls5 === 'risk-low', 'Skóre 5 je nízke.');
mehranRefTest($cls6 === 'risk-moderate' && $cls10 === 'risk-moderate', 'Skóre 6 až 10 je stredné.');
mehranRefTest($cls11 === 'risk-high' && $cls15 === 'risk-high', 'Skóre 11 až 15 je vysoké.');

// Wiring: stránka volá spoločnú funkciu, nemá vlastnú kópiu súčtu
$root = dirname(__DIR__);
$page = (string) file_get_contents($root . '/calculator_mehran.php');
mehranRefTest(str_contains($page, 'mehranScore('), 'calculator_mehran.php musí volať mehranScore.');
mehranRefTest(
    !preg_match('/\$agePts\s*=/', $page)
        && !preg_match('/function\s+mehranScore\s*\(/', $page)
        && !preg_match('/function\s+mehranRenalPoints\s*\(/', $page)
        && !preg_match('/function\s+mehranCategory\s*\(/', $page),
    'calculator_mehran.php nesmie mať vlastnú kópiu Mehran logiky.',
);
mehranRefTest(
    str_contains($page, 'pubmed.ncbi.nlm.nih.gov/15464318/'),
    'calculator_mehran.php musí citovať PMID 15464318.',
);

echo "Mehran clinical references: $checks PASS\n";
