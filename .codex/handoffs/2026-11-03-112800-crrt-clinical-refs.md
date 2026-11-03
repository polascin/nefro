# Handoff: crrt-clinical-refs

## Metadata

- Generated At: 2026-11-03T11:28:00+01:00
- Project Root: D:\Dev\nefro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: main (merge z claude/loop-dev-audit-1ec33b)
- Head Commit: bcffbf85

## Original Goal

Slučka 19 (/loop): P1 klinické referenčné testy, CRRT efluentová dávka.

## Current State

Hotové. Runtime `DEPLOY_COMMIT` = `bcffbf85` = `server/main` = `origin/main`.

## Completed This Session

- [x] `calculatorCrrtEffluentDose` + crrtDoseClass/Label v calculators_common.php
- [x] `tools/test_clinical_references_crrt.php` (16 PASS) v regressions.json
- [x] Živý výpočet zhodný s referenciou

## Remaining Work

- [ ] ROZHODNUTIE MAJITEĽA (Beh 153): limity korekcie hyponatrémie v calculator_na.php
- [ ] ROZHODNUTIE MAJITEĽA (Beh 157): CRRT bez korekcie predilúcie a bez citácie KDIGO
- [ ] Ďalšie kalkulačky bez referenčného testu: kdpi, igan, adpkd, gupta, mgrs, mgus

## Next Command

```text
php tools/run_regressions.php
```
