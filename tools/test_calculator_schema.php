<?php

declare(strict_types=1);

/**
 * Štruktúrované dáta kalkulačiek: head_meta.php doplní hlavnú entitu
 * WebApplication + MedicalWebPage, ak ju stránka neuvádza (Beh 171).
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;
function calcSchemaTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$base = 'https://nefro.polascin.net/';
$breadcrumb = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Domov', 'item' => $base],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Kalkulačky', 'item' => $base . 'calculators.php'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => 'eGFR (CKD-EPI 2021)', 'item' => $base . 'calculator_egfr.php'],
    ],
];

$out = calculatorStructuredDataWithEntity([$breadcrumb], 'eGFR CKD-EPI 2021 | Kalkulačky | Nefro', 'Popis.', $base . 'calculator_egfr.php', 'Nefro-projekt Slovensko', $base);
calcSchemaTest(count($out) === 2, 'Doplní sa jeden uzol.');
calcSchemaTest($out[0]['@type'] === ['WebApplication', 'MedicalWebPage'], 'Prvý uzol je WebApplication + MedicalWebPage.');
calcSchemaTest($out[0]['name'] === 'eGFR (CKD-EPI 2021)', 'Názov z položky 3 breadcrumbu.');
calcSchemaTest($out[0]['url'] === $base . 'calculator_egfr.php' && $out[0]['description'] === 'Popis.', 'URL a popis zo stránky.');
calcSchemaTest($out[1] === $breadcrumb, 'Breadcrumb ostáva nezmenený.');
calcSchemaTest(json_encode($out, JSON_UNESCAPED_UNICODE) !== false, 'Výstup sa dá zakódovať do JSON.');

$noCrumb = calculatorStructuredDataWithEntity([], 'Prevodník jednotiek | Kalkulačky', 'P.', $base . 'x.php', 'N', $base);
calcSchemaTest($noCrumb[0]['name'] === 'Prevodník jednotiek', 'Bez breadcrumbu názov z titulku.');

$existing = [['@context' => 'https://schema.org', '@type' => ['WebApplication', 'MedicalWebPage'], 'name' => 'X'], $breadcrumb];
calcSchemaTest(calculatorStructuredDataWithEntity($existing, 'T', 'D', 'U', 'S', $base) === $existing, 'Existujúca entita sa neduplikuje.');

$head = (string) file_get_contents(dirname(__DIR__) . '/head_meta.php');
calcSchemaTest(
    str_contains($head, 'calculatorStructuredDataWithEntity(')
        && str_contains($head, "'calculator_'")
        && str_contains($head, "'calculator_history.php'"),
    'head_meta.php volá doplnenie len pre calculator_* okrem histórie.',
);

echo "Calculator schema: $checks PASS\n";
