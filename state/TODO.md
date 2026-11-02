# TODO

## Ďalšia slučka

1. Voliteľne doplniť ďalšie `source_authors.php` (stále ~211+ unmapped; len single-source).
2. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.
3. Voliteľne: list helper ambulatory; P1 klinické referenčné testy.

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

## Hotové v slučke 9

- [x] request_input / calculatorPost* na kalkulačky POST
- [x] ambulatory: complications[] a diagnózy ako polia
- [x] changelog + deploy `00d04fc7`

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
