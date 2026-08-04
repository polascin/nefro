<?php

/**
 * add_prader-willi-syndrom-genetika-hyperfagia-starostlivost_article.php
 * Odborný článok o celoživotnom manažmente Praderovho-Williho syndrómu.
 *
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
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
    'title'        => 'Praderov-Williho syndróm naprieč životom: genetika, hyperfágia a koordinovaná starostlivosť',
    'slug'         => 'prader-willi-syndrom-genetika-hyperfagia-starostlivost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praderov-Williho syndróm si vyžaduje celoživotnú koordináciu. Nová liečba hyperfágie mení možnosti v USA, no európsky stav, limity dôkazov a renálna bezpečnosť vyžadujú presné čítanie.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Praderov-Williho syndróm nie je iba genetická príčina obezity. Je to celoživotné neurovývinové a endokrinné ochorenie, pri ktorom sa klinické priority menia od novorodeneckej hypotónie a poruchy príjmu potravy k hyperfágii, poruchám spánku, behaviorálnym ťažkostiam a metabolickým komplikáciám. Nové lieky rozširujú možnosti, ale nenahrádzajú koordinovanú starostlivosť ani bezpečne riadený prístup k jedlu.</em></p>

<p>Vzdelávacia aktivita Medscape autorov Jessicy Duisovej, Ashley Shoemakerovej a Anthonyho P. Goldstona spája genetiku, endokrinológiu, spánkovú medicínu, správanie a prechod do dospelej starostlivosti. Jej hlavný odkaz je správny: jednotlivé prejavy Praderovho-Williho syndrómu (PWS) nemožno riešiť izolovane. Pri interpretácii farmakoterapie je však potrebné doplniť aktuálny regulačný stav a rozlíšiť schválenú liečbu od intervencií, pri ktorých máme len obmedzené alebo ešte neukončené klinické údaje.</p>

<h2>Fenotyp sa v priebehu života zásadne mení</h2>

<p>V novorodeneckom a dojčenskom období dominuje výrazná hypotónia, slabé sanie a neprospievanie; časť detí dočasne potrebuje špeciálne pomôcky na kŕmenie alebo enterálnu výživu. Neskôr sa zvyšuje záujem o jedlo, postupne sa rozvíja porucha sýtosti a bez dôsledného dohľadu hrozí rýchly nárast hmotnosti. Hyperfágia nie je otázkou nedostatočnej vôle. Je súčasťou biologického fenotypu ochorenia.</p>

<p>Súbežne sa môžu prejaviť oneskorený psychomotorický a rečový vývin, kognitívne oslabenie, hypogonadizmus, nižší vzrast, zmenené telesné zloženie, skolióza, nižšia kostná denzita, centrálne alebo obštrukčné spánkové apnoe, nadmerná denná spavosť a charakteristické behaviorálne či psychiatrické ťažkosti. Relatívna závažnosť týchto oblastí sa mení, preto musí byť plán starostlivosti pravidelne prehodnocovaný.</p>

<h2>Diagnózu potvrdzuje epigenetické a molekulárne vyšetrenie</h2>

<p>PWS vzniká stratou expresie génov, ktoré sa v kritickej oblasti 15q11.2-q13 za normálnych okolností exprimujú z otcovskej alely. Najčastejším mechanizmom je delécia otcovského úseku, ďalším je maternálná uniparentálna dizómia chromozómu 15 a zriedkavejšou príčinou je imprintingová porucha. Fenotyp preto nemožno zredukovať na poškodenie jediného génu.</p>

<p>Podľa aktualizovaného GeneReviews možno diagnózu a vo väčšine prípadov aj mechanizmus objasniť kombináciou analýzy metylácie DNA a oligonukleotidového SNP poľa. Metylácia preukáže výlučne maternálny imprinting v kritickej oblasti; chromozómové pole pomáha rozlíšiť deléciu, niektoré formy uniparentálnej dizómie a deléciu imprintingového centra. Pri nejednoznačnom výsledku sa dopĺňajú ďalšie polymorfizmové alebo cielene zvolené testy. Určenie mechanizmu je dôležité aj pre genetické poradenstvo, pretože riziko opakovania v rodine nie je pri všetkých mechanizmoch rovnaké.</p>

<h2>Základom zostáva prostredie, výživa a endokrinná starostlivosť</h2>

<p>Prevencia obezity pri PWS vyžaduje predvídateľný režim, primeraný energetický príjem, dostatok mikronutrientov, pravidelný pohyb a konzistentne kontrolovaný prístup k jedlu. Takzvaná food security v tomto kontexte neznamená iba nutričnú bezpečnosť potravín. Znamená dohodnuté pravidlá, dohľad a úpravu prostredia tak, aby jedlo nebolo dostupné mimo plánu. Porušenie režimu sa nemá interpretovať ako morálne zlyhanie pacienta.</p>

<p>Liečba rastovým hormónom môže zlepšiť rast, pomer svalovej a tukovej hmoty, mobilitu a pri skorom začatí aj motorický vývin. Vyžaduje však odbornú indikáciu a monitorovanie. GeneReviews odporúča polysomnografiu pred začatím liečby a opakované vyšetrenie po jej začatí, pretože spánkové dýchanie treba hodnotiť nezávisle od subjektívnych ťažkostí. Do endokrinologického plánu patria aj puberta a substitúcia pohlavných hormónov, štítna žľaza, glukózový metabolizmus, kostné zdravie a podľa klinického podozrenia posúdenie centrálnej adrenálnej insuficiencie.</p>

<h2>Diazoxid cholín: schválenie v USA, nie v Európskej únii</h2>

<p>Najvýznamnejšou aktuálnou zmenou je diazoxid cholín s predĺženým uvoľňovaním (diazoxide choline extended-release, Vykat XR). Americká FDA ho 26. marca 2025 schválila na liečbu hyperfágie u dospelých a detí s PWS vo veku od štyroch rokov. Nemožno ho zamieňať za perorálnu suspenziu diazoxidu, pretože liekové formy majú odlišnú farmakokinetiku.</p>

<p>Registračnú účinnosť podporila 16-týždňová randomizovaná vysadzovacia fáza so 77 účastníkmi, ktorí pred randomizáciou dostávali liek priemerne 3,3 roka. Pri prechode na placebo sa skóre hyperfágie zhoršilo viac ako pri pokračovaní liečby; rozdiel zmien na škále HQ-CT bol −5,0 bodu v prospech Vykat XR (95 % interval spoľahlivosti −8,1 až −1,8). Tento dizajn dokladá udržanie účinku u predliečenej populácie, nie účinnosť začatia liečby u neselektovaných pacientov.</p>

<p>Bezpečnostný profil je klinicky dôležitý. Liek môže vyvolať hyperglykémiu vrátane diabetickej ketoacidózy a retenciu tekutín vrátane závažného edému alebo pľúcneho edému. Americká informácia o lieku vyžaduje kontrolu glykémie nalačno a HbA1c pred liečbou aj počas nej a sledovanie príznakov objemového preťaženia. Vykat XR nebol skúmaný pri poruche funkcie obličiek a americký súhrn ho v tejto situácii neodporúča.</p>

<p>V Európskej únii nejde o povolenú liečbu. Spoločnosť v apríli 2026 stiahla žiadosť o registráciu lieku Viokat s rovnakou účinnou látkou. Stiahnutie žiadosti nemožno interpretovať ako európske schválenie ani automaticky ako definitívne zamietnutie budúceho vývoja; pre klinickú prax však znamená, že americký regulačný status sa nesmie prenášať na Európu.</p>

<h2>Agonisti receptora GLP-1: sľubné kazuistiky, nejednotné údaje</h2>

<p>Lieky zo skupiny agonistov receptora GLP-1 môžu byť indikované pri obezite alebo diabete 2. typu podľa všeobecných registračných podmienok konkrétneho lieku. To však nie je totožné so schválením na liečbu hyperfágie pri PWS.</p>

<p>V randomizovanej štúdii s liraglutidom u 55 detí a dospievajúcich s PWS a obezitou neboli splnené koprimárne ciele zmeny BMI z-skóre v 16. ani 52. týždni. U dospievajúcich sa v 52. týždni objavil priaznivý signál v niektorých skóre hyperfágie, išlo však o sekundárny výsledok. Údaje o semaglutide pri PWS pochádzajú prevažne z jednotlivých prípadov a malých sérií. Očakávaný účinok pri bežnej obezite alebo diabete preto nemožno bez ďalších štúdií automaticky preniesť na syndrómovo podmienenú hyperfágiu.</p>

<p>Gastrointestinálne ťažkosti vyžadujú pri PWS osobitnú pozornosť. Oneskorené vyprázdňovanie žalúdka, zriedkavé vracanie a znížené vnímanie bolesti môžu maskovať závažnú akútnu brušnú príhodu. Nová distenzia brucha, bolesť, letargia, nechutenstvo alebo vracanie sa preto nemajú automaticky pripísať nežiaducemu účinku lieku; vyžadujú nízky prah pre urgentné vyšetrenie.</p>

<h2>Pitolisant a topiramát: rozdielna otázka, rozdielna sila dôkazov</h2>

<p>Pitolisant sa skúma na nadmernú dennú spavosť pri PWS. K marcu 2026 bola globálna randomizovaná štúdia fázy 3 NCT06366464 stále v nábore a nemala zverejnené výsledky. Pred farmakologickou liečbou dennej spavosti treba vyšetriť a liečiť poruchu dýchania v spánku a ďalšie možné príčiny. Pitolisant nemožno v súčasnosti prezentovať ako zavedenú liečbu PWS.</p>

<p>Topiramát sa pri PWS používa mimo schválenej indikácie najmä v súvislosti s hyperfágiou alebo niektorými behaviorálnymi prejavmi. V osemtýždňovej štúdii TOPRADER so 62 účastníkmi sa nepreukázal významný rozdiel v primárnom výsledku celkového klinického zlepšenia. Niektoré sekundárne skóre hyperfágie sa zlepšili a účinok súvisel s dávkou. Výsledok je signálom možného prínosu, nie dôkazom univerzálnej účinnosti na sebapoškodzovanie alebo obezitu.</p>

<p>Z nefrologického hľadiska topiramát inhibuje karboanhydrázu, môže vyvolať hyperchloremickú metabolickú acidózu a zvyšuje riziko nefrolitiázy. Pred liečbou a počas nej je potrebné zohľadniť renálnu funkciu, sérový bikarbonát, anamnézu kameňov, súbežnú liečbu a možnosti bezpečnej hydratácie.</p>

<h2>Čo má sledovať nefrológ</h2>

<p>PWS sám osebe nie je typickou primárnou nefropatiou a bez ďalších rizikových faktorov nie je dôvod automaticky zavádzať špecializovaný nefrologický dispenzár. Renálne riziko vzniká najmä prostredníctvom obezity, diabetu, hypertenzie, akútnej dehydratácie a liekov.</p>

<ul>
  <li><strong>CKD skríning podľa rizika:</strong> krvný tlak, sérový kreatinín s odhadom eGFR a albuminúria majú byť vyšetrené pri diabete, hypertenzii, výraznej obezite, po prekonanom akútnom poškodení obličiek alebo pri inom klinickom podozrení.</li>
  <li><strong>Diazoxid cholín:</strong> pred prípadným použitím treba poznať funkciu obličiek, glykemický profil a objemový stav. Edém nemusí byť iba dôsledkom obezity; pri liečbe môže signalizovať retenciu tekutín.</li>
  <li><strong>Topiramát:</strong> relevantné sú pokles bikarbonátu, zmena renálnej funkcie, renálna kolika, hematúria a rizikové kombinácie podporujúce acidózu alebo tvorbu kameňov.</li>
  <li><strong>Agonisti receptora GLP-1 a interkurentné ochorenie:</strong> pretrvávajúce vracanie alebo hnačka môžu viesť k hypovolémii a akútnemu poškodeniu obličiek. Individuálny plán dočasnej úpravy liekov má pripraviť ošetrujúci tím podľa komorbidít a konkrétnej medikácie.</li>
</ul>

<h2>Prechod do dospelosti musí byť plánovaný proces</h2>

<p>Prechod z pediatrickej do dospelej starostlivosti je rizikovým obdobím. Bežná predstava rastúcej úplnej samostatnosti môže byť pri PWS v rozpore s celoživotnou potrebou kontroly prístupu k jedlu a podpory pri rozhodovaní. Autonómia sa má rozvíjať primerane kognitívnym schopnostiam, nie formálnym odovzdaním zodpovednosti, ktorú pacient nedokáže bezpečne niesť.</p>

<p>Odovzdávacia správa má obsahovať molekulárny mechanizmus PWS, rastovú a endokrinnú anamnézu, liečbu rastovým a pohlavnými hormónmi, posledné spánkové vyšetrenia, metabolické a kostné riziká, behaviorálny a psychiatrický profil, komunikačné potreby, plán prístupu k jedlu a úplný zoznam liekov vrátane ich bezpečnostného monitorovania. Koordinátorom dospelej starostlivosti býva často endokrinológ alebo internista so skúsenosťou s PWS, podľa potreby v spolupráci s genetikom, spánkovým pracoviskom, psychiatrom, dietológom, rehabilitačným tímom a sociálnymi službami.</p>

<h2>Limity dôkazov</h2>

<p>Hlavný materiál Medscape je odborná CME syntéza, nie systematický prehľad ani klinické odporúčanie. Časť manažmentu PWS stojí na malých štúdiách, observačných údajoch a expertnej zhode, čo je pri zriedkavom ochorení pochopiteľné. Aj britsko-írske odporúčanie z roku 2024 výslovne uvádza, že významná časť odporúčaní vychádza z dôkazov nízkej kvality alebo z konsenzu.</p>

<p>Najpevnejší nový regulačný údaj sa týka diazoxidu cholínu v USA. Jeho randomizovaná vysadzovacia štúdia však hodnotila dlhodobo predliečených účastníkov a európska registračná žiadosť bola stiahnutá. Pri liraglutide neboli splnené primárne hmotnostné ciele, údaje o semaglutide sú prevažne kazuistické, topiramát neuspel v primárnom výsledku štúdie TOPRADER a štúdia pitolisantu fázy 3 ešte nemá zverejnené výsledky. Tieto rozdiely v kvalite dôkazov musia byť súčasťou rozhodovania.</p>

<h2>Záver</h2>

<p>Praderov-Williho syndróm vyžaduje celoživotnú, predvídateľnú a multidisciplinárnu starostlivosť. Včasná molekulárna diagnóza, riadené prostredie s bezpečným prístupom k jedlu, endokrinná liečba, pravidelné hodnotenie spánku, behaviorálna a psychosociálna podpora a plánovaný prechod do dospelosti zostávajú základom manažmentu.</p>

<p>Diazoxid cholín predstavuje prvú americkou FDA schválenú cielenú liečbu hyperfágie pri PWS, ale jeho účinok a bezpečnosť treba interpretovať v kontexte dizajnu registračnej štúdie, chýbajúceho európskeho povolenia a významných metabolických aj objemových rizík. Ostatné diskutované lieky majú slabšie alebo ešte neukončené dôkazy špecifické pre PWS. Pre nefrológa je najdôležitejšie rozpoznať sekundárne renálne riziko, bezpečne monitorovať liečbu a neprehliadnuť akútnu dehydratáciu, acidózu, nefrolitiázu alebo retenciu tekutín.</p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Duis J, Shoemaker A, Goldstone AP.</strong> <em>Connecting the Pieces in Prader-Willi Syndrome: New Insights for Novel Care Options.</em> Medscape Education. 3. augusta 2026. <a href="https://www.medscape.org/viewarticle/connecting-pieces-prader-willi-syndrome-new-insights-novel-2026a1000p8z?page=1" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
  <li><strong>Driscoll DJ, Miller JL, Cassidy SB.</strong> <em>Prader-Willi Syndrome.</em> GeneReviews®. Revízia 19. februára 2026. <a href="https://www.ncbi.nlm.nih.gov/books/NBK1330/" target="_blank" rel="noopener noreferrer">NCBI Bookshelf</a>.</li>
  <li><strong>U.S. Food and Drug Administration.</strong> <em>VYKAT XR (diazoxide choline) extended-release tablets: Prescribing Information.</em> Revízia marec 2025. <a href="https://www.accessdata.fda.gov/drugsatfda_docs/label/2025/216665s000lbl.pdf" target="_blank" rel="noopener noreferrer">FDA</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Viokat: Withdrawal of the marketing authorisation application.</em> 24. apríla 2026. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/viokat" target="_blank" rel="noopener noreferrer">EMA</a>.</li>
  <li><strong>Shaikh MG, Barrett TG, Bridges N, et al.</strong> <em>Prader-Willi syndrome: guidance for children and transition into adulthood.</em> Endocrine Connections. 2024;13:e240091. doi: 10.1530/EC-24-0091. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11301552/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Diene G, Angulo M, Hale PM, et al.</strong> <em>Liraglutide for Weight Management in Children and Adolescents With Prader-Willi Syndrome and Obesity.</em> Journal of Clinical Endocrinology &amp; Metabolism. 2023;108(1):4–12. doi: 10.1210/clinem/dgac549. <a href="https://pubmed.ncbi.nlm.nih.gov/36181471/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Consoli A, Çabal Berthoumieu S, Raffin M, et al.</strong> <em>Effect of topiramate on eating behaviours in Prader-Willi syndrome: TOPRADER double-blind randomised placebo-controlled study.</em> Translational Psychiatry. 2019;9:274. doi: 10.1038/s41398-019-0597-0. <a href="https://pubmed.ncbi.nlm.nih.gov/31685813/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>ClinicalTrials.gov.</strong> <em>A Study of Pitolisant in Patients With Prader-Willi Syndrome.</em> NCT06366464. Záznam aktualizovaný 17. marca 2026. <a href="https://clinicaltrials.gov/study/NCT06366464" target="_blank" rel="noopener noreferrer">Register štúdie</a>.</li>
  <li><strong>U.S. Food and Drug Administration.</strong> <em>TOPAMAX (topiramate): Prescribing Information.</em> Revízia marec 2026. <a href="https://www.accessdata.fda.gov/drugsatfda_docs/label/2026/020505s068lbl.pdf" target="_blank" rel="noopener noreferrer">FDA</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Hlavným spracovaným zdrojom je CME aktivita Medscape. Regulačné tvrdenia boli overené v dokumentoch FDA a EMA, diagnostické a celoživotné odporúčania v GeneReviews a v odbornom konsenze. Výsledky jednotlivých liekov sú uvádzané podľa ich skutočnej úrovne dôkazov; skúšané a off-label intervencie nie sú prezentované ako štandardná liečba PWS.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_prader-willi-syndrom-genetika-hyperfagia-starostlivost_article',
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
