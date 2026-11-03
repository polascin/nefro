# SESSION

Aktualizované: 2026-11-03 09:58 Europe/Bratislava

## Aktívna úloha

Beh 151: referenčné testy Kt/V, Watson TBW, nPCR. Handoff:
`.codex/handoffs/2026-11-03-095800-dialysis-clinical-refs.md`.

## Stav repozitára

- Vetva: `main` (práca vo worktree `claude/loop-dev-audit-1ec33b`, merge `--no-ff`)
- Runtime / `DEPLOY_COMMIT`: `9a1861e7`
- `origin/main` a `server/main`: `9a1861e7` (dokumentačný commit po ňom sa nenasadzuje)

## Čo je hotové

1. Kt/V a nPCR vzorce v calculators_common.php, test 25 PASS
2. Živý výpočet zhodný s referenciou
3. Regresie 42 PASS; PHPStan 0

## Otvorené

- Referenčné testy ďalších kalkulačiek (cg, free_water, na, recirculation, plasmic…)

## Executable next step

```text
php tools/run_regressions.php
```

## Handoff

`.codex/handoffs/2026-11-03-095800-dialysis-clinical-refs.md`
