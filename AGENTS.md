# AGENTS.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Development commands

- Install tracked git hooks (validation, auto-push and SFTP deploy): `pwsh -File .\hooks\install.ps1`
- Initialise/update database schema and seed codebooks: `php .\setup_db.php`
- Run PHP syntax lint across the repository: `php .\tools\lint_all.php`
- Lint a single PHP file: `php -l .\path\to\file.php`
- Run newsletter queue worker manually: `php .\newsletter_worker.php --limit=50 --max-attempts=5`
- Run archive cleanup manually: `php .\archive_cleanup.php [profile_days] [avatar_days]`
- Run safe UTF-8 checks: `pwsh -File .\smoke_test.ps1 -EncodingOnly`. Run the auth/mobile-verification flow with `-TestEnvironmentConfirmed` only after verifying an isolated test database and an SMS substitute; a localhost URL alone does not prove isolation.
- Static analysis (PHAR, no Composer): `php tools\phpstan.phar analyse --no-progress` (baseline blocks only NEW issues); style: `php tools\php-cs-fixer.phar fix --dry-run --diff`. Install: `pwsh -File .\tools\install-dev-tools.ps1`.

## Runtime and configuration

- App is plain PHP (no framework) with MariaDB via PDO.
- Environment values are loaded via `config_loader.php`, with this practical priority:
  1. `NEFRO_ENV_PATH`
  2. `../nefro.env.ini`
  3. `../private/nefro.env.ini`
  4. `../private/env.ini`
  5. local fallback `env.ini` in repo root
- `db_config.php` always uses `utf8mb4` and `PDO::ATTR_EMULATE_PREPARES = false`.
- For newsletter unsubscribe signing, set `NEWSLETTER_UNSUBSCRIBE_SECRET` in env config.

## High-level architecture

### 1) Page-oriented PHP application

- Each route is a top-level `*.php` file (for example `index.php`, `search.php`, `calculator_*.php`, `admin*.php`).
- Shared bootstrap pattern on most pages:
  - `auth.php` for session/security/CSRF/auth helpers
  - `db_config.php` for PDO and shared DB helper functions
  - shared layout includes: `header.php`, `main_nav.php`, `footer.php`, `head_meta.php`

### 2) Security and session layer (`auth.php`)

- Centralises security headers (CSP nonce, HSTS, frame/content/referrer policies, etc.).
- Starts and hardens session settings, applies idle timeout, and exposes auth guards:
  - `isLoggedIn()`, `requireLogin()`, `isAdmin()`, `requireAdmin()`
- Provides CSRF token generation/validation with token rotation after POST validation.
- Requires `bot_guard.php`, which self-executes on include (no-op under CLI).

### 2b) Anti-scraping layer (`bot_guard.php`, `bot_trap.php`)

Three coordinated layers — keep their agent lists in sync when editing any one:

1. `robots.txt` — declarative; blocks SEO harvesters and AI *training* crawlers.
   AI *search* agents (OAI-SearchBot, ChatGPT-User, Claude-User, PerplexityBot)
   stay allowed: they cite and send readers back.
2. `.htaccess` — User-Agent blocklist evaluated before PHP starts, plus
   `X-Robots-Tag: noai, noimageai` (`append`, never `set` — pages set their own).
3. `bot_guard.php` — per-IP sliding-window rate limits (tiers: verified search
   bot / browser / CLI tool), burst bans, and forward-confirmed rDNS to unmask
   agents that merely claim to be Googlebot. State lives in files under
   `private/cache/botguard/`, deliberately not in the DB — a DB-backed limiter
   would amplify the very floods it is meant to absorb.

`bot_trap.php` is a honeypot: linked from the footer behind `display:none`,
disallowed in `robots.txt`, and it temporarily bans whoever follows it anyway.
Verified search bots are exempt. Never block `curl`/`wget` (used for QA) or
`wkhtmltopdf` (fetches its own images while rendering article PDFs).

#### Trusted own tools (signed token)

Rate limiting without an auth layer cannot tell your own batch tool from a
scraper — statistically they are the same shape. Looser global rules would
weaken the protection for everyone, so instead a tool proves ownership upfront
with an HMAC-signed token:

```
X-Nefro-Trust: nefro1.<tool>.<issued>.<expires>.<base64url HMAC-SHA256>
```

Mint and inspect tokens with `botguard_token.php` (CLI only, denied in
`.htaccess`):

```
php botguard_token.php --tool=ebook-builder --ttl=24h --curl
php botguard_token.php --verify=<token>
```

Verification happens in `botGuardTrustedTool()` **before** any heuristic, so a
trusted tool never depends on its User-Agent staying off the blocklist. What a
valid token changes:

- its own limit tier (`BOT_GUARD_MAX_TRUSTED`, `BOT_GUARD_BURST_TRUSTED`);
- its own accounting identity, `trust:<tool>@<ip>` — this is the important
  part: a batch run no longer consumes the human limit for the same IP, which
  is what previously turned a 600-request ebook build into a 403 for the
  author's browser;
- no bans, ever — overflow yields 429 with `Retry-After`, so a runaway loop
  still gets stopped but cannot lock the outbound IP out of the site;
- exemption from the honeypot ban in `bot_trap.php`.

A token is **not** an access grant: it unlocks no content, data, or admin, so
leaking it only lets someone scrape at a higher rate. Hence short TTLs (max 7
days, enforced on both minting *and* verification so a long-dated signature
cannot outlive the policy), the tool name in every log line, and rotation by
changing the key.

Signing key: `BOT_GUARD_TRUST_KEY` in `private/nefro.env.ini`; if absent it is
derived via `hash_hkdf` from the data-protection key with its own `info`
context (independent key material, no shared purpose, nothing to configure).
**Consequence of the default:** the derived key differs between local and
production, so mint tokens on the host that will verify them (over SSH for
production), or set an explicit `BOT_GUARD_TRUST_KEY` in both. Rotating
`private/data_protection.key` invalidates outstanding tokens.

Failed verification is logged (`trust-reject`, with the reason distinguishing
an expired own token from a forgery attempt) and falls back to the normal tier
— never to a ban, or one broken token would take down your own pipeline.

### 2c) TDM / AI-training reservation

Blocking crawlers controls *access*; this layer reserves *rights*. Under
§ 51c of the Slovak Copyright Act (185/2015 Z. z., transposing Art. 4 of
Directive (EU) 2019/790) the general text-and-data-mining exception applies
only where the use has not been **expressly reserved** — so the reservation is
what makes training on this content unlawful rather than merely unwelcome.
Note § 51b (scientific-research TDM) cannot be reserved; do not claim otherwise.

The same reservation is declared through four independent channels. **Change
them together or they will contradict each other:**

| Channel | File |
| --- | --- |
| `/.well-known/tdmrep.json` (W3C TDMRep) | `.well-known/tdmrep.json` |
| `tdm-reservation` / `tdm-policy` / `Content-Usage` HTTP headers | `.htaccess` |
| `<meta name="tdm-reservation">`, `noai, noimageai` | `head_meta.php` + `legal_head.php` (právne stránky) |
| Binding legal text | `terms.php#tdm` |

`tdm-policy.json` is the ODRL offer the first three point at (`tdm:mine` with an
`obtainConsent` duty). `Content-Usage: train-ai=n, search=y` follows the IETF
aipref drafts; `ai-use` is deliberately left unstated so citing AI search agents
stay allowed, consistent with the crawler allowlist.

`noai, noimageai` is appended to the single existing `<meta name="robots">` tag
— never add a second robots meta, some parsers take the last one as binding and
`index, follow` would be lost.

Editing the Terms does **not** require bumping `legalInfo()['version']`; the
reservation is a unilateral act effective on publication. Bumping the version
makes `legal_notice_worker.php` email every member and subscriber on its next
cron run, so that is the owner's decision, not a routine edit.

### 3) Data model and migrations (`setup_db.php`)

- Schema creation and migrations are code-driven and idempotent in one CLI script.
- Core domains in schema:
  - Users/auth/security tables (`users`, `login_attempts`, `totp_attempts`, `password_resets`, `form_rate_limit`)
  - Content and discussion (`articles`, `discussion_posts`)
  - Calculator persistence (`calculator_results`)
  - Newsletter queues/subscribers (`article_newsletter_queue`, `newsletter_subscribers`, `nl_sub_queue`)
  - Admin/audit logging (`access_logs`, `admin_users_notice_audit`, archive/audit tables)
  - Slovak codebooks (`title_codebook`, insurance, country/region/district/municipality tables)

### 4) Main feature verticals

- **Public content**: article listing and SEO-rich metadata in `index.php`; article detail in `article.php`.
- **Search**: `search.php` + `search_helpers.php` implement tokenisation, Slovak normalisation, stop-word filtering, and search fallback order:
  1. FULLTEXT (`ft_articles_search`) when available
  2. LIKE search
  3. normalised LIKE search
- **Clinical calculators**:
  - catalogue in `calculators.php`
  - individual calculators in `calculator_*.php`
  - shared patient parsing/validation/storage in `calculators_common.php`
- **Accounts and admin**:
  - auth/profile/verification pages (`login.php`, `register.php`, `profile.php`, `email_verification.php`, `mobile_verification.php`, `2fa_*`, `totp.php`)
  - admin operations in `admin.php`, `admin_articles.php`, `admin_discussion.php`, `admin_newsletter.php`
- **Newsletter pipeline**:
  - enqueue and queue-management logic in `newsletter_notifications.php`
  - delivery worker in `newsletter_worker.php` (CLI)
  - weekly digest in `newsletter_weekly_digest.php` (CLI): new articles **plus** a
    "Novinky na portáli" section fed by `site_changelog.php`
  - supports both registered users and anonymous subscribers.

## Non-obvious project constraints

- There is no Composer/PHPUnit test harness in this repo; use the provided smoke and lint scripts for verification.
- Do not introduce PHPUnit.
- Keep text and data handling UTF-8 safe; repository scripts include explicit UTF-8/BOM checks.
- Treat `.audit.md` as historical project guidance for security/accessibility/GDPR audit expectations when making sensitive changes.
- **Shipping anything user-facing that is not an article** (new calculator, tool,
  database, or a change elsewhere on the portal): add an entry to
  `site_changelog.php` in the same commit, with the date/time the change goes live.
  The weekly digest announces only entries that fall inside its window, so a
  back-dated entry may never be sent.
- **Publishing/regenerating articles** (professional `odborne` and patient `popularne`),
  including PDF generation/sync: follow `PUBLIKOVANIE_CLANKOV.md` (section "Pre AI agentov"
  has the exact step-by-step) and `PUBLIKOVANIE_PRE_PACIENTOV.md`. Use the UPSERT templates
  `add_TEMPLATE_article.php` / `add_TEMPLATE_popular_article.php`; re-running a script updates
  content + PDF and sends the newsletter only on first insert.

## Cursor Cloud specific instructions

- PHP 8.5 (Ondřej Surý packages; production is 8.5.x) and MariaDB 10.11 are provisioned by the Cloud Agent environment. PID 1 is `tini`, not systemd, so MariaDB is started as `mariadbd` rather than via `service`/`systemctl`.
- Local config is gitignored `env.ini`, a symlink to `~/.config/nefro/env.ini` (`APP_ENV=local`, `SMS_PROVIDER=log`, random local DB password). Do not commit it. `start` runs `php setup_db.php` on every boot (idempotent).
- The site is already served at `http://127.0.0.1:8080/` by `php -S`. The built-in server does not apply `.htaccess`, so request real files (`/index.php`, `/calculators.php`, `/calculator_egfr.php`). Extensionless aliases such as `/privacy` exist only under Apache in production.
- Do not run `hooks/install.ps1` in Cloud Agents. Those hooks push the current branch and SFTP-deploy to production.
- `tools/phpstan.phar` and `tools/php-cs-fixer.phar` are gitignored symlinks to `/opt/nefro-dev/`. Lint with `php tools/lint_all.php`. PHPStan: `php tools/phpstan.phar analyse --no-progress` (baseline ignores existing findings; do not regenerate it). The environment pins PHPStan 2.2.17, which matches `phpstan-baseline.neon`; 2.3.0 reports findings that baseline does not list.
