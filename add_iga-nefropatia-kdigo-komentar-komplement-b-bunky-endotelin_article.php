<?php
/**
 * add_iga-nefropatia-kdigo-komentar-komplement-b-bunky-endotelin_article.php
 * Idempotentny publikacny skript odborneho clanku.
 * Spracovanie: Rovin et al., KDIGO commentary (Kidney International, 2026)
 * + styri registracne studie faz 3 (ALIGN, APPLAUSE-IgAN, VISIONARY, ORIGIN 3).
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
    'title'        => 'Komplement, B bunky a endotelínový systém pri IgA nefropatii: kam nové terapie zapadajú podľa komentára KDIGO',
    'slug'         => 'iga-nefropatia-kdigo-komentar-komplement-b-bunky-endotelin',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Po vydaní odporúčania KDIGO pre IgA nefropatiu z roku 2025 pribudli tri urýchlené schválenia FDA. Pracovná skupina preto vydala krátky komentár, ktorý nové lieky zaraďuje podľa štvorzásahového modelu patogenézy – a zároveň varuje pred zoraďovaním liekov podľa poklesu proteinúrie bez priameho porovnania.',
    'content'      => <<<'HTML'
<p>IgA nefropatia sa v priebehu niekoľkých rokov zmenila z ochorenia s obmedzenými liečebnými možnosťami na oblasť s viacerými mechanisticky odlišnými cieľmi liečby. Tempo registrácií pritom predbehlo tvorbu odporúčaní: organizácia KDIGO aktualizovala odporúčanie pre glomerulové ochorenia v roku 2021 a špecializované odporúčanie pre IgA nefropatiu a IgA vaskulitídu v roku 2025 – a <strong>po odovzdaní revízie do tlače získali ďalšie tri lieky urýchlené schválenie americkej FDA</strong>.</p>

<p>Pracovná skupina KDIGO preto namiesto plnej aktualizácie vydala <strong>krátky komentár</strong>, ktorý vysvetľuje, kam nové terapie v celkovej stratégii patria, kým nepribudnú ďalšie dôkazy. Dôvod je konkrétny: predpokladané mechanizmy účinku <strong>dvoch z týchto troch liekov</strong> sa podstatne líšia od mechanizmov predtým schválených molekúl, a bez jasného zaradenia by sa odporúčania v praxi používali nejednotne.</p>

<h2>Mechanistický rámec: štvorzásahový model</h2>

<p>Komentár zaraďuje lieky podľa toho, ktorý zásah („hit“) v patogenéze pravdepodobne primárne ovplyvňujú:</p>

<ul>
  <li><strong>Zásahy 1 až 3</strong> – vznik cirkulujúcej patogénnej IgA (predovšetkým galaktózo-deficitnej IgA1, Gd-IgA1), tvorba imunitných komplexov obsahujúcich IgA a ich ukladanie v mezangiu.</li>
  <li><strong>Zásah 4</strong> – zápalové a komplementom sprostredkované poškodenie obličky ako reakcia na tieto depozity.</li>
</ul>

<p>Dve upozornenia z komentára sú pri čítaní schémy zásadné. Po prvé, priradenie lieku k cieľu vychádza z <strong>dominantného predpokladaného účinku</strong> – všetky molekuly môžu mať aj sekundárne pôsobenia. Po druhé, <strong>poradie v zozname nevyjadruje liečebnú hierarchiu</strong> a pre kombinovanie viacerých nových terapií zatiaľ chýbajú údaje.</p>

<h2>Endotelínový systém: atrasentan vedľa sparsentanu</h2>

<p><strong>Atrasentan</strong> je selektívny antagonista endotelínového receptora typu A. Urýchlené schválenie získal pre dospelých s primárnou IgA nefropatiou s rizikom rýchlej progresie, pričom sa ako kritérium používal <strong>pomer bielkovina/kreatinín v moči (uPCR) najmenej 1,5 g/g</strong>.</p>

<h3>ALIGN (fáza 3)</h3>

<p>Do hlavného stratifikačného ramena bolo zaradených 340 pacientov; prespecifikovaná interim analýza hodnotila prvých 270 z nich (135 v každej skupine) v <strong>36. týždni</strong>. Geometrický priemer percentuálnej zmeny uPCR oproti východiskovej hodnote bol:</p>

<ul>
  <li>pri atrasentane <strong>−38,1 %</strong>,</li>
  <li>pri placebe <strong>−3,1 %</strong>,</li>
  <li>rozdiel medzi skupinami <strong>−36,1 percentuálneho bodu</strong> (95 % interval spoľahlivosti [IS] −44,6 až −26,4; <em>P</em> &lt; 0,001).</li>
</ul>

<p>Liečba prebiehala na pozadí inhibície systému renín–angiotenzín. Na rozdiel od sparsentanu, ktorý blokuje aj receptor AT1 pre angiotenzín II, atrasentan cieli výlučne receptor ET-A.</p>

<p>Podiel pacientov s nežiaducimi udalosťami sa medzi skupinami podstatne nelíšil. <strong>Retencia tekutín</strong> bola hlásená u 19 zo 169 pacientov (11,2 %) pri atrasentane a u 14 zo 170 (8,2 %) pri placebe, <strong>nevviedla však k prerušeniu liečby</strong> a nevyskytli sa zjavné prípady srdcového zlyhávania ani ťažkých edémov. Štúdia pokračuje s cieľom overiť, či atrasentan spomalí pokles eGFR nad rámec samotnej inhibície systému renín–angiotenzín. KDIGO ho preto umiestňuje do stratégie na podobnú pozíciu ako sparsentan.</p>

<h2>Komplement: iptakopan a alternatívna dráha</h2>

<p>Významná časť dôkazov podporuje úlohu komplementu pri IgA nefropatii, predovšetkým <strong>alternatívnej dráhy</strong>. Okrem akútneho zápalového poškodenia sa komplement môže podieľať aj na chronickej progresii prostredníctvom profibrotických mechanizmov v tubulointersticiu.</p>

<h3>APPLAUSE-IgAN (fáza 3)</h3>

<p><strong>Iptakopan</strong> je perorálny inhibítor faktora B, ktorý blokuje alternatívnu dráhu. Do hlavnej populácie bolo zaradených 443 pacientov; interim analýza hodnotila prvých 250 (125 v každej skupine). Primárnym ukazovateľom bola zmena uPCR za 24 hodín v <strong>9. mesiaci</strong> – nie v 36. týždni, ako sa niekedy nesprávne uvádza.</p>

<p>V 9. mesiaci bol upravený geometrický priemer uPCR pri iptakopane <strong>o 38,3 % nižší</strong> než pri placebe (95 % IS 26,0 až 48,6; obojstranné <em>P</em> &lt; 0,001). Výsledok bol podporený konzistentnými sekundárnymi analýzami.</p>

<h3>Bezpečnosť: rozlíšiť nález zo štúdie a upozornenie v informácii o lieku</h3>

<p>Tu je potrebné byť presný, pretože sa tieto dve veci často zamieňajú:</p>

<ul>
  <li><strong>V samotnej štúdii</strong> sa nezistili neočakávané bezpečnostné nálezy, výskyt nežiaducich udalostí bol v oboch skupinách podobný, väčšina bola mierna až stredne ťažká a reverzibilná, a <strong>nepozorovalo sa zvýšené riziko infekcií</strong>.</li>
  <li><strong>Z mechanizmu účinku</strong> vyplýva zvýšená náchylnosť na infekcie opuzdrenými baktériami, ktorá je predmetom upozornenia v informácii o lieku. Preto sa pred začatím liečby vyžaduje <strong>očkovanie proti opuzdreným patogénom, prípadne antibiotická profylaxia</strong>.</li>
</ul>

<p>Inými slovami: požiadavka na očkovanie nevyplýva z toho, že by sa v štúdii vyskytol nadbytok infekcií, ale z opatrnosti pri blokáde alternatívnej dráhy komplementu. Táto povinnosť je v praxi záväzná bez ohľadu na výsledky štúdie.</p>

<p>Komentár tiež uvádza, že nedávno boli doplnené údaje o trajektórii eGFR z ukončenej fázy 3 štúdie APPLAUSE-IgAN, ktoré ukazujú zmysluplné spomalenie ročného poklesu eGFR oproti placebu.</p>

<h2>Dráhy APRIL a BAFF: sibeprenlimab a atacicept</h2>

<p>Cytokíny <strong>APRIL</strong> (a proliferation-inducing ligand) a <strong>BAFF</strong> (B cell activating factor) sú biologicky relevantné pre tvorbu patogénnych foriem IgA. Rozdiel medzi nimi je klinicky podstatný: APRIL ovplyvňuje tvorbu IgA selektívnejšie, zatiaľ čo BAFF pôsobí širšie na prežívanie a dozrievanie B buniek, a tým aj na celkovú tvorbu imunoglobulínov.</p>

<h3>Sibeprenlimab – VISIONARY (fáza 3)</h3>

<p><strong>Sibeprenlimab</strong> je humanizovaná monoklonová protilátka IgG2, ktorá selektívne viaže a inhibuje APRIL. Urýchlené schválenie získal pre dospelých s primárnou IgA nefropatiou s rizikom progresie, <strong>bez kritéria uPCR</strong>.</p>

<p>Randomizovaných bolo 510 pacientov (259 sibeprenlimab, 251 placebo); prespecifikovaná interim analýza zahrnula prvých 320 (152 a 168). Primárnym ukazovateľom bola zmena uPCR za 24 hodín v <strong>9. mesiaci</strong>:</p>

<ul>
  <li>sibeprenlimab <strong>−50,2 %</strong>,</li>
  <li>placebo <strong>+2,1 %</strong> (teda nárast),</li>
  <li>upravený geometrický priemer uPCR bol pri sibeprenlimabe <strong>o 51,2 % nižší</strong> než pri placebe (96,5 % IS 42,9 až 58,2; <em>P</em> &lt; 0,001).</li>
</ul>

<p>Farmakodynamicky boli v 48. týždni hladiny <strong>APRIL znížené o 95,8 %</strong> a hladiny patogénnej <strong>Gd-IgA1 o 67,1 %</strong> oproti východisku. Bezpečnostný profil sa javil podobný ako pri placebe: nebolo hlásené žiadne úmrtie a výskyt závažných nežiaducich udalostí počas liečby bol <strong>3,5 % pri sibeprenlimabe oproti 4,4 % pri placebe</strong>. Kľúčovým sekundárnym ukazovateľom, ktorý sa bude referovať po ukončení štúdie, je ročný sklon eGFR za 24 mesiacov.</p>

<h3>Atacicept – ORIGIN 3 (fáza 3)</h3>

<p><strong>Atacicept</strong> je fúzny proteín TACI-Fc, ktorý inhibuje <strong>APRIL aj BAFF</strong>. V štúdii sa podával subkutánne v dávke 150 mg raz týždenne, pacientmi doma.</p>

<p>Prespecifikovaná interim analýza zahrnula 203 pacientov (106 atacicept, 97 placebo). Primárnym ukazovateľom bola percentuálna zmena uPCR za 24 hodín v <strong>36. týždni</strong>:</p>

<ul>
  <li>atacicept <strong>−45,7 %</strong>,</li>
  <li>placebo <strong>−6,8 %</strong>,</li>
  <li>rozdiel medzi skupinami <strong>41,8 percentuálneho bodu</strong> (95 % IS 28,9 až 52,3; <em>P</em> &lt; 0,001).</li>
</ul>

<p>Nežiaduce udalosti sa vyskytli u 59,3 % pacientov v skupine s ataciceptom a u 50,0 % v placebovej skupine; väčšina bola mierna alebo stredne ťažká. Štúdia pokračuje v hodnotení eGFR.</p>

<h2>Prehľad primárnych výsledkov</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie primárnych výsledkov registračných štúdií pri IgA nefropatii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Liek (štúdia)</th>
      <th scope="col">Cieľ</th>
      <th scope="col">Časový bod</th>
      <th scope="col">Rozdiel oproti placebu</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Atrasentan (ALIGN)</th>
      <td>Receptor ET-A</td>
      <td>36. týždeň</td>
      <td>−36,1 p. b. (−44,6 až −26,4)</td>
    </tr>
    <tr>
      <th scope="row">Iptakopan (APPLAUSE-IgAN)</th>
      <td>Faktor B, alternatívna dráha</td>
      <td>9. mesiac</td>
      <td>o 38,3 % nižší uPCR (26,0 až 48,6)</td>
    </tr>
    <tr>
      <th scope="row">Sibeprenlimab (VISIONARY)</th>
      <td>APRIL</td>
      <td>9. mesiac</td>
      <td>o 51,2 % nižší uPCR (42,9 až 58,2)</td>
    </tr>
    <tr>
      <th scope="row">Atacicept (ORIGIN 3)</th>
      <td>APRIL a BAFF</td>
      <td>36. týždeň</td>
      <td>41,8 p. b. (28,9 až 52,3)</td>
    </tr>
  </tbody>
</table>
</div>

<p><strong>Túto tabuľku nemožno čítať ako rebríček účinnosti.</strong> Štúdie sa líšia časovým bodom, vstupnými kritériami, populáciou aj spôsobom vyjadrenia efektu – rozdiel v percentuálnych bodoch a pomer geometrických priemerov nie sú zameniteľné veličiny. Tabuľka slúži na orientáciu v mechanizmoch, nie na porovnávanie čísel medzi riadkami.</p>

<h2>Ako voliť liečbu, keď chýba priame porovnanie</h2>

<p>Komentár formuluje problém jasne. Všetky schválené liečby znižujú proteinúriu a zmierňujú pokles eGFR významne viac než samotná inhibícia systému renín–angiotenzín. Bez priameho porovnania (head-to-head) však <strong>nie je možné korektne zoradiť lieky</strong> podľa veľkosti poklesu uPCR ani podľa zachovania eGFR.</p>

<p>KDIGO preto výslovne upozorňuje, že tabuľkové porovnanie nesmie viesť k záverom o poradí účinnosti a bezpečnosti. Namiesto toho ponúka logiku podľa štvorzásahového modelu: mechanizmus účinku lieku priradiť k tomu zásahu, ktorý chceme u daného pacienta ovplyvniť. Do rozhodovania vstupujú aj praktické faktory – dostupnosť lieku a náklady.</p>

<p>V praxi to znamená individualizovať voľbu podľa rizika progresie, výšky proteinúrie, funkcie obličiek, znášanlivosti podpornej liečby, pridružených ochorení a bezpečnostného profilu konkrétnej molekuly. <strong>Kombinovanie nových liekov KDIGO zatiaľ nepodporuje</strong> – chýbajú údaje o účinnosti kombinácií, o bezpečnosti dlhodobej duálnej alebo trojitej blokády aj o najvhodnejšom poradí podávania.</p>

<p>Osobitne stojí za pripomenutie, že <strong>zníženie proteinúrie nie je cieľom liečby, ale jej náhradným ukazovateľom</strong>. Skutočné ciele zostávajú spomalenie poklesu eGFR, zníženie rizika zlyhania obličiek, zachovanie kvality života a čo najnižšia toxicita liečby.</p>

<h2>Čo komentár nerieši</h2>

<p>Ide o <strong>dočasné preklenutie</strong> do plnej aktualizácie odporúčania, nie o komplexný návod. Komentár sa nezaoberá viacerými otázkami, ktoré v praxi rozhodujú:</p>

<ul>
  <li>prognostický význam nízkych hladín proteinúrie,</li>
  <li>dôsledky hematúrie,</li>
  <li>udržiavaciu liečbu,</li>
  <li>kombinovanie liekov,</li>
  <li>dĺžku liečby,</li>
  <li>prechod medzi jednotlivými terapiami.</li>
</ul>

<p>K tomu treba pripočítať zásadné metodické obmedzenie všetkých štyroch štúdií: <strong>ide o prespecifikované interim analýzy s proteinúriou ako náhradným ukazovateľom.</strong> Urýchlené schválenie je na takomto základe možné, definitívne potvrdenie prínosu však závisí od údajov o sklone eGFR, ktoré sa pri troch zo štyroch molekúl ešte len očakávajú.</p>

<h2>Praktický odkaz</h2>

<ol>
  <li>Pri IgA nefropatii dnes existuje viacero mechanisticky odlišných možností – voľba nemá vychádzať z najvyššieho percenta poklesu proteinúrie v tlačovej správe.</li>
  <li>Základom zostáva <strong>optimalizovaná podporná liečba</strong>; nové molekuly sa pridávajú na jej pozadí, nie namiesto nej.</li>
  <li>Pri iptakopane je <strong>očkovanie proti opuzdreným baktériám podmienkou</strong>, ktorú treba naplánovať pred začatím liečby.</li>
  <li>Pri atrasentane treba aktívne sledovať <strong>objemový stav</strong>, najmä pri súbežnej diuretickej liečbe alebo srdcovom zlyhávaní.</li>
  <li>Údaje o dlhodobom vplyve na eGFR sú pri väčšine nových molekúl <strong>ešte neúplné</strong>; podľa toho treba formulovať očakávania pacienta.</li>
</ol>

<h2>Záver</h2>

<p>Komentár KDIGO je praktickou odpoveďou na situáciu, keď registrácie predbehli odporúčania. Neurčuje poradie liekov a ani to nepredstiera – ponúka mechanistickú mapu, do ktorej možno nové terapie zaradiť, a explicitne varuje pred zoraďovaním molekúl podľa čísel z nezávislých štúdií. Pre klinickú prax je to zatiaľ najpoctivejšie možné stanovisko: viac možností, jasnejšie mechanizmy – a stále otvorená otázka, ktorá z nich je pre konkrétneho pacienta najlepšia.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">Algoritmus manažmentu IgA nefropatie podľa KDIGO 2025</a></li>
  <li><a href="article.php?slug=iga-nefropatia-uloha-april-v-stvorzasahovom-modeli-patogeneze">Úloha APRIL v štvorzásahovom modeli patogenézy IgA nefropatie</a></li>
  <li><a href="article.php?slug=iptakopan-iga-nefropatia-applause-igan-24-mesiacov">Iptakopan pri IgA nefropatii: 24-mesačné výsledky APPLAUSE-IgAN</a></li>
  <li><a href="article.php?slug=atacicept-trutakna-iga-nefropatia-fda-proteinuria">Atacicept pri IgA nefropatii a redukcia proteinúrie</a></li>
  <li><a href="article.php?slug=cielenie-b-buniek-imunitne-podmienene-nefropatie-kdigo">Cielenie B buniek pri imunitne podmienených nefropatiách podľa KDIGO</a></li>
  <li><a href="article.php?slug=sparsentan-sglt2-inhibitor-iga-nefropatia-spartacus-protect">Sparsentan so SGLT2 inhibítorom pri IgA nefropatii</a></li>
</ul>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Rovin BH, Barratt J, Cook HT, Noronha IL, Reich HN, Suzuki Y, Tang SCW, Trimarchi H, Floege J. Complement inhibitors and B cell-modifying agents for IgA nephropathy – a Kidney Disease: Improving Global Outcomes (KDIGO) commentary. <em>Kidney International</em>. 2026;110(3):502–507. doi:10.1016/j.kint.2026.03.003. PMID 41895685. <a href="https://doi.org/10.1016/j.kint.2026.03.003" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41895685/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Registračné štúdie (primárne publikácie):</strong></em></p>

<ol>
  <li><small><em>Heerspink HJL, Jardine M, Kohan DE, Lafayette RA, Levin A, Liew A, Zhang H, Lodha A, Gray T, Wang Y, Renfurm R, Barratt J. Atrasentan in Patients with IgA Nephropathy. <em>New England Journal of Medicine</em>. 2025;392(6):544–554. doi:10.1056/NEJMoa2409415. PMID 39460694. <a href="https://doi.org/10.1056/NEJMoa2409415" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/39460694/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Perkovic V, Barratt J, Rovin B, Kashihara N, Maes B, Zhang H, Trimarchi H, a kol. Alternative Complement Pathway Inhibition with Iptacopan in IgA Nephropathy. <em>New England Journal of Medicine</em>. 2025;392(6):531–543. doi:10.1056/NEJMoa2410316. PMID 39453772. <a href="https://doi.org/10.1056/NEJMoa2410316" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/39453772/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Perkovic V, Trimarchi H, Tesar V, Lafayette R, Wong MG, Barratt J, Suzuki Y, a kol. Sibeprenlimab in IgA Nephropathy – Interim Analysis of a Phase 3 Trial. <em>New England Journal of Medicine</em>. 2026;394(7):635–646. PMID 41211929. <a href="https://pubmed.ncbi.nlm.nih.gov/41211929/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Lafayette R, Barbour SJ, Brenner RM, Campbell KN, Doan T, Eren N, Floege J, a kol. A Phase 3 Trial of Atacicept in Patients with IgA Nephropathy. <em>New England Journal of Medicine</em>. 2026;394(7):647–657. doi:10.1056/NEJMoa2510198. PMID 41196369. <a href="https://doi.org/10.1056/NEJMoa2510198" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41196369/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>KDIGO 2025 Clinical Practice Guideline for the Management of Immunoglobulin A Nephropathy (IgAN) and Immunoglobulin A Vasculitis (IgAV). <a href="https://kdigo.org/guidelines/gd/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></li>
</ol>

<p><small>Bibliografické údaje a všetky uvedené číselné výsledky boli overené v databáze PubMed 17. septembra 2026 podľa abstraktov primárnych publikácií. Uvedené výsledky pochádzajú z prespecifikovaných interim analýz s proteinúriou ako náhradným ukazovateľom. Text nenahrádza individuálne klinické rozhodnutie ani schválenú informáciu o lieku.</small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_iga_nefropatia_kdigo_komentar_nove_terapie',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
