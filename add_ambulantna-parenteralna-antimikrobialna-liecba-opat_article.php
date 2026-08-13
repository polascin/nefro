<?php

/**
 * add_ambulantna-parenteralna-antimikrobialna-liecba-opat_article.php
 * Ambulantna parenteralna antimikrobialna liecba so zameranim na bezpecnost a ochranu zil pri CKD.
 *
 * Povodni autori klucoveho spracovaneho zdroja su uvedeni v source_authors.php.
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
    'title'        => 'Ambulantná parenterálna antimikrobiálna liečba: bezpečná alternatíva hospitalizácie iba pri správnom výbere pacienta',
    'slug'         => 'ambulantna-parenteralna-antimikrobialna-liecba-opat',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'OPAT môže bezpečne skrátiť alebo nahradiť hospitalizáciu, iba ak je súčasťou riadeného programu. Pri CKD navyše vyžaduje ochranu žilového riečiska, dynamické dávkovanie a individualizované monitorovanie toxicity.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Ambulantná parenterálna antimikrobiálna liečba môže vybraným pacientom umožniť dokončenie terapie mimo nemocnice. Bez formálneho programu, odbornej zodpovednosti a včasnej reakcie na komplikácie však nejde o bezpečnú alternatívu hospitalizácie, ale iba o presun jej rizík do domácnosti.</em></p>

<p>Ambulantná parenterálna antimikrobiálna liečba, označovaná skratkou <strong>OPAT</strong> z anglického <em>outpatient parenteral antimicrobial therapy</em>, znamená podávanie parenterálneho antimikrobiálneho lieku bez nepretržitej hospitalizácie. Najčastejšie ide o intravenóznu liečbu, podľa lieku a programu však môže byť parenterálne podanie aj intramuskulárne alebo subkutánne.</p>

<p>OPAT môže prebiehať doma, v ambulantnom infúznom centre, v zariadení následnej starostlivosti alebo počas návštevy dialyzačného strediska. Nové britské odporúčania správnej praxe z roku 2026 zdôrazňujú, že aj vo virtuálnej nemocnici alebo v programe nemocničnej starostlivosti doma sa má intravenózna antimikrobiálna liečba poskytovať prostredníctvom formálnej služby OPAT alebo v tesnej spolupráci s ňou.</p>

<h2>OPAT nie je synonymom nemocnice doma</h2>

<p>Nemocničná starostlivosť v domácom prostredí je širší organizačný model. Môže zahŕňať oxygenoterapiu, intravenózne tekutiny, diagnostiku, ošetrovanie rán, rehabilitáciu a ďalšie intervencie na úrovni nemocničnej starostlivosti. OPAT je užšie vymedzený proces zameraný na antimikrobiálnu liečbu a jej bezpečné riadenie.</p>

<p>Nejde teda iba o technické premiestnenie infúzie z nemocničnej izby. Bezpečný program musí zahŕňať:</p>

<ul>
  <li>potvrdenie diagnózy a trvajúcej indikácie antimikrobiálnej liečby,</li>
  <li>posúdenie kontroly zdroja infekcie,</li>
  <li>preverenie účinnej perorálnej alternatívy,</li>
  <li>výber lieku, dávky, spôsobu podania a plánovaného trvania,</li>
  <li>voľbu a starostlivosť o cievny prístup,</li>
  <li>klinické a laboratórne monitorovanie,</li>
  <li>jasné rozdelenie zodpovednosti medzi odosielajúcim a OPAT tímom,</li>
  <li>nepretržite dostupný postup pri zhoršení stavu,</li>
  <li>plán ukončenia liečby a ďalšieho sledovania.</li>
</ul>

<h2>Prvá otázka znie: potrebuje pacient parenterálnu liečbu?</h2>

<p>Dlhé trvanie liečby automaticky neznamená, že liek musí byť počas celého obdobia podávaný intravenózne. Odporúčania OPAT 2026 uprednostňujú perorálnu liečbu vždy, keď má porovnateľnú účinnosť a nebránia jej toxicita, nedostupná enterálna cesta, alergia, porucha absorpcie alebo klinicky významná interakcia.</p>

<p>Pred zaradením pacienta do programu treba preto odpovedať najmenej na tri otázky:</p>

<ol>
  <li>Je antimikrobiálna liečba stále indikovaná?</li>
  <li>Je dostupná účinná perorálna možnosť s primeranou biologickou dostupnosťou a prienikom do miesta infekcie?</li>
  <li>Prevažuje očakávaný prínos parenterálnej liečby nad rizikami lieku a cievneho prístupu?</li>
</ol>

<p>Možnosť prechodu na perorálnu liečbu závisí od diagnózy, patogénu, citlivosti izolátu, kontroly zdroja infekcie, gastrointestinálnej absorpcie, interakcií a klinického vývoja. Pokles C-reaktívneho proteínu ani ústup horúčky samy osebe nestačia. Naopak, normálna koncentrácia CRP nevylučuje pretrvávanie infekcie tam, kde nebola zabezpečená drenáž, odstránenie infikovaného materiálu alebo iná potrebná kontrola zdroja.</p>

<h2>Výber pacienta je klinické aj sociálne rozhodnutie</h2>

<p>Pacient má byť pred začatím OPAT klinicky stabilný a jeho infekcia dostatočne objasnená. Posúdenie vhodnosti má zahŕňať fyzické, kognitívne, sociálne a logistické okolnosti, nie iba aktuálny krvný tlak a teplotu.</p>

<p>Prakticky treba preveriť:</p>

<ul>
  <li>hemodynamickú a respiračnú stabilitu,</li>
  <li>riziko náhleho zhoršenia a potrebu ďalších výkonov,</li>
  <li>komorbidity, krehkosť, mobilitu a funkčný stav,</li>
  <li>kognitívne, zrakové a manuálne schopnosti pacienta alebo opatrovateľa,</li>
  <li>schopnosť porozumieť liečbe a dodržiavať monitorovací plán,</li>
  <li>bezpečné skladovanie lieku a hygienické podmienky,</li>
  <li>telefonický kontakt, dopravu a dostupnosť laboratórnych vyšetrení,</li>
  <li>reálnu dostupnosť urgentného vyšetrenia alebo prijatia do nemocnice.</li>
</ul>

<p>Vek sám osebe nie je kontraindikáciou. Krehkosť, kognitívna porucha alebo obmedzená mobilita však môžu vyžadovať intenzívnejšiu ošetrovateľskú podporu. Rovnako ani užívanie návykových látok či neisté bývanie nemajú byť automatickým dôvodom na odmietnutie. IDSA pre ľudí, ktorí injekčne užívajú drogy, nevydáva všeobecné odporúčanie a vyžaduje individuálne rozhodnutie; britské odporúčania 2026 pripúšťajú OPAT aj pre ťažšie dostupné skupiny, ak sa riziko posúdi individuálne a zapoja sa príslušné komunitné služby.</p>

<p>Pacient alebo opatrovateľ môže liek podávať samostatne až po zdokumentovanom zaškolení a overení kompetencie. Musí pritom existovať funkčný systém monitorovania komplikácií cievneho prístupu a nežiaducich účinkov. Prítomnosť zdravotníka pri každej dávke nie je nevyhnutná pre každého pacienta, úplná absencia odborného dohľadu však bezpečným modelom nie je.</p>

<h2>Výber lieku sa nesmie riadiť iba pohodlnou frekvenciou</h2>

<p>Jednorazové denné podanie môže zjednodušiť organizáciu, ale neospravedlňuje neprimerane široké spektrum. Ceftriaxón ani ertapeném nie sú univerzálnymi liekmi OPAT. Výber má vychádzať z mikrobiologickej účinnosti, prieniku do miesta infekcie, farmakokinetiky a farmakodynamiky, funkcie obličiek a pečene, interakcií, toxicity a antimikrobiálnej politiky.</p>

<p>Pri predĺženej alebo kontinuálnej infúzii betalaktámu treba mať robustné údaje o stabilite lieku v konkrétnom roztoku, koncentrácii a aplikačnom systéme. Rozhodujúca je aj skutočná teplota počas používania. Výsledok stabilitnej skúšky pri kontrolovanej izbovej teplote nemožno automaticky preniesť na elastomérnu pumpu nosenú pri tele.</p>

<p>Prvá dávka nového antimikrobiálneho lieku má byť podľa odporúčaní 2026 podaná pod dohľadom. Môže to byť aj v domácnosti, ale iba v prítomnosti osoby kompetentnej a vybavenej rozpoznať a zvládnuť anafylaxiu.</p>

<h2>Cievny prístup sa vyberá podľa lieku, trvania aj budúcnosti pacienta</h2>

<p>Periférna kanyla je vhodná najmä na krátku liečbu. Midline katéter možno u dospelých zvážiť pri kratších kúrach, často do 14 dní, ak je liek kompatibilný s periférnou žilou. Tento časový rámec však vychádza z odporúčania s veľmi nízkou kvalitou dôkazov a nenahrádza individuálne posúdenie vlastností roztoku ani stavu žíl.</p>

<p>Periférne zavedený centrálny katéter (PICC) poskytuje dlhodobejší prístup, ale prináša riziko trombózy, infekcie, oklúzie, malpozície a mechanických komplikácií. Zaviesť ho „pre istotu“ ešte pred rozhodnutím o potrebe a dĺžke intravenóznej liečby nie je správny postup.</p>

<h3>Pri chronickej chorobe obličiek treba chrániť žilové riečisko</h3>

<p>U pacienta s pokročilou chronickou chorobou obličiek môže PICC trombózou alebo stenózou poškodiť žily potrebné na budúce vytvorenie arteriovenóznej fistuly alebo graftu. IDSA preto pri pokročilej CKD odporúča skôr tunelizovaný centrálny venózny katéter než PICC, hoci toto silné odporúčanie stojí na dôkazoch nízkej kvality. KDOQI zároveň zdôrazňuje dlhodobý „ESKD Life-Plan“ a zachovanie cievnych možností pre budúce modality liečby.</p>

<p>Pri CKD G3b až G5, najmä ak je progresia pravdepodobná, má rozhodnutiu o PICC predchádzať konzultácia s nefrológom alebo tímom pre cievne prístupy. Nejde o absolútny zákaz každého PICC, ale o vedomé vyváženie bezprostrednej potreby antimikrobiálnej liečby a dlhodobej ochrany žíl.</p>

<p>U hemodialyzovaných pacientov možno vybrané lieky podať počas alebo po dialýze podľa protokolu dialyzačného pracoviska, čím sa môže predísť ďalšiemu katétru. Dávka a interval musia zohľadniť dialyzovateľnosť lieku, typ membrány, dĺžku a frekvenciu dialýzy, čas podania voči procedúre aj reziduálnu funkciu obličiek.</p>

<h2>Funkcia obličiek sa počas OPAT môže rýchlo meniť</h2>

<p>Jednorazový výpočet eGFR pri prepustení nestačí. Akútne ochorenie, zmeny hydratácie a objemu extracelulárnej tekutiny, sepsa, diuretiká, blokáda renínovo-angiotenzínového systému a ďalšie nefrotoxické lieky môžu eliminačnú kapacitu obličiek počas niekoľkých dní zásadne zmeniť.</p>

<p>Hodnota eGFR navyše nemusí zodpovedať parametru, podľa ktorého bola stanovená dávka v súhrne charakteristických vlastností konkrétneho lieku. Niektoré dávkovacie schémy vychádzajú z odhadovaného klírensu kreatinínu podľa Cockcroftovej-Gaultovej rovnice. Pri nestabilnej koncentrácii kreatinínu však statický odhad nemusí verne vystihovať aktuálnu funkciu obličiek bez ohľadu na použitú rovnicu.</p>

<p>Nedostatočná úprava dávky zvyšuje riziko akumulácie a toxicity; nadmerné zníženie môže viesť k subterapeutickej expozícii, zlyhaniu liečby a selekcii rezistencie. Dávkovanie sa preto musí priebežne prehodnocovať podľa trendu funkcie obličiek, klinického stavu, lieku, miesta infekcie a podľa možnosti aj terapeutického monitorovania koncentrácií.</p>

<h3>Lieky vyžadujúce osobitnú pozornosť</h3>

<ul>
  <li><strong>Vankomycín:</strong> pri závažných infekciách spôsobených MRSA konsenzus ASHP, IDSA, PIDS a SIDP uprednostňuje monitorovanie expozície podľa AUC pred samotným sledovaním minimálnej koncentrácie. Bežne uvádzaný cieľ AUC<sub>24</sub> 400 až 600 mg·h/l predpokladá MIC 1 mg/l stanovenú referenčnou mikrodilučnou metódou a nemožno ho nekriticky prenášať na každú diagnózu, populáciu ani metódu stanovenia MIC.</li>
  <li><strong>Aminoglykozidy:</strong> majú kumulatívne riziko nefrotoxicity a ototoxicity. Dlhšie ambulantné podávanie potrebuje presvedčivú indikáciu, individualizovaný farmakokinetický plán, terapeutické monitorovanie a aktívne zisťovanie porúch sluchu alebo rovnováhy.</li>
  <li><strong>Cefepím a ďalšie renálne eliminované betalaktámy:</strong> akumulácia môže vyvolať encefalopatiu, myoklónie alebo epileptické záchvaty. Renálna dysfunkcia patrí k najvýznamnejším rizikovým faktorom neurotoxicity cefepímu, ktorá sa môže objaviť aj napriek formálne upravenej dávke.</li>
  <li><strong>Daptomycín:</strong> vyžaduje sledovanie kreatínkinázy, svalových príznakov a funkcie obličiek. Častejšie kontroly môžu byť potrebné pri poruche funkcie obličiek, vyšších dávkach alebo súbežnej myotoxickej liečbe.</li>
</ul>

<h2>Monitorovanie nemožno zredukovať na automatický odber raz týždenne</h2>

<p>Britské odporúčania OPAT 2026 odporúčajú pri intravenóznej liečbe vykonať najmenej raz týždenne krvný obraz, vyšetrenie funkcie obličiek a pečene, CRP a terapeutické monitorovanie koncentrácií, ak je indikované. IDSA rovnako odporúča sériové laboratórne sledovanie, ale upozorňuje, že dôkazy nestačia na určenie jedného optimálneho súboru testov a frekvencie pre všetky lieky a všetkých pacientov.</p>

<p>Raz týždenne je teda praktické minimum aktuálneho britského štandardu, nie dôkaz, že takáto frekvencia postačuje každému. Kontroly majú byť častejšie napríklad pri:</p>

<ul>
  <li>nestabilnej alebo zhoršujúcej sa funkcii obličiek,</li>
  <li>pokročilej CKD alebo dialyzačnej liečbe,</li>
  <li>vysokom riziku nefrotoxicity, neurotoxicity alebo myelotoxicity,</li>
  <li>poruchách elektrolytov alebo objemového stavu,</li>
  <li>vysokých dávkach a súbežnej toxickej liečbe,</li>
  <li>dlhom trvaní terapie,</li>
  <li>nových klinických ťažkostiach alebo zmene liekov.</li>
</ul>

<p>Laboratórny výsledok, ktorý nikto včas nevyhodnotí, pacienta nechráni. Program musí vopred určiť, kto výsledky kontroluje, dokedy ich musí skontrolovať, ktoré hodnoty vyžadujú zásah, kto upraví dávku a kto kontaktuje pacienta. Súčasťou sledovania je aj klinická odpoveď, stav cievneho prístupu, nové mikrobiologické výsledky, interakcie, adherencia a opakované posúdenie možnosti deeskalácie alebo perorálneho prechodu.</p>

<h2>Pacient potrebuje konkrétny plán pre varovné príznaky</h2>

<p>Verbálne aj písomné pokyny musia obsahovať kontakt dostupný nepretržite a postup pri:</p>

<ul>
  <li>horúčke, triaške alebo novom zhoršení celkového stavu,</li>
  <li>dyspnoe, hypotenzii, synkope alebo poruche vedomia,</li>
  <li>vyrážke, opuchu tváre alebo príznakoch anafylaxie,</li>
  <li>bolesti, začervenaní, opuchu alebo sekrécii okolo katétra,</li>
  <li>opuchu končatiny s katétrom, jeho poškodení alebo nepriechodnosti,</li>
  <li>poklese diurézy, vracaní alebo významnej hnačke,</li>
  <li>svalovej slabosti, myalgiách, zmätenosti, myoklóniách alebo záchvate.</li>
</ul>

<p>Všeobecná veta „pri probléme choďte na urgentný príjem“ nie je plnohodnotný bezpečnostný plán. Pacient potrebuje vedieť, komu má zavolať, ktoré príznaky neznesú odklad a kam sa má dostaviť.</p>

<h2>Antimikrobiálna politika je jadrom, nie doplnkom OPAT</h2>

<p>Infektiologické alebo klinickomikrobiologické posúdenie pred začatím OPAT môže odhaliť nesprávnu diagnózu, chýbajúcu kontrolu zdroja, zbytočne široké spektrum, nevhodnú dávku, príliš dlhé trvanie alebo účinnú perorálnu alternatívu. Odporúčania 2026 zároveň požadujú pravidelnú kontrolu predpisu klinickým farmaceutom.</p>

<p>OPAT nemá predlžovať liečbu iba preto, že je logisticky uskutočniteľná. Má umožniť bezpečné pokračovanie parenterálnej terapie iba vtedy, keď je takáto cesta naďalej klinicky potrebná.</p>

<h2>Kedy OPAT radšej nezvoliť</h2>

<p>OPAT spravidla nie je vhodný, ak pacient zostáva nestabilný, potrebuje intenzívne monitorovanie alebo časté diagnostické výkony, nemá zabezpečenú potrebnú kontrolu zdroja infekcie, nedokáže bezpečne vykonávať potrebné úkony a nemá podporu, alebo ak nie sú dostupné laboratórne kontroly, odborný dohľad a urgentná pomoc.</p>

<p>Rovnako dôležitý je informovaný súhlas. Pacient má dostať vyvážené informácie a môže tento spôsob liečby odmietnuť. Ekonomický tlak na skrátenie hospitalizácie nesmie nahradiť klinické posúdenie ani preniesť neprimeranú časovú, finančnú a psychickú záťaž na rodinu.</p>

<h2>Ako hodnotiť kvalitu programu</h2>

<p>Počet ušetrených hospitalizačných dní nestačí. Sledovať treba klinické vyliečenie alebo dosiahnutie dohodnutého liečebného cieľa, neplánované návštevy urgentného príjmu, rehospitalizácie, nežiaduce účinky, akútne poškodenie obličiek, komplikácie cievneho prístupu, predčasné ukončenie liečby, infekcie spôsobené <em>Clostridioides difficile</em>, správnosť trvania liečby aj skúsenosť pacienta a opatrovateľa.</p>

<p>Aktuálne britské odporúčania navyše upozorňujú na nerovnosť prístupu. Bezpečnostné kritériá sú nevyhnutné, nemajú sa však zmeniť na mechanizmus, ktorý vylúči pacienta iba pre sociálne znevýhodnenie bez pokusu zabezpečiť primeranú podporu.</p>

<h2>Čo je podložené dôkazmi a kde zostáva neistota</h2>

<p>Odporúčania IDSA používajú metodiku GRADE, no viaceré konkrétne rozhodnutia o samopodávaní, type cievneho prístupu či frekvencii kontrol stoja na dôkazoch nízkej alebo veľmi nízkej kvality. Britské odporúčania 2026 vznikli aktualizovaným prehľadom literatúry, odborným konsenzom a širokou konzultáciou; ich vyhľadávanie zahŕňalo práce publikované do apríla 2024.</p>

<p>Preto možno spoľahlivo tvrdiť, že OPAT má fungovať ako formálne riadený proces s výberom pacienta, monitorovaním a dostupnou eskaláciou starostlivosti. Nemožno však z jedného modelu alebo observačného súboru odvodiť univerzálny kauzálny účinok na mortalitu či rehospitalizácie. Konkrétny liek, dávka, cievny prístup a frekvencia kontrol sa musia prispôsobiť pacientovi, infekcii, miestnym protokolom a súhrnu charakteristických vlastností lieku.</p>

<h2>Záver</h2>

<p>OPAT môže podporiť mobilitu a autonómiu pacienta, skrátiť hospitalizáciu a uvoľniť nemocničnú kapacitu. Tieto výhody nevznikajú samotným prepustením pacienta s intravenóznym antibiotikom.</p>

<p>Bezpečnosť stojí na správnej indikácii, kontrole zdroja infekcie, včasnom prechode na perorálnu liečbu, kompetentnom tíme, vhodnom cievnom prístupe, individualizovanom dávkovaní a výsledkoch, na ktoré niekto včas reaguje. Pri chronickej chorobe obličiek k tomu pristupuje povinnosť chrániť žily pre budúci dialyzačný prístup a priebežne prispôsobovať liečbu meniacej sa funkcii obličiek.</p>

<p><strong>OPAT nie je menej intenzívna medicína. Je to intenzívne riadená liečba poskytovaná mimo nemocničného lôžka.</strong></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou">Kedy vytvoriť cievny prístup pred začatím hemodialýzy</a>.</li>
  <li><a href="article.php?slug=antimikrobialna-rezistencia-infekcie-mocovych-ciest-nefrologia">Antimikrobiálna rezistencia pri infekciách močových ciest</a>.</li>
  <li><a href="article.php?slug=kedy-zacat-krt-pri-aki">Kedy začať náhradu funkcie obličiek pri AKI</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Ann L. Noble, Sanjay Patel, Ellie Birnie, Eileen Dorgan, Oyewole C. Durojaiye, Caroline Emilie, Achyut Guleri, Helen Green, Sara Hedderwick, Lucy Hinds, Monica V. Mahoney, Katie McIntyre, Fekade B. Sime, Owen Seddon, Julie Statham, Marie Woodley, Mark Gilchrist, R. Andrew Seaton.</strong> <em>2026 Updated good practice recommendations for outpatient parenteral antimicrobial therapy (OPAT) in adults and children in the UK.</em> JAC-Antimicrobial Resistance. 2026;8(2):dlag044. doi: 10.1093/jacamr/dlag044. <a href="https://doi.org/10.1093/jacamr/dlag044" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42028542/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Anne H. Norris, Nabin K. Shrestha, Genève M. Allison, Sara C. Keller, Kavita P. Bhavan, John J. Zurlo, Adam L. Hersh, Lisa A. Gorski, John A. Bosso, Mobeen H. Rathore, Antonio Arrieta, Russell M. Petrak, Akshay Shah, Richard B. Brown, Shandra L. Knight, Craig A. Umscheid.</strong> <em>2018 Infectious Diseases Society of America Clinical Practice Guideline for the Management of Outpatient Parenteral Antimicrobial Therapy.</em> Clinical Infectious Diseases. 2019;68(1):e1–e35. doi: 10.1093/cid/ciy745. <a href="https://www.idsociety.org/practice-guideline/outpatient-antimicrobial-parenteral-therapy/" target="_blank" rel="noopener noreferrer">IDSA</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/30423035/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Michael J. Rybak, Jennifer Le, Thomas P. Lodise, Donald P. Levine, John S. Bradley, Catherine Liu, Bruce A. Mueller, Manjunath P. Pai, Annie Wong-Beringer, John C. Rotschafer, Keith A. Rodvold, Holly D. Maples, Benjamin M. Lomaestro.</strong> <em>Therapeutic monitoring of vancomycin for serious methicillin-resistant Staphylococcus aureus infections: a revised consensus guideline and review.</em> American Journal of Health-System Pharmacy. 2020;77(11):835–864. doi: 10.1093/ajhp/zxaa036. <a href="https://doi.org/10.1093/ajhp/zxaa036" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Charmaine E. Lok, Thomas S. Huber, Timmy Lee, Surendra Shenoy, Alexander S. Yevzlin, Kenneth Abreo, Michael Allon, Arif Asif, Brad C. Astor, Marc H. Glickman, Janet Graham, Louise M. Moist, Dheeraj K. Rajan, Cynthia Roberts, Tushar J. Vachharajani, Rudolph P. Valentini; National Kidney Foundation.</strong> <em>KDOQI Clinical Practice Guideline for Vascular Access: 2019 Update.</em> American Journal of Kidney Diseases. 2020;75(4 Suppl 2):S1–S164. doi: 10.1053/j.ajkd.2019.12.001. <a href="https://doi.org/10.1053/j.ajkd.2019.12.001" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/32778223/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Gozun Maan, Koichi Keitoku, Nobuhiko Kimura, Haruki Sawada, Andrew Pham, Jihun Yeo, Hideharu Hagiya, Yoshito Nishimura.</strong> <em>Cefepime-induced neurotoxicity: systematic review.</em> Journal of Antimicrobial Chemotherapy. 2022;77(11):2908–2921. doi: 10.1093/jac/dkac271. <a href="https://doi.org/10.1093/jac/dkac271" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/35971666/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Medscape Education.</strong> <em>Medscape NOW! Optimizing Outpatient Parenteral Antimicrobial Therapy: Aligning Hospital-at-Home Care.</em> 2026. <a href="https://www.medscape.org/viewarticle/medscape-now-optimizing-outpatient-parenteral-antimicrobial-2026a1000rcl?page=1" target="_blank" rel="noopener noreferrer">Vzdelávacia aktivita</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Kľúčovým spracovaným zdrojom sú otvorene dostupné britské odporúčania OPAT 2026; ich bibliografické údaje a autorstvo boli overené v PubMed. Dodaná vzdelávacia aktivita Medscape bola pri kontrole prístupná iba po prihlásení, preto slúžila ako tematický podnet a nie ako samostatný podklad klinických tvrdení. Odporúčania treba zavádzať podľa miestnych kompetencií, dostupnosti služieb, schválených informácií o lieku a individuálneho klinického úsudku.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ambulantna-parenteralna-antimikrobialna-liecba-opat_article',
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
