<?php

declare(strict_types=1);

/**
 * A11y: samostatný <select> jednotiek bez <label for> musí mať aria-label
 * (WCAG 4.1.2; recidíva Beh 31). Pinuje aj id na companion unit selectoch
 * a prístupné meno status selectu v admin_content_notices.php.
 */

$checks = 0;

function a11yUnitTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

/**
 * Extract full opening select tags, ignoring greater-than inside PHP short tags.
 *
 * @return list<string>
 */
function a11yExtractSelectTags(string $src): array
{
    $tags = [];
    $offset = 0;
    $len = strlen($src);
    while (($pos = stripos($src, '<select', $offset)) !== false) {
        $i = $pos + 7;
        $inPhp = false;
        $tagEnd = null;
        while ($i < $len) {
            if (!$inPhp && $i + 1 < $len && $src[$i] === '<' && $src[$i + 1] === '?') {
                $inPhp = true;
                $i += 2;
                continue;
            }
            if ($inPhp && $i + 1 < $len && $src[$i] === '?' && $src[$i + 1] === '>') {
                $inPhp = false;
                $i += 2;
                continue;
            }
            if (!$inPhp && $src[$i] === '>') {
                $tagEnd = $i;
                break;
            }
            $i++;
        }
        if ($tagEnd === null) {
            break;
        }
        $tags[] = substr($src, $pos, $tagEnd - $pos + 1);
        $offset = $tagEnd + 1;
    }

    return $tags;
}

$root = dirname(__DIR__);

$common = (string) file_get_contents($root . '/calculators_common.php');
a11yUnitTest(
    str_contains($common, 'function calculatorRenderEgfrUnitSelect'),
    'calculators_common.php musí obsahovať calculatorRenderEgfrUnitSelect.',
);
a11yUnitTest(
    str_contains($common, 'aria-label="Jednotka eGFR"'),
    'calculatorRenderEgfrUnitSelect musí pri absencii viditeľného labelu nastaviť aria-label Jednotka eGFR.',
);
a11yUnitTest(
    str_contains($common, 'id="' . '<?= htmlspecialchars($name) ?>' . '"')
        || (str_contains($common, 'htmlspecialchars($name)')
            && preg_match('/\bid\s*=\s*"<\?=\s*htmlspecialchars\(\$name\)\s*\?>"/', $common)),
    'calculatorRenderEgfrUnitSelect musí vždy nastaviť id podľa name.',
);

$companionFiles = [
    'calculator_ckdpc.php',
    'calculator_kfre.php',
    'calculator_kdigo_risk.php',
    'calculator_prevent.php',
    'calculator_ambulatory.php',
];

foreach ($companionFiles as $page) {
    $path = $root . '/' . $page;
    a11yUnitTest(is_file($path), "{$page} musí existovať.");
    $src = (string) file_get_contents($path);
    foreach (a11yExtractSelectTags($src) as $tag) {
        if (!preg_match('/\bname\s*=\s*"(uacr_unit|chol_unit)"/i', $tag, $nm)) {
            continue;
        }
        $name = strtolower($nm[1]);
        a11yUnitTest(
            (bool) preg_match('/\bid\s*=\s*"' . preg_quote($name, '/') . '"/i', $tag),
            "{$page}: select {$name} musí mať id=\"{$name}\".",
        );
        a11yUnitTest(
            (bool) preg_match('/\baria-label\s*=/i', $tag),
            "{$page}: select {$name} musí mať aria-label (companion unit bez label for).",
        );
    }
}

$notices = (string) file_get_contents($root . '/admin_content_notices.php');
a11yUnitTest(
    str_contains($notices, 'for="notice_status_<?= $id ?>"')
        && str_contains($notices, 'id="notice_status_<?= $id ?>"'),
    'admin_content_notices.php: status select musí mať label for + id viazané na notice id.',
);
a11yUnitTest(
    (bool) preg_match('/aria-label="Stav oznámenia/u', $notices),
    'admin_content_notices.php: status select musí mať aria-label.',
);

// Žiadny calculator_*.php select s name=*unit* bez id a bez aria-label.
foreach (glob($root . '/calculator_*.php') ?: [] as $file) {
    $src = (string) file_get_contents($file);
    $base = basename($file);
    foreach (a11yExtractSelectTags($src) as $tag) {
        if (!preg_match('/\bname\s*=\s*"([^"]*unit[^"]*)"/i', $tag, $nm)) {
            continue;
        }
        $hasId = (bool) preg_match('/\bid\s*=/i', $tag);
        $hasAria = (bool) preg_match('/\baria-label\s*=/i', $tag);
        $name = $nm[1];
        // Unit select s id môže byť viazaný labelom for=; bez id musí mať aria-label.
        if (!$hasId) {
            a11yUnitTest(
                $hasAria,
                "{$base}: select name=\"{$name}\" bez id musí mať aria-label.",
            );
        }
    }
}

echo "A11y unit selects: {$checks} PASS\n";
