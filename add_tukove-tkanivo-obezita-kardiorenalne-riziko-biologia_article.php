<?php

/**
 * add_tukove-tkanivo-obezita-kardiorenalne-riziko-biologia_article.php
 * Biologia tukoveho tkaniva a kardiorenalne riziko pri obezite.
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
    'title'        => 'Tukové tkanivo nie je pasívna zásobáreň: čo jeho biológia hovorí o obezite a kardiorenálnom riziku',
    'slug'         => 'tukove-tkanivo-obezita-kardiorenalne-riziko-biologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Rozloženie tuku a jeho funkčná kvalita určujú metabolické riziko viac než index telesnej hmotnosti. Prehľad poznatkov o viscerálnom a podkožnom tuku, komunikácii cez mikroRNA a termogenéze — s dôrazom na to, čo z toho pre prax zatiaľ nevyplýva.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Metabolické riziko neurčuje len celkové množstvo tuku, ale aj jeho rozloženie, schopnosť bezpečne ukladať energetický nadbytok a endokrinná aktivita. Nové výskumné smery — pohlavne špecifické profily tukového tkaniva, komunikácia so srdcom cez mikroRNA a ovplyvňovanie termogenézy výživou — sú biologicky zaujímavé. Pre klinickú prax však zatiaľ nepredstavujú podklad na zmenu postupov.</em></p>

<p>Obezita sa tradične posudzuje podľa telesnej hmotnosti a indexu telesnej hmotnosti. Takýto prístup je praktický, ale biologicky neúplný. Význam má aj anatomické rozloženie tuku, schopnosť tukového tkaniva bezpečne ukladať energetický nadbytok, jeho zápalová a endokrinná aktivita, pohlavie, vek a interakcia s ďalšími orgánmi.</p>

<p><strong>Metodická poznámka na úvod:</strong> podstatná časť nižšie uvedených nových poznatkov pochádza z prednášok na Medzinárodnom kongrese o obezite 2026, teda z <strong>predbežných, plne nerecenzovaných údajov</strong>, prípadne z bunkových a zvieracích modelov. Kongresové výsledky som nemohol overiť proti publikovanému textu. Uvádzam ich preto ako smerovanie výskumu, nie ako podklad na klinické rozhodovanie.</p>

<h2>Tukové tkanivo ako endokrinný orgán</h2>

<p>Tukové tkanivo nie je pasívnym skladom triacylglycerolov. Je metabolicky aktívnym orgánom, ktorý ukladá a mobilizuje energiu, uvoľňuje adipokíny, cytokíny a mastné kyseliny, produkuje extracelulárne vezikuly a mikroRNA, ovplyvňuje citlivosť na inzulín, reguluje zápalové a cievne procesy, podieľa sa na termogenéze a komunikuje so svalmi, pečeňou, pankreasom, srdcom, obličkami a mozgom.</p>

<p>Účinok jeho produktov závisí od typu a lokalizácie depa, energetickej bilancie, veľkosti adipocytov a prítomnosti hypoxie, fibrózy a zápalovej infiltrácie.</p>

<p>Funkčne zdravé tukové tkanivo dokáže energetický nadbytok ukladať s relatívne malým poškodením ostatných orgánov. Ak sa jeho skladovacia kapacita vyčerpá, adipocyty hypertrofujú, vzniká lokálna hypoxia, zápal, fibróza a zvýšené uvoľňovanie mastných kyselín. Lipidy sa následne ukladajú v pečeni, kostrovom svalstve, pankrease a srdci, kde podporujú lipotoxicitu a inzulínovú rezistenciu.</p>

<h2>Množstvo tuku nie je totožné s jeho účinkom</h2>

<h3>Viscerálne tukové tkanivo</h3>

<p>Nadmerné množstvo viscerálneho tuku sa spája s vyšším rizikom inzulínovej rezistencie, diabetu 2. typu, aterogénnej dyslipidémie, artériovej hypertenzie, steatotickej choroby pečene spojenej s metabolickou dysfunkciou, kardiovaskulárnych ochorení a chronickej choroby obličiek.</p>

<p>Túto asociáciu nevysvetľuje jediný mechanizmus. Podieľa sa na nej zvýšený tok voľných mastných kyselín do portálneho obehu, zápalová aktivita, endotelová dysfunkcia, nepriaznivý profil adipokínov — a tiež skutočnosť, že viscerálna adipozita je <em>markerom</em> širšej metabolickej dysfunkcie, nie nutne jej jedinou príčinou.</p>

<h3>Podkožné tukové tkanivo</h3>

<p>Pri zachovanej schopnosti vytvárať nové adipocyty môže podkožný tuk fungovať ako relatívne bezpečný zásobník energetického nadbytku. Tvrdenie, že je „ochranný“, však nemožno absolutizovať — aj podkožné tkanivo môže hypertrofovať, fibrotizovať a stať sa zápalovo a metabolicky dysfunkčným. Rozhodujúca nie je iba poloha, ale <strong>biologická kvalita a schopnosť ďalšej expanzie</strong>.</p>

<h2>Rozdiely medzi mužmi a ženami</h2>

<p>Muži majú v priemere vyšší podiel viscerálneho tuku, zatiaľ čo ženy pred menopauzou častejšie ukladajú tuk podkožne, najmä v gluteofemorálnej oblasti. Ženy preto môžu mať vyšší celkový podiel telesného tuku bez proporcionálne vyššieho kardiometabolického rizika — biológiu tohto „hruškovitého“ fenotypu podrobne zhrnuli Kalypso Karastergiouová a spolupracovníci.</p>

<p>Tieto rozdiely ovplyvňujú pohlavné hormóny, distribúcia adrenergných receptorov, regionálna lipolytická aktivita, diferenciácia adipocytov, genetické a epigenetické mechanizmy, menopauza, vek, pohybová aktivita a výživa. Po menopauze sa distribúcia často posúva k centrálnej a viscerálnej adipozite. <strong>Biologické pohlavie však nie je deterministickým prediktorom</strong> — medzijednotlivcová variabilita je výrazná.</p>

<h3>Nové transkriptomické údaje</h3>

<p>Tím vedený Yazmín Macotelovou prezentoval na kongrese analýzu biopsií omentálneho viscerálneho a abdominálneho podkožného tukového tkaniva od 21 žien a 20 mužov vo veku 18 až 77 rokov, zameranú na expresné profily spojené s inzulínovou rezistenciou.</p>

<p>U mužov sa vo viscerálnom tuku zvýrazňovali dráhy súvisiace s bunkovým cyklom, senescenciou, zápalom, prestavbou extracelulárnej matrix a cievnymi zmenami; v podkožnom tuku dominovali poruchy funkcie adipocytov a odpovede na bunkový stres. U žien sa vo viscerálnom tuku výraznejšie prejavovala porucha adipocytovej funkcie, bunkový stres a vaskulárne zmeny; v podkožnom tuku imunitné, cievne a stromálne procesy.</p>

<p>Výsledky podporujú hypotézu, že dysfunkcia tukového tkaniva pri inzulínovej rezistencii nie je jednotným stavom a jej molekulový obraz sa môže líšiť podľa pohlavia a depa.</p>

<p><strong>Čo z toho zatiaľ nevyplýva:</strong> súbor mal 41 osôb so širokým vekovým rozpätím a z dostupného zhrnutia nemožno posúdiť výber účastníkov, menopauzálny stav žien, liečbu, kontrolu zmätočných faktorov ani korekciu na viacnásobné testovanie. Sekvenovanie RNA celého tkaniva navyše zachytáva zmes adipocytov, imunitných, endotelových a stromálnych buniek — zmena génovej expresie preto <strong>nemusí znamenať zmenu v adipocytoch</strong>, ale aj odlišné bunkové zloženie vzorky. Ide o hypotézotvorné údaje vyžadujúce replikáciu.</p>

<h2>Komunikácia s ostatnými orgánmi cez mikroRNA</h2>

<p>Tukové tkanivo komunikuje so vzdialenými orgánmi aj prostredníctvom extracelulárnych vezikúl prenášajúcich mikroRNA — krátke nekódujúce molekuly regulujúce génovú expresiu. Že ide o fyziologicky významný mechanizmus, doložili Thomas Thomou a spolupracovníci: mikroRNA pochádzajúce z tukového tkaniva regulujú expresiu génov v iných tkanivách.</p>

<p>Enzým DICER je nevyhnutný na tvorbu zrelých mikroRNA. V experimentálnych modeloch vedie jeho nedostatok v adipocytoch k čiastočnej lipodystrofii, inzulínovej rezistencii, poruche hnedého tukového tkaniva, zrýchlenej bunkovej senescencii a zmenám cirkulujúcich mikroRNA.</p>

<p>Marcelo Mori a spolupracovníci skúmajú, či mikroRNA z tukového tkaniva ovplyvňujú aj funkciu srdca. V zvieracích a bunkových modeloch zaznamenali zmeny dráh súvisiacich s cirkadiánnym rytmom, inzulínovou a adrenergnou signalizáciou, homeostázou vápnika a kontrakciou myokardu, s pozornosťou venovanou najmä miR-92a a miR-222.</p>

<p><strong>Potrebná opatrnosť:</strong> zistenie, že konkrétna mikroRNA prechádza z tukového tkaniva do srdca a mení expresiu génov u zvierat, nedokazuje, že jej zníženie spôsobuje klinické srdcové ochorenie u ľudí. Tá istá mikroRNA môže mať odlišný alebo protichodný účinok podľa tkaniva pôvodu, cieľovej bunky, koncentrácie, transportného mechanizmu, štádia ochorenia a prítomnosti zápalu alebo hypoxie. Klinické využitie mikroRNA ako biomarkerov alebo terapeutických cieľov zostáva výskumnou otázkou.</p>

<h2>Biele, hnedé a béžové tukové tkanivo</h2>

<p><strong>Biele tukové tkanivo</strong> ukladá energiu a má významnú endokrinnú, imunitnú a mechanickú funkciu.</p>

<p><strong>Hnedé adipocyty</strong> obsahujú veľké množstvo mitochondrií a exprimujú odpájací proteín 1 (UCP1), ktorý umožňuje rozptýliť protónový gradient vo forme tepla namiesto tvorby ATP. Aktivujú sa najmä chladom a sympatikovou stimuláciou; u dospelých sa nachádzajú predovšetkým v supraklavikulárnej a paravertebrálnej oblasti.</p>

<p><strong>Béžové adipocyty</strong> vznikajú v bielom tukovom tkanive za určitých podmienok a majú termogénne vlastnosti podobné hnedým (tzv. <em>browning</em>). Aktivácia termogenézy je zaujímavým terapeutickým cieľom, jej reálny príspevok k dlhodobému zníženiu telesnej hmotnosti u ľudí však zostáva neistý.</p>

<h3>Môže zvýšenie termogenézy liečiť obezitu?</h3>

<p>Uvádza sa, že chladom alebo stravou indukovaná termogenéza môže zvýšiť energetický výdaj približne o 5 až 10 %. Takýto údaj treba čítať veľmi opatrne — veľkosť účinku závisí od metodiky, trvania expozície, okolitej teploty, telesnej kompozície, množstva aktívneho hnedého tuku a adaptačných mechanizmov.</p>

<p>Organizmus navyše zvýšený výdaj kompenzuje väčším príjmom potravy, znížením spontánnej pohybovej aktivity, zmenami bazálneho metabolizmu a hormonálnou adaptáciou. <strong>Experimentálne zvýšenie termogenézy preto nemožno prepočítať na očakávaný úbytok hmotnosti.</strong></p>

<h2>Sója a genisteín</h2>

<p>Genisteín je izoflavón prítomný v sóji. V práci Rebecy Fuentesovej-Romerovej a spolupracovníkov zvýšil expresiu UCP1 prostredníctvom transkripčnej aktivácie prvkov odpovedajúcich na cAMP v promótore génu <em>Ucp1</em>, teda cez dráhu cAMP/PKA/CREB.</p>

<p>V zvieracích štúdiách sa podávanie genisteínu alebo sójovej bielkoviny spájalo s vyššou expresiou termogénnych markerov, väčším počtom béžových adipocytov, zvýšenou spotrebou kyslíka, menšími adipocytmi a nižším prírastkom hmotnosti. V izolovaných ľudských adipocytoch sa pozorovalo zvýšenie mitochondriálnych a termogénnych markerov, pričom odpoveď bola slabšia v bunkách od ľudí s nadváhou alebo obezitou.</p>

<p><strong>Čo tieto výsledky neznamenajú:</strong> preklinické údaje nedokazujú, že genisteín alebo sójové doplnky spôsobujú klinicky významné a udržateľné chudnutie u ľudí. Nemožno z nich odvodiť účinnú dávku, dlhodobú bezpečnosť koncentrovaných doplnkov, veľkosť očakávaného úbytku hmotnosti, účinok na kardiovaskulárne alebo renálne príhody ani nadradenosť nad štandardnou liečbou obezity. Sója môže byť súčasťou kvalitnej stravy, ale <strong>genisteín nemožno odporučiť ako liečbu obezity</strong> — a biologická aktivita izolovaného doplnku sa navyše nemusí zhodovať s účinkom celej potraviny.</p>

<h2>Prečo BMI nestačí</h2>

<p>Index telesnej hmotnosti je užitočný populačný a skríningový ukazovateľ, nerozlišuje však tukovú a svalovú hmotu, viscerálny a podkožný tuk, ektopické ukladanie tuku, metabolickú funkciu tkaniva ani vekové a pohlavné rozdiely v telesnej kompozícii.</p>

<p>Pri klinickom hodnotení je preto vhodné doplniť ho aspoň o obvod pása a posúdenie metabolických komplikácií; podľa situácie možno využiť zobrazovacie alebo bioimpedančné metódy s vlastnými obmedzeniami.</p>

<p>Pojem „metabolicky zdravá obezita“ treba používať opatrne — neprítomnosť aktuálnych metabolických odchýlok neznamená nulové dlhodobé riziko a tento fenotyp môže časom prejsť do metabolicky nezdravého stavu.</p>

<h2>Význam pre nefrologickú prax</h2>

<p>Obezita ovplyvňuje obličky hemodynamickými, metabolickými, zápalovými aj mechanickými cestami. Viscerálna a ektopická adipozita sa spájajú s aktiváciou sympatikového nervového systému a systému renín-angiotenzín-aldosterón, hyperinzulinémiou a retenciou sodíka, <strong>glomerulárnou hyperfiltráciou a intraglomerulárnou hypertenziou</strong>, albuminúriou, fokálnou segmentovou glomerulosklerózou asociovanou s obezitou, progresiou diabetickej a hypertenznej choroby obličiek, vyšším rizikom nefrolitiázy a so srdcovým zlyhávaním a kardiorenálnym syndrómom.</p>

<p>Index telesnej hmotnosti býva u pacientov s chronickou chorobou obličiek osobitne zavádzajúci. Výsledok ovplyvňuje retencia tekutín, sarkopénia, amputácie aj rozdielne zastúpenie svalovej a tukovej hmoty. <strong>Pacient môže mať normálny index telesnej hmotnosti a súčasne vysoký podiel viscerálneho tuku a nízku svalovú hmotu</strong> — kombináciu, ktorá je prognosticky nepriaznivá a bežným meraním úplne unikne.</p>

<h3>Obezita u dialyzovaných pacientov</h3>

<p>Pozorovaná asociácia vyššieho indexu telesnej hmotnosti s lepším prežívaním dialyzovaných pacientov, označovaná ako paradox obezity, <strong>nedokazuje ochranný účinok dysfunkčného tukového tkaniva</strong>. Výsledok môže byť ovplyvnený obrátenou príčinnosťou, zápalovo-malnutričným syndrómom, rozdielmi vo svalovej hmote, krátkym sledovaním, selekciou prežívajúcich pacientov a nedostatočným rozlíšením telesnej kompozície.</p>

<p>Pri redukcii hmotnosti u pacientov s chronickou chorobou obličiek treba chrániť svalovú hmotu a zabrániť malnutrícii. Cieľom nie je nižšia hmotnosť, ale zníženie metabolického a orgánového rizika pri zachovaní funkčnej kapacity.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<ol>
  <li><strong>Metabolické riziko nemožno hodnotiť iba podľa hmotnosti.</strong> Potrebné je zohľadniť obvod pása, tlak krvi, glykemický a lipidový profil, pečeňové a renálne parametre a telesnú kompozíciu.</li>
  <li><strong>Viscerálna adipozita má spravidla nepriaznivejší profil než gluteofemorálny podkožný tuk</strong> — ani podkožné tkanivo však nie je za každých okolností metabolicky neutrálne.</li>
  <li><strong>Pohlavie a vek ovplyvňujú distribúciu aj vlastnosti tuku</strong>, no malá transkriptomická štúdia zatiaľ neumožňuje zaviesť pohlavne špecifickú molekulovú liečbu.</li>
  <li><strong>Komunikácia cez mikroRNA je biologicky hodnoverná</strong>, jej terapeutické využitie však nebolo klinicky potvrdené.</li>
  <li><strong>Aktivácia hnedého alebo béžového tuku je perspektívnym smerom</strong>, ktorý zatiaľ nenahrádza intervencie s preukázanou klinickou účinnosťou.</li>
  <li><strong>Genisteín má preklinické termogénne účinky</strong>, ktoré nie sú dôvodom na odporúčanie koncentrovaných doplnkov.</li>
</ol>

<h2>Záver</h2>

<p>Tukové tkanivo je komplexný endokrinný, imunitný a metabolický orgán. Jeho schopnosť ukladať energiu, lokalizácia, bunkové zloženie a komunikácia s ostatnými orgánmi významne ovplyvňujú kardiometabolické a renálne riziko.</p>

<p>Nové výsledky naznačujú, že dysfunkcia tukového tkaniva môže mať pohlavne a anatomicky špecifické molekulové profily, že medzi tukovým tkanivom a srdcom prebieha komunikácia prostredníctvom mikroRNA a že genisteín dokáže aktivovať termogénny program adipocytov.</p>

<p>Tieto poznatky však zatiaľ neodôvodňujú molekulové testovanie tukového tkaniva, terapeutickú manipuláciu mikroRNA ani používanie genisteínu ako lieku na obezitu. Pre klinickú prax zostáva najdôležitejšie hodnotenie distribúcie tuku, metabolických a orgánových komplikácií a používanie intervencií s preukázaným dlhodobým prínosom. Jediné bezprostredne použiteľné posolstvo je pritom najstaršie: <strong>samotný index telesnej hmotnosti nestačí</strong> — a u nefrologického pacienta klame najviac.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=obezita-v-nefrologii-skrining-manazment-dialyza-transplantacia">Obezita v nefrológii</a> — skríning, manažment, dialýza a transplantácia.</li>
  <li><a href="article.php?slug=ckm-syndrom-stadia-skrining-liecba-usmernenie-2026">CKM syndróm: štádiá 0 až 4</a> — kardiovaskulárno-obličkovo-metabolické riziko.</li>
  <li><a href="article.php?slug=farmakologicka-liecba-obezity-pokrocile-ckd-dialyza">Farmakologická liečba obezity pri pokročilej CKD a dialýze</a>.</li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Krehkosť pri CKD</a> — telesná kompozícia a funkčné hodnotenie.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Medscape Medical News.</strong> <em>What Adipose Tissue Is Teaching Us About Obesity.</em> Medscape, 2026. Správa z kongresu International Congress on Obesity 2026 s vyjadreniami Yazmín Macotelovej, Marcela Moriho a Armanda R. Tovara. <a href="https://www.medscape.com/viewarticle/what-adipose-tissue-teaching-us-about-obesity-2026a1000q2q" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
  <li><strong>Kalypso Karastergiou, Steven R. Smith, Andrew S. Greenberg, Susan K. Fried.</strong> <em>Sex differences in human adipose tissues — the biology of pear shape.</em> Biology of Sex Differences. 2012;3:13. doi: 10.1186/2042-6410-3-13. <a href="https://pubmed.ncbi.nlm.nih.gov/22651247/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Thomas Thomou, Marcelo A. Mori, Jonathan M. Dreyfuss, Masahiro Konishi, Masaji Sakaguchi, Christian Wolfrum, Tata Nageswara Rao, Jonathon N. Winnay, Ruben Garcia-Martin, Steven K. Grinspoon, Phillip Gorden, C. Ronald Kahn.</strong> <em>Adipose-derived circulating miRNAs regulate gene expression in other tissues.</em> Nature. 2017;542:450–455. doi: 10.1038/nature21365. <a href="https://pubmed.ncbi.nlm.nih.gov/28199304/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Marcelo A. Mori, Raissa G. Ludwig, Ruben Garcia-Martin, Bruna B. Brandão, C. Ronald Kahn.</strong> <em>Extracellular miRNAs: From Biomarkers to Mediators of Physiology and Disease.</em> Cell Metabolism. 2019;30(4):656–673. doi: 10.1016/j.cmet.2019.07.011. <a href="https://pubmed.ncbi.nlm.nih.gov/31447320/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Rebeca Fuentes-Romero, Laura A. Velázquez-Villegas, Sarai Vasquez-Reyes, Berenice Pérez-Jiménez, Zuleima N. Domínguez Velázquez, Mónica Sánchez-Tapia, Ariana Vargas-Castillo, Sandra Tobón-Cornejo, Adriana M. López-Barradas, Valentín Mendoza, Nimbe Torres, Fernando López-Casillas, Armando R. Tovar.</strong> <em>Genistein-mediated thermogenesis and white-to-beige adipocyte differentiation involve transcriptional activation of cAMP response elements in the Ucp1 promoter.</em> FASEB Journal. 2023;37(8):e23079. doi: 10.1096/fj.202300139RR. <a href="https://pubmed.ncbi.nlm.nih.gov/37410022/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Csaba P. Kovesdy, Susan L. Furth, Carmine Zoccali; World Kidney Day Steering Committee.</strong> <em>Obesity and kidney disease: hidden consequences of the epidemic.</em> Kidney International. 2017;91(2):260–262. doi: 10.1016/j.kint.2016.10.019. <a href="https://pubmed.ncbi.nlm.nih.gov/28010887/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje a kompletné autorstvo všetkých piatich recenzovaných prác boli overené v Europe PMC. <strong>Kongresové údaje prezentované na International Congress on Obesity 2026 — transkriptomická analýza 41 biopsií, experimenty s mikroRNA vo vzťahu k srdcu vrátane miR-92a a miR-222, ako aj údaj o zvýšení energetického výdaja o 5 až 10 % — nebolo možné overiť proti publikovanému recenzovanému textu</strong> a treba ich do zverejnenia úplnej publikácie považovať za predbežné. Práce Thomoua, Moriho a Fuentesovej-Romerovej sú citované ako publikované doklady o samotných mechanizmoch (medziorgánový prenos mikroRNA, prehľad extracelulárnych mikroRNA, aktivácia promótora <em>Ucp1</em> genisteínom), nie ako zdroj kongresových zistení. Časť o význame pre nefrologickú prax, výhrady k paradoxu obezity a upozornenie na zavádzajúcu hodnotu indexu telesnej hmotnosti pri chronickej chorobe obličiek sú <strong>vlastným odborným spracovaním</strong> opretým o etablované poznatky.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_tukove-tkanivo-obezita-kardiorenalne-riziko-biologia_article',
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
