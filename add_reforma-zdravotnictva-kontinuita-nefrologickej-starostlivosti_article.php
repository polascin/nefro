<?php

/**
 * add_reforma-zdravotnictva-kontinuita-nefrologickej-starostlivosti_article.php
 * Reforma zdravotnictva a kontinuita nefrologickej starostlivosti.
 * Ramec: DGIM Talk "Die Zukunft der Inneren Medizin - zwischen Reform und
 * Verantwortung" (STREAMED UP, livestream 16. 10. 2026).
 * Vecny obsah: KDIGO 2024, Cochrane prehlad o vcasnom odoslani, Nicoll a spol.
 *
 * Zdroj je programove oznamenie podujatia, nie publikovana praca - do
 * source_authors.php sa preto nic nedoplna (nejde o autorov clanku).
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
    'title'        => 'Reforma a zodpovednosť: čo z debaty o budúcnosti internej medicíny platí pre nefrológiu',
    'slug'         => 'reforma-zdravotnictva-kontinuita-nefrologickej-starostlivosti',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nemecká debata o reforme nemocníc a vzdelávania kladie otázku, kto nesie zodpovednosť, keď sa menia štruktúry. Pre nefrológiu existuje presná odpoveď – a KDIGO ju vyjadruje v číslach, nie v heslách.',
    'content'      => <<<'HTML'
<figure><a href="img/reforma-zdravotnictva-kontinuita-nefrologickej-starostlivosti.webp" rel="noopener noreferrer" target="_blank"><img src="img/reforma-zdravotnictva-kontinuita-nefrologickej-starostlivosti.webp" alt="Tmavá chodba z kamenných oblúkov, z ktorých sú niektoré vychýlené z radu; cez všetky prechádza neprerušená svetlá modrá niť smerujúca k vzdialenej polopriesvitnej obličke" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna – nejde o zobrazenie konkrétneho zariadenia ani systému. Štruktúry sa prestavujú; niť starostlivosti musí prejsť aj cez posunuté oblúky.</figcaption></figure>

<p class="article-dek"><em>Keď sa prestavujú nemocnice, mení financovanie a prepisujú vzdelávacie poriadky, znie otázka takmer vždy rovnako: kto počas prestavby ručí za to, že pacient neprepadne medzi štruktúrami. Pre chronickú chorobu obličiek na to existuje nezvyčajne presná odpoveď. KDIGO ju neformuluje ako hodnotu, ale ako prahy rizika, ktoré určujú, kedy odoslať, kedy zapojiť tím a kedy začať pripravovať náhradu funkcie obličiek.</em></p>

<p>Podnetom pre tento text je odborné podujatie <strong>DGIM Talk</strong> s názvom <em>Die Zukunft der Inneren Medizin – zwischen Reform und Verantwortung</em> (Budúcnosť internej medicíny – medzi reformou a zodpovednosťou), ktoré sa vysiela 16. októbra 2026 na vzdelávacej platforme STREAMED UP.</p>

<p>Hneď na úvod je potrebné povedať, čo tento článok <strong>nie je</strong>. Nie je správou z podujatia ani zhrnutím toho, čo na ňom odznelo. V čase prípravy textu bol k dispozícii program, nie obsah prednášok. Nemecká debata tu preto slúži ako rámec a ako podnet na otázku; odpovede pochádzajú z odporúčaní a publikovaných prehľadov, ktoré sú overiteľné nezávisle od podujatia.</p>

<h2>O čom debata je</h2>

<p>Podujatie trvá 90 minút, je certifikované Lekárskou komorou spolkovej krajiny Hesensko dvoma kreditmi kategórie A a podľa platformy nie je sponzorované. Vedecké vedenie majú Petra-Maria Schumm-Draeger a Dirk Müller-Wieland. Program tvoria tri vystúpenia:</p>

<div class="table-responsive" role="region" aria-label="Program podujatia DGIM Talk o budúcnosti internej medicíny" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Téma</th>
        <th scope="col">Prednášajúci</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Reforma nemocníc: sme stále na ceste k vyššej kvalite, efektívnosti a starostlivosti zameranej na pacienta?</th>
        <td>Michael Hallek, Univerzitná nemocnica Kolín nad Rýnom</td>
      </tr>
      <tr>
        <th scope="row">Zdravotná reforma – stanovisko AWMF a ďalšie kroky</th>
        <td>Manfred Gogol, Lekárska vysoká škola Hannover, predsedníctvo AWMF</td>
      </tr>
      <tr>
        <th scope="row">Ďalšie vzdelávanie v internej medicíne prostredníctvom Spolkovej lekárskej komory: pripravené na budúcnosť a orientované na Európu</th>
        <td>Christina Hillebrecht, členka predstavenstva Spolkovej lekárskej komory, prezidentka Lekárskej komory v Brémach</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Spoločným menovateľom je napätie medzi <strong>reformou</strong>, ktorá mení štruktúry, a <strong>zodpovednosťou</strong>, ktorá zostáva na tom, kto pacienta vedie. Pre nefrológiu je to viac než rétorická figúra.</p>

<h2>Prečo sa nefrológia nemôže spoliehať, že ju reforma obíde</h2>

<p>Chronická choroba obličiek je diagnóza, ktorú systém vidí zle. Prebieha roky bez príznakov, jej manažment je prevažne ambulantný, prínos sa prejaví až s odstupom a najdrahšia fáza – náhrada funkcie obličiek – prichádza na konci. To ju robí zraniteľnou voči každej zmene, ktorá skracuje hospitalizácie, presúva výkony a prerozdeľuje kompetencie medzi pracoviská.</p>

<p>Riziko nie je v tom, že by sa starostlivosť zrušila. Je v tom, že sa <strong>rozpadne na nenaviazané epizódy</strong>: vyšetrenie bez nadväznej kontroly, kontrola bez zmeny liečby, odoslanie bez prevzatia. Výsledok takejto fragmentácie má v nefrológii konkrétnu podobu – neplánovaný začiatok dialýzy s dočasným cievnym prístupom u pacienta, ktorý si nestihol vybrať metódu.</p>

<h2>Zodpovednosť sa dá vyjadriť číslami</h2>

<p>Najsilnejšia vec, ktorú môže nefrológia do debaty o zodpovednosti priniesť, je, že svoje procesné požiadavky vie kvantifikovať. Odporúčanie KDIGO pre chronickú chorobu obličiek z roku 2024 odporúča u pacientov s CKD G3 – G5 používať externe validovanú rovnicu na odhad absolútneho rizika zlyhania obličiek, a to so silou odporúčania <strong>1A</strong>, teda najvyššou. Na túto rovnicu potom viaže konkrétne prahy:</p>

<div class="table-responsive" role="region" aria-label="Prahové hodnoty rizika zlyhania obličiek podľa KDIGO 2024 a im zodpovedajúce kroky" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Praktický bod</th>
        <th scope="col">Prah rizika zlyhania obličiek</th>
        <th scope="col">Čo spúšťa</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">2.2.1</th>
        <td>3 – 5 % počas 5 rokov</td>
        <td>Potrebu odoslania do špecializovanej nefrologickej starostlivosti</td>
      </tr>
      <tr>
        <th scope="row">2.2.2</th>
        <td>Viac než 10 % počas 2 rokov</td>
        <td>Načasovanie multidisciplinárnej starostlivosti</td>
      </tr>
      <tr>
        <th scope="row">2.2.3</th>
        <td>Viac než 40 % počas 2 rokov</td>
        <td>Edukáciu o modalitách, prípravu na náhradu funkcie obličiek vrátane plánovania cievneho prístupu a odoslanie na transplantačné vyšetrenie</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Tieto prahy sú doplnkom ku kritériám podľa glomerulovej filtrácie a albuminúrie, nie ich náhradou, a KDIGO k nim pridáva dve výhrady: rovnice vyvinuté pre CKD G3 – G5 nemusia platiť pri G1 – G2 a pri IgA nefropatii a autozómovo dominantnej polycystickej chorobe obličiek sa majú použiť validované rovnice špecifické pre dané ochorenie.</p>

<p>Praktický význam je v tom, že prah je <strong>auditovateľný</strong>, zatiaľ čo zámer nie. Vetu „venujeme sa včasnému záchytu“ nemožno skontrolovať. Otázku, koľkým pacientom s dvojročným rizikom nad 40 % bola ponúknutá edukácia o modalitách, skontrolovať možno.</p>

<p>KDIGO zároveň v kapitole o optimálnych modeloch starostlivosti výslovne priznáva, že multidisciplinárne tímy sú spojené s nákladmi a že v mnohých regiónoch nie sú dostupné. To nie je slabina odporúčania, ale poctivosť – a presne tá otázka, ktorú rieši reforma.</p>

<h2>Pre včasné odoslanie má nefrológia najsilnejšie čísla</h2>

<p>Cochranov systematický prehľad zahrnul 40 longitudinálnych kohortových štúdií so 63 887 účastníkmi, z ktorých 43 209 (68 %) bolo odoslaných k nefrológovi včas a 20 678 (32 %) neskoro. Rozdiel medzi skupinami bol konzistentný naprieč ukazovateľmi:</p>

<ul>
  <li><strong>Úmrtnosť</strong> – relatívne riziko 0,61 (95 % IS 0,55 – 0,67) po 3 mesiacoch a 0,66 (0,60 – 0,71) po 5 rokoch v prospech včasného odoslania.</li>
  <li><strong>Prvá hospitalizácia</strong> – kratšia o 9,12 dňa (95 % IS −10,92 až −7,32).</li>
  <li><strong>Peritoneálna dialýza</strong> – pacienti odoslaní včas ju začínali častejšie (RR 1,74; 95 % IS 1,64 – 1,84).</li>
  <li><strong>Dočasný cievny prístup</strong> – menej často (RR 0,47; 95 % IS 0,45 – 0,50).</li>
  <li><strong>Trvalý cievny prístup</strong> – častejšie (RR 3,22; 95 % IS 2,92 – 3,55).</li>
</ul>

<p>Tieto čísla treba čítať so zodpovedajúcou obozretnosťou. Autori <strong>nenašli ani jednu randomizovanú štúdiu</strong>; všetkých 40 prác bolo observačných, kvalita bola podľa Newcastle-Ottawskej škály nízka až stredná a heterogenita vo väčšine analýz vysoká (I² dosahovalo 82 až 97 %). Definícia „včasného“ odoslania sa medzi štúdiami mierne líšila, čo samo osebe zakladá riziko skreslenia.</p>

<p>Podstatná je aj úvaha o príčinnosti. Pacient odoslaný neskoro je často odoslaný neskoro práve preto, že ochorenie prebiehalo rýchlo alebo že má viac komorbidít – a potom nie je jasné, nakoľko za horší výsledok môže načasovanie a nakoľko samotné ochorenie. Autori síce uvádzajú, že rozdiely v úmrtnosti a hospitalizáciách sa nevysvetlili rozdielnou prevalenciou komorbidít, výberové skreslenie ani skreslenie dĺžkou sledovania sa však observačným dizajnom odstrániť nedá.</p>

<p>Napriek tomu zostáva jedno zistenie prakticky nespochybniteľné, pretože nejde o výsledok, ale o proces: <strong>včas odoslaný pacient mal pripravený trvalý cievny prístup, neskoro odoslaný mal katéter.</strong> Tu je kauzálna reťaz priehľadná – cievny prístup si vyžaduje čas, ktorý neskoré odoslanie neposkytne.</p>

<h2>Dôkaz pre „modely starostlivosti“ je naopak slabý</h2>

<p>Tu je namieste korigovať rozšírené tvrdenie, že multidisciplinárna starostlivosť pri CKD má doloženú účinnosť. Systematický prehľad, ktorý sa obmedzil na randomizované štúdie modelov starostlivosti pri predialyzačnej CKD, našiel za obdobie 1992 – 2016 iba <strong>deväť článkov zo siedmich štúdií</strong>. Identifikoval štyri modely: vedený sestrou, multidisciplinárny špecializovaný tím, vedený farmaceutom a model sebamanažmentu.</p>

<p>Zistenia boli skromné. Starostlivosť vedená sestrou alebo farmaceutom zlepšila mieru predpisovania liekov relevantných pre CKD a model vedený sestrou aj multidisciplinárny tím sa spájali s malým zlepšením kontroly krvného tlaku. Heterogenita bola vysoká a <strong>všetky štúdie mali vysoké riziko skreslenia</strong>. Dôkaz o dlhodobom zlepšení obličkových, kardiovaskulárnych alebo mortalitných ukazovateľov bol obmedzený krátkym sledovaním. Autori uzavreli, že publikovaných dôkazov o účinnosti jednotlivých modelov je málo, pričom určitý signál existuje pre modely, v ktorých sa starostlivosť poskytuje podľa štruktúrovaného protokolu.</p>

<p>Z toho vyplýva nepríjemný, ale dôležitý záver pre každú reformnú debatu: <strong>vieme doložiť, že na načasovaní odoslania záleží; nevieme rovnako doložiť, ktorý organizačný model je najlepší.</strong> Kto tvrdí opak, pripisuje dôkazom viac, než obsahujú. Reforma preto nemá organizačný model predpisovať, ale umožniť jeho overenie – a zbierať pri tom údaje, ktoré dnes chýbajú.</p>

<h2>Slovenské čísla ukazujú, kde problém je</h2>

<p>Debata o fragmentácii nemusí zostať abstraktná. Údaje Národného centra zdravotníckych informácií za rok 2025 ukazujú, že do pravidelnej dialyzačnej liečby bolo prijatých 151 pacientov, ktorí dovtedy neboli sledovaní pre zlyhanie obličiek, 534 z vlastnej nefrologickej ambulancie a 149 z inej nefrologickej ambulancie. Približne <strong>18 % novoprijatých teda prichádzalo bez predchádzajúceho nefrologického sledovania</strong> pre zlyhanie obličiek.</p>

<p>Druhý údaj dopĺňa obraz. Peritoneálnou dialýzou bolo na Slovensku ku koncu roka 2025 liečených 103 pacientov z celkovo 3 433 dialyzovaných, teda približne 3 %. Cochranov prehľad pritom zistil, že včas odoslaní pacienti začínajú peritoneálnou dialýzou výrazne častejšie. Nízky podiel domácej metódy a nezanedbateľný podiel neplánovaných začiatkov sú zlučiteľné s rovnakou príčinou: s tým, že časť pacientov sa k rozhodovaniu o modalite dostane neskoro alebo vôbec.</p>

<p>Pripomeňme však, čo výkaz neumožňuje. Neuvádza, či išlo o neskorý záchyt, o akútny priebeh, alebo o pacientov sledovaných inde, a nemožno z neho tieto situácie rozlíšiť. Je to signál, nie meranie kvality.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<ul>
  <li><strong>Riziko počítajte, neodhadujte.</strong> U pacienta s CKD G3 – G5 použite externe validovanú rovnicu rizika zlyhania obličiek; ide o odporúčanie úrovne 1A.</li>
  <li><strong>Naviažte na prahy konkrétne kroky:</strong> 3 – 5 % za 5 rokov na odoslanie, nad 10 % za 2 roky na zapojenie tímu, nad 40 % za 2 roky na edukáciu o modalitách, plánovanie cievneho prístupu a transplantačné vyšetrenie.</li>
  <li><strong>Sledujte cievny prístup ako ukazovateľ kvality procesu,</strong> nie ako technický detail. Podiel pacientov začínajúcich dialýzu s katétrom hovorí o organizácii starostlivosti viac než väčšina iných čísel.</li>
  <li><strong>Odoslanie nie je prevzatie.</strong> Pri každom odoslaní musí byť zrejmé, kto pacienta ďalej vedie a kedy je ďalšia kontrola.</li>
  <li><strong>Pri reformných zmenách žiadajte údaje o procese,</strong> nie len o počte výkonov: podiel neplánovaných začiatkov, podiel trvalých cievnych prístupov, čas od odoslania po prvé nefrologické vyšetrenie.</li>
  <li><strong>Nepredávajte organizačný model ako dôkazmi podloženú intervenciu.</strong> Štruktúrovaný protokol má určitú oporu; konkrétne zloženie tímu zatiaľ nie.</li>
</ul>

<h2>Limity</h2>

<ul>
  <li>Podujatie DGIM Talk je rámcom článku, nie jeho zdrojom; v čase prípravy textu bol dostupný program, nie obsah prednášok, a článok z neho nevyvodzuje žiadne vecné tvrdenia.</li>
  <li>Nemecké reformné prostredie sa od slovenského líši organizáciou, financovaním aj kompetenčným rámcom; prenosnosť je obmedzená na položené otázky, nie na odpovede.</li>
  <li>Dôkaz o prínose včasného odoslania je výlučne observačný, s vysokou heterogenitou a rizikom výberového skreslenia.</li>
  <li>Prahy rizika podľa KDIGO vychádzajú z rovníc validovaných prevažne v iných populáciách; ich kalibrácia v slovenskej populácii nie je doložená.</li>
  <li>Slovenské údaje pochádzajú z administratívneho výkazového zberu, ktorý nerozlišuje neskorý záchyt od akútneho priebehu.</li>
  <li>Článok sa nezaoberá ekonomickým hodnotením jednotlivých organizačných riešení.</li>
</ul>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie ani platné organizačné a úhradové predpisy. Rozhodnutie o načasovaní odoslania, o modalite a o príprave na náhradu funkcie obličiek je vždy individuálne.</em></p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=nefrolog-nie-je-lekar-az-pre-dialyzu-vcasne-vysetrenie">Nefrológ nie je lekár až pre dialýzu</a> – prečo na včasnom vyšetrení záleží.</li>
  <li><a href="article.php?slug=dialyzacna-liecba-slovensko-nczi-2025">Dialyzačná liečba na Slovensku podľa údajov NCZI za rok 2025</a> – zdroj slovenských čísel použitých v tomto článku.</li>
  <li><a href="article.php?slug=cievny-pristup-nemozny-avf-avg-planovanie-dialyzy">Plánovanie cievneho prístupu</a> – čo sa stane, keď naň nezostane čas.</li>
  <li><a href="article.php?slug=predialyzacna-edukacia-volba-peritonealnej-dialyzy">Predialyzačná edukácia a voľba peritoneálnej dialýzy</a> – rozhodovanie o modalite.</li>
  <li><a href="article.php?slug=estop-aki-strojove-ucenie-vcasna-konzultacia-nefrologa">Včasná konzultácia nefrológa</a> – pokus o jej systematizáciu strojovým učením.</li>
  <li><a href="article.php?slug=paliativna-starostlivost-nefrologia-krehki-starsi-eskd">Paliatívna starostlivosť v nefrológii</a> – komplexná konzervatívna starostlivosť ako rovnocenná cesta.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Deutsche Gesellschaft für Innere Medizin (DGIM), STREAMED UP.</strong> <em>Die Zukunft der Inneren Medizin – zwischen Reform und Verantwortung.</em> Online vzdelávacie podujatie, livestream 16. októbra 2026; vedecké vedenie Petra-Maria Schumm-Draeger a Dirk Müller-Wieland; prednášajúci Michael Hallek, Manfred Gogol a Christina Hillebrecht. <a href="https://streamed-up.com/live/die-zukunft-der-inneren-medizin-zwischen-reform-und-verantwortung" target="_blank" rel="noopener noreferrer">Stránka podujatia</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(4S):S117–S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">plné znenie (PDF)</a>.</li>
  <li><strong>Neil A. Smart, Gudrun Dieberg, Maleeka Ladhani, Thomas Titus.</strong> <em>Early referral to specialist nephrology services for preventing the progression to end-stage kidney disease.</em> Cochrane Database of Systematic Reviews. 2014;(6):CD007333. <a href="https://doi.org/10.1002/14651858.CD007333.pub2" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Ruairidh Nicoll, Lynn Robertson, Elliot Gemmell, Pawana Sharma, Corri Black, Angharad Marks.</strong> <em>Models of care for chronic kidney disease: A systematic review.</em> Nephrology (Carlton). 2018;23(5):389–396. <a href="https://doi.org/10.1111/nep.13198" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Národné centrum zdravotníckych informácií.</strong> <em>Nefrologická starostlivosť a liečba nahrádzajúca funkciu obličiek v Slovenskej republike 2025.</em> Bratislava: NCZI; publikované august 2026. <a href="https://data.nczisk.sk/statisticke_vystupy/Nefrologia/Nefrologia_v_SR_2025.pdf" target="_blank" rel="noopener noreferrer">Správa (PDF)</a>; <a href="https://data.nczisk.sk/statisticke_vystupy/Nefrologia/Nefrologia_v_SR_2025.xlsx" target="_blank" rel="noopener noreferrer">tabuľkové výstupy (XLSX)</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Údaje o podujatí – dátum vysielania, dĺžka, dva kredity kategórie A, certifikácia Lekárskou komorou spolkovej krajiny Hesensko, vyhlásenie o nesponzorovaní, mená vedeckého vedenia aj prednášajúcich a názvy troch tém – boli prevzaté z verejne dostupnej stránky podujatia a overené v jej plnom znení. Obsah prednášok nebol v čase prípravy článku dostupný a článok z neho nevyvodzuje žiadne tvrdenia. Odporúčanie 2.2.1 a praktické body 2.2.1 až 2.2.5, ako aj znenie kapitoly 5 o optimálnych modeloch starostlivosti, boli prevzaté z doslovného znenia odporúčania KDIGO 2024. Číselné údaje Cochranovho prehľadu (40 štúdií, 63 887 účastníkov, 43 209 oproti 20 678, RR 0,61 a 0,66, rozdiel 9,12 dňa, RR 1,74, 0,47 a 3,22, hodnotenie kvality Newcastle-Ottawskou škálou, I² 82 – 97 %) a systematického prehľadu modelov starostlivosti (deväť článkov zo siedmich štúdií, obdobie 1992 – 2016, štyri modely, vysoké riziko skreslenia) boli overené proti ich abstraktom v databáze PubMed. Slovenské údaje (151, 534 a 149 prijatých pacientov; 103 pacientov na peritoneálnej dialýze z 3 433) pochádzajú z tabuliek T 7 a T 8 primárneho výstupu NCZI. Bibliografia bola overená cez PubMed a Crossref vrátane úplných mien autorov. <strong>Rozdiely oproti pôvodnej predlohe:</strong> predloha uvádzala, že nedokázala overiť autorstvo zdrojov ani získať znenie odporúčaní, a tvrdenia preto formulovala všeobecne; všetky tieto overenia boli pre tento článok vykonané a hedging bol nahradený konkrétnymi údajmi. Predloha tiež uvádzala, že systematické prehľady podporujú prínos multidisciplinárnych modelov starostlivosti – overený prehľad randomizovaných štúdií dospel k opatrnejšiemu záveru, že publikovaných dôkazov je málo a všetky zahrnuté štúdie mali vysoké riziko skreslenia. <strong>Vlastným odborným spracovaním</strong> je prepojenie reformnej témy s prahmi rizika podľa KDIGO, rozlíšenie medzi silou dôkazu pre včasné odoslanie a pre organizačné modely, argument o cievnom prístupe ako priehľadnej kauzálnej reťazi, prepojenie na slovenské údaje a celé zhrnutie pre prax.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_reforma-zdravotnictva-kontinuita-nefrologickej-starostlivosti_article',
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
