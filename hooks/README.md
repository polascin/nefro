# Git hooky a SFTP deploy

Vývoj a nasadenie **nezávisia od GitHubu**. Overenie robí lokálna brána,
nasadenie ide priamo cez SFTP na WebSupport a vzdialené repozitáre slúžia len
ako zálohy. Repozitár používa verzované hooky priamo z adresára `hooks/`;
inštalácia nastaví lokálny Git `core.hooksPath=hooks`, takže po zmene netreba
kopírovať nové verzie skriptov do `.git/hooks`.

## Inštalácia

```powershell
pwsh -File .\hooks\install.ps1
```

Overenie:

```powershell
git config --local --get core.hooksPath
```

Výsledok musí byť `hooks`.

## Priebeh commitu

1. `pre-commit` spustí sken tajomstiev (ggshield), `git diff --cached --check`,
   PHP syntax lint staged súborov, vodoznak a konverziu nových PNG na WebP.
1. `post-commit` na vetve `main` zavolá `deploy.sh`. Báza nasadenia je commit,
   na ktorom stojí produkcia (`deploy.sh --remote-commit`), takže sa dobehne aj
   skorší nenasadený rozdiel.
1. `deploy.sh` pred uploadom spustí **lokálnu bránu** `hooks/local_gate.sh`:
   syntax všetkých PHP súborov, regresnú sadu `tools/run_regressions.php` a syntax
   JS sprievodcov. Brána odmietne, ak sa sledované PHP/JS súbory v pracovnom strome
   líšia od `HEAD` (overoval by sa iný kód, než aký sa nahrá).
1. Po prechode brány `deploy.sh` nahrá súbory z commitu (`git show HEAD:…`, nie
   z pracovného stromu) a v rovnakom SFTP batchi aj `deploy_info.php`.
1. Kroky po nasadení: UPSERT **upravených** `add_*_article.php` cez SSH
   a `generate_all_article_pdfs.php --stale`, potom smoke test `/`, `/privacy.php`
   a `/terms.php`. Nové články (pridané, nie upravené) sa zámerne nespúšťajú,
   lebo pri prvom vložení šablóna rozosiela newsletter avízo.
1. Až potom `post-commit` pushne vetvu do záloh. Zlyhanie zálohy (výpadok siete,
   ochrana vetvy na GitHube) produkciu neblokuje.

Commit na inej vetve sa nenasadzuje, len zálohuje. Na publikovanie stačí vetvu
zlúčiť do `main` (`git switch main && git merge <vetva>`); nasadenie spustí
`post-commit` (merge commit) alebo `post-merge` (fast-forward).

Kódy ukončenia `deploy.sh`: `0` hotovo, `1` brána alebo nasadenie zlyhali
(produkcia nezmenená), `3` súbory sú nasadené, ale zlyhal UPSERT, PDF alebo
smoke test.

### Zálohy (mirrors)

Zoznam remotov, do ktorých sa po commite pushuje, je v `git config nefro.mirrors`
(predvolene `server origin`; neexistujúce remoty sa preskočia).

- `server`: holý repozitár na WebSupporte mimo web rootu,
  `ssh://websupport/~/git/nefro.git` (alias z `~/.ssh/config`, kľúč cez
  `core.sshCommand` v lokálnom `.git/config`).
- `origin`: GitHub, ak ho chceš ponechať ako zrkadlo. Pokiaľ je `main` na GitHube
  chránená, push odmietne a hook to len oznámi.

Obnova z repozitára na serveri:

```bash
git clone ssh://websupport/~/git/nefro.git nefro
```

### Integračná sada v Dockeri

Rovnaká sada, akú predtým spúšťal GitHub ako „Regression gate“
(izolovaná MariaDB, HTTP testy, test nasadenia, záloha a obnova):

```bash
bash tools/integration/run.sh
```

Pri nasadení ju zapneš premennou `NEFRO_GATE_INTEGRATION=1` (trvá niekoľko minút).

### Návrat ku GitHub CI

`NEFRO_DEPLOY_GATE=github` v `~/.config/nefro/deploy.env` vráti pôvodné čakanie
na úspešný beh `deploy.yml` (`tools/wait_for_ci.php`). Predvolená hodnota je `local`.

Strojovo lokálne nastavenie sa číta z `~/.config/nefro/deploy.env`, takže Mac
a Windows môžu používať odlišné SSH identity bez synchronizácie cez repozitár.
Na Macu je v tomto súbore nastavený host `websupport` z `~/.ssh/config`.

## Priebeh mergu

`post-commit` sa viaže výlučne na lokálny `git commit`; fast-forward merge commit
nevytvára. `post-merge` túto medzeru zatvára:

1. Squash merge preskočí (zmeny sú zatiaľ len v indexe, nie v `HEAD`).
1. Bázu deployu zistí cez `deploy.sh --remote-commit`, teda z commitu, na ktorom
   produkcia **reálne** stojí. Ak sa server nepodarí osloviť (alebo hlási commit,
   ktorý lokálne neexistuje), padá na `ORIG_HEAD`.
1. Ak sa server rovná `HEAD`, nerobí nič; inak nasadí a potom pushne do záloh.

Pozn.: `post-merge` nevzniká pri `git pull --rebase`, tam Git spúšťa
`post-rewrite`. Projekt má `pull.rebase=false`.

## Kontrola driftu

```bash
# Na akom commite reálne stojí produkcia?
hooks/deploy.sh --remote-commit

# Porovnanie s lokálnym HEAD
test "$(hooks/deploy.sh --remote-commit)" = "$(git rev-parse --short HEAD)" && echo "v súlade" || echo "DRIFT"
```

## Manuálny deploy

```bash
# Iba ukáž plán posledného commitu
hooks/deploy.sh --dry-run

# Dohnanie všetkých zmien od konkrétneho commitu
hooks/deploy.sh <base-ref>

# Lokálna brána samostatne
bash hooks/local_gate.sh
```

Súbory v `hooks/deploy-ignore.txt` sa nikdy neposielajú do verejného web rootu.
SSH cieľ, remote cestu a ignore súbor možno pre test prepísať premennými
`NEFRO_SFTP_TARGET`, `NEFRO_REMOTE_PATH` a `NEFRO_DEPLOY_IGNORE_FILE`. Pre spätnú
kompatibilitu sú podporované aj `NEFRO_SFTP_HOST`, `NEFRO_SFTP_PORT`,
`NEFRO_SFTP_USER` a `NEFRO_SFTP_KEY`. Iný konfiguračný súbor možno určiť
cez `NEFRO_DEPLOY_CONFIG`. Izolovaný test podstrčí bránu cez `NEFRO_GATE_CMD`
a vypne kroky po nasadení cez `NEFRO_SKIP_POST_DEPLOY=1`.

## Monitoring

Prevádzkový stav kontroluje na serveri cron `ops_health.php --mail` (06:10,
pozri `tools/crontab.example`), vrátane verejných stránok. Workflow
`.github/workflows/ops-monitor.yml` je tým nadbytočný.

## Trunk

Trunk git-hook actions musia zostať vypnuté. Trunk podľa svojej dokumentácie pri
zapnutej action s Git triggerom automaticky preberie správu `core.hooksPath`, čím
by obišiel projektový deploy. Trunk kontroly sa spúšťajú ručne (`trunk check`).
