# Izolované integračné testy a povinná CI brána

## Spustenie

Potrebný je Docker Engine s Compose a Bash. PHP, Node.js, MariaDB a Mailpit
bežia v kontajneroch, hostiteľské PHP ani produkčné prístupy sa nepoužívajú.

```bash
bash tools/integration/run.sh
```

Windows PowerShell s Git for Windows:

```powershell
& 'C:/Program Files/Git/bin/bash.exe' tools/integration/run.sh
```

Skript vytvorí samostatný projekt, pripraví certifikát, spustí databázu a aplikáciu,
počká na pripravenosť, vykoná kontroly a odstráni iba svoj projekt vrátane jeho
zväzkov. MariaDB ukladá testovacie dáta do dočasnej pamäte. Žiadny port sa
nepublikuje na hostiteľa. Nepoužívaj `docker system prune` ani cudzí Compose projekt.

## Dôkaz izolácie

- Build používa zoznam povolených zdrojových súborov v `.dockerignore`.
  Produkčné INI, privátne súbory, uploady, PDF, git a pracovné adresáre sa nekopírujú.
- `NEFRO_ENV_PATH` ukazuje výhradne na `tools/integration/app.ini`.
  Explicitný chýbajúci alebo chybný súbor nesmie načítať inú konfiguráciu.
- Guard vyžaduje kontajner, presnú konfiguráciu, databázu `nefro_integration`,
  účet `nefro_test`, natívne PDO, lokálny Mailpit a logovací SMS provider.
- Sieť Compose je `internal: true`. Guard navyše overí, že spojenie na externú
  kontrolnú IP nie je možné. Build sťahuje verejné balíky; testy internet nepotrebujú.
- MariaDB, PHP, Node a Mailpit sú pripnuté digestom; PHPStan verziou a SHA-256.
  Aktualizáciu pinov treba vykonať vedome a opäť overiť celý beh.
- SMTP používa STARTTLS s kontrolou mena a certifikátu. Čerstvý testovací
  certifikát je dôveryhodný iba v testovacích kontajneroch, kontrola TLS sa nevypína.
- E-mailové adresy používajú `example.invalid`, účty a výsledky sú syntetické.
  Fixture prihlasovacie údaje sú verejné testovacie hodnoty, nie prevádzkové tajomstvá.
- SMS sa neposielajú operátorovi. Používa sa existujúci vývojový provider `log`.
  Pri zlyhaní sa vypisujú iba logy testovacej aplikácie a Mailpitu.

[Dokumentácia internej siete Compose](https://docs.docker.com/reference/compose-file/networks/)
a [TLS konfigurácie Mailpitu](https://mailpit.axllent.org/docs/configuration/smtp/).

## Čo kontroluje sada

`tools/regressions.json` je spoločný zoznam všetkých `tools/test_*.php` a
`tools/test_*.mjs`. Runner odmietne chýbajúci, duplicitný alebo neplatný záznam
a skončí nenulovo pri prvej chybe. Každý PHP test beží v samostatnom procese
s vlastnou neprodukčnou konfiguráciou.

Kontajnerová sada vykoná syntax PHP a vlastného JS, všetky regresie, PHPStan
s existujúcou nezmenenou baseline a integračné testy. Negatívna skúška vloží
v jednorazovom kontajneri test s návratovým kódom 42 a overí, že runner zlyhá;
manifest aj súbor následne obnoví. Chýbajúci záverečný úspešný marker integračného
testu tiež znamená zlyhanie, aj keby endpoint omylom ukončil proces kódom 0.

Integračná časť pokrýva natívny MariaDB FULLTEXT, resend, overenie e-mailu,
newsletter a explicitný súhlas, reset a jeho replay, login/CSRF, profil,
SMS hashovanie a uloženie stavu, oddelenie výsledkov dvoch účtov vrátane HTTP,
vymazanie vlastného výsledku, rate limit pri rozdielnych časových pásmach PHP a DB a platené sťahovanie so správnym,
nesprávnym a nezaplateným tokenom.

Portál používa externé Stripe Payment Links a manuálne potvrdenie platby;
nemá Stripe API ani webhook. Test preto vytvorí objednávku a synteticky potvrdí
úhradu v izolovanej DB. Nevykonáva reálnu platbu ani Stripe sandbox transakciu.
Tvorbu Stripe odkazov kontroluje existujúci regresný test. Rovnako nejde o
integračný test siete Twilio, klinickú validáciu alebo test Apache `.htaccess`.
Testovací HTTP router povoľuje iba potrebné aplikačné trasy a testovacie súbory blokuje.

## Povinné CI a vydanie

- `regressions.yml` je zdieľaný job `Regression gate`, bez produkčných secrets.
- `branch-regressions.yml` ho spúšťa pre pracovné vetvy, pull requesty a merge queue.
- `deploy.yml` ho spúšťa na `main`; produkčný Actions job vyžaduje úspešnú
  syntax aj regresie. Žiadny filter ciest nemôže preskočiť požadovanú kontrolu.
- SFTP deploy pred prvým zápisom čaká cez GitHub CLI na úspešný push workflow
  presného HEAD. Starší zelený commit, zlyhanie, zrušenie, preskočenie,
  nedostupné API alebo vypršanie limitu nasadenie nepovolí. Dry-run a čítanie
  produkčného markeru túto čakaciu bránu nepotrebujú.
- Na `main` má byť požadovaná úspešná kontrola `regressions / Regression gate`
  z GitHub Actions aj pre administrátora, bez force push a mazania vetvy.
  Aktuálne uplatnenie over cez GitHub branch protection API, nie iba podľa YAML.

Po zapnutí ochrany pracuj na vetve `codex/...`, nechaj prejsť CI a integruj
cez pull request. Priamy push neovereného nového commitu na `main` sa odmietne.
Ochranu ani hooky kvôli tomu nevypínaj. Po merge a pulli lokálny hook počká na
CI nového `main` commitu a až potom vykoná SFTP deploy.
