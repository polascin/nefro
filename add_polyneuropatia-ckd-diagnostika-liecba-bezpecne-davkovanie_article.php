<?php
/**
 * Odborny clanok: polyneuropatia pri CKD, liecba, HTEMS a renalne davkovanie.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_polyneuropatia-ckd-diagnostika-liecba-bezpecne-davkovanie_article.php"
 */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vlozit alebo aktualizovat clanok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Polyneuropatia pri chronickej chorobe obličiek: diagnostika, liečba, HTEMS a bezpečné dávkovanie',
    'slug'         => 'polyneuropatia-ckd-diagnostika-liecba-bezpecne-davkovanie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Uremická neuropatia vyžaduje diferenciálnu diagnostiku, optimalizáciu nefrologickej liečby a opatrnú farmakoterapiu. HTEMS je sľubný intradialytický doplnok, jeho dôkazy a dostupnosť však zostávajú obmedzené.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Polyneuropatia u pacienta s chronickou chorobou obličiek nemusí byť automaticky uremická. Diagnostika musí zohľadniť diabetes, lieky, nutričné deficity, paraproteinémiu, zápalové neuropatie aj komplikácie cievneho prístupu. Liečba stojí na ovplyvnení príčiny, bezpečnom zvládnutí neuropatickej bolesti a rehabilitácii. Vysokotónová externá svalová stimulácia počas hemodialýzy priniesla v malých nekontrolovaných štúdiách zlepšenie symptómov, zatiaľ však nie je štandardnou liečbou.</em></p>

<h2>Čo je uremická neuropatia</h2>

<p>Uremická neuropatia je neurologická komplikácia pokročilej chronickej choroby obličiek, najmä zlyhania obličiek. Najčastejšie má podobu pomaly progredujúcej, dĺžkovo závislej, symetrickej senzitívno-motorickej axonálnej polyneuropatie. Postihnutie sa zvyčajne začína na chodidlách a predkoleniach a až neskôr sa šíri na horné končatiny.</p>

<p>V počiatočných štádiách sa objavujú parestézie, pálenie, bolesť, znížené vibračné a povrchové čitie a oslabenie Achillových reflexov. Pri progresii sa pridáva necitlivosť, porucha rovnováhy, neistá chôdza, slabosť a atrofia distálnych svalov. Možné sú aj autonómne prejavy, napríklad ortostatická hypotenzia, poruchy potenia, obstipácia, hnačka alebo sexuálna dysfunkcia.</p>

<p>Patofyziológia nie je vysvetlená jediným uremickým toxínom. Pravdepodobne sa uplatňuje kombinácia retinovaných látok, oxidačného stresu, metabolických porúch a zmenenej excitability axónov. Chronicky zvýšená koncentrácia draslíka môže prispievať k depolarizácii nervových vlákien, no z dostupných údajov nemožno vyvodiť, že samotná korekcia draslíka už vzniknutú neuropatiu vylieči.</p>

<h2>Nie každá neuropatia pri CKD je uremická</h2>

<p>Diabetes je u pacientov s CKD častý a diabetická a uremická neuropatia sa môžu prekrývať. Podobný klinický obraz môžu vyvolať alkohol, deficit vitamínu B12, paraproteinémia, amyloidóza, hypotyreóza, vaskulitída, infekcie, dedičné neuropatie, nádorové ochorenia a viaceré lieky. Medzi liekové príčiny patria napríklad niektoré cytostatiká, amiodarón, metronidazol, linezolid, kolchicín, izoniazid, nitrofurantoín a nadmerné dávky pyridoxínu.</p>

<p>Rýchla progresia, výrazná asymetria, prevaha motorického postihnutia, proximálna slabosť, výrazná dysautonómia alebo demyelinizačný obraz nie sú typické pre bežnú uremickú dĺžkovo závislú polyneuropatiu. Takýto priebeh vyžaduje skoré neurologické vyšetrenie. Náhla bolesť, slabosť a porucha čitia končatiny po vytvorení arteriovenózneho prístupu môžu signalizovať ischemickú monomelickú neuropatiu alebo inú cievnu komplikáciu a vyžadujú urgentné posúdenie.</p>

<h2>Diagnostika</h2>

<p>Najvyššiu diagnostickú presnosť prináša spojenie anamnézy, neurologického vyšetrenia a podľa potreby elektrodiagnostiky. Elektroneurografia a elektromyografia nie sú náhradou klinického hodnotenia, ale pomáhajú potvrdiť polyneuropatiu, rozlíšiť axonálny a demyelinizačný proces, určiť závažnosť a zachytiť fokálne lézie. Pri typickej stabilnej distálnej symetrickej neuropatii nemusia byť potrebné u každého pacienta; význam rastie pri atypickom priebehu, rýchlej progresii, motorickom deficite alebo diagnostickej neistote.</p>

<div class="table-responsive" role="region" aria-label="Diagnostické kroky pri polyneuropatii u pacienta s chronickou chorobou obličiek" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Krok</th>
      <th scope="col">Čo hodnotiť</th>
      <th scope="col">Praktický význam</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Anamnéza</th>
      <td>začiatok a tempo progresie, ponožkovito-rukavicová distribúcia, bolesť, porucha spánku, pády, autonómne príznaky, diabetes, alkohol, rodinná anamnéza a lieky</td>
      <td>určí pravdepodobný fenotyp a naliehavosť ďalšieho vyšetrenia</td>
    </tr>
    <tr>
      <th scope="row">Neurologické vyšetrenie</th>
      <td>povrchové, bolestivé a vibračné čitie, propriocepcia, reflexy, svalová sila, atrofia, chôdza a rovnováha</td>
      <td>odlíši senzitívne, motorické a autonómne postihnutie</td>
    </tr>
    <tr>
      <th scope="row">Základné laboratóriá</th>
      <td>krvný obraz, elektrolyty, hydrogénuhličitany, parametre funkcie obličiek a pečene, glykémia nalačno a HbA1c</td>
      <td>zachytia metabolické a systémové príčiny alebo zhoršujúce faktory</td>
    </tr>
    <tr>
      <th scope="row">Vyšetrenia s vysokým diagnostickým výťažkom</th>
      <td>vitamín B12, pri hraničnej hodnote aj kyselina metylmalónová; elektroforéza sérových bielkovín s imunofixáciou</td>
      <td>AAN ich spolu s vyšetrením glukózového metabolizmu uvádza medzi testami s najvyšším výťažkom pri distálnej symetrickej polyneuropatii</td>
    </tr>
    <tr>
      <th scope="row">Cielené laboratóriá</th>
      <td>TSH, folát, infekčné, autoimunitné, toxikologické alebo genetické vyšetrenia podľa klinického fenotypu</td>
      <td>nemajú sa objednávať mechanicky bez väzby na anamnézu a nález</td>
    </tr>
    <tr>
      <th scope="row">Elektrodiagnostika</th>
      <td>motorické a senzitívne rýchlosti vedenia, amplitúdy, distálne latencie a ihlová EMG podľa indikácie</td>
      <td>typickým nálezom pri uremickej neuropatii je generalizované, prevažne axonálne postihnutie</td>
    </tr>
  </tbody>
</table>
</div>

<p>Pri symptomatickej periférnej neuropatii u kandidáta na transplantáciu KDIGO odporúča neurologické posúdenie. Pri progresívnej neuropatii pripisovanej urémii napriek intenzívnej dialyzačnej liečbe KDIGO navrhuje zvážiť urgentnú transplantáciu, ak je dostupná. Ide o odporúčanie s veľmi nízkou istotou dôkazov, nie o automatickú transplantačnú indikáciu bez posúdenia celého klinického stavu.</p>

<h2>Liečba zameraná na príčinu</h2>

<p>Základom je čo najpresnejšie určiť etiológiu. Pri uremickej neuropatii treba skontrolovať adekvátnosť a pravidelnosť dialýzy, objemový a metabolický stav, koncentráciu draslíka a ďalšie korigovateľné odchýlky. Dôkazy neumožňujú odporučiť konkrétnu dialyzačnú modalitu výlučne na liečbu neuropatie. Pretrvávanie alebo progresia príznakov má viesť k prehodnoteniu dialyzačnej preskripcie a diferenciálnej diagnózy, nie k nekritickému zvyšovaniu dávok analgetík.</p>

<p>Úspešná transplantácia obličky môže zastaviť progresiu a u časti pacientov zlepšiť klinické aj elektrofyziologické prejavy. Zotavenie však nemusí byť úplné, najmä pri dlhodobom a ťažkom axonálnom poškodení. Po transplantácii treba myslieť aj na neurotoxicitu kalcineurínových inhibítorov a na iné nové príčiny neuropatie.</p>

<p>Pri diabetickej alebo zmiešanej neuropatii zostáva dôležitá bezpečná glykemická kontrola, starostlivosť o nohy, liečba deficitu vitamínu B12 alebo inej preukázanej príčiny, obmedzenie alkoholu, revízia neurotoxických liekov, prevencia pádov a cielená rehabilitácia.</p>

<h2>Intradialytická vysokotónová externá svalová stimulácia, HTEMS</h2>

<p><strong>HTEMS</strong> je skratka anglického názvu <em>high-tone external muscle stimulation</em>. V slovenčine je presnejší termín <strong>vysokotónová externá svalová stimulácia</strong> než všeobecné označenie vysokofrekvenčná stimulácia. Používané zariadenia vytvárajú sínusový striedavý prúd so súčasnou moduláciou frekvencie a amplitúdy, typicky vo frekvenčnom rozsahu približne 4,096 až 32,768 kHz. Elektródy sa prikladajú na dolné končatiny. Mechanistické tvrdenia výrobcov o „normalizácii bunkového metabolizmu“ nemožno považovať za klinicky dokázaný mechanizmus účinku.</p>

<h3>Čo ukázali štúdie pri hemodialýze</h3>

<div class="table-responsive" role="region" aria-label="Klinické štúdie vysokotónovej externej svalovej stimulácie pri hemodialýze" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Súbor a protokol</th>
      <th scope="col">Výsledok</th>
      <th scope="col">Hlavný limit</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Klassen a kol., 2008</th>
      <td>40 hemodialyzovaných pacientov so symptomatickou polyneuropatiou, z toho 25 s diabetickou a 15 s uremickou formou; obe dolné končatiny 60 minút počas dialýzy, trikrát týždenne; 12 pacientov sledovaných 4 týždne a 28 pacientov 12 týždňov</td>
      <td>zlepšenie piatich hodnotených neuropatických symptómov a porúch spánku; odpoveď definovanú zlepšením aspoň jedného symptómu o najmenej 3 body dosiahlo 73 % pacientov; väčší účinok po troch mesiacoch než po jednom mesiaci</td>
      <td>prospektívna, ale nerandomizovaná pilotná štúdia bez kontrolnej a sham skupiny, s prevažne subjektívnymi výsledkami</td>
    </tr>
    <tr>
      <th scope="row">Strempska a kol., 2013</th>
      <td>28 hemodialyzovaných pacientov s manifestnou uremickou polyneuropatiou napriek predchádzajúcej farmakoterapii; 60 minút počas dialýzy, trikrát týždenne, 12 týždňov</td>
      <td>64 % uviedlo lepšiu celkovú pohodu, 61 % vyššiu fyzickú kapacitu a 57 % menší pocit studených nôh; u 19 pacientov s kompletným elektrofyziologickým vyšetrením sa motorická rýchlosť vedenia n. ulnaris zvýšila z 48,53 ± 6,14 na 51,50 ± 5,51 m/s, P = 0,03</td>
      <td>bez randomizácie a kontrolnej skupiny; elektrofyziologický výsledok bol dostupný iba u 19 pacientov a významná zmena sa nepreukázala vo všetkých hodnotených nervoch a parametroch</td>
    </tr>
    <tr>
      <th scope="row">Klassen a kol., 2013</th>
      <td>25 hemodialyzovaných pacientov s periférnou neuropatiou; rovnaký intradialytický režim počas 12 týždňov</td>
      <td>zlepšenie súhrnného skóre bolesti a niektorých domén SF-36, bez významnej zmeny skóre úzkosti a depresie</td>
      <td>malá nekontrolovaná štúdia s viacerými sledovanými výsledkami</td>
    </tr>
  </tbody>
</table>
</div>

<p>Tieto výsledky sú zaujímavé, ale nedokazujú regeneráciu periférnych nervov ani dlhodobý vplyv na progresiu neuropatie, pády, hospitalizácie alebo kvalitu života. Všetky tri klinické práce boli malé a bez randomizovanej kontrolnej skupiny. Pozorovaný účinok preto môže byť ovplyvnený prirodzeným kolísaním symptómov, placebo efektom, regresiou k priemeru a selekciou pacientov, ktorí liečbu dokončili.</p>

<p>HTEMS treba odlíšiť od širšej kategórie neuromuskulárnej elektrickej stimulácie, NMES. Aktualizovaná metaanalýza 12 randomizovaných štúdií s 289 hemodialyzovanými pacientmi podporuje zlepšenie sily dolných končatín, šesťminútovej chôdze a výkonu pri vstávaní zo stoličky pri intradialytickej NMES. Nepreukázala však jasný prínos pre svalovú hmotu, Timed Up and Go, SPPB, aktivity denného života ani kvalitu života a istota dôkazov bola od veľmi nízkej po strednú. Tieto výsledky sa týkajú fyzickej funkcie pri rôznych protokoloch NMES a nemožno ich automaticky preniesť na účinnosť HTEMS proti neuropatickej bolesti.</p>

<h3>Možné miesto HTEMS v praxi</h3>

<p>HTEMS možno zatiaľ vnímať iba ako <strong>experimentálnu doplnkovú nefarmakologickú intervenciu</strong> pre vybraných symptomatických pacientov počas hemodialýzy, napríklad pri nedostatočnom účinku alebo zlej tolerancii liekov. Nenahrádza diagnostiku príčiny, optimalizáciu dialýzy, transplantáciu u vhodného kandidáta, liečbu diabetu ani renálne upravenú farmakoterapiu.</p>

<p>Intradialytické použitie musí schváliť a organizačne zabezpečiť dialyzačný tím. Treba vychádzať z návodu konkrétneho zdravotníckeho zariadenia, posúdiť implantované elektronické prístroje a ďalšie kontraindikácie, skontrolovať kožu a neumiestňovať elektródy do oblasti cievneho prístupu. Tolerancia v pilotných štúdiách bola dobrá, ich veľkosť však nestačí na spoľahlivé zhodnotenie zriedkavých nežiaducich udalostí.</p>

<h3>Dostupnosť na Slovensku</h3>

<p>K 8. septembru 2026 sa podarilo verejne overiť <strong>komerčnú dostupnosť zariadení HiToP na Slovensku</strong>, ponuku ambulantnej vysokotónovej terapie v jednom fyzioterapeutickom pracovisku a ponuku prenájmu domáceho prístroja. Tieto informácie však nepotvrdzujú, že slovenské dialyzačné centrá poskytujú HTEMS rutinne počas hemodialýzy, že používajú protokol zo zverejnených štúdií alebo že je takáto intervencia hradená z verejného zdravotného poistenia.</p>

<p><strong>Rutinnú dostupnosť intradialytickej HTEMS v slovenských dialyzačných centrách sa z verejných zdrojov nepodarilo potvrdiť.</strong> Neznamená to, že ju žiadne pracovisko individuálne neposkytuje. Záujemca sa musí informovať priamo vo svojom dialyzačnom centre; ambulantná alebo domáca ponuka prístroja nie je ekvivalentom liečby počas dialýzy pod dohľadom dialyzačného tímu.</p>

<h2>Symptomatická farmakoterapia neuropatickej bolesti</h2>

<p>Farmakoterapia má sledovať konkrétny cieľ: klinicky významné zníženie bolesti, lepší spánok alebo zlepšenie funkcie pri prijateľnej toxicite. Ak sa tento cieľ po primeranej titrácii nedosiahne, liečbu treba prehodnotiť. Pri pokročilej CKD je nevhodné automaticky zvyšovať dávku podľa schém určených pre normálnu funkciu obličiek.</p>

<p>Gabapentín a pregabalín sú registrované na liečbu periférnej neuropatickej bolesti, nie osobitne uremickej neuropatie. Obe liečivá sa eliminujú prevažne obličkami, pri zníženej renálnej funkcii sa kumulujú a hemodialýza ich čiastočne odstraňuje. Klinická účinnosť presných renálnych dávkovacích schém u populácie s pokročilou CKD nebola overená rovnako robustne ako ich farmakokinetika.</p>

<h3>Gabapentín podľa aktuálneho slovenského SPC</h3>

<div class="table-responsive" role="region" aria-label="Dávkovanie gabapentínu podľa klírensu kreatinínu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Klírens kreatinínu</th>
      <th scope="col">Celková denná dávka podľa SPC</th>
      <th scope="col">Poznámka</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">≥ 80 ml/min</th><td>900 až 3 600 mg/deň</td><td rowspan="3">celková denná dávka sa v citovanom SPC podáva rozdelená do troch dávok</td></tr>
    <tr><th scope="row">50 až 79 ml/min</th><td>600 až 1 800 mg/deň</td></tr>
    <tr><th scope="row">30 až 49 ml/min</th><td>300 až 900 mg/deň</td></tr>
    <tr><th scope="row">15 až 29 ml/min</th><td>150 až 600 mg/deň</td><td>150 mg/deň sa realizuje ako 300 mg každý druhý deň</td></tr>
    <tr><th scope="row">&lt; 15 ml/min</th><td>150 až 300 mg/deň</td><td>dávka sa znižuje úmerne klírensu; aj tu sa 150 mg/deň realizuje ako 300 mg každý druhý deň</td></tr>
  </tbody>
</table>
</div>

<p>U anurického hemodialyzovaného pacienta, ktorý gabapentín predtým neužíval, citované SPC uvádza nasycovaciu dávku 300 až 400 mg a potom 200 až 300 mg po každých štyroch hodinách hemodialýzy; v nedialyzačné dni sa gabapentín nepodáva. Pri zachovanej reziduálnej funkcii sa udržiavacia dávka určuje podľa tabuľky a po každom štvorhodinovom dialyzačnom výkone sa pridáva 200 až 300 mg. Ide o schému konkrétneho SPC, nie o univerzálnu štartovaciu dávku pre každého krehkého pacienta s neuropatickou bolesťou.</p>

<h3>Pregabalín podľa aktuálnej informácie EMA</h3>

<div class="table-responsive" role="region" aria-label="Dávkovanie pregabalínu podľa klírensu kreatinínu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Klírens kreatinínu</th>
      <th scope="col">Úvodná dávka</th>
      <th scope="col">Maximálna dávka</th>
      <th scope="col">Režim</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">≥ 60 ml/min</th><td>150 mg/deň</td><td>600 mg/deň</td><td>v dvoch alebo troch dávkach</td></tr>
    <tr><th scope="row">≥ 30 až &lt; 60 ml/min</th><td>75 mg/deň</td><td>300 mg/deň</td><td>v dvoch alebo troch dávkach</td></tr>
    <tr><th scope="row">≥ 15 až &lt; 30 ml/min</th><td>25 až 50 mg/deň</td><td>150 mg/deň</td><td>raz denne alebo v dvoch dávkach</td></tr>
    <tr><th scope="row">&lt; 15 ml/min</th><td>25 mg/deň</td><td>75 mg/deň</td><td>raz denne</td></tr>
    <tr><th scope="row">Po štvorhodinovej hemodialýze</th><td colspan="2">jednorazová doplnková dávka 25 až 100 mg</td><td>navyše k dennej dávke určenej podľa reziduálnej funkcie obličiek</td></tr>
  </tbody>
</table>
</div>

<p>Tabuľky opisujú schválené dávkovacie rozpätia. Neznamenajú, že každý pacient má začať na hornej hranici alebo že maximálna dávka je terapeutickým cieľom. Pri vyššom veku, krehkosti, pádoch, kognitívnej poruche, súbežných sedatívach alebo kolísajúcej reziduálnej funkcii je potrebná obzvlášť pomalá titrácia a časté prehodnotenie prínosu.</p>

<h3>Ďalšie liekové možnosti</h3>

<p>Tricyklické antidepresíva, napríklad amitriptylín, môžu tlmiť neuropatickú bolesť, no pri pokročilej CKD ich použitie často obmedzuje anticholinergný účinok, ortostatická hypotenzia, sedácia, retencia moču, predĺženie QT intervalu a riziko pádov. U starších a polymorbídnych pacientov preto nejde o automatickú prvú voľbu. Výber duloxetínu a iných antidepresív musí rešpektovať aktuálne SPC konkrétneho lieku, pretože pri ťažkej poruche funkcie obličiek môžu byť nevhodné alebo kontraindikované.</p>

<p>Opioidy nie sú preferovanou dlhodobou liečbou polyneuropatickej bolesti. Ak sa výnimočne používajú, treba zohľadniť renálnu elimináciu účinnej látky a metabolitov, riziko sedácie, pádov, delíria, respiračnej depresie, tolerancie a závislosti. Kombinácia opioidu s gabapentínom alebo pregabalínom zvyšuje riziko útlmu centrálneho nervového systému a dýchania.</p>

<h2>Bezpečnosť gabapentinoidov pri CKD</h2>

<div class="table-responsive" role="region" aria-label="Varovné prejavy toxicity gabapentínu a pregabalínu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Riziko</th>
      <th scope="col">Prejavy alebo okolnosti</th>
      <th scope="col">Praktický postup</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Kumulácia a neurotoxicita</th><td>nová somnolencia, závraty, ataxia, zmätenosť, myoklónus, porucha reči alebo pády</td><td>overiť dávku, klírens kreatinínu, reziduálnu funkciu a dialyzačný režim; liečbu bezodkladne prehodnotiť</td></tr>
    <tr><th scope="row">Respiračná depresia</th><td>vyššie riziko pri poruche funkcie obličiek, vyššom veku, respiračnom alebo neurologickom ochorení a pri súbežných opioidoch alebo iných látkach tlmiacich CNS</td><td>kombinácie minimalizovať, poučiť pacienta a pri spomalenom alebo sťaženom dýchaní zabezpečiť urgentné vyšetrenie</td></tr>
    <tr><th scope="row">Edémy a funkčný pokles</th><td>periférne opuchy, prírastok hmotnosti, neistota pri chôdzi a zhoršenie sebestačnosti</td><td>odlíšiť liekový účinok od hypervolémie alebo srdcového zlyhávania a zvážiť redukciu či zmenu liečby</td></tr>
    <tr><th scope="row">Závislosť a abstinenčné príznaky</th><td>tolerancia, samovoľné zvyšovanie dávky, vyhľadávanie lieku; po náhlom vysadení nespavosť, úzkosť, nauzea, bolesť, potenie alebo kŕče</td><td>riziko posúdiť už pred liečbou a gabapentinoid vysadzovať postupne, spravidla najmenej počas jedného týždňa</td></tr>
  </tbody>
</table>
</div>

<p>Pri výbere dávky treba použiť tú funkciu obličiek a výpočtovú metódu, na ktorú sa odvoláva aktuálne SPC konkrétneho prípravku. Nie je správne mechanicky označiť eGFR alebo klírens kreatinínu za všeobecne „presnejší“ ukazovateľ bez ohľadu na registračný podklad. Pri gabapentíne a pregabalíne citované dokumenty viažu dávkovanie na odhad klírensu kreatinínu.</p>

<h2>Praktický diagnosticko-terapeutický rámec</h2>

<ol>
  <li><strong>Potvrdiť fenotyp.</strong> Určiť distribúciu, tempo, senzitívne, motorické a autonómne prejavy, bolesť, funkčný dosah a riziko pádov.</li>
  <li><strong>Hľadať inú alebo pridruženú príčinu.</strong> Skontrolovať diabetes, vitamín B12, paraproteinémiu, alkohol, lieky a ďalšie vyšetrenia podľa kliniky.</li>
  <li><strong>Rozpoznať varovné znaky.</strong> Pri asymetrii, rýchlej progresii, proximálnej alebo výraznej motorickej slabosti, demyelinizácii alebo akútnom postihnutí po vytvorení cievneho prístupu zabezpečiť skoré až urgentné vyšetrenie.</li>
  <li><strong>Optimalizovať nefrologickú liečbu.</strong> Posúdiť dialyzačnú adekvátnosť, draslík, acidobázickú rovnováhu, výživu, diabetes a transplantačné možnosti.</li>
  <li><strong>Zvoliť merateľný liečebný cieľ.</strong> Napríklad menej nočnej bolesti, lepší spánok, bezpečnejšia chôdza alebo zvládnutie konkrétnej dennej činnosti.</li>
  <li><strong>Ak je potrebný liek, začať opatrne.</strong> Dávku viazať na aktuálne SPC, renálnu funkciu a dialyzačný režim; sledovať sedáciu, rovnováhu, kogníciu, edémy a dýchanie.</li>
  <li><strong>Zvážiť nefarmakologický doplnok.</strong> Rehabilitácia, tréning rovnováhy a starostlivosť o nohy majú praktický význam. HTEMS možno zvážiť iba tam, kde je dostupné odborné intradialytické pracovisko a pacient rozumie obmedzenej istote dôkazov.</li>
  <li><strong>Pravidelne depreskribovať neúčinnú liečbu.</strong> Liek bez klinického prínosu alebo s neprijateľnou toxicitou nemá zostať v medikácii iba zo zotrvačnosti.</li>
</ol>

<h2>Limity dôkazov</h2>

<p>Údaje o uremickej neuropatii pochádzajú prevažne zo starších observačných štúdií a prehľadov. Moderných randomizovaných štúdií zameraných na klinicky významné neurologické výsledky je málo. Renálne dávkovanie gabapentinoidov je dobre opreté o farmakokinetiku a regulačné dokumenty, menej istá je však veľkosť ich klinického účinku priamo pri uremickej neuropatii. HTEMS má iba malé nekontrolované štúdie; širšia evidencia NMES sa týka najmä svalovej sily a fyzickej funkcie, nie špecificky neuropatickej bolesti.</p>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Uremická neuropatia je prevažne distálna symetrická senzitívno-motorická polyneuropatia pokročilej CKD, ale diagnózu nemožno stanoviť iba podľa prítomnosti zlyhania obličiek. Potrebné je klinické hodnotenie, cielené vyšetrenie liečiteľných príčin a elektrodiagnostika pri atypickom alebo nejasnom priebehu.</p>

<p>Liečba má prednostne ovplyvniť príčinu a funkčný dosah. Gabapentín a pregabalín vyžadujú dôslednú úpravu podľa klírensu kreatinínu a dialyzačného režimu; sedácia, pády, respiračná depresia a závislosť sú klinicky významné riziká. HTEMS je zaujímavý intradialytický doplnok s predbežným signálom symptomatického a čiastočne elektrofyziologického prínosu, nie však etablovaná náhrada štandardnej liečby. Na Slovensku sú verejne ponúkané zariadenia a ambulantné alebo domáce použitie, rutinnú dostupnosť počas dialýzy sa však nepodarilo potvrdiť.</p>
</div>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=myosteatoza-hemodialyza-ct-kvalita-svalstva">Myosteatóza pri hemodialýze: CT ukazovatele kvality svalstva a funkčné vyšetrenie</a></li>
  <li><a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">Chronická choroba obličiek ako samostatný faktor polyfarmácie</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Arnold R, Issar T, Krishnan AV, Pussell BA.</strong> <em>Neurological complications in chronic kidney disease.</em> JRSM Cardiovasc Dis. 2016;5:2048004016677687. doi: 10.1177/2048004016677687. <a href="https://pubmed.ncbi.nlm.nih.gov/27867500/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5102165/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>Krishnan AV, Kiernan MC.</strong> <em>Uremic neuropathy: clinical features and new pathophysiological insights.</em> Muscle Nerve. 2007;35(3):273–290. doi: 10.1002/mus.20713. <a href="https://pubmed.ncbi.nlm.nih.gov/17195171/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Mirian A, Aljohani Z, Grushka D, Florendo-Cumbermack A.</strong> <em>Diagnosis and management of patients with polyneuropathy.</em> CMAJ. 2023;195(6):E227–E233. doi: 10.1503/cmaj.220936. <a href="https://pubmed.ncbi.nlm.nih.gov/36781195/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9928442/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>Pirzada NA, Morgenlander JC.</strong> <em>Peripheral neuropathy in patients with chronic renal failure: a treatable source of discomfort and disability.</em> Postgrad Med. 1997;102(4):249–250, 255–257, 261. doi: 10.3810/pgm.1997.10.344. <a href="https://pubmed.ncbi.nlm.nih.gov/9336610/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>England JD, Gronseth GS, Franklin G, a spol.</strong> <em>Practice Parameter: evaluation of distal symmetric polyneuropathy: role of laboratory and genetic testing.</em> Neurology. 2009;72(2):185–192. doi: 10.1212/01.wnl.0000336370.51010.a1. <a href="https://www.aan.com/Guidelines/home/GetGuidelineContent/322" target="_blank" rel="noopener noreferrer">Súhrn AAN</a>; <a href="https://doi.org/10.1212/01.wnl.0000336370.51010.a1" target="_blank" rel="noopener noreferrer">publikácia</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes Transplant Candidate Work Group.</strong> <em>KDIGO Clinical Practice Guideline on the Evaluation and Management of Candidates for Kidney Transplantation.</em> Transplantation. 2020;104(4S):S11–S103. <a href="https://kdigo.org/wp-content/uploads/2018/08/KDIGO-Txp-Candidate-GL-FINAL.pdf" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>.</li>
  <li><strong>Raouf M, Atkinson TJ, Crumb MW, Fudin J.</strong> <em>Rational dosing of gabapentin and pregabalin in chronic kidney disease.</em> J Pain Res. 2017;10:275–278. doi: 10.2147/JPR.S130942. <a href="https://pubmed.ncbi.nlm.nih.gov/28184168/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5291335/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>Štátny ústav pre kontrolu liečiv.</strong> <em>Gabapentin Vipharm 100 mg, 300 mg a 400 mg tvrdé kapsuly: Súhrn charakteristických vlastností lieku.</em> Zmena 2026/00635-Z1B. <a href="https://www.sukl.sk/hlavna-stranka-1/slovenska-verzia/pomocne-stranky/save-dokument?dok_id=888597&amp;dok_sec=01219589987550411397bc5369fad73d&amp;page_id=637" target="_blank" rel="noopener noreferrer">Aktuálne SPC</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Lyrica: EPAR Product Information.</em> Revízia 72, aktualizované 25. marca 2026. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/lyrica" target="_blank" rel="noopener noreferrer">EMA</a>; <a href="https://www.ema.europa.eu/en/documents/product-information/lyrica-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">informácia o lieku</a>.</li>
  <li><strong>Pop-Busui R, Roberts L, Pennathur S, Kretzler M, Brosius FC, Feldman EL.</strong> <em>The management of diabetic neuropathy in CKD.</em> Am J Kidney Dis. 2010;55(2):365–385. doi: 10.1053/j.ajkd.2009.10.050. <a href="https://pubmed.ncbi.nlm.nih.gov/20042258/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4007054/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>Klassen A, Di Iorio B, Guastaferro P, Bahner U, Heidland A, De Santo N.</strong> <em>High-tone external muscle stimulation in end-stage renal disease: effects on symptomatic diabetic and uremic peripheral neuropathy.</em> J Ren Nutr. 2008;18(1):46–51. doi: 10.1053/j.jrn.2007.10.010. <a href="https://pubmed.ncbi.nlm.nih.gov/18089443/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Strempska B, Bilinska M, Weyde W, Koszewicz M, Madziarska K, Golebiowski T, Klinger M.</strong> <em>The effect of high-tone external muscle stimulation on symptoms and electrophysiological parameters of uremic peripheral neuropathy.</em> Clin Nephrol. 2013;79 Suppl 1:S24–S27. <a href="https://pubmed.ncbi.nlm.nih.gov/23249529/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Klassen A, Racasan S, Gherman-Caprioara M, Kürner B, Blaser C, Bahner U, Heidland A.</strong> <em>High-tone external muscle stimulation in endstage renal disease: effects on quality of life in patients with peripheral neuropathy.</em> Clin Nephrol. 2013;79 Suppl 1:S28–S33. <a href="https://pubmed.ncbi.nlm.nih.gov/23249530/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Otobe Y, Usui N, Kojima S, a spol.</strong> <em>Efficacy of Neuromuscular Electrical Stimulation in Patients on Hemodialysis: An Updated Systematic Review and Meta-analysis.</em> Kidney Med. 2026;8(6):101368. doi: 10.1016/j.xkme.2026.101368. <a href="https://pubmed.ncbi.nlm.nih.gov/42222442/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13218137/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>gbo Medizintechnik AG.</strong> <em>High Tone Therapy.</em> Technický opis frekvenčného rozsahu a zariadení. <a href="https://gbo-med.de/en/products/hightone_therapy/" target="_blank" rel="noopener noreferrer">Výrobca</a>.</li>
  <li><strong>BETA plus, spol. s r. o.</strong> <em>Vysokotónová terapia HiToP na Slovensku.</em> Komerčná ponuka zariadení. <a href="https://www.medicinskepristroje.sk/" target="_blank" rel="noopener noreferrer">Slovenský dodávateľ</a>.</li>
  <li><strong>Medikard Fyzio; ADOS-MAGDA.</strong> Verejné ponuky ambulantnej procedúry a prenájmu domáceho zariadenia na Slovensku. <a href="https://www.medikardfyzio.sk/hitop/" target="_blank" rel="noopener noreferrer">Ambulantná ponuka</a>; <a href="https://www.ados-magda.sk/pozicovna-pristroja-hitop-pnp-na-liecbu-polyneuropatie" target="_blank" rel="noopener noreferrer">prenájom zariadenia</a>.</li>
</ol>

<p><em><strong>Poznámka k dávkovaniu:</strong> Uvedené hodnoty reprodukujú citované regulačné dokumenty platné pri príprave článku. Pred predpísaním treba skontrolovať aktuálne SPC konkrétneho prípravku, indikáciu, klírens kreatinínu, reziduálnu funkciu obličiek, dialyzačný režim, vek, krehkosť, interakcie a klinickú odpoveď.</em></p>

<p><em><strong>Poznámka k dostupnosti HTEMS:</strong> Verejne dostupné komerčné stránky potvrdzujú dostupnosť zariadení alebo procedúr, nie rutinné intradialytické poskytovanie ani úhradu. Informácia bola overovaná k 8. septembru 2026 a môže sa meniť.</em></p>

<p><em><strong>Upozornenie:</strong> Text je určený na odborné vzdelávanie a nenahrádza individuálne neurologické, nefrologické ani farmakologické posúdenie pacienta.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_polyneuropatia-ckd-diagnostika-liecba-bezpecne-davkovanie_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "------------------------------------------------------\n";
    echo 'Migracia clanku: ' . $articles[0]['title'] . "\n";
    echo "------------------------------------------------------\n";
    echo "Vysledok: $inserted vlozenych, $updated aktualizovanych z $total clankov.\n";
    echo "Preskocenych (bez zmeny):      $skipped\n";
    echo "Zaradenych do fronty aviz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "------------------------------------------------------\n\n";
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
