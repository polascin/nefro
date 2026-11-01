<?php

declare(strict_types=1);

/**
 * A11y: chybové a úspešné alerty na autentifikačných a kalkulačkových
 * stránkach musia mať role="alert" / role="status" (WCAG 4.1.3 / 3.3.1).
 * Auth stránky viažu polia na zoznam chýb (aria-describedby) a fokusujú ho.
 */

$checks = 0;
function a11yAlertTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$root = dirname(__DIR__);

$authPages = [
    'login.php',
    'register.php',
    'forgot_password.php',
    'reset_password.php',
    'resend_verification.php',
    '2fa_verify.php',
    '2fa_setup.php',
];

foreach ($authPages as $page) {
    $src = (string) file_get_contents($root . '/' . $page);
    a11yAlertTest(is_file($root . '/' . $page), "{$page} musí existovať.");
    if (str_contains($src, 'alert alert-error')) {
        a11yAlertTest(
            !preg_match('/<div class="alert alert-error[^"]*"(?![^>]*\brole=)/', $src),
            "{$page}: každý alert-error musí mať role=\"alert\".",
        );
    }
    if (str_contains($src, 'alert alert-success')) {
        a11yAlertTest(
            !preg_match('/<div class="alert alert-success[^"]*"(?![^>]*\brole=)/', $src),
            "{$page}: každý alert-success musí mať role=\"status\".",
        );
    }
}

$focusBindings = [
    'login.php' => ['login-errors', 'aria-describedby="login-errors"'],
    'register.php' => ['register-errors', 'aria-describedby="register-errors"'],
    'forgot_password.php' => ['forgot-errors', 'aria-describedby="forgot-errors"'],
    'reset_password.php' => ['reset-errors', 'aria-describedby="reset-errors"'],
    'resend_verification.php' => ['resend-errors', 'aria-describedby="resend-errors"'],
    '2fa_verify.php' => ['totp-errors', 'aria-describedby="totp-errors"'],
];

foreach ($focusBindings as $page => [$errorId, $describedBy]) {
    $src = (string) file_get_contents($root . '/' . $page);
    a11yAlertTest(
        str_contains($src, 'id="' . $errorId . '"')
            && str_contains($src, $describedBy)
            && str_contains($src, 'aria-invalid="true"')
            && (str_contains($src, 'err.focus()') || str_contains($src, 'err.focus();')),
        "{$page} musí viazať polia na #{$errorId} a fokusovať zoznam chýb.",
    );
}

$theme = (string) file_get_contents($root . '/theme.js');
a11yAlertTest(
    str_contains($theme, 'menuFocusables')
        && str_contains($theme, "event.key === 'Escape'")
        && str_contains($theme, "event.key !== 'Tab'"),
    'theme.js musí pri otvorenom menu podporovať Escape a Tab cyklus.',
);

$css = (string) file_get_contents($root . '/index.css');
a11yAlertTest(
    str_contains($css, 'overflow-x: clip')
        && str_contains($css, '@media (max-width: 320px)'),
    'index.css musí mať ochranu pred horizontálnym pretečením pri 320 px.',
);

$calcSamples = [
    'calculator_egfr.php',
    'calculator_ckdpc.php',
    'calculator_prevent.php',
    'calculator_ambulatory.php',
];
foreach ($calcSamples as $page) {
    $src = (string) file_get_contents($root . '/' . $page);
    if (!str_contains($src, 'alert alert-error')) {
        continue;
    }
    a11yAlertTest(
        !preg_match('/<div class="alert alert-error[^"]*"(?![^>]*\brole=)/', $src),
        "{$page}: alert-error musí mať role=\"alert\".",
    );
}

echo "A11y form alerts: $checks PASS\n";
