# Handoff: auth-scalar-post-guards

## Metadata

- Generated At: 2026-11-03T05:18:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 03c461fd

## Original Goal

Autonómna slučka 2: najvyšší dlh po Behu 139. Claim/lease ENUM nesaheť.
Kandidát: `requestRequireScalarPost` na ďalšie POST formuláre bez polí.

## Current State

Hotové. `DEPLOY_COMMIT=03c461fd` = HEAD = `origin/main` = `server/main`.
Auth a newsletter POST endpointy odmietajú poľové parametre riadenou 400.

## Completed This Session

- [x] `requestRequireScalarPost` na login, forgot/reset, resend, confirm deletion,
  admin_reauth, newsletter_verify_sub, newsletter_unsubscribe
- [x] Heslá v reset/admin_reauth cez `requestScalarString(..., trim=false)`
- [x] Unsubscribe/verify tokeny cez skalárne helpers
- [x] Wiring asserty v `tools/test_request_input.php` (107 PASS)
- [x] Regresie 38 PASS; PHPStan 0; deploy + smoke
- [x] Claim/lease ENUM **nebol**

## Validated

- Command: `php tools/test_request_input.php` → 107 PASS
- Command: `php tools/run_regressions.php` → 38 files PASS
- Deploy: `DEPLOY_COMMIT` 03c461fd; smoke `/`, privacy, terms 200
- Live: `/login.php`, `/forgot_password.php` 200; `/AGENTS.md` 403

## Not Yet Validated

- Risk: admin katalógy s úmyselnými poľami (`formats[]` a pod.) nemôžu dostať
  plošný `requestRequireScalarPost` bez výnimiek
- Assumption: claim/lease stále vyžaduje výslovný súhlas

## Remaining Work

- [ ] Voliteľne clinical refs CKD-PC / CKM
- [ ] Claim/lease ENUM `sending` **iba so súhlasom**
- [ ] Admin POST: cielené skaláre tam, kde nie sú listové polia

## Decisions Made

- Decision: Auth/newsletter guard pred CSRF; admin katalógy tento beh nie
- Reason: Auth formuláre nemajú poľové polia; admin má multi-selecty
- Decision: Claim/lease nerobiť
- Reason: Stojaci zákaz bez súhlasu

## Blockers / Open Questions

- Žiadne. Claim/lease len so súhlasom.

## Critical Files

- login.php
- forgot_password.php
- reset_password.php
- resend_verification.php
- confirm_account_deletion.php
- admin_reauth.php
- newsletter_verify_sub.php
- newsletter_unsubscribe.php
- tools/test_request_input.php

## Recent Commits

- 03c461fd fix(auth): requestRequireScalarPost na login, reset a newsletter POST
- b726eba0 docs(state): finalny HEAD po SHA sync Beh 139
- 84d61269 fix(auth): Windows fixture pre requestRequireScalarPost a PREVENT referencie

## Modified Files

- (committed) 8 auth/newsletter PHP + test_request_input.php

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-03-051759-auth-scalar-post-guards.md

## Next Command

```text
# Voliteľne CKD-PC/CKM clinical refs, ALEBO claim/lease IBA so súhlasom.
# php tools/run_regressions.php
```
