## Req
Docker Desktop / Docker Engine

### macOS / Linux

```bash
chmod +x setup.sh
./setup.sh
```

### Windows (PowerShell)

```powershell
Set-ExecutionPolicy -Scope Process Bypass
.\setup.ps1
```

Open: http://localhost:8080

To stop:

```bash
./vendor/bin/sail down
```

Windows:

```powershell
docker compose down
```

