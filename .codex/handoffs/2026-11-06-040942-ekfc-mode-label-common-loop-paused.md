# Handoff: ekfc-mode-label-common-loop-paused

## Metadata

- Generated At: 2026-11-06T04:09:42+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: f695d7aa
- Runtime / DEPLOY_COMMIT: f695d7aa
- RSI slučka: **prechodne zastavená** na pokyn používateľa (PID 59480 / terminál 909755; sentinel `AGENT_LOOP_TICK_nefro-rsi` overený ako mŕtvy)
- Pripravené, nezlúčené (bez súhlasu): `feature/adpkd-mayo-2026-11-03`, `feature/gupta-mg-cutoff-2026-11-03`

## Original Goal

Tick 33 / Beh 196: `ekfcModeLabel` → `calculators_common` s pinom; potom na pokyn používateľa dokončiť rozpracované a **prechodne zastaviť** RSI slučku. Bez ticku 34.

## Current State

Tick 33 hotový a nasadený. Slučka RSI nebeží. Ďalšia RSI práca až na výslovný pokyn.

## Completed This Session

- [x] Presun `ekfcModeLabel` → `calculatorEkfcModeLabel` v `calculators_common.php` (vedľa ostatných `calculator*Label`)
- [x] `calculator_ekfc.php` len volá; bez zmeny EKFC výpočtu
- [x] Golden pin 5 labelov + wiring assert v `tools/test_clinical_references.php` (134 PASS)
- [x] Commit `f695d7aa` + SFTP deploy + smoke
- [x] Zabitie RSI loop PID 59480 (a zvyšných sentinel procesov); terminál 909755 `status: failed`

## Validated

- Command: `php -l` na common / ekfc / test → OK
- Command: `php tools/test_clinical_references.php` → 134 PASS
- Command: `php tools/run_regressions.php` → 56 files PASS (aj pred deploy bránou)
- Command: `hooks/deploy.sh --remote-commit` → `f695d7aa` = HEAD
- Live: `/` 200; `/calculator_ekfc.php` 200 (bez Fatal/`/data/8/`); `/calculators_common.php` 403
- Loop: `PID_59480_DEAD`; `TRUE_SENTINEL` count 0; terminál `909755` failed

## Not Yet Validated

- Assumption: žiadny Cursor `/loop` watcher automaticky nespustí nový tick po tomto handoffe
- Risk: ak UI znova spustí slučku, treba ju znova zabiť; nepokračovať v RSI bez pokynu

## Remaining Work

- [ ] **Až na výslovný pokyn:** ďalší malý bezpečný kalkulačkový refactor (kandidát: `preventRenderOutcome` v `calculator_prevent.php`, alebo print format helpery v `calculator_result_print.php`)
- [ ] Čaká na majiteľa: zlúčenie ADPKD a Gupta Mg vetiev; IgAN koeficienty; limity Na; CRRT predilúcia

## Decisions Made

- Decision: premenovanie na `calculatorEkfcModeLabel` (nie ponechanie `ekfcModeLabel`)
- Reason: konzistentné s `calculatorBool/Sex/SmokingLabel` a `calculatorEgfrUnitLabel`; výpočet ostáva v `calculator_ekfc_logic.php` pod `ekfc*`
- Decision: RSI slučka zastavená; bez ticku 34
- Reason: výslovný pokyn používateľa „prechodne zastav slučku“

## Blockers / Open Questions

- Slučka je zámerne pauznutá; neštartovať ju bez pokynu
- Klinické zmeny a feature vetvy ostávajú na súhlas majiteľa

## Critical Files

- calculators_common.php
- calculator_ekfc.php
- tools/test_clinical_references.php
- state/SESSION.md
- state/TODO.md
- .codex/handoffs/2026-11-06-040942-ekfc-mode-label-common-loop-paused.md

## Recent Commits

- f695d7aa refactor(kalkulacky): calculatorEkfcModeLabel do calculators_common s golden pinom
- 52508d56 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe
- 5bb3e60f docs(state): handoff adpkdClassify do calculators_common s golden pinom
- 28bcf11e refactor(kalkulacky): adpkdClassify do calculators_common s golden pinom
- 50e32a04 docs(state): upresnenie HEAD vs DEPLOY_COMMIT po handoffe

## Modified Files

- (feature) calculators_common.php, calculator_ekfc.php, tools/test_clinical_references.php
- (docs v tomto behu) handoff + state

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-06-040942-ekfc-mode-label-common-loop-paused.md

## Next Command

```text
# RSI slučka je prechodne zastavená. Neštartovať tick 34.
# Pokračovať až na výslovný pokyn používateľa. Potom kandidát:
rg -n "function preventRenderOutcome|function formatInputKey|function formatResultKey" calculator_prevent.php calculator_result_print.php calculators_common.php
```
