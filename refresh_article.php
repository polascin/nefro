<?php
declare(strict_types=1);
// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

// Delete old version
$pdo->exec('DELETE FROM articles WHERE slug = "optimalizacia-raasi-mra-hyperkaliemia-ckd-hf"');
echo "✓ Starý článok vymazaný\n";
