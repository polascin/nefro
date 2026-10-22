<?php

declare(strict_types=1);

/**
 * Návratová URL po opätovnom overení heslom nesmie umožniť presmerovanie
 * mimo portálu (open redirect).
 *
 * `reauth_return_url` sa ukladal z REQUEST_URI a používal priamo v hlavičke
 * `Location:`. Hodnota `//cudzidomena.tld` je v HTTP hlavičke platná a prehliadač
 * ju vyhodnotí ako absolútne URL na iný hostiteľ.
 */

$checks = 0;

function safeReturnUrlTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

$root = dirname(__DIR__);

require_once $root . '/auth.php';

// ── Bezpečné relatívne cesty sa zachovajú ────────────────────────────────────
safeReturnUrlTest(
    safeInternalReturnUrl('admin.php') === 'admin.php',
    'Relatívna cesta na stránku sa má zachovať.',
);
safeReturnUrlTest(
    safeInternalReturnUrl('admin_articles.php?id=7&filter=x') === 'admin_articles.php?id=7&filter=x',
    'Relatívna cesta s parametrami sa má zachovať.',
);
safeReturnUrlTest(
    safeInternalReturnUrl('  admin.php  ') === 'admin.php',
    'Ostré hrany sa majú orezať.',
);

// ── Nebezpečné hodnoty sa nahradia predvolenou ───────────────────────────────
$dangerous = [
    '//cudzidomena.tld/utok'   => 'protokolovo-relative URL',
    'https://cudzidomena.tld'  => 'absolútna URL s https',
    'http://cudzidomena.tld'   => 'absolútna URL s http',
    'javascript:alert(1)'      => 'schéma javascript',
    'data:text/html,<script>'  => 'schéma data',
    '/absolutna/cesta'         => 'absolútna cesta',
    '\\\\cudzidomena.tld'      => 'spätné lomítka',
    '../../etc/passwd'         => 'traverzia adresára',
    'admin.php<script>'       => 'skriptová značka',
];

foreach ($dangerous as $candidate => $label) {
    safeReturnUrlTest(
        safeInternalReturnUrl($candidate) === 'admin.php',
        'Nesmie sa preposlať na ' . $label . ' (dostali sme "' . $candidate . '").',
    );
}

// ── Prázdna hodnota a vlastný fallback ───────────────────────────────────────
safeReturnUrlTest(
    safeInternalReturnUrl('', 'index.php') === 'index.php',
    'Prázdna URL má použiť fallback.',
);
safeReturnUrlTest(
    safeInternalReturnUrl('   ', 'index.php') === 'index.php',
    'Whitespace-only URL má použiť fallback.',
);

// ── Oba miesta, kde sa URL používa, musia volať normalizátor ─────────────────
$authSource = (string) file_get_contents($root . '/auth.php');
$reauthSource = (string) file_get_contents($root . '/admin_reauth.php');

safeReturnUrlTest(
    str_contains($authSource, "safeInternalReturnUrl(\n            (string) (\$_SERVER['REQUEST_URI'] ?? '')")
        || preg_match('/safeInternalReturnUrl\(\s*\(string\) \(\$_SERVER\[.REQUEST_URI.\]/', $authSource) === 1,
    'requireAdminReauth() musí návratovú URL normalizovať.',
);
safeReturnUrlTest(
    preg_match('/safeInternalReturnUrl\(\s*\(string\) \(\$_SESSION\[.reauth_return_url.\]/', $reauthSource) === 1,
    'admin_reauth.php musí návratovú URL normalizovať pred presmerovaním.',
);

echo "Safe return URL: $checks PASS\n";
