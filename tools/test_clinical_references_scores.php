<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: PLASMIC skóre a klasifikácia TLS podľa Cairo–Bishop.
 *
 * PLASMIC: Bendapudi PK a kol. (Lancet Haematol 2017;4(4):e157–e164, PMID 28259520).
 * TLS: Cairo MS, Bishop M (Br J Haematol 2004;127(1):3–11, PMID 15384972).
 * Pinuje hranice každého kritéria (ostrá vs. neostrá nerovnosť), prepočty prahov
 * do SI jednotiek a rizikové pásma; wiring proti kópii logiky v stránkach.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function scoresRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function scoresRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    scoresRefTest(abs($expected - $actual) <= $tol, $message . ': očakávané ' . $expected . ', získané ' . $actual);
}

// ─── PLASMIC ───
// Typická TTP: trombocyty 12, hemolýza, bez nádoru a transplantácie, MCV 85, INR 1,1, kreatinín 110 → 7
$ttp = plasmicScore(12.0, true, false, false, 85.0, 1.1, 110.0);
scoresRefTest($ttp['score'] === 7, 'Typická TTP má PLASMIC 7.');
// Hranice sú ostré: 30 / 90 / 1,5 / 176,8 už bod nedávajú
$edges = plasmicScore(30.0, true, false, false, 90.0, 1.5, 176.8);
scoresRefTest(!$edges['platelets'] && !$edges['mcv'] && !$edges['inr'] && !$edges['creatinine'], 'Hraničné hodnoty PLASMIC bod nedávajú.');
scoresRefTest($edges['score'] === 3, 'Hraničný prípad: iba hemolýza, bez nádoru, bez transplantácie.');
$justBelow = plasmicScore(29.9, false, false, false, 89.9, 1.49, 176.7);
scoresRefTest($justBelow['score'] === 6, 'Tesne pod hranicou: 6 bodov.');
// Aktívny nádor a transplantácia odoberajú body
scoresRefTest(plasmicScore(12.0, true, true, true, 85.0, 1.1, 110.0)['score'] === 5, 'Nádor + transplantácia → 5.');
// 2,0 mg/dL × CREATININE_UMOL_PER_MGDL = 176,8 µmol/L
scoresRefApprox(creatinineMgDlToUmolL(2.0), PLASMIC_CREA_UMOL, 0.001, 'Prah kreatinínu PLASMIC = 2,0 mg/dL.');
// Rizikové pásma: 0 až 4 nízke, 5 stredné, 6 až 7 vysoké
scoresRefTest(plasmicRiskClass(4) === 'risk-low', 'PLASMIC 4 je nízke riziko.');
scoresRefTest(plasmicRiskClass(5) === 'risk-moderate', 'PLASMIC 5 je stredné riziko.');
scoresRefTest(plasmicRiskClass(6) === 'risk-high' && plasmicRiskClass(7) === 'risk-high', 'PLASMIC 6 až 7 je vysoké riziko.');
scoresRefTest(str_contains(plasmicRiskLabel(6), '62 až 82'), 'Štítok vysokého rizika PLASMIC.');

// ─── Cairo–Bishop TLS ───
// Prepočty prahov: kyselina močová 8 mg/dL · 59,48 = 476; P 4,5 mg/dL / 3,097 = 1,45;
// P 6,5 mg/dL / 3,097 = 2,10; Ca 7 mg/dL / 4,008 = 1,75 mmol/L
scoresRefApprox(8.0 * 59.48, TLS_URIC_ACID, 0.5, 'Prah kyseliny močovej 476 µmol/L.');
scoresRefApprox(4.5 / 3.097, TLS_PHOS_ADULT, 0.01, 'Prah fosfátu dospelí 1,45 mmol/L.');
scoresRefApprox(6.5 / 3.097, TLS_PHOS_CHILD, 0.01, 'Prah fosfátu deti 2,1 mmol/L.');
scoresRefApprox(7.0 / 4.008, TLS_CALCIUM, 0.01, 'Prah vápnika 1,75 mmol/L.');
// Hranice sú neostré (≥ / ≤)
$tlsEdges = tlsCairoBishop(476.0, 6.0, 1.45, 1.75, false, false, false, false);
scoresRefTest($tlsEdges['lab_count'] === 4 && $tlsEdges['ltls'] && !$tlsEdges['ctls'], 'Hraničné hodnoty sa počítajú (≥, ≤).');
$tlsNone = tlsCairoBishop(475.9, 5.9, 1.44, 1.76, false, true, true, true);
scoresRefTest($tlsNone['lab_count'] === 0 && !$tlsNone['ltls'] && !$tlsNone['ctls'], 'Bez laboratórneho TLS nie je klinický TLS ani pri klinických prejavoch.');
// Jedna odchýlka nestačí
$tlsOne = tlsCairoBishop(500.0, 4.5, 1.2, 2.2, false, true, false, false);
scoresRefTest($tlsOne['lab_count'] === 1 && !$tlsOne['ltls'], 'Jedna odchýlka nie je laboratórny TLS.');
// Dve odchýlky + kreatinín → klinický TLS
$tlsClin = tlsCairoBishop(520.0, 6.4, 1.2, 2.2, false, true, false, false);
scoresRefTest($tlsClin['ltls'] && $tlsClin['ctls'] && $tlsClin['clinical_count'] === 1, 'LTLS + kreatinín je klinický TLS.');
// Fosfát 1,8: u dospelého odchýlka, u dieťaťa nie
scoresRefTest(tlsCairoBishop(300.0, 4.0, 1.8, 2.2, false, false, false, false)['phosphate'], 'Fosfát 1,8 je odchýlka u dospelého.');
scoresRefTest(!tlsCairoBishop(300.0, 4.0, 1.8, 2.2, true, false, false, false)['phosphate'], 'Fosfát 1,8 nie je odchýlka u dieťaťa.');
scoresRefTest(tlsRiskLabel(true, true) === 'klinický TLS' && tlsRiskLabel(false, true) === 'laboratórny TLS', 'Štítky TLS.');
scoresRefTest(tlsRiskClass(false, false) === 'risk-low', 'Bez TLS je nízke riziko.');

// ─── Wiring ───
$root = dirname(__DIR__);
$plasmicPage = (string) file_get_contents($root . '/calculator_plasmic.php');
scoresRefTest(str_contains($plasmicPage, 'plasmicScore('), 'calculator_plasmic.php musí volať plasmicScore.');
scoresRefTest(!str_contains($plasmicPage, '< 30.0') && !str_contains($plasmicPage, 'function plasmicRisk'), 'calculator_plasmic.php nesmie mať vlastnú kópiu logiky.');
$tlsPage = (string) file_get_contents($root . '/calculator_tls.php');
scoresRefTest(str_contains($tlsPage, 'tlsCairoBishop('), 'calculator_tls.php musí volať tlsCairoBishop.');
scoresRefTest(!str_contains($tlsPage, 'const TLS_') && !str_contains($tlsPage, '>= TLS_URIC_ACID'), 'calculator_tls.php nesmie mať vlastnú kópiu prahov.');

echo "Clinical references (PLASMIC, Cairo–Bishop TLS): $checks PASS\n";
