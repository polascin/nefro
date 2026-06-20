# nefro

## Konfiguracia mimo webroot

Appka vie nacitat secrets v tomto poradi:

1. cesta z premennej prostredia `NEFRO_ENV_PATH`
2. `../nefro.env.ini`
3. `../private/nefro.env.ini`
4. `../private/env.ini`
5. lokalny fallback `env.ini` v root priecinku aplikacie

Pre produkciu na hostingu pouzi odporucane umiestnenie mimo webroot, napr. `../private/nefro.env.ini`, a nenahravaj produkcne hesla do verejne pristupneho root adresara webu.

Pre podpisovanie odhlasovacich odkazov z newslettera nastav aj:

- `NEWSLETTER_UNSUBSCRIBE_SECRET=...` (dlhy nahodny retazec)
- `DATA_PROTECTION_KEY=...` (dlhy nahodny retazec pre sifrovanie 2FA a pseudonymizaciu URL)

Pre oba uceli moze aplikacia pouzit fallback `APP_KEY` alebo `APP_SECRET`; samostatne kluce su odporucane.
Ak ziaden data-protection kluc nie je nastaveny, aplikacia jednorazovo vytvori `private/data_protection.key`. Tento subor musi ostat sukromny a musi byt zahrnuty v zalohach, inak nebude mozne desifrovat existujuce 2FA tajomstva.

## Smoke Test: Prihlásenie

Použi krátky smoke test po zmenách v autentifikácii. Over minimálne tieto 3 scenáre:

1. Overený používateľ

- Prihlásenie s platným účtom a overeným e-mailom.
- Očakávanie: úspešné prihlásenie a presmerovanie na `index.php`.

1. Neoverený používateľ

- Prihlásenie s platným účtom, kde `email_verified_at` je `NULL`.
- Očakávanie: prihlásenie je povolené, ale po prihlásení sa zobrazí upozornenie o neoverenom e-maile a obmedzení služieb.

1. Blokovaná IP

- Simuluj viac neúspešných pokusov alebo nastav `blocked_until` do budúcnosti pre testovaciu IP.
- Očakávanie: prihlásenie je odmietnuté a stránka zobrazí dôvod + zostávajúci čas blokácie.

Odporúčanie: po teste vyčisti testovacie záznamy v `login_attempts` a testovacích používateľov.

## Voliteľné overenie mobilného čísla

Overenie mobilu je voliteľné a prebieha cez 6-miestny SMS kód v profile používateľa.

- Lokálny vývoj: `SMS_PROVIDER=log` (kód sa zapíše do PHP error logu).
- Produkcia: nakonfiguruj reálneho SMS providera cez `SMS_PROVIDER` a prípadne `SMS_SENDER`.
- Ak je provider neimplementovaný, odoslanie v produkcii zlyhá zámerne, aby sa nepoužívali falošné "odoslané" kódy.

### Twilio Verify

Pre Twilio nastav v env súbore minimálne:

- `SMS_PROVIDER=twilio_verify`
- `SMS_TWILIO_ACCOUNT_SID=...`
- `SMS_TWILIO_AUTH_TOKEN=...`
- `SMS_TWILIO_VERIFY_SERVICE_SID=VA330ca23508539352eb04fa85d784cddc`

Poznámka: `VA...` je Twilio Verify Service SID (nie Phone Number SID). Overovací kód sa potom posiela a validuje priamo cez Twilio Verify API.

## Automatické e-mailové novinky pri novom článku

Pri publikovaní článku v administrácii sa e-mailové novinky zapisujú do fronty `article_newsletter_queue`.

- Posiela sa iba používateľom, ktorí majú:
  - `newsletter_consent = 1`
  - `is_active = 1`
  - overený e-mail (`email_verified_at` nie je `NULL`)
- SMS sa v tomto procese nepoužíva.
- Každý newsletter obsahuje na konci jedinečný odkaz na odhlásenie odberu.
- Odkaz otvorí potvrdzovací formulár; až CSRF-chránený POST nastaví `newsletter_consent = 0` a zruší čakajúce položky vo fronte (`pending`/`failed`).

### Spustenie workeru

Worker spracovania fronty je CLI skript:

```bash
php newsletter_worker.php --limit=50 --max-attempts=5
```

Odporúčanie: spúšťať cez plánovač úloh (Task Scheduler/cron) každú 1 minútu.

## Python code quality (Black + Pylint)

This repository is primarily PHP, but Black and Pylint are configured for any Python files you add.

```powershell
$pyFiles = Get-ChildItem -Path . -Recurse -Filter *.py | ForEach-Object { $_.FullName }
$pyFiles = $pyFiles | Where-Object { $_ -notmatch "\\\\.trunk\\\\" -and $_ -notmatch "\\\\.git\\\\" }
if ($pyFiles.Count -gt 0) {
  python -m black $pyFiles
  python -m pylint $pyFiles
} else {
  Write-Host "No Python files found."
}
```
