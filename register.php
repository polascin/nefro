<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'avatar_upload.php';
require_once 'email_verification.php';
require_once 'phone_utils.php';

$errors = [];
$success = false;
$registeredData = [];
$verificationNotice = null;

$isLocalDev = isAppLocalDev();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
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
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $mobilePhone = normalizeUserMobilePhone($_POST['mobile_phone'] ?? null);
        $workMobilePhone = normalizeUserMobilePhone($_POST['work_mobile_phone'] ?? null);
        $otherPhone = normalizeGenericPhone($_POST['other_phone'] ?? null);
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $username = trim($_POST['username'] ?? '');
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Zadajte platnú e-mailovú adresu.";
        }
        if (strlen($password) < 8 || strlen($password) > 1024 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $errors[] = "Heslo musí mať 8–1024 znakov, obsahovať aspoň jedno veľké písmeno, malé písmeno a číslicu.";
        } elseif ($password !== $passwordConfirm) {
            $errors[] = "Heslá sa nezhodujú. Skontrolujte potvrdenie hesla.";
        }
        if ($mobilePhone === false) {
            $errors[] = "Zadajte platné číslo súkromného mobilného telefónu vo formáte +421XXXXXXXXX (môžete použiť aj medzery).";
        }
        if ($workMobilePhone === false) {
            $errors[] = "Zadajte platné číslo pracovného mobilného telefónu vo formáte +421XXXXXXXXX (môžete použiť aj medzery).";
        }
        if ($otherPhone === false) {
            $errors[] = "Zadajte platné iné telefónne číslo v medzinárodnom formáte +XXXXXXXX (môžete použiť aj medzery).";
        }
        
        if (empty($username)) {
            $username = $email;
        }

        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare("SELECT email, username FROM users WHERE email = :email OR username = :username LIMIT 1");
                $stmt->execute([
                    'email' => $email,
                    'username' => $username,
                ]);
                $existingUser = $stmt->fetch();
                if ($existingUser) {
                    if (($existingUser['email'] ?? '') === $email) {
                        $errors[] = "Používateľ s týmto e-mailom už existuje.";
                    }
                    if (($existingUser['username'] ?? '') === $username) {
                        $errors[] = "Používateľ s týmto používateľským menom už existuje.";
                    }
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $newsletterConsent = isset($_POST['newsletter_consent']) ? 1 : 0;
                    $gender = trim($_POST['gender'] ?? '');
                    $pronouns = trim($_POST['pronouns'] ?? '');
                    
                    // Spracovanie avatara
                    $avatarPath = null;
                    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                        $avatarUploadResult = processAvatarUpload($_FILES['avatar']);
                        if (!empty($avatarUploadResult['error'])) {
                            $errors[] = $avatarUploadResult['error'];
                        } else {
                            $avatarPath = $avatarUploadResult['path'];
                        }
                    }

                    if (empty($errors)) {
                        $sql = "INSERT INTO users (
                            username, email, password_hash, gender, pronouns, avatar_path, title_before, first_name, middle_name, last_name,
                            title_after, name_note, organization, job_function, work_mobile_phone, org_website,
                            work_email, mobile_phone, other_phone, social_linkedin, social_x, social_facebook, social_instagram, social_other, other_contact, website, birth_date,
                            street, house_number, orientation_number, zip_code, city, district, region, country, address_note, newsletter_consent, email_verified_at,
                            email_verification_token_hash, email_verification_expires_at, email_verification_sent_at
                        ) VALUES (
                            :username, :email, :password_hash, :gender, :pronouns, :avatar_path, :title_before, :first_name, :middle_name, :last_name,
                            :title_after, :name_note, :organization, :job_function, :work_mobile_phone, :org_website,
                            :work_email, :mobile_phone, :other_phone, :social_linkedin, :social_x, :social_facebook, :social_instagram, :social_other, :other_contact, :website, :birth_date,
                            :street, :house_number, :orientation_number, :zip_code, :city, :district, :region, :country, :address_note, :newsletter_consent, NULL,
                            :email_verification_token_hash, :email_verification_expires_at, NOW()
                        )";
                        
                        $stmt = $pdo->prepare($sql);
                        $tokenData = generateEmailVerificationToken();
                        $registrationParams = [
                            'username' => $username,
                            'email' => $email,
                            'password_hash' => $passwordHash,
                            'gender' => $gender,
                            'pronouns' => $pronouns,
                            'avatar_path' => $avatarPath,
                            'title_before' => trim($_POST['title_before'] ?? ''),
                            'first_name' => trim($_POST['first_name'] ?? ''),
                            'middle_name' => trim($_POST['middle_name'] ?? ''),
                            'last_name' => trim($_POST['last_name'] ?? ''),
                            'title_after' => trim($_POST['title_after'] ?? ''),
                            'name_note' => trim($_POST['name_note'] ?? ''),
                            'organization' => trim($_POST['organization'] ?? ''),
                            'job_function' => trim($_POST['job_function'] ?? ''),
                            'work_mobile_phone' => $workMobilePhone,
                            'org_website' => trim($_POST['org_website'] ?? ''),
                            'work_email' => trim($_POST['work_email'] ?? ''),
                            'mobile_phone' => $mobilePhone,
                            'other_phone' => $otherPhone,
                            'social_linkedin' => trim($_POST['social_linkedin'] ?? ''),
                            'social_x' => trim($_POST['social_x'] ?? ''),
                            'social_facebook' => trim($_POST['social_facebook'] ?? ''),
                            'social_instagram' => trim($_POST['social_instagram'] ?? ''),
                            'social_other' => trim($_POST['social_other'] ?? ''),
                            'other_contact' => trim($_POST['other_contact'] ?? ''),
                            'website' => trim($_POST['website'] ?? ''),
                            'birth_date' => (function() {
                                $raw = $_POST['birth_date'] ?? '';
                                if (empty($raw)) return null;
                                $d = DateTime::createFromFormat('Y-m-d', $raw);
                                return ($d && $d->format('Y-m-d') === $raw) ? $raw : null;
                            })(),
                            'street' => trim($_POST['street'] ?? ''),
                            'house_number' => trim($_POST['house_number'] ?? ''),
                            'orientation_number' => trim($_POST['orientation_number'] ?? ''),
                            'zip_code' => trim($_POST['zip_code'] ?? ''),
                            'city' => trim($_POST['city'] ?? ''),
                            'district' => trim($_POST['district'] ?? ''),
                            'region' => trim($_POST['region'] ?? ''),
                            'country' => trim($_POST['country'] ?? ''),
                            'address_note' => trim($_POST['address_note'] ?? ''),
                            'newsletter_consent' => $newsletterConsent,
                            'email_verification_token_hash' => $tokenData['token_hash'],
                            'email_verification_expires_at' => $tokenData['expires_at'],
                        ];
                        $stmt->execute($registrationParams);

                        $newUserId = (int) $pdo->lastInsertId();
                        $newUserRow = null;
                        $userFetchStmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
                        $userFetchStmt->execute(['id' => $newUserId]);
                        $newUserRow = $userFetchStmt->fetch();

                        $sent = sendVerificationEmail($email, $username, $newUserId, $tokenData['token']);
                        if (!$sent) {
                            $verificationNotice = 'Účet bol vytvorený, ale overovací e-mail sa nepodarilo odoslať. Skúste možnosť opätovného odoslania.';
                        }

                        $userNoticeSent = sendUserRegistrationNotificationEmail(
                            $email,
                            $username,
                            is_array($newUserRow) ? $newUserRow : []
                        );
                        if (!$userNoticeSent) {
                            error_log('Registrácia: používateľský notifikačný e-mail sa nepodarilo odoslať pre user_id=' . $newUserId);
                        }

                        if (is_array($newUserRow)) {
                            $adminNoticeSent = sendAdminNewRegistrationEmail($newUserRow, [
                                'ip' => (string) ($_SERVER['REMOTE_ADDR'] ?? ''),
                                'user_agent' => (string) ($_SERVER['HTTP_USER_AGENT'] ?? ''),
                                'referer' => (string) ($_SERVER['HTTP_REFERER'] ?? ''),
                                'request_uri' => (string) ($_SERVER['REQUEST_URI'] ?? ''),
                            ]);
                            if (!$adminNoticeSent) {
                                error_log('Registrácia: admin notifikačný e-mail sa nepodarilo odoslať pre user_id=' . $newUserId);
                            }
                        }
                        
                        $success = true;
                        $registeredData = $registrationParams;
                        unset($registeredData['password_hash']);
                        $registeredData['newsletter_consent'] = $newsletterConsent ? 'Áno' : 'Nie';
                    }
                }
            } catch (\PDOException $e) {
                error_log("Chyba registrácie: " . $e->getMessage());
                if ((string) $e->getCode() === '23000') {
                    $errors[] = "Používateľ s rovnakým e-mailom alebo používateľským menom už existuje.";
                } else {
                    $errors[] = "Vyskytla sa chyba pri registrácii. Skúste to prosím neskôr.";
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
    <title>Registrácia - Nefro-projekt Slovensko</title>
    <meta name="description" content="Zaregistrujte sa do Nefro-projekt Slovensko — odborného portálu pre nefrológov a lekárov.">
    <link rel="canonical" href="https://nefro.polascin.net/register.php">
    <meta property="og:title" content="Registrácia | Nefro-projekt Slovensko">
    <meta property="og:description" content="Zaregistrujte sa do Nefro-projekt Slovensko — odborného portálu pre nefrológov a lekárov.">
    <meta property="og:url" content="https://nefro.polascin.net/register.php">
    <meta property="og:type" content="website">
    <meta name="robots" content="index, follow">

    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    $headerTitle = 'Nefro-projekt Slovensko';
    $showLogo = false;
    include 'header.php';
    ?>

    <main class="container">
        <div class="auth-container auth-container--wide">
            <h2>Registrácia</h2>
            <p class="auth-subtitle">Používateľ webovej lokality <a href="https://nefro.polascin.net/" class="auth-subtitle__link">https://nefro.polascin.net/</a></p>
            
            <?php if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && !$success): ?>
                <div class="alert alert-error">
                    Registrácia nebola úspešná. Skontrolujte chyby nižšie a skúste formulár odoslať znova.
                </div>
            <?php endif; ?>

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
                    Registrácia prebehla úspešne. Na prihlásenie je potrebné overiť e-mailovú adresu.
                </div>
                <?php if ($verificationNotice !== null): ?>
                    <div class="alert alert-error">
                        <p><?= htmlspecialchars($verificationNotice) ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-section">
                    <h3>Potvrdenie registrácie</h3>
                    <p>Nižšie sú zobrazené údaje, ktoré boli uložené pri registrácii.</p>
                    <div class="form-grid">
                        <?php
                        $fieldLabels = [
                            'username' => 'Používateľské meno',
                            'email' => 'E-mailová adresa',
                            'gender' => 'Identifikácia (pohlavie)',
                            'pronouns' => 'Identifikačné zámená',
                            'title_before' => 'Titul pred menom',
                            'first_name' => 'Prvé (krstné) meno',
                            'middle_name' => 'Stredné meno/á',
                            'last_name' => 'Priezvisko',
                            'title_after' => 'Titul za menom',
                            'birth_date' => 'Dátum narodenia',
                            'name_note' => 'Poznámka k menu',
                            'organization' => 'Organizácia',
                            'job_function' => 'Funkcia',
                            'work_mobile_phone' => 'Číslo pracovného mobilného telefónu',
                            'org_website' => 'Webové stránky organizácie',
                            'work_email' => 'Pracovný e-mail',
                            'mobile_phone' => 'Číslo súkromného mobilného telefónu',
                            'other_phone' => 'Iné telefónne číslo',
                            'website' => 'Osobné webové stránky',
                            'social_linkedin' => 'LinkedIn profil',
                            'social_x' => 'X (Twitter) profil',
                            'social_facebook' => 'Facebook profil',
                            'social_instagram' => 'Instagram profil',
                            'social_other' => 'Iné sociálne siete',
                            'other_contact' => 'Iné kontaktné informácie',
                            'street' => 'Ulica',
                            'house_number' => 'Popisné číslo',
                            'orientation_number' => 'Orientačné číslo',
                            'zip_code' => 'PSČ',
                            'city' => 'Obec',
                            'district' => 'Okres',
                            'region' => 'Kraj',
                            'country' => 'Štát',
                            'address_note' => 'Poznámka k adrese',
                            'newsletter_consent' => 'Súhlas so zasielaním noviniek',
                        ];
                        ?>
                        <?php foreach ($fieldLabels as $field => $label): ?>
                            <div class="form-group">
                                <label><?= htmlspecialchars($label) ?></label>
                                <?php
                                $displayValue = ($registeredData[$field] ?? '') !== '' ? (string) $registeredData[$field] : 'Neuvedené';
                                if (in_array($field, ['mobile_phone', 'work_mobile_phone', 'other_phone'], true) && $displayValue !== 'Neuvedené') {
                                    $displayValue = formatPhoneForDisplay($displayValue);
                                }
                                ?>
                                <p><?= htmlspecialchars($displayValue) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($registeredData['avatar_path'])): ?>
                        <div class="form-group">
                            <label>Nahraný avatar</label>
                            <p><a href="<?= htmlspecialchars($registeredData['avatar_path']) ?>" target="_blank" rel="noopener noreferrer">Zobraziť avatar</a></p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="auth-links">
                    <p>
                        Skontrolujte e-mail a overte účet.
                        Ak e-mail neprišiel, môžete ho <a href="resend_verification.php?login=<?= urlencode((string) ($registeredData['email'] ?? '')) ?>">odoslať znova</a>.
                    </p>
                </div>
            <?php else: ?>
                <form method="POST" action="register.php" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    
                    <div class="form-section">
                        <h3>Povinné údaje</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="email">E-mailová adresa *</label>
                                <input type="email" id="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="mobile_phone">Číslo súkromného mobilného telefónu (voliteľné)</label>
                                <input type="tel" id="mobile_phone" name="mobile_phone" class="form-control" value="<?= htmlspecialchars($_POST['mobile_phone'] ?? '') ?>" placeholder="+421 901 234 567" pattern="^\+421[0-9\s\-()\.\/]{8,20}$" title="Zadajte číslo vo formáte +421XXXXXXXXX alebo +421 901 234 567">
                                <small class="avatar-upload-hint">Pole je voliteľné. Povolený je iba medzinárodný formát začínajúci znakom +.</small>
                            </div>
                            <div class="form-group">
                                <label for="password">Heslo <small>(min. 8 znakov, veľké/malé písmená a číslice)</small> *</label>
                                <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirm">Potvrdenie hesla *</label>
                                <input type="password" id="password_confirm" name="password_confirm" class="form-control" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Základné a osobné údaje</h3>
                        
                        <div class="avatar-upload-group">
                            <img src="" id="avatarPreview" alt="Náhľad avatara" class="avatar-upload-preview">
                            <div>
                                <label for="avatar" class="avatar-upload-label">Profilová fotografia (Avatar)</label>
                                <input type="file" id="avatar" name="avatar" class="form-control" accept="image/jpeg, image/png, image/gif, image/webp" onchange="previewAvatar(event)">
                                <small class="avatar-upload-hint">Max. 2 MB (JPG, PNG, GIF, WebP). Ak nevyberiete, použije sa univerzálny avatar.</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username">Používateľské meno (ak nevyplníte, použije sa e-mail)</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="gender">Identifikácia (pohlavie)</label>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="">-- Vyberte --</option>
                                    <option value="Muž" <?= ($_POST['gender'] ?? '') === 'Muž' ? 'selected' : '' ?>>Muž</option>
                                    <option value="Žena" <?= ($_POST['gender'] ?? '') === 'Žena' ? 'selected' : '' ?>>Žena</option>
                                    <option value="Transgender muž" <?= ($_POST['gender'] ?? '') === 'Transgender muž' ? 'selected' : '' ?>>Transgender muž</option>
                                    <option value="Transgender žena" <?= ($_POST['gender'] ?? '') === 'Transgender žena' ? 'selected' : '' ?>>Transgender žena</option>
                                    <option value="Nebinárna osoba" <?= ($_POST['gender'] ?? '') === 'Nebinárna osoba' ? 'selected' : '' ?>>Nebinárna osoba</option>
                                    <option value="Iné" <?= ($_POST['gender'] ?? '') === 'Iné' ? 'selected' : '' ?>>Iné / Iná identita</option>
                                    <option value="Nechcem uviesť" <?= ($_POST['gender'] ?? '') === 'Nechcem uviesť' ? 'selected' : '' ?>>Nechcem uviesť</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pronouns">Identifikačné zámená (napr. on/jeho, ona/jej)</label>
                                <input type="text" id="pronouns" name="pronouns" class="form-control" value="<?= htmlspecialchars($_POST['pronouns'] ?? '') ?>" placeholder="napr. on/jeho">
                            </div>
                            <div class="form-group">
                                <label for="title_before">Titul pred menom</label>
                                <input type="text" id="title_before" name="title_before" class="form-control" value="<?= htmlspecialchars($_POST['title_before'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="first_name">Prvé (krstné) meno</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="middle_name">Stredné meno/á</label>
                                <input type="text" id="middle_name" name="middle_name" class="form-control" value="<?= htmlspecialchars($_POST['middle_name'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Priezvisko</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="title_after">Titul za menom</label>
                                <input type="text" id="title_after" name="title_after" class="form-control" value="<?= htmlspecialchars($_POST['title_after'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="birth_date">Dátum narodenia</label>
                                <input type="date" id="birth_date" name="birth_date" class="form-control" value="<?= htmlspecialchars($_POST['birth_date'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name_note">Poznámka k menu</label>
                            <input type="text" id="name_note" name="name_note" class="form-control" value="<?= htmlspecialchars($_POST['name_note'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Pracovné údaje</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="organization">Organizácia</label>
                                <input type="text" id="organization" name="organization" class="form-control" value="<?= htmlspecialchars($_POST['organization'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="job_function">Funkcia</label>
                                <input type="text" id="job_function" name="job_function" class="form-control" value="<?= htmlspecialchars($_POST['job_function'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="work_mobile_phone">Číslo pracovného mobilného telefónu (voliteľné)</label>
                                <input type="tel" id="work_mobile_phone" name="work_mobile_phone" class="form-control" value="<?= htmlspecialchars($_POST['work_mobile_phone'] ?? '') ?>" placeholder="+421 901 234 567" pattern="^\+421[0-9\s\-()\.\/]{8,20}$" title="Zadajte číslo vo formáte +421XXXXXXXXX alebo +421 901 234 567">
                            </div>
                            <div class="form-group">
                                <label for="org_website">Webové stránky organizácie</label>
                                <input type="url" id="org_website" name="org_website" class="form-control" value="<?= htmlspecialchars($_POST['org_website'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="work_email">Pracovný e-mail</label>
                                <input type="email" id="work_email" name="work_email" class="form-control" value="<?= htmlspecialchars($_POST['work_email'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Kontaktné údaje</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="other_phone">Iné telefónne číslo</label>
                                <input type="tel" id="other_phone" name="other_phone" class="form-control" value="<?= htmlspecialchars($_POST['other_phone'] ?? '') ?>" placeholder="+421 2 1234 5678" pattern="^\+[0-9][0-9\s\-()\.\/]{7,20}$" title="Zadajte číslo v medzinárodnom formáte +XXXXXXXX, napr. +421 2 1234 5678">
                            </div>
                            <div class="form-group">
                                <label for="website">Osobné webové stránky</label>
                                <input type="url" id="website" name="website" class="form-control" value="<?= htmlspecialchars($_POST['website'] ?? '') ?>">
                            </div>
                        </div>
                        <h3>Sociálne siete</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="social_linkedin">LinkedIn profil</label>
                                <input type="url" id="social_linkedin" name="social_linkedin" class="form-control" value="<?= htmlspecialchars($_POST['social_linkedin'] ?? '') ?>" placeholder="https://linkedin.com/in/meno-priezvisko">
                                <small class="avatar-upload-hint">Formát: linkedin.com/in/<em>pouzivatelske-meno</em></small>
                            </div>
                            <div class="form-group">
                                <label for="social_x">X (Twitter) profil</label>
                                <input type="url" id="social_x" name="social_x" class="form-control" value="<?= htmlspecialchars($_POST['social_x'] ?? '') ?>" placeholder="https://x.com/pouzivatelske_meno">
                                <small class="avatar-upload-hint">Formát: x.com/<em>pouzivatelske_meno</em></small>
                            </div>
                            <div class="form-group">
                                <label for="social_facebook">Facebook profil</label>
                                <input type="url" id="social_facebook" name="social_facebook" class="form-control" value="<?= htmlspecialchars($_POST['social_facebook'] ?? '') ?>" placeholder="https://facebook.com/meno.priezvisko">
                                <small class="avatar-upload-hint">Formát: facebook.com/<em>meno.priezvisko</em> alebo facebook.com/<em>profile.php?id=ID</em></small>
                            </div>
                            <div class="form-group">
                                <label for="social_instagram">Instagram profil</label>
                                <input type="url" id="social_instagram" name="social_instagram" class="form-control" value="<?= htmlspecialchars($_POST['social_instagram'] ?? '') ?>" placeholder="https://instagram.com/pouzivatelske_meno">
                                <small class="avatar-upload-hint">Formát: instagram.com/<em>pouzivatelske_meno</em></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="social_other">Iné sociálne siete (odkazy)</label>
                            <input type="text" id="social_other" name="social_other" class="form-control" value="<?= htmlspecialchars($_POST['social_other'] ?? '') ?>" placeholder="https://tiktok.com/@meno, https://youtube.com/@meno">
                            <small class="avatar-upload-hint">Uveďte URL adresu profilu. Viac odkazov oddeľte čiarkou.</small>
                        </div>
                        <div class="form-group">
                            <label for="other_contact">Iné kontaktné informácie</label>
                            <input type="text" id="other_contact" name="other_contact" class="form-control" value="<?= htmlspecialchars($_POST['other_contact'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Adresa</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="street">Ulica</label>
                                <input type="text" id="street" name="street" class="form-control" value="<?= htmlspecialchars($_POST['street'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="house_number">Popisné číslo</label>
                                <input type="text" id="house_number" name="house_number" class="form-control" value="<?= htmlspecialchars($_POST['house_number'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="orientation_number">Orientačné číslo</label>
                                <input type="text" id="orientation_number" name="orientation_number" class="form-control" value="<?= htmlspecialchars($_POST['orientation_number'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="zip_code">PSČ</label>
                                <input type="text" id="zip_code" name="zip_code" class="form-control" value="<?= htmlspecialchars($_POST['zip_code'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="city">Obec</label>
                                <input type="text" id="city" name="city" class="form-control" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="district">Okres</label>
                                <input type="text" id="district" name="district" class="form-control" value="<?= htmlspecialchars($_POST['district'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="region">Kraj</label>
                                <input type="text" id="region" name="region" class="form-control" value="<?= htmlspecialchars($_POST['region'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="country">Štát</label>
                                <input type="text" id="country" name="country" class="form-control" value="<?= htmlspecialchars($_POST['country'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address_note">Poznámka k adrese</label>
                            <input type="text" id="address_note" name="address_note" class="form-control" value="<?= htmlspecialchars($_POST['address_note'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="newsletter_consent" name="newsletter_consent" value="1" <?= isset($_POST['newsletter_consent']) ? 'checked' : '' ?>>
                        <label for="newsletter_consent">Súhlasím so zasielaním noviniek</label>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary btn-block">Registrovať sa</button>
                    </div>
                </form>
            <?php endif; ?>

            <div class="auth-links">
                <p>Už máte účet? <a href="login.php">Prihláste sa</a></p>
            </div>
        </div>
    </main>
    <script>
    function updateDefaultAvatar() {
        const preview = document.getElementById('avatarPreview');
        const input = document.getElementById('avatar');
        if (!input.files || !input.files[0]) {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            preview.src = currentTheme === 'dark' ? 'img/default-avatar-dark.svg' : 'img/default-avatar-light.svg';
        }
    }

    function previewAvatar(event) {
        const input = event.target;
        const preview = document.getElementById('avatarPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            updateDefaultAvatar();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Inicializácia pri načítaní stránky
        updateDefaultAvatar();
        
        // Sledovanie zmeny témy
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === "data-theme") {
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
