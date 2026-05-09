/**
 * Núdzový fallback pre otváranie cookie nastavení.
 * Pomáha v prípadoch, keď primárny listener zlyhá (napr. live-reload edge case).
 */
(function () {
    function openCookieSettings(event) {
        const trigger = event.target.closest('.cookie-settings-trigger');
        if (!trigger) {
            return;
        }

        event.preventDefault();

        if (typeof window.openCookiePreferences === 'function') {
            window.openCookiePreferences();
            return;
        }

        // Posledný fallback: manuálne zobrazenie modalu, ak už existuje v DOM.
        const modal = document.getElementById('cookieConsentModal');
        const overlay = document.getElementById('cookieModalOverlay');
        if (!modal) {
            return;
        }

        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        if (overlay) {
            overlay.classList.remove('hidden');
        }
        document.body.style.overflow = 'hidden';
    }

    document.addEventListener('click', openCookieSettings, true);
})();
