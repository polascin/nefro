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
    'login.php' => ['login-errors', 'aria-describedby="login-errors"', true],
    'register.php' => ['register-errors', 'aria-describedby="register-errors"', true],
    'forgot_password.php' => ['forgot-errors', 'aria-describedby="forgot-errors"', true],
    'reset_password.php' => ['reset-errors', 'aria-describedby="reset-errors"', true],
    'resend_verification.php' => ['resend-errors', 'aria-describedby="resend-errors"', true],
    '2fa_verify.php' => ['totp-errors', 'aria-describedby="totp-errors"', true],
    '2fa_setup.php' => ['setup-2fa-errors', 'aria-describedby="setup-2fa-errors"', true],
    'confirm_account_deletion.php' => ['deletion-errors', 'aria-describedby="deletion-errors"', false],
];

foreach ($focusBindings as $page => [$errorId, $describedBy, $needsInvalid]) {
    $src = (string) file_get_contents($root . '/' . $page);
    a11yAlertTest(
        str_contains($src, 'id="' . $errorId . '"')
            && str_contains($src, $describedBy)
            && (!$needsInvalid || str_contains($src, 'aria-invalid="true"'))
            && (str_contains($src, 'err.focus()') || str_contains($src, 'err.focus();')),
        "{$page} musí viazať na #{$errorId} a fokusovať zoznam chýb.",
    );
}

a11yAlertTest(
    str_contains((string) file_get_contents($root . '/confirm_account_deletion.php'), 'id="deletion-warning"')
        && str_contains((string) file_get_contents($root . '/confirm_account_deletion.php'), 'id="deletion-invalid"'),
    'confirm_account_deletion.php musí mať identifikovateľné upozornenie a neplatný odkaz.',
);

$theme = (string) file_get_contents($root . '/theme.js');
a11yAlertTest(
    str_contains($theme, 'menuFocusables')
        && str_contains($theme, "event.key === 'Escape'")
        && str_contains($theme, "event.key !== 'Tab'"),
    'theme.js musí pri otvorenom menu podporovať Escape a Tab cyklus.',
);

$ui = (string) file_get_contents($root . '/nefro-ui.js');
a11yAlertTest(
    str_contains($ui, 'aria-expanded')
        && str_contains($ui, 'focusEl.focus')
        && str_contains($ui, 'opening'),
    'nefro-ui.js musí pri otvorení confirm panelu fokusovať pole a nastaviť aria-expanded.',
);
a11yAlertTest(
    !preg_match('/querySelectorAll\(\'\\[data-toggle-btn\\]\'\)/', (string) file_get_contents($root . '/2fa_setup.php')),
    '2fa_setup.php nesmie duplicitne prepínať data-toggle-btn (nefro-ui.js).',
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
