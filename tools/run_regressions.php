<?php

declare(strict_types=1);

$root = dirname(__DIR__);
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
