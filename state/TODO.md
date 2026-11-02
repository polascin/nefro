# TODO

## Ďalšia slučka

1. Voliteľne doplniť `source_authors.php` pre ~225 unmapped slugov (zníži cold I/O).
2. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.
3. Voliteľne: list helper ambulatory; P1 klinické referenčné testy.

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
