<?php
/**
 * add_pacient-diagnoza-ai-nefrologicka-ambulancia_article.php
 * Odborný článok o bezpečnom postupe pri pacientovi s diagnózou navrhnutou AI.
 * Zdrojový článok nemá uvedeného konkrétneho autora, preto nemá záznam v source_authors.php.
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
    'title'        => 'Keď pacient prichádza s diagnózou od AI: čo to mení v nefrologickej ambulancii',
    'slug'         => 'pacient-diagnoza-ai-nefrologicka-ambulancia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Ako bezpečne reagovať na diagnózu alebo liečebný návrh z chatbota: nefrologický kontext, urgentná triáž, ochrana údajov a praktický postup konzultácie.',
    'content'      => <<<'HTML'
<p>Pacient môže dnes vstúpiť do ambulancie nielen so zoznamom príznakov a výsledkov, ale aj s ucelenou „diagnózou“, prognózou alebo návrhom liečby vytvoreným generatívnou umelou inteligenciou. Takýto výstup môže obsahovať užitočné všeobecné informácie, no môže byť aj nepresný, neaktuálny alebo neprimerane sebavedomý. Pre lekára preto nie je správnou reakciou ani automatické odmietnutie, ani nekritické potvrdenie.</p>

<p>V nefrológii je riziko nesprávnej interpretácie osobitne vysoké. Jednorazová eGFR, kreatinín, albuminúria, proteinúria alebo sonografický opis nemajú spoľahlivý význam bez časového vývoja, klinického stavu, liekov, hydratácie a ďalších nálezov. Chatbot môže z hodnoty eGFR 52 ml/min/1,73 m² vytvoriť záver o „zlyhávaní obličiek“, hoci ešte nie je potvrdená chronicita; rovnako môže podceniť význam pretrvávajúcej albuminúrie pri relatívne zachovanej eGFR.</p>

<p>Úlohou nefrológa nie je súťažiť s chatbotom o autoritu. Úlohou je zistiť, čo pacient čítal, čo z toho je správne, čo chýba a či výstup neviedol k nebezpečnému rozhodnutiu. Neoverenú informáciu treba premeniť na bezpečný diagnostický a komunikačný plán.</p>

<h2>Najprv porozumieť, až potom opravovať</h2>

<p>Pacient spravidla neprináša iba text. Prináša aj obavu, nádej alebo potrebu vysvetlenia, ktorú predchádzajúca komunikácia nenaplnila. Prudké odmietnutie môže zvýšiť obrannosť a presunúť pacienta k ďalším neovereným zdrojom. Nekritické prijatie zasa môže posilniť chybnú hypotézu.</p>

<p>Prvou užitočnou otázkou je: „Môžete mi ukázať presné zadanie aj celú odpoveď, ktorá vás znepokojila?“ Zhrnutie pacienta nemusí zachytiť podmienky, výhrady ani pôvodné údaje. Dôležité je vedieť aj to, aký nástroj použil, kedy odpoveď vznikla a či do konverzácie dopĺňal ďalšie výsledky.</p>

<p>Nasleduje otázka na význam: „Čo ste si z odpovede odniesli a čoho sa najviac obávate?“ Rovnaký text môže jedného pacienta viesť k žiadosti o biopsiu, druhého k vysadeniu liekov a tretieho iba k potrebe uistenia. Bez rozpoznania tohto cieľa môže lekár síce opraviť fakt, ale nevyriešiť skutočný problém.</p>

<h2>Nie každý systém označený ako AI je rovnaký</h2>

<div class="table-responsive" role="region" aria-label="Rozdiely medzi zdrojmi zdravotných informácií využívajúcimi AI" tabindex="0">
<table>
  <thead>
    <tr>
      <th>Typ nástroja</th>
      <th>Čo môže priniesť</th>
      <th>Čo nemožno predpokladať</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>verejný všeobecný chatbot</td>
      <td>zrozumiteľné vysvetlenie pojmov, návrh otázok, orientačný prehľad možností</td>
      <td>klinickú validáciu pre konkrétneho pacienta, úplnosť kontextu alebo spoľahlivé zdroje</td>
    </tr>
    <tr>
      <td>vyhľadávač alebo odpoveď ukotvená v zdrojoch</td>
      <td>rýchle nájdenie dokumentov a odkazov</td>
      <td>že citovaný dokument podporuje presne daný záver alebo je aktuálny</td>
    </tr>
    <tr>
      <td>pacientsky portál s automatickým vysvetlením</td>
      <td>kontext konkrétneho výsledku podľa nastavenia systému</td>
      <td>že pozná celý klinický obraz alebo nahrádza komunikáciu s lekárom</td>
    </tr>
    <tr>
      <td>validovaný klinický systém alebo zdravotnícka pomôcka</td>
      <td>presne vymedzenú podporu rozhodovania v schválenej alebo overenej úlohe</td>
      <td>bezchybný výkon mimo určenej populácie, vstupov a pracovného postupu</td>
    </tr>
  </tbody>
</table>
</div>

<p>Všeobecný chatbot a regulovaný klinický systém preto nemožno hodnotiť rovnakým spôsobom. Ani označenie „medicínska AI“ samo osebe nehovorí, na akých dátach bol nástroj overený, pre akú úlohu je určený ani kto kontroluje jeho výstup.</p>

<h2>Prečo môže presvedčivá odpoveď klamať</h2>

<p>Generatívny model vytvára text na základe pravdepodobnostných vzorcov. Plynulosť a odborný tón nie sú zárukou pravdivosti. Svetová zdravotnícka organizácia upozorňuje, že veľké multimodálne modely môžu produkovať nepravdivé, nepresné, skreslené alebo neúplné tvrdenia a podporovať automatizačné skreslenie, pri ktorom človek prehliadne chybu iba preto, že výstup pôsobí autoritatívne.</p>

<p>Pri klinickom použití treba počítať najmä s tým, že model môže:</p>

<ul>
  <li>doplniť chýbajúci údaj vymysleným predpokladom,</li>
  <li>priradiť bežnému symptómu zriedkavú diagnózu bez primeranej pravdepodobnosti,</li>
  <li>vynechať nebezpečnú alternatívu alebo naliehavú potrebu vyšetrenia,</li>
  <li>zameniť asociáciu za príčinu a biomarker za definitívnu diagnózu,</li>
  <li>citovať neexistujúci alebo obsahovo nesúvisiaci zdroj,</li>
  <li>odpovedať odlišne po malej zmene zadania alebo medzi jednotlivými verziami systému,</li>
  <li>použiť odporúčanie, ktoré už nie je aktuálne alebo neplatí v slovenskom prostredí.</li>
</ul>

<p>To neznamená, že každá odpoveď je chybná. Znamená to, že jej správnosť treba posúdiť nezávisle od štýlu, značky nástroja a istoty formulácie.</p>

<h2>Nefrologický kontext: rovnaký údaj, odlišný význam</h2>

<div class="table-responsive" role="region" aria-label="Príklady nesprávnej interpretácie nefrologických údajov chatbotom" tabindex="0">
<table>
  <thead>
    <tr>
      <th>Možný záver chatbota</th>
      <th>Čo musí overiť klinik</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>„eGFR pod 60 znamená chronické zlyhávanie obličiek.“</td>
      <td>predchádzajúce hodnoty, trvanie najmenej tri mesiace, možnosť AKI, vek, svalovú hmotu, lieky a albuminúriu</td>
    </tr>
    <tr>
      <td>„Liek poškodil obličky, pretože kreatinín stúpol.“</td>
      <td>časový vzťah, veľkosť zmeny, tlak, objemový stav, draslík a očakávaný hemodynamický účinok RAS blokády alebo inhibítora SGLT2</td>
    </tr>
    <tr>
      <td>„Bielkovina v moči znamená zlyhanie obličiek.“</td>
      <td>ACR alebo PCR, perzistenciu, sediment, hematuriu, infekciu, horúčku, fyzickú záťaž, hyperglykémiu a diagnózu</td>
    </tr>
    <tr>
      <td>„Na prečistenie obličiek treba piť tri až štyri litre denne.“</td>
      <td>srdcové zlyhávanie, opuchy, diurézu, hyponatriémiu, cirhózu, dialýzu a individuálnu potrebu tekutín</td>
    </tr>
    <tr>
      <td>„Pri CKD treba vyradiť draslík, fosfor a bielkoviny.“</td>
      <td>štádium CKD, laboratórne hodnoty, výživový stav, lieky, acidobázickú rovnováhu a odporúčanie nutričného terapeuta</td>
    </tr>
    <tr>
      <td>„Detoxikačný doplnok podporí funkciu obličiek.“</td>
      <td>zloženie, dávku, kontaminanty, interakcie, obsah draslíka a fosforu a možnú priamu nefrotoxicitu</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Jedna eGFR ešte nie je chronická choroba obličiek</h2>

<p>KDIGO definuje chronickú chorobu obličiek ako abnormalitu štruktúry alebo funkcie obličiek prítomnú najmenej tri mesiace a významnú pre zdravie. Chronicitu nemožno automaticky predpokladať z jednej abnormálnej eGFR alebo ACR, pretože výsledok môže súvisieť s akútnym poškodením obličiek, akútnym ochorením, hydratáciou alebo biologickou variabilitou.</p>

<p>eGFR odvodená od kreatinínu je odhad, nie priame meranie. Interpretáciu ovplyvňuje vek a pohlavie použité vo výpočte, ale aj faktory meniace tvorbu alebo vylučovanie kreatinínu: svalová hmota, amputácia, kachexia, intenzívna fyzická záťaž, strava a niektoré lieky. Pri rýchlej zmene kreatinínu navyše nie je splnený predpoklad ustáleného stavu, preto môže byť vypočítaná eGFR pri AKI zavádzajúca. Ak je kreatinín nespoľahlivým markerom, môže byť vhodný cystatín C alebo kombinovaný odhad, prípadne meraná GFR podľa klinickej otázky.</p>

<p>Aj albuminúria významne kolíše. Izolovaný zvýšený ACR treba interpretovať s ohľadom na infekciu močových ciest, febrilitu, cvičenie, menštruáciu, hyperglykémiu a ďalšie prechodné vplyvy. Zároveň platí, že normálna eGFR nevylučuje klinicky významné ochorenie obličiek, ak je prítomná perzistujúca albuminúria, hematuria, patologický sediment alebo štrukturálna abnormalita.</p>

<h2>Najprv urgentná triáž, až potom diskusia o zdroji</h2>

<p>Debata o kvalite AI nesmie oddialiť riešenie akútneho stavu. Pacient, ktorý prišiel s výstupom chatbota, potrebuje rovnakú úvodnú triáž ako ktorýkoľvek iný pacient. Naliehavé vyšetrenie môže vyžadovať najmä:</p>

<ul>
  <li>nová anúria alebo rýchly a výrazný pokles diurézy,</li>
  <li>dýchavica, hypoxémia alebo známky pľúcneho edému,</li>
  <li>porucha vedomia, kŕče alebo závažná slabosť pri podozrení na metabolickú poruchu,</li>
  <li>palpitácie alebo svalová slabosť pri riziku závažnej hyperkaliémie,</li>
  <li>veľmi vysoký tlak sprevádzaný neurologickými príznakmi, bolesťou na hrudníku alebo dýchavicou,</li>
  <li>horúčka a bolesť v oblasti štepu alebo boku u transplantovaného či imunosuprimovaného pacienta,</li>
  <li>makroskopická hematúria so zrazeninami, retenciou moču alebo obehovou nestabilitou.</li>
</ul>

<p>Chatbot môže naliehavosť preceniť aj podceniť. O mieste a čase ďalšej starostlivosti rozhoduje aktuálny klinický stav, nie digitálny záver.</p>

<h2>Praktický šesťkrokový postup konzultácie</h2>

<ol>
  <li><strong>Vylúčiť urgentný stav.</strong> Zhodnotiť vitálne funkcie, diurézu, objemový stav a príznaky, ktoré menia naliehavosť.</li>
  <li><strong>Získať presný výstup.</strong> Pozrieť celé zadanie, odpoveď, dátum, nástroj a údaje, ktoré pacient zadal.</li>
  <li><strong>Zistiť význam pre pacienta.</strong> Pomenovať jeho obavu, očakávanie a kroky, ktoré už na základe odpovede urobil alebo plánuje.</li>
  <li><strong>Rozdeliť obsah.</strong> Oddeliť overiteľné fakty, diagnostické hypotézy, odporúčania a tvrdenia bez opory.</li>
  <li><strong>Urobiť nezávislé klinické posúdenie.</strong> Rekonštruovať časový priebeh, vyšetriť pacienta a overiť relevantné údaje podľa odporúčaní a primárnych zdrojov.</li>
  <li><strong>Uzavrieť rozhovor konkrétnym plánom.</strong> Vysvetliť, čo sa potvrdilo, čo zostáva neisté, aké vyšetrenia nasledujú, ktoré lieky sa nemenia a pri akých príznakoch má pacient vyhľadať pomoc skôr.</li>
</ol>

<p>Užitočná formulácia môže znieť: „Táto časť odpovede správne vysvetľuje všeobecný význam výsledku. Záver o vašej diagnóze však zatiaľ nie je podložený, pretože chýba časový vývoj, vyšetrenie moču a zhodnotenie liekov. Dohodnime si, ako to overíme.“ Takýto postup rešpektuje pacientovu iniciatívu a zároveň udržiava klinické hranice.</p>

<h2>Pacient môže priniesť aj užitočnú stopu</h2>

<p>Chyba by bola predpokladať, že každá hypotéza z AI je bezcenná. Pacient môže vďaka chatbotu pomenovať prehliadaný symptóm, spýtať sa na rodinné ochorenie alebo upozorniť na možnú liekovú interakciu. Správnou odpoveďou je preveriť medicínsku pravdepodobnosť a dôkazy, nie hodnotiť myšlienku podľa toho, či ju vyslovil človek alebo systém.</p>

<p>Rovnaké riziko ukotvenia vzniká na oboch stranách. Pacient sa môže upnúť na výstup chatbota, lekár zasa na prvý dojem, že „internetová diagnóza“ je určite nesprávna. Bezpečnejší je explicitný diferenciálnodiagnostický postup: čo hypotézu podporuje, čo jej odporuje, čo je pravdepodobnejšie a ktorý test alebo časový vývoj môže rozhodnúť.</p>

<p>Kvalitatívna štúdia 34 pacientov v siedmich fokusových skupinách o AI v rádiologickej diagnostike ukázala význam transparentnosti, nezávislého posúdenia lekárom a zachovania empatického vzťahu. Výsledky nemožno priamo preniesť na používanie chatbotov v nefrológii ani z nich odhadovať názory celej populácie, podporujú však praktický význam ľudskej interpretácie a vysvetlenia.</p>

<h2>Súkromie: zdravotné údaje nie sú bežný text</h2>

<p>Verejne dostupný chatbot nemusí mať rovnaké zmluvné, bezpečnostné a retenčné pravidlá ako schválený nemocničný systém. Podmienky sa medzi službami líšia a môžu sa meniť. Pacient ani zdravotník by preto nemali do neoverenej služby vkladať meno, rodné číslo, adresu, kontakty, celé lekárske správy, fotografie dokumentov alebo obrazové súbory s identifikátormi.</p>

<p>Odstránenie mena nemusí vždy znamenať spoľahlivú anonymizáciu. Kombinácia dátumu narodenia, zriedkavej diagnózy, pracoviska, dátumov výkonov alebo metadát obrazového súboru môže umožniť opätovnú identifikáciu. Pri použití AI v zdravotníckom zariadení treba používať iba schválené pracovné prostredie a rešpektovať pravidlá prevádzkovateľa, ochrany osobných údajov, mlčanlivosti a minimalizácie dát.</p>

<p>Ak AI výstup významne ovplyvnil konzultáciu alebo viedol pacienta k zmene liečby, je primerané túto skutočnosť stručne zaznamenať v dokumentácii spolu s klinickým posúdením a poučením. Nie je však potrebné bezdôvodne kopírovať celú súkromnú konverzáciu do zdravotnej dokumentácie.</p>

<h2>Čomu sa v komunikácii vyhnúť</h2>

<ul>
  <li><strong>Zosmiešneniu:</strong> znižuje dôveru a neodstraňuje nesprávnu informáciu.</li>
  <li><strong>Súboju autorít:</strong> veta „AI sa mýli, lebo ja som lekár“ nevysvetľuje dôkaz ani neistotu.</li>
  <li><strong>Falošnej istote:</strong> ani lekár nemusí mať diagnózu po prvej návšteve; neistotu treba pomenovať spolu s plánom jej znižovania.</li>
  <li><strong>Nekritickému preberaniu výstupu:</strong> chatbot nemá byť skratkou k diagnóze alebo preskripcii.</li>
  <li><strong>Paušálnym zákazom:</strong> realistickejšie je naučiť pacienta, na čo je nástroj vhodný, čo má overovať a ktoré údaje mu neposkytovať.</li>
  <li><strong>Ignorovaniu samoliečby:</strong> treba sa priamo opýtať na vysadené lieky, nové doplnky, zmeny diéty a príjmu tekutín.</li>
</ul>

<h2>Limity zdrojového materiálu</h2>

<p>Hlavný zdroj je spravodajský článok Medscape News Europe založený na diskusii francúzskej Lekárskej komory z 8. apríla 2026. Nejde o klinickú štúdiu, systematický prehľad ani odborné odporúčanie.</p>

<p>Zo zdroja nemožno určiť prevalenciu používania AI pacientmi, presnosť modelov ani vplyv na morbiditu, adherenciu či počet vyšetrení. Výrok, že lekári nepoužívajúci AI budú nahradení, je názor diskutujúceho, nie vedecky potvrdený výsledok. Všeobecné riziká AI sú preto doplnené podľa WHO, nefrologické tvrdenia podľa KDIGO a ochrana údajov podľa európskych a francúzskych materiálov.</p>

<h2>Záver</h2>

<p>Diagnóza od chatbota nie je diagnózou v klinickom zmysle, ale môže byť dôležitou súčasťou pacientovho príbehu. Môže obsahovať chybu, užitočnú stopu aj informáciu o tom, čomu pacient nerozumie alebo čoho sa obáva.</p>

<p>Bezpečný nefrologický postup má tri piliere: najprv vylúčiť urgentný stav, potom nezávisle overiť údaje v časovom a klinickom kontexte a napokon uzavrieť konzultáciu jasným plánom. Generatívna AI môže pomáhať formulovať otázky a vysvetľovať pojmy, no individuálne rozhodnutie musí zostať ukotvené vo vyšetrení, dôkazoch, preferenciách pacienta a zodpovednej klinickej komunikácii.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Medscape News Europe. When Patients Arrive With AI Diagnoses. 7. júla 2026. Konkrétny autor v dostupnej publikácii nie je uvedený. <a href="https://www.medscape.com/viewarticle/when-patients-arrive-ai-diagnoses-2026a1000muh" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></p>

<p><em><strong>Podujatie:</strong> Conseil national de l’Ordre des médecins. La relation médecin-patient: un colloque singulier. Program diskusného dňa 8. apríla 2026. <a href="https://www.conseil-national.medecin.fr/publications/actualites/relation-medecin-patient-colloque-singulier" target="_blank" rel="noopener noreferrer">CNOM</a>.</em></p>

<p><em><strong>Odborné zdroje:</strong> World Health Organization. Ethics and governance of artificial intelligence for health: guidance on large multi-modal models. 2024. <a href="https://www.who.int/publications/b/70584" target="_blank" rel="noopener noreferrer">WHO</a> · KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO</a>.</em></p>

<p><em><strong>Ochrana údajov:</strong> European Data Protection Board. AI Privacy Risks &amp; Mitigations: Large Language Models. 2025. <a href="https://www.edpb.europa.eu/documents/support-pool-of-experts/ai-privacy-risks-mitigations-large-language-models-llms_en" target="_blank" rel="noopener noreferrer">EDPB</a> · Commission nationale de l’informatique et des libertés. Chatbots: les conseils de la CNIL pour respecter les droits des personnes. <a href="https://www.cnil.fr/fr/chatbots-les-conseils-de-la-cnil-pour-respecter-les-droits-des-personnes" target="_blank" rel="noopener noreferrer">CNIL</a>.</em></p>

<p><em><strong>Doplňujúca štúdia:</strong> Karger CR. Patients’ Perspectives on the Implementation of AI in Radiological Diagnostics: Focus Group Study. <em>Journal of Medical Internet Research</em>. 2026;28:e89178. DOI: 10.2196/89178. <a href="https://www.jmir.org/2026/1/e89178" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
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
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_patient_ai_diagnosis newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_patient_ai_diagnosis pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_patient_ai_diagnosis pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_patient_ai_diagnosis migration error: ' . $e->getMessage());
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
