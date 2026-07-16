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

/**
 * CSP reporty môžu obsahovať URL s reset/verification tokenmi alebo inými
 * query parametrami. Do logu ponecháme iba schému, host, port a cestu.
 */
function sanitizeCspReportUrl(string $value): string
{
    $value = trim(str_replace(["\r", "\n", "\0"], '', $value));
    if ($value === '') {
        return '';
    }

    if (preg_match('/^(?:data|blob):/i', $value) === 1) {
        return strtolower((string) strstr($value, ':', true)) . ':';
    }

    $parts = parse_url($value);
    if (is_array($parts) && isset($parts['scheme'], $parts['host'])) {
        $scheme = strtolower((string) $parts['scheme']);
        if (!in_array($scheme, ['http', 'https'], true)) {
            return mb_substr($scheme . ':', 0, 32);
        }

        $host = strtolower((string) $parts['host']);
        $port = isset($parts['port']) ? ':' . (int) $parts['port'] : '';
        $path = (string) ($parts['path'] ?? '/');

        return mb_substr($scheme . '://' . $host . $port . $path, 0, 2048);
    }

    return mb_substr((string) preg_replace('/[?#].*$/', '', $value), 0, 2048);
}

/**
 * Whitelist polí z legacy `report-uri` payloadu. Vynecháva script-sample
 * a všetky neznáme polia, aby útočník nemohol plniť log ľubovoľným obsahom.
 */
function sanitizeCspReport(array $report): array
{
    $payload = isset($report['csp-report']) && is_array($report['csp-report'])
        ? $report['csp-report']
        : $report;

    $clean = [];
    $urlFields = ['document-uri', 'blocked-uri', 'source-file', 'referrer'];
    foreach ($urlFields as $field) {
        if (isset($payload[$field]) && is_string($payload[$field])) {
            $clean[$field] = sanitizeCspReportUrl($payload[$field]);
        }
    }

    $textFields = ['violated-directive', 'effective-directive', 'disposition'];
    foreach ($textFields as $field) {
        if (isset($payload[$field]) && is_string($payload[$field])) {
            $clean[$field] = mb_substr(
                trim(str_replace(["\r", "\n", "\0"], ' ', $payload[$field])),
                0,
                255
            );
        }
    }

    foreach (['status-code', 'line-number', 'column-number'] as $field) {
        if (isset($payload[$field]) && is_numeric($payload[$field])) {
            $clean[$field] = max(0, (int) $payload[$field]);
        }
    }

    return ['csp-report' => $clean];
}

// IP-based rate limiting (file-based, bez DB závislosti)
$_rlIp     = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$_rlFile   = sys_get_temp_dir() . '/nefro_csp_rl_' . hash('sha256', $_rlIp) . '.json';
$_rlWindow = 60;   // sekundy
$_rlMax    = 30;   // max reportov za okno per IP

$_rlNow  = time();
$_rlData = ['count' => 0, 'window_start' => $_rlNow];

$_rlHandle = @fopen($_rlFile, 'c+');
if ($_rlHandle === false) {
    http_response_code(503);
    exit;
}

$_rlAvailable = false;
$_rlLimited = false;
try {
    @chmod($_rlFile, 0600);
    if (flock($_rlHandle, LOCK_EX)) {
        rewind($_rlHandle);
        $_rlRaw = stream_get_contents($_rlHandle);
        if ($_rlRaw !== false && $_rlRaw !== '') {
            $_rlParsed = json_decode($_rlRaw, true);
            if (is_array($_rlParsed)
                && ($_rlNow - (int) ($_rlParsed['window_start'] ?? 0)) < $_rlWindow
            ) {
                $_rlData = $_rlParsed;
            }
        }

        if ((int) $_rlData['count'] >= $_rlMax) {
            $_rlLimited = true;
        } else {
            $_rlData['count']++;
            rewind($_rlHandle);
            ftruncate($_rlHandle, 0);
            $_rlAvailable = fwrite($_rlHandle, (string) json_encode($_rlData)) !== false;
            fflush($_rlHandle);
        }

        flock($_rlHandle, LOCK_UN);
    }
} finally {
    if (is_resource($_rlHandle)) {
        fclose($_rlHandle);
    }
}

if ($_rlLimited) {
    http_response_code(429);
    exit;
}
if (!$_rlAvailable) {
    http_response_code(503);
    exit;
}

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
$report = sanitizeCspReport($report);

$logDir  = __DIR__ . '/private/logs';
@mkdir($logDir, 0750, true);
@chmod($logDir, 0750);
$logFile = $logDir . '/csp-violations.log';

// Rotácia logu — max 5 MB
if (file_exists($logFile) && filesize($logFile) > 5 * 1024 * 1024) {
    @rename($logFile, $logFile . '.old');
}

$ip    = $_SERVER['REMOTE_ADDR'] ?? '-';
$entry = date('Y-m-d H:i:s') . "\t" . $ip . "\t"
       . json_encode($report, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";

if (@file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX) === false) {
    http_response_code(503);
    exit;
}
@chmod($logFile, 0640);

http_response_code(204);
