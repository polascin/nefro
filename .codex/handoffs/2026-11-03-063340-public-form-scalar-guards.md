# Handoff: public-form-scalar-guards

## Metadata

- Generated At: 2026-11-03T06:34:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 83cb9d40

## Original Goal

Autonómna slučka 5: iný P1 dlh mimo claim/lease. Pokračovanie request_input
na verejných/členských POST formulároch.

## Current State

Hotové. `DEPLOY_COMMIT=83cb9d40` = HEAD = origin/server.
Claim/lease ENUM **nebol**.

## Completed This Session

- [x] `requestRequireScalarPost` na discussion, content_report, verify_email,
  provider_namietka, newsletter_subscribe, logout
- [x] profile delete_account: rovnaký guard ako úprava profilu
- [x] skalárne helpers namiesto `trim((string)$_POST)` kde treba
- [x] wiring 125 PASS; regresie 39; deploy + smoke
- [x] Claim/lease ENUM **nebol**

## Validated

- Command: `php tools/test_request_input.php` → 125 PASS
- Command: `php tools/run_regressions.php` → 39 files PASS
- Deploy: `DEPLOY_COMMIT` 83cb9d40; `/` + content_report 200; discussion 302 (login); AGENTS 403

## Not Yet Validated

- Assumption: claim/lease stále vyžaduje výslovný súhlas
- Risk: `publikacia.php` má úmyselný `formats[]` (requestStringList) — plošný
  RequireScalarPost tam nesmie ísť
- Remaining: register.php ešte má `trim($_POST)` po poli (guard už na POST)

## Remaining Work

- [ ] Claim/lease ENUM `sending` **iba so súhlasom**
- [ ] Voliteľne register/2fa: `requestScalarString` namiesto zvyšného `trim($_POST)`
- [ ] Ďalší P1 dlh z auditu (ops/cron/a11y) mimo claim/lease

## Decisions Made

- Decision: Verejné formuláre pred claim/lease
- Reason: Claim/lease zakázané; TypeError na discussion/DSA je reálny P1
- Decision: Claim/lease nerobiť
- Reason: Stojaci zákaz bez súhlasu

## Blockers / Open Questions

- Žiadne. Claim/lease len so súhlasom.

## Critical Files

- discussion.php
- content_report.php
- verify_email.php
- provider_namietka.php
- newsletter_subscribe.php
- logout.php
- profile.php
- tools/test_request_input.php

## Recent Commits

- 83cb9d40 fix(forms): requestRequireScalarPost na diskusiu, DSA a overenia
- 45a595cc docs(state): SHA deploy vs HEAD po handoffe Beh 142
- 7f498c59 fix(admin): requestRequireScalarPost na admin POST bez multi-selectov

## Modified Files

- (committed) 7 form PHP + test_request_input.php

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-03-063340-public-form-scalar-guards.md

## Next Command

```text
# Claim/lease IBA so súhlasom; inak register requestScalarString cleanup
# alebo ďalší P1 z .audit.md (ops/cron/a11y).
# php tools/run_regressions.php
```
