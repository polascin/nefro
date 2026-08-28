<?php
/**
 * Odborny clanok: dyslipidemia 2026 - riziko, ciele LDL, liecba pri CKD.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_dyslipidemia-2026-kardiovaskularne-riziko-ldl-ciele-ckd_article.php"
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
    'title'        => 'Dyslipidémia v roku 2026: hodnotenie kardiovaskulárneho rizika, ciele LDL cholesterolu a liečba pri chronickej chorobe obličiek',
    'slug'         => 'dyslipidemia-2026-kardiovaskularne-riziko-ldl-ciele-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Aktualizácia ESC/EAS z roku 2025 ponechala cieľové hodnoty LDL cholesterolu, ale spresnila hodnotenie rizika, skorú kombinovanú liečbu po akútnom koronárnom syndróme aj nové lieky. Čo z toho platí pri CKD a dialýze?',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Aterogénne lipoproteíny obsahujúce apolipoproteín B majú kauzálnu úlohu pri vzniku aterosklerotického kardiovaskulárneho ochorenia. Aktualizácia odporúčaní ESC a EAS z októbra 2025 nemení cieľové hodnoty LDL cholesterolu z roku 2019, ale spresňuje hodnotenie rizika, zavádza skorú kombinovanú liečbu po akútnom koronárnom syndróme a rozširuje liekové možnosti. Chronická choroba obličiek pritom zostáva osobitnou situáciou, v ktorej sa rozhodnutie nemôže opierať iba o koncentráciu LDL cholesterolu.</em></p>

<h2>Ateroskleróza je dôsledkom kumulatívnej expozície aterogénnym časticiam</h2>

<p>LDL cholesterol nie je iba štatistickým markerom rizika. LDL a ďalšie lipoproteíny obsahujúce apolipoproteín B prenikajú do arteriálnej steny, kde sa zadržiavajú a spúšťajú zápalovú odpoveď vedúcu k rastu aterosklerotického plátu.</p>

<p>Riziko závisí od kumulatívnej expozície, ktorú možno zjednodušene chápať ako súčin koncentrácie aterogénnych častíc a času. Mierne zvýšený LDL cholesterol pretrvávajúci desiatky rokov môže byť preto klinicky významnejší než krátkodobé zvýšenie vo vyššom veku.</p>

<p>Genetické, epidemiologické a randomizované farmakologické štúdie konzistentne ukazujú, že zníženie LDL cholesterolu znižuje výskyt:</p>

<ul>
  <li>infarktu myokardu,</li>
  <li>ischemickej cievnej mozgovej príhody,</li>
  <li>koronárnej revaskularizácie,</li>
  <li>ďalších aterosklerotických príhod.</li>
</ul>

<p>Pri poklese LDL cholesterolu približne o 1 mmol/l možno počas niekoľkých rokov očakávať približne pätinové relatívne zníženie veľkých vaskulárnych príhod. Absolútny prínos však závisí od východiskového rizika. Rovnaké relatívne zníženie poskytne väčší absolútny úžitok pacientovi po infarkte alebo s pokročilou chronickou chorobou obličiek než mladému človeku s nízkym krátkodobým rizikom.</p>

<h2>Lipidový profil: čo treba skutočne vyšetrovať</h2>

<p>Základné vyšetrenie zahŕňa:</p>

<ul>
  <li>celkový cholesterol,</li>
  <li>LDL cholesterol,</li>
  <li>HDL cholesterol,</li>
  <li>triacylglyceroly,</li>
  <li>non-HDL cholesterol.</li>
</ul>

<p>Non-HDL cholesterol sa vypočíta odpočítaním HDL cholesterolu od celkového cholesterolu. Zahŕňa cholesterol vo všetkých aterogénnych časticiach obsahujúcich apolipoproteín B a je užitočný najmä pri hypertriglyceridémii, diabete, obezite a chronickej chorobe obličiek.</p>

<h3>Apolipoproteín B</h3>

<p>Každá aterogénna častica obsahuje spravidla jednu molekulu apolipoproteínu B. Jeho koncentrácia preto približuje počet aterogénnych častíc, zatiaľ čo LDL cholesterol vyjadruje množstvo cholesterolu, ktoré tieto častice nesú.</p>

<p>Apolipoproteín B môže byť užitočný najmä pri nesúlade medzi LDL cholesterolom a počtom častíc, napríklad pri:</p>

<ul>
  <li>hypertriglyceridémii,</li>
  <li>metabolickom syndróme,</li>
  <li>diabete,</li>
  <li>obezite,</li>
  <li>veľmi nízkom LDL cholesterole počas kombinovanej liečby.</li>
</ul>

<p>Nie je však nevyhnutné stanovovať ho u každého pacienta, ak je klinické rozhodnutie jasné zo štandardného lipidového profilu a celkového rizika.</p>

<h3>Lipoproteín(a)</h3>

<p>Lipoproteín(a), Lp(a), je prevažne geneticky určený aterogénny a pravdepodobne aj protrombotický lipoproteín. Odporúča sa stanoviť ho aspoň raz za život u každého dospelého, s osobitným dôrazom na situácie ako:</p>

<ul>
  <li>predčasné aterosklerotické ochorenie,</li>
  <li>familiárna hypercholesterolémia,</li>
  <li>rodinná anamnéza predčasných príhod,</li>
  <li>opakované príhody napriek liečbe,</li>
  <li>hraničné rozhodovanie o intenzite prevencie,</li>
  <li>stenóza aortálnej chlopne.</li>
</ul>

<p>Za rizikovú hranicu sa považuje koncentrácia nad 50 mg/dl, približne nad 105 až 125 nmol/l podľa použitej metódy. Jednotky mg/dl a nmol/l nemožno spoľahlivo prevádzať jediným univerzálnym koeficientom, pretože veľkosť izoforiem apolipoproteínu(a) sa medzi ľuďmi líši.</p>

<p>Vysoký Lp(a) je modifikátor rizika, ktorý môže pacienta posunúť do vyššej rizikovej kategórie. Nie je však samostatnou indikáciou na experimentálnu liečbu. <strong>Zatiaľ nebolo preukázané, že zníženie Lp(a) znižuje riziko aterosklerotických príhod.</strong> Prvá výsledková štúdia s cielenou liečbou, Lp(a)HORIZON s pelakarsenom, mala pôvodne priniesť výsledky v prvej polovici roka 2026; k polovici augusta 2026 nebola zverejnená a očakáva sa v druhej polovici roka. Štúdia OCEAN(a) s olpasiranom má skončiť neskôr. Do ich vyhodnotenia zostáva základom intenzívna kontrola LDL cholesterolu a všetkých ostatných rizikových faktorov.</p>

<h2>Treba lipidový profil vyšetrovať nalačno?</h2>

<p>Vo väčšine prípadov postačuje odber bez lačnenia. Po jedle sa významnejšie menia predovšetkým triacylglyceroly, zatiaľ čo celkový, HDL a non-HDL cholesterol zostávajú klinicky použiteľné.</p>

<p>Odber nalačno je vhodný najmä pri:</p>

<ul>
  <li>výrazne zvýšených triacylglyceroloch,</li>
  <li>podozrení na familiárnu alebo sekundárnu hypertriglyceridémiu,</li>
  <li>predchádzajúcom neinterpretovateľnom výsledku,</li>
  <li>hodnotení rizika akútnej pankreatitídy,</li>
  <li>potrebe presnejšieho výpočtu LDL cholesterolu.</li>
</ul>

<p>Pri vysokých triacylglyceroloch môže byť vypočítaný LDL cholesterol nepresný. V takom prípade treba uprednostniť priamu metódu, non-HDL cholesterol alebo apolipoproteín B.</p>

<h2>Hodnotenie celkového kardiovaskulárneho rizika</h2>

<p>Pri zdanlivo zdravých ľuďoch vo veku 40 až 69 rokov sa v európskych odporúčaniach používa SCORE2, vo veku 70 až 89 rokov SCORE2-OP. Tieto modely odhadujú desaťročné riziko fatálnej aj nefatálnej kardiovaskulárnej príhody.</p>

<p>Rozhodovacie hranice nie sú jednotné pre všetkých. Sú <strong>vekovo špecifické</strong>, pretože rovnaké desaťročné riziko znamená u mladšieho človeka podstatne vyššie celoživotné riziko:</p>

<div class="table-responsive" role="region" aria-label="Vekovo špecifické hranice desaťročného rizika podľa SCORE2 a SCORE2-OP" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Vek</th>
      <th scope="col">Nízke až stredné riziko</th>
      <th scope="col">Vysoké riziko</th>
      <th scope="col">Veľmi vysoké riziko</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>menej ako 50 rokov</td><td>pod 2,5 %</td><td>2,5 až menej ako 7,5 %</td><td>7,5 % a viac</td></tr>
    <tr><td>50 až 69 rokov</td><td>pod 5 %</td><td>5 až menej ako 10 %</td><td>10 % a viac</td></tr>
    <tr><td>70 rokov a viac</td><td>pod 7,5 %</td><td>7,5 až menej ako 15 %</td><td>15 % a viac</td></tr>
  </tbody>
</table>
</div>

<p>SCORE2 sa nemá používať ako bežný kalkulátor u pacientov:</p>

<ul>
  <li>s už dokázaným aterosklerotickým kardiovaskulárnym ochorením,</li>
  <li>s familiárnou hypercholesterolémiou,</li>
  <li>s vybranými formami diabetu,</li>
  <li>s chronickou chorobou obličiek,</li>
  <li>už liečených hypolipidemikami s cieľom „prepočítať“ zostávajúce riziko.</li>
</ul>

<p>V týchto skupinách je riziko definované samotným ochorením alebo sa hodnotí osobitným postupom.</p>

<h3>Modifikátory rizika</h3>

<p>Pri výsledku blízko rozhodovacej hranice možno zohľadniť:</p>

<ul>
  <li>rodinnú anamnézu predčasného kardiovaskulárneho ochorenia,</li>
  <li>vysoký Lp(a) nad 50 mg/dl,</li>
  <li>pretrvávajúco zvýšený vysoko senzitívny CRP nad 2 mg/l,</li>
  <li>obezitu a fyzickú neaktivitu,</li>
  <li>chronické zápalové ochorenie,</li>
  <li>infekciu HIV,</li>
  <li>obštrukčné spánkové apnoe,</li>
  <li>predčasnú menopauzu,</li>
  <li>preeklampsiu a ďalšie hypertenzné poruchy gravidity,</li>
  <li>etnicitu spojenú s vyšším rizikom,</li>
  <li>sociálnu depriváciu a psychosociálnu záťaž,</li>
  <li>subklinickú aterosklerózu zachytenú zobrazovaním.</li>
</ul>

<h2>Koronárne kalciové skóre a zobrazovanie</h2>

<p>Koronárne kalciové skóre môže zlepšiť reklasifikáciu rizika u vybraných asymptomatických ľudí so stredným alebo hraničným rizikom, ak výsledok pravdepodobne zmení rozhodnutie o liečbe.</p>

<p>Nemá sa používať ako plošný skríning celej populácie. Nehodí sa ani na pravidelné sledovanie účinnosti statínu. Statíny môžu stabilizovať plát, znížiť jeho lipidovú zložku a súčasne zvýšiť jeho kalcifikáciu. Nárast kalciového skóre počas statínovej liečby preto automaticky neznamená zlyhanie liečby.</p>

<p>Nulové kalciové skóre môže u vybraných ľudí znamenať nízke krátkodobé riziko. Nevylučuje však:</p>

<ul>
  <li>nekalcifikovaný plát,</li>
  <li>budúce celoživotné riziko,</li>
  <li>potrebu liečby pri familiárnej hypercholesterolémii,</li>
  <li>riziko pri diabete, fajčení alebo veľmi vysokom LDL cholesterole.</li>
</ul>

<h2>Cieľové hodnoty LDL cholesterolu</h2>

<p>Aktualizácia ESC a EAS z roku 2025 výslovne potvrdila ciele aj rizikové kategórie z roku 2019 a nezaviedla novú kategóriu:</p>

<div class="table-responsive" role="region" aria-label="Cieľové hodnoty LDL cholesterolu podľa kategórie kardiovaskulárneho rizika" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kardiovaskulárne riziko</th>
      <th scope="col">Cieľ LDL cholesterolu</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Veľmi vysoké</td><td>menej ako 1,4 mmol/l a pokles najmenej o 50 %</td></tr>
    <tr><td>Vysoké</td><td>menej ako 1,8 mmol/l a pokles najmenej o 50 %</td></tr>
    <tr><td>Stredné</td><td>menej ako 2,6 mmol/l</td></tr>
    <tr><td>Nízke</td><td>menej ako 3,0 mmol/l</td></tr>
  </tbody>
</table>
</div>

<p>Pri druhej vaskulárnej príhode do dvoch rokov napriek maximálne tolerovanej liečbe možno u vybraného pacienta zvážiť cieľ pod 1,0 mmol/l.</p>

<p>Percentuálny pokles a dosiahnutá absolútna hodnota vyjadrujú dve odlišné informácie. Pacient s východiskovým LDL cholesterolom 5,0 mmol/l, ktorý dosiahne 2,0 mmol/l, síce dosiahol 60 % pokles, ale pri veľmi vysokom riziku zostáva nad cieľovou hodnotou.</p>

<h2>„Čím nižšie, tým lepšie“ má klinický kontext</h2>

<p>Pri pacientovi s vysokým alebo veľmi vysokým rizikom randomizované štúdie nepodporujú existenciu jasnej škodlivej dolnej hranice LDL cholesterolu v rozsahu dosiahnutom súčasnou liečbou. Veľmi nízka koncentrácia počas účinnej terapie preto sama osebe nie je dôvodom na zníženie dávky.</p>

<p>Tento princíp však neznamená:</p>

<ul>
  <li>podávať lieky bez indikácie ľuďom s veľmi nízkym rizikom,</li>
  <li>ignorovať nežiaduce účinky a pacientove preferencie,</li>
  <li>používať laboratórny cieľ bez hodnotenia absolútneho prínosu,</li>
  <li>liečiť sekundárne zníženie cholesterolu pri malnutrícii alebo závažnom systémovom ochorení.</li>
</ul>

<h2>Životný štýl zostáva súčasťou liečby</h2>

<p>Základom je strava s prevahou:</p>

<ul>
  <li>zeleniny a ovocia,</li>
  <li>celozrnných obilnín,</li>
  <li>strukovín,</li>
  <li>orechov,</li>
  <li>rýb,</li>
  <li>rastlinných olejov s nenasýtenými mastnými kyselinami.</li>
</ul>

<p>Obmedziť treba najmä:</p>

<ul>
  <li>transmastné kyseliny,</li>
  <li>nadbytok nasýtených tukov,</li>
  <li>údeniny a nadmernú konzumáciu spracovaného mäsa,</li>
  <li>rafinované sacharidy,</li>
  <li>nadbytok energie,</li>
  <li>ultraspracované potraviny,</li>
  <li>nadmernú konzumáciu alkoholu.</li>
</ul>

<p>Pravidelná fyzická aktivita, redukcia hmotnosti pri obezite a ukončenie fajčenia znižujú celkové kardiovaskulárne riziko, hoci ich vplyv na samotný LDL cholesterol býva menší než účinok liekov.</p>

<p>Výživové doplnky sa nemajú prezentovať ako náhrada statínu. Aktualizácia z roku 2025 je v tomto bode výslovnejšia než predchádzajúca verzia: pre používanie výživových doplnkov alebo vitamínov na zníženie LDL cholesterolu a aterosklerotického rizika nie je indikácia.</p>

<h2>Statíny: základ farmakologickej liečby</h2>

<p>Statíny inhibujú HMG-CoA reduktázu, zvyšujú expresiu hepatálnych LDL receptorov a znižujú koncentráciu LDL cholesterolu. Majú najrozsiahlejší dôkaz o prevencii aterosklerotických príhod.</p>

<p>Vysokointenzívna liečba, napríklad atorvastatínom alebo rosuvastatínom vo vhodnej dávke, má spravidla znížiť LDL cholesterol najmenej o 50 %. Skutočná odpoveď je individuálna, preto treba lipidový profil skontrolovať približne 4 až 6 týždňov po začatí alebo intenzifikácii liečby.</p>

<h3>Svalové ťažkosti</h3>

<p>Svalové príznaky počas liečby statínom sú klinicky dôležité, ale nie každý svalový problém je spôsobený statínom. Treba zhodnotiť:</p>

<ul>
  <li>časovú súvislosť príznakov s liečbou,</li>
  <li>ústup po vysadení a návrat po opätovnom nasadení lieku,</li>
  <li>liekové interakcie,</li>
  <li>hypotyreózu,</li>
  <li>intenzívnu fyzickú záťaž,</li>
  <li>deficit vitamínu D pri klinickom podozrení,</li>
  <li>polymyalgiu, myozitídu a neurologické ochorenie.</li>
</ul>

<p>Rutinné meranie kreatínkinázy u asymptomatických pacientov nie je potrebné. Je indikované pri výraznej svalovej bolesti, slabosti, tmavom moči alebo podozrení na rabdomyolýzu.</p>

<h3>Pečeňové testy</h3>

<p>Mierne zvýšenie aminotransferáz bez klinických známok poškodenia pečene neznamená automatickú hepatotoxicitu. Statíny možno používať aj pri metabolickej dysfunkcii spojenej so steatotickým ochorením pečene.</p>

<p>Kontraindikáciou je najmä aktívne závažné hepatálne ochorenie alebo nevysvetlené výrazné zvýšenie aminotransferáz, nie jednoduchá steatóza.</p>

<h2>Ezetimib</h2>

<p>Ezetimib znižuje črevnú absorpciu cholesterolu inhibíciou transportéra NPC1L1. V monoterapii znižuje LDL cholesterol približne o 15 až 20 %, v kombinácii so statínom poskytuje ďalší pokles.</p>

<p>Je vhodný:</p>

<ul>
  <li>ak statín nestačí na dosiahnutie cieľa,</li>
  <li>pri potrebe skorého kombinovaného postupu,</li>
  <li>pri čiastočnej intolerancii statínu,</li>
  <li>ako súčasť liečby pri chronickej chorobe obličiek.</li>
</ul>

<p>V štúdii SHARP znížila kombinácia simvastatínu s ezetimibom výskyt veľkých aterosklerotických príhod u pacientov s chronickou chorobou obličiek, hoci individuálny prínos sa líšil podľa východiskového rizika a štádia ochorenia.</p>

<h2>Inhibítory PCSK9</h2>

<p>Monoklonálne protilátky alirokumab a evolokumab výrazne znižujú LDL cholesterol a u pacientov s vysokým rizikom redukujú aterosklerotické príhody.</p>

<p>Používajú sa najmä:</p>

<ul>
  <li>pri veľmi vysokom riziku a nedosiahnutí cieľa kombináciou statínu s ezetimibom,</li>
  <li>pri familiárnej hypercholesterolémii,</li>
  <li>pri skutočnej intolerancii viacerých statínových režimov, ak zostáva významná terapeutická potreba.</li>
</ul>

<p>Dostupnosť a úhrada sa riadia národnými pravidlami a nemusia presne kopírovať odborné odporúčania.</p>

<h2>Inklisiran</h2>

<p>Inklisiran je malá interferujúca RNA, ktorá v hepatocytoch znižuje syntézu PCSK9. Po úvodných dávkach sa podáva v dlhších intervaloch a znižuje LDL cholesterol približne o polovicu.</p>

<p>Jeho schopnosť znížiť LDL cholesterol je preukázaná. Konečné výsledky veľkých štúdií s primárnymi kardiovaskulárnymi ukazovateľmi, ORION-4 a VICTORION-2P, však zatiaľ nie sú k dispozícii. Zníženie laboratórnej hodnoty preto nemožno automaticky prezentovať ako rovnako priamo dokázané zníženie príhod, aké majú statíny, ezetimib a monoklonálne protilátky proti PCSK9.</p>

<h2>Kyselina bempedoová</h2>

<p>Kyselina bempedoová inhibuje ATP-citrátlyázu, enzým uložený v metabolickej dráhe pred HMG-CoA reduktázou. Aktivuje sa prevažne v pečeni, nie v kostrovom svalstve, čo môže byť výhodné u pacientov so svalovými ťažkosťami pri statínoch.</p>

<p>Približný pokles LDL cholesterolu je:</p>

<ul>
  <li>okolo 20 % v monoterapii,</li>
  <li>približne 15 až 20 % pri pridaní k statínu,</li>
  <li>okolo 35 až 40 % vo fixnej kombinácii s ezetimibom.</li>
</ul>

<p>Štúdia CLEAR Outcomes u pacientov s intoleranciou statínov preukázala 13 % relatívne zníženie primárneho kombinovaného kardiovaskulárneho ukazovateľa. Nepreukázala však významné zníženie kardiovaskulárnej ani celkovej mortality.</p>

<p>Medzi klinicky dôležité riziká patria:</p>

<ul>
  <li>hyperurikémia a dna,</li>
  <li>zvýšenie aminotransferáz,</li>
  <li>cholelitiáza,</li>
  <li>možné poškodenie šliach,</li>
  <li>mierne zmeny kreatinínu alebo laboratórne hlásené „renálne poškodenie“.</li>
</ul>

<p>Zvýšenie kreatinínu môže čiastočne súvisieť s inhibíciou jeho tubulárnej sekrécie a nemusí vždy znamenať pokles skutočnej glomerulárnej filtrácie. Pri chronickej chorobe obličiek, dne alebo nevysvetlenom náraste kreatinínu však treba výsledok klinicky vyhodnotiť, nie automaticky bagatelizovať.</p>

<h2>Evinakumab pri homozygotnej familiárnej hypercholesterolémii</h2>

<p>Novým prvkom aktualizácie z roku 2025 je evinakumab, monoklonálna protilátka proti angiopoetínu podobnému proteínu 3. Znižuje LDL cholesterol mechanizmom nezávislým od LDL receptora, takže účinkuje aj u pacientov s minimálnou reziduálnou funkciou receptora.</p>

<p>Zvažuje sa u pacientov s homozygotnou familiárnou hypercholesterolémiou od piatich rokov veku, ktorí nedosahujú cieľ napriek maximálnej hypolipidemickej liečbe. Ide o zriedkavú diagnózu patriacu do špecializovaného centra.</p>

<h2>Liečba po akútnom koronárnom syndróme</h2>

<p>Po akútnom koronárnom syndróme je pacient vo veľmi vysokom riziku. Liečba sa má začať alebo intenzifikovať už počas hospitalizácie.</p>

<p>Aktualizácia z roku 2025 posúva prax od postupného stupňovania k <strong>skorej kombinovanej liečbe</strong>. Ak je nepravdepodobné, že samotný vysokointenzívny statín dosiahne cieľ, má sa už počas indexovej hospitalizácie zvážiť kombinácia statínu s ezetimibom. Pri extrémne vysokom LDL cholesterole, familiárnej hypercholesterolémii alebo nedosiahnutí cieľa napriek kombinácii možno zvážiť inhibítor PCSK9.</p>

<p>Tento postup zabraňuje terapeutickej zotrvačnosti, pri ktorej sa jednotlivé lieky pridávajú v niekoľkomesačných intervaloch napriek predvídateľne nedostatočnému účinku.</p>

<h2>Hypertriglyceridémia</h2>

<p>Zvýšené triacylglyceroly môžu odrážať:</p>

<ul>
  <li>obezitu a inzulínovú rezistenciu,</li>
  <li>zle kontrolovaný diabetes,</li>
  <li>alkohol,</li>
  <li>hypotyreózu,</li>
  <li>nefrotický syndróm,</li>
  <li>chronickú chorobu obličiek,</li>
  <li>graviditu,</li>
  <li>genetické ochorenie,</li>
  <li>účinok liekov.</li>
</ul>

<p>Pri miernej až strednej hypertriglyceridémii zostáva prvým farmakologickým cieľom LDL cholesterol a celkové aterosklerotické riziko.</p>

<p>Pri veľmi vysokých triacylglyceroloch rastie riziko akútnej pankreatitídy. Potrebná je rýchla liečba sekundárnej príčiny, výrazné obmedzenie alkoholu a podľa závažnosti nízkotučná diéta a farmakoterapia.</p>

<h3>Ikozapentetyl</h3>

<p>U pacientov s vysokým alebo veľmi vysokým rizikom, ktorí užívajú statín a majú pretrvávajúce triacylglyceroly približne v rozmedzí 1,5 až 5,6 mmol/l, teda 135 až 499 mg/dl, sa má zvážiť ikozapentetyl v dávke 2 g dvakrát denne.</p>

<p>Výsledky prípravku s čistou etylovou formou kyseliny eikozapentaénovej nemožno preniesť na bežné rybie oleje alebo zmesi EPA a DHA. Treba zohľadniť zvýšený výskyt fibrilácie predsiení a krvácania pozorovaný v štúdii REDUCE-IT.</p>

<h3>Fibráty</h3>

<p>Fibráty znižujú triacylglyceroly, ale ich prínos k statínu pri prevencii aterosklerotických príhod nie je univerzálne dokázaný. Môžu mať miesto pri ťažkej hypertriglyceridémii alebo vo vybranom dyslipidemickom fenotype.</p>

<p>Gemfibrozil sa nemá kombinovať so statínom pre vysoké riziko myopatie a rabdomyolýzy. Fenofibrát vyžaduje úpravu podľa funkcie obličiek a pri pokročilej chronickej chorobe obličiek môže byť kontraindikovaný.</p>

<h3>Familiárny chylomikronemický syndróm</h3>

<p>Pri familiárnom chylomikronemickom syndróme s extrémnou hypertriglyceridémiou nad približne 8,5 mmol/l, teda nad 750 mg/dl, možno na zníženie rizika pankreatitídy zvážiť volanesorsen, antisense oligonukleotid namierený proti apolipoproteínu C-III. Ide o liečbu v špecializovanom centre s dôsledným sledovaním počtu trombocytov.</p>

<h2>Osobitné situácie zavedené aktualizáciou 2025</h2>

<p>Aktualizácia rozšírila indikácie statínu v dvoch klinicky dôležitých skupinách:</p>

<ul>
  <li><strong>Infekcia HIV.</strong> U ľudí vo veku najmenej 40 rokov sa v primárnej prevencii odporúča statín bez ohľadu na východiskový LDL cholesterol, s dôsledným zohľadnením interakcií s antiretrovírusovou liečbou.</li>
  <li><strong>Onkologickí pacienti.</strong> Statín sa odporúča v primárnej prevencii u pacientov s vysokým alebo veľmi vysokým rizikom kardiotoxicity spojenej s antracyklínmi.</li>
</ul>

<h2>Chronická choroba obličiek mení riziko aj interpretáciu lipidov</h2>

<p>Pacienti s chronickou chorobou obličiek majú vysoké riziko aterosklerotických príhod, srdcového zlyhávania a mortality. S poklesom eGFR však narastá podiel neaterosklerotických mechanizmov, napríklad:</p>

<ul>
  <li>kalcifikácie strednej vrstvy tepien,</li>
  <li>hypertrofie ľavej komory,</li>
  <li>arytmií,</li>
  <li>náhlej srdcovej smrti,</li>
  <li>zápalu a oxidačného stresu,</li>
  <li>porúch minerálového metabolizmu.</li>
</ul>

<p>Preto je relatívny prínos ďalšieho znižovania LDL cholesterolu pri pokročilom zlyhaní obličiek menej predvídateľný než v bežnej aterosklerotickej populácii.</p>

<h3>Typické lipidové zmeny pri CKD</h3>

<p>Pri nedialyzovanej chronickej chorobe obličiek sa často vyskytujú:</p>

<ul>
  <li>zvýšené triacylglyceroly,</li>
  <li>znížený HDL cholesterol,</li>
  <li>hromadenie remnantných lipoproteínov,</li>
  <li>zvýšený počet malých denzných LDL častíc,</li>
  <li>zvýšený Lp(a), najmä pri niektorých fenotypoch ochorenia.</li>
</ul>

<p>LDL cholesterol pritom nemusí byť výrazne zvýšený. Relatívne „normálna“ hodnota preto nevylučuje vysoké kardiovaskulárne riziko ani indikáciu na liečbu.</p>

<h2>Statíny pri nedialyzovanej CKD</h2>

<p>KDIGO odporúča statín alebo kombináciu statínu s ezetimibom väčšine dospelých vo veku najmenej 50 rokov s eGFR pod 60 ml/min/1,73 m², ktorí nie sú liečení chronickou dialýzou ani nemajú transplantovanú obličku.</p>

<p>Pri eGFR najmenej 60 ml/min/1,73 m² je statín takisto indikovaný podľa veku a kardiovaskulárneho rizika. U mladších pacientov s chronickou chorobou obličiek sa rozhoduje podľa prítomnosti diabetu, ischemickej choroby srdca, predchádzajúcej ischemickej cievnej mozgovej príhody alebo dostatočne vysokého odhadovaného rizika.</p>

<p>KDIGO tradične používa skôr stratégiu „fire and forget“, teda nasadiť a ďalej netitrovať podľa laboratórneho cieľa. Európske kardiologické odporúčania naopak pracujú s rizikovými kategóriami a cieľovými hodnotami LDL cholesterolu. Tieto prístupy nie sú totožné:</p>

<ul>
  <li>KDIGO zdôrazňuje dôkaz o prínose konkrétnych bezpečných režimov pri CKD,</li>
  <li>ESC a EAS zdôrazňujú dosiahnutie intenzity poklesu primeranej riziku.</li>
</ul>

<p>Treba pripomenúť, že odporúčanie KDIGO pre lipidy pochádza z roku 2013 a nebolo odvtedy aktualizované, zatiaľ čo európske odporúčania sa medzitým dvakrát revidovali. V praxi je preto rozumné oba prístupy kombinovať s prihliadnutím na štádium CKD, vek, aterosklerotické ochorenie, liekové interakcie a toleranciu.</p>

<h2>Dialýza</h2>

<p>Veľké štúdie 4D a AURORA nepreukázali presvedčivý prínos začatia statínu u prevažne dialyzovaných pacientov napriek významnému poklesu LDL cholesterolu. V štúdii SHARP bol celkový výsledok priaznivý, ale dôkaz v dialyzačnej podskupine bol menej jednoznačný.</p>

<p>Preto platí:</p>

<ul>
  <li>u pacienta už liečeného statínom pri začatí dialýzy možno v liečbe spravidla pokračovať,</li>
  <li>rutinné nové začatie statínu až u dlhodobo dialyzovaného pacienta sa všeobecne neodporúča,</li>
  <li>individuálna výnimka môže prichádzať do úvahy pri nedávnom akútnom koronárnom syndróme, závažnej ateroskleróze alebo osobitne vysokej pravdepodobnosti aterosklerotického prínosu.</li>
</ul>

<p>Nejde o tvrdenie, že LDL cholesterol pri dialýze prestáva byť aterogénny. Problémom je vysoký podiel konkurenčných príčin smrti a nedostatok presvedčivého výsledkového prínosu pri neskorom začatí liečby.</p>

<h2>Transplantácia obličky</h2>

<p>Príjemcovia transplantovanej obličky majú vysoké kardiovaskulárne riziko a statín sa u dospelých spravidla odporúča. Treba však dôsledne kontrolovať interakcie s imunosupresívami.</p>

<p>Cyklosporín zvyšuje expozíciu viacerým statínom a riziko myopatie. Interakcie ovplyvňujú aj takrolimus, azolové antimykotiká, makrolidy, niektoré blokátory kalciových kanálov a antivirotiká. Výber molekuly a maximálna dávka sa preto musia riadiť registračnými údajmi a transplantačným protokolom.</p>

<h2>Nefrotický syndróm</h2>

<p>Nefrotický syndróm môže vyvolať výrazné zvýšenie LDL cholesterolu, triacylglycerolov a lipoproteínu(a). Závažnosť dyslipidémie často koreluje s proteinúriou a hypoalbuminémiou.</p>

<p>Základom je liečba primárneho glomerulárneho ochorenia a redukcia proteinúrie. Statín možno použiť podľa celkového rizika, očakávaného trvania nefrotického syndrómu a závažnosti dyslipidémie.</p>

<p>Nie je však spoľahlivo dokázané, že samotná hypolipidemická liečba bez kontroly základného ochorenia zásadne mení renálnu prognózu nefrotického syndrómu.</p>

<h2>Bezpečnosť hypolipidemík pri CKD</h2>

<p>Pri poklese funkcie obličiek treba venovať pozornosť:</p>

<ul>
  <li>dávke rosuvastatínu,</li>
  <li>kombinácii statínu s fibrátom,</li>
  <li>riziku rabdomyolýzy,</li>
  <li>liekovým interakciám,</li>
  <li>hypotyreóze,</li>
  <li>krehkosti a nízkej svalovej hmote,</li>
  <li>akútnemu ochoreniu a dehydratácii.</li>
</ul>

<p>Atorvastatín má minimálnu renálnu elimináciu a často sa používa bez úpravy dávky podľa eGFR. Pri rosuvastatíne môže byť pri závažnej renálnej insuficiencii potrebné dávku obmedziť.</p>

<p>Ezetimib spravidla nevyžaduje úpravu dávky pri CKD. Monoklonálne protilátky proti PCSK9 sa neeliminujú klasickou renálnou cestou, ale údaje pri terminálnom zlyhaní obličiek sú obmedzenejšie než v bežnej populácii.</p>

<h2>Statíny nezhoršujú CKD bežným nefrotoxickým mechanizmom</h2>

<p>Statíny sa nepovažujú za typické nefrotoxické lieky. Zriedkavá rabdomyolýza však môže viesť k závažnému akútnemu poškodeniu obličiek. Riziko stúpa pri:</p>

<ul>
  <li>vysokej dávke,</li>
  <li>súbežnom gemfibrozile,</li>
  <li>inhibítoroch CYP3A4,</li>
  <li>cyklosporíne,</li>
  <li>hypotyreóze,</li>
  <li>vyššom veku,</li>
  <li>pokročilej chronickej chorobe obličiek,</li>
  <li>interkurentnom závažnom ochorení.</li>
</ul>

<p>Proteinúria pozorovaná pri vyšších dávkach rosuvastatínu môže byť tubulárneho pôvodu a nemusí znamenať glomerulárne poškodenie. Nová alebo progresívna proteinúria si však vždy vyžaduje štandardné klinické vyhodnotenie.</p>

<h2>Statínová intolerancia</h2>

<p>Úplná intolerancia všetkých statínov je menej častá než čiastočná intolerancia konkrétnej dávky alebo molekuly.</p>

<p>Pred označením pacienta za intolerantného je vhodné:</p>

<ol>
  <li>overiť časový vzťah príznakov k liečbe,</li>
  <li>skontrolovať interakcie a sekundárne príčiny,</li>
  <li>dočasne liek prerušiť pri významných ťažkostiach,</li>
  <li>skúsiť inú molekulu alebo nižšiu dávku,</li>
  <li>zvážiť prerušované dávkovanie statínu s dlhým polčasom,</li>
  <li>kombinovať tolerovanú dávku s ezetimibom alebo ďalším liekom.</li>
</ol>

<p>Aj malá tolerovaná dávka statínu môže byť užitočná. Nocebo efekt môže prispievať k svalovým príznakom, ale nemá sa používať na znevažovanie pacientových ťažkostí.</p>

<h2>Praktický terapeutický postup</h2>

<p>U pacienta s dyslipidémiou je vhodné:</p>

<ol>
  <li>určiť, či ide o primárnu alebo sekundárnu prevenciu,</li>
  <li>zhodnotiť celkové kardiovaskulárne riziko vekovo primeranou hranicou,</li>
  <li>vyšetriť sekundárne príčiny dyslipidémie,</li>
  <li>zaznamenať východiskový LDL cholesterol a triacylglyceroly,</li>
  <li>podľa rizika určiť potrebný percentuálny pokles a cieľovú hodnotu,</li>
  <li>zvoliť statín s dostatočnou intenzitou,</li>
  <li>pri predvídateľne nedostatočnom účinku nasadiť kombináciu hneď, nie po mesiacoch,</li>
  <li>skontrolovať lipidový profil približne po 4 až 6 týždňoch,</li>
  <li>overiť adherenciu a toleranciu,</li>
  <li>pri chronickej chorobe obličiek prispôsobiť výber lieku eGFR a interakciám.</li>
</ol>

<p>Pri nedosiahnutí cieľa napriek deklarovanej liečbe treba najprv overiť, či pacient liek skutočne užíva, či nedošlo k chybe dávkovania a či nie je prítomná sekundárna príčina. Automatické pridávanie drahej liečby bez kontroly adherencie je metodicky aj ekonomicky nesprávne.</p>

<h2>Časté omyly a ich uvedenie na správnu mieru</h2>

<div class="table-responsive" role="region" aria-label="Časté omyly pri liečbe dyslipidémie a ich odborné spresnenie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>LDL cholesterol je kauzálnym faktorom aterosklerózy</td><td>Podporené</td><td>Kauzalitu podporujú genetické, epidemiologické aj randomizované farmakologické dôkazy.</td></tr>
    <tr><td>Každý pacient má dosiahnuť rovnaký LDL cholesterol</td><td>Nesprávne</td><td>Cieľ aj intenzita liečby závisia od celkového rizika.</td></tr>
    <tr><td>Aktualizácia ESC/EAS 2025 zmenila cieľové hodnoty LDL cholesterolu</td><td>Nesprávne</td><td>Ciele aj rizikové kategórie z roku 2019 zostali výslovne potvrdené.</td></tr>
    <tr><td>Hranica desaťročného rizika je rovnaká pre každý vek</td><td>Nesprávne</td><td>SCORE2 používa vekovo špecifické hranice; mladší človek je rizikový pri nižšom percente.</td></tr>
    <tr><td>SCORE2 sa má používať aj po infarkte alebo počas hypolipidemickej liečby</td><td>Nesprávne</td><td>Model je určený pre zdanlivo zdravých, neliečených ľudí bez dokázaného ASCVD.</td></tr>
    <tr><td>Lp(a) stačí vyšetriť raz za život</td><td>V zásade správne</td><td>Opakovanie môže byť relevantné pri osobitných klinických okolnostiach alebo špecifickej liečbe.</td></tr>
    <tr><td>Zníženie Lp(a) liekom už dokázateľne znižuje počet príhod</td><td>Nepodporené</td><td>Prvá výsledková štúdia Lp(a)HORIZON do polovice augusta 2026 nezverejnila výsledky.</td></tr>
    <tr><td>Koronárne kalciové skóre je vhodný plošný skríning</td><td>Nesprávne</td><td>Je rizikovým modifikátorom vo vybraných hraničných situáciách.</td></tr>
    <tr><td>Nárast kalciového skóre počas statínu znamená progresiu nebezpečného plátu</td><td>Nepresné</td><td>Statín môže podporiť kalcifikáciu stabilizovaného plátu.</td></tr>
    <tr><td>Výživové doplnky môžu nahradiť statín</td><td>Nepodporené</td><td>Aktualizácia 2025 uvádza, že pre ne nie je indikácia.</td></tr>
    <tr><td>Kyselina bempedoová znižuje kardiovaskulárne príhody pri intolerancii statínov</td><td>Podporené</td><td>CLEAR Outcomes preukázala 13 % relatívne zníženie kombinovaného ukazovateľa, nie zníženie mortality.</td></tr>
    <tr><td>Kyselina bempedoová nemá žiadne svalové nežiaduce účinky</td><td>Príliš kategorické</td><td>Svalové príhody boli podobné placebu, ale nie absolútne neprítomné.</td></tr>
    <tr><td>Inklisiran má už rovnaký výsledkový dôkaz ako statíny</td><td>Nepodporené</td><td>Pokles LDL je preukázaný; štúdie ORION-4 a VICTORION-2P ešte nemajú výsledky.</td></tr>
    <tr><td>Bežný rybí olej je rovnocenný ikozapentetylu</td><td>Nesprávne</td><td>Výsledky čistej EPA nemožno extrapolovať na zmesi EPA a DHA ani na doplnky výživy.</td></tr>
    <tr><td>CKD je významným zosilňovačom kardiovaskulárneho rizika</td><td>Správne</td><td>Riziko rastie s poklesom eGFR a s albuminúriou.</td></tr>
    <tr><td>Normálny LDL cholesterol vylučuje potrebu statínu pri CKD</td><td>Nesprávne</td><td>Indikácia sa opiera najmä o celkové riziko a štádium CKD.</td></tr>
    <tr><td>Statín treba začať každému dialyzovanému pacientovi</td><td>Nepodporené</td><td>Rutinné nové začatie pri udržiavacej dialýze sa všeobecne neodporúča.</td></tr>
    <tr><td>Statín sa musí vysadiť pri začatí dialýzy</td><td>Nesprávne</td><td>V už zavedenej liečbe možno spravidla pokračovať.</td></tr>
    <tr><td>Statín je typicky nefrotoxický</td><td>Nesprávne</td><td>Zriedkavá rabdomyolýza však môže spôsobiť závažné akútne poškodenie obličiek.</td></tr>
    <tr><td>Fibrát možno pri pokročilej CKD kombinovať so statínom bez obmedzení</td><td>Nesprávne</td><td>Riziko myopatie rastie a dávkovanie závisí od funkcie obličiek.</td></tr>
  </tbody>
</table>
</div>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Súčasná liečba dyslipidémie sa neopiera iba o jednu laboratórnu hodnotu. Spája príčinnú úlohu aterogénnych lipoproteínov, absolútne kardiovaskulárne riziko, kumulatívnu expozíciu a bezpečnosť konkrétneho liečebného režimu.</p>

<p>Statíny zostávajú základom liečby. Ezetimib, inhibítory PCSK9 a kyselina bempedoová umožňujú dosiahnuť väčší pokles LDL cholesterolu alebo liečiť pacientov s neúplnou toleranciou statínov. Inklisiran účinne znižuje LDL cholesterol, ale rozsah priamo dokázaného klinického prínosu sa musí hodnotiť až podľa dokončených výsledkových štúdií.</p>

<p>Pri chronickej chorobe obličiek je hypolipidemická liečba mimoriadne dôležitá pred začatím dialýzy. Pri udržiavacej dialýze však neskoré začatie statínu neprinieslo v hlavných štúdiách rovnaký výsledkový prínos. Rozhodovanie preto musí rozlišovať nedialyzovanú CKD, dialýzu a transplantáciu.</p>

<p><strong>Najpresnejšie klinické posolstvo znie: lieči sa aterosklerotické riziko pacienta, nie izolované číslo v lipidovom profile. LDL cholesterol je však hlavný kauzálny a terapeuticky ovplyvniteľný cieľ.</strong></p>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Mach F, Koskinas KC, Roeters van Lennep JE, a spol.</strong> <em>2025 Focused Update of the 2019 ESC/EAS Guidelines for the management of dyslipidaemias.</em> Atherosclerosis. 2025;409:120479. doi: 10.1016/j.atherosclerosis.2025.120479. <a href="https://doi.org/10.1016/j.atherosclerosis.2025.120479" target="_blank" rel="noopener noreferrer">Aktualizácia ESC/EAS 2025</a>; <a href="https://www.escardio.org/Guidelines/Clinical-Practice-Guidelines/Dyslipidaemias-Management-of" target="_blank" rel="noopener noreferrer">stránka odporúčaní ESC</a>.</li>
  <li><strong>Mach F, Baigent C, Catapano AL, a spol.</strong> <em>2019 ESC/EAS Guidelines for the management of dyslipidaemias: lipid modification to reduce cardiovascular risk.</em> Eur Heart J. 2020;41(1):111–188. doi: 10.1093/eurheartj/ehz455. <a href="https://doi.org/10.1093/eurheartj/ehz455" target="_blank" rel="noopener noreferrer">Základné odporúčania z roku 2019</a>.</li>
  <li><strong>Nissen SE, Lincoff AM, Brennan D, a spol.</strong> <em>Bempedoic Acid and Cardiovascular Outcomes in Statin-Intolerant Patients.</em> N Engl J Med. 2023;388(15):1353–1364. doi: 10.1056/NEJMoa2215024. <a href="https://doi.org/10.1056/NEJMoa2215024" target="_blank" rel="noopener noreferrer">Štúdia CLEAR Outcomes</a>.</li>
  <li><strong>Baigent C, Landray MJ, Reith C, a spol.</strong> <em>The effects of lowering LDL cholesterol with simvastatin plus ezetimibe in patients with chronic kidney disease (Study of Heart and Renal Protection): a randomised placebo-controlled trial.</em> Lancet. 2011;377(9784):2181–2192. doi: 10.1016/S0140-6736(11)60739-3. <a href="https://doi.org/10.1016/S0140-6736%2811%2960739-3" target="_blank" rel="noopener noreferrer">Štúdia SHARP</a>.</li>
  <li><strong>Wanner C, Krane V, März W, a spol.</strong> <em>Atorvastatin in Patients with Type 2 Diabetes Mellitus Undergoing Hemodialysis.</em> N Engl J Med. 2005;353(3):238–248. doi: 10.1056/NEJMoa043545. <a href="https://doi.org/10.1056/NEJMoa043545" target="_blank" rel="noopener noreferrer">Štúdia 4D</a>.</li>
  <li><strong>Fellström BC, Jardine AG, Schmieder RE, a spol.</strong> <em>Rosuvastatin and Cardiovascular Events in Patients Undergoing Hemodialysis.</em> N Engl J Med. 2009;360(14):1395–1407. doi: 10.1056/NEJMoa0810177. <a href="https://doi.org/10.1056/NEJMoa0810177" target="_blank" rel="noopener noreferrer">Štúdia AURORA</a>.</li>
  <li><strong>Bhatt DL, Steg PG, Miller M, a spol.</strong> <em>Cardiovascular Risk Reduction with Icosapent Ethyl for Hypertriglyceridemia.</em> N Engl J Med. 2019;380(1):11–22. doi: 10.1056/NEJMoa1812792. <a href="https://doi.org/10.1056/NEJMoa1812792" target="_blank" rel="noopener noreferrer">Štúdia REDUCE-IT</a>.</li>
  <li><strong>Wanner C, Tonelli M; KDIGO Lipid Guideline Development Work Group.</strong> <em>KDIGO Clinical Practice Guideline for Lipid Management in CKD: summary of recommendation statements and clinical approach to the patient.</em> Kidney Int. 2014;85(6):1303–1309. doi: 10.1038/ki.2014.31. <a href="https://kdigo.org/guidelines/lipids-in-ckd/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO pre lipidy</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Odporúčania KDIGO 2024</a>.</li>
  <li><strong>European Medicines Agency.</strong> Registračné a bezpečnostné informácie o hypolipidemikách vrátane inklisiranu, evinakumabu a volanesorsenu. <a href="https://www.ema.europa.eu/en/medicines" target="_blank" rel="noopener noreferrer">Databáza liekov EMA</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Podnetom na tému bol odborný program Lipide 2026 na platforme Streamed Up; verejne dostupná stránka neobsahovala prepis prednášok ani konkrétne klinické tvrdenia, článok preto nie je jeho prekladom. Ide o nezávislú syntézu platných európskych odporúčaní, výsledkových štúdií a nefrologických súvislostí.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Indikácie, maximálne dávky, renálne úpravy, kontraindikácie a úhradové podmienky hypolipidemík treba pred použitím overiť podľa aktuálneho európskeho a slovenského súhrnu charakteristických vlastností lieku a pravidiel zdravotných poisťovní. Odporúčanie KDIGO pre lipidy je z roku 2013 a od jeho vydania sa európske odporúčania dvakrát revidovali.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_dyslipidemia-2026-kardiovaskularne-riziko-ldl-ciele-ckd_article',
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
