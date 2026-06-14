<?php
/**
 * add_moderne-trendy-v-nefroprotekcii_article.php
 * Popularizačný článok (sekcia „Pre pacientov") — spracované z DOCX vrátane
 * 22 AI ilustrácií (img/nefroprot-01..nefroprot-22). Obrázky sú klikateľné (nová karta).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_moderne-trendy-v-nefroprotekcii_article.php"
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať popularizačný článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
$articles = [];

$articles[] = [
    'title'        => 'Moderné trendy v nefroprotekcii',
    'slug'         => 'moderne-trendy-v-nefroprotekcii',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 1,
    'excerpt'      => 'Moderné lieky pri cukrovke chránia nielen hladinu cukru, ale aj srdce a obličky. Zrozumiteľne o SGLT2 inhibítoroch, GLP-1 agonistoch, nsMRA a o tom, čo môže pre svoje obličky urobiť sám pacient.',
    'content'      => <<<'NEFRO_HTML'
<figure class="article-figure">
  <a href="img/nefroprot-01.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-01.webp" alt="Ilustrácia: moderné trendy v nefroprotekcii pri cukrovke" loading="lazy" decoding="async">
  </a>
  <figcaption>Moderná liečba cukrovky chráni nielen hladinu cukru, ale aj srdce a obličky.</figcaption>
</figure>

<p class="article-dek"><em>Moderné lieky pri cukrovke chránia nielen hladinu cukru, ale aj srdce a obličky, čo môže pacientom dodať pocit nádeje a dôvery v liečbu.</em></p>

<p>Liečba cukrovky sa za posledné roky výrazne zmenila. Kedysi sa pozornosť sústreďovala najmä na hladinu cukru v krvi. Dnes vieme, že dobrá liečba diabetu má robiť viac. Má chrániť cievy, srdce, mozog a obličky. Práve obličky patria medzi orgány, ktoré cukrovka ohrozuje najčastejšie a často aj nenápadne.</p>

<p>Chronická choroba obličiek môže roky prebiehať bez bolesti a výrazných ťažkostí. Pacient sa môže cítiť relatívne dobre, hoci v moči už môže byť prítomná bielkovina a filtračná schopnosť obličiek sa postupne znižuje. Preto je dôležité obličky nielen liečiť, keď už sú výrazne poškodené, ale aj ich včas chrániť. Tento prístup nazývame <strong>nefroprotekciou</strong>.</p>

<p>Moderná nefroprotekcia zahŕňa nielen kontrolu krvného tlaku a cukru, ale aj nové lieky, ako sú inhibítory SGLT2 a agonisti GLP-1, ktoré sú kľúčové pre ochranu obličiek a srdca, čím sa zdôrazňuje význam včasnej liečby.</p>

<h2>Prečo cukrovka poškodzuje obličky</h2>

<p>Obličky sú jemné filtračné orgány. Denne prefiltrovávajú veľké množstvo krvi, odstraňujú odpadové látky, regulujú množstvo vody a solí v tele a podieľajú sa aj na riadení krvného tlaku.</p>

<p>Pri cukrovke pôsobí na obličky viacero škodlivých vplyvov naraz. Zvýšená hladina glukózy poškodzuje drobné cievy, zhoršuje funkciu filtračných jednotiek obličky a podporuje zápalové a jazvovité zmeny v obličkovom tkanive. Často sa pridávajú vysoký krvný tlak, porucha tukového metabolizmu, nadváha a zvýšené riziko aterosklerózy.</p>

<p>Jedným z prvých signálov poškodenia obličiek býva zvýšené vylučovanie albumínu do moču. Albumín je bielkovina, ktorá by sa za normálnych okolností mala v moči nachádzať len vo veľmi malom množstve. Ak jej je viac, znamená to, že filtračná bariéra obličiek je poškodená. Tento nález sa označuje ako <strong>albuminúria</strong>.</p>

<p>Odhadovaná glomerulová filtrácia (eGFR) je kľúčová pre včasné odhalenie poškodenia obličiek. Pravidelné vyšetrenia vám môžu poskytnúť pocit kontroly a istoty v starostlivosti o vaše zdravie.</p>

<figure class="article-figure">
  <a href="img/nefroprot-02.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-02.webp" alt="Ilustrácia k téme: prečo cukrovka poškodzuje obličky" loading="lazy" decoding="async">
  </a>
  <figcaption>Prečo cukrovka poškodzuje obličky</figcaption>
</figure>

<h2>Staré základy liečby zostávajú dôležité</h2>

<p>Naďalej platí, že základné opatrenia, ako je kontrola krvného tlaku a hladiny cukru, sú spoľahlivou cestou na ochranu obličiek. Dôvera v overené metódy posilňuje vašu istotu.</p>

<p>Medzi klasické lieky s ochranným účinkom na obličky patria najmä ACE inhibítory alebo sartany, teda lieky často používané pri vysokom krvnom tlaku a albuminúrii. Znižujú tlak v obličkových klbkách (glomeruloch) a pomáhajú znižovať únik bielkovín do moču. U mnohých pacientov zostávajú základným pilierom nefroprotekcie.</p>

<p>Nové lieky tento základ <strong>nenahrádzajú</strong>, ale ho dopĺňajú.</p>

<figure class="article-figure">
  <a href="img/nefroprot-03.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-03.webp" alt="Ilustrácia k téme: staré základy liečby zostávajú dôležité" loading="lazy" decoding="async">
  </a>
  <figcaption>Staré základy liečby zostávajú dôležité</figcaption>
</figure>

<h2>SGLT2 inhibítory: lieky, ktoré zmenili pohľad na obličky</h2>

<p>SGLT2 inhibítory sú lieky, ktoré pôvodne vznikli ako liečba cukrovky 2. typu. Ich účinok spočíva v tom, že v obličkách znižujú spätné vstrebávanie glukózy. Časť cukru sa potom vylúči močom. Tým sa zníži hladina glukózy v krvi.</p>

<p>Veľké klinické štúdie preukázali, že SGLT2 inhibítory dokážu znížiť riziko zhoršenia chronickej choroby obličiek, riziko hospitalizácie pre srdcové zlyhávanie a priaznivo ovplyvniť prognózu pacientov s vysokým kardiovaskulárnym rizikom. Tieto dôkazy posilňujú ich význam v modernom liečebnom protokole.</p>

<p>Najčastejšie sa v praxi uvádzajú tieto štúdie:</p>

<ul>
  <li><strong>Chronická choroba obličiek (CKD):</strong> DAPA-CKD, CREDENCE, EMPA-KIDNEY</li>
  <li><strong>Srdcové zlyhávanie (HF):</strong> DAPA-HF, EMPEROR-Reduced, EMPEROR-Preserved</li>
  <li><strong>Kardiovaskulárne riziko</strong> (v širšom zmysle, vrátane diabetu 2. typu): DECLARE–TIMI 58</li>
</ul>

<p>Zjednodušene povedané, nejde už iba o lieky „na cukor“. Sú to lieky s ochranným účinkom na obličky a srdce.</p>

<figure class="article-figure">
  <a href="img/nefroprot-04.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-04.webp" alt="Ilustrácia: kľúčové štúdie so SGLT2 inhibítormi" loading="lazy" decoding="async">
  </a>
  <figcaption>SGLT2 inhibítory — kľúčové klinické štúdie</figcaption>
</figure>

<h3>Ako SGLT2 inhibítory chránia obličky</h3>

<p>Ich ochranný účinok nespočíva iba v znížení glykémie. Veľmi dôležitý je ich vplyv na tlakové pomery vo vnútri obličkových klbiek (glomerulov). Pri cukrovke bývajú tieto klbká často preťažované. Pracujú pod zvýšeným tlakom, čo urýchľuje ich poškodenie.</p>

<p>SGLT2 inhibítory pomáhajú znižovať vnútroobličkový tlak, čím chránia obličky pred poškodením, a ich účinok je dôležitý v moderných liečebných stratégiách na ochranu obličiek.</p>

<p>Tieto lieky môžu tiež mierne znižovať hmotnosť, krvný tlak a množstvo tekutín v tele. To je výhodné najmä u pacientov so srdcovým zlyhávaním alebo so sklonom k opuchom. Nejde však o močopudné lieky v klasickom zmysle slova.</p>

<figure class="article-figure">
  <a href="img/nefroprot-05.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-05.webp" alt="Ilustrácia: ako SGLT2 inhibítory chránia obličky" loading="lazy" decoding="async">
  </a>
  <figcaption>Ako SGLT2 inhibítory chránia obličky</figcaption>
</figure>

<h3>Pre koho môžu byť SGLT2 inhibítory vhodné</h3>

<p>O vhodnosti liečby rozhoduje lekár podľa celkového stavu pacienta, funkcie obličiek, prítomnosti albuminúrie, srdcového zlyhávania, diabetu a ďalších ochorení. Kritériá zahŕňajú hodnoty eGFR, prítomnosť albuminúrie a celkový kardiovaskulárny rizikový profil. Dnes sa tieto lieky používajú nielen u pacientov s cukrovkou 2. typu, ale v určitých situáciách aj u pacientov s chronickou chorobou obličiek alebo srdcovým zlyhávaním bez cukrovky, čím sa rozširujú ich indikácie.</p>

<p>To je zásadná zmena. Ukazuje sa, že ochranný účinok tejto skupiny liekov presahuje samotné zníženie hladiny cukru v krvi.</p>

<figure class="article-figure">
  <a href="img/nefroprot-06.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-06.webp" alt="Ilustrácia: pre koho môžu byť SGLT2 inhibítory vhodné" loading="lazy" decoding="async">
  </a>
  <figcaption>Pre koho môžu byť SGLT2 inhibítory vhodné</figcaption>
</figure>

<h3>Na čo si dať pozor pri SGLT2 inhibítoroch</h3>

<p>Tak ako všetky lieky, aj SGLT2 inhibítory majú svoje riziká. Dôležité je vyhýbať sa neschváleným peptidom a reklamám na sociálnych sieťach, aby ste si zachovali dôveru v overené informácie a starostlivosť.</p>

<p>Opatrnosť je potrebná pri stavoch spojených s dehydratáciou, vracaním, hnačkami, horúčkou, hladovaním alebo pred niektorými operačnými zákrokmi. V takýchto situáciách môže lekár odporučiť dočasné prerušenie liečby. Pacient by si však nemal liek vysadzovať svojvoľne bez dohody s lekárom, ak nejde o akútny stav alebo o jasné vopred dané poučenie.</p>

<p>Zriedkavou, ale závažnou komplikáciou môže byť <strong>ketoacidóza</strong>, ktorá sa výnimočne môže objaviť aj pri veľmi vysokej hladine cukru. Preto je dôležité, aby pacient poznal varovné príznaky, ako sú nevoľnosť, vracanie, bolesti brucha, zrýchlené dýchanie, výrazná slabosť alebo zmätenosť.</p>

<figure class="article-figure">
  <a href="img/nefroprot-07.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-07.webp" alt="Ilustrácia: na čo si dať pozor pri SGLT2 inhibítoroch" loading="lazy" decoding="async">
  </a>
  <figcaption>Na čo si dať pozor pri SGLT2 inhibítoroch</figcaption>
</figure>

<h2>GLP-1 receptorové agonisty: viac než lieky na chudnutie</h2>

<p>Druhou významnou skupinou moderných liekov sú agonisti receptora GLP-1. Napodobňujú účinok prirodzeného črevného hormónu GLP-1. Ten sa podieľa na regulácii tvorby inzulínu, spomaľuje vyprázdňovanie žalúdka, znižuje chuť do jedla a priaznivo ovplyvňuje metabolizmus.</p>

<p>Tieto lieky sa používajú pri liečbe cukrovky 2. typu a niektoré z nich aj pri liečbe obezity. V posledných rokoch sa dostali do veľkej pozornosti verejnosti najmä pre svoj účinok pri znižovaní hmotnosti. Jeho význam je však širší.</p>

<p>U pacientov s diabetom 2. typu, obezitou a vysokým srdcovocievnym rizikom môžu agonisty GLP-1 receptora znižovať riziko závažných kardiovaskulárnych príhod. Pri obličkách sa ich prínos prejavuje najmä znížením albuminúrie a priaznivým ovplyvnením rizikových faktorov, ako sú hmotnosť, glykémia, krvný tlak a zápalovo-metabolické zaťaženie organizmu.</p>

<figure class="article-figure">
  <a href="img/nefroprot-08.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-08.webp" alt="Ilustrácia: GLP-1 agonisti — viac než lieky na chudnutie" loading="lazy" decoding="async">
  </a>
  <figcaption>GLP-1 receptorové agonisty — viac než lieky na chudnutie</figcaption>
</figure>

<h3>Ako môžu GLP-1 receptorové agonisty pomáhať obličkám</h3>

<p>Ich účinok na obličky je odlišný od účinku inhibítorov SGLT2. GLP-1 receptorové agonisty zlepšujú metabolické prostredie organizmu. Pomáhajú znižovať hladinu cukru bez výrazného rizika hypoglykémie, ak sa nepoužívajú v kombinácii s liekmi, ktoré hypoglykémiu vyvolávajú. Znižujú chuť do jedla a často vedú k poklesu hmotnosti.</p>

<p>To je pre obličky dôležité. Obezita, inzulínová rezistencia a vysoký krvný tlak zvyšujú záťaž obličiek. Ak sa tieto faktory zlepšia, obličky budú vystavené menšiemu dlhodobému tlaku.</p>

<p>Niektoré odporúčania uprednostňujú GLP-1 receptorové agonisty s preukázaným kardiovaskulárnym prínosom najmä u pacientov s diabetom 2. typu a chronickou chorobou obličiek, ak nie je dostatočne dosiahnutá glykemická kontrola napriek metformínu a SGLT2 inhibítoru, alebo ak tieto lieky pacient nemôže užívať.</p>

<figure class="article-figure">
  <a href="img/nefroprot-09.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-09.webp" alt="Ilustrácia: ako môžu GLP-1 agonisty pomáhať obličkám" loading="lazy" decoding="async">
  </a>
  <figcaption>Ako môžu GLP-1 receptorové agonisty pomáhať obličkám</figcaption>
</figure>

<h3>Najčastejšie nežiaduce účinky GLP-1 liekov</h3>

<p>Najčastejšie ide o tráviace ťažkosti. Pacienti môžu mať nevoľnosť, pocit plnosti, nechutenstvo, vracanie, hnačku alebo zápchu. Tieto ťažkosti bývajú najvýraznejšie na začiatku liečby alebo pri zvyšovaní dávky a často sa časom zmiernia.</p>

<p>Dôležité je pomalé navyšovanie dávky podľa odporúčania lekára a primerané stravovanie. Pacient by nemal jesť veľké porcie ani mastné jedlá a nemal by sa nútiť do jedla, ak má výrazný pocit sýtosti.</p>

<p>Tieto lieky nie sú vhodné pre každého. Lekár musí zohľadniť osobnú anamnézu, ochorenia pankreasu, žlčníka, tráviace ťažkosti a ďalšie riziká. Aj tu platí, že dobrý liek je dobrý iba vtedy, keď je správne vybraný pre konkrétneho pacienta.</p>

<figure class="article-figure">
  <a href="img/nefroprot-10.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-10.webp" alt="Ilustrácia: najčastejšie nežiaduce účinky GLP-1 liekov" loading="lazy" decoding="async">
  </a>
  <figcaption>Najčastejšie nežiaduce účinky GLP-1 liekov</figcaption>
</figure>

<h2>Čo sú tirzepatid a retatrutid?</h2>

<p>Tirzepatid je liek, ktorý pôsobí na receptory GLP-1 a GIP, čím má dvojitý účinok. Klinické štúdie skúmajú jeho vplyv na glykémiu, hmotnosť a metabolické parametre. Momentálne je tirzepatid klinicky dostupný pre pacientov, avšak nie je hradený zdravotným poistením. Tento liek je predmetom ďalšieho monitorovania. To umožní rýchle získanie nových informácií o bezpečnosti. Od zdravotníckych pracovníkov sa vyžaduje, aby hlásili akékoľvek podozrenia na nežiaduce reakcie.</p>

<p>Retatrutid je liečivo, ktoré cieli na GLP-1, GIP aj glukagón (tzv. triple, teda trojitý agonista). V štúdiách sa hodnotí najmä jeho potenciál dosiahnuť výraznejšie zmeny v hmotnosti a ďalších metabolických ukazovateľoch. Nie je ešte schválený na bežné klinické použitie.</p>

<figure class="article-figure">
  <a href="img/nefroprot-11.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-11.webp" alt="Ilustrácia: tirzepatid a retatrutid" loading="lazy" decoding="async">
  </a>
  <figcaption>Tirzepatid a retatrutid</figcaption>
</figure>

<h3>Prečo ich ľudia sledujú aj pri diabete 2. typu?</h3>

<p>Aj keď sa niektoré účinky spájajú s chudnutím, sú tu aj ďalšie možné benefity:</p>

<ul>
  <li>zlepšenie metabolizmu (cukor v krvi, inzulínová rezistencia),</li>
  <li>pokles hmotnosti, ktorý nepriamo znižuje záťaž pre organizmus,</li>
  <li>sledovanie, či sa časom zlepší aj kardiometabolické riziko a bezpečnostný profil.</li>
</ul>

<h3>Čo znamená pre pacienta „vo fáze klinických štúdií“?</h3>

<p>Významné je, že ide o lieky, ktoré ešte prechádzajú vývojom:</p>

<ul>
  <li>výskumníci sledujú účinnosť aj bezpečnosť,</li>
  <li>zbierajú sa údaje o dlhodobých výsledkoch,</li>
  <li>nastavenia dávkovania a podmienky užívania sa upresňujú pre rôzne skupiny pacientov.</li>
</ul>

<p>Konkrétne použitie liekov závisí od schválených indikácií, dostupnosti a rozhodnutia lekára. Pri liekoch vo vývoji sa preto vždy treba držať aktuálnych odporúčaní a informácií z primárnych zdrojov.</p>

<h2>nsMRA: nové možnosti ochrany obličiek a srdca</h2>

<p>nsMRA je skratka pre non-steroidal mineralocorticoid receptor antagonists, po slovensky ide o lieky, ktoré blokujú mineralokortikoidný receptor (nie sú to „klasické“ steroidné antagonisty). V praxi sa najčastejšie stretávame s <strong>finerenónom</strong>. Tieto lieky majú význam najmä pri diabetickej chorobe obličiek.</p>

<figure class="article-figure">
  <a href="img/nefroprot-12.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-12.webp" alt="Ilustrácia: nsMRA — nové možnosti ochrany obličiek a srdca" loading="lazy" decoding="async">
  </a>
  <figcaption>nsMRA — nové možnosti ochrany obličiek a srdca</figcaption>
</figure>

<h3>Pre koho to dáva zmysel</h3>

<p>nsMRA sa zvyčajne zvažujú u ľudí s:</p>

<ul>
  <li>diabetom 2. typu,</li>
  <li>chronickou chorobou obličiek,</li>
  <li>a albuminúriou (vyšším únikom bielkovín do moču), pričom pacient má často už nasadenú štandardnú liečbu, ako sú ACE inhibítory alebo ARB (ak ich toleruje).</li>
</ul>

<h3>Čo je na tom dôležité</h3>

<p>Pri diabetickej chorobe obličiek nejde len o „cukor“, ale aj o zápal a poškodenie tkanív. Finerenón môže pomôcť spomaliť progresiu ochorenia obličiek a zároveň znižovať riziká v kardiovaskulárnej oblasti. V klinických štúdiách sa ukázali prínosy pri obličkách aj pri srdcovo-cievnych príhodách.</p>

<h3>Najväčšie „ale“: draslík (hyperkaliémia)</h3>

<p>Najdôležitejším rizikom nsMRA je zvýšenie hladiny draslíka v krvi. Preto sa musí sledovať hladina kália a liečba sa podľa výsledkov dávkuje alebo dočasne pozastaví. Prakticky sa v štúdiách používali hranice, napríklad pri hodnotách draslíka nad približne 5,5 mmol/l sa liek zvyčajne zadrží a znovu sa nasadí po poklese. Presný postup sa riadi odporúčaniami a lokálnym nastavením.</p>

<p>Ako to pacient vníma v každodennom živote:</p>

<ul>
  <li>kontroluje sa krv (draslík, obličkové parametre),</li>
  <li>lekár sleduje rizikové situácie, kde sa draslík môže ľahko zvýšiť (napríklad niektoré kombinácie liekov),</li>
  <li>liek nevysádza pacient svojvoľne, ale rieši to s lekárom, najmä ak sa zmení zdravotný stav alebo laboratórne hodnoty.</li>
</ul>

<h2>Výskumné peptidy, zneužívanie a čo by sa malo zmeniť</h2>

<p>V posledných mesiacoch pribúda na internete a v reklame na sociálnych sieťach obsah, ktorý láka ľudí na „výskumné peptidy“. Často sa predávajú pod označeniami typu <em>research grade</em>, <em>for research use only</em> alebo podobne. Problém je, že toto označenie neznamená bezpečnosť ani to, že ide o látky overené pre bežných pacientov.</p>

<figure class="article-figure">
  <a href="img/nefroprot-13.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-13.webp" alt="Ilustrácia: výskumné peptidy a riziká neoverených látok" loading="lazy" decoding="async">
  </a>
  <figcaption>Výskumné peptidy — prečo je opatrnosť na mieste</figcaption>
</figure>

<h3>Prečo je to nebezpečné</h3>

<ul>
  <li><strong>Nie sú to lieky, ktoré prešli bežným schvaľovacím procesom pre pacientov.</strong> Regulátori opakovane upozorňujú na predaj produktov, ktoré nie sú schválené a môžu byť aj nesprávne označené (napríklad ako určené „na výskum“, ale predávané spotrebiteľom).</li>
  <li><strong>Obsah a kvalita nemusia zodpovedať tomu, čo tvrdí reklama.</strong> Pri „výskumných“ produktoch môže byť problém v čistote, účinnosti, stabilite, sterilite a konzistencii dávok. A keď človek nevie, čo presne dostáva, nevie ani bezpečne nastaviť riziká.</li>
  <li><strong>Dávkovanie a „protokoly“ bývajú prebraté z internetu, nie z medicínskej indikácie.</strong> Tvorcovia obsahu často používajú vlastné „návody“ a dávkovacie schémy bez toho, aby bolo jasné, či ide o reálny klinický plán pre konkrétneho človeka.</li>
</ul>

<h3>Ako sa to zneužíva v praxi</h3>

<ul>
  <li>„Influenceri“ a tvorcovia obsahu prezentujú peptidy ako „prírodnejší“ alebo „bezpečnejší“ variant liečby, hoci pri neschválených látkach to nemusí byť pravda.</li>
  <li>Platená spolupráca a skryté odporúčania môžu vytvoriť dojem, že ide o overenú informáciu. Bez jasného označenia spolupráce a bez medicínskej zodpovednosti to klame.</li>
  <li>Strach a nádej idú ruka v ruke. Ľudia s cukrovkou hľadajú riešenie na hmotnosť, inzulínovú rezistenciu alebo „lepšie čísla“ a práve to sa v reklame často zneužíva.</li>
</ul>

<h3>Čo je na mieste pre čitateľov</h3>

<p>Ak uvažujete o akomkoľvek „peptide“, hlavná kontrolná otázka je: ide o schválenú liečbu pre pacienta alebo o neschválenú látku predávanú pod rúškom „výskumu“? Odporúčania pre bezpečnejší postup:</p>

<ul>
  <li>Nezačínajte bez dohľadu lekára, najmä ak máte diabetes 2. typu a už užívate lieky na cukor alebo máte ochorenie obličiek.</li>
  <li>Zaobstarajte si informáciu z primárneho zdroja (vaše aktuálne odporúčania, SPC, regulátorské informácie) a nie z reklamy ani z „recenzií“.</li>
  <li>Ak reklama sľubuje rýchly efekt a „garantované výsledky“, berte to ako varovný signál.</li>
</ul>

<p>Krátka realita pre diabetikov: ak je niečo v reklame „nové“, „tajné“ alebo „z výskumu“, nemusí to byť bezpečnejšie. Pri cukrovke ide o liečbu, kde rozhoduje presnosť a sledovanie, nie iba trend.</p>

<h2>Čo znamená „kardiorenometabolická“ liečba</h2>

<p>V modernej medicíne sa čoraz viac používa pojem kardiorenometabolickej ochrany. Znie to zložito, ale jeho význam je jednoduchý. Srdce, obličky a metabolizmus úzko súvisia.</p>

<p>Pacient s cukrovkou má často zvýšené riziko infarktu, mozgových príhod, srdcového zlyhávania aj chronickej choroby obličiek. Ak sa zhorší funkcia obličiek, stúpa riziko srdcových príhod. Ak zlyháva srdce, zhoršuje sa prekrvenie obličiek. Ak sú zle kontrolované cukrovka a nadváha, trpia tým cievy aj obličky.</p>

<p>Preto moderná liečba nemá riešiť iba jednu izolovanú laboratórnu hodnotu. Má znižovať <strong>celkové riziko</strong> pacienta.</p>

<figure class="article-figure">
  <a href="img/nefroprot-14.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-14.webp" alt="Ilustrácia: čo znamená kardiorenometabolická liečba" loading="lazy" decoding="async">
  </a>
  <figcaption>Srdce, obličky a metabolizmus úzko súvisia</figcaption>
</figure>

<h2>Prečo nestačí sledovať iba cukor</h2>

<p>Hodnota glykovaného hemoglobínu je dôležitá. Ukazuje priemernú úroveň glykémie za posledné týždne až mesiace. Nie je však jediným ukazovateľom úspešnej liečby.</p>

<p>Pacient môže mať prijateľnú hladinu cukru, ale zároveň vysoký krvný tlak, albuminúriu, obezitu, zvýšené hladiny tukov v krvi a vysoké riziko srdcového zlyhávania. V takom prípade nestačí povedať, že „cukor je dobrý“. Potrebné je pozrieť sa na celý obraz.</p>

<p>Pri diabete 2. typu sa preto čoraz viac hodnotí, či liečba chráni pacienta aj pred komplikáciami, ktoré najviac skracujú život a znižujú jeho kvalitu.</p>

<figure class="article-figure">
  <a href="img/nefroprot-15.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-15.webp" alt="Ilustrácia: prečo nestačí sledovať iba cukor" loading="lazy" decoding="async">
  </a>
  <figcaption>Prečo nestačí sledovať iba cukor</figcaption>
</figure>

<h2>Čo by mal pacient vedieť a sledovať</h2>

<p>Pacient s cukrovkou by mal poznať nielen hladinu cukru, ale aj základné údaje o stave obličiek a srdcovo-cievnom riziku. Mal by sa zaujímať najmä o tieto hodnoty:</p>

<ul>
  <li>krvný tlak,</li>
  <li>glykovaný hemoglobín,</li>
  <li>eGFR, teda odhadovanú filtračnú schopnosť obličiek,</li>
  <li>albumín v moči, najčastejšie ako pomer albumín/kreatinín,</li>
  <li>hladiny cholesterolu a tukov v krvi,</li>
  <li>telesnú hmotnosť a obvod pása,</li>
  <li>prítomnosť opuchov, dýchavice alebo zníženej tolerancie námahy.</li>
</ul>

<p>Vyšetrenie moču na albuminúriu je jednoduché, ale veľmi dôležité. Môže odhaliť riziko skôr, než sa kreatinín v krvi výrazne zvýši.</p>

<figure class="article-figure">
  <a href="img/nefroprot-16.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-16.webp" alt="Ilustrácia: čo by mal pacient vedieť a sledovať" loading="lazy" decoding="async">
  </a>
  <figcaption>Čo by mal pacient vedieť a sledovať</figcaption>
</figure>

<h2>Liečba musí byť individuálna</h2>

<p>Moderné lieky priniesli veľký pokrok, ale neznamená to, že každý pacient má užívať všetko. Liečba musí byť prispôsobená veku, funkcii obličiek, pridruženým ochoreniam, riziku hypoglykémie, hmotnosti, tlaku krvi, liekovým interakciám, tolerancii a možnostiam úhrady.</p>

<p>Iný postup môže byť vhodný pre mladšieho pacienta s obezitou a začínajúcou albuminúriou, iný pre staršieho pacienta s pokročilou chronickou chorobou obličiek, nízkym tlakom a rizikom dehydratácie. Preto je dôležitý pravidelný kontakt s diabetológom, nefrológom, kardiológom a praktickým lekárom.</p>

<p>Pacient by sa nemal báť opýtať, či je preňho vhodná liečba s ochranným účinkom na obličky a srdce. Zároveň by však nemal žiadať konkrétny liek iba preto, že o ňom čítal na internete alebo ho užíva niekto známy.</p>

<figure class="article-figure">
  <a href="img/nefroprot-17.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-17.webp" alt="Ilustrácia: liečba musí byť individuálna" loading="lazy" decoding="async">
  </a>
  <figcaption>Liečba musí byť individuálna</figcaption>
</figure>

<h2>Čo môže pacient urobiť sám</h2>

<p>Lieky sú dôležité, ale nenahradia každodenné rozhodnutia. Obličkám pomáha dobrá kontrola tlaku, nefajčenie, primeraný pohyb, redukcia nadváhy, rozumný príjem soli, pravidelné kontroly a opatrnosť pri užívaní voľnopredajných liekov proti bolesti.</p>

<p>Najmä nesteroidné protizápalové lieky, často používané pri bolestiach kĺbov alebo chrbtice, môžu u rizikových pacientov zhoršiť funkciu obličiek. Neznamená to, že sú vždy zakázané, ale pacient s cukrovkou a chorobou obličiek by ich nemal užívať dlhodobo bez porady s lekárom.</p>

<p>Dôležitý je aj pitný režim. Nemá byť ani extrémne nízky, ani prehnaný. Pri srdcovom zlyhávaní alebo pokročilej chorobe obličiek môže lekár odporučiť individuálne obmedzenie príjmu tekutín.</p>

<figure class="article-figure">
  <a href="img/nefroprot-18.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-18.webp" alt="Ilustrácia: čo môže pacient urobiť sám" loading="lazy" decoding="async">
  </a>
  <figcaption>Čo môže pacient urobiť sám</figcaption>
</figure>

<h2>Otázky, ktoré sa oplatí položiť lekárovi</h2>

<p>Pacient s cukrovkou, vysokým krvným tlakom alebo chronickou chorobou obličiek by sa nemal báť aktívne sa pýtať. Dobrá otázka často pomôže odhaliť riziko skôr, než sa objavia vážne ťažkosti. Pri najbližšej kontrole sa oplatí spýtať napríklad:</p>

<ul>
  <li>Aká je moja aktuálna funkcia obličiek, teda hodnota eGFR?</li>
  <li>Mám vyšetrený albumín v moči, prípadne pomer albumín/kreatinín?</li>
  <li>Mám známky začínajúceho alebo pokročilého poškodenia obličiek?</li>
  <li>Aký krvný tlak je pre mňa cieľový?</li>
  <li>Sú moje lieky nastavené tak, aby chránili nielen cukor, ale aj srdce a obličky?</li>
  <li>Som vhodný kandidát na liečbu SGLT2 inhibítorom?</li>
  <li>Ak užívam SGLT2 inhibítor, kedy ho mám dočasne vysadiť (napríklad pri horúčke, vracaní, hnačke, operácii alebo hladovaní)?</li>
  <li>Bol by pre mňa vhodný GLP-1 receptorový agonista, najmä ak mám nadváhu, obezitu alebo vysoké srdcovo-cievne riziko?</li>
  <li>Môžu moje bežné lieky proti bolesti poškodzovať obličky?</li>
  <li>Ako často mám absolvovať kontrolu krvi a moču?</li>
  <li>Kedy je vhodné vyšetrenie u nefrológa?</li>
  <li>Aké varovné príznaky by ma mali priviesť k lekárovi skôr než v plánovanom termíne?</li>
</ul>

<p>Dôležité je, aby pacient neodchádzal z ambulancie iba s informáciou, že „výsledky sú v norme“ alebo „cukor je lepší“. Mal by rozumieť aj tomu, aké je jeho riziko do budúcnosti a čo možno urobiť na ochranu obličiek a srdca.</p>

<p>Liečba má byť spoločným rozhodnutím lekára a pacienta. Lekár prináša odborné posúdenie, pacient zasa informácie o svojich ťažkostiach, možnostiach, obavách a každodennom živote. Práve spojenie týchto dvoch pohľadov vedie k najlepšiemu výsledku.</p>

<figure class="article-figure">
  <a href="img/nefroprot-19.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-19.webp" alt="Ilustrácia: otázky, ktoré sa oplatí položiť lekárovi" loading="lazy" decoding="async">
  </a>
  <figcaption>Otázky, ktoré sa oplatí položiť lekárovi</figcaption>
</figure>

<h2>Budúcnosť nefroprotekcie</h2>

<p>Vývoj pokračuje rýchlo. Okrem SGLT2 inhibítorov a GLP-1 receptorových agonistov sa rozvíjajú aj ďalšie prístupy, napríklad lieky ovplyvňujúce mineralokortikoidné receptory, liečba obezity, presnejšie stanovenie rizika pomocou albuminúrie a eGFR a širšie využívanie tímovej starostlivosti.</p>

<p>Najväčšou zmenou však nie je len nový liek. Je ňou nový spôsob myslenia. Cieľom nie je len upraviť laboratórne číslo, ale predĺžiť obdobie života bez dialýzy, bez srdcového zlyhávania, bez infarktu a bez ťažkých komplikácií.</p>

<figure class="article-figure">
  <a href="img/nefroprot-20.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-20.webp" alt="Ilustrácia: budúcnosť nefroprotekcie" loading="lazy" decoding="async">
  </a>
  <figcaption>Budúcnosť nefroprotekcie</figcaption>
</figure>

<h2>Nefroprotektívny plán doma: čo sledovať a ako bezpečne brať lieky</h2>

<p>Pri nefroprotekcii nejde len o „dobré lieky“, ale aj o správne sledovanie a bezpečné používanie. Dobré výsledky majú oporu v tom, že sa hodnotí trend eGFR a albumínu v moči (UACR) v čase, nie jedna jednorazová hodnota. Zároveň je dôležité, aby sa liečba nastavila cielene a s kontrolami: pri niektorých liekoch (najmä tých, ktoré ovplyvňujú hladinu draslíka) sa pravidelne kontrolujú kreatinín a draslík podľa plánu vášho nefrológa či diabetológa a po každej zmene dávky.</p>

<p>Nemenej dôležité sú tzv. „sick day“ pravidlá: keď má človek akútnu nevoľnosť s vracaním, hnačkou, horúčkou alebo výrazne zníženým príjmom tekutín a hrozí mu dehydratácia, môže sa zhoršiť rovnováha organizmu a niektoré lieky sa môžu dočasne pozastaviť. Pri začatí SGLT2 inhibítora sa preto od začiatku má dodržiavať presné odporúčanie na „sick day“ postup a na to, kedy liek dočasne nebrať. Pri plánovaných výkonoch sa postup tiež riadi odporúčaniami (napríklad pri SGLT2 inhibítoroch sa bežne odporúča vopred vysadenie podľa pravidiel pre daný typ zákroku).</p>

<figure class="article-figure">
  <a href="img/nefroprot-21.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-21.webp" alt="Ilustrácia: nefroprotekcia v praxi — sledovanie a bezpečné užívanie liekov" loading="lazy" decoding="async">
  </a>
  <figcaption>Nefroprotektívny plán doma — sledovanie a bezpečné užívanie liekov</figcaption>
</figure>

<h2>Zhrnutie pre pacienta</h2>

<p>Moderná liečba diabetu 2. typu sa už nesústreďuje iba na hladinu cukru v krvi. SGLT2 inhibítory a GLP-1 receptorové agonisty patria medzi lieky, ktoré môžu u vhodne vybraných pacientov pomáhať chrániť srdce a obličky.</p>

<p>SGLT2 inhibítory majú silné postavenie najmä pri ochrane obličiek a pri srdcovom zlyhávaní. GLP-1 receptorové agonisty sú dôležité najmä pri diabete 2. typu, obezite a vysokom srdcovocievnom riziku. Obe skupiny liekov však musia byť použité rozumne, individuálne a pod dohľadom lekára.</p>

<p>Najlepšie výsledky prináša kombinácia včasného záchytu, pravidelných kontrol, správnej životosprávy a liečby, ktorá chráni nielen hladinu cukru, ale aj samotného pacienta.</p>

<figure class="article-figure">
  <a href="img/nefroprot-22.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/nefroprot-22.webp" alt="Ilustrácia: zhrnutie pre pacienta" loading="lazy" decoding="async">
  </a>
  <figcaption>Zhrnutie pre pacienta</figcaption>
</figure>

<hr>

<h2>Použitá literatúra a zdroje</h2>

<ul>
  <li>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">kdigo.org/guidelines/ckd-evaluation-and-management</a></li>
  <li>KDIGO Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease. <a href="https://kdigo.org/guidelines/diabetes-ckd/" target="_blank" rel="noopener noreferrer">kdigo.org/guidelines/diabetes-ckd</a></li>
  <li>American Diabetes Association. Standards of Care in Diabetes 2025. <em>Diabetes Care</em>, 2025. <a href="https://diabetesjournals.org/care/issue/48/Supplement_1" target="_blank" rel="noopener noreferrer">diabetesjournals.org/care</a></li>
  <li>Heerspink HJL, Stefánsson BV, Correa-Rotter R, et al. Dapagliflozin in Patients with Chronic Kidney Disease (DAPA-CKD). <em>N Engl J Med</em>, 2020. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2024816" target="_blank" rel="noopener noreferrer">NEJMoa2024816</a></li>
  <li>The EMPA-KIDNEY Collaborative Group. Empagliflozin in Patients with Chronic Kidney Disease. <em>N Engl J Med</em>, 2023. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2204233" target="_blank" rel="noopener noreferrer">NEJMoa2204233</a></li>
  <li>Perkovic V, Tuttle KR, Rossing P, et al. Effects of Semaglutide on Chronic Kidney Disease in Type 2 Diabetes (FLOW). <em>N Engl J Med</em>, 2024. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">NEJMoa2403347</a></li>
  <li>Bakris GL, Agarwal R, et al. (FIDELIO-DKD). Effect of Finerenone on CKD Outcomes in Type 2 Diabetes. <em>N Engl J Med</em>, 2020. doi:10.1056/NEJMoa2025845</li>
  <li>Ruilope LM, et al. (FIGARO-DKD). Cardiovascular Events with Finerenone in Kidney Disease and Type 2 Diabetes. <em>N Engl J Med</em>, 2021. doi:10.1056/NEJMoa2110956</li>
  <li>Wanner C, Fioretto P, Kovesdy CP, et al. Potassium management with finerenone: practical aspects. <em>Endocrinol Diabetes Metab</em>, 2022. doi:10.1002/edm2.360</li>
  <li>European Medicines Agency (EMA). Kerendia (finerenone): EPAR product information. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/kerendia" target="_blank" rel="noopener noreferrer">ema.europa.eu</a></li>
  <li>U.S. Food and Drug Administration (FDA) — drug safety and approvals. <a href="https://www.fda.gov/drugs" target="_blank" rel="noopener noreferrer">fda.gov/drugs</a></li>
  <li>ClinicalTrials.gov (štúdie pre tirzepatid a retatrutid). <a href="https://clinicaltrials.gov/" target="_blank" rel="noopener noreferrer">clinicaltrials.gov</a></li>
  <li>AMA. What doctors want patients to know about injectable peptides. <a href="https://www.ama-assn.org/public-health/prevention-wellness/what-doctors-want-patients-know-about-injectable-peptides" target="_blank" rel="noopener noreferrer">ama-assn.org</a></li>
</ul>

<hr>

<p><em><strong>Upozornenie:</strong> Obsah má informačný a vzdelávací charakter a nenahrádza konzultáciu s lekárom. O vhodnosti konkrétnej liečby vždy rozhoduje váš lekár.</em></p>

<p><em>Autor je nefrológ a internista s rozsiahlymi skúsenosťami v dialyzačnej liečbe, klinickej a preventívnej nefrológii aj v riadení dialyzačných stredísk.</em></p>
NEFRO_HTML,
];

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, category, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, 'popularne', :published_at, :is_top, 1)"
);

$inserted = 0; $skipped = 0; $errors = []; $queuedTotal = 0;
foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title' => $a['title'], 'slug' => $a['slug'], 'author' => $a['author'],
            'content' => $a['content'], 'excerpt' => $a['excerpt'],
            'published_at' => $a['published_at'], 'is_top' => $a['is_top'],
        ]);
        if ($stmt->rowCount() > 0) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try { $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId); }
            catch (\Throwable $qe) { error_log('add_popular_article newsletter enqueue error: ' . $qe->getMessage()); }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_popular_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);
if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo "Popularizačný článok: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total vložených. Preskočené: $skipped. Avíza: $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) { echo "  - $err\n"; }
    }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Vložených: $inserted, preskočených: $skipped, avíz: $queuedTotal\n";
    foreach ($errors as $err) { echo "  - $err\n"; }
}
?>
