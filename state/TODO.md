# TODO

## Ďalšia slučka

1. Voliteľne doplniť ďalšie `source_authors.php` (manuálna DOI↔téma; často multi-zdroj).
2. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.
3. Voliteľne: P1 klinické referenčné testy.

## Hotové v slučke 13

- [x] list helper `requestStringList` / `calculatorPostStringList` (ambulatory)
- [x] +10 source_authors (Crossref, DOI↔téma, ≤40 autorov)
- [x] request_input 81 PASS; parity 172; deploy `d5f6466f`
- [x] bez claim/lease ENUM

## Hotové v slučke 12

- [x] 16 kurátorských source_authors (Crossref, DOI↔téma + DOI v obsahu)
- [x] Parity 172 PASS (mapped=56); regresie
- [x] Changelog + deploy `00d99f49`
- [x] bez claim/lease ENUM

## Hotové v slučke 11

- [x] 14 kurátorských source_authors (Crossref/PubMed, single-source)
- [x] Parity 172 PASS + regresie
- [x] Changelog + deploy `4827eb75`
- [x] bez claim/lease ENUM

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
