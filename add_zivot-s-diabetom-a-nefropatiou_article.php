<?php
/**
 * add_zivot-s-diabetom-a-nefropatiou_article.php
 * Popularizačný článok (sekcia „Pre pacientov") — spracované z DOCX
 * „Život s diabetom a nefropatiou s AI ilustráciami" vrátane 17 AI ilustrácií
 * (img/zdn-01..zdn-17). Obrázky sú klikateľné (nová karta). PDF verzia je
 * ručne pripravený kurátorovaný súbor (pdf/zivot-s-diabetom-a-nefropatiou.pdf)
 * — slug je v PROTECTED_PDF_SLUGS, takže sa automaticky neprepisuje.
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_zivot-s-diabetom-a-nefropatiou_article.php"
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
    'title'        => 'Život s diabetom a nefropatiou',
    'slug'         => 'zivot-s-diabetom-a-nefropatiou',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 1,
    'pdf_file'     => 'zivot-s-diabetom-a-nefropatiou.pdf',
    'excerpt'      => 'Keď sa k diabetu pridá nefropatia, mení sa strava, pitný režim aj liečba cukrovky. Praktický sprievodca pre pokročilé štádiá a dialýzu – o soli, draslíku, fosfore, bielkovinách, tekutinách a o tom, prečo rozhoduje tím.',
    'content'      => <<<'NEFRO_HTML'
<figure class="article-figure">
  <a href="img/zdn-01.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-01.png" alt="Ilustrácia: život s diabetom a nefropatiou v pokročilom štádiu a na dialýze" loading="lazy" decoding="async">
  </a>
  <figcaption>Keď sa k diabetu pridá nefropatia, stáva sa z toho jeden spoločný príbeh.</figcaption>
</figure>

<p class="article-dek"><em>V pokročilých štádiách a na dialýze: praktický edukačný sprievodca.</em></p>

<p>Keď sa k diabetu pridá nefropatia, človek si často uvedomí, že „liečba diabetu“ už nie je samostatná téma. Zrazu ide o jeden spoločný príbeh, kde sa spájajú cukry, tlak, tekutiny, minerály v krvi a aj to, ako vaše telo reaguje na jedlo a samotnú dialýzu. Preto odporúčania pre diabetes pri chronickom ochorení obličiek (CKD) zdôrazňujú, že ide o komplexný manažment rizík a že ciele sa musia prispôsobiť štádiu ochorenia a vášmu konkrétnemu profilu rizík [1,2].</p>

<p>V pokročilých štádiách nefropatie (pred dialýzou) a najmä na dialýze sa potom mení rytmus dňa, mení sa aj to, čo je „správne“ v jedle a pití. Nejde však o náhodné obmedzovanie. Je to snaha udržať stabilitu vnútorného prostredia tak, aby ste mali menšie výkyvy, menej komplikácií a aby liečba diabetu aj obličiek bola bezpečná.</p>

<p>V tomto článku ukážem, ako na to v praxi – od stravy cez pitný režim až po význam komunikácie medzi diabetológom, nefrológom a dialyzačným tímom (a často aj dietológom), aby ste dosiahli bezpečnú starostlivosť.</p>

<figure class="article-figure">
  <a href="img/zdn-02.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-02.png" alt="Ilustrácia: diabetes a nefropatia ako jeden spoločný manažment rizík" loading="lazy" decoding="async">
  </a>
  <figcaption>Diabetes a nefropatia – jeden spoločný manažment rizík.</figcaption>
</figure>

<h2>Prečo sa v pokročilom štádiu menia „pravidlá hry“ (a prečo sa to nedá mať rovnako pre všetkých)</h2>

<p>V skorších štádiách môže človek s diabetom dlho žiť „bez toho, aby boli obličky viditeľné“. Obličky totiž spočiatku fungujú kompenzačne. Až neskôr sa začne odzrkadľovať to, čo sa dialo v pozadí: objavia sa zmeny v laboratóriách, rastie riziko komplikácií a postupne sa pridávajú aj režimové obmedzenia. Včasná diagnostika a starostlivosť môžu výrazne zlepšiť vaše vyhliadky.</p>

<p>Pri pokročilom CKD sa mení schopnosť obličiek udržiavať rovnováhu vody a elektrolytov a lieky sa musia prispôsobiť. KDIGO zdôrazňuje, že cieľom je vyvážiť prínos liečby a riziká, pričom každý pacient vyžaduje individuálny prístup, čo znamená úpravy liečby pri zmene režimu, stravy alebo začatí dialýzy.</p>

<p>A potom je tu ešte dialýza. Dialýza nie je „magický reset“. Je to liečba s presnými pravidlami, ktorá má svoje limity a riziká (napríklad preťaženie tekutinami alebo elektrolytové zmeny počas sedenia). Preto sa aj výživa a pitný režim na dialýze nastavujú tak, aby sa dialýza dala bezpečne a opakovane zvládnuť.</p>

<figure class="article-figure">
  <a href="img/zdn-03.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-03.png" alt="Ilustrácia: prečo sa v pokročilom štádiu menia pravidlá hry" loading="lazy" decoding="async">
  </a>
  <figcaption>Prečo sa v pokročilom štádiu menia pravidlá hry.</figcaption>
</figure>

<h2>Spolupráca špecialistov: prečo je „tím“ dôležitejší než jedna správna rada</h2>

<p>Mnohí pacienti sa cítia rozpoltení: každý špecialista im povie niečo správne – ale v inom kontexte. To je normálne, lebo každý rieši inú časť problému.</p>

<p>Diabetológ zvyčajne rieši bezpečné nastavenie cukrov (a v pokročilom štádiu aj riziko hypoglykémie). Nefrológ rieši CKD/diurézu, elektrolyty, tlak, progresiu ochorenia a načasovanie dialýzy (alebo režim pred dialýzou). Dialyzačný tím vie najlepšie, ako vyzerá váš „reálny“ dialyzačný priebeh: ako znášate sedenie, aké máte typické ťažkosti a aké bývajú vaše prírastky medzi dialýzami. Dietológ potom tieto medicínske ciele preloží do stravy tak, aby bola praktická a zároveň bezpečná.</p>

<p>Tento prístup – prepojenie edukácie, monitorovania a tímovej starostlivosti – zodpovedá tomu, ako sa odporúčania opakovane formulujú: nie „jedna rada pre všetkých“, ale plánovanie podľa rizík a podľa výsledkov v čase [1,2,4]. Vaša aktívna účasť a porozumenie sú kľúčové pre úspešnú liečbu a lepšiu kvalitu života.</p>

<figure class="article-figure">
  <a href="img/zdn-04.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-04.png" alt="Ilustrácia: tímová spolupráca diabetológa, nefrológa, dialyzačného tímu a dietológa" loading="lazy" decoding="async">
  </a>
  <figcaption>Tímová spolupráca je dôležitejšia než jedna správna rada.</figcaption>
</figure>

<h2>Strava: prečo pri nefropatii nejde len o to „čo nejesť“, ale aj o to, čo si organizmus nevie dovoliť</h2>

<p>Pri pokročilej nefropatii sa často hovorí o obmedzení príjmu draslíka, fosforu a sodíka. To je pravda, ale dôvod je ešte hlbší: ide o to, že obličky (alebo dialýza) nezvládajú tieto látky v rovnakom rozsahu ako zdravé obličky.</p>

<figure class="article-figure">
  <a href="img/zdn-05.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-05.png" alt="Ilustrácia: strava pri nefropatii" loading="lazy" decoding="async">
  </a>
  <figcaption>Strava pri nefropatii: nejde len o to, „čo nejesť“.</figcaption>
</figure>

<h3>Soľ (sodík) a tlak: prečo strava ovplyvňuje pitný režim viac, než si človek myslí</h3>

<p>Keď je v strave veľa sodíka, zvyčajne sa zvýši smäd a zároveň sa zvyšuje riziko, že medzi dialýzami (alebo aj v predialyzačnom období) bude v tele viac tekutín. To následne znamená väčší prírastok hmotnosti, vyšší tlak a horšiu toleranciu dialýzy.</p>

<p>Práve preto dialyzačné edukácie kladú dôraz na to, aby pacient rozumel tomu, že pitný režim sa nedá udržať bez úpravy stravy a najmä bez obmedzenia soli [5,6,7]. Prakticky to býva najväčší rozdiel v tom, či režim „ide“ alebo či je človek neustále v smäde a pod tlakom.</p>

<figure class="article-figure">
  <a href="img/zdn-06.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-06.png" alt="Ilustrácia: soľ, smäd a obličky" loading="lazy" decoding="async">
  </a>
  <figcaption>Soľ, smäd a obličky – soľ v strave ovplyvňuje celý pitný režim.</figcaption>
</figure>

<h3>Draslík: prečo sa nevyberá podľa zoznamu z internetu</h3>

<p>V CKD a na dialýze môže draslík v krvi rásť. Príliš vysoký draslík môže byť nebezpečný pre srdce, a preto sa s ním opatrne pracuje. Ale obmedzenia draslíka nie sú pre každého identické: závisia od vašich aktuálnych hladín, od dialyzačnej schémy a často aj od toho, čo sa vám v praxi reálne darí jesť.</p>

<p>Preto sa v edukáciách opakovane zdôrazňuje individualizácia a sledovanie laboratórií. Dietoterapia v nefropatii je „vedená cieľmi“ – laboratórne hodnoty určujú, čo je v danom čase problém [1,4,7].</p>

<figure class="article-figure">
  <a href="img/zdn-07.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-07.png" alt="Ilustrácia: draslík a nefropatia" loading="lazy" decoding="async">
  </a>
  <figcaption>Draslík sa nevyberá podľa zoznamu z internetu, ale podľa laboratórií.</figcaption>
</figure>

<h3>Fosfor: prečo sa rieši dlhodobo, aj keď sa človek necíti „chorý“</h3>

<p>Fosfor pri CKD často narastá postupne a dlhodobo to môže poškodzovať kosti a zvyšovať riziká spojené s minerálovým metabolizmom. Preto sa strava prispôsobí a ak máte predpísané viazače fosforu, sú súčasťou stratégie, nie „doplnkom k režimu“.</p>

<p>Pritom je veľmi dôležité načasovanie viazačov. V praxi sa veľa problémov stane z drobností – napríklad z toho, že tabletky nie sú užité presne s jedlom alebo sa vynechajú v dňoch, keď má pacient horšiu chuť do jedla. Dialyzačné a renálne nutričné materiály preto fosfor uvádzajú ako jednu z centrálnych tém stravy [4,6,7].</p>

<figure class="article-figure">
  <a href="img/zdn-08.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-08.png" alt="Ilustrácia: fosfor a nefropatia" loading="lazy" decoding="async">
  </a>
  <figcaption>Fosfor sa rieši dlhodobo, aj keď sa človek necíti „chorý“.</figcaption>
</figure>

<h3>Bielkoviny a energia: prečo na dialýze môže byť problém skôr opačný než „jesť menej“</h3>

<p>Ľudia s ochorením obličiek niekedy znížia príjem bielkovín zo strachu. Lenže dialýza a pokročilé CKD zvyšujú riziko podvýživy a svalového úbytku. Preto nutričné odporúčania pri CKD a najmä pri dialýze pracujú s tým, aby pacient nebol v energetickom deficite a aby mal dostatok bielkovín v dávkovaní podľa štádia a stavu [4,6].</p>

<p>Je dôležité povedať jednu vec „ľudsky“: cieľom nie je hladovať. Cieľom je jesť tak, aby boli všetky relevantné parametre (sodík, draslík, fosfor, energia, bielkoviny) v rovnováhe. A to sa robí s dietológom a podľa vašich výsledkov.</p>

<figure class="article-figure">
  <a href="img/zdn-09.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-09.png" alt="Ilustrácia: bielkoviny a energia pri dialýze" loading="lazy" decoding="async">
  </a>
  <figcaption>Bielkoviny a energia: na dialýze býva problém skôr opačný než „jesť menej“.</figcaption>
</figure>

<h3>Pitný režim: prečo je to jedna z najťažších častí dialýzy a zároveň najviac „naučiteľná“</h3>

<p>Pitný režim sa často vníma ako disciplína. Ale správne nastavený pitný režim je najmä o fyziológii a plánovaní. Dialýza odstraňuje tekutiny v určitom čase a do určitej miery. Ak medzi dialýzami vypijete viac, telo sa postupne preplní tekutinami a dialýza musí uberať viac – čo zvyšuje riziko poklesu tlaku, kŕčov, dýchavičnosti a nepohody počas sedenia.</p>

<p>Preto americká National Kidney Foundation aj mnohé dialyzačné edukačné materiály zdôrazňujú, že tekutinové obmedzenie má byť presne podľa predpisu vášho tímu a že pomáha pracovať so stratégiami (sledovanie príjmu, náhrady pri smäde a najmä zníženie príjmu sodíka, aby smäd rástol menej) [5]. Slovenské dialyzačné príručky pre pacientov túto logiku rozvádzajú tak, že pitný režim a prírastky medzi dialýzami sú kľúčové pre komfort a bezpečnosť dialýzy [6].</p>

<p>Je veľmi dôležité, aby ste si uvedomili, že tekutinový limit nie je „trest za nedisciplinovanosť“. Limit sa dá diskutovať. Ak sa vám nedarí držať limit, často to nie je len o pití, ale aj o soli v jedle, o tom, ako máte nastavené dávky liekov (napríklad na tlak alebo režimy súvisiace s diabetom) a o tom, či máte správne zvládnutú hydratáciu pri horších dňoch.</p>

<figure class="article-figure">
  <a href="img/zdn-10.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-10.png" alt="Ilustrácia: pitný režim pri dialýze" loading="lazy" decoding="async">
  </a>
  <figcaption>Pitný režim – jedna z najťažších, no najviac naučiteľných častí dialýzy.</figcaption>
</figure>

<h2>Diabetes pri nefropatii a na dialýze: prečo sa mení riziko hypo/hyperglykémie a prečo nesmiete improvizovať</h2>

<p>V pokročilom CKD sa mení „správanie“ organizmu. Zmení sa tolerancia jedla, zmení sa aj rytmus dialýzy, často sa mení aj chuť do jedla (alebo sa mení typ jedál podľa draslíka/fosforu). To u určitých ľudí mení priebeh glykémie počas dňa.</p>

<p>K tomu sa pridáva aj to, že pri CKD a dialýze môžu byť niektoré lieky pre organizmus „z hľadiska bezpečnosti“ iné. KDIGO preto odporúča individualizovať liečbu diabetu aj ciele a zdôrazňuje, že pri CKD treba zohľadniť riziká vrátane hypoglykémie [1,2]. V praxi to znamená, že keď nastane zmena režimu (napríklad deň pred dialýzou, deň po dialýze, menej jedla, zmenený príjem tekutín), dávkovanie liekov by sa nemalo riešiť „od oka“.</p>

<p>Ak sa vám pri dialýze opakovane robí zle (napríklad tras, potenie, zmätenosť, slabosť, výrazne nízke hodnoty), nepovažujte to za „osobnú slabosť“. Je to signál, že plán treba prekalibrovať v spolupráci s diabetológom a dialyzačným tímom [1,6].</p>

<figure class="article-figure">
  <a href="img/zdn-11.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-11.png" alt="Ilustrácia: prečo je pri diabete na dialýze dôležitá opatrnosť" loading="lazy" decoding="async">
  </a>
  <figcaption>Diabetes na dialýze: prečo netreba improvizovať.</figcaption>
</figure>

<h2>Viazače fosforu, doplnky a lieky: najčastejšie chyby sú v drobnostiach</h2>

<p>V praxi býva problém v tom, že si pacient niekedy myslí, že „vitamín“ alebo „doplnok minerálov“ je automaticky bezpečný. Pri CKD to však nie je pravda. Draslík a fosfor sa môžu zhoršovať aj prostredníctvom doplnkov, nie iba cez jedlo. A niektoré doplnky môžu zasahovať do rovnováhy alebo do toho, ako sa cítite počas dialýzy.</p>

<p>Rovnako viazače fosforu fungujú len vtedy, ak sú použité správne. Preto sa v edukáciách opakovane zdôrazňuje, že lieky pri obličkových komplikáciách nie sú „voliteľné podľa chuti“, ale sú súčasťou liečebnej stratégie [4,6,7].</p>

<p>Toto je miesto, kde sa oplatí spraviť jednu jednoduchú vec: mať zoznam liekov a dávok a vždy ho ukázať pri kontrole diabetológa aj nefrológa (a najmä dialyzačnému tímu). To znižuje riziko, že sa niečo prehliadne.</p>

<figure class="article-figure">
  <a href="img/zdn-12.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-12.png" alt="Ilustrácia: najčastejšie chyby pri liekoch a viazačoch sú v drobnostiach" loading="lazy" decoding="async">
  </a>
  <figcaption>Viazače, doplnky a lieky – najčastejšie chyby sú v drobnostiach.</figcaption>
</figure>

<h2>Pred dialýzou vs. na dialýze: prečo sa pravidlá môžu líšiť aj v tom, na čo najviac „dávate pozor“</h2>

<p>V predialyzačnom období CKD je cieľom často spomaliť progresiu a zachovať stabilitu. Tam môže byť tekutinový režim menej „ostro ohraničený“ ako na dialýze, no aj tak často sú potrebné úpravy podľa príznakov, tlaku a laboratórií.</p>

<p>Na dialýze sa však pitný režim rieši veľmi konkrétne, pretože priamo súvisí s prírastkami medzi dialýzami a s tým, koľko tekutiny dialýza odstráni. Dialyzačné edukačné materiály preto prírastky a pitný režim pripomínajú ako praktickú súčasť úspešnosti dialyzačného liečenia [6,7]. Zároveň je dobré vedieť, že peritoneálna dialýza má iný spôsob odstránenia tekutín a iné režimové princípy (nie vždy rovnaké obmedzenia tekutín ako pri hemodialýze), takže presné odporúčania sa vždy majú riadiť vašou metódou a pokynmi tímu [6].</p>

<figure class="article-figure">
  <a href="img/zdn-13.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-13.png" alt="Ilustrácia: rozdiely medzi predialýzou a dialýzou" loading="lazy" decoding="async">
  </a>
  <figcaption>Pred dialýzou vs. na dialýze: pravidlá sa môžu líšiť.</figcaption>
</figure>

<h2>Každodenný život: ako sa režim „nezlomí“ pri cestovaní, chorobe alebo horšej chuti do jedla</h2>

<p>Jedna z najväčších výziev pri dialýze a pokročilom CKD je, že život nie je laboratórium. Prídu dni, keď budete mať menej chuti, príde chrípka, hnačka, zvracanie, horúčka alebo cestovanie.</p>

<p>Pri diabetikovi je navyše kľúčové, že zmena príjmu jedla môže zmeniť glykémiu veľmi rýchlo. A pri obličkách môže zmena hydratácie zmeniť tlak a minerály.</p>

<p>Aj preto mnohé edukácie zdôrazňujú, že pacient má vedieť, čo urobiť, keď sa zhorší stav – komu zavolať a aký je „smer“ riešenia (najmä pri opakovaných problémoch alebo dehydratácii/prehnanom smäde). NKF napríklad vo svojich dialyzačných edukáciách smeruje k tomu, aby pacient pracoval so systémom a sledoval, nie aby čakal až na veľký problém [5]. Slovenské dialyzačné príručky obdobne vedú pacienta k tomu, že pravidlá sú na udržanie bezpečnosti a komfortu [6].</p>

<p>Prakticky to znamená: ak máte „zlý deň“ (menej jedla, viac smädu, zmena stolice), nespoliehajte sa len na intuitívne rozhodnutia. Radšej to vopred preberte s tímom alebo aspoň zavolajte, keď sa to opakuje.</p>

<figure class="article-figure">
  <a href="img/zdn-14.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-14.png" alt="Ilustrácia: každodenný život s diabetom a nefropatiou" loading="lazy" decoding="async">
  </a>
  <figcaption>Každodenný život: ako sa režim nezlomí pri chorobe či cestovaní.</figcaption>
</figure>

<h2>Kedy je čas kontaktovať tím skôr (a nie až „kým to prejde“)</h2>

<p>V dialýze aj v pokročilom CKD platí jedna jednoduchá myšlienka: čím skôr zachytíte odchýlku, tým jednoduchšie sa často dá riešiť. Samozrejme, presný zoznam príznakov má byť podľa vášho centra, ale typicky ide o situácie ako dýchavičnosť, rýchle opuchy, výrazné zmeny prírastkov, opakované závraty alebo ťažkosti počas dialýzy, výrazné zmeny glykémie a príznaky hypoglykémie.</p>

<p>Dialyzačné príručky pre pacientov túto logiku komunikácie „nečakať“ opakovane vysvetľujú v edukácii o režime a bezpečnosti [6]. NKF pri tekutinách a dialyzačných obmedzeniach podobne zdôrazňuje, že tekutinové odporúčania nie sú teoretické, pretože preťaženie tekutinami mení priebeh dialýzy [5].</p>

<figure class="article-figure">
  <a href="img/zdn-15.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-15.png" alt="Ilustrácia: kedy kontaktovať tím skôr" loading="lazy" decoding="async">
  </a>
  <figcaption>Kedy kontaktovať tím skôr – nečakať, „kým to prejde“.</figcaption>
</figure>

<h2>Záver: čo je naozaj cieľom (a aby ste sa cítili menej ako „pacient s pravidlami“)</h2>

<p>Keď to celé zhrniem do jedného „ľudského“ odseku, cieľom nie je mať dokonalý režim každý deň. Cieľom je mať bezpečný režim, ktorý sa dá udržať a včas upravovať podľa výsledkov a podľa toho, ako naň reagujete vy.</p>

<p>Diabetológ a nefrológ vám pomáhajú nastaviť si ciele a zabezpečiť bezpečnú liečbu. Dialyzačný tím vám pomáha zvládať dialýzu. Dietológ vám preloží medicínske ciele do jedál a do toho, čo je pre vás prakticky možné. Keď sa toto „spojí“, režim prestane byť len súborom zákazov a začne byť oporou pre kvalitu života.</p>

<figure class="article-figure">
  <a href="img/zdn-16.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-16.png" alt="Ilustrácia: cieľom je bezpečnosť a kvalita života" loading="lazy" decoding="async">
  </a>
  <figcaption>Cieľom je bezpečnosť a kvalita života.</figcaption>
</figure>

<figure class="article-figure">
  <a href="img/zdn-17.png" target="_blank" rel="noopener noreferrer">
    <img src="img/zdn-17.png" alt="Ilustrácia: dve cesty, jeden cieľ – spolupráca diabetológa a nefrológa" loading="lazy" decoding="async">
  </a>
  <figcaption>Dve cesty, jeden cieľ – diabetológ aj nefrológ smerujú k vašej bezpečnej liečbe.</figcaption>
</figure>

<p><em>Autor je nefrológ a internista s rozsiahlymi skúsenosťami v dialyzačnej liečbe, klinickej a preventívnej nefrológii aj v riadení dialyzačných stredísk.</em></p>

<p><em>Tento článok má informačný a vzdelávací charakter a nenahrádza vyšetrenie, diagnostiku ani liečbu u vášho lekára. O konkrétnej strave, pitnom režime, liekoch a úprave liečby diabetu pri nefropatii a na dialýze sa vždy poraďte so svojím lekárom a dialyzačným tímom.</em></p>

<hr>

<h2>Zdroje</h2>
<ol>
  <li>KDIGO 2022 – Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease. <a href="https://kdigo.org/wp-content/uploads/2022/10/KDIGO-2022-Clinical-Practice-Guideline-for-Diabetes-Management-in-CKD.pdf" target="_blank" rel="noopener noreferrer">kdigo.org (PDF)</a></li>
  <li>KDIGO 2024 – Clinical Practice Guideline for the Evaluation and Management of CKD (Executive summary). <a href="https://kdigo.org/wp-content/uploads/2017/02/KDIGO-2024-CKD-Guideline-Executive-Summary.pdf" target="_blank" rel="noopener noreferrer">kdigo.org (PDF)</a> – celý dokument: <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">kdigo.org (PDF)</a></li>
  <li>KDOQI 2020 – Clinical Practice Guideline for Nutrition in CKD. <a href="https://www.ajkd.org/article/S0272-6386(20)30726-5/fulltext" target="_blank" rel="noopener noreferrer">ajkd.org</a></li>
  <li>National Kidney Foundation – Learning to follow your dialysis fluid restrictions. <a href="https://www.kidney.org/news-stories/learning-to-follow-your-dialysis-fluid-restrictions" target="_blank" rel="noopener noreferrer">kidney.org</a></li>
  <li>National Kidney Foundation – Dos and don’ts of fluid management for kidney disease. <a href="https://www.kidney.org/news-stories/dos-and-don-ts-fluid-management-kidney-disease" target="_blank" rel="noopener noreferrer">kidney.org</a></li>
  <li>Príručka pacienta liečeného hemodialýzou (SK). <a href="http://dialyza.hello.sk/hemodialyza.pdf" target="_blank" rel="noopener noreferrer">dialyza.hello.sk (PDF)</a></li>
  <li>Obličková diéta – Sprievodca výživou pri chronickom ochorení obličiek (SK). <a href="https://www.oblickovadieta.sk/wp-content/uploads/2023/12/pruvodce-vyzivou-pri-chronickem-onemocneni-ledvin-sk.pdf" target="_blank" rel="noopener noreferrer">oblickovadieta.sk (PDF)</a></li>
  <li>Zväz diabetikov Slovenska – DiaSpektrum (archív): <a href="https://zds.sk/casopis/Diaspektrum_2_2025.pdf" target="_blank" rel="noopener noreferrer">2/2025</a>, <a href="https://zds.sk/casopis/Diaspektrum_1_2024.pdf" target="_blank" rel="noopener noreferrer">1/2024</a></li>
  <li>Solen (SK) – Prevencia alebo spomalenie progresie diabetickej nefropatie. <a href="https://www.solen.sk/storage/file/article/3a76f564dd0042d82883e6e84da06f1c.pdf" target="_blank" rel="noopener noreferrer">solen.sk (PDF)</a></li>
  <li>Taiar R, Cunha T, Rodrigues Lacerda A. The prognostic value of gait speed in hemodialysis patients: a prospective observational study. PLoS One. 2026;21(3):e0343612. <a href="https://journals.plos.org/plosone/article?id=10.1371/journal.pone.0343612" target="_blank" rel="noopener noreferrer">journals.plos.org</a></li>
</ol>
NEFRO_HTML,
];

// ── Vkladanie do databázy (UPSERT) ──────────────────────────────────────────
// Newsletter avízo LEN pri prvom vložení (rc === 1). `pdf_file` ukazuje na ručne
// pripravený kurátorovaný PDF (slug je v PROTECTED_PDF_SLUGS → neprepisuje sa).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, category, published_at, is_top, is_published, pdf_file)
     VALUES (:title, :slug, :author, :content, :excerpt, 'popularne', :published_at, :is_top, 1, :pdf_file)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt),
        category = 'popularne', is_top = VALUES(is_top), pdf_file = VALUES(pdf_file)"
);

$inserted = 0; $updated = 0; $skipped = 0; $errors = []; $queuedTotal = 0;
foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title' => $a['title'], 'slug' => $a['slug'], 'author' => $a['author'],
            'content' => $a['content'], 'excerpt' => $a['excerpt'],
            'published_at' => $a['published_at'], 'is_top' => $a['is_top'],
            'pdf_file' => $a['pdf_file'],
        ]);
        $rc = $stmt->rowCount();
        if ($rc === 0) { $skipped++; continue; }
        if ($rc === 1) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try { $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId); }
            catch (\Throwable $qe) { error_log('add_zivot_nefropatia newsletter enqueue error: ' . $qe->getMessage()); }
        } else {
            $updated++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . $a['title'] . '": ' . $e->getMessage();
        error_log('add_zivot_nefropatia migration error: ' . $e->getMessage());
    }
}

$total = count($articles);
if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Život s diabetom a nefropatiou: $inserted vložených, $updated aktualizovaných z $total.\n";
    echo "Preskočené (bez zmeny):    $skipped\n";
    echo "Zaradených do fronty avíz: $queuedTotal\n";
    foreach ($errors as $e) { echo "  - $e\n"; }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Život s diabetom a nefropatiou: $inserted vložených, $updated aktualizovaných, $skipped bez zmeny | Avíza: $queuedTotal\n";
    foreach ($errors as $e) { echo "  - $e\n"; }
}
