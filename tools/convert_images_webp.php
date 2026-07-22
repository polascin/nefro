<?php
declare(strict_types=1);
/**
 * tools/convert_images_webp.php
 * ────────────────────────────────────────────────────────────────────────────
 * Konverzia PNG/JPEG → WebP (GD, zachováva priehľadnosť). WebP sa ukladá ako
 * súrodenec vedľa zdroja (foo.png → foo.webp, foo.jpeg → foo.webp). Originál
 * zostáva ako fallback — web ho transparentne nahrádza WebP cez
 * content-negotiation pravidlo v .htaccess.
 *
 * Použitie:
 *   php tools/convert_images_webp.php                 # prejde img/ a skonvertuje neaktuálne
 *   php tools/convert_images_webp.php img/a.png b.jpeg # skonvertuje konkrétne súbory
 *   php tools/convert_images_webp.php --force         # prekonvertuje aj aktuálne
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
// Obrázky, ktoré sa NESMÚ konvertovať na (stratový) WebP — napr. QR kódy,
// kde by kompresné artefakty okolo ostrých hrán zhoršili čitateľnosť. Servíruje
// sa len PNG (.htaccess pri chýbajúcom .webp spadne späť na PNG).
const WEBP_SKIP = ['pay-by-square', 'payme-qr'];
$root = dirname(__DIR__);

// ── Spracuj argumenty ────────────────────────────────────────────────────────
$force = false;
$explicit = [];
$arguments = isset($_SERVER['argv']) && is_array($_SERVER['argv']) ? $_SERVER['argv'] : [];
foreach (array_slice($arguments, 1) as $arg) {
    if ($arg === '--force') { $force = true; continue; }
    if ($arg === '--stage') { continue; } // akceptované kvôli pre-commit hooku (no-op)
    $explicit[] = $arg;
}

// ── Zostav zoznam zdrojov na konverziu (PNG + JPEG) ──────────────────────────
$sources = [];
if ($explicit) {
    foreach ($explicit as $p) {
        $abs = (preg_match('#^(?:[A-Za-z]:|/)#', $p)) ? $p : $root . '/' . $p;
        $ext = strtolower((string) pathinfo($abs, PATHINFO_EXTENSION));
        if (is_file($abs) && in_array($ext, ['png', 'jpg', 'jpeg'], true)) {
            $sources[] = $abs;
        }
    }
} else {
    foreach (glob($root . '/img/*.{png,jpg,jpeg}', GLOB_BRACE) ?: [] as $p) {
        $sources[] = $p;
    }
}

/**
 * Skonvertuje jeden PNG/JPEG na WebP súrodenca. Pri PNG zachová alfa kanál.
 */
function imageToWebp(string $src, string $dst, int $quality): bool
{
    $ext = strtolower((string) pathinfo($src, PATHINFO_EXTENSION));
    $im = match ($ext) {
        'png'         => @imagecreatefrompng($src),
        'jpg', 'jpeg' => @imagecreatefromjpeg($src),
        default       => false,
    };
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

foreach ($sources as $src) {
    $webp = preg_replace('/\.(png|jpe?g)$/i', '.webp', $src);

    // Preskoč obrázky vylúčené z WebP (napr. QR kódy — bezstratovosť)
    if (in_array(strtolower((string) pathinfo($src, PATHINFO_FILENAME)), WEBP_SKIP, true)) {
        $skipped++;
        continue;
    }

    // Preskoč, ak je WebP aktuálny (existuje a nie je starší ako zdroj)
    if (!$force && is_file($webp) && filemtime($webp) >= filemtime($src)) {
        $skipped++;
        continue;
    }

    if (imageToWebp($src, $webp, WEBP_QUALITY)) {
        $converted++;
        $savedBytes += max(0, filesize($src) - filesize($webp));
        $name = basename($webp);
        $pct  = filesize($src) > 0 ? round(100 * (1 - filesize($webp) / filesize($src))) : 0;
        echo "  ✓ {$name}  " . round(filesize($webp) / 1024) . " KB  (-{$pct}%)\n";
    } else {
        $failed[] = $src;
        fwrite(STDERR, "  ✗ ZLYHALO: {$src}\n");
    }
}

echo "──────────────────────────────────────────────────────\n";
echo "Obrázok→WebP: skonvertovaných {$converted}, preskočených (aktuálne) {$skipped}, "
    . "zlyhaní " . count($failed) . ". Ušetrené ~" . round($savedBytes / 1024 / 1024, 1) . " MB.\n";

exit($failed ? 1 : 0);
