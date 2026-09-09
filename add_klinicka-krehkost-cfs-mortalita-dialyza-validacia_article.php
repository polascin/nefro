<?php
/**
 * Odborný článok: Škála klinickej krehkosti (CFS) ako prognostický nástroj u dialyzovaných pacientov.
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
    'title'        => 'Krehkosť hodnotená sestrou predpovedá mortalitu na dialýze: multicentrická validácia škály klinickej krehkosti',
    'slug'         => 'klinicka-krehkost-cfs-mortalita-dialyza-validacia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Vo francúzskej kohorte 792 dialyzovaných pacientov rástla 24-mesačná mortalita od 9,8 % u zdatných po 45,9 % u krehkých. Škála klinickej krehkosti hodnotená sestrami mala prognostickú výkonnosť porovnateľnú s komorbiditným skóre.',
    'content'      => <<<'HTML'
<p>Krehkosť je stav zníženej fyziologickej rezervy a zvýšenej zraniteľnosti voči záťaži. U dialyzovaných pacientov je veľmi častá a spája sa s horšími výsledkami, jej rutinné hodnotenie však v praxi naráža na čas a personálne kapacity. Prospektívna multicentrická kohortová štúdia zo šiestich dialyzačných stredísk v severovýchodnom Francúzsku, publikovaná v časopise <em>Kidney Medicine</em>, preto overovala, či je uskutočniteľné a prognosticky prínosné, keď krehkosť hodnotí <strong>dialyzačná sestra</strong> pomocou škály klinickej krehkosti (<em>Clinical Frailty Scale</em>, CFS).</p>

<p>Do súboru bolo zaradených 792 prevalentných dospelých pacientov na udržiavacej dialýze. Krehkosť podľa CFS bola nezávisle spojená s celkovou mortalitou a jej diskriminačná schopnosť bola porovnateľná s komorbiditným skóre REIN Predictive Score (RPS), ktoré je vo francúzskej dialyzačnej praxi bežne dostupné. CFS pritom prinášala prognostickú informáciu <em>nad rámec</em> komorbidít, nie namiesto nich.</p>

<h2>Prečo krehkosť pri chorobe obličiek</h2>

<p>U pacientov s pokročilou chronickou chorobou obličiek sa na vzniku krehkosti podieľa vyšší vek, chronický zápal, metabolická acidóza, anémia, proteínovo-energetická malnutrícia, sarkopénia, poruchy minerálového a kostného metabolizmu, kardiovaskulárne ochorenia, polyfarmácia, opakované hospitalizácie aj samotná záťaž dialyzačnej liečby.</p>

<p>Krehkosť nie je synonymom vysokého veku, komorbidity, invalidity ani nevyliečiteľného ochorenia, hoci sa tieto stavy často prekrývajú. Jej klinický význam nespočíva len v prognóze: rozpoznanie krehkosti môže zmeniť liečebné ciele, viesť k rehabilitácii, nutričnej podpore, prevencii pádov a k včasnému plánovaniu budúcej starostlivosti.</p>

<h2>Škála klinickej krehkosti</h2>

<p>CFS je deväťbodová klinická škála, ktorú v roku 2005 predstavili Rockwood a spolupracovníci v rámci Kanadskej štúdie zdravia a starnutia. Hodnotí sa podľa funkčnej schopnosti, mobility, závislosti od pomoci pri bežných denných činnostiach a celkového zdravotného stavu — nie podľa veku ani počtu diagnóz.</p>

<div class="table-responsive" role="region" aria-label="Kategórie škály klinickej krehkosti použité v štúdii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória v štúdii</th>
      <th scope="col">Rozsah CFS</th>
      <th scope="col">Klinický obsah</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Zdatní</th>
      <td>1 až 3</td>
      <td>Veľmi zdatný, zdravý alebo dobre kompenzovaný pacient, ktorý zvláda bežné aktivity bez pomoci</td>
    </tr>
    <tr>
      <th scope="row">Zraniteľní</th>
      <td>4 až 5</td>
      <td>Zraniteľný alebo mierne krehký pacient; príznaky obmedzujú aktivitu, môže potrebovať pomoc pri náročnejších denných činnostiach</td>
    </tr>
    <tr>
      <th scope="row">Krehkí</th>
      <td>6 až 9</td>
      <td>Stredne až veľmi ťažko krehký pacient, veľmi ťažko chorý alebo terminálne chorý</td>
    </tr>
  </tbody>
</table>
</div>

<p>Pri hodnotení dialyzovaného pacienta treba posudzovať jeho <strong>obvyklý stav pred akútnym zhoršením</strong>. Hospitalizácia, bezprostredné postdialyzačné vyčerpanie alebo prechodná infekcia môžu skóre neprimerane zvýšiť.</p>

<h2>Usporiadanie štúdie</h2>

<p>Išlo o prospektívnu multicentrickú observačnú kohortu 792 prevalentných dospelých pacientov na udržiavacej dialýze v šiestich strediskách v severovýchodnom Francúzsku. Podľa sekundárneho spracovania štúdie v odbornom spravodajstve prebiehal zber údajov v rokoch 2016 až 2020, priemerný vek bol 69 rokov a muži tvorili 57,7 % súboru; tieto údaje nie sú súčasťou verejne dostupného súhrnu primárnej práce.</p>

<p>CFS stanovili jedenkrát vyškolené dialyzačné sestry. Skóre sa analyzovalo dvoma spôsobmi:</p>

<ol>
  <li>ako <strong>spojitá premenná</strong>, teda na každý jeden bod zvýšenia,</li>
  <li>ako <strong>tri vopred určené kategórie</strong> — zdatní (1 – 3), zraniteľní (4 – 5), krehkí (6 – 9).</li>
</ol>

<p>Sledovaným výsledkom bola celková mortalita po 12 a 24 mesiacoch. <strong>Transplantácia obličky sa hodnotila ako konkurenčná udalosť</strong>, nie ako obyčajné cenzorovanie. Tento postup je metodologicky správnejší, pretože transplantácia mení následné riziko úmrtia a jednoduché cenzorovanie by kumulatívnu incidenciu úmrtia v dialyzačnej kohorte skresľovalo.</p>

<p>Kumulatívne incidencie úmrtia a transplantácie sa odhadovali metódami pre konkurenčné riziká. Asociácie s mortalitou sa hodnotili <strong>Fineovým a Grayovým modelom subdistribučného hazardu</strong>, upraveným o vek, pohlavie, diabetes a používanie centrálneho venózneho katétra; CFS a RPS boli v modeli zahrnuté súčasne, takže sa vzájomne upravovali. Diskriminácia sa vyjadrila C-štatistikou po 12 a 24 mesiacoch.</p>

<h3>Čo je REIN Predictive Score</h3>

<p>RPS je komorbiditné skóre odvodené z francúzskeho registra REIN. Pôvodne ho odvodili Couchoud a spolupracovníci na predpoveď <em>šesťmesačnej</em> prognózy u <em>starších pacientov začínajúcich</em> dialýzu. V tejto štúdii sa použil ako referenčný komparátor u prevalentnej dialyzačnej populácie bez vekového obmedzenia — teda mimo pôvodného odvodzovacieho kontextu. Pri porovnávaní výkonnosti oboch nástrojov je to podstatné: časť rozdielu môže odrážať odlišnú cieľovú populáciu, nie iba vlastnosti samotného skóre.</p>

<h2>Zhoda medzi hodnotiteľkami</h2>

<p>U podskupiny 509 pacientov určili CFS dve nezávislé dialyzačné sestry. Pri zoskupení do troch kategórií bola zhoda stredná, kappa = 0,60.</p>

<p>Hodnota pre celú deväťbodovú škálu vo verejne dostupnom súhrne uvedená nie je. Samotná formulácia autorov („zhoda bola stredná, keď sa skóre zoskupilo do troch kategórií“) však naznačuje, že pri rozlišovaní jednotlivých susedných bodov bola nižšia. To zodpovedá aj všeobecnej skúsenosti s ordinálnymi klinickými škálami: rozdiel medzi CFS 5 a CFS 6 býva medzi hodnotiteľmi neistý, zatiaľ čo zaradenie pacienta do širšej kategórie je reprodukovateľnejšie.</p>

<p>Praktický dôsledok je jednoznačný. CFS nie je úplne objektívne meranie. Jej spoľahlivosť závisí od skúsenosti hodnotiteľa, kvality rozhovoru, dostupnosti údajov od pacienta a rodiny a od toho, či sa posudzuje obvyklý stav, alebo aktuálna akútna choroba. Pre klinické rozhodovanie sú preto vhodnejšie tri širšie kategórie než jednotlivé body.</p>

<h2>Mortalita rástla stupňovito s kategóriou krehkosti</h2>

<div class="table-responsive" role="region" aria-label="Kumulatívna incidencia úmrtia podľa kategórie krehkosti" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória CFS</th>
      <th scope="col">Kumulatívna mortalita po 12 mesiacoch</th>
      <th scope="col">Kumulatívna mortalita po 24 mesiacoch</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Zdatní (CFS 1 – 3)</th>
      <td>3,56 %</td>
      <td>9,78 %</td>
    </tr>
    <tr>
      <th scope="row">Zraniteľní (CFS 4 – 5)</th>
      <td>10,49 %</td>
      <td>21,30 %</td>
    </tr>
    <tr>
      <th scope="row">Krehkí (CFS 6 – 9)</th>
      <td>27,27 %</td>
      <td>45,87 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Rozdiel medzi krajnými kategóriami bol veľký: po dvoch rokoch zomrelo takmer 46 % krehkých pacientov oproti necelým 10 % zdatných. Ide však o kumulatívne riziká celých skupín, nie o prognózu konkrétneho pacienta. Individuálny odhad musí zohľadniť vek, komorbidity, nutričný stav, typ dialýzy, priebeh hospitalizácií, možnosť transplantácie a preferencie pacienta.</p>

<h2>CFS pridávala informáciu nad rámec komorbidít</h2>

<p>V multivariabilnom modeli boli s mortalitou nezávisle spojené obe skóre:</p>

<ul>
  <li>vyššia CFS: subdistribučný pomer hazardu <strong>1,33 na jeden bod</strong>, 95 % interval spoľahlivosti 1,19 – 1,49;</li>
  <li>vyššie RPS: subdistribučný pomer hazardu <strong>1,05 na jeden bod</strong>, 95 % interval spoľahlivosti 1,02 – 1,09.</li>
</ul>

<p>Keďže boli obe premenné v modeli súčasne, výsledok znamená, že <strong>funkčná krehkosť nesie prognostickú informáciu, ktorú samotný počet a závažnosť komorbidít nezachytí</strong>. Dvaja pacienti s podobným komorbiditným skóre môžu mať rozdielnu prognózu v závislosti od mobility, sebestačnosti, výživy a celkovej funkčnej rezervy.</p>

<p>Subdistribučný pomer hazardu treba interpretovať ako vzťah medzi CFS a kumulatívnou incidenciou úmrtia pri súčasnom zohľadnení transplantácie ako konkurenčnej udalosti. Nejde o pomer rizík z klasickej Coxovej regresie a obe veličiny sa nemajú zamieňať.</p>

<h2>Diskriminačná schopnosť bola porovnateľná</h2>

<div class="table-responsive" role="region" aria-label="C-štatistika pre CFS a REIN Predictive Score" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Nástroj</th>
      <th scope="col">C-štatistika po 12 mesiacoch</th>
      <th scope="col">C-štatistika po 24 mesiacoch</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">CFS</th>
      <td>0,73 (95 % IS 0,68 – 0,79)</td>
      <td>0,71 (95 % IS 0,66 – 0,75)</td>
    </tr>
    <tr>
      <th scope="row">REIN Predictive Score</th>
      <td>0,69 (95 % IS 0,63 – 0,75)</td>
      <td>0,67 (95 % IS 0,62 – 0,72)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Bodové odhady sú pre CFS mierne vyššie, <strong>intervaly spoľahlivosti sa však výrazne prekrývajú</strong>. Korektný záver preto znie, že výkonnosť oboch nástrojov bola porovnateľná — nie že CFS je nadradená. Autori sami formulujú výsledok ako výkonnosť „porovnateľnú s komorbiditným skóre a od neho nezávislú“.</p>

<p>C-štatistika navyše hodnotí len to, ako dobre model zoradí pacientov podľa rizika. Nehovorí nič o kalibrácii, o klinickej užitočnosti ani o tom, či používanie nástroja zlepší výsledky liečby. <strong>Hodnota 0,71 neznamená 71-percentnú pravdepodobnosť prežitia.</strong> Nástroj s dobrou diskrimináciou môže viesť k nesprávnym rozhodnutiam, ak sa jeho výsledok mechanicky použije na odmietnutie transplantácie, ukončenie dialýzy alebo obmedzenie liečby.</p>

<h2>Exploračný prah CFS 6</h2>

<p>Skóre CFS najmenej 6 identifikovalo skupinu so zvýšenou 12-mesačnou mortalitou. Autori tento nález výslovne označujú za <strong>exploračný</strong> a v závere upozorňujú, že pred použitím konkrétnych deliacich bodov na rozhodovanie o liečbe je potrebná externá validácia.</p>

<p>Prakticky môže prah slúžiť ako spúšťač doplňujúceho hodnotenia, nie ako rozhodovacia hranica. U pacienta s CFS 6 a viac je vhodné zvážiť:</p>

<ul>
  <li>komplexné geriatrické vyšetrenie,</li>
  <li>nutričné hodnotenie a cielenú podporu príjmu bielkovín a energie,</li>
  <li>posúdenie mobility a rizika pádu,</li>
  <li>revíziu liekov,</li>
  <li>rozhovor o cieľoch liečby a plánovanie budúcej starostlivosti,</li>
  <li>psychosociálnu podporu.</li>
</ul>

<p>Nejde o biologický zlom. CFS je ordinálna škála a riziko rastie plynulo; pacient s CFS 5 môže mať podobnú prognózu ako niektorý pacient s CFS 6 a naopak.</p>

<h2>Rozdiel medzi krehkosťou a komorbiditou</h2>

<p>Komorbiditné skóre zachytáva prítomnosť a závažnosť vybraných ochorení. Krehkosť zachytáva ich <em>funkčný dôsledok</em> a zníženú rezervu organizmu.</p>

<p>Pacient s početnými diagnózami, ktorý je stále mobilný a sebestačný, môže mať lepšiu prognózu než pacient s menším počtom diagnóz, ktorý je odkázaný na pomoc pri každodenných činnostiach, má nízku mobilitu a opakované pády. Obe dimenzie sa preto nemajú zamieňať a najlepšia prognostická informácia vzniká ich kombináciou — spolu s nutričnými ukazovateľmi, kogníciou a sociálnym zázemím.</p>

<h2>Klinické využitie v dialyzačnej praxi</h2>

<h3>Plánovanie liečby</h3>

<p>Krehkosť môže ovplyvniť toleranciu hemodialýzy, zotavenie po hospitalizácii aj schopnosť zvládnuť komplikácie. Informácia o funkčnom stave môže pomôcť pri voľbe medzi domácou a strediskovou liečbou, pri plánovaní peritoneálnej dialýzy a pri nastavovaní podpory rodiny či komunitných služieb.</p>

<h3>Transplantácia</h3>

<p>CFS môže dopĺňať hodnotenie kandidáta na transplantáciu, nemá však nahrádzať transplantologické vyšetrenie. Krehkosť môže byť do určitej miery ovplyvniteľná a jej prítomnosť nie je automatickým dôvodom na vyradenie pacienta z transplantačného procesu.</p>

<h3>Rehabilitácia a nutričná liečba</h3>

<p>Vyššie skóre môže identifikovať pacienta, ktorý potrebuje cielený pohybový program, podporu príjmu bielkovín a energie, liečbu anémie, korekciu acidózy alebo revíziu dialyzačnej adekvátnosti. Každý zásah treba prispôsobiť celkovému stavu a riziku sarkopénie.</p>

<h3>Plánovanie budúcej starostlivosti</h3>

<p>Krehkosť je relevantná pri rozhovore o preferenciách pacienta, o rozsahu invazívnej liečby, o hospitalizácii a resuscitácii, o možnom konzervatívnom postupe aj o pokračovaní či ukončení dialýzy v závere života. <strong>CFS sama osebe neindikuje ukončenie dialýzy.</strong> Má podporiť otvorený a včasný rozhovor, nie nahradiť individuálne rozhodovanie.</p>

<h2>Obmedzenia štúdie</h2>

<h3>Prevalentná, nie incidentná kohorta</h3>

<p>Zaradení boli pacienti, ktorí už dialýzu dostávali. Pacienti, ktorí zomreli krátko po jej začatí alebo ju netolerovali, sa v takejto kohorte nemusia nachádzať — ide o skreslenie prežitím. Výsledky preto nemožno automaticky preniesť na pacientov tesne pred začatím dialýzy ani na prvé mesiace liečby.</p>

<h3>Jeden región a chýbajúce údaje o pôvode</h3>

<p>Štúdia prebehla v šiestich strediskách jedného francúzskeho regiónu. Sociálne podmienky, organizácia dialýzy, dostupnosť transplantácie a veková štruktúra pacientov sa v iných krajinách môžu líšiť. Autori tiež uvádzajú, že etnický pôvod sa systematicky nezaznamenával, čo obmedzuje posúdenie prenositeľnosti výsledkov.</p>

<h3>Jednorazové hodnotenie</h3>

<p>Krehkosť je dynamický stav. Jediné hodnotenie nezachytáva, či sa pacient neskôr zlepšil po rehabilitácii, alebo naopak rýchlo funkčne upadal. Opakované meranie môže byť klinicky užitočnejšie, hoci optimálny interval opakovania u dialyzovaných pacientov stanovený nie je.</p>

<h3>Neštandardizované načasovanie</h3>

<p>Čas hodnotenia CFS vo vzťahu k dialyzačnej procedúre nebol medzi centrami štandardizovaný — autori to uvádzajú ako obmedzenie. Hodnotenie bezprostredne po dialýze môže byť ovplyvnené únavou, postdialyzačnou hypotenziou alebo krátkodobou slabosťou.</p>

<h3>Obmedzená reprodukovateľnosť pri deviatich bodoch</h3>

<p>Lepšia zhoda po zoskupení do troch kategórií podporuje používanie širších klinických kategórií, súčasne však znižuje rozlišovaciu jemnosť nástroja. Ide o kompromis medzi spoľahlivosťou a granularitou.</p>

<h3>Asociácia, nie kauzalita</h3>

<p>Štúdia preukázala prognostickú asociáciu. Neodpovedá na otázku, či zníženie krehkosti rehabilitáciou, nutričnou liečbou alebo úpravou dialýzy mortalitu skutočne zníži. To by vyžadovalo intervenčnú štúdiu.</p>

<h2>Ako CFS používať rozumne</h2>

<ol>
  <li>Hodnotiť obvyklý stav pacienta pred aktuálnym akútnym ochorením.</li>
  <li>Získať údaje od pacienta aj od rodiny alebo opatrovateľa.</li>
  <li>Posúdiť mobilitu a závislosť pri bežných denných činnostiach, nie vek a počet diagnóz.</li>
  <li>Zaznamenať dôvody prideleného skóre, aby bolo hodnotenie preskúmateľné.</li>
  <li>Používať rovnakú oficiálnu verziu škály a jednotnú metodiku vo všetkých strediskách.</li>
  <li>Zabezpečiť školenie hodnotiteľov — v štúdii hodnotili vyškolené sestry.</li>
  <li>Pracovať prednostne s tromi širšími kategóriami, ktoré sú reprodukovateľnejšie než jednotlivé body.</li>
  <li>Pri vyššom skóre doplniť komplexnejšie geriatrické, nutričné a funkčné vyšetrenie.</li>
  <li>Opakovať hodnotenie pri významnej zmene zdravotného stavu.</li>
  <li>Nepoužívať skóre ako jediný dôvod na odmietnutie liečby alebo transplantácie.</li>
</ol>

<p>CFS je skríningový a prognostický nástroj, nie diagnostický test s absolútnou hranicou.</p>

<h2>Záver</h2>

<p>V prospektívnej multicentrickej kohorte 792 dialyzovaných pacientov bola vyššia krehkosť podľa CFS spojená so stupňovito vyššou mortalitou. Po 24 mesiacoch dosiahla kumulatívna incidencia úmrtia 9,78 % u zdatných, 21,30 % u zraniteľných a 45,87 % u krehkých pacientov.</p>

<p>Každý bod CFS bol spojený so subdistribučným pomerom hazardu 1,33 (95 % interval spoľahlivosti 1,19 – 1,49) a asociácia pretrvala aj po zohľadnení komorbiditného skóre REIN, ktoré bolo v tom istom modeli tiež nezávisle spojené s mortalitou. Diskriminačná schopnosť oboch nástrojov bola porovnateľná, so vzájomne sa prekrývajúcimi intervalmi spoľahlivosti. Zhoda medzi sestrami bola stredná pri troch širších kategóriách.</p>

<p>Výsledky podporujú pravidelné hodnotenie funkčného stavu priamo v dialyzačných strediskách a ukazujú, že ho zvládnu vyškolené sestry. CFS však treba používať ako súčasť komplexného, opakovaného a na pacienta orientovaného hodnotenia, nie na mechanické rozhodovanie o pokračovaní dialýzy, o transplantácii alebo o rozsahu liečby. Autori sami považujú konkrétne deliace body za predbežné, kým ich nepotvrdí externá validácia.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=krehkost-negeriatricki-dialyzovani-pacienti-frail-skala">Krehkosť u dialyzovaných pacientov mladších než 65 rokov: čo prináša prierezová štúdia z Tbilisi</a></li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Frailty pri chronickej chorobe obličiek: prečo nestačí sledovať iba eGFR</a></li>
  <li><a href="article.php?slug=paliativna-starostlivost-nefrologia-krehki-starsi-eskd">Paliatívna starostlivosť v rutinnej nefrológii: nástroje s nízkym prahom pre krehkých a starších pacientov</a></li>
  <li><a href="article.php?slug=sarkopenia-peritonealna-dialyza-modifikovany-kreatininovy-index">Sarkopénia pri peritoneálnej dialýze: prečo modifikovaný kreatinínový index nestačí</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Ingwiller M, Chantrel F, Krummel T, Muller C, Dimitrov Y, Honoré N, Brokhès-Le Calvez S, Hannedouche T. Frailty as a Predictor of Mortality in Dialysis: A Multicenter Validation of the Clinical Frailty Scale. Kidney Medicine. 2026:101510. doi: 10.1016/j.xkme.2026.101510. <a href="https://doi.org/10.1016/j.xkme.2026.101510" target="_blank" rel="noopener noreferrer">plný text (otvorený prístup)</a>. Hlavný spracovaný zdroj.</em></small></li>
  <li><small><em>Rockwood K, Song X, MacKnight C, Bergman H, Hogan DB, McDowell I, Mitnitski A. A global clinical measure of fitness and frailty in elderly people. Canadian Medical Association Journal. 2005;173(5):489–495. doi: 10.1503/cmaj.050051. PMID 16129869. <a href="https://pubmed.ncbi.nlm.nih.gov/16129869/" target="_blank" rel="noopener noreferrer">PubMed</a>. Pôvodná práca, ktorá zaviedla škálu klinickej krehkosti.</em></small></li>
  <li><small><em>Couchoud C, Labeeuw M, Moranne O, Allot V, Esnault V, Frimat L, Stengel B; French Renal Epidemiology and Information Network (REIN) registry. A clinical score to predict 6-month prognosis in elderly patients starting dialysis for end-stage renal disease. Nephrology Dialysis Transplantation. 2009;24(5):1553–1561. doi: 10.1093/ndt/gfn698. PMID 19096087. <a href="https://pubmed.ncbi.nlm.nih.gov/19096087/" target="_blank" rel="noopener noreferrer">PubMed</a>. Odvodenie komorbiditného skóre REIN.</em></small></li>
  <li><small><em>Alfaadhel TA, Soroka SD, Kiberd BA, Landry D, Moorhouse P, Tennankore KK. Frailty and mortality in dialysis: evaluation of a clinical frailty scale. Clinical Journal of the American Society of Nephrology. 2015;10(5):832–840. doi: 10.2215/CJN.07760814. PMID 25739851. <a href="https://pubmed.ncbi.nlm.nih.gov/25739851/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Puri A, Lloyd AM, Bello AK, Tonelli M, Campbell SM, Tennankore K, Davison SN, Thompson S. Frailty Assessment Tools in Chronic Kidney Disease: A Systematic Review and Meta-analysis. Kidney Medicine. 2025;7(3):100960. doi: 10.1016/j.xkme.2024.100960. PMID 39980935. <a href="https://pubmed.ncbi.nlm.nih.gov/39980935/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Church S, Rogers E, Rockwood K, Theou O. A scoping review of the Clinical Frailty Scale. BMC Geriatrics. 2020;20(1):393. doi: 10.1186/s12877-020-01801-7. PMID 33028215. <a href="https://pubmed.ncbi.nlm.nih.gov/33028215/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Lamberink K, Vermeeren YM, Moes AD, Mulderij J, Rootjes PA, Zomer TP. Usefulness of the Clinical Frailty Scale in patients with end-stage kidney disease. Clinical Kidney Journal. 2024;17(7):sfae132. doi: 10.1093/ckj/sfae132. PMID 39015837. <a href="https://pubmed.ncbi.nlm.nih.gov/39015837/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Nixon AC, Bampouras TM, Pendleton N, Mitra S, Dhaygude AP. Diagnostic Accuracy of Frailty Screening Methods in Advanced Chronic Kidney Disease. Nephron. 2019;141(3):147–155. doi: 10.1159/000494223. PMID 30554199. <a href="https://pubmed.ncbi.nlm.nih.gov/30554199/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Drost D, Kalf A, Vogtlander N, van Munster BC. High prevalence of frailty in end-stage renal disease. International Urology and Nephrology. 2016;48(8):1357–1362. doi: 10.1007/s11255-016-1306-z. PMID 27165401. <a href="https://pubmed.ncbi.nlm.nih.gov/27165401/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Nurse-Rated Frailty Score Can Predict Mortality in Patients Undergoing Dialysis. Medscape Medical News, 2026 (redakčné spracovanie primárnej štúdie; autor v dostupnej verzii neuvedený). <a href="https://www.medscape.com/viewarticle/nurse-rated-frailty-score-can-predict-mortality-patients-2026a1000v82" target="_blank" rel="noopener noreferrer">Medscape</a>. Zdroj údajov o období zberu, priemernom veku a zastúpení pohlaví.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_klinicka-krehkost-cfs-mortalita-dialyza-validacia_article',
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
