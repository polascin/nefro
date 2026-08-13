<?php

/**
 * add_psychoza-uzivanie-navykovych-latok-integrovana-starostlivost_article.php
 * Psychoza a sucasne uzivanie navykovych latok - integrovana starostlivost.
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
    'title'        => 'Psychóza a súčasné užívanie návykových látok: integrovaná diagnostika, liečba a ochrana telesného zdravia',
    'slug'         => 'psychoza-uzivanie-navykovych-latok-integrovana-starostlivost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Psychóza a problémové užívanie látok vyžadujú jeden koordinovaný plán. Praktický rámec pre skríning, liečbu, prevenciu predávkovania a ochranu obličiek.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Súčasný výskyt psychózy a problémového užívania psychoaktívnych látok nepredstavuje dve oddelené diagnózy určené pre dve navzájom nepriepustné služby. Pacient potrebuje súbežné posúdenie oboch problémov, jedného koordinátora starostlivosti a plán, ktorý zahŕňa psychiatrickú aj adiktologickú liečbu, prevenciu predávkovania, sociálnu podporu a ochranu telesného zdravia.</em></p>

<p>Kombinácia psychotického ochorenia a poruchy užívania psychoaktívnych látok sa spája s horšou adherenciou, častejšími relapsmi a hospitalizáciami, úrazmi, samovražedným správaním, predávkovaním, nestabilným bývaním a vyššou telesnou chorobnosťou. Organizačne najrizikovejšia je situácia, keď psychiatrická služba podmieňuje liečbu abstinenciou a adiktologická služba stabilizáciou psychózy. Odporúčania NICE zdôrazňujú opačný princíp: <strong>obe poruchy sa majú rozpoznať a liečiť súčasne a pacient nemá byť pre jednu z nich vylúčený zo starostlivosti o druhú</strong>.</p>

<p>Tento článok sa sústreďuje na organizáciu a bezpečnosť integrovanej starostlivosti. Podrobné rozlíšenie primárnej psychotickej poruchy od psychózy vyvolanej látkou rozoberá samostatný článok uvedený v časti Súvisiace články.</p>

<h2>Terminológia určuje správny postup</h2>

<p>Odporúčanie NICE CG120 sa týka ľudí vo veku 14 rokov a viac s podozrením na psychózu alebo potvrdenou psychózou a so súčasným problémovým užívaním alkoholu, predpísaných, voľnopredajných alebo nelegálnych psychoaktívnych látok. Pojem závažné duševné ochorenie je širší a môže zahŕňať aj bipolárnu poruchu či ťažkú depresiu. Klinické jadro CG120 však tvorí psychotické ochorenie so súčasným užívaním látok.</p>

<p>Pri hodnotení treba rozlišovať:</p>

<ul>
  <li>príležitostné, rizikové alebo škodlivé užívanie,</li>
  <li>poruchu užívania psychoaktívnej látky a fyzickú závislosť,</li>
  <li>akútnu intoxikáciu a abstinenčný syndróm,</li>
  <li>psychotickú poruchu vyvolanú látkou,</li>
  <li>primárnu psychotickú poruchu zhoršovanú užívaním látky.</li>
</ul>

<p>Tieto kategórie nie sú zameniteľné. Odlišujú sa bezprostredným rizikom, indikáciou detoxifikácie, potrebou dlhodobého sledovania aj voľbou farmakoterapie.</p>

<h2>Obojsmerný skríning bez moralizovania</h2>

<p>Každý pacient so známou alebo predpokladanou psychózou má byť cielene vyšetrený na užívanie psychoaktívnych látok. Naopak, u človeka s problémovým užívaním látok treba aktívne posúdiť prítomnosť psychotických príznakov. Všeobecná otázka, či pacient „berie drogy“, nestačí.</p>

<p>Anamnéza má zahŕňať konkrétnu látku a jej predpokladané zloženie, množstvo, frekvenciu, spôsob podania, trvanie užívania, čas poslednej dávky, kombinácie látok, predchádzajúce predávkovania a abstinenčné príznaky. Pýtať sa treba aj na alkohol, nikotín, kofeín, predpísané a voľnopredajné lieky a látky získané mimo zdravotnej starostlivosti. Dôležitý je časový vzťah medzi expozíciou, spánkom, psychotickými príznakmi a zmenami adherence.</p>

<p>Syntetické kanabinoidy, nové psychoaktívne látky a nelegálne získané tablety môžu mať iné zloženie, než pacient predpokladá. Aj expozícia, ktorá by u človeka bez psychózy nemusela pôsobiť výrazne, môže u citlivého pacienta zhoršiť paranoju, halucinácie, impulzivitu alebo spánok. Univerzálnu „bezpečnú dávku“ preto nemožno určiť.</p>

<p>Komunikácia má byť priama, konkrétna a neodsudzujúca. Pacienti môžu užívanie zatajiť zo strachu z nedobrovoľnej hospitalizácie, trestného postihu, nútenej liečby alebo zásahu do starostlivosti o deti. Motivačný prístup neznamená pasívne prijatie nebezpečného správania. Pomáha pomenovať pacientove ciele, dôsledky užívania a uskutočniteľný ďalší krok. Ak pacient zatiaľ neprijíma abstinenciu, znižovanie rizika môže zahŕňať obmedzenie frekvencie, odstránenie najrizikovejších kombinácií, prevenciu predávkovania a najmä udržanie kontaktu so službou.</p>

<h2>Diagnóza sa má po kríze prehodnotiť</h2>

<p>Rozlíšenie primárnej psychotickej poruchy od psychózy vyvolanej látkou býva počas intoxikácie alebo abstinencie neisté. V prospech látkovej etiológie hovorí úzka časová súvislosť, vznik po látke so známym psychotomimetickým účinkom a úplný ústup príznakov počas dostatočne dlhej a vierohodne doloženej abstinencie. Primárnu poruchu podporujú psychotické epizódy pred začiatkom užívania, opakovanie bez látkovej expozície, pretrvávanie príznakov mimo očakávaného obdobia intoxikácie alebo abstinencie, negatívne príznaky a dlhodobejší funkčný pokles.</p>

<p>Žiadny jednotlivý znak diagnózu nepotvrdzuje. Konopné látky, stimulanciá, halucinogény a syntetické kanabinoidy môžu u zraniteľného človeka odhaliť alebo urýchliť dlhodobejšiu psychotickú poruchu. Diagnóza stanovená počas krízového prijatia sa preto má po stabilizácii a v ďalšom priebehu cielene prehodnotiť.</p>

<h2>Komplexné hodnotenie a dynamický plán rizika</h2>

<p>Multidisciplinárne posúdenie môže vyžadovať viacero stretnutí. Nemá sa obmedziť na jeden psychiatrický rozhovor. Zahŕňa psychiatrickú a adiktologickú anamnézu, telesné a sexuálne zdravie, kognitívne schopnosti a rozhodovaciu spôsobilosť, bývanie, rodinné vzťahy, ekonomickú situáciu, traumu, vykorisťovanie, kontakt s trestnoprávnym systémom, silné stránky pacienta a pripravenosť zmeniť spôsob užívania alebo s ním prestať.</p>

<p>Informácie od rodiny, záchrannej služby, ambulantných lekárov a z predchádzajúcej dokumentácie môžu zásadne spresniť časovú os. Ich získavanie a zdieľanie musí rešpektovať súhlas, dôvernosť údajov, rozhodovaciu spôsobilosť a slovenský právny rámec. V bezprostredne život ohrozujúcej situácii sa postupuje podľa klinickej nevyhnutnosti a platných právnych pravidiel.</p>

<p>Plán riadenia rizika má byť dynamický. Okrem samovraždy, násilia a sebazanedbávania treba hodnotiť predávkovanie, abstinenčné kŕče, delírium tremens, krvou prenosné infekcie, sexuálne vykorisťovanie, dopravné nehody, liekové interakcie, dostupnosť bývania a riziko straty kontaktu so službou.</p>

<h3>Kedy ide o urgentný somatický aj psychiatrický stav</h3>

<p>Bezodkladné vyšetrenie vyžaduje najmä porucha vedomia alebo pozornosti, výrazné kolísanie stavu, hypertermia, autonómna nestabilita, nový epileptický záchvat, závažná agitovanosť, rigidita alebo klonus, podozrenie na ťažkú intoxikáciu či abstinenčný syndróm, suicidálne alebo násilné správanie, dlhšia imobilizácia a pokles diurézy. Psychotické prejavy pri delíriu sa nesmú automaticky označiť za primárnu psychózu.</p>

<h2>Toxikologický test je nástroj, nie verdikt</h2>

<p>Vyšetrenie moču alebo krvi môže pomôcť pri akútnej intoxikácii, neistej anamnéze, podozrení na liekové interakcie alebo pri sledovaní dohodnutého liečebného plánu. NICE však neodporúča rutinné biologické testovanie všetkých pacientov s psychózou bez konkrétnej klinickej otázky.</p>

<ul>
  <li>Pozitívny nález nemusí dokazovať aktuálnu intoxikáciu ani príčinu psychózy.</li>
  <li>Negatívny výsledok nevylučuje syntetické látky, látky mimo panelu ani už ukončenú expozíciu.</li>
  <li>Detekčné okno závisí od látky, dávky, času, testu a niekedy aj od funkcie obličiek.</li>
  <li>Imunochemické skríningové metódy môžu mať skrížené reakcie a nečakaný výsledok môže vyžadovať konfirmačné vyšetrenie.</li>
</ul>

<p>Testovanie má byť transparentnou súčasťou diagnostického alebo liečebného plánu, nie trestom a nie náhradou terapeutického vzťahu.</p>

<h2>Integrovaná liečba oboch porúch</h2>

<p>Pre väčšinu pacientov má byť jasne určené pracovisko alebo odborník, ktorý koordinuje starostlivosť a zabezpečuje prepojenie psychiatrickej, adiktologickej, všeobecnej a sociálnej pomoci. Organizačné modely sa medzi krajinami a regiónmi líšia. Podstatou integrovanej starostlivosti nie je, aby jeden odborník vykonával všetky intervencie, ale aby existoval spoločný plán, dohodnutá zodpovednosť, vzájomná dostupnosť informácií a koordinované riešenie kríz.</p>

<p>Špecializovaná adiktologická spolupráca je osobitne dôležitá pri ťažkej závislosti od alkoholu, kombinovanej závislosti od alkoholu a benzodiazepínov, závislosti od opioidov alebo kokaínu, opakovaných predávkovaniach, neúspešných pokusoch o liečbu, bezdomovectve a závažnom sociálnom rozvrate.</p>

<h3>Psychosociálne intervencie</h3>

<p>Pacient má dostať intervencie odporúčané pre psychózu aj pre konkrétnu poruchu užívania látky. Podľa diagnózy, potrieb a dostupnosti možno využiť motivačný rozhovor, kognitívno-behaviorálne postupy, rodinnú intervenciu, prevenciu relapsu, nácvik zvládania baženia, podmienené odmeňovanie (<em>contingency management</em>), podporu bývania a sociálneho fungovania či rovesnícku podporu.</p>

<p>Cochrane prehľad 41 randomizovaných štúdií nenašiel kvalitný dôkaz, že by jedna konkrétna psychosociálna intervencia bola pri tejto heterogénnej populácii všeobecne nadradená štandardnej starostlivosti. Neznamená to, že psychosociálna liečba je neúčinná. Znamená to, že dôkazy sú neisté a intervencia má byť individualizovaná, dostatočne dlhá a prepojená s farmakoterapiou, bývaním a praktickou podporou.</p>

<h3>Antipsychotická liečba</h3>

<p>NICE neodporúča vyberať antipsychotikum podľa predpokladu, že jeden liek všeobecne lieči súčasnú poruchu užívania látky lepšie než ostatné. Výber má vychádzať z účinnosti pri predchádzajúcej liečbe, profilu nežiaducich účinkov, telesných komorbidít, liekových interakcií, preferencie pacienta, pravdepodobnosti adherence a možností monitorovania.</p>

<p>Systematický prehľad a metaanalýza publikovaná v roku 2023 spája klozapín s vyššou pravdepodobnosťou abstinencie a nižším rizikom psychiatrickej hospitalizácie v porovnaní s inými antipsychotikami. Autori však upozorňujú na nízku kvalitu a prevažne observačný charakter dôkazov. <strong>Klozapín sa preto nemá nasadzovať iba pre súčasnú látkovú poruchu</strong>; zostáva liekom predovšetkým pre rezistentnú schizofréniu a ďalšie uznané indikácie a vyžaduje pravidelné hematologické a klinické monitorovanie.</p>

<p>Depotné alebo dlhodobo pôsobiace injekčné antipsychotikum nie je špecifickou liečbou látkovej poruchy. Môže byť vhodné podľa všeobecných odporúčaní pre psychózu, napríklad ak ho pacient preferuje alebo ak je klinickou prioritou predchádzať nepozorovanej nonadherencii. Samotné užívanie látok nie je dôvodom na nútenú injekčnú liečbu.</p>

<h2>Interakcie, ktoré menia účinnosť aj toxicitu</h2>

<p>Alkohol, opioidy, benzodiazepíny, gabapentinoidy a ďalšie sedatíva môžu potencovať útlm vedomia, poruchu koordinácie a respiračnú depresiu. Stimulanciá zvyšujú riziko agitovanosti, hypertenzie, tachyarytmií, hypertermie a exacerbácie psychózy. Pri kombinácii liekov a látok treba hodnotiť sedáciu, dýchanie, QT interval, krvný tlak, srdcovú frekvenciu, záchvatový prah, telesnú teplotu a funkciu pečene a obličiek.</p>

<p>Fajčenie tabaku indukuje CYP1A2 a môže znižovať koncentrácie klozapínu a olanzapínu. Po náhlom ukončení alebo výraznom obmedzení fajčenia môžu koncentrácie stúpnuť a vyvolať toxicitu; po opätovnom začatí fajčenia môže účinnosť klesnúť. Tento účinok súvisí s produktmi spaľovania tabaku, nie so samotným nikotínom. Zmena fajčiarskeho režimu preto vyžaduje včasnú konzultáciu predpisujúceho lekára, klinické sledovanie a pri klozapíne podľa situácie aj terapeutické monitorovanie koncentrácie.</p>

<h2>Detoxifikácia a prevencia predávkovania</h2>

<p>NICE CG120 odporúča, aby plánovaná detoxifikácia pacienta s psychózou a súčasnou látkovou poruchou prebiehala za účasti adiktologického tímu v lôžkovom prostredí, prednostne na špecializovanom pracovisku. Toto odporúčanie sa týka komplexnej populácie s psychózou a nemožno ho preniesť na každého pacienta so závislosťou bez psychózy.</p>

<p>Lôžkový postup je osobitne dôležitý pri predchádzajúcom delíriu tremens alebo abstinenčných kŕčoch, závislosti od viacerých tlmivých látok, akútnej psychóze, suicidálnom riziku, závažnej telesnej komorbidite, tehotenstve, nedostatočnej sociálnej podpore a po opakovanom zlyhaní ambulantnej liečby. Náhle vysadenie alkoholu alebo benzodiazepínov môže byť život ohrozujúce. Odporúčanie „okamžite prestať“ bez posúdenia rizika abstinenčného syndrómu preto môže byť nebezpečné.</p>

<p>Počas hospitalizácie alebo abstinencie klesá tolerancia na opioidy. Návrat k predchádzajúcej dávke môže viesť k fatálnemu predávkovaniu. Pred prepustením má byť pripravený plán pokračujúcej liečby, kontakt s adiktologickou službou, poučenie o rizikových kombináciách a podľa miestnych pravidiel aj zabezpečenie naloxónu a zaškolenie pacienta alebo blízkej osoby. Pacient nemá byť z psychiatrického oddelenia prepustený iba preto, že počas hospitalizácie užil látku; incident vyžaduje bezpečnostné a terapeutické riešenie.</p>

<h2>Telesné zdravie nemožno odsunúť na okraj</h2>

<p>Ročná telesná kontrola predstavuje minimum, nie univerzálne postačujúci interval. Frekvencia sa má riadiť liečbou, druhom látky, akútnym rizikom a komorbiditami. Pri antipsychotickej liečbe treba dodržať odporúčané vstupné a následné monitorovanie hmotnosti, obvodu pása, krvného tlaku, pulzu, glykémie alebo HbA1c, lipidov, pohybových nežiaducich účinkov a celkového telesného stavu. EKG, krvný obraz, hepatálne parametre, kreatinín, eGFR, elektrolyty a infekčný skríning sa dopĺňajú podľa konkrétneho lieku, expozície a klinického rizika.</p>

<h3>Akútne poškodenie obličiek</h3>

<p>Stimulanciá a syntetické psychoaktívne látky môžu viesť k hypertermii, hypovolémii, rabdomyolýze, závažnej hypertenzii, renálnej ischémii a v niektorých prípadoch k trombotickej mikroangiopatii. Kokaín sa spája aj s renálnym infarktom a pri kontaminácii levamizolom s vaskulitickými prejavmi. Opioidy môžu poškodenie obličiek sprostredkovať hypoxémiou, hypotenziou a rabdomyolýzou po dlhšej imobilizácii.</p>

<p>Pri agitovanom alebo hypertermickom pacientovi, po kŕčoch či po dlhšom bezvedomí treba sledovať diurézu a vyšetriť kreatinín, draslík, sodík, bikarbonát, vápnik, fosfáty, kreatínkinázu, acidobázickú rovnováhu, moč a EKG. Rozsah vyšetrení sa prispôsobuje klinickému stavu a predpokladanej expozícii.</p>

<h3>Hyponatriémia</h3>

<p>Psychogénna polydipsia, syndróm neprimeranej sekrécie antidiuretického hormónu, MDMA a niektoré psychofarmaká môžu prispieť k hyponatriémii. Neurologické príznaky preto nemožno automaticky pripísať intoxikácii alebo psychóze. Rýchlosť korekcie musí zohľadniť závažnosť a pravdepodobné trvanie poruchy; nekontrolovaná rýchla korekcia chronickej hyponatriémie môže viesť k osmotickému demyelinizačnému syndrómu.</p>

<h3>Chronická choroba obličiek a dávkovanie</h3>

<p>Pri CKD sa môže meniť eliminácia psychofarmák aj liekov používaných v adiktológii. Dávkovanie sa musí posudzovať pre konkrétny liek a jeho aktívne metabolity; neexistuje jednotná „renálna dávka“ celej skupiny antipsychotík. Dehydratácia, infekcia, rabdomyolýza, nekontrolovaná hypertenzia a užívanie nesteroidových protizápalových liekov môžu renálne riziko ďalej zvyšovať. Nízky sérový kreatinín u pacienta so sarkopéniou alebo malnutríciou navyše môže viesť k nadhodnoteniu funkcie obličiek.</p>

<h3>Lítium vyžaduje osobitnú pozornosť</h3>

<p>Dehydratácia, vracanie, hnačka, znížený príjem sodíka, NSAID, inhibítory ACE, blokátory receptorov angiotenzínu a niektoré diuretiká môžu znížiť renálny klírens lítia a zvýšiť riziko toxicity. Pri poruche vedomia, novom hrubom tremore, ataxii, dysartrii, vracaní alebo inom neurologickom náleze treba vyšetriť koncentráciu lítia, elektrolyty a funkciu obličiek. Klinická závažnosť, najmä pri chronickej toxicite, nemusí presne zodpovedať jednej sérovej hodnote. Ťažká intoxikácia môže vyžadovať urgentnú konzultáciu klinického toxikológa a nefrológa a posúdenie mimotelovej eliminačnej liečby.</p>

<div class="pdf-avoid-break">
<h2>Rodina, ochrana detí a dospievajúci</h2>

<p>Rodinná intervencia môže zlepšiť porozumenie ochoreniu, rozpoznávanie relapsu a podporu liečby. Zapojenie rodiny musí rešpektovať dôvernosť informácií, bezpečnosť pacienta a jeho rozhodovaciu spôsobilosť. Ak je pacient rodičom alebo opatrovateľom dieťaťa či inej zraniteľnej osoby, posudzuje sa konkrétne fungovanie domácnosti a reálne riziká. Samotná psychiatrická diagnóza ani užívanie látok automaticky nedokazujú nespôsobilosť starať sa o dieťa.</p>
</div>

<p>U dospievajúcich treba zohľadniť vývojovú úroveň, telesnú hmotnosť, školské fungovanie, rodinné prostredie, traumu a schopnosť informovane rozhodovať. Britské organizačné stupne CAMHS ani odkazy NICE na britské právne predpisy nemožno mechanicky prenášať do slovenskej praxe.</p>

<h2>Praktický postup pri prvom kontakte</h2>

<ol>
  <li><strong>Zaistiť bezpečnosť:</strong> posúdiť vedomie, vitálne funkcie, intoxikáciu, abstinenciu, suicidálne a násilné riziko a možnosť delíria.</li>
  <li><strong>Zostaviť časovú os:</strong> látka, dávka, spôsob podania, posledná expozícia, spánok, lieky a vznik psychotických príznakov.</li>
  <li><strong>Vyžiadať objektívne údaje:</strong> dokumentácia a informácie od blízkych alebo zasahujúcich služieb, ak je to možné a právne prípustné.</li>
  <li><strong>Vyšetriť cielene:</strong> laboratórne a toxikologické testy voliť podľa klinickej otázky, nie ako automatický panel.</li>
  <li><strong>Liečiť oba problémy:</strong> psychiatrickú aj látkovú poruchu súčasne, so zrozumiteľným poradím intervencií podľa aktuálnej závažnosti.</li>
  <li><strong>Určiť koordinátora:</strong> zapísať zodpovednosti, kontakty, krízový plán a spôsob zdieľania informácií.</li>
  <li><strong>Predísť predávkovaniu:</strong> pred prepustením riešiť pokles tolerancie, rizikové kombinácie, pokračovanie liečby a naloxón, ak je dostupný.</li>
  <li><strong>Chrániť telesné zdravie:</strong> nastaviť metabolické, kardiálne, infekčné a renálne monitorovanie podľa liečby a expozície.</li>
</ol>

<h2>Čo zostáva neisté</h2>

<p>Odporúčanie NICE CG120 bolo publikované v roku 2011 a naposledy posúdené 7. mája 2024. Úpravy z roku 2024 boli formálne a redakčné a nemali meniť klinickú prax; nešlo o úplne nové systematické prehodnotenie všetkých dôkazov. Dokument preto nemusí v plnej miere zachytávať rýchly vývoj syntetických látok, súčasnú opioidovú epidemiológiu, digitálne intervencie ani novšie farmakologické štúdie.</p>

<p>Dôkazy o nadradenosti konkrétneho integrovaného modelu, psychosociálnej intervencie či antipsychotika zostávajú heterogénne. Silná stránka odporúčaní spočíva najmä v nediskriminácii, kontinuite kontaktu, koordinácii služieb, komplexnom hodnotení a súbežnej liečbe oboch porúch. Konkrétny detoxifikačný a farmakoterapeutický režim sa musí riadiť aktuálnymi diagnózovo špecifickými odporúčaniami a stavom pacienta.</p>

<h2>Záver</h2>

<p>Psychóza a problémové užívanie psychoaktívnych látok sa nemajú liečiť ako dve diagnózy, medzi ktorými pacient putuje bez jasnej zodpovednosti. Potrebuje jeden koordinovaný plán, priebežné prehodnocovanie diagnózy, psychiatrickú aj adiktologickú liečbu, sociálnu podporu a prevenciu predávkovania.</p>

<p>Telesné riziká sú súčasťou jadra starostlivosti. Hypertermia, rabdomyolýza, akútne poškodenie obličiek, hyponatriémia, respiračný útlm, liekové interakcie a toxicita lítia môžu byť bezprostredne život ohrozujúce. Ročná kontrola je iba minimálnym rámcom; rizikový pacient potrebuje kontroly podstatne častejšie.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=primarna-alebo-latkou-vyvolana-psychoza-diagnostika">Primárna alebo látkou vyvolaná psychóza?</a> – diferenciálna diagnostika a zásady akútnej liečby.</li>
  <li><a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">Chronická choroba obličiek ako samostatný faktor polyfarmácie</a>.</li>
  <li><a href="article.php?slug=cheatsheet-elektrolyty">Elektrolytové poruchy</a> – praktický prehľad diagnostiky a liečby.</li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>National Institute for Health and Care Excellence.</strong> <em>Coexisting severe mental illness (psychosis) and substance misuse: assessment and management in healthcare settings.</em> NICE Clinical Guideline CG120. Publikované 23. marca 2011, naposledy posúdené 7. mája 2024. <a href="https://www.nice.org.uk/guidance/cg120" target="_blank" rel="noopener noreferrer">NICE</a>.</li>
</ol>
</div>

<ol start="2">
  <li><strong>National Institute for Health and Care Excellence.</strong> <em>Coexisting severe mental illness and substance misuse: community health and social care services.</em> NICE Guideline NG58. Publikované 30. novembra 2016, naposledy posúdené 14. augusta 2024. <a href="https://www.nice.org.uk/guidance/ng58" target="_blank" rel="noopener noreferrer">NICE</a>.</li>
  <li><strong>National Institute for Health and Care Excellence.</strong> <em>Psychosis and schizophrenia in adults: prevention and management.</em> NICE Clinical Guideline CG178. <a href="https://www.nice.org.uk/guidance/cg178" target="_blank" rel="noopener noreferrer">NICE</a>.</li>
  <li><strong>Glenn E. Hunt, Nandi Siegfried, Kirsten Morley, Carrie Brooke-Sumner, Michelle Cleary.</strong> <em>Psychosocial interventions for people with both severe mental illness and substance misuse.</em> Cochrane Database of Systematic Reviews. 2019;(12):CD001088. doi: 10.1002/14651858.CD001088.pub4. <a href="https://pubmed.ncbi.nlm.nih.gov/31829430/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Reza Rafizadeh, Marlon Danilewitz, Chad A. Bousman, Nickie Mathew, Randall F. White, Anees Bahji, William G. Honer, Christian G. Schütz.</strong> <em>Effects of clozapine treatment on the improvement of substance use disorders other than nicotine in individuals with schizophrenia spectrum disorders: a systematic review and meta-analysis.</em> Journal of Psychopharmacology. 2023;37(2):135–143. doi: 10.1177/02698811221142575. <a href="https://pubmed.ncbi.nlm.nih.gov/36507548/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>William F. Pendergraft III, Leal C. Herlitz, Denyse Thornley-Brown, Mitchell Rosner, John L. Niles.</strong> <em>Nephrotoxic effects of common and emerging drugs of abuse.</em> Clinical Journal of the American Society of Nephrology. 2014;9(11):1996–2005. doi: 10.2215/CJN.00360114. <a href="https://pubmed.ncbi.nlm.nih.gov/25035273/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<ol start="7">
  <li><strong>National Institute for Health and Care Excellence.</strong> <em>Bipolar disorder: assessment and management.</em> NICE Clinical Guideline CG185, časť monitorovania lítia. <a href="https://www.nice.org.uk/guidance/cg185" target="_blank" rel="noopener noreferrer">NICE</a>.</li>
  <li><strong>Brian S. Decker, David S. Goldfarb, Paul I. Dargan a kol.; EXTRIP Workgroup.</strong> <em>Extracorporeal Treatment for Lithium Poisoning: Systematic Review and Recommendations from the EXTRIP Workgroup.</em> Clinical Journal of the American Society of Nephrology. 2015;10(5):875–887. doi: 10.2215/CJN.10021014. <a href="https://pubmed.ncbi.nlm.nih.gov/25583292/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Článok je odbornou syntézou viacerých odporúčaní a prehľadov, nie doslovným súhrnom jedného zdroja. NICE CG120 a NG58 poskytujú najmä klinický a organizačný rámec; dôkazy pre nadradenosť jednotlivých psychosociálnych alebo farmakologických intervencií sú obmedzené a heterogénne. Britské právne a organizačné odkazy sa musia pri použití prispôsobiť slovenským podmienkam. Text má informačný charakter a nenahrádza individuálne psychiatrické, adiktologické, toxikologické ani nefrologické posúdenie.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_psychoza-uzivanie-navykovych-latok-integrovana-starostlivost_article',
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
