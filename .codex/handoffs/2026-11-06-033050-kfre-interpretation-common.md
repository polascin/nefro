# Handoff: kfre-interpretation-common

## Metadata

- Generated At: 2026-11-06T03:30:50+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 0297c70e (feature 98753a08)
- Runtime / DEPLOY_COMMIT: 98753a08 (docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 27: presunúť `kfreInterpretation` z `calculator_kfre.php` do `calculators_common.php`, upraviť pin v teste, commit + deploy.

## Current State

Hotové. `kfreInterpretation` žije v `calculators_common.php` (za `ckdpcInterpretation`); `calculator_kfre.php` len volá. Test pinuje pásma 5yr 3–5 / >5 % a 2yr 10 / 40 % (správanie) a wiring (volať, nie definovať). Suite 56 PASS; produkcia `98753a08`.

## Completed This Session

- [x] Presun `kfreInterpretation` do `calculators_common.php` (za `ckdpcInterpretation`)
- [x] Odstránenie lokálnej definície z `calculator_kfre.php`
- [x] Pin v `tools/test_clinical_references.php` (správanie + wiring → 93 PASS)
- [x] Commit + post-commit SFTP deploy + mirror `server`/`origin`

## Validated

- Command: `php -l` na 3 súbory → OK
- Command: `php tools/test_clinical_references.php` → 93 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS (gate aj post-commit)
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `98753a08` = HEAD
- Live: `/` 200; `/calculator_kfre.php` 200 (bez Fatal/`/data/8/`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: žiadna iná stránka nedefinovala vlastnú `kfreInterpretation` (grep našiel len KFRE + test)
- Risk: žiadny; čistý interpretačný helper bez zmeny prahov ani textov

## Remaining Work

- [ ] Ďalšia executable slučka: presunúť `adpkdInterpretation` z `calculator_adpkd.php` do `calculators_common.php`; pridať pin v teste (mimo zlúčenia Mayo vetvy)
- [ ] Potom rovnakým vzorom: `iganInterpretation` (mimo klinickej opravy koeficientov)
- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev; IgAN; limity Na; CRRT predilúcia

## Decisions Made

- Decision: `kfreInterpretation` do `calculators_common`, nie do `ckd_risk_models.php`
- Reason: rovnaký vzor ako `ckdpcInterpretation` / `ckmStageClass`; model rizík ostáva v `ckd_risk_models`, UI interpretácia v common
- Decision: pin v `tools/test_clinical_references.php` (nie nový súbor)
- Reason: KFRE golden cases už žijú v tomto teste; hint ticku ukazoval naň

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa
- Presun `adpkdInterpretation` nemení Mayo model; zlúčenie `feature/adpkd-mayo-2026-11-03` ostáva oddelené

## Critical Files

- calculators_common.php
- calculator_kfre.php
- tools/test_clinical_references.php
- calculator_adpkd.php (ďalší kandidát: `adpkdInterpretation`)
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 98753a08 refactor(kalkulacky): kfreInterpretation do calculators_common
- 87ada222 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- dc7bfac4 docs(state): handoff ckdpcInterpretation do calculators_common
- 2a00246a refactor(kalkulacky): ckdpcInterpretation do calculators_common
- 6bb684f3 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) calculators_common.php, calculator_kfre.php, tools/test_clinical_references.php
- (docs commit po tomto behu) handoff + state

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-033050-kfre-interpretation-common.md

## Next Command

```text
rg -n "function adpkdInterpretation" calculator_adpkd.php calculators_common.php tools/
```
