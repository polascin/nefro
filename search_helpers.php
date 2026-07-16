<?php

declare(strict_types=1);
/**
 * search_helpers.php — Shared search helpers for search.php and regression tests.
 */

const SEARCH_PER_PAGE = 10;
const SEARCH_SNIPPET = 230;
const SEARCH_MIN_LEN = 2;
const SEARCH_MAX_TOKENS = 8;

const SK_STOP_WORDS = [
    "a",
    "aby",
    "aj",
    "ak",
    "ale",
    "ani",
    "ako",
    "alebo",
    "az",
    "ba",
    "bez",
    "bol",
    "bola",
    "boli",
    "byť",
    "by",
    "čo",
    "či",
    "ďalej",
    "do",
    "dolu",
    "ho",
    "hoci",
    "ich",
    "je",
    "jej",
    "im",
    "k",
    "kde",
    "keď",
    "kedy",
    "keďže",
    "kto",
    "ktory",
    "ku",
    "lebo",
    "len",
    "medzi",
    "mi",
    "my",
    "na",
    "nad",
    "nám",
    "nie",
    "nielen",
    "no",
    "o",
    "od",
    "okolo",
    "on",
    "oni",
    "po",
    "pod",
    "podľa",
    "pokiaľ",
    "pre",
    "pri",
    "s",
    "sa",
    "si",
    "sme",
    "sú",
    "tak",
    "taktiež",
    "teda",
    "tejto",
    "to",
    "toho",
    "tom",
    "tu",
    "u",
    "v",
    "viac",
    "vo",
    "voči",
    "vždy",
    "z",
    "za",
    "zo",
    "že",
    "než",
    "iba",
    "toto",
    "táto",
    "tento",
    "the",
    "and",
    "for",
    "that",
    "are",
    "with",
    "this",
    "was",
    "but",
    "not",
];

function searchNormalizeSk(string $text): string
{
    static $map = [
        "á" => "a",
        "ä" => "a",
        "č" => "c",
        "ď" => "d",
        "é" => "e",
        "í" => "i",
        "ĺ" => "l",
        "ľ" => "l",
        "ň" => "n",
        "ó" => "o",
        "ô" => "o",
        "ŕ" => "r",
        "š" => "s",
        "ť" => "t",
        "ú" => "u",
        "ý" => "y",
        "ž" => "z",
        "Á" => "a",
        "Ä" => "a",
        "Č" => "c",
        "Ď" => "d",
        "É" => "e",
        "Í" => "i",
        "Ĺ" => "l",
        "Ľ" => "l",
        "Ň" => "n",
        "Ó" => "o",
        "Ô" => "o",
        "Ŕ" => "r",
        "Š" => "s",
        "Ť" => "t",
        "Ú" => "u",
        "Ý" => "y",
        "Ž" => "z",
    ];
    return strtolower(strtr($text, $map));
}

function searchTokenize(string $rawQuery): array
{
    $clean = preg_replace('/[^\p{L}\p{N}\s]+/u', " ", $rawQuery) ?? $rawQuery;
    $clean = preg_replace("/\s+/u", " ", trim($clean)) ?? $clean;

    $rawTokens = explode(" ", $clean);
    $tokens = [];

    foreach ($rawTokens as $tok) {
        $tok = trim($tok);
        if (mb_strlen($tok, "UTF-8") < SEARCH_MIN_LEN) {
            continue;
        }
        $normalized = searchNormalizeSk($tok);
        if (in_array($normalized, SK_STOP_WORDS, true)) {
            continue;
        }
        $tokens[$normalized] = $tok;
    }

    $tokens = array_slice($tokens, 0, SEARCH_MAX_TOKENS, true);
    return $tokens;
}

function searchFtIndexExists(PDO $pdo): bool
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    try {
        $s = $pdo->prepare(
            "SELECT COUNT(*) FROM information_schema.STATISTICS
             WHERE table_schema = DATABASE()
               AND table_name   = 'articles'
               AND index_name   = 'ft_articles_search'
               AND index_type   = 'FULLTEXT'",
        );
        $s->execute();
        $cache = ((int) $s->fetchColumn()) > 0;
    } catch (\PDOException $e) {
        $cache = false;
    }
    return $cache;
}

function doArticleSearch(
    PDO $pdo,
    array $tokens,
    int $page,
    int $perPage,
): array {
    $offset = ($page - 1) * $perPage;
    $result = ["items" => [], "total" => 0, "strategy" => "none"];

    if (empty($tokens)) {
        return $result;
    }

    if (searchFtIndexExists($pdo)) {
        $ftResult = searchViaFullText(
            $pdo,
            $tokens,
            $offset,
            $perPage,
        );
        if ($ftResult["total"] > 0) {
            $ftResult["strategy"] = "fulltext";
            $result = $ftResult;
        }
    }

    if ($result["total"] === 0) {
        $likeResult = searchViaLike($pdo, $tokens, $offset, $perPage, false);
        if ($likeResult["total"] > 0) {
            $likeResult["strategy"] = "like";
            $result = $likeResult;
        }
    }

    if ($result["total"] === 0) {
        $likeNormResult = searchViaLike($pdo, $tokens, $offset, $perPage, true);
        if ($likeNormResult["total"] > 0) {
            $likeNormResult["strategy"] = "like-normalized";
            $result = $likeNormResult;
        }
    }

    return $result;
}

function searchArticles(PDO $pdo, string $rawQuery, int $page, int $perPage): array
{
    $tokens = searchTokenize($rawQuery);
    if (empty($tokens)) {
        return [
            "items" => [],
            "total" => 0,
            "strategy" => "none",
            "page" => 1,
            "totalPages" => 1,
            "tokens" => $tokens,
        ];
    }

    $sr = doArticleSearch($pdo, $tokens, $page, $perPage);
    $totalPages = max(1, (int) ceil($sr["total"] / $perPage));

    if ($page > $totalPages) {
        $page = $totalPages;
        $sr = doArticleSearch($pdo, $tokens, $page, $perPage);
    }

    return [
        "items" => $sr["items"],
        "total" => $sr["total"],
        "strategy" => $sr["strategy"],
        "page" => $page,
        "totalPages" => $totalPages,
        "tokens" => $tokens,
    ];
}

function searchViaFullText(
    PDO $pdo,
    array $tokens,
    int $offset,
    int $perPage,
): array {
    $result = ["items" => [], "total" => 0];
    $ftParts = [];
    foreach ($tokens as $orig) {
        $safe = str_replace(
            ["*", "@", "~", "+", "-", "<", ">", "(", ")", '\"'],
            "",
            $orig,
        );
        if ($safe !== "") {
            $ftParts[] = $safe . "*";
        }
    }
    if (empty($ftParts)) {
        return $result;
    }

    $ftQuery = implode(" ", $ftParts);

    try {
        $cntStmt = $pdo->prepare(
            "SELECT COUNT(*) FROM articles
             WHERE is_published = 1
               AND MATCH(title, excerpt, content) AGAINST(:q IN BOOLEAN MODE)",
        );
        $cntStmt->execute(["q" => $ftQuery]);
        $total = (int) $cntStmt->fetchColumn();

        if ($total > 0) {
            $stmt = $pdo->prepare(
                "SELECT id, title, slug, author, excerpt, published_at,
                        LEFT(content, 3000) AS content_preview
                 FROM articles
                 WHERE is_published = 1
                   AND MATCH(title, excerpt, content) AGAINST(:q IN BOOLEAN MODE)
                 ORDER BY MATCH(title, excerpt, content) AGAINST(:q IN BOOLEAN MODE) DESC,
                          published_at DESC
                 LIMIT :lim OFFSET :off",
            );
            $stmt->bindValue(":q", $ftQuery, PDO::PARAM_STR);
            $stmt->bindValue(":lim", $perPage, PDO::PARAM_INT);
            $stmt->bindValue(":off", $offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $result = ["items" => $rows, "total" => $total];
        }
    } catch (\PDOException $e) {
        $result = ["items" => [], "total" => 0];
    }

    return $result;
}

function searchViaLike(
    PDO $pdo,
    array $tokens,
    int $offset,
    int $perPage,
    bool $useNormalized,
): array {
    $result = ["items" => [], "total" => 0];
    if (empty($tokens)) {
        return $result;
    }

    $whereParams = [];
    $scoreParams = [];
    $whereParts = [];
    $scoreParts = [];
    $idx = 0;

    foreach ($tokens as $norm => $orig) {
        $term = $useNormalized ? $norm : $orig;
        $term = str_replace(["\\", "%", "_"], ["\\\\", "\\%", "\\_"], $term);
        $pattern = "%" . $term . "%";

        $wT = "wt" . $idx;
        $wE = "we" . $idx;
        $wC = "wc" . $idx;
        $whereParams[$wT] = $pattern;
        $whereParams[$wE] = $pattern;
        $whereParams[$wC] = $pattern;
        $whereParts[] = "(title LIKE :{$wT} ESCAPE '\\\\' OR excerpt LIKE :{$wE} ESCAPE '\\\\' OR content LIKE :{$wC} ESCAPE '\\\\')";

        $sT = "st" . $idx;
        $sE = "se" . $idx;
        $sC = "sc" . $idx;
        $scoreParams[$sT] = $pattern;
        $scoreParams[$sE] = $pattern;
        $scoreParams[$sC] = $pattern;
        $scoreParts[] = "(CASE WHEN title   LIKE :{$sT} ESCAPE '\\\\' THEN 10 ELSE 0 END)";
        $scoreParts[] = "(CASE WHEN excerpt LIKE :{$sE} ESCAPE '\\\\' THEN  5 ELSE 0 END)";
        $scoreParts[] = "(CASE WHEN content LIKE :{$sC} ESCAPE '\\\\' THEN  1 ELSE 0 END)";

        $idx++;
    }

    $whereClause = implode(" AND ", $whereParts);
    $scoreExpr = implode(" + ", $scoreParts);

    try {
        $cntSql = "SELECT COUNT(*) FROM articles WHERE is_published = 1 AND ({$whereClause})";
        $cntStmt = $pdo->prepare($cntSql);
        $cntStmt->execute($whereParams);
        $total = (int) $cntStmt->fetchColumn();

        if ($total > 0) {
            $selSql = "SELECT id, title, slug, author, excerpt, published_at,
                              LEFT(content, 3000) AS content_preview,
                              ({$scoreExpr}) AS score
                       FROM articles
                       WHERE is_published = 1
                         AND ({$whereClause})
                       ORDER BY score DESC, published_at DESC
                       LIMIT :lim OFFSET :off";

            $selStmt = $pdo->prepare($selSql);
            foreach ($whereParams as $k => $v) {
                $selStmt->bindValue(":" . $k, $v, PDO::PARAM_STR);
            }
            foreach ($scoreParams as $k => $v) {
                $selStmt->bindValue(":" . $k, $v, PDO::PARAM_STR);
            }
            $selStmt->bindValue(":lim", $perPage, PDO::PARAM_INT);
            $selStmt->bindValue(":off", $offset, PDO::PARAM_INT);
            $selStmt->execute();
            $rows = $selStmt->fetchAll();
            $result = ["items" => $rows, "total" => $total];
        }
    } catch (\PDOException $e) {
        error_log("search_helpers.php LIKE error: " . $e->getMessage());
        $result = ["items" => [], "total" => 0];
    }

    return $result;
}

function buildSearchSnippet(
    string $htmlContent,
    array $tokens,
    int $snippetLen = SEARCH_SNIPPET,
): string {
    $text = html_entity_decode(
        strip_tags($htmlContent),
        ENT_QUOTES | ENT_HTML5,
        "UTF-8",
    );
    $text = preg_replace("/\s+/u", " ", trim($text)) ?? $text;

    if ($text === "") {
        return "";
    }

    $textLower = mb_strtolower($text, "UTF-8");
    $firstPos = mb_strlen($text, "UTF-8");

    foreach ($tokens as $norm => $orig) {
        $pos = mb_stripos($text, $orig, 0, "UTF-8");
        if ($pos !== false && $pos < $firstPos) {
            $firstPos = $pos;
        }
        $pos2 = mb_stripos($textLower, $norm, 0, "UTF-8");
        if ($pos2 !== false && $pos2 < $firstPos) {
            $firstPos = $pos2;
        }
    }

    if ($firstPos >= mb_strlen($text, "UTF-8")) {
        $firstPos = 0;
    }

    $half = (int) ($snippetLen / 2);
    $start = max(0, $firstPos - $half);

    while ($start > 0 && mb_substr($text, $start - 1, 1, "UTF-8") !== " ") {
        $start--;
    }

    $snippet = mb_substr($text, $start, $snippetLen, "UTF-8");
    $prefix = $start > 0 ? "…" : "";
    $suffix = $start + $snippetLen < mb_strlen($text, "UTF-8") ? "…" : "";
    $snippet = $prefix . trim($snippet) . $suffix;

    return highlightSearchTerms(htmlspecialchars($snippet, ENT_QUOTES, 'UTF-8'), $tokens);
}

function highlightSearchTerms(string $text, array $tokens): string
{
    $allTerms = [];
    foreach ($tokens as $norm => $orig) {
        $allTerms[] = $orig;
        if ($norm !== $orig) {
            $allTerms[] = $norm;
        }
    }
    usort(
        $allTerms,
        fn($a, $b) => mb_strlen($b, "UTF-8") - mb_strlen($a, "UTF-8"),
    );

    foreach ($allTerms as $term) {
        if (mb_strlen($term, "UTF-8") < SEARCH_MIN_LEN) {
            continue;
        }
        $escaped = preg_quote($term, "/");
        $text = preg_replace(
            "/(" . $escaped . ")/ui",
            '<mark class="search-hl">$1</mark>',
            $text,
        ) ?? $text;
    }

    return $text;
}

function detectMatchFields(array $row, array $tokens): array
{
    $fields = [];
    foreach ($tokens as $norm => $orig) {
        if (
            !in_array("title", $fields, true) &&
            (mb_stripos((string) ($row["title"] ?? ""), $orig) !== false ||
                mb_stripos((string) ($row["title"] ?? ""), $norm) !== false)
        ) {
            $fields[] = "title";
        }
        if (
            !in_array("excerpt", $fields, true) &&
            (mb_stripos((string) ($row["excerpt"] ?? ""), $orig) !== false ||
                mb_stripos((string) ($row["excerpt"] ?? ""), $norm) !== false)
        ) {
            $fields[] = "excerpt";
        }
        if (
            !in_array("content", $fields, true) &&
            (mb_stripos((string) ($row["content_preview"] ?? ""), $orig) !== false ||
                mb_stripos((string) ($row["content_preview"] ?? ""), $norm) !== false)
        ) {
            $fields[] = "content";
        }
    }
    return $fields;
}
