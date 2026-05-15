<?php
require_once 'db_config.php';

header('Content-Type: application/xml; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: public, max-age=1800');

$baseUrl = 'https://nefro.polascin.net/';
$urls = [
    [
        'loc' => $baseUrl,
        'lastmod' => date('c'),
        'changefreq' => 'daily',
        'priority' => '1.0',
    ],
    [
        'loc' => $baseUrl . 'calculators.php',
        'lastmod' => date('c'),
        'changefreq' => 'weekly',
        'priority' => '0.9',
    ],
    [
        'loc' => $baseUrl . 'calculator_egfr.php',
        'lastmod' => date('c'),
        'changefreq' => 'weekly',
        'priority' => '0.8',
    ],
    [
        'loc' => $baseUrl . 'calculator_kdigo_risk.php',
        'lastmod' => date('c'),
        'changefreq' => 'weekly',
        'priority' => '0.8',
    ],
];

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

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

foreach ($urls as $url) {
    $loc = htmlspecialchars((string) ($url['loc'] ?? ''), ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $lastmod = htmlspecialchars((string) ($url['lastmod'] ?? ''), ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $changefreq = htmlspecialchars((string) ($url['changefreq'] ?? 'monthly'), ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $priority = htmlspecialchars((string) ($url['priority'] ?? '0.5'), ENT_XML1 | ENT_QUOTES, 'UTF-8');

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
