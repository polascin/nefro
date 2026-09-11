<?php

/**
 * add_ketogenna-dieta-metabolicke-zdravie-pecen-randomizovana-studia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok — spracovanie randomizovanej štúdie Cell Metabolism 2026
 * (doi 10.1016/j.cmet.2026.07.020, PMID 42660124, PMC13551625, NCT02706262)
 * po overení plného textu vrátane STAR Methods.
 * ════════════════════════════════════════════════════════════════════════════
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Ketogénna diéta a metabolické zdravie: sľubné výsledky pre pečeň, nie dôkaz univerzálnej prevahy',
    'slug'         => 'ketogenna-dieta-metabolicke-zdravie-pecen-randomizovana-studia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pri rovnakom 10 % úbytku hmotnosti zlepšila ketogénna strava pečeňovú citlivosť na inzulín dvoj- až trojnásobne viac. Druhý spoločný hlavný cieľ — svalová citlivosť — sa však medzi diétami vôbec nelíšil.',
    'content'      => <<<'HTML'
<p>Zníženie telesnej hmotnosti spravidla zlepšuje viaceré metabolické ukazovatele. Menej jednoznačná je otázka, do akej miery výsledok závisí od samotného energetického deficitu a do akej miery od pomeru sacharidov, tukov a bielkovín.</p>

<p>Randomizovaná klinická štúdia publikovaná v časopise <em>Cell Metabolism</em> túto otázku riešila nezvyčajne dôsledne: účastníkom poskytovala <strong>všetko jedlo</strong> a porovnávala tri diéty pri <strong>rovnakom, približne desaťpercentnom úbytku hmotnosti</strong>. Ketogénna strava zlepšila pečeňový metabolizmus výraznejšie než stredomorská a veľmi nízkotučná.</p>

<p>Mediálne zjednodušenie na súťaž o „najzdravšiu diétu“ však nevystihuje, čo štúdia ukázala. Mala <strong>dva rovnocenné hlavné ciele</strong> — a pri jednom z nich sa diéty nelíšili vôbec.</p>

<h2>Čo výskumníci porovnávali</h2>

<p>Štúdia prebiehala na Washington University School of Medicine od februára 2016 do apríla 2025. Zaradení boli dospelí vo veku 18 až 55 rokov s <strong>metabolicky nezdravou obezitou</strong>, definovanou súčasnou prítomnosťou troch podmienok:</p>

<ul>
  <li>index telesnej hmotnosti 30,0 až 50,0 kg/m²,</li>
  <li>prediabetes (glykémia nalačno ≥ 100 mg/dl, HbA<sub>1c</sub> ≥ 5,7 % alebo glykémia 2 hodiny po 75 g glukózy ≥ 140 mg/dl),</li>
  <li>steatóza pečene (obsah triacylglycerolov v pečeni ≥ 5 % podľa magnetickej rezonancie).</li>
</ul>

<p>Randomizovaných bolo 55 účastníkov, analyzovaných <strong>42</strong>, ktorí štúdiu dokončili — v každej skupine zhodne 9 žien a 5 mužov. Priemerný vek bol 43,2 ± 7,5 roka a index telesnej hmotnosti 38,9 ± 4,9 kg/m².</p>

<div class="table-responsive" role="region" aria-label="Zloženie porovnávaných diét a dosiahnutý úbytok hmotnosti" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Diéta</th>
      <th scope="col">Sacharidy</th>
      <th scope="col">Tuky</th>
      <th scope="col">Bielkoviny</th>
      <th scope="col">Úbytok hmotnosti</th>
      <th scope="col">Čas do dosiahnutia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Veľmi nízkosacharidová ketogénna (n = 14)</th>
      <td>4 %</td><td>73 %</td><td>23 %</td>
      <td>10,4 ± 2,3 %</td><td>4,6 ± 1,8 mesiaca</td>
    </tr>
    <tr>
      <th scope="row">Stredomorská (n = 14)</th>
      <td>50 %</td><td>35 %</td><td>15 %</td>
      <td>10,2 ± 1,6 %</td><td>5,4 ± 2,1 mesiaca</td>
    </tr>
    <tr>
      <th scope="row">Veľmi nízkotučná, prevažne rastlinná (n = 14)</th>
      <td>70 %</td><td>15 %</td><td>15 %</td>
      <td>10,1 ± 2,2 %</td><td>5,1 ± 1,4 mesiaca</td>
    </tr>
  </tbody>
</table>
</div>

<p>Všetky jedlá aj občerstvenie pripravovala metabolická kuchyňa univerzity a dodávala ich zamrazené, týždenne. Účastníci sa raz týždenne stretávali s dietológom. Dodržiavanie režimu, merané podielom zaznamenaných skonzumovaných porcií, presiahlo vo všetkých skupinách <strong>95 %</strong>.</p>

<p>Nízkotučná strava nebola striktne vegánska — medzi jedlami boli aj zmiešané obilniny s lososom. Označenie „rastlinná strava“ preto treba chápať ako prevažne rastlinný model, nie ako úplné vylúčenie živočíšnych potravín.</p>

<p>Silnou stránkou takéhoto usporiadania je porovnanie metabolických zmien pri takmer rovnakom úbytku hmotnosti a pri overenej adherencii. Zároveň však poskytovanie všetkých jedál obmedzuje prenositeľnosť do každodennej praxe, v ktorej o úspechu výrazne rozhodujú dostupnosť potravín, cena, preferencie a dlhodobé dodržiavanie režimu.</p>

<h2>Kľúčový detail: jeden z dvoch hlavných cieľov bol negatívny</h2>

<p>Štúdia mala vopred určené <strong>dva rovnocenné hlavné ciele</strong>, obidva merané zlatým štandardom — hyperinzulinemickým euglykemickým klampom so stabilnými izotopmi. Chyba prvého druhu bola pre ne rozdelená Bonferroniho korekciou na α = 0,025 pre každý.</p>

<div class="table-responsive" role="region" aria-label="Výsledky dvoch hlavných cieľov štúdie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Hlavný cieľ</th>
      <th scope="col">Výsledok</th>
      <th scope="col">Rozdiel medzi diétami</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Citlivosť kostrového svalu na inzulín</th>
      <td>Vzrástla približne o 50 % vo <strong>všetkých</strong> skupinách</td>
      <td><strong>Žiadny</strong> (p = 0,617)</td>
    </tr>
    <tr>
      <th scope="row">Index pečeňovej citlivosti na inzulín</th>
      <td>Vzrástol vo všetkých skupinách</td>
      <td>Dvoj- až trojnásobne väčší vzostup pri ketogénnej strave (p &lt; 0,001)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Toto je najdôležitejšie zistenie celej práce a zároveň to, čo sa v titulkoch stráca. Pokiaľ ide o <strong>svalovú</strong> inzulínovú rezistenciu — hlavný patogenetický mechanizmus metabolických ochorení pri obezite — rozhodoval výlučne úbytok hmotnosti. Zloženie stravy neprinieslo nič navyše.</p>

<p>Citlivostná analýza lineárnym zmiešaným modelom zahŕňajúca všetkých 55 randomizovaných účastníkov dala pri oboch hlavných cieľoch rovnaký výsledok (p = 0,560, resp. p &lt; 0,001), takže vypadnutie 13 účastníkov výsledok neskreslilo.</p>

<p><strong>Všetky ostatné ukazovatele boli podľa autorov exploračné a hodnotili sa bez korekcie na viacnásobné porovnávanie.</strong> To sa týka aj tých nálezov, ktoré sa dostali do titulkov.</p>

<h2>Výraznejší pokles tuku v pečeni</h2>

<p>Obsah triacylglycerolov v pečeni, meraný magnetickou rezonanciou, klesol vo všetkých skupinách — pri ketogénnej strave o <strong>67 %</strong>, pri stredomorskej a nízkotučnej zhodne o <strong>45 %</strong> (p &lt; 0,05).</p>

<p>Relatívny pokles o 67 % neznamená pokles o 67 percentuálnych bodov ani úplné odstránenie steatózy. Znamená, že z východiskového obsahu tuku zostala približne tretina.</p>

<p>Zhodne sa zmenili aj mechanisticky súvisiace ukazovatele. Tvorba nových mastných kyselín v pečeni <em>de novo</em>, meraná pomocou deuterovanej vody, klesla pri ketogénnej a stredomorskej strave, ale nezmenila sa pri nízkotučnej; pokles bol najväčší v ketogénnej skupine (p &lt; 0,001). Zmena lipogenézy pritom korelovala so zmenou 24-hodinovej plochy pod krivkou inzulínu (r = 0,725; p &lt; 0,001) — čo je vnútorne konzistentný mechanistický reťazec, nie izolovaný nález.</p>

<p>Najdôležitejšie je však neprekročiť hranicu medzi metabolickým ukazovateľom a klinickým výsledkom. Zníženie tuku v pečeni samo osebe nedokazuje ústup zápalu, regresiu fibrózy ani zníženie rizika cirhózy. Štúdia s približne päťmesačnou intervenciou takisto nemôže preukázať dlhodobé zníženie úmrtnosti.</p>

<h2>Ako rozumieť „remisii prediabetu“</h2>

<p>Remisiu prediabetu dosiahlo 50 % účastníkov ketogénnej skupiny, 29 % stredomorskej a 7 % nízkotučnej (p &lt; 0,05, chí-kvadrát test).</p>

<p>Autori remisiu definovali prísne — museli byť splnené <strong>všetky tri</strong> podmienky súčasne: glykémia nalačno &lt; 100 mg/dl, glykémia 2 hodiny po 75 g glukózy &lt; 140 mg/dl a HbA<sub>1c</sub> &lt; 5,7 %.</p>

<p>Pri pohľade na jednotlivé zložky sa však ukazuje zaujímavý detail. Glykémia 2 hodiny po záťaži klesla vo všetkých skupinách <strong>bez rozdielu medzi diétami</strong>. Rozdiel v remisii teda pochádzal z glykémie nalačno a HbA<sub>1c</sub>, nie z glukózovej tolerancie. To je klinicky podstatné: ketogénna strava zlepšila predovšetkým ukazovatele odrážajúce pečeňovú produkciu glukózy a dlhodobú glykémiu, nie schopnosť spracovať sacharidovú nálož.</p>

<p>Pri 14 účastníkoch v skupine navyše rozdiel medzi 50 % a 29 % predstavuje tri osoby. Percentá preto nemožno prezentovať ako spoľahlivú predpoveď pravdepodobnosti úspechu pre konkrétneho pacienta.</p>

<p>Normalizácia glykemických ukazovateľov počas poskytovanej stravy napokon nie je synonymom trvalého odstránenia rizika diabetu. Rozhodujúce je, či zlepšenie pretrváva po ukončení dodávania jedál.</p>

<h3>Funkcia beta-buniek sa nezlepšila</h3>

<p>Samostatnú pozornosť si zaslúži nález, ktorý autori zdôrazňujú: sekrécia inzulínu po podaní glukózy sa po redukcii hmotnosti <strong>nezmenila v žiadnej skupine</strong>. Mesiace obmedzovania sacharidov teda beta-bunku „neoddýchli“ — na rozdiel od známeho priaznivého účinku pri už rozvinutom diabete 2. typu.</p>

<h2>Prečo môže obmedzenie sacharidov ovplyvňovať pečeňový tuk</h2>

<p>Pečeňový tuk nevzniká iba ukladaním tukov prijatých potravou. Jeho množstvo závisí od prísunu mastných kyselín, tvorby nových mastných kyselín, ich oxidácie a exportu lipidov z pečene.</p>

<p>24-hodinové odbery ponúkajú presvedčivé vysvetlenie. V ketogénnej skupine klesla plocha pod krivkou glukózy o 20 % (oproti 8 % v oboch ostatných skupinách) a plocha pod krivkou inzulínu až o 74 % (oproti 44 % a 27 %). Koncentrácia glukagónu naopak stúpla o 52 %, kým v ostatných skupinách klesla o 32 % a 41 %; pomer glukagónu k inzulínu sa zvýšil viac než trojnásobne. Beta-hydroxybutyrát stúpol viac než dvadsaťnásobne.</p>

<p>Lipogenéza v pečeni je stimulovaná glukózou a inzulínom a tlmená glukagónom; glukagón zároveň podporuje oxidáciu mastných kyselín a ketogenézu. Pozorovaný hormonálny posun teda vysvetľuje pozorovaný pokles pečeňového tuku.</p>

<p>Z výsledkov však nemožno vyvodiť jednoduché pravidlo, že vysoký príjem tukov „odstraňuje tuk z pečene“. Autori sami uvádzajú, že <strong>nevedia určiť, či by menej prísne obmedzenie sacharidov bez navodenia ketózy prinieslo rovnaký účinok</strong>, ani či je potrebné dodržiavať diétu počas chudnutia alebo by stačila pri udržiavaní hmotnosti.</p>

<h2>Lipidy: obava sa nepotvrdila, ale obraz je zmiešaný</h2>

<p>Ketogénna strava obsahovala <strong>23 % energie z nasýtených mastných kyselín</strong>. Napriek tomu sa celkový cholesterol, LDL cholesterol ani apolipoproteín B medzi skupinami nelíšili — vo všetkých mali tendenciu klesať.</p>

<div class="table-responsive" role="region" aria-label="Vplyv diét na lipidové ukazovatele" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Výsledok</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">LDL cholesterol, apolipoproteín B, celkový cholesterol</th><td>Bez rozdielu medzi diétami</td></tr>
    <tr><th scope="row">Krvný tlak</th><td>Tendencia k poklesu, bez rozdielu medzi diétami</td></tr>
    <tr><th scope="row">24-hodinové triacylglyceroly</th><td>Bez rozdielu (keto −23 %, stredomorská −23 %, nízkotučná −17 %)</td></tr>
    <tr><th scope="row">Triacylglyceroly nalačno, veľkosť častíc VLDL</th><td>Väčší pokles pri ketogénnej strave (p &lt; 0,005)</td></tr>
    <tr><th scope="row">Koncentrácia veľkých častíc VLDL</th><td>Klesla iba pri ketogénnej strave (p &lt; 0,01)</td></tr>
    <tr><th scope="row">HDL cholesterol</th><td>Klesol pri stredomorskej a nízkotučnej, tendencia k vzostupu pri ketogénnej (p = 0,005)</td></tr>
    <tr><th scope="row">PAI-1 a TNF-α</th><td>Klesli iba pri ketogénnej strave (p &lt; 0,05)</td></tr>
  </tbody>
</table>
</div>

<p>Dôležitá je jedna nenápadná veta v diskusii: triacylglyceroly nalačno klesli v ketogénnej skupine najviac, ale <strong>24-hodinové hodnoty sa nelíšili, pretože postprandiálne koncentrácie boli v ketogénnej skupine vyššie</strong>. Kto by hodnotil iba odber nalačno, získal by priaznivejší obraz, než aký zodpovedá celodennej expozícii.</p>

<p>Tieto výsledky nemožno zovšeobecniť na všetkých ľudí ani na dlhodobé stravovanie. Odpoveď lipidového profilu na ketogénnu stravu je individuálna a u niektorých ľudí môže koncentrácia LDL cholesterolu významne stúpnuť. Súbor 14 osôb na skupinu takúto menšinovú odpoveď spoľahlivo nezachytí.</p>

<p>Ani stredomorskú stravu nemožno označiť za menej vhodnú len preto, že v tejto štúdii dosiahla menšiu zmenu niektorých pečeňových ukazovateľov. Porovnanie metabolických výsledkov po piatich mesiacoch nie je celkovým porovnaním zdravotných prínosov oboch stravovacích modelov — pri stredomorskej strave existujú dôkazy o klinických výsledkoch z podstatne dlhších štúdií.</p>

<h2>Nález, ktorý si v nefrológii zaslúži pozornosť</h2>

<p>Medzi bezpečnostnými ukazovateľmi sa objavuje zistenie, ktoré samotná práca nerozvádza: <strong>odhadovaná glomerulová filtrácia v ketogénnej skupine stúpla</strong>, kým v ostatných skupinách sa nezmenila (p = 0,002). Vzostup odrážal <strong>pokles cystatínu C, nie kreatinínu</strong>; eGFR sa počítala rovnicou CKD-EPI 2021 z kreatinínu a cystatínu C.</p>

<p>Tento nález nemožno bez ďalšieho čítať ako zlepšenie funkcie obličiek, a to z troch dôvodov:</p>

<ol>
  <li><strong>Cystatín C má mimorenálne determinanty.</strong> Ovplyvňuje ho tuková hmota, zápal a funkcia štítnej žľazy. V ketogénnej skupine súčasne klesol PAI-1 a TNF-α a ubudla tuková hmota — pokles cystatínu C teda mohol sčasti odrážať zmenu týchto faktorov, nie skutočnej filtrácie.</li>
  <li><strong>Príjem bielkovín bol v ketogénnej skupine vyšší</strong> (23 % energie oproti 15 %), čo potvrdzuje aj zvýšené vylučovanie dusíka močom. Vyšší príjem bielkovín môže zvýšiť glomerulovú filtráciu hyperfiltráciou — a hyperfiltrácia nie je priaznivý jav.</li>
  <li><strong>Rozpor medzi kreatinínom a cystatínom C</strong> je sám osebe signálom, že ide skôr o zmenu markera než o zmenu filtrácie.</li>
</ol>

<p>Štúdia zároveň vylúčila osoby so závažným ochorením obličiek aj s diabetom vyžadujúcim liečbu. Neposkytuje preto <strong>žiadny</strong> podklad na hodnotenie účinnosti ani bezpečnosti ketogénnej diéty u pacientov s pokročilou chronickou chorobou obličiek alebo u dialyzovaných pacientov.</p>

<h2>Čo z výsledkov vyplýva pre nefrologickú prax</h2>

<p>Nasledujúce súvislosti sú klinickým kontextom, nie výsledkami tejto štúdie.</p>

<p>Ketogénna diéta nie je z definície vysokobielkovinová — jej základom je obmedzenie sacharidov. V praxi však môže pacient sacharidové potraviny nahrádzať veľkým množstvom mäsa, syrov či proteínových prípravkov. V tejto štúdii tvorili bielkoviny 23 % energie, teda výrazne viac než v porovnávacích diétach. U človeka s ochorením obličiek preto treba hodnotiť skutočný príjem bielkovín, nie iba názov diéty.</p>

<p>Osobitnú pozornosť si vyžadujú zmeny objemového stavu. Začiatočný pokles hmotnosti pri výraznom obmedzení sacharidov môže čiastočne súvisieť so stratou vody a sodíka. U pacienta užívajúceho diuretiká alebo antihypertenzíva môže byť potrebné prehodnotenie liečby. Naopak, všeobecné odporúčanie zvýšiť príjem tekutín alebo soli nemusí byť vhodné pri srdcovom zlyhávaní či dialýze.</p>

<p>Pri zníženej funkcii obličiek sú relevantné aj acidobázická rovnováha, elektrolyty, riziko nefrolitiázy a zachovanie primeraného nutričného stavu. Nutričnú ketózu treba odlišovať od ketoacidózy, ale toto rozlíšenie neznamená, že výrazne reštriktívny režim je bezpečný pre každého.</p>

<p>Zvláštnu opatrnosť vyžaduje kombinácia ketogénnej diéty s <strong>inhibítormi SGLT2</strong> pre riziko euglykemickej ketoacidózy. Pri inzulíne a derivátoch sulfonylurey zase môže výrazné zníženie sacharidov zvýšiť riziko hypoglykémie, ak sa liečba primerane neupraví. Pacient nemá lieky svojvoľne vysadzovať ani meniť ich dávkovanie.</p>

<h2>Čo štúdia dokazuje a čo nie</h2>

<div class="table-responsive" role="region" aria-label="Kontrola tvrdení o výsledkoch štúdie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Odborne primeraná interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Ketogénna diéta prekonala ostatné diéty</th>
      <td>Prekonala ich v pečeňových ukazovateľoch. Pri svalovej citlivosti na inzulín — druhom hlavnom cieli — sa diéty nelíšili (p = 0,617).</td>
    </tr>
    <tr>
      <th scope="row">Tuk v pečeni klesol o 67 %</th>
      <td>Ide o relatívny pokles, nie o percentuálne body ani o vymiznutie steatózy.</td>
    </tr>
    <tr>
      <th scope="row">Polovica účastníkov dosiahla remisiu prediabetu</th>
      <td>50 % oproti 29 % a 7 %; pri 14 osobách na skupinu ide o rozdiel troch osôb. Definícia vyžadovala normalizáciu glykémie nalačno, 2-hodinovej glykémie aj HbA<sub>1c</sub>.</td>
    </tr>
    <tr>
      <th scope="row">Všetky diéty boli rovnako úspešné pri chudnutí</th>
      <td>Úbytok približne 10 % bol <em>cieľom</em> kontrolovanej intervencie s dodávaným jedlom, nie prirodzeným výsledkom.</td>
    </tr>
    <tr>
      <th scope="row">Nízkotučná skupina jedla rastlinnú stravu</th>
      <td>Strava bola prevažne rastlinná, nie striktne vegánska.</td>
    </tr>
    <tr>
      <th scope="row">Cholesterol sa nezhoršil napriek nasýteným tukom</th>
      <td>Potvrdené pre LDL cholesterol a apolipoproteín B pri 23 % energie z nasýtených tukov. 24-hodinové triacylglyceroly sa však nelíšili pre vyššie postprandiálne hodnoty.</td>
    </tr>
    <tr>
      <th scope="row">Zlepšila sa funkcia obličiek</th>
      <td>eGFR stúpla, ale iba pre pokles cystatínu C, nie kreatinínu. Pri vyššom príjme bielkovín a poklese zápalu ide pravdepodobne o zmenu markera, nie o preukázaný renálny prínos.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Rozhodovanie nemá stáť na titulku</h2>

<p>Štúdia je metodicky nadpriemerná: poskytované jedlo, adherencia nad 95 %, zhodný úbytok hmotnosti, klamp, magnetická rezonancia, deuterovaná voda a 26 odberov počas 24 hodín. Jej mechanistické zistenia o pečeňovom metabolizme sú vierohodné a vnútorne konzistentné.</p>

<p>Zároveň však ide o 42 analyzovaných účastníkov vo veku do 55 rokov, prevažne belochov, bez diabetu a bez ochorenia obličiek, sledovaných približne päť mesiacov. Jeden z dvoch hlavných cieľov bol negatívny a ostatné nálezy boli exploračné.</p>

<p>Nejde teda o dôkaz, že ketogénna diéta je najzdravším spôsobom chudnutia, že lieči fibrózu pečene alebo že je vhodná pre pacientov s chronickou chorobou obličiek. Ide o dobre podložený mechanistický poznatok: pri metabolicky nezdravej obezite so steatózou pečene prináša výrazné obmedzenie sacharidov pri rovnakom úbytku hmotnosti <strong>pečeni</strong> niečo navyše — zatiaľ čo svalu nie.</p>

<p>Pri výbere stravy rozhoduje kombinácia účinnosti, bezpečnosti, nutričnej kvality a udržateľnosti. Zlepšenie laboratórneho ukazovateľa má hodnotu vtedy, keď je súčasťou celkového zdravotného prínosu, nie keď ho sprevádza iné, prehliadané riziko.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=bmi-hematokrit-diabetes-2-typu-riziko-zlyhania-obliciek">BMI a hematokrit pri diabete 2. typu: čo skutočne hovoria o riziku zlyhania obličiek</a></li>
  <li><a href="article.php?slug=alternativne-sladidla-masld-ckd-inkretinova-liecba">Sladidlá pri MASLD, CKD a inkretínovej liečbe: dôkazy a neistoty</a></li>
  <li><a href="article.php?slug=cielovy-systolicky-tlak-120-ckd-kdigo-realna-prax">Cieľový systolický tlak pod 120 mm Hg pri chronickej chorobe obličiek sa v praxi uplatňuje len obmedzene</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Petersen MC, Smith GI, Farabi SS, Palacios HH, Shankaran M, Hellerstein MK, Patterson BW, Klein S. Effect of diet macronutrient content on the cardiometabolic response to weight loss: A randomized clinical trial. <em>Cell Metabolism</em>. Publikované online 27. augusta 2026. doi: 10.1016/j.cmet.2026.07.020. Registrácia ClinicalTrials.gov NCT02706262. <a href="https://pubmed.ncbi.nlm.nih.gov/42660124/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13551625/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>

<p><small><em><strong>Sprievodné spravodajstvo:</strong> „Uniquely Beneficial Effect“: Study Suggests Keto Diet Is Healthiest for Weight Loss, Here's Why. ScienceAlert (autor neuvedený). <a href="https://www.sciencealert.com/uniquely-beneficial-effect-study-suggests-keto-diet-is-healthiest-for-weight-loss-heres-why" target="_blank" rel="noopener noreferrer">sciencealert.com</a>. — Ketogénna diéta prekvapila výskumníkov, keď prekonala stredomorskú aj nízkotučnú stravu. Nextech (autor neuvedený). <a href="https://www.nextech.sk/a/Ketogenna-dieta-prekvapila-vyskumnikov-ked-prekonala-stredomorsku-aj-nizkotucnu-stravu" target="_blank" rel="noopener noreferrer">nextech.sk</a>.</em></small></p>
HTML,
];

// ── Vloženie / aktualizácia ───────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ketogenna_dieta_metabolicke_zdravie',
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
