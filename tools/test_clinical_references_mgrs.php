<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: klasifikácia MGRS (IKMG checklist).
 *
 * Leung N a kol. (Nat Rev Nephrol 2019;15(1):45–59, PMID 30510265): MGRS = klon
 * spôsobujúci obličkové poškodenie bez kritérií malignity vyžadujúcej liečbu.
 * Hierarchia: malignita > MGRS (biopsia / pravdepodobná) > MGUS > okultný klon.
 * Biopsia s monoklonálnymi depozitmi dokladá klon aj pri negatívnom sére/moči.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function mgrsRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

// Bez kritérií
$empty = mgrsClassify(false, false, false, false);
mgrsRefTest($empty['code'] === '—' && $empty['risk_class'] === 'risk-low', 'Bez kritérií: nedostatok údajov.');

// Len dôkaz klonu → MGUS
$mgus = mgrsClassify(true, false, false, false);
mgrsRefTest($mgus['code'] === 'MGUS' && $mgus['risk_class'] === 'risk-low', 'Klon bez renálneho významu = MGUS.');

// Klinické renálne postihnutie bez klonu → hľadaj okultný klon
$occult = mgrsClassify(false, false, true, false);
mgrsRefTest($occult['code'] === 'Klon?' && $occult['risk_class'] === 'risk-moderate', 'Renálne postihnutie bez klonu.');

// Biopsia MGRS sama dokladá klon aj renálne postihnutie
$biopsy = mgrsClassify(false, true, false, false);
mgrsRefTest($biopsy['code'] === 'MGRS' && str_contains($biopsy['label'], 'biopsiou'), 'Biopsia potvrdzuje MGRS bez sérového klonu.');

// Klon + klinické renálne postihnutie bez biopsie → MGRS?
$probable = mgrsClassify(true, false, true, false);
mgrsRefTest($probable['code'] === 'MGRS?' && $probable['risk_class'] === 'risk-high', 'Klon + klinické renálne = MGRS pravdepodobná.');

// Klon + biopsia → potvrdená MGRS (nie MGRS?)
$confirmed = mgrsClassify(true, true, true, false);
mgrsRefTest($confirmed['code'] === 'MGRS', 'Biopsia má prednosť pred MGRS?.');

// Malignita vylučuje MGRS aj pri biopsii / renálnom postihnutí
$maligRenal = mgrsClassify(true, true, true, true);
mgrsRefTest(
    $maligRenal['code'] === 'Malignita' && str_contains($maligRenal['label'], 'mimo definície MGRS'),
    'Malignita + renálna lézia nie je MGRS.',
);
$maligOnly = mgrsClassify(true, false, false, true);
mgrsRefTest(
    $maligOnly['code'] === 'Malignita' && !str_contains($maligOnly['label'], 'mimo definície'),
    'Malignita bez renálnej lézie.',
);

// Wiring a citácia
$page = (string) file_get_contents(dirname(__DIR__) . '/calculator_mgrs.php');
mgrsRefTest(str_contains($page, 'mgrsClassify('), 'calculator_mgrs.php musí volať mgrsClassify.');
mgrsRefTest(
    !str_contains($page, 'function mgrsClassify'),
    'calculator_mgrs.php nesmie mať vlastnú kópiu logiky.',
);
mgrsRefTest(
    str_contains($page, 'pubmed.ncbi.nlm.nih.gov/30510265/')
        && str_contains($page, 'Nat Rev Nephrol 2019;15(1):45')
        && str_contains($page, 'IKMG'),
    'Citácia IKMG Leung 2019: PMID 30510265.',
);

echo "Clinical references (MGRS IKMG): $checks PASS\n";
