<?php
declare(strict_types=1);
require_once 'auth.php';
require_once 'db_config.php';
require_once 'totp.php';

// Ak je používateľ už prihlásený (2FA dokončené), presmerovať
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

// Ak nemá pending 2FA stav, presmerovať na login
if (!isTwoFactorPending()) {
    setFlashMessage('warning', 'Prihlásenie vypršalo. Prihláste sa znova.');
    header("Location: login.php");
    exit;
}

$errors       = [];
$isLocalDev   = isAppLocalDev();
$pendingUserId = (int) ($_SESSION['2fa_pending']['user_id'] ?? 0);

// Rate limiting pre 2FA pokusy (max 5 pokusov, potom 15 minút blokácia)
$maxAttempts = 5;
$blockSecs   = 900;
$clientIp    = getClientIpAddress();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $postedCsrfToken = $_POST['csrf_token'] ?? '';

    if (!validateCsrfToken($postedCsrfToken)) {
        $errors[] = "Neplatný CSRF token. Skúste to znova.";
    } else {
        // Načítanie používateľa
        $user = null;
        try {
            $stmt = $pdo->prepare(
                "SELECT id, email, username, is_admin, is_active, email_verified_at,
                        totp_secret, totp_enabled, totp_backup_codes
                 FROM users WHERE id = :id"
            );
            $stmt->execute(['id' => $pendingUserId]);
            $user = $stmt->fetch();
        } catch (\PDOException $e) {
            error_log("2fa_verify: DB chyba pri načítaní používateľa: " . $e->getMessage());
            $errors[] = "Nastala chyba. Skúste to znova neskôr.";
        }

        if (empty($errors) && (!$user || !(int) ($user['is_active'] ?? 0) || (int) ($user['totp_enabled'] ?? 0) !== 1)) {
            // Neplatný stav — bezpečné vyčistenie a presmerovanie na login
            unset($_SESSION['2fa_pending']);
            setFlashMessage('warning', 'Prihlásenie sa nepodarilo. Skúste to znova.');
            header("Location: login.php");
            exit;
        }

        if (empty($errors)) {
            // IP rate limiting
            $ipBlocked = false;
            try {
                $pdo->prepare("DELETE FROM totp_attempts WHERE blocked_until IS NOT NULL AND blocked_until < DATE_SUB(NOW(), INTERVAL 1 DAY)")
                    ->execute();
                $laStmt = $pdo->prepare("SELECT attempt_count, blocked_until FROM totp_attempts WHERE ip = :ip");
                $laStmt->execute(['ip' => $clientIp]);
                $laRow = $laStmt->fetch();
                if ($laRow && !empty($laRow['blocked_until'])) {
                    $blockedUntilTs = strtotime((string) $laRow['blocked_until']);
                    if ($blockedUntilTs !== false && $blockedUntilTs > time()) {
                        $ipBlocked = true;
                        $errors[]  = "Z bezpečnostných dôvodov bol prístup dočasne zablokovaný. Skúste to znova o 15 minút.";
                    } else {
                        $pdo->prepare("UPDATE totp_attempts SET blocked_until = NULL WHERE ip = :ip")
                            ->execute(['ip' => $clientIp]);
                    }
                }
            } catch (\PDOException $e) {
                error_log("2fa_verify: rate limit check: " . $e->getMessage());
            }

            // Kontrola počtu pokusov v session (aj per-session limit)
            $sessionAttempts = (int) ($_SESSION['2fa_pending']['attempts'] ?? 0);
            if (!$ipBlocked && $sessionAttempts >= $maxAttempts) {
                $ipBlocked = true;
                $errors[]  = "Príliš veľa neúspešných pokusov. Skúste sa prihlásiť znova.";
                unset($_SESSION['2fa_pending']);
            }

            if (!$ipBlocked && empty($errors)) {
                $inputCode = trim($_POST['totp_code'] ?? '');

                // Overenie: TOTP kód ALEBO záložný kód
                $totpOk   = false;
                $backupOk = false;

                // Skús TOTP
                if (verifyTotpCode((string) $user['totp_secret'], $inputCode)) {
                    $totpOk = true;
                }

                // Skús záložný kód (ak TOTP nezostal)
                if (!$totpOk && !empty($user['totp_backup_codes'])) {
                    $backupCodes = json_decode((string) $user['totp_backup_codes'], true);
                    if (is_array($backupCodes)) {
                        $usedIdx = verifyAndConsumeBackupCode($inputCode, $backupCodes);
                        if ($usedIdx >= 0) {
                            $backupOk = true;
                            // Odstráň použitý záložný kód z DB
                            array_splice($backupCodes, $usedIdx, 1);
                            try {
                                $pdo->prepare("UPDATE users SET totp_backup_codes = :codes WHERE id = :id")
                                    ->execute([
                                        'codes' => json_encode(array_values($backupCodes), JSON_UNESCAPED_UNICODE),
                                        'id'    => $pendingUserId,
                                    ]);
                            } catch (\PDOException $e) {
                                error_log("2fa_verify: chyba pri aktualizácii záložných kódov: " . $e->getMessage());
                            }
                        }
                    }
                }

                if ($totpOk || $backupOk) {
                    // Úspech — vyčisti rate limiter a dokončí login
                    try {
                        $pdo->prepare("DELETE FROM totp_attempts WHERE ip = :ip")->execute(['ip' => $clientIp]);
                    } catch (\PDOException) { /* ignoruj */ }

                    completeTwoFactorLogin($user);

                    if ($backupOk && empty($backupCodes)) {
                        setFlashMessage('warning', 'Použili ste posledný záložný kód. Odporúčame vygenerovať nové záložné kódy v nastaveniach 2FA.');
                    } elseif ($backupOk) {
                        $remaining = count($backupCodes);
                        setFlashMessage('info', "Použili ste záložný kód. Zostáva vám {$remaining} záložn" . ($remaining === 1 ? 'ý kód' : ($remaining < 5 ? 'é kódy' : 'ých kódov')) . ". Záložné kódy môžete obnoviť v nastaveniach 2FA.");
                    }

                    header("Location: index.php");
                    exit;
                } else {
                    // Nesprávny kód — zaznamenaj pokus
                    $_SESSION['2fa_pending']['attempts'] = $sessionAttempts + 1;
                    $errors[] = "Nesprávny overovací kód. Skontrolujte čas v autentifikátore a skúste znova.";

                    try {
                        $pdo->prepare(
                            "INSERT INTO totp_attempts (ip, attempt_count, first_attempt, last_attempt)
                             VALUES (:ip, 1, NOW(), NOW())
                             ON DUPLICATE KEY UPDATE attempt_count = attempt_count + 1, last_attempt = NOW()"
                        )->execute(['ip' => $clientIp]);

                        $cntStmt = $pdo->prepare("SELECT attempt_count FROM totp_attempts WHERE ip = :ip");
                        $cntStmt->execute(['ip' => $clientIp]);
                        $currentCount = (int) ($cntStmt->fetchColumn() ?? 0);
                        if ($currentCount >= $maxAttempts) {
                            $pdo->prepare("UPDATE totp_attempts SET blocked_until = DATE_ADD(NOW(), INTERVAL :secs SECOND) WHERE ip = :ip")
                                ->execute(['secs' => $blockSecs, 'ip' => $clientIp]);
                        }
                    } catch (\PDOException $e) {
                        error_log("2fa_verify: rate limit update: " . $e->getMessage());
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle      = 'Dvojfaktorové overenie | Nefro-projekt Slovensko';
  $seoDescription = 'Zadajte kód z autentifikátora pre dokončenie prihlásenia.';
  $robotsMeta     = 'noindex, nofollow';
  $canonicalUrl   = 'https://nefro.polascin.net/2fa_verify.php';
  include 'head_meta.php';
  ?>
</head>
<body>
  <?php
  $headerTitle = 'Nefro-projekt Slovensko';
  $showLogo    = false;
  include 'header.php';
  ?>

  <main class="container">
    <div class="auth-container">
      <h2>Dvojfaktorové overenie</h2>
      <p class="auth-subtitle">Zadajte 6-ciferný kód z vašej autentifikačnej aplikácie, alebo jeden zo záložných kódov.</p>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
          <ul>
            <?php foreach ($errors as $e): ?>
              <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="POST" action="2fa_verify.php" autocomplete="off">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">

        <div class="form-group">
          <label for="totp_code">Overovací kód</label>
          <input
            type="text"
            id="totp_code"
            name="totp_code"
            class="form-control"
            inputmode="numeric"
            autocomplete="one-time-code"
            maxlength="14"
            placeholder="123456"
            autofocus
            required
          >
          <small class="avatar-upload-hint">Zadajte 6-ciferný TOTP kód alebo záložný kód vo formáte XXXXX-XXXXX.</small>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-primary btn-block">Overiť</button>
        </div>
      </form>

      <div class="auth-links">
        <p><a href="login.php">Späť na prihlásenie</a></p>
      </div>

      <?php
      $remaining = (int) (($_SESSION['2fa_pending']['expires'] ?? time()) - time());
      if ($remaining > 0):
      ?>
        <p class="avatar-upload-hint" style="text-align:center; margin-top:1rem;">
          Platnosť prihlásenia vyprší o <strong><?= $remaining ?> sekúnd</strong>.
        </p>
      <?php endif; ?>
    </div>
  </main>
  <?php include 'footer.php'; ?>
</body>
</html>
