<?php

if (!function_exists('normalizeUserMobilePhone')) {
    /**
     * Normalize and validate user's mobile phone in international format.
     * Accepted examples: +421901234567, +421 901 234 567.
     * Returns normalized format +421XXXXXXXXX or null when empty.
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
     * Normalize and validate a generic phone number in international format.
     * Supports +XXXXXXXX without/with separators.
     * Returns normalized format +XXXXXXXX or null when empty.
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
     * Formats a normalized phone number with spaces for readability.
     * Keeps unsupported formats unchanged.
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
