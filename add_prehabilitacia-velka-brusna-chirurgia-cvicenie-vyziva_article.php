<?php

/**
 * Odborny clanok: prehabilitacia pred velkou brusnou chirurgiou - cvicenie,
 * vyziva, dokazy a nefrologicke suvislosti.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_prehabilitacia-velka-brusna-chirurgia-cvicenie-vyziva_article.php"
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
    'title'        => 'Prehabilitácia pred veľkou brušnou operáciou: komplikácie áno, funkčná kapacita nie',
    'slug'         => 'prehabilitacia-velka-brusna-chirurgia-cvicenie-vyziva',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia PREHAB znížila závažné pooperačné komplikácie takmer na polovicu, no primárny funkčný ukazovateľ nedosiahla. Sieťová metaanalýza 186 štúdií navyše ukazuje, že ťažisko účinku nesie cvičenie a výživa.',
    'content'      => <<<'HTML'
<figure><a href="img/prehabilitacia-velka-brusna-chirurgia-cvicenie-vyziva.webp" rel="noopener noreferrer" target="_blank"><img src="img/prehabilitacia-velka-brusna-chirurgia-cvicenie-vyziva.webp" alt="Dva polopriesvitné trupy v tme: vľavo chladne modrý s vybudovanou svalovou rezervou, vpravo červený pod kužeľom chirurgického svetla, medzi nimi stúpajúce svetelné stĺpce" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna – nie snímka konkrétneho pacienta ani pracoviska. Prehabilitácia buduje rezervu skôr, než príde chirurgický stres.</figcaption></figure>

<p><strong>Prehabilitácia</strong> je cielená príprava pacienta pred plánovaným chirurgickým výkonom: zlepšiť telesnú zdatnosť, nutričný stav a psychickú pripravenosť v týždňoch, ktoré zostávajú do operácie. Myšlienka je intuitívna a podporujú ju dobré fyziologické argumenty. Dôkazy sú však nerovnomerné spôsobom, ktorý sa v prehľadoch často zjednodušuje.</p>

<p>Najcitovanejšia randomizovaná štúdia v tejto oblasti <strong>nedosiahla</strong> svoj primárny funkčný ukazovateľ, hoci výrazne znížila závažné komplikácie. Najväčšia sieťová metaanalýza nezistila prevahu multimodálnych programov nad samotným cvičením. A celá oblasť stojí na dôkazoch s nízkou až veľmi nízkou istotou. To nie je dôvod prehabilitáciu zavrhnúť – je to dôvod hovoriť o nej presne.</p>

<p>Pre nefrológiu má téma dvojitý význam. Pacient s chronickou chorobou obličiek patrí medzi tých, u ktorých je riziko pooperačných komplikácií vyššie, a zároveň je príprava na transplantáciu obličky samostatnou situáciou, kde sa prehabilitácia skúma s vlastnou logikou.</p>

<h2>Čo prehabilitácia zahŕňa</h2>

<p>V intervenčných štúdiách sa opakovane objavujú tie isté štyri zložky: progresívne cvičenie, nutričná intervencia, psychologická podpora a manažment rizík a komorbidít vrátane odvykania od fajčenia, korekcie anémie a riešenia krehkosti. Program PREHAB aj neskoršia holandská celonárodná implementácia používali zhodne vysokointenzívne cvičenie <strong>trikrát týždenne</strong>.</p>

<p>Prehabilitácia nie je náhradou protokolov ERAS (Enhanced Recovery After Surgery), ktoré sa venujú perioperačnému obdobiu – tekutinám, analgézii, mobilizácii, načasovaniu príjmu stravy a minimalizácii invazívnosti. Odporúčania ASCRS a SAGES pre kolorektálnu chirurgiu tento perioperačný rámec definujú; prehabilitácia stojí pred ním, ako príprava na vstup do neho, a má zmysel vtedy, keď je do operácie dosť času.</p>

<h2>PREHAB: čo štúdia naozaj ukázala</h2>

<p>Medzinárodná randomizovaná štúdia PREHAB (Charlotte Johanna Laura Molenaar a spol., <em>JAMA Surgery</em> 2023) zaradila dospelých s nemetastázujúcim kolorektálnym karcinómom vo fakultných nemocniciach s už zavedeným programom ERAS. Štvortýždňový dohliadaný multimodálny program zahŕňal vysokointenzívne cvičenie trikrát týždenne, nutričnú intervenciu, psychologickú podporu a v indikovaných prípadoch odvykanie od fajčenia. Obe ramená dostali štandardnú perioperačnú starostlivosť.</p>

<p>V populácii podľa pôvodného zámeru liečby bolo <strong>251 účastníkov</strong> (medián veku 69 rokov, medzikvartilové rozpätie 60 – 76; 138 mužov, teda 55 %). U 206 (82 %) bol nádor lokalizovaný v hrubom čreve a 234 (93 %) podstúpilo laparoskopický alebo roboticky asistovaný výkon.</p>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky randomizovanej štúdie PREHAB" tabindex="0">
<table>
<thead>
<tr><th scope="col">Ukazovateľ</th><th scope="col">Prehabilitácia</th><th scope="col">Štandardná starostlivosť</th><th scope="col">Efekt</th></tr>
</thead>
<tbody>
<tr><th scope="row">Závažné komplikácie (CCI &gt; 20)</th><td>21/123 (17,1 %)</td><td>38/128 (29,7 %)</td><td>OR 0,47 (95 % IS 0,26 – 0,87); p = 0,02</td></tr>
<tr><th scope="row">Medicínske komplikácie</th><td>19/123 (15,4 %)</td><td>35/128 (27,3 %)</td><td>OR 0,48 (95 % IS 0,26 – 0,89); p = 0,02</td></tr>
<tr><th scope="row">6-minútová chôdza 4 týždne po operácii</th><td colspan="2">rozdiel oproti východiskovému stavu</td><td>+15,6 m (95 % IS −1,4 až 32,6); <strong>p = 0,07</strong></td></tr>
</tbody>
</table>
</div>

<p>Posledný riadok je dôvod, prečo treba byť pri formuláciách opatrný. Zlepšenie šesťminútovej chôdze, jeden z primárnych ukazovateľov, <strong>nebolo štatisticky významné</strong>. Tvrdenie, že PREHAB preukázala zlepšenie funkčnej kapacity, prekračuje to, čo štúdia ukázala. Autori uvádzajú, že sekundárne parametre funkčnej kapacity v pooperačnom období vo všeobecnosti vyzneli v prospech prehabilitácie – to je však slabší typ dôkazu než nesplnený primárny ukazovateľ.</p>

<p>Druhé obmedzenie je rovnako dôležité: štúdia bola <strong>predčasne ukončená pre pandémiu COVID-19</strong>. Zaraďovanie prebiehalo od júna 2017 do decembra 2020, sledovanie sa skončilo v decembri 2021. Predčasné ukončenie znižuje silu štúdie a u štúdií zastavených pri priaznivom priebežnom výsledku systematicky nadhodnocuje veľkosť účinku.</p>

<h2>Sieťová metaanalýza: ťažisko nesie cvičenie a výživa</h2>

<p>Najrozsiahlejší dôkazový prehľad v tejto oblasti pochádza od Daniela I. McIsaaca a spol. (<em>BMJ</em> 2025): systematický prehľad so sieťovou a komponentovou sieťovou metaanalýzou, <strong>186 randomizovaných štúdií a 15 684 účastníkov</strong>.</p>

<p>Pri znížení komplikácií oproti bežnej starostlivosti vyšli najlepšie:</p>

<ul>
  <li>samotné cvičenie: OR 0,50 (95 % IS 0,39 – 0,64),</li>
  <li>samotná nutričná intervencia: OR 0,62 (95 % IS 0,50 – 0,77),</li>
  <li>kombinácia cvičenia, výživy a psychosociálnej zložky: OR 0,64 (95 % IS 0,45 – 0,92).</li>
</ul>

<p>Toto poradie je dôvodom na opatrnosť pri rozšírenom tvrdení, že multimodálny program je účinnejší než jednotlivé zložky. V tejto analýze mal najsilnejší bodový odhad pre komplikácie práve <strong>samotný tréning</strong>, nie kombinácia. Komponentová metaanalýza to potvrdzuje z druhej strany: <em>cvičenie a výživa</em> boli jednotlivé zložky s najvyššou pravdepodobnosťou zlepšenia všetkých kritických ukazovateľov.</p>

<p>Pri dĺžke hospitalizácie skrátila pobyt kombinácia cvičenia a psychosociálnej zložky o 2,44 dňa (95 % IS −3,85 až −1,04), kombinácia cvičenia a výživy o 1,22 dňa (95 % IS −2,54 až 0,10), samotné cvičenie o 0,93 dňa (95 % IS −1,27 až −0,58) a samotná nutričná intervencia o 0,99 dňa (95 % IS −1,49 až −0,48). Kvalitu života súvisiacu so zdravím a fyzické zotavenie najviac zlepšila kombinácia cvičenia, výživy a psychosociálnej zložky: rozdiel 3,48 bodu na fyzickej zložke dotazníka SF-36 (95 % IS 0,82 – 6,14) a 43,43 m v teste šesťminútovej chôdze (95 % IS 5,96 – 80,91).</p>

<p>Istota dôkazov je kľúčový údaj, ktorý sa v prevzatých zhrnutiach spravidla stráca. Pre takmer všetky uvedené porovnania bola podľa prístupu CINeMA hodnotená ako <strong>nízka až veľmi nízka</strong> pre riziko systematickej chyby na úrovni jednotlivých štúdií a pre nepresnosť. Jedinou výnimkou s miernou istotou bol odhad skrátenia hospitalizácie pri kombinácii cvičenia a výživy. Dôležité však je, že výsledky pre cvičebnú a nutričnú prehabilitáciu zostali robustné aj po vylúčení štúdií s vysokým rizikom systematickej chyby.</p>

<h2>Dáta z bežnej praxe: holandská celonárodná implementácia</h2>

<p>Keďže randomizované štúdie v tejto oblasti bývajú malé a selektívne, osobitnú hodnotu má kohortová štúdia Charissy R. Sabajo a spol. (<em>JAMA Surgery</em> 2026) z <strong>18 holandských nemocníc</strong>, ktoré v rokoch 2020 – 2023 zaviedli jednotný multimodálny program u neselektovaných pacientov pred resekciou kolorektálneho karcinómu. Porovnanie s historickými kontrolami z tých istých centier prebehlo s použitím skóre náchylnosti (vek, pohlavie, index telesnej hmotnosti, klasifikácia ASA, typ výkonu a operačný prístup).</p>

<p>Zahrnutých bolo <strong>2 384 pacientov</strong> (priemerný vek 70 rokov, smerodajná odchýlka 11; 1 254 mužov, teda 53 %), po 1 192 v každej skupine.</p>

<div class="table-responsive" role="region" aria-label="Výsledky holandskej celonárodnej implementácie multimodálnej prehabilitácie" tabindex="0">
<table>
<thead>
<tr><th scope="col">Ukazovateľ</th><th scope="col">Prehabilitácia</th><th scope="col">Historická kontrola</th><th scope="col">Efekt</th></tr>
</thead>
<tbody>
<tr><th scope="row">Celkové komplikácie</th><td>356/1 181 (30,1 %)</td><td>446/1 181 (37,8 %)</td><td>OR 0,71 (95 % IS 0,60 – 0,84)</td></tr>
<tr><th scope="row">Medicínske komplikácie</th><td>182/1 181 (15,4 %)</td><td>290/1 181 (24,6 %)</td><td>OR 0,56 (95 % IS 0,46 – 0,69)</td></tr>
<tr><th scope="row">Chirurgické komplikácie</th><td>253/1 181 (21,4 %)</td><td>294/1 181 (24,9 %)</td><td>OR 0,82 (95 % IS 0,68 – 1,00)</td></tr>
<tr><th scope="row">Dĺžka hospitalizácie (medián)</th><td>4 dni (3 – 6)</td><td>5 dní (4 – 8)</td><td>p &lt; 0,001</td></tr>
</tbody>
</table>
</div>

<p>Zníženie výskytu komplikácií sa prejavilo naprieč všetkými podskupinami podľa veku aj klasifikácie ASA a klesli aj miery readmisií a prijatí na jednotku intenzívnej starostlivosti. Je to presvedčivý argument pre uskutočniteľnosť programu v bežnej starostlivosti.</p>

<p>Zásadné obmedzenie však nie je „heterogenita manažmentu“, ale <strong>historické kontroly</strong>. Kontrolné dáta pochádzajú z obdobia od júna 2014 do júna 2023, teda až z deväťročného rozpätia, počas ktorého sa nezávisle od prehabilitácie zlepšovala miniinvazívna technika, anestéziologický manažment aj samotné protokoly ERAS. Skóre náchylnosti vyrovnáva zaznamenané premenné, nie dobový trend. Rozdiel chirurgických komplikácií s horným ohraničením intervalu spoľahlivosti presne na hodnote 1,00 je navyše hraničný. Štúdia preto dokladá súvislosť a uskutočniteľnosť, nie kauzalitu.</p>

<h2>Nutričná časť a kto má z prehabilitácie profitovať</h2>

<p>Nutričné riziko je u chirurgických pacientov časté a spája sa s vyšším rizikom komplikácií. Konsenzuálny dokument výborov pre intenzívnu starostlivosť a geriatrickú traumatológiu Americkej asociácie pre chirurgiu traumy (Michael Steven Farrell a spol.) zdôrazňuje včasné posúdenie nutričného stavu a cielenú intervenciu u rizikových pacientov. Dokument vznikol v kontexte traumatológie a intenzívnej starostlivosti, takže jeho prenos na plánovanú elektívnu brušnú chirurgiu je analógiou, nie priamym odporúčaním.</p>

<p>Najväčší očakávaný prínos majú pacienti, u ktorých je východisková rezerva najmenšia: starší pacienti, pacienti s krehkosťou, s nutričným rizikom alebo malnutríciou, s nízkou východiskovou telesnou výkonnosťou a s významnými komorbiditami. Práve u nich je však najťažšie dosiahnuť dodržiavanie programu, takže rozhodovať treba podľa reálnych bariér, nie podľa teoretickej vhodnosti.</p>

<h2>Nefrologické súvislosti</h2>

<p>Chronická choroba obličiek do tejto témy vstupuje dvoma cestami.</p>

<h3>Perioperačné poškodenie obličiek nie je prechodná epizóda</h3>

<p>Retrospektívna kohorta 3 751 pacientov po veľkej brušnej operácii (Toshiyuki Mizota a spol., <em>Journal of Critical Care</em>) ukázala, že <strong>84 % prípadov pooperačného akútneho poškodenia obličiek bolo prechodných</strong>, teda kreatinín sa vrátil do pásma bez poškodenia do siedmich dní. Napriek tomu mali aj títo pacienti oproti pacientom bez poškodenia obličiek vyššiu jednoročnú úmrtnosť (upravený pomer rizík 2,01; 95 % IS 1,34 – 2,93; p = 0,001) a vyššie riziko progresie chronickej choroby obličiek v priebehu roka (upravený pomer šancí 3,87; 95 % IS 2,12 – 7,08; p &lt; 0,001). Pri pretrvávajúcom poškodení boli hodnoty podstatne vyššie: pomer rizík 6,20 (95 % IS 3,00 – 11,43) a pomer šancí 23,70 (95 % IS 9,64 – 58,22).</p>

<p>Praktický dôsledok: „kreatinín sa upravil“ nie je pri predoperačnej a pooperačnej rozvahe neutrálny nález a pacient po epizóde perioperačného poškodenia obličiek patrí do nefrologického sledovania, nie len do chirurgickej ambulantnej kontroly.</p>

<h3>Príprava kandidáta na transplantáciu obličky</h3>

<p>Prehľad Danielle L. Kirkman (<em>Current Opinion in Organ Transplantation</em> 2025) popisuje situáciu, ktorá sa nefrológa týka priamo. Pacienti s fenotypom telesnej krehkosti majú horšie výsledky transplantácie obličky, a preto bývajú menej často zaradení na čakaciu listinu. Keďže krehkosť je častejšia u starších ako 65 rokov s pokročilou a terminálnou chorobou obličiek, čiastočne tak prispieva k nerovnému prístupu k transplantácii.</p>

<p>Doterajšie malé štúdie prehabilitácie u kandidátov na transplantáciu obličky preukázali uskutočniteľnosť a bezpečnosť a účinok na funkčné náhradné ukazovatele krehkosti. Jedna malá pilotná práca uvádza <strong>50 % skrátenie pooperačnej hospitalizácie</strong> – údaj, ktorý je povzbudivý, ale pochádza z pilotného súboru a sám osebe nie je podkladom pre odporúčanie. Autorka zdôrazňuje, že cvičebná intervencia má byť podporená nutričnou intervenciou zameranou na zvýšenie energetického príjmu a že kľúčom k prijatiu programu je koučing zmeny správania a individuálne zvážená psychologická podpora. Americká aj Európska transplantologická spoločnosť sa zhodujú, že prehabilitácia je hodnotná perioperačná intervencia; na odporúčania založené na dôkazoch sú však potrebné robustné multicentrické randomizované štúdie.</p>

<h3>Čo z toho platí pri pacientovi s CKD pred brušnou operáciou</h3>

<p>Žiadna z citovaných prehabilitačných štúdií nemala renálne koncové ukazovatele ako výstup, preto nasledujúce body sú prenesením všeobecných zásad, nie dôkazom:</p>

<ul>
  <li>včas posúdiť renálne riziko vrátane trendu kreatinínu a albuminúrie, nie jedinej hodnoty,</li>
  <li>cielene zvážiť lieky ovplyvňujúce renálnu perfúziu a ich perioperačné vysadenie alebo ponechanie,</li>
  <li>optimalizovať objemový stav podľa perioperačného protokolu, bez automatického nadmerného tekutinového zaťaženia,</li>
  <li>nutričné ciele vrátane príjmu bielkovín zosúladiť so štádiom CKD; odporúčanie KDIGO 2024 (3.3.1.1, stupeň 2C) uvádza príjem bielkovín 0,8 g/kg telesnej hmotnosti denne u dospelých s CKD G3 – G5, zatiaľ čo predoperačná nutričná príprava smeruje k vyššiemu energetickému a bielkovinovému príjmu – tento rozpor treba vyriešiť individuálne a s nefrológom, nie mlčky,</li>
  <li>pri krehkom pacientovi nespájať nutričnú a cvičebnú zložku automaticky, ale overiť, že zvýšený príjem bielkovín je pri jeho renálnej funkcii a acidobázickom stave únosný.</li>
</ul>

<h2>Limity</h2>

<p>Dôkazový základ prehabilitácie má tri systematické slabiny. Zaslepenie je pri cvičebných a nutričných intervenciách prakticky nemožné, takže subjektívne ukazovatele vrátane kvality života sú zraniteľné. Istota dôkazov je v najväčšom dostupnom prehľade nízka až veľmi nízka pre takmer všetky porovnania. A definície výstupov sa medzi štúdiami líšia natoľko, že porovnateľnosť je obmedzená.</p>

<p>Najsilnejšia randomizovaná štúdia bola predčasne ukončená a svoj funkčný primárny ukazovateľ nedosiahla. Najväčšia observačná štúdia používa historické kontroly z deväťročného obdobia. Nefrologická časť dôkazov je najslabšia: ide o malé pilotné súbory u kandidátov na transplantáciu obličky a o nepriame odvodenie z prác, ktoré renálne ukazovatele nesledovali.</p>

<p>Prenos do slovenských podmienok navyše limituje dostupnosť dohliadaného vysokointenzívneho tréningu a klinickej výživy v predoperačnom okne, ktoré je v onkochirurgii často kratšie než štyri týždne použité v štúdii PREHAB.</p>

<hr>

<p><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie, platné odporúčania ani posúdenie spôsobilosti pacienta na cvičenie. Perioperačná príprava pacienta s chronickou chorobou obličiek patrí do spoločného rozhodovania chirurgického, anestéziologického, nutričného a nefrologického tímu.</em></p>

<div class="pdf-keep-together"><h2>Literatúra</h2><ol>
<li><small><em>Molenaar CJL, Minnella EM, Coca-Martinez M, Ten Cate DWG, Regis M, Awasthi R, Martínez-Palli G, López-Baamonde M, Sebio-Garcia R, Feo CV, van Rooijen SJ, Schreinemakers JMJ, Bojesen RD, Gögenur I, van den Heuvel ER, Carli F, Slooter GD. Effect of Multimodal Prehabilitation on Reducing Postoperative Complications and Enhancing Functional Capacity Following Colorectal Cancer Surgery: The PREHAB Randomized Clinical Trial. JAMA Surg. 2023;158(6):572–581. doi:10.1001/jamasurg.2023.0198; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10061316/" target="_blank" rel="noopener noreferrer">plný text</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/36988937/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>McIsaac DI, Kidd G, Gillis C, Branje K, Al-Bayati M, Baxi A, Grudzinski AL, Boland L, Veroniki AA, Wolfe D, Hutton B. Relative efficacy of prehabilitation interventions and their components: systematic review with network and component network meta-analyses of randomised controlled trials. BMJ. 2025;388:e081164. doi:10.1136/bmj-2024-081164; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11752451/" target="_blank" rel="noopener noreferrer">plný text</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/39843215/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Sabajo CR, Ten Cate DWG, van Grinsven S, Groen LCB, Verdaasdonk EGG, Kerstens SCL, Woltering JJM, Marsman HA, Franssen RFW, Kerst A, Steller EJA, Bastian OW, van 't Hullenaar CDP, Talsma AK, van der Meij W, Inberg B, Marres GMH, Takkenberg M, Geomini LD, Heijmans MHM, Scheltinga MRM, Dekker JWT, van den Heuvel B, Klaase JM, Slooter GD. Nationwide Implementation of Multimodal Prehabilitation and Complications After Colorectal Cancer Surgery. JAMA Surg. 2026;161(7):711–718. doi:10.1001/jamasurg.2026.1519; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13191448/" target="_blank" rel="noopener noreferrer">plný text</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42160080/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Mizota T, Dong L, Takeda C, Shiraki A, Matsukawa S, Shimizu S, Kai S. Transient acute kidney injury after major abdominal surgery increases chronic kidney disease risk and 1-year mortality. J Crit Care. 2019;50:17–22. doi:10.1016/j.jcrc.2018.11.008; <a href="https://pubmed.ncbi.nlm.nih.gov/30469043/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kirkman DL. Frailty in kidney transplant candidates: new therapeutic strategies to intervene. Curr Opin Organ Transplant. 2025;30(2):74–80. doi:10.1097/MOT.0000000000001205; <a href="https://pubmed.ncbi.nlm.nih.gov/39868460/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Farrell MS, Bongiovanni T, Cuschieri J, Egodage T, Elkbuli A, Gelbard R, Jawa R, Mitha S, Nassar AK, Pathak A, Peralta R, Putnam T, Stein DM. Geriatric nutrition in the surgical patient: an American Association for the Surgery of Trauma Critical Care and Geriatric Trauma Committees clinical consensus document. Trauma Surg Acute Care Open. 2025;10(1):e001602. doi:10.1136/tsaco-2024-001602; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11792288/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></small></li>
<li><small><em>Irani JL, Hedrick TL, Miller TE, Lee L, Steinhagen E, Shogan BD, Goldberg JE, Feingold DL, Lightner AL, Paquette IM. Clinical Practice Guidelines for Enhanced Recovery After Colon and Rectal Surgery From the American Society of Colon and Rectal Surgeons and the Society of American Gastrointestinal and Endoscopic Surgeons. Dis Colon Rectum. 2023;66(1):15–40. doi:10.1097/DCR.0000000000002650; <a href="https://pubmed.ncbi.nlm.nih.gov/36515513/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117–S314; <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">plné znenie</a>.</em></small></li>
<li><small><em>Medscape Education. Medscape NOW! Prehabilitation Before Major Abdominal Surgery: Exercise, Nutrition, and Outcomes. Vzdelávacia aktivita, 2026; <a href="https://www.medscape.org/viewarticle/medscape-now-prehabilitation-before-major-abdominal-surgery-2026a10012w8" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></li>
</ol></div>

<p><small><em><strong>Poznámka k dôkazom:</strong> bibliografické údaje všetkých siedmich odborných prác boli overené 20. októbra 2026 cez PubMed a Crossref vrátane úplných autorských zoznamov, ročníkov, čísel a strán; predloha ich neuvádzala. Číselné výsledky pochádzajú zo štruktúrovaných abstraktov. Oproti predlohe boli opravené tri vecné tvrdenia: štúdia PREHAB <em>nedosiahla</em> významné zlepšenie šesťminútovej chôdze (p = 0,07), hoci predloha uvádzala zlepšenie funkčnej kapacity; štúdia bola predčasne ukončená pre pandémiu COVID-19, čo predloha neuvádzala; a sieťová metaanalýza v <em>BMJ</em> nepodporuje tvrdenie, že multimodálny prístup prekonáva izolované zložky – najsilnejší bodový odhad pre komplikácie mal samotný tréning a komponentová analýza vyzdvihla cvičenie a výživu. Doplnená bola istota dôkazov podľa prístupu CINeMA, obmedzenie historických kontrol v holandskej kohorte a nefrologická časť podložená prácami o perioperačnom poškodení obličiek a o príprave kandidátov na transplantáciu obličky; predloha priznávala, že tieto údaje nedohľadala. Dokument Farrell a spol. bol spresnený ako traumatologicko-intenzivistický konsenzus, nie ako všeobecné chirurgické nutričné odporúčanie. Autorstvo citovanej vzdelávacej aktivity Medscape sa nepodarilo overiť na verejne dostupnej stránke (ochrana proti automatizovanému prístupu), preto je uvedená bez mena autora.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=vlaknina-pohyb-ckd-crevna-os-konsenzus">Vláknina a pohyb pri CKD: čo dôkazy skutočne unesú a ako to povedať pacientovi</a></li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Frailty pri chronickej chorobe obličiek: prečo nestačí sledovať iba eGFR</a></li>
  <li><a href="article.php?slug=klinicka-krehkost-cfs-mortalita-dialyza-validacia">Krehkosť hodnotená sestrou predpovedá mortalitu na dialýze: multicentrická validácia škály klinickej krehkosti</a></li>
  <li><a href="article.php?slug=sarkopenia-peritonealna-dialyza-modifikovany-kreatininovy-index">Sarkopénia pri peritoneálnej dialýze: prečo modifikovaný kreatinínový index nestačí</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_prehabilitacia-velka-brusna-chirurgia-cvicenie-vyziva_article',
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
