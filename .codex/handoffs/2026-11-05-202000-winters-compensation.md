# Handoff: winters-compensation

## Metadata

- Generated At: 2026-11-05T20:20:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: e1606d38
- Runtime / DEPLOY_COMMIT: e1606d38 (SSH grep deploy_info.php)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 3: `php tools/test_a11y_form_alerts.php`; pri PASS ďalšia bezpečná položka mimo „Čaká na majiteľa“ (Wintersova kompenzácia / PHPStan / live smoke / ops).

## Current State

Hotové. A11y form alerts 35 PASS. Wintersova rovnica (1,5 · HCO₃ + 8 ± 2 mmHg) v `calculators_common.php`, zapojená do `calculator_acidbase.php` s voliteľným pCO₂, referenčný test 31 PASS, PMID 6016545 overený. Produkcia zodpovedá `e1606d38`.

## Completed This Session

- [x] `php tools/test_a11y_form_alerts.php` → 35 PASS
- [x] PHPStan 0; lokálny `ops_health --no-http` WARN (očakávané mimo produkcie)
- [x] `calculatorWintersCompensation` + interpretácia v `calculators_common.php`
- [x] Voliteľné pole pCO₂, vzorec, citácia Albert/Dell/Winters PMID 6016545
- [x] Referenčné testy 31 PASS; display 19 PASS; PMID register; `check_calculator_pubmed` 15/0
- [x] `site_changelog` + popis v `calculators.php`
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_a11y_form_alerts.php` → 35 PASS
- Command: `php tools/test_clinical_references_acidbase.php` → 31 PASS
- Command: `php tools/test_acidbase_display.php` → 19 PASS
- Command: `php tools/check_calculator_pubmed.php` → 15 odkazov, nesúlad 0
- Command: `php tools/test_calculator_pmid_registry.php` → 44 PASS
- Command: `php tools/run_regressions.php` → 54 files PASS
- Command: `php tools/phpstan.phar analyse --memory-limit=1G` → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `e1606d38` = `git rev-parse --short HEAD`
- Live: `https://nefro.polascin.net/` 200; `/calculator_acidbase.php` 200 s Winters/6016545, bez Fatal; `/calculators_common.php` 403

## Not Yet Validated

- Assumption: pásmo ± 2 mmHg je výučbová konštanta viazaná na Wintersovu rovnicu; pôvodná práca Albert 1967 popisuje empirický vzťah, nie striktný diagnostický cut-off
- Risk: Winters platí len pri primárnej metabolickej acidóze (HCO₃ < 24); pri zmiešaných poruchách treba interpretáciu čítať s AG/ΔΔ

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: live smoke / ops produkčný / PHPStan new; kandidát bez pokrytia: očakávané pCO₂ pri metabolickej alkalóze (nie Winters)

## Decisions Made

- Decision: Winters len pri HCO₃ < 24; pCO₂ je voliteľné
- Reason: rovnica je pre metabolickú acidózu; AG/ΔΔ ostávajú použiteľné aj bez krvných plynov
- Decision: PMID 6016545 (nie 6016894 z niektorých kalkulačiek online)
- Reason: NCBI esummary potvrdil Albert/Dell/Winters Ann Intern Med 1967;66(2):312–22

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

- e1606d38 feat(kalkulacky): Wintersova kompenzacia pCO2 pri metabolickej acidoze
- 77f4343c docs(state): handoff AG/Figge/delta-delta referencnych testov
- 23b0ffe1 test(kalkulacky): referencne testy anionovej medzery, Figge a delta/delta
- 1f09dbc6 audit(beh-163): záznam auditu a exclude agent worktrees z lintu

## Modified Files

- (po docs commite) state/SESSION.md, state/TODO.md, tento handoff

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-05-202000-winters-compensation.md

## Next Command

```text
php tools/run_regressions.php
```
