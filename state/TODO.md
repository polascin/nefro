# TODO

## Ďalšia slučka

1. Voliteľne doplniť ďalšie `source_authors.php` (manuálna DOI↔téma).
2. Voliteľne: CSRF/`$_POST` skaláre na auth stránkach cez `requestScalarString`.
3. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.
4. Voliteľne: P1 klinické referenčné testy.

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

## Hotové v slučke 13

- [x] list helper `requestStringList` / `calculatorPostStringList` (ambulatory)
- [x] +10 source_authors (Crossref, DOI↔téma, ≤40 autorov)
- [x] request_input 81 PASS; parity 172; deploy `d5f6466f`
- [x] bez claim/lease ENUM

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
