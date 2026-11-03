# TODO

## Ďalšia slučka

1. P1 klinické referencie: plasmic, kdpi, tls, egfr_slope (vzor Beh 151 až 153).
2. Čaká na majiteľa: limity korekcie hyponatrémie v calculator_na.php (Beh 153).

## Hotové: slučka 2026-11-03-o (CrCl 24 h, nátrium)

- [x] Vzorce v calculators_common + test 28 PASS; deploy `b3e0f4df`

## Hotové: slučka 2026-11-03-n (CG, recirkulácia, voľná voda)

- [x] Vzorce v calculators_common + test 25 PASS; deploy `c4eddcc2`

## Hotové: slučka 2026-11-03-m (Kt/V, nPCR)

- [x] Vzorce v calculators_common + test 25 PASS; deploy `9a1861e7`

## Hotové: slučka 2026-11-03-l (skalárne superglobály)

- [x] admin/profile/refresh_article cez request* helpery + regresia
- [x] PHPStan 0; deploy `effbd221`

## Hotové: slučka 2026-11-03-k (legal claim/lease)

- [x] Port claim/lease do legal_notifications
- [x] Migrácia ENUM sending; ops_health; reclaim regresia
- [x] deploy `d4f12dcf`; produkčná migrácia

## Hotové: slučka 2026-11-03-j … a

- [x] cron sync + newsletter sending; a11y; scalar; clinical refs

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- `provider_notice_worker --send` (nie cron).
