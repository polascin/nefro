<?php

declare(strict_types=1);

require_once __DIR__ . '/legal_data.php';

$info = legalInfo();
$pageLastUpdated = date('d.m.Y', strtotime($info['effectiveDate']));

$legalTitle       = 'Podmienky používania';
$legalDescription = 'Podmienky používania webovej lokality Nefro-projekt Slovensko — kontá, prijateľné používanie, zdravotnícky disclaimer, zodpovednosť a vaše spotrebiteľské práva.';
$legalSlug        = 'terms.php';
$legalHeaderTitle = 'Podmienky používania';
$legalHeaderIntro = 'User Agreement';

include 'legal_head.php';
?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <article class="primary-article legal-article">
                <header>
                    <h2>Podmienky používania</h2>
                    <p class="meta">
                        <?= htmlspecialchars($info['entity'], ENT_QUOTES, 'UTF-8') ?>
                        · Verzia <?= htmlspecialchars($info['version'], ENT_QUOTES, 'UTF-8') ?>
                        · Posledná aktualizácia:&nbsp;
                        <time datetime="<?= htmlspecialchars($info['effectiveDate'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($pageLastUpdated, ENT_QUOTES, 'UTF-8') ?></time>
                    </p>
                    <p>
                        Tieto Podmienky používania („Podmienky“) sú zmluvou medzi vami a
                        prevádzkovateľom webovej lokality <?= htmlspecialchars($info['entity'], ENT_QUOTES, 'UTF-8') ?>
                        a upravujú vaše používanie lokality <code><?= htmlspecialchars($info['url'], ENT_QUOTES, 'UTF-8') ?></code>
                        (ďalej len „Služba“). Vytvorením konta alebo používaním Služby súhlasíte
                        s týmito Podmienkami a s našimi <a href="privacy.php">Zásadami ochrany osobných údajov</a>.
                    </p>
                </header>

                <!-- ZDRAVOTNÍCKY DISCLAIMER -->
                <section class="legal-callout" aria-labelledby="medical-disclaimer-heading">
                    <h3 id="medical-disclaimer-heading">Dôležité zdravotnícke upozornenie</h3>
                    <p>
                        Obsah, kalkulačky, interaktívne nástroje, databáza liekov a register
                        klinických štúdií na tejto Službe slúžia výhradne na
                        <strong>informačné a vzdelávacie účely a ako podporný nástroj</strong> pre
                        zdravotníckych pracovníkov a informovaných pacientov.
                        <strong>Nenahrádzajú odborný lekársky úsudok, vyšetrenie, diagnózu ani liečbu.</strong>
                        Výsledky výpočtov sú orientačné a každé klinické rozhodnutie musí
                        posúdiť kvalifikovaný zdravotnícky pracovník so znalosťou konkrétneho
                        pacienta. V naliehavých prípadoch kontaktujte tiesňovú linku alebo
                        svojho lekára.
                    </p>
                </section>

                <!-- 1. S KÝM UZATVÁRATE ZMLUVU -->
                <h3>1. S kým uzatvárate zmluvu</h3>
                <p>
                    Službu poskytuje <strong><?= htmlspecialchars($info['operator'], ENT_QUOTES, 'UTF-8') ?></strong>
                    (IČO <?= htmlspecialchars($info['companyId'], ENT_QUOTES, 'UTF-8') ?>),
                    so sídlom v <?= htmlspecialchars($info['establishment'], ENT_QUOTES, 'UTF-8') ?>.
                    Ak sa poskytujúca osoba zmení, túto sekciu aktualizujeme a upozorníme vás.
                </p>

                <!-- 2. SPÔSOBILOSŤ -->
                <h3>2. Spôsobilosť</h3>
                <p>
                    Musíte mať aspoň 16 rokov (alebo minimálny vek digitálneho súhlasu vo vašej
                    krajine) a byť spôsobilí uzavrieť záväznú zmluvu. Ak Službu používate za
                    organizáciu, potvrdzujete, že ste oprávnení ju zaviazať.
                </p>

                <!-- 3. ČO SLUŽBA JE (A ČO NIE) -->
                <h3>3. Čo Služba je (a čo nie je)</h3>
                <p>
                    <?= htmlspecialchars($info['entity'], ENT_QUOTES, 'UTF-8') ?> je odborný
                    portál o nefrológii, dialýze a internej medicíne. Poskytuje články,
                    medicínske kalkulačky a interaktívne nástroje, informačnú databázu liekov
                    a register klinických štúdií, ako aj diskusiu pre prihlásených používateľov. Služba
                    <strong>nie je poskytovateľom zdravotnej starostlivosti</strong> a
                    neposkytuje individuálne lekárske poradenstvo. Obsah môže byť neúplný alebo
                    sa môže časom meniť; nezaručujeme jeho bezchybnosť ani vhodnosť pre
                    konkrétny prípad (pozri zdravotnícke upozornenie vyššie).
                </p>

                <!-- 4. VAŠE KONTO -->
                <h3>4. Vaše konto</h3>
                <p>
                    Svoje prihlasovacie údaje uchovávajte v tajnosti a profilové údaje
                    aktuálne; za aktivitu pod vaším kontom zodpovedáte vy. O akomkoľvek
                    neoprávnenom použití nás bezodkladne informujte na
                    <a href="mailto:<?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?></a>.
                    Kontá, ktoré porušujú tieto Podmienky alebo predstavujú bezpečnostné
                    riziko, môžeme pozastaviť.
                </p>

                <!-- 5. PRIJATEĽNÉ POUŽÍVANIE -->
                <h3>5. Prijateľné používanie</h3>
                <p>Zaväzujete sa, že nebudete:</p>
                <ul>
                    <li>preťažovať, skenovať ani narúšať Službu, jej rozhrania či bezpečnostné prvky;</li>
                    <li>obchádzať zabezpečenie, rate-limity alebo prístupové kontroly;</li>
                    <li>používať Službu nezákonne ani na zásah do práv iných;</li>
                    <li>zneužívať klinické nástroje na účely, na ktoré nie sú určené;</li>
                    <li>zadávať osobné údaje pacientov bez náležitého právneho základu a poučenia;</li>
                    <li>predstierať cudziu totožnosť alebo rozosielať spam cez naše funkcie.</li>
                </ul>

                <!-- 6. OBSAH POUŽÍVATEĽA -->
                <h3>6. Obsah používateľa (diskusia)</h3>
                <p>
                    Za príspevky, ktoré v diskusii alebo profile zverejníte, zodpovedáte vy a
                    musíte mať práva na ich zdieľanie. Nezverejňujte identifikovateľné údaje
                    pacientov. Obsah, ktorý porušuje zákon, tieto Podmienky alebo etické
                    pravidlá, môžeme upraviť alebo odstrániť. Zverejnením obsahu nám udeľujete
                    nevýhradnú licenciu na jeho zobrazenie v rámci Služby.
                </p>

                <!-- 7. DUŠEVNÉ VLASTNÍCTVO -->
                <h3>7. Duševné vlastníctvo</h3>
                <p>
                    Služba vrátane jej softvéru, dizajnu a značky
                    <?= htmlspecialchars($info['entity'], ENT_QUOTES, 'UTF-8') ?> je chránená
                    zákonom a patrí nám alebo našim poskytovateľom licencií. Udeľujeme vám
                    obmedzenú, odvolateľnú a nevýhradnú licenciu na používanie Služby na jej
                    zamýšľaný účel. Odborné zdroje a citácie patria ich príslušným autorom.
                </p>

                <!-- 8. TRETIE STRANY -->
                <h3>8. Služby tretích strán</h3>
                <p>
                    Služba sa opiera o tretie strany (napr. Google Analytics, hosting a SMTP
                    od WebSupport) a môže na ne odkazovať. Na vaše používanie týchto služieb sa
                    vzťahujú ich vlastné podmienky a zásady súkromia; za ich obsah
                    nezodpovedáme. Zoznam sprostredkovateľov nájdete v
                    <a href="privacy.php">Zásadách ochrany osobných údajov</a>.
                </p>

                <!-- 9. VYHLÁSENIA -->
                <h3>9. Vyhlásenia (Disclaimers)</h3>
                <p>
                    Služba sa poskytuje „tak, ako je“ a „ako je dostupná“. V rozsahu povolenom
                    zákonom odmietame záruky presnosti, dostupnosti a vhodnosti na konkrétny
                    účel, vrátane výsledkov kalkulačiek a odborného obsahu. Nič v týchto
                    Podmienkach nevylučuje zodpovednosť, ktorú nemožno zákonne vylúčiť.
                </p>

                <!-- 10. OBMEDZENIE ZODPOVEDNOSTI -->
                <h3>10. Obmedzenie zodpovednosti</h3>
                <p>
                    V rozsahu povolenom zákonom <?= htmlspecialchars($info['entity'], ENT_QUOTES, 'UTF-8') ?>
                    nezodpovedá za nepriame ani následné škody, ušlý zisk, ani za klinické
                    rozhodnutia urobené na základe obsahu či výsledkov kalkulačiek.
                    <strong>Toto neobmedzuje vaše záväzné spotrebiteľské práva</strong> ani
                    zodpovednosť za smrť, ujmu na zdraví, podvod či hrubú nedbanlivosť.
                </p>

                <!-- 11. UKONČENIE -->
                <h3>11. Ukončenie</h3>
                <p>
                    Službu môžete kedykoľvek prestať používať a svoje konto zmazať. Prístup
                    môžeme pozastaviť alebo ukončiť pri porušení Podmienok, zo zákonných
                    dôvodov alebo ak Službu ukončíme, s upozornením tam, kde to vyžaduje zákon.
                    Ustanovenia, ktoré majú zo svojej povahy pretrvať (napr. duševné
                    vlastníctvo, vyhlásenia, zodpovednosť), platia aj po ukončení.
                </p>

                <!-- 12. ROZHODNÉ PRÁVO A SPORY -->
                <h3>12. Rozhodné právo a spory</h3>
                <p>
                    Tieto Podmienky sa riadia právom <?= htmlspecialchars($info['jurisdiction'], ENT_QUOTES, 'UTF-8') ?>,
                    bez vplyvu na záväzné spotrebiteľské pravidlá vašej krajiny pobytu.
                    Spotrebitelia v EHP a UK môžu využiť aj príslušné mechanizmy online riešenia
                    sporov a podať žalobu na svojom miestnom súde.
                </p>

                <!-- 13. ZMENY PODMIENOK -->
                <h3>13. Zmeny týchto Podmienok</h3>
                <p>
                    Tieto Podmienky môžeme aktualizovať; novú verziu zverejníme s aktualizovaným
                    dátumom a pri podstatných zmenách vás upozorníme. Pokračovaním v používaní
                    po nadobudnutí účinnosti zmien ich prijímate.
                </p>

                <!-- 14. KONTAKT -->
                <h3>14. Kontakt</h3>
                <p>
                    Otázky k týmto Podmienkam:
                    <a href="mailto:<?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?></a>.
                </p>

                <?php $legalCurrent = 'terms.php'; include 'legal_related.php'; ?>
            </article>
        </div>
    </main>

    <?php include 'footer.php'; ?>
