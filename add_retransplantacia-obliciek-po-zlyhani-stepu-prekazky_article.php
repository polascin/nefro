<?php
/**
 * Odborný článok: Prekážky opakovanej transplantácie obličky po zlyhaní štepu.
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
    'title'        => 'Po zlyhaní transplantovanej obličky: prekážky opakovanej transplantácie očami pacientov, opatrovateľov aj lekárov',
    'slug'         => 'retransplantacia-obliciek-po-zlyhani-stepu-prekazky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kanadská kvalitatívna štúdia identifikovala štyri prekážky opakovanej transplantácie a ďalšie štyri pri darcovstve od žijúceho darcu. Komentár pacientky po troch transplantáciách ukazuje, ako sa prejavujú v praxi.',
    'content'      => <<<'HTML'
<p>Zlyhanie transplantovanej obličky neznamená iba návrat k dialýze. Pacient sa musí vyrovnať so stratou fungujúceho orgánu, obnovením uremických ťažkostí, zmenou imunosupresívnej liečby, neistotou ďalšej prognózy a často aj s podstatne zložitejšou cestou k opakovanej transplantácii.</p>

<p>Význam témy podčiarkujú dve skutočnosti, ktoré uvádzajú autori kanadskej kvalitatívnej štúdie publikovanej v <em>Clinical Journal of the American Society of Nephrology</em>: opakovaná transplantácia prináša oproti zotrvaniu na čakacej listine <strong>významný prínos v prežívaní</strong>, a zlyhanie štepu zostáva <strong>jednou z hlavných príčin začatia dialýzy</strong>. Trendy v preemptívnom opätovnom zaradení na čakaciu listinu sú pritom podľa autorov neuspokojivé.</p>

<p>Na túto štúdiu reagovala v tom istom časopise osobným komentárom Kimberly Brown Marsh — pacientka po troch transplantáciách obličky. Pacientska skúsenosť nenahrádza kontrolovanú štúdiu, prináša však informácie, ktoré registre a administratívne databázy zachytávajú nedostatočne: psychologické dôsledky straty štepu, praktické problémy pri hľadaní žijúceho darcu, nedostatky edukácie, fragmentáciu starostlivosti a potrebu aktívnej navigácie pacienta systémom.</p>

<h2>Opakovaná transplantácia nie je návratom na začiatok</h2>

<p>Pacient po zlyhaní štepu sa z klinického ani imunologického hľadiska nevracia do východiskovej situácie. Jeho postavenie komplikuje HLA senzibilizácia po predchádzajúcej transplantácii, predchádzajúce transfúzie, gravidita, protilátkami sprostredkovaná rejekcia, chirurgické následky predošlých výkonov, cievne komplikácie, dlhšia kumulatívna expozícia imunosupresii, prekonané infekcie a malignity, progresia kardiovaskulárnych ochorení, strata funkčnej rezervy a vznik krehkosti — a napokon aj psychologické následky samotného zlyhania.</p>

<p>Opakovaná transplantácia preto nie je technickým zopakovaním prvého výkonu. Vyžaduje nové posúdenie imunologického rizika, operačnej realizovateľnosti, komorbidít, adherencie, sociálnej podpory a očakávaného prínosu.</p>

<h2>Kvalitatívna štúdia a jej zistenia</h2>

<p>Autori použili interpretatívne deskriptívne usporiadanie. Účastníkov vyberali cieleným výberom a metódou snehovej gule, údaje zbierali pološtruktúrovanými rozhovormi a analyzovali ich induktívnou tematickou analýzou. Zosumarizovali perspektívy <strong>23 pacientov so skúsenosťou so zlyhaním štepu, 23 opatrovateľov a 11 transplantačných nefrológov zastupujúcich 11 kanadských transplantačných programov</strong>.</p>

<div class="table-responsive" role="region" aria-label="Prekážky opakovanej transplantácie identifikované v kvalitatívnej štúdii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Prekážky opakovanej transplantácie</th>
      <th scope="col">Dôsledok podľa autorov</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Vysoká protilátková senzibilizácia</th>
      <td>Nedostatok kompatibilných darcov</td>
    </tr>
    <tr>
      <th scope="row">Vysoký výskyt komorbidít</th>
      <td>Nespôsobilosť na zaradenie alebo vyradenie z čakacej listiny</td>
    </tr>
    <tr>
      <th scope="row">Anamnéza neadherencie</th>
      <td>Nespôsobilosť alebo oneskorenie odoslania a opätovného posúdenia</td>
    </tr>
    <tr>
      <th scope="row">Oneskorené odoslanie</th>
      <td>Zlá koordinácia vyšetrení pred opakovanou transplantáciou</td>
    </tr>
  </tbody>
</table>
</div>

<div class="table-responsive" role="region" aria-label="Ďalšie prekážky pri transplantácii od žijúceho darcu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ďalšie prekážky pri žijúcom darcovi</th>
      <th scope="col">Podstata problému</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Preferencia zomretého darcu</th>
      <td>Postoj, ktorý sa po zlyhaní štepu podľa účastníkov pravdepodobne nezmení</td>
    </tr>
    <tr>
      <th scope="row">Vnímane vyčerpaný okruh darcov</th>
      <td>Pocit, že menší okruh vhodných žijúcich darcov sa už spotreboval pri prvej transplantácii</td>
    </tr>
    <tr>
      <th scope="row">Psychologická záťaž</th>
      <td>Nevyriešené otázky spojené so stratou predchádzajúceho štepu od žijúceho darcu</td>
    </tr>
    <tr>
      <th scope="row">Štrukturálne prekážky</th>
      <td>Celkové systémové bariéry živého darcovstva obličky</td>
    </tr>
  </tbody>
</table>
</div>

<p>Kvalitatívny dizajn umožnil podrobne preskúmať skúsenosti jednotlivých skupín. Neumožňuje však určiť prevalenciu jednotlivých prekážok ani kvantifikovať ich vplyv na pravdepodobnosť opakovanej transplantácie.</p>

<h2>Senzibilizácia a nedostatok kompatibilných darcov</h2>

<p>Autorka komentára opisuje, že v 80. rokoch dostala viacero transfúzií, po ktorých sa stala výrazne HLA senzibilizovanou. Pred ďalšou transplantáciou strávila približne štyri roky na hemodialýze — vrátane posledných troch rokov strednej školy a prvého roka vysokej školy.</p>

<p>Mechanizmus je biologicky vierohodný. Expozícia cudzorodým HLA antigénom pri transfúzii, gravidite alebo predchádzajúcej transplantácii môže viesť k tvorbe anti-HLA protilátok. Vysoký vypočítaný panel reaktívnych protilátok (cPRA) znižuje pravdepodobnosť negatívnej krížovej skúšky a predlžuje čakanie na kompatibilný orgán.</p>

<p>U pacienta po zlyhaní štepu je preto dôležité predchádzať zbytočným transfúziám, optimalizovať liečbu anémie, pravidelne aktualizovať protilátkový profil, dokumentovať predchádzajúce donorovo špecifické protilátky, včas posúdiť možnosť párovej výmeny obličiek, zvážiť programy prijateľného nesúladu alebo prioritizácie vysoko senzibilizovaných pacientov a individuálne posúdiť desenzibilizačné postupy.</p>

<p>Vyhýbanie sa transfúziám však nesmie byť absolútne — pri život ohrozujúcej anémii, krvácaní alebo perioperačnej potrebe má prednosť bezpečnosť pacienta.</p>

<h3>Odborné spresnenie: krvná skupina a Rh faktor</h3>

<p>Autorka uvádza, že nikto z jej rodiny nemal krvnú skupinu 0 pozitívnu. Toto tvrdenie si vyžaduje spresnenie.</p>

<p>Pre kompatibilitu pri transplantácii obličky je podstatný systém AB0. <strong>Rh faktor nemá pri výbere darcu obličky rovnaký význam ako pri transfúzii erytrocytov.</strong> Pacient s krvnou skupinou 0 spravidla potrebuje darcu skupiny 0, darca však nemusí mať zhodný Rh faktor.</p>

<p>Prekážkou teda pravdepodobne bola neprítomnosť vhodného darcu skupiny 0, nie neprítomnosť darcu 0 pozitívneho. V súčasnosti navyše môže nekompatibilný dobrovoľný darca vstúpiť do programu párovej výmeny a umožniť transplantáciu v rámci výmenného reťazca.</p>

<h2>Komorbidity a pripravenosť na transplantáciu</h2>

<p>Autorka opisuje onkologické ochorenie diagnostikované šesť rokov pred publikovaním komentára. Chemoterapia podľa jej skúsenosti ohrozila funkciu transplantovanej obličky, štep sa však zotavil a autorka uvádza, že je bez známok malignity. Jej súčasný transplantát funguje už 32 rokov.</p>

<p>Príbeh poukazuje na zložitú rovnováhu medzi liečbou malignity, zachovaním štepu a úpravou imunosupresie. Onkologická liečba môže štep ovplyvniť priamou nefrotoxicitou, akútnym poškodením obličiek, infekčnými komplikáciami, dehydratáciou a elektrolytovými poruchami, interakciami s imunosupresívami, potrebou znížiť alebo zmeniť imunosupresiu a s tým spojeným rizikom rejekcie.</p>

<p>Autorkino vyjadrenie, že aktívna malignita by ďalšiu transplantáciu znemožnila, je zrozumiteľné, ale príliš kategorické. Aktívne onkologické ochorenie je vo väčšine prípadov dôvodom transplantáciu odložiť, rozhodovanie však závisí od typu nádoru, štádia, biologického správania, odpovede na liečbu, rizika recidívy a naliehavosti transplantácie. Odporúčanie KDIGO pre hodnotenie kandidátov sa odklonilo od jednotného univerzálneho intervalu bez ochorenia pre všetky malignity smerom k individualizovanému posúdeniu v spolupráci s onkológom.</p>

<h2>Adherencia nie je len vlastnosť pacienta</h2>

<p>Anamnéza neadherencie bola v štúdii identifikovaná ako prekážka vedúca k nespôsobilosti alebo k oneskoreniu odoslania a opätovného posúdenia. Faktor je klinicky relevantný — vynechávanie imunosupresív môže viesť k tvorbe donorovo špecifických protilátok, rejekcii a strate štepu.</p>

<p>Pojem neadherencia sa však nesmie používať ako morálny úsudok. Nedodržiavanie liečby môže byť dôsledkom finančných problémov, nedostatočného poistného krytia, nežiaducich účinkov, depresie alebo úzkosti, kognitívnej poruchy, nízkej zdravotnej gramotnosti, jazykovej bariéry, nestabilného bývania, nedostupnosti dopravy, komplikovaného dávkovacieho režimu, nedostatočnej komunikácie so zdravotníckym tímom alebo prechodu z pediatrickej do dospelej starostlivosti.</p>

<p>Posúdenie pred opakovanou transplantáciou by preto nemalo končiť pri otázke, či pacient v minulosti liečbu dodržiaval. Treba identifikovať príčiny, posúdiť ich odstrániteľnosť a vytvoriť konkrétny podporný plán — zjednodušenie režimu, pripomienky, zapojenie rodiny, sociálnu intervenciu, psychiatrickú alebo psychologickú liečbu, zabezpečenie dostupnosti liekov, častejšie kontroly a zrozumiteľnú edukáciu.</p>

<p>Predchádzajúca neadherencia nemá byť automatickou a trvalou kontraindikáciou. Zároveň ju nemožno ignorovať, ak pretrvávajú okolnosti, ktoré by nový štep vystavili vysokému riziku.</p>

<h2>Oneskorené odoslanie a fragmentovaná starostlivosť</h2>

<p>Po zlyhaní štepu pacient prechádza medzi transplantačným centrom, všeobecným nefrologickým pracoviskom a dialyzačným strediskom. Ak nie je jasne určené, kto zodpovedá za nové transplantačné vyšetrenie, dochádza k oneskoreniu.</p>

<p>Opätovné posúdenie transplantability by sa nemalo začínať až po definitívnom zlyhaní štepu a návrate na dialýzu. U vhodného pacienta treba plánovanie začať už pri progresívnom poklese funkcie štepu. Včasný postup umožňuje identifikovať potenciálneho žijúceho darcu, začať párovú výmenu, aktualizovať HLA vyšetrenia, liečiť ovplyvniteľné komorbidity, dokončiť kardiologické a onkologické vyšetrenia, zhodnotiť adherenciu a sociálne podmienky, pripraviť dialyzačný prístup a predísť neplánovanému začatiu dialýzy.</p>

<p>Preemptívna opakovaná transplantácia môže návrat na dialýzu obmedziť alebo mu úplne zabrániť. Nie je však dostupná všetkým — závisí od vhodného darcu, imunologického rizika, časovania a organizačných možností programu.</p>

<h2>Psychologický význam straty štepu</h2>

<p>Strata štepu môže byť psychologicky podobná strate blízkej osoby alebo zásadnej životnej schopnosti. Môže vyvolať smútok, hnev, pocit osobného zlyhania, vinu voči žijúcemu darcovi, strach z ďalšieho zlyhania, nedôveru k liečbe, depresívne a úzkostné prejavy aj vyhýbanie sa diskusii o novej transplantácii.</p>

<p>Záťaž býva obzvlášť výrazná po zlyhaní štepu od žijúceho darcu — a práve to štúdia identifikovala ako samostatnú prekážku. Pacient môže nadobudnúť presvedčenie, že predchádzajúci dar bol „premárnený“, a odmietať požiadať o ďalšie darcovstvo. Takéto presvedčenie sa nedá riešiť ďalšou technickou informáciou. Vyžaduje psychologickú podporu, citlivé vysvetlenie príčin straty štepu a podľa potreby zapojenie predchádzajúceho darcu alebo rodiny.</p>

<h2>Transplantácia od žijúceho darcu</h2>

<p>Niektorí pacienti uprednostňujú čakanie na orgán od zomretého darcu, hoci by mohli využiť živé darcovstvo. Dôvodom býva obava poškodiť blízkeho človeka, pocit viny, neochota požiadať o orgán alebo skúsenosť so zlyhaním predchádzajúceho štepu. Podľa účastníkov štúdie ide o preferenciu, ktorá sa po zlyhaní štepu pravdepodobne nezmení.</p>

<p>Pacient má právo transplantáciu od žijúceho darcu odmietnuť. Jeho rozhodnutie by však malo vychádzať zo správnych a úplných informácií. Edukácia má zahŕňať riziká a prínosy živého darcovstva, nezávislé posúdenie a ochranu darcu, možnosť párovej výmeny, anonymné darcovské reťazce, skutočnosť že biologický príbuzný nemusí byť priamym kompatibilným darcom, možnosť zapojenia širšej sociálnej siete a právo darcu kedykoľvek a bez vysvetľovania odstúpiť.</p>

<p><strong>Pacient nemá niesť zodpovednosť za rozhodnutie, či je potenciálny darca zdravotne vhodný.</strong> Túto úlohu má nezávislý tím posudzujúci darcu.</p>

<h2>Imunosupresia po zlyhaní štepu</h2>

<p>Jedno z najťažších rozhodnutí. Rýchle vysadenie imunosupresie môže znižovať riziko infekcií, malignít, metabolických komplikácií a hematologickej toxicity. Súčasne však môže zvýšiť riziko tvorby nových anti-HLA protilátok, nárastu cPRA, straty reziduálnej funkcie štepu, syndrómu intolerancie zlyhaného štepu a potreby transplantektómie.</p>

<p>Pokračovanie imunosupresie môže byť výhodnejšie u pacienta s reálnou možnosťou skorej opakovanej transplantácie. U pacienta s aktívnou závažnou infekciou, malignitou alebo bez realistickej perspektívy retransplantácie môže prevážiť potreba liečbu znížiť alebo ukončiť.</p>

<p>Univerzálny režim neexistuje. Rozhodnutie má zohľadniť očakávaný čas do opakovanej transplantácie, prítomnosť žijúceho darcu, imunologické riziko, infekčné a onkologické komplikácie, reziduálnu diurézu, symptómy zlyhaného štepu, vek, komorbidity a preferencie pacienta.</p>

<h2>Transplantektómia zlyhaného štepu</h2>

<p>Odstránenie zlyhaného štepu sa nerobí rutinne. Môže byť indikované pri neovládateľnom syndróme intolerancie štepu, pretrvávajúcej bolesti, krvácaní, infekcii, závažnej rejekcii nereagujúcej na liečbu, cievnej komplikácii, podozrení na malignitu v štepe alebo pri potrebe vytvoriť anatomické podmienky pre ďalšiu transplantáciu.</p>

<p>Transplantektómia aj vysadenie imunosupresie sa spájajú so zvýšenou tvorbou anti-HLA protilátok. Vzťah však ovplyvňuje klinická indikácia výkonu, predchádzajúca senzibilizácia, načasovanie a spôsob vysadenia imunosupresie. Nemožno preto tvrdiť, že samotná transplantektómia senzibilizáciu vždy spôsobuje ani že jej vynechanie jej spoľahlivo zabráni.</p>

<h2>Sociálne determinanty prístupu</h2>

<p>Autorka komentára upozorňuje, že štúdia mohla podrobnejšie skúmať sociálne a ekonomické faktory: príjem a pracovnú situáciu, zdravotné poistenie, platené pracovné voľno, dopravu do centra, vzdialenosť, dostupnosť opatrovateľa, jazyk, zdravotnú gramotnosť, bývanie, pobytový status a prístup k digitálnym technológiám.</p>

<p>Tieto faktory môžu navonok pôsobiť ako neadherencia alebo nedostatočný záujem pacienta, v skutočnosti však ide o systémové prekážky. Transplantačné programy by preto mali hodnotiť nielen individuálnu motiváciu, ale aj to, či pacient dostal reálnu možnosť požiadavky programu splniť.</p>

<h2>Navrhované riešenia</h2>

<p>Autori štúdie výslovne prezentujú dôsledky na úrovni systému, transplantačného centra, poskytovateľa aj pacienta.</p>

<h3>Systém</h3>

<ul>
  <li>štandardizované postupy opätovného odoslania,</li>
  <li>jasné rozdelenie zodpovednosti medzi centrami,</li>
  <li>sledovanie času od zlyhania štepu po nové vyšetrenie,</li>
  <li>lepší prístup k programom párovej výmeny,</li>
  <li>transparentné kritériá zaradenia,</li>
  <li>dostupná psychologická a sociálna podpora.</li>
</ul>

<h3>Transplantačný program</h3>

<ul>
  <li>začať hodnotenie ešte pred definitívnym zlyhaním štepu,</li>
  <li>určiť koordinátora opakovanej transplantácie,</li>
  <li>poskytovať edukáciu špecifickú pre retransplantáciu,</li>
  <li>pravidelne hodnotiť senzibilizáciu,</li>
  <li>vytvoriť multidisciplinárny plán pri neadherencii,</li>
  <li>zapojiť psychológa, sociálneho pracovníka a farmaceuta.</li>
</ul>

<h3>Pacient a rodina</h3>

<ul>
  <li>zrozumiteľne vysvetliť možnosti živého darcovstva vrátane párovej výmeny,</li>
  <li>umožniť opakované rozhovory, nie jednorazové poučenie,</li>
  <li>podporiť pacienta pri komunikácii s potenciálnymi darcami,</li>
  <li>rešpektovať odmietnutie bez nátlaku,</li>
  <li>pomôcť s praktickou navigáciou systémom.</li>
</ul>

<h2>Aké dôkazy tieto zdroje prinášajú a aké nie</h2>

<h3>Pacientsky komentár nie je klinická štúdia</h3>

<p>Text Kimberly Brown Marsh je osobná perspektíva jednej pacientky. Nie je zdrojom epidemiologických odhadov, porovnania liečebných stratégií ani všeobecných klinických odporúčaní. Jeho hodnota je iná: ukazuje, ako sa bariéry identifikované výskumníkmi prejavujú v živote konkrétneho človeka.</p>

<p>Údaje o 32-ročnom fungovaní tretieho štepu, predchádzajúcich transfúziách, štvorročnej hemodialýze a onkologickom ochorení sú autorkinou osobnou výpoveďou. Neboli predmetom nezávislého klinického overenia a nemožno ich zovšeobecňovať.</p>

<h3>Kvalitatívna štúdia neurčuje početnosť javov</h3>

<p>Kvalitatívna štúdia môže identifikovať témy a vysvetliť ich význam, nemôže však určiť, aký podiel pacientov je odmietnutý pre senzibilizáciu, o koľko sa predlžuje čakanie pri slabej koordinácii, ktorá intervencia počet opakovaných transplantácií zvyšuje, či psychologická podpora zlepšuje prežívanie štepu ani či živé darcovstvo vedie v tejto skupine k lepším výsledkom. Na takéto otázky sú potrebné registre, prospektívne kohorty alebo intervenčné štúdie.</p>

<h3>Výber účastníkov</h3>

<p>Pacienti a opatrovatelia ochotní zúčastniť sa rozhovoru môžu mať iné skúsenosti než tí, ktorí sa výskumu nezúčastnili — môžu byť aktívnejší, zdravotne gramotnejší alebo mať mimoriadne pozitívnu či negatívnu skúsenosť. Cielený výber a metóda snehovej gule, ktoré autori použili, sú pre kvalitatívny výskum primerané, ale reprezentatívnu vzorku nezaručujú. Podobne názory 11 transplantačných nefrológov nemusia reprezentovať všetkých poskytovateľov, chirurgov, koordinátorov, sociálnych pracovníkov a pracovníkov dialyzačných stredísk.</p>

<h3>Prenositeľnosť na slovenské podmienky</h3>

<p>Štúdia prebehla v kanadskom transplantačnom systéme. Organizácia čakacej listiny, financovanie, párová výmena, dostupnosť žijúcich darcov a zodpovednosť jednotlivých pracovísk sa môžu od slovenských podmienok líšiť. Základné problémy — senzibilizácia, komorbidity, psychologická záťaž a potreba koordinácie — sú však klinicky relevantné aj v európskom prostredí.</p>

<h2>Praktický postup pri zhoršovaní funkcie štepu</h2>

<ol>
  <li>Potvrdiť príčinu a rýchlosť poklesu funkcie štepu.</li>
  <li>Posúdiť liečiteľné príčiny vrátane rejekcie, obštrukcie a liekovej toxicity.</li>
  <li>Aktualizovať HLA protilátkový profil.</li>
  <li>Prediskutovať prognózu štepu s pacientom.</li>
  <li>Začať nové transplantačné vyšetrenie ešte pred návratom na dialýzu.</li>
  <li>Identifikovať potenciálnych žijúcich darcov.</li>
  <li>Posúdiť možnosť párovej výmeny.</li>
  <li>Zhodnotiť adherenciu a odstrániteľné prekážky.</li>
  <li>Rozhodnúť o ďalšom vedení imunosupresie.</li>
  <li>Pripraviť alternatívny dialyzačný plán vrátane cievneho prístupu.</li>
  <li>Poskytnúť psychologickú a sociálnu podporu.</li>
  <li>Zabezpečiť jednoznačnú zodpovednosť za koordináciu.</li>
</ol>

<h2>Záver</h2>

<p>Opakovaná transplantácia obličky po zlyhaní štepu je medicínsky, imunologicky, psychologicky aj organizačne náročný proces. Kvalitatívna štúdia identifikovala štyri hlavné prekážky — vysokú protilátkovú senzibilizáciu s nedostatkom kompatibilných darcov, komorbidity vedúce k nespôsobilosti alebo vyradeniu z listiny, anamnézu neadherencie a oneskorené odoslanie so zlou koordináciou vyšetrení. Pri žijúcom darcovi sa pridávajú ďalšie štyri: preferencia zomretého darcu, pocit vyčerpaného okruhu darcov, psychologická záťaž po strate predchádzajúceho štepu a štrukturálne bariéry živého darcovstva.</p>

<p>Osobná skúsenosť pacientky po troch transplantáciách ukazuje, že laboratórne hodnoty, cPRA a čakací čas zachytávajú iba časť reality. Rozhoduje aj schopnosť systému pripraviť pacienta včas, koordinovať vyšetrenia, riešiť sociálne a psychologické bariéry a ponúknuť realistické možnosti vrátane párovej výmeny.</p>

<p>Najpraktickejším opatrením je začať plánovať opakovanú transplantáciu <strong>ešte pred definitívnym zlyhaním štepu</strong>. Pacient sa nemá po návrate na dialýzu stratiť medzi transplantačným centrom a dialyzačným pracoviskom.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=transplantacia-oblicky-zaradenie-do-programu">Ako prebieha zaradenie do transplantačného programu na transplantáciu obličky</a></li>
  <li><a href="article.php?slug=teclistamab-pred-transplantaciou-oblicky-hla-senzibilizacia">Teclistamab pred transplantáciou obličky: prvý klinický signál pri extrémnej HLA senzibilizácii</a></li>
  <li><a href="article.php?slug=preemptivna-transplantacia-optimalny-sposob-nahrady-funkcie-ledvin">Preemptívna transplantácia – optimálny spôsob náhrady funkcie obličiek</a></li>
  <li><a href="article.php?slug=styridsat-rokov-transplantat-oblicky-ultra-dlhodobe-prezivanie">Štyridsať rokov s funkčným transplantátom obličky: čo ukazujú ultra-dlhodobí prežívajúci</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Marsh KB. Beyond the Numbers: A Three-Time Kidney Transplant Recipient's Perspective on Barriers to Re-Transplantation. Clinical Journal of the American Society of Nephrology. 2026. doi: 10.2215/CJN.0000001228. PMID 42709610. <a href="https://pubmed.ncbi.nlm.nih.gov/42709610/" target="_blank" rel="noopener noreferrer">PubMed</a>. Osobný komentár pacientky, nie pôvodná klinická štúdia; hlavný spracovaný zdroj.</em></small></li>
  <li><small><em>Slominska AM, Gouin-Bonenfant M, Katz E, Gaudio K, Sterling-Eilok T, El Wazze S, Shamseddin MK, Bugeja A, Fortin MC, Ho J, Lam NN, Cantarovich M, Kinsella EA, Sandal S. A Qualitative Study of Patients, Caregivers, and Providers on Barriers to Kidney Retransplantation following Graft Loss. Clinical Journal of the American Society of Nephrology. 2026. doi: 10.2215/CJN.0000001162. PMID 42485104. <a href="https://pubmed.ncbi.nlm.nih.gov/42485104/" target="_blank" rel="noopener noreferrer">PubMed</a>. Kvalitatívna štúdia, na ktorú komentár reaguje.</em></small></li>
  <li><small><em>Chadban SJ, Ahn C, Axelrod DA, Foster BJ, Kasiske BL, Kher V, Kumar D, Oberbauer R, Pascual J, Pilmore HL, Rodrigue JR, Segev DL, Sheerin NS, Tinckam KJ, Wong G, Knoll GA. KDIGO Clinical Practice Guideline on the Evaluation and Management of Candidates for Kidney Transplantation. Transplantation. 2020;104(4S1 Suppl 1):S11–S103. doi: 10.1097/TP.0000000000003136. PMID 32301874. <a href="https://pubmed.ncbi.nlm.nih.gov/32301874/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://kdigo.org/guidelines/transplant-candidate/" target="_blank" rel="noopener noreferrer">stránka odporúčania</a>.</em></small></li>
  <li><small><em>Chadban SJ, Ahn C, Axelrod DA, a spol. Summary of the Kidney Disease: Improving Global Outcomes (KDIGO) Clinical Practice Guideline on the Evaluation and Management of Candidates for Kidney Transplantation. Transplantation. 2020;104(4):708–714. doi: 10.1097/TP.0000000000003137. PMID 32224812. <a href="https://pubmed.ncbi.nlm.nih.gov/32224812/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7147399/" target="_blank" rel="noopener noreferrer">plný text v PMC</a>. Zhrnutie má 20 autorov, oproti plnému odporúčaniu je rozšírené o metodický tím.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_retransplantacia-obliciek-po-zlyhani-stepu-prekazky_article',
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
