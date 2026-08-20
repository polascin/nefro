<?php
/**
 * Odborny clanok: diagnostika ADHD u dospelych - diferencialna diagnostika a nefrologicke suvislosti.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_diagnostika-adhd-dospeli-diferencialna-diagnostika_article.php"
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
    'title'        => 'Diagnostika ADHD u dospelých: čo je potrebné, aby sa rozptýlenosť nezamenila za diagnózu',
    'slug'         => 'diagnostika-adhd-dospeli-diferencialna-diagnostika',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'ADHD v dospelosti sa nedá potvrdiť ani vylúčiť na základe nepozornosti. Skríningová škála ASRS má senzitivitu iba 68,7 %, takže negatívny výsledok diagnózu nevylučuje. Pri chronickej chorobe obličiek treba navyše zvážiť medicínske príčiny poruchy pozornosti.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Dospelí s podozrením na ADHD opisujú nepozornosť, zabúdanie, ťažkosti s organizáciou, vnútorný nepokoj alebo impulzivitu. Samotná nepozornosť však diagnózu nezakladá. ADHD je neurovývinová porucha definovaná trvalým vzorcom príznakov s funkčným dopadom vo viacerých prostrediach a s nutnosťou odlíšiť iné medicínske, psychiatrické a environmentálne príčiny. Posudzovacie škály hodnotenie podporujú — nenahrádzajú ho.</em></p>

<h2>Prečo je téma dôležitá aj pre nefrológa</h2>

<p>Porucha pozornosti s hyperaktivitou (ADHD; v staršej terminológii MKCH-10 hyperkinetická porucha) sa v dospelosti diagnostikuje čoraz častejšie. Rastie aj počet pacientov, ktorí prichádzajú s vlastným podozrením — často po obsahu na sociálnych sieťach.</p>

<p>Pre nefrológiu je téma relevantná z dvoch strán. Po prvé, <strong>porucha pozornosti je pri chronickej chorobe obličiek (CKD) častá a má viacero medicínskych príčin</strong>, ktoré sa dajú liečiť. Po druhé, ak sa ADHD potvrdí, jeho farmakoterapia zasahuje do krvného tlaku a srdcovej frekvencie — teda presne do parametrov, ktoré sú pri CKD kľúčové.</p>

<p>Cieľom článku nie je nahradiť psychiatrické vyšetrenie. Je ním zhrnúť, čo má obsahovať poctivé diagnostické posúdenie a kde sú jeho hranice.</p>

<h2>Čo ADHD v dospelosti je — a čo ním nie je</h2>

<p>Diagnóza podľa DSM-5 nestojí na prítomnosti príznakov, ale na ich <em>vzorci</em>. Vyžaduje sa:</p>

<ul>
  <li>trvalý vzorec nepozornosti a/alebo hyperaktivity a impulzivity,</li>
  <li>príznaky nezodpovedajúce vývinovej úrovni,</li>
  <li>prítomnosť vo <strong>viacerých prostrediach</strong> (práca, domácnosť, vzťahy),</li>
  <li>preukázateľné <strong>funkčné poškodenie</strong>, nie iba subjektívny diskomfort,</li>
  <li>počiatok príznakov v detstve,</li>
  <li>vylúčenie iného vysvetlenia.</li>
</ul>

<p><strong>Klinický obraz sa s vekom mení.</strong> Zjavná hyperaktivita spravidla ustupuje, nepozornosť pretrváva. U dospelých sa hyperaktivita často presúva „dovnútra“ — ako vnútorný nepokoj, ruminácie, neschopnosť udržať pozornosť v rozhovore alebo neznesiteľnosť nečinnosti. Ťažkosti s organizáciou, riadením času a emočnou reguláciou sú typické, ale <em>nešpecifické</em> — vyskytujú sa pri mnohých iných stavoch.</p>

<h2>Diagnostický postup</h2>

<div class="table-responsive" role="region" aria-label="Zložky diagnostického posúdenia ADHD u dospelých" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Zložka</th>
      <th scope="col">Čo má obsahovať</th>
      <th scope="col">Váha v rozhodovaní</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Klinický rozhovor</th>
      <td>aktuálne príznaky, vývinová anamnéza, komorbidity, rodinná anamnéza, funkčné zlyhávanie, kritériá DSM-5</td>
      <td><strong>Základ diagnózy</strong></td>
    </tr>
    <tr>
      <th scope="row">Objektívna anamnéza</th>
      <td>školské vysvedčenia a hodnotenia, zdravotná dokumentácia z detstva, svedectvo rodiča alebo partnera</td>
      <td>Vysoká — najmä pri overovaní počiatku v detstve</td>
    </tr>
    <tr>
      <th scope="row">Posudzovacie škály</th>
      <td>ASRS a podobné nástroje na zmapovanie a kvantifikáciu príznakov</td>
      <td>Podporná — nikdy samostatný dôkaz</td>
    </tr>
    <tr>
      <th scope="row">Štruktúrovaný rozhovor</th>
      <td>DIVA-5 alebo iný nástroj viazaný na kritériá DSM-5</td>
      <td>Zvyšuje konzistentnosť, nenahrádza anamnézu</td>
    </tr>
    <tr>
      <th scope="row">Diferenciálna diagnostika</th>
      <td>psychiatrické, somatické, liekové a spánkové príčiny</td>
      <td><strong>Povinná</strong></td>
    </tr>
    <tr>
      <th scope="row">Neuropsychologické testy</th>
      <td>hodnotenie exekutívnych funkcií</td>
      <td>Doplnková — normálny výsledok ADHD nevylučuje a abnormálny ho nedokazuje</td>
    </tr>
  </tbody>
</table>
</div>

<div class="pdf-avoid-break">
<h2>Posudzovacie škály: čo dokážu a čo nie</h2>

<p>Najpoužívanejším nástrojom je <strong>ASRS</strong> (Adult ADHD Self-Report Scale) vyvinutý pod hlavičkou Svetovej zdravotníckej organizácie. Obsahuje 18 otázok podľa kritérií DSM-IV; z nich šesť tvorí skrátený skríner.</p>

<p>Validačná práca Kesslera a spol. na vzorke 154 respondentov porovnala škálu so zaslepeným klinickým hodnotením:</p>

<div class="table-responsive" role="region" aria-label="Vlastnosti škály ASRS oproti zaslepenému klinickému hodnoteniu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Verzia</th>
      <th scope="col">Senzitivita</th>
      <th scope="col">Špecificita</th>
      <th scope="col">Celková presnosť</th>
      <th scope="col">Kappa</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">6-položkový skríner</th><td>68,7 %</td><td>99,5 %</td><td>97,9 %</td><td>0,76</td></tr>
    <tr><th scope="row">18-položková ASRS</th><td>56,3 %</td><td>98,3 %</td><td>96,2 %</td><td>0,58</td></tr>
  </tbody>
</table>
</div>

<p>Tieto čísla treba čítať pozorne, pretože hovoria niečo dosť iné, než sa bežne predpokladá.</p>

<p><strong>Špecificita je vynikajúca, senzitivita nie.</strong> Pri 99,5 % špecificite je pozitívny skríning silným signálom, že sa oplatí pokračovať v podrobnom vyšetrení. Ale pri senzitivite 68,7 % <em>zhruba tri z desiatich prípadov ADHD skríner nezachytí</em>. Negatívna ASRS teda ADHD <strong>nevylučuje</strong> a nesmie byť dôvodom na ukončenie vyšetrovania u pacienta s presvedčivou anamnézou.</p>

<p>Zhoda pri jednotlivých príznakoch navyše veľmi kolísala (Cohenovo kappa 0,16 až 0,81) — niektoré položky teda merajú to, čo klinik hodnotí, podstatne horšie než iné. Paradoxne skrátený šesťpoložkový skríner prekonal plnú 18-položkovú verziu vo všetkých sledovaných parametroch.</p>

<p>Doplňme dve obmedzenia, ktoré sa v propagácii nástroja strácajú: ASRS je viazaná na kritériá <strong>DSM-IV</strong>, nie DSM-5, a validácia prebehla na komunitnej vzorke s cieleným nadzastúpením osôb, ktoré samy uviedli ADHD v detstve. V populácii s inou pretestovou pravdepodobnosťou budú prediktívne hodnoty iné.</p>
</div>

<h2>Štruktúrované rozhovory: pozor na verziu</h2>

<p><strong>DIVA</strong> (Diagnostic Interview for ADHD in Adults) je semištruktúrovaný rozhovor, ktorý prechádza kritériá DSM položku po položke a pre každú ponúka konkrétne príklady zo života dospelého aj z detstva.</p>

<p>Pri citovaní dôkazov o nástroji však treba rozlišovať verzie:</p>

<ul>
  <li><strong>DIVA 2.0</strong> vychádza z kritérií <strong>DSM-IV</strong>. Práve tejto verzie sa týka najčastejšie citovaná validačná práca (Ramos-Quiroga a spol.) — a išlo o štúdiu na <strong>40 ambulantných pacientoch</strong>, čo je pre posúdenie diagnostickej presnosti veľmi málo.</li>
  <li><strong>DIVA-5</strong> je aktuálna verzia postavená na kritériách <strong>DSM-5</strong>; existujú aj varianty Young DIVA-5 pre deti a dorast a DIVA-5 ID pre osoby s mentálnym postihnutím. Nástroj spravuje nadácia DIVA Foundation a nie je bezplatný.</li>
</ul>

<p>Tvrdenie „DIVA je validovaný nástroj“ je preto presnejšie formulovať ako: <em>DIVA 2.0 bola v malej štúdii validovaná voči kritériám DSM-IV; DIVA-5 je jej aktualizácia podľa DSM-5.</em></p>

<h2>Diferenciálna diagnostika</h2>

<p>Toto je časť, ktorá rozhoduje najviac — a ktorá sa pri rýchlom vyšetrení najčastejšie odbije.</p>

<div class="table-responsive" role="region" aria-label="Stavy, ktoré môžu napodobniť ADHD u dospelých" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Okruh</th>
      <th scope="col">Príklady</th>
      <th scope="col">Rozlišujúci znak</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Afektívne a úzkostné poruchy</th><td>depresia, generalizovaná úzkostná porucha, bipolárna porucha</td><td>epizodický priebeh, ruminácie a anhedónia namiesto celoživotného vzorca</td></tr>
    <tr><th scope="row">Spánok</th><td>spánkové apnoe, nespavosť, syndróm nepokojných nôh, spánková deprivácia</td><td>denná spavosť, chrápanie, zlepšenie po liečbe spánku</td></tr>
    <tr><th scope="row">Látky a lieky</th><td>alkohol, kanabis, stimulanciá, abstinenčné stavy; sedatíva, anticholinergiká, antihistaminiká</td><td>časová súvislosť s expozíciou</td></tr>
    <tr><th scope="row">Somatické príčiny</th><td>anémia, hypotyreóza a hypertyreóza, deficit B12, poruchy vnútorného prostredia</td><td>laboratórny nález, novovzniknuté ťažkosti</td></tr>
    <tr><th scope="row">Neurologické a kognitívne</th><td>mierna kognitívna porucha, demencia, stav po úraze hlavy</td><td>progresia, vek nástupu, pamäťový profil</td></tr>
    <tr><th scope="row">Situačné</th><td>vyhorenie, chronický stres, preťaženie, neprimeraná pracovná záťaž</td><td>viazanosť na okolnosti, ústup po ich zmene</td></tr>
  </tbody>
</table>
</div>

<p><strong>Kľúčové rozlíšenie:</strong> ADHD má celoživotný priebeh s počiatkom v detstve. Novovzniknutá porucha pozornosti u dospelého, ktorý predtým fungoval bez ťažkostí, je <em>predovšetkým dôvodom na medicínske vyšetrenie</em>, nie na diagnózu ADHD.</p>

<h3>Digitálna distrakcia</h3>

<p>Časté prepínanie úloh, krátky obsah a intenzívne používanie smartfónu môžu napodobniť príznaky ADHD. Príčinná súvislosť však nie je preukázaná a smer vzťahu je nejasný: ľudia s poruchou pozornosti môžu obrazovky používať viac, nie naopak. Ide o dôvod na opatrnosť pri interpretácii, nie o diagnostické kritérium ani o vysvetlenie, ktoré ADHD vylučuje.</p>

<h3>Prečo je rekonštrukcia detstva metodologicky slabá</h3>

<p>Podmienka počiatku príznakov v detstve sa v dospelosti overuje spätne — a spätné vybavovanie je nespoľahlivé. Pacient, ktorý sa už s diagnózou stotožnil, si minulosť prirodzene reinterpretuje cez jej optiku. Dokumentácia z detstva často chýba a rodičia si nemusia pamätať detaily alebo ich hodnotia inak.</p>

<p>Praktický dôsledok: čím slabšie sú podklady o detstve, tým opatrnejší má byť záver — a tým väčšiu váhu má dôsledná diferenciálna diagnostika.</p>

<div class="pdf-avoid-break">
<h2>Vecná kontrola hlavných tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie hlavných tvrdení o diagnostike ADHD u dospelých" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>ADHD nie je dané len nepozornosťou</td><td><strong>Potvrdené</strong></td><td>Vyžaduje sa trvalý vzorec, vývinová neprimeranosť, prítomnosť vo viacerých prostrediach a funkčné poškodenie</td></tr>
    <tr><td>Klinický rozhovor je základ diagnózy</td><td><strong>Potvrdené</strong></td><td>V súlade s odporúčaním NICE NG87; štruktúrované nástroje zvyšujú konzistentnosť, nenahrádzajú posúdenie</td></tr>
    <tr><td>DIVA je užitočný štruktúrovaný rozhovor</td><td><strong>Potvrdené ako podporný nástroj</strong></td><td>Pozor na verziu: validačná práca sa týka DIVA 2.0 (DSM-IV, n = 40); aktuálna je DIVA-5 (DSM-5)</td></tr>
    <tr><td>Posudzovacie škály samy diagnózu nestanovia</td><td><strong>Potvrdené a kvantifikovateľné</strong></td><td>ASRS skríner: špecificita 99,5 %, ale senzitivita iba 68,7 % — negatívny výsledok ADHD nevylučuje</td></tr>
    <tr><td>Neuropsychologické testy samy ADHD nedokazujú</td><td><strong>Potvrdené</strong></td><td>Poruchu exekutívnych funkcií spôsobuje množstvo iných stavov; normálny výsledok diagnózu nevylučuje</td></tr>
    <tr><td>Úzkosť a depresia môžu príznaky zameniť</td><td><strong>Potvrdené</strong></td><td>Zámena funguje obojsmerne — ADHD býva mylne liečené ako primárna depresia</td></tr>
    <tr><td>Spánok, látky a lieky môžu zhoršiť pozornosť</td><td><strong>Potvrdené</strong></td><td>Pri novovzniknutých ťažkostiach majú prednosť pred diagnózou ADHD</td></tr>
    <tr><td>Technologická distrakcia môže ADHD napodobniť</td><td><strong>Podporené, kauzalita nejasná</strong></td><td>Smer vzťahu nie je určený; nejde o diagnostické kritérium ani o vylučujúci nález</td></tr>
    <tr><td>ADHD v dospelosti nevyzerá ako v detstve</td><td><strong>Potvrdené</strong></td><td>Hyperaktivita ustupuje, nepozornosť pretrváva; príznaky sa internalizujú</td></tr>
    <tr><td>Spätné vybavovanie detstva je limitujúce</td><td><strong>Potvrdené</strong></td><td>Bez dokumentácie alebo svedka interpretovať vývinovú anamnézu opatrne</td></tr>
  </tbody>
</table>
</div>
</div>

<h2>Nefrologické súvislosti</h2>

<h3>Porucha pozornosti pri CKD má viacero liečiteľných príčin</h3>

<p>U pacienta s chronickou chorobou obličiek treba pred úvahou o ADHD cielene zvážiť:</p>

<ul>
  <li><strong>kognitívne zmeny pri CKD</strong> — spomalenie, únava, poruchy pozornosti a exekutívnych funkcií sú v tejto populácii dobre popísané a súvisia aj s cerebrálnym ochorením malých ciev,</li>
  <li><strong>urémiu a metabolické odchýlky</strong> — vrátane vplyvu urémických toxínov,</li>
  <li><strong>anémiu</strong> pri CKD,</li>
  <li><strong>poruchy spánku</strong>, ktoré sú pri CKD a najmä pri dialýze veľmi časté (spánkové apnoe, syndróm nepokojných nôh),</li>
  <li><strong>depresiu a úzkosť</strong> v kontexte chronického ochorenia,</li>
  <li><strong>polyfarmáciu</strong> — sedatívne, anticholinergné a antihistaminové účinky,</li>
  <li><strong>interkurentné stavy</strong> — infekcie, dehydratáciu, poruchy iónov,</li>
  <li><strong>dialyzačný režim</strong> — kolísanie vnútorného prostredia a únavu po procedúre.</li>
</ul>

<p>Toto nie je alternatíva k ADHD, ale <strong>povinná súčasť</strong> diagnostického procesu. Ak nefrologický pacient žiada vyšetrenie na ADHD, medicínska diferenciálna diagnostika má prebehnúť súbežne s psychiatrickým posúdením.</p>

<div class="pdf-avoid-break">
<h3>Ak sa ADHD potvrdí: čo znamená jeho liečba pri CKD</h3>

<p>Farmakoterapia ADHD zasahuje do kardiovaskulárnych parametrov. Metaanalýza 22 štúdií so 46 107 účastníkmi potvrdila, že <strong>metylfenidát zvyšuje srdcovú frekvenciu aj systolický tlak</strong> oproti placebu (obe P &lt; 0,001) a že u detí a dorastu <strong>atomoxetín zvyšoval tieto parametre ešte viac než metylfenidát</strong>. V počte nežiaducich kardiálnych príhod sa skupiny nelíšili, ale sledovanie bolo krátkodobé.</p>

<p>Pre pacienta s CKD, u ktorého je kontrola tlaku jedným z hlavných nefroprotektívnych opatrení, z toho vyplýva:</p>

<ol>
  <li>pred začatím liečby zmerať krvný tlak a srdcovú frekvenciu a zaznamenať východiskový stav,</li>
  <li>po nasadení a po každej zmene dávky kontrolovať oba parametre,</li>
  <li>pri vzostupe tlaku prehodnotiť antihypertenzívnu liečbu alebo samotnú indikáciu stimulancia,</li>
  <li>zohľadniť, že úprava dávkovania pri zníženej funkcii obličiek sa riadi <strong>platným súhrnom charakteristických vlastností konkrétneho lieku</strong> — medzi liečivami sú rozdiely a paušálne pravidlo neexistuje,</li>
  <li>rátať s tým, že predpisovanie psychostimulancií podlieha na Slovensku osobitným pravidlám pre omamné a psychotropné látky a preskripčným obmedzeniam.</li>
</ol>

<p>Metaanalýza sa netýkala populácie s CKD, takže veľkosť účinku u týchto pacientov nie je známa. Smer účinku je však konzistentný a opodstatňuje dôslednejšie sledovanie.</p>
</div>

<h2>Praktický záver</h2>

<p>ADHD u dospelých sa nedá potvrdiť ani vyvrátiť na základe nepozornosti. Poctivé posúdenie kombinuje vývinovú anamnézu (ideálne s doloženým dôkazom z detstva), funkčné poškodenie vo viacerých prostrediach, informácie od blízkych osôb, dôslednú diferenciálnu diagnostiku a posudzovacie škály ako doplnok.</p>

<p><strong>Konkrétne čísla to potvrdzujú:</strong> skríningová škála ASRS má síce špecificitu 99,5 %, ale senzitivitu iba 68,7 %. Pozitívny výsledok je dôvod pokračovať, negatívny nie je dôvod skončiť.</p>

<p>Pre nefrologickú prax platí dvojité pravidlo. Pred diagnózou treba vylúčiť medicínske príčiny poruchy pozornosti, ktoré sú pri CKD časté a liečiteľné. Po diagnóze treba pri liečbe sledovať krvný tlak a srdcovú frekvenciu — teda parametre, na ktorých pri CKD záleží najviac.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ckd-mozog-kognitivne-poruchy-cievne-poskodenie">Chronická choroba obličiek postihuje aj mozog: kognitívne poruchy, cievne poškodenie a klinické dôsledky</a></li>
  <li><a href="article.php?slug=indoxyl-sulfat-kognitivne-zhorsenie-ckd">Indoxyl sulfát a kognitívne zhoršenie pri chronickej chorobe obličiek</a></li>
  <li><a href="article.php?slug=primarna-alebo-latkou-vyvolana-psychoza-diagnostika">Primárna alebo látkou vyvolaná psychóza? Diferenciálna diagnostika a zásady akútnej liečby</a></li>
  <li><a href="article.php?slug=prukaloprid-brain-fog-depresia-kognicia-nefrologia">Prukaloprid a „brain fog“ po depresii: môže 5-HT4 agonizmus zlepšiť kogníciu?</a></li>
  <li><a href="article.php?slug=hranicna-porucha-osobnosti-telesne-zdravie-somaticke-riziko">Hraničná porucha osobnosti a telesné zdravie: vyššiu chorobnosť nemožno vysvetliť iba psychikou</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Kessler RC, Adler L, Ames M, Demler O, Faraone S, Hiripi E, Howes MJ, Jin R, Secnik K, Spencer T, Ustun TB, Walters EE.</strong> <em>The World Health Organization Adult ADHD Self-Report Scale (ASRS): a short screening scale for use in the general population.</em> Psychol Med. 2005;35(2):245–256. Zdroj údajov o senzitivite, špecificite a kappa. <a href="https://pubmed.ncbi.nlm.nih.gov/15841682/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>National Institute for Health and Care Excellence (NICE).</strong> <em>Attention deficit hyperactivity disorder: diagnosis and management.</em> NICE guideline NG87. Publikované 14. marca 2018, naposledy aktualizované 13. septembra 2019. Britské odporúčanie, na Slovensku nie je záväzné. <a href="https://www.nice.org.uk/Guidance/ng87" target="_blank" rel="noopener noreferrer">Odporúčanie NICE</a>.</li>
  <li><strong>Ramos-Quiroga JA, Nasillo V, Richarte V, Corrales M, Palma F, Ibáñez P, Michelsen M, Van de Glind G, Casas M, Kooij JJS.</strong> <em>Criteria and Concurrent Validity of DIVA 2.0: A Semi-Structured Diagnostic Interview for Adult ADHD.</em> J Atten Disord. 2019;23(10):1126–1135. doi: 10.1177/1087054716646451. Validácia na 40 ambulantných pacientoch podľa kritérií DSM-IV. <a href="https://doi.org/10.1177/1087054716646451" target="_blank" rel="noopener noreferrer">Validačná štúdia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/27125994/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>DIVA Foundation.</strong> <em>DIVA-5 — Diagnostic Interview for ADHD in Adults.</em> Inštitucionálne autorstvo. Aktuálna verzia podľa DSM-5 vrátane variantov Young DIVA-5 a DIVA-5 ID; nástroj je spoplatnený. <a href="https://www.divacenter.eu/" target="_blank" rel="noopener noreferrer">DIVA Foundation</a>.</li>
  <li><strong>Liang EF, Lim SZ, Tam WW, Ho CS, Zhang MW, McIntyre RS, Ho RC.</strong> <em>The Effect of Methylphenidate and Atomoxetine on Heart Rate and Systolic Blood Pressure in Young People and Adults with Attention-Deficit Hyperactivity Disorder (ADHD): Systematic Review, Meta-Analysis, and Meta-Regression.</em> Int J Environ Res Public Health. 2018;15(8):1789. doi: 10.3390/ijerph15081789. Metaanalýza 22 štúdií so 46 107 účastníkmi. <a href="https://doi.org/10.3390/ijerph15081789" target="_blank" rel="noopener noreferrer">Metaanalýza</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/30127314/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>The Challenge of Diagnosing ADHD in Adults.</em> Medscape, 2026. Sekundárny zdroj použitý ako východisko, nie ako hlavný dôkaz; ako autorka sa uvádza Zebib K. Abraham. <a href="https://www.medscape.com/viewarticle/challenge-diagnosing-adhd-adults-2026a1000rxl" target="_blank" rel="noopener noreferrer">Spravodajské spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Údaje o vlastnostiach škály ASRS (senzitivita 68,7 % oproti 56,3 %, špecificita 99,5 % oproti 98,3 %, celková presnosť 97,9 % oproti 96,2 %, kappa 0,76 oproti 0,58, rozsah kappa 0,16–0,81 pri jednotlivých položkách, vzorka 154 respondentov) boli overené priamo proti abstraktu v PubMed (PMID 15841682), rovnako ako úplný zoznam 12 autorov. Údaje metaanalýzy o metylfenidáte a atomoxetíne (22 štúdií, 46 107 účastníkov, P &lt; 0,001) pochádzajú z abstraktu PMID 30127314; ročník a číslo boli overené cez Crossref. Validačná štúdia DIVA 2.0 (n = 40, kritériá DSM-IV) bola overená cez PMID 27125994 — pozor, týka sa verzie 2.0, nie aktuálnej DIVA-5. Dátumy publikovania a poslednej aktualizácie odporúčania NICE NG87 boli prevzaté priamo zo stránky odporúčania. Autorstvo spravodajského spracovania Medscape sa pre obmedzený prístup nepodarilo nezávisle overiť a uvádza sa s výhradou.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Článok neslúži na stanovenie diagnózy ani na výber liečby. Diagnostika ADHD u dospelých patrí do rúk psychiatra; nefrológ prispieva vylúčením medicínskych príčin poruchy pozornosti a sledovaním kardiovaskulárnych parametrov pri liečbe. Dávkovanie liekov pri zníženej funkcii obličiek sa riadi platným súhrnom charakteristických vlastností konkrétneho lieku a preskripčnými obmedzeniami platnými na Slovensku.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_diagnostika-adhd-dospeli-diferencialna-diagnostika_article',
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
