<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli' || !is_file('/.dockerenv')) {
    exit('Wrong-key probe requires the isolated CLI container.');
}

ini_set('display_errors', '0');
ini_set('error_log', '/dev/null');
function getAppDataProtectionKey(): string
{
    static $key = null;
    return $key ??= random_bytes(32);
}
$appRoot = realpath('/restore');
if ($appRoot === false) {
    throw new RuntimeException('Restore root missing.');
}
require $appRoot . '/totp.php';
$rejected = 0;
foreach (json_decode(stream_get_contents(STDIN), true, 512, JSON_THROW_ON_ERROR) as $ciphertext) {
    try {
        decryptTotpSecret($ciphertext);
    } catch (Throwable) {
        ++$rejected;
    }
}
echo json_encode(['rejected' => $rejected], JSON_THROW_ON_ERROR);
