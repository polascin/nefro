<?php

declare(strict_types=1);

/**
 * Vymaže existujúci článok podľa slugu, aby ho bolo možné znovu vložiť/regenerovať.
 * Použitie:
 *   CLI:  php refresh_article.php <slug>
 *   Web:  refresh_article.php?slug=<slug>  (iba admin, POST + CSRF)
 */

$isCli = php_sapi_name() === 'cli';
$slug = '';

if ($isCli) {
    $slug = $argv[1] ?? '';
} else {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminReauth();
}

require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

if (!$isCli) {
    $requestMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
    if ($requestMethod === 'GET') {
        $slug = trim((string) ($_GET['slug'] ?? ''));
        if (!preg_match('/^[a-z0-9-]{1,120}$/', $slug)) {
            http_response_code(400);
            header('Content-Type: text/plain; charset=utf-8');
            exit('Neplatný slug.');
        }

        $safeSlug = htmlspecialchars($slug, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $safeTitle = 'Zmazať článok pre regeneráciu';
        $csrfToken = htmlspecialchars(generateCsrfToken(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $cssVersion = is_file(__DIR__ . '/index.css') ? (string) filemtime(__DIR__ . '/index.css') : '1';
        $preferencesVersion = is_file(__DIR__ . '/ui-preferences.js') ? (string) filemtime(__DIR__ . '/ui-preferences.js') : '1';
        $preferencesFallbackVersion = is_file(__DIR__ . '/ui-preferences-fallback.js') ? (string) filemtime(__DIR__ . '/ui-preferences-fallback.js') : '1';
        $themeVersion = is_file(__DIR__ . '/theme.js') ? (string) filemtime(__DIR__ . '/theme.js') : '1';

        echo '<!DOCTYPE html><html lang="sk"><head><meta charset="UTF-8">'
            . '<meta name="viewport" content="width=device-width, initial-scale=1.0">'
            . '<meta name="robots" content="noindex, nofollow">'
            . '<title>' . $safeTitle . '</title>'
            . '<link rel="stylesheet" href="index.css?v=' . rawurlencode($cssVersion) . '">'
            . '<script src="ui-preferences.js?v=' . rawurlencode($preferencesVersion) . '"></script>'
            . '<script src="theme.js?v=' . rawurlencode($themeVersion) . '"></script>'
            . '<script src="ui-preferences-fallback.js?v=' . rawurlencode($preferencesFallbackVersion) . '" defer></script>'
            . '</head><body><a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>'
            . '<main id="main-content" class="container" role="main">'
            . '<div class="auth-container"><h1>' . $safeTitle . '</h1>'
            . '<div class="alert alert-error"><p>Naozaj chcete zmazať článok <code>' . $safeSlug . '</code>, aby ste ho mohli znovu vložiť/regenerovať?</p></div>'
            . '<form method="POST" action="refresh_article.php"><input type="hidden" name="csrf_token" value="' . $csrfToken . '"><input type="hidden" name="slug" value="' . $safeSlug . '">'
            . '<div class="form-actions"><button type="submit" class="btn-danger">Potvrdiť zmazanie</button>'
            . '<a href="admin_articles.php" class="btn-secondary">Zrušiť</a></div></form>'
            . '</div></main></body></html>';
        exit;
    }

    if ($requestMethod !== 'POST') {
        http_response_code(405);
        header('Allow: GET, POST');
        exit;
    }

    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=utf-8');
        exit('Neplatný CSRF token.');
    }

    $slug = trim((string) ($_POST['slug'] ?? ''));
}

if (!preg_match('/^[a-z0-9-]{1,120}$/', $slug)) {
    $message = $isCli
        ? "Použitie: php refresh_article.php <slug>\n"
        : 'Neplatný slug.';
    if (!$isCli) {
        http_response_code(400);
        header('Content-Type: text/plain; charset=utf-8');
    }
    exit($message);
}

try {
    $metaStmt = $pdo->prepare('SELECT id, pdf_file FROM articles WHERE slug = :slug LIMIT 1');
    $metaStmt->execute(['slug' => $slug]);
    $articleMeta = $metaStmt->fetch();

    if ($articleMeta) {
        $articleId = (int) $articleMeta['id'];
        $pdfFile = (string) ($articleMeta['pdf_file'] ?? '');

        $pdo->prepare(
            "UPDATE article_newsletter_queue
             SET status = 'cancelled', last_error = 'Článok bol zmazaný (refresh_article).'
             WHERE article_id = :article_id AND status = 'pending'"
        )->execute(['article_id' => $articleId]);

        if ($pdfFile !== '') {
            $pdfPath = __DIR__ . '/pdf/' . basename($pdfFile);
            if (is_file($pdfPath)) {
                @unlink($pdfPath);
            }
        }
    }

    $stmt = $pdo->prepare('DELETE FROM articles WHERE slug = :slug');
    $stmt->execute(['slug' => $slug]);
    $deleted = $stmt->rowCount();

    if (!$isCli && isLoggedIn()) {
        logAdminAction($pdo, 'refresh_article', 'article_slug', $articleMeta ? (int) $articleMeta['id'] : null, ['slug' => $slug, 'deleted_rows' => $deleted]);
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
