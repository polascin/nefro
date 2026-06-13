$ErrorActionPreference = "Stop"

$textExtensions = @("*.php", "*.css", "*.js", "*.md", "*.txt", "*.xml", "*.json", "*.ini", "*.ps1", "*.html")

function Test-TextFilesEncoding {
	param(
		[Parameter(Mandatory = $true)]
		[string]$RootPath
	)

	$utf8Strict = New-Object System.Text.UTF8Encoding($false, $true)
	$invalidUtf8 = New-Object System.Collections.Generic.List[string]
	$filesWithBom = New-Object System.Collections.Generic.List[string]

	$trackedAndUntracked = & git -C $RootPath ls-files --cached --others --exclude-standard
	if ($LASTEXITCODE -eq 0) {
		$allowedExtensions = $textExtensions | ForEach-Object { $_.TrimStart('*').ToLowerInvariant() }
		$files = foreach ($relativePath in $trackedAndUntracked) {
			$extension = [System.IO.Path]::GetExtension($relativePath).ToLowerInvariant()
			if ($allowedExtensions -contains $extension) {
				Get-Item -LiteralPath (Join-Path $RootPath $relativePath)
			}
		}
	} else {
		$files = Get-ChildItem -Path $RootPath -Recurse -File -Include $textExtensions | Where-Object {
			$_.FullName -notmatch '\\\.git\\' -and $_.FullName -notmatch '\\\.trunk\\'
		}
	}

	foreach ($file in $files) {
		try {
			$bytes = [System.IO.File]::ReadAllBytes($file.FullName)

			if ($bytes.Length -ge 3 -and $bytes[0] -eq 0xEF -and $bytes[1] -eq 0xBB -and $bytes[2] -eq 0xBF) {
				$filesWithBom.Add($file.FullName)
			}

			[void]$utf8Strict.GetString($bytes)
		} catch {
			$invalidUtf8.Add($file.FullName)
		}
	}

	Write-Host "Encoding check scanned files: $($files.Count)"

	if ($filesWithBom.Count -gt 0) {
		Write-Host "Files with UTF-8 BOM:" -ForegroundColor Yellow
		foreach ($path in $filesWithBom) {
			Write-Host " - $path"
		}
	}

	if ($invalidUtf8.Count -gt 0) {
		Write-Host "Invalid UTF-8 files:" -ForegroundColor Red
		foreach ($path in $invalidUtf8) {
			Write-Host " - $path"
		}
		throw "Encoding check failed: invalid UTF-8 files found."
	}

	if ($filesWithBom.Count -gt 0) {
		throw "Encoding check failed: UTF-8 BOM detected."
	}

	Write-Host "Encoding check: PASS"
}

Test-TextFilesEncoding -RootPath $PSScriptRoot

$session = New-Object Microsoft.PowerShell.Commands.WebRequestSession
$url = "http://127.0.0.1:8099"
$res = Invoke-WebRequest -Uri "$url/login.php" -SessionVariable session
$token = ([regex]'"csrf_token"\s+value="([^"]+)"').Match($res.Content).Groups[1].Value
if ([string]::IsNullOrWhiteSpace($token)) { throw "Login CSRF token was not found." }
Write-Host "Login CSRF token loaded."
$loginBody = @{ login = "test_mobile_verify"; password = "TestPass123A"; csrf_token = $token }
$res = Invoke-WebRequest -Uri "$url/login.php" -Method Post -Body $loginBody -WebSession $session
Write-Host "Login Status: $($res.StatusCode)"
if ($res.BaseResponse.RequestMessage.RequestUri.AbsolutePath -eq "/login.php") {
	throw "Smoke login failed. Verify that the test_mobile_verify fixture exists and its password is current."
}
$res = Invoke-WebRequest -Uri "$url/profile.php" -WebSession $session
if ($res.BaseResponse.RequestMessage.RequestUri.AbsolutePath -ne "/profile.php" -or $res.Content -notmatch "mobile_verification_action") {
	throw "Smoke profile check failed: authenticated profile page was not loaded."
}
$token = ([regex]'"csrf_token"\s+value="([^"]+)"').Match($res.Content).Groups[1].Value
if ([string]::IsNullOrWhiteSpace($token)) { throw "Profile CSRF token was not found." }
Write-Host "Profile CSRF token loaded."
$smsRequestBody = @{ csrf_token = $token; username = "test_mobile_verify"; mobile_phone = "+421901234567"; mobile_verification_action = "send" }
$res1 = Invoke-WebRequest -Uri "$url/profile.php" -Method Post -Body $smsRequestBody -WebSession $session
Write-Host "SMS Send Response Indicators:"
$indicators1 = @("Overovací SMS kód bol odoslaný", "nepodarilo odoslať", "dočasne nedostupné")
$sendIndicatorFound = $false
foreach ($i in $indicators1) {
	if ($res1.Content -match $i) {
		Write-Host " - Found: $i"
		$sendIndicatorFound = $true
	}
}
if (-not $sendIndicatorFound) {
	throw "SMS send response did not contain an expected status indicator."
}
$res = Invoke-WebRequest -Uri "$url/profile.php" -WebSession $session
$token = ([regex]'"csrf_token"\s+value="([^"]+)"').Match($res.Content).Groups[1].Value
if ([string]::IsNullOrWhiteSpace($token)) { throw "Rotated profile CSRF token was not found." }
$verifyBody = @{ csrf_token = $token; username = "test_mobile_verify"; mobile_phone = "+421901234567"; mobile_verification_action = "verify"; mobile_verification_code = "123456" }
$res2 = Invoke-WebRequest -Uri "$url/profile.php" -Method Post -Body $verifyBody -WebSession $session
Write-Host "SMS Verify Response Indicators:"
$indicators2 = @("Mobilné číslo bolo úspešne overené", "Neplatný overovací SMS kód", "dočasne nedostupné")
$verifyIndicatorFound = $false
foreach ($i in $indicators2) {
	if ($res2.Content -match $i) {
		Write-Host " - Found: $i"
		$verifyIndicatorFound = $true
	}
}
if (-not $verifyIndicatorFound) {
	throw "SMS verify response did not contain an expected status indicator."
}

# ── PDF na stiahnutie: bonus pre prihlásených používateľov ────────────────────
Write-Host "`n--- PDF download smoke test ---"

# Deterministický fixture: zverejnený článok s priradeným PDF (len lokálne/dev)
$seedScript = Join-Path $PSScriptRoot 'smoke_seed_pdf.php'
$seedOut = & php $seedScript seed 2>&1
Write-Host "Seed: $seedOut"
if ($LASTEXITCODE -ne 0 -or "$seedOut" -notmatch 'SEED_OK') {
	throw "PDF smoke fixture seed failed: $seedOut"
}
if ("$seedOut" -match 'file=MISSING') {
	throw "PDF fixture file missing in /pdf — cannot test download."
}

try {
	$pdfUrl = "$url/download_pdf.php?slug=smoke-test-pdf"

	# 1) Anonymný používateľ → prístup zamietnutý (presmerovanie na login.php)
	$anonSession = New-Object Microsoft.PowerShell.Commands.WebRequestSession
	$resAnon = Invoke-WebRequest -Uri $pdfUrl -WebSession $anonSession
	$anonPath = $resAnon.BaseResponse.RequestMessage.RequestUri.AbsolutePath
	if ($anonPath -ne "/login.php") {
		throw "PDF download was not gated for anonymous user (landed on '$anonPath', expected /login.php)."
	}
	Write-Host "Anonymous PDF access redirected to login.php: PASS"

	# 2) Prihlásený používateľ (existujúca $session) → reálne PDF
	$resPdf = Invoke-WebRequest -Uri $pdfUrl -WebSession $session
	if ($resPdf.StatusCode -ne 200) {
		throw "Logged-in PDF download returned HTTP $($resPdf.StatusCode), expected 200."
	}
	$ctype = [string]$resPdf.Headers['Content-Type']
	if ($ctype -notmatch 'application/pdf') {
		throw "Logged-in PDF download Content-Type was '$ctype', expected application/pdf."
	}
	$disp = [string]$resPdf.Headers['Content-Disposition']
	if ($disp -notmatch 'attachment') {
		throw "PDF download missing 'attachment' Content-Disposition (got '$disp')."
	}
	# Overenie PDF magic '%PDF' v prvých bajtoch (binárne aj textové telo)
	$body = $resPdf.Content
	if ($body -is [string]) {
		$head = $body.Substring(0, [Math]::Min(8, $body.Length))
		$bytes = [System.Text.Encoding]::ASCII.GetBytes($head)
	} else {
		$bytes = $body
	}
	$magic = -join ($bytes[0..3] | ForEach-Object { [char]$_ })
	if ($magic -ne '%PDF') {
		throw "Downloaded file did not start with PDF magic '%PDF' (got '$magic')."
	}
	Write-Host "Logged-in PDF download (application/pdf, attachment, %PDF): PASS"
}
finally {
	$cleanOut = & php $seedScript cleanup 2>&1
	Write-Host "Cleanup: $cleanOut"
}
Write-Host "PDF download smoke test: PASS"
