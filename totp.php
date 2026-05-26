<?php
declare(strict_types=1);

/**
 * TOTP (RFC 6238) — čistá PHP implementácia bez externých závislostí.
 * Použitie: Google Authenticator, Authy, Bitwarden a iné TOTP aplikácie.
 */

/**
 * Generuje náhodný Base32-kódovaný tajný kľúč (160 bitov = 32 Base32 znakov).
 */
function generateTotpSecret(): string
{
    return totpBase32Encode(random_bytes(20));
}

/**
 * Overí TOTP kód. Akceptuje ±1 časové okno (tolerancia hodín ~30 s).
 *
 * @param string $secret  Base32-kódovaný tajný kľúč
 * @param string $code    6-ciferný kód od používateľa
 * @param int    $window  Počet intervalov (každý 30 s) na každú stranu
 */
function verifyTotpCode(string $secret, string $code, int $window = 1): bool
{
    $code = preg_replace('/\s+/', '', $code);
    if (!preg_match('/^\d{6}$/', $code)) {
        return false;
    }
    $key = totpBase32Decode($secret);
    if ($key === false || $key === '') {
        return false;
    }
    $counter = (int) floor(time() / 30);
    for ($i = -$window; $i <= $window; $i++) {
        if (hash_equals(totpComputeCode($key, $counter + $i), $code)) {
            return true;
        }
    }
    return false;
}

/**
 * Vráti otpauth:// URI pre zobrazenie QR kódu alebo manuálne pridanie.
 */
function getTotpUri(string $secret, string $accountName, string $issuer): string
{
    return 'otpauth://totp/'
        . rawurlencode($issuer . ':' . $accountName)
        . '?secret=' . rawurlencode($secret)
        . '&issuer=' . rawurlencode($issuer)
        . '&algorithm=SHA1&digits=6&period=30';
}

/**
 * Formátuje Base32 tajný kľúč do skupín po 4 znaky pre lepšiu čitateľnosť.
 * Napr. "JBSWY3DPEHPK3PXP" → "JBSW Y3DP EHPK 3PXP"
 */
function formatTotpSecret(string $secret): string
{
    return implode(' ', str_split($secret, 4));
}

/**
 * Generuje sadu 8 jednorazových záložných kódov.
 * Vráti: ['plain' => string[], 'hashed' => string[]]
 * plain  — zobrazíme raz používateľovi (formát XXXXX-XXXXX)
 * hashed — uložíme do DB (bcrypt hash)
 */
function generateBackupCodes(): array
{
    $plain  = [];
    $hashed = [];
    for ($i = 0; $i < 8; $i++) {
        $raw    = strtoupper(bin2hex(random_bytes(5))); // 10 hex znakov
        $plain[]  = substr($raw, 0, 5) . '-' . substr($raw, 5);
        $hashed[] = password_hash($raw, PASSWORD_DEFAULT);
    }
    return ['plain' => $plain, 'hashed' => $hashed];
}

/**
 * Overí záložný kód (vstup normalizovaný — bez pomlčiek a medzier, veľké písmená).
 * Ak kód je platný, vráti jeho index v poli, inak vráti -1.
 * Index použiješ na odstránenie kódu z poľa (jednorazové použitie).
 *
 * @param string   $inputCode  Kód zadaný používateľom
 * @param string[] $hashedCodes  Pole bcrypt hashov uložených v DB (z JSON)
 */
function verifyAndConsumeBackupCode(string $inputCode, array $hashedCodes): int
{
    $normalized = strtoupper(str_replace(['-', ' '], '', $inputCode));
    if (!preg_match('/^[0-9A-F]{10}$/', $normalized)) {
        return -1;
    }
    foreach ($hashedCodes as $i => $hash) {
        if (password_verify($normalized, (string) $hash)) {
            return (int) $i;
        }
    }
    return -1;
}

// ── Interné funkcie ───────────────────────────────────────────────────────────

/**
 * Vypočíta TOTP kód pre daný binárny kľúč a counter (RFC 4226 HOTP).
 */
function totpComputeCode(string $binaryKey, int $counter): string
{
    $msg  = pack('J', $counter); // 8-bytový big-endian integer
    $hash = hash_hmac('sha1', $msg, $binaryKey, true);
    // Dynamic truncation
    $offset = ord($hash[19]) & 0x0F;
    $code   = (
        ((ord($hash[$offset])     & 0x7F) << 24) |
        ((ord($hash[$offset + 1]) & 0xFF) << 16) |
        ((ord($hash[$offset + 2]) & 0xFF) << 8)  |
         (ord($hash[$offset + 3]) & 0xFF)
    ) % 1_000_000;
    return str_pad((string) $code, 6, '0', STR_PAD_LEFT);
}

/**
 * Zakóduje binárny reťazec do Base32 (RFC 4648).
 */
function totpBase32Encode(string $bytes): string
{
    static $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $output   = '';
    $buffer   = 0;
    $bitsLeft = 0;
    for ($i = 0, $len = strlen($bytes); $i < $len; $i++) {
        $buffer    = ($buffer << 8) | ord($bytes[$i]);
        $bitsLeft += 8;
        while ($bitsLeft >= 5) {
            $bitsLeft -= 5;
            $output   .= $alphabet[($buffer >> $bitsLeft) & 0x1F];
        }
    }
    if ($bitsLeft > 0) {
        $output .= $alphabet[($buffer << (5 - $bitsLeft)) & 0x1F];
    }
    return $output;
}

/**
 * Dekóduje Base32 reťazec na binárny reťazec. Vráti false ak je vstup neplatný.
 */
function totpBase32Decode(string $base32): string|false
{
    static $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $base32   = strtoupper(trim($base32));
    $base32   = rtrim($base32, '=');
    $base32   = str_replace(' ', '', $base32);
    $output   = '';
    $buffer   = 0;
    $bitsLeft = 0;
    for ($i = 0, $len = strlen($base32); $i < $len; $i++) {
        $idx = strpos($alphabet, $base32[$i]);
        if ($idx === false) {
            return false;
        }
        $buffer    = ($buffer << 5) | $idx;
        $bitsLeft += 5;
        if ($bitsLeft >= 8) {
            $bitsLeft -= 8;
            $output   .= chr(($buffer >> $bitsLeft) & 0xFF);
        }
    }
    return $output;
}
