<?php

declare(strict_types=1);

require_once __DIR__ . '/guard.php';
if (!isset($pdo) || !$pdo instanceof PDO) {
    throw new RuntimeException('Integration database bootstrap failed.');
}
require_once __DIR__ . '/../../backup_snapshot.php';

if (($argv[1] ?? '') === '--verify') {
    $row = $pdo->query('SELECT id, label, HEX(payload) AS payload FROM backup_fixture_view')->fetch(PDO::FETCH_ASSOC);
    if ($row !== ['id' => 1, 'label' => "Test '\\ slovenský", 'payload' => '00FF01']) {
        throw new RuntimeException('Backup roundtrip lost fixture values.');
    }
    $pdo->exec("INSERT INTO backup_fixture VALUES (2, 'second', 0x0102)");
    if ((int) $pdo->query('SELECT COUNT(*) FROM backup_fixture_audit')->fetchColumn() !== 2) {
        throw new RuntimeException('Restored trigger did not execute.');
    }
    $call = $pdo->query('CALL backup_fixture_procedure()');
    if ((int) $call->fetchColumn() !== 2) {
        throw new RuntimeException('Restored routine returned an unexpected result.');
    }
    $call->closeCursor();
    echo "Backup MariaDB: table, binary/text values, view, trigger and procedure roundtrip PASS\n";
    exit(0);
}

$pdo->exec('CREATE TABLE backup_fixture (id INT PRIMARY KEY, label TEXT, payload BLOB) ENGINE=InnoDB');
$pdo->exec('CREATE TABLE backup_fixture_audit (id INT PRIMARY KEY) ENGINE=InnoDB');
$pdo->exec('CREATE TRIGGER backup_fixture_trigger AFTER INSERT ON backup_fixture FOR EACH ROW INSERT INTO backup_fixture_audit VALUES (NEW.id)');
$pdo->exec('CREATE VIEW backup_fixture_view AS SELECT * FROM backup_fixture');
$pdo->exec('CREATE PROCEDURE backup_fixture_procedure() BEGIN SELECT COUNT(*) FROM backup_fixture; END');
$stmt = $pdo->prepare('INSERT INTO backup_fixture VALUES (1, :label, :payload)');
$stmt->execute(['label' => "Test '\\ slovenský", 'payload' => "\x00\xff\x01"]);
$stmt->closeCursor();
$pdo->setAttribute(Pdo\Mysql::ATTR_USE_BUFFERED_QUERY, false);
$path = tempnam(sys_get_temp_dir(), 'nefro-backup-roundtrip-');
try {
    $stats = backupDumpDatabase($pdo, $path, 'nefro_integration');
    if ($stats['warnings'] !== [] || $stats['triggers'] < 1 || $stats['routines'] < 1 || $stats['views'] < 1) {
        throw new RuntimeException('Backup objects missing or dump reported warnings.');
    }
    // Restore removes the fixture first, so its trigger cannot fire while rows are reloaded.
    echo "DROP VIEW backup_fixture_view;\nDROP TRIGGER backup_fixture_trigger;\nDROP PROCEDURE backup_fixture_procedure;\n";
    echo gzdecode((string) file_get_contents($path));
} finally {
    unlink($path);
}
