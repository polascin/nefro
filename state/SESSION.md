# SESSION

Aktualizované: 2026-11-03 05:41 Europe/Bratislava

## Aktívna úloha

P1 clinical refs CKD-PC / CKM. Handoff:
`.codex/handoffs/2026-11-03-054047-clinical-refs-ckdpc-ckm.md`.

## Stav repozitária

- Vetva: `main`
- HEAD: `eb6e48bb` (docs Beh 141; runtime test `ed5bd134`)
- Runtime / `DEPLOY_COMMIT`: `03c461fd` (ignore drift OK: `tools/**`, docs)
- `origin/main` a `server/main`: aktuálne

## Čo je hotové

1. `tools/test_clinical_references_ckdpc_ckm.php` (37 PASS)
2. Regresie 39 PASS; live CKD-PC/CKM 200
3. Claim/lease ENUM **nebol**

## Executable next step

```text
# Cielené skaláre v admin POST bez multi-selectov, alebo claim/lease IBA so súhlasom.
```

## Handoff

`.codex/handoffs/2026-11-03-054047-clinical-refs-ckdpc-ckm.md`
