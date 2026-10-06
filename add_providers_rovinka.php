<?php

declare(strict_types=1);
/**
 * add_providers_rovinka.php
 * Doplnenie dvoch ambulancií v Zdravotnom stredisku Rovinka do partner_providers.
 * Idempotentné: vkladá len ak názov alebo e-mail ešte neexistuje, takže opakované
 * spustenie nevytvorí duplikáty a neprepíše ručné úpravy.
 *
 * Spustenie: php add_providers_rovinka.php  (CLI/SSH) alebo admin v prehliadači.
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť ambulancie v Rovinke');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$source = 'údaje od prevádzkovateľa, 2026-10-06';

$seed = [
    [
        'name'           => 'Diabetologická ambulancia MUDr. Miriam Adamovičová',
        'provider_type'  => 'specialista',
        'specialization' => 'diabetológia, poruchy látkovej premeny a výživy',
        'locality'       => 'Rovinka',
        'address'        => 'Zdravotné stredisko Rovinka, Hlavná 209/104B, 900 41 Rovinka',
        'phone'          => '+421 903 529 040',
        'email'          => 'diabet.mbrovinka@milosrdni.sk',
        'contact_person' => 'MUDr. Miriam Adamovičová',
        'ico'            => null,
        'notes'          => null,
    ],
    [
        'name'           => 'P-Med, s. r. o.',
        'provider_type'  => 'vseobecny_lekar',
        'specialization' => 'všeobecné lekárstvo',
        'locality'       => 'Rovinka',
        'address'        => 'Zdravotné stredisko Rovinka, Hlavná 209/104B, miestnosť č. 22, 1. nadzemné podlažie, 900 41 Rovinka',
        'phone'          => '+421 948 090 041',
        'email'          => 'lekarka.rovinka@gmail.com',
        'contact_person' => 'MUDr. Peri Haj Ali, PhD.',
        'ico'            => '55976352',
        'notes'          => 'Sestra: Viera Vojteková. Poisťovne: VšZP, Dôvera, Union.',
    ],
];

$checkStmt = $pdo->prepare(
    'SELECT id, name FROM partner_providers WHERE name = :name OR email = :email LIMIT 1'
);
$insStmt = $pdo->prepare(
    'INSERT INTO partner_providers
        (name, provider_type, specialization, locality, address, phone, email,
         contact_person, notes, source, ico, is_active)
     VALUES
        (:name, :provider_type, :specialization, :locality, :address, :phone, :email,
         :contact_person, :notes, :source, :ico, 1)'
);

$inserted = 0;
$skipped  = 0;
foreach ($seed as $row) {
    $checkStmt->execute(['name' => $row['name'], 'email' => $row['email']]);
    $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);
    if ($existing !== false) {
        $skipped++;
        echo 'Preskočené (už existuje id ' . (int) $existing['id'] . '): ' . $existing['name'] . PHP_EOL;
        continue;
    }
    $row['source'] = $source;
    $insStmt->execute($row);
    $inserted++;
    echo 'Vložené: ' . $row['name'] . PHP_EOL;
}

echo "Ambulancie Rovinka: vložených {$inserted}, preskočených {$skipped}." . PHP_EOL;
