<?php
$currentUser = null;
$loggedIn = function_exists('isLoggedIn')
    ? isLoggedIn()
    : (isset($_SESSION) && !empty($_SESSION['user_id']));

if ($loggedIn && !isset($pdo)) {
    require_once __DIR__ . '/db_config.php';
}

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
    $avatarSrc = htmlspecialchars(str_replace('\\', '/', trim((string) $currentUser['avatar_path'])));
} else {
    $avatarSrc = 'img/default-avatar-light.svg';
    $isDefaultAvatar = true;
}

$firstName = $currentUser ? trim((string) ($currentUser['first_name'] ?? '')) : '';
$lastName = $currentUser ? trim((string) ($currentUser['last_name'] ?? '')) : '';
$displayFullName = ($firstName !== '' && $lastName !== '')
    ? htmlspecialchars($firstName . ' ' . $lastName)
    : '';
$displayName = $currentUser ? htmlspecialchars(($currentUser['username'] ?? '') ?: ($currentUser['email'] ?? '')) : 'Neprihlásený používateľ';
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
            <a href="profile.php" class="header-profile__profile-link">Môj profil</a>
            <?php if (!empty($currentUser['is_admin'])): ?>
                <a href="admin.php" class="header-profile__admin-link">Administrácia</a>
            <?php endif; ?>
            <form action="logout.php" method="post" class="header-profile__logout-form">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                <button type="submit" class="header-profile__logout-link">Odhlásiť sa</button>
            </form>
        <?php else: ?>
            <a href="login.php" class="header-profile__link header-profile__link--guest">
                <div class="header-profile__name"><?= $displayName ?></div>
            </a>
            <div class="header-profile__guest-note">
                Diskusia je prístupná len pre registrovaných a prihlásených používateľov.
            </div>
        <?php endif; ?>
    </div>
    <a href="<?= $profileLink ?>" class="header-profile__avatar-wrapper">
        <img src="<?= $avatarSrc ?>" id="headerAvatar" data-is-default="<?= $isDefaultAvatar ? 'true' : 'false' ?>" alt="Avatar" class="header-profile__avatar">
    </a>
</div>
