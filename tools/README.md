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
