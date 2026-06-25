<?php

declare(strict_types=1);
/**
 * drugs_common.php
 * Fáza 6 — zdieľané pomocné funkcie pre databázu liekov (lieky.php / liek.php / admin_drugs.php).
 * Knižnica (len include, web prístup blokovaný v .htaccess).
 */

/** Slovenské popisky kurátorských kategórií liekov. */
function dgCategoryLabels(): array
{
    return [
        'nephroprotect' => 'Nefroprotektíva',
        'diuretic'      => 'Diuretiká',
        'dose_adjust'   => 'Úprava dávky podľa obličiek',
        'nephrotoxic'   => 'Nefrotoxické lieky',
        'dialysis'      => 'Lieky a dialýza',
        'transplant'    => 'Transplantácia / imunosupresia',
        'other'         => 'Ostatné',
    ];
}

/** Popisok kategórie (fallback na slug). */
function dgCategoryLabel(string $slug): string
{
    return dgCategoryLabels()[$slug] ?? ucfirst($slug);
}

/** Čitateľný popisok klinickej fázy (ChEMBL max_phase). */
function dgPhaseLabel(?int $maxPhase): string
{
    return match ($maxPhase) {
        4       => 'Schválený liek',
        3       => 'Fáza 3 (klinické skúšanie)',
        2       => 'Fáza 2 (klinické skúšanie)',
        1       => 'Fáza 1 (klinické skúšanie)',
        0       => 'Predklinické štádium',
        default => '',
    };
}

/** Cesty podania (CSV „oral,parenteral,topical") → slovenský zoznam. */
function dgRoutesLabel(?string $routes): string
{
    if ($routes === null || trim($routes) === '') {
        return '';
    }
    $map = [
        'oral'       => 'perorálny',
        'parenteral' => 'parenterálny',
        'topical'    => 'lokálny',
    ];
    $out = [];
    foreach (explode(',', $routes) as $r) {
        $r = trim($r);
        if ($r === '') {
            continue;
        }
        $out[] = $map[$r] ?? $r;
    }
    return implode(', ', $out);
}

/** Generuje URL-friendly ASCII slug z názvu lieku (translit. diakritiky). */
function dgSlugify(string $name): string
{
    $map = [
        'á' => 'a', 'ä' => 'a', 'č' => 'c', 'ď' => 'd', 'é' => 'e', 'í' => 'i',
        'ĺ' => 'l', 'ľ' => 'l', 'ň' => 'n', 'ó' => 'o', 'ô' => 'o', 'ŕ' => 'r',
        'š' => 's', 'ť' => 't', 'ú' => 'u', 'ý' => 'y', 'ž' => 'z',
        'Á' => 'a', 'Ä' => 'a', 'Č' => 'c', 'Ď' => 'd', 'É' => 'e', 'Í' => 'i',
        'Ĺ' => 'l', 'Ľ' => 'l', 'Ň' => 'n', 'Ó' => 'o', 'Ô' => 'o', 'Ŕ' => 'r',
        'Š' => 's', 'Ť' => 't', 'Ú' => 'u', 'Ý' => 'y', 'Ž' => 'z',
    ];
    $name = strtr($name, $map);
    $name = strtolower($name);
    $name = preg_replace('/[^a-z0-9]+/', '-', $name) ?? '';
    $name = trim($name, '-');
    return mb_substr($name, 0, 120);
}

/** Bezpečné dekódovanie JSON poľa zo stĺpca; vždy vráti pole. */
function dgDecodeJsonList(?string $json): array
{
    if ($json === null || $json === '') {
        return [];
    }
    $d = json_decode($json, true);
    return is_array($d) ? $d : [];
}

/** Kanonická URL lieku v prehliadači ChEMBL. */
function dgChemblUrl(string $chemblId): string
{
    return 'https://www.ebi.ac.uk/chembl/explore/compound/' . rawurlencode($chemblId);
}

/** URL do WHO ATC/DDD indexu pre daný ATC kód. */
function dgAtcUrl(string $atc): string
{
    return 'https://www.whocc.no/atc_ddd_index/?code=' . rawurlencode($atc);
}

/**
 * Načíta zverejnené lieky s voliteľným filtrom kategórie a textovým hľadaním.
 * @return array<int, array<string, mixed>>
 */
function dgFetchDrugs(\PDO $pdo, string $category = '', string $query = '', int $limit = 300): array
{
    $sql = "SELECT slug, name_sk, name_intl, drug_class, atc_code, category, max_phase,
                   black_box_warning, withdrawn, renal_dosing, sk_note
            FROM drugs
            WHERE is_published = 1";
    $params = [];
    if ($category !== '' && array_key_exists($category, dgCategoryLabels())) {
        $sql .= " AND category = :cat";
        $params['cat'] = $category;
    }
    if ($query !== '') {
        $sql .= " AND (name_sk LIKE :q OR name_intl LIKE :q OR drug_class LIKE :q OR atc_code LIKE :q)";
        $params['q'] = '%' . $query . '%';
    }
    $sql .= " ORDER BY name_sk ASC LIMIT " . (int) $limit;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

/** Načíta jeden zverejnený liek podľa slugu (alebo null). */
function dgFetchDrug(\PDO $pdo, string $slug): ?array
{
    $stmt = $pdo->prepare("SELECT * FROM drugs WHERE slug = :slug AND is_published = 1 LIMIT 1");
    $stmt->execute(['slug' => $slug]);
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);
    return is_array($row) ? $row : null;
}

/** Počty zverejnených liekov podľa kategórie (slug → počet). */
function dgCategoryCounts(\PDO $pdo): array
{
    $out = [];
    foreach ($pdo->query("SELECT category, COUNT(*) n FROM drugs WHERE is_published = 1 GROUP BY category") as $r) {
        $out[(string) $r['category']] = (int) $r['n'];
    }
    return $out;
}

/** Dátum poslednej synchronizácie z ChEMBL (max chembl_synced_at) ako Y-m-d alebo null. */
function dgLastSync(\PDO $pdo): ?string
{
    $v = $pdo->query("SELECT MAX(chembl_synced_at) FROM drugs")->fetchColumn();
    return is_string($v) && $v !== '' ? substr($v, 0, 10) : null;
}
