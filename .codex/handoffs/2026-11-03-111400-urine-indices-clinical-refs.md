# Handoff: urine-indices-clinical-refs

## Metadata

- Generated At: 2026-11-03T11:14:00+01:00
- Project Root: D:\Dev\nefro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: main (merge z claude/loop-dev-audit-1ec33b)
- Head Commit: 1a601bdc

## Original Goal

Slučka 18 (/loop): P1 klinické referenčné testy, Furstov pomer, FENa, FEurea.

## Current State

Hotové. Runtime `DEPLOY_COMMIT` = `1a601bdc` = `server/main` = `origin/main`.

## Completed This Session

- [x] Štyri spoločné funkcie + furstClass/Label v calculators_common.php
- [x] `tools/test_clinical_references_urine_indices.php` (24 PASS) v regressions.json
- [x] Živé výpočty zhodné s referenciou

## Remaining Work

- [ ] ROZHODNUTIE MAJITEĽA (Beh 153): limity korekcie hyponatrémie v calculator_na.php
- [ ] Ďalšie kalkulačky bez referenčného testu: kdpi, igan, adpkd, crrt, gupta, mgrs, mgus

## Next Command

```text
php tools/run_regressions.php
```
