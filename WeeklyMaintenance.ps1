[CmdletBinding()]
param(
    [ValidatePattern('^[A-Za-z]$')]
    [string]$DriveLetter = 'C',

    [ValidateNotNullOrEmpty()]
    [string]$ReportDirectory = "$env:ProgramData\WindowsWeeklyMaintenance",

    [switch]$InstallScheduledTask
)

$ErrorActionPreference = 'Stop'

function Test-Administrator {
    $identity = [Security.Principal.WindowsIdentity]::GetCurrent()
    $principal = New-Object Security.Principal.WindowsPrincipal($identity)
    return $principal.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
}

function Convert-WingetStatus {
    param(
        [int]$ExitCode,
        [string]$OutputText
    )

    if ($ExitCode -ne 0) {
        return 'FAILED'
    }
    if ($OutputText -match 'No available upgrade found' -or $OutputText -match 'No applicable upgrade found') {
        return 'UP_TO_DATE'
    }
    if ($OutputText -match 'Successfully installed') {
        return 'UPDATED'
    }
    return 'UNKNOWN'
}

function Convert-DismStatus {
    param(
        [int]$ExitCode,
        [string]$OutputText
    )

    if ($ExitCode -ne 0) {
        return 'FAILED'
    }
    if ($OutputText -match 'No component store corruption detected') {
        return 'HEALTHY'
    }
    return 'UNKNOWN'
}

function Convert-SfcStatus {
    param(
        [int]$ExitCode,
        [string]$OutputText
    )

    if ($ExitCode -ne 0) {
        return 'FAILED'
    }
    if ($OutputText -match 'did not find any integrity violations') {
        return 'HEALTHY'
    }
    if ($OutputText -match 'found corrupt files and successfully repaired them') {
        return 'REPAIRED'
    }
    if ($OutputText -match 'found corrupt files but was unable to fix some') {
        return 'ATTENTION_REQUIRED'
    }
    return 'UNKNOWN'
}

function Convert-ChkdskStatus {
    param(
        [int]$ExitCode,
        [string]$OutputText
    )

    if ($ExitCode -ne 0) {
        return 'FAILED'
    }
    if ($OutputText -match 'found no problems') {
        return 'HEALTHY'
    }
    return 'ATTENTION_REQUIRED'
}

if (-not (Test-Administrator)) {
    throw 'Skript musí byť spustený ako správca (Run as Administrator).'
}

New-Item -ItemType Directory -Path $ReportDirectory -Force | Out-Null

$timestamp = Get-Date -Format 'yyyyMMdd-HHmmss'
$transcriptPath = Join-Path $ReportDirectory "WeeklyMaintenance-$timestamp.log"
$reportTextPath = Join-Path $ReportDirectory "WeeklyMaintenance-$timestamp.txt"
$reportJsonPath = Join-Path $ReportDirectory "WeeklyMaintenance-$timestamp.json"
$startedAt = Get-Date

Start-Transcript -Path $transcriptPath -Force | Out-Null

try {
    Write-Host '=== Týždenná údržba Windows ==='
    Write-Host "Štart: $startedAt"
    $wingetExit = -1
    $wingetText = ''
    $wingetStatus = 'NOT_AVAILABLE'

    Write-Host "`n[1/5] Winget upgrade (bez interakcie)..."
    if (Get-Command winget.exe -ErrorAction SilentlyContinue) {
        $wingetOutput = & winget.exe upgrade --all --include-unknown --accept-source-agreements --accept-package-agreements --disable-interactivity --silent 2>&1
        $wingetExit = $LASTEXITCODE
        $wingetText = ($wingetOutput | Out-String).Trim()
        $wingetStatus = Convert-WingetStatus -ExitCode $wingetExit -OutputText $wingetText
    } else {
        $wingetText = 'winget.exe nie je dostupný v PATH.'
    }

    Write-Host "`n[2/5] DISM CheckHealth..."
    $dismOutput = & dism.exe /Online /Cleanup-Image /CheckHealth 2>&1
    $dismExit = $LASTEXITCODE
    $dismText = ($dismOutput | Out-String).Trim()
    Write-Host "`n[3/5] SFC /scannow..."
    $sfcOutput = & sfc.exe /scannow 2>&1
    $sfcExit = $LASTEXITCODE
    $sfcText = ($sfcOutput | Out-String).Trim()
    Write-Host "`n[4/5] CHKDSK $DriveLetter`: /scan..."
    $chkdskOutput = & chkdsk.exe "$DriveLetter`:" /scan 2>&1
    $chkdskExit = $LASTEXITCODE
    $chkdskText = ($chkdskOutput | Out-String).Trim()
    Write-Host "`n[5/5] Kontrola optimalizácie disku..."
    $defragEvents = Get-WinEvent -FilterHashtable @{
        LogName      = 'Application'
        ProviderName = 'Microsoft-Windows-Defrag'
        Id           = 258
        StartTime    = (Get-Date).AddDays(-21)
    } -ErrorAction SilentlyContinue |
    Sort-Object TimeCreated -Descending |
    Select-Object -First 5 TimeCreated, Id, LevelDisplayName, Message

    $scheduledDefragInfo = $null
    try {
        $scheduledDefragInfo = Get-ScheduledTask -TaskPath '\Microsoft\Windows\Defrag\' -TaskName 'ScheduledDefrag' -ErrorAction Stop |
        Get-ScheduledTaskInfo -ErrorAction Stop
    } catch {
        $scheduledDefragInfo = $null
    }

    $dismStatus = Convert-DismStatus -ExitCode $dismExit -OutputText $dismText
    $sfcStatus = Convert-SfcStatus -ExitCode $sfcExit -OutputText $sfcText
    $chkdskStatus = Convert-ChkdskStatus -ExitCode $chkdskExit -OutputText $chkdskText

    $overallStatus = if (
        $wingetStatus -ne 'FAILED' -and
        $dismStatus -eq 'HEALTHY' -and
        ($sfcStatus -eq 'HEALTHY' -or $sfcStatus -eq 'REPAIRED') -and
        $chkdskStatus -eq 'HEALTHY'
    ) {
        'HEALTHY'
    } else {
        'ATTENTION_REQUIRED'
    }

    $osInfo = Get-CimInstance Win32_OperatingSystem | Select-Object Caption, Version, BuildNumber, LastBootUpTime
    $finishedAt = Get-Date

    $reportObject = [ordered]@{
        generated_at   = $finishedAt.ToString('s')
        started_at     = $startedAt.ToString('s')
        finished_at    = $finishedAt.ToString('s')
        overall_status = $overallStatus
        computer_name  = $env:COMPUTERNAME
        os             = $osInfo
        checks         = [ordered]@{
            winget_upgrade  = [ordered]@{
                status    = $wingetStatus
                exit_code = $wingetExit
                command   = 'winget upgrade --all --include-unknown --accept-source-agreements --accept-package-agreements --disable-interactivity --silent'
            }
            dism_checkhealth = [ordered]@{
                status    = $dismStatus
                exit_code = $dismExit
            }
            sfc_scannow      = [ordered]@{
                status    = $sfcStatus
                exit_code = $sfcExit
            }
            chkdsk_scan      = [ordered]@{
                status    = $chkdskStatus
                exit_code = $chkdskExit
                drive     = "$DriveLetter`:"
            }
        }
        defrag         = [ordered]@{
            scheduled_task = if ($scheduledDefragInfo) {
                [ordered]@{
                    last_run_time    = $scheduledDefragInfo.LastRunTime
                    last_task_result = $scheduledDefragInfo.LastTaskResult
                    next_run_time    = $scheduledDefragInfo.NextRunTime
                }
            } else {
                $null
            }
            latest_events  = $defragEvents
        }
        artefacts      = [ordered]@{
            transcript = $transcriptPath
            text_report = $reportTextPath
            json_report = $reportJsonPath
        }
    }

    $textReport = @(
        '=== Týždenný report údržby Windows ==='
        "Vygenerované: $($finishedAt.ToString('yyyy-MM-dd HH:mm:ss'))"
        "Počítač: $env:COMPUTERNAME"
        "OS: $($osInfo.Caption) $($osInfo.Version) (build $($osInfo.BuildNumber))"
        "Posledný boot: $($osInfo.LastBootUpTime)"
        ''
        '--- Stav kontrol ---'
        "Winget upgrade: $wingetStatus (exit code $wingetExit)"
        "DISM CheckHealth: $dismStatus (exit code $dismExit)"
        "SFC /scannow: $sfcStatus (exit code $sfcExit)"
        "CHKDSK $DriveLetter`: /scan: $chkdskStatus (exit code $chkdskExit)"
        ''
        '--- Optimalizácia disku ---'
    )

    if ($scheduledDefragInfo) {
        $textReport += "ScheduledDefrag - LastRunTime: $($scheduledDefragInfo.LastRunTime)"
        $textReport += "ScheduledDefrag - LastTaskResult: $($scheduledDefragInfo.LastTaskResult)"
        $textReport += "ScheduledDefrag - NextRunTime: $($scheduledDefragInfo.NextRunTime)"
    } else {
        $textReport += 'ScheduledDefrag info: nedostupné'
    }

    if ($defragEvents) {
        $textReport += ''
        $textReport += 'Posledné eventy defragmentácie/optimalizácie:'
        foreach ($event in $defragEvents) {
            $message = ($event.Message -replace '\s+', ' ').Trim()
            $textReport += "- $($event.TimeCreated): $message"
        }
    } else {
        $textReport += 'Posledné eventy defragmentácie/optimalizácie: nenašli sa.'
    }

    $textReport += ''
    $textReport += "CELKOVÝ STAV: $overallStatus"

    if ($overallStatus -eq 'HEALTHY') {
        $textReport += 'Odporúčanie: pokračovať v týždennom cykle údržby.'
    } else {
        $textReport += 'Odporúčanie: spustiť DISM /RestoreHealth a následne opäť SFC /scannow.'
    }

    $textReport | Set-Content -Path $reportTextPath -Encoding UTF8
    $reportObject | ConvertTo-Json -Depth 8 | Set-Content -Path $reportJsonPath -Encoding UTF8

    if ($InstallScheduledTask) {
        $taskName = 'WeeklyWindowsMaintenance'
        $taskCommand = "pwsh.exe -NoProfile -ExecutionPolicy Bypass -File `"$PSCommandPath`" -DriveLetter $DriveLetter -ReportDirectory `"$ReportDirectory`""
        $schtasksOutput = & schtasks.exe /Create /TN $taskName /SC WEEKLY /D MON /ST 03:00 /RU SYSTEM /RL HIGHEST /TR $taskCommand /F 2>&1
        if ($LASTEXITCODE -ne 0) {
            throw "Nepodarilo sa vytvoriť plánovanú úlohu '$taskName'. Výstup: $($schtasksOutput -join ' ')"
        }
        Write-Host "Naplánovaná úloha vytvorená/aktualizovaná: $taskName"
    }

    Write-Host ''
    Write-Host "Textový report: $reportTextPath"
    Write-Host "JSON report: $reportJsonPath"
    Write-Host "Transcript: $transcriptPath"
}
finally {
    Stop-Transcript | Out-Null
}
