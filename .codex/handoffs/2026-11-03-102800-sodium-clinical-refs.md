# Handoff: sodium-clinical-refs

## Metadata

- Generated At: 2026-11-03T10:28:00+01:00
- Project Root: D:\Dev
efro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: main (merge z claude/loop-dev-audit-1ec33b)
- Head Commit: b3e0f4df

## Original Goal

Slučka 15 (/loop): P1 klinické referenčné testy, CrCl 24 h a nátrium.

## Current State

Hotové. Runtime `DEPLOY_COMMIT` = `b3e0f4df` = `server/main` = `origin/main`.

## Completed This Session

- [x] Šesť spoločných funkcií v calculators_common.php
- [x] `tools/test_clinical_references_sodium.php` (28 PASS) v regressions.json
- [x] Živé výpočty zhodné s referenciou

## Remaining Work

- [ ] ROZHODNUTIE MAJITEĽA: limity korekcie hyponatrémie v calculator_na.php
      (≤ 8 / ≤ 6 mmol/L/24 h) vs. Spasovski 2014 (PMID 24569496) a Verbalis 2013
      (PMID 24074529); čísla overiť v plnom texte, rozlíšiť cieľ a limit
- [ ] Ďalšie kalkulačky bez referenčného testu: plasmic, kdpi, igan, adpkd,
      aki, crrt, tls, furst, gupta, ca, egfr_slope, mgrs

## Decisions Made

- Klinický obsah (limity ODS) sa bez súhlasu nemení

## Next Command

```text
php tools/run_regressions.php
```
