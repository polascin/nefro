<?php

/**
 * add_retatrutid-sivy-trh-chudnutie-kardiovaskularne-symptomy_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: observačná RWE analýza nference o produktoch označených
 * ako retatrutid mimo klinických skúšaní (sivý trh / gray market) —
 * slabší úbytok hmotnosti, vzostup srdcovej frekvencie a vyššia záťaž
 * kardiovaskulárnych symptómov. Preprint Preprints.org, doi
 * 10.20944/preprints202608.1193.v1. Autor projektu: MUDr. Ľubomír Polaščín.
 * Pôvodní autori zdroja sú v source_authors.php.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_retatrutid-sivy-trh-chudnutie-kardiovaskularne-symptomy_article.php"
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => '„Sivý trh“ s retatrutidom: polovičný úbytok hmotnosti a viac kardiovaskulárnych symptómov? Klinická interpretácia signálu z reálnej praxe a implikácie pre nefrológa',
    'slug'         => 'retatrutid-sivy-trh-chudnutie-kardiovaskularne-symptomy',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Analýza EHR spája sivý trh s retatrutidom s približne polovičným úbytkom hmotnosti oproti ramenu skúšania a s vyššou záťažou kardiovaskulárnych symptómov. MACE ostáva nepresný; ide o predbežný signál, nie o dôkaz kauzality.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Retatrutid je skúšaný trojitý agonista receptorov pre GIP, GLP-1 a glukagón. V USA ho pacienti získavajú aj mimo klinických skúšaní. Observačná analýza elektronických zdravotných záznamov (EHR) od nference spája tieto produkty s približne polovičným úbytkom hmotnosti oproti ramenu skúšania, s prechodným vzostupom srdcovej frekvencie a s vyššou záťažou kardiovaskulárnych aj neuropsychiatrických symptómov. Závažné kardiovaskulárne príhody (MACE) sú pri malých počtoch nepresné a štatisticky nevýznamné. Ide o preprint a predbežný farmakovigilančný signál, nie o dôkaz kauzality. Tento text použitie neschválených peptidov neodporúča.</em></p>

<p>Téma sa <strong>líši</strong> od dvoch súvisiacich článkov na tomto webe. Článok o <a href="article.php?slug=retatrutid-mimo-schvalenia-neregulovane-pouzivanie">neregulovanom používaní</a> opisuje trh, identitu produktu a etiku rozhovoru s pacientom. Článok o <a href="article.php?slug=retatrutid-expanded-access-lekar-pacient-bariery">expanded access</a> opisuje úzku, ale legálnu cestu k autentickému skúšanému lieku v USA. Tu ide o <strong>klinický signál z reálnych dát</strong>: čo sa v poznámkach lekárov spája s produktmi, o ktorých pacienti hovoria ako o retatrutide, keď ich nezískali v skúšaní.</p>

<h2>Čo retatrutid je – a čo „sivý trh“ nie je</h2>

<p><strong>Retatrutid</strong> (LY3437943) je <strong>skúšaný</strong> raz týždenne podávaný trojitý agonista. V čase písania tohto textu ho neschválila FDA ani EMA na nijakú indikáciu. Vo fáze 3 program TRIUMPH hlásil v preprinte priemerný úbytok hmotnosti až 28,3 %; to je kontext účinnosti autentického lieku v kontrolovanom skúšaní, nie dôvod predpisovať neschválený peptid.</p>

<p>Anglický termín <em>gray market</em> v tomto článku prekladáme ako <strong>„sivý trh“</strong>. Označuje produkty, ktoré sa vydávajú za retatrutid, ale nie sú schváleným liekom a nie sú súčasťou riadne vedeného klinického skúšania. V americkej analýze ide najmä o nákup cez internet a telehealth, o lekárenské miešanie (<em>compounding</em>) a o wellness kliniky. <strong>Nie je to to isté</strong> ako individuálna príprava schváleného lieku v lekárenstve počas deficitu a <strong>nie je to to isté</strong> ako expanded access k autentickému retatrutidu od výrobcu.</p>

<p>Americký Úrad pre kontrolu potravín a liečiv (FDA) výslovne uvádza, že retatrutid <strong>nemožno v USA používať na compounding</strong>, pretože nie je zložkou schváleného lieku a nebolo preukázané, že je bezpečný a účinný pri akejkoľvek indikácii. Úrad tiež varoval pred predajom neschválených peptidov označených ako „výskumné“ alebo „nie na ľudské použitie“, ktoré sa predávajú spotrebiteľom s dávkovacími pokynmi. Právny režim sa medzi krajinami líši; medicínske jadro je rovnaké: <strong>názov na etikete nedokazuje identitu, čistotu ani dávku</strong>.</p>

<h2>Prečo EHR a jazykový model: chýba kód NDC</h2>

<p>Retatrutid ako neschválený produkt nemá národný kód lieku (NDC), lekárenský nárok ani štruktúrovaný predpis. Expozícia existuje takmer výlučne vo voľnom texte klinických poznámok: či pacient látku naozaj užíval, odkiaľ ju získal a kedy začal. Murugadoss, Venkatakrishnan a Soundararajan preto v federovanej americkej sieti EHR s približne 29 miliónmi pacientov nechali veľký jazykový model posúdiť celú históriu poznámok u každého, u koho sa retatrutid spomenul. Klinický recenzent následne ručne overil 320 náhodne vybraných extrakcií: klasifikácia expozície mala prevalenčne váženú presnosť 99,8 % a cesta dodávky 90,3 %.</p>

<p>Indexový dátum je najskoršia poznámka s potvrdenou expozíciou, prípadne explicitný dátum začiatku, ak ho záznam uvádza (214 z 652 potvrdených užívateľov, 32,8 %). Dizajn je <strong>observačný</strong> a <strong>nedokazuje príčinnú súvislosť</strong>. Nevie overiť zloženie, čistotu, dávku ani adherenciu. Autori ho označujú za predbežný farmakovigilančný signál, nie za dôkaz kardiovaskulárneho rizika.</p>

<h2>Kohorty: kto, odkiaľ a ako dlho</h2>

<p>Retatrutid sa spomenul u 983 pacientov. Potvrdená expozícia bola u 652 (66,3 %). Cesta dodávky bola známa u 531 z nich (81,4 % potvrdených užívateľov; 54 % všetkých zmienok). Z týchto 531 osôb 378 (71,2 %) získalo produkt mimo skúšania, 89 (16,8 %) ako zaslepení účastníci skúšania (retatrutid alebo placebo) a 64 (12,1 %) inou cestou. Medzi 378 užívateľmi mimo skúšania prevládali internet a telehealth (217; 57,4 %), miešacie lekárne (111; 29,4 %) a wellness, medical-spa alebo redukčné kliniky (33; 8,7 %). Iniciácia rástla 1,80-násobne za štvrťrok od októbra 2023 do marca 2026.</p>

<p>V poznámkach sa vyskytovali aj kopreparáty s kagrilintidom, vysokodávkovým tirzepatidom, neschválenými peptidmi BPC-157 a AOD-9604, NAD+ a analógmi IGF-1, ako aj vymyslené označenia „GLP-3“ a „triple-G“, ktoré nemajú zavedený farmakologický význam. Žiadna z týchto kombinácií nie je ekvivalentom retatrutidu z klinického skúšania.</p>

<p>Analytické ramená vznikli najbližším susedným párovaním 1 : 3 : 10 : 10 podľa veku, pohlavia, rasy, BMI, diabetu 2. typu, predchádzajúcej expozície semaglutidu alebo tirzepatidu a dní od poslednej takej expozície. Komparátori boli perzistentní iniciátori semaglutidu a tirzepatidu v roku 2025.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Zložené a spárované kohorty analýzy nference" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Rameno</th>
        <th scope="col">n</th>
        <th scope="col">Vek (roky)</th>
        <th scope="col">Ženy</th>
        <th scope="col">BMI (kg/m²)</th>
        <th scope="col">Predchádzajúci inkretín</th>
        <th scope="col">Sledovanie, medián [IQR] (dni)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Retatrutid, skúšanie</th>
        <td>89</td>
        <td>51,2</td>
        <td>64,0 %</td>
        <td>33,0</td>
        <td>37,1 %</td>
        <td>125 [57–390]</td>
      </tr>
      <tr>
        <th scope="row">Retatrutid, sivý trh</th>
        <td>243</td>
        <td>49,0</td>
        <td>62,6 %</td>
        <td>32,2</td>
        <td>36,6 %</td>
        <td>130 [78–200]</td>
      </tr>
      <tr>
        <th scope="row">Semaglutid</th>
        <td>890</td>
        <td>51,5</td>
        <td>64,6 %</td>
        <td>33,7</td>
        <td>36,2 %</td>
        <td>270 [165–360]</td>
      </tr>
      <tr>
        <th scope="row">Tirzepatid</th>
        <td>890</td>
        <td>51,4</td>
        <td>64,8 %</td>
        <td>33,5</td>
        <td>37,1 %</td>
        <td>255 [165–355]</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Sledovanie je kratšie a nerovnomerné: v diskusii autori uvádzajú medián približne 3 mesiace v ramenách retatrutidu oproti približne 6 mesiacom u komparátorov. V tabuľke 1 preprintu je medián sledovania 125 a 130 dní pri retatrutide oproti 270 a 255 dňom pri semaglutide a tirzepatide. Medián trvania liečby podľa zmienok v poznámkach bol 83 dní v ramene skúšania a 56 dní na sivom trhu. Diabetes 2. typu aj chronická choroba obličiek (CKD) mali v retatrutidových ramenách nízke počty (CKD pod prahom zverejnenia &lt; 11), preto z tejto práce <strong>nemožno vyvodiť špecifické závery pre CKD</strong>.</p>

<h2>Úbytok hmotnosti: rameno skúšania versus sivý trh</h2>

<p>Rameno skúšania v bežnej starostlivosti stratilo v okne 6–12 mesiacov v priemere <strong>15,5 %</strong> hmotnosti. To sa blíži váženému priemeru 16,9 % v programoch TRIUMPH-1 až TRIUMPH-4 v 80. týždni, ktorý zahŕňa aj placebo. Toto rameno ostalo zaslepené a obsahuje aj príjemcov placeba, takže 15,5 % <strong>podhodnocuje</strong> účinok aktívneho lieku. Užívatelia produktov zo sivého trhu stratili v tom istom okne <strong>7,2 %</strong> (P = 0,004 oproti ramenu skúšania), čo je porovnateľné s 7,7 % pri spárovanom tirzepatide (P = 0,79) a 4,6 % pri semaglutide (P = 0,13).</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Priemerný percentuálny úbytok hmotnosti v spárovaných ramenách" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Rameno</th>
        <th scope="col">3 mesiace</th>
        <th scope="col">6 mesiacov</th>
        <th scope="col">6–12 mesiacov</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Retatrutid, skúšanie</th>
        <td>5,7 %</td>
        <td>11,9 %</td>
        <td>15,5 %</td>
      </tr>
      <tr>
        <th scope="row">Retatrutid, sivý trh</th>
        <td>4,7 %</td>
        <td>5,3 %</td>
        <td>7,2 %</td>
      </tr>
      <tr>
        <th scope="row">Tirzepatid (spárovaný)</th>
        <td>—</td>
        <td>—</td>
        <td>7,7 %</td>
      </tr>
      <tr>
        <th scope="row">Semaglutid (spárovaný)</th>
        <td>—</td>
        <td>—</td>
        <td>4,6 %</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Autori sami upozorňujú, že indexový dátum na sivom trhu často prichádza až po skutočnom začiatku, takže najstrmšia fáza úbytku môže uniknúť a rozdiel oproti skúšaniu sa môže nadhodnotiť. Aj po zohľadnení predindexového poklesu hmotnosti však rameno sivého trhu ostalo za ramenom skúšania. Mechanizmus atenuácie z týchto dát nevyplýva: môže ísť o inú látku, inú koncentráciu, prerušovanú liečbu, kopreparáty, kratšiu expozíciu alebo o iný výber pacientov.</p>

<h2>Srdcová frekvencia: farmakodynamický odtlačok</h2>

<p>V 3. mesiaci stúpla srdcová frekvencia o <strong>+4,3 úderu/min</strong> v ramene skúšania (P = 0,028; párové meranie u 25 osôb) a o <strong>+2,5 úderu/min</strong> na sivom trhu (P = 0,011; n = 60). Pri semaglutide a tirzepatide sa významná zmena nepozorovala (0,0 a +0,1 úderu/min; P &gt; 0,9). Vzostup bol prechodný: v 6. mesiaci boli hodnoty opäť pri východiskovej hodnote (−2,0 a −1,5 úderu/min). Krvný tlak sa v retatrutidových ramenách významne nezmenil; pri schválených komparátoroch mierne klesol.</p>

<p>Chronotropný účinok je známy z fázy 2 a z metaanalýz agonistov GLP-1 (priamy vplyv na sínusový uzol). To, že sa objavil aj pri produktoch zo sivého trhu, podporuje hypotézu, že aspoň časť expozície je biologicky aktívna – <strong>nie však, že ide o overený retatrutid v deklarovanej dávke</strong>. Párový počet v ramene skúšania je malý; odhad +4,3 úderu/min treba čítať s touto rezervou.</p>

<h2>MACE: kardiovaskulárne, nie „koronárne“ príhody – a široké intervaly</h2>

<p>Spravodajské spracovanie Medscape označilo 3-bodový ukazovateľ ako <em>major adverse coronary events</em> („závažné koronárne príhody“). To je <strong>terminologicky nesprávne</strong>. V kardiovaskulárnej epidemiológii MACE znamená <strong>závažné kardiovaskulárne príhody</strong> (<em>major adverse cardiovascular events</em>). V metódach preprintu sú dva vopred určené zložené ukazovatele zo štruktúrovaných kódov:</p>

<ul>
  <li><strong>3-bodový MACE:</strong> infarkt myokardu, cievna mozgová príhoda alebo <strong>kardiovaskulárne úmrtie</strong>;</li>
  <li><strong>rozšírený MACE:</strong> totéž plus srdcové zlyhávanie.</li>
</ul>

<p>Popis obrázka 6 v tom istom preprinte však pri 3-bodovom MACE uvádza namiesto kardiovaskulárneho úmrtia <strong>úmrtie z akejkoľvek príčiny</strong>. Ide o vnútorný nesúlad rukopisu; v tomto článku preto uvádzame obe formulácie a RR čítame ako <strong>nepresné intervalové odhady</strong>, nie ako dôkaz rizika. Počty udalostí v retatrutidových ramenách klesli pod prah zverejnenia (&lt; 11). Autori odhadujú približne 290 osoborokov retatrutidu.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Pomer rizík MACE v ramene skúšania retatrutidu oproti schváleným komparátorom" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ (rameno skúšania)</th>
        <th scope="col">Oproti tirzepatidu</th>
        <th scope="col">Oproti semaglutidu</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">3-bodový MACE</th>
        <td>RR 1,77 (95 % CI 0,19–7,94); P = 0,34</td>
        <td>RR 1,02 (95 % CI 0,12–4,17); P = 1,00</td>
      </tr>
      <tr>
        <th scope="row">Rozšírený MACE</th>
        <td>RR 2,03 (95 % CI 0,38–7,09); P = 0,21</td>
        <td>RR 1,25 (95 % CI 0,24–4,07); P = 0,73</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Tieto RR sa týkajú <strong>ramena skúšania</strong> (zaslepený retatrutid alebo placebo), nie sivého trhu. Incidencia 3-bodového MACE bola 2,13 na 100 osoborokov v ramene skúšania oproti 2,09 pri semaglutide a 1,20 pri tirzepatide. Rameno sivého trhu smerovalo <strong>opačným</strong> smerom (RR v rozpätí 0,24–0,94 podľa zloženého ukazovateľa a komparátora). Zlúčený 3-bodový MACE mal RR 0,50 (0,09–1,66) oproti semaglutidu. Každý interval prechádza jednotkou so širokým okrajom. <strong>Z týchto dát nemožno tvrdiť, že sivý trh zvyšuje MACE</strong>, ani to vylúčiť.</p>

<h2>Nové symptómy: silnejší signál ako MACE</h2>

<p>Zlúčená kohorta retatrutidu (skúšanie aj sivý trh) mala vyššiu incidenciu novo zachytených symptómov v 12 z 16 klinických kategórií po korekcii Benjaminiho–Hochberga, a to oproti semaglutidu aj tirzepatidu. Negatívna kontrola (108 nálezov bez prijateľnej väzby na inkretín, napríklad divertikulóza, cysty, névy) bola voči semaglutidu nulová (RR 1,03; 95 % CI 0,63–1,63; P = 0,91).</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Pomery rizík novo vzniknutých symptómov v zlúčenej kohorte retatrutidu" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Kategória</th>
        <th scope="col">Oproti semaglutidu</th>
        <th scope="col">Oproti tirzepatidu</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Kardiovaskulárne symptómy</th>
        <td>RR 1,56 (1,26–1,92); q &lt; 0,001</td>
        <td>RR 1,85 (1,49–2,28); q &lt; 0,001</td>
      </tr>
      <tr>
        <th scope="row">Neuropsychiatrické symptómy</th>
        <td>RR 1,95 (1,61–2,36); q &lt; 0,001</td>
        <td>RR 2,22 (1,82–2,68); q &lt; 0,001</td>
      </tr>
      <tr>
        <th scope="row">Tachykardia (jednotlivý symptóm)</th>
        <td>RR 1,90 (1,13–3,09); P = 0,010</td>
        <td>RR 2,88 (1,68–4,85); P &lt; 0,001</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Kardiovaskulárna kategória v preprinte zahŕňa krvný tlak, tachykardiu, bolesť na hrudníku a príbuzné ťažkosti. Čísla RR 1,56 a 1,95, ktoré sa objavili v spravodajských textoch bez bližšieho určenia komparátora, zodpovedajú <strong>porovnaniu so semaglutidom</strong>. Oproti tirzepatidu sú odhady ešte vyššie. Medzi ramenom skúšania a sivým trhom sa po korekcii líšil prakticky len zaznamenaný pokles chuti do jedla (častejší v skúšaní). Skreslenie intenzitou dokumentácie nemožno vylúčiť: užívatelia retatrutidu mali približne 1,5-násobnú hustotu poznámok a úprava na objem dokumentácie sa nerobila. Negatívna kontrola ohraničuje všeobecnú zložku tohto skreslenia, nie cielené vypytovanie na srdce a náladu.</p>

<h2>Čo z toho na Slovensku a v EÚ vyplýva – a čo nie</h2>

<p>Analýza je americká. Na Slovensku nie je retatrutid registrovaný. Štátny ústav pre kontrolu liečiv (ŠÚKL) vo verejných upozorneniach opakuje, že internetový výdaj smie ponúkať len lieky registrované v SR, ktorých výdaj nie je viazaný na lekársky predpis, a že nákup z neoverených zdrojov nesie riziko falšovaného alebo nekvalitného produktu. ŠÚKL v otvorených zdrojoch, ktoré sme overili, <strong>nevydal osobitné stanovisko práve k retatrutidu</strong>; ide o všeobecný rámec pre neregistrované a internetové lieky. „Výskumný peptid“ predávaný na ľudské chudnutie nie je schválenou liečbou ani v EÚ.</p>

<p>Lekárenské miešanie v USA počas deficitu semaglutidu a tirzepatidu (ktoré FDA medzičasom ukončila ako právny základ hromadného compoundingu) sa <strong>nesmie zamieňať</strong> s nelegálnym predajom neskúšaných peptidov. Pri retatrutide FDA compounding zakazuje. Expanded access k autentickému lieku od výrobcu je tretia, právne aj medicínsky odlišná cesta – a na Slovensku sa 1 : 1 nepremieta.</p>

<h2>Implikácie pre nefrológa</h2>

<p>Pacient s obezitou, diabetom 2. typu, hypertenziou a CKD patrí k skupinám s vysokým kardiovaskulárnym rizikom. Práve u neho môže byť lákavý sľub „silnejšieho“ inkretínu. Táto práca <strong>nedáva podklad na dávkovanie</strong> neschváleného retatrutidu a také dávkovanie lekár nemá určovať. Má však dôvod pýtať sa na neschválené peptidy, lebo bez otázky expozícia v štruktúrovanom liekovom zozname chýba.</p>

<p>Praktický postup, ktorý z dát vyplýva bez toho, aby sa legitimizoval sivý trh:</p>

<ol>
  <li><strong>Opýtať sa priamo</strong> na neschválené peptidy, „výskumné“ injekcie, telehealth a kopreparáty. Otázka nie je súhlas s liečbou.</li>
  <li><strong>Neupravovať dávku</strong> neschváleného produktu a nevytvárať dojem, že ide o ekvivalent skúšaného lieku.</li>
  <li><strong>Odporučiť ukončenie</strong> používania neovereného produktu a ponúknuť schválenú liečbu obezity alebo diabetu, ak je indikovaná.</li>
  <li>Ak pacient užívanie prizná, <strong>sledovať srdcovú frekvenciu a symptómy</strong> (palpitácie, bolesť na hrudníku, výrazné zmeny krvného tlaku) a zhodnotiť hydratáciu, diurézu, glykémiu a súbežnú liečbu (diuretiká, RAAS, SGLT2, inzulín). To je znižovanie rizika, nie titrácia sivého trhu.</li>
  <li>Hlásiť podozrenie na nežiaduci účinok ŠÚKL-u, ak ide o liek alebo produkt použitý ako liek. Identitu internetového prípravku však z etikety spoľahlivo neodvodíme.</li>
</ol>

<p>Vzostup srdcovej frekvencie a vyššia záťaž kardiovaskulárnych symptómov sú pri CKD klinicky relevantné aj vtedy, keď MACE ostáva štatisticky nemý. Nefrológ zároveň nesmie z RR 1,77 urobiť záver, že „sivý trh spôsobuje infarkty“: toto číslo patrí ramenu skúšania, interval je široký a rameno sivého trhu smerovalo opačne.</p>

<h2>Záver</h2>

<p>Predbežná observačná analýza spája urýchľujúce sa používanie produktov označených ako retatrutid mimo skúšaní s približne polovičným úbytkom hmotnosti oproti ramenu skúšania, s prechodným vzostupom srdcovej frekvencie a s vyššou záťažou kardiovaskulárnych aj neuropsychiatrických symptómov. MACE je pri malých počtoch neinformatívny. Zloženie, čistota a dávka ostávajú neznáme. Preprint nie je recenzovaný. Správnou klinickou odpoveďou nie je predpísať neschválený peptid, ale pýtať sa naň, neodporučiť ho, ponúknuť schválenú alternatívu a pri priznanom užívaní sledovať srdcovú frekvenciu, objemový stav a symptómy – najmä u pacienta s CKD a vysokým kardiovaskulárnym rizikom.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Murugadoss K, Venkatakrishnan AJ, Soundararajan V. Accelerating Use of Unapproved Retatrutide Is Associated with Weaker Weight Loss and Increased Cardiovascular Symptoms. Preprint, Preprints.org, 18. augusta 2026. doi: <a href="https://doi.org/10.20944/preprints202608.1193.v1" target="_blank" rel="noopener noreferrer">10.20944/preprints202608.1193.v1</a>. Autori overení v PDF preprintu, na stránke nference a v Crossref (3 mená). <a href="https://www.preprints.org/manuscript/202608.1193" target="_blank" rel="noopener noreferrer">Preprints.org</a>; <a href="https://nference.com/publications/ao2bRhEAAC4AL_MI/Accelerating-Use-of-Unapproved-Retatrutide-Is-Associated-with-Weaker-Weight-Loss-and-Increased-Cardiovascular" target="_blank" rel="noopener noreferrer">nference</a>.</em></p>

<p><em><strong>Ďalšie zdroje:</strong> Larkin M. Gray-Market Retatrutide: Less Weight Loss, More CV Effects. <em>Medscape Medical News</em>. 2026. Sekundárne spravodajské spracovanie (paywall nebol obchádzaný). <a href="https://www.medscape.com/viewarticle/gray-market-retatrutide-less-weight-loss-more-cv-effects-2026a1000tpl" target="_blank" rel="noopener noreferrer">medscape.com</a>. Cairns E. Using gray-market versions of Lilly’s triple-G leads to relatively poor weight loss, study finds. <em>Endpoints News</em>. 20. augusta 2026. Verejne dostupný je titul a perex; plný text je za prihlásením, paywall nebol obchádzaný. <a href="https://endpoints.news/using-gray-market-versions-of-lillys-triple-g-leads-to-relatively-poor-weight-loss-study-finds/" target="_blank" rel="noopener noreferrer">endpoints.news</a>. U.S. Food and Drug Administration. FDA’s Concerns with Unapproved GLP-1 Drugs Used for Weight Loss. <a href="https://www.fda.gov/drugs/postmarket-drug-safety-information-patients-and-providers/fdas-concerns-unapproved-glp-1-drugs-used-weight-loss" target="_blank" rel="noopener noreferrer">fda.gov</a>. ŠÚKL. Upozornenie na internetový predaj liekov neznámeho pôvodu. <a href="https://www.sukl.sk/hlavna-stranka/slovenska-verzia/media/tlacove-spravy/sukl-upozornuje-na-internetovy-predaj-liekov-neznameho-povodu?page_id=4480" target="_blank" rel="noopener noreferrer">sukl.sk</a>.</em></p>

<p><em><strong>Súvisiace články:</strong> <a href="article.php?slug=retatrutid-mimo-schvalenia-neregulovane-pouzivanie">Retatrutid mimo schválenia: keď experimentálny liek predbehne reguláciu</a>; <a href="article.php?slug=retatrutid-expanded-access-lekar-pacient-bariery">Retatrutid a expanded access: bariéry procesu a význam pre nefrológiu</a>; <a href="article.php?slug=retatrutid-ubytok-hmotnosti-metabolicke-benefity">Retatrutid a úbytok hmotnosti v klinických skúšaniach</a>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_retatrutid-sivy-trh-chudnutie-kardiovaskularne-symptomy_article',
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
