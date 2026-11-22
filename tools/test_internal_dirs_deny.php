<?php

declare(strict_types=1);

/**
 * Každý sledovaný adresár v koreni repozitára je buď vedome verejný, alebo
 * sa nenasadzuje (oba ignore zoznamy) a pri bežnom mene je aj zamietnutý
 * v .htaccess.
 *
 * Dôvod (Beh 190): adresár `editorial/` s internými redakčnými dokladmi
 * (snímky prihlásených účtov na sociálnych sieťach, kontroly zdrojov) nebol
 * v žiadnom zozname, nasadzoval sa do web rootu a súbory .json, .jpg, .png,
 * .docx a .txt z neho vracali HTTP 200.
 */

$checks = 0;
function internalDirTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$root = dirname(__DIR__);

// Adresáre, ktoré do web rootu patria. `private` a `uploads` majú vlastné
// pravidlá v .htaccess, `.licenses` obsahuje iba licenčný text.
$public = ['assets', 'img', 'pdf', 'uploads', 'private', '.well-known', '.licenses'];

$tracked = [];
$fromGit = false;
$output = [];
$rc = 1;
exec('git -C ' . escapeshellarg($root) . ' ls-files 2>/dev/null', $output, $rc);
if ($rc === 0 && $output !== []) {
    $fromGit = true;
    foreach ($output as $path) {
        // Cesty s diakritikou Git vypisuje v úvodzovkách; zaujíma nás iba prvý segment.
        $path = ltrim($path, '"');
        $slash = strpos($path, '/');
        if ($slash !== false) {
            $tracked[substr($path, 0, $slash)] = true;
        }
    }
} else {
    // Bez Gitu (integračný kontajner má iba výber súborov) ber adresáre z disku.
    foreach (glob($root . '/{,.}[!.]*', GLOB_ONLYDIR | GLOB_BRACE) ?: [] as $dir) {
        $tracked[basename($dir)] = true;
    }
    unset($tracked['.git'], $tracked['node_modules'], $tracked['vendor']);
}
internalDirTest(isset($tracked['tools'], $tracked['hooks']), 'Zoznam adresárov sa nepodarilo načítať.');

$readPatterns = static function (string $file): array {
    $patterns = [];
    foreach (preg_split('~\R~', (string) file_get_contents($file)) ?: [] as $line) {
        $line = trim($line);
        if ($line !== '' && $line[0] !== '#') {
            $patterns[$line] = true;
        }
    }

    return $patterns;
};
$sftpIgnore = $readPatterns($root . '/hooks/deploy-ignore.txt');
$rsyncIgnore = $readPatterns($root . '/.deployignore');

$htaccess = (string) file_get_contents($root . '/.htaccess');
$denied = [];
if (preg_match('~RewriteRule \^\(([^)]*)\)\(/\.\*\)\?\$ - \[F,L\]~', $htaccess, $m) === 1) {
    foreach (explode('|', $m[1]) as $name) {
        $denied[str_replace('\\', '', $name)] = true;
    }
}
internalDirTest(isset($denied['tools'], $denied['hooks']), 'Pravidlo deny pre adresáre v .htaccess sa nepodarilo načítať.');

$internal = 0;
foreach (array_keys($tracked) as $dir) {
    if (in_array($dir, $public, true)) {
        continue;
    }
    ++$internal;
    internalDirTest(
        isset($sftpIgnore[$dir . '/**']),
        "Adresár {$dir}/ chýba v hooks/deploy-ignore.txt (alebo ho pridaj medzi verejné v tomto teste)."
    );
    internalDirTest(isset($rsyncIgnore[$dir]), "Adresár {$dir}/ chýba v .deployignore.");
    // Adresáre začínajúce bodkou hosting zamieta sám; bežné mená musí kryť .htaccess,
    // lebo ignore zoznam nezabráni prístupu k súborom nahraným pred jeho doplnením.
    if ($dir[0] !== '.') {
        internalDirTest(isset($denied[$dir]), "Adresár {$dir}/ chýba v pravidle deny v .htaccess.");
    }
}
internalDirTest($internal >= ($fromGit ? 5 : 2), 'Kontrola pokryla neočakávane málo interných adresárov.');
internalDirTest(isset($denied['editorial'], $sftpIgnore['editorial/**']), 'Adresár editorial/ musí ostať interný.');

echo "Internal directories deny: {$checks} PASS\n";
