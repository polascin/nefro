<?php
/**
 * add_neziaduce-ucinky-statinov-dokazy-nefrologia_article.php
 * Odborny clanok o neziaducich ucinkoch statinov a ich interpretacii
 * v nefrologickej praxi, spracovany z clanku Medscape a primarnych studii.
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
    'title'        => 'Nežiaduce účinky statínov: čo ukazujú dôkazy a čo je dôležité v nefrológii',
    'slug'         => 'neziaduce-ucinky-statinov-dokazy-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Zaslepené štúdie potvrdzujú malé riziko svalových príznakov, diabetu a odchýlok pečeňových testov. Močový signál nepreukazuje klinicky významnú nefrotoxicitu.',
    'content'      => <<<'HTML'
<figure><a href="img/neziaduce-ucinky-statinov-dokazy-nefrologia.webp" rel="noopener noreferrer" target="_blank"><img src="img/neziaduce-ucinky-statinov-dokazy-nefrologia.webp" alt="Polopriesvitné obličky medzi svalovými vláknami, tabletou a prierezom cievy v modrom a červenom svetle" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická ilustračná scéna, nie snímka konkrétneho pacienta ani lieku. Obličky, svalové vlákna a cieva znázorňujú potrebu vyvažovať kardiovaskulárny prínos statínov, možné svalové ťažkosti a bezpečnosť liečby pri chorobe obličiek.</figcaption></figure>

<p>Statíny znižujú aterosklerotické kardiovaskulárne riziko, ich užívanie však často sprevádzajú obavy zo svalovej toxicity, poškodenia pečene, porúch pamäti či diabetu. Metaanalýzy zaslepených randomizovaných štúdií potvrdzujú, že niektoré nežiaduce účinky sú skutočné. Ich absolútny nadbytok je však pri väčšine pacientov malý a podstatne nižší než samotný výskyt ťažkostí počas liečby. [2–4]</p>

<p>V nefrologickej praxi nemožno bezpečnosť oddeliť od indikácie. Chronická choroba obličiek zvyšuje aterosklerotické riziko, zároveň prináša polyfarmáciu, častejšie liekové interakcie a viac alternatívnych príčin svalovej slabosti, edémov či zmien v moči. Výsledky všeobecných statínových štúdií preto treba interpretovať spolu so štádiom choroby obličiek, dialyzačnou liečbou, transplantáciou a konkrétnym liekom.</p>

<h2>Udalosť počas liečby ešte nemusí byť účinkom lieku</h2>

<p>Nežiaduca udalosť vznikne počas liečby, ale nemusí byť liekom spôsobená. Nežiaduci účinok predpokladá aspoň odôvodnenú možnosť príčinnej súvislosti. Rozdiel je podstatný pri príznakoch, ktoré sú bežné aj bez statínu: svalovej bolesti, únave, poruchách spánku alebo subjektívnych poruchách pamäti.</p>

<p>Dvojito zaslepené randomizované štúdie porovnávajú statín s placebom a obmedzujú vplyv očakávaní pacienta aj hodnotiteľa. Sú preto vhodnejšie na posudzovanie častých nešpecifických ťažkostí než otvorené pozorovanie. Ani veľké štúdie však nemusia spoľahlivo zachytiť veľmi zriedkavú toxicitu, dlhodobé následky alebo riziko v slabo zastúpených skupinách.</p>

<h2>Metaanalýza 154 664 účastníkov: čo sa skutočne zvýšilo</h2>

<p>Metaanalýza Cholesterol Treatment Trialists’ Collaboration z roku 2026 analyzovala individuálne údaje z 19 dvojito zaslepených štúdií statínu oproti placebu. Zahŕňali 123 940 účastníkov s mediánom sledovania 4,5 roka. Ďalšie štyri štúdie s 30 724 účastníkmi porovnávali intenzívnejší a menej intenzívny režim. Autori vyhľadali 66 kategórií nežiaducich udalostí uvedených v súhrnoch charakteristických vlastností atorvastatínu, fluvastatínu, pravastatínu, rosuvastatínu a simvastatínu. Výsledky korigovali na viacnásobné testovanie pomocou kontroly miery falošných objavov na úrovni 5 %. [2]</p>

<p>Okrem už skôr analyzovaných svalových a glykemických účinkov zostali po tejto korekcii štatisticky významné štyri kategórie: zvýšenie aminotransferáz, iné odchýlky pečeňových testov, zmeny zloženia moču a edémy. Pri ďalších 62 kategóriách vrátane kognitívnych porúch, depresie, porúch spánku, periférnej neuropatie a akútneho poškodenia obličiek sa významný nadbytok nepotvrdil. [2]</p>

<div class="table-responsive" role="region" aria-label="Štyri signály nežiaducich udalostí v metaanalýze statínu oproti placebu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória</th>
      <th scope="col">Statín, ročne</th>
      <th scope="col">Placebo, ročne</th>
      <th scope="col">Pomer mier a 95 % IS</th>
      <th scope="col">Absolútny ročný nadbytok</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Zvýšené aminotransferázy</th><td>0,30 %</td><td>0,22 %</td><td>1,41 (1,26 až 1,57)</td><td>0,09 percentuálneho bodu</td></tr>
    <tr><th scope="row">Iné odchýlky pečeňových testov</th><td>0,25 %</td><td>0,20 %</td><td>1,26 (1,12 až 1,41)</td><td>0,05 percentuálneho bodu</td></tr>
    <tr><th scope="row">Zmeny zloženia moču</th><td>0,21 %</td><td>0,18 %</td><td>1,18 (1,04 až 1,33)</td><td>0,03 percentuálneho bodu</td></tr>
    <tr><th scope="row">Edémy</th><td>1,38 %</td><td>1,31 %</td><td>1,07 (1,02 až 1,12)</td><td>0,07 percentuálneho bodu</td></tr>
  </tbody>
</table>
</div>

<p>Výsledok neznamená, že statíny „majú iba štyri nežiaduce účinky“. Analýza hodnotila vopred určené udalosti z liekových informácií a jej autori výslovne upozorňujú, že tento zoznam nemusí zahŕňať všetky možné účinky. Štatistický signál tiež nie je automaticky dôkazom klinicky závažného poškodenia. Rozhoduje jeho absolútna veľkosť, dávková odpoveď, biologická vierohodnosť a vplyv na klinické výsledky. [2]</p>

<h2>Svalové príznaky: malý nadbytok, sústredený najmä do prvého roka</h2>

<p>Samostatná metaanalýza individuálnych údajov z 19 dvojito zaslepených štúdií zaznamenala svalovú bolesť alebo slabosť u 27,1 % účastníkov pridelených k statínu a u 26,6 % účastníkov pridelených k placebu počas váženého priemerného mediánu sledovania 4,3 roka. Pomer mier bol 1,03 (95 % interval spoľahlivosti 1,01 až 1,06). [3]</p>

<p>V prvom roku bol relatívny nadbytok výraznejší: približne 11 dodatočných hlásení svalovej bolesti alebo slabosti na 1 000 osoborokov. Autori odhadli, že iba približne jedno z 15 hlásení počas prvého roka bolo pripísateľné statínu. Po prvom roku sa pri všetkých režimoch spolu významný nadbytok nepotvrdil, hoci pri intenzívnejších režimoch zostala neistota. [3]</p>

<p>Väčšina svalových ťažkostí zaznamenaných počas statínovej liečby teda nebola spôsobená farmakologickým účinkom statínu. Tento populačný údaj však neurčuje príčinu ťažkostí u konkrétneho pacienta. Normálna koncentrácia kreatínkinázy nevylučuje myalgiu a pri podozrení treba posúdiť časový priebeh, fyzickú záťaž, hypotyreózu, poruchy elektrolytov, súbežné ochorenia a liekové interakcie.</p>

<p>Myalgiu treba odlíšiť od svalového poškodenia so zvýšením kreatínkinázy a od rabdomyolýzy. Výrazná slabosť, silná bolesť, tmavý moč alebo pokles diurézy vyžadujú bezodkladné vyšetrenie. Rabdomyolýza môže viesť k hyperkaliémii a akútnemu poškodeniu obličiek, preto má u pacienta s chorobou obličiek osobitný význam.</p>

<h2>Nocebo efekt neznamená, že príznaky nie sú reálne</h2>

<p>V štúdii SAMSON dostalo 60 pacientov, ktorí predtým statín prerušili pre nežiaduce príznaky, v náhodnom poradí štyri mesačné obdobia s atorvastatínom 20 mg, štyri s placebom a štyri bez tabliet. Priemerné skóre príznakov bolo 8,0 bez tabliet, 16,3 pri atorvastatíne a 15,4 pri placebe. Medzi atorvastatínom a placebom nebol štatisticky významný rozdiel. Takzvaný nocebo pomer dosiahol 0,90, teda 90 % symptomatickej záťaže navyše pozorovanej pri statíne oproti obdobiu bez tabliet sa objavilo aj pri placebe. [5]</p>

<p>Neznamená to, že 90 % pacientov si ťažkosti vymýšľa. Príznaky boli reálne, ale ich načasovanie a intenzita v tejto malej výberovej štúdii nerozlišovali farmakologický účinok od účinku očakávania spojeného s užitím tablety. Šesť mesiacov po skončení štúdie statín opäť užívala polovica randomizovaných účastníkov. [5]</p>

<p>StatinWISE, séria 200 dvojito zaslepených N-of-1 skúšaní s atorvastatínom 20 mg a placebom, takisto nezistila priemerný rozdiel v intenzite svalových príznakov. Do primárnej analýzy však vstúpilo 151 účastníkov a štúdia skúmala iba jednu dávku jedného statínu. Nevylučuje preto farmakologické ťažkosti u malej časti pacientov ani riziko pri iných režimoch. [6]</p>

<h2>Diabetes mellitus: malé posuny môžu prekročiť diagnostickú hranicu</h2>

<p>Metaanalýza individuálnych údajov z roku 2024 potvrdila dávkovo závislé zvýšenie počtu nových diagnóz diabetu. Pri nízkej alebo strednej intenzite bola ročná incidencia 1,3 % pri statíne a 1,2 % pri placebe, s pomerom mier 1,10 (95 % interval spoľahlivosti 1,04 až 1,16). Pri vysokointenzívnej liečbe bola ročná incidencia 4,8 % oproti 3,5 % a pomer mier 1,36 (1,25 až 1,48). [4]</p>

<p>Absolútne incidencie z týchto dvoch súborov nemožno priamo porovnávať. Autori zistili, že ich výrazne ovplyvnila frekvencia merania HbA1c, ktorá bola vyššia v skúšaniach vysokointenzívnej liečby. Priemerná glykémia u účastníkov bez diabetu vzrástla o 0,04 mmol/l. HbA1c sa zvýšil o 0,06 percentuálneho bodu pri nízkej alebo strednej intenzite a o 0,08 percentuálneho bodu pri vysokej intenzite. Približne 62 % nových diagnóz vzniklo u ľudí, ktorí boli už na začiatku v najvyššej štvrtine rozdelenia glykémie. [4]</p>

<p>Statín teda často posunie pacienta s hodnotami blízko diagnostickej hranice cez túto hranicu. Nová diagnóza diabetu nie je automatickým dôvodom na vysadenie správne indikovanej liečby. Vyžaduje metabolickú starostlivosť a nové zhodnotenie pomeru prínosu a rizika.</p>

<h2>Pečeňové testy: laboratórna odchýlka nie je zlyhanie pečene</h2>

<p>Zvýšené aminotransferázy sa v analýze z roku 2026 vyskytovali ročne u 0,30 % účastníkov pri statíne a u 0,22 % pri placebe. Spolu s inými odchýlkami pečeňových testov predstavoval absolútny ročný nadbytok 0,13 percentuálneho bodu. Porovnania intenzívnejšej s menej intenzívnou liečbou podporili dávkovú závislosť. [2]</p>

<p>Aminotransferázy sú markery poškodenia buniek, nie priame meradlá syntetickej funkcie pečene. Izolovaný vzostup alanínaminotransferázy alebo aspartátaminotransferázy nemožno stotožniť so závažným liekovým poškodením či zlyhaním pečene; aspartátaminotransferáza môže pochádzať aj zo svalu. Význam výsledku určujú jeho rozsah a dynamika, klinické príznaky, bilirubín, ďalšie ukazovatele a alternatívne príčiny.</p>

<h2>Močový nález a edémy nepreukazujú klinicky významnú nefrotoxicitu</h2>

<p>Primárna publikácia umožňuje presnejšiu interpretáciu než široká kategória „zmeny zloženia moču“. V post hoc analýze išlo najmä o kompozit proteinúrie, albuminúrie alebo mikroalbuminúrie: pomer mier 1,20 (95 % interval spoľahlivosti 1,02 až 1,42) a absolútny ročný nadbytok 0,02 percentuálneho bodu. Statíny významne nezvýšili leukocytúriu, hematúriu, iné močové abnormality ani klinické renálne výsledky vrátane akútneho poškodenia obličiek. [2]</p>

<p>Pri intenzívnejšej oproti menej intenzívnej liečbe sa močový signál nepotvrdil a neobjavila sa dávková odpoveď. Autori preto jeho kauzalitu a klinický význam hodnotia ako neisté. Malý vzostup koncentrácie bielkovín v moči nemožno automaticky preložiť ako progresiu chronickej choroby obličiek alebo glomerulové poškodenie. [2]</p>

<p>Podobne malý nadbytok edémov, 0,07 percentuálneho bodu ročne, nebol závislý od intenzity liečby. Databáza neumožnila určiť závažnosť edému a pozorovaný močový signál podľa autorov pravdepodobne nevysvetľuje jeho nadbytok. U pacienta s novým edémom preto treba hľadať kongesciu, venózne ochorenie, hypoalbuminémiu, retenciu sodíka a účinky ďalších liekov, nie ho automaticky pripísať statínu. [2]</p>

<h2>Kognícia, nálada a spánok: randomizované údaje kauzálny vzťah nepodporujú</h2>

<p>Metaanalýza nezistila po korekcii na viacnásobné testovanie významný nadbytok kognitívnych porúch, depresie ani porúch spánku. Presné posolstvo je, že veľké zaslepené randomizované údaje nepodporujú všeobecný kauzálny vzťah. Neznamená to, že pri individuálnom pacientovi možno bez vyšetrenia vylúčiť akúkoľvek časovú súvislosť alebo inú príčinu ťažkostí. [2]</p>

<h2>Čo sa mení v nefrologickej praxi</h2>

<p>KDIGO 2024 odporúča statín alebo kombináciu statínu s ezetimibom dospelým vo veku najmenej 50 rokov s odhadovanou glomerulovou filtráciou nižšou ako 60 ml/min/1,73 m², ktorí nie sú liečení chronickou dialýzou a nemajú transplantovanú obličku. Pri zachovalejšej filtrácii v rovnakej vekovej skupine odporúča statín. U mladších dospelých sa rozhoduje podľa známeho koronárneho ochorenia, diabetu, prekonanej ischemickej cievnej mozgovej príhody alebo vysokého odhadovaného koronárneho rizika. [7]</p>

<p>Pre dialýzu a transplantáciu platí odlišný dôkazový rámec. KDIGO neodporúča statín ani kombináciu statínu s ezetimibom rutinne začínať u dospelých s dialyzačne závislou chronickou chorobou obličiek, ale navrhuje pokračovať, ak ich pacient užíval pri začatí dialýzy. Dospelým príjemcom transplantovanej obličky statín navrhuje. [7] Bezpečnostná metaanalýza z roku 2026 zahŕňala aj štúdie ALERT, 4D a AURORA, nebola však navrhnutá ako samostatná analýza bezpečnosti pre každú nefrologickú podskupinu. [2]</p>

<p>Pri výbere lieku a dávky treba skontrolovať aktuálny súhrn charakteristických vlastností konkrétneho prípravku. Riziko svalovej toxicity môžu zvyšovať konkrétne kombinácie so silnými inhibítormi metabolizmu statínu, niektorými makrolidmi a azolovými antimykotikami, fibrátmi či imunosupresívami. Pri transplantovanom pacientovi je preto dôležitejší presný interakčný profil celej medikácie než všeobecná veta o „interakcii statínov“.</p>

<h2>Praktický postup pri podozrení na intoleranciu</h2>

<p>Podozrenie na nežiaduci účinok nemá viesť ani k bagatelizovaniu príznakov, ani k automatickému trvalému vysadeniu účinnej prevencie. Najprv treba zaznamenať začiatok a charakter ťažkostí, súvislosť so začatím liečby alebo zvýšením dávky, zmeny súbežnej medikácie, fyzickú záťaž a interkurentné ochorenia.</p>

<p>Vyšetrenia sa riadia klinickým obrazom. Pri významných svalových ťažkostiach môže byť potrebné stanoviť kreatínkinázu, kreatinín a elektrolyty; pri močovom náleze vyšetriť sediment a kvantifikovať albuminúriu alebo proteinúriu. Ťažká slabosť, výrazne zvýšená kreatínkináza, tmavý moč, hyperkaliémia alebo akútne zhoršenie funkcie obličiek vyžadujú urgentné riešenie.</p>

<p>Ak je podozrenie klinicky dôvodné a nejde o závažnú toxicitu, možno pod lekárskym dohľadom zvážiť dočasné prerušenie, nižšiu dávku, iný statín alebo kombináciu tolerovanej dávky s nestatínovým hypolipidemikom. Ústup príznakov po vysadení podozrenie podporuje, sám však kauzalitu nedokazuje; príznaky môžu prirodzene kolísať. Opätovné podanie po závažnej toxicite patrí do individuálneho odborného rozhodovania po objasnení príčiny.</p>

<h2>Limity dôkazov</h2>

<p>Analýza z roku 2026 je založená na individuálnych údajoch z veľkých, dlhodobých a dvojito zaslepených štúdií, čo obmedzuje skreslenie pri častých nešpecifických udalostiach. Jednotlivé skúšania však nezbierali nežiaduce udalosti úplne rovnakým spôsobom a niektoré zaznamenávali iba závažné alebo vybrané udalosti. Zistenia sa vzťahujú na päť skúmaných statínov a na populácie zaradené do príslušných skúšaní. [2]</p>

<p>Kontrola miery falošných objavov znižuje riziko náhodných pozitívnych nálezov, nevylučuje však falošne negatívny výsledok. Veľmi zriedkavá toxicita, špecifické liekové interakcie a skupiny s nedostatočným zastúpením preto naďalej vyžadujú farmakovigilanciu a individuálne posúdenie.</p>

<h2>Záver</h2>

<p>Najlepšie zaslepené randomizované dôkazy potvrdzujú malý absolútny nadbytok svalových príznakov, nových diagnóz diabetu a odchýlok pečeňových testov. Signály mierne zvýšenej proteinúrie a edémov nemali dávkovú odpoveď a ich klinický význam zostáva neistý; analýza nepreukázala nadbytok akútneho poškodenia obličiek.</p>

<p>U pacienta s chronickou chorobou obličiek je cieľom zachovať liečbu s primeraným kardiovaskulárnym prínosom bez prehliadnutia skutočnej toxicity. To si vyžaduje správnu indikáciu, vhodný liek a dávku, kontrolu interakcií a vecné vyšetrenie nových príznakov. Samotná časová súvislosť nestačí na dokázanie príčiny, ale ani nízke priemerné riziko neoprávňuje individuálne ťažkosti ignorovať.</p>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie ani aktuálny súhrn charakteristických vlastností konkrétneho lieku.</em></p>

<h2>Literatúra</h2>

<ol>
  <li><em>van den Heuvel M. Statin Side Effects: What the Evidence Shows. Medscape. 5. októbra 2026. <a href="https://www.medscape.com/viewarticle/statin-side-effects-what-evidence-shows-2026a100112s" target="_blank" rel="noopener noreferrer">Východiskový článok</a>.</em></li>
  <li><em>Cholesterol Treatment Trialists’ (CTT) Collaboration. Assessment of adverse effects attributed to statin therapy in product labels: a meta-analysis of double-blind randomised controlled trials. Lancet. 2026;407(10529):689–703. doi: 10.1016/S0140-6736(25)01578-8. PMID: 41655587. PMCID: PMC7619005. <a href="https://pubmed.ncbi.nlm.nih.gov/41655587/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7619005/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></li>
  <li><em>Cholesterol Treatment Trialists’ Collaboration, Reith C, Baigent C, Blackwell L, Emberson J, Spata E, Davies K, Halls H, Holland L, Wilson K, Armitage J, Harper C, Preiss D, Roddick A, Keech A, Simes J, Collins R, Barnes E, Fulcher J, Herrington WG. Effect of statin therapy on muscle symptoms: an individual participant data meta-analysis of large-scale, randomised, double-blind trials. Lancet. 2022;400(10355):832–845. doi: 10.1016/S0140-6736(22)01545-8. PMID: 36049498. <a href="https://pubmed.ncbi.nlm.nih.gov/36049498/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Cholesterol Treatment Trialists’ Collaboration. Effects of statin therapy on diagnoses of new-onset diabetes and worsening glycaemia in large-scale randomised blinded statin trials: an individual participant data meta-analysis. Lancet Diabetes Endocrinol. 2024;12(5):306–319. doi: 10.1016/S2213-8587(24)00040-8. PMID: 38554713. <a href="https://pubmed.ncbi.nlm.nih.gov/38554713/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Howard JP, Wood FA, Finegold JA, Nowbar AN, Thompson DM, Arnold AD, Rajkumar CA, Connolly S, Cegla J, Stride C, Sever P, Norton C, Thom SAM, Shun-Shin MJ, Francis DP. Side Effect Patterns in a Crossover Trial of Statin, Placebo, and No Treatment. J Am Coll Cardiol. 2021;78(12):1210–1222. doi: 10.1016/j.jacc.2021.07.022. PMID: 34531021. <a href="https://pubmed.ncbi.nlm.nih.gov/34531021/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Herrett E, Williamson E, Brack K, Perkins A, Thayne A, Shakur-Still H, Roberts I, Prowse D, Beaumont D, Jamal Z, Goldacre B, van Staa T, MacDonald TM, Armitage J, Moore M, Hoffman M, Smeeth L. The effect of statins on muscle symptoms in primary care: the StatinWISE series of 200 N-of-1 RCTs. Health Technol Assess. 2021;25(16):1–62. doi: 10.3310/hta25160. PMID: 33709907. <a href="https://pubmed.ncbi.nlm.nih.gov/33709907/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Oficiálne usmernenie</a>.</em></li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Východiskom bol článok Medscape. Hlavné tvrdenia a číselné údaje boli porovnané s plným textom metaanalýzy CTT vrátane jej nefrologických post hoc analýz, s úplnými abstraktmi v PubMed, so štúdiami SAMSON a StatinWISE a s usmernením KDIGO 2024. Nefrologická interpretácia a praktické usporiadanie textu sú redakčným spracovaním uvedených zdrojov.</em></p>

<h3>Súvisiace články</h3>
<ul>
  <li><a href="article.php?slug=dyslipidemia-ckd-acc-aha-2026-nefrologicka-prax">Dyslipidémia pri CKD: odporúčania a nefrologická prax</a></li>
  <li><a href="article.php?slug=rosuvastatin-rabdomyolyza-aki-dialyza">Rosuvastatín, rabdomyolýza a akútne poškodenie obličiek</a></li>
  <li><a href="article.php?slug=postmarketingove-bezpecnostne-zlyhania-liekov-fda-ema">Postmarketingová bezpečnosť liekov: čo zachytia FDA a EMA</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_neziaduce-ucinky-statinov-dokazy-nefrologia_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
            <div class="alert alert-error"><ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul></div>
          <?php endif; ?>
          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?><p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p><?php endif; ?>
          </div>
          <p class="mt-30"><a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a></p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
