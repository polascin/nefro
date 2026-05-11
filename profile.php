<?php
require_once 'auth.php';
require_once 'db_config.php';

requireLogin();

$user_id = $_SESSION['user_id'];
$errors = [];
$success = false;

// Načítanie aktuálnych údajov
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();

if (!$user) {
    // Používateľ nebol nájdený, mal by byť odhlásený
    header("Location: logout.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = "Neplatný CSRF token. Skúste to znova.";
    } else {
        // Zber polí
        $fields = [
            'username', 'gender', 'pronouns', 'title_before', 'first_name', 
            'middle_name', 'last_name', 'title_after', 'name_note', 
            'organization', 'job_function', 'work_mobile_phone', 'org_website', 
            'work_email', 'mobile_phone', 'other_phone', 'social_linkedin', 
            'social_x', 'social_facebook', 'social_instagram', 'social_other', 
            'other_contact', 'website', 'birth_date', 'street', 'house_number', 
            'orientation_number', 'zip_code', 'city', 'region', 'country', 'address_note'
        ];
        
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = trim($_POST[$field] ?? '');
            if ($data[$field] === '') {
                $data[$field] = null;
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
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
            $max_size = 2 * 1024 * 1024; // 2 MB
            $detected_mime = mime_content_type($_FILES['avatar']['tmp_name']);
            
            if ($_FILES['avatar']['size'] > $max_size) {
                $errors[] = "Súbor avatara je príliš veľký (max 2 MB).";
            } elseif (!isset($allowed_types[$detected_mime])) {
                $errors[] = "Nepodporovaný formát avatara. Povolené sú JPG, PNG, GIF a WebP.";
            } else {
                $upload_dir = __DIR__ . '/uploads/avatars/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $extension = $allowed_types[$detected_mime];
                $filename = uniqid('avatar_', true) . '.' . $extension;
                $destination = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
                    // Zmazanie starého avatara
                    if (!empty($user['avatar_path']) && file_exists(__DIR__ . '/' . $user['avatar_path'])) {
                        unlink(__DIR__ . '/' . $user['avatar_path']);
                    }
                    $avatar_path = 'uploads/avatars/' . $filename;
                } else {
                    $errors[] = "Chyba pri nahrávaní avatara.";
                }
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
                    city = :city, region = :region, country = :country, 
                    address_note = :address_note, newsletter_consent = :newsletter_consent,
                    avatar_path = :avatar_path
                    $password_query
                    WHERE id = :id";
                
                $params = $data;
                $params['avatar_path'] = $avatar_path;
                $params['id'] = $user_id;
                $params = array_merge($params, $password_params);
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                
                if (!empty($data['username'])) {
                    $_SESSION['username'] = $data['username'];
                }
                
                $success = true;
                
                // Obnova údajov
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
                $stmt->execute(['id' => $user_id]);
                $user = $stmt->fetch();
                
            } catch (\PDOException $e) {
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

            <form method="POST" action="profile.php" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">

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
                            <label for="work_mobile_phone">Číslo pracovného mobilného telefónu</label>
                            <input type="tel" id="work_mobile_phone" name="work_mobile_phone" class="form-control" value="<?= htmlspecialchars($user['work_mobile_phone'] ?? '') ?>">
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
                            <label for="mobile_phone">Číslo súkromného mobilného telefónu</label>
                            <input type="tel" id="mobile_phone" name="mobile_phone" class="form-control" value="<?= htmlspecialchars($user['mobile_phone'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="other_phone">Iné telefónne číslo</label>
                            <input type="tel" id="other_phone" name="other_phone" class="form-control" value="<?= htmlspecialchars($user['other_phone'] ?? '') ?>">
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
                            <input type="url" id="social_linkedin" name="social_linkedin" class="form-control" value="<?= htmlspecialchars($user['social_linkedin'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="social_x">X (Twitter) profil</label>
                            <input type="url" id="social_x" name="social_x" class="form-control" value="<?= htmlspecialchars($user['social_x'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="social_facebook">Facebook profil</label>
                            <input type="url" id="social_facebook" name="social_facebook" class="form-control" value="<?= htmlspecialchars($user['social_facebook'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="social_instagram">Instagram profil</label>
                            <input type="url" id="social_instagram" name="social_instagram" class="form-control" value="<?= htmlspecialchars($user['social_instagram'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="social_other">Iné sociálne siete (odkazy)</label>
                        <input type="text" id="social_other" name="social_other" class="form-control" value="<?= htmlspecialchars($user['social_other'] ?? '') ?>">
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
        if (input.files && input.files[0]) {
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
        updateDefaultAvatar();
        
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
