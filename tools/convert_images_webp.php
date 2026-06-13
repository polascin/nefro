<?php
declare(strict_types=1);
/**
 * tools/convert_images_webp.php
 * ────────────────────────────────────────────────────────────────────────────
 * Konverzia PNG → WebP (GD, zachováva priehľadnosť). WebP sa ukladá ako súrodenec
 * vedľa PNG (foo.png → foo.webp). PNG zostáva ako fallback — web ho transparentne
 * nahrádza WebP cez content-negotiation pravidlo v .htaccess.
 *
 * Použitie:
 *   php tools/convert_images_webp.php                # prejde img/ a skonvertuje neaktuálne
 *   php tools/convert_images_webp.php img/a.png b.png # skonvertuje konkrétne súbory
 *   php tools/convert_images_webp.php --force        # prekonvertuje aj aktuálne
 *
 * Beží len z CLI. Vracia 0 pri úspechu, 1 ak niektorá konverzia zlyhala.
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Len CLI.\n");
}

ini_set('memory_limit', '512M');

if (!function_exists('imagewebp')) {
    fwrite(STDERR, "CHYBA: PHP GD nemá podporu WebP (imagewebp). Nainštaluj rozšírenie GD s WebP.\n");
    exit(1);
}

const WEBP_QUALITY = 82;
$root = dirname(__DIR__);

// ── Spracuj argumenty ────────────────────────────────────────────────────────
$force = false;
$explicit = [];
foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--force') { $force = true; continue; }
    if ($arg === '--stage') { continue; } // akceptované kvôli pre-commit hooku (no-op)
    $explicit[] = $arg;
}

// ── Zostav zoznam PNG na konverziu ───────────────────────────────────────────
$pngs = [];
if ($explicit) {
    foreach ($explicit as $p) {
        $abs = (preg_match('#^(?:[A-Za-z]:|/)#', $p)) ? $p : $root . '/' . $p;
        if (is_file($abs) && strtolower((string) pathinfo($abs, PATHINFO_EXTENSION)) === 'png') {
            $pngs[] = $abs;
        }
    }
} else {
    foreach (glob($root . '/img/*.png') ?: [] as $p) {
        $pngs[] = $p;
    }
}

/**
 * Skonvertuje jeden PNG na WebP súrodenca. Zachováva alfa kanál.
 */
function pngToWebp(string $src, string $dst, int $quality): bool
{
    $im = @imagecreatefrompng($src);
    if ($im === false) {
        return false;
    }
    imagepalettetotruecolor($im);
    imagealphablending($im, false);
    imagesavealpha($im, true);
    $ok = imagewebp($im, $dst, $quality);
    imagedestroy($im);
    return $ok && is_file($dst) && filesize($dst) > 0;
}

$converted = 0;
$skipped   = 0;
$failed    = [];
$savedBytes = 0;

foreach ($pngs as $png) {
    $webp = preg_replace('/\.png$/i', '.webp', $png);

    // Preskoč, ak je WebP aktuálny (existuje a nie je starší ako PNG)
    if (!$force && is_file($webp) && filemtime($webp) >= filemtime($png)) {
        $skipped++;
        continue;
    }

    if (pngToWebp($png, $webp, WEBP_QUALITY)) {
        $converted++;
        $savedBytes += max(0, filesize($png) - filesize($webp));
        $name = basename($webp);
        $pct  = filesize($png) > 0 ? round(100 * (1 - filesize($webp) / filesize($png))) : 0;
        echo "  ✓ {$name}  " . round(filesize($webp) / 1024) . " KB  (-{$pct}%)\n";
    } else {
        $failed[] = $png;
        fwrite(STDERR, "  ✗ ZLYHALO: {$png}\n");
    }
}

echo "──────────────────────────────────────────────────────\n";
echo "PNG→WebP: skonvertovaných {$converted}, preskočených (aktuálne) {$skipped}, "
    . "zlyhaní " . count($failed) . ". Ušetrené ~" . round($savedBytes / 1024 / 1024, 1) . " MB.\n";

exit($failed ? 1 : 0);
