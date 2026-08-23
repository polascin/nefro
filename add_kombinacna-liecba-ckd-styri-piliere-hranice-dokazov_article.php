<?php
/**
 * add_kombinacna-liecba-ckd-styri-piliere-hranice-dokazov_article.php
 * Idempotentný UPSERT skript pre odborne a jazykovo korigovaný článok
 * o kombinovanej liečbe chronickej choroby obličiek.
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
    'title'        => 'Kombinovaná liečba chronickej choroby obličiek: štyri piliere, dôkazy a otvorené otázky',
    'slug'         => 'kombinacna-liecba-ckd-styri-piliere-hranice-dokazov',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-07-13 21:25:22',
    'is_top'       => 0,
    'excerpt'      => 'RASi, inhibítory SGLT2, finerenón a liečba založená na GLP-1 môžu pri CKD pôsobiť komplementárne. Nie každý pacient však potrebuje všetky štyri triedy a úplná kombinácia zatiaľ nemá priamy dôkaz z výsledkovej štúdie.',
    'content'      => <<<'HTML'
<p>Farmakologická ochrana obličiek sa desaťročia opierala najmä o kontrolu krvného tlaku a blokádu systému renín–angiotenzín (RAS). Dnes sa k inhibítorom enzýmu konvertujúceho angiotenzín a blokátorom receptora AT1 (spoločne RASi) pridali inhibítory sodíkovo-glukózového kotransportéra 2 (SGLT2), finerenón a u vybraných pacientov liečba založená na glukagónu podobnom peptide 1 (GLP-1). Moderná nefroprotekcia tak môže cieliť viacero mechanizmov súčasne.</p>

<p>Tento posun však neznamená, že „podporná starostlivosť“ stratila význam alebo že každý človek s chronickou chorobou obličiek (CKD) má dostať rovnakú štvorliekovú schému. Kontrola krvného tlaku a objemového stavu, primerané obmedzenie sodíka, nefajčenie, pohyb, úprava hmotnosti, liečba dyslipidémie a glykémie aj prevencia akútneho poškodenia obličiek zostávajú základom. Samotná blokáda RAS navyše nie je iba podporným opatrením: u správne vybraných pacientov ide o liečbu modifikujúcu priebeh ochorenia.</p>

<p>Januárový <strong>editoriál</strong>, ktorého prvým autorom je Kaiyu He, v časopise <em>Nephrology Dialysis Transplantation</em> opisuje prechod ku kombinačnej liečbe CKD. Nejde o novú randomizovanú štúdiu, systematický prehľad ani klinické odporúčanie. Je to odborná perspektíva, ktorú treba čítať spolu s primárnymi štúdiami a s ohľadom na to, čo bolo priamo dokázané, čo je odvodené z náhradných ukazovateľov a čo zostáva iba modelovým odhadom.</p>

<h2>„Štyri piliere“ sú rámec, nie univerzálny predpis</h2>

<p>Kardiovaskulárno-obličkovo-metabolický syndróm (CKM; z angl. <span lang="en">cardiovascular–kidney–metabolic</span>) upriamuje pozornosť na prepojenie hemodynamiky, metabolizmu, zápalu, fibrózy a kardiovaskulárneho rizika. Tento rámec odôvodňuje liečbu zameranú na viac mechanizmov. Nenahrádza však určenie príčiny CKD ani špecifickú liečbu napríklad glomerulových chorôb, systémových autoimunitných ochorení, polycystickej choroby obličiek či obštrukcie močových ciest.</p>

<p>Pojem štvorpilierová liečba je najužitočnejší pri <strong>diabete 2. typu s albuminurickou CKD</strong>, pretože práve v tejto populácii sa indikácie jednotlivých tried najčastejšie prekrývajú. Odporúčanie <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO 2024</a> používa holistický liečebný prístup: podľa fenotypu pacienta zahŕňa RASi, inhibítor SGLT2, nesteroidového antagonistu mineralokortikoidového receptora (nsMRA) a agonistu receptora GLP-1. Neprikazuje však automatické nasadenie všetkých štyroch tried každému pacientovi s CKD.</p>

<div class="table-responsive" role="region" aria-label="Štyri piliere sú rámec, nie univerzálny predpis" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Liečebný pilier</th>
      <th scope="col">Kde je dôkaz najsilnejší</th>
      <th scope="col">Hlavný prínos a monitorovanie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>RASi</strong><br>ACE inhibítor alebo ARB</td>
      <td>CKD s hypertenziou a albuminúriou, osobitne pri diabete; ak je liek indikovaný, používa sa najvyššia schválená tolerovaná dávka</td>
      <td>Znižuje albuminúriu a riziko progresie; sledovať krvný tlak, kreatinín/eGFR a sérový draslík</td>
    </tr>
    <tr>
      <td><strong>Inhibítor SGLT2</strong></td>
      <td>Široké spektrum CKD s diabetom aj bez diabetu podľa eGFR, albuminúrie a prítomnosti srdcového zlyhávania</td>
      <td>Spomaľuje progresiu CKD a znižuje riziko srdcového zlyhávania; sledovať objemový stav a genitálne infekcie, poučiť o dočasnom prerušení pri dlhom hladovaní, operácii alebo kritickom ochorení</td>
    </tr>
    <tr>
      <td><strong>Finerenón</strong><br>nsMRA</td>
      <td>Diabetes 2. typu s CKD a pretrvávajúcou albuminúriou napriek RASi, pri vyhovujúcej eGFR a koncentrácii draslíka</td>
      <td>Znižuje obličkové a kardiovaskulárne riziko; rozhodujúce je monitorovanie draslíka a eGFR</td>
    </tr>
    <tr>
      <td><strong>Agonista receptora GLP-1</strong></td>
      <td>Najmä diabetes 2. typu s potrebou lepšej kontroly glykémie, hmotnosti alebo kardiovaskulárneho rizika; semaglutid má výsledkové údaje aj pri CKD</td>
      <td>Znižuje kardiovaskulárne riziko a pri semaglutide aj zložený obličkovo-kardiovaskulárny ukazovateľ; sledovať toleranciu tráviaceho traktu a riziko podvýživy</td>
    </tr>
  </tbody>
</table>
</div>

<p><em>ACE – enzým konvertujúci angiotenzín; ARB – blokátor receptora AT1; eGFR – odhadovaná glomerulová filtrácia. Konkrétna indikácia a dávkovanie sa musia riadiť aktuálnym súhrnom charakteristických vlastností lieku, odporúčaniami a klinickým stavom pacienta.</em></p>

<h2>Čo preukázali výsledkové štúdie jednotlivých tried</h2>

<p>Významný pokrok priniesli veľké randomizované štúdie, ich percentá však nemožno mechanicky porovnávať. Skúmali rozdielne populácie, mali odlišné vstupné hodnoty eGFR a albuminúrie a používali rozdielne zložené ukazovatele.</p>

<ul>
  <li><strong><a href="https://pubmed.ncbi.nlm.nih.gov/30990260/" target="_blank" rel="noopener noreferrer">CREDENCE</a>:</strong> u pacientov s diabetom 2. typu a albuminurickou CKD znížil kanagliflozín relatívne riziko primárneho zloženého obličkovo-kardiovaskulárneho ukazovateľa o 30 % oproti placebu.</li>
  <li><strong><a href="https://pubmed.ncbi.nlm.nih.gov/32970396/" target="_blank" rel="noopener noreferrer">DAPA-CKD</a>:</strong> dapagliflozín znížil relatívne riziko primárneho zloženého ukazovateľa o 39 % u pacientov s CKD s diabetom aj bez diabetu.</li>
  <li><strong><a href="https://pubmed.ncbi.nlm.nih.gov/36331190/" target="_blank" rel="noopener noreferrer">EMPA-KIDNEY</a>:</strong> empagliflozín znížil relatívne riziko progresie ochorenia obličiek alebo úmrtia z kardiovaskulárnych príčin o 28 % v širokej populácii CKD s diabetom aj bez neho.</li>
  <li><strong><a href="https://pubmed.ncbi.nlm.nih.gov/33264825/" target="_blank" rel="noopener noreferrer">FIDELIO-DKD</a>:</strong> finerenón pridaný k blokáde RAS pri diabete 2. typu a CKD znížil relatívne riziko zloženého obličkového ukazovateľa o 18 % (HR 0,82). Ukazovateľ zahŕňal zlyhanie obličiek, trvalý pokles eGFR najmenej o 40 % alebo úmrtie z obličkových príčin.</li>
  <li><strong><a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">FLOW</a>:</strong> semaglutid pri diabete 2. typu a CKD znížil relatívne riziko primárneho zloženého ukazovateľa o 24 % (HR 0,76). Tento ukazovateľ zahŕňal závažné obličkové príhody <strong>aj úmrtie z kardiovaskulárnych príčin</strong>; nemožno ho preto označiť iba ako súbor „obličkových príhod“.</li>
</ul>

<p>Tieto výsledky dokazujú prínos jednotlivých liekov v presne definovaných populáciách. Neznamenajú 18- až 39-percentný absolútny pokles rizika a nepreukazujú, že účinky všetkých tried sa pri spoločnom podaní jednoducho sčítajú.</p>

<h2>Úplná kombinácia: presvedčivá hypotéza, zatiaľ nie výsledková štúdia</h2>

<p>Pre súbežnú kombináciu RASi, inhibítora SGLT2, finerenónu a agonistu receptora GLP-1 zatiaľ nebola dokončená osobitná randomizovaná štúdia s dostatočným počtom zlyhaní obličiek, kardiovaskulárnych príhod a úmrtí. Prísne vzaté preto nepoznáme klinický účinok celej štvorpilierovej schémy ani to, či ide o aditívny účinok alebo o farmakologickú interakciu väčšiu než súčet jednotlivých účinkov. Pojem <em>synergia</em> by bol bez takéhoto dôkazu príliš silný.</p>

<p>Zdrojový editoriál cituje <a href="https://pubmed.ncbi.nlm.nih.gov/37952217/" target="_blank" rel="noopener noreferrer">modelovú analýzu údajov z viacerých štúdií</a>. Pre modelovaného 50-ročného pacienta s diabetom 2. typu a albuminúriou odhadla, že pridanie inhibítora SGLT2, agonistu receptora GLP-1 a finerenónu ku konvenčnej liečbe zahŕňajúcej RASi by mohlo predĺžiť obdobie bez obličkovej príhody o <strong>5,5 roka (95 % interval spoľahlivosti 4,0–6,7)</strong>. Model predpokladal aditívnosť účinkov a celoživotné zotrvanie na liečbe. Ide o potenciálny celoživotný zisk odvodený z modelu, nie o pozorovaný výsledok štvorliekovej randomizovanej štúdie. Odhad nemožno bez ďalšieho preniesť na starších pacientov, CKD bez albuminúrie, nediabetické príčiny CKD ani na človeka s krátkou očakávanou dĺžkou života.</p>

<h2>Komplementárna bezpečnosť: najmä otázka draslíka</h2>

<p>Blokáda RAS a mineralokortikoidového receptora môže zvyšovať sérový draslík. Inhibítory SGLT2 sa naopak v randomizovaných aj observačných analýzach spájali s nižším rizikom hyperkaliémie. Mechanizmus je pravdepodobne multifaktoriálny: inhibícia SGLT2 pôsobí v proximálnom tubule, prechodne zvyšuje natriurézu a dodávku sodíka do distálnejších úsekov nefrónu a ovplyvňuje aj glomerulovú hemodynamiku a objemový stav.</p>

<p>Malá krátkodobá skrížená štúdia <a href="https://pubmed.ncbi.nlm.nih.gov/35440501/" target="_blank" rel="noopener noreferrer">ROTATE-3</a> u 46 pacientov ukázala pri dapagliflozíne s eplerenónom väčší pokles UACR a menej epizód hyperkaliémie než pri samotnom eplerenóne. Podobným smerom ukázali analýzy programu FIDELITY a veľkých štúdií s inhibítormi SGLT2. V <a href="https://pubmed.ncbi.nlm.nih.gov/37876229/" target="_blank" rel="noopener noreferrer">spoločnej analýze CREDENCE a DAPA-CKD</a> bolo riziko dočasného alebo trvalého prerušenia RASi najmenej na štyri týždne pri inhibítore SGLT2 o 15 % nižšie než pri placebe (HR 0,85; 95 % IS 0,74–0,99). Observačné údaje z bežnej praxe tento signál podporujú, nemôžu však nahradiť randomizáciu.</p>

<p><strong>Riziko hyperkaliémie sa nezruší.</strong> Ani priaznivý populačný priemer nie je zárukou bezpečnosti u jednotlivca s nízkou eGFR, vysokou vstupnou kalémiou, interkurentným ochorením alebo súbežnými liekmi zvyšujúcimi draslík. Pri vrstvení liečby treba naďalej kontrolovať sérový draslík, eGFR, krvný tlak a objemový stav.</p>

<h2>CONFIDENCE: dôkaz pre albuminúriu, nie ešte pre zlyhanie obličiek</h2>

<p>Významný krok ku kombinačnej liečbe priniesla štúdia <a href="https://doi.org/10.1056/NEJMoa2410659" target="_blank" rel="noopener noreferrer">CONFIDENCE</a>. U dospelých s diabetom 2. typu, CKD, eGFR 30–90 mL/min/1,73 m² a UACR 100–5 000 mg/g porovnala súčasné začatie finerenónu s empagliflozínom s každou monoterapiou. Po 180 dňoch sa UACR pri kombinácii znížil oproti východiskovej hodnote približne o 52 %; relatívny pokles bol o 29 % väčší než pri finerenóne a o 32 % väčší než pri empagliflozíne.</p>

<p>Zdrojový editoriál na jednom mieste uvádza dapagliflozín a spomalenie poklesu eGFR. Presné znenie dôkazu je užšie: CONFIDENCE testovala <strong>empagliflozín</strong>, jej primárnym ukazovateľom bola zmena UACR v 180. deň a nebola výsledkovou štúdiou dlhodobej progresie CKD. Pokles albuminúrie je klinicky významný náhradný ukazovateľ, ale 52-percentný pokles UACR neznamená 52-percentné zníženie rizika dialýzy alebo úmrtia.</p>

<p>Krátkodobý bezpečnostný profil bol u starostlivo vybraných účastníkov prijateľný, hyperkaliémia sa však vyskytovala aj pri kombinácii. Podrobný rozbor štúdie ponúka samostatný článok <a href="https://nefro.polascin.net/article.php?slug=finerenon-empagliflozin-confidence-albuminuria-krvny-tlak">o finerenóne, empagliflozíne, albuminúrii a krvnom tlaku</a>.</p>

<h2>Nasadzovať postupne alebo súbežne?</h2>

<p>Tradičné dlhé čakanie medzi jednotlivými krokmi môže viesť k terapeutickej zotrvačnosti a ponechať pacienta vystaveného vysokému reziduálnemu riziku. Žiadne všeobecné pravidlo však neprikazuje čakať tri až šesť mesiacov po každom lieku a rovnako neexistuje dôkaz, že všetky štyri triedy treba začať v jeden deň.</p>

<p>Štúdia STRONG-HF ukázala prínos rýchleho zavádzania liečby po hospitalizácii pre akútne srdcové zlyhávanie. Pre nefrológiu je to zaujímavá <strong>implementačná analógia</strong>, nie priamy dôkaz účinnosti alebo bezpečnosti rýchlej štvorpilierovej liečby CKD. Bližší údaj poskytuje CONFIDENCE pre súčasné začatie dvoch liekov, stále však iba počas 180 dní a s albuminúriou ako primárnym ukazovateľom.</p>

<p><a href="https://doi.org/10.2337/dc26-S011" target="_blank" rel="noopener noreferrer">Štandardy ADA 2026</a> uvádzajú, že súčasné začatie inhibítora SGLT2 a finerenónu možno zvážiť u dospelých s diabetom 2. typu, UACR najmenej 100 mg/g, eGFR 30–90 mL/min/1,73 m² a liečbou RASi, a to na základe bezpečnosti a priaznivého vplyvu na albuminúriu. Formulácia „možno zvážiť“ nie je univerzálnym odporúčaním ani dôkazom dlhodobého výsledkového prínosu tejto dvojkombinácie.</p>

<p>Rozumným cieľom je <strong>včasné, ale individualizované vrstvenie</strong> indikovaných liekov. O poradí rozhodujú naliehavosť rizika, krvný tlak, eGFR, UACR, sérový draslík, objemový stav, diabetes, srdcové zlyhávanie, aterosklerotické kardiovaskulárne ochorenie, obezita, tolerancia, počet liekov, preferencie a ich dostupnosť.</p>

<h2>Počiatočný pokles eGFR nie je automaticky poškodenie obličiek</h2>

<p>Po začatí RASi, inhibítora SGLT2 alebo finerenónu sa môže objaviť mierny skorý hemodynamický pokles eGFR. Pri inhibítoroch SGLT2 sa po úvodnej zmene sklon eGFR zvyčajne zmierni; práve dlhodobé spomalenie straty funkcie tvorí podstatnú časť ich prínosu. Očakávaný farmakodynamický „pokles“ sám osebe nie je akútne poškodenie obličiek a nemal by automaticky viesť k vysadeniu účinnej liečby.</p>

<p>Pri súbežnom alebo rýchlom nasadení viacerých liekov sa však ich hemodynamické účinky môžu prekryť. Pokles eGFR väčší než približne 30 %, pretrvávajúce zhoršovanie, hypotenzia, ortostatické ťažkosti, interkurentné ochorenie alebo známky objemovej deplécie si vyžadujú klinické zhodnotenie príčiny. Kontrola približne v priebehu 1–4 týždňov – skôr pri vysokom riziku – má zahŕňať krvný tlak, symptómy, kreatinín/eGFR, draslík a objemový stav; presný interval sa riadi použitým liekom a rizikom pacienta.</p>

<h2>Nová informácia po publikovaní editorialu: FIND-CKD</h2>

<p>V čase online publikovania editorialu bola úloha finerenónu pri CKD bez diabetu otvorenou otázkou. Dňa 4. júna 2026 však boli online publikované výsledky štúdie <a href="https://doi.org/10.1056/NEJMoa2604625" target="_blank" rel="noopener noreferrer">FIND-CKD</a>. Zahŕňala 1 584 dospelých bez diabetu, s eGFR 25 až menej než 90 mL/min/1,73 m², UACR 200–3 500 mg/g a liečbou RASi.</p>

<p>Celkový ročný sklon eGFR bol −3,3 mL/min/1,73 m² pri finerenóne a −4,0 pri placebe; rozdiel predstavoval 0,7 mL/min/1,73 m² za rok (95 % IS 0,3–1,1; p &lt; 0,001). Zložený obličkovo-kardiovaskulárny ukazovateľ bol menej častý pri finerenóne (HR 0,77; 95 % IS 0,60–0,99), zatiaľ čo samotný zložený obličkový ukazovateľ mal HR 0,78 s 95 % IS 0,60–1,01. Hyperkaliémia sa vyskytla u 17,0 % pacientov pri finerenóne a u 13,3 % pri placebe; pre hyperkaliémiu liečbu ukončilo 1,5 % oproti 0,1 %.</p>

<p>FIND-CKD teda rozšírila dôkazy o finerenóne za hranice diabetu, najmä na albuminurickú nediabetickú CKD. Neznamená to však automatickú indikáciu pre každú nediabetickú CKD ani okamžitú zmenu registračných podmienok. KDIGO v marci 2026 oznámilo <a href="https://kdigo.org/kdigo-announces-update-to-2024-ckd-guideline/" target="_blank" rel="noopener noreferrer">cielenú aktualizáciu odporúčania CKD</a> pre inhibítory SGLT2, agonisty receptora GLP-1 a nsMRA pri CKD bez diabetu; jej výsledok treba odlíšiť od stále platného odporúčania z roku 2024.</p>

<h2>Čo môže prísť po dnešných pilieroch</h2>

<h3>Inhibícia aldosterónsyntázy</h3>

<p>Skúšaný inhibítor aldosterónsyntázy BI 690517, dnes označovaný ako <strong>vicadrostat</strong>, znížil v 14-týždňovej štúdii fázy 2 UACR oproti východiskovej hodnote približne o 22 % pri dávke 3 mg, o 39 % pri 10 mg a o 37 % pri 20 mg, oproti 3 % pri placebe. Podobný pokles sa pozoroval aj na pozadí empagliflozínu. Hyperkaliémia bola častejšia pri aktívnej liečbe a štúdia hodnotila albuminúriu, nie zlyhanie obličiek.</p>

<p>Prebiehajúca výsledková štúdia <a href="https://clinicaltrials.gov/study/NCT06531824" target="_blank" rel="noopener noreferrer">EASi-KIDNEY (NCT06531824)</a> porovnáva vicadrostat s placebom na pozadí empagliflozínu približne u 11 000 pacientov. Podľa verejných informácií bol v apríli 2026 randomizovaný 5 000. účastník a výsledky sa očakávajú v rokoch 2028–2029. Vicadrostat preto zatiaľ patrí medzi skúšané, nie etablované nefroprotektívne lieky.</p>

<h3>Endotelínový systém</h3>

<p>V 12-týždňovej štúdii fázy 2b ZENITH-CKD priniesla kombinácia zibotentanu s dapagliflozínom dodatočný pokles UACR oproti samotnému dapagliflozínu: o 27,0 % pri zibotentane 0,25 mg a o 33,7 % pri dávke 1,5 mg.</p>

<p>Retencia tekutín sa vyskytla približne u 8,8 % pacientov pri nízkej kombinovanej dávke, u 18,4 % pri vyššej dávke a u 7,9 % pri samotnom dapagliflozíne. Inhibítor SGLT2 teda mohol toto riziko zmierniť, ale neodstránil ho. Krátkodobý pokles UACR je sľubný; nepreukazuje dlhodobú ochranu pred zlyhaním obličiek a nerobí zo zibotentanu štandardnú liečbu CKD.</p>

<h2>Praktický rámec pre ambulanciu</h2>

<ol>
  <li><strong>Určiť fenotyp a príčinu CKD.</strong> Zdokumentovať eGFR, UACR, krvný tlak, draslík, objemový stav, diabetes, srdcové zlyhávanie, aterosklerotické ochorenie, obezitu a lieky; nezabudnúť na etiologickú diagnostiku a špecifickú liečbu.</li>
  <li><strong>Optimalizovať základ.</strong> Riešiť sodík, stravu, pohyb, fajčenie, hmotnosť, tlak, lipidy a glykémiu. RASi podať a titrovať iba tam, kde je indikovaný a tolerovaný; nekombinovať ACE inhibítor s ARB.</li>
  <li><strong>Neodkladať inhibítor SGLT2, ak je indikovaný.</strong> Jeho prínos presahuje kontrolu glykémie a zahŕňa aj mnohých pacientov bez diabetu.</li>
  <li><strong>Finerenón pridať podľa indikácie a rizika.</strong> Rozhodujú albuminúria, eGFR, draslík a základná blokáda RAS; po nasadení alebo úprave dávky treba laboratórnu kontrolu.</li>
  <li><strong>Liečbu založenú na GLP-1 vyberať podľa celého profilu.</strong> Uplatnenie neurčuje iba albuminúria, ale aj diabetes 2. typu, obezita, kontrola glykémie, kardiovaskulárne riziko, frailty a nutričný stav.</li>
  <li><strong>Tempo prispôsobiť pacientovi.</strong> Vysoké riziko môže hovoriť pre rýchlejšie vrstvenie; hypotenzia, hyperkaliémia, nestabilný objemový stav, polyfarmácia alebo krehkosť vyžadujú opatrnejší postup.</li>
  <li><strong>Vopred naplánovať monitorovanie a edukáciu.</strong> Pacient má vedieť, ktoré príznaky hlásiť a kedy dočasne prerušiť inhibítor SGLT2. Klinický tím má určiť termín kontroly tlaku, eGFR a draslíka ešte pri predpise.</li>
</ol>

<h2>Otvorené otázky a hranice implementácie</h2>

<ul>
  <li>Chýba výsledková randomizovaná štúdia celej štvorpilierovej kombinácie a priame porovnanie rýchleho so sekvenčným nasadzovaním.</li>
  <li>Populácie bez diabetu sú heterogénne; výsledok jednej albuminurickej štúdie nemožno preniesť na každú príčinu a každý stupeň CKD.</li>
  <li>Biomarkery by v budúcnosti mohli pomôcť vyberať kombinácie, ich klinická užitočnosť však potrebuje prospektívnu validáciu.</li>
  <li>Cena, úhrada, polyfarmácia, zdravotná gramotnosť a prístup k laboratórnym kontrolám môžu rozhodovať rovnako ako farmakológia.</li>
  <li>Koordinácia nefrológa, diabetológa, kardiológa, internistu a všeobecného lekára musí mať jasné rozdelenie zodpovednosti, aby sa predišlo duplicitám aj opomenutiam.</li>
</ul>

<h2>Záver</h2>

<p>Moderná liečba CKD už nestojí na ovplyvnení jedinej dráhy. Výsledkové štúdie podporujú RASi, inhibítory SGLT2, finerenón a semaglutid v presne vymedzených populáciách; priamy dôkaz pre súbežné nasadenie celej štvorpilierovej schémy však zostáva neúplný. Nie každý pacient potrebuje všetky štyri triedy a žiadna univerzálna schéma nenahrádza určenie príčiny CKD.</p>

<p>Komplementárne mechanizmy podporujú včasné, individualizované vrstvenie liečby s kontrolou krvného tlaku, eGFR, sérového draslíka a objemového stavu. Pokles albuminúrie pri nových kombináciách je sľubný, nemôže však nahradiť dôkaz o dlhodobom vplyve na zlyhanie obličiek, kardiovaskulárne príhody a mortalitu.</p>

<hr>

<p><em><strong>Hlavný zdroj – editoriál:</strong> He K, Guo Y, Yang C, Johnson DW, Su G. Trends in nephrology: from “supportive care” to CKD combination therapy. <em>Nephrology Dialysis Transplantation</em>. 2026;41(7):1180–1183. Prijaté 27. decembra 2025; publikované online 14. januára 2026. <a href="https://academic.oup.com/ndt/article/41/7/1180/8425349" target="_blank" rel="noopener noreferrer">Oxford Academic – zdrojový článok</a>. doi: <a href="https://doi.org/10.1093/ndt/gfag003" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfag003</a>. PMID 41533660: <a href="https://pubmed.ncbi.nlm.nih.gov/41533660/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://europepmc.org/article/MED/41533660" target="_blank" rel="noopener noreferrer">Europe PMC</a>. <a href="https://academic.oup.com/ndt/article-pdf/41/7/1180/66410994/gfag003.pdf" target="_blank" rel="noopener noreferrer">Oxford Academic – PDF</a>.</em></p>

<p><em><strong>Všetci autori zdrojového editoriálu:</strong> Kaiyu He; Yuanrong Guo; Changyuan Yang; David W. Johnson; Guobin Su.</em></p>

<p><em><strong>Financovanie a konflikty záujmov zdroja:</strong> Autori deklarovali, že nemajú konflikty záujmov. Guobin Su uviedol podporu z Research Fund for Bajian Talents of Guangdong Provincial Hospital of Chinese Medicine (BJ2022KY11), grantov Guangdong Provincial Hospital of Chinese Medicine (YN2024MB018, YN2024MS012, YN2020QN18 a YN2020QN24), grantov Karolinska Institutet (2020-01616 a 2022-02044), čínskeho National Science and Technology Major Project (2023ZD0505600 a 2023ZD0505604), Sanming Project of Medicine in Shenzhen (SZZYSM202206014), ERA-ERAC MSc in Clinical Trials Fellowship 2024, Guangzhou Basic and Applied Basic Research Foundation (2023A03J0235), State Key Laboratory of Traditional Chinese Medicine Syndrome (SKLKY2025B0008) a čiastočnú podporu Xusheng Liu Inherited Studio for Famous Doctor of Chinese Medicine. Podľa vyhlásenia nemali financovatelia úlohu pri príprave práce ani pri rozhodnutí o publikovaní.</em></p>

<p><em><strong>Vybrané doplňujúce zdroje použité pri vecnej aktualizácii:</strong> <a href="https://doi.org/10.1056/NEJMoa2604625" target="_blank" rel="noopener noreferrer">FIND-CKD – NEJM/DOI</a>, <a href="https://pubmed.ncbi.nlm.nih.gov/42246672/" target="_blank" rel="noopener noreferrer">FIND-CKD – PubMed</a>; <a href="https://doi.org/10.1056/NEJMoa2410659" target="_blank" rel="noopener noreferrer">CONFIDENCE – NEJM/DOI</a>, <a href="https://pubmed.ncbi.nlm.nih.gov/40470996/" target="_blank" rel="noopener noreferrer">CONFIDENCE – PubMed</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38109916/" target="_blank" rel="noopener noreferrer">vicadrostat – PubMed</a>, <a href="https://clinicaltrials.gov/study/NCT06531824" target="_blank" rel="noopener noreferrer">EASi-KIDNEY – ClinicalTrials.gov</a>, <a href="https://www.easikidney.org/" target="_blank" rel="noopener noreferrer">EASi-KIDNEY – študijný web</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37931629/" target="_blank" rel="noopener noreferrer">ZENITH-CKD – PubMed</a>, <a href="https://clinicaltrials.gov/study/NCT04724837" target="_blank" rel="noopener noreferrer">ZENITH-CKD – ClinicalTrials.gov</a>.</em></p>
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
