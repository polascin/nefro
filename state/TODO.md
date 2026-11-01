# TODO

## Ďalšia slučka (P0/P1)

1. Po súhlase: migrácia `sending` + claim/lease pre `legal_notice_queue` a `legal_notice_sub_queue` (vzor newsletter).
2. A11y: klávesnica / 320 px / chyby formulárov (P1 plán).
3. Voliteľné: doplniť prioritu jedinému aktívnemu záznamu bez priority (produkcia: 1 empty).

## Hotové v slučke 2

- [x] Produkčný ops_health --no-http
- [x] Defense-in-depth deny add_provider* + provider_notice_worker
- [x] DB-čas retry v legal_notifications
- [x] Overenie priorít na produkcii (read-only)

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / workery bez konkrétneho súhlasu.
