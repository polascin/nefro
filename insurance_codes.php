<?php
/**
 * Číselník zdravotných poisťovní Slovenskej republiky.
 * Zdroj: UDZS SR — Zoznam zdravotných poisťovní.
 *
 * Štruktúra: 'kód' => ['nazov' => '...', 'skratka' => '...', 'aktivna' => bool]
 */

const INSURANCE_COMPANIES = [
    '24' => [
        'nazov'   => 'Všeobecná zdravotná poisťovňa, a. s.',
        'skratka' => 'VšZP',
        'aktivna' => true,
    ],
    '25' => [
        'nazov'   => 'DÔVERA zdravotná poisťovňa, a. s.',
        'skratka' => 'DÔVERA',
        'aktivna' => true,
    ],
    '27' => [
        'nazov'   => 'UNION zdravotná poisťovňa, a. s.',
        'skratka' => 'UNION',
        'aktivna' => true,
    ],
];

/**
 * Vráti názov zdravotnej poisťovne podľa kódu.
 * Ak kód nie je v číselníku, vráti samotný kód.
 *
 * @param string $code Kód poisťovne (napr. '24')
 * @param bool   $withCode Ak true, pripojí kód do závorky: "VšZP (24)"
 */
function insuranceName(string $code, bool $withCode = false): string {
    $code = trim($code);
    // Normalizácia: odstráni prípadné prípony (napr. '24-01' → '24')
    $baseCode = strtok($code, '-');
    if (isset(INSURANCE_COMPANIES[$baseCode])) {
        $name = INSURANCE_COMPANIES[$baseCode]['skratka']
            . ' — '
            . INSURANCE_COMPANIES[$baseCode]['nazov'];
        return $withCode ? $name . ' (' . $code . ')' : $name;
    }
    return $code !== '' ? $code : '—';
}
