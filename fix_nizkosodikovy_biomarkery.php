<?php
if (php_sapi_name() !== 'cli') { exit; }
require_once __DIR__ . '/db_config.php';

$slug = 'nizkosodikovy-dialyzat-a-sodik-v-tkanivach-randomizovana-crossover-studia';
$stmt = $pdo->prepare('SELECT id, content FROM articles WHERE slug = :slug LIMIT 1');
$stmt->execute(['slug' => $slug]);
$row = $stmt->fetch();
if (!$row) { echo "Článok nenájdený\n"; exit; }

$find    = 'nízkosodíovým a vyšším sodíkovým dialyzátom <strong>nevykázali';
$replace = 'nízkosodíkovým a vyšším sodíkovým dialyzátom <strong>nevykázali';

if (!str_contains($row['content'], $find)) {
    echo "Text nenájdený — možno už opravené\n";
    exit;
}
$new = str_replace($find, $replace, $row['content']);
$pdo->prepare('UPDATE articles SET content = :c WHERE id = :id')
    ->execute(['c' => $new, 'id' => $row['id']]);
echo "OK: biomarkery sekcia opravená\n";
?>
