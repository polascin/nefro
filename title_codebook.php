<?php

declare(strict_types=1);
// Pomocné funkcie pre číselník akademických a iných titulov

/**
 * Vráti zoznam titulov pred menom z tabuľky title_codebook.
 * Ak databáza nie je dostupná, vráti zabudovaný fallback zoznam.
 */
function getTitlesBeforeName(\PDO $pdo): array {
    try {
        $stmt = $pdo->prepare(
            "SELECT title FROM title_codebook WHERE type = 'before' ORDER BY sort_order ASC, title ASC"
        );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return $rows ?: getFallbackTitlesBefore();
    } catch (\PDOException $e) {
        error_log('title_codebook: chyba načítania titulov pred menom: ' . $e->getMessage());
        return getFallbackTitlesBefore();
    }
}

/**
 * Vráti zoznam titulov za menom z tabuľky title_codebook.
 * Ak databáza nie je dostupná, vráti zabudovaný fallback zoznam.
 */
function getTitlesAfterName(\PDO $pdo): array {
    try {
        $stmt = $pdo->prepare(
            "SELECT title FROM title_codebook WHERE type = 'after' ORDER BY sort_order ASC, title ASC"
        );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return $rows ?: getFallbackTitlesAfter();
    } catch (\PDOException $e) {
        error_log('title_codebook: chyba načítania titulov za menom: ' . $e->getMessage());
        return getFallbackTitlesAfter();
    }
}

/**
 * Záložný zoznam titulov pred menom (ak tabuľka ešte neexistuje).
 */
function getFallbackTitlesBefore(): array {
    return [
        'prof.',
        'doc.',
        'MUDr.',
        'MDDr.',
        'MVDr.',
        'RNDr.',
        'PhDr.',
        'JUDr.',
        'PaedDr.',
        'PhMr.',
        'Mgr.',
        'Mgr. art.',
        'Ing.',
        'Ing. arch.',
        'Bc.',
        'BcA.',
        'ThDr.',
        'ThLic.',
        'ThMgr.',
        'Dr.',
        'Dr. h. c.',
        'Dipl. Ing.',
    ];
}

/**
 * Záložný zoznam titulov za menom (ak tabuľka ešte neexistuje).
 */
function getFallbackTitlesAfter(): array {
    return [
        'PhD.',
        'Ph.D.',
        'CSc.',
        'DrSc.',
        'DSc.',
        'DBA',
        'MBA',
        'MSc.',
        'LL.M.',
        'MPH',
        'MHA',
        'MPA',
        'MPHA',
        'MPM',
        'FRCPS',
        'FACP',
        'FRCP',
        'dis.',
        'DiS.',
    ];
}
?>
