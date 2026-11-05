# SESSION

Aktualizované: 2026-11-05 21:37 Europe/Bratislava

## Aktívna úloha

Beh: spoločné helpery prevodu kreatinínu. Handoff:
`.codex/handoffs/2026-11-05-213700-creatinine-helpers.md`.

## Stav repozitária

- Vetva: `main` (HEAD `61b09a7f`)
- Runtime / `DEPLOY_COMMIT`: `61b09a7f`
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Čo je hotové

1. Beh 150 až 163 + slučka tick 2: AG / Figge / ΔΔ
2. Slučka tick 3: a11y 35 PASS; Wintersova rovnica + test 31 PASS
3. Slučka tick 4: regresie 54 PASS; alkalóza Javaheri + test 42 PASS
4. Slučka tick 5: PHPStan 0; Mehran `mehranScore` + test 24 PASS; suite 55 PASS
5. Slučka tick 6: ops_health WARN OK; prevodník `calculatorUnitConversionRows` + test 53 PASS; suite 56 PASS
6. Slučka tick 7: `CREATININE_UMOL_PER_MGDL` + helpery; 7 stránok bez inline 88,4; units 69 PASS; suite 56 PASS

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
rg -n "8\\.84|\\* 8\\.84|/ 8\\.84" calculator_*.php calculators_common.php ckd_risk_models.php
```

## Handoff

`.codex/handoffs/2026-11-05-213700-creatinine-helpers.md`
