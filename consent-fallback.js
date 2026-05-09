/**
 * Núdzový fallback pre otváranie cookie nastavení.
 * Pomáha v prípadoch, keď primárny listener zlyhá (napr. live-reload edge case).
 */
(function () {
    function forceOpenCookieSettings() {
        if (typeof window.openCookiePreferences === 'function') {
            try {
                window.openCookiePreferences();
                return true;
            } catch (e) {
                // Pokračuj na ďalšie fallback vetvy.
            }
        }

        // Fallback 1: manuálne zobrazenie modalu, ak už existuje v DOM.
        const modal = document.getElementById('cookieConsentModal');
        const overlay = document.getElementById('cookieModalOverlay');
        if (modal) {
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            if (overlay) {
                overlay.classList.remove('hidden');
            }
            document.body.style.overflow = 'hidden';
            return true;
        }

        // Fallback 2: zobraz banner, ak je skrytý.
        const banner = document.getElementById('cookieConsentBanner');
        if (banner) {
            banner.classList.remove('hidden');
            return true;
        }

        return false;
    }

    function openCookieSettings(event) {
        const trigger = event.target.closest('.cookie-settings-trigger');
        if (!trigger) {
            return;
        }

        event.preventDefault();
        forceOpenCookieSettings();
    }

    function openByHash() {
        if (window.location.hash === '#cookie-settings') {
            forceOpenCookieSettings();
        }
    }

    window.openCookiePreferencesFallback = forceOpenCookieSettings;
    window.__cookieFallbackReady = true;

    document.addEventListener('click', openCookieSettings, true);
    window.addEventListener('hashchange', openByHash);
    openByHash();
})();
