<?php

declare(strict_types=1);

/**
 * Všetky publikačné skripty musia mať rovnaké správanie stavu zverejnenia.
 *
 * 46 skriptov z 165 si po svojom INSERT-e nastavovalo `is_published = 1`
 * natvrdo a v `ON DUPLICATE KEY UPDATE` ho znovu prepisovalo. Pri opakovanom
 * behu skriptu sa tak článok znova zverejnil, aj keď bol v administrácii
 * odpublikovaný. Zvyšných 119 skriptov stav zachovávalo, takže správanie
 * záviselo od toho, ktorý skript článok vytvoril.
 *
 * Pravidlo: `is_published` sa pri aktualizácii nemení, kým ho skript výslovne
 * nevyžiada (vtedy cez `upsertArticles(..., ['is_published' => true|false])`).
 */

$checks = 0;

function publicationConsistencyTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

$root = dirname(__DIR__);

$files = array_merge(
    glob($root . '/add_*_article.php') ?: [],
    glob($root . '/add_*_clanok.php') ?: []
);
sort($files);

$withUpsert = 0;
$offenders = [];

foreach ($files as $file) {
    $source = (string) file_get_contents($file);
    if (!str_contains($source, 'ON DUPLICATE KEY UPDATE')) {
        continue;
    }

    ++$withUpsert;

    $markerPos = strpos($source, 'ON DUPLICATE KEY UPDATE');
    $tail = substr($source, $markerPos);

    if (preg_match('/is_published\s*=\s*VALUES\(is_published\)/', $tail) === 1) {
        $offenders[] = basename($file);
    }
}

publicationConsistencyTest(
    $withUpsert > 100,
    'Očakáva sa dostatok publikačných skriptov s UPSERT (nájdené: ' . $withUpsert . ').',
);

publicationConsistencyTest(
    $offenders === [],
    'Skripty, ktoré pri aktualizácii prepisujú is_published: ' . implode(', ', $offenders),
);

// ── Zdieľaný helper ──────────────────────────────────────────────────────────
$helper = (string) file_get_contents($root . '/article_publisher.php');

publicationConsistencyTest(
    str_contains($helper, 'is_published = IF(:is_published_set = 0, is_published, VALUES(is_published))'),
    'article_publisher.php musí zachovať is_published, ak sa výslovne nenastavuje.',
);
publicationConsistencyTest(
    str_contains($helper, "array_key_exists('is_published', \$options)"),
    'article_publisher.php musí rozlíšiť výslovne zadaný stav od predvoleného.',
);
publicationConsistencyTest(
    !str_contains($helper, 'published_at = VALUES(published_at)'),
    'published_at sa pri aktualizácii zachováva (dokumentovaný postup).',
);

// ── Šablóna používa helper ───────────────────────────────────────────────────
foreach (['add_TEMPLATE_article.php', 'add_TEMPLATE_popular_article.php'] as $template) {
    $path = $root . '/' . $template;
    if (!is_file($path)) {
        continue;
    }
    publicationConsistencyTest(
        str_contains((string) file_get_contents($path), 'upsertArticles('),
        $template . ' musí publikovať cez zdieľaný helper upsertArticles().',
    );
}

echo "Publication consistency: $checks PASS\n";
