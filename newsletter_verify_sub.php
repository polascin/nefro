<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
if (!isset($pdo) || !$pdo instanceof \PDO) {
    throw new \RuntimeException('Databázové pripojenie nie je dostupné.');
}

const NEWSLETTER_VERIFY_MAX_ATTEMPTS = 5;
const NEWSLETTER_VERIFY_WINDOW_SECS = 3600;

$requestMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if (!in_array($requestMethod, ['GET', 'POST'], true)) {
    http_response_code(405);
    header('Allow: GET, POST');
    exit;
}

$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
$tokenFormatValid = preg_match('/^[a-f0-9]{64}$/Di', $token) === 1;

$status = 'error';
$message = 'Neplatný alebo expirovaný overovací odkaz.';
$showConfirmation = false;

$verificationFlash = $requestMethod === 'GET'
    ? (string) ($_SESSION['newsletter_verify_flash'] ?? '')
    : '';
if ($verificationFlash !== '') {
    unset($_SESSION['newsletter_verify_flash']);
    $status = 'success';
    $message = $verificationFlash === 'already'
        ? 'Váš e-mail je už overený. Odber noviniek je aktívny.'
        : 'E-mail bol úspešne overený. Vitajte medzi odberateľmi!';
}

if ($requestMethod === 'GET' && $verificationFlash === '' && $tokenFormatValid) {
    // GET nesmie aktivovať odber: e-mailové skenery často otvárajú odkazy
    // automaticky ešte pred používateľom.
    $status = 'pending';
    $message = 'Kliknutím na tlačidlo potvrďte odber noviniek.';
    $showConfirmation = true;
}

if ($requestMethod === 'POST') {
    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $message = 'Neplatný CSRF token. Skúste to znova.';
        $showConfirmation = $tokenFormatValid;
    } elseif (!$tokenFormatValid) {
        $message = 'Overovací odkaz nie je platný.';
    } else {
        $clientIp = getClientIpAddress();
        $rateLimitBlocked = !checkFormRateLimit(
            $pdo,
            'newsletter_verify',
            $clientIp,
            NEWSLETTER_VERIFY_MAX_ATTEMPTS,
            NEWSLETTER_VERIFY_WINDOW_SECS
        );

        if ($rateLimitBlocked) {
            $message = 'Príliš veľa pokusov. Skúste to znova neskôr.';
        } else {
            try {
                $pdo->beginTransaction();

                $stmt = $pdo->prepare(
                    "SELECT id, verified_at
                     FROM newsletter_subscribers
                     WHERE verify_token = :token_hash
                       AND updated_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                     LIMIT 1
                     FOR UPDATE"
                );
                $stmt->execute(['token_hash' => hash('sha256', $token)]);
                $subscriber = $stmt->fetch();

                if (!$subscriber) {
                    $pdo->rollBack();
                    $message = 'Overovací odkaz nie je platný alebo už bol použitý.';
                } else {
                    $wasVerified = $subscriber['verified_at'] !== null;
                    $pdo->prepare(
                        "UPDATE newsletter_subscribers
                         SET verified_at = COALESCE(verified_at, NOW()),
                             verify_token = NULL
                         WHERE id = :id"
                    )->execute(['id' => (int) $subscriber['id']]);
                    $pdo->commit();

                    try {
                        $pdo->prepare(
                            "DELETE FROM form_rate_limit
                             WHERE ip = :ip AND action = 'newsletter_verify'"
                        )->execute(['ip' => $clientIp]);
                    } catch (\PDOException) {
                        // Vyčistenie počítadla je best-effort.
                    }

                    $_SESSION['newsletter_verify_flash'] = $wasVerified ? 'already' : 'verified';
                    header('Location: newsletter_verify_sub.php?confirmed=1', true, 303);
                    exit;
                }
            } catch (\PDOException $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                error_log('Newsletter verification error: ' . $e->getMessage());
                $message = 'Pri overovaní nastala chyba. Skúste to neskôr.';
                $showConfirmation = true;
            }
        }
    }
}

$pageClass = match ($status) {
    'success' => 'alert-success',
    'pending' => 'alert-info',
    default => 'alert-error',
};
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'Potvrdenie odberu noviniek | Nefro-projekt Slovensko';
  $seoDescription = 'Súkromné potvrdenie e-mailovej adresy pre odber noviniek Nefro-projekt Slovensko.';
  $robotsMeta = 'noindex, nofollow';
  $canonicalUrl = getAppBaseUrl() . '/newsletter_verify_sub.php';
  include 'head_meta.php';
  ?>
</head>
<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
  <?php
  $headerTitle = 'Potvrdenie odberu';
  $showLogo    = false;
  include 'header.php';
  ?>
  <main id="main-content" class="container" role="main">
    <div class="auth-container">
      <h2>Odber noviniek</h2>
      <div class="alert <?= htmlspecialchars($pageClass, ENT_QUOTES) ?>">
        <p><?= htmlspecialchars($message) ?></p>
      </div>

      <?php if ($showConfirmation): ?>
        <form method="POST" action="newsletter_verify_sub.php">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
          <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
          <div class="form-actions">
            <button type="submit" class="btn-primary btn-block">Potvrdiť odber noviniek</button>
          </div>
        </form>
      <?php endif; ?>

      <div class="auth-links auth-links--spaced">
        <p>
          <a href="index.php">Prejsť na domovskú stránku</a>
          <?php if ($status === 'success'): ?>
          | <a href="register.php">Zaregistrovať sa pre plný prístup</a>
          <?php endif; ?>
        </p>
      </div>
    </div>
  </main>
  <?php include 'footer.php'; ?>
</body>
</html>
