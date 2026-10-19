<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$checks = 0;
function excerptTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$bySlug = [];
foreach (glob($root . '/add_*_article.php') ?: [] as $file) {
    $source = (string) file_get_contents($file);
    $count = preg_match_all("/'slug'\\s*=>\\s*'([^']+)'/u", $source, $slugs);
    $excerpts = preg_match_all("/'excerpt'\\s*=>\\s*'((?:[^'\\\\]|\\\\.)*)'/u", $source, $texts);
    if ($count === 0 || $count !== $excerpts) {
        continue;
    }
    foreach ($slugs[1] as $i => $slug) {
        $bySlug[$slug] = trim($texts[1][$i]);
    }
}

excerptTest(count($bySlug) > 0, 'No article scripts with excerpts were found.');

$owners = [];
foreach ($bySlug as $slug => $excerpt) {
    if ($excerpt === '') {
        continue;
    }
    $owners[mb_strtolower($excerpt)][] = $slug;
}
foreach ($owners as $slugs) {
    excerptTest(count($slugs) === 1, 'Articles share one excerpt: ' . implode(', ', $slugs));
}

$sobic = 'metabolicka-acidoza-ckd-vyssi-vs-nizsi-ciel-hydrogenuhlicitanu-sobic';
excerptTest(isset($bySlug[$sobic]), 'SoBic article script must define an excerpt.');
$text = $bySlug[$sobic];
excerptTest(str_contains($text, 'SoBic'), 'SoBic excerpt must name the study.');
excerptTest(str_contains($text, 'HCO'), 'SoBic excerpt must describe bicarbonate targets.');
excerptTest(
    preg_match('/kalcifik|koronárn|horčík|PTH/iu', $text) !== 1,
    'SoBic excerpt must not carry the coronary calcification/Mg/PTH perex.',
);
excerptTest(mb_strlen($text) <= 165, 'SoBic excerpt must fit the 165-character meta description.');

echo "Article excerpt regression: {$checks} checks PASS\n";
