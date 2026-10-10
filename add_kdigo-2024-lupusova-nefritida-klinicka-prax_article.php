<?php
/**
 * Odborne revidovaný prehľad implementácie KDIGO 2024 pri lupusovej nefritíde.
 * Idempotentné publikovanie cez aktuálnu šablónu a article_publisher.php.
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Ako aplikovať odporúčania KDIGO 2024 pre lupusovú nefritídu v klinickej praxi',
    'slug'         => 'kdigo-2024-lupusova-nefritida-klinicka-prax',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktické uplatnenie KDIGO 2024 pri lupusovej nefritíde: výber liečby podľa biopsie, ciele renálnej odpovede, bezpečné znižovanie glukokortikoidov a postup pri nedostatočnej odpovedi.',
    'content'      => <<<'HTML'
<p>Lupusová nefritída (LN) je orgánová manifestácia systémového lupus erythematosus (SLE), pri ktorej treba potlačiť imunitne podmienený zápal a zároveň obmedziť nezvratné poškodenie obličiek aj toxicitu liečby. Odporúčania KDIGO 2024 poskytujú praktický rámec: rozhodovanie vychádza z biopsie, aktivity ochorenia, funkcie obličiek a priebežnej liečebnej odpovede. Novšie kombinácie rozširujú možnosti liečby, ale nenahrádzajú dôsledné sledovanie pacienta. [1]</p>

<figure>
<a href="img/kdigo-2024-lupusova-nefritida-klinicka-prax.webp" target="_blank" rel="noopener noreferrer"><img src="img/kdigo-2024-lupusova-nefritida-klinicka-prax.webp" alt="Ilustračný rez obličkou so zväčšeným glomerulom a symbolickým zobrazením imunitne podmieneného zápalu" width="1586" height="992" loading="lazy" decoding="async"></a>
<figcaption>Ilustračné zobrazenie lupusovej nefritídy. Cieľom liečby je zvládnuť zápal v glomeruloch a zachovať funkčné obličkové tkanivo. Obrázok nie je histologickým nálezom.</figcaption>
</figure>

<h2>Čo KDIGO 2024 mení a ako čítať jeho odporúčania</h2>
<p>Dokument predstavuje cielenú aktualizáciu kapitoly o LN z odporúčaní KDIGO 2021 pre glomerulárne ochorenia. Zohľadňuje najmä dôkazy pre belimumab a voklosporín a podporuje znižovanie expozície glukokortikoidom. Rozlišuje formálne odporúčania s hodnotením sily a istoty dôkazov od praktických bodov, ktoré pomáhajú individualizovať liečbu. Napríklad označenie <strong>1B</strong> znamená silné odporúčanie založené na dôkazoch strednej istoty. Praktické body nemajú rovnaký stupeň formálneho hodnotenia. [1]</p>
<p>Nasledujúci prehľad sa sústreďuje na dospelých a na uplatnenie KDIGO 2024. Samostatná záverečná časť uvádza novší vývoj. Konkrétny liek, dávku a kombináciu treba vždy zosúladiť s aktuálnym súhrnom charakteristických vlastností lieku (SPC), komorbiditami a dostupnosťou liečby.</p>

<h2>1. Najprv určiť, čo sa má liečiť</h2>
<p>Pri podozrení na LN treba vyšetriť sérový kreatinín a odhadovanú glomerulárnu filtráciu (eGFR), močový sediment, kvantifikovať proteinúriu a posúdiť protilátky proti dvojvláknovej DNA (anti-dsDNA) aj zložky komplementu C3 a C4. Klinické rozhodovanie dopĺňajú krvný tlak, opuchy, sérový albumín a extrarenálna aktivita SLE. Izolovaná sérologická odchýlka sama osebe neurčuje potrebu eskalácie renálnej imunosupresie. [1]</p>
<p>KDIGO uvádza <strong>proteinúriu ≥ 500 mg/24 h ako podnet na zváženie biopsie</strong>. Nejde o hranicu, pod ktorou je závažná nefritída vylúčená. Aktívny sediment alebo nevysvetlené zhoršovanie funkcie obličiek môžu odôvodniť biopsiu aj pri nižšej proteinúrii. Pri rýchlo progredujúcom priebehu je potrebné urgentné odborné zhodnotenie. [1]</p>
<p>Bioptický nález má okrem triedy podľa ISN/RPS opísať aktivitu, chronicitu a tubulointersticiálne či cievne poškodenie. Aktívny zápal a jazvovité poškodenie nemajú rovnakú liečebnú ovplyvniteľnosť. Praktické rozlíšenie je nasledovné:</p>
<ul>
<li><strong>Trieda I alebo II:</strong> imunosupresiu spravidla určujú extrarenálne prejavy. Pri nefrotickom syndróme treba myslieť na lupusovú podocytopatiu a zhodnotiť elektrónovú mikroskopiu.</li>
<li><strong>Aktívna trieda III alebo IV, aj v kombinácii s triedou V:</strong> vyžaduje liečbu proliferatívnej LN.</li>
<li><strong>Čistá trieda V:</strong> postup závisí najmä od závažnosti proteinúrie a jej komplikácií; nemožno na ňu automaticky preniesť všetky závery pre proliferatívnu LN.</li>
<li><strong>Prevažne chronické poškodenie bez aktivity:</strong> uprednostňuje sa liečba chronickej choroby obličiek; samotná reziduálna proteinúria nie je dôkazom potreby intenzívnejšej imunosupresie. [1]</li>
</ul>

<h2>2. Podporná liečba patrí do každého plánu</h2>
<p><strong>Hydroxychlorochín sa odporúča pacientom so SLE vrátane LN, pokiaľ nie je kontraindikovaný</strong> (1C). Dávku a oftalmologické sledovanie treba prispôsobiť aj funkcii obličiek a riziku retinálnej toxicity. Súčasťou starostlivosti je kontrola krvného tlaku, obmedzenie nadmerného príjmu soli, nefroprotekcia, prevencia infekcií a posúdenie kardiovaskulárneho, kostného a reprodukčného rizika. [1]</p>
<p>Blokáda renínovo-angiotenzínového systému má miesto pri proteinúrii a hypertenzii, ak ju umožňuje krvný tlak, kaliémia a funkcia obličiek. KDIGO uvádza aj inhibítory SGLT2 medzi nefroprotektívnymi možnosťami u stabilných pacientov bez akútneho poškodenia obličiek. Ich použitie vyžaduje individuálne posúdenie; nie sú liečbou aktívneho imunitného zápalu. [1]</p>
<p>Pred imunosupresiou treba skontrolovať krvný obraz, pečeňové testy, kreatinín, elektrolyty, infekčné riziká a očkovanie. Podľa plánovanej liečby a rizika pacienta sa dopĺňa infekčný skríning a zvažuje profylaxia pneumónie vyvolanej <em>Pneumocystis jirovecii</em>. Pri cyklofosfamide treba vopred diskutovať ochranu fertility a kumulatívnu expozíciu. [1]</p>

<h2>3. Úvodná liečba aktívnej triedy III alebo IV</h2>
<p>KDIGO 2024 odporúča glukokortikoidy spolu s jednou zo štyroch možností uvedených nižšie; odporúčanie sa vzťahuje aj na súčasnú membranóznu zložku. <strong>Trojkombinácia je jednou z možností úvodnej liečby, nie povinným režimom pre každého pacienta.</strong> Analógy kyseliny mykofenolovej (MPAA) zahŕňajú mykofenolát-mofetil (MMF) a prípravky kyseliny mykofenolovej. [1]</p>

<div class="table-responsive" role="region" aria-label="Možnosti úvodnej liečby proliferatívnej lupusovej nefritídy" tabindex="0">
<table>
<thead><tr><th scope="col">Režim popri glukokortikoidoch</th><th scope="col">Praktické rozhodovanie</th></tr></thead>
<tbody>
<tr><th scope="row">MPAA</th><td>Štandardná možnosť (1B). Vhodná najmä pri snahe vyhnúť sa gonadotoxicite cyklofosfamidu; treba posúdiť toleranciu, adherenciu a reprodukčné plány.</td></tr>
<tr><th scope="row">Nízkodávkovaný intravenózny cyklofosfamid</th><td>Štandardná možnosť (1B). Režim Euro-Lupus používa 500 mg každé dva týždne, spolu šesť dávok. Intravenózne podanie môže pomôcť pri problémoch s pravidelným užívaním perorálnej liečby.</td></tr>
<tr><th scope="row">Belimumab + MPAA alebo nízkodávkovaný intravenózny cyklofosfamid</th><td>Možnosť úvodnej trojkombinácie (1B). KDIGO ju osobitne zvažuje pri opakovaných renálnych vzplanutiach alebo vysokom riziku progresie.</td></tr>
<tr><th scope="row">MPAA + inhibítor kalcineurínu (CNI)</th><td>Možnosť úvodnej trojkombinácie (1B), ak funkcia obličiek nie je závažne znížená. Výhodná môže byť pri nefrotickej proteinúrii a relatívne zachovanej eGFR; vyžaduje kontrolu nefrotoxicity a interakcií.</td></tr>
</tbody>
</table>
</div>
<p>Voľba režimu zohľadňuje aj histologický nález, extrarenálne prejavy, predchádzajúcu liečbu, infekcie a preferencie pacienta. Pacienti s prudkým poklesom funkcie obličiek alebo veľmi závažným nálezom boli v registračných štúdiách zastúpení obmedzene; ich liečbu nemožno odvodiť iba z priemerných výsledkov. [1]</p>

<h3>Čo preukázali BLISS-LN a AURORA 1</h3>
<p>V štúdii <strong>BLISS-LN</strong> bolo randomizovaných 448 pacientov. Belimumab pridaný k štandardnej liečbe zvýšil v 104. týždni podiel pacientov s primárnou renálnou odpoveďou zo 32 % na 43 % a s úplnou renálnou odpoveďou z 20 % na 30 %. Primárna renálna odpoveď a úplná odpoveď boli rozdielne zložené ukazovatele. Výsledok podporuje účinnosť kombinácie, nie belimumabu v monoterapii. [2]</p>
<p>V štúdii <strong>AURORA 1</strong> bolo randomizovaných 357 pacientov. Voklosporín pridaný k MMF a glukokortikoidom zvýšil podiel úplnej renálnej odpovede v 52. týždni z 23 % na 41 %. Závažné nežiaduce udalosti sa vyskytli približne u 21 % pacientov v oboch skupinách. To nevylučuje individuálne riziko nefrotoxicity alebo infekcie. [3]</p>
<p>Tieto percentá sa nemajú používať na priame poradie účinnosti belimumabu a voklosporínu: štúdie sa líšili populáciou, trvaním aj definíciami odpovede. Pokles proteinúrie pri CNI navyše zahŕňa aj účinky na podocyty a glomerulárnu hemodynamiku; sám osebe nedokazuje ústup histologickej aktivity. [1–3]</p>

<h3>Voklosporín: dôležité rozlíšenie odporúčania a SPC</h3>
<p>KDIGO 2024 upozorňuje na hranicu eGFR približne <strong>45 ml/min/1,73 m²</strong> pri výbere režimu s CNI; pacienti s eGFR ≤ 45 ml/min/1,73 m² neboli zaradení do kľúčových štúdií voklosporínu. Nejde však o univerzálnu absolútnu kontraindikáciu všetkých CNI. Aktuálne európske SPC pri eGFR 30 až &lt; 45 ml/min/1,73 m² pripúšťa voklosporín iba po zvážení prevahy prínosu nad rizikom. Odporúčanie, študijné kritérium a regulačné podmienky nie sú totožné. [1,4]</p>
<p>SPC odporúča vyšetriť eGFR pred začatím liečby, potom každé dva týždne počas prvého mesiaca a následne každé štyri týždne. Pri potvrdenom poklese funkcie obličiek sa dávka upravuje alebo liečba prerušuje podľa algoritmu SPC. Sleduje sa tiež krvný tlak, kaliémia a liekové interakcie; súbežné podávanie silných inhibítorov CYP3A4 je kontraindikované. [4]</p>

<h2>4. Znižovanie glukokortikoidov naplánovať od začiatku</h2>
<p>KDIGO umožňuje po krátkej liečbe intravenóznym metylprednizolónom použiť režim s nižšími dávkami perorálnych glukokortikoidov, ak sa renálne aj extrarenálne prejavy primerane zlepšujú. Uvádza viacero príkladov dávkovania, nie jedinú povinnú schému. V príklade redukovaného režimu klesá prednizón alebo jeho ekvivalent na 5 mg/deň v 11. až 12. týždni a na 2,5 mg/deň v 13. až 14. týždni. Takéto tempo treba prispôsobiť klinickej odpovedi. [1]</p>
<p>Pri každej kontrole má byť zrejmá aktuálna dávka, ďalší plán redukcie a dôvod prípadného spomalenia. Znižovanie expozície glukokortikoidom neznamená tolerovať pretrvávajúci aktívny zápal ani nahradiť hodnotenie ochorenia samotnou snahou dosiahnuť nízku dávku.</p>

<h2>5. Odpoveď hodnotiť číslami aj v čase</h2>
<p>Na sledovanie treba používať konzistentnú metódu kvantifikácie proteinúrie a vždy uvádzať jednotky. Pomer bielkovín ku kreatinínu v moči (UPCR) v g/g nie je totožný údaj s denným vylučovaním bielkovín v g/24 h. Nasledujúce definície vychádzajú z prehľadu bežne používaných kritérií v KDIGO; jednotlivé štúdie sa v detailoch líšia. [1]</p>
<ul>
<li><strong>Čiastočná odpoveď:</strong> pokles proteinúrie aspoň o 50 % a UPCR &lt; 3 g/g, spolu so stabilizáciou alebo zlepšením funkcie obličiek, obvykle do 6 až 12 mesiacov.</li>
<li><strong>Úplná odpoveď:</strong> UPCR &lt; 0,5 g/g a stabilizácia alebo zlepšenie funkcie obličiek; často do 6 až 12 mesiacov, niekedy neskôr. KDIGO pri stabilite funkcie uvádza rozmedzie približne ±10 až 15 % východiskovej hodnoty.</li>
<li><strong>Vývoj je dôležitejší než izolovaná kontrola:</strong> pri sústavnom zlepšovaní môže byť primerané umožniť dosiahnutie úplnej odpovede v priebehu 18 až 24 mesiacov. Tento postup sa nevzťahuje na pacienta, ktorého stav stagnuje alebo sa zhoršuje. [1]</li>
</ul>
<p>Sérológia, sediment, albumín, opuchy a extrarenálna aktivita dopĺňajú hodnotenie. Pretrvávanie anti-dsDNA alebo nízkeho komplementu môže sprevádzať aj klinické zlepšenie. Naopak, klinická odpoveď nevylučuje reziduálnu histologickú aktivitu. Pri zásadných rozhodnutiach môže preto pomôcť opakovaná biopsia. [1]</p>

<h2>6. Nedostatočná odpoveď neznamená automaticky pridať ďalší liek</h2>
<p><strong>Ak sa stav po 3 až 4 týždňoch liečby nezlepšuje alebo sa zhoršuje, treba príčinu prehodnotiť včas.</strong> Pri rýchlom zhoršovaní sa nečaká na tento interval. U pacienta, ktorý sa zlepšuje, ale nedostatočne, KDIGO odporúča znovu posúdiť priebeh približne po 3 až 4 mesiacoch. Formálne hodnotenie odpovede po 6 až 12 mesiacoch nesmie viesť k odkladu potrebného zásahu. [1]</p>
<ol>
<li>Overiť skutočné užívanie liekov, toleranciu a dostupnosť predpísanej liečby.</li>
<li>Skontrolovať dávky, podané infúzie, interakcie a podľa situácie liekové koncentrácie.</li>
<li>Hľadať infekciu, hemodynamické príčiny, liekovú nefrotoxicitu a inú príčinu zhoršenia.</li>
<li>Zvážiť opakovanú biopsiu, najmä pri otázke aktivity oproti chronicite alebo podozrení na trombotickú mikroangiopatiu.</li>
<li>Pri preukázanej pretrvávajúcej aktivite zmeniť odporúčaný režim; pri refraktérnom priebehu zvážiť ďalšiu liečbu v skúsenom centre. KDIGO 2024 uvádza aj rituximab, pričom dôkazy pri refraktérnej LN sú slabšie než pri štandardnej úvodnej liečbe. [1]</li>
</ol>

<h2>7. Udržiavacia liečba a čistá trieda V</h2>
<p>Po úvodnej liečbe proliferatívnej LN KDIGO odporúča MPAA na udržiavanie odpovede (1B). Azatioprín je alternatívou pri intolerancii, nedostupnosti MPAA alebo plánovaní gravidity. Úvodná a udržiavacia imunosupresia majú spolu trvať <strong>najmenej 36 mesiacov</strong>; ide o minimálny rámec, nie o automatický termín vysadenia. V účinnej trojkombinácii s belimumabom alebo CNI možno pokračovať aj v udržiavacej fáze podľa prínosu a rizika. [1]</p>
<p>Glukokortikoidy sa znižujú na najnižšiu potrebnú dávku. Ich vysadenie možno zvážiť po najmenej 12 mesiacoch udržanej úplnej klinickej renálnej odpovede, ak ich nevyžaduje extrarenálna aktivita. To neznamená súčasné vysadenie celej imunosupresie. [1]</p>
<p>Pri <strong>čistej triede V s nízkou proteinúriou</strong> sa uplatňuje podporná liečba, hydroxychlorochín a sledovanie; imunosupresiu môžu určovať extrarenálne prejavy. Pri nefrotickej proteinúrii alebo jej komplikáciách sa zvažuje glukokortikoid s ďalším imunosupresívom. Rozhodovanie ovplyvňujú opuchy, dyslipidémia a trombotické riziko. Dôkazy pre jednotlivé kombinácie sú pri čistej triede V menej presvedčivé než pri proliferatívnej LN. [1]</p>

<h2>8. Praktický plán pre ambulanciu a oddelenie</h2>
<p>Nasledujúci pracovný postup je praktickou syntézou, nie doslovným harmonogramom KDIGO:</p>
<ul>
<li><strong>Pri začatí liečby:</strong> zaznamenať histologickú triedu, aktivitu a chronicitu, kreatinín/eGFR, proteinúriu s jednotkami, sediment, albumín, krvný tlak, sérológiu, bezpečnostné laboratórne výsledky a reprodukčné plány.</li>
<li><strong>V liečebnom pláne:</strong> uviesť dôvod výberu kombinácie, dávky, postup redukcie glukokortikoidov, infekčnú prevenciu a zodpovednosť nefrológa a reumatológa.</li>
<li><strong>V prvých týždňoch:</strong> zabezpečiť skoré kontroly podľa závažnosti a SPC. Krvný obraz, funkcia obličiek, elektrolyty a ďalšie vyšetrenia sa prispôsobujú konkrétnemu lieku; pri voklosporíne platí uvedený osobitný plán eGFR.</li>
<li><strong>Priebežne:</strong> porovnávať proteinúriu a funkciu obličiek s východiskom, sledovať infekcie a toxicitu a určiť termín ďalšieho zhodnotenia. Horúčka, oligúria, prudký vzostup kreatinínu alebo výrazná cytopénia vyžadujú skorý kontakt s pracoviskom.</li>
<li><strong>Pri plánovaní gravidity:</strong> zosúladiť liečbu vopred. KDIGO odporúča počkať najmenej šesť mesiacov od ústupu aktivity LN; mykofenolát nie je vhodný počas gravidity. Prechod na kompatibilnú liečbu musí byť plánovaný a kontrolovaný. [1,4]</li>
</ul>

<div class="pdf-keep-together">
<h2>Čo pribudlo po KDIGO 2024</h2>
<p>Vývoj sa vydaním odporúčaní nezastavil. V štúdii fázy III <strong>REGENCY</strong>, publikovanej v roku 2025, dosiahlo úplnú renálnu odpoveď v 76. týždni 46,4 % pacientov s obinutuzumabom oproti 33,1 % s placebom; obe skupiny dostávali MMF a glukokortikoidy. Závažné nežiaduce udalosti, najmä infekcie, boli častejšie pri obinutuzumabe. [5]</p>
<p>EMA už uvádza obinutuzumab v kombinácii s MMF pre dospelých s aktívnou LN triedy III alebo IV, so súčasnou triedou V alebo bez nej. Ide o <strong>novší dôkazový a regulačný vývoj, nie o odporúčanie KDIGO 2024</strong>. Registračná indikácia sama osebe nepotvrdzuje dostupnosť ani úhradu na Slovensku; tie treba overiť pri konkrétnom predpise. [6]</p>

</div>
<h2>Záver</h2>
<p>Uplatnenie KDIGO 2024 začína rozlíšením aktívneho zápalu od chronického poškodenia. Nasleduje výber primeranej kombinácie, podporná liečba, plán znižovania glukokortikoidov a včasné hodnotenie účinnosti aj bezpečnosti. Dobre vedená starostlivosť má pre každého pacienta jasný cieľ, termín kontroly a postup pre prípad nedostatočnej odpovede. Rozhodovanie musí vychádzať zo spoločného posúdenia obličkového a systémového ochorenia.</p>

<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) Lupus Nephritis Work Group. KDIGO 2024 Clinical Practice Guideline for the Management of Lupus Nephritis. Kidney International. 2024;105(1S):S1–S69. <a href="https://kdigo.org/wp-content/uploads/2024/01/KDIGO-2024-Lupus-Nephritis-Guideline.pdf" target="_blank" rel="noopener noreferrer">Úplné odporúčania KDIGO</a>.</em></small></li>
<li><small><em>Furie R, et al. Two-Year, Randomized, Controlled Trial of Belimumab in Lupus Nephritis. New England Journal of Medicine. 2020;383:1117–1128. DOI: 10.1056/NEJMoa2001180. <a href="https://pubmed.ncbi.nlm.nih.gov/32937045/" target="_blank" rel="noopener noreferrer">PubMed, PMID 32937045</a>.</em></small></li>
<li><small><em>Rovin BH, et al. Efficacy and safety of voclosporin versus placebo for lupus nephritis (AURORA 1): a double-blind, randomised, multicentre, placebo-controlled, phase 3 trial. Lancet. 2021;397:2070–2080. DOI: 10.1016/S0140-6736(21)00578-X. <a href="https://pubmed.ncbi.nlm.nih.gov/33971155/" target="_blank" rel="noopener noreferrer">PubMed, PMID 33971155</a>.</em></small></li>
<li><small><em>European Medicines Agency. Lupkynis: EPAR a aktuálne informácie o lieku, najmä časti 4.2 až 4.5 SPC. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/lupkynis" target="_blank" rel="noopener noreferrer">Oficiálna dokumentácia EMA</a>.</em></small></li>
<li><small><em>Furie RA, et al. Efficacy and Safety of Obinutuzumab in Active Lupus Nephritis. New England Journal of Medicine. 2025;392:1471–1483. DOI: 10.1056/NEJMoa2410965. <a href="https://pubmed.ncbi.nlm.nih.gov/39927615/" target="_blank" rel="noopener noreferrer">PubMed, PMID 39927615</a>.</em></small></li>
<li><small><em>European Medicines Agency. Gazyvaro: EPAR, terapeutická indikácia pri aktívnej lupusovej nefritíde. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/gazyvaro" target="_blank" rel="noopener noreferrer">Oficiálna dokumentácia EMA</a>.</em></small></li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kdigo-2024-lupusova-nefritida-klinicka-prax_article',
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
