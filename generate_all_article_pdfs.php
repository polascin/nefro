<?php
declare(strict_types=1);
/**
 * generate_all_article_pdfs.php
 * ────────────────────────────────────────────────────────────────────────────
 * Hromadné vytvorenie PDF verzií článkov (wkhtmltopdf) a priradenie k článkom
 * (articles.pdf_file) ako bonus na stiahnutie pre prihlásených používateľov.
 *
 * Predvolene spracuje len ZVEREJNENÉ články BEZ priradeného PDF — existujúce
 * (vrátane ručne pripravených) sa neprepisujú.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *     "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/generate_all_article_pdfs.php"
 *
 * Voľby:
 *   --slug=<slug>   spracuj len jeden článok (aj keď už PDF má)
 *   --limit=N       spracuj najviac N článkov (test)
 *   --force         prepíš PDF aj tam, kde už pdf_file existuje
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Parsovanie volieb ────────────────────────────────────────────────────────
$onlySlug = null;
$limit = 0;
$force = false;
foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--force') { $force = true; }
    elseif (str_starts_with($arg, '--slug=')) { $onlySlug = substr($arg, 7); }
    elseif (str_starts_with($arg, '--limit=')) { $limit = max(0, (int) substr($arg, 8)); }
}

if (!articlePdfAvailable()) {
    fwrite(STDERR, "CHYBA: wkhtmltopdf nie je dostupné — PDF sa nedajú vygenerovať.\n");
    exit(1);
}

// ── Výber článkov ────────────────────────────────────────────────────────────
if ($onlySlug !== null) {
    $stmt = $pdo->prepare("SELECT id, slug, title, author, content, published_at, pdf_file
                           FROM articles WHERE slug = :slug LIMIT 1");
    $stmt->execute(['slug' => $onlySlug]);
} else {
    $where = "is_published = 1";
    if (!$force) {
        $where .= " AND (pdf_file IS NULL OR pdf_file = '')";
    }
    $stmt = $pdo->query("SELECT id, slug, title, author, content, published_at, pdf_file
                         FROM articles WHERE $where ORDER BY id");
}
$rows = $stmt->fetchAll();

$ok = 0; $fail = 0; $skipped = 0; $errors = [];
$count = 0;

echo "\n──────────────────────────────────────────────────────\n";
echo "Generovanie PDF verzií článkov\n";
echo "──────────────────────────────────────────────────────\n";

foreach ($rows as $a) {
    if ($limit > 0 && $count >= $limit) { break; }
    // Pri hromadnom behu bez --force preskoč články, ktoré už PDF majú.
    if ($onlySlug === null && !$force && !empty($a['pdf_file'])) { $skipped++; continue; }
    $count++;

    $res = generateArticlePdf($pdo, $a, true);
    if ($res['ok']) {
        $ok++;
        $kb = round(filesize(__DIR__ . '/pdf/' . $res['file']) / 1024);
        echo "  ✓ {$res['file']}  ({$kb} KB)" . ($res['error'] ? "  ⚠ {$res['error']}" : '') . "\n";
    } else {
        $fail++;
        $errors[] = "{$a['slug']}: {$res['error']}";
        fwrite(STDERR, "  ✗ {$a['slug']}: {$res['error']}\n");
    }
}

echo "──────────────────────────────────────────────────────\n";
echo "Hotovo: vytvorených {$ok}, zlyhaní {$fail}, preskočených (už majú PDF) {$skipped}.\n";
if ($errors) {
    echo "\nChyby:\n";
    foreach ($errors as $e) { echo "  - $e\n"; }
}
echo "──────────────────────────────────────────────────────\n\n";

exit($fail > 0 ? 1 : 0);
