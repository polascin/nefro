<?php

declare(strict_types=1);
/**
 * providers_common.php
 * Zdieľané pomôcky pre internú databázu spolupracujúcich poskytovateľov
 * (partner_providers) — číselníky typov, návrhy lokalít a odborností.
 */

if (!function_exists('ppTypeLabels')) {
    /** Typy poskytovateľa (slug => popis). */
    function ppTypeLabels(): array
    {
        return [
            'vseobecny_lekar' => 'Všeobecný lekár (dospelí)',
            'specialista'     => 'Ambulantný špecialista',
            'nemocnica'       => 'Nemocnica / ústav',
            'poliklinika'     => 'Poliklinika',
            'laboratorium'    => 'Laboratórium / SVLZ',
            'lekaren'         => 'Lekáreň',
            'socialna_sluzba' => 'Sociálna služba / ZSS',
            'ados'            => 'ADOS / domáca starostlivosť',
            'transplant'      => 'Transplantačné centrum',
            'ine'             => 'Iné',
        ];
    }
}

if (!function_exists('ppTypeLabel')) {
    function ppTypeLabel(?string $slug): string
    {
        $labels = ppTypeLabels();
        $slug = (string) $slug;
        return $labels[$slug] ?? ($slug !== '' ? $slug : '—');
    }
}

if (!function_exists('ppOutreachLabels')) {
    /** Stav oslovenia odporúčateľa (slug => popis) — sledovanie akvizície. */
    function ppOutreachLabels(): array
    {
        return [
            'nekontaktovany' => 'Nekontaktovaný',
            'osloveny'       => 'Oslovený',
            'odpovedal'      => 'Odpovedal',
            'spolupracuje'   => 'Spolupracuje',
            'odmietol'       => 'Odmietol',
        ];
    }
}

if (!function_exists('ppOutreachLabel')) {
    function ppOutreachLabel(?string $slug): string
    {
        $labels = ppOutreachLabels();
        $slug = (string) $slug;
        return $labels[$slug] ?? 'Nekontaktovaný';
    }
}

if (!function_exists('ppLocalitySuggestions')) {
    /** Návrhy lokalít v pracovnom dosahu Dúbravky (západná BA + Záhorie). */
    function ppLocalitySuggestions(): array
    {
        return [
            'Bratislava-Dúbravka', 'Bratislava-Karlova Ves', 'Bratislava-Lamač',
            'Bratislava-Devínska Nová Ves', 'Bratislava-Záhorská Bystrica', 'Bratislava-Devín',
            'Bratislava-Staré Mesto', 'Bratislava-Nové Mesto', 'Bratislava-Petržalka',
            'Stupava', 'Malacky', 'Marianka', 'Borinka', 'Záhorská Ves', 'Zohor', 'Lozorno',
        ];
    }
}

if (!function_exists('ppSpecializationSuggestions')) {
    /** Návrhy odborností (špecializácií). */
    function ppSpecializationSuggestions(): array
    {
        return [
            'nefrológia', 'diabetológia', 'kardiológia', 'interná medicína', 'urológia',
            'všeobecné lekárstvo', 'endokrinológia', 'angiológia', 'cievna chirurgia', 'chirurgia',
            'reumatológia', 'hematológia', 'imunológia a alergológia', 'gastroenterológia',
            'neurológia', 'oftalmológia', 'geriatria', 'rádiológia', 'klinická biochémia',
            'psychiatria', 'výživové poradenstvo', 'fyzioterapia',
        ];
    }
}
