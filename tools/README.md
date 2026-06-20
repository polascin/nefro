# Lokálne vývojárske nástroje

Kontrola kvality PHP kódu **bez Composera** — nástroje sa sťahujú ako samostatné
PHAR súbory (sú v `.gitignore`, na server sa nedeployujú).

## Inštalácia (raz)

```powershell
.\tools\install-dev-tools.ps1
```

Stiahne `phpstan.phar` + `php-cs-fixer.phar` do `tools/` a vygeneruje
`phpstan-baseline.neon` (existujúce nálezy sa ignorujú → hlásia sa len NOVÉ chyby).

## Každodenné použitie

```powershell
.\tools\quality.ps1          # PHPStan analýza + náhľad formátovania (nič nemení)
.\tools\quality.ps1 -Fix     # aplikuje opravy formátovania (PHP-CS-Fixer)
```

Alebo priamo:

```powershell
php tools\phpstan.phar analyse --no-progress
php tools\php-cs-fixer.phar fix --dry-run --diff
```

## Konfigurácia

| Súbor | Účel |
|-------|------|
| `phpstan.neon.dist` | PHPStan — úroveň 4 (postupne zvyšuj k 9), vylúčené generované adresáre |
| `phpstan-baseline.neon` | zoznam ignorovaných existujúcich nálezov (regeneruje install skript) |
| `.php-cs-fixer.dist.php` | PHP-CS-Fixer — konzervatívna sada nízkorizikových pravidiel |

## Git hook

`hooks/pre-commit` robí pri každom commite rýchly `php -l` syntax check staged
PHP súborov. Hlbšiu analýzu (PHPStan/Fixer) spúšťaj ručne cez `quality.ps1`.

Inštalácia hookov: `.\hooks\install.ps1`

## Existujúci `tools/lint_all.php`

Prejde `php -l` cez **celý** projekt naraz (nie len staged) — užitočné na jednorazovú
revíziu: `php tools\lint_all.php`.

## Trunk (voliteľné, len vo WSL)

V repe je `.trunk/trunk.yaml` (meta-linter: gitleaks, prettier MD/JSON/YAML,
markdownlint, shellcheck/shfmt, yamllint, taplo + PHPStan/PHP-CS-Fixer cez existujúce
konfigy). **Trunk NEBEŽÍ natívne na Windows** (`Failed to resolve Windows
dependencies`) — jeho lintre sú Linux/macOS binárky. Treba ho spúšťať vo **WSL2**:

```powershell
# raz: nainštaluj WSL2 + Ubuntu (PowerShell ako admin), reštart ak treba
wsl --install -d Ubuntu
```

```bash
# v Ubuntu termináli (WSL):
curl https://get.trunk.io -fsSL | bash      # raz: inštalácia Trunku
cd /mnt/d/OneDrive/www/nefro
trunk upgrade        # zladí verzie cli/plugins/lintrov (spusti ako prvé)
trunk check --all    # plný sken; bez --all len súbory zmenené oproti merge-base
trunk fmt            # formátovanie MD/JSON/YAML
```

- **PHP kvalita aj bez Trunku:** natívne na Windowse funguje `quality.ps1` / PHAR
  (vyššie) — Trunk je len doplnková jednotná vrstva pre nestPHP súbory a tajomstvá.
- **Git hooky** (pre-commit `php -l`, post-commit SFTP deploy) zostávajú na Windows
  strane; Trunkove hooky sú v configu zámerne vypnuté. Commit/deploy rob v PowerShelli,
  `trunk check`/`trunk fmt` vo WSL.
- **Pozn. (výkon/EOL):** repo na `/mnt/d/...` je vo WSL pomalšie (9p FS); pri `trunk fmt`
  sleduj prípadný CRLF↔LF šum (git má `autocrlf`).
