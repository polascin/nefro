<?php
$currentUser = null;
$loggedIn = function_exists('isLoggedIn')
    ? isLoggedIn()
    : (isset($_SESSION) && !empty($_SESSION['user_id']));

if ($loggedIn && isset($pdo)) {
    try {
        $stmt = $pdo->prepare("SELECT username, email, first_name, last_name, avatar_path, is_admin, email_verified_at, mobile_phone, mobile_verified_at, title_before, middle_name, title_after, organization, job_function, work_mobile_phone, org_website, work_email FROM users WHERE id = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $currentUser = $stmt->fetch();
    } catch (\PDOException $e) {
        // Ignorovať chybu pre prípad, že db nefunguje
    }
}

if ($loggedIn && !$currentUser) {
    // Fallback pre stránky bez DB pripojenia (napr. privacy.php)
    $currentUser = [
        'username' => (isset($_SESSION) ? ($_SESSION['username'] ?? '') : ''),
        'email' => '',
        'first_name' => '',
        'last_name' => '',
        'avatar_path' => null,
        'is_admin' => (isset($_SESSION) && !empty($_SESSION['is_admin'])) ? 1 : 0,
        'email_verified_at' => (isset($_SESSION) && !empty($_SESSION['email_verified'])) ? date('Y-m-d H:i:s') : null,
        'mobile_phone' => null,
        'mobile_verified_at' => null,
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

$firstName = $currentUser ? trim((string) ($currentUser['first_name'] ?? '')) : '';
$lastName = $currentUser ? trim((string) ($currentUser['last_name'] ?? '')) : '';
$displayFullName = ($firstName !== '' && $lastName !== '')
    ? htmlspecialchars($firstName . ' ' . $lastName)
    : '';
$displayName = $currentUser ? htmlspecialchars(($currentUser['username'] ?? '') ?: ($currentUser['email'] ?? '')) : '<a href="login.php" class="header-profile__unlogged">Neprihlásený používateľ</a>';
$displayEmail = $currentUser ? htmlspecialchars($currentUser['email']) : '';
$emailIsVerified = $currentUser && !empty($currentUser['email_verified_at']);
$mobileIsSet = $currentUser && !empty($currentUser['mobile_phone']);
$mobileIsVerified = $mobileIsSet && !empty($currentUser['mobile_verified_at']);
$profileLink = $currentUser ? 'profile.php' : 'login.php';
?>
<div class="header-profile">
    <div class="header-profile__info">
        <?php if ($currentUser): ?>
            <a href="<?= $profileLink ?>" class="header-profile__link">
                <?php if ($displayFullName !== ''): ?>
                    <div class="header-profile__name"><?= $displayFullName ?></div>
                <?php endif; ?>
                <?php if ($displayName !== ''): ?>
                    <div class="header-profile__email"><?= $displayName ?></div>
                <?php endif; ?>
                <?php if ($displayEmail): ?>
                    <div class="header-profile__email"><?= $displayEmail ?></div>
                    <div class="header-profile__email-status <?= $emailIsVerified ? 'header-profile__email-status--verified' : 'header-profile__email-status--unverified' ?>">
                        <?= $emailIsVerified ? 'E-mail overený' : 'E-mail neoverený' ?>
                    </div>
                    <?php if ($mobileIsSet): ?>
                        <div class="header-profile__email-status <?= $mobileIsVerified ? 'header-profile__email-status--verified' : 'header-profile__email-status--unverified' ?>">
                            <?= $mobileIsVerified ? 'Mobil overený' : 'Mobil neoverený' ?>
                        </div>
                    <?php endif; ?>
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
