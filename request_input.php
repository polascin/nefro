<?php

declare(strict_types=1);

/**
 * request_input.php
 *
 * Vstupná vrstva bootstrapu: jednotné čítanie skalárnych HTTP parametrov.
 * Pole alebo objekt namiesto skaláru nesmie skončiť TypeError/HTML fatálom —
 * odpoveď je riadená HTTP 400 (JSON ak endpoint už posiela JSON, inak plain text).
 *
 * Súčasť P1 „oddelenie bootstrapov“ (ANALYZA_A_PLAN_ROZVOJA.md): malý izolovaný
 * modul bez framework churnu. Načítať pred spracovaním $_GET/$_POST.
 */

if (!function_exists('requestIsScalarInput')) {
    function requestIsScalarInput(mixed $value): bool
    {
        return $value === null || is_scalar($value);
    }
}

if (!function_exists('requestInputResponseIsJson')) {
    /**
     * JSON odpoveď: už nastavený Content-Type, Accept klienta, alebo explicitný príznak.
     * (Niektoré CLI SAPI neukladajú header() do headers_list().)
     */
    function requestInputResponseIsJson(?bool $force = null): bool
    {
        static $preferJson = false;
        if ($force !== null) {
            $preferJson = $force;
        }
        if ($preferJson) {
            return true;
        }
        foreach (headers_list() as $header) {
            if (stripos($header, 'Content-Type:') === 0
                && stripos($header, 'application/json') !== false) {
                return true;
            }
        }
        $accept = (string) ($_SERVER['HTTP_ACCEPT'] ?? '');

        return str_contains($accept, 'application/json')
            && !str_contains($accept, 'text/html');
    }
}

if (!function_exists('requestRejectNonScalarInput')) {
    /**
     * Ukončí požiadavku s HTTP 400. Nikdy nevracia HTML chybovú stránku PHP.
     */
    function requestRejectNonScalarInput(string $param): never
    {
        $param = preg_replace('/[^a-zA-Z0-9_.\-]/', '', $param) ?? 'param';
        $message = 'Neplatný tvar parametra "' . $param . '". Očakáva sa jedna hodnota.';
        $wantsJson = requestInputResponseIsJson();

        if (!headers_sent()) {
            http_response_code(400);
            header('Cache-Control: no-store');
            if ($wantsJson) {
                header('Content-Type: application/json; charset=UTF-8');
                echo json_encode([
                    'ok' => false,
                    'error' => 'invalid_parameter',
                    'parameter' => $param,
                    'message' => $message,
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }
            header('Content-Type: text/plain; charset=UTF-8');
        } elseif ($wantsJson) {
            echo json_encode([
                'ok' => false,
                'error' => 'invalid_parameter',
                'parameter' => $param,
                'message' => $message,
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo $message;
        exit;
    }
}

if (!function_exists('requestScalarString')) {
    /**
     * @param array<string, mixed> $source
     * @param bool $trim Heslá a podobné hodnoty neorezávať (`false`).
     */
    function requestScalarString(
        array $source,
        string $key,
        string $default = '',
        bool $rejectNonScalar = true,
        bool $trim = true
    ): string {
        if (!array_key_exists($key, $source)) {
            return $default;
        }
        $value = $source[$key];
        if (!requestIsScalarInput($value)) {
            if ($rejectNonScalar) {
                requestRejectNonScalarInput($key);
            }
            return $default;
        }
        if ($value === null) {
            return $default;
        }
        $out = (string) $value;

        return $trim ? trim($out) : $out;
    }
}

if (!function_exists('requestScalarStringPreferPost')) {
    /**
     * POST má prednosť pred GET (typicky token/slug vo formulári aj v odkaze).
     */
    function requestScalarStringPreferPost(
        string $key,
        string $default = '',
        bool $rejectNonScalar = true,
        bool $trim = true
    ): string {
        if (array_key_exists($key, $_POST)) {
            return requestScalarString($_POST, $key, $default, $rejectNonScalar, $trim);
        }

        return requestScalarString($_GET, $key, $default, $rejectNonScalar, $trim);
    }
}

if (!function_exists('requestScalarIntPreferPost')) {
    function requestScalarIntPreferPost(
        string $key,
        int $default = 0,
        bool $rejectNonScalar = true
    ): int {
        if (array_key_exists($key, $_POST)) {
            return requestScalarInt($_POST, $key, $default, $rejectNonScalar);
        }

        return requestScalarInt($_GET, $key, $default, $rejectNonScalar);
    }
}

if (!function_exists('requestScalarInt')) {
    /**
     * @param array<string, mixed> $source
     */
    function requestScalarInt(
        array $source,
        string $key,
        int $default = 0,
        bool $rejectNonScalar = true
    ): int {
        if (!array_key_exists($key, $source)) {
            return $default;
        }
        $value = $source[$key];
        if (!requestIsScalarInput($value)) {
            if ($rejectNonScalar) {
                requestRejectNonScalarInput($key);
            }
            return $default;
        }
        if ($value === null || $value === '') {
            return $default;
        }
        if (is_bool($value)) {
            return $value ? 1 : 0;
        }
        if (is_int($value)) {
            return $value;
        }
        if (is_float($value)) {
            return (int) $value;
        }
        $raw = trim((string) $value);
        if ($raw === '' || !preg_match('/^-?\d+$/', $raw)) {
            return $default;
        }

        return (int) $raw;
    }
}

if (!function_exists('requestRejectInvalidListInput')) {
    /**
     * Ukončí požiadavku s HTTP 400 pri vnorenom poli/objekte v listovom parametri.
     */
    function requestRejectInvalidListInput(string $param): never
    {
        $param = preg_replace('/[^a-zA-Z0-9_.\-\[\]]/', '', $param) ?? 'param';
        $message = 'Neplatný tvar parametra "' . $param . '". Očakáva sa zoznam jednoduchých hodnôt.';
        $wantsJson = requestInputResponseIsJson();

        if (!headers_sent()) {
            http_response_code(400);
            header('Cache-Control: no-store');
            if ($wantsJson) {
                header('Content-Type: application/json; charset=UTF-8');
                echo json_encode([
                    'ok' => false,
                    'error' => 'invalid_parameter',
                    'parameter' => $param,
                    'message' => $message,
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }
            header('Content-Type: text/plain; charset=UTF-8');
        } elseif ($wantsJson) {
            echo json_encode([
                'ok' => false,
                'error' => 'invalid_parameter',
                'parameter' => $param,
                'message' => $message,
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo $message;
        exit;
    }
}

if (!function_exists('requestStringList')) {
    /**
     * Zoznam reťazcov z GET/POST (multi-select / checkbox group).
     *
     * - chýbajúci kľúč → []
     * - skalár → jedno orezané neprázdne pole, alebo []
     * - pole skalárov → list orezaných neprázdnych reťazcov
     * - vnorené pole/objekt → HTTP 400 (ak $rejectNested)
     *
     * @param array<string, mixed> $source
     * @return list<string>
     */
    function requestStringList(
        array $source,
        string $key,
        bool $rejectNested = true,
        bool $trim = true
    ): array {
        if (!array_key_exists($key, $source)) {
            return [];
        }
        $value = $source[$key];
        if (requestIsScalarInput($value)) {
            if ($value === null) {
                return [];
            }
            $out = (string) $value;
            if ($trim) {
                $out = trim($out);
            }

            return $out === '' ? [] : [$out];
        }
        if (!is_array($value)) {
            if ($rejectNested) {
                requestRejectInvalidListInput($key);
            }

            return [];
        }

        $items = [];
        foreach ($value as $item) {
            if (!requestIsScalarInput($item)) {
                if ($rejectNested) {
                    requestRejectInvalidListInput($key);
                }
                continue;
            }
            if ($item === null) {
                continue;
            }
            $raw = (string) $item;
            if ($trim) {
                $raw = trim($raw);
            }
            if ($raw !== '') {
                $items[] = $raw;
            }
        }

        return $items;
    }
}
