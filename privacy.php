<?php

declare(strict_types=1);

require_once __DIR__ . '/legal_data.php';
require_once __DIR__ . '/auth.php';

$info = legalInfo();
$pageLastUpdated = formatUserDateTime($info['effectiveDate'], 'd.m.Y');
$pageTimeZone = getUserTimezoneAbbr() . ' (' . getUserTimezone() . ')';

$legalTitle       = 'Ochrana osobných údajov';
$legalDescription = 'Zásady ochrany osobných údajov pre Nefro-projekt Slovensko — aké údaje spracúvame, na akom právnom základe, sprostredkovatelia a vaše práva podľa GDPR a zákonov sveta.';
$legalSlug        = 'privacy.php';
$legalHeaderTitle = 'Zásady ochrany osobných údajov';
$legalHeaderIntro = 'Privacy Policy';

include 'legal_head.php';
?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <article class="primary-article legal-article">
                <header>
                    <h2>Zásady ochrany osobných údajov</h2>
                    <p class="meta">
                        <?= htmlspecialchars($info['entity'], ENT_QUOTES, 'UTF-8') ?>
                        · Verzia <?= htmlspecialchars($info['version'], ENT_QUOTES, 'UTF-8') ?>
                        · Posledná aktualizácia:&nbsp;
                        <time datetime="<?= htmlspecialchars($info['effectiveDate'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($pageLastUpdated, ENT_QUOTES, 'UTF-8') ?></time>
                    </p>
                    <p>
                        Tieto Zásady vysvetľujú, ako prevádzkovateľ webovej lokality
                        <strong><?= htmlspecialchars($info['entity'], ENT_QUOTES, 'UTF-8') ?></strong>
                        (<code><?= htmlspecialchars($info['url'], ENT_QUOTES, 'UTF-8') ?></code>) zhromažďuje,
                        používa, zdieľa a chráni vaše osobné údaje a aké práva máte. Vzťahujú sa
                        na túto webovú lokalitu a jej služby.
                    </p>
                </header>

                <!-- SÚHRN ZMIEN -->
                <section class="legal-updates" aria-labelledby="legal-updates-heading">
                    <h3 id="legal-updates-heading">Súhrn posledných zmien</h3>
                    <ul>
                        <?php foreach (legalRecentUpdates() as $update): ?>
                            <li><?= htmlspecialchars($update, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <!-- 1. PREVÁDZKOVATEĽ -->
                <h3>1. Kto zodpovedá za vaše údaje</h3>
                <p>
                    Prevádzkovateľom je <strong><?= htmlspecialchars($info['operator'], ENT_QUOTES, 'UTF-8') ?></strong>
                    (IČO <?= htmlspecialchars($info['companyId'], ENT_QUOTES, 'UTF-8') ?>),
                    so sídlom v <?= htmlspecialchars($info['establishment'], ENT_QUOTES, 'UTF-8') ?>,
                    ktorý prevádzkuje <?= htmlspecialchars($info['entity'], ENT_QUOTES, 'UTF-8') ?>.
                    V otázkach súkromia alebo pri uplatnení práv nás kontaktujte na
                    <a href="mailto:<?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?></a>.
                    Máte tiež právo podať sťažnosť na dozorný úrad; naším vedúcim dozorným úradom je
                    <a href="<?= htmlspecialchars($info['supervisoryAuthorityUrl'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($info['supervisoryAuthority'], ENT_QUOTES, 'UTF-8') ?></a>.
                </p>

                <!-- 2. AKÉ ÚDAJE ZHROMAŽĎUJEME -->
                <h3>2. Aké osobné údaje spracúvame</h3>
                <div class="admin-table-wrap legal-table-wrap">
                    <table class="admin-table legal-table">
                        <thead>
                            <tr>
                                <th scope="col">Kategória</th>
                                <th scope="col">Príklady</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (legalDataCategories() as $row): ?>
                                <tr>
                                    <th scope="row"><?= htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8') ?></th>
                                    <td><?= htmlspecialchars($row['examples'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p>
                    Spracúvame údaje, ktoré nám poskytnete (napr. pri registrácii), údaje
                    vznikajúce pri používaní služby a obmedzené technické údaje zbierané
                    automaticky. Údaje o zdraví uložené na serveri (výsledky kalkulačiek
                    s pacientskymi identifikátormi) vkladá výhradne prihlásený lekár a sú
                    asociované s jeho kontom. Neprihlásenému používateľovi sa po udelení
                    preferenčného súhlasu môže lokálne v prehliadači uložiť najviac 50
                    zobrazených výsledkov; formulárové vstupy ani identifikátory pacienta
                    sa do tejto histórie neukladajú a záznamy sa neodosielajú na server.
                </p>

                <!-- 3. ÚČELY A PRÁVNE ZÁKLADY -->
                <h3>3. Prečo údaje používame a naše právne základy</h3>
                <p>
                    Pre používateľov v EHP, Švajčiarsku a Spojenom kráľovstve sa opierame
                    o nasledujúce právne základy (GDPR / UK GDPR / zákon č. 18/2018 Z. z.):
                </p>
                <div class="admin-table-wrap legal-table-wrap">
                    <table class="admin-table legal-table">
                        <thead>
                            <tr>
                                <th scope="col">Účel</th>
                                <th scope="col">Právny základ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (legalProcessingPurposes() as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['purpose'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($row['basis'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- 4. ZDIEĽANIE ÚDAJOV -->
                <h3>4. Ako údaje zdieľame</h3>
                <p>
                    <strong>Vaše osobné údaje nepredávame za peniaze.</strong>
                    Údaje zdieľame len s príjemcami, ktorých potrebujeme na prevádzku služby,
                    ak to vyžaduje zákon alebo pri prevode podniku.
                </p>
                <p>
                    Nie každý príjemca má rovnaké postavenie, preto ho v tabuľke uvádzame:
                </p>
                <ul>
                    <li><strong>Sprostredkovateľ</strong> spracúva údaje výlučne podľa našich
                        pokynov a na základe zmluvy o spracúvaní podľa čl. 28 GDPR.</li>
                    <li><strong>Samostatný prevádzkovateľ</strong> určuje vlastné účely —
                        pri platobných službách je to vykonanie platby, prevencia podvodov
                        a povinnosti podľa predpisov o platobných službách a proti legalizácii
                        príjmov z trestnej činnosti. Nad týmto spracúvaním nemáme zmluvnú
                        kontrolu a riadi sa zásadami príslušnej služby.</li>
                    <li>Pri časti platobných kanálov <strong>neprenášame nič</strong> —
                        zobrazíme len odkaz alebo číslo účtu a spojenie vytvorí váš prehliadač
                        či aplikácia. Uvádzame ich pre úplnosť.</li>
                </ul>
                <div class="admin-table-wrap legal-table-wrap">
                    <table class="admin-table legal-table">
                        <thead>
                            <tr>
                                <th scope="col">Poskytovateľ</th>
                                <th scope="col">Rola</th>
                                <th scope="col">Účel</th>
                                <th scope="col">Prenos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (legalSubprocessors() as $row): ?>
                                <tr>
                                    <th scope="row"><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></th>
                                    <td><?= htmlspecialchars($row['role'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($row['purpose'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($row['transfer'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- 5. MEDZINÁRODNÉ PRENOSY -->
                <h3>5. Medzinárodné prenosy</h3>
                <p>
                    Niektorí poskytovatelia sídlia mimo vašej krajiny. Pri prenose údajov do
                    tretích krajín sa opierame o vhodné záruky podľa čl. 46 GDPR — najmä
                    štandardné zmluvné doložky EÚ (SCC), prípadne rámec EU-US Data Privacy
                    Framework tam, kde sa uplatňuje. Do USA sa — iba po udelení vášho súhlasu —
                    prenášajú analytické údaje v Google Analytics 4. Ak si overujete telefónne
                    číslo, vaše číslo sa prenáša spoločnosti Twilio Inc. (USA), ktorá odosiela
                    overovací SMS kód; tento prenos je krytý štandardnými zmluvnými doložkami (SCC).
                    Webové písmo (Inter) je hostované priamo na našom serveri, takže pri jeho
                    načítaní sa žiadne údaje do tretích krajín neprenášajú.
                </p>
                <p>
                    <strong>Pri platbe za publikáciu</strong> sú naši zmluvní partneri v Európskej
                    únii — Stripe Payments Europe (Írsko) a PayPal (Europe) v Luxembursku. Ak
                    tieto služby posielajú údaje ďalej v rámci svojej skupiny do USA, robia tak
                    na základe vlastných záruk (štandardné zmluvné doložky, prípadne rámec
                    EU-US Data Privacy Framework) a ako samostatní prevádzkovatelia. Pri Ko-fi
                    a Uphold ide o Spojené kráľovstvo, na ktoré sa vzťahuje rozhodnutie Komisie
                    o primeranosti; týmto službám navyše sami neposielame žiadny údaj.
                    Bankový prevod, Viamo ani payme.sk neznamenajú prenos mimo EÚ.
                </p>

                <!-- 6. DOBA UCHOVÁVANIA -->
                <h3>6. Ako dlho údaje uchovávame</h3>
                <ul>
                    <li><strong>Používateľské kontá:</strong> po dobu aktívneho používania; na žiadosť možné okamžité vymazanie.</li>
                    <li><strong>Výsledky kalkulačiek uložené v konte:</strong> kým ich používateľ nevymaže alebo nepožiada o zmazanie konta.</li>
                    <li><strong>Lokálna história kalkulačiek pre neprihlásených:</strong> najviac 50 výsledkov v prehliadači, kým ich používateľ nevymaže, neodvolá preferenčný súhlas alebo nevymaže údaje stránky.</li>
                    <li><strong>Server logy:</strong> maximálne 90 dní, potom automaticky mazané.</li>
                    <li><strong>Minimalizovaný audit zrušenia účtu:</strong> maximálne 90 dní; neobsahuje používateľské meno a slúži na bezpečnostnú kontrolu a preukázanie vykonania žiadosti.</li>
                    <li><strong>Bezpečnostné záznamy (pokusy o prihlásenie, rate-limiting):</strong> priebežne mazané po uplynutí ich účelu.</li>
                    <li><strong>GA4 dáta:</strong> používateľské a udalostné údaje viazané na pseudonymný identifikátor sa v Google Analytics uchovávajú najviac 14 mesiacov.</li>
                    <li><strong>Cookie súhlas:</strong> 365 dní (po uplynutí sa banner znova zobrazí).</li>
                </ul>

                <p>
                    <strong>Objednávky publikácií</strong> majú zámerne rôzne doby — jednotná
                    desaťročná lehota by znamenala, že držíme aj to, čo už nemá účel. Mazanie
                    a anonymizáciu vykonáva automatický cron, nie až reakcia na žiadosť:
                </p>
                <ul>
                    <li><strong>Zaplatená objednávka ako účtovný doklad</strong> (e-mail,
                        fakturačné údaje, suma, variabilný symbol, dátumy): 10 rokov podľa
                        § 35 zákona č. 431/2002 Z. z. o účtovníctve.</li>
                    <li><strong>Neuhradená alebo zrušená objednávka:</strong> 90 dní, potom sa
                        maže celá — účtovný záznam z nej nevznikol.</li>
                    <li><strong>IP adresa a prehliadač z objednávkového formulára:</strong>
                        90 dní. Potom sa z objednávky odstránia, zvyšok záznamu zostáva.</li>
                    <li><strong>Doklad o súhlasoch</strong> (čas potvrdenia podmienok, čas
                        žiadosti o okamžité dodanie a verzia podmienok): spolu so zaplatenou
                        objednávkou, pretože práve on preukazuje, že právo na odstúpenie
                        zaniklo oprávnene.</li>
                    <li><strong>Prístup na stiahnutie:</strong> 2 roky od potvrdenia platby.
                        Do 30 dní po uplynutí sa prístupový token znehodnotí a odkaz z e-mailu
                        prestane fungovať.</li>
                    <li><strong>Podrobnosti o stiahnutiach</strong> (čas a formát posledného
                        stiahnutia): 4 roky od úhrady. Potom zostáva len počet stiahnutí ako
                        minimalizovaný doklad o dodaní.</li>
                </ul>

                <!-- 7. BEZPEČNOSŤ -->
                <h3>7. Ako údaje chránime</h3>
                <p>
                    Heslá sú hašované algoritmom bcrypt, prenos je šifrovaný cez TLS (HTTPS, HSTS),
                    formuláre chránia CSRF tokeny, databázové dopyty sú parametrizované (PDO),
                    uplatňujeme striktné bezpečnostné hlavičky (CSP, X-Frame-Options),
                    rate-limiting a overenie e-mailovej adresy pri registrácii. Žiadny spôsob
                    prenosu ani uchovávania nie je 100 % bezpečný, no robíme všetko pre ochranu
                    vašich údajov a v prípade incidentu vás upozorníme tam, kde to vyžaduje zákon.
                </p>

                <!-- 8. PRÁVA PODĽA REGIÓNU -->
                <h3>8. Vaše práva podľa regiónu</h3>
                <div class="legal-regions">
                    <?php foreach (legalRightsRegions() as $region): ?>
                        <div class="legal-region-card">
                            <p class="legal-region-card__region"><?= htmlspecialchars($region['region'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="legal-region-card__law"><?= htmlspecialchars($region['law'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="legal-region-card__rights"><?= htmlspecialchars($region['rights'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p>
                    Pre uplatnenie ktoréhokoľvek práva nás kontaktujte na
                    <a href="mailto:<?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?></a>.
                    Väčšinu úprav (oprava údajov, zmena súhlasu) zvládnete priamo vo svojom
                    profile a v nastaveniach cookies.
                </p>

                <!-- 9. AUTOMATIZOVANÉ ROZHODOVANIE -->
                <h3>9. Automatizované rozhodovanie a profilovanie</h3>
                <p>
                    Služba nevykonáva rozhodnutia založené výlučne na automatizovanom spracúvaní,
                    ktoré by mali voči vám právne účinky alebo vás podobne významne ovplyvňovali,
                    ani nevytvára marketingové či zdravotné profily používateľov. Klinické kalkulačky
                    poskytujú iba podporný informatívny výpočet; neurčujú diagnózu ani liečbu a ich
                    výsledok musí vždy posúdiť zdravotnícky pracovník.
                </p>

                <!-- 10. DETI -->
                <h3>10. Deti</h3>
                <p>
                    Služba nie je určená osobám mladším ako 16 rokov; ak vaše miestne právo
                    vyžaduje vyšší minimálny vek, platí tento vyšší vek. Údaje mladších osôb
                    vedome nezhromažďujeme. Ak sa domnievate, že nám
                    dieťa poskytlo údaje, kontaktujte nás na
                    <a href="mailto:<?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?></a>.
                </p>

                <!-- 11. COOKIES -->
                <h3>11. Cookies a podobné technológie</h3>
                <p>
                    Predvolene používame iba nevyhnutné úložisko; voliteľné cookies nastavujeme
                    len s vaším súhlasom. Podrobnosti a správu volieb nájdete v našej
                    <a href="/cookies">Cookie Policy</a>. Súhlas môžete kedykoľvek zmeniť:
                </p>
                <button class="cookie-settings-trigger btn-outline btn-outline--mt"
                        type="button"
                        aria-haspopup="dialog"
                        aria-controls="cookieConsentModal">
                    Otvoriť nastavenia cookies
                </button>

                <!-- 12. ZMENY -->
                <h3>12. Zmeny týchto Zásad</h3>
                <p>
                    Tieto Zásady môžeme aktualizovať. Podstatné zmeny zvýrazníme v sekcii
                    „Súhrn posledných zmien“ vyššie a zmení sa dátum poslednej aktualizácie.
                    Náš systém správy cookies uchováva verziu platného súhlasu — pri každej
                    podstatnej zmene sa verzia aktualizuje a všetkým návštevníkom sa znova
                    zobrazí banner na potvrdenie nových podmienok (v súlade s čl. 7 ods. 3 GDPR).
                </p>

                <!-- 13. KONTAKT -->
                <h3>13. Kontakt</h3>
                <p>
                    Ochrana súkromia:
                    <a href="mailto:<?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?></a>
                    · Pozrite si aj naše <a href="/terms">Podmienky používania</a> a
                    <a href="/cookies">Cookie Policy</a>.
                </p>

                <?php $legalCurrent = 'privacy'; include 'legal_related.php'; ?>
            </article>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
