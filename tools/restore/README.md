# Izolovaná skúška obnovy

Nástroj obnoví existujúcu súborovú zálohu a SQL/SQL.gz/ZIP do jednorazových
kontajnerov. V predvolenom režime nespúšťa portál. Voliteľná aplikačná skúška
spúšťa iba určené funkcie a verejné sťahovanie na loopbacku kontajnera bez siete.
Migrácie, cron, newsletter, SMS ani platby sa nespúšťajú.
Produkčná DB/SMTP konfigurácia ani prihlasovacie údaje sa neaktivujú.
Pri aplikačnej skúške sa z archivovanej konfigurácie číta iba zdroj šifrovacieho
kľúča, výhradne v pamäti izolovaného kontajnera.

## Príprava a spustenie

Potrebný je Docker s Linux kontajnermi a Python 3.12 alebo novší.
Obrazy sa pripravujú pred obnovou; samotné kontajnery obnovy nemajú sieť.

```bash
docker build -f tools/integration/Dockerfile -t nefro-restore-php .
docker pull mariadb:11.4.13@sha256:250e1609e93c0e6aecf64bfbab2d84d5e89d2481540fe77447ff6c855c3b1873
python tools/restore/run.py --files /cesta/k/suborovej-zalohe --sql /cesta/k/databaze.sql.gz \
  --file-image nefro-restore-php --report scratch/restore-vysledok.json
```

Na Windowse možno použiť `py` namiesto `python`. Existujúci report sa neprepisuje.
Vstupom je existujúci adresár zálohy bez symlinkov alebo priamo ZIP a existujúci SQL/SQL.gz/ZIP súbor.
Súborový ZIP sa rozbalí až v izolovanom kontajneri do pamäte, nie na hostiteľský disk.
Kontrola odmieta nebezpečné cesty, duplicity, symlinky, špeciálne súbory,
šifrované položky a poškodené CRC. Limit je 100 000 položiek a 8 GiB po rozbalení.
Overené ZIP položky sa priebežne prenášajú cez UTF-8 tar do pamäte kontajnera;
obchádza sa tým nejednotné prekódovanie názvov v Info-ZIP. Porovnávajú sa
aj názvy a prázdne adresáre. Pôvod, čas vytvorenia
a príslušnosť oboch záloh k rovnakému obdobiu treba overiť v úložisku.
Build používa allowlist `.dockerignore`; privátne dáta a kľúče sa doň nepridávajú.

Ak databázová záloha chýba, možno výslovne nacvičiť iba databázový postup:

```bash
python tools/restore/run.py --files /cesta/k/suborovej-zalohe --synthetic-database \
  --file-image nefro-restore-php --report scratch/restore-nacvik.json
```

Takýto report má vždy `result=PARTIAL` a
`existing_database_backup_restore_verified=false`. Syntetický nácvik
nie je dôkazom obnoviteľnosti produkčnej databázy.

## Kontroly a izolácia

1. SHA-256 a veľkosť každého vstupného súboru. ZIP/CRC a povinný obsah
   EPUB/DOCX/ODT, PDF hlavička a koncový marker, hlavička AZW3.
2. Zdroj súborov je pripojený iba na čítanie. Obnova ide do `tmpfs` s `noexec`,
   v kontajneri bez siete, bez portov, bez capabilities a pod neprivilegovaným
   používateľom. Z kontajnera sa čítajú iba veľkosti a kontrolné súčty.
   Obnovený obsah ani konfigurácia sa nespúšťajú.
3. SQL sa importuje do samostatnej MariaDB s vypnutým sieťovým serverom,
   plánovačom udalostí a `LOCAL INFILE`. Dáta sú v `tmpfs`. Nejde o pripojenie
   k existujúcej databáze; import môže meniť iba jednorazovú izolovanú MariaDB.
4. `CHECK TABLE`, počty riadkov a obsahové kontrolné súčty; export a obnova
   do druhej čerstvej MariaDB. Porovnáva sa aj export schémy vrátane pohľadov,
   procedúr, triggerov a udalostí. Dump zostáva v pamäti procesu.
5. Opakovaná kontrola nemennosti zdrojov, siete a portov. Odstránenie vlastných
   kontajnerov vrátane obnovených dát. Až potom vznikne report bez obsahu
   riadkov, prihlasovacích údajov a názvov používateľov.

Databázový `tmpfs` má limit 768 MiB. Pre súbory možno nastaviť
`--file-memory-mib` v rozsahu 128 až 8192 (predvolene 768).
Nástroj pred spustením vyžaduje priestor na dáta, 15 % rezervu a 64 MiB režijného priestoru.
Docker musí mať dostatok voľnej pamäte aj pre ostatné procesy.
Poškodenie zdrojového formátu sa vykazuje samostatne: presná bajtová obnova
poškodeného EPUB neznamená použiteľný EPUB. Chyba importu alebo upratania
nesmie vytvoriť úspešný report. Návratový kód 0 označuje dokončenie nácviku;
pri vyhodnotení treba čítať aj `result`, `file_format_validation` a príznak
skutočnej databázovej zálohy. `PARTIAL` nie je plná úspešná obnova.
Poškodené publikácie možno identifikovať podľa `failed_file_sha256` bez
zverejnenia názvov súborov v reporte.

Neoveruje sa vizuálna správnosť dokumentov, aplikačné správanie, dešifrovanie,
2FA, oprávnenia/ACL, externé služby ani obnova celého hostingu. Súčty potvrdzujú
zhodu s dodanou zálohou, nie jej autenticitu alebo úplnosť oproti produkcii.

## Voliteľná kontrola konzistencie a aplikácie

```bash
python tools/restore/run.py --files /cesta/k/suborom.zip --sql /cesta/k/databaze.zip \
  --file-memory-mib 4096 --application-probe --file-image nefro-restore-php \
  --report scratch/restore-konzistencia.json
```

Predchádzajúci odsek opisuje hranice predvoleného nácviku. Prepínač
`--application-probe` navyše výslovne povoľuje vykonanie archivovaného kódu
v kontajneri bez siete. Dôverovať treba pôvodu kódu aj obrazu; izolácia
nenahrádza overenie ich integrity. Pôvodné archívy sa nemenia.

- Porovnajú sa odkazy článkov na PDF a obrázky (`src`, `srcset`), aktuálne
  a archivované avatary, súbory plateného katalógu a formáty objednávok.
  Externé obrázky sa nesťahujú. Cesty s traversal alebo mimo obnovy sa odmietnu.
- Pri každom deklarovanom cudzom kľúči sa vyhľadajú osirelé riadky.
  To nepokrýva nedeklarované obchodné pravidlá ani zhodu obsahu PDF s článkom.
- Z archivovanej konfigurácie sa načíta iba prvý dostupný zdroj dátového kľúča
  podľa priorít aplikácie. Aktívna konfigurácia obsahuje len izolované nastavenia.
  Skutočné TOTP obálky sa dešifrujú a overí sa odmietnutie nesprávneho kľúča
  aj zmeneného ciphertextu. Tajomstvá sa nevypisujú, nehashujú do reportu ani
  neukladajú na hostiteľa. Kontrola nepoužíva reálne prihlasovacie kódy.
- Samostatný syntetický kryptografický cyklus overí použiteľnosť kľúča.
  Ak v DB nie je šifrovaný záznam, dešifrovanie sa označí `NO_ENCRYPTED_RECORDS`,
  nie `PASS`. Bez DB je výsledok najviac `PARTIAL`.
- Obnovená aplikácia sa pripája k prvej jednorazovej DB iba cez Unix socket.
  Samostatný účet má výhradne `SELECT`; negatívny pokus o vytvorenie tabuľky
  musí byť odmietnutý. Socket je v samostatnom označenom zväzku a po skúške
  sa odstráni spolu s kontajnermi. DB naďalej nemá sieťový server ani udalosti.
- HTTP server počúva len na `127.0.0.1` v kontajneri bez siete a bez portov.
  Router povoľuje iba konkrétne verejné trasy. Overuje sa zoznam článkov,
  vyhľadávanie, prihlasovací formulár, článok a odmietnutie neprihláseného
  sťahovania PDF. Chýbajúci povinný endpoint znamená `FAIL`; bez publikovaného
  článku nemožno dostať plný `PASS`. Vyhľadávanie používa parameter `s`
  a musí vykresliť vetvu výsledkov, samotný prázdny formulár nestačí.
  Verejné publikácie sa prenesú vo všetkých 20 kombináciách
  vydania a formátu; SHA-256 odpovede musí zodpovedať obnovenému súboru.
- Po skúške sa znova porovnajú súčty aplikačných tabuliek a pôvodných archívov.
  Report obsahuje iba agregované výsledky. Chyba či chýbajúca referencia
  nesmie vytvoriť `PASS`; kontrolovaná chyba má stav `FAIL` a dokončené čiastkové
  kontroly zostávajú viditeľné. Návratový kód 0 sám osebe nepotvrdzuje úspech.

Skúška nepotvrdzuje prihlásenie reálnych účtov, použitie 2FA autentifikátora,
zmenu profilu či ďalšie zapisujúce toky nad obnovenými údajmi. Tie sa testujú
oddelene na syntetických dátach v integračnej bráne. Neoveruje sa prehliadač,
Apache `.htaccess`, SMTP, SMS, platobný poskytovateľ, ACL hostingu ani RPO/RTO.
Pri inom dátovom modeli treba projektový probe upraviť; chýbajúcu podporu
nenahrádza úspešná generická obnova.

## Doplnenie izolovanej pracovnej kópie

```bash
python tools/restore/run.py --files /cesta/k/povodnym-suborom.zip --sql /cesta/k/databaze.zip \
  --application-probe --file-memory-mib 4096 --file-image nefro-restore-php \
  --recovery-source /cesta/k/lokalnym-zdrojom --recovery-bundle scratch/nove-doplnky \
  --report scratch/restore-doplnena-kopia.json
```

Najprv sa overí úplná zhoda pôvodnej obnovy s archívom. Až potom sa do jej
pracovnej kópie v `tmpfs` doplnia **iba chýbajúce PDF a rastrové obrázky článkov**
odkazované databázou. Existujúce súbory sa neprepisujú; `tar -k` musí prípadnú
kolíziu odmietnuť. Nepridáva sa PHP kód, konfigurácia, SQL, kľúče ani súbory
účtov. Symlinky, nekanonické cesty a doplnky nad 128 MiB sa odmietajú.
Spoločný objem dát musí zostať v povolenom pamäťovom rozpočte.

`--recovery-source` je iba zdroj čítania. `--recovery-bundle` musí byť nový
adresár; uchováva len doplnené verejné súbory v rovnakých relatívnych cestách.
Po skúške sa celá pamäťová obnova vrátane databázy odstráni. Zopakovať ju možno
z pôvodných archívov a zachovaného doplnkového balíka ako nového recovery zdroja;
výstupný balík aj report musia mať pri každom behu nové cesty.

Report uvádza pri každom doplnku SHA-256, veľkosť, druh lokálneho zdroja
a pri sledovaných súboroch posledný commit a zhodu s blobom `HEAD`.
Git je voliteľný: bez dostupného programu alebo čitateľného commitu zostávajú
tieto polia `null`; kopírovanie zo samostatného adresára tým nie je blokované.
Pri zdroji v podadresári repozitára sa blob číta relatívne k tomuto podadresáru.
Pri PDF s dostupným titulom článku a nástrojom `pdftotext` sa v pamäti overí
prítomnosť normalizovaného titulu v texte. Bez tohto nástroja ostáva kontrola
textovej identity `NOT_RUN`. PDF musí prejsť aj základnou kontrolou formátu,
obrázky kontrolou čitateľnej veľkosti cez PHP. Po kopírovaní sa znovu overia
všetky kontrolné súčty doplnkov a celý aplikačný probe.

Úspech doplnenej pracovnej kópie **nemení výsledok pôvodnej dvojice záloh**.
Zhoda názvu a titulu PDF nepotvrdzuje úplnú obsahovú zhodu s databázovým
článkom ani pôvodný čas jeho vytvorenia. Doplnenie nie je nový záložný snapshot
poskytovateľa a nepotvrdzuje spoločný historický bod obnovy.

## Regresné kontroly

```bash
python tools/restore/self_test.py --file-image nefro-restore-php
```

Syntetická kontrola zahŕňa SQL.gz aj ZIP so SQL.gz, diakritiku, cudzí kľúč, pohľad, procedúru,
trigger a vypnutú plánovanú udalosť. Overuje odmietnutie neplatného SQL
a odlíšenie poškodeného EPUB od úspešnej bajtovej obnovy. Spúšťa sa aj
cez povinnú integračnú bránu `tools/integration/run.sh`.

Samostatná kontrola súborov bez spustenia databázy:

```bash
python tools/restore/run.py --files /cesta/k/suborom.zip --files-only --file-memory-mib 4096 \
  --file-image nefro-restore-php --report scratch/restore-subory.json
```

Takýto úspech má `verification_scope=files_only` a `database_round_trip=NOT_RUN`.
Nepotvrdzuje obnovu databázy. Regresná brána overuje aj túto vetvu, diakritiku
v názvoch súborov a adresárov, prázdne adresáre a odmietnutie ZIP traversal,
symlinkov a poškodeného CRC.

## Výsledok z 18. októbra 2026

Strojový záznam: [evidence/2026-10-18.json](evidence/2026-10-18.json).

| Oblasť                   | Výsledok                                                                                                                                  |
| ------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Zdroj                    | Čiastková lokálna záloha publikácií označená dátumom 2026-10-06; označenie nepreukazuje čas jej vytvorenia.                               |
| Súbory                   | 10 súborov, 218 769 019 bajtov; úplná zhoda veľkostí a SHA-256, zdroj nezmenený.                                                          |
| Formáty                  | 9 kontrol prešlo; jeden EPUB nie je platný ZIP kontajner. Zdrojová záloha sa neopravovala.                                                |
| Prvý DB nácvik           | 3 syntetické tabuľky a 3 riadky; pôvodný čiastkový záznam sa zachováva.                                                                   |
| Skutočná záloha DB Nefro | Záloha poskytovateľa z 18. 10. 2026, 03:21:13: 37 tabuliek, 144 649 riadkov, zhodné obsahové súčty aj schéma po obnove do druhej MariaDB. |
| Izolácia                 | Sieť `none`, žiadne porty, bez spustenia aplikácie a bez produkčných SQL zápisov.                                                         |
| Celkové hodnotenie       | **ČIASTOČNE OVERENÉ**, nie potvrdenie úplnej obnoviteľnosti systému.                                                                      |

Časy v JSON merajú iba lokálny nácvik po príprave obrazov. Nie sú RTO celého
systému. RPO nemožno určiť bez overeného dátumu a rozsahu DB aj súborovej zálohy.
Nový export zo živej databázy sa nevytváral.

## Úplná súborová záloha a zostávajúce hranice

Používateľ stiahol archív adresára projektu zo zálohy poskytovateľa označenej 17. 10. 2026 o 15:10. [Výsledok súborovej obnovy](evidence/2026-10-18-full-files.json)
potvrdzuje zhodu všetkých 3 323 súborov (2 705 031 952 bajtov) a 60 adresárov.
Prešlo 532 kontrol formátov bez chyby. Archív zostal nezmenený a jednorazový
kontajner bol odstránený. Použitý súborový tmpfs mal limit 4 096 MiB.

Archív pokrýva aplikáciu, publikácie, uploady, PDF článkov aj konfiguračný INI.
Konfigurácia obsahuje neprázdny kandidátsky zdroj odvodenia dátového kľúča
`NEWSLETTER_UNSUBSCRIBE_SECRET`; samostatný `data_protection.key` sa v archíve
nenachádza. Hodnota sa nevypisovala ani nepoužila ako aktívna konfigurácia.
V pôvodnej súborovej skúške sa dešifrovanie neoverovalo; nadväzujúci výsledok
je uvedený nižšie. Súčasný stav živej produkcie sa neoveroval.

[Skutočná DB obnova](evidence/2026-10-18-production-db.json) bola overená
v samostatnej predchádzajúcej skúške. Terajší beh používa `--files-only`;
DB neimportoval znova. SQL, konfigurácia ani obsah archívu nie sú v repozitári.
Starší chybný EPUB z čiastkovej zálohy zostáva historickým nálezom;
kontrolované dokumenty úplného archívu prešli.

DB záloha z 18. 10. 2026 o 03:21:13 a súborová záloha z predchádzajúceho dňa
netvoria preukázaný spoločný konzistentný bod obnovy. Na uzavretie úplnej
obnoviteľnosti systému treba vyriešiť nižšie zistené chýbajúce súbory
a preveriť prevádzkový postup vrátane oprávnení. RPO ani RTO celého systému
nie sú potvrdené. Produkčná obnova sa nespúšťala.

## Nadväzujúci výsledok konzistencie (18. 10. 2026)

[Strojový výsledok](evidence/2026-10-18-consistency.json) má správne **`result=FAIL`**:
dodaná dvojica záloh neprešla kontrolou všetkých súborových referencií.
Nejde o zlyhanie importu databázy alebo dešifrovania. Archívy sa neopravovali.

| Kontrola            | Výsledok                                                                                                                            |
| ------------------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| Databáza            | 37 tabuliek, 144 649 riadkov; obsah aj schéma zhodné po druhej obnove.                                                              |
| Súbory              | 3 323 súborov, 60 adresárov, zhodné SHA-256; 532 kontrol formátov bez chyby.                                                        |
| PDF článkov         | 449 zo 454 referencií dostupných; **5 odlišných PDF chýba**.                                                                        |
| Obrázky článkov     | 539 z 544 referencií dostupných; **5 odlišných obrázkov chýba**. Externé obrázky: 0.                                                |
| Avatary             | Všetkých 6 aktuálnych a 2 archivované súbory dostupné.                                                                              |
| Platený katalóg     | Všetkých 40 súborov dostupných. DB má 0 objednávok, takže reálna väzba objednávky na súbor nebola dátami precvičená.                |
| Cudzie kľúče        | 19 deklarovaných väzieb, 0 osirelých riadkov.                                                                                       |
| Dešifrovanie        | Jediný šifrovaný TOTP záznam úspešne dešifrovaný archivovaným kľúčom; nesprávny kľúč aj zmenený ciphertext odmietnuté.              |
| Ďalšie TOTP stavy   | 0 starých plaintext záznamov a 0 zapnutých TOTP bez tajomstva.                                                                      |
| Aplikačné funkcie   | 8 kontrol pomocných funkcií archivovaného kódu.                                                                                     |
| HTTP s obnovenou DB | 5 kontrol: zoznam článkov, vyhľadávanie, login formulár, presmerovanie neprihláseného sťahovania PDF a detail publikovaného článku. |
| Verejné sťahovanie  | 20 kombinácií vydania a formátu prenesených so zhodným SHA-256; 3 negatívne HTTP kontroly.                                          |
| Oprávnenia DB       | Samostatný účet iba `SELECT`, vytvorenie tabuľky odmietnuté; aplikačné tabuľky po HTTP skúške nezmenené.                            |
| Upratanie           | Všetky 3 vlastné kontajnery a zväzok Unix socketu odstránené; zdrojové archívy nezmenené.                                           |

Rozdiel času súborovej a databázovej zálohy je možným vysvetlením chýbajúcich
súborov, príčina však nebola potvrdená. Tieto zálohy nemožno označiť za úplnú
konzistentnú obnovu portálu. Ďalším krokom je zabezpečiť časovo zosúladenú
dvojicu záloh alebo preukázateľne doplniť chýbajúce súbory do novej pracovnej
kópie a celú kontrolu zopakovať. Pôvodné archívy a tento neúspešný dôkaz zachovať.

Zhoda kľúča je potvrdená pre uložený TOTP záznam v tejto DB zálohe, nie pre
neskoršie zmeny produkcie ani iné prípadné zdroje šifrovaných dát. Neuskutočnilo
sa prihlásenie reálneho účtu ani zmena jeho 2FA. Nie sú overené zapisujúce
aplikačné toky nad obnovenými reálnymi údajmi, doručovanie správ, platby,
vykreslenie v prehliadači, Apache pravidlá, oprávnenia hostingu ani spoločný
časový bod obnovy. Lokálne časy v JSON nie sú RTO a nepotvrdzujú RPO.

Povinná CI regresia navyše používa syntetickú aplikáciu a DB: pozitívny
dešifrovací prípad, samostatný chybný kľúč, chýbajúci PDF odkaz aj povinný endpoint, HTTP a
odmietnutie DB zápisu. Kontrolované negatívne prípady musia vykázať `FAIL`.
PHP probe súbory sú v allowliste build kontextu, preto podliehajú aj syntaxi
a PHPStan. Skutočné zálohy, kľúče a reporty s obsahom údajov sa do obrazu nekopírujú.

_Primárny zdroj: [Websupport: Zálohy databáz](https://www.websupport.sk/podpora/kb/zalohy-databaz/), overené 18. 10. 2026. Všeobecný opis služby nepotvrdzuje dostupnosť konkrétnej zálohy Nefro._

## Doplnená pracovná kópia (18. 10. 2026)

[Nový strojový výsledok](evidence/2026-10-18-recovered.json) má **`result=PASS`**
v rozsahu kontrolovaného aplikačného probe. Pôvodný neúspešný výsledok
[nezmenenej dvojice záloh](evidence/2026-10-18-consistency.json) zostáva zachovaný.

Všetkých 10 chýbajúcich súborov sa našlo v lokálnom repozitári. Ich SHA-256
sa zhodujú s príslušnými blobmi `HEAD`; posledný zdrojový commit každého
súboru je uvedený v novom JSON. Nevykonávalo sa generovanie PDF ani úprava
článkov alebo obrázkov. Doplnili sa existujúce bajtovo zhodné súbory:

| Spoločný názov PDF a obrázka                         | Doplnené cesty                        |
| ---------------------------------------------------- | ------------------------------------- |
| `ai-governance-klinicka-prax-nefrologia`             | `pdf/<nazov>.pdf`, `img/<nazov>.webp` |
| `automatizovane-podavanie-inzulinu-dm2-dialyza`      | `pdf/<nazov>.pdf`, `img/<nazov>.webp` |
| `cetp-inhibicia-obicetrapib-lipidy-renalna-funkcia`  | `pdf/<nazov>.pdf`, `img/<nazov>.webp` |
| `nizkoenergeticka-dieta-cvicenie-remisia-dm2-reset`  | `pdf/<nazov>.pdf`, `img/<nazov>.webp` |
| `renin-aldosteron-dapagliflozin-spironolakton-hfpef` | `pdf/<nazov>.pdf`, `img/<nazov>.webp` |

Ide spolu o 2 313 497 bajtov. Všetkých 5 PDF prešlo kontrolou formátu
a overením prítomnosti databázového titulu v extrahovanom texte; 5 WebP
kontrolou čitateľných rozmerov. Súbory doplnila výhradne vrstva recovery do
pamäťového `/restore`, bez prepísania ktoréhokoľvek pôvodného súboru.

| Kontrola po doplnení   | Výsledok                                                                                                      |
| ---------------------- | ------------------------------------------------------------------------------------------------------------- |
| Pracovná kópia         | 3 323 pôvodných + 10 doplnených súborov = 3 333 súborov pred spustením aplikačného probe.                     |
| PDF článkov            | 454 zo 454 odkazov dostupných, 0 nedostupných.                                                                |
| Obrázky článkov        | 544 z 544 odkazov dostupných, 0 nedostupných.                                                                 |
| Ostatné súborové väzby | 40 súborov plateného katalógu, 6 aktuálnych a 2 archivované avatary dostupné.                                 |
| Databáza               | 37 tabuliek, 144 649 riadkov; 19 deklarovaných väzieb bez osirelých riadkov.                                  |
| Aplikácia              | 8 kontrol funkcií, 5 HTTP kontrol s DB vrátane vetvy výsledkov vyhľadávania, 23 kontrol verejného sťahovania. |
| Dešifrovanie           | 1 z 1 TOTP záznamov úspešne dešifrovaný; nesprávny kľúč a zmenený ciphertext odmietnuté.                      |
| Nemennosť a izolácia   | Pôvodné archívy aj aplikačné tabuľky nezmenené, DB účet iba `SELECT`, sieť `none`, žiadne porty.              |
| Upratanie              | Všetky vlastné kontajnery a zväzok socketu odstránené.                                                        |

Lokálny doplnkový balík zostáva v ignorovanom adresári
`scratch/restore-recovered-assets-20261018/`, s relatívnymi cestami a
`recovery-manifest.json`. Neobsahuje SQL, konfiguráciu, kľúče ani údaje účtov.
Celá obnovená databáza a aplikačný strom zostali iba v dočasnej pamäti a po
kontrole sa odstránili. Balík umožňuje zostaviť tú istú pracovnú kópiu znova
nad pôvodnými archívmi. Kontrolovaná regresia pokrýva aj doplnenie PDF a PNG,
odmietnutie nebezpečných ciest a vynechanie nesúvisiaceho INI zo zdroja.

**Zostávajúce obmedzenia:** PASS patrí doplnenej pracovnej kópii, nie pôvodným
archívom. Použité lokálne verzie pochádzajú z doložených commitov, ale nemusia
zodpovedať historickému stavu v čase poskytovateľovej zálohy. Kontrola titulu
PDF nepotvrdzuje zhodu celého textu a obrázkov s článkom. Naďalej nie sú
overené prihlásenia reálnych účtov, zapisujúce toky nad reálnymi údajmi,
externé služby, Apache, ACL ani RPO/RTO. DB obsahuje 0 objednávok. Produkcia
ani pôvodné zálohy sa počas dopĺňania nemenili.

## Celý text piatich doplnených PDF (18. 10. 2026)

Porovnanie sa vykonalo nad novou izolovanou obnovou tej istej DB zálohy
(`804ca4ff…a8b3ce`) a existujúcim doplnkovým balíkom. Nepoužila sa produkčná
databáza ani konfigurácia. Obnova a kontrolný opätovný import potvrdili
37 tabuliek a 144 649 riadkov s rovnakým inventárom a schémou ako predtým.
Kontajnery mali sieť `none`, bez publikovaných portov, vypnuté TCP a udalosti;
údaje zostali v tmpfs. Po čítaní sa znovu overil inventár aplikačných tabuliek.
Vlastné kontajnery boli odstránené. SHA-256 vstupnej DB zálohy aj manifest
doplnkového balíka sa počas skúšky nezmenili. Pôvodná súborová záloha sa
v tejto etape vôbec neotvárala.

**Výsledok:** v celom extrahovanom texte všetkých piatich článkov sa nenašla
nevysvetlená obsahová zmena. Štyri PDF majú zhodnú celú usporiadanú sekvenciu
slov, číslic a interpunkcie; RESET navyše obsahuje opakovanú hlavičku tabuľky.
Hlavička s titulom, autor a dátum publikovania sa zhodujú s obnovenou DB vo
všetkých piatich PDF. Overená bola aj zdrojová URL a text záverečného upozornenia.

| PDF, spoločný názov so súborom                       | Strany | Tokeny DB / PDF | Rozdiel po zohľadnení číslovania zoznamov               |
| ---------------------------------------------------- | -----: | --------------: | ------------------------------------------------------- |
| `ai-governance-klinicka-prax-nefrologia`             |      7 |   3 635 / 3 635 | 0                                                       |
| `automatizovane-podavanie-inzulinu-dm2-dialyza`      |      5 |   2 576 / 2 576 | 0                                                       |
| `cetp-inhibicia-obicetrapib-lipidy-renalna-funkcia`  |      5 |   3 384 / 3 384 | 0                                                       |
| `nizkoenergeticka-dieta-cvicenie-remisia-dm2-reset`  |      5 |   2 572 / 2 574 | Druhý výskyt „Kritérium Hodnota“ v pokračovaní tabuľky. |
| `renin-aldosteron-dapagliflozin-spironolakton-hfpef` |      6 |   4 017 / 4 017 | 0                                                       |

### Metóda a vyhodnotenie rozdielov

HTML sa spracovalo ako dáta, bez vykonania PHP, JavaScriptu alebo načítania
externých zdrojov. Porovnáva sa celý viditeľný text vrátane popiskov, tabuliek,
zoznamov a bibliografie. Desatinné číslovanie zoznamov sa doplnilo podľa
`ol`, `start` a `li value`, pretože v HTML nie je uložené ako bežný text.
Nepodporovaný typ číslovania bráni výsledku `PASS`.

Prvý konzervatívny priechod pred týmto zohľadnením a s predvoleným poradím
extrakcie zachytil 116 skupín rozdielov. [Pôvodný výsledok](evidence/2026-10-18-pdf-text-baseline.json)
zostáva zachovaný. Príčinami boli najmä čítanie viacriadkových buniek tabuľky
po vodorovných riadkoch, automatické čísla zoznamov a odstránenie spojovníkov
na koncoch riadkov extraktorom.

Kontrolný priechod použil Poppler `pdftotext 25.07.0 -raw`, teda poradie
textových prvkov v PDF, a explicitné číslovanie HTML zoznamov. Normalizuje sa
Unicode NFC a biele znaky. Zachováva sa veľkosť písmen, diakritika, číslice,
interpunkcia a matematické znamienka. Nepoužíva sa prah podobnosti ani
všeobecné odstraňovanie duplicitných slov. Oddeľuje sa iba overená hlavička,
metadáta, zdrojová pätička a očakávané poradové číslo na konci každej strany.
Rozdiely v medzerách zostávajú priznané: normalizované reťazce nie sú úplne
znakovo zhodné ani pri štyroch PDF so zhodnými tokenmi.

[Strojový výsledok kontrolného priechodu](evidence/2026-10-18-pdf-content.json)
je **`PARTIAL`**, pretože prísne porovnanie ponechalo opakovanú hlavičku RESET.
[Samostatné posúdenie](evidence/2026-10-18-pdf-content-assessment.json)
ju vysvetľuje konkrétnym dôkazom:

- jediný rozdiel tvorí vloženie dvoch tokenov „Kritérium Hodnota“;
- HTML zdroja obsahuje túto hlavičku v `thead` raz; SHA-256 celého HTML po
  normalizácii koncov riadkov na LF je zhodný s HTML načítaným z obnovenej DB;
- výstup `pdftotext -bbox` ju lokalizuje na stranách 1 a 2 v rovnakých stĺpcoch
  (`xMin` približne 48,14 a 157,18 bodu), druhýkrát hore na strane 2;
- po zohľadnení výhradne tohto doloženého opakovania je zvyšok celej sekvencie
  tokenov RESET zhodný. Neodstraňovala sa žiadna veta, hodnota ani citácia.

Reprodukcia prísneho porovnania, bez zmeny vstupov:

```bash
python3 tools/restore/run.py \
  --files scratch/restore-recovered-assets-20261018 \
  --sql /cesta/k/povodnej-db-zalohe.zip \
  --pdf-content-bundle scratch/restore-recovered-assets-20261018 \
  --file-image nefro-restore-consistency-php \
  --report scratch/novy-pdf-content-report.json
```

Vyžaduje Docker, lokálny integračný obraz a `pdftotext` v PATH. Report musí
mať novú cestu. Očakávaný prísny výsledok tejto dvojice vstupov je `PARTIAL`,
nie chyba obnovy; vysvetlenie opakovanej hlavičky sa posudzuje osobitne.
Pri kombinácii kontrol vždy platí poradie `FAIL` > `PARTIAL` > `PASS`;
textové `PARTIAL` nikdy nezmierni aplikačné `FAIL`. Pokrýva to regresná skúška.
Regresná brána navyše kontroluje zmenu čísla, negácie, diakritiky, dátumu a
matematického znamienka, zachovanie zlomku v obsahu a odmietnutie cudzieho
titulu. Syntetická skúška extrakcie používa riadenú náhradu `pdftotext`;
skutočné PDF sa overili samostatným vyššie uvedeným priechodom.

**Hranice dôkazu:** ide o zhodu extrahovaného textového obsahu s doloženým
rozdielom sadzby, nie bajtovú alebo vizuálnu zhodu dokumentov. Neoverovali sa
pixely a úplnosť obrázkov, vzhľad tabuliek, kreslené vzorce, funkčnosť cieľov
odkazov, PDF prístupnosť ani medicínska správnosť citovaných tvrdení. Výsledok
nepotvrdzuje spoločný historický bod záloh, RPO/RTO ani neskorší stav produkcie.
PDF, články, pôvodné zálohy a produkcia sa nemenili. Predchádzajúce dôkazy
aplikačného správania a dešifrovania sa touto textovou skúškou nerozširujú.

## Vizuálna úplnosť, ilustrácie a odkazy piatich PDF

Dokončená je aj vizuálna kontrola všetkých 28 strán pomocou renderov Poppler
pri 110 dpi. Text, ilustrácie a tabuľky sú čitateľné; pri tejto kontrole sa
nenašiel chýbajúci obrázok, viditeľne orezaná tabuľka ani prekrytie textu.
Opakovanie hlavičky tabuľky RESET na strane 2 je správnym pokračovaním tabuľky.
Pri článku o riadení UI zostala strana 7 takmer prázdna: obsahuje iba zdrojovú
poznámku a číslo strany. Je to nedostatok stránkovania, nie strata obsahu.

[Nový strojový výsledok](evidence/2026-10-18-pdf-assets.json) a
[záznam vizuálnej kontroly](evidence/2026-10-18-pdf-visual-review.json)
rozširujú predchádzajúce overenie bez jeho prepísania. HTML sa znovu čítalo
z izolovane obnovenej DB, pretože samotné súčasné zdrojové skripty štyroch
článkov nemajú zhodný hash s uloženým HTML. Nezamieňali sa za obnovenú DB.

Každé PDF obsahuje jednu ilustráciu 1600 × 1000. Vložený obrázok je JPEG,
obnovený zdroj WebP; bajtová zhoda sa preto netvrdí. Pri porovnaní dekódovaných
RGB pixelov je priemerná absolútna odchýlka približne 1,56 až 2,13 z 255.
Rozmery a vizuálny obsah zodpovedajú príslušným zdrojovým ilustráciám.
Strojový verdikt pri každom neidentickom RGB obraze zostáva
`REQUIRES_VISUAL_REVIEW`, aj pri malej alebo zaokrúhlene nulovej odchýlke;
samotná zhoda rozmerov ani nízka priemerná odchýlka nepotvrdzuje zhodu obsahu.
Geometrická kontrola nenašla slová ani obrázky mimo hraníc strán; sama osebe
nenahrádza vizuálnu kontrolu prekrytia alebo čitateľnosti.

| PDF                                                  | Strany | Webové anotácie | Absolútne lokálne anotácie |
| ---------------------------------------------------- | -----: | --------------: | -------------------------: |
| `ai-governance-klinicka-prax-nefrologia`             |      7 |              10 |                          7 |
| `automatizovane-podavanie-inzulinu-dm2-dialyza`      |      5 |               5 |                          7 |
| `cetp-inhibicia-obicetrapib-lipidy-renalna-funkcia`  |      5 |              18 |                          6 |
| `nizkoenergeticka-dieta-cvicenie-remisia-dm2-reset`  |      5 |               5 |                          7 |
| `renin-aldosteron-dapagliflozin-spironolakton-hfpef` |      6 |               9 |                          8 |

Všetkých 47 webových anotácií smeruje na ciele uložené v príslušných článkoch.
Zvyšných 35 anotácií tvorí 5 odkazov na ilustrácie a 30 na súvisiace články.
Ich verejné koncové cesty zodpovedajú HTML, ale samotné PDF ich ukladá ako
absolútne lokálne súbory typu `Launch`. Také odkazy závisia od cudzieho
súborového systému a nie sú funkčne rovnocenné webovým URL pre čitateľa.
Absolútne cesty sa do dôkazov neukladajú. Zdrojová URL v záverečnej poznámke
je obyčajný text; jej prípadná neklikateľnosť sa nezamieňa za chýbajúcu
anotáciu HTML odkazu.

**Celkový výsledok zostáva `PARTIAL`.** Obsah a ilustrácie sú vo vyššie
uvedenom rozsahu overené, ale problém prenositeľnosti lokálnych odkazov
a osamotená záverečná poznámka zostávajú otvorené. PDF ani generátor sa
v tomto overení nemenili. Následná oprava má vytvoriť nové pracovné PDF,
previesť verejné relatívne odkazy na HTTPS URL a upraviť stránkovanie pätičky;
potom zopakovať textové, obrazové, odkazové a vizuálne porovnanie. Pôvodné
zálohy a doložené vstupné PDF zachovať.

Reprodukcia strojovej kontroly: k predchádzajúcemu príkazu pridať
`--pdf-asset-review` a zvoliť novú cestu reportu. Voliteľný režim vyžaduje
PyMuPDF a Pillow na hostiteľovi; ich prítomnosť sa overuje pred obnovou.
Relatívne HTML odkazy sa pri porovnaní identít riešia voči verejnej URL
článku, takže kontrola rozpozná aj následnú opravu na HTTPS. Percentuálne
kódovanie URI sa plošne nedekóduje: zakódovaný oddeľovač parametra musí zostať
odlíšený od skutočného oddeľovača. Regresie chránia oba tieto prípady aj
odmietnutie odlišného obrázka s rovnakými rozmermi bez vizuálneho posúdenia.
Regresná brána bez týchto voliteľných závislostí kontroluje čítanie HTML
odkazov, dekódovanie entít a nezverejnenie privátnych častí lokálnej cesty.
Skutočná extrakcia obrázkov a anotácií sa preverila nad piatimi pôvodnými PDF.

**Zostávajúce hranice:** neuskutočnili sa HTTP požiadavky na ciele odkazov,
neoverili sa presmerovania, prihlasovanie, platený obsah ani správanie rôznych
PDF prehliadačov. Render nie je skúška tlače ani audit PDF/UA. Nevykonalo sa
nové overovanie medicínskych tvrdení, historického spoločného bodu obnovy
alebo RPO/RTO. Archívy, doplnené PDF, obrázky a produkcia zostali nezmenené.

## Oprava nových pracovných PDF, 18. október 2026

V samostatnom odvodenom balíku je opravených 35 lokálnych anotácií: všetkých
82 odkazov teraz používa HTTPS a ich ciele zodpovedajú obnovenému HTML.
Päť odkazov smeruje na ilustrácie, 30 na súvisiace články. Nezostala žiadna
anotácia Launch ani chýbajúci či neočakávaný cieľ.

Pri článku o riadení klinickej UI sa pôvodná vektorová zdrojová poznámka
presunula zo samostatnej siedmej strany na koniec šiestej. Čísla strán sú
aktualizované na 1/6 až 6/6; pre číslice sa použil font Helvetica, pretože
opätovné použitie pôvodného podmnožinového fontu pri prvom náhľade nevykreslilo
číslice správne. Tento nevyhovujúci medzivýstup nie je finálnym balíkom.
Finálny balík má spolu 27 strán.

**Výsledok požadovanej opravy: PASS.** Úplný extrahovaný text všetkých piatich
PDF je po odstránení overených čísel strán a normalizácii Unicode a medzier
zhodný so vstupom. Bajty vložených obrázkov sú zhodné. Všetkých 27 finálnych
strán bolo vizuálne skontrolovaných pri 110 dpi bez zisteného prekrytia,
orezania alebo nečitateľných čísel. Pri 21 stranách je render pixelovo zhodný.
Pri šiestich stranách riadenia UI sa mení číslovanie a pri poslednej aj
poznámka. Opätovný zápis obsahových prúdov pri odstránení starých čísel navyše
zmenil vyhladenie 96 pixelov v tele strany 2 a 49 pixelov na strane 5;
príslušné miesta boli vizuálne skontrolované, text sa nezmenil.

Izolovaná obnova pôvodnej DB a kontrola nového balíka znovu overili 37 tabuliek,
144 649 riadkov, zhodný inventár a schému. Kontajnery nemali sieť ani zverejnené
porty a po skúške boli odstránené. Kontrolné súčty vstupných aktív a DB archívu
zostali zhodné. Produkcia ani pôvodné PDF a zálohy sa nemenili.

Všeobecný porovnávač stále oprávnene vracia **PARTIAL**: RESET opakuje hlavičku
pokračujúcej tabuľky a JPEG vložený v pôvodnom PDF nemá identické RGB pixely
so zdrojovým WebP. Tieto známe obmedzenia sa neprepisujú na PASS; samostatný
výsledok opravy vychádza aj z úplnej zhody textu a obrázkov pred/po úprave
a vizuálnej kontroly. Neoverovala sa HTTP dostupnosť cieľov, presmerovania,
prihlásenie, rôzne PDF prehliadače, tlač ani PDF/UA. Nevzniklo nové overenie
medicínskych tvrdení ani historického spoločného bodu obnovy či RPO/RTO.

Dôkazy: [strojová kontrola DB a PDF](evidence/2026-10-18-working-pdf-check.json)
a [porovnanie opravy vrátane kontrolných súčtov](evidence/2026-10-18-working-pdf-repair.json).
Finálne pracovné súbory sú mimo Git a publikovaných PDF v lokálnom adresári
`scratch/restore-repaired-20261018/final/`; `output/` je vyradený medzivýstup.

Reprodukcia vyžaduje PyMuPDF, Pillow, Poppler a pôvodný doplnený balík:

```powershell
py tools/restore/repair_working_pdfs.py --source <vstupny-balik> --output <novy-pracovny-balik>
py tools/restore/run.py --files <novy-pracovny-balik> --sql <povodny-db-archiv> --pdf-content-bundle <novy-pracovny-balik> --pdf-asset-review --file-image nefro-restore-consistency-php --report <novy-report.json>
```

Nástroj odmieta existujúci výstupný adresár, neznáme ciele, odlišný počet
lokálnych anotácií aj nebezpečné alebo duplicitné cesty v manifeste. Očakáva
presne päť auditovaných PDF a päť ilustrácií. Nie je všeobecným generátorom PDF;
pri odlišnom rozložení sa má zastaviť a vyžadovať novú kontrolu.
