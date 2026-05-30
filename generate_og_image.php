<?php
declare(strict_types=1);
/**
 * generate_og_image.php
 * Generuje Open Graph obrázok 1200×630 px pre Nefro-projekt Slovensko.
 * CLI: php generate_og_image.php
 * Výstup: img/og-default.jpg
 */

// Ochrana: súbor je určený iba pre CLI použitie
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('Forbidden'); }

define('OG_W', 1200);
define('OG_H', 630);
define('OUT_PATH', __DIR__ . '/img/og-default.jpg');
define('OUT_QUALITY', 95);

$logoPath     = __DIR__ . '/img/nps-logo.gif';
$abstractPath = __DIR__ . '/img/nps-abstract.png';

// Značkové farby
$colorBg1    = [9,  18,  48];   // #09122f — hlboký navy (vľavo hore)
$colorBg2    = [22, 78, 180];   // #164eb4 — modrozlatý (vpravo dole)
$colorBg3    = [10, 110, 195];  // #0a6ec3 — žiarivá modrá (glow)
$colorAccent = [14, 165, 233];  // #0ea5e9 — cyan/teal
$colorGreen  = [16, 185, 129];  // #10b981 — zeleno-teal
$colorWhite  = [255, 255, 255];
$colorSilver = [185, 210, 235]; // chladná strieborná pre subtitle

// TTF fonty
$boldFonts = [
    'C:/Windows/Fonts/arialbd.ttf',
    'C:/Windows/Fonts/verdanab.ttf',
    'C:/Windows/Fonts/calibrib.ttf',
    'C:/Windows/Fonts/segoeuib.ttf',
    '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
    '/usr/share/fonts/truetype/ubuntu/Ubuntu-B.ttf',
    '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
];
$regularFonts = [
    'C:/Windows/Fonts/arial.ttf',
    'C:/Windows/Fonts/verdana.ttf',
    'C:/Windows/Fonts/calibri.ttf',
    'C:/Windows/Fonts/segoeui.ttf',
    '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
    '/usr/share/fonts/truetype/ubuntu/Ubuntu-R.ttf',
    '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
];
$fBold = $fReg = null;
foreach ($boldFonts as $fp)    { if (file_exists($fp)) { $fBold = $fp; break; } }
foreach ($regularFonts as $fp) { if (file_exists($fp)) { $fReg  = $fp; break; } }
if (!$fReg)  $fReg  = $fBold;
$useTTF = ($fBold !== null);
echo "Font bold: " . ($fBold ?: 'GD built-in') . "\n";

// ── Pomocná funkcia: odstráni biele/svetlé pozadie z obrázka ─────────────────
function removeWhiteBackground(\GdImage $src, int $threshold = 235): \GdImage
{
    $w   = imagesx($src);
    $h   = imagesy($src);
    $dst = imagecreatetruecolor($w, $h);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);

    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            $rgb = imagecolorat($src, $x, $y);
            $r   = ($rgb >> 16) & 0xFF;
            $g   = ($rgb >> 8)  & 0xFF;
            $b   = $rgb & 0xFF;

            // Biely/svetlý pixel → priehľadný
            if ($r >= $threshold && $g >= $threshold && $b >= $threshold) {
                $alpha = 127;
            } else {
                // Tmavý pixel ponechaj, prípadne jemne zvýš kontrast
                $alpha = 0;
                // Optionally darken slightly for better blending on dark bg
                $r = max(0, $r - 10);
                $g = max(0, $g - 5);
            }

            $nc = imagecolorallocatealpha($dst, $r, $g, $b, $alpha);
            imagesetpixel($dst, $x, $y, $nc);
            imagecolordeallocate($dst, $nc);
        }
    }
    return $dst;
}

// ── 1. Plátno ─────────────────────────────────────────────────────────────────
$img = imagecreatetruecolor(OG_W, OG_H);
imagealphablending($img, true);

// ── 2. Diagonálny gradient pozadie ───────────────────────────────────────────
for ($y = 0; $y < OG_H; $y++) {
    for ($x = 0; $x < OG_W; $x++) {
        $t = ($x / OG_W + $y / OG_H) / 2.0;

        $r = (int)($colorBg1[0] + $t * ($colorBg2[0] - $colorBg1[0]));
        $g = (int)($colorBg1[1] + $t * ($colorBg2[1] - $colorBg1[1]));
        $b = (int)($colorBg1[2] + $t * ($colorBg2[2] - $colorBg1[2]));

        // Glow efekt — sférické svetlo vpravo-stred
        $gx   = OG_W * 0.75;
        $gy   = OG_H * 0.40;
        $dist = sqrt(($x - $gx) ** 2 + ($y - $gy) ** 2);
        $glow = max(0, 1 - $dist / 380) * 0.35;
        $r    = min(255, (int)($r + $glow * 40));
        $g    = min(255, (int)($g + $glow * 100));
        $b    = min(255, (int)($b + $glow * 190));

        $c = imagecolorallocate($img, $r, $g, $b);
        imagesetpixel($img, $x, $y, $c);
        imagecolordeallocate($img, $c);
    }
}

// ── 3. Subtilná vedecká textúra (nps-abstract.png, pravá časť, 14% opacity) ──
if (file_exists($abstractPath)) {
    $abs = imagecreatefrompng($abstractPath);
    if ($abs) {
        $aw = imagesx($abs);
        $ah = imagesy($abs);

        // Vyberieme strednú-pravú časť abstraktu
        $srcX  = (int)($aw * 0.25);
        $srcW  = $aw - $srcX;
        $dstW  = 720;

        $absDst = imagecreatetruecolor($dstW, OG_H);
        imagealphablending($absDst, true);
        imagecopyresampled($absDst, $abs, 0, 0, $srcX, 0, $dstW, OG_H, $srcW, $ah);
        imagecopymerge($img, $absDst, OG_W - $dstW, 0, 0, 0, $dstW, OG_H, 14);
        imagedestroy($absDst);
        imagedestroy($abs);
    }
}

// ── 4. Ľavý tmavý panel (zvýrazní čitateľnosť textu) ─────────────────────────
// Gradient fade: plná tmavá vľavo, priehľadná pred logom
$panelW = 660;
for ($x = 0; $x < $panelW; $x++) {
    $fade  = max(0.0, 1.0 - ($x / $panelW) * 1.4);
    $alpha = (int)(127 * (1.0 - min(1.0, $fade * 0.6)));
    $c = imagecolorallocatealpha($img, $colorBg1[0], $colorBg1[1], $colorBg1[2], $alpha);
    imageline($img, $x, 0, $x, OG_H, $c);
    imagecolordeallocate($img, $c);
}

// ── 5. Logo obličiek (nps-logo.gif) vpravo — bez bieleho pozadia ─────────────
$logoPosX = 600; // Začiatok loga (pravých 50%)

if (file_exists($logoPath)) {
    $logoRaw = imagecreatefromgif($logoPath);
    if ($logoRaw) {
        $lw = imagesx($logoRaw);
        $lh = imagesy($logoRaw);

        // Cieľová šírka = 560px (zostatok po textovej oblasti)
        $targetW = 560;
        $targetH = (int)($lh * ($targetW / $lw));
        if ($targetH > OG_H - 20) {
            $targetH = OG_H - 20;
            $targetW = (int)($lw * ($targetH / $lh));
        }

        // Resize
        $logoResized = imagecreatetruecolor($targetW, $targetH);
        imagealphablending($logoResized, false);
        imagesavealpha($logoResized, true);
        imagecopyresampled($logoResized, $logoRaw, 0, 0, 0, 0, $targetW, $targetH, $lw, $lh);
        imagedestroy($logoRaw);

        // Odstráň biele/svetlé pozadie
        $logoAlpha = removeWhiteBackground($logoResized);
        imagedestroy($logoResized);

        // Pozícia: vpravo-stred, s malým odsadením od pravého okraja
        $posX = $logoPosX + (int)((OG_W - $logoPosX - $targetW) / 2);
        $posY = (int)((OG_H - $targetH) / 2);

        // Kopírovanie s alpha (nie imagecopymerge — rešpektuje priehľadnosť)
        imagealphablending($img, true);
        imagecopy($img, $logoAlpha, $posX, $posY, 0, 0, $targetW, $targetH);
        imagedestroy($logoAlpha);
    }
}

// ── 6. Dekoratívne prvky ──────────────────────────────────────────────────────
$cAccent  = imagecolorallocate($img, ...$colorAccent);
$cGreen   = imagecolorallocate($img, ...$colorGreen);
$cWhite   = imagecolorallocate($img, ...$colorWhite);
$cSilver  = imagecolorallocate($img, ...$colorSilver);

// Hrubá horizontálna čiara (separátor po hlavnom nadpise)
imagesetthickness($img, 4);
imageline($img, 64, 335, 550, 335, $cAccent);
imagesetthickness($img, 1);

// Tenká linka po nadnádpise
imagesetthickness($img, 2);
imageline($img, 64, 122, 200, 122, $cGreen);
imagesetthickness($img, 1);

// Akcentové puntíky vľavo
imagefilledellipse($img, 47, 192, 11, 11, $cAccent);
imagefilledellipse($img, 47, 245, 7, 7, $cGreen);

// Jemné kruhy vľavo dole — dekorácia
$circles = [[72, OG_H-52, 22], [130, OG_H-52, 16], [182, OG_H-52, 12]];
foreach ($circles as [$cx, $cy, $r]) {
    $cc = imagecolorallocatealpha($img, ...[...$colorAccent, 95]);
    imageellipse($img, $cx, $cy, $r * 2, $r * 2, $cc);
    imagecolordeallocate($img, $cc);
}

// Vertikálna tenká linka — vizuálny oddeľovač textu
$lineC = imagecolorallocatealpha($img, ...[...$colorAccent, 100]);
imageline($img, 58, 135, 58, 430, $lineC);
imagecolordeallocate($img, $lineC);

// ── 7. Text ───────────────────────────────────────────────────────────────────
$tx = 72; // X-ová pozícia všetkých textov

if ($useTTF) {
    // Nadnádpis (uppercase malé písmená)
    imagettftext($img, 16, 0, $tx, 115, $cGreen, $fReg,
        'ODBORNÝ PORTÁL · NEFROLÓGIA · SLOVENSKO');

    // Hlavný nadpis — 2 riadky s rôznymi farbami
    imagettftext($img, 82, 0, $tx, 225, $cWhite,  $fBold, 'Nefro-projekt');
    imagettftext($img, 82, 0, $tx, 325, $cAccent, $fBold, 'Slovensko');

    // Subtitle (menšie, strieborné)
    imagettftext($img, 23, 0, $tx, 375, $cSilver, $fReg,
        'Klinické kalkulačky · Odborné články · KDIGO 2024');

    // Tagy (zeleno-teal)
    imagettftext($img, 19, 0, $tx, 415, $cGreen, $fReg,
        'eGFR  ·  KFRE  ·  KDIGO  ·  CKD-PC  ·  IgAN  ·  ADPKD');

    // URL / branding dole
    $urlC = imagecolorallocatealpha($img, ...[...$colorSilver, 20]);
    imagettftext($img, 18, 0, $tx + 16, OG_H - 34, $cSilver, $fReg,
        'nefro.polascin.net');
    imagecolordeallocate($img, $urlC);

} else {
    $f = 5;
    imagestring($img, $f, $tx, 100, 'ODBORNY PORTAL PRE NEFROLOGII', $cGreen);
    imagestring($img, $f, $tx, 175, 'Nefro-projekt Slovensko', $cWhite);
    imagestring($img, $f, $tx, 240, 'Klinicke kalkulacky · KDIGO 2024', $cSilver);
    imagestring($img, $f, $tx, 270, 'eGFR  KFRE  KDIGO  CKD-PC', $cGreen);
    imagestring($img, $f, $tx, OG_H - 28, 'nefro.polascin.net', $cSilver);
    echo "WARN: TTF font chýba — text bez diakritiky (GD built-in fonty)\n";
}

// ── 8. Rámček (jemný teal) ────────────────────────────────────────────────────
$bC = imagecolorallocatealpha($img, ...[...$colorAccent, 90]);
imagerectangle($img, 0, 0, OG_W - 1, OG_H - 1, $bC);
imagecolordeallocate($img, $bC);

// ── 9. Uloženie ───────────────────────────────────────────────────────────────
imagealphablending($img, false);
imagesavealpha($img, false);

$saved = imagejpeg($img, OUT_PATH, OUT_QUALITY);
imagedestroy($img);

if ($saved) {
    $size = filesize(OUT_PATH);
    echo "✅  " . OUT_PATH . "\n";
    echo "   " . OG_W . "×" . OG_H . " px  |  " . round($size / 1024) . " KB  |  JPEG " . OUT_QUALITY . "%\n";
} else {
    echo "❌  Uloženie zlyhalo: " . OUT_PATH . "\n";
    exit(1);
}
