# TODO

## Ďalšia slučka (P0)

1. Spustiť produkčný `php ops_health.php --no-http` cez SSH a zaznamenať `retry_overdue` / vek frontov.
2. Defense-in-depth: doplniť `add_providers_*.php` seed/migračné skripty do `.htaccess` / `robots.txt` deny (majú CLI/admin guard).
3. Overiť (bez spustenia, pokiaľ nie je súhlas), či e-VÚC seed a priority seed už bežali na produkčnej DB.

## Neskôr (P1 z plánu rozvoja)

- Spoľahlivé fronty: claim/lease, krátke transakcie, test prerušenia po SMTP.
- Oddelenie bootstrapov (config / session / HTTP / CLI).
- A11y: klávesnica, mobil 320 px, chyby formulárov.
- Klinické referenčné testy kalkulačiek (vyžaduje odborné schválenie).

## Vedomé mimo rozsahu

- Newsletter avíza (default off, neposielať bez výslovnej požiadavky).
- Sociálne siete (nepublikovať bez výslovnej požiadavky).
- Produkčné SQL / migrácie / workery bez konkrétneho súhlasu.
