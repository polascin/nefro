# TODO

## Ďalšia slučka

1. Rozšíriť P1 klinické referenčné testy (EKFC, KFRE, PREVENT, Mehran, …).
2. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.
3. Voliteľne zvyšné `source_authors` bez spoľahlivého single DOI (nízka priorita).

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

## Hotové v slučke 15

- [x] `index.php` page/autor cez request_input
- [x] +12 source_authors
- [x] deploy `a5aa91e6`

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
