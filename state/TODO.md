# TODO

## Ďalšia slučka

1. Zjednotiť glukózový faktor `0.0555` na konštantu/helper, alebo P1 mimo „Čaká na majiteľa“.
2. Čaká na majiteľa: limity korekcie hyponatrémie v calculator_na.php (Beh 153).
3. Čaká na majiteľa: CRRT bez korekcie predilúcie a bez citácie KDIGO (Beh 157).
4. Čaká na majiteľa: zlúčenie `fix/adpkd-mayo-2026-11-03` (Beh 158).
5. Čaká na majiteľa: IgAN koeficienty nezodpovedajú opísanému modelu (Beh 158).
6. Čaká na majiteľa: zlúčenie `fix/gupta-mg-cutoff-2026-11-03` (Beh 159).

## Hotové: slučka 2026-11-05-k (BUN/urea)

- [x] `BUN_MGDL_TO_UREA_MMOLL` + `UREA_MMOLL_TO_BUN_MGDL` + helpery; units 96 PASS; deploy `792c16ce`

## Hotové: slučka 2026-11-05-j (MW kreatinínu)

- [x] `CREATININE_MOLAR_MASS_G_PER_MOL` + creatinineMmolLToGL; UACR bez 113.12; units 87 PASS; deploy `8c5348a8`

## Hotové: slučka 2026-11-05-i (UACR helpery)

- [x] `UACR_MG_G_PER_MG_MMOL` + uacrToMgG; 5 súborov; units 81 PASS; deploy `69906449`

## Hotové: slučka 2026-11-05-h (kreatinín helpery)

- [x] `CREATININE_UMOL_PER_MGDL` + MgDl⇄Umol/Mmol helpery; 7 kalkulačiek; test 69 PASS; deploy `61b09a7f`

## Hotové: slučka 2026-11-05-g (prevodník)

- [x] `calculatorUnitConversionRows` + konverzie v calculators_common; test 53 PASS; deploy `8108f319`

## Hotové: slučka 2026-11-05-f (Mehran)

- [x] `mehranScore` v calculators_common + test 24 PASS; deploy `a9e99f84`

## Hotové: slučka 2026-11-05-e (alkalóza)

- [x] Javaheri 0,7 · HCO₃ + 20 ± 5 v calculators_common + test 42 PASS; deploy `8d5793b8`

## Hotové: slučka 2026-11-05-d (Winters)

- [x] Wintersova rovnica v calculators_common + test 31 PASS; deploy `e1606d38`

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
