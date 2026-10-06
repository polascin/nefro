<?php
/**
 * add_integrovane-systemy-cgm-aid-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie odborného článku o integrovaných systémoch CGM a AID
 * (EASD 2026, SMART02, PharmaSens/SiBionics) a ich nefrologických aspektoch.
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'Integrované systémy kontinuálneho monitorovania glukózy a automatizovaného podávania inzulínu: nové technológie a nefrologické súvislosti',
    'slug'         => 'integrovane-systemy-cgm-aid-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Na kongrese EASD 2026 boli predstavené integrované systémy spájajúce kontinuálne monitorovanie glukózy a automatizované podávanie inzulínu do jednej náplasti. V nefrológii otvárajú nové možnosti, no vyžadujú osobitnú pozornosť pre riziká pri pokročilom CKD a dialýze.',
    'content'      => <<<'HTML'
<figure><a href="img/integrovane-systemy-cgm-aid-nefrologia.webp" rel="noopener noreferrer" target="_blank"><img src="img/integrovane-systemy-cgm-aid-nefrologia.webp" alt="Integrovaný senzor kontinuálneho monitorovania glukózy a mikroinfúzie inzulínu v nositeľnej náplasti" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Integrovaný koncept nositeľného systému (all-in-one patch pump) kombinujúci kontinuálne monitorovanie glukózy, algoritmické vyhodnocovanie a podávanie inzulínu. Pri pokročilom ochorení obličiek a dialýze vyžadujú takéto systémy osobitné klinické overenie.</figcaption></figure>

<p>Na 62. výročnom zasadnutí Európskej asociácie pre štúdium diabetu (EASD 2026), ktoré sa konalo v Miláne od 28. septembra do 2. októbra 2026, predstavili technologickí partneri SiBionics a PharmaSens vývojové koncepty v oblasti kontinuálneho monitorovania glukózy, monitorovania ketolátok a automatizovaného podávania inzulínu.</p>

<p>Výraznú pozornosť vzbudil výskumný prototyp označovaný ako <em>niia signature</em>. Zariadenie smeruje k integrácii kontinuálneho senzora glukózy (CGM), infúzneho mechanizmu na podávanie inzulínu a algoritmu automatizovanej regulácie glykémie (AGC) do jedinej nositeľnej náplasti. Ide o vývojový prototyp, ktorý zatiaľ nezískal schválenie regulačných orgánov a nie je dostupný na trhu. Pre klinickú prax a osobitne pre nefrológiu však otvára zásadné otázky o tom, ako sa technologický pokrok vyrovnáva s náročnými patofyziologickými podmienkami u pacientov s poruchou funkcie obličiek.</p>

<h2>Od samostatných senzorov k automatizovanej liečbe (AID)</h2>

<p>Súčasné systémy automatizovaného podávania inzulínu (Automated Insulin Delivery, AID), nazývané aj hybridné systémy s uzavretou slučkou, využívajú údaje z podkožného glukózového senzora na dynamickú úpravu dávkovania inzulínu prostredníctvom riadiaceho algoritmu. Ich hlavným cieľom je znížiť glykemickú variabilitu, predĺžiť čas strávený v cieľovom rozmedzí (Time in Range, TIR) a minimalizovať výskyt závažnej hypoglykémie.</p>

<p>Väčšina doterajších komerčných AID systémov si vyžaduje nosenie dvoch samostatných zariadení na tele: nezávislého senzora CGM a samostatnej infúznej súpravy či patch pumpy, ktoré navzájom komunikujú bezdrôtovo. Technologický vývoj prirodzene smeruje k unifikácii:</p>

<ul>
  <li>kontinuálne stanovenie intersticiálnej glukózy,</li>
  <li>mikroinfúzia inzulínu cez integrovanú kanylu,</li>
  <li>algoritmické spracovanie dát priamo v riadiacej jednotke náplasti,</li>
  <li>automatická prediktívna modulácia bazálnej aj korekčnej dávky,</li>
  <li>potenciálne súbežné monitorovanie ketolátok a ďalších biomarkerov.</li>
</ul>

<p>Zjednotenie do jedného aplikačného prvku znižuje záťaž pacienta spojenú s nosením viacerých pomôcok. Z bioinžinierskeho a medicínskeho hľadiska však prináša špecifické riziká, najmä ak sa senzorový filament a infúzna kanyla nachádzajú v tesnej anatomickej blízkosti v podkoží.</p>

<h2>Štúdia SMART02 a fenomén lokálnej interferencie</h2>

<p>Na kongrese EASD 2026 odzneli prvé výsledky štúdie uskutočniteľnosti <strong>SMART02</strong>, ktorú prezentoval profesor Ahmad Haidar z McGill University. Výskum hodnotil skorý prototyp systému niia signature s cieľom overiť, či podávanie inzulínu v bezprostrednom okolí senzora glukózy nespôsobuje dočasné skreslenie meraných hodnôt.</p>

<p>Kľúčovým pozorovaním bolo, že pri bežnom bazálnom dávkovaní bola presnosť merania stabilná. Dočasná interferencia sa však vyskytovala po podaní bolusových dávok s veľkosťou 10 jednotiek inzulínu alebo vyšších. Pri takýchto dávkach dosahovala pravdepodobnosť prechodného výkyvu signálu približne 20 až 25 %. K úplnému obnoveniu spoľahlivého signálu senzora došlo v priemere do 20 minút po aplikácii bolusu.</p>

<p>Z hľadiska medicíny založenej na dôkazoch je nevyhnutné hodnotiť tieto dáta triezvo. Išlo o pilotnú štúdiu uskutočniteľnosti na obmedzenom počte participantov. Štúdia neposkytuje dôkaz o dlhodobej bezpečnosti, klinickej účinnosti ani o vplyve na metabolickú kompenzáciu v reálnom živote. Zverejnené dáta zatiaľ neobsahujú podrobné rozdelenie podľa veku, typu diabetu, referenčnej laboratórnej metódy ani klinické ukazovatele, akými sú percento času v hypoglykémii či výskyt technických zlyhaní.</p>

<h2>Prečo je diabetes s chronickou chorobou obličiek špecifický</h2>

<p>Kombinácia diabetu a chronickej choroby obličiek (CKD) predstavuje jednu z najzložitejších oblastí internej medicíny. Progresívny pokles renálnych funkcií zásadne mení homeostázu glukózy a metabolizmus inzulínu:</p>

<ul>
  <li><strong>Znížený renálny klírens inzulínu:</strong> Zdravé obličky odbúravajú približne 30 až 40 % cirkulujúceho inzulínu. Pri poklese glomerulovej filtrácie (eGFR pod 60 ml/min/1,73 m² a najmä pod 30 ml/min/1,73 m²) sa biologický polčas inzulínu výrazne predlžuje, čo rapídne zvyšuje riziko oneskorených a prolongovaných hypoglykémií.</li>
  <li><strong>Znížená renálna glukoneogenéza:</strong> Renálny kortex sa významne podieľa na systémovej novotvorbe glukózy nalačno. Pri zániku funkčného parenchýmu je táto záchranná brzda pred hypoglykémiou oslabená.</li>
  <li><strong>Nepredvídateľná glykemická variabilita:</strong> Sprievodná uremická enteropatia, diabetická gastroparéza a nechutenstvo spôsobujú disproporciu medzi resorpciou živín a farmakodynamikou podaného inzulínu.</li>
</ul>

<p>V pokročilých štádiách CKD (G4 a G5) a u pacientov v pravidelnom dialyzačnom programe navyše <strong>glykovaný hemoglobín (HbA1c) stráca svoju diagnostickú spoľahlivosť</strong>. Hodnoty HbA1c bývajú skreslené skráteným prežívaním erytrocytov, renálnou anémiou, liečbou erytropoetínom (ESA), intravenóznym železom, krvnými transfúziami aj prítomnosťou karbamylovaného hemoglobínu. HbA1c nedokáže zachytiť nebezpečné nočné hypoglykémie ani prudké výkyvy v priebehu dňa.</p>

<p>Konsenzuálne odporúčania American Diabetes Association (ADA) a Kidney Disease: Improving Global Outcomes (KDIGO), ako aj odborné stanovisko publikované v roku 2025 (Rhee et al., <em>Journal of Diabetes Science and Technology</em>), jednoznačne vyzdvihujú kontinuálne monitorovanie glukózy ako kľúčový nástroj u pacientov s CKD. CGM poskytuje dynamický pohľad na čas strávený v cieľovom pásme (TIR 70–180 mg/dl, t. j. 3,9–10,0 mmol/l), čas pod cieľovým pásmom (TBR &lt; 70 mg/dl, t. j. &lt; 3,9 mmol/l) a odhaľuje asymptomatické hypoglykémie.</p>

<h2>Špecifiká hemodialýzy a validácia presnosti senzorov</h2>

<p>Hemodialyzačná procedúra vystavuje pacienta extrémnym metabolickým a objemovým zmenám, ktoré priamo ovplyvňujú chovanie glukózy aj fungovanie biosenzorov:</p>

<ul>
  <li><strong>Difúzia glukózy cez dialyzačnú membránu:</strong> Pri použití dialyzačného roztoku bez glukózy dochádza k rýchlym stratám glukózy do dialyzátu. Použitie roztokov s fyziologickou koncentráciou glukózy (5,5 mmol/l, resp. 100 mg/dl) tieto straty tlmí, no dynamika výmeny ostáva výrazná.</li>
  <li><strong>Zmeny inzulínovej rezistencie:</strong> Odstránenie uremických toxínov počas dialýzy akútne zlepšuje tkanivovú citlivosť na inzulín, čo môže po dialýze viesť k náhlemu prepadu glykémie.</li>
  <li><strong>Objemové posuny a intersticiálna hydratácia:</strong> Ultrafiltrácia odstraňuje tekutinu z intravaskulárneho a následne z intersticiálneho priestoru. Keďže CGM senzory merajú koncentráciu glukózy v intersticiálnej tekutine, rýchla dehydratácia podkožia, periférna vazokonstrikcia a edémy môžu ovplyvniť difúziu glukózy k enzýmovej elektróde.</li>
</ul>

<p>Významná klinická štúdia Narasakiho a kolektívu (<em>Diabetes Care</em> 2024;47(11):1922–1930) hodnotila analytickú presnosť CGM u dialyzovaných diabetikov. Výskum ukázal, že stredná absolútna relatívna odchýlka (MARD) bola u hemodialyzovaných pacientov vyššia než v bežnej populácii, dosahujúc približne 20 % (18,2 % v nedialyzačné dni oproti 22,0 % počas samotnej dialýzy). Napriek nižšej numerickej presnosti však analýza podľa konsenzuálnych chybových mriežok (Parkes/Clarke Error Grid) potvrdila, že takmer všetky namerané hodnoty spadali do klinicky bezpečných zón A a B, kde nehrozí nesprávne liečebné rozhodnutie vedúce k poškodeniu pacienta.</p>

<p>Platí však striktné klinické pravidlo: ak sa klinický stav pacienta nezhoduje s hodnotou na displeji senzora, alebo pri podozrení na ťažkú hypoglykémiu, je nevyhnutné okamžité overenie kapilárnou alebo laboratórnou glykémiou.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie parametrov a manažmentu glykémie u bežnej populácie a pri pokročilom CKD" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Klinický parameter / Technológia</th>
      <th scope="col">Bežná populácia (bez závažného CKD)</th>
      <th scope="col">Pokročilé CKD (G4–G5) a hemodialýza</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Spoľahlivosť HbA1c</th>
      <td>Štandardný biomarker dlhodobej kompenzácie</td>
      <td>Nespoľahlivý (skreslenie anémiou, liečbou ESA, transfúziami a uémiou)</td>
    </tr>
    <tr>
      <th scope="row">Klírens a biologický polčas inzulínu</th>
      <td>Fyziologický, rýchla eliminácia obličkami a pečeňou</td>
      <td>Výrazne predĺžený biologický polčas, kumulácia inzulínu, fenomén „vyhorenia diabetu“</td>
    </tr>
    <tr>
      <th scope="row">Presnosť CGM senzorov (MARD)</th>
      <td>Vysoká, obvykle 8 až 10 %</td>
      <td>Mierne znížená (MARD okolo 18 až 22 %), no klinicky prijateľná (zóny A a B)</td>
    </tr>
    <tr>
      <th scope="row">Algoritmy automatizovaného dávkovania (AID)</th>
      <td>Overené v desiatkach veľkých randomizovaných štúdií</td>
      <td>Pilotné dáta a kazuistické série, chýbajú veľké multicentrické RCT</td>
    </tr>
    <tr>
      <th scope="row">Riziko ťažkej hypoglykémie</th>
      <td>Pri bežnom manažmente nízke až stredné</td>
      <td>Mimoriadne vysoké, hrozba protrahovanej a nerozpoznanej nočnej hypoglykémie</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Kontinuálne monitorovanie ketolátok (CKM) a nefrologické úskalia</h2>

<p>Ďalším významným technologickým trendom diskutovaným na kongrese EASD 2026 je kontinuálne monitorovanie ketolátok (Continuous Ketone Monitoring, CKM). Zariadenia merajú koncentráciu beta-hydroxybutyrátu v podkoží v reálnom čase s aktualizáciou každých niekoľko minút (Kong et al., <em>Diabetes Obesity and Metabolism</em> 2024; Nguyen et al., <em>Journal of Diabetes Science and Technology</em> 2022).</p>

<p>Perspektíva CKM je mimoriadna pri diabete 1. typu, pri akútnych infekčných dekompenzáciách a osobitne <strong>pri liečbe inhibítormi SGLT2 (gliflozínmi)</strong>. Inhibítory SGLT2 sa stali základným pilierom nefroprotektívnej liečby pri chronickom ochorení obličiek. U pacientov s diabetom však nesú známe, hoci zriedkavé riziko <em>euglykemickej diabetickej ketoacidózy</em> (euDKA), kde hladina glukózy v krvi nepresahuje varovné hodnoty, no ketogenéza prudko akceleruje. Senzor CKM dokáže zachytiť stúpajúcu hladinu ketolátok skôr, než sa rozvinie plný metabolický rozvrat.</p>

<p>Pre nefrológa má však interpretácia ketolátok špecifické úskalia. Pacienti s pokročilým CKD majú často prítomnú chronickú metabolickú acidózu s normálnou alebo zvýšenou aniónovou medzerou (spôsobenú retenciou sulfátov, fosfátov a organických kyselín v dôsledku poklesu tubulárnej sekrécie vodíkových iónov). Samotný údaj z podkožného senzora preto <strong>nesmie nahradiť komplexné laboratórne vyšetrenie</strong>:</p>

<ul>
  <li>stanovenie acidobázickej rovnováhy (pH, pCO₂, aktuálny bikarbonát),</li>
  <li>výpočet sérovej aniónovej medzery (anion gap),</li>
  <li>stanovenie sérových elektrolytov vrátane draslíka a chloridov,</li>
  <li>laboratórne overenie venóznych ketolátok a laktátu.</li>
</ul>

<h2>Klinické výzvy a riziká AID systémov pri zlyhávaní obličiek</h2>

<p>Automatizované systémy podávania inzulínu predstavujú prísľub stability, no pri ich nekritickej aplikácii u pacientov s pokročilou renálnou insuficienciou hrozia závažné komplikácie:</p>

<ol>
  <li><strong>Nesúlad algoritmu s farmakokinetikou:</strong> Štandardné komerčné algoritmy kalkulujú s krivkami aktívneho inzulínu odvodenými od jedincov so zachovanou renálnou elimináciou. Ak algoritmus pri pretrvávajúcej hyperglykémii opakovane pridáva korekčné dávky, zatiaľ čo predchádzajúci inzulín sa z tela odbúrava spomalene, dochádza k nebezpečnému „stohovaniu inzulínu“ (insulin stacking) a k masívnej oneskorenej hypoglykémii.</li>
  <li><strong>Rozdiel medzi dialyzačnými a nedialyzačnými dňami:</strong> Potreba inzulínu u dialyzovaného pacienta kolíše zo dňa na deň. Fixné alebo pomaly sa adaptujúce algoritmy nemusia adekvátne reagovať na skokové zmeny inzulínovej senzitivity po hemodialýze.</li>
  <li><strong>Zlyhanie kanyly a rýchly rozvoj ketoacidózy:</strong> Inzulínové pumpy používajú výhradne rýchlo účinkujúce inzulínové analógy bez prítomnosti depotného bazálneho inzulínu. Ak sa infúzna kanyla v náplasti upchá, zalomí alebo dislokuje, pacient ostáva v priebehu niekoľkých hodín bez inzulínu, čo môže vyvolať prudkú ketoacidózu.</li>
  <li><strong>Lokálne kožné zmeny a edémy:</strong> Uremickí pacienti trpia suchosťou kože, pruritom, zhoršeným hojením a tkanivovým edémom, čo môže komplikovať spoľahlivé uchytenie integrovanej náplasti a stabilitu senzora.</li>
</ol>

<h2>Aké dôkazy musí priniesť integrovaný systém pred vstupom do nefrológie</h2>

<p>Prechod integrovaného zariadenia typu <em>niia signature</em> z fázy technologického prototypu do klinickej praxe si vyžaduje rozsiahly translačný a klinický výskum. Regulačné orgány aj odborné spoločnosti budú vyžadovať dáta z prospektívnych štúdií zameraných priamo na nefrologickú populáciu:</p>

<ul>
  <li>presnosť merania glukózy overenú proti referenčnej laboratórnej metóde (napr. glukózooxidázovej metóde YSI) osobitne v hypoglykemickom pásme pod 70 mg/dl (3,9 mmol/l),</li>
  <li>validáciu funkčnosti počas hemodialyzačnej procedúry a bezprostredne po nej,</li>
  <li>preukázanie, že lokálna infúzia inzulínu neovplyvňuje biosenzor pri kumulatívnych dávkach a po niekoľkých dňoch nosenia na jednom mieste,</li>
  <li>štúdie bezpečnosti a účinnosti u pacientov s eGFR pod 30 ml/min/1,73 m², na hemodialýze, na peritoneálnej dialýze a po transplantácii obličky,</li>
  <li>hodnotenie výskytu diabetickej ketoacidózy, ťažkej hypoglykémie s potrebou pomoci druhej osoby a frekvencie technických zlyhaní hardvéru.</li>
</ul>

<h2>Praktické odporúčania pre nefrologickú ambulanciu</h2>

<p>Hoci plne integrované náplasti typu „všetko v jednom“ sú zatiaľ hudbou budúcnosti, samostatné CGM senzory sa už dnes stávajú neoceniteľnou súčasťou manažmentu diabetu pri CKD. Pre lekárov v nefrologických ambulanciách a dialyzačných strediskách z toho vyplývajú tieto kľúčové zásady:</p>

<ul>
  <li><strong>Indikovať CGM u rizikových pacientov:</strong> Senzor je prínosný najmä u pacientov liečených inzulínom alebo derivátmi sulfonylmočoviny, u pacientov s nerozpoznávaním hypoglykémie a pri diskrepancii medzi HbA1c a klinickým stavom.</li>
  <li><strong>Poznať analytické limity:</strong> Rátať s tým, že MARD u dialyzovaných pacientov je vyššia. Pri akýchkoľvek pochybnostiach alebo príznakoch hypoglykémie overiť hodnotu kapilárnou glukózou.</li>
  <li><strong>Sledovať obdobie po dialýze:</strong> Riziko závažného poklesu glykémie stúpa v hodinách nasledujúcich po ukončení hemodialýzy v dôsledku odstránenia uremických inhibítorov a zvýšenia inzulínovej senzitivity.</li>
  <li><strong>Konzultovať diabetologicko-nefrologický tím:</strong> Nasadenie inzulínovej pumpy či AID systému u dialyzovaného pacienta vyžaduje úzku medziodborovú spoluprácu a individuálne upravené cieľové pásma glykémie (často s toleranciou mierne vyšších hodnôt v záujme prevencie hypoglykémie).</li>
  <li><strong>Pravidlo pri SGLT2 inhibítoroch:</strong> Pri podozrení na ketoacidózu okamžite vyšetriť pH a bikarbónát v krvi; normálna glykémia nevylučuje euglykemickú DKA.</li>
</ul>

<div class="info-box-blue">
<p><strong>Laboratórny prepočet jednotiek glukózy.</strong> V klinickej praxi a medzinárodnej literatúre sa používajú jednotky mmol/l aj mg/dl. Pre rýchly prepočet platí:</p>
<ul>
  <li>glykémia v mmol/l = glykémia v mg/dl ÷ 18,018 (približne mg/dl × 0,0555),</li>
  <li>glykémia v mg/dl = glykémia v mmol/l × 18,018 (približne mmol/l × 18),</li>
  <li>cieľové pásmo 70 až 180 mg/dl zodpovedá 3,9 až 10,0 mmol/l; prah hypoglykémie 70 mg/dl zodpovedá 3,9 mmol/l; prah klinicky závažnej hypoglykémie 54 mg/dl zodpovedá 3,0 mmol/l.</li>
</ul>
</div>

<h2>Záver</h2>

<p>Vývojový prototyp niia signature predstavený na kongrese EASD 2026 ilustruje technologický smer, ktorým sa uberá moderná diabetológia: miniaturizácia, integrácia senzorov a dávkovačov do jedného nositeľného prvku a automatizované uzatváranie regulačnej slučky. Výsledky štúdie SMART02 potvrdili realizovateľnosť takéhoto riešenia, no zároveň poukázali na technické výzvy pri bolusovom podávaní inzulínu v tesnej blízkosti biosenzora.</p>

<p>Pre nefrológiu zostáva kľúčovým odkazom skutočnosť, že pacienti s pokročilým ochorením obličiek a pacienti odkázaní na dialýzu predstavujú zraniteľnú skupinu s odlišnou farmakokinetikou inzulínu, zmenenou intersticiálnou dynamikou a vysokou mierou kardiovaskulárneho rizika. Kým sa integrované systémy stanú bežnou realitou v nefrologických ambulanciách, bude potrebné ich bezpečnosť a algoritmy rigorózne overiť v dedikovaných klinických štúdiách zameraných na pacientov so zlyhávaním obličiek.</p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>SiBionics, PharmaSens. <em>SIBIONICS and PharmaSens Explore New Horizons for Automated Insulin Delivery at EASD 2026.</em> PR Newswire, 4. októbra 2026. <a href="https://www.prnewswire.com/news-releases/sibionics-and-pharmasens-explore-new-horizons-for-automated-insulin-delivery-at-easd-2026-302897720.html" target="_blank" rel="noopener noreferrer">prnewswire.com</a></li>
  <li>Európska asociácia pre štúdium diabetu. <em>62nd EASD Annual Meeting, Miláno, 28. septembra – 2. októbra 2026.</em> <a href="https://www.easd.org/annual-meeting/easd-2026/" target="_blank" rel="noopener noreferrer">easd.org</a></li>
  <li>American Diabetes Association Professional Practice Committee. <em>7. Diabetes Technology: Standards of Care in Diabetes – 2026.</em> Diabetes Care 2026;49(Suppl 1):S150–S178. <a href="https://doi.org/10.2337/dc26-S007" target="_blank" rel="noopener noreferrer">doi:10.2337/dc26-S007</a> (PMID: 41358889, PMC12690173).</li>
  <li>de Boer IH, Khunti K, Sadusky T, Tuttle KR, Neumiller JJ, Rhee CM, Rosas SE, Rossing P, Bakris G. <em>Diabetes Management in Chronic Kidney Disease: A Consensus Report by the American Diabetes Association (ADA) and Kidney Disease: Improving Global Outcomes (KDIGO).</em> Diabetes Care 2022;45(12):3075–3090. <a href="https://doi.org/10.2337/dci22-0027" target="_blank" rel="noopener noreferrer">doi:10.2337/dci22-0027</a> (PMID: 36189689, PMC9870667).</li>
  <li>Hughes MS, Levy CJ. <em>The Future of Automated Insulin Delivery Systems.</em> Endocr Pract 2025;31(9):1016–1025. <a href="https://doi.org/10.1016/j.eprac.2025.05.752" target="_blank" rel="noopener noreferrer">doi:10.1016/j.eprac.2025.05.752</a> (PMID: 40532759).</li>
  <li>Liarakos AL, Randhay A, Wilmot EG. <em>Continuous glucose monitoring and automated insulin delivery systems in the management of diabetes among individuals with chronic kidney disease on dialysis.</em> Curr Opin Nephrol Hypertens 2025;34(6):533–540. <a href="https://doi.org/10.1097/MNH.0000000000001106" target="_blank" rel="noopener noreferrer">doi:10.1097/MNH.0000000000001106</a> (PMID: 40693396).</li>
  <li>Chaudhry K, Hyslop R, Johnston T, Pender S, Hussain S, Karalliedde J. <em>Case series of using automated insulin delivery to improve glycaemic control in people with type 1 diabetes and end stage kidney disease on haemodialysis.</em> Diabetes Res Clin Pract 2024;217:111800. <a href="https://doi.org/10.1016/j.diabres.2024.111800" target="_blank" rel="noopener noreferrer">doi:10.1016/j.diabres.2024.111800</a> (PMID: 39151730).</li>
  <li>Rhee CM, Gianchandani RY, Kerr D, Philis-Tsimikas A, Kovesdy CP, Stanton RC, Drincic AT, Galindo RJ, Kalantar-Zadeh K, Neumiller JJ, de Boer IH, Lind M, Kim SH, Ayers AT, Ho CN, Aaron RE, Tian T, Klonoff DC. <em>Consensus Report on the Use of Continuous Glucose Monitoring in Chronic Kidney Disease and Diabetes.</em> J Diabetes Sci Technol 2025;19(1):198–215. <a href="https://doi.org/10.1177/19322968241292041" target="_blank" rel="noopener noreferrer">doi:10.1177/19322968241292041</a> (PMID: 39611379).</li>
  <li>Narasaki Y, Kalantar-Zadeh K, Daza AC, You AS, Novoa A, Peralta RA, Siu MKM, Nguyen DV, Rhee CM. <em>Accuracy of Continuous Glucose Monitoring in Hemodialysis Patients With Diabetes.</em> Diabetes Care 2024;47(11):1922–1930. <a href="https://doi.org/10.2337/dc24-0635" target="_blank" rel="noopener noreferrer">doi:10.2337/dc24-0635</a> (PMID: 39213372).</li>
  <li>Kong YW, Morrison D, Lu JC, Lee MH, Jenkins AJ, O'Neal DN. <em>Continuous ketone monitoring: Exciting implications for clinical practice.</em> Diabetes Obes Metab 2024;26(12):5501–5512. <a href="https://doi.org/10.1111/dom.15921" target="_blank" rel="noopener noreferrer">doi:10.1111/dom.15921</a> (PMID: 39314201).</li>
  <li>Nguyen KT, Xu NY, Zhang JY, Shang T, Basu A, Bergenstal RM, Castorino K, Chen KY, Kerr D, Koliwad SK, Laffel LM, Mathioudakis N, Midyett LK, Miller JD, Nichols JH, Pasquel FJ, Prahalad P, Prausnitz MR, Seley JJ, Sherr JL, Spanakis EK, Umpierrez GE, Wallia A, Klonoff DC. <em>Continuous Ketone Monitoring Consensus Report 2021.</em> J Diabetes Sci Technol 2022;16(3):689–715. <a href="https://doi.org/10.1177/19322968211042656" target="_blank" rel="noopener noreferrer">doi:10.1177/19322968211042656</a> (PMID: 34605694).</li>
  <li>Jaromy M, Miller JD. <em>Potential Clinical Applications for Continuous Ketone Monitoring in the Hospitalized Patient with Diabetes.</em> Curr Diab Rep 2022;22(10):477–485. <a href="https://doi.org/10.1007/s11892-022-01489-6" target="_blank" rel="noopener noreferrer">doi:10.1007/s11892-022-01489-6</a> (PMID: 35984565).</li>
</ol>

<p><em>Bibliografické údaje citovaných prác boli verifikované v databáze PubMed a v oficiálnych zborníkoch.</em></p>

<p><em><strong>Upozornenie:</strong> Článok má odborný a vzdelávací charakter a je určený pre zdravotníckych pracovníkov. Nenahrádza oficiálne súhrny charakteristických vlastností zdravotníckych pomôcok ani individuálny klinický úsudok ošetrujúceho nefrológa a diabetológa.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_integrovane-systemy-cgm-aid-nefrologia_article',
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
