<?php
require_once __DIR__ . '/db_config.php';
$sql = "SELECT COUNT(*) FROM articles WHERE is_published = 1 AND (title LIKE '%eGFR%' OR excerpt LIKE '%eGFR%' OR content LIKE '%eGFR%')";
$stmt = $pdo->query($sql);
if (!$stmt) {
    var_dump($pdo->errorInfo());
    exit(1);
}
echo $stmt->fetchColumn();
