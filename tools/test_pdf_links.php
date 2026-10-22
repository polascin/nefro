<?php

declare(strict_types=1);

require_once __DIR__ . '/../pdf_generator.php';

$checks = 0;
function pdfLinksTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

// Jednotlivé tvary odkazov: prenositeľné ostávajú alebo sa prepíšu, nebezpečné zmiznú.
$cases = [
    'https://doi.org/10.1000/xyz' => 'https://doi.org/10.1000/xyz',
    'http://example.org/a?b=1' => 'http://example.org/a?b=1',
    'article.php?slug=test-clanok' => 'https://nefro.polascin.net/article.php?slug=test-clanok',
    '/article.php?slug=test-clanok' => 'https://nefro.polascin.net/article.php?slug=test-clanok',
    'img/ilustracia.webp' => 'https://nefro.polascin.net/img/ilustracia.webp',
    '/img/ilustracia.webp' => 'https://nefro.polascin.net/img/ilustracia.webp',
    'lieky.php' => 'https://nefro.polascin.net/lieky.php',
    '#tabulka-1' => '#tabulka-1',
    '' => null,
    '   ' => null,
    'javascript:alert(1)' => null,
    'mailto:niekto@example.org' => null,
    'data:text/html,abc' => null,
    'file:///etc/passwd' => null,
    '../private/nefro.env.ini' => null,
    'img/../../etc/passwd' => null,
    '//evil.example/x' => 'https://nefro.polascin.net/evil.example/x',
];
foreach ($cases as $input => $expected) {
    pdfLinksTest(articlePdfPortableHref((string) $input) === $expected, 'Prepis odkazu zlyhal pre: ' . var_export($input, true));
}

// Sanitizácia obsahu: relatívne odkazy dostanú HTTPS základ, nebezpečné sa odstránia.
$content = '<p>Pozri <a href="article.php?slug=suvisiaci">súvisiaci článok</a>, '
    . '<a href="/img/obrazok.webp">ilustráciu</a> a <a href="https://pubmed.ncbi.nlm.nih.gov/1/">zdroj</a>. '
    . '<a href="#kotva">Kotva</a> <a href="javascript:void(0)">skript</a> <a href="mailto:x@example.org">mail</a></p>';
$safe = sanitizeArticlePdfContent($content);
pdfLinksTest(str_contains($safe, 'href="https://nefro.polascin.net/article.php?slug=suvisiaci"'), 'Relatívny odkaz na článok nedostal HTTPS základ.');
pdfLinksTest(str_contains($safe, 'href="https://nefro.polascin.net/img/obrazok.webp"'), 'Relatívny odkaz na ilustráciu nedostal HTTPS základ.');
pdfLinksTest(str_contains($safe, 'href="https://pubmed.ncbi.nlm.nih.gov/1/"'), 'Externý odkaz sa nesmie meniť.');
pdfLinksTest(str_contains($safe, 'href="#kotva"'), 'Vnútorná kotva musí ostať.');
pdfLinksTest(!str_contains($safe, 'javascript:'), 'javascript: odkaz musí zmiznúť.');
pdfLinksTest(!str_contains($safe, 'mailto:'), 'mailto: odkaz musí zmiznúť.');
pdfLinksTest(preg_match('~href="(?!https?://|#)~', $safe) !== 1, 'V PDF obsahu nesmie ostať relatívny href.');

// Celé tlačové HTML: lokálny <base> ostáva iba pre obrázky, odkazy sú absolútne.
$html = buildArticlePdfHtml([
    'title' => 'Testovací článok',
    'author' => 'Syntetický autor',
    'slug' => 'testovaci-clanok',
    'content' => $content,
    'published_at' => '2026-01-02 03:04:05',
]);
pdfLinksTest(str_contains($html, '<base href="file://'), 'Obrázky sa majú ďalej načítavať lokálne cez <base>.');
pdfLinksTest(preg_match('~href="(?!https?://|#|file://)~', $html) !== 1, 'Tlačové HTML nesmie obsahovať relatívny href.');
pdfLinksTest(substr_count($html, '<base ') === 1, 'Obsah článku nesmie vložiť ďalší <base>.');
pdfLinksTest(str_contains($html, 'https://nefro.polascin.net/article.php?slug=testovaci-clanok'), 'Pätička musí uvádzať verejnú URL článku.');

pdfLinksTest(str_contains($html, 'href="https://nefro.polascin.net/article.php?slug=testovaci-clanok#kotva"'), 'Kotva v tlačovom HTML musí mať verejnú URL; wkhtmltopdf ju inak uloží ako Launch.');
pdfLinksTest(!str_contains($html, 'href="#'), 'V tlačovom HTML nesmie ostať lokálna kotva.');

echo "PDF links: $checks PASS\n";
