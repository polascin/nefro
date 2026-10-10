<?php
/**
 * add_anca-vaskulitida-renalne-postihnutie-standardy-liecby-2026_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie odborného článku: ANCA-asociovaná vaskulitída s renálnym postihnutím
 * — štandardy diagnostiky a liečby v roku 2026 po zrušení registrácie avacopanu.
 * Autor projektu: MUDr. Ľubomír Polaščín. Ide o odborné zhrnutie viacerých
 * odporúčaní a primárnych štúdií (KDIGO 2024, EULAR 2022, PEXIVAS, RAVE, LoVAS,
 * RITAZAREM, MIRRA, MANDARA), nie o preklad jedného zdrojového článku —
 * preto sa do source_authors.php nedopĺňajú pôvodní autori.
 * Postup: git commit (SFTP deploy) → spustenie cez SSH (php …/add_…php).
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
    'title'        => 'ANCA-asociovaná vaskulitída s postihnutím obličiek: čo zo štandardov liečby platí v roku 2026',
    'slug'         => 'anca-vaskulitida-renalne-postihnutie-standardy-liecby-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Po stiahnutí štúdie ADVOCATE a zrušení európskej registrácie avacopanu ostáva pri ANCA-asociovanej vaskulitíde s renálnym postihnutím jediná indukčná vetva: glukokortikoidy s rituximabom alebo cyklofosfamidom. Prehľad odporúčaní KDIGO 2024 a EULAR 2022 vrátane redukovaného zostupu steroidov podľa PEXIVAS-u a vrstvenej indikácie plazmaferézy.',
    'content'      => <<<'HTML'
<figure><a href="img/anca-vaskulitida-renalne-postihnutie.webp" rel="noopener noreferrer" target="_blank"><img src="img/anca-vaskulitida-renalne-postihnutie.webp" alt="Glomerulus zovretý polmesiacovitou zápalovou léziou, okolo obrys presýpacích hodín ako symbol ubiehajúceho času" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna, nie histologický preparát konkrétneho pacienta. Pri ANCA-asociovanej vaskulitíde s renálnym postihnutím rozhoduje čas: kým sa polmesiace stanú fibróznymi, funkcia obličiek je nenávratne stratená.</figcaption></figure>

<p><strong>ANCA-asociované vaskulitídy (AAV)</strong> sú systémové nekrotizujúce vaskulitídy malých ciev spojené s protilátkami proti cytoplazme neutrofilov. Patria k najčastejším príčinám <strong>rýchlo progredujúcej glomerulonefritídy (RPGN)</strong> a k tým málo nefrologickým diagnózam, pri ktorých niekoľko dní oneskorenia rozhoduje o tom, či pacient zostane bez dialýzy.</p>

<p>Posledné roky priniesli dve protichodné správy. Na jednej strane sa ukázalo, že <strong>expozíciu glukokortikoidom možno bezpečne výrazne znížiť</strong>. Na druhej strane liek, ktorý mal byť pilierom tejto stratégie, <strong>avacopan</strong>, v roku 2026 prišiel v Európskej únii o registráciu po tom, ako bola jeho kľúčová štúdia stiahnutá. Ďalej preto zhŕňame, čo z odporúčaní <strong>KDIGO 2024</strong> a <strong>EULAR 2022</strong> po tejto zmene v praxi zostáva a ako dnes vyzerá obhájiteľný postup u pacienta s AAV a postihnutím obličiek.</p>

<h2>Čo sa zmenilo: avacopan už v Európe nie je možnosťou</h2>

<p>Odporúčania EULAR aj KDIGO boli formulované v čase, keď bol avacopan (Tavneos) registrovaný ako prostriedok na zníženie expozície glukokortikoidom pri <strong>granulomatóze s polyangiitídou (GPA)</strong> a <strong>mikroskopickej polyangiitíde (MPA)</strong>. Táto premisa už neplatí:</p>

<ul>
  <li><strong>29. júna 2026</strong> časopis <em>New England Journal of Medicine</em> <strong>stiahol (retrahoval)</strong> registračnú štúdiu ADVOCATE. Podľa redakčného oznámenia obaja akademickí autori o stiahnutie požiadali sami, keď sa v rámci prebiehajúceho vyšetrovania FDA ukázalo, že u <strong>deviatich pacientov</strong> bolo hodnotenie primárneho cieľového ukazovateľa <strong>opätovne adjudikované až po uzamknutí databázy a po odslepení štúdie</strong> – bez ich vedomia a bez uvedenia v článku.</li>
  <li><strong>26. júna 2026</strong> výbor CHMP odporučil zrušiť európsku registráciu; <strong>rozhodnutím Európskej komisie zo 4. augusta 2026</strong> bola registrácia Tavneosu v EÚ a EHP <strong>zrušená</strong>.</li>
  <li>V USA navrhlo centrum CDER zrušenie schválenia už v apríli 2026; výrobca požiadal o vypočutie, takže americká situácia zostáva otvorená. Pre slovenskú prax je však rozhodujúce európske rozhodnutie: <strong>avacopan tu už nie je liečebnou možnosťou</strong>.</li>
</ul>

<p>Prakticky to znamená, že všade, kde odporúčania ponúkali vetvu „glukokortikoidy <em>alebo</em> avacopan“, ostáva dnes v Európe <strong>len jedna vetva</strong>. O to dôležitejšie je, že dôkazový základ pre <em>redukované</em> dávkovanie glukokortikoidov pochádza z celkom iných, nespochybnených štúdií. Podrobnejšie k regulačnej stránke pozri samostatný článok <a href="article.php?slug=ema-zrusenie-povolenia-tavneos-avacopan-anca-vaskulitida">o zrušení povolenia pre Tavneos</a>.</p>

<h2>Diagnostika: biopsia áno, ale nesmie zdržať liečbu</h2>

<p>EULAR aj KDIGO stavajú diagnostiku na kombinácii <strong>sérológie ANCA</strong> (anti-MPO, anti-PR3) a <strong>histológie</strong>. Biopsia obličky má hodnotu nielen diagnostickú, ale aj prognostickú – podiel normálnych, sklerotických a polmesiacových glomerulov určuje, koľko funkcie sa dá reálne zachrániť.</p>

<p>Podstatná je však poznámka KDIGO k načasovaniu: ak klinický obraz zodpovedá vaskulitíde malých ciev a sérológia MPO- alebo PR3-ANCA je pozitívna, <strong>čakanie na vykonanie alebo na výsledok biopsie nemá oddialiť začatie imunosupresívnej liečby</strong>, najmä u rýchlo sa zhoršujúceho pacienta. KDIGO zároveň uvádza, že pacienti s AAV majú byť liečení v centrách so skúsenosťou s týmto ochorením – teda tam, kde je naraz dostupná rýchla sérológia a histológia, rituximab, plazmaferéza, jednotka intenzívnej starostlivosti aj akútna hemodialýza.</p>

<h2>Indukcia remisie: glukokortikoidy plus rituximab alebo cyklofosfamid</h2>

<p>Pri orgán ohrozujúcej alebo život ohrozujúcej AAV zostáva základom <strong>kombinácia glukokortikoidov s rituximabom alebo s cyklofosfamidom</strong> (KDIGO odporúčanie 9.3.1.1, stupeň 1B; zhodne EULAR 2022). Rovnocennosť oboch ramien vychádza zo štúdie <strong>RAVE</strong>, kde rituximab splnil kritérium non-inferiority voči cyklofosfamidu (64 % vs. 53 % remisií bez prednizónu v 6. mesiaci) a pri <strong>relabujúcom</strong> ochorení bol dokonca lepší (67 % vs. 42 %).</p>

<div class="table-responsive" role="region" aria-label="Kedy uprednostniť rituximab a kedy cyklofosfamid" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Faktor</th><th scope="col">Uprednostniť</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Deti a dospievajúci</th><td>Rituximab</td></tr>
    <tr><th scope="row">Ženy pred menopauzou a muži, pre ktorých je dôležitá fertilita</th><td>Rituximab</td></tr>
    <tr><th scope="row">Krehkí starší pacienti</th><td>Rituximab</td></tr>
    <tr><th scope="row">Relabujúce ochorenie, PR3-ANCA fenotyp</th><td>Rituximab</td></tr>
    <tr><th scope="row">Keď je šetrenie glukokortikoidmi obzvlášť dôležité</th><td>Rituximab</td></tr>
    <tr><th scope="row">Obmedzená dostupnosť rituximabu</th><td>Cyklofosfamid</td></tr>
    <tr><th scope="row">Ťažká glomerulonefritída (S-kreatinín &gt; 354 µmol/l)</th><td>Cyklofosfamid, prípadne kombinácia dvoch i.v. pulzov cyklofosfamidu s rituximabom</td></tr>
  </tbody>
</table>
<p><em>Podľa KDIGO 2024, obrázok 7. Faktorom proti cyklofosfamidu je už podaná stredne vysoká kumulatívna dávka v minulosti.</em></p>
</div>

<p>Pre nefrológa je podstatná praktická poznámka KDIGO 9.3.1.2: pri <strong>výrazne zníženej alebo rýchlo klesajúcej glomerulovej filtrácii (S-kreatinín &gt; 354 µmol/l)</strong> je dôkazový základ pre samotný rituximab s glukokortikoidmi <strong>obmedzený</strong> – práve títo pacienti boli v registračných štúdiách zastúpení najmenej. Do úvahy prichádza cyklofosfamid s glukokortikoidmi alebo kombinácia rituximabu s cyklofosfamidom.</p>

<p>Dávkovanie cyklofosfamidu podľa KDIGO: perorálne <strong>2 mg/kg/deň</strong> počas 3 mesiacov (pri pretrvávajúcej aktivite maximálne 6 mesiacov), so znížením <strong>na 1,5 mg/kg/deň nad 60 rokov</strong> a <strong>na 1,0 mg/kg/deň nad 70 rokov</strong>, plus ďalšie zníženie o 0,5 mg/kg/deň pri GFR &lt; 30 ml/min/1,73 m². Intravenózna schéma je <strong>15 mg/kg v týždňoch 0, 2, 4, 7, 10</strong> a ďalej. Perorálna cesta sa uprednostní tam, kde je prístup do infúzneho centra ťažký a adherencia nie je problémom; intravenózna tam, kde je nižší počet leukocytov, kde môže byť adherencia problémom alebo kde je dôležitá nižšia kumulatívna dávka.</p>

<h2>Glukokortikoidy: rýchly zostup je dnes štandardom</h2>

<p>Najdôležitejšia praktická zmena posledných rokov sa netýka biologík, ale <strong>dávkovania glukokortikoidov</strong>. Štúdia <strong>PEXIVAS</strong> (704 pacientov s ťažkou AAV, teda s eGFR &lt; 50 ml/min/1,73 m² alebo s difúznym alveolárnym krvácaním) ukázala, že <strong>redukovaný režim perorálnych glukokortikoidov je non-inferiórny</strong> voči štandardnému: úmrtie z akejkoľvek príčiny alebo zlyhanie obličiek nastalo u 27,9 % vs. 25,5 % pacientov (absolútny rozdiel 2,3 percentuálneho bodu; 90 % IS −3,4 až 8,0, pri hranici non-inferiority 11 bodov). Zároveň bolo v redukovanej vetve <strong>menej závažných infekcií v prvom roku</strong> (pomer incidencií 0,69; 95 % IS 0,52–0,93).</p>

<p>Japonská štúdia <strong>LoVAS</strong> to potvrdila aj pri rituximabovej indukcii: prednizolón 0,5 mg/kg/deň bol non-inferiórny voči 1 mg/kg/deň (remisia v 6. mesiaci 71,0 % vs. 69,2 %), pričom <strong>závažné nežiaduce udalosti nastali u 18,8 % vs. 36,9 %</strong> a závažné infekcie u 7,2 % vs. 20,0 % pacientov. Dôležitá výhrada pre nefrológiu: <strong>LoVAS zámerne vylúčila pacientov s ťažkou glomerulonefritídou a s alveolárnym krvácaním</strong>, takže na najzávažnejších pacientov ju priamo extrapolovať nemožno – pre nich je relevantný PEXIVAS.</p>

<p>KDIGO 2024 preto ako referenčný uvádza <strong>redukovaný režim z PEXIVAS-u</strong> (nadväzuje na úvodné intravenózne pulzy metylprednizolónu podľa zvyklostí pracoviska). EULAR 2022 formuluje ten istý cieľ inak, ale zhodne: znížiť dávku na <strong>približne 5 mg prednizolónového ekvivalentu denne do 4 až 5 mesiacov</strong>.</p>

<div class="table-responsive" role="region" aria-label="Redukovaný režim perorálneho prednizolónu podľa PEXIVAS v mg denne" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Týždeň</th><th scope="col">&lt; 50 kg</th><th scope="col">50–75 kg</th><th scope="col">&gt; 75 kg</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">1</th><td>50</td><td>60</td><td>75</td></tr>
    <tr><th scope="row">2</th><td>25</td><td>30</td><td>40</td></tr>
    <tr><th scope="row">3–4</th><td>20</td><td>25</td><td>30</td></tr>
    <tr><th scope="row">5–6</th><td>15</td><td>20</td><td>25</td></tr>
    <tr><th scope="row">7–8</th><td>12,5</td><td>15</td><td>20</td></tr>
    <tr><th scope="row">9–10</th><td>10</td><td>12,5</td><td>15</td></tr>
    <tr><th scope="row">11–12</th><td>7,5</td><td>10</td><td>12,5</td></tr>
    <tr><th scope="row">13–14</th><td>6</td><td>7,5</td><td>10</td></tr>
    <tr><th scope="row">15–16</th><td>5</td><td>5</td><td>7,5</td></tr>
    <tr><th scope="row">17–18</th><td>5</td><td>5</td><td>7,5</td></tr>
    <tr><th scope="row">19–20</th><td>5</td><td>5</td><td>5</td></tr>
    <tr><th scope="row">21–22</th><td>5</td><td>5</td><td>5</td></tr>
    <tr><th scope="row">23–52</th><td>5</td><td>5</td><td>5</td></tr>
    <tr><th scope="row">&gt; 52</th><td colspan="3">Podľa zvyklostí pracoviska</td></tr>
  </tbody>
</table>
<p><em>Dávky prednizolónu v mg denne podľa redukovaného ramena štúdie PEXIVAS, ako ich preberá KDIGO 2024 (obrázok 9).</em></p>
</div>

<h2>Plazmaferéza: koniec paušálneho používania, nie koniec indikácií</h2>

<p>Pri plazmaferéze (terapeutickej výmene plazmy) sa viac než inde oplatí riadiť pôvodnými údajmi, nie zvykom. <strong>PEXIVAS prínos nepreukázal:</strong> zložený cieľ úmrtia alebo zlyhania obličiek dosiahlo 28,4 % pacientov s plazmaferézou a 31,0 % pacientov bez nej (pomer rizík 0,86; 95 % IS 0,65–1,13; p = 0,27). To ukončilo éru, v ktorej sa plazmaferéza podávala takmer každému pacientovi s ťažkou renálnou vaskulitídou.</p>

<p>Ukončilo ju však <em>iba ako rutinu</em>. Následné systematické prehodnotenie dôkazov v odporúčaní <em>BMJ Rapid Recommendations</em> (2022), vedenom metodikou GRADE, formulovalo <strong>vrstvený prístup podľa rizika zlyhania obličiek</strong>:</p>

<ul>
  <li><strong>nízke až nízko-stredné riziko</strong> vývoja zlyhania obličiek – slabé odporúčanie <strong>proti</strong> plazmaferéze;</li>
  <li><strong>stredne vysoké až vysoké riziko</strong> – slabé odporúčanie <strong>v prospech</strong> plazmaferézy;</li>
  <li><strong>pľúcne krvácanie bez renálneho postihnutia</strong> – panel navrhuje plazmaferézu <strong>nepoužívať</strong>;</li>
  <li>a súčasne <strong>silné</strong> odporúčanie v prospech redukovaného, nie štandardného dávkovania glukokortikoidov.</li>
</ul>

<p>KDIGO 2024 to premieta do konkrétnych spúšťačov (praktický bod 9.3.1.9): <strong>zvážiť plazmaferézu pri S-kreatiníne &gt; 300 µmol/l, u pacientov vyžadujúcich dialýzu alebo s rýchlo stúpajúcim kreatinínom a pri difúznom alveolárnom krvácaní s hypoxémiou</strong>. Odvoláva sa pritom aj na staršiu štúdiu MEPEX, ktorá ukázala lepšie renálne výsledky pri veľmi ťažkom postihnutí (S-kreatinín &gt; 500 µmol/l).</p>

<p>Medzi odporúčaniami je jeden rozdiel, ktorý ľahko unikne: pri <strong>alveolárnom krvácaní</strong> panel <em>BMJ</em> plazmaferézu neodporúča, kým KDIGO ju pri <strong>hypoxémii</strong> zvážiť pripúšťa. Nejde o chybu ani jednej strany – panel <em>BMJ</em> hodnotil pľúcne krvácanie <em>bez</em> renálneho postihnutia, KDIGO cieli na hypoxemických pacientov s vysokou včasnou mortalitou. Pri normoxemickom alveolárnom krvácaní sa obe stanoviská zhodujú, že prognóza je priaznivá a stav ustúpi s kontrolou mimopľúcneho ochorenia.</p>

<p>Samostatnú, jednoznačnejšiu indikáciu tvorí <strong>prekryv AAV s ochorením proti bazálnej membráne glomerulov (anti-GBM)</strong>: tu KDIGO plazmaferézu <strong>pridať odporúča</strong> (praktický bod 9.3.1.10). Dvojitá pozitivita nie je rarita – v citovanej jednocentrovej práci bolo 5 % ANCA-pozitívnych pacientov súčasne anti-GBM pozitívnych a 32 % anti-GBM pozitívnych malo detegovateľné ANCA. Títo pacienti sa správajú skôr ako pacienti s anti-GBM ochorením. <strong>Praktický dôsledok: u každého pacienta s RPGN a pozitívnymi ANCA vyšetri aj anti-GBM protilátky.</strong></p>

<h2>Udržiavacia liečba: rituximab ako prvá voľba, ale nie donekonečna</h2>

<p>KDIGO odporúča po indukcii remisie <strong>udržiavaciu liečbu rituximabom alebo azatioprínom s nízkou dávkou glukokortikoidov</strong> (odporúčanie 9.3.2.1, stupeň 1C); EULAR pri GPA/MPA uprednostňuje rituximab, s azatioprínom a metotrexátom ako alternatívami. Po indukcii rituximabom má udržiavaciu liečbu dostať <strong>väčšina</strong> pacientov.</p>

<p>Oporou je štúdia <strong>RITAZAREM</strong> u pacientov s relabujúcou AAV: opakovane podávaný rituximab bol v prevencii relapsu výrazne lepší než azatioprín (pomer rizík <strong>0,41</strong>; 95 % IS 0,27–0,61; p &lt; 0,001), pričom závažnú nežiaducu udalosť zaznamenalo <strong>22 % vs. 36 %</strong> pacientov. Vyššia účinnosť teda nebola vykúpená horšou bezpečnosťou.</p>

<p>Dve dávkovacie schémy podľa KDIGO:</p>
<ul>
  <li><strong>MAINRITSAN</strong> – 500 mg dvakrát pri dosiahnutí kompletnej remisie, potom 500 mg v 6., 12. a 18. mesiaci;</li>
  <li><strong>RITAZAREM</strong> – 1000 mg po indukcii remisie a ďalej v 4., 8., 12. a 16. mesiaci.</li>
</ul>

<p>Pri neznášanlivosti azatioprínu prichádza do úvahy mykofenolátmofetil alebo metotrexát – <strong>metotrexát sa však nemá použiť pri GFR &lt; 60 ml/min/1,73 m²</strong>, čo z neho v nefrologickej populácii robí skôr výnimku než alternatívu.</p>

<p><strong>Optimálna dĺžka udržiavacej liečby je podľa KDIGO 18 mesiacov až 4 roky</strong> po indukcii remisie. Pri rozhodovaní o vysadení treba vážiť riziko relapsu – vyššie je pri GPA, PR3-ANCA fenotype, vyššom sérovom kreatiníne, rozsiahlejšom ochorení, postihnutí ORL oblasti a pri relapse v anamnéze. Post hoc analýza štúdie RITAZAREM (2026) k tomu pridáva dva ľahko dostupné markery: po ukončení liečby bola s relapsom spojená <strong>prítomnosť CD19+ B-lymfocytov</strong> (pomer šancí 2,5; 95 % IS 1,2–5,1) a <strong>opätovné objavenie sa ANCA</strong> (pomer šancí 3,2; 95 % IS 1,3–7,7). Pacient musí byť poučený, že pri návrate príznakov má prísť <strong>bezodkladne</strong>.</p>

<h2>Špecifické nefrologické situácie</h2>

<ul>
  <li><strong>Pacient trvale na dialýze bez mimorenálnych prejavov.</strong> KDIGO odporúča <strong>zvážiť ukončenie imunosupresie po 3 mesiacoch</strong> (praktický bod 9.3.1.5). Pokračovanie v tejto situácii prináša riziko infekcie bez zodpovedajúceho zisku.</li>
  <li><strong>Refraktérne ochorenie.</strong> Riešením je zvýšenie dávky glukokortikoidov, prechod z cyklofosfamidu na rituximab alebo naopak; plazmaferézu možno zvážiť. Pozor na diferenciálnu diagnostiku: progresia zlyhávania obličiek môže odrážať <strong>chronické poškodenie, nie aktivitu</strong> – opakovaná biopsia je legitímny krok.</li>
  <li><strong>Relaps.</strong> Život alebo orgán ohrozujúci relaps sa lieči <strong>opätovnou indukciou, prednostne rituximabom</strong>.</li>
  <li><strong>Transplantácia obličky.</strong> Odložiť až do <strong>kompletnej klinickej remisie trvajúcej aspoň 6 mesiacov</strong>. <strong>Pretrvávajúca pozitivita ANCA nie je dôvodom na odklad</strong> – recidíva po transplantácii je zriedkavá (rádovo 0,02–0,03 na pacientorok) a nesúvisí s ANCA statusom pred transplantáciou.</li>
</ul>

<h2>EGPA: anti-IL-5 liečba ako samostatná vetva</h2>

<p>Pri <strong>eozinofilnej granulomatóze s polyangiitídou (EGPA)</strong> s relabujúcim alebo refraktérnym priebehom EULAR odporúča <strong>mepolizumab</strong>. Opiera sa o štúdiu <strong>MIRRA</strong>, kde remisiu v 36. aj 48. týždni dosiahlo 32 % pacientov na mepolizumabe oproti 3 % na placebe.</p>

<p>Od publikácie odporúčaní pribudla dôležitá možnosť: v štúdii <strong>MANDARA</strong> bol <strong>benralizumab</strong> (protilátka proti α-podjednotke receptora pre interleukín 5) <strong>non-inferiórny voči mepolizumabu</strong> – remisia v 36. aj 48. týždni u 59 % vs. 56 % pacientov (rozdiel 3 percentuálne body; 95 % IS −13 až 18). V dvojročnom otvorenom predĺžení bolo v remisii 62 % pacientov pokračujúcich na benralizumabe a 68 % tých, ktorí prešli z mepolizumabu, pričom približne 44 % pacientov v oboch skupinách <strong>úplne vysadilo perorálne glukokortikoidy</strong>. Pre pacienta s EGPA je to relevantné práve pre steroid-šetriaci potenciál – treba však pamätať, že renálne postihnutie je pri EGPA menej časté a menej závažné než pri GPA/MPA a pacienti s ťažkou glomerulonefritídou boli v týchto štúdiách zastúpení okrajovo.</p>

<h2>Bezpečnosť a monitorovanie</h2>

<p>Kumulatívna imunosupresia pri AAV je jedna z najvyšších v nefrológii a infekcie sú vedúcou príčinou včasnej mortality – nie samotná vaskulitída. Rámec, ktorý sa v praxi osvedčuje:</p>

<ul>
  <li><strong>Profylaxia pneumocystovej pneumónie</strong> počas indukcie a po celý čas vyššej dávky glukokortikoidov, podľa lokálneho protokolu a funkcie obličiek.</li>
  <li><strong>Krvný obraz</strong> – pri cyklofosfamide zvlášť sledovanie leukopénie; pri rituximabe kontrola <strong>hladín imunoglobulínov</strong> pred opakovaným podaním a pri opakovaných infekciách.</li>
  <li><strong>Skríning hepatitíd B a C a latentnej tuberkulózy</strong> pred začatím biologickej liečby.</li>
  <li><strong>Očkovanie</strong> podľa možnosti pred začatím liečby alebo v období najnižšej imunosupresie; po rituximabe je odpoveď na vakcíny výrazne oslabená.</li>
  <li><strong>Renálne parametre a močový nález</strong> (sediment, pomer albumín/kreatinín) ako nepriame markery aktivity.</li>
  <li><strong>Kumulatívna dávka cyklofosfamidu</strong> – dokumentovať ju, s ohľadom na fertilitu a onkologické riziko.</li>
  <li><strong>Kostné zdravie</strong> – aj pri redukovanom režime ide o mesiace liečby glukokortikoidmi.</li>
</ul>

<h2>Praktický algoritmus pre prvých 72 hodín</h2>

<ol>
  <li><strong>Posúď závažnosť.</strong> Rýchlosť poklesu eGFR, močový sediment, albuminúria, oxygenácia, systémové prejavy.</li>
  <li><strong>Zober sérológiu naraz.</strong> ANCA (MPO aj PR3) <strong>a anti-GBM</strong>, doplň diferenciálnu diagnostiku (komplement, ANA, kryoglobulíny, sérologické vyšetrenia podľa kliniky).</li>
  <li><strong>Naplánuj biopsiu – ale neodkladaj kvôli nej liečbu.</strong> Pri zodpovedajúcom obraze a pozitívnej sérológii začni imunosupresiu okamžite.</li>
  <li><strong>Začni indukciu:</strong> glukokortikoidy plus rituximab alebo cyklofosfamid; pri S-kreatiníne &gt; 354 µmol/l zváž cyklofosfamid alebo kombináciu s rituximabom.</li>
  <li><strong>Nastav zostup glukokortikoidov hneď na začiatku</strong> podľa redukovanej schémy PEXIVAS, s cieľom približne 5 mg denne do 4 až 5 mesiacov. Nenechávaj zostupnú schému „na neskôr“.</li>
  <li><strong>Rozhodni o plazmaferéze podľa rizika:</strong> S-kreatinín &gt; 300 µmol/l, potreba dialýzy alebo rýchlo stúpajúci kreatinín; hypoxemické alveolárne krvácanie; <strong>vždy</strong> pri prekryve s anti-GBM.</li>
  <li><strong>Zabezpeč profylaxiu infekcií</strong> a plán monitorovania ešte pred ukončením akútnej fázy.</li>
  <li><strong>Naplánuj udržiavaciu liečbu</strong> (prednostne rituximab) a povedz pacientovi, na ktoré príznaky relapsu má reagovať okamžite.</li>
</ol>

<h2>Poznámka k dôkazom</h2>

<p>Odporúčania EULAR 2022 aj KDIGO 2024 boli formulované v čase, keď sa štúdia ADVOCATE považovala za platnú. Body týkajúce sa <strong>avacopanu</strong> (EULAR: „môže byť zvážený“; KDIGO praktický bod 9.3.1.7: „môže byť použitý ako alternatíva glukokortikoidov“) preto v tomto článku uvádzame len ako historický kontext – v Európskej únii sú po zrušení registrácie zo 4. augusta 2026 neaplikovateľné. Ostatné časti oboch dokumentov stoja na iných, nespochybnených štúdiách (RAVE, PEXIVAS, LoVAS, MAINRITSAN, RITAZAREM, MEPEX, MIRRA) a zostávajú v platnosti.</p>

<p>Tento článok je odborným zhrnutím publikovaných odporúčaní a primárnych štúdií, nie samostatným systematickým prehľadom. Uvedené číselné údaje pochádzajú z plných textov a abstraktov citovaných prác. Konkrétny postup u konkrétneho pacienta vždy závisí od aktivity ochorenia, komorbidít, dostupnosti liečby a lokálnych protokolov.</p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Floege J, Jayne DRW, Sanders JF, Tesar V, Balk EM, a kol. KDIGO 2024 Clinical Practice Guideline for the Management of Antineutrophil Cytoplasmic Antibody (ANCA)-Associated Vasculitis. <em>Kidney Int</em>. 2024;105(3S):S71–S116. Výkonný súhrn: <em>Kidney Int</em>. 2024;105(3):447–449. <a href="https://doi.org/10.1016/j.kint.2023.10.009" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Hellmich B, Sanchez-Alamo B, Schirmer JH, Berti A, Blockmans D, a kol. EULAR recommendations for the management of ANCA-associated vasculitis: 2022 update. <em>Ann Rheum Dis</em>. 2024;83(1):30–47. <a href="https://doi.org/10.1136/ard-2022-223764" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Walsh M, Merkel PA, Peh CA, Szpirt WM, Puéchal X, a kol. Plasma Exchange and Glucocorticoids in Severe ANCA-Associated Vasculitis (PEXIVAS). <em>N Engl J Med</em>. 2020;382(7):622–631. <a href="https://doi.org/10.1056/NEJMoa1803537" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Zeng L, Walsh M, Guyatt GH, Siemieniuk RAC, a kol. Plasma exchange and glucocorticoid dosing for patients with ANCA-associated vasculitis: a clinical practice guideline. <em>BMJ</em>. 2022;376:e064597. <a href="https://doi.org/10.1136/bmj-2021-064597" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Stone JH, Merkel PA, Spiera R, Seo P, a kol. Rituximab versus cyclophosphamide for ANCA-associated vasculitis (RAVE). <em>N Engl J Med</em>. 2010;363(3):221–232. <a href="https://doi.org/10.1056/NEJMoa0909905" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Furuta S, Nakagomi D, Kobayashi Y, a kol. Effect of Reduced-Dose vs High-Dose Glucocorticoids Added to Rituximab on Remission Induction in ANCA-Associated Vasculitis (LoVAS). <em>JAMA</em>. 2021;325(21):2178–2187. <a href="https://doi.org/10.1001/jama.2021.6615" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Smith RM, Jones RB, Specks U, Bond S, a kol. Rituximab versus azathioprine for maintenance of remission for patients with ANCA-associated vasculitis and relapsing disease (RITAZAREM). <em>Ann Rheum Dis</em>. 2023;82(7):937–944. <a href="https://doi.org/10.1136/ard-2022-223559" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Romich E, Baker JF, Riley TR, a kol. Risk Factors for Relapse in Antineutrophil Cytoplasmic Antibody-Associated Vasculitis Among Patients With Relapse After Induction of Remission With Rituximab. <em>Arthritis Rheumatol</em>. 2026;78(5):1134–1144. <a href="https://doi.org/10.1002/art.70025" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Wechsler ME, Akuthota P, Jayne D, a kol. Mepolizumab or Placebo for Eosinophilic Granulomatosis with Polyangiitis (MIRRA). <em>N Engl J Med</em>. 2017;376(20):1921–1932. <a href="https://doi.org/10.1056/NEJMoa1702079" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Wechsler ME, Nair P, Terrier B, a kol. Benralizumab versus Mepolizumab for Eosinophilic Granulomatosis with Polyangiitis (MANDARA). <em>N Engl J Med</em>. 2024;390(10):911–921. <a href="https://doi.org/10.1056/NEJMoa2311155" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Merkel PA, Nair PK, Khalidi N, Terrier B, a kol. Two-year efficacy and safety of anti-interleukin-5/receptor therapy for eosinophilic granulomatosis with polyangiitis. <em>Ann Rheum Dis</em>. 2025;84(11):1888–1899. <a href="https://doi.org/10.1016/j.ard.2025.06.2131" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Retraction: Jayne DRW et al. Avacopan for the Treatment of ANCA-Associated Vasculitis, N Engl J Med 2021;384:599–609. <em>N Engl J Med</em>. 2026 (29. júna 2026). <a href="https://doi.org/10.1056/NEJMe2608684" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>European Medicines Agency. Tavneos (avacopan) — authorisation revoked (rozhodnutie Európskej komisie zo 4. augusta 2026). <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/tavneos" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</li>
</ol>

<p><em>Bibliografické údaje boli overené cez PubMed a Crossref; abstrakty citovaných prác sú dostupné na <a href="https://pubmed.ncbi.nlm.nih.gov/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Poznámka:</strong> Tento článok má vzdelávací charakter a nenahrádza individuálne klinické rozhodovanie ošetrujúceho tímu, platné súhrny charakteristických vlastností liekov ani aktuálne stanoviská regulačných orgánov.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_anca_vaskulitida_renalne_postihnutie',
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
