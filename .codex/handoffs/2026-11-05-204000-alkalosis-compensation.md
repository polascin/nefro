# Handoff: alkalosis-compensation

## Metadata

- Generated At: 2026-11-05T20:40:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 8d5793b8
- Runtime / DEPLOY_COMMIT: 8d5793b8 (SSH grep deploy_info.php)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 4: `php tools/run_regressions.php`; pri PASS ďalšia bezpečná položka mimo „Čaká na majiteľa“ (PHPStan / ops_health / a11y / live smoke / očakávané pCO₂ pri metabolickej alkalóze).

## Current State

Hotové. Regresie 54 PASS. Očakávané pCO₂ pri metabolickej alkalóze (0,7 · HCO₃ + 20 ± 5 mmHg) v `calculators_common.php`, zapojené do `calculator_acidbase.php` (mutually exclusive s Winters), referenčný test 42 PASS, PMID 6799256 overený NCBI esummary. Produkcia zodpovedá `8d5793b8`.

## Completed This Session

- [x] `php tools/run_regressions.php` → 54 files PASS
- [x] PHPStan `--memory-limit=1G` → 0; a11y unit selects 22 PASS; lokálny `ops_health --no-http` WARN (očakávané)
- [x] `calculatorMetabolicAlkalosisCompensation` + interpretácia v `calculators_common.php`
- [x] Zapojenie do `calculator_acidbase.php` (HCO₃ > 24); citácia Javaheri PMID 6799256
- [x] Referenčné testy 42 PASS; display 23 PASS; PMID register; `check_calculator_pubmed` 16/0
- [x] `site_changelog` + popis v `calculators.php`
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/run_regressions.php` → 54 files PASS
- Command: `php tools/test_clinical_references_acidbase.php` → 42 PASS
- Command: `php tools/test_acidbase_display.php` → 23 PASS
- Command: `php tools/check_calculator_pubmed.php` → 16 odkazov, nesúlad 0
- Command: `php tools/test_calculator_pmid_registry.php` → 44 PASS
- Command: `php tools/phpstan.phar analyse --memory-limit=1G` → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `8d5793b8` = `git rev-parse --short HEAD`
- Live: `https://nefro.polascin.net/` 200; `/calculator_acidbase.php` 200 s Javaheri/6799256, bez Fatal; `/calculators_common.php` 403

## Not Yet Validated

- Assumption: pásmo ± 5 mmHg je výučbová konštanta (Brandis); Javaheri 1982 popisuje lineárny vzťah ± SEM, nie striktný diagnostický cut-off
- Risk: vzorec platí len pri primárnej metabolickej alkalóze (HCO₃ > 24); pri hypoxémii alebo bolesti môže byť hypoventilácia maskovaná

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: live smoke / produkčný ops / PHPStan new; kandidát bez pokrytia podľa `state/TODO.md`

## Decisions Made

- Decision: alkalóza len pri HCO₃ > 24; Winters len pri HCO₃ < 24; pri 24 ani jedna
- Reason: rovnice sú špecifické pre primárnu metabolickú poruchu; AG/ΔΔ ostávajú vždy
- Decision: PMID 6799256 (Javaheri/Shore/Rose/Kazemi, Chest 1982) a pásmo ± 5 mmHg
- Reason: NCBI esummary potvrdil autorov a rovnicu PaCO₂ = 0,7 [HCO₃] + 20; Brandis používa ± 5

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- calculator_acidbase.php
- calculators.php
- site_changelog.php
- tools/test_clinical_references_acidbase.php
- tools/test_acidbase_display.php
- tools/test_calculator_pmid_registry.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 8d5793b8 feat(kalkulacky): ocakavane pCO2 pri metabolickej alkaloze
- 79f01d24 docs(state): handoff Wintersovej kompenzacie pCO2
- e1606d38 feat(kalkulacky): Wintersova kompenzacia pCO2 pri metabolickej acidoze
- 77f4343c docs(state): handoff AG/Figge/delta-delta referencnych testov

## Modified Files

- (po docs commite) state/SESSION.md, state/TODO.md, tento handoff

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-05-204000-alkalosis-compensation.md

## Next Command

```text
php tools/phpstan.phar analyse --memory-limit=1G --no-progress
```
