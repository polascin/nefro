# TODO

## Ďalšia slučka

1. Legal notice claim/lease (ENUM + worker port z newsletter vzoru) — podľa DECISIONS.md.
2. Inak P1 z `.audit.md`.

## Hotové: slučka 2026-11-03-j (cron sync + newsletter sending)

- [x] Produkčný crontab = `tools/crontab.example` + preserve polascin.net
- [x] Migrácia ENUM `sending` na newsletter frontách
- [x] RSI: render/verify/lib, ops_health ENUM, LF pin
- [x] deploy `bad2398d`; ops_health PASS

## Hotové: slučka 2026-11-03-i … a

- [x] a11y unit selecty; crontab/CLI ops; cookie a11y; scalar guards; clinical refs

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Legal ENUM sending (až po porte kódu).
- `provider_notice_worker --send` (vedomé rozhodnutie, nie cron).
