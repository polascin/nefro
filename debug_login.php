<?php
session_start();
require_once 'db_config.php';

// Simuluj prihlásenie používateľa ID 4 (polascin)
$userId = 4;
$_SESSION['user_id'] = $userId;

// Načítaj údaje
$stmt = $pdo->prepare("SELECT username, email, first_name, last_name, avatar_path, is_admin FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch();

echo "=== Logged In User Debug ===\n";
echo "Username: " . $user['username'] . "\n";
echo "Avatar Path: " . ($user['avatar_path'] ?? 'NULL') . "\n";
echo "First Name: " . ($user['first_name'] ?? 'NULL') . "\n";
echo "Last Name: " . ($user['last_name'] ?? 'NULL') . "\n";
echo "Is Admin: " . $user['is_admin'] . "\n";
echo "\n";

// Teraz načítaj ako by header_profile.php
$currentUser = $user;
$isDefaultAvatar = false;
$avatarSrc = "";
if ($currentUser && !empty($currentUser['avatar_path'])) {
    $avatarSrc = htmlspecialchars(str_replace('\\', '/', trim((string) $currentUser['avatar_path'])));
} else {
    $avatarSrc = 'img/default-avatar-light.svg';
    $isDefaultAvatar = true;
}

echo "Avatar Src: " . $avatarSrc . "\n";
echo "Is Default Avatar: " . ($isDefaultAvatar ? 'true' : 'false') . "\n";
echo "\n";
echo "HTML Output would be:\n";
echo '<img src="' . $avatarSrc . '" id="headerAvatar" data-is-default="' . ($isDefaultAvatar ? 'true' : 'false') . '" alt="Avatar" class="header-profile__avatar">';
?>
