<?php
/**
 * add_oblicka-v-centre-ckm-syndromu-kdigo_article.php
 * Odborný článok o CKM syndróme a integrovanom rámci odporúčaní KDIGO.
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Oblička v centre kardiovaskulárno-obličkovo-metabolického syndrómu: ako KDIGO prepája nefrológiu, diabetológiu a kardiológiu',
    'slug'         => 'oblicka-v-centre-ckm-syndromu-kdigo',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prehľad prepája CKD s kardiovaskulárnym a metabolickým rizikom a premieňa KDIGO 2024 na praktický rámec: eGFR, UACR, KFRE, RAS blokáda, SGLT2 inhibítory, finerenón a GLP-1 RA.',
    'content'      => <<<'HTML'
<p>Chronická choroba obličiek (CKD) nie je izolovaným ochorením jedného orgánu. V klinickej praxi sa tesne prelína s obezitou, diabetes mellitus 2. typu, artériovou hypertenziou, dyslipidémiou, srdcovým zlyhávaním a aterosklerotickým kardiovaskulárnym ochorením. Americká kardiologická asociácia (AHA) tieto vzájomne prepojené procesy v roku 2023 zastrešila pojmom <strong>kardiovaskulárno-obličkovo-metabolický syndróm</strong> (cardiovascular-kidney-metabolic syndrome, CKM syndróm).</p>

<p>Pre nefrológa má tento koncept zásadný význam. CKD zvyšuje kardiovaskulárne riziko už v skorých štádiách, pričom prognózu neurčuje iba pokles odhadovanej glomerulovej filtrácie (eGFR), ale aj albuminúria, príčina nefropatie, hypertenzia, diabetes, obezita, anémia, poruchy minerálového a kostného metabolizmu či retencia sodíka a tekutín. Metabolické a kardiovaskulárne ochorenia zároveň urýchľujú poškodenie obličiek.</p>

<p>Prehľadový článok Levina a spoluautorov ukazuje, že odporúčania organizácie Kidney Disease: Improving Global Outcomes (KDIGO) pre CKD, krvný tlak, diabetes a lipidy spolu s konsenzuálnymi správami o obezite a prevencii vytvárajú spoločný rámec pre CKM syndróm. Jeho hlavný odkaz je praktický: <strong>včas vyhľadať riziko, liečiť ho súčasne naprieč orgánmi a koordinovať starostlivosť medzi odbormi</strong>.</p>

<h2>Čo CKM syndróm pomenúva</h2>

<p>CKM syndróm je systémová porucha vyplývajúca z prepojenia nadmerného alebo dysfunkčného tukového tkaniva, metabolických rizikových faktorov, CKD a kardiovaskulárneho ochorenia. AHA ho opisuje v štádiách 0 až 4; nejde však o náhradu klasifikácie CKD podľa KDIGO, ale o širší rámec kardiovaskulárneho rizika.</p>

<div class="table-responsive" role="region" aria-label="Štádiá CKM syndrómu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štádium</th>
      <th scope="col">Charakteristika</th>
      <th scope="col">Ťažisko starostlivosti</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>0</td>
      <td>Bez identifikovaných rizikových faktorov CKM</td>
      <td>Primordiálna prevencia a zachovanie zdravia</td>
    </tr>
    <tr>
      <td>1</td>
      <td>Nadmerné alebo dysfunkčné tukové tkanivo, napríklad obezita alebo prediabetes</td>
      <td>Životný štýl, redukcia hmotnosti a prevencia progresie</td>
    </tr>
    <tr>
      <td>2</td>
      <td>Metabolické rizikové faktory, diabetes alebo CKD so stredným až vysokým rizikom</td>
      <td>Aktívna liečba rizikových faktorov a orgánová protekcia</td>
    </tr>
    <tr>
      <td>3</td>
      <td>Subklinické kardiovaskulárne ochorenie, veľmi vysoké riziko CKD alebo vysoké predikované kardiovaskulárne riziko</td>
      <td>Intenzívna multidisciplinárna prevencia klinických príhod</td>
    </tr>
    <tr>
      <td>4</td>
      <td>Manifestné kardiovaskulárne ochorenie; osobitne sa rozlišuje prítomnosť zlyhania obličiek</td>
      <td>Sekundárna prevencia a koordinovaná liečba komplikácií</td>
    </tr>
  </tbody>
</table>
</div>

<p>Takéto členenie zdôrazňuje, že pacient s CKD môže patriť do pokročilého CKM štádia aj bez prekonaného infarktu alebo cievnej mozgovej príhody. Veľmi vysoké renálne riziko je samo osebe ekvivalentom vysokého kardiovaskulárneho rizika.</p>

<h2>Obojsmerná patofyziológia</h2>

<p>Obezita, inzulínová rezistencia, hyperglykémia a artériová hypertenzia podporujú glomerulovú hyperfiltráciu, albuminúriu, glomerulosklerózu a tubulointersticiálne poškodenie. Postupujúca CKD následne potencuje hypertenziu, objemové preťaženie, aktiváciu sympatikového nervového systému a renínovo-angiotenzínového systému, endoteliálnu dysfunkciu, zápal, oxidačný stres a vaskulárnu kalcifikáciu.</p>

<p>Výsledkom je samoudržiavajúci sa kruh, ktorý zvyšuje riziko progresie CKD do zlyhania obličiek, hospitalizácií pre srdcové zlyhávanie, aterosklerotických príhod, fibrilácie predsiení a predčasného úmrtia. Rozsah problému je veľký: približne 850 miliónov ľudí na svete žije s ochorením obličiek a podľa 11. vydania atlasu International Diabetes Federation malo v roku 2024 diabetes približne 589 miliónov dospelých vo veku 20 až 79 rokov. Ide o populačné odhady, ktoré závisia od definície a metodiky.</p>

<h2>Včasné rozpoznanie CKD: eGFR nestačí</h2>

<p>KDIGO 2024 definuje CKD ako abnormality štruktúry alebo funkcie obličiek prítomné najmenej tri mesiace, ktoré majú dôsledky pre zdravie. Diagnóza preto nesmie byť založená na jedinom abnormálnom výsledku ani zúžená iba na eGFR. Medzi diagnostické markery patria aj albuminúria, abnormality močového sedimentu, perzistujúca hematúria glomerulového pôvodu, poruchy tubulárnych funkcií, histologický nález, štruktúrne abnormality pri zobrazovaní alebo stav po transplantácii obličky.</p>

<p>V bežnej praxi však zostávajú <strong>eGFR a pomer albumínu ku kreatinínu v moči (UACR)</strong> základnou dvojicou na detekciu a stratifikáciu rizika. CKD sa klasifikuje podľa príčiny, kategórie eGFR (G1 až G5) a kategórie albuminúrie (A1 až A3), teda systémom CGA. Kategórie G1 a G2 samy osebe CKD nepotvrdzujú, ak chýba iný marker poškodenia obličiek.</p>

<div class="table-responsive" role="region" aria-label="Kategórie albuminúrie podľa KDIGO" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória</th>
      <th scope="col">UACR</th>
      <th scope="col">Význam</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>A1</td>
      <td>&lt;3 mg/mmol (&lt;30 mg/g)</td>
      <td>Normálna až mierne zvýšená albuminúria</td>
    </tr>
    <tr>
      <td>A2</td>
      <td>3–30 mg/mmol (30–300 mg/g)</td>
      <td>Stredne zvýšená albuminúria</td>
    </tr>
    <tr>
      <td>A3</td>
      <td>&gt;30 mg/mmol (&gt;300 mg/g)</td>
      <td>Výrazne zvýšená albuminúria</td>
    </tr>
  </tbody>
</table>
</div>

<p>Nedostatočné vyšetrovanie albuminúrie je významnou medzerou v starostlivosti. Pacient s diabetom, hypertenziou, obezitou alebo srdcovým zlyhávaním môže mať normálnu či iba mierne zníženú eGFR, ale albuminúria už signalizuje zvýšené renálne a kardiovaskulárne riziko. Naopak, pri obezite a v skorých fázach diabetickej choroby obličiek môže hyperfiltrácia viesť k zdanlivo priaznivej alebo zvýšenej eGFR.</p>

<h2>Od kategórie CKD k absolútnemu riziku</h2>

<p>Klasifikácia CGA je začiatkom, nie koncom prognostického hodnotenia. KDIGO 2024 odporúča pri CKD G3 až G5 použiť externe validovanú rovnicu na odhad absolútneho rizika zlyhania obličiek. Najznámejšia štvorpremenná Kidney Failure Risk Equation (KFRE) pracuje s vekom, pohlavím, eGFR a UACR.</p>

<ul>
  <li><strong>päťročné riziko 3–5 %</strong> môže spolu s eGFR, UACR a klinickým kontextom podporiť odoslanie k nefrológovi,</li>
  <li><strong>dvojročné riziko &gt;10 %</strong> môže pomôcť určiť čas zapojenia multidisciplinárneho tímu,</li>
  <li><strong>dvojročné riziko &gt;40 %</strong> môže spolu s ďalšími kritériami usmerniť edukáciu o modalite a prípravu na náhradu funkcie obličiek vrátane cievneho prístupu alebo transplantácie.</li>
</ul>

<p>Tieto prahy nie sú automatickými pokynmi. Nemožno ich mechanicky používať pri akútnom poškodení obličiek ani bez zohľadnenia veku, komorbidít, konkurenčného rizika úmrtia a lokálnej dostupnosti starostlivosti.</p>

<h2>Spoločný terapeutický rámec KDIGO</h2>

<p>Jednotlivé intervencie majú spoločný cieľ: oddialiť zlyhanie obličiek, znížiť kardiovaskulárne príhody a predĺžiť život pri zachovaní jeho kvality. Liečba sa má vrstviť podľa indikácie, tolerancie a absolútneho rizika, nie zavádzať ako univerzálny balík pre každého pacienta.</p>

<h3>Krvný tlak a blokáda systému renín-angiotenzín</h3>

<p>KDIGO navrhuje u dospelých s CKD a vysokým krvným tlakom cieľový systolický tlak <strong>&lt;120 mmHg, ak je tolerovaný a tlak sa meria štandardizovaným spôsobom v ambulancii</strong>. Táto hodnota sa nemá nekriticky prenášať na neštandardizované rutinné meranie. Cieľ treba individualizovať najmä pri krehkosti, symptomatickej ortostatickej hypotenzii, veľmi obmedzenej prognóze alebo riziku pádov.</p>

<p>Pri albuminúrii zostáva inhibítor angiotenzín konvertujúceho enzýmu (ACEi) alebo blokátor receptora AT1 pre angiotenzín II (ARB) základom nefroprotektívnej liečby. Dôležité praktické pravidlá sú:</p>

<ul>
  <li>použiť najvyššiu schválenú dávku, ktorú pacient toleruje,</li>
  <li>skontrolovať tlak, kreatinín a draslík do 2–4 týždňov po nasadení alebo zvýšení dávky,</li>
  <li>pokračovať v liečbe, ak kreatinín do štyroch týždňov nestúpne o viac ako 30 %, pričom väčšia zmena je podnetom na vyšetrenie príčiny, nie automatickým dôkazom liekovej toxicity,</li>
  <li>nekombinovať ACEi, ARB a priamy inhibítor renínu,</li>
  <li>pri hyperkaliémii najprv hľadať reverzibilné príčiny a možnosti jej liečby; dávku znížiť alebo liek vysadiť najmä pri symptomatickej hypotenzii alebo nezvládnutej hyperkaliémii napriek liečbe.</li>
</ul>

<p>Medzi opatrenia na zvládnutie hyperkaliémie patria revízia súbežných liekov a stravy, korekcia metabolickej acidózy, vhodné diuretikum a podľa potreby lieky viažuce draslík. Cieľom je zachovať prognosticky účinnú liečbu vždy, keď je to bezpečné.</p>

<h3>Inhibítory SGLT2: orgánová ochrana presahujúca diabetológiu</h3>

<p>Účinok inhibítorov sodíkovo-glukózového kotransportéra 2 (SGLT2) presahuje glykemickú kontrolu. Obnovou tubuloglomerulovej spätnej väzby znižujú intraglomerulový tlak, spomaľujú pokles eGFR a znižujú riziko renálnych aj kardiovaskulárnych príhod.</p>

<p>Podľa KDIGO 2024 sa SGLT2 inhibítor odporúča:</p>

<ul>
  <li>pacientom s diabetes mellitus 2. typu, CKD a eGFR ≥20 ml/min/1,73 m<sup>2</sup>,</li>
  <li>dospelým s CKD, eGFR ≥20 ml/min/1,73 m<sup>2</sup> a UACR ≥20 mg/mmol (≥200 mg/g),</li>
  <li>dospelým s CKD a srdcovým zlyhávaním bez ohľadu na albuminúriu.</li>
</ul>

<p>Pri eGFR 20–45 ml/min/1,73 m<sup>2</sup> a UACR &lt;20 mg/mmol (&lt;200 mg/g) KDIGO liečbu navrhuje s nižšou silou odporúčania. Po nasadení je bežný malý, spravidla reverzibilný pokles eGFR, ktorý sám osebe nie je dôvodom na vysadenie. Ak pacient liek toleruje, možno v ňom pokračovať aj po poklese eGFR pod 20 ml/min/1,73 m<sup>2</sup>, kým sa nezačne náhrada funkcie obličiek. Liečbu je rozumné dočasne prerušiť počas dlhšieho hladovania, operácie alebo kritického ochorenia pre zvýšené riziko ketózy.</p>

<h3>Finerenón: reziduálne riziko pri diabete a albuminúrii</h3>

<p>Nesteroidný antagonista mineralokortikoidového receptora s preukázaným renálnym a kardiovaskulárnym prínosom má miesto u dospelých s diabetes mellitus 2. typu, eGFR &gt;25 ml/min/1,73 m<sup>2</sup>, normálnou koncentráciou draslíka a perzistujúcou albuminúriou &gt;3 mg/mmol (&gt;30 mg/g) napriek maximálnej tolerovanej dávke RAS blokády. Môže sa pridať k RAS blokáde a SGLT2 inhibítoru.</p>

<p>Výber pacienta a pravidelné monitorovanie kaliémie sú zásadné, pretože liečba zvyšuje riziko hyperkaliémie. Steroidné antagonisty mineralokortikoidového receptora zostávajú dôležité pri srdcovom zlyhávaní, hyperaldosteronizme alebo rezistentnej hypertenzii, ich indikačný rámec však nie je totožný s finerenónom.</p>

<h3>Diabetes, obezita a agonisty receptora GLP-1</h3>

<p>Obezita je významným, no často podceňovaným determinantom CKD. Podieľa sa na hyperfiltrácii, albuminúrii, glomerulomegálii, sekundárnej fokálnej segmentálnej glomeruloskleróze, hypertenzii, diabete aj srdcovom zlyhávaní so zachovanou ejekčnou frakciou.</p>

<p>KDIGO 2024 odporúča dlhodobo pôsobiaci agonista receptora GLP-1 u dospelých s diabetes mellitus 2. typu a CKD, ktorí nedosiahli individualizované glykemické ciele napriek liečbe metformínom a SGLT2 inhibítorom alebo tieto lieky nemôžu užívať; prednosť majú látky s preukázaným kardiovaskulárnym prínosom. Pri výbere treba zohľadniť registrovanú indikáciu, eGFR, gastrointestinálnu toleranciu, riziko dehydratácie, nutričný stav, stratu svalovej hmoty a krehkosť.</p>

<p>Farmakoterapia nenahrádza komplexnú intervenciu životného štýlu. Primeraná fyzická aktivita, racionálna výživa, nefajčenie, dostatočný spánok a obmedzenie nadmerného príjmu sodíka zostávajú spoločnými piliermi naprieč CKM štádiami.</p>

<h3>Dyslipidémia: rozhoduje riziko a štádium CKD</h3>

<p>U dospelých vo veku ≥50 rokov s eGFR &lt;60 ml/min/1,73 m<sup>2</sup>, ktorí nie sú liečení chronickou dialýzou a nemajú transplantovanú obličku, KDIGO odporúča statín alebo kombináciu statínu s ezetimibom. Pri eGFR ≥60 ml/min/1,73 m<sup>2</sup> odporúča statín. Vo veku 18–49 rokov sa rozhoduje podľa prítomnosti koronárnej choroby, diabetu, prekonanej ischemickej cievnej mozgovej príhody a odhadovaného koronárneho rizika.</p>

<p>Začatie hypolipidemickej liečby po vstupe do dialyzačného programu nemá rovnakú dôkazovú oporu ako jej použitie v skorších štádiách CKD. To však nie je totožné s automatickým vysadením liečby, ktorú pacient už užíva; rozhodnutie má vychádzať z klinického kontextu a platných odporúčaní.</p>

<h2>Srdcové zlyhávanie a CKD: kreatinín treba čítať v kontexte</h2>

<p>Srdcové zlyhávanie a CKD sa často vyskytujú spoločne. Diagnostiku a liečbu komplikujú venózna kongescia, diuretiká, kolísanie perfúzie obličiek a zmeny sérového kreatinínu. Mierny vzostup kreatinínu počas účinnej dekongesčnej liečby nemusí automaticky znamenať štruktúrne poškodenie obličiek alebo neúspech liečby. Môže odrážať funkčnú hemodynamickú zmenu pri úprave objemového stavu.</p>

<p>Rozhodnutie o pokračovaní alebo úprave diuretík a prognosticky účinnej liečby musí vychádzať zo súčasného hodnotenia kongescie, krvného tlaku, symptómov, dynamiky hmotnosti a diurézy, kaliémie a trendu renálnych parametrov. Zhoršujúca sa hypotenzia, oligoanúria, závažné elektrolytové poruchy alebo známky hypoperfúzie si vyžadujú inú reakciu než izolovaná malá zmena kreatinínu u klinicky dekongestovaného pacienta.</p>

<h2>Praktický rámec pre ambulanciu</h2>

<div class="table-responsive" role="region" aria-label="Praktický rámec sledovania CKM rizika" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Situácia</th>
      <th scope="col">Čo hodnotiť</th>
      <th scope="col">Na čo nezabudnúť</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Vstupné vyšetrenie</td>
      <td>eGFR, UACR, močový sediment podľa indikácie, tlak, hmotnosť, objemový stav, glykémia/HbA1c, lipidy, draslík a bikarbonát</td>
      <td>Potvrdiť chronicitu nálezu a určiť príčinu CKD</td>
    </tr>
    <tr>
      <td>Po nasadení alebo titrácii ACEi/ARB</td>
      <td>Tlak, kreatinín a draslík o 2–4 týždne; pri vysokom riziku skôr</td>
      <td>Pri väčšom poklese eGFR preveriť objem, NSAID, diuretiká, AKI a stenózu renálnej artérie</td>
    </tr>
    <tr>
      <td>Po nasadení SGLT2 inhibítora</td>
      <td>Tolerancia, objemový stav a riziko ketózy; laboratórne kontroly podľa bežného plánu CKD</td>
      <td>Malý počiatočný pokles eGFR býva očakávaný; poučiť o dočasnom prerušení v rizikových situáciách</td>
    </tr>
    <tr>
      <td>Po nasadení finerenónu</td>
      <td>Draslík a eGFR podľa schváleného súhrnu charakteristických vlastností lieku a klinického rizika</td>
      <td>Nezačínať pri hyperkaliémii; prehodnotiť súbežné lieky zvyšujúce draslík</td>
    </tr>
    <tr>
      <td>Priebežné sledovanie</td>
      <td>Trend eGFR a UACR, tlak, hmotnosť, metabolické parametre, fajčenie, pohyb, výživa, adherencia a nežiaduce účinky</td>
      <td>Frekvenciu prispôsobiť kategórii CGA, KFRE a dynamike ochorenia</td>
    </tr>
  </tbody>
</table>
</div>

<p>Skoré nefrologické konzílium je vhodné pri diagnostickej neistote, rýchlom poklese eGFR, významnej alebo narastajúcej albuminúrii, aktívnom močovom sedimente, rezistentnej hypertenzii, opakovanej hyperkaliémii alebo vysokom predikovanom riziku zlyhania obličiek. Odoslanie k nefrológovi nemá byť vnímané iba ako príprava na dialýzu, ale ako príležitosť spomaliť progresiu CKD a znížiť kardiovaskulárne riziko.</p>

<h2>Časový kontext a limity prehľadu</h2>

<p>Hlavný zdroj bol publikovaný online 25. mája 2026. Ide o odborný prehľad, nie o novú intervenčnú alebo observačnú štúdiu. Syntetizuje odporúčania KDIGO a poukazuje aj na pripravované usmernenie pre srdcové zlyhávanie pri CKD a na oblasti, v ktorých dôkazy zostávajú neúplné.</p>

<p>V júni 2026, teda po online publikovaní tohto prehľadu, vyšlo prvé spoločné klinické usmernenie AHA/ACC a partnerských odborných spoločností pre CKM syndróm. Novšie usmernenie rámec KDIGO nenahrádza; dopĺňa ho o formálne štádiá CKM, predikciu kardiovaskulárneho rizika a organizačný model integrovanej starostlivosti. Podrobnejší komentár k nemu je dostupný v samostatnom článku <a href="article.php?slug=ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia">CKM syndróm konečne ako „jeden rámec“</a>.</p>

<p>Jednotlivé odporúčania majú rozdielnu silu dôkazov a nemožno ich mechanicky preniesť na každého pacienta. Rozhodovanie musí zohľadniť vek, krehkosť, komorbidity, prognózu, preferencie pacienta, dostupnosť liekov a miestne podmienky zdravotnej starostlivosti. Článok nenahrádza súhrn charakteristických vlastností konkrétneho lieku ani individuálne klinické rozhodnutie.</p>

<h2>Záver</h2>

<p>CKM syndróm mení tradičný pohľad na chronickú chorobu obličiek. Oblička nie je iba pasívnym cieľovým orgánom metabolických a kardiovaskulárnych porúch, ale aktívnym determinantom ich priebehu a prognózy.</p>

<p>Základom kvalitnej starostlivosti je včasné rozpoznanie CKD vrátane vyšetrenia albuminúrie, klasifikácia podľa príčiny, eGFR a UACR, odhad absolútneho rizika a vrstvenie kardiorenálne protektívnej liečby podľa indikácie a tolerancie. Rovnako dôležitá je koordinovaná spolupráca všeobecného lekára, internistu, nefrológa, diabetológa, kardiológa, farmaceuta a nutričného špecialistu.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Levin A, Bansal N, de Boer IH, Grams ME, Jadoul M, ter Maaten JM, Mustafa RA, Rossing P, Cheung M, King JM, Earley A, Stevens PE. The kidney in the middle: Kidney Disease: Improving Global Outcomes (KDIGO) guidelines address multiple key components of cardiovascular-kidney-metabolic syndrome. <em>Kidney International</em>. 2026; online ahead of print. DOI: 10.1016/j.kint.2026.03.031. <a href="https://doi.org/10.1016/j.kint.2026.03.031" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42191113/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Overené odporúčania a kontext:</strong> <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of CKD</a> · <a href="https://professional.heart.org/en/science-news/cardiovascular-kidney-metabolic-health-a-presidential-advisory" target="_blank" rel="noopener noreferrer">AHA 2023 Presidential Advisory on CKM Health</a> · <a href="https://doi.org/10.1016/j.jacc.2026.03.056" target="_blank" rel="noopener noreferrer">2026 AHA/ACC Guideline for CKM Syndrome</a> · <a href="https://diabetesatlas.org/" target="_blank" rel="noopener noreferrer">IDF Diabetes Atlas, 11. vydanie</a> · <a href="https://www.theisn.org/blog/2023/03/30/new-global-kidney-health-report-sheds-light-on-current-capacity-around-the-world-to-deliver-kidney-care/" target="_blank" rel="noopener noreferrer">ISN Global Kidney Health Atlas</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_oblicka_ckm newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_oblicka_ckm pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_oblicka_ckm pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_oblicka_ckm migration error: ' . $e->getMessage());
    }
}

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
