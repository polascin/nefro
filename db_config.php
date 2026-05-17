<?php
// Ochrana pred priamym prístupom k súboru
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit("Prístup odmietnutý.");
}

/**
 * Konfigurácia pripojenia k databáze
 */
require_once __DIR__ . '/config_loader.php';

try {
    $env = loadAppConfig();
} catch (\RuntimeException $e) {
    error_log('Konfigurácia DB nebola načítaná: ' . $e->getMessage());
    exit("Chyba: Konfiguračný súbor sa nenašiel alebo je neplatný.");
}

$dbHost = (string) ($env['DB_HOST'] ?? '');
$dbName = (string) ($env['DB_NAME'] ?? '');
$dbUser = (string) ($env['DB_USER'] ?? '');
$dbPass = (string) ($env['DB_PASS'] ?? '');
$dbCharset = 'utf8mb4';

if ($dbHost === '' || $dbName === '' || $dbUser === '') {
    error_log('Konfigurácia DB je nekompletná.');
    exit("Chyba: Databázová konfigurácia je nekompletná.");
}

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=$dbCharset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Vyhadzovanie výnimiek pri chybách
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Výsledky ako asociatívne polia
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Použitie natívnych prepared statements pre lepšiu bezpečnosť
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (\PDOException $e) {
    // V produkcii by sa chyba nemala vypisovať priamo kvôli bezpečnosti
    // Zapisujeme do logu a zobrazíme všeobecnú chybu
    error_log("Chyba pripojenia k databáze: " . $e->getMessage());
    exit("Chyba: Pripojenie k databáze zlyhalo.");
}

/**
 * Vráti verejne zobraziteľné štatistiky projektu.
 *
 * @return array{published_articles:int,users_total:int}
 */
function getProjectPublicStats(\PDO $pdo): array {
    $stats = [
        'published_articles' => 0,
        'users_total' => 0,
    ];

    try {
        $stmt = $pdo->query(
            "SELECT
                (SELECT COUNT(*) FROM articles WHERE is_published = 1) AS published_articles,
                (SELECT COUNT(*) FROM users) AS users_total"
        );
        $row = $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
        $stats['published_articles'] = max(0, (int) ($row['published_articles'] ?? 0));
        $stats['users_total'] = max(0, (int) ($row['users_total'] ?? 0));
    } catch (\PDOException $e) {
        error_log('project stats: chyba načítania verejných štatistík: ' . $e->getMessage());
    }

    return $stats;
}

function formatProjectPublicCount(int $count): string {
    return number_format(max(0, $count), 0, ',', ' ');
}

// ── Číselník akademických a iných titulov ───────────────────────────────────

/**
 * Vráti zoznam titulov pred menom z tabuľky title_codebook.
 * Ak tabuľka neexistuje alebo je prázdna, vráti zabudovaný fallback zoznam.
 */
function getTitlesBeforeName(\PDO $pdo): array {
    try {
        $stmt = $pdo->prepare(
            "SELECT title FROM title_codebook WHERE type = 'before' ORDER BY sort_order ASC, title ASC"
        );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return $rows ?: _getFallbackTitlesBefore();
    } catch (\PDOException $e) {
        error_log('title_codebook: chyba načítania titulov pred menom: ' . $e->getMessage());
        return _getFallbackTitlesBefore();
    }
}

/**
 * Vráti zoznam titulov za menom z tabuľky title_codebook.
 * Ak tabuľka neexistuje alebo je prázdna, vráti zabudovaný fallback zoznam.
 */
function getTitlesAfterName(\PDO $pdo): array {
    try {
        $stmt = $pdo->prepare(
            "SELECT title FROM title_codebook WHERE type = 'after' ORDER BY sort_order ASC, title ASC"
        );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return $rows ?: _getFallbackTitlesAfter();
    } catch (\PDOException $e) {
        error_log('title_codebook: chyba načítania titulov za menom: ' . $e->getMessage());
        return _getFallbackTitlesAfter();
    }
}

/** @internal Fallback zoznam titulov pred menom. */
function _getFallbackTitlesBefore(): array {
    return [
        'prof.', 'doc.', 'MUDr.', 'MDDr.', 'MVDr.', 'RNDr.', 'PhDr.', 'JUDr.',
        'PaedDr.', 'PhMr.', 'Mgr.', 'Mgr. art.', 'Ing.', 'Ing. arch.',
        'Bc.', 'BcA.', 'ThDr.', 'ThLic.', 'ThMgr.', 'Dr.', 'Dr. h. c.', 'Dipl. Ing.',
    ];
}

/** @internal Fallback zoznam titulov za menom. */
function _getFallbackTitlesAfter(): array {
    return [
        'PhD.', 'Ph.D.', 'CSc.', 'DrSc.', 'DSc.', 'DBA', 'MBA', 'MSc.',
        'LL.M.', 'MPH', 'MHA', 'MPA', 'MPHA', 'MPM', 'FRCPS', 'FACP', 'FRCP',
        'dis.', 'DiS.',
    ];
}

// ── Číselník adries ──────────────────────────────────────────────────────────

/**
 * Vráti zoznam názvov štátov pre datalist.
 * @return string[] Pole názvov štátov zoradených podľa sort_order
 */
function getCountries(\PDO $pdo): array {
    try {
        $stmt = $pdo->query(
            "SELECT name_sk FROM codebook_countries ORDER BY sort_order ASC, name_sk ASC"
        );
        $rows = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return $rows ?: ['Slovenská republika', 'Česká republika', 'Rakúsko', 'Maďarsko', 'Poľsko'];
    } catch (\PDOException $e) {
        error_log('codebook_countries: ' . $e->getMessage());
        return ['Slovenská republika', 'Česká republika', 'Rakúsko', 'Maďarsko', 'Poľsko'];
    }
}

/**
 * Vráti zoznam názvov krajov pre datalist.
 * @return string[] Pole názvov krajov
 */
function getRegions(\PDO $pdo): array {
    try {
        $stmt = $pdo->query(
            "SELECT name FROM codebook_regions ORDER BY sort_order ASC, name ASC"
        );
        $rows = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return $rows ?: [
            'Bratislavský kraj', 'Trnavský kraj', 'Trenčiansky kraj', 'Nitriansky kraj',
            'Žilinský kraj', 'Banskobystrický kraj', 'Prešovský kraj', 'Košický kraj',
        ];
    } catch (\PDOException $e) {
        error_log('codebook_regions: ' . $e->getMessage());
        return [
            'Bratislavský kraj', 'Trnavský kraj', 'Trenčiansky kraj', 'Nitriansky kraj',
            'Žilinský kraj', 'Banskobystrický kraj', 'Prešovský kraj', 'Košický kraj',
        ];
    }
}

/**
 * Vráti zoznam názvov okresov pre datalist.
 * @return string[] Pole názvov okresov
 */
function getDistricts(\PDO $pdo): array {
    try {
        $stmt = $pdo->query(
            "SELECT name FROM codebook_districts ORDER BY sort_order ASC, name ASC"
        );
        $rows = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return $rows ?: [];
    } catch (\PDOException $e) {
        error_log('codebook_districts: ' . $e->getMessage());
        return [];
    }
}

/**
 * Vráti zoznam obcí pre datalist (prípadne filtrovaný podľa okresu).
 * @param string|null $districtFilter Nepovinný filter podľa okresu
 * @return string[] Pole názvov obcí
 */
function getMunicipalities(\PDO $pdo, ?string $districtFilter = null): array {
    try {
        if ($districtFilter !== null && $districtFilter !== '') {
            $stmt = $pdo->prepare(
                "SELECT name FROM codebook_municipalities WHERE district_name = :d ORDER BY sort_order ASC, name ASC"
            );
            $stmt->execute(['d' => $districtFilter]);
        } else {
            $stmt = $pdo->query(
                "SELECT name FROM codebook_municipalities ORDER BY sort_order ASC, name ASC LIMIT 500"
            );
        }
        return $stmt->fetchAll(\PDO::FETCH_COLUMN) ?: [];
    } catch (\PDOException $e) {
        error_log('codebook_municipalities: ' . $e->getMessage());
        return [];
    }
}

/**
 * Vráti pole obcí so PSČ pre JS autofill.
 * Formát: [['name'=>..., 'zip_code'=>..., 'district_name'=>..., 'region_code'=>...], ...]
 * @return array<int,array<string,string>>
 */
function getMunicipalitiesWithZip(\PDO $pdo): array {
    try {
        $stmt = $pdo->query(
            "SELECT name, zip_code, district_name, region_code
             FROM codebook_municipalities
             ORDER BY sort_order ASC, name ASC"
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    } catch (\PDOException $e) {
        error_log('codebook_municipalities (zip): ' . $e->getMessage());
        return [];
    }
}

/**
 * Vráti zoznam unikátnych PSČ pre datalist.
 * @return string[]
 */
function getZipCodes(\PDO $pdo): array {
    try {
        $stmt = $pdo->query(
            "SELECT DISTINCT zip_code FROM codebook_municipalities ORDER BY zip_code ASC"
        );
        return $stmt->fetchAll(\PDO::FETCH_COLUMN) ?: [];
    } catch (\PDOException $e) {
        error_log('codebook_municipalities (zip list): ' . $e->getMessage());
        return [];
    }
}
/**
 * Preloží kód kraja (napr. 'BL') na jeho plný názov (napr. 'Bratislavský kraj').
 * @return string Plný názov alebo pôvodný kód ak sa nenájde
 */
function getRegionNameByCode(\PDO $pdo, string $code): string {
    static $cache = [];
    if (isset($cache[$code])) {
        return $cache[$code];
    }
    try {
        $stmt = $pdo->prepare("SELECT name FROM codebook_regions WHERE code = :code LIMIT 1");
        $stmt->execute(['code' => $code]);
        $name = $stmt->fetchColumn();
        $cache[$code] = $name !== false ? (string) $name : $code;
    } catch (\PDOException $e) {
        $cache[$code] = $code;
    }
    return $cache[$code];
}
?>
