# Handoff: mgrs-kdpi-clinical-refs

## Metadata

- Generated At: 2026-11-05T19:20:38+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: a6c6b4b1
- Runtime / DEPLOY_COMMIT: a6c6b4b1 (SFTP get deploy_info.php)
- Pripravené, nezlúčené (bez súhlasu): `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Original Goal

Prvá slučka /loop: jedna opraviteľná položka bez súhlasu majiteľa. Preferencia TODO: referenčné testy MGRS (checklist) a KDPI/KDRI (OPTN).

## Current State

Hotové. Logika `mgrsClassify` a `kdri*` je v `calculators_common.php`; nové regresné súbory sú v suite (53 PASS). Produkcia zodpovedá `a6c6b4b1`.

## Completed This Session

- [x] Extrakcia `mgrsClassify` z `calculator_mgrs.php` do `calculators_common.php`
- [x] Extrakcia `kdpiParseNonNeg`, `kdriXbeta`, `kdriRiskClass`, `kdriRiskLabel` + nový `kdriRao` do `calculators_common.php`
- [x] `tools/test_clinical_references_mgrs.php` (11 PASS): hierarchie IKMG Leung 2019 PMID 30510265
- [x] `tools/test_clinical_references_kdpi.php` (26 PASS): Rao 2009 PMID 19623019 koeficienty, referenčný darca KDRI=1, strop Scr 8,0
- [x] Zaradenie do `tools/regressions.json`; suite 53 PASS
- [x] Commit + push mirrors + SFTP deploy; smoke HTTP 200

## Validated

- Command: `php tools/test_clinical_references_mgrs.php` → 11 PASS
- Command: `php tools/test_clinical_references_kdpi.php` → 26 PASS
- Command: `php tools/run_regressions.php` → 53 files PASS
- Command: SFTP `deploy_info.php` → `DEPLOY_COMMIT` = `a6c6b4b1` = `git rev-parse --short HEAD`
- Live: `https://nefro.polascin.net/` 200; `/calculator_mgrs.php` a `/calculator_kdpi.php` bez Fatal; `/calculators_common.php` 403

## Not Yet Validated

- Assumption: koeficienty KDRI zo sekundárnych zdrojov (PMC3332103 / OPTN guide text) zodpovedajú aktuálnemu OPTN PDF (priamy PDF download z OPTN vrátil HTML, nie binárku)
- Risk: ak by OPTN zmenil operacionalizáciu (nie samotný Rao model), testy by stále pinovali Rao 2009 donor-only; KDPI percentil sa zámerne nepočíta

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: `php ops_health.php --no-http` alebo ďalší FAIL/WARN / a11y / PHPStan new issues

## Decisions Made

- Decision: jedna slučka pokryla obe TODO položky mgrs + kdpi (súvisiace P1 clinical refs), nie len jednu kalkulačku
- Reason: rovnaký vzor extrakcie + pinovanie citácií; žiadna zmena správania UI; bez súhlasu majiteľa
- Decision: KDPI percentil sa netestuje ani nepočíta
- Reason: vyžaduje ročnú referenčnú populáciu OPTN; stránka už odkazuje na oficiálnu kalkulačku

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- calculator_mgrs.php
- calculator_kdpi.php
- tools/test_clinical_references_mgrs.php
- tools/test_clinical_references_kdpi.php
- tools/regressions.json
- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md

## Recent Commits

- a6c6b4b1 test(kalkulacky): referencne testy MGRS (IKMG) a KDRI/OPTN
- 31a5daf0 fix(deploy): šablóny add_TEMPLATE_* už nebežia pri deployi a prázdny slug sa nevloží do DB
- db7b6446 audit(korekcia): hĺbková jazyková a typografická korektúra portálu + čistenie kódu

## Modified Files

- (po commite docs) state/SESSION.md, state/TODO.md, tento handoff

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-05-192038-mgrs-kdpi-clinical-refs.md

## Next Command

```text
php ops_health.php --no-http
```
