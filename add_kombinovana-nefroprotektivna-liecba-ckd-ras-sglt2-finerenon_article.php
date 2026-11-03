<?php
/**
 * add_kombinovana-nefroprotektivna-liecba-ckd-ras-sglt2-finerenon_article.php
 * Idempotentný publikačný skript odborného článku.
 * Avíza sa pri publikovaní neposielajú ('enqueue_newsletter' => false);
 * rozosielanie riadi používateľ sám.
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
    'title'        => 'Kombinovaná nefroprotektívna liečba pri chronickej chorobe obličiek: ako vrstviť inhibítory RAS, inhibítory SGLT2 a finerenón',
    'slug'         => 'kombinovana-nefroprotektivna-liecba-ckd-ras-sglt2-finerenon',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Inhibítory RAS, inhibítory SGLT2 a finerenón sa pri CKD dopĺňajú, nie zamieňajú. Ako ich vrstviť podľa eGFR, albuminúrie a draslíka a čo k tomu pridávajú štúdie CONFIDENCE, FIND-CKD a metaanalýza SMART-C.',
    'content'      => <<<'HTML'
<figure><a href="img/kombinovana-nefroprotektivna-liecba-ckd-ras-sglt2-finerenon.webp" rel="noopener noreferrer" target="_blank"><img src="img/kombinovana-nefroprotektivna-liecba-ckd-ras-sglt2-finerenon.webp" alt="Polopriehľadná oblička na tmavom pozadí obklopená tromi vrstvami tyrkysových svetelných štítov" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna, nie snímka konkrétneho pacienta. Tri vrstvy ochrany symbolizujú inhibíciu RAS, inhibíciu SGLT2 a finerenón: dopĺňajú sa, no každá má vlastnú indikáciu a vlastné kontroly.</figcaption></figure>

<p>Liečba chronickej choroby obličiek (CKD) sa čoraz viac opiera o súbežné ovplyvnenie viacerých mechanizmov progresie. <strong>Inhibítory systému renín-angiotenzín (RAS), inhibítory kotransportéra sodíka a glukózy 2 (SGLT2) a finerenón</strong> znižujú obličkové aj kardiovaskulárne riziko, každý však inou cestou a za iných podmienok bezpečného použitia. Kombináciu preto treba prispôsobiť príčine CKD, albuminúrii, odhadovanej glomerulovej filtrácii (eGFR) a sérovému draslíku, nie jednej diagnóze.</p>

<p>Východiskom článku je vzdelávací program Medscape z roku 2026, ktorý kladie otázku, ako tieto tri skupiny liekov vrstviť pri diabetickej aj nediabetickej CKD. Odporúčania a čísla v texte sú overené priamo v usmernení KDIGO 2024, v európskej registrácii finerenónu a v primárnych publikáciách štúdií EMPA-KIDNEY, CONFIDENCE, FIND-CKD a metaanalýzy konzorcia SMART-C.</p>

<h2>Najdôležitejšie body</h2>

<ul>
  <li><strong>Inhibícia RAS</strong> (inhibítor ACE alebo sartan) zostáva základom liečby albuminurickej CKD. Podáva sa v najvyššej schválenej dávke, ktorú pacient znáša. Kombinácia inhibítora ACE so sartanom alebo s priamym inhibítorom renínu sa neodporúča.</li>
  <li><strong>Inhibítor SGLT2</strong> odporúča KDIGO 2024 pri diabete 2. typu a CKD s eGFR ≥ 20 ml/min/1,73 m², pri CKD s UACR ≥ 200 mg/g a pri srdcovom zlyhávaní bez ohľadu na albuminúriu, teda aj u pacientov bez diabetu.</li>
  <li><strong>Finerenón</strong> má výsledkové dôkazy pri CKD s diabetom 2. typu a pretrvávajúcou albuminúriou napriek inhibícii RAS. V Európskej únii je k 3. novembru 2026 schválený na liečbu CKD s albuminúriou spojenej s diabetom 2. typu a symptomatického srdcového zlyhávania s ejekčnou frakciou ľavej komory ≥ 40 %.</li>
  <li><strong>CONFIDENCE</strong> ukázala, že pri súčasnom začatí finerenónu a empagliflozínu klesla albuminúria po 180 dňoch výraznejšie než pri ktoromkoľvek lieku samostatne. Ide o náhradný ukazovateľ, nie o porovnanie so sekvenčným postupom.</li>
  <li><strong>FIND-CKD</strong> priniesla údaje zo štúdie 3. fázy, podľa ktorých finerenón spomaľuje pokles eGFR aj pri CKD bez diabetu. Táto indikácia však zatiaľ nie je schválená ani v EÚ, ani v USA.</li>
  <li>Pri každom kroku treba vopred určiť, kedy sa skontroluje krvný tlak, eGFR, draslík a UACR.</li>
</ul>

<h2>Liečba podľa rizika, nie podľa jednej diagnózy</h2>

<p>Chronická choroba obličiek je heterogénny stav. Pri výbere liečby treba zohľadniť jej príčinu, kategóriu eGFR (G1 až G5) a kategóriu albuminúrie (A1 až A3). Samotná hodnota kreatinínu ani prítomnosť diabetu 2. typu neposkytujú úplný obraz o riziku progresie. Preto je užitočné eGFR aj pomer albumínu ku kreatinínu v moči (UACR) opakovane vyšetrovať a podľa výsledkov liečbu upravovať.</p>

<p>Tri skupiny liekov sa dopĺňajú, ale nie sú zameniteľné. Inhibítory RAS znižujú intraglomerulový tlak a albuminúriu. Inhibítory SGLT2 chránia obličky a srdce aj u mnohých pacientov bez diabetu. Finerenón, nesteroidný antagonista mineralokortikoidového receptora (MRA), má preukázaný prínos pri CKD spojenej s diabetom 2. typu a novšie randomizované údaje rozširujú dôkazový základ aj na nediabetickú CKD.</p>

<p>Cieľom nie je predpísať každému pacientovi všetky tri lieky naraz. Podstatné je rozpoznať vhodných kandidátov, liečbu bezpečne zavádzať a sledovať jej účinok aj nežiaduce účinky.</p>

<div class="table-responsive" role="region" aria-label="Praktický prehľad troch vrstiev nefroprotektívnej liečby podľa KDIGO 2024" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Liečba</th>
      <th scope="col">Kedy ju KDIGO 2024 odporúča</th>
      <th scope="col">Začatie</th>
      <th scope="col">Kontroly a bezpečnosť</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Inhibítor ACE alebo sartan</th>
      <td>Albuminúria A2 alebo A3 pri diabete (1B); A3 bez diabetu (1B); A2 bez diabetu (2C)</td>
      <td>Titrovať na najvyššiu schválenú dávku, ktorú pacient znáša</td>
      <td>Krvný tlak, kreatinín a draslík do 2 až 4 týždňov; vzostup kreatinínu do 30 % nie je dôvodom na vysadenie; hyperkaliémiu najprv liečiť</td>
    </tr>
    <tr>
      <th scope="row">Inhibítor SGLT2</th>
      <td>Diabetes 2. typu a CKD pri eGFR ≥ 20 (1A); CKD pri eGFR ≥ 20 a UACR ≥ 200 mg/g alebo pri srdcovom zlyhávaní (1A); eGFR 20 až 45 a UACR &lt; 200 mg/g (2B)</td>
      <td>Pri eGFR ≥ 20; po začatí pokračovať aj pod touto hranicou</td>
      <td>Počiatočný pokles eGFR nie je dôvodom na ukončenie; posúdiť objemový stav a diuretiká; prechodne vysadiť pri dlhšom hladovaní, operácii alebo závažnom akútnom ochorení</td>
    </tr>
    <tr>
      <th scope="row">Finerenón</th>
      <td>Diabetes 2. typu, eGFR &gt; 25, normálny draslík a albuminúria &gt; 30 mg/g napriek maximálnej tolerovanej dávke inhibítora RAS (2A)</td>
      <td>Pri draslíku ≤ 4,8 mmol/l: 10 mg denne pri eGFR 25 až 59, 20 mg denne pri eGFR ≥ 60</td>
      <td>Draslík po mesiaci, potom každé 4 mesiace; pri draslíku &gt; 5,5 mmol/l liečbu prerušiť; overiť liekové interakcie, najmä so silnými inhibítormi CYP3A4</td>
    </tr>
  </tbody>
</table>
</div>

<p><small>eGFR je uvedená v ml/min/1,73 m². V zátvorke je sila odporúčania a kvalita dôkazov podľa KDIGO 2024.</small></p>

<h2>Inhibícia RAS zostáva základom pri albuminúrii</h2>

<p>Inhibítory angiotenzín konvertujúceho enzýmu (inhibítory ACE) a blokátory receptora pre angiotenzín II (sartany) sa pri CKD nasadzujú najmä pri zvýšenej albuminúrii. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">KDIGO 2024</a> ich odporúča pri ťažko zvýšenej albuminúrii (A3) bez diabetu a pri stredne až ťažko zvýšenej albuminúrii (A2 a A3) s diabetom; pri stredne zvýšenej albuminúrii (A2) bez diabetu ide o slabšie odporúčanie. Pri normálnej až mierne zvýšenej albuminúrii (A1) sa môžu použiť pre inú indikáciu, napríklad na liečbu hypertenzie alebo srdcového zlyhávania so zníženou ejekčnou frakciou.</p>

<p>Inhibítor RAS sa má podávať v najvyššej schválenej dávke, ktorú pacient znáša, pretože prínos sa v štúdiách preukázal práve pri takých dávkach. Akúkoľvek kombináciu inhibítora ACE, sartanu a priameho inhibítora renínu KDIGO odporúča nepoužívať (1B): zvyšuje riziko hyperkaliémie a akútneho poškodenia obličiek bez preukázaného obličkového prínosu.</p>

<p>Krvný tlak, sérový kreatinín a draslík sa majú skontrolovať do 2 až 4 týždňov od začatia liečby alebo zvýšenia dávky. Vzostup kreatinínu do 30 % v tomto období zvyčajne odráža očakávanú hemodynamickú zmenu a podľa KDIGO nie je dôvodom na ukončenie liečby. Pri väčšom vzostupe treba posúdiť objemový stav, súbežné lieky, napríklad nesteroidové antiflogistiká a diuretiká, a možnú stenózu renálnej artérie. Hyperkaliémiu spojenú s inhibíciou RAS treba podľa možností riešiť opatreniami na zníženie draslíka, nie automaticky znížením dávky alebo vysadením lieku. V liečbe sa pokračuje aj vtedy, keď eGFR klesne pod 30 ml/min/1,73 m².</p>

<h2>Inhibítory SGLT2: ochrana obličiek aj bez diabetu</h2>

<p>KDIGO 2024 odporúča inhibítor SGLT2 všetkým pacientom s diabetom 2. typu a CKD pri eGFR ≥ 20 ml/min/1,73 m² (1A). U dospelých s CKD bez ohľadu na diabetes ho odporúča pri eGFR ≥ 20 ml/min/1,73 m² a UACR ≥ 200 mg/g (≥ 20 mg/mmol), ako aj pri srdcovom zlyhávaní bez ohľadu na albuminúriu (1A). Pri eGFR 20 až 45 ml/min/1,73 m² a UACR pod 200 mg/g ide o slabšie odporúčanie (2B). Odporúčanie sa teda netýka iba diabetickej choroby obličiek.</p>

<p>Prínos u pacientov bez diabetu potvrdili veľké randomizované štúdie. V štúdii <a href="https://doi.org/10.1056/NEJMoa2204233" target="_blank" rel="noopener noreferrer">EMPA-KIDNEY</a> so 6 609 pacientmi, ktorí mali eGFR 20 až menej než 45 ml/min/1,73 m² alebo eGFR 45 až menej než 90 ml/min/1,73 m² s UACR ≥ 200 mg/g, znížil empagliflozín riziko progresie ochorenia obličiek alebo úmrtia z kardiovaskulárnych príčin o 28 % (HR 0,72; 95 % IS 0,64 až 0,82). Výsledky boli konzistentné u pacientov s diabetom aj bez neho.</p>

<p><a href="https://doi.org/10.1001/jama.2025.20834" target="_blank" rel="noopener noreferrer">Metaanalýza konzorcia SMART-C</a> z januára 2026 zhrnula 10 randomizovaných štúdií so 70 361 účastníkmi s diabetom 2. typu, CKD alebo srdcovým zlyhávaním. Inhibítory SGLT2 znížili riziko progresie CKD (HR 0,62; 95 % IS 0,57 až 0,68), a to bez ohľadu na východiskovú eGFR aj albuminúriu: pri eGFR pod 30 ml/min/1,73 m² bol HR 0,71 a pri UACR ≤ 30 mg/g 0,58. Ročný pokles eGFR spomalili vo všetkých podskupinách podľa eGFR a UACR, a to aj pri samostatnej analýze účastníkov s diabetom a bez neho.</p>

<p>Relatívny prínos je teda podobný v celom spektre funkcie obličiek. Absolútny prínos však závisí od východiskového rizika, ktoré je pri nízkej albuminúrii menšie. Pri CKD bez diabetu a bez srdcového zlyhávania, s UACR pod 200 mg/g a eGFR nad 45 ml/min/1,73 m², KDIGO 2024 inhibítor SGLT2 výslovne neodporúča; v takej situácii ide o individuálne rozhodnutie.</p>

<p>Po nasadení inhibítora SGLT2 sa často objaví počiatočný, prevažne reverzibilný pokles eGFR. Podľa KDIGO nie je dôvodom na ukončenie liečby a nevyžaduje častejšie kontroly CKD. Ak sa liečba začala, je rozumné pokračovať v nej aj pri poklese eGFR pod 20 ml/min/1,73 m², pokiaľ ju pacient znáša a nezačala sa náhrada funkcie obličiek. Pri nasadení treba posúdiť objemový stav, krvný tlak a dávku diuretík, pri súbežnej liečbe inzulínom alebo derivátom sulfonylurey aj riziko hypoglykémie. Pacient má vedieť, že pri dlhšom hladovaní, operácii alebo závažnom akútnom ochorení sa liek prechodne vysadzuje pre riziko ketózy; ketoacidóza je zriedkavá a týka sa najmä pacientov s diabetom. Patrí sem aj poučenie o genitálnych mykotických infekciách.</p>

<h2>Finerenón: pevné dôkazy pri diabete 2. typu, nové údaje bez diabetu</h2>

<p>Finerenón znížil výskyt obličkových aj kardiovaskulárnych príhod u pacientov s CKD a diabetom 2. typu v štúdiách 3. fázy <a href="https://doi.org/10.1056/NEJMoa2025845" target="_blank" rel="noopener noreferrer">FIDELIO-DKD</a> a <a href="https://doi.org/10.1056/NEJMoa2110956" target="_blank" rel="noopener noreferrer">FIGARO-DKD</a>. KDIGO 2024 ho navrhuje (2A) dospelým s diabetom 2. typu, eGFR &gt; 25 ml/min/1,73 m², normálnym sérovým draslíkom a albuminúriou &gt; 30 mg/g napriek maximálnej tolerovanej dávke inhibítora RAS. Nesteroidný MRA možno pridať k inhibítoru RAS aj k inhibítoru SGLT2.</p>

<p>Pri začatí rozhoduje draslík. Podľa schémy KDIGO sa finerenón začína pri draslíku ≤ 4,8 mmol/l dávkou 10 mg denne pri eGFR 25 až 59 ml/min/1,73 m² alebo 20 mg denne pri eGFR ≥ 60 ml/min/1,73 m². Draslík sa kontroluje po mesiaci a potom každé 4 mesiace; ak zostáva ≤ 4,8 mmol/l, dávka 10 mg sa zvyšuje na 20 mg. Pri hodnote nad 5,5 mmol/l sa liečba preruší a opätovne ju možno začať, keď draslík klesne na ≤ 5,0 mmol/l. Podľa <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/kerendia" target="_blank" rel="noopener noreferrer">európskych informácií o lieku</a> sa finerenón nezačína pri draslíku nad 5,0 mmol/l; pri hodnotách nad 4,8 až 5,0 mmol/l možno začatie zvážiť s dodatočnou kontrolou draslíka. Dávkovanie, liekové interakcie vrátane kontraindikácie súbežného podávania silných inhibítorov CYP3A4 a ostatné kontraindikácie treba overiť v aktuálnom súhrne charakteristických vlastností lieku.</p>

<h3>CONFIDENCE: súčasné začatie s empagliflozínom</h3>

<p>Randomizovaná štúdia <a href="https://doi.org/10.1056/NEJMoa2410659" target="_blank" rel="noopener noreferrer">CONFIDENCE</a> zaradila dospelých s diabetom 2. typu, eGFR 30 až 90 ml/min/1,73 m² a UACR 100 až 5 000 mg/g, ktorí už užívali inhibítor RAS. Porovnala súčasné začatie finerenónu a empagliflozínu s každým liekom podávaným samostatne. Po 180 dňoch klesol UACR pri kombinácii o 29 % viac než pri samotnom finerenóne a o 32 % viac než pri samotnom empagliflozíne (pomer zmien oproti východiskovej hodnote 0,71 a 0,68; v oboch prípadoch p &lt; 0,001). Symptomatická hypotenzia, akútne poškodenie obličiek a hyperkaliémia vedúca k ukončeniu liečby boli zriedkavé.</p>

<p>UACR je však náhradný ukazovateľ a 180 dní je krátke obdobie. Štúdia neporovnávala súčasné a postupné zavádzanie liečby a nebola navrhnutá na hodnotenie zlyhania obličiek ani úmrtnosti. Výsledky podporujú aditívny účinok kombinácie na albuminúriu a jej krátkodobú bezpečnosť, nie povinnosť začínať oba lieky naraz. <a href="https://doi.org/10.2337/dc26-S011" target="_blank" rel="noopener noreferrer">Štandardy ADA 2026</a> to vyjadrujú opatrne: súčasné začatie inhibítora SGLT2 a finerenónu „možno zvážiť“ u dospelých s diabetom 2. typu, UACR ≥ 100 mg/g, eGFR 30 až 90 ml/min/1,73 m² a liečbou inhibítorom RAS.</p>

<h3>FIND-CKD: finerenón pri CKD bez diabetu</h3>

<p><a href="https://doi.org/10.1056/NEJMoa2604625" target="_blank" rel="noopener noreferrer">FIND-CKD</a> bola dvojito zaslepená, placebom kontrolovaná štúdia 3. fázy s 1 584 dospelými bez diabetu, ktorí mali eGFR 25 až menej než 90 ml/min/1,73 m², UACR 200 až 3 500 mg/g a užívali inhibítor RAS. Finerenón spomalil priemerný ročný pokles eGFR počas 32 mesiacov: −3,3 oproti −4,0 ml/min/1,73 m² za rok, s rozdielom 0,7 ml/min/1,73 m² za rok (95 % IS 0,3 až 1,1). Hierarchicky testovaný zložený obličkovo-kardiovaskulárny ukazovateľ sa pri finerenóne vyskytoval zriedkavejšie (HR 0,77; 95 % IS 0,60 až 0,99). Intervaly spoľahlivosti pre samostatnú obličkovú zložku (HR 0,78) a kardiovaskulárnu zložku (HR 0,60) však zahŕňali nulový účinok. Hyperkaliémia sa vyskytla u 17,0 % oproti 13,3 % pacientov a k ukončeniu liečby viedla u 1,5 % oproti 0,1 %.</p>

<p>Inhibítor SGLT2 užívalo na začiatku štúdie len približne 17 % účastníkov. Veľkosť dodatočného prínosu finerenónu u pacienta, ktorý už užíva inhibítor RAS aj inhibítor SGLT2, preto nie je presne známa. Podľa tlačovej správy výrobcu zo 7. októbra 2026 prijal americký úrad FDA na posúdenie žiadosť o rozšírenie indikácie na CKD bez diabetu; k 3. novembru 2026 však táto indikácia nie je schválená v USA ani v EÚ. Výsledok jednej štúdie automaticky nemení schválené indikácie ani klinické odporúčania. Použitie mimo schválenú indikáciu vyžaduje individuálne zdôvodnenie a overenie aktuálneho regulačného aj úhradového stavu.</p>

<h3>Glomerulové ochorenia</h3>

<p>Prespecifikovaná exploračná <a href="https://doi.org/10.1001/jama.2026.9923" target="_blank" rel="noopener noreferrer">analýza štúdie FIND-CKD</a> sa zamerala na 903 účastníkov (57,0 %), u ktorých skúšajúci uviedol glomerulové ochorenie: IgA nefropatiu malo 46,1 %, fokálnu segmentovú glomerulosklerózu 23,8 % a membránovú nefropatiu 10,0 %. Rozdiel v ročnom poklese eGFR v prospech finerenónu bol 0,73 ml/min/1,73 m² za rok (95 % IS 0,22 až 1,24). Albuminúria sa po 12 mesiacoch znížila o 42 % (95 % IS 35 až 48 %) a riziko zlyhania obličiek alebo poklesu eGFR o 40 % a viac bolo nižšie (7,42 oproti 9,60 príhody na 100 pacientorokov; HR 0,74; 95 % IS 0,57 až 0,97).</p>

<p>Diagnózu uvádzal skúšajúci, nebola centrálne overená, a analýza je exploračná. Výsledky preto nie sú definitívnym dôkazom účinnosti pri každej jednotlivej glomerulopatii a nenahrádzajú liečbu zameranú na príčinu ochorenia, napríklad imunosupresívnu alebo cielenú liečbu pri IgA nefropatii.</p>

<div class="table-responsive" role="region" aria-label="Novšie dôkazy ku kombinovanej nefroprotektívnej liečbe a ich hranice" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Zdroj</th>
      <th scope="col">Populácia</th>
      <th scope="col">Hlavný výsledok</th>
      <th scope="col">Čo nedokazuje</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">SMART-C, 2026</th>
      <td>10 štúdií, 70 361 účastníkov s diabetom 2. typu, CKD alebo srdcovým zlyhávaním</td>
      <td>Inhibítory SGLT2: progresia CKD HR 0,62 bez ohľadu na eGFR a UACR</td>
      <td>Rovnaký absolútny prínos pri nízkom riziku; ide o súhrn existujúcich štúdií</td>
    </tr>
    <tr>
      <th scope="row">CONFIDENCE, 2025</th>
      <td>Diabetes 2. typu, eGFR 30 až 90, UACR 100 až 5 000 mg/g, inhibítor RAS</td>
      <td>Kombinácia: pokles UACR o 29 % väčší než pri finerenóne a o 32 % väčší než pri empagliflozíne po 180 dňoch</td>
      <td>Vplyv na zlyhanie obličiek a úmrtnosť; výhodu súčasného začatia oproti postupnému</td>
    </tr>
    <tr>
      <th scope="row">FIND-CKD, 2026</th>
      <td>1 584 dospelých bez diabetu, eGFR 25 až &lt; 90, UACR 200 až 3 500 mg/g, inhibítor RAS</td>
      <td>Pokles eGFR pomalší o 0,7 ml/min/1,73 m² za rok; zložený ukazovateľ HR 0,77</td>
      <td>Prínos pri súčasnej liečbe inhibítorom SGLT2 (užívalo ho asi 17 %); schválenú indikáciu</td>
    </tr>
    <tr>
      <th scope="row">FIND-CKD, glomerulové ochorenia, 2026</th>
      <td>903 účastníkov so skúšajúcim uvedenou glomerulopatiou</td>
      <td>UACR −42 % po 12 mesiacoch; zlyhanie obličiek alebo pokles eGFR o ≥ 40 % HR 0,74</td>
      <td>Účinnosť pri každej glomerulopatii; náhradu liečby zameranej na príčinu</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Štvrtý pilier pri diabete 2. typu</h2>

<p>Pri diabete 2. typu a CKD má výsledkové dôkazy aj agonista receptora GLP-1 semaglutid. V štúdii <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">FLOW</a> znížil riziko závažných obličkových príhod alebo úmrtia z obličkových či kardiovaskulárnych príčin o 24 % (HR 0,76; 95 % IS 0,66 až 0,88). Usmernenie KDIGO 2024, vydané pred zverejnením štúdie FLOW, odporúča dlhodobo pôsobiaceho agonistu receptora GLP-1 dospelým s diabetom 2. typu a CKD, ktorí napriek liečbe metformínom a inhibítorom SGLT2 nedosiahli individuálne glykemické ciele alebo tieto lieky nemôžu užívať (1B). Prednosť majú lieky s preukázaným kardiovaskulárnym prínosom.</p>

<h2>Praktické poradie a kombinácia</h2>

<p>U pacienta s albuminurickou CKD je rozumné najprv optimalizovať inhibíciu RAS, ak je indikovaná a tolerovaná, a u vhodných pacientov pridať inhibítor SGLT2. Pri CKD s diabetom 2. typu a pretrvávajúcou albuminúriou možno zvážiť aj finerenón, ak eGFR a draslík umožňujú bezpečné podanie. Poradie nemusí byť u každého pacienta rovnaké. Ovplyvňuje ho naliehavosť indikácie, krvný tlak, riziko objemovej deplécie, východisková eGFR, draslík aj to, či pacient zvládne plánované kontroly.</p>

<p>Pri každom kroku je vhodné vopred stanoviť, ktoré parametre a kedy sa skontrolujú. Po začatí alebo úprave liečby sa sledujú najmä krvný tlak, eGFR, sérový draslík a UACR. Pri finerenóne je monitorovanie draslíka zásadné; postup a intervaly majú vychádzať z platného súhrnu charakteristických vlastností lieku a klinického stavu pacienta. Treba preveriť aj ostatné lieky, ktoré môžu zvyšovať draslík alebo zhoršovať funkciu obličiek, napríklad nesteroidové antiflogistiká, draslík šetriace diuretiká či trimetoprim.</p>

<p>Kombinovaná liečba môže znížiť albuminúriu a riziko obličkových aj kardiovaskulárnych komplikácií, jej prínos však závisí od správnej indikácie a bezpečného monitorovania. Nejde o mechanické pridávanie liekov, ale o postupné zavádzanie liečby podľa rizikového profilu a odpovede pacienta.</p>

<h2>Limity</h2>

<ul>
  <li>Plné znenie vzdelávacieho programu Medscape, z ktorého článok tematicky vychádza, nebolo verejne dostupné. Všetky odborné tvrdenia a čísla preto pochádzajú z primárnych zdrojov uvedených nižšie.</li>
  <li>CONFIDENCE hodnotila náhradný ukazovateľ počas 180 dní a neporovnávala súčasné a postupné začatie liečby.</li>
  <li>Žiadna výsledková štúdia zatiaľ nehodnotila plnú kombináciu inhibítora RAS, inhibítora SGLT2 a finerenónu proti postupnému zavádzaniu.</li>
  <li>V štúdii FIND-CKD užívala inhibítor SGLT2 len menšina účastníkov a analýza glomerulových ochorení je exploračná, s diagnózami uvedenými skúšajúcimi.</li>
  <li>Regulačný stav a úhrada liekov sa menia; údaje o registrácii finerenónu sú overené k 3. novembru 2026.</li>
</ul>

<h2>Záver</h2>

<p>Inhibícia RAS, inhibítory SGLT2 a finerenón predstavujú komplementárne možnosti znižovania kardiorenálneho rizika pri CKD. Najpevnejšie dôkazy pre finerenón sa týkajú CKD s diabetom 2. typu. Výsledky z roku 2026 sú povzbudivé aj pri nediabetickom ochorení, ich uplatnenie však treba posudzovať podľa dizajnu štúdií a aktuálneho regulačného postavenia lieku. Kľúčom k bezpečnej liečbe zostáva výber podľa eGFR a albuminúrie, kontrola draslíka a funkcie obličiek a priebežné prehodnocovanie tolerancie.</p>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie, aktuálny súhrn charakteristických vlastností lieku ani podmienky úhrady.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li>Bazargan N. Medscape NOW! Drug Protection for the Kidney: Combining Drug Therapies for Chronic Kidney Disease. Vzdelávací program CME. Medscape Education; 2026. <a href="https://www.medscape.org/viewarticle/medscape-now-drug-protection-kidney-combining-drug-therapies-2026a10011tb" target="_blank" rel="noopener noreferrer">Medscape Education</a>.</li>
  <li>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney International</em>. 2024;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">doi:10.1016/j.kint.2023.10.018</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed 38490803</a>.</li>
  <li>EMPA-KIDNEY Collaborative Group; Herrington WG, Staplin N, Wanner C, Green JB, Hauske SJ, Emberson JR, Preiss D, Judge P, Mayne KJ, Ng SYA, Sammons E, Zhu D, Hill M, Stevens W, Wallendszus K, Brenner S, Cheung AK, Liu ZH, Li J, Hooi LS, Liu W, Kadowaki T, Nangaku M, Levin A, Cherney D, Maggioni AP, Pontremoli R, Deo R, Goto S, Rossello X, Tuttle KR, Steubl D, Petrini M, Massey D, Eilbracht J, Brueckmann M, Landray MJ, Baigent C, Haynes R. Empagliflozin in Patients with Chronic Kidney Disease. <em>New England Journal of Medicine</em>. 2023;388(2):117-127. <a href="https://doi.org/10.1056/NEJMoa2204233" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2204233</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/36331190/" target="_blank" rel="noopener noreferrer">PubMed 36331190</a>.</li>
  <li>Neuen BL, Fletcher RA, Anker SD, Bhatt DL, Butler J, Cherney DZI, Docherty KF, Inzucchi SE, Jardine MJ, Mahaffey KW, McCausland FR, McGuire DK, McMurray JJV, Neal B, Packer M, Patel SM, Perkovic V, Sabatine MS, Sardell RJ, Solomon SD, Vaduganathan M, Wanner C, Wheeler DC, Zannad F, Haynes R, Staplin N, Herrington WG, Heerspink HJL; SGLT2 Inhibitor Meta-Analysis Cardio-Renal Trialists' Consortium (SMART-C). SGLT2 Inhibitors and Kidney Outcomes by Glomerular Filtration Rate and Albuminuria: A Meta-Analysis. <em>JAMA</em>. 2026;335(3):233-244. <a href="https://doi.org/10.1001/jama.2025.20834" target="_blank" rel="noopener noreferrer">doi:10.1001/jama.2025.20834</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41203232/" target="_blank" rel="noopener noreferrer">PubMed 41203232</a>.</li>
  <li>Bakris GL, Agarwal R, Anker SD, Pitt B, Ruilope LM, Rossing P, Kolkhof P, Nowack C, Schloemer P, Joseph A, Filippatos G; FIDELIO-DKD Investigators. Effect of Finerenone on Chronic Kidney Disease Outcomes in Type 2 Diabetes. <em>New England Journal of Medicine</em>. 2020;383(23):2219-2229. <a href="https://doi.org/10.1056/NEJMoa2025845" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2025845</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/33264825/" target="_blank" rel="noopener noreferrer">PubMed 33264825</a>.</li>
  <li>Pitt B, Filippatos G, Agarwal R, Anker SD, Bakris GL, Rossing P, Joseph A, Kolkhof P, Nowack C, Schloemer P, Ruilope LM; FIGARO-DKD Investigators. Cardiovascular Events with Finerenone in Kidney Disease and Type 2 Diabetes. <em>New England Journal of Medicine</em>. 2021;385(24):2252-2263. <a href="https://doi.org/10.1056/NEJMoa2110956" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2110956</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/34449181/" target="_blank" rel="noopener noreferrer">PubMed 34449181</a>.</li>
  <li>Agarwal R, Green JB, Heerspink HJL, Mann JFE, McGill JB, Mottl AK, Rosenstock J, Rossing P, Vaduganathan M, Brinker M, Edfors R, Li N, Scheerer MF, Scott C, Nangaku M; CONFIDENCE Investigators. Finerenone with Empagliflozin in Chronic Kidney Disease and Type 2 Diabetes. <em>New England Journal of Medicine</em>. 2025;393(6):533-543. <a href="https://doi.org/10.1056/NEJMoa2410659" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2410659</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/40470996/" target="_blank" rel="noopener noreferrer">PubMed 40470996</a>.</li>
  <li>Heerspink HJL, Neuen BL, Agarwal R, Cherney DZI, Lam CSP, Tuttle KR, Wanner C, Sarafidis P, Jongs N, Smeijer JD, Brinker M, Rethemeier N, Schloemer P, Vesterinen P, Goldsbury D, Dizayee S, Mares JW, Perkovic V; FIND-CKD Investigators. Finerenone in Persons with Chronic Kidney Disease without Diabetes. <em>New England Journal of Medicine</em>. 2026;395(6):533-545. <a href="https://doi.org/10.1056/NEJMoa2604625" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2604625</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42246672/" target="_blank" rel="noopener noreferrer">PubMed 42246672</a>.</li>
  <li>Neuen BL, Perkovic V, Agarwal R, Cherney DZI, Lam CSP, Wanner C, Tuttle KR, Sarafidis P, Barratt J, Burgner A, Chen X, Chew-Wong A, Dobronravov VA, Floege J, McCafferty K, Nangaku M, Packham D, Papachristou E, Pergola PE, Speeckaert MM, Subbiah A, Tang SCW, Tang S, Yeo SC, Jongs N, Smeijer JD, Berger M, Brinker M, Dayoub R, Elliott J, Li N, Mueller K, Rethemeier N, Finkelsztein MY, Heerspink HJL; FIND-CKD Investigators. Finerenone in Patients With Chronic Kidney Disease Due to Glomerular Diseases: A Randomized Clinical Trial. <em>JAMA</em>. 2026;336(3):224-235. <a href="https://doi.org/10.1001/jama.2026.9923" target="_blank" rel="noopener noreferrer">doi:10.1001/jama.2026.9923</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42246414/" target="_blank" rel="noopener noreferrer">PubMed 42246414</a>.</li>
  <li>Perkovic V, Tuttle KR, Rossing P, Mahaffey KW, Mann JFE, Bakris G, Baeres FMM, Idorn T, Bosch-Traberg H, Lausvig NL, Pratley R; FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. <em>New England Journal of Medicine</em>. 2024;391(2):109-121. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2403347</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed 38785209</a>.</li>
  <li>American Diabetes Association Professional Practice Committee for Diabetes. 11. Chronic Kidney Disease and Risk Management: Standards of Care in Diabetes-2026. <em>Diabetes Care</em>. 2026;49(Suppl 1):S246-S260. <a href="https://doi.org/10.2337/dc26-S011" target="_blank" rel="noopener noreferrer">doi:10.2337/dc26-S011</a>.</li>
  <li>European Medicines Agency. Kerendia (finerenón): EPAR a informácie o lieku. Terapeutické indikácie overené 3. novembra 2026. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/kerendia" target="_blank" rel="noopener noreferrer">EMA</a>.</li>
  <li>Bayer. U.S. FDA Accepts Bayer's Supplemental New Drug Application for KERENDIA (finerenone) to Treat Adults with Chronic Kidney Disease (CKD) Without Diabetes. Tlačová správa, Business Wire, 7. októbra 2026. <a href="https://www.businesswire.com/news/home/20261007583229/en/" target="_blank" rel="noopener noreferrer">Business Wire</a>.</li>
</ol>

<p><small><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje, úplné autorské zoznamy a všetky číselné výsledky boli overené 3. novembra 2026 v PubMed zo štruktúrovaných abstraktov primárnych publikácií a v Crossref. Znenie odporúčaní a praktických bodov KDIGO 2024 (3.6, 3.7, 3.8 a 3.9) aj schéma monitorovania draslíka pri finerenóne boli overené v plnom texte usmernenia, indikácie finerenónu v EÚ v EPAR Európskej agentúry pre lieky a stav žiadosti v USA v tlačovej správe výrobcu. Plné znenie programu Medscape nebolo dostupné; z neho článok preberá tému, autorstvo programu bolo overené na jeho verejnej stránke. Oproti východiskovému textu boli doplnené úplné znenie odporúčaní KDIGO pre inhibítory SGLT2 a finerenón, výsledky štúdií v číslach, regulačný stav k dátumu publikovania, štúdia FLOW a súhrnná tabuľka dôkazov s ich hranicami.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=kombinacna-liecba-ckd-styri-piliere-hranice-dokazov">Kombinovaná liečba chronickej choroby obličiek: štyri piliere, dôkazy a otvorené otázky</a></li>
  <li><a href="article.php?slug=sekvencna-simultanna-kombinovana-liecba-diabetes-ckd">Sekvenčne, alebo naraz? Ako začať kombinovanú kardiorenálnu liečbu pri diabete 2. typu a chronickej chorobe obličiek</a></li>
  <li><a href="article.php?slug=finerenon-empagliflozin-confidence-albuminuria-krvny-tlak">Finerenón s empagliflozínom pri CKD a diabete 2. typu: vysvetľuje pokles albuminúrie krvný tlak?</a></li>
  <li><a href="article.php?slug=finerenon-hypertenzna-nefropatia-bez-diabetu-find-ckd">Finerenón pri hypertenznej nefropatii bez diabetu: čo prináša analýza FIND-CKD?</a></li>
  <li><a href="article.php?slug=finerenon-zakladna-liecba-ckd-glomerularne-ochorenia">Finerenón: potenciál ako základná liečba pri CKD aj bez diabetu a pri glomerulových ochoreniach</a></li>
  <li><a href="article.php?slug=hyperkaliemia-raasi-mra-viazace-draslika-sodik">Sodíková záťaž viazačov draslíka: nezamýšľaný dôsledok snahy udržať RAASi a MRA</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kombinovana_nefroprotektivna_liecba_ckd_article',
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
