# Handoff: uric-acid-helpers

## Metadata

- Generated At: 2026-11-06T00:14:30+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 2f5ea0cb (pred docs(state) commite)
- Runtime / DEPLOY_COMMIT: 2f5ea0cb (SSH grep deploy_info.php)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 15: zjednotiť prevody kyseliny močovej (mg/dL ↔ µmol/L, faktor 59,48 / 0,0168) na spoločné konštanty/helpery v calculators_common, so zachovaním klinickej správnosti.

## Current State

Hotové. `URIC_ACID_MGDL_TO_UMOLL = 59.48`, `URIC_ACID_UMOLL_TO_MGDL = 0.0168` (samostatne zaokrúhlené klinické konštanty, nie recipročné odvodenie; ≈ MW 168,14). Helpery `uricAcidMgDlToUmolL`, `uricAcidUmolLToMgDl`. Prevodník `calculatorUnitConversionRows` ide cez `URIC_ACID_MGDL_TO_UMOLL`. Inline `59.48` mimo definície konštanty nie je. TLS prah ostáva publikovaný `TLS_URIC_ACID = 476` (8 mg/dL · 59,48 ≈ 475,84). Units 136 PASS; scores 26 PASS; suite 56 PASS; PHPStan 0. Produkcia `2f5ea0cb`.

## Completed This Session

- [x] Konštanty kyseliny močovej + obojsmerné helpery v calculators_common
- [x] Zapojenie prevodníka bez inline 59.48
- [x] Units + scores testy (pin konštánt, helpery, wiring, absencia literálu v riadku; TLS cez helper)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 136 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (`calculators_common.php`, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `2f5ea0cb` = feature HEAD
- Live: `https://nefro.polascin.net/` 200; `/calculator_units.php` 200 (riadok Kyselina močová, `data-factor="59.48"`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: TLS prah 476 µmol/L ostáva pevná publikovaná hodnota Cairo–Bishop, nie exaktný súčin 8 × 59,48
- Risk: 59,48 a 0,0168 nie sú exaktné reciproky (klinické zaokrúhlenie); round-trip má drobnú odchýlku, rovnako ako pri Ca/P/Mg

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: zjednotiť cholesterol `0.02586` na konštantu/helper, alebo iný P1 mimo majiteľa

## Decisions Made

- Decision: dve pomenované konštanty `URIC_ACID_MGDL_TO_UMOLL` a `URIC_ACID_UMOLL_TO_MGDL`, nie odvodenie jednej z druhej
- Reason: rovnaký vzor ako Ca/P/Mg/glukóza; prevodník pinuje 59,48; MW ≈ 168,14 → 0,0168
- Decision: `TLS_URIC_ACID` ostáva 476.0, test pinuje cez `uricAcidMgDlToUmolL(8.0)` s toleranciou 0,5
- Reason: publikovaný prah Cairo–Bishop; 8 × 59,48 = 475,84

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- tools/test_clinical_references_units.php
- tools/test_clinical_references_scores.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 2f5ea0cb feat(kalkulacky): spolocne konstanty a helpery prevodu kyseliny mocovej
- 7192c315 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 2bc54eca docs(state): handoff spolocnych helperov prevodu magnezia
- c7a18acd feat(kalkulacky): spolocne konstanty a helpery prevodu magnezia
- c4578633 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) common + units/scores test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-001430-uric-acid-helpers.md

## Next Command

```text
rg -n 0.02586 calculator_*.php calculators_common.php
```
