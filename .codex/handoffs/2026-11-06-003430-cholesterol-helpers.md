# Handoff: cholesterol-helpers

## Metadata

- Generated At: 2026-11-06T00:34:30+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: b4f88e21 (feature 64712578)
- Runtime / DEPLOY_COMMIT: 64712578 (SSH grep deploy_info.php; docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 16: zjednotiť prevody cholesterolu (mg/dL ↔ mmol/L, faktor 0,02586 / 38,67) na spoločné konštanty/helpery v calculators_common, so zachovaním klinickej správnosti.

## Current State

Hotové. `CHOLESTEROL_MGDL_TO_MMOLL = 0.02586`, `CHOLESTEROL_MMOLL_TO_MGDL = 38.67` (samostatne zaokrúhlené klinické konštanty, nie recipročné odvodenie; ≈ MW 386,65 / 10). Helpery `cholesterolMgDlToMmolL`, `cholesterolMmolLToMgDl`. Prevodník `calculatorUnitConversionRows` ide cez `CHOLESTEROL_MGDL_TO_MMOLL`. PREVENT (`prevent_model.php`) používa tú istú konštantu pri vstupe v mg/dL. Inline `0.02586` mimo definície konštanty nie je. Units 145 PASS; scores 26 PASS; PREVENT load 14 PASS; suite 56 PASS; PHPStan 0. Produkcia `64712578`.

## Completed This Session

- [x] Konštanty cholesterolu + obojsmerné helpery v calculators_common
- [x] Zapojenie prevodníka a PREVENT bez inline 0.02586
- [x] Units testy (pin konštánt, helpery, wiring, absencia literálu v riadku a v prevent_model)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 145 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/test_prevent_load.php` → 14 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (`calculators_common.php`, `prevent_model.php`, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `64712578` = feature HEAD
- Live: `https://nefro.polascin.net/` 200; `/calculator_units.php` 200 (riadok Cholesterol, `data-factor="0.02586"`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: PREVENT referenčné % ostávajú zhodné, lebo faktor je rovnaká hodnota 0,02586
- Risk: 0,02586 a 38,67 nie sú exaktné reciproky (klinické zaokrúhlenie); round-trip má drobnú odchýlku, rovnako ako pri Ca/P/Mg/UA

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: zjednotiť triglyceridy `0.01129` na konštantu/helper, alebo iný P1 mimo majiteľa

## Decisions Made

- Decision: dve pomenované konštanty `CHOLESTEROL_MGDL_TO_MMOLL` a `CHOLESTEROL_MMOLL_TO_MGDL`, nie odvodenie jednej z druhej
- Reason: rovnaký vzor ako Ca/P/Mg/UA/glukóza; prevodník pinuje 0,02586; dokumentovaný deliteľ projektu je 38,67
- Decision: `prevent_model.php` prešiel na `CHOLESTEROL_MGDL_TO_MMOLL` (načíta sa po `calculators_common`)
- Reason: jediný produkčný výpočet s literálom 0,02586 mimo prevodníka

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- prevent_model.php
- tools/test_clinical_references_units.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- b4f88e21 docs(state): handoff spolocnych helperov prevodu cholesterolu
- 64712578 feat(kalkulacky): spolocne konstanty a helpery prevodu cholesterolu
- 202a6bb4 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 139e40ec docs(state): handoff spolocnych helperov prevodu kyseliny mocovej
- 2f5ea0cb feat(kalkulacky): spolocne konstanty a helpery prevodu kyseliny mocovej

## Modified Files

- (feature commit) common + prevent + units test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-003430-cholesterol-helpers.md

## Next Command

```text
rg -n 0.01129 calculator_*.php calculators_common.php
```
