<?php
declare(strict_types=1);
/**
 * cleanup_inline_table_styles.php
 * Jednorazový cleanup (Beh 41): odstráni inertné inline style="" z tabuliek
 * v obsahu článkov. Pod CSP style-src 'self' sa neaplikujú a .primary-article
 * table/th/td v index.css ich štýluje identicky. Idempotentné — opakované
 * spustenie nič nepokazí.
 *
 * Dotýka sa len 3 presných reťazcov (table/th/td), takže nemôže poškodiť iný obsah.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/cleanup_inline_table_styles.php"
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$needles = [
    ' style="width:100%;border-collapse:collapse;margin:1rem 0;font-size:0.95rem;"',
    ' style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);"',
    ' style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;"',
];

// Vnorené REPLACE() — odstráni všetky tri reťazce v jednom UPDATE.
$expr = 'content';
$params = [];
foreach ($needles as $i => $needle) {
    $expr = "REPLACE($expr, :n$i, '')";
    $params["n$i"] = $needle;
}

$like = '%' . str_replace(['%', '_'], ['\%', '\_'], 'border-bottom:1px solid var(--border-color)') . '%';
$sql = "UPDATE articles SET content = $expr WHERE content LIKE :like";
$stmt = $pdo->prepare($sql);
$stmt->execute($params + ['like' => $like]);
$rows = $stmt->rowCount();

// Overenie: koľko článkov ešte obsahuje inline style v tabuľkách.
$chk = $pdo->query("SELECT COUNT(*) FROM articles WHERE content LIKE '%border-collapse:collapse;margin:1rem 0%' OR content LIKE '%vertical-align:top;\"%'");
$remaining = (int) $chk->fetchColumn();

$msg = "Aktualizovaných článkov: $rows\n"
     . "Zostáva s inline table style: $remaining\n";

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo "Cleanup inline table style v obsahu článkov\n";
    echo "──────────────────────────────────────────────────────\n";
    echo $msg;
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    header('Content-Type: text/plain; charset=utf-8');
    echo $msg;
}
