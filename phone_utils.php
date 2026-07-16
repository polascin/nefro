<?php

declare(strict_types=1);

if (!function_exists('normalizeUserMobilePhone')) {
    /**
     * Normalizuje a validuje mobilné tel. číslo používateľa v medzinárodnom formáte.
     * Akceptované príklady: +421901234567, +421 901 234 567.
     * Vráti normalizovaný formát +421XXXXXXXXX alebo null pre prázdnu hodnotu.
     */
    function normalizeUserMobilePhone(?string $rawPhone)
    {
        $value = trim((string) $rawPhone);
        if ($value === '') {
            return null;
        }

        $compact = preg_replace('/[\s\-()\.\/]+/', '', $value);
        if ($compact === null || $compact === '') {
            return false;
        }

        if (!str_starts_with($compact, '+')) {
            return false;
        }

        $digits = substr($compact, 1);
        if (!preg_match('/^\d+$/', (string) $digits)) {
            return false;
        }

        if (!str_starts_with($digits, '421')) {
            return false;
        }

        $local = substr($digits, 3);
        if (!preg_match('/^9\d{8}$/', (string) $local)) {
            return false;
        }

        return '+421' . $local;
    }
}

if (!function_exists('normalizeGenericPhone')) {
    /**
     * Normalizuje a validuje všeobecné tel. číslo v medzinárodnom formáte.
     * Podporuje +XXXXXXXX bez oddeľovačov alebo s oddeľovačmi.
     * Vráti normalizovaný formát +XXXXXXXX alebo null pre prázdnu hodnotu.
     */
    function normalizeGenericPhone(?string $rawPhone)
    {
        $value = trim((string) $rawPhone);
        if ($value === '') {
            return null;
        }

        $compact = preg_replace('/[\s\-()\.\/]+/', '', $value);
        if ($compact === null || $compact === '') {
            return false;
        }

        if (!str_starts_with($compact, '+')) {
            return false;
        }

        $digits = substr($compact, 1);
        if (!preg_match('/^\d{8,15}$/', (string) $digits)) {
            return false;
        }

        return '+' . $digits;
    }
}

if (!function_exists('formatPhoneForDisplay')) {
    /**
     * Naformátuje normalizované tel. číslo s medzerami pre čiteľnosť.
     * Nepodporované formáty ponechá bezo zmeny.
     */
    function formatPhoneForDisplay(?string $rawPhone): string
    {
        $value = trim((string) $rawPhone);
        if ($value === '') {
            return '';
        }

        $compact = preg_replace('/[\s\-()\.\/]+/', '', $value);
        if ($compact === null || $compact === '') {
            return $value;
        }

        if (!str_starts_with($compact, '+')) {
            return $value;
        }

        $digits = substr($compact, 1);
        if (!preg_match('/^\d+$/', (string) $digits)) {
            return $value;
        }

        if (str_starts_with($digits, '421')) {
            $local = substr($digits, 3);
            if (preg_match('/^9\d{8}$/', (string) $local)) {
                return '+421 ' . substr($local, 0, 3) . ' ' . substr($local, 3, 3) . ' ' . substr($local, 6, 3);
            }
            if (strlen($local) === 8 && str_starts_with($local, '2')) {
                return '+421 2 ' . substr($local, 1, 4) . ' ' . substr($local, 5, 3);
            }
            if (strlen($local) >= 6) {
                $chunks = str_split($local, 3);
                return '+421 ' . implode(' ', $chunks);
            }
        }

        $chunks = str_split($digits, 3);
        return '+' . implode(' ', $chunks);
    }
}
