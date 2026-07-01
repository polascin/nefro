<?php

declare(strict_types=1);
/**
 * fix_slovak_close_quotes.php
 * ────────────────────────────────────────────────────────────────────────────
 * Jednorazová migrácia (audit Beh 61, nález SK-1): niektoré články používajú
 * slovenskú OTVÁRACIU úvodzovku „ (U+201E), ale ako ZATVÁRACIU majú ASCII "
 * (U+0022) namiesto správnej „ (U+201C). Site je rozdelený (~62 správne, ~47 zle);
 * táto migrácia zosúladí zlé so správnou väčšinou.
 *
 * Bezpečnosť: konverzia sa robí LEN v čistom textovom spane „…", teda regex
 *   /\x{201E}([^"<>\r\n]*?)"/u  → „$1“ (U+201C)
 * Vylúčené sú <, >, " a nové riadky vo vnútri → HTML atribúty (href="…") sa
 * NIKDY nedotkne (medzi „ a jej ASCII zatváračkou nesmie byť < ani ďalší ").
 *
 * Použitie:  php fix_slovak_close_quotes.php          (DRY-RUN, len report)
 *            php fix_slovak_close_quotes.php apply     (zapíše do DB)
 */

require __DIR__ . '/config.php';

$apply = (($argv[1] ?? '') === 'apply');
$pdo   = db();

/** Konverzia ASCII zatváracej úvodzovky na U+201C len v čistom „…" spane. */
function fixCloseQuotes(string $s, int &$count): string
{
    return (string) preg_replace_callback(
        '/\x{201E}([^"<>\r\n]*?)"/u',
        static function (array $m) use (&$count): string {
            $count++;
            return "\u{201E}" . $m[1] . "\u{201C}";
        },
        $s
    );
}

$rows = $pdo->query('SELECT id, slug, title, content, excerpt FROM articles')->fetchAll(PDO::FETCH_ASSOC);

$upd = $pdo->prepare('UPDATE articles SET content = :c, excerpt = :e WHERE id = :id');

$totalFiles   = 0;
$totalRepl    = 0;
$changedSlugs = [];

foreach ($rows as $r) {
    $cCount = 0;
    $eCount = 0;
    $newContent = fixCloseQuotes((string) $r['content'], $cCount);
    $newExcerpt = fixCloseQuotes((string) ($r['excerpt'] ?? ''), $eCount);
    $repl = $cCount + $eCount;
    if ($repl === 0) {
        continue;
    }
    $totalFiles++;
    $totalRepl     += $repl;
    $changedSlugs[] = sprintf('  %-58s +%d (content %d, excerpt %d)', $r['slug'], $repl, $cCount, $eCount);

    if ($apply) {
        $upd->execute([':c' => $newContent, ':e' => $newExcerpt, ':id' => $r['id']]);
    }
}

echo ($apply ? '[APPLY] ' : '[DRY-RUN] ') . "Zmiešané úvodzovky – oprava zatváracej ASCII \" → „ (U+201C)\n";
echo implode("\n", $changedSlugs) . "\n";
echo str_repeat('─', 60) . "\n";
echo sprintf("Článkov dotknutých: %d | zámien spolu: %d\n", $totalFiles, $totalRepl);
if (!$apply) {
    echo "→ DRY-RUN, nič sa nezapísalo. Spusti s argumentom 'apply' pre zápis.\n";
} else {
    echo "→ Zapísané do DB. Ďalej: regenerovať PDF (sync_article_pdfs.sh).\n";
}
