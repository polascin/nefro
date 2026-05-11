<?php
$headerTitle = $headerTitle ?? 'Nefro-projekt Slovensko';
$headerIntro = $headerIntro ?? '';
$showLogo = $showLogo ?? false;
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
                <?= $headerTitle ?>
            </h2>
        <?php endif; ?>
        
        <?php if (!empty($headerIntro)): ?>
            <p class="site-header__intro">
                <?= $headerIntro ?>
            </p>
        <?php endif; ?>
    </div>
    
    <!-- Vpravo - Profil (1/3) -->
    <div class="site-header__col site-header__col--right">
        <?php include 'header_profile.php'; ?>
    </div>
    
  </div>
</header>
