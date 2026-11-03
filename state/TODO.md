# TODO

## Ďalšia slučka

1. Po **výslovnom súhlase**: ENUM `sending` + claim/lease; empty provider priority.
2. Voliteľne `register.php` / 2fa: `requestScalarString` namiesto zvyšného `trim($_POST)`.
3. Inak ďalší P1 dlh z `.audit.md` (ops/cron/a11y; nie claim/lease bez súhlasu).

## Hotové: slučka 2026-11-03-e (public form scalar guards)

- [x] discussion, content_report, verify_email, provider_namietka, subscribe, logout
- [x] profile delete_account; deploy `83cb9d40`
- [x] bez claim/lease ENUM

## Hotové: slučka 2026-11-03-d (admin scalar guards)

- [x] admin mutácie; deploy `7f498c59`

## Hotové: slučka 2026-11-03-c / b / a

- [x] CKD-PC/CKM refs; auth scalar; request_input Windows + PREVENT

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority bez súhlasu.
