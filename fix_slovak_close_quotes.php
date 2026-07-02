<?php

declare(strict_types=1);
/**
 * fix_slovak_close_quotes.php  (audit Beh 63 — dokončenie SK-1, cross-line residual)
 * ────────────────────────────────────────────────────────────────────────────
 * Doopraví 8 zvyšných zmiešaných úvodzoviek „…" (ASCII zatváracia), ktoré span
 * prechádza cez zalomenie riadka — všetko overená próza (názvy zdrojových
 * citácií + citované frázy), nie atribúty.
 *
 * Regex: /\x{201E}([^"\x{201E}\x{201C}<>]*?)"/u  → „$1“ (U+201C)
 *   povoľuje \r\n vo vnútri, ale vylučuje ", „ (U+201E), “ (U+201C), <, >.
 *
 * BEZPEČNOSTNÝ ABORT-GUARD (poučenie z regex-bugu Beh 62): po transformácii sa
 * článok zapíše LEN ak NEPRIBUDLA žiadna attr-korupčná signatúra (=“ / “> / ““
 * / “ attr=). Ak by transformácia mala poškodiť HTML atribút, článok sa PRESKOČÍ.
 *
 * Použitie:  php fix_slovak_close_quotes.php        (DRY-RUN)
 *            php fix_slovak_close_quotes.php apply   (zápis + regen PDF)
 */

require __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$apply = (($argv[1] ?? '') === 'apply');

function corruptionSignatures(string $s): int
{
    return (int) preg_match_all('/=\x{201C}|\x{201C}>|\x{201C}\x{201C}|\x{201C}\s+[a-z-]+=/u', $s);
}

function fixCloseQuotes(string $s, int &$count): string
{
    return (string) preg_replace_callback(
        '/\x{201E}([^"\x{201E}\x{201C}<>]*?)"/u',
        static function (array $m) use (&$count): string {
            $count++;
            return "\u{201E}" . $m[1] . "\u{201C}";
        },
        $s
    );
}

$rows = $pdo->query('SELECT id, slug, content, excerpt FROM articles')->fetchAll(PDO::FETCH_ASSOC);
$upd  = $pdo->prepare('UPDATE articles SET content = :c, excerpt = :e WHERE id = :id');

$files = 0;
$repl  = 0;
$aborted = [];

foreach ($rows as $r) {
    $cN = 0;
    $eN = 0;
    $oldContent = (string) $r['content'];
    $oldExcerpt = (string) ($r['excerpt'] ?? '');
    $newContent = fixCloseQuotes($oldContent, $cN);
    $newExcerpt = fixCloseQuotes($oldExcerpt, $eN);
    if (($cN + $eN) === 0) {
        continue;
    }

    // Abort-guard: transformácia nesmie pridať attr-korupčnú signatúru.
    if (corruptionSignatures($newContent) > corruptionSignatures($oldContent)
        || corruptionSignatures($newExcerpt) > corruptionSignatures($oldExcerpt)) {
        $aborted[] = $r['slug'];
        continue;
    }

    $files++;
    $repl += $cN + $eN;
    echo sprintf("  %-58s +%d\n", $r['slug'], $cN + $eN);

    if ($apply) {
        $upd->execute([':c' => $newContent, ':e' => $newExcerpt, ':id' => $r['id']]);
    }
}

echo str_repeat('─', 60) . "\n";
echo ($apply ? '[APPLY] ' : '[DRY-RUN] ') . sprintf("Článkov: %d | zámien: %d | abortnutých (guard): %d\n", $files, $repl, count($aborted));
if ($aborted) {
    echo 'ABORT-GUARD preskočil (možná attr-korupcia): ' . implode(', ', $aborted) . "\n";
}
