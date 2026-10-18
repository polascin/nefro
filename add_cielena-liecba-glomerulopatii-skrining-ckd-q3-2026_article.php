<?php
/**
 * add_cielena-liecba-glomerulopatii-skrining-ckd-q3-2026_article.php
 * Odborný článok: Cielená liečba glomerulopatií a skríning chronickej choroby obličiek: klinická analýza regulačných a odborných míľnikov 3. štvrťroka 2026
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
    'title'        => 'Cielená liečba glomerulopatií a skríning chronickej choroby obličiek: klinická analýza regulačných a odborných míľnikov 3. štvrťroka 2026',
    'slug'         => 'cielena-liecba-glomerulopatii-skrining-ckd-q3-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Tretí štvrťrok 2026 priniesol sériu prelomových rozhodnutí v nefrológii: zrýchlené schválenie ataciceptu (Trutakna) pri IgA nefropatii na základe štúdie ORIGIN 3, klinické dáta inhibítora faktora B iptacopanu (Fabhalta) pri C3 glomerulopatii (APPEAR-C3G), výsledky finerenónu pri diabete 1. typu s CKD (FINE-ONE), prioritné posúdenie obinutuzumabu pri primárnej membranóznej nefropatii (MAJESTY) a nové odporúčania ESC/ERA 2026 pre duálny skríning CKD.',
    'content'      => <<<'HTML'
<h2>Úvod: Od nešpecifickej imunosupresie k molekulárne cielenej nefroprotekcii</h2>
<p>Liečba primárnych glomerulopatií sa desaťročia opierala o systémové kortikosteroidy, alkylačné cytostatiká a inhibítory kalcineurínu, ktoré popri čiastočnej kontrole proteinúrie prinášali významnú metabolickú, infekčnú a nefrotoxickú záťaž. Tretí štvrťrok 2026 potvrdil definitívny posun klinickej nefrológie k patogeneticky cieleným bioliečivám a malým molekulám, ktorých schválenie alebo prioritné regulačné posúdenie sa opiera o robustné randomizované štúdie fázy 3 publikované v časopise <em>New England Journal of Medicine</em> a <em>The Lancet</em>.<sup>1–5</sup></p>

<p>Súčasne s nástupom duálnej inhibície cytokínov BAFF a APRIL pri imunoglobulínovej A nefropatii (IgAN), blokády faktora B alternatívnej dráhy komplementu pri C3 glomerulopatii (C3G), nesteroidnej blokády mineralokortikoidového receptora pri diabetickej chorobe obličiek v rámci diabetu 1. typu (T1D) a anti-CD20 liečby II. generácie pri primárnej membranóznej nefropatii (pMN) priniesli nové spoločné odporúčania Európskej kardiologickej spoločnosti (ESC) a Európskej renálnej asociácie (ERA) z roku 2026 zásadnú zmenu v populačnom vyhľadávaní chronickej choroby obličiek (CKD) u kardiovaskulárne rizikových pacientov.<sup>1–6</sup> Cieľom tohto odborného prehľadu je kriticky analyzovať mechanizmus účinku, silu dôkazov, rozdiel medzi zástupnými ukazovateľmi (proteinúria) a dlhodobými renálnymi cieľmi (sklon krivky eGFR, zlyhanie obličiek) a bezpečnostné požiadavky jednotlivých terapeutických postupov.</p>

<figure class="article-figure">
  <img src="img/cielena-liecba-glomerulopatii-skrining-ckd-q3-2026.png" alt="Molekulárne cielená ochrana glomerulárnej filtračnej bariéry pomocou monoklonálnych protilátok, fúznych proteínov a malých molekúl" width="1600" height="1000" loading="lazy">
  <figcaption><strong>Obrázok 1.</strong> Koncepčná vizualizácia cieleného zásahu do patogenézy glomerulopatií: blokáda humorálnej autoimunity (BAFF/APRIL, CD20), alternatívnej dráhy komplementu (faktor B) a mineralokortikoidovej zápalovo-fibrotickej signalizácie pri ochrane glomerulárnej filtračnej bariéry.</figcaption>
</figure>

<h2>1. IgA nefropatia: atacicept (Trutakna) a vzťah medzi redukciou proteinúrie a spomalením poklesu eGFR</h2>

<h3>Patogenetický cieľ a regulačný rámec</h3>
<p>Patogenéza primárnej IgA nefropatie sa odvíja od viackrokového („four-hit“) modelu: zvýšená produkcia galaktózovo-deficientného imunoglobulínu A1 (Gd-IgA1, 1. zásah) spúšťa tvorbu špecifických IgG alebo IgA autoprotilátok (2. zásah), vznik cirkulujúcich imunokomplexov (3. zásah) a ich ukladanie v mezangiu s následnou aktiváciou komplementu, proliferáciou mezangiálnych buniek a poškodením podocytov (4. zásah). Cytokíny <strong>BAFF</strong> (B-cell activating factor, známy aj ako BLyS) a <strong>APRIL</strong> (a proliferation-inducing ligand) zohrávajú ústrednú úlohu pri prežívaní, diferenciácii B-lymfocytov a plazmatických buniek produkujúcich Gd-IgA1 aj príslušné autoprotilátky.</p>

<p><strong>Atacicept (Trutakna, atacicept-vymj)</strong> je rekombinantný fúzny proteín spájajúci extracelulárnu väzbovú doménu receptora TACI (transmembrane activator and CAML interactor) s modifikovaným Fc fragmentom ľudského IgG1, čím duálne viaže a neutralizuje BAFF aj APRIL.<sup>1,2</sup> Americký Úrad pre kontrolu potravín a liečiv (U.S. FDA) udelil 7. júla 2026 prípravku Trutakna zrýchlené schválenie (<em>accelerated approval</em>) na redukciu proteinúrie u dospelých s primárnou IgA nefropatiou s vysokým rizikom progresie ochorenia. Liek sa podáva v dávke <strong>150 mg subkutánne 1-krát týždenne</strong> v domácom prostredí.<sup>1,2</sup></p>

<h3>Dôkazy zo štúdie fázy 3 ORIGIN 3</h3>
<p>Podkladom regulačného rozhodnutia bola preddefinovaná priebežná analýza multicentrickej, randomizovanej, dvojito zaslepenej, placebom kontrolovanej štúdie fázy 3 <strong>ORIGIN 3</strong> (NCT04716231), ktorú publikovali Lafayette a spolupracovníci v časopise <em>New England Journal of Medicine</em>.<sup>2</sup> Do štúdie boli zaradení dospelí pacienti s biopsiou potvrdenou primárnou IgAN, 24-hodinovou proteinúriou ≥ 1,0 g/deň alebo pomerom celkových bielkovín k kreatinínu v 24-hodinovom zbere moču (UPCR) ≥ 0,75 g/g a odhadovanou glomerulárnou filtráciou (eGFR) ≥ 30 ml/min/1,73 m<sup>2</sup> napriek maximálne tolerovanej stabilnej blokáde renín-angiotenzínového systému (RAS) počas najmenej 12 týždňov.<sup>2</sup></p>

<ul>
  <li><strong>Analyzovaná populácia:</strong> Priebežná analýza účinnosti zahŕňala prvých <strong>203 randomizovaných pacientov</strong>, z ktorých 106 dostávalo atacicept 150 mg subkutánne 1× týždenne a 97 dostávalo placebo.<sup>2</sup></li>
  <li><strong>Primárny ukazovateľ v 36. týždni:</strong> Pomer UPCR z 24-hodinového zberu moču klesol oproti východiskovej hodnote o <strong>45,7 %</strong> v skupine s ataciceptom v porovnaní so <strong>6,8 %</strong> v skupine s placebom. Geometrický priemer medziskupinového rozdielu predstavoval redukciu o <strong>41,8 percentuálneho bodu</strong> v prospech ataciceptu (95 % interval spoľahlivosti [CI] 28,9 až 52,3; <em>p</em> &lt; 0,001).<sup>1,2</sup></li>
  <li><strong>Biologická odpoveď a bezpečnosť:</strong> Liečba viedla k výraznému a skorému poklesu sérových koncentrácií Gd-IgA1, IgA, IgG a IgM, ako aj k ústupu mikroskopickej hematúrie. Nežiaduce udalosti počas liečby sa vyskytli u <strong>59,3 %</strong> pacientov na atacicepte oproti <strong>50,0 %</strong> na placebe, pričom väčšina mala miernu až strednú závažnosť a neviedla k prerušeniu liečby.<sup>2</sup></li>
</ul>

<h3>Klinická interpretácia: proteinúria ako zástupný ukazovateľ verzus dvojročný sklon eGFR</h3>
<p>V klinickej praxi je nevyhnutné rozlišovať medzi včasnou redukciou proteinúrie (v 36. týždni), ktorá v regulačnom rámci FDA slúži ako zástupný (surogátny) ukazovateľ pravdepodobne predikujúci klinický prínos, a dlhodobým zachovaním funkcie obličiek. V samotnom texte schválenia FDA z júla 2026 sa uvádza, že v čase zrýchleného schválenia nebolo definitívne potvrdené, či Trutakna spomaľuje dlhodobý pokles funkcie obličiek, pričom potvrdenie klinického benefitu závisí od dokončenia konfirmačnej dvojročnej fázy štúdie ORIGIN 3.<sup>1</sup> Následne prezentované dvojročné výsledky štúdie ORIGIN 3 v 3. štvrťroku 2026 doplnili obraz o priaznivý vplyv na stabilizáciu dvojročného sklonu krivky eGFR.<sup>9</sup> Z bezpečnostného hľadiska si duálna inhibícia BAFF/APRIL vyžaduje kontrolu hladín imunoglobulínov, obozretnosť pri infekciách a vyhýbanie sa podávaniu živých atenuovaných vakcín bezprostredne pred začatím a počas liečby.<sup>1</sup></p>

<h2>2. C3 glomerulopatia: iptacopan (Fabhalta) ako perorálny inhibítor faktora B</h2>

<h3>Mechanizmus účinku a regulačné zaradenie</h3>
<p><strong>Komplementová 3 glomerulopatia (C3G)</strong> je zriedkavé chronické glomerulárne ochorenie (choroba z depozitov denzných pruhov [DDD] a C3 glomerulonefritída [C3GN]) vyvolané dysreguláciou a hyperaktiváciou alternatívnej dráhy komplementu v tekutej fáze aj na povrchu glomerulárnych štruktúr. Nadmerné štiepenie C3 konvertázou C3bBb vedie k masívnemu ukladaniu C3 a jeho štiepnych produktov v glomeruloch, zápalovej reakcii a progresívnemu zjazveniu parenchýmu.<sup>3</sup></p>

<p><strong>Iptacopan (Fabhalta)</strong> je selektívny, perorálne podávaný malomolekulový inhibítor <strong>faktora B</strong>, ktorý blokuje aktivitu C3 konvertázy alternatívnej dráhy (C3bBb) bez narušenia klasickej a lektínovej dráhy komplementu.<sup>3</sup> Hoci samotné schválenie FDA pre indikáciu redukcie proteinúrie u dospelých s C3G prebehlo už v marci 2025 ako vôbec prvá schválená cielená liečba tohto ochorenia, v roku 2026 sa klinická pozornosť sústredila na plné publikované dáta štúdie fázy 3 <strong>APPEAR-C3G</strong> a skúsenosti z predĺženého sledovania a reálnej praxe.<sup>3,4</sup></p>

<h3>Výsledky štúdie fázy 3 APPEAR-C3G</h3>
<p>Kavanagh a spolupracovníci publikovali v časopise <em>The Lancet</em> výsledky multicentrickej, randomizovanej, dvojito zaslepenej, placebom kontrolovanej štúdie fázy 3 <strong>APPEAR-C3G</strong> (NCT04817618).<sup>3</sup> Zaradených bolo <strong>74 dospelých pacientov</strong> (vo veku 18 až 60 rokov) s biopsiou potvrdenou C3G, zníženou sérovou koncentráciou C3 (&lt; 77 mg/dl), pretrvávajúcou proteinúriou (UPCR ≥ 1,0 g/g) a eGFR ≥ 30 ml/min/1,73 m<sup>2</sup> na maximálne tolerovanej dávke inhibítora ACE alebo sartanov. Pacienti boli randomizovaní v pomere 1 : 1 na perorálny <strong>iptacopan 200 mg 2-krát denne</strong> (<em>n</em> = 38) alebo placebo (<em>n</em> = 36) počas 6 mesiacov dvojito zaslepenej fázy, po ktorej nasledovalo 6-mesačné otvorené pokračovanie liečby iptacopanom u všetkých účastníkov.<sup>3</sup></p>

<ul>
  <li><strong>Primárny ukazovateľ po 6 mesiacoch:</strong> V skupine s iptacopanom došlo k zmene 24-hodinového UPCR oproti východiskovej hodnote o <strong>−30,2 %</strong> (95 % CI −42,8 až −14,8), zatiaľ čo v skupine s placebom sa 24-hodinový UPCR zvýšil o <strong>+7,6 %</strong> (95 % CI −11,9 až +31,3). Primárny cieľ bol splnený s relatívnou redukciou 24-hodinového UPCR o <strong>35,1 %</strong> v prospech iptacopanu oproti placebu (95 % CI 13,8 až 51,1; <em>p</em> = 0,0014).<sup>3,4</sup></li>
  <li><strong>Pretrvávanie odpovede:</strong> Priaznivý účinok na proteinúriu sa udržal až do 12. mesiaca v otvorenej fáze sledovania, pričom u pacientov prevedených z placeba na iptacopan po 6. mesiaci nastal porovnateľný pokles proteinúrie a normalizácia sérového C3.<sup>3,4</sup></li>
</ul>

<h3>Bezpečnostné implikácie blokády alternatívnej dráhy komplementu</h3>
<p>Keďže alternatívna dráha komplementu zabezpečuje opsonizáciu a lýzu opuzdrených baktérií, liečba iptacopanom nesie zvýšené riziko závažných až život ohrozujúcich infekcií spôsobených <strong>opuzdrenými patogénmi</strong>, predovšetkým <em>Streptococcus pneumoniae</em>, <em>Neisseria meningitidis</em> a <em>Haemophilus influenzae</em> typu b.<sup>3,4</sup> V USA je indikácia viazaná na bezpečnostný program REMS (<em>Risk Evaluation and Mitigation Strategy</em>) a varovanie v rámčeku (<em>Boxed Warning</em>): pacienti musia mať ukončené očkovanie proti meningokokom (skupiny A, C, W, Y a B) a pneumokokom najmenej 2 týždne pred prvou dávkou iptacopanu; ak klinický stav vyžaduje neodkladné začatie liečby skôr, je nevyhnutná súbežná antibakteriálna profylaxia a dôsledná edukácia pacienta o včasných príznakoch febrilného alebo meningeálneho stavu.<sup>3,4</sup></p>

<h2>3. Nesteroidný antagonista mineralokortikoidového receptora finerenón (Kerendia) pri diabete 1. typu a CKD</h2>

<h3>Prekročenie hraníc diabetu 2. typu: štúdia FINE-ONE</h3>
<p>Nesteroidný selektívny antagonista mineralokortikoidového receptora (nsMRA) <strong>finerenón (Kerendia)</strong> mal doteraz pevné postavenie v nefroprotekcii a kardioprotekcii pri CKD spojenej s diabetom 2. typu (štúdie FIDELIO-DKD a FIGARO-DKD). Pacienti s <strong>diabetom 1. typu (T1D)</strong> a chronickou chorobou obličiek však zostávali takmer tri desaťročia bez novej schválenej renoprotektívnej farmakoterapie nad rámec inhibície RAS, keďže gliflozíny (SGLT2 inhibítory) narážajú pri T1D na riziko euglykemickej diabetickej ketoacidózy.<sup>5</sup></p>

<p>V roku 2026 publikovali Heerspink a spolupracovníci v časopise <em>New England Journal of Medicine</em> výsledky prelomovej štúdie fázy 3 <strong>FINE-ONE</strong> (NCT05901831), ktoré sa premietli aj do aktualizácie regulačnej dokumentácie prípravku Kerendia.<sup>5,6</sup> Do dvojito zaslepenej štúdie bolo v 82 centrách v 9 krajinách zaradených <strong>242 dospelých s diabetom 1. typu</strong>, CKD s eGFR 25 až &lt; 90 ml/min/1,73 m<sup>2</sup>, závažnou albuminúriou (pomer albumínu k kreatinínu v moči [UACR] 200 až &lt; 5 000 mg/g) a sérovým draslíkom ≤ 4,8 mmol/l na štandardnej liečbe inhibítorom ACE alebo sartanom. Pacienti boli randomizovaní v pomere 1 : 1 na finerenón (10 alebo 20 mg denne podľa eGFR; <em>n</em> = 120) alebo placebo (<em>n</em> = 122) počas 6 mesiacov.<sup>5</sup></p>

<ul>
  <li><strong>Účinnosť na albuminúriu:</strong> Priemerný relatívny pokles UACR počas 6 mesiacov dosiahol <strong>34 %</strong> v skupine s finerenónom (pomer geometrických priemerov oproti východiskovej hodnote 0,66) oproti <strong>12 %</strong> v skupine s placebom (pomer 0,88), čo zodpovedá o <strong>25 % väčšej relatívnej redukcii UACR</strong> pri liečbe finerenónom (pomer geometrických priemerov 0,75; 95 % CI 0,65 až 0,87; <em>p</em> &lt; 0,001).<sup>5</sup></li>
  <li><strong>Bezpečnosť a hyperkaliémia:</strong> Epizódy hyperkaliémie boli hlásené u <strong>10,1 %</strong> pacientov (12 zo 119) v skupine s finerenónom oproti <strong>3,3 %</strong> (4 zo 122) v skupine s placebom; len u <strong>1,7 %</strong> pacientov (2 osoby) na finerenóne viedla hyperkaliémia k trvalému vysadeniu liečby.<sup>5</sup></li>
</ul>

<p>Pre klinickú prax z toho vyplýva, že pri rozširovaní indikácie finerenónu na populáciu s T1D a albuminurickou CKD je kľúčové dodržať vstupné a monitorovacie kritériá sérového draslíka (vstupne ≤ 4,8 mmol/l, kontrola po 4 týždňoch od začatia alebo úpravy dávky) a presne rešpektovať populáciu definovanú v súhrne charakteristických vlastností lieku.<sup>5,6</sup></p>

<h2>4. Primárna membranózna nefropatia: obinutuzumab (Gazyva/Gazyvaro) verzus takrolimus v štúdii MAJESTY</h2>

<h3>Regulačný míľnik a dizajn štúdie MAJESTY</h3>
<p>Dňa 15. júla 2026 udelil U.S. FDA štatút prioritného posúdenia (<em>Priority Review</em>) doplnkovej žiadosti sBLA pre humanizovanú anti-CD20 monoklonálnu protilátku II. generácie <strong>obinutuzumab (Gazyva/Gazyvaro)</strong> v liečbe dospelých s <strong>primárnou membranóznou nefropatiou (pMN)</strong>, s očakávaným regulačným rozhodnutím do novembra 2026.<sup>7</sup> Obinutuzumab je glykozinžiniersky modifikovaná anti-CD20 protilátka typu II, ktorá v porovnaní s chimerickým rituximabom (typ I) vyvoláva silnejšiu priamu bunkovú smrť B-lymfocytov a výraznejšiu na protilátkach závislú bunkovú cytotoxicitu (ADCC) pri nižšej závislosti od komplementu.</p>

<p>Dôkazovým základom je multicentrická, randomizovaná, otvorená, aktívne kontrolovaná štúdia fázy 3 <strong>MAJESTY</strong> (NCT04629248), ktorú publikovali Fervenza a spolupracovníci v časopise <em>New England Journal of Medicine</em>.<sup>8</sup> Celkovo <strong>142 dospelých pacientov</strong> s biopsiou potvrdenou pMN a vysokým rizikom progresie bolo randomizovaných v pomere 1 : 1 na intravenózny <strong>obinutuzumab</strong> (<em>n</em> = 71; 1 000 mg v 1. a 15. deň a následne v 24. a 26. týždni) alebo perorálny <strong>takrolimus</strong> (<em>n</em> = 71, z toho 70 liečených; podávaný počas 52 týždňov s postupným vysadzovaním do 76. týždňa).<sup>8</sup></p>

<ul>
  <li><strong>Primárny ukazovateľ (kompletná remisia v 104. týždni):</strong> Prísne definovanú kompletnú remisiu v 2. roku (UPCR ≤ 0,3 g/g pri stabilnej hodnote eGFR a normalizácii sérového albumínu) dosiahlo <strong>26 zo 71 pacientov (36,9 %; pri mnohonásobnej imputácii 37 %)</strong> v skupine s obinutuzumabom v porovnaní so <strong>4 zo 70 pacientov (5,7 %; 6 %)</strong> v skupine s takrolimom. Upravený rozdiel predstavoval <strong>31 percentuálnych bodov</strong> v prospech obinutuzumabu (95 % CI 18 až 44; <em>p</em> &lt; 0,001).<sup>7,8</sup></li>
  <li><strong>Sekundárne a imunologické ukazovatele:</strong> Obinutuzumab bol štatisticky významne účinnejší aj v dosiahnutí celkovej remisie (kompletnej alebo parciálnej) v 104. týždni, v rýchlosti a hĺbke imunologickej remisie (eradikácia protilátok proti receptoru pre fosfolipázu A2 [anti-PLA2R]) a v udržaní remisie po vysadení takrolimu, pri ktorom typicky dochádzalo k častým relapsom.<sup>8</sup></li>
  <li><strong>Bezpečnostný profil:</strong> Nežiaduce udalosti stupňa ≥ 3 sa vyskytli u <strong>22 %</strong> pacientov (16 osôb) na obinutuzumabe oproti <strong>19 %</strong> (13 osôb) na takrolime; závažné nežiaduce udalosti u <strong>17 %</strong> (12 osôb) oproti <strong>14 %</strong> (10 osôb). Celková miera infekcií bola <strong>61 verzus 57 na 100 pacientorokov</strong> a miera závažných infekcií <strong>3 verzus 4 na 100 pacientorokov</strong>. Medzi špecifické nežiaduce účinky obinutuzumabu patrili reakcie súvisiace s infúziou, infekcie horných dýchacích ciest a neutropénia.<sup>8</sup></li>
</ul>

<div class="table-responsive">
  <table class="article-table">
    <thead>
      <tr>
        <th>Liek (názov)</th>
        <th>Molekulárny cieľ a podávanie</th>
        <th>Indikácia a registračná štúdia</th>
        <th>Primárny výsledok účinnosti</th>
        <th>Kľúčové bezpečnostné špecifiká</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><strong>Atacicept-vymj</strong> (Trutakna)</td>
        <td>Duálny inhibítor BAFF a APRIL (TACI-Fc fúzny proteín); 150 mg s.c. 1× týždenne</td>
        <td>Primárna IgA nefropatia; štúdia fázy 3 <strong>ORIGIN 3</strong> (<em>N</em> = 203 v interim analýze)<sup>1,2</sup></td>
        <td>Pokles 24-h UPCR v 36. týždni o <strong>45,7 % vs. 6,8 %</strong> (medziskupinový rozdiel 41,8 %; <em>p</em> &lt; 0,001)</td>
        <td>Hypogamaglobulinémia, riziko infekcií, zákaz živých vakcín počas liečby; zrýchlené schválenie FDA (7. 7. 2026)</td>
      </tr>
      <tr>
        <td><strong>Iptacopan</strong> (Fabhalta)</td>
        <td>Selektívny inhibítor faktora B alternatívnej dráhy komplementu; 200 mg p.o. 2× denne</td>
        <td>C3 glomerulopatia (C3G); štúdia fázy 3 <strong>APPEAR-C3G</strong> (<em>N</em> = 74)<sup>3,4</sup></td>
        <td>Zmena 24-h UPCR v 6. mesiaci <strong>−30,2 % vs. +7,6 %</strong> (relatívna redukcia o <strong>35,1 %</strong>; <em>p</em> = 0,0014)</td>
        <td><em>Boxed Warning</em> a REMS pre závažné infekcie opuzdrenými baktériami (<em>S. pneumoniae</em>, <em>N. meningitidis</em>, <em>H. influenzae</em> b); povinné očkovanie/profylaxia</td>
      </tr>
      <tr>
        <td><strong>Finerenón</strong> (Kerendia)</td>
        <td>Nesteroidný selektívny antagonista MR (nsMRA); 10 alebo 20 mg p.o. 1× denne</td>
        <td>CKD s albuminúriou pri diabete 1. typu; štúdia fázy 3 <strong>FINE-ONE</strong> (<em>N</em> = 242)<sup>5,6</sup></td>
        <td>Pokles UACR za 6 mesiacov o <strong>34 % vs. 12 %</strong> (o <strong>25 %</strong> väčšia relatívna redukcia; GMR 0,75; <em>p</em> &lt; 0,001)</td>
        <td>Hyperkaliémia u <strong>10,1 % vs. 3,3 %</strong> (prerušenie liečby u 1,7 %); nutný monitoring sérového K<sup>+</sup></td>
      </tr>
      <tr>
        <td><strong>Obinutuzumab</strong> (Gazyva / Gazyvaro)</td>
        <td>Humanizovaná anti-CD20 protilátka typu II; 1 000 mg i.v. (deň 1, 15; týždeň 24, 26)</td>
        <td>Primárna membranózna nefropatia (pMN); štúdia fázy 3 <strong>MAJESTY</strong> (<em>N</em> = 142)<sup>7,8</sup></td>
        <td>Kompletná remisia v 104. týždni u <strong>36,9 % (26/71) vs. 5,7 % (4/70)</strong> na takrolime (rozdiel 31 p. b.; <em>p</em> &lt; 0,001)</td>
        <td>Reakcie pri infúzii, neutropénia, infekcie (závažné infekcie 3 vs. 4 na 100 pacientorokov); FDA <em>Priority Review</em> (15. 7. 2026)</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>5. Odporúčania ESC a ERA 2026: systematický duálny skríning CKD pri kardiovaskulárnych ochoreniach</h2>

<h3>Prečo samotný sérový kreatinín nestačí</h3>
<p>Popri cielených imunointervenčných liečbach v glomerulonéfrologii priniesol 3. štvrťrok 2026 aj zásadný klinický míľnik na pomedzí kardiológie a nefrológie: publikovanie vôbec prvých samostatných spoločných odporúčaní <strong>2026 ESC Guidelines for the management of cardiovascular disease and chronic kidney disease</strong>, vypracovaných pracovnou skupinou Európskej kardiologickej spoločnosti (ESC) v spolupráci s Európskou renálnou asociáciou (ERA) pod vedením Dammana a Herringtona v časopise <em>European Heart Journal</em>.<sup>9,10</sup></p>

<p>Ústredným posolstvom nových odporúčaní je požiadavka, aby sa hodnotenie stavu obličiek u každého pacienta s manifestným kardiovaskulárnym ochorením (KVO) alebo s vysokým kardiovaskulárnym rizikom opieralo o <strong>duálny skríning</strong> zahŕňajúci súčasne:<sup>9,10</sup></p>
<ol>
  <li><strong>Odhad glomerulárnej filtrácie (eGFR)</strong> zo sérového kreatinínu (a v indikovaných prípadoch kombinovane s cystatínom C na spresnenie klasifikácie a prognózy).</li>
  <li><strong>Kvantifikáciu albuminúrie pomocou pomeru albumínu k kreatinínu v jednorazovej vzorke moču (UACR)</strong>.</li>
</ol>

<p>Odporúčania ESC/ERA 2026 zdôrazňujú, že eGFR a UACR sú dva nezávislé, komplementárne a multiplikatívne prediktory kardiovaskulárnej mortality, srdcového zlyhávania, arytmií a progresie do zlyhania obličiek. Vynechávanie rutinného stanovenia UACR v kardiologických a internistických ambulanciách vedie k prehliadnutiu veľkej skupiny pacientov s zachovanou eGFR (štádiá G1 a G2), ktorí však pre prítomnosť albuminúrie (kategórie A2 alebo A3) nesú vysoké kardiorenálne riziko a jednoznačne profitujú z včasného nasadenia inhibítorov SGLT2, blokátorov RAS a nesteroidných MRA.<sup>9,10</sup></p>

<h2>Záver a praktické posolstvá pre klinickú prax</h2>
<ol>
  <li><strong>IgA nefropatia (atacicept):</strong> Subkutánna blokáda BAFF a APRIL raz týždenne prináša v štúdii ORIGIN 3 výraznú redukciu proteinúrie v 36. týždni (−45,7 % vs. −6,8 %); nefrológ však musí pri zrýchlených schváleniach sledovať aj konfirmačné dvojročné dáta o sklone eGFR a rešpektovať vakcinačné obmedzenia.<sup>1,2</sup></li>
  <li><strong>C3 glomerulopatia (iptacopan):</strong> Perorálna inhibícia faktora B v štúdii APPEAR-C3G redukuje 24-hodinový UPCR o 35,1 % oproti placebu a normalizuje hladiny C3, no vyžaduje striktnú vakcináciu a bdelosť voči invazívnym infekciám opuzdrenými baktériami.<sup>3,4</sup></li>
  <li><strong>CKD pri diabete 1. typu (finerenón):</strong> Štúdia FINE-ONE po prvýkrát preukázala v randomizovanom dizajne 25 % relatívnu redukciu UACR oproti placebu u pacientov s T1D a CKD pri akceptovateľnom a predvídateľnom riziku hyperkaliémie za predpokladu systematického monitorovania draslíka.<sup>5,6</sup></li>
  <li><strong>Primárna membranózna nefropatia (obinutuzumab):</strong> V priamom porovnaní štúdie MAJESTY šesťnásobne prevýšil obinutuzumab mieru kompletnej remisie v 2. roku oproti takrolimu (36,9 % vs. 5,7 %) pri porovnateľnom výskyte závažných infekcií, čo z neho robí silného kandidáta na prvolíniovú anti-CD20 terapiu pri vysoko rizikovej pMN.<sup>7,8</sup></li>
  <li><strong>Duálny skríning CKD (ESC/ERA 2026):</strong> Hodnotenie eGFR bez súčasného vyšetrenia UACR v moči je u pacientov s kardiovaskulárnym ochorením neúplné; systematická identifikácia oboch parametrov je vstupnou bránou k modernej kardiorenálnej ochrane.<sup>9,10</sup></li>
</ol>

<h2>Literatúra</h2>
<ol class="references-list">
  <li>U.S. Food and Drug Administration, Center for Drug Evaluation and Research. <em>FDA Approves New Treatment to Reduce Proteinuria in Adults with Primary Immunoglobulin A Nephropathy (Trutakna, atacicept-vymj)</em>. Silver Spring (MD): U.S. FDA; 7. júl 2026. Dostupné z: <a href="https://www.fda.gov/drugs/news-events-human-drugs/fda-approves-new-treatment-reduce-proteinuria-adults-primary-immunoglobulin-nephropathy" target="_blank" rel="noopener">https://www.fda.gov/drugs/news-events-human-drugs/fda-approves-new-treatment-reduce-proteinuria-adults-primary-immunoglobulin-nephropathy</a></li>
  <li>Lafayette R, Barbour SJ, Brenner RM, Campbell KN, Doan T, Eren N, Floege J, Jha V, Kim BS, Liew A, Maes B, Pal A, Pecoits-Filho R, Phoon RKS, Rizk DV, Suzuki H, Tesař V, Trimarchi H, Wei X, Zhang H, Barratt J; ORIGIN Phase 3 Trial Investigators. A Phase 3 Trial of Atacicept in Patients with IgA Nephropathy. <em>New England Journal of Medicine</em>. 2026;394(7):647–657. DOI: <a href="https://doi.org/10.1056/NEJMoa2510198" target="_blank" rel="noopener">10.1056/NEJMoa2510198</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/41196369/" target="_blank" rel="noopener">41196369</a>.</li>
  <li>Kavanagh D, Bomback AS, Vivarelli M, Nester CM, Remuzzi G, Zhao MH, Wong EKS, Wang Y, Krishnan I, Schuhmann I, Trapani AJ, Webb NJA, Meier M, Israni RK, Smith RJH; APPEAR-C3G investigators. Efficacy and safety of iptacopan in patients with C3 glomerulopathy (APPEAR-C3G): a randomised, double-blind, placebo-controlled, phase 3 trial. <em>The Lancet</em>. 2025;406(10512):1587–1598. DOI: <a href="https://doi.org/10.1016/S0140-6736(25)01148-1" target="_blank" rel="noopener">10.1016/S0140-6736(25)01148-1</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/41016405/" target="_blank" rel="noopener">41016405</a>.</li>
  <li>U.S. Food and Drug Administration. <em>FDA Approves First Treatment for Adults with Complement 3 Glomerulopathy, a Rare Kidney Disease, to Reduce Proteinuria (Fabhalta, iptacopan)</em>. Silver Spring (MD): U.S. FDA; 2025. Dostupné z: <a href="https://www.fda.gov/drugs/news-events-human-drugs/fda-approves-first-treatment-adults-complement-3-glomerulopathy-rare-kidney-disease-reduce" target="_blank" rel="noopener">https://www.fda.gov/drugs/news-events-human-drugs/fda-approves-first-treatment-adults-complement-3-glomerulopathy-rare-kidney-disease-reduce</a></li>
  <li>Heerspink HJL, Birkenfeld AL, Cherney DZI, Colhoun HM, Groop PH, Ji L, Jongs N, Mathieu C, Pratley RE, Rosas SE, Rossing P, Skyler JS, Tuttle KR, Lawatscheck R, Brinker M, Scheerer MF, Russell J, Schloemer P, McGill JB; FINE-ONE Investigators. Finerenone in Patients with Type 1 Diabetes and Chronic Kidney Disease. <em>New England Journal of Medicine</em>. 2026;394(10):947–957. DOI: <a href="https://doi.org/10.1056/NEJMoa2512854" target="_blank" rel="noopener">10.1056/NEJMoa2512854</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/41780000/" target="_blank" rel="noopener">41780000</a>.</li>
  <li>U.S. Food and Drug Administration. <em>Kerendia (finerenone) Prescribing Information, Supplement s009</em>. Silver Spring (MD): U.S. FDA; 2026. Dostupné z: <a href="https://www.accessdata.fda.gov/drugsatfda_docs/label/2026/215341Orig1s009lbl.pdf" target="_blank" rel="noopener">https://www.accessdata.fda.gov/drugsatfda_docs/label/2026/215341Orig1s009lbl.pdf</a></li>
  <li>F. Hoffmann-La Roche Ltd. <em>FDA grants Priority Review to Roche’s Gazyva/Gazyvaro for adults with primary membranous nephropathy</em>. Bazilej: Roche Media Release; 15. júl 2026. Dostupné z: <a href="https://www.roche.com/media/releases/med-cor-2026-07-15" target="_blank" rel="noopener">https://www.roche.com/media/releases/med-cor-2026-07-15</a></li>
  <li>Fervenza FC, Hou FF, Hao CM, Kirsztajn GM, Gesualdo L, Hryszko T, Pisani A, Roccatello D, Bomback AS, Rae J, Barmaki F, Berisha E, Schindler T, Omachi TA, Garg JP, Malvar A; MAJESTY Trial Investigators. Obinutuzumab or Tacrolimus in Primary Membranous Nephropathy. <em>New England Journal of Medicine</em>. 2026;395(10):959–971. DOI: <a href="https://doi.org/10.1056/NEJMoa2602678" target="_blank" rel="noopener">10.1056/NEJMoa2602678</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/42246654/" target="_blank" rel="noopener">42246654</a>.</li>
  <li>Damman K, Ter Maaten JM, Mayne KJ, Bolignano D, Brown EM, da Costa BR, Dagre A, Gansevoort RT, Gavina C, Goette A, Gorog DA, Gotcheva NN, Kałużna-Oleksy M, Kelly DM, Korzh O, Lees JS, Manfrini O, Martens P, Núñez J, Stabile E, Sudano I, Theodorakopoulou MP, Winther S, Herrington WG; ESC Guidelines Advisory Group. 2026 ESC Guidelines for the management of cardiovascular disease and chronic kidney disease: Developed by the task force for the management of cardiovascular disease and chronic kidney disease of the European Society of Cardiology (ESC), in collaboration with the European Renal Association (ERA). <em>European Heart Journal</em>. 2026;ehag098. DOI: <a href="https://doi.org/10.1093/eurheartj/ehag098" target="_blank" rel="noopener">10.1093/eurheartj/ehag098</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/42661426/" target="_blank" rel="noopener">42661426</a>.</li>
  <li>European Society of Cardiology (ESC). <em>2026 ESC Clinical Practice Guidelines on Cardiovascular Disease and Chronic Kidney Disease</em>. Sophia Antipolis: ESC; 2026. Dostupné z: <a href="https://www.escardio.org/guidelines/clinical-practice-guidelines/all-esc-practice-guidelines/cvd-chronic-kidney-disease/" target="_blank" rel="noopener">https://www.escardio.org/guidelines/clinical-practice-guidelines/all-esc-practice-guidelines/cvd-chronic-kidney-disease/</a></li>
  <li>Hillenbrand A (odborná kontrola: Derman C). <em>10 Nephrology Headlines You Missed in Q3 2026</em>. Monroe (NJ): HCPLive; 6. október 2026. Dostupné z: <a href="https://www.hcplive.com/view/10-nephrology-headlines-you-missed-in-q3-2026" target="_blank" rel="noopener">https://www.hcplive.com/view/10-nephrology-headlines-you-missed-in-q3-2026</a></li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_cielena-liecba-glomerulopatii-skrining-ckd-q3-2026_article',
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
