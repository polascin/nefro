<?php
/**
 * add_retatrutid-expanded-access-lekar-pacient-bariery_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: americký expanded-access proces k retatrutidu
 * (komentár Medscape, Caroline Messer) a odlíšenie od slovenského/EÚ rámca.
 * Autor projektu: MUDr. Ľubomír Polaščín. Pôvodná autorka zdroja je v
 * source_authors.php. Postup: git commit (SFTP) → SSH UPSERT.
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'Retatrutid a „pitting the physician against the patient“: bariéry procesu expanded access v praxi a význam pre nefrológiu',
    'slug'         => 'retatrutid-expanded-access-lekar-pacient-bariery',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Komentár Medscape opisuje americký expanded access k retatrutidu ako prekážku, nie most. Proces vyžaduje súhlas výrobcu, formulár FDA aj IRB; na Slovensku ide o iný právny rámec.',
    'content'      => <<<'HTML'
<p>Komentár Caroline Messer na portáli Medscape nesie názov <em>Retatrutide: Pitting Physician Against Patient</em>. Nie je to správa o účinnosti molekuly a nie je to ani text o internetovom predaji neschválených peptidov. Ide o <strong>procesný problém</strong>: pacient podľa verejných kritérií výrobcu „spĺňa“ podmienky predschvaľovacieho prístupu k <strong>retatrutidu</strong>, no cesta k lieku vedie cez niekoľko nezávislých brán. Autorka to v americkom prostredí opisuje ako prekážku, ktorá môže postaviť lekára proti očakávaniu pacienta.</p>

<p>Tento článok oddeľuje <strong>overiteľné fakty</strong> (kto rozhoduje, aké formuláre a aké vstupné kritériá sú verejne uvedené) od <strong>názoru</strong> (či je administratívna záťaž neprimeraná a či vzťah lekár – pacient trpí). Opisuje <strong>americký</strong> režim <em>expanded access</em> („rozšírený prístup“) a výslovne ho <strong>neprekladá 1 : 1</strong> na Slovensko ani na EÚ. Od <a href="article.php?slug=retatrutid-mimo-schvalenia-neregulovane-pouzivanie">neregulovaného používania produktov označených ako retatrutid</a> sa líši v jednom bode, na ktorom stojí celá téma: ide o <strong>legálnu, ale úzku cestu k autentickému skúšanému lieku</strong>, nie o obídenie regulácie.</p>

<h2>Čo retatrutid je – a čo zatiaľ nie je</h2>

<p>Retatrutid (LY3437943) je <strong>skúšaný</strong> raz týždenne podávaný <strong>trojitý agonista receptorov pre GIP, GLP-1 a glukagón</strong>. Vo fáze 2 u dospelých s obezitou viedla 48-týždňová liečba k výraznému poklesu hmotnosti: pri dávke 12 mg bol priemerný pokles <strong>24,2 %</strong> oproti <strong>2,1 %</strong> pri placebe (Jastreboff a kol., <em>N Engl J Med</em> 2023; PMID 37366315). To je kontext účinnosti, nie dôvod predpisovať liek mimo schválenia. Retatrutid <strong>nemá</strong> v čase písania tohto textu schválenie FDA ani EMA na žiadnu indikáciu. Fáza 3 (programy TRIUMPH a TRANSCEND) prebieha; renálne ukazovatele v uvedenej fáze 2 <strong>neboli primárnym cieľom</strong> a tento článok z nich nevyvodzuje benefit pre chronickú chorobu obličiek (CKD).</p>

<p>Výrobca vo verejných materiáloch uvádza, že pre obmedzený počet pacientov, ktorí spĺňajú medicínske kritériá a nemôžu vstúpiť do klinického skúšania, považuje za medicínsky primerané sprístupniť autentický retatrutid pred schválením FDA, v súlade s usmernením úradu. To je východisko komentára Medscape. Otázka nie je, či molekula „funguje“, ale <strong>ako sa k nej pacient vôbec môže dostať</strong>.</p>

<h2>Fakty: čo expanded access v USA znamená</h2>

<p>Americký Úrad pre kontrolu potravín a liečiv (FDA) označuje <em>expanded access</em> (často aj „compassionate use“) ako možnú cestu pre pacienta so <strong>závažným alebo bezprostredne život ohrozujúcim</strong> ochorením k <strong>skúšanému</strong> lieku mimo klinického skúšania, ak nie je k dispozícii porovnateľná uspokojivá liečba. Skúšaný produkt ešte <strong>neprešiel</strong> rozhodnutím FDA o bezpečnosti a účinnosti pre dané použitie; účinok u konkrétneho pacienta je neistý a môžu sa vyskytnúť neočakávané závažné nežiaduce účinky.</p>

<p>Pre individuálneho pacienta mimo naliehavej situácie FDA vo verejnej príručke pre lekárov uvádza tieto kroky:</p>

<ol>
  <li><strong>List splnomocnenia</strong> (<em>Letter of Authorization</em>, LOA) od výrobcu, ktorý umožňuje FDA odkázať na už existujúcu žiadosť o skúšaný nový liek (IND) dodávateľa. Ak LOA nie je, treba predložiť dostatočné údaje o kvalite lieku.</li>
  <li><strong>Podanie FDA:</strong> prednostne zjednodušený <strong>formulár FDA 3926</strong> (individuálny pacient); naďalej je prípustný aj starší <strong>formulár FDA 1571</strong> (IND). Formulár 1571 ostáva povinný pri iných typoch expanded access (stredne veľká populácia, treatment IND) a pri podaniach komerčného sponsora.</li>
  <li><strong>Schválenie inštitucionálnej etickej komisie</strong> (IRB) podľa 21 CFR časť 56. Pri podaní cez formulár 3926 môže lekár požiadať o súhlas predsedu IRB alebo určeného člena namiesto zasadnutia pléna. Pri formulári 1571 treba na rovnakú výnimku samostatnú žiadosť o odpustenie.</li>
  <li><strong>Informovaný súhlas</strong> pacienta alebo zákonného zástupcu podľa 21 CFR časť 50, na formulári schválenom IRB.</li>
</ol>

<p>Liečbu pri individuálnom IND mimo naliehavej situácie spravidla nemožno začať skôr, ako uplynie <strong>30 dní</strong> od doručenia podania FDA (alebo kým FDA skôr oznámi, že podanie nezdrží) <strong>a</strong> kým je k dispozícii súhlas IRB. FDA <strong>nemôže prinútiť</strong> výrobcu, aby liek dodal. Ochota výrobcu je preto praktickým predpokladom, nie formalitou. To je verejný fakt úradu, nie interpretácia komentára.</p>

<h2>Fakty: kto podľa Lilly a ClinicalTrials.gov spĺňa kritériá</h2>

<p>Predschvaľovací individuálny prístup k retatrutidu je verejne evidovaný ako <strong>NCT07629401</strong> (<em>Pre-approval Expanded Access of Retatrutide</em>). Podľa záznamu musia byť splnené <strong>všetky</strong> tieto vstupné podmienky:</p>

<ul>
  <li>vek <strong>≥ 18</strong> rokov;</li>
  <li><strong>refrakterná obezita</strong> definovaná ako BMI <strong>≥ 35 kg/m²</strong> napriek dodržiavaniu a znášanlivosti liečby <strong>najvyššou dostupnou dávkou</strong> schválenej terapie chronického manažmentu hmotnosti;</li>
  <li><strong>dve alebo viac</strong> závažných alebo život ohrozujúcich komplikácií obezity, pre ktoré pacient <strong>aktuálne dostáva štandardnú starostlivosť</strong>;</li>
  <li><strong>nemožnosť</strong> účasti v prebiehajúcom klinickom skúšaní retatrutidu alebo porovnateľného skúšaného lieku (vstupné kritériá alebo chýbajúce primerane dostupné centrum);</li>
  <li>s pacientom boli v rámci spoločného rozhodovania prebraté <strong>všetky štandardné možnosti</strong> vrátane <strong>bariatrickej chirurgie</strong>.</li>
</ul>

<p>Vylučovacím kritériom je medicínska kontraindikácia retatrutidu. Žiadosť podáva <strong>ošetrujúci lekár</strong>, nie pacient priamo výrobcovi. Lilly vo verejnej odpovedi pre zdravotníkov uvádza, že dostupnosť závisí od <strong>geografie, zásob lieku a individuálneho posúdenia</strong>; žiadosti hodnotí prípad od prípadu. Liek v tomto programe poskytuje <strong>bezodplatne</strong>. Po prípadnom schválení FDA a komerčnej dostupnosti sa expanded access ukončí.</p>

<p>Tieto body sú <strong>vstupné sitá výrobcu</strong>. Ani ich splnenie negarantuje dodávku. Až po súhlase výrobcu (LOA / ochota dodať) nasledujú FDA a IRB.</p>

<h2>Tri brány: čo je proces a čo je hodnotenie</h2>

<p>Komentár Medscape zhŕňa cestu do <strong>troch brán</strong>: výrobca (LOA a dodávka), FDA (formulár 3926 alebo 1571) a IRB. Vo verejných dokumentoch FDA ide o <strong>samostatné rozhodnutia rôznych subjektov</strong>. Zamietnutie na ktorejkoľvek bráne cestu zastaví. FDA neuvádza, že by výrobcu mohla k dodávke prinútiť, ani jednotný zákonný odvolací mechanizmus proti firemnému „nie“. To je faktické nastavenie systému. Tvrdenie, že proces „nemá nikoho, kto by za celok zodpovedal“, a že „nič sa nedá odvolať“, je už <strong>hodnotenie autorky</strong> – nie veta z 21 CFR.</p>

<p>Časové oneskorenie rádovo v <strong>týždňoch až mesiacoch</strong> komentár uvádza ako praktický dôsledok postupnosti krokov. Zákonná 30-dňová lehota FDA je len jednou zložkou; k nej sa pripočítava firemné posúdenie, príprava podania, IRB a logistika dodávky. Lilly vo všeobecnej politike expanded access sľubuje odpoveď lekárovi do <strong>piatich pracovných dní</strong> od prijatia žiadosti – to je firemný záväzok na komunikáciu, nie lehota na doručenie lieku pacientovi.</p>

<h2>Názor komentára: prečo „lekár proti pacientovi“</h2>

<p>Messer opisuje situáciu, v ktorej pacient (a často aj rodina) vníma expanded access ako prísľub, kým lekár nesie <strong>administratívnu, regulačnú a etickú záťaž</strong> bez toho, aby mal v rukách jediného rozhodovateľa. Ak ktorákoľvek brána povie nie, vysvetlenie ostáva na klinickom lekárovi. To môže narušiť dôveru, aj keď lekár postupoval podľa pravidiel. Ide o <strong>komentár z praxe</strong>, nie o dôkaz, že retatrutid vzťah lekár – pacient poškodzuje farmakologicky. Kauzalitu lieku k tomuto napätiu článok <strong>nepripisuje</strong>.</p>

<p>Rovnako treba oddeliť túto cestu od čierneho trhu. Expanded access je pokus o <strong>regulovaný</strong> prístup k overiteľnému produktu. Nákup „retatrutidu“ z internetu je opak: bez identity látky, bez IND, bez IRB a bez farmakovigilancie. Tieto dve situácie sa v ambulancii môžu stretnúť u toho istého pacienta, ale medicínsky ani právne nie sú zameniteľné.</p>

<h2>Slovensko a EÚ: iný slovník, iné brány</h2>

<p>Medscape opisuje <strong>americký</strong> individuálny IND. Na Slovensku formulár FDA 3926, LOA voči FDA ani americké IRB <strong>neplatia</strong>. Zámena týchto pojmov by v ambulancii škodila.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Porovnanie amerického expanded access a slovenského terapeutického použitia neregistrovaného lieku" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Prvok</th>
        <th scope="col">USA (FDA expanded access)</th>
        <th scope="col">Slovensko / EÚ</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Názov cesty</th>
        <td>Expanded access (individuálny, stredne veľká populácia, treatment IND)</td>
        <td>Terapeutické použitie neregistrovaného lieku; v EÚ navyše <em>compassionate use</em> (skupinový program) a named-patient (individuálne)</td>
      </tr>
      <tr>
        <th scope="row">Kto povoľuje liečbu</th>
        <td>FDA (IND) + IRB; výrobca musí liek dobrovoľne dodať</td>
        <td>Ministerstvo zdravotníctva SR (§ 46 ods. 4 zákona č. 362/2011 Z. z.); ŠÚKL môže vydať stanovisko, pri nesúhlase MZ liečbu nepovolí</td>
      </tr>
      <tr>
        <th scope="row">Typický formulár</th>
        <td>FDA 3926 (alebo 1571) + LOA výrobcu</td>
        <td>Žiadosť poskytovateľa zdravotnej starostlivosti; nie americký IND</td>
      </tr>
      <tr>
        <th scope="row">Súhlas pacienta</th>
        <td>Informovaný súhlas podľa 21 CFR časť 50, schválený IRB</td>
        <td>Predchádzajúci písomný súhlas; je súčasťou zdravotnej dokumentácie</td>
      </tr>
      <tr>
        <th scope="row">Podmienka „nie je iná liečba“</th>
        <td>Kritériá 21 CFR 312.305; pri retatrutide navyše úzke sitá výrobcu (BMI ≥ 35 kg/m², dve závažné komplikácie, zlyhanie max. dávky schválenej liečby)</td>
        <td>§ 46 ods. 4: povoliť možno, ak nie je dostupný porovnateľný registrovaný humánny liek</td>
      </tr>
      <tr>
        <th scope="row">Skupinový program</th>
        <td>Intermediate-size / treatment IND alebo kohortový program výrobcu</td>
        <td>§ 46a liečebný program; v EÚ skupinový compassionate use podľa čl. 83 nariadenia (ES) č. 726/2004 – pravidlá určuje členský štát, EMA len odporúča</td>
      </tr>
    </tbody>
  </table>
</div>

<p>EMA výslovne odlišuje <strong>compassionate use</strong> (program pre skupinu pacientov, ktorý členské štáty zavádzajú samy; CHMP môže vydať odporúčanie) od liečby na <strong>named-patient</strong> báze, pri ktorej lekár získava liek priamo od výrobcu pre konkrétneho pacienta a agentúru o tom informovať nemusí. Ani jedna z týchto ciest nie je kópiou formulára FDA 3926.</p>

<p>Na Slovensku je ťažiskom <strong>§ 46 ods. 3 a 4</strong> zákona o liekoch: terapeutické alebo diagnostické použitie pre jedného pacienta alebo skupinu pri ohrození života alebo riziku závažného zhoršenia stavu. Pri skúšanom lieku ide typicky o písmená týkajúce sa neregistrovaného alebo skúšaného humánneho lieku, nie o „off-label“ už registrovaného prípravku. Povoľuje <strong>MZ SR</strong> na žiadosť poskytovateľa, ktorý liečbu indikuje, ak nie je dostupný porovnateľný registrovaný liek. ŠÚKL vo verejných pokynoch rieši najmä <strong>hlásenie dovozu</strong> neregistrovaných liekov po povolení MZ, nie vydávanie amerického IND. Výrobca musí liek aj tak <strong>chcieť dodať</strong>; geografické obmedzenie, ktoré Lilly uvádza pri retatrutide, preto ostáva praktickou bránou aj mimo USA.</p>

<p>Kritérium „nie je porovnateľný registrovaný liek“ je v EÚ/SR prísne v inom zmysle než americké sitá NCT07629401. V SR sú na obezitu a diabetes 2. typu dostupné schválené inkretínové lieky. Ani ťažká, na schválenú liečbu refrakterná obezita <strong>automaticky</strong> nezakladá nárok na retatrutid cez § 46. Tvrdosť tejto vety je zámer: falošná nádej škodí rovnako ako mlčanie o existencii cesty.</p>

<h2>Prečo to v nefrológii nie je okrajová téma</h2>

<p>Pacient s obezitou, diabetom 2. typu, hypertenziou a CKD – teda s kardiorenálno-metabolickým (CKM) syndrómom – je práve ten, kto môže mať zo zníženia hmotnosti a zlepšenia metabolického profilu najviac. Zároveň je to pacient, ktorého obezitologické a diabetologické skúšania <strong>často vylučujú</strong> pre eGFR, proteinúriu, dialýzu alebo komplexnú komedikáciu. Ak sa do skúšania nedostane, expanded access môže byť <em>jedinou regulovanou</em> cestou k skúšanému retatrutidu. Môže byť aj cestou, ktorá sa na tretej bráne zastaví.</p>

<p>Kým proces beží, liečba je <strong>štandardná starostlivosť</strong>: schválené antiobezitiká a antidiabetiká v indikácii a dávke, inhibítory SGLT2 a blokáda RAAS podľa KDIGO, kontrola tlaku, objemu a výživy, prípadne bariatrická chirurgia tam, kde je indikovaná a dostupná. Čakanie mesiacov nie je „prázdne miesto“, v ktorom treba vymyslieť dávku neschváleného lieku. <strong>Schválené dávkovanie retatrutidu pre CKD neexistuje</strong> – a tento text ho nevymýšľa. Údaje o obličkových výsledkoch sa v programe výrobcu ešte len zbierajú; kým nie sú publikované primárne cieľové ukazovatele, nefrológ z nich nemá vyvodzovať indikačný záver.</p>

<p>Ak by sa regulovaný prístup predsa len otvoril, platia rovnaké klinické obavy ako pri iných silných inkretínových liekoch: nauzea, vracanie a znížený príjem tekutín môžu u pacienta s CKD spustiť hypovolémiu a akútne poškodenie obličiek, najmä pri diuretikách a RAAS blokáde. To je riziko triedy a klinickej situácie, nie dôkaz, že retatrutid obličky poškodzuje. Monitorovanie a pauza pri akútnom ochorení ostávajú súčasťou štandardnej starostlivosti, nie experimentálnym protokolom z tohto článku.</p>

<h2>Čo z toho plynie pre prax</h2>

<ul>
  <li>Ak pacient žiada „retatrutid teraz“, najprv rozlíšte <strong>skúšanie</strong>, <strong>expanded access / terapeutické použitie</strong> a <strong>neregulovaný produkt</strong>. Sú to tri rôzne svety.</li>
  <li>V USA je expanded access k retatrutidu úzka, verejne opísaná cesta (NCT07629401) s troma bránami. Lekár je žiadateľ, nie výdajňa.</li>
  <li>Na Slovensku hľadajte analogickú, nie identickú cestu: klinické skúšanie, prípadne § 46 / § 46a, vždy s ochotou výrobcu dodať liek. Neexistuje slovenský „formulár 3926“ na retatrutid.</li>
  <li>Kým liek nie je schválený, jedinou správnou liečbou ostáva <strong>dostupná schválená terapia</strong> a znižovanie rizika. Falošný pocit, že „už len čakáme na zásielku“, nesmie odsunúť titráciu toho, čo pacient môže dostať dnes.</li>
  <li>Názor, že proces stavia lekára proti pacientovi, berte ako varovanie pred komunikáciou: sľubujte postup a časový rámec, nie výsledok tretej brány.</li>
</ul>

<p>Retatrutid môže po dokončení vývoja a posúdení regulátorov rozšíriť možnosti liečby obezity. Kým sa tak stane, expanded access nie je skratka schválenia. Je to úzka, dobrovoľná a viacbránová výnimka – v USA opísaná inak ako v EÚ a na Slovensku. Pre nefrológa je užitočné vedieť, <em>že</em> existuje, <em>kde</em> sa končí a <em>čím</em> medzitým pacienta liečiť.</p>

<hr>

<p><em><strong>Zdroj:</strong> Messer C. Retatrutide: Pitting Physician Against Patient. <em>Medscape Gastroenterology</em>. 19. augusta 2026. <a href="https://www.medscape.com/viewarticle/retatrutide-pitting-physician-against-patient-2026a1000s68" target="_blank" rel="noopener noreferrer">medscape.com</a>.</em></p>

<p><em><strong>Ďalšie zdroje:</strong> U.S. Food and Drug Administration. Expanded Access. <a href="https://www.fda.gov/news-events/public-health-focus/expanded-access" target="_blank" rel="noopener noreferrer">fda.gov</a>; FDA. For Physicians: A Guide to Non-emergency Single Patient Expanded Access Submissions. <a href="https://www.fda.gov/drugs/investigational-new-drug-ind-application/physicians-guide-non-emergency-single-patient-expanded-access-submissions" target="_blank" rel="noopener noreferrer">fda.gov</a>; ClinicalTrials.gov. NCT07629401 – Pre-approval Expanded Access of Retatrutide (LY3437943). <a href="https://clinicaltrials.gov/study/NCT07629401" target="_blank" rel="noopener noreferrer">clinicaltrials.gov</a>; Eli Lilly and Company. Is there an expanded access program for retatrutide? <a href="https://medical.lilly.com/us/products/answers/is-there-an-expanded-access-program-for-retatrutide-416668" target="_blank" rel="noopener noreferrer">medical.lilly.com</a>; Európska lieková agentúra. Compassionate use. <a href="https://www.ema.europa.eu/en/human-regulatory-overview/research-development/compassionate-use" target="_blank" rel="noopener noreferrer">ema.europa.eu</a>; Zákon č. 362/2011 Z. z. o liekoch a zdravotníckych pomôckach, § 46 a § 46a. <a href="https://www.zakonypreludi.sk/zz/2011-362" target="_blank" rel="noopener noreferrer">zakonypreludi.sk</a>; ŠÚKL. Hlásenie dovozu neregistrovaných liekov na základe povolenia MZ SR. <a href="https://www.sukl.sk/pre-odbornikov-a-firmy/dostupnost-a-kvalita-liekov/hlasenia-dovozu-a-spotreby/hlasenie-dovozu-neregistrovanych-liekov-na-zaklade-povolenia-mz-sr" target="_blank" rel="noopener noreferrer">sukl.sk</a>; Jastreboff AM, et al. Triple-Hormone-Receptor Agonist Retatrutide for Obesity – A Phase 2 Trial. <em>N Engl J Med</em>. 2023;389(6):514–526. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/37366315/" target="_blank" rel="noopener noreferrer">37366315</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_retatrutid-expanded-access-lekar-pacient-bariery_article',
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
