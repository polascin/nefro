<?php

declare(strict_types=1);

require_once __DIR__ . '/legal_data.php';

$info = legalInfo();
$pageLastUpdated = formatUserDateTime($info['effectiveDate'], 'd.m.Y');
$pageTimeZone = getUserTimezoneAbbr() . ' (' . getUserTimezone() . ')';

$legalTitle       = 'Cookie Policy';
$legalDescription = 'Ako Nefro-projekt Slovensko používa súbory cookies a podobné technológie, aké máte voľby a aké sú vaše práva na súkromie podľa regiónu.';
$legalSlug        = 'cookies.php';
$legalHeaderTitle = 'Zásady používania cookies';
$legalHeaderIntro = 'Cookie Policy';

include 'legal_head.php';
?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <article class="primary-article legal-article">
                <header>
                    <h2>Zásady používania súborov cookies</h2>
                    <p class="meta">
                        <?= htmlspecialchars($info['entity'], ENT_QUOTES, 'UTF-8') ?>
                        · Verzia <?= htmlspecialchars($info['version'], ENT_QUOTES, 'UTF-8') ?>
                        · Posledná aktualizácia:&nbsp;
                        <time datetime="<?= htmlspecialchars($info['effectiveDate'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($pageLastUpdated, ENT_QUOTES, 'UTF-8') ?></time>
                    </p>
                    <p>
                        Tieto zásady vysvetľujú, ako <?= htmlspecialchars($info['entity'], ENT_QUOTES, 'UTF-8') ?>
                        používa súbory cookies a podobné technológie (napr. úložisko
                        <code>localStorage</code> v prehliadači) a ako ich ovládate. Predvolene
                        nastavujeme iba nevyhnutné úložisko; všetko voliteľné vyžaduje vašu
                        výslovnú voľbu, nech ste kdekoľvek na svete.
                    </p>
                </header>

                <!-- SPRAVOVAŤ VOĽBY -->
                <section class="legal-updates" aria-labelledby="cookie-manage-heading">
                    <h3 id="cookie-manage-heading">Spravovať svoje voľby</h3>
                    <p>
                        Svoj súhlas — vrátane odhlásenia z akéhokoľvek predaja alebo zdieľania
                        osobných údajov — môžete kedykoľvek skontrolovať alebo zmeniť.
                    </p>
                    <button class="cookie-settings-trigger btn-outline btn-outline--mt"
                            type="button"
                            aria-haspopup="dialog"
                            aria-controls="cookieConsentModal">
                        Otvoriť nastavenia cookies
                    </button>
                </section>

                <!-- 1. ČO SÚ COOKIES -->
                <h3>1. Čo sú súbory cookies</h3>
                <p>
                    Cookies sú malé textové súbory, ktoré web ukladá vo vašom prehliadači.
                    Pomáhajú stránke fungovať (napr. udržať vaše prihlásenie), zapamätať si vaše
                    nastavenia a — len s vaším súhlasom — merať návštevnosť. Podobne funguje
                    aj <code>localStorage</code>, ktoré používame na uloženie vášho súhlasu
                    a po udelení preferenčného súhlasu aj na nastavenia vzhľadu, automatické
                    ukladanie a lokálnu históriu výsledkov kalkulačiek.
                </p>

                <!-- 2. KATEGÓRIE -->
                <h3>2. Kategórie, ktoré používame</h3>
                <div class="legal-regions">
                    <?php foreach (legalCookieCategories() as $cat): ?>
                        <div class="legal-region-card">
                            <p class="legal-region-card__region">
                                <?= htmlspecialchars($cat['title'], ENT_QUOTES, 'UTF-8') ?>
                                <?php if (!empty($cat['required'])): ?>
                                    <span class="legal-badge">vždy zapnuté</span>
                                <?php endif; ?>
                            </p>
                            <p class="legal-region-card__rights"><?= htmlspecialchars($cat['description'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- 3. ZOZNAM ÚLOŽISKA -->
                <h3>3. Čo konkrétne ukladáme</h3>
                <div class="admin-table-wrap legal-table-wrap">
                    <table class="admin-table legal-table">
                        <thead>
                            <tr>
                                <th scope="col">Názov</th>
                                <th scope="col">Kategória</th>
                                <th scope="col">Účel</th>
                                <th scope="col">Platnosť</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (legalStoredItems() as $item): ?>
                                <tr>
                                    <th scope="row"><code><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></code></th>
                                    <td><?= htmlspecialchars($item['category'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($item['purpose'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($item['duration'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- 4. GA4 -->
                <h3>4. Google Analytics 4 a súhlas</h3>
                <p>
                    Na meranie návštevnosti používame <strong>Google Analytics 4</strong>
                    (merací identifikátor <code>G-0JT5VMQ61K</code>) implementovaný cez
                    <strong>Google Consent Mode v2</strong>. Skript GA4 sa načíta a dáta sa
                    odosielajú <em>až po</em> udelení súhlasu na analytické alebo marketingové
                    cookies (<code>analytics_storage: granted/denied</code>). Dáta spracúva
                    Google LLC (USA); prenos je krytý štandardnými zmluvnými doložkami (SCC)
                    podľa čl. 46 GDPR. Viac:
                    <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">Google Privacy Policy</a>,
                    <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer">Google Analytics Opt-out</a>.
                </p>

                <!-- 5. ULOŽENIE SÚHLASU -->
                <h3>5. Uloženie a odvolanie súhlasu</h3>
                <p>
                    Váš súhlas sa ukladá primárne do <code>localStorage</code> a zálohou do
                    cookie <code>nps_cookie_consent</code> s platnosťou <strong>365 dní</strong>
                    (<code>SameSite=Lax; Secure</code>). Pri opakovanej návšteve sa banner
                    nezobrazuje, kým je súhlas platný. Súhlas môžete kedykoľvek zmeniť alebo
                    odvolať tlačidlom vyššie alebo odkazom „Nastavenia cookies“ v päte stránky;
                    pri odvolaní sa analytické cookies deaktivujú a údaje z voliteľného
                    preferenčného úložiska sa vymažú.
                </p>

                <!-- 6. PRÁVA PODĽA REGIÓNU -->
                <h3>6. Vaše práva na súkromie podľa regiónu</h3>
                <div class="legal-regions">
                    <?php foreach (legalRightsRegions() as $region): ?>
                        <div class="legal-region-card">
                            <p class="legal-region-card__region"><?= htmlspecialchars($region['region'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="legal-region-card__law"><?= htmlspecialchars($region['law'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="legal-region-card__rights"><?= htmlspecialchars($region['rights'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- 7. UPLATNENIE PRÁV -->
                <h3>7. Uplatnenie práv</h3>
                <p>
                    Na okamžitú zmenu súhlasu použite tlačidlo „Otvoriť nastavenia cookies“
                    vyššie. Pri akejkoľvek inej žiadosti o súkromie nás kontaktujte na
                    <a href="mailto:<?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?></a>.
                    Odpovieme v lehote, ktorú vyžaduje vaše miestne právo. Pozrite si aj naše
                    <a href="privacy.php">Zásady ochrany osobných údajov</a>.
                </p>

                <?php $legalCurrent = 'cookies.php'; include 'legal_related.php'; ?>
            </article>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
