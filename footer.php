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
          <form action="logout.php" method="post" class="footer-logout-form">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(function_exists('generateCsrfToken') ? generateCsrfToken() : '') ?>">
              <button type="submit" class="site-footer__link footer-logout-btn">Odhlásiť sa</button>
          </form>
        <?php endif; ?>
      </p>
    </div>
  </footer>

  <!-- Tlačidlo Späť nahor -->
  <button id="backToTop" class="back-to-top no-print" aria-label="Späť nahor" title="Späť nahor">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
  </button>

  <!-- Tlačová pätička -->
  <?php
  $printDateTime = date('d.m.Y H:i:s');
  $isCalculatorPageFooter = str_starts_with(basename($_SERVER['PHP_SELF']), 'calculator');
  ?>
  <?php if ($isCalculatorPageFooter && !empty($currentUser)): ?>
        </div> <!-- end .print-layout-tbody -->
        <div class="print-layout-tfoot">
  <?php endif; ?>

  <div class="global-print-footer print-only" aria-hidden="true">
    <div>Vytlačené z webovej lokality Nefro-projekt Slovensko - https://nefro.polascin.net/ &copy; <?= date('Y') ?> Ľubomír Polaščín</div>
    <div class="mt-2">Dátum a čas tlače: <?= $printDateTime ?> (<?= htmlspecialchars($pageTimeZone, ENT_QUOTES, 'UTF-8') ?>)</div>
  </div>

  <?php if ($isCalculatorPageFooter && !empty($currentUser)): ?>
        </div> <!-- end .print-layout-tfoot -->
    </div> <!-- end .print-layout-table -->
  <?php endif; ?>

  <script src="form-submit-enter.js?v=20260512-1&cb=<?= filemtime('form-submit-enter.js') ?>" defer></script>
</body>
</html>
