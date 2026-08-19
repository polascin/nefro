<?php
/**
 * Odborny clanok: dapagliflozin pred kardiochirurgickou operaciou a AKI (studia MERCURI-2).
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_dapagliflozin-kardiochirurgia-aki-mercuri-2_article.php"
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
    'title'        => 'Dapagliflozín pred kardiochirurgickou operáciou znížil výskyt akútneho poškodenia obličiek. Meniť perioperačnú prax je zatiaľ predčasné',
    'slug'         => 'dapagliflozin-kardiochirurgia-aki-mercuri-2',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V randomizovanej štúdii MERCURI-2 znížili štyri dávky dapagliflozínu výskyt pooperačného akútneho poškodenia obličiek z 52 % na 28 %. Výsledok však do veľkej miery určilo kritérium nízkej diurézy. Mortalita, dĺžka hospitalizácie ani závažné kardiorenálne príhody sa nezmenili.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Štyri dávky dapagliflozínu podané okolo elektívnej operácie srdca znížili v štúdii MERCURI-2 výskyt akútneho poškodenia obličiek z 52 % na 28 %. Rozsah účinku je nezvyčajne veľký, no podstatnú časť rozdielu tvorili prípady definované krátkodobou oligúriou — a dapagliflozín diurézu sám zvyšuje. Mortalita, potreba náhrady funkcie obličiek, dĺžka hospitalizácie ani závažné kardiorenálne príhody sa nezmenili a bezpečnostný súbor bol príliš malý a príliš selektovaný na vylúčenie perioperačnej ketoacidózy.</em></p>

<h2>Prečo je téma dôležitá</h2>

<p>Akútne poškodenie obličiek (AKI) patrí medzi najčastejšie komplikácie kardiochirurgických operácií. Autori štúdie uvádzajú, že podľa doterajších prác postihuje 2 % až 50 % pacientov po elektívnej operácii srdca; taký široký rozptyl odráža rozdiely v type výkonu, rizikovom profile pacientov a najmä v použitej definícii. Overená farmakologická prevencia doteraz neexistuje.</p>

<p>Aj mierne zvýšenie sérového kreatinínu sa spája s nepriaznivejšou prognózou, ale najzávažnejšie dôsledky prináša perzistentné AKI vyššieho štádia, potreba náhrady funkcie obličiek a neúplná obnova renálnej funkcie.</p>

<p>Štúdia MERCURI-2, publikovaná 30. júla 2026 v časopise <em>JAMA</em>, priniesla prekvapujúci výsledok: dapagliflozín podávaný od dňa pred elektívnou operáciou srdca do druhého pooperačného dňa znížil výskyt AKI takmer o polovicu. Takýto rozsah účinku je pri preventívnej intervencii nezvyčajný a vyžaduje nezávislé potvrdenie.</p>

<p>Štúdia zároveň vstupuje do citlivej bezpečnostnej oblasti. Inhibítory sodíkovo-glukózového kotransportéra 2 (inhibítory SGLT2) sa pred plánovaným operačným výkonom štandardne prerušujú pre riziko euglykemickej diabetickej ketoacidózy. MERCURI-2 postupovala opačne: dapagliflozín sa <strong>začal</strong> tesne pred operáciou a podával sa aj v skorom pooperačnom období.</p>

<h2>Prečo vzniká AKI po operácii srdca</h2>

<p>Pooperačné poškodenie obličiek nemá jedinú príčinu. U jednotlivého pacienta sa spravidla kombinuje viacero mechanizmov:</p>

<ul>
  <li>znížená perfúzia obličiek a nízky srdcový výdaj,</li>
  <li>venózna kongescia a zvýšený intraabdominálny tlak,</li>
  <li>hemodilúcia a anémia,</li>
  <li>zápalová odpoveď na mimotelový obeh,</li>
  <li>oxidačný stres a ischemicko-reperfúzne poškodenie,</li>
  <li>hemolýza a pigmentová nefropatia,</li>
  <li>mikroembolizácia,</li>
  <li>vazopresorická liečba a transfúzia krvi,</li>
  <li>infekcia,</li>
  <li>expozícia nefrotoxickým liekom a kontrastným látkam,</li>
  <li>už existujúca chronická choroba obličiek.</li>
</ul>

<p>Nie každé pooperačné zvýšenie kreatinínu predstavuje rovnaký typ poškodenia. Kreatinín ovplyvňuje objem tekutín, svalová hmota, jeho tvorba aj oneskorená kinetika. Diurézu zas ovplyvňujú hemodynamika, diuretiká, glykosúria a perioperačný príjem tekutín. Táto skutočnosť je pre interpretáciu MERCURI-2 kľúčová.</p>

<h2>Ako bola štúdia MERCURI-2 postavená</h2>

<div class="table-responsive" role="region" aria-label="Základné parametre štúdie MERCURI-2" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Údaj</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Dizajn</th><td>multicentrická, randomizovaná, dvojito zaslepená, placebom kontrolovaná štúdia</td></tr>
    <tr><th scope="row">Pracoviská</th><td>2 univerzitné a 5 neuniverzitných nemocníc v Holandsku</td></tr>
    <tr><th scope="row">Zaraďovanie</th><td>8. jún 2023 až 27. január 2025; posledné sledovanie 16. máj 2025</td></tr>
    <tr><th scope="row">Populácia</th><td>dospelí pripravovaní na elektívnu kardiochirurgickú operáciu</td></tr>
    <tr><th scope="row">Randomizácia</th><td>1 : 1; dapagliflozín 10 mg denne (392 pacientov) verzus placebo (392 pacientov)</td></tr>
    <tr><th scope="row">Liečebný režim</th><td>od dňa pred operáciou do druhého pooperačného dňa, spolu 4 dávky</td></tr>
    <tr><th scope="row">Dokončené sledovanie</th><td>778 z 784 účastníkov (99 %)</td></tr>
    <tr><th scope="row">Registrácia</th><td>ClinicalTrials.gov NCT05590143</td></tr>
  </tbody>
</table>
</div>

<p>Základné charakteristiky súboru boli: medián veku 68 rokov (medzikvartilové rozpätie 61 až 74), 76 % mužov, 97 % osôb belošského pôvodu, medián BMI 27 kg/m² (25 až 30) a medián eGFR 80 ml/min/1,73 m² (67 až 89).</p>

<p>Nešlo teda primárne o štúdiu diabetikov, pacientov s pokročilou chronickou chorobou obličiek ani pacientov s vysokým rizikom ketoacidózy. Väčšina účastníkov mala zachovanú alebo iba mierne zníženú funkciu obličiek.</p>

<h3>Zaslepenie: dvojité alebo trojité?</h3>

<p>Publikovaný protokol štúdie označuje dizajn za trojito zaslepený (pacient, ošetrujúci tím aj skúšajúci), publikácia v <em>JAMA</em> používa označenie dvojito zaslepený. Ide o terminologický rozdiel, nie o rozpor v metodike: tablety dapagliflozínu boli prekapsulované a placebo obsahovalo mikrokryštalickú celulózu, takže boli vzhľadom nerozoznateľné.</p>

<h2>Koho štúdia nezahrnula</h2>

<p>Vylučovacie kritériá sú pre interpretáciu bezpečnostných záverov rovnako dôležité ako samotné výsledky. Podľa protokolu boli vylúčení pacienti:</p>

<ul>
  <li>s diabetom 1. typu,</li>
  <li>s diabetom 2. typu, ktorí mali súčasne BMI pod 25 kg/m² <strong>a</strong> boli liečení viacnásobnými dennými injekciami inzulínu (krátko aj dlhodobo pôsobiaceho),</li>
  <li>s anamnézou diabetickej ketoacidózy,</li>
  <li>so systolickým tlakom pod 100 mm Hg v čase zaradenia,</li>
  <li>s eGFR pod 20 ml/min/1,73 m²,</li>
  <li><strong>už liečení inhibítorom SGLT2</strong>,</li>
  <li>so známou alebo predpokladanou alergiou na skúšanú liečbu,</li>
  <li>operovaní urgentne, teda do 72 hodín,</li>
  <li>tehotné a dojčiace ženy a ženy bez primeranej antikoncepcie.</li>
</ul>

<p>Dve z týchto kritérií menia vyznenie diskusie o perioperačnej bezpečnosti:</p>

<ol>
  <li><strong>Chronickí používatelia inhibítora SGLT2 boli zo štúdie vylúčení.</strong> MERCURI-2 preto <em>neodpovedá</em> na otázku, či má pacient dlhodobo užívajúci inhibítor SGLT2 liek pred operáciou vysadiť. Odpovedá na inú otázku — či sa oplatí liek na štyri dni <em>začať</em>.</li>
  <li>Vylúčené boli aj viaceré skupiny s vyšším rizikom ketoacidózy. Nízky výskyt tejto komplikácie preto nemožno automaticky preniesť na všetkých pacientov užívajúcich inhibítory SGLT2.</li>
</ol>

<h2>Definícia primárneho výsledku</h2>

<p>Primárnym ukazovateľom bolo AKI počas prvých siedmich pooperačných dní podľa kritérií KDIGO. Stačilo splnenie aspoň jednej z podmienok:</p>

<ul>
  <li>zvýšenie kreatinínu najmenej o 0,3 mg/dl (26,5 µmol/l) do 48 hodín po operácii,</li>
  <li>zvýšenie kreatinínu najmenej na 1,5-násobok východiskovej hodnoty do siedmich dní,</li>
  <li>diuréza pod 0,5 ml/kg/h počas 6 až 12 hodín.</li>
</ul>

<p>Použitie štandardných kritérií KDIGO je metodologickou prednosťou. Zároveň však vytvára interpretačný problém, ktorý je pri tomto lieku zásadný: dapagliflozín zvyšuje glykosúriu a osmotickú diurézu. Môže preto znižovať počet prípadov definovaných oligúriou bez toho, aby v rovnakom rozsahu zabránil skutočnému poškodeniu obličiek.</p>

<h2>Hlavný výsledok</h2>

<div class="table-responsive" role="region" aria-label="Primárny výsledok štúdie MERCURI-2" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Dapagliflozín</th>
      <th scope="col">Placebo</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">AKI do 7 dní po operácii</th><td>28 %</td><td>52 %</td></tr>
    <tr><th scope="row">Relatívne riziko (95 % IS)</th><td colspan="2">0,54 (0,45 až 0,65); P &lt; 0,001</td></tr>
    <tr><th scope="row">Absolútny rozdiel</th><td colspan="2">24 percentuálnych bodov</td></tr>
    <tr><th scope="row">NNT (orientačne)</th><td colspan="2">1 ÷ 0,24 ≈ 4,2 pacienta</td></tr>
  </tbody>
</table>
</div>

<p>Relatívne zníženie rizika predstavovalo 46 %. Približne štyria pacienti by teda museli dostať dapagliflozín, aby sa zabránilo jednej epizóde AKI definovanej použitým kombinovaným kritériom.</p>

<p>Číslo je mimoriadne priaznivé, ale vzťahuje sa na konkrétnu populáciu, veľmi vysokú incidenciu AKI a definíciu zahŕňajúcu krátkodobú oligúriu. Nemožno ho preniesť na iné chirurgické výkony ani na prevenciu klinicky závažného zlyhania obličiek.</p>

<div class="pdf-avoid-break">
<h3>Výskyt AKI v placebovej skupine bol viac než dvojnásobný oproti očakávaniu</h3>

<p>Táto skutočnosť sa v spravodajstve takmer nespomína, hoci je pre posúdenie výsledku podstatná. Výpočet veľkosti súboru vychádzal z <strong>predpokladaného výskytu AKI v placebovej skupine 22 %</strong> a z relatívneho rizika 0,64, čo zodpovedalo absolútnemu zníženiu o 7,9 percentuálneho bodu. Skutočne pozorovaný výskyt v placebovej skupine bol 52 %, teda takmer 2,4-násobok predpokladu, a pozorovaný účinok bol väčší, než sa plánovalo.</p>

<p>Ak sa pozorovaná incidencia v kontrolnej skupine výrazne odchýli od predpokladu, spravidla to znamená, že sa zachytávali aj veľmi mierne udalosti — v tomto prípade najmä krátkodobé poklesy diurézy, ktoré sa pri hodinovom monitorovaní na jednotke intenzívnej starostlivosti zaznamenávajú takmer u každého pacienta po mimotelovom obehu.</p>
</div>

<h2>Kritérium diurézy vysvetľuje väčšinu rozdielu</h2>

<p>Podľa spravodajského spracovania štúdie splnilo primárny výsledok na základe nízkej diurézy <strong>48 % pacientov s AKI v placebovej skupine a 21 % pacientov s AKI v dapagliflozínovej skupine</strong>.</p>

<p>Z týchto podielov možno urobiť orientačný prepočet. Pri 392 pacientoch v každom ramene zodpovedá 52 % približne 204 pacientom s AKI v placebovej a 28 % približne 110 pacientom v dapagliflozínovej skupine. Kritérium diurézy tak splnilo zhruba 98 pacientov na placebe a zhruba 23 pacientov na dapagliflozíne.</p>

<div class="table-responsive" role="region" aria-label="Orientačný rozklad primárneho výsledku podľa kritérií" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Orientačný prepočet</th>
      <th scope="col">Dapagliflozín</th>
      <th scope="col">Placebo</th>
      <th scope="col">Rozdiel</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Všetky prípady AKI</th><td>≈ 110</td><td>≈ 204</td><td>≈ 94</td></tr>
    <tr><th scope="row">Z toho podľa diurézy</th><td>≈ 23</td><td>≈ 98</td><td>≈ 75</td></tr>
    <tr><th scope="row">Zvyšok (podľa kreatinínu)</th><td>≈ 87</td><td>≈ 106</td><td>≈ 19</td></tr>
  </tbody>
</table>
</div>

<p>Ak by sa AKI hodnotilo <em>iba</em> podľa kreatinínu, rozdiel by predstavoval približne 22 % oproti 27 %, teda relatívne zníženie rádovo o pätinu — hodnotu blízku doterajším súhrnným analýzam dlhodobej liečby inhibítormi SGLT2, ktoré uvádzajú zníženie rizika AKI približne o 20 až 26 %.</p>

<p><strong>Tento prepočet je orientačný.</strong> Predpokladá, že sa kritériá u jednotlivých pacientov neprekrývali, čo publikovaný abstrakt neuvádza. Napriek tomu ukazuje, kde je ťažisko problému: kritérium diurézy pravdepodobne vysvetľuje približne štyri pätiny pozorovaného absolútneho rozdielu.</p>

<p>Ponúkajú sa dve možné, navzájom sa nevylučujúce interpretácie:</p>

<ol>
  <li>dapagliflozín skutočne zlepšil renálnu hemodynamiku alebo odolnosť obličiek voči perioperačnému poškodeniu, čo sa prejavilo aj zachovanou diurézou,</li>
  <li>osmotická diuréza mechanicky znížila počet pacientov spĺňajúcich oligurickú zložku definície AKI.</li>
</ol>

<p>Samotné zachovanie diurézy nie je bezvýznamné — oligúria môže signalizovať závažnú hemodynamickú poruchu a spája sa s nepriaznivou prognózou. Pri lieku s priamym diuretickým účinkom však nemožno automaticky považovať pokles oligúrie za rovnocenný dôkaz ochrany renálneho parenchýmu.</p>

<p>Na rozlíšenie týchto možností by boli potrebné samostatne publikované výsledky kreatinínových a diuretických kritérií, biomarkery tubulárneho poškodenia a dlhodobejšie sledovanie eGFR a albuminúrie.</p>

<h2>Čo štúdia nepreukázala</h2>

<p>Podľa publikovaného abstraktu a súhrnov vydavateľa dapagliflozín nezlepšil žiadny zo sekundárnych ukazovateľov. Medzi skupinami nebol zistený významný rozdiel v:</p>

<ul>
  <li>dĺžke hospitalizácie,</li>
  <li>dĺžke pobytu na jednotke intenzívnej starostlivosti,</li>
  <li>závažných kardiálnych a renálnych príhodách do 30 dní,</li>
  <li>mortalite,</li>
  <li>kvalite života,</li>
  <li>pooperačnej fibrilácii predsiení,</li>
  <li>potrebe reoperácie.</li>
</ul>

<p>Fibrilácia predsiení vznikla u 45 % pacientov v oboch skupinách (176 z 392 v každej). Reoperáciu podstúpilo 11 % pacientov liečených dapagliflozínom (43 z 392) a 10 % pacientov dostávajúcich placebo (39 z 392).</p>

<p>Neprítomnosť rozdielu nemusí znamenať neúčinnosť — štúdia pravdepodobne nemala dostatočnú štatistickú silu na zriedkavejšie klinické udalosti. Zároveň však ukazuje, že výrazné zníženie kombinovaného AKI sa zatiaľ nepremietlo do preukázateľného krátkodobého klinického prínosu.</p>

<div class="pdf-avoid-break">
<h3>Poznámka k údajom o závažnejších štádiách AKI</h3>

<p>Sekundárne spravodajské spracovanie uvádza, že AKI druhého alebo tretieho štádia vzniklo u 19 pacientov v dapagliflozínovej a u 50 pacientov v placebovej skupine (približne 4,8 % oproti 12,8 %), pričom samotné tretie štádium sa vyskytlo u veľmi malého počtu pacientov bez štatisticky významného rozdielu.</p>

<p><strong>Tieto čísla sa nedali overiť vo voľne dostupnom abstrakte ani v otvorených sekundárnych zdrojoch</strong>, ktoré rozdelenie AKI podľa štádií neuvádzajú. Ak by boli správne, oslabovali by vysvetlenie, že celý účinok bol iba dôsledkom zvýšenej diurézy. Aj vtedy by však platilo, že jednotlivé štádiá KDIGO možno definovať diurézou a že vyššie štádium AKI automaticky neznamená trvalé poškodenie obličiek. Do overenia proti plnému textu treba tento údaj považovať za predbežný.</p>
</div>

<h2>Ketoacidóza sa vyskytla u jedného pacienta</h2>

<p>Jedna epizóda ketoacidózy vznikla v dapagliflozínovej skupine, žiadna v skupine s placebom. Absolútne riziko v liečenej skupine tak bolo približne 0,26 %.</p>

<p>Jediná udalosť neumožňuje spoľahlivo odhadnúť skutočné riziko. Pri 392 liečených pacientoch je horná hranica 95 % intervalu spoľahlivosti pre jednu udalosť približne 1,4 %, čo nie je zanedbateľné. Štúdia bola na vylúčenie zriedkavej, ale potenciálne život ohrozujúcej komplikácie príliš malá — a navyše boli vylúčení pacienti s viacerými rizikovými faktormi ketoacidózy.</p>

<div class="pdf-avoid-break">
<h3>Prečo vzniká euglykemická ketoacidóza</h3>

<p>Inhibítory SGLT2 znižujú glykémiu zvýšeným vylučovaním glukózy močom. Súčasne môžu:</p>

<ul>
  <li>znižovať sekréciu inzulínu,</li>
  <li>relatívne zvyšovať účinok glukagónu,</li>
  <li>podporovať lipolýzu a ketogenézu,</li>
  <li>maskovať hyperglykémiu glykosúriou.</li>
</ul>

<p>Ketoacidóza preto môže vzniknúť aj pri normálnej alebo iba mierne zvýšenej glykémii. Operačný stres, hladovanie, znížený príjem sacharidov, infekcia, dehydratácia a nedostatok inzulínu riziko ďalej zvyšujú.</p>

<p><strong>Normálna glykémia ketoacidózu nevylučuje.</strong> Pri nauzee, vracaní, bolesti brucha, tachypnoe, nevysvetlenej acidóze alebo poruche vedomia treba vyšetriť:</p>

<ul>
  <li>acidobázickú rovnováhu,</li>
  <li>aniónovú medzeru,</li>
  <li>β-hydroxybutyrát v krvi,</li>
  <li>laktát,</li>
  <li>glykémiu,</li>
  <li>funkciu obličiek a elektrolyty.</li>
</ul>

<p>Močové ketóny sú menej spoľahlivé než priame stanovenie β-hydroxybutyrátu v krvi, pretože testovacie prúžky detegujú predovšetkým acetoacetát.</p>
</div>

<h2>Možné mechanizmy renálnej ochrany</h2>

<p>Prípadný účinok dapagliflozínu nemožno vysvetliť chronickou redukciou albuminúrie ani spomalením progresie CKD — liečba trvala iba štyri dni. Uvažovať možno o viacerých akútnych mechanizmoch:</p>

<ul>
  <li>zníženie proximálnej tubulárnej reabsorpcie sodíka a glukózy,</li>
  <li>zníženie energetickej a kyslíkovej náročnosti proximálneho tubulu,</li>
  <li>obnovenie tubuloglomerulárnej spätnej väzby,</li>
  <li>priaznivejšia intrarenálna distribúcia kyslíka,</li>
  <li>osmotická diuréza a natriuréza,</li>
  <li>zníženie venóznej kongescie,</li>
  <li>protizápalové a metabolické účinky,</li>
  <li>zlepšenie kardiálnej a renálnej energetiky.</li>
</ul>

<p>Niektoré z týchto mechanizmov sú podporené experimentálnymi údajmi, ale MERCURI-2 ich priamo nedokázala. Klinická štúdia preukázala rozdiel vo výskyte definovaného AKI, nie konkrétny biologický mechanizmus.</p>

<h2>Dapagliflozín mení aj diagnostické ukazovatele</h2>

<p>Pri chronickom začatí inhibítora SGLT2 sa často objaví skorý, zvyčajne reverzibilný pokles eGFR vyplývajúci zo zmeny intraglomerulárnej hemodynamiky. V perioperačnom období je interpretácia kreatinínu ešte zložitejšia pre:</p>

<ul>
  <li>hemodilúciu a transfúzie,</li>
  <li>zmeny objemu tekutín,</li>
  <li>zníženú tvorbu kreatinínu pri katabolizme a imobilite,</li>
  <li>vplyv mimotelového obehu,</li>
  <li>rýchlo sa meniacu filtráciu, ktorú kreatinín sleduje s oneskorením.</li>
</ul>

<p>Súčasne dapagliflozín zvyšuje diurézu, ktorá bola súčasťou primárneho výsledku. Budúce štúdie by preto mali oddelene vykazovať:</p>

<ul>
  <li>AKI definované kreatinínom,</li>
  <li>AKI definované diurézou,</li>
  <li>perzistentné AKI,</li>
  <li>potrebu náhrady funkcie obličiek,</li>
  <li>biomarkerovo potvrdené poškodenie tubulov,</li>
  <li>dlhodobý vývoj eGFR a albuminúrie.</li>
</ul>

<h2>Ako výsledok zapadá do ostatných dôkazov</h2>

<p>MERCURI-2 nie je jediná práca k tejto otázke a observačné údaje sú nejednotné. Ich porovnanie je poučné práve preto, že sa líšia definíciou AKI.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie štúdií o inhibítoroch SGLT2 a pooperačnom AKI" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Dizajn a populácia</th>
      <th scope="col">Definícia AKI</th>
      <th scope="col">Výsledok</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">MERCURI-2 (2026)</th>
      <td>randomizovaná, 784 pacientov, elektívna kardiochirurgia, <em>začatie</em> dapagliflozínu</td>
      <td>KDIGO: kreatinín <strong>aj</strong> diuréza</td>
      <td>28 % oproti 52 %; RR 0,54 (0,45 až 0,65)</td>
    </tr>
    <tr>
      <th scope="row">Ruste a spol. (2026)</th>
      <td>retrospektívna kohorta, 509 pacientov, kardiochirurgia s mimotelovým obehom, <em>chronická</em> liečba</td>
      <td>KDIGO: <strong>len kreatinín</strong></td>
      <td>35 % oproti 30 %; RR 1,12 (0,80 až 1,55) — bez prínosu</td>
    </tr>
    <tr>
      <th scope="row">Gao a spol. (2026)</th>
      <td>emulácia cieľovej štúdie, 2 499 pacientov s diabetom 2. typu, rôzne operácie</td>
      <td>rutinne zbierané údaje</td>
      <td>18,6 % oproti 25,8 %; upravený OR 0,71 (0,56 až 0,91)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Francúzska kohorta autorov Ruste a spol. je pre uvedenú úvahu obzvlášť zaujímavá: hodnotila AKI <strong>výlučne podľa kreatinínu</strong> a prínos nezistila, hoci autori sami priznávajú nedostatočnú silu. Zapadá to do obrazu, v ktorom je pri kreatinínovom kritériu účinok podstatne menší než pri kombinovanom kritériu s diurézou.</p>

<h2>Možno podľa štúdie prestať vysadzovať inhibítory SGLT2?</h2>

<p><strong>Zatiaľ nie</strong> — a to hneď z dvoch dôvodov.</p>

<p>Prvý je logický: <em>MERCURI-2 na túto otázku vôbec neodpovedá.</em> Pacienti už liečení inhibítorom SGLT2 boli zo štúdie vylúčení. Štúdia teda testovala <strong>začatie</strong> lieku, nie <strong>pokračovanie</strong> chronickej liečby cez operáciu. To sú farmakologicky aj klinicky odlišné situácie: chronický používateľ má iný metabolický stav, dlhšie trvajúcu glykosúriu a spravidla aj kardiorenálnu indikáciu.</p>

<p>Druhý je dôkazný: jedna štúdia nestačí na zmenu bezpečnostných odporúčaní. Doterajšie odporúčania na prerušenie inhibítora SGLT2 pred plánovanou operáciou vznikli na základe farmakológie liekov a hlásených prípadov perioperačnej euglykemickej ketoacidózy. Napriek krátkemu plazmatickému polčasu môže farmakodynamický účinok — glykosúria a ketogénny posun — pretrvávať dlhšie.</p>

<p>MERCURI-2 nevylučuje riziko u:</p>

<ul>
  <li>pacientov s diabetom 1. typu,</li>
  <li>diabetikov s nedostatkom inzulínu,</li>
  <li>pacientov liečených intenzifikovaným inzulínovým režimom,</li>
  <li>ľudí s nízkym BMI alebo malnutríciou,</li>
  <li>pacientov s anamnézou ketoacidózy,</li>
  <li>urgentne operovaných pacientov,</li>
  <li>pacientov s dlhým hladovaním,</li>
  <li>osôb so sepsou alebo hemodynamickou nestabilitou,</li>
  <li>pacientov s pokročilou CKD (eGFR pod 20 ml/min/1,73 m²),</li>
  <li>pacientov podstupujúcich nekardiochirurgické výkony.</li>
</ul>

<p>Výsledok nemožno automaticky preniesť ani na empagliflozín, kanagliflozín či ertugliflozín. Triedový účinok je biologicky pravdepodobný, ale musí byť klinicky overený.</p>

<h3>Čo hovoria platné odporúčania</h3>

<p>Americká FDA odporúča prerušiť liečbu inhibítorom SGLT2 pred plánovanou operáciou, a to <strong>bez ohľadu na to, či má pacient diabetes</strong>: dapagliflozín, kanagliflozín a empagliflozín najmenej 3 dni a ertugliflozín najmenej 4 dni pred výkonom. Liečbu možno obnoviť po návrate perorálneho príjmu k východiskovému stavu a po odznení ostatných rizikových faktorov ketoacidózy.</p>

<p>Multidisciplinárne konsenzuálne stanovisko SPAQI z roku 2026, publikované v <em>British Journal of Anaesthesia</em>, tento paušálny prístup posúva k <strong>individualizovanému manažmentu</strong> podľa prítomnosti diabetu a ďalších komorbidít, typu výkonu a perioperačného príjmu potravy, spolu so stratégiami monitorovania a prevencie euglykemickej ketoacidózy. Stanovisko vzniklo modifikovaným delfským procesom podporeným systematickým prehľadom literatúry.</p>

<p>Pre slovenskú prax je rozhodujúci platný súhrn charakteristických vlastností lieku registrovaný v Európskej únii a miestny anestéziologický alebo diabetologický protokol. Americké odporúčania nie sú na Slovensku regulačne záväzné.</p>

<h2>Pacienti bez diabetu</h2>

<p>Riziko ketoacidózy je u pacientov bez diabetu podstatne nižšie. <strong>Nie je však nulové.</strong> Ketoacidóza bola zriedkavo opísaná aj u nediabetických pacientov užívajúcich inhibítory SGLT2 pre srdcové zlyhávanie alebo CKD, najmä pri hladovaní, nízkosacharidovej diéte alebo závažnom akútnom ochorení. Regulačné odporúčanie FDA na perioperačné prerušenie sa výslovne vzťahuje aj na pacientov bez diabetu.</p>

<p>MERCURI-2 nebola dostatočne veľká na spoľahlivé stanovenie bezpečnosti v jednotlivých podskupinách. Nemožno preto zaviesť všeobecné pravidlo, že pacient bez diabetu môže pokračovať v liečbe bez perioperačného hodnotenia.</p>

<div class="pdf-avoid-break">
<h2>Čo robiť v súčasnej klinickej praxi</h2>

<p>Kým výsledok nepotvrdia ďalšie štúdie a neprevezmú ho aktualizované regulačné a odborné odporúčania, je rozumné:</p>

<ol>
  <li><strong>Nezačínať dapagliflozín pred operáciou iba na prevenciu AKI mimo klinickej štúdie.</strong></li>
  <li><strong>Pri plánovanej operácii naďalej postupovať podľa aktuálne platného lokálneho protokolu</strong> pre vysadenie inhibítora SGLT2 a podľa platného súhrnu charakteristických vlastností lieku.</li>
  <li><strong>Individuálne zvážiť riziko</strong> ketoacidózy, dehydratácie, dekompenzácie srdcového zlyhávania a prerušenia kardiorenálnej liečby; u nízkorizikového pacienta pred krátkym výkonom s rýchlym návratom príjmu potravy môže byť individualizovaný postup podľa SPAQI opodstatnený.</li>
  <li><strong>Po operácii obnoviť liek</strong> až pri hemodynamickej stabilite, dostatočnom príjme potravy a tekutín a neprítomnosti ketózy alebo významného AKI.</li>
  <li><strong>Pri urgentnej operácii aktívne monitorovať</strong> acidobázickú rovnováhu a krvné ketóny, ak pacient inhibítor SGLT2 nedávno užíval.</li>
  <li><strong>Nezamieňať zachovanú diurézu za dôkaz ochrany obličiek</strong> u pacienta liečeného inhibítorom SGLT2; hodnotiť aj kreatinín a klinický kontext.</li>
</ol>
</div>

<h2>Ďalšie postupy prevencie pooperačného AKI</h2>

<p>Dapagliflozín nenahrádza základnú perioperačnú ochranu obličiek. Tá zahŕňa najmä:</p>

<ul>
  <li>predoperačné rozpoznanie CKD a albuminúrie,</li>
  <li>korekciu hypovolémie,</li>
  <li>vyhýbanie sa dlhšie trvajúcej hypotenzii,</li>
  <li>optimalizáciu srdcového výdaja a venóznej kongescie,</li>
  <li>individualizované riadenie tekutín,</li>
  <li>kontrolu glykémie bez ťažkej hypoglykémie,</li>
  <li>obmedzenie nefrotoxických liekov,</li>
  <li>správne dávkovanie liekov podľa funkcie obličiek,</li>
  <li>sledovanie kreatinínu a diurézy,</li>
  <li>včasné rozpoznanie infekcie a nízkeho srdcového výdaja.</li>
</ul>

<p>Rutinné používanie „renálnych dávok“ dopamínu, fenoldopamu, manitolu alebo diuretík výhradne na prevenciu AKI nemá presvedčivú oporu. Diuretiká sú indikované na liečbu objemového preťaženia, nie na prevenciu AKI ani na urýchlenie zotavenia obličiek.</p>

<div class="pdf-avoid-break">
<h2>Hĺbková vecná kontrola hlavných tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie hlavných tvrdení o štúdii MERCURI-2" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Odborné hodnotenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Dapagliflozín znížil pooperačné AKI z 52 % na 28 %</td><td>Potvrdené v abstrakte MERCURI-2</td></tr>
    <tr><td>Relatívne riziko AKI kleslo o 46 %</td><td>Matematicky správne; RR 0,54 (0,45 až 0,65)</td></tr>
    <tr><td>Liečba zabránila jednému AKI približne na štyroch liečených pacientov</td><td>Platí pre použitý kombinovaný výsledok a skúmanú populáciu</td></tr>
    <tr><td>Dapagliflozín takmer o polovicu znížil štrukturálne poškodenie obličiek</td><td>Nedokázané; výsledok výrazne určila oligúria</td></tr>
    <tr><td>Kritérium diurézy vysvetľuje väčšinu absolútneho rozdielu</td><td>Veľmi pravdepodobné (orientačný prepočet: asi štyri pätiny)</td></tr>
    <tr><td>Znížili sa aj AKI štádia 2 alebo 3</td><td>Uvádza sekundárny zdroj; vo voľne dostupných prameňoch neoveriteľné</td></tr>
    <tr><td>Dapagliflozín znížil mortalitu alebo potrebu náhrady funkcie obličiek</td><td>Nedokázané</td></tr>
    <tr><td>Liečba skrátila pobyt v nemocnici alebo na JIS</td><td>Nedokázané</td></tr>
    <tr><td>Perioperačná ketoacidóza bola zriedkavá</td><td>Áno, vznikla jedna udalosť; štúdia však nemohla spoľahlivo odhadnúť zriedkavé riziko</td></tr>
    <tr><td>Výsledok dokazuje bezpečnosť u všetkých diabetikov</td><td>Nie; vysokorizikové skupiny boli vylúčené</td></tr>
    <tr><td>Riziko ketoacidózy je u pacientov bez diabetu nulové</td><td>Nie</td></tr>
    <tr><td>Výsledok odôvodňuje rutinné začatie dapagliflozínu deň pred operáciou</td><td>Zatiaľ nie</td></tr>
    <tr><td>Podľa štúdie už netreba inhibítory SGLT2 pred operáciou vysadzovať</td><td>Predčasný záver; chronickí používatelia boli zo štúdie vylúčení</td></tr>
    <tr><td>Účinok možno automaticky preniesť na všetky inhibítory SGLT2</td><td>Nedokázané</td></tr>
    <tr><td>Účinok možno preniesť na urgentné a nekardiochirurgické operácie</td><td>Nedokázané; urgentné výkony boli vylúčené</td></tr>
    <tr><td>Výskyt AKI v placebovej skupine výrazne prekročil plánovaný predpoklad</td><td>Áno: 52 % oproti očakávaným 22 %</td></tr>
    <tr><td>Výsledok treba potvrdiť ďalšou randomizovanou štúdiou</td><td>Áno</td></tr>
  </tbody>
</table>
</div>
</div>

<h2>Metodologické zhodnotenie štúdie</h2>

<h3>Silné stránky</h3>

<ul>
  <li>randomizované a zaslepené usporiadanie s placebom a prekapsulovanou liečbou,</li>
  <li>multicentrická realizácia v akademických aj neakademických nemocniciach,</li>
  <li>vysoký podiel dokončeného sledovania (99 %),</li>
  <li>štandardná definícia AKI podľa KDIGO,</li>
  <li>dôsledný zber údajov o diuréze,</li>
  <li>klinicky relevantná perioperačná populácia,</li>
  <li>presne definovaný a jednoducho reprodukovateľný krátkodobý režim (4 dávky),</li>
  <li>vopred publikovaný protokol a registrácia v ClinicalTrials.gov.</li>
</ul>

<h3>Obmedzenia</h3>

<ol>
  <li><strong>Nezvyčajne vysoký výskyt AKI v placebovej skupine.</strong> Hodnota 52 % je viac než dvojnásobkom plánovaného predpokladu 22 % a odráža citlivý záznam oligúrie.</li>
  <li><strong>Primárny výsledok mohol byť farmakologicky ovplyvnený.</strong> Dapagliflozín zvyšuje diurézu a mohol priamo znižovať splnenie oligurického kritéria.</li>
  <li><strong>Prevažovali mierne prípady AKI.</strong> Klinický význam krátkej oligúrie nie je rovnaký ako význam perzistentného kreatinínového AKI.</li>
  <li><strong>Bez dôkazu zlepšenia tvrdých výsledkov.</strong> Mortalita, hospitalizácia ani závažné kardiorenálne príhody sa významne nezmenili.</li>
  <li><strong>Krátke sledovanie.</strong> Primárne sledovanie trvalo sedem dní, sekundárne prevažne 30 dní; chýbajú dlhodobé renálne výsledky.</li>
  <li><strong>Nízke zastúpenie pacientov s diabetom a srdcovým zlyhávaním.</strong> Výsledky neodpovedajú na otázky typických chronických používateľov inhibítorov SGLT2.</li>
  <li><strong>Malé zastúpenie CKD.</strong> Medián eGFR bol 80 ml/min/1,73 m² a pacienti s eGFR pod 20 ml/min/1,73 m² boli vylúčení.</li>
  <li><strong>Vylúčenie doterajších používateľov inhibítora SGLT2.</strong> Štúdia neodpovedá na otázku perioperačného pokračovania chronickej liečby.</li>
  <li><strong>Selektovaná populácia s nízkym rizikom ketoacidózy.</strong> Výsledok nemôže zrušiť bezpečnostné obavy u vylúčených skupín.</li>
  <li><strong>Obmedzená etnická rozmanitosť.</strong> Až 97 % účastníkov tvorili osoby belošského pôvodu.</li>
  <li><strong>Iba elektívna kardiochirurgia.</strong> Zovšeobecnenie na urgentné alebo nekardiochirurgické výkony nie je odôvodnené.</li>
  <li><strong>Veľkosť účinku môže byť nadhodnotená.</strong> Relatívne zníženie o 46 % je pri preventívnej intervencii neobvykle veľké.</li>
  <li><strong>Nedostatočná sila na zriedkavé bezpečnostné príhody.</strong> Jedna ketoacidóza nevylučuje klinicky významné riziko.</li>
</ol>

<h2>Sprievodný komentár a spravodajské spracovanie</h2>

<p>Redakčný komentár Wolfganga C. Winkelmayera a Glenna M. Chertowa, uverejnený spolu so štúdiou, podľa dostupného spravodajského spracovania upozorňuje, že relatívne účinky liečby presahujúce 40 % si zasluhujú „zdravú dávku skepsy“, že vysoký výskyt AKI v placebovej skupine je podstatnou výhradou a že bude dôležité získať údaje o dlhodobom vplyve perioperačnej liečby inhibítorom SGLT2 na funkciu obličiek, vrátane vzniku a progresie CKD. Komentátori zároveň uvádzajú, že veľmi nízke riziko euglykemickej diabetickej ketoacidózy podľa nich neodôvodňuje odopretie lieku s potenciálom významne znížiť riziko pooperačného AKI.</p>

<p>Práve toto posledné hodnotenie je najviac diskutabilné. Vyplýva z jedinej udalosti v populácii, z ktorej boli vopred vylúčené takmer všetky vysokorizikové skupiny, a preto je preň dôkazný základ slabý.</p>

<p>Spravodajské spracovanie v Medscape primerane reprodukuje základné výsledky štúdie a upozorňuje na napätie medzi možným znížením AKI a rizikom ketoacidózy. Niektoré formulácie však vyžadujú korekciu:</p>

<ul>
  <li>označenie rizika ketoacidózy u pacientov bez diabetu za „takmer zanedbateľné“ je príliš kategorické — regulačné odporúčanie FDA sa výslovne vzťahuje aj na nediabetikov,</li>
  <li>pokles kombinovaného AKI nemožno bez výhrad označiť za rovnako veľký pokles parenchýmového poškodenia obličiek,</li>
  <li>neprítomnosť rozdielu v mortalite a ďalších tvrdých výsledkoch si zasluhuje väčší dôraz,</li>
  <li>skutočnosť, že chronickí používatelia inhibítora SGLT2 boli zo štúdie vylúčení, sa v spravodajstve prakticky nespomína, hoci zásadne obmedzuje záver o „netreba vysadzovať“,</li>
  <li>komentáre jednotlivých odborníkov predstavujú interpretáciu, nie súčasť randomizovaného dôkazu.</li>
</ul>

<p>Deklarované záujmy patria k transparentnej interpretácii, hoci samy osebe nedokazujú nesprávnosť vyjadrení. Spoluautor štúdie Abraham H. Hulst deklaroval grantovú podporu z verejných a odborných výskumných zdrojov mimo publikovanej štúdie. Elif I. Ekinciová, citovaná ako externá odborníčka, uviedla poradenské a prednáškové vzťahy so spoločnosťami Bayer, Eli Lilly, AstraZeneca a Boehringer Ingelheim, pričom finančné prostriedky boli podľa článku smerované jej inštitúcii. Doplňme, že Ekinciová je zároveň poslednou autorkou observačnej práce z roku 2026, ktorá u pacientov s diabetom 2. typu zistila nižší výskyt pooperačného AKI pri predoperačnom užívaní inhibítora SGLT2.</p>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Štúdia MERCURI-2 priniesla prvý presvedčivý randomizovaný signál, že krátkodobé perioperačné podávanie dapagliflozínu môže znižovať výskyt AKI po elektívnej operácii srdca. Absolútny rozdiel 24 percentuálnych bodov je klinicky pôsobivý a metodika štúdie je solídna.</p>

<p>Výsledok však nemožno interpretovať bez zásadných výhrad. Primárny ukazovateľ do veľkej miery určila oligúria, ktorú dapagliflozín mení osmotickou diurézou; po odpočítaní tejto zložky sa účinok približuje k rádovo pätinovému zníženiu známemu z chronickej liečby. Nebol dokázaný pokles mortality, hospitalizácie ani závažných kardiorenálnych príhod. Bezpečnostný súbor bol príliš malý a príliš selektovaný na vylúčenie euglykemickej ketoacidózy.</p>

<p><strong>Dapagliflozín sa preto zatiaľ nemá rutinne začínať deň pred operáciou srdca iba na prevenciu AKI. Rovnako je predčasné všeobecne zrušiť perioperačné prerušovanie inhibítorov SGLT2 — najmä preto, že chronickí používatelia týchto liekov boli zo štúdie vylúčení, takže na túto otázku MERCURI-2 vôbec neodpovedá.</strong> O prípadnej zmene praxe majú rozhodnúť nezávislé replikačné štúdie, samostatne vykazované kreatinínové výsledky, dlhodobé renálne sledovanie a aktualizované odborné a regulačné odporúčania.</p>
</div>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ketoacidoza-nefrologicka-prax-hladovanie-euglykemicka-dka">Ketoacidóza v nefrologickej praxi: od hladovania po euglykemickú diabetickú ketoacidózu</a></li>
  <li><a href="article.php?slug=kedy-zacat-krt-pri-aki">Kedy začať náhradnú liečbu obličiek (KRT) pri akútnom poškodení obličiek (AKI)</a></li>
  <li><a href="article.php?slug=estop-aki-strojove-ucenie-vcasna-konzultacia-nefrologa">ESTOP-AKI: algoritmus riziko rozpoznal, včasná konzultácia nefrológa však výsledky nezlepšila</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba chronickej choroby obličiek v roku 2026: vrstvená nefroprotekcia, presná stratifikácia rizika a sledovanie po AKI</a></li>
  <li><a href="article.php?slug=metformin-sglt2-prva-linia-diabetu-2-typu">Metformín s predĺženým uvoľňovaním a inhibítor SGLT2 ako nová prvá línia liečby diabetu 2. typu</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Oosterom-Eijmael MJP, Hulst AH, Monteiro de Oliveira NP, Niesten ED, Wietsma NE, Gerritse BM, Scohy TV, Rettig TCD, Snellen FTF, Voogd MF, Godfried MB, de Boer RN, Wink J, van der Werff LMM, Cobbaert CM, Ruhaak LR, Eberl S, Preckel B, Hollmann MW, Schenk J, Hermanides J, van Raalte DH; MERCURI-2 Study Group.</strong> <em>Dapagliflozin and Acute Kidney Injury Following Cardiac Surgery: A Randomized Clinical Trial.</em> JAMA. Publikované online 30. júla 2026:e269268. doi: 10.1001/jama.2026.9268. <a href="https://doi.org/10.1001/jama.2026.9268" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42530910/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://clinicaltrials.gov/study/NCT05590143" target="_blank" rel="noopener noreferrer">registrácia NCT05590143</a>.</li>
  <li><strong>Winkelmayer WC, Chertow GM.</strong> <em>Dapagliflozin to Reduce the Risk of Perioperative Acute Kidney Injury in Elective Cardiac Surgery.</em> Sprievodný redakčný komentár. JAMA. Publikované online 30. júla 2026. doi: 10.1001/jama.2026.7477. <a href="https://doi.org/10.1001/jama.2026.7477" target="_blank" rel="noopener noreferrer">Editoriál</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42530951/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Oosterom-Eijmael MJP, Hulst AH, van Raalte DH, Hermanides J, a spol.</strong> <em>Study protocol of the multicentre, randomised, triple-blind, placebo-controlled MERCURI-2 trial: promoting effective renoprotection in cardiac surgery patients by inhibition of sodium glucose cotransporter (SGLT)-2.</em> Zdroj vylučovacích kritérií, plánu výsledkov a výpočtu veľkosti súboru. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12086897/" target="_blank" rel="noopener noreferrer">Plný text protokolu</a>.</li>
  <li><strong>Oprea AD, Mohamed B, Hepner DL, Auron M, Richman DC, Umpierrez GE, Edmonston D, Ionescu C, a spol.</strong> <em>Perioperative management of patients taking sodium-glucose cotransporter 2 inhibitors: Society for Perioperative Assessment and Quality Improvement (SPAQI) multidisciplinary consensus statement.</em> Br J Anaesth. 2026;136(6):1776–1799. doi: 10.1016/j.bja.2026.02.031. <a href="https://doi.org/10.1016/j.bja.2026.02.031" target="_blank" rel="noopener noreferrer">Konsenzuálne stanovisko</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42067493/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Ruste M, Vieira A, Le Guennec-Lux Y, Berthod C, Pozzi M, Mewton N, Fellahi JL, Jacquet-Lagrèze M.</strong> <em>Preoperative Exposure to Sodium-Glucose Cotransporter-2 Inhibitors and Acute Kidney Injury After Cardiac Surgery: A Retrospective Single-Centre Cohort Study With Overlap Weighting Propensity Score Analysis.</em> Heart Lung Circ. 2026;35(5):658–667. doi: 10.1016/j.hlc.2026.01.004. Kohorta hodnotiaca AKI len podľa kreatinínu; prínos nezistený. <a href="https://doi.org/10.1016/j.hlc.2026.01.004" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42014291/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Gao FM, Kishore K, Pandey D, Jahanabadi H, Stevens M, Lecamwasam A, Churilov L, Ekinci EI.</strong> <em>Effect of preoperative SGLT2 inhibitor use on postoperative acute kidney injury in patients with type 2 diabetes undergoing surgery: A causal inference study using routinely collected data.</em> Diabetes Obes Metab. 2026;28(4):3193–3201. doi: 10.1111/dom.70509. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12992174/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) Acute Kidney Injury Work Group.</strong> <em>KDIGO Clinical Practice Guideline for Acute Kidney Injury.</em> Kidney Int Suppl. 2012;2:1–138. Inštitucionálne skupinové autorstvo. <a href="https://kdigo.org/guidelines/acute-kidney-injury/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>.</li>
  <li><strong>Kellum JA, Lameire N; KDIGO AKI Guideline Work Group.</strong> <em>Diagnosis, evaluation, and management of acute kidney injury: a KDIGO summary (Part 1).</em> Crit Care. 2013;17(1):204. doi: 10.1186/cc11454. <a href="https://doi.org/10.1186/cc11454" target="_blank" rel="noopener noreferrer">Súhrn odporúčania</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/23394211/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>U.S. Food and Drug Administration.</strong> Bezpečnostné informácie o inhibítoroch SGLT2 a ketoacidóze vrátane odporúčania prerušiť liečbu 3 až 4 dni pred plánovanou operáciou. Inštitucionálne autorstvo; americké regulačné informácie nie sú automaticky záväzné pre Slovensko. <a href="https://www.fda.gov/drugs/drug-safety-and-availability" target="_blank" rel="noopener noreferrer">Bezpečnostné oznámenia FDA</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>SGLT2 inhibitors: PRAC recommendations to minimise risk of diabetic ketoacidosis.</em> Inštitucionálne autorstvo. <a href="https://www.ema.europa.eu/en/medicines/human/referrals/sglt2-inhibitors" target="_blank" rel="noopener noreferrer">Prehodnotenie EMA</a>; <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/forxiga" target="_blank" rel="noopener noreferrer">informácie o lieku Forxiga (dapagliflozín)</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Odporúčania KDIGO</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>Perioperative Dapagliflozin Reduces Acute Kidney Injury After Cardiac Surgery.</em> Medscape, 2026. Sekundárny spravodajský zdroj (obsah za prihlásením). <a href="https://www.medscape.com/viewarticle/perioperative-dapagliflozin-reduces-acute-kidney-injury-2026a1000ru0" target="_blank" rel="noopener noreferrer">Spravodajské spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Údaje o dizajne, populácii, primárnom výsledku (28 % oproti 52 %; RR 0,54; 95 % IS 0,45 až 0,65; P &lt; 0,001), fibrilácii predsiení a reoperáciách boli overené priamo proti abstraktu publikácie v časopise JAMA (PubMed, PMID 42530910). Vylučovacie kritériá, plánovaná veľkosť súboru a predpokladaný 22 % výskyt AKI v placebovej skupine pochádzajú z otvorene dostupného protokolu štúdie. Údaje o podiele prípadov splnených kritériom diurézy (48 % oproti 21 %), o jednej epizóde ketoacidózy a o rozdelení AKI podľa štádií pochádzajú zo sekundárneho spravodajského spracovania a nedali sa overiť vo voľne dostupnom abstrakte; údaj o štádiách 2 a 3 je preto v texte označený za predbežný. Prepočty NNT, absolútnych rozdielov a rozkladu primárneho výsledku podľa kritérií sú vlastné orientačné výpočty z publikovaných percent, nie prevzaté hodnoty. Individuálne mená spolupracovníkov skupiny MERCURI-2 Study Group nie sú v bibliografickom zázname rozvinuté a neboli dopĺňané odhadom.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Rozhodnutie o vysadení alebo ponechaní inhibítora SGLT2 pred operáciou, o dávkovaní a o perioperačnom monitorovaní sa má riadiť platným súhrnom charakteristických vlastností konkrétneho lieku, miestnym anestéziologickým a diabetologickým protokolom a individuálnym rizikom pacienta. Jedna randomizovaná štúdia na selektovanej populácii nie je podkladom na zmenu miestnych protokolov.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_dapagliflozin-kardiochirurgia-aki-mercuri-2_article',
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
