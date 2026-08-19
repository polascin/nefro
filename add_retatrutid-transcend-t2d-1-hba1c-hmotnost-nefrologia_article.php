<?php
/**
 * Odborny clanok: retatrutid v studii TRANSCEND-T2D-1 - kriticke zhodnotenie a nefrologicke suvislosti.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_retatrutid-transcend-t2d-1-hba1c-hmotnost-nefrologia_article.php"
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
    'title'        => 'Retatrutid pri diabete 2. typu: výrazný pokles HbA1c a telesnej hmotnosti, kardiorenálny prínos však zatiaľ nepoznáme',
    'slug'         => 'retatrutid-transcend-t2d-1-hba1c-hmotnost-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Trojitý agonista receptorov GIP, GLP-1 a glukagónu znížil v štúdii fázy 3 TRANSCEND-T2D-1 HbA1c o 1,94 percentuálneho bodu a hmotnosť o 15,3 %. Ide o selektovanú populáciu s včasným diabetom, 40-týždňové sledovanie a porovnanie iba s placebom, bez kardiorenálnych výsledkov.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Retatrutid dosiahol v prvej štúdii fázy 3 pri diabete 2. typu výrazné metabolické účinky. Výsledky sa však týkajú selektovanej populácie s včasným diabetom liečeným iba režimovými opatreniami, krátkeho 40-týždňového sledovania a porovnania s placebom, nie s aktívnou liečbou. Retatrutid zostáva skúšaným liekom bez preukázanej ochrany obličiek alebo kardiovaskulárneho systému.</em></p>

<p>Tento článok je podrobným kritickým rozborom štúdie TRANSCEND-T2D-1 so zameraním na nefrologické súvislosti. Prehľadové spracovanie oboch retatrutidových štúdií prezentovaných na kongrese ADA 2026 nájdete v článku <a href="article.php?slug=retatrutid-ubytok-hmotnosti-metabolicke-benefity">Retatrutid prináša výrazný úbytok hmotnosti aj metabolické benefity</a>.</p>

<h2>Čo je retatrutid</h2>

<p>Retatrutid, pôvodne označovaný ako LY3437943, je podkožne podávaný peptid, ktorý súčasne aktivuje tri hormonálne receptory:</p>

<ul>
  <li><strong>receptor GLP-1</strong> — podporuje glukózo-dependentnú sekréciu inzulínu, znižuje neprimeranú sekréciu glukagónu pri hyperglykémii, spomaľuje vyprázdňovanie žalúdka a tlmí príjem potravy;</li>
  <li><strong>receptor GIP</strong> — ovplyvňuje inzulínovú odpoveď, energetický metabolizmus a funkciu tukového tkaniva;</li>
  <li><strong>glukagónový receptor</strong> — môže podporovať mobilizáciu tukových zásob a energetický výdaj, ale súčasne môže stimulovať hepatálnu tvorbu glukózy a ovplyvňovať srdcovú frekvenciu.</li>
</ul>

<p>Výsledný klinický účinok nie je jednoduchým súčtom účinkov troch hormónov. Závisí od relatívnej aktivity molekuly na jednotlivých receptoroch, od dávky, farmakokinetiky a fyziologickej odpovede pacienta.</p>

<p>Retatrutid nemožno zamieňať s agonistami receptora GLP-1, ako sú semaglutid alebo dulaglutid, ani s duálnym agonistom GIP/GLP-1 tirzepatidom. Účinnosť, bezpečnosť ani orgánový prínos jednej molekuly nemožno automaticky preniesť na inú.</p>

<h2>Ako bola štúdia TRANSCEND-T2D-1 postavená</h2>

<div class="table-responsive" role="region" aria-label="Základné parametre štúdie TRANSCEND-T2D-1" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Údaj</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Dizajn</th><td>randomizovaná, dvojito zaslepená, placebom kontrolovaná štúdia fázy 3</td></tr>
    <tr><th scope="row">Trvanie</th><td>40 týždňov</td></tr>
    <tr><th scope="row">Pracoviská</th><td>48 centier v USA, Mexiku a Indii</td></tr>
    <tr><th scope="row">Zaraďovanie</th><td>10. apríl 2024 až 21. apríl 2025</td></tr>
    <tr><th scope="row">Skríning a randomizácia</th><td>930 skrínovaných, 537 randomizovaných v pomere 1 : 1 : 1 : 1</td></tr>
    <tr><th scope="row">Liečba</th><td>retatrutid 4 mg, 9 mg alebo 12 mg podkožne raz týždenne s postupnou titráciou, alebo placebo</td></tr>
    <tr><th scope="row">Primárny ukazovateľ</th><td>zmena HbA1c od začiatku do 40. týždňa</td></tr>
    <tr><th scope="row">Kľúčový sekundárny ukazovateľ</th><td>percentuálna zmena telesnej hmotnosti</td></tr>
    <tr><th scope="row">Registrácia</th><td>ClinicalTrials.gov NCT06354660 (ukončená)</td></tr>
    <tr><th scope="row">Financovanie</th><td>Eli Lilly and Company</td></tr>
  </tbody>
</table>
</div>

<p>Zaradení boli dospelí od 18 rokov s diabetom 2. typu nedostatočne kontrolovaným samotnou diétou a pohybom, s HbA1c od 7,0 do 9,5 % (53 až 80 mmol/mol) a s BMI najmenej 23 kg/m², ktorí neužívali inú glukózu znižujúcu farmakoterapiu.</p>

<div class="table-responsive" role="region" aria-label="Rozdelenie účastníkov do liečebných skupín" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Liečebná skupina</th>
      <th scope="col">Počet pacientov</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Retatrutid 4 mg</th><td>134</td></tr>
    <tr><th scope="row">Retatrutid 9 mg</th><td>133</td></tr>
    <tr><th scope="row">Retatrutid 12 mg</th><td>136</td></tr>
    <tr><th scope="row">Placebo</th><td>134</td></tr>
  </tbody>
</table>
</div>

<p>Priemerný vek účastníkov bol 48,8 roka (smerodajná odchýlka 12,1), priemerné HbA1c 7,9 % (1,1), priemerný BMI 35,8 kg/m² (7,0) a priemerné trvanie diabetu iba 2,5 roka (4,4). Ženy tvorili 55 % súboru (296 z 537).</p>

<p>Liečebné obdobie na pridelenej liečbe dokončilo 490 účastníkov (91 %) a celú štúdiu 504 účastníkov (94 %).</p>

<h2>Výsledky glykemickej kontroly</h2>

<div class="table-responsive" role="region" aria-label="Zmena HbA1c v 40. týždni" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Liečba</th>
      <th scope="col">Priemerná zmena HbA1c (SE)</th>
      <th scope="col">Rozdiel oproti placebu (95 % IS)</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Retatrutid 4 mg</th><td>−1,69 p. b. (0,11)</td><td>−0,88 (−1,18 až −0,59)</td></tr>
    <tr><th scope="row">Retatrutid 9 mg</th><td>−1,86 p. b. (0,10)</td><td>−1,04 (−1,32 až −0,76)</td></tr>
    <tr><th scope="row">Retatrutid 12 mg</th><td>−1,94 p. b. (0,08)</td><td>−1,12 (−1,39 až −0,85)</td></tr>
    <tr><th scope="row">Placebo</th><td>−0,81 p. b. (0,12)</td><td>referenčná skupina</td></tr>
  </tbody>
</table>
</div>

<p>Skratka „p. b.“ znamená percentuálny bod, SE je štandardná chyba priemeru. Všetky tri porovnania s placebom boli štatisticky významné s hodnotou P &lt; 0,0001.</p>

<h3>Prečo je dôležitý rozdiel oproti placebu</h3>

<p>Pokles HbA1c v placebovej skupine o 0,81 percentuálneho bodu bol pomerne výrazný. Mohli k nemu prispieť:</p>

<ul>
  <li>intenzívnejšie režimové opatrenia sprevádzajúce účasť v štúdii,</li>
  <li>pravidelné sledovanie a edukácia,</li>
  <li>regresia k priemeru,</li>
  <li>krátke trvanie diabetu a zachovaná sekrécia inzulínu,</li>
  <li>zmeny stravovania a pohybovej aktivity,</li>
  <li>ukončenie liečby u časti účastníkov a spôsob štatistického spracovania chýbajúcich údajov.</li>
</ul>

<p>Pre posúdenie farmakologického účinku je preto presnejší rozdiel medzi retatrutidom a placebom než samotná zmena oproti východiskovej hodnote.</p>

<p>Ani veľký pokles HbA1c neznamená vyliečenie diabetu. Štúdia nehodnotila dlhodobú remisiu po ukončení liečby a nepreukázala, že glykemický účinok pretrváva bez pokračujúceho podávania lieku.</p>

<h2>Úbytok telesnej hmotnosti</h2>

<div class="table-responsive" role="region" aria-label="Percentuálna zmena telesnej hmotnosti v 40. týždni" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Liečba</th>
      <th scope="col">Priemerná zmena hmotnosti (SE)</th>
      <th scope="col">Orientačný rozdiel oproti placebu</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Retatrutid 4 mg</th><td>−11,5 % (0,7)</td><td>asi 8,9 p. b.</td></tr>
    <tr><th scope="row">Retatrutid 9 mg</th><td>−13,9 % (0,8)</td><td>asi 11,3 p. b.</td></tr>
    <tr><th scope="row">Retatrutid 12 mg</th><td>−15,3 % (0,8)</td><td>asi 12,7 p. b.</td></tr>
    <tr><th scope="row">Placebo</th><td>−2,6 % (0,5)</td><td>referenčná skupina</td></tr>
  </tbody>
</table>
</div>

<p>Účinok bol jasne závislý od dávky. Rozdiely oproti placebu v poslednom stĺpci sú <strong>vlastným odčítaním priemerov</strong>, nie publikovanými odhadmi liečebného rozdielu — publikovaný abstrakt pri hmotnosti neuvádza ani bodové odhady rozdielu, ani intervaly spoľahlivosti. Treba ich preto brať ako orientačné.</p>

<p>Podľa tlačovej správy Americkej diabetologickej asociácie predstavoval priemerný úbytok pri najvyššej dávke približne 36,6 libry, teda asi 16,6 kg. Z toho vyplýva východisková hmotnosť približne 99 kg. Úbytok hmotnosti nedosiahol do 40. týždňa maximum, krivka teda ešte neklesla do plató.</p>

<div class="pdf-avoid-break">
<h3>Pozor na rozdielne čísla: dva estimandy</h3>

<p>Publikácia v <em>Lancete</em> aj tento článok uvádzajú výsledky podľa takzvaného <strong>estimandu liečebného režimu</strong>. Ten hodnotí všetkých randomizovaných účastníkov vrátane tých, ktorí liečbu prerušili alebo dostali záchrannú liečbu, a je preto konzervatívnejší.</p>

<p>Tlačová správa ADA k tej istej štúdii uvádza „až 2 % zníženie HbA1c“ a zníženie hmotnosti o <strong>16,8 %</strong>. Rozdiel oproti hodnotám 1,94 % a 15,3 % s najväčšou pravdepodobnosťou vyplýva z použitia druhého, priaznivejšieho estimandu, ktorý hodnotí účinok pri pokračujúcej liečbe bez záchrannej medikácie.</p>

<p>Ani jedno číslo nie je nesprávne — odpovedajú však na dve odlišné otázky. Pri porovnávaní liekov medzi štúdiami je preto nevyhnutné overiť, ktorý estimand je uvedený. Rovnaké upozornenie platí pri čítaní tlačových správ a konferenčného spravodajstva.</p>
</div>

<h3>Priame porovnanie so semaglutidom alebo tirzepatidom nie je možné</h3>

<p>TRANSCEND-T2D-1 neobsahovala aktívny komparátor. Z jej výsledkov preto nemožno tvrdiť, že retatrutid je účinnejší než semaglutid alebo tirzepatid.</p>

<p>Nepriame porovnania medzi samostatnými štúdiami skresľujú rozdiely v:</p>

<ul>
  <li>trvaní diabetu a predchádzajúcej liečbe,</li>
  <li>východiskovom HbA1c a BMI,</li>
  <li>dávkovaní a schéme titrácie,</li>
  <li>trvaní sledovania,</li>
  <li>zastúpení obezity a komorbidít,</li>
  <li>definícii výsledkov a použitom estimande,</li>
  <li>spôsobe spracovania prerušenej liečby a chýbajúcich údajov.</li>
</ul>

<p>Na spoľahlivé porovnanie je potrebná priamo porovnávacia randomizovaná štúdia. Práve taká už prebieha — pozri nižšie.</p>

<h2>Bezpečnosť a znášanlivosť</h2>

<p>Najčastejšími nežiaducimi účinkami boli gastrointestinálne ťažkosti typické pre lieky s aktivitou na receptore GLP-1. Väčšinou boli mierne až stredne závažné a časom ustupovali. Patrili medzi ne najmä nauzea, hnačka, vracanie, zápcha, dyspeptické ťažkosti a znížená chuť do jedla.</p>

<p>Pre nežiaduce účinky prerušilo liečbu 2 až 5 % pacientov užívajúcich retatrutid oproti 0 % pri placebe.</p>

<p>V štúdii nebola zaznamenaná závažná hypoglykémia. Tento výsledok je priaznivý, ale týka sa <strong>monoterapie</strong> u pacientov, ktorí dovtedy neužívali žiadnu glukózu znižujúcu farmakoterapiu. Riziko môže byť odlišné pri kombinácii s inzulínom alebo derivátmi sulfonylurey.</p>

<p>Počas štúdie zomreli dvaja účastníci, obaja v skupine s dávkou 4 mg; podľa hodnotenia skúšajúcich úmrtia nesúviseli so skúšaným liekom. Takýto malý počet udalostí neumožňuje posúdiť vplyv retatrutidu na mortalitu.</p>

<h3>Otvorené bezpečnostné otázky</h3>

<p>Štyridsaťtýždňová štúdia s 537 účastníkmi nemôže spoľahlivo zachytiť zriedkavé alebo neskoré komplikácie. Ďalší výskum musí hodnotiť najmä:</p>

<ul>
  <li>akútnu pankreatitídu,</li>
  <li>ochorenia žlčníka a žlčových ciest,</li>
  <li>dehydratáciu a akútne poškodenie obličiek,</li>
  <li>zmeny srdcovej frekvencie a arytmie,</li>
  <li>dôsledky veľmi rýchleho úbytku hmotnosti,</li>
  <li>stratu svalovej a kostnej hmoty,</li>
  <li>podvýživu a deficit mikronutrientov,</li>
  <li>bezpečnosť u starších a krehkých pacientov,</li>
  <li>používanie pri pokročilej chronickej chorobe obličiek,</li>
  <li>vývoj hmotnosti a metabolických parametrov po prerušení liečby.</li>
</ul>

<h2>Nefrologické súvislosti</h2>

<p>Výrazný úbytok hmotnosti, zlepšenie glykémie, pokles krvného tlaku a priaznivé zmeny lipidov môžu teoreticky znižovať riziko vzniku alebo progresie diabetickej choroby obličiek. TRANSCEND-T2D-1 však nebola renálnou výsledkovou štúdiou.</p>

<p>Na základe dostupných výsledkov nemožno tvrdiť, že retatrutid:</p>

<ul>
  <li>spomaľuje dlhodobý pokles eGFR,</li>
  <li>znižuje albuminúriu nezávisle od zmeny hmotnosti a glykémie,</li>
  <li>znižuje riziko terminálneho zlyhania obličiek,</li>
  <li>predchádza potrebe dialýzy alebo transplantácie,</li>
  <li>znižuje renálnu alebo kardiovaskulárnu mortalitu,</li>
  <li>poskytuje orgánovú ochranu porovnateľnú s inhibítormi SGLT2 alebo s liekmi, pri ktorých boli výsledky preukázané v osobitných kardiorenálnych štúdiách.</li>
</ul>

<p>Orgánový prínos nemožno odvodzovať iba z mechanizmu účinku ani prenášať z iných inkretínových liekov.</p>

<h3>Riziko prerenálneho AKI</h3>

<p>Nauzea, vracanie, hnačka a výrazné zníženie príjmu potravy a tekutín môžu viesť k hypovolémii a prerenálnemu akútnemu poškodeniu obličiek. Zvýšené riziko by mohli mať najmä pacienti:</p>

<ul>
  <li>s chronickou chorobou obličiek,</li>
  <li>vo vyššom veku alebo s krehkosťou,</li>
  <li>liečení diuretikami,</li>
  <li>súbežne užívajúci inhibítor SGLT2,</li>
  <li>s nízkym krvným tlakom,</li>
  <li>so srdcovým zlyhávaním,</li>
  <li>počas akútnej infekcie alebo horúčky.</li>
</ul>

<p>Pri významných gastrointestinálnych ťažkostiach je vhodné zhodnotiť hydratáciu, krvný tlak, kreatinín, sodík a draslík a individuálne upraviť lieky ovplyvňujúce objemový stav a hemodynamiku obličiek.</p>

<div class="pdf-avoid-break">
<h3>Kreatinín a úbytok svalovej hmoty</h3>

<p>Veľký pokles telesnej hmotnosti môže zahŕňať aj stratu svalstva. Znížená tvorba kreatinínu potom môže viesť k <strong>zdanlivému zvýšeniu kreatinínovej eGFR bez skutočného zlepšenia glomerulovej filtrácie</strong>. Pri poklese hmotnosti o 15 % za necelý rok ide o klinicky reálny problém, nie o teoretickú výhradu.</p>

<p>V renálnych štúdiách retatrutidu by preto bolo vhodné hodnotiť:</p>

<ul>
  <li>kreatinínovú aj cystatínovú eGFR,</li>
  <li>pomer albumínu ku kreatinínu v moči,</li>
  <li>telesné zloženie a svalovú silu,</li>
  <li>dlhodobý sklon eGFR,</li>
  <li>potvrdené klinické renálne príhody.</li>
</ul>
</div>

<h2>Čo prinesú ďalšie štúdie programu</h2>

<p>Autori štúdie uvádzajú, že prebiehajú ďalšie štúdie fázy 3. Pre nefrológiu sú podstatné dve:</p>

<div class="table-responsive" role="region" aria-label="Prebiehajúce štúdie fázy 3 s retatrutidom pri diabete 2. typu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Populácia a porovnanie</th>
      <th scope="col">Primárny ukazovateľ</th>
      <th scope="col">Rozsah</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">TRANSCEND-T2D-2<br>(NCT06260722)</th>
      <td>diabetes 2. typu; retatrutid oproti <strong>semaglutidu</strong>, 80 týždňov</td>
      <td>glykemická kontrola</td>
      <td>1 250 účastníkov</td>
    </tr>
    <tr>
      <th scope="row">TRANSCEND-T2D-3<br>(NCT06297603)</th>
      <td>diabetes 2. typu so <strong>stredne ťažkou alebo ťažkou poruchou funkcie obličiek</strong> pri liečbe bazálnym inzulínom, prípadne s metformínom a/alebo inhibítorom SGLT2; retatrutid oproti placebu</td>
      <td>zmena HbA1c v 52. týždni</td>
      <td>320 účastníkov</td>
    </tr>
  </tbody>
</table>
</div>

<p><strong>Dôležitá nefrologická poznámka:</strong> ani štúdia u pacientov s poruchou funkcie obličiek nie je renálnou výsledkovou štúdiou. Jej primárnym ukazovateľom je zmena HbA1c v 52. týždni; obličkové parametre sú hodnotené v rámci účinnosti a bezpečnosti, nie ako klinické renálne príhody. Prinesie teda cenné údaje o účinnosti a znášanlivosti pri zníženej funkcii obličiek, ale <em>neodpovie</em> na otázku, či retatrutid spomaľuje progresiu chronickej choroby obličiek.</p>

<p>Zo štúdie sú navyše vylúčení pacienti s rýchlo progredujúcim alebo nestabilným ochorením obličiek, so srdcovým zlyhávaním triedy NYHA III a IV a s nedávnou kardiovaskulárnou príhodou. Aj jej výsledky teda budú platiť pre relatívne stabilnú populáciu.</p>

<h2>Populácia štúdie nereprezentuje väčšinu komplikovaných diabetikov</h2>

<p>Priemerné trvanie diabetu bolo iba 2,5 roka a pacienti dovtedy neužívali glukózu znižujúcu farmakoterapiu. Výsledky preto nemožno bez ďalších dôkazov prenášať na pacientov:</p>

<ul>
  <li>s dlhodobým diabetom,</li>
  <li>liečených inzulínom,</li>
  <li>s pokročilou chronickou chorobou obličiek,</li>
  <li>s prekonanými kardiovaskulárnymi príhodami,</li>
  <li>vo vyššom veku a s krehkosťou,</li>
  <li>s diabetickou gastroparézou,</li>
  <li>po transplantácii obličky,</li>
  <li>liečených dialýzou,</li>
  <li>s komplexnou polyfarmáciou.</li>
</ul>

<p>U takýchto pacientov môže byť odlišná nielen účinnosť, ale aj tolerancia, bezpečnosť titrácie a riziko straty svalovej hmoty.</p>

<h2>Metodologické zhodnotenie</h2>

<h3>Silné stránky</h3>

<ul>
  <li>randomizované a dvojito zaslepené usporiadanie s placebom,</li>
  <li>tri dávkové skupiny umožňujúce posúdiť závislosť od dávky,</li>
  <li>multicentrická a medzinárodná realizácia (48 centier v troch krajinách),</li>
  <li>vysoký podiel dokončeného sledovania (94 %) aj zotrvania na liečbe (91 %),</li>
  <li>vopred definovaný primárny ukazovateľ a registrácia štúdie,</li>
  <li>vykazovanie podľa estimandu liečebného režimu, teda konzervatívnejšieho prístupu,</li>
  <li>konzistentný účinok na HbA1c aj telesnú hmotnosť naprieč dávkami.</li>
</ul>

<h3>Hlavné obmedzenia</h3>

<ol>
  <li><strong>Krátke sledovanie.</strong> Štyridsať týždňov nestačí na posúdenie dlhodobej bezpečnosti, udržateľnosti hmotnosti ani orgánových výsledkov.</li>
  <li><strong>Selektovaná populácia.</strong> Išlo prevažne o pacientov s obezitou a včasným diabetom liečeným iba režimovými opatreniami.</li>
  <li><strong>Chýbajúci aktívny komparátor.</strong> Štúdia neumožňuje priamu konfrontáciu so semaglutidom, tirzepatidom ani metformínom.</li>
  <li><strong>Obmedzená štatistická sila pre zriedkavé riziká.</strong> Bezpečnostný súbor bol príliš malý na vylúčenie neobvyklých komplikácií.</li>
  <li><strong>Bez kardiorenálnych výsledkov.</strong> Zmeny metabolických markerov nie sú náhradou za klinické príhody.</li>
  <li><strong>Nejasná udržateľnosť po vysadení.</strong> Štúdia neurčila rozsah opätovného nárastu hmotnosti a zhoršenia glykémie po ukončení liečby.</li>
  <li><strong>Chýbajúce údaje o telesnom zložení.</strong> Publikovaný abstrakt neuvádza podiel svalovej a tukovej hmoty na úbytku, čo je pri poklese o 15 % podstatné.</li>
  <li><strong>Financovanie výrobcom.</strong> Štúdiu financovala spoločnosť Eli Lilly and Company a časť autorského kolektívu tvoria jej zamestnanci.</li>
  <li><strong>Placebom kontrolovaný dizajn môže zvýrazniť dojem účinnosti.</strong> Pre klinické rozhodovanie bude potrebné priame porovnanie s najúčinnejšími dostupnými liekmi.</li>
</ol>

<p>Financovanie výrobcom neznamená, že výsledky sú nesprávne. Zvyšuje však význam úplného zverejnenia protokolu, štatistického plánu, individuálnych údajov, nezávislej replikácie a následných aktívne kontrolovaných štúdií.</p>

<div class="pdf-avoid-break">
<h2>Vecná kontrola hlavných tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie hlavných tvrdení o retatrutide a štúdii TRANSCEND-T2D-1" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Odborné hodnotenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Retatrutid aktivuje receptory GIP, GLP-1 a glukagónu</td><td>Potvrdené</td></tr>
    <tr><td>Pri dávke 12 mg znížil HbA1c o 1,94 percentuálneho bodu</td><td>Potvrdené ako zmena oproti východisku podľa estimandu liečebného režimu</td></tr>
    <tr><td>Placebom korigovaný pokles HbA1c pri 12 mg bol 1,12 percentuálneho bodu</td><td>Potvrdené; 95 % IS −1,39 až −0,85</td></tr>
    <tr><td>Pri dávke 12 mg znížil hmotnosť o 15,3 %</td><td>Potvrdené ako priemerná zmena oproti východisku</td></tr>
    <tr><td>Rozdiel v hmotnosti oproti placebu bol 12,7 percentuálneho bodu</td><td>Vlastný orientačný prepočet; publikovaný odhad rozdielu ani interval spoľahlivosti abstrakt neuvádza</td></tr>
    <tr><td>Tlačová správa a publikácia uvádzajú rovnaké čísla</td><td>Nie; 16,8 % oproti 15,3 % pre hmotnosť — pravdepodobne rozdiel estimandov</td></tr>
    <tr><td>Retatrutid je účinnejší než semaglutid alebo tirzepatid</td><td>Nedokázané; chýba priame porovnanie (prebieha TRANSCEND-T2D-2)</td></tr>
    <tr><td>Retatrutid môže navodiť trvalú remisiu diabetu</td><td>Nedokázané</td></tr>
    <tr><td>Retatrutid nespôsobuje hypoglykémiu</td><td>Závažná hypoglykémia sa nevyskytla pri monoterapii; kombinovaná liečba nebola overená</td></tr>
    <tr><td>Retatrutid má preukázanú kardiovaskulárnu ochranu</td><td>Nedokázané</td></tr>
    <tr><td>Retatrutid chráni obličky</td><td>Nedokázané; ani prebiehajúca štúdia pri poruche funkcie obličiek nemá renálny primárny ukazovateľ</td></tr>
    <tr><td>Zlepšenie HbA1c a hmotnosti dokazuje zníženie mortality</td><td>Nie</td></tr>
    <tr><td>Bezpečnostný profil je definitívne známy</td><td>Nie; sledovanie bolo krátke a súbor relatívne malý</td></tr>
    <tr><td>Výsledky možno preniesť na pacientov s pokročilou CKD alebo na dialýze</td><td>Nie</td></tr>
    <tr><td>Retatrutid možno získavať ako „výskumný peptid“ na samoliečbu</td><td>Takéto produkty nemožno považovať za overené, bezpečné ani farmaceuticky rovnocenné skúšanému lieku</td></tr>
  </tbody>
</table>
</div>
</div>

<div class="pdf-avoid-break">
<h2>Praktický záver</h2>

<p>Retatrutid v štúdii TRANSCEND-T2D-1 priniesol výrazný pokles HbA1c a telesnej hmotnosti u dospelých s relatívne včasným diabetom 2. typu a prevažne prítomnou obezitou. Pri najvyššej dávke sa HbA1c za 40 týždňov znížil o 1,94 percentuálneho bodu a hmotnosť o 15,3 %.</p>

<p>Výsledky predstavujú významný dôkaz metabolickej účinnosti, nie však dôkaz celkového klinického prínosu. Zatiaľ nevieme, či retatrutid znižuje mortalitu, infarkt myokardu, cievnu mozgovú príhodu, hospitalizácie pre srdcové zlyhávanie alebo progresiu chronickej choroby obličiek.</p>

<p>Pred určením jeho miesta v liečbe bude potrebné:</p>

<ul>
  <li>priame porovnanie s aktívnou liečbou,</li>
  <li>dlhodobé bezpečnostné sledovanie,</li>
  <li>kardiovaskulárne a renálne výsledkové štúdie,</li>
  <li>údaje u starších a polymorbídnych pacientov,</li>
  <li>posúdenie vplyvu na svalovú a kostnú hmotu,</li>
  <li>údaje o následkoch ukončenia liečby,</li>
  <li>nezávislé potvrdenie výsledkov.</li>
</ul>

<p><strong>Retatrutid zostáva skúšanou molekulou. Nie je registrovaný a nemá sa používať prostredníctvom neoverených internetových prípravkov označovaných ako „research peptides“</strong> — tejto téme sa venuje samostatný článok uvedený nižšie.</p>
</div>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=retatrutid-ubytok-hmotnosti-metabolicke-benefity">Retatrutid prináša výrazný úbytok hmotnosti aj metabolické benefity. Nové dáta však treba čítať opatrne</a></li>
  <li><a href="article.php?slug=retatrutid-mimo-schvalenia-neregulovane-pouzivanie">Retatrutid mimo schválenia: keď experimentálny liek predbehne reguláciu</a></li>
  <li><a href="article.php?slug=tirzepatid-oblickove-vysledky-surpass-nefrologia">Tirzepatid a obličkové výsledky v programe SURPASS: čo znamenajú pre nefrológiu</a></li>
  <li><a href="article.php?slug=semaglutid-ckd-porovnanie-glp1-realna-prax">Semaglutid a riziko chronickej choroby obličiek pri diabete 2. typu: porovnanie agonistov receptora GLP-1 v reálnej praxi</a></li>
  <li><a href="article.php?slug=farmakologicka-liecba-obezity-pokrocile-ckd-dialyza">Farmakologická liečba obezity u pacientov s pokročilým CKD a na dialýze: praktické dávkovanie, dialyzačné špecifiká a bezpečnosť</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Bajaj HS, Welch M, Shah P, Luna E, Jaouimaa FZ, Liu B, Liu R, Chen Y, Patel H, Bartee A.</strong> <em>Efficacy and safety of retatrutide, a GIP, GLP-1, and glucagon receptor agonist, in people with type 2 diabetes and inadequate glycaemic control with diet and exercise (TRANSCEND-T2D-1): a double-blind, randomised, phase 3 trial.</em> Lancet. 2026;407(10546):2402–2413. doi: 10.1016/S0140-6736(26)00967-0. <a href="https://doi.org/10.1016/S0140-6736(26)00967-0" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42250575/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Eli Lilly and Company.</strong> <em>A Study of Retatrutide in Participants With Type 2 Diabetes Mellitus (TRANSCEND-T2D-1).</em> ClinicalTrials.gov, NCT06354660. Inštitucionálny registračný záznam. <a href="https://clinicaltrials.gov/study/NCT06354660" target="_blank" rel="noopener noreferrer">Registračný záznam</a>.</li>
  <li><strong>American Diabetes Association.</strong> <em>Breakthrough Studies Demonstrate Effectiveness of the First Triple-Hormone Therapy for Type 2 Diabetes and Obesity.</em> Tlačová správa k 86. Scientific Sessions, New Orleans, 6. júna 2026. Inštitucionálne autorstvo. <a href="https://professional.diabetes.org/sites/dpro/files/2026-06/final_ada.26_retatrutide_press_release.pdf" target="_blank" rel="noopener noreferrer">Tlačová správa ADA</a>.</li>
  <li><strong>Eli Lilly and Company.</strong> <em>Effect of Retatrutide Compared With Semaglutide in Adult Participants With Type 2 Diabetes (TRANSCEND-T2D-2).</em> ClinicalTrials.gov, NCT06260722. <a href="https://clinicaltrials.gov/study/NCT06260722" target="_blank" rel="noopener noreferrer">Registračný záznam</a>.</li>
  <li><strong>Eli Lilly and Company.</strong> <em>Effect of Retatrutide Compared With Placebo in Participants With Type 2 Diabetes and Moderate or Severe Renal Impairment (TRANSCEND-T2D-3).</em> ClinicalTrials.gov, NCT06297603. Primárnym ukazovateľom je zmena HbA1c v 52. týždni. <a href="https://clinicaltrials.gov/study/NCT06297603" target="_blank" rel="noopener noreferrer">Registračný záznam</a>.</li>
  <li><strong>Rosenstock J, Frias J, Jastreboff AM, Du Y, Lou J, Gurbuz S, Thomas MK, Hartman ML, Haupt A, Milicevic Z, Coskun T.</strong> <em>Retatrutide, a GIP, GLP-1 and glucagon receptor agonist, for people with type 2 diabetes: a randomised, double-blind, placebo and active-controlled, parallel-group, phase 2 trial conducted in the USA.</em> Lancet. 2023;402(10401):529–544. doi: 10.1016/S0140-6736(23)01053-X. <a href="https://doi.org/10.1016/S0140-6736(23)01053-X" target="_blank" rel="noopener noreferrer">Štúdia fázy 2 pri diabete</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37385280/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Jastreboff AM, Kaplan LM, Frías JP, Wu Q, Du Y, Gurbuz S, Coskun T, Haupt A, Milicevic Z, Hartman ML.</strong> <em>Triple-Hormone-Receptor Agonist Retatrutide for Obesity — A Phase 2 Trial.</em> N Engl J Med. 2023;389(6):514–526. doi: 10.1056/NEJMoa2301972. <a href="https://doi.org/10.1056/NEJMoa2301972" target="_blank" rel="noopener noreferrer">Štúdia fázy 2 pri obezite</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37366315/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Coskun T, Urva S, Roell WC, Qu H, Loghin C, Moyers JS, O'Farrell LS, Briere DA, Sloop KW, Thomas MK, a spol.</strong> <em>LY3437943, a novel triple glucagon, GIP, and GLP-1 receptor agonist for glycemic control and weight loss: from discovery to clinical proof of concept.</em> Cell Metab. 2022;34(9):1234–1247.e9. doi: 10.1016/j.cmet.2022.07.013. Celkovo 20 autorov. <a href="https://doi.org/10.1016/j.cmet.2022.07.013" target="_blank" rel="noopener noreferrer">Farmakologická charakteristika molekuly</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/35985340/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>Retatrutide Trims Weight and A1c in Diabetes.</em> Medscape, 2026. Sekundárny spravodajský zdroj (obsah za prihlásením); individuálny autor nie je v sprístupnenej verzii uvedený. <a href="https://www.medscape.com/s/viewarticle/retatrutide-trims-weight-and-a1c-diabetes-2026a1000rfw" target="_blank" rel="noopener noreferrer">Spravodajské spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Všetky číselné údaje o dizajne, populácii, primárnom a kľúčovom sekundárnom ukazovateli, o rozdieloch oproti placebu vrátane intervalov spoľahlivosti, o prerušeniach liečby a o úmrtiach boli overené priamo proti abstraktu publikácie v časopise Lancet (PubMed, PMID 42250575). Údaje o prebiehajúcich štúdiách TRANSCEND-T2D-2 a TRANSCEND-T2D-3 pochádzajú z registra ClinicalTrials.gov, absolútny úbytok hmotnosti a hodnota 16,8 % z tlačovej správy ADA. Rozdiely v telesnej hmotnosti oproti placebu vyjadrené v percentuálnych bodoch sú vlastným orientačným odčítaním priemerov — publikovaný abstrakt pri hmotnosti neuvádza odhad liečebného rozdielu ani interval spoľahlivosti. Autorstvo a bibliografické údaje všetkých citovaných prác boli overené cez PubMed; mená neboli dopĺňané odhadom.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Retatrutid nie je registrovaným liekom. Tento článok neslúži na odporúčanie liečby ani na porovnávanie s registrovanými prípravkami. Voľbu liečby diabetu 2. typu treba riadiť platnými odbornými odporúčaniami, súhrnom charakteristických vlastností konkrétneho lieku, funkciou obličiek a individuálnym rizikom pacienta.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_retatrutid-transcend-t2d-1-hba1c-hmotnost-nefrologia_article',
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
