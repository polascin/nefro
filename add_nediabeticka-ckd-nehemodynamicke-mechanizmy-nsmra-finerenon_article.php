<?php

/**
 * add_nediabeticka-ckd-nehemodynamicke-mechanizmy-nsmra-finerenon_article.php
 * Odborný článok — UPSERT (vloženie aj regenerácia). Pozri PUBLIKOVANIE_CLANKOV.md.
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Beyond hemodynamics: nové dôkazy a perspektívy nediabetickej chronickej choroby obličiek (CKD)',
    'slug'         => 'nediabeticka-ckd-nehemodynamicke-mechanizmy-nsmra-finerenon',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prehľad nových dôkazov z ERA kongresu: pri nediabetickej CKD sa ťažisko presúva od hemodynamiky (RAAS, SGLT2) k nehemodynamickým cieľom — zápalu, fibróze a aldosterónovej osi (finerenón, FIND-CKD, INFINITY).',
    'content'      => <<<'HTML'
<p>Medscape vzdelávacia aktivita „Hot Off the Press: Emerging Therapies in Nondiabetic Kidney Disease“ prináša prehľad nových klinických dát prezentovaných na kongrese Európskej renálnej asociácie (ERA) a z nich vyplývajúci praktický smer: pri nediabetickej CKD sa čoraz viac posúvame od samotnej hemodynamiky (inhibícia RAAS, SGLT2 inhibítory) k cieleniu <strong>nehemodynamických</strong> — predovšetkým zápalových a fibrotizujúcich — mechanizmov poškodenia. V centre pozornosti sú <strong>nesteroidné antagonisty mineralokortikoidového receptora (nsMRA)</strong>, najmä <strong>finerenón</strong>, doplnené o ďalšie triedy liekov, ktoré sa snažia ovplyvniť aldosterónovú os „vyššie v kaskáde“ (<em>upstream</em>) aj zápalovú signalizáciu.</p>

<p>Tento článok sumarizuje hlavné argumenty, ktoré podľa zdroja podporujú rozšírenie „pilierovej“ liečby aj u pacientov bez diabetu, a vysvetľuje, kde sa objavujú najvýraznejšie benefity.</p>

<h2>1. Prečo nestačí hemodynamika: reziduálne riziko pri nediabetickej CKD</h2>

<p>Zdroj explicitne rámcuje problém ako <strong>reziduálne riziko</strong> (<em>residual risk</em>). Aj keď štandardná starostlivosť dnes zahŕňa inhibítory RAAS a SGLT2 inhibítory, časť pacientov napriek liečbe pokračuje v progresii CKD a/alebo dosahuje fatálne kardiovaskulárne (KV) a renálne ukončenia.</p>

<p>Kľúčové je, že reziduálne riziko sa v praxi často odvíja od <strong>albuminúrie</strong>. Podľa zdroja je albuminúria významným hnacím faktorom progresie a jej zníženie v danom čase koreluje s priaznivejšou budúcnosťou z hľadiska poklesu funkcie obličiek aj klinických udalostí.</p>

<p>Z toho vyplýva logická výzva: ak hemodynamické mechanizmy vysvetľujú len časť progresie, potom treba cieliť aj ďalšie determinanty poškodenia.</p>

<h2>2. Nehemodynamické mechanizmy progresie: zápal, fibróza a aldosterón ako spúšťač</h2>

<p>Ako významné nehemodynamické vodiče progresie sa v diskusii opisujú najmä:</p>

<ul>
  <li><strong>zápalové dráhy</strong> (<em>inflammatory pathways</em>),</li>
  <li><strong>fibróza</strong> a následný pokles schopnosti obličky udržať funkciu.</li>
</ul>

<p>Albuminúria je tu opísaná ako spúšťač glomerulárneho poškodenia, ktoré následne ťahá aj tubulárne zranenie. Tento reťazec vedie k fibróze a zhoršeniu výsledkov.</p>

<p>Zdroj ďalej tematizuje rolu <strong>renín-angiotenzín-aldosterónového systému (RAAS)</strong> a najmä <strong>aldosterónu</strong>. V časti o aldosteróne ide o posun v interpretácii: nejde len o „škodlivé zvýšenie“, ale o dôsledky <strong>chronicky (aj subklinicky) zvýšenej aktivácie</strong>. Zdroj uvádza, že aj subklinický nadbytok aldosterónu môže predikovať pokles eGFR a nepriaznivé klinické výsledky, čo podporuje úvahu, že zníženie tvorby aldosterónu alebo blokovanie jeho účinku na mineralokortikoidovom receptore môže mať pri ochoreniach obličiek význam.</p>

<p>Prakticky to znamená, že terapia zameraná na aldosterónovú os môže byť jedným zo spôsobov, ako „dopĺňať“ SGLT2 a RAAS inhibíciu tak, aby sa pokryli viaceré mechanizmy progresie naraz.</p>

<h2>3. Finerenón pri nediabetickej CKD: FIND-CKD ako rozhodujúci signál</h2>

<h3>3.1. Otázka, ktorú štúdia riešila</h3>

<p>Zdroj zdôrazňuje, že finerenón (nsMRA) už priniesol relevantné benefity pri <strong>diabetickej</strong> chorobe obličiek, no nebolo jasné, či rovnaký koncept bude fungovať aj u pacientov s <strong>nediabetickou</strong> CKD. Preto sa uvádza štúdia <strong>FIND-CKD</strong>.</p>

<h3>3.2. Dizajn a populácia</h3>

<p>FIND-CKD (podľa zdroja) zahrnula:</p>

<ul>
  <li><strong>1584 pacientov</strong> s <strong>nediabetickou</strong> CKD,</li>
  <li>eGFR &gt; 25 a &lt; 75 ml/min/1,73 m²,</li>
  <li>albuminúriu najmenej <strong>200 mg/g</strong>,</li>
  <li>všetci boli liečení <strong>stabilnou inhibíciou RAAS</strong>.</li>
</ul>

<p>Randomizácia prebehla do ramena <strong>finerenón</strong> verzus <strong>placebo</strong>.</p>

<p>Primárnym ukazovateľom bol <strong>celkový sklon poklesu GFR</strong> (rýchlosť poklesu GFR za 3 roky). V sekundárnych a ďalších ukazovateľoch sa sledovali aj klinicky tvrdé výsledky vrátane kombinovaných renálnych a KV udalostí.</p>

<h3>3.3. Výsledky: sklon eGFR a preklad do tvrdých ukazovateľov</h3>

<p>Podľa zdroja pacienti v skupine placeba strácali približne <strong>4 ml/min za rok</strong>. V ramene finerenónu sa pokles zmenšil na <strong>3,3 ml/min za rok</strong>, čo predstavuje absolútny rozdiel približne <strong>0,7 ml/min za rok</strong>.</p>

<p>Aj keď tento rozdiel na úrovni sklonu môže pôsobiť „mierne“, zdroj uvádza dôležitý preklad do klinických výsledkov: pre kľúčový sekundárny kompozitný ukazovateľ (zahŕňajúci napr. zlyhanie obličiek alebo 57 % pokles GFR, hospitalizácie pre zlyhanie srdca a KV smrť) sa dosiahlo približne <strong>23 % relatívne zníženie rizika</strong> a výsledok bol štatisticky významný.</p>

<h3>3.4. Bezpečnosť: hyperkaliémia a znášanlivosť</h3>

<p>Z hľadiska bezpečnosti bol finerenón podľa zdroja celkovo dobre znášaný a bez signálu nerovnováhy v závažných nežiaducich udalostiach.</p>

<p>Hyperkaliémia sa vyskytovala častejšie pri finerenóne než pri placebe (v zdroji uvedené približne <strong>17 % verzus 13,3 %</strong>). Dôležité však je, že klinicky relevantná hyperkaliémia vedúca k trvalému vysadeniu liečby alebo k hospitalizácii bola podľa zdroja nízka (uvádzané <strong>&lt; 2 %</strong>).</p>

<p>Toto je praktický bod, lebo cieľom takejto terapie je zmysluplná účinnosť bez neprijateľnej bezpečnostnej záťaže.</p>

<h2>4. Špecifická výzva: glomerulárne ochorenia vo FIND-CKD</h2>

<p>Glomerulárne ochorenia sú v diskusii opísané ako populácia s historicky menším počtom liečebných možností a rýchlejším zhoršovaním.</p>

<p>Zdroj pripomína, že FIND-CKD zahrnula:</p>

<ul>
  <li><strong>903 pacientov</strong> s diagnózou glomerulárnej choroby podľa vyšetrujúceho lekára (čo je <strong>57 %</strong> populácie),</li>
  <li>v štruktúre boli uvedené napr. <strong>IgA nefropatia</strong>, <strong>FSGS</strong>, <strong>membranózna nefropatia</strong> a aj iné menej časté glomerulárne diagnózy.</li>
</ul>

<p>Zaujímavé je aj to, že približne <strong>80 %</strong> prípadov malo diagnózu potvrdenú biopsiou, pričom zdroj naznačuje variabilitu biopsických postupov v rôznych krajinách.</p>

<h3>4.1. Renálny sklon, albuminúria a exploračné kompozity</h3>

<p>Podľa zdroja bola v placebovom ramene ročná strata GFR približne <strong>4,2 ml/min za rok</strong>, zatiaľ čo v ramene finerenónu približne <strong>3,5 ml/min za rok</strong>, čím vzniká absolútny rozdiel <strong>0,7 ml/min za rok</strong>. To je konzistentné s celkovou populáciou FIND-CKD.</p>

<p>Zdroj ďalej uvádza:</p>

<ul>
  <li>lepší <strong>chronický sklon</strong> (bez akútneho poklesu) o približne <strong>1,2 ml/min za rok</strong>,</li>
  <li>pokles albuminúrie oproti východiskovej hodnote v priebehu <strong>12 mesiacov</strong> o približne <strong>42 %</strong>,</li>
  <li>v exploračnom kompozite (zahŕňajúcom napr. zlyhanie obličiek alebo 40 % pokles GFR) relatívne zníženie rizika približne <strong>26 %</strong>.</li>
</ul>

<h3>4.2. Konzistentnosť naprieč podtypmi a nezávislosť od SGLT2</h3>

<p>Zdroj zdôrazňuje, že benefity boli konzistentné naprieč podtypmi glomerulárnych chorôb (IgA nefropatia, FSGS, membranózna nefropatia) a že výsledky sa nelíšili podľa toho, či pacienti užívali SGLT2 inhibítory.</p>

<p>Praktický význam: nsMRA sa v tejto interpretácii nevníma ako „liečba len pre jeden typ“, ale ako relatívne univerzálny príspevok k spomaleniu progresie v skupinách, kde je podstatná albuminúria a následné (<em>downstream</em>) zápalové poškodenie.</p>

<h2>5. INFINITY: pohľad naprieč spektrom CKD a preklad na klinicky relevantné výsledky</h2>

<p>Zdroj uvádza program <strong>INFINITY</strong>, ktorý je <strong>metaanalýzou na úrovni individuálnych účastníkov</strong> (<em>individual participant data</em>) štúdie FIND-CKD a predchádzajúcich diabetických štúdií (FIGARO-DKD a FIDELIO-DKD).</p>

<p>Cieľom je zistiť účinky finerenónu naprieč:</p>

<ul>
  <li>prítomnosťou alebo neprítomnosťou diabetu,</li>
  <li>rôznymi úrovňami <strong>GFR</strong> a <strong>albuminúrie</strong>,</li>
  <li>rôznymi charakteristikami pacientov.</li>
</ul>

<p>Podľa zdroja finerenón v programe INFINITY:</p>

<ul>
  <li>znížil riziko progresie CKD približne o <strong>24 %</strong>,</li>
  <li>znížil riziko hospitalizácie pre zlyhanie srdca alebo KV smrti o <strong>20 %</strong>,</li>
  <li>znížil riziko dialýzy o <strong>15 %</strong>,</li>
  <li>znížil KV smrť o <strong>18 %</strong>,</li>
  <li>znížil celkovú (<em>all-cause</em>) mortalitu o <strong>12 %</strong>.</li>
</ul>

<p>Zdroj zároveň zdôrazňuje konzistentnosť naprieč príčinami ochorenia obličiek, statusom diabetu, úrovňami GFR, albuminúriou aj užívaním SGLT2.</p>

<p>V kontexte článku je dôležité, že táto interpretácia podporuje koncept, podľa ktorého môže byť finerenón „základným“ pilierom terapie podobne, ako dnes u mnohých pacientov vnímame SGLT2.</p>

<h2>6. Kto má najväčší absolútny benefit</h2>

<p>Zdroj priamo rieši otázku, „kto z toho vyťaží najviac v absolútnych číslach“.</p>

<p>Argumentácia vychádza z toho, že niektorí pacienti majú vyššie východiskové riziko a výraznejšie konkurenčné riziko KV udalostí. Pri diabete je diabetes silným vodičom KV rizika, a preto sú absolútne benefity pri KV a mortalitných ukazovateľoch (v tejto interpretácii) väčšie. Pri nediabetickej CKD však benefity pretrvávajú, len v absolútnych číslach môžu byť menšie — čo však stále môže byť klinicky relevantné.</p>

<p>Pri glomerulárnych chorobách zdroj uvádza, že podskupinová analýza naznačila zvlášť výrazný signál pri <strong>FSGS</strong>, a ponúka biologické vysvetlenie: mineralokortikoidový receptor je exprimovaný na <strong>podocytoch</strong> a prehnaná aktivácia tohto receptora môže podporovať ich poškodenie.</p>

<p>Toto je dobrý príklad toho, ako sa od mechanizmu prechádza ku klinickému pozorovaniu. Zároveň je férové dodať, že podskupinové interpretácie treba vždy brať opatrne a držať ich v hraniciach toho, čo štúdie reálne dokazujú.</p>

<h2>7. Steroidné verzus nesteroidné antagonisty mineralokortikoidového receptora: prečo je finerenón vpredu</h2>

<p>Zdroj pomenúva „slona v miestnosti“: ako sa finerenón líši od <strong>spironolaktónu</strong>.</p>

<p>Ako hlavný argument sa uvádza, že veľká štúdia so steroidným MRA pri CKD, <strong>BARACK-D</strong>, mala výrazne vyššiu mieru ukončenia liečby pre bezpečnostné problémy. Podľa zdroja až dve tretiny pacientov v ramene spironolaktónu ukončili liečbu pre protokolom riadené bezpečnostné obmedzenia.</p>

<p>Okrem toho zdroj uvádza, že dôkazy pre spironolaktón a eplerenón pri CKD sú podľa neho obmedzené menšími štúdiami s nekonzistentnými výsledkami a len skromnými účinkami na albuminúriu.</p>

<p>Z toho zdroj vyvodzuje, že aktuálne sú dôkazy silnejšie pre nsMRA — a to je presne dôvod, prečo sa v tejto diskusii stavia finerenón do centra pozornosti.</p>

<h2>8. Terapia „upstream“: inhibítory aldosterónsyntázy a prebiehajúce fázy výskumu</h2>

<p>Zdroj opisuje pre nefrológa obdobie nezvyčajne bohaté na nové dáta: popri finerenóne pribúdajú údaje z tried liekov zameraných na aldosterónovú os, no odlišným mechanizmom. Namiesto blokovania receptora ide o zásah do tvorby aldosterónu.</p>

<p>Ako mechanistická logika sa uvádza, že inhibícia aldosterónsyntázy môže znížiť zápal, znížiť podocytový zápal, znížiť albuminúriu, a tým následne aj tubulárne/glomerulárne zranenie a progresiu do terminálneho štádia CKD — a zároveň môže znížiť aj hypertenziu.</p>

<p>Zdroj spomína tri prebiehajúce programy s plánovanými výsledkami v horizonte rokov:</p>

<ul>
  <li><strong>FigHTN</strong> s baxdrostatom pri CKD s nekontrolovanou hypertenziou (pričom sa zdôrazňuje, že tieto lieky môžu znižovať krvný tlak),</li>
  <li><strong>BaxDuo-ARCTIC</strong> a <strong>BaxDuo-PACIFIC</strong> ako fáza 3 kombinujúca baxdrostat s dapagliflozínom,</li>
  <li><strong>EASi-KIDNEY</strong>: vicadrostat plus štandardná starostlivosť, konkrétne vicadrostat a empagliflozín.</li>
</ul>

<p>V texte sa uvádza, že do budúcna bude potrebné vybrať správne fenotypy a indikovať liečbu pacientom s najväčším očakávaným benefitom.</p>

<h2>9. Endotelínové receptory a „vypnutie“ zápalových kaskád</h2>

<p>Ďalšou triedou liekov v diskusii sú <strong>antagonisty endotelínových receptorov</strong>.</p>

<p>Zdroj upozorňuje, že endotelínové receptory majú dve zložky — <strong>ETA</strong> a <strong>ETB</strong>. V interpretácii zdroja blokáda ETA vedie k zníženiu albuminúrie a zápalu, zatiaľ čo ETB môže zvyšovať retenciu tekutín.</p>

<p>V klinickom vývoji sa spomína <strong>zibotentan</strong> (fáza 3) a kombinácia zibotentanu s dapagliflozínom. Podľa zdroja by výsledky mali prísť v roku 2027.</p>

<p>Zápalová logika v texte sa opiera o blokádu následnej signalizácie spojenej s NF-κB a o pokles zápalových cytokínov. V rámci kombinácií to má byť „ďalší nástroj“ popri finerenóne, SGLT2 a inhibícii RAAS.</p>

<h2>10. Atrasentan: ďalší príspevok do algoritmov pri IgA nefropatii</h2>

<p>Zdroj spomína aj liek <strong>atrasentan</strong>, pre ktorý sa očakávajú výsledky v populácii <strong>IgA nefropatie</strong>.</p>

<p>Pozoruhodné je, že podľa prezentácie nejde o liek „výlučne pre IgA“, ale skôr o liek pri CKD, ktorý má význam pre populáciu s IgA nefropatiou. Zmysel je v tom, že zníženie albuminúrie sa v tejto logike spája so znížením zápalu, podocytového a tubulárneho poškodenia a s nižším rizikom progresie do terminálneho štádia CKD.</p>

<h2>11. Kam smeruje štandard: kombinovaná, etiológiu zohľadňujúca a rizikovo orientovaná terapia</h2>

<p>V závere zdroj sumarizuje veľkú tendenciu: posun smerom ku <strong>kombinovanej terapii</strong> ako novému štandardu.</p>

<p>Argumentácia vychádza z toho, že progresia CKD je multifaktoriálna a vyžaduje zásah do viacerých mechanizmov. Pri diabetickej CKD sa v diskusii explicitne uvádza, že existujú štyri overené terapie znižujúce riziko zlyhania obličiek aj KV riziko: <strong>inhibícia RAAS, SGLT2 inhibítory, nesteroidné MRA a agonisty GLP-1 receptora</strong>.</p>

<p>Pri nediabetickej CKD sú v texte ako piliere uvedené inhibícia RAAS, SGLT2 inhibícia a teraz aj nsMRA. Do budúcna sa očakávajú ďalšie možnosti.</p>

<p>Zdroj zároveň kladie dôraz na špecifikum nediabetickej CKD: treba riešiť aj <strong>príčinu</strong> (terapia špecifická pre etiológiu), nielen následky. Pri niektorých imunologických ochoreniach obličiek, najmä pri IgA nefropatii, sa zdôrazňuje smerovanie k terapiám špecifickým pre etiológiu.</p>

<p>Zároveň sa zdôrazňuje, že pacienti s najvyšším rizikom budú mať najväčší absolútny benefit a že treba zlepšiť identifikáciu vysokorizikových jedincov a liečiť ich včasnejšie a intenzívnejšie.</p>

<h2>12. Praktické implikácie pre nefrológa (vychádzajúce z logiky zdroja)</h2>

<p>Tento článok nie je klinickým odporúčaním a neuvádza indikácie ani dávkovacie schémy. Vychádza však z mechanistickej a dôkazovej logiky prezentovanej v zdroji a dá sa z nej zostaviť praktický rámec:</p>

<ol>
  <li><strong>Albuminúria ako reziduálne riziko:</strong> ak pacient napriek štandardnej starostlivosti pokračuje v rizikovej trajektórii, treba uvažovať o rozšírení mechanizmov, ktoré liečba cieli.</li>
  <li><strong>Aldosterónová os a zápal:</strong> výsledky FIND-CKD pri nediabetickej CKD poskytujú dôvod vnímať nsMRA (finerenón) ako terapiu, ktorá sa neopiera len o hemodynamiku.</li>
  <li><strong>Glomerulárne choroby nie sú „okraj“:</strong> v tejto diskusii je glomerulárna populácia veľká a benefity sa vnímajú ako konzistentné naprieč podtypmi.</li>
  <li><strong>Bezpečnosť hyperkaliémie je kľúčový praktický faktor:</strong> podľa zdroja je signál zvýšenej hyperkaliémie prítomný, no závažné klinicky relevantné udalosti sú nízke. Aj preto sa pri zavádzaní tejto triedy liekov v praxi očakáva potreba monitorovania a manažmentu rizika.</li>
  <li><strong>Výber populácie:</strong> budúcnosť patrí kombináciám a selekcii podľa rizika a fenotypu vrátane terapií špecifických pre etiológiu pri vybraných diagnózach.</li>
</ol>

<h2>Záver</h2>

<p>Podľa zdroja sa pri nediabetickej CKD mení paradigma: hemodynamické cesty sú dôležité, ale nie sú kompletné. Aldosterónová os a nehemodynamické mechanizmy zápalu a fibrózy vytvárajú racionálny cieľ pre terapiu nsMRA. Dôkazy z FIND-CKD podporujú finerenón ako liek, ktorý spomaľuje pokles GFR a prekladá sa aj do klinicky významných renálnych a KV výsledkov vrátane veľkej glomerulárnej podskupiny. Program INFINITY potom posilňuje konzistentnosť účinku naprieč spektrom CKD.</p>

<p>Súčasne prebiehajú ďalšie výskumné línie, ktoré idú „vyššie v kaskáde“ (inhibítory aldosterónsyntázy) alebo zasahujú do endotelínovej signalizácie. V horizonte rokov má zmysel očakávať posun ku kombinovanej a fenotypovo aj etiologicky riadenej liečbe tak, aby sa pacientom s najvyšším reziduálnym rizikom podarilo predĺžiť čas do renálnej „cieľovej udalosti“ a znížiť KV úmrtnosť.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape vzdelávacia aktivita „Hot Off the Press: Emerging Therapies in Nondiabetic Kidney Disease“ (2026), rozhovorové vystúpenie: Brendon Neuen, MBBS, PhD, MSc; Beatriz Fernandez-Fernandez, MD, PhD. <a href="https://www.medscape.org/viewarticle/hot-press-new-evidence-emerging-therapies-nondiabetic-ckd-2026a1000k2g" target="_blank" rel="noopener noreferrer">Odkaz na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

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
