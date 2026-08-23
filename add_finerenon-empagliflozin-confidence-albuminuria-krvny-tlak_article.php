<?php
/**
 * add_finerenon-empagliflozin-confidence-albuminuria-krvny-tlak_article.php
 * Idempotentný UPSERT skript pre odborne a jazykovo korigovaný článok
 * o štúdii CONFIDENCE, albuminúrii a úlohe krvného tlaku.
 * Pôvodní autori zdrojového editoriálu sú evidovaní aj v source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Finerenón s empagliflozínom pri CKD a diabete 2. typu: vysvetľuje pokles albuminúrie krvný tlak?',
    'slug'         => 'finerenon-empagliflozin-confidence-albuminuria-krvny-tlak',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-07-13 21:13:08',
    'is_top'       => 0,
    'excerpt'      => 'CONFIDENCE ukázala pri súčasnom začatí finerenónu a empagliflozínu väčší pokles UACR než pri monoterapiách. Februárový editorial ho pripisoval krvnému tlaku, novšia mediačná analýza však túto hypotézu skôr nepodporila.',
    'content'      => <<<'HTML'
<p>Chronická choroba obličiek (CHO; v medzinárodnej literatúre CKD) u ľudí s diabetom 2. typu zostáva spojená s vysokým rizikom progresie do zlyhania obličiek aj s kardiovaskulárnymi príhodami. Blokáda systému renín–angiotenzín (RAS), inhibítory sodíkovo-glukózového kotransportéra 2 (SGLT2), agonisty receptora glukagónu podobného peptidu 1 a nesteroidné antagonisty mineralokortikoidného receptora toto riziko znižujú, ale neodstraňujú ho. Prirodzenou ďalšou otázkou preto je, čo prinesie kombinácia liekov s komplementárnymi mechanizmami.</p>

<p>Randomizovaná štúdia <strong>CONFIDENCE</strong> ukázala, že súčasné začatie liečby finerenónom a empagliflozínom znižuje pomer albumínu ku kreatinínu v moči (UACR) po 180 dňoch výraznejšie než ktorákoľvek monoterapia. Editorial Marie José Soler, Paoly Romagnani a Fernanda C. Fervenzu v časopise <em>Nephrology Dialysis Transplantation</em> však položil provokatívnu otázku: nejde najmä o dôsledok väčšieho poklesu systolického krvného tlaku?</p>

<p>Od publikovania editorialu 19. februára 2026 pribudla dôležitá sekundárna analýza CONFIDENCE, ktorá túto otázku skúmala priamo. Aktuálne hodnotenie preto musí oddeliť tri úrovne dôkazov: výsledok pôvodnej randomizovanej štúdie, mechanistickú hypotézu editorialu a novšiu exploratívnu mediačnú analýzu.</p>

<h2>Čo štúdia CONFIDENCE skutočne testovala</h2>

<p>CONFIDENCE bola randomizovaná, dvojito zaslepená, trojramenná štúdia fázy 2 s aktívnymi porovnávacími ramenami a s dvojitou simuláciou liečby (<span lang="en">double-dummy</span>). Randomizovaných bolo 818 dospelých; úplný súbor analýzy účinnosti tvorilo 800 a bezpečnostný súbor 798 účastníkov.</p>

<p>Zaradení pacienti mali diabetes 2. typu, CHO s eGFR 30–90 mL/min/1,73 m² a UACR 100–5 000 mg/g. Najvyššiu schválenú tolerovanú dávku inhibítora angiotenzín konvertujúceho enzýmu alebo blokátora receptora AT1 mali užívať dlhšie než mesiac; pri randomizácii blokádu RAS reálne užívalo 98,4 % účastníkov. Označenie „CHO pri diabete 2. typu“ je presnejšie než automatické pripísanie diabetickej etiológie ochorenia obličiek každému pacientovi.</p>

<p>Účastníci boli v pomere 1 : 1 : 1 zaradení do troch skupín:</p>

<ul>
  <li>finerenón 10 alebo 20 mg denne podľa vstupnej eGFR,</li>
  <li>empagliflozín 10 mg denne,</li>
  <li>kombinácia oboch liekov v rovnakých dávkach.</li>
</ul>

<p>Štúdia nemala rameno so samotnou základnou liečbou alebo s dvojitým placebom. Primárnym ukazovateľom bola relatívna zmena logaritmicky transformovaného priemerného UACR od východiskovej hodnoty do 180. dňa. Na začiatku bola priemerná eGFR 54,2 ± 17,1 mL/min/1,73 m² a medián UACR 579 mg/g (medzikvartilové rozpätie 292–1 092 mg/g).</p>

<h2>Výsledok: výraznejší pokles UACR, nie zatiaľ menej zlyhaní obličiek</h2>

<table>
  <thead>
    <tr>
      <th scope="col">Liečba alebo porovnanie v 180. deň</th>
      <th scope="col">Výsledok UACR</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Finerenón + empagliflozín oproti východiskovej hodnote</td>
      <td>pomer 0,48; pokles približne o 52 %</td>
    </tr>
    <tr>
      <td>Finerenón oproti východiskovej hodnote</td>
      <td>pomer 0,68; pokles približne o 32 %</td>
    </tr>
    <tr>
      <td>Empagliflozín oproti východiskovej hodnote</td>
      <td>pomer 0,71; pokles približne o 29 %</td>
    </tr>
    <tr>
      <td>Kombinácia oproti finerenónu</td>
      <td>o 29 % väčší relatívny pokles; pomer 0,71 (95 % IS 0,61–0,82); p &lt; 0,001</td>
    </tr>
    <tr>
      <td>Kombinácia oproti empagliflozínu</td>
      <td>o 32 % väčší relatívny pokles; pomer 0,68 (95 % IS 0,59–0,79); p &lt; 0,001</td>
    </tr>
  </tbody>
</table>

<p><em>IS – interval spoľahlivosti. Percentá v posledných dvoch riadkoch vyjadrujú porovnanie relatívnych zmien UACR, nie rozdiel v percentuálnych bodoch.</em></p>

<p>Pokles UACR bol viditeľný už počas prvých štyroch týždňov. <strong>Údaj 52 % však neznamená 52-percentné zníženie rizika dialýzy, zlyhania obličiek, kardiovaskulárnej príhody alebo úmrtia.</strong> CONFIDENCE trvala šesť mesiacov, jej primárnym ukazovateľom bol náhradný biomarker a nebola navrhnutá ani dostatočne veľká na hodnotenie dlhodobých klinických výsledkov.</p>

<p>UACR je významný prognostický marker a jeho pokles v predchádzajúcich analýzach súvisel s lepšími obličkovými výsledkami. V konkrétnej štúdii však táto súvislosť nenahrádza priamy dôkaz, že súčasné začatie oboch liekov zabráni väčšiemu počtu klinických príhod než ich samostatné alebo postupné nasadenie.</p>

<h2>Prečo editorial upriamil pozornosť na krvný tlak</h2>

<p>Pri kombinovanej liečbe sa systolický krvný tlak do 30. dňa znížil približne o 7,4 mmHg. Medzi 180. a 210. dňom, teda po vysadení skúšanej liečby, opäť vzrástol približne o 7,5 mmHg. Súčasne sa zvýšil UACR: pomer hodnoty po vysadení k hodnote v 180. deň bol 1,63 pri kombinácii, 1,45 pri finerenóne a 1,44 pri empagliflozíne. UACR však zostal v 210. deň numericky pod východiskovou hodnotou.</p>

<p>Podobne sa v 30. deň znížila eGFR priemerne o 5,6 mL/min/1,73 m² pri kombinácii, o 2,0 pri finerenóne a o 3,8 pri empagliflozíne; po vysadení sa veľká časť poklesu upravila. Skoré zníženie eGFR pri týchto liekoch môže predstavovať očakávanú farmakodynamickú odpoveď a samo osebe nie je dôkazom poškodenia obličiek.</p>

<p>Súbežný časový priebeh STK, UACR a eGFR je zlučiteľný s významnou úlohou systémovej a vnútroobličkovej hemodynamiky. Časová zhoda však sama osebe neurčuje kauzalitu ani veľkosť sprostredkovaného účinku. Intraglomerulový tlak sa v CONFIDENCE priamo nemeral a zmena systémového krvného tlaku nie je jeho úplnou náhradou.</p>

<h2>Novšia analýza hypotézu „iba krvný tlak“ skôr nepodporila</h2>

<p>Dňa 5. júna 2026 bola v časopise <em>Hypertension</em> publikovaná sekundárna analýza 800 účastníkov CONFIDENCE. Vstupný STK najmenej 130 mmHg malo 532 pacientov (66 %). Kombinácia zvýšila pravdepodobnosť poklesu STK aspoň o 10 mmHg oproti finerenónu (OR 1,83; 95 % IS 1,21–2,76; p = 0,004). Oproti empagliflozínu výsledok nedosiahol konvenčnú hranicu štatistickej významnosti (OR 1,45; 95 % IS 0,97–2,17; p = 0,07). Najsilnejším prediktorom tlakovej odpovede bol vyšší vstupný STK.</p>

<p>Rozhodujúca exploratívna kauzálna mediačná analýza odhadla, že zmena STK do 30. dňa sprostredkovala <strong>menej než 10 %</strong> celkového poklesu UACR v 180. deň. Pokles albuminúrie sa teda v tejto analýze javil prevažne nezávislý od skorej zmeny klinicky meraného STK.</p>

<p>Tento výsledok oslabuje ústrednú hypotézu februárového editorialu, ale neuzatvára mechanistickú diskusiu. Mediačná časť bola sekundárna a exploratívna, vychádzala z tlaku meraného v ambulancii, nie z 24-hodinového ambulantného monitorovania, a hodnotila jeden skorý časový bod. Meracia chyba mohla podiel mediácie podhodnotiť. Analýza navyše pracovala s tými istými údajmi zo štúdie financovanej spoločnosťou Bayer; nejde o nezávislú výsledkovú štúdiu. Jej záver preto znie presnejšie takto: <strong>pokles systémového krvného tlaku podľa dostupnej analýzy nevysvetľuje väčšinu dodatočného poklesu UACR, hemodynamický podiel však nemožno vylúčiť.</strong></p>

<h2>Prečo jednoduchá „adjustácia na tlak“ nestačí</h2>

<p>Editorial kritizoval, že primárna analýza nebola upravená o zmenu krvného tlaku. Neupravenie randomizovaného porovnania však nie je samo osebe metodickou chybou. Krvný tlak meraný po randomizácii môže byť následkom liečby, teda mediátorom, nie vstupným konfúzorom. Bežné vloženie takejto premennej do regresného modelu môže časť skutočného celkového účinku odstrániť alebo zaviesť nové skreslenie.</p>

<p>Na rozdelenie účinku na tlakovo sprostredkovanú a nesprostredkovanú zložku je potrebná osobitná kauzálna mediačná analýza s ďalšími predpokladmi. Novšia práca takúto analýzu vykonala, hoci s uvedenými obmedzeniami. Primárne randomizované porovnanie naďalej platne odpovedá na inú otázku: aký bol celkový účinok priradenej liečby na UACR?</p>

<h2>Štyri otázky editorialu v primeranom kontexte</h2>

<ol>
  <li><strong>Bol krvný tlak na začiatku optimálne liečený?</strong> Priemerný vstupný STK bol približne 135 ± 13 mmHg a diuretikum užívalo 36 % účastníkov. To otvára otázku objemového a tlakového manažmentu, ale nedokazuje nedostatočnú liečbu. Cieľ STK pod 120 mmHg podľa <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO 2024</a> sa týka dospelých s vysokým tlakom a CHO, ak je tolerovaný, pri štandardizovanom ambulantnom meraní a s individualizáciou. Nemožno ho mechanicky preniesť na každú rutinnú hodnotu ani na každého pacienta.</li>
  <li><strong>Chýbali údaje o sodíku.</strong> Štúdia neuviedla príjem sodíka ani jeho vylučovanie močom. To obmedzuje vysvetlenie mechanizmu, keďže sodík, objemový stav, tlak a albuminúria spolu úzko súvisia. Neznamená to však, že zahrnutie jednej tlakovej premennej by nevyhnutne odstránilo účinok kombinácie.</li>
  <li><strong>Aká bola východisková albuminúria?</strong> Medián UACR 579 mg/g nie je klinicky „nízky“; patrí do kategórie A3, teda závažne zvýšenej albuminúrie. Bol však nižší než v historických štúdiách s výraznou proteinúriou a približne štvrtina účastníkov mala UACR pod 300 mg/g. Rovnaký relatívny pokles znamená pri nižšej východiskovej hodnote menší absolútny rozdiel a CONFIDENCE priamo neoverila jeho dlhodobý klinický prínos.</li>
  <li><strong>Bola blokáda RAS dostatočne stabilná?</strong> Požadovaná stabilizácia dlhšia než jeden mesiac mohla byť u časti pacientov krátka a doznievajúci účinok nedávno nasadeného ACE inhibítora alebo ARB mohol prispieť k poklesu UACR vo všetkých ramenách. Randomizácia by však mala tento vplyv v priemere vyvážiť, preto sám osebe presvedčivo nevysvetľuje rozdiel kombinácie oproti monoterapiám.</li>
</ol>

<h2>Čo pripomínajú štúdie RENAAL a IDNT</h2>

<p>Autori editorialu zasadili diskusiu do kontextu historických štúdií blokády RAS. V štúdii RENAAL znížil losartan riziko primárneho kompozitného ukazovateľa o 16 % a proteinúriu približne o 35 %. Po časovo závislej úprave o dosiahnutý krvný tlak zostal odhad zníženia rizika prakticky nezmenený na 15 %, čo podporovalo účinok presahujúci samotnú zmenu systémového tlaku.</p>

<p>V štúdii IDNT bolo pri irbesartane riziko primárneho ukazovateľa o 20 % nižšie než pri placebe a o 23 % nižšie než pri amlodipíne. Proteinúria sa znížila priemerne o 33 % pri irbesartane, o 6 % pri amlodipíne a o 10 % pri placebe. Priemerný tlak počas sledovania bol podobný pri irbesartane a amlodipíne, ale vyšší pri placebe.</p>

<p>Tieto štúdie ukazujú, prečo sa tlakovo závislé a tlakovo nezávislé účinky nedajú spoľahlivo oddeliť iba pohľadom na priemerné hodnoty tlaku. Zároveň išlo o inú éru, populácie s výraznejšou proteinúriou, dlhšie sledovanie a klinické obličkové ukazovatele; nie sú priamym dôkazom mechanizmu kombinácie finerenónu s empagliflozínom.</p>

<h2>Náklady a chlórtalidón: užitočná pripomienka, nie rovnocenná náhrada</h2>

<p>Editorial použil americké ceny presahujúce 1 000 USD mesačne za kombináciu a približne 8 USD za mesačnú liečbu chlórtalidónom. Ide o dobovú ilustráciu amerického trhu, nie o výsledok CONFIDENCE ani o údaje prenositeľné na Slovensko. Reálne náklady závisia od cien, úhrad, zliav a konkrétneho zdravotného systému.</p>

<p>V štúdii CLICK u 160 pacientov s CHO kategórie G4 a nedostatočne kontrolovanou hypertenziou znížil chlórtalidón po 12 týždňoch 24-hodinový STK oproti placebu približne o 10,5 mmHg a výrazne znížil UACR. Častejšie sa však vyskytli hypokaliémia, reverzibilný vzostup kreatinínu, hyperglykémia, závraty a hyperurikémia. Chlórtalidón je účinnou možnosťou pri vhodne indikovanom manažmente hypertenzie a objemovej expanzie, ale CLICK nepreukázala jeho vplyv na zlyhanie obličiek a nerobí z neho náhradu liekov s osobitne preukázaným kardiorenálnym prínosom.</p>

<h2>Bezpečnosť: priaznivý 180-dňový obraz, nie dôvod poľaviť v monitorovaní</h2>

<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Kombinácia</th>
      <th scope="col">Finerenón</th>
      <th scope="col">Empagliflozín</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Závažná nežiaduca udalosť</td>
      <td>7,1 %</td>
      <td>6,1 %</td>
      <td>6,4 %</td>
    </tr>
    <tr>
      <td>Hlásená hyperkaliémia</td>
      <td>9,3 %</td>
      <td>11,4 %</td>
      <td>3,8 %</td>
    </tr>
    <tr>
      <td>Laboratórna hodnota K<sup>+</sup> &gt;5,5 mmol/L</td>
      <td>15,3 %</td>
      <td>18,6 %</td>
      <td>9,7 %</td>
    </tr>
    <tr>
      <td>Akútne poškodenie obličiek</td>
      <td>5 pacientov</td>
      <td>3 pacienti</td>
      <td>0 pacientov</td>
    </tr>
    <tr>
      <td>Symptomatická hypotenzia</td>
      <td>3 pacienti</td>
      <td>0 pacientov</td>
      <td>0 pacientov</td>
    </tr>
  </tbody>
</table>

<p>Pre hyperkaliémiu natrvalo ukončil liečbu jeden pacient v každej skupine. Kombinácia teda počas 180 dní neodhalila neočakávaný bezpečnostný signál, ale riziko hyperkaliémie neodstránila. Výsledky navyše nemožno bezvýhradne preniesť na pacientov so vstupnou koncentráciou draslíka nad 4,8 mmol/L, symptomatickým srdcovým zlyhávaním so zníženou ejekčnou frakciou alebo nedávnou závažnou kardiovaskulárnou príhodou, pretože takíto pacienti boli zo štúdie vylúčení.</p>

<h2>Čo z toho vyplýva pre klinickú prax</h2>

<p><a href="https://doi.org/10.2337/dc26-S011" target="_blank" rel="noopener noreferrer">Štandardy starostlivosti ADA 2026</a> uvádzajú, že súčasné začatie inhibítora SGLT2 a finerenónu možno zvážiť u dospelých s diabetom 2. typu, UACR najmenej 100 mg/g, eGFR 30–90 mL/min/1,73 m² a liečbou inhibítorom RAS, a to na základe údajov o bezpečnosti a priaznivom účinku na albuminúriu. Formulácia „možno zvážiť“ nie je univerzálnym odporúčaním pre každého pacienta ani dôkazom dlhodobého výsledkového prínosu konkrétnej kombinácie.</p>

<p>Praktický postup má zostať individualizovaný:</p>

<ul>
  <li>overiť samostatnú indikáciu oboch liekov a čo najlepšie tolerovanú blokádu RAS;</li>
  <li>zhodnotiť UACR, eGFR, sérový draslík, krvný tlak a objemový stav;</li>
  <li>nezanedbať štandardizované meranie tlaku, primerané obmedzenie sodíka a indikovanú diuretickú liečbu;</li>
  <li>po nasadení sledovať krvný tlak, príznaky objemovej deplécie, eGFR a draslík, pri finerenóne osobitne približne po štyroch týždňoch a ďalej podľa rizika;</li>
  <li>rozlíšiť očakávaný skorý pokles eGFR od progresívneho zhoršovania, akútneho poškodenia obličiek alebo intolerancie;</li>
  <li>o súčasnom alebo postupnom nasadení rozhodnúť podľa rizika, komorbidít, tolerancie, preferencií a dostupnosti liečby.</li>
</ul>

<h2>Záver</h2>

<p>CONFIDENCE poskytuje randomizovaný dôkaz, že súčasné začatie finerenónu a empagliflozínu pri CHO, diabete 2. typu a albuminúrii znižuje UACR po šiestich mesiacoch výraznejšie než každá monoterapia. Ide o dodatočný, s aditívnym pôsobením zlučiteľný účinok; štúdia nepreukázala farmakologickú synergiu v prísnom štatistickom zmysle.</p>

<p>Februárový editorial správne upozornil na hemodynamiku, sodík, objemový manažment a potrebu nepreceňovať náhradný ukazovateľ. Jeho hypotézu, že pokles albuminúrie je prevažne dôsledkom poklesu systémového krvného tlaku, však novšia exploratívna mediačná analýza skôr nepodporila: skorá zmena STK vysvetľovala menej než 10 % celkového poklesu UACR.</p>

<p>Najpresnejší záver preto nie je „iba krvný tlak“ ani „dokázaná synergia“. Kombinácia prináša väčší pokles albuminúrie s prijateľným krátkodobým bezpečnostným profilom u starostlivo vybraných pacientov; mechanizmus nie je úplne vysvetlený a dlhodobý prínos súčasného začatia liečby na zlyhanie obličiek a kardiovaskulárne príhody zostáva nepreukázaný.</p>

<hr>

<p><em><strong>Hlavný zdroj – editorial:</strong> Soler MJ, Romagnani P, Fervenza FC. Finerenone with empagliflozin in CKD with diabetes (CONFIDENCE): only a blood pressure effect? Likely! <em>Nephrology Dialysis Transplantation</em>. 2026;41(7):1177–1179. Publikované online 19. februára 2026. <a href="https://academic.oup.com/ndt/article/41/7/1177/8490465" target="_blank" rel="noopener noreferrer">Oxford Academic – zdrojový článok</a>. doi: <a href="https://doi.org/10.1093/ndt/gfag042" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfag042</a>. PMID 41711584: <a href="https://pubmed.ncbi.nlm.nih.gov/41711584/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://academic.oup.com/ndt/advance-article-pdf/doi/10.1093/ndt/gfag042/66991154/gfag042.pdf" target="_blank" rel="noopener noreferrer">Oxford Academic – PDF</a>.</em></p>

<p><em><strong>Všetci autori zdrojového editoriálu:</strong> Maria José Soler; Paola Romagnani; Fernando C. Fervenza.</em></p>

<p><em><strong>Primárna štúdia CONFIDENCE:</strong> Agarwal R, Green JB, Heerspink HJL, Mann JFE, McGill JB, Mottl AK, Rosenstock J, Rossing P, Vaduganathan M, Brinker M, Edfors R, Li N, Scheerer MF, Scott C, Nangaku M; CONFIDENCE Investigators. Finerenone with Empagliflozin in Chronic Kidney Disease and Type 2 Diabetes. <em>N Engl J Med</em>. 2025;393(6):533–543. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2410659" target="_blank" rel="noopener noreferrer">NEJM – plný text</a>. doi: <a href="https://doi.org/10.1056/NEJMoa2410659" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2410659</a>. PMID 40470996: <a href="https://pubmed.ncbi.nlm.nih.gov/40470996/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://clinicaltrials.gov/study/NCT05254002" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov: NCT05254002</a>.</em></p>

<p><em><strong>Následná analýza krvného tlaku:</strong> Agarwal R et al. Safety and Synergy of Finerenone and Empagliflozin in Lowering Blood Pressure. <em>Hypertension</em>. Publikované online 5. júna 2026. doi: <a href="https://doi.org/10.1161/HYPERTENSIONAHA.126.27036" target="_blank" rel="noopener noreferrer">10.1161/HYPERTENSIONAHA.126.27036</a>. PMID 42244376: <a href="https://pubmed.ncbi.nlm.nih.gov/42244376/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Financovanie a konflikty záujmov:</strong> Editorial neuvádza osobitné financovanie. Maria José Soler deklarovala osobné honoráre od viacerých spoločností vrátane Bayer a ďalšie odborné funkcie; úplné vyhlásenie je uvedené v zdrojovom článku. Samotnú štúdiu CONFIDENCE financovala spoločnosť Bayer.</em></p>
HTML,
];

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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
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
