<?php

declare(strict_types=1);

require_once __DIR__ . '/../bot_guard.php';

$checks = 0;
function botPrivacyTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$_SERVER['REMOTE_ADDR'] = '192.0.2.8';
$_SERVER['HTTP_USER_AGENT'] = "SyntheticAgent\tInjected\r\nForged" . str_repeat('x', 1000);
foreach ([
    '/reset_password.php?token=fictional-secret',
    '/objednavka.php?vs=123&t=fictional-secret',
    '/calculator_history.php?patient=fictional-secret',
    '/profile.php?email=fictional-secret#fragment',
] as $uri) {
    $_SERVER['REQUEST_URI'] = $uri;
    $line = botGuardLogLine("throttle\nforged", "reason\tforged");
    $fields = explode("\t", rtrim($line, "\n"));
    botPrivacyTest(count($fields) === 6, 'Útočník nesmie vložiť stĺpec logu.');
    botPrivacyTest(substr_count($line, "\n") === 1 && !str_contains($line, "\r"), 'Útočník nesmie vložiť riadok logu.');
    botPrivacyTest(!str_contains($line, 'fictional-secret') && !str_contains($line, '?'), 'Query údaje sa nelogujú.');
    botPrivacyTest($fields[4] === explode('?', $uri)[0], 'Cesta zostáva použiteľná na diagnostiku.');
    botPrivacyTest(mb_strlen($fields[5]) <= 300, 'User-Agent má ohraničenú dĺžku.');
}

echo "Botguard privacy: $checks PASS\n";
