<?php
declare(strict_types=1);
if (defined('MAIN_NAV_INCLUDED')) return;
define('MAIN_NAV_INCLUDED', 1);

// Aktívna položka: automatická detekcia, alebo ručné nastavenie cez $navActiveItem pred include.
$_navCurrent = isset($navActiveItem) ? $navActiveItem : basename((string) ($_SERVER['PHP_SELF'] ?? ''));

// Kalkulačky sú aktívne pre všetky calculator_* stránky aj pre calculators.php
$_navCalcActive = $_navCurrent === 'calculators.php' || str_starts_with($_navCurrent, 'calculator_');

// Nástroje sú aktívne pre nastroje.php aj pre všetky nastroj_* stránky
$_navToolsActive = $_navCurrent === 'nastroje.php' || str_starts_with($_navCurrent, 'nastroj_');

// Štúdie sú aktívne pre hub aj detail
$_navStudiesActive = $_navCurrent === 'studie.php' || $_navCurrent === 'studia.php';

// Na hlavnej stránke odkazujeme na vlastné sekcie (hash), inde na index.php
$_navOnIndex = $_navCurrent === 'index.php';

if (!function_exists('_navA')) {
    function _navA(string $href, string $label, bool $active): string {
        if ($active) {
            return '<a href="' . htmlspecialchars($href) . '" class="active" aria-current="page">'
                . htmlspecialchars($label) . '</a>';
        }
        return '<a href="' . htmlspecialchars($href) . '">' . htmlspecialchars($label) . '</a>';
    }
}
?>
<nav class="main-nav" aria-label="Hlavná navigácia">
    <div class="container">
        <button class="menu-toggle" id="menuToggle" aria-label="Otvoriť menu" aria-expanded="false">
            <span>Menu</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
        <ul>
            <li><?= _navA($_navOnIndex ? '#domov' : 'index.php', 'Domov', $_navCurrent === 'index.php') ?></li>
            <li><?= _navA('populars.php', 'Pre pacientov', $_navCurrent === 'populars.php') ?></li>
            <li><?= _navA('calculators.php', 'Kalkulačky', $_navCalcActive) ?></li>
            <li><?= _navA('nastroje.php', 'Nástroje', $_navToolsActive) ?></li>
            <li><?= _navA('cheatsheets.php', 'Ťaháky', $_navCurrent === 'cheatsheets.php') ?></li>
            <li><?= _navA('studie.php', 'Štúdie', $_navStudiesActive) ?></li>
            <li><?= _navA('search.php', 'Vyhľadávanie', $_navCurrent === 'search.php') ?></li>
            <li class="main-nav__break" role="presentation" aria-hidden="true"></li>
            <li><a href="<?= $_navOnIndex ? '#sluzby' : 'index.php#sluzby' ?>">Služby</a></li>
            <li><a href="<?= $_navOnIndex ? '#kontakt' : 'index.php#kontakt' ?>">Kontakt</a></li>
            <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
                <li><?= _navA('discussion.php', 'Diskusia', $_navCurrent === 'discussion.php') ?></li>
                <li><?= _navA('profile.php', 'Môj profil', $_navCurrent === 'profile.php') ?></li>
                <?php if (function_exists('isAdmin') && isAdmin()): ?>
                    <li><?= _navA('admin.php', 'Administrácia', in_array($_navCurrent, ['admin.php', 'admin_articles.php', 'admin_discussion.php'], true)) ?></li>
                <?php endif; ?>
                <li>
                    <form action="logout.php" method="post" class="nav-logout-form">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(function_exists('generateCsrfToken') ? generateCsrfToken() : '') ?>">
                        <button type="submit" class="nav-logout-btn">Odhlásiť sa</button>
                    </form>
                </li>
            <?php else: ?>
                <li><?= _navA('login.php', 'Prihlásenie', $_navCurrent === 'login.php') ?></li>
                <li><?= _navA('register.php', 'Registrácia', $_navCurrent === 'register.php') ?></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<?php if ($_navCalcActive): include 'calc_subnav.php'; endif; ?>
<script nonce="<?= htmlspecialchars(function_exists('getScriptNonce') ? getScriptNonce() : '', ENT_QUOTES) ?>">
(function () {
    // Hamburger toggle
    var navBtn = document.getElementById('menuToggle');
    var navUl  = navBtn ? navBtn.parentNode.querySelector('ul') : null;
    if (navBtn && navUl) {
        navBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = navUl.style.display !== 'flex';
            navUl.style.display       = open ? 'flex'   : 'none';
            navUl.style.flexDirection = open ? 'column' : '';
            navUl.style.gap           = open ? '0'      : '';
            navUl.style.width         = open ? '100%'   : '';
            navBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            navBtn.setAttribute('aria-label',    open ? 'Zavrieť menu' : 'Otvoriť menu');
        });
        document.addEventListener('click', function (e) {
            if (navUl.style.display === 'flex' && !navBtn.contains(e.target) && !navUl.contains(e.target)) {
                navUl.style.display = 'none';
                navBtn.setAttribute('aria-expanded', 'false');
                navBtn.setAttribute('aria-label', 'Otvoriť menu');
            }
        });
    }

    // is-stuck IntersectionObserver
    var nav = document.querySelector('.main-nav');
    if (nav && window.IntersectionObserver) {
        var sentinel = document.createElement('div');
        sentinel.style.cssText = 'position:absolute;height:1px;width:1px;top:0;pointer-events:none;visibility:hidden';
        nav.parentNode.insertBefore(sentinel, nav);
        new IntersectionObserver(function (entries) {
            nav.classList.toggle('is-stuck', !entries[0].isIntersecting);
        }, { threshold: [1] }).observe(sentinel);
    }
})();
</script>
