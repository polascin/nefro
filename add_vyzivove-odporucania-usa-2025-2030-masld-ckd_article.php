<?php
/**
 * Odborne a jazykovo revidovaný článok o interpretácii DGA 2025-2030
 * pri MASLD a chronickej chorobe obličiek.
 * Pôvodní autori spracovaného komentára sú uvedení v source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Americké výživové odporúčania 2025–2030: riziko nesprávnej interpretácie pri MASLD a CKD',
    'slug'         => 'vyzivove-odporucania-usa-2025-2030-masld-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Americké DGA odporúčajú 1,2–1,6 g bielkovín/kg/deň, no tento populačný cieľ nie je vhodný pre každého pacienta s CKD. Čo ukázala analýza NHANES a ako ju bezpečne čítať pri MASLD.',
    'content'      => <<<'HTML'
<p>Americké <em>Dietary Guidelines for Americans 2025–2030</em> (DGA), zverejnené v januári 2026, prinášajú zrozumiteľné populačné posolstvo: uprednostňovať nutrične hodnotné, málo spracované potraviny a obmedziť sladené nápoje, pridané cukry, nadbytok sodíka a ultraspracované výrobky. Dve časti dokumentu však vyžadujú v klinickej praxi osobitnú opatrnosť: cieľový príjem bielkovín 1,2–1,6 g/kg/deň a všeobecná formulácia „konzumujte menej alkoholu“ bez číselného limitu.</p>

<p>Pre pacienta s metabolicky asociovanou steatotickou chorobou pečene (MASLD), chronickou chorobou obličiek (CKD), cirhózou, dialyzačnou liečbou, krehkosťou alebo sarkopéniou nemožno tieto vety premeniť na univerzálny jedálny lístok. DGA sú americké populačné odporúčania, nie klinické usmernenie pre konkrétne ochorenie a už vôbec nie náhrada odporúčaní KDIGO, KDOQI alebo EASL.</p>

<h2>Čo DGA 2025–2030 skutočne uvádzajú</h2>

<p>Priama kontrola oficiálneho desaťstranového dokumentu potvrdzuje, že DGA:</p>

<ul>
  <li>odporúčajú cieľový príjem bielkovín <strong>1,2–1,6 g/kg telesnej hmotnosti denne</strong>, upravený podľa individuálnej energetickej potreby,</li>
  <li>uvádzajú rôzne živočíšne zdroje vrátane vajec, hydiny, rýb, morských plodov a červeného mäsa, ale aj fazuľu, hrach, šošovicu, ďalšie strukoviny, orechy, semená a sóju,</li>
  <li>odporúčajú zeleninu, ovocie a celozrnné potraviny,</li>
  <li>ponechávajú všeobecný limit nasýtených tukov pod 10 % denného energetického príjmu,</li>
  <li>odporúčajú osobám od 14 rokov prijímať menej než 2 300 mg sodíka denne,</li>
  <li>odporúčajú obmedziť alkohol slovami „konzumujte menej alkoholu pre lepšie celkové zdravie“, no pre všeobecnú populáciu už neuvádzajú predchádzajúce denné číselné limity.</li>
</ul>

<p>Tvrdenie, že nové DGA úplne vynechali rastlinné bielkoviny, ryby, zeleninu, ovocie alebo celozrnné potraviny, preto nie je vecne správne. Oprávnená kritika sa týka skôr <strong>hierarchie a dôrazu</strong>: vysoký číselný cieľ celkových bielkovín môže byť bez ďalšieho vysvetlenia pochopený ako výzva jesť viac mäsa. Samotný dokument však červené mäso neuprednostňuje pred všetkými ostatnými zdrojmi.</p>

<p>DGA zároveň výslovne upozorňujú, že ľudia s chronickým ochorením majú odporúčania prispôsobiť svojmu zdravotnému stavu spolu so zdravotníckym pracovníkom. Už primárny dokument teda nepodporuje mechanické prenesenie všeobecného bielkovinového cieľa na pacienta s CKD.</p>

<h2>Čo ukázala analýza NHANES z roku 2026</h2>

<p>Nicholas Dunn a spoluautori analyzovali 10 944 dospelých účastníkov amerického prieskumu NHANES 2017–2023. Údaje z 24-hodinového retrospektívneho zisťovania príjmu potravy spojili s výsledkami vibračne kontrolovanej prechodnej elastografie. Jednotlivé zložky stravy hodnotili pomocou komponentov <em>Healthy Eating Index 2020</em> a energeticky upravených štandardizovaných skóre zostavených podľa potravinových skupín relevantných pre DGA 2025–2030.</p>

<p>Vyšší príjem ovocia, zeleniny, listovej zeleniny a strukovín, celozrnných potravín a bielkovín z rýb, morských plodov a rastlinných zdrojov sa spájal s nižšou pravdepodobnosťou steatotickej choroby pečene alebo fibrózy. Vyšší príjem červeného a spracovaného mäsa, celkových bielkovín, sodíka, nasýtených tukov a pridaných cukrov sa spájal s vyššou prevalenciou niektorých pečeňových výsledkov. Skóre súladu s číselnými limitmi alkoholu zo starších DGA bolo takisto asociované s priaznivejšími výsledkami.</p>

<p><strong>Štúdia však netestovala zdravotný účinok nových DGA.</strong> Údaje o strave a pečeni boli zozbierané ešte pred zverejnením odporúčaní v januári 2026 a potravinové komponenty sa na nový rámec mapovali spätne. Výsledky preto nemôžu ukázať, že DGA spôsobujú poškodenie pečene ani že ich zavedenie zmení výskyt MASLD.</p>

<h2>Prečo z asociácie nemožno urobiť liečebný záver</h2>

<ul>
  <li><strong>Prierezový dizajn:</strong> expozícia a pečeňový nález sa hodnotili v rovnakom období, takže nemožno spoľahlivo určiť časovú následnosť.</li>
  <li><strong>Krátkodobé zisťovanie príjmu:</strong> 24-hodinové spätné vybavenie je zaťažené náhodnou variabilitou, nepresným odhadom porcií aj systematickým podhodnotením niektorých potravín a alkoholu.</li>
  <li><strong>Reziduálne skreslenie:</strong> výsledok môžu ovplyvňovať socioekonomické podmienky, pohyb, kvalita celej stravy, obezita, diabetes, lieky a ďalšie faktory, ktoré sa nedajú modelom úplne odstrániť.</li>
  <li><strong>Obrátená kauzalita:</strong> človek so známym ochorením pečene mohol stravu alebo konzumáciu alkoholu zmeniť ešte pred vyšetrením.</li>
  <li><strong>Neinvazívne ukazovatele:</strong> prechodná elastografia je klinicky užitočná, ale nenahrádza histologickú diagnózu a výsledok môžu meniť zápal, cholestáza alebo venózna kongescia.</li>
  <li><strong>SLD nie je automaticky MASLD:</strong> steatóza zistená v populačnej analýze bez úplného etiologického zhodnotenia sa nesmie bez ďalších kritérií označiť za MASLD.</li>
</ul>

<p>Formulácia, že „súlad s alkoholovým limitom bol protektívny“, je tiež nešťastná. Ide o štatistickú asociáciu skóre, nie o dôkaz ochranného účinku alkoholu. Výsledok rozhodne nie je dôvodom odporučiť abstinentovi, aby začal piť.</p>

<h2>Vecná kontrola kľúčových tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola tvrdení o amerických výživových odporúčaniach a analýze NHANES" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Verdikt</th>
      <th scope="col">Presná interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">DGA určujú cieľ 1,2–1,6 g bielkovín/kg/deň</th>
      <td>Potvrdené</td>
      <td>Je priamo uvedený v oficiálnom dokumente, nejde však o klinický cieľ pre každé chronické ochorenie.</td>
    </tr>
    <tr>
      <th scope="row">DGA odporúčajú iba alebo prednostne červené mäso</th>
      <td>Nepotvrdené</td>
      <td>Červené mäso je jedným z viacerých uvedených zdrojov; dokument menuje aj ryby, hydinu, vajcia a široké spektrum rastlinných zdrojov.</td>
    </tr>
    <tr>
      <th scope="row">DGA vynechali rastlinné bielkoviny, zeleninu a celozrnné potraviny</th>
      <td>Nesprávne</td>
      <td>Všetky tieto skupiny sú v dokumente výslovne uvedené. Diskutovať možno o miere ich zdôraznenia, nie o úplnom vynechaní.</td>
    </tr>
    <tr>
      <th scope="row">Nové DGA už neuvádzajú všeobecné denné číselné limity alkoholu</th>
      <td>Potvrdené</td>
      <td>Predchádzajúce DGA uvádzali najviac dva nápoje denne pre mužov a jeden pre ženy v deň konzumácie; nová verzia používa iba formuláciu „konzumujte menej“.</td>
    </tr>
    <tr>
      <th scope="row">Analýza dokázala, že nové DGA zvyšujú riziko fibrózy</th>
      <td>Nesprávne</td>
      <td>Ide o prierezové asociácie historických údajov spätne mapovaných na komponenty nového dokumentu.</td>
    </tr>
    <tr>
      <th scope="row">Cieľ DGA možno použiť pri CKD bez úpravy</th>
      <td>Nesprávne</td>
      <td>Pri CKD rozhodujú štádium, dialýza, metabolická stabilita, nutričný stav, sarkopénia a ďalšie ochorenia.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Najväčší konflikt pre nefrológa: množstvo bielkovín</h2>

<p>KDIGO 2024 odporúča u dospelých s CKD G3–G5, ktorí nie sú liečení dialýzou, udržiavať príjem približne 0,8 g/kg/deň a u osôb s rizikom progresie sa vyhýbať vysokému príjmu nad 1,3 g/kg/deň. Dolná hranica DGA 1,2 g/kg/deň sa teda približuje pásmu, ktoré už pri progresívnej CKD vyžaduje opatrnosť, a horná hranica 1,6 g/kg/deň ho jasne prekračuje.</p>

<p>To neznamená, že každý pacient s ochorením obličiek má dostať nízkobielkovinovú diétu. Pri dialýze sa potreba zvyšuje pre katabolizmus a straty aminokyselín; pri krehkosti, sarkopénii, akútnom ochorení alebo hojení rán môže mať ochrana svalovej hmoty prednosť pred prísnou reštrikciou. Pri cirhóze sa bielkoviny rutinne neobmedzujú a často sa odporúča 1,2–1,5 g/kg/deň. Súbeh pokročilej CKD a cirhózy preto vyžaduje spoločný plán nefrológa, hepatológa a nutričného terapeuta.</p>

<div class="table-responsive" role="region" aria-label="Orientačné ciele príjmu bielkovín v rôznych klinických situáciách" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Populácia alebo stav</th>
      <th scope="col">Orientačný príjem</th>
      <th scope="col">Klinická poznámka</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Všeobecná populácia podľa DGA 2025–2030</th>
      <td>1,2–1,6 g/kg/deň</td>
      <td>Populačný cieľ; pri chronickom ochorení ho treba prispôsobiť.</td>
    </tr>
    <tr>
      <th scope="row">Stabilná CKD G3–G5 bez dialýzy</th>
      <td>Približne 0,8 g/kg/deň</td>
      <td>KDIGO 2024; pri riziku progresie sa vyhýbať príjmu &gt;1,3 g/kg/deň.</td>
    </tr>
    <tr>
      <th scope="row">Krehkosť, sarkopénia alebo podvýživa pri CKD</th>
      <td>Individuálne, často vyšší cieľ</td>
      <td>Prioritou môže byť zachovanie svalovej hmoty a dostatočný energetický príjem.</td>
    </tr>
    <tr>
      <th scope="row">Udržiavacia hemodialýza alebo peritoneálna dialýza</th>
      <td>Približne 1,0–1,2 g/kg/deň</td>
      <td>KDOQI 2020 pre metabolicky stabilných dospelých; potreba môže stúpnuť pri zápale, peritonitíde alebo ranách.</td>
    </tr>
    <tr>
      <th scope="row">Cirhóza</th>
      <td>Spravidla 1,2–1,5 g/kg/deň</td>
      <td>Cieľom je predchádzať sarkopénii; pri súčasnej CKD treba oba protichodné ciele zosúladiť.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Číslo v g/kg navyše nemožno počítať vždy z aktuálnej hmotnosti. Výrazná obezita, ascites, edémy alebo amputácia môžu vyžadovať štandardnú, ideálnu či upravenú hmotnosť podľa použitého odporúčania. Dostatočný energetický príjem je nevyhnutný, inak sa časť prijatých bielkovín využije ako zdroj energie.</p>

<h2>Zdroj bielkovín a kvalita celej stravy</h2>

<p>KDIGO odporúča zdravý a pestrý model s vyšším zastúpením rastlinných než živočíšnych potravín a s nižším podielom ultraspracovaných výrobkov. Pri MASLD európske odporúčania podporujú stravu podobnú stredomorskému modelu, obmedzenie sladených nápojov, ultraspracovaných potravín, nasýtených tukov a červeného či spracovaného mäsa.</p>

<p>Pre nefrologického pacienta má zdroj bielkovín aj ďalší význam. Spracované mäso môže prinášať veľa sodíka a ľahko vstrebateľných fosfátových aditív. Rastlinné potraviny obsahujú vlákninu a fosfor s nižšou biologickou dostupnosťou, ale niektoré sú bohaté na draslík. Správnym riešením preto nie je paušálne zakázať strukoviny, ovocie či zeleninu, ale prispôsobiť výber laboratórnym hodnotám, liekom, acidobázickému stavu, zápche a celkovému jedálnemu lístku.</p>

<p>Aj limit sodíka treba preložiť správne: DGA určujú pre všeobecnú populáciu menej než 2 300 mg/deň, kým KDIGO pri CKD odporúča menej než 2 g sodíka denne, čo zodpovedá približne 5 g kuchynskej soli. Výnimkou môžu byť nefropatie so stratami sodíka a iné osobitné klinické situácie.</p>

<h2>Alkohol: neurčitý populačný slogan nestačí</h2>

<p>Staršie americké limity neboli cieľom ani zárukou bezpečnosti. Nová veta „konzumujte menej“ síce smeruje správnym smerom, ale pri klinickom rozhovore je príliš neurčitá. U každého pacienta so steatotickou chorobou pečene treba zaznamenať množstvo v gramoch alkoholu, frekvenciu, epizódy nárazového pitia a zmeny v čase.</p>

<p>EASL–EASD–EASO odporúčajú ľudí so SLD od alkoholu odrádzať; pri pokročilej fibróze alebo cirhóze je namieste úplná a trvalá abstinencia. Pri CKD treba zohľadniť aj krvný tlak, triglyceridy, glykemickú kontrolu, objemový stav, liekové interakcie, riziko pádov a transplantologický kontext. Chýbajúci číselný limit v DGA sa nesmie interpretovať ako povolenie bez hraníc.</p>

<h2>Praktický postup v nefrologickej ambulancii</h2>

<ol>
  <li><strong>Určiť klinický fenotyp:</strong> štádium CKD, rýchlosť progresie, albuminúriu, dialyzačnú modalitu, diabetes, MASLD, fibrózu alebo cirhózu.</li>
  <li><strong>Zhodnotiť výživu:</strong> hmotnostný trend, chuť do jedla, svalovú silu a hmotu, zápal, rany, gastrointestinálne ťažkosti a riziko proteínovo-energetického chradnutia.</li>
  <li><strong>Zmerať skutočný príjem:</strong> nepýtať sa iba na mäso, ale aj na mliečne výrobky, vajcia, strukoviny, výživové doplnky, proteínové nápoje, sodík, fosfátové aditíva a alkohol.</li>
  <li><strong>Stanoviť individuálny cieľ:</strong> zvoliť vhodnú referenčnú hmotnosť a zosúladiť renálnu prognózu s rizikom sarkopénie, dialyzačnými stratami a pečeňovým ochorením.</li>
  <li><strong>Uprednostniť kvalitu:</strong> budovať jedálny lístok z málo spracovaných rastlinných potravín, rýb a ďalších vhodných zdrojov; červené a najmä spracované mäso ponechať skôr ako menšiu časť než základ bielkovinového príjmu.</li>
  <li><strong>Monitorovať odpoveď:</strong> sledovať hmotnosť, funkčný stav, ureu, draslík, fosfor, bikarbonát, albuminúriu, krvný tlak a podľa stavu pečeňové a metabolické parametre.</li>
  <li><strong>Zapájať nutričného terapeuta:</strong> najmä pri CKD G4–G5, dialýze, cirhóze, sarkopénii, obezite alebo pri súbehu protichodných výživových cieľov.</li>
</ol>

<h2>Záver</h2>

<p>Americké DGA 2025–2030 majú užitočné jadro: menej ultraspracovaných potravín, sladených nápojov, pridaných cukrov a nadbytočného sodíka, viac nutrične hodnotných potravín. Ich bielkovinový cieľ 1,2–1,6 g/kg/deň však nemožno preniesť na stabilnú nedialyzovanú CKD bez klinickej úpravy a všeobecná výzva „konzumujte menej alkoholu“ nenahrádza konkrétne odporúčanie pri SLD, fibróze alebo cirhóze.</p>

<p>Analýza NHANES podporuje význam zdroja bielkovín a kvality celej stravy, ale zostáva prierezovou observačnou štúdiou. Nehodnotila dôsledky zavedenia nových DGA a nedokazuje kauzalitu. Najbezpečnejším klinickým prekladom preto nie je „viac bielkovín pre každého“, ale <strong>správne množstvo zo správnych zdrojov pre konkrétneho pacienta</strong>.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=masld-diagnostika-fibroza-nefrologicka-prax">Metabolicky asociovaná steatotická choroba pečene: diagnostika, hodnotenie fibrózy a význam pre nefrologickú prax</a></li>
  <li><a href="article.php?slug=vyssi-prijem-bielkovin-merana-gfr-renis">Vyšší príjem bielkovín a funkcia obličiek: desaťročná kohorta nezistila rýchlejší pokles meranej GFR</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Dunn W, Singal AK. New US Dietary Guidelines Get Big Picture Right but Misinterpret Critical Components for Liver Health. <em>Medscape</em>. Publikované 19. augusta 2026. <a href="https://www.medscape.com/viewarticle/new-us-dietary-guidelines-get-big-picture-right-misinterpret-2026a1000s6d" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></p>

<p><small><em><strong>Primárna observačná štúdia:</strong> Dunn N, Patel S, Díaz LA, Wong RJ, Arab JP, Zelber-Sagi S, Krag A, Younossi ZM, Singal AK. Dietary Guidelines 2025–2030 For Americans Are Concerning For Liver Health. <em>American Journal of Gastroenterology</em>. Publikované online 9. júla 2026. doi: 10.14309/ajg.0000000000004114. <a href="https://pubmed.ncbi.nlm.nih.gov/42424626/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://doi.org/10.14309/ajg.0000000000004114" target="_blank" rel="noopener noreferrer">DOI</a>.</em></small></p>

<p><small><em><strong>Populačné odporúčanie:</strong> U.S. Department of Health and Human Services; U.S. Department of Agriculture. <em>Dietary Guidelines for Americans, 2025–2030.</em> Január 2026. <a href="https://cdn.realfood.gov/DGA.pdf" target="_blank" rel="noopener noreferrer">Oficiálny dokument</a>. Porovnanie alkoholu: <a href="https://www.dietaryguidelines.gov/sites/default/files/2020-12/Dietary_Guidelines_for_Americans_2020-2025.pdf" target="_blank" rel="noopener noreferrer">DGA 2020–2025</a>.</em></small></p>

<p><small><em><strong>Nefrologické odporúčanie:</strong> Kidney Disease: Improving Global Outcomes CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney International</em>. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Výživa pri CKD a dialýze:</strong> Ikizler TA, Burrowes JD, Byham-Gray LD, et al. KDOQI Clinical Practice Guideline for Nutrition in CKD: 2020 Update. <em>American Journal of Kidney Diseases</em>. 2020;76(3 Suppl 1):S1–S107. doi: 10.1053/j.ajkd.2020.05.006. <a href="https://pubmed.ncbi.nlm.nih.gov/32829751/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Hepatologické odporúčanie:</strong> European Association for the Study of the Liver, European Association for the Study of Diabetes, European Association for the Study of Obesity. EASL–EASD–EASO Clinical Practice Guidelines on the management of metabolic dysfunction-associated steatotic liver disease (MASLD). <em>Journal of Hepatology</em>. 2024;81(3):492–542. doi: 10.1016/j.jhep.2024.04.031. <a href="https://pubmed.ncbi.nlm.nih.gov/38851997/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11299976/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazom a aktuálnosti:</strong> Znenie DGA, bibliografické údaje štúdie a aktuálne odporúčania KDIGO, KDOQI a EASL boli overené 22. augusta 2026. Uvedené číselné ciele sú orientačné rámce pre definované populácie, nie individuálny liečebný predpis.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vyzivove_odporucania_usa_2025_2030_masld_ckd',
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
