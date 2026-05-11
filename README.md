# nefro

## Konfiguracia mimo webroot

Appka vie nacitat secrets v tomto poradi:

1. cesta z premennej prostredia `NEFRO_ENV_PATH`
2. `../nefro.env.ini`
3. `../private/nefro.env.ini`
4. `../private/env.ini`
5. lokalny fallback `env.ini` v root priecinku aplikacie

Pre produkciu na hostingu pouzi odporucane umiestnenie mimo webroot, napr. `../private/nefro.env.ini`, a nenahravaj produkcne hesla do verejne pristupneho root adresara webu.

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
