<?php

declare(strict_types=1);

/**
 * Regresia pravidiel priority A/B/C pre partner_providers.
 * Izolovaný beh bez DB — iba providers_common.php.
 */

require_once dirname(__DIR__) . '/providers_common.php';

$checks = 0;
function providersPriorityTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$cases = [
    ['name' => 'Ambulancia západ', 'provider_type' => 'vseobecny_lekar', 'locality' => 'Bratislava-Dúbravka', 'expect' => 'A'],
    ['name' => 'Ambulancia východ', 'provider_type' => 'specialista', 'locality' => 'Bratislava-Petržalka', 'expect' => 'C'],
    ['name' => 'Poliklinika stred', 'provider_type' => 'poliklinika', 'locality' => 'Bratislava-Nové Mesto', 'expect' => 'B'],
    ['name' => 'Nemocnica východ', 'provider_type' => 'nemocnica', 'locality' => 'Bratislava-Ružinov', 'expect' => 'C'],
    ['name' => 'CINRE, Nemocnica Bory', 'provider_type' => 'specialista', 'locality' => 'Bratislava-Lamač', 'expect' => 'B'],
    ['name' => 'MUDr. Juraj Magyarics', 'provider_type' => 'vseobecny_lekar', 'locality' => 'Bratislava-Dúbravka', 'expect' => null],
    ['name' => 'Neznáma lokalita', 'provider_type' => 'vseobecny_lekar', 'locality' => 'Košice', 'expect' => null],
    ['name' => 'Rovinka VLD', 'provider_type' => 'vseobecny_lekar', 'locality' => 'Rovinka', 'expect' => 'B'],
];

foreach ($cases as $case) {
    $got = ppPriorityForProvider([
        'name' => $case['name'],
        'provider_type' => $case['provider_type'],
        'locality' => $case['locality'],
    ]);
    $label = $case['name'] . ' / ' . $case['locality'];
    providersPriorityTest($got === $case['expect'], "Priorita pre {$label}: očakávané " . var_export($case['expect'], true) . ', dostané ' . var_export($got, true));
}

$rules = ppPriorityAssignmentRules();
providersPriorityTest($rules['west'] !== [] && $rules['east'] !== [] && $rules['mid'] !== [], 'Pravidlá musia mať lokality.');
providersPriorityTest(array_key_exists('A', ppPriorityLabels()) && array_key_exists('C', ppPriorityLabels()), 'Štítky A/B/C musia existovať.');

echo "Providers priority: $checks PASS\n";
