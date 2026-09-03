<?php

/**
 * add_kolko-krokov-denne-staci-davkovo-odpovedova-analyza-nefrologia_article.php
 * Odborný článok: dávkovo-odpoveďová meta-analýza denných krokov (Lancet Public Health 2025)
 * a jej praktický význam v nefrológii.
 *
 * Pôvodní autori spracovanej práce sú uvedení v source_authors.php.
 * Overené cez PubMed eutils (PMID 40713949) a plný text práce.
 */

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
    'title'        => 'Koľko krokov denne naozaj stačí? Čo prináša najnovšia dávkovo-odpoveďová analýza a ako to uchopiť v nefrológii',
    'slug'         => 'kolko-krokov-denne-staci-davkovo-odpovedova-analyza-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Meta-analýza v The Lancet Public Health spája 7 000 krokov denne so zreteľne nižším rizikom úmrtia a kardiovaskulárnych príhod. Ide o asociačné údaje; v nefrológii však ponúkajú realistickejší cieľ než 10 000 krokov.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Cieľ 10 000 krokov denne je v praxi veľmi rozšírený, no nevznikol ako výsledok dávkovo-odpoveďového klinického dôkazu. Systematická analýza v <em>The Lancet Public Health</em> ukazuje, že zdravotné prínosy sa zreteľne prejavia už okolo 7 000 krokov denne a ďalej väčšinou nerastú lineárne. Ide o observačné asociácie, nie o priamy kauzálny dôkaz. Pre nefrológiu je to predovšetkým argument pre realistický a merateľný cieľ pohybovej aktivity.</em></p>

<p>V populárnej komunikácii sa 10 000 krokov denne často predkladá ako univerzálne minimum. Dôkaz pre takúto hranicu však nie je taký jednoznačný, ako sa uvádza. Autori najväčšej doterajšej syntézy prístrojovo meraných krokov ju označujú za <strong>neoficiálny cieľ bez jasného evidenčného základu</strong>. Ťažisko tohto článku preto nie je v histórii sloganu, ale v tom, čo dávkovo-odpoveďové údaje skutočne ukazujú — a čo z nich možno, a čo nemožno, preniesť k pacientovi s chronickou chorobou obličiek.</p>

<h2>Čo skúmala analýza v <em>The Lancet Public Health</em></h2>

<p>Ding a spolupracovníci syntetizovali prospektívne štúdie, v ktorých sa denné kroky merali zariadením (akcelerometer, krokomer, inteligentné hodinky) v bežnom živote, nie v laboratóriu. Do systematického prehľadu zaradili <strong>57 štúdií z 35 kohort</strong>; do meta-analýz vstúpilo <strong>31 štúdií z 24 kohort</strong>. Referenčnou hodnotou bolo <strong>2 000 krokov denne</strong>, teda dolná hranica bežného rozpätia u starších dospelých.</p>

<p>Na rozdiel od starších prehľadov, ktoré sa sústreďovali najmä na mortalitu a kardiovaskulárne ochorenia, táto práca hodnotila širšie spektrum ukazovateľov: úmrtie zo všetkých príčin, incidenciu a mortalitu kardiovaskulárnych ochorení, incidenciu a mortalitu nádorov, diabetes 2. typu, demenciu, depresívne príznaky, fyzickú funkciu a pády. Istota dôkazov sa hodnotila podľa GRADE. Protokol je registrovaný v PROSPERO (CRD42024529706).</p>

<p>Do meta-analýzy mortality zo všetkých príčin vstúpilo 161 176 účastníkov. Väčšina zaradených prác pochádzala z krajín s vysokým príjmom; 77 % štúdií použilo akcelerometer a 19 % krokomer.</p>

<h2>Hlavné výsledky: 7 000 oproti 2 000 krokom denne</h2>

<p>Porovnanie 7 000 voči 2 000 krokom denne nie je tvrdenie, že pod 7 000 je pohyb bezvýznamný. Je to syntetizovaný odhad relatívneho rizika voči nízkej, ale ešte merateľnej aktivite.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Zdravotné ukazovatele pri 7 000 krokoch denne v porovnaní s 2 000 krokmi denne" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">HR (95 % IS)</th>
        <th scope="col">Relatívne zníženie</th>
        <th scope="col">Štúdie</th>
        <th scope="col">Istota (GRADE)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Úmrtie zo všetkých príčin</th>
        <td>0,53 (0,46–0,60)</td>
        <td>47 %</td>
        <td>14</td>
        <td>stredná</td>
      </tr>
      <tr>
        <th scope="row">Incidencia kardiovaskulárnych ochorení</th>
        <td>0,75 (0,67–0,85)</td>
        <td>25 %</td>
        <td>6</td>
        <td>stredná</td>
      </tr>
      <tr>
        <th scope="row">Kardiovaskulárna mortalita</th>
        <td>0,53 (0,37–0,77)</td>
        <td>47 %</td>
        <td>3</td>
        <td>nízka</td>
      </tr>
      <tr>
        <th scope="row">Mortalita na nádory</th>
        <td>0,63 (0,55–0,72)</td>
        <td>37 %</td>
        <td>3</td>
        <td>stredná</td>
      </tr>
      <tr>
        <th scope="row">Incidencia nádorov</th>
        <td>0,94 (0,87–1,01)</td>
        <td>6 % (nesignifikantné)</td>
        <td>2</td>
        <td>nízka</td>
      </tr>
      <tr>
        <th scope="row">Diabetes 2. typu</th>
        <td>0,86 (0,74–0,99)</td>
        <td>14 %</td>
        <td>4</td>
        <td>stredná</td>
      </tr>
      <tr>
        <th scope="row">Demencia</th>
        <td>0,62 (0,53–0,73)</td>
        <td>38 %</td>
        <td>2</td>
        <td>stredná</td>
      </tr>
      <tr>
        <th scope="row">Depresívne príznaky</th>
        <td>0,78 (0,73–0,83)</td>
        <td>22 %</td>
        <td>3</td>
        <td>stredná</td>
      </tr>
      <tr>
        <th scope="row">Pády</th>
        <td>0,72 (0,65–0,81)</td>
        <td>28 %</td>
        <td>4</td>
        <td>veľmi nízka</td>
      </tr>
    </tbody>
  </table>
</div>

<p>HR je pomer rizík (hazard ratio) z náhodných dávkovo-odpoveďových modelov. Percentá sú prepočet z bodového odhadu HR a <strong>nie sú individuálnou prognózou</strong>. Heterogenita pri kardiovaskulárnej mortalite bola značná (I² = 78,2 %). Pri pádoch GRADE klesol na veľmi nízku úroveň pre nekonzistentné smery asociácie; po vynechaní jednej veľkej štúdie sa vzťah menil. Tento ukazovateľ preto v nefrologickej praxi nemožno predkladať ako spoľahlivý argument proti pádom.</p>

<h2>Vzťah nie je lineárny — a 7 000 nie je biologický strop</h2>

<p>Tvrdenie, že „po 7 000 krokoch sa benefit už nezvyšuje“, je zjednodušenie. Správnejšie je: <strong>vzťah je pri viacerých ukazovateľoch nelineárny a prírastok prínosu sa spravidla zmierňuje</strong>.</p>

<p>Inverzný nelineárny vzťah s inflexnými bodmi približne v pásme 5 000–7 000 krokov denne sa potvrdil pri mortalite zo všetkých príčin, incidencii kardiovaskulárnych ochorení, demencii a pádoch. Pri kardiovaskulárnej mortalite, incidencii a mortalite nádorov, diabete 2. typu a depresívnych príznakoch autori v abstrakte popisujú inverzný lineárny vzťah. Tvar krivky sa teda líši podľa ukazovateľa, veku aj typu zariadenia.</p>

<p>Aj po 7 000 krokoch riziko pri niektorých ukazovateľoch ďalej klesalo, no prírastok bol malý. Napríklad 10 000 krokov denne oproti 7 000 bolo spojených s približne <strong>10 % nižším rizikom úmrtia zo všetkých príčin</strong>. Pri kardiovaskulárnej mortalite, incidencii nádorov, diabete 2. typu a pádoch už rozdiel oproti 7 000 nebol štatisticky významný. Desaťtisíc krokov preto ostáva primeraným cieľom pre aktívnejších ľudí, nie však nutným minimom pre každého.</p>

<p>Rovnako dôležité je druhé rameno krivky. Už 4 000 krokov denne oproti 2 000 bolo spojených s približne <strong>36 % nižším rizikom úmrtia zo všetkých príčin</strong>. Posolstvo analýzy teda nie je „buď 7 000, alebo nič“, ale „každý bezpečne pridaný krok má význam, najmä pri nízkej východiskovej aktivite“.</p>

<h2>Ak pacient 7 000 krokov objektívne nezvládne</h2>

<p>V logike nelinearity aj v klinickej praxi je najlepšia stratégia začať od reálne nameranej východiskovej hodnoty, cieliť na postupné zvyšovanie a udržať konzistentnosť. Sedemtisíc krokov je orientačný verejnozdravotný cieľ, nie absolútne minimum a nie predpis tréningu.</p>

<p>Praktický postup v ambulancii môže byť takýto:</p>

<ol>
  <li>zistiť, koľko krokov pacient skutočne urobí — aspoň niekoľko dní merania, nie jednorazový odhad,</li>
  <li>odlíšiť nízku aktivitu od obmedzenia chorobou, bolesťou, anémiou, objemovým stavom alebo krehkosťou,</li>
  <li>stanoviť malý, merateľný prírastok (napríklad o 500–1 000 krokov denne) namiesto skoku na populačné maximum,</li>
  <li>kombinovať chôdzu so silovým a rovnovážnym cvičením, najmä pri riziku pádu,</li>
  <li>pri nových alarmujúcich príznakoch (bolesť na hrudníku, synkopa, neprimeraná dýchavica, nestabilita) záťaž prerušiť a stav prehodnotiť.</li>
</ol>

<p>Kroky nezachytia bicyklovanie, plávanie, veslovanie ani pohyb na vozíku. U pacienta s výrazným obmedzením mobility preto počet krokov nie je vhodnou jedinou metrikou. Cadencia (rýchlosť krokov) ako doplnkový ukazovateľ má podľa tej istej analýzy zatiaľ zmiešané a na odporúčanie nedostatočné dôkazy.</p>

<h2>Prečo je to relevantné v nefrológii</h2>

<p>Analýza Ding a spolupracovníkov <strong>nemá chronickú chorobu obličiek ako primárny ukazovateľ</strong>. Štúdie v špecifických populáciách s chronickým ochorením boli na samostatnú meta-analýzu príliš málo početné a heterogénne. Výsledky teda nemožno automaticky preniesť na dialyzovaného, krehkého alebo ťažko anémického pacienta. Dajú sa však použiť na nastavenie realistického cieľa v populácii s vysokým kardiovaskulárnym rizikom a častými pádmi — a to chronická choroba obličiek jednoznačne je.</p>

<p>KDIGO 2024 odporúča dospelým s chronickou chorobou obličiek aspoň <strong>150 minút stredne intenzívnej aktivity týždenne</strong>, alebo úroveň zlučiteľnú s kardiovaskulárnou a fyzickou toleranciou (odporúčanie 1D). Ľudí s chronickou chorobou obličiek treba zároveň nabádať, aby sa vyhýbali dlhému sedavému správaniu. Pri vyššom riziku pádu treba radu individualizovať podľa intenzity aj typu cvičenia. KDIGO neurčuje denný počet krokov; 7 000 krokov je preto doplnková, zrozumiteľná metrika, nie náhrada tohto odporúčania.</p>

<p>Reálna východisková hodnota v nefrológii je pritom podstatne nižšia ako populačný slogan. Meta-analýza 28 observačných štúdií (Zhang a kol.) odhadla priemerný denný počet krokov u pacientov s chronickou chorobou obličiek na <strong>približne 4 640</strong> (95 % IS 4 274–5 011), s veľkou heterogenitou. Podľa štádia:</p>

<ul>
  <li>predialýza približne 5 640 krokov denne,</li>
  <li>peritoneálna dialýza približne 4 260,</li>
  <li>hemodialýza približne 4 110; v dialyzačný deň približne 3 410, v nedialyzačný približne 4 200,</li>
  <li>po transplantácii obličky približne 8 690.</li>
</ul>

<p>Tieto čísla sú popisné priemery, nie ciele liečby. Ukazujú však, že pre väčšinu nefrologických pacientov je skok na 10 000 krokov denne nereálny, kým posun od 3 500 k 5 000 alebo od 5 000 k 7 000 môže byť dosiahnuteľný. Zhangova analýza je prierezová a silne heterogénna; neslúži ako dôkaz, že vyšší počet krokov spomalí pokles glomerulovej filtrácie.</p>

<p>Že nízka pohybová aktivita pri chronickej chorobe obličiek nie je kozmetický problém, naznačujú aj staršie populačné údaje. V NHANES III (Beddhu a kol.) bola neaktivita častejšia pri zníženej eGFR než bez nej (28,0 % oproti 13,5 %). V skupine s chronickou chorobou obličiek mali nedostatočne aktívni aj aktívni účastníci nižšie riziko úmrtia ako neaktívni (HR 0,58 a 0,44). Aj tu ide o observačnú asociáciu s dotazníkovým meraním aktivity, nie o randomizovaný tréningový protokol.</p>

<h2>Ako to uchopiť v nefrologickej ambulancii</h2>

<p>Kroky sú užitočné vtedy, keď slúžia ako spoločný, zrozumiteľný jazyk medzi lekárom a pacientom — nie ako ďalší laboratórny parameter, ktorý treba „normalizovať“.</p>

<ul>
  <li><strong>Predialýza:</strong> nízka aktivita sa objavuje už pred začiatkom náhrady funkcie obličiek. Tu má zmysel pýtať sa na chôdzu, meranie hodinkami alebo telefónom a postupný prírastok ešte pred poklesom funkčnej rezervy.</li>
  <li><strong>Hemodialýza:</strong> dialyzačný deň je spravidla chudobnejší na kroky. Reálnejší cieľ je často nedialyzačný deň, prípadne intradialyzačné bicyklovanie, ak to umožňuje hemodynamika, cievny prístup a krehkosť.</li>
  <li><strong>Peritoneálna dialýza:</strong> aktivita býva o niečo vyššia ako pri hemodialýze, ale stále hlboko pod populačným sloganom. Treba zohľadniť brušný diskomfort, hernie a záťaž katétra.</li>
  <li><strong>Po transplantácii:</strong> priemerné počty sa blížia k verejnozdravotnému pásmu 7 000–10 000. Aj tu však rozhoduje infekčné riziko, osteopénia, steroidná myopatia a kardiovaskulárna rezerva, nie samotné číslo na hodinkách.</li>
</ul>

<p>Nositeľné zariadenia môžu meranie uľahčiť, ale samy osebe starostlivosť nezlepšia. Bez dohody, čo sa má stať pri nízkej aktivite, ostane počet krokov izolovaným údajom v aplikácii.</p>

<h2>Limitácie, ktoré treba povedať nahlas</h2>

<ol>
  <li><strong>Observačný dizajn.</strong> Vyšší počet krokov je spojený s lepšími ukazovateľmi, ale kauzalitu z toho automaticky nevyplýva. Zdravší, zdatnejší a menej krehkí ľudia chodia viac. Reziduálne skreslenie a spätná kauzalita ostávajú, aj keď väčšina primárnych štúdií upravovala vek a zdravotný stav.</li>
  <li><strong>Nelinearita nie je tabulka pre jednotlivca.</strong> Sedemtisíc krokov je praktická verejnozdravotná hranica, nie biologická konštanta platná pre každého vek, pohlavie a komorbiditu. Analýza nemala vekovo špecifické ciele v sile, ktorá by stačila na osobitné odporúčanie pre starších.</li>
  <li><strong>Málo štúdií pri väčšine ukazovateľov.</strong> Robustnejší je odhad mortality zo všetkých príčin. Pri nádoroch, demencii, diabete a pádoch ide o exploratívne syntézy s malým počtom kohort.</li>
  <li><strong>Generalizácia.</strong> Dáta pochádzajú prevažne z krajín s vysokým príjmom a z výskumných zariadení nosených niekoľko dní. Nemusia sa zhodovať s dlhodobým záznamom spotrebiteľských hodiniek a nie sú to randomizované tréningové protokoly.</li>
  <li><strong>Chronická choroba obličiek nie je v syntéze samostatne vyriešená.</strong> Prenos do dialyzačnej a transplantačnej populácie je analogický, nie priamy.</li>
</ol>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Sedemtisíc krokov denne je v doteraz najširšej syntéze prístrojovo meranej chôdze spojených so štatisticky aj klinicky významným znížením rizika viacerých ukazovateľov v porovnaní s 2 000 krokmi. Po tomto bode vzťah spravidla nie je lineárny: ďalší prírastok ostáva možný, ale menší. Desaťtisíc krokov nie je vyvrátené — je však zbytočne vysokou latkou pre človeka, ktorý dnes urobí tri- až päťtisíc krokov.</p>

<p><strong>V nefrológii z toho vyplýva skromné, ale použiteľné posolstvo: merať východisko, pridávať postupne a nepovažovať nesplnenie sloganu za zlyhanie liečby.</strong> Pohyb dopĺňa kontrolu tlaku, nefroprotekciu, liečbu anémie a objemový manažment. Nenahrádza ich.</p>
</div>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=pohybova-aktivita-fibrilacia-predsieni-cmp-mortalita">Pohybová aktivita pri fibrilácii predsiení</a> — aj nízka aktivita a riziko cievnej mozgovej príhody.</li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Krehkosť pri CKD</a> — výživa, pohyb a funkčné hodnotenie.</li>
  <li><a href="article.php?slug=wearables-chronicke-ochorenia-protokoly-klinicky-zmysel">Wearables pri chronických ochoreniach</a> — meranie bez protokolu nestačí.</li>
  <li><a href="article.php?slug=wearables-dialyza-nefrologia-dokazy-a-limity">Wearables pri dialýze</a> — dôkazy a limity v nefrológii.</li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Ding D, Nguyen B, Nau T, Luo M, Del Pozo Cruz B, Dempsey PC, Munn Z, Jefferis BJ, Sherrington C, Calleja EA, Hau Chong K, Davis R, Francois ME, Tiedemann A, Biddle SJH, Okely A, Bauman A, Ekelund U, Clare P, Owen K.</strong> <em>Daily steps and health outcomes in adults: a systematic review and dose-response meta-analysis.</em> Lancet Public Health. 2025;10(8):e668–e681. doi: 10.1016/S2468-2667(25)00164-1. <a href="https://doi.org/10.1016/S2468-2667(25)00164-1" target="_blank" rel="noopener noreferrer">Plný text</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/40713949/" target="_blank" rel="noopener noreferrer">PubMed</a>. K práci vyšla korekcia: Lancet Public Health. 2025;10(9):e731. doi: 10.1016/S2468-2667(25)00199-9.</li>
  <li><strong>Zhang F, Ren Y, Wang H, Bai Y, Huang L.</strong> <em>Daily Step Counts in Patients With Chronic Kidney Disease: A Systematic Review and Meta-Analysis of Observational Studies.</em> Front Med (Lausanne). 2022;9:842645. doi: 10.3389/fmed.2022.842645. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8891233/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Beddhu S, Baird BC, Zitterkoph J, Neilson J, Greene T.</strong> <em>Physical Activity and Mortality in Chronic Kidney Disease (NHANES III).</em> Clin J Am Soc Nephrol. 2009;4(12):1901–1906. doi: 10.2215/CJN.04760709. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC2798872/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. Odporúčanie 3.2.2.1 a praktické body k pohybovej aktivite. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">KDIGO</a>.</li>
  <li><strong>World Health Organization.</strong> <em>WHO guidelines on physical activity and sedentary behaviour.</em> Geneva: WHO; 2020. <a href="https://www.who.int/publications/i/item/9789240015128" target="_blank" rel="noopener noreferrer">Odporúčania WHO</a>.</li>
  <li><strong>Stamatakis E, Ahmadi M, Murphy MH.</strong> <em>Journey of a thousand miles: from ‘Manpo-Kei’ to the first steps-based physical activity recommendations.</em> Br J Sports Med. 2023;57(19):1227–1228. doi: 10.1136/bjsports-2023-106869. <a href="https://doi.org/10.1136/bjsports-2023-106869" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Nextech.</strong> <em>Cieľ prejsť denne 10 000 krokov nevychádza z vedy. Toto je správna hranica.</em> Popularizačný článok, ktorý podnet spracovania priniesol; čísla a interpretácia v texte vychádzajú z primárnej meta-analýzy, nie z tohto zdroja. <a href="https://www.nextech.sk/a/Ciel-prejst-denne-10-000-krokov-nevychadza-z-vedy--Toto-je-spravna-hranica" target="_blank" rel="noopener noreferrer">Nextech</a>.</li>
</ol>

<p><em><strong>Poznámka k interpretácii:</strong> Článok sumarizuje observačné dávkovo-odpoveďové údaje a všeobecné odporúčania k pohybovej aktivite. Konkrétny plán chôdze a cvičenia treba prispôsobiť kardiovaskulárnej tolerancii, krehkosti, riziku pádu, anémii, objemovému stavu a štádiu chronickej choroby obličiek. Relatívne zníženie rizika nie je prísľubom individuálneho výsledku.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kolko-krokov-denne-staci-davkovo-odpovedova-analyza-nefrologia_article',
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
