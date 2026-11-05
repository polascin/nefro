# TODO

## Ďalšia slučka

1. `php tools/test_a11y_form_alerts.php` (alebo prvý FAIL); PHPStan new / live smoke / ops; Wintersova kompenzácia mimo aktuálnej AG kalkulačky.
2. Čaká na majiteľa: limity korekcie hyponatrémie v calculator_na.php (Beh 153).
3. Čaká na majiteľa: CRRT bez korekcie predilúcie a bez citácie KDIGO (Beh 157).
4. Čaká na majiteľa: zlúčenie `fix/adpkd-mayo-2026-11-03` (Beh 158).
5. Čaká na majiteľa: IgAN koeficienty nezodpovedajú opísanému modelu (Beh 158).
6. Čaká na majiteľa: zlúčenie `fix/gupta-mg-cutoff-2026-11-03` (Beh 159).

## Hotové: slučka 2026-11-05-c (AG / Figge / ΔΔ)

- [x] Logika v calculators_common + test 21 PASS; deploy `23b0ffe1`

## Hotové: slučka 2026-11-05-b (eGFR Cr–Cys)

- [x] Vzorec v calculators_common + test 27 PASS; deploy `fc543a83`

## Hotové: slučka 2026-11-05 (MGRS + KDRI)

- [x] Logika v calculators_common + testy 11+26 PASS; deploy `a6c6b4b1`

## Hotové: slučka 2026-11-03-v (MGUS)

- [x] Logika v calculators_common + test 16 PASS; deploy `3c118c65`

## Hotové: slučka 2026-11-03-u (textové citácie)

- [x] 23 citácií overených, 3 tituly opravené, register; deploy `623953eb`

## Hotové: slučka 2026-11-03-t (PubMed odkazy)

- [x] 12 odkazov overených, MGRS opravený; check tool + offline register; deploy `3d09b657`

## Hotové: slučka 2026-11-03-s (CRRT)

- [x] Výpočet v calculators_common + test 16 PASS; deploy `bcffbf85`

## Hotové: slučka 2026-11-03-r (Furst, FENa, FEurea)

- [x] Vzorce v calculators_common + test 24 PASS; deploy `1a601bdc`

## Hotové: slučka 2026-11-03-q (sklon eGFR, vápnik)

- [x] Vzorce v calculators_common + test 21 PASS; deploy `7a70938a`

## Hotové: slučka 2026-11-03-p (PLASMIC, TLS)

- [x] Logika v calculators_common + test 26 PASS; deploy `143687e2`

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
