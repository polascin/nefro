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
require_once __DIR__ . '/source_authors.php';

try {
    $env = loadAppConfig();
} catch (\RuntimeException $e) {
    error_log('Konfigurácia DB nebola načítaná: ' . $e->getMessage());

    $isCli = php_sapi_name() === 'cli';
    $host = strtolower((string) ($_SERVER['SERVER_NAME'] ?? ''));
    $isLocalHttp = in_array($host, ['localhost', '127.0.0.1', '::1'], true);

    if ($isCli || $isLocalHttp) {
        exit("Chyba: " . $e->getMessage());
    }

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
 * Výpočet autorov skenuje obsah všetkých publikovaných článkov (regex „Zdroj:"),
 * preto sa výsledok cachuje. Cache invaliduje lacný podpis (počet článkov +
 * MAX(updated_at) + počet používateľov) — pri zmene článku sa prepočíta automaticky.
 *
 * @return array{published_articles:int,users_total:int,authors:array<int,array{author:string,articles:int}>}
 */
function getProjectPublicStats(\PDO $pdo): array {
    $meta = fetchProjectStatsMeta($pdo);
    $signature = $meta['signature'];

    if ($signature !== '') {
        $cached = readProjectStatsCache($signature);
        if ($cached !== null) {
            return $cached;
        }
    }

    $stats = [
        'published_articles' => $meta['published_articles'],
        'users_total' => $meta['users_total'],
        'authors' => fetchProjectAuthors($pdo),
    ];

    if ($signature !== '') {
        writeProjectStatsCache($signature, $stats);
    }

    return $stats;
}

/**
 * Lacný dotaz: základné počty + podpis na invalidáciu cache (bez skenu obsahu).
 *
 * @return array{published_articles:int,users_total:int,signature:string}
 */
function fetchProjectStatsMeta(\PDO $pdo): array {
    $meta = ['published_articles' => 0, 'users_total' => 0, 'signature' => ''];

    try {
        $stmt = $pdo->query(
            "SELECT
                (SELECT COUNT(*) FROM articles WHERE is_published = 1) AS published_articles,
                (SELECT COALESCE(MAX(updated_at), '') FROM articles WHERE is_published = 1) AS max_updated,
                (SELECT COUNT(*) FROM users) AS users_total"
        );
        $row = $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
        $meta['published_articles'] = max(0, (int) ($row['published_articles'] ?? 0));
        $meta['users_total'] = max(0, (int) ($row['users_total'] ?? 0));
        // Fingerprint mapy zdrojových autorov — zmena source_authors.php
        // automaticky invaliduje cache (inak by signatúra závisela len od článkov).
        $sourceFingerprint = function_exists('getSourceArticleAuthors')
            ? crc32((string) json_encode(getSourceArticleAuthors()))
            : 0;
        $meta['signature'] = hash(
            'sha256',
            $meta['published_articles'] . '|' . (string) ($row['max_updated'] ?? '')
                . '|' . $meta['users_total'] . '|' . $sourceFingerprint
        );
    } catch (\PDOException $e) {
        error_log('project stats: chyba načítania verejných štatistík: ' . $e->getMessage());
    }

    return $meta;
}

function projectStatsCachePath(): string {
    return __DIR__ . '/private/cache/project_stats.json';
}

/**
 * @return array{published_articles:int,users_total:int,authors:array<int,array{author:string,articles:int}>}|null
 */
function readProjectStatsCache(string $signature): ?array {
    $path = projectStatsCachePath();
    if (!is_file($path)) {
        return null;
    }

    $raw = @file_get_contents($path);
    if ($raw === false) {
        return null;
    }

    $data = json_decode($raw, true);
    if (!is_array($data) || ($data['signature'] ?? '') !== $signature || !is_array($data['stats'] ?? null)) {
        return null;
    }

    $stats = $data['stats'];
    $authors = [];
    foreach (is_array($stats['authors'] ?? null) ? $stats['authors'] : [] as $author) {
        if (is_array($author)) {
            $authors[] = [
                'author' => (string) ($author['author'] ?? ''),
                'articles' => (int) ($author['articles'] ?? 0),
            ];
        }
    }

    return [
        'published_articles' => (int) ($stats['published_articles'] ?? 0),
        'users_total' => (int) ($stats['users_total'] ?? 0),
        'authors' => $authors,
    ];
}

/**
 * @param array{published_articles:int,users_total:int,authors:array<int,array{author:string,articles:int}>} $stats
 */
function writeProjectStatsCache(string $signature, array $stats): void {
    $dir = __DIR__ . '/private/cache';
    if (!is_dir($dir) && !@mkdir($dir, 0750, true) && !is_dir($dir)) {
        return; // cache je best-effort — pri zlyhaní sa len prepočíta nabudúce
    }
    @chmod($dir, 0750);

    $payload = json_encode(['signature' => $signature, 'stats' => $stats], JSON_UNESCAPED_UNICODE);
    if ($payload === false) {
        return;
    }

    $cachePath = projectStatsCachePath();
    if (@file_put_contents($cachePath, $payload, LOCK_EX) !== false) {
        @chmod($cachePath, 0640);
    }
}

/**
 * @return array<int,array{author:string,articles:int}>
 */
function fetchProjectAuthors(\PDO $pdo): array {
    $authors = [];

    try {
        $authorsStmt = $pdo->query(
            "SELECT TRIM(author) AS author_name, slug, content
             FROM articles
             WHERE is_published = 1"
        );

        $authorBuckets = [];
        foreach ($authorsStmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            registerArticleAuthors($authorBuckets, $row);
        }

        sortAuthorBuckets($authorBuckets);
        $authors = mapAuthorBucketsToStats($authorBuckets);
    } catch (\PDOException $e) {
        error_log('project stats: chyba načítania autorov článkov: ' . $e->getMessage());
    }

    return $authors;
}

/**
 * Vráti množinu identít autorov článku — jednotný zdroj pravdy pre widget
 * „Zúčastnení autori" (počítanie) aj pre filter `?autor=` (vyhľadávanie).
 * Zahŕňa autora projektu a pôvodných zdrojových autorov (z poľa `author`
 * aj z citácie „Zdroj:" v obsahu), len ak vyzerajú ako osoby; v rámci jedného
 * článku je každá identita najviac raz.
 *
 * @param array<string,mixed> $row  očakáva 'author_name' alebo 'author' a 'content'
 * @return array<string,string>  normalizovaný kľúč => zobrazované meno
 */
function articleAuthorIdentities(array $row): array {
    $parsed = parseArticleAuthorField((string) ($row['author_name'] ?? $row['author'] ?? ''));
    $content = (string) ($row['content'] ?? '');

    /** @var array<string,string> $identities */
    $identities = [];
    $register = static function (string $name) use (&$identities): void {
        $name = trim($name);
        // Publikácie/zdroje (ReachMD, ScienceDaily, časopisy) neprejdú person-filtrom.
        if ($name === '' || !isLikelyPersonalAuthorName($name)) {
            return;
        }
        $key = normalizeAuthorIdentity($name);
        if ($key !== '' && !isset($identities[$key])) {
            $identities[$key] = $name;
        }
    };

    // Autor projektu (pole author, prípadne časť za "… Autor: X").
    $register($parsed['project']);
    // Pôvodný autor zdroja zapísaný priamo v poli author ("Meno (Medscape); Autor: …").
    $register($parsed['source']);

    // Pôvodní autori zdrojového článku. Kurátorská mapa podľa slugu
    // (source_authors.php, plné mená z otvorených bibliografických API) je
    // AUTORITATÍVNA — ak existuje, použije sa namiesto skrátenej extrakcie z
    // obsahu (predíde duplicitným notáciám „Ostermann M" vs „Marlies Ostermann").
    static $sourceMap = null;
    if ($sourceMap === null) {
        $sourceMap = function_exists('getSourceArticleAuthors') ? getSourceArticleAuthors() : [];
    }
    $slug = (string) ($row['slug'] ?? '');
    if ($slug !== '' && isset($sourceMap[$slug])) {
        foreach ($sourceMap[$slug] as $sourceAuthor) {
            $register((string) $sourceAuthor);
        }
    } else {
        // Fallback: pôvodný autor zdroja vyťažený zo značky "Zdroj:" v obsahu.
        $register(extractOriginalSourceFirstAuthor($content));
    }

    return $identities;
}

/**
 * @param array<string,array{author:string,articles:int}> $authorBuckets
 * @param array<string,mixed> $row
 */
function registerArticleAuthors(array &$authorBuckets, array $row): void {
    foreach (articleAuthorIdentities($row) as $authorName) {
        registerAuthorContribution($authorBuckets, $authorName);
    }
}

/**
 * Načíta publikované články, kde je daný autor medzi identitami článku
 * (autor projektu alebo pôvodný zdrojový autor). Používa rovnakú logiku ako
 * widget „Zúčastnení autori", preto klik na ktoréhokoľvek autora vždy dopadne
 * na reálny obsah a počty sedia. Zoradené ako hlavný výpis (top, poradie, dátum).
 *
 * @return array<int,array{id:int,title:string,slug:string,author:string,excerpt:string,published_at:string,is_top:int}>
 */
function fetchPublishedArticlesByAuthor(\PDO $pdo, string $authorName): array {
    $targetKey = normalizeAuthorIdentity($authorName);
    if ($targetKey === '') {
        return [];
    }

    try {
        $stmt = $pdo->query(
            "SELECT id, title, slug, author, excerpt, published_at, content, is_top, sort_order
             FROM articles
             WHERE is_published = 1
             ORDER BY is_top DESC, sort_order ASC, published_at DESC"
        );
    } catch (\PDOException $e) {
        error_log('project stats: chyba filtra článkov podľa autora: ' . $e->getMessage());
        return [];
    }

    $matches = [];
    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $identities = articleAuthorIdentities($row);
        if (!isset($identities[$targetKey])) {
            continue;
        }

        $matches[] = [
            'id'           => (int) $row['id'],
            'title'        => (string) $row['title'],
            'slug'         => (string) $row['slug'],
            'author'       => (string) $row['author'],
            'excerpt'      => (string) $row['excerpt'],
            'published_at' => (string) $row['published_at'],
            'is_top'       => (int) $row['is_top'],
        ];
    }

    return $matches;
}

/**
 * Rozparsuje pole "author" na autora projektu a autora pôvodného zdroja.
 * Podporované tvary:
 *   "MUDr. Ľubomír Polaščín"                                  → projekt
 *   "Batya Swift Yasgur (Medscape); Autor: MUDr. … Polaščín"  → zdroj + projekt
 *   "Medscape / Univadis; Autor: MUDr. … Polaščín"            → (zdroj=publikácia) + projekt
 *
 * @return array{project:string,source:string}
 */
function parseArticleAuthorField(string $author): array {
    $author = trim((string) preg_replace('/\s+/u', ' ', $author));
    $project = $author;
    $source = '';

    if (preg_match('/^(.*?)\s*;\s*Autor\s*:\s*(.+)$/iu', $author, $m)) {
        $source = trim($m[1]);
        $project = trim($m[2]);
    }

    // Z autora zdroja odstráň zátvorky "(Medscape)" a koncové tituly za čiarkou (", MD").
    $source = trim((string) preg_replace('/\s*\([^)]*\)/u', '', $source));
    $source = trim((string) preg_replace('/,\s*[A-Za-z.\s]{1,12}$/u', '', $source));

    return ['project' => $project, 'source' => $source];
}

/**
 * Odvodí autorov pre byline článku: autora projektu (predvolene
 * „MUDr. Ľubomír Polaščín") a zoznam pôvodných autorov zdroja (len osoby)
 * z poľa `author` („… (Medscape); Autor: …") a z citácie „Zdroj:" v obsahu.
 * Publikácie/časopisy ostávajú v citácii „Zdroj:" v tele článku.
 *
 * @return array{project:string,sources:array<int,string>}
 */
function getArticleBylineAuthors(string $author, string $content): array {
    $parsed = parseArticleAuthorField($author);

    $project = $parsed['project'];
    if (!isLikelyPersonalAuthorName($project)) {
        $project = 'MUDr. Ľubomír Polaščín';
    }

    $sources = [];
    $seen = [normalizeAuthorIdentity($project) => true];

    // Pole `author` („Meno (Medscape); Autor: …") je kurátorský zdroj autora;
    // citáciu „Zdroj:" v obsahu použijeme len ako fallback, keď pole autora
    // neobsahuje osobu — inak by sa tá istá osoba mohla zopakovať v dvoch
    // notáciách („Batya Swift Yasgur" vs. „Yasgur BS").
    $candidates = isLikelyPersonalAuthorName(trim($parsed['source']))
        ? [$parsed['source']]
        : [extractOriginalSourceFirstAuthor($content)];

    foreach ($candidates as $candidate) {
        $candidate = trim($candidate);
        if ($candidate === '' || !isLikelyPersonalAuthorName($candidate)) {
            continue;
        }

        $key = normalizeAuthorIdentity($candidate);
        if ($key === '' || isset($seen[$key])) {
            continue;
        }

        $sources[] = $candidate;
        $seen[$key] = true;
    }

    return ['project' => $project, 'sources' => $sources];
}

/**
 * Postaví schema.org `author` z výsledku getArticleBylineAuthors():
 * jeden Person objekt (autor projektu), alebo pole Person pri viacerých
 * (projekt + pôvodní autori zdroja).
 *
 * @param array{project:string,sources:array<int,string>} $bylineAuthors
 * @return array<string,mixed>|array<int,array<string,mixed>>
 */
function buildArticleAuthorSchema(array $bylineAuthors): array {
    $projectAuthor = [
        '@type' => 'Person',
        'name' => $bylineAuthors['project'],
        'sameAs' => 'https://polascin.com/',
    ];

    if (empty($bylineAuthors['sources'])) {
        return $projectAuthor;
    }

    $authors = [$projectAuthor];
    foreach ($bylineAuthors['sources'] as $sourceName) {
        $authors[] = ['@type' => 'Person', 'name' => $sourceName];
    }

    return $authors;
}

/**
 * @param array<string,array{author:string,articles:int}> $authorBuckets
 */
function registerAuthorContribution(array &$authorBuckets, string $authorName): string {
    $authorName = trim($authorName);
    $authorKey = normalizeAuthorIdentity($authorName);
    if ($authorKey === '') {
        return '';
    }

    if (!isset($authorBuckets[$authorKey])) {
        $authorBuckets[$authorKey] = [
            'author' => $authorName,
            'articles' => 0,
        ];
    }

    $authorBuckets[$authorKey]['articles']++;

    return $authorKey;
}

/**
 * @param array<string,array{author:string,articles:int}> $authorBuckets
 */
function sortAuthorBuckets(array &$authorBuckets): void {
    uasort($authorBuckets, static function (array $left, array $right): int {
        $leftCount = (int) $left['articles'];
        $rightCount = (int) $right['articles'];

        if ($leftCount !== $rightCount) {
            return $rightCount <=> $leftCount;
        }

        return strcasecmp(
            (string) $left['author'],
            (string) $right['author']
        );
    });
}

/**
 * @param array<string,array{author:string,articles:int}> $authorBuckets
 * @return array<int,array{author:string,articles:int}>
 */
function mapAuthorBucketsToStats(array $authorBuckets): array {
    $stats = [];

    foreach ($authorBuckets as $bucket) {
        $authorName = trim((string) $bucket['author']);
        if ($authorName === '') {
            continue;
        }

        $stats[] = [
            'author' => $authorName,
            'articles' => max(0, (int) $bucket['articles']),
        ];
    }

    return $stats;
}

/**
 * Pokúsi sa zo sekcie "Zdroj:" vyťažiť prvého autora originálneho zdroja.
 */
function extractOriginalSourceFirstAuthor(string $content): string {
    $result = '';

    if (
        trim($content) !== '' &&
        preg_match_all('/Zdroj:\s*([^<]*(?:<(?!\/(?:p|li)>)[^<]*)*)(?:<\/p>|<\/li>|$)/isu', $content, $matches)
    ) {
        foreach ($matches[1] as $rawSourceSnippet) {
            $sourceText = normalizeSourceCitationText((string) $rawSourceSnippet);
            if ($sourceText === '') {
                continue;
            }

            $author = extractFirstAuthorFromCitation($sourceText);
            if ($author !== '') {
                $result = $author;
                break;
            }
        }
    }

    return $result;
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
        $sourceText = trim((string) $segmentMatch[1]);
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

        $author = trim((string) $parts[1]);
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
    $isValid = true;

    if ($author === '' || preg_match('/\\d/u', $author)) {
        $isValid = false;
    }

    if ($isValid && (mb_strlen($author, 'UTF-8') < 2 || mb_strlen($author, 'UTF-8') > 80)) {
        $isValid = false;
    }

    if ($isValid) {
        foreach (getNonPersonAuthorKeywords() as $keyword) {
            if (stripos($author, $keyword) !== false) {
                $isValid = false;
                break;
            }
        }
    }

    return $isValid;
}

/**
 * @return string[]
 */
function getNonPersonAuthorKeywords(): array {
    return [
        'medscape',
        'american',
        'european',
        'international',
        'society',
        'association',
        'group',
        'collaborative',
        'guideline',
        'journal',
        'ajkd',
        'nejm',
        'jama',
        'kdigo',
        'kdoqi',
        'fda',
        'ema',
        'pubmed',
        'cureus',
        'diabetes care',
        'core curriculum',
        'review',
        // Publikácie, spravodajské portály a citované časopisy (nie sú osoby).
        'reachmd',
        'sciencedaily',
        'science daily',
        'docwire',
        'univadis',
        'advisor',
        'academy',
        'pathogenesis',
        'barcelona',
        'clinic',
        'clínic',
        'nephrology',
        'dialysis',
        'transplantation',
        'urology',
        'renal',
        'nefro',
        'infectious',
        'disease',
        'kidney',
        'health',
        'medicine',
        'university',
        'hospital',
        'institute',
        'foundation',
    ];
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

    $value = stripKnownTitlePrefixes($value);
    $value = stripKnownTitleSuffixes($value);

    // Odstránenie bodiek pre porovnanie variantov titulov.
    $value = str_replace('.', '', $value);

    return trim($value);
}

function stripKnownTitlePrefixes(string $value): string {
    $prefixes = [
        'prof.',
        'doc.',
        'mudr.',
        'mddr.',
        'mvdr.',
        'rndr.',
        'phdr.',
        'judr.',
        'paeddr.',
        'phmr.',
        'mgr.',
        'mgr. art.',
        'ing.',
        'ing. arch.',
        'bc.',
        'bca.',
        'dr.',
    ];

    $trimmed = ltrim($value);
    foreach ($prefixes as $prefix) {
        $prefixWithSpace = $prefix . ' ';
        if (str_starts_with($trimmed, $prefixWithSpace)) {
            return ltrim(substr($trimmed, strlen($prefixWithSpace)) ?: '');
        }
    }

    return $trimmed;
}

function stripKnownTitleSuffixes(string $value): string {
    $suffixes = [
        'phd.',
        'ph.d.',
        'csc.',
        'drsc.',
        'dsc.',
        'mba',
        'msc.',
        'll.m.',
        'mph',
        'mha',
        'dis.',
        'di.s.',
    ];

    $trimmed = trim($value);
    foreach ($suffixes as $suffix) {
        $directSuffix = ' ' . $suffix;
        $commaSuffix = ', ' . $suffix;

        if (str_ends_with($trimmed, $commaSuffix)) {
            return trim(substr($trimmed, 0, -strlen($commaSuffix)) ?: '');
        }

        if (str_ends_with($trimmed, $directSuffix)) {
            return trim(substr($trimmed, 0, -strlen($directSuffix)) ?: '');
        }
    }

    return $trimmed;
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

/**
 * Slovenský tvar počtu autorov (1 autor / 2–4 autori / 5+ autorov).
 * Pre widget „Zúčastnení autori" (celkový počet).
 */
function formatParticipatingAuthorsLabel(int $count): string {
    $count = max(0, $count);
    $unit = match ($count) {
        1 => 'autor',
        2, 3, 4 => 'autori',
        default => 'autorov',
    };

    return formatProjectPublicCount($count) . ' ' . $unit;
}

/**
 * Mená autorov projektu — na odlíšenie od pôvodných autorov zdrojových článkov
 * vo widgete „Zúčastnení autori". Zatiaľ jediný autor projektu.
 *
 * @return array<int,string>
 */
function getProjectAuthorNames(): array {
    return ['MUDr. Ľubomír Polaščín'];
}

/**
 * Rozdelí agregovaný zoznam zúčastnených autorov (z fetchProjectAuthors) na
 * autora/autorov projektu a pôvodných autorov zdrojových článkov a uvedie
 * celkový počet. Jednotný zdroj pre widget „Zúčastnení autori".
 *
 * @param array<int,array{author:string,articles:int}> $authors
 * @return array{project:array<int,array{author:string,articles:int}>,sources:array<int,array{author:string,articles:int}>,total:int}
 */
function splitParticipatingAuthors(array $authors): array {
    $projectKeys = [];
    foreach (getProjectAuthorNames() as $name) {
        $key = normalizeAuthorIdentity($name);
        if ($key !== '') {
            $projectKeys[$key] = true;
        }
    }

    $project = [];
    $sources = [];
    $total = 0;
    foreach ($authors as $authorStat) {
        $name = trim($authorStat['author']);
        if ($name === '') {
            continue;
        }
        $total++;
        if (isset($projectKeys[normalizeAuthorIdentity($name)])) {
            $project[] = $authorStat;
        } else {
            $sources[] = $authorStat;
        }
    }

    return ['project' => $project, 'sources' => $sources, 'total' => $total];
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
        return $rows ?: getFallbackTitlesBefore();
    } catch (\PDOException $e) {
        error_log('title_codebook: chyba načítania titulov pred menom: ' . $e->getMessage());
        return getFallbackTitlesBefore();
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
        return $rows ?: getFallbackTitlesAfter();
    } catch (\PDOException $e) {
        error_log('title_codebook: chyba načítania titulov za menom: ' . $e->getMessage());
        return getFallbackTitlesAfter();
    }
}

/** @internal Fallback zoznam titulov pred menom. */
function getFallbackTitlesBefore(): array {
    return [
        'prof.', 'doc.', 'MUDr.', 'MDDr.', 'MVDr.', 'RNDr.', 'PhDr.', 'JUDr.',
        'PaedDr.', 'PhMr.', 'Mgr.', 'Mgr. art.', 'Ing.', 'Ing. arch.',
        'Bc.', 'BcA.', 'ThDr.', 'ThLic.', 'ThMgr.', 'Dr.', 'Dr. h. c.', 'Dipl. Ing.',
    ];
}

/** @internal Fallback zoznam titulov za menom. */
function getFallbackTitlesAfter(): array {
    return [
        'PhD.', 'Ph.D.', 'CSc.', 'DrSc.', 'DSc.', 'DBA', 'MBA', 'MSc.',
        'LL.M.', 'MPH', 'MHA', 'MPA', 'MPHA', 'MPM', 'FRCPS', 'FACP', 'FRCP',
        'dis.', 'DiS.',
    ];
}

// ── Číselník typov používateľa ───────────────────────────────────────────────

/**
 * Vráti zoskupený číselník typov používateľa (voliteľné pole v registrácii a profile).
 *
 * Kľúč poľa = názov skupiny (HTML <optgroup>); prázdny kľúč '' znamená možnosti bez skupiny.
 * Hodnoty = popisy možností, ktoré sú zároveň hodnotami ukladanými do stĺpca users.user_type.
 * Toto je jediný zdroj pravdy — používa ho formulár (render) aj serverová validácia (whitelist).
 *
 * @return array<string, string[]>
 */
function getUserTypeGroups(): array {
    return [
        'Zdravotnícki pracovníci' => [
            'Lekár/lekárka',
            'Sestra/brat',
            'Zdravotník/zdravotníčka',
            'Zdravotnícky záchranár/záchranárka',
            'Farmaceut/farmaceutka',
            'Nutričný terapeut/nutričná terapeutka',
            'Fyzioterapeut/fyzioterapeutka',
            'Psychológ/psychologička',
            'Sociálny pracovník/sociálna pracovníčka',
            'Laborant/laborantka',
        ],
        'Veda a vzdelávanie' => [
            'Vedecký/výskumný pracovník',
            'Učiteľ/učiteľka',
            'Lektor/lektorka',
            'Študent/študentka medicíny',
        ],
        'Pacienti a verejnosť' => [
            'Pacient/pacientka',
            'Rodinný príslušník/opatrujúca osoba',
        ],
        '' => [
            'Iné',
        ],
    ];
}

/**
 * Plochý whitelist povolených hodnôt user_type pre serverovú validáciu.
 *
 * @return string[]
 */
function getUserTypeWhitelist(): array {
    $flat = [];
    foreach (getUserTypeGroups() as $options) {
        foreach ($options as $opt) {
            $flat[] = $opt;
        }
    }
    return $flat;
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
