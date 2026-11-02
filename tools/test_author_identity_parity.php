<?php

declare(strict_types=1);

/**
 * P1 autori: hydratácia contentu len pre unmapped slugy musí zachovať identity
 * oproti načítaniu s plným contentom.
 */

require_once dirname(__DIR__) . '/db_config.php';

/** @var PDO $pdo */
if (!isset($pdo) || !$pdo instanceof PDO) {
    fwrite(STDERR, "Author identity parity: no PDO\n");
    exit(1);
}

$checks = 0;
function authorParityTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$src = (string) file_get_contents(dirname(__DIR__) . '/db_config.php');
authorParityTest(
    str_contains($src, 'function hydrateArticleContentForUnmappedAuthors'),
    'db_config musí obsahovať hydrateArticleContentForUnmappedAuthors.',
);
authorParityTest(
    str_contains($src, 'function buildPublishedAuthorCatalog'),
    'db_config musí obsahovať buildPublishedAuthorCatalog.',
);
authorParityTest(
    str_contains($src, 'hydrateArticleContentForUnmappedAuthors($pdo, $rows)'),
    'katalóg autorov musí volať hydrate.',
);
authorParityTest(
    str_contains($src, 'author_index_v1'),
    'signatúra cache musí verziovať author_index.',
);

$map = function_exists('getSourceArticleAuthors') ? getSourceArticleAuthors() : [];
authorParityTest($map !== [], 'source_authors mapa nesmie byť prázdna.');

$stmt = $pdo->query(
    'SELECT id, title, slug, author, excerpt, published_at, content, is_top, sort_order
     FROM articles WHERE is_published = 1
     ORDER BY is_top DESC, sort_order ASC, published_at DESC, id ASC
     LIMIT 80'
);
$fullRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
authorParityTest($fullRows !== [], 'Musí existovať aspoň jeden publikovaný článok.');

$liteRows = [];
foreach ($fullRows as $row) {
    $lite = $row;
    unset($lite['content']);
    $liteRows[] = $lite;
}
hydrateArticleContentForUnmappedAuthors($pdo, $liteRows);

$mappedChecked = 0;
$unmappedChecked = 0;
foreach ($fullRows as $i => $full) {
    $slug = (string) ($full['slug'] ?? '');
    $fullIds = articleAuthorIdentities($full);
    $liteIds = articleAuthorIdentities($liteRows[$i]);
    authorParityTest(
        $fullIds === $liteIds,
        "Identity musia sedieť pre slug={$slug}.",
    );
    if ($slug !== '' && isset($map[$slug])) {
        $mappedChecked++;
        authorParityTest(
            ($liteRows[$i]['content'] ?? 'x') === '',
            "Mapovaný slug {$slug} nesmie ťahať content.",
        );
    } else {
        $unmappedChecked++;
        authorParityTest(
            array_key_exists('content', $liteRows[$i]),
            "Unmapped slug {$slug} musí mať content kľúč.",
        );
    }
}

authorParityTest($mappedChecked > 0, 'Vzorka musí obsahovať mapovaný článok.');
authorParityTest($unmappedChecked > 0, 'Vzorka musí obsahovať unmapped článok.');

// Studený katalóg + teplý cache filter.
@unlink(projectStatsCachePath());
$t0 = hrtime(true);
$authors = fetchProjectAuthors($pdo);
$coldMs = (hrtime(true) - $t0) / 1e6;
authorParityTest($authors !== [], 'fetchProjectAuthors musí vrátiť autorov.');
$sample = (string) ($authors[0]['author'] ?? '');
$t0 = hrtime(true);
$filtered = fetchPublishedArticlesByAuthor($pdo, $sample);
$warmMs = (hrtime(true) - $t0) / 1e6;
authorParityTest($filtered !== [], "Filter pre „{$sample}“ musí niečo nájsť.");
authorParityTest(
    $warmMs < $coldMs || $warmMs < 50.0,
    sprintf('Teplý filter (%.1f ms) musí byť rýchlejší než studený katalóg (%.1f ms) alebo pod 50 ms.', $warmMs, $coldMs),
);

$again = fetchPublishedArticlesByAuthor($pdo, $sample);
authorParityTest(
    array_column($filtered, 'id') === array_column($again, 'id'),
    'Opakovaný filter z cache musí vrátiť rovnaké ID.',
);

echo "Author identity parity: $checks PASS (mapped=$mappedChecked unmapped=$unmappedChecked cold_ms="
    . round($coldMs, 1) . " warm_ms=" . round($warmMs, 1) . ")\n";
