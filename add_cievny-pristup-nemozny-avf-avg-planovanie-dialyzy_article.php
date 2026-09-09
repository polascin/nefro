<?php
/**
 * Odborný článok: Pacienti nevhodní na arteriovenózny cievny prístup — klinické dôsledky a plánovanie liečby.
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
    'title'        => 'Keď arteriovenózny cievny prístup nie je možný: negatívne chirurgické odporúčanie ako prognostický marker',
    'slug'         => 'cievny-pristup-nemozny-avf-avg-planovanie-dialyzy',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Zo 647 pacientov posúdených tímom pre cievne prístupy dostalo 40 (6,2 %) negatívne odporúčanie. Deväť z desiatich začalo hemodialýzu neplánovane a 43 % pacientov počas sledovania zomrelo.',
    'content'      => <<<'HTML'
<p>Arteriovenózna fistula (AVF) a arteriovenózny graft (AVG) sú preferovanými formami cievneho prístupu pri hemodialýze. Nie u každého pacienta s pokročilou chronickou chorobou obličiek (CKD) ich však možno vytvoriť. Dôvodom býva vyčerpanie vhodného cievneho riečiska, centrálna venózna stenóza alebo oklúzia, opakované zlyhanie predchádzajúcich prístupov, závažné kardiovaskulárne ochorenie, vysoké operačné riziko alebo celkový stav pacienta.</p>

<p>Retrospektívna kohortová štúdia z portugalskej nemocnice Unidade Local de Saúde de São João v Porte, publikovaná v časopise <em>Hemodialysis International</em>, sledovala, ako sa vyvinul stav pacientov, ktorým multidisciplinárny tím pre cievne prístupy <strong>neodporučil</strong> vytvorenie autológnej ani protetickej arteriovenóznej spojky.</p>

<p>Zistenie je jednoznačné: negatívne chirurgické odporúčanie označuje skupinu s vysokým rizikom neplánovaného začatia hemodialýzy, dlhodobej expozície dialyzačnému katétru a úmrtia. Nejde teda len o technický problém cievnej chirurgie, ale o prognostický marker.</p>

<h2>Usporiadanie štúdie</h2>

<p>Autori retrospektívne analyzovali všetkých pacientov posúdených multidisciplinárnym tímom pre cievne prístupy od januára 2022 do decembra 2024, ktorí dostali negatívne chirurgické odporúčanie. Pacientov rozdelili podľa toho, či v čase posúdenia už dostávali náhradu funkcie obličiek, alebo nie.</p>

<div class="table-responsive" role="region" aria-label="Zloženie súboru pacientov s negatívnym chirurgickým odporúčaním" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Počet</th>
      <th scope="col">Podiel</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Posúdení pacienti celkovo</th>
      <td>647</td>
      <td>—</td>
    </tr>
    <tr>
      <th scope="row">Negatívne chirurgické odporúčanie</th>
      <td>40</td>
      <td>6,2 %</td>
    </tr>
    <tr>
      <th scope="row">Z toho: predialyzačné CKD G4 – G5</th>
      <td>20</td>
      <td>50 %</td>
    </tr>
    <tr>
      <th scope="row">Z toho: už na náhrade funkcie obličiek</th>
      <td>20</td>
      <td>50 %</td>
    </tr>
    <tr>
      <th scope="row">Dôvod: vyčerpanie cievneho riečiska</th>
      <td>23</td>
      <td>57,5 %</td>
    </tr>
    <tr>
      <th scope="row">Dôvod: kontraindikácia pre komorbidity</th>
      <td>17</td>
      <td>42,5 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Analýza bola opisná. Štúdia preto neposkytuje dôkaz o rozdieloch medzi liečebnými stratégiami ani o účinnosti konkrétnej intervencie.</p>

<p>Podiel 6,2 % treba čítať v správnom kontexte: menovateľom sú pacienti <em>odoslaní na posúdenie tímom pre cievne prístupy</em>, nie všetci pacienti s pokročilou CKD. Nemožnosť vytvoriť arteriovenózny prístup je teda v tejto vybranej populácii nie častým, ale ani zanedbateľným javom.</p>

<h2>Pacienti pred začatím dialýzy</h2>

<p>Z 20 pacientov s pokročilou CKD, ktorí v čase posúdenia ešte neboli liečení náhradou funkcie obličiek, ju neskôr začalo <strong>11 (55 %)</strong>: desať hemodialýzou a jeden peritoneálnou dialýzou.</p>

<p>Rozhodujúci je však spôsob, akým sa liečba začala. U <strong>deviatich z desiatich pacientov (90 %)</strong>, ktorí ako prvú modalitu začali hemodialýzu, išlo o <strong>neplánované začatie</strong> — najčastejšie pre akútny kardiorenálny alebo koronárny syndróm.</p>

<p>Klinický dosah je zrejmý. Pacient bez vytvoreného arteriovenózneho prístupu, ktorý náhle potrebuje hemodialýzu, je spravidla odkázaný na dočasný alebo tunelizovaný centrálny venózny katéter. Liečba sa tak začína počas urgentnej hospitalizácie, bez dostatočného času na voľbu modality, poučenie pacienta a prípravu bezpečného prístupu.</p>

<h2>Pacienti, ktorí už boli na náhrade funkcie obličiek</h2>

<p>V skupine 20 pacientov, ktorí už náhradu funkcie obličiek dostávali, negatívne odporúčanie potvrdilo <strong>trvalú absenciu možnosti dlhodobého arteriovenózneho prístupu</strong>. Po indexovom posúdení bolo 18 pacientov (90 %) liečených hemodialýzou s predĺženou expozíciou katétru.</p>

<p>Dlhodobý katéter môže byť nevyhnutným riešením, jeho používanie však súvisí s vyšším rizikom katétrovej infekcie a bakteriémie, trombózy, centrálnej venóznej stenózy alebo oklúzie, dysfunkcie katétra, nedostatočnej dialyzačnej dávky, hospitalizácie a straty ďalších možností cievneho prístupu.</p>

<p>Odporúčanie KDOQI pre cievny prístup preto zavádza koncept individuálneho životného plánu pacienta so zlyhaním obličiek (<em>ESKD Life-Plan</em>). Cieľom nemá byť vytvorenie fistuly za každú cenu, ale voľba riešenia zodpovedajúceho prognóze, plánovanej modalite, očakávanému priebehu ochorenia a preferenciám pacienta.</p>

<h2>Mortalita</h2>

<p>Počas sledovania zomrelo 17 zo 40 pacientov, teda 42,5 % (v abstrakte zaokrúhlené na 43 %).</p>

<div class="table-responsive" role="region" aria-label="Mortalita podľa stavu náhrady funkcie obličiek pri posúdení" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Skupina</th>
      <th scope="col">Úmrtia</th>
      <th scope="col">Podiel</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Predialyzační pacienti</th>
      <td>7 z 20</td>
      <td>35 %</td>
    </tr>
    <tr>
      <th scope="row">Už na náhrade funkcie obličiek</th>
      <td>10 z 20</td>
      <td>50 %</td>
    </tr>
    <tr>
      <th scope="row">Celý súbor</th>
      <td>17 zo 40</td>
      <td>42,5 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Mortalita bola numericky vyššia u pacientov, ktorí už náhradu funkcie obličiek dostávali. Pri 20 pacientoch v každej skupine však nemožno tvrdiť, že rozdiel je štatisticky významný ani že ho spôsobil stav cievneho prístupu.</p>

<p>Negatívne chirurgické odporúčanie treba chápať predovšetkým ako <strong>marker pokročilosti ochorenia a kumulácie rizikových faktorov</strong>. Pacienti s vyčerpaným cievnym riečiskom alebo závažnými komorbiditami majú spravidla aj vyšší vek, pokročilejšie kardiovaskulárne ochorenie, vyššiu krehkosť, častejšie hospitalizácie, závažnejšiu aterosklerózu a kratšiu očakávanú dĺžku života.</p>

<p>Samotná nemožnosť vytvoriť fistulu teda pravdepodobne nie je priamou príčinou úmrtia, ale súčasťou komplexného obrazu vysokorizikového pacienta.</p>

<h2>Katéter nie je iba technický problém</h2>

<p>V praxi sa dlhodobé používanie katétra niekedy vníma predovšetkým ako problém cievneho prístupu. U pacienta s vyčerpaným cievnym riečiskom však ovplyvňuje celý priebeh liečby.</p>

<p>Katéter môže viesť k opakovaným infekčným komplikáciám, hospitalizáciám a prerušovaniu dialýzy. Centrálna venózna stenóza môže navyše znemožniť budúce cievne rekonštrukcie a skomplikovať aj iné výkony, napríklad implantáciu alebo používanie kardiologických intravaskulárnych systémov.</p>

<p>Pri katétrovej hemodialýze je preto potrebné pravidelne hodnotiť funkciu a prietok katétra, počet dysfunkcií a výmen, infekčné komplikácie, stav centrálnych žíl, adekvátnosť dialýzy, možnosť peritoneálnej dialýzy a celkovú prognózu a ciele pacienta.</p>

<h2>Význam peritoneálnej dialýzy</h2>

<p>U pacienta bez možnosti arteriovenózneho prístupu treba vždy posúdiť, či je vhodnou alternatívou peritoneálna dialýza. V opísanom súbore ju spomedzi jedenástich pacientov začínajúcich náhradu funkcie obličiek zvolil iba jeden — čo naznačuje, že jej potenciál v tejto situácii nemusí byť plne využitý.</p>

<p>Automaticky možná však nie je u každého. Zohľadniť treba predchádzajúce brušné operácie a zrasty, funkciu peritonea, hernie alebo opakované infekcie, schopnosť pacienta liečbu vykonávať, kognitívny a funkčný stav, podporu rodiny alebo dostupnosť asistovanej liečby, riziko nedostatočnej ultrafiltrácie a preferencie pacienta.</p>

<p>U niektorých pacientov môže byť vhodná urgentne začatá alebo asistovaná peritoneálna dialýza. Rozhodnutie musí byť individuálne a nemá vychádzať len z toho, že hemodialýza cez katéter je problematická.</p>

<h2>Potreba skoršieho plánovania</h2>

<p>Výsledky podporujú včasné odoslanie rizikových pacientov na komplexné posúdenie cievneho prístupu. Samotné vytvorenie prístupu však nie je jediným cieľom — plánovať treba celý ďalší priebeh liečby. Autori vo svojom závere zdôrazňujú práve tri veci: <strong>skoršiu identifikáciu</strong> týchto pacientov, <strong>štruktúrované posúdenie modality</strong> a <strong>včasné začlenenie paliatívnej starostlivosti</strong>.</p>

<p>Včas je vhodné prediskutovať:</p>

<ol>
  <li>pravdepodobnosť potreby náhrady funkcie obličiek,</li>
  <li>predpokladaný čas začatia liečby,</li>
  <li>možnosť hemodialýzy,</li>
  <li>možnosť peritoneálnej dialýzy vrátane asistovanej formy,</li>
  <li>transplantáciu obličky, ak je relevantná,</li>
  <li>konzervatívnu liečbu bez dialýzy,</li>
  <li>riziko neplánovaného urgentného začatia,</li>
  <li>očakávanú kvalitu života a záťaž liečby,</li>
  <li>osobné ciele a preferencie pacienta.</li>
</ol>

<p>Najmä pri pokročilom srdcovom zlyhávaní, ťažkej ischemickej chorobe srdca, krehkosti, demencii alebo pokročilej malignite nemusí byť najlepším postupom opakovaný pokus o vytvorenie cievneho prístupu. Vhodnejšia môže byť konzervatívna nefrologická liečba alebo včasná integrácia paliatívnej starostlivosti.</p>

<p>Paliatívna starostlivosť neznamená automatické ukončenie aktívnej liečby. Zahŕňa liečbu symptómov, podporu rozhodovania, plánovanie budúcej starostlivosti a pomoc pacientovi aj rodine pri zvládaní záťaže chronického ochorenia.</p>

<h2>Kritické zhodnotenie štúdie</h2>

<h3>Malý súbor</h3>

<p>Hlavným obmedzením je počet pacientov: celý analyzovaný súbor tvorilo 40 osôb, po 20 v každej podskupine. Percentuálne údaje preto pôsobia výrazne, ale ich odhad je štatisticky neistý — jeden či dva prípady navyše by výsledné podiely podstatne zmenili.</p>

<h3>Chýbajúca kontrolná skupina</h3>

<p>Štúdia neporovnávala pacientov bez možnosti arteriovenózneho prístupu s pacientmi, u ktorých bola fistula alebo graft vytvorená. Nemožno preto určiť, či katétrový prístup viedol k vyššej mortalite, či by úspešný arteriovenózny prístup zlepšil prežívanie, či bola peritoneálna dialýza spojená s lepším výsledkom ani či by skoršie odoslanie k cievnemu tímu prognózu zmenilo.</p>

<h3>Neuvedená dĺžka sledovania</h3>

<p>Publikovaný súhrn neuvádza medián sledovania. Údaj o 43-percentnej mortalite preto nemá časový rámec a nemožno ho priamo porovnávať s prežívaním v iných kohortách.</p>

<h3>Retrospektívny dizajn a výberové skreslenie</h3>

<p>Retrospektívne štúdie závisia od kvality dokumentácie. Pacienti odoslaní na posúdenie cievneho prístupu navyše nemusia reprezentovať všetkých pacientov s pokročilou CKD.</p>

<h3>Zlúčenie dvoch odlišných klinických situácií</h3>

<p>Do jednej skupiny boli zaradení pacienti s vyčerpaným cievnym riečiskom (23) aj pacienti s chirurgickou kontraindikáciou pre komorbidity (17). Tieto situácie majú odlišný mechanizmus aj prognózu. Samostatné vyhodnotenie by mohlo ukázať, či za horšie výsledky môže predovšetkým technická nemožnosť vytvoriť prístup, alebo celková záťaž komorbidít.</p>

<h3>Neplánované začatie hemodialýzy nemá jednoduchú príčinu</h3>

<p>Skutočnosť, že deväť z desiatich pacientov začalo hemodialýzu neplánovane, je klinicky významná, nemožno z nej však vyvodiť, že urgentné začatie spôsobilo negatívne chirurgické odporúčanie. Pravdepodobnejšie je, že negatívne odporúčanie aj neplánované začatie dialýzy sú prejavmi tej istej pokročilej choroby — akútnych kardiorenálnych a koronárnych syndrómov, náhleho zhoršenia CKD, infekcie, objemového preťaženia a celkovej krehkosti.</p>

<h2>Praktický postup pri pacientovi bez možnosti arteriovenózneho prístupu</h2>

<p>Multidisciplinárny tím by mal zvážiť:</p>

<ul>
  <li>opakované cievne zobrazovanie, ak môže rozhodnutie zmeniť,</li>
  <li>možnosť protetického prístupu v primeranom časovom horizonte,</li>
  <li>transplantáciu obličky,</li>
  <li>peritoneálnu dialýzu vrátane asistovanej formy,</li>
  <li>dlhodobý tunelizovaný katéter a s ním spojené riziko infekcie a centrálnej venóznej stenózy,</li>
  <li>konzervatívnu liečbu bez dialýzy,</li>
  <li>plán pre urgentné zhoršenie stavu,</li>
  <li>informovanie pacienta a rodiny,</li>
  <li>včasnú paliatívnu konzultáciu.</li>
</ul>

<p>Opakované chirurgické alebo endovaskulárne zákroky by mali mať jasný očakávaný prínos. Samotná snaha „nájsť ešte jeden prístup“ nemusí byť pre pacienta prospešná, ak je spojená s vysokým rizikom a krátkou očakávanou životnosťou prístupu.</p>

<h2>Záver</h2>

<p>Nemožnosť vytvoriť arteriovenózny cievny prístup je významným prognostickým markerom u pacientov s pokročilou CKD aj u pacientov už liečených náhradou funkcie obličiek. V analyzovanom súbore 40 pacientov:</p>

<ul>
  <li>55 % predialyzačných pacientov neskôr začalo náhradu funkcie obličiek,</li>
  <li>90 % z tých, ktorí ako prvú modalitu začali hemodialýzu, ju začalo neplánovane,</li>
  <li>90 % pacientov už liečených náhradou funkcie obličiek pokračovalo v hemodialýze s dlhodobou expozíciou katétru,</li>
  <li>celková mortalita dosiahla 42,5 %.</li>
</ul>

<p>Štúdia nepreukázala, že absencia arteriovenózneho prístupu priamo spôsobuje vyššiu mortalitu. Ukazuje, že negatívne chirurgické odporúčanie identifikuje skupinu pacientov s pokročilým cievnym ochorením, vysokou komorbiditou a nepriaznivou prognózou — a že dôsledky sa líšia podľa toho, či pacient náhradu funkcie obličiek už dostáva.</p>

<p>Praktickým záverom je skoré a realistické plánovanie všetkých možností vrátane peritoneálnej dialýzy a konzervatívnej liečby. Pri pacientoch s vysokou krehkosťou a závažnými komorbiditami má byť paliatívna starostlivosť integrovaná včas, nie až po zlyhaní poslednej možnosti cievneho prístupu.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou">Načasovanie cievneho prístupu pred hemodialýzou: AVF potrebuje väčší predstih než AVG</a></li>
  <li><a href="article.php?slug=swam-technika-tromboza-hemodialyzacneho-pristupu">SWAM technika pri trombóze hemodialyzačného prístupu: nová možnosť mechanickej trombektómie</a></li>
  <li><a href="article.php?slug=paliativna-starostlivost-nefrologia-krehki-starsi-eskd">Paliatívna starostlivosť v rutinnej nefrológii: nástroje s nízkym prahom pre krehkých a starších pacientov</a></li>
  <li><a href="article.php?slug=dialyzacna-modalita-prezivanie-oktogenari-pd-hd">Dialyzačná modalita a prežívanie u pacientov vo veku 80 rokov a viac</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Figueiredo R, Diniz H, Ferreira J, Lima JC, Mansilha A, Coentrão L. Clinical Outcomes of Patients Ineligible for Arteriovenous Vascular Access: A Retrospective Cohort Analysis. Hemodialysis International. 2026. doi: 10.1111/hdi.70122. PMID 42702583. <a href="https://pubmed.ncbi.nlm.nih.gov/42702583/" target="_blank" rel="noopener noreferrer">PubMed</a>. Hlavný spracovaný zdroj.</em></small></li>
  <li><small><em>Lok CE, Huber TS, Lee T, Shenoy S, Yevzlin AS, Abreo K, Allon M, Asif A, Astor BC, Glickman MH, Graham J, Moist LM, Rajan DK, Roberts C, Vachharajani TJ, Valentini RP; National Kidney Foundation. KDOQI Clinical Practice Guideline for Vascular Access: 2019 Update. American Journal of Kidney Diseases. 2020;75(4 Suppl 2):S1–S164. doi: 10.1053/j.ajkd.2019.12.001. PMID 32778223. <a href="https://pubmed.ncbi.nlm.nih.gov/32778223/" target="_blank" rel="noopener noreferrer">PubMed</a>. Zdroj konceptu individuálneho životného plánu pacienta so zlyhaním obličiek (ESKD Life-Plan).</em></small></li>
  <li><small><em>Lok CE, Rajan DK. KDOQI 2019 Vascular Access Guidelines: What Is New. Seminars in Interventional Radiology. 2022;39(1):3–8. doi: 10.1055/s-0041-1740937. PMID 35210726. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8856770/" target="_blank" rel="noopener noreferrer">plný text v PMC</a>.</em></small></li>
  <li><small><em>National Institute for Health and Care Excellence. Renal replacement therapy and conservative management. NICE guideline NG107. <a href="https://www.nice.org.uk/guidance/ng107" target="_blank" rel="noopener noreferrer">Odporúčania NICE</a>. Voľba medzi hemodialýzou, peritoneálnou dialýzou, transplantáciou a konzervatívnou liečbou so zapojením pacienta do rozhodovania.</em></small></li>
  <li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney International. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. PMID 38490803. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">stránka odporúčania</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_cievny-pristup-nemozny-avf-avg-planovanie-dialyzy_article',
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
