<?php

declare(strict_types=1);

/** Stav vydania musí patriť presnému commitu, nie predchádzajúcemu zelenému behu. */
function nefroCiGateState(array $runs, string $sha): string
{
    foreach ($runs as $run) {
        if (($run['headSha'] ?? '') !== $sha) {
            continue;
        }
        if (($run['status'] ?? '') !== 'completed') {
            return 'pending';
        }
        return ($run['conclusion'] ?? '') === 'success' ? 'success' : 'failure';
    }
    return 'pending';
}
