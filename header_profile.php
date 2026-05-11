<?php
$currentUser = null;
if (isLoggedIn() && isset($pdo)) {
    try {
        $stmt = $pdo->prepare("SELECT username, email, avatar_path, is_admin FROM users WHERE id = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $currentUser = $stmt->fetch();
    } catch (\PDOException $e) {
        // Ignorovať chybu pre prípad, že db nefunguje
    }
}

if (isLoggedIn() && !$currentUser) {
    // Fallback pre stránky bez DB pripojenia (napr. privacy.php)
    $currentUser = [
        'username' => $_SESSION['username'] ?? '',
        'email' => '',
        'avatar_path' => null,
        'is_admin' => !empty($_SESSION['is_admin']) ? 1 : 0,
    ];
}

$isDefaultAvatar = false;
$avatarSrc = "";
if ($currentUser && !empty($currentUser['avatar_path'])) {
    $avatarSrc = htmlspecialchars($currentUser['avatar_path']);
} else {
    $avatarSrc = 'img/default-avatar-dark.svg';
    $isDefaultAvatar = true;
}

$displayName = $currentUser ? htmlspecialchars(($currentUser['username'] ?? '') ?: ($currentUser['email'] ?? '')) : '<a href="login.php" class="header-profile__unlogged">Neprihlásený používateľ</a>';
$displayEmail = $currentUser ? htmlspecialchars($currentUser['email']) : '';
$profileLink = $currentUser ? 'profile.php' : 'login.php';
?>
<div class="header-profile">
    <div class="header-profile__info">
        <?php if ($currentUser): ?>
            <a href="<?= $profileLink ?>" class="header-profile__link">
                <div class="header-profile__name"><?= $displayName ?></div>
                <?php if ($displayEmail): ?>
                    <div class="header-profile__email"><?= $displayEmail ?></div>
                <?php endif; ?>
            </a>
            <?php if (!empty($currentUser['is_admin'])): ?>
                <a href="admin.php" class="header-profile__admin-link">Admin panel</a>
            <?php endif; ?>
            <a href="logout.php" class="header-profile__logout-link">Odhlásiť sa</a>
        <?php else: ?>
            <div class="header-profile__name"><?= $displayName ?></div>
        <?php endif; ?>
    </div>
    <a href="<?= $profileLink ?>" class="header-profile__avatar-wrapper">
        <img src="<?= $avatarSrc ?>" id="headerAvatar" data-is-default="<?= $isDefaultAvatar ? 'true' : 'false' ?>" alt="Avatar" class="header-profile__avatar">
    </a>
</div>
