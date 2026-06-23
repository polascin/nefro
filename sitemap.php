<?php
declare(strict_types=1);
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

header('Content-Type: application/xml; charset=UTF-8');
header('Cache-Control: public, max-age=1800');

$baseUrl = 'https://nefro.polascin.net/';

// Pomocná funkcia: vráti ISO 8601 lastmod z filemtime() alebo fallback na dnešný dátum
function _sitemapLastmod(string $file): string {
    $path = __DIR__ . '/' . $file;
    $ts = is_file($path) ? @filemtime($path) : false;
    return date('c', $ts !== false ? $ts : time());
}

$urls = [
    [
        'loc'        => $baseUrl,
        'lastmod'    => _sitemapLastmod('index.php'),
        'changefreq' => 'daily',
        'priority'   => '1.0',
    ],
    [
        'loc'        => $baseUrl . 'calculators.php',
        'lastmod'    => _sitemapLastmod('calculators.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.9',
    ],
    [
        'loc'        => $baseUrl . 'calculator_egfr.php',
        'lastmod'    => _sitemapLastmod('calculator_egfr.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_egfr_cys.php',
        'lastmod'    => _sitemapLastmod('calculator_egfr_cys.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_kdigo_risk.php',
        'lastmod'    => _sitemapLastmod('calculator_kdigo_risk.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_kfre.php',
        'lastmod'    => _sitemapLastmod('calculator_kfre.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_ckdpc.php',
        'lastmod'    => _sitemapLastmod('calculator_ckdpc.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_prevent.php',
        'lastmod'    => _sitemapLastmod('calculator_prevent.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_igan.php',
        'lastmod'    => _sitemapLastmod('calculator_igan.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_adpkd.php',
        'lastmod'    => _sitemapLastmod('calculator_adpkd.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_aki.php',
        'lastmod'    => _sitemapLastmod('calculator_aki.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_cg.php',
        'lastmod'    => _sitemapLastmod('calculator_cg.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_crcl_24h.php',
        'lastmod'    => _sitemapLastmod('calculator_crcl_24h.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_crrt.php',
        'lastmod'    => _sitemapLastmod('calculator_crrt.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_mehran.php',
        'lastmod'    => _sitemapLastmod('calculator_mehran.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_units.php',
        'lastmod'    => _sitemapLastmod('calculator_units.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.7',
    ],
    [
        'loc'        => $baseUrl . 'calculator_ca.php',
        'lastmod'    => _sitemapLastmod('calculator_ca.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_na.php',
        'lastmod'    => _sitemapLastmod('calculator_na.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_acidbase.php',
        'lastmod'    => _sitemapLastmod('calculator_acidbase.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_egfr_slope.php',
        'lastmod'    => _sitemapLastmod('calculator_egfr_slope.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_ktv.php',
        'lastmod'    => _sitemapLastmod('calculator_ktv.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_npcr.php',
        'lastmod'    => _sitemapLastmod('calculator_npcr.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'calculator_uacr.php',
        'lastmod'    => _sitemapLastmod('calculator_uacr.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'nastroje.php',
        'lastmod'    => _sitemapLastmod('nastroje.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ],
    [
        'loc'        => $baseUrl . 'nastroj_aki.php',
        'lastmod'    => _sitemapLastmod('nastroj_aki.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.7',
    ],
    [
        'loc'        => $baseUrl . 'nastroj_hyponatremia.php',
        'lastmod'    => _sitemapLastmod('nastroj_hyponatremia.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.7',
    ],
    [
        'loc'        => $baseUrl . 'nastroj_hypokalemia.php',
        'lastmod'    => _sitemapLastmod('nastroj_hypokalemia.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.7',
    ],
    [
        'loc'        => $baseUrl . 'nastroj_dieta.php',
        'lastmod'    => _sitemapLastmod('nastroj_dieta.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.7',
    ],
    [
        'loc'        => $baseUrl . 'populars.php',
        'lastmod'    => _sitemapLastmod('populars.php'),
        'changefreq' => 'weekly',
        'priority'   => '0.7',
    ],
    [
        'loc'        => $baseUrl . 'cheatsheets.php',
        'lastmod'    => _sitemapLastmod('cheatsheets.php'),
        'changefreq' => 'monthly',
        'priority'   => '0.7',
    ],
    [
        'loc'        => $baseUrl . 'podpora.php',
        'lastmod'    => _sitemapLastmod('podpora.php'),
        'changefreq' => 'yearly',
        'priority'   => '0.5',
    ],
    [
        'loc'        => $baseUrl . 'privacy.php',
        'lastmod'    => _sitemapLastmod('privacy.php'),
        'changefreq' => 'yearly',
        'priority'   => '0.3',
    ],
    [
        'loc'        => $baseUrl . 'cookies.php',
        'lastmod'    => _sitemapLastmod('cookies.php'),
        'changefreq' => 'yearly',
        'priority'   => '0.3',
    ],
    [
        'loc'        => $baseUrl . 'terms.php',
        'lastmod'    => _sitemapLastmod('terms.php'),
        'changefreq' => 'yearly',
        'priority'   => '0.3',
    ],
];

$maxArticleTs = 0;

try {
    $stmt = $pdo->query("SELECT slug, published_at, updated_at FROM articles WHERE is_published = 1 ORDER BY published_at DESC, id DESC");
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($articles as $article) {
        $slug = trim((string) ($article['slug'] ?? ''));
        if ($slug === '') {
            continue;
        }

        $lastModRaw = (string) ($article['updated_at'] ?? $article['published_at'] ?? '');
        $lastModTs = strtotime($lastModRaw);
        if ($lastModTs && $lastModTs > $maxArticleTs) {
            $maxArticleTs = $lastModTs;
        }

        $urls[] = [
            'loc' => $baseUrl . 'article.php?slug=' . rawurlencode($slug),
            'lastmod' => $lastModTs ? date('c', $lastModTs) : date('c'),
            'changefreq' => 'monthly',
            'priority' => '0.8',
        ];
    }
} catch (\PDOException $e) {
    error_log('sitemap.php generation error: ' . $e->getMessage());
}

// Domovská stránka sa obsahovo mení pri každom novom článku — lastmod nech
// odráža najnovší článok (signál čerstvosti), nie len dátum deployu index.php.
if ($maxArticleTs > 0) {
    $homeTs = is_file(__DIR__ . '/index.php') ? (int) @filemtime(__DIR__ . '/index.php') : 0;
    $urls[0]['lastmod'] = date('c', max($maxArticleTs, $homeTs));
}

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

foreach ($urls as $url) {
    $loc = htmlspecialchars((string) $url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $lastmod = htmlspecialchars((string) $url['lastmod'], ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $changefreq = htmlspecialchars((string) $url['changefreq'], ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $priority = htmlspecialchars((string) $url['priority'], ENT_XML1 | ENT_QUOTES, 'UTF-8');

    if ($loc === '') {
        continue;
    }

    echo "  <url>\n";
    echo "    <loc>{$loc}</loc>\n";
    echo "    <lastmod>{$lastmod}</lastmod>\n";
    echo "    <changefreq>{$changefreq}</changefreq>\n";
    echo "    <priority>{$priority}</priority>\n";
    echo "  </url>\n";
}

echo "</urlset>\n";
