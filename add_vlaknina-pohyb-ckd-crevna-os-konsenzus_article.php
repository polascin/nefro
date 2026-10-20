<?php

/**
 * Odborny clanok: vlaknina a fyzicka aktivita pri CKD - os crevo-oblicka,
 * dokazy pre uremicke toxiny a konsenzus Italian Society of Nephrology.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_vlaknina-pohyb-ckd-crevna-os-konsenzus_article.php"
 */

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
    'title'        => 'Vláknina a pohyb pri CKD: čo dôkazy skutočne unesú a ako to povedať pacientovi',
    'slug'         => 'vlaknina-pohyb-ckd-crevna-os-konsenzus',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Vláknina pri CKD preukázateľne znižuje uremické toxíny, ale žiadna štúdia zatiaľ nedoložila spomalenie progresie. Pohyb má oporu pevnejšiu. Rozdiel v sile dôkazov treba povedať pacientovi nahlas.',
    'content'      => <<<'HTML'
<figure><a href="img/vlaknina-pohyb-ckd-crevna-os-konsenzus.webp" rel="noopener noreferrer" target="_blank"><img src="img/vlaknina-pohyb-ckd-crevna-os-konsenzus.webp" alt="Polopriesvitné črevo v jantárovom svetle, uprostred žiariaca oblička a vpravo rozpohybované svalstvo dolnej končatiny prepojené svetelnými vláknami" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna – nie snímka konkrétneho pacienta. Vláknina a pohyb zasahujú do tej istej osi: črevo, mikrobiota, zápal, svalová rezerva.</figcaption></figure>

<p><strong>Dve nefarmakologické páky</strong>, ktoré v nefrologickej ambulancii stoja takmer vždy v tieni liekov, majú v skutočnosti nerovnako pevný dôkazový základ. Vláknina má presvedčivé mechanistické vysvetlenie a doložený účinok na biochemické ukazovatele, ale žiadna intervenčná štúdia zatiaľ nepreukázala, že spomaľuje progresiu chronickej choroby obličiek. Fyzická aktivita má naopak oporu v randomizovaných štúdiách pre funkčnú kapacitu, krvný tlak a kvalitu života a od roku 2024 aj v samostatnom konsenzuálnom dokumente.</p>

<p>Tento rozdiel nie je akademický. Určuje, čo pacientovi sľúbime. Ak mu povieme, že „vláknina chráni obličky“, prekročíme dáta. Ak mu povieme, že vláknina zlepší vyprázdňovanie, zníži zápalovú záťaž a nemá preukázané renálne riziko, hovoríme presne to, čo dôkazy unesú.</p>

<p>Spoločný menovateľ oboch intervencií je os črevo – oblička. Pri CKD sa prekrývajú tri procesy: posun zloženia a metabolizmu črevnej mikrobioty smerom k proteolytickej fermentácii, zhoršená integrita črevnej bariéry a následný nárast systémových účinkov látok odvodených z čreva vrátane uremických toxínov. Vláknina do tejto osi vstupuje ako fermentačný substrát, pohyb cez svalovú funkciu, zápalové prostredie a metabolizmus.</p>

<h2>Koľko vlákniny pacienti s CKD skutočne jedia</h2>

<p>Prehľad pracovnej skupiny okolo Guobina Su z Karolinska Institutet a Nanfang Hospital uvádza pre dospelú populáciu odporúčaný príjem <strong>25 – 35 g vlákniny denne</strong>. Namerané hodnoty pri CKD sú od toho vzdialené o polovicu až tri štvrtiny:</p>

<div class="table-responsive" role="region" aria-label="Zistený denný príjem vlákniny v rôznych populáciách pacientov s CKD" tabindex="0">
<table>
<thead>
<tr><th scope="col">Populácia</th><th scope="col">Príjem vlákniny (g/deň)</th></tr>
</thead>
<tbody>
<tr><th scope="row">Dospelá populácia – odporúčanie</th><td>25 – 35</td></tr>
<tr><th scope="row">CKD bez dialýzy (Švédsko)</th><td>16,6 (14,5 – 19,1)</td></tr>
<tr><th scope="row">Hemodialýza (Turecko)</th><td>12,6 ± 4,7</td></tr>
<tr><th scope="row">Hemodialýza (Brazília)</th><td>13,2 ± 6,6</td></tr>
<tr><th scope="row">Hemodialýza (Čína)</th><td>&lt; 14 g u 90 % súboru</td></tr>
<tr><th scope="row">Peritoneálna dialýza</th><td>5,0 ± 2,5 až 8,7 ± 6,6</td></tr>
</tbody>
</table>
</div>

<p>Najnižšie hodnoty u pacientov na peritoneálnej dialýze sú klinicky najvýrečnejšie: príjem okolo 5 – 9 g denne je rádovo pod akýmkoľvek odporúčaním a zároveň ide o skupinu, kde zápcha komplikuje samotnú metódu.</p>

<h2>Čo vláknina pri CKD dokázateľne robí</h2>

<h3>Znižuje uremické toxíny odvodené z čreva</h3>

<p>Toto je najpevnejšie doložený účinok. Metaanalýza desiatich randomizovaných štúdií so <strong>292 pacientmi</strong> s CKD (Hui-Li Yang a spol., <em>Journal of Renal Nutrition</em>) ukázala, že suplementácia vlákniny významne znižuje:</p>

<ul>
  <li>indoxylsulfát: štandardizovaný rozdiel priemerov (SMD) −0,55 (95 % IS −1,04 až −0,07; p = 0,03),</li>
  <li>p-krezylsulfát: SMD −0,47 (95 % IS −0,82 až −0,13; p &lt; 0,01),</li>
  <li>močovinový dusík v krvi: SMD −0,31 (95 % IS −0,58 až −0,03; p = 0,03),</li>
  <li>kyselinu močovú: SMD −0,60 (95 % IS −1,02 až −0,18; p &lt; 0,01).</li>
</ul>

<p>Kreatinín sa pritom <strong>nezmenil</strong> (SMD −0,31; 95 % IS −0,73 až 0,11; p = 0,14). To je dôležitý detail: ak by vláknina ovplyvňovala renálnu funkciu, čakali by sme signál práve tu. Pokles močoviny a kyseliny močovej je zlučiteľný s posunom fermentácie a zvýšeným vylučovaním stolicou, nie nevyhnutne so zlepšením filtrácie.</p>

<p>V podskupinových analýzach bol pokles indoxylsulfátu výraznejší u dialyzovaných než u nedialyzovaných pacientov (p pre interakciu = 0,03) a pokles kreatinínu výraznejší u pacientov bez diabetu (p pre interakciu &lt; 0,01). Staršia metaanalýza experimentálnych prác (Mengyin Wu a spol., <em>Clinical Nutrition</em>; 12 odhadov zo 7 prác, 203 pacientov) doložila pokles p-krezylsulfátu s váženým rozdielom priemerov −16,16 (95 % IS −23,82 až −8,50) a sami autori upozornili, že záver potrebuje potvrdiť randomizovanými štúdiami s lepším dizajnom, väčšími súbormi a dlhším trvaním.</p>

<h3>Súvisí s nižším zápalom a nižšou úmrtnosťou – ale len pozorovacie</h3>

<p>Analýza 14 543 účastníkov NHANES III (Vidya M. Raj Krishnamurthy a spol., <em>Kidney International</em>) priniesla najčastejšie citované číslo z tejto oblasti. Na každých <strong>10 g vlákniny denne navyše</strong> klesla pravdepodobnosť zvýšenej hladiny C-reaktívneho proteínu o 11 % u ľudí bez ochorenia obličiek a o <strong>38 % u ľudí s CKD</strong>. Celkový príjem vlákniny nebol významne spojený s úmrtnosťou u ľudí bez ochorenia obličiek, ale bol s ňou nepriamo spojený u ľudí s CKD; rozdiel medzi skupinami bol štatisticky významný.</p>

<p>Ide o prierezové a observačné dáta s odhadom príjmu z diétnych dotazníkov. Interakcia s CKD je biologicky konzistentná, zvyškové zmätenie však vylúčiť nemožno – vyšší príjem vlákniny je zástupným znakom celkovo zdravšieho životného štýlu. Autori sami uzatvárajú, že na stanovenie účinku sú potrebné intervenčné štúdie.</p>

<h3>Zlepšuje vyprázdňovanie</h3>

<p>Zápcha je pri CKD bežná a jej klinický význam presahuje pohodlie pacienta. V celonárodnej taiwanskej kohorte (Chung-Yen Lu a spol., <em>BMC Nephrology</em>) bola incidencia zlyhania obličiek 22,9 na 1 000 osoborokov u pacientov s novovzniknutou zápchou oproti 12,2 u porovnateľných pacientov bez nej, s upraveným pomerom rizík <strong>1,90 (95 % IS 1,60 – 2,27)</strong>. Riziko stúpalo so závažnosťou zápchy vyjadrenou počtom dní užívania laxatív.</p>

<p>Tento gradient treba čítať opatrne. Počet dní s laxatívami je ukazovateľom závažnosti zápchy, ale aj celkovej chorobnosti a polypragmázie, takže ide o zmätenie indikáciou v učebnicovej podobe. Štúdia nedokazuje, že liečba zápchy znižuje riziko zlyhania obličiek. Dokazuje, že zápcha pri CKD nie je neutrálny nález a patrí do anamnézy.</p>

<p>Na strane intervencie sú dáta konzistentnejšie: prehľad Su a spol. uvádza, že štúdie so suplementáciou vlákniny opakovane hlásia nižší výskyt zápchy a zmiernenie jej príznakov, bez zaznamenaných problémov s toleranciou.</p>

<h2>Kde dôkazy končia</h2>

<p>Tu je potrebná formulácia bez okolkov, pretože predlohy na túto tému ju spravidla zmäkčujú. Prehľad Su a spol. píše doslova, že <em>„hoci je to biologicky vierohodné, zatiaľ neexistuje dôkaz z klinických štúdií, že by príjem vlákniny mohol spomaliť progresiu CKD“</em>. Nejde o „menej konzistentné výsledky“ ani o „slabšie dôkazy“. Ide o chýbajúci dôkaz.</p>

<p>Rovnako zostáva otvorené, aký je optimálny príjem, ktorý typ a zdroj vlákniny je najvhodnejší a aký je účinok na tvrdé koncové ukazovatele, teda na vznik zlyhania obličiek a na úmrtnosť. Prehľad Carly Camerotto a spol. (<em>Nutrients</em>) k tomu dodáva rozmer, ktorý sa v praxi zanedbáva: pri „renálnej diéte“ nejde len o gramy vlákniny, ale o jej typ charakterizovaný rozpustnosťou, viskozitou a fermentovateľnosťou. Tieto vlastnosti určujú, čo sa v hrubom čreve skutočne stane, a štúdie, ktoré ich nerozlišujú, miešajú intervencie s odlišným mechanizmom.</p>

<h2>Draslík: najčastejšia zámienka, prečo sa vláknina neodporučí</h2>

<p>Potraviny bohaté na vlákninu sú často bohaté aj na draslík, a tak sa v pokročilej CKD rutinne obmedzujú. Prehľad Su a spol. tento postup spochybňuje viacerými argumentmi naraz:</p>

<ul>
  <li>súvislosť medzi príjmom draslíka v strave a sérovou kálemiou je <strong>slabá, ak vôbec nejaká</strong>; prierezové práce pri pokročilej CKD a pri dialýze nachádzajú slabú alebo žiadnu koreláciu,</li>
  <li>strava s vysokým obsahom vlákniny môže zvyšovať vylučovanie draslíka stolicou tým, že zväčšuje objem stolice – podanie 7 g psyllia viedlo v jednej práci k <strong>32 % nárastu fekálneho vylučovania draslíka</strong>,</li>
  <li>autori preto uvažujú, že obmedzovaním ovocia a zeleniny možno absorpciu draslíka skôr uľahčujeme, než jej bránime.</li>
</ul>

<p>Tento posun sleduje aj odporúčanie KDIGO 2024. Praktický bod 3.3.1 radí odporúčať ľuďom s CKD zdravú a pestrú stravu s <strong>vyššou spotrebou rastlinných potravín</strong> oproti živočíšnym a s nižšou spotrebou ultraspracovaných potravín. Praktický bod 3.11.5.2 obmedzuje potraviny s vysokým obsahom biologicky dostupného draslíka cielene – uvádza ako príklad <em>spracované potraviny</em> a vzťahuje sa na pacientov s CKD G3 – G5 s hyperkaliémiou v anamnéze alebo v obdobiach so zvýšeným rizikom. Smerovanie je teda jednoznačné: obmedziť vysoko spracované potraviny, nie ovocie a zeleninu plošne.</p>

<p>Praktický dôsledok pre ambulanciu: pri rozhodovaní o vláknine nestačí jediná hodnota kália. Rozhoduje jej dynamika, súbežná liečba inhibítormi renín-angiotenzínového systému a antagonistami mineralokortikoidových receptorov, acidobázický stav a diuréza. Obmedzenie rastlinnej stravy znižuje kvalitu diéty merateľne, kým jeho prínos pre kálemiu je neistý.</p>

<h2>Fyzická aktivita: čo hovorí konsenzus a aké sú čísla</h2>

<p>Konsenzuálny dokument pracovnej skupiny pre fyzické cvičenie Talianskej nefrologickej spoločnosti (Yuri Battaglia a spol., <em>Journal of Nephrology</em> 2024) formuluje <strong>16 stanovísk</strong> a začína terminologickým rozlíšením, ktoré má praktický dosah. <em>Fyzická aktivita</em> je akýkoľvek pohyb tela vyvolaný kontrakciou kostrových svalov, ktorý zvyšuje energetický výdaj. <em>Cvičenie</em> je plánovaná, štruktúrovaná a opakovaná forma fyzickej aktivity zameraná na zlepšenie alebo udržanie telesnej zdatnosti. Fyzická inaktivita je nedostatočná úroveň fyzickej aktivity v porovnaní s platnými odporúčaniami – teda modifikovateľný rizikový faktor, nie vlastnosť pacienta.</p>

<p>Z dokumentu vyplýva konkrétny preskripčný rámec:</p>

<div class="table-responsive" role="region" aria-label="Preskripčný rámec cvičenia pri CKD podľa konsenzu Talianskej nefrologickej spoločnosti" tabindex="0">
<table>
<thead>
<tr><th scope="col">Parameter</th><th scope="col">Odporúčanie</th></tr>
</thead>
<tbody>
<tr><th scope="row">Trvanie programu</th><td>najmenej 12 týždňov, aby bol účinný</td></tr>
<tr><th scope="row">Objem</th><td>najmenej 150 minút týždenne podľa kardiovaskulárnej tolerancie</td></tr>
<tr><th scope="row">Intenzita</th><td>začať nízkou a postupne zvyšovať; stredná intenzita = 11 – 13 na 15-bodovej Borgovej škále vnímanej námahy, ≥ 14 = vysoká</td></tr>
<tr><th scope="row">Typ</th><td>aeróbny aj silový tréning; kombinácia oboch prináša najväčší úžitok</td></tr>
<tr><th scope="row">Pred začatím</th><td>posúdenie spôsobilosti: anamnéza, aktuálna liečba, fyzikálne vyšetrenie, EKG, laboratórne vyšetrenia</td></tr>
</tbody>
</table>
</div>

<p>K bezpečnosti dokument uvádza, že v publikovaných štúdiách s tréningom u hemodialyzovaných pacientov neboli hlásené srdcové príhody a že intradialyzačné cvičenie strednej intenzity nevyvolalo nežiaduce príhody vrátane hypotenzie. U príjemcov transplantovanej obličky neboli na základe klinickej skúsenosti zistené významné nežiaduce príhody v súvislosti s pravidelným cvičením, dlhšie sledovania však chýbajú.</p>

<p>Kvantitatívnu oporu dáva cochranovský prehľad Susanne Heiwe a Stefana H. Jacobsona, ktorý zahrnul <strong>45 randomizovaných štúdií s 1 863 účastníkmi</strong> s CKD alebo po transplantácii obličky. Pravidelné cvičenie významne zlepšilo alebo znížilo:</p>

<ul>
  <li>aeróbnu kapacitu (24 štúdií, 847 účastníkov; SMD 0,56; 95 % IS 0,42 – 0,70),</li>
  <li>schopnosť chôdze (7 štúdií, 191 účastníkov; SMD 0,36; 95 % IS 0,06 – 0,65),</li>
  <li>znížilo pokojový systolický tlak o 6,08 mm Hg (9 štúdií, 347 účastníkov; 95 % IS 2,15 – 10,12) a diastolický o 2,32 mm Hg (11 štúdií, 419 účastníkov; 95 % IS 0,59 – 4,05),</li>
  <li>znížilo pokojovú srdcovú frekvenciu a zlepšilo kvalitu života súvisiacu so zdravím.</li>
</ul>

<p>Kvalita dôkazov je zmiešaná: 17 % štúdií bolo hodnotených ako s nízkym rizikom systematickej chyby, 33 % so stredným a <strong>49 % s vysokým</strong>. Veľkosť účinku navyše závisela od dizajnu intervencie, čo je argument pre štruktúrovaný program, nie pre všeobecnú radu „hýbte sa viac“.</p>

<p>KDIGO 2024 formuluje odporúčanie 3.2.2.1 (stupeň 1D): ľuďom s CKD sa odporúča fyzická aktivita strednej intenzity v kumulatívnom trvaní najmenej 150 minút týždenne alebo na úrovni zlučiteľnej s ich kardiovaskulárnou a fyzickou toleranciou. Praktické body dopĺňajú zohľadnenie veku, etnického pozadia, komorbidít a dostupnosti zdrojov, vyhýbanie sa sedavému správaniu a u pacientov so zvýšeným rizikom pádu poradenstvo o intenzite a type cvičenia. Stupeň 1D znamená silné odporúčanie pri veľmi nízkej istote dôkazov – teda odporúčanie, ktoré stojí skôr na pomere prínosu a rizika než na robustných koncových ukazovateľoch.</p>

<h2>Prečo má zmysel kombinovať</h2>

<p>Vláknina a pohyb nezdieľajú len rečnícky rámec „životný štýl“. Zasahujú do prekrývajúceho sa cieľového priestoru: zloženia mikrobioty, funkcie čreva, zápalového prostredia a svalovej rezervy. Praktické dôsledky sú tri.</p>

<p>Po prvé, vláknina sa nasadzuje pre črevnú pasáž, bariéru a metabolické prostredie, nie ako nefroprotektívum. Po druhé, pohyb sa nasadzuje pre svalovú funkciu a toleranciu záťaže, čo spätne podporuje dlhodobé dodržiavanie celého liečebného plánu vrátane diétnych zmien. Po tretie, obe intervencie treba nastaviť tak, aby nezhoršovali gastrointestinálnu toleranciu a aby sa minimalizovalo nutričné riziko – u pacienta s proteínovo-energetickým chradnutím môže objemná strava s vysokým obsahom vlákniny vytlačiť energeticky hodnotnejšie jedlo.</p>

<h2>Praktický postup v ambulancii</h2>

<p>Pred úpravou stravy má zmysel zistiť aspoň orientačne aktuálny príjem vlákniny a kvalitu diéty, výskyt a závažnosť zápchy, dynamiku kálemie a fosfatémie, nutričný stav a riziko proteínovo-energetického chradnutia a doterajšiu gastrointestinálnu toleranciu.</p>

<p>Pri navyšovaní vlákniny sa osvedčuje postupnosť: rozdeliť príjem do menších dávok počas dňa, uprednostniť zdroje, ktoré znesú kuchynskú úpravu znižujúcu obsah draslíka, a sledovať kálemiu v dynamike, nie jednorazovo. KDIGO odporúča zapojiť renálneho dietológa alebo akreditovaného poskytovateľa nutričnej starostlivosti; Su a spol. to uvádzajú rovnako.</p>

<p>Pri pohybe je prvým krokom posúdenie spôsobilosti vrátane EKG, nie samotný tréningový plán. Cieľom je 150 minút strednej intenzity týždenne, ale u krehkého pacienta je zmysluplnejším východiskovým cieľom skrátenie času stráveného v sede a akýkoľvek pravidelný pohyb nad východiskovou úrovňou. Program má trvať najmenej 12 týždňov a kombinovať aeróbnu a silovú zložku.</p>

<p>Pri stanovovaní cieľov je rozumné postupovať v tomto poradí: najprv zápcha, funkčná kapacita a kvalita života; potom metabolické a zápalové ukazovatele; a až nakoniec zmeny, ktoré by mohli súvisieť s uremickými toxínmi. Progresiu CKD medzi očakávané výsledky nezaraďujeme.</p>

<h2>Limity</h2>

<p>Väčšina dôkazov o vláknine pri CKD je krátkodobá, s malými súbormi a s náhradnými ukazovateľmi. Metaanalýza Yang a spol. zahŕňa 292 pacientov v desiatich štúdiách, metaanalýza Wu a spol. 203 pacientov v siedmich prácach – to sú čísla, pri ktorých jediná väčšia štúdia môže súhrnný odhad podstatne posunúť. Heterogenita je vysoká aj preto, že „vláknina“ zastrešuje intervencie s odlišnou rozpustnosťou a fermentovateľnosťou.</p>

<p>Dôkazy pre pohyb sú početnejšie, ale takmer polovica randomizovaných štúdií v cochranovskom prehľade mala vysoké riziko systematickej chyby a zaslepenie je pri cvičebných intervenciách prakticky nemožné. Konsenzus Talianskej nefrologickej spoločnosti je expertný dokument, nie metaanalýza; jeho bezpečnostné stanoviská vychádzajú sčasti z klinickej skúsenosti, čo autori priznávajú. Odporúčanie KDIGO pre 150 minút týždenne má stupeň istoty dôkazov D, teda veľmi nízky.</p>

<p>Ani jedna z citovaných prác nebola zameraná na tvrdé renálne koncové ukazovatele ako primárny výstup. Prenos do slovenských podmienok navyše limituje odlišná skladba stravy a dostupnosť štruktúrovanej rehabilitácie pre nefrologických pacientov.</p>

<hr>

<p><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie, platné odporúčania ani posúdenie spôsobilosti pacienta na cvičenie. Nutričné a pohybové intervencie pri pokročilej CKD patria do rúk tímu, ktorý má k dispozícii aktuálne laboratórne hodnoty pacienta.</em></p>

<div class="pdf-keep-together"><h2>Literatúra</h2><ol>
<li><small><em>Su G, Qin X, Yang C, Sabatino A, Kelly JT, Avesani CM, Carrero JJ. Fiber intake and health in people with chronic kidney disease. Clin Kidney J. 2022;15(2):213–225. doi:10.1093/ckj/sfab169; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8825222/" target="_blank" rel="noopener noreferrer">plný text</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/35145637/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Yang HL, Feng P, Xu Y, Hou YY, Ojo O, Wang XH. The Role of Dietary Fiber Supplementation in Regulating Uremic Toxins in Patients With Chronic Kidney Disease: A Meta-Analysis of Randomized Controlled Trials. J Ren Nutr. 2021;31(5):438–447. doi:10.1053/j.jrn.2020.11.008; <a href="https://pubmed.ncbi.nlm.nih.gov/33741249/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Wu M, Cai X, Lin J, Zhang X, Scott EM, Li X. Association between fibre intake and indoxyl sulphate/P-cresyl sulphate in patients with chronic kidney disease: Meta-analysis and systematic review of experimental studies. Clin Nutr. 2019;38(5):2016–2022. doi:10.1016/j.clnu.2018.09.015; <a href="https://pubmed.ncbi.nlm.nih.gov/30274900/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Krishnamurthy VMR, Wei G, Baird BC, Murtaugh M, Chonchol MB, Raphael KL, Greene T, Beddhu S. High dietary fiber intake is associated with decreased inflammation and all-cause mortality in patients with chronic kidney disease. Kidney Int. 2012;81(3):300–306. doi:10.1038/ki.2011.355; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4704855/" target="_blank" rel="noopener noreferrer">plný text</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/22012132/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Camerotto C, Cupisti A, D'Alessandro C, Muzio F, Gallieni M. Dietary Fiber and Gut Microbiota in Renal Diets. Nutrients. 2019;11(9):2149. doi:10.3390/nu11092149; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6770883/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></small></li>
<li><small><em>Lu CY, Chen YC, Lu YW, Muo CH, Chang RE. Association of Constipation with risk of end-stage renal disease in patients with chronic kidney disease. BMC Nephrol. 2019;20(1):304. doi:10.1186/s12882-019-1481-0; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6683335/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></small></li>
<li><small><em>Battaglia Y, Baciga F, Bulighin F, Amicone M, Mosconi G, Storari A, Brugnano R, Pozzato M, Motta D, D'Alessandro C, Torino C, Mallamaci F, Cupisti A, Aucella F, Capitanini A. Physical activity and exercise in chronic kidney disease: consensus statements from the Physical Exercise Working Group of the Italian Society of Nephrology. J Nephrol. 2024;37(7):1735–1765. doi:10.1007/s40620-024-02049-9; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11519309/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></small></li>
<li><small><em>Heiwe S, Jacobson SH. Exercise training for adults with chronic kidney disease. Cochrane Database Syst Rev. 2011;2011(10):CD003236. doi:10.1002/14651858.CD003236.pub2; <a href="https://pubmed.ncbi.nlm.nih.gov/21975737/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117–S314; <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">plné znenie</a>.</em></small></li>
<li><small><em>Medscape Education. Medscape NOW! Food, Fiber, Fitness: Rethinking Nonpharmacologic Care for Irritable Bowel Syndrome. Vzdelávacia aktivita, 2026; <a href="https://www.medscape.org/viewarticle/medscape-now-food-fiber-fitness-rethinking-nonpharmacologic-2026a10012yp" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></li>
</ol></div>

<p><small><em><strong>Poznámka k dôkazom:</strong> bibliografické údaje všetkých deviatich odborných zdrojov boli overené 20. októbra 2026 cez PubMed a Crossref vrátane úplných autorských zoznamov, ročníkov, čísel a strán. Pri prehľade Su a spol. bol opravený nesprávny citačný údaj z predlohy („Clinical Kidney Journal 2021;2021:169“) na skutočný záznam Clin Kidney J 2022;15(2):213–225. Číselné výsledky metaanalýz a kohortových štúdií sú prevzaté zo štruktúrovaných abstraktov a plných textov; znenie odporúčania 3.2.2.1 a praktických bodov 3.3.1 a 3.11.5.2 je prevzaté priamo zo súhrnu odporúčania KDIGO 2024. Vlastným prínosom textu je kvantifikácia tvrdení, ktoré predloha uvádzala všeobecne, doplnenie oddielu o draslíku a explicitné pomenovanie, že dôkaz o vplyve vlákniny na progresiu CKD nie je slabý, ale chýba. Autorstvo citovanej vzdelávacej aktivity Medscape sa nepodarilo overiť na verejne dostupnej stránke (ochrana proti automatizovanému prístupu), preto je uvedená bez mena autora.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=fibermaxxing-vlaknina-davka-odpoved-ckd">„Fibermaxxing“: vyšší príjem vlákniny prináša úžitok, otázkou je kde a pre koho sa krivka vyrovná</a></li>
  <li><a href="article.php?slug=tmao-crevny-metabolit-uremicky-toxin-ckd">Trimetylamín-N-oxid (TMAO): črevný metabolit ako uremický toxín pri chronickej chorobe obličiek</a></li>
  <li><a href="article.php?slug=kontrola-draslika-ckd-edukovat-nie-strasit">Kontrola draslíka pri ochorení obličiek: edukovať, nie strašiť</a></li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Frailty pri chronickej chorobe obličiek: prečo nestačí sledovať iba eGFR</a></li>
  <li><a href="article.php?slug=rastlinna-strava-nizsia-mortalita-ckd">Rastlinná strava a nižšia mortalita u pacientov s CKD: čo z toho využiť v praxi</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vlaknina-pohyb-ckd-crevna-os-konsenzus_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\nMigrácia článku: {$articles[0]['title']}\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny): $skipped\n";
    echo "Zaradených do fronty avíz: $queuedTotal\n";
    foreach ($errors as $error) {
        echo "Chyba: $error\n";
    }
} else {
    echo '<p>Článok bol spracovaný: ' . htmlspecialchars($articles[0]['title']) . '.</p>';
}
