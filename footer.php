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
    <div style="margin-top: 2px;">Dátum a čas tlače: <?= $printDateTime ?> (<?= htmlspecialchars($pageTimeZone, ENT_QUOTES, 'UTF-8') ?>)</div>
  </div>

  <?php if ($isCalculatorPageFooter && !empty($currentUser)): ?>
        </div> <!-- end .print-layout-tfoot -->
    </div> <!-- end .print-layout-table -->
  <?php endif; ?>

  <script src="form-submit-enter.js?v=20260512-1&cb=<?= filemtime('form-submit-enter.js') ?>" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const passwordInputs = document.querySelectorAll('input[type="password"]');

      passwordInputs.forEach((input, index) => {
        if (input.dataset.passwordToggleReady === 'true') {
          return;
        }

        const wrapper = document.createElement('div');
        wrapper.className = 'password-toggle';

        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        const toggleButton = document.createElement('button');
        toggleButton.type = 'button';
        toggleButton.className = 'password-toggle__button';
        toggleButton.setAttribute('aria-controls', input.id || `password-field-${index + 1}`);
        toggleButton.setAttribute('aria-label', 'Zobraziť heslo');
        toggleButton.setAttribute('aria-pressed', 'false');
        toggleButton.textContent = 'Zobraziť';

        if (!input.id) {
          input.id = `password-field-${index + 1}`;
        }

        toggleButton.addEventListener('click', () => {
          const isVisible = input.type === 'text';
          input.type = isVisible ? 'password' : 'text';
          toggleButton.textContent = isVisible ? 'Zobraziť' : 'Skryť';
          toggleButton.setAttribute('aria-label', isVisible ? 'Zobraziť heslo' : 'Skryť heslo');
          toggleButton.setAttribute('aria-pressed', isVisible ? 'false' : 'true');
        });

        wrapper.appendChild(toggleButton);
        input.dataset.passwordToggleReady = 'true';
      });
    });
  </script>
</body>
</html>
