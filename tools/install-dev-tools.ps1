# Stiahne lokálne vývojárske PHP nástroje (PHPStan + PHP-CS-Fixer) ako PHAR.
# Composer nie je potrebný. Spusti z koreňa projektu:  .\tools\install-dev-tools.ps1
#
# Verzie a kontrolné súčty SHA-256 určuje register tools/dependencies.json.
# Skript sťahuje presne tieto vydania a súbor uloží až po zhode súčtu, takže
# regresia tools/test_dependency_register.php prejde na každom počítači rovnako.
# Povýšenie verzie: uprav "version" v registri, spusti skript s -AllowHashMismatch,
# over nástroje a potom spusti  php tools/dependency_register.php --update.
#
# PHAR súbory sú v .gitignore, nenasadzujú sa na server (sú len pre lokálny vývoj).
# Baseline PHPStanu sa generuje iba s prepínačom -GenerateBaseline; bežná inštalácia
# ho neprepisuje, aby sa do neho nedostali nové nálezy.

param(
    [switch]$GenerateBaseline,
    [switch]$AllowHashMismatch
)

$ErrorActionPreference = 'Stop'
$toolsDir = $PSScriptRoot
$registerPath = Join-Path $toolsDir 'dependencies.json'

if (-not (Test-Path -LiteralPath $registerPath)) {
    throw "Chýba register závislostí: $registerPath"
}
$registerJson = [System.IO.File]::ReadAllText($registerPath, [System.Text.Encoding]::UTF8)
$register = $registerJson | ConvertFrom-Json

$tools = @(
    @{ Id = 'phpstan'; File = 'phpstan.phar'; Url = 'https://github.com/phpstan/phpstan/releases/download/{0}/phpstan.phar' },
    @{ Id = 'php-cs-fixer'; File = 'php-cs-fixer.phar'; Url = 'https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/releases/download/v{0}/php-cs-fixer.phar' }
)

try {
    [Net.ServicePointManager]::SecurityProtocol = [Net.ServicePointManager]::SecurityProtocol -bor [Net.SecurityProtocolType]::Tls12
} catch {
    Write-Verbose 'TLS 1.2 sa nepodarilo vynútiť, pokračujem s predvoleným nastavením.'
}

foreach ($tool in $tools) {
    $entry = $register.entries | Where-Object { $_.id -eq $tool.Id } | Select-Object -First 1
    if ($null -eq $entry) {
        throw "Register neobsahuje položku '$($tool.Id)'."
    }
    $version = [string]$entry.version
    if ($version -notmatch '^[0-9]+(\.[0-9]+){1,3}$') {
        throw "Neplatná verzia '$version' pri položke '$($tool.Id)'."
    }
    $relative = 'tools/' + $tool.File
    $expected = [string]$entry.files.$relative
    $target = Join-Path $toolsDir $tool.File
    $temp = $target + '.download'
    $url = $tool.Url -f $version

    Write-Host "Sťahujem $($entry.name) $version..." -ForegroundColor Cyan
    try {
        Invoke-WebRequest -Uri $url -OutFile $temp -UseBasicParsing
        $actual = (Get-FileHash -LiteralPath $temp -Algorithm SHA256).Hash.ToLowerInvariant()
        if ($actual -ne $expected.ToLowerInvariant()) {
            if (-not $AllowHashMismatch) {
                throw "SHA-256 nesedí pre $relative (očakávaný $expected, stiahnutý $actual). Súbor nebol nainštalovaný."
            }
            Write-Host "SHA-256 sa líši od registra ($actual). Po overení spusti: php tools/dependency_register.php --update" -ForegroundColor Yellow
        }
        Move-Item -LiteralPath $temp -Destination $target -Force
    } finally {
        if (Test-Path -LiteralPath $temp) {
            Remove-Item -LiteralPath $temp -Force
        }
    }
}

$phpstanPhar = Join-Path $toolsDir 'phpstan.phar'
$fixerPhar = Join-Path $toolsDir 'php-cs-fixer.phar'

if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
    Write-Host 'PHP nenájdený v PATH, PHAR súbory sú stiahnuté a overené súčtom, spustenie preskočené.' -ForegroundColor Yellow
    exit 0
}

Write-Host "`nVerzie:" -ForegroundColor Green
& php $phpstanPhar --version
& php $fixerPhar --version

if ($GenerateBaseline) {
    $projectRoot = Split-Path $PSScriptRoot -Parent
    $baseline = Join-Path $projectRoot 'phpstan-baseline.neon'
    Write-Host "`nGenerujem PHPStan baseline (prepíše existujúci súbor)..." -ForegroundColor Cyan
    Push-Location $projectRoot
    try {
        & php $phpstanPhar analyse --generate-baseline=$baseline --no-progress
        if ($LASTEXITCODE -ne 0) {
            throw "PHPStan skončil s kódom $LASTEXITCODE."
        }
        Write-Host 'Hotovo. Baseline: phpstan-baseline.neon' -ForegroundColor Green
    } finally {
        Pop-Location
    }
}

Write-Host "`nNástroje sú pripravené. Spúšťaj ich cez:  .\tools\quality.ps1" -ForegroundColor Green
