# TODO

## Ďalšia slučka

1. Po **súhlase**: zosúladiť produkčný crontab s `tools/crontab.example`
   (provider_notice_worker, backup_snapshot, sync_drugs, sync_clinical_trials;
   interval newsletter_worker).
2. Po **výslovnom súhlase**: ENUM `sending` + claim/lease.
3. Inak ďalší P1 z `.audit.md`.

## Hotové: slučka 2026-11-03-g (cookie banner a11y)

- [x] HTML hidden + aria-hidden + inert; fallback; test; changelog
- [x] deploy `f5032e59`; bez claim/lease ENUM

## Hotové: slučka 2026-11-03-f … a

- [x] register/2fa scalar; public/admin/auth scalar; CKD-PC/CKM; Windows fixture

## Vedomé mimo rozsahu

- Newsletter avíza (default off).
- Sociálne siete.
- Produkčné SQL / migrácie / seed priority / crontab bez súhlasu.
