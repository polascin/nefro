<?php
require_once 'db_config.php';

$stmt = $pdo->query('SELECT id, username, avatar_path, is_admin FROM users LIMIT 10');
$users = $stmt->fetchAll();

echo "=== Avatar Debug Info ===\n\n";
foreach ($users as $user) {
    echo "ID: " . $user['id'] . "\n";
    echo "Username: " . $user['username'] . "\n";
    echo "Avatar: " . ($user['avatar_path'] ?? 'NULL') . "\n";
    echo "Admin: " . $user['is_admin'] . "\n";
    echo "---\n";
}
?>
