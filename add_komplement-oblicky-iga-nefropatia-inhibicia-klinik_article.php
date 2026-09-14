<?php
/**
 * add_komplement-oblicky-iga-nefropatia-inhibicia-klinik_article.php
 * Spracovanie: Thurman JM, Poppelaars F. Complement in Kidney Disease: Core Curriculum 2026.
 * Am J Kidney Dis. doi:10.1053/j.ajkd.2026.06.008 (PMID 42726032).
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
    'title'        => 'Komplement v nefrológii: diagnostika, infekčné riziko a cielená inhibícia pri IgA nefropatii',
    'slug'         => 'komplement-oblicky-iga-nefropatia-inhibicia-klinik',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický prehľad diagnostiky komplementu (C3/C4, CH50/AH50, limity), infekčného rizika a očkovania pred inhibíciou a cieľovej liečby pri IgA nefropatii — od iptakopanu po negatívnu fázu III s narsoplimabom.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Komplement už nie je len laboratórny „sprievodný jav“ pri glomerulonefritídach. Pri IgA nefropatii je alternatívna dráha kľúčovým amplifikačným uzlom, histologické a genetické markery pomáhajú stratifikovať riziko a schválené inhibítory menia prax — no vyžadujú disciplínu v diagnostike, očkovaní a výbere správnej dráhy.</em></p>

<p>Komplementový systém je súčasťou vrodenej imunity a chráni pred infekciou. Nadmerná alebo nevhodná aktivácia však prispieva k obličkovému zápalu pri viacerých ochoreniach. Podľa prehľadu <em>Core Curriculum 2026</em> v <em>American Journal of Kidney Diseases</em> (Thurman, Poppelaars) už Úrad pre kontrolu potravín a liekov (FDA) schválil komplementové inhibítory pre päť renálnych indikácií — atypický hemolyticko-uremický syndróm (aHUS), komplement 3 glomerulopatiu (C3G), primárnu imunokomplexovú membranoproliferatívnu glomerulonefritídu (IC-MPGN), ANCA-asociovanú vaskulitídu a IgA nefropatiu. Väčšina imunosupresív komplement priamo neblokuje; preto sa očakáva ďalšie rozširovanie indikácií. Pre nefrológa z toho vyplýva nová disciplína: diagnostika aktivity, manažment infekčného rizika a správne cielenie mechanizmu.</p>

<h2>Tri roviny uvažovania, ktoré sa v praxi často miešajú</h2>

<ol>
  <li><strong>Systémová versus lokálna aktivita</strong> — pokles plazmatického C3/C4 môže naznačovať spotrebu, ale nie je univerzálnym „snímačom“ aktivity v obličke. Patologická aktivácia v glomerule môže prebiehať bez merateľnej zmeny v plazme.</li>
  <li><strong>Aktivácia v tkanive versus produkcia biomarkerov</strong> — fragmenty a funkčné testy ovplyvňuje spracovanie vzorky, akútna fáza, pečeňová syntéza a iné ochorenia.</li>
  <li><strong>Nesprávne cielenie dráhy versus nesprávna selekcia pacienta</strong> — ak inhibujete dráhu, ktorá u daného pacienta nie je dominantná, účinok môže chýbať aj pri biologicky relevantnej úlohe komplementu v chorobe ako celku.</li>
</ol>

<h2>Tri dráhy aktivácie</h2>

<ul>
  <li><strong>Klasická dráha</strong> — typicky imunitný komplex (C1q, C4, C2),</li>
  <li><strong>Lektínová dráha</strong> — rozpoznanie cukrových vzorov (mannózovo viažuci lektín, MBL; MASP-1/2),</li>
  <li><strong>Alternatívna dráha (AP)</strong> — spontánna „tick-over“ aktivácia C3 cez faktor B a properdin; slúži ako amplifikačný okruh bez ohľadu na počiatočnú cestu.</li>
</ul>

<p>Pri IgA nefropatii sa v biopsii bežne nachádza IgA spolu s C3, zatiaľ čo C1q chýba — čo poukazuje skôr na alternatívnu a/alebo lektínovú než klasickú dráhu. Alternatívna dráha sa považuje za <strong>dominantný amplifikačný mechanizmus</strong> po ukladaní patogénnych IgA imunitných komplexov v mezangiu. To nevylučuje prínos lektínovej dráhy u podskupiny pacientov, ale vysvetľuje, prečo inhibícia faktora B (iptakopan) priniesla klinicky overený prínos, zatiaľ čo čistá lektínová stratégia vo fáze III zatiaľ nie.</p>

<h2>Diagnostika komplementu: čo má zmysel a čo sú limity</h2>

<h3>Plazmatické C3 a C4</h3>

<p>Koncentrácie C3 a C4 sú užitočné, ale <strong>nie dostatočné</strong> na posúdenie aktivity v obličke:</p>

<ul>
  <li>pri imunokomplexových ochoreniach často klesajú <strong>obe</strong> hodnoty,</li>
  <li>pri chorobách s dominanciou alternatívnej dráhy môže C4 zostať typicky v norme,</li>
  <li>pokles môžu napodobniť aj iné stavy (sepsa, ateroembolická choroba, pankreatitída, HIV), zlyhaná syntéza pri chronickej chorobe pečene alebo malnutrícii; spotrebu môže maskovať akútna fáza a tehotenstvo.</li>
</ul>

<p><strong>Zásadné poučenie:</strong> normálne sérové C3/C4 <strong>nevylučujú</strong> lokálnu aktiváciu v glomerule. Naopak, izolovaný pokles C3 bez renálneho ochorenia môže byť sekundárny. Výsledky vždy prepojte s klinickým a histologickým obrazom.</p>

<h3>Aktivačné fragmenty (C3a, C4a, C5a, Bb, sC5b-9)</h3>

<p>Fragmenty sú často citlivejšie na aktiváciu než intaktné proteíny, no sú citlivé na spracovanie vzorky a ako rutinný rozhodovací parameter ešte nie sú dostatočne validované. V štúdiách s iptakopanom klesol plazmatický sC5b-9 — to podporuje farmakodynamický efekt, nie však univerzálny ambulantný algoritmus. Mimo jasného protokolu ich berte ako pomocnú informáciu.</p>

<h3>CH50 a AH50: funkčné testy a farmakodynamika</h3>

<p><strong>CH50</strong> meria hemolytickú kapacitu klasickej (a terminálnej) dráhy, <strong>AH50</strong> alternatívnej. Sú užitočné na posúdenie funkčného dopadu a na monitorovanie inhibície. Pri adekvátnej blokáde C5 (napr. ekulizumab) sa očakáva výrazný pokles CH50 — v praxi sa za cieľ často berie CH50 blízko nule až pod približne 10 % normy, podľa lokálneho protokolu a laboratória. AH50 dopĺňa pohľad na alternatívnu dráhu. Interpretácia vyžaduje znalosť metódy a času odberu voči dávke.</p>

<h3>Genetika a autoprotilátky</h3>

<p>Genetické vyšetrenie a autoprotilátky (napr. proti faktoru H) pomáhajú pri aHUS, C3G a podozrení na dysreguláciu AP. Výsledky môžu trvať dni až týždne — pri akútnych TMA sa liečba často začína klinicky ešte pred dostupnosťou genetiky.</p>

<h3>Tkanivové vyšetrenie</h3>

<p>Imunofluorescenčné značenie (C3c, C1q, prípadne C4d/MBL) je najbližšie k dôkazu lokálnej aktivity. Prítomnosť C3 fragmentov v glomerulárnych depozitoch odráža aktiváciu v obličke. C4d v natívnej obličke nie je rutina v každom centre a nemusí spoľahlivo odrážať klasickú dráhu v glomerule — pri IgA nefropatii skôr signalizuje lektínovú/klasickú aktiváciu a horšiu prognózu (pozri nižšie).</p>

<div class="table-responsive" role="region" aria-label="Prehľad diagnostiky komplementu" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Vyšetrenie</th>
        <th scope="col">Čo ukazuje</th>
        <th scope="col">Hlavný limit</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Sérové C3, C4</th>
        <td>Spotreba / typ aktivácie</td>
        <td>Nemusia zachytiť lokálnu aktiváciu v obličke</td>
      </tr>
      <tr>
        <th scope="row">Fragmenty (sC5b-9, C3a…)</th>
        <td>Citlivejší signál aktivácie</td>
        <td>Preanalytika; nie rutinný rozhodovací parameter</td>
      </tr>
      <tr>
        <th scope="row">CH50 / AH50</th>
        <td>Funkčná kapacita dráh; PD pri inhibícii</td>
        <td>Metóda, timing voči dávke, lokálne cut-offy</td>
      </tr>
      <tr>
        <th scope="row">Biopsia (C3, C4d)</th>
        <td>Lokálna aktivácia a fenotyp</td>
        <td>C4d nie je všade rutina; nie automatická voľba lieku</td>
      </tr>
      <tr>
        <th scope="row">Genetika / anti-FH</th>
        <td>Dysregulácia AP (aHUS, C3G)</td>
        <td>Oneskorenie výsledkov</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Stručný vizuálny prehľad dráh je aj v <a href="article.php?slug=cheatsheet-komplement">cheatsheete o komplemente</a>.</p>

<h2>Infekčné riziko a prevencia pred inhibíciou</h2>

<p>Komplement je ochranný systém. Jeho inhibícia — najmä terminálnej dráhy (C5 / C5b-9) — zvyšuje riziko závažných infekcií, predovšetkým meningokokových. Pred začatím liečby Core Curriculum zdôrazňuje: optimalizovať podpornú liečbu, zhodnotiť aktivitu ochorenia a posúdiť, či už nejde o ireverzibilné poškodenie.</p>

<ul>
  <li><strong>Očkovanie je povinné</strong> pred väčšinou anti-komplementových liekov: meningokok (séroskupiny A, C, W, Y a B), pneumokok a <em>Haemophilus influenzae</em> typu b (Hib).</li>
  <li>Ideálne aspoň <strong>2 týždne pred začiatkom</strong>; ak to nie je možné, zvážiť antibiotickú profylaxiu do vytvorenia imunity (a podľa lokálnych odporúčaní aj počas liečby).</li>
  <li><strong>Očkovanie riziko nevylúči.</strong> McNamara a kol. (MMWR 2017) zdokumentovali 16 prípadov invazívnej meningokokovej infekcie u príjemcov ekulizumabu v USA (2008–2016); 14 malo aspoň jednu dávku meningokokovej vakcíny pred ochorením — často išlo o neskupinové (nongroupable) kmene. Preto je nevyhnutná edukácia pacienta, včasné vyhľadanie starostlivosti a rýchla liečba pri podozrení.</li>
  <li>V didaktických textoch sa často uvádza odhad rádovo okolo <strong>0,5 % ročne</strong> aj u očkovaných pacientov na ekulizumabe; rozsiahla farmakovigilancia (Socié a kol., 2019) hlásila približne <strong>0,25 prípadu na 100 pacientorokov</strong>. Rádová veľkosť rizika ostáva klinicky relevantná.</li>
</ul>

<h2>IgA nefropatia: biomarkery a dominantná dráha</h2>

<h3>C3 a C4d v histológii</h3>

<p>Rutinná imunofluorescencia ukazuje dominantné alebo spoludominantné IgA depozity. <strong>C3 sa nachádza vo väčšine biopsií</strong> — v prehľadnej literatúre v približne &gt; 90 % prípadov; prítomnosť C3 pomáha odlíšiť klinicky relevantnú IgA nefropatiu od subklinického mezangiálneho IgA. Absencia C1q pri prítomnosti C3 podporuje aktiváciu mimo klasickej dráhy.</p>

<p><strong>C4d</strong> (marker aktivácie lektínovej a/alebo klasickej dráhy) sa nachádza približne u <strong>jednej tretiny</strong> pacientov (v kohortách často 30–45 %). C4d-pozitívni majú v štúdiách horšiu renálnu prognózu aj v skorších štádiách; ide o asociáciu a stratifikačný signál, nie automatický dôkaz, že C4d je jediný terapeutický cieľ. <strong>Neexistuje validovaný algoritmus</strong>, ktorý by podľa C4d automaticky určil typ komplementovej inhibície.</p>

<h3>CFHR a alternatívna dráha</h3>

<p>Genomové asociačné štúdie identifikovali pri IgA nefropatii lokus s génmi <strong>CFHR1 a CFHR3</strong>. Ich delecia je spojená s nižším rizikom ochorenia — produkty týchto génov konkurujú faktoru H pri regulácii AP; pri ich absencii môže byť komplement lepšie brzdený. Genetické a biopsijné údaje spolu podporujú dominanciu alternatívnej dráhy s možným podielom lektínovej dráhy v podskupine.</p>

<div class="table-responsive" role="region" aria-label="Komplementové markery pri IgA nefropatii" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Marker</th>
        <th scope="col">Význam</th>
        <th scope="col">Praktická poznámka</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">C3 v biopsii</th>
        <td>Veľmi častý nález (&gt; 90 % v review)</td>
        <td>Rozlišuje klinickú IgAN od subklinického IgA</td>
      </tr>
      <tr>
        <th scope="row">C4d v biopsii</th>
        <td>~1/3 pacientov; horšia prognóza</td>
        <td>Nezávislý prediktor v štúdiách; zatiaľ bez štandardizovanej terapeutickej voľby</td>
      </tr>
      <tr>
        <th scope="row">Properdin, faktor B</th>
        <td>Alternatívna dráha v tkanive</td>
        <td>Podporuje cielenú inhibíciu AP</td>
      </tr>
      <tr>
        <th scope="row">CFHR1/3 delecia</th>
        <td>Genetická ochrana</td>
        <td>Prepojenie AP a rizika IgAN</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Iptakopan — inhibícia faktora B (APPLAUSE-IgAN)</h2>

<p>Iptakopan je perorálny selektívny inhibítor faktora B. Vo fáze III <strong>APPLAUSE-IgAN</strong> (NCT04578834) u dospelých s biopsiou potvrdenou IgA nefropatiou a proteinúriou ≥ 1 g/g napriek podpornej liečbe:</p>

<ul>
  <li><strong>Deväťmesačná interim analýza</strong> (NEJM 2024/2025; prvých 250 pacientov): upravený geometrický priemer 24-hodinového UPCR bol o <strong>38,3 %</strong> nižší pri iptakopane oproti placebu (95 % IS 26,0–48,6; p &lt; 0,001). Na tomto výsledku — <strong>redukcii proteinúrie</strong> — FDA udelila <strong>urýchlené schválenie 7.–8. augusta 2024</strong> (Fabhalta) na zníženie proteinúrie u dospelých s primárnou IgA nefropatiou v riziku progresie. V tom čase <strong>ešte nebol preukázaný</strong> účinok na pokles eGFR; ten bol naplánovaný na 24 mesiacov. (Nesprávne je tvrdiť, že schválenie vychádzalo zo spomalenia poklesu funkcie už v 9-mesačnom interim.)</li>
  <li><strong>Konečná 24-mesačná analýza</strong> (NEJM 2026): anualizovaný sklon eGFR −3,10 oproti −6,12 ml/min/1,73 m²/rok (rozdiel 3,02; upravené p &lt; 0,001); kombinovaný renálny ukazovateľ 21,4 % oproti 33,5 % (HR 0,57). Závažné infekcie boli častejšie (6,7 % oproti 2,1 %).</li>
</ul>

<p>Detailné čísla sú v samostatnom článku o <a href="article.php?slug=iptakopan-iga-nefropatia-applause-igan-24-mesiacov">APPLAUSE-IgAN</a>.</p>

<p>Pri IgA nefropatii je mechanisticky dôraz na <strong>proximálnu blokádu alternatívnej dráhy</strong>. Terminálna blokáda C5 (ekulizumab a pod.) má indikačné miesto pri iných komplementových nefropatiách (napr. <a href="article.php?slug=c3-glomerulopatia-c3g-liecba-inhibicia-komplementu">C3G</a>), no nezastaví upstream hyperaktiváciu AP — preto iptakopan cielí faktor B.</p>

<h2>Lektínová dráha: negatívna fáza III (ARTEMIS-IGAN)</h2>

<p><strong>Narsoplimab</strong> (protilátka proti MASP-2) inhibuje lektínovú dráhu. Vo fáze II sa pozorovalo zníženie proteinúrie; vo fáze III <strong>ARTEMIS-IGAN</strong> (NCT03608033) však liek <strong>nedosiahol štatistickú významnosť</strong> v primárnom cieli (redukcia 24-hodinovej proteinúrie po 36 týždňoch oproti placebu). V placebovom ramene bol paradoxne veľký pokles proteinúrie; sponzor skúšku ukončil a nepodal žiadosti o schválenie v tejto indikácii.</p>

<p>Didaktické ponaučenie z Core Curriculum: keďže len približne tretina pacientov má C4d+ (pravdepodobne výraznejšiu lektínovú aktiváciu) a skúška <strong>nevyberala podľa C4d ani biomarkerov</strong>, negatívny výsledok v nemarkovanej populácii nevyvracia hypotézu — skôr ukazuje, že budúce skúšky lektínovej dráhy potrebujú enrichment podľa histológie alebo biomarkerov.</p>

<h2>Kombinácie s inými liekmi: logika a limity</h2>

<p>Komplementové inhibítory cielia najmä glomerulárny zápal a downstream mediáciu poškodenia. Mechanisticky je logické kombinovať ich s liekmi, ktoré zasahujú upstream alebo iné uzly:</p>

<div class="table-responsive" role="region" aria-label="Kombinačné koncepty pri IgA nefropatii" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Liek / skupina</th>
        <th scope="col">Mechanizmus</th>
        <th scope="col">Vzťah ku komplementu</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Budesonid s cieleným uvoľňovaním (Nefecon)</th>
        <td>Lokálna imunosupresia v ileálnom Peyerovom patchi; menej patogénneho IgA1</td>
        <td>Nepriama — menej substrátu pre komplexy a aktiváciu</td>
      </tr>
      <tr>
        <th scope="row">Sibeprenlimab</th>
        <td>Inhibícia APRIL; menej galaktózovo deficitného IgA1</td>
        <td>Nepriama — fáza III VISIONARY: −51,2 % proteinúrie oproti placebu v 9 mesiacoch</td>
      </tr>
      <tr>
        <th scope="row">Sparsentan (+ SGLT2i)</th>
        <td>Duálna blokáda endotelínu/angiotenzínu</td>
        <td>Nepriama — hemodynamická nefroprotekcia; racionálna kombinácia</td>
      </tr>
      <tr>
        <th scope="row">Iptakopan</th>
        <td>Inhibícia faktora B (AP)</td>
        <td>Priama — schválenie na proteinúriu; 24-mesačný prínos na eGFR</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Lieky znižujúce produkciu galaktózovo deficitného IgA môžu časom znížiť downstream aktiváciu komplementu — dodatočný prínos komplementovej inhibície potom môže byť ťažšie odlíšiť len podľa proteinúrie. Randomizované dáta o pevných kombináciách zatiaľ chýbajú. Súbežná komplementová blokáda s inými imunomodulátormi vyžaduje osobitnú opatrnosť kvôli infekciám. K sparsentanu pozri aj <a href="article.php?slug=sparsentan-sglt2-inhibitor-iga-nefropatia-spartacus-protect">SPARTACUS / PROTECT</a>.</p>

<h2>Praktický checklist pred a počas inhibície</h2>

<ol>
  <li><strong>Je ochorenie komplementom mediované?</strong> — diagnóza, biopsia, relevantné biomarkery.</li>
  <li><strong>Je aktívna infekcia?</strong> — pred nasadením riešiť alebo aspoň stabilizovať.</li>
  <li><strong>Je pacient očkovaný v správnom čase?</strong> — meningokok (A, C, W, Y a B), pneumokok, Hib; ideálne ≥ 2 týždne pred začiatkom, inak antibiotická profylaxia podľa protokolu.</li>
  <li><strong>Aký je plán monitorovania?</strong> — proteinúria, eGFR, klinická aktivita; pri C5 inhibícii podľa dostupnosti CH50/AH50 alebo hladiny lieku.</li>
  <li><strong>Má ešte zmysel inhibovať?</strong> — posúdiť, či už neprevažuje ireverzibilné poškodenie.</li>
  <li><strong>Neprekladať proteinúriu na tvrdý endpoint</strong> — urýchlené schválenie iptakopanu vychádzalo z 9-mesačnej proteinúrie; prínos na eGFR vyžadoval 24-mesačné dáta.</li>
</ol>

<p>Podpornú liečbu a stratifikáciu rizika podľa KDIGO 2025 nájdete v článku o <a href="article.php?slug=iga-nefropatia-kdigo-2025-kdoqi">IgA nefropatii</a>.</p>

<h2>Obmedzenia a opatrná interpretácia</h2>

<ul>
  <li>Plný text <em>Core Curriculum 2026</em> je za paywallom vydavateľa; tento prehľad vychádza z PubMed abstraktu, otvorených sekundárnych zdrojov a overiteľných klinických dát citovaných nižšie.</li>
  <li>Presné percento C3+ biopsií sa líši podľa kohorty; „&gt; 90 %“ je konsenzus z review literatúry.</li>
  <li>C4d prognostický význam neznamená, že každý C4d+ pacient potrebuje lektínovú inhibíciu.</li>
  <li>Regulačný status liekov sa môže líšiť medzi USA, EÚ a Slovenskom.</li>
</ul>

<h2>Záver</h2>

<p>Komplement v nefrológii vyžaduje tri veci naraz: rozlíšiť systémovú a lokálnu aktivitu, rešpektovať infekčné riziko (očkovanie nevylučuje meningokokovú infekciu) a cieľiť správnu dráhu. Pri IgA nefropatii je alternatívna dráha mechanisticky centrálna — iptakopan znížil proteinúriu (základ FDA schválenia v auguste 2024) a po 24 mesiacoch spomalil pokles eGFR. Lektínová dráha je relevantná u C4d+ podskupiny, no fáza III s narsoplimabom bez enrichmentu skončila negatívne. Diagnostika (C3/C4, CH50/AH50, biopsia) má limity; checklist pred inhibíciou by mal byť rutina.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=iptakopan-iga-nefropatia-applause-igan-24-mesiacov">Iptakopan a APPLAUSE-IgAN — 24-mesačné výsledky</a></li>
  <li><a href="article.php?slug=c3-glomerulopatia-c3g-liecba-inhibicia-komplementu">C3 glomerulopatia a inhibícia komplementu</a></li>
  <li><a href="article.php?slug=sparsentan-sglt2-inhibitor-iga-nefropatia-spartacus-protect">Sparsentan so SGLT2i pri IgA nefropatii</a></li>
  <li><a href="article.php?slug=iga-nefropatia-kdigo-2025-kdoqi">IgA nefropatia podľa KDIGO 2025</a></li>
  <li><a href="article.php?slug=cheatsheet-komplement">Cheatsheet: komplement</a></li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Joshua M. Thurman, Felix Poppelaars. <em>Complement in Kidney Disease: Core Curriculum 2026.</em> American Journal of Kidney Diseases, 2026. <a href="https://doi.org/10.1053/j.ajkd.2026.06.008" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42726032/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.ajkd.org/article/S0272-6386(26)01049-8/fulltext" target="_blank" rel="noopener noreferrer">AJKD</a>.</em></p>

<h2>Ďalšie overené zdroje</h2>

<ol>
  <li><strong>Vojtech Petr, Joshua M. Thurman.</strong> <em>The role of complement in kidney disease.</em> Nature Reviews Nephrology. 2023;19(12):771–787. <a href="https://doi.org/10.1038/s41581-023-00766-1" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37735215/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Maria Alice V. Willrich, Karin M. P. Braun, Ann M. Moyer, David H. Jeffrey, Ashley Frazer-Abel.</strong> <em>Complement testing in the clinical laboratory.</em> Critical Reviews in Clinical Laboratory Sciences. 2021. <a href="https://doi.org/10.1080/10408363.2021.1907297" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/33962553/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Lucy A. McNamara, Nadav Topaz, Xin Wang, Susan Hariri, LeAnne Fox, Jessica R. MacNeil.</strong> <em>High Risk for Invasive Meningococcal Disease Among Patients Receiving Eculizumab (Soliris) Despite Receipt of Meningococcal Vaccine.</em> MMWR. 2017;66(27):734–737. <a href="https://doi.org/10.15585/mmwr.mm6627e1" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/28704351/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.cdc.gov/mmwr/volumes/66/wr/mm6627e1.htm" target="_blank" rel="noopener noreferrer">CDC/MMWR</a>.</li>
  <li><strong>Gérard Socié, Marie-Pierre Caby-Tosi, Jing L. Marantz, Alexander Cole, Camille L. Bedrosian, Christoph Gasteyger, Arshad Mujeebuddin, Peter Hillmen, Johan Vande Walle, Hermann Haller.</strong> <em>Eculizumab in paroxysmal nocturnal haemoglobinuria and atypical haemolytic uraemic syndrome: 10-year pharmacovigilance analysis.</em> British Journal of Haematology. 2019;185(2):297–310. <a href="https://doi.org/10.1111/bjh.15790" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/30768680/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Nicolas Maillard, Robert J. Wyatt, Bruce A. Julian, Krzysztof Kiryluk, Ali Gharavi, Veronique Fremeaux-Bacchi, Jan Novak.</strong> <em>Current Understanding of the Role of Complement in IgA Nephropathy.</em> Journal of the American Society of Nephrology. 2015;26(7):1503–1512. <a href="https://doi.org/10.1681/ASN.2014101000" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/25694468/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4483595/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Anja Roos, Maria Pia Rastaldi, Novella Calvaresi, Beatrijs D. Oortwijn, Nicole Schlagwein, Danielle J. van Gijlswijk-Janssen, Gregory L. Stahl, Misao Matsushita, Teizo Fujita, Cees van Kooten, Mohamed R. Daha.</strong> <em>Glomerular activation of the lectin pathway of complement in IgA nephropathy is associated with more severe renal disease.</em> Journal of the American Society of Nephrology. 2006;17(6):1724–1734. <a href="https://pubmed.ncbi.nlm.nih.gov/16687629/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Vlado Perkovic, Jonathan Barratt, Brad Rovin, Naoki Kashihara, Bart Maes, Hong Zhang, Hernán Trimarchi, Dmitrij Kollins, Olympia Papachristofi, Severina Jacinto-Sanders, Tobias Merkel, Nicolas Guerard, Ronny Renfurm, Thomas Hach, Dana V. Rizk (APPLAUSE-IgAN Investigators).</strong> <em>Alternative Complement Pathway Inhibition with Iptacopan in IgA Nephropathy.</em> New England Journal of Medicine. 2025;392(6):531–543. <a href="https://doi.org/10.1056/NEJMoa2410316" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/39453772/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Jonathan Barratt, Necmi Eren, Naoki Kashihara, Bart Maes, Dana V. Rizk, Brad Rovin, Hernán Trimarchi, Hong Zhang, Weiming Wang, Ismail Kocyigit, Chuanming Hao, Vladimir Tesař, Kenan Turgutalp, Li Yang, Guangqun Xing, Valter Duro Garcia, Seung Hyeok Han, Wanhong Lu, Antonio Pisani, Julia Weinmann-Menke, Frank Eitner, Nicolas Guerard, Dmytro Butylin, Luca Monaco, Emil Scosyrev, Annabel Magirr, Ronny Renfurm, Thomas Hach, Vlado Perkovic (APPLAUSE-IgAN Study Group).</strong> <em>Iptacopan in IgA Nephropathy — Final 24-Month Data.</em> New England Journal of Medicine. 2026;395(5):465–477. <a href="https://doi.org/10.1056/NEJMoa2600743" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41910396/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Novartis.</strong> <em>Novartis receives FDA accelerated approval for Fabhalta (iptacopan) for reduction of proteinuria in primary IgA nephropathy.</em> 8 August 2024. <a href="https://www.novartis.com/news/media-releases/novartis-receives-fda-accelerated-approval-fabhalta-iptacopan-first-and-only-complement-inhibitor-reduction-proteinuria-primary-iga-nephropathy-igan" target="_blank" rel="noopener noreferrer">Tlačová správa</a>.</li>
  <li><strong>Omeros Corporation.</strong> <em>Update on interim analysis of ARTEMIS-IGAN Phase 3 trial of narsoplimab in IgA nephropathy.</em> 16 October 2023. <a href="https://www.businesswire.com/news/home/20231016616955/en/Omeros-Corporation-Provides-Update-on-Interim-Analysis-of-ARTEMIS-IGAN-Phase-3-Trial-of-Narsoplimab-in-IgA-Nephropathy" target="_blank" rel="noopener noreferrer">Business Wire</a>; skúška <a href="https://clinicaltrials.gov/study/NCT03608033" target="_blank" rel="noopener noreferrer">NCT03608033</a>.</li>
  <li><strong>Vlado Perkovic, Hernán Trimarchi, Vladimir Tesař, Richard Lafayette, Muh Geot Wong, Jonathan Barratt, Yusuke Suzuki, Adrian Liew, Hong Zhang, Kevin Carroll, Vivekanand Jha, Alejandra Quevedo, Seung Hyeok Han, Manuel Praga, Bobby Chacko, Manisha Sahay, Chee Kay Cheung, Laura Kooienga, Michael Walsh, Jing Xia, Cecile Fajardo, Lokesh Shah, Jeffrey Hafkin, Dana V. Rizk (VISIONARY Trial Investigators Group).</strong> <em>Sibeprenlimab in IgA Nephropathy — Interim Analysis of a Phase 3 Trial.</em> New England Journal of Medicine. 2025. <a href="https://doi.org/10.1056/NEJMoa2512133" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41211929/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_komplement-oblicky-iga-nefropatia-inhibicia-klinik_article',
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
