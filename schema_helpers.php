<?php

declare(strict_types=1);
/**
 * schema_helpers.php
 * ────────────────────────────────────────────────────────────────────────────
 * Pomocné funkcie na zisťovanie stavu schémy.
 *
 * Zdieľané `setup_db.php` aj migračnymi skriptami `add_*_migration.php`, aby
 * sa detekcia stĺpca či indexu neopakovala na miestach. Všetky sú
 * idempotentné a bezpečné na opakované spustenie.
 * ────────────────────────────────────────────────────────────────────────────
 */

if (!function_exists('schemaTableExists')) {
    /** Existuje tabuľka v aktuálnej schéme? */
    function schemaTableExists(PDO $pdo, string $table): bool
    {
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table"
        );
        $stmt->execute(['table' => $table]);

        return (int) $stmt->fetchColumn() > 0;
    }
}

if (!function_exists('columnExists')) {
    /** Existuje stĺpec v aktuálnej schéme? */
    function columnExists(PDO $pdo, string $table, string $column): bool
    {
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND COLUMN_NAME = :column"
        );
        $stmt->execute(['table' => $table, 'column' => $column]);

        return (int) $stmt->fetchColumn() > 0;
    }
}

if (!function_exists('indexExists')) {
    /** Existuje index s daným menom v aktuálnej schéme? */
    function indexExists(PDO $pdo, string $table, string $index): bool
    {
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND INDEX_NAME = :index"
        );
        $stmt->execute(['table' => $table, 'index' => $index]);

        return (int) $stmt->fetchColumn() > 0;
    }
}

if (!function_exists('enumContainsValue')) {
    /**
     * Obsahuje ENUM stĺpec danú hodnotu?
     *
     * @param string $columnType Hodnota COLUMN_TYPE z INFORMATION_SCHEMA, napr.
     *                           `enum('pending','sent','failed')`.
     */
    function enumContainsValue(string $columnType, string $value): bool
    {
        return stripos($columnType, "'" . $value . "'") !== false;
    }
}
