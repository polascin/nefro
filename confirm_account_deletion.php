<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
header('Referrer-Policy: no-referrer');
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/email_verification.php';

$requestMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if (!in_array($requestMethod, ['GET', 'POST'], true)) {
    http_response_code(405);
    header('Allow: GET, POST');
    exit;
}

$errors = [];
$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
$tokenFormatValid = preg_match('/^[A-Za-z0-9_-]{32,128}$/D', $token) === 1;
$token = $tokenFormatValid ? $token : '';
$tokenHash = $token !== '' ? hash('sha256', $token) : '';
$deletionRequest = null;

if ($tokenHash !== '') {
    try {
        $stmt = $pdo->prepare(
            "SELECT adt.user_id, u.email, u.avatar_path,
                    u.is_admin, u.newsletter_consent, u.created_at
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

if ($requestMethod === 'POST') {
    $postedCsrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($postedCsrfToken)) {
        $errors[] = "Neplatný CSRF token. Skúste to znova.";
    } elseif (empty($deletionRequest)) {
        $errors[] = "Potvrdzovací odkaz je neplatný alebo expiroval.";
    } elseif (!empty($deletionRequest['is_admin'])) {
        $errors[] = "Administrátorský účet nie je možné zrušiť týmto spôsobom.";
    } else {
        $userId   = (int) $deletionRequest['user_id'];
        $clientIp = getClientIpAddress();
        $userAgent = mb_substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500);
        $avatarFilesToDelete = [];
        $avatarArchiveDir = null;

        try {
            $pdo->beginTransaction();

            // Token aj účet opätovne načítame pod riadkovým zámkom. Súbežné
            // požiadavky tak nemôžu ten istý mazací token spracovať dvakrát.
            $lockStmt = $pdo->prepare(
                "SELECT adt.user_id, u.email, u.avatar_path,
                        u.is_admin, u.newsletter_consent, u.created_at
                 FROM account_deletion_tokens adt
                 INNER JOIN users u ON u.id = adt.user_id
                 WHERE adt.token_hash = :token_hash
                   AND adt.expires_at >= NOW()
                 LIMIT 1
                 FOR UPDATE"
            );
            $lockStmt->execute(['token_hash' => $tokenHash]);
            $lockedDeletionRequest = $lockStmt->fetch();
            if (!is_array($lockedDeletionRequest)) {
                throw new \DomainException('Potvrdzovací odkaz už bol použitý alebo jeho platnosť vypršala.');
            }
            if (!empty($lockedDeletionRequest['is_admin'])) {
                throw new \DomainException('Administrátorský účet nie je možné zrušiť týmto spôsobom.');
            }
            $deletionRequest = $lockedDeletionRequest;
            $userId = (int) $deletionRequest['user_id'];

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
                    :had_avatar, :had_newsletter_consent
                )"
            )->execute([
                ':uid'            => $userId,
                ':username'       => '(vymazané)',
                ':email_hash'     => $emailHash,
                ':email_domain'   => mb_substr($emailDomain, 0, 255),
                ':is_admin'       => 0,
                ':age_days'       => $ageDays,
                ':client_ip'      => mb_substr($clientIp, 0, 45),
                ':user_agent'     => $userAgent,
                ':calc_results'   => $statCalc,
                ':profile_changes'=> $statProfile,
                ':had_avatar'     => empty($deletionRequest['avatar_path']) ? 0 : 1,
                ':had_newsletter_consent' => (int) ($deletionRequest['newsletter_consent'] ?? 0) === 1 ? 1 : 0,
            ]);

            // Cesty k avatarom pripravíme v transakcii, ale súbory zmažeme až po commite.
            // Rollback tak nikdy nenechá existujúci účet bez avatarov.
            $avatarPath = $deletionRequest['avatar_path'] ?? null;
            if (!empty($avatarPath)) {
                $uploadsRoot = realpath(__DIR__ . '/uploads/avatars');
                $candidate   = realpath(__DIR__ . '/' . ltrim(str_replace('\\', '/', $avatarPath), '/'));
                if ($uploadsRoot !== false && $candidate !== false
                    && str_starts_with($candidate, $uploadsRoot . DIRECTORY_SEPARATOR)
                    && is_file($candidate)
                ) {
                    $avatarFilesToDelete[] = $candidate;
                }
            }
            $archiveDir = realpath(__DIR__ . '/uploads/avatars/archive/' . $userId);
            if ($archiveDir !== false && is_dir($archiveDir)) {
                foreach (glob($archiveDir . '/*') as $archFile) {
                    if (is_file($archFile)) {
                        $avatarFilesToDelete[] = $archFile;
                    }
                }
                $avatarArchiveDir = $archiveDir;
            }

            // Prístupové logy ostanú len ako minimalizované technické záznamy bez väzby na účet.
            $pdo->prepare(
                "UPDATE access_logs SET user_id = NULL, username = NULL WHERE user_id = :id"
            )->execute(['id' => $userId]);

            // Vymazanie záznamu tokenu (FK CASCADE zmažú aj account_deletion_tokens)
            // DB: CASCADE vymaže users_profile_archive, users_avatar_archive,
            //     password_resets, account_deletion_tokens, calculator_results, article_newsletter_queue,
            //     access_logs (user_id FK = SET NULL), admin_users_notice_audit (CASCADE)
            $deleteUserStmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $deleteUserStmt->execute(['id' => $userId]);
            if ($deleteUserStmt->rowCount() !== 1) {
                throw new \RuntimeException('Uzamknutý používateľský účet sa nepodarilo vymazať.');
            }

            $pdo->commit();

            foreach (array_unique($avatarFilesToDelete) as $avatarFile) {
                if (is_file($avatarFile) && !@unlink($avatarFile)) {
                    error_log('Po zmazaní účtu sa nepodarilo odstrániť avatar: ' . $avatarFile);
                }
            }
            if ($avatarArchiveDir !== null && is_dir($avatarArchiveDir) && !@rmdir($avatarArchiveDir)) {
                error_log('Po zmazaní účtu sa nepodarilo odstrániť adresár avatarov: ' . $avatarArchiveDir);
            }

            // Fallback súborový log
            $logDir = __DIR__ . '/private/logs';
            @mkdir($logDir, 0750, true);
            @chmod($logDir, 0750);
            $logFile = $logDir . '/account_deletions.log';
            $logLine = implode("\t", [
                date('Y-m-d H:i:s'),
                'account_deleted',
                $userId,
                '(vymazané)',
                'user_self',
                $clientIp,
            ]) . "\n";
            if (@file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX) !== false) {
                @chmod($logFile, 0640);
            }

            // Zničenie relácie (pokiaľ bol používateľ prihlásený)
            clearUserSession();

            header('Location: login.php?account_deleted=1', true, 303);
            exit;

        } catch (\DomainException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $errors[] = $e->getMessage();
            $deletionRequest = null;
        } catch (\Throwable $e) {
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
  $seoDescription = 'Súkromné potvrdenie žiadosti o zrušenie používateľského účtu.';
  $robotsMeta = 'noindex, nofollow';
  $canonicalUrl = getAppBaseUrl() . '/confirm_account_deletion.php';
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

            <?php if (empty($deletionRequest)): ?>
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
                        vrátane profilu, avatarov a uložených výsledkov kalkulačiek. Minimalizovaný
                        bezpečnostný audit vykonania žiadosti bez používateľského mena môžeme uchovať
                        najviac 90 dní podľa Zásad ochrany osobných údajov.
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
