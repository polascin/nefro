<?php

declare(strict_types=1);

/**
 * Vymaže existujúci článok podľa slugu, aby ho bolo možné znovu vložiť/regenerovať.
 * Použitie:
 *   CLI:  php refresh_article.php <slug>
 *   Web:  refresh_article.php?slug=<slug>  (iba admin)
 */

$isCli = php_sapi_name() === 'cli';

if ($isCli) {
    $slug = $argv[1] ?? '';
} else {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    $slug = trim((string) ($_GET['slug'] ?? $_POST['slug'] ?? ''));
}

if (!is_string($slug) || !preg_match('/^[a-z0-9-]{1,120}$/', $slug)) {
    $message = $isCli
        ? "Použitie: php refresh_article.php <slug>\n"
        : 'Neplatný slug.';
    if (!$isCli) {
        http_response_code(400);
        header('Content-Type: text/plain; charset=utf-8');
    }
    exit($message);
}

require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

try {
    $stmt = $pdo->prepare('DELETE FROM articles WHERE slug = :slug');
    $stmt->execute(['slug' => $slug]);
    $deleted = $stmt->rowCount();

    if (!$isCli && isLoggedIn()) {
        logAdminAction($pdo, 'refresh_article', 'article_slug', null, ['slug' => $slug, 'deleted_rows' => $deleted]);
    }

    if ($isCli) {
        echo "✓ Článok so slug '$slug' vymazaný (riadkov: {$deleted})\n";
    } else {
        header('Content-Type: text/plain; charset=utf-8');
        echo "✓ Článok so slug '$slug' vymazaný.";
    }
} catch (\PDOException $e) {
    error_log('refresh_article error: ' . $e->getMessage());
    if ($isCli) {
        fwrite(STDERR, "Chyba pri mazaní článku: " . $e->getMessage() . "\n");
        exit(1);
    }
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    exit('Chyba pri mazaní článku.');
}
