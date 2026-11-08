<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: Mayo zobrazovacia klasifikácia ADPKD.
 *
 * Irazabal MV a kol. (J Am Soc Nephrol 2015;26(1):160–172, PMID 24904092):
 * teoretický počiatočný HtTKV 150 mL/m a ročné percentuálne prírastky
 * < 1,5 % (1A), 1,5 až 3 % (1B), 3 až 4,5 % (1C), 4,5 až 6 % (1D), > 6 % (1E).
 * Pinuje, že trieda sa určuje z toho istého ročného prírastku, ktorý stránka zobrazuje.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function adpkdRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

/** HtTKV pre daný vek a ročný prírastok (výška 1 m → TKV = HtTKV). */
function adpkdRefHtTkv(int $age, float $growth): float
{
    return 150.0 * (1.0 + $growth) ** $age;
}

// HtTKV = TKV / výška: 1200 mL pri 1,60 m = 750 mL/m
adpkdRefTest(adpkdClassify(1200.0, 160.0, 30.0)['httkv'] === 750.0, 'HtTKV 1200 mL / 1,60 m = 750 mL/m.');
// Vek 30, HtTKV 600: (600/150)^(1/30) − 1 = 4,73 % → 1D
$r = adpkdClassify(600.0, 100.0, 30.0);
adpkdRefTest($r['k_pct'] === 4.73 && $r['class'] === '1D', 'Vek 30, HtTKV 600 → 4,73 %/rok, 1D.');

// Tesne nad a pod každou hranicou pri veku 40
$cases = [
    [0.014, '1A'], [0.016, '1B'],
    [0.029, '1B'], [0.031, '1C'],
    [0.044, '1C'], [0.046, '1D'],
    [0.059, '1D'], [0.061, '1E'],
];
foreach ($cases as [$growth, $class]) {
    $res = adpkdClassify(adpkdRefHtTkv(40, $growth), 100.0, 40.0);
    adpkdRefTest(
        $res['class'] === $class,
        sprintf('Prírastok %.1f %%/rok pri veku 40 má byť %s, je %s.', $growth * 100, $class, $res['class']),
    );
}

// Konzistencia: zobrazený prírastok a trieda nesmú protirečiť (regresia: 6,1 %/rok bolo 1D)
foreach ([20, 30, 40, 50, 60] as $age) {
    foreach ([0.01, 0.02, 0.035, 0.05, 0.0605, 0.07] as $growth) {
        $res = adpkdClassify(adpkdRefHtTkv($age, $growth), 100.0, (float) $age);
        $pct = $res['k_pct'];
        $expected = $pct < 1.5 ? '1A' : ($pct < 3.0 ? '1B' : ($pct < 4.5 ? '1C' : ($pct < 6.0 ? '1D' : '1E')));
        adpkdRefTest($res['class'] === $expected, sprintf('Vek %d: %.2f %%/rok a trieda %s si protirečia.', $age, $pct, $res['class']));
    }
}

// HtTKV pod 150 mL/m dáva záporný prírastok → 1A
adpkdRefTest(adpkdClassify(140.0, 100.0, 30.0)['class'] === '1A', 'HtTKV < 150 je 1A.');

// Wiring a citácia na stránke
$page = (string) file_get_contents(dirname(__DIR__) . '/calculator_adpkd.php');
adpkdRefTest(str_contains($page, 'adpkdClassify(') && !str_contains($page, 'function adpkdClassify'), 'Stránka volá spoločnú adpkdClassify.');
adpkdRefTest(str_contains($page, '2015;26(1):160–172') && !str_contains($page, '1987'), 'Citácia Irazabal 2015;26(1):160–172.');

echo "Clinical references (Mayo ADPKD): $checks PASS\n";
