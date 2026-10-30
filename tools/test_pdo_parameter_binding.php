<?php

declare(strict_types=1);

/**
 * `PDOStatement::execute($params)` prepíše hodnotu KAŽDÉHO placeholdera,
 * ktorý v poli chýba — hodnota viazaná cez `bindValue()` sa nezachová.
 *
 * Konkrétny past: v `article_publisher.php` bol parameter `:is_published_set`
 * viazaný cez `bindValue()` a potom sa `execute()` volal s poľom, ktorý
 * obsahoval iba ostatné parametre. Výsledok bol `NULL` v `IF()` vetve, teda
 * `is_published = NULL` — článok by pri každej aktualizácii stav zverejnenia
 * stratil. Bez spustenia proti MySQL by sa to neprejavilo nijak.
 *
 * Test prehľadáva súbory, v ktorých sa zmenilo správanie dotazov, a kontroluje,
 * že každý placeholder viazaný cez bindValue() sa posiela aj v poli execute().
 */

$checks = 0;

function pdoParameterBindingTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

$root = dirname(__DIR__);

$files = [
    'article_publisher.php',
    'newsletter_notifications.php',
    'auth.php',
    'login.php',
    'register.php',
    'archive_cleanup.php',
    'calculators_common.php',
    'setup_db.php',
    'db_config.php',
];

/**
 * Placeholdery viazané cez bindValue() v danom bloku kódu.
 *
 * @return list<string>
 */
function boundPlaceholders(string $code): array
{
    $found = [];
    if (preg_match_all('/bindValue\(\s*[\'"]:(\w+)[\'"]/', $code, $matches) > 0) {
        $found = $matches[1];
    }

    return $found;
}

/**
 * Kľúče polí, ktoré sa posielajú do execute([...]).
 *
 * @return list<string>
 */
function executeArrayKeys(string $code): array
{
    $found = [];
    if (preg_match_all('/execute\(\s*\[(.*?)\]\s*\)/s', $code, $matches) > 0) {
        foreach ($matches[1] as $block) {
            if (preg_match_all('/[\'"](:?\w+)[\'"]\s*=>/', $block, $keyMatches) > 0) {
                foreach ($keyMatches[1] as $key) {
                    $found[] = ltrim($key, ':');
                }
            }
        }
    }

    return $found;
}

foreach ($files as $file) {
    $path = $root . '/' . $file;
    if (!is_file($path)) {
        continue;
    }

    $source = (string) file_get_contents($path);

    // Rozdelíme súbor na jednotlivé funkcie — bindValue a execute musia
    // patriať tej istej funkcii, inak by porovnanie nemalo význam.
    $functions = [];
    if (preg_match_all('/function\s+([a-zA-Z_][a-zA-Z0-9_]*)\s*\([^)]*\)[^{]*\{(.*?)\n\}/s', $source, $matches, PREG_SET_ORDER) > 0) {
        foreach ($matches as $match) {
            $functions[$match[1]] = $match[2];
        }
    }

    foreach ($functions as $name => $body) {
        $bound = boundPlaceholders($body);
        if ($bound === []) {
            continue;
        }

        // Ak sa v danej funkcii `execute()` volá bez poľa, hodnoty zostávajú
        // zachované a kontrola sa netýka.
        $executeWithArray = preg_match('/execute\(\s*\[/', $body) === 1;
        if (!$executeWithArray) {
            continue;
        }

        $keys = executeArrayKeys($body);
        foreach (array_unique($bound) as $placeholder) {
            pdoParameterBindingTest(
                in_array($placeholder, $keys, true),
                sprintf(
                    '%s: %s() viaže placeholder :%s cez bindValue(), ale neposiela ho v execute([…]) — hodnota by sa prepísala na NULL.',
                    $file,
                    $name,
                    $placeholder
                ),
            );
        }
    }
}

// ── Scanner musí chybný vzor naozaj zachytiť ───────────────────────────────
// Bez tejto kontroly by test mohol poľo stratíť schopnosť detegovať chybu
// (napríklad po zmene regulárneho výrazu) a stále by prechádzal.
$buggySample = <<<'PHP'
<?php
function ukazkovaFunkcia(PDO $pdo): void {
    $stmt = $pdo->prepare("UPDATE tabulka SET a = :a, b = :b WHERE id = :id");
    $stmt->bindValue(':b', 1, PDO::PARAM_INT);
    $stmt->execute(['a' => 2, 'id' => 3]);
}
PHP;

$sampleBound = boundPlaceholders($buggySample);
$sampleKeys = executeArrayKeys($buggySample);

pdoParameterBindingTest(
    in_array('b', $sampleBound, true),
    'Scanner musí nájsť placeholder viazaný cez bindValue() v ukážke.',
);
pdoParameterBindingTest(
    !in_array('b', $sampleKeys, true),
    'Ukážka musí obsahovať chybný vzor (placeholder chýba v poli execute()).',
);
pdoParameterBindingTest(
    in_array('a', $sampleKeys, true) && in_array('id', $sampleKeys, true),
    'Scanner musí nájsť aj kľúče poslané v poli execute().',
);

// ── Konkrétne, najcitlivejšie miesto ───────────────────────────────────────
$publisher = (string) file_get_contents($root . '/article_publisher.php');
pdoParameterBindingTest(
    str_contains($publisher, "'is_published_set' => \$isPublishedOverride === null ? 0 : 1"),
    'article_publisher.php musí posielať :is_published_set priamo v poli execute().',
);
pdoParameterBindingTest(
    !preg_match('/bindValue\(\s*[\'"]:is_published_set[\'"]/', $publisher),
    'article_publisher.php nesmie viazať :is_published_set cez bindValue() pred execute([…]).',
);

/**
 * Pomenované placeholdery v SQL. Natívny PDO (ATTR_EMULATE_PREPARES = false)
 * odmietne opakovaný názov s HY093 — rovnaká trieda chyby ako duplikát :q
 * v katalógu (PR #37).
 *
 * @return list<string>
 */
function namedPlaceholders(string $sql): array
{
    preg_match_all('/(?<!:):([a-zA-Z_][a-zA-Z_0-9]*)/', $sql, $matches);
    return $matches[1];
}

$duplicateSample = 'UPDATE t SET a = IF(x >= :window, 1, a + 1), b = IF(x >= :window, NOW(), b)';
$sampleNames = namedPlaceholders($duplicateSample);
pdoParameterBindingTest(
    $sampleNames === ['window', 'window'],
    'Scanner musí v ukážke nájsť opakovaný placeholder :window.',
);

$auth = (string) file_get_contents($root . '/auth.php');
$fnPos = strpos($auth, 'function recordFormRateLimitFailure');
pdoParameterBindingTest($fnPos !== false, 'auth.php musí obsahovať recordFormRateLimitFailure().');
$fnBody = substr($auth, $fnPos, 1600);
pdoParameterBindingTest(
    str_contains($fnBody, ':window_reset'),
    'recordFormRateLimitFailure() musí mať jedinečný placeholder :window_reset — natívny PDO neakceptuje dve :window.',
);

preg_match_all('/(?:prepare|query)\(\s*(["\'])(.*?)\1/s', $fnBody, $sqlMatches);
pdoParameterBindingTest($sqlMatches[2] !== [], 'recordFormRateLimitFailure() musí obsahovať SQL reťazce.');
foreach ($sqlMatches[2] as $sql) {
    $names = namedPlaceholders($sql);
    pdoParameterBindingTest(
        $names === [] || count($names) === count(array_unique($names)),
        'recordFormRateLimitFailure() nesmie opakovať pomenovaný placeholder (natívny PDO HY093): ' . preg_replace('/\s+/', ' ', $sql)
    );
}

echo "PDO parameter binding: $checks PASS\n";
