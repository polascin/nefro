<?php

declare(strict_types=1);

/**
 * Výsledky kalkulačiek obsahujú údaje o zdraví vrátane rodného čísla.
 * Bez retenčnej politiky zostávali v databáze navždy.
 *
 * Dvojstupňový model:
 *   1. po roku sa odstránia priame identifikátory, výsledok zostane
 *      anonymizovaný a použiteľný na sledovanie vývoja,
 *   2. po desiatich rokoch sa riadok maž úplne.
 *
 * Text v zásadách ochrany údajov musí zodpovedať skutočnému správaniu —
 * rovnako ako pri retencii objednávok publikácií (publications_common.php).
 */

$checks = 0;

function retentionPolicyTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

$root = dirname(__DIR__);

$common = (string) file_get_contents($root . '/calculators_common.php');
$cleanup = (string) file_get_contents($root . '/archive_cleanup.php');
$privacy = (string) file_get_contents($root . '/privacy.php');

// ── Lehoty žijú pri funkcii, nie v textoch ───────────────────────────────────
retentionPolicyTest(
    str_contains($common, 'const CALCULATOR_RESULT_ANONYMISE_DAYS'),
    'calculators_common.php musí definovať CALCULATOR_RESULT_ANONYMISE_DAYS.',
);
retentionPolicyTest(
    str_contains($common, 'const CALCULATOR_RESULT_RETENTION_DAYS'),
    'calculators_common.php musí definovať CALCULATOR_RESULT_RETENTION_DAYS.',
);
retentionPolicyTest(
    preg_match('/const CALCULATOR_RESULT_ANONYMISE_DAYS\s*=\s*(\d+)/', $common, $m) === 1
        && (int) $m[1] === 365,
    'Anonymizácia po roku (365 dní).',
);
retentionPolicyTest(
    preg_match('/const CALCULATOR_RESULT_RETENTION_DAYS\s*=\s*(\d+)/', $common, $m) === 1
        && (int) $m[1] === 3653,
    'Úplné vymazanie po desiatich rokoch (3653 dní).',
);

// ── Retenčné funkcie ────────────────────────────────────────────────────────
retentionPolicyTest(
    str_contains($common, 'function calculatorAnonymiseOldResults('),
    'Chýba funkcia calculatorAnonymiseOldResults().',
);
retentionPolicyTest(
    str_contains($common, 'function calculatorDeleteExpiredResults('),
    'Chýba funkcia calculatorDeleteExpiredResults().',
);

// Anonymizácia musí vyčistiť všetky priame identifikátory.
foreach ([
    'patient_first_name',
    'patient_last_name',
    'patient_birth_date',
    'patient_birth_number',
    'patient_insurance_code',
] as $column) {
    retentionPolicyTest(
        preg_match(
            '/calculatorAnonymiseOldResults[\s\S]{0,2000}?' . preg_quote($column, '/') . '\s*=\s*NULL/',
            $common
        ) === 1,
        'Anonymizácia musí vyčistiť stĺpec ' . $column . '.',
    );
}

// ── Retenčný cron naozaj volá tie funkcie ───────────────────────────────────
retentionPolicyTest(
    str_contains($cleanup, 'calculatorAnonymiseOldResults('),
    'archive_cleanup.php musí anonymizovať staré výsledky kalkulačiek.',
);
retentionPolicyTest(
    str_contains($cleanup, 'calculatorDeleteExpiredResults('),
    'archive_cleanup.php musí mazať výsledky kalkulačiek po lehote.',
);
retentionPolicyTest(
    str_contains($cleanup, "require_once __DIR__ . '/calculators_common.php'"),
    'archive_cleanup.php musí načítať retenčné konštanty z calculators_common.php.',
);

// ── Zásady musia zodpovedať skutočnosti ─────────────────────────────────────
// Týka sa položky o VÝSLEDKOCH ULOŽENÝCH V KONTE (serverová databáza).
// Lokálna história v prehliadači má inú logiku (mazanie používateľom) a
// musí zostať tak, ako je.
$serverSideBullet = '';
if (preg_match('/<li>(?:(?!<\/li>).)*Výsledky kalkulačiek uložené v konte(?:(?!<\/li>).)*<\/li>/s', $privacy, $bulletMatch) === 1) {
    $serverSideBullet = $bulletMatch[0];
}

retentionPolicyTest(
    $serverSideBullet !== '',
    'V zásadách chýba položka o výsledkoch kalkulačiek uložených v konte.',
);
retentionPolicyTest(
    !str_contains($serverSideBullet, 'kým ich používateľ nevymaže'),
    'Položka o výsledkoch v konte nesmie tvrdiť, že zostávajú bez obmedzenia.',
);
retentionPolicyTest(
    str_contains($serverSideBullet, 'rodné číslo') && str_contains($serverSideBullet, 'anonymizovaný'),
    'Zásady musia uviesť, že sa odstraňujú identifikátory a výsledok zostáva anonymizovaný.',
);
retentionPolicyTest(
    preg_match('/po (jeden |1 )?roku/i', $serverSideBullet) === 1,
    'Zásady musia uviesť ročnú lehotu anonymizácie.',
);
retentionPolicyTest(
    preg_match('/po (desiatich |10 )/i', $serverSideBullet) === 1,
    'Zásady musia uviesť desaťročnú lehotu úplného vymazania.',
);

// Lokálna história v prehliadači ostáva bez časovej lehoty — to je správne.
retentionPolicyTest(
    str_contains($privacy, 'Lokálna história kalkulačiek pre neprihlásených'),
    'Zásady musia naďalej uvádzať lokálnu históriu kalkulačiek v prehliadači.',
);

echo "Retention policy: $checks PASS\n";
