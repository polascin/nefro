<?php

/**
 * add_lipedem-multidisciplinarny-manazment-chirurgia_article.php
 * Lipedém: multidisciplinárny manažment a miesto chirurgie.
 *
 * Pôvodní autori spracovaných zdrojov sú uvedení v source_authors.php.
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
    'title'        => 'Lipedém (lipedema): multidisciplinárny manažment a miesto chirurgie v liečbe – praktický odborný prehľad',
    'slug'         => 'lipedem-multidisciplinarny-manazment-chirurgia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Lipedém je chronické ochorenie podkožného tuku s bolesťou, disproporciou končatín a neskorším lymfatickým postihnutím. Diagnóza je klinická; liečba multidisciplinárna a chirurgia redukčná, nie kozmetická.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Lipedém nie je „len obezita nôh“. Ide o chronické, prevažne u žien sa vyskytujúce ochorenie podkožného tuku s bolesťou, obmedzením hybnosti a psychosociálnou záťažou. Diagnóza ostáva klinická. Liečba je multidisciplinárna; chirurgia je redukčná, nie kozmetická, a nie je vyliečením.</em></p>

<p>Text spracúva kongresovú správu portálu Medscape z Medzinárodného kongresu o obezite (International Congress on Obesity, ICO) 2026, americký štandard starostlivosti o lipedém (Herbst a spol., 2021) a medzinárodný Delphi konsenzus Lipedema World Alliance (Kruppa a spol., 2026). Pacientsky prehľad Cleveland Clinic uvádzam len ako sekundárny, verejne dostupný opis klinického obrazu – nie ako zdroj dávkovania ani operačných percent.</p>

<h2>Čo je lipedém</h2>

<p><strong>Lipedém</strong> (angl. <em>lipedema</em>, v literatúre aj <em>lipoedema</em>) je chronické ochorenie riedkeho väziva a podkožného tuku. Typicky ide o disproporčný, obojstranný a relatívne symetrický nárast nodulárneho a fibrotického tuku na sedacej oblasti, bokoch a končatinách. Dlane a nárty bývajú ušetrené, často s „manžetou“ pri členku alebo zápästí. Ochorenie sa zvyčajne začína alebo zhoršuje v obdobiach hormonálnej zmeny – v puberte, v tehotenstve a v menopauze.</p>

<p>Svetová zdravotnícka organizácia (WHO) zaradila lipedém do 11. revízie Medzinárodnej klasifikácie chorôb (MKCH-11, ICD-11) medzi nezápalové poruchy podkožného tuku. Klasifikácia bola uvoľnená v roku 2018 a pre štatistické používanie nadobudla účinnosť v roku 2022.</p>

<p>Prevalencia nie je spoľahlivo známa. Často citovaný údaj o približne 11 % dospelých, prípadne 11 % žien, <strong>nie je robustným populačným odhadom</strong> – diagnostické kritériá sa líšia, štúdie pochádzajú z rôznych populácií a Delphi konsenzus 2026 výslovne upozorňuje na veľkú neistotu. Americký štandard starostlivosti uvádza napríklad 6 až 8 % žien v Nemecku a 15 až 19 % v cievnych ambulanciách; tieto čísla nemožno prenášať na všeobecnú populáciu.</p>

<p>Klinický význam spočíva v bolesti, ťažkých končatinách, zhoršenej hybnosti, sklonu k hematómom, neskôr v lymfatickom postihnutí (lipolymfedém) a v značnej psychosociálnej záťaži. Súbežná obezita, lymfedém, venózne ochorenie a hypermobilita kĺbov sú časté komorbidity – nie vzájomne sa vylučujúce diagnózy.</p>

<h2>Klinický obraz</h2>

<p>Najčastejšie postihnuté sú stehná, lýtka, boky a sedacia oblasť; v pokročilejších štádiách aj ramená. Trup býva relatívne štíhlejší. Pacientky opisujú bolesť a citlivosť na palpáciu, ťažké nohy, opuch po dlhom státí, bolestivé noduly, chladnejšiu kožu, varixy a ľahké tvorenie hematómov. Tukové vankúše okolo kolien a bedier zhoršujú chôdzu a mechaniku kĺbov.</p>

<p>Bolesť je častá, ale <strong>nie je absolútnou podmienkou diagnózy</strong>. V klasickej práci Allena a Hinesa ju malo len približne 40 až 50 % žien; americký štandard starostlivosti to výslovne pripomína.</p>

<p>Lipedémové tkanivo sa <strong>zvyčajne</strong> diétou, cvičením ani bariatrickou operáciou významne nezmenší – najmä pre fibrotickú zložku riedkeho väziva. Nie je to však univerzálny biologický zákon. Úbytok viscerálneho a trupového tuku môže nastať, kým disproporcia končatín pretrváva. Delphi konsenzus 2026 uvádza, že pri súbežnej obezite možno po bariatrickej operácii očakávať pretrvávanie príznakov lipedému, aj keď sa celkový objem končatín čiastočne zmenší.</p>

<h2>Diagnostika ostáva klinická</h2>

<p>Neexistuje univerzálny definitívny zobrazovací test. Magnetická rezonancia (MRI) môže ukázať fibrózu prepletenú s tukom, ale diagnostické kritérium podľa obrazu nie je zavedené. Diagnóza sa opiera o anamnézu a fyzikálne vyšetrenie; laboratórium a zobrazovanie slúžia predovšetkým na vylúčenie iných príčin a na zhodnotenie komorbidít.</p>

<p>Praktické vodidlá – žiadne z nich nie je samostatným diagnostickým pravidlom:</p>

<ul>
  <li><strong>disproporcia</strong> – relatívne štíhlejší trup, väčší objem nôh (neskôr aj paží);</li>
  <li><strong>obojstrannosť a relatívna symetria</strong> – lipedém je typicky bilaterálny; lymfedém býva často jednostranný, ale obojstranný lymfedém lipedém nevylučuje;</li>
  <li><strong>bolestivosť a citlivosť</strong> tkaniva na palpáciu;</li>
  <li><strong>ušetrenie dlaní a nártov</strong> s možnou manžetou pri členku alebo zápästí (nie vždy prítomnou);</li>
  <li><strong>začiatok</strong> v období hormonálnej zmeny;</li>
  <li><strong>rodinný výskyt</strong> u časti pacientok.</li>
</ul>

<h3>Jamkový edém – opatrná formulácia</h3>

<p>Klasicky sa pri lipedéme uvádza edém s malým alebo žiadnym jamkovaním po tlaku. Delphi konsenzus 2026 uvádza, že pri absencii komorbidít jamkový edém v postihnutom tkanive spravidla chýba a tým sa lipedém líši od lymfedému. Americký štandard starostlivosti je striedmejší: opuch nôh pri lipedéme môže byť <strong>jamkový aj nejamkový</strong>.</p>

<p>Jamkovanie preto <strong>nemôže byť jediným rozlišovacím znakom</strong>. Ortostatický opuch, venózna nedostatočnosť a lipolymfedém môžu jamku zanechať. Neprítomnosť jamky lipedém nepotvrdzuje a jej prítomnosť ho nevylučuje.</p>

<h3>Diferenciálna diagnostika voči obezite a lymfedému</h3>

<p>Žena s lipedémom môže mať súčasne obezitu. Vodidlom je disproporčné uloženie tuku na stehnách a lýtkach, najmä ak metabolický profil nezodpovedá očakávanému obrazu pri danom stupni celkovej adipozity. Index telesnej hmotnosti (BMI) pri lipedéme nadhodnocuje „obezitu“, lebo zahŕňa objem končatín; pomer pásu k výške môže byť výpovednejší, ale nie je štandardizovaným diagnostickým testom.</p>

<p>Lymfedém je porucha lymfatického odtoku s hromadením lymfy. Býva často jednostranný, postihuje aj nárty a prsty, koža môže byť zhrubnutá, Stemmerov príznak pozitívny. Lipedém je typicky obojstranný, nárty ušetrené, tkanivo bolestivé. V neskorších štádiách sa môžu prekrývať: <strong>lipolymfedém</strong> je lipedém s klinicky zjavným lymfedémom. Epizóda lymfedému v skorom štádiu automaticky neznamená štádium 4.</p>

<h2>Päť typov a štyri štádiá – systémy sa líšia</h2>

<p>Anatomickú distribúciu opisuje päť typov; progresiu a fibrózu štyri klinické štádiá (Schmeller a Meier-Vollrath, prevzaté aj v americkom štandarde). Klasifikácie nie sú jednotné: niektoré usmernenia pracujú len s tromi štádiami a lipolymfedém uvádzajú ako komplikáciu, nie ako štádium 4. Typ a štádium treba v dokumentácii pomenovať aj so zdrojom klasifikácie.</p>

<div class="table-responsive" role="region" aria-label="Typy lipedému podľa anatomickej distribúcie tkaniva" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Typ</th>
      <th scope="col">Anatomická distribúcia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">I</th>
      <td>Pod pupkom, nad bokmi a sedacou oblasťou</td>
    </tr>
    <tr>
      <th scope="row">II</th>
      <td>Od oblasti pod pupkom po kolená</td>
    </tr>
    <tr>
      <th scope="row">III</th>
      <td>Od oblasti pod pupkom po členky</td>
    </tr>
    <tr>
      <th scope="row">IV</th>
      <td>Ramená a paže</td>
    </tr>
    <tr>
      <th scope="row">V</th>
      <td>Predkolenia (od kolien nadol)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Typy sa môžu kombinovať. Manžeta pri členku alebo zápästí môže byť v ktoromkoľvek štádiu, ale nemusí.</p>

<div class="table-responsive" role="region" aria-label="Štádiá lipedému podľa zmien kože, palpácie a lymfatického postihnutia" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štádium</th>
      <th scope="col">Charakteristika (Schmeller a Meier-Vollrath / americký štandard)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Povrch kože hladký; podkožie s drobnozrnným, „kamienkovitým“ pocitom pri palpácii pre začínajúcu fibrózu riedkeho väziva</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Viaceré a väčšie noduly, jamkovanie kože (vzhľad celulitídy) pri pokročilejšej fibróze a väčšom objeme tkaniva</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Hrubé noduly, tuhšie fibrotické tkanivo, previsajúce laloky tuku</td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>Lipolymfedém – lipedém s klinicky zjavným lymfedémom</td>
    </tr>
  </tbody>
</table>
</div>

<p>Štádium 1 môže uniknúť pozornosti, lebo obraz pripomína bežnú obezitu. Štádium 4 nie je synonymom každej lymfatickej epizódy v skoršom priebehu.</p>

<h2>Ciele liečby nie sú „chudnutie za každú cenu“</h2>

<p>Cieľom je zmierniť bolesť, zlepšiť hybnosť, ovplyvniť opuch a kvalitu života – nie maximalizovať úbytok kilogramov. Empatické vysvetlenie diagnózy, typu a štádia patrí k liečbe: mnohé pacientky si roky vypočúvali, že „málo cvičia“ a „málo sa stravujú“.</p>

<h2>Konzervatívna starostlivosť je základ</h2>

<p>Americký štandard starostlivosti za štandardnú konzervatívnu liečbu považuje výživové poradenstvo, manuálne techniky, kompresiu, zváženie pneumatickej kompresie a individuálny domáci pohybový plán. Delphi konsenzus 2026 zdôrazňuje multidisciplinárny prístup: medicína, rehabilitácia, výživa a psychológia.</p>

<ul>
  <li><strong>Výživa:</strong> obmedzenie vysoko spracovaných potravín a rafinovaných sacharidov je <em>podporné opatrenie</em>, nie kauzálne vyliečenie lipedému. Cieľom je metabolické zdravie, zápal a sprievodná obezita, nie „vymiznutie“ lipedémového tuku. V literatúre sa spomínajú strava z celých, prevažne rastlinných potravín aj nízkosacharidové vzorce; žiadny režim nie je dokázanou špecifickou liečbou ochorenia.</li>
  <li><strong>Pohyb:</strong> chôdza, bicykel, vodné aktivity, podľa tolerancie aj eliptický trenažér alebo joga. Záťaž má byť udržateľná, nie trestajúca. Individuálny predpis, pomalý nárast a dlhodobé sledovanie.</li>
  <li><strong>Kompresia:</strong> znižuje bolesť a pomáha pri opuchu; silu, strih a materiál treba individualizovať podľa bolesti a schopnosti odev obliecť a vyzliecť.</li>
  <li><strong>Lymfatická terapia:</strong> manuálna lymfodrenáž ako súčasť komplexného programu, mäkké uvoľňovanie väziva, v indikovaných prípadoch pneumatická kompresia – nie ako jediná „kúra“.</li>
  <li><strong>Psychológia:</strong> stigma, úzkosť, depresia a poruchy príjmu potravy sú časté; psychologická podpora nie je doplnok navyše, ale súčasť liečby.</li>
</ul>

<h2>Farmakoterapia a agonisty GLP-1: obmedzené dôkazy</h2>

<p>Špecifická schválená farmakoterapia lipedému neexistuje. Antiobezitiká prichádzajú do úvahy, ak je metabolická indikácia – diabetes 2. typu, obezita so zvýšeným kardiometabolickým rizikom – nie ako liek „na lipedém“.</p>

<p>Pri agonistoch receptora glukagónu podobného peptidu 1 (GLP-1) a duálnych agonistoch GLP-1/GIP (glukózodependentný inzulínotropný polypeptid) sa v klinickej praxi opisuje u časti pacientok ústup bolesti, opuchu a objemu končatín. Ide o <strong>pozorovania a obmedzené, prevažne nekontrolované údaje</strong>. Chýbajú randomizované kontrolované štúdie s primárnymi cieľmi špecifickými pre lipedém. Z týchto údajov <strong>nemožno odvodiť kauzálne tvrdenie</strong>, že GLP-1 lipedém lieči. Účinok na viscerálny tuk a telesnú hmotnosť sa nemusí rovnať účinku na fibrotické lipedémové depo.</p>

<h2>Chirurgia je redukčná, nie kozmetická</h2>

<p>Operácia prichádza do úvahy, keď konzervatívna liečba narazí na strop a bolesť, hybnosť alebo progresia pretrvávajú pri dobrej adherencii. Nie každá pacientka ju potrebuje.</p>

<p>Americký štandard starostlivosti (Herbst a spol., 2021) uvádza, že <strong>redukčný výkon je v súčasnosti jedinou dostupnou technikou na odstránenie abnormálneho lipedémového tkaniva</strong> – adipocytov, nodulov, fibrotickej extracelulárnej matrix a ďalších neadipocytových zložiek – a že ide zároveň o jedinú liečbu, ktorá spomaľuje progresiu ochorenia. Toto tvrdenie patrí <strong>tomuto dokumentu</strong> (konsenzus s nízkou kvalitou dôkazov, GRADE C). Nie je to univerzálny biologický zákon a budúce farmakologické prístupy ho môžu zmeniť.</p>

<p>Najčastejší výkon je liposukcia šetriaca cievy a lymfatiká; lipektómia (excízia) a manuálna extrakcia sa používajú podľa nálezu. Ide o <strong>redukciu chorobného tkaniva</strong>, nie o estetickú liposukciu. Objemové limity kozmetickej liposukcie na lipedém nesedia. Výkon má robiť skúsený tím v nemocničnom zázemí technikou šetriacou lymfatiká (tupé kanyly primeranej šírky, longitudinálny postup pozdĺž lymfatických kolektorov). Nesprávne vykonaná liposukcia môže spôsobiť sekundárny lymfedém a iné dlhodobé komplikácie.</p>

<p>Operácii má predchádzať konzervatívna liečba. V správe z ICO 2026 Max Sirota odporúčal aspoň šesť mesiacov s cieľom znížiť opuch a fibrózu, obmedziť krvácanie počas výkonu a uľahčiť zotavenie. Americký štandard cituje britské usmernenie s intervalom 6 až 12 mesiacov adherencie ku konzervatívnej liečbe; holandské usmernenie viaže indikáciu na vyčerpanie odpovede na konzervatívnu liečbu. Presný počet mesiacov teda nie je jednotný – rozhoduje dokumentovaná adherencia alebo zlyhanie konzervatívnej liečby, nie kalendár sám osebe.</p>

<p>Pred výkonmi treba zhodnotiť venózny a lymfatický systém, liečiť významnú venóznu insuficienciu a pri veľkom objeme plánovať výkony <strong>etapovito</strong>. Optimálny odstup medzi etapami nie je známy. Pri lipolymfedéme má predchádzať intenzívna kompletná dekongestívna terapia.</p>

<h3>Výsledky operácie – bez neoverených percent</h3>

<p>Pozorovacie série a metaanalýzy prevažne nerandomizovaných štúdií opisujú zlepšenie bolesti, hybnosti a kvality života. Dizajny sú však väčšinou retrospektívne, bez primeranej kontroly, s rôznymi technikami, štádiami a dĺžkou sledovania. Často citované percentá v kongresových správach občas <strong>zamieňajú priemerný pokles skóre bolesti s podielom pacientok</strong>. Preto ich tu neuvádzam ako klinickú konštantu. Randomizované dôkazy s dlhým sledovaním chýbajú.</p>

<p>Chirurgia <strong>nie je vyliečenie</strong>. Redukuje tkanivo a môže spomaliť progresiu, ale celoživotná multidisciplinárna starostlivosť – kompresia, pohyb, výživa, lymfatická terapia, psychológia – ostáva potrebná. Včasné štádiá nosia pooperačnú kompresiu aspoň 2 až 3 mesiace; pokročilý lipedém a lipolymfedém často doživotne.</p>

<h2>Poznámka pre nefrológa</h2>

<p>Lipedém sa v ambulancii môže zamieňať s edémom pri chronickej chorobe obličiek (CKD), s nefrotickým syndrómom alebo s lymfedémom. Rozlíšenie má praktický dosah na diuretickú liečbu.</p>

<ul>
  <li><strong>Nefrotický a CKD edém</strong> býva jamkový, často s periorbitálnym opuchom, nyktúriou, hypoalbuminémiou, proteinúriou a ďalšími známkami objemového preťaženia. Distribúcia nie je „štíhly trup, disproporčné bolestivé nohy so ušetrenými nártmi“.</li>
  <li><strong>Lymfedém</strong> pri CKD alebo po výkone na končatine môže byť jednostranný, s postihnutím prstov a pozitívnym Stemmerovým príznakom.</li>
  <li><strong>Lipedém</strong> je tkanivový, bolestivý, typicky obojstranný; opuch nie je prejavom objemového preťaženia obehu.</li>
</ul>

<p><strong>Diuretiká nie sú liekom prvej voľby pri lipedéme.</strong> Americký štandard starostlivosti dlhodobé podávanie neodporúča. Ak sa lipedém lieči „ako hypervolémia“, hrozí hypovolémia, elektrolytová dysbalancia a zhoršenie funkcie obličiek bez zmysluplného vplyvu na fibrotické tukové tkanivo. Diuretikum ostáva indikované pri preukázanom objemovom preťažení z inej príčiny (srdcové zlyhávanie, nefrotický syndróm, dekompenzovaná CKD) – nie „na nohy s lipedémom“. Dávkovanie tu neuvádzam; riadi sa primárnou indikáciou, nie diagnózou lipedému.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<ul>
  <li>Na lipedém myslieť pri disproporcii končatín, bolestivom tuku a relatívne ušetrených nártoch – aj pri súbežnej obezite.</li>
  <li>Diagnóza je klinická; zobrazovanie a laboratórium diferencujú, nenahrádzajú vyšetrenie.</li>
  <li>Jamkový edém nie je samostatné diagnostické pravidlo.</li>
  <li>Typy a štádiá treba uvádzať s vedomím, že klasifikácie nie sú jednotné.</li>
  <li>Cieľom je bolesť, hybnosť, opuch a kvalita života, nie chudnutie za každú cenu.</li>
  <li>Konzervatívna starostlivosť je základ; GLP-1 len pri metabolickej indikácii a bez kauzálneho nároku na „liečbu lipedému“.</li>
  <li>Chirurgia je redukčná, lymfu šetriaca, etapovitá, po konzervatívnej príprave a cievnom vyšetrení; nie je vyliečením.</li>
  <li>Diuretiká nepatria do prvej línie liečby lipedému.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Astrid Rivera. <em>Lipedema: A Multidisciplinary and Surgical Approach to Care.</em> Medscape, 2026 (správa z ICO 2026; verejný byline). <a href="https://www.medscape.com/viewarticle/lipedema-multidisciplinary-and-surgical-approach-care-2026a1000qs9" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></p>

<ol>
  <li><strong>Karen L. Herbst, Linda Anne Kahn, Emily Iker, Chuck Ehrlich, Thomas Wright, Lindy McHutchison, Jaime Schwartz, Molly Sleigh, Paula MC Donahue, Kathleen H. Lisson, Tami Faris, Janis Miller, Erik Lontok, Michael S. Schwartz, Steven M. Dean, John R. Bartholomew, Polly Armour, Margarita Correa-Perez, Nicholas Pennings, Edely L. Wallace, Ethan Larson.</strong> <em>Standard of care for lipedema in the United States.</em> Phlebology. 2021;36(10):779–796. doi: 10.1177/02683555211015887. PMID: 34049453. PMC: PMC8652358. <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC8652358/" target="_blank" rel="noopener noreferrer">PMC (voľný text)</a>.</li>
  <li><strong>Philipp Kruppa, Rachelle Crescenzi, Gabriele Faerber, Isabel Forner-Cordero, Manuel Cornely, Ramin Shayan, Tara Karnezis, Jose Luis Simarro, Paula Frederichi de Souza, Karen Louise Herbst, Mojtaba Ghods, Sandro Michelini.</strong> <em>Lipedema World Alliance Delphi Consensus-Based Position Paper on the Definition and Management of Lipedema: Results from the 2023 Lipedema World Congress in Potsdam.</em> Nature Communications. 2026;17(1):427. doi: 10.1038/s41467-025-68232-z. PMID: 41519859. PMC: PMC12796449. <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC12796449/" target="_blank" rel="noopener noreferrer">PMC (voľný text)</a>.</li>
  <li>Cleveland Clinic. <em>Lipedema: Causes, Symptoms &amp; Treatment.</em> Pacientsky prehľad (sekundárny zdroj). <a href="https://my.clevelandclinic.org/health/diseases/17175-lipedema" target="_blank" rel="noopener noreferrer">clevelandclinic.org</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Autorku Medscape správy (Astrid Rivera) a kompletné autorstvo Herbst 2021 (21 mien) aj Kruppa 2026 (12 mien) som overil v PubMed/eutils, PMC a Crossref – bez obchádzania paywallu. Kongresové tvrdenia z ICO 2026 (klinické pozorovania agonistov GLP-1, šesťmesačná predoperačná príprava) sú citované ako vyjadrenia prednášajúcich, nie ako recenzované primárne dáta. Operačné percentá z kongresovej správy neuvádzam, lebo otvorené zdroje ukazujú, že podobné čísla pochádzajú z retrospektívnych sérií a metaanalýz nerandomizovaných štúdií a občas sa zamieňa priemerný pokles skóre s podielom pacientok. Nefrologická diferenciálna diagnostika edému a postoj k diuretikám sú odborným spracovaním opretým o americký štandard starostlivosti, nie o dávkovacie schémy.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_lipedem-multidisciplinarny-manazment-chirurgia_article',
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
