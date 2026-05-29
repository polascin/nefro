<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/totp.php';

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
                        totp_secret, totp_enabled, totp_backup_codes, totp_last_counter, password_hash
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

        // Overenie pwd_fingerprint — detekuje zmenu hesla počas čakania na 2FA
        if (empty($errors) && $user) {
            $expectedFingerprint = $_SESSION['2fa_pending']['pwd_fingerprint'] ?? null;
            if ($expectedFingerprint !== null) {
                $actualFingerprint = substr(hash('sha256', (string) $user['password_hash']), 0, 16);
                if (!hash_equals($expectedFingerprint, $actualFingerprint)) {
                    unset($_SESSION['2fa_pending']);
                    setFlashMessage('warning', 'Prihlásenie sa nepodarilo. Prihláste sa znova.');
                    header("Location: login.php");
                    exit;
                }
            }
        }

        if (empty($errors)) {
            // IP rate limiting
            $ipBlocked = false;
            try {
                $blockedUntilTs = ipRateLimitBlockedUntil($pdo, 'totp_attempts', $clientIp);
                if ($blockedUntilTs > 0) {
                    $ipBlocked = true;
                    $errors[]  = "Z bezpečnostných dôvodov bol prístup dočasne zablokovaný. Skúste to znova o 15 minút.";
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

                // Skús TOTP (window=2 = tolerancia ±60 s pre prípadnú odchýlku hodín)
                // Replay ochrana: akceptujeme len counter > naposledy použitého
                $matchedCounter = verifyTotpCodeGetCounter((string) $user['totp_secret'], $inputCode, 2);
                $lastCounter    = isset($user['totp_last_counter']) ? (int) $user['totp_last_counter'] : -1;
                if ($matchedCounter !== false && $matchedCounter > $lastCounter) {
                    $totpOk = true;
                    try {
                        $pdo->prepare("UPDATE users SET totp_last_counter = :c WHERE id = :id")
                            ->execute(['c' => $matchedCounter, 'id' => $pendingUserId]);
                    } catch (\PDOException $e) {
                        error_log("2fa_verify: chyba pri ukladaní totp_last_counter: " . $e->getMessage());
                    }
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
                        clearIpRateLimit($pdo, 'totp_attempts', $clientIp);
                    } catch (\PDOException $e) { error_log("2fa_verify: vyčistenie totp_attempts: " . $e->getMessage()); }

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
                        recordIpFailedAttempt($pdo, 'totp_attempts', $clientIp, $maxAttempts, $blockSecs);
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
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
  <?php
  $headerTitle = 'Nefro-projekt Slovensko';
  $showLogo    = false;
  include 'header.php';
  ?>

  <main id="main-content" class="container">
    <div class="auth-container">
      <h2>Dvojfaktorové overenie</h2>
      <p class="auth-subtitle">Zadajte 6-ciferný kód z vašej autentifikačnej aplikácie alebo jeden zo záložných kódov.</p>

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
