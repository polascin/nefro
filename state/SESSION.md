# SESSION

Aktualizované: 2026-11-06 03:53 Europe/Bratislava

## Aktívna úloha

Beh: CKD-PC label helpery do `calculators_common` + pin. Handoff:
`.codex/handoffs/2026-11-06-035239-ckdpc-label-helpers-common.md`.

## Stav repozitária

- Vetva: `main` (HEAD `8869effc`; feature `e8ae58c6`)
- Runtime / `DEPLOY_COMMIT`: `e8ae58c6` (docs-only drift po handoffe OK)
- Pripravené, nezlúčené: `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

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
22. Slučka tick 23: `CREATININE_UMOL_PER_MMOL` + `creatinineUmolLToMmolL` / `creatinineMmolLToUmolL`; AKI + CrCl; units 199 PASS; urine 24 PASS; suite 56 PASS
23. Slučka tick 24: `*ParseNonNeg` → `calculatorParseNonNegativeFloat` (8 stránok + kdpi); suite 56 PASS; deploy `e676e53b`
24. Slučka tick 25: `ckmStageClass` → `calculators_common`; CKD-PC/CKM 40 PASS; suite 56 PASS; deploy `5110a7f9`
25. Slučka tick 26: `ckdpcInterpretation` → `calculators_common`; CKD-PC/CKM 42 PASS; suite 56 PASS; deploy `2a00246a`
26. Slučka tick 27: `kfreInterpretation` → `calculators_common`; clinical 93 PASS; suite 56 PASS; deploy `98753a08`
27. Slučka tick 28: `adpkdInterpretation` → `calculators_common`; clinical 101 PASS; suite 56 PASS; deploy `f947f90b`
28. Slučka tick 29: `iganInterpretation` → `calculators_common`; clinical 107 PASS; suite 56 PASS; deploy `36c6541b`
29. Slučka tick 30: `iganRisk` → `calculators_common` + golden pin 8 scenárov; clinical 116 PASS; suite 56 PASS; deploy `715c6dcc`
30. Slučka tick 31: CKD-PC label helpery → `calculatorBool/Sex/SmokingLabel`; CKD-PC/CKM 53 PASS; suite 56 PASS; deploy `e8ae58c6`

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
rg -n "function adpkdClassify" calculator_adpkd.php calculators_common.php tools/
```

`adpkdClassify` do `calculators_common` (interpretácia už je common), alebo iný malý bezpečný kalkulačkový refactor.

## Handoff

`.codex/handoffs/2026-11-06-035239-ckdpc-label-helpers-common.md`
