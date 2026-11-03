# Handoff: register-2fa-scalar-cleanup

## Metadata

- Generated At: 2026-11-03T06:59:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 8bc17a45

## Original Goal

Autonómna slučka 6: register/2fa `requestScalarString` cleanup.
Claim/lease ENUM nesaheť.

## Current State

Hotové. `DEPLOY_COMMIT=8bc17a45` = HEAD = origin/server.
Claim/lease ENUM **nebol**.

## Completed This Session

- [x] `register.php`: žiadne `trim($_POST)`; polia/heslá/telefóny cez helpers
- [x] `2fa_setup.php`: action, heslá (bez trimu), totp_confirm_code
- [x] `2fa_verify.php`: totp_code cez requestScalarString
- [x] wiring 128 PASS; regresie 39; deploy + smoke
- [x] Claim/lease ENUM **nebol**

## Validated

- Command: `php tools/test_request_input.php` → 128 PASS
- Command: `php tools/run_regressions.php` → 39 files PASS
- PHPStan: 0 na register/2fa
- Deploy: `DEPLOY_COMMIT` 8bc17a45; `/`, `/register.php` 200; AGENTS 403

## Not Yet Validated

- Assumption: claim/lease stále vyžaduje výslovný súhlas
- Note: HTML re-display v register ešte číta `$_POST['…']` pri chybe (po
  `requestRequireScalarPost` už nie je pole)

## Remaining Work

- [ ] Claim/lease ENUM `sending` **iba so súhlasom**
- [ ] Ďalší P1 z auditu (ops/cron/a11y) mimo claim/lease

## Decisions Made

- Decision: register/2fa cleanup pred ops/cron
- Reason: Explicitný kandidát zo SESSION; dokončuje request_input P1 na auth
- Decision: Claim/lease nerobiť
- Reason: Stojaci zákaz bez súhlasu

## Blockers / Open Questions

- Žiadne. Claim/lease len so súhlasom.

## Critical Files

- register.php
- 2fa_setup.php
- 2fa_verify.php
- tools/test_request_input.php

## Recent Commits

- 8bc17a45 fix(auth): register a 2FA čítajú POST cez requestScalarString
- b2883c2c docs(state): SHA deploy vs HEAD po handoffe Beh 143
- 83cb9d40 fix(forms): requestRequireScalarPost na diskusiu, DSA a overenia

## Modified Files

- (committed) register.php, 2fa_setup.php, 2fa_verify.php, test_request_input.php

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-03-065908-register-2fa-scalar-cleanup.md

## Next Command

```text
# Claim/lease IBA so súhlasom; inak P1 ops/cron/a11y z .audit.md.
# php tools/run_regressions.php
```
