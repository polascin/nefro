<?php

declare(strict_types=1);

/**
 * Každá knižnica v koreni repozitára, ktorú iný PHP súbor includuje a ktorá
 * nie je samostatná stránka, musí byť v .htaccess za `Require all denied`.
 *
 * Dôvod (Beh 101, Beh 169): include-only súbor bez deny vracia pri priamom
 * prístupe HTTP 200 s prázdnym telom (calculator_ekfc_logic.php) alebo 500
 * (widget_participating_authors.php s guardom cez PHP_SELF).
 */

$checks = 0;
function includeDenyTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$root = dirname(__DIR__);
$htaccess = (string) file_get_contents($root . '/.htaccess');

$denied = [];
if (preg_match_all('~<FilesMatch "\^\(([^)]*)\)\\\\\.php\$">\s*Require all denied~', $htaccess, $m) > 0) {
    foreach ($m[1] as $group) {
        foreach (explode('|', $group) as $name) {
            $denied[$name] = true;
        }
    }
}
if (preg_match_all('~<Files "([a-z0-9_]+)\.php">\s*Require all denied~', $htaccess, $m) > 0) {
    foreach ($m[1] as $name) {
        $denied[$name] = true;
    }
}
includeDenyTest(isset($denied['calculators_common']), 'Zoznam deny v .htaccess sa nepodarilo načítať.');

$pages = [];
foreach (glob($root . '/*.php') ?: [] as $file) {
    $pages[basename($file, '.php')] = $file;
}

$included = [];
foreach (array_merge(glob($root . '/*.php') ?: [], glob($root . '/tools/*.php') ?: []) as $file) {
    $src = (string) file_get_contents($file);
    if (preg_match_all('~(?:require|include)(?:_once)?\s*\(?\s*(?:__DIR__\s*\.\s*)?["\']/?([a-z0-9_]+)\.php["\']~', $src, $m) > 0) {
        foreach ($m[1] as $name) {
            $included[$name] = true;
        }
    }
}

$checked = 0;
foreach (array_keys($included) as $name) {
    if (!isset($pages[$name])) {
        continue;
    }
    $src = (string) file_get_contents($pages[$name]);
    // Samostatná stránka (vlastné HTML alebo spoločná hlavička) nie je knižnica.
    if (preg_match('~<!DOCTYPE|<html|["\']/?header\.php["\']|legal_head~i', $src) === 1) {
        continue;
    }
    ++$checked;
    includeDenyTest(isset($denied[$name]), "{$name}.php sa includuje, ale chýba v .htaccess deny (priamy prístup ho spustí).");
}
includeDenyTest($checked >= 40, "Príliš málo knižníc ({$checked}); heuristika include zlyhala.");

echo "Include library deny: $checks PASS\n";
