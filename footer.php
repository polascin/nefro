<?php
// Získanie času poslednej modifikácie aktuálneho súboru, ak nebol definovaný
if (!isset($pageLastUpdated) || !isset($pageTimeZone)) {
    $currentFile = $_SERVER['SCRIPT_FILENAME'];
    if (file_exists($currentFile)) {
        $pageLastUpdated = date('d.m.Y H:i', filemtime($currentFile));
    } else {
        $pageLastUpdated = date('d.m.Y H:i');
    }
    $pageTimeZone = date('T') . ' (' . date_default_timezone_get() . ')';
}

$isHomePage = basename($_SERVER['PHP_SELF']) === 'index.php';
?>
  <!-- <footer>: Pätička stránky alebo sekcie, obsahuje autorské práva, dôležité odkazy atď. -->
  <footer class="site-footer" role="contentinfo">
    <div class="container site-footer__container">
      <p>
        &copy; 2026 Ľubomír Polaščín. Vytvorené s využitím moderných štandardov a s dôrazom na prístupnosť.
      </p>
      <p class="site-footer__updated">
        Posledná aktualizácia stránky: <?= htmlspecialchars($pageLastUpdated, ENT_QUOTES, 'UTF-8') ?> (časové pásmo: <?= htmlspecialchars($pageTimeZone, ENT_QUOTES, 'UTF-8') ?>)
      </p>
      <p class="site-footer__links site-footer__links--margined">
        <?php if (!$isHomePage): ?>
            <a href="index.php" class="site-footer__link site-footer__link--home">Návrat na Domov</a> <span class="site-footer__separator">|</span> 
        <?php endif; ?>
        <a href="privacy.php" class="site-footer__link">Ochrana osobných údajov (Privacy Policy)</a> <span class="site-footer__separator">|</span> 
        <a href="#cookie-settings" role="button" class="cookie-settings-trigger site-footer__link" aria-haspopup="dialog" aria-controls="cookieConsentModal">Nastavenia Cookies</a>
        <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
          <span class="site-footer__separator">|</span>
          <a href="logout.php" class="site-footer__link">Odhlásiť sa</a>
        <?php endif; ?>
      </p>
    </div>
  </footer>
</body>
</html>
