# TODO

## Ďalšia slučka

1. Voliteľne clinical refs pre CKD-PC / CKM (samostatný súbor).
2. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.
3. Admin POST: cielené skaláre len tam, kde nie sú úmyselné listové polia.

## Hotové: slučka 2026-11-03-b (auth scalar guards)

- [x] `requestRequireScalarPost` na login/forgot/reset/resend/confirm/admin_reauth
- [x] newsletter verify + unsubscribe
- [x] deploy `03c461fd`; bez claim/lease ENUM

## Hotové: slučka 2026-11-03 (request-input + PREVENT)

- [x] Windows fixture pre `requestRequireScalarPost`
- [x] `profile.php` skalárny guard
- [x] PREVENT v `test_clinical_references.php`
- [x] deploy `84d61269`; bez claim/lease ENUM

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
