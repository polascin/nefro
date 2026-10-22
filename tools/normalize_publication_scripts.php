<?php

declare(strict_types=1);
/**
 * Jednorazový migračný skript pre repozitár nefro.
 *
 * Zjednocuje správanie publikačných skriptov `add_*_article.php`:
 * stĺpec `is_published` sa pri opakovanom spustení už nenastavuje, takže
 * editorialové rozhodnutie o zverejnení článku zostáva zachované.
 *
 * Pred úpravou: 46 skriptov malo `is_published = VALUES(is_published)` v
 * bloku `ON DUPLICATE KEY UPDATE`, pričom hodnota bola v INSERT napísaná
 * natvrdo ako 1. Takéto skripty článok pri každom opakovanom behu
 * znovu zverejnili, aj keď bol v administrácii odpublikovaný. Zvyšných
 * 419 skriptov stav zachovávalo.
 *
 * Po úprave: všetky publikačné skripty zachovávajú stav zverejnenia.
 * Zverejnenie alebo odpublikovanie sa robí cez administráciu
 * (Správa článkov), prípadne cez `article_publisher.php` s explicitnou
 * hodnotou `'is_published' => true|false`.
 *
 * Spustenie:  php tools/normalize_publication_scripts.php [--dry-run|--apply]
 *
 * Bez prepínača sa nič nezmení (suchý beh). Zápis do súborov vykoná iba
 * `--apply`, aby sa skript nedal omylom spustiť.
 */

$root = dirname(__DIR__);
$arguments = $argv ?? [];
$apply = in_array('--apply', $arguments, true);
$dryRun = !$apply;

$patterns = [
    // `excerpt = ..., is_top = ..., is_published = VALUES(is_published),`
    'excerpt = VALUES(excerpt), is_top = VALUES(is_top), is_published = VALUES(is_published),'
        => 'excerpt = VALUES(excerpt), is_top = VALUES(is_top),',
    // `is_published = VALUES(is_published), updated_at = NOW()"`
    'is_published = VALUES(is_published), updated_at = NOW()"'
        => 'updated_at = NOW()"',
];

$files = glob($root . '/add_*_article.php') ?: [];
$files = array_merge($files, glob($root . '/add_*_clanok.php') ?: []);
sort($files);

$changed = 0;
$totalHits = 0;

foreach ($files as $file) {
    $contents = file_get_contents($file);
    if ($contents === false) {
        continue;
    }

    // Upravujeme len blok `ON DUPLICATE KEY UPDATE` — INSERT hodnoty
    // (napr. natvrdo 1) musia zostať nedotknuté.
    $markerPos = strpos($contents, 'ON DUPLICATE KEY UPDATE');
    if ($markerPos === false) {
        continue;
    }
    $head = substr($contents, 0, $markerPos);
    $tail = substr($contents, $markerPos);

    $hits = 0;
    $newTail = $tail;
    foreach ($patterns as $search => $replace) {
        $count = substr_count($newTail, $search);
        if ($count > 0) {
            $hits += $count;
            $newTail = str_replace($search, $replace, $newTail);
        }
    }

    if ($hits === 0) {
        continue;
    }

    $totalHits += $hits;
    $changed++;

    if ($dryRun) {
        echo '[dry-run] ' . basename($file) . ": {$hits} upravených výskytov\n";
        continue;
    }

    $new = $head . $newTail;
    file_put_contents($file, $new);
    echo 'upravené: ' . basename($file) . " ({$hits} výskytov)\n";
}

echo "\n" . ($dryRun ? 'Suchý beh.' : 'Hotovo.') . "\n";
echo 'Súborov upravených: ' . $changed . "\n";
echo 'Celkovo upravených výskytov: ' . $totalHits . "\n";
