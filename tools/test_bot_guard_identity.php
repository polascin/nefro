<?php

declare(strict_types=1);

/**
 * Ochrana proti scrapingu a limit prihlásenia musia používať rovnakú
 * identitu klienta.
 *
 * Pôvodne limiter noviniek (bot_guard.php) bral IP len z REMOTE_ADDR, kým
 * limit prihlásenia (config_loader.php → getClientIpAddress()) dôveroval
 * X-Forwarded-For. Útočník si tak vedel podvrhnúť IP a obísť limit prihlásenia.
 *
 * Navyše sa limiter celý vypínal, ak User-Agent obsahoval reťazec
 * "wkhtmltopdf" — hocičíkto si tým vypýtal neobmedzený prístup. PDF verzie
 * článkov sa generujú z lokálneho HTML s `<base href="file://…">` a na stránku
 * neposielajú žiadny HTTP request (pozri pdf_generator.php), takže vôbec
 * nebolo čo chrániť.
 */

$checks = 0;

function botGuardIdentityTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

$root = dirname(__DIR__);

$_SERVER['REMOTE_ADDR'] = '198.51.100.23';
$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0';

require_once $root . '/config_loader.php';
require_once $root . '/bot_guard.php';

// ── 1) Obe vrstvy vidia tú istú identitu ─────────────────────────────────────
botGuardIdentityTest(
    botGuardClientIp() === getClientIpAddress(),
    'Limiter noviniek a limit prihlásenia musia používať rovnakú IP adresu.',
);

botGuardIdentityTest(
    botGuardClientIp() === '198.51.100.23',
    'Bez dôveryhodnej proxy sa používa REMOTE_ADDR.',
);

// ── 2) Vypnutie limitera podľa User-Agent je preč ────────────────────────────
$source = (string) file_get_contents($root . '/bot_guard.php');

botGuardIdentityTest(
    preg_match('/function botGuardShouldSkip\(\): bool\s*\{(.*?)\n\}/s', $source, $matches) === 1,
    'Funkcia botGuardShouldSkip() sa nedá nájsť v bot_guard.php.',
);

$skipBody = $matches[1] ?? '';
botGuardIdentityTest(
    stripos($skipBody, 'UserAgent') === false,
    'botGuardShouldSkip() nesmie rozhodovať podľa User-Agenta.',
);
botGuardIdentityTest(
    stripos($skipBody, 'wkhtmltopdf') === false,
    'botGuardShouldSkip() nesmie vypínať limiter pre reťazec vo User-Agent.',
);

// ── 3) Explicitne povolené IP a siete ───────────────────────────────────────
botGuardIdentityTest(
    botGuardIpInCidr('203.0.113.7', '203.0.113.0/24') === true,
    'IP v sieti CIDR má byť povolená.',
);
botGuardIdentityTest(
    botGuardIpInCidr('203.0.114.7', '203.0.113.0/24') === false,
    'IP mimo siete CIDR nemá byť povolená.',
);
botGuardIdentityTest(
    botGuardIpInCidr('203.0.113.7', '203.0.113.7/32') === true,
    'Jediná adresa v sieti /32 má byť povolená.',
);
botGuardIdentityTest(
    botGuardIpInCidr('198.51.100.1', '0.0.0.0/0') === true,
    'Sieť /0 má pokrývať všetky adresy.',
);
botGuardIdentityTest(
    botGuardIpInCidr('nonsense', '203.0.113.0/24') === false,
    'Neplatná adresa nesmie byť povolená.',
);
botGuardIdentityTest(
    botGuardIpInCidr('203.0.113.7', '203.0.113.0/33') === false,
    'Neplatná dĺžka masky nesmie spustiť povolenie.',
);

// ── 4) Allowlist sa načíta z konfigurácie (v samostatnom procese) ─────────────
// `loadAppConfig()` cacheuje konfiguráciu, preto allowlist overujeme
// v čerstvom procese s vlastným NEFRO_ENV_PATH.
$configFile = tempnam(sys_get_temp_dir(), 'nefro-botguard-');
file_put_contents(
    $configFile,
    "APP_ENV=test\nBOT_GUARD_ALLOW_IPS=203.0.113.0/24,198.51.100.5\n"
);

$helperFile = tempnam(sys_get_temp_dir(), 'nefro-botguard-') . '.php';
file_put_contents(
    $helperFile,
    <<<'PHP'
<?php
$root = $argv[1];
$ip = $argv[2];
$_SERVER['REMOTE_ADDR'] = $ip;
require_once $root . '/bot_guard.php';
echo botGuardIpAllowed($ip) ? 'ALLOWED' : 'DENIED';
PHP
);

$runAllowlist = static function (string $ip) use ($helperFile, $root, $configFile): string {
    $descriptors = [1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
    $process = proc_open(
        [PHP_BINARY, $helperFile, $root, $ip],
        $descriptors,
        $pipes,
        $root,
        ['NEFRO_ENV_PATH' => $configFile] + $_ENV
    );
    if (!is_resource($process)) {
        throw new RuntimeException('Nepodarilo sa spustiť pomocný proces.');
    }
    $out = (string) stream_get_contents($pipes[1]);
    $err = (string) stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $exit = proc_close($process);

    if ($exit !== 0) {
        throw new RuntimeException('Pomocný proces zlyhal: ' . trim($err));
    }

    return trim($out);
};

botGuardIdentityTest(
    $runAllowlist('198.51.100.5') === 'ALLOWED',
    'Presná adresa z BOT_GUARD_ALLOW_IPS má byť povolená.',
);
botGuardIdentityTest(
    $runAllowlist('203.0.113.7') === 'ALLOWED',
    'Adresa v sieti CIDR z BOT_GUARD_ALLOW_IPS má byť povolená.',
);
botGuardIdentityTest(
    $runAllowlist('198.51.100.6') === 'DENIED',
    'Adresa mimo allowlistu nemá byť povolená.',
);

unlink($helperFile);
unlink($configFile);

echo "Bot guard identity: $checks PASS\n";
