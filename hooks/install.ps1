# Install Git hooks to .git/hooks directory
# Run this script from project root: .\hooks\install.ps1

Write-Host "Installing Git hooks..." -ForegroundColor Green

$gitHooksDir = ".git/hooks"
$hooksSourceDir = "hooks"

# Check if .git directory exists
if (-not (Test-Path ".git" -PathType Container)) {
    Write-Host "Error: .git directory not found. Run this from project root." -ForegroundColor Red
    exit 1
}

# Check if hooks directory exists
if (-not (Test-Path $hooksSourceDir -PathType Container)) {
    Write-Host "Error: $hooksSourceDir directory not found." -ForegroundColor Red
    exit 1
}

# Copy post-commit hook
if (Test-Path "$hooksSourceDir/post-commit") {
    Copy-Item "$hooksSourceDir/post-commit" "$gitHooksDir/post-commit" -Force
    Write-Host "✓ Installed post-commit hook (Unix/Bash)" -ForegroundColor Green
}

# Copy pre-commit hook (automatic PNG → WebP conversion)
if (Test-Path "$hooksSourceDir/pre-commit") {
    Copy-Item "$hooksSourceDir/pre-commit" "$gitHooksDir/pre-commit" -Force
    if ($PSVersionTable.Platform -eq "Unix") { chmod +x "$gitHooksDir/pre-commit" }
    Write-Host "✓ Installed pre-commit hook (PNG to WebP)" -ForegroundColor Green
}

# For Windows, also create a .bat version
if (Test-Path "$hooksSourceDir/post-commit") {
    $content = Get-Content "$hooksSourceDir/post-commit" -Raw
    $batContent = "@echo off`r`nREM Automatický git push po commite`r`n`r`nfor /f %%i in ('git rev-parse --abbrev-ref HEAD') do set branch=%%i`r`ngit push origin %branch% 2>nul`r`n`r`nexit /b 0"
    Set-Content "$gitHooksDir/post-commit.bat" $batContent -Force
    Write-Host "✓ Installed post-commit hook (Windows Batch)" -ForegroundColor Green
}

# Make hooks executable on Unix-like systems
if ($PSVersionTable.Platform -eq "Unix") {
    chmod +x "$gitHooksDir/post-commit"
    Write-Host "✓ Made hooks executable" -ForegroundColor Green
}

Write-Host "Git hooks installed successfully!" -ForegroundColor Green
Write-Host "From now on, every commit will automatically push to remote." -ForegroundColor Cyan
