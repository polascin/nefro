# TODO

## Ďalšia slučka

1. Voliteľne doplniť ďalšie `source_authors.php` (~195 unmapped; manuálna DOI↔téma).
2. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.
3. Voliteľne: list helper ambulatory; P1 klinické referenčné testy.

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

## Hotové v slučke 10

- [x] EXPLAIN + meranie (492 pub., filter ~811 ms → warm ~157 ms)
- [x] hydrate unmapped + author_index cache (`author_index_v1`)
- [x] parity regresia + deploy `288b01e6`
- [x] bez index migrácie (dôkaz: nízka selektivita)

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
