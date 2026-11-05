# SESSION

Aktualizované: 2026-11-05 20:55 Europe/Bratislava

## Aktívna úloha

Beh: Mehran skóre CI-AKI (spoločná funkcia + citácia). Handoff:
`.codex/handoffs/2026-11-05-205500-mehran-score.md`.

## Stav repozitára

- Vetva: `main` (HEAD `075ca14e`; feature `a9e99f84`)
- Runtime / `DEPLOY_COMMIT`: `a9e99f84` (docs-only drift po handoffe OK)
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Čo je hotové

1. Beh 150 až 163 + slučka tick 2: AG / Figge / ΔΔ
2. Slučka tick 3: a11y 35 PASS; Wintersova rovnica + test 31 PASS
3. Slučka tick 4: regresie 54 PASS; alkalóza Javaheri + test 42 PASS
4. Slučka tick 5: PHPStan 0; Mehran `mehranScore` + test 24 PASS; suite 55 PASS

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
php ops_health.php
```

## Handoff

`.codex/handoffs/2026-11-05-205500-mehran-score.md`
