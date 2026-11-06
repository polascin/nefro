<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: Gupta skóre ťažkej AKI po cisplatine.
 *
 * Gupta S a kol. (BMJ 2024;384:e077169, PMID 38538012, PMC10964715). Z textu článku
 * sú overené kategórie premenných (vek ≤ 45 / 46 až 60 / 61 až 70; Hb < 110 / 110 až 119 /
 * ≥ 120 g/L; leukocyty > 12; albumín < 33 / 33 až 38 / > 38 g/L; dávka ≤ 50 až > 200 mg)
 * a rozsah 0 až 22,5 bodu. Bodové hodnoty sú z obr. 2 (v teste pinované podľa kódu).
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function guptaRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

// Maximum podľa článku: 22,5 bodu
$max = guptaScore(80.0, true, true, 9.0, 15.0, 100.0, 2.5, 0.6, 250.0);
guptaRefTest($max['score'] === 22.5, 'Maximálne skóre je 22,5 (článok: 0 až 22,5).');
// Minimum: 0 bodov
$min = guptaScore(40.0, false, false, 13.0, 8.0, 250.0, 4.2, 0.9, 40.0);
guptaRefTest($min['score'] === 0.0, 'Minimálne skóre je 0.');

// Hranice kategórií podľa textu článku (ostrá vs. neostrá nerovnosť)
guptaRefTest(guptaAgePoints(45.0) === 0.0 && guptaAgePoints(46.0) > 0.0, 'Vek ≤ 45 je referencia.');
guptaRefTest(guptaAgePoints(60.0) === guptaAgePoints(46.0) && guptaAgePoints(61.0) > guptaAgePoints(60.0), 'Vek 46 až 60 je jedna kategória.');
guptaRefTest(guptaAgePoints(70.0) === guptaAgePoints(61.0) && guptaAgePoints(71.0) > guptaAgePoints(70.0), 'Vek 61 až 70 je jedna kategória.');
guptaRefTest(guptaHbPoints(12.0) === 0.0 && guptaHbPoints(11.9) > 0.0, 'Hb ≥ 120 g/L je referencia.');
guptaRefTest(guptaHbPoints(11.0) === guptaHbPoints(11.9) && guptaHbPoints(10.9) > guptaHbPoints(11.0), 'Hb 110 až 119 g/L je jedna kategória.');
guptaRefTest(guptaAlbPoints(3.81) === 0.0 && guptaAlbPoints(3.8) > 0.0, 'Albumín > 38 g/L je referencia.');
guptaRefTest(guptaAlbPoints(3.3) === guptaAlbPoints(3.8) && guptaAlbPoints(3.29) > guptaAlbPoints(3.3), 'Albumín 33 až 38 g/L je jedna kategória.');
guptaRefTest(guptaScore(40.0, false, false, 13.0, 12.0, 250.0, 4.2, 0.9, 40.0)['wbc'] === 0.0, 'Leukocyty 12,0 bod nedávajú.');
guptaRefTest(guptaScore(40.0, false, false, 13.0, 12.1, 250.0, 4.2, 0.9, 40.0)['wbc'] > 0.0, 'Leukocyty > 12,0 dávajú bod.');
$doseEdges = [50.0, 75.0, 100.0, 125.0, 150.0, 200.0];
$prev = -1.0;
foreach ($doseEdges as $edge) {
    $atEdge = guptaDosePoints($edge);
    guptaRefTest($atEdge > $prev, "Dávka {$edge} mg patrí do vyššej kategórie než predošlá hranica.");
    guptaRefTest(guptaDosePoints($edge + 1.0) > $atEdge, "Dávka nad {$edge} mg zvyšuje body.");
    $prev = $atEdge;
}
guptaRefTest(guptaDosePoints(50.0) === 0.0, 'Dávka ≤ 50 mg je referencia.');

// Horčík: hranica < 0,82 mmol/L podľa článku (regresia: 0,82 mmol/L · 2,43 = 1,99 mg/dL < 2,0 dávalo bod)
guptaRefTest(str_contains((string) file_get_contents(dirname(__DIR__) . '/calculator_gupta.php'), 'Magnézium (mmol/l):</strong> ≥0,82 → 0 · &lt;0,82 → 1'), 'Legenda stránky uvádza hranicu 0,82 mmol/l.');
guptaRefTest(guptaScore(40.0, false, false, 13.0, 8.0, 250.0, 4.2, 0.82, 40.0)['mg'] === 0.0, 'Mg 0,82 mmol/L bod nedáva.');
guptaRefTest(guptaScore(40.0, false, false, 13.0, 8.0, 250.0, 4.2, 0.81, 40.0)['mg'] === 1.0, 'Mg 0,81 mmol/L dáva bod.');
guptaRefTest(guptaScore(40.0, false, false, 13.0, 8.0, 250.0, 4.2, magnesiumMgDlToMmolL(2.0), 40.0)['mg'] === 0.0, 'Mg 2,0 mg/dL (0,823 mmol/L) bod nedáva.');
guptaRefTest(guptaScore(40.0, false, false, 13.0, 8.0, 250.0, 4.2, magnesiumMgDlToMmolL(1.99), 40.0)['mg'] === 1.0, 'Mg 1,99 mg/dL (0,819 mmol/L) dáva bod.');

// Súčet bodov zodpovedá zložkám
$mixed = guptaScore(58.0, true, false, 11.5, 9.0, 140.0, 3.5, 0.86, 140.0);
guptaRefTest(
    $mixed['score'] === $mixed['age'] + $mixed['htn'] + $mixed['dm'] + $mixed['hb'] + $mixed['wbc']
        + $mixed['plt'] + $mixed['alb'] + $mixed['mg'] + $mixed['dose'],
    'Skóre je súčtom zložiek.',
);

// Rizikové kategórie: každý rozsah skóre patrí práve do jednej z nich, monotónne
$order = ['low' => 0, 'moderate' => 1, 'high' => 2, 'veryhigh' => 3];
$last = 0;
for ($s = 0.0; $s <= 22.5; $s += 0.5) {
    $rank = $order[guptaRiskCategory($s)['code']];
    guptaRefTest($rank >= $last, "Kategória pri skóre {$s} nesmie klesnúť.");
    $last = $rank;
}
guptaRefTest(guptaRiskCategory(0.0)['code'] === 'low' && guptaRiskCategory(22.5)['code'] === 'veryhigh', 'Krajné kategórie.');

// Wiring a citácia
$page = (string) file_get_contents(dirname(__DIR__) . '/calculator_gupta.php');
guptaRefTest(str_contains($page, 'guptaScore(') && !str_contains($page, 'function guptaAgePoints'), 'Stránka volá spoločnú guptaScore.');
guptaRefTest(
    str_contains($page, 'pubmed.ncbi.nlm.nih.gov/38538012/') && str_contains($page, 'BMJ 2024;384:e077169') && !str_contains($page, '38538052'),
    'Citácia Gupta: PMID 38538012, BMJ 2024;384.',
);

echo "Clinical references (Gupta CP-AKI): $checks PASS\n";
