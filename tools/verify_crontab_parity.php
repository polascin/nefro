<?php

declare(strict_types=1);

/**
 * Overí dump crontabu voči SoT (tools/crontab.example / crontab_lib).
 *
 * Použitie:
 *   php tools/verify_crontab_parity.php                  # overí samotný example
 *   php tools/verify_crontab_parity.php path/to/dump     # overí dump (napr. crontab -l)
 *   crontab -l | php tools/verify_crontab_parity.php -  # stdin
 *
 * Exit 0 = OK, 1 = parity chyby, 2 = použitie.
 */

require __DIR__ . '/crontab_lib.php';

$root = dirname(__DIR__);
$examplePath = $root . '/tools/crontab.example';

$checks = 0;
$failures = [];

// Closure s referenciou namiesto `global`: PHPStan inak $failures vidí ako
// navždy prázdne pole a záverečnú kontrolu hlási ako mŕtvy kód.
$crontabParityAssert = static function (bool $ok, string $message) use (&$checks, &$failures): void {
    ++$checks;
    if (!$ok) {
        $failures[] = $message;
    }
};

$targetArg = $argv[1] ?? '';
if ($targetArg === '' || $targetArg === '--example') {
    $text = (string) file_get_contents($examplePath);
    $label = 'tools/crontab.example';
} elseif ($targetArg === '-' || $targetArg === '--stdin') {
    $text = stream_get_contents(STDIN);
    if ($text === false) {
        fwrite(STDERR, "Nepodarilo sa čítať stdin.\n");
        exit(2);
    }
    $label = 'stdin';
} else {
    if (!is_file($targetArg)) {
        fwrite(STDERR, "Súbor neexistuje: {$targetArg}\n");
        exit(2);
    }
    $text = (string) file_get_contents($targetArg);
    $label = $targetArg;
}

$crontabParityAssert($text !== '', "{$label}: crontab text nesmie byť prázdny.");

foreach (nefroCrontabParityErrors($text) as $err) {
    $crontabParityAssert(false, "{$label}: {$err}");
}

// Pri example navyše pinuj, že knižnica a example majú rovnaký mustSchedule.
if ($targetArg === '' || $targetArg === '--example') {
    foreach (nefroCrontabMustSchedule() as $script) {
        $crontabParityAssert(
            is_file($root . '/' . $script),
            "Ops skript {$script} musí existovať v koreni.",
        );
    }
    $crontabParityAssert(
        is_file($root . '/tools/render_crontab.php'),
        'tools/render_crontab.php musí existovať (RSI inštalácia).',
    );
}

if ($failures !== []) {
    fwrite(STDERR, "Crontab parity FAIL ({$checks} checks, " . count($failures) . " errors) — {$label}\n");
    foreach ($failures as $f) {
        fwrite(STDERR, ' - ' . $f . "\n");
    }
    exit(1);
}

echo "Crontab parity: {$checks} PASS ({$label})\n";
