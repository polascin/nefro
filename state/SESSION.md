# SESSION

Aktualizované: 2026-11-06 02:34 Europe/Bratislava

## Aktívna úloha

Beh: UACR albumín g/L → mg/L cez `MASS_CONC_GL_TO_MGL` / `massConcGlToMgl`. Handoff:
`.codex/handoffs/2026-11-06-023400-uacr-albumin-gl-mgl.md`.

## Stav repozitária

- Vetva: `main` (HEAD `8f49c948`; feature `e6a7bd6c`)
- Runtime / `DEPLOY_COMMIT`: `e6a7bd6c` (docs-only drift po handoffe OK)
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Čo je hotové

1. Beh 150 až 163 + slučka tick 2: AG / Figge / ΔΔ
2. Slučka tick 3: a11y 35 PASS; Wintersova rovnica + test 31 PASS
3. Slučka tick 4: regresie 54 PASS; alkalóza Javaheri + test 42 PASS
4. Slučka tick 5: PHPStan 0; Mehran `mehranScore` + test 24 PASS; suite 55 PASS
5. Slučka tick 6: ops_health WARN OK; prevodník `calculatorUnitConversionRows` + test 53 PASS; suite 56 PASS
6. Slučka tick 7: `CREATININE_UMOL_PER_MGDL` + helpery; 7 stránok bez inline 88,4; units 69 PASS; suite 56 PASS
7. Slučka tick 8: `UACR_MG_G_PER_MG_MMOL` + `uacrToMgG`; 5 súborov bez inline 8,84; units 81 PASS; suite 56 PASS
8. Slučka tick 9: `CREATININE_MOLAR_MASS_G_PER_MOL` + `creatinineMmolLToGL`; bez inline 113,12; units 87 PASS; suite 56 PASS
9. Slučka tick 10: `BUN_MGDL_TO_UREA_MMOLL` + `UREA_MMOLL_TO_BUN_MGDL` + helpery; units 96 PASS; suite 56 PASS
10. Slučka tick 11: `GLUCOSE_MGDL_TO_MMOLL` + `GLUCOSE_MMOLL_TO_MGDL` + helpery; units 104 PASS; sodium 31 PASS; suite 56 PASS
11. Slučka tick 12: `CALCIUM_MGDL_TO_MMOLL` + `CALCIUM_MMOLL_TO_MGDL` + helpery; units 112 PASS; scores 26 PASS; suite 56 PASS
12. Slučka tick 13: `PHOSPHATE_MGDL_TO_MMOLL` + `PHOSPHATE_MMOLL_TO_MGDL` + helpery; units 120 PASS; scores 26 PASS; suite 56 PASS
13. Slučka tick 14: `MAGNESIUM_MGDL_TO_MMOLL` + `MAGNESIUM_MMOLL_TO_MGDL` + helpery; units 128 PASS; scores 26 PASS; suite 56 PASS
14. Slučka tick 15: `URIC_ACID_MGDL_TO_UMOLL` + `URIC_ACID_UMOLL_TO_MGDL` + helpery; units 136 PASS; scores 26 PASS; suite 56 PASS
15. Slučka tick 16: `CHOLESTEROL_MGDL_TO_MMOLL` + `CHOLESTEROL_MMOLL_TO_MGDL` + helpery; PREVENT bez inline 0,02586; units 145 PASS; scores 26 PASS; suite 56 PASS
16. Slučka tick 17: `TRIGLYCERIDES_MGDL_TO_MMOLL` + `TRIGLYCERIDES_MMOLL_TO_MGDL` + helpery; units 153 PASS; scores 26 PASS; suite 56 PASS
17. Slučka tick 18: `BILIRUBIN_MGDL_TO_UMOLL` + `BILIRUBIN_UMOLL_TO_MGDL` + helpery; units 162 PASS; scores 26 PASS; suite 56 PASS
18. Slučka tick 19: `MASS_CONC_GDL_TO_GL` + `massConcGdlToGl` / `massConcGlToGdl`; Gupta + prevodník; units 172 PASS; scores 26 PASS; suite 56 PASS
19. Slučka tick 20: `EGFR_ML_MIN_TO_ML_S` + `egfrMlMinToMlS` / `egfrMlSToMlMin`; prevodník + egfr/cys/ekfc; units 185 PASS; scores 26 PASS; suite 56 PASS
20. Slučka tick 21: UACR albumín mg/dL → mg/L cez `massConcGdlToGl`; units 187 PASS; clinical 85 PASS; scores 26 PASS; suite 56 PASS
21. Slučka tick 22: `MASS_CONC_GL_TO_MGL` + `massConcGlToMgl` / `massConcMglToGl`; UACR g/L → mg/L; units 193 PASS; clinical 87 PASS; scores 26 PASS; suite 56 PASS

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
rg -n "/\s*1000|\*\s*1000" calculator_aki.php calculators_common.php
```

Tenké helpery kreatinín µmol/L ↔ mmol/L (`calculator_aki.php` `/ 1000`, common `* 1000`), mimo majiteľa.

## Handoff

`.codex/handoffs/2026-11-06-023400-uacr-albumin-gl-mgl.md`
