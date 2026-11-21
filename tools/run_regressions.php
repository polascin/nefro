<?php

declare(strict_types=1);

$root = dirname(__DIR__);
// Bez týchto rozšírení testy zlyhajú zavádzajúcou chybou (napr. PDF sanitizér bez DOM
// potichu prejde na náhradnú vetvu), preto ich chýbanie hlásime vopred a presne.
$missingExtensions = array_values(array_filter(
    ['dom', 'iconv', 'mbstring', 'pdo_sqlite'],
    static fn (string $extension): bool => !extension_loaded($extension)
));
if ($missingExtensions !== []) {
    fwrite(STDERR, 'Regression suite: chýbajú rozšírenia PHP: ' . implode(', ', $missingExtensions) . ".\n");
    exit(1);
}
$manifest = json_decode((string) file_get_contents(__DIR__ . '/regressions.json'), true, 512, JSON_THROW_ON_ERROR);
$discovered = array_merge(glob(__DIR__ . '/test_*.php') ?: [], glob(__DIR__ . '/test_*.mjs') ?: []);
$discovered = array_map(static fn (string $path): string => 'tools/' . basename($path), $discovered);
$listed = $manifest;
sort($discovered);
sort($listed);
if ($discovered !== $listed) {
    throw new RuntimeException('Regression manifest must include every test exactly once.');
}
$testConfig = tempnam(sys_get_temp_dir(), 'nefro-regression-');
if ($testConfig === false) {
    throw new RuntimeException('Cannot create test configuration.');
}
file_put_contents($testConfig, "APP_ENV=test\nDATA_PROTECTION_KEY=synthetic-regression-only\nSMTP_HOST=127.0.0.1\nSMTP_PORT=1\nSMS_PROVIDER=log\n");
putenv('NEFRO_ENV_PATH=' . $testConfig);
try {
    foreach ($manifest as $test) {
        $path = $root . '/' . $test;
        if (!preg_match('~^tools/test_[a-z0-9_]+\.(php|mjs)$~D', $test) || !is_file($path)) {
            throw new RuntimeException('Invalid regression manifest entry.');
        }
        $command = [str_ends_with($test, '.php') ? PHP_BINARY : 'node', $path];
        $process = proc_open($command, [STDIN, STDOUT, STDERR], $pipes, $root);
        if (!is_resource($process) || proc_close($process) !== 0) {
            throw new RuntimeException('Regression failed: ' . $test);
        }
    }
    echo 'Regression suite: ' . count($manifest) . " files PASS\n";
} finally {
    unlink($testConfig);
}
