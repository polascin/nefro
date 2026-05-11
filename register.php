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
        if (strlen($password) < 8) {
            $errors[] = "Heslo musí mať aspoň 8 znakov.";
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
                    
                    $sql = "INSERT INTO users (
                        username, email, password_hash, title_before, first_name, middle_name, last_name,
                        title_after, name_note, organization, job_function, work_email, mobile_phone,
                        other_phone, social_media, other_contact, website, birth_date, street, house_number,
                        orientation_number, zip_code, city, region, country, address_note, newsletter_consent
                    ) VALUES (
                        :username, :email, :password_hash, :title_before, :first_name, :middle_name, :last_name,
                        :title_after, :name_note, :organization, :job_function, :work_email, :mobile_phone,
                        :other_phone, :social_media, :other_contact, :website, :birth_date, :street, :house_number,
                        :orientation_number, :zip_code, :city, :region, :country, :address_note, :newsletter_consent
                    )";
                    
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        'username' => $username,
                        'email' => $email,
                        'password_hash' => $passwordHash,
                        'title_before' => trim($_POST['title_before'] ?? ''),
                        'first_name' => trim($_POST['first_name'] ?? ''),
                        'middle_name' => trim($_POST['middle_name'] ?? ''),
                        'last_name' => trim($_POST['last_name'] ?? ''),
                        'title_after' => trim($_POST['title_after'] ?? ''),
                        'name_note' => trim($_POST['name_note'] ?? ''),
                        'organization' => trim($_POST['organization'] ?? ''),
                        'job_function' => trim($_POST['job_function'] ?? ''),
                        'work_email' => trim($_POST['work_email'] ?? ''),
                        'mobile_phone' => trim($_POST['mobile_phone'] ?? ''),
                        'other_phone' => trim($_POST['other_phone'] ?? ''),
                        'social_media' => trim($_POST['social_media'] ?? ''),
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
    <script src="theme.js?v=20260509-1"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <header class="site-header" role="banner">
        <div class="container">
            <h1><a href="index.php" style="text-decoration:none; color:inherit;">Nefro-projekt Slovensko</a></h1>
        </div>
    </header>

    <main class="container">
        <div class="auth-container" style="max-width: 800px;">
            <h2>Registrácia</h2>
            
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
                    Registrácia prebehla úspešne. Teraz sa môžete <a href="login.php" style="font-weight:bold;">prihlásiť</a>.
                </div>
            <?php else: ?>
                <form method="POST" action="register.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    
                    <div class="form-section">
                        <h3>Povinné údaje</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="email">E-mailová adresa *</label>
                                <input type="email" id="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Heslo * (min. 8 znakov)</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Základné a osobné údaje</h3>
                        <div class="form-group">
                            <label for="username">Používateľské meno (ak nevyplníte, použije sa e-mail)</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                        </div>
                        <div class="form-grid">
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
                        <h3>Pracovné a kontaktné údaje</h3>
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
                                <label for="work_email">Pracovný e-mail</label>
                                <input type="email" id="work_email" name="work_email" class="form-control" value="<?= htmlspecialchars($_POST['work_email'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="mobile_phone">Číslo mobilného telefónu</label>
                                <input type="tel" id="mobile_phone" name="mobile_phone" class="form-control" value="<?= htmlspecialchars($_POST['mobile_phone'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="other_phone">Iné telefónne číslo</label>
                                <input type="tel" id="other_phone" name="other_phone" class="form-control" value="<?= htmlspecialchars($_POST['other_phone'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="website">Webové stránky používateľa</label>
                                <input type="url" id="website" name="website" class="form-control" value="<?= htmlspecialchars($_POST['website'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="social_media">Kontakty na sociálne siete</label>
                            <input type="text" id="social_media" name="social_media" class="form-control" value="<?= htmlspecialchars($_POST['social_media'] ?? '') ?>">
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
</body>
</html>
