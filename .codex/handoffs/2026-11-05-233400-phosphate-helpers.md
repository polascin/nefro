# Handoff: phosphate-helpers

## Metadata

- Generated At: 2026-11-05T23:33:46+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: b576b78f
- Runtime / DEPLOY_COMMIT: b576b78f (SSH grep deploy_info.php)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 13: zjednotiť prevody fosfátu (mg/dL ↔ mmol/L, faktor 0,3229 / 3,097) na spoločné konštanty/helpery v calculators_common, so zachovaním klinickej správnosti.

## Current State

Hotové. `PHOSPHATE_MGDL_TO_MMOLL = 0.3229`, `PHOSPHATE_MMOLL_TO_MGDL = 3.097` (samostatne zaokrúhlené klinické konštanty, nie recipročné odvodenie). Helpery `phosphateMgDlToMmolL`, `phosphateMmolLToMgDl`. Prevodník `calculatorUnitConversionRows` ide cez `PHOSPHATE_MGDL_TO_MMOLL`. TLS prahy `TLS_PHOS_ADULT` / `TLS_PHOS_CHILD` ostávajú zaokrúhlené (1,45 / 2,1); scores pinujú 4,5 / 6,5 ÷ `PHOSPHATE_MMOLL_TO_MGDL`. Units 120 PASS; scores 26 PASS; suite 56 PASS; PHPStan 0. Produkcia `b576b78f`.

## Completed This Session

- [x] Konštanty fosfátu + obojsmerné helpery v calculators_common
- [x] Zapojenie prevodníka bez inline 0.3229; scores cez `PHOSPHATE_MMOLL_TO_MGDL`
- [x] Units + scores testy (pin konštánt, helpery, wiring)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 120 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (`calculators_common.php`, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `b576b78f` = `git rev-parse --short HEAD`
- Live: `https://nefro.polascin.net/` 200; `/calculator_units.php` 200 (riadok Fosfát); `/calculator_tls.php` 200; `/calculators_common.php` 403

## Not Yet Validated

- Assumption: LaTeX/dokumentácia môže spomínať ÷ 3,1; výpočty idú cez konštanty
- Risk: 0,3229 a 3,097 nie sú exaktné reciproky (klinické zaokrúhlenie); round-trip má drobnú odchýlku, rovnako ako predtým

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: zjednotiť magnéziový faktor `0.4114` na konštantu/helper, alebo iný P1 mimo majiteľa

## Decisions Made

- Decision: dve pomenované konštanty `PHOSPHATE_MGDL_TO_MMOLL` a `PHOSPHATE_MMOLL_TO_MGDL`, nie odvodenie jednej z druhej
- Reason: prevodník pinuje 0,3229; TLS prahy Cairo–Bishop pinujú 3,097 (MW P / 10); recipročné odvodenie by posunulo jednu zo strán
- Decision: `TLS_PHOS_ADULT` / `TLS_PHOS_CHILD` ostávajú literály 1,45 / 2,1 mmol/L
- Reason: klinické prahy Cairo–Bishop sú zaokrúhlené; `4,5 / 3,097 ≈ 1,45` a `6,5 / 3,097 ≈ 2,1` ostávajú v tolerancii testu

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- tools/test_clinical_references_units.php
- tools/test_clinical_references_scores.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- b576b78f feat(kalkulacky): spolocne konstanty a helpery prevodu fosfatu
- a6d84442 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- e82e4433 docs(state): handoff spolocnych helperov prevodu vapnika
- 55f1d254 feat(kalkulacky): spolocne konstanty a helpery prevodu vapnika
- 64ebb1c3 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) common + units/scores test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-05-233400-phosphate-helpers.md

## Next Command

```text
rg -n 0.4114 calculator_*.php calculators_common.php
```
