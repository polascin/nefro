<?php
// Zabezpečené nastavenia relácie
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

// Secure cookie zapíname iba pri HTTPS, inak sa na HTTP (lokálny vývoj) cookie neuloží.
$isHttps = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
    || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string) $_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
);
ini_set('session.cookie_secure', $isHttps ? '1' : '0');
ini_set('session.cookie_samesite', 'Strict');

// Spustenie relácie
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
 * Generovanie CSRF tokenu
 * @return string CSRF token
 */
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validácia CSRF tokenu z formulára
 * @param string $token Token z POST požiadavky
 * @return bool True ak je platný, inak False
 */
function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
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
?>
