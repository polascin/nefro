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
    'title'        => 'Komplement v ochoreniach obličiek a jeho cieľová inhibícia pri IgA nefropatii: čo má klinik vedieť',
    'slug'         => 'komplement-oblicky-iga-nefropatia-inhibicia-klinik',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prehľad komplementových dráh v nefrológii, biomarkerov pri IgA nefropatii (C3, C4d, CFHR), dostupných diagnostík a cielených inhibícií — od iptakopanu po negatívnu skúšku lektínovej dráhy narsoplimabom.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Komplement nie je len „laboratórna zvedavosť“ pri glomerulonefritídach. Pri IgA nefropatii je alternatívna dráha kľúčovým amplifikačným mechanizmom, histologické a genetické markery pomáhajú stratifikovať riziko a prvé schválené inhibítory už menia praktický algoritmus — no nie každá komplementová cesta sa ukázala ako liečebný cieľ.</em></p>

<p>Komplement je súčasťou vrodeného imunitného systému a chráni pred infekciou. Nadmerná alebo nevhodná aktivácia však prispieva k obličkovej zápalovej reakcii pri viacerých ochoreniach. Podľa prehľadu <em>Core Curriculum 2026</em> v <em>American Journal of Kidney Diseases</em> už Úrad pre kontrolu potravín a liekov (FDA) schválil komplementové inhibítory pre päť renálnych indikácií — atypický hemolyticko-uremický syndróm (aHUS), komplement 3 glomerulopatiu (C3G), primárnu imunokomplexovú membranoproliferatívnu glomerulonefritídu (IC-MPGN), ANCA-asociovanú vaskulitídu a IgA nefropatiu. Ďalšie skúšky testujú nové lieky aj ďalšie indikácie. Pre nefrológa je preto dôležité poznať mechanizmy, diagnostiku aj limity terapeutických zásahov.</p>

<h2>Tri dráhy aktivácie a prečo záleží na rozlíšení</h2>

<p>Komplement sa aktivuje tromi hlavnými cestami:</p>

<ul>
  <li><strong>Klasická dráha</strong> — typicky imunitný komplex (C1q, C4, C2),</li>
  <li><strong>Lektínová dráha</strong> — rozpoznanie cukrových vzorov (mannózovo viažuci lektín, MBL; MASP-1/2),</li>
  <li><strong>Alternatívna dráha (AP)</strong> — spontánna „tick-over“ aktivácia C3 cez faktor B a properdin; slúži ako amplifikačný okruh bez ohľadu na počiatočnú cestu.</li>
</ul>

<p>Pri IgA nefropatii sa v biopsii bežne nachádza IgA spolu s C3, zatiaľ čo C1q chýba — čo poukazuje skôr na alternatívnu a/alebo lektínovú než klasickú dráhu. Alternatívna dráha sa považuje za <strong>dominantný amplifikačný mechanizmus</strong> po ukladaní patogénnych IgA imunitných komplexov v mezangiu. To nevylučuje prínos lektínovej dráhy u podskupiny pacientov, ale vysvetľuje, prečo inhibícia faktora B (iptakopan) priniesla klinicky overený prínos, zatiaľ čo čistá lektínová stratégia zatiaľ nie.</p>

<h2>IgA nefropatia: čo hovoria biopsia a genetika</h2>

<h3>C3 a C4d v histológii</h3>

<p>Rutinná imunofluorescencia pri IgA nefropatii ukazuje dominantné alebo spoludominantné IgA depozity. <strong>C3 sa nachádza vo väčšine biopsií</strong> — v prehľadnej literatúre sa uvádza prítomnosť v približne 90 % a viac prípadov; prítomnosť C3 pomáha odlíšiť klinicky relevantnú IgA nefropatiu od subklinického mezangiálneho IgA. Absencia C1q pri prítomnosti C3 podporuje aktiváciu mimo klasickej dráhy.</p>

<p><strong>C4d</strong> (marker aktivácie lektínovej a/alebo klasickej dráhy) sa nachádza približne u <strong>tretiny až polovice</strong> pacientov (v jednotlivých kohortách 30–45 %). C4d-pozitívni pacienti majú v štúdiách horšiu renálnu prognózu nezávisle od ďalších premenných; v jednej recentnej kohorte bol glomerulárny C4d nezávislým prediktorom progresie k zlyhaniu obličiek. C4d teda nie je len epifenomen, ale potenciálny stratifikačný marker — hoci zatiaľ <strong>neexistuje validovaný algoritmus</strong>, ktorý by podľa C4d automaticky určil typ komplementovej inhibície.</p>

<h3>CFHR a alternatívna dráha</h3>

<p>Genomové asociačné štúdie identifikovali pri IgA nefropatii lokus s <strong>génmi CFHR1 a CFHR3</strong>. Ich delecia je spojená s nižším rizikom ochorenia, pravdepodobne preto, že produkty týchto génov konkuruje faktoru H pri regulácii alternatívnej dráhy — pri ich absencii môže byť komplement lepšie brzdený. Varianty ovplyvňujúce reguláciu komplementu (faktor H, CFHR) sa preto radia medzi mechanistické prepojenie medzi genetikou IgA nefropatie a alternatívnou dráhou.</p>

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
        <td>Veľmi častý nález; aktivácia komplementu</td>
        <td>Rozlišuje klinickú IgAN od subklinického IgA</td>
      </tr>
      <tr>
        <th scope="row">C4d v biopsii</th>
        <td>Lektínová/klasická aktivácia; horšia prognóza</td>
        <td>Nezávislý prediktor progresie v štúdiách; zatiaľ bez štandardizovanej terapeutickej voľby</td>
      </tr>
      <tr>
        <th scope="row">Properdin, faktor B</th>
        <td>Alternatívna dráha v tkanive</td>
        <td>Podporuje cielenú inhibíciu AP</td>
      </tr>
      <tr>
        <th scope="row">CFHR1/3 delecia</th>
        <td>Genetická ochrana</td>
        <td>Vysvetľuje prepojenie AP a rizika IgAN</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Laboratórna diagnostika komplementu</h2>

<p>Core Curriculum zdôrazňuje, že vyšetrenie komplementu patrí k vyšetreniu zápalových a autoimunitných renálnych ochorení. V praxi sa kombinuje:</p>

<ul>
  <li><strong>Sérové koncentrácie</strong> C3, C4, prípadne C1q — pokles môže naznačovať spotrebovanie, no u IgA nefropatie môžu zostať v norme aj pri lokálnej aktivácii v glomerule,</li>
  <li><strong>Fragmenty aktivácie</strong> (C3a, C5a, solubilný C5b-9 / sC5b-9) — citlivejšie na systémovú aktiváciu; v štúdiách s iptakopanom klesol plazmatický sC5b-9,</li>
  <li><strong>Funkčné testy</strong> — CH50 (klasická dráha), AH50 (alternatívna dráha),</li>
  <li><strong>Genetika</strong> — pri aHUS/C3G a pri podozrení na dysreguláciu AP (faktor H, CFH/CFHR, MCP/CD46 a ďalšie),</li>
  <li><strong>Autoprotilátky proti faktoru H</strong> — pri aHUS a vybraných glomerulopatiách s komplementovou dysreguláciou,</li>
  <li><strong>Histológia</strong> — doplnkové farbenie C4d, C3c alebo MBL v biopsii, ak je dostupné.</li>
</ul>

<p>Interpretácia vyžaduje kontext: <strong>normálne sérové C3/C4 nevylučujú</strong> lokálnu komplementovú aktiváciu v obličke. Naopak, izolovaný pokles C3 bez renálneho ochorenia môže byť aj sekundárny. Výsledky treba vždy prepojiť s klinickou a histologickou obrazou.</p>

<h2>Schválené a overené cielené inhibície pri IgA nefropatii</h2>

<h3>Iptakopan — inhibícia alternatívnej dráhy (faktor B)</h3>

<p>Iptakopan je perorálny selektívny inhibítor faktora B. Vo fáze III <strong>APPLAUSE-IgAN</strong> (NCT04578834) u dospelých s biopsiou potvrdenou IgA nefropatiou a proteinúriou ≥ 1 g/g napriek podpornej liečbe:</p>

<ul>
  <li><strong>Deväťmesačná analýza</strong> (NEJM 2024): upravený geometrický priemer 24-hodinového UPCR bol o <strong>38,3 %</strong> nižší pri iptakopane oproti placebu (95 % IS 26,0–48,6; p &lt; 0,001). Na tomto výsledku FDA udelila <strong>urýchlené schválenie 7.–8. augusta 2024</strong> na zníženie proteinúrie u dospelých s primárnou IgA nefropatiou v riziku progresie (typicky UPCR ≥ 1,5 g/g). V tom čase <strong>ešte nebol preukázaný</strong> účinok na pokles eGFR — ten bol naplánovaný až na 24 mesiacov.</li>
  <li><strong>Konečná 24-mesačná analýza</strong> (NEJM 2026): anualizovaný sklon eGFR −3,10 oproti −6,12 ml/min/1,73 m²/rok (rozdiel 3,02; upravené p &lt; 0,001); kombinovaný renálny ukazovateľ 21,4 % oproti 33,5 % (HR 0,57). Závažné infekcie boli častejšie (6,7 % oproti 2,1 %).</li>
</ul>

<p>Detailné čísla a bezpečnostné nuansy sú v samostatnom článku o APPLAUSE-IgAN na tomto portáli.</p>

<h3>Prečo nie terminálna blokáda u každého?</h3>

<p>Inhibícia C5 (ekulizumab, avakopan) má indikácie pri iných komplementových nefropatiách, no pri IgA nefropatii je mechanisticky dôraz kladený skôr na <strong>proximálnu blokádu alternatívnej dráhy</strong>, kde vzniká amplifikácia C3. Terminálna blokáda nezastaví upstream hyperaktiváciu AP — preto iptakopan a niektoré ďalšie lieky cielia skôr faktor B alebo C3.</p>

<h2>Lektínová dráha: negatívna fáza III a prečo to nie je prekvapenie</h2>

<p><strong>Narsoplimab</strong> (monoklonálna protilátka proti MASP-2) inhibuje lektínovú dráhu. Vo fáze II pri IgA nefropatii sa pozorovalo zníženie proteinúrie a pokles biomarkerov lektínovej dráhy. Vo fáze III <strong>ARTEMIS-IGAN</strong> (NCT03608033) však liek <strong>nedosiahol štatistickú významnosť</strong> v primárnom cieli — redukcia 24-hodinovej proteinúrie po 36 týždňoch oproti placebu. V placebovom ramene bol paradoxne veľký pokles proteinúrie, čo skúšku zhatilo; sponzor skúšku ukončil a nepodal žiadosti o schválenie v tejto indikácii.</p>

<p>Dôležité metodologické ponaučenie: približne <strong>iba tretina</strong> biopsií pri IgA nefropatii je C4d-pozitívna, teda pravdepodobne s výraznejšou lektínovou aktiváciou. ARTEMIS-IGAN <strong>nevyberala pacientov podľa C4d ani podľa biomarkerov lektínovej dráhy</strong> — testovala „všetkých“ s vysokou proteinúriou. Ak je lektínová aktivácia relevantná len u menšej podskupiny, negatívna skúška v nemarkovanej populácii nevyvracia hypotézu; skôr ukazuje, že <strong>enrichment podľa histológie alebo biomarkerov</strong> bude pri budúcich skúškach lektínovej dráhy nevyhnutný.</p>

<h2>Kombinačné koncepty: rôzne ciele, nie „všetko naraz“</h2>

<p>Moderná liečba IgA nefropatie útočí na rôzne články patogenézy. Core Curriculum a súčasné smernice naznačujú, že komplementová inhibícia bude často <strong>prídavná</strong> k podpornej liečbe, nie jej náhrada:</p>

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
        <td>Lokálna imunosupresia v ileálnom Peyerovom patchi; znižuje patogénne IgA1</th>
        <td>Ne priama — menej substrátu pre imunitné komplexy a komplementovú aktiváciu</td>
      </tr>
      <tr>
        <th scope="row">Sibeprenlimab</th>
        <td>Inhibícia APRIL; menej galaktózovo deficitného IgA1</th>
        <td>Ne priama — fáza III VISIONARY: −51,2 % proteinúrie oproti placebu v 9 mesiacoch</td>
      </tr>
      <tr>
        <th scope="row">Sparsentan (+ SGLT2i)</th>
        <td>Duálna blokáda endotelínu/angiotenzínu; hemodynamická nefroprotekcia</th>
        <td>Ne priama — znižuje proteinúriu a intraglomerulárny tlak</td>
      </tr>
      <tr>
        <th scope="row">Iptakopan</th>
        <td>Inhibícia faktora B; priama blokáda alternatívnej dráhy</td>
        <td>Priama — schválená indikácia na zníženie proteinúrie; 24-mesačný prínos na eGFR</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Randomizované dáta o bezpečnosti a účinnosti <strong>pevných kombinácií</strong> (napr. iptakopan + sibeprenlimab + sparsentan) zatiaľ chýbajú. V praxi ide skôr o sekvenčné rozhodovanie podľa rizika progresie, histológie, komplementových markerov, infekčného rizika a dostupnosti liekov. Súbežná komplementová blokáda s inými imunomodulátormi si vyžaduje osobitnú opatrnosť kvôli infekciám.</p>

<h2>Praktický algoritmus pre ambulanciu</h2>

<ol>
  <li><strong>Optimalizovať podpornú liečbu</strong> — ACEi/ARB, SGLT2i podľa indikácie, kontrola tlaku a kardiovaskulárneho rizika (viď <a href="article.php?slug=iga-nefropatia-kdigo-2025-kdoqi">KDIGO 2025</a>).</li>
  <li><strong>Stratifikovať riziko</strong> — eGFR, proteinúria, MEST-C; zvážiť doplnkové C4d v biopsii, ak materiál existuje.</li>
  <li><strong>Pri vysokom riziku a pretrvávajúcej proteinúrii</strong> zvážiť cielenú terapiu podľa mechanizmu: Nefecon, sibeprenlimab, sparsentan alebo iptakopan podľa dostupnosti, schválení a profilu pacienta — nie automaticky komplement u každého.</li>
  <li><strong>Pred komplementovou inhibíciou</strong> overiť očkovanie proti <em>Neisseria meningitidis</em> a <em>Streptococcus pneumoniae</em>, poučiť o infekčnom riziku, sledovať proteinúriu a eGFR.</li>
  <li><strong>Neprekladať proteinúriu na tvrdý endpoint</strong> — urýchlené schválenia iptakopanu vychádzali z 9-mesačnej proteinúrie; dlhodobý prínos na eGFR vyžaduje 24-mesačné dáta (u iptakopanu už publikované).</li>
</ol>

<h2>Obmedzenia a opatrná interpretácia</h2>

<ul>
  <li>Plný text <em>Core Curriculum 2026</em> je za paywallom vydavateľa; tento prehľad vychádza z PubMed abstraktu a overiteľných otvorených zdrojov citovaných nižšie.</li>
  <li>Presné percento C3+ biopsií sa líši podľa kohorty; „&gt; 90 %“ je konsenzus z review literatúry, nie univerzálne pravidlo pre každé centrum.</li>
  <li>C4d prognostický význam neznamená, že každý C4d+ pacient potrebuje lektínovú inhibíciu — terapeutická odpoveď nebola v randomizovanej skúške preukázaná.</li>
  <li>Regulačný status liekov sa môže líšiť medzi USA, EÚ a Slovenskom; článok popisuje publikované klinické dáta a FDA schválenia, nie lokálny formulár.</li>
</ul>

<h2>Záver</h2>

<p>Komplement pri IgA nefropatii nie je jednotná story: alternatívna dráha je mechanisticky centrálna a jej inhibícia iptakopanom znížila proteinúriu (schválenie FDA august 2024) a po 24 mesiacoch spomalila pokles eGFR. Lektínová dráha je biologicky relevantná u podskupiny s C4d+, no fáza III s narsoplimabom bez výberu podľa biomarkerov skončila negatívne. Nefrológ by mal poznať základné dráhy, limitovanú hodnotu sérového C3/C4, význam histologického C4d a genetiky CFHR, a zaradiť komplementovú terapiu do širšieho multimodálneho rámca spolu s podpornou liečbou a ďalšími cielenými postupmi proti IgA1.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=iptakopan-iga-nefropatia-applause-igan-24-mesiacov">Iptakopan a APPLAUSE-IgAN — 24-mesačné výsledky</a></li>
  <li><a href="article.php?slug=c3-glomerulopatia-c3g-liecba-inhibicia-komplementu">C3 glomerulopatia a inhibícia komplementu</a></li>
  <li><a href="article.php?slug=sparsentan-sglt2-inhibitor-iga-nefropatia-spartacus-protect">Sparsentan so SGLT2i pri IgA nefropatii</a></li>
  <li><a href="article.php?slug=iga-nefropatia-kdigo-2025-kdoqi">IgA nefropatia podľa KDIGO 2025</a></li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Joshua M. Thurman, Felix Poppelaars. <em>Complement in Kidney Disease: Core Curriculum 2026.</em> American Journal of Kidney Diseases, 2026 (ahead of print). <a href="https://doi.org/10.1053/j.ajkd.2026.06.008" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42726032/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<h2>Ďalšie overené zdroje</h2>

<ol>
  <li><strong>Nicolas Maillard, Robert J. Wyatt, Bruce A. Julian, Krzysztof Kiryluk, Ali Gharavi, Veronique Fremeaux-Bacchi, Jan Novak.</strong> <em>Current Understanding of the Role of Complement in IgA Nephropathy.</em> Journal of the American Society of Nephrology. 2015;26(7):1503–1512. <a href="https://doi.org/10.1681/ASN.2014101000" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/25694468/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4483595/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Anja Roos, Maria Pia Rastaldi, Novella Calvaresi, Beatrijs D. Oortwijn, Nicole Schlagwein, Danielle J. van Gijlswijk-Janssen, Gregory L. Stahl, Misao Matsushita, Teizo Fujita, Cees van Kooten, Mohamed R. Daha.</strong> <em>Glomerular activation of the lectin pathway of complement in IgA nephropathy is associated with more severe renal disease.</em> Journal of the American Society of Nephrology. 2006;17(6):1724–1734. <a href="https://pubmed.ncbi.nlm.nih.gov/16687629/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Vlado Perkovic, Jonathan Barratt, Brad Rovin, Naoki Kashihara, Bart Maes, Hong Zhang, Hernán Trimarchi, Dmitrij Kollins, Olympia Papachristofi, Severina Jacinto-Sanders, Tobias Merkel, Nicolas Guerard, Ronny Renfurm, Thomas Hach, Dana V. Rizk (APPLAUSE-IgAN Investigators).</strong> <em>Alternative Complement Pathway Inhibition with Iptacopan in IgA Nephropathy.</em> New England Journal of Medicine. 2025;392(6):531–543. <a href="https://doi.org/10.1056/NEJMoa2410316" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/39453772/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Jonathan Barratt, Necmi Eren, Naoki Kashihara, Bart Maes, Dana V. Rizk, Brad Rovin, Hernán Trimarchi, Hong Zhang, Weiming Wang, Ismail Kocyigit, Chuanming Hao, Vladimir Tesař, Kenan Turgutalp, Li Yang, Guangqun Xing, Valter Duro Garcia, Seung Hyeok Han, Wanhong Lu, Antonio Pisani, Julia Weinmann-Menke, Frank Eitner, Nicolas Guerard, Dmytro Butylin, Luca Monaco, Emil Scosyrev, Annabel Magirr, Ronny Renfurm, Thomas Hach, Vlado Perkovic (APPLAUSE-IgAN Study Group).</strong> <em>Iptacopan in IgA Nephropathy — Final 24-Month Data.</em> New England Journal of Medicine. 2026;395(5):465–477. <a href="https://doi.org/10.1056/NEJMoa2600743" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41910396/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Novartis.</strong> <em>Novartis receives FDA accelerated approval for Fabhalta (iptacopan) for reduction of proteinuria in primary IgA nephropathy.</em> 8 August 2024. <a href="https://www.novartis.com/news/media-releases/novartis-receives-fda-accelerated-approval-fabhalta-iptacopan-first-and-only-complement-inhibitor-reduction-proteinuria-primary-iga-nephropathy-igan" target="_blank" rel="noopener noreferrer">Tlačová správa</a>.</li>
  <li><strong>Omeros Corporation.</strong> <em>Update on interim analysis of ARTEMIS-IGAN Phase 3 trial of narsoplimab in IgA nephropathy.</em> 16 October 2023. <a href="https://www.businesswire.com/news/home/20231016616955/en/Omeros-Corporation-Provides-Update-on-Interim-Analysis-of-ARTEMIS-IGAN-Phase-3-Trial-of-Narsoplimab-in-IgA-Nephropathy" target="_blank" rel="noopener noreferrer">Business Wire</a>; skúška <a href="https://clinicaltrials.gov/study/NCT03608033" target="_blank" rel="noopener noreferrer">NCT03608033</a>.</li>
  <li><strong>Vlado Perkovic, Hernán Trimarchi, Vladimir Tesař, Richard Lafayette, Muh Geot Wong, Jonathan Barratt, Yusuke Suzuki, Adrian Liew, Hong Zhang, Kevin Carroll, Vivekanand Jha, Alejandra Quevedo, Seung Hyeok Han, Manuel Praga, Bobby Chacko, Manisha Sahay, Chee Kay Cheung, Laura Kooienga, Michael Walsh, Jing Xia, Cecile Fajardo, Lokesh Shah, Jeffrey Hafkin, Dana V. Rizk (VISIONARY Trial Investigators Group).</strong> <em>Sibeprenlimab in IgA Nephropathy — Interim Analysis of a Phase 3 Trial.</em> New England Journal of Medicine. 2025 (online ahead of print). <a href="https://doi.org/10.1056/NEJMoa2512133" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41211929/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
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
