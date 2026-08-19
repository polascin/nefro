<?php
/**
 * Odborny clanok: zazitkove vzdelavanie lekarov (hranie ulohy pacienta) a kompenzacia diabetu 2. typu (CREATION).
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_role-play-vzdelavanie-lekarov-diabetes-creation_article.php"
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
    'title'        => 'Keď si lekár vyskúša úlohu pacienta: môže zážitkové vzdelávanie zlepšiť kompenzáciu diabetu 2. typu?',
    'slug'         => 'role-play-vzdelavanie-lekarov-diabetes-creation',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Čínska klastrová randomizovaná štúdia CREATION zistila, že po týždňovom zážitkovom školení lekárov dosiahlo HbA1c pod 7 % o 17 percentuálnych bodov viac pacientov. Dôkaz sa týka celého programu, nie samotného hrania rolí, a nezahŕňa klinické komplikácie ani obličkové výsledky.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Nedostatočná kompenzácia diabetu 2. typu nie je iba dôsledkom nízkej účinnosti liekov alebo slabej adherencie pacienta. Významnú úlohu majú klinická zotrvačnosť, komunikačné nedostatky a rozdiel medzi znalosťou odporúčaní a ich uplatňovaním v praxi. Čínska klastrová randomizovaná štúdia skúmala, či tento rozdiel možno zmenšiť intenzívnym zážitkovým vzdelávaním lekárov, ktorého súčasťou bolo hranie úlohy pacienta.</em></p>

<h2>Prečo je téma dôležitá</h2>

<p>Rozdiel medzi tým, čo odporúčania hovoria, a tým, čo sa reálne deje v ambulancii, sa v anglickej literatúre označuje ako <em>guideline-implementation gap</em>. Pri diabete 2. typu ide o dlhodobo dokumentovaný problém s priamymi dôsledkami pre obličky, srdce a cievy.</p>

<p>Väčšina intervencií proti klinickej zotrvačnosti sa zameriava na algoritmy, pripomienky v informačnom systéme alebo na audit a spätnú väzbu. Štúdia CREATION zvolila iný prístup: nechala lekárov prežiť si časť pacientskej skúsenosti na vlastnej koži.</p>

<p>Výsledky ukázali klinicky významné zvýšenie podielu pacientov, ktorí dosiahli HbA1c pod 7,0 %. Štúdia však <strong>nepreukazuje</strong>, že účinnou zložkou bolo samotné hranie rolí — testovala komplexný týždňový program. Nepreukázala ani zníženie výskytu mikrovaskulárnych, kardiovaskulárnych alebo obličkových príhod.</p>

<h2>Dizajn štúdie</h2>

<div class="table-responsive" role="region" aria-label="Základné parametre štúdie CREATION" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Údaj</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Dizajn</th><td>otvorená, dvojramenná paralelná klastrová randomizovaná klinická štúdia</td></tr>
    <tr><th scope="row">Pracoviská</th><td>205 centier v Číne</td></tr>
    <tr><th scope="row">Randomizačná jednotka</th><td>lekár (centrum), nie jednotlivý pacient</td></tr>
    <tr><th scope="row">Fáza 1 — lekári</th><td>205 lekárov zaradených od 13. februára do 29. apríla 2023</td></tr>
    <tr><th scope="row">Fáza 2 — pacienti</th><td>2 017 pacientov zaradených od 28. februára do 19. septembra 2023</td></tr>
    <tr><th scope="row">Sledovanie</th><td>12 mesiacov; ukončené 25. októbra 2024</td></tr>
    <tr><th scope="row">Primárny ukazovateľ</th><td>podiel pacientov s HbA1c pod 7,0 % po 6 mesiacoch</td></tr>
    <tr><th scope="row">Registrácia</th><td>ClinicalTrials.gov NCT05715307</td></tr>
    <tr><th scope="row">Zadávateľ</th><td>Shanghai Jiao Tong University School of Medicine</td></tr>
  </tbody>
</table>
</div>

<p>Lekári boli randomizovaní do dvoch ramien: 103 do intenzívneho zážitkového školenia a 102 do štandardného školenia. Následne zaradili pacientov — 1 009 do intervenčného a 1 008 do kontrolného ramena.</p>

<p>Priemerný vek lekárov bol 36,2 roka (smerodajná odchýlka 5,1) a ženy tvorili 75,6 % (155 z 205). Pacienti mali priemerný vek 53,0 roka (7,0), muži tvorili 64,7 % (1 304 z 2 017) a ženy 35,3 % (713).</p>

<p>Podľa registračného záznamu boli zaraďovaní pacienti vo veku 40 až 65 rokov s BMI nad 24,0 a najviac 35,0 kg/m², so skríningovým HbA1c od 7,5 do 10,0 %, s glykémiou nalačno od 8,0 do 13,3 mmol/l, s trvaním diabetu do 10 rokov a s nedostatočnou kontrolou pri jednom alebo dvoch neinzulínových antidiabetikách užívaných najmenej dva mesiace.</p>

<div class="pdf-avoid-break">
<h3>Nefrologicky podstatné vylučovacie kritérium</h3>

<p><strong>Podľa registračného záznamu boli zo štúdie vylúčení pacienti s eGFR pod 60 ml/min/1,73 m²</strong>, teda všetci s chronickou chorobou obličiek v štádiu G3a a vyššom. Vylúčení boli aj pacienti so závažným srdcovým ochorením vrátane srdcového zlyhávania triedy NYHA III a IV a s akútnymi diabetickými komplikáciami v predchádzajúcich troch mesiacoch.</p>

<p>Ide o zásadné obmedzenie pre nefrologickú interpretáciu: <em>program nebol testovaný práve u tých pacientov, u ktorých je manažment diabetu najzložitejší a rozhodovanie najviac zaťažené rizikom hypoglykémie, úpravou dávok a liekovými interakciami.</em></p>
</div>

<h2>Charakter intervencie</h2>

<p>Obe skupiny lekárov absolvovali online školenie o manažmente diabetu, o protokole štúdie a o používaní digitálnej platformy Metabolic Management Center.</p>

<p>Intervenčná skupina navyše absolvovala <strong>týždňové prezenčné intenzívne školenie</strong>, počas ktorého lekári:</p>

<ul>
  <li>preberali úlohu pacientov,</li>
  <li>absolvovali simulované vyšetrenia súvisiace s diabetom,</li>
  <li>riešili scenáre diabetických komplikácií,</li>
  <li>podstupovali intervencie zamerané na životný štýl,</li>
  <li>nacvičovali osobné rozhovory a komunikáciu.</li>
</ul>

<p>Sekundárne sa hodnotili výsledky po 12 mesiacoch, antropometrické a metabolické ukazovatele, životný štýl, nežiaduce udalosti a vedomosti lekárov.</p>

<h2>Hlavné výsledky</h2>

<div class="table-responsive" role="region" aria-label="Podiel pacientov s HbA1c pod 7,0 %" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Časový bod</th>
      <th scope="col">Intenzívne školenie</th>
      <th scope="col">Štandardné školenie</th>
      <th scope="col">Upravený rozdiel (95 % IS)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">6 mesiacov</th>
      <td>58,0 % (476 z 820)</td>
      <td>42,9 % (351 z 818)</td>
      <td>16,6 p. b. (7,2 až 25,7); P &lt; 0,001</td>
    </tr>
    <tr>
      <th scope="row">12 mesiacov</th>
      <td>60,9 % (502 z 824)</td>
      <td>44,6 % (371 z 832)</td>
      <td>17,0 p. b. (7,0 až 26,8); P &lt; 0,001</td>
    </tr>
  </tbody>
</table>
</div>

<p>Skratka „p. b.“ znamená percentuálny bod. Ak by bol tento rozdiel kauzálny a prenosný do porovnateľnej klinickej praxe, približne šesť pacientov by muselo byť manažovaných lekárom po intenzívnom školení, aby jeden ďalší dosiahol HbA1c pod 7,0 %. Ide však iba o orientačný prepočet z priemerného rozdielu, nie o všeobecne platný počet potrebný na liečbu.</p>

<p>Všimnime si šírku intervalov spoľahlivosti: dolná hranica 7,2 respektíve 7,0 percentuálneho bodu. Účinok je teda štatisticky presvedčivý, ale jeho skutočná veľkosť môže byť podstatne menšia než bodový odhad. Široký interval je pri klastrovej randomizácii s 205 klastrami očakávaný.</p>

<h3>Ďalšie výsledky po 12 mesiacoch</h3>

<div class="table-responsive" role="region" aria-label="Sekundárne metabolické a antropometrické ukazovatele" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Upravený rozdiel medzi skupinami (95 % IS)</th>
      <th scope="col">Interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">BMI</th><td>−0,3 kg/m² (−0,5 až −0,1)</td><td>Malý účinok na úrovni jednotlivca</td></tr>
    <tr><th scope="row">Obvod pása</th><td>−1,4 cm (−2,1 až −0,8)</td><td>Malý, štatisticky významný rozdiel</td></tr>
    <tr><th scope="row">Glykémia nalačno</th><td>−6,3 mg/dl, teda asi −0,35 mmol/l (−10,7 až −1,9 mg/dl)</td><td>Skromný metabolický účinok</td></tr>
    <tr><th scope="row">Systolický krvný tlak</th><td>−1,5 mm Hg (−2,9 až −0,1)</td><td>Malý rozdiel s neistým individuálnym významom</td></tr>
  </tbody>
</table>
</div>

<p>V intervenčnom ramene sa zaznamenali aj priaznivejšie zmeny niektorých údajov o stravovaní, konzumácii alkoholu a dĺžke spánku. Lekári dosiahli väčšie zlepšenie vedomostí a malé zníženie vlastného BMI.</p>

<p>Závažné nežiaduce udalosti sa vyskytli u 2,6 % pacientov v intervenčnej skupine (26 z 1 009) a u 2,4 % v kontrolnej skupine (24 z 1 008).</p>

<div class="pdf-avoid-break">
<h3>Rozpor medzi veľkým rozdielom v HbA1c a malými zmenami ostatných ukazovateľov</h3>

<p>Za povšimnutie stojí nepomer: podiel pacientov v cieli sa zvýšil o 17 percentuálnych bodov, ale glykémia nalačno klesla iba o 0,35 mmol/l, BMI o 0,3 kg/m² a systolický tlak o 1,5 mm Hg.</p>

<p>Takýto vzorec sa dá vysvetliť viacerými spôsobmi. Binárny ukazovateľ „pod 7,0 %“ je citlivý na malý posun celej distribúcie okolo prahovej hodnoty — ak leží veľká časť pacientov tesne nad hranicou, aj mierne zlepšenie HbA1c prekloní mnohých pod ňu. Zmena môže tiež pochádzať prevažne z postprandiálnej glykémie, ktorú lačná hodnota nezachytáva, alebo z intenzifikácie farmakoterapie, ktorá HbA1c ovplyvní viac než hmotnosť či tlak.</p>

<p>Bez podrobných údajov o zmenách liečby nemožno medzi týmito vysvetleniami rozhodnúť. Pre klinickú interpretáciu to znamená, že veľkosť účinku vyjadrená podielom pacientov v cieli pôsobí pôsobivejšie než priemerné metabolické posuny, ktoré ju sprevádzajú.</p>
</div>

<h2>Metodologické silné stránky</h2>

<p>Najväčšou prednosťou je randomizovaný dizajn. Klastrová randomizácia bola pri vzdelávacej intervencii primeraná — randomizácia jednotlivých pacientov toho istého lekára by viedla ku kontaminácii medzi ramenami.</p>

<ul>
  <li>veľký počet klastrov (205 centier), čo je pri klastrových štúdiách priaznivé,</li>
  <li>viac než dvetisíc pacientov a 12-mesačné sledovanie,</li>
  <li>objektívnejší primárny ukazovateľ než dotazníkové hodnotenie vedomostí alebo spokojnosti,</li>
  <li>deklarovaná analýza podľa princípu <em>intention-to-treat</em>,</li>
  <li>výsledky prezentované s intervalmi spoľahlivosti,</li>
  <li>vopred registrovaný protokol,</li>
  <li>hodnotenie bezpečnosti aj zmien vedomostí lekárov.</li>
</ul>

<h2>Dôležité metodologické obmedzenia</h2>

<h3>Pacienti boli zaraďovaní až po randomizácii centier</h3>

<p>Lekári boli randomizovaní od 13. februára do 29. apríla 2023, zatiaľ čo pacienti sa zaraďovali od 28. februára do 19. septembra 2023. Lekári teda poznali pridelenie svojho centra skôr, než zaradili väčšinu pacientov, a mohli vedome či nevedome vyberať odlišnú skupinu pacientov. Toto skreslenie sa v klastrových štúdiách označuje ako <em>identification bias</em> alebo <em>recruitment bias</em> a ani deklarovaný konsekutívny nábor ho úplne neodstraňuje.</p>

<h3>Otvorený dizajn</h3>

<p>Lekárov nebolo možné zaslepiť. Intenzívne školení lekári vedeli, že dostali nadštandardnú intervenciu, čo mohlo zvýšiť ich pozornosť, frekvenciu kontaktov, motiváciu aj intenzitu farmakoterapie. Časť účinku mohol predstavovať Hawthornov efekt.</p>

<h3>Kontrolná intervencia nemala rovnakú intenzitu</h3>

<p>Kontrolná skupina neabsolvovala časovo porovnateľné prezenčné školenie bez hrania rolí. Nemožno preto oddeliť špecifický účinok simulácie pacientskej skúsenosti od účinku dodatočného týždňa vzdelávania, osobnej interakcie a spätnej väzby. <strong>Nadpis o „hraní úlohy pacienta“ preto vystihuje intervenciu iba čiastočne.</strong></p>

<h3>Chýbajúce merania HbA1c</h3>

<p>Primárny výsledok bol uvedený ako 476 z 820 a 351 z 818, hoci randomizované ramená zahŕňali 1 009 a 1 008 pacientov. Do týchto podielov teda nebolo zahrnutých približne 19 % zaradených pacientov.</p>

<p>Za zmienku stojí, že v 12. mesiaci boli menovatele dokonca vyššie (824 a 832) než v 6. mesiaci. Časť pacientov teda mala k dispozícii 12-mesačné, ale nie 6-mesačné meranie. Autori označili primárnu analýzu za analýzu podľa princípu <em>intention-to-treat</em>, no na úplné posúdenie rizika skreslenia treba poznať spôsob imputácie chýbajúcich údajov a výsledky citlivostných analýz.</p>

<h3>Náhradný primárny ukazovateľ</h3>

<p>HbA1c pod 7 % je klinicky relevantný, ale nie je priamym dôkazom prevencie terminálneho zlyhania obličiek, infarktu, mozgovej príhody, amputácie alebo smrti. Univerzálny cieľ pod 7 % navyše nie je vhodný pre každého pacienta — u starších, krehkých a u pacientov s pokročilou chronickou chorobou obličiek môže byť prísny cieľ nevhodný pre riziko hypoglykémie.</p>

<h3>Nejasný mechanizmus účinku</h3>

<p>Bez podrobného porovnania zmien farmakoterapie, dávok, adherencie, frekvencie kontrol a využívania glukózového monitorovania nemožno určiť, ako program znížil HbA1c. Výsledok mohla sprostredkovať intenzifikácia liečby rovnako ako zmena komunikácie alebo životného štýlu. Tieto dve cesty majú pritom odlišné dôsledky pre bezpečnosť a náklady.</p>

<h3>Neistá udržateľnosť a nákladová efektívnosť</h3>

<p>Týždňové prezenčné školenie je organizačne a finančne náročné. Štúdia neposkytuje dostatočné údaje o nákladoch ani o zachovaní účinku po dlhšom období. Nevieme ani, či by kratší alebo dištančný formát priniesol porovnateľný výsledok.</p>

<h3>Obmedzená prenositeľnosť</h3>

<p>Štúdia prebiehala v čínskej sieti centier metabolického manažmentu s jednotnou digitálnou platformou, u relatívne mladých lekárov (priemerný vek 36 rokov) a u vybranej skupiny pacientov stredného veku s nadhmotnosťou a diabetom trvajúcim menej než 10 rokov. Organizácia zdravotníctva, dostupnosť liekov, vzdelávacia kultúra aj typický pacient sa na Slovensku líšia.</p>

<div class="pdf-avoid-break">
<h2>Hĺbková vecná kontrola hlavných tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie hlavných tvrdení o štúdii CREATION" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Hranie úlohy pacienta zlepšilo glykemickú kontrolu</td><td><strong>Čiastočne potvrdené</strong></td><td>Účinný bol komplexný týždňový program obsahujúci hranie rolí; samostatný účinok tejto zložky nebol izolovaný</td></tr>
    <tr><td>Program zvýšil podiel pacientov s HbA1c pod 7 %</td><td><strong>Potvrdené</strong></td><td>Upravený rozdiel 16,6 p. b. po 6 mesiacoch a 17,0 p. b. po 12 mesiacoch, oba s P &lt; 0,001</td></tr>
    <tr><td>Zlepšili sa aj hmotnosť, tlak a glykémia nalačno</td><td><strong>Potvrdené, ale rozdiely sú malé</strong></td><td>BMI −0,3 kg/m², obvod pása −1,4 cm, systolický tlak −1,5 mm Hg, glykémia nalačno asi −0,35 mmol/l</td></tr>
    <tr><td>Lekári po školení „lepšie manažovali diabetes“</td><td><strong>Pravdepodobné, ale príliš všeobecné</strong></td><td>Dokázalo sa najmä zlepšenie glykemického výsledku; kvalita manažmentu zahŕňa aj bezpečnosť, individualizáciu a kardiorenálnu ochranu</td></tr>
    <tr><td>Program zlepšil celkové zdravie pacientov</td><td><strong>Nepreukázané v plnom rozsahu</strong></td><td>Zlepšili sa vybrané náhradné a behaviorálne ukazovatele, nie klinické komplikácie ani mortalita</td></tr>
    <tr><td>Intervencia bola bezpečná</td><td><strong>Bez zjavného bezpečnostného signálu</strong></td><td>2,6 % oproti 2,4 % závažných udalostí; štúdia nebola primárne dimenzovaná na hodnotenie bezpečnosti liečebných zmien</td></tr>
    <tr><td>Program prekonáva rozdiel medzi odporúčaniami a praxou</td><td><strong>Podporené, nie definitívne dokázané</strong></td><td>Implementačná medzera zahŕňa viac než glykemický cieľ, napríklad kardiorenálnu ochranu a dostupnosť liečby</td></tr>
    <tr><td>Výsledky sú prenosné do slovenskej praxe</td><td><strong>Neisté</strong></td><td>Obmedzujú ju rozdiely v organizácii zdravotníctva, kultúre, vzdelávaní a dostupnosti liekov</td></tr>
    <tr><td>Program môže chrániť obličky</td><td><strong>Nepreukázané</strong></td><td>Štúdia nehodnotila obličkové ukazovatele a pacientov s eGFR pod 60 ml/min/1,73 m² vôbec nezaradila</td></tr>
  </tbody>
</table>
</div>
</div>

<h2>Nefrologické súvislosti</h2>

<p>Diabetes 2. typu je jednou z najvýznamnejších príčin chronickej choroby obličiek. Lepšia dlhodobá glykemická kontrola môže znižovať riziko diabetickej mikroangiopatie, ale z tejto štúdie nemožno odvodiť renoprotektívny účinok vzdelávacieho programu.</p>

<p>Nehodnotili sa:</p>

<ul>
  <li>trvalý pokles odhadovanej glomerulovej filtrácie,</li>
  <li>vznik alebo progresia albuminúrie,</li>
  <li>zdvojnásobenie sérového kreatinínu,</li>
  <li>terminálne zlyhanie obličiek,</li>
  <li>potreba náhrady funkcie obličiek,</li>
  <li>obličková alebo celková mortalita.</li>
</ul>

<p>Pripomeňme navyše, že pacienti s eGFR pod 60 ml/min/1,73 m² boli zo štúdie vylúčení. Program teda nebol overený u populácie, ktorá nefrológa zaujíma najviac.</p>

<p>Kvalitný manažment diabetu u pacienta s chronickou chorobou obličiek nemožno redukovať na HbA1c. Musí zahŕňať pravidelné vyšetrovanie eGFR a albuminúrie, kontrolu krvného tlaku a správne použitie inhibítorov systému renín-angiotenzín, inhibítorov SGLT2, agonistov receptora GLP-1 a pri vhodnej indikácii nesteroidného antagonistu mineralokortikoidového receptora.</p>

<p>Osobitnú pozornosť vyžaduje interpretácia HbA1c pri pokročilej chronickej chorobe obličiek, anémii, liečbe látkami stimulujúcimi erytropoézu, po nedávnej transfúzii a pri dialýze. V týchto situáciách môže HbA1c nepresne odrážať skutočnú glykémiu, pretože sa mení dĺžka prežívania erytrocytov.</p>

<div class="pdf-avoid-break">
<h3>Ako by mohol vyzerať nefrologický variant takéhoto vzdelávania</h3>

<p>Ak by sa podobný program pripravoval pre nefrológiu, simulované scenáre by mali zahŕňať:</p>

<ul>
  <li>úpravu dávok liekov podľa eGFR,</li>
  <li>prevenciu hypoglykémie pri zníženej funkcii obličiek,</li>
  <li>pravidlá dočasného vysadenia vybraných liekov počas akútneho ochorenia (takzvané „sick day rules“),</li>
  <li>prevenciu euglykemickej ketoacidózy pri inhibítoroch SGLT2,</li>
  <li>manažment hyperkaliémie a retencie tekutín,</li>
  <li>polyfarmáciu a liekové interakcie,</li>
  <li>koordináciu nefrológa, diabetológa, všeobecného lekára, sestry a nutričného terapeuta,</li>
  <li>rozhovor o cieľoch starostlivosti pri pokročilej chorobe obličiek.</li>
</ul>
</div>

<h2>Praktický záver</h2>

<p>Týždňové intenzívne prezenčné školenie lekárov, ktorého súčasťou bolo preberanie úlohy pacienta, zvýšilo v čínskej klastrovej randomizovanej štúdii podiel pacientov s diabetom 2. typu dosahujúcich HbA1c pod 7 % približne o 17 percentuálnych bodov.</p>

<p>Výsledok podporuje význam praktického, komunikačného a zážitkového vzdelávania. Dôkaz sa však týka celého viacprvkového programu, nie samotného hrania rolí. Nemožno z neho odvodiť prevenciu diabetických komplikácií ani renoprotekciu — a už vôbec nie u pacientov s chronickou chorobou obličiek, ktorí do štúdie neboli zaradení.</p>

<p>Pre slovenskú prax by bolo primerané pilotné overenie podobného programu s <strong>aktívnou kontrolnou skupinou s rovnakou časovou dotáciou</strong>, s ekonomickým hodnotením a so širšími výsledkami zahŕňajúcimi hypoglykémie, albuminúriu, eGFR, používanie kardiorenálne ochrannej liečby, hospitalizácie, kvalitu života a dlhodobú udržateľnosť účinku.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
  <li><a href="article.php?slug=kontinualne-monitorovanie-glukozy-diabetes-2-typu-bez-inzulinu">Kontinuálne monitorovanie glukózy môže pomôcť aj pacientom s diabetom 2. typu bez inzulínu</a></li>
  <li><a href="article.php?slug=12-knih-lekar-choroba-pacient-narativna-medicina">Dvanásť kníh, ktoré môžu lekárovi pomôcť lepšie rozumieť chorobe, pacientovi aj sebe</a></li>
  <li><a href="article.php?slug=neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt">Keď pacient nechce hovoriť o svojich hodnotách: skrytá prekážka spoločného rozhodovania o dialýze</a></li>
  <li><a href="article.php?slug=predialyzacna-edukacia-volba-peritonealnej-dialyzy">Predialyzačná edukácia a voľba peritoneálnej dialýzy: čo ukázala poľská kohorta</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Zhang Y, Peng Y, Chen Y, Ke T, Xu F, Wu S, Dai Y, Sun L, Zheng Q, Hu Z, Dong Q, Shi J, Wu X, Shi Y, Tang R, Sha Y, Chen R, Xu B, Li S, Liu L, Gao M, Zhao D, Yi Q, Kang Z, Wang W; Chinese Endocrinologists Health Education Study (CREATION) group.</strong> <em>Role-Playing-Based Physician Training and Metabolic Outcomes Among Patients With Type 2 Diabetes: A Cluster Randomized Clinical Trial.</em> JAMA Netw Open. 2026;9(8):e2627376. doi: 10.1001/jamanetworkopen.2026.27376. <a href="https://doi.org/10.1001/jamanetworkopen.2026.27376" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42560674/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Shanghai Jiao Tong University School of Medicine.</strong> <em>Chinese Endocrinologists Health Education Study (CREATION).</em> ClinicalTrials.gov, NCT05715307. Zdroj zaraďovacích a vylučovacích kritérií vrátane hranice eGFR. <a href="https://clinicaltrials.gov/study/NCT05715307" target="_blank" rel="noopener noreferrer">Registračný záznam</a>.</li>
  <li><strong>de Boer IH, Khunti K, Sadusky T, Tuttle KR, Neumiller JJ, Rhee CM, Rosas SE, Rossing P, Bakris G.</strong> <em>Diabetes Management in Chronic Kidney Disease: A Consensus Report by the American Diabetes Association (ADA) and Kidney Disease: Improving Global Outcomes (KDIGO).</em> Diabetes Care. 2022;45(12):3075–3090. doi: 10.2337/dci22-0027. <a href="https://doi.org/10.2337/dci22-0027" target="_blank" rel="noopener noreferrer">Konsenzuálna správa</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/36189689/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) Diabetes Work Group.</strong> <em>KDIGO 2022 Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease.</em> Kidney Int. 2022;102(5 Suppl):S1–S127. doi: 10.1016/j.kint.2022.06.008. Inštitucionálne skupinové autorstvo. <a href="https://kdigo.org/guidelines/diabetes-ckd/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>Role-Play as Patients Helps Docs Manage Diabetes Better.</em> Medscape, 2026. Sekundárny spravodajský zdroj použitý ako východisko, nie ako hlavný dôkaz; individuálny autor nie je v sprístupnenej verzii uvedený. <a href="https://www.medscape.com/viewarticle/role-play-patients-helps-docs-manage-diabetes-better-2026a1000rn5" target="_blank" rel="noopener noreferrer">Spravodajské spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Údaje o dizajne, dátumoch zaraďovania, počtoch lekárov a pacientov, o primárnom aj sekundárnych ukazovateľoch vrátane intervalov spoľahlivosti a o závažných nežiaducich udalostiach boli overené priamo proti abstraktu publikácie v JAMA Network Open (PubMed, PMID 42560674). Zaraďovacie a vylučovacie kritériá vrátane hranice eGFR 60 ml/min/1,73 m², vekového rozpätia 40 až 65 rokov a rozpätia BMI pochádzajú z registračného záznamu NCT05715307. Trvanie diabetu, východiskový BMI a východiskový HbA1c jednotlivých ramien publikovaný abstrakt neuvádza, preto sa v texte uvádzajú iba kritériá zaradenia, nie priemerné hodnoty súboru. Orientačný prepočet počtu potrebného na liečbu je vlastný výpočet z upraveného rozdielu, nie prevzatá hodnota. Autorstvo bolo overené cez PubMed; mená neboli dopĺňané odhadom.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Cieľová hodnota HbA1c sa má stanoviť individuálne podľa veku, komorbidít, rizika hypoglykémie, funkcie obličiek a preferencií pacienta. Pri chronickej chorobe obličiek treba postupovať podľa platných odporúčaní KDIGO a ADA a HbA1c interpretovať s vedomím jeho obmedzenej výpovednej hodnoty pri anémii, liečbe stimulátormi erytropoézy a pri dialýze.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_role-play-vzdelavanie-lekarov-diabetes-creation_article',
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
