<?php

declare(strict_types=1);

require_once __DIR__ . '/guard.php';
$manifestPath = __DIR__ . '/../regressions.json';
$fixturePath = __DIR__ . '/../test_injected_regression.php';
if (file_exists($fixturePath)) {
    throw new RuntimeException('Unexpected failure-test fixture.');
}
$original = (string) file_get_contents($manifestPath);
try {
    file_put_contents($fixturePath, "<?php\nexit(42);\n");
    $manifest = json_decode($original, true, 512, JSON_THROW_ON_ERROR);
    array_unshift($manifest, 'tools/test_injected_regression.php');
    file_put_contents($manifestPath, json_encode($manifest, JSON_THROW_ON_ERROR));
    $process = proc_open([PHP_BINARY, __DIR__ . '/../run_regressions.php'], [STDIN, ['pipe', 'w'], ['pipe', 'w']], $pipes);
    if (!is_resource($process)) {
        throw new RuntimeException('Cannot run negative regression probe.');
    }
    $output = stream_get_contents($pipes[1]);
    $error = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    if (proc_close($process) === 0 || !str_contains($output . $error, 'Regression failed: tools/test_injected_regression.php')) {
        throw new RuntimeException('Injected failure did not stop regression runner.');
    }
} finally {
    file_put_contents($manifestPath, $original);
    if (is_file($fixturePath)) {
        unlink($fixturePath);
    }
}
echo "Injected regression failure: correctly blocked PASS\n";
