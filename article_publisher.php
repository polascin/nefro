<?php

declare(strict_types=1);

/**
 * article_publisher.php
 * ────────────────────────────────────────────────────────────────────────────
 * Zdieľaná pomocná funkcia pre publikovanie a regeneráciu článkov z
 * add_*_article.php skriptov (odborné, popularizačné aj cheatsheety).
 */

require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

/**
 * Vloží alebo aktualizuje pole článkov, pri nových článkoch zaradí avízo do
 * fronty a regeneruje PDF. Vráti štatistiky.
 *
 * @param PDO    $pdo       Aktívne PDO pripojenie.
 * @param array  $articles  Pole asociatívnych polí článkov (title, slug, author,
 *                          content, excerpt, published_at, is_top, is_published?).
 * @param string $category  Hodnota stĺpca category ('odborne', 'popularne', 'cheatsheet').
 * @param array  $options   'enqueue_newsletter' => bool (predvol true),
 *                          'regenerate_pdf'     => bool (predvol true),
 *                          'log_prefix'         => string (predvol 'article_publisher').
 * @return array{inserted:int, updated:int, skipped:int, queued:int, errors:array<string>}
 */
function upsertArticles(
    PDO $pdo,
    array $articles,
    string $category,
    array $options = [],
): array {
    $enqueueNewsletter = (bool) ($options['enqueue_newsletter'] ?? true);
    $regeneratePdf = (bool) ($options['regenerate_pdf'] ?? true);
    $logPrefix = (string) ($options['log_prefix'] ?? 'article_publisher');

    $inserted = 0;
    $updated = 0;
    $skipped = 0;
    $queued = 0;
    $errors = [];

    $stmt = $pdo->prepare(
        "INSERT INTO articles
         (title, slug, author, content, excerpt, category, published_at, is_top, is_published)
         VALUES
         (:title, :slug, :author, :content, :excerpt, :category, :published_at, :is_top, :is_published)
         ON DUPLICATE KEY UPDATE
            title = VALUES(title),
            author = VALUES(author),
            content = VALUES(content),
            excerpt = VALUES(excerpt),
            category = VALUES(category),
            is_top = VALUES(is_top)"
    );

    foreach ($articles as $a) {
        try {
            $stmt->execute([
                'title' => (string) ($a['title'] ?? ''),
                'slug' => (string) ($a['slug'] ?? ''),
                'author' => (string) ($a['author'] ?? ''),
                'content' => (string) ($a['content'] ?? ''),
                'excerpt' => (string) ($a['excerpt'] ?? ''),
                'category' => $category,
                'published_at' => (string) ($a['published_at'] ?? date('Y-m-d H:i:s')),
                'is_top' => (int) ($a['is_top'] ?? 0),
                'is_published' => (int) ($a['is_published'] ?? 1),
            ]);

            // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
            $rc = $stmt->rowCount();
            if ($rc === 0) {
                $skipped++;
                continue;
            }

            $articleId = (int) $pdo->lastInsertId();
            if ($articleId === 0) {
                $idStmt = $pdo->prepare('SELECT id FROM articles WHERE slug = :slug');
                $idStmt->execute(['slug' => (string) ($a['slug'] ?? '')]);
                $articleId = (int) $idStmt->fetchColumn();
            }

            if ($rc === 1) {
                $inserted++;
                if ($enqueueNewsletter && ((int) ($a['is_published'] ?? 1)) === 1 && $articleId > 0) {
                    try {
                        $queued += enqueueArticleNewsletterEmails($pdo, $articleId);
                    } catch (\Throwable $qe) {
                        error_log($logPrefix . ' newsletter enqueue error: ' . $qe->getMessage());
                    }
                }
            } else {
                $updated++;
            }

            if ($regeneratePdf && $articleId > 0) {
                try {
                    $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
                    if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                        error_log($logPrefix . ' pdf gen: ' . $pdfRes['error']);
                    }
                } catch (\Throwable $pe) {
                    error_log($logPrefix . ' pdf gen error: ' . $pe->getMessage());
                }
            }
        } catch (\PDOException $e) {
            $errors[] = 'Chyba pri článku „' . htmlspecialchars((string) ($a['title'] ?? '')) . '“: ' . $e->getMessage();
            error_log($logPrefix . ' migration error: ' . $e->getMessage());
        }
    }

    return [
        'inserted' => $inserted,
        'updated' => $updated,
        'skipped' => $skipped,
        'queued' => $queued,
        'errors' => $errors,
    ];
}
