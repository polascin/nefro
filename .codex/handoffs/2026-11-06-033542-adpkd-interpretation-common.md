# Handoff: adpkd-interpretation-common

## Metadata

- Generated At: 2026-11-06T03:35:42+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: f947f90b
- Runtime / DEPLOY_COMMIT: f947f90b
- Pripravené, nezlúčené (bez súhlasu): `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 28 / Beh 191: presunúť `adpkdInterpretation` z `calculator_adpkd.php` do `calculators_common.php`, upraviť pin v teste, commit + deploy. Mimo zlúčenia Mayo vetvy.

## Current State

Hotové. `adpkdInterpretation` žije v `calculators_common.php` (za `kfreInterpretation`); `calculator_adpkd.php` len volá. `adpkdClassify` ostáva lokálne na stránke. Test pinuje triedy 1A–1E + neznámu triedu a wiring. Suite 56 PASS; produkcia `f947f90b`.

## Completed This Session

- [x] Presun `adpkdInterpretation` do `calculators_common.php` (za `kfreInterpretation`)
- [x] Odstránenie lokálnej definície z `calculator_adpkd.php` (`adpkdClassify` nedotknuté)
- [x] Pin v `tools/test_clinical_references.php` (1A–1E + unknown + wiring → 101 PASS)
- [x] Commit + post-commit SFTP deploy + mirror `server`/`origin`

## Validated

- Command: `php -l` na 3 súbory → OK
- Command: `php tools/test_clinical_references.php` → 101 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS (gate aj post-commit)
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `f947f90b` = HEAD
- Live: `/` 200; `/calculator_adpkd.php` 200 (bez Fatal/`/data/8/`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: žiadna iná stránka nedefinovala vlastnú `adpkdInterpretation` (grep našiel len ADPKD + test + common)
- Risk: žiadny; čistý interpretačný helper bez zmeny textov ani Mayo klasifikácie

## Remaining Work

- [ ] Ďalšia executable slučka: presunúť `iganInterpretation` z `calculator_igan.php` do `calculators_common.php`; pridať pin v teste (mimo klinickej opravy koeficientov)
- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev; IgAN koeficienty; limity Na; CRRT predilúcia

## Decisions Made

- Decision: `adpkdInterpretation` do `calculators_common`, `adpkdClassify` ostáva v `calculator_adpkd.php`
- Reason: rovnaký vzor ako KFRE/CKD-PC; klasifikácia HtTKV je súčasť Mayo modelu a Mayo vetva sa nemá spájať v tejto slučke
- Decision: pin v `tools/test_clinical_references.php` (nie nový súbor)
- Reason: rovnaký vzor ako `kfreInterpretation`; hint ticku ukazoval na common + calculator + tools/

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa
- Presun `iganInterpretation` nemení IgAN model; oprava koeficientov ostáva oddelená

## Critical Files

- calculators_common.php
- calculator_adpkd.php
- tools/test_clinical_references.php
- calculator_igan.php (ďalší kandidát: `iganInterpretation`)
- state/SESSION.md
- state/TODO.md

## Recent Commits

- f947f90b refactor(kalkulacky): adpkdInterpretation do calculators_common
- 3072cde9 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 0297c70e docs(state): handoff kfreInterpretation do calculators_common
- 98753a08 refactor(kalkulacky): kfreInterpretation do calculators_common
- 87ada222 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) calculators_common.php, calculator_adpkd.php, tools/test_clinical_references.php
- (docs commit po tomto behu) handoff + state

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-033542-adpkd-interpretation-common.md

## Next Command

```text
rg -n "function iganInterpretation" calculator_igan.php calculators_common.php tools/
```
