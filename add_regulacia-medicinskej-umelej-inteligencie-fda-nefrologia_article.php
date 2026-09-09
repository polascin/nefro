<?php
/**
 * Odborný článok: Regulácia medicínskej umelej inteligencie — diskusný dokument FDA a nefrologický kontext.
 */

// Ochrana – len admin alebo CLI
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
    'title'        => 'Regulácia medicínskej umelej inteligencie: čo by mal lekár vedieť a čo z toho plynie pre nefrológiu',
    'slug'         => 'regulacia-medicinskej-umelej-inteligencie-fda-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'FDA nereguluje umelú inteligenciu, ale zdravotnícke pomôcky. Diskusný dokument z augusta 2026 navrhuje dvojosový rizikový rámec a kompetenčné hodnotenie generatívnej AI. Čo to znamená pre nefrologickú prax.',
    'content'      => <<<'HTML'
<p>Umelá inteligencia sa rýchlo začleňuje do klinickej praxe — pri analýze obrazových vyšetrení, klinickej dokumentácii, predikcii rizika, podpore diagnostiky, triedení pacientov, monitorovaní vitálnych funkcií aj vo výskume. Podľa údajov Americkej lekárskej asociácie (AMA), ktoré cituje odborné spravodajstvo, viac než 80 % lekárov dnes uvádza profesionálne používanie takýchto nástrojov, zatiaľ čo v roku 2023 to bolo 38 %.</p>

<p>Regulačný rámec za technológiou zaostáva. Nie každý nástroj využívajúci umelú inteligenciu je zdravotníckou pomôckou, nie každý prešiel hodnotením bezpečnosti a účinnosti a povolenie uvedenia na trh neznamená, že nástroj je vhodný pre každého pacienta a každé pracovisko.</p>

<p>Americký Úrad pre kontrolu potravín a liečiv (FDA) uverejnil v auguste 2026 prostredníctvom svojho Centra pre pomôcky a rádiologické zdravie (CDRH) dokument <em>Considerations for the Regulation of Generative AI-Enabled Medical Devices</em>. Ten načrtáva možný budúci spôsob hodnotenia generatívnej umelej inteligencie v zdravotníckych pomôckach.</p>

<p><strong>Právny status dokumentu je pritom kľúčový.</strong> Dokument sám uvádza, že je určený výlučne na diskusiu, nepredstavuje návrh ani konečné usmernenie, nenavrhuje ani nezavádza zmeny politiky a <em>ani nerieši, či sú opísané prístupy v rámci existujúcich právomocí FDA, alebo by si vyžiadali nové zákonné splnomocnenie</em>. Ide teda o podklad na získanie spätnej väzby, nie o platné pravidlo. Verejné pripomienkovanie bolo podľa odborného spravodajstva otvorené do 19. októbra.</p>

<h2>1. FDA nereguluje umelú inteligenciu, ale zdravotnícke pomôcky</h2>

<p>Dokument to formuluje priamo: FDA nereguluje generatívnu umelú inteligenciu ako takú — reguluje zdravotnícke pomôcky vrátane tých, ktoré ju využívajú. Je to rovnaký prístup ako pri iných technológiách: úrad nereguluje softvér ako taký, hardvér ako taký ani umelú inteligenciu ako takú, ale výrobky, ktoré spĺňajú definíciu pomôcky podľa federálneho zákona o potravinách, liekoch a kozmetike.</p>

<p>Regulácia sa navyše uplatňuje na <strong>jednotlivé funkcie</strong> výrobku, nie na výrobok ako celok. Podľa usmernenia o pomôckach s viacerými funkciami je funkcia samostatný účel výrobku: produkt určený na ukladanie, prenos a analýzu údajov má tri funkcie. Niektoré z nich môžu byť zdravotníckou pomôckou, iné nie.</p>

<p>Rovnaký model umelej inteligencie preto môže mať odlišný regulačný status podľa toho, na čo je určený a ako sa používa. Výraz „umelá inteligencia schválená úradmi“ je tak spravidla príliš nepresný — schválená alebo povolená býva konkrétna pomôcka s konkrétnym zamýšľaným použitím, nie technológia.</p>

<h2>2. Dvojosový rizikový rámec: čo systém robí a aké sú následky chyby</h2>

<p>Jadrom dokumentu je návrh dvojosovej heuristiky. Prvá os opisuje <strong>činnosť</strong> systému a rastie zľava doprava podľa miery jeho samostatnosti. Druhá os opisuje <strong>závažnosť ujmy</strong>, ktorá môže vzniknúť pri spoľahnutí sa na nesprávny výstup. Riziko rastie od ľavého dolného rohu k pravému hornému.</p>

<div class="table-responsive" role="region" aria-label="Os činnosti v dvojosovom rizikovom rámci FDA" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória činnosti</th>
      <th scope="col">Čo systém robí</th>
      <th scope="col">Príklad</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Informačná, nedirektívna</th>
      <td>Poskytuje informáciu bez smerovania k činu</td>
      <td>Skóre rizika budúcej kardiovaskulárnej príhody</td>
    </tr>
    <tr>
      <th scope="row">Informačná, smerujúca k činu</th>
      <td>Formálne informuje, ale reálne smeruje k určitému konaniu</td>
      <td>Dôrazne formulované odporúčanie vyhľadať urgentnú starostlivosť</td>
    </tr>
    <tr>
      <th scope="row">Konajúca pod dohľadom</th>
      <td>Koná, ale pod priebežným dohľadom zdravotníckeho pracovníka</td>
      <td>Návrh objednávkového setu, ktorý lekár potvrdzuje</td>
    </tr>
    <tr>
      <th scope="row">Konajúca plne autonómne</th>
      <td>Koná samostatne bez priameho dohľadu</td>
      <td>Autonómne spustenie liečebného protokolu</td>
    </tr>
  </tbody>
</table>
</div>

<p>Os následkov ilustruje dokument názorne: nesprávne odporúčanie voľnopredajného prípravku na drobný príznak je niečo celkom iné než nesprávne odporúčanie na úpravu dávky inzulínu. Rovnako autonómne predpísanie antibiotika pri potvrdenej streptokokovej angíne môže mať podstatne nižšiu závažnosť než autonómne spustenie trombolytického protokolu pri cievnej mozgovej príhode — a to aj pri rovnakej miere dohľadu.</p>

<h3>Direktívnosť je kontinuum, nie prepínač</h3>

<p>CDRH upozorňuje, že hranica medzi „nedirektívnou“ informáciou a výstupom smerujúcim k činu nie je binárna. Dokument uvádza štyri stupne na tom istom príklade:</p>

<ol>
  <li>všeobecná informácia: „dávky lizinoprilu sa niekedy zvyšujú, ak tlak zostáva nad liečebným cieľom“,</li>
  <li>prepojenie na situáciu používateľa: „v podobných situáciách lekári často zvyšujú dávku lizinoprilu“,</li>
  <li>podpora konkrétneho konania: „odporúčam zvýšiť dávku lizinoprilu“,</li>
  <li>konkrétny pokyn: „zvýšte lizinopril z 10 mg na 20 mg denne“.</li>
</ol>

<p>Podstatné je, že miera direktívnosti podľa CDRH závisí <strong>od obsahu a kontextu výstupu, nie iba od toho, či zaznie slovo „odporúčam“, „mali by ste“ alebo „zvážte“</strong>. Úrad zároveň zvažuje, či doložka „poraďte sa so svojím lekárom“ alebo „nie som zdravotnícky pracovník“ vôbec robí výstup menej direktívnym.</p>

<h3>Tri spresnenia, ktoré sú pre nefrológiu obzvlášť dôležité</h3>

<p><strong>Meracie a signálové funkcie.</strong> Funkcie in vitro diagnostiky, merania a spracovania signálu produkujú formálne nedirektívne informácie, no CDRH ich napriek tomu zvažuje ako rizikovejšie: používateľ spravidla nedokáže nezávisle posúdiť, na akom základe výstup vznikol, a preto nemôže rozpoznať a odmietnuť nesprávny výsledok. To je presne situácia laboratórne odvodených renálnych parametrov.</p>

<p><strong>Generalista verzus špecialista.</strong> Funkcia, ktorej bezpečné použitie závisí od kontextualizácie špecialistom, môže predstavovať zvýšené riziko práve vtedy, keď ju používa lekár bez príslušnej špecializácie. Nefrologický nástroj v rukách nešpecialistu tak nemusí byť rovnako bezpečný ako u nefrológa — a naopak, môže zmysluplne rozšíriť prístup k odbornej znalosti tam, kde nefrológ nie je dostupný.</p>

<p><strong>Viackolové konverzácie.</strong> Konverzačný systém môže začať informačnou funkciou a v priebehu rozhovoru sa posunúť k funkcii smerujúcej k činu. CDRH preto zvažuje hodnotenie rizika naprieč realistickými priebehmi rozhovoru, nie iba na úrovni jednotlivých funkcií.</p>

<p>Dokument osobitne rieši aj <strong>eskalačné funkcie</strong>: pri rozhodovaní o vyhľadaní urgentnej starostlivosti záleží na oboch smeroch chyby. Nedostatočná eskalácia vedie k oneskorenej liečbe, nadmerná eskalácia k úzkosti pacienta, zbytočným vyšetreniam a výkonom, zbytočnému zaťaženiu urgentných príjmov a k erózii dôvery, ktorá môže časom znížiť ochotu vyhľadať pomoc vtedy, keď je potrebná.</p>

<h2>3. Kompetenčný prístup: benchmarking a klinické potvrdenie</h2>

<p>Klasické softvérové pomôcky majú ohraničené vstupy a pevné výstupy. Pri generatívných systémoch je rozsah možných vstupov a výstupov príliš veľký na vyčerpávajúce testovanie. CDRH preto zvažuje kompetenčný prístup inšpirovaný — na vysokej úrovni — tým, ako sa hodnotia a atestujú lekári: nie testovaním každého mysliteľného scenára, ale kombináciou štruktúrovaného hodnotenia znalostí, praxe pod dohľadom a priebežného hodnotenia po začatí samostatnej praxe.</p>

<p>Prístup má dve zložky: <strong>neklinický benchmarking pomôcky</strong> a <strong>klinické potvrdenie</strong>. Hodnotila by sa pritom výsledná pomôcka v podobe určenej na reálne nasadenie, nie samotný základový model ani izolovaný podkomponent.</p>

<div class="table-responsive" role="region" aria-label="Prvky benchmarkingu podľa diskusného dokumentu FDA" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória</th>
      <th scope="col">Jednotlivé prvky</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Bezpečnosť</th>
      <td>Rozpoznanie bezpečnostne kritických situácií a eskalácia; udržanie rozsahu a rešpektovanie hraníc; kalibrácia, komunikovanie neistoty a odovzdanie rozhodnutia klinikovi</td>
    </tr>
    <tr>
      <th scope="row">Klinická spôsobilosť</th>
      <td>Klinické znalosti a vernosť zadanej úlohe; zber informácií a klinická analýza; kvantitatívna a meracia analýza; kvalita komunikácie a porozumenie zo strany používateľa</td>
    </tr>
    <tr>
      <th scope="row">Generalizovateľnosť</th>
      <td>Robustnosť, spoľahlivosť a reprodukovateľnosť; výkonnosť v podskupinách</td>
    </tr>
    <tr>
      <th scope="row">Agentické schopnosti</th>
      <td>Doplnkové kompetencie, ktoré sa týkajú iba agentických systémov</td>
    </tr>
  </tbody>
</table>
</div>

<p>Kategórie sú teda štyri; komunikácia a zrozumiteľnosť nie sú samostatnou kategóriou, ale prvkom klinickej spôsobilosti. Nie všetky prvky by sa uplatnili na každú pomôcku — voľba by závisela od zamýšľaného použitia a rizikového profilu.</p>

<p>CDRH zároveň upozorňuje na úskalie verejne dostupných benchmarkov: kontamináciu údajov, saturáciu a obmedzenú reprezentatívnosť reálnych podmienok.</p>

<h3>Klinické potvrdenie nemusí vždy znamenať prospektívnu štúdiu</h3>

<p>Dokument uvádza možné prístupy zoradené približne podľa rastúcej prísnosti a expozície pacientov:</p>

<ol>
  <li><strong>Retrospektívne hodnotenie na reálnych vstupoch pacientov</strong> s porovnaním proti referenčnému štandardu alebo expertnej adjudikácii.</li>
  <li><strong>Tiché nasadenie</strong> (<em>shadow deployment</em>): systém pracuje v živom klinickom procese na reálnych pacientoch, ale jeho výstupy sa klinikom ani pacientom nezobrazujú a neovplyvňujú starostlivosť; zaznamenávajú sa a porovnávajú so skutočnými rozhodnutiami a následnými výsledkami.</li>
  <li><strong>Štandardizované interakcie s figurantmi</strong> v úlohe pacienta.</li>
  <li><strong>Adjudikácia reálnych prípadov klinikmi</strong>, prípadne zaslepená voči výstupom systému.</li>
  <li><strong>Prospektívna klinická štúdia</strong>, v niektorých prípadoch randomizovaná.</li>
</ol>

<p>Otvorenou otázkou zostáva, voči čomu sa má výkonnosť porovnávať. CDRH zvažuje porovnanie s panelom kvalifikovaných klinikov, s mediánovým lekárom v praxi, prípadne s bežným štandardom starostlivosti — a osobitne rieši, či sa má hodnotiť <strong>tím človek a stroj</strong>, alebo systém pracujúci sám.</p>

<h3>Monitorovanie po uvedení na trh</h3>

<p>Vzhľadom na to, že generatívne systémy sa po nasadení menia, dokument zvažuje väčšie spoliehanie sa na dohľad po uvedení na trh. Navrhované prístupy zahŕňajú periodické opakovanie benchmarkingu, periodické hodnotenie vzoriek reálnych vstupov a výstupov nezávislými klinikmi a monitorovanie degradácie výkonnosti (driftu) v dôsledku zmien vstupnej populácie alebo dátového prostredia.</p>

<p>Zmeny pomôcky sa pritom delia na zámerné úpravy sponzorom, na priebežnú evolúciu modelu a — čo je osobitne dôležité — na zmeny vyplývajúce z aktualizácie <strong>základového modelu tretej strany</strong>, ktoré nemusí iniciovať výrobca pomôcky. Dokument tiež výslovne uvádza, že zodpovednosť za ekosystém je zdieľaná: úlohu majú kliniki, pacienti, zdravotnícke inštitúcie, platitelia, odborné spoločnosti, normalizačné orgány aj federálne a štátne úrady.</p>

<h2>4. Povolenie na trhu nie je dôkazom klinickej vhodnosti</h2>

<p>Lekár by nemal predpokladať, že každý nástroj predávaný v zdravotníctve niekto overil. Odborníci citovaní v odbornom spravodajstve to formulujú priamo: mnohé nástroje na podporu klinického rozhodovania stoja mimo dohľadu FDA, rovnako ako všeobecné generatívne nástroje typu ChatGPT, a tvrdenia výrobcov a dodávateľov treba brať s rezervou, pretože majú motiváciu schopnosti svojich produktov nadhodnocovať a nemusia byť povinní ich doložiť.</p>

<p>Aj keď výrobok pod reguláciu spadá, požiadavky jednotlivých ciest sa líšia:</p>

<div class="table-responsive" role="region" aria-label="Hlavné regulačné cesty pre zdravotnícke pomôcky v USA" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Cesta</th>
      <th scope="col">Podstata posúdenia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">510(k)</th>
      <td>Preukázanie podstatnej rovnocennosti s už existujúcou pomôckou. Touto cestou prešla väčšina pomôcok s umelou inteligenciou; predtrhové posúdenie je spravidla menej náročné než pri ostatných hlavných cestách.</td>
    </tr>
    <tr>
      <th scope="row">De Novo</th>
      <td>Nové pomôcky s nízkym až stredným rizikom, ktoré nemajú vhodný predchádzajúci výrobok na porovnanie.</td>
    </tr>
    <tr>
      <th scope="row">Premarket Approval (PMA)</th>
      <td>Pomôcky s vyšším rizikom; vyžaduje komplexnejšie preukázanie bezpečnosti a účinnosti.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Cesta 510(k) nie je „nevedecká“ — je to iný typ posúdenia, ktorého jadrom je porovnanie s existujúcou pomôckou. To však znamená, že samotné povolenie nemusí byť podložené rozsiahlymi prospektívnymi štúdiami v podmienkach každodennej praxe. Kritika sa dlhodobo týka aj toho, že používatelia nemusia dostať podstatné informácie o bezpečnom používaní vrátane zloženia tréningových údajov podľa pohlavia, rasy a etnicity; jedným z navrhovaných riešení sú štandardizované označenia typu „AI Facts“ podľa vzoru výživových údajov na potravinách.</p>

<p>Zásadné je rozlíšenie medzi <strong>validačnou štúdiou a dôkazom zlepšenia klinických výsledkov</strong>. Nástroj môže mať výbornú diskrimináciu v testovacom súbore, a pritom neznižovať mortalitu, komplikácie ani počet hospitalizácií.</p>

<h2>5. Štáty USA si tvoria vlastné pravidlá</h2>

<p>Federálny rámec nie je jedinou vrstvou regulácie. Podľa Národnej konferencie štátnych zákonodarných zborov prijalo v roku 2025 zákony týkajúce sa umelej inteligencie v zdravotníctve najmenej desať štátov a v priebehu tohto roka ich podľa organizácie Transparency Coalition nasledovalo vyše tucta ďalších.</p>

<ul>
  <li><strong>Utah</strong> vyžaduje, aby chatboty v oblasti duševného zdravia zverejnili, že používateľ komunikuje s umelou inteligenciou, nie s človekom.</li>
  <li><strong>Kalifornia</strong> zaviedla podobné obmedzenia vrátane zákazu používať slová, tituly alebo označenia ako „doktor“, ktoré by mohli vyvolať dojem, že ide o licencovaného zdravotníckeho pracovníka.</li>
  <li><strong>Rhode Island</strong> prijal v júni zákon ukladajúci poskytovateľom povinnosť informovať pacienta o použití nástroja na automatický prepis návštevy. Zákon nadväzuje na viaceré žaloby proti zdravotníckym systémom pre nahrávanie návštev bez primeraného upozornenia a súhlasu.</li>
  <li><strong>Colorado</strong> reguluje umelú inteligenciu pri rozhodovaní o úhradách: od roku 2027 musí posudzovanie využitia zohľadňovať individuálne klinické okolnosti pacienta, nie skupinové údaje, a zamietnutie pre lekársku nevyhnutnosť sa nesmie opierať výlučne o výstup systému bez posúdenia kvalifikovaným licencovaným pracovníkom.</li>
  <li><strong>Utah</strong> súčasne pilotne skúša opačný smer — účasť umelej inteligencie na rozhodovaní o obnovení niektorých existujúcich receptov.</li>
</ul>

<p>Federácia štátnych lekárskych komôr (FSMB) zriadila v máji pracovnú skupinu pre umelú inteligenciu s dôrazom na nástroje vykonávajúce klinické funkcie s obmedzeným alebo žiadnym priamym dohľadom lekára; návrh usmernenia sa očakáva na verejné pripomienkovanie začiatkom roka 2027.</p>

<p>Uvedené príklady nemožno zovšeobecniť na všetky štáty a ich aktuálne znenie treba overiť v oficiálnych predpisoch. Vždy treba rozlišovať medzi platným zákonom, vykonávacím predpisom, návrhom regulácie, odborným stanoviskom, pilotným projektom a odporúčaním profesijnej organizácie.</p>

<h3>Európsky kontext</h3>

<p>Podobná viacvrstvovosť platí aj v Európe. Používanie umelej inteligencie v zdravotníctve môže súčasne podliehať pravidlám pre zdravotnícke pomôcky, ochrane osobných údajov, kybernetickej bezpečnosti, pravidlám klinického skúšania a zodpovednosti za škodu.</p>

<p>Nariadenie (EÚ) 2024/1689, akt o umelej inteligencii, vytvára rizikový rámec pre systémy umelej inteligencie. Neznamená to však, že každý medicínsky nástroj má rovnaký právny status — pri zdravotníckych pomôckach treba posudzovať aj vzťah k nariadeniu o zdravotníckych pomôckach a k príslušným postupom posudzovania zhody.</p>

<h2>Zodpovednosť za chybný výstup</h2>

<p>Najťažšia otázka znie: kto zodpovedá, ak umelá inteligencia poškodí pacienta? Odpoveď nemožno zredukovať na to, že vždy zodpovedá lekár alebo vždy výrobca.</p>

<p>Návrh politiky, ktorý v júni posudzovala Washingtonská lekárska komisia, uvádzal, že lekári a ďalší držitelia licencie zostávajú pri používaní nástrojov umelej inteligencie „plne a výlučne“ zodpovední za klinický úsudok a výsledky starostlivosti. Súčasne im ukladal <strong>vyhľadať a preštudovať dokumentáciu o validovaných spôsoboch použitia nástroja, jeho výkonnostných ukazovateľoch a známych režimoch zlyhania</strong> — a ak dodávateľ tieto údaje neposkytne, zvážiť úplné upustenie od jeho používania, individuálne aj na úrovni organizácie. Nešlo o všeobecne platné pravidlo pre celé USA.</p>

<p>Generálny riaditeľ AMA na návrh reagoval kriticky. Podporil zachovanie lekárskeho dohľadu nad umelou inteligenciou, ale odmietol prenesenie plnej zodpovednosti za chyby na klinikov — najmä ak je nástroj zabudovaný do klinického procesu alebo nariadený zamestnávateľom. Podľa neho by taký prístup zaobchádzal s umelou inteligenciou inak než s akýmkoľvek iným zdravotníckym produktom a v podstate by zbavoval technológie zodpovednosti za ich vlastnú výkonnosť. Namiesto toho navrhol posudzovať zodpovednosť <strong>podľa toho, kto je v najlepšom postavení poznať riziko nástroja a predísť ujme alebo ju zmierniť</strong>.</p>

<p>Pri konkrétnom posúdení tak zaváži, aký bol účel systému, či bol riadne overený, či sa používal v rámci deklarovaného použitia, či lekár dostal dostatočné informácie o obmedzeniach, či zariadenie jeho používanie nariadilo, či výrobca zatajil známe zlyhania, či došlo k neprimeranej aktualizácii modelu, či existoval primeraný ľudský dohľad a či lekár mohol výstup rozumne overiť.</p>

<h2>Osobitný význam pre nefrológiu</h2>

<p>Nefrológia patrí medzi oblasti, kde môže byť umelá inteligencia užitočná, ale kde nesprávny výstup môže viesť k závažnej ujme. Do úvahy prichádza predikcia progresie chronickej choroby obličiek, odhad rizika akútneho poškodenia obličiek, analýza trendov kreatinínu, albuminúrie a eGFR, interpretácia zobrazovacích vyšetrení, podpora rozhodovania pri transplantácii, predikcia komplikácií hemodialýzy, sumarizácia dokumentácie aj komunikácia s pacientom.</p>

<h3>eGFR a renálne biomarkery</h3>

<p>Algoritmus môže byť ovplyvnený zmenami laboratórnych metód, rozdielmi medzi analyzátormi, chýbajúcimi údajmi, akútnymi zmenami hydratácie, svalovou hmotou aj neštandardnými klinickými situáciami.</p>

<p>Výpočet eGFR nie je priamym meraním skutočnej glomerulovej filtrácie. Model validovaný na stabilných ambulantných pacientoch nemusí byť vhodný pri akútnom poškodení obličiek, na dialýze, pri extrémnej svalovej hmote ani pri rýchlych zmenách kreatinínu. Ide presne o typ funkcie, ktorú diskusný dokument zaraďuje medzi meracie funkcie so zvýšeným rizikom — používateľ totiž nedokáže nezávisle posúdiť, na akom základe výstup vznikol.</p>

<h3>Hemodialýza</h3>

<p>Pri systémoch podporujúcich dialyzačné rozhodovanie treba osobitne hodnotiť falošne negatívne aj falošne pozitívne výstrahy, vplyv výstupu na ultrafiltráciu, riziko intradialyzačnej hypotenzie, elektrolytové poruchy, kvalitu cievneho prístupu, odlišnosti medzi pracoviskami a prenositeľnosť na rôzne typy dialyzačných monitorov.</p>

<p>Výstup systému nesmie byť automaticky považovaný za náhradu klinického posúdenia objemového stavu a hemodynamiky pacienta.</p>

<h3>Dialyzované a transplantované populácie</h3>

<p>Dialyzovaní a transplantovaní pacienti bývajú v bežných databázach nedostatočne zastúpení. Model preto môže mať horšiu výkonnosť práve u pacientov s vysokou polymorbiditou, častými hospitalizáciami, atypickými laboratórnymi hodnotami, odlišnou farmakokinetikou, premenlivým objemovým stavom a imunosupresívnou liečbou. Dobrá výkonnosť v celkovej populácii nie je dôkazom vhodnosti pre nefrologických pacientov — čo zodpovedá tomu, že FDA zaraďuje <em>výkonnosť v podskupinách</em> medzi samostatné prvky benchmarkingu.</p>

<h2>Praktický kontrolný zoznam pre pracovisko</h2>

<p>Pred zavedením nástroja s umelou inteligenciou by pracovisko malo poznať:</p>

<ol>
  <li>presné zamýšľané použitie systému,</li>
  <li>pre koho je určený a kto ho bude reálne používať (špecialista verzus nešpecialista),</li>
  <li>rozhodnutia, ktoré môže ovplyvniť, a mieru jeho samostatnosti,</li>
  <li>regulačný status výrobku a cestu, ktorou ho získal,</li>
  <li>výsledky externej a lokálnej validácie,</li>
  <li>výkonnosť v relevantných podskupinách pacientov,</li>
  <li>známe kontraindikácie a režimy zlyhania,</li>
  <li>spôsob označenia neistoty a odovzdania rozhodnutia klinikovi,</li>
  <li>pravidlá ľudského dohľadu,</li>
  <li>spôsob dokumentovania použitia výstupu,</li>
  <li>proces hlásenia incidentov,</li>
  <li>pravidlá aktualizácie modelu vrátane zmien základového modelu tretej strany,</li>
  <li>ochranu osobných údajov a kybernetickú bezpečnosť,</li>
  <li>plán monitorovania výkonnosti a driftu po zavedení.</li>
</ol>

<p>Prakticky sa oplatí začať kontrolovaným pilotom alebo tichým nasadením, pri ktorom výstup systému neovplyvňuje starostlivosť. Až po overení lokálnej výkonnosti možno zvažovať jeho začlenenie do klinického rozhodovania. Ide o rovnaký princíp, aký FDA zvažuje ako jeden zo spôsobov klinického potvrdenia.</p>

<h2>Čo požadovať od dodávateľa</h2>

<p>Dodávateľ by mal vedieť poskytnúť opis zamýšľaného použitia, technickú dokumentáciu, údaje o tréningovej a validačnej populácii, výsledky podľa pohlavia, veku a relevantných klinických skupín, informácie o kalibrácii, údaje o falošne pozitívnych a falošne negatívnych výsledkoch, opis známych režimov zlyhania, pravidlá aktualizácie modelu, spôsob sledovania degradácie výkonnosti, informácie o uchovávaní a spracúvaní údajov a kontaktný postup pri bezpečnostnom incidente.</p>

<p>Ak dodávateľ neposkytne ani základné informácie o overení, obmedzeniach a zlyhaniach, používanie nástroja má byť veľmi opatrné. Samotné marketingové tvrdenie o „klinicky overenej umelej inteligencii“ nemá dostatočnú informačnú hodnotu.</p>

<h2>Záver</h2>

<p>Regulácia medicínskej umelej inteligencie sa presúva od otázky, či sa výrobok označuje ako AI, k otázkam jeho zamýšľaného použitia, miery samostatnosti a závažnosti možnej ujmy. FDA pri generatívnej umelej inteligencii zvažuje rizikovo orientovaný dvojosový rámec a kompetenčné hodnotenie kombinujúce neklinický benchmarking, klinické potvrdenie a dlhodobé monitorovanie po nasadení.</p>

<p>Zatiaľ však nejde o platnú regulačnú požiadavku — dokument je výslovne diskusný a sám neriešil ani to, či by opísané prístupy boli v rámci existujúcich právomocí úradu. Lekár preto nesmie zamieňať regulačné povolenie konkrétnej pomôcky s dôkazom, že nástroj zlepšuje klinické výsledky v jeho vlastnej populácii pacientov.</p>

<p>V nefrológii má umelá inteligencia potenciál zlepšiť predikciu, dokumentáciu aj organizáciu starostlivosti. Pri rozhodnutiach týkajúcich sa dialýzy, liekov, transplantácie alebo akútneho poškodenia obličiek však musí zostať súčasťou riadeného klinického procesu s jasne určeným ľudským dohľadom, dokumentovanými obmedzeniami a priebežným hodnotením bezpečnosti.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=umela-inteligencia-nefrologia-co-vieme-limity">Umelá inteligencia v nefrológii: čo už vieme, kde sú limity a kam to smeruje</a></li>
  <li><a href="article.php?slug=ai-scribe-pravne-nastrahy-ambulancia-nefrologia">Právne nástrahy pri používaní AI scribov v ambulancii a čo z toho plynie pre nefrologickú prax</a></li>
  <li><a href="article.php?slug=ai-nefrologia-hands-on-primer-klinicka-integracia">AI v nefrológii v praxi: čo prináša „Hands-On Primer“ pre klinické myslenie a bezpečnú integráciu</a></li>
  <li><a href="article.php?slug=estop-aki-strojove-ucenie-vcasna-konzultacia-nefrologa">ESTOP-AKI: algoritmus riziko rozpoznal, včasná konzultácia nefrológa však výsledky nezlepšila</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>U.S. Food and Drug Administration, Center for Devices and Radiological Health. Considerations for the Regulation of Generative AI-Enabled Medical Devices: Discussion Paper and Request for Feedback. August 2026. <a href="https://www.fda.gov/media/194242/download" target="_blank" rel="noopener noreferrer">plný text</a>. Inštitucionálny autor; dokument je výslovne označený ako diskusný a nepredstavuje návrh ani konečné usmernenie. Hlavný spracovaný zdroj.</em></small></li>
  <li><small><em>Weber S. 5 Things Doctors Should Know About Medical AI Regulation. Medscape Medical News, 4. septembra 2026. <a href="https://www.medscape.com/viewarticle/5-things-doctors-should-know-about-medical-ai-regulation-2026a1000wxy" target="_blank" rel="noopener noreferrer">Medscape</a>. Odborné publicistické spracovanie, nie recenzovaná vedecká publikácia; zdroj údajov o štátnych zákonoch, termíne pripomienkovania a stanoviskách AMA a FSMB.</em></small></li>
  <li><small><em>Patel B, Blumenthal D. A Novel Approach to Overseeing the Clinical Application of Generative AI. JAMA Health Forum. 2026;7(3):e256947. doi: 10.1001/jamahealthforum.2025.6947. <a href="https://doi.org/10.1001/jamahealthforum.2025.6947" target="_blank" rel="noopener noreferrer">DOI</a>. Návrh kompetenčnej regulácie podľa vzoru lekárskeho vzdelávania a licencovania.</em></small></li>
  <li><small><em>Bergman A, Wachter RM, Emanuel EJ. A Licensure Framework for Autonomous Clinical AI. JAMA. 2026;335(20):1751–1754. doi: 10.1001/jama.2026.5483. <a href="https://doi.org/10.1001/jama.2026.5483" target="_blank" rel="noopener noreferrer">DOI</a>. Rámec s vymedzeným rozsahom praxe, časovo obmedzenou certifikáciou a zodpovednosťou vývojárov aj zavádzajúcich inštitúcií.</em></small></li>
  <li><small><em>Freyer O, Jayabalan S, Kather JN, Gilbert S. Overcoming regulatory barriers to the implementation of AI agents in healthcare. Nature Medicine. 2025;31(10):3239–3243. doi: 10.1038/s41591-025-03841-1. <a href="https://doi.org/10.1038/s41591-025-03841-1" target="_blank" rel="noopener noreferrer">DOI</a>. Diskusný dokument FDA cituje túto prácu skrátene ako „Freyer O, Jayabalan S, et al.“; úplný zoznam štyroch autorov je overený cez Crossref.</em></small></li>
  <li><small><em>U.S. Food and Drug Administration. Policy for Device Software Functions and Mobile Medical Applications. <a href="https://www.fda.gov/regulatory-information/search-fda-guidance-documents/policy-device-software-functions-and-mobile-medical-applications" target="_blank" rel="noopener noreferrer">Usmernenie FDA</a>.</em></small></li>
  <li><small><em>U.S. Food and Drug Administration. Multiple Function Device Products: Policy and Considerations. <a href="https://www.fda.gov/regulatory-information/search-fda-guidance-documents/multiple-function-device-products-policy-and-considerations" target="_blank" rel="noopener noreferrer">Usmernenie FDA</a>.</em></small></li>
  <li><small><em>U.S. Food and Drug Administration. Artificial Intelligence-Enabled Medical Devices. <a href="https://www.fda.gov/medical-devices/software-medical-device-samd/artificial-intelligence-enabled-medical-devices" target="_blank" rel="noopener noreferrer">Zoznam FDA</a>. Zaradenie výrobku do zoznamu neznamená všeobecné schválenie umelej inteligencie ani dôkaz vhodnosti pre všetky klinické indikácie.</em></small></li>
  <li><small><em>U.S. Food and Drug Administration. FDA Digital Health and Artificial Intelligence Glossary: Educational Resource. <a href="https://www.fda.gov/science-research/artificial-intelligence-and-medical-products/fda-digital-health-and-artificial-intelligence-glossary-educational-resource" target="_blank" rel="noopener noreferrer">Terminologický zdroj FDA</a>.</em></small></li>
  <li><small><em>Európsky parlament a Rada Európskej únie. Nariadenie (EÚ) 2024/1689, ktorým sa stanovujú harmonizované pravidlá v oblasti umelej inteligencie (akt o umelej inteligencii). 2024. <a href="https://eur-lex.europa.eu/eli/reg/2024/1689/oj" target="_blank" rel="noopener noreferrer">EUR-Lex</a>.</em></small></li>
  <li><small><em>World Health Organization. Ethics and Governance of Artificial Intelligence for Health. Ženeva: World Health Organization; 2021. <a href="https://www.who.int/publications/i/item/9789240029200" target="_blank" rel="noopener noreferrer">WHO</a>.</em></small></li>
  <li><small><em>National Institute of Standards and Technology. Artificial Intelligence Risk Management Framework (AI RMF 1.0). NIST AI 100-1. 2023. <a href="https://www.nist.gov/itl/ai-risk-management-framework" target="_blank" rel="noopener noreferrer">NIST</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_regulacia-medicinskej-umelej-inteligencie-fda-nefrologia_article',
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
