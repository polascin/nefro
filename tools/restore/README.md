# Izolovaná skúška obnovy

Nástroj obnoví existujúcu súborovú zálohu a SQL/SQL.gz/ZIP do jednorazových
kontajnerov. Nespúšťa portál, migrácie, cron, newsletter, SMS ani platby.
Nepoužíva produkčnú konfiguráciu, prihlasovacie údaje ani sieťové DB spojenie.

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
Zhoda s aktívnym produkčným kľúčom a dešifrovanie údajov nie sú overené.

[Skutočná DB obnova](evidence/2026-10-18-production-db.json) bola overená
v samostatnej predchádzajúcej skúške. Terajší beh používa `--files-only`;
DB neimportoval znova. SQL, konfigurácia ani obsah archívu nie sú v repozitári.
Starší chybný EPUB z čiastkovej zálohy zostáva historickým nálezom;
kontrolované dokumenty úplného archívu prešli.

DB záloha z 18. 10. 2026 o 03:21:13 a súborová záloha z predchádzajúceho dňa
netvoria preukázaný spoločný konzistentný bod obnovy. Na uzavretie úplnej
obnoviteľnosti systému zostáva overiť väzby DB na súbory, aplikačné správanie,
dešifrovanie a prevádzkový postup vrátane oprávnení. RPO ani RTO celého systému
nie sú potvrdené. Produkčná obnova sa nespúšťala.

_Primárny zdroj: [Websupport: Zálohy databáz](https://www.websupport.sk/podpora/kb/zalohy-databaz/), overené 18. 10. 2026. Všeobecný opis služby nepotvrdzuje dostupnosť konkrétnej zálohy Nefro._
