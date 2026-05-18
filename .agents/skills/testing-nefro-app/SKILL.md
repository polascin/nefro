---
name: testing-nefro-app
description: Test the Nefro PHP application end-to-end. Use when verifying navigation, authentication, or UI changes.
---

# Testing the Nefro Application

## Environment Setup

1. Install PHP 8.1+ with required extensions:
   ```bash
   sudo apt-get install -y php php-mysql php-mbstring php-xml php-curl
   ```

2. Start MySQL and create the database:
   ```bash
   sudo service mysql start
   sudo mysql -e "CREATE DATABASE IF NOT EXISTS nefro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   sudo mysql -e "CREATE USER IF NOT EXISTS 'nefro'@'localhost' IDENTIFIED BY 'nefro_pass'; GRANT ALL ON nefro.* TO 'nefro'@'localhost'; FLUSH PRIVILEGES;"
   ```

3. Create `env.ini` in the repo root (if not present):
   ```ini
   DB_HOST=localhost
   DB_NAME=nefro
   DB_USER=nefro
   DB_PASS=nefro_pass
   APP_ENV=development
   ```

4. Initialize the database schema:
   ```bash
   cd /home/ubuntu/repos/nefro
   php -S localhost:8080 &
   curl -s http://localhost:8080/setup_db.php
   ```

5. Create test users (via MySQL):
   ```sql
   -- Admin user
   INSERT INTO users (username, email, password_hash, first_name, last_name, is_admin, is_active, email_verified)
   VALUES ('testadmin', 'admin@test.local', '<bcrypt_hash_of_TestPass123!>', 'Test', 'Admin', 1, 1, 1);
   
   -- Regular user
   INSERT INTO users (username, email, password_hash, first_name, last_name, is_admin, is_active, email_verified)
   VALUES ('testuser', 'user@test.local', '<bcrypt_hash_of_TestPass123!>', 'Test', 'User', 0, 1, 1);
   ```
   Generate the password hash with: `php -r "echo password_hash('TestPass123!', PASSWORD_DEFAULT);"`

## Running the Dev Server

```bash
cd /home/ubuntu/repos/nefro
php -S localhost:8080
```

The app is then accessible at `http://localhost:8080/index.php`.

## Key Application Architecture

- **Navigation components**: `main_nav.php` (main), `admin_menu.php` (admin), `header_profile.php` (header profile), `footer.php`
- **Authentication**: Session-based with `password_hash()` / `password_verify()`
- **Logout**: Requires POST method with CSRF token (via `logout.php`). Plain GET links to logout.php will NOT work.
- **Language**: All UI text is in Slovak
- **CSRF**: Generated via `generateCsrfToken()` function, validated on POST requests

## Testing Navigation

### What to verify on each page:
1. `<nav class="main-nav">` with `aria-label="Hlavná navigácia"` is present
2. Active page link has `class="active"` and `aria-current="page"`
3. Logged-in nav shows: Domov, Služby, Kontakt, Kalkulačky, Vyhľadávanie, Môj profil, [Admin links if admin], Odhlásiť sa
4. Non-logged-in nav shows: Domov, Služby, Kontakt, Kalkulačky, Vyhľadávanie, Prihlásenie, Registrácia

### Critical: Logout verification
- Logout buttons must be `<form method="post">` with hidden `<input name="csrf_token">` — NOT plain `<a>` links
- After clicking logout, verify the header changes to "Neprihlásený používateľ" (session destroyed)
- Check logout in: main_nav.php, admin_menu.php, footer.php, header_profile.php

### Pages that should have navigation:
- `index.php`, `login.php`, `register.php`, `forgot_password.php`, `reset_password.php`, `profile.php`
- All calculator pages (`calculators.php`, `calc_*.php`)
- `admin.php`, `admin_articles.php`, `admin_users_notice.php`
- `search.php`, `privacy.php`

## Common Issues

- If logout doesn't work, check that the form uses `method="post"` and includes a valid CSRF token
- The `setup_db.php` script creates all necessary tables; run it before testing
- Email verification must be set to 1 for test users to be able to log in
- Admin features only visible when `is_admin=1` in the users table
