# Deploy – nefro.polascin.net

Automatické nasadenie cez GitHub Actions (`.github/workflows/deploy.yml`):
po každom pushi do `main` (alebo manuálne cez **Actions → Deploy → Run
workflow**) sa repozitár zosynchronizuje rsyncom do web rootu na WebSupport.
Súbory vylúčené v `.deployignore` sa nenasadzujú; `--delete` sa nepoužíva,
takže serverové súbory mimo repozitára zostávajú nedotknuté. Push s
`[skip deploy]` v commit message deploy preskočí.

Secrets sú nastavené od **2026-09-11**, deploy je teda aktívny. Dovtedy sa
deploy job iba preskakoval s upozornením a nasadzoval výhradne lokálny SFTP
hook.

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

| Secret               | Popis                                                                |
| -------------------- | -------------------------------------------------------------------- |
| `DEPLOY_HOST`        | SSH host, napr. `shell.r1.websupport.sk`                              |
| `DEPLOY_USER`        | SSH používateľ, napr. `uid58858`                                      |
| `DEPLOY_PORT`        | SSH port (WebSupport shell používa `26650`; predvolené `22`)          |
| `DEPLOY_SSH_KEY`     | Celý obsah privátneho SSH kľúča                                       |
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

Lokálny SFTP hook (`hooks/deploy.sh`) zostáva funkčný ako záložný spôsob.
Po zapnutí Actions deployu **nasadzuje každý lokálny commit dvakrát** (hook
cez SFTP hneď, Actions cez rsync o ~1 min). Nie je to škodlivé (`--delete` sa
nepoužíva, rsync je idempotentný), ale je to zbytočné — hook možno odinštalovať
odstránením `post-commit` z `.git/hooks/`.
