<?php

/** Publikačný skript odborného článku. */
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
    'title' => 'Stigma okolo liečby GLP-1: pacient nemení liečbu, mení lekára',
    'slug' => 'stigma-glp1-komunikacia-s-pacientom-nefrologia',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Kvalitatívna práca s 34 pacientmi ukazuje, že pri očakávanom odsúdení si pacient liek zaobstará inde. V nefrológii to znamená liečbu bez dohľadu nad funkciou obličiek.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/stigma-glp1-komunikacia-s-pacientom-nefrologia.webp" type="image/webp">
    <img src="img/stigma-glp1-komunikacia-s-pacientom-nefrologia.png" alt="Injekcne pero stojace v kuzeli ostreho svetla vrha dva dlhe rozbiehave tiene, na okraji svetla stoji rad nejasnych tmavych postav" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna. Nejde o zobrazenie konkrétneho pacienta, výrobku ani situácie.</figcaption>
</figure>

<p>Agonisty receptora GLP-1 sa rozšírili rýchlosťou, akú farmakoterapia obezity nepoznala. Podľa prieskumu agentúry Gallup ich na redukciu hmotnosti v súčasnosti užíva približne 11 % dospelých v Spojených štátoch, teda takmer štvornásobok oproti roku 2024.</p>

<p>Kvalitatívna práca uverejnená v časopise <em>Health Communication</em> sa pýta na niečo iné než účinnosť. Autori viedli rozhovory s 34 dospelými užívajúcimi tieto lieky a sledovali, ako zažívajú a zvládajú stigmu prostredníctvom komunikácie. Jedno zo zistení má priamy klinický dosah a v prevzatiach sa stráca: ak pacient očakáva odsúdenie od lekára, nezmení názor na liečbu. Zmení lekára.</p>

<h2>Dvojitá stigma</h2>

<p>Pacienti opisujú dva zdroje odsúdenia naraz. Prvým je telesná hmotnosť, druhým samotné rozhodnutie užívať na chudnutie liek. Medzi opakujúcimi sa motívmi bolo presvedčenie okolia, že užívatelia GLP-1 „podvádzajú“ alebo si skracujú cestu namiesto toho, aby odviedli ťažkú prácu.</p>

<p>U žien sa pridáva osobitný rozmer. Tieto lieky bývajú označované za prípravok pre márnivosť, takže časť účastníčok mala pocit, že ich okolie bude súdiť nielen za to, <em>ako</em> schudli, ale v niektorých prípadoch aj za to, že vôbec chceli schudnúť. Mnohí účastníci zažili odsúdenie najprv za to, že majú väčšie telo, a potom za to, že schudli „nesprávnym spôsobom“, prípadne že sa im nepodarilo schudnúť ani s liekom.</p>

<p>Účastníci tiež opisovali, že po úbytku hmotnosti sa k nim okolie začalo správať inak, napríklad väčšou pozornosťou v partnerskom zmysle a láskavosťou zo strany cudzích ľudí. Tieto skúsenosti ich viedli k tomu, aby pri každej situácii a pri každom človeku vyhodnocovali, či je „bezpečný“ na to, aby sa pred ním o liečbe zmienili.</p>

<h2>Ako pacienti stigmu zvládajú</h2>

<p>Autorka práce opisuje dva hlavné vzorce. Prvým je výber, komu liečbu prezradiť, podľa toho, ako daný človek hovorí o GLP-1 alebo o hmotnosti iných ľudí. Väčšina účastníkov buď liečbu otvorene neuvádzala, alebo prevzala úlohu vysvetľujúceho a snažila sa vonkajšie vnímanie zmeniť. To viedlo aj k tomu, že liečbu zatajovali pred blízkymi priateľmi a rodinou práve pre to, ako títo ľudia o hmotnosti a o GLP-1 hovorili.</p>

<p>Druhým vzorcom je sebazaradenie do skupiny tých, ktorí liek užívajú „správne“. Účastníci zdôrazňovali, že liek je len nástroj a bez ťažkej práce na strave, pohybe a dlhodobej zmene správania by nefungoval. Dokladali zdravotné výsledky a medicínsku nevyhnutnosť, aby svoju potrebu lieku legitimizovali, na rozdiel od tých, ktorí ho podľa nich užívajú z nesprávnych dôvodov.</p>

<p>A tu je bod, ktorý sa pri preberaní spravidla otočí naruby. Táto stratégia sa <strong>na prvý pohľad javí ako konštruktívna, ale autori ju hodnotia opačne</strong>: takéto rozdeľovanie v podstate tú istú stigmu posilňuje, pretože vytvára kategórie podľa toho, kto už „dosť vytrpel“ a kto vynakladá „najviac úsilia“. Lekár, ktorý pacienta v tejto argumentácii podporuje, mu síce v danej chvíli uľaví, ale zároveň spoluvytvára rámec, v ktorom bude ďalší pacient obhajovať sám seba.</p>

<h2>Klinicky najzávažnejší dôsledok</h2>

<p>Otázka, či stigma ovplyvňuje aj komunikáciu s lekárom, má v práci jednoznačnú odpoveď. Z údajov vyplýva, že časť pacientov sa na GLP-1 vôbec nespýta, ak sa domnieva, že ich sociálne okolie liečbu nepodporí.</p>

<p>Ešte konkrétnejší je nález o tom, ako si pacienti liek zaobstarávajú. Ak očakávali stigmatizáciu zo strany svojho lekára, cielene vyhľadali <strong>iného lekára</strong>, o ktorom vedeli, že liek predpíše, alebo telemedicínsku službu, ktorá nevyžaduje osobnú návštevu, prípadne si liek zaobstarali v zariadení typu medicínskeho salónu.</p>

<p>To je pre lekára podstatnejšie než akékoľvek komunikačné odporúčanie. Pacient, ktorý očakáva odsúdenie, sa nevzdáva liečby; presúva ju mimo dosahu toho, kto pozná jeho funkciu obličiek, jeho lieky a jeho kardiovaskulárne riziko. Odsudzujúci tón teda nevedie k menšiemu užívaniu GLP-1, ale k užívaniu GLP-1 bez dohľadu.</p>

<p>Účastníci ďalej opisovali, že zvyšovali alebo znižovali dávky bez lekárskeho dohľadu, aby dosiahli konkrétne ciele, a že dávkovanie a frekvenciu upravovali zámerne tak, aby obmedzili príjem potravy, prejedli sa, alebo aby pred inými ľuďmi pôsobili, že jedia „normálne“. Autorka vyjadruje obavu aj z toho, že stigma okolo stereotypne známych nežiaducich účinkov zníži ochotu pacientov pýtať sa na nežiaduce účinky pri kontrolách.</p>

<h2>Čo si v ambulancii všímať a čo s tým</h2>

<p>Prvým krokom je uvedomiť si, že rozhovor o hmotnosti a o potenciálne zahanbujúcich nežiaducich účinkoch je citlivý a vyvoláva nepríjemné emócie. Kým lekár sa sústreďuje na medicínske výsledky, pacient zvažuje mnoho iných vecí naraz.</p>

<p>Stojí za to všimnúť si, keď pacient prejaví váhavosť pri novom lieku alebo spomenie prevzaté predstavy. Je úplne namieste opýtať sa, prečo váha a odkiaľ informáciu má. Autorka uvádza ako dobrý začiatok vetu: „Keď som spomenul liečbu GLP-1, zdalo sa mi, že váhate. Čo si o týchto liekoch myslíte?“</p>

<div class="table-responsive" role="region" aria-label="Praktické kroky na zníženie stigmy v rozhovore" tabindex="0">
<table>
  <thead><tr><th scope="col">Namiesto</th><th scope="col">Skôr</th><th scope="col">Prečo</th></tr></thead>
  <tbody>
    <tr><th scope="row">„Máte nejaké obavy?“</th><td>„Aké máte obavy?“</td><td>Otvorená otázka takmer vždy prinesie lepšiu odpoveď</td></tr>
    <tr><th scope="row">Naznačenie, že pacient zlyhal v režime</th><td>Pomenovanie konkrétneho zdravotného cieľa</td><td>Rámcovanie ako zlyhanie uzatvára rozhovor</td></tr>
    <tr><th scope="row">Prijatie znevažujúceho vtipu bez reakcie</th><td>Nasmerovanie na to, čo liečba zlepší</td><td>Vtip býva štítom, nie postojom</td></tr>
    <tr><th scope="row">Rozlišovanie „oprávnených“ a „neoprávnených“ užívateľov</th><td>Jednotný prístup k indikácii</td><td>Takéto delenie stigmu reprodukuje</td></tr>
  </tbody>
</table>
</div>

<p>Autorka uvádza ako príklad formulácie: „Viem, že sme už hovorili o znížení hmotnosti kvôli vášmu spánkovému apnoe. Zdá sa, že to bolo dosť náročné, čo je u pacientov veľmi časté. Liek zo skupiny GLP-1 by mohol byť dobrým nástrojom na podporu tohto cieľa.“</p>

<p>Dôležitá je aj poznámka o budovaní vzťahu: nevyžaduje dlhú návštevu. Stačí konzistentný postoj, jednoduché otázky o živote pacienta a empatia pri ťažkých témach.</p>

<h2>Prečo to patrí do nefrologickej ambulancie</h2>

<p>Dôvod nie je komunikačný, ale vecný. Pri pacientoch s diabetom 2. typu a chronickou chorobou obličiek už nejde o liek na chudnutie, ale o liek s doloženým obličkovým účinkom.</p>

<p>Štúdia FLOW randomizovala 3 533 pacientov s diabetom 2. typu a chronickou chorobou obličiek na semaglutid 1,0 mg týždenne subkutánne alebo placebo. Po mediáne sledovania 3,4 roka, po odporúčaní predčasného ukončenia pri vopred stanovenej priebežnej analýze, bolo riziko primárneho ukazovateľa, teda zloženého ukazovateľa závažných obličkových udalostí, o <strong>24 % nižšie</strong> (331 oproti 410 prvých udalostí; HR 0,76; 95 % IS 0,66–0,88; p = 0,0003).</p>

<div class="table-responsive" role="region" aria-label="Výsledky štúdie FLOW" tabindex="0">
<table>
  <thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Pomer hazardov</th><th scope="col">95 % interval spoľahlivosti</th></tr></thead>
  <tbody>
    <tr><th scope="row">Závažné obličkové udalosti (primárny)</th><td>0,76</td><td>0,66–0,88</td></tr>
    <tr><th scope="row">Obličkové zložky primárneho ukazovateľa</th><td>0,79</td><td>0,66–0,94</td></tr>
    <tr><th scope="row">Úmrtie z kardiovaskulárnych príčin</th><td>0,71</td><td>0,56–0,89</td></tr>
    <tr><th scope="row">Závažné kardiovaskulárne príhody</th><td>0,82</td><td>0,68–0,98</td></tr>
    <tr><th scope="row">Úmrtie z akejkoľvek príčiny</th><td>0,80</td><td>0,67–0,95</td></tr>
  </tbody>
</table>
</div>

<p>Priemerný ročný sklon eGFR bol v ramene so semaglutidom miernejší o 1,16 ml/min/1,73 m² (p &lt; 0,001). Závažné nežiaduce udalosti boli pritom hlásené u <em>nižšieho</em> podielu účastníkov na semaglutide než na placebe (49,6 % oproti 53,8 %).</p>

<p>Toto je kvalitatívne iná situácia než liečba obezity bez komorbidity. U pacienta s diabetom 2. typu a albuminurickou chronickou chorobou obličiek nejde o estetiku ani o pohodlie, ale o oddialenie zlyhania obličiek a o zníženie kardiovaskulárnej úmrtnosti. A práve u tohto pacienta je obzvlášť nežiaduce, aby liečbu riešil mimo ambulancie, ktorá sleduje jeho eGFR a albuminúriu.</p>

<p>Z nefrologického hľadiska pristupujú tri praktické dôvody, prečo musí pacient hovoriť otvorene:</p>

<ul>
  <li><strong>Gastrointestinálne nežiaduce účinky a objemový stav.</strong> Zvracanie a hnačka pri súbežnej liečbe inhibítormi systému renín-angiotenzín, diuretikami alebo inhibítormi SGLT2 môžu viesť k prerenálnemu akútnemu poškodeniu obličiek. Pacient, ktorý o nich nepovie pre hanbu, prichádza o možnosť dostať jednoduchú radu o prechodnom vysadení diuretika.</li>
  <li><strong>Úprava dávky bez dohľadu.</strong> Ak lekár nevie, akú dávku pacient skutočne užíva, nemôže správne interpretovať ani účinnosť, ani neúčinnosť, ani nežiaduci priebeh.</li>
  <li><strong>Hodnotenie funkcie obličiek pri rýchlom chudnutí.</strong> Výrazná redukcia hmotnosti mení svalovú hmotu, a tým aj tvorbu kreatinínu. Odhad glomerulárnej filtrácie z kreatinínu sa môže zdať priaznivejší, než aká je skutočnosť. Pri nejasnosti má miesto stanovenie cystatínu C.</li>
</ul>

<h2>Záver</h2>

<p>Ide o kvalitatívnu prácu s 34 účastníkmi. Nedáva odhady prevalencie a nemožno z nej usudzovať, aká časť pacientov sa správa opísaným spôsobom. Opisuje však mechanizmy, ktoré sú pre klinickú prax rozpoznateľné a overiteľné v rozhovore.</p>

<p>Praktický záver je striedmy a jednoduchý. Neodsudzujúci tón nie je láskavosť, ale podmienka toho, aby lekár vedel, čo pacient skutočne užíva a ako to znáša. V nefrológii, kde má táto skupina liekov doložený prínos pre obličky aj pre prežívanie, je to podmienka bezpečnej liečby, nie otázka štýlu.</p>

<hr>

<p><small><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom. Nenahrádza odborné vyšetrenie, individuálne posúdenie ani platné klinické odporúčania a súhrny charakteristických vlastností liekov. Výsledky štúdie FLOW sa vzťahujú na pacientov s diabetom 2. typu a chronickou chorobou obličiek v definovanom rozsahu eGFR a albuminúrie a nemožno ich zovšeobecňovať na iné populácie. Indikácie a úhrada sa v Slovenskej republike riadia platnou kategorizáciou.</em></small></p>

<h2>Literatúra</h2>

<p><small><em>1. Lazenby Braidyn, Guidry Ashley, Price Sarah, Shuvo Md Sazzad Mahmud, Alikhanova Tursynay, Morrison Chloe, Davis Nicole, Lenard Madison. „They Call Us Cheaters“: Exploring Stigma Management Communication Strategies During GLP-1 Medication Use. <em>Health Communication.</em> Uverejnené online 18. septembra 2026, s. 1–11. DOI: <a href="https://doi.org/10.1080/10410236.2026.2734167" target="_blank" rel="noopener noreferrer">10.1080/10410236.2026.2734167</a>.</em></small></p>

<p><small><em>2. Watson John. Patients Taking GLP-1s Face a Double Dose of Stigma. <em>Medscape Medical News</em>, 16. októbra 2026. Rozhovor s Braidyn Lazenby, PhD (School of Communication, Florida State University, Tallahassee). <a href="https://www.medscape.com/viewarticle/patients-taking-glp-1s-face-double-dose-stigma-2026a10012zi" target="_blank" rel="noopener noreferrer">Celý rozhovor</a>.</em></small></p>

<p><small><em>3. Perkovic Vlado, Tuttle Katherine R., Rossing Peter, Mahaffey Kenneth W., Mann Johannes F. E., Bakris George, Baeres Florian M. M., Idorn Thomas, Bosch-Traberg Heidrun, Lausvig Nanna Leonora, Pratley Richard; FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. <em>New England Journal of Medicine.</em> 2024;391(2):109–121. DOI: <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2403347</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed PMID 38785209</a>.</em></small></p>

<h3>Poznámka k dôkazom</h3>

<p><small><em>Citácie z kvalitatívnej práce vrátane počtu účastníkov, opisu stratégií, odporúčaných formulácií a zistenia o vyhľadávaní iného poskytovateľa boli overené priamo na verejne prístupnej stránke zdrojového rozhovoru, vrátane mena autora v byline. Názov, časopis, dátum uverejnenia, rozsah strán, DOI a úplný autorský zoznam všetkých ôsmich autorov primárnej práce boli overené v databáze Crossref. Všetky číselné výsledky štúdie FLOW vrátane pomerov hazardov, intervalov spoľahlivosti, počtu účastníkov, dĺžky sledovania a sklonu eGFR pochádzajú zo štruktúrovaného abstraktu v PubMed.</em></small></p>

<p><small><em>Vlastným prínosom tohto spracovania je zdôraznenie zistenia o presune pacienta k inému poskytovateľovi alebo k telemedicíne ako klinicky najzávažnejšieho dôsledku, upozornenie na to, že stratégia legitimizácie vlastnej liečby podľa autorov stigmu reprodukuje a nie zmierňuje, nahradenie zastaraných sekundárnych renálnych analýz štúdií LEADER a SUSTAIN-6 primárnym dôkazom zo štúdie FLOW, a tri nefrologicky špecifické dôvody, pre ktoré je otvorená komunikácia podmienkou bezpečnej liečby, vrátane vplyvu úbytku svalovej hmoty na odhad glomerulárnej filtrácie z kreatinínu.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=semaglutid-chudnutie-egfr-kreatinin-cystatin-c">Semaglutid, chudnutie a odhad eGFR z kreatinínu a cystatínu C</a></li>
  <li><a href="article.php?slug=obezita-multifaktorialne-ochorenie-skrining-nefrologia">Obezita ako multifaktoriálne ochorenie v nefrológii</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: vrstvená kardiorenálna liečba</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_stigma-glp1-komunikacia-s-pacientom-nefrologia_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "────────────────────────────────────────────────────\n\n";
}
?>