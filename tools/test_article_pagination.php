<?php

declare(strict_types=1);

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec(
    'CREATE TABLE articles (
        physical_order INTEGER PRIMARY KEY,
        id INTEGER NOT NULL UNIQUE,
        title TEXT NOT NULL,
        slug TEXT NOT NULL,
        author TEXT NOT NULL,
        excerpt TEXT NOT NULL,
        published_at TEXT NOT NULL,
        content TEXT NOT NULL,
        is_top INTEGER NOT NULL,
        is_published INTEGER NOT NULL,
        category TEXT NOT NULL,
        sort_order INTEGER NOT NULL
    )',
);

$indexSource = (string) file_get_contents(__DIR__ . '/../index.php');
$articleSource = (string) file_get_contents(__DIR__ . '/../db_config.php');
$checks = 0;

function articlePaginationTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

function articlePaginationExtractFunction(string $source, string $name): string
{
    $tokens = token_get_all($source);
    $count = count($tokens);

    for ($i = 0; $i < $count; ++$i) {
        if (!is_array($tokens[$i]) || $tokens[$i][0] !== T_FUNCTION) {
            continue;
        }

        $start = $i;
        for ($j = $i + 1; $j < $count; ++$j) {
            if (is_array($tokens[$j]) && $tokens[$j][0] === T_STRING) {
                if ($tokens[$j][1] !== $name) {
                    break;
                }

                $bodyStart = $j;
                while ($bodyStart < $count && $tokens[$bodyStart] !== '{') {
                    ++$bodyStart;
                }
                if ($bodyStart === $count) {
                    break;
                }

                $sourceCode = '';
                $depth = 0;
                for ($k = $start; $k < $count; ++$k) {
                    $text = is_array($tokens[$k]) ? $tokens[$k][1] : $tokens[$k];
                    $sourceCode .= $text;
                    if ($tokens[$k] === '{') {
                        ++$depth;
                    } elseif ($tokens[$k] === '}') {
                        --$depth;
                        if ($depth === 0) {
                            return $sourceCode;
                        }
                    }
                }
                break;
            }
        }
    }

    throw new RuntimeException("Function $name not found.");
}

function articlePaginationOrder(string $source, string $where): string
{
    $pattern = '/FROM articles WHERE ' . preg_quote($where, '/') . '\s+ORDER BY ([^"\r\n]+)/';
    if (!preg_match($pattern, $source, $matches)) {
        throw new RuntimeException("Article query not found for: $where");
    }

    return trim($matches[1]);
}

function normalizeAuthorIdentity(string $author): string
{
    return mb_strtolower(trim($author), 'UTF-8');
}

function articleAuthorIdentities(array $row): array
{
    $author = (string) ($row['author'] ?? '');
    return $author === '' ? [] : [normalizeAuthorIdentity($author) => $author];
}

$authorFunction = articlePaginationExtractFunction($articleSource, 'fetchPublishedArticlesByAuthor');
eval($authorFunction);

$insert = $pdo->prepare(
    'INSERT INTO articles
        (physical_order, id, title, slug, author, excerpt, published_at, content, is_top, is_published, category, sort_order)
     VALUES
        (:physical_order, :id, :title, :slug, :author, :excerpt, :published_at, :content, :is_top, 1, :category, 5)',
);
// The rowid (physical scan order) is deliberately decoupled from article IDs,
// so a query without the ID tie-breaker cannot return range(1, 50) by accident.
for ($position = 1; $position <= 50; ++$position) {
    $id = (($position * 17) % 50) + 1;
    $insert->execute([
        'physical_order' => $position,
        'id' => $id,
        'title' => "Synthetic article $id",
        'slug' => "synthetic-article-$id",
        'author' => 'Pagination Test Author',
        'excerpt' => 'Synthetic excerpt',
        'published_at' => '2026-10-11 12:00:00',
        'content' => 'Synthetic content',
        'is_top' => 0,
        'category' => 'odborne',
    ]);
}
$physicalIds = array_map('intval', $pdo->query('SELECT id FROM articles ORDER BY physical_order')->fetchAll(PDO::FETCH_COLUMN));
articlePaginationTest(
    $physicalIds !== range(1, 50) && $physicalIds !== range(50, 1) && count(array_unique($physicalIds)) === 50,
    'Fixture physical order must be a unique non-monotonic permutation of article IDs.',
);

$standardWhere = "is_top = 0 AND is_published = 1 AND category = 'odborne'";
$standardOrder = articlePaginationOrder($indexSource, $standardWhere);
articlePaginationTest(
    $standardOrder === 'sort_order ASC, published_at DESC, id ASC',
    'Main article pagination must add a unique ID tie-breaker after existing ordering.',
);
$mainIds = [];
for ($page = 0; $page < 3; ++$page) {
    $query = $pdo->query(
        "SELECT id FROM articles WHERE $standardWhere ORDER BY $standardOrder LIMIT 21 OFFSET " . ($page * 21),
    );
    $mainIds[] = array_map('intval', $query->fetchAll(PDO::FETCH_COLUMN));
}
articlePaginationTest(
    array_map('count', $mainIds) === [21, 21, 8],
    'Equal-key main query must retain the expected 21/21/8 page boundaries.',
);
$flattenedMainIds = array_merge(...$mainIds);
articlePaginationTest(
    $flattenedMainIds === range(1, 50),
    'Equal-key main query pages must be deterministic, complete, and duplicate-free.',
);

$topWhere = "is_top = 1 AND is_published = 1 AND category = 'odborne'";
$topOrder = articlePaginationOrder($indexSource, $topWhere);
articlePaginationTest(
    $topOrder === 'sort_order ASC, published_at DESC, id ASC',
    'Top article query must retain its ordering and use the same unique tie-breaker.',
);

articlePaginationTest(
    preg_match('/ORDER BY ([^"\r\n]+)"/', $authorFunction, $authorOrderMatch) === 1
        && trim($authorOrderMatch[1]) === 'is_top DESC, sort_order ASC, published_at DESC, id ASC',
    'Author query must keep the main ordering and add the unique ID tie-breaker.',
);
$authorArticles = fetchPublishedArticlesByAuthor($pdo, 'Pagination Test Author');
articlePaginationTest(
    array_column($authorArticles, 'id') === range(1, 50),
    'Author query must return equal-key articles in deterministic unique-ID order.',
);
$authorPages = [
    array_slice($authorArticles, 0, 21),
    array_slice($authorArticles, 21, 21),
    array_slice($authorArticles, 42, 21),
];
articlePaginationTest(
    array_map('count', $authorPages) === [21, 21, 8],
    'Equal-key author results must retain the expected 21/21/8 page boundaries.',
);
$flattenedAuthorIds = array_map(
    static fn (array $row): int => $row['id'],
    array_merge(...$authorPages),
);
articlePaginationTest(
    $flattenedAuthorIds === range(1, 50),
    'Equal-key author pages must be complete and duplicate-free.',
);

echo "Article pagination: $checks checks PASS\n";
