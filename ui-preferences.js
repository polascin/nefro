/**
 * Komplexný Cookie Consent Banner (GDPR, CCPA) s Google Consent Mode v2
 * Autor: MUDr. Ľubomír Polaščín
 */

const consentKey = 'nps_cookie_consent';
const consentCookieMaxAgeDays = 365;

// Verzia Privacy Policy — pri zmene zásad aktualizovať tento reťazec.
// Všetky uložené súhlasy zo staršej verzie sa automaticky invalidujú
// a banner sa zobrazí znova (GDPR čl. 7 ods. 3 — nový súhlas pri zmene podmienok).
const consentVersion = '2026-05-15';

// Predvolené nastavenia
const defaultSettings = {
    necessary: true, // Vždy zapnuté
    analytics: false,
    marketing: false,
    preferences: false,
    timestamp: null
};

// Pomocná funkcia pre synchrónne načítanie cookie
function getCookieSync(name) {
    const escapedName = name.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const match = document.cookie.match(new RegExp(`(?:^|; )${escapedName}=([^;]*)`));
    return match ? decodeURIComponent(match[1]) : null;
}

// Synchrónne načítanie súhlasu z localStorage alebo cookie pred inicializáciou GA4.
// Overuje verziu — pri nezhode vráti null (vynúti zobrazenie bannera).
function readStoredConsentSync() {
    let consent = null;
    try {
        const fromLocalStorage = localStorage.getItem(consentKey);
        if (fromLocalStorage) {
            const parsed = JSON.parse(fromLocalStorage);
            // Verzia sa musí zhodovať s aktuálnou consentVersion
            if (parsed && parsed.version === consentVersion) {
                consent = parsed;
            }
        }
    } catch (e) {
        // Ignorovať chyby localStorage
    }

    if (!consent) {
        const cookieVal = getCookieSync(consentKey);
        if (cookieVal) {
            try {
                const parsed = JSON.parse(cookieVal);
                if (parsed && parsed.version === consentVersion) {
                    consent = parsed;
                }
            } catch (e) {
                // Ignorovať chyby
            }
        }
    }
    return consent;
}

const initialConsent = readStoredConsentSync() || defaultSettings;

// Inicializácia Google Analytics 4 (Google Consent Mode v2)
window.dataLayer = window.dataLayer || [];
window.gtag = function(){ dataLayer.push(arguments); };

try {
    // Nastavenie defaultného súhlasu podľa uložených preferencií (zabráni strate dát pri prvom zobrazení pre vracajúcich sa návštevníkov)
    gtag('consent', 'default', {
      'ad_storage': initialConsent.marketing ? 'granted' : 'denied',
      'ad_user_data': initialConsent.marketing ? 'granted' : 'denied',
      'ad_personalization': initialConsent.marketing ? 'granted' : 'denied',
      'analytics_storage': initialConsent.analytics ? 'granted' : 'denied'
    });

    // Dynamické načítanie Google Tag Manager scriptu
    const gtagScript = document.createElement('script');
    gtagScript.async = true;
    gtagScript.src = "https://www.googletagmanager.com/gtag/js?id=G-0JT5VMQ61K";
    gtagScript.onerror = function() {
        console.warn("NPS Privacy Manager: GA4 script bol zablokovaný (pravdepodobne blokovačom reklám alebo nastala chyba siete).");
    };
    document.head.appendChild(gtagScript);

    gtag('js', new Date());
    gtag('config', 'G-0JT5VMQ61K');
} catch (error) {
    console.warn("NPS Privacy Manager: GA4 script bol zablokovaný (pravdepodobne Ad-Blockerom).", error);
}

function initPrivacyManager() {
    const bannerId = 'cookieConsentBanner';
    const modalId = 'cookieConsentModal';

    // Načítanie súhlasu s ochranou proti chybám
    let currentConsent = null;
    let hasResponded = false;

    function setCookie(name, value, days) {
        const maxAge = Math.max(1, Math.floor(days * 24 * 60 * 60));
        const securePart = window.location.protocol === 'https:' ? '; Secure' : '';
        document.cookie = `${name}=${encodeURIComponent(value)}; Path=/; Max-Age=${maxAge}; SameSite=Lax${securePart}`;
    }

    function persistConsent(consentData) {
        const serializedConsent = JSON.stringify(consentData);

        let localStorageSaved = false;
        try {
            localStorage.setItem(consentKey, serializedConsent);
            localStorageSaved = true;
        } catch (e) {
            console.warn('NPS Privacy Manager: Nepodarilo sa uložiť nastavenia do localStorage, používam cookie fallback.', e);
        }

        // Cookie fallback zároveň drží consent dostupný aj bez localStorage.
        setCookie(consentKey, serializedConsent, consentCookieMaxAgeDays);

        return localStorageSaved;
    }

    function syncCookieBannerSpace() {
        if (!banner) {
            return;
        }

        const bannerIsVisible = !banner.classList.contains('hidden');
        const bannerHeight = bannerIsVisible ? Math.ceil(banner.getBoundingClientRect().height) : 0;
        const extraSpace = bannerIsVisible ? Math.max(32, bannerHeight + 24) : 0;

        document.body.style.setProperty('--cookie-banner-space', `${extraSpace}px`);
    }

    try {
        currentConsent = readStoredConsentSync();
        hasResponded = currentConsent !== null;
    } catch (e) {
        console.warn('NPS Privacy Manager: Prehliadač blokuje trvalé uloženie súhlasu.');
        hasResponded = false; // Vynúti aspoň snahu o zobrazenie
    }

    if (!currentConsent) {
        currentConsent = { ...defaultSettings };
    }

    // Injektovanie HTML do body
    function injectHTML() {
        // Banner
        const bannerHTML = `
            <div id="${bannerId}" class="cookie-banner ${hasResponded ? 'hidden' : ''}" role="region" aria-label="Nastavenia súkromia" aria-labelledby="cookieBannerTitle" aria-describedby="cookieBannerDesc">
                <div class="cookie-content">
                    <h2 id="cookieBannerTitle">Vážime si vaše súkromie</h2>
                    <p id="cookieBannerDesc">
                        Naša webová stránka používa súbory cookies na zabezpečenie základného fungovania (nevyhnutné cookies) a s vaším súhlasom aj na analytické, marketingové a personalizačné účely. Vaše údaje nám pomáhajú zlepšovať obsah a používateľský zážitok.
                        Viac informácií nájdete v našich <a href="privacy.php">Zásadách ochrany osobných údajov</a>.
                    </p>
                </div>
                <div class="cookie-buttons">
                    <button id="btnAcceptAll" class="btn-primary">Prijať všetko</button>
                    <button id="btnRejectAll" class="btn-secondary">Odmietnuť voliteľné</button>
                    <button id="btnCustomize" class="btn-outline">Prispôsobiť</button>
                </div>
            </div>
        `;

        // Modal pre Preferences
        const modalHTML = `
            <div id="${modalId}" class="cookie-modal hidden" role="dialog" aria-modal="true" aria-labelledby="cookieModalTitle">
                <div class="cookie-modal-content">
                    <div class="cookie-modal-header">
                        <h2 id="cookieModalTitle">Prispôsobenie súborov cookies</h2>
                        <button id="btnCloseModal" class="btn-close" aria-label="Zatvoriť">&times;</button>
                    </div>
                    <div class="cookie-modal-body">
                        <p>Tu môžete povoliť alebo zakázať jednotlivé kategórie cookies. Pre fungovanie stránky sú kľúčové 'Nevyhnutné' cookies, ktoré nie je možné vypnúť.</p>
                        
                        <div class="cookie-category">
                            <div class="category-info">
                                <h3 id="necessaryCookiesTitle">Nevyhnutné cookies (Strictly Necessary)</h3>
                                <p>Sú potrebné pre správne fungovanie webu (napr. uloženie tohto súhlasu). Nedajú sa vypnúť.</p>
                            </div>
                            <div class="category-toggle">
                                <label class="switch">
                                    <input type="checkbox" aria-labelledby="necessaryCookiesTitle" checked disabled>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="cookie-category">
                            <div class="category-info">
                                <h3 id="analyticsCookiesTitle">Analytické cookies (Analytics)</h3>
                                <p>Pomáhajú nám pochopiť, ako návštevníci používajú náš web. Dáta sú zbierané anonymne.</p>
                            </div>
                            <div class="category-toggle">
                                <label class="switch">
                                    <input type="checkbox" id="toggleAnalytics" aria-labelledby="analyticsCookiesTitle" ${currentConsent.analytics ? 'checked' : ''}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="cookie-category">
                            <div class="category-info">
                                <h3 id="marketingCookiesTitle">Marketingové cookies (Marketing)</h3>
                                <p>Používajú sa na sledovanie návštevníkov naprieč webmi s cieľom zobraziť relevantnú reklamu.</p>
                            </div>
                            <div class="category-toggle">
                                <label class="switch">
                                    <input type="checkbox" id="toggleMarketing" aria-labelledby="marketingCookiesTitle" ${currentConsent.marketing ? 'checked' : ''}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="cookie-category">
                            <div class="category-info">
                                <h3 id="preferencesCookiesTitle">Preferenčné cookies (Preferences)</h3>
                                <p>Umožňujú stránke zapamätať si informácie, ktoré menia, ako sa stránka správa alebo vyzerá (napr. preferovaný jazyk).</p>
                            </div>
                            <div class="category-toggle">
                                <label class="switch">
                                    <input type="checkbox" id="togglePreferences" aria-labelledby="preferencesCookiesTitle" ${currentConsent.preferences ? 'checked' : ''}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="cookie-modal-footer">
                        <button id="btnSavePreferences" class="btn-primary">Uložiť moje nastavenia</button>
                    </div>
                </div>
            </div>
            <div id="cookieModalOverlay" class="cookie-overlay hidden"></div>
        `;

        document.body.insertAdjacentHTML('beforeend', bannerHTML + modalHTML);
    }

    injectHTML();

    // Referencie na DOM elementy
    const banner = document.getElementById(bannerId);
    const modal = document.getElementById(modalId);
    const overlay = document.getElementById('cookieModalOverlay');
    let lastFocusedElement = null;
    
    // Tlačidlá
    const btnAcceptAll = document.getElementById('btnAcceptAll');
    const btnRejectAll = document.getElementById('btnRejectAll');
    const btnCustomize = document.getElementById('btnCustomize');
    const btnCloseModal = document.getElementById('btnCloseModal');
    const btnSavePreferences = document.getElementById('btnSavePreferences');

    // Toggles
    const toggleAnalytics = document.getElementById('toggleAnalytics');
    const toggleMarketing = document.getElementById('toggleMarketing');
    const togglePreferences = document.getElementById('togglePreferences');

    modal.setAttribute('aria-hidden', 'true');
    syncCookieBannerSpace();

    function saveConsent(consentData) {
        consentData.timestamp = new Date().toISOString();
        // Uložiť aktuálnu verziu súhlasu — pri budúcej zmene Privacy Policy
        // stačí aktualizovať konštantu consentVersion na začiatku súboru
        consentData.version = consentVersion;
        persistConsent(consentData);
        banner.classList.add('hidden');
        syncCookieBannerSpace();
        closeModal();
        applyConsent(consentData);
    }

    function applyConsent(consentData) {
        // Aplikácia súhlasu pre Google Analytics 4 (Consent Mode v2)
        gtag('consent', 'update', {
            'analytics_storage': consentData.analytics ? 'granted' : 'denied',
            'ad_storage': consentData.marketing ? 'granted' : 'denied',
            'ad_user_data': consentData.marketing ? 'granted' : 'denied',
            'ad_personalization': consentData.marketing ? 'granted' : 'denied'
        });
        
        // GA4 consent update applied
    }

    // Ak už bol súhlas udelený predtým, aplikuj ho hneď po načítaní (aktualizuje prípadné zmeny)
    if (hasResponded) {
        applyConsent(currentConsent);
    }

    function openModal() {
        lastFocusedElement = document.activeElement;
        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden'; // Zabrániť scrollovaniu pod modalom
        
        // Obnova aktuálnych nastavení do toggle tlačidiel
        const saved = readStoredConsentSync();

        const effectiveSettings = saved || defaultSettings;
        
        toggleAnalytics.checked = effectiveSettings.analytics;
        toggleMarketing.checked = effectiveSettings.marketing;
        togglePreferences.checked = effectiveSettings.preferences;

        btnCloseModal.focus();
    }

    function closeModal() {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';

        if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
            lastFocusedElement.focus();
        }
    }

    window.addEventListener('resize', syncCookieBannerSpace, { passive: true });

    function trapFocusInModal(event) {
        if (modal.classList.contains('hidden') || event.key !== 'Tab') {
            return;
        }

        const focusableElements = modal.querySelectorAll(
            'button:not([disabled]), input:not([disabled]), [href], [tabindex]:not([tabindex="-1"])'
        );

        if (!focusableElements.length) {
            return;
        }

        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];

        if (event.shiftKey && document.activeElement === firstFocusable) {
            event.preventDefault();
            lastFocusable.focus();
        } else if (!event.shiftKey && document.activeElement === lastFocusable) {
            event.preventDefault();
            firstFocusable.focus();
        }
    }

    // Event listenery
    btnAcceptAll.addEventListener('click', () => {
        saveConsent({
            necessary: true,
            analytics: true,
            marketing: true,
            preferences: true
        });
    });

    btnRejectAll.addEventListener('click', () => {
        saveConsent({
            necessary: true,
            analytics: false,
            marketing: false,
            preferences: false
        });
    });

    btnCustomize.addEventListener('click', openModal);
    btnCloseModal.addEventListener('click', closeModal);
    overlay.addEventListener('click', closeModal);
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
            return;
        }

        trapFocusInModal(event);
    });

    btnSavePreferences.addEventListener('click', () => {
        saveConsent({
            necessary: true,
            analytics: toggleAnalytics.checked,
            marketing: toggleMarketing.checked,
            preferences: togglePreferences.checked
        });
    });

    // Vystavenie funkcie openModal globálne pre prípadné ďalšie využitie
    window.openCookiePreferences = openModal;

    // Delegovaný handler funguje aj pre dynamicky vložené prvky (napr. pri live-reloade).
    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('.cookie-settings-trigger');
        if (!trigger) {
            return;
        }

        event.preventDefault();
        openModal();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPrivacyManager, { once: true });
} else {
    initPrivacyManager();
}
