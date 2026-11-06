# TODO

## Slučky PAUSED (2026-11-06)

Denný doaudit (1d) a RSI ~20m loop sú **PAUSED**. Nespúšťať, kým majiteľ
neobnoví. Tento beh novú slučku nespustil.

## Po odblokovaní (nie teraz)

1. BLOCKED: rebase + zlúčenie `fix/gupta-mg-cutoff-2026-11-03` (Mg &lt; 0,82 mmol/L) s pinom.
2. BLOCKED: rebase + zlúčenie `fix/adpkd-mayo-2026-11-03` (Mayo %/rok) s aktualizáciou golden pinu `adpkdClassify`.
3. Čaká na majiteľa: limity korekcie hyponatrémie v calculator_na.php (Beh 153).
4. Čaká na majiteľa: CRRT bez korekcie predilúcie a bez citácie KDIGO (Beh 157).
5. Čaká na majiteľa: IgAN koeficienty nezodpovedajú opísanému modelu (Beh 158).
6. Voliteľné: dirty worktree `expert-article-review-social-9d76d4` (mimo main).

## Hotové: close-WIP 2026-11-06 (pauza)

- [x] Overenie `calculatorEkfcModeLabel` na main; clinical 134 PASS
- [x] Dobehnutie deployu `28bcf11e` → `f695d7aa` (Git Bash + Windows PHP; WSL mbstring FAIL)
- [x] RSI: ADPKD/Gupta merge odložené (DECISIONS)
- [x] SESSION/handoff: PAUSED; loop nespustený

## Hotové: slučka 2026-11-06-s (calculatorEkfcModeLabel)

- [x] `ekfcModeLabel` → `calculatorEkfcModeLabel` v common; pin; suite 56 PASS; deploy `f695d7aa`

## Hotové: slučka 2026-11-06-r (adpkdClassify)

- [x] `adpkdClassify` → `calculators_common`; golden pin 7 scenárov + 4 hranice k + wiring; clinical 127 PASS; suite 56 PASS; deploy `28bcf11e`

## Hotové: slučka 2026-11-06-q (CKD-PC label helpery)

- [x] `boolLabel`/`sexLabel`/`smokingLabel` → `calculatorBool/Sex/SmokingLabel` v common; pin + wiring; CKD-PC/CKM 53 PASS; suite 56 PASS; deploy `e8ae58c6`

## Hotové: slučka 2026-11-06-p (iganRisk pin)

- [x] `iganRisk` → `calculators_common`; golden pin 8 scenárov + koeficienty; wiring; clinical 116 PASS; suite 56 PASS; deploy `715c6dcc`

## Hotové: slučka 2026-11-06-o (iganInterpretation)

- [x] `iganInterpretation` → `calculators_common`; pin pásiem 5/15/40 + wiring; `iganRisk` lokálne; clinical 107 PASS; suite 56 PASS; deploy `36c6541b`

## Hotové: slučka 2026-11-06-n (adpkdInterpretation)

- [x] `adpkdInterpretation` → `calculators_common`; pin 1A–1E + wiring; `adpkdClassify` lokálne; clinical 101 PASS; suite 56 PASS; deploy `f947f90b`

## Hotové: slučka 2026-11-06-m (kfreInterpretation)

- [x] `kfreInterpretation` → `calculators_common`; pin pásiem 3–5 / >5 / 10 / 40 + wiring; clinical 93 PASS; suite 56 PASS; deploy `98753a08`

## Hotové: slučka 2026-11-06-l (ckdpcInterpretation)

- [x] `ckdpcInterpretation` → `calculators_common`; pin pásiem 5/10/20 + wiring; CKD-PC/CKM 42 PASS; suite 56 PASS; deploy `2a00246a`

## Hotové: slučka 2026-11-06-k (ckmStageClass)

- [x] `ckmStageClass` → `calculators_common`; pin + správanie; CKD-PC/CKM 40 PASS; suite 56 PASS; deploy `5110a7f9`

## Hotové: slučka 2026-11-06-j (ParseNonNeg)

- [x] Lokálne `*ParseNonNeg` + `kdpiParseNonNeg` → `calculatorParseNonNegativeFloat`; CRRT empty→0; suite 56 PASS; deploy `e676e53b`

## Hotové: slučka 2026-11-06-i (kreatinín µmol ↔ mmol)

- [x] `CREATININE_UMOL_PER_MMOL` + helpery; AKI + CrCl; units 199 PASS; urine 24 PASS; deploy `a165e6d1`

## Hotové: slučka 2026-11-06-h (UACR albumín g/L → mg/L)

- [x] `MASS_CONC_GL_TO_MGL` + helpery; UACR; units 193 PASS; clinical 87 PASS; scores 26 PASS; deploy `e6a7bd6c`

## Hotové: slučka 2026-11-06-g (UACR albumín mg/dL → mg/L)

- [x] `massConcGdlToGl` v UACR; units 187 PASS; clinical 85 PASS; scores 26 PASS; deploy `600e2f50`

## Hotové: slučka 2026-11-06-f (eGFR ml/min ↔ ml/s)

- [x] `EGFR_ML_MIN_TO_ML_S` + helpery; prevodník + egfr/cys/ekfc; units 185 PASS; scores 26 PASS; deploy `d8adc96c`

## Hotové: slučka 2026-11-06-e (Hb/Alb)

- [x] `MASS_CONC_GDL_TO_GL` + helpery; Gupta + prevodník; units 172 PASS; scores 26 PASS; deploy `135590d9`

## Hotové: slučka 2026-11-06-d (bilirubín)

- [x] `BILIRUBIN_MGDL_TO_UMOLL` + `BILIRUBIN_UMOLL_TO_MGDL` + helpery; units 162 PASS; scores 26 PASS; deploy `3807b84a`

## Hotové: slučka 2026-11-06-c (triglyceridy)

- [x] `TRIGLYCERIDES_MGDL_TO_MMOLL` + `TRIGLYCERIDES_MMOLL_TO_MGDL` + helpery; units 153 PASS; scores 26 PASS; deploy `33814da9`

## Hotové: slučka 2026-11-06-b (cholesterol)

- [x] `CHOLESTEROL_MGDL_TO_MMOLL` + `CHOLESTEROL_MMOLL_TO_MGDL` + helpery; PREVENT; units 145 PASS; scores 26 PASS; deploy `64712578`

## Hotové: slučka 2026-11-06-a (kyselina močová)

- [x] `URIC_ACID_MGDL_TO_UMOLL` + `URIC_ACID_UMOLL_TO_MGDL` + helpery; units 136 PASS; scores 26 PASS; deploy `2f5ea0cb`

## Hotové: slučka 2026-11-05-o (magnézium)

- [x] `MAGNESIUM_MGDL_TO_MMOLL` + `MAGNESIUM_MMOLL_TO_MGDL` + helpery; units 128 PASS; scores 26 PASS; deploy `c7a18acd`

## Hotové: slučka 2026-11-05-n (fosfát)

- [x] `PHOSPHATE_MGDL_TO_MMOLL` + `PHOSPHATE_MMOLL_TO_MGDL` + helpery; units 120 PASS; scores 26 PASS; deploy `b576b78f`

## Hotové: slučka 2026-11-05-m (vápnik)

- [x] `CALCIUM_MGDL_TO_MMOLL` + `CALCIUM_MMOLL_TO_MGDL` + helpery; units 112 PASS; scores 26 PASS; deploy `55f1d254`

## Hotové: slučka 2026-11-05-l (glukóza)

- [x] `GLUCOSE_MGDL_TO_MMOLL` + `GLUCOSE_MMOLL_TO_MGDL` + helpery; units 104 PASS; sodium 31 PASS; deploy `e34dc727`

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
