# AGENTS.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Development commands
- Install local git hooks (auto-push on commit): `pwsh -File .\hooks\install.ps1`
- Initialise/update database schema and seed codebooks: `php .\setup_db.php`
- Run PHP syntax lint across the repository: `php .\tools\lint_all.php`
- Lint a single PHP file: `php -l .\path\to\file.php`
- Run newsletter queue worker manually: `php .\newsletter_worker.php --limit=50 --max-attempts=5`
- Run archive cleanup manually: `php .\archive_cleanup.php [profile_days] [avatar_days]`
- Run smoke test script (auth/mobile-verification flow + UTF-8 checks): `pwsh -File .\smoke_test.ps1`
- Optional repo-wide checks (if Trunk CLI is installed): `trunk check`

## Runtime and configuration
- App is plain PHP (no framework) with MariaDB via PDO.
- Environment values are loaded via `config_loader.php`, with this practical priority:
  1) `NEFRO_ENV_PATH`
  2) `../nefro.env.ini`
  3) `../private/nefro.env.ini`
  4) `../private/env.ini`
  5) local fallback `env.ini` in repo root
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
  1) FULLTEXT (`ft_articles_search`) when available
  2) LIKE search
  3) normalised LIKE search
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
  - supports both registered users and anonymous subscribers.

## Non-obvious project constraints
- There is no Composer/PHPUnit test harness in this repo; use the provided smoke and lint scripts for verification.
- Do not introduce PHPUnit.
- Keep text and data handling UTF-8 safe; repository scripts include explicit UTF-8/BOM checks.
- Treat `.agent.md` as historical project guidance for security/accessibility/GDPR audit expectations when making sensitive changes.
