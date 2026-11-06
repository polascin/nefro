# Handoff: creatinine-umol-mmol

## Metadata

- Generated At: 2026-11-06T02:55:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: a165e6d1
- Runtime / DEPLOY_COMMIT: a165e6d1 (SSH grep deploy_info.php)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 23: zaviesť spoločný helper kreatinín µmol/L ↔ mmol/L (faktor 1000) v `calculators_common` a zapojiť `calculator_aki.php` (+ bezpečné miesta v common), bez false-positive `* 1000` / `/ 1000` mimo tohto kontextu.

## Current State

Hotové. `CREATININE_UMOL_PER_MMOL = 1000.0` a helpery `creatinineUmolLToMmolL` / `creatinineMmolLToUmolL`. AKI používa helper namiesto `$sCrUmol / 1000`. `creatinineMgDlToMmolL` a `crclCreatinineToMgDl` (mmol_l) idú cez helpery. `creatinineMmolLToGL` ponechané s `/ 1000` (mmol·MW → g/L, nie µmol↔mmol). Units 199 PASS; urine indices 24 PASS; clinical 87 PASS; scores 26 PASS; suite 56 PASS; PHPStan 0. Produkcia `a165e6d1`.

## Completed This Session

- [x] `CREATININE_UMOL_PER_MMOL` + `creatinineUmolLToMmolL` / `creatinineMmolLToUmolL`
- [x] `calculator_aki.php`, `creatinineMgDlToMmolL`, `crclCreatinineToMgDl`
- [x] Units + urine indices pin/wiring (bez `$sCrUmol / 1000`, bez CrCl inline × 1000)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 199 PASS
- Command: `php tools/test_clinical_references_urine_indices.php` → 24 PASS
- Command: `php tools/test_clinical_references.php` → 87 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (common + aki, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `a165e6d1` = HEAD
- Live: `https://nefro.polascin.net/` 200; `/calculator_aki.php` 200; `/calculators_common.php` 403; bez Fatal error / `/data/8/`

## Not Yet Validated

- Assumption: `creatinineMmolLToGL` `/ 1000` je mmol→mol pre hmotnostnú koncentráciu (MW), nie SI prefix µmol↔mmol
- Risk: Gupta stále používa inline `* 2.43` pre magnézium mmol/L → mg/dL (nie `MAGNESIUM_MMOLL_TO_MGDL` = 2,4305); zmena by mohla posunúť skórovanie a súvisí s vetvou `fix/gupta-mg-cutoff`

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka (mimo unit faktorov): zjednotiť lokálne `*ParseNonNeg` na `calculatorParseNonNegativeFloat` (gupta, furst, crrt, tls, mgus, ckm, plasmic; plus `kdpiParseNonNeg` v common)

## Decisions Made

- Decision: nová konštanta `CREATININE_UMOL_PER_MMOL` (nie znovupoužitie `MASS_CONC_GL_TO_MGL`)
- Reason: faktor 1000 je SI prefix µmol↔mmol pri koncentrácii kreatinínu; MASS_CONC je g↔mg pri rovnakom objeme. Zmiešanie by zakrylo význam.
- Decision: `creatinineMmolLToGL` nerušiť
- Reason: delenie 1000 tam nie je µmol→mmol, ale prepočet mmol·(g/mol) → g/L.

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa
- Triviálne SI unit faktory (prevodník, UACR mass-conc, kreatinín µmol↔mmol) sú vyčerpané

## Critical Files

- calculator_aki.php
- calculators_common.php
- tools/test_clinical_references_units.php
- tools/test_clinical_references_urine_indices.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- a165e6d1 feat(kalkulacky): kreatinin umol/L <-> mmol/L cez CREATININE_UMOL_PER_MMOL
- 3d27b45c docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 8f49c948 docs(state): handoff UACR albumín g/L → mg/L cez MASS_CONC_GL_TO_MGL
- e6a7bd6c feat(kalkulacky): UACR albumín g/L → mg/L cez MASS_CONC_GL_TO_MGL
- 10ae81af docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) aki + common + units/urine_indices test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-025500-creatinine-umol-mmol.md

## Next Command

```text
rg -n "function \\w+ParseNonNeg" calculator_*.php calculators_common.php
```
