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

## Manuálny deploy

```bash
# Iba ukáž plán posledného commitu
hooks/deploy.sh --dry-run

# Dohnanie všetkých zmien od konkrétneho commitu
hooks/deploy.sh <base-ref>
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
