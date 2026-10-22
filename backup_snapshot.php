<?php

declare(strict_types=1);
/**
 * backup_snapshot.php — aplikačná záloha s transakčným snapshotom DB (CLI, cron).
 *
 * Skúška obnovy z 18. 10. 2026 ukázala, že záloha DB poskytovateľa (03:21)
 * a súborová záloha z predchádzajúceho dňa netvoria spoločný bod obnovy:
 * chýbalo 5 PDF a 5 ilustrácií. Tento skript vytvorí v jednom behu
 *   1. SQL dump databázy v jednej transakcii s konzistentným snapshotom
 *      (tabuľky, pohľady, triggery, procedúry, udalosti),
 *   2. tar archív súborových adresárov, ktoré nie sú v gite (pdf, img, uploads,
 *      private/publications) — po dumpe; spoločný časový bod vyžaduje zastavenie všetkých zápisov,
 *   3. manifest s počtami riadkov a SHA-256 všetkých výstupov,
 * a odstráni staršie snapshoty nad limit retencie.
 *
 * Záloha sa ukladá do private/backups/<UTC-čas>/ (mimo verejného prístupu,
 * `private/` je v .htaccess odmietnuté). Nenahrádza zálohu poskytovateľa,
 * spoločná konzistencia DB a súborov sa musí overiť pri obnove. Obnova a jej overenie:
 * tools/restore/README.md.
 *
 * Použitie:
 *   php backup_snapshot.php [--dest=private/backups] [--paths=pdf,img,uploads,private/publications]
 *                           [--keep=2] [--skip-db] [--skip-files] [--dry-run]
 *
 * Príklad cron jobu (denne o 03:40, po zálohe poskytovateľa):
 *   40 3 * * * /usr/bin/php /path/to/nefro/backup_snapshot.php >> /path/to/nefro/private/backup_snapshot_cron.log 2>&1
 *
 * Návratový kód 0 = snapshot kompletný, 1 = chyba (neúplný snapshot sa označí
 * v manifeste a nepočíta sa do retencie ako platný).
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý. Tento skript je dostupný iba z príkazového riadku.\n");
}

const BACKUP_SNAPSHOT_DEFAULT_PATHS = ['pdf', 'img', 'uploads', 'private/publications'];
const BACKUP_SNAPSHOT_ID_PATTERN = '/^\d{8}T\d{6}Z$/';
const BACKUP_SNAPSHOT_INSERT_BATCH = 200;

function backupSnapshotId(?int $time = null): string
{
    return gmdate('Ymd\THis\Z', $time ?? time());
}

/**
 * Hodnota do SQL: NULL, číslo alebo reťazec; binárne (ne-UTF-8) dáta ako hex literál.
 */
function backupSqlValue(PDO $pdo, mixed $value): string
{
    if ($value === null) {
        return 'NULL';
    }
    if (is_int($value) || is_float($value)) {
        return (string) $value;
    }
    if (is_bool($value)) {
        return $value ? '1' : '0';
    }
    $string = (string) $value;
    if ($string !== '' && !mb_check_encoding($string, 'UTF-8')) {
        return '0x' . bin2hex($string);
    }
    return $pdo->quote($string);
}

/**
 * INSERT príkazy po dávkach; stĺpce sú v spätných úvodzovkách.
 *
 * @param list<string> $columns
 * @param iterable<array<string, mixed>> $rows
 * @return Generator<string>
 */
function backupInsertStatements(PDO $pdo, string $table, array $columns, iterable $rows, int $batch = BACKUP_SNAPSHOT_INSERT_BATCH): Generator
{
    $quotedColumns = implode(', ', array_map(static fn (string $c): string => '`' . str_replace('`', '``', $c) . '`', $columns));
    $head = 'INSERT INTO `' . str_replace('`', '``', $table) . '` (' . $quotedColumns . ') VALUES';
    $buffer = [];
    foreach ($rows as $row) {
        $values = [];
        foreach ($columns as $column) {
            $values[] = backupSqlValue($pdo, $row[$column] ?? null);
        }
        $buffer[] = '(' . implode(', ', $values) . ')';
        if (count($buffer) >= $batch) {
            yield $head . "\n" . implode(",\n", $buffer) . ";\n";
            $buffer = [];
        }
    }
    if ($buffer !== []) {
        yield $head . "\n" . implode(",\n", $buffer) . ";\n";
    }
}

/**
 * Argumenty pre systémový tar (bez shellu). Adresáre, ktoré neexistujú, sa vynechajú.
 *
 * @param list<string> $paths relatívne k $root
 * @return array{command: list<string>, included: list<string>, skipped: list<string>}
 */
function backupTarCommand(string $root, array $paths, string $archive): array
{
    $included = [];
    $skipped = [];
    foreach ($paths as $path) {
        $clean = trim(str_replace('\\', '/', $path), '/');
        if ($clean === '' || str_contains($clean, '..') || preg_match('~^[A-Za-z0-9_./-]+$~D', $clean) !== 1) {
            $skipped[] = $path;
            continue;
        }
        if (in_array($clean, $included, true)) {
            continue;
        }
        if (!str_starts_with($clean, '-') && is_dir($root . '/' . $clean) && !is_link($root . '/' . $clean)) {
            $included[] = $clean;
        } else {
            $skipped[] = $clean;
        }
    }
    $command = ['tar', '--exclude=*/.tmp', '--exclude=*/.tmp/*', '-cf', $archive, '-C', $root];
    return ['command' => array_merge($command, $included), 'included' => $included, 'skipped' => $skipped];
}

/**
 * Odstráni najstaršie snapshoty nad limit. Vracia zmazané ID. Neúplné
 * snapshoty (bez manifest.json alebo s result != complete) sa mažú prednostne.
 *
 * @return list<string>
 */
function backupPruneSnapshots(string $dest, int $keep): array
{
    $complete = [];
    $incomplete = [];
    foreach (scandir($dest) ?: [] as $entry) {
        if (preg_match(BACKUP_SNAPSHOT_ID_PATTERN, $entry) !== 1 || !is_dir($dest . '/' . $entry) || is_link($dest . '/' . $entry)) {
            continue;
        }
        $manifest = $dest . '/' . $entry . '/manifest.json';
        $data = is_file($manifest) ? json_decode((string) file_get_contents($manifest), true) : null;
        if (is_array($data) && ($data['result'] ?? '') === 'complete') {
            $complete[] = $entry;
        } else {
            $incomplete[] = $entry;
        }
    }
    sort($complete);
    sort($incomplete);
    $remove = $incomplete;
    $excess = count($complete) - max(0, $keep);
    if ($excess > 0) {
        $remove = array_merge($remove, array_slice($complete, 0, $excess));
    }
    foreach ($remove as $id) {
        backupRemoveDirectory($dest . '/' . $id);
    }
    return $remove;
}

function backupRemoveDirectory(string $dir): void
{
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($iterator as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }
    rmdir($dir);
}

/**
 * Dump MariaDB/MySQL databázy do gzip súboru v jednej konzistentnej transakcii.
 *
 * @return array{tables: array<string, int>, views: int, triggers: int, routines: int, events: int, warnings: list<string>}
 */
function backupDumpDatabase(PDO $pdo, string $gzPath, string $dbName): array
{
    $gz = gzopen($gzPath, 'wb6');
    if ($gz === false) {
        throw new RuntimeException('Nedá sa otvoriť výstup dumpu.');
    }
    $write = static function (string $sql) use ($gz): void {
        if (gzwrite($gz, $sql) === false) {
            throw new RuntimeException('Zápis dumpu zlyhal.');
        }
    };
    $stats = ['tables' => [], 'views' => 0, 'triggers' => 0, 'routines' => 0, 'events' => 0, 'warnings' => []];

    $pdo->exec('SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ');
    $pdo->exec('START TRANSACTION WITH CONSISTENT SNAPSHOT');
    try {
        $write("-- Nefro backup_snapshot " . backupSnapshotId() . " (konzistentný snapshot)\n");
        $write("SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\nSET UNIQUE_CHECKS=0;\nSET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n\n");

        $tables = [];
        $views = [];
        foreach ($pdo->query('SHOW FULL TABLES')->fetchAll(PDO::FETCH_NUM) as $row) {
            if (strtoupper((string) $row[1]) === 'VIEW') {
                $views[] = (string) $row[0];
            } else {
                $tables[] = (string) $row[0];
            }
        }

        foreach ($tables as $table) {
            $quoted = '`' . str_replace('`', '``', $table) . '`';
            $createStmt = $pdo->query('SHOW CREATE TABLE ' . $quoted);
            $create = $createStmt->fetch(PDO::FETCH_NUM);
            $createStmt->closeCursor();
            $write("DROP TABLE IF EXISTS {$quoted};\n" . (string) ($create[1] ?? '') . ";\n");
            $stmt = $pdo->query('SELECT * FROM ' . $quoted);
            $columns = [];
            for ($i = 0; $i < $stmt->columnCount(); $i++) {
                $columns[] = (string) ($stmt->getColumnMeta($i)['name'] ?? ('c' . $i));
            }
            $count = 0;
            $rows = (static function () use ($stmt, &$count): Generator {
                while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                    ++$count;
                    yield $row;
                }
            })();
            foreach (backupInsertStatements($pdo, $table, $columns, $rows) as $insert) {
                $write($insert);
            }
            $write("\n");
            $stmt->closeCursor();
            $stats['tables'][$table] = $count;
        }

        foreach ($views as $view) {
            $quoted = '`' . str_replace('`', '``', $view) . '`';
            try {
                $createStmt = $pdo->query('SHOW CREATE VIEW ' . $quoted);
                $create = $createStmt->fetch(PDO::FETCH_NUM);
                $createStmt->closeCursor();
                $write("DROP VIEW IF EXISTS {$quoted};\n" . (string) ($create[1] ?? '') . ";\n\n");
                $stats['views']++;
            } catch (PDOException $e) {
                $stats['warnings'][] = "pohľad {$view}: " . $e->getMessage();
            }
        }

        foreach ([
            ['SHOW TRIGGERS', 'Trigger', 'SHOW CREATE TRIGGER', 2, 'triggers'],
            ['SHOW PROCEDURE STATUS WHERE Db = ' . $pdo->quote($dbName), 'Name', 'SHOW CREATE PROCEDURE', 2, 'routines'],
            ['SHOW FUNCTION STATUS WHERE Db = ' . $pdo->quote($dbName), 'Name', 'SHOW CREATE FUNCTION', 2, 'routines'],
            ['SHOW EVENTS', 'Name', 'SHOW CREATE EVENT', 3, 'events'],
        ] as [$listSql, $nameColumn, $createSql, $createIndex, $statKey]) {
            try {
                foreach ($pdo->query($listSql)->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    $name = (string) ($row[$nameColumn] ?? '');
                    if ($name === '') {
                        continue;
                    }
                    $createStmt = $pdo->query($createSql . ' `' . str_replace('`', '``', $name) . '`');
                    $create = $createStmt->fetch(PDO::FETCH_NUM);
                    $createStmt->closeCursor();
                    $definition = (string) ($create[$createIndex] ?? '');
                    if ($definition !== '') {
                        $write("DELIMITER ;;\n" . $definition . ";;\nDELIMITER ;\n\n");
                        $stats[$statKey]++;
                    } else {
                        throw new RuntimeException('Prázdna definícia objektu databázy.');
                    }
                }
            } catch (PDOException $e) {
                $stats['warnings'][] = $listSql . ': ' . $e->getMessage();
            }
        }

        $write("SET FOREIGN_KEY_CHECKS=1;\nSET UNIQUE_CHECKS=1;\n");
    } finally {
        $pdo->exec('ROLLBACK');
        gzclose($gz);
    }
    return $stats;
}

function backupSnapshotMain(array $argv): int
{
    $root = __DIR__;
    $dest = $root . '/private/backups';
    $paths = BACKUP_SNAPSHOT_DEFAULT_PATHS;
    $keep = 2;
    $skipDb = false;
    $skipFiles = false;
    $dryRun = false;
    foreach (array_slice($argv, 1) as $arg) {
        if (preg_match('~^--dest=([A-Za-z0-9_./:\\\\-]+)$~', $arg, $m) === 1 && !str_contains($m[1], '..')) {
            $target = str_replace('\\', '/', $m[1]);
            $dest = preg_match('~^(?:/|[A-Za-z]:/)~', $target) === 1 ? $target : $root . '/' . $target;
        } elseif (preg_match('~^--paths=([A-Za-z0-9_./,-]+)$~', $arg, $m) === 1) {
            $paths = array_values(array_filter(array_map('trim', explode(',', $m[1]))));
        } elseif (preg_match('/^--keep=(\d{1,3})$/', $arg, $m) === 1) {
            $keep = max(1, (int) $m[1]);
        } elseif ($arg === '--skip-db') {
            $skipDb = true;
        } elseif ($arg === '--skip-files') {
            $skipFiles = true;
        } elseif ($arg === '--dry-run') {
            $dryRun = true;
        } else {
            fwrite(STDERR, "Neznámy parameter: {$arg}\n");
            return 2;
        }
    }

    $id = backupSnapshotId();
    $dir = $dest . '/' . $id;
    $tar = backupTarCommand($root, $paths, $dir . '/files.tar');
    echo "Nefro backup snapshot {$id}\n";
    echo 'Cieľ: ', $dir, "\n";
    echo 'Súbory: ', $tar['included'] === [] ? '(žiadne)' : implode(', ', $tar['included']), "\n";
    foreach ($tar['skipped'] as $skipped) {
        echo "  vynechané (neexistuje alebo neplatné): {$skipped}\n";
    }
    if ($dryRun) {
        echo "Dry run — nič sa nezapísalo.\n";
        return 0;
    }

    if (!is_dir($dest) && !@mkdir($dest, 0700, true) && !is_dir($dest)) {
        fwrite(STDERR, "Cieľový adresár sa nedá vytvoriť.\n");
        return 1;
    }
    $lock = fopen($dest . '/.snapshot.lock', 'c');
    if ($lock === false || !flock($lock, LOCK_EX | LOCK_NB)) {
        fwrite(STDERR, "Iná záloha už beží alebo zámok nie je dostupný.\n");
        return 1;
    }
    try {
        if (!@mkdir($dir, 0700)) {
            fwrite(STDERR, "Adresár snapshotu sa nedá vytvoriť.\n");
            return 1;
        }

        $manifest = [
            'id' => $id,
            'started_utc' => gmdate('c'),
            'result' => 'incomplete',
            'db' => null,
            'files' => null,
            'sha256' => [],
            'warnings' => [],
            'consistency' => 'unverified_db_and_files_are_captured_sequentially',
        ];
        $failed = $skipDb || $skipFiles || $tar['skipped'] !== [] || $tar['included'] === [];
        if ($failed) {
            $manifest['warnings'][] = 'Niektoré požadované časti zálohy chýbajú alebo boli vynechané.';
        }

        if (!$skipDb) {
            try {
                require_once $root . '/config_loader.php';
                $env = loadAppConfig();
                $dbName = (string) ($env['DB_NAME'] ?? '');
                $pdo = new PDO('mysql:host=' . (string) ($env['DB_HOST'] ?? '') . ';dbname=' . $dbName . ';charset=utf8mb4', (string) ($env['DB_USER'] ?? ''), (string) ($env['DB_PASS'] ?? ''), [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    Pdo\Mysql::ATTR_USE_BUFFERED_QUERY => false,
                ]);
                $dbStats = backupDumpDatabase($pdo, $dir . '/db.sql.gz', $dbName);
                $manifest['db'] = [
                    'file' => 'db.sql.gz',
                    'bytes' => filesize($dir . '/db.sql.gz'),
                    'tables' => $dbStats['tables'],
                    'rows_total' => array_sum($dbStats['tables']),
                    'views' => $dbStats['views'],
                    'triggers' => $dbStats['triggers'],
                    'routines' => $dbStats['routines'],
                    'events' => $dbStats['events'],
                ];
                $manifest['warnings'] = array_merge($manifest['warnings'], $dbStats['warnings']);
                if ($dbStats['warnings'] !== []) {
                    $failed = true;
                }
                echo sprintf("DB: %d tabuliek, %d riadkov, %d B\n", count($dbStats['tables']), array_sum($dbStats['tables']), (int) $manifest['db']['bytes']);
            } catch (\Throwable $e) {
                $failed = true;
                $manifest['warnings'][] = 'DB dump zlyhal: ' . get_class($e) . ' — ' . preg_replace('/\s+/', ' ', $e->getMessage());
                fwrite(STDERR, "DB dump zlyhal: " . $e->getMessage() . "\n");
            }
        }

        if (!$skipFiles && $tar['included'] !== []) {
            $process = proc_open($tar['command'], [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, $root);
            if (!is_resource($process)) {
                $failed = true;
                $manifest['warnings'][] = 'tar sa nedá spustiť.';
            } else {
                fclose($pipes[0]);
                stream_get_contents($pipes[1]);
                $stderr = (string) stream_get_contents($pipes[2]);
                fclose($pipes[1]);
                fclose($pipes[2]);
                $code = proc_close($process);
                if ($code !== 0 || !is_file($dir . '/files.tar')) {
                    $failed = true;
                    $manifest['warnings'][] = 'tar skončil kódom ' . $code . ': ' . trim(preg_replace('/\s+/', ' ', $stderr) ?? '');
                    fwrite(STDERR, "tar zlyhal (kód {$code}).\n");
                } else {
                    $manifest['files'] = ['file' => 'files.tar', 'bytes' => filesize($dir . '/files.tar'), 'paths' => $tar['included'], 'skipped' => $tar['skipped']];
                    echo sprintf("Súbory: %s, %d B\n", implode(', ', $tar['included']), (int) $manifest['files']['bytes']);
                }
            }
        } elseif (!$skipFiles) {
            $manifest['warnings'][] = 'Žiadny z požadovaných adresárov neexistuje; súborová časť vynechaná.';
        }

        foreach (['db.sql.gz', 'files.tar'] as $file) {
            if (is_file($dir . '/' . $file)) {
                $manifest['sha256'][$file] = hash_file('sha256', $dir . '/' . $file);
            }
        }
        $manifest['finished_utc'] = gmdate('c');
        $manifest['result'] = $failed ? 'incomplete' : 'complete';
        if (file_put_contents($dir . '/manifest.json', json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) . "\n") === false) {
            throw new RuntimeException('Zápis manifestu zlyhal.');
        }
        $sums = '';
        foreach ($manifest['sha256'] as $file => $hash) {
            $sums .= $hash . '  ' . $file . "\n";
        }
        if (file_put_contents($dir . '/SHA256SUMS', $sums) === false) {
            throw new RuntimeException('Zápis kontrolných súčtov zlyhal.');
        }

        $removed = $failed ? [] : backupPruneSnapshots($dest, $keep);
        foreach ($removed as $old) {
            echo "Odstránený starší snapshot: {$old}\n";
        }
        echo 'RESULT: ', $manifest['result'], "\n";
        return $failed ? 1 : 0;
    } finally {
        flock($lock, LOCK_UN);
        fclose($lock);
    }
}

if (realpath((string) ($_SERVER['SCRIPT_FILENAME'] ?? '')) === __FILE__) {
    exit(backupSnapshotMain(isset($_SERVER['argv']) && is_array($_SERVER['argv']) ? $_SERVER['argv'] : []));
}
