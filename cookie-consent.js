/**
 * Komplexný Cookie Consent Banner (GDPR, CCPA)
 * Autor: MUDr. Ľubomír Polaščín
 */

document.addEventListener('DOMContentLoaded', () => {
    const consentKey = 'nps_cookie_consent';
    const bannerId = 'cookieConsentBanner';
    const modalId = 'cookieConsentModal';

    // Predvolené nastavenia
    const defaultSettings = {
        necessary: true, // Vždy zapnuté
        analytics: false,
        marketing: false,
        preferences: false,
        timestamp: null
    };

    // Načítanie súhlasu
    let currentConsent = JSON.parse(localStorage.getItem(consentKey));
    let hasResponded = currentConsent !== null;

    if (!currentConsent) {
        currentConsent = { ...defaultSettings };
    }

    // Injektovanie HTML do body
    function injectHTML() {
        // Banner
        const bannerHTML = `
            <div id="${bannerId}" class="cookie-banner ${hasResponded ? 'hidden' : ''}" role="dialog" aria-live="polite" aria-labelledby="cookieBannerTitle" aria-describedby="cookieBannerDesc">
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
                                <h3>Nevyhnutné cookies (Strictly Necessary)</h3>
                                <p>Sú potrebné pre správne fungovanie webu (napr. uloženie tohto súhlasu). Nedajú sa vypnúť.</p>
                            </div>
                            <div class="category-toggle">
                                <label class="switch">
                                    <input type="checkbox" checked disabled>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="cookie-category">
                            <div class="category-info">
                                <h3>Analytické cookies (Analytics)</h3>
                                <p>Pomáhajú nám pochopiť, ako návštevníci používajú náš web. Dáta sú zbierané anonymne.</p>
                            </div>
                            <div class="category-toggle">
                                <label class="switch">
                                    <input type="checkbox" id="toggleAnalytics" ${currentConsent.analytics ? 'checked' : ''}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="cookie-category">
                            <div class="category-info">
                                <h3>Marketingové cookies (Marketing)</h3>
                                <p>Používajú sa na sledovanie návštevníkov naprieč webmi s cieľom zobraziť relevantnú reklamu.</p>
                            </div>
                            <div class="category-toggle">
                                <label class="switch">
                                    <input type="checkbox" id="toggleMarketing" ${currentConsent.marketing ? 'checked' : ''}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="cookie-category">
                            <div class="category-info">
                                <h3>Preferenčné cookies (Preferences)</h3>
                                <p>Umožňujú stránke zapamätať si informácie, ktoré menia, ako sa stránka správa alebo vyzerá (napr. preferovaný jazyk).</p>
                            </div>
                            <div class="category-toggle">
                                <label class="switch">
                                    <input type="checkbox" id="togglePreferences" ${currentConsent.preferences ? 'checked' : ''}>
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

    function saveConsent(consentData) {
        consentData.timestamp = new Date().toISOString();
        localStorage.setItem(consentKey, JSON.stringify(consentData));
        banner.classList.add('hidden');
        closeModal();
        applyConsent(consentData);
    }

    function applyConsent(consentData) {
        // Tu by sa aktivovali/deaktivovali skripty na základe consentData
        // Napríklad ak consentData.analytics == true, injektovať Google Analytics, atď.
        console.log("Cookie consent aplikovaný: ", consentData);
    }

    // Ak už bol súhlas udelený predtým, aplikuj ho hneď po načítaní
    if (hasResponded) {
        applyConsent(currentConsent);
    }

    function openModal() {
        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Zabrániť scrollovaniu pod modalom
        
        // Obnova aktuálnych nastavení do toggle tlačidiel
        const saved = JSON.parse(localStorage.getItem(consentKey)) || defaultSettings;
        toggleAnalytics.checked = saved.analytics;
        toggleMarketing.checked = saved.marketing;
        togglePreferences.checked = saved.preferences;
    }

    function closeModal() {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
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

    // Pridanie event listenerov pre odkazy na otvorenie nastavení (namiesto inline onclick kvôli CSP)
    const cookieTriggers = document.querySelectorAll('.cookie-settings-trigger');
    cookieTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
    });
});
