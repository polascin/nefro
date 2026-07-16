<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/totp.php';

requireLogin();

$requestMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if (!in_array($requestMethod, ['GET', 'POST'], true)) {
    http_response_code(405);
    header('Allow: GET, POST');
    exit;
}

$userId     = $_SESSION['user_id'];
$isLocalDev = isAppLocalDev();
$errors     = [];
$successes  = [];

// Načítanie aktuálnych 2FA údajov používateľa
$user = null;
try {
    $stmt = $pdo->prepare(
        "SELECT id, email, username, password_hash, totp_secret, totp_enabled, totp_backup_codes
         FROM users WHERE id = :id"
    );
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch();
} catch (\PDOException $e) {
    error_log("2fa_setup: DB chyba: " . $e->getMessage());
}

if (!$user) {
    clearUserSession();
    header("Location: login.php");
    exit;
}

$totpEnabled    = (int) ($user['totp_enabled'] ?? 0) === 1;
$backupCodes    = [];
if ($totpEnabled && !empty($user['totp_secret'])) {
    try {
        $totpStorage = decodeTotpStorage(
            (string) $user['totp_secret'],
            isset($user['totp_backup_codes']) ? (string) $user['totp_backup_codes'] : null
        );
        $backupCodes = $totpStorage['codes'];
    } catch (\RuntimeException $e) {
        error_log('2fa_setup: poškodené 2FA úložisko pre user_id=' . $userId . ': ' . $e->getMessage());
        $errors[] = 'Údaje dvojfaktorového overenia sa nepodarilo bezpečne načítať. Kontaktujte administrátora.';
    }
}

// Nový tajný kľúč pre aktiváciu — uložený v session počas nastavenia
$pendingSecret = $_SESSION['2fa_setup_secret'] ?? null;

// ── Spracovanie POST akcií ────────────────────────────────────────────────────
// CSRF kontrola ide ako prvá — pred načítaním záložných kódov zo session.
// Ak CSRF zlyhá, presmerujeme cez PRG; záložné kódy ostanú v session a zobrazia
// sa používateľovi správne po presmerovaní na GET, nie zmätene vedľa chybovej hlášky.
if ($requestMethod === 'POST') {
    $postedCsrfToken = $_POST['csrf_token'] ?? '';
    $action          = $_POST['action'] ?? '';

    if (!validateCsrfToken($postedCsrfToken)) {
        setFlashMessage('error', 'Neplatný CSRF token. Skúste stránku obnoviť a akciu zopakovať.');
        header("Location: 2fa_setup.php");
        exit;
    } else {

        // ── Krok 1: Začať aktiváciu — vygeneruj tajný kľúč ─────────────────
        if ($action === 'enable_start') {
            if ($totpEnabled) {
                $errors[] = "2FA je už aktivované.";
            } else {
                $secret = generateTotpSecret();
                $_SESSION['2fa_setup_secret'] = $secret;
                header("Location: 2fa_setup.php");
                exit;
            }
        }

        // ── Krok 2: Potvrdiť aktiváciu — overenie prvého TOTP kódu ────────
        elseif ($action === 'enable_confirm') {
            if ($totpEnabled) {
                $errors[] = "2FA je už aktivované.";
            } elseif (empty($_SESSION['2fa_setup_secret'])) {
                $errors[] = "Relačné údaje nastavenia vypršali. Začnite aktiváciu znova.";
            } else {
                $confirmCode    = trim($_POST['totp_confirm_code'] ?? '');
                $matchedCounter = verifyTotpCodeGetCounter($_SESSION['2fa_setup_secret'], $confirmCode, 2);
                if ($matchedCounter === false) {
                    $errors[] = "Nesprávny overovací kód. Skontrolujte čas v aplikácii a skúste znova.";
                    // Admin diagnostika — pomáha zistiť, či je problém v synchronizácii hodín
                    if (!empty($_SESSION['is_admin'])) {
                        $diagKey = totpBase32Decode($_SESSION['2fa_setup_secret']);
                        if ($diagKey !== false && $diagKey !== '') {
                            $diagCounter = (int) floor(time() / 30);
                            $diagCodes = [];
                            for ($diagW = -2; $diagW <= 2; $diagW++) {
                                $diagCode = totpComputeCode($diagKey, $diagCounter + $diagW);
                                $diagCodes[] = ($diagW === 0) ? "[{$diagCode}]" : $diagCode;
                            }
                            $errors[] = "[Diagnostika] Server: " . date('H:i:s T') . " | Akceptované kódy: " . implode('  ', $diagCodes) . " (stredný = aktuálny)";
                        }
                    }
                } else {
                    // Kód je správny — ulož tajný kľúč, záložné kódy a počiatočný counter
                    $backup       = generateBackupCodes();
                    $secretToSave = $_SESSION['2fa_setup_secret'];
                    try {
                        $storage = encodeTotpStorage($secretToSave, $backup['hashed']);
                        $pdo->prepare(
                            "UPDATE users SET totp_secret = :secret, totp_enabled = 1, totp_backup_codes = :codes, totp_last_counter = :counter WHERE id = :id"
                        )->execute([
                            'secret'  => $storage['secret_field'],
                            'codes'   => $storage['backup_json'],
                            'counter' => $matchedCounter,
                            'id'      => $userId,
                        ]);
                        unset($_SESSION['2fa_setup_secret']);
                        $pendingSecret = null;
                        $totpEnabled   = true;
                        // Záložné kódy zobrazíme jednoraz — uložíme do session, po načítaní stránky ich zobrazíme a vymažeme
                        $_SESSION['2fa_new_backup_codes'] = $backup['plain'];
                        $newPlainBackupCodes = $backup['plain'];
                        setFlashMessage('success', 'Dvojfaktorové overenie bolo úspešne aktivované!');
                        header("Location: 2fa_setup.php");
                        exit;
                    } catch (\PDOException|\RuntimeException $e) {
                        error_log("2fa_setup: enable_confirm DB chyba: " . $e->getMessage());
                        $errors[] = "Nastala chyba pri bezpečnom ukladaní 2FA. Skúste to znova neskôr.";
                    }
                }
            }
        }

        // ── Deaktivácia 2FA — vyžaduje aktuálne heslo ──────────────────────
        elseif ($action === 'disable') {
            if (!$totpEnabled) {
                $errors[] = "2FA nie je aktivované.";
            } else {
                $confirmPassword = $_POST['disable_password'] ?? '';
                if (empty($confirmPassword)) {
                    $errors[] = "Pre deaktiváciu zadajte svoje aktuálne heslo.";
                } elseif (!password_verify($confirmPassword, (string) $user['password_hash'])) {
                    $errors[] = "Zadané heslo nie je správne.";
                } else {
                    try {
                        $pdo->prepare(
                            "UPDATE users SET totp_secret = NULL, totp_enabled = 0, totp_backup_codes = NULL, totp_last_counter = NULL WHERE id = :id"
                        )->execute(['id' => $userId]);
                        unset($_SESSION['2fa_setup_secret']);
                        setFlashMessage('success', 'Dvojfaktorové overenie bolo deaktivované.');
                        header("Location: 2fa_setup.php");
                        exit;
                    } catch (\PDOException $e) {
                        error_log("2fa_setup: disable DB chyba: " . $e->getMessage());
                        $errors[] = "Nastala databázová chyba. Skúste to znova neskôr.";
                    }
                }
            }
        }

        // ── Regenerácia záložných kódov ─────────────────────────────────────
        elseif ($action === 'regenerate_backup') {
            if (!$totpEnabled) {
                $errors[] = "2FA nie je aktivované.";
            } else {
                $confirmPassword = $_POST['regen_password'] ?? '';
                if (empty($confirmPassword)) {
                    $errors[] = "Pre obnovu záložných kódov zadajte svoje aktuálne heslo.";
                } elseif (!password_verify($confirmPassword, (string) $user['password_hash'])) {
                    $errors[] = "Zadané heslo nie je správne.";
                } else {
                    $backup = generateBackupCodes();
                    try {
                        $storage = replaceTotpBackupCodes(
                            (string) ($user['totp_secret'] ?? ''),
                            isset($user['totp_backup_codes']) ? (string) $user['totp_backup_codes'] : null,
                            $backup['hashed']
                        );
                        $pdo->prepare(
                            "UPDATE users SET totp_secret = :secret, totp_backup_codes = :codes WHERE id = :id"
                        )->execute([
                            'secret' => $storage['secret_field'],
                            'codes'  => $storage['backup_json'],
                            'id'     => $userId,
                        ]);
                        $_SESSION['2fa_new_backup_codes'] = $backup['plain'];
                        setFlashMessage('success', 'Záložné kódy boli úspešne obnovené.');
                        header("Location: 2fa_setup.php");
                        exit;
                    } catch (\PDOException|\RuntimeException $e) {
                        error_log("2fa_setup: regenerate_backup DB chyba: " . $e->getMessage());
                        $errors[] = "Nastala chyba pri bezpečnom ukladaní záložných kódov. Skúste to znova neskôr.";
                    }
                }
            }
        }
    }
}

// Novo vygenerované záložné kódy na zobrazenie (len raz po aktivácii).
// Načítavame až tu — po POST bloku — aby ich CSRF redirect nevymazal skôr, než sa zobrazia.
$newPlainBackupCodes = $_SESSION['2fa_new_backup_codes'] ?? null;
if ($newPlainBackupCodes !== null) {
    unset($_SESSION['2fa_new_backup_codes']);
}

// Otpauth URI pre manuálne pridanie do autentifikátora
$issuer  = 'Nefro-projekt SK';
$totpUri = $pendingSecret ? getTotpUri($pendingSecret, (string) ($user['email'] ?? ''), $issuer) : '';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle      = 'Dvojfaktorové overenie (2FA) | Nefro-projekt Slovensko';
  $seoDescription = 'Správa dvojfaktorového overenia (2FA) — aktivácia, deaktivácia a obnova záložných kódov.';
  $robotsMeta     = 'noindex, nofollow';
  $canonicalUrl   = 'https://nefro.polascin.net/2fa_setup.php';
  include 'head_meta.php';
  ?>
</head>
<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
  <?php
  $headerTitle = 'Nastavenia 2FA';
  $headerIntro = 'Správa dvojfaktorového overenia';
  $showLogo    = false;
  include 'header.php';
  ?>

  <main id="main-content" class="container" role="main">
    <div class="auth-container auth-container--wide">
      <h2>Dvojfaktorové overenie (2FA)</h2>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
          <ul>
            <?php foreach ($errors as $err): ?>
              <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <!-- ── Stav 2FA ─────────────────────────────────────────────────────── -->
      <div class="form-section">
        <h3>Aktuálny stav</h3>
        <?php if ($totpEnabled): ?>
          <p>
            <span class="badge-2fa-on">2FA je ZAPNUTÉ</span>
            — váš účet je chránený TOTP autentifikátorom.
          </p>
          <p class="avatar-upload-hint">
            Záložných kódov zostáva: <strong><?= count($backupCodes) ?></strong>
            <?php if (count($backupCodes) <= 2): ?>
              <span class="badge-draft">Málo záložných kódov — odporúčame obnoviť</span>
            <?php endif; ?>
          </p>
        <?php else: ?>
          <p>
            <span class="badge-draft">2FA je VYPNUTÉ</span>
            — odporúčame aktivovať pre vyššiu bezpečnosť účtu.
          </p>
        <?php endif; ?>
      </div>

      <?php if (!$totpEnabled): ?>
      <!-- ══ AKTIVÁCIA 2FA ════════════════════════════════════════════════════ -->
      <div class="form-section">
        <h3>Aktivovať 2FA</h3>

        <?php if ($pendingSecret): ?>
          <!-- Krok 2: Zobraziť tajný kľúč a formulár na potvrdenie -->
          <p>Pridajte tento kľúč do vašej autentifikačnej aplikácie (Google Authenticator, Authy, Bitwarden, Microsoft Authenticator a pod.), potom zadajte prvý vygenerovaný kód.</p>

          <div class="form-section totp-panel">
            <div class="totp-row">
              <div>
                <p class="avatar-upload-hint mb-05rem">Naskenujte QR kód aplikáciou:</p>
                <div id="totp-qr" class="totp-qr-box"></div>
                <p class="avatar-upload-hint">
                  Na mobile môžete tiež <a href="<?= htmlspecialchars($totpUri) ?>">otvoriť priamo v aplikácii</a>.
                </p>
              </div>
              <div class="totp-manual-col">
                <p class="avatar-upload-hint mb-05rem">Alebo zadajte kľúč ručne:</p>
                <code id="totp-secret-display" class="totp-secret"><?= htmlspecialchars(formatTotpSecret($pendingSecret)) ?></code>
                <button type="button" id="copy-secret-btn" class="btn-secondary totp-copy-btn">Kopírovať kľúč</button>
                <p class="avatar-upload-hint">
                  V aplikácii zvoľte <em>„Pridať účet → Zadať kód ručne“</em> a vložte kľúč bez medzier.
                </p>
              </div>
            </div>
          </div>
          <script src="/assets/qrcode.min.js?v=<?= filemtime(__DIR__ . '/assets/qrcode.min.js') ?>"></script>
          <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
            (function() {
              var el = document.getElementById('totp-qr');
              if (el && typeof QRCode !== 'undefined') {
                new QRCode(el, {
                  text: <?= json_encode($totpUri) ?>,
                  width: 180, height: 180,
                  colorDark: '#000000', colorLight: '#ffffff',
                  correctLevel: QRCode.CorrectLevel.M
                });
              }
            })();
          </script>

          <form method="POST" action="2fa_setup.php">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
            <input type="hidden" name="action" value="enable_confirm">
            <div class="form-group">
              <label for="totp_confirm_code">Potvrďte aktiváciu — zadajte prvý kód z aplikácie</label>
              <input
                type="text"
                id="totp_confirm_code"
                name="totp_confirm_code"
                class="form-control"
                inputmode="numeric"
                autocomplete="one-time-code"
                maxlength="6"
                placeholder="123456"
                autofocus
                required
              >
            </div>
            <div class="form-actions">
              <button type="submit" class="btn-primary">Aktivovať 2FA</button>
            </div>
          </form>

          <form method="POST" action="2fa_setup.php" class="mt-075rem">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
            <input type="hidden" name="action" value="enable_start">
            <button type="submit" class="btn-secondary">Vygenerovať nový kľúč</button>
          </form>

        <?php else: ?>
          <!-- Krok 1: Tlačidlo na spustenie aktivácie -->
          <p class="avatar-upload-hint">
            Po kliknutí vám zobrazíme tajný kľúč, ktorý pridáte do autentifikačnej aplikácie.
            Potom zadáte prvý 6-ciferný kód pre potvrdenie.
          </p>
          <form method="POST" action="2fa_setup.php">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
            <input type="hidden" name="action" value="enable_start">
            <div class="form-actions">
              <button type="submit" class="btn-primary">Aktivovať 2FA</button>
            </div>
          </form>
        <?php endif; ?>
      </div>

      <?php else: ?>
      <!-- ══ ZÁLOŽNÉ KÓDY ═════════════════════════════════════════════════════ -->
      <?php if ($newPlainBackupCodes !== null): ?>
      <div class="form-section">
        <h3>Záložné kódy</h3>
        <div class="alert alert-error alert-2fa-backup">
          <p><strong>Uložte si tieto záložné kódy na bezpečné miesto!</strong></p>
          <p class="avatar-upload-hint">Každý kód môžete použiť raz namiesto TOTP kódu. Po tomto zobrazení ich nebude možné znova zobraziť.</p>
        </div>
        <div id="backup-codes-list" class="backup-codes-grid">
          <?php foreach ($newPlainBackupCodes as $bc): ?>
            <code class="backup-code"><?= htmlspecialchars($bc) ?></code>
          <?php endforeach; ?>
        </div>
        <button type="button" id="copy-backup-btn" class="btn-secondary">Kopírovať všetky záložné kódy</button>
      </div>
      <?php endif; ?>

      <!-- ══ OBNOVA ZÁLOŽNÝCH KÓDOV ═══════════════════════════════════════════ -->
      <div class="form-section">
        <h3>Obnoviť záložné kódy</h3>
        <p class="avatar-upload-hint">Vygeneruje nových 8 záložných kódov. Staré kódy budú zneplatnené.</p>
        <form method="POST" action="2fa_setup.php">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
          <input type="hidden" name="action" value="regenerate_backup">
          <div class="form-group">
            <label for="regen_password">Potvrdenie heslom</label>
            <input type="password" id="regen_password" name="regen_password" class="form-control" required autocomplete="current-password" placeholder="Zadajte aktuálne heslo">
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-secondary">Obnoviť záložné kódy</button>
          </div>
        </form>
      </div>

      <!-- ══ NEBEZPEČNÁ ZÓNA — DEAKTIVÁCIA ════════════════════════════════════ -->
      <div class="danger-zone" id="disable-2fa-zone">
        <h3 class="danger-zone__title">Deaktivovať 2FA</h3>
        <p class="danger-zone__desc">Deaktivácia zníži bezpečnosť vášho účtu. Potvrďte aktuálne heslo.</p>
        <button type="button" class="btn-danger-outline" data-toggle-btn="disable-2fa-confirm">
          Deaktivovať 2FA
        </button>
        <div id="disable-2fa-confirm" class="delete-confirm-panel d-none">
          <form method="POST" action="2fa_setup.php" class="delete-confirm-panel__form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
            <input type="hidden" name="action" value="disable">
            <div class="form-group">
              <label for="disable_password">Aktuálne heslo</label>
              <input type="password" id="disable_password" name="disable_password" class="form-control" required autocomplete="current-password" placeholder="Zadajte heslo pre potvrdenie">
            </div>
            <div class="form-actions">
              <button type="button" class="btn-secondary" data-toggle-btn="disable-2fa-confirm">Zrušiť</button>
              <button type="submit" class="btn-danger">Deaktivovať 2FA</button>
            </div>
          </form>
        </div>
      </div>
      <?php endif; ?>

      <div class="auth-links mt-1-5rem">
        <p><a href="profile.php">&larr; Späť na profil</a></p>
      </div>
    </div>
  </main>

  <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
  (function () {
    // Kopírovanie tajného kľúča
    var copySecretBtn = document.getElementById('copy-secret-btn');
    var secretDisplay = document.getElementById('totp-secret-display');
    if (copySecretBtn && secretDisplay) {
      copySecretBtn.addEventListener('click', function () {
        var text = secretDisplay.textContent.replace(/\s+/g, '');
        navigator.clipboard.writeText(text).then(function () {
          copySecretBtn.textContent = 'Skopírované!';
          setTimeout(function () { copySecretBtn.textContent = 'Kopírovať kľúč'; }, 2000);
        }).catch(function () {
          copySecretBtn.textContent = 'Kopírovanie zlyhalo';
        });
      });
    }

    // Kopírovanie záložných kódov
    var copyBackupBtn  = document.getElementById('copy-backup-btn');
    var backupCodeList = document.getElementById('backup-codes-list');
    if (copyBackupBtn && backupCodeList) {
      copyBackupBtn.addEventListener('click', function () {
        var codes = Array.from(backupCodeList.querySelectorAll('code')).map(function (el) {
          return el.textContent.trim();
        }).join('\n');
        navigator.clipboard.writeText(codes).then(function () {
          copyBackupBtn.textContent = 'Skopírované!';
          setTimeout(function () { copyBackupBtn.textContent = 'Kopírovať všetky záložné kódy'; }, 2000);
        }).catch(function () {
          copyBackupBtn.textContent = 'Kopírovanie zlyhalo';
        });
      });
    }

    // Toggle pre disable panel (rovnaký vzor ako v profile.php)
    document.querySelectorAll('[data-toggle-btn]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var targetId = btn.getAttribute('data-toggle-btn');
        var target   = document.getElementById(targetId);
        if (target) {
          target.classList.toggle('d-none');
        }
      });
    });
  })();
  </script>

  <?php include 'footer.php'; ?>
</body>
</html>
