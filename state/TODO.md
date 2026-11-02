# TODO

## Ďalšia slučka

1. Voliteľne: P1 klinické referenčné testy (inventár vzorcov / referenčné príklady).
2. Voliteľne doplniť zvyšné `source_authors` (safe DOI kandidáti takmer vyčerpaní).
3. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.

## Hotové v slučke 16

- [x] `requestCsrfTokenFromPost` + auth/admin CSRF skaláre
- [x] +4 source_authors (Manghi, Heerspink, Chadban, Reis-Neto)
- [x] request_input 87 PASS; parity 172; deploy `532db34f`
- [x] bez claim/lease ENUM

## Hotové v slučke 15

- [x] `index.php` page/autor cez request_input
- [x] +12 source_authors (Crossref, DOI↔téma, ≤40 autorov)
- [x] request_input 84 PASS; parity 172; deploy `a5aa91e6`
- [x] bez claim/lease ENUM

## Hotové v slučke 14

- [x] `formats[]` cez `requestStringList` v `publikacia.php`
- [x] +13 source_authors (Crossref, DOI↔téma, ≤40 autorov)
- [x] request_input 82 PASS; parity 172; deploy `576a20ba`
- [x] bez claim/lease ENUM

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
