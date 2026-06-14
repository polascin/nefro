<?php
declare(strict_types=1);
/**
 * add_article_pdf_migration.php
 * ────────────────────────────────────────────────────────────────────────────
 * Idempotentná migrácia: pridá stĺpec `pdf_file` do tabuľky `articles` a priradí
 * dostupné PDF verzie k príslušným článkom. PDF je bonus na stiahnutie pre
 * registrovaných a prihlásených používateľov (servíruje download_pdf.php).
 *
 * Spustenie cez SSH na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_article_pdf_migration.php"
 * ────────────────────────────────────────────────────────────────────────────
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$steps = [];

// 1) Stĺpec pdf_file (názov súboru v priečinku /pdf), ak chýba
$colStmt = $pdo->query("SHOW COLUMNS FROM articles LIKE 'pdf_file'");
if (!$colStmt->fetch()) {
    $pdo->exec("ALTER TABLE articles
        ADD COLUMN pdf_file VARCHAR(255) NULL DEFAULT NULL
        COMMENT 'názov PDF v /pdf – bonus na stiahnutie pre prihlásených'
        AFTER content");
    $steps[] = "articles.pdf_file: stĺpec pridaný";
} else {
    $steps[] = "articles.pdf_file: už existuje";
}

// 2) Priradenie dostupných PDF k článkom (podľa slugu)
// Pozn.: názvy súborov na disku sú ASCII (bez diakritiky/medzier) — diakritika
// v názve rozbíja SFTP deploy (git escapuje cestu). Čitateľný názov pri sťahovaní
// generuje download_pdf.php z titulu článku.
$map = [
    'diabeticka-choroba-obliciek-bez-zahad' => 'diabeticka-choroba-obliciek-bez-zahad.pdf',
    'moderne-trendy-v-nefroprotekcii'       => 'moderne-trendy-v-nefroprotekcii.pdf',
];

$upd = $pdo->prepare("UPDATE articles SET pdf_file = :pdf WHERE slug = :slug");
foreach ($map as $slug => $pdf) {
    $upd->execute(['pdf' => $pdf, 'slug' => $slug]);
    $steps[] = "  ↳ $slug ← " . ($upd->rowCount() > 0 ? "PDF priradené" : "bez zmeny (slug nenájdený alebo už nastavené)");
}

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo "Migrácia: articles.pdf_file\n";
    echo "──────────────────────────────────────────────────────\n";
    foreach ($steps as $s) {
        echo "  • $s\n";
    }
    echo "Hotovo.\n";
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Migrácia articles.pdf_file dokončená:\n";
    foreach ($steps as $s) {
        echo "  • $s\n";
    }
}
