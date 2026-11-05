# Handoff: magnesium-helpers

## Metadata

- Generated At: 2026-11-05T23:53:50+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 2bc54eca (feature c7a18acd)
- Runtime / DEPLOY_COMMIT: c7a18acd (SSH grep deploy_info.php; docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 14: zjednotiť prevody magnézia (mg/dL ↔ mmol/L, faktor 0,4114 / 2,4305) na spoločné konštanty/helpery v calculators_common, so zachovaním klinickej správnosti.

## Current State

Hotové. `MAGNESIUM_MGDL_TO_MMOLL = 0.4114`, `MAGNESIUM_MMOLL_TO_MGDL = 2.4305` (samostatne zaokrúhlené klinické konštanty, nie recipročné odvodenie; MW Mg 24,305 / 10). Helpery `magnesiumMgDlToMmolL`, `magnesiumMmolLToMgDl`. Prevodník `calculatorUnitConversionRows` ide cez `MAGNESIUM_MGDL_TO_MMOLL`. Inline `0.4114` mimo definície konštanty nie je. Units 128 PASS; scores 26 PASS; suite 56 PASS; PHPStan 0. Produkcia `c7a18acd`.

## Completed This Session

- [x] Konštanty magnézia + obojsmerné helpery v calculators_common
- [x] Zapojenie prevodníka bez inline 0.4114
- [x] Units testy (pin konštánt, helpery, wiring, absencia literálu v riadku)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 128 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (`calculators_common.php`, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `c7a18acd` = `git rev-parse --short HEAD`
- Live: `https://nefro.polascin.net/` 200; `/calculator_units.php` 200 (riadok Magnézium, `data-factor="0.4114"`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: Gupta CP-AKI prah Mg ostáva v mg/dL; konverzia sa tam nepoužíva
- Risk: 0,4114 a 2,4305 nie sú exaktné reciproky (klinické zaokrúhlenie); round-trip má drobnú odchýlku, rovnako ako pri Ca/P

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: zjednotiť kyselinu močovú `59.48` na konštantu/helper, alebo iný P1 mimo majiteľa

## Decisions Made

- Decision: dve pomenované konštanty `MAGNESIUM_MGDL_TO_MMOLL` a `MAGNESIUM_MMOLL_TO_MGDL`, nie odvodenie jednej z druhej
- Reason: rovnaký vzor ako Ca/P/glukóza; prevodník pinuje 0,4114; MW Mg / 10 = 2,4305
- Decision: Gupta skóre (`mgMgdl < 2.0`) sa nemenilo
- Reason: vstup je už v mg/dL; prevod nie je potrebný

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- tools/test_clinical_references_units.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- c7a18acd feat(kalkulacky): spolocne konstanty a helpery prevodu magnezia
- c4578633 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- b2bc1e21 docs(state): handoff spolocnych helperov prevodu fosfatu
- b576b78f feat(kalkulacky): spolocne konstanty a helpery prevodu fosfatu
- a6d84442 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) common + units test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-05-235350-magnesium-helpers.md

## Next Command

```text
rg -n 59.48 calculator_*.php calculators_common.php
```
