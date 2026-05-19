<?php
// Načítaj deploy timestamp ak existuje (generuje deploy.sh)
$deployInfoFile = __DIR__ . '/deploy_info.php';
if (file_exists($deployInfoFile)) {
    require_once $deployInfoFile;
}

if (!isset($pageLastUpdated) || !isset($pageTimeZone)) {
    if (defined('DEPLOY_TIME')) {
        $pageLastUpdated = DEPLOY_TIME;
    } else {
        $currentFile = $_SERVER['SCRIPT_FILENAME'];
        $pageLastUpdated = file_exists($currentFile)
            ? date('d.m.Y H:i', filemtime($currentFile))
            : date('d.m.Y H:i');
    }
    $pageTimeZone = date('T') . ' (' . date_default_timezone_get() . ')';
}

$isHomePage = basename($_SERVER['PHP_SELF']) === 'index.php';

// @beat — Swiss Internet Time (BMT = UTC+1, 1 deň = 1000 beatov)
$utcNow     = new DateTime('now', new DateTimeZone('UTC'));
$utcSecs    = (int)$utcNow->format('H') * 3600
            + (int)$utcNow->format('i') * 60
            + (int)$utcNow->format('s');
$bmtSecs    = ($utcSecs + 3600) % 86400;
$swatchBeat = '@' . str_pad((string)(int)floor($bmtSecs / 86.4), 3, '0', STR_PAD_LEFT);
?>
  <footer class="site-footer" role="contentinfo">
    <div class="container site-footer__body">

      <div class="site-footer__col site-footer__col--brand">
        <img src="./img/nps.gif" alt="Nefro-projekt Slovensko" class="site-footer__logo" loading="lazy" width="48" height="48">
        <p class="site-footer__brand-name">Nefro-projekt Slovensko</p>
        <p class="site-footer__brand-desc">Odborný portál o nefrológii, dialýze a internej medicíne pre zdravotníkov aj informovaných pacientov.</p>
      </div>

      <nav class="site-footer__col site-footer__col--nav" aria-label="Rýchla navigácia v pätičke">
        <p class="site-footer__col-heading">Navigácia</p>
        <ul class="site-footer__nav-list">
          <li><a href="index.php" class="site-footer__link">Domov</a></li>
          <li><a href="index.php#sluzby" class="site-footer__link">Služby</a></li>
          <li><a href="index.php#o-mne" class="site-footer__link">O mne</a></li>
          <li><a href="index.php#kontakt" class="site-footer__link">Kontakt</a></li>
          <li><a href="calculators.php" class="site-footer__link">Kalkulačky</a></li>
        </ul>
      </nav>

      <div class="site-footer__col site-footer__col--contact">
        <p class="site-footer__col-heading">Kontakt</p>
        <ul class="site-footer__nav-list">
          <li><a href="mailto:nefro@polascin.net" class="site-footer__link">nefro@polascin.net</a></li>
          <?php if (function_exists('isLoggedIn') && !isLoggedIn()): ?>
            <li><a href="register.php" class="site-footer__link">Registrácia</a></li>
            <li><a href="login.php" class="site-footer__link">Prihlásenie</a></li>
          <?php else: ?>
            <li><a href="profile.php" class="site-footer__link">Môj profil</a></li>
            <li><a href="logout.php" class="site-footer__link">Odhlásiť sa</a></li>
          <?php endif; ?>
          <li><a href="privacy.php" class="site-footer__link">Ochrana osobných údajov</a></li>
        </ul>
      </div>

    </div>

    <div class="site-footer__bottom">
      <div class="container site-footer__bottom-inner">
        <span>&copy; <?= date('Y') ?> Ľubomír Polaščín</span>
        <span class="site-footer__bottom-sep" aria-hidden="true">·</span>
        <a href="#cookie-settings" role="button" class="cookie-settings-trigger site-footer__link" aria-haspopup="dialog" aria-controls="cookieConsentModal">Nastavenia Cookies</a>
        <span class="site-footer__bottom-sep" aria-hidden="true">·</span>
        <span class="site-footer__updated">Aktualizované: <?= htmlspecialchars($pageLastUpdated, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($pageTimeZone, ENT_QUOTES, 'UTF-8') ?>)</span>
        <span class="site-footer__bottom-sep" aria-hidden="true">·</span>
        <a href="https://www.swatch.com/en-us/internet-time.html" target="_blank" rel="noopener noreferrer" class="site-footer__link site-footer__beat" title="Swiss Internet Time — 1 deň = 1000 beatov"><?= htmlspecialchars($swatchBeat, ENT_QUOTES, 'UTF-8') ?> .beat</a>
        <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
          <span class="site-footer__bottom-sep" aria-hidden="true">·</span>
          <form action="logout.php" method="post" class="footer-logout-form">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(function_exists('generateCsrfToken') ? generateCsrfToken() : '') ?>">
              <button type="submit" class="site-footer__link footer-logout-btn">Odhlásiť sa</button>
          </form>
        <?php endif; ?>
      </div>
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
