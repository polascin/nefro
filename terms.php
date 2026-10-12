<?php

declare(strict_types=1);

require_once __DIR__ . '/legal_data.php';
require_once __DIR__ . '/auth.php';

$info = legalInfo();
$pageLastUpdated = formatUserDateTime($info['effectiveDate'], 'd.m.Y');
$pageTimeZone = getUserTimezoneAbbr() . ' (' . getUserTimezone() . ')';

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
                        s týmito Podmienkami a s našimi <a href="/privacy">Zásadami ochrany osobných údajov</a>.
                    </p>
                </header>

                <!-- ZDRAVOTNÍCKY DISCLAIMER -->
                <section class="legal-callout" aria-labelledby="medical-disclaimer-heading">
                    <h3 id="medical-disclaimer-heading">Dôležité zdravotnícke upozornenie</h3>
                    <p>
                        Obsah, kalkulačky, interaktívne nástroje, databáza liekov a register
                        klinických štúdií na tejto Službe slúžia výhradne na
                        <strong>informačné a vzdelávacie účely</strong>.
                        <strong>Nie sú určené na použitie lekárom pri starostlivosti o konkrétneho
                        pacienta ani na diagnostiku, monitorovanie zdravotného stavu alebo
                        rozhodovanie o liečbe.</strong> Nenahrádzajú odborný lekársky úsudok,
                        vyšetrenie, diagnózu, liečbu ani validovaný zdravotnícky softvér.
                        V naliehavých prípadoch kontaktujte tiesňovú linku alebo svojho lekára.
                    </p>
                </section>

                <!-- 1. S KÝM UZATVÁRATE ZMLUVU -->
                <h3>1. S kým uzatvárate zmluvu</h3>
                <p>
                    Službu poskytuje <strong><?= htmlspecialchars($info['operator'], ENT_QUOTES, 'UTF-8') ?></strong>
                    (IČO <?= htmlspecialchars($info['companyId'], ENT_QUOTES, 'UTF-8') ?>,
                    DIČ <?= htmlspecialchars($info['taxId'], ENT_QUOTES, 'UTF-8') ?>), s miestom podnikania
                    <?= htmlspecialchars($info['businessAddress'], ENT_QUOTES, 'UTF-8') ?>.
                    Zapísaný v <?= htmlspecialchars($info['registerName'], ENT_QUOTES, 'UTF-8') ?>,
                    registračný orgán <?= htmlspecialchars($info['registerNumber'], ENT_QUOTES, 'UTF-8') ?>.
                    Kontakt: <a href="mailto:<?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?></a>,
                    telefón <?= htmlspecialchars($info['phone'], ENT_QUOTES, 'UTF-8') ?>.
                    Ak sa poskytujúca osoba zmení, túto sekciu aktualizujeme a upozorníme vás.
                </p>

                <!-- 2. SPÔSOBILOSŤ -->
                <h3>2. Spôsobilosť</h3>
                <p>
                    Musíte mať aspoň 16 rokov; ak právo vašej krajiny vyžaduje vyšší minimálny
                    vek, musíte dosiahnuť tento vyšší vek. Zároveň musíte byť spôsobilí uzavrieť
                    záväznú zmluvu. Ak Službu používate za
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
                <p>
                    Do kalkulačiek ani uložených výsledkov nesmiete zadávať osobné alebo
                    zdravotné údaje inej osoby. Funkcia uloženia slúži iba na vaše vlastné
                    orientačné poznámky a nesmie sa používať ako zdravotná dokumentácia.
                </p>
                <p>
                    Obsah portálu zostáva <strong>voľne dostupný bez platobnej steny</strong>.
                    Samostatne predávame len <strong>elektronické publikácie (e-knihy)</strong>,
                    ktoré ten istý obsah zostavujú do jedného zväzku. Na ich kúpu sa vzťahujú
                    <a href="/obchodne-podmienky">Obchodné podmienky predaja publikácií</a> —
                    obsahujú identifikáciu predávajúceho, cenu, spôsoby platby, dodanie
                    digitálneho obsahu, odstúpenie od zmluvy, reklamácie a alternatívne
                    riešenie sporov. Tieto Podmienky používania upravujú prístup k portálu
                    a ku kontu, nie kúpnu zmluvu.
                </p>
                <p>
                    <strong>Prístupnosť:</strong> poskytovateľ má podľa stavu k 12. októbru 2026
                    jedného pracovníka, nulový obrat a zatiaľ nemá uzavretú prvú bilanciu.
                    Na základe týchto údajov sa predbežne považuje za mikropodnik poskytujúci
                    služby, na ktorý sa vzťahuje výnimka podľa zákona č. 351/2022 Z. z.
                    Bez ohľadu na výnimku portál dobrovoľne sleduje WCAG 2.1 AA. Status sa
                    prehodnotí po prvej účtovnej závierke a pri každej podstatnej zmene veľkosti.
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
                    <li>
                        hromadne sťahovať obsah Služby (scraping) ani ho používať na
                        trénovanie, doladenie či vyhodnocovanie modelov umelej
                        inteligencie — pozri výhradu práv v <a href="#tdm">bode 7.1</a>;
                    </li>
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

                <h4 id="tdm">7.1 Výhrada práv na čerpanie údajov (text a data mining)</h4>
                <p>
                    Prevádzkovateľ si <strong>výslovne vyhradzuje</strong> práva na čerpanie
                    údajov (text and data mining) zo všetkého obsahu tejto Služby v zmysle
                    § 51c autorského zákona č. 185/2015 Z. z. a čl. 4 ods. 3 smernice (EÚ)
                    2019/790 o autorskom práve na digitálnom jednotnom trhu. Uplatnenie
                    zákonnej výnimky pre čerpanie údajov je týmto vylúčené.
                </p>
                <p>
                    Táto výhrada sa vzťahuje najmä na <strong>trénovanie, dolaďovanie
                    a vyhodnocovanie modelov umelej inteligencie</strong> vrátane
                    generatívnych jazykových modelov, a to pre všetky formy obsahu —
                    články, klinické nástroje a kalkulačky, databázu liekov, obrázky, ako
                    aj PDF verzie článkov.
                </p>
                <p>
                    Výhrada je popri tomto texte deklarovaná aj strojovo čitateľne, aby
                    ju bolo možné zistiť automatizovane:
                </p>
                <ul>
                    <li>
                        súborom
                        <a href="/.well-known/tdmrep.json"><code>/.well-known/tdmrep.json</code></a>
                        podľa protokolu TDMRep (W3C Community Group);
                    </li>
                    <li>
                        HTTP hlavičkami <code>tdm-reservation: 1</code>,
                        <code>tdm-policy</code> a <code>Content-Usage: train-ai=n</code>
                        pri každej odpovedi servera;
                    </li>
                    <li>
                        značkami <code>&lt;meta name="tdm-reservation" content="1"&gt;</code>
                        a <code>noai, noimageai</code> v hlavičke každej stránky;
                    </li>
                    <li>
                        zákazom príslušných crawlerov v súbore
                        <a href="/robots.txt"><code>/robots.txt</code></a>.
                    </li>
                </ul>
                <p>
                    Podmienky, za ktorých možno získať súhlas s čerpaním údajov, sú uvedené
                    v strojovo čitateľnej politike
                    <a href="/tdm-policy.json"><code>/tdm-policy.json</code></a>.
                    O súhlas žiadajte na adrese
                    <a href="mailto:<?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?></a>.
                    Bez udeleného súhlasu je použitie obsahu na uvedené účely porušením
                    autorských práv.
                </p>
                <p>
                    Výhradou nie je dotknutá výnimka čerpania údajov na účely vedeckého
                    výskumu podľa § 51b autorského zákona, ktorú si zákon vyhradiť
                    neumožňuje a ktorá svedčí vymedzeným výskumným a pamäťovým inštitúciám.
                </p>

                <!-- 8. TRETIE STRANY -->
                <h3>8. Služby tretích strán</h3>
                <p>
                    Služba sa opiera o tretie strany (napr. Google Analytics, hosting a SMTP
                    od WebSupport, pri predaji publikácií platobné služby Stripe, PayPal
                    a ďalšie) a môže na ne odkazovať. Na vaše používanie týchto služieb sa
                    vzťahujú ich vlastné podmienky a zásady súkromia; za ich obsah
                    nezodpovedáme. Zoznam sprostredkovateľov nájdete v
                    <a href="/privacy">Zásadách ochrany osobných údajov</a>.
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

                <h3>11a. Oznámenie a moderovanie nezákonného obsahu</h3>
                <p>
                    Nezákonný obsah možno oznámiť cez <a href="content_report.php">elektronický
                    formulár</a>. Oznámenie musí obsahovať presnú URL, vysvetlenie nezákonnosti
                    a vyhlásenie o dobrej viere. Oznámenia posudzujeme včas, objektívne a bez
                    svojvôle. Pri obmedzení obsahu poskytneme dotknutému používateľovi jasné
                    odôvodnenie; ohlasovateľovi s uvedeným kontaktom oznámime výsledok a možnosti
                    nápravy. Kontaktné miesto podľa DSA je
                    <a href="mailto:<?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($info['contactEmail'], ENT_QUOTES, 'UTF-8') ?></a>.
                </p>

                <!-- 12. ROZHODNÉ PRÁVO A SPORY -->
                <h3>12. Rozhodné právo a spory</h3>
                <p>
                    Tieto Podmienky sa riadia právom <?= htmlspecialchars($info['jurisdiction'], ENT_QUOTES, 'UTF-8') ?>,
                    bez vplyvu na záväzné spotrebiteľské pravidlá vašej krajiny pobytu.
                    Spotrebiteľ sa môže po predchádzajúcej žiadosti o nápravu obrátiť na subjekt
                    alternatívneho riešenia spotrebiteľských sporov, najmä na Slovenskú obchodnú
                    inšpekciu. Európska platforma ODR bola 20. júla 2025 ukončená, preto na ňu
                    neodkazujeme. Aktuálne informácie a elektronické podanie sú dostupné na
                    <a href="https://www.soi.sk/sk/Alternativne-riesenie-spotrebitelskych-sporov.soi"
                       target="_blank" rel="noopener noreferrer">stránke SOI o alternatívnom riešení sporov</a>.
                    Tým nie je dotknuté právo obrátiť sa na príslušný súd.
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
                <p>
                    Orgán dozoru nad ochranou spotrebiteľa:
                    <strong><?= htmlspecialchars($info['consumerAuthority'], ENT_QUOTES, 'UTF-8') ?></strong>,
                    <?= htmlspecialchars($info['consumerAuthorityAddress'], ENT_QUOTES, 'UTF-8') ?>.
                </p>

                <?php $legalCurrent = 'terms'; include 'legal_related.php'; ?>
            </article>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
