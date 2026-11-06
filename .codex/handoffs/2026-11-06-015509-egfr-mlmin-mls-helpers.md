# Handoff: egfr-mlmin-mls-helpers

## Metadata

- Generated At: 2026-11-06T01:55:09+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 8cc366ba (feature d8adc96c)
- Runtime / DEPLOY_COMMIT: d8adc96c (SSH grep deploy_info.php; docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 20: zjednotiť prevod eGFR/clearance s faktorom 1/60 (60 s/min) na spoločné konštanty/helpery v calculators_common a zapojiť prevodník; false-positive 60 mimo tohto kontextu nerušiť.

## Current State

Hotové. Existujúca `EGFR_ML_S_PER_ML_MIN = 60.0` doplnená o `EGFR_ML_MIN_TO_ML_S = 1/60` a helpery `egfrMlMinToMlS` / `egfrMlSToMlMin`. Prevodník `calculatorUnitConversionRows` (riadok eGFR) ide cez `EGFR_ML_MIN_TO_ML_S`. `calculatorEgfrToMlMin` / `FromMlMin` / formátovanie a chybové rozsahy volajú helpery. Zobrazenie SI ekvivalentu v `calculator_egfr.php`, `calculator_egfr_cys.php`, `calculator_ekfc.php` cez `egfrMlMinToMlS`. Časové `* 60.0` (CrCl, nPCR, free water, …) ostali nedotknuté. Units 185 PASS; scores 26 PASS; suite 56 PASS; PHPStan 0. Produkcia `d8adc96c`.

## Completed This Session

- [x] Konštanta EGFR_ML_MIN_TO_ML_S + obojsmerné helpery v calculators_common
- [x] Zapojenie prevodníka eGFR a zobrazení ml/s bez inline 1/60
- [x] Units testy (pin konštanty, helpery, wiring, absencia literálu v riadku eGFR)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 185 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (common + egfr + egfr_cys + ekfc, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `d8adc96c` = HEAD
- Live: `https://nefro.polascin.net/` 200; `/calculator_units.php` 200 (eGFR faktor ≈ 0,01666…); `/calculator_egfr.php` 200; `/calculators_common.php` 403

## Not Yet Validated

- Assumption: močový albumín v UACR (`calculator_uacr.php`: `$ualb * 10` pre mg/dL → mg/L) zdieľa číselný faktor 10 s `MASS_CONC_GDL_TO_GL`, ale ide o mg, nie g
- Risk: Gupta stále používa inline `* 2.43` pre magnézium mmol/L → mg/dL (nie `MAGNESIUM_MMOLL_TO_MGDL` = 2,4305); zmena by mohla posunúť skórovanie a súvisí s vetvou `fix/gupta-mg-cutoff`

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: UACR albumín mg/dL → mg/L (`* 10`) cez `MASS_CONC_GDL_TO_GL` / `massConcGdlToGl` (alebo tenký alias), mimo majiteľa

## Decisions Made

- Decision: ponechať historický názov `EGFR_ML_S_PER_ML_MIN` (= 60) a pridať `EGFR_ML_MIN_TO_ML_S` pre smer prevodníka
- Reason: hodnota a použitie sú stabilné naprieč parsovaním eGFR; premenovanie by bolo čisto kozmetické a riskantné pre diff šum

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa
- Triviálne SI faktory v prevodníku sú prakticky vyčerpané; ďalší bezpečný cieľ je UACR `* 10` alebo iný P1 mimo majiteľa

## Critical Files

- calculators_common.php
- calculator_egfr.php
- calculator_egfr_cys.php
- calculator_ekfc.php
- tools/test_clinical_references_units.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- d8adc96c feat(kalkulacky): spolocne konstanty a helpery prevodu eGFR ml/min ↔ ml/s
- 7c8cd840 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 4b9e479c docs(state): handoff spolocnych helperov prevodu Hb/Alb
- 135590d9 feat(kalkulacky): spolocne konstanty a helpery prevodu Hb/Alb g/dL ↔ g/L
- 93ef2117 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) common + egfr/egfr_cys/ekfc + units test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-015509-egfr-mlmin-mls-helpers.md

## Next Command

```text
rg -n "ualb\s*\*\s*10|\*\s*10\b" calculator_uacr.php calculators_common.php
```
