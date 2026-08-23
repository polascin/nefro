<?php
/**
 * add_osmolalita-mocu-nalacno-riziko-progresie-dm2_article.php
 * Idempotentný UPSERT skript pre vecne a jazykovo korigovaný článok
 * o osmolalite moču nalačno a progresii ochorenia obličiek pri diabete 2. typu.
 * Pôvodní autori zdrojovej štúdie sú evidovaní aj v source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Osmolalita moču nalačno a riziko progresie ochorenia obličiek u pacientov s diabetom 2. typu',
    'slug'         => 'osmolalita-mocu-nalacno-riziko-progresie-dm2',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-07-13 23:25:00',
    'is_top'       => 0,
    'excerpt'      => 'V dvoch prospektívnych kohortách pacientov s diabetom 2. typu bola nižšia osmolalita moču nalačno spojená s nepriaznivejšími obličkovými výsledkami po multivariačnej úprave. Výsledky však neurčujú klinický prah ani neopodstatňujú liečbu riadenú týmto ukazovateľom.',
    'content'      => <<<'HTML'
<p>Odhadovaná glomerulová filtrácia (eGFR) a pomer albumínu a kreatinínu v moči (UACR) zostávajú základom hodnotenia rizika ochorenia obličiek pri diabete 2. typu. Každý z týchto ukazovateľov však zachytáva inú časť obličkovej fyziológie. eGFR odhaduje celkovú filtračnú funkciu a UACR kvantifikuje vylučovanie albumínu; ani jeden priamo netestuje schopnosť obličiek koncentrovať moč.</p>

<p>Práve na túto funkciu sa zamerala prospektívna observačná štúdia publikovaná v časopise <em>Nephrology Dialysis Transplantation</em>. Autori skúmali, či je nižšia osmolalita moču nalačno spojená s progresiou ochorenia obličiek u pacientov s diabetom 2. typu aj nad rámec informácie poskytovanej tradičnými rizikovými ukazovateľmi. Výsledky sú klinicky zaujímavé, ale vyžadujú presnú interpretáciu: ide o asociáciu s prognózou, nie o dôkaz príčiny, validovaný skríningový prah alebo návod na zmenu liečby.</p>

<h2>Čo vyjadruje osmolalita moču</h2>

<p>Osmolalita udáva počet osmoticky aktívnych častíc na kilogram vody a vyjadruje sa v mOsm/kg H₂O. Nie je totožná s osmolaritou, ktorá sa vzťahuje na objem roztoku, ani so špecifickou hmotnosťou moču. Špecifická hmotnosť závisí aj od hmotnosti prítomných molekúl; výraznejšie ju preto môžu meniť napríklad glukóza, bielkoviny alebo kontrastné látky. Refraktometrické meranie špecifickej hmotnosti nemožno bez osobitnej validácie považovať za náhradu osmolality skúmanej v tejto práci.</p>

<p>Koncentrácia moču vzniká súhrou viacerých mechanizmov: protiprúdového systému Henleho slučky, dreňového osmotického gradientu, primeranej funkcie tubulov a interstícia, účinku vazopresínu a priepustnosti zberných kanálikov pre vodu. Hodnotu v jednorazovej vzorke však ovplyvňujú aj príjem tekutín a osmoticky aktívnych látok, množstvo vylučovanej močoviny, glykémia a glykozúria, diuretiká, celková funkcia obličiek i podmienky odberu.</p>

<p>Osmolalita vzorky moču nalačno je preto praktickým približným ukazovateľom koncentračnej schopnosti, nie jej čistým alebo maximálnym meraním. Nízka hodnota môže súvisieť s tubulointersticiálnou dysfunkciou a úbytkom funkčných nefrónov, nie je však anatomicky špecifická. Samotné meranie nedokáže určiť, či porucha vzniká v distálnom nefróne, dreňovom interstíciu, v regulácii vazopresínom alebo v dôsledku odlišného osmotického zaťaženia.</p>

<h2>Dve prospektívne kohorty</h2>

<p>Analýza zahŕňala dve geograficky a populačne odlišné kohorty pacientov s diabetom 2. typu. V singapurskej kohorte SMART2D bolo 1 711 účastníkov, ktorých autori sledovali priemerne 6,6 ± 1,6 roka. Francúzska kohorta SURDIAGENE zahŕňala 1 097 účastníkov s priemerným sledovaním 7,4 ± 3,7 roka. Spolu teda išlo o 2 808 ľudí a dlhodobé pozorovanie v dvoch odlišných zdravotníckych a populačných prostrediach.</p>

<p>Osmolalita moču nalačno sa stanovila na začiatku sledovania. Primárnym výsledkom bol kompozit zlyhania obličiek v konečnom štádiu (ESKD, podľa terminológie zdroja) alebo zdvojnásobenia koncentrácie sérového kreatinínu. Sekundárnym výsledkom bol rýchly pokles funkcie obličiek (RKFD), definovaný ako ročný pokles eGFR najmenej o 5 ml/min/1,73 m².</p>

<p>Kompozitný výsledok spájal dve klinicky závažné udalosti, ale súhrnný počet neukazuje, aký podiel tvorila každá z jeho zložiek. RKFD bol odlišný, kategoricky hodnotený ukazovateľ založený na rýchlosti poklesu eGFR. Primárny a sekundárny výsledok preto opisujú príbuzné, nie však totožné stránky progresie ochorenia obličiek.</p>

<p>Počas sledovania sa zaznamenalo 239 primárnych obličkových udalostí v SMART2D a 82 v SURDIAGENE. Autori porovnali účastníkov v najnižšom a najvyššom tercile osmolality. Tercily boli relatívne kategórie odvodené z rozdelenia hodnôt v jednotlivých kohortách; nejde o univerzálne klinické prahy.</p>

<div style="page-break-inside: avoid;">
<h2>Výsledky: rovnaký smer, nie úplná replikácia</h2>

<table>
  <thead>
    <tr>
      <th scope="col">Výsledok: najnižší verzus najvyšší tercil</th>
      <th scope="col">SMART2D</th>
      <th scope="col">SURDIAGENE</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Primárny kompozitný obličkový výsledok</td>
      <td>aHR 2,94<br>95 % IS 1,12–7,69</td>
      <td>aHR 1,74<br>95 % IS 0,85–3,58</td>
    </tr>
    <tr>
      <td>Rýchly pokles funkcie obličiek</td>
      <td>aOR 1,47<br>95 % IS 0,95–2,28</td>
      <td>aOR 1,84<br>95 % IS 1,06–3,19</td>
    </tr>
  </tbody>
</table>
</div>

<p>V SMART2D mali účastníci v najnižšom tercile osmolality po multivariačnej úprave takmer trojnásobný pomer rizík primárneho kompozitného výsledku oproti najvyššiemu tercilu. Interval spoľahlivosti nezahŕňal hodnotu 1, takže výsledok bol štatisticky významný. V SURDIAGENE bol bodový odhad takisto nepriaznivý, interval 0,85–3,58 však zahŕňal 1 a výsledok nebol štatisticky významný.</p>

<p>Pri rýchlom poklese eGFR sa situácia obrátila. V SMART2D smeroval odhad k vyššej pravdepodobnosti RKFD, ale 95 % interval spoľahlivosti zahŕňal 1. Štatisticky významná asociácia sa zistila v SURDIAGENE, kde bol adjustovaný pomer šancí 1,84.</p>

<p>Adjustovaný pomer rizík (aHR) vyjadruje relatívny rozdiel v okamžitom riziku udalosti počas sledovania, zatiaľ čo adjustovaný pomer šancí (aOR) porovnáva šance na výskyt kategoricky definovaného RKFD. Číselnú veľkosť aHR a aOR preto nemožno priamo porovnávať ani z ich rozdielu odvodzovať, ktorý výsledok bol „silnejší“.</p>

<p>Najpresnejšie zhrnutie teda znie: nižšia osmolalita bola v oboch kohortách spojená s nepriaznivým smerom odhadov, ale štatistická významnosť toho istého výsledku sa v oboch súboroch nezopakovala. Asociácia s primárnym kompozitným výsledkom bola štatisticky významná iba v SMART2D a asociácia s RKFD iba v SURDIAGENE. To možno označiť za čiastočnú replikáciu smeru asociácie, nie za úplné nezávislé potvrdenie každého výsledku. Široké intervaly spoľahlivosti zároveň ukazujú, že veľkosť asociácie je odhadnutá s nezanedbateľnou neistotou.</p>

<h2>Informácia nad rámec eGFR a albuminúrie</h2>

<p>Publikovaný abstrakt uvádza, že autori výsledky upravili o známe klinické rizikové faktory a nižšiu osmolalitu interpretovali ako ukazovateľ spojený s progresiou nezávisle od konvenčných rizikových faktorov. Pojem „nezávislá asociácia“ tu však znamená nezávislosť v rámci použitého štatistického modelu. Neodstraňuje reziduálne skreslenie a automaticky neznamená, že pridanie ukazovateľa zlepší správnosť predikcie u konkrétneho pacienta.</p>

<p>Na preukázanie klinického prínosu prognostického ukazovateľa nestačí pomer rizík odlišný od 1. Potrebné je posúdiť, či ukazovateľ zlepšuje rozlíšenie pacientov s budúcou udalosťou a bez nej, či sú predpovedané riziká správne kalibrované a či reklasifikácia vedie k užitočnému klinickému rozhodnutiu. Predložené výsledky samy osebe takýto rozhodovací prínos neustanovujú.</p>

<p>Exploratívne analýzy navyše naznačili, že vzťah nízkej osmolality k primárnemu obličkovému výsledku pretrvával aj po zohľadnení plazmatického kopeptínu, zástupného ukazovateľa vazopresínu, alebo močovej koncentrácie KIM-1, biomarkera poškodenia proximálneho tubulu. Tento nález je zaujímavý, no nepreukazuje, že osmolalita špecificky meria poškodenie distálneho nefrónu. Na takéto anatomické alebo mechanistické tvrdenie by boli potrebné cielenejšie funkčné, zobrazovacie alebo histologické údaje.</p>

<p>Rovnako nemožno tvrdiť, že pokles osmolality nevyhnutne predchádza albuminúrii alebo poklesu eGFR. Štúdia hodnotila osmolalitu na začiatku a následné klinické výsledky, neporovnávala však časový vznik jednotlivých patologických procesov. Nižšia hodnota môže byť skorým signálom, sprievodným prejavom už prítomného ochorenia alebo kombináciou oboch.</p>

<div style="page-break-inside: avoid;">
<h2>Prečo výsledok nemusí znamenať iba tubulárne poškodenie</h2>

<p>Pri úbytku funkčných nefrónov musia zostávajúce nefróny vylúčiť väčší podiel denného osmotického nákladu. To môže obmedziť dosiahnuteľnú koncentráciu moču aj bez izolovanej poruchy jedného tubulárneho segmentu. Pri diabete sa pridáva premenlivá glykozúria, ktorá mení počet častíc v moči a vyvoláva osmotickú diurézu. Osmolalita je preto výsledkom interakcie štruktúry obličky, hormonálnej regulácie, glomerulovej filtrácie, zloženia stravy, metabolického stavu a liečby.</p>
</div>

<p style="page-break-inside: avoid;">Tento širší fyziologický rámec vysvetľuje, prečo môže byť osmolalita prognosticky informatívna, ale zároveň málo špecifická. Asociovaný ukazovateľ nemusí byť príčinou progresie a jeho farmakologické alebo behaviorálne zvýšenie nemusí zlepšiť prognózu. Zo štúdie preto nemožno odvodiť odporúčanie obmedziť príjem tekutín, meniť osmotický príjem alebo cielene zvyšovať koncentráciu moču.</p>

<h2>Inhibítory SGLT2 menia interpretačný kontext</h2>

<p>Pri dnešnej liečbe diabetu a chronickej choroby obličiek treba osobitne zohľadniť inhibítory sodíkovo-glukózového kotransportéra 2 (SGLT2). Navodená glykozúria zvyšuje vylučovanie osmoticky aktívnych častíc a mení objem moču; jej čistý vplyv na nameranú osmolalitu závisí od klinického kontextu. Rovnaká hodnota preto nemusí mať identický fyziologický význam u pacienta liečeného inhibítorom SGLT2 a u pacienta bez tejto liečby.</p>

<p>To nespochybňuje preukázaný obličkový a kardiovaskulárny prínos inhibítorov SGLT2. Znamená to iba, že prognostickú výpovednú hodnotu osmolality treba osobitne validovať v súčasných, intenzívne liečených populáciách. Osmolalita nesmie byť dôvodom na vysadenie účinnej liečby ani samostatným kritériom na jej začatie.</p>

<h2>Čo možno preniesť do praxe už dnes</h2>

<ul>
  <li><strong>Možno povedať:</strong> osmolalita moču nalačno je fyziologicky zmysluplný a potenciálne dostupný doplnkový prognostický ukazovateľ.</li>
  <li><strong>Možno povedať:</strong> nízke hodnoty boli spojené s nepriaznivejšími obličkovými výsledkami po multivariačnej úprave, pričom smer odhadov bol rovnaký v dvoch odlišných kohortách.</li>
  <li><strong>Nemožno povedať:</strong> že konkrétna hodnota, napríklad 350 alebo 400 mOsm/kg H₂O, definuje vysoké riziko. Univerzálny klinický prah nebol validovaný.</li>
  <li><strong>Nemožno povedať:</strong> že špecifická hmotnosť moču meraná refraktometrom poskytuje rovnocennú prognostickú informáciu.</li>
  <li><strong>Nemožno povedať:</strong> že osmolalita nahrádza eGFR alebo UACR, dokazuje diabetickú etiológiu ochorenia obličiek alebo lokalizuje léziu do distálneho nefrónu.</li>
  <li><strong>Nemožno povedať:</strong> že výsledok určuje intenzitu liečby inhibítorom SGLT2, blokátorom systému renín–angiotenzín alebo antagonistom mineralokortikoidového receptora.</li>
</ul>

<p>V klinickej praxi preto zostávajú eGFR a UACR základnými ukazovateľmi klasifikácie a sledovania. Osmolalita môže byť predmetom doplnkového hodnotenia alebo ďalšieho výskumu, ale zatiaľ nemá štúdiou potvrdený rozhodovací prah, interval opakovaného merania ani algoritmus, ktorý by menil liečbu. Izolovaná nízka hodnota nemá automaticky viesť k označeniu pacienta za rýchlo progredujúceho ani k zmene liečby.</p>

<p>Ak sa má ukazovateľ v budúcnosti používať na stratifikáciu rizika, bude potrebný štandardizovaný odber a poznanie jeho biologickej variability. Výskum by mal určiť význam podmienok odberu, príjmu tekutín a osmoticky aktívnych látok, súbežnej glykozúrie a opakovaných meraní. Bez takéhoto protokolu môže rozdiel medzi dvoma vzorkami odrážať zmenu podmienok odberu namiesto zmeny ochorenia.</p>

<h2>Silné stránky a limity</h2>

<p>Medzi silné stránky patria prospektívne sledovanie, spolu 2 808 účastníkov, 321 primárnych obličkových udalostí a hodnotenie v dvoch populačne odlišných kohortách. Dlhé priemerné sledovanie a multivariačná úprava podporujú prognostickú relevantnosť nálezu. Druhá kohorta zároveň umožnila posúdiť, či sa smer vzťahu objaví aj v inom prostredí.</p>

<ul>
  <li style="page-break-inside: avoid;"><strong>Observačný dizajn:</strong> štúdia preukazuje asociáciu, nie kauzalitu. Nemožno vylúčiť reziduálne a nemerané skresľujúce faktory ani obrátenú kauzalitu.</li>
  <li style="page-break-inside: avoid;"><strong>Jedno východiskové meranie:</strong> výsledok môže ovplyvniť hydratácia, strava, glykozúria, lieky a bežná vnútroindividuálna variabilita. Nie je známe, akú prognostickú hodnotu má priemer opakovaných meraní.</li>
  <li style="page-break-inside: avoid;"><strong>Čiastočná replikácia:</strong> rovnaký smer odhadov je povzbudivý, ale každý z dvoch výsledkov bol štatisticky významný iba v jednej kohorte.</li>
  <li style="page-break-inside: avoid;"><strong>Relatívne kategórie:</strong> tercily rozdeľujú konkrétnu kohortu a nevytvárajú všeobecne použiteľnú hranicu pre jednotlivého pacienta.</li>
  <li style="page-break-inside: avoid;"><strong>Nešpecifickosť:</strong> osmolalita nedokáže sama odlíšiť tubulointersticiálne poškodenie od vplyvu zníženej filtrácie, vazopresínu, osmotického príjmu, glykozúrie alebo liečby.</li>
  <li style="page-break-inside: avoid;"><strong>Súčasná terapia:</strong> vzťah treba znova overiť v populáciách liečených dnešnou kombinovanou kardiorenálnou liečbou, najmä inhibítormi SGLT2.</li>
  <li style="page-break-inside: avoid;"><strong>Klinická využiteľnosť:</strong> uvedené pomery rizík a šancí samy osebe nedokazujú zlepšenie diskriminácie, kalibrácie alebo reklasifikácie rizika a neoverujú liečbu riadenú osmolalitou.</li>
</ul>

<p>Do štúdie boli zaradení pacienti s diabetom 2. typu; tento údaj sám osebe nepotvrdzuje, že každé ochorenie obličiek malo diabetickú etiológiu. Aj preto je presnejšie hovoriť o riziku progresie ochorenia obličiek pri diabete 2. typu než označiť osmolalitu za špecifický marker diabetickej choroby obličiek.</p>

<h2>Záver</h2>

<p>Nižšia osmolalita moču nalačno bola v kohortách SMART2D a SURDIAGENE spojená s nepriaznivejším smerom obličkových výsledkov po multivariačnej úprave. Štatistická významnosť jednotlivých výsledkov sa však medzi kohortami reprodukovala iba čiastočne. Práca preto podporuje ďalšie skúmanie osmolality ako doplnkového prognostického ukazovateľa, nie jej okamžité zavedenie ako samostatného skríningového alebo rozhodovacieho testu.</p>

<p style="page-break-inside: avoid;">Pred klinickým využitím treba určiť reprodukovateľnosť merania, pridanú hodnotu oproti eGFR a UACR, použiteľný prah a interpretáciu pri glykozúrii a liečbe inhibítormi SGLT2. Dovtedy má najväčšiu hodnotu presný, úzky záver: nízka osmolalita je prognostický signál hodný pozornosti, nie diagnóza, dôkaz mechanizmu ani indikácia konkrétnej liečby.</p>

<hr>

<p><em><strong>Zdroj – originálna štúdia:</strong> Liu JJ, Liu S, de Keizer J, Zheng H, Lee J, Javaugue V, Gurung RL, Ang K, Potier L, Nelson RG, Kestenbaum B, Bjornstad P, Lim SC, Hadjadj S, Saulnier PJ; SMART2D and SURDIAGENE Study Groups. Fasting urine osmolality and risk of kidney disease progression in patients with type 2 diabetes. <em>Nephrology Dialysis Transplantation</em>. 2026;41(7):1304–1312. Publikované online 12. decembra 2025. doi: <a href="https://doi.org/10.1093/ndt/gfaf264" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfaf264</a>. PMID 41384790. <a href="https://academic.oup.com/ndt/article/41/7/1304/8378095" target="_blank" rel="noopener noreferrer">Oxford Academic – originálny zdroj</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41384790/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://europepmc.org/article/MED/41384790" target="_blank" rel="noopener noreferrer">Europe PMC</a>; <a href="https://hal.science/hal-05554293v1" target="_blank" rel="noopener noreferrer">HAL</a>; <a href="https://openalex.org/W4417277070" target="_blank" rel="noopener noreferrer">OpenAlex</a>; <a href="https://academic.oup.com/ndt/article-pdf/41/7/1304/65854844/gfaf264.pdf" target="_blank" rel="noopener noreferrer">PDF na Oxford Academic</a> (prístup môže vyžadovať predplatné).</em></p>

<p style="page-break-inside: avoid;"><em><strong>Všetci autori a kolektívny autor zdrojovej štúdie:</strong> Jian-Jun Liu; Sylvia Liu; Joe de Keizer; Huili Zheng; Janus Lee; Vincent Javaugue; Resham L. Gurung; Keven Ang; Louis Potier; Robert G. Nelson; Bryan Kestenbaum; Petter Bjornstad; Su Chi Lim; Samy Hadjadj; Pierre-Jean Saulnier; SMART2D and SURDIAGENE Study Groups.</em></p>

<p style="page-break-inside: avoid;"><em><strong>Bibliografická poznámka:</strong> PubMed uvádza 15 menovaných autorov a kolektívneho autora SMART2D and SURDIAGENE Study Groups. Zoznam členov vyšetrovateľských skupín vedený v PubMed ako <em>InvestigatorList</em> nie je ďalšou autorskou byline. Článok je na stránke vydavateľa distribuovaný v štandardnom publikačnom modeli Oxford University Press, nie pod otvorenou licenciou.</em></p>

<p style="page-break-inside: avoid;"><em><strong>Financovanie evidované v PubMed:</strong> granty STAR 23201, 24102 a 25203; granty Singapore National Medical Research Council 001327-02, 001704-00 a 001688-00; grant French Ministry of Health PHRC-IR 2008 a podpora označená skratkou SFD. Otvorené bibliografické záznamy neuvádzajú úplné znenie vyhlásenia o konfliktoch záujmov ani úlohu financovateľov; tieto údaje preto bez plného textu neinterpretujeme.</em></p>
HTML,
];

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
?>
