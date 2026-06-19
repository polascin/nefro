<?php
declare(strict_types=1);
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
 * @return array{published_articles:int,users_total:int,authors:array<int,array{author:string,articles:int}>}
 */
function getProjectPublicStats(\PDO $pdo): array {
    $stats = [
        'published_articles' => 0,
        'users_total' => 0,
        'authors' => [],
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

    try {
        $authorsStmt = $pdo->query(
            "SELECT TRIM(author) AS author_name, content
             FROM articles
             WHERE is_published = 1"
        );

        $authorBuckets = [];
        foreach ($authorsStmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $articleAuthor = trim((string) ($row['author_name'] ?? ''));
            if ($articleAuthor !== '') {
                $articleAuthorKey = normalizeAuthorIdentity($articleAuthor);
                if ($articleAuthorKey !== '') {
                    if (!isset($authorBuckets[$articleAuthorKey])) {
                        $authorBuckets[$articleAuthorKey] = [
                            'author' => $articleAuthor,
                            'articles' => 0,
                        ];
                    }
                    $authorBuckets[$articleAuthorKey]['articles']++;
                }
            }

            $sourceFirstAuthor = extractOriginalSourceFirstAuthor((string) ($row['content'] ?? ''));
            if ($sourceFirstAuthor === '') {
                continue;
            }

            $sourceAuthorKey = normalizeAuthorIdentity($sourceFirstAuthor);
            if ($sourceAuthorKey === '') {
                continue;
            }

            if (
                $articleAuthor !== '' &&
                isset($articleAuthorKey) &&
                $articleAuthorKey !== '' &&
                $sourceAuthorKey === $articleAuthorKey
            ) {
                continue;
            }

            if (!isset($authorBuckets[$sourceAuthorKey])) {
                $authorBuckets[$sourceAuthorKey] = [
                    'author' => $sourceFirstAuthor,
                    'articles' => 0,
                ];
            }
            $authorBuckets[$sourceAuthorKey]['articles']++;
        }

        uasort($authorBuckets, static function (array $left, array $right): int {
            $leftCount = (int) ($left['articles'] ?? 0);
            $rightCount = (int) ($right['articles'] ?? 0);

            if ($leftCount !== $rightCount) {
                return $rightCount <=> $leftCount;
            }

            return strcasecmp(
                (string) ($left['author'] ?? ''),
                (string) ($right['author'] ?? '')
            );
        });

        foreach ($authorBuckets as $bucket) {
            $authorName = trim((string) ($bucket['author'] ?? ''));
            if ($authorName === '') {
                continue;
            }

            $stats['authors'][] = [
                'author' => $authorName,
                'articles' => max(0, (int) ($bucket['articles'] ?? 0)),
            ];
        }
    } catch (\PDOException $e) {
        error_log('project stats: chyba načítania autorov článkov: ' . $e->getMessage());
    }

    return $stats;
}

/**
 * Pokúsi sa zo sekcie "Zdroj:" vyťažiť prvého autora originálneho zdroja.
 */
function extractOriginalSourceFirstAuthor(string $content): string {
    if (trim($content) === '') {
        return '';
    }

    if (!preg_match_all('/Zdroj:\s*(.*?)(?:<\/p>|<\/li>|$)/isu', $content, $matches)) {
        return '';
    }

    foreach (($matches[1] ?? []) as $rawSourceSnippet) {
        $sourceText = normalizeSourceCitationText((string) $rawSourceSnippet);
        if ($sourceText === '') {
            continue;
        }

        $author = extractFirstAuthorFromCitation($sourceText);
        if ($author !== '') {
            return $author;
        }
    }

    return '';
}

/**
 * Normalizuje text citácie po značke "Zdroj:".
 */
function normalizeSourceCitationText(string $rawSource): string {
    $sourceText = html_entity_decode(
        strip_tags($rawSource),
        ENT_QUOTES | ENT_HTML5,
        'UTF-8'
    );
    $sourceText = trim((string) preg_replace('/\s+/u', ' ', $sourceText));
    if ($sourceText === '') {
        return '';
    }

    // Odstráni úvodné úvodzovky a podobné znaky.
    $sourceText = ltrim($sourceText, " \t\n\r\0\x0B\"'“”„‚`");
    // Odstráni počiatočné pomlčky a odrážky.
    $sourceText = preg_replace('/^[-–—•·]+\s*/u', '', $sourceText) ?? $sourceText;

    return trim($sourceText);
}

/**
 * Z citácie sa pokúsi vyťažiť prvého autora, ak vyzerá ako osoba.
 */
function extractFirstAuthorFromCitation(string $sourceText): string {
    // Niektoré citácie začínajú názvom periodika a až potom uvedú autorov.
    // Ak je pred dvojbodkou príliš dlhý segment, skúšame časť za dvojbodkou.
    if (preg_match('/^.{25,120}:\s+(.+)$/u', $sourceText, $segmentMatch)) {
        $sourceText = trim((string) ($segmentMatch[1] ?? $sourceText));
    }

    $candidates = [
        '/^([A-ZÁČĎÉÍĹĽŇÓÔŔŠŤÚÝŽ][\\p{L}\\-\'’]+(?:\s+[A-Z]{1,5}){1,2})(?=,|;|\.|\set\sal\.|\s\()/u',
        '/^([A-ZÁČĎÉÍĹĽŇÓÔŔŠŤÚÝŽ][\\p{L}\\-\'’]+(?:\s+[A-ZÁČĎÉÍĹĽŇÓÔŔŠŤÚÝŽ][\\p{L}\\-\'’]+){1,2})(?=,|;|\.|\set\sal\.|\s\()/u',
        '/^([A-ZÁČĎÉÍĹĽŇÓÔŔŠŤÚÝŽ][\\p{L}\\-\'’]+)(?=,|;)/u',
    ];

    foreach ($candidates as $pattern) {
        if (!preg_match($pattern, $sourceText, $parts)) {
            continue;
        }

        $author = trim((string) ($parts[1] ?? ''));
        if (isLikelyPersonalAuthorName($author)) {
            return $author;
        }
    }

    return '';
}

/**
 * Heuristika: overí, že extrahovaný autor je pravdepodobne osoba.
 */
function isLikelyPersonalAuthorName(string $author): bool {
    if ($author === '' || preg_match('/\\d/u', $author)) {
        return false;
    }

    if (mb_strlen($author, 'UTF-8') < 2 || mb_strlen($author, 'UTF-8') > 80) {
        return false;
    }

    if (
        preg_match(
            '/medscape|american|european|international|society|association|group|collaborative|guideline|journal|ajkd|nejm|jama|kdigo|kdoqi|fda|ema|pubmed|cureus|diabetes care|core curriculum|review/i',
            $author
        )
    ) {
        return false;
    }

    return true;
}

/**
 * Vytvorí normalizovaný kľúč autora pre porovnávanie a deduplikáciu.
 */
function normalizeAuthorIdentity(string $author): string {
    $value = trim($author);
    if ($value === '') {
        return '';
    }

    // Zjednotenie medzier a malých/veľkých písmen.
    $value = trim((string) preg_replace('/\s+/u', ' ', $value));
    $value = mb_strtolower($value, 'UTF-8');

    // Odstránenie bežných titulov pred menom.
    $value = preg_replace(
        '/^(?:prof\.|doc\.|mudr\.|mddr\.|mvdr\.|rndr\.|phdr\.|judr\.|paeddr\.|phmr\.|mgr\.|mgr\.\s*art\.|ing\.|ing\.\s*arch\.|bc\.|bca\.|dr\.)\s+/u',
        '',
        $value
    ) ?? $value;

    // Odstránenie bežných titulov za menom.
    $value = preg_replace(
        '/,?\s*(?:phd\.|ph\.d\.|csc\.|drsc\.|dsc\.|mba|msc\.|ll\.m\.|mph|mha|dis\.|di\.s\.)$/u',
        '',
        $value
    ) ?? $value;

    // Odstránenie bodiek pre porovnanie variantov titulov.
    $value = str_replace('.', '', $value);

    return trim($value);
}

function formatProjectPublicCount(int $count): string {
    return number_format(max(0, $count), 0, ',', ' ');
}

function formatProjectArticleCountLabel(int $count): string {
    $count = max(0, $count);
    $unit = match ($count) {
        1 => 'článok',
        2, 3, 4 => 'články',
        default => 'článkov',
    };

    return formatProjectPublicCount($count) . ' ' . $unit;
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
