
    $server = Start-Process php -ArgumentList "-S 127.0.0.1:8112 -t d:\OneDrive\www\nefro" -PassThru
    Start-Sleep -Seconds 3
    try {
        $sess = New-Object Microsoft.PowerShell.Commands.WebRequestSession
        $ts = [DateTimeOffset]::UtcNow.ToUnixTimeSeconds()
        $email = "e2e_verify_${ts}@example.com"
        $username = "e2e_verify_${ts}"
        $password = "Password123A"

        # 1) Register
        $regGet = Invoke-WebRequest -Uri "http://127.0.0.1:8112/register.php" -WebSession $sess
        $regCsrf = [regex]::Match($regGet.Content, 'name="csrf_token"\s+value="([^"]+)"').Groups[1].Value
        $regPost = Invoke-WebRequest -Uri "http://127.0.0.1:8112/register.php" -Method Post -Body @{ csrf_token = $regCsrf; email = $email; username = $username; password = $password } -WebSession $sess
        $regOk = ($regPost.Content -like "*Registrácia prebehla úspešne*" -and $regPost.Content -like "*overiť e-mailovú adresu*")

        # 2) Login should be blocked before verification
        $loginGet = Invoke-WebRequest -Uri "http://127.0.0.1:8112/login.php" -WebSession $sess
        $loginCsrf = [regex]::Match($loginGet.Content, 'name="csrf_token"\s+value="([^"]+)"').Groups[1].Value
        $loginBlockedPage = Invoke-WebRequest -Uri "http://127.0.0.1:8112/login.php" -Method Post -Body @{ csrf_token = $loginCsrf; login = $email; password = $password } -WebSession $sess
        $blockedOk = ($loginBlockedPage.Content -like "*E-mailová adresa ešte nie je overená*" -and $loginBlockedPage.Content -like "*Poslať overenie znova*")

        # 3) Simulate verification
        $token = "MANUAL_E2E_TOKEN_$ts"
        $hash = [BitConverter]::ToString((New-Object Security.Cryptography.SHA256Managed).ComputeHash([Text.Encoding]::UTF8.GetBytes($token))).Replace("-", "").ToLower()
        
        $sql = "UPDATE users SET email_verified_at = NULL, email_verification_token_hash = '$hash', email_verification_expires_at = DATE_ADD(NOW(), INTERVAL 1 DAY), email_verification_sent_at = NOW() WHERE email = '$email'"
        $phpUpdate = "<?php require 'd:/OneDrive/www/nefro/db_config.php'; `$pdo->exec(`"$sql`") ; `$s = `$pdo->prepare('SELECT id FROM users WHERE email = :email'); `$s->execute(['email' => '$email']); echo 'USER_ID=' . `$s->fetchColumn();"
        $prepOut = $phpUpdate | php
        $userId = [int](([regex]::Match(($prepOut -join "`n"), 'USER_ID=(\d+)')).Groups[1].Value)

        $verifyPage = Invoke-WebRequest -Uri ("http://127.0.0.1:8112/verify_email.php?uid=" + $userId + "&token=" + [uri]::EscapeDataString($token)) -WebSession $sess
        $verifyOk = ($verifyPage.Content -like "*E-mailová adresa bola úspešne overená*" -or $verifyPage.Content -like "*E-mailová adresa je už overená*")

        # 4) Login should succeed
        $loginGet2 = Invoke-WebRequest -Uri "http://127.0.0.1:8112/login.php" -WebSession $sess
        $loginCsrf2 = [regex]::Match($loginGet2.Content, 'name="csrf_token"\s+value="([^"]+)"').Groups[1].Value
        try {
            Invoke-WebRequest -Uri "http://127.0.0.1:8112/login.php" -Method Post -Body @{ csrf_token = $loginCsrf2; login = $email; password = $password } -WebSession $sess -MaximumRedirection 0 -ErrorAction Stop | Out-Null
            $loginAfterVerifyOk = $false
        } catch {
            $loginAfterVerifyOk = ($_.Exception.Response.StatusCode.Value__ -eq 302)
        }

        $indexAfter = Invoke-WebRequest -Uri "http://127.0.0.1:8112/index.php" -WebSession $sess
        $headerBadgeOk = ($indexAfter.Content -like "*E-mail overený*")

        "E2E_EMAIL=$email", "STEP_REGISTER_OK=$regOk", "STEP_LOGIN_BLOCKED_OK=$blockedOk", "STEP_VERIFY_OK=$verifyOk", "STEP_LOGIN_AFTER_VERIFY_OK=$loginAfterVerifyOk", "STEP_HEADER_BADGE_OK=$headerBadgeOk"
    } finally {
        Stop-Process -Id $server.Id -Force
    }

