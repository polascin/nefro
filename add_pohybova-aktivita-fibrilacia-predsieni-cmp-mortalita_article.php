<?php
/**
 * Odborny clanok: pohybova aktivita pri fibrilacii predsieni.
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
    'title'        => 'Pohybová aktivita pri fibrilácii predsiení: nižšie riziko cievnej mozgovej príhody a úmrtia, nie náhrada antikoagulácie',
    'slug'         => 'pohybova-aktivita-fibrilacia-predsieni-cmp-mortalita',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nórske kohorty HUNT a Tromsø spájajú už nízku pohybovú aktivitu s nižším rizikom cievnej mozgovej príhody a úmrtia pri fibrilácii predsiení. Observačný výsledok však nenahrádza antikoaguláciu.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Analýza 87 340 účastníkov štúdií HUNT a Tromsø spája aj nízku úroveň pohybovej aktivity s nižším rizikom cievnej mozgovej príhody a úmrtia. Podobná asociácia sa pozorovala u ľudí s fibriláciou predsiení aj bez nej. Výsledok je klinicky povzbudivý, ale observačná štúdia nedokazuje kauzalitu a pohybová aktivita nenahrádza antikoagulačnú liečbu indikovanú podľa tromboembolického rizika.</em></p>

<h2>Prečo je táto otázka dôležitá</h2>

<p>Fibrilácia predsiení je najčastejšou pretrvávajúcou srdcovou arytmiou. Nepravidelná aktivácia predsiení podporuje stázu krvi, najmä v ušku ľavej predsiene, a tvorbu trombu. Jeho embolizácia môže spôsobiť ischemickú cievnu mozgovú príhodu alebo systémovú embóliu.</p>

<p>Riziko nie je u všetkých pacientov rovnaké. Ovplyvňuje ho vek, predchádzajúca cievna mozgová príhoda alebo tranzitórny ischemický atak, hypertenzia, diabetes, srdcové zlyhávanie, cievne ochorenie a ďalšie faktory. Chronická choroba obličiek zároveň zvyšuje tromboembolické aj krvácavé riziko a komplikuje výber i dávkovanie antikoagulačnej liečby.</p>

<p>Pohybová aktivita priaznivo ovplyvňuje krvný tlak, telesnú hmotnosť, inzulínovú senzitivitu, kardiorespiračnú zdatnosť a funkčnú sebestačnosť. Doteraz však nebolo dostatočne jasné, či sa jej priaznivá asociácia s cievnou mozgovou príhodou a mortalitou zachová aj po vzniku fibrilácie predsiení.</p>

<h2>Čo skúmala nórska analýza</h2>

<p>Johansen a spolupracovníci spojili údaje zo štúdií HUNT a Tromsø, dvoch veľkých populačných kohort v Nórsku. Do analýzy zaradili <strong>87 340 dospelých</strong>; priemerný vek bol 50,9 roka a 47,4 % tvorili muži. Fibrilácia predsiení bola evidovaná u 6 539 účastníkov.</p>

<p>Údaje o fibrilácii predsiení, cievnych mozgových príhodách a úmrtiach pochádzali z národných zdravotných registrov. Ak sa fibrilácia predsiení objavila až počas sledovania, účastník bol od času diagnózy zaradený do skupiny s arytmiou. Takýto časovo aktualizovaný prístup je presnejší než posudzovanie fibrilácie predsiení iba pri vstupe do štúdie.</p>

<p>Počas mediánu sledovania 13,5 roka sa zaznamenalo:</p>

<ul>
  <li><strong>3 415 cievnych mozgových príhod</strong>,</li>
  <li><strong>7 833 úmrtí zo všetkých príčin</strong>.</li>
</ul>

<p>Približne 87 % cievnych mozgových príhod bolo ischemických a 13 % predstavovali intracerebrálne krvácania. Autori použili multivariabilne upravené flexibilné parametrické modely prežívania.</p>

<h2>Ako sa merala pohybová aktivita</h2>

<p>Účastníci v dotazníkoch uvádzali frekvenciu, trvanie a intenzitu pohybovej aktivity. Z odpovedí sa vypočítal týždenný objem v metabolických ekvivalentoch za minútu, teda v MET-min/týždeň.</p>

<div class="table-responsive" role="region" aria-label="Kategórie pohybovej aktivity v nórskej štúdii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória</th>
      <th scope="col">Objem aktivity</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Neaktívni</td><td>0 MET-min/týždeň</td></tr>
    <tr><td>Nízka aktivita</td><td>1 až 449 MET-min/týždeň</td></tr>
    <tr><td>Stredná aktivita</td><td>450 až 899 MET-min/týždeň</td></tr>
    <tr><td>Vysoká aktivita</td><td>≥ 900 MET-min/týždeň</td></tr>
  </tbody>
</table>
</div>

<p>Jeden MET približne zodpovedá energetickému výdaju v pokoji. Päť 30-minútových aktivít s intenzitou 3 MET predstavuje približne 450 MET-min/týždeň. Ide len o orientačný prepočet: energetická náročnosť chôdze, bicyklovania či iného pohybu závisí od tempa, terénu a fyzickej zdatnosti.</p>

<p><strong>Nízka úroveň aktivity v tejto štúdii nie je synonymom ľahkej intenzity.</strong> Kategória vyjadruje celkový týždenný objem odvodený z frekvencie, trvania a intenzity. Výsledky preto nemožno preložiť ako dôkaz, že presne určený počet minút „ľahkého cvičenia“ zabráni cievnej mozgovej príhode.</p>

<h2>Hlavné výsledky</h2>

<p>V celom súbore bolo v porovnaní s neaktívnymi účastníkmi upravené riziko cievnej mozgovej príhody nižšie:</p>

<ul>
  <li>o <strong>9 %</strong> pri nízkej aktivite (95 % interval spoľahlivosti [IS] 1 až 16 %),</li>
  <li>o <strong>19 %</strong> pri strednej aktivite (95 % IS 11 až 27 %),</li>
  <li>o <strong>18 %</strong> pri vysokej aktivite (95 % IS 8 až 26 %).</li>
</ul>

<p>Upravené riziko úmrtia zo všetkých príčin bolo nižšie:</p>

<ul>
  <li>o <strong>11 %</strong> pri nízkej aktivite (95 % IS 7 až 14 %),</li>
  <li>o <strong>18 %</strong> pri strednej aktivite (95 % IS 14 až 22 %),</li>
  <li>o <strong>22 %</strong> pri vysokej aktivite (95 % IS 18 až 27 %).</li>
</ul>

<p>Podobný smer asociácie sa zachoval po rozdelení účastníkov podľa prítomnosti fibrilácie predsiení. Priaznivý vzťah medzi pohybovou aktivitou a sledovanými výsledkami bol teda podobný u ľudí s fibriláciou predsiení aj bez nej.</p>

<h2>Čo ukázali modely pri fibrilácii predsiení</h2>

<div class="table-responsive" role="region" aria-label="Modelované výsledky u účastníkov s fibriláciou predsiení" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Aktivita oproti neaktivite</th>
      <th scope="col">Pomer 15-ročného rizika cievnej mozgovej príhody</th>
      <th scope="col">Pomer 15-ročného rizika úmrtia</th>
      <th scope="col">Odhadovaný zisk dĺžky života</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Nízka</td><td>0,80</td><td>0,91</td><td>0,50 roka (95 % IS 0,22 až 0,78)</td></tr>
    <tr><td>Stredná</td><td>0,88</td><td>0,88</td><td>0,66 roka (95 % IS 0,31 až 1,01)</td></tr>
    <tr><td>Vysoká</td><td>0,80</td><td>0,79</td><td>1,15 roka (95 % IS 0,77 až 1,53)</td></tr>
  </tbody>
</table>
</div>

<p>Tieto hodnoty sú <strong>upravené pomery modelovaného 15-ročného rizika</strong>, nie hazard ratio. Odhadovaný zisk dĺžky života je populačný výstup štatistického modelu. Neznamená, že konkrétnemu pacientovi možno sľúbiť predĺženie života o presný počet mesiacov.</p>

<p>Pri mortalite bol priaznivý gradient s rastúcou aktivitou zreteľnejší. Pri cievnej mozgovej príhode v skupine s fibriláciou predsiení nebola dávková odpoveď monotónna: pomer rizika bol 0,80 pri nízkej aj vysokej aktivite a 0,88 pri strednej aktivite. Zo štúdie preto nemožno odvodiť jednu optimálnu dávku pohybu na prevenciu cievnej mozgovej príhody.</p>

<h2>Ischemická a hemoragická príhoda nie sú to isté</h2>

<p>Pri analýze ischemických cievnych mozgových príhod bol smer výsledkov podobný ako pri celkovom ukazovateli. Pri intracerebrálnom krvácaní sa štatisticky významná asociácia nepotvrdila. Keďže krvácania tvorili iba menšiu časť príhod, analýza mohla mať nedostatočnú štatistickú silu.</p>

<p>Mechanizmy sa navyše líšia. Fibrilácia predsiení priamo súvisí najmä s kardioembolickou ischemickou príhodou. Intracerebrálne krvácanie ovplyvňujú najmä hypertenzia, vek, cerebrálna amyloidová angiopatia, antitrombotická liečba a ďalšie cievne faktory. Neštatisticky významný výsledok preto nemožno interpretovať ako dôkaz neprítomnosti akéhokoľvek vzťahu.</p>

<h2>Čo štúdia nedokazuje</h2>

<h3>Asociácia nie je kauzalita</h3>

<p>Účastníci neboli náhodne pridelení k rozdielnej úrovni pohybu. Aktívnejší ľudia mohli mať lepšiu stravu, nižšiu krehkosť, priaznivejší sociálno-ekonomický profil, vyššiu adherenciu k liečbe alebo lepší prístup k zdravotnej starostlivosti. Štatistická úprava tieto rozdiely zmierňuje, ale neodstraňuje všetky nemerané a nepresne merané faktory.</p>

<h3>Reverzná kauzalita</h3>

<p>Symptomatická fibrilácia predsiení, srdcové zlyhávanie, krehkosť alebo iné ochorenie mohli pohyb obmedziť už pred zaznamenanou príhodou. Neaktivita tak môže byť nielen rizikovým faktorom, ale aj markerom horšieho zdravotného stavu.</p>

<h3>Sebahodnotenie a zmeny v čase</h3>

<p>Pohyb sa meral dotazníkom, nie nepretržite akcelerometrom. Odpovede podliehajú chybe pamäti a nepresnému odhadu intenzity. Ani opakované údaje zo študijných návštev nedokážu zachytiť všetky zmeny aktivity počas 13,5 roka.</p>

<h3>Obmedzená generalizovateľnosť</h3>

<p>HUNT a Tromsø sú kvalitné nórske kohorty, ale výsledky sa nemusia v rovnakej miere preniesť na populácie s odlišným etnickým zložením, sociálnymi podmienkami, prevalenciou obezity alebo dostupnosťou zdravotnej starostlivosti. Relatívne zníženie rizika navyše nevyjadruje absolútny prínos pre konkrétneho pacienta.</p>

<h2>Pohyb nenahrádza antikoaguláciu</h2>

<p>Toto je najdôležitejšia klinická hranica interpretácie. Pohyb môže zlepšiť viaceré modifikovateľné rizikové faktory, ale spoľahlivo neodstraňuje stázu krvi v ľavej predsieni ani tromboembolické riziko spojené s vekom, prekonanou cievnou mozgovou príhodou a ďalšími komorbiditami.</p>

<p>Podľa odporúčaní ESC z roku 2024 sa rozhodnutie o perorálnej antikoagulácii pri klinickej fibrilácii predsiení opiera o pravidelne prehodnocované tromboembolické riziko, v európskom rámci najmä o skóre <strong>CHA₂DS₂-VA</strong> a ďalšie individuálne faktory. Pri skóre 1 sa má antikoagulácia zvážiť a pri skóre ≥ 2 sa odporúča, ak pacient nemá kontraindikáciu. Krvácavé rizikové faktory treba aktívne upravovať; samotné krvácavé skóre spravidla nemá byť dôvodom na odopretie indikovanej liečby.</p>

<p>Pacient nemá svojvoľne vysadiť antikoagulans preto, že začal cvičiť, schudol, nemá symptómy alebo úspešne absolvoval abláciu. Dlhodobá antikoagulácia po ablácii sa riadi tromboembolickým rizikom, nie iba vnímaným úspechom kontroly rytmu.</p>

<p>Údaje o antikoagulačnej liečbe neboli v nórskej analýze dostupné pre celý súbor. Doplnková úprava v podskupine s dostupnými údajmi hlavný smer výsledkov zásadne nezmenila, no nedokázala zachytiť všetky zmeny indikácie, lieku, dávky a adherencie počas dlhého sledovania. Štúdia preto neporovnáva pohyb s antikoaguláciou a nedokazuje ich zameniteľnosť.</p>

<h2>Koľko pohybu odporúčať</h2>

<p>Pre dospelých sa vo všeobecnosti odporúča postupne smerovať k 150 až 300 minútam stredne intenzívnej aeróbnej aktivity týždenne alebo k 75 až 150 minútam intenzívnej aktivity, prípadne k ich kombinácii. Súčasťou programu má byť posilňovanie hlavných svalových skupín aspoň dvakrát týždenne a obmedzenie dlhého neprerušovaného sedenia.</p>

<p>Štúdia HUNT a Tromsø neurčuje presný tréningový predpis pre fibriláciu predsiení. Jej praktické posolstvo je skromnejšie: aj malý, bezpečne dosiahnuteľný posun od úplnej neaktivity môže mať význam. U krehkého alebo dlhodobo neaktívneho človeka môže byť prvým cieľom niekoľko krátkych úsekov chôdze denne, nie okamžité splnenie populačného maxima.</p>

<p>Intenzitu, trvanie aj typ aktivity treba prispôsobiť veku, symptómom, kontrole komorovej frekvencie, srdcovému zlyhávaniu, ischemickej chorobe srdca, funkcii obličiek, riziku pádu a predchádzajúcej zdatnosti.</p>

<h2>Intenzívny šport a bezpečnostné hranice</h2>

<p>Pravidelná mierna až stredná aktivita je prevažne prospešná. Dlhoročné veľmi vysoké vytrvalostné zaťaženie sa však u predisponovaných športovcov spája s vyšším výskytom fibrilácie predsiení. Tento poznatok nie je argumentom proti bežnej rekreačnej chôdzi, cyklistike alebo primeranému aeróbnemu tréningu.</p>

<p>Počas antikoagulačnej liečby nie je potrebná úplná neaktivita, ale treba zohľadniť následky pádu a poranenia. Chôdza, stacionárny bicykel, primerané plávanie, kontrolovaný silový tréning a cvičenie rovnováhy mávajú nižšie úrazové riziko. Kontaktné športy a aktivity s významným rizikom pádu alebo úderu do hlavy vyžadujú individuálne spoločné rozhodnutie.</p>

<p>Aktivitu treba prerušiť a vyhľadať lekárske posúdenie pri bolesti alebo tlaku na hrudníku, synkope či presynkope, novej neprimeranej dýchavici, náhlom poklese výkonnosti, pretrvávajúcej rýchlej srdcovej frekvencii alebo neurologických príznakoch.</p>

<h2>Chronická choroba obličiek mení praktické rozhodovanie</h2>

<p>Chronická choroba obličiek je spojená s vyšším výskytom fibrilácie predsiení, cievnej mozgovej príhody, krvácania aj mortality. Pohyb môže zlepšovať krvný tlak, svalovú silu, fyzickú kapacitu, inzulínovú senzitivitu a kvalitu života. KDIGO odporúča dospelým s CKD podľa tolerancie aspoň 150 minút stredne intenzívnej aktivity týždenne a obmedzovanie sedavého správania.</p>

<p>Nórska štúdia však nebola navrhnutá na samostatné hodnotenie jednotlivých kategórií CKD ani dialyzovaných pacientov. Jej odhady preto nemožno automaticky preniesť na človeka s pokročilým zlyhaním obličiek, výraznou anémiou, intradialyzačnou hypotenziou alebo vysokou krehkosťou.</p>

<h3>Antikoagulácia pri CKD</h3>

<p>Priamy perorálny antikoagulant sa má dávkovať podľa kritérií konkrétneho lieku a platného súhrnu charakteristických vlastností. Pri hodnotení renálnej funkcie pre dávkovanie sa často používa klírens kreatinínu podľa Cockcroftovej-Gaultovej rovnice, pretože takto boli pacienti klasifikovaní v rozhodujúcich registračných skúšaniach. Laboratórne uvádzaná eGFR a klírens kreatinínu nie sú zameniteľné.</p>

<p>Funkciu obličiek treba kontrolovať opakovane a častejšie pri vyššom veku, krehkosti, zníženom klírense alebo interkurentnom ochorení, ktoré môže spôsobiť akútne poškodenie obličiek. Neindikované zníženie dávky môže oslabiť ochranu pred tromboembolizmom; neprimerane vysoká dávka zvyšuje krvácavé riziko.</p>

<p>Pri zlyhaní obličiek liečenom dialýzou je dôkazová situácia zložitejšia a európske registračné podmienky sa medzi liekmi líšia. Rozhodnutie vyžaduje individuálne posúdenie tromboembolického a krvácavého rizika, liekových interakcií, anamnézy krvácania a preferencií pacienta.</p>

<h3>Pohyb pri dialýze</h3>

<p>Program môže podľa tolerancie zahŕňať chôdzu v nedialyzačných dňoch, intradialyzačné bicyklovanie, nácvik svalovej sily a rovnováhy. Treba zohľadniť krvný tlak, objemový stav, anémiu, kardiálne symptómy, riziko pádu a cievny prístup. Čerstvú alebo komplikovanú arteriovenóznu fistulu nemožno zaťažovať rovnakým spôsobom ako stabilný dlhodobo funkčný prístup.</p>

<h2>Praktický postup v ambulancii</h2>

<ol>
  <li>Zhodnotiť symptómy fibrilácie predsiení, komorovú frekvenciu, srdcové zlyhávanie, ischemické príznaky a východiskovú funkčnú kapacitu.</li>
  <li>Samostatne posúdiť tromboembolické riziko a indikáciu antikoagulácie; pohybovú aktivitu neposudzovať ako náhradu lieku.</li>
  <li>Skontrolovať modifikovateľné faktory: krvný tlak, telesnú hmotnosť, diabetes, spánkové apnoe, fajčenie a nadmerný príjem alkoholu.</li>
  <li>Pri CKD overiť renálnu funkciu, správnu dávku antikoagulancia, anémiu, objemový stav a liekové interakcie.</li>
  <li>Začať objemom a intenzitou, ktoré pacient bezpečne toleruje, a záťaž zvyšovať postupne.</li>
  <li>Kombinovať aeróbnu aktivitu so silovým a rovnovážnym tréningom; pri antikoagulácii minimalizovať úrazové riziko.</li>
  <li>Pri nových alarmujúcich príznakoch tréning prerušiť a klinický stav prehodnotiť.</li>
</ol>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Analýza štúdií HUNT a Tromsø ukazuje, že už nízka úroveň pohybovej aktivity bola spojená s nižším rizikom cievnej mozgovej príhody a úmrtia. Podobný vzťah sa pozoroval u účastníkov s fibriláciou predsiení aj bez nej a pri mortalite bol priaznivejší výsledok zreteľnejší pri vyššej aktivite.</p>

<p>Štúdia je observačná, aktivita bola hodnotená dotazníkom a reziduálne skreslenie ani reverznú kauzalitu nemožno vylúčiť. Neurčuje optimálnu dávku pohybu a modelový zisk dĺžky života nie je individuálnym prísľubom.</p>

<p><strong>Primeraná pravidelná pohybová aktivita patrí do komplexnej starostlivosti o pacienta s fibriláciou predsiení. Dopĺňa kontrolu rizikových faktorov, liečbu arytmie a správne indikovanú antikoaguláciu, ale nenahrádza ich.</strong></p>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Johansen KR, Nes BM, Malmo V, Myrstad M, Thelle DS, Heitmann KA, Mathiesen EB, Eggen AE, Wilsgaard T, Løchen ML, Morseth B; Norwegian Exercise and Atrial Fibrillation Initiative Investigators.</strong> <em>Impact of Physical Activity on Stroke and Mortality in Individuals With and Without Atrial Fibrillation: The HUNT Study and the Tromsø Study.</em> Journal of the American Heart Association. Publikované online 5. augusta 2026; e048812. doi: 10.1161/JAHA.126.048812. <a href="https://doi.org/10.1161/JAHA.126.048812" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42554413/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>American Heart Association.</strong> <em>Even light activity may lower stroke, death risk in people with atrial fibrillation.</em> Tlačová správa k primárnej štúdii, 5. augusta 2026. <a href="https://newsroom.heart.org/news/even-light-activity-may-lower-stroke-death-risk-in-people-with-atrial-fibrillation" target="_blank" rel="noopener noreferrer">AHA Newsroom</a>.</li>
  <li><strong>Van Gelder IC, Rienstra M, Bunting KV, et al.</strong> <em>2024 ESC Guidelines for the management of atrial fibrillation developed in collaboration with the European Association for Cardio-Thoracic Surgery (EACTS).</em> Eur Heart J. 2024;45(36):3314–3414. doi: 10.1093/eurheartj/ehae176. <a href="https://doi.org/10.1093/eurheartj/ehae176" target="_blank" rel="noopener noreferrer">Odporúčania ESC</a>.</li>
  <li><strong>Steffel J, Collins R, Antz M, et al.</strong> <em>2021 European Heart Rhythm Association Practical Guide on the Use of Non-Vitamin K Antagonist Oral Anticoagulants in Patients with Atrial Fibrillation.</em> Europace. 2021;23(10):1612–1676. doi: 10.1093/europace/euab065. <a href="https://doi.org/10.1093/europace/euab065" target="_blank" rel="noopener noreferrer">Praktická príručka EHRA</a>.</li>
  <li><strong>World Health Organization.</strong> <em>WHO Guidelines on Physical Activity and Sedentary Behaviour.</em> Geneva: WHO; 2020. <a href="https://www.who.int/publications/i/item/9789240015128" target="_blank" rel="noopener noreferrer">Odporúčania WHO</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(Suppl 4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Odporúčania KDIGO</a>.</li>
  <li><strong>Medscape Professional Network.</strong> <em>Even Low Physical Activity May Lower Stroke Risk in AF.</em> 2026. Individuálny autor nebol vo verejne dostupnom zobrazení spoľahlivo uvedený. <a href="https://www.medscape.com/viewarticle/even-low-physical-activity-may-lower-stroke-risk-atrial-2026a1000rij" target="_blank" rel="noopener noreferrer">Sekundárne spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k interpretácii:</strong> Článok sumarizuje populačné observačné údaje a všeobecné odborné odporúčania. Konkrétny tréningový plán, indikáciu antikoagulácie a jej dávkovanie treba prispôsobiť klinickému stavu, funkcii obličiek, platnému súhrnu charakteristických vlastností lieku a miestnym odporúčaniam.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_pohybova-aktivita-fibrilacia-predsieni-cmp-mortalita_article',
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
