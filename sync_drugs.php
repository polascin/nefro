<?php

declare(strict_types=1);
/**
 * sync_drugs.php
 * Fáza 6 — synchronizácia farmakológie liekov z ChEMBL (EMBL-EBI) REST API v2.
 *
 * Len CLI/cron (php_sapi_name guard + .htaccess deny). Pre kurátorský zoznam liekov
 * (podľa ChEMBL ID) stiahne molekulu + mechanizmus a upsertne do `drugs` (podľa
 * chembl_id). Vytvára lieky ako NEZVEREJNENÉ (is_published ostáva 0).
 *
 * HRANICA KURÁCIE:
 *   - ChEMBL vlastní (aktualizuje pri každom behu): name_intl, atc_code, routes,
 *     max_phase, first_approval, black_box_warning, withdrawn, mechanism, synonyms.
 *   - Seed pri prvom vložení (sync NEPREPISUJE): slug, name_sk, category, drug_class,
 *     source_refs.
 *   - Čisto kurátorské (sync sa NEDOTÝKA): indications, renal_dosing, nephrotoxicity,
 *     dialyzability, warnings, monitoring, sk_note, is_published.
 *
 * Spustenie:  php sync_drugs.php   (cez SSH alebo cron, napr. týždenne)
 * Predpoklad: migrácia `add_drugs_migration.php` už prebehla.
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}
require_once __DIR__ . '/db_config.php';

const DG_API = 'https://www.ebi.ac.uk/chembl/api/data';

/**
 * Kurátorský zoznam nefrologicky relevantných liekov (ChEMBL ID = parent molecule).
 * slug/name_sk/category/drug_class sú seed hodnoty (po vložení ich spravuje admin).
 */
$seed = [
    ['chembl' => 'CHEMBL429910',  'slug' => 'dapagliflozin', 'name_sk' => 'Dapagliflozín', 'category' => 'nephroprotect', 'drug_class' => 'SGLT2 inhibítor'],
    ['chembl' => 'CHEMBL2107830', 'slug' => 'empagliflozin', 'name_sk' => 'Empagliflozín', 'category' => 'nephroprotect', 'drug_class' => 'SGLT2 inhibítor'],
    ['chembl' => 'CHEMBL2181927', 'slug' => 'finerenon',     'name_sk' => 'Finerenón',     'category' => 'nephroprotect', 'drug_class' => 'Nesteroidný MRA'],
    ['chembl' => 'CHEMBL2108724', 'slug' => 'semaglutid',    'name_sk' => 'Semaglutid',    'category' => 'nephroprotect', 'drug_class' => 'GLP-1 receptorový agonista'],
    ['chembl' => 'CHEMBL191',     'slug' => 'losartan',      'name_sk' => 'Losartan',      'category' => 'nephroprotect', 'drug_class' => 'ARB (sartan)'],
    ['chembl' => 'CHEMBL1168',    'slug' => 'ramipril',      'name_sk' => 'Ramipril',      'category' => 'nephroprotect', 'drug_class' => 'ACE inhibítor'],
    ['chembl' => 'CHEMBL1393',    'slug' => 'spironolakton', 'name_sk' => 'Spironolaktón', 'category' => 'nephroprotect', 'drug_class' => 'Steroidný MRA'],
    ['chembl' => 'CHEMBL1431',    'slug' => 'metformin',     'name_sk' => 'Metformín',     'category' => 'dose_adjust',   'drug_class' => 'Biguanid'],
    ['chembl' => 'CHEMBL6067485', 'slug' => 'gentamicin',    'name_sk' => 'Gentamicín',    'category' => 'nephrotoxic',   'drug_class' => 'Aminoglykozid'],
    ['chembl' => 'CHEMBL269732',  'slug' => 'tacrolimus',    'name_sk' => 'Takrolimus',    'category' => 'nephrotoxic',   'drug_class' => 'Kalcineurínový inhibítor'],
];

/** Stiahne JSON z ChEMBL REST; vráti dekódované pole alebo null pri chybe. */
function dgFetch(string $url): ?array
{
    $ch = curl_init($url);
    if ($ch === false) {
        return null;
    }
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_HTTPHEADER     => ['Accept: application/json'],
        CURLOPT_USERAGENT      => 'nefro.polascin.net drug-database sync (+https://nefro.polascin.net)',
    ]);
    $resp = curl_exec($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if (!is_string($resp) || $code !== 200) {
        return null;
    }
    $data = json_decode($resp, true);
    return is_array($data) ? $data : null;
}

/** Cesty podania z booleanov molekuly → CSV „oral,parenteral,topical". */
function dgBuildRoutes(array $m): ?string
{
    $r = [];
    foreach (['oral', 'parenteral', 'topical'] as $k) {
        if (!empty($m[$k])) {
            $r[] = $k;
        }
    }
    return $r !== [] ? implode(',', $r) : null;
}

/** ATC level5 z poľa atc_classifications (REST: pole reťazcov, prvý prvok). */
function dgExtractAtc(array $m): ?string
{
    $atc = $m['atc_classifications'] ?? null;
    if (is_array($atc) && isset($atc[0]) && is_string($atc[0]) && $atc[0] !== '') {
        return mb_substr($atc[0], 0, 16);
    }
    return null;
}

/** Obchodné názvy (TRADE_NAME) z molecule_synonyms → JSON (max 15, dedup). */
function dgExtractSynonyms(array $m): ?string
{
    $syns = $m['molecule_synonyms'] ?? null;
    if (!is_array($syns)) {
        return null;
    }
    $seen = [];
    $out = [];
    foreach ($syns as $s) {
        if (!is_array($s)) {
            continue;
        }
        $type = strtoupper((string) ($s['syn_type'] ?? ''));
        if ($type !== 'TRADE_NAME') {
            continue;
        }
        $name = trim((string) ($s['molecule_synonym'] ?? ''));
        $key = mb_strtolower($name);
        if ($name === '' || isset($seen[$key])) {
            continue;
        }
        $seen[$key] = true;
        $out[] = $name;
        if (count($out) >= 15) {
            break;
        }
    }
    return $out !== [] ? (json_encode($out, JSON_UNESCAPED_UNICODE) ?: null) : null;
}

/** EMA odkazy z cross_references → JSON [{label,url}] (len pri prvom vložení). */
function dgExtractSources(array $m): ?string
{
    $refs = $m['cross_references'] ?? null;
    if (!is_array($refs)) {
        return null;
    }
    $out = [];
    foreach ($refs as $r) {
        if (!is_array($r) || strtoupper((string) ($r['xref_src'] ?? '')) !== 'EMA') {
            continue;
        }
        $xid = trim((string) ($r['xref_id'] ?? ''));
        $xname = trim((string) ($r['xref_name'] ?? ''));
        if ($xid === '' || !str_starts_with($xid, 'human/')) {
            continue;
        }
        $out[] = [
            'label' => 'EMA EPAR' . ($xname !== '' ? ' — ' . ucfirst($xname) : ''),
            'url'   => 'https://www.ema.europa.eu/en/medicines/' . $xid,
        ];
        if (count($out) >= 6) {
            break;
        }
    }
    return $out !== [] ? (json_encode($out, JSON_UNESCAPED_UNICODE) ?: null) : null;
}

/** Mechanizmus účinku z mechanism endpointu (spojí unikátne MoA). */
function dgFetchMechanism(string $chemblId): ?string
{
    $data = dgFetch(DG_API . '/mechanism.json?molecule_chembl_id=' . rawurlencode($chemblId) . '&limit=20');
    $list = is_array($data) ? ($data['mechanisms'] ?? null) : null;
    if (!is_array($list)) {
        return null;
    }
    $seen = [];
    $parts = [];
    foreach ($list as $row) {
        $moa = is_array($row) ? trim((string) ($row['mechanism_of_action'] ?? '')) : '';
        if ($moa === '' || isset($seen[$moa])) {
            continue;
        }
        $seen[$moa] = true;
        $parts[] = $moa;
    }
    return $parts !== [] ? mb_substr(implode('; ', $parts), 0, 2000) : null;
}

/** @var \PDO $pdo */
$insert = $pdo->prepare(
    "INSERT INTO drugs
        (slug, name_sk, category, drug_class, chembl_id, name_intl, atc_code, routes,
         max_phase, first_approval, black_box_warning, withdrawn, mechanism, synonyms,
         source_refs, chembl_synced_at)
     VALUES
        (:slug, :name_sk, :category, :drug_class, :chembl_id, :name_intl, :atc_code, :routes,
         :max_phase, :first_approval, :black_box_warning, :withdrawn, :mechanism, :synonyms,
         :source_refs, :synced_at)
     ON DUPLICATE KEY UPDATE
        name_intl = VALUES(name_intl), atc_code = VALUES(atc_code), routes = VALUES(routes),
        max_phase = VALUES(max_phase), first_approval = VALUES(first_approval),
        black_box_warning = VALUES(black_box_warning), withdrawn = VALUES(withdrawn),
        mechanism = VALUES(mechanism), synonyms = VALUES(synonyms),
        chembl_synced_at = VALUES(chembl_synced_at)"
);

$now = date('Y-m-d H:i:s');
$ok = 0;
$failed = 0;
$errors = [];

foreach ($seed as $drug) {
    $chemblId = $drug['chembl'];
    $mol = dgFetch(DG_API . '/molecule/' . rawurlencode($chemblId) . '.json');
    if ($mol === null) {
        $failed++;
        $errors[] = "$chemblId ({$drug['name_sk']}): zlyhalo stiahnutie molekuly.";
        continue;
    }

    $maxPhaseRaw = $mol['max_phase'] ?? null;
    $maxPhase = is_numeric($maxPhaseRaw) ? (int) round((float) $maxPhaseRaw) : null;
    $approval = isset($mol['first_approval']) && is_numeric($mol['first_approval']) ? (int) $mol['first_approval'] : null;

    try {
        $insert->execute([
            'slug'              => $drug['slug'],
            'name_sk'           => $drug['name_sk'],
            'category'          => $drug['category'],
            'drug_class'        => $drug['drug_class'],
            'chembl_id'         => $chemblId,
            'name_intl'         => (($p = trim((string) ($mol['pref_name'] ?? ''))) !== '') ? mb_substr($p, 0, 200) : null,
            'atc_code'          => dgExtractAtc($mol),
            'routes'            => dgBuildRoutes($mol),
            'max_phase'         => $maxPhase,
            'first_approval'    => $approval,
            'black_box_warning' => !empty($mol['black_box_warning']) ? 1 : 0,
            'withdrawn'         => !empty($mol['withdrawn_flag']) ? 1 : 0,
            'mechanism'         => dgFetchMechanism($chemblId),
            'synonyms'          => dgExtractSynonyms($mol),
            'source_refs'       => dgExtractSources($mol),
            'synced_at'         => $now,
        ]);
        $ok++;
    } catch (\PDOException $e) {
        $failed++;
        $errors[] = "$chemblId: " . $e->getMessage();
        error_log('sync_drugs upsert error: ' . $e->getMessage());
    }
}

echo "──────────────────────────────────────────────────────\n";
echo "Synchronizácia liekov (ChEMBL / EMBL-EBI)\n";
echo "──────────────────────────────────────────────────────\n";
echo "V zozname:        " . count($seed) . "\n";
echo "Uložených/upsert: $ok\n";
echo "Zlyhaných:        $failed\n";
if ($errors !== []) {
    echo "Chyby:\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
}
echo "Lieky sa vytvárajú ako NEZVEREJNENÉ — doplňte renálne dávkovanie a zverejnite v admin_drugs.php.\n";
echo "Dokončené: $now\n";

error_log(sprintf('sync_drugs: total=%d ok=%d failed=%d at %s', count($seed), $ok, $failed, $now));
