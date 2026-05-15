<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'avatar_upload.php';
require_once 'phone_utils.php';
require_once 'mobile_verification.php';

requireLogin();

$user_id = $_SESSION['user_id'];
$errors = [];
$success = false;
$mobileVerificationNotice = null;

$isLocalDev = isAppLocalDev();

// Načítanie aktuálnych údajov
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();

if (!$user) {
    // Používateľ nebol nájdený, mal by byť odhlásený
    header("Location: logout.php");
    exit;
}

$normalizeValue = function ($value) {
    if ($value === '') {
        return null;
    }
    return $value;
};

$deleteAvatarFile = function (?string $relativePath): void {
    if (empty($relativePath)) {
        return;
    }

    $uploadsRoot = realpath(__DIR__ . '/uploads/avatars');
    if ($uploadsRoot === false) {
        return;
    }

    $candidate = realpath(__DIR__ . '/' . ltrim($relativePath, '/\\'));
    if ($candidate === false) {
        return;
    }

    if (!str_starts_with($candidate, $uploadsRoot . DIRECTORY_SEPARATOR)) {
        return;
    }

    if (is_file($candidate)) {
        @unlink($candidate);
    }
};

$archiveAvatarVersion = function (int $userId, string $action, ?string $originalPath, ?string $replacementPath) use ($pdo): void {
    if (empty($originalPath)) {
        return;
    }

    $uploadsRoot = realpath(__DIR__ . '/uploads/avatars');
    $originalAbsolute = realpath(__DIR__ . '/' . ltrim($originalPath, '/\\'));

    $archivedPath = null;
    if ($uploadsRoot !== false && $originalAbsolute !== false && str_starts_with($originalAbsolute, $uploadsRoot . DIRECTORY_SEPARATOR) && is_file($originalAbsolute)) {
        $archiveDirAbsolute = __DIR__ . '/uploads/avatars/archive/' . $userId;
        if (!is_dir($archiveDirAbsolute)) {
            mkdir($archiveDirAbsolute, 0755, true);
        }

        if (is_dir($archiveDirAbsolute)) {
            $safeBaseName = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($originalPath));
            $archiveFileName = date('Ymd_His') . '_' . $action . '_' . $safeBaseName;
            $archiveAbsolute = $archiveDirAbsolute . '/' . $archiveFileName;

            if (@copy($originalAbsolute, $archiveAbsolute)) {
                $archivedPath = 'uploads/avatars/archive/' . $userId . '/' . $archiveFileName;
            }
        }
    }

    $archiveStmt = $pdo->prepare("INSERT INTO users_avatar_archive (user_id, action, original_path, archived_path, replacement_path) VALUES (:user_id, :action, :original_path, :archived_path, :replacement_path)");
    $archiveStmt->execute([
        'user_id' => $userId,
        'action' => $action,
        'original_path' => $originalPath,
        'archived_path' => $archivedPath,
        'replacement_path' => $replacementPath,
    ]);
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedCsrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($postedCsrfToken)) {
        $errors[] = "Neplatný CSRF token. Skúste to znova.";

        if ($isLocalDev) {
            $sessionTokenPresent = !empty($_SESSION['csrf_token']);
            $postTokenPresent = !empty($postedCsrfToken);
            $csrfReason = !$postTokenPresent
                ? 'Vo formulári chýba CSRF token.'
                : (!$sessionTokenPresent
                    ? 'V relácii chýba CSRF token (pravdepodobne problém so session cookie alebo stará otvorená karta).'
                    : 'Token vo formulári sa nezhoduje s tokenom v relácii.');

            $errors[] = "[DEV diagnostika] CSRF zlyhanie: " . $csrfReason;
        }
    } else {
        // Zber polí
        $fields = [
            'username', 'gender', 'pronouns', 'title_before', 'first_name', 
            'middle_name', 'last_name', 'title_after', 'name_note', 
            'organization', 'job_function', 'work_mobile_phone', 'org_website', 
            'work_email', 'mobile_phone', 'other_phone', 'social_linkedin', 
            'social_x', 'social_facebook', 'social_instagram', 'social_other', 
            'other_contact', 'website', 'birth_date', 'street', 'house_number', 
            'orientation_number', 'zip_code', 'city', 'district', 'region', 'country', 'address_note'
        ];
        
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = trim($_POST[$field] ?? '');
            if ($data[$field] === '') {
                $data[$field] = null;
            }
        }

        $normalizedMobilePhone = normalizeUserMobilePhone($_POST['mobile_phone'] ?? null);
        if ($normalizedMobilePhone === false) {
            $errors[] = "Zadajte platné číslo súkromného mobilného telefónu vo formáte +421XXXXXXXXX (môžete použiť aj medzery).";
        } else {
            $data['mobile_phone'] = $normalizedMobilePhone;
        }

        $normalizedWorkMobilePhone = normalizeUserMobilePhone($_POST['work_mobile_phone'] ?? null);
        if ($normalizedWorkMobilePhone === false) {
            $errors[] = "Zadajte platné číslo pracovného mobilného telefónu vo formáte +421XXXXXXXXX (môžete použiť aj medzery).";
        } else {
            $data['work_mobile_phone'] = $normalizedWorkMobilePhone;
        }

        $normalizedOtherPhone = normalizeGenericPhone($_POST['other_phone'] ?? null);
        if ($normalizedOtherPhone === false) {
            $errors[] = "Zadajte platné iné telefónne číslo v medzinárodnom formáte +XXXXXXXX (môžete použiť aj medzery).";
        } else {
            $data['other_phone'] = $normalizedOtherPhone;
        }

        $mobileVerificationAction = trim((string) ($_POST['mobile_verification_action'] ?? ''));
        $requestedMobileCode = trim((string) ($_POST['mobile_verification_code'] ?? ''));

        $existingMobilePhone = trim((string) ($user['mobile_phone'] ?? ''));
        $existingMobilePhone = $existingMobilePhone === '' ? null : $existingMobilePhone;
        $mobilePhoneChanged = $existingMobilePhone !== ($data['mobile_phone'] ?? null);

        $mobileVerifiedAt = $user['mobile_verified_at'] ?? null;
        $mobileVerificationCodeHash = $user['mobile_verification_code_hash'] ?? null;
        $mobileVerificationExpiresAt = $user['mobile_verification_expires_at'] ?? null;
        $mobileVerificationSentAt = $user['mobile_verification_sent_at'] ?? null;

        if ($mobilePhoneChanged) {
            $mobileVerifiedAt = null;
            $mobileVerificationCodeHash = null;
            $mobileVerificationExpiresAt = null;
            $mobileVerificationSentAt = null;
        }

        if ($mobileVerificationAction === 'send') {
            if (empty($data['mobile_phone'])) {
                $errors[] = "Najprv zadajte číslo súkromného mobilného telefónu, ktoré chcete overiť.";
            } elseif (!$mobilePhoneChanged && !isMobileResendAllowed($mobileVerificationSentAt, 60)) {
                $errors[] = "Overovací SMS kód bol odoslaný nedávno. Skúste to znova o chvíľu.";
            } else {
                $usingExternalProvider = isExternalMobileVerificationProvider();

                $tokenData = null;
                if (!$usingExternalProvider) {
                    $tokenData = generateMobileVerificationCode();
                }

                $sent = sendMobileVerificationCode(
                    (string) $data['mobile_phone'],
                    $tokenData['code'] ?? null
                );

                if ($sent) {
                    $mobileVerifiedAt = null;
                    $mobileVerificationCodeHash = $usingExternalProvider ? null : ($tokenData['code_hash'] ?? null);
                    $mobileVerificationExpiresAt = $usingExternalProvider
                        ? date('Y-m-d H:i:s', time() + 600)
                        : ($tokenData['expires_at'] ?? null);
                    $mobileVerificationSentAt = date('Y-m-d H:i:s');
                    $mobileVerificationNotice = 'Overovací SMS kód bol odoslaný. Platnosť kódu je 10 minút.';

                    if ($isLocalDev && !$usingExternalProvider && isset($tokenData['code'])) {
                        $mobileVerificationNotice .= ' [DEV] Kód: ' . $tokenData['code'];
                    }
                } else {
                    $errors[] = "Overovací SMS kód sa nepodarilo odoslať. Skúste to znova neskôr.";
                }
            }
        } elseif ($mobileVerificationAction === 'verify') {
            $verificationStatus = verifyMobileCodeByProvider([
                'mobile_verified_at' => $mobileVerifiedAt,
                'mobile_verification_code_hash' => $mobileVerificationCodeHash,
                'mobile_verification_expires_at' => $mobileVerificationExpiresAt,
            ], (string) ($data['mobile_phone'] ?? ''), $requestedMobileCode);

            if ($verificationStatus === 'ok') {
                $mobileVerifiedAt = date('Y-m-d H:i:s');
                $mobileVerificationCodeHash = null;
                $mobileVerificationExpiresAt = null;
                $mobileVerificationSentAt = null;
                $mobileVerificationNotice = 'Mobilné číslo bolo úspešne overené.';
            } elseif ($verificationStatus === 'already_verified') {
                $mobileVerificationNotice = 'Mobilné číslo je už overené.';
            } elseif ($verificationStatus === 'missing_code') {
                $errors[] = 'Overovací kód nie je dostupný. Najprv požiadajte o zaslanie SMS kódu.';
            } elseif ($verificationStatus === 'expired') {
                $errors[] = 'Platnosť overovacieho SMS kódu vypršala. Požiadajte o nový kód.';
            } elseif ($verificationStatus === 'provider_error') {
                $errors[] = 'Overenie mobilného čísla je dočasne nedostupné. Skúste to prosím neskôr.';
            } else {
                $errors[] = 'Neplatný overovací SMS kód.';
            }
        }

        // Validácia dátumu narodenia
        if (!empty($data['birth_date'])) {
            $bd = DateTime::createFromFormat('Y-m-d', $data['birth_date']);
            if (!$bd || $bd->format('Y-m-d') !== $data['birth_date']) {
                $errors[] = "Neplatný dátum narodenia.";
                $data['birth_date'] = null;
            }
        }
        $data['newsletter_consent'] = isset($_POST['newsletter_consent']) ? 1 : 0;
        
        // Zmena hesla
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $new_password_confirm = $_POST['new_password_confirm'] ?? '';
        
        $password_query = "";
        $password_params = [];
        
        if (!empty($current_password) || !empty($new_password) || !empty($new_password_confirm)) {
            if (!password_verify($current_password, $user['password_hash'])) {
                $errors[] = "Súčasné heslo nie je správne.";
            } elseif (strlen($new_password) < 8 || strlen($new_password) > 1024 || !preg_match('/[A-Z]/', $new_password) || !preg_match('/[a-z]/', $new_password) || !preg_match('/[0-9]/', $new_password)) {
                $errors[] = "Nové heslo musí mať 8–1024 znakov, obsahovať aspoň jedno veľké písmeno, malé písmeno a číslicu.";
            } elseif ($new_password !== $new_password_confirm) {
                $errors[] = "Nové heslá sa nezhodujú.";
            } else {
                $password_query = ", password_hash = :password_hash";
                $password_params['password_hash'] = password_hash($new_password, PASSWORD_DEFAULT);
            }
        }

        // Upload avatara
        $avatar_path = $user['avatar_path'];
        $removeAvatar = isset($_POST['remove_avatar']) && $_POST['remove_avatar'] === '1';
        $hasNewAvatarUpload = isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK;

        $avatarAction = null;
        $newUploadedAvatarPath = null;

        if (empty($errors) && $removeAvatar && !$hasNewAvatarUpload) {
            if (!empty($avatar_path)) {
                $avatarAction = 'deleted';
            }
            $avatar_path = null;
        }

        if (empty($errors) && $hasNewAvatarUpload) {
            $avatarUploadResult = processAvatarUpload($_FILES['avatar']);
            if (!empty($avatarUploadResult['error'])) {
                $errors[] = $avatarUploadResult['error'];
            } else {
                $newUploadedAvatarPath = $avatarUploadResult['path'];
                if (!empty($avatar_path)) {
                    $avatarAction = 'updated';
                }
                $avatar_path = $newUploadedAvatarPath;
            }
        }
        
        if (empty($errors)) {
            try {
                $sql = "UPDATE users SET 
                    username = :username, gender = :gender, pronouns = :pronouns, 
                    title_before = :title_before, first_name = :first_name, 
                    middle_name = :middle_name, last_name = :last_name, 
                    title_after = :title_after, name_note = :name_note, 
                    organization = :organization, job_function = :job_function, 
                    work_mobile_phone = :work_mobile_phone, org_website = :org_website, 
                    work_email = :work_email, mobile_phone = :mobile_phone, 
                    other_phone = :other_phone, social_linkedin = :social_linkedin, 
                    social_x = :social_x, social_facebook = :social_facebook, 
                    social_instagram = :social_instagram, social_other = :social_other, 
                    other_contact = :other_contact, website = :website, 
                    birth_date = :birth_date, street = :street, house_number = :house_number, 
                    orientation_number = :orientation_number, zip_code = :zip_code, 
                    city = :city, district = :district, region = :region, country = :country, 
                    address_note = :address_note, newsletter_consent = :newsletter_consent,
                    avatar_path = :avatar_path,
                    mobile_verified_at = :mobile_verified_at,
                    mobile_verification_code_hash = :mobile_verification_code_hash,
                    mobile_verification_expires_at = :mobile_verification_expires_at,
                    mobile_verification_sent_at = :mobile_verification_sent_at
                    $password_query
                    WHERE id = :id";
                
                $params = $data;
                $params['avatar_path'] = $avatar_path;
                $params['mobile_verified_at'] = $mobileVerifiedAt;
                $params['mobile_verification_code_hash'] = $mobileVerificationCodeHash;
                $params['mobile_verification_expires_at'] = $mobileVerificationExpiresAt;
                $params['mobile_verification_sent_at'] = $mobileVerificationSentAt;
                $params['id'] = $user_id;
                $params = array_merge($params, $password_params);

                $changedFields = [];
                $trackedFields = array_merge(array_keys($data), [
                    'avatar_path',
                    'mobile_verified_at',
                    'mobile_verification_code_hash',
                    'mobile_verification_expires_at',
                    'mobile_verification_sent_at',
                ]);
                foreach ($trackedFields as $field) {
                    $oldValue = $normalizeValue($user[$field] ?? null);
                    $newValue = $normalizeValue($params[$field] ?? null);
                    if ($oldValue !== $newValue) {
                        $changedFields[] = $field;
                    }
                }

                if (!empty($password_params)) {
                    $changedFields[] = 'password_hash';
                }

                if (empty($changedFields)) {
                    $success = true;
                } else {
                    $pdo->beginTransaction();

                    $historyStmt = $pdo->prepare("INSERT INTO users_profile_archive (user_id, changed_fields, previous_data) VALUES (:user_id, :changed_fields, :previous_data)");
                    $historyStmt->execute([
                        'user_id' => $user_id,
                        'changed_fields' => json_encode(array_values(array_unique($changedFields)), JSON_UNESCAPED_UNICODE),
                        'previous_data' => json_encode($user, JSON_UNESCAPED_UNICODE),
                    ]);

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);

                    $oldAvatarPath = $user['avatar_path'] ?? null;
                    $avatarChanged = $oldAvatarPath !== $avatar_path;
                    if ($avatarChanged && !empty($oldAvatarPath) && ($avatarAction === 'updated' || $avatarAction === 'deleted')) {
                        $archiveAvatarVersion($user_id, $avatarAction, $oldAvatarPath, $avatar_path);
                        $deleteAvatarFile($oldAvatarPath);
                    }

                    $pdo->commit();
                    $success = true;
                }

                if (!$success && !empty($newUploadedAvatarPath)) {
                    $deleteAvatarFile($newUploadedAvatarPath);
                }
                
                if (!empty($data['username'])) {
                    $_SESSION['username'] = $data['username'];
                }
                
                // Obnova údajov
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
                $stmt->execute(['id' => $user_id]);
                $user = $stmt->fetch();
                
            } catch (\PDOException $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }

                if (!empty($newUploadedAvatarPath)) {
                    $deleteAvatarFile($newUploadedAvatarPath);
                }

                if ($e->getCode() == 23000) {
                    $errors[] = "Toto používateľské meno už niekto používa.";
                } else {
                    $errors[] = "Chyba pri ukladaní do databázy.";
                    error_log("Profile error: " . $e->getMessage());
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil používateľa - Nefro-projekt Slovensko</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    $headerTitle = 'Môj profil';
    $headerIntro = 'Správa osobných údajov a nastavení';
    $showLogo = false;
    include 'header.php';
    ?>

    <main class="container">
        <div class="auth-container auth-container--wide">
            <h2>Úprava profilu</h2>
            <p class="auth-subtitle">
                E-mailová adresa (prihlasovacia): <strong><?= htmlspecialchars($user['email']) ?></strong>
            </p>
            <p class="auth-subtitle">Formát mobilného čísla: <strong>+421XXXXXXXXX</strong> (môžete použiť aj medzery, pole je voliteľné).</p>

            <form method="POST" action="profile.php" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">

                <div class="form-section">
                    <h3>Prihlasovacie údaje</h3>
                    <div class="form-grid">
                        <div class="form-group form-group--full-width">
                            <label for="mobile_phone">Číslo súkromného mobilného telefónu (voliteľné)</label>
                            <input type="tel" id="mobile_phone" name="mobile_phone" class="form-control" value="<?= htmlspecialchars(formatPhoneForDisplay((string) ($user['mobile_phone'] ?? ''))) ?>" placeholder="+421 901 234 567" pattern="^\+421[0-9\s\-()\.\/]{8,20}$" title="Zadajte číslo vo formáte +421XXXXXXXXX alebo +421 901 234 567">
                            <small class="avatar-upload-hint">Pole je voliteľné. Povolený je iba medzinárodný formát začínajúci znakom +.</small>

                            <?php
                            $isMobileVerified = !empty($user['mobile_verified_at']);
                            $mobileSentAt = $user['mobile_verification_sent_at'] ?? null;
                            $mobileExpiresAt = $user['mobile_verification_expires_at'] ?? null;
                            ?>
                            <p class="avatar-upload-hint" style="margin-top:8px;">
                                Stav overenia mobilu:
                                <strong><?= $isMobileVerified ? 'Overený' : 'Neoverený' ?></strong>
                                <?php if (!empty($user['mobile_phone']) && !$isMobileVerified): ?>
                                    <?php if (!empty($mobileExpiresAt) && strtotime((string) $mobileExpiresAt) >= time()): ?>
                                        (kód aktívny do <?= htmlspecialchars(date('d.m.Y H:i', strtotime((string) $mobileExpiresAt))) ?>)
                                    <?php elseif (!empty($mobileSentAt)): ?>
                                        (posledný kód odoslaný <?= htmlspecialchars(date('d.m.Y H:i', strtotime((string) $mobileSentAt))) ?>)
                                    <?php endif; ?>
                                <?php endif; ?>
                            </p>

                            <div class="form-grid" style="margin-top:10px;">
                                <div class="form-group">
                                    <label for="mobile_verification_code">SMS overovací kód</label>
                                    <input type="text" id="mobile_verification_code" name="mobile_verification_code" class="form-control" inputmode="numeric" pattern="^\d{6}$" maxlength="6" placeholder="123456">
                                </div>
                            </div>

                            <div class="form-actions" style="margin-top:6px; display:flex; gap:10px; flex-wrap:wrap;">
                                <button type="submit" name="mobile_verification_action" value="send" class="btn-primary">Poslať overovací SMS kód</button>
                                <button type="submit" name="mobile_verification_action" value="verify" class="btn-primary">Overiť mobilný kód</button>
                            </div>
                        </div>
                    </div>
                </div>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    Profil bol úspešne aktualizovaný.
                </div>
            <?php endif; ?>

            <?php if ($mobileVerificationNotice !== null): ?>
                <div class="alert alert-success">
                    <p><?= htmlspecialchars($mobileVerificationNotice) ?></p>
                </div>
            <?php endif; ?>

                <div class="form-section">
                    <h3>Zmena hesla</h3>
                    <p class="avatar-upload-hint mb-15">Ak nechcete zmeniť heslo, ponechajte tieto polia prázdne.</p>
                    <div class="form-grid">
                        <div class="form-group form-group--full-width">
                            <label for="current_password">Súčasné heslo</label>
                            <input type="password" id="current_password" name="current_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="new_password">Nové heslo <small>(min. 8 znakov, veľké/malé písmená a číslice)</small></label>
                            <input type="password" id="new_password" name="new_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirm">Potvrdenie nového hesla</label>
                            <input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Základné a osobné údaje</h3>
                    
                    <div class="avatar-upload-group">
                        <?php
                        $avatarSrc = !empty($user['avatar_path']) ? htmlspecialchars($user['avatar_path']) : 'img/default-avatar-dark.svg'; // Default set by JS later
                        ?>
                        <img src="<?= $avatarSrc ?>" id="avatarPreview" data-is-default="<?= empty($user['avatar_path']) ? 'true' : 'false' ?>" alt="Náhľad avatara" class="avatar-upload-preview">
                        <div>
                            <label for="avatar" class="avatar-upload-label">Profilová fotografia (Avatar)</label>
                            <input type="file" id="avatar" name="avatar" class="form-control" accept="image/jpeg, image/png, image/gif, image/webp" onchange="previewAvatar(event)">
                            <small class="avatar-upload-hint">Zvoľte nový obrázok, ak chcete zmeniť aktuálny.</small>
                            <?php if (!empty($user['avatar_path'])): ?>
                                <div class="form-check">
                                    <input type="checkbox" id="remove_avatar" name="remove_avatar" value="1" <?= isset($_POST['remove_avatar']) ? 'checked' : '' ?>>
                                    <label for="remove_avatar">Vymazať aktuálny obrázok profilu</label>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Používateľské meno</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($user['username'] ?? '') ?>">
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="gender">Identifikácia (pohlavie)</label>
                            <select id="gender" name="gender" class="form-control">
                                <option value="">-- Vyberte --</option>
                                <option value="Muž" <?= ($user['gender'] ?? '') === 'Muž' ? 'selected' : '' ?>>Muž</option>
                                <option value="Žena" <?= ($user['gender'] ?? '') === 'Žena' ? 'selected' : '' ?>>Žena</option>
                                <option value="Transgender muž" <?= ($user['gender'] ?? '') === 'Transgender muž' ? 'selected' : '' ?>>Transgender muž</option>
                                <option value="Transgender žena" <?= ($user['gender'] ?? '') === 'Transgender žena' ? 'selected' : '' ?>>Transgender žena</option>
                                <option value="Nebinárna osoba" <?= ($user['gender'] ?? '') === 'Nebinárna osoba' ? 'selected' : '' ?>>Nebinárna osoba</option>
                                <option value="Iné" <?= ($user['gender'] ?? '') === 'Iné' ? 'selected' : '' ?>>Iné / Iná identita</option>
                                <option value="Nechcem uviesť" <?= ($user['gender'] ?? '') === 'Nechcem uviesť' ? 'selected' : '' ?>>Nechcem uviesť</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pronouns">Identifikačné zámená (napr. on/jeho)</label>
                            <input type="text" id="pronouns" name="pronouns" class="form-control" value="<?= htmlspecialchars($user['pronouns'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="title_before">Titul pred menom</label>
                            <input type="text" id="title_before" name="title_before" class="form-control" value="<?= htmlspecialchars($user['title_before'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="first_name">Prvé (krstné) meno</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Stredné meno/á</label>
                            <input type="text" id="middle_name" name="middle_name" class="form-control" value="<?= htmlspecialchars($user['middle_name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Priezvisko</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="title_after">Titul za menom</label>
                            <input type="text" id="title_after" name="title_after" class="form-control" value="<?= htmlspecialchars($user['title_after'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="birth_date">Dátum narodenia</label>
                            <input type="date" id="birth_date" name="birth_date" class="form-control" value="<?= htmlspecialchars($user['birth_date'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name_note">Poznámka k menu</label>
                        <input type="text" id="name_note" name="name_note" class="form-control" value="<?= htmlspecialchars($user['name_note'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-section">
                    <h3>Pracovné údaje</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="organization">Organizácia</label>
                            <input type="text" id="organization" name="organization" class="form-control" value="<?= htmlspecialchars($user['organization'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="job_function">Funkcia</label>
                            <input type="text" id="job_function" name="job_function" class="form-control" value="<?= htmlspecialchars($user['job_function'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="work_mobile_phone">Číslo pracovného mobilného telefónu (voliteľné)</label>
                            <input type="tel" id="work_mobile_phone" name="work_mobile_phone" class="form-control" value="<?= htmlspecialchars(formatPhoneForDisplay((string) ($user['work_mobile_phone'] ?? ''))) ?>" placeholder="+421 901 234 567" pattern="^\+421[0-9\s\-()\.\/]{8,20}$" title="Zadajte číslo vo formáte +421XXXXXXXXX alebo +421 901 234 567">
                        </div>
                        <div class="form-group">
                            <label for="org_website">Webové stránky organizácie</label>
                            <input type="url" id="org_website" name="org_website" class="form-control" value="<?= htmlspecialchars($user['org_website'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="work_email">Pracovný e-mail</label>
                            <input type="email" id="work_email" name="work_email" class="form-control" value="<?= htmlspecialchars($user['work_email'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Kontaktné údaje</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="other_phone">Iné telefónne číslo</label>
                            <input type="tel" id="other_phone" name="other_phone" class="form-control" value="<?= htmlspecialchars(formatPhoneForDisplay((string) ($user['other_phone'] ?? ''))) ?>" placeholder="+421 2 1234 5678" pattern="^\+[0-9][0-9\s\-()\.\/]{7,20}$" title="Zadajte číslo v medzinárodnom formáte +XXXXXXXX, napr. +421 2 1234 5678">
                        </div>
                        <div class="form-group">
                            <label for="website">Osobné webové stránky</label>
                            <input type="url" id="website" name="website" class="form-control" value="<?= htmlspecialchars($user['website'] ?? '') ?>">
                        </div>
                    </div>
                    <h3>Sociálne siete</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="social_linkedin">LinkedIn profil</label>
                            <input type="url" id="social_linkedin" name="social_linkedin" class="form-control" value="<?= htmlspecialchars($user['social_linkedin'] ?? '') ?>" placeholder="https://linkedin.com/in/meno-priezvisko">
                            <small class="avatar-upload-hint">Formát: linkedin.com/in/<em>pouzivatelske-meno</em></small>
                        </div>
                        <div class="form-group">
                            <label for="social_x">X (Twitter) profil</label>
                            <input type="url" id="social_x" name="social_x" class="form-control" value="<?= htmlspecialchars($user['social_x'] ?? '') ?>" placeholder="https://x.com/pouzivatelske_meno">
                            <small class="avatar-upload-hint">Formát: x.com/<em>pouzivatelske_meno</em></small>
                        </div>
                        <div class="form-group">
                            <label for="social_facebook">Facebook profil</label>
                            <input type="url" id="social_facebook" name="social_facebook" class="form-control" value="<?= htmlspecialchars($user['social_facebook'] ?? '') ?>" placeholder="https://facebook.com/meno.priezvisko">
                            <small class="avatar-upload-hint">Formát: facebook.com/<em>meno.priezvisko</em> alebo facebook.com/<em>profile.php?id=ID</em></small>
                        </div>
                        <div class="form-group">
                            <label for="social_instagram">Instagram profil</label>
                            <input type="url" id="social_instagram" name="social_instagram" class="form-control" value="<?= htmlspecialchars($user['social_instagram'] ?? '') ?>" placeholder="https://instagram.com/pouzivatelske_meno">
                            <small class="avatar-upload-hint">Formát: instagram.com/<em>pouzivatelske_meno</em></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="social_other">Iné sociálne siete (odkazy)</label>
                        <input type="text" id="social_other" name="social_other" class="form-control" value="<?= htmlspecialchars($user['social_other'] ?? '') ?>" placeholder="https://tiktok.com/@meno, https://youtube.com/@meno">
                        <small class="avatar-upload-hint">Uveďte URL adresu profilu. Viac odkazov oddeľte čiarkou.</small>
                    </div>
                    <div class="form-group">
                        <label for="other_contact">Iné kontaktné informácie</label>
                        <input type="text" id="other_contact" name="other_contact" class="form-control" value="<?= htmlspecialchars($user['other_contact'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-section">
                    <h3>Adresa</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="street">Ulica</label>
                            <input type="text" id="street" name="street" class="form-control" value="<?= htmlspecialchars($user['street'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="house_number">Popisné číslo</label>
                            <input type="text" id="house_number" name="house_number" class="form-control" value="<?= htmlspecialchars($user['house_number'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="orientation_number">Orientačné číslo</label>
                            <input type="text" id="orientation_number" name="orientation_number" class="form-control" value="<?= htmlspecialchars($user['orientation_number'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="zip_code">PSČ</label>
                            <input type="text" id="zip_code" name="zip_code" class="form-control" value="<?= htmlspecialchars($user['zip_code'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="city">Obec</label>
                            <input type="text" id="city" name="city" class="form-control" value="<?= htmlspecialchars($user['city'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="district">Okres</label>
                            <input type="text" id="district" name="district" class="form-control" value="<?= htmlspecialchars($user['district'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="region">Kraj</label>
                            <input type="text" id="region" name="region" class="form-control" value="<?= htmlspecialchars($user['region'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="country">Štát</label>
                            <input type="text" id="country" name="country" class="form-control" value="<?= htmlspecialchars($user['country'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address_note">Poznámka k adrese</label>
                        <input type="text" id="address_note" name="address_note" class="form-control" value="<?= htmlspecialchars($user['address_note'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" id="newsletter_consent" name="newsletter_consent" value="1" <?= $user['newsletter_consent'] ? 'checked' : '' ?>>
                    <label for="newsletter_consent">Súhlasím so zasielaním noviniek</label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary btn-block">Uložiť zmeny</button>
                </div>
            </form>
            <div class="auth-links auth-links--spaced">
                <p><a href="logout.php" class="link-error">Odhlásiť sa zo systému</a></p>
            </div>
        </div>
    </main>

    <script>
    function updateDefaultAvatar() {
        const preview = document.getElementById('avatarPreview');
        const input = document.getElementById('avatar');
        
        // Ak je obrázok defaultný (z databázy nie je cesta) a nezvolil sa nový súbor
        if (preview.dataset.isDefault === 'true' && (!input.files || !input.files[0])) {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            preview.src = currentTheme === 'dark' ? 'img/default-avatar-dark.svg' : 'img/default-avatar-light.svg';
        }
    }

    function previewAvatar(event) {
        const input = event.target;
        const preview = document.getElementById('avatarPreview');
        const removeCheckbox = document.getElementById('remove_avatar');
        if (input.files && input.files[0]) {
            if (removeCheckbox) {
                removeCheckbox.checked = false;
            }
            preview.dataset.isDefault = 'false';
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            // Používateľ zrušil výber, obnov náhľad pôvodného avatara
            const originalSrc = preview.dataset.isDefault === 'true' ? '' : '<?= htmlspecialchars($user['avatar_path'] ?? '') ?>';
            if (originalSrc) {
                preview.src = originalSrc;
            } else {
                updateDefaultAvatar();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const preview = document.getElementById('avatarPreview');
        const input = document.getElementById('avatar');
        const removeCheckbox = document.getElementById('remove_avatar');
        const originalAvatarSrc = '<?= htmlspecialchars($user['avatar_path'] ?? '') ?>';

        updateDefaultAvatar();

        if (removeCheckbox) {
            removeCheckbox.addEventListener('change', () => {
                if (removeCheckbox.checked) {
                    preview.dataset.isDefault = 'true';
                    updateDefaultAvatar();
                    return;
                }

                if (input.files && input.files[0]) {
                    previewAvatar({ target: input });
                    return;
                }

                if (originalAvatarSrc) {
                    preview.dataset.isDefault = 'false';
                    preview.src = originalAvatarSrc;
                } else {
                    preview.dataset.isDefault = 'true';
                    updateDefaultAvatar();
                }
            });
        }
        
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'data-theme') {
                    updateDefaultAvatar();
                }
            });
        });
        observer.observe(document.documentElement, {
            attributes: true
        });
    });
    </script>
    
    <?php include 'footer.php'; ?>
