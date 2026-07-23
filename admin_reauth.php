<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

requireAdmin();

$requestMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
$errors = [];

if ($requestMethod === 'POST') {
    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Neplatný CSRF token. Skúste to znova.';
    } else {
        $password = (string) ($_POST['password'] ?? '');
        $userId = (int) ($_SESSION['user_id'] ?? 0);

        try {
            $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = :id LIMIT 1');
            $stmt->execute(['id' => $userId]);
            $user = $stmt->fetch();
            $passwordHash = is_array($user) ? (string) ($user['password_hash'] ?? '') : '';

            if ($passwordHash === '') {
                $errors[] = 'Nepodarilo sa načítať údaje účtu.';
            } else {
                $reauth = verifySensitiveActionPassword($pdo, $userId, $password, $passwordHash);
                if ($reauth['ok']) {
                    $returnUrl = (string) ($_SESSION['reauth_return_url'] ?? 'admin.php');
                    unset($_SESSION['reauth_return_url']);
                    setFlashMessage('success', 'Opätovné overenie prebehlo úspešne.');
                    header('Location: ' . $returnUrl, true, 303);
                    exit;
                }
                if ($reauth['blocked']) {
                    $errors[] = 'Príliš veľa nesprávnych pokusov. Skúste to znova o 15 minút.';
                } else {
                    $errors[] = 'Zadané heslo nie je správne.';
                }
            }
        } catch (\PDOException $e) {
            error_log('admin_reauth: DB chyba: ' . $e->getMessage());
            $errors[] = 'Pri overovaní došlo k chybe. Skúste to neskôr.';
        }
    }
} elseif ($requestMethod !== 'GET') {
    http_response_code(405);
    header('Allow: GET, POST');
    exit;
}

$pageTitle = 'Overenie identity | Nefro-projekt Slovensko';
$seoDescription = 'Bezpečnostné opätovné overenie heslom pre citlivé admin operácie.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = 'https://nefro.polascin.net/admin_reauth.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php include 'head_meta.php'; ?>
</head>
<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
  <?php
  $headerTitle = 'Overenie identity';
  $headerIntro = 'Bezpečnostné opätovné overenie';
  $showLogo = false;
  include 'header.php';
  ?>

  <main id="main-content" class="container" role="main">
    <div class="auth-container">
      <h2>Overenie identity</h2>
      <p>Pre túto operáciu zadajte svoje aktuálne heslo.</p>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
          <ul>
            <?php foreach ($errors as $err): ?>
              <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="POST" action="admin_reauth.php" class="form-section">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
        <div class="form-group">
          <label for="password">Heslo</label>
          <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password" autofocus>
        </div>
        <button type="submit" class="btn btn-primary">Overiť</button>
        <a href="admin.php" class="btn btn-secondary">Zrušiť</a>
      </form>
    </div>
  </main>

  <?php include 'footer.php'; ?>
</body>
</html>
