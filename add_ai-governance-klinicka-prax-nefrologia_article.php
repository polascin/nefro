<?php
/**
 * add_ai-governance-klinicka-prax-nefrologia_article.php
 * Odborný článok o správe a riadení klinickej umelej inteligencie (governance),
 * pracovných postupoch a ľudskom dohľade s náväznosťou na nefrológiu.
 * Spracovanie odborného rozhovoru Medscape Digital Health Pulse zo 16. 10. 2026.
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'UI v klinickej praxi: správa, pracovné postupy a ľudský dohľad – praktický rámec pre nefrológiu',
    'slug'         => 'ai-governance-klinicka-prax-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Zlý pracovný postup sa automatizáciou nezlepší, iba zrýchli. Čo o ambientnej dokumentácii a únave z upozornení skutočne vieme a aké termíny podľa aktu EÚ o UI platia po odklade.',
    'content'      => <<<'HTML'
<figure><a href="img/ai-governance-klinicka-prax-nefrologia.webp" rel="noopener noreferrer" target="_blank"><img src="img/ai-governance-klinicka-prax-nefrologia.webp" alt="Chaotický roj modrých dátových vlákien prechádza presnou geometrickou mriežkou a vychádza z nej ako jediný pokojný jantárový pruh svetla smerujúci k polopriesvitnej sklenej obličke" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie zobrazenie konkrétneho systému ani pracoviska. Rozdiel medzi užitočnou a škodlivou umelou inteligenciou v ambulancii nerobí model, ale to, čo stojí medzi ním a rozhodnutím o pacientovi.</figcaption></figure>

<p>Umelá inteligencia (UI) sa v zdravotníctve presunula z pilotných projektov do bežnej prevádzky rýchlejšie, než vznikli pravidlá na jej riadenie. Otázka „dokáže to UI?“ je dnes menej zaujímavá než otázka „vyrieši to problém, ktorý na našom pracovisku skutočne máme, a zvládneme to riadiť päť rokov po nasadení?“.</p>

<p>Tento text zhŕňa praktický rámec správy a riadenia (governance) klinickej UI, zasadzuje ho do aktuálneho regulačného stavu k októbru 2026 a prekladá ho do nefrologických situácií – dávkovanie pri meniacej sa glomerulovej filtrácii, upozornenia na hyperkaliémiu, triáž, ambulantná dokumentácia. Vychádza z odborného rozhovoru publikovaného na Medscape a z primárnych zdrojov, ktoré boli pre jednotlivé tvrdenia overené samostatne.</p>

<h2>Prvá zásada: problém pred nástrojom</h2>

<p>Deepti Pandita, hlavná lekárska informatička a riaditeľka pre UI na University of California Irvine Health, formuluje východisko jednoducho: <em>„UI nie je stratégia. UI môže byť prostriedkom, ktorý existujúce stratégie posilní.“</em> Keď sa jej vedenie pýta, aká je ich stratégia pre UI, odpovedá otázkou, ktoré časti už existujúceho plánu sa dajú nástrojmi UI podporiť.</p>

<p>Z toho plynie druhá, pre prax ešte dôležitejšia veta: <strong>zlý pracovný postup sa automatizáciou nezlepší, iba zrýchli.</strong> Ak je ambulantný proces chaotický, UI vrstva nad ním vyrobí chaos rýchlejšie a v väčšom objeme. Poradie krokov je teda: najprv opísať a opraviť postup, až potom zvažovať technológiu.</p>

<p>Tretia zásada je o viditeľnosti: <em>„najlepšia UI je tá, ktorú klinik nikdy nevidí.“</em> Nástroj, ktorý si vyžaduje ďalšie okno, ďalšie kliknutie a ďalšiu obrazovku, pridáva k záťaži namiesto toho, aby ju odoberal – aj keď jeho model funguje presne tak, ako má.</p>

<h2>Dve triedy použitia, ktoré nemožno riadiť rovnako</h2>

<p>Pre praktické účely sa klinická UI delí na dve skupiny s odlišným profilom rizika:</p>

<div class="table-responsive" role="region" aria-label="Porovnanie administratívnych a rozhodovacích aplikácií umelej inteligencie v klinickej praxi" tabindex="0">
<table>
<caption>Dve triedy klinickej UI a rozdiely v tom, čo treba merať a riadiť.</caption>
<thead>
<tr><th scope="col">Hľadisko</th><th scope="col">Administratívna a dokumentačná UI</th><th scope="col">UI zasahujúca do rozhodovania</th></tr>
</thead>
<tbody>
<tr><th scope="row">Typický príklad</th><td>Ambientný zápis konzultácie, prepis, návrh prepúšťacej správy, triedenie pošty</td><td>Upozornenia na interakcie a dávkovanie, predikcia rizika, triáž, podpora diagnostiky</td></tr>
<tr><th scope="row">Cieľ</th><td>Vrátiť čas a kognitívnu kapacitu smerom k pacientovi</td><td>Bezpečnosť, konzistentnosť, menej chýb bez novej záťaže</td></tr>
<tr><th scope="row">Čo merať</th><td>Čas strávený dokumentáciou, práca po pracovnom čase, kvalita zápisu, skúsenosť pacienta</td><td>Miera akceptácie a prekročenia upozornení, bezpečnostné ukazovatele, nežiaduce udalosti</td></tr>
<tr><th scope="row">Spôsob dohľadu</th><td>Kontrola a úprava návrhu pred podpisom</td><td>Testovanie pred nasadením, priebežné meranie chybovosti, eskalačný proces</td></tr>
<tr><th scope="row">Regulačné zaradenie</th><td>Spravidla mimo definície zdravotníckej pomôcky</td><td>Často zdravotnícka pomôcka so všetkým, čo z toho vyplýva</td></tr>
</tbody>
</table>
</div>

<p>Toto rozdelenie nie je akademické. Určuje, či pracovisko potrebuje klinickú validáciu a označenie CE, alebo „len“ dobrý interný proces kontroly kvality.</p>

<h2>Čo o ambientnej dokumentácii vieme a čo nie</h2>

<p>Ambientný zápis patrí k najlepšie zdokumentovaným použitiam. Prospektívna observačná štúdia metodikou snímkovania pracovného dňa (time-motion) v singapurskej univerzitnej nemocnici sledovala <strong>deväť klinikov a 169 konzultácií</strong>, pričom každý klinik slúžil ako vlastná kontrola a päť vyškolených pozorovateľov merilo čas priamo, nie z časových značiek v informačnom systéme.</p>

<ul>
  <li>Čas dokumentácie na konzultáciu klesol o <strong>15,0 %</strong> (z 5,3 ± 2,7 na 4,5 ± 2,4 minúty; P = 0,04).</li>
  <li>Podiel času očného kontaktu stúpol relatívne o <strong>10,6 %</strong> (z 69,6 ± 18,6 % na 77,1 ± 17,7 %; P = 0,009).</li>
  <li>Dĺžka konzultácie sa nezmenila (11,5 vs. 10,9 minúty; P = 0,42) a nezmenil sa ani celkový čas na pacienta vrátane prípravy a dokončenia zápisu (13,7 vs. 13,2 minúty; P = 0,57).</li>
  <li>Z 39 opýtaných pacientov 27 (69,2 %) súhlasilo, že sa im lekár počas návštevy venoval viac; nikto neuviedol nepohodlie z technológie.</li>
</ul>

<p>Metodicky je najcennejšie to, čo sa <em>nezmenilo</em>: pracovisko nezískalo kapacitu na viac pacientov. Nástroj <strong>presunul úsilie klinika od obrazovky k pacientovi</strong>, nezrýchlil obrat. To je legitímny a dobrý výsledok – ale ak sa nástroj zavádza s prísľubom vyššej priepustnosti, zlyhá.</p>

<p>Hranice dôkazu treba povedať rovnako jasne: ide o observačnú štúdiu zlepšovania kvality s deviatimi skúsenými používateľmi na jednom pracovisku, nie o randomizovanú štúdiu. Výsledok hovorí, čo sa dá dosiahnuť, nie čo sa dosiahne automaticky.</p>

<h2>Únava z upozornení: najčastejší spôsob, ako si rozhodovaciu podporu pokaziť</h2>

<p>Obava, že UI pridá ďalšiu vrstvu upozornení a kontrolných obrazoviek, má tvrdý empirický základ. V literatúre o počítačovom zadávaní ordinácií sa opakovane uvádza, že <strong>približne 90–96 % upozornení lekári prekročia</strong> – pri takej miere prestáva byť upozornenie informáciou a stáva sa šumom.</p>

<p>Jednou zo skúmaných ciest je predpovedať, či klinik dané upozornenie prijme, a podľa toho odstupňovať jeho rušivosť. Práca z taiwanskej univerzitnej nemocnice vyvinula a validovala modely strojového učenia na 6 453 ordináciách, ktoré v systéme rozhodovacej podpory spustili upozornenie; neurónová sieť dosiahla plochu pod ROC krivkou 0,94 a presnosť 0,85, čím prekonala náhodný les, naivný Bayes, gradientný boosting aj metódu podporných vektorov.</p>

<p>Dôležitá výhrada, ktorú predlohy tohto typu zvyknú stratiť: išlo o <strong>vývoj a validáciu modelu na historických dátach, nie o preukázanie, že nasadenie takého modelu skutočne zníži únavu z upozornení alebo zlepší bezpečnosť</strong>. Ide o vierohodnú cestu, nie o doložený klinický prínos.</p>

<p>V nefrológii sa problém koncentruje do niekoľkých dobre známych miest:</p>

<ul>
  <li>upozornenia na liekové interakcie u pacientov s chronickou chorobou obličiek, kde veľká časť hlásení opakuje to, čo nefrológ vie;</li>
  <li>návrhy na úpravu dávky pri zmene odhadovanej glomerulovej filtrácie, ktoré nerozlišujú prechodný hemodynamický pokles od skutočného zhoršenia;</li>
  <li>upozornenia na riziko hyperkaliémie pri liečbe inhibítormi RAAS a mineralokortikoidovými receptorovými antagonistami, ktoré nezohľadňujú zámer lekára liečbu ponechať;</li>
  <li>signály akútneho poškodenia obličiek po kontrastnej látke alebo po intervencii bez kontextu objemového stavu.</li>
</ul>

<p>Spoločný menovateľ je, že upozornenie neberie do úvahy informáciu, ktorú klinik už má. Výsledkom je, že začne šetriť pozornosť – a prehliadne aj to upozornenie, ktoré malo zmysel.</p>

<h2>Správa a riadenie UI: čím sa líši od bežného riadenia technológií</h2>

<p>Pandita zdôrazňuje jeden konkrétny rozdiel: bežnú softvérovú alebo hardvérovú dodávku nasadíte a vrátite sa k nej o pár rokov. UI treba riadiť <strong>na vstupe aj po nasadení, nepretržite počas celého životného cyklu</strong>, pretože modely sa môžu znehodnotiť, driftovať a pri generatívnych systémoch vymýšľať. Prakticky to znamená štyri vrstvy:</p>

<ol>
  <li><strong>Vstupná kontrola.</strong> Bezpečnostné a súlad zabezpečujúce mantinely pri prijímaní dát; chránené osobné údaje o zdravotnom stave nesmú opustiť kontrolované prostredie. Pri nástrojoch pracujúcich v cloude to znamená overiť, či sa zvuk či text uchovávajú, kde a ako dlho.</li>
  <li><strong>Viacstranný riadiaci výbor.</strong> Klinici, informatici, bezpečnosť, kvalita, právnici a podľa kontextu aj zástupca pacientov. Jeho úlohou je posúdiť etické aspekty, predpojatosť modelu a hodnotenie jeho výkonnosti ešte pred pilotom.</li>
  <li><strong>Nepretržité monitorovanie.</strong> Nie revízia raz za tri roky, ale priebežné sledovanie s vopred definovanými sentinelovými udalosťami. Zlyhanie modelu zriedka vyzerá ako pád softvéru – býva tiché a prejaví sa zhoršenou kvalitou odporúčaní.</li>
  <li><strong>Dátové základy.</strong> Bez dobrej správy údajov niet dobrej UI. Ak je dátová infraštruktúra neusporiadaná, výsledky sa nedostavia bez ohľadu na kvalitu modelu.</li>
</ol>

<p>K tomu patrí varovanie, ktoré stojí za zopakovanie: <strong>to, že riešenie fungovalo na inom pracovisku, nepredpovedá, že bude fungovať u vás.</strong> Pracovné postupy, procesy, infraštruktúra a dátové základy sa medzi zariadeniami líšia natoľko, že prenos výsledku nie je automatický.</p>

<h3>Etické rámce, z ktorých sa dá vychádzať</h3>

<p>Svetová zdravotnícka organizácia vo svojom usmernení z roku 2021 postavila etiku a ľudské práva do jadra návrhu, nasadenia aj používania UI v zdravotníctve a vymedzila šesť zásad: ochrana autonómie človeka; podpora ľudského blaha, bezpečnosti a verejného záujmu; transparentnosť, vysvetliteľnosť a zrozumiteľnosť; zodpovednosť a vyvoditeľnosť zodpovednosti; inkluzívnosť a spravodlivosť; a schopnosť systému reagovať a byť udržateľný. V roku 2024 WHO vydala samostatné usmernenie pre veľké multimodálne modely, ktoré sa venuje práve generatívnym systémom.</p>

<p>Americká zdravotnícko-informatická asociácia (AMIA) sformulovala zásady dôveryhodnej UI, použiteľné ako kontrolný zoznam toho, čo musí byť opísané a merateľné pred pilotom: vysvetliteľnosť a interpretovateľnosť, spravodlivosť a absencia predpojatosti, spoľahlivosť vrátane bezpečného zlyhania, auditovateľnosť a záznam o činnosti (audit trail), správa poznatkovej základne a aktualizácií modelu, transparentnosť a zodpovednosť organizácie.</p>

<h2>Ľudský dohľad: čo tá fráza skutočne znesie</h2>

<p>Tu je potrebné byť presný, pretože bežná interpretácia a odborný názor sa rozchádzajú. „Človek v slučke“ (human in the loop) sa zvykne chápať ako požiadavka, aby klinik potvrdil každý výstup UI. Pandita tento výklad otvorene spochybňuje: človek dokáže len toľko, koľko stihne, a <em>„ten človek nemusí ani vedieť, že daný poznatok pochádza z UI“</em>. Formálne odklikávanie potom vytvára ilúziu dohľadu bez jeho obsahu.</p>

<p>Jej alternatívne vymedzenie je užšie, ale vymáhateľné: UI má odstrániť to, čo sa postavilo <em>medzi</em> klinika a pacienta – klávesnicu, schránku správ, administratívnu záťaž, informačné zahltenie – pričom podstata vzťahu lekár – pacient musí zostať chránená. Paradoxne tak môže UI urobiť starostlivosť ľudskejšou.</p>

<p>Pre pracovisko z toho plynú tri praktické požiadavky:</p>

<ul>
  <li><strong>Označovanie pôvodu.</strong> Klinik musí vedieť, ktorá časť zápisu alebo odporúčania pochádza z UI. Bez toho dohľad nie je možný ani v princípe.</li>
  <li><strong>Odstupňovanie podľa dôsledku.</strong> Vopred určiť, ktoré výstupy vyžadujú aktívne potvrdenie a ktoré sú len návrhom na kontrolu. Všetko potvrdzovať rovnako znamená nepotvrdzovať nič.</li>
  <li><strong>Ostražitosť voči uhladenému textu.</strong> Generatívny systém dokáže klinické myslenie preformulovať do podoby, ktorá znie správne a prejde kontrolou práve preto, že znie správne. Zdravá dávka skepsy, nie slepá dôvera – to je podľa Pandity jediná podoba dohľadu, ktorá vydrží.</li>
</ul>

<h2>Regulačný rámec k októbru 2026</h2>

<h3>Riadenie zmien modelu: plány PCCP</h3>

<p>Modely sa po nasadení menia – a bez pravidiel sa každá zmena stáva novým, neposúdeným produktom. Americká FDA, Health Canada a britská MHRA preto <strong>18. augusta 2025</strong> spoločne vydali vodiace zásady pre vopred určené plány riadenia zmien (predetermined change control plans, PCCP) pri zdravotníckych pomôckach so strojovým učením. Ide o nezáväzné usmernenie, ktoré stanovuje päť zásad: plán má byť zameraný a ohraničený, založený na riziku, podložený dôkazmi, transparentný voči zainteresovaným stranám a vedený z perspektívy celého životného cyklu výrobku (TPLC).</p>

<p>Tieto zásady sú použiteľné aj pre nemocnicu, ktorá nie je výrobcom: ak nasadíte nástroj, ktorý sa priebežne aktualizuje, potrebujete vlastné pravidlo, ktoré zmeny prijmete bez opätovného posúdenia a ktoré nie.</p>

<h3>Európsky akt o umelej inteligencii a čo sa s ním stalo</h3>

<p>Pre slovenské pracovisko je záväzným rámcom nariadenie (EÚ) 2024/1689 – akt o umelej inteligencii – postavené na posudzovaní rizika. Jeho časový plán sa však v priebehu roka 2026 posunul a predlohy, ktoré vychádzajú zo staršieho stavu, uvádzajú neaktuálne dátumy.</p>

<div class="table-responsive" role="region" aria-label="Platné dátumy uplatňovania povinností podľa aktu EÚ o umelej inteligencii k októbru 2026" tabindex="0">
<table>
<caption>Dátumy uplatňovania povinností podľa nariadenia (EÚ) 2024/1689 po zmene nariadením (EÚ) 2026/1744, stav k 17. októbru 2026.</caption>
<thead>
<tr><th scope="col">Okruh povinností</th><th scope="col">Uplatňuje sa od</th></tr>
</thead>
<tbody>
<tr><th scope="row">Zakázané praktiky a povinnosť gramotnosti v oblasti UI</th><td>2. februára 2025</td></tr>
<tr><th scope="row">Pravidlá správy a povinnosti poskytovateľov všeobecných modelov UI</th><td>2. augusta 2025</td></tr>
<tr><th scope="row">Povinnosti transparentnosti (čl. 50) a väčšina ostatných pravidiel</th><td>2. augusta 2026</td></tr>
<tr><th scope="row">Vysokorizikové systémy podľa prílohy III (napr. biometria, vzdelávanie, zamestnanosť)</th><td>2. decembra 2027</td></tr>
<tr><th scope="row">Vysokorizikové systémy podľa prílohy I – UI ako súčasť výrobku podliehajúceho sektorovej legislatíve vrátane zdravotníckych pomôcok</th><td>2. augusta 2028</td></tr>
</tbody>
</table>
</div>

<p>Odklad zaviedlo nariadenie (EÚ) 2026/1744, takzvaný digitálny omnibus pre UI, ktoré nadobudlo účinnosť 27. júla 2026. Pôvodný termín 2. augusta 2026 sa pre vysokorizikové systémy posunul o šestnásť mesiacov.</p>

<p><strong>Pre klinickú UI je rozhodujúci posledný riadok tabuľky.</strong> Softvér, ktorý je zdravotníckou pomôckou alebo jej bezpečnostnou súčasťou podľa nariadenia o zdravotníckych pomôckach, spadá pod prílohu I, a teda pod termín august 2028. Požiadavky, ktoré potom nastúpia – systém riadenia rizík, správa údajov, technická dokumentácia, automatické záznamy o činnosti, ľudský dohľad, presnosť, robustnosť a kybernetická bezpečnosť, hlásenie závažných incidentov – sú však presne tým, čo by malo zodpovedné pracovisko zaviesť tak či tak. Odklad je časom na prípravu, nie dôvodom nerobiť nič.</p>

<h2>Praktický postup pre nefrologické pracovisko</h2>

<ol>
  <li><strong>Opíšte pracovný postup skôr, než si vyberiete nástroj.</strong> Kde vzniká časová alebo kognitívna strata? Ide o dokumentáciu, komunikáciu, triáž, alebo o samotné rozhodovanie? Kto je primárnym používateľom a kto pracuje s výstupom ďalej?</li>
  <li><strong>Stanovte merateľný cieľ pred nasadením.</strong> Pri dokumentácii: čas na zápis, práca po pracovnom čase, kvalita zápisu, skúsenosť pacienta. Pri rozhodovacej podpore: miera akceptácie upozornení, bezpečnostné ukazovatele, záťaž používateľa. Cieľ určený až po nasadení sa vždy podarí splniť.</li>
  <li><strong>Zapojte klinikov do výberu a návrhu.</strong> Riešenie vybrané bez nich spravidla nesadne do procesu. Pri ambientných nástrojoch rozhoduje štruktúra výstupu a spôsob, akým sa návrh dostane do elektronickej zdravotnej dokumentácie.</li>
  <li><strong>Vyriešte údaje a súkromie písomne.</strong> Kde sa spracúvajú, či sa uchovávajú, kto má prístup, či systém uchováva zvukový záznam. Pri cezhraničnom spracúvaní doplňte posúdenie vplyvu na ochranu údajov.</li>
  <li><strong>Testujte aj spôsoby zlyhania, nielen presnosť.</strong> Ako sa systém správa pri chýbajúcich údajoch, pri netypickom pacientovi, pri výpadku? Čo urobí používateľ, keď výstup nedôveryhodne vyzerá?</li>
  <li><strong>Monitorujte po nasadení.</strong> Plán pre drift, pravidelné kvalitatívne posúdenie výstupov, definované sentinelové udalosti a záznam o činnosti, ktorý umožní spätne vysvetliť, čo sa stalo a prečo.</li>
  <li><strong>Riaďte zmeny.</strong> Dohodnite s dodávateľom, ktoré aktualizácie sú vopred odsúhlasené a ktoré vyžadujú nové posúdenie – v duchu zásad PCCP, aj keď formálne PCCP mať nemusíte.</li>
  <li><strong>Sledujte spravodlivosť prístupu.</strong> Pacienti s obmedzeným prístupom k technológiám sú už dnes ťažšie dosiahnuteľní. Nástroj, ktorý zlepší starostlivosť len tým, ktorí s technológiou vedia pracovať, digitálnu priepasť prehlbuje. V dialyzačnej a predialyzačnej populácii, kde je priemerný vek vysoký, to nie je teoretická obava.</li>
</ol>

<h2>Ako si definovať úspech</h2>

<p>Na záver stojí za zopakovanie meradlo, ktoré Pandita ponúka: úspechom nie je, že pracovisko tento rok nasadilo sto nástrojov UI. Úspechom je, že pacienti dostali lepšiu starostlivosť a klinici dostali späť čas. Najväčší posun sa podľa nej dá v najbližších rokoch čakať v administratívnej oblasti; pri UI priamo pri lôžku zostane postup pomalší – a to oprávnene, pretože tam je aj jednopercentná chybovosť neprijateľná.</p>

<h2>Limity</h2>

<ul>
  <li><strong>Východiskový zdroj je odborný rozhovor</strong>, teda názor skúseného odborníka, nie systematický prehľad. Jednotlivé tvrdenia o účinku nástrojov sú v tomto texte podložené samostatne citovanými primárnymi prácami; tam, kde také podloženie neexistuje, je to uvedené.</li>
  <li><strong>Dôkazová základňa pre ambientnú dokumentáciu je tenká.</strong> Citovaná štúdia zahŕňa deväť klinikov na jednom pracovisku v observačnom dizajne. Rozsah účinku pri inom nástroji, inom jazyku a inom type ambulancie môže byť úplne iný – slovenčina ako jazyk prepisu je samostatná otázka, ku ktorej dôkazy prakticky nie sú.</li>
  <li><strong>Prediktívne modelovanie akceptácie upozornení nebolo prospektívne overené v praxi.</strong> Ide o vývoj a validáciu modelu, nie o dôkaz klinického prínosu.</li>
  <li><strong>Regulačný stav sa mení rýchlo.</strong> Uvedené dátumy platia k 17. októbru 2026 a vychádzajú z nariadenia (EÚ) 2024/1689 v znení nariadenia (EÚ) 2026/1744; pred rozhodovaním si ich overte v aktuálnom konsolidovanom znení.</li>
  <li><strong>Nefrologicky špecifické dôkazy chýbajú.</strong> Prenos poznatkov na dávkovanie podľa glomerulovej filtrácie, upozornenia na hyperkaliémiu či predikciu akútneho poškodenia obličiek je v tomto texte úvahou o použiteľnosti rámca, nie doloženým nefrologickým výsledkom.</li>
</ul>

<hr>

<p><em>Text je určený zdravotníckym pracovníkom. Nenahrádza právne poradenstvo ani posúdenie súladu konkrétneho produktu s nariadením o zdravotníckych pomôckach či aktom o umelej inteligencii. Zodpovednosť za rozhodnutie o pacientovi zostáva na ošetrujúcom lekárovi aj vtedy, keď sa opiera o výstup systému umelej inteligencie.</em></p>

<h2>Literatúra</h2>

<ol>
  <li>Abulata N, Pandita D. AI Isn't the Strategy. Knowing Where to Use It Is. <em>Medscape – Global Digital Health Pulse</em>, 16. októbra 2026. <a href="https://www.medscape.com/viewarticle/ai-isnt-strategy-knowing-where-use-it-2026a10012s6" target="_blank" rel="noopener noreferrer">medscape.com</a>.</li>
  <li>Tan JYE, Rafi IBM, Sng GGR, Tung JYM, Lim DYZ, Ong JCL, Lim GH, Lew EYL, Chia KW, Heng MKH. Impact of an Ambient AI Scribe Among Clinicians and Patients: Real-World Prospective Observational Time-Motion Study. <em>JMIR Med Inform.</em> 2026;14:e85580. doi: <a href="https://doi.org/10.2196/85580" target="_blank" rel="noopener noreferrer">10.2196/85580</a>. PMID: 41915701, PMC13037756.</li>
  <li>Poly TN, Islam MM, Muhtar MS, Yang HC, Nguyen PAA, Li YCJ. Machine Learning Approach to Reduce Alert Fatigue Using a Disease Medication-Related Clinical Decision Support System: Model Development and Validation. <em>JMIR Med Inform.</em> 2020;8(11):e19489. doi: <a href="https://doi.org/10.2196/19489" target="_blank" rel="noopener noreferrer">10.2196/19489</a>. PMID: 33211018, PMC7714650.</li>
  <li>Solomonides AE, Koski E, Atabaki SM, Weinberg S, McGreevey JD 3rd, Kannry JL, Petersen C, Lehmann CU. Defining AMIA's artificial intelligence principles. <em>J Am Med Inform Assoc.</em> 2022;29(4):585–591. doi: <a href="https://doi.org/10.1093/jamia/ocac006" target="_blank" rel="noopener noreferrer">10.1093/jamia/ocac006</a>. PMC8922174.</li>
  <li>World Health Organization. <em>Ethics and governance of artificial intelligence for health: WHO guidance.</em> Ženeva: WHO; 2021. ISBN 978-92-4-002920-0. <a href="https://www.who.int/publications/i/item/9789240029200" target="_blank" rel="noopener noreferrer">who.int</a>.</li>
  <li>World Health Organization. <em>Ethics and governance of artificial intelligence for health: Guidance on large multi-modal models.</em> Ženeva: WHO; 2024. <a href="https://www.who.int/publications/i/item/9789240084759" target="_blank" rel="noopener noreferrer">who.int</a>.</li>
  <li>U.S. Food and Drug Administration, Health Canada, Medicines and Healthcare products Regulatory Agency. <em>Predetermined Change Control Plans for Machine Learning-Enabled Medical Devices: Guiding Principles.</em> 18. augusta 2025. <a href="https://www.fda.gov/medical-devices/artificial-intelligence-enabled-medical-devices/predetermined-change-control-plans-machine-learning-enabled-medical-devices-guiding-principles" target="_blank" rel="noopener noreferrer">fda.gov</a>.</li>
  <li>Nariadenie Európskeho parlamentu a Rady (EÚ) 2024/1689 z 13. júna 2024, ktorým sa stanovujú harmonizované pravidlá v oblasti umelej inteligencie (akt o umelej inteligencii). <a href="https://eur-lex.europa.eu/eli/reg/2024/1689/oj" target="_blank" rel="noopener noreferrer">eur-lex.europa.eu</a>.</li>
  <li>Európska komisia. <em>Regulatory framework for AI</em> – prehľad uplatňovania aktu o UI vrátane zmien zavedených nariadením (EÚ) 2026/1744. <a href="https://digital-strategy.ec.europa.eu/en/policies/regulatory-framework-ai" target="_blank" rel="noopener noreferrer">digital-strategy.ec.europa.eu</a>.</li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p>Citácie 2–4 boli overené cez PubMed a Crossref k 17. októbru 2026 vrátane úplných autorských zoznamov, ročníkov, čísel a strán; údaje zo štúdie ambientného zápisu a z práce o únave z upozornení pochádzajú zo štruktúrovaných abstraktov. Znenie rozhovoru (citácia 1) bolo overené na verejne prístupnej stránke zdroja. Dátumy uplatňovania aktu o UI boli overené na stránke Európskej komisie.</p>

<p>Pri práci sa ukázalo niekoľko nepresností, ktoré sa v sekundárnych zhrnutiach tejto témy bežne opakujú a ktoré sú tu opravené. Vodiace zásady pre plány PCCP nepochádzajú z roku 2021 – to bol spoločný dokument o správnej praxi strojového učenia; zásady PCCP vydali FDA, Health Canada a MHRA 18. augusta 2025. Termín uplatňovania povinností pre vysokorizikové systémy podľa aktu EÚ o UI nie je 2. august 2026: nariadenie (EÚ) 2026/1744 ho posunulo na 2. december 2027 pre prílohu III a na 2. august 2028 pre prílohu I, pod ktorú spadá klinická UI v zdravotníckych pomôckach. Práca o strojovom učení a únave z upozornení je vývojom a validáciou modelu, nie dôkazom, že takýto prístup v praxi znižuje záťaž. A napokon – výklad pojmu „človek v slučke“ ako potvrdzovania každého výstupu je v samotnom zdrojovom rozhovore odmietnutý; text preto uvádza užšie, ale vymáhateľné vymedzenie, nie zaužívanú frázu.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=ai-nefrologia-hands-on-primer-klinicka-integracia">Umelá inteligencia v nefrológii: praktický úvod ku klinickej integrácii</a></li>
  <li><a href="article.php?slug=ai-scribe-pravne-nastrahy-ambulancia-nefrologia">AI scribe v ambulancii: právne nástrahy</a></li>
  <li><a href="article.php?slug=umela-inteligencia-nefrologia-co-vieme-limity">Umelá inteligencia v nefrológii: čo vieme a kde sú limity</a></li>
  <li><a href="article.php?slug=digitalne-zdravotnictvo-nerovnosti-who-nefrologia">Digitálne zdravotníctvo a nerovnosti: pohľad WHO</a></li>
  <li><a href="article.php?slug=pacient-diagnoza-ai-nefrologicka-ambulancia">Pacient s diagnózou od umelej inteligencie v nefrologickej ambulancii</a></li>
  <li><a href="article.php?slug=ai-asistovane-pocus-kardialne-rozhodnutia-nefrologia">AI asistované POCUS a kardiálne rozhodnutia v nefrológii</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_ai_governance_nefrologia_2026 newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_ai_governance_nefrologia_2026 pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_ai_governance_nefrologia_2026 pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_ai_governance_nefrologia_2026 migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . $articles[0]['title'] . "\n";
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
