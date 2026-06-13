<?php
declare(strict_types=1);
/**
 * smoke_seed_pdf.php — pomocník pre smoke_test.ps1 (PDF download flow).
 * ────────────────────────────────────────────────────────────────────────────
 * Vytvorí (alebo zmaže) deterministický testovací článok s priradeným PDF,
 * aby sa dal automaticky overiť bonus „stiahnutie PDF pre prihlásených".
 *
 * Beží IBA z CLI a IBA v lokálnom/dev prostredí (isAppLocalDev) — nikdy nesmie
 * zasiahnuť produkčnú databázu.
 *
 * Použitie:
 *   php smoke_seed_pdf.php seed       # založí/aktualizuje fixture
 *   php smoke_seed_pdf.php cleanup    # zmaže fixture
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Len CLI.\n");
}

require_once __DIR__ . '/db_config.php'; // poskytuje $pdo aj config_loader

if (!function_exists('isAppLocalDev') || !isAppLocalDev()) {
    fwrite(STDERR, "ODMIETNUTÉ: smoke_seed_pdf.php beží len v lokálnom/dev prostredí (APP_ENV=local / APP_LOCAL_DEV=1).\n");
    exit(2);
}

$mode = strtolower(trim((string) ($argv[1] ?? 'seed')));

const SMOKE_SLUG = 'smoke-test-pdf';
// Existujúce PDF v repozitári (commitnuté) — fixture naň iba odkazuje.
const SMOKE_PDF  = 'diabeticka-choroba-obliciek-bez-zahad.pdf';

// Uisti sa, že stĺpec pdf_file existuje (mimo poradia migrácií, idempotentne).
$hasCol = $pdo->query("SHOW COLUMNS FROM articles LIKE 'pdf_file'")->fetch();
if (!$hasCol) {
    $pdo->exec("ALTER TABLE articles
        ADD COLUMN pdf_file VARCHAR(255) NULL DEFAULT NULL
        COMMENT 'názov PDF v /pdf – bonus na stiahnutie pre prihlásených'
        AFTER content");
}

if ($mode === 'cleanup') {
    $stmt = $pdo->prepare("DELETE FROM articles WHERE slug = :slug");
    $stmt->execute(['slug' => SMOKE_SLUG]);
    echo "CLEANUP_OK removed={$stmt->rowCount()}\n";
    exit(0);
}

// seed (default) — INSERT alebo UPDATE fixture článku so zverejneným stavom a PDF
$sql = "INSERT INTO articles (title, slug, author, content, excerpt, category, published_at, is_top, is_published, pdf_file)
        VALUES (:title, :slug, :author, :content, :excerpt, 'odborne', NOW(), 0, 1, :pdf)
        ON DUPLICATE KEY UPDATE
            is_published = 1,
            pdf_file     = VALUES(pdf_file),
            content      = VALUES(content)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'title'   => 'Smoke test PDF',
    'slug'    => SMOKE_SLUG,
    'author'  => 'Smoke Test',
    'content' => '<p>Fixture pre automatický smoke-test sťahovania PDF.</p>',
    'excerpt' => 'Fixture pre smoke-test (PDF download).',
    'pdf'     => SMOKE_PDF,
]);

$pdfPath = __DIR__ . '/pdf/' . SMOKE_PDF;
$pdfOk = is_file($pdfPath) ? 'present' : 'MISSING';
echo "SEED_OK slug=" . SMOKE_SLUG . " pdf=" . SMOKE_PDF . " file={$pdfOk}\n";
