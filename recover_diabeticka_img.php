<?php

declare(strict_types=1);
/**
 * recover_diabeticka_img.php  (audit Beh 61 — recovery)
 * ────────────────────────────────────────────────────────────────────────────
 * Chirurgická náprava JEDNÉHO článku (diabeticka-choroba-obliciek-bez-zahad),
 * kde predchádzajúca (chybná) verzia fix_slovak_close_quotes.php skonvertovala
 * ASCII " atribútov na „ (U+201C) v <img> s alt textom obsahujúcim „…".
 *
 * Poškodené:  …poriadku““ loading=“lazy"…   (attr-close + loading-open)
 * Správne:    …poriadku“" loading="lazy"…
 *
 * Zdroj INSERT IGNORE → re-run add-skriptu je no-op, preto priamy UPDATE.
 */

require __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$slug = 'diabeticka-choroba-obliciek-bez-zahad';

$corrupt = "poriadku\u{201C}\u{201C} loading=\u{201C}lazy\"";
$correct = "poriadku\u{201C}\" loading=\"lazy\"";

$content = (string) $pdo->query('SELECT content FROM articles WHERE slug=' . $pdo->quote($slug))->fetchColumn();
$hits    = substr_count($content, $corrupt);
echo "Vyskyt poskodeneho retazca: $hits\n";

if ($hits > 0) {
    $new = str_replace($corrupt, $correct, $content);
    $st  = $pdo->prepare('UPDATE articles SET content=:c WHERE slug=:s');
    $st->execute([':c' => $new, ':s' => $slug]);
    echo "UPDATED (str_replace $hits×).\n";
} else {
    echo "Poskodeny retazec nenajdeny — mozno uz opravene.\n";
}

$chk = (string) $pdo->query('SELECT content FROM articles WHERE slug=' . $pdo->quote($slug))->fetchColumn();
$sig = preg_match_all('/=\x{201C}|\x{201C}>|\x{201C}\x{201C}|\x{201C}\s+[a-z-]+=/u', $chk);
echo "Zvysne attr-position „ signatury v clanku: " . (int) $sig . "  (0 = cisty)\n";
