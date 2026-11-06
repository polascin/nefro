# Handoff: parse-nonneg-unify

## Metadata

- Generated At: 2026-11-06T03:15:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: (docs commit po tomto handoffe; feature `e676e53b`)
- Runtime / DEPLOY_COMMIT: e676e53b (SSH grep deploy_info.php)
- Pripravené, nezlúčené (bez súhlasu): `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

## Original Goal

Slučka /loop nefro-rsi tick 24: zjednotiť duplicitné lokálne `*ParseNonNeg` (gupta, furst, crrt, tls, mgus, ckm, plasmic) a `kdpiParseNonNeg` na existujúci `calculatorParseNonNegativeFloat`, zachovať správanie a edge cases.

## Current State

Hotové. Odstránených 8 lokálnych parserov (−110 riadkov). Všetky call sites volajú `calculatorParseNonNegativeFloat`. CRRT: prázdny vstup ostáva 0 cez `trim(...) === '' ? '0' : ...` pred spoločným parserom. KDPI test pinuje spoločný helper. Suite 56 PASS; PHPStan 0. Produkcia `e676e53b`.

## Completed This Session

- [x] Odstránenie `gupta/furst/crrt/tls/mgus/ckm/plasmic`ParseNonNeg a `kdpiParseNonNeg`
- [x] CRRT empty→0 zachované bez lokálneho wrappera
- [x] `tools/test_clinical_references_kdpi.php` pin na `calculatorParseNonNegativeFloat`
- [x] Commit + post-commit deploy + mirror `server`/`origin`

## Validated

- Command: `php tools/test_clinical_references_kdpi.php` → 26 PASS
- Command: `php tools/test_clinical_references_scores.php` → 26 PASS
- Command: `php tools/test_clinical_references.php` → 87 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS (vrátane Gupta 74, CRRT 16, Furst 24, MGUS 16, PLASMIC/TLS 26, CKD-PC/CKM 37)
- Command: PHPStan (common + 8 kalkulačiek, memory 512M) → 0
- Command: SSH `deploy_info.php` → `DEPLOY_COMMIT` = `e676e53b` = feature HEAD
- Live: `https://nefro.polascin.net/` 200; `/calculator_crrt.php` 200; `/calculator_gupta.php` 200; `/calculator_kdpi.php` 200; `/calculators_common.php` 403; bez Fatal error / `/data/8/`

## Not Yet Validated

- Assumption: `is_finite()` v spoločnom helperi je prísnejšie než lokálne wrappery (INF/NAN → null); v praxi žiadny POST vstup tak nevzniká
- Risk: Gupta stále používa inline `* 2.43` pre magnézium mmol/L → mg/dL (nie `MAGNESIUM_MMOLL_TO_MGDL` = 2,4305); zmena by mohla posunúť skórovanie a súvisí s vetvou `feature/gupta-mg-cutoff`

## Remaining Work

- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev
- [ ] Čaká na majiteľa: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Ďalšia executable slučka: presunúť `ckmStageClass` z `calculator_ckm.php` do `calculators_common.php` (rovnaký vzor ako plasmic/tls/mgus/crrt/furst *Class); upraviť pin v `tools/test_clinical_references_ckdpc_ckm.php`

## Decisions Made

- Decision: CRRT empty→0 riešiť na call site (`'' ? '0'`), nie novým parametrom spoločného parsera
- Reason: API `calculatorParseNonNegativeFloat` ostáva jednoznačné; empty-as-zero je výnimka len pri voliteľných CRRT prietokoch
- Decision: `kdpiParseNonNeg` zmazať, nie aliasovať
- Reason: jediný call site + jeden test; alias by len predĺžil duplicitu

## Blockers / Open Questions

- Vetvy ADPKD/Gupta a klinické zmeny IgAN / Na limity / CRRT predilúcia ostávajú na súhlas majiteľa
- Unit faktory a ParseNonNeg duplicity sú vyčerpané

## Critical Files

- calculator_gupta.php
- calculator_furst.php
- calculator_crrt.php
- calculator_tls.php
- calculator_mgus.php
- calculator_ckm.php
- calculator_plasmic.php
- calculator_kdpi.php
- calculators_common.php
- tools/test_clinical_references_kdpi.php
- state/SESSION.md
- state/TODO.md

## Recent Commits

- e676e53b refactor(kalkulacky): zjednotenie ParseNonNeg na calculatorParseNonNegativeFloat
- a5d91e1e docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 84a31ee0 docs(state): handoff kreatinín µmol/L ↔ mmol/L cez CREATININE_UMOL_PER_MMOL
- a165e6d1 feat(kalkulacky): kreatinin umol/L <-> mmol/L cez CREATININE_UMOL_PER_MMOL
- 3d27b45c docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature commit) 8 kalkulačiek + common + kdpi test; state/handoff v docs commite po tomto behu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-031500-parse-nonneg-unify.md

## Next Command

```text
rg -n "function ckmStageClass" calculator_ckm.php calculators_common.php tools/test_clinical_references_ckdpc_ckm.php
```
