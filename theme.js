/**
 * Logika pre Svetlý a Tmavý režim (Light / Dark Mode)
 * Autor: MUDr. Ľubomír Polaščín
 */

(function() {
    var hasPreferenceConsent = typeof window.npsHasConsent === 'function'
        && window.npsHasConsent('preferences');
    var isAuto = window.npsServerThemeAuto !== 0;
    var storedTheme = null;
    if (hasPreferenceConsent) {
        try {
            isAuto = localStorage.getItem('nps_theme_auto') !== '0';
            storedTheme = localStorage.getItem('nps_theme');
        } catch (e) {}
    }

    window.npsThemeAutoActive = isAuto;

    var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

    var theme;
    if (isAuto) {
        theme = prefersDark ? 'dark' : 'light';
    } else {
        theme = (storedTheme === 'dark' || storedTheme === 'light') ? storedTheme : (prefersDark ? 'dark' : 'light');
    }

    document.documentElement.setAttribute('data-theme', theme);
})();

document.addEventListener('DOMContentLoaded', () => {
    let themeToggleBtn = document.getElementById('themeToggleBtn');
    
    // Ak tlačidlo neexistuje v HTML, vytvoríme ho dynamicky a pridáme do body
    if (!themeToggleBtn) {
        const container = document.createElement('div');
        container.className = 'theme-toggle-container no-print';
        themeToggleBtn = document.createElement('button');
        themeToggleBtn.id = 'themeToggleBtn';
        themeToggleBtn.className = 'theme-toggle';
        themeToggleBtn.type = 'button';
        container.appendChild(themeToggleBtn);
        document.body.appendChild(container);
    }
    
    const initialTheme = document.documentElement.getAttribute('data-theme');
    setToggleAccessibility(initialTheme);
    updateToggleIcon(initialTheme);
    updateAvatars(initialTheme);
    
    themeToggleBtn.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        document.documentElement.setAttribute('data-theme', newTheme);
        window.npsThemeAutoActive = false;
        if (typeof window.npsHasConsent === 'function' && window.npsHasConsent('preferences')) {
            try {
                localStorage.setItem('nps_theme', newTheme);
                // Manuálne prepnutie deaktivuje auto režim lokálne;
                // trvalé nastavenie sa mení v profile.php
                localStorage.setItem('nps_theme_auto', '0');
            } catch (e) {}
        }

        setToggleAccessibility(newTheme);
        updateToggleIcon(newTheme);
        updateAvatars(newTheme);
    });

    // Živá odozva na zmenu systémovej témy — aplikuje sa len v auto režime
    const themeMq = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)');
    if (themeMq && typeof themeMq.addEventListener === 'function') {
        themeMq.addEventListener('change', (e) => {
            if (!window.npsThemeAutoActive) return;
            const newTheme = e.matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
            setToggleAccessibility(newTheme);
            updateToggleIcon(newTheme);
            updateAvatars(newTheme);
        });
    }

    window.addEventListener('nps:consent-changed', (event) => {
        const preferencesAllowed = event.detail && event.detail.preferences === true;
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';

        if (preferencesAllowed) {
            try {
                localStorage.setItem('nps_theme', currentTheme);
                localStorage.setItem('nps_theme_auto', window.npsThemeAutoActive ? '1' : '0');
            } catch (_) {}
            return;
        }

        window.npsThemeAutoActive = window.npsServerThemeAuto !== 0;
        const prefersDarkNow = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const resetTheme = prefersDarkNow ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', resetTheme);
        setToggleAccessibility(resetTheme);
        updateToggleIcon(resetTheme);
        updateAvatars(resetTheme);
    });

    function updateAvatars(theme) {
        // Aktualizuj header avatar
        const headerAvatar = document.getElementById('headerAvatar');
        if (headerAvatar && headerAvatar.dataset.isDefault === 'true') {
            headerAvatar.src = theme === 'dark' ? 'img/default-avatar-dark.svg' : 'img/default-avatar-light.svg';
        }
        
        // Aktualizuj avatar preview na profile stránke
        const avatarPreview = document.getElementById('avatarPreview');
        if (avatarPreview && avatarPreview.dataset.isDefault === 'true') {
            avatarPreview.src = theme === 'dark' ? 'img/default-avatar-dark.svg' : 'img/default-avatar-light.svg';
        }
    }

    function setToggleAccessibility(theme) {
        const isDark = theme === 'dark';
        themeToggleBtn.setAttribute('aria-pressed', String(isDark));
        themeToggleBtn.setAttribute('aria-label', isDark ? 'Prepnúť na svetlý režim' : 'Prepnúť na tmavý režim');
        themeToggleBtn.setAttribute('title', isDark ? 'Prepnúť na svetlý režim' : 'Prepnúť na tmavý režim');
    }
    
    function updateToggleIcon(theme) {
        if (theme === 'dark') {
            themeToggleBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="5"></circle>
                    <line x1="12" y1="1" x2="12" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="23"></line>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                    <line x1="1" y1="12" x2="3" y2="12"></line>
                    <line x1="21" y1="12" x2="23" y2="12"></line>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                </svg>
            `;
        } else {
            themeToggleBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
            `;
        }
    }

    // Auto-formátovanie a nápoveda pre telefónne čísla
    const telInputs = document.querySelectorAll('input[type="tel"]');
    telInputs.forEach(input => {
        if (!input.placeholder) input.placeholder = '+XXX ...';
        if (!input.title) input.title = 'Zadajte telefónne číslo s medzinárodnou predvoľbou (napr. +421, +420, +44, atď.)';
        if (!input.pattern) input.pattern = '^\\+?[0-9\\s]{9,20}$';
        
        const hint = document.createElement('small');
        hint.className = 'form-hint';
        hint.style.color = 'var(--text-secondary)';
        hint.style.display = 'block';
        hint.style.marginTop = '4px';
        hint.style.fontSize = '0.85rem';
        hint.textContent = 'Medzinárodný formát (napr. +421..., +44..., +1...)';
        input.parentNode.appendChild(hint);
        
        input.addEventListener('blur', function() {
            let val = this.value.trim();
            // Jednoduché automatické formátovanie pre zadané čísla bez medzier
            if (val.startsWith('+') && !val.includes(' ') && val.length > 5) {
                if ((val.startsWith('+421') || val.startsWith('+420')) && val.length === 13) {
                    this.value = val.substring(0, 4) + ' ' + val.substring(4, 7) + ' ' + val.substring(7, 10) + ' ' + val.substring(10, 13);
                } else {
                    // Základné oddelenie predvoľby od čísla pre iné štáty
                    let pLen = 4; // napr. +421
                    if (val.startsWith('+1') || val.startsWith('+7')) pLen = 2;
                    else if (val.startsWith('+44') || val.startsWith('+49') || val.startsWith('+33') || val.startsWith('+34') || val.startsWith('+39')) pLen = 3;
                    this.value = val.substring(0, pLen) + ' ' + val.substring(pLen);
                }
            }
        });
    });

    // Auto-formátovanie a nápoveda pre webové adresy
    const urlInputs = document.querySelectorAll('input[type="url"]');
    urlInputs.forEach(input => {
        if (!input.placeholder) input.placeholder = 'https://...';
        
        const hint = document.createElement('small');
        hint.className = 'form-hint';
        hint.style.color = 'var(--text-secondary)';
        hint.style.display = 'block';
        hint.style.marginTop = '4px';
        hint.style.fontSize = '0.85rem';
        hint.textContent = 'Napríklad: https://polascin.net/';
        input.parentNode.appendChild(hint);

        input.addEventListener('blur', function() {
            let val = this.value.trim();
            if (val && !/^https?:\/\//i.test(val)) {
                this.value = 'https://' + val;
            }
        });
    });

    // Rozbaľovacie zoznamy v sidebar
    const expandableLists = document.querySelectorAll('.expandable-list');
    expandableLists.forEach((list, listIndex) => {
        const limit = parseInt(list.dataset.limit) || 10;
        const items = list.querySelectorAll('li');
        const button = list.parentElement.querySelector('.show-more-btn');

        if (items.length <= limit) {
            if (button) button.hidden = true;
            return;
        }

        // Skryť položky nad limit
        items.forEach((item, index) => {
            if (index >= limit) {
                item.classList.add('hidden-item');
            }
        });

        if (button) {
            // Prístupnosť: tlačidlo oznamuje rozbalený/zbalený stav (WCAG 4.1.2).
            if (!list.id) {
                list.id = 'expandable-list-' + listIndex;
            }
            button.setAttribute('aria-controls', list.id);
            button.setAttribute('aria-expanded', 'false');

            button.addEventListener('click', () => {
                const isExpanded = button.classList.contains('expanded');

                if (isExpanded) {
                    // Skryť
                    items.forEach((item, index) => {
                        if (index >= limit) item.classList.add('hidden-item');
                    });
                    button.textContent = 'Zobraziť viac';
                    button.classList.remove('expanded');
                    button.setAttribute('aria-expanded', 'false');
                } else {
                    // Zobraziť všetko
                    items.forEach(item => item.classList.remove('hidden-item'));
                    button.textContent = 'Zobraziť menej';
                    button.classList.add('expanded');
                    button.setAttribute('aria-expanded', 'true');
                }
            });
        }
    });

    // Logika pre mobilné menu (Hamburger)
    const menuToggle = document.getElementById('menuToggle');
    const mainNavList = document.querySelector('.main-nav ul');
    
    if (menuToggle && mainNavList) {
        const setMenuState = (open, returnFocus = false) => {
            mainNavList.classList.toggle('is-open', open);
            menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            menuToggle.setAttribute('aria-label', open ? 'Zavrieť menu' : 'Otvoriť menu');
            const label = menuToggle.querySelector('span');
            if (label) label.textContent = open ? 'Zavrieť menu' : 'Menu';
            if (!open && returnFocus) menuToggle.focus();
        };

        menuToggle.addEventListener('click', () => {
            setMenuState(!mainNavList.classList.contains('is-open'));
        });

        // Zatvoriť menu po kliknutí na odkaz (najmä pre kotvy na tej istej stránke)
        mainNavList.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                setMenuState(false);
            });
        });

        document.addEventListener('click', (event) => {
            if (mainNavList.classList.contains('is-open')
                && !menuToggle.contains(event.target)
                && !mainNavList.contains(event.target)) {
                setMenuState(false);
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && mainNavList.classList.contains('is-open')) {
                setMenuState(false, true);
            }
        });
        const desktopQuery = window.matchMedia('(min-width: 961px)');
        const closeOnDesktop = (event) => {
            if (event.matches) setMenuState(false);
        };
        if (typeof desktopQuery.addEventListener === 'function') {
            desktopQuery.addEventListener('change', closeOnDesktop);
        } else if (typeof desktopQuery.addListener === 'function') {
            desktopQuery.addListener(closeOnDesktop);
        }
    }
});
