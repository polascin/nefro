<?php
declare(strict_types=1);
/**
 * tools/watermark_images.php
 * ────────────────────────────────────────────────────────────────────────────
 * Pridá decentný textový vodoznak so značkou ("© nefro.polascin.net") do
 * obsahových obrázkov v img/. Vodoznak sa zapeká priamo do PNG/JPEG (to, čo
 * návštevník stiahne, nesie značku). PNG zachováva priehľadnosť.
 *
 * Vodoznak je IDEMPOTENTNÝ cez manifest (tools/.watermark-manifest.json):
 * skript si pamätá sha256 už ovodoznakovaného súboru a pri ďalšom behu ho
 * preskočí. Nový/zmenený obrázok (čerstvý export bez vodoznaku) sa ovodoznakuje.
 *
 * Vylúčené sú značkové a UI assety (logá, OG obrázok, avatary, portrét autora) —
 * pozri DENY_PATTERNS nižšie. uploads/ (používateľský obsah) sa nedotýkame vôbec.
 *
 * Použitie:
 *   php tools/watermark_images.php                 # prejde img/, ovodoznakuje neaktuálne
 *   php tools/watermark_images.php img/nefro_1.png # konkrétne súbory
 *   php tools/watermark_images.php --out-dir=tmp/wm # PREVIEW: zapíše kópie inam, originály ani manifest sa nemenia
 *   php tools/watermark_images.php --force          # POZOR: ignoruje manifest → môže zdvojiť vodoznak (len z pristine originálov!)
 *
 * Beží len z CLI. Vracia 0 pri úspechu, 1 ak niektoré spracovanie zlyhalo.
 * Po behu v img/ regeneruj WebP súrodencov: php tools/convert_images_webp.php
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Len CLI.\n");
}

ini_set('memory_limit', '512M');

if (!function_exists('imagettftext')) {
    fwrite(STDERR, "CHYBA: PHP GD nemá FreeType (imagettftext). Nainštaluj GD s FreeType.\n");
    exit(1);
}

// ── Konfigurácia vodoznaku ───────────────────────────────────────────────────
const WM_TEXT        = '© nefro.polascin.net'; // text vodoznaku (značka = doména)
const WM_REL_SIZE    = 0.020;  // výška písma ako podiel šírky obrázka
const WM_MIN_SIZE    = 11;     // min. veľkosť písma (px)
const WM_MAX_SIZE    = 30;     // max. veľkosť písma (px)
const WM_MARGIN_REL  = 0.022;  // odsadenie od okraja ako podiel šírky
const WM_TEXT_ALPHA  = 62;     // priehľadnosť textu (0=plný, 127=neviditeľný) → ~51 % krytie
const WM_SHADOW_ALPHA = 95;    // priehľadnosť tieňa pod textom
const WM_MIN_DIM     = 320;    // menšie obrázky (kratšia strana) sa preskočia
const JPEG_QUALITY   = 90;
const MANIFEST_REL   = 'tools/.watermark-manifest.json';

// Značkové/UI assety, ktoré sa NEvodoznakujú (regex na basename, bez prípony).
const DENY_PATTERNS = [
    '/^nps(-.*)?$/i',                // nps.png, nps-logo, nps-abstract
    '/^nefro\.polascin\.net\.\d+$/i', // brandové screenshoty
    '/^lubomir-polascin$/i',         // portrét autora
    '/^og-default$/i',               // Open Graph obrázok (hotlinkujú ho sociálne siete)
    '/^default-avatar-/i',           // default avatary
    '/^favicon/i',                   // favicony
    '/^apple-touch-icon/i',
    '/^TikTok /i',                   // sociálne cover obrázky (značkové)
    '/^pay-by-square$/i',            // platobný QR — vodoznak by znehodnotil čitateľnosť
    '/^payme-qr$/i',                 // payme.sk QR — to isté
];

// Fonty: najprv systémové (dev Windows / Linux server), potom bundled fallback.
const FONT_CANDIDATES = [
    'C:/Windows/Fonts/seguisb.ttf',   // Segoe UI Semibold
    'C:/Windows/Fonts/segoeui.ttf',
    'C:/Windows/Fonts/arial.ttf',
    'C:/Windows/Fonts/calibri.ttf',
    '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
    '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
    '/usr/share/fonts/truetype/ubuntu/Ubuntu-R.ttf',
    'assets/katex/0.16.11/fonts/KaTeX_SansSerif-Regular.ttf', // bundled fallback
];

$root = dirname(__DIR__);

// ── Spracuj argumenty ────────────────────────────────────────────────────────
$force   = false;
$outDir  = null;
$explicit = [];
foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--force') { $force = true; continue; }
    if ($arg === '--stage') { continue; } // pre-commit kompatibilita (no-op)
    if (str_starts_with($arg, '--out-dir=')) { $outDir = substr($arg, 10); continue; }
    $explicit[] = $arg;
}

// ── Nájdi font ───────────────────────────────────────────────────────────────
$font = null;
foreach (FONT_CANDIDATES as $f) {
    $abs = (preg_match('#^(?:[A-Za-z]:|/)#', $f)) ? $f : $root . '/' . $f;
    if (is_file($abs)) { $font = $abs; break; }
}
if ($font === null) {
    fwrite(STDERR, "CHYBA: nenašiel sa žiadny TTF font (pozri FONT_CANDIDATES).\n");
    exit(1);
}

// ── Eligibilita súboru ───────────────────────────────────────────────────────
function isEligible(string $path): bool
{
    $ext = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));
    if (!in_array($ext, ['png', 'jpg', 'jpeg'], true)) {
        return false;
    }
    $base = pathinfo($path, PATHINFO_FILENAME);
    foreach (DENY_PATTERNS as $re) {
        if (preg_match($re, $base)) {
            return false;
        }
    }
    return true;
}

// ── Zostav zoznam obrázkov ───────────────────────────────────────────────────
$targets = [];
if ($explicit) {
    foreach ($explicit as $p) {
        $abs = (preg_match('#^(?:[A-Za-z]:|/)#', $p)) ? $p : $root . '/' . $p;
        if (is_file($abs) && isEligible($abs)) {
            $targets[] = $abs;
        }
    }
} else {
    foreach (glob($root . '/img/*.{png,jpg,jpeg}', GLOB_BRACE) ?: [] as $p) {
        if (isEligible($p)) {
            $targets[] = $p;
        }
    }
}

// ── Manifest (idempotencia) ──────────────────────────────────────────────────
$manifestPath = $root . '/' . MANIFEST_REL;
$manifest = ['version' => 1, 'files' => []];
if (is_file($manifestPath)) {
    $decoded = json_decode((string) file_get_contents($manifestPath), true);
    if (is_array($decoded) && isset($decoded['files']) && is_array($decoded['files'])) {
        $manifest = $decoded;
    }
}

/** Relatívna cesta s '/' oddeľovačmi (kľúč manifestu). */
function relKey(string $abs, string $root): string
{
    $rel = ltrim(str_replace('\\', '/', substr($abs, strlen($root))), '/');
    return $rel;
}

/**
 * Zapeká vodoznak do GD obrázka (vpravo dole, tieň + polopriehľadný text).
 */
function applyWatermark(\GdImage $im, string $font, string $text): void
{
    $w = imagesx($im);
    $h = imagesy($im);

    $size = (int) round($w * WM_REL_SIZE);
    $size = max(WM_MIN_SIZE, min(WM_MAX_SIZE, $size));
    $margin = (int) round($w * WM_MARGIN_REL);

    // Rozmery textu cez bounding box.
    $bbox = imagettfbbox($size, 0, $font, $text);
    $textW = $bbox[2] - $bbox[0];
    $textH = $bbox[1] - $bbox[7];

    // Baseline pozícia vpravo dole.
    $x = $w - $textW - $margin;
    $y = $h - $margin - ($bbox[1]); // $bbox[1] = spodný presah (descender)
    if ($x < $margin) { $x = $margin; } // veľmi úzke obrázky: neutekaj mimo plátna

    imagealphablending($im, true);

    $shadow = imagecolorallocatealpha($im, 0, 0, 0, WM_SHADOW_ALPHA);
    $white  = imagecolorallocatealpha($im, 255, 255, 255, WM_TEXT_ALPHA);
    if ($shadow === false || $white === false) {
        return;
    }

    // Jemný tieň pre čitateľnosť na svetlom aj tmavom pozadí.
    imagettftext($im, $size, 0, $x + 1, $y + 1, $shadow, $font, $text);
    imagettftext($im, $size, 0, $x, $y, $white, $font, $text);
}

/** Načíta PNG/JPEG ako truecolor GD obrázok. */
function loadImage(string $path, string $ext): ?\GdImage
{
    $im = match ($ext) {
        'png'          => @imagecreatefrompng($path),
        'jpg', 'jpeg'  => @imagecreatefromjpeg($path),
        default        => false,
    };
    if ($im === false) {
        return null;
    }
    imagepalettetotruecolor($im);
    return $im;
}

/** Uloží GD obrázok do cieľovej cesty podľa prípony (PNG zachová alfa). */
function saveImage(\GdImage $im, string $dst, string $ext): bool
{
    if ($ext === 'png') {
        imagealphablending($im, false);
        imagesavealpha($im, true);
        return imagepng($im, $dst, 9);
    }
    return imagejpeg($im, $dst, JPEG_QUALITY);
}

$done = 0;
$skipped = 0;
$failed = [];
$manifestChanged = false;

foreach ($targets as $src) {
    $ext = strtolower((string) pathinfo($src, PATHINFO_EXTENSION));
    $key = relKey($src, $root);

    // Idempotencia: ak sha256 súboru zodpovedá manifestu, je už ovodoznakovaný.
    $curHash = hash_file('sha256', $src);
    if (!$force && $outDir === null && isset($manifest['files'][$key]) && $manifest['files'][$key] === $curHash) {
        $skipped++;
        continue;
    }

    $im = loadImage($src, $ext);
    if ($im === null) {
        $failed[] = $src;
        fwrite(STDERR, "  ✗ nedá sa načítať: {$src}\n");
        continue;
    }

    if (min(imagesx($im), imagesy($im)) < WM_MIN_DIM) {
        imagedestroy($im);
        $skipped++;
        continue;
    }

    applyWatermark($im, $font, WM_TEXT);

    // Cieľ: in-place, alebo do --out-dir (preview).
    if ($outDir !== null) {
        $outAbs = (preg_match('#^(?:[A-Za-z]:|/)#', $outDir)) ? $outDir : $root . '/' . $outDir;
        if (!is_dir($outAbs)) { @mkdir($outAbs, 0o775, true); }
        $dst = rtrim($outAbs, '/\\') . '/' . basename($src);
    } else {
        $dst = $src;
    }

    $ok = saveImage($im, $dst, $ext);
    imagedestroy($im);

    if (!$ok || !is_file($dst) || filesize($dst) === 0) {
        $failed[] = $src;
        fwrite(STDERR, "  ✗ ZLYHALO uloženie: {$dst}\n");
        continue;
    }

    // Manifest aktualizuj len pri in-place behu (preview originály nemení).
    if ($outDir === null) {
        $manifest['files'][$key] = hash_file('sha256', $dst);
        $manifestChanged = true;
    }

    $done++;
    echo "  ✓ " . basename($dst) . "  " . round(filesize($dst) / 1024) . " KB\n";
}

// Zapíš manifest (zoradený kvôli stabilnému diffu).
if ($manifestChanged) {
    ksort($manifest['files']);
    file_put_contents(
        $manifestPath,
        json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n"
    );
}

echo "──────────────────────────────────────────────────────\n";
echo "Vodoznak: spracovaných {$done}, preskočených (aktuálne/malé) {$skipped}, "
    . "zlyhaní " . count($failed) . ".";
echo $outDir !== null ? "  [PREVIEW → {$outDir}]\n" : "\n";
if ($outDir === null && $done > 0) {
    echo "Nezabudni regenerovať WebP: php tools/convert_images_webp.php\n";
}

exit($failed ? 1 : 0);
