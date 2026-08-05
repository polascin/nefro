<?php

/**
 * add_paliativna-starostlivost-nefrologia-krehki-starsi-eskd_article.php
 * Integracia paliativnej starostlivosti do rutinnej nefrologickej praxe.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
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
    'title'        => 'Paliatívna starostlivosť v rutinnej nefrológii: nástroje s nízkym prahom pre krehkých a starších pacientov',
    'slug'         => 'paliativna-starostlivost-nefrologia-krehki-starsi-eskd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Zásady paliatívnej starostlivosti odporúčania uznávajú, no do praxe sa premietajú nedostatočne. Rakúsky prehľad ukazuje, že nefrológ ich môže používať aj bez špecializovaného výcviku — od prognostiky cez depreskripciu až po ukončenie dialýzy.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Pacientov, ktorí sa do konečného štádia obličkového ochorenia dostávajú vo vysokom veku a s výraznou krehkosťou, pribúda. Prehľad v <em>Nephrology Dialysis Transplantation</em> upozorňuje, že paliatívne zásady síce odporúčania uznávajú, no ich praktické zavedenie zostáva nedostatočné — a že nefrológ nepotrebuje na ich používanie špecializovaný výcvik.</em></p>

<p>Nefrológia sa dlho definovala schopnosťou nahradiť zlyhávajúcu funkciu. Táto schopnosť je mimoriadna, no prináša so sebou aj tichý predpoklad: že ak náhrada existuje, má sa použiť. U staršieho a krehkého pacienta tento predpoklad prestáva platiť automaticky.</p>

<p>Autorský kolektív pod vedením Judith Böhmovej a Balazsa Odlera formuluje východisko jasne: integrácia paliatívnych zásad do klinickej praxe sa stala <strong>naliehavou potrebou</strong> pre rastúci počet pacientov vo vysokom veku a s krehkosťou, ktorí dosahujú konečné štádium ochorenia obličiek. A hoci odporúčania tieto zásady podporujú, <strong>ich praktické zavedenie zostáva nedostatočné</strong>.</p>

<h2>Šesť oblastí, ktoré prehľad pokrýva</h2>

<p>Prehľad postupuje cez šesť domén, ktoré spolu tvoria priebeh starostlivosti, nie samostatné epizódy:</p>

<ol>
  <li>prognostika,</li>
  <li>rozhovory o cieľoch starostlivosti,</li>
  <li>hodnotenie konzervatívneho nefrologického postupu,</li>
  <li>individualizované nastavenie dialýzy,</li>
  <li>depreskripcia liekov,</li>
  <li>ukončenie dialýzy.</li>
</ol>

<p>Záver autorov znie, že nefrológovia môžu do svojej praxe zaradiť <strong>nástroje s nízkym prahom aj bez špecializovaného paliatívneho výcviku</strong>, a tým obmedziť zbytočné intervencie a zlepšiť manažment symptómov.</p>

<h2>Prognostika: nevyhnutná, hoci nepresná</h2>

<p>Rozhovor o cieľoch starostlivosti bez odhadu prognózy je prázdny — pacient nemá podľa čoho voliť. Nefrológovia sa však odhadom vyhýbajú, čiastočne preto, že sú neisté.</p>

<p>Najjednoduchším nástrojom zostáva <strong>prekvapujúca otázka</strong>: „Prekvapilo by ma, keby tento pacient zomrel v priebehu najbližších dvanástich mesiacov?“ Odpoveď „nie“ nie je prognózou — je spúšťačom. Znamená, že je čas hovoriť o cieľoch, doriešiť plánovanie starostlivosti vopred a zvážiť, ktoré intervencie ešte dávajú zmysel.</p>

<p>Presnosť tejto otázky je len stredná a jej výsledok sa nemá pacientovi tlmočiť ako predpoveď. Jej hodnota spočíva v tom, že rozhovor otvorí — a to je viac, než dosiahne dokonalý prognostický model, ktorý sa nepoužije.</p>

<h2>Konzervatívny postup nie je rezignácia</h2>

<p>Najčastejším nedorozumením je predstava, že konzervatívny nefrologický postup znamená „nerobiť nič“. Ide pritom o aktívne vedenú starostlivosť: manažment symptómov, korekcia anémie a acidózy, kontrola objemu, liečba svrbenia a bolesti, psychosociálna a duchovná podpora, plánovanie záveru života.</p>

<p>Dôkazy sú konkrétnejšie, než sa vo všeobecnosti predpokladá. Holandská kohorta Woutera Verbeho a spolupracovníkov porovnala 107 konzervatívne vedených pacientov s 204 pacientmi na náhrade funkcie obličiek vo veku 70 rokov a viac:</p>

<ul>
  <li>V celom súbore bol medián prežívania 3,1 roka pri náhrade funkcie oproti 1,5 roka pri konzervatívnom postupe.</li>
  <li><strong>Vo veku 80 rokov a viac sa rozdiel prestal potvrdzovať</strong> — 2,1 oproti 1,4 roka (p = 0,08).</li>
  <li>Pri vysokej komorbidite (Daviesovo skóre 3 a viac) bol rozdiel síce významný, ale malý — 1,8 oproti 1,0 roka.</li>
</ul>

<p>Staršia britská práca Rachel Carsonovej a spolupracovníkov našla u pacientov nad 70 rokov výraznejší rozdiel v prežívaní (medián 37,8 oproti 13,9 mesiaca), zároveň však ukázala niečo podstatnejšie: konzervatívne vedení pacienti mali <strong>podobný počet dní strávených mimo nemocnice</strong> a významne vyššiu pravdepodobnosť, že zomrú doma alebo v hospici (pomer šancí 4,15).</p>

<p>Voľba teda spravidla nie je medzi životom a smrťou, ale medzi <strong>dlhším časom stráveným čiastočne v nemocnici a kratším časom stráveným prevažne doma</strong>. Takto formulovaná otázka je pre pacienta zodpovedateľná — na rozdiel od otázky, či „chce dialýzu“.</p>

<h2>Individualizované nastavenie dialýzy</h2>

<p>Rozhodnutie nie je binárne. Aj u pacienta, ktorý dialýzu začne, možno paliatívny prístup uplatniť:</p>

<ul>
  <li><strong>Inkrementálny začiatok</strong> — dve procedúry týždenne pri zachovanej reziduálnej funkcii namiesto automatických troch.</li>
  <li><strong>Predpis vedený symptómami</strong>, nie cieľovým Kt/V, tam, kde cieľom už nie je maximalizovať prežívanie.</li>
  <li><strong>Realistické plánovanie cievneho prístupu.</strong> U pacienta s krátkou očakávanou prognózou môže byť centrálny katéter primeranejšou voľbou než opakované pokusy o fistulu s hojením trvajúcim mesiace. Ide o jeden z mála prípadov, keď je „horší“ prístup správnym rozhodnutím.</li>
  <li><strong>Vopred dohodnutá skúšobná doba.</strong> Časovo ohraničený pokus s vopred stanovenými kritériami hodnotenia mení ukončenie dialýzy z porážky na naplánovaný krok.</li>
</ul>

<h2>Depreskripcia</h2>

<p>Pacient s pokročilým ochorením obličiek užíva bežne desať a viac liekov. Časť z nich má prínos, ktorý sa dostaví o roky — a teda mimo očakávaného horizontu. Systematicky prehodnotiť treba najmä:</p>

<ul>
  <li><strong>statíny</strong>, ktorých prínos v primárnej prevencii sa prejaví po rokoch;</li>
  <li><strong>viazače fosfátov</strong>, ktoré predstavujú veľkú tabletovú záťaž pri cieli, ktorý už nie je aktuálny;</li>
  <li><strong>cieľové hodnoty hemoglobínu</strong> — pri paliatívnom cieli je rozhodujúca únava, nie čísla;</li>
  <li><strong>antihypertenzíva</strong>, ktoré v terminálnej fáze zvyšujú riziko pádov a ortostatickej hypotenzie;</li>
  <li><strong>diétne obmedzenia</strong>, ktoré v tejto fáze zhoršujú kvalitu života bez zodpovedajúceho prínosu.</li>
</ul>

<p>Depreskripcia nie je jednorazovým „odľahčením“, ale súčasťou pravidelnej revízie. Súvisí to aj s polyfarmáciou, ktorá je pri chronickej chorobe obličiek samostatným rizikovým faktorom.</p>

<h2>Ukončenie dialýzy</h2>

<p>Ukončenie dialýzy je v krajinách s vysokým príjmom častou cestou k úmrtiu — podľa registrových údajov ide rádovo o pätinu úmrtí dialyzovaných pacientov. Napriek tomu sa naň pripravuje málokedy.</p>

<p>Po ukončení nasleduje spravidla <strong>niekoľko dní</strong> (v publikovaných súboroch medián približne štyri až osem dní podľa modality). Tento krátky čas treba využiť, nie improvizovať. Plán má obsahovať:</p>

<ul>
  <li>lieky na bolesť, dýchavičnosť, úzkosť, nauzeu a dýchacie sekréty <strong>predpísané vopred</strong>, vrátane podania mimo perorálnej cesty;</li>
  <li>jasné určenie miesta starostlivosti — domov, hospic alebo lôžkové oddelenie — a zabezpečenie dostupnosti liekov na danom mieste;</li>
  <li>zrozumiteľné vysvetlenie priebehu rodine, vrátane toho, že narastajúca spavosť je očakávaným javom;</li>
  <li>dohodu, čo sa stane pri zhoršení, aby výsledkom nebolo neplánované volanie záchrannej služby.</li>
</ul>

<p>Ukončenie dialýzy nie je ukončením starostlivosti. Rozdiel medzi dobrým a zlým priebehom týchto dní spočíva takmer výlučne v tom, či bol plán pripravený vopred.</p>

<h2>Limity</h2>

<ul>
  <li>Ide o <strong>naratívny prehľad</strong>, nie o systematickú syntézu — sila dôkazov za jednotlivými tvrdeniami sa líši a výber literatúry nie je vopred definovaný.</li>
  <li>Prehľad opisuje <strong>rakúsky a stredoeurópsky kontext</strong>; dostupnosť hospicovej a domácej paliatívnej starostlivosti sa medzi krajinami výrazne líši a od nej závisí realizovateľnosť viacerých odporúčaní.</li>
  <li>Údaje o konzervatívnom postupe pochádzajú z <strong>observačných štúdií</strong> s malými súbormi a s výrazným výberovým skreslením — pacienti volia konzervatívny postup preto, že sú chorší, a randomizovaná štúdia v tejto oblasti je len ťažko uskutočniteľná.</li>
</ul>

<h2>Záver</h2>

<p>Prehľad neponúka nový nástroj, ale odstraňuje jednu prekážku: presvedčenie, že paliatívna starostlivosť je samostatná odbornosť, ktorá sa má odovzdať niekomu inému. Prognostika, rozhovor o cieľoch, depreskripcia a plánovanie záveru života sú nástrojmi s nízkym prahom, ktoré nefrológ používať vie — a spravidla je na ne v lepšom postavení než ktokoľvek iný, pretože pacienta pozná roky.</p>

<p>Paliatívny prístup pritom nie je alternatívou k aktívnej nefrologickej liečbe. Je spôsobom, ako rozhodovať o dialýze, o liekoch aj o prípadnom ukončení liečby tak, aby to zodpovedalo tomu, čo je pre konkrétneho pacienta dôležité. U krehkého osemdesiatnika to znamená položiť otázku skôr a inak — nie „začneme dialýzu?“, ale „čo chcete, aby sme týmto časom získali?“.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt">Keď pacient nechce hovoriť o svojich hodnotách</a> — skrytá prekážka spoločného rozhodovania.</li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Krehkosť pri CKD</a> — výživa, pohyb a funkčné hodnotenie.</li>
  <li><a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">CKD ako samostatný faktor polyfarmácie</a>.</li>
  <li><a href="article.php?slug=predialyzacna-edukacia-volba-peritonealnej-dialyzy">Predialyzačná edukácia a voľba modality</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Judith Böhm, Martin Windpessl, Matthias Huemer, Eva K. Masel, Marcus Säemann, Andreas Kronbichler, Balazs Odler.</strong> <em>Integrating palliative care into routine nephrology practice.</em> Nephrology Dialysis Transplantation. 2026 Aug 3 (online ahead of print). doi: 10.1093/ndt/gfag170. <a href="https://pubmed.ncbi.nlm.nih.gov/42545759/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1093/ndt/gfag170" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Wouter R. Verberne, A. B. M. Tom Geers, Wilbert T. Jellema, Hieronymus H. Vincent, Johannes J. M. van Delden, Willem Jan W. Bos.</strong> <em>Comparative Survival among Older Adults with Advanced Kidney Disease Managed Conservatively Versus with Dialysis.</em> Clinical Journal of the American Society of Nephrology. 2016;11(4):633–640. doi: 10.2215/CJN.07510715. <a href="https://pubmed.ncbi.nlm.nih.gov/26988748/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Rachel C. Carson, Maciej Juszczak, Andrew Davenport, Aine Burns.</strong> <em>Is maximum conservative management an equivalent treatment option to dialysis for elderly patients with significant comorbid disease?</em> Clinical Journal of the American Society of Nephrology. 2009;4(10):1611–1619. doi: 10.2215/CJN.00510109. <a href="https://pubmed.ncbi.nlm.nih.gov/19808244/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje, kompletné autorstvo aj obsah prehľadu — naliehavosť integrácie paliatívnych zásad, nedostatočné praktické zavedenie napriek podpore v odporúčaniach, všetkých šesť pokrytých oblastí a záver o použiteľnosti nástrojov s nízkym prahom bez špecializovaného výcviku — boli overené v zázname PubMed a Europe PMC. Plný text prehľadu je za platobnou bariérou vydavateľa a nebol sprístupnený; konkrétne algoritmy ani odporúčacie body z plnej verzie tu preto nie sú citované. Číselné údaje o prežívaní pri konzervatívnom postupe (3,1 oproti 1,5 roka; 2,1 oproti 1,4 roka pri veku ≥ 80 rokov; 1,8 oproti 1,0 roka pri Daviesovom skóre ≥ 3; 37,8 oproti 13,9 mesiaca; pomer šancí 4,15 pre úmrtie doma alebo v hospici) pochádzajú z dvoch samostatne overených štúdií a v prehľade sa v tejto podobe neuvádzajú. Prekvapujúca otázka, praktické postupy pri individualizácii dialýzy, zoznam liekov na depreskripciu, plán pri ukončení dialýzy a údaje o podiele ukončenia dialýzy na úmrtiach a o dĺžke prežívania po ňom sú <strong>vlastným odborným spracovaním</strong> opretým o etablované poznatky.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_paliativna-starostlivost-nefrologia-krehki-starsi-eskd_article',
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
