# Register závislostí

Aktualizované: 20. 10. 2026 (plán rozvoja, etapa 2: register závislostí).
Strojový register s SHA-256 každého súboru je v `tools/dependencies.json`;
kontroluje ho `tools/test_dependency_register.php` v povinnej regresnej bráne,
takže zmena dodanej knižnice bez aktualizácie registra zastaví CI.

```bash
php tools/dependency_register.php --check    # overí hashe a pokrytie
php tools/dependency_register.php --update   # prepočíta hashe po aktualizácii knižnice
```

Projekt nemá Composer ani npm závislosti za behu; všetky knižnice sú dodané
v repozitári (vendored) alebo ide o nástroje a služby mimo kódu.

## Dodané knižnice (v repozitári)

| Knižnica         | Verzia                                     | Pôvod                                                           | Licencia | Použitie                                          | Oznámenia                                                               |
| ---------------- | ------------------------------------------ | --------------------------------------------------------------- | -------- | ------------------------------------------------- | ----------------------------------------------------------------------- |
| KaTeX            | 0.18.11                                    | npm registry, tarball s overenou SHA-512 integritou             | MIT      | `head_meta.php` (vzorce v článkoch), 78 súborov   | [GitHub advisories](https://github.com/KaTeX/KaTeX/security/advisories) |
| qrcode.js        | minifikovaná distribúcia (hash v registri) | [davidshimjs/qrcodejs](https://github.com/davidshimjs/qrcodejs) | MIT      | `2fa_setup.php`, `objednavka.php` (PAY by square) | GitHub Advisory Database (npm `qrcodejs`); upstream nemá vlastný kanál  |
| Inter (variable) | Fontsource build, latin + latin-ext        | [Fontsource](https://fontsource.org/fonts/inter)                | OFL 1.1  | `index.css` `@font-face`                          | bez bezpečnostných oznámení, sleduje sa iba integrita                   |

## Vývojové nástroje (mimo gitu, PHAR)

| Nástroj      | Verzia | Pôvod                                                                    | Licencia | Aktualizácia                                             |
| ------------ | ------ | ------------------------------------------------------------------------ | -------- | -------------------------------------------------------- |
| PHPStan      | 2.2.2  | [GitHub releases](https://github.com/phpstan/phpstan/releases)           | MIT      | `tools/install-dev-tools.ps1`, potom `--update` registra |
| PHP CS Fixer | 3.95.7 | [GitHub releases](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/releases) | MIT      | `tools/install-dev-tools.ps1`, potom `--update` registra |

PHAR súbory sú v `.gitignore`; register ich eviduje ako `optional`: ak chýbajú,
kontrola ich preskočí, ak existujú, hash musí sedieť.

## Pripnuté nástroje CI a izolovaného prostredia

| Zložka                         | Pin                                                                                                                                                                                  | Kde                              |
| ------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | -------------------------------- |
| PHP (integračný kontajner)     | `php:8.5.8-cli-bookworm` podľa digestu                                                                                                                                               | `tools/integration/Dockerfile`   |
| Node (integračný kontajner)    | `node:22-bookworm-slim` podľa digestu                                                                                                                                                | `tools/integration/Dockerfile`   |
| MariaDB (integračný kontajner) | `mariadb:11.4.13` podľa digestu                                                                                                                                                      | `tools/integration/compose.yaml` |
| Mailpit                        | `axllent/mailpit:v1.31.6` podľa digestu                                                                                                                                              | `tools/integration/compose.yaml` |
| Trunk CLI a lintery            | `cli 1.25.0`; gitleaks 8.30.1, markdownlint 0.49.1, prettier 3.9.10, shellcheck 0.11.0, shfmt 3.14.1, taplo 0.10.0, yamllint 1.38.0; runtimes go 1.25.0, node 22.16.0, python 3.14.4 | `.trunk/trunk.yaml`              |
| GitHub Actions                 | `actions/checkout@v5`, `trunk-io/trunk-action@v1` (pin na major tag)                                                                                                                 | `.github/workflows/*.yml`        |

Akcie sú pripnuté na hlavnú verziu (tag), nie na commit SHA; prísnejšie pripnutie
na SHA je možné zlepšenie, treba ho však udržiavať pri každej aktualizácii akcie.

## Služby a prostredie mimo repozitára

| Zložka                 | Stav                                                                   | Kontrola                                                  |
| ---------------------- | ---------------------------------------------------------------------- | --------------------------------------------------------- |
| PHP na produkcii       | verzia hostingu WebSupport; lokálne a v CI 8.5.8                       | `php -v` cez SSH pri audite                               |
| MariaDB na produkcii   | spravuje hosting                                                       | `SELECT VERSION()` pri audite                             |
| wkhtmltopdf            | 0.12.6 na serveri (bez WebP, preto PNG fallback v `pdf_generator.php`) | `wkhtmltopdf --version` cez SSH                           |
| SMTP, SMS poskytovateľ | konfigurácia v `private/nefro.env.ini`                                 | `tools/integration` používa náhrady, nie produkčné služby |

## Postup aktualizácie knižnice

1. Stiahnuť novú verziu z primárneho zdroja a overiť integritu (npm `dist.integrity`,
   release checksum alebo podpis).
2. Nahradiť súbory v `assets/…`, upraviť odkazy v kóde (`head_meta.php`, `index.css`).
3. Spustiť príslušný regresný test (`node tools/test_katex.mjs`, ručná kontrola QR).
4. `php tools/dependency_register.php --update`, doplniť verziu a pôvod v
   `tools/dependencies.json` a v tejto tabuľke.
5. `php tools/run_regressions.php`; zmena ide cez pull request a povinné CI.

Pri bezpečnostnom oznámení k dodanej knižnici posúdiť, či je zraniteľná cesta
v portáli vôbec dosiahnuteľná (napr. KaTeX beží s `trust: false` a limitmi
rozširovania), a výsledok posúdenia zapísať do `.audit.md`.
