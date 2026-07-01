<?php

declare(strict_types=1);
/**
 * add_providers_seed.php
 * Štartovací seed pre partner_providers — LEN overené verejné inštitúcie
 * (žiadne vymyslené kontakty). Idempotentné: vkladá len ak názov ešte neexistuje,
 * takže opakované spustenie nevytvorí duplikáty a neprepíše ručné úpravy.
 *
 * Zdroj údajov: verejné weby inštitúcií (unb.sk a pod.). Zvyšok siete odporúčateľov
 * sa dopĺňa ručne cez admin_providers.php (alebo z pripravených podkladov).
 *
 * Spustenie: php add_providers_seed.php  (CLI cez SSH) alebo admin v prehliadači.
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$seed = [
    [
        'name'           => 'Klinika nefrológie a transplantácií obličiek LF UK a UNB',
        'provider_type'  => 'transplant',
        'specialization' => 'nefrológia, transplantácie obličiek',
        'locality'       => 'Bratislava-Nové Mesto',
        'address'        => 'Limbová 5, 833 05 Bratislava-Kramáre',
        'phone'          => '02/5954 2293',
        'email'          => 'nefrologia.transplant@kr.unb.sk',
        'website'        => 'https://www.unb.sk/klinika-nefrologie-a-transplantacii-obliciek-lf-uk-a-unb/',
        'contact_person' => null,
        'notes'          => 'Príprava pacientov na transplantáciu obličky, dispenzarizácia. Transplantačná ambulancia: transplantacna.ambulancia@kr.unb.sk.',
        'source'         => 'unb.sk',
    ],
    [
        'name'           => 'Urologická klinika s Centrom pre transplantácie obličiek LF UK, SZU a UNB',
        'provider_type'  => 'transplant',
        'specialization' => 'urológia, transplantácie obličiek',
        'locality'       => 'Bratislava-Nové Mesto',
        'address'        => 'Limbová 5, 833 05 Bratislava-Kramáre',
        'phone'          => '02/5954 2368',
        'email'          => null,
        'website'        => 'https://www.unb.sk/urologicka-klinika-lf-uk-a-unb/',
        'contact_person' => null,
        'notes'          => 'Odbery a transplantácie obličiek (od živých aj mŕtvych darcov), riešenie potransplantačných komplikácií.',
        'source'         => 'unb.sk',
    ],
    [
        'name'           => 'Univerzitná nemocnica Bratislava – Nemocnica akad. L. Dérera (Kramáre)',
        'provider_type'  => 'nemocnica',
        'specialization' => 'všeobecná nemocnica (nefrológia, urológia, interná medicína)',
        'locality'       => 'Bratislava-Nové Mesto',
        'address'        => 'Limbová 5, 833 05 Bratislava-Kramáre',
        'phone'          => null,
        'email'          => null,
        'website'        => 'https://www.unb.sk/',
        'contact_person' => null,
        'notes'          => 'Spádová univerzitná nemocnica; nefrologické, urologické a transplantačné pracoviská.',
        'source'         => 'unb.sk',
    ],
    [
        'name'           => 'Nemocnica Bory',
        'provider_type'  => 'nemocnica',
        'specialization' => 'všeobecná nemocnica',
        'locality'       => 'Bratislava-Lamač',
        'address'        => null,
        'phone'          => null,
        'email'          => null,
        'website'        => 'https://www.nemocnicabory.sk/',
        'contact_person' => null,
        'notes'          => 'Nová všeobecná nemocnica v blízkosti Dúbravky (Bory). Kontakty doplniť z webu.',
        'source'         => 'nemocnicabory.sk',
    ],
];

$checkStmt = $pdo->prepare('SELECT id FROM partner_providers WHERE name = :name LIMIT 1');
$insStmt   = $pdo->prepare(
    'INSERT INTO partner_providers
        (name, provider_type, specialization, locality, address, phone, email, website, contact_person, notes, source, is_active)
     VALUES
        (:name, :provider_type, :specialization, :locality, :address, :phone, :email, :website, :contact_person, :notes, :source, 1)'
);

$inserted = 0;
$skipped  = 0;
foreach ($seed as $row) {
    $checkStmt->execute(['name' => $row['name']]);
    if ($checkStmt->fetchColumn() !== false) {
        $skipped++;
        continue;
    }
    $insStmt->execute($row);
    $inserted++;
}

echo "Seed poskytovateľov: vložených {$inserted}, preskočených (už existujú) {$skipped}." . PHP_EOL;
