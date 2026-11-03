# SESSION

Aktualizované: 2026-11-03 05:18 Europe/Bratislava

## Aktívna úloha

Auth/newsletter POST majú `requestRequireScalarPost`. Handoff:
`.codex/handoffs/2026-11-03-051759-auth-scalar-post-guards.md`.

## Stav repozitára

- Vetva: `main`
- HEAD: `03c461fd`
- Runtime / `DEPLOY_COMMIT`: `03c461fd`
- `origin/main` a `server/main`: aktuálne

## Čo je hotové

1. Scalar guard na login, forgot/reset, resend, confirm deletion, admin_reauth
2. Newsletter verify + unsubscribe POST (a skalárne tokeny)
3. request_input wiring 107 PASS; regresie 38; deploy OK
4. Claim/lease ENUM **nebol**

## Executable next step

```text
# Voliteľne clinical refs CKD-PC/CKM, alebo claim/lease IBA so súhlasom.
```

## Handoff

`.codex/handoffs/2026-11-03-051759-auth-scalar-post-guards.md`
