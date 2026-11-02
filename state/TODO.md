# TODO

## Ďalšia slučka

1. Voliteľne PREVENT / ďalšie riziko-modely ako samostatný clinical ref súbor.
2. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.
3. Voliteľne zvyšné `source_authors` bez spoľahlivého single DOI (nízka priorita).

## Hotové: CI regression fix (2026-11-02)

- [x] `.dockerignore` `!/.htaccess` (provider script deny v Dockeri)
- [x] PHPStan: clinical G páry, author PDO, providers note
- [x] Restore: `request_input.php` vo fixture; self_test `--no-verify`
- [x] Lokálne integration PASS; GH Actions 41382755429 success (`1ed7f45d`)
- [x] bez claim/lease ENUM

## Hotové v slučke 18

- [x] `calculator_ekfc_logic.php` + UACR/Mehran v `calculators_common`
- [x] `test_clinical_references.php` (KFRE/EKFC/UACR/G/Mehran, 56 PASS)
- [x] regressions 38; deploy `2a5164ea`
- [x] bez claim/lease ENUM

## Hotové v slučke 17

- [x] GET request_input na studia/objednavka/download/result_print
- [x] spoločný CKD-EPI 2021 + referenčný regresný test
- [x] request_input 95 PASS; regressions 37; deploy `07dea5e1`
- [x] bez claim/lease ENUM; source_authors DOI low-hanging vyčerpané

## Hotové v slučke 16

- [x] `requestCsrfTokenFromPost` + auth/admin CSRF skaláre
- [x] +4 source_authors (Manghi, Heerspink, Chadban, Reis-Neto)
- [x] request_input 87 PASS; parity 172; deploy `532db34f`
- [x] bez claim/lease ENUM

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
