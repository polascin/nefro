<?php
/**
 * add_iga-nefropatia-kidney-week-2026-styri-studie-fazy-3_article.php
 * Idempotentný publikačný skript odborného článku.
 * Avíza sa pri publikovaní neposielajú ('enqueue_newsletter' => false);
 * rozosielanie riadi používateľ sám.
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
    'title'        => 'IgA nefropatia po Kidney Week 2026: štyri štúdie fázy 3 menia predstavu o liečbe',
    'slug'         => 'iga-nefropatia-kidney-week-2026-styri-studie-fazy-3',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kongres ASN Kidney Week 2026 v Denvery priniesol štyri štúdie fázy 3 pri IgA nefropatii. Pri aktívnej liečbe sa ročný sklon eGFR pohyboval od −0,6 do +0,3 ml/min/1,73 m² – na úrovni fyziologického poklesu (cieľ KDIGO 2025).',
    'content'      => <<<'HTML'
<figure><a href="img/iga-nefropatia-kidney-week-2026-styri-studie-fazy-3.webp" rel="noopener noreferrer" target="_blank"><img src="img/iga-nefropatia-kidney-week-2026-styri-studie-fazy-3.webp" alt="Polopriehľadný glomerulus žiariaci jantárovým svetlom na takmer čiernom pozadí" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna, nie snímka konkrétneho pacienta ani preparátu. Jantárové „iskry“ na glomerulových kapilárach symbolizujú ukladanie imunitných komplexov a aktiváciu komplementu pri IgA nefropatii.</figcaption></figure>

<p>Kongres American Society of Nephrology (ASN) Kidney Week 2026 (21.–25. októbra 2026, Denver, Colorado) priniesol zatiaľ najucelenejšiu dôkazovú základňu pre cielenú liečbu IgA nefropatie. <em>New England Journal of Medicine</em> počas dvoch dní (22. a 23. októbra 2026) zverejnil štyri randomizované štúdie fázy 3 – <a href="https://doi.org/10.1056/NEJMoa2609127" target="_blank" rel="noopener noreferrer">VISIONARY</a> (sibeprenlimab), <a href="https://doi.org/10.1056/NEJMoa2610103" target="_blank" rel="noopener noreferrer">ORIGIN 3</a> (atacicept), <a href="https://doi.org/10.1056/NEJMoa2608682" target="_blank" rel="noopener noreferrer">RAINIER</a> (povetacicept) a <a href="https://doi.org/10.1056/NEJMoa2607544" target="_blank" rel="noopener noreferrer">I CAN</a> (ravulizumab) – a na kongrese ich doplnili záverečné dvojročné výsledky čínskej štúdie TELIGAN (telitacicept). Spoločný záver: zásah do imunitných mechanizmov choroby dokáže u značnej časti pacientov prakticky zastaviť pokles glomerulovej filtrácie.</p>

<p>Práve čo najmenší pokles odhadovanej glomerulovej filtrácie (eGFR) je cieľom aktuálneho usmernenia KDIGO 2025: ročný pokles eGFR menej než 1 ml/min/1,73 m² a súčasne proteinúria pod 0,5 g/deň (ideálne pod 0,3 g/deň). V nových štúdiách sa tento cieľ podarilo dosiahnuť alebo sa k nemu výrazne priblížiť.</p>

<h2>Klinický kontext</h2>

<p>IgA nefropatia je najčastejšia primárna glomerulonefritída na svete a postihuje prevažne ľudí v produktívnom veku. Jej patogenézu opisuje štvorkrokový model: tvorba galaktózou deficitného IgA1 (Gd-IgA1), tvorba autoprotilátok proti nemu, vznik imunitných komplexov a ich ukladanie v mezangiu s aktiváciou komplementu.</p>

<p>Nové lieky zasahujú do dvoch uzlov tejto kaskády: do cytokínov BAFF (B-bunkový aktivačný faktor, z angl. <em>B-cell activating factor</em>) a APRIL (ligand indukujúci proliferáciu, z angl. <em>a proliferation-inducing ligand</em>), ktoré riadia produkciu patogénneho IgA, a do terminálnej dráhy komplementu (C5). Usmernenie KDIGO 2025 pre IgA nefropatiu a IgA vaskulitídu odporúča popri všeobecnej nefroprotektívnej liečbe (maximalizovaná inhibícia systému renín‑angiotenzín, inhibítor SGLT2, kontrola tlaku krvi) u rizikových pacientov cieľavedome zasahovať aj do chorobou špecifických imunitných mechanizmov.</p>

<h2>Sibeprenlimab (VISIONARY): ročný sklon eGFR na úrovni fyziologického poklesu</h2>

<p>Záverečná analýza štúdie VISIONARY zahŕňala 510 dospelých s biopsiou potvrdenou IgA nefropatiou, randomizovaných v pomere 1:1 k subkutánnemu sibeprenlimabu 400 mg alebo placebu každé 4 týždne (26 dávok počas 100 týždňov). Všetci mali optimalizovanú podpornú liečbu vrátane maximálne tolerovanej inhibície systému renín‑angiotenzín. Sibeprenlimab je humanizovaná monoklonálna protilátka, ktorá selektívne blokuje APRIL.</p>

<p>Kľúčový sekundárny ukazovateľ, ročný sklon eGFR za 24 mesiacov, bol v skupine so sibeprenlimabom +0,3 ml/min/1,73 m² (95 % IS −0,4 až 0,9) oproti −4,2 ml/min/1,73 m² (95 % IS −4,9 až −3,6) v placebovej skupine. Rozdiel medzi skupinami dosiahol 4,5 ml/min/1,73 m² za rok (95 % IS 3,6 až 5,4; p &lt; 0,001). Zmena eGFR oproti východiskovej hodnote po 24 mesiacoch bola v prospech sibeprenlimabu o 9,2 ml/min/1,73 m² (95 % IS 7,1 až 11,4; p &lt; 0,001; priemerná zmena +1,3 oproti −7,9 ml/min/1,73 m²). Zložený obličkový ukazovateľ (pokles funkcie obličiek alebo zlyhanie obličiek) zaznamenal 1 pacient (0,4 %) v skupine so sibeprenlimabom a 28 pacientov (11,2 %) v placebovej skupine; pomer hazardov bol 0,029 (95 % IS 0,004 až 0,214; p &lt; 0,001).</p>

<p>Bezpečnosť bola porovnateľná s placebom: nežiaduce udalosti sa vyskytli u 90,7 % oproti 90,0 % pacientov, závažné nežiaduce udalosti u 8,1 % oproti 12,7 % a závažné infekcie u 1,9 % oproti 4,0 %. Počas štúdie nezaznamenali žiadne úmrtie. Na základe údajov z prechodnej analýzy (v 9. mesiaci pokles 24‑hodinového pomeru bielkovín a kreatinínu v moči o 50,2 % oproti nárastu o 2,1 % pri placebe; upravený rozdiel −51,2 %, 96,5 % IS 42,9 až 58,2) získal sibeprenlimab (Voyxact, sibeprenlimab‑szsi) 25. novembra 2025 od amerického úradu FDA urýchlené schválenie na zníženie proteinúrie; výrobca už podáva priebežnú žiadosť o plné schválenie zahŕňajúcu 24‑mesačné údaje o eGFR.</p>

<h2>Atacicept (ORIGIN 3): dvojročné zachovanie funkcie obličiek</h2>

<p>Atacicept je rozpustný fúzny receptor TACI‑Fc, ktorý inhibuje BAFF aj APRIL. Vo finálnej analýze účinnosti štúdie ORIGIN 3, do ktorej bolo randomizovaných 431 dospelých s biopsiou potvrdenou primárnou IgA nefropatiou a perzistujúcou proteinúriou napriek maximálnej inhibícii systému renín‑angiotenzín (428 liečených, po 214 v skupine; atacicept 150 mg subkutánne týždenne), bola priemerná zmena eGFR v 52. týždni −0,11 ml/min/1,73 m² (95 % IS −1,44 až 1,22) s ataciceptom oproti −5,69 ml/min/1,73 m² (95 % IS −7,04 až −4,35) s placebom (rozdiel 5,58; 95 % IS 3,68 až 7,48; p &lt; 0,001). Ročný sklon eGFR do 104. týždňa bol −0,60 ml/min/1,73 m² (95 % IS −1,62 až 0,41) s ataciceptom oproti −5,60 ml/min/1,73 m² (95 % IS −6,64 až −4,57) s placebom (rozdiel 5,00; 95 % IS 3,55 až 6,45; p &lt; 0,001).</p>

<p>Progresia ochorenia obličiek sa vyskytla u 11 pacientov (5,1 %) s ataciceptom a u 38 pacientov (17,8 %) s placebom (pomer hazardov 0,24; 95 % IS 0,12 až 0,48; p &lt; 0,001). V skupine s ataciceptom žiadny pacient nezačal dialýzu, nepodstúpil transplantáciu obličky ani nezomrel; v placebovej skupine takýchto pacientov bolo 7 (jeden zomrel). Nežiaduce udalosti sa vyskytli u 74,8 % oproti 78,0 % a závažné nežiaduce udalosti u 7,0 % oproti 15,4 % pacientov. Atacicept (atacicept‑vymj, Trutakna) získal 7. júla 2026 od FDA urýchlené schválenie na zníženie proteinúrie; výrobca (Vera Therapeutics) plánuje v 4. štvrťroku 2026 podať na základe týchto údajov o eGFR žiadosť o plné schválenie.</p>

<h2>Povetacicept (RAINIER): najväčší pokles proteinúrie z prechodnej analýzy</h2>

<p>Povetacicept je vylepšený fúzny proteín TACI‑Fc, ktorý s vysokou afinitou blokuje BAFF aj APRIL. V preddefinovanej prechodnej analýze štúdie RAINIER, ktorej hlavnú kohortu tvorilo 557 dospelých randomizovaných v pomere 2:1 k povetaciceptu 80 mg alebo placebu subkutánne každé 4 týždne (spolu 605 účastníkov vrátane exploratórnej kohorty), sa hodnotili prví 199 účastníci (131 vs 68). V 36. týždni klesol 24‑hodinový pomer bielkovín a kreatinínu v moči s povetaciceptom o 52,0 % oproti 4,3 % s placebom (upravený rozdiel −49,8 percentuálneho bodu; 95 % IS −58,6 až −39,2; p &lt; 0,001). Pomer klesol pod 0,5 g/g u 42,2 % pacientov s povetaciceptom oproti 6,2 % s placebom.</p>

<p>Sekundárne ukazovatele potvrdili zásah do patogenézy: hladina Gd‑IgA1 klesla o 77,4 % (v placebovej skupine stúpla o 9,1 %) a hematúria vymizla u 85 % pacientov s východiskovou hematúriou oproti 23 % s placebom. Nežiaduce udalosti (75 % oproti 78 %) a závažné nežiaduce udalosti (3 % oproti 4 %) boli v oboch skupinách porovnateľné. FDA prijala žiadosť o povetacicept a stanovila cieľový dátum rozhodnutia (PDUFA) na 30. novembra 2026; finálnym ukazovateľom štúdie zostáva celkový sklon eGFR do 104. týždňa, ktorý zatiaľ nebol hodnotený.</p>

<h2>Ravulizumab (I CAN): prvý inhibítor terminálnej dráhy komplementu pri IgA nefropatii</h2>

<p>Ravulizumab je dlhodobo pôsobiaca monoklonálna protilátka proti C5, ktorá zabraňuje vzniku C5a a membránového útočného komplexu C5b‑9; podáva sa intravenózne každé 8 týždňov. V prechodnej analýze štúdie I CAN, do ktorej bolo randomizovaných 485 dospelých s eGFR najmenej 30 ml/min/1,73 m² a proteinúriou (24‑hodinový pomer bielkovín a kreatinínu v moči ≥ 0,75 g/g alebo celkové bielkoviny v moči ≥ 1,0 g/deň) napriek štandardnej liečbe (240 k ravulizumabu, 245 k placebu) a z ktorej bolo hodnotených prvých 352 pacientov (po 176), klesol v 34. týždni geometrický priemer 24‑hodinového pomeru bielkovín a kreatinínu v moči z 1,56 na 0,83 s ravulizumabom a z 1,60 na 1,48 s placebom. To zodpovedá poklesu o 46,6 % oproti 5,6 %; upravený pomer bol o 43,4 % nižší s ravulizumabom (99 % IS 30,1 až 54,2; p &lt; 0,001).</p>

<p>Nežiaduce udalosti boli v skupine s ravulizumabom menej časté (69,5 % oproti 75,8 %), závažné nežiaduce udalosti sa vyskytli u 4,6 % oproti 9,0 % pacientov. Meningokokové infekcie ani úmrtia sa nezaznamenali, čo je pri inhibícii C5 kľúčový bezpečnostný údaj; všetci účastníci boli pred liečbou zaočkovaní proti <em>Neisseria meningitidis</em> a liek je dostupný len cez osobitný bezpečnostný program (REMS). Na základe týchto údajov FDA udelila ravulizumabu (Ultomiris, ravulizumab‑cwvz) 21. októbra 2026 urýchlené schválenie pri IgA nefropatii – ide o prvý schválený liek zameraný na terminálnu dráhu komplementu v tejto indikácii. Údaje o dlhodobom sklone eGFR zatiaľ nie sú k dispozícii.</p>

<h2>Telitacicept (TELIGAN): dvojročné dáta z Číny</h2>

<p>Záverečné výsledky 104 týždňov štúdie TELIGAN, realizovanej v Číne na 318 dospelých s IgA nefropatiou (telitacicept 240 mg subkutánne týždenne do 39. týždňa, potom každé 2 týždne), ukázali ročný sklon eGFR −0,6 ml/min/1,73 m² s telitaciceptom oproti −5,7 ml/min/1,73 m² s placebom (rozdiel 5,1; 95 % IS 3,5 až 6,7; p &lt; 0,001). Potvrdený pokles eGFR o najmenej 30 % nastal u 2,5 % oproti 16,4 % pacientov (pomer hazardov 0,11; 95 % IS 0,04 až 0,30), teda o 89 % menej. Proteinúria v 104. týždni klesla o 60,7 % oproti placebu a zložené zlyhanie obličiek sa nevyskytlo u žiadneho pacienta s telitaciceptom oproti 3,1 % v placebovej skupine (5 pacientov, z nich 2 začali dialýzu). Závažné nežiaduce udalosti boli s telitaciceptom menej časté (8,2 % oproti 18,2 %), reakcie v mieste podania injekcie však výrazne častejšie (56,0 % oproti 18,9 %). Telitacicept má v Číne podmienené schválenie (jún 2026); údaje pochádzajú z kongresového abstraktu (TH‑OR111, prezentovaný 22. októbra 2026) a tlačovej správy výrobcov a ešte neprešli recenzným konaním v plnom texte.</p>

<h2>Prehľad štúdií</h2>

<div class="table-responsive" role="region" aria-label="Prehľad štúdií fázy 3 pri IgA nefropatii prezentovaných alebo zverejnených počas Kidney Week 2026" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia (liek)</th>
      <th scope="col">Cieľ lieku</th>
      <th scope="col">Populácia a sledovanie</th>
      <th scope="col">Hlavný výsledok</th>
      <th scope="col">Regulačný stav</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">VISIONARY (sibeprenlimab)</th>
      <td>anti‑APRIL</td>
      <td>510 dospelých, 24 mesiacov</td>
      <td>ročný sklon eGFR +0,3 vs −4,2 ml/min/1,73 m²/rok (rozdiel 4,5); zložený obličkový ukazovateľ 0,4 % vs 11,2 % (HR 0,029)</td>
      <td>urýchlené schválenie FDA 25. 11. 2025 (Voyxact)</td>
    </tr>
    <tr>
      <th scope="row">ORIGIN 3 (atacicept)</th>
      <td>anti‑BAFF/APRIL (TACI‑Fc)</td>
      <td>431 randomizovaných, 104 týždňov</td>
      <td>sklon eGFR −0,60 vs −5,60 ml/min/1,73 m²/rok (rozdiel 5,0); progresia 5,1 % vs 17,8 % (HR 0,24)</td>
      <td>urýchlené schválenie FDA 7. 7. 2026 (Trutakna)</td>
    </tr>
    <tr>
      <th scope="row">RAINIER (povetacicept)</th>
      <td>anti‑BAFF/APRIL (TACI‑Fc)</td>
      <td>557 v hlavnej kohorte, prechodná analýza v 36. týždni</td>
      <td>UPCR −52,0 % vs −4,3 %; Gd‑IgA1 −77,4 % vs +9,1 %; hematúria vymizla u 85 % vs 23 %</td>
      <td>rozhodnutie FDA očakávané 30. 11. 2026 (PDUFA)</td>
    </tr>
    <tr>
      <th scope="row">I CAN (ravulizumab)</th>
      <td>anti‑C5</td>
      <td>485 randomizovaných, prechodná analýza v 34. týždni</td>
      <td>UPCR −46,6 % vs −5,6 % (upravený rozdiel −43,4 %); žiadna meningokoková infekcia</td>
      <td>urýchlené schválenie FDA 21. 10. 2026 (Ultomiris)</td>
    </tr>
    <tr>
      <th scope="row">TELIGAN (telitacicept)</th>
      <td>anti‑BAFF/APRIL (TACI‑Fc)</td>
      <td>318 dospelých v Číne, 104 týždňov</td>
      <td>sklon eGFR −0,6 vs −5,7 ml/min/1,73 m²/rok (rozdiel 5,1); pokles eGFR ≥ 30 % u 2,5 % vs 16,4 % (HR 0,11)</td>
      <td>podmienené schválenie v Číne (VI/2026); abstrakt, nie plný text</td>
    </tr>
  </tbody>
</table>
</div>

<p>UPCR = 24‑hodinový pomer bielkovín a kreatinínu v moči; Gd‑IgA1 = galaktózou deficitný IgA1; HR = pomer hazardov; IS = interval spoľahlivosti.</p>

<h2>Spoločný obraz a otvorené otázky</h2>

<p>Napriek odlišným mechanizmom a ukazovateľom sa výsledky prelomovo zhodujú v jednom: v skupinách s aktívnou liečbou sa ročný sklon eGFR pohyboval od −0,6 do +0,3 ml/min/1,73 m², čo zodpovedá fyziologickému poklesu a cieľu KDIGO. Placebové skupiny strácali od 4,2 do 5,7 ml/min/1,73 m² ročne. Pokles proteinúrie, ktorý FDA akceptuje ako náhradný ukazovateľ pri urýchlenom schvaľovaní, bol konzistentný – od 43 % do 61 % oproti placebu – a v štúdiách s dvojročným hodnotením sa premietol do výrazného zníženia rizika progresie (pomer hazardov 0,029 pre sibeprenlimab, 0,24 pre atacicept a 0,11 pre telitacicept).</p>

<p>Pri interpretácii treba rešpektovať hranice dôkazov. Prechodné analýzy (RAINIER, I CAN) hodnotili len časť randomizovaných pacientov a proteinúria nie je rovnocenná s dlhodobým zachovaním funkcie obličiek. Štúdie neposkytujú priame porovnanie jednotlivých liekov navzájom – rozdiely v usporiadaní, populáciách a časových bodoch znemožňujú spoľahlivé zoradenie liekov podľa účinnosti. Účinnosť a bezpečnosť dlhšie než dva roky, pôsobenie u pacientov s pokročilou chronickou chorobou obličiek a otázka očkovania proti meningokokom pri dlhodobej inhibícii C5 zostávajú predmetom ďalšieho sledovania.</p>

<h2>Čo to znamená pre klinickú prax</h2>

<p>Pacient s IgA nefropatiou a proteinúriou pretrvávajúcou napriek podpornej liečbe je dnes skôr kandidátom na cielenú liečbu než len na sledovanie. O výbere konkrétneho lieku bude pravdepodobne viac než drobné rozdiely v účinnosti rozhodovať jeho dostupnosť a úhrada v konkrétnom systéme zdravotnej starostlivosti.</p>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie, aktuálny súhrn charakteristických vlastností lieku ani podmienky úhrady.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li>Rizk DV, Barratt J, Suzuki Y, Zhang H, Wong MG, Liew A, Lafayette R, Tesař V, Trimarchi H, Carroll K, Roberts ISD, Jha V, Quevedo A, Han SH, Yahya R, Cheung CK, Ramachandran R, Walsh M, Chacko B, Praga M, Chen JB, Suassuna J, Xia J, Shah L, Perkovic V; VISIONARY Trial Investigators Group. Sibeprenlimab in IgA Nephropathy – Final Phase 3 Trial Analysis. <em>New England Journal of Medicine</em>. 2026; publikované online 22. októbra 2026. <a href="https://doi.org/10.1056/NEJMoa2609127" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2609127</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42911185/" target="_blank" rel="noopener noreferrer">PubMed 42911185</a>.</li>
  <li>Barratt J, Brenner RM, Barbour SJ, Campbell KN, Doan T, Eren N, Floege J, Fordyce MW, Jha V, Khawaja Z, Kim BS, Liew A, Maes B, Pal A, Pecoits‑Filho R, Phoon RKS, Rizk DV, Suzuki H, Tesař V, Trimarchi H, Wei X, Yu L, Zhang H, Lafayette R; ORIGIN Phase 3 Trial Investigators. Atacicept in IgA Nephropathy – Phase 3 Trial Final Efficacy Analysis. <em>New England Journal of Medicine</em>. 2026; publikované online 22. októbra 2026. <a href="https://doi.org/10.1056/NEJMoa2610103" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2610103</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42911181/" target="_blank" rel="noopener noreferrer">PubMed 42911181</a>.</li>
  <li>Barratt J, Zhang H, Han SH, Suzuki Y, Tumlin J, Chacko B, Noronha IL, Madan A, Duivenvoorden R, Azzi JR, Nester C, Dong C, Ahluwalia N, Li J, Bozic C, Egbuna O, Wong MG, Lafayette R; RAINIER AIS‑D08 Trial Group. Interim Analysis of a Phase 3 Trial of Povetacicept in IgA Nephropathy. <em>New England Journal of Medicine</em>. 2026;395(18):1830–1840 (online 23. októbra 2026). <a href="https://doi.org/10.1056/NEJMoa2608682" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2608682</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42912669/" target="_blank" rel="noopener noreferrer">PubMed 42912669</a>.</li>
  <li>Barratt J, Farag YMK, Rice K, Cammett TJ, Inker LA, Trimarchi H, Bruchfeld A, Heerspink HJL, Liew A, Carroll K, Zhang H, Norouzi S, Hou S, Park S, Pérez Valdivia MÁ, Radhakrishnan J, Suzuki Y, Schneider B, Marsala J, Carrillo‑Infante C, Lake SL, Singh AK, Nolan S, Lafayette RA; I CAN Trial Group. Ravulizumab in IgA Nephropathy – Interim Analysis of a Phase 3 Trial. <em>New England Journal of Medicine</em>. 2026; publikované online 23. októbra 2026. <a href="https://doi.org/10.1056/NEJMoa2607544" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2607544</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42912700/" target="_blank" rel="noopener noreferrer">PubMed 42912700</a>.</li>
  <li>Lv J, Liu L, Tang S, Wang W, Reich HN, Li L, Mao W, Zhang Y, Fang J, Perkovic V, Zhang H; TELIGAN Investigators. Telitacicept for IgA Nephropathy: Final Two‑Year Results of the Phase 3 TELIGAN Trial. Abstrakt TH‑OR111, ASN Kidney Week 2026, Denver, 21.–25. októbra 2026 (prezentovaný 22. októbra 2026). <a href="https://www.asn-online.org/education/kidneyweek/2026/KW26_LBAs_TitlesAuthors.pdf" target="_blank" rel="noopener noreferrer">Zoznam autorov (ASN)</a>.</li>
  <li>Vor Bio / RemeGen. Telitacicept Demonstrates Durable Preservation of Kidney Function Through Two Years in Phase 3 TELIGAN Trial in IgA Nephropathy. Tlačová správa, GlobeNewswire, 22. októbra 2026. <a href="https://www.globenewswire.com/news-release/2026/10/22/3386893/0/en/telitacicept-demonstrates-durable-preservation-of-kidney-function-through-two-years-in-phase-3-teligan-trial-in-iga-nephropathy.html" target="_blank" rel="noopener noreferrer">GlobeNewswire</a>.</li>
  <li>Kidney Disease: Improving Global Outcomes (KDIGO) IgAN and IgAV Work Group. KDIGO 2025 Clinical Practice Guideline for the Management of Immunoglobulin A Nephropathy (IgAN) and Immunoglobulin A Vasculitis (IgAV). <em>Kidney International</em>. 2025;108(4S):S1–S71. <a href="https://doi.org/10.1016/j.kint.2025.04.004" target="_blank" rel="noopener noreferrer">doi:10.1016/j.kint.2025.04.004</a>.</li>
  <li>Perkovic V, Trimarchi H, Tesar V, Lafayette R, Wong MG, Barratt J, Suzuki Y, Liew A, Zhang H, Carroll K, Jha V, Quevedo A, Han SH, Praga M, Chacko B, Sahay M, Cheung CK, Kooienga L, Walsh M, Xia J, Fajardo C, Shah L, Hafkin J, Rizk DV; VISIONARY Trial Investigators Group. Sibeprenlimab in IgA Nephropathy – Interim Analysis of a Phase 3 Trial. <em>New England Journal of Medicine</em>. 2026;394(7):635–646. <a href="https://doi.org/10.1056/NEJMoa2512133" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2512133</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41211929/" target="_blank" rel="noopener noreferrer">PubMed 41211929</a>.</li>
  <li>Lafayette R, Barbour SJ, Brenner RM, Campbell KN, Doan T, Eren N, Floege J, Jha V, Kim BS, Liew A, Maes B, Pal A, Pecoits‑Filho R, Phoon RKS, Rizk DV, Suzuki H, Tesar V, Trimarchi H, Wei X, Zhang H, Barratt J; ORIGIN Phase 3 Trial Investigators. A Phase 3 Trial of Atacicept in Patients with IgA Nephropathy. <em>New England Journal of Medicine</em>. 2026;394(7):647–657. <a href="https://doi.org/10.1056/NEJMoa2510198" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2510198</a>.</li>
  <li>Brooks A. I CAN: Ravulizumab Cuts Proteinuria 43% vs Placebo in IgA Nephropathy. <em>HCPLive</em>, 2026. <a href="https://www.hcplive.com/view/i-can-ravulizumab-cuts-proteinuria-43-vs-placebo-in-iga-nephropathy" target="_blank" rel="noopener noreferrer">HCPLive</a>.</li>
  <li>McNulty R. Kidney Week 2026 Recap: IgAN Advances, Value-Based Care, CKD Care Gaps. <em>AJMC</em>, 30. októbra 2026. <a href="https://www.ajmc.com/view/kidney-week-2026-recap-igan-advances-value-based-care-ckd-care-gaps" target="_blank" rel="noopener noreferrer">AJMC</a>.</li>
  <li>Vertex Pharmaceuticals. Phase 3 RAINIER Results Supporting Best‑in‑Class Potential of Povetacicept in IgA Nephropathy Published in the New England Journal of Medicine and Presented at the American Society of Nephrology Kidney Week 2026. Tlačová správa, 23. októbra 2026. <a href="https://news.vrtx.com/news-releases/news-release-details/phase-3-rainier-results-supporting-best-class-potential" target="_blank" rel="noopener noreferrer">Vertex</a>.</li>
</ol>

<p><small><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje, úplné autorské zoznamy a všetky číselné výsledky boli overené 5. novembra 2026 v PubMed (metadáta a štruktúrované abstrakty PMID 42911185, 42911181, 42912669, 42912700 a 41211929) a v Crossref (DOI a autorské zoznamy). Regulačný stav liekov bol overený podľa tlačových správ výrobcov a správ o rozhodnutiach FDA (Otsuka 25. 11. 2025, Vera Therapeutics 7. 7. 2026 a 2. 6. 2026, AstraZeneca/Alexion 21. 10. 2026, Vertex – cieľový dátum PDUFA 30. 11. 2026) a dátum kongresu podľa oficiálnych materiálov ASN (21.–25. októbra 2026, Denver). Ciele liečby podľa KDIGO 2025 boli overené v plnom texte usmernenia. Údaje štúdie TELIGAN pochádzajú z kongresového abstraktu TH‑OR111 a tlačovej správy výrobcov (22. 10. 2026) a ešte neboli publikované ako recenzovaný plný text – v texte je to výslovne uvedené. Oproti podkladovému textu boli opravené autorské mená v citácii prechodnej analýzy VISIONARY (Fajardo C, Shah L, Hafkin J namiesto nesprávných mien), doplnené presné dátumy schválení FDA, názvy liekov (Voyxact, Trutakna, Ultomiris), časové body ukazovateľov (9. mesiac, 34., 36., 52. a 104. týždeň), percento vymiznutia hematúrie a nežiaduce udalosti v RAINIER podľa abstraktu a odstránený DOI kongresového abstraktu, ktorý nezodpovedal žiadnemu záznamu v registračnom systéme DOI.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=sibeprenlimab-povetacicept-ravulizumab-iga-nefropatia">Sibeprenlimab, povetacicept a ravulizumab pri IgA nefropatii: tri štúdie fázy 3</a></li>
  <li><a href="article.php?slug=trutakna-atacicept-iga-nefropatia-origin-3-finalna-analyza">Trutakna pri IgA nefropatii: finálna analýza ORIGIN 3 a význam pre prax</a></li>
  <li><a href="article.php?slug=atacicept-trutakna-iga-nefropatia-fda-proteinuria">Atacicept pri primárnej IgA nefropatii: čo znamená zrýchlené schválenie FDA</a></li>
  <li><a href="article.php?slug=telitacicept-iga-nefropatia-teligan-faza-3-interim">Telitacicept v IgA nefropatii: interim analýza fázy 3 (TELIGAN)</a></li>
  <li><a href="article.php?slug=inhibicia-april-baff-iga-nefropatia-faza-3">Inhibícia dráhy APRIL/BAFF pri IgA nefropatii: štúdie fázy 3</a></li>
  <li><a href="article.php?slug=komplement-oblicky-iga-nefropatia-inhibicia-klinik">Komplement v nefrológii: cielená inhibícia pri IgA nefropatii</a></li>
  <li><a href="article.php?slug=iga-nefropatia-kdigo-2025-kdoqi">IgA nefropatia podľa KDIGO 2025 a KDOQI US Commentary</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Avíza sa preto pri publikovaní neposielajú — používateľ ich riadi sám.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_iga-nefropatia-kidney-week-2026-styri-studie-fazy-3',
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
