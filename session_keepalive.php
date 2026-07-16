<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo json_encode(['ok' => false], JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['HTTP_X_NPS_KEEPALIVE'] ?? '') !== '1'
    || !validateSessionKeepaliveToken((string) ($_SERVER['HTTP_X_NPS_KEEPALIVE_TOKEN'] ?? ''))
) {
    http_response_code(400);
    echo json_encode(['ok' => false], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'expired' => true], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode([
    'ok' => true,
    'timeout_seconds' => SESSION_IDLE_TIMEOUT,
], JSON_UNESCAPED_UNICODE);
