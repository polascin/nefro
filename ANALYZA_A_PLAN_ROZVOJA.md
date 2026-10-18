# Hĺbková analýza a plán rozvoja Nefro

Dátum: 18. 10. 2026. Základ revízie: `c313ffe` na `main`.

## Záver a rozsah

Portál má použiteľný základ: natívne PDO parametre, spoločnú ochranu relácie,
CSRF kontroly, oddelené administrátorské oprávnenia, ochranu súborov a viacero
izolovaných regresných testov. Najväčšie riziko ďalšieho rastu predstavujú
prepojené bootstrapy, chýbajúce integračné prostredie a prevádzková spoľahlivosť
frontov a nasadzovania. Odporúčam postupné oddeľovanie modulov so zachovaním
existujúcich trás a testov. Plošný prepis aplikácie by teraz zvýšil regresné riziko.

Inventúra zahŕňala všetky sledované súbory: na začiatku 609 PHP súborov,
z toho 397 obsahových skriptov, 194 ostatných koreňových PHP súborov a 18 PHP
nástrojov/testov; ďalej 35 JavaScriptov a 6 modulov MJS vrátane dodávaných knižníc.
Celoprojektové vyhľadávanie rizikových konštrukcií a automatizované kontroly
pokrývajú celý sledovaný kód. Manuálne boli cielene preskúmané kritické toky:
prihlásenie, overenie a reset hesla, relácie, CSRF, newsletter, právne oznámenia,
vyhľadávanie, uploady, sťahovanie publikácií, platobné spracovanie, ochrana botov,
PDF, nasadzovanie a prístup k výsledkom kalkulačiek.

Tento rozsah neznamená manuálne prečítanie každého riadka ani klinickú validáciu
všetkých článkov a kalkulačiek. Produkčné SQL zápisy, migrácie, cleanup, workery,
platby a SMS sa nespúšťali. Kontrola právnych mechanizmov nie je právny posudok.

## Implementované opravy

| ID      | Závažnosť                                   | Príčina a dopad                                                                                                                                                                                   | Oprava a dôkaz                                                                                                                                                                            |
| ------- | ------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| A129-01 | stredná                                     | FULLTEXT opakoval `:q` v jednom native PDO statemente. Výnimka nútila pomalší náhradný spôsob vyhľadávania.                                                                                       | Samostatné `:q` a `:q_score`; test odmieta duplicitné bindy.                                                                                                                              |
| A129-02 | stredná                                     | Opätovné odoslanie overenia opakovalo `:login` pre e-mail aj meno.                                                                                                                                | Dva unikátne parametre v `resend_verification.php`; regresná kontrola query.                                                                                                              |
| A129-03 | stredná                                     | Newsletter endpoint používal rate limiter bez načítania jeho definície.                                                                                                                           | Doplnený spoločný auth bootstrap; test načítania a 8 správaní limitera na SQLite.                                                                                                         |
| A129-04 | stredná                                     | Bot log ukladal celú query vrátane možných bearer/reset tokenov; UA nemal pevnú dĺžku ani ochranu pred riadiacimi znakmi.                                                                         | Loguje sa iba cesta, všetky polia sú ohraničené a jednoriadkové; 20 kontrol bez zápisu reálneho logu.                                                                                     |
| A129-05 | stredná                                     | Výnimka pri zostavení alebo odoslaní jedného právneho oznámenia mohla prerušiť dávku.                                                                                                             | Obe fronty zachytávajú chybu položky, zaznamenajú pokus a backoff, pokračujú ďalšou; testy poškodeného snapshotu aj transportu.                                                           |
| A129-06 | stredná                                     | Hooky a priamy deploy neobmedzovali produkčné nahrávanie na `main`.                                                                                                                               | Ochrana v oboch hookoch aj deploy skripte; simulovaný feature deploy odmietnutý pred SSH.                                                                                                 |
| A129-07 | stredná                                     | PDF sync mohol po zlyhaní regenerácie pokračovať alebo zahrnúť cudzie staged zmeny.                                                                                                               | Kontrola čistého stagingu/PDF a návratového kódu SSH; pri chybe žiadne SFTP ani commit.                                                                                                   |
| A129-08 | nízka                                       | Postupné zvýrazňovanie mohlo znova spracovať vlastné HTML a rozbiť výsledok pri výrazoch `mark`/`class`.                                                                                          | Jeden priechod nad čistým textom s escapovaním; testy prekryvu, entít, Unicode a HTML.                                                                                                    |
| A129-09 | nízka                                       | Zhodné skóre a dátum nemali stabilné poradie; extrémna stránka mohla pretekať pri výpočte offsetu.                                                                                                | Dodatočné radenie podľa ID, hranice page/perPage a bezpečný celočíselný offset; test zhodných dátumov a PHP_INT_MAX.                                                                      |
| A129-10 | nízka                                       | Zoznam zdrojových autorov vytváral tisíce úplných odkazov, väčšinu následne skrýval JavaScript.                                                                                                   | Osem priamych odkazov a natívny rozbaľovací výber s vyhľadávaním a GET formulárom; všetci autori zostávajú dostupní.                                                                      |
| A129-11 | stredná závislosť, podmienená zneužiteľnosť | Dodaný KaTeX 0.16.11 spadal do rozsahu dvoch bezpečnostných oznámení. Prvé vyžaduje dôveryhodné HTML príkazy, druhé už existujúce prototype pollution; ich zneužitie v portáli nebolo preukázané. | KaTeX 0.18.11, overená npm SHA-512 integrita, licencia, odstránené staré assety; explicitné trust=false a limity rozširovania/veľkosti; test vzorcov, zdedeného trust a odkazov na fonty. |

Unikátne pomenované parametre vyžaduje [oficiálna dokumentácia PDO](https://www.php.net/manual/en/pdo.prepare.php).
Rozsah KaTeX opráv: [GHSA-cg87-wmx4-v546](https://github.com/KaTeX/KaTeX/security/advisories/GHSA-cg87-wmx4-v546)
a [GHSA-238p-pmpm-9mq7](https://github.com/KaTeX/KaTeX/security/advisories/GHSA-238p-pmpm-9mq7).
Balík pochádza z [oficiálneho npm registra](https://registry.npmjs.org/katex/0.18.11).

## Overenie a jeho hranice

- PHPStan: 0 chýb, baseline sa nemenila.
- PHP lint: 612 súborov, 0 chýb vrátane troch nových PHP testov.
- Regresie: 14 PHP súborov, spolu 430 úspešných kontrol; JS test súhlasu a KaTeX prešli.
- Deploy/PDF: 12 kontrol so syntetickým Git/SSH/SFTP, bez siete a produkčných zápisov.
- CS-Fixer: surový výsledok 424/590; na LF kópiách všetkých 424 kandidátov 0 nálezov. Rozdiel spôsobujú konce riadkov, nie požiadavka na plošné preformátovanie.
- Regresné databázové adaptéry používajú SQLite v pamäti. Kontrola unikátnych PDO parametrov simuluje obmedzenie natívneho MySQL; nenahrádza integračný test proti MariaDB.
- Úplný autentifikačný HTTP test a skutočné doručovanie, SMS a platobné toky zostávajú neoverené v izolovanom prostredí.
- Existujúce staršie serverové logy sa nemenili. Nové filtrovanie spätne neodstráni už uložené query; ich retenciu/purge treba riešiť samostatným konkrétne schváleným zásahom.
- Klinická správnosť všetkých kalkulačiek, úplná WCAG zhoda, zmluvy dodávateľov, obnova zo záloh a organizačné právne dôkazy neboli týmto behom preukázané.

### Nasadenie a živé kontroly

Implementácia je v commite `b5e5c46`; následný `c30882a` opravuje formátovanie
release guardu a čas záznamu zmien. Produkčný marker po druhom SFTP deployi:
`c30882a`. Actions validačný job pre implementáciu uspel, produkčný Actions job
sa správne preskočil. Prvé Trunk CI odhalilo formátovanie shell skriptu;
opravené pripnutým shfmt, ShellCheck aj 12 simulovaných kontrol následne prešli.
Výsledky kontrol runtime commitu sú dostupné v
[Trunk CI](https://github.com/polascin/nefro/actions/runs/39075120604) a
[validačnom workflow](https://github.com/polascin/nefro/actions/runs/39075120618).
Nasledujúca dôkazová dokumentácia je v deploy ignore a nemení runtime marker.

- 12 verejných GET stránok vrátane troch skutočných vyhľadávacích dopytov,
  extrémneho čísla stránky, filtra autora, prihlásenia a právnych stránok: HTTP 200,
  jeden title, CSP a HSTS, bez zachytenej PHP chyby alebo úniku cesty.
- Dva interné PHP partialy a interný plán: HTTP 403.
- Tri používané KaTeX JS/CSS súbory a hlavný WOFF2 font: HTTP 200 a SHA-256
  zhodný s lokálnymi súbormi; starý `0.16.11/katex.min.js`: HTTP 404.
- Domovská stránka pred zmenou 536 928 B, po zmene 238 158 B, približne o 56 %
  menej nekomprimovaného HTML. Ide o veľkosť odpovede, nie meranie p95 výkonu.
- V mobilnom náhľade prehliadača overené otvorenie výberu autora a odoslanie
  syntetického mena; výsledná URL obsahuje GET filter a stránka správne uvádza,
  že autor nemá publikované články. Celá matica prehliadačov zostáva neoverená.
- Prípravná séria prekročila krátke okno limitera a dostala 429. Ochrana sa
  nemenila; po uplynutí okna prešla záverečná séria so správnym parametrom `s`.

## Plán ďalšieho rozvoja

Odhady sú pracovné človekodni jedného vývojára vrátane testov. Nezahŕňajú
externé právne/klinické posúdenie ani čakanie na infraštruktúru. P0 označuje
najbližšiu etapu, nie potvrdený kritický bezpečnostný incident.

| Etapa                  | Priorita a úloha                      | Rozsah / odhad                                                                                                                         | Podmienka prijatia                                                                                                                                            |
| ---------------------- | ------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| 1, najbližšie 2 týždne | P0: izolované integračné prostredie   | MariaDB s vymyslenými údajmi, zachytávač SMTP, náhrada SMS a Stripe test mode; 3 až 5 dní                                              | Žiadna produkčná konfigurácia ani adresát; automaticky overený reset, overenie, odber, limity, nákup a prístup k výsledkom.                                   |
| 1                      | P0: regresie ako povinná CI brána     | Jednotný zoznam bezpečných testov, PHPStan, syntax JS, PHP lint, testy na cielenej verzii PHP; 2 až 3 dni                              | Úmyselná regresia zastaví merge/release; žiadne vypínanie baseline alebo hookov; výsledky dostupné v CI.                                                      |
| 1                      | P0: prevádzkové signály a obnova      | Kontrola tela verejných odpovedí, markeru a frontov; inventúra záloh a skúšobná obnova izolovanej kópie; 2 až 4 dni                    | Dohodnuté RPO/RTO, preukázaná obnova, alarm na zlyhanie a vek frontu bez osobných údajov v telemetry.                                                         |
| 2, nasledujúci mesiac  | P1: spoľahlivé fronty                 | Krátke transakcie, claim/lease položky, idempotencia, obnova po prerušení; 4 až 7 dní                                                  | Dva workery neodošlú tú istú položku súčasne; SMTP úspech nasledovaný DB chybou má zdokumentovanú obnovu a merateľnú duplicitu.                               |
| 2                      | P1: oddelenie bootstrapov             | Menšie moduly konfigurácie, relácie, HTTP ochrany, CLI a služieb, jednotné čítanie skalárnych vstupov; 4 až 6 dní                      | API nevracia HTML chybu; pole namiesto scalar vstupu má riadenú 400 odpoveď; chýbajúci require odhalí test.                                                   |
| 2                      | P1: normalizácia autorov a výkon      | Zmerať EXPLAIN a p95, oddeliť autorstvo od obsahových parsovaní a cachovať metadáta; 4 až 7 dní                                        | Výpis ani filter nevyžaduje parsovanie celého korpusu; rovnaké výsledky filtrovania, namerané zlepšenie pri realistickej záťaži.                              |
| 2                      | P1: register závislostí               | Verzia, pôvod, licencia, hash a spôsob aktualizácie každej dodanej knižnice/PHAR; 1 až 2 dni                                           | Pravidelná kontrola primárnych advisories a reprodukovateľná aktualizácia s regresnými testami.                                                               |
| 3, 1 až 3 mesiace      | P1: klinické referenčné testy         | Inventár vzorcov, jednotiek, hraničných hodnôt a primárnych zdrojov; klinická revízia; 6 až 12 dní                                     | Každá kalkulačka má nezávislé referenčné príklady a verziu metodiky, zmeny medicínskeho významu majú osobitné schválenie.                                     |
| 3                      | P1: používateľské úlohy a prístupnosť | Klávesnica, čítačka, mobil, chyby formulárov, jednotky a tlač; 4 až 7 dní                                                              | Používateľ dokončí vyhľadanie, výpočet a návrat k výsledku bez myši; zdokumentovaná matica prehliadačov, bez horizontálneho pretekania pri 320 px a zväčšení. |
| 3                      | P2: súkromie a vysvetlenie stavu      | Jasný rozdiel medzi lokálnym výpočtom a uložením, priebežná minimalizácia a overenie retencie; 3 až 5 dní                              | Uloženie je zrozumiteľné a kontrolovateľné používateľom; testy rolí/exportu/výmazu a nezávislá kontrola organizačných dôkazov.                                |
| 4, priebežne           | P2: udržateľnosť obsahu a modulov     | Oddeliť repository/services/view po vertikálnych funkciách, verzovať metodiky, redakčné a PDF kontroly; 5 až 10 dní na prvé dva moduly | Každý krok má zachované URL a správanie, testy a meranie; žiadny veľký prepis bez preukázanej potreby.                                                        |

### Poradie a závislosti

Najprv vytvoriť izoláciu a CI bránu, potom meniť transakcie frontov a dátový
model autorov. Súčasné newsletterové spracovanie má rozsiahle transakcie okolo
externého doručovania; SMTP sa po DB rollbacku nedá odvolať. Preto samotné
zachytenie výnimky nerieši všetky možné duplicity. Nový outbox/claim návrh musí
mať test prerušení a explicitnú migračnú a návratovú stratégiu.

Zmeny schémy a produkčných údajov, cleanup existujúcich logov a spustenie
workerov vyžadujú konkrétne schválenie. Vývoj a testy ich návrhu môžu prebehnúť
v izolácii. Pri každej etape zachovať súčasné bezpečnostné kontroly a uvádzať,
čo je overený výsledok a čo zostáva pracovným návrhom.

## Realizácia prvej etapy: izolácia a CI (18. 10. 2026)

Pripravené sú úlohy izolovaného integračného prostredia a povinného regresného
jobu. Postup, rozsah, piny a bezpečnostné hranice opisuje
[integračný návod](tools/integration/README.md). Prevádzkové alarmy a skúšobná
obnova záloh z tretej úlohy etapy zostávajú samostatnou ďalšou prácou.

Sada používa dočasnú MariaDB v UTC, PHP 8.5.8 v pásme Europe/Bratislava,
Mailpit so skutočným overovaným STARTTLS a vývojový SMS provider. Platobná
časť overuje existujúci manuálny model potvrdenia úhrady, nie Stripe API,
ktoré portál nemá. Produkčné prístupy ani externé SMS/platby sa nepoužívajú.

Regresný runner má 18 testovacích súborov; integračná časť má 41 kontrol.
Negatívna skúška s návratovým kódom 42 overuje zastavenie runnera. Povinný
job blokuje Actions deploy; lokálny SFTP navyše čaká na úspech CI presného HEAD.
Ochrana vetvy musí vyžadovať výsledok tohto jobu aj pre administrátora.

Test odhalil závislosť spoločného rate limitera od zhodného časového pásma
PHP a DB: pri UTC databáze sa okno obnovovalo príliš skoro. Výpočet uplynutia,
trvania blokovania aj reset okna teraz používa výhradne databázový čas;
regresia výslovne zachováva rozdielne pásma. Explicitný `NEFRO_ENV_PATH` sa
pri chybe už nenahrádza iným konfiguračným súborom. Schéma produkcie sa nemení.

Overenie implementácie `c46b74f`: [regresný workflow](https://github.com/polascin/nefro/actions/runs/39105249048)
a [Trunk](https://github.com/polascin/nefro/actions/runs/39105249032) úspešné.
V CI prešlo 18 regresných súborov, 41 integračných kontrol, negatívna skúška
runnera aj tri simulácie deployu; syntax 622 PHP súborov a PHPStan bez chyby.
Produkčný marker po overenom SFTP deployi je `c46b74f`. Živé verejné GET
kontroly prešli, testovací INI je na produkcii nedostupný (403).
Následná dôkazová dokumentácia nemení nasaditeľné súbory.

## Skúška obnovy záloh (18. 10. 2026)

[Postup a hranice obnovy](tools/restore/README.md) a
[strojový výsledok](tools/restore/evidence/2026-10-18.json) sú súčasťou projektu.
Existujúca čiastková záloha publikácií sa obnovila v kontajneri bez siete:
10 súborov, 218 769 019 bajtov, zhodné SHA-256 a nezmenený zdroj.
Jeden EPUB v zdroji neprešiel kontrolou ZIP kontajnera. Záloha sa nemenila.

Po prihlásení používateľa sa získala existujúca DB záloha poskytovateľa
z 18. 10. 2026 o 03:21. Izolovaná obnova overila 37 tabuliek a 144 649 riadkov
vrátane obsahových súčtov a schémy po obnove do druhej čerstvej MariaDB.
[Strojový záznam DB obnovy](tools/restore/evidence/2026-10-18-production-db.json)
neobsahuje riadky ani osobné údaje. Povinná CI brána navyše overuje SQL.gz, diakritiku,
cudzie kľúče, pohľad, procedúru, trigger, vypnutú udalosť, odmietnutie
neplatného SQL a rozpoznanie poškodeného EPUB. To nenahrádza produkčnú zálohu.

Následná izolovaná skúška úplného súborového ZIP zo 17. 10. 2026 o 15:10
overila 3 323 súborov (2 705 031 952 bajtov), 60 adresárov a 532 kontrol
formátov bez chyby. [Strojový výsledok](tools/restore/evidence/2026-10-18-full-files.json)
potvrdzuje nemennosť zdroja a odstránenie kontajnera. Nástroj podporuje priamy
ZIP vstup, bezpečné cesty, UTF-8 názvy, prázdne adresáre a samostatný režim
`--files-only`; negatívne ZIP skúšky sú súčasťou povinnej regresnej brány.

Obnoviteľnosť DB a dodaných súborov je overená oddelene. Zostáva preveriť
konzistenciu rozdielne datovaných záloh, aplikačné väzby a dešifrovanie.
Archív obsahuje kandidátsky zdroj odvodenia kľúča v konfigurácii; jeho zhodu
s aktívnym kľúčom skúška nepotvrdzuje. RPO ani RTO celého systému zatiaľ
nie sú preukázané. Produkcia sa počas skúšok nemenila.
