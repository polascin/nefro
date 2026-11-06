# Handoff: ckdpc-interpretation-common

## Metadata

- Generated At: 2026-11-06T03:26:01+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 2a00246a (feature = DEPLOY)
- Runtime / DEPLOY_COMMIT: 2a00246a
- Pripravené, nezlúčené (bez súhlasu): `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 26: presunúť `ckdpcInterpretation` z `calculator_ckdpc.php` do `calculators_common.php`, upraviť pin v teste, commit + deploy.

## Current State

Hotové. `ckdpcInterpretation` žije v `calculators_common.php` (za `ckmStageClass`); `calculator_ckdpc.php` len volá. Test pinuje pásma 5 / 10 / 20 % (správanie) a wiring (volať, nie definovať). Suite 56 PASS; produkcia `2a00246a`.

## Completed This Session

- [x] Presun `ckdpcInterpretation` do `calculators_common.php` (za `ckmStageClass`)
- [x] Odstránenie lokálnej definície z `calculator_ckdpc.php`
- [x] Pin v `tools/test_clinical_references_ckdpc_ckm.php` (správanie + wiring → 42 PASS)
- [x] Commit + post-commit SFTP deploy + mirror `server`/`origin`

## Validated

- Command: `php -l` na 3 súbory → OK
- Command: `php tools/test_clinical_references_ckdpc_ckm.php` → 42 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS (gate aj post-commit)
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `2a00246a` = HEAD
- Live: `/` 200; `/calculator_ckdpc.php` 200 (bez Fatal/`/data/8/`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: žiadna iná stránka nedefinovala vlastnú `ckdpcInterpretation` (grep našiel len CKD-PC + test)
- Risk: žiadny; čistý interpretačný helper bez zmeny prahov ani textov

## Remaining Work

- [ ] Ďalšia executable slučka: presunúť `kfreInterpretation` z `calculator_kfre.php` do `calculators_common.php`; pridať pin v existujúcom KFRE/clinical teste
- [ ] Neskôr rovnakým vzorom (vetvy / súhlas majiteľa): `adpkdInterpretation`, `iganInterpretation`
- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev; IgAN; limity Na; CRRT predilúcia

## Decisions Made

- Decision: `ckdpcInterpretation` do `calculators_common`, nie do `ckd_risk_models.php`
- Reason: rovnaký vzor ako `ckmStageClass` / Furst; model rizík ostáva v `ckd_risk_models`, UI interpretácia v common
- Decision: test pinuje správanie pásiem + „volá, nedefinuje“, prahy aj v common source
- Reason: konzistentné s CKM wiring assertami; source-only prahy v page by po presune zlyhali

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- calculator_ckdpc.php
- tools/test_clinical_references_ckdpc_ckm.php
- calculator_kfre.php (ďalší kandidát: `kfreInterpretation`)
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 2a00246a refactor(kalkulacky): ckdpcInterpretation do calculators_common
- 6bb684f3 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 5fad4075 docs(state): handoff ckmStageClass do calculators_common
- 5110a7f9 refactor(kalkulacky): ckmStageClass do calculators_common
- 618dd931 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) calculators_common.php, calculator_ckdpc.php, tools/test_clinical_references_ckdpc_ckm.php
- (docs commit po tomto behu) handoff + state

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-032601-ckdpc-interpretation-common.md

## Next Command

```text
rg -n "function kfreInterpretation" calculator_kfre.php calculators_common.php tools/test_clinical_references.php
```
