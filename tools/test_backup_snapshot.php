<?php

declare(strict_types=1);

require_once __DIR__ . '/../backup_snapshot.php';

$checks = 0;
function backupTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

// Identifikátor snapshotu je UTC a triediteľný.
backupTest(backupSnapshotId(0) === '19700101T000000Z', 'ID snapshotu musí byť UTC.');
backupTest(preg_match(BACKUP_SNAPSHOT_ID_PATTERN, backupSnapshotId()) === 1, 'ID snapshotu musí sedieť so vzorom.');

// SQL hodnoty: NULL, čísla, reťazce s diakritikou a úvodzovkami, binárne dáta ako hex.
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
backupTest(backupSqlValue($pdo, null) === 'NULL', 'NULL hodnota.');
backupTest(backupSqlValue($pdo, 42) === '42' && backupSqlValue($pdo, 1.5) === '1.5', 'Číselné hodnoty bez úvodzoviek.');
backupTest(backupSqlValue($pdo, "Ľubomír O'Neil") === "'Ľubomír O''Neil'", 'Reťazec s apostrofom sa escapuje.');
backupTest(backupSqlValue($pdo, "\x00\xff\xfe") === '0x00fffe', 'Binárne dáta ako hex literál.');
backupTest(backupSqlValue($pdo, '') === "''", 'Prázdny reťazec ostáva prázdny reťazec.');

// INSERT dávky: správny počet príkazov a poradie stĺpcov.
$rows = [];
for ($i = 1; $i <= 5; $i++) {
    $rows[] = ['id' => $i, 'name' => 'n' . $i, 'blob' => $i === 3 ? "\xff" : null];
}
$statements = iterator_to_array(backupInsertStatements($pdo, 'tab`le', ['id', 'name', 'blob'], $rows, 2), false);
backupTest(count($statements) === 3, 'Päť riadkov po dvoch dáva tri INSERTy.');
backupTest(str_starts_with($statements[0], 'INSERT INTO `tab``le` (`id`, `name`, `blob`) VALUES'), 'Hlavička INSERT escapuje spätné úvodzovky.');
backupTest(str_contains($statements[1], "(3, 'n3', 0xff)"), 'Binárny stĺpec v dávke je hex.');
backupTest(str_contains($statements[2], "(5, 'n5', NULL);"), 'Posledná dávka končí bodkočiarkou.');
backupTest(iterator_to_array(backupInsertStatements($pdo, 't', ['id'], [], 2), false) === [], 'Prázdna tabuľka nedáva INSERT.');

// Dump SQLite „databázy“ cez rovnaké INSERT funkcie je čitateľný späť.
$pdo->exec('CREATE TABLE t (id INTEGER PRIMARY KEY, name TEXT, data BLOB)');
$pdo->exec("INSERT INTO t VALUES (1, 'Ľ''x', X'00FF')");
$stmt = $pdo->query('SELECT * FROM t');
$sql = implode('', iterator_to_array(backupInsertStatements($pdo, 't', ['id', 'name', 'data'], $stmt->fetchAll(PDO::FETCH_ASSOC)), false));
$pdo->exec('CREATE TABLE t2 (id INTEGER PRIMARY KEY, name TEXT, data BLOB)');
$pdo->exec(str_replace('INSERT INTO `t`', 'INSERT INTO `t2`', str_replace('0x00ff', "X'00FF'", $sql)));
$restored = $pdo->query('SELECT name, hex(data) AS h FROM t2')->fetch(PDO::FETCH_ASSOC);
backupTest($restored['name'] === "Ľ'x" && $restored['h'] === '00FF', 'Dump sa dá načítať späť bez straty.');

// tar príkaz: iba existujúce bezpečné adresáre, bez shellu.
$root = sys_get_temp_dir() . '/nefro-backup-' . bin2hex(random_bytes(6));
mkdir($root . '/pdf', 0777, true);
mkdir($root . '/private/publications', 0777, true);
$tar = backupTarCommand($root, ['pdf', 'img', '../etc', 'private/publications', 'x;rm -rf /', '/pdf/'], $root . '/out.tar');
backupTest($tar['included'] === ['pdf', 'private/publications'], 'Zahrnú sa iba existujúce adresáre.');
backupTest($tar['skipped'] === ['img', '../etc', 'x;rm -rf /'], 'Neexistujúce a nebezpečné cesty sa vynechajú: ' . json_encode($tar['skipped']));
backupTest($tar['command'][0] === 'tar' && in_array('-C', $tar['command'], true) && end($tar['command']) === 'private/publications', 'tar argumenty sú pole bez shellu.');

// Retencia: neúplné snapshoty sa mažú prednostne, kompletné nad limit od najstaršieho.
$dest = $root . '/backups';
mkdir($dest);
$make = static function (string $id, ?string $result) use ($dest): void {
    mkdir($dest . '/' . $id);
    if ($result !== null) {
        file_put_contents($dest . '/' . $id . '/manifest.json', json_encode(['result' => $result]));
    }
    file_put_contents($dest . '/' . $id . '/db.sql.gz', 'x');
};
$make('20261001T030000Z', 'complete');
$make('20261002T030000Z', 'complete');
$make('20261003T030000Z', 'incomplete');
$make('20261004T030000Z', 'complete');
$make('20261005T030000Z', null);
mkdir($dest . '/cudzi-adresar');
$removed = backupPruneSnapshots($dest, 2);
sort($removed);
backupTest($removed === ['20261001T030000Z', '20261003T030000Z', '20261005T030000Z'], 'Retencia: ' . json_encode($removed));
backupTest(is_dir($dest . '/20261002T030000Z') && is_dir($dest . '/20261004T030000Z') && is_dir($dest . '/cudzi-adresar'), 'Ostatné adresáre ostávajú.');
backupTest(backupPruneSnapshots($dest, 0) === ['20261002T030000Z', '20261004T030000Z'], 'keep=0 zmaže všetky kompletné.');

// Dry run cez skutočný skript: nič nezapíše, neznámy parameter vracia 2.
$projectRoot = dirname(__DIR__);
$descriptors = [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
$run = static function (array $args) use ($projectRoot, $descriptors): array {
    $process = proc_open(array_merge([PHP_BINARY, $projectRoot . '/backup_snapshot.php'], $args), $descriptors, $pipes, $projectRoot);
    fclose($pipes[0]);
    $out = (string) stream_get_contents($pipes[1]);
    $err = (string) stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    return [proc_close($process), $out, $err];
};
[$code, $out] = $run(['--dry-run', '--dest=' . str_replace('\\', '/', $dest) . '/dry', '--paths=pdf,neexistuje']);
backupTest($code === 0 && str_contains($out, 'Dry run') && str_contains($out, 'vynechané') && !is_dir($dest . '/dry'), 'Dry run nič nezapíše: ' . $out);
[$code] = $run(['--neznamy']);
backupTest($code === 2, 'Neznámy parameter vracia kód 2.');
[$code] = $run(['--dest=../mimo', '--dry-run']);
backupTest($code === 2, 'Cesta s .. sa odmietne.');

backupRemoveDirectory($root);
backupTest(!is_dir($root), 'Upratanie dočasného koreňa.');

echo "Backup snapshot: $checks PASS\n";
