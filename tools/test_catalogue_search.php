<?php

declare(strict_types=1);

require_once __DIR__ . '/../clinical_trials_common.php';
require_once __DIR__ . '/../drugs_common.php';

$checks = 0;
function catalogueSearchTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function catalogueNamedPlaceholders(string $sql): array
{
    preg_match_all('/(?<!:):([a-zA-Z_][a-zA-Z_0-9]*)/', $sql, $matches);
    return $matches[1];
}

function catalogueRejectDuplicatePlaceholders(string $sql): void
{
    $names = catalogueNamedPlaceholders($sql);
    if ($names !== [] && count($names) !== count(array_unique($names))) {
        throw new PDOException('SQLSTATE[HY093]: duplicate named parameter');
    }
}

/** Natívny PDO MySQL odmieta opakované pomenované parametre; SQLite ich povoľuje. */
class NativeCatalogueTestPdo extends PDO
{
    public array $statements = [];

    public function __construct()
    {
    }

    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        catalogueRejectDuplicatePlaceholders($query);
        $statement = new NativeCatalogueTestStatement($query);
        $this->statements[] = $statement;
        return $statement;
    }
}

class NativeCatalogueTestStatement extends PDOStatement
{
    public array $values = [];

    public function __construct(public string $sql)
    {
    }

    public function execute(?array $params = null): bool
    {
        $values = $params ?? $this->values;
        foreach (catalogueNamedPlaceholders($this->sql) as $name) {
            if (!array_key_exists($name, $values)) {
                throw new PDOException('Unbound parameter');
            }
        }
        return true;
    }

    public function fetchAll(int $mode = PDO::FETCH_DEFAULT, mixed ...$args): array
    {
        return [['nct_id' => 'NCT00000000', 'slug' => 'furosemid']];
    }
}

$pdo = new NativeCatalogueTestPdo();
$trials = ctFetchTrials($pdo, '', 'CKD');
catalogueSearchTest($trials !== [], 'Vyhľadávanie štúdií nesmie padnúť na duplicitný placeholder.');
$trialSql = $pdo->statements[array_key_last($pdo->statements)]->sql;
catalogueSearchTest(
    str_contains($trialSql, ':q_title') && str_contains($trialSql, ':q_conditions') && str_contains($trialSql, ':q_sponsor'),
    'Štúdie viažu každé LIKE pole vlastným placeholderom.'
);

$drugs = dgFetchDrugs($pdo, '', 'furosemid');
catalogueSearchTest($drugs !== [], 'Vyhľadávanie liekov nesmie padnúť na duplicitný placeholder.');
$drugSql = $pdo->statements[array_key_last($pdo->statements)]->sql;
catalogueSearchTest(
    str_contains($drugSql, ':q_name_sk') && str_contains($drugSql, ':q_atc'),
    'Lieky viažu každé LIKE pole vlastným placeholderom.'
);

$sqlite = new PDO('sqlite::memory:');
$sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sqlite->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$sqlite->exec('CREATE TABLE clinical_trials (
    id INTEGER PRIMARY KEY, nct_id TEXT, brief_title TEXT, overall_status TEXT, phase TEXT,
    study_type TEXT, conditions TEXT, lead_sponsor TEXT, enrollment INTEGER,
    last_update_posted TEXT, countries TEXT, category TEXT, sk_note TEXT, is_published INTEGER
)');
$sqlite->exec("INSERT INTO clinical_trials VALUES (1,'NCT11111111','CKD outcome study','Recruiting','Phase 3','Interventional','Chronic Kidney Disease','Synthetic Sponsor',10,'2026-01-01','Slovakia','ckd','',1)");
$foundTrials = ctFetchTrials($sqlite, '', 'CKD');
catalogueSearchTest(count($foundTrials) === 1 && $foundTrials[0]['nct_id'] === 'NCT11111111', 'Textové hľadanie štúdií vráti zhodu.');

$sqlite->exec('CREATE TABLE drugs (
    id INTEGER PRIMARY KEY, slug TEXT, name_sk TEXT, name_intl TEXT, drug_class TEXT, atc_code TEXT,
    category TEXT, max_phase TEXT, black_box_warning INTEGER, withdrawn INTEGER,
    renal_dosing TEXT, sk_note TEXT, is_published INTEGER
)');
$sqlite->exec("INSERT INTO drugs VALUES (1,'furosemid','Furosemid','Furosemide','loop diuretic','C03CA01','diuretic','4',0,0,'','',1)");
$foundDrugs = dgFetchDrugs($sqlite, '', 'furosemid');
catalogueSearchTest(count($foundDrugs) === 1 && $foundDrugs[0]['slug'] === 'furosemid', 'Textové hľadanie liekov vráti zhodu.');

foreach ([
    __DIR__ . '/../admin_drugs.php',
    __DIR__ . '/../admin_trials.php',
    __DIR__ . '/../admin_providers.php',
    __DIR__ . '/../clinical_trials_common.php',
    __DIR__ . '/../drugs_common.php',
] as $file) {
    $source = (string) file_get_contents($file);
    preg_match_all("/'([^']*:q[^']*)'/", $source, $quoted);
    foreach ($quoted[1] as $sql) {
        if (!str_contains($sql, 'LIKE')) {
            continue;
        }
        $names = catalogueNamedPlaceholders($sql);
        catalogueSearchTest(
            $names === [] || count($names) === count(array_unique($names)),
            basename($file) . ' nesmie opakovať pomenovaný placeholder v LIKE.'
        );
    }
}

echo "Catalogue search: $checks PASS\n";
