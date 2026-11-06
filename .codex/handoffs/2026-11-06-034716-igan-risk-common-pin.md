# Handoff: igan-risk-common-pin

## Metadata

- Generated At: 2026-11-06T03:47:16+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 2c7fda2d (feature 715c6dcc)
- Runtime / DEPLOY_COMMIT: 715c6dcc (docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 30 / Beh 193: pin aktuálneho správania `iganRisk` (golden cases bez zmeny klinických koeficientov), commit + deploy. Fallback: CKD-PC label helpery.

## Current State

Hotové. `iganRisk` žije v `calculators_common.php` (pred `iganInterpretation`); `calculator_igan.php` len volá. Koeficienty Barbour 2019 nezmenené. Golden pin 8 scenárov + wiring koeficientov v `tools/test_clinical_references.php` (116 PASS). Suite 56 PASS; produkcia `715c6dcc`.

## Completed This Session

- [x] Presun `iganRisk` do `calculators_common.php` (pred `iganInterpretation`, rovnaký vzorec)
- [x] Odstránenie lokálnej definície z `calculator_igan.php`
- [x] Golden pin 8 prípadov (zaokrúhlené na 0,1) + assert koeficientov/referencií
- [x] Wiring: stránka volá `iganRisk`/`iganInterpretation` z common
- [x] Commit + post-commit SFTP deploy + mirror `server`/`origin`

## Validated

- Command: `php -l` na 3 súbory → OK
- Command: `php tools/test_clinical_references.php` → 116 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS (gate aj post-commit)
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `715c6dcc` = HEAD
- Live: `/` 200; `/calculator_igan.php` 200 (bez Fatal/`/data/8/`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: žiadna iná stránka nedefinovala vlastnú `iganRisk` (grep našiel len IgAN + test + common + handoffy)
- Risk: pin chráni aktuálne (známe ako potenciálne nesprávne) koeficienty; klinická oprava modelu ostáva na súhlas majiteľa

## Remaining Work

- [ ] Ďalšia executable slučka: CKD-PC label helpery (`sexLabel` / `smokingLabel` / `boolLabel` → `calculators_common` s prefixom), alebo iný malý bezpečný kalkulačkový refactor
- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev; IgAN koeficienty; limity Na; CRRT predilúcia

## Decisions Made

- Decision: `iganRisk` do `calculators_common` spolu s golden pinom (nie len eval/extrakcia zo stránky)
- Reason: rovnaký vzor ako Mehran/KFRE; pin musí volať skutočnú funkciu; koeficienty sa nemenia
- Decision: pin v `tools/test_clinical_references.php` (8 scenárov + literal koeficienty)
- Reason: rovnaký súbor ako `iganInterpretation`; UI zaokrúhľuje na 0,1

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa
- Pin zámerme zachytáva aktuálne správanie; nezhodu s oficiálnym IgAN nástrojom nerieši

## Critical Files

- calculators_common.php
- calculator_igan.php
- tools/test_clinical_references.php
- calculator_ckdpc.php (ďalší kandidát: label helpery)
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 715c6dcc refactor(kalkulacky): iganRisk do calculators_common s golden pinom
- ecaf9d86 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- ca6a4c5a docs(state): handoff iganInterpretation do calculators_common
- 36c6541b refactor(kalkulacky): iganInterpretation do calculators_common
- 72327e36 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) calculators_common.php, calculator_igan.php, tools/test_clinical_references.php
- (docs commit po tomto behu) handoff + state

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-034716-igan-risk-common-pin.md

## Next Command

```text
rg -n "function (boolLabel|smokingLabel|sexLabel)" calculator_ckdpc.php calculators_common.php tools/
```
