<?php

declare(strict_types=1);
/**
 * update_nefroprot_webp.php
 * Jednorazová aktualizácia: v už vloženom článku „moderne-trendy-v-nefroprotekcii"
 * prepíše odkazy na ilustrácie z .png na .webp (obrázky boli prekonvertované).
 * Idempotentné — opakované spustenie nič nepokazí.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/update_nefroprot_webp.php"
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$slug = 'moderne-trendy-v-nefroprotekcii';

// V obsahu tohto článku sa .png vyskytuje výhradne pri ilustráciách nefroprot-*,
// takže jednoduchý a bezpečný REPLACE '.png' → '.webp' stačí.
$stmt = $pdo->prepare(
    "UPDATE articles
        SET content = REPLACE(content, '.png', '.webp')
      WHERE slug = :slug AND content LIKE '%nefroprot-%.png%'"
);
$stmt->execute(['slug' => $slug]);
$rows = $stmt->rowCount();

// Overenie
$chk = $pdo->prepare("SELECT
        (LENGTH(content) - LENGTH(REPLACE(content, '.webp', ''))) / LENGTH('.webp') AS webp_cnt,
        (LENGTH(content) - LENGTH(REPLACE(content, 'nefroprot-', ''))) / LENGTH('nefroprot-') AS ref_cnt
    FROM articles WHERE slug = :slug");
$chk->execute(['slug' => $slug]);
$info = $chk->fetch();

$msg = "Aktualizovaných riadkov: $rows\n"
     . "Počet .webp výskytov v obsahu: " . (int) ($info['webp_cnt'] ?? 0) . "\n"
     . "Počet odkazov nefroprot-*: " . (int) ($info['ref_cnt'] ?? 0) . "\n";

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo "Migrácia obrázkov na WebP: $slug\n";
    echo "──────────────────────────────────────────────────────\n";
    echo $msg;
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    header('Content-Type: text/plain; charset=utf-8');
    echo $msg;
}
