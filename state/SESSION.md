# SESSION

Aktualizované: 2026-11-03 04:58 Europe/Bratislava

## Aktívna úloha

Opravený Windows regresný test Behu 138 (blokoval deploy), spevnený profil
a PREVENT clinical refs. Handoff:
`.codex/handoffs/2026-11-03-045740-request-input-prevent-refs.md`.

## Stav repozitára

- Vetva: `main`
- HEAD: `166dee58` (docs/handoff Beh 139; runtime fix `84d61269`)
- Runtime / `DEPLOY_COMMIT`: `166dee58` (zhoda s HEAD; medzi fixom a docs
  pribudol `aa9eaad7` providers lookup, tiež nasadený)
- `origin/main` a `server/main`: aktuálne
- Predchádzajúci `c0f033c7` (Beh 138) sa nenasadil samostatne; brána padala
  na Windowse a produkcia ostala na `1ed7f45d` až do `84d61269`

## Čo je hotové

1. `tools/test_request_input.php`: fixture namiesto `php -r` (100 PASS)
2. `profile.php`: `requestRequireScalarPost` + `requestScalarString` na polia
3. PREVENT golden case + model select + risk class v clinical refs (80 PASS)
4. Regresie 38 PASS; PHPStan 0; live smoke OK
5. Claim/lease ENUM **nebol**

## Executable next step

```text
# Voliteľne requestRequireScalarPost na ďalšie formuláre, alebo claim/lease IBA so súhlasom.
```

## Handoff

`.codex/handoffs/2026-11-03-045740-request-input-prevent-refs.md`
