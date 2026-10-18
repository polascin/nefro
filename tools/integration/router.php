<?php

declare(strict_types=1);

$path = parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH);
$allowed = ['/login.php', '/logout.php', '/profile.php', '/forgot_password.php', '/reset_password.php', '/resend_verification.php', '/verify_email.php', '/newsletter_subscribe.php', '/newsletter_verify_sub.php', '/download_publication.php', '/calculator_history.php', '/index.php', '/download_pdf.php'];
if (!in_array($path, $allowed, true)) {
    http_response_code(403);
    exit('Integration route denied.');
}
// Built-in server obsluhuje skutočné aplikačné endpointy, bez testovacej auth skratky.
return false;
