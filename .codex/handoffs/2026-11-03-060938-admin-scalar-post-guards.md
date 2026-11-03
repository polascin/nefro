# Handoff: admin-scalar-post-guards

## Metadata

- Generated At: 2026-11-03T06:10:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 7f498c59

## Original Goal

Autonómna slučka 4: cielené skaláre v admin POST bez multi-selectov.
Claim/lease ENUM nesaheť.

## Current State

Hotové. `DEPLOY_COMMIT=7f498c59` = HEAD = origin/server.
Admin mutácie bez poľových polí odmietajú `pole[]` riadenou 400.

## Completed This Session

- [x] `requestRequireScalarPost` na admin.php, articles, content_notices,
  discussion, drugs, drugs_review, newsletter, publication_orders, providers,
  trials, users_notice (+ reauth už z Behu 140)
- [x] Providers / notices / orders: skalárne helpers namiesto `trim((string)$_POST)`
- [x] Wiring asserty v `tools/test_request_input.php` (118 PASS)
- [x] Regresie 39 PASS; PHPStan 0; deploy + smoke
- [x] Claim/lease ENUM **nebol**

## Validated

- Command: `php tools/test_request_input.php` → 118 PASS
- Command: `php tools/run_regressions.php` → 39 files PASS
- Deploy: `DEPLOY_COMMIT` 7f498c59; smoke `/`, privacy, terms 200; AGENTS 403

## Not Yet Validated

- Assumption: claim/lease stále vyžaduje výslovný súhlas
- Risk: budúci admin multi-select nesmie dostať plošný `requestRequireScalarPost`

## Remaining Work

- [ ] Claim/lease ENUM `sending` **iba so súhlasom**
- [ ] Prípadne ďalší P1 dlh z auditu (mimo claim/lease)

## Decisions Made

- Decision: Guard na všetky súčasné admin POST bez `name="…[]"` (grep 0)
- Reason: Žiadny multi-select; jednotný skorý reject je bezpečný
- Decision: Claim/lease nerobiť
- Reason: Stojaci zákaz bez súhlasu

## Blockers / Open Questions

- Žiadne. Claim/lease len so súhlasom.

## Critical Files

- admin.php
- admin_articles.php
- admin_content_notices.php
- admin_discussion.php
- admin_drugs.php
- admin_drugs_review.php
- admin_newsletter.php
- admin_publication_orders.php
- admin_providers.php
- admin_trials.php
- admin_users_notice.php
- tools/test_request_input.php

## Recent Commits

- 7f498c59 fix(admin): requestRequireScalarPost na admin POST bez multi-selectov
- 4464d167 docs(state): SHA deploy vs HEAD po handoffe Beh 141
- ed5bd134 test(clinical): P1 referencie CKD-PC a CKM

## Modified Files

- (committed) 11 admin PHP + test_request_input.php

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-03-060938-admin-scalar-post-guards.md

## Next Command

```text
# Claim/lease ENUM sending IBA so súhlasom používateľa.
# Inak vybrať ďalší P1 dlh z .audit.md / SESSION.
# php tools/run_regressions.php
```
