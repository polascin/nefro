# Handoff: creatinine-helpers

## Metadata

- Generated At: 2026-11-05T21:37:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 4153ad83 (feature `61b09a7f`)
- Runtime / DEPLOY_COMMIT: 61b09a7f (SSH grep deploy_info.php; docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 7: zjednotiť inline prevody kreatinínu (`× 88,4` / `0,0884`) na spoločné konštanty/helpery z calculators_common (nadväzne na unit converter).

## Current State

Hotové. `CREATININE_UMOL_PER_MGDL = 88.4`, helpery `creatinineMgDlToUmolL` / `creatinineUmolLToMgDl` / `creatinineMgDlToMmolL`, `crclCreatinineToMgDl` a prevodník používajú konštantu; PLASMIC prah = `2.0 * CREATININE_UMOL_PER_MGDL`. Stránky eGFR, eGFR–Cys, CG, KDPI, AKI, UACR, EKFC bez inline `×/÷ 88,4`. Test units 69 PASS; suite 56 PASS; PHPStan na zmenených súboroch 0. Produkcia `61b09a7f`.

## Completed This Session

- [x] Konštanta + helpery v `calculators_common.php`; unit rows + `crclCreatinineToMgDl`
- [x] Zapojenie calculator_egfr/_cys, cg, kdpi, aki, uacr, ekfc; odstránenie `EKFC_CREATININE_UMOL_PER_MGDL`
- [x] Referenčné testy + wiring (inline 88,4 zakázané na stránkach)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 69 PASS
- Command: `php tools/test_clinical_references.php` → 84 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (zmenené kalkulačky) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `61b09a7f` = `git rev-parse --short HEAD`
- Live: `https://nefro.polascin.net/` 200; `/calculator_egfr.php` 200 (LaTeX `\div 88.4` ostáva vo vzorci); `/calculators_common.php` 403; bez Fatal / `/data/8/`

## Not Yet Validated

- Assumption: vzorce v LaTeX na stránkach môžu literálne uvádzať 88,4 (dokumentácia, nie výpočet)
- Risk: faktor UACR `× 8,84` (mg/mmol → mg/g) je stále samostatný literál; súvisí s 88,4/10

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: zjednotiť `× 8,84` (UACR mg/mmol ↔ mg/g) na odvodenú konštantu z kreatinínu, alebo iný P1 mimo majiteľa

## Decisions Made

- Decision: jedna konštanta `CREATININE_UMOL_PER_MGDL` + tri smerové helpery; ponechať názov `crclCreatinineToMgDl`
- Reason: už používaný API; mmol/L = umol/1000 cez ten istý faktor
- Decision: PLASMIC prah odvodiť ako `2.0 * CREATININE_UMOL_PER_MGDL` (176,8)
- Reason: jeden zdroj pravdy; komentár „88,42“ bol nepresný

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- calculator_egfr.php, calculator_egfr_cys.php, calculator_cg.php, calculator_kdpi.php
- calculator_aki.php, calculator_uacr.php, calculator_ekfc.php, calculator_ekfc_logic.php
- tools/test_clinical_references_units.php (+ related clinical ref tests)
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 61b09a7f feat(kalkulacky): spolocne helpery prevodu kreatininu mg/dL a µmol/L
- df9be68b docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 60a6f948 docs(state): handoff prevodnika jednotiek SI a konvencnych
- 8108f319 feat(kalkulacky): spolocne konverzne faktory prevodnika jednotiek
- e311e87c docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) kalkulačky + common + testy; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-05-213700-creatinine-helpers.md

## Next Command

```text
rg -n "8\\.84|\\* 8\\.84|/ 8\\.84" calculator_*.php calculators_common.php ckd_risk_models.php
```
