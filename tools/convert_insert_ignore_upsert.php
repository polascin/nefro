<?php

declare(strict_types=1);

/**
 * One-shot konverzia starých add_*_article.php skriptov z INSERT IGNORE
 * na UPSERT (INSERT ... ON DUPLICATE KEY UPDATE) so správnym spracovaním
 * rowCount a vyhľadania existujúceho id pri UPDATE.
 *
 * Spustenie:
 *   php tools/convert_insert_ignore_upsert.php
 */

$root = __DIR__ . '/..';
$files = glob($root . '/add_*_article.php');
if ($files === false) {
    fwrite(STDERR, "Nenašli sa žiadne súbory\n");
    exit(1);
}

$categoryPattern = '/INSERT IGNORE INTO articles \(title, slug, author, content, excerpt, category, published_at, is_top, is_published\)\s+VALUES \(:title, :slug, :author, :content, :excerpt, \'popularne\', :published_at, :is_top, 1\)/s';
$categoryReplacement = <<<'SQL'
INSERT INTO articles (title, slug, author, content, excerpt, category, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, 'popularne', :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author), content = VALUES(content),
        excerpt = VALUES(excerpt), category = VALUES(category), is_top = VALUES(is_top),
        is_published = VALUES(is_published), updated_at = NOW()
SQL;

$noCategoryPattern = '/INSERT IGNORE INTO articles \(title, slug, author, content, excerpt, published_at, is_top, is_published\)\s+VALUES \(:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1\)/s';
$noCategoryReplacement = <<<'SQL'
INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author), content = VALUES(content),
        excerpt = VALUES(excerpt), is_top = VALUES(is_top), is_published = VALUES(is_published),
        updated_at = NOW()
SQL;

$pdfBlockTemplate = <<<'PHP'

            // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
            // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
            try {
                $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
                if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                    error_log('add_article pdf gen: ' . $pdfRes['error']);
                }
            } catch (\Throwable $pe) {
                error_log('add_article pdf gen error: ' . $pe->getMessage());
            }
PHP;

$newBlockTemplate = <<<'PHP'
foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        // Newsletter avízo LEN pri prvom vložení, nikdy pri regenerácii/update.
        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        }
%s
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}
PHP;

foreach ($files as $f) {
    $text = file_get_contents($f);

    // Preskoč šablóny a už prevedené súbory
    if (str_contains(basename($f), 'TEMPLATE') || str_contains($text, 'ON DUPLICATE KEY UPDATE')) {
        continue;
    }
    if (strpos($text, 'INSERT IGNORE INTO articles') === false) {
        continue;
    }

    $hasPdf = strpos($text, 'generateArticlePdf') !== false;

    // Nahraď SQL
    if (preg_match($categoryPattern, $text) === 1) {
        $text = preg_replace($categoryPattern, $categoryReplacement, $text, 1);
    } elseif (preg_match($noCategoryPattern, $text) === 1) {
        $text = preg_replace($noCategoryPattern, $noCategoryReplacement, $text, 1);
    } else {
        fwrite(STDERR, 'Neznáma INSERT syntax v ' . basename($f) . "\n");
        continue;
    }

    // Nájdi foreach block
    if (preg_match('/foreach\s*\(\$articles\s+as\s+\$a\)\s*\{/s', $text, $m, PREG_OFFSET_CAPTURE) !== 1) {
        fwrite(STDERR, 'foreach block not found in ' . basename($f) . "\n");
        continue;
    }
    $start = $m[0][1];
    $depth = 1;
    $i = $start + strlen($m[0][0]);
    $len = strlen($text);
    while ($i < $len && $depth > 0) {
        if ($text[$i] === '{') {
            $depth++;
        } elseif ($text[$i] === '}') {
            $depth--;
        }
        $i++;
    }

    $pdfBlock = $hasPdf ? $pdfBlockTemplate : '';
    $newBlock = sprintf($newBlockTemplate, $pdfBlock);

    $text = substr($text, 0, $start) . $newBlock . substr($text, $i);

    file_put_contents($f, $text);
    echo 'Converted: ' . basename($f) . ($hasPdf ? ' (with PDF)' : '') . PHP_EOL;
}

echo 'Konverzia dokončená.' . PHP_EOL;
