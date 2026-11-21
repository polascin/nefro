# Správa o publikovaní predbežných výsledkov TRANSCEND-T2D-2

Dátum: 2026-11-21, Europe/Bratislava.

Článok: https://nefro.polascin.net/article.php?slug=retatrutid-semaglutid-predbezne-vysledky-transcend-t2d-2
Databázový záznam: 2610. Zdrojový commit: e75be106. PDF commit: f251246a.

## Rozsah a dôkazy

Používateľ po pôvodnom pozastavení výslovne zmenil zadanie: spracovať oznámenie výrobcu ako správu o predbežných výsledkoch, uviesť obmedzenia, vynechať sporný údaj o dyzestézii a publikovať článok aj sociálne siete. Pôvodný audit v editorial/research zachytáva stav pred touto zmenou zadania.

Celý verejný prepis Medscape bol načítaný priamym HTTP GET. Tlačová správa Lilly bola prečítaná vrátane tabuľky, štatistických poznámok a definície estimandu cez webový nástroj. Priamy prístup k tlačovej správe vracal 403 alebo timeout. Register NCT06260722 overený priamym API, hasResults=false. Overené kritérium eGFR pod 45 ml/min/1,73 m². FLOW: úplný abstrakt a všetci bibliografickí autori vrátane skupinového autorstva z NCBI EFetch XML. Plné texty výsledkov TRANSCEND-T2D-2 a suplement neboli dostupné. Nepredstiera sa ich kontrola.

Čísla v článku sú výslovne pripísané výrobcovi. Kontrola rozlíšila percentá a percentuálne body, nominálnu významnosť a kontrolu viacnásobného testovania, hypotetický efficacy estimand a jednoduchú analýzu účastníkov, ktorí dokončili liečbu. Pokles hmotnosti nie je prezentovaný ako dôkaz nefroprotekcie. Sporný údaj o dyzestézii je úplne vynechaný. Vykonaná odborná, bibliografická a slovenská redakcia, následne kontrola zachovania významu. Bez dlhých pomlčiek a textGrain.

Odkazy: Medscape HTTP 200, ClinicalTrials.gov HTTP 200, PubMed HTTP 203. DOI a NEJM HTTP 403, ochrana proti automatizovanému prístupu, nie potvrdené mŕtve odkazy. Bibliografická identita FLOW bola overená cez EFetch. Tlačová správa dostupná cez webový nástroj, priamy HTTP prístup obmedzený. Záznam konkrétnych HTTP kontrol je v editorial/research/2026-11-21-retatrutide-semaglutide/http-links.json.

## Produkcia a PDF

Lokálna brána: 793 PHP súborov bez syntaktickej chyby, 64 regresných súborov PASS, JavaScript syntax v poriadku. PHPStan nového publikačného súboru bez chyby. Sken tajomstiev prešiel. Žiadne nasadenie cez GitHub Actions. Použitý miestny deploy hook cez SSH alias websupport.

Pred vložením bol slug v DB voľný. Prvé spustenie: inserted=1, queued=0, errors=[]. Opakovanie: skipped=1, inserted=0, updated=0, queued=0. Databázové overenie oboch front article_newsletter_queue aj nl_sub_queue pre článok 2610: 0. Žiadny newsletter ani avízo sa neodosielali.

Verejný článok aj domovská stránka HTTP 200. Domovská stránka obsahuje nový slug. Verejné telo obsahuje tabuľku a správnu ilustráciu, sporný údaj chýba.

PDF: 3 strany, 170110 bajtov. Vytvorené na produkcii, stiahnuté cielene cez scp -O s aliasom websupport. Text vrátane všetkých štyroch zdrojov extrahovaný a skontrolovaný, prvá strana vizuálne skontrolovaná. Priame porovnanie SHA-256 lokálnej a produkčnej kópie: 5592fd9feb090af033df350e529f65ef4ae24d6dad6c9eb7534ef91d5f969f5d. Hromadný synchronizačný skript sa nepoužil, aby sa nemiešali cudzie PDF a nepoužil jeho pevne zadaný SSH cieľ. Cielené stiahnutie zachovalo rovnaký výsledok pre tento článok.

Produkčný marker aj obe vzdialené main sa po PDF commite zhodovali s f251246a. Nasledujúci commit môže obsahovať len tento dôkazový záznam a snímky.

## Ilustrácie a sociálne siete

Dve generované ilustrácie, oba výsledné súbory 1600 × 1000. Prvý motív: symbolické tri receptorové dráhy v bunkovej membráne. Druhý: abstraktná peptidová slučka s tromi svetelnými bodmi. Ilustrácie nepredstierajú skutočnú molekulovú štruktúru ani klinický účinok. PNG bez textu podľa výslovného zadania, webová verzia vo WebP. Oba PNG skopírované do G:/Môj disk/nefro.polascin.net/obrazky/2026-11; zhoda kópií overená SHA-256, nezávislá cloudová existencia overená Google Drive konektorom.

Texty aj ilustrácie boli používateľovi zobrazené pred publikovaním. X: dva príspevky vo vlákne, obidva pod 280 znakmi po započítaní odkazu podľa pravidla t.co. Threads: SK a EN ako dve časti vlákna. Facebook a LinkedIn: jeden dvojjazyčný príspevok. LinkedIn má štyri odborné hashtagy. Všetky siete majú nahraný sociálny obrázok; EN odpovede na X a Threads nesú odkaz na článok. Alternatívny text doplnený na všetkých štyroch sieťach. Facebook AI label on. Chránený účet X zostal chránený.

Zverejnenie overené v používateľskom rozhraní, nie iba úspešným kliknutím. X: oba príspevky viditeľné na profile. LinkedIn: text, obrázok a samostatný permalink viditeľné po obnovení. Threads: SK obrázok a EN odpoveď viditeľné vo vlákne. Facebook: oba jazyky, odkaz a fotografia viditeľné na profile po dokončení publikovania.

- x_sk: https://x.com/polascin/status/2124262868086387189
- x_en: https://x.com/polascin/status/2124262871630520818
- facebook: https://www.facebook.com/photo/?fbid=10245940703311263&set=a.1137300272261
- linkedin: https://www.linkedin.com/feed/update/urn:li:activity:7530028879437074433/
- threads_sk: https://www.threads.com/@lubomirpolascin/post/DgBRMbBCJZ-
- threads_en: https://www.threads.com/@lubomirpolascin/post/DgBRNr6CFSo
- drive_article_image: https://drive.google.com/file/d/1VD4PzF8h3cLIKZF8Hju1qydjC8cVHNmN/view
- drive_social_image: https://drive.google.com/file/d/1HUoOAvQBVMuC8xwvVxZfUUBcccEtINJe/view

Snímky výsledku X, LinkedIn a Threads sú v tomto priečinku. Na Facebooku bolo nahratie obrázka úspešné cez kláves Enter na ovládacom prvku Photo/video a štandardný dialóg prílohy. Samotné kliknutie neotvorilo výber súboru. Súbory sa nenahrávali obchádzaním rozhrania.

Otvorené zostáva vydanie úplnej vedeckej publikácie TRANSCEND-T2D-2. Žiadna ďalšia používateľská akcia nie je potrebná na dokončenie tejto publikácie.
