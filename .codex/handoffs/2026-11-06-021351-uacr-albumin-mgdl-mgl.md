# Handoff: uacr-albumin-mgdl-mgl

## Metadata

- Generated At: 2026-11-06T02:13:51+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 600e2f50
- Runtime / DEPLOY_COMMIT: 600e2f50 (SSH grep deploy_info.php)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 21: nahradiť inline ×10 pre močový albumín mg/dL → mg/L v UACR spoločným helperom `massConcGdlToGl` / `MASS_CONC_GDL_TO_GL`, skontrolovať rovnaké miesta, zachovať klinickú správnosť.

## Current State

Hotové. `calculator_uacr.php` prevádza albumín mg/dL → mg/L cez `massConcGdlToGl` (faktor 10 je ten istý ako g/dL → g/L). Docstringy konštanty a helperov v `calculators_common.php` explicitne pokrývajú aj mg/dL ↔ mg/L. Iné `* 10` v kalkulačkách (BMI zaokrúhlenie, nPCR TBW×10, UACR_MG_G odvodenie `/ 10.0`) ostali nedotknuté. Prevod g/L → mg/L (`* 1000`) v UACR ostáva inline. Units 187 PASS; clinical 85 PASS; scores 26 PASS; suite 56 PASS; PHPStan 0. Produkcia `600e2f50`.

## Completed This Session

- [x] UACR albumín mg/dL → mg/L cez `massConcGdlToGl`
- [x] Rozšírenie docstringov MASS_CONC o mg/dL ↔ mg/L
- [x] Units + clinical testy (pin UACR 3 mg/dL → 30 mg/L, wiring bez `$ualb * 10`)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 187 PASS
- Command: `php tools/test_clinical_references.php` → 85 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (common + uacr, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `600e2f50` = HEAD
- Live: `https://nefro.polascin.net/` 200; `/calculator_uacr.php` 200; `/calculators_common.php` 403; bez Fatal error / `/data/8/`

## Not Yet Validated

- Assumption: g/L → mg/L (`* 1000` v UACR) je samostatný SI prefixový faktor, nie MASS_CONC_GDL_TO_GL
- Risk: Gupta stále používa inline `* 2.43` pre magnézium mmol/L → mg/dL (nie `MAGNESIUM_MMOLL_TO_MGDL` = 2,4305); zmena by mohla posunúť skórovanie a súvisí s vetvou `fix/gupta-mg-cutoff`

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: UACR albumín g/L → mg/L (`* 1000`) cez novú konštantu/helper (napr. `MASS_CONC_GL_TO_MGL` = 1000), mimo majiteľa
- [ ] Po vyčerpaní unit faktorov: tenké helpery kreatinín µmol/L ↔ mmol/L (`/ 1000` v `calculator_aki.php`, `* 1000` v `calculators_common`), alebo iný P1 mimo majiteľa

## Decisions Made

- Decision: znovupoužiť `massConcGdlToGl` / `MASS_CONC_GDL_TO_GL` pre UACR mg/dL → mg/L, bez samostatného aliasu
- Reason: fyzikálny faktor je exaktne 10 pre ×/dL → ×/L bez ohľadu na to, či ide o g alebo mg; samostatný alias by bol čisto kozmetický

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa
- Triviálne analytové SI faktory v prevodníku sú prakticky vyčerpané; posledný blízky unit cieľ je UACR `* 1000`, potom µmol↔mmol

## Critical Files

- calculator_uacr.php
- calculators_common.php
- tools/test_clinical_references.php
- tools/test_clinical_references_units.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 600e2f50 feat(kalkulacky): UACR albumín mg/dL → mg/L cez massConcGdlToGl
- dc5a7f8b docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 8cc366ba docs(state): handoff spolocnych helperov prevodu eGFR ml/min ↔ ml/s
- d8adc96c feat(kalkulacky): spolocne konstanty a helpery prevodu eGFR ml/min ↔ ml/s
- 7c8cd840 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) uacr + common docstring + units/clinical test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-021351-uacr-albumin-mgdl-mgl.md

## Next Command

```text
rg -n "ualb\s*\*\s*1000|\*\s*1000" calculator_uacr.php calculators_common.php
```
