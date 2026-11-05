# Handoff: egfr-cys-clinical-refs

## Metadata

- Generated At: 2026-11-05T19:45:17+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: fc543a83
- Runtime / DEPLOY_COMMIT: fc543a83 (SSH grep deploy_info.php)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 1: `php ops_health.php --no-http`, opraviť prvý FAIL/WARN bez súhlasu majiteľa, alebo bezpečnú položku z TODO (a11y / PHPStan / clinical refs / smoke).

## Current State

Hotové. Lokálny `ops_health --no-http` dáva WARN (chýba `private/archive_cleanup_cron.log` a `deploy_info.php` mimo produkcie); produkčný ops_health je PASS. Nájdená bezpečná oprava: CKD-EPI 2021 kreatinín–cystatín C bez referenčných testov a s lokálnou kópiou G kategórií. Produkcia zodpovedá `fc543a83`.

## Completed This Session

- [x] Overenie `ops_health --no-http` (lokálne WARN očakávané; produkcia PASS)
- [x] PHPStan 0 (`--memory-limit=1G`); suite pred zmenou 53 PASS
- [x] Extrakcia `calculatorCkdEpi2021FromCreatinineCystatinMgDl` do `calculators_common.php`
- [x] `calculator_egfr_cys.php` volá spoločný vzorec + `ckdGCategory` / `ckdGCategoryDescription`
- [x] Rozšírenie `tools/test_clinical_egfr_reference.php` (27 PASS): Inker 2021 PMID 34554658
- [x] Commit + post-commit deploy + mirror push (`server`, `origin`)

## Validated

- Command: `php tools/test_clinical_egfr_reference.php` → 27 PASS
- Command: `php tools/run_regressions.php` → 53 files PASS
- Command: hook gate lint 3559/0 + regresie + JS
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `fc543a83` = `git rev-parse --short HEAD`
- Live: `https://nefro.polascin.net/` 200; `/calculator_egfr_cys.php` 200 bez Fatal; `/calculators_common.php` 403
- Command: produkčný `php ops_health.php --no-http` → RESULT PASS

## Not Yet Validated

- Assumption: pinované Cr–Cys hodnoty sú zo vzorca Inker 2021 (koeficienty overené proti PMID 34554658 / publikovanému tvaru rovnice), nie proti nezávislému softvérovému golden case NKF/MDCalc v tomto behu
- Risk: ak by sa zmenila operacionalizácia veku (napr. necelé roky), pinované celé-ročné prípady by to neodhalili

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: a11y / PHPStan new / live smoke; kandidát bez pokrytia: hlbšia klinická logika `calculator_acidbase.php` (mimo display testu)

## Decisions Made

- Decision: lokálne WARN ops_health (chýbajúci retenčný log a deploy marker) sa neošetrujú fake súbormi
- Reason: produkcia je PASS; marker a cron log vznikajú nasadením/cronom, nie v gite
- Decision: Cr–Cys ide do existujúceho `test_clinical_egfr_reference.php`, nie do nového súboru
- Reason: rovnaká rodina CKD-EPI 2021 / Inker; suite ostáva na 53 súboroch

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- calculator_egfr_cys.php
- tools/test_clinical_egfr_reference.php
- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md

## Recent Commits

- fc543a83 test(kalkulacky): referencne testy CKD-EPI 2021 kreatinin-cystatin C
- 9b99618c docs(state): upresnenie HEAD vs DEPLOY_COMMIT
- d846c5aa docs(state): handoff MGRS/KDRI referencnych testov
- a6c6b4b1 test(kalkulacky): referencne testy MGRS (IKMG) a KDRI/OPTN

## Modified Files

- (po docs commite) state/SESSION.md, state/TODO.md, tento handoff

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-05-194517-egfr-cys-clinical-refs.md

## Next Command

```text
php tools/test_acidbase_display.php
```
