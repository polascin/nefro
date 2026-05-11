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
        // Jednoduchý limit pre brute-force (sleep)
        sleep(1);

        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $errors[] = "Zadajte e-mail a heslo.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id, password_hash, username FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password_hash'])) {
                    // Prihlásenie úspešné
                    regenerateSession();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: index.php");
                    exit;
                } else {
                    $errors[] = "Nesprávny e-mail alebo heslo.";
                }
            } catch (\PDOException $e) {
                error_log("Chyba prihlásenia: " . $e->getMessage());
                $errors[] = "Vyskytla sa chyba. Skúste to prosím neskôr.";
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
                    <label for="email">E-mailová adresa</label>
                    <input type="email" id="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
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
</body>
</html>
