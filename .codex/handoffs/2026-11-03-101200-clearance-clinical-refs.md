# Handoff: clearance-clinical-refs

## Metadata

- Generated At: 2026-11-03T10:12:00+01:00
- Project Root: D:\Dev\nefro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: main (merge z claude/loop-dev-audit-1ec33b)
- Head Commit: c4eddcc2

## Original Goal

Slučka 14 (/loop): P1 klinické referenčné testy, CG, recirkulácia, voľná voda.

## Current State

Hotové. Runtime `DEPLOY_COMMIT` = `c4eddcc2` = `server/main` = `origin/main`.

## Completed This Session

- [x] Vzorce v calculators_common.php, pomocné triedy presunuté zo stránok
- [x] `tools/test_clinical_references_clearance.php` (25 PASS) v regressions.json
- [x] Živé výpočty zhodné s referenciou

## Validated

- PHPStan 0; lint 705/0; UTF-8 PASS; regresie 43 PASS; CS-Fixer 0 (LF)

## Remaining Work

- [ ] Ďalšie kalkulačky bez referenčného testu: crcl_24h, na, plasmic, kdpi,
      igan, adpkd, aki, crrt, tls, furst, gupta, ca, egfr_slope, mgrs

## Decisions Made

- Neplatný menovateľ v spoločných funkciách → InvalidArgumentException (stránky validujú vopred)

## Next Command

```text
php tools/run_regressions.php
```
