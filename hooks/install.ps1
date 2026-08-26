# Run from anywhere inside the repository: pwsh -File .\hooks\install.ps1

$ErrorActionPreference = "Stop"

$repoRoot = (& git rev-parse --show-toplevel 2>$null)
if (-not $repoRoot) {
    throw "Git repository not found."
}

$repoRoot = $repoRoot.Trim()
$hooksDir = Join-Path $repoRoot "hooks"
$requiredHooks = @("pre-commit", "post-commit", "post-merge", "deploy.sh", "deploy-ignore.txt")

foreach ($name in $requiredHooks) {
    $path = Join-Path $hooksDir $name
    if (-not (Test-Path -LiteralPath $path -PathType Leaf)) {
        throw "Missing hook file: $path"
    }
}

Push-Location $repoRoot
try {
    # Tracked hooks stay current after every pull; no stale copies in .git/hooks.
    & git config --local --replace-all core.hooksPath hooks
    if ($LASTEXITCODE -ne 0) {
        throw "Failed to configure core.hooksPath."
    }

    if ($IsLinux -or $IsMacOS) {
        & chmod +x hooks/pre-commit hooks/post-commit hooks/post-merge hooks/deploy.sh
        if ($LASTEXITCODE -ne 0) {
            throw "Failed to mark hooks as executable."
        }
    }

    $configuredPath = (& git config --local --get core.hooksPath).Trim()
    Write-Host "Git hooks enabled: $configuredPath" -ForegroundColor Green
    Write-Host "Commits run validation, push and SFTP deploy; pulls/merges deploy too." -ForegroundColor Cyan
}
finally {
    Pop-Location
}
