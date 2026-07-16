<?php

/**
 * add_obezita-a-oblicky_article.php
 * Popularizačný článok (sekcia „Pre pacientov“) — spracované z DOCX
 * „Obezita a obličky s AI ilustráciami“ vrátane 10 AI ilustrácií
 * (img/obob-01..obob-10). Obrázky sú klikateľné (nová karta). PDF verzia je
 * ručne pripravený kurátorovaný súbor (pdf/obezita-a-oblicky.pdf) — slug je
 * v PROTECTED_PDF_SLUGS, takže sa automaticky neprepisuje.
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_obezita-a-oblicky_article.php"
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať popularizačný článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'Obezita a obličky',
    'slug'         => 'obezita-a-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 1,
    'pdf_file'     => 'obezita-a-oblicky.pdf',
    'excerpt'      => 'Keď sa stretne cukrovka a obezita, trpia aj obličky. Zrozumiteľne o tom, prečo obezita zvyšuje tlak na obličky, ako môže chudnutie odľahčiť ich filtračný aparát a aké sú dnešné možnosti liečby obezity.',
    'content'      => <<<'NEFRO_HTML'
<figure class="article-figure">
  <a href="img/obob-01.png" target="_blank" rel="noopener noreferrer">
    <img src="img/obob-01.png" alt="Ilustrácia: redukcia hmotnosti a zlepšenie obličiek pri cukrovke a obezite" loading="lazy" decoding="async">
  </a>
  <figcaption>Keď sa stretne cukrovka a obezita, je to jeden spoločný príbeh — a obličky sú jeho tichými svedkami.</figcaption>
</figure>

<p class="article-dek"><em>Ako redukcia hmotnosti u diabetika odľahčí filtračný aparát obličiek a aké sú súčasné medicínske možnosti manažmentu obezity.</em></p>

<p>Keď má človek diabetes a zároveň aj obezitu, nejde len o „dva problémy vedľa seba“. Ide o jeden spoločný príbeh, v ktorom sa stretávajú metabolická nerovnováha, zmeny v cievach, zápalové procesy a často aj zhoršená schopnosť dlhodobo udržiavať stabilnú hladinu cukru v krvi. Obezita v takomto prostredí zvyšuje nároky na organizmus a postupne sa môže premietnuť aj do toho, ako fungujú obličky.</p>

<p>Obličky sú pri diabetikovi „tichými svedkami“ dlhodobého stresu. Nemusia bolieť, neukážu sa hneď v plnom rozsahu a človek môže roky fungovať tak, že sa nič dramatické „nevníma“. Napriek tomu sa v pozadí môžu diať zmeny, ktoré sa neskôr prejavia albumínom v moči, postupným zhoršovaním funkcie obličiek a zvýšeným kardiovaskulárnym rizikom. Preto medzinárodné odporúčania zdôrazňujú, že pri diabete a chronickom ochorení obličiek ide o komplexný manažment rizík vrátane tlaku, albuminúrie a celkového kardiometabolického zdravia, nie iba o glykémiu [1,2].</p>

<figure class="article-figure">
  <a href="img/obob-02.png" target="_blank" rel="noopener noreferrer">
    <img src="img/obob-02.png" alt="Ilustrácia: nadváha a obezita zvyšujú nároky na celý organizmus" loading="lazy" decoding="async">
  </a>
  <figcaption>Obezita zvyšuje nároky na celý organizmus vrátane obličiek.</figcaption>
</figure>

<h2>Prečo obezita zvyšuje tlak na obličky</h2>

<p>V praxi je užitočné predstaviť si obličku ako filtračný systém, ktorý potrebuje stabilné podmienky. Pri obezite sa často mení viac vecí naraz. Tukové tkanivo nie je len „sklad energie“. Je aktívne a vytvára látky a signály, ktoré podporujú chronický zápal, zhoršujú inzulínovú citlivosť a súvisia aj s poruchami metabolizmu tukov. To isté sa týka aj faktorov, ktoré zvyšujú riziko poškodenia ciev a tým aj cievnych štruktúr v obličkách.</p>

<p>K tomu sa pridáva častý sprievodný problém: vysoký krvný tlak. Aj keď sa o krvnom tlaku hovorí často, pri obličkách platí, že ide o jedného z najdôležitejších „spúšťačov“ dlhodobého poškodenia filtračného aparátu. Ak je tlak dlhodobo vyšší, oblička sa musí prispôsobiť. Ak je adaptácia dlhodobá a nevhodná, zvyšuje sa riziko, že sa poškodenie časom zafixuje. Medzinárodné dokumenty pre manažment diabetu pri chronickom ochorení obličiek preto opakovane zdôrazňujú, že treba pracovať aj s tlakom, albuminúriou a celkovým kardiometabolickým rizikom, nie iba s jedným „číslom“ [1,2].</p>

<p>Obezita navyše často zhoršuje kvalitu kompenzácie diabetu. Človek môže byť na liečbe, ale inzulínová rezistencia zostáva vysoká, hladiny cukru sa môžu opakovane „tlačiť“ hore a potom opäť klesať a tento kolotoč metabolického stresu postupne zasahuje orgány. Keď sa tento proces kombinuje s už spomenutými tlakmi a zápalom, obraz sa zhoršuje aj pre obličky. A preto dáva zmysel, že redukcia hmotnosti sa v modernej medicíne nepovažuje za kozmetický cieľ, ale môže byť súčasťou ochrany orgánov [1,2].</p>

<figure class="article-figure">
  <a href="img/obob-03.png" target="_blank" rel="noopener noreferrer">
    <img src="img/obob-03.png" alt="Ilustrácia: obezita a tlak na obličky" loading="lazy" decoding="async">
  </a>
  <figcaption>Prečo obezita zvyšuje tlak na obličky.</figcaption>
</figure>

<h2>Ako môže redukcia hmotnosti u diabetika odľahčiť filtračný aparát</h2>

<p>Najdôležitejšie je, že chudnutie môže ovplyvniť viac mechanizmov naraz. Nie vždy sa to dá vysvetliť jednou vetou a nie u každého bude mať rovnaký účinok. V praxi sa však často pozoruje, že keď sa dlhodobo zlepší metabolická situácia, spravidla sa zlepší aj prostredie pre obličky.</p>

<p>Pri redukcii hmotnosti často nastane aspoň časť týchto javov: znižuje sa inzulínová rezistencia, lepšie sa regulujú výkyvy glykémie, postupne sa zlepšuje krvný tlak a znižuje sa chronický zápalový signál. Tým sa menia „podmienky v okolí“ obličky. Ak sú tieto podmienky menej stresujúce, obličky nemusia tak intenzívne kompenzovať a riziko progresie poškodenia sa môže znížiť. Práve albuminúria je v tomto kontexte dôležitým signálom. Ak sa albumín v moči znižuje, často to znamená, že sa zlepšujú podmienky pre filtračný aparát [1,2].</p>

<p>Bezpečný a koordinovaný prístup k redukcii hmotnosti je kľúčový na to, aby sa pacienti cítili istí, že ich zdravie je v dobrých rukách a že riziká sú minimalizované.</p>

<p>Je reálne chudnúť a pritom neublížiť obličkám? Áno, ale nie je to automatické. Preto je vhodné vyhnúť sa jednoduchým sľubom typu „schudnete a obličky sa hneď opravia“. Také tvrdenie by bolo pre pacientov zavádzajúce. Rozumnejšia formulácia znie: správne vedená a postupná redukcia hmotnosti môže znížiť riziká, odľahčiť organizmus a podporiť priaznivejší priebeh ochorenia vrátane ochorení obličiek.</p>

<p>Podstatné je, že pri diabetikovi s rizikom ochorenia obličiek sa sleduje viacero parametrov. Zvyčajne ide o funkciu obličiek, prítomnosť albumínu v moči, krvný tlak a dlhodobú kontrolu glykémie. Pri sledovaní týchto ukazovateľov je možné prispôsobiť liečbu tak, aby bola bezpečná a aby chudnutie nebolo spojené s nepriaznivými vedľajšími účinkami. Tento prístup je v súlade s medzinárodnými odporúčaniami, ktoré zdôrazňujú individualizáciu a manažment rizík [1,2].</p>

<figure class="article-figure">
  <a href="img/obob-04.png" target="_blank" rel="noopener noreferrer">
    <img src="img/obob-04.png" alt="Ilustrácia: redukcia hmotnosti a zdravé obličky" loading="lazy" decoding="async">
  </a>
  <figcaption>Bezpečné a postupné chudnutie môže odľahčiť filtračný aparát obličiek.</figcaption>
</figure>

<h2>Súčasné medicínske možnosti manažmentu obezity</h2>

<p>Dnes už nikto neberie obezitu len ako „nedostatok vôle“. V medicíne sa obezita chápe ako chronické, relapsujúce ochorenie, ktoré si často vyžaduje dlhodobý plán. Zmyslom liečby je znížiť hmotnosť a najmä udržať dosiahnutý výsledok, aby sa znížilo riziko komplikácií. Na Slovensku štandardné postupy aj odborné dokumenty zdôrazňujú multidisciplinárny prístup, edukáciu a spoluprácu viacerých odborov [5].</p>

<p>V praxi sa liečba zvyčajne skladá z troch rovín. Prvá je režimová: strava je nastavená tak, aby podporovala lepšiu metabolickú kontrolu a primeraný pohyb podľa možností človeka. Druhá je farmakologická, keď samotné režimové opatrenia nestačia alebo ich nie je možné dosiahnuť v požadovanom čase a rozsahu. Tretia rovina je bariatrická alebo metabolická chirurgia u vybraných pacientov, kde môže byť prínos výrazný, ale vždy je potrebné zvážiť indikácie a následné sledovanie [5].</p>

<figure class="article-figure">
  <a href="img/obob-05.png" target="_blank" rel="noopener noreferrer">
    <img src="img/obob-05.png" alt="Ilustrácia: súčasné medicínske možnosti manažmentu obezity" loading="lazy" decoding="async">
  </a>
  <figcaption>Súčasné medicínske možnosti manažmentu obezity.</figcaption>
</figure>

<h2>Farmakoterapia, ktorá mení hru (aj pri diabetikovi)</h2>

<p>Jedným z významných posunov posledných rokov je širšie využívanie liečby, ktorá pôsobí na mechanizmy spojené s reguláciou chuti do jedla a energetického metabolizmu. Príkladom sú lieky na báze semaglutidu, ktoré sa v rôznych odporúčaniach uvádzajú ako možnosť manažmentu nadváhy a obezity u vhodných pacientov spolu so zníženou kalorickou diétou a zvýšenou fyzickou aktivitou [3].</p>

<p>V klinických štúdiách semaglutid viedol k významnej redukcii hmotnosti u dospelých s nadváhou alebo obezitou a výsledky patria medzi dôvody, prečo sa lieková liečba v praxi stala bežnou súčasťou manažmentu obezity v mnohých krajinách [4]. Pre diabetikov je dôležité, aby sa takáto liečba posudzovala v kontexte celej terapie diabetu a obličiek. Nie je to jedno univerzálne riešenie, ale nástroj, ktorý môže zmysluplne doplniť režim, ak je indikovaný a bezpečný pre konkrétneho človeka [1,2,7].</p>

<p>Zároveň platí, že lieky nie sú náhradou za zmeny životného štýlu. Skôr pomáhajú prekonať biologické brzdy, ktoré sa objavia, keď človek začne žiť v kalorickom deficite a telo sa snaží vrátiť do pôvodného stavu. Keď je farmakoterapia správne načasovaná a koordinovaná, zvyšuje sa šanca, že výsledok bude trvalý [3,4,9].</p>

<figure class="article-figure">
  <a href="img/obob-06.png" target="_blank" rel="noopener noreferrer">
    <img src="img/obob-06.png" alt="Ilustrácia: farmakoterapia obezity" loading="lazy" decoding="async">
  </a>
  <figcaption>Farmakoterapia obezity, ktorá mení hru aj pri diabetikovi.</figcaption>
</figure>

<h2>Chirurgia, keď je to medicínsky odôvodnené</h2>

<p>Bariatrická a metabolická chirurgia môže byť veľmi účinná u vybraných pacientov so závažnou obezitou alebo u tých, u ktorých iné možnosti neposkytujú udržateľné výsledky. V odporúčaniach sa zdôrazňuje, že ide o liečbu s prípravou, sledovaním a dlhodobým nutričným manažmentom. Pri diabetikovi môže mať výrazný metabolický dopad, ale rozhodnutie musí byť individuálne, s ohľadom na komorbidity a riziká [5,9].</p>

<figure class="article-figure">
  <a href="img/obob-07.png" target="_blank" rel="noopener noreferrer">
    <img src="img/obob-07.png" alt="Ilustrácia: bariatrická a metabolická chirurgia" loading="lazy" decoding="async">
  </a>
  <figcaption>Bariatrická a metabolická chirurgia — pri správnej indikácii.</figcaption>
</figure>

<h2>Čo by mal pacient riešiť s lekárom pri diabete a obezite (prakticky)</h2>

<p>Ak chcete, aby redukcia hmotnosti chránila aj obličky, je dobré mať v hlave jednoduchú logiku: cieľ nie je „schudnúť“, ale znížiť riziko komplikácií a spomaliť poškodenie orgánov. A k tomu patrí aj pravidelná kontrola.</p>

<p>Pri konzultácii má zmysel pýtať sa na trend albuminúrie a funkcie obličiek, na krvný tlak a na to, ako sa nastaví diabetologická liečba tak, aby sa pri redukcii neznížila bezpečnosť pacienta. Dôležité je aj to, aký typ režimu a pohybového plánu je vhodný, aby sa minimalizovalo riziko zníženia svalovej hmoty a zachovala sa výkonnosť. Ak je indikovaná farmakoterapia obezity, treba zvážiť jej bezpečnosť v kontexte obličiek a diabetu. Tento typ koordinovaného tímového prístupu zodpovedá odporúčaniam manažmentu diabetu a obličiek aj v medzinárodných dokumentoch [1,2].</p>

<figure class="article-figure">
  <a href="img/obob-08.png" target="_blank" rel="noopener noreferrer">
    <img src="img/obob-08.png" alt="Ilustrácia: spolupráca pre zdravé obličky pri diabete a obezite" loading="lazy" decoding="async">
  </a>
  <figcaption>Čo riešiť s lekárom — spolupráca pre zdravé obličky pri diabete a obezite.</figcaption>
</figure>

<h2>Záver</h2>

<p>Obezita zvyšuje riziko poškodenia obličiek u diabetikov najmä prostredníctvom metabolických a tlakových mechanizmov, zápalu a dlhodobého zhoršovania mikrocirkulácie. Redukcia hmotnosti, ak je bezpečná, udržateľná a koordinovaná s liečbou diabetu, môže obličkám reálne odľahčiť a prispieť k priaznivejšiemu priebehu ochorenia.</p>

<p>Súčasná medicína dnes ponúka nielen režimové opatrenia, ale aj farmakologickú liečbu obezity a u vybraných pacientov aj bariatrickú alebo metabolickú chirurgiu. Rozumný cieľ je dosiahnuť zmenu, ktorú viete udržať a ktorá znižuje riziká, nielen dočasne zmeniť číslo.</p>

<figure class="article-figure">
  <a href="img/obob-09.png" target="_blank" rel="noopener noreferrer">
    <img src="img/obob-09.png" alt="Ilustrácia: obezita, diabetes a obličky sú navzájom prepojené" loading="lazy" decoding="async">
  </a>
  <figcaption>Obezita, diabetes a obličky sú navzájom prepojené.</figcaption>
</figure>

<figure class="article-figure">
  <a href="img/obob-10.png" target="_blank" rel="noopener noreferrer">
    <img src="img/obob-10.png" alt="Ilustrácia: multidisciplinárny tímový prístup k liečbe obezity a ochrane obličiek" loading="lazy" decoding="async">
  </a>
  <figcaption>Multidisciplinárny tímový prístup je základom úspešnej liečby.</figcaption>
</figure>

<p><em>Autor je nefrológ a internista s rozsiahlymi skúsenosťami v dialyzačnej liečbe, klinickej a preventívnej nefrológii aj v riadení dialyzačných stredísk.</em></p>

<p><em>Tento článok má informačný a vzdelávací charakter a nenahrádza vyšetrenie, diagnostiku ani liečbu u vášho lekára. O konkrétnych krokoch pri chudnutí, úprave liečby cukrovky a ochrane obličiek sa vždy poraďte so svojím lekárom.</em></p>

<hr>

<h2>Zdroje</h2>
<ol>
  <li>KDIGO. KDIGO 2022 Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease. 2022. <a href="https://kdigo.org/wp-content/uploads/2022/10/KDIGO-2022-Clinical-Practice-Guideline-for-Diabetes-Management-in-CKD.pdf" target="_blank" rel="noopener noreferrer">kdigo.org</a></li>
  <li>de Boer IH, Khunti K, Sadusky T, et al. Diabetes management in chronic kidney disease: a consensus report by the ADA and KDIGO. Diabetes Care. 2022. <a href="https://kdigo.org/wp-content/uploads/2018/03/ADA-KDIGO-Consensus-Report-Diabetes-CKD-Diabetes-Care-2022.pdf" target="_blank" rel="noopener noreferrer">kdigo.org</a></li>
  <li>National Institute for Health and Care Excellence. Semaglutide for managing overweight and obesity. Technology appraisal guidance TA875. London: NICE; 2023. <a href="https://www.nice.org.uk/guidance/ta875" target="_blank" rel="noopener noreferrer">nice.org.uk</a></li>
  <li>Wilding JPH, Batterham RL, Calanna S, et al. Once-weekly semaglutide in adults with overweight or obesity. N Engl J Med. 2021;384(11):989–1002. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2032183" target="_blank" rel="noopener noreferrer">nejm.org</a></li>
  <li>Ministerstvo zdravotníctva Slovenskej republiky. Štandardný diagnostický a terapeutický postup pre komplexný manažment nadváhy/obezity v dospelom veku. 2. revízia. Bratislava: MZ SR; 2023. <a href="https://www.health.gov.sk/" target="_blank" rel="noopener noreferrer">health.gov.sk</a></li>
  <li>Zväz diabetikov Slovenska. DiaSpektrum a informácie ZDS. <a href="https://zds.sk/" target="_blank" rel="noopener noreferrer">zds.sk</a></li>
  <li>National Kidney Foundation. GLP-1 receptor agonists (GLP-1 RAs). <a href="https://www.kidney.org/kidney-topics/glp-1-receptor-agonists-glp-1-ras" target="_blank" rel="noopener noreferrer">kidney.org</a></li>
  <li>American Diabetes Association. Chronic kidney disease and risk management: Standards of Care in Diabetes—2024. Diabetes Care. 2024;47(Suppl 1):S239–S256. <a href="https://diabetesjournals.org/care/article/49/Supplement_1/S239/157554/11-Chronic-Kidney-Disease-and-Risk-Management" target="_blank" rel="noopener noreferrer">diabetesjournals.org</a></li>
  <li>Apovian CM, Aronne LJ, Bessesen DH, et al. Pharmacological management of obesity: an Endocrine Society clinical practice guideline. J Clin Endocrinol Metab. 2015;100(2):342–362. <a href="https://pubmed.ncbi.nlm.nih.gov/25590212/" target="_blank" rel="noopener noreferrer">pubmed.ncbi.nlm.nih.gov</a></li>
</ol>
NEFRO_HTML,
];

// ── Vkladanie do databázy (UPSERT) ──────────────────────────────────────────
// Re-spustenie po úprave obsahu prepíše existujúci článok (regenerácia).
// Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1). `category` ostáva
// 'popularne'. `pdf_file` ukazuje na ručne pripravený kurátorovaný PDF súbor
// (slug je v PROTECTED_PDF_SLUGS → automatická regenerácia ho neprepíše).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, category, published_at, is_top, is_published, pdf_file)
     VALUES (:title, :slug, :author, :content, :excerpt, 'popularne', :published_at, :is_top, 1, :pdf_file)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt),
        category = 'popularne', is_top = VALUES(is_top), pdf_file = VALUES(pdf_file)"
);

$inserted = 0; $updated = 0; $skipped = 0; $errors = []; $queuedTotal = 0;
foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title' => $a['title'], 'slug' => $a['slug'], 'author' => $a['author'],
            'content' => $a['content'], 'excerpt' => $a['excerpt'],
            'published_at' => $a['published_at'], 'is_top' => $a['is_top'],
            'pdf_file' => $a['pdf_file'],
        ]);
        $rc = $stmt->rowCount();
        if ($rc === 0) { $skipped++; continue; }
        if ($rc === 1) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try { $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId); }
            catch (\Throwable $qe) { error_log('add_obezita_oblicky newsletter enqueue error: ' . $qe->getMessage()); }
        } else {
            $updated++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . $a['title'] . '“: ' . $e->getMessage();
        error_log('add_obezita_oblicky migration error: ' . $e->getMessage());
    }
}

$total = count($articles);
if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Obezita a obličky: $inserted vložených, $updated aktualizovaných z $total.\n";
    echo "Preskočené (bez zmeny):    $skipped\n";
    echo "Zaradených do fronty avíz: $queuedTotal\n";
    foreach ($errors as $e) { echo "  - $e\n"; }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Obezita a obličky: $inserted vložených, $updated aktualizovaných, $skipped bez zmeny | Avíza: $queuedTotal\n";
    foreach ($errors as $e) { echo "  - $e\n"; }
}
