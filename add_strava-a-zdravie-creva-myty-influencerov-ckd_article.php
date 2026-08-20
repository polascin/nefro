<?php
/**
 * Odborny clanok: myty influencerov o strave a zdravi creva a co z nich plynie pre nefrologicku prax.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_strava-a-zdravie-creva-myty-influencerov-ckd_article.php"
 */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vlozit alebo aktualizovat clanok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Strava a zdravie čreva podľa influencerov: kde vznikajú najčastejšie chyby a čo z nich plynie pre nefrologickú prax',
    'slug'         => 'strava-a-zdravie-creva-myty-influencerov-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štyri opakujúce sa mýty o strave a čreve narážajú pri chronickej chorobe obličiek na tvrdé čísla: fitness prah 1,62 g bielkovín na kilogram leží nad stropom 1,3 g, ktorý KDIGO neodporúča prekračovať, a „čistenie čriev“ má doložené renálne riziko.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Tvrdenia influencerov o strave a „zdraví čreva“ bývajú presvedčivé preto, že majú pravdivé jadro — ktoré sa potom neprimerane zovšeobecní. Pri chronickej chorobe obličiek však tieto zovšeobecnenia narážajú na konkrétne čísla a konkrétne riziká. Tento článok prechádza štyri najčastejšie mýty a ukazuje, kde presne sa pri nefrologickom pacientovi lámu.</em></p>

<h2>Prečo sa tým má nefrológ zaoberať</h2>

<p>Pacienti prichádzajú s odporúčaniami zo sociálnych sietí častejšie než s odporúčaniami od dietológa. Štyri opakujúce sa témy — bielkoviny, detox, testy potravinovej citlivosti a hmotnosť — sa pritom dotýkajú presne tých oblastí, kde je pri chronickej chorobe obličiek (CKD) riziko vyššie než v bežnej populácii.</p>

<p>Cieľom nie je paušálne odmietnuť všetko, čo zaznie na internete. Väčšina týchto tvrdení má pravdivý základ. Problém vzniká pri prenose na pacienta, u ktorého platia iné hranice.</p>

<div class="pdf-avoid-break">
<h2>Mýtus 1: „Pri bielkovinách je viac vždy lepšie“</h2>

<h3>Čo hovoria dáta</h3>

<p>Metaanalýza Mortona a spol. spracovala 49 randomizovaných štúdií s 1 863 účastníkmi a použila analýzu bodu zlomu. Výsledok je jednoznačný: <strong>pri celkovom príjme nad približne 1,62 g bielkovín na kilogram telesnej hmotnosti denne už ďalšie zvyšovanie neprinášalo žiadny prírastok beztukovej hmoty</strong> pri silovom tréningu. Účinnosť suplementácie navyše klesala s vekom.</p>

<p>Novšia metaanalýza Nunesa a spol. (74 randomizovaných štúdií) tento obraz dopĺňa: zvýšenie príjmu bielkovín prináša pri silovom tréningu iba <em>malý</em> prírastok beztukovej hmoty (štandardizovaný rozdiel priemerov 0,22; 95 % IS 0,14 až 0,30). Účinok bol významný u osôb nad 65 rokov pri príjme 1,2 až 1,59 g/kg/deň a u mladších pri príjme nad 1,6 g/kg/deň.</p>

<p>Tvrdenie „viac je lepšie“ teda nie je nepravdivé — je <strong>ohraničené</strong>. A hranica je známa.</p>

<h3>Kde to naráža pri CKD</h3>

<p>Odporúčanie KDIGO 2024 pre chronickú chorobu obličiek uvádza:</p>

<div class="table-responsive" role="region" aria-label="Porovnanie fitness prahu a odporúčaní KDIGO pre príjem bielkovín" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kontext</th>
      <th scope="col">Príjem bielkovín</th>
      <th scope="col">Zdroj</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Prah, nad ktorým už nepribúda svalová hmota</th><td>≈ 1,62 g/kg/deň</td><td>Morton a spol. 2018</td></tr>
    <tr><th scope="row">Odporúčaný príjem pri CKD G3–G5 (bez dialýzy)</th><td>0,8 g/kg/deň</td><td>KDIGO 2024 (odporúčanie 2C)</td></tr>
    <tr><th scope="row">Hranica, ktorú netreba prekračovať pri riziku progresie</th><td>&gt; 1,3 g/kg/deň</td><td>KDIGO 2024 (praktický bod)</td></tr>
  </tbody>
</table>
</div>

<p>Kontrast je zreteľný: <strong>prah, pri ktorom sa vo fitness komunite prestáva oplácať ďalší proteín, leží nad hranicou, ktorú KDIGO pri riziku progresie neodporúča prekračovať.</strong> Pacient, ktorý sa riadi obsahom pre zdravých športovcov, sa teda môže úplne legitímne dostať do pásma, pred ktorým nefrologické odporúčanie varuje — bez toho, aby porušil čokoľvek z toho, čo počul.</p>

<p>Doplňme dve upozornenia, aby výklad nebol jednostranný. KDIGO neodporúča prísne nízkobielkovinové diéty plošne — veľmi nízky príjem (0,3 až 0,4 g/kg/deň s ketoanalógmi) prichádza do úvahy len pod dohľadom u vybraných pacientov s rizikom zlyhania obličiek, a u metabolicky nestabilných pacientov ani nízko-, ani veľmi nízkobielkovinovú diétu predpisovať netreba. U detí s CKD sa bielkoviny neobmedzujú vôbec pre riziko poruchy rastu. Pacienti na dialýze majú navyše iné, vyššie potreby než pacienti bez dialýzy.</p>

<p>Podrobnejšie sa proteínovým a kreatínovým doplnkom venuje samostatný článok uvedený v prehľade nižšie.</p>
</div>

<h2>Mýtus 2: „Detox a čistenie čriev odstránia toxíny a resetujú črevo“</h2>

<h3>Čo hovoria dáta</h3>

<p>Prehľad Mishoriovej a spol. hľadal doklady o prínose čistenia hrubého čreva a nenašiel <strong>žiadnu metodologicky spoľahlivú štúdiu</strong>, ktorá by túto prax podporovala. Naopak, zdokumentované poškodenia sú konkrétne: poruchy elektrolytov, sepsa, kolitída, perforácia rekta a úmrtia. V opísanom prepuknutí amébózy pripisovanom kolonickej irigácii v jedinom zariadení sa infikovalo najmenej 36 pacientov, 10 potrebovalo kolektómiu a šiesti zomreli.</p>

<p>Koncept „detoxifikácie“ je pritom medicínsky nepresný. Pečeň, obličky, pľúca, črevo a koža <em>sú</em> eliminačný systém a pracujú nepretržite. Krátkodobý úbytok hmotnosti po „detoxe“ sa vysvetľuje energetickým deficitom, zmenou obsahu čreva a stratou tekutín — nie odstránením toxínov.</p>

<div class="pdf-avoid-break">
<h3>Kde to naráža pri CKD — a jeden konkrétny renálny mechanizmus</h3>

<p>Poruchy elektrolytov a dehydratácia sú pri CKD závažnejšie a menej reverzibilné než u zdravého človeka. Existuje však aj priamy renálny mechanizmus s vlastným menom.</p>

<p><strong>Akútna fosfátová nefropatia</strong> je poškodenie obličiek s tubulárnymi depozitmi fosforečnanu vápenatého po prípravkoch na čistenie čriev obsahujúcich perorálny sodný fosfát. Markowitz a spol. opísali 21 takýchto pacientov, ktorí sa prezentovali akútnym zlyhaním obličiek pri normálnej kalcémii po vyčistení čreva perorálnym sodným fosfátom — a označili tento stav za <em>nedostatočne rozpoznávanú príčinu chronického zlyhania obličiek</em>.</p>

<p>To je zásadný rozdiel oproti bežnej predstave: nejde o teoretické riziko dehydratácie, ale o histologicky doloženú entitu, ktorá môže zanechať trvalé poškodenie. Pacientovi s CKD, ktorý uvažuje o „prečistení“ pomocou laxatívnych prípravkov neznámeho zloženia, treba toto povedať priamo.</p>
</div>

<h2>Mýtus 3: „IgG test ukáže, ktoré potraviny mi zapaľujú črevo“</h2>

<h3>Čo hovoria odborné spoločnosti</h3>

<p>Stanovisko Kanadskej spoločnosti pre alergiu a klinickú imunológiu (CSACI) k testovaniu potravinovo špecifických IgG je jednoznačne odmietavé — test sa neodporúča na diagnostiku potravinovej alergie ani intolerancie. Rovnaké stanovisko zastáva Americká akadémia alergie, astmy a imunológie.</p>

<p>Dôvod je imunologický: <strong>prítomnosť špecifických IgG proti potravine odráža expozíciu tejto potravine, nie patologickú reakciu na ňu.</strong> Vysoké IgG voči mlieku znamená predovšetkým to, že daný človek pije mlieko. Pozitívny výsledok tak nemá diagnostickú hodnotu, ale má reálne dôsledky — vedie k vylúčeniu často desiatok potravín.</p>

<h3>Kde to naráža pri CKD</h3>

<p>Neodôvodnené reštrikcie sú v tejto populácii obzvlášť rizikové. Pacient s CKD už spravidla obmedzuje fosfor, draslík a sodík; strava sa mu teda zužuje aj bez ďalších zákazov. Pridanie rozsiahleho zoznamu „zápalových“ potravín podľa IgG testu zvyšuje riziko nedostatočného príjmu energie a bielkovín, deficitu mikroživín a v konečnom dôsledku sarkopénie a krehkosti — teda presne toho, čo prognózu pri CKD zhoršuje.</p>

<p>Praktický postup: ak pacient príde s výsledkom IgG testu, nie je vhodné ho zosmiešniť. Užitočnejšie je vysvetliť, čo test v skutočnosti meria, a ponúknuť riadny postup — cielenú anamnézu, prípadne alergologické alebo gastroenterologické vyšetrenie, a pri podozrení na intoleranciu štruktúrovanú eliminačno-expozičnú skúšku pod dohľadom.</p>

<h2>Mýtus 4: „Nižšia hmotnosť je vždy zdravšia“</h2>

<h3>Čo je na tom nepresné</h3>

<p>BMI nerozlišuje tukovú a svalovú hmotu, nehovorí nič o rozložení tuku ani o funkčnom stave. Ako samostatný ukazovateľ zdravia je preto hrubý.</p>

<h3>Kde to naráža pri CKD</h3>

<p>V nefrologickej populácii je táto výhrada obzvlášť podstatná. Sarkopénia, krehkosť a zmeny telesného zloženia sú pri pokročilej CKD a na dialýze bežné. Pacient môže mať „normálne“ BMI a súčasne výrazne zníženú svalovú hmotu a silu. Riadiť sa iba hmotnosťou znamená prehliadnuť to, čo skutočne predpovedá výsledok.</p>

<p>Informatívnejšie sú:</p>

<ul>
  <li>funkčný stav — sila stisku ruky, chôdzová rýchlosť, test vstávania zo stoličky,</li>
  <li>nutričný stav vrátane príjmu energie a bielkovín,</li>
  <li>telesné zloženie tam, kde je dostupné,</li>
  <li>krvný tlak a metabolický profil,</li>
  <li>kvalita života a sebestačnosť.</li>
</ul>

<p>Osobitnú opatrnosť si vyžaduje neplánovaný úbytok hmotnosti u dialyzovaného pacienta — ten nie je úspechom, ale varovným znamením.</p>

<div class="pdf-avoid-break">
<h2>Vecná kontrola hlavných tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie tvrdení o strave a zdraví čreva" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Pri bielkovinách je viac vždy lepšie</td><td><strong>Ohraničene nepravdivé</strong></td><td>Nad ≈ 1,62 g/kg/deň už žiadny ďalší prírastok beztukovej hmoty (49 štúdií, 1 863 účastníkov)</td></tr>
    <tr><td>Bielkoviny sú pre svalovú hmotu dôležité</td><td><strong>Potvrdené, ale účinok je malý</strong></td><td>SMD 0,22 (95 % IS 0,14–0,30) pri silovom tréningu</td></tr>
    <tr><td>Odporúčania pre športovcov platia aj pri CKD</td><td><strong>Nie</strong></td><td>KDIGO 2024: 0,8 g/kg/deň pri G3–G5, neprekračovať 1,3 g/kg/deň pri riziku progresie</td></tr>
    <tr><td>Detox diéta odstráni toxíny a resetuje črevo</td><td><strong>Nepodložené</strong></td><td>Žiadna metodologicky spoľahlivá štúdia; eliminačné orgány pracujú nepretržite</td></tr>
    <tr><td>Čistenie čriev je neškodné</td><td><strong>Nepravdivé</strong></td><td>Doložené poruchy elektrolytov, sepsa, kolitída, perforácia, úmrtia; pri amébóze z irigácie ≥ 36 infikovaných, 10 kolektómií, 6 úmrtí</td></tr>
    <tr><td>Prípravky na čistenie čriev nemajú renálne riziko</td><td><strong>Nepravdivé</strong></td><td>Akútna fosfátová nefropatia po perorálnom sodnom fosfáte — 21 opísaných pacientov, možné trvalé poškodenie</td></tr>
    <tr><td>IgG test ukáže potraviny vyvolávajúce zápal</td><td><strong>Nepodložené na diagnostiku</strong></td><td>IgG odráža expozíciu, nie patologickú reakciu; CSACI aj AAAAI test neodporúčajú</td></tr>
    <tr><td>Nižšie BMI je automaticky zdravšie</td><td><strong>Zjednodušenie</strong></td><td>BMI nerozlišuje tuk od svalu ani nezachytáva funkciu; pri CKD je informatívnejší funkčný a nutričný stav</td></tr>
  </tbody>
</table>
</div>
</div>

<h2>Čo z toho vyplýva pre rozhovor s pacientom</h2>

<ol>
  <li><strong>Nezačínať odmietnutím.</strong> Každý zo štyroch mýtov má pravdivé jadro. Pacient, ktorý sa cíti zosmiešnený, sa nabudúce nespýta a poradí sa opäť na internete.</li>
  <li><strong>Pomenovať hranicu, nie zákaz.</strong> Pri bielkovinách funguje konkrétne číslo lepšie než všeobecné „menej“: existuje prah, nad ktorým prínos mizne, a pri CKD leží ešte nižšie.</li>
  <li><strong>Pri „detoxe“ hovoriť o mechanizme.</strong> Akútna fosfátová nefropatia je konkrétnejší argument než abstraktné „môže to uškodiť“.</li>
  <li><strong>Pri IgG teste vysvetliť, čo test meria.</strong> Nie „je to nezmysel“, ale „meria to, čo jete, nie to, čo vám škodí“.</li>
  <li><strong>Namiesto hmotnosti sledovať funkciu.</strong> Sila stisku ruky a chôdzová rýchlosť sú pri CKD výpovednejšie než číslo na váhe.</li>
  <li><strong>Pýtať sa aktívne na doplnky a kúry.</strong> Pacienti ich spontánne neuvádzajú, lebo ich nepovažujú za lieky.</li>
</ol>

<h2>Praktický záver</h2>

<p>Obsah influencerov o strave a zdraví čreva zvyčajne nestojí na výmysle, ale na neprimeranom zovšeobecnení pravdivého jadra. Pre nefrologickú prax je podstatné, že tieto zovšeobecnenia sa lámu presne tam, kde má pacient s CKD iné hranice než zdravý dospelý.</p>

<p>Konkrétne: fitness prah príjmu bielkovín leží nad stropom, ktorý KDIGO pri riziku progresie neodporúča prekračovať; „čistenie čriev“ má okrem chýbajúceho prínosu aj doloženú renálnu toxicitu; IgG testy vedú k reštrikciám, ktoré v tejto populácii hrozia sarkopéniou; a hmotnosť sama osebe nehovorí o funkčnom stave, na ktorom pri CKD záleží najviac.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=protein-kreatin-uz-nie-su-len-fitness-tema-nefrologia">Proteín a kreatín už nie sú výhradne „fitness téma“ a čo z toho plynie pre nefrológiu</a></li>
  <li><a href="article.php?slug=mierne-obmedzenie-bielkovin-ckd-prognoza">Mierne obmedzenie bielkovín môže pri chronickej chorobe obličiek zlepšiť prognózu</a></li>
  <li><a href="article.php?slug=vyssi-prijem-bielkovin-merana-gfr-renis">Vyšší príjem bielkovín a funkcia obličiek: desaťročná kohorta nezistila rýchlejší pokles meranej GFR</a></li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Frailty pri chronickej chorobe obličiek: prečo nestačí sledovať iba eGFR</a></li>
  <li><a href="article.php?slug=neceliakalna-citlivost-psenica-gluten-fruktany">Neceliakálna citlivosť na pšenicu: spúšťačom nemusí byť iba glutén</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Morton RW, Murphy KT, McKellar SR, Schoenfeld BJ, Henselmans M, Helms E, Aragon AA, Devries MC, Banfield L, Krieger JW, Phillips SM.</strong> <em>A systematic review, meta-analysis and meta-regression of the effect of protein supplementation on resistance training-induced gains in muscle mass and strength in healthy adults.</em> Br J Sports Med. 2018;52(6):376–384. doi: 10.1136/bjsports-2017-097608. Zdroj prahu 1,62 g/kg/deň. <a href="https://doi.org/10.1136/bjsports-2017-097608" target="_blank" rel="noopener noreferrer">Metaanalýza</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/28698222/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Nunes EA, Colenso-Semple L, McKellar SR, Yau T, Ali MU, Fitzpatrick-Lewis D, Sherifali D, Gaudichon C, Tomé D, Atherton PJ, Robles MC, Naranjo-Modad S, Braun M, Landi F, Phillips SM.</strong> <em>Systematic review and meta-analysis of protein intake to support muscle mass and function in healthy adults.</em> J Cachexia Sarcopenia Muscle. 2022;13(2):795–810. doi: 10.1002/jcsm.12922. <a href="https://doi.org/10.1002/jcsm.12922" target="_blank" rel="noopener noreferrer">Metaanalýza 74 štúdií</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/35187864/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. Zdroj odporúčania 0,8 g/kg/deň a praktického bodu o hranici 1,3 g/kg/deň. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>.</li>
  <li><strong>Mishori R, Otubu A, Jones AA.</strong> <em>The dangers of colon cleansing.</em> J Fam Pract. 2011;60(8):454–457. Prehľad dôkazov a poškodení pri čistení hrubého čreva. <a href="https://pubmed.ncbi.nlm.nih.gov/21814639/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Markowitz GS, Stokes MB, Radhakrishnan J, D'Agati VD.</strong> <em>Acute phosphate nephropathy following oral sodium phosphate bowel purgative: an underrecognized cause of chronic renal failure.</em> J Am Soc Nephrol. 2005;16(11):3389–3396. Séria 21 pacientov s akútnou fosfátovou nefropatiou. <a href="https://pubmed.ncbi.nlm.nih.gov/16192415/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Carr S, Chan E, Lavine E, Moote W.</strong> <em>CSACI Position statement on the testing of food-specific IgG.</em> Allergy Asthma Clin Immunol. 2012;8(1):12. doi: 10.1186/1710-1492-8-12. <a href="https://doi.org/10.1186/1710-1492-8-12" target="_blank" rel="noopener noreferrer">Stanovisko CSACI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/22835332/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>American Academy of Allergy, Asthma &amp; Immunology (AAAAI).</strong> <em>IgG food test.</em> Inštitucionálne autorstvo. <a href="https://www.aaaai.org/tools-for-the-public/conditions-library/allergies/igg-food-test" target="_blank" rel="noopener noreferrer">Stanovisko AAAAI</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>What Influencers Get Wrong About Diet and Gut Health.</em> Medscape, 2026. Sekundárny zdroj použitý ako východisko témy, nie ako dôkaz; ako autorka sa uvádza Charlotte Markey. <a href="https://www.medscape.com/viewarticle/what-influencers-get-wrong-about-diet-and-gut-health-2026a1000rxg" target="_blank" rel="noopener noreferrer">Spravodajské spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Prah 1,62 g/kg/deň, počet 49 štúdií a 1 863 účastníkov boli overené proti abstraktu v PubMed (PMID 28698222); údaje druhej metaanalýzy (74 štúdií, SMD 0,22; 95 % IS 0,14–0,30, pásma 1,2–1,59 a ≥ 1,6 g/kg/deň) proti PMID 35187864; séria 21 pacientov s akútnou fosfátovou nefropatiou proti PMID 16192415; stanovisko CSACI proti PMID 22835332. Odporúčanie 0,8 g/kg/deň (2C) a praktický bod o neprekračovaní 1,3 g/kg/deň pochádzajú z odporúčania KDIGO 2024 pre CKD. <strong>Oprava oproti pôvodnému podkladu:</strong> ako doklad o „čistení čriev“ bola v podklade uvedená práca Restelliniho a spol. (World J Gastroenterol 2017), tá sa však týka prípravy čreva pred kolonoskopiou pri nešpecifických zápaloch čreva, nie detoxových praktík — bola nahradená prehľadom Mishoriovej a spol. Autorstvo spravodajského spracovania Medscape sa pre obmedzený prístup nepodarilo nezávisle overiť a uvádza sa s výhradou.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Príjem bielkovín, obmedzenia stravy a nutričné intervencie pri chronickej chorobe obličiek treba stanoviť individuálne podľa štádia ochorenia, dialyzačnej liečby, nutričného stavu a rizika sarkopénie, v spolupráci s nutričným terapeutom a podľa platných odporúčaní. Uvedené prahy sú orientačné hodnoty z populačných štúdií a odporúčaní, nie predpis pre konkrétneho pacienta.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_strava-a-zdravie-creva-myty-influencerov-ckd_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "------------------------------------------------------\n";
    echo 'Migracia clanku: ' . $articles[0]['title'] . "\n";
    echo "------------------------------------------------------\n";
    echo "Vysledok: $inserted vlozenych, $updated aktualizovanych z $total clankov.\n";
    echo "Preskocenych (bez zmeny):      $skipped\n";
    echo "Zaradenych do fronty aviz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "------------------------------------------------------\n\n";
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
