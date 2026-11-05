# Handoff: triglycerides-helpers

## Metadata

- Generated At: 2026-11-06T00:54:11+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 33814da9
- Runtime / DEPLOY_COMMIT: 33814da9 (SSH grep deploy_info.php)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 17: zjednotiť prevody triglyceridov (mg/dL ↔ mmol/L, faktor 0,01129 / 88,57) na spoločné konštanty/helpery v calculators_common, so zachovaním klinickej správnosti.

## Current State

Hotové. `TRIGLYCERIDES_MGDL_TO_MMOLL = 0.01129`, `TRIGLYCERIDES_MMOLL_TO_MGDL = 88.57` (samostatne zaokrúhlené klinické konštanty, nie recipročné odvodenie; ≈ MW trioleínu / 10). Helpery `triglyceridesMgDlToMmolL`, `triglyceridesMmolLToMgDl`. Prevodník `calculatorUnitConversionRows` ide cez `TRIGLYCERIDES_MGDL_TO_MMOLL`. Inline `0.01129` mimo definície konštanty a pin testu nie je. Units 153 PASS; scores 26 PASS; suite 56 PASS; PHPStan 0. Produkcia `33814da9`.

## Completed This Session

- [x] Konštanty triglyceridov + obojsmerné helpery v calculators_common
- [x] Zapojenie prevodníka bez inline 0.01129
- [x] Units testy (pin konštánt, helpery, wiring, absencia literálu v riadku)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 153 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (`calculators_common.php`, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `33814da9` = HEAD
- Live: `https://nefro.polascin.net/` 200; `/calculator_units.php` 200 (riadok Triglyceridy, `data-factor="0.01129"`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: žiadny iný produkčný výpočet nepoužíval inline 0.01129 (grep našiel len prevodník)
- Risk: 0,01129 a 88,57 nie sú exaktné reciproky (klinické zaokrúhlenie); round-trip má drobnú odchýlku, rovnako ako pri cholesterol/Ca/P/Mg/UA

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: zjednotiť bilirubín `17.1` na konštantu/helper, alebo hemoglobín/albumín `10.0`, alebo iný P1 mimo majiteľa

## Decisions Made

- Decision: dve pomenované konštanty `TRIGLYCERIDES_MGDL_TO_MMOLL` a `TRIGLYCERIDES_MMOLL_TO_MGDL`, nie odvodenie jednej z druhej
- Reason: rovnaký vzor ako cholesterol/Ca/P/Mg/UA; prevodník pinuje 0,01129; dokumentovaný deliteľ projektu je 88,57

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- tools/test_clinical_references_units.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 33814da9 feat(kalkulacky): spolocne konstanty a helpery prevodu triglyceridov
- cf2ece6d docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- b4f88e21 docs(state): handoff spolocnych helperov prevodu cholesterolu
- 64712578 feat(kalkulacky): spolocne konstanty a helpery prevodu cholesterolu
- 202a6bb4 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) common + units test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-005411-triglycerides-helpers.md

## Next Command

```text
rg -n 17.1 calculator_*.php calculators_common.php
```
