<?php

declare(strict_types=1);

/**
 * TOTP (RFC 6238) — čistá PHP implementácia bez externých závislostí.
 * Použitie: Google Authenticator, Authy, Bitwarden a iné TOTP aplikácie.
 */

const TOTP_ENCRYPTED_MARKER = 'encrypted:v1';

/**
 * Vráti kľúč oddelený od ostatných použití aplikačného data-protection kľúča.
 */
function getTotpEncryptionKey(): string
{
    if (!function_exists('getAppDataProtectionKey')) {
        require_once __DIR__ . '/config_loader.php';
    }
    return hash_hmac('sha256', 'nefro:totp-secret:v1', getAppDataProtectionKey(), true);
}

function totpBase64UrlEncode(string $value): string
{
    return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
}

function totpBase64UrlDecode(string $value): string|false
{
    $padding = strlen($value) % 4;
    if ($padding > 0) {
        $value .= str_repeat('=', 4 - $padding);
    }
    return base64_decode(strtr($value, '-_', '+/'), true);
}

/**
 * Zašifruje TOTP tajomstvo pomocou Sodium alebo AES-256-GCM.
 */
function encryptTotpSecret(string $secret): string
{
    if ($secret === '' || totpBase32Decode($secret) === false) {
        throw new \RuntimeException('TOTP tajomstvo nie je platné.');
    }

    if (function_exists('sodium_crypto_secretbox')) {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $ciphertext = sodium_crypto_secretbox($secret, $nonce, getTotpEncryptionKey());
        return 's1:' . totpBase64UrlEncode($nonce . $ciphertext);
    }

    if (function_exists('openssl_encrypt')) {
        $iv = random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt(
            $secret,
            'aes-256-gcm',
            getTotpEncryptionKey(),
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            'nefro:totp:v1',
            16
        );
        if ($ciphertext !== false && strlen($tag) === 16) {
            return 'o1:' . totpBase64UrlEncode($iv . $tag . $ciphertext);
        }
    }

    throw new \RuntimeException('Sodium alebo OpenSSL je potrebné pre bezpečné uloženie 2FA tajomstva.');
}

/**
 * Dešifruje TOTP tajomstvo a odmietne poškodený alebo neznámy formát.
 */
function decryptTotpSecret(string $encrypted): string
{
    if (str_starts_with($encrypted, 's1:')) {
        if (!function_exists('sodium_crypto_secretbox_open')) {
            throw new \RuntimeException('PHP rozšírenie Sodium je potrebné pre načítanie 2FA tajomstva.');
        }
        $payload = totpBase64UrlDecode(substr($encrypted, 3));
        if ($payload === false || strlen($payload) <= SODIUM_CRYPTO_SECRETBOX_NONCEBYTES) {
            throw new \RuntimeException('Šifrované 2FA tajomstvo je poškodené.');
        }
        $nonce = substr($payload, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $ciphertext = substr($payload, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, getTotpEncryptionKey());
    } elseif (str_starts_with($encrypted, 'o1:')) {
        if (!function_exists('openssl_decrypt')) {
            throw new \RuntimeException('PHP rozšírenie OpenSSL je potrebné pre načítanie 2FA tajomstva.');
        }
        $payload = totpBase64UrlDecode(substr($encrypted, 3));
        if ($payload === false || strlen($payload) <= 28) {
            throw new \RuntimeException('Šifrované 2FA tajomstvo je poškodené.');
        }
        $iv = substr($payload, 0, 12);
        $tag = substr($payload, 12, 16);
        $ciphertext = substr($payload, 28);
        $plaintext = openssl_decrypt(
            $ciphertext,
            'aes-256-gcm',
            getTotpEncryptionKey(),
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            'nefro:totp:v1'
        );
    } else {
        throw new \RuntimeException('Neznámy formát šifrovaného 2FA tajomstva.');
    }

    if ($plaintext === false || $plaintext === '' || totpBase32Decode($plaintext) === false) {
        throw new \RuntimeException('Šifrované 2FA tajomstvo sa nepodarilo overiť.');
    }
    return $plaintext;
}

/**
 * Vytvorí šifrovaný envelope pre tajomstvo a bcrypt hashe záložných kódov.
 *
 * @return array{secret_field:string, backup_json:string}
 */
function encodeTotpStorage(string $secret, array $backupCodes): array
{
    $json = json_encode([
        'version' => 1,
        'secret' => encryptTotpSecret($secret),
        'codes' => array_values($backupCodes),
    ], JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        throw new \RuntimeException('2FA údaje sa nepodarilo zakódovať.');
    }

    return [
        'secret_field' => TOTP_ENCRYPTED_MARKER,
        'backup_json' => $json,
    ];
}

/**
 * Načíta nový šifrovaný formát aj pôvodný plaintext formát.
 *
 * @return array{secret:string, codes:array, legacy:bool}
 */
function decodeTotpStorage(string $secretField, ?string $backupJson): array
{
    $decoded = $backupJson !== null && $backupJson !== ''
        ? json_decode($backupJson, true)
        : [];

    if ($secretField === TOTP_ENCRYPTED_MARKER) {
        if (!is_array($decoded)
            || (int) ($decoded['version'] ?? 0) !== 1
            || !is_string($decoded['secret'] ?? null)
            || !is_array($decoded['codes'] ?? null)
        ) {
            throw new \RuntimeException('Šifrované 2FA úložisko je neplatné.');
        }
        return [
            'secret' => decryptTotpSecret($decoded['secret']),
            'codes' => array_values($decoded['codes']),
            'legacy' => false,
        ];
    }

    return [
        'secret' => $secretField,
        'codes' => is_array($decoded) && array_is_list($decoded) ? array_values($decoded) : [],
        'legacy' => true,
    ];
}

/**
 * Nahradí záložné kódy a zachová existujúce šifrované tajomstvo.
 *
 * @return array{secret_field:string, backup_json:string}
 */
function replaceTotpBackupCodes(string $secretField, ?string $backupJson, array $backupCodes): array
{
    $decoded = $backupJson !== null && $backupJson !== ''
        ? json_decode($backupJson, true)
        : null;

    if ($secretField === TOTP_ENCRYPTED_MARKER
        && is_array($decoded)
        && (int) ($decoded['version'] ?? 0) === 1
        && is_string($decoded['secret'] ?? null)
    ) {
        $decoded['codes'] = array_values($backupCodes);
        $json = json_encode($decoded, JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            throw new \RuntimeException('2FA údaje sa nepodarilo zakódovať.');
        }
        return ['secret_field' => TOTP_ENCRYPTED_MARKER, 'backup_json' => $json];
    }

    return encodeTotpStorage($secretField, $backupCodes);
}

/**
 * Generuje náhodný Base32-kódovaný tajný kľúč (160 bitov = 32 Base32 znakov).
 */
function generateTotpSecret(): string
{
    return totpBase32Encode(random_bytes(20));
}

/**
 * Overí TOTP kód. Akceptuje ±1 časové okno (tolerancia ±30 s).
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
 * Overí TOTP kód a vráti matched counter (int) alebo false.
 * Používa sa na replay ochranu — uložte counter do DB a odmietajte nižšie alebo rovnaké hodnoty.
 *
 * @param string $secret  Base32-kódovaný tajný kľúč
 * @param string $code    6-ciferný kód od používateľa
 * @param int    $window  Počet intervalov (každý 30 s) na každú stranu
 * @return int|false  Matched counter alebo false ak kód neplatí
 */
function verifyTotpCodeGetCounter(string $secret, string $code, int $window = 1): int|false
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
            return $counter + $i;
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
    // Prejdeme celé pole bez predčasného ukončenia — zabraňuje timing útoku.
    $matchIdx = -1;
    foreach ($hashedCodes as $i => $hash) {
        if (password_verify($normalized, (string) $hash) && $matchIdx === -1) {
            $matchIdx = (int) $i;
        }
    }
    return $matchIdx;
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
