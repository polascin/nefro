# SESSION

Aktualizované: 2026-11-03 07:24 Europe/Bratislava

## Aktívna úloha

Cookie banner mimo a11y stromu po súhlase. Handoff:
`.codex/handoffs/2026-11-03-072407-cookie-banner-a11y.md`.

## Stav repozitára

- Vetva: `main`
- HEAD: `f5032e59`
- Runtime / `DEPLOY_COMMIT`: `f5032e59`
- `origin/main` a `server/main`: aktuálne

## Čo je hotové

1. `setCookieBannerVisible` (hidden + aria-hidden + inert)
2. Fallback + regresia + site_changelog
3. Claim/lease ENUM **nebol**

## Otvorené (ops)

Produkčný crontab vs `tools/crontab.example`: chýbajú provider_notice,
backup_snapshot, sync_drugs, sync_clinical_trials; newsletter_worker `*/30`
namiesto minútového. Úprava crontabu **iba so súhlasom**.

## Executable next step

```text
# Po súhlase: sync crontab; inak claim/lease so súhlasom alebo iný P1.
```

## Handoff

`.codex/handoffs/2026-11-03-072407-cookie-banner-a11y.md`
