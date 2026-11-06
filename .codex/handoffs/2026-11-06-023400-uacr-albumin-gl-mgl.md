# Handoff: uacr-albumin-gl-mgl

## Metadata

- Generated At: 2026-11-06T02:34:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 8f49c948 (feature e6a7bd6c)
- Runtime / DEPLOY_COMMIT: e6a7bd6c (SSH grep deploy_info.php; docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 22: nahradiť inline ×1000 pre močový albumín g/L → mg/L v UACR spoločnou konštantou/helperom `MASS_CONC_GL_TO_MGL` / `massConcGlToMgl`, bez zásahu do false-positive `* 1000` mimo hmotnostnej koncentrácie.

## Current State

Hotové. `calculators_common.php` má `MASS_CONC_GL_TO_MGL = 1000.0` a helpery `massConcGlToMgl` / `massConcMglToGl`. `calculator_uacr.php` prevádza albumín g/L → mg/L cez `massConcGlToMgl` (bez `$ualb * 1000`). Units 193 PASS; clinical 87 PASS; scores 26 PASS; suite 56 PASS; PHPStan 0. Produkcia `e6a7bd6c`.

## Completed This Session

- [x] `MASS_CONC_GL_TO_MGL` + `massConcGlToMgl` / `massConcMglToGl`
- [x] UACR albumín g/L → mg/L cez helper
- [x] Units + clinical testy (pin 0,03 g/L → 30 mg/L, wiring bez `$ualb * 1000`, round-trip)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 193 PASS
- Command: `php tools/test_clinical_references.php` → 87 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (common + uacr, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `e6a7bd6c` = HEAD
- Live: `https://nefro.polascin.net/` 200; `/calculator_uacr.php` 200; `/calculators_common.php` 403; bez Fatal error / `/data/8/`

## Not Yet Validated

- Assumption: kreatinín µmol/L ↔ mmol/L (`/ 1000` v `calculator_aki.php`, `* 1000` v common) je samostatný SI prefixový faktor, nie MASS_CONC
- Risk: Gupta stále používa inline `* 2.43` pre magnézium mmol/L → mg/dL (nie `MAGNESIUM_MMOLL_TO_MGDL` = 2,4305); zmena by mohla posunúť skórovanie a súvisí s vetvou `fix/gupta-mg-cutoff`

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: tenké helpery kreatinín µmol/L ↔ mmol/L (`calculator_aki.php` `/ 1000`, common `* 1000`), mimo majiteľa

## Decisions Made

- Decision: nová konštanta `MASS_CONC_GL_TO_MGL` (nie znovupoužitie MASS_CONC_GDL_TO_GL)
- Reason: faktor 1000 je SI prefix g↔mg pri rovnakom objeme; faktor 10 je ×/dL → ×/L. Zmiešanie by zakrylo význam.

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa
- Triviálne analytové SI faktory v prevodníku a UACR mass-conc sú vyčerpané; ďalší blízky unit cieľ je kreatinín µmol↔mmol

## Critical Files

- calculator_uacr.php
- calculators_common.php
- tools/test_clinical_references.php
- tools/test_clinical_references_units.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- e6a7bd6c feat(kalkulacky): UACR albumín g/L → mg/L cez MASS_CONC_GL_TO_MGL
- 10ae81af docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- e5bbceb8 docs(state): handoff UACR albumín mg/dL → mg/L cez massConcGdlToGl
- 600e2f50 feat(kalkulacky): UACR albumín mg/dL → mg/L cez massConcGdlToGl
- dc5a7f8b docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) uacr + common + units/clinical test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-023400-uacr-albumin-gl-mgl.md

## Next Command

```text
rg -n "/\s*1000|\*\s*1000" calculator_aki.php calculators_common.php
```
