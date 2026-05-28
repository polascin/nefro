<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

$token   = trim((string) ($_GET['token'] ?? ''));
$status  = 'error';
$message = 'Neplatný alebo expirovaný overovací odkaz.';

if ($token !== '') {
    try {
        $stmt = $pdo->prepare(
            "SELECT id, email, verified_at FROM newsletter_subscribers
             WHERE verify_token = :token
               AND updated_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
             LIMIT 1"
        );
        $stmt->execute(['token' => $token]);
        $sub = $stmt->fetch();

        if (!$sub) {
            $message = 'Overovací odkaz nie je platný.';
        } elseif ($sub['verified_at'] !== null) {
            $status  = 'success';
            $message = 'Váš e-mail je už overený. Odber noviniek je aktívny.';
        } else {
            $pdo->prepare(
                "UPDATE newsletter_subscribers SET verified_at = NOW() WHERE id = :id AND verified_at IS NULL"
            )->execute(['id' => (int) $sub['id']]);
            $status  = 'success';
            $message = 'E-mail bol úspešne overený. Vitajte medzi odberateľmi!';
        }
    } catch (\PDOException $e) {
        error_log('newsletter_verify_sub error: ' . $e->getMessage());
        $message = 'Pri overovaní nastala chyba. Skúste to neskôr.';
    }
}

$pageClass = $status === 'success' ? 'alert-success' : 'alert-error';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Potvrdenie odberu noviniek - Nefro-projekt Slovensko</title>
  <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
  <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
  <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
  <?php
  $headerTitle = 'Potvrdenie odberu';
  $showLogo    = false;
  include 'header.php';
  ?>
  <main class="container">
    <div class="auth-container">
      <h2>Odber noviniek</h2>
      <div class="alert <?= htmlspecialchars($pageClass, ENT_QUOTES) ?>">
        <p><?= htmlspecialchars($message) ?></p>
      </div>
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
