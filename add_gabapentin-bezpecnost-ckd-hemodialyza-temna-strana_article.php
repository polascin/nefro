<?php
/**
 * add_gabapentin-bezpecnost-ckd-hemodialyza-temna-strana_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie odborného článku: bezpečnostný profil gabapentínu (a gabapentinoidov
 * všeobecne) v nefrologickom kontexte — renálna kumulácia, respiračná depresia
 * pri kopreskripcii s opioidmi, zmenený duševný stav, pády a fraktúry pri
 * hemodialýze, dávkovo závislé riziko pri CKD bez dialýzy a potenciál zneužitia.
 *
 * Autor projektu: MUDr. Ľubomír Polaščín. Ide o odborné zhrnutie viacerých
 * primárnych zdrojov (FDA Drug Safety Communication 2019 a platné preskripčné
 * informácie, Smith 2016 Addiction, Ishida 2018 JASN, Muanda 2022 AJKD,
 * Blum 1994 Clin Pharmacol Ther, Lehmann 2022 Case Rep Nephrol Dial) — nie
 * o preklad jedného zdrojového článku, preto sa do source_authors.php
 * nedopĺňajú pôvodní autori.
 *
 * Číselné údaje overené proti abstraktom a plným textom v PubMede
 * (PMID 27265421, 29871945, 34979160, 8062491, 36518357) a proti platným
 * americkým preskripčným informáciám gabapentínu (sekcia 5.7 Respiratory
 * Depression). Postup: git commit (SFTP deploy) → spustenie cez SSH.
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
    'title'        => 'Gabapentín a jeho „temná strana“: bezpečnosť v nefrologickom kontexte (CKD, hemodialýza)',
    'slug'         => 'gabapentin-bezpecnost-ckd-hemodialyza-temna-strana',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Gabapentín sa vylučuje obličkami nezmenený a jeho polčas sa pri dialýze predlžuje z 5 až 9 hodín až na 132 hodín. Prehľad bezpečnostných línií, ktoré z toho vyplývajú: respiračná depresia pri kopreskripcii s opioidmi, zmenený duševný stav, pády a fraktúry pri hemodialýze, dávkovo závislé riziko pri CKD bez dialýzy a potenciál zneužitia — plus to, čo tieto dáta nehovoria.',
    'content'      => <<<'HTML'
<figure><a href="img/gabapentin-bezpecnost-ckd-hemodialyza.webp" rel="noopener noreferrer" target="_blank"><img src="img/gabapentin-bezpecnost-ckd-hemodialyza.webp" alt="Jediná kapsula stojí na studenej klinickej podlahe a vrhá neúmerne dlhý čierny tieň; v tieni sa črtá padajúca staršia osoba a dýchacia krivka, ktorá sa vyrovnáva do priamky, zatiaľ čo v pozadí dve svietiace obličky tvoria uzavreté stavidlo bez odtoku" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna, nie klinický záznam ani snímka konkrétneho pacienta či prípravku. Malá dávka vrhá pri zlyhávajúcich obličkách neúmerne dlhý tieň: liečivo sa vylučuje nezmenené obličkami, a keď odtok chýba, kumuluje sa. Pády, zmätenosť a útlm dýchania nie sú „iné“ nežiaduce účinky — sú to tie isté účinky pri vyššej expozícii.</figcaption></figure>

<p>Gabapentín je antiepileptikum, ktoré sa v praxi používa predovšetkým ako analgetikum — pri neuropatickej bolesti, pri syndróme nepokojných nôh, pri uremickom pruritu a nezriedka aj mimo schválených indikácií pri nespavosti či úzkosti. V nefrologickej populácii je jeho podiel vysoký: v americkom registri USRDS dostávalo v roku 2011 gabapentín <strong>19 % hemodialyzovaných pacientov</strong> a ďalšie 4 % pregabalín.</p>

<p>Práve preto sa oplatí pozrieť sa na jeho bezpečnostný profil bez marketingového aj bez bulvárneho filtra. Cieľom tohto článku <strong>nie je gabapentín démonizovať</strong> — u správne vybraného pacienta je to užitočné a lacné liečivo s desaťročiami klinickej skúsenosti. Cieľom je oddeliť štyri bezpečnostné línie, ktoré sa v diskusii o „temnej strane“ gabapentínu zvyknú zlievať do jednej, pri každej z nich pomenovať jej dôkazový základ a vyvodiť, čo z nej vyplýva pre nefrologickú prax.</p>

<h2>Prečo je to v nefrológii iný liek než v neurológii</h2>

<p>Celý problém má jeden farmakokinetický koreň. Gabapentín sa <strong>nemetabolizuje</strong> — v klasickej práci Bluma a spolupracovníkov (<em>Clinical Pharmacology and Therapeutics</em>, 1994) sa u 60 osôb s rôznym stupňom renálnej funkcie nenašli známky metabolizmu ani pri ťažkej renálnej insuficiencii a celkové množstvo nezmeneného liečiva vylúčeného močom bolo porovnateľné vo všetkých skupinách. Plazmatický aj renálny klírens gabapentínu pritom <strong>lineárne koreloval s klírensom kreatinínu</strong>.</p>

<p>Dôsledok je priamočiary a pre nefrológa neprekvapivý: pri klesajúcej glomerulárnej filtrácii rastie maximálna plazmatická koncentrácia, predlžuje sa čas do jej dosiahnutia a predlžuje sa eliminačný polčas. Pri normálnej funkcii obličiek je polčas <strong>asi 5 až 9 hodín</strong>; u dialyzovaného pacienta sa uvádza až <strong>132 hodín</strong>. To nie je jemné posunutie dávkovacieho intervalu — to je zmena o celý rád.</p>

<p>Dve praktické poznámky k tomu:</p>

<ul>
  <li><strong>Vstrebávanie gabapentínu je saturovateľné.</strong> Prebieha prenášačom pre veľké neutrálne aminokyseliny, takže biologická dostupnosť pri vyšších jednorazových dávkach <em>klesá</em>. U pacienta s CKD to pôsobí ako falošná poistka: zdvojnásobenie dávky nemusí zdvojnásobiť koncentráciu, ale nijako to nekompenzuje chýbajúcu elimináciu.</li>
  <li><strong>Gabapentín sa dialýzou odstraňuje.</strong> Je to malá molekula bez podstatnej väzby na bielkoviny, takže hemodialýza ju účinne eliminuje — preto schémy dávkovania pri dialýze pracujú s dávkou <em>po</em> výkone. Zároveň to znamená, že pri klinicky zjavnej toxicite je dialýza terapeutickým nástrojom, nielen zdrojom problému.</li>
</ul>

<p>Konkrétne dávkovacie schémy podľa klírensu kreatinínu, vrátane schémy pre anurického hemodialyzovaného pacienta, rozoberá samostatný článok <a href="article.php?slug=polyneuropatia-ckd-diagnostika-liecba-bezpecne-davkovanie">o polyneuropatii pri CKD</a>; tu sa nimi nebudeme duplicitne zaoberať.</p>

<h2>Línia 1: respiračná depresia a kopreskripcia s opioidmi</h2>

<p>Dlho sa predpokladalo, že gabapentinoidy nemajú klinicky významný vplyv na dýchanie. <strong>19. decembra 2019</strong> vydala americká FDA <em>Drug Safety Communication</em>, ktorá tento predpoklad formálne ukončila: upozornila na riziko <strong>závažných dýchacích ťažkostí</strong> pri gabapentíne a pregabalíne a nariadila doplniť varovanie do preskripčných informácií.</p>

<p>Podklad bol zmiešaný — kazuistiky, klinické štúdie aj observačné dáta:</p>

<ul>
  <li>V období <strong>2012 až 2017</strong> bolo FDA nahlásených <strong>49 prípadov respiračnej depresie</strong> súvisiacej s gabapentinoidmi; <strong>12 pacientov zomrelo</strong> a všetci mali aspoň jeden rizikový faktor.</li>
  <li>V jednej štúdii tlmil pregabalín dýchacie funkcie samostatne aj v kombinácii s opioidom; v ďalšej gabapentín samostatne zvýšil počet dýchacích páuz v spánku.</li>
  <li>Tri observačné štúdie z jedného akademického centra ukázali súvislosť medzi podaním gabapentinoidu pred operáciou a pooperačnou respiračnou depresiou.</li>
</ul>

<p>FDA zároveň <strong>uložila výrobcom povinnosť vykonať klinické štúdie</strong> hodnotiace potenciál gabapentinoidov tlmiť dýchanie pri súbežnom podávaní s opioidmi. Rizikové faktory uvedené v komunikácii sú tri: <strong>opioidné analgetiká a iné látky tlmiace centrálny nervový systém</strong>, <strong>stavy znižujúce funkciu pľúc</strong> (typicky chronická obštrukčná choroba pľúc) a <strong>vyšší vek</strong>.</p>

<p>Platné americké preskripčné informácie gabapentínu to dnes v sekcii 5.7 formulujú veľmi explicitne — hovoria o dôkazoch z kazuistík, humánnych aj animálnych štúdií, ktoré spájajú gabapentín so <em>závažnou, život ohrozujúcou alebo fatálnou</em> respiračnou depresiou pri súbežnom podaní látok tlmiacich CNS (vrátane opioidov) alebo pri existujúcej poruche dýchania, a odporúčajú v takej situácii pacienta monitorovať a <strong>zvážiť začatie nízkou dávkou</strong>.</p>

<div class="table-responsive" role="region" aria-label="Rizikové faktory respiračnej depresie pri gabapentinoidoch a ich výskyt v nefrologickej populácii" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Rizikový faktor podľa FDA</th><th scope="col">Prečo je v nefrologickej populácii častejší</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Opioidy a iné CNS-depresíva</th><td>Chronická bolesť pri CKD a na dialýze je vysoko prevalentná; pridávajú sa benzodiazepíny, Z-hypnotiká, sedatívne antihistaminiká a antidepresíva — polyfarmácia je pri CKD pravidlom, nie výnimkou</td></tr>
    <tr><th scope="row">Znížená funkcia pľúc (CHOCHP)</th><td>Spoločné rizikové faktory (fajčenie, vek), častá kardiorenálna kongescia a objemové preťaženie s reštrikčnou zložkou</td></tr>
    <tr><th scope="row">Vyšší vek</th><td>Dialyzačná populácia je prevažne staršia a krehká</td></tr>
    <tr><th scope="row">Renálna insuficiencia <em>(nie je v zozname FDA, ale moduluje expozíciu)</em></th><td>Pri rovnakej predpísanej dávke je plazmatická koncentrácia výrazne vyššia — rizikové faktory sa teda sčítavajú s vyššou expozíciou</td></tr>
  </tbody>
</table>
<p><em>Zostavené podľa FDA Drug Safety Communication z 19. 12. 2019 a platných preskripčných informácií gabapentínu (sekcia 5.7). Posledný riadok je klinická interpretácia, nie citát z dokumentu.</em></p>
</div>

<h2>Línia 2: čo sa reálne deje na hemodialýze — zmätenosť, pády, fraktúry</h2>

<p>Najcitovanejšou nefrologickou prácou k tejto téme je kohortová analýza <strong>Ishidovej a spolupracovníkov</strong> (<em>Journal of the American Society of Nephrology</em>, 2018). Z registra USRDS identifikovala <strong>140 899 dospelých</strong> na hemodialýze s krytím Medicare Part D v roku <strong>2011</strong>. Expozícia gabapentínu a pregabalínu bola modelovaná ako <em>časovo premenná</em>, zvlášť pre každé liečivo a podľa kategórií dennej dávky. Coxove modely boli upravené na demografiu, komorbidity, trvanie expozície, počet liekov a súbežnú potenciálne zavádzajúcu medikáciu. Sledovaným ukazovateľom bol čas do prvej návštevy urgentného príjmu alebo hospitalizácie pre <strong>zmenený duševný stav, pád a fraktúru</strong>.</p>

<div class="table-responsive" role="region" aria-label="Asociácia gabapentínu a pregabalínu s nepriaznivými udalosťami u hemodialyzovaných pacientov" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Expozícia</th><th scope="col">Zmenený duševný stav</th><th scope="col">Pád</th><th scope="col">Fraktúra</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Gabapentín &gt; 300 mg/deň (najvyššia kategória)</th><td>o <strong>50 %</strong> vyššie riziko</td><td>o <strong>55 %</strong> vyššie riziko</td><td>o <strong>38 %</strong> vyššie riziko</td></tr>
    <tr><th scope="row">Gabapentín v nižších dávkových kategóriách</th><td>o <strong>31 – 41 %</strong> vyššie riziko</td><td>o <strong>26 – 30 %</strong> vyššie riziko</td><td>bez konzistentného signálu</td></tr>
    <tr><th scope="row">Pregabalín</th><td>až o <strong>51 %</strong> vyššie riziko</td><td>až o <strong>68 %</strong> vyššie riziko</td><td>bez konzistentného signálu</td></tr>
  </tbody>
</table>
<p><em>Ishida JH a kol., JASN 2018;29(7):1970–1978. Dávkové kategórie gabapentínu: &gt; 0 – 100, &gt; 100 – 200, &gt; 200 – 300 a &gt; 300 mg denne; pregabalínu: &gt; 0 – 100 a &gt; 100 mg denne. Údaje sú upravené pomery rizík z Coxových modelov, vyjadrené ako percentuálny nárast oproti neužívaniu.</em></p>
</div>

<p>Z tejto tabuľky vyplývajú tri veci, ktoré sa v sekundárnych citáciách pravidelne strácajú:</p>

<ol>
  <li><strong>Nejde o „predávkovanie“.</strong> Najvyššia skúmaná kategória je „viac ako 300 mg denne“ — teda dávka, ktorú by mnohý predpisujúci lekár označil za konzervatívnu. Riziko sa nezačína pri gramových dávkach.</li>
  <li><strong>Riziko sa nestráca ani pri nižších dávkach.</strong> Pre zmenený duševný stav a pády bolo zvýšené vo <em>všetkých</em> dávkových kategóriách. Dávkovo závislá je veľkosť efektu, nie jeho prítomnosť.</li>
  <li><strong>Pregabalín nie je bezpečná alternatíva.</strong> Pre pády bol jeho signál dokonca najvýraznejší z celej analýzy.</li>
</ol>

<p>Pozornosť si zaslúži aj nález, ktorý s rizikom priamo nesúvisí: <strong>68 % používateľov</strong> gabapentínu alebo pregabalínu malo zdokumentovanú diagnózu neuropatickej bolesti, pruritu alebo syndrómu nepokojných nôh. U takmer tretiny teda zjavná indikácia v dátach chýbala. Autori uzatvárajú, že gabapentín a pregabalín treba u hemodialyzovaných pacientov používať <em>uvážlivo</em> a že je potrebný výskum optimálneho dávkovania — to druhé je po rokoch stále nesplnená požiadavka.</p>

<h3>Ako to vyzerá na konkrétnom pacientovi</h3>

<p>Čísla z registrov sú abstraktné; kazuistika z nemeckého centra (<em>Case Reports in Nephrology and Dialysis</em>, 2022) ich prekladá do ambulantnej reality. Dvaja pacienti na peritoneálnej dialýze mali predávkovanie gabapentínom. U jedného z nich viedli ťažké neurologické prejavy k rozsiahlemu diagnostickému postupu vrátane zobrazenia mozgu — pričom skutočnou príčinou bola <strong>supraterapeutická hladina gabapentínu</strong>. Príznaky ustúpili po vysadení liečiva.</p>

<p>Autori z toho vyvodzujú odporúčanie, ktoré sa v odporúčaniach odborných spoločností nenájde, ale v praxi má zmysel: <strong>u dialyzovaného pacienta s nevysvetlenou zmätenosťou, myoklonom, ataxiou alebo útlmom patrí gabapentín do diferenciálnej diagnózy skôr než CT mozgu</strong> — a tam, kde je dostupné meranie hladín, je rozumné ho využiť. Uremická encefalopatia, dialyzačný dysekvilibračný syndróm a gabapentínová toxicita sa klinicky prekrývajú; posledná z nich je jediná, ktorá sa dá odstrániť vysadením tablety.</p>

<h2>Línia 3: CKD bez dialýzy — na dávke záleží už v prvom mesiaci</h2>

<p>Pacient s CKD, ktorý nie je na dialýze, má najhoršiu kombináciu: zníženú elimináciu <em>a</em> žiadny mimotelový odtok. Populačná kohortová štúdia <strong>Muandu a spolupracovníkov</strong> (<em>American Journal of Kidney Diseases</em>, 2022) túto skupinu zmapovala v kanadskom Ontáriu:</p>

<ul>
  <li><strong>74 084 starších dospelých</strong> (64 % ženy, medián veku 79 rokov) s eGFR &lt; 60 ml/min/1,73 m², bez dialýzy, s novo predpísaným gabapentinoidom v rokoch 2008 až 2020.</li>
  <li>Porovnávala sa <strong>vyššia štartovacia dávka</strong> (gabapentín &gt; 300 mg/deň alebo pregabalín &gt; 75 mg/deň) oproti nižšej (≤ 300 mg, resp. ≤ 75 mg denne).</li>
  <li><strong>41 % pacientov začalo vyššou dávkou</strong> — teda nejde o okrajovú prax, ale takmer o polovicu preskripcií.</li>
  <li>Zložený ukazovateľ do 30 dní: nemocničná návšteva pre encefalopatiu, pád alebo fraktúru, alebo hospitalizácia pre respiračnú depresiu.</li>
</ul>

<p>Výsledok po vážení pravdepodobnosťou liečby: <strong>585 z 30 660 (1,9 %)</strong> pri vyššej dávke oproti <strong>462 z 30 707 (1,5 %)</strong> pri nižšej. Vážený <strong>pomer rizík 1,27 (95 % IS 1,13 – 1,42)</strong>, vážený <strong>rozdiel rizík 0,40 % (95 % IS 0,21 – 0,60 %)</strong>. Ani multiplikatívne, ani aditívne interakcie v podskupinách podľa kategórie eGFR a typu gabapentinoidu neboli štatisticky významné.</p>

<p>Interpretácia si žiada presnosť v oboch smeroch. Relatívny nárast o 27 % znie veľa, <strong>absolútny rozdiel 0,40 percentného bodu počas 30 dní</strong> znie málo — a autori sami hovoria o „mierne vyššom riziku“, ktoré treba vyvážiť prínosom vyššej dávky. Lenže ide o <em>tridsaťdňové</em> okno u pacientov, ktorí gabapentinoid často užívajú roky, a o udalosti, ktoré nie sú nevinné: fraktúra proximálneho femuru u 79-ročného pacienta s CKD G4 je udalosť mortalitného rádu. Počet pacientov potrebných na uškodenie približne 250 pri jednej jedinej voľbe štartovacej dávky je pri takej jednoduchej intervencii — začať nižšie — veľmi dobrá výmena.</p>

<h2>Línia 4: zneužívanie a nesprávne užívanie</h2>

<p>Gabapentín bol roky vnímaný ako liečivo bez zneužívacieho potenciálu, čo bolo jedným z dôvodov jeho rozsiahleho predpisovania mimo schválených indikácií. Systematický prehľad <strong>Smithovej, Havensovej a Walshovej</strong> (<em>Addiction</em>, 2016) tento obraz korigoval. Zahrnul <strong>33 prác</strong> — <strong>23 kazuistík a 11 epidemiologických správ</strong> — zo Spojených štátov, Spojeného kráľovstva, Nemecka, Fínska, Indie, Juhoafrickej republiky a Francúzska.</p>

<div class="table-responsive" role="region" aria-label="Udávaná prevalencia nesprávneho užívania gabapentínu podľa populácie" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Populácia</th><th scope="col">Udávaná prevalencia nesprávneho užívania</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Všeobecná populácia</th><td>približne <strong>1 %</strong></td></tr>
    <tr><th scope="row">Osoby s predpisom gabapentínu</th><td><strong>40 – 65 %</strong></td></tr>
    <tr><th scope="row">Populácie osôb zneužívajúcich opioidy</th><td><strong>15 – 22 %</strong></td></tr>
  </tbody>
</table>
<p><em>Smith RV, Havens JR, Walsh SL. Addiction 2016;111(7):1160–1174. Nesprávne užívanie (misuse) bolo definované ako užitie vyššej dávky, než bola predpísaná, alebo užitie gabapentínu bez predpisu.</em></p>
</div>

<p>Dvom veciam sa pri citovaní týchto čísel treba vyhnúť. Prvou je zámena pojmov: <strong>nesprávne užívanie podľa použitej definície nie je závislosť</strong> — zahŕňa aj pacienta, ktorý si pri silnej bolesti vezme o jednu tabletu viac, než mu bolo predpísané. Rozpätie 40 – 65 % u osôb s predpisom preto nemožno čítať ako „polovica mojich pacientov je závislá“. Druhou je prehliadanie heterogenity: ide o prehľad údajov z rôznych krajín a populácií, prevažne z kazuistík, nie o metaanalýzu s jedným súhrnným odhadom.</p>

<p>Čo je však z prehľadu konzistentné a klinicky použiteľné:</p>

<ul>
  <li>Subjektívne účinky pripomínajúce opioidy, benzodiazepíny aj psychedeliká sa objavili <strong>v rozsahu dávok vrátane tých, ktoré sú v klinických odporúčaniach</strong>.</li>
  <li>Gabapentín sa zneužíval najmä rekreačne, ako samoliečba alebo so sebapoškodzujúcim zámerom — a <strong>typicky v kombinácii s opioidmi, benzodiazepínmi alebo alkoholom</strong>. To je presne tá kombinácia, pre ktorú FDA varuje pred respiračnou depresiou; línia 1 a línia 4 sa tu stretávajú.</li>
  <li>Najčastejšie išlo o osoby s anamnézou zneužívania látok — to je použiteľný stratifikačný údaj pri rozhodovaní o preskripcii.</li>
</ul>

<p>Regulačné následky na seba nedali čakať: v <strong>Spojenom kráľovstve boli gabapentín aj pregabalín od 1. apríla 2019 preradené</strong> medzi kontrolované liečivá (Schedule 3 podľa <em>Misuse of Drugs Regulations</em> 2001, trieda C podľa <em>Misuse of Drugs Act</em> 1971) s prísnejšími požiadavkami na predpis a s platnosťou receptu 28 dní. V Slovenskej republike takéto zaradenie neplatí, čo z pohľadu klinika znamená jediné: <strong>kontrolu musí zabezpečiť preskripčná disciplína, nie legislatíva</strong>.</p>

<h2>Signál, na ktorý sa zatiaľ nedá spoliehať</h2>

<p>V roku 2026 sa objavil <strong>preprint</strong> (medRxiv, teda práca <em>bez</em> dokončeného recenzného posúdenia) s hypotézou, že CKD zosilňuje asociáciu gabapentínu s demenciou v porovnaní s pregabalínom. Autori uvádzajú u pacientov s CKD pomer rizík 7,39 (95 % IS 3,43 – 15,92) oproti takmer nulovej asociácii bez CKD, so signálom sústredeným v nedialyzačnom CKD G3b – G4 a s externou replikáciou v programe <em>All of Us</em> (pomer rizík 1,59; 95 % IS 1,35 – 1,88).</p>

<p>Tento údaj uvádzame <strong>zámerne s výhradou a nie ako podklad na rozhodovanie</strong>. Pomer rizík 7,39 je pre farmakoepidemiologickú asociáciu liečiva s demenciou nápadne vysoký a taká veľkosť efektu býva spravidla skôr ukazovateľom reziduálneho zavádzania (zavádzania podľa indikácie, protopatického zavádzania pri prodróme demencie) než skutočnej príčinnej súvislosti — napokon aj samotná externá replikácia v tej istej práci je o celý rád miernejšia. Mechanistická úvaha o renálnej expozícii je legitímna a konzistentná s farmakokinetikou; dôkazová sila preprintu však neopodstatňuje zmenu praxe. <strong>Hodno sledovať, nie podľa toho predpisovať.</strong></p>

<h2>Čo tieto dáta nehovoria</h2>

<p>Poctivé čítanie bezpečnostnej literatúry vyžaduje aj negatívny výpočet:</p>

<ul>
  <li><strong>Ide prevažne o observačné dáta.</strong> Analýza Ishidovej aj štúdia Muandu sú kohortové práce s úpravou na zmerané zavádzajúce premenné; <strong>zavádzanie podľa indikácie</strong> zostáva otvorené. Pacient, ktorý potrebuje vyššiu dávku gabapentínu, je už z definície pacient s horšími príznakmi — a často aj krehkejší. Muanda a spolupracovníci uvádzajú reziduálne zavádzanie ako hlavné obmedzenie explicitne.</li>
  <li><strong>Žiadna z týchto prác nehovorí, že gabapentín netreba predpisovať.</strong> Hovoria, že jeho prínos treba vyvážiť rizikom a že dávka je modifikovateľná premenná.</li>
  <li><strong>Neexistuje štúdia, ktorá by stanovila optimálnu dávku pri dialýze.</strong> Táto medzera je výslovným záverom práce Ishidovej z roku 2018 a dodnes nebola zaplnená. Všetko, čo máme, je farmakokinetická extrapolácia a klinická opatrnosť.</li>
  <li><strong>Alternatívy majú vlastné riziká.</strong> Nesteroidné antiflogistiká sú pri CKD problematické, opioidy nesú riziko útlmu, pádov, delíria a respiračnej depresie (a pri renálnej eliminácii metabolitov sa kumulujú podobne ako gabapentín), tricyklické antidepresíva pôsobia anticholínergne. „Nepredpísať gabapentín“ nie je automaticky bezpečnejšia voľba — bezpečnejšia je <em>správna indikácia a správna dávka</em>.</li>
</ul>

<h2>Prevedenie do praxe</h2>

<p>Z uvedených štyroch línií vychádza šesť praktických princípov. Nie sú odporúčaniami odbornej spoločnosti — sú klinickou syntézou citovaných zdrojov.</p>

<ol>
  <li><strong>Indikáciu pomenujte výslovne a zapíšte ju do dokumentácie.</strong> Neuropatická bolesť, syndróm nepokojných nôh, uremický pruritus — alebo nič z toho. Zistenie, že takmer tretina používateľov v registri USRDS zdokumentovanú indikáciu nemala, je prvé miesto, kde sa dá riziko znížiť bez akejkoľvek straty prínosu. Pri pruritu stojí za zváženie, či nejde o situáciu, ktorú rozoberá článok <a href="article.php?slug=uviaznuti-na-antihistaminikach-pri-ckd-ap">o uviaznutí na antihistaminikách pri CKD-aP</a>.</li>
  <li><strong>Začínajte nízko, a to aj vtedy, keď sa dávka zdá malá.</strong> Údaje z Ontária hovoria, že voľba štartovacej dávky robí merateľný rozdiel už do 30 dní; údaje z USRDS hovoria, že „viac ako 300 mg denne“ už je najrizikovejšia kategória. Titrujte podľa odpovede, nie podľa schémy prevzatej z neurologickej indikácie.</li>
  <li><strong>Pred predpisom prejdite celý zoznam liekov so zameraním na CNS-depresíva.</strong> Opioidy, benzodiazepíny, Z-hypnotiká, sedatívne antihistaminiká, antipsychotiká, antidepresíva. Ak je kombinácia s opioidom nevyhnutná, pacienta aj jeho blízkych poučte o prejavoch respiračnej depresie: pomalé a plytké dýchanie, nereagovanie, cyanóza, zmätenosť, závrat, letargia. Širší rámec dáva článok <a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">o CKD ako samostatnom faktore polyfarmácie</a>.</li>
  <li><strong>Rizikové faktory zo zoznamu FDA vyhľadávajte aktívne.</strong> CHOCHP, spánkové apnoe, vyšší vek, krehkosť. Pri ich prítomnosti platí nielen nižšia štartovacia dávka, ale aj pomalšia titrácia a včasnejšia kontrola.</li>
  <li><strong>Monitorujte to, čo sa reálne stáva.</strong> V prvých týždňoch a po každom zvýšení dávky cielene sledujte ospalosť, zmätenosť, myoklonus, ataxiu, poruchu chôdze a nestabilitu — a u rizikových pacientov zapojte opatrenia na prevenciu pádov. U dialyzovaného pacienta s novovzniknutou zmätenosťou patrí gabapentín do diferenciálnej diagnózy.</li>
  <li><strong>Predpis je proces, nie udalosť.</strong> Pri každej kontrole prehodnoťte, či liečivo ešte prináša úžitok, či je dávka stále potrebná, či nestúpla dávka iných CNS-depresív a či nie sú prítomné znaky nesprávneho užívania. Pri vysadzovaní postupujte <strong>postupne</strong> — náhle prerušenie je spojené s abstinenčnými prejavmi a odporúča sa znižovať spravidla najmenej počas jedného týždňa.</li>
</ol>

<h2>Záver</h2>

<p>„Temná strana“ gabapentínu nie je tajomstvo ani škandál. Je to predvídateľný dôsledok jedného farmakologického faktu — liečivo sa vylučuje obličkami nezmenené — v kombinácii s populáciou, ktorá je staršia, krehkejšia a polyfarmaceuticky liečená než tá, pre ktorú boli dávkovacie schémy navrhnuté.</p>

<p>Pre nefrologickú prax z toho vyplýva jednoduchá veta: <strong>gabapentín nie je „jedna dávka pre všetkých“</strong>. Jeho bezpečnosť neurčuje len indikácia, ale renálna funkcia, zoznam súbežných liekov, respiračný stav, vek a krehkosť — a predovšetkým ochota prehodnotiť predpis, ktorý už svoj účel splnil alebo ho nikdy nesplnil.</p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li><em>FDA Drug Safety Communication: FDA warns about serious breathing problems with seizure and nerve pain medicines gabapentin (Neurontin, Gralise, Horizant) and pregabalin (Lyrica, Lyrica CR)</em>, 19. 12. 2019. <a href="https://www.fda.gov/drugs/drug-safety-and-availability/fda-warns-about-serious-breathing-problems-seizure-and-nerve-pain-medicines-gabapentin-neurontin" target="_blank" rel="noopener noreferrer">fda.gov</a>. Doplnené platnými americkými preskripčnými informáciami gabapentínu, sekcia 5.7 <em>Respiratory Depression</em>.</li>
  <li>Smith RV, Havens JR, Walsh SL. <em>Gabapentin misuse, abuse and diversion: a systematic review.</em> Addiction 2016;111(7):1160–1174. <a href="https://doi.org/10.1111/add.13324" target="_blank" rel="noopener noreferrer">doi:10.1111/add.13324</a> (PMID 27265421).</li>
  <li>Ishida JH, McCulloch CE, Steinman MA, Grimes BA, Johansen KL. <em>Gabapentin and Pregabalin Use and Association with Adverse Outcomes among Hemodialysis Patients.</em> J Am Soc Nephrol 2018;29(7):1970–1978. <a href="https://doi.org/10.1681/ASN.2018010096" target="_blank" rel="noopener noreferrer">doi:10.1681/ASN.2018010096</a> (PMID 29871945).</li>
  <li>Muanda FT, Weir MA, Ahmadi F, Sontrop JM, Cowan A, Fleet JL, Blake PG, Garg AX. <em>Higher-Dose Gabapentinoids and the Risk of Adverse Events in Older Adults With CKD: A Population-Based Cohort Study.</em> Am J Kidney Dis 2022;80(1):98–107.e1. <a href="https://doi.org/10.1053/j.ajkd.2021.11.007" target="_blank" rel="noopener noreferrer">doi:10.1053/j.ajkd.2021.11.007</a> (PMID 34979160).</li>
  <li>Blum RA, Comstock TJ, Sica DA a kol. <em>Pharmacokinetics of gabapentin in subjects with various degrees of renal function.</em> Clin Pharmacol Ther 1994;56(2):154–159. <a href="https://doi.org/10.1038/clpt.1994.118" target="_blank" rel="noopener noreferrer">doi:10.1038/clpt.1994.118</a> (PMID 8062491).</li>
  <li>Lehmann K, Diab S, Meyer TM, Kielstein JT, Eden G. <em>More Drug Monitoring and Less CT Scans of the Brain: Gabapentin Overdose in Two Peritoneal Dialysis Patients.</em> Case Rep Nephrol Dial 2022;12(3):145–149. <a href="https://doi.org/10.1159/000525922" target="_blank" rel="noopener noreferrer">doi:10.1159/000525922</a> (PMID 36518357).</li>
  <li>Green J, Byham-Gray LD, Kaplan J a kol. <em>Chronic Kidney Disease Amplifies Gabapentin-Associated Dementia Risk in Non-Dialysis Patients.</em> medRxiv 2026 — <strong>preprint, nerecenzovaný</strong>. <a href="https://doi.org/10.64898/2026.03.15.26348418" target="_blank" rel="noopener noreferrer">doi:10.64898/2026.03.15.26348418</a> (PMID 41891045).</li>
  <li>NHS England: <em>Handling of gabapentin and pregabalin as Schedule 3 Controlled Drugs</em> — preradenie účinné od 1. 4. 2019. <a href="https://www.england.nhs.uk/wp-content/uploads/2019/02/handling-pregabalin-and-gabapentin.pdf" target="_blank" rel="noopener noreferrer">england.nhs.uk</a>.</li>
</ol>

<p><em>Bibliografické údaje prác 2 až 7 boli overené v databáze PubMed.</em></p>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a nenahrádza platné súhrny charakteristických vlastností liečiva ani individuálne klinické rozhodnutie. Dávkovanie overte v aktuálnom SPC konkrétneho prípravku.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_gabapentin-bezpecnost-ckd-hemodialyza-temna-strana_article',
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
