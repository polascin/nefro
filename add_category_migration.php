<?php
declare(strict_types=1);
/**
 * add_category_migration.php
 * ────────────────────────────────────────────────────────────────────────────
 * Idempotentná migrácia: pridá stĺpec `category` do tabuľky `articles`.
 *   • 'odborne'   – odborný článok (predvolené; všetky existujúce ostanú odborné)
 *   • 'popularne' – popularizačný článok pre poučených pacientov a verejnosť
 *
 * Spustenie cez SSH na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_category_migration.php"
 * ────────────────────────────────────────────────────────────────────────────
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

$steps = [];

// Pridaj stĺpec, ak chýba
$colStmt = $pdo->query("SHOW COLUMNS FROM articles LIKE 'category'");
if (!$colStmt->fetch()) {
    $pdo->exec("ALTER TABLE articles
        ADD COLUMN category VARCHAR(32) NOT NULL DEFAULT 'odborne'
        COMMENT 'odborne = odborný článok, popularne = popularizačný (pre pacientov/verejnosť)'
        AFTER excerpt");
    $steps[] = "articles.category: stĺpec pridaný";
} else {
    $steps[] = "articles.category: už existuje";
}

// Pridaj index, ak chýba
$idxStmt = $pdo->query("SHOW INDEX FROM articles WHERE Key_name = 'idx_articles_category'");
if (!$idxStmt->fetch()) {
    $pdo->exec("ALTER TABLE articles ADD INDEX idx_articles_category (category)");
    $steps[] = "idx_articles_category: index pridaný";
} else {
    $steps[] = "idx_articles_category: už existuje";
}

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo "Migrácia: articles.category\n";
    echo "──────────────────────────────────────────────────────\n";
    foreach ($steps as $s) {
        echo "  • $s\n";
    }
    echo "Hotovo.\n";
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Migrácia articles.category dokončená:\n";
    foreach ($steps as $s) {
        echo "  • $s\n";
    }
}
