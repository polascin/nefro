<?php
declare(strict_types=1);
// Ochrana pred priamym prístupom k súboru
if (basename($_SERVER['PHP_SELF'] ?? '') === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit("Prístup odmietnutý.");
}

/**
 * Vráti kandidátne cesty ku konfiguračnému súboru.
 * Poradie je od najbezpečnejšej/explicitnej po fallback pre lokálny vývoj.
 */
function getAppConfigPaths(): array {
    $paths = [];

    $envOverride = trim((string) getenv('NEFRO_ENV_PATH'));
    if ($envOverride !== '') {
        $paths[] = $envOverride;
    }

    $appRoot = __DIR__;
    $searchRoots = [$appRoot];

    $currentDir = $appRoot;
    for ($level = 0; $level < 4; $level++) {
        $parentDir = dirname($currentDir);
        if ($parentDir === $currentDir) {
            break;
        }
        $searchRoots[] = $parentDir;
        $currentDir = $parentDir;
    }

    $documentRoot = trim((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''));
    if ($documentRoot !== '') {
        $searchRoots[] = rtrim($documentRoot, '/\\');

        $currentDir = rtrim($documentRoot, '/\\');
        for ($level = 0; $level < 4; $level++) {
            $parentDir = dirname($currentDir);
            if ($parentDir === $currentDir) {
                break;
            }
            $searchRoots[] = $parentDir;
            $currentDir = $parentDir;
        }
    }

    $searchRoots = array_values(array_unique($searchRoots));

    foreach ($searchRoots as $root) {
        $paths[] = $root . DIRECTORY_SEPARATOR . 'nefro.env.ini';
        $paths[] = $root . DIRECTORY_SEPARATOR . 'env.ini';
        $paths[] = $root . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'nefro.env.ini';
        $paths[] = $root . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'env.ini';
    }

    // Fallback pre lokálny vývoj alebo existujúce prostredie.
    $paths[] = $appRoot . DIRECTORY_SEPARATOR . 'env.ini';

    return array_values(array_unique($paths));
}

/**
 * Načíta konfiguráciu z prvého dostupného ini súboru.
 */
function loadAppConfig(): array {
    static $config = null;

    if ($config !== null) {
        return $config;
    }

    foreach (getAppConfigPaths() as $path) {
        if (!is_file($path) || !is_readable($path)) {
            continue;
        }

        $parsed = parse_ini_file($path, false, INI_SCANNER_TYPED);
        if ($parsed !== false) {
            $config = $parsed;
            return $config;
        }
    }

    $searchedPaths = implode(', ', getAppConfigPaths());
    throw new RuntimeException('Konfiguračný súbor sa nenašiel alebo je neplatný. Hľadané cesty: ' . $searchedPaths);
}

/**
 * Vráti true/false pre textové env hodnoty ako 1/0, true/false, yes/no, on/off.
 */
function parseEnvBool(mixed $value, bool $default = false): bool {
    if ($value === null) {
        return $default;
    }

    $normalized = strtolower(trim((string) $value));
    if ($normalized === '') {
        return $default;
    }

    $truthy = ['1', 'true', 'yes', 'on'];
    $falsy = ['0', 'false', 'no', 'off'];

    if (in_array($normalized, $truthy, true)) {
        return true;
    }
    if (in_array($normalized, $falsy, true)) {
        return false;
    }

    return $default;
}

/**
 * Centrálne určenie lokálneho/development režimu.
 * Preferuje explicitnú konfiguráciu APP_ENV alebo APP_LOCAL_DEV.
 */
function isAppLocalDev(): bool {
    try {
        $env = loadAppConfig();
    } catch (\RuntimeException) {
        $env = [];
    }

    $appEnv = strtolower(trim((string) ($env['APP_ENV'] ?? getenv('APP_ENV') ?? '')));
    if ($appEnv !== '') {
        return in_array($appEnv, ['local', 'dev', 'development', 'test', 'testing'], true);
    }

    if (array_key_exists('APP_LOCAL_DEV', $env) || getenv('APP_LOCAL_DEV') !== false) {
        return parseEnvBool($env['APP_LOCAL_DEV'] ?? getenv('APP_LOCAL_DEV'), false);
    }

    return false;
}

/**
 * Urči HTTPS schému bez dôvery v spoofovateľný Host header.
 * Proxy hlavičky sa akceptujú len ak je explicitne povolené TRUST_PROXY_HEADERS.
 */
function isRequestHttps(): bool {
    $httpsFlag = $_SERVER['HTTPS'] ?? null;
    if (!empty($httpsFlag) && strtolower((string) $httpsFlag) !== 'off') {
        return true;
    }

    if (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443) {
        return true;
    }

    try {
        $env = loadAppConfig();
    } catch (\RuntimeException) {
        $env = [];
    }

    $trustProxy = parseEnvBool($env['TRUST_PROXY_HEADERS'] ?? getenv('TRUST_PROXY_HEADERS'), false);
    if ($trustProxy) {
        $forwardedProto = strtolower(trim((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')));
        if ($forwardedProto === 'https') {
            return true;
        }
    }

    return false;
}

/**
 * Vráti bezpečný základ URL. Priorita:
 * 1) APP_BASE_URL z konfigurácie
 * 2) schéma + SERVER_NAME (+ port)
 */
function getAppBaseUrl(): string {
    try {
        $env = loadAppConfig();
    } catch (\RuntimeException) {
        $env = [];
    }

    $configured = trim((string) ($env['APP_BASE_URL'] ?? getenv('APP_BASE_URL') ?? ''));
    if ($configured !== '' && filter_var($configured, FILTER_VALIDATE_URL)) {
        return rtrim($configured, '/');
    }

    $scheme = isRequestHttps() ? 'https' : 'http';
    $serverName = trim((string) ($_SERVER['SERVER_NAME'] ?? 'localhost'));

    if ($serverName === '' || !preg_match('/^[a-z0-9.-]+$/i', $serverName)) {
        $serverName = 'localhost';
    }

    $port = (int) ($_SERVER['SERVER_PORT'] ?? 0);
    $includePort = $port > 0 && !(($scheme === 'http' && $port === 80) || ($scheme === 'https' && $port === 443));

    return $scheme . '://' . $serverName . ($includePort ? ':' . $port : '');
}

/**
 * Vráti 32-bajtový aplikačný kľúč pre šifrovanie a pseudonymizáciu dát.
 */
function getAppDataProtectionKey(): string {
    static $key = null;

    if ($key !== null) {
        return $key;
    }

    try {
        $env = loadAppConfig();
    } catch (\RuntimeException $e) {
        $env = [];
        error_log('Data protection key config loading failed: ' . $e->getMessage());
    }

    $rawKey = '';
    $candidates = [
        (string) ($env['DATA_PROTECTION_KEY'] ?? getenv('DATA_PROTECTION_KEY') ?: ''),
        (string) ($env['APP_KEY'] ?? getenv('APP_KEY') ?: ''),
        (string) ($env['APP_SECRET'] ?? getenv('APP_SECRET') ?: ''),
        (string) ($env['NEWSLETTER_UNSUBSCRIBE_SECRET'] ?? getenv('NEWSLETTER_UNSUBSCRIBE_SECRET') ?: ''),
    ];
    foreach ($candidates as $candidate) {
        $candidate = trim($candidate);
        if ($candidate !== '') {
            $rawKey = $candidate;
            break;
        }
    }

    if ($rawKey === '') {
        $keyDir = __DIR__ . DIRECTORY_SEPARATOR . 'private';
        $keyPath = $keyDir . DIRECTORY_SEPARATOR . 'data_protection.key';
        if (!is_dir($keyDir) && !@mkdir($keyDir, 0750, true) && !is_dir($keyDir)) {
            throw new \RuntimeException('DATA_PROTECTION_KEY is not configured and the private key directory cannot be created.');
        }

        if (is_file($keyPath)) {
            $rawKey = trim((string) @file_get_contents($keyPath));
        } else {
            $generatedKey = base64_encode(random_bytes(32));
            $handle = @fopen($keyPath, 'x');
            if ($handle !== false) {
                if (fwrite($handle, $generatedKey . PHP_EOL) === false) {
                    fclose($handle);
                    @unlink($keyPath);
                    throw new \RuntimeException('Generated data protection key could not be stored.');
                }
                fclose($handle);
                @chmod($keyPath, 0600);
                $rawKey = $generatedKey;
            } elseif (is_file($keyPath)) {
                // Iný súbežný request vytvoril kľúč medzi kontrolou a fopen().
                $rawKey = trim((string) @file_get_contents($keyPath));
            }
        }

        if ($rawKey === '') {
            throw new \RuntimeException('DATA_PROTECTION_KEY is not configured and no persistent fallback key is available.');
        }
    }

    $key = hash('sha256', $rawKey, true);
    return $key;
}

/**
 * Centrálna funkcia na získanie klientovej IP adresy.
 * Rešpektuje TRUST_PROXY_HEADERS — dostupná aj v endpoint súboroch bez auth.php.
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
}
