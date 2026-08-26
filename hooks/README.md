# Git hooky a SFTP deploy

Repozitár používa verzované hooky priamo z adresára `hooks/`. Inštalácia nastaví
lokálny Git `core.hooksPath=hooks`, takže po pullnutí netreba kopírovať nové verzie
skriptov do `.git/hooks`.

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

1. `pre-commit` spustí `git diff --cached --check`, PHP syntax lint staged PHP
   súborov a konverziu nových PNG na WebP.
1. `post-commit` pushne aktuálnu vetvu na jej remote.
1. Až po úspešnom pushi `deploy.sh` nasadí cez SFTP všetky nasaditeľné zmeny od
   predchádzajúceho remote commitu po `HEAD`.
1. `deploy_info.php` sa odošle v rovnakom SFTP batchi ako ostatné súbory.

Ak push alebo SFTP zlyhá, hook vypíše chybu a deploy neoznačí ako úspešný.
Strojovo lokálne nastavenie sa číta z `~/.config/nefro/deploy.env`, takže Mac
a Windows môžu používať odlišné SSH identity bez synchronizácie cez repozitár.
Na Macu je v tomto súbore nastavený host `websupport` z `~/.ssh/config`.

## Priebeh pullu / mergu

`post-commit` sa viaže výlučne na **lokálny** `git commit`. Commit prijatý cez
GitHub PR merge + `git pull` ho teda nikdy nespustil a produkcia ticho driftovala
(PR #3 2026-07-24; PR #4 2026-08-25 — oprava právnych stránok ležala dva dni
v gite, kým `privacy.php`, `terms.php` a `cookies.php` vracali fatal error).

`post-merge` túto medzeru zatvára:

1. Squash merge preskočí (zmeny sú zatiaľ len v indexe, nie v `HEAD`).
1. Ak je vetva pred svojím upstreamom (merge commit z non-fast-forward pullu),
   najprv pushne; pri zlyhaní pushu produkciu nemení.
1. Bázu deployu zistí cez `deploy.sh --remote-commit`, teda z commitu, na ktorom
   produkcia **reálne** stojí. Dobehne tak aj drift nazbieraný skôr, nie len
   práve pullnuté commity. Ak sa server nepodarí osloviť (alebo hlási commit,
   ktorý lokálne neexistuje), padá na `ORIG_HEAD`.
1. Ak sa server rovná `HEAD`, nerobí nič.

Pozn.: `post-merge` nevzniká pri `git pull --rebase` — tam Git spúšťa
`post-rewrite`. Projekt má `pull.rebase=false`, takže bežný pull hook spustí.

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

# Commit, na ktorom stojí produkcia (číta vzdialený deploy_info.php)
hooks/deploy.sh --remote-commit
```

Súbory v `hooks/deploy-ignore.txt` sa nikdy neposielajú do verejného web rootu.
SSH cieľ, remote cestu a ignore súbor možno pre test prepísať premennými
`NEFRO_SFTP_TARGET`, `NEFRO_REMOTE_PATH` a `NEFRO_DEPLOY_IGNORE_FILE`. Pre spätnú
kompatibilitu sú podporované aj `NEFRO_SFTP_HOST`, `NEFRO_SFTP_PORT`,
`NEFRO_SFTP_USER` a `NEFRO_SFTP_KEY`. Iný konfiguračný súbor možno určiť
cez `NEFRO_DEPLOY_CONFIG`.

## Trunk

Trunk git-hook actions musia zostať vypnuté. Trunk podľa svojej dokumentácie pri
zapnutej action s Git triggerom automaticky preberie správu `core.hooksPath`, čím
by obišiel projektový push a deploy. Trunk kontroly sa spúšťajú ručne vo WSL.
