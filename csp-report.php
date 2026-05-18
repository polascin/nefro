<?php
declare(strict_types=1);
/**
 * csp-report.php — CSP violation report endpoint
 * Prehliadač posiela POST so JSON telom pri porušení Content-Security-Policy.
 * Logy sa ukladajú do private/logs/csp-violations.log
 * NESMIE includovať auth.php — prehliadač ho volá priamo bez session.
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$body = file_get_contents('php://input');
if ($body === false || $body === '') {
    http_response_code(400);
    exit;
}

$report = json_decode($body, true);
if (!is_array($report)) {
    http_response_code(400);
    exit;
}

$logDir  = __DIR__ . '/private/logs';
@mkdir($logDir, 0755, true);
$logFile = $logDir . '/csp-violations.log';

$ip    = $_SERVER['REMOTE_ADDR'] ?? '-';
$entry = date('Y-m-d H:i:s') . "\t" . $ip . "\t"
       . json_encode($report, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";

@file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);

http_response_code(204);
