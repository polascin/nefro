# Handoff: ckm-stage-class-common

## Metadata

- Generated At: 2026-11-06T03:20:54+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 5fad4075 (feature 5110a7f9)
- Runtime / DEPLOY_COMMIT: 5110a7f9 (docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 25: presunúť `ckmStageClass` z `calculator_ckm.php` do `calculators_common.php` (vzor plasmic/tls/mgus/crrt/furst *Class), upraviť pin v teste, commit + deploy.

## Current State

Hotové. `ckmStageClass` žije v `calculators_common.php`; `calculator_ckm.php` len volá. Test pinuje správanie (0–1 low, 2 moderate, 3–4 high) a wiring (volať, nie definovať). Suite 56 PASS; produkcia `5110a7f9`.

## Completed This Session

- [x] Presun `ckmStageClass` do `calculators_common.php` (za `furstLabel`)
- [x] Odstránenie lokálnej definície z `calculator_ckm.php`
- [x] Pin v `tools/test_clinical_references_ckdpc_ckm.php` (+3 asserty → 40 PASS)
- [x] Commit + post-commit SFTP deploy + mirror `server`/`origin`

## Validated

- Command: `php -l` na 3 súbory → OK
- Command: `php tools/test_clinical_references_ckdpc_ckm.php` → 40 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS (gate aj post-commit)
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `5110a7f9` = HEAD
- Live: `/` 200; `/calculator_ckm.php` 200 (bez Fatal/`/data/8/`); `/calculators_common.php` 403; `/ckd_risk_models.php` 403

## Not Yet Validated

- Assumption: žiadna iná stránka nedefinovala vlastnú `ckmStageClass` (grep našiel len CKM + test)
- Risk: žiadny; čistý CSS helper bez zmeny prahov

## Remaining Work

- [ ] Ďalšia executable slučka: presunúť `ckdpcInterpretation` z `calculator_ckdpc.php` do `calculators_common.php`; upraviť pin v `tools/test_clinical_references_ckdpc_ckm.php`
- [ ] Neskôr rovnakým vzorom: `kfreInterpretation` (KFRE), prípadne `adpkdInterpretation` / `iganInterpretation` (vetvy / súhlas majiteľa)
- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev; IgAN; limity Na; CRRT predilúcia

## Decisions Made

- Decision: `ckmStageClass` do `calculators_common`, nie vedľa `ckmStageLabel` v `ckd_risk_models.php`
- Reason: rovnaký vzor ako ostatné *Class CSS helpery; label/stage logika ostáva v modeli
- Decision: test pinuje správanie + „volá, nedefinuje“, nie len absenciu funkcie
- Reason: konzistentné s Furst/KDPI wiring assertami

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- calculator_ckm.php
- tools/test_clinical_references_ckdpc_ckm.php
- calculator_ckdpc.php (ďalší kandidát: `ckdpcInterpretation`)
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 5110a7f9 refactor(kalkulacky): ckmStageClass do calculators_common
- 618dd931 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- e610421b docs(state): handoff zjednotenie ParseNonNeg na calculatorParseNonNegativeFloat
- e676e53b refactor(kalkulacky): zjednotenie ParseNonNeg na calculatorParseNonNegativeFloat
- a5d91e1e docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) calculators_common.php, calculator_ckm.php, tools/test_clinical_references_ckdpc_ckm.php
- (docs commit po tomto behu) handoff + state

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-032054-ckm-stage-class-common.md

## Next Command

```text
rg -n "function ckdpcInterpretation" calculator_ckdpc.php calculators_common.php tools/test_clinical_references_ckdpc_ckm.php
```
