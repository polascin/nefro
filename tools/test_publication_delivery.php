<?php

declare(strict_types=1);

require_once __DIR__ . '/../publications_common.php';

$assertions = 0;

function publicationDeliveryTestSame(mixed $expected, mixed $actual, string $message): void
{
    global $assertions;
    $assertions++;
    if ($expected !== $actual) {
        throw new \RuntimeException(
            $message . ': očakávané ' . var_export($expected, true) .
            ', získané ' . var_export($actual, true),
        );
    }
}

// Predvolený nákup (len PDF) ide celý odkazom — úvodná správa nemá prílohu.
// Technická adresa sa musí skúsiť aj vtedy, inak potvrdenie platby zmizne,
// keď server odmietne PUBLICATION_DELIVERY_FROM_EMAIL.
publicationDeliveryTestSame(
    ['technical'],
    publicationDeliveryIntroFallbackPlan(false),
    'bez prílohy nasleduje hneď technická adresa',
);

publicationDeliveryTestSame(
    ['unattached', 'technical'],
    publicationDeliveryIntroFallbackPlan(true),
    'po zlyhaní prílohy najprv správa bez prílohy, potom technická adresa',
);

echo 'Dodanie publikácie: ' . $assertions . " kontroly prešli.\n";
