# nefro

## Smoke Test: Prihlásenie

Použi krátky smoke test po zmenách v autentifikácii. Over minimálne tieto 3 scenáre:

1. Overený používateľ
- Prihlásenie s platným účtom a overeným e-mailom.
- Očakávanie: úspešné prihlásenie a presmerovanie na `index.php`.

2. Neoverený používateľ
- Prihlásenie s platným účtom, kde `email_verified_at` je `NULL`.
- Očakávanie: prihlásenie je povolené, ale po prihlásení sa zobrazí upozornenie o neoverenom e-maile a obmedzení služieb.

3. Blokovaná IP
- Simuluj viac neúspešných pokusov alebo nastav `blocked_until` do budúcnosti pre testovaciu IP.
- Očakávanie: prihlásenie je odmietnuté a stránka zobrazí dôvod + zostávajúci čas blokácie.

Odporúčanie: po teste vyčisti testovacie záznamy v `login_attempts` a testovacích používateľov.
