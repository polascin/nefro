# Deploy – nefro.polascin.net

Automatické nasadenie cez GitHub Actions (`.github/workflows/deploy.yml`):
po každom pushi do `main` (alebo manuálne cez **Actions → Deploy → Run
workflow**) sa repozitár zosynchronizuje rsyncom do web rootu na WebSupport.
Súbory vylúčené v `.deployignore` sa nenasadzujú; `--delete` sa nepoužíva,
takže serverové súbory mimo repozitára zostávajú nedotknuté. Push s
`[skip deploy]` v commit message deploy preskočí.

Kým secrets nie sú nastavené, deploy job sa iba preskočí s upozornením
(workflow nezlyhá).

## GitHub Secrets (Settings → Secrets and variables → Actions)

| Secret               | Popis                                                                |
| -------------------- | -------------------------------------------------------------------- |
| `DEPLOY_HOST`        | SSH host, napr. `shell.r1.websupport.sk`                              |
| `DEPLOY_USER`        | SSH používateľ, napr. `uid58858`                                      |
| `DEPLOY_PORT`        | SSH port (WebSupport shell používa `26650`; predvolené `22`)          |
| `DEPLOY_SSH_KEY`     | Celý obsah privátneho SSH kľúča                                       |
| `DEPLOY_KNOWN_HOSTS` | Host key servera (`ssh-keyscan -p <port> <host>`), formát `[host]:port` |
| `DEPLOY_REMOTE_PATH` | `/data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro` |

Fingerprint z `ssh-keyscan` over aj nezávisle u poskytovateľa hostingu.
Lokálny SFTP hook (`hooks/deploy.sh`) zostáva funkčný ako záložný spôsob —
nespúšťaj ho súčasne s bežiacim Actions deployom.
