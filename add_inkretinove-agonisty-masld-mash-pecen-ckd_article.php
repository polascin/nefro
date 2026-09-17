<?php

/**
 * add_inkretinove-agonisty-masld-mash-pecen-ckd_article.php
 * Odborne revidovane spracovanie clanku Via practica 2/2026 o semaglutide,
 * tirzepatide a retatrutide pri MASLD/MASH.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Inkretínové agonisty pri MASLD a MASH: ochrana pečene a význam pre nefrológa',
    'slug'         => 'inkretinove-agonisty-masld-mash-pecen-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Semaglutid, tirzepatid a retatrutid nemajú pri MASH rovnakú úroveň dôkazov ani registračné postavenie. Čo ukázali ESSENCE a SYNERGY-NASH a čo musí zohľadniť nefrológ?',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Semaglutid, tirzepatid a retatrutid predstavujú tri rozdielne receptorové stratégie. Nemožno ich však zoradiť podľa počtu cieľových receptorov ani podľa úbytku hmotnosti v navzájom odlišných štúdiách. Pre klinické rozhodnutie treba oddeliť zníženie obsahu tuku v pečeni, histologickú odpoveď, prevenciu pečeňových komplikácií a kardiorenálny prínos. Pri chronickej chorobe obličiek navyše rozhodujú hydratácia, glykémia, nutričný stav a presná indikácia konkrétneho lieku.</em></p>

<p>Východiskom tohto článku je prehľad Ľubomíra Horáka a Anny Šarockej publikovaný vo <em>Via practica</em> 2/2026. Jeho téma je aktuálna, ale niektoré údaje a závery si vyžadujú opravu alebo doplnenie. Odlišné úrovne dôkazov priniesli najmä štúdie ESSENCE so semaglutidom, SYNERGY-NASH s tirzepatidom a obrazová podštúdia retatrutidu. Zmenilo sa aj regulačné prostredie: v Európskej únii už existujú lieky osobitne povolené pre vymedzenú populáciu s MASH.</p>

<h2>MASLD nie je synonymom steatohepatitídy</h2>

<p>MASLD označuje <strong>steatotickú chorobu pečene spojenú s metabolickou dysfunkciou</strong> (<em>metabolic dysfunction-associated steatotic liver disease</em>). MASH je jej zápalový fenotyp — <strong>steatohepatitída spojená s metabolickou dysfunkciou</strong> (<em>metabolic dysfunction-associated steatohepatitis</em>) — charakterizovaný steatózou, zápalom a balónovým poškodením hepatocytov, s fibrózou alebo bez nej.</p>

<p>V anglickom abstrakte východiskového článku je skratka MASLD nesprávne rozpísaná ako steatohepatitída. Nejde o zanedbateľnú terminologickú chybu. Steatóza zistená ultrasonograficky automaticky nepotvrdzuje MASH a už vôbec neurčuje štádium fibrózy. Zároveň neplatí, že každý pacient s MASLD nevyhnutne progreduje do MASH.</p>

<p>Pri rozhodovaní o liečbe preto treba poznať klinický fenotyp, riziko fibrózy a prítomnosť diabetu, obezity, kardiovaskulárneho ochorenia a chronickej choroby obličiek (CKD). Samotné zvýšenie aminotransferáz ani prítomnosť steatózy nestačia na výber cielenej liečby MASH.</p>

<h2>Tri molekuly, tri rozdielne úrovne dôkazu</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie semaglutidu, tirzepatidu a retatrutidu pri MASLD a MASH" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Liečivo</th>
        <th scope="col">Receptorový profil</th>
        <th scope="col">Najrelevantnejší pečeňový dôkaz</th>
        <th scope="col">Stav v EÚ k 13. 9. 2026</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Semaglutid</th>
        <td>Agonista receptora GLP-1</td>
        <td>ESSENCE, fáza 3: histologická odpoveď pri MASH s fibrózou F2–F3</td>
        <td>Kayshild má podmienečné povolenie pre necirhotickú MASH s fibrózou F2–F3</td>
      </tr>
      <tr>
        <th scope="row">Tirzepatid</th>
        <td>Duálny agonista receptorov GIP a GLP-1</td>
        <td>SYNERGY-NASH, fáza 2: histologická odpoveď pri MASH s fibrózou F2–F3</td>
        <td>Mounjaro je povolené pre diabetes 2. typu a manažment hmotnosti, nie osobitne pre MASH</td>
      </tr>
      <tr>
        <th scope="row">Retatrutid</th>
        <td>Trojitý agonista receptorov GIP, GLP-1 a glukagónu</td>
        <td>Fáza 2a: výrazný pokles tuku v pečeni meraného MRI, bez histologického cieľa MASH</td>
        <td>Experimentálne liečivo bez povolenia na uvedenie na trh</td>
      </tr>
    </tbody>
  </table>
</div>

<p>GLP-1 a GIP sú inkretínové hormóny; glukagón inkretínom nie je. Retatrutid je preto presnejšie označovať ako trojitého receptorového agonistu kombinujúceho inkretínové a glukagónové pôsobenie. Viac aktivovaných receptorov automaticky neznamená väčší klinický prínos. Výsledok závisí od farmakologickej rovnováhy molekuly, dávky, populácie, tolerancie a zvoleného ukazovateľa.</p>

<h3>Mechanizmus nemôže nahradiť klinický výsledok</h3>

<p>Agonizmus GLP-1 podporuje glukózovo závislú sekréciu inzulínu, tlmí príjem potravy a spomaľuje vyprázdňovanie žalúdka. Pokles hmotnosti a zlepšenie glykemického a lipidového profilu môžu priaznivo ovplyvniť pečeň. Podľa európskeho regulačného hodnotenia sa receptor GLP-1 v pečeni neexprimuje a pečeňový účinok semaglutidu sa sprostredkúva najmä zlepšením metabolických faktorov. Nie je preto primerané vydávať každú experimentálnu zmenu signálnej dráhy za dokázaný priamy účinok na ľudský hepatocyt.</p>

<p>Glukagónový agonizmus nemožno zjednodušiť na „ďalšie zníženie glykémie“, pretože glukagón môže zvyšovať hepatálnu produkciu glukózy. A pojem „synergia“ vyjadruje viac než súčasné pôsobenie na dva receptory. Bez priamych farmakologických alebo klinických porovnaní nemožno výraznejší úbytok hmotnosti automaticky označiť za dôkaz synergického účinku.</p>

<h2>ESSENCE: semaglutid má dôkaz z fázy 3</h2>

<p>ESSENCE je prebiehajúca multicentrická, randomizovaná, dvojito zaslepená, placebom kontrolovaná štúdia fázy 3. Zaradila 1 197 pacientov s biopsiou potvrdenou MASH a fibrózou F2 alebo F3 v pomere 2 : 1 na semaglutid alebo placebo. Semaglutid sa podával <strong>subkutánne v dávke 2,4 mg raz týždenne</strong>. Celkové plánované trvanie liečby je 240 týždňov.</p>

<p>Publikovaná plánovaná priebežná analýza hodnotila prvých 800 pacientov po 72 týždňoch:</p>

<div class="table-responsive" role="region" aria-label="Histologické a metabolické výsledky štúdie ESSENCE po 72 týždňoch" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Semaglutid</th>
        <th scope="col">Placebo</th>
        <th scope="col">Odhadovaný rozdiel</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Ústup steatohepatitídy bez zhoršenia fibrózy</th>
        <td>62,9 %</td>
        <td>34,3 %</td>
        <td>28,7 percentuálneho bodu (95 % IS 21,1–36,2)</td>
      </tr>
      <tr>
        <th scope="row">Zlepšenie fibrózy bez zhoršenia steatohepatitídy</th>
        <td>36,8 %</td>
        <td>22,4 %</td>
        <td>14,4 percentuálneho bodu (95 % IS 7,5–21,3)</td>
      </tr>
      <tr>
        <th scope="row">Súčasný ústup steatohepatitídy a zlepšenie fibrózy</th>
        <td>32,7 %</td>
        <td>16,1 %</td>
        <td>16,5 percentuálneho bodu (95 % IS 10,2–22,8)</td>
      </tr>
      <tr>
        <th scope="row">Priemerná zmena telesnej hmotnosti</th>
        <td>−10,5 %</td>
        <td>−2,0 %</td>
        <td>−8,5 percentuálneho bodu (95 % IS −9,6 až −7,4)</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Všetky tri uvedené histologické porovnania aj zmena hmotnosti boli štatisticky významné (p &lt; 0,001). Hodnota 28,7 percentuálneho bodu je modelový odhad autorov, preto sa nemusí presne rovnať rozdielu zaokrúhlených percent 62,9 a 34,3.</p>

<p>ESSENCE preukázala histologický účinok v skúmanej populácii, nie zatiaľ prevenciu dekompenzácie, transplantácie alebo úmrtia. Na tieto klinické udalosti má odpovedať pokračovanie štúdie. Výsledok nemožno automaticky preniesť na cirhózu F4, pacientov s ťažkou poruchou funkcie obličiek alebo dialyzovaných pacientov.</p>

<p>Na základe týchto histologických výsledkov získal Kayshild (semaglutid) 26. marca 2026 podmienečné povolenie platné v celej EÚ ako doplnok diéty a pohybovej aktivity pre dospelých s necirhotickou MASH a fibrózou F2–F3. Podmienečné povolenie znamená, že dlhodobý klinický prínos sa musí ďalej potvrdiť; nejde o dôkaz zníženia mortality.</p>

<h2>SYNERGY-NASH: tirzepatid má priamy histologický dôkaz z fázy 2</h2>

<p>Tirzepatid nemožno pri MASH opisovať iba na základe štúdií diabetu a obezity. Randomizovaná, dvojito zaslepená štúdia fázy 2 SYNERGY-NASH zaradila 190 pacientov s biopsiou potvrdenou MASH a fibrózou F2 alebo F3. Účastníci dostávali 5, 10 alebo 15 mg tirzepatidu, alebo placebo, <strong>subkutánne raz týždenne počas 52 týždňov</strong>.</p>

<div class="table-responsive" role="region" aria-label="Histologické výsledky štúdie SYNERGY-NASH po 52 týždňoch" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Placebo</th>
        <th scope="col">Tirzepatid 5 mg</th>
        <th scope="col">Tirzepatid 10 mg</th>
        <th scope="col">Tirzepatid 15 mg</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Ústup MASH bez zhoršenia fibrózy</th>
        <td>10 %</td>
        <td>44 %</td>
        <td>56 %</td>
        <td>62 %</td>
      </tr>
      <tr>
        <th scope="row">Zlepšenie fibrózy najmenej o jeden stupeň bez zhoršenia MASH</th>
        <td>30 %</td>
        <td>55 %</td>
        <td>51 %</td>
        <td>51 %</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Primárny ukazovateľ — ústup MASH bez zhoršenia fibrózy — bol pri každej dávke lepší než pri placebe (p &lt; 0,001). Výsledok fibrózy je povzbudivý, ale odhady boli menej presné a neukazujú jednoduchú dávkovú závislosť. Biopsiu v 52. týždni bolo možné vyhodnotiť u 157 účastníkov; chýbajúce hodnoty sa imputovali podľa vopred určeného štatistického postupu. Štúdia bola krátka a malá na posúdenie klinických pečeňových udalostí.</p>

<p>V EÚ je tirzepatid ako Mounjaro povolený pre diabetes 2. typu a manažment hmotnosti. MASH medzi jeho schválenými indikáciami k 13. septembru 2026 nie je. Výsledky SYNERGY-NASH preto predstavujú dôkaz účinnosti fázy 2 a podklad pre ďalší výskum, nie samostatnú európsku indikáciu na liečbu MASH.</p>

<h2>Retatrutid: výrazný pokles tuku v pečeni, ale bez histológie MASH</h2>

<p>Retatrutid sa hodnotil v obrazovej podštúdii fázy 2a u 98 účastníkov štúdie obezity, ktorí mali MASLD a najmenej 10 % tuku v pečeni. Dostávali placebo alebo retatrutid 1, 4, 8 či 12 mg <strong>subkutánne raz týždenne</strong>. Primárnym cieľom bola relatívna zmena tuku v pečeni meraného magnetickou rezonanciou po 24 týždňoch.</p>

<p>Priemerná relatívna zmena pečeňového tuku bola −42,9 %, −57,0 %, −81,4 % a −82,4 % pri dávkach 1, 4, 8 a 12 mg oproti +0,3 % pri placebe; všetky porovnania s placebom mali p &lt; 0,001. Obsah pečeňového tuku pod 5 % dosiahlo 27 %, 52 %, 79 % a 86 % účastníkov oproti 0 % pri placebe.</p>

<p>Ide o silný obrazový signál, ale nie o biopsiou potvrdený ústup MASH ani zlepšenie fibrózy. Podštúdia bola malá, porovnania neboli upravené na mnohonásobné testovanie a počet dostupných MRI po 48 týždňoch bol ešte menší. Retatrutid preto nemožno zaradiť vedľa semaglutidu a tirzepatidu ako rovnocenne histologicky overenú liečbu MASH. Zostáva experimentálnym liečivom.</p>

<h2>Spôsob podávania: v pôvodnej tabuľke je klinicky významná chyba</h2>

<p>V tabuľke východiskového článku sa pri tirzepatide aj retatrutide opakovane uvádza perorálne podávanie. V citovaných klinických skúšaniach sa však obe liečivá podávali <strong>subkutánne raz týždenne</strong>. Rovnakou cestou sa v ESSENCE podával semaglutid 2,4 mg. Pri tirzepatide rozpor potvrdzuje aj citovaná štúdia SURPASS-5, ktorej názov výslovne uvádza subkutánne podanie.</p>

<p>Táto oprava nie je iba redakčná: cesta podania patrí k základným údajom o lieku. Dávky experimentálnych ramien zároveň nemožno meniť na návod na liečbu mimo schválenej indikácie a aktuálneho súhrnu charakteristických vlastností lieku.</p>

<h2>Prečo z týchto štúdií nemožno zostaviť rebríček liekov</h2>

<p>ESSENCE, SYNERGY-NASH a podštúdia retatrutidu sa líšia fázou, veľkosťou, trvaním, populáciou, dávkami, prácou s chýbajúcimi údajmi aj cieľovými ukazovateľmi. Percentá z nich preto nemožno priamo porovnávať ako v jednom spoločnom experimente.</p>

<ol>
  <li><strong>Metabolické ukazovatele</strong> — hmotnosť, HbA1c a obvod pása — opisujú metabolickú odpoveď.</li>
  <li><strong>Biomarkery a zobrazovanie</strong> — aminotransferázy a obsah tuku v pečeni — sú užitočné, ale nepotvrdzujú histologický ústup MASH.</li>
  <li><strong>Histológia</strong> — ústup steatohepatitídy a zlepšenie fibrózy — je bližšie k samotnému ochoreniu, stále však ide o náhradný ukazovateľ.</li>
  <li><strong>Klinické udalosti</strong> — dekompenzácia, transplantácia, hepatocelulárny karcinóm a úmrtie — sú výsledky, ktoré majú potvrdiť dlhodobý prínos.</li>
</ol>

<p>Úspech na jednej úrovni automaticky nedokazuje úspech na nasledujúcej. Nie je preto opodstatnené odporúčať semaglutid iba pri „miernej MASLD“, tirzepatid pri „pokročilej MASLD“ a retatrutid ako najsilnejšiu možnosť podľa počtu receptorov. Semaglutid bol priamo skúšaný a povolený práve pri MASH s fibrózou F2–F3; výber lieku sa musí riadiť potvrdenou diagnózou, konkrétnou indikáciou a individuálnym pomerom prínosu a rizika.</p>

<h2>Registračné postavenie v EÚ sa musí uvádzať presne</h2>

<p>Tvrdenie, že neexistuje žiadny liek osobitne indikovaný pri MASH, už v septembri 2026 nie je pravdivé. V EÚ majú podmienečné povolenie pre dospelých s necirhotickou MASH a fibrózou F2–F3 dva lieky používané spolu s diétou a pohybovou aktivitou:</p>

<ul>
  <li><strong>Rezdiffra (resmetirom)</strong>, povolená 18. augusta 2025,</li>
  <li><strong>Kayshild (semaglutid)</strong>, povolený 26. marca 2026.</li>
</ul>

<p>Centralizované povolenie platné v EÚ nie je totožné s automatickou úhradou alebo bežnou dostupnosťou na Slovensku. Indikáciu Kayshildu nemožno automaticky preniesť na každý prípravok so semaglutidom ani na celú triedu agonistov GLP-1. Rovnako priaznivý výsledok tirzepatidu v štúdii fázy 2 nevytvára schválenú indikáciu Mounjara pre MASH.</p>

<h2>Čo je osobitne dôležité pre nefrológa</h2>

<h3>Renálne obmedzenia sú špecifické pre prípravok a indikáciu</h3>

<p>Súhrn charakteristických vlastností Kayshildu nevyžaduje úpravu dávky pri miernej alebo stredne ťažkej poruche funkcie obličiek. Skúsenosti pri ťažkej poruche sú však obmedzené a Kayshild sa <strong>neodporúča pri eGFR &lt; 30 ml/min/1,73 m² vrátane terminálneho zlyhania obličiek</strong>. Tieto populačné hranice sú dôležité pri prenose výsledkov ESSENCE do nefrologickej praxe.</p>

<p>Pri Mounjare sú regulačné údaje odlišné: úprava dávky sa nevyžaduje ani pri terminálnom zlyhaní obličiek, skúsenosti pri ťažkej CKD a ESRD sú však obmedzené a odporúča sa opatrnosť. To nemení skutočnosť, že Mounjaro nemá v EÚ osobitnú indikáciu pre MASH. Registračné údaje jednej značky alebo indikácie sa nesmú bez kontroly prenášať na inú.</p>

<h3>Gastrointestinálne ťažkosti môžu poškodiť obličky</h3>

<p>Nauzea, vracanie a hnačka môžu znížiť príjem tekutín a viesť k hypovolémii, hypotenzii, poruche elektrolytov a zhoršeniu funkcie obličiek. Európske produktové informácie na toto riziko výslovne upozorňujú pri semaglutide aj tirzepatide. U pacienta s CKD treba pri významných ťažkostiach posúdiť hydratáciu, tlak, kreatinín, elektrolyty a súbežné diuretiká či ďalšiu hemodynamicky aktívnu liečbu.</p>

<h3>Nízke riziko hypoglykémie nie je nulové</h3>

<p>Glukózovo závislé inkretínové pôsobenie má samo osebe nízke riziko hypoglykémie. Riziko sa zvyšuje pri kombinácii s inzulínom alebo derivátom sulfonylurey a pri náhlom poklese príjmu potravy. Pri zlepšení glykémie treba tieto lieky individuálne prehodnotiť; nie je bezpečné vysadiť alebo znížiť ich paušálne bez znalosti glykemického profilu.</p>

<h3>Pokles hmotnosti treba hodnotiť spolu so svalovou funkciou</h3>

<p>Redukcia hmotnosti pri obezite môže priniesť zásadný metabolický úžitok, ale časť úbytku tvorí aj beztuková hmota. Pri pokročilej CKD, dialýze, krehkosti alebo cirhóze preto nestačí sledovať kilogramy. Dôležité sú príjem bielkovín a energie primeraný štádiu CKD, svalová sila, funkčná výkonnosť a známky proteínovo-energetického chradnutia. Liečba sa nemá titrovať cez pretrvávajúcu intoleranciu a nedostatočný príjem.</p>

<h3>Pečeňový a obličkový dôkaz treba posudzovať oddelene</h3>

<p>Štúdia FLOW preukázala pri semaglutide 1 mg raz týždenne u 3 533 pacientov s diabetom 2. typu a CKD zníženie rizika zloženého renálneho ukazovateľa o 24 % oproti placebu (HR 0,76; 95 % IS 0,66–0,88). Je to samostatný dôkaz zo špecifickej populácie a s inou dávkou než v ESSENCE. Nemožno z neho odvodiť, že histologické zlepšenie MASH sprostredkovalo renálny prínos, ani ho automaticky preniesť na tirzepatid alebo retatrutid.</p>

<h2>Praktický rámec rozhodovania</h2>

<ol>
  <li><strong>Potvrdiť fenotyp a riziko pečeňového ochorenia.</strong> Steatóza, MASH, fibróza F2–F3 a cirhóza nie sú zameniteľné diagnózy.</li>
  <li><strong>Určiť hlavnú liečebnú indikáciu.</strong> Rozlíšiť diabetes, obezitu, MASH a kardiorenálnu ochranu; pri každej overiť konkrétny prípravok a dávku.</li>
  <li><strong>Zhodnotiť obličky a objemový stav.</strong> Skontrolovať eGFR, albuminúriu, tlak, diuretiká, sklon k hypovolémii a riziko akútneho poškodenia obličiek.</li>
  <li><strong>Prehodnotiť riziko hypoglykémie.</strong> Osobitne pri inzulíne, derivátoch sulfonylurey a zníženom príjme potravy.</li>
  <li><strong>Chrániť výživu a funkčný stav.</strong> Sledovať nielen hmotnosť, ale aj svalovú silu, príjem živín a prejavy krehkosti.</li>
  <li><strong>Hodnotiť správny výsledok.</strong> Pokles ALT alebo pečeňového tuku nie je totožný s ústupom MASH, regresiou fibrózy alebo prevenciou dekompenzácie.</li>
</ol>

<h2>Čo možno a nemožno tvrdiť</h2>

<h3>Dostatočne podložené</h3>

<ul>
  <li>Semaglutid 2,4 mg zlepšil oba primárne histologické ukazovatele v priebežnej analýze ESSENCE.</li>
  <li>Tirzepatid zlepšil ústup MASH bez zhoršenia fibrózy v štúdii fázy 2 SYNERGY-NASH.</li>
  <li>Retatrutid výrazne znížil obsah tuku v pečeni meraný MRI v malej podštúdii fázy 2a.</li>
  <li>Všetky tri liečivá sa v uvedených štúdiách podávali subkutánne raz týždenne.</li>
  <li>Kayshild má v EÚ podmienečné povolenie pre necirhotickú MASH s fibrózou F2–F3.</li>
</ul>

<h3>Zatiaľ nepreukázané alebo neprimerane silné</h3>

<ul>
  <li>Retatrutid je histologicky potvrdenou liečbou MASH alebo fibrózy.</li>
  <li>Viac receptorov automaticky znamená nadradenú účinnosť alebo bezpečnosť.</li>
  <li>Semaglutid patrí iba k miernej MASLD a tirzepatid k pokročilej MASLD.</li>
  <li>Percentá z ESSENCE, SYNERGY-NASH a podštúdie retatrutidu predstavujú priame porovnanie liekov.</li>
  <li>Histologické zlepšenie už dokazuje nižšie riziko dekompenzácie, transplantácie alebo úmrtia.</li>
  <li>Pečeňový výsledok automaticky dokazuje renálnu ochranu celej liekovej triedy.</li>
</ul>

<h2>Záver</h2>

<p>Inkretínové a kombinované receptorové agonisty významne menia liečbu metabolických ochorení, pri MASH však nemajú rovnakú dôkazovú ani regulačnú pozíciu. Semaglutid má histologické výsledky fázy 3 a Kayshild podmienečné povolenie EÚ pre necirhotickú MASH s fibrózou F2–F3. Tirzepatid priniesol presvedčivý histologický signál vo fáze 2, ale Mounjaro zatiaľ nemá európsku indikáciu pre MASH. Retatrutid výrazne znižuje pečeňový tuk, no chýba mu histologický dôkaz liečby MASH a zostáva experimentálny.</p>

<p>Pre nefrológa je rozhodujúce nepodľahnúť jednoduchému rebríčku „jednoduchý, duálny, trojitý agonista“. Liečbu treba vyberať podľa potvrdenej diagnózy, schválenej indikácie, funkcie obličiek a individuálneho rizika. Počas liečby treba aktívne sledovať hydratáciu, glykémiu, znášanlivosť a zachovanie svalovej aj nutričnej rezervy.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=masld-diagnostika-fibroza-nefrologicka-prax">MASLD: diagnostika, hodnotenie fibrózy a význam pre nefrologickú prax</a></li>
  <li><a href="article.php?slug=glp1-lieky-renalne-benefity-dokazy-prax-nefrologia">GLP-1 lieky: renálne prínosy, dôkazy a nefrologická prax</a></li>
  <li><a href="article.php?slug=retatrutid-ubytok-hmotnosti-metabolicke-benefity">Retatrutid: úbytok hmotnosti, metabolické výsledky a limity dôkazov</a></li>
  <li><a href="article.php?slug=alternativne-sladidla-masld-ckd-inkretinova-liecba">Sladidlá pri MASLD, CKD a inkretínovej liečbe: dôkazy a neistoty</a></li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Ľubomír Horák, Anna Šarocká.</strong> <em>Inkretínové agonisty v liečbe MASLD a MASH: Porovnanie trojice terapeutických prístupov.</em> Via practica. 2026;23(2):62–65. <a href="https://www.solen.sk/sk/casopisy/via-practica/inkretinove-agonisty-v-liecbe-masld-a-mash-porovnanie-trojice-terapeutickych-pristupov" target="_blank" rel="noopener noreferrer">Záznam a abstrakt vydavateľa</a>.</li>
  <li><strong>Arun J. Sanyal, Philip N. Newsome, Iris Kliers a spol.; ESSENCE Study Group.</strong> <em>Phase 3 Trial of Semaglutide in Metabolic Dysfunction-Associated Steatohepatitis.</em> New England Journal of Medicine. 2025;392(21):2089–2099. doi: 10.1056/NEJMoa2413258. <a href="https://pubmed.ncbi.nlm.nih.gov/40305708/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://doi.org/10.1056/NEJMoa2413258" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Kayshild (semaglutid): EPAR a informácie o lieku.</em> Podmienečné povolenie vydané 26. marca 2026. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/kayshild" target="_blank" rel="noopener noreferrer">EPAR</a>. <a href="https://www.ema.europa.eu/en/documents/product-information/kayshild-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Súhrn charakteristických vlastností lieku</a>.</li>
  <li><strong>Rohit Loomba, Mark L. Hartman, Eric J. Lawitz a spol.; SYNERGY-NASH Investigators.</strong> <em>Tirzepatide for Metabolic Dysfunction-Associated Steatohepatitis with Liver Fibrosis.</em> New England Journal of Medicine. 2024;391(4):299–310. doi: 10.1056/NEJMoa2401943. <a href="https://pubmed.ncbi.nlm.nih.gov/38856224/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://doi.org/10.1056/NEJMoa2401943" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Arun J. Sanyal, Lee M. Kaplan, Juan P. Frias a spol.</strong> <em>Triple hormone receptor agonist retatrutide for metabolic dysfunction-associated steatotic liver disease: a randomized phase 2a trial.</em> Nature Medicine. 2024;30(7):2037–2048. doi: 10.1038/s41591-024-03018-2. <a href="https://pubmed.ncbi.nlm.nih.gov/38858523/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11271400/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Mounjaro (tirzepatid): EPAR a informácie o lieku.</em> <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/mounjaro" target="_blank" rel="noopener noreferrer">EPAR</a>. <a href="https://www.ema.europa.eu/en/documents/product-information/mounjaro-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Súhrn charakteristických vlastností lieku</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Rezdiffra (resmetirom): EPAR.</em> Podmienečné povolenie vydané 18. augusta 2025. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/rezdiffra" target="_blank" rel="noopener noreferrer">EPAR</a>.</li>
  <li><strong>Vlado Perkovic, Katherine R. Tuttle, Peter Rossing a spol.; FLOW Trial Committees and Investigators.</strong> <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes.</em> New England Journal of Medicine. 2024;391(2):109–121. doi: 10.1056/NEJMoa2403347. <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>European Association for the Study of the Liver, European Association for the Study of Diabetes, European Association for the Study of Obesity.</strong> <em>EASL–EASD–EASO Clinical Practice Guidelines on the management of metabolic dysfunction-associated steatotic liver disease.</em> Journal of Hepatology. 2024;81(3):492–542. doi: 10.1016/j.jhep.2024.04.031. <a href="https://pubmed.ncbi.nlm.nih.gov/38851997/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11299976/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
</ol>

<p><em><strong>Poznámka k vecnej kontrole:</strong> Číselné údaje z ESSENCE, SYNERGY-NASH, obrazovej podštúdie retatrutidu a FLOW boli skontrolované podľa abstraktov a verejných plných textov primárnych publikácií. Indikácie, cesta podania a obmedzenia pri poruche funkcie obličiek boli overené podľa aktuálnych dokumentov EMA. Oproti východiskovému prehľadu bola opravená definícia MASLD, nesprávne perorálne podávanie tirzepatidu a retatrutidu, neaktuálne tvrdenie o absencii liekov pre MASH a neprimerané rozdelenie liekov podľa „miernej“ a „pokročilej“ MASLD. Doplnené boli histologické výsledky ESSENCE a SYNERGY-NASH a presné odlíšenie obrazového výsledku retatrutidu od liečby biopsiou potvrdenej MASH.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_inkretinove_agonisty_masld_mash_pecen_ckd',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    ?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Migrácia článku</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migrácia článku</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?>
              <p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p>
            <?php endif; ?>
          </div>

          <ul>
            <?php foreach ($articles as $a): ?>
              <li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li>
            <?php endforeach; ?>
          </ul>

          <p class="mt-30">
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
