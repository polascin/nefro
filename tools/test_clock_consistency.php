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

// ops_health.php má vlastné PDO (db_config.php pri chybe končí exit(0)),
// preto musí pásmo nastaviť rovnako — inak je retry_overdue pri UTC CLI
// posunutý o 1 až 2 h (nález Behu 134).
$opsHealth = (string) file_get_contents($root . '/ops_health.php');
clockConsistencyTest(
    str_contains($opsHealth, 'function opsHealthApplySessionTimezone'),
    'ops_health.php musí mať spoločnú funkciu na zjednotenie časového pásma.',
);
clockConsistencyTest(
    str_contains($opsHealth, 'opsHealthApplySessionTimezone($pdo)'),
    'ops_health.php musí po pripojení k MySQL nastaviť časové pásmo relácie.',
);
clockConsistencyTest(
    str_contains($opsHealth, "date_default_timezone_set('Europe/Bratislava')"),
    'ops_health.php musí parsovať časy DB v pásme aplikácie.',
);
clockConsistencyTest(
    str_contains($opsHealth, "SET time_zone = '"),
    'ops_health.php musí nastaviť MySQL time_zone rovnako ako db_config.php.',
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

// Právne oznámenia: rovnaká zmluva (retry termín z NOW()/datetime, nie PHP date).
$legal = (string) file_get_contents($root . '/legal_notifications.php');
clockConsistencyTest(
    str_contains($legal, 'function legalNoticePrepareFailStmt'),
    'legal_notifications.php musí mať spoločnú prípravu zápisu zlyhania s časom DB.',
);
clockConsistencyTest(
    str_contains($legal, 'DATE_ADD(NOW(), INTERVAL :retry_delay SECOND)'),
    'Zlyhanie právneho oznámenia musí na MySQL počítať next_attempt_at v databáze.',
);
clockConsistencyTest(
    !str_contains($legal, "date('Y-m-d H:i:s'"),
    'legal_notifications.php nesmie zapisovať next_attempt_at cez PHP date().',
);
clockConsistencyTest(
    !str_contains($legal, 'next_attempt_at=:next_attempt_at')
        && !str_contains($legal, 'next_attempt_at = :next_attempt_at'),
    'Stĺpec next_attempt_at v právnych frontách sa nesmie plniť PHP hodnotou.',
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
