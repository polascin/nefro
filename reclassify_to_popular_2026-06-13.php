<?php
declare(strict_types=1);
/**
 * reclassify_to_popular_2026-06-13.php
 * ────────────────────────────────────────────────────────────────────────────
 * Jednorazová zmena kategórie vybraných článkov na 'popularne'
 * (presun do sekcie „Pre pacientov"). Idempotentné — opätovné spustenie nič nepokazí.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/reclassify_to_popular_2026-06-13.php"
 * ────────────────────────────────────────────────────────────────────────────
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

$slugs = [
    'kolko-vetrov-denne-je-este-normalne',
    'zelenina-pre-lepsie-zdravie-obliciek-ckd-5-druhov-dietologovia',
    'chronicka-choroba-obliciek-podla-kdigo-2024-co-moze-pacient-urobit-pre-svoje-oblicky',
];

$isCli = php_sapi_name() === 'cli';
if (!$isCli) {
    header('Content-Type: text/plain; charset=utf-8');
}

$sel = $pdo->prepare("SELECT id, category FROM articles WHERE slug = :slug LIMIT 1");
$upd = $pdo->prepare("UPDATE articles SET category = 'popularne' WHERE slug = :slug");

$changed = 0;
$already = 0;
$missing = 0;

foreach ($slugs as $slug) {
    $sel->execute(['slug' => $slug]);
    $row = $sel->fetch();
    if (!$row) {
        $missing++;
        echo "CHÝBA   : $slug (článok sa nenašiel)\n";
        continue;
    }
    if (($row['category'] ?? '') === 'popularne') {
        $already++;
        echo "UŽ JE   : $slug (už 'popularne')\n";
        continue;
    }
    $upd->execute(['slug' => $slug]);
    $changed++;
    echo "ZMENENÉ : $slug ('" . ($row['category'] ?? '?') . "' → 'popularne')\n";
}

echo "──────────────────────────────────────────────────────\n";
echo "Zmenené: $changed | Už populárne: $already | Nenájdené: $missing\n";
