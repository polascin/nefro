<?php

/**
 * add_ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba_article.php
 * Odborný článok o skríningu a vrstvenej liečbe CKD pri diabete.
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
    'title'        => 'Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba',
    'slug'         => 'ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'CKD pri diabete odhalí až spoločné hodnotenie eGFR a UACR. Praktický rámec skríningu, diferenciálnej diagnostiky a bezpečného vrstvenia RAS blokády, inhibítora SGLT2, finerenónu a agonistu receptora GLP-1.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Chronická choroba obličiek (CKD) patrí medzi najčastejšie a prognosticky najzávažnejšie komplikácie diabetu, no dlho môže zostať bez príznakov. Samotný kreatinín ani samotná albuminúria nestačia. Včasný záchyt vyžaduje spoločné hodnotenie eGFR a pomeru albumínu ku kreatinínu v moči; liečba potom vrství terapie podľa typu diabetu, albuminúrie, funkcie obličiek, kardiovaskulárneho rizika a bezpečnosti.</em></p>

<p>Moderná liečba CKD pri diabete už nie je iba otázkou glykemickej kontroly a inhibície systému renín-angiotenzín (RAS). Pri diabete 2. typu pribudli inhibítory sodíkovo-glukózového kotransportéra 2 (SGLT2), nesteroidný antagonista mineralokortikoidového receptora finerenón a agonisty receptora pre glukagónu podobný peptid 1 (GLP-1). Ich účinky sa čiastočne dopĺňajú, nemožno ich však mechanicky predpísať každému pacientovi ani zameniť dôkaz o znížení albuminúrie za dôkaz dlhodobej prevencie zlyhania obličiek.</p>

<p>Východiskom článku je vzdelávací program <em>The Hidden Threat: Transforming CKD Care Across the Diabetes Spectrum</em>. Keďže bol sprístupnený ešte pred zverejnením výsledkov FINE-ONE a vznikol s podporou spoločnosti vyrábajúcej finerenón, jeho tvrdenia sú tu konfrontované s odporúčaniami ADA 2026, platnými usmerneniami KDIGO, primárnymi randomizovanými štúdiami a aktuálnou európskou registráciou.</p>

<h2>CKD pri diabete zostáva často nerozpoznaná</h2>

<p>ADA 2026 uvádza, že CKD sa vyskytuje približne u 20 až 40 % ľudí s diabetom. Presný podiel závisí od typu a trvania diabetu, veku, definície CKD a skúmanej populácie. Riziko nespočíva iba v progresii k zlyhaniu obličiek. CKD výrazne zvyšuje aj pravdepodobnosť aterosklerotických príhod, srdcového zlyhávania, akútneho poškodenia obličiek, hypoglykémie pri poklese eGFR, liekovej toxicity a predčasného úmrtia.</p>

<p>CKD je definovaná abnormalitou štruktúry alebo funkcie obličiek, ktorá trvá najmenej tri mesiace a má význam pre zdravie. Pri eGFR 60 ml/min/1,73 m² alebo vyššej preto diagnóza vyžaduje iný pretrvávajúci marker poškodenia obličiek, napríklad albuminúriu. Naopak, eGFR nižšia ako 60 ml/min/1,73 m² môže CKD definovať aj bez zvýšenej albuminúrie, ak je nález chronický.</p>

<h2>Skríning znamená eGFR aj UACR</h2>

<p>Jednoduchý skríning pozostáva z dvoch vyšetrení:</p>

<ol>
  <li><strong>sérový kreatinín s výpočtom eGFR,</strong></li>
  <li><strong>pomer albumínu ku kreatinínu v jednorazovej vzorke moču (UACR).</strong></li>
</ol>

<p>Podľa ADA 2026 sa majú eGFR a UACR vyšetriť najmenej raz ročne u všetkých ľudí s diabetom 2. typu bez ohľadu na liečbu a u ľudí s diabetom 1. typu po najmenej piatich rokoch trvania ochorenia. Pri už potvrdenej CKD sa frekvencia zvyšuje približne na jeden až štyri razy ročne podľa kombinácie kategórie eGFR, albuminúrie, rýchlosti progresie, komorbidít a toho, či výsledok môže zmeniť manažment.</p>

<p>UACR sa zvyčajne hodnotí v kategóriách:</p>

<ul>
  <li><strong>A1:</strong> menej ako 3 mg/mmol, teda menej ako 30 mg/g,</li>
  <li><strong>A2:</strong> 3 až 30 mg/mmol, teda 30 až 300 mg/g,</li>
  <li><strong>A3:</strong> viac ako 30 mg/mmol, teda viac ako 300 mg/g.</li>
</ul>

<p>Albuminúria má významnú biologickú variabilitu. Zvýšiť ju môžu intenzívna fyzická námaha, infekcia, horúčka, dekompenzované srdcové zlyhávanie, výrazná hyperglykémia alebo hypertenzia a menštruačná kontaminácia. Pri neprítomnosti urgentného klinického dôvodu sa stredne alebo výrazne zvýšená albuminúria potvrdzuje aspoň dvoma abnormálnymi výsledkami z troch vzoriek odobratých počas troch až šiestich mesiacov. Preferovaná je prvá ranná stredná vzorka moču, hoci náhodná jednorazová vzorka je v praxi prijateľná.</p>

<div class="pdf-avoid-break">
<h2>Nie každá CKD u človeka s diabetom je diabetická nefropatia</h2>

<p>Diabetes nevylučuje glomerulonefritídu, paraproteínové ochorenie, obštrukciu, liekové poškodenie ani inú renálnu diagnózu. Bez histologického dôkazu je často presnejšie hovoriť o <strong>CKD u človeka s diabetom</strong> alebo o predpokladanej diabetickej chorobe obličiek, nie o definitívne dokázanej diabetickej nefropatii.</p>
</div>

<p>Alternatívnu alebo kombinovanú príčinu treba cielene hľadať najmä pri:</p>

<ul>
  <li>aktívnom močovom sedimente, makroskopickej hematúrii alebo bunkových valcoch,</li>
  <li>rýchlo narastajúcej albuminúrii či celkovej proteinúrii,</li>
  <li>nefrotickom syndróme,</li>
  <li>rýchlom alebo nevysvetlenom poklese eGFR,</li>
  <li>diabete 1. typu trvajúcom menej ako päť rokov alebo pri chýbajúcej diabetickej retinopatii, najmä ak sú prítomné aj ďalšie atypické znaky,</li>
  <li>systémových prejavoch, monoklonálnom proteíne alebo morfologickej abnormalite obličiek.</li>
</ul>

<p>Nefrologická konzultácia je potrebná aj pri neistej etiológii, ťažko zvládnuteľnej hypertenzii, elektrolytových poruchách, progresívnom raste UACR, rýchlom poklese eGFR alebo pri eGFR nižšej ako 30 ml/min/1,73 m². Podľa klinickej situácie môže nasledovať imunologická, hematologická, zobrazovacia, genetická alebo histologická diagnostika.</p>

<h2>Základ liečby nie je iba farmakologický</h2>

<p>Vrstvená liečba stojí na kontrole krvného tlaku a glykémie, primeranej fyzickej aktivite, individualizovanej výžive, liečbe dyslipidémie, podpore ukončenia fajčenia, očkovaní, prevencii akútneho poškodenia obličiek a revízii nefrotoxických či nevhodne dávkovaných liekov. Glykemický cieľ sa musí prispôsobiť veku, komorbiditám, riziku hypoglykémie a funkcii obličiek.</p>

<p>ADA 2026 odporúča u väčšiny ľudí s diabetom a CKD tlak nižší ako 130/80 mmHg; nižší systolický cieľ možno zvážiť pri vysokom kardiovaskulárnom alebo renálnom riziku, iba ak sa tlak meria štandardizovane a pacient liečbu toleruje. Krehkosť, ortostatická hypotenzia a riziko pádov môžu viesť k menej intenzívnemu cieľu.</p>

<h2>Blokáda RAS: správna indikácia a správne monitorovanie</h2>

<p>Inhibítor ACE alebo blokátor receptorov AT1 pre angiotenzín II (ARB, sartan) je základom liečby najmä pri súčasnej hypertenzii a albuminúrii. Dávka sa titruje na najvyššiu tolerovanú úroveň. Kombinácia inhibítora ACE s ARB sa nepoužíva, pretože zvyšuje riziko hypotenzie, hyperkaliémie a akútneho poškodenia obličiek bez primeraného klinického prínosu.</p>

<p>Po začatí alebo zvýšení dávky sa má spravidla do dvoch až štyroch týždňov skontrolovať kreatinín, eGFR a draslík, pri vyššom riziku aj skôr. Vzostup kreatinínu do 30 % bez známok hypovolémie nie je automatickým dôvodom na vysadenie. Väčší alebo progresívny nárast vyžaduje zhodnotenie objemového stavu, diuretík, nesteroidových antiflogistík, interkurentného ochorenia a renovaskulárnej príčiny. RAS blokáda sa nepodáva ako primárna prevencia CKD človeku s normálnym tlakom, normálnym UACR a normálnou eGFR.</p>

<h2>Inhibítory SGLT2 chránia obličky aj mimo glykemického účinku</h2>

<p>Pri diabete 2. typu a CKD ADA 2026 odporúča inhibítor SGLT2 s preukázaným prínosom začať pri eGFR najmenej 20 ml/min/1,73 m². Indikácia nie je viazaná na nedostatočne kontrolovaný HbA1c; glykemický účinok pri nižšej eGFR slabne, kardiorenálny prínos však pretrváva. Ak je liek tolerovaný, možno v ňom pokračovať aj po poklese eGFR pod iniciačný prah až do zlyhania obličiek, podľa konkrétnej registrácie a klinickej situácie.</p>

<p>Malý skorý pokles eGFR po začatí býva hemodynamický a reverzibilný. Sám osebe zvyčajne neznamená AKI. Treba však posúdiť hypovolémiu, tlak a dávku diuretika. Pacienta treba poučiť o genitálnych mykotických infekciách a o príznakoch ketoacidózy, ktorá môže vzniknúť aj bez výraznej hyperglykémie. Počas kritického ochorenia, dlhšieho hladovania a pred plánovanou operáciou sa inhibítor SGLT2 dočasne prerušuje podľa konkrétneho perioperačného alebo akútneho protokolu a musí existovať aj plán jeho opätovného nasadenia.</p>

<p>Pri diabete 1. typu inhibítory SGLT2 nie sú štandardnou nefroprotektívnou liečbou. Riziko diabetickej ketoacidózy je v tejto populácii podstatne vyššie a výsledky štúdií pri diabete 2. typu nemožno automaticky prenášať.</p>

<h2>Finerenón cieli na reziduálne albuminurické riziko</h2>

<p>Finerenón je nesteroidný selektívny antagonista mineralokortikoidového receptora. FIDELIO-DKD a FIGARO-DKD preukázali pri diabete 2. typu a albuminurickej CKD zníženie obličkových a kardiovaskulárnych príhod na pozadí maximálne tolerovanej RAS blokády. ADA 2026 ho odporúča u vhodných ľudí s CKD a albuminúriou pri eGFR najmenej 25 ml/min/1,73 m².</p>

<p>Pred začatím treba poznať eGFR a sérový draslík. Kontrola sa vykonáva približne po štyroch týždňoch od začatia alebo zmeny dávky a následne periodicky podľa rizika. Hlavným limitom je hyperkaliémia. Presné iniciačné prahy, dávkovanie, interakcie a postup pri zvýšení draslíka sa musia riadiť aktuálnym súhrnom charakteristických vlastností lieku. Finerenón nie je univerzálnou náhradou spironolaktónu ani dôvodom ignorovať inú príčinu hyperaldosteronizmu či srdcového zlyhávania.</p>

<h2>Agonisty receptora GLP-1 po štúdii FLOW</h2>

<p>ADA 2026 odporúča pri diabete 2. typu a CKD agonistu receptora GLP-1 s preukázaným prínosom na zníženie progresie CKD a kardiovaskulárneho rizika. Najpevnejší dedikovaný obličkový dôkaz má zatiaľ subkutánny semaglutid zo štúdie FLOW. U 3 533 pacientov s diabetom 2. typu a CKD znížil riziko primárneho kompozitného výsledku závažných obličkových príhod alebo úmrtia z obličkových či kardiovaskulárnych príčin o 24 % oproti placebu. Riziko obličkovo špecifického kompozitného výsledku bez kardiovaskulárneho úmrtia bolo nižšie o 21 %.</p>

<p>Tento výsledok neznamená automatický triedový účinok rovnakej veľkosti ani to, že semaglutid nahrádza inhibítor SGLT2, finerenón alebo indikovanú RAS blokádu. Výber lieku ovplyvňuje obezita, aterosklerotické riziko, glykémia, eGFR, krehkosť, gastrointestinálna tolerancia a dostupnosť. Pri nauzee, vracaní alebo hnačke hrozí dehydratácia a prerenálne akútne poškodenie obličiek, osobitne pri súčasnom diuretiku, RAS blokáde alebo inhibítore SGLT2.</p>

<h2>CONFIDENCE podporuje súbežné začatie, nie automatickú štvorliečbu</h2>

<p>Štúdia CONFIDENCE randomizovala 818 pacientov s diabetom 2. typu, eGFR 30 až 90 ml/min/1,73 m² a UACR 100 až menej ako 5 000 mg/g, ktorí už dostávali RAS blokádu. Po 180 dňoch klesol UACR pri súbežnom začatí finerenónu a empagliflozínu o 52 %. Redukcia bola o 29 % väčšia než pri samotnom finerenóne a o 32 % väčšia než pri samotnom empagliflozíne.</p>

<p>Primárnym výsledkom bola albuminúria, nie zlyhanie obličiek, infarkt, hospitalizácia pre srdcové zlyhávanie alebo úmrtie. Šesťmesačné sledovanie preto nepreukazuje dlhodobú klinickú nadradenosť kombinácie. Na základe týchto údajov ADA 2026 uvádza, že súbežné začatie inhibítora SGLT2 a finerenónu <strong>možno zvážiť</strong> u dospelých s diabetom 2. typu, UACR najmenej 100 mg/g, eGFR 30 až 90 ml/min/1,73 m² a liečbou inhibítorom RAS. Ide o odporúčanie úrovne B, nie o povinný postup pre každého pacienta.</p>

<p>Súbežné začatie môže byť rozumné pri vysokom reziduálnom riziku a spoľahlivom následnom monitorovaní. Rýchle sekvenčné nasadenie je často prehľadnejšie pri nízkom tlaku, hraničnej kaliémii, nestabilnej eGFR, hypovolémii, krehkosti alebo rozsiahlej polyfarmácii. Podstatné je neodkladať účinnú liečbu celé mesiace bez klinického dôvodu.</p>

<h2>FINE-ONE už má výsledky, ale nie tvrdé klinické ukazovatele</h2>

<p>Východiskový vzdelávací program opisoval FINE-ONE ako takmer dokončenú štúdiu. To už nie je aktuálne. Výsledky štúdie 3. fázy boli publikované v marci 2026. Randomizovaných bolo 242 dospelých s diabetom 1. typu, eGFR 25 až menej ako 90 ml/min/1,73 m² a UACR 200 až menej ako 5 000 mg/g, ktorí dostávali inhibítor ACE alebo ARB.</p>

<p>Za šesť mesiacov sa UACR znížil o 34 % pri finerenóne a o 12 % pri placebe; relatívny pokles bol pri finerenóne o 25 % väčší. Hyperkaliémia sa vyskytla u 10,1 % účastníkov s finerenónom a u 3,3 % s placebom, pričom 1,7 % účastníkov finerenón pre hyperkaliémiu vysadilo. Počas liečby bol pokles eGFR väčší pri finerenóne, po vymývacom období sa hodnoty približovali k východiskovým hodnotám.</p>

<p>FINE-ONE preukázala účinok na albuminúriu a poskytla krátkodobé bezpečnostné údaje. Nebola navrhnutá na dôkaz prevencie zlyhania obličiek, kardiovaskulárnych príhod alebo mortality. Európska lieková agentúra na aktuálnej stránke lieku uvádza CKD indikáciu finerenónu pre dospelých s diabetom 2. typu a albuminúriou, nie pre diabetes 1. typu. Výsledok FINE-ONE je preto významným krokom, ale nie dôvodom prezentovať finerenón ako už schválený štandard liečby CKD pri diabete 1. typu v Európskej únii.</p>

<h2>Praktický postup v ambulancii</h2>

<ol>
  <li><strong>Vyšetriť eGFR aj UACR:</strong> pri diabete 2. typu od diagnózy, pri diabete 1. typu po piatich rokoch trvania, najmenej raz ročne.</li>
  <li><strong>Potvrdiť chronicitu:</strong> odlíšiť prechodnú albuminúriu, AKI a laboratórnu variabilitu od CKD.</li>
  <li><strong>Určiť fenotyp a riziko:</strong> kategórie G a A, trend eGFR, krvný tlak, srdcové zlyhávanie, aterosklerotické ochorenie, obezita a riziko hypoglykémie.</li>
  <li><strong>Hľadať atypické znaky:</strong> aktívny sediment, nefrotický syndróm, rýchly pokles eGFR alebo neobvyklý časový priebeh vyžadujú inú diagnostiku.</li>
  <li><strong>Optimalizovať základ:</strong> režimové opatrenia, tlak, glykémiu, lipidy, fajčenie, nefrotoxické lieky a indikovanú RAS blokádu.</li>
  <li><strong>Pri diabete 2. typu vrstviť liečbu:</strong> inhibítor SGLT2, finerenón a agonistu receptora GLP-1 vyberať podľa eGFR, UACR, komorbidít, tolerancie a schválenej indikácie.</li>
  <li><strong>Naplánovať laboratórne kontroly:</strong> draslík, kreatinín, eGFR, UACR, tlak a objemový stav kontrolovať v intervale zodpovedajúcom použitej liečbe a riziku.</li>
  <li><strong>Dať písomný plán pre akútne ochorenie:</strong> určiť, ktoré lieky a za akých okolností dočasne prerušiť, kedy vyhľadať pomoc a kedy liečbu bezpečne obnoviť.</li>
</ol>

<h2>Najčastejšie chyby v praxi</h2>

<ul>
  <li>vyšetrovanie iba kreatinínu bez UACR,</li>
  <li>stanovenie CKD alebo perzistujúcej albuminúrie z jediného výsledku bez posúdenia chronicity,</li>
  <li>automatické pripísanie každej CKD diabetu,</li>
  <li>vysadenie RAS blokády alebo inhibítora SGLT2 pre očakávanú miernu hemodynamickú zmenu eGFR bez posúdenia klinického kontextu,</li>
  <li>nasadenie viacerých liekov bez vopred určených kontrol draslíka, funkcie obličiek, tlaku a objemového stavu,</li>
  <li>zamieňanie poklesu UACR za definitívny dôkaz redukcie dlhodobých klinických príhod,</li>
  <li>prenášanie dôkazov z diabetu 2. typu na diabetes 1. typu alebo mimo schválenej indikácie bez jasného označenia neistoty.</li>
</ul>

<h2>Ako čítať východiskový vzdelávací program</h2>

<p>Program Global Cardiology Academy/ReachMD prehľadne zdôrazňuje potrebu spoločného vyšetrovania eGFR a UACR a rýchlejšej implementácie dokázanej liečby. Nie je však systematickým odporúčaním. Aktivita bola podporená nezávislým vzdelávacím grantom spoločnosti Bayer AG a všetci traja odborní prednášajúci deklarovali finančné vzťahy s viacerými farmaceutickými spoločnosťami vrátane Bayeru. Samotná stránka uvádza, že tieto vzťahy boli identifikované a zmiernené podľa pravidiel akreditácie.</p>

<p>Financovanie ani konflikty záujmov automaticky neznehodnocujú odborný obsah, vyžadujú však transparentnosť a kontrolu proti nezávislým usmerneniam a primárnym štúdiám. Osobitne dôležité je, že program zachytáva stav pred publikovaním FINE-ONE. Tento článok je preto aktualizovanou odbornou syntézou, nie prepisom programu.</p>

<h2>Záver</h2>

<p>Najväčšou rezervou v starostlivosti o CKD pri diabete zostáva neskorý záchyt a chýbajúce vyšetrenie albuminúrie. eGFR a UACR treba hodnotiť spoločne, abnormálny nález potvrdiť v čase a pri atypickom priebehu aktívne hľadať inú alebo pridruženú renálnu diagnózu.</p>

<div class="pdf-avoid-break">
<p>Pri diabete 2. typu sa kardiorenálna liečba vrství z optimalizácie rizikových faktorov, indikovaných inhibítorov RAS, inhibítora SGLT2, finerenónu a agonistu receptora GLP-1. Poradie a tempo určujú fenotyp, absolútne riziko a bezpečnosť. CONFIDENCE podporuje súbežné začatie finerenónu a empagliflozínu vo vymedzenej populácii, no zatiaľ najmä na základe albuminúrie. FINE-ONE priniesla sľubné údaje pri diabete 1. typu, ale nepreukázala dlhodobé klinické výsledky a európska CKD indikácia finerenónu zostáva viazaná na diabetes 2. typu.</p>
</div>

<div class="pdf-avoid-break">
<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba chronickej choroby obličiek v roku 2026</a> - širší rámec vrstvenej nefroprotekcie a sledovania po AKI.</li>
  <li><a href="article.php?slug=semaglutid-ckd-porovnanie-glp1-realna-prax">Semaglutid a riziko CKD pri diabete 2. typu</a> - porovnanie agonistov receptora GLP-1 v reálnej praxi.</li>
  <li><a href="article.php?slug=kazuistika-hyperkaliemia-ckd-hf-zachovanie-raas">Hyperkaliémia pri CKD a srdcovom zlyhávaní</a> - ako zachovať prognosticky účinnú liečbu.</li>
</ul>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Fioretto P, Rossing P, Heerspink HJL.</strong> <em>The Hidden Threat: Transforming CKD Care Across the Diabetes Spectrum.</em> Global Cardiology Academy, ReachMD a Medcon International. Vzdelávací program sprístupnený v novembri 2025. Aktivita bola podporená nezávislým vzdelávacím grantom spoločnosti Bayer AG. <a href="https://globalcardiologyacademy.org/programs/cme/the-hidden-threat-transforming-ckd-care-across-the-diabetes-spectrum/36523/" target="_blank" rel="noopener noreferrer">Program, prepis a zverejnené konflikty záujmov</a>.</li>
  <li><strong>American Diabetes Association Professional Practice Committee for Diabetes.</strong> <em>11. Chronic Kidney Disease and Risk Management: Standards of Care in Diabetes-2026.</em> Diabetes Care. 2026;49(Suppl 1):S246-S260. doi: 10.2337/dc26-S011. <a href="https://doi.org/10.2337/dc26-S011" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
</ol>
</div>

<ol start="3">
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(Suppl 4S):S117-S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plný text odporúčania</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes Diabetes Work Group.</strong> <em>KDIGO 2022 Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease.</em> Kidney International. 2022;102(Suppl 5):S1-S127. doi: 10.1016/j.kint.2022.06.008. <a href="https://kdigo.org/wp-content/uploads/2022/10/KDIGO-2022-Clinical-Practice-Guideline-for-Diabetes-Management-in-CKD.pdf" target="_blank" rel="noopener noreferrer">Plný text odporúčania</a>.</li>
  <li><strong>Perkovic V, Tuttle KR, Rossing P, et al.</strong> <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes.</em> New England Journal of Medicine. 2024;391:109-121. doi: 10.1056/NEJMoa2403347. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">FLOW</a>.</li>
  <li><strong>Agarwal R, Green JB, Heerspink HJL, et al.</strong> <em>Finerenone with Empagliflozin in Chronic Kidney Disease and Type 2 Diabetes.</em> New England Journal of Medicine. 2025;393:533-543. doi: 10.1056/NEJMoa2410659. <a href="https://doi.org/10.1056/NEJMoa2410659" target="_blank" rel="noopener noreferrer">CONFIDENCE</a>.</li>
  <li><strong>Heerspink HJL, Birkenfeld AL, Cherney DZI, et al.</strong> <em>Finerenone in Type 1 Diabetes and Chronic Kidney Disease.</em> New England Journal of Medicine. 2026;394:947-957. doi: 10.1056/NEJMoa2512854. <a href="https://doi.org/10.1056/NEJMoa2512854" target="_blank" rel="noopener noreferrer">FINE-ONE</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Kerendia (finerenone): European public assessment report and product information.</em> Stránka aktualizovaná 7. mája 2026. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/kerendia" target="_blank" rel="noopener noreferrer">Aktuálna európska indikácia</a>.</li>
</ol>

<p><em><strong>Poznámka k aktuálnosti:</strong> Text odráža dôkazy a regulačný stav overený 14. augusta 2026. Dostupnosť, úhrada, kontraindikácie, dávkovanie a monitorovanie liekov sa musia pred klinickým použitím overiť v aktuálnom európskom a slovenskom súhrne charakteristických vlastností lieku. Návrh aktualizácie KDIGO pre diabetes a CKD z roku 2026 bol v čase kontroly dokumentom na verejné pripomienkovanie, nie konečným usmernením.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba_article',
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
