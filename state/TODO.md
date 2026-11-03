# TODO

## Ďalšia slučka

1. Voliteľne `requestRequireScalarPost` na ďalšie POST formuláre bez poľových polí
   (forgot/reset, zvyšné admin mutácie), kde ešte ostáva surový `trim($_POST)`.
2. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.
3. Voliteľne clinical refs pre CKD-PC / CKM (samostatný súbor).

## Hotové: slučka 2026-11-03 (request-input + PREVENT)

- [x] Windows fixture pre `requestRequireScalarPost` (odblokoval deploy Behu 138)
- [x] `profile.php` skalárny guard
- [x] PREVENT v `test_clinical_references.php` (80 PASS)
- [x] deploy `84d61269`; bez claim/lease ENUM

## Hotové: CI regression fix (2026-11-02)

- [x] `.dockerignore` `!/.htaccess` (provider script deny v Dockeri)
- [x] PHPStan: clinical G páry, author PDO, providers note
- [x] Restore: `request_input.php` vo fixture; self_test `--no-verify`
- [x] Lokálne integration PASS; GH Actions 41382755429 success (`1ed7f45d`)
- [x] bez claim/lease ENUM

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
