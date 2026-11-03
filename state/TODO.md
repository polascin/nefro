# TODO

## Ďalšia slučka

1. Cielené skaláre v admin POST bez multi-selectov
   (`admin_reauth` už hotové; zvyšok bez `formats[]` a pod.).
2. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.

## Hotové: slučka 2026-11-03-c (CKD-PC/CKM clinical refs)

- [x] `tools/test_clinical_references_ckdpc_ckm.php` + regressions.json
- [x] 37 PASS; suite 39; deploy marker bez zmeny (iba tools)
- [x] bez claim/lease ENUM

## Hotové: slučka 2026-11-03-b (auth scalar guards)

- [x] `requestRequireScalarPost` na login/forgot/reset/resend/confirm/admin_reauth
- [x] newsletter verify + unsubscribe
- [x] deploy `03c461fd`; bez claim/lease ENUM

## Hotové: slučka 2026-11-03 (request-input + PREVENT)

- [x] Windows fixture; profile; PREVENT refs; deploy `84d61269`

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
