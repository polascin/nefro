<?php
/**
 * Odborný článok: Obezita ako multifaktoriálne ochorenie, nástroj CheckCausesObesity.com a nefrologický kontext.
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
    'title'        => 'Obezita ako multifaktoriálne ochorenie: nový skríningový nástroj a jeho význam pre nefrologickú prax',
    'slug'         => 'obezita-multifaktorialne-ochorenie-skrining-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Digitálny nástroj CheckCausesObesity.com hodnotí viac než 30 možných prispievajúcich faktorov obezity v siedmich oblastiach. Z 62 809 používateľov holandskej verzie ich 91,2 % uviedlo faktory v dvoch a viacerých oblastiach.',
    'content'      => <<<'HTML'
<p>Obezita nie je výsledkom jedinej príčiny ani iba dôsledkom nedostatku pohybu a nadmerného príjmu energie. Je multifaktoriálnym chronickým ochorením, na ktorom sa podieľajú biologické, genetické, endokrinné, psychologické, sociálne, behaviorálne aj iatrogénne faktory. Bežná klinická prax sa napriek tomu často zastaví pri všeobecnej rade o strave a pohybe.</p>

<p>Tento pohľad má priamy význam aj v nefrológii. Obezita zvyšuje riziko hypertenzie, albuminúrie, glomerulárnej hyperfiltrácie, chronickej choroby obličiek (CKD), obličkových kameňov, obštrukčného spánkového apnoe a kardiovaskulárnych komplikácií. Súčasne môže komplikovať interpretáciu telesnej hmotnosti, svalovej hmoty aj renálnych parametrov.</p>

<p>V časopise <em>Nature Reviews Endocrinology</em> bol 1. septembra 2026 publikovaný opis digitálneho nástroja CheckCausesObesity.com, ktorý má systematicky vyhodnocovať viac než 30 možných prispievajúcich faktorov obezity v siedmich oblastiach. Ide o krátky opisný text predstavujúci nástroj, nie o pôvodnú výskumnú štúdiu s vlastnou metodickou sekciou — pri hodnotení sily dôkazov je tento rozdiel podstatný.</p>

<h2>Čo nástroj hodnotí</h2>

<p>Nástroj vytvoril multidisciplinárny tím endokrinológov, špecialistov na obezitu, všeobecných lekárov, psychológov a genetikov spolu s odborníkmi na behaviorálne zdravie a so zástupcami pacientov. Vznikol na Erasmus MC v Rotterdame.</p>

<div class="table-responsive" role="region" aria-label="Sedem hodnotených oblastí a ich obsah" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Oblasť</th>
      <th scope="col">Príklady hodnotených faktorov</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Životný štýl</th>
      <td>Stravovacie návyky, pohybová aktivita, spánok, alkohol</td>
    </tr>
    <tr>
      <th scope="row">Sociálne okolnosti</th>
      <td>Ekonomická situácia, pracovné podmienky, sociálna podpora</td>
    </tr>
    <tr>
      <th scope="row">Psychologické faktory</th>
      <td>Depresia, úzkosť, stres, poruchy príjmu potravy</td>
    </tr>
    <tr>
      <th scope="row">Liekmi podmienené faktory</th>
      <td>Liečivá podporujúce priberanie</td>
    </tr>
    <tr>
      <th scope="row">Endokrinné ochorenia</th>
      <td>Hypotyreóza, Cushingov syndróm, syndróm polycystických ovárií</td>
    </tr>
    <tr>
      <th scope="row">Poškodenie hypotalamu</th>
      <td>Nádor, operácia, ožiarenie, úraz</td>
    </tr>
    <tr>
      <th scope="row">Genetické faktory</th>
      <td>Monogénové a syndrómové formy, rodinná záťaž</td>
    </tr>
  </tbody>
</table>
</div>

<p>Súčasťou sú aj skríningové algoritmy pre vybrané komorbidity, prevzaté z existujúcich odporúčaní: STOP-Bang pre obštrukčné spánkové apnoe, kritériá NICE pre osteoartrózu, štandardizované psychiatrické kritériá pre záchvatové prejedanie, rotterdamské kritériá pre syndróm polycystických ovárií a AUDIT-C pre užívanie alkoholu.</p>

<p>Dotazník pacient vyplní doma približne za 25 minút. Výsledkom je zhrnutý report určený na diskusiu so zdravotníckym pracovníkom, nie na samostatné stanovenie diagnózy.</p>

<h2>Údaje z holandskej verzie nástroja</h2>

<p>Prvotná analýza vychádzala z údajov <strong>62 809 dospelých</strong>, ktorí vyplnili holandskú verziu nástroja (jeho predchodkyňu) a súhlasili s využitím údajov na výskumné účely.</p>

<ul>
  <li>medián veku 53 rokov,</li>
  <li>ženy 76,2 %,</li>
  <li>medián indexu telesnej hmotnosti (BMI) 33,1 kg/m<sup>2</sup>.</li>
</ul>

<p>Aspoň jeden prispievajúci faktor v <strong>dvoch alebo viacerých</strong> oblastiach uviedlo 91,2 % používateľov, v <strong>troch alebo viacerých</strong> oblastiach 68,3 %. Najčastejšou kombináciou boli faktory životného štýlu, psychologické faktory a faktory súvisiace s liekmi — vyskytla sa u 39,9 % používateľov.</p>

<p>Tieto čísla <strong>neopisujú prevalenciu príčin obezity v populácii</strong>. Ide o výsledky skupiny ľudí, ktorí sa nástroj rozhodli použiť; nešlo o náhodne vybranú populačnú vzorku. Údaj „91,2 %“ preto hovorí o tom, čo používatelia <em>uviedli</em>, nie o tom, čo ich obezitu spôsobilo.</p>

<h2>Význam pre pacientov s chronickou chorobou obličiek</h2>

<h3>Obezita a hyperfiltrácia</h3>

<p>Obezita mení renálnu hemodynamiku, zvyšuje intraglomerulový tlak a glomerulovú filtráciu. Dlhodobá hyperfiltrácia môže viesť k segmentálnej glomeruloskleróze a rozvoju obezitovej glomerulopatie, ktorú ako samostatnú, narastajúcu jednotku opísali Kambham a spolupracovníci už v roku 2001.</p>

<p>Typickým nálezom môže byť albuminúria alebo proteinúria, zväčšenie obličiek, glomerulová hyperfiltrácia v skoršom štádiu a neskorší pokles eGFR. Neprítomnosť výraznej albuminúrie však obezitou podmienené poškodenie obličiek nevylučuje.</p>

<h3>Arteriálna hypertenzia</h3>

<p>Obezita podporuje aktiváciu sympatikového nervového systému a systému renín-angiotenzín-aldosterón, retenciu sodíka a vznik obštrukčného spánkového apnoe. Výsledkom môže byť rezistentná hypertenzia a vyššie riziko progresie CKD.</p>

<p>Pri nefrologickom vyšetrení pacienta s obezitou je preto vhodné cielene hodnotiť domáce merania krvného tlaku, ortostatickú reakciu, adherenciu k liečbe, príjem sodíka, príznaky spánkového apnoe, užívanie nesteroidových antiflogistík a sekundárne príčiny hypertenzie.</p>

<h3>Lieky podporujúce priberanie</h3>

<p>Medzi potenciálne problematické liečivá patria niektoré glukokortikoidy, inzulín, sulfonylureové deriváty, viaceré antipsychotiká, antidepresíva a antiepileptiká.</p>

<p>U pacienta s CKD treba posudzovať nielen vplyv lieku na hmotnosť, ale aj renálnu elimináciu, riziko hypoglykémie, objemový stav, interakcie s antihypertenzívami a riziko akútneho poškodenia obličiek. <strong>Zmena liečby sa nesmie zakladať iba na priberaní.</strong> Vyžaduje posúdenie pomeru prínosu a rizika a podľa potreby konzultáciu s diabetológom, psychiatrom alebo iným predpisujúcim špecialistom.</p>

<h3>Obštrukčné spánkové apnoe</h3>

<p>Obštrukčné spánkové apnoe je pri obezite časté a môže prispievať k rezistentnej hypertenzii, nočnej hypoxémii, sympatikovej aktivácii, albuminúrii, dennej únave a vyššiemu kardiovaskulárnemu riziku.</p>

<p>Nástroj používa ako skríningový algoritmus STOP-Bang. Ten má vo validačných prácach vysokú citlivosť, ale nízku špecificitu, takže <strong>pozitívny výsledok nie je diagnózou</strong> — tú musí potvrdiť vyšetrenie spánku, najčastejšie polygrafia alebo polysomnografia. Naopak, jeho sila je práve v tom, že negatívny výsledok stredne ťažké až ťažké apnoe pomerne spoľahlivo vylúči.</p>

<h3>Psychologické faktory a záchvatové prejedanie</h3>

<p>Psychologické faktory ovplyvňujú príjem potravy, spánok, pohybovú aktivitu aj adherenciu k liečbe. Záchvatové prejedanie môže zostať nerozpoznané, najmä ak sa rozhovor s pacientom sústreďuje iba na kalorický príjem a pohyb.</p>

<p>Systematický skríning môže pomôcť identifikovať pacientov, ktorí potrebujú psychologické vyšetrenie, psychiatrickú intervenciu, behaviorálnu terapiu, liečbu porúch spánku alebo podporu pri zmene stravovacích návykov.</p>

<p>Významným prínosom môže byť aj <strong>zníženie stigmatizácie</strong>. Pacient nemá byť označovaný za „nedisciplinovaného“, ak sa na jeho stave podieľajú depresia, porucha príjmu potravy, liečba psychofarmakami, sociálna neistota alebo biologická predispozícia. Autori tento zámer uvádzajú výslovne: štruktúrované hodnotenie má podľa nich zmenšiť rozdiely v poskytovanej starostlivosti a znížiť sebaobviňovanie pacienta.</p>

<h2>Genetické a endokrinné príčiny</h2>

<p>Väčšina obezity nie je spôsobená jedinou monogénovou poruchou. Genetické faktory však môžu významne ovplyvňovať apetít, pocit sýtosti, energetický výdaj aj odpoveď na liečbu.</p>

<p>Na raritnú genetickú obezitu treba myslieť najmä pri veľmi skorom začiatku obezity, extrémnej hyperfágii, výraznej rodinnej záťaži, vývojových abnormalitách, hypogonadizme, neprimerane rýchlom náraste hmotnosti a syndrómových prejavoch.</p>

<p>Endokrinné príčiny, ako hypotyreóza, Cushingov syndróm alebo hypotalamické poškodenie, sú menej časté, ale klinicky dôležité. Ich vyšetrenie má byť cielené podľa klinického obrazu, nie plošné a nekritické.</p>

<h2>Obmedzenia nástroja a dostupných údajov</h2>

<p>Publikovaný text obmedzenia neuvádza. Nasledujúce body sú preto odborným zhodnotením, nie prevzatím zo zdroja.</p>

<h3>Nejde o dôkaz kauzality</h3>

<p>Nástroj identifikuje faktory spojené s obezitou alebo priberaním. Výsledok nepreukazuje, že konkrétny faktor je príčinou, ani že jeho odstránenie povedie k redukcii hmotnosti. Presnejšie je hovoriť o <em>prispievajúcich faktoroch</em> než o príčinách — čo napokon zodpovedá aj názvu nástroja lepšie než jeho doslovný preklad.</p>

<h3>Výberové skreslenie</h3>

<p>Používatelia nástroja nepredstavujú náhodnú vzorku populácie. Pravdepodobne ide o ľudí, ktorí majú záujem riešiť svoju hmotnosť, majú prístup na internet, zvládnu vyplniť rozsiahly dotazník a sú ochotní poskytnúť údaje na výskum. Výrazná prevaha žien (76,2 %) tomu zodpovedá. Výsledky preto nemožno priamo prenášať na všetkých pacientov s obezitou, na osoby s nízkou zdravotnou gramotnosťou ani na dialyzovaných pacientov.</p>

<h3>Sebahodnotenie údajov</h3>

<p>Časť odpovedí je subjektívna a môže byť ovplyvnená pamäťou, sociálne žiaducimi odpoveďami, stigmatizáciou, psychickým stavom aj porozumením otázkam. Údaje o liekoch, alkohole, poruchách príjmu potravy a psychických ťažkostiach si vyžadujú klinické overenie.</p>

<h3>Skríning nie je diagnóza</h3>

<p>Pozitívny výsledok pre hypotyreózu, spánkové apnoe, depresiu, záchvatové prejedanie alebo genetickú obezitu má viesť k ďalšiemu vyšetreniu, nie k automatickému stanoveniu diagnózy. Pri sedemoblastnom hodnotení s desiatkami položiek navyše rastie pravdepodobnosť falošne pozitívnych nálezov, takže bez klinického filtra hrozí zbytočná diagnostika.</p>

<h3>Chýba dôkaz o zlepšení klinických výsledkov</h3>

<p>Doterajšie údaje ukazujú, že nástroj identifikuje viacero faktorov. Nie je však preukázané, či jeho používanie vedie k väčšiemu poklesu hmotnosti, zlepšeniu krvného tlaku, zníženiu albuminúrie, pomalšiemu poklesu eGFR, nižšej mortalite alebo lepšej kvalite života. Na potvrdenie klinickej užitočnosti by boli potrebné prospektívne intervenčné štúdie.</p>

<h3>Deklarované záujmy</h3>

<p>Podľa sekundárneho spracovania niektorí autori uviedli pôsobenie ako hlavní skúšajúci v klinických skúšaniach a prijatie honorárov, prednáškových odmien, úhrad účasti na podujatiach alebo licenčných poplatkov od farmaceutických spoločností a organizácií. Pri hodnotení textu, ktorý predstavuje vlastný nástroj, je táto informácia relevantná.</p>

<h2>Osobitosti pri pokročilej chronickej chorobe obličiek</h2>

<p>Pri pokročilej CKD nemožno účinok redukcie hmotnosti hodnotiť iba podľa BMI. Telesná hmotnosť je ovplyvnená retenciou tekutín, úbytkom svalovej hmoty, zápalom, proteínovo-energetickou malnutríciou, dialyzačnou liečbou a zmenami hydratácie. Konferencia KDIGO Controversies venovaná vzťahu obezity a CKD na tieto úskalia merania a manažmentu upozorňuje samostatne.</p>

<p>U dialyzovaných pacientov býva vhodnejšie sledovať kombináciu trendu suchej hmotnosti, obvodu pása, nutričného stavu, svalovej sily, funkčnej kapacity, albumínu a ďalších klinických ukazovateľov.</p>

<p>Príliš agresívna redukcia hmotnosti môže byť škodlivá u pacientov s krehkosťou, sarkopéniou alebo nedostatočným príjmom bielkovín. Intervencia musí byť individualizovaná a koordinovaná s nefrológom, dietológom a podľa potreby obezitológom.</p>

<h2>Praktický postup pre nefrológa</h2>

<ol>
  <li>Potvrdiť rozsah a časový priebeh priberania.</li>
  <li>Posúdiť hydratáciu a vylúčiť nadhodnotenie hmotnosti retenciou tekutín.</li>
  <li>Zhodnotiť krvný tlak, albuminúriu a trend eGFR.</li>
  <li>Prehodnotiť lieky podporujúce priberanie, so zohľadnením ich indikácie a renálnej bezpečnosti.</li>
  <li>Cielene pátrať po spánkovom apnoe a pozitívny skríning potvrdiť vyšetrením spánku.</li>
  <li>Vyhodnotiť psychické ťažkosti a záchvatové prejedanie.</li>
  <li>Indikovať endokrinné alebo genetické vyšetrenie podľa klinických znakov, nie plošne.</li>
  <li>Stanoviť realistický a bezpečný cieľ redukcie hmotnosti.</li>
  <li>Zvoliť intervenciu podľa komorbidít a funkcie obličiek.</li>
  <li>Pravidelne hodnotiť účinnosť aj nežiaduce účinky liečby.</li>
</ol>

<p>Farmakologická liečba obezity vrátane agonistov receptora GLP-1 alebo kombinovaných inkretínových liečiv môže byť u vybraných pacientov relevantná. Jej použitie však musí zohľadňovať aktuálne indikácie, funkciu obličiek, toleranciu, riziko dehydratácie a hypovolemického poškodenia obličiek pri gastrointestinálnych nežiaducich účinkoch, ako aj miestne regulačné a úhradové podmienky.</p>

<h2>Záver</h2>

<p>CheckCausesObesity.com je praktický pokus systematizovať vyšetrenie obezity ako komplexného ochorenia. Údaje z holandskej verzie ukázali, že veľká väčšina používateľov uvádzala prispievajúce faktory vo viacerých oblastiach naraz — najčastejšie kombináciu životného štýlu, psychologických okolností a liekov.</p>

<p>Pre nefrologickú prax je najcennejší samotný multidimenzionálny prístup. Pri pacientovi s obezitou nestačí odporúčanie znížiť kalorický príjem a zvýšiť pohyb. Treba posúdiť krvný tlak, albuminúriu, spánkové apnoe, psychické faktory, lieky, sociálne podmienky, hydratáciu aj riziko sarkopénie.</p>

<p>Nástroj môže pomôcť štruktúrovať rozhovor a znížiť stigmatizáciu. Zatiaľ však nemožno tvrdiť, že jeho používanie zlepšuje renálne alebo kardiovaskulárne výsledky, a každý pozitívny skríningový nález musí byť overený klinickým vyšetrením.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=obezita-v-nefrologii-skrining-manazment-dialyza-transplantacia">Obezita v nefrológii: skríning, manažment a vplyv na dialýzu a transplantáciu</a></li>
  <li><a href="article.php?slug=tukove-tkanivo-obezita-kardiorenalne-riziko-biologia">Tukové tkanivo nie je pasívna zásobáreň: čo jeho biológia hovorí o obezite a kardiorenálnom riziku</a></li>
  <li><a href="article.php?slug=glp1-era-novy-model-starostlivosti-o-obezitu-nefrologia">Éra GLP-1 si žiada nový model starostlivosti o obezitu (a čo z toho plynie pre nefrológiu)</a></li>
  <li><a href="article.php?slug=farmakologicka-liecba-obezity-pokrocile-ckd-dialyza">Farmakologická liečba obezity u pacientov s pokročilým CKD a na dialýze</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>van Rossum EFC, Boon MR, Meeusen REH, Terwee CB, Boor AJ, van den Akker ELT. CheckCausesObesity.com: a screening and monitoring tool for obesity. Nature Reviews Endocrinology. Publikované online 1. septembra 2026. doi: 10.1038/s41574-026-01300-6. PMID 42680831. <a href="https://pubmed.ncbi.nlm.nih.gov/42680831/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.nature.com/articles/s41574-026-01300-6" target="_blank" rel="noopener noreferrer">vydavateľská stránka</a>. Hlavný spracovaný zdroj.</em></small></li>
  <li><small><em>van der Valk ES, van den Akker ELT, Savas M, Kleinendorst L, Visser JA, Van Haelst MM, Sharma AM, van Rossum EFC. A comprehensive diagnostic approach to detect underlying causes of obesity in adults. Obesity Reviews. 2019;20(6):795–804. doi: 10.1111/obr.12836. PMID 30821060. <a href="https://pubmed.ncbi.nlm.nih.gov/30821060/" target="_blank" rel="noopener noreferrer">PubMed</a>. Koncepčná predchodkyňa nástroja.</em></small></li>
  <li><small><em>Furth SL, Colhoun HM, Kanbay M, Kukla A, Lim LL, a spol. The relationship between obesity and chronic kidney disease: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference. Kidney International. 2026;109(3):442–464. doi: 10.1016/j.kint.2025.09.019. PMID 41176308. <a href="https://pubmed.ncbi.nlm.nih.gov/41176308/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Yau K, Kuah R, Cherney DZI, Lam TKT. Obesity and the kidney: mechanistic links and therapeutic advances. Nature Reviews Endocrinology. 2024;20(6):321–335. doi: 10.1038/s41574-024-00951-7. PMID 38351406. <a href="https://pubmed.ncbi.nlm.nih.gov/38351406/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Kambham N, Markowitz GS, Valeri AM, Lin J, D'Agati VD. Obesity-related glomerulopathy: an emerging epidemic. Kidney International. 2001;59(4):1498–1509. doi: 10.1046/j.1523-1755.2001.0590041498.x. PMID 11260414. <a href="https://pubmed.ncbi.nlm.nih.gov/11260414/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Nagappa M, Liao P, Wong J, Auckley D, Ramachandran SK, Memtsoudis S, Mokhlesi B, Chung F. Validation of the STOP-Bang Questionnaire as a Screening Tool for Obstructive Sleep Apnea among Different Populations: A Systematic Review and Meta-Analysis. PLoS One. 2015;10(12):e0143697. doi: 10.1371/journal.pone.0143697. PMID 26658438. <a href="https://pubmed.ncbi.nlm.nih.gov/26658438/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney International. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. PMID 38490803. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>CheckCausesObesity.com — verejná stránka nástroja a <a href="https://www.checkcausesobesity.com/for-health-care-professionals/" target="_blank" rel="noopener noreferrer">sekcia pre zdravotníckych pracovníkov</a>. <a href="https://www.checkcausesobesity.com/" target="_blank" rel="noopener noreferrer">checkcausesobesity.com</a>.</em></small></li>
  <li><small><em>New Tool Helps Clinicians Screen for Obesity's Causes. Medscape Medical News, 3. septembra 2026 (redakčné spracovanie primárneho textu). <a href="https://www.medscape.com/viewarticle/new-tool-screens-30-contributors-obesity-adults-2026a1000wr0" target="_blank" rel="noopener noreferrer">Medscape</a>. Zdroj číselných údajov z holandskej verzie nástroja a informácie o deklarovaných záujmoch autorov.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_obezita-multifaktorialne-ochorenie-skrining-nefrologia_article',
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
