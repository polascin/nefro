# Handoff: adpkd-classify-common

## Metadata

- Generated At: 2026-11-06T03:59:47+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 28bcf11e
- Runtime / DEPLOY_COMMIT: 28bcf11e
- Pripravené, nezlúčené (bez súhlasu): `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 32 / Beh 195: `adpkdClassify` (Mayo HtTKV 1A–1E) → `calculators_common`; pin; commit + deploy. Bez zmeny klinických hraníc/tried.

## Current State

Hotové. `adpkdClassify` žije v `calculators_common.php` tesne pred `adpkdInterpretation`. `calculator_adpkd.php` len volá. Pin 7 scenárov + 4 hranice k (0.015 / 0.03 / 0.045 / 0.06) + wiring v `tools/test_clinical_references.php` (127 PASS). Suite 56 PASS; produkcia `28bcf11e`.

## Completed This Session

- [x] Presun `adpkdClassify` do `calculators_common.php` (presné bajty vrátane NBSP v `speed`)
- [x] Odstránenie lokálnej definície z `calculator_adpkd.php`
- [x] Golden pin tried/httkv/k_pct + hranice k + wiring assert (common má classify+interpretáciu; stránka len volá)
- [x] Commit + post-commit SFTP deploy + mirror `server`/`origin`

## Validated

- Command: `php -l` na `calculator_adpkd.php`, `calculators_common.php`, test → OK
- Command: `php tools/test_clinical_references.php` → 127 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS (aj post-commit gate)
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `28bcf11e` = HEAD
- Live: `/` 200; `/calculator_adpkd.php` 200 (Mayo/HtTKV/Irazabal, bez Fatal/`/data/8/`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: atypická trieda 2 zostáva v POST vetve stránky (nie v `adpkdClassify`); zámerme sa nemenilo
- Risk: zlúčenie `feature/adpkd-mayo-2026-11-03` môže znova rozísť klasifikáciu; treba pin pred merge

## Remaining Work

- [ ] Ďalšia executable slučka: `ekfcModeLabel` → `calculators_common` (malý label helper), alebo iný malý bezpečný kalkulačkový refactor
- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev; IgAN koeficienty; limity Na; CRRT predilúcia

## Decisions Made

- Decision: `adpkdClassify` ostáva bez prefixu `calculator*` (rovnako ako `adpkdInterpretation` / `iganRisk`)
- Reason: konzistentné mená ADPKD API v common; nie generický label helper
- Decision: pin zahŕňa hranice `k` cez `150*exp(k*age)*height_m`, nie len reprezentatívne TKV
- Reason: chráni prahy 1,5 / 3 / 4,5 / 6 %/rok pred tichou zmenou

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- calculator_adpkd.php
- tools/test_clinical_references.php
- calculator_ekfc.php (ďalší kandidát: `ekfcModeLabel`)
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 28bcf11e refactor(kalkulacky): adpkdClassify do calculators_common s golden pinom
- 50e32a04 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 8869effc docs(state): handoff CKD-PC label helpery do calculators_common
- e8ae58c6 refactor(kalkulacky): CKD-PC label helpery do calculators_common
- 199da390 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) calculators_common.php, calculator_adpkd.php, tools/test_clinical_references.php
- (docs commit po tomto behu) handoff + state

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-035947-adpkd-classify-common.md

## Next Command

```text
rg -n "function ekfcModeLabel" calculator_ekfc.php calculators_common.php tools/
```
