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
