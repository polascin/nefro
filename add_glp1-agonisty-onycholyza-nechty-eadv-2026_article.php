<?php

/**
 * add_glp1-agonisty-onycholyza-nechty-eadv-2026_article.php
 * GLP-1 receptorove agonisty a onycholyza - studia SCOP-GLP1 prezentovana
 * na kongrese EADV 2026 (Piraccini a spol.), s nefrologickym kontextom.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
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
    'title'        => 'GLP-1 receptorové agonisty a onycholýza: čo skutočne ukázala štúdia z EADV 2026',
    'slug'         => 'glp1-agonisty-onycholyza-nechty-eadv-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Odlúpenie nechtovej platničky bolo u používateľov GLP-1 receptorových agonistov štyrikrát častejšie ako u kontrol. Najsilnejší argument štúdie je však anatomický, nie štatistický – a práve ten rozhoduje, či ide o účinok lieku alebo o následok chudnutia.',
    'content'      => <<<'HTML'
<figure><a href="img/glp1-agonisty-onycholyza-nechty-eadv-2026.webp" rel="noopener noreferrer" target="_blank"><img src="img/glp1-agonisty-onycholyza-nechty-eadv-2026.webp" alt="Detail nechtovej jednotky v tmavej scéne: nechtová platnička sa na distálnom okraji odlupuje od nechtového lôžka, v pozadí svietiaca peptidová špirála a tieň obličky" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna – nejde o snímku konkrétneho pacienta ani o zobrazenie konkrétneho výrobku. Znázorňuje odlúpenie nechtovej platničky od lôžka, teda nález, ktorý sa pri chudnutí typicky neočakáva.</figcaption></figure>

<p class="article-dek"><em>Na kongrese EADV 2026 vo Viedni bola prezentovaná prvá kontrolovaná štúdia nechtových zmien u používateľov GLP-1 receptorových agonistov. Onycholýza bola v nej viac než štyrikrát častejšia než u porovnateľných kontrol. Pre nefrológa to nie je dermatologická kuriozita: semaglutid je dnes liek s preukázaným renoprotektívnym účinkom a predčasné vysadenie pre benígny kožný nález by znamenalo stratu doloženého prínosu pre obličky.</em></p>

<p>Práca bola prezentovaná 1. októbra 2026 v sekcii neskoro zaradených abstraktov (late-breaker) na kongrese European Academy of Dermatology and Venereology (EADV) vo Viedni. Predniesla ju spoluautorka <strong>Bianca Maria Piraccini</strong> z Dermatologickej kliniky Univerzity v Bologni. Ide zatiaľ o kongresový abstrakt, <strong>nie o recenzovanú publikáciu</strong>, a tomu treba prispôsobiť váhu, ktorú jej pripisujeme.</p>

<p>Novosť zistenia potvrdzuje nepriamo aj systematický prehľad dermatologických účinkov GLP-1 receptorových agonistov z roku 2025, ktorý zahrnul 51 štúdií. Katalogizoval reakcie z precitlivenosti, reakcie v mieste vpichu, pruritus, urtikáriu, angioedém a bulózny pemfigoid, ako aj priaznivé účinky pri psoriáze a hidradenitis suppurativa – <strong>nechtové zmeny medzi nimi neboli</strong>.</p>

<h2>Prečo signál o nechtoch patrí aj do nefrologickej ambulancie</h2>

<p>Dôvod nie je v tom, že nefrológ lieči nechty. Je v tom, že nefrológ dnes GLP-1 receptorové agonisty <strong>sám indikuje</strong>.</p>

<p>Randomizovaná štúdia FLOW u 3 533 pacientov s diabetom 2. typu a chronickou chorobou obličiek preukázala, že semaglutid v dávke 1,0 mg týždenne znížil riziko závažných obličkových príhod o 24 % (HR 0,76; 95 % IS 0,66 – 0,88). Priaznivé boli aj všetky potvrdzujúce sekundárne ukazovatele: ročný sklon odhadovanej glomerulovej filtrácie bol miernejší o 1,16 ml/min/1,73 m², riziko závažných kardiovaskulárnych príhod kleslo o 18 % a riziko úmrtia z akejkoľvek príčiny o 20 %. Štúdia bola predčasne ukončená na odporúčanie pri vopred plánovanej priebežnej analýze.</p>

<p>Z toho vyplýva praktický záver, ktorý je v tomto článku dôležitejší než samotné nechty: ak pacient s chronickou chorobou obličiek preruší liečbu pre nepríjemný, ale neškodný nechtový nález, <strong>stratí doložený obličkový a kardiovaskulárny prínos</strong>. Úlohou nefrológa preto nie je nechtovú zmenu prehliadnuť, ale ani z nej urobiť dôvod na vysadenie.</p>

<p>Druhý dôvod je populačný. GLP-1 receptorové agonisty sa pri diabete 2. typu a obezite predpisujú čoraz častejšie, teda práve v skupinách, s ktorými sa nefrológia stretáva denne.</p>

<h2>Čo štúdia zistila</h2>

<p>Multinacionálna štúdia porovnala <strong>575 pacientov</strong> užívajúcich GLP-1 receptorové agonisty s <strong>1 329 kontrolami</strong> s diabetom 2. typu a/alebo obezitou, ktoré tieto lieky nikdy neužívali. Účastníci boli zaradení vo Francúzsku, Spojených štátoch, Brazílii a Mexiku. Priemerné trvanie liečby bolo 18,5 mesiaca.</p>

<div class="table-responsive" role="region" aria-label="Prevalencia nechtových nálezov u používateľov GLP-1 receptorových agonistov a u kontrol" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Nález</th>
        <th scope="col">GLP-1 (n = 575)</th>
        <th scope="col">Kontroly (n = 1 329)</th>
        <th scope="col">p</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Aspoň jedna nechtová zmena</th><td>66,3 %</td><td>52,8 %</td><td>&lt; 0,001</td></tr>
      <tr><th scope="row">Onycholýza</th><td><strong>39,3 %</strong></td><td><strong>8,7 %</strong></td><td>&lt; 0,001</td></tr>
      <tr><th scope="row">Dyschrómia</th><td>45,6 %</td><td>17,0 %</td><td>&lt; 0,001</td></tr>
      <tr><th scope="row">Krehkosť</th><td>58,3 %</td><td>51,1 %</td><td>&lt; 0,005</td></tr>
      <tr><th scope="row">Ryhy a zárezy</th><td>46,8 %</td><td>31,8 %</td><td>&lt; 0,001</td></tr>
      <tr><th scope="row">Nedávny úbytok hmotnosti</th><td>76,3 %</td><td>47,3 %</td><td>&lt; 0,001</td></tr>
    </tbody>
  </table>
</div>

<p>Rozdiely nie sú rovnako presvedčivé. Pri onycholýze a dyschrómii ide o niekoľkonásobok, pri krehkosti o rozdiel 7,2 percentuálneho bodu, ktorý je pri tejto veľkosti vzorky síce štatisticky významný, klinicky však nenápadný. Táto nerovnomernosť je dôležitá – naznačuje, že nejde o plošné zhoršenie stavu nechtov, ale o <strong>špecifický profil nálezov</strong>.</p>

<p>Po obmedzení analýzy iba na pacientov, ktorí schudli, sa rozdiel medzi skupinami zmenšil, ale zostal významný.</p>

<h2>Najsilnejší argument štúdie je anatomický, nie štatistický</h2>

<p>Najzaujímavejšia časť zistenia sa v číslach nenachádza. Formulovala ju Piraccini pri prezentácii: pri rýchlom úbytku hmotnosti sa typicky objavujú zmeny <strong>povrchu nechtovej platničky</strong> – ryhy, zárezy, Beauove línie, teda stopy prechodnej poruchy nechtovej matrix. Onycholýza je však niečo iné: je to <strong>odlúčenie platničky od nechtového lôžka</strong>, teda porucha adhézie, nie tvorby.</p>

<p>Práve preto autori považujú onycholýzu za nález, ktorý sa samotným chudnutím vysvetľuje ťažko, a ktorý by mohol súvisieť priamo s liekom. Je to argument z mechanizmu, nie z p-hodnoty – a je silnejší než ktorékoľvek číslo v tabuľke vyššie, pretože ponúka falzifikovateľnú hypotézu.</p>

<p>Tomu zodpovedá aj to, čo sa so signálom stalo po štatistickej úprave. Po zohľadnení dermatologických ochorení a nutričných deficitov sa sila niektorých asociácií zmenšila, no <strong>onycholýza a dyschrómia zostali približne dvoj- až trojnásobne častejšie</strong>. Pokles z viac než štvornásobku na dvoj- až trojnásobok ukazuje, že časť rozdielu skutočne vysvetľujú sprievodné faktory – a časť nie.</p>

<h2>Sprievodná štúdia: vlasy a pokožka hlavy</h2>

<p>Na rovnakej vzorke prebehla aj sprievodná analýza vlasových a skalpových prejavov. Jej čísla sú v tlačovej správe uvedené zaokrúhlene:</p>

<div class="table-responsive" role="region" aria-label="Prevalencia vlasových a skalpových prejavov u používateľov GLP-1 receptorových agonistov a u kontrol" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Nález</th>
        <th scope="col">GLP-1</th>
        <th scope="col">Kontroly</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Nezvyčajné vypadávanie vlasov</th><td>50 %</td><td>34 %</td></tr>
      <tr><th scope="row">Strata objemu alebo hustoty vlasov</th><td>42 %</td><td>19 %</td></tr>
      <tr><th scope="row">Vypadávanie začínajúce až po začatí liečby</th><td>26 %</td><td>12 %</td></tr>
      <tr><th scope="row">Začervenanie pokožky hlavy</th><td colspan="2">približne trojnásobne častejšie u používateľov</td></tr>
    </tbody>
  </table>
</div>

<p>Klinicky najzaujímavejšie nie je samotné vypadávanie vlasov – to je pri rýchlom chudnutí známy jav (telogénne efluvium). Podstatné je, že vypadávanie sa u používateľov <strong>zriedka vyskytovalo izolovane</strong>: väčšinu prípadov sprevádzali skalpové príznaky ako svrbenie, začervenanie alebo šupinatenie.</p>

<p>Spoluautor Bruno Halioua k tomu uviedol, že zápal pokožky hlavy bol skôr pravidlom než výnimkou, že ho lekári bežne nehľadajú a že môže byť liečiteľný. Ak sa to potvrdí, ide o praktický odkaz: pri sťažnosti na vypadávanie vlasov sa oplatí pozrieť sa na pokožku hlavy, nielen na vlasy.</p>

<h2>Čo signál oslabuje</h2>

<p>Štúdia má viacero obmedzení a časť z nich je závažná.</p>

<p><strong>Približne polovica používateľov udávala nechtové ťažkosti už pred začatím liečby.</strong> To je najvážnejšia výhrada a sama osebe vysvetľuje, prečo nemožno hovoriť o príčinnom vzťahu. Pri prierezovom zbere nie je možné spoľahlivo určiť, čo bolo skôr.</p>

<p><strong>Údaje sú hlásené pacientmi, nie hodnotené dermatológom.</strong> Nechty neboli vyšetrené štandardizovane ani zaslepene. Pacient, ktorý o možných kožných účinkoch lieku počul, si svoje nechty všíma inak než kontrola – ide o klasické skreslenie zisťovania a hlásenia.</p>

<p><strong>Označenie „case-control“ nezodpovedá dizajnu.</strong> Názov abstraktu používa termín case-control, no výber účastníkov prebiehal podľa <strong>expozície</strong> (užívanie GLP-1 receptorového agonistu), nie podľa <strong>výsledku</strong> (prítomnosť nechtovej zmeny). V pravej štúdii prípadov a kontrol je to naopak. Správnejšie je hovoriť o prierezovom porovnaní exponovaných a neexponovaných, ako to robí aj tlačová správa EADV aj odborné spravodajstvo.</p>

<p><strong>Chýba aktívny komparátor.</strong> Shari Lipner, ktorá štúdiu komentovala a na nej sa nepodieľala, označila prácu za generujúcu hypotézu, nie meniacu prax, a upozornila, že nálezy môžu odrážať skreslenie zisťovania a nutričné dôsledky chudnutia, nie toxicitu lieku pre necht. Ako vhodné overenie navrhla prospektívnu kohortovú štúdiu so zaslepeným a objektívnym hodnotením nechtov, s <strong>aktívnymi komparátormi</strong> (inhibítory SGLT2 alebo DPP-4) a s pravidelným nutričným laboratórnym sledovaním. Práve aktívny komparátor by oddelil účinok lieku od účinku liečeného stavu a chudnutia.</p>

<p><strong>Financovanie a konflikty záujmov si zasluhujú zmienku.</strong> Štúdia vznikla s inštitucionálnou podporou laboratórií DUCRAY (skupina Pierre Fabre), ktoré sa špecializujú na dermatologickú a vlasovú kozmetiku – teda spoločnosti pôsobiacej na trhu, ktorý by zo zisteného problému mohol profitovať. Piraccini uviedla grantovú alebo výskumnú podporu od spoločnosti Eli Lilly a honoráre okrem iného od Pierre Fabre/Ducray a Eli Lilly. Lipner neuviedla relevantné konflikty záujmov. Tieto skutočnosti výsledky nevyvracajú, patria však k ich posúdeniu.</p>

<p>Autori sami uvádzajú, že štúdia nemôže preukázať príčinný vzťah, a plánujú prospektívne sledovanie pacientov od začiatku liečby so štandardizovaným dermatologickým vyšetrením a biologickým monitorovaním.</p>

<h2>Diferenciálna diagnostika onycholýzy</h2>

<p>Onycholýza má široký diferenciál a pripísať ju lieku možno až po jeho zvážení. Medzi časté príčiny patria trauma a opakované mikrotraumy, nadmerný kontakt s vodou a dráždivými látkami, nechtová psoriáza, onychomykóza a ďalšie liekové príčiny vrátane fotoonycholýzy.</p>

<p>Osobitne treba myslieť na systémové príčiny. Onycholýza býva opisovaná pri hyperfunkcii štítnej žľazy ako takzvané Plummerove nechty; v publikovanom opise prípadu išlo o 38-ročného muža s onycholýzou pri Gravesovej chorobe. Autori odporúčajú pri nevysvetlenej onycholýze zvážiť vyšetrenie funkcie štítnej žľazy. Ide o jediný opis prípadu, teda o najslabší typ dôkazu, ktorý však upozorňuje na klinicky lacnú a dostupnú diferenciálnu úvahu.</p>

<p>V nefrologickej populácii sa k tomu pridávajú nutričné deficity, ktoré pri chronickej chorobe obličiek nie sú zriedkavé a ktoré rýchly úbytok hmotnosti môže prehĺbiť.</p>

<h2>Praktický postup v nefrologickej ambulancii</h2>

<p>Prehľadové práce o nechtových ochoreniach odporúčajú vyšetriť <strong>všetkých 20 nechtových jednotiek</strong>, nie iba ten necht, na ktorý sa pacient sťažuje, a podľa potreby doplniť dermatoskopiu, zobrazovacie alebo mykologické vyšetrenie. Pre nefrologickú ambulanciu z toho vyplýva nenáročný postup:</p>

<ul>
  <li><strong>Opýtať sa na časový vzťah.</strong> Boli zmeny prítomné už pred začatím liečby, alebo vznikli počas nej? Pri polovici používateľov v štúdii išlo o prvú možnosť.</li>
  <li><strong>Rozlíšiť typ zmeny.</strong> Odlúpenie platničky od lôžka (onycholýza) má iný význam než ryhy a zárezy na povrchu, ktoré pri rýchlom chudnutí očakávame.</li>
  <li><strong>Zdokumentovať rozsah.</strong> Jeden necht alebo viacero; ruky, nohy, alebo oboje.</li>
  <li><strong>Prejsť bežné príčiny.</strong> Trauma, manikúra, vlhké prostredie, dráždivé látky, psoriáza, podozrenie na mykózu.</li>
  <li><strong>Zvážiť vyšetrenie štítnej žľazy</strong> pri nevysvetlenej onycholýze.</li>
  <li><strong>Posúdiť výživu.</strong> Pri rýchlom úbytku hmotnosti zabezpečiť dostatočný príjem bielkovín a mikroživín; u pacienta s chronickou chorobou obličiek v spolupráci s nutričným terapeutom.</li>
  <li><strong>Pri nejasnom, rýchlo progredujúcom alebo asymetrickom náleze odoslať na dermatologické vyšetrenie.</strong> Jednostranná nechtová zmena s pigmentáciou vyžaduje vylúčenie malignity.</li>
</ul>

<p>Pokiaľ ide o komunikáciu s pacientom, stanovisko autorov aj komentujúcej odborníčky je zhodné a strieda sa iba dôraz. Halioua uviedol, že tieto zmeny sú časté, zvyčajne benígne a nie sú dôvodom na prerušenie účinnej liečby z vlastnej iniciatívy pacienta, a že kto si všimne vypadávanie vlasov, svrbiacu či začervenanú pokožku hlavy alebo zmeny nechtov, má to spomenúť lekárovi, nie liečbu vysadiť. Lipner zasa upozornila, aby sme medzi pacientmi nevyvolávali zbytočný strach, a zároveň považuje za rozumné nechtové a vlasové zmeny pri rýchlom chudnutí vopred spomenúť spolu s odporúčaním primeraného príjmu bielkovín a mikroživín.</p>

<p>Pre nefrológa je z toho najdôležitejšie: <strong>nechtový nález nie je indikáciou na vysadenie lieku s preukázaným renoprotektívnym účinkom.</strong></p>

<h2>Limity</h2>

<ul>
  <li>Ide o kongresový abstrakt bez recenzovanej publikácie; číselné údaje pochádzajú z tlačovej správy EADV a z odborného spravodajstva, nie z plného textu.</li>
  <li>Prierezový dizajn a pacientom hlásené prejavy neumožňujú stanoviť príčinný vzťah ani časovú postupnosť.</li>
  <li>Približne polovica používateľov mala nechtové ťažkosti už pred liečbou.</li>
  <li>Chýba zaslepené objektívne hodnotenie nechtov, aktívny komparátor aj nutričné laboratórne sledovanie.</li>
  <li>Nie je uvedené, ktoré konkrétne GLP-1 receptorové agonisty a v akých dávkach pacienti užívali, takže nemožno posúdiť rozdiely medzi liečivami ani vzťah k dávke.</li>
  <li>Údaje pochádzajú zo štyroch krajín mimo strednej Európy a ich prenosnosť na slovenskú populáciu nie je overená.</li>
  <li>Štúdia nebola zameraná na pacientov s chronickou chorobou obličiek; prepojenie na nefrologickú prax je v tomto článku odvodené, nie prevzaté od autorov.</li>
</ul>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie, dermatologické vyšetrenie ani aktuálny súhrn charakteristických vlastností konkrétneho lieku. Pacient nemá liečbu GLP-1 receptorovým agonistom prerušovať bez konzultácie s ošetrujúcim lekárom.</em></p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=glp1-lieky-renalne-benefity-dokazy-prax-nefrologia">Renálne benefity GLP-1 liekov</a> – dôkazový základ pre nefrologickú prax.</li>
  <li><a href="article.php?slug=semaglutid-ckd-porovnanie-glp1-realna-prax">Semaglutid pri CKD v reálnej praxi</a> – porovnanie s ďalšími GLP-1 agonistami.</li>
  <li><a href="article.php?slug=glp1-obezita-vysadenie-dlhodoba-liecba-nefrologicky-pohlad">Vysadenie GLP-1 liečby</a> – prečo má predčasné prerušenie dôsledky.</li>
  <li><a href="article.php?slug=glp1-ischemicka-opticka-neuropatia-naion">GLP-1 a ischemická optická neuropatia</a> – iný bezpečnostný signál a ako ho čítať.</li>
  <li><a href="article.php?slug=prehadzovanie-glp1-agonistov-prakticky-postup-ckd">Prehadzovanie GLP-1 agonistov pri CKD</a> – praktický postup pri zmene liečiva.</li>
  <li><a href="article.php?slug=semaglutid-wernickeho-encefalopatia-deficit-tiaminu">Semaglutid a deficit tiamínu</a> – nutričné riziká rýchleho chudnutia.</li>
  <li><a href="article.php?slug=farmakologicka-liecba-obezity-pokrocile-ckd-dialyza">Farmakologická liečba obezity pri pokročilej CKD</a> – vrátane dialyzovaných pacientov.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Bianca Maria Piraccini, Valérie Mengeaud, Virginie Ribet, Anne Couttet, Núria Perez Cullell, Charles Taïeb, Bruno Halioua.</strong> <em>Association between GLP-1 receptor agonists and nail disorders: Results from a multinational case-control study.</em> EADV Congress 2026, Viedeň, 30. septembra – 3. októbra 2026 (kongresový abstrakt, sekcia late-breaker).</li>
  <li><strong>European Academy of Dermatology and Venereology.</strong> <em>Nail detachment over four times more common among GLP-1 users, first controlled study finds.</em> Tlačová správa, 1. októbra 2026. <a href="https://eadv.org/wp-content/uploads/2026/09/EADV_2026_Bruno_GLP1_Press_Release_01_10.pdf" target="_blank" rel="noopener noreferrer">Text tlačovej správy (PDF)</a>.</li>
  <li><strong>Scott Harris.</strong> <em>GLP-1s Linked to Nail Detachment and Other Disorders in New Study.</em> Medscape Medical News, 9. októbra 2026. <a href="https://www.medscape.com/viewarticle/glp-1s-linked-nail-detachment-and-other-disorders-new-study-2026a10011ym" target="_blank" rel="noopener noreferrer">Text správy</a>.</li>
  <li><strong>Bruno Halioua, Charles Taïeb, Anne Couttet, Núria Perez Cullell, Virginie Ribet, Valérie Mengeaud, Bianca Maria Piraccini.</strong> <em>Association between GLP-1 receptor agonists and scalp involvement: Results from a multinational case-control study.</em> EADV Congress 2026, Viedeň (kongresový abstrakt).</li>
  <li><strong>Vlado Perkovic, Katherine R. Tuttle, Peter Rossing, Kenneth W. Mahaffey, Johannes F. E. Mann, George Bakris a spol. (FLOW).</strong> <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes.</em> New England Journal of Medicine. 2024;391(2):109–121. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Calista Persson, Allison Eaton, Harvey N. Mayrovitz.</strong> <em>A Closer Look at the Dermatological Profile of GLP-1 Agonists.</em> Diseases. 2025;13(5):127. <a href="https://doi.org/10.3390/diseases13050127" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12110338/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Debra K. Lee, Shari R. Lipner.</strong> <em>Optimal diagnosis and management of common nail disorders.</em> Annals of Medicine. 2022;54(1):694–712. <a href="https://doi.org/10.1080/07853890.2022.2044511" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8896184/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Archana Singal, Rahul Arora.</strong> <em>Nail as a window of systemic diseases.</em> Indian Dermatology Online Journal. 2015;6(2):67–74. <a href="https://doi.org/10.4103/2229-5178.153002" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4375768/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Malumani Malan, Zhe Dai, Wu Jianbo, Song Ji Quan.</strong> <em>Onycholysis an early indicator of thyroid disease.</em> Pan African Medical Journal. 2019;32:31. <a href="https://doi.org/10.11604/pamj.2019.32.31.17653" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6522173/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Piaopiao Li, Jithin S. Varghese, Megha K. Shah, Rodolfo J. Galindo, Francisco J. Pasquel, Mohammed K. Ali, Hui Shao.</strong> <em>Prescribing Trends of Glucagon-Like Peptide 1 Receptor Agonists for Type 2 Diabetes or Obesity.</em> JAMA Network Open. 2025;8(10):e2540890. <a href="https://doi.org/10.1001/jamanetworkopen.2025.40890" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Číselné údaje o nechtových nálezoch (575 oproti 1 329 účastníkom, 18,5 mesiaca, 66,3/52,8 %, 39,3/8,7 %, 45,6/17,0 %, 58,3/51,1 %, 46,8/31,8 %, 76,3/47,3 %) boli overené proti pôvodnému spravodajstvu Medscape z prezentácie na kongrese; zaokrúhlené údaje o vlasoch a pokožke hlavy, krajiny zaradenia, údaj o polovici používateľov s nechtovými ťažkosťami pred liečbou, zachovanie dvoj- až trojnásobku po úprave, financovanie laboratóriami DUCRAY a úplný autorský zoznam oboch abstraktov pochádzajú z overenej tlačovej správy EADV. Bibliografia prác citovaných v tomto článku bola overená cez PubMed a Crossref vrátane úplných mien autorov, ročníka, čísla, strán a DOI. <strong>Opravy oproti pôvodnej predlohe:</strong> v citácii práce o onycholýze pri chorobe štítnej žľazy bolo nesprávne poradie autorov (prvým autorom je Malumani Malan, nie Zhe Dai) a chybne uvedené meno tretieho autora; ide o opis jedného prípadu, nie o štúdiu. Pri práci Singalovej a Aroru chýbal rok, ročník, číslo aj strany. Predloha uvádzala, že analýzy boli upravené na vek, pohlavie a komorbidity so zachovaním významnosti – podľa tlačovej správy sa úprava týkala aj dermatologických ochorení a nutričných deficitov a silu asociácií znížila z viac než štvornásobku na dvoj- až trojnásobok. Predloha neuvádzala, že približne polovica používateľov mala nechtové ťažkosti už pred liečbou, ani zdroj financovania štúdie a konflikty záujmov. <strong>Vlastným odborným spracovaním</strong> je prepojenie na štúdiu FLOW a na nefrologickú indikáciu GLP-1 receptorových agonistov, výhrada k označeniu dizajnu ako „case-control“, zdôraznenie anatomického rozdielu medzi poruchou adhézie a poruchou tvorby nechtovej platničky, poznámka o chýbajúcom aktívnom komparátore a celý praktický postup pre ambulanciu.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_glp1-agonisty-onycholyza-nechty-eadv-2026_article',
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
