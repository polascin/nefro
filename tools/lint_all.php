<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY,
    RecursiveIteratorIterator::CATCH_GET_CHILD
);

$checked = 0;
$failed = 0;

foreach ($iterator as $file) {
    if (!$file->isFile() || strtolower($file->getExtension()) !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    echo "---- $path\n";

    if (!is_readable($path)) {
        echo "File is not readable: $path\n";
        $failed++;
        continue;
    }

    $output = [];
    $exitCode = 0;
    $command = escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($path) . ' 2>&1';
    exec($command, $output, $exitCode);
    foreach ($output as $line) {
        echo $line . "\n";
    }

    $checked++;
    if ($exitCode !== 0) {
        $failed++;
    }
}

echo "\nChecked PHP files: $checked; failures: $failed\n";
exit($failed === 0 ? 0 : 1);
