<?php
declare(strict_types=1);
require_once 'auth.php';
require_once 'db_config.php';

$errors = [];
$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
// Validácia formátu tokenu pred hashovaním (base64url: A-Z a-z 0-9 - _)
if ($token !== '' && !preg_match('/^[A-Za-z0-9_\-]{32,128}$/', $token)) {
    $token = '';
}
$tokenHash = $token !== '' ? hash('sha256', $token) : '';
$resetRequest = null;

if ($tokenHash !== '') {
    try {
        $stmt = $pdo->prepare("SELECT pr.id, pr.user_id, u.email, u.username
            FROM password_resets pr
            INNER JOIN users u ON u.id = pr.user_id
            WHERE pr.token_hash = :token_hash
              AND pr.used_at IS NULL
              AND pr.expires_at >= NOW()
            LIMIT 1");
        $stmt->execute(['token_hash' => $tokenHash]);
        $resetRequest = $stmt->fetch();
    } catch (\PDOException $e) {
        error_log('Reset password lookup error: ' . $e->getMessage());
        $resetRequest = null;
    }
}

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
        $newPassword = $_POST['new_password'] ?? '';
        $newPasswordConfirm = $_POST['new_password_confirm'] ?? '';

        if ($resetRequest === null) {
            $errors[] = 'Odkaz na obnovenie hesla je neplatný alebo jeho platnosť vypršala.';
        }

        if (strlen($newPassword) < 8 || strlen($newPassword) > 1024 || !preg_match('/[A-Z]/', $newPassword) || !preg_match('/[a-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
            $errors[] = 'Heslo musí mať 8–1024 znakov, obsahovať aspoň jedno veľké písmeno, malé písmeno a číslicu.';
        } elseif ($newPassword !== $newPasswordConfirm) {
            $errors[] = 'Heslá sa nezhodujú.';
        }

        if (empty($errors) && $resetRequest !== null) {
            try {
                $pdo->beginTransaction();

                $updatePwd = $pdo->prepare('UPDATE users SET password_hash = :password_hash WHERE id = :user_id');
                $updatePwd->execute([
                    'password_hash' => password_hash($newPassword, PASSWORD_DEFAULT),
                    'user_id' => (int) $resetRequest['user_id'],
                ]);

                $useToken = $pdo->prepare('UPDATE password_resets SET used_at = NOW() WHERE user_id = :user_id AND used_at IS NULL');
                $useToken->execute(['user_id' => (int) $resetRequest['user_id']]);

                $pdo->commit();

                setFlashMessage('success', 'Heslo bolo úspešne zmenené. Môžete sa prihlásiť novým heslom.');
                header('Location: login.php');
                exit;
            } catch (\PDOException $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                error_log('Reset password update error: ' . $e->getMessage());
                $errors[] = 'Pri zmene hesla došlo k chybe. Skúste to znova neskôr.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle      = 'Nastavenie nového hesla | Nefro-projekt Slovensko';
  $seoDescription = 'Nastavte nové heslo pre váš účet Nefro-projekt Slovensko pomocou odkazu z e-mailu.';
  $robotsMeta     = 'noindex, nofollow';
  $canonicalUrl   = 'https://nefro.polascin.net/reset_password.php';
  include 'head_meta.php';
  ?>
</head>
<body>
    <?php
    $headerTitle = 'Nefro-projekt Slovensko';
    $showLogo = false;
    include 'header.php';
    ?>

    <main class="container">
        <div class="auth-container">
            <h2>Nastavenie nového hesla</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($resetRequest === null): ?>
                <div class="alert alert-error">
                    <p>Odkaz na obnovenie hesla je neplatný alebo jeho platnosť vypršala.</p>
                </div>
                <div class="auth-links">
                    <p><a href="forgot_password.php">Požiadať o nový odkaz</a></p>
                    <p><a href="login.php">Späť na prihlásenie</a></p>
                </div>
            <?php else: ?>
                <p class="auth-subtitle">Účet: <strong><?= htmlspecialchars((string) ($resetRequest['email'] ?? '')) ?></strong></p>

                <form method="POST" action="reset_password.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                    <div class="form-group">
                        <label for="new_password">Nové heslo</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirm">Potvrdenie nového hesla</label>
                        <input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" required autocomplete="new-password">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary btn-block">Uložiť nové heslo</button>
                    </div>
                </form>

                <div class="auth-links">
                    <p><a href="login.php">Späť na prihlásenie</a></p>
                </div>
            <?php endif; ?>
        </div>
    </main>


    <?php include 'footer.php'; ?>
</body>
</html>
