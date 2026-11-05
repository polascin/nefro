# Handoff: acidbase-clinical-refs

## Metadata

- Generated At: 2026-11-05T20:00:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 23b0ffe1
- Runtime / DEPLOY_COMMIT: 23b0ffe1 (SSH deploy.sh --remote-commit)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 2: `php tools/test_acidbase_display.php`; pri PASS ďalšia bezpečná položka (regresia / PHPStan / live smoke / a11y / ops / hlbšia acidbase logika).

## Current State

Hotové. Display test 15 PASS. Extrahovaná logika AG / Figge / ΔΔ do `calculators_common.php`, referenčný test 21 PASS, PubMed odkazy overené, suite 54 PASS, PHPStan 0. Produkcia zodpovedá `23b0ffe1`.

## Completed This Session

- [x] `php tools/test_acidbase_display.php` → 15 PASS
- [x] PHPStan 0 (`--memory-limit=1G`); suite pred zmenou 53 PASS
- [x] Extrakcia `calculatorAnionGapAnalysis` + `calculatorAnionGapDeltaInterpretation` do `calculators_common.php`
- [x] `calculator_acidbase.php` volá spoločnú funkciu; citácie Figge PMID 9824071 a Rastegar PMID 17656477
- [x] `tools/test_clinical_references_acidbase.php` (21 PASS) + manifest + PMID register
- [x] Commit + manuálny deploy z dočasného main worktree + mirror `server`/`origin`

## Validated

- Command: `php tools/test_acidbase_display.php` → 15 PASS
- Command: `php tools/test_clinical_references_acidbase.php` → 21 PASS
- Command: `php tools/check_calculator_pubmed.php` → 14 odkazov, nesúlad 0
- Command: `php tools/test_calculator_pmid_registry.php` → 44 PASS
- Command: `php tools/run_regressions.php` → 54 files PASS
- Command: `php tools/phpstan.phar analyse --memory-limit=1G` → 0
- Command: SSH `deploy.sh --remote-commit` → `DEPLOY_COMMIT` = `23b0ffe1` = `git rev-parse --short HEAD`
- Live: `https://nefro.polascin.net/` 200; `/calculator_acidbase.php` 200 s Figge/Rastegar, bez Fatal; `/calculators_common.php` 403

## Not Yet Validated

- Assumption: pásma Δ/Δ < 0,4 / < 0,8 / < 2,0 sú výučbová konvencia pinovaná existujúcou stránkou; Rastegar 2007 upozorňuje na široký individuálny rozptyl, nie na tieto cut-offy
- Risk: korekcia albumínu používa fixný normál 40 g/L (Figgeov tvar); laboratórny „normál“ sa môže líšiť

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: a11y / PHPStan new / live smoke / ops; kandidát bez pokrytia: Wintersova kompenzácia / pCO₂ pri acidobáze (aktuálna kalkulačka AG+ΔΔ nepočíta)

## Decisions Made

- Decision: AG logika ide do `calculators_common`, nie ostáva inline
- Reason: rovnaký vzor ako eGFR/MGUS; wiring test proti kópii na stránke
- Decision: PMID 9824071 a 17656477 pridané do offline registra po `check_calculator_pubmed.php`
- Reason: nový PubMed odkaz bez registra by zlyhal v regresii

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa
- Worktree `nefro-main-release` je detached s veľkým dirty stromom; `main` je v `d:\Dev\nefro`

## Critical Files

- calculators_common.php
- calculator_acidbase.php
- tools/test_clinical_references_acidbase.php
- tools/test_calculator_pmid_registry.php
- tools/regressions.json
- state/SESSION.md
- state/TODO.md

## Recent Commits

- 23b0ffe1 test(kalkulacky): referencne testy anionovej medzery, Figge a delta/delta
- 1f09dbc6 audit(beh-163): záznam auditu a exclude agent worktrees z lintu
- f30ddfe2 docs(state): handoff CKD-EPI Cr-Cys referencnych testov
- fc543a83 test(kalkulacky): referencne testy CKD-EPI 2021 kreatinin-cystatin C

## Modified Files

- (po docs commite) state/SESSION.md, state/TODO.md, tento handoff

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-05-200000-acidbase-clinical-refs.md

## Next Command

```text
php tools/test_a11y_form_alerts.php
```
