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
Vstupom je existujúci adresár zálohy bez symlinkov a existujúci SQL/SQL.gz/ZIP súbor.
Archív súborov najprv bezpečne rozbaľte do samostatného lokálneho adresára,
nikdy do pracovnej kópie alebo produkčného adresára. Pôvod, čas vytvorenia
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

Každý dátový `tmpfs` má limit 768 MiB. Väčšie zálohy potrebujú osobitný plán.
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

## Čo chýba na uzavretie

Sprístupniť úplnú súborovú zálohu a overiť jej časovú nadväznosť na DB zálohu. Poskytovateľ uvádza DB zálohy vo Webadmine v sekcii Databázy/Zálohy.
Po prihlásení používateľa sa konkrétna DB záloha našla a používateľ ju stiahol.
[Výsledok skutočnej DB obnovy](evidence/2026-10-18-production-db.json) potvrdzuje
import, kontrolu tabuliek aj opakovanú obnovu. SQL obsah sa do repozitára neukladá.
Nestláčať obnovu na pôvodnú databázu ani do produkčného adresára; zálohu
treba iba stiahnuť na izolovanú skúšku. Pri súboroch sa našiel termín 17. 10. 2026
(15:10); pripravená žiadosť sa týka iba adresára projektu Nefro. Doručovací
kontakt dopĺňa používateľ priamo u poskytovateľa. Príprava ani stiahnutie
celého súborového archívu zatiaľ nie sú potvrdené.

Úplná súborová záloha musí pokrývať aj publikácie a uploady mimo Gitu
a osobitne chránenú konfiguráciu a šifrovací kľúč. Konfiguráciu ani kľúč
nepoužiť ako aktívnu konfiguráciu aplikácie v tomto nácviku. Dešifrovanie
treba následne preveriť samostatne, izolovane a bez výpisu údajov.
Poškodený EPUB nahradiť až v novej overenej zálohe; pôvodný dôkaz zachovať.

_Primárny zdroj: [Websupport: Zálohy databáz](https://www.websupport.sk/podpora/kb/zalohy-databaz/), overené 18. 10. 2026. Všeobecný opis služby nepotvrdzuje dostupnosť konkrétnej zálohy Nefro._
