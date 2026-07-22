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

/** Citlivé tokeny a exporty nesmú opustiť stránku v hlavičke Referer. */
function requestNeedsNoReferrer(): bool {
    $script = basename((string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
    $sensitiveScripts = [
        'verify_email.php',
        'newsletter_verify_sub.php',
        'newsletter_unsubscribe.php',
        'confirm_account_deletion.php',
        'reset_password.php',
        'profile_export.php',
    ];
    if (in_array($script, $sensitiveScripts, true)) {
        return true;
    }

    foreach (array_keys($_GET) as $name) {
        $normalized = strtolower(rawurldecode((string) $name));
        $normalized = preg_replace('/[^a-z0-9]+/', '', $normalized) ?? '';
        if (in_array($normalized, [
            'token', 'sig', 'signature', 'secret', 'password', 'passwd',
            'csrf', 'csrftoken', 'jstoken', 'code', 'totpcode',
            'verificationtoken', 'resettoken', 'deletiontoken',
        ], true)) {
            return true;
        }
    }

    return false;
}

function getRequestReferrerPolicy(): string {
    return requestNeedsNoReferrer() ? 'no-referrer' : 'strict-origin-when-cross-origin';
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
    header('Referrer-Policy: ' . getRequestReferrerPolicy());
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
        "style-src 'self'; " .
        "font-src 'self'; " .
        "script-src 'self' 'nonce-{$nonce}' https://www.googletagmanager.com https://www.google-analytics.com; " .
        "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com " .
            "https://analytics.google.com https://*.analytics.google.com https://stats.g.doubleclick.net; " .
        "frame-src https://www.google.com https://maps.google.com; " .
        "base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; upgrade-insecure-requests";
    header('Content-Security-Policy: ' . $csp);
    $cspRO = $csp . '; report-uri /csp-report.php';
    header('Content-Security-Policy-Report-Only: ' . $cspRO);
}

// Kontrola idle timeout a GC – konštanta musí byť definovaná pred prvým použitím
const SESSION_IDLE_TIMEOUT = 3600;
const APP_PASSWORD_MIN_BYTES = 8;
const APP_PASSWORD_MAX_BYTES = 72; // PASSWORD_DEFAULT je aktuálne bcrypt.
const APP_DUMMY_PASSWORD_HASH = '$2y$12$1tNSCTWlgcAYigjqkJKc4uj2t22PGxoKeDa2ajFJz1Bxb.I5bYPQy';

// Zabezpečené nastavenia relácie
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.gc_maxlifetime', (string) SESSION_IDLE_TIMEOUT); // PHP GC vymaže neaktívne sessions po SESSION_IDLE_TIMEOUT sekundách

// Secure cookie zapíname iba pri HTTPS, inak sa na HTTP (lokálny vývoj) cookie neuloží.
$isHttps = isRequestHttps();
ini_set('session.cookie_secure', $isHttps ? '1' : '0');
ini_set('session.cookie_samesite', 'Strict');

// Priorita: projektovo-lokálne sessions > temp > default
$projectSessionPath = __DIR__ . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'sessions';
if ((is_dir($projectSessionPath) || @mkdir($projectSessionPath, 0700, true)) && is_writable($projectSessionPath)) {
    @chmod($projectSessionPath, 0700);
    session_save_path($projectSessionPath);
} else {
    // Fallback na sys_get_temp_dir() ak projektovo-lokálne cesta zlyhá
    $tempSessionPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'nefro_sessions';
    if ((is_dir($tempSessionPath) || @mkdir($tempSessionPath, 0700, true)) && is_writable($tempSessionPath)) {
        @chmod($tempSessionPath, 0700);
        session_save_path($tempSessionPath);
    }
}

// Spustenie relácie
if (session_status() === PHP_SESSION_NONE && !session_start()) {
    error_log('Nepodarilo sa spustiť PHP session. Skontrolujte session.save_path a oprávnenia.');
    http_response_code(500);
    exit('Chyba: Nepodarilo sa spustiť reláciu.');
}

// Kontrola idle timeout: ak bol používateľ prihlásený a 1 hodinu nebol aktívny, odhlásiť ho.
if (!empty($_SESSION['user_id'])) {
    $now = time();
    if (isset($_SESSION['_last_activity']) && ($now - $_SESSION['_last_activity']) > SESSION_IDLE_TIMEOUT) {
        clearUserSession();
        if (!session_start()) {
            http_response_code(500);
            exit('Chyba: Nepodarilo sa obnoviť reláciu.');
        }
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

function isAppPasswordValid(string $password): bool {
    $length = strlen($password);
    return $length >= APP_PASSWORD_MIN_BYTES
        && $length <= APP_PASSWORD_MAX_BYTES
        && preg_match('/[A-Z]/', $password) === 1
        && preg_match('/[a-z]/', $password) === 1
        && preg_match('/[0-9]/', $password) === 1;
}

function hashAppPassword(string $password): string {
    if (!isAppPasswordValid($password)) {
        throw new \InvalidArgumentException('Heslo nespĺňa bezpečnostné pravidlá.');
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    if (!is_string($hash) || $hash === '') {
        throw new \RuntimeException('Heslo sa nepodarilo bezpečne zahashovať.');
    }
    return $hash;
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
 * @param mixed $token Token z POST požiadavky; ne-reťazcové vstupy sa bezpečne odmietnu.
 * @return bool True ak je token platný, inak False
 */
function validateCsrfToken(mixed $token): bool {
    if (!is_string($token) || !isset($_SESSION['csrf_token']) || $token === '') {
        return false;
    }
    $valid = hash_equals($_SESSION['csrf_token'], $token);
    // Token rotuje po každom POST — platný aj neplatný pokus.
    // Znemožňuje replay attack a CSRF token fixation.
    // Používateľ dostane pri ďalšom načítaní stránky nový token.
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $valid;
}

/** Nerotujúci token pre keepalive, aby predĺženie relácie nezneplatnilo rozpracované formuláre. */
function generateSessionKeepaliveToken(): string {
    if (empty($_SESSION['_keepalive_token'])) {
        $_SESSION['_keepalive_token'] = bin2hex(random_bytes(32));
    }

    return (string) $_SESSION['_keepalive_token'];
}

function validateSessionKeepaliveToken(string $token): bool {
    return $token !== ''
        && isset($_SESSION['_keepalive_token'])
        && hash_equals((string) $_SESSION['_keepalive_token'], $token);
}

/**
 * Webové spustenie administračného mutačného skriptu povoľuje iba cez POST.
 * GET zobrazí potvrdenie, CLI beh ostáva bez zmeny.
 */
function requireAdminMutationConfirmation(string $title = 'Spustiť administračný skript'): void {
    if (php_sapi_name() === 'cli') {
        return;
    }

    $method = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
    if ($method === 'POST') {
        if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
            http_response_code(403);
            exit('Neplatný CSRF token.');
        }
        return;
    }

    if ($method !== 'GET') {
        http_response_code(405);
        header('Allow: GET, POST');
        exit('Nepovolená HTTP metóda.');
    }

    $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $csrfToken = htmlspecialchars(generateCsrfToken(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $cssVersion = is_file(__DIR__ . '/index.css') ? (string) filemtime(__DIR__ . '/index.css') : '1';
    $preferencesVersion = is_file(__DIR__ . '/ui-preferences.js') ? (string) filemtime(__DIR__ . '/ui-preferences.js') : '1';
    $preferencesFallbackVersion = is_file(__DIR__ . '/ui-preferences-fallback.js') ? (string) filemtime(__DIR__ . '/ui-preferences-fallback.js') : '1';
    $themeVersion = is_file(__DIR__ . '/theme.js') ? (string) filemtime(__DIR__ . '/theme.js') : '1';

    echo '<!DOCTYPE html><html lang="sk"><head><meta charset="UTF-8">'
        . '<meta name="viewport" content="width=device-width, initial-scale=1.0">'
        . '<meta name="robots" content="noindex, nofollow">'
        . '<title>' . $safeTitle . '</title>'
        . '<link rel="stylesheet" href="index.css?v=' . rawurlencode($cssVersion) . '">'
        . '<script src="ui-preferences.js?v=' . rawurlencode($preferencesVersion) . '"></script>'
        . '<script src="theme.js?v=' . rawurlencode($themeVersion) . '"></script>'
        . '<script src="ui-preferences-fallback.js?v=' . rawurlencode($preferencesFallbackVersion) . '" defer></script>'
        . '</head><body><a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>'
        . '<main id="main-content" class="container" role="main">'
        . '<div class="auth-container"><h1>' . $safeTitle . '</h1>'
        . '<div class="alert alert-error"><p>Tento skript mení údaje v databáze. Pokračujte iba vtedy, ak chcete zmenu vykonať.</p></div>'
        . '<form method="POST"><input type="hidden" name="csrf_token" value="' . $csrfToken . '">'
        . '<div class="form-actions"><button type="submit" class="btn-danger">Potvrdiť a spustiť</button>'
        . '<a href="admin_articles.php" class="btn-secondary">Zrušiť</a></div></form>'
        . '</div></main></body></html>';
    exit;
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
        setcookie(session_name(), '', [
            'expires' => time() - 42000,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'],
        ]);
        unset($_COOKIE[session_name()]);
    }

    session_destroy();
}

/**
 * Podpis autentifikačného stavu invaliduje staré relácie po zmene hesla,
 * administrátorskej roly, aktivity účtu alebo 2FA údajov bez ukladania tajomstiev
 * do samostatnej session tabuľky.
 */
function buildUserAuthFingerprint(array $user): string {
    $parts = [
        (string) ($user['id'] ?? ''),
        (string) ($user['password_hash'] ?? ''),
        (string) ((int) ($user['is_admin'] ?? 0)),
        (string) ((int) ($user['is_active'] ?? 0)),
        (string) ($user['email_verified_at'] ?? ''),
        (string) ((int) ($user['totp_enabled'] ?? 0)),
        (string) ($user['totp_secret'] ?? ''),
        (string) ($user['totp_backup_codes'] ?? ''),
    ];

    return hash_hmac(
        'sha256',
        'nefro:session-auth:v1|' . implode("\x1f", $parts),
        getAppDataProtectionKey()
    );
}

function refreshCurrentSessionAuthFingerprint(array $user): void {
    $_SESSION['_auth_fingerprint'] = buildUserAuthFingerprint($user);
}

/**
 * Porovná reláciu s aktuálnym stavom účtu v DB. Staré relácie bez podpisu sa
 * zámerne ukončia pri prvom požiadavku po nasadení tejto ochrany.
 */
function synchronizeAuthenticatedSession(PDO $pdo): bool {
    if (!isLoggedIn()) {
        return true;
    }

    $stmt = $pdo->prepare(
        'SELECT id, username, email, password_hash, is_admin, is_active,
                email_verified_at, totp_enabled, totp_secret, totp_backup_codes
         FROM users WHERE id = :id LIMIT 1'
    );
    $stmt->execute(['id' => (int) $_SESSION['user_id']]);
    $user = $stmt->fetch();
    $stored = (string) ($_SESSION['_auth_fingerprint'] ?? '');
    $valid = is_array($user)
        && (int) ($user['is_active'] ?? 0) === 1
        && $stored !== ''
        && hash_equals(buildUserAuthFingerprint($user), $stored);

    if (!$valid) {
        clearUserSession();
        if (!session_start()) {
            http_response_code(500);
            exit('Chyba: Nepodarilo sa obnoviť reláciu.');
        }
        setFlashMessage('warning', 'Vaša relácia bola z bezpečnostných dôvodov ukončená. Prihláste sa znova.');
        return false;
    }

    $_SESSION['username'] = (string) ($user['username'] ?? '');
    $_SESSION['email'] = (string) ($user['email'] ?? '');
    $_SESSION['is_admin'] = (int) ($user['is_admin'] ?? 0);
    $_SESSION['email_verified'] = !empty($user['email_verified_at']) ? 1 : 0;
    return true;
}

/**
 * Overenie aktuálneho hesla s dvoma atómovými limitmi: na IP a na účet.
 * @return array{ok:bool,blocked:bool}
 */
function verifySensitiveActionPassword(
    PDO $pdo,
    int $userId,
    string $password,
    string $passwordHash,
    int $maxAttempts = 5,
    int $blockSecs = 900
): array {
    $keys = [
        ['ip' => mb_substr(getClientIpAddress(), 0, 45), 'action' => 'sensitive_reauth'],
        ['ip' => 'user:' . $userId, 'action' => 'sensitive_reauth'],
    ];
    $startedTransaction = !$pdo->inTransaction();

    try {
        if ($startedTransaction) {
            $pdo->beginTransaction();
        }
        foreach ($keys as $key) {
            $pdo->prepare(
                'INSERT INTO form_rate_limit (ip, action, attempt_count, first_attempt, last_attempt)
                 VALUES (:ip, :action, 0, NOW(), NOW())
                 ON DUPLICATE KEY UPDATE id = id'
            )->execute($key);
        }

        $rows = [];
        foreach ($keys as $key) {
            $stmt = $pdo->prepare(
                'SELECT attempt_count, first_attempt, blocked_until
                 FROM form_rate_limit WHERE ip = :ip AND action = :action FOR UPDATE'
            );
            $stmt->execute($key);
            $rows[] = $stmt->fetch() ?: [];
        }

        $now = time();
        foreach ($rows as $row) {
            $blockedUntil = !empty($row['blocked_until']) ? strtotime((string) $row['blocked_until']) : false;
            if ($blockedUntil !== false && $blockedUntil > $now) {
                if ($startedTransaction) {
                    $pdo->commit();
                }
                return ['ok' => false, 'blocked' => true];
            }
        }

        $ok = $password !== '' && password_verify($password, $passwordHash);
        if ($ok) {
            foreach ($keys as $key) {
                $pdo->prepare('DELETE FROM form_rate_limit WHERE ip = :ip AND action = :action')->execute($key);
            }
            $_SESSION['_reauthenticated_at'] = $now;
        } else {
            foreach ($keys as $index => $key) {
                $firstAttempt = !empty($rows[$index]['first_attempt'])
                    ? strtotime((string) $rows[$index]['first_attempt'])
                    : false;
                $expiredWindow = $firstAttempt === false || ($now - $firstAttempt) >= $blockSecs;
                $newCount = $expiredWindow ? 1 : ((int) ($rows[$index]['attempt_count'] ?? 0) + 1);
                $stmt = $pdo->prepare(
                    'UPDATE form_rate_limit
                     SET attempt_count = :count,
                         first_attempt = IF(:reset_window = 1, NOW(), first_attempt),
                         last_attempt = NOW(),
                         blocked_until = IF(:blocked = 1, DATE_ADD(NOW(), INTERVAL :secs SECOND), NULL)
                     WHERE ip = :ip AND action = :action'
                );
                $stmt->execute([
                    'count' => $newCount,
                    'reset_window' => $expiredWindow ? 1 : 0,
                    'blocked' => $newCount >= $maxAttempts ? 1 : 0,
                    'secs' => $blockSecs,
                    'ip' => $key['ip'],
                    'action' => $key['action'],
                ]);
            }
        }

        if ($startedTransaction) {
            $pdo->commit();
        }
        return ['ok' => $ok, 'blocked' => false];
    } catch (\Throwable $e) {
        if ($startedTransaction && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('Citlivé opätovné overenie zlyhalo: ' . $e->getMessage());
        return ['ok' => false, 'blocked' => true];
    }
}

function hasRecentSensitiveReauthentication(int $ttlSeconds = 300): bool {
    $verifiedAt = (int) ($_SESSION['_reauthenticated_at'] ?? 0);
    return $verifiedAt > 0 && (time() - $verifiedAt) <= $ttlSeconds;
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
    return isset($_SESSION['js_challenge_token'])
        && $token !== null
        && hash_equals($_SESSION['js_challenge_token'], $token);
}

/**
 * Centrálna funkcia na získanie klientovej IP adresy.
 * Definovaná primárne v config_loader.php — guard zabraňuje duplikácii.
 */
if (!function_exists('getClientIpAddress')) {
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
} // end if (!function_exists('getClientIpAddress'))

/**
 * Overí, či je IP blokovaná pre danú rate-limit tabuľku. Odstraňuje expirované bloky.
 * @param string $table Povolené hodnoty: 'login_attempts', 'totp_attempts'
 * @return int Unix timestamp konca blokácie, alebo 0 ak nie je blokovaná
 */
function ipRateLimitBlockedUntil(PDO $pdo, string $table, string $ip): int
{
    $allowedTables = ['login_attempts', 'totp_attempts'];
    if (!in_array($table, $allowedTables, true)) {
        throw new \InvalidArgumentException("Nepovolená tabuľka rate-limit: {$table}");
    }
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
        $pdo->prepare(
            "UPDATE `{$table}`
             SET attempt_count = 0, first_attempt = NOW(), last_attempt = NOW(), blocked_until = NULL
             WHERE ip = :ip"
        )
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
    $allowedTables = ['login_attempts', 'totp_attempts'];
    if (!in_array($table, $allowedTables, true)) {
        throw new \InvalidArgumentException("Nepovolená tabuľka rate-limit: {$table}");
    }
    // Staré neúspešné pokusy sa nesmú kumulovať navždy. Po celom okne
    // bez pokusu začína počítadlo odznova.
    $pdo->prepare(
        "UPDATE `{$table}`
         SET attempt_count = 0, first_attempt = NOW(), last_attempt = NOW(), blocked_until = NULL
         WHERE ip = :ip AND last_attempt < DATE_SUB(NOW(), INTERVAL :window SECOND)"
    )->execute(['ip' => $ip, 'window' => $blockSecs]);

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
    $allowedTables = ['login_attempts', 'totp_attempts'];
    if (!in_array($table, $allowedTables, true)) {
        throw new \InvalidArgumentException("Nepovolená tabuľka rate-limit: {$table}");
    }
    $pdo->prepare("DELETE FROM `{$table}` WHERE ip = :ip")->execute(['ip' => $ip]);
}

/**
 * Určí, či query parameter nesmie byť uložený do prístupového logu.
 */
function isSensitiveAccessLogParameter(string $name): bool {
    $normalized = strtolower(rawurldecode($name));
    $normalized = preg_replace('/[^a-z0-9]+/', '', $normalized) ?? '';

    if ($normalized === '') {
        return false;
    }

    $exact = [
        'token', 'sig', 'signature', 'secret', 'password', 'passwd',
        'csrf', 'csrftoken', 'jstoken', 'code', 'totpcode',
        'email', 'login', 'username', 'phone', 'mobile', 'patient', 'birthnumber',
        'patientbirthnumber', 'rodnecislo',
    ];
    if (in_array($normalized, $exact, true)) {
        return true;
    }

    return str_contains($normalized, 'token')
        || str_contains($normalized, 'password')
        || str_contains($normalized, 'secret')
        || str_contains($normalized, 'birthnumber');
}

/**
 * Rediguje citlivé hodnoty v query stringu bez zmeny necitlivých parametrov.
 */
function redactAccessLogQuery(string $query): string {
    if ($query === '') {
        return '';
    }

    $parts = [];
    foreach (preg_split('/[&;]/', $query) ?: [] as $part) {
        if ($part === '') {
            continue;
        }
        [$rawName, $rawValue] = array_pad(explode('=', $part, 2), 2, '');
        if (isSensitiveAccessLogParameter($rawName)) {
            $parts[] = $rawName . '=%5BREDACTED%5D';
        } else {
            $parts[] = $rawName . ($rawValue !== '' ? '=' . $rawValue : '');
        }
    }

    return implode('&', $parts);
}

/**
 * Odstráni prihlasovacie údaje a rediguje query parametre v URL.
 */
function redactAccessLogUrl(string $url): string {
    $url = str_replace(["\r", "\n"], '', trim($url));
    if ($url === '') {
        return '';
    }

    $fragmentPos = strpos($url, '#');
    if ($fragmentPos !== false) {
        $url = substr($url, 0, $fragmentPos);
    }

    $queryPos = strpos($url, '?');
    $base = $queryPos === false ? $url : substr($url, 0, $queryPos);
    $query = $queryPos === false ? '' : substr($url, $queryPos + 1);

    $parsed = parse_url($base);
    if (is_array($parsed) && isset($parsed['host'])) {
        $scheme = isset($parsed['scheme']) ? strtolower((string) $parsed['scheme']) . '://' : '//';
        $host = strtolower((string) $parsed['host']);
        $port = isset($parsed['port']) ? ':' . (int) $parsed['port'] : '';
        $path = (string) ($parsed['path'] ?? '/');
        $base = $scheme . $host . $port . $path;
    }

    $redactedQuery = redactAccessLogQuery($query);
    return $base . ($redactedQuery !== '' ? '?' . $redactedQuery : '');
}

/**
 * Normalizuje textové polia logu a obmedzí ich veľkosť.
 */
function normalizeAccessLogText(string $value, int $maxLength): string {
    $value = str_replace(["\r", "\n", "\0"], '', $value);
    return mb_substr($value, 0, $maxLength);
}

/**
 * Centrálna funkcia na získanie PDO pre audit logy, ak je dostupná.
 */
function getAccessLogPdo(): ?\PDO {
    $resolvedPdo = null;

    if (isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof \PDO) {
        $resolvedPdo = $GLOBALS['pdo'];
    } else {
        $configPath = __DIR__ . '/db_config.php';
        if (is_file($configPath)) {
            try {
                require_once $configPath;
            } catch (\Throwable $e) {
                error_log('Access log DB load failed: ' . $e->getMessage());
            }
        }

        // PHPStan nevidí $pdo injektované cez require_once vo funkcii (include limit);
        // fallback je zámerný pre prípad, keď db_config.php ešte nebol načítaný globálne.
        if (isset($pdo) && $pdo instanceof \PDO) {
            $resolvedPdo = $pdo;
        }
        if ($resolvedPdo === null && isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof \PDO) {
            $resolvedPdo = $GLOBALS['pdo'];
        }
    }

    return $resolvedPdo;
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
    @mkdir($logDir, 0750, true);
    @chmod($logDir, 0750);
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
    if (@file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX) !== false) {
        @chmod($logFile, 0640);
    }
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
    $uri = redactAccessLogUrl((string) ($_SERVER['REQUEST_URI'] ?? ($_SERVER['PHP_SELF'] ?? '/')));
    $query = redactAccessLogQuery((string) ($_SERVER['QUERY_STRING'] ?? ''));
    $status = http_response_code();
    if (!is_int($status) || $status < 100 || $status > 599) {
        $status = 200;
    }

    $record = [
        'user_id' => isLoggedIn() ? (int) ($_SESSION['user_id'] ?? 0) : null,
        'username' => $_SESSION['username'] ?? null,
        'event_type' => 'page_view',
        'method' => $method,
        'request_uri' => normalizeAccessLogText($uri, 2048),
        'query_string' => normalizeAccessLogText($query, 2048),
        'http_status' => $status,
        'client_ip' => getClientIpAddress(),
        'user_agent' => normalizeAccessLogText((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 500),
        'referer' => normalizeAccessLogText(redactAccessLogUrl((string) ($_SERVER['HTTP_REFERER'] ?? '')), 2048),
        'host' => normalizeAccessLogText((string) ($_SERVER['HTTP_HOST'] ?? ''), 255),
        'accept_language' => normalizeAccessLogText((string) ($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? ''), 255),
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
    if (empty($ua)) {
        return true; // Požiadavky bez UA sú takmer vždy boti
    }

    $botPatterns = [
        '/curl/i', '/Wget/i', '/libwww-perl/i', '/Python-urllib/i', '/php/i',
        '/Go-http-client/i', '/Java\//i', '/PostmanRuntime/i', '/axios/i',
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
    $isValid = false;

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $domain = substr(strrchr($email, "@"), 1);
        if (!empty($domain)) {
            // MX záznamy sú preferované, A záznam je fallback.
            $isValid = checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A');
        }
    }

    return $isValid;
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
    refreshCurrentSessionAuthFingerprint($user);
}
