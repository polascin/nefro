<?php
/**
 * Odborny clanok: lokalny finasterid pri muzskej androgenovej alopecii.
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
    'title'        => 'Lokálny finasterid pri mužskej androgénovej alopécii: účinnosť po 52 týždňoch a hranice dôkazov',
    'slug'         => 'lokalny-finasterid-muzska-androgenova-alopecia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Lokálny finasterid zlepšil vlasové parametre aj po 52 týždňoch, no nekontrolovaná štúdia nevylučuje systémové riziká ani nedokazuje rovnocennosť rôznych formulácií.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Nová 52-týždňová retrospektívna štúdia prináša doteraz chýbajúce dlhodobejšie údaje o lokálnom finasteride v monoterapii. Výsledky sú priaznivé, ale ich klinický význam treba oddeliť od toho, čo štúdia pre svoj dizajn nemohla dokázať: rovnocennosť s perorálnym finasteridom, vzájomnú zameniteľnosť rôznych roztokov ani neprítomnosť zriedkavých systémových nežiaducich účinkov.</em></p>

<h2>Čo je mužská androgénová alopécia</h2>

<p>Androgénová alopécia je geneticky a hormonálne podmienené progresívne rednutie vlasov. U mužov sa typicky prejavuje ústupom frontotemporálnej vlasovej hranice a rednutím vo vertexovej oblasti. V citlivých folikuloch premieňa 5α-reduktáza testosterón na dihydrotestosterón (DHT). Androgénová signalizácia následne skracuje anagénnu fázu vlasového cyklu a podporuje miniaturizáciu folikulu: hrubý pigmentovaný terminálny vlas sa postupne nahrádza kratším a tenším vlasom velusového typu.</p>

<p>Finasterid je inhibítor 5α-reduktázy, predovšetkým izoenzýmu typu II. Perorálna liečba účinne znižuje DHT, ale systémová expozícia môže byť spojená najmä so sexuálnymi nežiaducimi účinkami. Lokálne podanie sa usiluje vytvoriť účinnú koncentráciu v pokožke hlavy pri nižšej plazmatickej expozícii. Neznamená to však, že liečivo zostáva výlučne v koži.</p>

<h2>Čo skúmala nová 52-týždňová štúdia</h2>

<p>Gallo a spolupracovníci retrospektívne analyzovali zdravotnú dokumentáciu <strong>123 dospelých mužov</strong> s androgénovou alopéciou liečených lokálnym finasteridom v monoterapii na Dermatologickej klinike Turínskej univerzity. Priemerný vek bol 32,4 ± 8,1 roka. Liečba prebiehala od apríla 2022 do novembra 2025 a stav sa porovnával na začiatku a po 52 týždňoch pomocou štandardizovaných fotografií a videodermoskopie.</p>

<p>V kohorte sa používali dve farmaceuticky odlišné formulácie:</p>

<ul>
  <li><strong>78 mužov</strong> používalo komerčný sprej s obsahom 2,275 mg finasteridu v 1 ml a dávkou jedného až štyroch strekov denne podľa veľkosti ošetrovanej plochy,</li>
  <li><strong>45 mužov</strong> používalo individuálne pripravený 0,25 % hydroalkoholový roztok v objeme 1 ml denne.</li>
</ul>

<p>Primárnym ukazovateľom bola zmena celkového počtu vlasov. Ďalšie ukazovatele zahŕňali priemer vlasového stvolu, pomer terminálnych a velusových vlasov, hodnotenie lekárom, odpoveď pacienta a nežiaduce udalosti.</p>

<h2>Výsledky po jednom roku</h2>

<ul>
  <li>V temporálnej oblasti sa priemerný počet vlasov zvýšil o <strong>29,4 vlasu/cm²</strong>.</li>
  <li>Vo vertexovej oblasti sa zvýšil o <strong>21,8 vlasu/cm²</strong>.</li>
  <li>Obe zmeny boli štatisticky významné (<strong>p &lt; 0,001</strong>).</li>
  <li>Významne sa zväčšil aj priemer vlasového stvolu a zlepšil sa pomer terminálnych a velusových vlasov.</li>
  <li>Mierne a prechodné lokálne podráždenie uviedlo <strong>7,3 % pacientov</strong>.</li>
  <li>V dostupnej dokumentácii neboli zaznamenané systémové nežiaduce udalosti súvisiace so sexuálnou funkciou alebo náladou.</li>
</ul>

<p>Zlepšenie trichoskopických parametrov je zlučiteľné s obmedzením folikulárnej miniaturizácie. Nie je však histologickým dôkazom úplnej regenerácie folikulov. Aj priaznivé hodnotenie lekárom a pacientom treba interpretovať s vedomím, že účastníci ani hodnotiaci neboli zaslepení voči liečbe.</p>

<h2>Čo štúdia nedokázala</h2>

<p>Výsledky predstavujú asociáciu pred liečbou a po liečbe, nie randomizované porovnanie. Štúdii chýbala kontrolná skupina, placebo, perorálny komparátor aj zaslepené pridelenie liečby. Výsledok mohli ovplyvniť výber pacientov, adherencia, variabilita merania, hodnotiace očakávania a neúplný záznam miernych nežiaducich udalostí.</p>

<p>Súbor 123 mužov navyše nemá dostatočnú štatistickú silu na vylúčenie zriedkavých systémových komplikácií. Tvrdenie „neboli zaznamenané“ preto nemožno zameniť za tvrdenie „nemôžu sa vyskytnúť“.</p>

<p>Nezistenie významného rozdielu medzi dvoma používanými formuláciami nepreukazuje ich bioekvivalenciu. Štúdia nebola navrhnutá ako ekvivalenčné ani noninferioritné skúšanie a roztoky sa líšili koncentráciou, vehikulom, objemom aj spôsobom dávkovania.</p>

<h2>Koncentrácia nie je to isté ako denná dávka</h2>

<p>Pri lokálnom finasteride treba vždy uviesť <strong>koncentráciu, objem jednej dávky, počet strekov a ošetrovanú plochu</strong>. Slovenský registrovaný liek Finjuve obsahuje 2,275 mg/ml, čo pri prepočte zodpovedá približne 0,2275 % m/V. Jeden 50-mikrolitrový strek obsahuje 114 mikrogramov finasteridu. Odporúčaná dávka je jeden až štyri neprekrývajúce sa streky raz denne, teda najviac približne 0,46 mg finasteridu naneseného na pokožku.</p>

<p>Ak 0,25 % magistraliter roztok obsahuje 2,5 mg/ml a aplikuje sa v objeme 1 ml, na pokožku sa nanesie približne 2,5 mg finasteridu, teda asi 5,5-násobok množstva v maximálnej dennej dávke registrovaného spreja. To neznamená 5,5-násobnú systémovú expozíciu: penetrácia závisí od vehikula, plochy, kožnej bariéry a aplikačnej techniky. Znamená to však, že údaje o bezpečnosti štandardizovaného spreja nemožno automaticky preniesť na každý individuálne pripravený roztok.</p>

<h2>Ako výsledky zapadajú do randomizovaných dôkazov</h2>

<p>V multicentrickom randomizovanom skúšaní fázy III bolo 458 mužov pridelených k lokálnemu finasteridovému spreju, placebu alebo perorálnemu finasteridu 1 mg. Bezpečnostná populácia zahŕňala 446 účastníkov a 323 mužov dokončilo 24 týždňov liečby.</p>

<p>Počet vlasov v cieľovej oblasti sa pri lokálnom finasteride zvýšil v priemere o 20,2 vlasu, pri placebe o 6,7 vlasu (<strong>p &lt; 0,001</strong>). Numerický účinok bol podobný perorálnemu finasteridu, skúšanie však nebolo formálnym dôkazom úplnej terapeutickej ekvivalencie.</p>

<p>Maximálne priemerné plazmatické koncentrácie finasteridu boli pri štandardizovanom spreji viac než stonásobne nižšie než pri perorálnej dávke 1 mg. Sérový DHT po 24 týždňoch klesol približne o 34,5 % pri lokálnej a o 55,6 % pri perorálnej liečbe. Lokálne podanie teda znižuje systémovú expozíciu, ale sérový DHT môže ovplyvniť klinicky významne.</p>

<p>Schválený súhrn charakteristických vlastností Finjuve doteraz uvádza, že klinické skúsenosti s používaním dlhšie ako šesť mesiacov nie sú k dispozícii. Nová kohorta túto medzeru čiastočne dopĺňa, ide však o observačné údaje, nie o predĺženie registračného randomizovaného skúšania.</p>

<h2>Bezpečnosť: čo vieme a čo zostáva neisté</h2>

<h3>Lokálne reakcie</h3>

<p>Najčastejšie sa vyskytujú pruritus, erytém, pálenie, suchosť alebo šupinatenie. Príčinou môže byť samotné liečivo aj etanol, propylénglykol či iná pomocná látka. Prípravok sa nemá aplikovať na poškodenú alebo výrazne zapálenú pokožku.</p>

<h3>Sexuálne nežiaduce účinky</h3>

<p>V registračnom skúšaní boli sexuálne nežiaduce udalosti súvisiace s liečbou hlásené u 2,8 % pacientov s lokálnym finasteridom, u 3,3 % s placebom a u 4,8 % s perorálnym finasteridom. Počet udalostí bol malý a tieto údaje neumožňujú dokázať nulové riziko. Biologicky možné sú najmä znížené libido, erektilná dysfunkcia, poruchy ejakulácie a zmeny fertility.</p>

<h3>Nálada a suicidálne myšlienky</h3>

<p>Celoeurópske bezpečnostné prehodnotenie v roku 2025 potvrdilo suicidálne myšlienky ako nežiaduci účinok tabliet finasteridu s neznámou frekvenciou. Pri finasteridových kožných sprejoch sa z dostupných údajov súvislosť so suicidálnymi myšlienkami nepreukázala a regulačné orgány pre ne neprijali nové opatrenia. Toto konštatovanie sa vzťahuje na vyhodnotené registrované spreje a nie je dôkazom absolútnej neprítomnosti psychických ťažkostí pri každej lokálnej formulácii.</p>

<p>Súhrn charakteristických vlastností Finjuve naďalej odporúča pacienta poučiť, aby pri psychiatrických príznakoch vyhľadal lekársku pomoc. Novú depresívnu náladu, depresiu alebo suicidálne myšlienky treba vždy klinicky riešiť bez ohľadu na predpokladanú príčinu.</p>

<h3>Fertilita, PSA a prenos na inú osobu</h3>

<p>Fertilita u ľudí sa s registrovaným lokálnym sprejom systematicky neskúmala. Nie sú dostupné ani údaje o jeho vplyve na prostatický špecifický antigén (PSA), čo treba zohľadniť pri interpretácii výsledku. Finasterid môže narušiť vývoj vonkajších pohlavných orgánov plodu mužského pohlavia. Gravidné ženy, ženy, ktoré môžu otehotnieť, deti a dospievajúci preto nesmú prísť do kontaktu s roztokom ani s exponovanou pokožkou alebo povrchom.</p>

<p>Pri registrovanom spreji má byť pokožka pred aplikáciou suchá, miesta jednotlivých strekov sa nemajú prekrývať a roztok sa má nechať zaschnúť. Ošetrená pokožka nemá prísť do kontaktu s povrchmi až do zaschnutia a prípravok sa má ponechať pôsobiť najmenej šesť hodín. Pri náhodnom kontakte treba postihnutú kožu dôkladne umyť.</p>

<h2>Ženy, kombinácie a magistraliter prípravky</h2>

<p>Nová 52-týždňová štúdia zahŕňala iba mužov. Finjuve nie je určené ženám a je kontraindikované u žien, ktoré sú gravidné alebo môžu otehotnieť. Menšie práce s lokálnym alebo systémovým finasteridom u žien nemožno použiť na svojvoľné rozšírenie indikácie registrovaného spreja.</p>

<p>Predmetná kohorta hodnotila finasterid ako monoterapiu. Zo štúdie preto nemožno vyvodiť účinnosť ani bezpečnosť konkrétnej kombinácie s minoxidilom. Súhrn charakteristických vlastností Finjuve uvádza, že súbežné použitie s lokálnym minoxidilom ani inými lokálnymi prípravkami na rovnakej ploche sa neskúmalo; na ošetrovanej ploche sa im treba vyhnúť.</p>

<p>Individuálna príprava môže byť klinicky odôvodnená, ale koncentrácia na etikete sama osebe nezaručuje rovnakú stabilitu, rovnomernosť dávky, penetráciu ani systémovú expozíciu ako pri registrovanom lieku. Pri rozhodovaní treba poznať presné zloženie, dávkovací objem, obal, čas použiteľnosti a podmienky prípravy.</p>

<h2>Čo sa stane po ukončení liečby</h2>

<p>Finasterid nemení genetickú predispozíciu vlasových folikulov. Prínos sa udržiava počas pokračujúcej liečby; po vysadení sa androgénová signalizácia obnoví a alopécia môže v priebehu ďalších mesiacov opäť progredovať. Nejde automaticky o poškodenie spôsobené vysadením, ale prevažne o návrat prirodzeného priebehu ochorenia. Nová štúdia obdobie po vysadení nehodnotila.</p>

<h2>Kedy treba diagnózu prehodnotiť</h2>

<p>Nie každé rednutie vlasov u muža je androgénová alopécia. Dermatologické vyšetrenie je dôležité najmä pri náhlom alebo difúznom vypadávaní, ložiskách bez vlasov, jazvení, bolesti či zápale pokožky, lámaní vlasov, systémových príznakoch alebo časovej súvislosti s novým liekom, infekciou, operáciou či výrazným úbytkom hmotnosti.</p>

<p>Laboratórne vyšetrenia sa volia podľa anamnézy a fenotypu. Krvný obraz, feritín, tyreotropín, nutričné parametre alebo ďalšie testy nemajú byť automatickým panelom u každého muža s typickým vzorom androgénovej alopécie.</p>

<h2>Nefrologické súvislosti</h2>

<p>Finasterid sa nepovažuje za typický nefrotoxický liek. Súhrn charakteristických vlastností Finjuve nevyžaduje úpravu dávky pri poruche funkcie obličiek, pretože systémová absorpcia štandardizovaného spreja je nízka. Zároveň výslovne uvádza, že klinické štúdie u pacientov s poruchou funkcie obličiek alebo pečene sa neuskutočnili. Tento záver nemožno bez ďalších údajov prenášať na všetky magistraliter formulácie a vysoké aplikačné objemy.</p>

<p>U pacienta s CKD môže difúzne vypadávanie vlasov súvisieť aj s deficitom železa, poruchou štítnej žľazy, chronickým zápalom, proteínovo-energetickou malnutríciou, deficitom zinku, telogénnym eflúviom po závažnom ochorení alebo liekovým nežiaducim účinkom. Typický mužský vzor však nemožno automaticky pripísať urémii.</p>

<p>Sexuálna dysfunkcia, zmeny nálady a poruchy fertility môžu byť pri pokročilej CKD prítomné už pred začiatkom liečby. Východiskové zdokumentovanie ťažkostí preto pomáha pri neskoršom posúdení časovej a kauzálnej súvislosti.</p>

<h2>Praktický postup pred začatím liečby</h2>

<ol>
  <li>Dermatologicky potvrdiť mužskú androgénovú alopéciu a zdokumentovať východiskový stav štandardizovanými fotografiami.</li>
  <li>Rozlíšiť registrovaný sprej od magistraliter prípravku a zapísať koncentráciu, objem jednej dávky, počet strekov a ošetrovanú plochu.</li>
  <li>Zhodnotiť reprodukčné plány, sexuálne funkcie, náladu, ochorenia pokožky a súbežné lokálne prípravky.</li>
  <li>Pri Finjuve dodržať registrovanú indikáciu, jeden až štyri neprekrývajúce sa streky raz denne a maximálnu dennú dávku.</li>
  <li>Neaplikovať liek na poškodenú kožu a zabrániť prenosu na gravidné ženy, ženy, ktoré môžu otehotnieť, a maloleté osoby.</li>
  <li>Účinok hodnotiť najskôr po troch až šiestich mesiacoch; pri dobrej tolerancii má zmysel objektívne porovnanie aj približne po 12 mesiacoch.</li>
  <li>Pri novej sexuálnej dysfunkcii, psychiatrických príznakoch, zmenách prsného tkaniva alebo bolesti semenníkov liečbu bez odkladu klinicky prehodnotiť.</li>
</ol>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Lokálny finasterid je účinnou možnosťou liečby mužskej androgénovej alopécie. Nová 52-týždňová kohorta ukazuje pretrvávajúce zlepšenie počtu aj hrúbky vlasov pri prevažne dobrej lokálnej tolerancii. Jej nekontrolovaný retrospektívny dizajn však nedokazuje rovnocennosť s perorálnym finasteridom ani úplnú systémovú bezpečnosť.</p>

<p>Najdôležitejším praktickým poznatkom je, že „lokálny finasterid 0,25 %“ nie je jedna univerzálna intervencia. Dennú expozíciu určujú koncentrácia, objem, aplikátor, vehikulum, plocha a stav kožnej bariéry. Najlepšie podložené bezpečnostné údaje sa týkajú štandardizovaného spreja v dávke 50 až 200 mikrolitrov denne, nie ľubovoľného 1-mililitrového magistraliter roztoku.</p>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Gallo G, Mastorino L, Quaglino P, Ribero S.</strong> <em>Long-term effectiveness and safety of topical finasteride 0.25% monotherapy in male androgenetic alopecia: a 52-week real-world retrospective study.</em> Clinical and Experimental Dermatology. Publikované online 3. augusta 2026. doi: 10.1093/ced/llag333. <a href="https://doi.org/10.1093/ced/llag333" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>.</li>
  <li><strong>Piraccini BM, Blume-Peytavi U, Scarci F, et al.</strong> <em>Efficacy and safety of topical finasteride spray solution for male androgenetic alopecia: a phase III, randomized, controlled clinical trial.</em> J Eur Acad Dermatol Venereol. 2022;36(2):286-294. doi: 10.1111/jdv.17738. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9297965/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>Štátny ústav pre kontrolu liečiv.</strong> <em>Finjuve pre mužov 2,275 mg/ml dermálny roztokový sprej: súhrn charakteristických vlastností lieku.</em> Registračné číslo 46/0119/24-S. <a href="https://www.sukl.sk/finjuve-pre-muzov-2275-mg-ml-dermalny-roztokovy-sprej-6262e" target="_blank" rel="noopener noreferrer">Databáza ŠÚKL</a>.</li>
  <li><strong>Štátny ústav pre kontrolu liečiv.</strong> <em>Opatrenia na minimalizáciu rizika samovražedných myšlienok pri liečbe finasteridom a dutasteridom.</em> 9. mája 2025. <a href="https://www.sukl.sk/pre-odbornikov-a-firmy/bezpecnost-liekov/bezpecnostne-upozornenia/opatrenia-na-minimalizaciu-rizika-samovrazednych-myslienok-pri-liecbe-finasteridom-a-dutasteridom" target="_blank" rel="noopener noreferrer">Bezpečnostné upozornenie</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Finasteride- and dutasteride-containing medicinal products: Article 31 referral.</em> Európska komisia prijala konečné rozhodnutie 22. augusta 2025. <a href="https://www.ema.europa.eu/en/medicines/human/referrals/finasteride-dutasteride-containing-medicinal-products" target="_blank" rel="noopener noreferrer">EMA</a>.</li>
  <li><strong>Caserini M, Radicioni M, Leuratti C, Annoni O, Palmieri R.</strong> <em>Effects of a novel finasteride 0.25% topical solution on scalp and serum dihydrotestosterone in healthy men with androgenetic alopecia.</em> Int J Clin Pharmacol Ther. 2016;54(1):19-27. doi: 10.5414/CP202467. <a href="https://pubmed.ncbi.nlm.nih.gov/26636418/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Medscape Professional Network.</strong> <em>Topical Finasteride 0.25% Shows Sustained Improvements in Hair Density and Thickness.</em> 2026. Individuálny autor nebol vo verejne dostupnom zobrazení spoľahlivo uvedený. <a href="https://www.medscape.com/viewarticle/topical-finasteride-0-25-shows-sustained-improvements-hair-2026a1000rd0" target="_blank" rel="noopener noreferrer">Sekundárne spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k interpretácii:</strong> Registračné podmienky, dostupnosť a presné zloženie lokálnych prípravkov sa môžu meniť. Pred predpísaním alebo individuálnou prípravou treba overiť aktuálny súhrn charakteristických vlastností konkrétneho lieku a miestne pravidlá.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_lokalny-finasterid-muzska-androgenova-alopecia_article',
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
