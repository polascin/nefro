# Deploy – nefro.polascin.net

Predvolený spôsob nasadenia je lokálny SFTP hook (`hooks/post-commit`,
`hooks/post-merge`, `hooks/deploy.sh`). Hooky sa zapájajú cez
`pwsh -File ./hooks/install.ps1` a `core.hooksPath=hooks`.

GitHub Actions (`.github/workflows/deploy.yml`) vždy vykonajú validáciu.
Produkčný job beží iba pri repository variable `NEFRO_DEPLOY_MODE=actions`;
pri chýbajúcej alebo inej hodnote sa preskočí aj po manuálnom spustení workflow.
V režime Actions sa po pushi do `main` alebo cez **Run workflow** repozitár
zosynchronizuje rsyncom do web rootu na WebSupport.
Súbory vylúčené v `.deployignore` sa nenasadzujú; `--delete` sa nepoužíva,
takže serverové súbory mimo repozitára zostávajú nedotknuté. Push s
`[skip deploy]` v commit message deploy preskočí.

Samotná prítomnosť secrets nestačí na zapnutie produkčného jobu. Stav nasadenia
over podľa vykonaných krokov konkrétneho behu, nie podľa zeleného výsledku
validácie alebo historického dátumu konfigurácie.

Pred prepnutím na Actions vypni lokálne nasadzovanie cez strojovú konfiguráciu
`NEFRO_DEPLOY_MODE=actions` v lokálnom deploy env súbore. Potom nastav rovnomennú
repository variable. Pri návrate na SFTP postupuj opačne: najprv vypni Actions,
počkaj na dokončenie rozbehnutých jobov a až potom znovu povoľ lokálny deploy. Over drift
a synchronizuj PDF až po dokončení všetkých nasadení.

## Prevádzkové signály a zálohy

Verejné odpovede kontroluje denne workflow `.github/workflows/ops-monitor.yml`
(HTTP 200, jediný `<title>`, bez PHP chýb a úniku cesty, hlavičky CSP a HSTS,
interné cesty 403/404). Beží bez secrets; zlyhanie behu oznámi GitHub podľa
notifikácií účtu. Serverovú časť pokrýva `php ops_health.php` (CLI): vek
najstaršej čakajúcej položky vo frontoch newslettera a právnych oznámení,
zlyhania za 24 h, vek logu retenčného cronu, produkčný marker a tie isté
verejné kontroly; `--mail` pošle agregované upozornenie na `SMTP_ADMIN_EMAIL`
pri výsledku FAIL. Záznamy bez osobných údajov sa pripájajú do
`private/logs/ops_health.log`. Odporúčaný cron: denne po behu workerov.

Aplikačnú zálohu s transakčným snapshotom DB vytvára `php backup_snapshot.php`:
SQL dump v jednej transakcii s konzistentným snapshotom a tar adresárov mimo
gitu (`pdf`, `img`, `uploads`, `private/publications`) v tom istom behu,
s manifestom, počtami riadkov a SHA-256. DB a súbory vznikajú postupne;
spoločná konzistencia sa musí overiť pri obnove. Prázdna, vynechaná alebo
chybná časť znamená neúplnú zálohu a nesmie spustiť retenciu. Snapshoty sú v `private/backups/`,
predvolená retencia sú dva kompletné snapshoty (jeden snapshot zaberá približne
1,7 GB). Odporúčaný cron: denne po zálohe poskytovateľa. Obnova a overenie
podľa `tools/restore/README.md`. Zápis cron úloh na serveri je produkčný zásah,
ktorý vyžaduje samostatné rozhodnutie vlastníka.

## Povinné regresie

Pred nasadením musí prejsť izolovaná sada podľa
[`tools/integration/README.md`](tools/integration/README.md). Actions deploy čaká
na regresný job; SFTP čaká na úspešný CI workflow presného HEAD. Pri nedostupnom
GitHub CLI/API sa produkčný upload nevykoná. `--dry-run` a `--remote-commit`
zostávajú čitateľné bez tejto brány. Pri chránenej vetve používaj pracovnú vetvu
a pull request, nie neoverený priamy push na `main`.

## UPSERT zmenených článkov

Rsync nahrá `add_<slug>_article.php`, ale obsah v databáze sa zmení až jeho
spustením. Workflow preto po rsyncu spustí cez SSH každý **upravený**
(`--diff-filter=M`) `add_*_article.php` z daného pushu a potom
`generate_all_article_pdfs.php --stale`.

**Nové články (`--diff-filter=A`) sa zámerne nespúšťajú.** Pri prvom vložení
šablóna rozosiela newsletter avízo a to nesmie spustiť CI bez dozoru — nový
článok publikuj ručne podľa [PUBLIKOVANIE_CLANKOV.md](PUBLIKOVANIE_CLANKOV.md).
Pri úprave existujúceho článku sa avízo neposiela (`rc === 2`), takže
automatický UPSERT je bezpečný.

## GitHub Secrets (Settings → Secrets and variables → Actions)

| Secret               | Popis                                                                   |
| -------------------- | ----------------------------------------------------------------------- |
| `DEPLOY_HOST`        | SSH host, napr. `shell.r1.websupport.sk`                                |
| `DEPLOY_USER`        | SSH používateľ, napr. `uid58858`                                        |
| `DEPLOY_PORT`        | SSH port (WebSupport shell používa `26650`; predvolené `22`)            |
| `DEPLOY_SSH_KEY`     | Celý obsah privátneho SSH kľúča                                         |
| `DEPLOY_KNOWN_HOSTS` | Host key servera (`ssh-keyscan -p <port> <host>`), formát `[host]:port` |
| `DEPLOY_REMOTE_PATH` | `/data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro` |

Fingerprint z `ssh-keyscan` over aj nezávisle u poskytovateľa hostingu.

`DEPLOY_SSH_KEY` je **samostatný CI kľúč** `nefro-ci-github-20260911`
(ED25519, `SHA256:tELE+ZdlFIgmYxTY1dkdhQucbI6ulFOT7O6ji6XKxs8`), nie osobný
kľúč `nefro-deploy-20260519` používaný lokálnym hookom. Privátna časť existuje
len v GitHub secrets, lokálna kópia bola po nastavení zmazaná. **Rotácia:**
vygeneruj nový pár, pridaj verejnú časť do `~/.ssh/authorized_keys` na serveri,
prepíš secret a zmaž starý riadok — lokálny prístup tým nie je dotknutý.
Záloha pôvodného súboru je na serveri ako `~/.ssh/authorized_keys.bak-20260911`.

Súbežné nasadzovanie cez SFTP a Actions nie je bezpečná záloha: rsync môže
prepísať novšie serverové PDF a UPSERT ho môže opäť regenerovať počas synchronizácie.
Beh 128 tento rozdiel potvrdil porovnaním SHA-256. Používaj jeden režim.
Hooky neodinštalúvaj mazaním `.git/hooks/post-commit`; projekt používa `hooks/`
cez `core.hooksPath` a validácia musí zostať zapnutá.
