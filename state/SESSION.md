# SESSION

Aktualizované: 2026-11-06 00:54 Europe/Bratislava

## Aktívna úloha

Beh: spoločné konštanty/helpery triglyceridov mg/dL ↔ mmol/L. Handoff:
`.codex/handoffs/2026-11-06-005411-triglycerides-helpers.md`.

## Stav repozitária

- Vetva: `main` (HEAD `33814da9`)
- Runtime / `DEPLOY_COMMIT`: `33814da9`
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

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
rg -n 17.1 calculator_*.php calculators_common.php
```

## Handoff

`.codex/handoffs/2026-11-06-005411-triglycerides-helpers.md`
