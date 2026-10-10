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
    'excerpt'      => 'Prehľad nových dôkazov z ERA kongresu: pri nediabetickej CKD sa ťažisko presúva od hemodynamiky (RAAS, SGLT2) k nehemodynamickým cieľom – zápalu, fibróze a aldosterónovej osi (finerenón, FIND-CKD, INFINITY).',
    'content'      => <<<'HTML'
<figure><a href="img/nediabeticka-ckd-nehemodynamicke-mechanizmy-nsmra-finerenon.webp" rel="noopener noreferrer" target="_blank"><img src="img/nediabeticka-ckd-nehemodynamicke-mechanizmy-nsmra-finerenon.webp" alt="Oblička so stlmenou tlakovou cestou a jasne svietiacimi fibróznymi, zápalovými a hormonálnymi mechanizmami" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická vizualizácia. Tlak vysvetľuje len časť poškodenia – zvyšok prebieha mechanizmami, ktoré s ním nesúvisia.</figcaption></figure>

<p>Medscape vzdelávacia aktivita „Hot Off the Press: Emerging Therapies in Nondiabetic Kidney Disease“ prináša prehľad nových klinických údajov prezentovaných na kongrese Európskej renálnej asociácie (ERA) a praktický smer, ktorý z nich vyplýva: pri nediabetickej CKD sa liečba posúva od samotnej hemodynamiky (inhibícia RAAS, SGLT2 inhibítory) k <strong>nehemodynamickým</strong> mechanizmom poškodenia – predovšetkým zápalovým a fibrotizujúcim. V centre pozornosti sú <strong>nesteroidné antagonisty mineralokortikoidového receptora (nsMRA)</strong>, najmä <strong>finerenón</strong>, doplnené o ďalšie triedy liekov, ktoré sa snažia ovplyvniť aldosterónovú os „vyššie v kaskáde“ (<em>upstream</em>) aj zápalovú signalizáciu.</p>

<p>Článok zhŕňa hlavné argumenty, ktoré podľa zdroja podporujú rozšírenie „pilierovej“ liečby aj na pacientov bez diabetu, a ukazuje, kde je prínos najvýraznejší.</p>

<h2>1. Prečo nestačí hemodynamika: reziduálne riziko pri nediabetickej CKD</h2>

<p>Zdroj opisuje problém ako <strong>reziduálne riziko</strong> (<em>residual risk</em>). Hoci štandardná starostlivosť dnes zahŕňa inhibítory RAAS a inhibítory SGLT2, časť pacientov napriek liečbe pokračuje v progresii CKD a/alebo dosahuje fatálne kardiovaskulárne (KV) a renálne ukončenia.</p>

<p>Reziduálne riziko sa v praxi často odvíja od <strong>albuminúrie</strong>. Podľa zdroja je albuminúria významným hnacím faktorom progresie a jej zníženie koreluje s pomalším poklesom funkcie obličiek aj s menším počtom klinických udalostí.</p>

<p>Ak hemodynamické mechanizmy vysvetľujú len časť progresie, liečba sa musí zamerať aj na ďalšie determinanty poškodenia.</p>

<h2>2. Nehemodynamické mechanizmy progresie: zápal, fibróza a aldosterón ako spúšťač</h2>

<p>Ako významné nehemodynamické hnacie mechanizmy progresie sa v diskusii opisujú najmä:</p>

<ul>
  <li><strong>zápalové dráhy</strong> (<em>inflammatory pathways</em>),</li>
  <li><strong>fibróza</strong> a následný pokles schopnosti obličky udržať funkciu.</li>
</ul>

<p>Albuminúria je tu opísaná ako spúšťač glomerulárneho poškodenia, na ktoré nadväzuje poškodenie tubulov. Tento reťazec vedie k fibróze a horším výsledkom.</p>

<p>Zdroj sa ďalej venuje úlohe <strong>renín-angiotenzín-aldosterónového systému (RAAS)</strong>, najmä <strong>aldosterónu</strong>. Pri aldosteróne sa posúva interpretácia: nejde len o „škodlivé zvýšenie“, ale o dôsledky <strong>chronicky (aj subklinicky) zvýšenej aktivácie</strong>. Zdroj uvádza, že aj subklinický nadbytok aldosterónu môže predikovať pokles eGFR a nepriaznivé klinické výsledky, čo podporuje úvahu, že zníženie tvorby aldosterónu alebo blokovanie jeho účinku na mineralokortikoidovom receptore môže mať pri ochoreniach obličiek význam.</p>

<p>Liečba zameraná na aldosterónovú os tak môže dopĺňať inhibíciu SGLT2 a RAAS a pokryť viac mechanizmov progresie naraz.</p>

<h2>3. Finerenón pri nediabetickej CKD: FIND-CKD ako rozhodujúci signál</h2>

<h3>3.1. Otázka, ktorú štúdia riešila</h3>

<p>Finerenón (nsMRA) už preukázal prínos pri <strong>diabetickej</strong> chorobe obličiek, no nebolo jasné, či rovnaký koncept bude fungovať aj pri <strong>nediabetickej</strong> CKD. Na túto otázku odpovedala štúdia <strong>FIND-CKD</strong>.</p>

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

<h3>3.3. Výsledky: sklon eGFR a tvrdé ukazovatele</h3>

<p>Podľa zdroja pacienti v skupine placeba strácali približne <strong>4 ml/min za rok</strong>. V ramene finerenónu sa pokles zmenšil na <strong>3,3 ml/min za rok</strong>, čo predstavuje absolútny rozdiel približne <strong>0,7 ml/min za rok</strong>.</p>

<p>Rozdiel v sklone môže pôsobiť „mierne“, zdroj však uvádza aj klinické výsledky: pri kľúčovom sekundárnom kompozitnom ukazovateli (zahŕňajúci napr. zlyhanie obličiek alebo 57 % pokles GFR, hospitalizácie pre zlyhanie srdca a KV smrť) sa dosiahlo približne <strong>23 % relatívne zníženie rizika</strong> a výsledok bol štatisticky významný.</p>

<h3>3.4. Bezpečnosť: hyperkaliémia a znášanlivosť</h3>

<p>Z hľadiska bezpečnosti bol finerenón podľa zdroja celkovo dobre znášaný a bez signálu nerovnováhy v závažných nežiaducich udalostiach.</p>

<p>Hyperkaliémia sa vyskytovala častejšie pri finerenóne než pri placebe (v zdroji približne <strong>17 % verzus 13,3 %</strong>). Klinicky relevantná hyperkaliémia vedúca k trvalému vysadeniu liečby alebo k hospitalizácii však bola podľa zdroja zriedkavá (<strong>&lt; 2 %</strong>). Prakticky to je podstatné, pretože účinnosť nesmie byť vykúpená neprijateľnou bezpečnostnou záťažou.</p>

<h2>4. Špecifická výzva: glomerulové ochorenia vo FIND-CKD</h2>

<p>Glomerulové ochorenia sú v diskusii opísané ako populácia s historicky menším počtom liečebných možností a rýchlejším zhoršovaním.</p>

<p>FIND-CKD zahrnula:</p>

<ul>
  <li><strong>903 pacientov</strong> s diagnózou glomerulárnej choroby podľa vyšetrujúceho lekára (čo je <strong>57 %</strong> populácie),</li>
  <li>v štruktúre boli uvedené napr. <strong>IgA nefropatia</strong>, <strong>FSGS</strong>, <strong>membranózna nefropatia</strong> a aj iné menej časté glomerulárne diagnózy.</li>
</ul>

<p>Približne <strong>80 %</strong> prípadov malo diagnózu potvrdenú biopsiou; zdroj pritom naznačuje, že biopsické postupy sa medzi krajinami líšili.</p>

<h3>4.1. Renálny sklon, albuminúria a exploračné kompozity</h3>

<p>Podľa zdroja bola v placebovom ramene ročná strata GFR približne <strong>4,2 ml/min za rok</strong>, zatiaľ čo v ramene finerenónu približne <strong>3,5 ml/min za rok</strong>, čím vzniká absolútny rozdiel <strong>0,7 ml/min za rok</strong>. To je konzistentné s celkovou populáciou FIND-CKD.</p>

<p>Zdroj ďalej uvádza:</p>

<ul>
  <li>lepší <strong>chronický sklon</strong> (bez akútneho poklesu) o približne <strong>1,2 ml/min za rok</strong>,</li>
  <li>pokles albuminúrie oproti východiskovej hodnote v priebehu <strong>12 mesiacov</strong> o približne <strong>42 %</strong>,</li>
  <li>v exploračnom kompozite (zahŕňajúcom napr. zlyhanie obličiek alebo 40 % pokles GFR) relatívne zníženie rizika približne <strong>26 %</strong>.</li>
</ul>

<h3>4.2. Konzistentnosť v podtypoch a nezávislosť od SGLT2</h3>

<p>Prínos bol podľa zdroja konzistentný vo všetkých podtypoch glomerulárnych chorôb (IgA nefropatia, FSGS, membranózna nefropatia) a že výsledky sa nelíšili podľa toho, či pacienti užívali inhibítory SGLT2.</p>

<p>nsMRA sa v tejto interpretácii nechápe ako „liečba len pre jeden typ“, ale ako pomerne univerzálny príspevok k spomaleniu progresie v skupinách, kde je podstatná albuminúria a následné (<em>downstream</em>) zápalové poškodenie.</p>

<h2>5. INFINITY: celé spektrum CKD a klinicky relevantné výsledky</h2>

<p>Program <strong>INFINITY</strong> je <strong>metaanalýzou na úrovni individuálnych účastníkov</strong> (<em>individual participant data</em>) štúdie FIND-CKD a predchádzajúcich diabetických štúdií (FIGARO-DKD a FIDELIO-DKD).</p>

<p>Cieľom je zistiť účinky finerenónu v závislosti od:</p>

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

<p>Účinok bol podľa zdroja konzistentný bez ohľadu na príčinu ochorenia obličiek, prítomnosť diabetu, úroveň GFR, albuminúriu aj užívanie SGLT2.</p>

<p>Táto interpretácia podporuje koncept, podľa ktorého môže byť finerenón „základným“ pilierom liečby, podobne ako dnes u mnohých pacientov SGLT2 inhibítory.</p>

<h2>6. Kto má najväčší absolútny benefit</h2>

<p>Zdroj sa priamo pýta, kto z liečby získa najviac v absolútnych číslach.</p>

<p>Niektorí pacienti majú vyššie východiskové riziko a výraznejšie konkurenčné riziko KV udalostí. Diabetes je silným zdrojom KV rizika, a preto je absolútny prínos pri KV a mortalitných ukazovateľoch (v tejto interpretácii) väčší u diabetikov. Pri nediabetickej CKD prínos pretrváva, v absolútnych číslach však môže byť menší, a napriek tomu klinicky relevantný.</p>

<p>Pri glomerulárnych chorobách zdroj uvádza, že podskupinová analýza naznačila zvlášť výrazný signál pri <strong>FSGS</strong>, a ponúka biologické vysvetlenie: mineralokortikoidový receptor je exprimovaný na <strong>podocytoch</strong> a prehnaná aktivácia tohto receptora môže podporovať ich poškodenie.</p>

<p>Mechanizmus a klinické pozorovanie sa tu zhodujú. Podskupinové analýzy však treba interpretovať opatrne a v hraniciach toho, čo štúdie skutočne dokazujú.</p>

<h2>7. Steroidné verzus nesteroidné antagonisty mineralokortikoidového receptora: prečo je finerenón vpredu</h2>

<p>Zdroj otvára aj otázku, ktorá sa ponúka sama: čím sa finerenón líši od <strong>spironolaktónu</strong>.</p>

<p>Ako hlavný argument sa uvádza, že veľká štúdia so steroidným MRA pri CKD, <strong>BARACK-D</strong>, mala výrazne vyššiu mieru ukončenia liečby pre bezpečnostné problémy. Podľa zdroja až dve tretiny pacientov v ramene spironolaktónu ukončili liečbu pre protokolom riadené bezpečnostné obmedzenia.</p>

<p>Dôkazy pre spironolaktón a eplerenón pri CKD sú podľa zdroja obmedzené na menšie štúdie s nekonzistentnými výsledkami a len skromnými účinkami na albuminúriu.</p>

<p>Zdroj z toho vyvodzuje, že dôkazy sú v súčasnosti silnejšie pre nsMRA, a preto je v diskusii v centre pozornosti finerenón.</p>

<h2>8. Terapia „upstream“: inhibítory aldosterónsyntázy a prebiehajúce fázy výskumu</h2>

<p>Podľa zdroja prežíva nefrológia obdobie nezvyčajne bohaté na nové údaje: popri finerenóne pribúdajú dáta o liekoch, ktoré ovplyvňujú aldosterónovú os iným mechanizmom. Namiesto blokovania receptora ide o zásah do tvorby aldosterónu.</p>

<p>Mechanisticky má inhibícia aldosterónsyntázy znížiť systémový aj podocytový zápal a albuminúriu, a tým aj tubulárne a glomerulárne poškodenie a progresiu do terminálneho štádia CKD; zároveň môže znížiť krvný tlak.</p>

<p>Zdroj spomína tri prebiehajúce programy, ktorých výsledky sa očakávajú v najbližších rokoch:</p>

<ul>
  <li><strong>FigHTN</strong> s baxdrostatom pri CKD s nekontrolovanou hypertenziou (pričom sa zdôrazňuje, že tieto lieky môžu znižovať krvný tlak),</li>
  <li><strong>BaxDuo-ARCTIC</strong> a <strong>BaxDuo-PACIFIC</strong> ako fáza 3 kombinujúca baxdrostat s dapagliflozínom,</li>
  <li><strong>EASi-KIDNEY</strong>: vicadrostat plus štandardná starostlivosť, konkrétne vicadrostat a empagliflozín.</li>
</ul>

<p>Do budúcna bude podľa zdroja potrebné vyberať správne fenotypy a liečbu indikovať pacientom s najväčším očakávaným prínosom.</p>

<h2>9. Endotelínové receptory a „vypnutie“ zápalových kaskád</h2>

<p>Ďalšou triedou liekov v diskusii sú <strong>antagonisty endotelínových receptorov</strong>.</p>

<p>Endotelínové receptory majú dva podtypy – <strong>ETA</strong> a <strong>ETB</strong>. Podľa zdroja blokáda ETA vedie k zníženiu albuminúrie a zápalu, zatiaľ čo ETB môže zvyšovať retenciu tekutín.</p>

<p>V klinickom vývoji sa spomína <strong>zibotentan</strong> (fáza 3) a kombinácia zibotentanu s dapagliflozínom. Podľa zdroja by výsledky mali prísť v roku 2027.</p>

<p>Protizápalový účinok sa vysvetľuje blokádou následnej signalizácie spojenej s NF-κB a poklesom zápalových cytokínov. V kombinovanej liečbe by šlo o ďalší nástroj popri finerenóne, SGLT2 inhibítoroch a inhibícii RAAS.</p>

<h2>10. Atrasentan: ďalší príspevok do algoritmov pri IgA nefropatii</h2>

<p>Zdroj spomína aj liek <strong>atrasentan</strong>, pre ktorý sa očakávajú výsledky v populácii <strong>IgA nefropatie</strong>.</p>

<p>Podľa prezentácie nejde o liek „výlučne pre IgA“, ale skôr o liek pri CKD, ktorý má význam aj pre pacientov s IgA nefropatiou. Zníženie albuminúrie sa v tejto logike spája so znížením zápalu, podocytového a tubulárneho poškodenia a s nižším rizikom progresie do terminálneho štádia CKD.</p>

<h2>11. Kam smeruje štandard: kombinovaná, etiológiu zohľadňujúca a rizikovo orientovaná terapia</h2>

<p>V závere zdroj opisuje celkový trend: posun ku <strong>kombinovanej terapii</strong> ako novému štandardu.</p>

<p>Progresia CKD je multifaktoriálna a vyžaduje zásah do viacerých mechanizmov. Pri diabetickej CKD sa v diskusii explicitne uvádza, že existujú štyri overené terapie znižujúce riziko zlyhania obličiek aj KV riziko: <strong>inhibícia RAAS, inhibítory SGLT2, nesteroidné MRA a agonisty GLP-1 receptora</strong>.</p>

<p>Pri nediabetickej CKD sú v texte ako piliere uvedené inhibícia RAAS, SGLT2 inhibícia a teraz aj nsMRA. Do budúcna sa očakávajú ďalšie možnosti.</p>

<p>Pri nediabetickej CKD treba podľa zdroja riešiť aj <strong>príčinu</strong> (terapia špecifická pre etiológiu), nielen následky; pri niektorých imunologických ochoreniach obličiek, najmä pri IgA nefropatii, sa liečba k takýmto terapiám už posúva.</p>

<p>Pacienti s najvyšším rizikom budú mať najväčší absolútny prínos, preto treba lepšie identifikovať vysokorizikových jedincov a liečiť ich včasnejšie a intenzívnejšie.</p>

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

<p>Podľa zdroja sa pri nediabetickej CKD mení paradigma: hemodynamické mechanizmy sú dôležité, ale nevysvetľujú všetko. Aldosterónová os a nehemodynamické mechanizmy zápalu a fibrózy vytvárajú racionálny cieľ pre terapiu nsMRA. Dôkazy z FIND-CKD podporujú finerenón ako liek, ktorý spomaľuje pokles GFR a zlepšuje aj klinicky významné renálne a KV výsledky vrátane veľkej glomerulárnej podskupiny. Program INFINITY podporuje konzistentnosť účinku v celom spektre CKD.</p>

<p>Súčasne prebiehajú ďalšie výskumné línie, ktoré idú „vyššie v kaskáde“ (inhibítory aldosterónsyntázy) alebo zasahujú do endotelínovej signalizácie. V najbližších rokoch možno očakávať posun ku kombinovanej a fenotypovo aj etiologicky riadenej liečbe tak, aby sa pacientom s najvyšším reziduálnym rizikom podarilo predĺžiť čas do renálnej „cieľovej udalosti“ a znížiť KV úmrtnosť.</p>

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
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
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
