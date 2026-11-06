# Handoff: igan-interpretation-common

## Metadata

- Generated At: 2026-11-06T03:40:48+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: ca6a4c5a (feature 36c6541b)
- Runtime / DEPLOY_COMMIT: 36c6541b (docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 29 / Beh 192: presunúť `iganInterpretation` z `calculator_igan.php` do `calculators_common.php`, upraviť pin v teste, commit + deploy. Bez klinickej opravy koeficientov IgAN.

## Current State

Hotové. `iganInterpretation` žije v `calculators_common.php` (za `adpkdInterpretation`); `calculator_igan.php` len volá. `iganRisk` ostáva lokálne na stránke. Test pinuje pásma <5 / <15 / <40 / ≥40 % a wiring. Suite 56 PASS; produkcia `36c6541b`.

## Completed This Session

- [x] Presun `iganInterpretation` do `calculators_common.php` (za `adpkdInterpretation`)
- [x] Odstránenie lokálnej definície z `calculator_igan.php` (`iganRisk` nedotknuté)
- [x] Pin v `tools/test_clinical_references.php` (pásma + wiring → 107 PASS)
- [x] Commit + post-commit SFTP deploy + mirror `server`/`origin`

## Validated

- Command: `php -l` na 3 súbory → OK
- Command: `php tools/test_clinical_references.php` → 107 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS (gate aj post-commit)
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `36c6541b` = HEAD
- Live: `/` 200; `/calculator_igan.php` 200 (bez Fatal/`/data/8/`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: žiadna iná stránka nedefinovala vlastnú `iganInterpretation` (grep našiel len IgAN + test + common + handoffy)
- Risk: žiadny; čistý interpretačný helper bez zmeny textov ani `iganRisk` koeficientov

## Remaining Work

- [ ] Ďalšia executable slučka: pin aktuálneho správania `iganRisk` (golden cases bez zmeny koeficientov), alebo malý bezpečný refactor label helperov CKD-PC (`sexLabel` / `smokingLabel` / `boolLabel` → `calculators_common` s prefixom)
- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev; IgAN koeficienty; limity Na; CRRT predilúcia

## Decisions Made

- Decision: `iganInterpretation` do `calculators_common`, `iganRisk` ostáva v `calculator_igan.php`
- Reason: rovnaký vzor ako KFRE/ADPKD; skórovací model a oprava koeficientov sú oddelené od interpretačného helpera
- Decision: pin v `tools/test_clinical_references.php` (nie nový súbor)
- Reason: rovnaký vzor ako `adpkdInterpretation` / `kfreInterpretation`

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa
- Presun `iganInterpretation` nemení IgAN model; oprava koeficientov ostáva oddelená
- Reťaz interpretačných helperov (ckdpc → kfre → adpkd → igan) je v common hotová

## Critical Files

- calculators_common.php
- calculator_igan.php
- tools/test_clinical_references.php
- calculator_ckdpc.php (ďalší kandidát: label helpery)
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 36c6541b refactor(kalkulacky): iganInterpretation do calculators_common
- 72327e36 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 1696bc56 docs(state): handoff adpkdInterpretation do calculators_common
- f947f90b refactor(kalkulacky): adpkdInterpretation do calculators_common
- 3072cde9 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) calculators_common.php, calculator_igan.php, tools/test_clinical_references.php
- (docs commit po tomto behu) handoff + state

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-034048-igan-interpretation-common.md

## Next Command

```text
rg -n "function iganRisk" calculator_igan.php tools/
```
