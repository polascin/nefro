<?php
// Zabezpečené nastavenia relácie
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1); // Zapnúť len pre HTTPS prostredie
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
 * Funkcia na vyžadovanie prihlásenia (presmeruje ak nie je)
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
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
?>
