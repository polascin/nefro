<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/avatar_upload.php';
require_once __DIR__ . '/email_verification.php';
require_once __DIR__ . '/phone_utils.php';

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
        // ── Bot detekcia (User-Agent, honeypot, JS-challenge, time-check) ────
        $isBotRequest = false;

        if (isKnownBotUserAgent()) {
            if ($isLocalDev) {
                $errors[] = "[DEV] Detekovaný nepovolený User-Agent.";
            } else {
                $isBotRequest = true;
            }
        }

        if (!$isBotRequest && ($_POST['website_url'] ?? '') !== '') {
            if ($isLocalDev) {
                $errors[] = "[DEV] Honeypot aktivovaný.";
            } else {
                $isBotRequest = true;
            }
        }

        if (!$isBotRequest && !validateJsChallengeToken($_POST['js_token'] ?? null)) {
            if ($isLocalDev) {
                $errors[] = "[DEV] JS-Challenge zlyhal (chýba js_token).";
            } else {
                $isBotRequest = true;
            }
        }

        if (!$isBotRequest && !validateFormTime('register', 5)) {
            if ($isLocalDev) {
                $errors[] = "[DEV] Formulár odoslaný príliš rýchlo (pod 5s).";
            } else {
                $isBotRequest = true;
            }
        }

        if ($isBotRequest) {
            // Tvárime sa, že registrácia prebehla úspešne — neinformujeme bota o detekcii
            $success = true;
        } else {

        // ── 4. IP Rate Limiting (max 5 pokusov/hodina per IP) ────────────────
        $clientIpReg = getClientIpAddress();
        $maxRegAttempts = 5;    // max registrácií za okno
        $regWindowSecs  = 3600; // okno: 1 hodina
        $regBlockSecs   = 3600; // blokácia: 1 hodina
        $regIsBlocked   = false;

        try {
            // Odstrán expirované bloky staršie ako 1 deň
            $pdo->prepare("DELETE FROM form_rate_limit WHERE action = 'register' AND blocked_until IS NOT NULL AND blocked_until < DATE_SUB(NOW(), INTERVAL 1 DAY)")
                ->execute();

            $rlStmt = $pdo->prepare("SELECT attempt_count, blocked_until FROM form_rate_limit WHERE ip = :ip AND action = 'register'");
            $rlStmt->execute(['ip' => $clientIpReg]);
            $rlRow = $rlStmt->fetch();

            if ($rlRow && !empty($rlRow['blocked_until'])) {
                $blockedUntilTs = strtotime((string) $rlRow['blocked_until']);
                if ($blockedUntilTs !== false && $blockedUntilTs > time()) {
                    $regIsBlocked = true;
                    $errors[] = "Z bezpečnostných dôvodov bol prístup k registrácii dočasne zablokovaný. Skúste to znova o hodinu.";
                    if ($isLocalDev) {
                        $remainingMins = max(1, (int) ceil(($blockedUntilTs - time()) / 60));
                        $errors[] = "[DEV] IP {$clientIpReg} je blokovaná na registráciu ešte {$remainingMins} min.";
                    }
                } else {
                    // Blokácia expirovala — vymazáme ju
                    $pdo->prepare(
                        "UPDATE form_rate_limit
                         SET attempt_count = 0, first_attempt = NOW(), last_attempt = NOW(), blocked_until = NULL
                         WHERE ip = :ip AND action = 'register'"
                    )
                        ->execute(['ip' => $clientIpReg]);
                }
            }
        } catch (\PDOException $e) {
            error_log('Register rate limit check error: ' . $e->getMessage());
            // Pri DB chybe pokračuj bez rate limitingu
        }

        if (!$regIsBlocked) {
        $email = trim($_POST['email'] ?? '');

        $mobilePhone = normalizeUserMobilePhone($_POST['mobile_phone'] ?? null);
        $workMobilePhone = normalizeUserMobilePhone($_POST['work_mobile_phone'] ?? null);
        $otherPhone = normalizeGenericPhone($_POST['other_phone'] ?? null);
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $username = trim($_POST['username'] ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Zadajte platnú e-mailovú adresu.";
        } elseif (!isEmailDomainValid($email)) {
            $errors[] = "Doména e-mailovej adresy neexistuje alebo nemôže prijímať poštu.";
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
                // Zaznamenať pokus o registráciu pre rate limiting
                try {
                    $pdo->prepare(
                        "INSERT INTO form_rate_limit (ip, action, attempt_count, first_attempt)
                         VALUES (:ip, 'register', 1, NOW())
                         ON DUPLICATE KEY UPDATE attempt_count = attempt_count + 1, last_attempt = NOW()"
                    )->execute(['ip' => $clientIpReg]);

                    $cntStmt = $pdo->prepare("SELECT attempt_count FROM form_rate_limit WHERE ip = :ip AND action = 'register'");
                    $cntStmt->execute(['ip' => $clientIpReg]);
                    $regCurrentCount = (int) ($cntStmt->fetchColumn() ?? 0);

                    if ($regCurrentCount >= $maxRegAttempts) {
                        $pdo->prepare("UPDATE form_rate_limit SET blocked_until = DATE_ADD(NOW(), INTERVAL :secs SECOND) WHERE ip = :ip AND action = 'register'")
                            ->execute(['secs' => $regBlockSecs, 'ip' => $clientIpReg]);
                    }
                } catch (\PDOException $rlEx) {
                    error_log('Register rate limit update error: ' . $rlEx->getMessage());
                }


                $stmt = $pdo->prepare("SELECT email, username FROM users WHERE email = :email OR username = :username LIMIT 1");
                $stmt->execute([
                    'email' => $email,
                    'username' => $username,
                ]);
                $existingUser = $stmt->fetch();
                if ($existingUser) {
                    // Anti-enumeration: generické hlásenie — neodhalujeme,
                    // či je duplicita v e-maili alebo v používateľskom mene.
                    // (Konkrétne hlásenie by umožňovalo aut. harvestovanie existujúcich účtov.)
                    $errors[] = 'Registrácia sa nepodarila. Zadajte iný e-mail alebo používateľské meno.';
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $newsletterConsent = isset($_POST['newsletter_consent']) ? 1 : 0;
                    $themeAuto = isset($_POST['theme_auto']) ? 1 : 0;

                    // Whitelist pre gender — hodnoty musia zodpovedať hodnotám <option value="..."> v HTML formulári
                    $allowedGenders  = ['Muž', 'Žena', 'Transgender muž', 'Transgender žena', 'Nebinárna osoba', 'Iné', 'Nechcem uviesť', ''];
                    $genderRaw       = trim($_POST['gender'] ?? '');
                    $gender          = in_array($genderRaw, $allowedGenders, true) ? $genderRaw : '';
                    // Pronouns sú voľný text (input type="text") — dĺžkovo obmedzíme a sanitizujeme
                    $pronounsRaw     = trim($_POST['pronouns'] ?? '');
                    $pronouns        = mb_substr($pronounsRaw, 0, 50, 'UTF-8');

                    // Dĺžkové limity pre textové polia (prevencia pred oversized vstupmi)
                    $fieldLimits = [
                        'username'         => 255,
                        'title_before'     => 50,
                        'first_name'       => 100,
                        'middle_name'      => 100,
                        'last_name'        => 100,
                        'title_after'      => 50,
                        'name_note'        => 255,
                        'organization'     => 255,
                        'job_function'     => 255,
                        'org_website'      => 255,
                        'work_email'       => 254,
                        'social_linkedin'  => 255,
                        'social_x'         => 255,
                        'social_facebook'  => 255,
                        'social_instagram' => 255,
                        'social_other'     => 500,
                        'other_contact'    => 500,
                        'website'          => 255,
                        'street'           => 255,
                        'house_number'     => 20,
                        'orientation_number' => 20,
                        'zip_code'         => 10,
                        'city'             => 150,
                        'district'         => 150,
                        'region'           => 150,
                        'country'          => 100,
                        'address_note'     => 500,
                    ];
                    foreach ($fieldLimits as $_field => $_max) {
                        $rawVal = trim($_POST[$_field] ?? '');
                        if (mb_strlen($rawVal, 'UTF-8') > $_max) {
                            $errors[] = 'Pole je príliš dlhé (max. ' . $_max . ' znakov). Skontrolujte zadané údaje.';
                        }
                    }

                    // Validácia dátumu narodenia (nepovinné pole, ale ak zadané, musí byť platné a vek min. 18 rokov)
                    $birthDateRaw = trim($_POST['birth_date'] ?? '');
                    if ($birthDateRaw !== '') {
                        $bd = DateTime::createFromFormat('Y-m-d', $birthDateRaw);
                        $today = new DateTime();
                        if (!$bd || $bd->format('Y-m-d') !== $birthDateRaw) {
                            $errors[] = 'Dátum narodenia má neplatný formát.';
                        } elseif ($bd > $today) {
                            $errors[] = 'Dátum narodenia nemôže byť v budúcnosti.';
                        } elseif ($bd < (new DateTime())->modify('-120 years')) {
                            $errors[] = 'Dátum narodenia je mimo povolený rozsah (max. 120 rokov).';
                        } elseif ($today->diff($bd)->y < 18) {
                            $errors[] = 'Registrácia je povolená len osobám starším ako 18 rokov.';
                        }
                    }

                    $avatarPath = null;

                    if (empty($errors)) {
                        // Spracovanie avatara — až po overení ostatných polí, aby sme neprijímali súbory pri chybách formulára
                        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                            $avatarUploadResult = processAvatarUpload($_FILES['avatar']);
                            if (!empty($avatarUploadResult['error'])) {
                                $errors[] = $avatarUploadResult['error'];
                            } else {
                                $avatarPath = $avatarUploadResult['path'];
                            }
                        }
                    }

                    if (empty($errors)) {
                        $sql = "INSERT INTO users (
                            username, email, password_hash, gender, pronouns, avatar_path, title_before, first_name, middle_name, last_name,
                            title_after, name_note, organization, job_function, work_mobile_phone, org_website,
                            work_email, mobile_phone, other_phone, social_linkedin, social_x, social_facebook, social_instagram, social_other, other_contact, website, birth_date,
                            street, house_number, orientation_number, zip_code, city, district, region, country, address_note, newsletter_consent, theme_auto, email_verified_at,
                            email_verification_token_hash, email_verification_expires_at, email_verification_sent_at
                        ) VALUES (
                            :username, :email, :password_hash, :gender, :pronouns, :avatar_path, :title_before, :first_name, :middle_name, :last_name,
                            :title_after, :name_note, :organization, :job_function, :work_mobile_phone, :org_website,
                            :work_email, :mobile_phone, :other_phone, :social_linkedin, :social_x, :social_facebook, :social_instagram, :social_other, :other_contact, :website, :birth_date,
                            :street, :house_number, :orientation_number, :zip_code, :city, :district, :region, :country, :address_note, :newsletter_consent, :theme_auto, NULL,
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
                            'theme_auto' => $themeAuto,
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
                                'ip' => getClientIpAddress(),
                                'user_agent' => (string) ($_SERVER['HTTP_USER_AGENT'] ?? ''),
                                'referer' => (string) ($_SERVER['HTTP_REFERER'] ?? ''),
                                'request_uri' => (string) ($_SERVER['REQUEST_URI'] ?? ''),
                            ]);
                            if (!$adminNoticeSent) {
                                error_log('Registrácia: admin notifikačný e-mail sa nepodarilo odoslať pre user_id=' . $newUserId);
                            }
                        }

                        if ($sent) {
                            setFlashMessage('success', 'Registrácia prebehla úspešne. Overovací e-mail bol odoslaný.');
                        } else {
                            setFlashMessage('warning', 'Registrácia prebehla úspešne, ale overovací e-mail sa nepodarilo odoslať. Skúste ho odoslať znova.');
                        }

                        header('Location: register.php?registered=1');
                        exit;
                    }
                }
            } catch (\PDOException $e) {
                error_log("Chyba registrácie: " . $e->getMessage());
                if ((string) $e->getCode() === '23000') {
                    $errors[] = 'Registrácia sa nepodarila. Zadajte iný e-mail alebo používateľské meno.';
                } else {
                    $errors[] = "Vyskytla sa chyba pri registrácii. Skúste to prosím neskôr.";
                }
            }
        }
        } // if (!$regIsBlocked)
        } // !$isBotRequest else
    }
} else {
    // GET požiadavka: zaznamenaj čas načítania pre ochranu pred botmi
    markFormLoadTime('register');
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'Registrácia | Nefro-projekt Slovensko';
  $seoDescription = 'Zaregistrujte sa do Nefro-projekt Slovensko — odborného portálu pre nefrológov a lekárov.';
  $robotsMeta = 'noindex, follow';
  $canonicalUrl = 'https://nefro.polascin.net/register.php';
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Nefro-projekt Slovensko';
    $showLogo = false;
    include 'header.php';
    ?>

    <main id="main-content" class="container" role="main">
        <div class="auth-container auth-container--wide">
            <h2>Registrácia</h2>
            <p class="auth-subtitle">Vytvorte si účet za pár sekúnd — stačí e-mail a heslo. Ostatné údaje sú nepovinné a môžete ich kedykoľvek doplniť vo svojom profile.</p>

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

            <?php if (isset($_GET['registered']) && $_GET['registered'] === '1'): ?>
                <div class="alert alert-success">
                    Ďakujeme za registráciu. Skontrolujte svoju e-mailovú schránku a dokončite overenie účtu.
                </div>
                <div class="auth-links">
                    <p>Ak ste e-mail nedostali, môžete si ho <a href="resend_verification.php">odoslať znova</a>.</p>
                    <p>Po overení sa prihláste na <a href="login.php">prihlasovacej stránke</a>.</p>
                </div>
            <?php else: ?>
                <form method="POST" action="register.php" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <input type="hidden" name="js_token" id="js_token_field" value="">
                    <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
                        // JS Challenge: Vloží token po načítaní stránky. Boti bez JS toto nespustia.
                        document.addEventListener('DOMContentLoaded', function() {
                            document.getElementById('js_token_field').value = "<?= htmlspecialchars(generateJsChallengeToken(), ENT_QUOTES) ?>";
                        });
                    </script>

                    <!-- Honeypot pole: neviditeľné pre ľudí, vypĺňajú ho iba boti. Musí ostať prázdne. -->
                    <div class="honeypot" aria-hidden="true" tabindex="-1">
                        <label for="website_url">Webová adresa (nevypĺňať)</label>
                        <input type="text" id="website_url" name="website_url" value="" autocomplete="off" tabindex="-1" maxlength="255">
                    </div>

                    <div class="form-section">
                        <h3>Vytvorenie účtu</h3>
                        <p class="form-section-hint">Na vytvorenie účtu stačí e-mail a heslo. Všetko ostatné je nepovinné — môžete to doplniť nižšie alebo kedykoľvek neskôr vo svojom profile.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="email">E-mailová adresa *</label>
                                <input type="email" id="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="email">
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

                    <div class="form-check">
                        <input type="checkbox" id="newsletter_consent" name="newsletter_consent" value="1" <?= isset($_POST['newsletter_consent']) ? 'checked' : '' ?>>
                        <label for="newsletter_consent">Chcem dostávať nové odborné články do e-mailu — nové štúdie, zmeny v odporúčaniach a praktické závery pre prax. Zadarmo, kedykoľvek sa odhlásite.</label>
                    </div>

                    <details class="register-optional">
                      <summary class="register-optional__summary">Doplniť ďalšie údaje (titul, pracovisko, adresa, sociálne siete) — nepovinné</summary>

                    <div class="form-section">
                        <h3>Základné a osobné údaje</h3>

                        <div class="avatar-upload-group">
                            <img src="" id="avatarPreview" alt="Náhľad avatara" class="avatar-upload-preview">
                            <div>
                                <label for="avatar" class="avatar-upload-label">Profilová fotografia (Avatar)</label>
                                <input type="file" id="avatar" name="avatar" class="form-control" accept="image/jpeg, image/png, image/gif, image/webp">
                                <small class="avatar-upload-hint">Max. 2 MB (JPG, PNG, GIF, WebP). Ak nevyberiete, použije sa univerzálny avatar.</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username">Používateľské meno (ak nevyplníte, použije sa e-mail)</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autocomplete="username">
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
                                <?php $titlesBefore = getTitlesBeforeName($pdo); ?>
                                <input type="text" id="title_before" name="title_before" class="form-control"
                                    list="title_before_list"
                                    value="<?= htmlspecialchars($_POST['title_before'] ?? '') ?>"
                                    placeholder="napr. MUDr. alebo MUDr. doc."
                                    autocomplete="off">
                                <datalist id="title_before_list">
                                    <?php foreach ($titlesBefore as $t): ?>
                                        <option value="<?= htmlspecialchars($t) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                                <small class="avatar-upload-hint">Vyberte zo zoznamu alebo zadajte vlastný titul (prípadne aj kombináciu viacerých).</small>
                            </div>
                            <div class="form-group">
                                <label for="first_name">Prvé (krstné) meno</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" autocomplete="given-name">
                            </div>
                            <div class="form-group">
                                <label for="middle_name">Stredné meno/á</label>
                                <input type="text" id="middle_name" name="middle_name" class="form-control" value="<?= htmlspecialchars($_POST['middle_name'] ?? '') ?>" autocomplete="additional-name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Priezvisko</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" autocomplete="family-name">
                            </div>
                            <div class="form-group">
                                <label for="title_after">Titul za menom</label>
                                <?php $titlesAfter = getTitlesAfterName($pdo); ?>
                                <input type="text" id="title_after" name="title_after" class="form-control"
                                    list="title_after_list"
                                    value="<?= htmlspecialchars($_POST['title_after'] ?? '') ?>"
                                    placeholder="napr. PhD. alebo PhD., MBA"
                                    autocomplete="off">
                                <datalist id="title_after_list">
                                    <?php foreach ($titlesAfter as $t): ?>
                                        <option value="<?= htmlspecialchars($t) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                                <small class="avatar-upload-hint">Vyberte zo zoznamu alebo zadajte vlastný titul (prípadne aj kombináciu viacerých).</small>
                            </div>
                            <div class="form-group">
                                <label for="birth_date">Dátum narodenia</label>
                                <input type="date" id="birth_date" name="birth_date" class="form-control" value="<?= htmlspecialchars($_POST['birth_date'] ?? '') ?>" autocomplete="bday">
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
                                <input type="text" id="organization" name="organization" class="form-control" value="<?= htmlspecialchars($_POST['organization'] ?? '') ?>" autocomplete="organization">
                            </div>
                            <div class="form-group">
                                <label for="job_function">Funkcia</label>
                                <input type="text" id="job_function" name="job_function" class="form-control" value="<?= htmlspecialchars($_POST['job_function'] ?? '') ?>" autocomplete="organization-title">
                            </div>
                            <div class="form-group">
                                <label for="work_mobile_phone">Číslo pracovného mobilného telefónu (voliteľné)</label>
                                <input type="tel" id="work_mobile_phone" name="work_mobile_phone" class="form-control" value="<?= htmlspecialchars($_POST['work_mobile_phone'] ?? '') ?>" placeholder="+421 901 234 567" pattern="^\+421[0-9\s\-()\.\/]{8,20}$" title="Zadajte číslo vo formáte +421XXXXXXXXX alebo +421 901 234 567" autocomplete="work tel-national">
                            </div>
                            <div class="form-group">
                                <label for="org_website">Webové stránky organizácie</label>
                                <input type="url" id="org_website" name="org_website" class="form-control" value="<?= htmlspecialchars($_POST['org_website'] ?? '') ?>" autocomplete="url">
                            </div>
                            <div class="form-group">
                                <label for="work_email">Pracovný e-mail</label>
                                <input type="email" id="work_email" name="work_email" class="form-control" value="<?= htmlspecialchars($_POST['work_email'] ?? '') ?>" autocomplete="work email">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Kontaktné údaje</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="mobile_phone">Číslo súkromného mobilného telefónu</label>
                                <input type="tel" id="mobile_phone" name="mobile_phone" class="form-control" value="<?= htmlspecialchars($_POST['mobile_phone'] ?? '') ?>" placeholder="+421 901 234 567" pattern="^\+421[0-9\s\-()\.\/]{8,20}$" title="Zadajte číslo vo formáte +421XXXXXXXXX alebo +421 901 234 567" autocomplete="tel">
                                <small class="avatar-upload-hint">Povolený je iba medzinárodný formát začínajúci znakom +.</small>
                            </div>
                            <div class="form-group">
                                <label for="other_phone">Iné telefónne číslo</label>
                                <input type="tel" id="other_phone" name="other_phone" class="form-control" value="<?= htmlspecialchars($_POST['other_phone'] ?? '') ?>" placeholder="+421 2 1234 5678" pattern="^\+[0-9][0-9\s\-()\.\/]{7,20}$" title="Zadajte číslo v medzinárodnom formáte +XXXXXXXX, napr. +421 2 1234 5678" autocomplete="tel">
                            </div>
                            <div class="form-group">
                                <label for="website">Osobné webové stránky</label>
                                <input type="url" id="website" name="website" class="form-control" value="<?= htmlspecialchars($_POST['website'] ?? '') ?>" autocomplete="url">
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
                        <?php
                        $addrCountries     = getCountries($pdo);
                        $addrRegions       = getRegions($pdo);
                        $addrDistricts     = getDistricts($pdo);
                        $addrMunicipalities = getMunicipalitiesWithZip($pdo);
                        $addrZips          = getZipCodes($pdo);
                        ?>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="street">Ulica</label>
                                <input type="text" id="street" name="street" class="form-control"
                                    value="<?= htmlspecialchars($_POST['street'] ?? '') ?>"
                                    placeholder="napr. Hlavná"
                                    autocomplete="address-line1">
                            </div>
                            <div class="form-group">
                                <label for="house_number">Popisné číslo</label>
                                <input type="text" id="house_number" name="house_number" class="form-control"
                                    value="<?= htmlspecialchars($_POST['house_number'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="orientation_number">Orientačné číslo</label>
                                <input type="text" id="orientation_number" name="orientation_number" class="form-control"
                                    value="<?= htmlspecialchars($_POST['orientation_number'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="city">Obec</label>
                                <input type="text" id="city" name="city" class="form-control"
                                    list="city_list"
                                    value="<?= htmlspecialchars($_POST['city'] ?? '') ?>"
                                    placeholder="napr. Bratislava"
                                    autocomplete="off">
                                <datalist id="city_list">
                                    <?php foreach ($addrMunicipalities as $m): ?>
                                        <option value="<?= htmlspecialchars($m['name']) ?>"
                                            data-zip="<?= htmlspecialchars($m['zip_code']) ?>"
                                            data-district="<?= htmlspecialchars($m['district_name']) ?>"
                                            data-region="<?= htmlspecialchars(getRegionNameByCode($pdo, $m['region_code'])) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                                <small class="avatar-upload-hint">Výberom obce sa automaticky doplní PSČ, okres a kraj.</small>
                            </div>
                            <div class="form-group">
                                <label for="zip_code">PSČ</label>
                                <input type="text" id="zip_code" name="zip_code" class="form-control"
                                    list="zip_list"
                                    value="<?= htmlspecialchars($_POST['zip_code'] ?? '') ?>"
                                    placeholder="napr. 81101"
                                    maxlength="6" autocomplete="off">
                                <datalist id="zip_list">
                                    <?php foreach ($addrZips as $z): ?>
                                        <option value="<?= htmlspecialchars($z) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label for="district">Okres</label>
                                <input type="text" id="district" name="district" class="form-control"
                                    list="district_list"
                                    value="<?= htmlspecialchars($_POST['district'] ?? '') ?>"
                                    placeholder="napr. Bratislava I"
                                    autocomplete="off">
                                <datalist id="district_list">
                                    <?php foreach ($addrDistricts as $d): ?>
                                        <option value="<?= htmlspecialchars($d) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label for="region">Kraj</label>
                                <input type="text" id="region" name="region" class="form-control"
                                    list="region_list"
                                    value="<?= htmlspecialchars($_POST['region'] ?? '') ?>"
                                    placeholder="napr. Bratislavský kraj"
                                    autocomplete="off">
                                <datalist id="region_list">
                                    <?php foreach ($addrRegions as $r): ?>
                                        <option value="<?= htmlspecialchars($r) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label for="country">Štát</label>
                                <input type="text" id="country" name="country" class="form-control"
                                    list="country_list"
                                    value="<?= htmlspecialchars($_POST['country'] ?? '') ?>"
                                    placeholder="napr. Slovenská republika"
                                    autocomplete="off">
                                <datalist id="country_list">
                                    <?php foreach ($addrCountries as $c): ?>
                                        <option value="<?= htmlspecialchars($c) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address_note">Poznámka k adrese</label>
                            <input type="text" id="address_note" name="address_note" class="form-control"
                                value="<?= htmlspecialchars($_POST['address_note'] ?? '') ?>">
                        </div>
                    </div>


                    <div class="form-check">
                        <input type="checkbox" id="theme_auto" name="theme_auto" value="1" <?= (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST' || isset($_POST['theme_auto'])) ? 'checked' : '' ?>>
                        <label for="theme_auto">Automaticky prispôsobovať tému (svetlá/tmavá) podľa nastavenia systému</label>
                    </div>
                    </details>

                    <p class="auth-consent-note">
                        Registráciou súhlasíte s našimi <a href="terms.php">Podmienkami používania</a>
                        a <a href="privacy.php">Zásadami ochrany osobných údajov</a>.
                    </p>

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
    <script src="address-autofill.js?cb=<?= filemtime('address-autofill.js') ?>" defer></script>
    <?php include 'footer.php'; ?>
