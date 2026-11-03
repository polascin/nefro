<?php

declare(strict_types=1);

/**
 * Vykreslí inštalovateľný crontab z tools/crontab.example.
 *
 * Použitie:
 *   php tools/render_crontab.php [--php=/usr/bin/php] [--root=/path/to/nefro] [--preserve=file]
 *
 * Výstup na stdout. Cudzie úlohy (napr. polascin.net ops) pripoj cez --preserve.
 */

require __DIR__ . '/crontab_lib.php';

$phpBin = nefroCrontabDefaultPhp();
$root = nefroCrontabDefaultRoot();
$preservePath = '';

foreach (array_slice($argv, 1) as $arg) {
    if (str_starts_with($arg, '--php=')) {
        $phpBin = substr($arg, 6);
        continue;
    }
    if (str_starts_with($arg, '--root=')) {
        $root = substr($arg, 7);
        continue;
    }
    if (str_starts_with($arg, '--preserve=')) {
        $preservePath = substr($arg, 11);
        continue;
    }
    fwrite(STDERR, "Neznámy argument: {$arg}\n");
    exit(2);
}

$extra = '';
if ($preservePath !== '') {
    if (!is_file($preservePath)) {
        fwrite(STDERR, "Preserve súbor neexistuje: {$preservePath}\n");
        exit(2);
    }
    $extra = (string) file_get_contents($preservePath);
}

$example = dirname(__DIR__) . '/tools/crontab.example';
try {
    echo nefroCrontabRender($example, $phpBin, $root, $extra);
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}
