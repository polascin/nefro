# Handoff: bilirubin-helpers

## Metadata

- Generated At: 2026-11-06T01:13:57+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 691fded6 (feature 3807b84a)
- Runtime / DEPLOY_COMMIT: 3807b84a (SSH grep deploy_info.php; docs-only drift OK)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 18: zjednotiť literály 17.1 (bilirubín mg/dL ↔ µmol/L a súvisiace recipročné faktory) na spoločné konštanty/helpery v calculators_common, so zachovaním klinickej správnosti a bez false-positive zásahov do iných výskytov 17.1.

## Current State

Hotové. `BILIRUBIN_MGDL_TO_UMOLL = 17.1`, `BILIRUBIN_UMOLL_TO_MGDL = 0.0585` (samostatne zaokrúhlené klinické konštanty, nie recipročné odvodenie; ≈ MW bilirubínu / 10 000). Helpery `bilirubinMgDlToUmolL`, `bilirubinUmolLToMgDl`. Prevodník `calculatorUnitConversionRows` ide cez `BILIRUBIN_MGDL_TO_UMOLL`. Inline `17.1` mimo definície konštanty a pin testu nie je. False-positive zhody (DOI, percentá v článkoch, PREVENT koeficienty) zostali nedotknuté. Units 162 PASS; scores 26 PASS; suite 56 PASS; PHPStan 0. Produkcia `3807b84a`.

## Completed This Session

- [x] Konštanty bilirubínu + obojsmerné helpery v calculators_common
- [x] Zapojenie prevodníka bez inline 17.1
- [x] Units testy (pin konštánt, helpery, wiring, absencia literálu v riadku, reciproká tolerancia)
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_units.php` → 162 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS
- Command: PHPStan (`calculators_common.php`, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `3807b84a` = HEAD
- Live: `https://nefro.polascin.net/` 200; `/calculator_units.php` 200 (riadok Bilirubín, `data-factor="17.1"`); `/calculators_common.php` 403

## Not Yet Validated

- Assumption: žiadny iný produkčný výpočet nepoužíval inline 17.1 (grep v calculator_*.php / calculators_common našiel len prevodník)
- Risk: 17,1 a 0,0585 nie sú exaktné reciproky (klinické zaokrúhlenie); round-trip má drobnú odchýlku, rovnako ako pri UA/cholesterol/TG

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: zjednotiť hemoglobín/albumín `10.0` na konštantu/helper, alebo iný P1 mimo majiteľa

## Decisions Made

- Decision: dve pomenované konštanty `BILIRUBIN_MGDL_TO_UMOLL` a `BILIRUBIN_UMOLL_TO_MGDL`, nie odvodenie jednej z druhej
- Reason: rovnaký vzor ako UA/cholesterol/TG; prevodník pinuje 17,1; bežný klinický reciproký faktor je 0,0585 (≈ MW/10 000)

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- tools/test_clinical_references_units.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 691fded6 docs(state): handoff spolocnych helperov prevodu bilirubinu
- 3807b84a feat(kalkulacky): spolocne konstanty a helpery prevodu bilirubinu
- 9a7b36f2 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- ef5457cc docs(state): handoff spolocnych helperov prevodu triglyceridov
- 33814da9 feat(kalkulacky): spolocne konstanty a helpery prevodu triglyceridov

## Modified Files

- (feature commit) common + units test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-011357-bilirubin-helpers.md

## Next Command

```text
rg -n "10\.0" calculator_*.php calculators_common.php
```
