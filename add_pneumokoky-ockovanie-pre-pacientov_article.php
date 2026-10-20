<?php

/** Publikačný skript popularizačného článku (sekcia „Pre pacientov“). */
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
    'title' => 'Očkovanie proti pneumokokom, keď máte chorobu obličiek alebo chodíte na dialýzu',
    'slug' => 'pneumokoky-ockovanie-pre-pacientov',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Pneumokoky môžu u ľudí s chorobou obličiek spôsobiť ťažký zápal pľúc alebo otravu krvi. Očkovanie je jedna z mála vecí, ktoré riziko znížia vopred. Čo potrebujete vedieť.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/pneumokoky-pre-pacientov-ochrana.webp" type="image/webp">
    <img src="img/pneumokoky-pre-pacientov-ochrana.png" alt="Oblička v teplých koralových tónoch obklopená súvislou zlatistou ochrannou kupolou, od ktorej sa odrážajú drobné tyrkysové častice" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračný obrázok. Očkovanie nevytvorí okolo vás neviditeľný štít, ale výrazne zníži pravdepodobnosť, že sa z bežnej infekcie stane ťažký stav.</figcaption>
</figure>

<p>Keď máte chorobu obličiek, počúvate veľa odporúčaní: čo jesť, koľko piť, ktoré lieky brať. Očkovanie v tom zozname často zapadne. Pritom patrí medzi tie málo vecí, ktoré sa dajú urobiť <strong>vopred</strong>, jednorazovo, a ktoré nijako nezasahujú do vašej ostatnej liečby.</p>

<p>Tento článok vysvetľuje, prečo je očkovanie proti pneumokokom pri chorobe obličiek dôležitejšie než u bežného človeka, aké vakcíny existujú a čo si pripraviť na najbližšiu kontrolu.</p>

<h2>Čo sú pneumokoky</h2>

<p>Pneumokok (odborne <em>Streptococcus pneumoniae</em>) je baktéria. Veľa ľudí ju nosí v nose a v hrdle bez akýchkoľvek ťažkostí. Problém nastane, keď sa dostane tam, kde nemá byť.</p>

<p>Môže spôsobiť:</p>

<ul>
  <li><strong>zápal pľúc</strong> (pneumóniu) — najčastejšiu a najznámejšiu formu,</li>
  <li><strong>otravu krvi</strong> (bakteriémiu) — keď sa baktéria dostane do krvného obehu,</li>
  <li><strong>zápal mozgových blán</strong> (meningitídu) — najzávažnejšiu formu.</li>
</ul>

<p>Posledné dve formy lekári spoločne nazývajú <strong>invazívne pneumokokové ochorenie</strong>. Sú zriedkavejšie než zápal pľúc, ale oveľa nebezpečnejšie — a práve proti nim očkovanie chráni najlepšie.</p>

<h2>Prečo je to pri chorobe obličiek inak</h2>

<p>Pri chorobe obličiek sa spájajú dve nepríjemnosti naraz.</p>

<p><strong>Po prvé, riziko je vyššie.</strong> Veľká americká štúdia porovnala, ako často invazívne pneumokokové ochorenie vzniká pri rôznom stupni poškodenia obličiek:</p>

<ul>
  <li>pri stredne pokročilej chorobe obličiek je riziko približne <strong>1,2-násobné</strong> oproti bežnej populácii,</li>
  <li>pri zlyhaní obličiek alebo na dialýze je <strong>3,7-násobné</strong>.</li>
</ul>

<p><strong>Po druhé, ochrana po očkovaní vydrží kratšie.</strong> Telo si po očkovaní vytvorí ochranné protilátky. Pri chorobe obličiek je ich tvorba slabšia než u zdravého človeka. A ak chodíte na dialýzu, časť protilátok sa navyše počas samotnej dialýzy postupne z krvi odstráni.</p>

<p>Mohlo by sa zdať, že keď očkovanie funguje slabšie, nemá zmysel. Je to presne naopak — je to dôvod <strong>neodkladať ho</strong>.</p>

<figure>
  <picture>
    <source srcset="img/pneumokoky-pre-pacientov-vcas.webp" type="image/webp">
    <img src="img/pneumokoky-pre-pacientov-vcas.png" alt="Tri obličky vedľa seba: prvá v jasnom súvislom zlatistom kruhu, druhá v slabšom a tretia už len v tenkom prerušovanom kruhu" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračný obrázok. Čím skôr v priebehu choroby obličiek sa očkuje, tým lepšiu ochranu telo dokáže vytvoriť.</figcaption>
</figure>

<p>Najlepší čas na očkovanie je <strong>skôr, než sa začne dialýza</strong>. Vtedy imunitný systém reaguje ešte najlepšie. Ak už na dialýze ste, neznamená to, že je neskoro — znamená to, že s tým netreba ďalej otáľať.</p>

<h2>Koho sa očkovanie týka</h2>

<p>Na Slovensku to upravuje vyhláška Ministerstva zdravotníctva. Očkovanie proti pneumokokovým invazívnym infekciám sa odporúča dispenzarizovaným osobám (teda tým, ktorých lekár pravidelne sleduje) <strong>bez ohľadu na vek</strong>, ak majú závažné chronické ochorenie — a obličkové ochorenia sú v nej výslovne uvedené, konkrétne nefrotický syndróm a zlyhanie obličiek.</p>

<p>To „bez ohľadu na vek“ je dôležité. Ak máte 35 rokov a chodíte na dialýzu, patríte do rizikovej skupiny rovnako ako sedemdesiatročný človek. Nemusíte čakať na žiadnu vekovú hranicu.</p>

<p>Očkovanie sa odporúča najmä ak:</p>

<ul>
  <li>máte pokročilú chronickú chorobu obličiek,</li>
  <li>chodíte na dialýzu (hemodialýzu aj peritoneálnu),</li>
  <li>máte transplantovanú obličku,</li>
  <li>máte nefrotický syndróm,</li>
  <li>užívate lieky, ktoré tlmia imunitu.</li>
</ul>

<h2>Dva druhy vakcín a v čom sa líšia</h2>

<figure>
  <picture>
    <source srcset="img/pneumokoky-pre-pacientov-typy-vakcin.webp" type="image/webp">
    <img src="img/pneumokoky-pre-pacientov-typy-vakcin.png" alt="Vľavo žltá guľa s pevne ukotvenými cukrovými reťazcami, vpravo voľne rozsypané tyrkysové reťazce bez spoločného jadra" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračný obrázok. Vľavo zjednodušene konjugovaná vakcína — cukry sú pevne naviazané na bielkovinové jadro. Vpravo polysacharidová vakcína — samotné cukry bez jadra.</figcaption>
</figure>

<p>Nemusíte si pamätať názvy, ale pomôže vám vedieť, že existujú dva typy. Lekár medzi nimi vyberá podľa toho, čo ste už dostali.</p>

<p><strong>Konjugovaná vakcína</strong> (skratka PCV, napríklad PCV15, PCV20 alebo PCV21). Cukry z povrchu baktérie sú v nej pevne naviazané na bielkovinu. Vďaka tomu si imunitný systém vytvorí <em>pamäť</em> — zapamätá si baktériu na dlhšie.</p>

<p><strong>Polysacharidová vakcína</strong> (skratka PPSV23). Obsahuje cukry zo 23 typov pneumokoka, ale bez bielkovinového jadra. Pokrýva viac typov baktérie, imunitná pamäť po nej však nie je taká trvalá. Používa sa preto zvyčajne ako <em>doplnenie</em> po konjugovanej vakcíne.</p>

<p>Mnohí ľudia s chorobou obličiek potrebujú kombináciu oboch typov. Niektorým stačí jedna dávka novšej konjugovanej vakcíny a séria je kompletná. Preto neexistuje jedna schéma pre všetkých.</p>

<h2>Prečo je dôležité vedieť, čo ste už dostali</h2>

<p>Toto je najpraktickejšia vec v celom článku. Lekár nevie zvoliť správny postup, kým nevie:</p>

<ul>
  <li><strong>ktorú vakcínu</strong> ste dostali (konjugovanú alebo polysacharidovú, a ktorú presne),</li>
  <li><strong>kedy</strong> ste ju dostali.</li>
</ul>

<p>Od toho závisí nielen to, ktorá vakcína príde na rad, ale aj <strong>ako dlho treba počkať</strong>. Odstup medzi dvoma dávkami môže byť osem týždňov alebo celý rok — podľa toho, čo ste už dostali a do ktorej rizikovej skupiny patríte. Práve pri chorobe obličiek býva tento odstup kratší než u iných chronických pacientov.</p>

<p>Ak si nepamätáte alebo nemáte doklad, nevadí a nie je to prekážka. Lekár vtedy postupuje tak, ako keby ste očkovaní neboli. Je to bezpečné — len možno dostanete dávku, ktorú by ste inak nepotrebovali.</p>

<h2>Čo si pripraviť na kontrolu</h2>

<ol>
  <li><strong>Očkovací preukaz</strong> alebo akýkoľvek záznam o očkovaní.</li>
  <li><strong>Zoznam liekov</strong>, ktoré užívate, vrátane voľnopredajných a výživových doplnkov.</li>
  <li><strong>Informáciu o tom, či a kedy</strong> ste už boli očkovaní proti pneumokokom — aj keď si nie ste istí, povedzte to.</li>
  <li><strong>Otázku</strong>, ak máte v pláne transplantáciu obličky. Očkovanie sa vtedy rieši <em>pred</em> zaradením na čakaciu listinu, pretože po transplantácii už niektoré vakcíny dostať nemôžete.</li>
</ol>

<h2>Kedy očkovanie odložiť</h2>

<p>Sú situácie, keď lekár termín posunie. Napríklad pri akútnej infekcii s horúčkou alebo krátko po prepustení z nemocnice. Nejde o zrušenie očkovania, iba o výber vhodnejšieho termínu. Preto sa oplatí po takejto príhode sám pripomenúť, aby na to nikto nezabudol.</p>

<p>Očkovanie proti pneumokokom sa dá podať kedykoľvek počas roka — nie je viazané na sezónu ako očkovanie proti chrípke.</p>

<h2>Čo môžete čakať po očkovaní</h2>

<p>Najčastejšie reakcie sú mierne a rýchlo odznejú:</p>

<ul>
  <li>bolesť, začervenanie alebo opuch v mieste vpichu,</li>
  <li>mierne zvýšená teplota,</li>
  <li>únava alebo pocit „dolámanosti“ na deň či dva.</li>
</ul>

<p>Ak by ste mali výraznú alebo nezvyčajnú reakciu — vysokú horúčku, ťažkosti s dýchaním, vyrážku po tele alebo opuch tváre — kontaktujte lekára.</p>

<h2>Buďme úprimní: čo o tom vieme a čo nie</h2>

<p>Patrí sa povedať aj druhú stranu. Vieme bezpečne, že očkovanie vyvolá u ľudí s chorobou obličiek tvorbu protilátok, hoci slabšiu a kratšie trvajúcu než u zdravých. Vieme tiež, že riziko závažnej pneumokokovej infekcie je pri chorobe obličiek vyššie.</p>

<p>Čo zatiaľ <strong>nemáme</strong>, sú veľké štúdie, ktoré by priamo dokázali, o koľko očkovanie zníži počet úmrtí práve u dialyzovaných pacientov. Odporúčanie sa teda opiera o kombináciu vyššieho rizika, dobrej znášanlivosti vakcín a nepriamych údajov — nie o nezvratný dôkaz.</p>

<p>Je to poctivý dôvod očkovanie odporučiť, ale nie dôvod sľubovať viac, než vieme. Ak máte pochybnosti, prediskutujte ich so svojím nefrológom; sú legitímne.</p>

<h2>Zhrnutie v piatich vetách</h2>

<ul>
  <li>Pri zlyhaní obličiek a na dialýze je riziko závažnej pneumokokovej infekcie takmer štvornásobné.</li>
  <li>Ochrana po očkovaní vydrží pri chorobe obličiek kratšie, preto sa oplatí očkovať skoro.</li>
  <li>Na Slovensku sa očkovanie odporúča pri obličkovom ochorení bez ohľadu na vek.</li>
  <li>Existujú dva typy vakcín; ktorý dostanete a kedy, závisí od toho, čo ste už mali.</li>
  <li>Najužitočnejšie, čo môžete urobiť, je priniesť na kontrolu očkovací preukaz.</li>
</ul>

<hr>

<p><em><strong>Upozornenie:</strong> Tento článok má informačný charakter a <strong>nenahrádza vyšetrenie ani poradenstvo u lekára</strong>. O tom, ktoré očkovanie je pre vás vhodné a kedy, rozhoduje váš ošetrujúci lekár podľa vášho zdravotného stavu a očkovacej anamnézy.</em></p>

<p><em><strong>Zdroje a ďalšie čítanie:</strong><br>
Odborná verzia tohto textu s presnými schémami a odkazmi na pramene: <a href="article.php?slug=pneumokokove-ockovanie-ckd-dialyza">Očkovanie proti pneumokokom pri chronickej chorobe obličiek a na dialýze</a>.<br>
Vyhláška Ministerstva zdravotníctva SR č. 585/2008 Z. z. o prevencii a kontrole prenosných ochorení, § 9 ods. 2 a príloha č. 3, v znení účinnom od 1. júna 2025 — <a href="https://www.slov-lex.sk/pravne-predpisy/SK/ZZ/2008/585/" target="_blank" rel="noopener noreferrer">znenie na Slov-Lex</a>.<br>
National Kidney Foundation: <a href="https://www.kidney.org/kidney-topics/pneumococcal-disease-and-chronic-kidney-disease" target="_blank" rel="noopener noreferrer">Pneumococcal Disease and Chronic Kidney Disease</a>.<br>
Centers for Disease Control and Prevention: <a href="https://www.cdc.gov/pneumococcal/hcp/vaccine-recommendations/index.html" target="_blank" rel="noopener noreferrer">Pneumococcal Vaccine Recommendations</a>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'popularne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_pneumokoky-ockovanie-pre-pacientov_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia popularizačného článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
?>
