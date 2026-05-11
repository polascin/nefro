<?php
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
