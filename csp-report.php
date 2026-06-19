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
    header('Allow: POST');
    exit;
}

$maxBodyBytes = 65536;
$contentLength = filter_var(
    $_SERVER['CONTENT_LENGTH'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 0]]
);
if ($contentLength !== false && $contentLength > $maxBodyBytes) {
    http_response_code(413);
    exit;
}

// IP-based rate limiting (file-based, bez DB závislosti)
$_rlIp     = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$_rlFile   = sys_get_temp_dir() . '/csp_rl_' . md5($_rlIp) . '.json';
$_rlWindow = 60;   // sekundy
$_rlMax    = 30;   // max reportov za okno per IP

$_rlNow  = time();
$_rlData = ['count' => 0, 'window_start' => $_rlNow];

$_rlRaw = @file_get_contents($_rlFile);
if ($_rlRaw !== false) {
    $_rlParsed = json_decode($_rlRaw, true);
    if (is_array($_rlParsed) && ($_rlNow - (int) ($_rlParsed['window_start'] ?? 0)) < $_rlWindow) {
        $_rlData = $_rlParsed;
    }
}

if ((int) $_rlData['count'] >= $_rlMax) {
    http_response_code(429);
    exit;
}

$_rlData['count']++;
@file_put_contents($_rlFile, json_encode($_rlData), LOCK_EX);

$body = file_get_contents('php://input', false, null, 0, $maxBodyBytes + 1);
if ($body === false || $body === '') {
    http_response_code(400);
    exit;
}
if (strlen($body) > $maxBodyBytes) {
    http_response_code(413);
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

// Rotácia logu — max 5 MB
if (file_exists($logFile) && filesize($logFile) > 5 * 1024 * 1024) {
    @rename($logFile, $logFile . '.old');
}

$ip    = $_SERVER['REMOTE_ADDR'] ?? '-';
$entry = date('Y-m-d H:i:s') . "\t" . $ip . "\t"
       . json_encode($report, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";

@file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);

http_response_code(204);
