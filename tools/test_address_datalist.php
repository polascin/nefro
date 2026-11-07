<?php

declare(strict_types=1);

/**
 * Datalisty adresy (obce, PSČ, okresy, kraje, krajiny) sa vykresľujú kompaktne:
 * jedna položka na riadok bez odsadenia šablóny (Beh 183: register.php mal
 * 1,5 MB HTML, väčšinu tvorili medzery v 4 158 položkách obcí).
 *
 * Bez DB: funkcie sa vyberú z db_config.php a spustia so stubom názvu kraja.
 */

$checks = 0;
function addressDatalistTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$root = dirname(__DIR__);
$source = (string) file_get_contents($root . '/db_config.php');

/** Vráti zdrojový kód jednej top-level funkcie z db_config.php. */
function addressExtractFunction(string $source, string $name): string
{
    $start = strpos($source, 'function ' . $name . '(');
    if ($start === false) {
        throw new RuntimeException("Funkcia {$name} v db_config.php chýba.");
    }
    $open = strpos($source, '{', $start);
    $depth = 0;
    $length = strlen($source);
    for ($i = (int) $open; $i < $length; $i++) {
        if ($source[$i] === '{') {
            ++$depth;
        } elseif ($source[$i] === '}') {
            --$depth;
            if ($depth === 0) {
                return substr($source, $start, $i - $start + 1);
            }
        }
    }
    throw new RuntimeException("Koniec funkcie {$name} sa nenašiel.");
}

if (!function_exists('getRegionNameByCode')) {
    function getRegionNameByCode(\PDO $pdo, string $code): string
    {
        return ['BL' => 'Bratislavský kraj', 'BC' => 'Banskobystrický kraj'][$code] ?? $code;
    }
}
// eval len nad zdrojom vlastného db_config.php z repozitára (nie nad vstupom);
// include db_config.php by otvoril spojenie s DB. tools/ sa nenasadzuje.
foreach (['addressMunicipalityDatalistOptions', 'addressDatalistOptions'] as $fn) {
    if (!function_exists($fn)) {
        eval(addressExtractFunction($source, $fn));
    }
}

$pdo = new PDO('sqlite::memory:');
$municipalities = [
    ['name' => 'Ábelová', 'zip_code' => '98513', 'district_name' => 'Lučenec', 'region_code' => 'BC'],
    ['name' => 'Bratislava "Staré" <Mesto>', 'zip_code' => '81101', 'district_name' => 'Bratislava I', 'region_code' => 'BL'],
];
$html = addressMunicipalityDatalistOptions($pdo, $municipalities);
$lines = explode("\n", $html);
addressDatalistTest(count($lines) === 2, 'Jedna obec na riadok.');
addressDatalistTest(
    $lines[0] === '<option value="Ábelová" data-zip="98513" data-district="Lučenec" data-region="Banskobystrický kraj">',
    'Atribúty obce pre address-autofill.js (data-zip, data-district, data-region).',
);
addressDatalistTest(
    str_contains($lines[1], 'value="Bratislava &quot;Staré&quot; &lt;Mesto&gt;"') && str_contains($lines[1], 'data-region="Bratislavský kraj"'),
    'Hodnoty sú escapované (úvodzovky a < >).',
);
addressDatalistTest(!str_contains($html, '  '), 'Bez odsadenia šablóny.');

$simple = addressDatalistOptions(['81101', '98513', "O'Brien"]);
addressDatalistTest($simple === "<option value=\"81101\">\n<option value=\"98513\">\n<option value=\"O&#039;Brien\">", 'Jednoduchý datalist: jedna hodnota na riadok, escapovaný apostrof.');
addressDatalistTest(addressDatalistOptions([]) === '', 'Prázdny zoznam = prázdny reťazec.');

// Šablóny používajú pomocné funkcie (žiadny odsadený foreach s <option>)
foreach (['register.php', 'profile_form_address.php'] as $page) {
    $src = (string) file_get_contents($root . '/' . $page);
    addressDatalistTest(str_contains($src, 'addressMunicipalityDatalistOptions($pdo, $addrMunicipalities)'), "{$page} vykresľuje obce kompaktne.");
    addressDatalistTest(substr_count($src, 'addressDatalistOptions($addr') === 4, "{$page} vykresľuje PSČ, okresy, kraje a krajiny kompaktne.");
    addressDatalistTest(!str_contains($src, 'foreach ($addrMunicipalities as'), "{$page} nemá odsadený foreach obcí.");
}

$js = (string) file_get_contents($root . '/address-autofill.js');
addressDatalistTest(
    str_contains($js, 'opt.dataset.zip') && str_contains($js, 'opt.dataset.district') && str_contains($js, 'opt.dataset.region'),
    'address-autofill.js číta rovnaké atribúty.',
);

echo "Address datalist: $checks PASS\n";
