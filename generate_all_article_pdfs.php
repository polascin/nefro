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
$stale = false;
foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--force') { $force = true; }
    elseif ($arg === '--stale') { $stale = true; }
    elseif (str_starts_with($arg, '--slug=')) { $onlySlug = substr($arg, 7); }
    elseif (str_starts_with($arg, '--limit=')) { $limit = max(0, (int) substr($arg, 8)); }
}

if (!articlePdfAvailable()) {
    fwrite(STDERR, "CHYBA: wkhtmltopdf nie je dostupné — PDF sa nedajú vygenerovať.\n");
    exit(1);
}

$pdfDir = __DIR__ . '/pdf';

/**
 * Treba (pre)generovať PDF pre tento článok?
 *   --force  → vždy
 *   --stale  → ak PDF chýba (priradenie/súbor) ALEBO je obsah novší (updated_at > mtime PDF)
 *   inak     → len ak PDF úplne chýba
 */
function articleNeedsPdf(array $a, bool $force, bool $stale, string $pdfDir): bool
{
    // Chránené (ručne pripravené) PDF bulk nikdy automaticky neprepisuje.
    if (articlePdfIsProtected((string) ($a['slug'] ?? ''))) { return false; }
    if ($force) { return true; }
    $pf = (string) ($a['pdf_file'] ?? '');
    if ($pf === '') { return true; }
    $path = $pdfDir . '/' . basename($pf);
    if (!is_file($path)) { return true; }
    if ($stale) {
        // Porovnanie v epoch sekundách z DB hodín (UNIX_TIMESTAMP) — bez TZ posunu.
        $updatedTs = (int) ($a['updated_ts'] ?? 0);
        if ($updatedTs > filemtime($path)) { return true; }
    }
    return false;
}

// ── Výber článkov ────────────────────────────────────────────────────────────
if ($onlySlug !== null) {
    $stmt = $pdo->prepare("SELECT id, slug, title, author, content, published_at, pdf_file,
                                  UNIX_TIMESTAMP(updated_at) AS updated_ts
                           FROM articles WHERE slug = :slug LIMIT 1");
    $stmt->execute(['slug' => $onlySlug]);
} else {
    $stmt = $pdo->query("SELECT id, slug, title, author, content, published_at, pdf_file,
                                UNIX_TIMESTAMP(updated_at) AS updated_ts
                         FROM articles WHERE is_published = 1 ORDER BY id");
}
$rows = $stmt->fetchAll();

$ok = 0; $fail = 0; $skipped = 0; $errors = [];
$count = 0;

echo "\n──────────────────────────────────────────────────────\n";
echo "Generovanie PDF verzií článkov\n";
echo "──────────────────────────────────────────────────────\n";

foreach ($rows as $a) {
    if ($limit > 0 && $count >= $limit) { break; }
    // Pri --slug generuj vždy; inak rozhodne articleNeedsPdf (force / stale / chýbajúce).
    if ($onlySlug === null && !articleNeedsPdf($a, $force, $stale, $pdfDir)) { $skipped++; continue; }
    $count++;

    $res = generateArticlePdf($pdo, $a, true);
    if (!empty($res['skipped'])) {
        $skipped++;
        echo "  • {$a['slug']}: chránené (ručné PDF) — preskočené\n";
        continue;
    }
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
