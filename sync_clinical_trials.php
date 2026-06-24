<?php

declare(strict_types=1);
/**
 * sync_clinical_trials.php
 * Fáza 6 — synchronizácia kurátorského registra klinických štúdií z ClinicalTrials.gov v2 API.
 *
 * Len CLI/cron (php_sapi_name guard + .htaccess deny). Pre každú nefrologickú kategóriu
 * stiahne najnovšie aktualizované NÁBOROVÉ intervenčné štúdie a upsertne ich do
 * `clinical_trials` (podľa nct_id). Zachováva ručne kurátorské polia `sk_note` a `is_published`.
 *
 * Spustenie:  php sync_clinical_trials.php   (cez SSH alebo cron, napr. týždenne)
 * Predpoklad: migrácia `add_clinical_trials_migration.php` už prebehla.
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}
require_once __DIR__ . '/db_config.php';

const CT_API = 'https://clinicaltrials.gov/api/v2/studies';
const CT_PAGE_SIZE = 40;

/** Kurátorský výber: slug kategórie → vyhľadávacia podmienka (query.cond). */
$categories = [
    'ckd'        => 'chronic kidney disease',
    'dialysis'   => 'dialysis',
    'transplant' => 'kidney transplantation',
    'glomerular' => 'glomerulonephritis',
    // Onkonefrológia: jednotka „onconephrology" nie je indexovaná ako podmienka —
    // mierime na reálne renálne onko-hematologické jednotky (viac termínov).
    'onco'       => [
        'tumor lysis syndrome',
        'myeloma cast nephropathy',
        'monoclonal gammopathy of renal significance',
        'renal amyloidosis',
        'cisplatin nephrotoxicity',
    ],
];

/** Bezpečné čítanie zanorenej hodnoty z poľa cez cestu kľúčov. */
function ctGet(array $arr, array $path, mixed $default = null): mixed
{
    $cur = $arr;
    foreach ($path as $k) {
        if (!is_array($cur) || !array_key_exists($k, $cur)) {
            return $default;
        }
        $cur = $cur[$k];
    }
    return $cur;
}

/** Normalizácia dátumu z ClinicalTrials.gov (YYYY / YYYY-MM / YYYY-MM-DD / „Month YYYY") na Y-m-d alebo null. */
function ctNormalizeDate(?string $d): ?string
{
    if ($d === null || $d === '') {
        return null;
    }
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) {
        return $d;
    }
    if (preg_match('/^\d{4}-\d{2}$/', $d)) {
        return $d . '-01';
    }
    if (preg_match('/^\d{4}$/', $d)) {
        return $d . '-01-01';
    }
    $ts = strtotime($d);
    return $ts !== false ? date('Y-m-d', $ts) : null;
}

/** Stiahne JSON z v2 API; vráti dekódované pole alebo null pri chybe. */
function ctFetch(string $url): ?array
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
        CURLOPT_USERAGENT      => 'nefro.polascin.net clinical-trials sync (+https://nefro.polascin.net)',
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

/** @var \PDO $pdo */
$upsert = $pdo->prepare(
    "INSERT INTO clinical_trials
        (nct_id, brief_title, official_title, overall_status, phase, study_type, conditions,
         interventions, lead_sponsor, enrollment, start_date, completion_date, last_update_posted,
         countries, brief_summary, category, source_synced_at)
     VALUES
        (:nct_id, :brief_title, :official_title, :overall_status, :phase, :study_type, :conditions,
         :interventions, :lead_sponsor, :enrollment, :start_date, :completion_date, :last_update_posted,
         :countries, :brief_summary, :category, :synced_at)
     ON DUPLICATE KEY UPDATE
        brief_title = VALUES(brief_title), official_title = VALUES(official_title),
        overall_status = VALUES(overall_status), phase = VALUES(phase), study_type = VALUES(study_type),
        conditions = VALUES(conditions), interventions = VALUES(interventions),
        lead_sponsor = VALUES(lead_sponsor), enrollment = VALUES(enrollment),
        start_date = VALUES(start_date), completion_date = VALUES(completion_date),
        last_update_posted = VALUES(last_update_posted), countries = VALUES(countries),
        brief_summary = VALUES(brief_summary), source_synced_at = VALUES(source_synced_at)"
);

$now = date('Y-m-d H:i:s');
$totalSeen = 0;
$totalStored = 0;
$totalSkipped = 0;
$errors = [];

// Rozbalenie kategórií (slug → jeden alebo viac termínov) do plochého zoznamu dotazov.
$queries = [];
foreach ($categories as $cat => $condList) {
    foreach ((array) $condList as $cond) {
        $queries[] = ['cat' => (string) $cat, 'cond' => (string) $cond];
    }
}

foreach ($queries as $q) {
    $cat = $q['cat'];
    $cond = $q['cond'];
    $url = CT_API . '?' . http_build_query([
        'query.cond'           => $cond,
        'filter.overallStatus' => 'RECRUITING',
        'sort'                 => 'LastUpdatePostDate:desc',
        'pageSize'             => CT_PAGE_SIZE,
        'fields'               => implode(',', [
            'protocolSection.identificationModule',
            'protocolSection.statusModule',
            'protocolSection.designModule',
            'protocolSection.conditionsModule',
            'protocolSection.armsInterventionsModule',
            'protocolSection.sponsorCollaboratorsModule',
            'protocolSection.descriptionModule',
            'protocolSection.contactsLocationsModule',
        ]),
    ]);

    $data = ctFetch($url);
    if ($data === null) {
        $errors[] = "Kategória '$cat': zlyhalo stiahnutie z API.";
        continue;
    }
    $studies = ctGet($data, ['studies'], []);
    if (!is_array($studies)) {
        continue;
    }

    foreach ($studies as $study) {
        if (!is_array($study)) {
            continue;
        }
        $totalSeen++;
        $ps = ctGet($study, ['protocolSection'], []);
        if (!is_array($ps)) {
            continue;
        }

        $studyType = (string) ctGet($ps, ['designModule', 'studyType'], '');
        if ($studyType !== 'INTERVENTIONAL') {
            $totalSkipped++;
            continue;
        }

        $nctId = trim((string) ctGet($ps, ['identificationModule', 'nctId'], ''));
        $briefTitle = trim((string) ctGet($ps, ['identificationModule', 'briefTitle'], ''));
        if ($nctId === '' || $briefTitle === '') {
            $totalSkipped++;
            continue;
        }

        // Fázy
        $phases = ctGet($ps, ['designModule', 'phases'], []);
        $phase = is_array($phases) && $phases !== [] ? implode('/', array_map('strval', $phases)) : null;

        // Podmienky (pole reťazcov)
        $conditions = ctGet($ps, ['conditionsModule', 'conditions'], []);
        $conditionsJson = is_array($conditions) && $conditions !== []
            ? json_encode(array_values(array_map('strval', $conditions)), JSON_UNESCAPED_UNICODE) : null;

        // Intervencie ({type, name})
        $intervRaw = ctGet($ps, ['armsInterventionsModule', 'interventions'], []);
        $interv = [];
        if (is_array($intervRaw)) {
            foreach ($intervRaw as $iv) {
                if (!is_array($iv)) {
                    continue;
                }
                $name = trim((string) ($iv['name'] ?? ''));
                if ($name === '') {
                    continue;
                }
                $interv[] = ['type' => (string) ($iv['type'] ?? ''), 'name' => $name];
            }
        }
        $intervJson = $interv !== [] ? json_encode($interv, JSON_UNESCAPED_UNICODE) : null;

        // Krajiny (unikátne)
        $locs = ctGet($ps, ['contactsLocationsModule', 'locations'], []);
        $countries = [];
        if (is_array($locs)) {
            foreach ($locs as $loc) {
                $c = is_array($loc) ? trim((string) ($loc['country'] ?? '')) : '';
                if ($c !== '') {
                    $countries[$c] = true;
                }
            }
        }
        $countriesJson = $countries !== []
            ? json_encode(array_keys($countries), JSON_UNESCAPED_UNICODE) : null;

        $enrollment = ctGet($ps, ['designModule', 'enrollmentInfo', 'count'], null);
        $enrollment = is_numeric($enrollment) ? (int) $enrollment : null;

        $summary = trim((string) ctGet($ps, ['descriptionModule', 'briefSummary'], ''));
        if (mb_strlen($summary) > 5000) {
            $summary = mb_substr($summary, 0, 5000);
        }

        try {
            $upsert->execute([
                'nct_id'             => mb_substr($nctId, 0, 20),
                'brief_title'        => mb_substr($briefTitle, 0, 600),
                'official_title'     => (($t = trim((string) ctGet($ps, ['identificationModule', 'officialTitle'], ''))) !== '') ? $t : null,
                'overall_status'     => (($s = (string) ctGet($ps, ['statusModule', 'overallStatus'], '')) !== '') ? $s : null,
                'phase'              => $phase,
                'study_type'         => $studyType,
                'conditions'         => $conditionsJson,
                'interventions'      => $intervJson,
                'lead_sponsor'       => (($ls = trim((string) ctGet($ps, ['sponsorCollaboratorsModule', 'leadSponsor', 'name'], ''))) !== '') ? mb_substr($ls, 0, 300) : null,
                'enrollment'         => $enrollment,
                'start_date'         => ctNormalizeDate((string) ctGet($ps, ['statusModule', 'startDateStruct', 'date'], '') ?: null),
                'completion_date'    => ctNormalizeDate((string) ctGet($ps, ['statusModule', 'primaryCompletionDateStruct', 'date'], '') ?: null),
                'last_update_posted' => ctNormalizeDate((string) ctGet($ps, ['statusModule', 'lastUpdatePostDateStruct', 'date'], '') ?: null),
                'countries'          => $countriesJson,
                'brief_summary'      => $summary !== '' ? $summary : null,
                'category'           => $cat,
                'synced_at'          => $now,
            ]);
            $totalStored++;
        } catch (\PDOException $e) {
            $errors[] = "$nctId: " . $e->getMessage();
            error_log('sync_clinical_trials upsert error: ' . $e->getMessage());
        }
    }
}

echo "──────────────────────────────────────────────────────\n";
echo "Synchronizácia klinických štúdií (ClinicalTrials.gov v2)\n";
echo "──────────────────────────────────────────────────────\n";
echo "Kategórie:        " . implode(', ', array_keys($categories)) . "\n";
echo "Záznamov z API:   $totalSeen\n";
echo "Uložených/upsert: $totalStored\n";
echo "Preskočených:     $totalSkipped (neintervenčné / neúplné)\n";
if ($errors !== []) {
    echo "Chyby:\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
}
echo "Dokončené: $now\n";

// Trvalý záznam o behu (cron výstup do stdout sa nezachová) — dohľadateľnosť plánovaných synchronizácií.
error_log(sprintf(
    'sync_clinical_trials: seen=%d stored=%d skipped=%d errors=%d at %s',
    $totalSeen,
    $totalStored,
    $totalSkipped,
    count($errors),
    $now
));
