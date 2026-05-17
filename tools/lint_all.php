<?php
$dir = __DIR__ . DIRECTORY_SEPARATOR . '..';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($it as $file) {
    if (!$file->isFile()) continue;
    if (strtolower($file->getExtension()) !== 'php') continue;
    $path = $file->getRealPath();
    echo "---- $path\n";
    $cmd = 'php -l ' . escapeshellarg($path) . ' 2>&1';
    $out = [];
    exec($cmd, $out, $code);
    foreach ($out as $line) echo $line . "\n";
}
