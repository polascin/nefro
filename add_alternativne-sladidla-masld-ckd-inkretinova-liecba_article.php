<?php
/**
 * Odborne a jazykovo revidovaný článok o alternatívnych sladidlách.
 *
 * Text je viaczdrojovou syntézou klinických štúdií, systematických prehľadov,
 * odporúčaní a regulačných dokumentov. Nejde o spracovanie jednej publikácie,
 * preto sa autori citovaných prác nepridávajú do source_authors.php.
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
    'title'        => 'Sladidlá pri MASLD, CKD a inkretínovej liečbe: dôkazy a neistoty',
    'slug'         => 'alternativne-sladidla-masld-ckd-inkretinova-liecba',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Agávový sirup, nesacharidové sladidlá a polyoly netvoria jednu skupinu. Článok oddeľuje klinické dôkazy od hypotéz pri MASLD, CKD a inkretínovej liečbe.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Agávový sirup, intenzívne nesacharidové sladidlá a polyoly (cukrové alkoholy) sa často zaraďujú pod nepresný zastrešujúci pojem „alternatívne sladidlá“. Metabolicky však nejde o jednu skupinu. Agávový sirup je zdroj voľných cukrov a energie, aspartám či sukralóza sa používajú v neporovnateľne menších množstvách a polyoly sa odlišne vstrebávajú a majú vlastné gastrointestinálne účinky. Bez tohto rozlíšenia vznikajú tvrdenia, ktoré znejú mechanisticky presvedčivo, ale klinické dôkazy ich nepodporujú.</em></p>

<p>Najlepšie podložený praktický záver je menej dramatický než populárne varovania. Nadmerný príjem sladených nápojov a voľných cukrov, najmä ak zvyšuje celkový energetický príjem, podporuje prírastok hmotnosti a ukladanie tuku v pečeni. Nahradenie takýchto nápojov nízkoenergetickou alebo nekalorickou alternatívou môže priniesť malý metabolický úžitok; z dlhodobého hľadiska však treba uprednostňovať vodu a nesladené nápoje. Nie sú dostupné priame klinické dôkazy, že by povolené nesacharidové sladidlá znižovali účinnosť semaglutidu alebo tirzepatidu.</p>

<h2>Najprv treba oddeliť tri rozdielne skupiny</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie hlavných skupín sladidiel" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Skupina</th>
        <th scope="col">Príklady</th>
        <th scope="col">Klinicky podstatná vlastnosť</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Kalorické cukry a sirupy</th>
        <td>Sacharóza, glukózovo-fruktózový sirup, fruktózové koncentráty, agávový sirup</td>
        <td>Dodávajú energiu a patria medzi voľné alebo pridané cukry; nízky bezprostredný glykemický vzostup fruktózy z nich nerobí metabolicky „zdravé“ sladidlá.</td>
      </tr>
      <tr>
        <th scope="row">Intenzívne nesacharidové sladidlá</th>
        <td>Aspartám, acesulfám K, sacharín, sukralóza, glykozidy steviolu</td>
        <td>Sladia v malých dávkach s minimálnym príspevkom energie. Jednotlivé látky majú odlišnú absorpciu, metabolizmus a prijateľný denný príjem.</td>
      </tr>
      <tr>
        <th scope="row">Polyoly</th>
        <td>Erytritol, xylitol, sorbitol, maltitol</td>
        <td>Majú inú energetickú hodnotu a absorpciu než cukry. Pri vyššej dávke môžu vyvolať plynatosť, kŕče alebo osmotickú hnačku; znášanlivosť je individuálna.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Označenia „prírodné“ a „syntetické“ samy osebe neurčujú zdravotný účinok. Niektoré glykozidy steviolu sa získavajú zo stévie, kým iné povolené formy sa vyrábajú fermentáciou alebo enzymaticky; všetky patria medzi intenzívne sladidlá. Agávový sirup je prírodný, no stále ide o kalorický cukrový sirup. Erytritol sa prirodzene vyskytuje v malých množstvách, priemyselne sa však používa v podstatne vyšších dávkach.</p>

<h2>Agávový sirup a fruktóza: problémom je najmä dávka, zdroj a energetický nadbytok</h2>

<p>Zloženie agávového sirupu nie je jednotné. Analytické práce potvrdili, že v mnohých výrobkoch z modrej agávy tvorí fruktóza väčšinu sacharidovej zložky, zatiaľ čo sirupy z iných druhov môžu obsahovať viac sacharózy. Pevné tvrdenie, že každý agávový sirup obsahuje 75 až 90 % „voľnej fruktózy“, preto nie je univerzálne platné. Z pohľadu klinickej výživy je podstatné, že nejde o nekalorickú náhradu cukru.</p>

<p>Fruktóza sa vstrebáva najmä v tenkom čreve a časť, ktorá sa dostane do portálneho obehu, sa výrazne metabolizuje v pečeni. Fruktokinázová dráha obchádza hlavný regulačný krok glykolýzy, podporuje tvorbu triózových fosfátov a pri vysokej záťaži môže zvyšovať de novo lipogenézu, triglyceridy a tvorbu kyseliny močovej. Tento mechanizmus je biologicky vierohodný, ale sám osebe neurčuje klinický výsledok bežnej dávky.</p>

<p>Systematická analýza kontrolovaných štúdií ukázala dôležitý rozdiel. Keď fruktóza izokaloricky nahradila iné sacharidy, ukazovatele obsahu tuku v pečeni sa významne nezhoršili. Zvýšenie množstva intrahepatálneho tuku a aktivity alanínaminotransferázy sa pozorovalo najmä pri pridaní vysokých dávok fruktózy nad rámec energetickej potreby. Novší prehľad potvrdil, že osobitne nepriaznivé boli sladené nápoje dodávajúce nadbytočnú energiu. Nie je preto správne tvrdiť, že jediná dávka agávového sirupu automaticky vyvolá steatózu; rovnako nesprávne je vydávať jeho nižší glykemický index za ochranu pred metabolicky asociovanou steatotickou chorobou pečene (MASLD).</p>

<h2>Nesacharidové sladidlá: regulačná bezpečnosť nie je to isté ako dlhodobý metabolický prínos</h2>

<p>V Európskej únii sa potravinové sladidlá pred povolením hodnotia toxikologicky a pre jednotlivé látky sa podľa dostupných údajov stanovuje prijateľný denný príjem. Európsky úrad pre bezpečnosť potravín (EFSA) vo februári 2026 po opätovnom hodnotení potvrdil, že sukralóza je pri súčasných povolených použitiach bezpečná, a ponechal prijateľný denný príjem (ADI) 15 mg/kg telesnej hmotnosti/deň. Takéto hodnotenie odpovedá na otázku bezpečnosti expozície, nie na otázku, či sladidlo pomáha dlhodobo schudnúť alebo predchádzať diabetu.</p>

<p>Odporúčanie Svetovej zdravotníckej organizácie (WHO) z roku 2023 naopak hodnotilo nesacharidové sladidlá ako populačný nástroj kontroly hmotnosti a prevencie neprenosných chorôb. WHO vydala podmienené odporúčanie nepoužívať ich na tento dlhodobý účel, pretože dlhodobý prínos nebol presvedčivo preukázaný a nepriaznivé asociácie v kohortách mohli byť ovplyvnené reziduálnym skreslením a reverznou kauzalitou. Odporúčanie nie je toxikologickým zákazom, nevzťahuje sa na polyoly a jeho hlavná cieľová populácia nezahŕňa ľudí s už diagnostikovaným diabetom.</p>

<p>Pri interpretácii je rozhodujúci komparátor:</p>

<ul>
  <li><strong>Ak nesacharidovo sladený nápoj nahradí sladený nápoj,</strong> randomizované štúdie ukazujú malý pokles hmotnosti a niektorých kardiometabolických ukazovateľov.</li>
  <li><strong>Ak nahradí vodu alebo nesladený nápoj,</strong> metabolická výhoda sa nepreukázala.</li>
  <li><strong>Ak sa pridá bez zníženia cukru alebo energie inde,</strong> nemožno automaticky očakávať úžitok.</li>
</ul>

<p>Sieťová metaanalýza zahŕňala 17 randomizovaných štúdií. Konkrétny odhad pri nahradení cukrom sladených nápojov nízkoenergetickými alebo nekalorickými nápojmi vychádzal z 12 štúdií so 601 účastníkmi a ukázal priemerný rozdiel hmotnosti −1,06 kg. Výsledok podporuje možnosť prechodnej substitúcie, nie predstavu terapeutického účinku samotného sladidla.</p>

<h2>Mikrobióm: zaujímavý signál, nie dôkaz univerzálnej dysbiózy</h2>

<p>Najčastejším mechanistickým argumentom proti intenzívnym sladidlám je zmena črevného mikrobiómu. Randomizovaná štúdia u 120 zdravých dospelých skúmala počas dvoch týždňov sacharín, sukralózu, aspartám a glykozidy steviolu v dávkach pod prijateľným denným príjmom. Jednotlivé sladidlá vyvolali odlišné zmeny mikrobiómu a metabolómu; sacharín a sukralóza v tejto štúdii zhoršili glykemickú odpoveď. Reakcie však boli individuálne a štúdia nehodnotila vznik MASLD, progresiu chronickej choroby obličiek (CKD), dlhodobý vývoj HbA1c ani účinnosť agonistov receptora GLP-1.</p>

<p>Z takéhoto krátkeho experimentu nemožno odvodiť, že konzumácia aspartámu alebo sukralózy nevyhnutne vedie k „dysbióze“, zvýšenej priepustnosti čreva, portálnej endotoxémii a zápalu pečene. Časť týchto dráh pochádza z bunkových a zvieracích modelov. Navyše sa jednotlivé látky správajú odlišne: napríklad aspartám sa po hydrolýze vstrebáva v tenkom čreve, takže nie je správne automaticky predpokladať rovnakú priamu expozíciu hrubého čreva ako pri slabo vstrebávanej látke.</p>

<p>Metaanalýza akútnych štúdií u ľudí navyše ukázala, že samostatne podané nesacharidovo sladené nápoje mali v porovnaní s vodou podobný postprandiálny priebeh koncentrácií glukózy, inzulínu, GLP-1, GIP, PYY, ghrelínu a glukagónu. Účastníci boli prevažne zdraví a istota dôkazov bola väčšinou nízka až stredná. Výsledky nevylučujú dlhodobejšie alebo individuálne účinky, ale nepodporujú tvrdenie o univerzálnej cefalickej inzulínovej odpovedi ani o klinicky preukázanej desenzitizácii črevných receptorov.</p>

<h2>Obličky: mechanistické poznatky nemožno zameniť za kauzalitu u ľudí</h2>

<p>Proximálne tubuly dokážu filtrovanú fruktózu reabsorbovať a metabolizovať. Bunkové a zvieracie práce ukazujú, že pri nadmernej fruktózovej záťaži môže aktivácia ketohexokinázy viesť k spotrebe ATP, tvorbe urátu, oxidačnému stresu, zápalu a tubulointersticiálnemu poškodeniu. Oblička môže za patologických podmienok vytvárať fruktózu aj endogénne polyolovou dráhou. Ide o dôležitú výskumnú hypotézu, nie o dôkaz, že bežná porcia konkrétneho sladidla spôsobuje u človeka eferentnú arteriolárnu vazokonstrikciu alebo glomerulárnu hyperfiltráciu.</p>

<p>Ľudské údaje o nesacharidovo sladených nápojoch a obličkách sú prevažne observačné. V kohorte Nurses' Health Study bolo pitie aspoň dvoch porcií diétneho sýteného nápoja denne spojené s približne dvojnásobným pomerom šancí na pokles eGFR aspoň o 30 % počas 11 rokov. Tá istá analýza však nezistila asociáciu s albuminúriou a nedokázala určiť, či príčinou bolo sladidlo, iná zložka nápoja, stravovací vzorec, obezita, diabetes alebo to, že diétne nápoje si častejšie vyberali ľudia s už vyšším rizikom.</p>

<p>Metaanalýza observačných štúdií neskôr odhadla relatívne riziko CKD pri vysokej v porovnaní s nízkou konzumáciou umelo sladených nápojov na 1,40, ale s veľmi širokým 95 % intervalom spoľahlivosti 0,65 až 3,02. Hlavná analýza teda nebola štatisticky presvedčivá.</p>

<p>Novšie údaje rozšírili, ale nezmenili observačný charakter dôkazov. V analýze 127 830 účastníkov UK Biobank bola konzumácia viac ako jednej porcie umelo sladeného nápoja denne oproti nulovej konzumácii spojená s vyšším výskytom CKD (upravený pomer rizík [HR] 1,26; 95 % interval spoľahlivosti 1,12 až 1,43). Ďalšia analýza tej istej databázy, ktorá hodnotila príjem umelých sladidiel z viacerých zdrojov, zistila pri vysokej expozícii HR 1,19 (95 % interval spoľahlivosti 1,08 až 1,30). Nejde o nezávislé potvrdenie v dvoch kohortách. Ani tieto výsledky nedokazujú kauzalitu, účinok konkrétnej molekuly ani mechanizmus; zostáva možné reziduálne skreslenie a reverzná kauzalita. Formulácia, že dva diétne nápoje denne „potvrdzujú“ dvojnásobné riziko CKD a že mechanizmom je črevná endotoxémia, preto presahuje dostupné dôkazy.</p>

<p>Pre nefrologickú prax z toho vyplýva rozumná priorita: obmedziť cukrom sladené nápoje a ako základ pitného režimu s ohľadom na individuálne obmedzenie príjmu tekutín používať vodu alebo nesladené nápoje. Samotná konzumácia nesacharidového sladidla nie je diagnózou ani dôvodom pripísať mu progresiu CKD.</p>

<h2>Erytritol a ďalšie polyoly: menej glukózy neznamená nulové riziko</h2>

<p>V starších farmakokinetických štúdiách u zdravých ľudí sa väčšina podaného erytritolu vstrebala a vylúčila močom v nezmenenej forme. V malej štúdii zameranej na črevnú priepustnosť boli koncentrácie erytritolu po podaní zmesi cukrov u 10 hemodialyzovaných pacientov vyššie a pretrvávali dlhšie než u piatich kontrolných osôb. Táto štúdia však neurčovala bezpečnú dávku ani klinické následky. Dostupné údaje neposkytujú podklad pre validovaný dávkovací režim pri CKD G4 až G5, pevný zákaz pri eGFR pod 30 ml/min/1,73 m<sup>2</sup> ani tvrdenie, že zlyhanie obličiek farmakokinetiku erytritolu klinicky významne nemení. Pri pokročilej CKD preto zostáva primeraná individuálna opatrnosť.</p>

<p>EFSA v roku 2023 stanovila pre erytritol prijateľný denný príjem 0,5 g/kg telesnej hmotnosti/deň, najmä na ochranu pred hnačkou a jej následkami vrátane porúch elektrolytov. Nejde o špecifický limit pre pacientov počas inkretínovej liečby a hranica 10 g/deň nie je univerzálnym klinickým prahom.</p>

<p>Štúdia publikovaná v <em>Nature Medicine</em> spojila vyššie cirkulujúce koncentrácie erytritolu s kardiovaskulárnymi príhodami a observačné zistenia doplnila laboratórnymi experimentmi, v ktorých sa pozorovala aktivácia trombocytov. Observačná časť však nedokáže odlíšiť príjem erytritolu od jeho endogénnej tvorby ani úplne odstrániť vplyv metabolického a renálneho rizika. Následná malá intervenčná štúdia z roku 2024 u zdravých dobrovoľníkov zistila po jednorazovej dávke 30 g erytritolu akútne zvýšenie viacerých ukazovateľov reaktivity trombocytov. Zahŕňala iba 20 účastníkov a hodnotila zástupné laboratórne ukazovatele, nie klinické trombotické príhody ani dlhodobé riziko. Hodnotenie EFSA z decembra 2023 tejto novšej intervencii časovo predchádzalo; podľa vtedy dostupných štúdií nebola príčinná súvislosť medzi konzumáciou erytritolu a kardiovaskulárnym rizikom preukázaná. Klinická kauzalita preto zostáva nepreukázaná a erytritol nemožno zjednodušene zaradiť ani do „zelenej“, ani do „červenej“ zóny.</p>

<h2>Inkretínová liečba: chýba dôkaz, že sladidlá znižujú jej účinnosť</h2>

<p>Semaglutid je agonista receptora GLP-1 a tirzepatid je duálny agonista receptorov GIP a GLP-1. V ich schválených európskych informáciách o lieku nie sú nesacharidové sladidlá, polyoly ani agávový sirup uvedené ako farmakologické antagonisty alebo kontraindikované potraviny. Zároveň nie sú k dispozícii priame klinické štúdie, ktoré by testovali, či konkrétne sladidlo mení účinnosť semaglutidu alebo tirzepatidu na telesnú hmotnosť či HbA1c alebo zhoršuje klinické výsledky. Tvrdenie o antagonizme je preto nepodložené, nie klinicky vyvrátené.</p>

<p>Nedoložené sú najmä tieto tvrdenia:</p>

<ul>
  <li><strong>Intenzívne sladidlá</strong> desenzitizujú receptory T1R2/T1R3 natoľko, že oslabia účinok semaglutidu alebo tirzepatidu.</li>
  <li><strong>Sladká chuť</strong> vyvoláva „neuvedomovaný hlad“ a ruší centrálnu signalizáciu sýtosti.</li>
  <li><strong>Nesacharidové sladidlá</strong> zvyšujú HbA1c u stabilne liečeného pacienta bez inej zmeny.</li>
  <li><strong>Glykozidy steviolu</strong> prostredníctvom AMPK klinicky zosilňujú účinok inkretínovej liečby.</li>
</ul>

<p>To neznamená, že kvalita stravy počas liečby nie je dôležitá. Sladký nápoj s vysokým obsahom energie môže znižovať dosiahnutý energetický deficit a polyoly môžu u citlivého pacienta zhoršiť plynatosť alebo hnačku. Ide však o nutričný problém a problém znášanlivosti, nie o preukázaný receptorový antagonizmus lieku.</p>

<p>Retatrutid je trojitý agonista receptorov GIP, GLP-1 a glukagónu. K 5. septembru 2026 zostáva skúšaným liečivom vo fáze III a nie je schválený žiadnou regulačnou autoritou. Nemá sa preto uvádzať v bežnom liečebnom pláne pacienta ako dostupná štandardná liečba.</p>

<h2>Bezpečná praktická edukácia počas liečby semaglutidom alebo tirzepatidom</h2>

<p>Inkretínová liečba môže spomaliť vyprázdňovanie žalúdka a často spôsobuje nauzeu, vracanie, hnačku, zápchu alebo predčasný pocit sýtosti. Intenzita týchto príznakov je individuálna a môže sa meniť počas titrácie; samotná prítomnosť príznakov automaticky neznamená gastroparézu. Odborné odporúčania podporujú nutričnú a pohybovú intervenciu, neodôvodňujú však univerzálne zákazy alebo pevný „záchranný protokol“ pre každého pacienta.</p>

<ul>
  <li><strong>Pri gastrointestinálnych ťažkostiach:</strong> jesť pomalšie, voliť menšie porcie a dočasne obmedziť veľké, veľmi mastné alebo individuálne zle tolerované jedlá. Polyoly obmedziť vtedy, keď zhoršujú plynatosť alebo hnačku, nie automaticky u každého.</li>
  <li><strong>Hydratácia:</strong> prijímať tekutiny priebežne s ohľadom na smäd, straty tekutín a individuálny klinický plán. Pevný cieľ 35 ml/kg/deň ani limit 200 ml pri jedle nie sú bezpečné univerzálne pravidlá, najmä pri CKD, srdcovom zlyhávaní, hyponatriémii alebo predpísanom obmedzení tekutín.</li>
  <li><strong>Bielkoviny a svalstvo:</strong> primeraný príjem energie a bielkovín spolu s odporovým cvičením pomáha chrániť svalovú silu a funkciu. Pri CKD G3 až G5 KDIGO orientačne odporúča 0,8 g bielkovín/kg telesnej hmotnosti/deň a vyhýbanie sa príjmu nad 1,3 g/kg/deň pri riziku progresie. Dialýza, podvýživa, krehkosť a sarkopénia vyžadujú iný, individuálny plán.</li>
  <li><strong>Sledovanie:</strong> funkciu obličiek, elektrolyty a ďalšie parametre kontrolovať podľa štádia CKD, komorbidít, súbežnej liečby a klinického priebehu. Pevný 12-týždňový interval medzi kontrolami eGFR a kyseliny močovej nie je štandardom pre každého.</li>
  <li><strong>Varovné príznaky:</strong> neschopnosť udržať tekutiny, oligúria, závraty alebo hypotenzia, pretrvávajúce vracanie či hnačka, silná bolesť brucha, ikterus, výrazná distenzia brucha alebo pretrvávajúca zápcha vyžadujú včasné klinické zhodnotenie. Pacient nemá meniť dávku lieku bez dohody s predpisujúcim lekárom.</li>
</ul>

<p>Európska informácia o lieku Wegovy (semaglutid) výslovne upozorňuje, že nauzea, vracanie a hnačka môžu viesť k dehydratácii a v zriedkavých prípadoch k zhoršeniu funkcie obličiek. Práve toto je pri CKD podstatnejší a lepšie doložený bezpečnostný problém než hypotetická interakcia lieku so sladkou chuťou.</p>

<h2>Časté tvrdenia a odborné spresnenie</h2>

<div class="table-responsive" role="region" aria-label="Odborné hodnotenie častých tvrdení o sladidlách" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Tvrdenie</th>
        <th scope="col">Hodnotenie</th>
        <th scope="col">Spresnenie</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Agávový sirup je zdravá nekalorická náhrada cukru.</th>
        <td>Nesprávne</td>
        <td>Je kalorickým zdrojom voľných cukrov, často s vysokým podielom fruktózy.</td>
      </tr>
      <tr>
        <th scope="row">Každé nesacharidové sladidlo spôsobuje dysbiózu, zvýšenú črevnú priepustnosť a MASLD.</th>
        <td>Nepreukázané</td>
        <td>Krátke ľudské štúdie ukazujú látkovo špecifické a individuálne zmeny; klinická kauzálna reťaz nebola potvrdená.</td>
      </tr>
      <tr>
        <th scope="row">Dva diétne nápoje denne zdvojnásobia riziko CKD.</th>
        <td>Zavádzajúce zovšeobecnenie</td>
        <td>Staršia približne dvojnásobná asociácia pochádza z jednej kohorty žien. Novšie analýzy UK Biobank našli menšie asociácie, stále však nedokazujú kauzalitu ani účinok konkrétneho sladidla.</td>
      </tr>
      <tr>
        <th scope="row">Nesacharidové sladidlá znižujú účinok semaglutidu alebo tirzepatidu.</th>
        <td>Nepreukázané</td>
        <td>Priame klinické štúdie tejto interakcie chýbajú; tvrdenie o farmakologickom antagonizme alebo strate účinnosti liečby preto nie je podložené.</td>
      </tr>
      <tr>
        <th scope="row">Glykozidy steviolu prostredníctvom AMPK synergicky zosilňujú inkretínovú liečbu.</th>
        <td>Preklinická hypotéza</td>
        <td>Mechanistické experimenty nenahrádzajú klinický dôkaz prínosu u liečených pacientov.</td>
      </tr>
      <tr>
        <th scope="row">Erytritol je bezpečný do 10 g/deň a pri eGFR pod 30 ml/min/1,73 m<sup>2</sup> sa hromadí.</th>
        <td>Nepodložený pevný prah</td>
        <td>EFSA stanovila všeobecný ADI 0,5 g/kg/deň pre laxatívny účinok; kvalitné farmakokinetické údaje pri CKD a validovaná prahová hodnota eGFR chýbajú.</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Praktický rozhodovací rámec</h2>

<ol>
  <li><strong>Pýtať sa, čo sladidlo nahrádza.</strong> Nahradenie sladeného nápoja môže znížiť príjem cukru a energie; nahradenie vody neprináša preukázanú metabolickú výhodu.</li>
  <li><strong>Hodnotiť konkrétnu látku a dávku.</strong> Aspartám, sukralóza, glykozidy steviolu a polyoly nie sú metabolicky zameniteľné.</li>
  <li><strong>Uprednostniť celkový stravovací vzorec.</strong> Pre MASLD a kardiorenálne riziko je dôležitejšia energetická bilancia, kvalita potravín, vláknina, hmotnosť, pohyb a obmedzenie sladených nápojov než marketingové označenie jedného sladidla.</li>
  <li><strong>Pri CKD individualizovať tekutiny a bielkoviny.</strong> Ani univerzálny pitný režim, ani vysokoproteínový plán nie sú bezpečné pre každého pacienta.</li>
  <li><strong>Pri inkretínovej liečbe riešiť znášanlivosť, nie predpokladaný antagonizmus.</strong> Zamerať sa na nauzeu, vracanie, hnačku, zápchu, hydratáciu, primeraný príjem živín a zachovanie svalovej funkcie.</li>
</ol>

<h2>Záver</h2>

<p>Alternatívne sladidlá netvoria jednotnú „dobrú“ alebo „zlú“ skupinu. Agávový sirup zostáva kalorickým zdrojom voľných cukrov. Pri fruktóze sú pre pečeňové riziko rozhodujúce najmä vysoká dávka, konzumácia v sladených nápojoch a nadbytočný energetický príjem. Nesacharidové sladidlá môžu pri náhrade cukrom sladených nápojov priniesť malý krátko- až strednodobý úžitok, no nie sú nevyhnutným nástrojom dlhodobej kontroly hmotnosti.</p>

<p>Mikrobiómové, hepatálne a renálne mechanizmy si zaslúžia ďalší výskum, ale krátke experimenty a observačné asociácie nemožno vydávať za všeobecnú príčinnú súvislosť. Rovnako neexistuje klinický dôkaz, že povolené sladidlá znižujú účinnosť semaglutidu alebo tirzepatidu. V praxi má najväčší význam znížiť voľné cukry, uprednostňovať vodu a nesladené nápoje, rešpektovať individuálnu gastrointestinálnu znášanlivosť a pri CKD prispôsobiť príjem tekutín aj bielkovín konkrétnemu pacientovi.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=masld-diagnostika-fibroza-nefrologicka-prax">MASLD: diagnostika, hodnotenie fibrózy a význam pre nefrologickú prax</a>.</li>
  <li><a href="article.php?slug=glp1-lieky-renalne-benefity-dokazy-prax-nefrologia">Sú agonisty GLP-1 receptora už „liekmi na obličky“?</a>.</li>
  <li><a href="article.php?slug=glp1-pokles-krokov-fyzicka-aktivita-nefro-kardiometabolicka-prax">„Weight down, steps down“: fyzická aktivita počas liečby agonistami GLP-1</a>.</li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">CKD pri diabete: skríning a vrstvená kardiorenálna liečba</a>.</li>
  <li><a href="article.php?slug=vyzivove-odporucania-usa-2025-2030-masld-ckd">Výživové odporúčania USA 2025 až 2030 v kontexte MASLD a CKD</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>World Health Organization.</strong> <em>Use of non-sugar sweeteners: WHO guideline.</em> 2023. <a href="https://www.who.int/publications/i/item/9789240073616" target="_blank" rel="noopener noreferrer">WHO</a>.</li>
  <li><strong>European Food Safety Authority.</strong> <em>Sweeteners.</em> Aktuálny prehľad hodnotenia a povoľovania sladidiel v EÚ. <a href="https://www.efsa.europa.eu/en/topics/topic/sweeteners" target="_blank" rel="noopener noreferrer">Prehľad sladidiel EFSA</a>; <em>EFSA finds sucralose safe when used as currently authorised.</em> 2026. <a href="https://www.efsa.europa.eu/en/news/efsa-finds-sucralose-safe-when-used-currently-authorised-cannot-confirm-safety-extending-its" target="_blank" rel="noopener noreferrer">Prehodnotenie sukralózy EFSA 2026</a>.</li>
  <li><strong>Joint FAO/WHO Expert Committee on Food Additives.</strong> <em>Steviol glycosides.</em> Databáza hodnotení JECFA, aktualizované 2026. <a href="https://apps.who.int/food-additives-contaminants-jecfa-database/Home/Chemical/267" target="_blank" rel="noopener noreferrer">JECFA</a>.</li>
  <li><strong>Mellado-Mojica E, López MG.</strong> <em>Identification, classification, and discrimination of agave syrups from natural sweeteners by infrared spectroscopy and HPAEC-PAD.</em> Food Chem. 2015;167:349–357. doi: 10.1016/j.foodchem.2014.06.111. PMID 25148997. <a href="https://pubmed.ncbi.nlm.nih.gov/25148997/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Lee D, Chiavaroli L, Ayoub-Charette S, et al.</strong> <em>Important Food Sources of Fructose-Containing Sugars and Non-Alcoholic Fatty Liver Disease: A Systematic Review and Meta-Analysis of Controlled Trials.</em> Nutrients. 2022;14(14):2846. doi: 10.3390/nu14142846. PMID 35889803. <a href="https://pubmed.ncbi.nlm.nih.gov/35889803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Chiu S, Sievenpiper JL, de Souza RJ, et al.</strong> <em>Effect of fructose on markers of non-alcoholic fatty liver disease (NAFLD): a systematic review and meta-analysis of controlled feeding trials.</em> Eur J Clin Nutr. 2014;68:416–423. doi: 10.1038/ejcn.2014.8. PMID 24569542. <a href="https://pubmed.ncbi.nlm.nih.gov/24569542/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>McGlynn ND, Khan TA, Wang L, et al.</strong> <em>Association of Low- and No-Calorie Sweetened Beverages as a Replacement for Sugar-Sweetened Beverages With Body Weight and Cardiometabolic Risk: A Systematic Review and Meta-analysis.</em> JAMA Netw Open. 2022;5(3):e222092. doi: 10.1001/jamanetworkopen.2022.2092. PMID 35285920. <a href="https://pubmed.ncbi.nlm.nih.gov/35285920/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Zhang R, Noronha JC, Khan TA, et al.</strong> <em>The Effect of Non-Nutritive Sweetened Beverages on Postprandial Glycemic and Endocrine Responses: A Systematic Review and Network Meta-Analysis.</em> Nutrients. 2023;15(4):1050. doi: 10.3390/nu15041050. PMID 36839408. <a href="https://pubmed.ncbi.nlm.nih.gov/36839408/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Suez J, Cohen Y, Valdés-Mas R, et al.</strong> <em>Personalized microbiome-driven effects of non-nutritive sweeteners on human glucose tolerance.</em> Cell. 2022;185(18):3307–3328.e19. doi: 10.1016/j.cell.2022.07.016. PMID 35987213. <a href="https://pubmed.ncbi.nlm.nih.gov/35987213/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Lin J, Curhan GC.</strong> <em>Associations of sugar and artificially sweetened soda with albuminuria and kidney function decline in women.</em> Clin J Am Soc Nephrol. 2011;6(1):160–166. doi: 10.2215/CJN.03260410. PMID 20884773. <a href="https://pubmed.ncbi.nlm.nih.gov/20884773/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Lo WC, Ou SH, Chou CL, et al.</strong> <em>Sugar- and artificially-sweetened beverages and the risks of chronic kidney disease: a systematic review and dose-response meta-analysis.</em> J Nephrol. 2021;34(6):1791–1804. doi: 10.1007/s40620-020-00957-0. PMID 33502726. <a href="https://pubmed.ncbi.nlm.nih.gov/33502726/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Heo GY, Koh HB, Park JT, et al.</strong> <em>Sweetened Beverage Intake and Incident Chronic Kidney Disease in the UK Biobank Study.</em> JAMA Netw Open. 2024;7(2):e2356885. doi: 10.1001/jamanetworkopen.2023.56885. PMID 38416492. <a href="https://pubmed.ncbi.nlm.nih.gov/38416492/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Wang J, Wang A, Liu B, et al.</strong> <em>Association of artificial sweeteners intake and risk of CKD: a prospective cohort study.</em> J Nutr Health Aging. 2026;30(8):100917. doi: 10.1016/j.jnha.2026.100917. PMID 42379074. <a href="https://pubmed.ncbi.nlm.nih.gov/42379074/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42492226/" target="_blank" rel="noopener noreferrer">oprava citácií v diskusii</a>.</li>
  <li><strong>Nakagawa T, Kang DH.</strong> <em>Fructose in the kidney: from physiology to pathology.</em> Kidney Res Clin Pract. 2021;40(4):527–541. doi: 10.23876/j.krcp.21.138. PMID 34781638. <a href="https://pubmed.ncbi.nlm.nih.gov/34781638/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Bornet FR, Blayo A, Dauchy F, Slama G.</strong> <em>Plasma and urine kinetics of erythritol after oral ingestion by healthy humans.</em> Regul Toxicol Pharmacol. 1996;24(2 Pt 2):S280–S285. doi: 10.1006/rtph.1996.0109. PMID 8933644. <a href="https://pubmed.ncbi.nlm.nih.gov/8933644/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Wong J, Lenaerts K, Meesters DM, et al.</strong> <em>Acute haemodynamic changes during haemodialysis do not exacerbate gut hyperpermeability.</em> Biosci Rep. 2019;39(4):BSR20181704. doi: 10.1042/BSR20181704. PMID 30898976. <a href="https://pubmed.ncbi.nlm.nih.gov/30898976/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>EFSA Panel on Food Additives and Flavourings.</strong> <em>Re-evaluation of erythritol (E 968) as a food additive.</em> EFSA Journal. 2023;21:e08430. doi: 10.2903/j.efsa.2023.8430. <a href="https://www.efsa.europa.eu/en/plain-language-summary/re-evaluation-erythritol-e-968-food-additive" target="_blank" rel="noopener noreferrer">EFSA</a>.</li>
  <li><strong>Witkowski M, Nemet I, Alamri H, et al.</strong> <em>The artificial sweetener erythritol and cardiovascular event risk.</em> Nat Med. 2023;29:710–718. doi: 10.1038/s41591-023-02223-9. PMID 36849732. <a href="https://pubmed.ncbi.nlm.nih.gov/36849732/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.fda.gov/media/182122/download?attachment=" target="_blank" rel="noopener noreferrer">odborné hodnotenie FDA</a>.</li>
  <li><strong>Witkowski M, Wilcox J, Province V, et al.</strong> <em>Ingestion of the Non-Nutritive Sweetener Erythritol, but Not Glucose, Enhances Platelet Reactivity and Thrombosis Potential in Healthy Volunteers: Brief Report.</em> Arterioscler Thromb Vasc Biol. 2024;44(9):2136–2141. doi: 10.1161/ATVBAHA.124.321019. PMID 39114916. <a href="https://pubmed.ncbi.nlm.nih.gov/39114916/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Wegovy: Product information.</em> Aktualizované 26. augusta 2026. <a href="https://www.ema.europa.eu/en/documents/product-information/wegovy-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">EMA: Wegovy</a>; <em>Mounjaro: Product information.</em> Aktualizované 28. augusta 2026. <a href="https://www.ema.europa.eu/en/documents/product-information/mounjaro-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">EMA: Mounjaro</a>.</li>
  <li><strong>Eli Lilly and Company.</strong> <em>What to know about retatrutide.</em> Aktualizované v júli 2026. <a href="https://www.lilly.com/news/stories/what-to-know-about-retatrutide" target="_blank" rel="noopener noreferrer">lilly.com</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4S):S117–S314. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">KDIGO</a>.</li>
  <li><strong>Mozaffarian D, Agarwal M, Aggarwal M, et al.</strong> <em>Nutritional priorities to support GLP-1 therapy for obesity: a joint Advisory from the American College of Lifestyle Medicine, the American Society for Nutrition, the Obesity Medicine Association, and The Obesity Society.</em> Am J Clin Nutr. 2025;122(1):344–367. doi: 10.1016/j.ajcnut.2025.04.023. PMID 40450457. <a href="https://pubmed.ncbi.nlm.nih.gov/40450457/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Dobbie LJ, Tolvanen L, Alves D, et al.</strong> <em>Nutritional, functional, and psychological considerations for incretin-based therapies in adults: an EASO, EFAD, and ECPO Consensus Statement.</em> Lancet Diabetes Endocrinol. 2026;14(9):754–777. doi: 10.1016/S2213-8587(26)00122-1. PMID 42419343. <a href="https://pubmed.ncbi.nlm.nih.gov/42419343/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k interpretácii:</strong> Údaje o dlhodobých účinkoch jednotlivých sladidiel, údaje pri pokročilej CKD a priame štúdie počas inkretínovej liečby zostávajú obmedzené. Článok preto rozlišuje regulačné hodnotenie bezpečnosti, dôkazy z krátkodobých randomizovaných štúdií, observačné asociácie a preklinické mechanizmy. Nenahrádza individuálne nutričné odporúčanie ani posúdenie lekárom.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_alternativne-sladidla-masld-ckd-inkretinova-liecba_article',
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
      <link rel="stylesheet" href="index.css?v=20260509-1&amp;cb=<?= filemtime('index.css') ?>">
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
