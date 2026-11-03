# Handoff: clinical-refs-ckdpc-ckm

## Metadata

- Generated At: 2026-11-03T05:41:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: ed5bd134

## Original Goal

Autonómna slučka 3: P1 clinical refs CKD-PC / CKM. Claim/lease ENUM nesaheť.

## Current State

Hotové. HEAD `ed5bd134` na origin/server. Runtime `DEPLOY_COMMIT` ostáva
`03c461fd` (iba `tools/` + regressions.json, SFTP ignore, žiadne nasaditeľné
PHP). Live `calculator_ckdpc.php` / `calculator_ckm.php` 200.

## Completed This Session

- [x] `tools/test_clinical_references_ckdpc_ckm.php` (37 PASS)
- [x] Zapísané do `tools/regressions.json` (39 files PASS)
- [x] CKD-PC: ckdpcrisk.org scenáre, eGFR=60 priemer, model_name strata
- [x] CKM: `ckmComputeStage` hierarchia + labely + wiring BMI 23/25 a KF→very-high
- [x] Claim/lease ENUM **nebol**

## Validated

- Command: `php tools/test_clinical_references_ckdpc_ckm.php` → 37 PASS
- Command: `php tools/run_regressions.php` → 39 files PASS
- PHPStan: 0 errors na novom teste
- Live: `/`, `/calculator_ckdpc.php`, `/calculator_ckm.php` 200
- Deploy marker: `03c461fd` (očakávaný drift voči HEAD; ignore cesty)

## Not Yet Validated

- Assumption: claim/lease stále vyžaduje výslovný súhlas
- Risk: admin POST so skalármi ešte nie je plošne pokrytý

## Remaining Work

- [ ] Cielené skaláre v admin POST bez multi-selectov
- [ ] Claim/lease ENUM `sending` **iba so súhlasom**

## Decisions Made

- Decision: Samostatný clinical-ref súbor namiesto ďalšieho rozšírenia
  `test_clinical_references.php`
- Reason: Handoff/TODO žiadali oddelený súbor; CKD-PC scenáre zdieľajú
  ambulatory, CKM unit pin je nový
- Decision: Claim/lease nerobiť
- Reason: Stojaci zákaz bez súhlasu

## Blockers / Open Questions

- Žiadne. Claim/lease len so súhlasom.

## Critical Files

- tools/test_clinical_references_ckdpc_ckm.php
- tools/regressions.json
- ckd_risk_models.php
- calculator_ckdpc.php
- calculator_ckm.php

## Recent Commits

- ed5bd134 test(clinical): P1 referencie CKD-PC a CKM
- 0d78c324 docs(state): SHA deploy vs HEAD po handoffe Beh 140
- 03c461fd fix(auth): requestRequireScalarPost na login, reset a newsletter POST

## Modified Files

- (committed) tools/test_clinical_references_ckdpc_ckm.php, tools/regressions.json

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-03-054047-clinical-refs-ckdpc-ckm.md

## Next Command

```text
# Cielené requestRequireScalarPost v admin POST bez multi-selectov,
# ALEBO claim/lease IBA so súhlasom.
# php tools/run_regressions.php
```
