<?php
/**
 * Odborny clanok: kava a crevna mikrobiota (Lawsonibacter asaccharolyticus),
 * kriticke citanie dokazov a dosledky pre nefrologicku prax.
 *
 * Spustenie na serveri po commite:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_kava-mikrobiota-lawsonibacter-nefrologicka-prax_article.php"
 */

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
    'title'        => 'Káva a črevná mikrobiota: čo ukazujú štúdie a čo znamenajú pre nefrologickú prax',
    'slug'         => 'kava-mikrobiota-lawsonibacter-nefrologicka-prax',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Káva sa reprodukovateľne spája s baktériou Lawsonibacter asaccharolyticus aj pri bezkofeínovej forme. Čo presne štúdie zmerali, kde ich populárne podanie preháňa a čo z nich vyplýva pre pacienta s CKD.',
    'content'      => <<<'HTML'
<figure><a href="img/kava-mikrobiota-lawsonibacter-nefrologicka-prax.webp" rel="noopener noreferrer" target="_blank"><img src="img/kava-mikrobiota-lawsonibacter-nefrologicka-prax.webp" alt="Rozlomené kávové zrno, z ktorého prúdia jantárové tyčinkovité baktérie do priesvitného hrubého čreva; v pozadí slabo viditeľná silueta obličky" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna. Nejde o snímku konkrétneho pacienta ani o mikroskopický obraz skutočnej baktérie.</figcaption></figure>

<p>Káva nie je iba zdrojom kofeínu. Obsahuje chlorogénové kyseliny a ďalšie polyfenoly, trigonelín a melanoidíny vznikajúce pri pražení. Časť týchto látok sa dostáva do hrubého čreva, kde ich metabolizuje mikrobiota. Rozsiahla metagenomická práca Manghiho a spoluautorov v časopise <em>Nature Microbiology</em> z roku 2024 ukázala, že konzumácia kávy sa reprodukovateľne spája s vyšším relatívnym zastúpením baktérie <em>Lawsonibacter asaccharolyticus</em>, a to aj pri bezkofeínovej káve [1]. Nezávislá izraelská kohorta ten istý nález v roku 2025 zopakovala [2].</p>

<p>Nevieme však, či táto mikrobiálna zmena sama osebe zlepšuje zdravie človeka, a už vôbec nie, či prináša osobitný prospech pacientom s chronickou chorobou obličiek (CKD). Správa Medscape, ktorá tému v októbri 2026 priniesla lekárom, niektoré závery zjednodušuje a v dvoch bodoch sa s primárnymi prácami rozchádza. Článok preto oddeľuje to, čo štúdie skutočne zmerali, od interpretácie a od toho, čo z nich vyplýva pre nefrologickú ambulanciu.</p>

<p>Motilite, refluxu a osi črevo – mozog sa podrobnejšie venuje starší článok <a href="article.php?slug=kava-crevny-mikrobiom-ucinok-presahuje-kofein">Káva a črevný mikrobióm: účinok presahuje kofeín</a>. Tento text sa sústreďuje na metodiku kľúčovej štúdie, na replikačné údaje a na dôsledky pre pacienta s CKD.</p>

<h2>Čo výskumníci skutočne skúmali</h2>

<p>Medscape predstavuje výskum ako analýzu „viac než 54 000 vzoriek stolice“ [7]. Pre interpretáciu je podstatné, čo tento počet zahŕňal. Pôvodná práca spracovala celkovo 54 198 metagenomických vzoriek z 211 kohort. Súbor však okrem zdravých dospelých obsahoval aj novorodencov a deti, 7 423 vzoriek od ľudí s jedným z 35 ochorení, komunity s netradičným (nezápadným) spôsobom života, primáty a historické vzorky [1].</p>

<p>Podrobné potravinové frekvenčné dotazníky s viac než 150 položkami boli prepojené s 23 115 metagenomickými profilmi. Po vyradení osôb nad 99. percentilom príjmu kávy (extrémne, nepravdepodobné hodnoty) zostalo v analýze kategórií konzumácie 22 867 účastníkov zo Spojených štátov a Spojeného kráľovstva [1].</p>

<div class="table-responsive" role="region" aria-label="Súbory použité v štúdii Manghi et al. 2024" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Súbor</th>
      <th scope="col">Rozsah</th>
      <th scope="col">Na čo slúžil</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Všetky metagenómy</th>
      <td>54 198 vzoriek, 211 kohort</td>
      <td>Prevalencia <em>L. asaccharolyticus</em> v rôznych populáciách, chorobách a vekových skupinách</td>
    </tr>
    <tr>
      <th scope="row">Metagenómy s potravinovým dotazníkom</th>
      <td>23 115 profilov</td>
      <td>Strojové učenie: ktoré potraviny „čítať“ z mikrobioty</td>
    </tr>
    <tr>
      <th scope="row">Analýza kategórií konzumácie kávy</th>
      <td>22 867 účastníkov</td>
      <td>Porovnanie skupín bez kávy, s miernou a s vysokou konzumáciou</td>
    </tr>
    <tr>
      <th scope="row">Kofeínová a bezkofeínová káva zvlášť</th>
      <td>12 089, resp. 6 089 účastníkov</td>
      <td>Overenie, či súvislosť nespôsobuje iba kofeín</td>
    </tr>
    <tr>
      <th scope="row">Plazmatická metabolomika</th>
      <td>438 vzoriek</td>
      <td>Metabolity spojené s kávou a s prítomnosťou baktérie</td>
    </tr>
  </tbody>
</table>
</div>

<p>Už predchádzajúca práca tej istej skupiny ukázala, že spomedzi viac než 150 potravín má k zloženiu mikrobioty najsilnejší vzťah práve káva. V novej analýze sa podľa mikrobiálneho profilu sa dali spoľahlivo odlíšiť ľudia, ktorí kávu nepijú, od konzumentov s vysokým príjmom (medián AUC naprieč kohortami 0,92) aj s miernym príjmom (0,86). Miernu od vysokej konzumácie však model rozlišoval oveľa slabšie (pri krížovej validácii s externými kohortami AUC 0,65) [1]. Predstavu, že každá ďalšia šálka prináša úmerne väčší mikrobiálny účinok, to nepodporuje.</p>

<h2>Baktéria spojená s pitím kávy</h2>

<p>Najsilnejšiu súvislosť s konzumáciou kávy vykazovala <em>Lawsonibacter asaccharolyticus</em> (Spearmanov koeficient ρ = 0,43). Jej medián relatívneho zastúpenia bol pri vysokej konzumácii 4,5- až 8-násobne vyšší a pri miernej konzumácii 3,4- až 6,4-násobne vyšší než v skupine bez kávy. Najväčší rozdiel medzi miernou a vysokou konzumáciou dosiahol iba 1,4-násobok a v troch z piatich kohort nebol štatisticky významný. Vo väčšine západných populácií je baktéria bežná, u ľudí s tradičným vidieckym spôsobom života a u detí sa vyskytuje zriedka. Na úrovni krajín jej prevalencia korelovala s priemernou spotrebou kávy na obyvateľa [1].</p>

<p>Tieto údaje opisujú <strong>relatívne</strong> zastúpenie baktérie v mikrobiálnom spoločenstve, nie jej absolútny počet v čreve. Vyššie relatívne zastúpenie zároveň nie je automaticky ukazovateľom lepšieho zdravotného stavu.</p>

<p>Baktéria bola pri prvom opise v roku 2018 izolovaná z ľudskej stolice a charakterizovaná ako producent butyrátu [5]. To je biologicky zaujímavé, nestačí to však na záver, že pitie kávy prostredníctvom jej rastu zvyšuje tvorbu butyrátu v ľudskom čreve alebo prináša konkrétny klinický účinok. Metaanalýza prípadovo-kontrolných metagenomických súborov z 25 ochorení (5 670 chorých a 7 154 kontrol) navyše nenašla rozdiel v jej prevalencii medzi chorými a zdravými [1]. Označovať ju bez výhrad za „prospešnú baktériu“ je preto predčasné.</p>

<h2>Nezávislé potvrdenie a nečakaný renálny detail</h2>

<p>Dôležitým doplnkom je prierezová štúdia z izraelského projektu Human Phenotype Project (Dai et al.), publikovaná v časopise <em>Metabolism</em> [2]. Zahŕňala 8 666 prevažne zdravých dospelých z Izraela s priemerným vekom 51,8 roka. Príjem kávy sa nezisťoval dotazníkom, ale z dvojtýždňových záznamov stravy v reálnom čase. Najsilnejšie asociovaným mikrobiálnym druhom bol opäť <em>Clostridium phoceensis</em>, ktorý bol medzičasom preklasifikovaný práve na <em>L. asaccharolyticus</em>. Keď sa asociácia zopakuje v inej krajine a pri inom spôsobe zisťovania stravy, je ťažšie ju vysvetliť chybou jednej metódy.</p>

<p>Pre nefrológa je zaujímavejší iný nález tej istej práce. Zo štyroch sledovaných renálnych ukazovateľov (sérový kreatinín, urea, sodík a draslík) súvisela konzumácia kávy iba s <strong>vyššou koncentráciou sérového draslíka</strong> [2]. Autori v súhrne zaraďujú renálny systém medzi oblasti s „priaznivými“ asociáciami. U zdravých dospelých môže ísť o klinicky nevýznamný posun. U pacienta s pokročilou CKD, s hyperkaliémiou v anamnéze alebo s liečbou inhibítormi systému renín – angiotenzín – aldosterón (RAAS) či antagonistami mineralokortikoidových receptorov však vyšší draslík „priaznivým“ nálezom nie je. Prierezový dizajn neumožňuje určiť, či ide o účinok kávy, a z textu práce nie je zrejmé, aký veľký bol rozdiel v mmol/l. Pri pacientovi s CKD je to skôr pripomienka, že o káve rozhoduje draslík a objem nápoja, nie mikrobiota.</p>

<h2>Účinok nemožno pripísať iba kofeínu</h2>

<p>Súvislosť s <em>L. asaccharolyticus</em> pretrvávala aj v analýze bezkofeínovej kávy po úprave na kofeínovú kávu, pohlavie, vek a index telesnej hmotnosti [1]. Výskumníci navyše kultivovali referenčný kmeň baktérie na pôdach s prídavkom kávy pripravenej v moka kanvičke a instantnej kávy, vždy v kofeínovej aj bezkofeínovej forme. Káva podporila rast baktérie v priemere približne 3,5-násobne a štatisticky významne v 10 zo 16 testovaných prípravkov [1].</p>

<p>Spojenie populačných údajov s laboratórnym experimentom robí priamy účinok niektorých zložiek kávy biologicky vierohodným. Randomizovanú klinickú štúdiu však nenahrádza. Kultivačné médium nepredstavuje celý črevný ekosystém a rast izolovanej baktérie nevypovedá o zdravotnom výsledku u človeka.</p>

<p>Plazmatická metabolomika ukázala, že u konzumentov kávy, ktorí baktériu nosia, sú vyššie koncentrácie kyseliny chinovej, trigonelínu a s nimi korelujúcich metabolitov. Časť týchto signálov zostala chemicky neidentifikovaná; autori predpokladajú, že môže ísť o deriváty kyseliny chinovej vznikajúce mikrobiálnym metabolizmom [1]. Kyselina chinová je súčasťou chlorogénových kyselín, hlavných polyfenolov kávy. Presný mechanizmus však zatiaľ objasnený nie je.</p>

<h2>Diverzita a „prospešné“ baktérie</h2>

<p>Prehľad v časopise <em>Nutrients</em> z roku 2024 (Saygili, Hegde, Shi) zhŕňa práce, v ktorých mierna konzumácia kávy (menej ako štyri šálky denne) súvisela s vyšším zastúpením bifidobaktérií, s poklesom enterobaktérií a s vyššou diverzitou mikrobioty [3]. Zahŕňa však veľmi rozdielne prístupy: štúdie u ľudí, pokusy na hlodavcoch aj kultivácie mimo organizmu. Niektoré práce skúmali kávové extrakty, izolované zložky alebo vedľajšie produkty spracovania kávy. Ich výsledky nemožno bez rozlíšenia zlúčiť do klinického odporúčania ani preniesť na bežnú šálku nápoja.</p>

<p>Opatrnosť je potrebná najmä pri tvrdení, že káva „zvyšuje diverzitu“; uvádza ho aj perex správy Medscape [7]. V rozsiahlej metagenomickej štúdii bola korelácia konzumácie kávy s alfa-diverzitou, teda s rozmanitosťou mikrobioty v jednej vzorke, slabá (ρ = 0,1), zatiaľ čo s <em>L. asaccharolyticus</em> bola viac než štvornásobne silnejšia [1]. Káva teda mikrobiotu nemení plošne, ale selektívne. Ani vyššia diverzita pritom sama osebe nie je univerzálnym dôkazom zdravšej mikrobioty.</p>

<p>Rovnako nemožno celú čeľaď <em>Enterobacteriaceae</em> označiť za škodlivú a pokles jej zastúpenia automaticky vyhodnotiť ako zdravotný prínos. Klinický význam závisí od konkrétnych mikroorganizmov, ich vlastností a od prostredia hostiteľa.</p>

<h2>Hranica „päť šálok“: kde sa podklady rozchádzajú</h2>

<p>Správa Medscape uvádza, že viac než päť šálok kávy denne sa spája s vyšším rizikom gastroezofágovej refluxovej choroby a s progresiou Crohnovej choroby. Ako dôkaz odkazuje na prierezovú analýzu údajov NHANES z roku 2025 (Yang et al.) [7, 4]. Táto práca však šálky kávy nehodnotila: pracovala s príjmom kofeínu v miligramoch a zápalové ochorenie čreva v nej bolo definované podľa údajov samotných účastníkov. Medzi príjmom kofeínu a zápalovým ochorením čreva <strong>nenašla štatisticky významnú súvislosť</strong> [4]. Opísala iba nelineárny vzťah k chronickej zápche: pod hranicou približne 204 mg kofeínu denne bol vyšší príjem spojený s nižšou šancou zápchy, nad ňou s mierne vyššou.</p>

<p>Formulácia o „viac než piatich šálkach“ v skutočnosti pochádza zo záveru prehľadu v časopise <em>Nutrients</em> [3]. Prehľad sám zároveň uvádza, že údaje o vplyve kávy na zápalové ochorenia čreva sú rozporné a časť štúdií súvislosť nepotvrdila. Takto formulovanú hranicu preto nemožno prevziať ako všeobecné klinické pravidlo. Šálka navyše nie je štandardizovanou dávkou: líši sa objemom, spôsobom prípravy aj obsahom kofeínu.</p>

<h2>Motilita, reflux a individuálna tolerancia</h2>

<p>Účinky kávy na tráviaci trakt nie sú totožné s jej účinkami na mikrobiotu. Káva aj bezkofeínová káva stimulujú sekréciu gastrínu, žalúdočnú a pankreatickú sekréciu a motilitu ilea a hrubého čreva; experimentálne údaje naznačujú aj priamy účinok na hladký sval čreva nezávislý od kofeínu [3]. U niektorých ľudí káva vyvoláva nutkanie na stolicu, u iných zhoršuje pálenie záhy, naliehavosť vyprázdňovania alebo hnačku.</p>

<p>Pre klinickú prax je užitočné odlišovať tri roviny:</p>

<ul>
  <li>dlhodobejšiu súvislosť pitia kávy so zložením mikrobioty,</li>
  <li>bezprostredné tráviace príznaky po vypití nápoja,</li>
  <li>vznik alebo progresiu konkrétneho ochorenia.</li>
</ul>

<p>Tieto roviny nemožno zamieňať. Pálenie záhy po káve u citlivého človeka nedokazuje, že káva u všetkých konzumentov spôsobuje gastroezofágovú refluxovú chorobu. Zhoršenie hnačky u pacienta s Crohnovou chorobou nepreukazuje progresiu črevného zápalu. Pri syndróme dráždivého čreva alebo refluxe je rozumnejšie vychádzať z opakovateľnej individuálnej reakcie než predpisovať univerzálny zákaz kávy alebo ju odporúčať ako liečbu. Bezkofeínová káva obmedzí účinky kofeínu, nemusí však odstrániť všetky tráviace ťažkosti, keďže časť účinkov na motilitu od kofeínu nezávisí.</p>

<h2>Os črevo – mozog: hypotéza, nie preukázaná liečba</h2>

<p>Črevná mikrobiota sa zúčastňuje na komunikácii medzi tráviacim traktom, imunitným a nervovým systémom. Prehľadová literatúra preto diskutuje, či sa mikrobiálne zmeny po konzumácii kávy môžu podieľať na metabolických alebo neurobehaviorálnych účinkoch; podstatná časť týchto podkladov však pochádza zo zvieracích modelov [3]. Z dostupných prác nevyplýva, že káva zlepšuje kognitívne funkcie práve prostredníctvom <em>L. asaccharolyticus</em>. Na preukázanie takého mechanizmu nestačí súčasne pozorovať konzumáciu kávy, určitý mikrobiálny profil a zdravotný výsledok. Treba ukázať, že mikrobiálna zmena účinok skutočne sprostredkúva.</p>

<h2>Čo z toho vyplýva pre nefrologickú prax</h2>

<p>Žiadna z citovaných prác nebola klinickou skúškou u pacientov s CKD. Neoverovali, či káva prostredníctvom mikrobioty spomaľuje pokles glomerulovej filtrácie, znižuje koncentrácie uremických toxínov alebo zlepšuje výsledky dialyzačnej liečby. Takéto závery z nich nemožno odvodiť. Mikrobiota pacienta s pokročilou CKD sa navyše od mikrobioty zdravých dospelých líši, preto výsledky z populačných kohort nemožno do tejto skupiny prenášať priamo. Nasledujúce úvahy preto predstavujú individuálny klinický prístup, nie odporúčanie vyplývajúce z mikrobiomových štúdií.</p>

<ul>
  <li><strong>Tekutinová bilancia.</strong> Ak má pacient predpísané obmedzenie príjmu tekutín, objem kávy sa započítava do celkového príjmu. Dôležitý je skutočný objem nápoja, nie počet „káv“.</li>
  <li><strong>Draslík a fosfor.</strong> Čierna káva aj prídavky obsahujú draslík; mlieko, smotana, kávové krémy a niektoré rastlinné nápoje pridávajú aj fosfor, cukor a energiu. Čierna káva a veľký mliečny alebo sladený kávový nápoj nie sú nutrične rovnocenné. Asociácia kávy s vyšším sérovým draslíkom v kohorte zdravých dospelých [2] je dôvodom brať do úvahy aj kávu pri nevysvetlenej hyperkaliémii. Potrebu obmedzenia draslíka však nemožno určovať iba podľa diagnózy CKD, bez aktuálnych laboratórnych výsledkov a posúdenia celého jedálnička.</li>
  <li><strong>Krvný tlak, palpitácie a spánok.</strong> Rozhodovanie o kofeíne má zohľadňovať toleranciu, pridružené ochorenia a príznaky. Možný mikrobiálny účinok nie je dôvodom prehliadať nežiaduce účinky nápoja.</li>
  <li><strong>Tráviace ťažkosti.</strong> Káva nie je štandardnou liečbou zápchy u pacienta s CKD. Pri zápche treba posúdiť lieky (napríklad viazače fosfátov, katiónomeničové živice, opioidy), stravu, pohyb, povolený príjem tekutín a ďalšie príčiny. Pri hnačke alebo refluxe môže pomôcť sledovanie príznakov po znížení príjmu kávy.</li>
  <li><strong>Perorálne železo.</strong> Káva znižuje vstrebávanie nehemového železa. V klasickej štúdii s izotopmi znížila jedna šálka vstrebávanie železa z jedla o 39 %; pri káve vypitej hodinu pred jedlom sa vstrebávanie neznížilo, pri káve vypitej hodinu po jedle áno [6]. Štúdia merala železo zo stravy, nie z tabliet; pri perorálnych prípravkoch železa je však rozumné ich kávou nezapíjať a riadiť sa pokynmi konkrétneho prípravku. Účinnosti intravenózne podaného železa sa tento problém netýka.</li>
</ul>

<p>Na základe mikrobiologických výsledkov nie je dôvod odporúčať pacientovi, ktorý kávu nepije, aby s ňou začal. Rovnako nie je dôvod zvyšovať jej príjem s cieľom podporiť konkrétnu baktériu. Pri dobrej tolerancii a rozumnom zložení nápoja zase nie je dôvod kávu pacientovi s CKD paušálne zakazovať.</p>

<h2>Limity</h2>

<p>Obe kľúčové populačné práce sú observačné a prierezové; zachytávajú asociáciu, nie príčinný vzťah. V štúdii Manghiho a spoluautorov sa konzumácia kávy zisťovala potravinovými frekvenčnými dotazníkmi, ktoré sú zaťažené chybou spomínania, a šálka v nich slúžila ako štandardná porcia bez ohľadu na skutočný objem a silu nápoja [1]. Kultivačný experiment pracoval s jediným dostupným referenčným kmeňom baktérie. Izraelská kohorta zahŕňala ľudí s relatívne jednotným spôsobom prípravy kávy a bez systematického záznamu sladenia [2]. Ani jedna práca nezahŕňala osobitne pacientov s pokročilou CKD, dialyzovaných ani pacientov po transplantácii obličky. Prehľad v časopise <em>Nutrients</em> je naratívny, nie systematický, a kombinuje humánne, zvieracie aj <em>in vitro</em> údaje [3].</p>

<h2>Čo možno povedať s primeranou istotou</h2>

<p>Konzumácia kávy má reprodukovateľnú súvislosť so zložením črevnej mikrobioty, najmä s relatívnym zastúpením <em>Lawsonibacter asaccharolyticus</em>. Súvislosť sa potvrdila v amerických, britských aj izraelských súboroch. Jej pretrvávanie pri bezkofeínovej káve a výsledky kultivačných experimentov naznačujú, že nejde iba o účinok kofeínu.</p>

<p>Zdravotný význam tejto mikrobiálnej zmeny však zostáva otvorený. Kávu preto nemožno na základe týchto údajov považovať za mikrobiotou sprostredkovanú liečbu črevných ochorení ani CKD. O tom, či a koľko kávy pacient s CKD pije, majú rozhodovať tolerancia, zloženie a objem nápoja, kalémia a celkový zdravotný stav, nie predstava „podpory prospešných baktérií“.</p>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne posúdenie pacienta ani dietologické poradenstvo. Pri obmedzení tekutín, draslíka alebo fosforu má pacient zmenu pitného režimu konzultovať so svojím nefrológom.</em></p>

<h2>Literatúra</h2>

<ol>
  <li><em>Manghi P, Bhosle A, Wang K, Marconi R, Selma-Royo M, Ricci L, Asnicar F, Golzato D, Ma W, Hang D, Thompson KN, Franzosa EA, Nabinejad A, Tamburini S, Rimm EB, Garrett WS, Sun Q, Chan AT, Valles-Colomer M, Arumugam M, Bermingham KM, Giordano F, Davies R, Hadjigeorgiou G, Wolf J, Strowig T, Berry SE, Huttenhower C, Spector TD, Segata N, Song M. Coffee consumption is associated with intestinal Lawsonibacter asaccharolyticus abundance and prevalence across multiple cohorts. Nat Microbiol. 2024;9(12):3120–3134. doi: <a href="https://doi.org/10.1038/s41564-024-01858-9" target="_blank" rel="noopener noreferrer">10.1038/s41564-024-01858-9</a>. PMID: 39558133. PMCID: PMC11602726. <a href="https://pubmed.ncbi.nlm.nih.gov/39558133/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11602726/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></li>
  <li><em>Dai J, Dai W, Heianza Y, Qi L. Phenome-wide associations of coffee intake in the human phenotype project. Metabolism. 2026;174:156412. doi: <a href="https://doi.org/10.1016/j.metabol.2025.156412" target="_blank" rel="noopener noreferrer">10.1016/j.metabol.2025.156412</a>. PMID: 41047001. PMCID: PMC13215564. <a href="https://pubmed.ncbi.nlm.nih.gov/41047001/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Saygili S, Hegde S, Shi XZ. Effects of Coffee on Gut Microbiota and Bowel Functions in Health and Diseases: A Literature Review. Nutrients. 2024;16(18):3155. doi: <a href="https://doi.org/10.3390/nu16183155" target="_blank" rel="noopener noreferrer">10.3390/nu16183155</a>. PMID: 39339755. PMCID: PMC11434970. <a href="https://pubmed.ncbi.nlm.nih.gov/39339755/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://www.mdpi.com/2072-6643/16/18/3155" target="_blank" rel="noopener noreferrer">vydavateľ</a>.</em></li>
  <li><em>Yang X, Yan H, Chen Y, Guo R. Association Between Caffeine Intake and Bowel Habits and Inflammatory Bowel Disease: A Population-Based Study. J Multidiscip Healthc. 2025;18:3717–3726. doi: <a href="https://doi.org/10.2147/JMDH.S512855" target="_blank" rel="noopener noreferrer">10.2147/JMDH.S512855</a>. PMID: 40600201. PMCID: PMC12212077. <a href="https://pubmed.ncbi.nlm.nih.gov/40600201/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Sakamoto M, Iino T, Yuki M, Ohkuma M. Lawsonibacter asaccharolyticus gen. nov., sp. nov., a butyrate-producing bacterium isolated from human faeces. Int J Syst Evol Microbiol. 2018;68(6):2074–2081. doi: <a href="https://doi.org/10.1099/ijsem.0.002800" target="_blank" rel="noopener noreferrer">10.1099/ijsem.0.002800</a>. PMID: 29745868. <a href="https://pubmed.ncbi.nlm.nih.gov/29745868/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Morck TA, Lynch SR, Cook JD. Inhibition of food iron absorption by coffee. Am J Clin Nutr. 1983;37(3):416–420. doi: <a href="https://doi.org/10.1093/ajcn/37.3.416" target="_blank" rel="noopener noreferrer">10.1093/ajcn/37.3.416</a>. PMID: 6402915. <a href="https://pubmed.ncbi.nlm.nih.gov/6402915/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Coffee's Hidden Effects on Gut Health. Medscape, 8. októbra 2026. Bez uvedeného autora („Edited by Medscape Staff“); podľa vydavateľa ide o spracovanie článku <em>Coffee and the Gut: What's Brewing in the Microbiome?</em> vytvorené s pomocou nástrojov umelej inteligencie a skontrolované redaktormi. <a href="https://www.medscape.com/s/viewarticle/coffees-hidden-effects-gut-health-2026a10011my" target="_blank" rel="noopener noreferrer">Zdrojová správa</a>.</em></li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Všetky číselné údaje z práce Manghiho a spoluautorov (veľkosti súborov, AUC, násobky mediánu relatívneho zastúpenia, korelácie, kultivačné výsledky a metaanalýza 25 ochorení) boli overené v plnom texte v PMC. Prehľad Saygiliovej a spoluautorov a štúdia Daia a spoluautorov boli overené v plnom texte; ostatné práce v štruktúrovanom abstrakte. Úplné autorské zoznamy, ročníky, čísla a strany boli porovnané s PubMed a Crossref. Oproti predlohe článok opravuje pripísanie hranice „viac než päť šálok“ (pochádza z prehľadu [3], nie zo štúdie [4], na ktorú odkazuje Medscape a ktorá súvislosť s IBD nenašla), spresňuje tvrdenie o diverzite a dopĺňa replikačnú kohortu [2] vrátane asociácie s draslíkom. Nefrologická interpretácia a praktické úvahy sú redakčným spracovaním uvedených dôkazov, nie stanoviskom odbornej spoločnosti.</em></p>

<h3>Súvisiace články</h3>
<ul>
  <li><a href="article.php?slug=kava-crevny-mikrobiom-ucinok-presahuje-kofein">Káva a črevný mikrobióm: účinok presahuje kofeín</a></li>
  <li><a href="article.php?slug=kava-pecen-cirhoza-hcc-uk-biobank-nefrologia">Káva a pečeň v UK Biobank: nižšie riziko cirhózy a hepatocelulárneho karcinómu a čo z toho platí pre pacienta s chorobou obličiek</a></li>
  <li><a href="article.php?slug=kontrola-draslika-ckd-edukovat-nie-strasit">Kontrola draslíka pri ochorení obličiek: edukovať, nie strašiť</a></li>
  <li><a href="article.php?slug=zelezo-anemia-ckd-kdigo-2026-erbp">Železo pri anémii v CKD podľa KDIGO 2026: prahy iniciácie, proaktívna i.v. substitúcia a európsky pohľad ERBP</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kava-mikrobiota-lawsonibacter-nefrologicka-prax_article',
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
            <div class="alert alert-error"><ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul></div>
          <?php endif; ?>
          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?><p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p><?php endif; ?>
          </div>
          <ul><?php foreach ($articles as $a): ?><li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li><?php endforeach; ?></ul>
          <p class="mt-30"><a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>&nbsp;<a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a></p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
