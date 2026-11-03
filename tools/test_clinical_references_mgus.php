<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: Mayo riziková stratifikácia MGUS.
 *
 * Rajkumar SV a kol. (Blood 2005;106(3):812–817, PMID 15855274): rizikové faktory
 * M-proteín ≥ 15 g/L, izotyp iný než IgG, abnormálny pomer κ/λ; 20-ročné riziko
 * progresie 5 / 21 / 37 / 58 % pri 0 / 1 / 2 / 3 faktoroch (overené v abstrakte).
 * Normálne rozpätie κ/λ 0,26 až 1,65 (Katzmann 2002).
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function mgusRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

// Bez faktorov: IgG 10 g/L, κ 15 / λ 12 mg/L (pomer 1,25)
$low = mgusMayoRisk(10.0, false, 15.0, 12.0);
mgusRefTest(abs($low['ratio'] - 1.25) < 1e-9 && $low['factors'] === 0, 'Bez rizikových faktorov.');
mgusRefTest(mgusProgressionPct(0) === 5 && mgusRiskClass(0) === 'risk-low', '0 faktorov: 5 %, nízke riziko.');
// Všetky tri: IgA 20 g/L, κ 120 / λ 10 (pomer 12)
$high = mgusMayoRisk(20.0, true, 120.0, 10.0);
mgusRefTest($high['factors'] === 3 && $high['abnormal_flc'] && $high['high_m_protein'], 'Tri rizikové faktory.');
mgusRefTest(mgusProgressionPct(3) === 58 && mgusRiskClass(3) === 'risk-high', '3 faktory: 58 %, vysoké riziko.');
mgusRefTest(mgusProgressionPct(1) === 21 && mgusProgressionPct(2) === 37, '1 a 2 faktory: 21 a 37 %.');
mgusRefTest(mgusRiskLabel(1) === 'nízko-stredné riziko' && mgusRiskLabel(2) === 'stredne-vysoké riziko', 'Štítky 1 a 2 faktorov.');

// Hranice: M-proteín presne 15 g/L je rizikový faktor (≥)
mgusRefTest(mgusMayoRisk(15.0, false, 15.0, 12.0)['high_m_protein'], 'M-proteín 15 g/L je faktor.');
mgusRefTest(!mgusMayoRisk(14.9, false, 15.0, 12.0)['high_m_protein'], 'M-proteín 14,9 g/L nie je faktor.');
// Pomer presne na hranici rozpätia je normálny, mimo neho abnormálny
mgusRefTest(!mgusMayoRisk(10.0, false, 26.0, 100.0)['abnormal_flc'], 'Pomer 0,26 je normálny.');
mgusRefTest(mgusMayoRisk(10.0, false, 25.0, 100.0)['abnormal_flc'], 'Pomer 0,25 je abnormálny.');
mgusRefTest(!mgusMayoRisk(10.0, false, 165.0, 100.0)['abnormal_flc'], 'Pomer 1,65 je normálny.');
mgusRefTest(mgusMayoRisk(10.0, false, 166.0, 100.0)['abnormal_flc'], 'Pomer 1,66 je abnormálny.');
// Izotyp sám o sebe
mgusRefTest(mgusMayoRisk(10.0, true, 15.0, 12.0)['factors'] === 1, 'Iný izotyp než IgG je jeden faktor.');

try {
    mgusMayoRisk(10.0, false, 15.0, 0.0);
    mgusRefTest(false, 'Nulové λ musí vyhodiť výnimku.');
} catch (InvalidArgumentException) {
    mgusRefTest(true, 'Nulové λ vyhodí výnimku.');
}

// Wiring
$page = (string) file_get_contents(dirname(__DIR__) . '/calculator_mgus.php');
mgusRefTest(str_contains($page, 'mgusMayoRisk('), 'calculator_mgus.php musí volať mgusMayoRisk.');
mgusRefTest(
    !str_contains($page, 'const MGUS_FLC') && !str_contains($page, 'function mgusRisk') && !str_contains($page, '>= 15.0'),
    'calculator_mgus.php nesmie mať vlastnú kópiu logiky.',
);

echo "Clinical references (Mayo MGUS): $checks PASS\n";
