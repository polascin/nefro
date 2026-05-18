<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'email_verification.php';

$errors = [];
$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
$tokenHash = $token !== '' ? hash('sha256', $token) : '';
$deletionRequest = null;

if ($tokenHash !== '') {
    try {
        $stmt = $pdo->prepare(
            "SELECT adt.user_id, u.email, u.username, u.password_hash, u.avatar_path,
                    u.is_admin, u.created_at
             FROM account_deletion_tokens adt
             INNER JOIN users u ON u.id = adt.user_id
             WHERE adt.token_hash = :token_hash
               AND adt.expires_at >= NOW()
             LIMIT 1"
        );
        $stmt->execute(['token_hash' => $tokenHash]);
        $deletionRequest = $stmt->fetch();
    } catch (\PDOException $e) {
        error_log('Confirm account deletion lookup error: ' . $e->getMessage());
    }
}

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $postedCsrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($postedCsrfToken)) {
        $errors[] = "Neplatný CSRF token. Skúste to znova.";
    } elseif ($deletionRequest === null) {
        $errors[] = "Potvrdzovací odkaz je neplatný alebo expiroval.";
    } elseif (!empty($deletionRequest['is_admin'])) {
        $errors[] = "Administrátorský účet nie je možné zrušiť týmto spôsobom.";
    } else {
        $userId   = (int) $deletionRequest['user_id'];
        $clientIp = getClientIpAddress();
        $userAgent = mb_substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500);

        try {
            $pdo->beginTransaction();

            // Štatistiky pred mazaním (pre audit log)
            $stCalcStmt = $pdo->prepare("SELECT COUNT(*) FROM calculator_results WHERE user_id = :uid");
            $stCalcStmt->execute([':uid' => $userId]);
            $statCalc = (int) $stCalcStmt->fetchColumn();

            $stProfStmt = $pdo->prepare("SELECT COUNT(*) FROM users_profile_archive WHERE user_id = :uid");
            $stProfStmt->execute([':uid' => $userId]);
            $statProfile = (int) $stProfStmt->fetchColumn();

            // Zapísanie audit logu pred mazaním (atomicky v transakcii)
            $emailRaw  = (string) ($deletionRequest['email'] ?? '');
            $emailHash = hash('sha256', strtolower(trim($emailRaw)));
            $emailDomain = strstr($emailRaw, '@') !== false
                ? ltrim((string) strstr($emailRaw, '@'), '@')
                : 'unknown';
            $createdAt = strtotime((string) ($deletionRequest['created_at'] ?? '')) ?: time();
            $ageDays   = (int) round((time() - $createdAt) / 86400);

            $pdo->prepare(
                "INSERT INTO account_deletion_log (
                    deleted_user_id, username, email_hash, email_domain, is_admin,
                    account_age_days, initiated_by, admin_actor_id,
                    client_ip, user_agent,
                    stat_calculator_results, stat_profile_changes,
                    had_avatar, had_newsletter_consent
                ) VALUES (
                    :uid, :username, :email_hash, :email_domain, :is_admin,
                    :age_days, 'user_self', NULL,
                    :client_ip, :user_agent,
                    :calc_results, :profile_changes,
                    :had_avatar, 0
                )"
            )->execute([
                ':uid'            => $userId,
                ':username'       => mb_substr((string) ($deletionRequest['username'] ?? ''), 0, 255),
                ':email_hash'     => $emailHash,
                ':email_domain'   => mb_substr($emailDomain, 0, 255),
                ':is_admin'       => 0,
                ':age_days'       => $ageDays,
                ':client_ip'      => mb_substr($clientIp, 0, 45),
                ':user_agent'     => $userAgent,
                ':calc_results'   => $statCalc,
                ':profile_changes'=> $statProfile,
                ':had_avatar'     => empty($deletionRequest['avatar_path']) ? 0 : 1,
            ]);

            // Vymazanie súborov avatara
            $avatarPath = $deletionRequest['avatar_path'] ?? null;
            if (!empty($avatarPath)) {
                $absPath = __DIR__ . '/' . ltrim(str_replace('\\', '/', $avatarPath), '/');
                if (is_file($absPath)) {
                    @unlink($absPath);
                }
            }
            $archiveDir = realpath(__DIR__ . '/uploads/avatars/archive/' . $userId);
            if ($archiveDir !== false && is_dir($archiveDir)) {
                foreach (glob($archiveDir . '/*') as $archFile) {
                    if (is_file($archFile)) {
                        @unlink($archFile);
                    }
                }
                @rmdir($archiveDir);
            }

            // Vymazanie záznamu tokenu (FK CASCADE zmažú aj account_deletion_tokens)
            // DB: CASCADE vymaže users_profile_archive, users_avatar_archive,
            //     password_resets, account_deletion_tokens, calculator_results, article_newsletter_queue,
            //     access_logs (user_id FK = SET NULL), admin_users_notice_audit (CASCADE)
            $pdo->prepare("DELETE FROM users WHERE id = :id")->execute(['id' => $userId]);

            $pdo->commit();

            // Fallback súborový log
            $logDir = __DIR__ . '/private/logs';
            @mkdir($logDir, 0755, true);
            $logLine = implode("\t", [
                date('Y-m-d H:i:s'),
                'account_deleted',
                $userId,
                mb_substr((string) ($deletionRequest['username'] ?? ''), 0, 255),
                'user_self',
                $clientIp,
            ]) . "\n";
            @file_put_contents($logDir . '/account_deletions.log', $logLine, FILE_APPEND | LOCK_EX);

            // Zničenie relácie (pokiaľ bol používateľ prihlásený)
            $_SESSION = [];
            if (ini_get('session.use_cookies')) {
                $p = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $p['path'], $p['domain'], $p['secure'], $p['httponly']);
            }
            session_destroy();

            header('Location: login.php?account_deleted=1');
            exit;

        } catch (\PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Zrušenie účtu zlyhalo pre user_id=' . $userId . ': ' . $e->getMessage());
            $errors[] = "Nastala chyba pri mazaní účtu. Skúste to znova neskôr.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'Potvrdenie zrušenia účtu - Nefro-projekt Slovensko';
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
            <h2>Zrušenie účtu</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($deletionRequest === null): ?>
                <div class="alert alert-error">
                    <p>Potvrdzovací odkaz je neplatný alebo expiroval (platnosť je 24 hodín).</p>
                </div>
                <div class="auth-links">
                    <p><a href="profile.php">Späť na profil</a></p>
                    <p><a href="login.php">Prihlásiť sa</a></p>
                </div>
            <?php else: ?>
                <div class="alert alert-error">
                    <p><strong>Upozornenie — táto akcia je nezvratná!</strong></p>
                    <p>Kliknutím na tlačidlo nižšie natrvalo vymažete účet
                        <strong><?= htmlspecialchars((string) ($deletionRequest['email'] ?? '')) ?></strong>
                        vrátane všetkých uložených údajov.
                    </p>
                </div>

                <form method="POST" action="confirm_account_deletion.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                    <div class="form-actions">
                        <button type="submit" class="btn-danger">Áno, natrvalo zrušiť môj účet</button>
                        <a href="profile.php" class="btn-secondary">Zrušiť</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
