<?php

declare(strict_types=1);
/**
 * clinical_trials_common.php
 * Fáza 6 — zdieľané pomocné funkcie pre register klinických štúdií (studie.php / studia.php).
 * Knižnica (len include, web prístup blokovaný v .htaccess).
 */

/** Slovenské popisky kurátorských kategórií. */
function ctCategoryLabels(): array
{
    return [
        'ckd'        => 'Chronická choroba obličiek',
        'dialysis'   => 'Dialýza',
        'transplant' => 'Transplantácia obličky',
        'glomerular' => 'Glomerulopatie',
        'onco'       => 'Onkonefrológia',
        'other'      => 'Ostatné',
    ];
}

/** Popisok kategórie (fallback na slug). */
function ctCategoryLabel(string $slug): string
{
    return ctCategoryLabels()[$slug] ?? ucfirst($slug);
}

/** Slovenský popisok stavu náboru (ClinicalTrials.gov overallStatus). */
function ctStatusLabel(?string $status): string
{
    $map = [
        'RECRUITING'              => 'Nábor prebieha',
        'NOT_YET_RECRUITING'      => 'Nábor sa ešte nezačal',
        'ENROLLING_BY_INVITATION' => 'Nábor na pozvanie',
        'ACTIVE_NOT_RECRUITING'   => 'Aktívna (bez náboru)',
        'COMPLETED'               => 'Ukončená',
        'SUSPENDED'               => 'Pozastavená',
        'TERMINATED'              => 'Predčasne ukončená',
        'WITHDRAWN'               => 'Stiahnutá',
        'UNKNOWN'                 => 'Neznámy stav',
    ];
    return $map[(string) $status] ?? (string) $status;
}

/** Čitateľná fáza (PHASE1 → Fáza 1; NA → bez fázy). */
function ctPhaseLabel(?string $phase): string
{
    if ($phase === null || $phase === '' || $phase === 'NA') {
        return 'bez fázy / neuvedené';
    }
    $parts = array_map(static function (string $p): string {
        return match ($p) {
            'EARLY_PHASE1' => 'skorá fáza 1',
            'PHASE1'       => 'fáza 1',
            'PHASE2'       => 'fáza 2',
            'PHASE3'       => 'fáza 3',
            'PHASE4'       => 'fáza 4',
            default        => $p,
        };
    }, explode('/', $phase));
    return ucfirst(implode(' / ', $parts));
}

/** Bezpečné dekódovanie JSON poľa zo stĺpca; vždy vráti pole reťazcov/štruktúr. */
function ctDecodeJsonList(?string $json): array
{
    if ($json === null || $json === '') {
        return [];
    }
    $d = json_decode($json, true);
    return is_array($d) ? $d : [];
}

/** Kanonická URL štúdie na ClinicalTrials.gov. */
function ctSourceUrl(string $nctId): string
{
    return 'https://clinicaltrials.gov/study/' . rawurlencode($nctId);
}

/**
 * Načíta publikované štúdie s voliteľným filtrom kategórie a textovým hľadaním.
 * @return array<int, array<string, mixed>>
 */
function ctFetchTrials(\PDO $pdo, string $category = '', string $query = '', int $limit = 200): array
{
    $sql = "SELECT nct_id, brief_title, overall_status, phase, study_type, conditions,
                   lead_sponsor, enrollment, last_update_posted, countries, category, sk_note
            FROM clinical_trials
            WHERE is_published = 1";
    $params = [];
    if ($category !== '' && array_key_exists($category, ctCategoryLabels())) {
        $sql .= " AND category = :cat";
        $params['cat'] = $category;
    }
    if ($query !== '') {
        $sql .= " AND (brief_title LIKE :q OR conditions LIKE :q OR lead_sponsor LIKE :q)";
        $params['q'] = '%' . $query . '%';
    }
    $sql .= " ORDER BY last_update_posted DESC, id DESC LIMIT " . (int) $limit;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

/** Načíta jednu publikovanú štúdiu podľa nct_id (alebo null). */
function ctFetchTrial(\PDO $pdo, string $nctId): ?array
{
    $stmt = $pdo->prepare("SELECT * FROM clinical_trials WHERE nct_id = :nct AND is_published = 1 LIMIT 1");
    $stmt->execute(['nct' => $nctId]);
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);
    return is_array($row) ? $row : null;
}

/** Dátum poslednej synchronizácie (max source_synced_at) ako Y-m-d alebo null. */
function ctLastSync(\PDO $pdo): ?string
{
    $v = $pdo->query("SELECT MAX(source_synced_at) FROM clinical_trials")->fetchColumn();
    return is_string($v) && $v !== '' ? substr($v, 0, 10) : null;
}

/** Počty publikovaných štúdií podľa kategórie (slug → počet). */
function ctCategoryCounts(\PDO $pdo): array
{
    $out = [];
    foreach ($pdo->query("SELECT category, COUNT(*) n FROM clinical_trials WHERE is_published = 1 GROUP BY category") as $r) {
        $out[(string) $r['category']] = (int) $r['n'];
    }
    return $out;
}
