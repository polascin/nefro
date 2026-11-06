# Handoff: ckdpc-label-helpers-common

## Metadata

- Generated At: 2026-11-06T03:52:39+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 8869effc (feature e8ae58c6)
- Runtime / DEPLOY_COMMIT: e8ae58c6 (docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 31 / Beh 194: CKD-PC label helpery (`boolLabel` / `smokingLabel` / `sexLabel`) → `calculators_common` s prefixom; pin; commit + deploy. Bez zmeny klinického výpočtu.

## Current State

Hotové. Helpery žijú v `calculators_common.php` ako `calculatorBoolLabel` / `calculatorSmokingLabel` / `calculatorSexLabel` (za `ckdpcInterpretation`). `calculator_ckdpc.php` len volá. Pin 9 assertov výstupov + wiring v `tools/test_clinical_references_ckdpc_ckm.php` (53 PASS). Suite 56 PASS; produkcia `e8ae58c6`.

## Completed This Session

- [x] Presun label helperov do `calculators_common.php` s prefixom `calculator*`
- [x] Odstránenie lokálnych `boolLabel` / `smokingLabel` / `sexLabel` z `calculator_ckdpc.php`
- [x] Pin výstupov (Áno/Nie, Muž/Žena + default, Fajčí/Ex-fajčiar/Nefajčí + default) a wiring assert
- [x] Commit + post-commit SFTP deploy + mirror `server`/`origin`

## Validated

- Command: `php -l` na 3 súbory → OK
- Command: `php tools/test_clinical_references_ckdpc_ckm.php` → 53 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS (gate aj post-commit)
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `e8ae58c6` = HEAD
- Live: `/` 200; `/calculator_ckdpc.php` 200 (CKD-PC/Grams, bez Fatal/`/data/8/`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: `calculator_result_print.php` má vlastné mapovanie sex/smoking/bool s inými defaultmi (sex → „Iné“, smoking default → raw); zámerme sa nemenilo
- Risk: zjednotenie print formátovača na nové helpery by zmenilo edge-case správanie; treba samostatný beh so súhlasom/pinom

## Remaining Work

- [ ] Ďalšia executable slučka: `adpkdClassify` → `calculators_common` (interpretácia už je common), alebo iný malý bezpečný kalkulačkový refactor
- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev; IgAN koeficienty; limity Na; CRRT predilúcia

## Decisions Made

- Decision: prefix `calculatorBoolLabel` / `calculatorSmokingLabel` / `calculatorSexLabel` (nie holé `boolLabel`)
- Reason: handoff požadoval prefix; holé mená sú príliš generické pre globálny namespace common
- Decision: pin zachováva CKD-PC defaulty (non-male → Žena; unknown smoking → Nefajčí)
- Reason: žiadna zmena zobrazenia; print stránka ostáva oddelená pre iné defaulty

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- calculator_ckdpc.php
- tools/test_clinical_references_ckdpc_ckm.php
- calculator_adpkd.php (ďalší kandidát: `adpkdClassify`)
- state/SESSION.md
- state/TODO.md

## Recent Commits

- e8ae58c6 refactor(kalkulacky): CKD-PC label helpery do calculators_common
- 199da390 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 2c7fda2d docs(state): handoff iganRisk do calculators_common s golden pinom
- 715c6dcc refactor(kalkulacky): iganRisk do calculators_common s golden pinom
- ecaf9d86 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) calculators_common.php, calculator_ckdpc.php, tools/test_clinical_references_ckdpc_ckm.php
- (docs commit po tomto behu) handoff + state

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-035239-ckdpc-label-helpers-common.md

## Next Command

```text
rg -n "function adpkdClassify" calculator_adpkd.php calculators_common.php tools/
```
