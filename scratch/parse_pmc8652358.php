<?php
declare(strict_types=1);

$xml = simplexml_load_file(__DIR__ . '/pmc8652358.xml');
if ($xml === false) {
    fwrite(STDERR, "fail pmc xml\n");
    exit(1);
}

$xml->registerXPathNamespace('a', 'https://jats.nlm.nih.gov/ns/archiving/1.0/');
$authors = $xml->xpath('//contrib-group/contrib[@contrib-type="author"]') ?: $xml->xpath('//contrib[@contrib-type="author"]');
echo "AUTHOR COUNT xpath1: " . (is_array($authors) ? count($authors) : 0) . "\n";

$i = 0;
$names = [];
if (is_array($authors)) {
    foreach ($authors as $c) {
        $i++;
        $coll = (string) ($c->{'collab'} ?? '');
        if ($coll !== '') {
            echo "$i. COLLAB: $coll\n";
            $names[] = $coll;
            continue;
        }
        $given = trim((string) $c->name->{'given-names'} . (string) $c->{'name'}->{'given-names'});
        $surname = trim((string) $c->name->surname);
        if ($given === '' && isset($c->name)) {
            $given = trim((string) $c->name->{'given-names'});
            $surname = trim((string) $c->name->surname);
        }
        $suf = trim((string) ($c->name->suffix ?? ''));
        $full = trim($given . ' ' . $surname . ($suf !== '' ? ' ' . $suf : ''));
        echo "$i. $full\n";
        $names[] = $full;
    }
}

echo "\nPHP: ['" . implode("', '", $names) . "']\n";

// dump article-title and some section titles
$titles = $xml->xpath('//article-title') ?: [];
foreach ($titles as $t) {
    echo "ART TITLE: " . trim(preg_replace('/\s+/', ' ', (string) $t)) . "\n";
}
$secs = $xml->xpath('//sec/title') ?: [];
echo "SECTIONS:\n";
foreach ($secs as $s) {
    echo " - " . trim(preg_replace('/\s+/', ' ', (string) $s)) . "\n";
}
