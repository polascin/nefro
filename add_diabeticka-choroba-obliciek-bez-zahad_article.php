<?php

/**
 * add_diabeticka-choroba-obliciek-bez-zahad_article.php
 * Popularizačný článok (sekcia „Pre pacientov“) — spracované z DOCX vrátane
 * 19 AI ilustrácií (img/dkd-01..dkd-19). Obrázky sú klikateľné (nová karta).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_diabeticka-choroba-obliciek-bez-zahad_article.php"
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať popularizačný článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';
$articles = [];

$articles[] = [
    'title'        => 'Diabetická choroba obličiek bez záhad',
    'slug'         => 'diabeticka-choroba-obliciek-bez-zahad',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 1,
    'excerpt'      => 'Diabetická choroba obličiek sa dlho vyvíja bez príznakov. Zrozumiteľne o tom, čo sa deje v obličkách pri cukrovke, ako čítať kreatinín, eGFR a albumín v moči a prečo rozhoduje včasný záchyt.',
    'content'      => <<<'NEFRO_HTML'
<p class="article-dek"><em>Čo sa deje v obličkách pri cukrovke, ako čítať kreatinín a bielkovinu v moči a prečo rozhoduje včasný záchyt</em></p>
<p>Cukrovka neznamená iba zvýšenú hladinu cukru – konkrétne glukózy – v krvi. Ak trvá roky, môže ovplyvniť cievy, nervy, oči, srdce aj obličky. Práve obličky patria medzi orgány, ktoré dlho „nebolia“ a nehlásia problém viditeľnými príznakmi. Preto sa diabetická choroba obličiek často rozvíja potichu.</p>
<p>Dobrá správa je, že dnes vieme zachytiť DKD skôr a efektívnejšie ako predtým, čo môže pacientom dodať pocit istoty a nádeje, že je ich zdravie pod kontrolou.</p>
<p>Diabetická choroba obličiek, skrátene DKD, je poškodenie obličiek spôsobené cukrovkou. Aby ste ju mohli čo najlepšie ochrániť, je dôležité udržiavať hladinu cukru a krvný tlak v odporúčaných hodnotách, pravidelne kontrolovať moč a krv a dodržiavať odporúčania lekára ohľadom liečby a životného štýlu.</p>
<figure class="article-figure">
  <a href="img/dkd-01.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-01.png" alt="Ilustrácia: diabetická choroba obličiek sa vyvíja potichu" loading="lazy" decoding="async">
  </a>
  <figcaption>Diabetická choroba obličiek sa dlho vyvíja bez príznakov.</figcaption>
</figure>
<h2>Obličky ako jemný filter</h2>
<p>Obličky filtrujú krv. Denne cez ne pretečie veľké množstvo krvi a v drobných filtračných jednotkách, ktoré sa nazývajú glomeruly, sa oddeľujú látky, ktoré má telo vylúčiť, od látok, ktoré si má ponechať.</p>
<p>Zjednodušene povedané, zdravý obličkový filter má prepúšťať odpadové látky, ale nemá prepúšťať významné množstvo bielkovín. Bielkoviny, najmä albumín, majú zostať v krvi.</p>
<p>Pri cukrovke sa však tento jemný filter môže postupne poškodzovať. Dlhodobo zvýšená hladina cukru mení vlastnosti drobných ciev, podporuje zápalové a oxidačné procesy a vedie k zhrubnutiu a zjazvovaniu častí obličkového tkaniva. Ak sa pridá vysoký krvný tlak, obličky sú vystavené ešte väčšiemu tlakovému zaťaženiu.</p>
<p>Výsledkom môže byť najprv nenápadný únik albumínu do moču. Neskôr môže klesnúť filtračná schopnosť obličiek.</p>
<figure class="article-figure">
  <a href="img/dkd-02.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-02.png" alt="Ilustrácia k téme: Obličky ako jemný filter" loading="lazy" decoding="async">
  </a>
  <figcaption>Obličky ako jemný filter</figcaption>
</figure>
<h2>Prečo obličky pri cukrovke dlho nebolia</h2>
<p>Mnohí pacienti si pod poškodením obličiek predstavia bolesť v krížoch, pálenie pri močení alebo viditeľnú zmenu moču. Pri diabetickej chorobe obličiek to tak väčšinou nie je. Preto je dôležité, aby pacienti s cukrovkou podstupovali pravidelné laboratórne kontroly, ideálne raz ročne alebo podľa odporúčania lekára.</p>
<p>Ak čakáme na príznaky, môžeme prísť príliš neskoro. Keď sa objavia výrazné opuchy, únava, zhoršenie krvného tlaku, málokrvnosť alebo výrazné zmeny vnútorného prostredia, obličkové poškodenie už môže byť pokročilé.</p>
<figure class="article-figure">
  <a href="img/dkd-03.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-03.png" alt="Ilustrácia k téme: Prečo obličky pri cukrovke dlho nebolia" loading="lazy" decoding="async">
  </a>
  <figcaption>Prečo obličky pri cukrovke dlho nebolia</figcaption>
</figure>
<h2>Kreatinín: užitočný, ale nie dokonalý ukazovateľ</h2>
<p>Kreatinín je látka, ktorá vzniká vo svaloch a vylučuje sa obličkami. V krvi ho meriame preto, lebo jeho zvýšenie môže signalizovať zhoršenú funkciu obličiek.</p>
<p>Problém je v tom, že samotný kreatinín niekedy klame svojou „normálnosťou“. Okrem toho môžu byť hodnoty kreatinínu a eGFR ovplyvnené faktormi ako vek, svalová hmota alebo užívanie doplnkov, čo je dôležité pri interpretácii výsledkov.</p>
<p>Preto sa dnes nepozeráme iba na kreatinín samotný. Z kreatinínu sa vypočítava odhadovaná glomerulová filtrácia, známa pod skratkou eGFR. Táto formulácia lepšie vyjadruje, ako obličky krv filtrujú.</p>
<figure class="article-figure">
  <a href="img/dkd-04.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-04.png" alt="Ilustrácia k téme: Kreatinín: užitočný, ale nie dokonalý ukazovateľ" loading="lazy" decoding="async">
  </a>
  <figcaption>Kreatinín: užitočný, ale nie dokonalý ukazovateľ</figcaption>
</figure>
<h2>Kreatín ako doplnok výživy môže skresliť kreatinín</h2>
<p>Pri hodnotení kreatinínu je dôležité vedieť aj to, či pacient neužíva potravinový doplnok kreatín. Kreatín sa dlhé roky používal najmä vo fitnes a silovom tréningu, no v poslednom období sa o ňom čoraz viac hovorí aj v súvislosti so starnutím, udržiavaním svalovej hmoty a možným vplyvom na kognitívne funkcie. Dôkazy o priaznivom účinku na kogníciu u starších ľudí sú zatiaľ sľubné, ale nie úplne jednoznačné.</p>
<p>Z pohľadu obličkových výsledkov je podstatné, že kreatín je metabolický substrát, z ktorého v tele vzniká kreatinín. Ak človek užíva kreatín, môže sa zvýšiť hladina kreatinínu v krvi bez toho, aby to automaticky znamenalo skutočné zhoršenie funkcie obličiek. Keďže sa z kreatinínu počíta aj eGFR, teda odhadovaná glomerulová filtrácia, kreatín môže nepriamo spôsobiť aj zdanlivé zníženie eGFR. Výsledok potom môže navodiť falošný dojem, že sa obličky zhoršili.</p>
<p>Preto je dôležité, aby pacient lekárovi povedal, že kreatín užíva. Platí to najmä vtedy, ak sa kreatinín náhle zvýši alebo eGFR nečakane klesne bez iného vysvetlenia. V takých situáciách môže lekár zvážiť opakované vyšetrenie po dočasnom vysadení doplnku alebo použiť alternatívne spôsoby odhadu funkcie obličiek, napríklad výpočet eGFR podľa cystatínu C. Cystatín C je marker, ktorý nie je priamo závislý od príjmu kreatínu a svalového metabolizmu v takej miere ako kreatinín.</p>
<p>Dôležité je rozlišovať medzi laboratórnym skreslením a skutočným poškodením obličiek. Súčasné dostupné dôkazy neukazujú, že by primerané užívanie kreatínu u ľudí so zdravými obličkami samo osebe poškodzovalo obličky. Opatrnosť je však namieste u pacientov s už známou chronickou chorobou obličiek, pri cukrovke, vysokom krvnom tlaku, dehydratácii alebo pri súčasnom užívaní liekov, ktoré môžu obličky zaťažovať. V týchto prípadoch je rozumné užívanie kreatínu vopred konzultovať s lekárom.</p>
<figure class="article-figure">
  <a href="img/dkd-05.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-05.png" alt="Ilustrácia k téme: Kreatín ako doplnok výživy môže skresliť kreatinín" loading="lazy" decoding="async">
  </a>
  <figcaption>Kreatín ako doplnok výživy môže skresliť kreatinín</figcaption>
</figure>
<h2>Čo si všímať vo výsledkoch</h2>
<p>Pri kontrole obličiek u človeka s cukrovkou nestačí pozrieť sa iba na jednu hodnotu. Dôležitý je najmä celkový obraz:</p>
<ul>
  <li>kreatinín v krvi,</li>
  <li>eGFR, čiže odhad filtračnej schopnosti obličiek,</li>
  <li>albumín v moči alebo pomer albumín/kreatinín v moči, často označovaný ako ACR alebo uACR,</li>
  <li>močový sediment, najmä ak je prítomná krv alebo zápalový nález v moči,</li>
  <li>krvný tlak,</li>
  <li>vývoj výsledkov v čase, nielen jedna izolovaná hodnota,</li>
  <li>užívanie kreatínu ako doplnku výživy, pretože môže zvýšiť hladinu kreatinínu a znížiť vypočítanú eGFR bez skutočného zhoršenia funkcie obličiek.</li>
</ul>
<p>Ak je kreatinín „v norme“, ešte to automaticky neznamená, že obličky sú úplne bez rizika. Pri cukrovke je veľmi dôležité aj vyšetrenie albumínu v moči.</p>
<figure class="article-figure">
  <a href="img/dkd-06.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-06.png" alt="Ilustrácia k téme: Čo si všímať vo výsledkoch" loading="lazy" decoding="async">
  </a>
  <figcaption>Čo si všímať vo výsledkoch</figcaption>
</figure>
<h2>Čo znamená eGFR</h2>
<p>eGFR je odhad filtračnej schopnosti obličiek. Udáva sa najčastejšie v ml/min/1,73 m². Čím je eGFR nižšia, tým je filtračná funkcia obličiek slabšia.</p>
<p>Veľmi zjednodušene:</p>
<ul>
  <li>eGFR nad 90 môže byť normálna, ak nie sú iné známky poškodenia obličiek,</li>
  <li>eGFR 60 až 89 môže byť ešte relatívne dobrá, ale treba ju hodnotiť spolu s močom a celkovým rizikom,</li>
  <li>eGFR pod 60, ak trvá aspoň 3 mesiace, už zodpovedá chronickej chorobe obličiek,</li>
  <li>čím nižšia eGFR, tým vyššie riziko komplikácií a tým dôležitejšia je nefrologická starostlivosť.</li>
</ul>
<p>Treba však zdôrazniť, že jedna hodnota nestačí na dôležité závery. Obličkovú funkciu treba hodnotiť v priebehu času. Dôležité je, či je stav stabilný alebo či sa eGFR postupne znižuje.</p>
<figure class="article-figure">
  <a href="img/dkd-07.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-07.png" alt="Ilustrácia k téme: Čo znamená eGFR" loading="lazy" decoding="async">
  </a>
  <figcaption>Čo znamená eGFR</figcaption>
</figure>
<h2>Bielkovina v moči: skorý varovný signál</h2>
<p>Pri cukrovke je mimoriadne dôležité vyšetrenie albumínu v moči. Albumín je hlavná bielkovina krvnej plazmy. Zdravé obličky ho do moču prepúšťajú len v minimálnych množstvách.</p>
<p>Ak sa albumín v moči zvyšuje, môže to byť skorý príznak poškodenia obličkového filtra. Často sa používa vyšetrenie pomeru albumínu ku kreatinínu v moči, označované ako ACR alebo uACR (UACR). Výhodou je, že sa dá vyšetriť z jednej vzorky moču, najčastejšie z ranného.</p>
<p>Orientačne sa nález hodnotí takto:</p>
<ul>
  <li>normálny alebo mierne zvýšený albumín v moči: ACR pod 3 mg/mmol,</li>
  <li>stredne zvýšený albumín v moči: ACR 3 až 30 mg/mmol,</li>
  <li>výrazne zvýšený albumín v moči: ACR nad 30 mg/mmol.</li>
</ul>
<p>Tieto hranice sa môžu v laboratórnych výsledkoch uvádzať aj v iných jednotkách, preto je vždy potrebné pozerať sa na referenčné hodnoty konkrétneho laboratória a na interpretáciu lekára.</p>
<p>Dôležité je aj to, že zvýšený albumín v moči nemusí automaticky znamenať trvalé poškodenie. Prechodne sa môže zvýšiť pri horúčke, infekcii močových ciest, výraznej fyzickej námahe, zle kompenzovanom krvnom tlaku, veľmi vysokej glykémii alebo pri akútnom ochorení. Preto sa nález zvyčajne potvrdzuje opakovaným vyšetrením.</p>
<figure class="article-figure">
  <a href="img/dkd-08.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-08.png" alt="Ilustrácia k téme: Bielkovina v moči: skorý varovný signál" loading="lazy" decoding="async">
  </a>
  <figcaption>Bielkovina v moči: skorý varovný signál</figcaption>
</figure>
<h2>Čo si všímať pri bielkovine v moči</h2>
<p>Pacient by sa mal lekára opýtať najmä na to, či ide o:</p>
<ul>
  <li>jednorazový nález alebo opakovane potvrdený nález,</li>
  <li>malé, stredné alebo výrazné zvýšenie albumínu v moči,</li>
  <li>nález spojený s poklesom eGFR,</li>
  <li>nález sprevádzaný krvou v moči alebo inými netypickými zmenami,</li>
  <li>stav, ktorý si vyžaduje úpravu liečby alebo nefrologické vyšetrenie.</li>
</ul>
<p>Samotná „bielkovina v moči“ nie je diagnóza. Je to signál, ktorý treba správne zaradiť do celkového obrazu pacienta.</p>
<figure class="article-figure">
  <a href="img/dkd-09.jpeg" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-09.jpeg" alt="Ilustrácia k téme: Čo si všímať pri bielkovine v moči" loading="lazy" decoding="async">
  </a>
  <figcaption>Čo si všímať pri bielkovine v moči</figcaption>
</figure>
<h2>Prečo sa sleduje aj močový sediment</h2>
<p>Pri diabetickej chorobe obličiek je typická najmä prítomnosť albumínu v moči a postupný pokles eGFR. Ak sa však v moči objavuje krv, výrazný zápalový nález, valce alebo iné netypické zmeny, lekár musí myslieť aj na iné ochorenia obličiek.</p>
<p>Nie každý problém s obličkami u diabetika je automaticky spôsobený cukrovkou. Diabetik môže mať aj zápalové, imunologické, cievne, urologické alebo liekové poškodenie obličiek. Preto má význam nielen kreatinín a albumín, ale aj celkové vyšetrenie moču a klinický kontext.</p>
<figure class="article-figure">
  <a href="img/dkd-10.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-10.png" alt="Ilustrácia k téme: Prečo sa sleduje aj močový sediment" loading="lazy" decoding="async">
  </a>
  <figcaption>Prečo sa sleduje aj močový sediment</figcaption>
</figure>
<h2>Včasný záchyt mení prognózu</h2>
<p>V minulosti bola diabetická choroba obličiek často považovaná za takmer nevyhnutný osud časti pacientov s dlhoročnou cukrovkou. Dnes je pohľad iný. Vieme, že riziko možno významne ovplyvniť.</p>
<p>Najväčší význam má:</p>
<ul>
  <li>dobrá, ale bezpečná kompenzácia cukrovky,</li>
  <li>dôsledná liečba krvného tlaku,</li>
  <li>liečba albuminúrie,</li>
  <li>ochrana srdca a ciev,</li>
  <li>nefajčenie,</li>
  <li>rozumná životospráva,</li>
  <li>pravidelné kontroly krvi a moču,</li>
  <li>správne zvolená liečba s ochranným účinkom na obličky.</li>
</ul>
<p>Včasný záchyt je dôležitý preto, že v skorých štádiách máme najväčšiu šancu spomaliť poškodzovanie obličiek. Keď je obličkové tkanivo už výrazne zjazvené, možnosti liečby sú obmedzenejšie.</p>
<figure class="article-figure">
  <a href="img/dkd-11.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-11.png" alt="Ilustrácia k téme: Včasný záchyt mení prognózu" loading="lazy" decoding="async">
  </a>
  <figcaption>Včasný záchyt mení prognózu</figcaption>
</figure>
<h2>Cukor nie je jediný problém</h2>
<p>Pri cukrovke sa prirodzene zameriavame na glykémiu. Je to správne, ale pri ochrane obličiek nestačí sledovať len hladinu cukru (myslíme tým glukózu, teda glykémiu).</p>
<p>Veľmi dôležitý je krvný tlak. Vysoký tlak poškodzuje obličkové cievy a zároveň urýchľuje stratu filtračnej funkcie. U mnohých pacientov s diabetickou chorobou obličiek je liečba vysokého krvného tlaku rovnako dôležitá ako liečba cukrovky.</p>
<p>Dôležité sú aj tuky v krvi, telesná hmotnosť, fajčenie, pohybová aktivita a celkové kardiovaskulárne riziko. Obličky, srdce a cievy úzko súvisia. Pacient s diabetickou chorobou obličiek nemá iba „obličkový problém“. Má vyššie riziko infarktu, srdcového zlyhávania, mozgových príhod a ďalších cievnych komplikácií.</p>
<figure class="article-figure">
  <a href="img/dkd-12.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-12.png" alt="Ilustrácia k téme: Cukor nie je jediný problém" loading="lazy" decoding="async">
  </a>
  <figcaption>Cukor nie je jediný problém</figcaption>
</figure>
<h2>Lieky, ktoré chránia obličky</h2>
<p>Liečba patrí vždy do rúk lekára, pretože závisí od typu cukrovky, veku, funkcie obličiek, tlaku, hladiny draslíka, pridružených ochorení a ďalších okolností. Napriek tomu je dobré, aby pacient rozumel základným princípom.</p>
<p>Pri zvýšenom krvnom tlaku a albuminúrii sa často používajú lieky zo skupiny ACE inhibítorov alebo blokátorov receptorov pre angiotenzín II. Tieto lieky nielen znižujú tlak, ale môžu znižovať aj únik bielkoviny do moču a chrániť obličkový filter.</p>
<p>V posledných rokoch sa veľa zmenilo vďaka liekom zo skupiny inhibítorov SGLT2. Pôvodne boli vyvíjané ako lieky na zníženie glykémie, ale ukázalo sa, že majú významný ochranný účinok na obličky a srdce u mnohých pacientov s diabetom 2. typu a chronickou chorobou obličiek. Ich použitie však závisí od konkrétnej situácie a funkcie obličiek.</p>
<p>U niektorých pacientov môže mať význam aj liečba zo skupiny agonistov GLP-1 receptorov, najmä pri potrebe ovplyvniť hmotnosť, glykémiu a kardiovaskulárne riziko.</p>
<p>Pacient by však nemal lieky svojvoľne vysadzovať ani nasadzovať. Pri ochorení obličiek je dôležité aj správne dávkovanie liekov. Niektoré lieky treba pri zníženej funkcii obličiek upraviť, niektorým sa treba vyhýbať.</p>
<figure class="article-figure">
  <a href="img/dkd-13.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-13.png" alt="Ilustrácia k téme: Lieky, ktoré chránia obličky" loading="lazy" decoding="async">
  </a>
  <figcaption>Lieky, ktoré chránia obličky</figcaption>
</figure>
<h2>Pozor na lieky proti bolesti</h2>
<p>Veľmi praktická rada sa týka voľnopredajných liekov proti bolesti. Niektoré protizápalové lieky zo skupiny nesteroidových antiflogistík môžu u citlivých pacientov zhoršiť funkciu obličiek, najmä pri dehydratácii, vyššom veku, srdcovom zlyhávaní, užívaní liekov na tlak alebo pri už existujúcej chronickej chorobe obličiek.</p>
<p>Neznamená to, že každý jedenkrát užitý liek automaticky poškodí obličky. Znamená to však, že pacient s cukrovkou a obličkovým rizikom by sa mal o bezpečnej liečbe bolesti poradiť s lekárom alebo lekárnikom.</p>
<figure class="article-figure">
  <a href="img/dkd-14.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-14.png" alt="Ilustrácia k téme: Pozor na lieky proti bolesti" loading="lazy" decoding="async">
  </a>
  <figcaption>Pozor na lieky proti bolesti</figcaption>
</figure>
<h2>Čo môže urobiť pacient</h2>
<p>Pacient nie je pasívny pozorovateľ výsledkov. Práve naopak. Pri diabetickej chorobe obličiek má každodenné správanie veľký význam.</p>
<p>Základné odporúčania sú jednoduché, ale účinné:</p>
<ul>
  <li>chodiť na pravidelné kontroly diabetológa a praktického lekára,</li>
  <li>aspoň raz ročne mať skontrolovaný kreatinín, eGFR a albumín v moči, podľa stavu aj častejšie,</li>
  <li>poznať svoj krvný tlak a riešiť jeho dlhodobé zvýšenie,</li>
  <li>nefajčiť,</li>
  <li>dodržiavať liečbu a nevysadzovať lieky bez dohody s lekárom,</li>
  <li>vyhýbať sa dehydratácii,</li>
  <li>informovať lekára o všetkých liekoch vrátane voľnopredajných prípravkov a doplnkov,</li>
  <li>udržiavať primeraný pohyb a hmotnosť podľa možností,</li>
  <li>pri infekcii, horúčke, vracaní alebo hnačke sa poradiť, ako bezpečne postupovať s liekmi.</li>
</ul>
<p>Nie je potrebné, aby sa pacient stal odborníkom na nefrológiu. Je však veľmi užitočné, ak rozumie svojim základným výsledkom a vie, prečo ich lekár sleduje.</p>
<figure class="article-figure">
  <a href="img/dkd-15.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-15.png" alt="Ilustrácia k téme: Čo môže urobiť pacient" loading="lazy" decoding="async">
  </a>
  <figcaption>Čo môže urobiť pacient</figcaption>
</figure>
<h2>Otázky pre lekára</h2>
<p>Na kontrole sa oplatí spýtať konkrétne:</p>
<ul>
  <li>Akú mám hodnotu eGFR a ako sa mení v čase?</li>
  <li>Mám v moči zvýšený albumín alebo bielkovinu?</li>
  <li>Je potrebné vyšetrenie nálezu v moči zopakovať?</li>
  <li>Aký krvný tlak je pre mňa cieľový?</li>
  <li>Sú moje lieky vhodné aj vzhľadom na funkciu obličiek?</li>
  <li>Užívam niečo, čo môže obličky zbytočne zaťažovať?</li>
  <li>Potrebujem nefrologické vyšetrenie?</li>
  <li>Ako často mám kontrolovať krv a moč?</li>
  <li>Čo mám robiť pri horúčke, vracaní, hnačke alebo dehydratácii?</li>
  <li>Môže kreatín alebo iný doplnok výživy ovplyvniť môj kreatinín a výpočet eGFR?</li>
</ul>
<p>Dobrá otázka nie je prejavom nedôvery. Je to súčasť spolupráce medzi pacientom a lekárom.</p>
<figure class="article-figure">
  <a href="img/dkd-16.jpeg" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-16.jpeg" alt="Ilustrácia k téme: Otázky pre lekára" loading="lazy" decoding="async">
  </a>
  <figcaption>Otázky pre lekára</figcaption>
</figure>
<h2>Kedy myslieť na nefrológa</h2>
<p>Nefrológ je lekár – špecialista na obličky. Pacient s diabetom nemusí byť od začiatku automaticky sledovaný nefrológom. Sú však situácie, keď je nefrologické vyšetrenie vhodné alebo potrebné.</p>
<p>Patrí sem najmä:</p>
<ul>
  <li>trvalo znížená eGFR pod 60 ml/min/1,73 m²,</li>
  <li>rýchly pokles eGFR,</li>
  <li>výraznejšia alebo narastajúca albuminúria,</li>
  <li>krv v moči alebo netypický močový nález,</li>
  <li>ťažko liečiteľný vysoký krvný tlak,</li>
  <li>podozrenie na iné ochorenie obličiek,</li>
  <li>poruchy hladiny draslíka, minerálov alebo vnútorného prostredia,</li>
  <li>príprava na pokročilejšie štádiá chronickej choroby obličiek.</li>
</ul>
<p>Včasná spolupráca diabetológa, praktického lekára, nefrológa a pacienta môže zásadne zlepšiť výsledok liečby.</p>
<figure class="article-figure">
  <a href="img/dkd-17.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-17.png" alt="Ilustrácia k téme: Kedy myslieť na nefrológa" loading="lazy" decoding="async">
  </a>
  <figcaption>Kedy myslieť na nefrológa</figcaption>
</figure>
<h2>Najčastejší omyl: „Kreatinín mám v norme, obličky sú v poriadku“</h2>
<p>Toto je časté nedorozumenie. Normálny kreatinín je dobrá správa, ale nemusí stačiť. Pri cukrovke potrebujeme poznať aj eGFR a albumín v moči. Práve albuminúria môže byť prvým signálom, že obličkový filter je pod tlakom, hoci kreatinín ešte vyzerá dobre.</p>
<p>Druhý častý omyl je opačný: „Keď mám bielkovinu v moči, určite skončím na dialýze.“ Ani to nie je pravda. Albumín v moči je varovný signál, nie rozsudok. Je to dôvod konať, upraviť liečbu, tlak, glykémiu a rizikové faktory.</p>
<figure class="article-figure">
  <a href="img/dkd-18.png" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-18.png" alt="Ilustrácia k téme: Najčastejší omyl: „Kreatinín mám v norme, obličky sú v poriadku“" loading="lazy" decoding="async">
  </a>
  <figcaption>Najčastejší omyl: „Kreatinín mám v norme, obličky sú v poriadku“</figcaption>
</figure>
<h2>Záver: obličky treba chrániť skôr, než sa ozvú</h2>
<p>Diabetická choroba obličiek je vážna komplikácia cukrovky, ale nie je to záhada ani nevyhnutný osud. Dnes vieme, čo máme sledovať: kreatinín, eGFR, albumín v moči, krvný tlak a celkové riziko pacienta.</p>
<p>Najdôležitejšie je nečakať na príznaky. Obličky môžu byť dlho tiché. Pravidelné kontroly krvi a moču sú preto jednoduchým, ale veľmi účinným spôsobom, ako problém zachytiť včas.</p>
<p>Ak pacient rozumie svojim výsledkom a spolupracuje s lekárom, má oveľa väčšiu šancu udržať si obličky čo najdlhšie funkčné.</p>
<figure class="article-figure">
  <a href="img/dkd-19.jpeg" target="_blank" rel="noopener noreferrer">
    <img src="img/dkd-19.jpeg" alt="Ilustrácia k téme: Záver: obličky treba chrániť skôr, než sa ozvú" loading="lazy" decoding="async">
  </a>
  <figcaption>Záver: obličky treba chrániť skôr, než sa ozvú</figcaption>
</figure>
<h2>Použité a odporúčané zdroje</h2>
<h3>Slovensko</h3>
<ul>
  <li>Slovenská diabetologická spoločnosť. Odborné informácie a odporúčania v diabetológii. <a href="https://www.diaslovakia.sk" target="_blank" rel="noopener noreferrer">https://www.diaslovakia.sk</a></li>
  <li>Slovenská nefrologická spoločnosť. Odborné informácie z oblasti nefrológie. <a href="https://www.nefro.sk/" target="_blank" rel="noopener noreferrer">https://www.nefro.sk/</a></li>
  <li>Národné centrum zdravotníckych informácií. Zdravotnícke štatistiky a informácie o chronických ochoreniach. <a href="https://www.nczisk.sk" target="_blank" rel="noopener noreferrer">https://www.nczisk.sk</a></li>
  <li>Ministerstvo zdravotníctva Slovenskej republiky. Štandardné diagnostické a terapeutické postupy. <a href="https://www.health.gov.sk" target="_blank" rel="noopener noreferrer">https://www.health.gov.sk</a></li>
</ul>
<h3>Česko</h3>
<ul>
  <li>Česká diabetologická společnost ČLS JEP. Doporučené postupy a odborné informace v diabetologii. <a href="https://www.diab.cz" target="_blank" rel="noopener noreferrer">https://www.diab.cz</a></li>
  <li>Česká nefrologická společnost. Odborné informace a doporučení v nefrologii. <a href="https://www.nefrol.cz" target="_blank" rel="noopener noreferrer">https://www.nefrol.cz</a></li>
  <li>Národní zdravotnický informační portál. Informácie pre pacientov a verejnosť. <a href="https://www.nzip.cz" target="_blank" rel="noopener noreferrer">https://www.nzip.cz</a></li>
  <li>Státní zdravotní ústav. Informácie o prevencii a chronických ochoreniach. <a href="https://www.szu.cz" target="_blank" rel="noopener noreferrer">https://www.szu.cz</a></li>
</ul>
<h3>Medzinárodné odborné zdroje</h3>
<ul>
  <li>KDIGO. Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease. <a href="https://kdigo.org/guidelines/diabetes-ckd/" target="_blank" rel="noopener noreferrer">https://kdigo.org/guidelines/diabetes-ckd/</a></li>
  <li>KDIGO. Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">https://kdigo.org/guidelines/ckd-evaluation-and-management/</a></li>
  <li>American Diabetes Association. Standards of Care in Diabetes. <a href="https://diabetesjournals.org/care/issue" target="_blank" rel="noopener noreferrer">https://diabetesjournals.org/care/issue</a></li>
</ul>
<hr>
<p><em>Autor je nefrológ a internista s dlhoročnou praxou v dialyzačnej liečbe, klinickej a preventívnej nefrológii a v riadení dialyzačných stredísk.</em></p>
NEFRO_HTML,
];

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, category, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, 'popularne', :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt),
        category = 'popularne', is_top = VALUES(is_top)"
);

$inserted = 0; $updated = 0; $skipped = 0; $errors = []; $queuedTotal = 0;
foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title' => $a['title'], 'slug' => $a['slug'], 'author' => $a['author'],
            'content' => $a['content'], 'excerpt' => $a['excerpt'],
            'published_at' => $a['published_at'], 'is_top' => $a['is_top'],
        ]);
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try { $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId); }
            catch (\Throwable $qe) { error_log('add_article newsletter enqueue error: ' . $qe->getMessage()); }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

if (php_sapi_name() === 'cli') {
    echo "\nVložené: $inserted | Aktualizované: $updated | Preskočené (bez zmeny): $skipped | Avíza: $queuedTotal\n";
    foreach ($errors as $e) { echo "  - $e\n"; }
} else {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Vložené: $inserted | Aktualizované: $updated | Preskočené: $skipped | Avíza: $queuedTotal\n";
    foreach ($errors as $e) { echo "  - $e\n"; }
}
