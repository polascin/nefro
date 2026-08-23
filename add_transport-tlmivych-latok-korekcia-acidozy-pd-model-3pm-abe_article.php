<?php
/**
 * add_transport-tlmivych-latok-korekcia-acidozy-pd-model-3pm-abe_article.php
 * Idempotentný UPSERT skript pre odborne a jazykovo korigovaný článok
 * o integrovanom modeli peritoneálneho transportu a acidobázickej rovnováhy.
 * Pôvodní autori zdrojovej štúdie sú evidovaní aj v source_authors.php.
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
    'title'        => 'Transport tlmivých látok a korekcia acidózy pri peritoneálnej dialýze: integrovaný model 3PM/ABE',
    'slug'         => 'transport-tlmivych-latok-korekcia-acidozy-pd-model-3pm-abe',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-07-13 22:48:48',
    'is_top'       => 0,
    'excerpt'      => 'Exploratívny model 3PM/ABE na údajoch zo šiestich pacientov dobre reprodukoval transport bikarbonátu, laktátu a CO₂ počas 4-hodinových výmen. Výsledky však nepreukazujú klinickú nadradenosť ani dlhodobú bezpečnosť konkrétneho roztoku.',
    'content'      => <<<'HTML'
<p>Pri peritoneálnej dialýze (PD) nestačí poznať iba prestup vody a rozpustených látok cez peritoneálnu membránu. Bikarbonát, laktát a oxid uhličitý sú súčasťou dynamického systému: prechádzajú medzi peritoneálnou dutinou a krvou, vstupujú do chemických rovnováh v telesných tekutinách a ich systémový účinok závisí aj od metabolizmu a pľúcnej ventilácie. Samotná hmotnostná bilancia dialyzátu preto nevysvetľuje, ako sa počas výmeny zmení acidobázická rovnováha pacienta.</p>

<p>Práca publikovaná v časopise <em>Scientific Reports</em> spojila rozšírený trojpórový model peritoneálneho transportu (3PM; <em>three-pore model</em>) s celotelovým modelom acidobázickej rovnováhy (ABE; <em>acid-base equilibrium</em>). Cieľom nebolo porovnať klinickú účinnosť alebo bezpečnosť komerčných roztokov, ale mechanisticky opísať 4-hodinové výmeny s laktátovým roztokom PD4 a s bikarbonátovo-laktátovým roztokom B/L. Výsledok je zaujímavý najmä tým, že prepája peritoneálny transport s telesnými oddielmi, pľúcami a metabolickým spracovaním laktátu. Jeho klinickú interpretáciu však musí sprevádzať dôsledné rozlíšenie medzi meraním, modelovým odhadom a vopred zadaným predpokladom.</p>

<h2>Údaje zo šiestich pacientov a dve oddelené výmeny</h2>

<p>Autori použili skôr získané fyziologické údaje, ktoré boli v agregovanej podobe čiastočne publikované už v roku 2003. Pôvodne bolo zaradených sedem pacientov; jeden bol z analýzy vylúčený pre nedostatočné vypustenie pred jednou výmenou a zvyškový intraperitoneálny objem väčší ako 1 liter. Model sa preto prispôsoboval údajom šiestich pacientov, z toho dvoch žien, s priemernou telesnou hmotnosťou 74,8 ± 15,3 kg. Podrobnejšia charakteristika veku, základných ochorení a hepatálnych alebo respiračných komorbidít v článku uvedená nie je.</p>

<p>Každý pacient absolvoval v dvoch po sebe nasledujúcich týždňoch dve samostatné 4-hodinové výmeny s 2 litrami roztoku obsahujúceho 3,86 % glukózy:</p>

<ul>
  <li><strong>B/L</strong> bol roztok Physioneal tlmený kombináciou bikarbonátu a laktátu;</li>
  <li><strong>PD4</strong> bol roztok Dianeal PD4 tlmený výlučne laktátom.</li>
</ul>

<p>Rádiojódom značený ľudský sérový albumín (RISA) slúžil ako značkovač objemu na odhad zvyškového objemu, intraperitoneálneho objemu počas výmeny a peritoneálnej absorpcie. Vzorky peritoneálnej tekutiny sa odoberali v 0., 3., 6., 10., 15., 20., 25., 30., 40., 50., 60., 90., 120., 180. a 240. minúte; venózna krv pred začiatkom a v 15., 60., 120. a 240. minúte. Merali sa okrem iného močovina, glukóza, kreatinín, sodík, draslík, chloridy, fosfát, laktát, bikarbonát, pH a pCO₂.</p>

<p>Nasledujúce hodnoty nie sú deklarovaným zložením roztokov vo vaku. Ide o koncentrácie namerané v peritoneálnej tekutine tri minúty po skončení napúšťania, teda už po zmiešaní so zvyškovou tekutinou v dutine:</p>

<table>
  <thead>
    <tr>
      <th scope="col">Parameter po 3 minútach</th>
      <th scope="col">B/L</th>
      <th scope="col">PD4</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Laktát</td>
      <td>15,2 ± 0,4 mmol/L</td>
      <td>38,1 ± 1,5 mmol/L</td>
    </tr>
    <tr>
      <td>Bikarbonát</td>
      <td>25,4 ± 1,1 mmol/L</td>
      <td>3,4 ± 1,1 mmol/L</td>
    </tr>
    <tr>
      <td>Rozpustený CO₂</td>
      <td>1,30 ± 0,08 mmol/L</td>
      <td>0,34 ± 0,04 mmol/L</td>
    </tr>
  </tbody>
</table>

<p>Rozdiely v týchto troch tlmivých zložkách boli očakávané a všetky boli štatisticky významné (p &lt; 0,05). Z ostatných meraných zložiek sa na začiatku líšil iba sodík, ktorého koncentrácia bola pri PD4 o 1,3 % vyššia. Rýchlosť peritoneálnej absorpcie dosiahla 3,66 ± 1,48 mL/min pri B/L a 2,79 ± 1,02 mL/min pri PD4; rozdiel nebol štatisticky významný (p = 0,11).</p>

<p>Zvyškový objem pred výmenou bol 466 ± 160 mL pri B/L a 316 ± 74 mL pri PD4; tento rozdiel nebol štatisticky významný. Napustené objemy sa v priemere líšili o 30 mL a kinetika intraperitoneálneho objemu bola medzi roztokmi odlišná do 25. minúty. Autori ju pripisujú skôr malým rozdielom v zvyškovom a napustenom objeme než tlmivému zloženiu. Podľa pomeru kreatinínu v dialyzáte a plazme po štyroch hodinách bol jeden pacient vysoký, traja stredne vysokí a dvaja stredne nízki transportéri. Rozdiel v kinetike laktátu alebo bikarbonátu podľa transportného typu sa neukázal, ale šesť pacientov neposkytuje dostatočnú silu na spoľahlivú podskupinovú analýzu.</p>

<h2>Čo spája model 3PM/ABE</h2>

<p>Trojpórový model opisuje prestup vody a rozpustených látok cez veľké, malé a ultramalé póry, pričom ultramalé póry reprezentujú najmä akvaporíny. Tok vody určujú hydrostatické, onkotické a osmotické gradienty; rozpustené látky sa prenášajú difúziou a konvekciou. Acidobázická časť modelu zahŕňa pľúcne kapiláry a alveoly, arteriálnu a zmiešanú venóznu krv, interstícium a intracelulárny priestor. Do tohto celotelového systému vstupujú modelované transperitoneálne toky bikarbonátu, laktátu a rozpusteného CO₂.</p>

<p>Model odhadoval hydraulickú vodivosť membrány, podiel ultramalých pórov a súčin permeability a plochy (PS) pre desať rozpustených látok. Peritoneálna perfúzia bola pevne nastavená na 55 mL/min a absorpcia sa pre každú výmenu zadala podľa údajov RISA. Pri viacerých neacidobázických látkach sa plazmatické koncentrácie považovali za známe vstupy a medzi odbermi sa lineárne interpolovali.</p>

<table>
  <thead>
    <tr>
      <th scope="col">Úroveň informácie</th>
      <th scope="col">Príklady v štúdii</th>
      <th scope="col">Ako ju interpretovať</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>Priamo merané</strong></td>
      <td>Objem podľa RISA; koncentrácie v peritoneálnej tekutine a krvi; pH a pCO₂ v určených časoch</td>
      <td>Experimentálne údaje zo šiestich pacientov</td>
    </tr>
    <tr>
      <td><strong>Prispôsobené alebo dopočítané</strong></td>
      <td>LpS, podiel ultramalých pórov, PS, transperitoneálne hmotnostné toky a niektoré metabolické a ventilačné parametre</td>
      <td>Výsledok modelu závislý od jeho štruktúry a vstupov</td>
    </tr>
    <tr>
      <td><strong>Vopred predpokladané</strong></td>
      <td>Konštantná peritoneálna perfúzia; 20 % odstránenej tekutiny z interstícia a zvyšok z cievnych oddielov; predialyzačná venózna saturácia O₂ 0,65; v základnom scenári konštantná ventilácia a metabolizmus; okamžitá premena laktátu na bikarbonát v pomere 1 : 1</td>
      <td>Nie je to výsledok merania ani dôkaz mechanizmu u konkrétneho pacienta</td>
    </tr>
  </tbody>
</table>

<h2>Ako dobre model reprodukoval údaje</h2>

<p>Po prispôsobení parametrov tým istým údajom z peritoneálnej tekutiny dosiahla celková relatívna odmocnina zo strednej kvadratickej chyby (RMSE) 6,6 ± 1,4 % pri B/L a 6,4 ± 0,9 % pri PD4; medzi roztokmi nebol štatisticky významný rozdiel. Pri jednotlivých rozpustených látkach zostala chyba pod 10 %.</p>

<p>Pre plazmatický bikarbonát bola RMSE 4,0 ± 2,8 % pri B/L a 5,7 ± 4,4 % pri PD4. Pre rozpustený CO₂ dosiahla 7,2 ± 5,3 %, respektíve 5,2 ± 3,5 %. Tieto plazmatické profily neboli cieľom prispôsobenia transportných parametrov na strane dialyzátu, čo podporuje vnútornú fyziologickú konzistentnosť modelu. Nešlo však o nezávislú externú validáciu: použili sa tí istí pacienti, ich východiskové acidobázické údaje a tá istá modelová štruktúra.</p>

<h2>Odlišná kinetika bikarbonátu a laktátu</h2>

<p>Pri nízkej počiatočnej koncentrácii bikarbonátu v PD4 vznikol veľký koncentračný gradient z krvi do peritoneálnej dutiny a prestup bol prevažne difúzny. Model odhadol 65,7 ± 10,8 mmol bikarbonátu preneseného z krvi do peritoneálnej tekutiny pri PD4 a 23,1 ± 6,8 mmol pri B/L. Autori pri tomto výpočte výslovne vylúčili množstvo znovu získané absorpciou do tkaniva. Hodnoty preto nemožno označiť za priamo nameranú čistú systémovú stratu bikarbonátu.</p>

<p>Laktát sa pri oboch roztokoch prenášal z peritoneálnej tekutiny do krvi, pri PD4 však vo väčšom množstve pre vyššiu počiatočnú koncentráciu. Plazmatická koncentrácia bikarbonátu napriek rozdielnej transperitoneálnej kinetike zostávala počas výmeny takmer konštantná a model tento priebeh reprodukoval. Kľúčom je však jeho predpoklad, že každý absorbovaný mol laktátu sa okamžite zmení na jeden mol bikarbonátu. Štúdia rýchlosť ani miesto tejto konverzie priamo nemerala; model nemá samostatný realistický pečeňový kompartment a nezachytáva oneskorenie metabolizmu. Stabilný plazmatický bikarbonát teda podporuje kompatibilitu modelu s údajmi, nie dôkaz úplnej a okamžitej metabolickej kompenzácie u každého pacienta.</p>

<p>Odhadnuté transportné parametre boli medzi roztokmi zväčša podobné. Štatisticky významne vyšší PS pri B/L sa zistil iba pre chloridy a laktát. Pri bikarbonáte a CO₂ bol rozptyl PS, najmä pri B/L, veľký, pravdepodobne preto, že ich koncentrácie v krvi a peritoneálnej tekutine boli blízko rovnováhy. Štúdia preto nepodporuje záver, že tlmivá zložka zásadne mení všeobecné transportné vlastnosti membrány. Zároveň však nemerala Kt/V, dlhodobú ultrafiltráciu, zlyhanie techniky ani klinické výsledky, a preto nepreukazuje zachovanie dialyzačnej adekvátnosti po zmene roztoku.</p>

<table>
  <thead>
    <tr>
      <th scope="col">Odhadnutý PS (mL/min)</th>
      <th scope="col">B/L</th>
      <th scope="col">PD4</th>
      <th scope="col">Porovnanie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Glukóza</td>
      <td>12,02 ± 3,63</td>
      <td>12,23 ± 3,39</td>
      <td>bez štatisticky významného rozdielu</td>
    </tr>
    <tr>
      <td>Kreatinín</td>
      <td>12,01 ± 3,86</td>
      <td>11,45 ± 2,01</td>
      <td>bez štatisticky významného rozdielu</td>
    </tr>
    <tr>
      <td>Chloridy</td>
      <td>11,35 ± 3,92</td>
      <td>7,74 ± 2,59</td>
      <td>vyšší pri B/L; p &lt; 0,05</td>
    </tr>
    <tr>
      <td>Laktát</td>
      <td>19,80 ± 4,92</td>
      <td>15,43 ± 2,66</td>
      <td>vyšší pri B/L; p &lt; 0,05</td>
    </tr>
    <tr>
      <td>Bikarbonát</td>
      <td>28,54 ± 12,34</td>
      <td>18,70 ± 4,69</td>
      <td>bez štatisticky významného rozdielu</td>
    </tr>
    <tr>
      <td>Rozpustený CO₂</td>
      <td>20,20 ± 20,67</td>
      <td>27,23 ± 7,44</td>
      <td>bez štatisticky významného rozdielu</td>
    </tr>
  </tbody>
</table>

<p>Plazmatické koncentrácie väčšiny sledovaných látok boli počas výmeny stabilné. Viac než jeden časový bod odlišný od východiskovej hodnoty sa našiel iba pri glukóze a pri chloridoch a draslíku počas PD4. Ani tento krátkodobý laboratórny profil však nenahrádza meranie celkovej týždennej adekvátnosti alebo klinického účinku.</p>

<h2>Respiračná časť je mechanistická, nie klinický simulátor CHOCHP</h2>

<p>Z východiskových údajov model odvodil pokojovú minútovú ventiláciu 3,52 ± 0,73 L/min pri B/L a 2,83 ± 0,296 L/min pri PD4 (p = 0,039). Ventilácia sa však priamo nemerala. Rozdiel mohol súvisieť s východiskovými údajmi alebo so zjednodušeniami regulačných mechanizmov a nemožno ho pripísať účinku roztoku.</p>

<p>U jedného pacienta sa podrobnosti priebehu plazmatického CO₂ dali priblížiť až po zadaní časovo premennej ventilácie. Išlo o hypotetické scenáre poklesu a následnej zmeny ventilácie, nie o pozorovaný respiračný záznam. Model preto zatiaľ nemožno používať ako validovaný nástroj na predikciu rizika u pacientov s chronickou obštrukčnou chorobou pľúc, respiračným zlyhaním alebo inou poruchou ventilácie.</p>

<h2>Čo možno a nemožno preniesť do klinickej praxe</h2>

<ul>
  <li><strong>Možno povedať:</strong> model dobre opísal krátkodobé koncentrácie a objemy v skúmaných 4-hodinových výmenách a vytvoril konzistentné prepojenie medzi peritoneálnym transportom a acidobázickou reguláciou.</li>
  <li><strong>Možno povedať:</strong> rozdielne počiatočné koncentrácie bikarbonátu a laktátu viedli k očakávane odlišným hmotnostným tokom, kým väčšina odhadnutých parametrov membránového transportu bola podobná.</li>
  <li><strong>Nemožno povedať:</strong> že jeden roztok je klinicky účinnejší, bezpečnejší alebo metabolicky nadradený. Štúdia nemala taký dizajn ani výsledkové ukazovatele.</li>
  <li><strong>Nemožno povedať:</strong> že B/L sám osebe znižuje tvorbu degradačných produktov glukózy alebo predlžuje životnosť peritoneálnej membrány. Hodnota pH a obsah degradačných produktov závisia aj od viac-komorovej výroby a tepelnej sterilizácie, nielen od voľby tlmivej látky.</li>
  <li><strong>Nemožno povedať:</strong> že prechod medzi roztokmi automaticky zachová adekvátnosť PD alebo dlhodobé výsledky. Tie sa v práci nesledovali.</li>
</ul>

<p>Širšie dôkazy treba posudzovať oddelene. Cochraneov prehľad neutrálneho pH a roztokov s nízkym obsahom degradačných produktov glukózy naznačil možný priaznivý vplyv na zachovanie reziduálnej funkcie obličiek, objem moču a bolesť pri napúšťaní. Dôkazy však neboli dostatočné pre spoľahlivé závery o peritonitíde, transportných vlastnostiach, udržaní pacienta na danej liečebnej metóde alebo prežívaní pacientov. Odporúčanie ISPD uprednostniť pri akútnej PD roztok s bikarbonátom u kriticky chorých pacientov s významnou poruchou funkcie pečene alebo vysokou koncentráciou laktátu sa týka odlišnej akútnej populácie; nemožno ho vydávať za výsledok tejto šesťpacientovej modelovej štúdie.</p>

<h2>Hlavné limity</h2>

<ul>
  <li>Analýza zahŕňala iba šesť pacientov a dve 4-hodinové výmeny na pacienta. Jeden pacient bol vysoký, traja stredne vysokí a dvaja stredne nízki transportéri; nízky typ transportu zastúpený nebol.</li>
  <li>Všetci pacienti boli už pred štúdiou dlhodobo liečení roztokom Dianeal PD4. Výsledky sa týkajú 2 litrov 3,86 % glukózy a nemožno ich automaticky prenášať na kratšie výmeny, APD, iné koncentrácie glukózy, ikodextrín, deti, akútnu PD alebo kriticky chorých pacientov.</li>
  <li>Parametre sa kalibrovali na tých istých údajoch, na ktorých sa hodnotila zhoda modelu. Chýbala externá validačná kohorta.</li>
  <li>Okamžitá premena laktátu na bikarbonát v pomere 1 : 1 je zjednodušujúci predpoklad, nie priamo overený dej.</li>
  <li>Ventilácia, metabolické rýchlosti, peritoneálna perfúzia a rozdelenie odstránenej tekutiny boli zjednodušené alebo pevne zadané; predialyzačná venózna saturácia O₂ bola pre nedostatok údajov nastavená na 0,65 u všetkých pacientov.</li>
  <li>Acidobázická časť používa kodanský prístup a výslovne nevynucuje úplnú elektroneutralitu ani všetky väzby medzi iónmi, tkanivami a erytrocytmi.</li>
  <li>Plazmatické profily viacerých ostatných rozpustených látok boli vstupom modelu, nie jeho predikciou. Zdrojový kód ani verejný dátový súbor nie sú sprístupnené; doplnkový materiál obsahuje rovnice, nie spustiteľný program.</li>
  <li>Štúdia neposkytuje údaje o dlhodobej kontinuálnej ambulantnej alebo automatizovanej PD, symptómoch, hospitalizáciách, reziduálnej funkcii obličiek, zlyhaní liečebnej metódy ani mortalite.</li>
</ul>

<p><strong>Poznámka k označeniu roztokov:</strong> v jednej úvodnej vete diskusie originálneho článku sú skratky B/L a PD4 zjavne zamenené. Abstrakt, metodika, výsledky, obrázky aj názvy produktov konzistentne definujú B/L ako bikarbonátovo-laktátový Physioneal a PD4 ako laktátový Dianeal PD4; týmto definíciám sa riadi aj naše spracovanie.</p>

<p><strong>Poznámka k jednotke rozpustnosti CO₂:</strong> hlavný text uvádza 0,23 mmol/L/mmHg, kým doplnkový matematický materiál pracuje s pCO₂ v kPa. Fyzikálne konzistentná jednotka je 0,23 mmol/L/kPa, približne 0,031 mmol/L/mmHg. Chybnú jednotku z hlavného textu preto v našich výpočtoch ani záveroch nepreberáme.</p>

<h2>Záver</h2>

<p>Integrovaný model 3PM/ABE presvedčivo ukazuje, prečo pri peritoneálnej dialýze nestačí sledovať iba koncentrácie v dialyzáte. Krátkodobý transperitoneálny tok bikarbonátu, laktátu a CO₂ treba zasadiť do celotelovej acidobázickej regulácie. Model po kalibrácii dobre reprodukoval údaje zo šiestich pacientov a pri oboch roztokoch odhadol prevažne podobné parametre transportu, hoci samotná kinetika tlmivých látok sa výrazne líšila.</p>

<p style="page-break-inside: avoid;">Najbezpečnejší klinický záver je úzky: práca podporuje fyziologickú vierohodnosť integrovaného modelovania a poskytuje základ pre ďalšiu validáciu. Nepreukazuje klinickú ekvivalenciu, nadradenosť, dlhodobú bezpečnosť ani vhodnosť konkrétneho roztoku pre pacienta s poruchou pečene alebo pľúc. Na takéto rozhodnutia sú potrebné klinické údaje a individuálne zhodnotenie pacienta, nie iba simulácia.</p>

<hr>

<p><em><strong>Zdroj – originálna štúdia:</strong> Pietribiasi M, Stachowska-Pietka J, Waniewski J, Lindholm B, Heimbürger O. Mathematical modeling of peritoneal buffer transport and acidosis correction in patients on peritoneal dialysis. <em>Scientific Reports</em>. 2026;16(1):20555. doi: <a href="https://doi.org/10.1038/s41598-026-53800-0" target="_blank" rel="noopener noreferrer">10.1038/s41598-026-53800-0</a>. PMID 42401598: <a href="https://pubmed.ncbi.nlm.nih.gov/42401598/" target="_blank" rel="noopener noreferrer">PubMed</a>. PMCID PMC13333014: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13333014/" target="_blank" rel="noopener noreferrer">PubMed Central – plný text</a>. <a href="https://www.nature.com/articles/s41598-026-53800-0" target="_blank" rel="noopener noreferrer">Nature / Scientific Reports – originálny zdroj</a>. <a href="https://europepmc.org/article/MED/42401598" target="_blank" rel="noopener noreferrer">Europe PMC</a>. <a href="https://www.nature.com/articles/s41598-026-53800-0.pdf" target="_blank" rel="noopener noreferrer">PDF originálneho článku</a>. Článok bol publikovaný 4. júla 2026 pod licenciou CC BY 4.0.</em></p>

<p><em><strong>Všetci autori zdrojovej štúdie:</strong> Mauro Pietribiasi; Joanna Stachowska-Pietka; Jacek Waniewski; Bengt Lindholm; Olof Heimbürger.</em></p>

<p style="page-break-inside: avoid;"><em><strong>Financovanie a vyhlásenia zdroja:</strong> Výskum pracovísk Renal Medicine a Baxter Novum vznikol vďaka grantu spoločnosti Vantive (predtým Baxter Healthcare Corporation) pre Department of Clinical Science, Intervention and Technology, Karolinska Institutet. Oba skúmané roztoky vyrábala spoločnosť Baxter; článok bližšie nešpecifikuje úlohu poskytovateľa grantu pri dizajne, analýze alebo publikovaní. Otvorený prístup financoval Karolinska Institutet. Autori deklarovali, že nemajú konflikty záujmov. Údaje sú dostupné na základe odôvodnenej žiadosti.</em></p>

<p><em><strong>Doplnkový materiál a zdroje použité pri vecnej kontrole:</strong> <a href="https://static-content.springer.com/esm/art%3A10.1038%2Fs41598-026-53800-0/MediaObjects/41598_2026_53800_MOESM1_ESM.docx" target="_blank" rel="noopener noreferrer">doplnkový materiál k originálnej štúdii</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/14870876/" target="_blank" rel="noopener noreferrer">pôvodná publikácia časti klinických údajov</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6517187/" target="_blank" rel="noopener noreferrer">Cochrane – biokompatibilné roztoky pre peritoneálnu dialýzu</a>; <a href="https://ispd.org/guidelines/" target="_blank" rel="noopener noreferrer">prehľad odporúčaní ISPD</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/33267747/" target="_blank" rel="noopener noreferrer">ISPD – akútna peritoneálna dialýza u dospelých</a>.</em></p>
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
