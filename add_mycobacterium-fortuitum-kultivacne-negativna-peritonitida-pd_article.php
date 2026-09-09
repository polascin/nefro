<?php
/**
 * Odborný článok: Mycobacterium fortuitum ako príčina refraktérnej kultivačne negatívnej peritonitídy pri PD.
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
    'title'        => 'Refraktérna kultivačne negatívna peritonitída pri peritoneálnej dialýze: treba myslieť na Mycobacterium fortuitum',
    'slug'         => 'mycobacterium-fortuitum-kultivacne-negativna-peritonitida-pd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Slovenská kazuistika pripomína netuberkulózne mykobaktérie ako príčinu peritonitídy, ktorá nereaguje na liečbu a zostáva kultivačne negatívna. Podľa ISPD sa lieči kombináciou antibiotík a odstránením katétra.',
    'content'      => <<<'HTML'
<p>Peritonitída zostáva jednou z najzávažnejších komplikácií peritoneálnej dialýzy (PD). Väčšinu epizód spôsobujú bežné grampozitívne alebo gramnegatívne baktérie a pôvodcu možno určiť štandardnou kultiváciou. Osobitný diagnostický problém predstavuje peritonitída s opakovane negatívnymi kultiváciami, ktorá nereaguje na empirickú antibiotickú liečbu.</p>

<p>V takom prípade treba prehodnotiť pôvodnú diagnózu, správnosť odberu a kultivačného postupu, predchádzajúcu expozíciu antibiotikám aj možnosť infekcie neobvyklým mikroorganizmom. Jedným z klinicky významných, hoci zriedkavých pôvodcov je <em>Mycobacterium fortuitum</em>, rýchlo rastúca netuberkulózna mykobaktéria.</p>

<p>Práve na ňu upozorňuje kazuistika publikovaná v <em>Journal of Nephrology</em> v rubrike určenej na poučenia pre klinického nefrológa. Ide o <strong>slovenskú prácu</strong>: autori pochádzajú z Ústavu lekárskej a klinickej mikrobiológie Univerzitnej nemocnice L. Pasteura v Košiciach, z dialyzačného pracoviska v Košiciach a z Jesseniovej lekárskej fakulty Univerzity Komenského v Martine, v spolupráci s Národným referenčným laboratóriom pre mykobaktérie Státního zdravotního ústavu v Prahe.</p>

<h2>Netuberkulózne mykobaktérie pri peritoneálnej dialýze</h2>

<p>Netuberkulózne mykobaktérie (NTM) sú heterogénnou skupinou environmentálnych mikroorganizmov, ktoré sa prirodzene vyskytujú vo vode, pôde, aerosóloch a na povrchoch. Na rozdiel od komplexu <em>Mycobacterium tuberculosis</em> sa typicky neprenášajú medzi ľuďmi a nespôsobujú tuberkulózu.</p>

<p>V súvislosti s peritoneálnou dialýzou môžu vyvolať infekciu výstupu katétra, infekciu podkožného tunela, peritonitídu, kombináciu infekcie katétra a peritonitídy alebo zriedkavo diseminované ochorenie.</p>

<p>Podľa odporúčaní International Society for Peritoneal Dialysis (ISPD) pripadá <strong>väčšina epizód NTM peritonitídy práve na <em>M. fortuitum</em> a <em>M. chelonae</em></strong>; opisovaný je aj <em>M. abscessus</em>.</p>

<p>Označenie „rýchlo rastúce“ je relatívne. Tieto mikroorganizmy môžu na vhodnom médiu vytvoriť viditeľné kolónie približne do siedmich dní, stále však môžu uniknúť diagnostike nastavenej na konvenčné baktérie.</p>

<h3>Charakteristika <em>Mycobacterium fortuitum</em></h3>

<p><em>M. fortuitum</em> je acidorezistentný aeróbny environmentálny mikroorganizmus zo skupiny rýchlo rastúcich netuberkulóznych mykobaktérií, ktorý dokáže vytvárať biofilm na cudzorodých materiáloch.</p>

<p>Práve to je pri peritoneálnom katétri klinicky rozhodujúce. Biofilm môže znižovať účinnosť antibiotík, chrániť mikroorganizmus pred imunitnou odpoveďou, spôsobovať pretrvávanie infekcie napriek zdanlivo vhodnej liečbe, viesť k opakovaným relapsom a podmieňovať potrebu odstránenia katétra.</p>

<p><em>M. fortuitum</em> môže spôsobovať infekcie kože, mäkkých tkanív, operačných rán, katétrov a iných implantovaných pomôcok. Peritonitída pri PD je zriedkavá, môže však mať závažný priebeh a viesť k definitívnemu zlyhaniu dialyzačnej modality.</p>

<h2>Kedy hovoríme o peritonitíde a kedy je kultivačne negatívna</h2>

<p>ISPD odporúča (stupeň 1C) diagnostikovať peritonitídu pri splnení najmenej dvoch z týchto troch kritérií:</p>

<ol>
  <li>klinické prejavy zodpovedajúce peritonitíde, teda bolesť brucha alebo zakalený dialyzát,</li>
  <li>počet leukocytov v dialyzáte nad 100/µl (nad 0,1 × 10<sup>9</sup>/l) <strong>po najmenej dvojhodinovej dobe zotrvania roztoku</strong> v peritoneálnej dutine, s viac než 50 % polymorfonukleárnych leukocytov,</li>
  <li>pozitívna kultivácia dialyzátu.</li>
</ol>

<p>Kultivačne negatívna peritonitída je definovaná ako peritonitída spĺňajúca prvé dve kritériá, pri ktorej sa kultiváciou dialyzátu nezistí žiadny mikroorganizmus. <strong>Negatívna kultivácia teda peritonitídu nevylučuje.</strong></p>

<p>Pri automatizovanej peritoneálnej dialýze s krátkymi výmenami môže byť absolútny počet leukocytov nižší; diagnosticky významný potom môže byť podiel neutrofilov nad 50 %.</p>

<h3>Prečo môže kultivácia zostať negatívna</h3>

<p>ISPD delí príčiny na infekčné a neinfekčné. Medzi infekčné patrí nedávna expozícia antibiotikám, suboptimálny odber alebo kultivačná metodika a nesprávne zaradenie pomaly rastúcich atypických mikroorganizmov, výslovne vrátane <strong>mykobaktérií a húb</strong>. K neinfekčným patrí eozinofilná alebo chemická peritonitída, napríklad po ikodextríne, pri ktorej nemusí byť prítomná prevaha neutrofilov. Hemoperitoneum s prevahou erytrocytov sa s peritonitídou zamieňať nemá.</p>

<p>Riziko negatívnej kultivácie znižuje rýchle doručenie vzoriek alebo naočkovaných fliaš do laboratória a centrifugácia dialyzátu.</p>

<h3>Ako postupovať pri pretrvávajúcej negativite</h3>

<p>Ak kultivácie zostávajú negatívne po troch až piatich dňoch inkubácie, ISPD odporúča poslať dialyzát na opakovaný počet buniek a diferenciálny rozpočet a na <strong>mykotickú a mykobakteriálnu kultiváciu</strong>. Ďalšie tri až štyri dni subkultivácie v aeróbnych, anaeróbnych a mikroaerofilných podmienkach môžu odhaliť pomaly rastúce náročné baktérie a kvasinky, ktoré niektoré automatizované systémy nezachytia. Diagnostickú výťažnosť môže zvýšiť aj <strong>kultivácia samotného katétra</strong>, najmä pri hubách a enterokokoch.</p>

<p>Pri podozrení na NTM treba laboratórium výslovne upozorniť. ISPD uvádza konkrétne: predĺžiť inkubáciu štandardných bakteriálnych kultivácií <strong>na sedem dní</strong> a doplniť špecifické mykobakteriálne médiá.</p>

<p>Negatívna acidorezistentná mikroskopia diagnózu nevylučuje — jej citlivosť je pri nízkom počte mikroorganizmov nedostatočná.</p>

<h2>Kedy myslieť na netuberkulózne mykobaktérie</h2>

<p>ISPD odporúča (stupeň 2D) vyžiadať farbenie podľa Ziehla a Neelsena na acidorezistentné tyčinky vždy, keď je klinické podozrenie na NTM peritonitídu — <strong>vrátane pretrvávajúcej kultivačne negatívnej peritonitídy</strong>.</p>

<p>Podozrenie by mala zvýšiť kombinácia nasledujúcich okolností:</p>

<ul>
  <li>pretrvávajúci zakalený dialyzát a zvýšený počet leukocytov,</li>
  <li>opakovane negatívna štandardná kultivácia,</li>
  <li>nedostatočná odpoveď na obvyklú empirickú liečbu alebo relaps po prechodnom zlepšení,</li>
  <li>súčasná infekcia výstupu alebo tunela katétra — ISPD ju uvádza ako typický sprievodný nález,</li>
  <li>noduly, abscesy alebo atypické kožné lézie v okolí katétra,</li>
  <li>neobvyklý alebo oneskorený mikrobiologický rast,</li>
  <li>nález, ktorý sa nedarí spoľahlivo identifikovať.</li>
</ul>

<p>Osobitne zradné je, že rýchlo rastúce mykobaktérie sa pri Gramovom farbení môžu <strong>zameniť za difteroidy alebo za druhy rodu <em>Corynebacterium</em></strong>. Publikované série preto opisujú medián oneskorenia diagnózy v rozmedzí šesť až tridsať dní.</p>

<h2>Refraktérna peritonitída a rozhodnutie o katétri</h2>

<p>ISPD definuje refraktérnu peritonitídu ako zlyhanie vyčistenia dialyzátu po piatich dňoch vhodnej antibiotickej liečby a pri nej odporúča odstránenie katétra (stupeň 1D). Po začatí liečby zvyčajne nastáva klinické zlepšenie do 72 hodín.</p>

<p>Aktualizácia z roku 2022 však priniesla dôležité zmiernenie: ak sa počet leukocytov v dialyzáte znižuje smerom k norme, je namieste ďalej sledovať účinok antibiotík aj po piatom dni namiesto povinného odstránenia katétra (stupeň 2C). Samotná päťdňová hranica sa v texte odporúčania označuje za <strong>arbitrárny referenčný nástroj</strong> — údaje porovnávajúce dlhodobé výsledky pri päťdňovom pravidle a pri dlhšom čakaní chýbajú.</p>

<p>Rozhodnutie preto musí vychádzať z dynamiky, nie z jedného časového bodu. Skoršie odstránenie katétra je namieste pri hemodynamickej nestabilite, sepse, zhoršujúcej sa bolesti brucha, rastúcom počte leukocytov v dialyzáte, podozrení na chirurgickú príčinu, tunelovej infekcii, plesňovej alebo mykobakteriálnej etiológii a pri progresii napriek adekvátnej liečbe.</p>

<p>Dlhé pokusy liečiť refraktérnu peritonitídu antibiotikami bez odstránenia katétra sa podľa ISPD spájajú s predĺženou hospitalizáciou, poškodením peritoneálnej membrány, vyšším rizikom plesňovej peritonitídy a nadmernou mortalitou.</p>

<h2>Liečba NTM peritonitídy</h2>

<h3>Antibiotiká aj odstránenie katétra</h3>

<p>ISPD odporúča (stupeň 2D) liečiť NTM peritonitídu <strong>súčasne účinnými antibiotikami a odstránením katétra</strong>. Ide o zásadný rozdiel oproti tuberkulóznej peritonitíde, pri ktorej sa naopak odporúča antituberkulózna liečba <em>namiesto</em> odstránenia katétra (stupeň 2C).</p>

<p>Dôvodom je schopnosť NTM vytvárať biofilm, v ktorom môžu pretrvávať napriek antibiotickej liečbe. Odklad odstránenia katétra môže viesť k predĺženiu infekcie, relapsom, progresii tunelovej infekcie, abscesom, poškodeniu peritonea, zlyhaniu peritoneálnej dialýzy a systémovým komplikáciám.</p>

<h3>Trvanie liečby a triezve očakávania</h3>

<p>Údajov o optimálnom trvaní liečby je málo. ISPD uvádza, že <strong>väčšina expertov odporúča dve antibiotiká, na ktoré je izolát citlivý, počas najmenej šiestich týždňov</strong>. Ide o expertný konsenzus, nie o samostatne odstupňované odporúčanie.</p>

<p>Realistické očakávania nastavuje citovaná observačná štúdia 27 po sebe nasledujúcich epizód: úplné vyliečenie sa dosiahlo len u <strong>14,8 %</strong> pacientov napriek liečbe trvajúcej vyše dvoch mesiacov. NTM peritonitída teda aj pri správnom postupe často znamená koniec peritoneálnej dialýzy.</p>

<p>Antibiotickú liečbu treba riadiť podľa identifikovaného druhu a následne podľa citlivosti in vitro. ISPD výslovne odporúča konzultovať výber kombinovanej antimykobakteriálnej liečby s mikrobiológom alebo infektológom.</p>

<h3>Ktoré liečivá prichádzajú do úvahy</h3>

<p>Potenciálnu aktivitu proti niektorým izolátom <em>M. fortuitum</em> môžu mať amikacín, imipeném, fluorochinolóny, doxycyklín alebo minocyklín, kotrimoxazol, linezolid a niektoré makrolidy. Tento zoznam nie je univerzálnym terapeutickým odporúčaním — citlivosť jednotlivých izolátov je premenlivá a medzi laboratórnou citlivosťou a klinickou účinnosťou nemusí byť zhoda.</p>

<p>Pri výbere treba zohľadniť výsledok testovania citlivosti, závažnosť infekcie, prítomnosť biofilmu, osud katétra, reziduálnu funkciu obličiek, liekové interakcie, ototoxicitu a vestibulotoxicitu, hematologickú a neurologickú toxicitu, predĺženie intervalu QT a dostupnosť intravenózneho, perorálneho alebo intraperitoneálneho podania.</p>

<h3>Pozor na makrolidovú rezistenciu</h3>

<p>Pri rýchlo rastúcich mykobaktériách nemožno predpokladať účinnosť makrolidov iba podľa skorého výsledku citlivosti. Niektoré kmene majú indukovateľný mechanizmus rezistencie sprostredkovaný génmi skupiny <em>erm</em>: izolát sa pri úvodnom hodnotení javí ako citlivý, ale pri dlhšej expozícii makrolidu sa rezistencia prejaví. Interpretácia preto patrí mikrobiológovi so skúsenosťou s netuberkulóznymi mykobaktériami. Makrolidová monoterapia nie je vhodným postupom.</p>

<h2>Návrat k peritoneálnej dialýze</h2>

<p>Po odstránení katétra býva pacient dočasne prevedený na hemodialýzu. O opätovnom zavedení katétra možno uvažovať až po klinickom a mikrobiologickom zvládnutí infekcie.</p>

<p>Prekonaná NTM peritonitída budúcu peritoneálnu dialýzu absolútne nevylučuje. Pravdepodobnosť úspešného návratu však znižuje závažnosť a trvanie infekcie, oneskorené odstránenie pôvodného katétra, rozsiahle poškodenie peritonea, adhézie, pretrvávajúca infekcia výstupu alebo tunela, nedostatočná ultrafiltrácia a vysoké riziko recidívy.</p>

<p>Rozhodnutie má byť individuálne, so zohľadnením preferencií pacienta, stavu peritoneálnej membrány, možností cievneho prístupu a rizík dlhodobej hemodialýzy.</p>

<h2>Diferenciálna diagnostika kultivačne negatívnej peritonitídy</h2>

<div class="table-responsive" role="region" aria-label="Príčiny zakaleného dialyzátu pri negatívnej kultivácii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Skupina príčin</th>
      <th scope="col">Konkrétne možnosti</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Infekčné</th>
      <td>Antibiotikami čiastočne potlačená bakteriálna infekcia; mykobakteriálna peritonitída; plesňová peritonitída; mikroorganizmy vyžadujúce špeciálne kultivačné podmienky; sekundárna peritonitída pri intraabdominálnej patológii</td>
    </tr>
    <tr>
      <th scope="row">Neinfekčné, bunkové</th>
      <td>Eozinofilná peritonitída; chemická peritonitída (napríklad po ikodextríne); vzorka odobratá zo suchej brušnej dutiny s prevahou monocytov a makrofágov</td>
    </tr>
    <tr>
      <th scope="row">Neinfekčné, ostatné</th>
      <td>Hemoperitoneum; chylózny dialyzát; malignita; pankreatitída; reakcia na intraperitoneálne podané látky; technický problém pri odbere</td>
    </tr>
  </tbody>
</table>
</div>

<p>Pretrvávajúca bolesť brucha, polymikrobiálny nález, vysoká koncentrácia amylázy v dialyzáte, známky ilea alebo neprimerane závažný systémový stav majú viesť k vyšetreniu možnej chirurgickej príčiny.</p>

<h2>Prevencia</h2>

<p>Úplnú prevenciu NTM infekcií zaručiť nemožno, riziko však znižuje dôsledné dodržiavanie hygienických zásad: hygiena rúk, odporúčaná technika výmen, ochrana katétra pred kontaktom s nekontrolovanou vodou, nepoužívanie vodovodnej vody na ošetrovanie výstupu mimo postupu odporúčaného pracoviskom, správne skladovanie materiálu, včasné hlásenie zmien v okolí výstupu a vyšetrenie atypickej alebo nereagujúcej infekcie katétra.</p>

<p>Environmentálny pôvod mikroorganizmu neznamená, že u každého pacienta možno určiť konkrétny zdroj infekcie. Neprítomnosť zjavnej expozície NTM infekciu nevylučuje.</p>

<h2>Aké dôkazy kazuistika prináša a aké nie</h2>

<p>Zdrojová práca je kazuistickým spracovaním určeným na klinické poučenie, nie kontrolovanou štúdiou. Jej hodnota spočíva v upozornení na diagnostickú možnosť, ktorú rutinný postup prehliadne. Nemôže určiť incidenciu ochorenia, porovnať účinnosť liečebných režimov ani doložiť optimálne trvanie liečby.</p>

<p>Vo verejne dostupnom bibliografickom zázname nie je k dispozícii abstrakt, a teda ani podrobnosti o klinickom priebehu, cytologickom náleze, časovaní kultivácií, konkrétnych antibiotických režimoch, profile citlivosti izolátu, načasovaní odstránenia katétra ani o konečnom osude dialyzačnej modality. Odborné závery tohto článku preto vychádzajú z overiteľnej témy kazuistiky a z odporúčaní ISPD, nie z rekonštrukcie podrobností prípadu.</p>

<h2>Praktické poučenie</h2>

<p>Pri peritonitíde, ktorá zostáva kultivačne negatívna a nereaguje na štandardnú liečbu, by mal nefrológ:</p>

<ol>
  <li>overiť, či sú splnené diagnostické kritériá peritonitídy,</li>
  <li>skontrolovať odber, transport a kultivačný postup vrátane centrifugácie dialyzátu,</li>
  <li>zopakovať počet leukocytov a diferenciálny rozpočet,</li>
  <li>konzultovať prípad s mikrobiológom,</li>
  <li>vyžiadať farbenie na acidorezistentné tyčinky, mykobakteriálnu a mykotickú kultiváciu a predĺženie inkubácie na sedem dní,</li>
  <li>vyšetriť výstup a tunel katétra a zvážiť kultiváciu katétra,</li>
  <li>cielene pátrať po sekundárnej intraabdominálnej príčine,</li>
  <li>neodkladať odstránenie katétra pri refraktérnom priebehu, najmä pri potvrdenej NTM etiológii,</li>
  <li>po identifikácii NTM zvoliť kombináciu najmenej dvoch antibiotík podľa citlivosti,</li>
  <li>priebežne hodnotiť toxicitu dlhodobej antibiotickej liečby.</li>
</ol>

<h2>Záver</h2>

<p><em>Mycobacterium fortuitum</em> je zriedkavý, ale klinicky významný pôvodca peritonitídy pri peritoneálnej dialýze — spolu s <em>M. chelonae</em> tvorí väčšinu epizód NTM peritonitídy. Diagnóza býva oneskorená o šesť až tridsať dní, pretože štandardné kultivácie zostávajú negatívne, mikroorganizmus sa dá pri Gramovom farbení zameniť za difteroidy a úvodná antibiotická liečba nie je účinná.</p>

<p>Na NTM treba myslieť pri refraktérnej alebo relabujúcej peritonitíde, najmä ak je spojená s infekciou výstupu či tunela katétra. Diagnostika vyžaduje úzku spoluprácu nefrológa a mikrobiológa, druhovú identifikáciu a testovanie citlivosti.</p>

<p>Základom liečby je podľa ISPD súčasné odstránenie peritoneálneho katétra a účinná antibiotická liečba; väčšina expertov odporúča dve antibiotiká podľa citlivosti počas najmenej šiestich týždňov. Údaje o úplnom vyliečení sú pritom skromné, takže očakávania majú byť triezve a rozhovor s pacientom o možnom prechode na hemodialýzu má prísť včas.</p>

<p>Najdôležitejším praktickým posolstvom je, že opakovane negatívna kultivácia pri pretrvávajúcej peritonitíde nemá viesť k opakovaniu toho istého empirického režimu. Má viesť k prehodnoteniu diagnózy, rozšíreniu mikrobiologického vyšetrenia a včasnému rozhodnutiu o ďalšom osude katétra.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=taurolidin-relapsujuca-peritonitida-peritonealna-dialyza">Adjuvantný taurolidín pri relapsujúcej peritonitíde na peritoneálnej dialýze: záchrana katétra alebo slepá ulička?</a></li>
  <li><a href="article.php?slug=klucove-intervencie-peritonealna-dialyza-prevencia-infekcii">Kľúčové intervencie v peritoneálnej dialýze: prevencia infekcií ako spoločná zodpovednosť tímu</a></li>
  <li><a href="article.php?slug=ako-prebieha-peritonealna-dialyza">Ako prebieha peritoneálna dialýza a príprava na ňu</a></li>
  <li><a href="article.php?slug=infekcie-krvneho-rieciska-hemodialyza-mikrobiologicke-spektrum">Infekcie krvného riečiska pri hemodialýze: ich výskyt klesá, mikrobiologické spektrum sa však môže meniť</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Schreterova E, Rosenberger J, Baltesova T, Dohal M, Dvorakova V. Mycobacterium fortuitum as a Cause of Refractory Culture-Negative Peritonitis in a Peritoneal Dialysis Patient. Journal of Nephrology. 2026. doi: 10.1093/joneph/aajag235. PMID 42700380. <a href="https://pubmed.ncbi.nlm.nih.gov/42700380/" target="_blank" rel="noopener noreferrer">PubMed</a>. Hlavný spracovaný zdroj; v čase spracovania dostupný ako publikácia pred zaradením do čísla, bez verejného abstraktu.</em></small></li>
  <li><small><em>Li PK, Chow KM, Cho Y, Fan S, Figueiredo AE, Harris T, Kanjanabuch T, Kim YL, Madero M, Malyszko J, Mehrotra R, Okpechi IG, Perl J, Piraino B, Runnegar N, Teitelbaum I, Wong JK, Yu X, Johnson DW. ISPD peritonitis guideline recommendations: 2022 update on prevention and treatment. Peritoneal Dialysis International. 2022;42(2):110–153. doi: 10.1177/08968608221080586. PMID 35264029. <a href="https://pubmed.ncbi.nlm.nih.gov/35264029/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://ispd.org/wp-content/uploads/2025/09/LI-ET-1.pdf" target="_blank" rel="noopener noreferrer">plný text ISPD</a>. Zdroj definícií peritonitídy a refraktérnej peritonitídy aj odporúčaní pre NTM peritonitídu.</em></small></li>
  <li><small><em>Fung WW, Chow KM, Li PK, Szeto CC. Clinical course of peritoneal dialysis-related peritonitis due to non-tuberculosis mycobacterium — a single centre experience spanning 20 years. Peritoneal Dialysis International. 2022;42(2):204–211. doi: 10.1177/08968608211042434. <a href="https://doi.org/10.1177/08968608211042434" target="_blank" rel="noopener noreferrer">DOI</a>. Zdroj údaja o nízkej miere úplného vyliečenia; odporúčanie ISPD ju cituje ešte v podobe pred zaradením do čísla.</em></small></li>
  <li><small><em>Renaud CJ, Subramanian S, Tambyah PA, Lee EJC. The clinical course of rapidly growing nontuberculous mycobacterial peritoneal dialysis infections in Asians: a case series and literature review. Nephrology (Carlton). 2011;16(2):174–179. doi: 10.1111/j.1440-1797.2010.01370.x. <a href="https://doi.org/10.1111/j.1440-1797.2010.01370.x" target="_blank" rel="noopener noreferrer">DOI</a>. Práca, o ktorú ISPD opiera expertné odporúčanie dvoch antibiotík počas najmenej šiestich týždňov.</em></small></li>
  <li><small><em>Song Y, Wu J, Yan H, Chen J. Peritoneal dialysis-associated nontuberculous mycobacterium peritonitis: a systematic review of reported cases. Nephrology Dialysis Transplantation. 2012;27(4):1639–1644. doi: 10.1093/ndt/gfr504. <a href="https://doi.org/10.1093/ndt/gfr504" target="_blank" rel="noopener noreferrer">DOI</a>.</em></small></li>
  <li><small><em>Clinical and Laboratory Standards Institute. Susceptibility Testing of Mycobacteria, Nocardia spp., and Other Aerobic Actinomycetes. CLSI Standard M24. Wayne, Pennsylvania. <a href="https://clsi.org/standards/products/microbiology/documents/m24/" target="_blank" rel="noopener noreferrer">CLSI</a>. Metodika testovania citlivosti mykobaktérií vrátane rýchlo rastúcich druhov; aktuálnu verziu treba overiť v katalógu CLSI.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_mycobacterium-fortuitum-kultivacne-negativna-peritonitida-pd_article',
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
