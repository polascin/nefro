<?php
require_once __DIR__ . '/config_loader.php';

// Zabezpečené nastavenia relácie
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

// Secure cookie zapíname iba pri HTTPS, inak sa na HTTP (lokálny vývoj) cookie neuloží.
$isHttps = isRequestHttps();
ini_set('session.cookie_secure', $isHttps ? '1' : '0');
ini_set('session.cookie_samesite', 'Strict');

// Priorita: projekt-lokální sessions > temp > default
$projectSessionPath = __DIR__ . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'sessions';
if ((is_dir($projectSessionPath) || @mkdir($projectSessionPath, 0755, true)) && is_writable($projectSessionPath)) {
    session_save_path($projectSessionPath);
} else {
    // Fallback na sys_get_temp_dir() ak projekt-lokální cesta zlyhá
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

/**
 * Funkcia na overenie prihlásenia používateľa
 * @return bool True ak je prihlásený, inak False
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

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
function isAdmin() {
    return !empty($_SESSION['is_admin']) && (int) $_SESSION['is_admin'] === 1;
}

/**
 * Funkcia na vyžadovanie prihlásenia (presmeruje ak nie je)
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

/**
 * Funkcia na vyžadovanie admin oprávnenia
 */
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("HTTP/1.1 403 Forbidden");
        exit("Prístup len pre administrátora.");
    }
}

/**
 * Generovanie CSRF tokenu (Synchronizer Token Pattern).
 * Token je generovaný raz za reláciu a uložený v session.
 * Po úspechné validácii POST formulára sa token rotuje (pozri validateCsrfToken).
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
 * Po úspechnéj validácii sa token automaticky rotuje — ochráni pred opakovaným
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
    // Používateľ dostane pri ďaľšom načítaní stránky nový token.
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $valid;
}

/**
 * Ochana proti Session Hijacking a Fixation
 * Odporúča sa volať po prihlásení
 */
function regenerateSession() {
    session_regenerate_id(true);
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
?>
