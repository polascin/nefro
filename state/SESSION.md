# SESSION

Aktualizované: 2026-11-02 00:16 Europe/Bratislava

## Aktívna úloha

Vývojová slučka Nefro (iterácia 7 dokončená). Handoff:
`.codex/handoffs/2026-11-02-001545-nefro-dev-loop.md`.

## Stav repozitára

- Vetva: `main`
- HEAD: `8e80d4f0` (docs state/handoff)
- Runtime / `DEPLOY_COMMIT`: `7a7fb854` (docs-only drift OK)
- `origin/main` a `server/main`: aktuálne

## Čo je hotové v slučke 7

1. Rozšírenie `request_input` na auth, články, lieky, štúdie, publikácie, tokeny.
2. PreferPost + heslá bez trim; regresia 57 PASS.
3. Claim/lease a seed priority **nebolo**.

## Executable next step

```text
# request_input na admin_drugs/trials/articles, alebo P1 autori.
# Claim/lease IBA so súhlasom.
```

## Handoff

`.codex/handoffs/2026-11-02-001545-nefro-dev-loop.md`
