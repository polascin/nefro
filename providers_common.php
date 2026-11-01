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

if (!function_exists('ppContactChannelLabels')) {
    /** Kanály kontaktu (história) — slug => popis. */
    function ppContactChannelLabels(): array
    {
        return [
            'email'   => 'E-mail',
            'telefon' => 'Telefón',
            'osobne'  => 'Osobne',
            'list'    => 'List',
            'other'   => 'Iné',
        ];
    }
}

if (!function_exists('ppContactChannelLabel')) {
    function ppContactChannelLabel(?string $slug): string
    {
        $slug = (string) $slug;
        return ppContactChannelLabels()[$slug] ?? 'Iné';
    }
}

if (!function_exists('ppPriorityLabels')) {
    /** Priorita odporúčateľa (cielenie akvizície). */
    function ppPriorityLabels(): array
    {
        return [
            'A' => 'A (vysoká)',
            'B' => 'B (stredná)',
            'C' => 'C (nízka)',
        ];
    }
}

if (!function_exists('ppPriorityLabel')) {
    function ppPriorityLabel(?string $v): string
    {
        $v = (string) $v;
        return ppPriorityLabels()[$v] ?? '';
    }
}

if (!function_exists('ppPriorityAssignmentRules')) {
    /**
     * Pravidlá prvotného priradenia priority A/B/C podľa lokality a typu.
     * Používa seed skript; admin môže výsledok neskôr ručne zmeniť.
     *
     * @return array{
     *   west: list<string>,
     *   east: list<string>,
     *   mid: list<string>,
     *   institutions: list<string>,
     *   overrides: array<string, ?string>
     * }
     */
    function ppPriorityAssignmentRules(): array
    {
        return [
            'west' => [
                'Bratislava-Dúbravka', 'Bratislava-Karlova Ves', 'Bratislava-Lamač',
                'Bratislava-Devínska Nová Ves', 'Bratislava-Devín', 'Bratislava-Záhorská Bystrica',
            ],
            'east' => [
                'Bratislava-Ružinov', 'Bratislava-Podunajské Biskupice', 'Bratislava-Vrakuňa',
                'Bratislava-Rača', 'Bratislava-Petržalka',
            ],
            'mid' => [
                'Bratislava-Nové Mesto', 'Bratislava-Staré Mesto', 'Rovinka', 'Stupava',
            ],
            'institutions' => ['nemocnica', 'poliklinika', 'transplant', 'socialna_sluzba'],
            'overrides' => [
                'MUDr. Juraj Magyarics' => null,
                'CINRE' => 'B',
            ],
        ];
    }
}

if (!function_exists('ppPriorityForProvider')) {
    /**
     * Navrhne prioritu A/B/C alebo null (nechať na ručné rozhodnutie).
     *
     * @param array{name?: string, provider_type?: string, locality?: string} $provider
     */
    function ppPriorityForProvider(array $provider, ?array $rules = null): ?string
    {
        $rules ??= ppPriorityAssignmentRules();
        $name = (string) ($provider['name'] ?? '');
        foreach ($rules['overrides'] as $prefix => $priority) {
            if ($prefix !== '' && str_starts_with($name, $prefix)) {
                return $priority;
            }
        }
        $locality = (string) ($provider['locality'] ?? '');
        $type = (string) ($provider['provider_type'] ?? '');
        if (in_array($locality, $rules['east'], true)) {
            return 'C';
        }
        if (in_array($type, $rules['institutions'], true) || in_array($locality, $rules['mid'], true)) {
            return 'B';
        }
        if (in_array($locality, $rules['west'], true)) {
            return 'A';
        }
        return null;
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
            'Bratislava-Ružinov', 'Bratislava-Rača', 'Bratislava-Vrakuňa', 'Bratislava-Podunajské Biskupice',
            'Rovinka',
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
