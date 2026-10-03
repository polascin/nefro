<?php

declare(strict_types=1);
/**
 * obchodne-podmienky.php — Obchodné podmienky predaja publikácií
 * ────────────────────────────────────────────────────────────────────────────
 * Samostatný dokument, zámerne oddelený od terms.php. Podmienky používania
 * upravujú prístup k webu a kontu; tu ide o kúpnu zmluvu na digitálny obsah
 * uzatváranú na diaľku, ktorá má vlastné povinné informácie (identifikácia
 * predávajúceho, cena, dodanie, odstúpenie od zmluvy, reklamácie, ADR).
 * Vďaka tomu sa pri zmene cenníka nemusí prečíslovať verzia Podmienok
 * používania ani rozosielať oznámenie o zmene právnych dokumentov.
 */

require_once __DIR__ . '/legal_data.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/publications_common.php';

$info   = legalInfo();
$seller = publicationSeller();
$bank   = publicationBankAccount();

/** Dátum účinnosti týchto obchodných podmienok (nezávislý od verzie legalInfo). */
const PUBLICATION_TERMS_EFFECTIVE_DATE = '2026-10-03';
const PUBLICATION_TERMS_VERSION = '1.0';

$pageLastUpdated = formatUserDateTime(PUBLICATION_TERMS_EFFECTIVE_DATE, 'd.m.Y');

$legalTitle       = 'Obchodné podmienky predaja publikácií';
$legalDescription = 'Obchodné podmienky predaja elektronických publikácií (e-knihy) na portáli '
    . 'Nefro-projekt Slovensko — cena, platba, dodanie digitálneho obsahu, odstúpenie '
    . 'od zmluvy, reklamácie a licencia na použitie.';
$legalSlug        = 'obchodne-podmienky.php';
$legalHeaderTitle = 'Obchodné podmienky predaja publikácií';
$legalHeaderIntro = 'Elektronické publikácie (e-knihy)';

include 'legal_head.php';
?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <article class="primary-article legal-article">
                <header>
                    <h2>Obchodné podmienky predaja publikácií</h2>
                    <p class="meta">
                        <?= htmlspecialchars($seller['name'], ENT_QUOTES, 'UTF-8') ?>
                        · Verzia <?= htmlspecialchars(PUBLICATION_TERMS_VERSION, ENT_QUOTES, 'UTF-8') ?>
                        · Účinné od&nbsp;
                        <time datetime="<?= htmlspecialchars(PUBLICATION_TERMS_EFFECTIVE_DATE, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($pageLastUpdated, ENT_QUOTES, 'UTF-8') ?></time>
                    </p>
                    <p>
                        Tieto obchodné podmienky upravujú predaj elektronických publikácií
                        (e-knihy, ďalej len „publikácia“) prostredníctvom stránky
                        <a href="publikacie.php">Publikácie</a> na webovej lokalite
                        <code><?= htmlspecialchars($info['url'], ENT_QUOTES, 'UTF-8') ?></code>.
                        Na ostatné používanie lokality sa vzťahujú
                        <a href="/terms">Podmienky používania</a>; spracúvanie osobných údajov
                        popisujú <a href="/privacy">Zásady ochrany osobných údajov</a>.
                    </p>
                </header>

                <section class="legal-callout" aria-labelledby="pub-terms-disclaimer-heading">
                    <h3 id="pub-terms-disclaimer-heading">Dôležité zdravotnícke upozornenie</h3>
                    <p>
                        Publikácie majú <strong>informačný a vzdelávací charakter</strong> a sú
                        určené zdravotníckym pracovníkom a informovaným pacientom.
                        <strong>Nenahrádzajú odborný lekársky úsudok, vyšetrenie, diagnózu
                        ani liečbu.</strong> Dávkovanie liekov, indikácie a klinické odporúčania
                        si vždy overte v aktuálnom primárnom zdroji. Obsah zachytáva stav poznania
                        v čase vydania a neskôr sa nemusí aktualizovať.
                    </p>
                </section>

                <h3>1. Predávajúci</h3>
                <p>
                    Publikácie predáva <strong><?= htmlspecialchars($seller['name'], ENT_QUOTES, 'UTF-8') ?></strong>,
                    IČO <?= htmlspecialchars($seller['companyId'], ENT_QUOTES, 'UTF-8') ?>,
                    DIČ <?= htmlspecialchars($seller['taxId'], ENT_QUOTES, 'UTF-8') ?>,
                    s miestom podnikania
                    <?= htmlspecialchars($seller['address'], ENT_QUOTES, 'UTF-8') ?>,
                    <?= htmlspecialchars($seller['establishment'], ENT_QUOTES, 'UTF-8') ?>
                    (ďalej len „predávajúci“).
                </p>
                <p>
                    Kontakt pre objednávky, otázky, reklamácie aj odstúpenie od zmluvy:
                    <a href="mailto:<?= htmlspecialchars($seller['email'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($seller['email'], ENT_QUOTES, 'UTF-8') ?></a>.
                    Komunikácia prebieha v slovenčine.
                </p>
                <p>
                    <strong><?= htmlspecialchars($seller['vatNote'], ENT_QUOTES, 'UTF-8') ?></strong>
                    K uvedenej cene sa teda nepripočítava daň z pridanej hodnoty.
                </p>

                <h3>2. Predmet predaja</h3>
                <p>
                    Predmetom predaja je <strong>digitálny obsah</strong> — elektronická
                    publikácia dodávaná v súboroch bez technických prostriedkov ochrany
                    (bez DRM). Na stránke každej publikácie je uvedený jej názov, vydanie,
                    rozsah, dostupné formáty a veľkosti súborov.
                </p>
                <p>
                    Publikácie zostavujú obsah, ktorý je na portáli dostupný bezplatne. Ich
                    pridanou hodnotou je zoradenie, jazyková korektúra, zjednotenie terminológie,
                    obsah s vnútornými odkazmi a možnosť čítať celok offline alebo v tlači.
                    Kúpa publikácie nie je podmienkou prístupu k obsahu portálu —
                    ten zostáva voľne dostupný bez platobnej steny.
                </p>
                <p>
                    <strong>Technické požiadavky.</strong> PDF otvorí akýkoľvek prehliadač PDF.
                    EPUB vyžaduje čítačku alebo aplikáciu na čítanie elektronických kníh,
                    AZW3 čítačku Amazon Kindle, DOCX program Microsoft Word alebo kompatibilný
                    a ODT program LibreOffice či OpenOffice. Pre prístup k súborom je potrebné
                    internetové pripojenie a funkčná e-mailová adresa.
                </p>

                <h3>3. Cena</h3>
                <p>
                    Cena jedného formátu publikácie je
                    <strong><?= htmlspecialchars(formatPublicationPrice(PUBLICATION_PRICE_SINGLE), ENT_QUOTES, 'UTF-8') ?></strong>.
                    Pri výbere dvoch a viac formátov sa uplatní balíková cena
                    <strong><?= htmlspecialchars(formatPublicationPrice(PUBLICATION_PRICE_BUNDLE), ENT_QUOTES, 'UTF-8') ?></strong>
                    za všetky vybrané formáty. Ceny sú konečné a vrátane všetkých daní;
                    k cene sa neúčtuje poštovné ani iné náklady na dodanie, keďže obsah
                    sa dodáva elektronicky.
                </p>
                <p>
                    Cena je uvedená v eurách (EUR). Pri platbe zo zahraničia môže vaša banka
                    účtovať vlastné poplatky za prevod — tie nie sú súčasťou ceny publikácie
                    a nesie ich kupujúci.
                </p>

                <h3>4. Objednávka a uzatvorenie zmluvy</h3>
                <p>
                    Objednávku podáte vyplnením formulára na stránke publikácie. Povinným údajom
                    je e-mailová adresa — potrebujeme ju na doručenie platobných pokynov aj samotnej
                    publikácie. Registrácia na portáli sa nevyžaduje. Fakturačné údaje (meno, firma,
                    IČO, DIČ, adresa) sú voliteľné; vyplňte ich, ak potrebujete doklad na firmu.
                </p>
                <p>
                    Odoslaním formulára vzniká objednávka, ktorú predávajúci bezodkladne potvrdí
                    e-mailom s platobnými pokynmi vrátane variabilného symbolu. Pred odoslaním
                    objednávky máte možnosť skontrolovať a opraviť zadané údaje; údaje neskôr
                    opravíte odpoveďou na potvrdzovací e-mail.
                </p>
                <p>
                    <strong>Kúpna zmluva je uzatvorená pripísaním platby</strong> na účet
                    predávajúceho. Samotná objednávka vás k ničomu nezaväzuje — ak nezaplatíte,
                    nič sa nedeje a objednávka po
                    <?= (int) PUBLICATION_PAYMENT_DAYS ?> dňoch zanikne.
                </p>

                <h3>5. Platba</h3>
                <p>
                    Platí sa <strong>bankovým prevodom v eurách</strong> na účet predávajúceho:
                </p>
                <div class="info-box-blue">
                    <dl class="donate-bank">
                        <dt>Príjemca</dt>
                        <dd><?= htmlspecialchars($bank['recipient'], ENT_QUOTES, 'UTF-8') ?></dd>
                        <dt>IBAN</dt>
                        <dd><code><?= htmlspecialchars($bank['iban_pretty'], ENT_QUOTES, 'UTF-8') ?></code></dd>
                        <dt>SWIFT / BIC</dt>
                        <dd><code><?= htmlspecialchars($bank['swift'], ENT_QUOTES, 'UTF-8') ?></code></dd>
                        <dt>Banka</dt>
                        <dd><?= htmlspecialchars($bank['bank_name'], ENT_QUOTES, 'UTF-8') ?>,
                            <?= htmlspecialchars($bank['bank_address'], ENT_QUOTES, 'UTF-8') ?></dd>
                        <dt>Kód krajiny</dt>
                        <dd><?= htmlspecialchars($bank['country'], ENT_QUOTES, 'UTF-8') ?></dd>
                    </dl>
                </div>
                <p>
                    <strong>Variabilný symbol je povinný</strong> — bez neho predávajúci nedokáže
                    platbu priradiť k objednávke. Dostanete ho v e-maile s platobnými pokynmi
                    a nájdete ho aj na stránke objednávky spolu s QR kódom, ktorý predvyplní
                    platbu v aplikácii vašej banky.
                </p>
                <p>
                    <strong>Na tomto portáli sa nespracúvajú platobné údaje.</strong> Platbu
                    vykonávate výhradne vo svojej banke; predávajúci nezískava čísla platobných
                    kariet ani prihlasovacie údaje do internetbankingu.
                </p>

                <h3>6. Dodanie digitálneho obsahu</h3>
                <p>
                    Po pripísaní platby a jej spárovaní podľa variabilného symbolu — zvyčajne
                    do jedného pracovného dňa — predávajúci odošle publikáciu na e-mailovú
                    adresu z objednávky. Súbory, ktoré sa zmestia do limitu veľkosti prílohy
                    poštového servera, prídu <strong>priamo v prílohe e-mailu</strong>;
                    objemnejšie súbory sprístupní predávajúci na <strong>stránke objednávky</strong>,
                    ktorej odkaz máte v e-maile. Táto stránka slúži na stiahnutie aj vtedy,
                    ak sa príloha v pošte stratí.
                </p>
                <p>
                    Prístup na stiahnutie je platný
                    <?= (int) round(PUBLICATION_ACCESS_DAYS / 365) ?> roky od potvrdenia platby,
                    s limitom <?= (int) PUBLICATION_DOWNLOAD_MAX ?> stiahnutí. Ak prístup
                    vyprší, limit vyčerpáte alebo odkaz stratíte, napíšte predávajúcemu
                    s variabilným symbolom a prístup bude obnovený bez ďalšej platby.
                </p>
                <p>
                    Ak publikácia nedorazí do troch pracovných dní od úhrady, skontrolujte prosím
                    aj priečinok nevyžiadanej pošty (e-mail s prílohou desiatok megabajtov
                    niektoré filtre odkladajú) a potom nás kontaktujte.
                </p>

                <h3>7. Licencia na použitie</h3>
                <p>
                    Kúpou získavate <strong>nevýhradné, neprenosné právo používať publikáciu
                    na vlastné osobné, študijné a profesijné účely</strong>, a to na
                    neobmedzený čas a na akomkoľvek počte vlastných zariadení. Súbory môžete
                    tlačiť pre svoju potrebu a vytvárať si z nich výpisky a poznámky.
                </p>
                <p>
                    Bez písomného súhlasu predávajúceho nie je dovolené publikáciu ani jej časti
                    ďalej rozširovať, sprístupňovať verejnosti, zdieľať v súborových službách,
                    ďalej predávať, prenajímať ani používať na čerpanie údajov (text and data
                    mining) či trénovanie modelov umelej inteligencie. Výhrada práv na čerpanie
                    údajov podľa čl. 4 ods. 3 smernice (EÚ) 2019/790 a § 51c autorského zákona
                    sa vzťahuje aj na publikácie. Súbory neobsahujú DRM — prosíme preto
                    o korektnosť: výnos z publikácií drží zvyšok portálu voľne dostupný
                    bez platobnej steny a bez reklám.
                </p>
                <p>
                    Citovanie v rozsahu zvyklostí (s uvedením názvu publikácie a autora) je
                    v súlade s autorským zákonom dovolené a vítané.
                </p>

                <h3>8. Odstúpenie od zmluvy</h3>
                <p>
                    Ak ste <strong>spotrebiteľ</strong>, máte pri zmluvách uzatvorených na diaľku
                    právo odstúpiť od zmluvy do <strong>14 dní</strong> bez uvedenia dôvodu.
                </p>
                <div class="info-box-yellow">
                    <p>
                        <strong>Pri digitálnom obsahu toto právo zaniká</strong> jeho dodaním,
                        ak ste výslovne požiadali o dodanie pred uplynutím 14-dňovej lehoty
                        a boli ste poučení, že tým právo na odstúpenie stratíte. Práve tento
                        súhlas udeľujete zaškrtnutím príslušného políčka v objednávkovom
                        formulári — bez neho by vám predávajúci nemohol sprístupniť súbory
                        hneď po platbe.
                    </p>
                </div>
                <p>
                    Ak ste súhlas s okamžitým dodaním neudelili alebo vám publikácia ešte nebola
                    sprístupnená, odstúpenie oznámte e-mailom na
                    <a href="mailto:<?= htmlspecialchars($seller['email'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($seller['email'], ENT_QUOTES, 'UTF-8') ?></a>
                    s uvedením variabilného symbolu. Postačuje jednoznačne formulované vyhlásenie;
                    formulár nie je povinný. Zaplatenú sumu vám predávajúci vráti na účet,
                    z ktorého platba prišla, najneskôr do 14 dní od doručenia oznámenia.
                </p>
                <p>
                    Ak ste nakupovali <strong>ako podnikateľ</strong> (uviedli ste IČO),
                    právo na odstúpenie od zmluvy podľa spotrebiteľských predpisov sa na vás
                    nevzťahuje.
                </p>

                <h3>9. Reklamácie a vady digitálneho obsahu</h3>
                <p>
                    Predávajúci zodpovedá za to, že dodaný digitálny obsah zodpovedá opisu
                    na stránke publikácie — formáty, rozsah a obsah. Ak je súbor poškodený,
                    neúplný, nedá sa otvoriť alebo nezodpovedá opisu, oznámte to e-mailom
                    na <a href="mailto:<?= htmlspecialchars($seller['email'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($seller['email'], ENT_QUOTES, 'UTF-8') ?></a>
                    s uvedením variabilného symbolu a popisom problému.
                </p>
                <p>
                    Reklamáciu predávajúci vybaví bezodkladne, najneskôr do 30 dní od jej
                    uplatnenia. Prednostným riešením je dodanie bezchybného súboru alebo iného
                    formátu; ak to nie je možné, vráti predávajúci zaplatenú sumu.
                    Predávajúci nezodpovedá za to, že súbor nepodporuje vaše konkrétne
                    zariadenie alebo aplikácia — formát si prosím vyberte podľa opisu
                    na stránke publikácie, a ak si nie ste istí, napíšte nám pred nákupom.
                </p>
                <p>
                    Predávajúci nezodpovedá za rozhodnutia prijaté na základe obsahu publikácie;
                    platí zdravotnícke upozornenie vyššie.
                </p>

                <h3>10. Alternatívne riešenie sporov</h3>
                <p>
                    Ak nie ste s vybavením reklamácie spokojní alebo sa domnievate, že predávajúci
                    porušil vaše práva, môžete sa naň najprv obrátiť so žiadosťou o nápravu
                    (e-mailom). Ak na ňu predávajúci odpovie zamietavo alebo neodpovie do 30 dní,
                    máte ako spotrebiteľ právo podať <strong>návrh na alternatívne riešenie
                    sporu</strong> subjektu ADR podľa zákona č. 391/2015 Z. z. — napríklad
                    Slovenskej obchodnej inšpekcii
                    (<a href="https://www.soi.sk/" target="_blank" rel="noopener noreferrer">soi.sk</a>).
                    Zoznam subjektov ADR vedie Ministerstvo hospodárstva SR. Návrh možno podať
                    aj elektronicky. Využitie ADR nevylučuje obrátiť sa na súd.
                </p>
                <p>
                    Orgánom dozoru je
                    <strong><?= htmlspecialchars($seller['supervisoryAuthority'], ENT_QUOTES, 'UTF-8') ?></strong>
                    (<a href="<?= htmlspecialchars($seller['supervisoryAuthorityUrl'], ENT_QUOTES, 'UTF-8') ?>"
                        target="_blank" rel="noopener noreferrer">soi.sk</a>),
                    príslušný podľa miesta podnikania predávajúceho.
                </p>

                <h3>11. Osobné údaje</h3>
                <p>
                    Na vybavenie objednávky spracúva predávajúci e-mailovú adresu a voliteľne
                    vyplnené fakturačné údaje, ďalej variabilný symbol, sumu, vybrané formáty,
                    IP adresu a prehliadač pri podaní objednávky (ochrana pred zneužitím)
                    a záznam o stiahnutiach. Právnym základom je plnenie zmluvy
                    (čl. 6 ods. 1 písm. b GDPR), pri daňových a účtovných dokladoch plnenie
                    zákonnej povinnosti (čl. 6 ods. 1 písm. c GDPR) s obvyklou dobou uchovávania
                    10 rokov.
                </p>
                <p>
                    Objednávka <strong>neznamená prihlásenie na odber noviniek</strong> —
                    newsletter je samostatný a dobrovoľný. Podrobnosti vrátane vašich práv
                    nájdete v <a href="/privacy">Zásadách ochrany osobných údajov</a>.
                </p>

                <h3>12. Záverečné ustanovenia</h3>
                <p>
                    Zmluvný vzťah sa riadi právom
                    <?= htmlspecialchars($info['jurisdiction'], ENT_QUOTES, 'UTF-8') ?>.
                    Ak ste spotrebiteľ, nie sú tým dotknuté práva, ktoré vám priznáva právo
                    štátu vášho obvyklého pobytu.
                </p>
                <p>
                    Predávajúci môže tieto obchodné podmienky meniť; na už uzatvorenú zmluvu sa
                    vždy vzťahuje znenie platné v čase podania objednávky. Aktuálne znenie je
                    vždy na tejto stránke s uvedením verzie a dátumu účinnosti.
                </p>
                <p>
                    Zmluva sa uzatvára v slovenskom jazyku a predávajúci ju archivuje
                    v elektronickej podobe.
                </p>

                <div class="form-actions">
                    <a href="publikacie.php" class="btn-primary">Katalóg publikácií</a>
                    <a href="index.php" class="btn-secondary">Späť na úvod</a>
                </div>

                <?php $legalCurrent = 'obchodne-podmienky'; include 'legal_related.php'; ?>
            </article>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
