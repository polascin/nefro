<?php
/**
 * add_tirzepatid-mounjaro-fda-kardiovaskularne-riziko-t2d-surpass-cvot_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: FDA indikačný rámec tirzepatidu (Mounjaro) na zníženie
 * kardiovaskulárneho rizika pri diabete 2. typu (SURPASS-CVOT).
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_tirzepatid-mounjaro-fda-kardiovaskularne-riziko-t2d-surpass-cvot_article.php"
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
    'title'        => 'Mounjaro (tirzepatid): nový indikačný rámec FDA na zníženie kardiovaskulárneho rizika pri diabete 2. typu – čo z toho vyplýva pre prax',
    'slug'         => 'tirzepatid-mounjaro-fda-kardiovaskularne-riziko-t2d-surpass-cvot',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'FDA v USA schválila tirzepatid (Mounjaro) na zníženie rizika MACE pri diabete 2. typu s vysokým kardiovaskulárnym rizikom. SURPASS-CVOT preukázala neinferioritu voči dulaglutidu, nie superioritu; EMA indikáciu neschválila.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Americký indikačný rámec tirzepatidu (Mounjaro) sa v auguste 2026 rozšíril o zníženie rizika závažných nežiaducich kardiovaskulárnych príhod. Podkladom je aktívne kontrolovaná štúdia SURPASS-CVOT, ktorá preukázala neinferioritu voči dulaglutidu, nie nadradenosť. Ide o označenie FDA; výbor CHMP túto indikáciu v EÚ neschválil.</em></p>

<p>FDA 27. augusta 2026 (doplnok s44 v databáze Drugs@FDA; tlačová správa výrobcu 28. augusta 2026) schválila liek <strong>Mounjaro</strong> (tirzepatid) na zníženie rizika závažných nežiaducich kardiovaskulárnych príhod (MACE) u dospelých s diabetom 2. typu, ktorí sú na tieto príhody vo vysokom riziku. Tirzepatid je duálny agonista receptorov GIP (glukózodependentný inzulínotropný polypeptid) a GLP-1 (glukagónu podobný peptid 1) a podáva sa podkožne raz týždenne.</p>

<p>Pre slovenskú prax je táto správa dôležitá aj tým, čím nie je. Schválenie FDA <strong>nie je</strong> automaticky indikačným rámcom EMA ani ŠÚKL. Výbor CHMP v júni 2026 novú kardiovaskulárnu indikáciu neodporučil; relevantné údaje sa majú uviesť v informáciách o lieku, bez rozšírenia bodu 4.1.</p>

<h2>Čo presne hovorí americký súhrn údajov</h2>

<p>Verejný americký súhrn údajov o lieku (USPI, revízia 08/2026) uvádza dve indikácie Mounjaro:</p>

<ul>
  <li>ako doplnok k diéte a cvičeniu na zlepšenie glykemickej kontroly u dospelých a pediatrických pacientov od 10 rokov s diabetom 2. typu;</li>
  <li>na zníženie rizika závažných nežiaducich kardiovaskulárnych príhod – kardiovaskulárne úmrtie, nefatálny infarkt myokardu alebo nefatálna cievna mozgová príhoda – <strong>u dospelých s diabetom 2. typu, ktorí sú na tieto príhody vo vysokom riziku</strong>.</li>
</ul>

<p>Označenie teda <strong>nevyžaduje výslovne už prítomné aterosklerotické kardiovaskulárne ochorenie (ASKVO)</strong>. Štúdia SURPASS-CVOT, o ktorú sa indikácia opiera, však randomizovala práve dospelých s diabetom 2. typu a <strong>už etablovaným ASKVO</strong>. Tento rozdiel medzi znením indikačného textu a skúšanou populáciou treba pri čítaní súhrnu vnímať.</p>

<p>Indikácia sa týka značky <strong>Mounjaro</strong>, nie značky Zepbound. V USA je Zepbound samostatný prípravok s tou istou účinnou látkou na dlhodobú redukciu hmotnosti a na stredne ťažké až ťažké obštrukčné spánkové apnoe u dospelých s obezitou. Tieto označenia sa nesmú miešať s kardiovaskulárnou indikáciou Mounjaro. Pediatrické použitie od 10 rokov platí pre glykemickú indikáciu, nie pre MACE.</p>

<h2>SURPASS-CVOT: aktívny komparátor, nie placebo</h2>

<p>Primárna publikácia v <em>New England Journal of Medicine</em> (PMID 41406444, doi 10.1056/NEJMoa2505928) opisuje SURPASS-CVOT (NCT04255433) ako aktívne kontrolovanú, dvojito zaslepenú, paralelne usporiadanú štúdiu fázy 3 s testom neinferiority. Pacienti s diabetom 2. typu a ASKVO boli v pomere 1 : 1 randomizovaní na podkožný tirzepatid raz týždenne (až 15 mg, alebo maximálna tolerovaná dávka) alebo na dulaglutid 1,5 mg raz týždenne. Dulaglutid je agonista receptora GLP-1 s už preukázaným znížením kardiovaskulárnych príhod; porovnanie teda nie je voči placebu.</p>

<p>Randomizovaných bolo 13 299 pacientov; 134 bolo následne vylúčených, lebo nespĺňali vstupné kritériá. Modifikovaná populácia podľa úmyslu liečiť (mITT) mala 6 586 pacientov v skupine s tirzepatidom a 6 579 v skupine s dulaglutidom. Priemerný vek bol 64,1 ± 8,8 roka, ženy tvorili 29,0 %, priemerný index telesnej hmotnosti 32,6 ± 5,5, priemerný HbA1c 8,4 ± 0,9 % a priemerné trvanie diabetu 14,7 ± 8,8 roka.</p>

<p>Americký súhrn údajov uvádza medián sledovania 210,1 týždňa (približne štyri roky) v súbore všetkých randomizovaných a liečených účastníkov. Štúdia bola udalosťami riadená a trvala približne päť rokov; medián sledovania nie je totožný s dĺžkou účasti každého pacienta.</p>

<div class="table-responsive" role="region" aria-label="Základné parametre štúdie SURPASS-CVOT podľa primárnej publikácie NEJM" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Údaj</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Dizajn</th>
      <td>aktívne kontrolovaná, dvojito zaslepená, paralelná štúdia fázy 3 s testom neinferiority, pomer 1 : 1</td>
    </tr>
    <tr>
      <th scope="row">Populácia</th>
      <td>dospelí s diabetom 2. typu a etablovaným ASKVO</td>
    </tr>
    <tr>
      <th scope="row">Liečba</th>
      <td>tirzepatid podkožne raz týždenne až 15 mg oproti dulaglutidu 1,5 mg raz týždenne</td>
    </tr>
    <tr>
      <th scope="row">Randomizovaní / mITT</th>
      <td>13 299 randomizovaných; 134 vylúčených; mITT 6 586 oproti 6 579</td>
    </tr>
    <tr>
      <th scope="row">Primárny ukazovateľ</th>
      <td>MACE-3: kardiovaskulárne úmrtie, infarkt myokardu alebo cievna mozgová príhoda</td>
    </tr>
    <tr>
      <th scope="row">Neinferiorita</th>
      <td>horná hranica 95,3 % intervalu spoľahlivosti pomeru rizík &lt; 1,05; superiorita pri hodnote &lt; 1,00</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Primárny výsledok: neinferiorita, nie superiorita</h2>

<p>Primárna príhoda MACE-3 nastala u 801 pacientov (12,2 %) v skupine s tirzepatidom a u 862 pacientov (13,1 %) v skupine s dulaglutidom. Pomer rizík bol 0,92 (95,3 % interval spoľahlivosti 0,83–1,01). Test neinferiority bol významný (P = 0,003), test superiority nie (P = 0,09).</p>

<p>Pomer rizík 0,92 zodpovedá približne 8 % nižšiemu hazardu. Tento údaj treba čítať ako <strong>pozorovaný nižší výskyt príhod, nie ako preukázanú nadradenosť</strong>: horná hranica 95,3 % intervalu spoľahlivosti prekročila 1. Absolútny rozdiel bol 0,9 percentuálneho bodu (12,2 % oproti 13,1 %).</p>

<p>Klinický význam tohto usporiadania je praktický. Dulaglutid už má kardiovaskulárny dôkaz; SURPASS-CVOT ukázala, že tirzepatid v skúšanej populácii <strong>nezostal za ním</strong> v kompozite MACE-3. Neukázala, že je v tomto kompozite lepší. Interpretácia „prvý duálny agonista GIP/GLP-1 so znížením kardiovaskulárneho rizika“ preto platí v americkom regulačnom zmysle neinferiority voči aktívnemu komparátoru, nie ako dôkaz superiority voči dulaglutidu ani voči placebu.</p>

<div class="table-responsive" role="region" aria-label="Primárny ukazovateľ MACE-3 v SURPASS-CVOT, populácia mITT podľa NEJM" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Tirzepatid (n = 6 586)</th>
      <th scope="col">Dulaglutid (n = 6 579)</th>
      <th scope="col">Pomer rizík (95,3 % IS)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">MACE-3</th>
      <td>801 (12,2 %)</td>
      <td>862 (13,1 %)</td>
      <td>0,92 (0,83–1,01); P = 0,003 pre neinferioritu; P = 0,09 pre superioritu</td>
    </tr>
  </tbody>
</table>
</div>

<p>Americký súhrn údajov uvádza v súbore všetkých randomizovaných a liečených (po 6 647 v ramene) výskyt 12,1 % oproti 13,0 % pri rovnakom pomere rizík 0,92 (0,83–1,01). Rozdiel voči 12,2 % a 13,1 % vyplýva z inej analytickej populácie, nie z iného záveru štúdie.</p>

<h2>Bezpečnosť</h2>

<p>V otvorenom abstrakte NEJM sa výskyt nežiaducich udalostí javil v oboch skupinách podobný, gastrointestinálne nežiaduce účinky však boli častejšie pri tirzepatide. Podľa amerického súhrnu a tlačovej správy výrobcu išlo prevažne o nauzeu, hnačku, zníženú chuť do jedla, vracanie a zápchu, spravidla mierne až stredne ťažké a viazané najmä na obdobie titrácie. Tieto doplnkové formulácie abstrakt NEJM neuvádza; opierajú sa o označenie lieku.</p>

<p>Z nefrologického hľadiska ostáva relevantné riziko dehydratácie a akútneho poškodenia obličiek pri vracaní alebo hnačke, osobitne pri súbežnom diuretiku, blokáde RAS alebo inhibítore SGLT2. Ide o triedové upozornenie inkretínovej liečby, nie o nový signál SURPASS-CVOT.</p>

<h2>Obličkové ukazovatele z tohto reportu nevyplývajú</h2>

<p>Otvorený abstrakt primárnej publikácie SURPASS-CVOT v NEJM <strong>neuvádza obličkové ukazovatele</strong> – ani kompozit progresie CKD, ani zmenu eGFR, ani albuminúriu. Z tohto primárneho reportu preto <strong>nemožno tvrdiť prínos na spomalenie progresie CKD</strong> a kardiovaskulárnu indikáciu FDA nemožno čítať ako obličkovú indikáciu.</p>

<p>Exploračné obličkové analýzy programu SURPASS, vrátane predšpecifikovanej analýzy SURPASS-CVOT, sú spracované osobitne a nie sú podkladom tohto amerického indikačného textu. Najpevnejší randomizovaný obličkový dôkaz v triede agonistov receptora GLP-1 ostáva štúdia FLOW so semaglutidom oproti placebu u pacientov s diabetom 2. typu a už prítomnou CKD – iná otázka, iný komparátor, iná populácia.</p>

<h2>EMA a Slovensko: americké označenie sa neprenáša</h2>

<p>Výbor pre humánne lieky (CHMP) na zasadnutí 22.–25. júna 2026 uzavrel posúdenie žiadosti o rozšírenie použitia Mounjaro na zníženie rizika závažných kardiovaskulárnych príhod u dospelých s diabetom 2. typu a už prítomným kardiovaskulárnym ochorením. <strong>Novú indikáciu neodporučil.</strong> Dohodol sa na uvedení predložených údajov v informáciách o lieku, aby mali zdravotnícki pracovníci k dispozícii aktuálne dáta, bez zmeny indikačného bodu.</p>

<p>Platná indikácia EMA pre Mounjaro ostáva liečba nedostatočne kontrolovaného diabetu 2. typu od 10 rokov ako doplnok k diéte a cvičeniu a manažment hmotnosti u dospelých s obezitou alebo nadváhou a pridruženými ochoreniami. V EÚ teda Mounjaro pokrýva aj hmotnosť; značka Zepbound sa v tomto rámci nepoužíva. Rozhodnutie FDA samo osebe <strong>neopravňuje predpisovať tirzepatid na Slovensku na zníženie MACE</strong>. Úhradový a indikačný rámec určuje ŠÚKL a platný súhrn charakteristických vlastností lieku.</p>

<h2>Čo z toho vyplýva v ambulancii</h2>

<p>Pre pacienta s diabetom 2. typu a ASKVO, ktorý už má alebo zvažuje inkretínovú liečbu, SURPASS-CVOT hovorí predovšetkým toto: tirzepatid v priamom porovnaní s dulaglutidom 1,5 mg nesklamal v kompozite MACE-3 a metabolicky ostáva veľmi účinný. Nehovorí, že má nahradiť dulaglutid, semaglutid alebo inhibítor SGLT2 „pretože je kardiovaskulárne lepší“. Superiorita v MACE-3 preukázaná nebola.</p>

<p>Výber ostáva fenotypový: glykémia, hmotnosť, ASKVO, srdcové zlyhávanie, CKD, tolerancia, dostupnosť a – na Slovensku – indikačné obmedzenie a úhrada. Inhibítor SGLT2 s obličkovým alebo srdcovým dôkazom sa kardiovaskulárnym označením tirzepatidu v USA nestráca. Rovnako sa nestráca dôkaz FLOW pre semaglutid pri CKD.</p>

<p>Ak sa liečba začína alebo tituje, treba vopred hovoriť o gastrointestinálnej tolerancii, o riziku objemovej deplecie a o tom, že americká MACE indikácia zatiaľ nie je európskym indikačným textom.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=tirzepatid-oblickove-vysledky-surpass-nefrologia">Tirzepatid a obličkové výsledky v programe SURPASS: čo znamenajú pre nefrológiu</a></li>
  <li><a href="article.php?slug=tirzepatid-diabeticka-retinopatia-surpass-cvot">Tirzepatid nezvýšil riziko diabetickej retinopatie u rizikových pacientov</a></li>
  <li><a href="article.php?slug=vyber-sglt2-glp1-dualne-agonisty-kardiorenalne-riziko">Výber a kombinovanie inhibítorov SGLT2, agonistov GLP-1 a duálnych agonistov pri diabete 2. typu s kardiorenálnym rizikom</a></li>
  <li><a href="article.php?slug=glp1-lieky-renalne-benefity-dokazy-prax-nefrologia">Sú GLP-1 lieky už „lieky na obličky“? Renálne benefity v dôkazoch posledných rokov</a></li>
  <li><a href="article.php?slug=semaglutid-ckd-porovnanie-glp1-realna-prax">Semaglutid a riziko CKD pri diabete 2. typu: porovnanie agonistov GLP-1 v reálnej praxi</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">CKD pri diabete: skríning a vrstvená kardiorenálna liečba</a></li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Nicholls SJ, Pavo I, Bhatt DL, et al. Cardiovascular Outcomes with Tirzepatide versus Dulaglutide in Type 2 Diabetes. <em>N Engl J Med</em>. 2025;393(24):2409–2420. PMID: 41406444. doi: <a href="https://doi.org/10.1056/NEJMoa2505928" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2505928</a>.</em></p>

<p><em><strong>Ďalšie zdroje:</strong> U.S. Food and Drug Administration / Eli Lilly. MOUNJARO (tirzepatide) prescribing information, revízia 08/2026, indikácie a časť 14.6 SURPASS-CVOT. <a href="https://pi.lilly.com/us/mounjaro-uspi.pdf" target="_blank" rel="noopener noreferrer">pi.lilly.com</a>; Drugs@FDA, NDA 215866, doplnok s44 (27. 8. 2026). <a href="https://www.accessdata.fda.gov/scripts/cder/daf/index.cfm?event=overview.process&amp;ApplNo=215866" target="_blank" rel="noopener noreferrer">accessdata.fda.gov</a>; Eli Lilly. FDA approves Lilly’s Mounjaro (tirzepatide) to reduce cardiovascular risk in adults with type 2 diabetes. 28. 8. 2026. <a href="https://investor.lilly.com/news-releases/news-release-details/fda-approves-lillys-mounjaro-tirzepatide-reduce-cardiovascular" target="_blank" rel="noopener noreferrer">investor.lilly.com</a>; European Medicines Agency. Meeting highlights from the CHMP, 22–25 June 2026. <a href="https://www.ema.europa.eu/en/news/meeting-highlights-committee-medicinal-products-human-use-chmp-22-25-june-2026" target="_blank" rel="noopener noreferrer">ema.europa.eu</a>; European Medicines Agency. Mounjaro EPAR – therapeutic indication. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/mounjaro" target="_blank" rel="noopener noreferrer">ema.europa.eu</a>. Spravodajský prehľad Medscape (Larkin) slúžil len ako podnet, nie ako spracovaný vedecký zdroj.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_tirzepatid-mounjaro-fda-kardiovaskularne-riziko-t2d-surpass-cvot_article',
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
