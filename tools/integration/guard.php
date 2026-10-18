<?php

declare(strict_types=1);

// Tento kontrolný bod je iba v nástrojoch; nikdy sa nenasadzuje do web rootu.
if (PHP_SAPI !== 'cli' || !is_file('/.dockerenv')) {
    throw new RuntimeException('Integration tests require the isolated container.');
}
if (getenv('NEFRO_ENV_PATH') !== '/app/tools/integration/app.ini') {
    throw new RuntimeException('Unexpected integration configuration path.');
}
require_once __DIR__ . '/../../config_loader.php';
$config = loadAppConfig();
foreach (['APP_ENV' => 'test', 'DB_HOST' => 'db', 'DB_NAME' => 'nefro_integration', 'DB_USER' => 'nefro_test', 'SMTP_HOST' => 'mailpit', 'SMTP_SECURE' => 'tls', 'SMS_PROVIDER' => 'log'] as $key => $expected) {
    if (($config[$key] ?? null) !== $expected) {
        throw new RuntimeException('Unsafe integration configuration: ' . $key);
    }
}
foreach (['/app/env.ini', '/app/private/env.ini', '/app/private/nefro.env.ini', '/nefro.env.ini'] as $path) {
    if (file_exists($path)) {
        throw new RuntimeException('Unexpected configuration file in test image.');
    }
}
$socket = @stream_socket_client('tcp://1.1.1.1:443', $errorCode, $errorText, 2);
if (is_resource($socket)) {
    fclose($socket);
    throw new RuntimeException('Integration network has external access.');
}
require_once __DIR__ . '/../../db_config.php';
if (!isset($pdo) || !$pdo instanceof PDO) {
    throw new RuntimeException('Integration database bootstrap failed.');
}
if ($pdo->query('SELECT DATABASE()')->fetchColumn() !== 'nefro_integration'
    || !str_starts_with((string) $pdo->query('SELECT CURRENT_USER()')->fetchColumn(), 'nefro_test@')
    || $pdo->getAttribute(PDO::ATTR_EMULATE_PREPARES)) {
    throw new RuntimeException('Integration database identity or PDO mode mismatch.');
}
if (realpath((string) ($_SERVER['SCRIPT_FILENAME'] ?? '')) === __FILE__) {
    echo "Isolation guard: container, exclusive configuration, database identity and blocked egress PASS\n";
}
