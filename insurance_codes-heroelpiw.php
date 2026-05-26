<?php
/**
 * Číselník zdravotných poisťovní Slovenskej republiky.
 * Zdroj: UDZS SR — Zoznam zdravotných poisťovní.
 *
 * Tento súbor slúži ako statický fallback pre prípad, že DB nie je dostupná.
 * Primárny zdroj číselníka je tabuľka `insurance_companies` v databáze.
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
 * Vráti čitateľný názov zdravotnej poisťovne podľa kódu.
 * Primárne hľadá v DB (ak je dostupné PDO), fallback na statickú konštantu.
 *
 * @param string   $code     Kód poisťovne (napr. '24' alebo '24-01')
 * @param bool     $withCode Ak true, pripojí kód do závorky: "VšZP — ... (24)"
 * @param PDO|null $pdo      Voliteľné PDO spojenie pre DB lookup
 */
function insuranceName(string $code, bool $withCode = false, ?PDO $pdo = null): string {
    $code     = trim($code);
    $baseCode = strtok($code, '-') ?: $code;

    // Pokus o DB lookup
    if ($pdo !== null) {
        try {
            $stmt = $pdo->prepare(
                "SELECT nazov, skratka FROM insurance_companies WHERE code = ? LIMIT 1"
            );
            $stmt->execute([$baseCode]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $label = $row['skratka'] . ' — ' . $row['nazov'];
                return $withCode ? $label . ' (' . $code . ')' : $label;
            }
        } catch (Throwable $e) {
            error_log('insuranceName DB chyba: ' . $e->getMessage());
        }
    }

    // Fallback na statickú konštantu
    if (isset(INSURANCE_COMPANIES[$baseCode])) {
        $ins   = INSURANCE_COMPANIES[$baseCode];
        $label = $ins['skratka'] . ' — ' . $ins['nazov'];
        return $withCode ? $label . ' (' . $code . ')' : $label;
    }

    // Neznámy kód — vrátiť pôvodný reťazec
    return $code !== '' ? $code : '—';
}
