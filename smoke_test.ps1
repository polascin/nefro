$textExtensions = @("*.php", "*.css", "*.js", "*.md", "*.txt", "*.xml", "*.json", "*.ini", "*.ps1", "*.html")

function Test-TextFilesEncoding {
	param(
		[Parameter(Mandatory = $true)]
		[string]$RootPath
	)

	$utf8Strict = New-Object System.Text.UTF8Encoding($false, $true)
	$invalidUtf8 = New-Object System.Collections.Generic.List[string]
	$filesWithBom = New-Object System.Collections.Generic.List[string]

	$files = Get-ChildItem -Path $RootPath -Recurse -File -Include $textExtensions | Where-Object {
		$_.FullName -notmatch '\\\.git\\' -and $_.FullName -notmatch '\\\.trunk\\'
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
Write-Host "CSRF Token: $token"
$loginBody = @{ login = "test_mobile_verify"; password = "TestPass123A"; csrf_token = $token }
$res = Invoke-WebRequest -Uri "$url/login.php" -Method Post -Body $loginBody -WebSession $session
Write-Host "Login Status: $($res.StatusCode)"
$res = Invoke-WebRequest -Uri "$url/profile.php" -SessionVariable session -WebSession $session
$token = ([regex]'"csrf_token"\s+value="([^"]+)"').Match($res.Content).Groups[1].Value
Write-Host "Profile CSRF Token: $token"
$smsRequestBody = @{ csrf_token = $token; username = "test_mobile_verify"; mobile_phone = "+421901234567"; mobile_verification_action = "send" }
$res1 = Invoke-WebRequest -Uri "$url/profile.php" -Method Post -Body $smsRequestBody -WebSession $session
Write-Host "SMS Send Response Indicators:"
$indicators1 = @("Overovací SMS kód bol odoslaný", "nepodarilo odoslať", "dočasne nedostupné")
foreach ($i in $indicators1) { if ($res1.Content -match $i) { Write-Host " - Found: $i" } }
$verifyBody = @{ csrf_token = $token; username = "test_mobile_verify"; mobile_phone = "+421901234567"; mobile_verification_action = "verify"; mobile_verification_code = "123456" }
$res2 = Invoke-WebRequest -Uri "$url/profile.php" -Method Post -Body $verifyBody -WebSession $session
Write-Host "SMS Verify Response Indicators:"
$indicators2 = @("Mobilné číslo bolo úspešne overené", "Neplatný overovací SMS kód", "dočasne nedostupné")
foreach ($i in $indicators2) { if ($res2.Content -match $i) { Write-Host " - Found: $i" } }
