# Handoff: dialysis-clinical-refs

## Metadata

- Generated At: 2026-11-03T09:58:00+01:00
- Project Root: D:\Dev
efro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: main (merge z claude/loop-dev-audit-1ec33b)
- Head Commit: 9a1861e7

## Original Goal

Slučka 13 (/loop): P1 klinické referenčné testy pre kalkulačky bez pokrytia.

## Current State

Hotové. Runtime `DEPLOY_COMMIT` = `9a1861e7` = `server/main` = `origin/main`.

## Completed This Session

- [x] `calculatorKtvDaugirdas2`, `npcrSargentGotch` + pomocné nPCR funkcie v calculators_common.php
- [x] `tools/test_clinical_references_dialysis.php` (25 PASS), zapísaný v regressions.json
- [x] Živý výpočet Kt/V a nPCR zhodný s referenciou

## Validated

- PHPStan 0; lint 704/0; UTF-8 PASS; regresie 42 PASS; CS-Fixer 0 (LF)
- Citácie PMID 8305648 a 6986753 overené cez PubMed

## Remaining Work

- [ ] Ďalšie kalkulačky bez referenčného testu: cg, crcl_24h, free_water, na,
      recirculation, plasmic, kdpi, igan, adpkd, aki, crrt, tls, furst, gupta,
      ca, egfr_slope, mgrs (vzor: vytiahnuť vzorec do calculators_common + test)

## Decisions Made

- Očakávané hodnoty počítané nezávisle z publikovaných rovníc, nie z kódu
- Bez changelogu: výpočet ani UI sa nemenili

## Critical Files

- calculators_common.php
- tools/test_clinical_references_dialysis.php

## Next Command

```text
php tools/test_clinical_references_dialysis.php; php tools/run_regressions.php
```
