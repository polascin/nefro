<?php
require_once 'auth.php';
require_once 'db_config.php';

// Ak už je prihlásený, presmerovať
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$errors = [];

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = "Neplatný CSRF token. Skúste to znova.";
    } else {
        // Ochrana proti brute-force útokom (Zablokovanie po 5 neúspešných pokusoch)
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['last_login_attempt'] = time();
        }

        // Reset počítadla po 5 minútach
        if (time() - $_SESSION['last_login_attempt'] > 300) {
            $_SESSION['login_attempts'] = 0;
        }

        if ($_SESSION['login_attempts'] >= 5) {
            $errors[] = "Z bezpečnostných dôvodov bolo prihlásenie zablokované. Skúste to znova o 5 minút.";
        } else {
            $loginInput = trim($_POST['login'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($loginInput) || empty($password)) {
                $errors[] = "Zadajte používateľské meno (alebo e-mail) a heslo.";
            } else {
                try {
                    $stmt = $pdo->prepare("SELECT id, password_hash, username FROM users WHERE email = :login OR username = :login");
                    $stmt->execute(['login' => $loginInput]);
                    $user = $stmt->fetch();
                    
                    if ($user && password_verify($password, $user['password_hash'])) {
                        // Prihlásenie úspešné
                        regenerateSession();
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        unset($_SESSION['login_attempts']); // Vyčistenie po úspechu
                        header("Location: index.php");
                        exit;
                    } else {
                        $_SESSION['login_attempts']++;
                        $_SESSION['last_login_attempt'] = time();
                        $errors[] = "Nesprávny e-mail alebo heslo.";
                    }
                } catch (\PDOException $e) {
                    error_log("Chyba prihlásenia: " . $e->getMessage());
                    $errors[] = "Vyskytla sa chyba. Skúste to prosím neskôr.";
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
    <title>Prihlásenie - Nefro-projekt Slovensko</title>
    <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
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
        <div class="auth-container">
            <h2>Prihlásenie</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                
                <div class="form-group">
                    <label for="login">Používateľské meno alebo e-mailová adresa</label>
                    <input type="text" id="login" name="login" class="form-control" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Heslo</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary btn-block">Prihlásiť sa</button>
                </div>
            </form>

            <div class="auth-links">
                <p>Ešte nemáte účet? <a href="register.php">Zaregistrujte sa</a></p>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
