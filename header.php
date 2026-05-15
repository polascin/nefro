<?php
$headerTitle = $headerTitle ?? 'Nefro-projekt Slovensko';
$headerIntro = $headerIntro ?? '';
$showLogo = $showLogo ?? false;
$flash = function_exists('popFlashMessage') ? popFlashMessage() : null;
$showUnverifiedNotice = function_exists('isLoggedIn')
    && function_exists('isEmailVerified')
    && isLoggedIn()
    && !isEmailVerified();
$resendLink = 'resend_verification.php';
if ($showUnverifiedNotice && !empty($_SESSION['email'])) {
    $resendLink .= '?login=' . urlencode((string) $_SESSION['email']);
}
?>
<header class="site-header" role="banner" id="domov">
  <div class="site-header__wrapper">
    
    <!-- Vľavo - Logo (1/3) -->
    <div class="site-header__col site-header__col--left">
        <a href="index.php" class="site-header__logo-link">
            <img src="./img/nps-logo.gif" alt="Nefro-projekt Slovensko Logo" class="site-header__logo-img">
        </a>
    </div>
    
    <!-- Stred - Nadpis a Podnadpis (1/3) -->
    <div class="site-header__col site-header__col--center">
        <a href="index.php" class="site-header__title-link">
            <h1 class="site-header__main-title">
                Nefro-projekt Slovensko
            </h1>
        </a>
        
        <?php if ($headerTitle !== 'Nefro-projekt Slovensko'): ?>
            <h2 class="site-header__subtitle">
                <?= htmlspecialchars($headerTitle) ?>
            </h2>
        <?php endif; ?>
        
        <?php if (!empty($headerIntro)): ?>
            <p class="site-header__intro">
                <?= htmlspecialchars($headerIntro) ?>
            </p>
        <?php endif; ?>
    </div>
    
    <!-- Vpravo - Profil (1/3) -->
    <div class="site-header__col site-header__col--right">
        <?php include 'header_profile.php'; ?>
    </div>
    
  </div>
</header>

<?php if (is_array($flash) && !empty($flash['message'])): ?>
    <div class="container">
        <div class="alert <?= (($flash['type'] ?? '') === 'warning') ? 'alert-error' : 'alert-success' ?>">
            <p><?= htmlspecialchars((string) $flash['message']) ?></p>
        </div>
    </div>
<?php endif; ?>

<?php if ($showUnverifiedNotice): ?>
    <div class="container">
        <div class="alert alert-error">
            <p>
                Váš účet má neoverenú e-mailovú adresu. Neoverení používatelia nemôžu využívať služby určené pre používateľov.
                <a href="<?= htmlspecialchars($resendLink) ?>">Poslať overenie znova</a>
            </p>
        </div>
    </div>
<?php endif; ?>
