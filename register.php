<?php
require_once 'auth.php';
require_once 'db_config.php';

$errors = [];
$success = false;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = "Neplatný CSRF token. Skúste to znova.";
    } else {
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $username = trim($_POST['username'] ?? '');
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Zadajte platnú e-mailovú adresu.";
        }
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $errors[] = "Heslo musí mať aspoň 8 znakov, obsahovať aspoň jedno veľké písmeno, malé písmeno a číslicu.";
        }
        
        if (empty($username)) {
            $username = $email;
        }

        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                if ($stmt->fetch()) {
                    $errors[] = "Používateľ s týmto e-mailom už existuje.";
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $newsletterConsent = isset($_POST['newsletter_consent']) ? 1 : 0;
                    $gender = trim($_POST['gender'] ?? '');
                    $pronouns = trim($_POST['pronouns'] ?? '');
                    
                    // Spracovanie avatara
                    $avatarPath = null;
                    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                        $fileTmpPath = $_FILES['avatar']['tmp_name'];
                        $fileName = $_FILES['avatar']['name'];
                        $fileSize = $_FILES['avatar']['size'];
                        $fileType = mime_content_type($fileTmpPath);
                        
                        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                        $maxFileSize = 2 * 1024 * 1024; // 2 MB
                        
                        if (!in_array($fileType, $allowedMimeTypes)) {
                            $errors[] = "Nepovolený formát obrázka. Povolené sú iba JPG, PNG, GIF a WebP.";
                        } elseif ($fileSize > $maxFileSize) {
                            $errors[] = "Obrázok je príliš veľký. Maximálna povolená veľkosť je 2 MB.";
                        } else {
                            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                            $newFileName = uniqid('avatar_', true) . '.' . $fileExtension;
                            $uploadDir = 'uploads/avatars/';
                            $destPath = $uploadDir . $newFileName;
                            
                            if (move_uploaded_file($fileTmpPath, $destPath)) {
                                $avatarPath = $destPath;
                            } else {
                                $errors[] = "Nastala chyba pri nahrávaní obrázka.";
                            }
                        }
                    }

                    if (empty($errors)) {
                        $sql = "INSERT INTO users (
                            username, email, password_hash, gender, pronouns, avatar_path, title_before, first_name, middle_name, last_name,
                            title_after, name_note, organization, job_function, work_mobile_phone, org_website,
                            work_email, mobile_phone, other_phone, social_linkedin, social_x, social_facebook, social_instagram, social_other, other_contact, website, birth_date,
                            street, house_number, orientation_number, zip_code, city, region, country, address_note, newsletter_consent
                        ) VALUES (
                            :username, :email, :password_hash, :gender, :pronouns, :avatar_path, :title_before, :first_name, :middle_name, :last_name,
                            :title_after, :name_note, :organization, :job_function, :work_mobile_phone, :org_website,
                            :work_email, :mobile_phone, :other_phone, :social_linkedin, :social_x, :social_facebook, :social_instagram, :social_other, :other_contact, :website, :birth_date,
                            :street, :house_number, :orientation_number, :zip_code, :city, :region, :country, :address_note, :newsletter_consent
                        )";
                        
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
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
                            'work_mobile_phone' => trim($_POST['work_mobile_phone'] ?? ''),
                            'org_website' => trim($_POST['org_website'] ?? ''),
                            'work_email' => trim($_POST['work_email'] ?? ''),
                            'mobile_phone' => trim($_POST['mobile_phone'] ?? ''),
                            'other_phone' => trim($_POST['other_phone'] ?? ''),
                            'social_linkedin' => trim($_POST['social_linkedin'] ?? ''),
                            'social_x' => trim($_POST['social_x'] ?? ''),
                            'social_facebook' => trim($_POST['social_facebook'] ?? ''),
                            'social_instagram' => trim($_POST['social_instagram'] ?? ''),
                            'social_other' => trim($_POST['social_other'] ?? ''),
                            'other_contact' => trim($_POST['other_contact'] ?? ''),
                            'website' => trim($_POST['website'] ?? ''),
                            'birth_date' => !empty($_POST['birth_date']) ? $_POST['birth_date'] : null,
                            'street' => trim($_POST['street'] ?? ''),
                            'house_number' => trim($_POST['house_number'] ?? ''),
                            'orientation_number' => trim($_POST['orientation_number'] ?? ''),
                            'zip_code' => trim($_POST['zip_code'] ?? ''),
                            'city' => trim($_POST['city'] ?? ''),
                            'region' => trim($_POST['region'] ?? ''),
                            'country' => trim($_POST['country'] ?? ''),
                            'address_note' => trim($_POST['address_note'] ?? ''),
                            'newsletter_consent' => $newsletterConsent
                        ]);
                        
                        $success = true;
                    }
                }
            } catch (\PDOException $e) {
                error_log("Chyba registrácie: " . $e->getMessage());
                $errors[] = "Vyskytla sa chyba pri registrácii. Skúste to prosím neskôr.";
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
                    Registrácia prebehla úspešne. Teraz sa môžete <strong><a href="login.php">prihlásiť</a></strong>.
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
                                <label for="password">Heslo <small>(min. 8 znakov, veľké/malé písmená a číslice)</small> *</label>
                                <input type="password" id="password" name="password" class="form-control" required>
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
                                <label for="work_mobile_phone">Číslo pracovného mobilného telefónu</label>
                                <input type="tel" id="work_mobile_phone" name="work_mobile_phone" class="form-control" value="<?= htmlspecialchars($_POST['work_mobile_phone'] ?? '') ?>">
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
                                <label for="mobile_phone">Číslo súkromného mobilného telefónu</label>
                                <input type="tel" id="mobile_phone" name="mobile_phone" class="form-control" value="<?= htmlspecialchars($_POST['mobile_phone'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="other_phone">Iné telefónne číslo</label>
                                <input type="tel" id="other_phone" name="other_phone" class="form-control" value="<?= htmlspecialchars($_POST['other_phone'] ?? '') ?>">
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
                                <input type="url" id="social_linkedin" name="social_linkedin" class="form-control" value="<?= htmlspecialchars($_POST['social_linkedin'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="social_x">X (Twitter) profil</label>
                                <input type="url" id="social_x" name="social_x" class="form-control" value="<?= htmlspecialchars($_POST['social_x'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="social_facebook">Facebook profil</label>
                                <input type="url" id="social_facebook" name="social_facebook" class="form-control" value="<?= htmlspecialchars($_POST['social_facebook'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="social_instagram">Instagram profil</label>
                                <input type="url" id="social_instagram" name="social_instagram" class="form-control" value="<?= htmlspecialchars($_POST['social_instagram'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="social_other">Iné sociálne siete (odkazy)</label>
                            <input type="text" id="social_other" name="social_other" class="form-control" value="<?= htmlspecialchars($_POST['social_other'] ?? '') ?>">
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
