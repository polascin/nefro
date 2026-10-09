<?php

declare(strict_types=1);

/**
 * Výpis AG/delta ratio nesmie ísť do htmlspecialchars ako float —
 * pri strict_types=1 to na PHP 8 padá TypeErrorom (rovnako ako UACR/Kt/V).
 */

$checks = 0;

function acidbaseDisplayTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

$source = (string) file_get_contents(__DIR__ . '/../calculator_acidbase.php');

foreach (['ag', 'corrected_ag', 'delta_ratio', 'alb'] as $key) {
    acidbaseDisplayTest(
        (bool) preg_match(
            '/htmlspecialchars\(\s*\(string\)\s*\$calculated\["' . preg_quote($key, '/') . '"\]/',
            $source,
        ),
        'Pole ' . $key . ' ide do htmlspecialchars ako string.',
    );
    acidbaseDisplayTest(
        !preg_match(
            '/htmlspecialchars\(\s*\$calculated\["' . preg_quote($key, '/') . '"\]/',
            $source,
        ),
        'Pole ' . $key . ' už nejde do htmlspecialchars ako float.',
    );
}

$ag = round(140.0 - (104.0 + 16.0), 1);
$alb = round(40.0, 1);
$correctedAg = round($ag + 0.25 * (40.0 - $alb), 1);
$deltaRatio = round(($correctedAg - 12.0) / (24.0 - 16.0), 2);

acidbaseDisplayTest($ag === 20.0, 'Klasický príklad Na 140, Cl 104, HCO3 16 dá AG 20.');
acidbaseDisplayTest($correctedAg === 20.0, 'Pri albumíne 40 g/L ostáva korigované AG 20.');
acidbaseDisplayTest($deltaRatio === 1.0, 'Delta ratio pri HCO3 16 je 1,0 (čistá high-AG acidóza).');

foreach ([$ag, $correctedAg, $deltaRatio, $alb] as $value) {
    acidbaseDisplayTest(is_float($value), 'round() vracia float, ktorý htmlspecialchars bez pretypovania odmietne.');
    $escaped = htmlspecialchars((string) $value);
    acidbaseDisplayTest($escaped !== '', 'Pretypovanie na string dovolí htmlspecialchars.');
}

echo "Acidbase display: $checks PASS\n";
