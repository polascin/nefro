<?php
// Ensure auth helpers are available when header is included directly.
if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/auth.php';
}

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
        <p class="site-header__tagline">Nefrológia&nbsp;· Dialýza&nbsp;· Interná medicína</p>

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

  <?php
  $nowUtc  = new DateTime('now', new DateTimeZone('UTC'));
  $utcSecs = (int)$nowUtc->format('H') * 3600
           + (int)$nowUtc->format('i') * 60
           + (int)$nowUtc->format('s');
  $initBeat = number_format((($utcSecs + 3600) % 86400) / 86.4, 2, '.', '');
  ?>
  <div class="site-header__beat-bar">
    <a href="https://www.swatch.com/en-us/internet-time.html"
       target="_blank" rel="noopener noreferrer"
       class="header-beat-link"
       title="Swiss Internet Time — reálny čas, 1 deň = 1000 beatov">
      <span id="beat-clock">@<?= $initBeat ?></span> .beat
    </a>
  </div>
  <script nonce="<?= htmlspecialchars(function_exists('getScriptNonce') ? getScriptNonce() : '', ENT_QUOTES) ?>">
  (function () {
      function swatchBeat() {
          var now = new Date();
          var ms = now.getUTCHours() * 3600000
                 + now.getUTCMinutes() * 60000
                 + now.getUTCSeconds() * 1000
                 + now.getUTCMilliseconds();
          return ((ms + 3600000) % 86400000 / 86400).toFixed(2);
      }
      function tick() {
          var el = document.getElementById('beat-clock');
          if (el) el.textContent = '@' + swatchBeat();
      }
      tick();
      setInterval(tick, 500);
  })();
  </script>
</header>
<?php include __DIR__ . '/main_nav.php'; ?>

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

<?php
$isCalculatorPage = str_starts_with(basename($_SERVER['PHP_SELF']), 'calculator');
if ($isCalculatorPage && !empty($currentUser)):
    $tb = trim((string)($currentUser['title_before'] ?? ''));
    $fn = trim((string)($currentUser['first_name'] ?? ''));
    $mn = trim((string)($currentUser['middle_name'] ?? ''));
    $ln = trim((string)($currentUser['last_name'] ?? ''));
    $ta = trim((string)($currentUser['title_after'] ?? ''));

    $fullNameParts = array_filter([$tb, $fn, $mn, $ln]);
    $fullName = implode(' ', $fullNameParts);
    if ($ta !== '') $fullName .= ', ' . $ta;

    $email = trim((string)($currentUser['email'] ?? ''));
    $mobile = trim((string)($currentUser['mobile_phone'] ?? ''));
    
    $line2Parts = array_filter([$email, $mobile]);
    $line2 = implode(' | ', $line2Parts);

    $org = trim((string)($currentUser['organization'] ?? ''));
    $job = trim((string)($currentUser['job_function'] ?? ''));
    $wMobile = trim((string)($currentUser['work_mobile_phone'] ?? ''));
    $orgWeb = trim((string)($currentUser['org_website'] ?? ''));
    $wEmail = trim((string)($currentUser['work_email'] ?? ''));

    $line3Parts = array_filter([$org, $job, $wMobile, $orgWeb, $wEmail]);
    $line3 = implode(' | ', $line3Parts);
?>
    <div class="print-layout-table">
        <div class="print-layout-thead">
            <div class="user-print-header print-only">
                <div class="user-print-header__content">
                    <div class="user-print-header__line1"><?= htmlspecialchars($fullName ?: ($currentUser['username'] ?? '')) ?></div>
                    <?php if ($line2 !== ''): ?><div class="user-print-header__line2"><?= htmlspecialchars($line2) ?></div><?php endif; ?>
                    <?php if ($line3 !== ''): ?><div class="user-print-header__line3"><?= htmlspecialchars($line3) ?></div><?php endif; ?>
                </div>
            </div>
        </div>
        <div class="print-layout-tbody">
<?php elseif ($isCalculatorPage): ?>
    <div class="print-layout-table">
        <div class="print-layout-thead">
            <div class="user-print-header print-only">
                <div class="user-print-header__content">
                    <div class="user-print-header__line1" style="font-style:italic;color:#666">Nie je prihlásený žiaden používateľ</div>
                </div>
            </div>
        </div>
        <div class="print-layout-tbody">
<?php endif; ?>
