<?php
/**
 * Odborny clanok: alopurinol u zivych darcov oblicky a hmotnost lavej komory (studia AL-DON).
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_alopurinol-zivi-darcovia-oblicky-lvm-al-don_article.php"
 */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vlozit alebo aktualizovat clanok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Alopurinol u živých darcov obličky znížil kyselinu močovú, no nezlepšil srdcovú štruktúru ani krvný tlak',
    'slug'         => 'alopurinol-zivi-darcovia-oblicky-lvm-al-don',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V randomizovanej štúdii AL-DON deväť mesiacov alopurinolu 300 mg u zdravých darcov obličky výrazne znížilo urikémiu, ale nezmenilo hmotnosť ľavej komory na magnetickej rezonancii, krvný tlak ani inzulínovú citlivosť. Nežiaduce udalosti boli častejšie v aktívnej vetve.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>V randomizovanej, dvojito zaslepenej, placebom kontrolovanej štúdii fázy 2b u zdravých živých darcov obličky deväťmesačná liečba alopurinolom 300 mg denne výrazne znížila sérovú kyselinu močovú, ale nezmenila hmotnosť ľavej komory meranú magnetickou rezonanciou, krvný tlak ani inzulínovú citlivosť. Výsledok pripomína, že zníženie biomarkera samo osebe nezaručuje zmenu orgánovej štruktúry.</em></p>

<h2>Prečo sa téma skúmala</h2>

<p>Darovanie obličky sa všeobecne považuje za bezpečné. Novšie práce však vyvolali otázku, či po darcovskej nefrektómii nenastáva nepriaznivý kardiovaskulárny vývoj vrátane nárastu hmotnosti ľavej komory a zvýšenia krvného tlaku, čo by mohlo prispievať k vyššej kardiovaskulárnej mortalite.</p>

<p>Zvýšená kyselina močová sa v pozorovacích štúdiách spája s vyššou hmotnosťou ľavej komory. Po nefrektómii urikémia typicky stúpa, pretože klesá renálna exkrécia urátu. Autori preto vyslovili hypotézu, že zníženie kyseliny močovej môže hmotnosť ľavej komory u darcov znížiť.</p>

<p>Otázka je legitímna aj preto, že staršie randomizované štúdie s alopurinolom pri hypertrofii ľavej komory u iných populácií dopadli pozitívne. Ako uvidíme nižšie, práve porovnanie s nimi vysvetľuje, prečo je tento výsledok negatívny.</p>

<h2>Dizajn a populácia štúdie AL-DON</h2>

<div class="table-responsive" role="region" aria-label="Základné parametre štúdie AL-DON" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Údaj</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Dizajn</th><td>jednocentrová randomizovaná, dvojito zaslepená, placebom kontrolovaná štúdia fázy 2b</td></tr>
    <tr><th scope="row">Randomizácia</th><td>1 : 1</td></tr>
    <tr><th scope="row">Trvanie liečby</th><td>9 mesiacov</td></tr>
    <tr><th scope="row">Počet účastníkov</th><td>71</td></tr>
    <tr><th scope="row">Populácia</th><td>zdraví darcovia obličky vo veku od 18 rokov, najmenej 6 mesiacov po nefrektómii, eGFR nad 30 ml/min/1,73 m²</td></tr>
    <tr><th scope="row">Intervencia</th><td>alopurinol 300 mg raz denne verzus placebo</td></tr>
    <tr><th scope="row">Primárny ukazovateľ</th><td>zmena hmotnosti ľavej komory od začiatku do 9. mesiaca, hodnotená magnetickou rezonanciou srdca</td></tr>
    <tr><th scope="row">Zadávateľ</th><td>Oslo University Hospital (Nórsko)</td></tr>
    <tr><th scope="row">Registrácia a realizácia</th><td>ClinicalTrials.gov NCT03353298; od januára 2018 do septembra 2020</td></tr>
  </tbody>
</table>
</div>

<p>Podľa registračného záznamu boli medzi sekundárne ukazovatele zaradené zmena krvného tlaku, odhad inzulínovej senzitivity (metabolická klírensová rýchlosť glukózy), počet a dávky antihypertenzív, <strong>zmena vylučovania albumínu močom</strong> a <strong>zmena eGFR</strong>. Posledné dva, pre nefrológiu najzaujímavejšie ukazovatele, publikovaný abstrakt neuvádza.</p>

<div class="pdf-avoid-break">
<h3>Išlo o skutočne zdravú populáciu</h3>

<p>Vylučovacie kritériá podľa registra boli prísne. Vylúčení boli darcovia s:</p>

<ul>
  <li>reakciou na alopurinol alebo iný inhibítor xantínoxidázy,</li>
  <li>liečbou znižujúcou kyselinu močovú v predchádzajúcich 3 mesiacoch,</li>
  <li>anamnézou dny, xantinúrie alebo inej indikácie na liečbu znižujúcu urikémiu,</li>
  <li>anamnézou obličkových konkrementov,</li>
  <li>anamnézou ischemickej choroby srdca,</li>
  <li>srdcovým zlyhávaním s ejekčnou frakciou ľavej komory pod 45 %,</li>
  <li>významnou chlopňovou chybou,</li>
  <li>klinicky významným ochorením pečene, HIV alebo závažnou systémovou infekciou.</li>
</ul>

<p>Populácia teda nemala ani indikáciu na liečbu znižujúcu urikémiu, ani zavedené kardiálne ochorenie. Táto skutočnosť je pre interpretáciu výsledku zásadná.</p>
</div>

<h2>Hlavné výsledky</h2>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky štúdie AL-DON" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Výsledok</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Kyselina močová</th><td>významne nižšia v skupine s alopurinolom; P &lt; 0,001</td></tr>
    <tr><th scope="row">Hmotnosť ľavej komory</th><td>alopurinol −0,25 g (± 4,4), placebo +1,04 g (± 4,2); P = 0,25</td></tr>
    <tr><th scope="row">Krvný tlak</th><td>bez rozdielu; P = 0,98</td></tr>
    <tr><th scope="row">Inzulínová citlivosť</th><td>bez rozdielu; P = 0,62</td></tr>
  </tbody>
</table>
</div>

<p>Všimnime si veľkosť rozdielu: medzi skupinami ide o približne 1,3 g hmotnosti ľavej komory pri smerodajnej odchýlke zmeny okolo 4,4 g. To je rozdiel, ktorý je nielen štatisticky nevýznamný, ale aj klinicky bezvýznamný — leží hlboko pod hranicou, ktorá by mohla čokoľvek znamenať pre prognózu. Nejde teda o „takmer významný“ výsledok, ale o presvedčivo nulový nález pri tejto veľkosti účinku.</p>

<h3>Bezpečnosť</h3>

<p>Nežiaduce udalosti sa vyskytli u 28 účastníkov (39 %), z toho u 18 v skupine s alopurinolom a u 10 v skupine s placebom. Tri udalosti boli hodnotené ako závažné a všetky sa vyskytli v skupine s alopurinolom.</p>

<p><em>Metodická poznámka:</em> publikovaný abstrakt uvádza pri týchto počtoch podiely 70 % a 37 %. Tie nezodpovedajú rovnomernému rozdeleniu 71 účastníkov do dvoch ramien približne po 35 a menovatele, z ktorých boli vypočítané, abstrakt neuvádza. Absolútne počty (18 oproti 10, tri závažné udalosti) sú preto spoľahlivejšie než uvedené percentá. Typy závažných udalostí abstrakt nešpecifikuje, a preto ich tu neuvádzame.</p>

<p>Aj pri malých číslach ide o pripomienku, že alopurinol nie je nevinný liek. Jeho najzávažnejšou komplikáciou je syndróm precitlivenosti vrátane DRESS, ktorý môže postihnúť aj obličky — tejto téme sa venuje samostatný článok uvedený nižšie.</p>

<div class="pdf-avoid-break">
<h2>Prečo bol výsledok negatívny? Porovnanie s predchádzajúcimi štúdiami</h2>

<p>Alopurinol pri hypertrofii ľavej komory nie je nová myšlienka. Predchádzajúce randomizované štúdie skupiny z Dundee dopadli pozitívne — ale v podstatne odlišných populáciách.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie randomizovaných štúdií s alopurinolom a hmotnosťou ľavej komory" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Populácia</th>
      <th scope="col">Dávka</th>
      <th scope="col">Výsledok na hmotnosť ľavej komory</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Kao a spol. 2011</th><td>CKD 3. štádia <strong>s hypertrofiou ľavej komory</strong></td><td>300 mg denne</td><td>zníženie</td></tr>
    <tr><th scope="row">Rekhraj a spol. 2013</th><td>ischemická choroba srdca <strong>s hypertrofiou ľavej komory</strong></td><td>600 mg denne</td><td>zníženie</td></tr>
    <tr><th scope="row">Szwejkowski a spol. 2013</th><td>diabetes 2. typu <strong>s hypertrofiou ľavej komory</strong></td><td>600 mg denne</td><td>zníženie</td></tr>
    <tr><th scope="row">AL-DON 2026</th><td>zdraví darcovia obličky <strong>bez známej hypertrofie</strong></td><td>300 mg denne</td><td>bez zmeny</td></tr>
  </tbody>
</table>
</div>

<p>Rozdiel je zreteľný a ponúka najprirodzenejšie vysvetlenie negatívneho výsledku: <strong>predchádzajúce štúdie zaraďovali pacientov s už prítomnou hypertrofiou ľavej komory, teda s priestorom na regresiu.</strong> Ak je východisková hmotnosť ľavej komory normálna — a u zdravých darcov bez kardiálneho ochorenia to možno predpokladať —, nemožno očakávať, že sa ešte zníži.</p>

<p>Druhým rozdielom je dávka: dve z troch pozitívnych štúdií použili 600 mg denne, AL-DON 300 mg. Nižšia dávka mohla priniesť menšiu inhibíciu xantínoxidázy a menší efekt na oxidačný stres. Tento argument však oslabuje skutočnosť, že Kao a spol. dosiahli pozitívny výsledok pri CKD aj s dávkou 300 mg.</p>

<p>Tretím rozdielom je trvanie a výber ukazovateľa. Deväť mesiacov je pri remodelácii myokardu na hranici toho, čo stačí — pozitívne štúdie trvali spravidla 9 až 12 mesiacov, takže samotné trvanie zrejme nie je hlavným vysvetlením.</p>
</div>

<h2>Metodologické zhodnotenie</h2>

<h3>Silné stránky</h3>

<ul>
  <li>randomizované a dvojito zaslepené usporiadanie s placebom znižuje riziko systematického skreslenia,</li>
  <li>magnetická rezonancia srdca je referenčnou metódou na meranie hmotnosti ľavej komory a je podstatne presnejšia než echokardiografia,</li>
  <li>vysoká presnosť merania znižuje potrebný počet účastníkov,</li>
  <li>overená účinnosť intervencie na cieľový biomarker — kyselina močová naozaj klesla, takže nejde o zlyhanie adherencie alebo dávkovania,</li>
  <li>mechanisticky zmysluplná otázka postavená na predchádzajúcich pozitívnych štúdiách,</li>
  <li>vopred registrovaný protokol.</li>
</ul>

<p>Bod o overenom účinku na biomarker je dôležitý: negatívny výsledok nemožno vysvetliť tým, že liek „nefungoval“. Fungoval — len sa to nepremietlo do zmeny srdcovej štruktúry.</p>

<h3>Obmedzenia</h3>

<ol>
  <li><strong>Malý súbor.</strong> Sedemdesiatjeden účastníkov je primeraných pre fázu 2b, ale nedovoľuje vylúčiť malý účinok. Vzhľadom na pozorovaný rozdiel približne 1,3 g však nejde o „takmer významný“ nález.</li>
  <li><strong>Trvanie 9 mesiacov.</strong> Nemusí postačovať, ak by účinok urátovej osi bol pomalší alebo závislý od dlhšej expozície.</li>
  <li><strong>Jednocentrový dizajn v jednej krajine.</strong> Nórski darcovia nemusia reprezentovať iné populácie.</li>
  <li><strong>Vysoko selektovaná populácia.</strong> Zdraví darcovia bez indikácie na liečbu znižujúcu urikémiu a bez kardiálneho ochorenia; výsledky nemožno prenášať na pacientov s pokročilejšou CKD, s hypertrofiou ľavej komory alebo s výraznejšou komorbiditou.</li>
  <li><strong>Náhradný ukazovateľ.</strong> Hmotnosť ľavej komory je mechanisticky relevantná, ale nie je klinickou príhodou. Štúdia nebola určená na hodnotenie mortality, infarktu ani cievnej mozgovej príhody.</li>
  <li><strong>Nepublikované renálne ukazovatele.</strong> Zmena albuminúrie a eGFR boli podľa registra sekundárnymi ukazovateľmi, ale v abstrakte sa neuvádzajú.</li>
  <li><strong>Odstup od realizácie po publikáciu.</strong> Štúdia sa skončila v septembri 2020, publikovaná bola v auguste 2026. Dôvod tohto odstupu nie je z abstraktu zrejmý.</li>
</ol>

<div class="pdf-avoid-break">
<h2>Vecná kontrola hlavných tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie hlavných tvrdení o štúdii AL-DON" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Alopurinol znižuje kyselinu močovú u živých darcov obličky</td><td><strong>Potvrdené</strong></td><td>Významné zníženie v aktívnej vetve; P &lt; 0,001</td></tr>
    <tr><td>Alopurinol nezmenil hmotnosť ľavej komory po 9 mesiacoch</td><td><strong>Potvrdené</strong></td><td>−0,25 g oproti +1,04 g; P = 0,25; rozdiel je aj klinicky bezvýznamný</td></tr>
    <tr><td>Alopurinol nezmenil krvný tlak</td><td><strong>Potvrdené</strong></td><td>P = 0,98</td></tr>
    <tr><td>Alopurinol nezlepšil inzulínovú citlivosť</td><td><strong>Potvrdené</strong></td><td>P = 0,62</td></tr>
    <tr><td>Liečba bola spojená s vyšším výskytom nežiaducich udalostí</td><td><strong>Podporené</strong></td><td>18 oproti 10 účastníkom; všetky tri závažné udalosti v aktívnej vetve; typy udalostí abstrakt neuvádza</td></tr>
    <tr><td>Negatívny výsledok znamená, že urát nespôsobuje kardiovaskulárne zmeny</td><td><strong>Nesprávna interpretácia</strong></td><td>Štúdia testovala jednu intervenciu v špecifickej populácii, na náhradný ukazovateľ a počas 9 mesiacov; kauzalitu urátu ako mediátora nevyvracia</td></tr>
    <tr><td>Výsledok popiera predchádzajúce pozitívne štúdie s alopurinolom</td><td><strong>Nie</strong></td><td>Tie zaraďovali pacientov s už prítomnou hypertrofiou ľavej komory, teda s priestorom na regresiu</td></tr>
    <tr><td>Alopurinol sa nemá po darovaní obličky používať vôbec</td><td><strong>Nepodporené</strong></td><td>Štúdia hovorí proti podávaniu <em>s cieľom kardiovaskulárnej prevencie</em>, nie proti bežným indikáciám (dna, urátová litiáza)</td></tr>
    <tr><td>Výsledok možno preniesť na pacientov s pokročilou CKD</td><td><strong>Nie</strong></td><td>Zaradení boli darcovia s eGFR nad 30 ml/min/1,73 m² bez kardiálneho ochorenia</td></tr>
  </tbody>
</table>
</div>
</div>

<h2>Nefrologický kontext</h2>

<p>Po darovaní obličky sa dlhodobo diskutujú tri okruhy:</p>

<ol>
  <li><strong>Pokles renálnej rezervy</strong> a adaptácia po nefrektómii vrátane hyperfiltrácie zvyšnej obličky.</li>
  <li><strong>Možné zvýšenie kardiovaskulárneho rizika</strong>, na ktoré upozornili štúdie CRIB-Donor a ďalšie práce hodnotiace hmotnosť ľavej komory po darovaní.</li>
  <li><strong>Úloha metabolických faktorov</strong> vrátane urátu v mechanizmoch ovplyvňujúcich vaskulárnu a myokardiálnu štruktúru.</li>
</ol>

<p>Urát je asociovaný s viacerými kardiovaskulárnymi fenotypmi vrátane hypertrofie a endotelovej dysfunkcie. Táto štúdia však v najlepšej dostupnej testovacej forme — randomizácia, zaslepenie, endpoint na magnetickej rezonancii — nedokázala, že by u darcov po deviatich mesiacoch alopurinol zmenil hmotnosť ľavej komory ani sledované kardiometabolické parametre.</p>

<p>Výsledok zapadá do širšieho vzorca posledných rokov. Dve veľké randomizované štúdie publikované v roku 2020 v <em>New England Journal of Medicine</em> — CKD-FIX u pacientov s chronickou chorobou obličiek 3. a 4. štádia a PERL u pacientov s diabetom 1. typu a včasnou až stredne pokročilou diabetickou chorobou obličiek — takisto nepreukázali klinicky významný prínos znižovania urátu alopurinolom na obličkové výsledky.</p>

<p>Asociácia medzi urikémiou a orgánovým poškodením teda nemusí byť príčinná. Zvýšený urát môže byť skôr <em>ukazovateľom</em> zníženej funkcie obličiek a metabolického rizika než jeho pôvodcom. AL-DON tento obraz dopĺňa o srdcovú štruktúru u darcov.</p>

<h2>Praktický záver</h2>

<ul>
  <li><strong>Zníženie kyseliny močovej alopurinolom je u darcov obličky dosiahnuteľné</strong> a liek účinkuje podľa očakávania.</li>
  <li><strong>Deväť mesiacov alopurinolu v dávke 300 mg denne však nepreukázalo</strong> regresiu hmotnosti ľavej komory ani zlepšenie krvného tlaku a inzulínovej citlivosti.</li>
  <li><strong>Liečbu znižujúcu urikémiu preto nemožno odporúčať darcom obličky iba s cieľom znížiť kardiovaskulárne riziko.</strong> Rozhodnutie má vychádzať z konkrétnych klinických indikácií, ako sú dnavá choroba alebo urátová litiáza, a z bezpečnostného profilu lieku.</li>
  <li>Bezpečnostný signál — všetky tri závažné udalosti v aktívnej vetve — pri chýbajúcom prínose ďalej posúva pomer prínosu a rizika v neprospech podávania bez indikácie.</li>
  <li>Sledovanie darcov má aj naďalej stáť na kontrole krvného tlaku, eGFR, albuminúrie, hmotnosti a metabolických rizikových faktorov, nie na farmakologickom ovplyvňovaní urikémie.</li>
</ul>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=dress-alopurinol-granulomatozna-ain-pankreatitida">DRESS syndróm po alopurinole: diagnostická pasca granulomatóznej intersticiálnej nefritídy s pankreatitídou</a></li>
  <li><a href="article.php?slug=genotypizacia-apol1-zivy-darca-oblicky">Genotypizácia APOL1 pri živom darovaní obličky: presnejšia stratifikácia, nie automatické vylúčenie</a></li>
  <li><a href="article.php?slug=transplantacia-oblicky-zaradenie-do-programu">Ako prebieha zaradenie do transplantačného programu na transplantáciu obličky</a></li>
  <li><a href="article.php?slug=nove-odporucania-hypertenzia-meranie-rozhodnutia">Nové odporúčania pre hypertenziu: menej improvizácie, viac presného merania a praktických rozhodnutí</a></li>
  <li><a href="article.php?slug=styridsat-rokov-transplantat-oblicky-ultra-dlhodobe-prezivanie">Štyridsať rokov s funkčným transplantátom obličky: čo ukazujú ultra-dlhodobí prežívajúci</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Langberg NE, Jenssen TG, Hopp E, Haugen A, Åsberg A, Birkeland KI, Hartmann A, Dahle DO.</strong> <em>A Randomized Controlled Trial to Evaluate Allopurinol vs Placebo on Left Ventricular Mass in Living Kidney Donors.</em> Kidney360. Publikované online 3. augusta 2026. doi: 10.34067/KID.0000001313. <a href="https://doi.org/10.34067/KID.0000001313" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42545761/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Oslo University Hospital.</strong> <em>A Randomized, Double-blind, Placebo-controlled, 9-month, Parallel Group Study of Allopurinol to Reduce Left Ventricular Mass in Living Kidney Donors (AL-DON).</em> ClinicalTrials.gov, NCT03353298. Zdroj zaraďovacích a vylučovacích kritérií a zoznamu sekundárnych ukazovateľov. <a href="https://clinicaltrials.gov/study/NCT03353298" target="_blank" rel="noopener noreferrer">Registračný záznam</a>.</li>
  <li><strong>Kao MP, Ang DS, Gandy SJ, Nadir MA, Houston JG, Lang CC, Struthers AD.</strong> <em>Allopurinol benefits left ventricular mass and endothelial dysfunction in chronic kidney disease.</em> J Am Soc Nephrol. 2011;22(7):1382–1389. doi: 10.1681/ASN.2010111185. Alopurinol 300 mg denne pri CKD 3. štádia s hypertrofiou ľavej komory. <a href="https://doi.org/10.1681/ASN.2010111185" target="_blank" rel="noopener noreferrer">Štúdia pri CKD</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/21719783/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Rekhraj S, Gandy SJ, Szwejkowski BR, Nadir MA, Noman A, Houston JG, Lang CC, George J, Struthers AD.</strong> <em>High-dose allopurinol reduces left ventricular mass in patients with ischemic heart disease.</em> J Am Coll Cardiol. 2013;61(9):926–932. doi: 10.1016/j.jacc.2012.09.066. Alopurinol 600 mg denne. <a href="https://doi.org/10.1016/j.jacc.2012.09.066" target="_blank" rel="noopener noreferrer">Štúdia pri ischemickej chorobe srdca</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/23449426/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Szwejkowski BR, Gandy SJ, Rekhraj S, Houston JG, Lang CC, Morris AD, George J, Struthers AD.</strong> <em>Allopurinol reduces left ventricular mass in patients with type 2 diabetes and left ventricular hypertrophy.</em> J Am Coll Cardiol. 2013;62(24):2284–2293. doi: 10.1016/j.jacc.2013.07.074. Alopurinol 600 mg denne. <a href="https://doi.org/10.1016/j.jacc.2013.07.074" target="_blank" rel="noopener noreferrer">Štúdia pri diabete 2. typu</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/23994420/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Moody WE, Ferro CJ, Edwards NC, Chue CD, Lin ELS, Taylor RJ, Cockwell P, Steeds RP, Townend JN; CRIB-Donor Study Investigators.</strong> <em>Cardiovascular Effects of Unilateral Nephrectomy in Living Kidney Donors.</em> Hypertension. 2016;67(2):368–377. doi: 10.1161/HYPERTENSIONAHA.115.06608. <a href="https://doi.org/10.1161/HYPERTENSIONAHA.115.06608" target="_blank" rel="noopener noreferrer">Štúdia CRIB-Donor</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/26754643/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Altmann U, Böger CA, Farkas S, Mack M, Luchner A, Hamer OW, Zeman F, Debl K, Fellner C, Jungbauer C, Banas B, Buchner S.</strong> <em>Effects of Reduced Kidney Function Because of Living Kidney Donation on Left Ventricular Mass.</em> Hypertension. 2017;69(2):297–303. doi: 10.1161/HYPERTENSIONAHA.116.08175. <a href="https://doi.org/10.1161/HYPERTENSIONAHA.116.08175" target="_blank" rel="noopener noreferrer">Nemecká kohorta darcov</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/28049698/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Badve SV, Pascoe EM, Tiku A, Boudville N, a spol.; CKD-FIX Study Investigators.</strong> <em>Effects of Allopurinol on the Progression of Chronic Kidney Disease.</em> N Engl J Med. 2020;382(26):2504–2513. doi: 10.1056/NEJMoa1915833. <a href="https://doi.org/10.1056/NEJMoa1915833" target="_blank" rel="noopener noreferrer">Štúdia CKD-FIX</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/32579811/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Doria A, Galecki AT, Spino C, Pop-Busui R, a spol.; PERL Study Group.</strong> <em>Serum Urate Lowering with Allopurinol and Kidney Function in Type 1 Diabetes.</em> N Engl J Med. 2020;382(26):2493–2503. doi: 10.1056/NEJMoa1916624. <a href="https://doi.org/10.1056/NEJMoa1916624" target="_blank" rel="noopener noreferrer">Štúdia PERL</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/32579810/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>Allopurinol Lowers Uric Acid Levels, Fails to Reduce Heart Risk.</em> Medscape, 2026. Sekundárny spravodajský zdroj použitý ako východisko, nie ako hlavný dôkaz. <a href="https://www.medscape.com/viewarticle/allopurinol-lowers-uric-acid-levels-fails-reduce-heart-risk-2026a1000rco" target="_blank" rel="noopener noreferrer">Spravodajské spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Dizajn, veľkosť súboru, dávka, trvanie, primárny ukazovateľ, hodnoty zmeny hmotnosti ľavej komory (−0,25 ± 4,4 g oproti +1,04 ± 4,2 g), hodnoty P pre kyselinu močovú, krvný tlak a inzulínovú citlivosť aj počty nežiaducich udalostí boli overené priamo proti abstraktu publikácie v Kidney360 (PubMed, PMID 42545761). Zadávateľ, obdobie realizácie, zaraďovacie a vylučovacie kritériá a zoznam sekundárnych ukazovateľov pochádzajú z registračného záznamu NCT03353298. Dávky a populácie porovnávaných starších randomizovaných štúdií boli overené proti ich abstraktom v PubMed. Typy troch závažných nežiaducich udalostí publikovaný abstrakt neuvádza, preto sa v texte neuvádzajú; podiely 70 % a 37 % sú prevzaté z abstraktu, ale ich menovatele nie sú uvedené a nezodpovedajú rovnomernému rozdeleniu 71 účastníkov. Autorstvo všetkých citovaných prác bolo overené cez PubMed a Crossref; mená neboli dopĺňané odhadom.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Ide o štúdiu fázy 2b s náhradným ukazovateľom u vysoko selektovanej populácie zdravých darcov obličky. Výsledok nie je podkladom na zmenu indikácií alopurinolu pri dne, urátovej litiáze ani pri iných uznaných indikáciách. Dávkovanie alopurinolu treba pri zníženej funkcii obličiek upravovať podľa platného súhrnu charakteristických vlastností lieku.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_alopurinol-zivi-darcovia-oblicky-lvm-al-don_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "------------------------------------------------------\n";
    echo 'Migracia clanku: ' . $articles[0]['title'] . "\n";
    echo "------------------------------------------------------\n";
    echo "Vysledok: $inserted vlozenych, $updated aktualizovanych z $total clankov.\n";
    echo "Preskocenych (bez zmeny):      $skipped\n";
    echo "Zaradenych do fronty aviz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "------------------------------------------------------\n\n";
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
