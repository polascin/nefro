# Handoff: scores-clinical-refs

## Metadata

- Generated At: 2026-11-03T10:45:00+01:00
- Project Root: D:\Dev\nefro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: main (merge z claude/loop-dev-audit-1ec33b)
- Head Commit: 143687e2

## Original Goal

Slučka 16 (/loop): P1 klinické referenčné testy, PLASMIC a TLS.

## Current State

Hotové. Runtime `DEPLOY_COMMIT` = `143687e2` = `server/main` = `origin/main`.

## Completed This Session

- [x] `plasmicScore`, `tlsCairoBishop` + triedy, štítky a prahy v calculators_common.php
- [x] `tools/test_clinical_references_scores.php` (26 PASS) v regressions.json
- [x] Živé výpočty zhodné s referenciou

## Remaining Work

- [ ] ROZHODNUTIE MAJITEĽA (Beh 153): limity korekcie hyponatrémie v calculator_na.php
- [ ] Ďalšie kalkulačky bez referenčného testu: kdpi, igan, adpkd, aki, crrt,
      furst, gupta, ca, egfr_slope, mgrs

## Decisions Made

- Porovnania konštánt v testoch cez pomocnú funkciu (PHPStan ich inak vyhodnotí staticky)

## Next Command

```text
php tools/run_regressions.php
```
