<?php
declare(strict_types=1);
require_once __DIR__ . '/config_loader.php';

/**
 * Vráti CSP nonce pre aktuálnu HTTP požiadavku (lazy singleton per-request).
 * Použiť ako atribút nonce="<?= htmlspecialchars(getScriptNonce()) ?>" na inline <script> tagoch.
 */
function getScriptNonce(): string {
    static $nonce = null;
    if ($nonce === null) {
        $nonce = base64_encode(random_bytes(18));
    }
    return $nonce;
}

/**
 * Odosiela kompletný set bezpečnostných HTTP hlavičiek.
 * Volá sa automaticky pri každej web požiadavke cez auth.php.
 */
function sendSecurityHeaders(): void {
    if (php_sapi_name() === 'cli') {
        return;
    }
    header_remove('X-Powered-By');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 0');
    header('X-Content-Type-Options: nosniff');
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=()');
    header('Cross-Origin-Opener-Policy: same-origin');
    header('X-Permitted-Cross-Domain-Policies: none');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0, private');
    header('Pragma: no-cache');
    header('Expires: 0');
    header('Surrogate-Control: no-store');
    $nonce = getScriptNonce();
    $csp =
        "default-src 'self'; " .
        "img-src 'self' data: https:; " .
        "style-src 'self' https://fonts.googleapis.com; " .
        "font-src 'self' https://fonts.gstatic.com; " .
        "script-src 'self' 'nonce-{$nonce}' https://www.googletagmanager.com https://www.google-analytics.com; " .
        "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com " .
            "https://analytics.google.com https://*.analytics.google.com https://stats.g.doubleclick.net; " .
        "base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; upgrade-insecure-requests";
    header('Content-Security-Policy: ' . $csp);
    $cspRO = $csp . '; report-uri /csp-report.php';
    header('Content-Security-Policy-Report-Only: ' . $cspRO);
}

// Zabezpečené nastavenia relácie
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.gc_maxlifetime', (string) SESSION_IDLE_TIMEOUT); // PHP GC vymaže neaktívne sessions po SESSION_IDLE_TIMEOUT sekundách

// Secure cookie zapíname iba pri HTTPS, inak sa na HTTP (lokálny vývoj) cookie neuloží.
$isHttps = isRequestHttps();
ini_set('session.cookie_secure', $isHttps ? '1' : '0');
ini_set('session.cookie_samesite', 'Strict');

// Priorita: projektovo-lokálne sessions > temp > default
$projectSessionPath = __DIR__ . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'sessions';
if ((is_dir($projectSessionPath) || @mkdir($projectSessionPath, 0755, true)) && is_writable($projectSessionPath)) {
    session_save_path($projectSessionPath);
} else {
    // Fallback na sys_get_temp_dir() ak projektovo-lokálne cesta zlyhá
    $tempSessionPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'nefro_sessions';
    if ((is_dir($tempSessionPath) || @mkdir($tempSessionPath, 0755, true)) && is_writable($tempSessionPath)) {
        session_save_path($tempSessionPath);
    }
}

// Spustenie relácie
if (session_status() === PHP_SESSION_NONE) {
    if (!session_start()) {
        error_log('Nepodarilo sa spustiť PHP session. Skontrolujte session.save_path a oprávnenia.');
        http_response_code(500);
        exit('Chyba: Nepodarilo sa spustiť reláciu.');
    }
}

// Kontrola idle timeout: ak bol používateľ prihlásený a 1 hodinu nebol aktívny, odhlásiť ho.
const SESSION_IDLE_TIMEOUT = 3600;
if (!empty($_SESSION['user_id'])) {
    $now = time();
    if (isset($_SESSION['_last_activity']) && ($now - $_SESSION['_last_activity']) > SESSION_IDLE_TIMEOUT) {
        $_SESSION = [];
        session_destroy();
        session_start();
        setFlashMessage('info', 'Vaša relácia vypršala z dôvodu nečinnosti. Prihláste sa znova.');
        // Presmeruj na prihlásenie okamžite — bez čakania na ďalšiu akciu používateľa
        $currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');
        if (!in_array($currentScript, ['login.php', 'register.php', 'forgot_password.php', 'reset_password.php'], true)) {
            header('Location: login.php');
            exit;
        }
    } else {
        $_SESSION['_last_activity'] = $now;
    }
}

sendSecurityHeaders();
registerAccessLogger();

/**
 * Funkcia na overenie, či má používateľ overený e-mail
 * @return bool
 */
function isEmailVerified(): bool {
    return !empty($_SESSION['email_verified']) && (int) $_SESSION['email_verified'] === 1;
}

/**
 * Funkcia na overenie admin oprávnenia
 * @return bool True ak je používateľ admin
 */
function isAdmin(): bool {
    return !empty($_SESSION['is_admin']) && (int) $_SESSION['is_admin'] === 1;
}

/**
 * Funkcia na overenie, či je používateľ prihlásený.
 *
 * @return bool True ak je v relácii platný user_id
 */
if (!function_exists('isLoggedIn')) {
    function isLoggedIn(): bool {
        return isset($_SESSION['user_id']) && (int) $_SESSION['user_id'] > 0;
    }
}

/**
 * Funkcia na vyžadovanie prihlásenia (presmeruje ak nie je)
 */
function requireLogin(): void {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

/**
 * Funkcia na vyžadovanie admin oprávnenia
 */
function requireAdmin(): void {
    requireLogin();
    if (!isAdmin()) {
        header("HTTP/1.1 403 Forbidden");
        exit("Prístup len pre administrátora.");
    }
}

/**
 * Generovanie CSRF tokenu (Synchronizer Token Pattern).
 * Token je generovaný raz za reláciu a uložený v session.
 * Po úspešnej validácii POST formulára sa token rotuje (pozri validateCsrfToken).
 *
 * @return string Aktuálny CSRF token pre vloženie do formulára.
 */
function generateCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validácia CSRF tokenu z POST formulára.
 * Po úspešnej validácii sa token automaticky rotuje — ochráni pred opakovaným
 * použitím a pred CSRF-token-fixation útokmi.
 *
 * @param string $token Token z POST požiadavky ($_POST['csrf_token'])
 * @return bool True ak je token platný, inak False
 */
function validateCsrfToken(string $token): bool {
    if (!isset($_SESSION['csrf_token']) || $token === '') {
        return false;
    }
    $valid = hash_equals($_SESSION['csrf_token'], $token);
    // Token rotuje po každom POST — platný aj neplatný pokus.
    // Znemožňuje replay attack a CSRF token fixation.
    // Používateľ dostane pri ďalšom načítaní stránky nový token.
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $valid;
}

/**
 * Ochrana proti Session Hijacking a Fixation
 * Odporúča sa volať po prihlásení
 */
function regenerateSession(): void {
    session_regenerate_id(true);
}

/**
 * Bezpečné vyčistenie relácie a odstránenie session cookie.
 */
function clearUserSession(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    session_unset();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'], $params['secure'], $params['httponly']
        );
    }

    session_destroy();
}

/**
 * Uloženie jednorazovej hlášky do relácie
 */
function setFlashMessage(string $type, string $message): void {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message,
    ];
}

/**
 * Načítanie a odstránenie jednorazovej hlášky z relácie
 */
function popFlashMessage(): ?array {
    if (empty($_SESSION['flash_message']) || !is_array($_SESSION['flash_message'])) {
        return null;
    }

    $flash = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
    return $flash;
}

/**
 * 1. ČASOVÁ ANALÝZA: Zaznamená čas načítania formulára.
 * @param string $formId Identifikátor formulára
 */
function markFormLoadTime(string $formId): void {
    $_SESSION['form_load_' . $formId] = time();
}

/**
 * 1. ČASOVÁ ANALÝZA: Overí, či od načítania formulára uplynul dostatočný čas.
 * @param string $formId Identifikátor formulára
 * @param int $minSeconds Minimálny počet sekúnd (predvolené 4s)
 * @return bool True ak prešlo dosť času, False ak je to pravdepodobne bot.
 */
function validateFormTime(string $formId, int $minSeconds = 4): bool {
    $key = 'form_load_' . $formId;
    if (empty($_SESSION[$key])) {
        return false; // Formulár nebol načítaný cez GET
    }
    $elapsed = time() - $_SESSION[$key];
    return $elapsed >= $minSeconds;
}

/**
 * 2. JS-CHALLENGE: Vygeneruje token, ktorý musí byť vložený do formulára cez JS.
 * @return string Unikátny kľúč
 */
function generateJsChallengeToken(): string {
    if (empty($_SESSION['js_challenge_token'])) {
        $_SESSION['js_challenge_token'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['js_challenge_token'];
}

/**
 * 2. JS-CHALLENGE: Overí kľúč z POST požiadavky.
 */
function validateJsChallengeToken(?string $token): bool {
    return isset($_SESSION['js_challenge_token']) && $token === $_SESSION['js_challenge_token'];
}

/**
 * Centrálna funkcia na získanie klientovej IP adresy.
 */
function getClientIpAddress(): string {
    $defaultIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    try {
        $env = loadAppConfig();
    } catch (\RuntimeException) {
        $env = [];
    }

    if (parseEnvBool($env['TRUST_PROXY_HEADERS'] ?? getenv('TRUST_PROXY_HEADERS'), false)) {
        $forwarded = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_REAL_IP'] ?? '';
        if ($forwarded !== '') {
            foreach (explode(',', $forwarded) as $candidate) {
                $candidate = trim($candidate);
                if (filter_var($candidate, FILTER_VALIDATE_IP)) {
                    return $candidate;
                }
            }
        }
    }

    return filter_var($defaultIp, FILTER_VALIDATE_IP) ? $defaultIp : '0.0.0.0';
}

/**
 * Overí, či je IP blokovaná pre danú rate-limit tabuľku. Odstraňuje expirované bloky.
 * @param string $table Povolené hodnoty: 'login_attempts', 'totp_attempts'
 * @return int Unix timestamp konca blokácie, alebo 0 ak nie je blokovaná
 */
function ipRateLimitBlockedUntil(PDO $pdo, string $table, string $ip): int
{
    $pdo->prepare("DELETE FROM `{$table}` WHERE blocked_until IS NOT NULL AND blocked_until < DATE_SUB(NOW(), INTERVAL 1 DAY)")
        ->execute();

    $stmt = $pdo->prepare("SELECT blocked_until FROM `{$table}` WHERE ip = :ip");
    $stmt->execute(['ip' => $ip]);
    $row = $stmt->fetch();

    if ($row && !empty($row['blocked_until'])) {
        $ts = strtotime((string) $row['blocked_until']);
        if ($ts !== false && $ts > time()) {
            return $ts;
        }
        $pdo->prepare("UPDATE `{$table}` SET blocked_until = NULL WHERE ip = :ip")
            ->execute(['ip' => $ip]);
    }

    return 0;
}

/**
 * Zaznamená neúspešný pokus pre IP. Nastaví blokáciu ak bol dosiahnutý limit.
 * @return int Aktuálny počet pokusov
 */
function recordIpFailedAttempt(PDO $pdo, string $table, string $ip, int $maxAttempts, int $blockSecs): int
{
    $pdo->prepare(
        "INSERT INTO `{$table}` (ip, attempt_count, first_attempt, last_attempt)
         VALUES (:ip, 1, NOW(), NOW())
         ON DUPLICATE KEY UPDATE attempt_count = attempt_count + 1, last_attempt = NOW()"
    )->execute(['ip' => $ip]);

    $stmt = $pdo->prepare("SELECT attempt_count FROM `{$table}` WHERE ip = :ip");
    $stmt->execute(['ip' => $ip]);
    $count = (int) ($stmt->fetchColumn() ?? 0);

    if ($count >= $maxAttempts) {
        $pdo->prepare("UPDATE `{$table}` SET blocked_until = DATE_ADD(NOW(), INTERVAL :secs SECOND) WHERE ip = :ip")
            ->execute(['secs' => $blockSecs, 'ip' => $ip]);
    }

    return $count;
}

/**
 * Vyčistí rate-limit záznamy pre IP adresu (volaj pri úspešnom prihlásení).
 */
function clearIpRateLimit(PDO $pdo, string $table, string $ip): void
{
    $pdo->prepare("DELETE FROM `{$table}` WHERE ip = :ip")->execute(['ip' => $ip]);
}

/**
 * Centrálna funkcia na získanie PDO pre audit logy, ak je dostupná.
 */
function getAccessLogPdo(): ?\PDO {
    if (isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof \PDO) {
        return $GLOBALS['pdo'];
    }

    $configPath = __DIR__ . '/db_config.php';
    if (!is_file($configPath)) {
        return null;
    }

    try {
        require_once $configPath;
    } catch (\Throwable $e) {
        error_log('Access log DB load failed: ' . $e->getMessage());
        return null;
    }

    if (isset($pdo) && $pdo instanceof \PDO) {
        return $pdo;
    }

    return isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof \PDO ? $GLOBALS['pdo'] : null;
}

/**
 * Zapíše informácie o prístupe do databázy alebo do fallback logu.
 */
function saveAccessLog(array $record): bool {
    $pdo = getAccessLogPdo();
    if ($pdo === null) {
        return false;
    }

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO access_logs (
                user_id, username, event_type, method, request_uri, query_string,
                http_status, client_ip, user_agent, referer, host, accept_language,
                response_time_ms, is_bot
            ) VALUES (
                :user_id, :username, :event_type, :method, :request_uri, :query_string,
                :http_status, :client_ip, :user_agent, :referer, :host, :accept_language,
                :response_time_ms, :is_bot
            )"
        );

        $stmt->execute([
            ':user_id' => $record['user_id'],
            ':username' => $record['username'],
            ':event_type' => $record['event_type'],
            ':method' => $record['method'],
            ':request_uri' => $record['request_uri'],
            ':query_string' => $record['query_string'],
            ':http_status' => $record['http_status'],
            ':client_ip' => $record['client_ip'],
            ':user_agent' => $record['user_agent'],
            ':referer' => $record['referer'],
            ':host' => $record['host'],
            ':accept_language' => $record['accept_language'],
            ':response_time_ms' => $record['response_time_ms'],
            ':is_bot' => $record['is_bot'],
        ]);

        return true;
    } catch (\PDOException $e) {
        error_log('Access log write failed: ' . $e->getMessage());
        return false;
    }
}

/**
 * Zapíše prístupový záznam do lokálneho fallback logu, ak DB nie je dostupná.
 */
function fallbackAccessLog(array $record): void {
    $logDir = __DIR__ . '/private/logs';
    @mkdir($logDir, 0755, true);
    $logFile = $logDir . '/access.log';
    $line = sprintf(
        "%s\t%s\t%s\t%s\t%s\t%d\t%s\t%s\t%s\t%s\t%s\t%s\t%d\t%d\n",
        date('Y-m-d H:i:s'),
        $record['event_type'],
        $record['method'],
        $record['request_uri'],
        $record['query_string'],
        $record['http_status'],
        $record['client_ip'],
        str_replace(["\r", "\n"], ['',''], $record['user_agent']),
        str_replace(["\r", "\n"], ['',''], $record['referer']),
        $record['host'],
        $record['accept_language'],
        $record['username'] ?? '',
        $record['response_time_ms'],
        $record['is_bot'],
    );
    @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
}

/**
 * Registruje shutdown handler pre audit prístupu.
 */
function registerAccessLogger(): void {
    register_shutdown_function('recordAccessLogShutdown');
}

/**
 * Zaznamená prístup pri ukončení spracovania požiadavky.
 */
function recordAccessLogShutdown(): void {
    if (php_sapi_name() === 'cli') {
        return;
    }

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $uri = $_SERVER['REQUEST_URI'] ?? ($_SERVER['PHP_SELF'] ?? '/');
    $query = $_SERVER['QUERY_STRING'] ?? '';
    $status = http_response_code();
    if (!is_int($status) || $status < 100 || $status > 599) {
        $status = 200;
    }

    $record = [
        'user_id' => isLoggedIn() ? (int) ($_SESSION['user_id'] ?? 0) : null,
        'username' => $_SESSION['username'] ?? null,
        'event_type' => 'page_view',
        'method' => $method,
        'request_uri' => $uri,
        'query_string' => $query,
        'http_status' => $status,
        'client_ip' => getClientIpAddress(),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'referer' => $_SERVER['HTTP_REFERER'] ?? '',
        'host' => $_SERVER['HTTP_HOST'] ?? '',
        'accept_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '',
        'response_time_ms' => isset($_SERVER['REQUEST_TIME_FLOAT']) ? (int) round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000) : null,
        'is_bot' => isKnownBotUserAgent() ? 1 : 0,
    ];

    if (!saveAccessLog($record)) {
        fallbackAccessLog($record);
    }
}

/**
 * 3. USER-AGENT CHECK: Kontroluje, či požiadavka nepochádza od známeho bota.
 */
function isKnownBotUserAgent(): bool {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    if (empty($ua)) return true; // Požiadavky bez UA sú takmer vždy boti

    $botPatterns = [
        '/curl/i', '/Wget/i', '/libwww-perl/i', '/Python-urllib/i', '/php/i',
        '/Go-http-client/i', '/Java\//i', '/PostmanRuntime/i', '/axios/i'
    ];

    foreach ($botPatterns as $pattern) {
        if (preg_match($pattern, $ua)) {
            return true;
        }
    }
    return false;
}

/**
 * 4. DNS CHECK: Overí, či doména e-mailu má platné DNS záznamy (MX alebo A).
 * @param string $email E-mailová adresa na overenie
 * @return bool True ak doména existuje a môže prijímať poštu.
 */
function isEmailDomainValid(string $email): bool {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $domain = substr(strrchr($email, "@"), 1);
    if (empty($domain)) return false;

    // Skontrolujeme MX záznamy (poštové servery)
    if (checkdnsrr($domain, 'MX')) {
        return true;
    }

    // Fallback: Skontrolujeme A záznam (ak doména nemá MX, ale má IP, môže prijímať poštu)
    if (checkdnsrr($domain, 'A')) {
        return true;
    }

    return false;
}

// ── 2FA helpre ────────────────────────────────────────────────────────────────

/**
 * Vráti true ak je v session uložený 2FA pending stav a ešte nevypršal (TTL 5 min).
 * Automaticky vyčistí expirovaný pending stav.
 */
function isTwoFactorPending(): bool
{
    if (empty($_SESSION['2fa_pending']) || !is_array($_SESSION['2fa_pending'])) {
        return false;
    }
    if (empty($_SESSION['2fa_pending']['expires']) || $_SESSION['2fa_pending']['expires'] < time()) {
        unset($_SESSION['2fa_pending']);
        return false;
    }
    return true;
}

/**
 * Dokončí prihlásenie po úspešnom overení 2FA alebo záložného kódu.
 * Ekvivalent bloku v login.php — nastavuje rovnaké session premenné.
 *
 * @param array $user  Riadok z tabuľky users (musí obsahovať id, username, email, is_admin, email_verified_at)
 */
function completeTwoFactorLogin(array $user): void
{
    unset($_SESSION['2fa_pending']);
    regenerateSession();
    $_SESSION['user_id']        = $user['id'];
    $_SESSION['username']       = $user['username'];
    $_SESSION['email']          = (string) ($user['email'] ?? '');
    $_SESSION['is_admin']       = (int) ($user['is_admin'] ?? 0);
    $_SESSION['email_verified'] = !empty($user['email_verified_at']) ? 1 : 0;
    $_SESSION['_last_activity'] = time();
}
?>
