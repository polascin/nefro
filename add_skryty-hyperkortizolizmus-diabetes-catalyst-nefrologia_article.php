<?php
/**
 * Odborný článok: CATALYST, hyperkortizolizmus a ťažko kontrolovateľný diabetes.
 */

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
    'title'        => 'Skrytý hyperkortizolizmus pri ťažko kontrolovateľnom diabete 2. typu: čo ukázala CATALYST',
    'slug'         => 'skryty-hyperkortizolizmus-diabetes-catalyst-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V štúdii CATALYST malo 23,8 % starostlivo vybraných pacientov nesupresný kortizol po dexametazóne. Pozitívny skríning však nie je diagnóza Cushingovho syndrómu a mifepristón vyžaduje náročné monitorovanie.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Štúdia CATALYST upozornila, že pri ťažko kontrolovateľnom diabete 2. typu môže byť porucha regulácie kortizolu častejšia, než sa predpokladalo. Jej najcitovanejší výsledok — 23,8 % pacientov s nesupresným kortizolom po 1 mg dexametazónu — však nemožno zameniť za 23,8 % prevalenciu potvrdeného Cushingovho syndrómu. Pre nefrológa je podstatné vedieť, koho cielene vyšetriť, ako interpretovať pozitívny test pri CKD a prečo liečba mifepristónom vyžaduje intenzívne sledovanie draslíka, tlaku, objemového stavu a glykémie.</em></p>

<p>Diabetes 2. typu, obezita a hypertenzia sú bežné ochorenia. Samy osebe preto nepredstavujú dostatočný dôvod na plošný skríning Cushingovho syndrómu. Podozrenie rastie pri nezvyčajnej kombinácii alebo progresii nálezov: pri neprimerane ťažkej hyperglykémii napriek viacliekovej liečbe, pri ťažko kontrolovateľnej hypertenzii, nevysvetlenej hypokaliémii, proximálnej svalovej slabosti, širokých fialových striách, ľahkej tvorbe modrín, osteoporotických zlomeninách alebo pri adrenálnom incidentalóme.</p>

<p>CATALYST skúmala práve výberovú populáciu s vysokou predtestovou pravdepodobnosťou. Výsledok preto otvára dôležitú klinickú otázku, ale nemení pozitívny skríningový test na hotovú diagnózu.</p>

<h2>Čo presne skúmala CATALYST</h2>

<p>CATALYST bola americká multicentrická štúdia fázy 4 financovaná spoločnosťou Corcept Therapeutics, výrobcom mifepristónu Korlym. Mala dve časti:</p>

<ol>
  <li><strong>Prevalenčná fáza:</strong> prospektívne vyšetrenie pacientov s nedostatočne kontrolovaným diabetom 2. typu pomocou nočného supresného testu s 1 mg dexametazónu (DST).</li>
  <li><strong>Liečebná fáza:</strong> 24-týždňové randomizované, dvojito zaslepené porovnanie mifepristónu s placebom u časti pacientov s pozitívnym DST.</li>
</ol>

<p>Za „ťažko kontrolovateľný“ diabetes štúdia považovala HbA<sub>1c</sub> 7,5 až 11,5 % pri splnení aspoň jednej z týchto podmienok:</p>

<ul>
  <li>najmenej tri glukózu znižujúce lieky,</li>
  <li>inzulín spolu s ďalším glukózu znižujúcim liekom,</li>
  <li>najmenej dva glukózu znižujúce lieky a mikrovaskulárna alebo makrovaskulárna komplikácia,</li>
  <li>najmenej dva glukózu znižujúce a najmenej dva antihypertenzívne lieky.</li>
</ul>

<p>Protokol sa snažil odstrániť alebo vylúčiť viaceré časté príčiny nepresného DST: perorálnu estrogénovú antikoncepciu bolo potrebné vysadiť najmenej tri týždne pred testom; nadmerný príjem alkoholu, neliečené ťažké spánkové apnoe, závažné akútne alebo psychiatrické ochorenie a práca v nočných zmenách patrili medzi vylučovacie kritériá. Vylúčení boli aj dialyzovaní pacienti a pacienti s terminálnym zlyhaním obličiek.</p>

<h2>Výsledok 23,8 %: pozitívny DST, nie 252 potvrdených Cushingových syndrómov</h2>

<p>Do prevalenčnej analýzy vstúpilo 1 057 pacientov s dostatočnou koncentráciou dexametazónu. Kortizol po DST zostal nad 1,8 µg/dl (50 nmol/l) u 252 pacientov, teda u <strong>23,8 %</strong> (95 % interval spoľahlivosti 21,3 až 26,5 %). U pacientov užívajúcich najmenej tri triedy antihypertenzív bola nesupresia prítomná u <strong>36,6 %</strong>.</p>

<p>Tieto čísla treba čítať presne:</p>

<ul>
  <li>išlo o vysoko selektovanú populáciu z diabetologických pracovísk, nie o všetkých pacientov s diabetom,</li>
  <li>študijná definícia „hyperkortizolizmu“ vychádzala z <strong>jedného</strong> nesupresného DST,</li>
  <li>protokol nevyžadoval druhý nezávislý biochemický test na potvrdenie Cushingovho syndrómu,</li>
  <li>štúdia nepreukázala, že nesupresia kortizolu bola príčinou nedostatočnej glykemickej kontroly,</li>
  <li>tri alebo viac antihypertenzív bez overenia adherencie, dávok a diuretika nie je automaticky formálna diagnóza rezistentnej hypertenzie.</li>
</ul>

<p>Z 219 pacientov s pozitívnym DST a dostupným CT malo 34,7 % opísanú odchýlku nadobličky, najčastejšie jednostranný uzol. Väčšina teda nemala na CT zjavný adrenálny nález. Negatívne CT však nevylučuje hormonálnu poruchu a pozitívne CT samo osebe nepotvrdzuje, že nález kortizol produkuje.</p>

<h3>Nezávislá meta-analýza dáva číslu potrebný kontext</h3>

<p>Systematický prehľad z roku 2026 zahrnul 39 štúdií so 14 995 vyšetrenými osobami. Medzi 6 638 pacientmi s diabetom malo abnormálny DST 14,3 %; po štatistickej korekcii heterogenity autori uviedli odhad 23,3 %. <strong>Potvrdený Cushingov syndróm</strong> však malo 2,1 % (95 % interval spoľahlivosti 1,3 až 3,3 %) a autori uviedli, že k potvrdeniu syndrómu viedol približne jeden zo siedmich abnormálnych DST.</p>

<p>Rozdiel medzi nesupresným DST a potvrdenou diagnózou nie je slovná maličkosť. Určuje, či pacient potrebuje ďalšie endokrinologické testovanie, etiologické vyšetrenie a špecifickú liečbu.</p>

<h2>Koho cielene vyšetriť</h2>

<p>Dostupné usmernenia nepodporujú skríning všetkých pacientov s diabetom alebo obezitou. Vyšetrenie má najväčší zmysel pri rastúcej predtestovej pravdepodobnosti, najmä pri:</p>

<ul>
  <li>viacerých a progresívnych znakoch typických pre Cushingov syndróm,</li>
  <li>ťažko kontrolovateľnom diabete spolu s neprimeranou liekovou záťažou,</li>
  <li>ťažko kontrolovateľnej hypertenzii, najmä pri hypokaliémii alebo adrenálnom incidentalóme,</li>
  <li>nezvyčajnej osteoporóze alebo vertebrálnych zlomeninách,</li>
  <li>proximálnej myopatii, širokých fialových striách, tvárovej plétore alebo ľahkej tvorbe modrín,</li>
  <li>adrenálnom incidentalóme, pri ktorom sa podľa európskeho usmernenia vykonáva 1 mg DST.</li>
</ul>

<p>Samotná centrálna obezita, hypertenzia alebo vyšší HbA<sub>1c</sub> majú nízku špecificitu. Najprv treba preveriť adherenciu, techniku podávania inzulínu, sekundárne liekové príčiny, spánkové apnoe, alkohol, depresiu, infekciu a ďalšie časté dôvody zlej kompenzácie.</p>

<h2>Ako správne vykonať a interpretovať 1 mg DST</h2>

<ol>
  <li><strong>Pred testom skontrolovať rušivé faktory.</strong> Treba cielene hľadať glukokortikoidy všetkými cestami podania, estrogény zvyšujúce kortizol viažuci globulín, akútne ochorenie, nadmerný alkohol, závažnú depresiu, neliečené spánkové apnoe, nočné zmeny a lieky meniace metabolizmus dexametazónu, napríklad niektoré induktory alebo inhibítory CYP3A.</li>
  <li><strong>Dexametazón podať približne o 23:00.</strong> Pacient užije 1 mg perorálne.</li>
  <li><strong>Krv odobrať približne o 8:00 nasledujúce ráno.</strong> Tvrdenie, že čas odberu je ľubovoľný, nie je správne.</li>
  <li><strong>Hodnotiť kortizol v kontexte metódy.</strong> Hodnota nad 1,8 µg/dl (50 nmol/l) znamená nedostatočnú supresiu a pozitívny skríning.</li>
  <li><strong>Pri pozitívnom výsledku overiť expozíciu dexametazónu.</strong> Súčasná koncentrácia dexametazónu pomáha odhaliť nepožitie, nedostatočné vstrebávanie alebo zrýchlený metabolizmus. CATALYST používala hranicu ≥140 ng/dl; nejde však o univerzálnu hodnotu pre všetky laboratóriá a metódy.</li>
</ol>

<p>Po jednom abnormálnom teste má nasledovať endokrinologické posúdenie a spravidla ďalšie biochemické potvrdenie alebo opakovanie testu podľa fenotypu. Endocrine Society odporúča pri abnormálnom prvom výsledku druhý validovaný test; pri nezhodných výsledkoch ďalšie hodnotenie. Až po potvrdení endogénneho hyperkortizolizmu sa určuje jeho príčina.</p>

<h3>ACTH a zobrazovanie patria až do etiologického kroku</h3>

<p>Potlačený alebo nízky ACTH podporuje ACTH-nezávislý adrenálny pôvod. Normálny alebo zvýšený ACTH vedie k vyšetrovaniu ACTH-dependentného zdroja, najmä hypofýzy alebo ektopickej sekrécie. Samotné MRI hypofýzy nemusí pôvod spoľahlivo určiť; ďalší postup môže vyžadovať špecializované dynamické testy alebo odber z dolných petróznych splavov.</p>

<p>Zobrazovanie pred biochemickým potvrdením môže odhaliť náhodný, hormonálne nesúvisiaci uzol a odviesť diagnostiku nesprávnym smerom.</p>

<h2>Osobitosti testovania pri CKD</h2>

<p>Pri chronickej chorobe obličiek treba výber testu interpretovať obzvlášť opatrne:</p>

<ul>
  <li><strong>24-hodinový voľný kortizol v moči môže byť pri zníženej GFR falošne nízky.</strong> S poklesom funkcie obličiek klesá jeho vylučovanie, preto normálny výsledok hyperkortizolizmus spoľahlivo nevylučuje.</li>
  <li><strong>Mierny alebo autonómny adrenálny hyperkortizolizmus môže mať normálny močový aj neskorý slinný kortizol.</strong> Výber druhého testu preto patrí endokrinológovi a závisí od podozrivého fenotypu.</li>
  <li><strong>Pokročilá CKD môže meniť cirkadiánny profil a farmakokinetiku.</strong> Výsledok musí byť posúdený spolu s klinickým obrazom, použitým testom a laboratórnou metódou.</li>
  <li><strong>CATALYST neposkytuje údaje pre dialýzu.</strong> Prevalenčná fáza vylúčila dialyzovaných pacientov a terminálne zlyhanie obličiek; liečebná fáza navyše vylúčila odhadovanú glomerulovú filtráciu (eGFR) &lt;30 ml/min/1,73 m².</li>
</ul>

<h2>Liečebná fáza: výrazné zlepšenie HbA1c, ale za cenu vysokej toxicity a prerušení</h2>

<p>Do randomizovanej fázy vstúpilo 136 pacientov s pozitívnym DST: 91 dostávalo mifepristón a 45 placebo. Mifepristón sa začínal dávkou 300 mg denne, s možnosťou titrácie na 600 a 900 mg podľa tolerancie a odpovede. Liečba trvala 24 týždňov.</p>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky randomizovanej liečebnej fázy CATALYST" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Mifepristón</th>
        <th scope="col">Placebo</th>
        <th scope="col">Rozdiel oproti placebu</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Zmena HbA<sub>1c</sub> v 24. týždni</th>
        <td>−1,47 percentuálneho bodu</td>
        <td>−0,15 percentuálneho bodu</td>
        <td>−1,32 (95 % IS −1,81 až −0,83; p &lt;0,001)</td>
      </tr>
      <tr>
        <th scope="row">Zmena hmotnosti</th>
        <td>−4,40 kg</td>
        <td>+0,72 kg</td>
        <td>−5,12 kg (95 % IS −8,20 až −2,03)</td>
      </tr>
      <tr>
        <th scope="row">Dokončenie 24 týždňov liečby</th>
        <td>53,8 %</td>
        <td>82,2 %</td>
        <td>46 % verzus 18 % liečbu nedokončilo</td>
      </tr>
      <tr>
        <th scope="row">Zmena systolického tlaku</th>
        <td>+8,0 mm Hg</td>
        <td>−2,1 mm Hg</td>
        <td>+10,1 mm Hg (95 % IS 3,62 až 16,59)</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Počas prvých 12 týždňov sa rýchlo pôsobiaci inzulín znížil alebo vysadil u 30 % pacientov na mifepristóne oproti 11 % pri placebe; pri bazálnom inzulíne to bolo 49 % oproti 13 %. Tieto sekundárne výsledky neboli upravené na mnohonásobné porovnávania a treba ich chápať ako podporné.</p>

<p>Primárna analýza HbA<sub>1c</sub> použila model s predpokladom, že chýbajúce údaje vznikli náhodne, a zahrnula dostupné merania aj po ukončení skúšanej liečby. Citlivostné analýzy počas liečby a u pacientov, ktorí štúdiu dokončili, ukázali podobný smer účinku. Vysoký počet predčasných ukončení však zostáva zásadným limitom prenositeľnosti výsledku do bežnej praxe.</p>

<h2>Bezpečnosť mifepristónu je nefrologická téma</h2>

<p>Mifepristón blokuje glukokortikoidný aj progesterónový receptor. Nezastavuje tvorbu kortizolu; prerušenie negatívnej spätnej väzby môže koncentrácie kortizolu a ACTH ešte zvýšiť. Kortizol potom môže presiahnuť kapacitu renálneho enzýmu 11β-hydroxysteroiddehydrogenázy typu 2 a aktivovať mineralokortikoidný receptor.</p>

<p>Klinickými dôsledkami sú:</p>

<ul>
  <li>renálna strata draslíka a <strong>hypokaliémia</strong>,</li>
  <li>retencia sodíka, periférne edémy a vzostup krvného tlaku,</li>
  <li>potreba dopĺňania draslíka alebo antagonistu mineralokortikoidného receptora,</li>
  <li>rýchly pokles glykémie s potrebou znížiť inzulín alebo derivát sulfonylurey.</li>
</ul>

<p>V CATALYST sa hypokaliémia objavila u 29,7 % pacientov na mifepristóne. Nežiaduce udalosti stupňa 3 boli častejšie než pri placebe (29 % oproti 2 %) a závažné nežiaduce udalosti sa hlásili u 32 % oproti 5 %. Tridsaťtri percent pacientov na mifepristóne začalo užívať draslík šetriace diuretikum, najmä spironolaktón, oproti 2,2 % pri placebe.</p>

<p>Tri prípady euglykemickej diabetickej ketoacidózy vznikli v mifepristónovej vetve u pacientov užívajúcich inhibítor SGLT2 pri zníženom príjme potravy a redukcii inzulínu. Skúšajúci ich nepovažovali za spôsobené mifepristónom, ale pre prax ide o dôležité varovanie: pri nauzee, hladovaní alebo prudkej redukcii inzulínu treba individuálne prehodnotiť inhibítor SGLT2 a myslieť na ketózu aj pri normálnejšej glykémii.</p>

<h3>Syndróm z vysadenia glukokortikoidov nie je to isté ako biochemická nedostatočnosť</h3>

<p>Únava, nauzea, bolesti svalov, bolesti kĺbov a bolesť hlavy môžu sprevádzať pokles glukokortikoidného účinku a označujú sa ako syndróm z vysadenia glukokortikoidov. Podobné príznaky však môžu znamenať nadmernú blokádu receptora alebo klinickú nedostatočnosť glukokortikoidného účinku. Keďže kortizol pri mifepristóne zostáva zvýšený, sérový kortizol nepomáha pri hodnotení účinnosti ani bezpečnosti. Rozhoduje klinický stav a manažment skúseným endokrinológom.</p>

<p>Americká informácia o lieku Korlym uvádza mifepristón na kontrolu hyperglykémie sekundárnej k endogénnemu Cushingovmu syndrómu u dospelých s diabetom 2. typu alebo poruchou glukózovej tolerancie, u ktorých operácia zlyhala alebo nie sú jej kandidátmi. <strong>Samotný pozitívny DST alebo ťažko kontrolovateľný diabetes nie sú touto schválenou indikáciou.</strong></p>

<p>Liek je kontraindikovaný v gravidite, má významné interakcie cez CYP3A, môže predlžovať QT interval a pre antiprogesterónový účinok môže spôsobiť endometriálne zmeny alebo krvácanie. Jeho dostupnosť a registračné postavenie na Slovensku treba overovať v aktuálnej databáze ŠÚKL; americká indikácia sa nesmie automaticky prenášať do európskej praxe.</p>

<h2>Renálne pozorovania z desiatich kazuistík nie sú dôkazom nefroprotekcie</h2>

<p>Kazuistický súbor Christophera P. Lucciho a Grete McCoyovej opísal desať pacientov z jedného pracoviska liečených mifepristónom. Dvaja mali diabetes 1. typu a jeden pacient dostal liečbu napriek kortizolu po DST pod diagnostickou hranicou. Dĺžka liečby sa pohybovala od menej než troch do 72 mesiacov a súbežná liečba sa menila.</p>

<p>U siedmich pacientov eGFR stúpla v priemere o 17,4 ml/min/1,73 m², u troch klesla; u jedného pacienta sa objavila nová výrazná proteinúria. Autori správne uviedli, že pre variabilitu UACR a nekontrolovaný dizajn nemožno robiť záver o zlepšení funkcie obličiek.</p>

<p>Tento súbor je užitočný na tvorbu hypotéz a opis praktických komplikácií, nie na dokazovanie renálneho účinku. Zmenu kreatinínu mohli ovplyvniť hemodynamika, hmotnosť, svalová hmota, objemový stav, zmena glykémie aj súbežné inhibítory SGLT2, blokátory renín-angiotenzínového systému alebo finerenón.</p>

<h2>Čo sledovať, ak špecializované pracovisko mifepristón použije</h2>

<ul>
  <li><strong>Pred liečbou:</strong> draslík, bikarbonát, kreatinín a eGFR, tlak, objemový stav, EKG a kompletná kontrola interakcií; vylúčenie gravidity a príslušných gynekologických kontraindikácií.</li>
  <li><strong>Po začatí a po každej titrácii:</strong> skorá kontrola draslíka, tlaku, edémov a renálnej funkcie; CATALYST kontrolovala pacienta približne po dvoch týždňoch.</li>
  <li><strong>Glykémia:</strong> časté meranie alebo kontinuálne monitorovanie, včasná individualizovaná redukcia inzulínu a derivátu sulfonylurey.</li>
  <li><strong>Pri inhibítore SGLT2:</strong> edukácia o euglykemickej ketoacidóze a dočasnom prerušení pri hladovaní, vracaní, dehydratácii alebo akútnom ochorení.</li>
  <li><strong>Obličkové riziko:</strong> sledovať eGFR aj UACR; izolovanú zmenu kreatinínu nevydávať za nefroprotekciu.</li>
  <li><strong>Účinnosť:</strong> hodnotiť klinicky podľa glykémie, hmotnosti, tlaku a komorbidít, nie podľa sérového kortizolu.</li>
</ul>

<h2>Limity dôkazov</h2>

<ul>
  <li>CATALYST použila v prevalenčnej fáze jediný DST a širšiu študijnú definíciu než tradičný algoritmus potvrdenia Cushingovho syndrómu.</li>
  <li>Populácia bola selektovaná v špecializovaných diabetologických centrách a výsledok nemožno preniesť na bežnú populáciu s diabetom.</li>
  <li>Štúdiu financoval výrobca lieku; analýzu vykonali štatistici zamestnaní sponzorom a viacerí autori mali finančné vzťahy so spoločnosťou.</li>
  <li>Liečebná fáza bola malá, trvala 24 týždňov a mala vysokú mieru predčasného ukončenia.</li>
  <li>Pacienti s eGFR pod 30 ml/min/1,73 m² neboli do liečebnej fázy zaradení a dialyzovaní pacienti neboli v prevalenčnej fáze.</li>
  <li>Štúdia nehodnotila dlhodobé kardiovaskulárne, renálne ani mortalitné výsledky.</li>
</ul>

<h2>Praktický záver pre nefrológa</h2>

<ol>
  <li><strong>Nevykonávať plošný skríning.</strong> Hľadať kombináciu progresívnych alebo nezvyčajne závažných znakov.</li>
  <li><strong>Pri ťažko kontrolovateľnom diabete a hypertenzii myslieť aj na kortizol.</strong> Súčasne však nezabudnúť na častejšie príčiny vrátane primárneho aldosteronizmu, spánkového apnoe, liekov a nedostatočnej adherencie.</li>
  <li><strong>DST vykonať štandardizovane.</strong> Dexametazón približne o 23:00, kortizol približne o 8:00 a pri pozitívnom výsledku kontrola primeranej expozície dexametazónu.</li>
  <li><strong>Pozitívny DST neposielať rovno na CT alebo liečbu.</strong> Pacient potrebuje endokrinologické potvrdenie a etiologický algoritmus.</li>
  <li><strong>Pri mifepristóne monitorovať obličkové a metabolické riziká aktívne.</strong> Hypokaliémia, retencia sodíka, edémy, vzostup tlaku, hypoglykémia a interakcie nie sú okrajové komplikácie.</li>
</ol>

<h2>Záver</h2>

<p>CATALYST priniesla dôležitý dôkaz, že v úzko vybranej skupine pacientov s nedostatočne kontrolovaným diabetom 2. typu je nesupresný 1 mg DST častý a že blokáda glukokortikoidného receptora môže výrazne znížiť HbA<sub>1c</sub>. Nepriniesla však dôkaz, že takmer štvrtina týchto pacientov má potvrdený Cushingov syndróm, ani že mifepristón chráni obličky.</p>

<p>Najrozumnejším dôsledkom nie je plošné testovanie ani empirická liečba. Je ním vyššia klinická pozornosť, správne vykonaný DST u vhodne vybraného pacienta, endokrinologické potvrdenie diagnózy a rešpektovanie náročného bezpečnostného profilu liečby.</p>

<hr>

<h2>Odborné zdroje</h2>

<ol>
  <li><strong>Buse JB, Kahn SE, Aroda VR, et al.; CATALYST Investigators.</strong> <em>Prevalence of Hypercortisolism in Difficult-to-Control Type 2 Diabetes.</em> Diabetes Care. 2025;48(12):2012–2020. doi: 10.2337/dc24-2841. <a href="https://pubmed.ncbi.nlm.nih.gov/40249765/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12635953/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>DeFronzo RA, Fonseca V, Aroda VR, et al.; CATALYST Investigators.</strong> <em>Inadequately Controlled Type 2 Diabetes and Hypercortisolism: Improved Glycemia With Mifepristone Treatment.</em> Diabetes Care. 2025;48(12):2036–2044. doi: 10.2337/dc25-1055. <a href="https://pubmed.ncbi.nlm.nih.gov/40550011/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12635952/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>Ferrari D, Bonaventura I, Tenuta M, et al.</strong> <em>Rethinking hypercortisolism screening in obesity and diabetes: A systematic review and meta-analysis.</em> Metabolism. 2026;182:156675. doi: 10.1016/j.metabol.2026.156675. <a href="https://pubmed.ncbi.nlm.nih.gov/42289244/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Nieman LK, Biller BMK, Findling JW, et al.</strong> <em>The diagnosis of Cushing's syndrome: an Endocrine Society Clinical Practice Guideline.</em> Journal of Clinical Endocrinology &amp; Metabolism. 2008;93(5):1526–1540. doi: 10.1210/jc.2008-0125. <a href="https://pubmed.ncbi.nlm.nih.gov/18334580/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Fassnacht M, Tsagarakis S, Terzolo M, et al.</strong> <em>European Society of Endocrinology clinical practice guidelines on the management of adrenal incidentalomas.</em> European Journal of Endocrinology. 2023;189(1):G1–G42. doi: 10.1093/ejendo/lvad066. <a href="https://pubmed.ncbi.nlm.nih.gov/37318239/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Nieman LK, Biller BMK, Findling JW, et al.; Endocrine Society.</strong> <em>Treatment of Cushing's Syndrome: An Endocrine Society Clinical Practice Guideline.</em> Journal of Clinical Endocrinology &amp; Metabolism. 2015;100(8):2807–2831. doi: 10.1210/jc.2015-1818. <a href="https://pubmed.ncbi.nlm.nih.gov/26222757/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Lucci CP, McCoy G.</strong> <em>Identification of Endogenous Hypercortisolism and the Effect of Mifepristone Treatment in Patients With Difficult-to-Manage Diabetes: A Case Series.</em> Diabetes Spectrum. 2025;38(5):550–560. doi: 10.2337/ds25-0035. <a href="https://pubmed.ncbi.nlm.nih.gov/41522275/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12784433/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>DeFronzo RA, Auchus RJ, Bancos I, et al.</strong> <em>Study protocol for a prospective, multicentre study of hypercortisolism in patients with difficult-to-control type 2 diabetes (CATALYST).</em> BMJ Open. 2024;14:e081121. doi: 10.1136/bmjopen-2023-081121. <a href="https://pubmed.ncbi.nlm.nih.gov/39013654/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>U.S. National Library of Medicine.</strong> <em>Korlym (mifepristone): current U.S. prescribing information.</em> <a href="https://dailymed.nlm.nih.gov/dailymed/drugInfo.cfm?setid=542f3fae-8bc8-4f00-9228-e4b66c9ad6a9" target="_blank" rel="noopener noreferrer">DailyMed</a>.</li>
</ol>

<p><em><strong>Poznámka k vecnej kontrole:</strong> Bibliografické údaje, autori, číselné výsledky a bezpečnostné udalosti boli overené v PubMed, PubMed Central, ClinicalTrials.gov a aktuálnej informácii DailyMed. Oproti východiskovému textu bolo oddelené jednorazové pozitívne skríningové vyšetrenie od potvrdeného Cushingovho syndrómu, opravené načasovanie DST, odstránená neprimeraná schéma „pozitívny DST → zobrazovanie → liečba“, doplnené limity pri CKD a vypustené tvrdenia o nefroprotektívnom účinku mifepristónu. Štúdia CATALYST aj redakčná podpora boli financované výrobcom mifepristónu; táto skutočnosť patrí do interpretácie výsledkov.</em></p>

<p><em>Text má odborný informačný charakter. Diagnostika a liečba endogénneho hyperkortizolizmu patria do spolupráce s endokrinológom a nenahrádzajú individuálne klinické rozhodovanie.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
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