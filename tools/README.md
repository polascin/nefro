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

| Súbor                    | Účel                                                                   |
| ------------------------ | ---------------------------------------------------------------------- |
| `phpstan.neon.dist`      | PHPStan — úroveň 4 (postupne zvyšuj k 9), vylúčené generované adresáre |
| `phpstan-baseline.neon`  | zoznam ignorovaných existujúcich nálezov (regeneruje install skript)   |
| `.php-cs-fixer.dist.php` | PHP-CS-Fixer — konzervatívna sada nízkorizikových pravidiel            |

## Git hook

`hooks/pre-commit` robí pri každom commite rýchly `php -l` syntax check staged
PHP súborov. Hlbšiu analýzu (PHPStan/Fixer) spúšťaj ručne cez `quality.ps1`.

Inštalácia hookov: `.\hooks\install.ps1`

## Existujúci `tools/lint_all.php`

Prejde `php -l` cez **celý** projekt naraz (nie len staged) — užitočné na jednorazovú
revíziu: `php tools\lint_all.php`.

## Regresie platieb a dodania publikácií

```powershell
php tools\test_publication_stripe.php
php tools\test_publication_delivery.php
```

Testy používajú SQLite v pamäti a CLI SMTP stub; neotvárajú Checkout,
nevykonávajú platbu ani neposielajú živú poštu. Stripe test počíta priamo
volania SMTP: prvé potvrdenie úhrady odošle jednu správu, opakované potvrdenie
žiadnu ďalšiu a samostatné opätovné dodanie jednu ďalšiu. Pridané druhé volanie
`sendPublicationOrderDeliveryEmail()` pri prvom potvrdení musí test odmietnuť.

## Trunk (len vo WSL)

V repe je `.trunk/trunk.yaml` pre Gitleaks, Prettier, Markdownlint,
ShellCheck/Shfmt, Yamllint a Taplo. **Trunk NEBEŽÍ natívne na Windows**
(`Failed to resolve Windows dependencies`), preto sa spúšťa vo **WSL2**:

```powershell
# raz: nainštaluj WSL2 + Ubuntu (PowerShell ako admin), reštart ak treba
wsl --install -d Ubuntu
```

```bash
# v Ubuntu termináli (WSL):
curl https://get.trunk.io -fsSL | bash      # raz: inštalácia Trunku
cd /mnt/d/Dev/nefro
trunk upgrade --dry-run  # skontroluje aktualizácie bez zmeny configu
trunk check --all        # plný sken; bez --all len zmenené súbory
trunk fmt --all          # formátovanie podporovaných súborov
```

- **PHP kvalita:** natívne na Windowse funguje `quality.ps1` / PHAR (vyššie).
- **Git hooky:** `pwsh -File .\hooks\install.ps1` nastaví verzovaný adresár
  `hooks/`. Trunk actions s Git hook triggerom musia zostať vypnuté, aby
  neprepísali projektový pre-commit, push a SFTP deploy.
- **Spoločný index Windows/WSL:** pred prvým behom spusti na Windowse
  `pwsh -File .\hooks\install.ps1`. Inštalátor zjednotí `core.autocrlf=true`,
  nastaví `core.checkStat=minimal`, `core.trustctime=false` a `core.fsmonitor=false`.
  Tým sa obmedzí opakované čítanie nezmenených súborov pri striedaní oboch Gitov.
  Nastavenia platia iba pre tento checkout. `.gitattributes` určuje LF pre shell skripty
  aj Markdown, YAML, JSON a TOML, aby Prettier lokálne videl rovnaké súbory ako v CI.
  Ak Trunk hlási „single player mode“ alebo ignoruje `.trunk/trunk.yaml`, spusti
  `trunk config share`. Odstráni staré lokálne ignorovanie už verzovanej konfigurácie.
- **Pozn. (výkon/EOL):** repo na `/mnt/d/...` je vo WSL pomalšie (9p FS); pri `trunk fmt`
  sleduj prípadný CRLF↔LF šum (git má `autocrlf`).

## Izolované regresie a integračné CI

Brána zahŕňa aj syntetickú skúšku obnovy. Postup pre existujúce zálohy,
výsledok čiastkovej skúšky a jej obmedzenia opisuje
[návod obnovy](restore/README.md).

Celú sadu spustí `bash tools/integration/run.sh`; postup a hranice overenia sú
v [integračnom návode](integration/README.md). Rýchle samostatné testy spustí
`php tools/run_regressions.php`. Povinný CI job vykonáva aj PHPStan a testy nad MariaDB.
