/**
 * Logika pre Svetlý a Tmavý režim (Light / Dark Mode)
 * Autor: MUDr. Ľubomír Polaščín
 */

(function() {
    let storedTheme = null;
    try {
        storedTheme = localStorage.getItem('nps_theme');
    } catch (e) {
        storedTheme = null;
    }
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    let initialTheme = 'light';
    if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
        initialTheme = 'dark';
    }
    
    document.documentElement.setAttribute('data-theme', initialTheme);
})();

document.addEventListener('DOMContentLoaded', () => {
    let themeToggleBtn = document.getElementById('themeToggleBtn');
    
    // Ak tlačidlo neexistuje v HTML, vytvoríme ho dynamicky a pridáme do body
    if (!themeToggleBtn) {
        const container = document.createElement('div');
        container.className = 'theme-toggle-container';
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
    updateHeaderAvatar(initialTheme);
    
    themeToggleBtn.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        try {
            localStorage.setItem('nps_theme', newTheme);
        } catch (e) {
            // Ignorovať zlyhanie uloženia, téma ostane funkčná aspoň pre aktuálnu reláciu.
        }

        setToggleAccessibility(newTheme);
        updateToggleIcon(newTheme);
        updateHeaderAvatar(newTheme);
    });

    function updateHeaderAvatar(theme) {
        const headerAvatar = document.getElementById('headerAvatar');
        if (headerAvatar && headerAvatar.dataset.isDefault === 'true') {
            headerAvatar.src = theme === 'dark' ? 'img/default-avatar-dark.svg' : 'img/default-avatar-light.svg';
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
});
