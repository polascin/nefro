# Register organizačných dôkazov súladu

Aktualizované: 2026-10-12. Tento register je pracovný dôkazný index, nie právne stanovisko.
Každá položka rozlišuje medzi implementovanou technickou kontrolou a externým dokumentom,
ktorý musí byť uchovaný mimo verejného webu.

| Oblasť | Dôkaz alebo kontrola | Stav | Preskúmanie |
| --- | --- | --- | --- |
| Záznamy o spracovateľských činnostiach | `legal_data.php`, mapa kategórií, účelov, príjemcov a retencie | implementované, vyžaduje ročné vecné preskúmanie | 2027-10-12 |
| Newsletterový súhlas | `newsletter_consent_audit` uchováva text, verziu, zdroj, čas, udelenie a odvolanie; `archive_cleanup.php` vynucuje štyri roky od odvolania | implementované v kóde; produkčná schéma sa musí overiť po migrácii | po každom deployi schémy |
| Digitálny obsah | Objednávka eviduje obe vyhlásenia a verziu podmienok; potvrdzovací e-mail reprodukuje ich text a čas | implementované | pri každej zmene podmienok |
| Oznámenia obsahu podľa DSA | `content_report.php`, `content_notices`, rozhodnutie a odôvodnenie v `admin_content_notices.php` | implementované v kóde; produkčná schéma sa musí overiť po migrácii | štvrťročne |
| Retencia | `archive_cleanup.php`, produkčný cron a `private/archive_cleanup_cron.log` | technická kontrola implementovaná; log kontrolovať mesačne | mesačne |
| Incidenty a porušenia ochrany údajov | Interný register incidentov, posúdenie rizika, čas zistenia, rozhodnutie o oznámení úradu a dotknutým osobám | externý dôkaz sa v repozitári nenachádza, treba viesť v chránenom úložisku | po incidente a ročne |
| Dodávatelia a prenosy | Aktuálne DPA, SCC, zoznam subdodávateľov, transfer impact assessment a doklad o platnom mechanizme prenosu | nemožno preukázať z repozitára, treba uchovať zmluvné dôkazy | polročne |
| DPIA a roly pri zdravotných údajoch | Kalkulačky nie sú určené na starostlivosť o pacienta; používateľ nesmie zadávať údaje inej osoby | technické upozornenie implementované; právne posúdenie zostáva potrebné, ak sa účel alebo prax zmení | pred každou zmenou účelu |
| Bezpečnostné kontroly | PHPStan, lint, regresné testy, CSP, CSRF, session hardening, rate limiting a auditné logy | implementované | pri každom audite |
| Mikropodnik a prístupnosť | Jeden pracovník, nulový obrat a začiatok podnikania bez uzavretej bilancie podľa vyhlásenia podnikateľa z 2026-10-12 | predbežná klasifikácia; prehodnotiť po prvej závierke a pri raste | najneskôr 2027-10-12 |

## Povinný balík mimo repozitára

- podpísané zmluvy so sprostredkovateľmi a ich aktuálne prílohy,
- SCC a transfer impact assessments pri prenosoch mimo EHP,
- register incidentov a rozhodnutí o oznamovaní,
- vybavené žiadosti dotknutých osôb a dôkaz lehôt,
- ročné posúdenie statusu mikropodniku,
- zápis o preskúmaní účelov kalkulačiek a zákaze použitia pri starostlivosti o pacienta,
- exporty rozhodnutí o oznámeniach nezákonného obsahu a odoslaných odôvodnení.

Chýbajúci externý dôkaz sa nesmie v audite označiť ako splnený iba preto, že právny text
obsahuje príslušné tvrdenie.
