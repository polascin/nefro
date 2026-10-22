<?php

declare(strict_types=1);

/**
 * Aplikácia používa jedinú hodinu: Europe/Bratislava.
 *
 * PHP zapisuje časy do stĺpcov DATETIME cez `date('Y-m-d H:i:s')` a
 * `formatUserDateTime()` číta hodnoty z databázy rovnako v tomto pásme.
 * `NOW()` a stĺpce TIMESTAMP sa riadia časovým pásmom relácie, ktoré bez
 * explicitného nastavenia preberá zo servera. Ak server beží v inom pásme,
 * do tej istej DATETIME kolóny sa ukladá raz čas z PHP a raz čas z
 * databázy a porovnanie s `NOW()` je posunuté o hodiny.
 *
 * Pravidlá, ktoré tu strážime:
 *   1. `db_config.php` pripája časové pásmo relácie k času aplikácie.
 *   2. Časy vo frontách noviniek počíta databáza, nie PHP.
 *   3. Zostávajúci čas blokácie počíta databáza, nie PHP.
 *   4. Integračná brána kontroluje zhodu hodín a nesmie stratiť kontrolu
 *      nad vznikom zmiešaných časov.
 */

$checks = 0;

function clockConsistencyTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

$root = dirname(__DIR__);

// ── 1. Časové pásmo databázovej relácie ─────────────────────────────────────
$dbConfig = (string) file_get_contents($root . '/db_config.php');

clockConsistencyTest(
    str_contains($dbConfig, "SET time_zone"),
    'db_config.php musí explicitne nastaviť časové pásmo databázovej relácie.',
);
clockConsistencyTest(
    str_contains($dbConfig, "new \\DateTimeZone('Europe/Bratislava')"),
    'Časové pásmo relácie musí vychádzať z časového pásma aplikácie.',
);
clockConsistencyTest(
    str_contains($dbConfig, "date_default_timezone_set('Europe/Bratislava')"),
    'Aplikácia musí mať jednotné referenčné časové pásmo.',
);

// ── 2. Fronty noviniek: čas počíta databáza ─────────────────────────────────
$newsletter = (string) file_get_contents($root . '/newsletter_notifications.php');

clockConsistencyTest(
    !str_contains($newsletter, "date('Y-m-d H:i:s'"),
    'newsletter_notifications.php nesmie zapisovať čas vypočítaný v PHP (fronty používajú hodinu databázy).',
);
clockConsistencyTest(
    substr_count($newsletter, 'DATE_ADD(NOW(), INTERVAL :retry_delay SECOND)') === 2,
    'Oba stavy "zlyhanie" vo frontách noviniek musia počítať čas ďalšieho pokusu v databáze.',
);
clockConsistencyTest(
    !str_contains($newsletter, 'next_attempt_at=:next_attempt_at'),
    'Stĺpec next_attempt_at sa nesmie plniť hodnotou vypočítanou v PHP.',
);

// ── 3. Blokovanie účtu: zostávajúci čas počíta databáza ─────────────────────
$auth = (string) file_get_contents($root . '/auth.php');
$login = (string) file_get_contents($root . '/login.php');

clockConsistencyTest(
    str_contains($auth, 'function formRateLimitBlockedForSeconds(PDO $pdo, string $action, string $ip): int'),
    'auth.php musí počítať zostávajúci čas blokácie na databáze.',
);
clockConsistencyTest(
    str_contains($auth, 'TIMESTAMPDIFF(SECOND, NOW(), blocked_until)'),
    'Zostávajúci čas blokácie musí vychádzať z NOW() v databáze.',
);

$blockedForFunction = '';
$functionPos = strpos($auth, 'function formRateLimitBlockedForSeconds');
if ($functionPos !== false) {
    $blockedForFunction = substr($auth, $functionPos, 1200);
}
clockConsistencyTest(
    $blockedForFunction !== '' && !str_contains($blockedForFunction, 'strtotime('),
    'Prepočet zostávajúceho času cez strtotime() by ho posunul o rozdiel časových pásiem.',
);
clockConsistencyTest(
    str_contains($login, 'formRateLimitBlockedForSeconds('),
    'login.php musí použiť blokáciu počítanú databázou.',
);
clockConsistencyTest(
    !str_contains($login, 'formRateLimitBlockedUntil('),
    'login.php nesmie používať odstránenú funkciu s prepočtom cez strtotime().',
);

// ── 4. Integračná brána nesmie stratiť kontrolu nad zmiešanými časmi ───────
$integration = (string) file_get_contents($root . '/tools/integration/run.php');

clockConsistencyTest(
    !str_contains($integration, 'different PHP and MariaDB timezones intentionally exercised'),
    'Integračná brána už nesmie tvrdiť, že databáza beží v UTC (to odporuje zmluve aplikácie).',
);
clockConsistencyTest(
    str_contains($integration, 'database session timezone follows the application'),
    'Integračná brána musí kontrolovať, že časové pásmo relácie sleduje čas aplikácie.',
);
clockConsistencyTest(
    str_contains($integration, 'PHP and database write the same clock into the same DATETIME column'),
    'Integračná brána musí kontrolovať, že PHP a databáza zapisujú do tej istej kolóny ten istý čas.',
);

echo "Clock consistency: $checks PASS\n";
