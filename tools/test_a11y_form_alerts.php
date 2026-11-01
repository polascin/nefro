<?php

declare(strict_types=1);

/**
 * A11y: chybové a úspešné alerty na autentifikačných a kalkulačkových
 * stránkach musia mať role="alert" / role="status" (WCAG 4.1.3 / 3.3.1).
 * Prihlásenie navyše viaže polia na zoznam chýb (aria-describedby).
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

$login = (string) file_get_contents($root . '/login.php');
a11yAlertTest(
    str_contains($login, 'id="login-errors"')
        && str_contains($login, 'aria-describedby="login-errors"')
        && str_contains($login, 'aria-invalid="true"'),
    'login.php musí viazať polia na #login-errors pri chybách.',
);
a11yAlertTest(
    str_contains($login, "err.focus()") || str_contains($login, 'err.focus();'),
    'login.php musí po chybe fokusovať zoznam chýb.',
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
