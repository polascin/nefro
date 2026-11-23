<?php

declare(strict_types=1);

/**
 * Laboratórne výsledky pre Ambulantnú kalkulačku: rozbor textu z Nefrisu (MS-DOS)
 * alebo textu výsledkového listu Synlab (PDF z elab.synlab.sk, text z neho vyberá
 * prehliadač cez pdf.js, calculator_ambulatory.js) a zostavenie bloku
 * „Laboratórne a pomocné vyšetrenia“ podľa pevnej šablóny.
 *
 * Parser rozpozná riadky typu „názov hodnota príznak (referenčné rozpätie) jednotka“,
 * dátumy odberov, stĺpcové kumulatívne výpisy (hlavička s viacerými dátumami)
 * aj dva parametre v jednom riadku. Nič sa neukladá ani nezapisuje do logu.
 */

require_once __DIR__ . '/calculators_common.php';
require_once __DIR__ . '/calculator_ambulatory_logic.php';

const LABS_MAX_INPUT_CHARS = 100000;
const LABS_MAX_LINES = 3000;
// Rozbor jedného riadku rastie s jeho dĺžkou rýchlejšie než lineárne; výpis z Nefrisu
// má najviac 132 znakov, súvislý text v správe niekoľko stoviek.
const LABS_MAX_LINE_CHARS = 4000;
const LABS_MAX_UNPARSED = 30;

/**
 * Katalóg rozpoznávaných parametrov. Aliasy sú v zloženom tvare (labsFoldKey);
 * predpona "u " = vzorka moču, "us " = moč vyšetrený prúžkom.
 *
 * @return array<string, array{label: string, default: bool, aliases: list<string>}>
 */
function labsCatalogue(): array
{
    static $catalogue = [
        'urea' => ['label' => 'Urea', 'default' => true, 'aliases' => ['urea', 'mocovina', 'bun']],
        'krea' => ['label' => 'Kreatinín', 'default' => true, 'aliases' => ['kreatinin', 'kreat', 'krea', 'kreatinin enzymaticky', 'kreatinin jaffe', 'creatinine', 'crea', 'kreatinin idms']],
        'egfr' => ['label' => 'eGFR', 'default' => true, 'aliases' => ['egfr', 'gfr', 'egfr ckd epi', 'ckd epi', 'egfr ckd epi 2021', 'egfr mdrd', 'egfr ckdepi', 'odhad gfr', 'egf', 'egf ckd epi', 'egfr ckd epi 2009', 'egfr kreatinin', 'egfr krea']],
        'egfrcys' => ['label' => 'eGFR (cystatín C)', 'default' => false, 'aliases' => ['egfr cys', 'egfr cys c', 'egfr cystatin', 'egfr cystatin c', 'egfr ckd epi cys', 'egfr ckd epi cystatin c', 'egf cystatin c', 'egfr cystatin c ckd epi']],
        'cysc' => ['label' => 'Cystatín C', 'default' => false, 'aliases' => ['cystatin c', 'cystatin', 'cys c', 'cysc']],
        'kmc' => ['label' => 'Kys. močová', 'default' => true, 'aliases' => ['kyselina mocova', 'kys mocova', 'k mocova', 'kmc', 'km', 'uric acid', 'ua', 'urat', 'uraty']],
        'na' => ['label' => 'Na', 'default' => true, 'aliases' => ['na', 'natrium', 'sodik', 'sodium']],
        'k' => ['label' => 'K', 'default' => true, 'aliases' => ['k', 'kalium', 'draslik', 'potassium']],
        'cl' => ['label' => 'Cl', 'default' => true, 'aliases' => ['cl', 'chloridy', 'chlorid', 'chloride']],
        'ca' => ['label' => 'Ca', 'default' => true, 'aliases' => ['ca', 'kalcium', 'vapnik', 'ca celk', 'ca celkove', 'ca celkovy', 'kalcium celkove', 'calcium']],
        'cai' => ['label' => 'Ca2+', 'default' => false, 'aliases' => ['ca2', 'ca ion', 'ca ionizovane', 'ca ionizovany', 'ionizovane ca', 'ionizovany vapnik', 'ica', 'ca2 ionizovane', 'vapnik ionizovany', 'ionizovany ca']],
        'cacorr' => ['label' => 'Korigovaný Ca', 'default' => false, 'aliases' => ['vapnik korig albumin', 'vapnik korig', 'vapnik korigovany', 'korigovany vapnik', 'ca korig', 'ca korig albumin', 'ca korigovany', 'korigovany ca', 'korigovane ca', 'ca kor']],
        'p' => ['label' => 'P', 'default' => true, 'aliases' => ['p', 'p anorg', 'p anorganicky', 'fosfor', 'fosfaty', 'fosfat', 'anorg fosfor', 'anorganicky fosfor', 'fosfor anorganicky', 'phos', 'po4']],
        'mg' => ['label' => 'Mg', 'default' => true, 'aliases' => ['mg', 'magnezium', 'horcik', 'magnesium']],
        'ph' => ['label' => 'pH', 'default' => false, 'aliases' => ['ph']],
        'hco3' => ['label' => 'HCO3', 'default' => true, 'aliases' => ['hco3', 'hco3 std', 'std hco3', 'shco3', 'bikarbonat', 'bikarbonaty', 'hydrogenuhlicitan', 'hydrogenuhlicitany', 'aktualny hco3', 'ahco3']],
        'be' => ['label' => 'BE', 'default' => false, 'aliases' => ['be', 'abe', 'sbe', 'beecf', 'be ecf', 'base excess']],
        'pco2' => ['label' => 'pCO2', 'default' => false, 'aliases' => ['pco2']],
        'alb' => ['label' => 'Albumín', 'default' => true, 'aliases' => ['alb', 'albumin', 'albumin v sere']],
        'cb' => ['label' => 'Celk. bielkoviny', 'default' => false, 'aliases' => ['cb', 'celkova bielkovina', 'celkove bielkoviny', 'bielkovina celkova', 'bielkoviny celkove', 'celk bielkoviny', 'celk bielkovina', 'tp', 'total protein']],
        'glu' => ['label' => 'Glukóza', 'default' => true, 'aliases' => ['glu', 'glukoza', 'glykemia', 'glc', 'glukoza nalacno', 'glykemia nalacno', 'glucose']],
        'hba1c' => ['label' => 'HbA1c', 'default' => true, 'aliases' => ['hba1c', 'hb a1c', 'glykovany hemoglobin', 'glykozylovany hemoglobin', 'hba1c ifcc', 'hba1c dcct', 'hba1c ngsp']],
        'chol' => ['label' => 'Cholesterol', 'default' => true, 'aliases' => ['chol', 'cholesterol', 'celk cholesterol', 'cholesterol celkovy', 'celkovy cholesterol', 'tc']],
        'ldl' => ['label' => 'LDL-C', 'default' => true, 'aliases' => ['ldl', 'ldl c', 'ldl chol', 'ldl cholesterol', 'cholesterol ldl']],
        'hdl' => ['label' => 'HDL-C', 'default' => true, 'aliases' => ['hdl', 'hdl c', 'hdl chol', 'hdl cholesterol', 'cholesterol hdl']],
        'tag' => ['label' => 'TAG', 'default' => true, 'aliases' => ['tag', 'triacylglyceroly', 'triglyceridy', 'tg', 'triacylglyceridy']],
        'crp' => ['label' => 'CRP', 'default' => true, 'aliases' => ['crp', 'c reaktivny protein', 'hs crp', 'hscrp']],
        'ast' => ['label' => 'AST', 'default' => false, 'aliases' => ['ast', 'got']],
        'alt' => ['label' => 'ALT', 'default' => false, 'aliases' => ['alt', 'gpt']],
        'ggt' => ['label' => 'GMT', 'default' => false, 'aliases' => ['ggt', 'gmt', 'ggt gmt']],
        'alp' => ['label' => 'ALP', 'default' => true, 'aliases' => ['alp', 'alkp', 'alkalicka fosfataza', 'alk fosfataza', 'af']],
        'bili' => ['label' => 'Bilirubín', 'default' => false, 'aliases' => ['bili', 'bilirubin', 'bilirubin celkovy', 'celkovy bilirubin', 'bil']],
        'pth' => ['label' => 'PTH', 'default' => true, 'aliases' => ['pth', 'ipth', 'parathormon', 'intaktny pth', 'intakt pth', 'pth intaktny', 'i pth', 'parathormon intakt', 'parathormon intaktny', 'pth intakt']],
        'vitd' => ['label' => '25-OH vit. D', 'default' => true, 'aliases' => ['25 oh vit d', '25 oh vitamin d', '25ohd', '25 oh d', '25 ohd', 'vit d', 'vitamin d', 'kalcidiol', 'vit d3', 'vitamin d 25 oh', '25 hydroxyvitamin d', 'vitamin d celk', 'vit d celk', 'vitamin d celkovy', '25 oh vit d celk']],
        'fe' => ['label' => 'Fe', 'default' => false, 'aliases' => ['fe', 'zelezo', 'iron']],
        'tibc' => ['label' => 'TIBC', 'default' => false, 'aliases' => ['tibc', 'celkova vazobna kapacita', 'cvk', 'cvk fe', 'vazobna kapacita fe', 'tvk']],
        'ferr' => ['label' => 'Feritín', 'default' => true, 'aliases' => ['feritin', 'ferritin', 'ferr']],
        'tsat' => ['label' => 'TSAT', 'default' => true, 'aliases' => ['tsat', 'saturacia transferinu', 'sat transferinu', 'sat transf', 'saturacia transf', 'sat tf', 'saturacia']],
        'trf' => ['label' => 'Transferín', 'default' => false, 'aliases' => ['transferin', 'trf', 'tf']],
        'hb' => ['label' => 'Hb', 'default' => true, 'aliases' => ['hb', 'hgb', 'hemoglobin']],
        'hct' => ['label' => 'Hct', 'default' => false, 'aliases' => ['hct', 'htk', 'hematokrit']],
        'ery' => ['label' => 'Ery', 'default' => false, 'aliases' => ['ery', 'erytrocyty', 'rbc']],
        'mcv' => ['label' => 'MCV', 'default' => false, 'aliases' => ['mcv']],
        'mch' => ['label' => 'MCH', 'default' => false, 'aliases' => ['mch']],
        'mchc' => ['label' => 'MCHC', 'default' => false, 'aliases' => ['mchc']],
        'leu' => ['label' => 'Leu', 'default' => true, 'aliases' => ['leu', 'leukocyty', 'wbc']],
        'neu' => ['label' => 'neutrofily', 'default' => false, 'aliases' => ['neutrofily', 'neu', 'neut', 'gra', 'granulocyty', 'neutrofily segmentovane', 'segmenty']],
        'lym' => ['label' => 'lymfocyty', 'default' => false, 'aliases' => ['lymfocyty', 'lym', 'ly', 'lymph']],
        'mono' => ['label' => 'monocyty', 'default' => false, 'aliases' => ['monocyty', 'mono', 'mo']],
        'eos' => ['label' => 'eozinofily', 'default' => false, 'aliases' => ['eozinofily', 'eo', 'eos']],
        'baso' => ['label' => 'bazofily', 'default' => false, 'aliases' => ['bazofily', 'baso', 'ba']],
        'tro' => ['label' => 'Tro', 'default' => true, 'aliases' => ['tro', 'trom', 'trombocyty', 'plt']],
        'bmi' => ['label' => 'BMI', 'default' => false, 'aliases' => ['bmi', 'body mass index', 'index telesnej hmotnosti']],
        'inr' => ['label' => 'INR', 'default' => false, 'aliases' => ['inr', 'pt inr', 'quick inr']],
        'ntprobnp' => ['label' => 'NT-proBNP', 'default' => false, 'aliases' => ['nt probnp', 'ntprobnp', 'nt pro bnp']],
        'b2m' => ['label' => 'Beta2-mikroglobulín', 'default' => false, 'aliases' => ['b2 mikroglobulin', 'beta2 mikroglobulin', 'beta 2 mikroglobulin', 'b2m']],
        'uacr' => ['label' => 'ACR', 'default' => true, 'aliases' => ['acr', 'uacr', 'albumin kreatinin', 'alb kreat', 'alb krea', 'albumin kreatinin pomer', 'pomer albumin kreatinin', 'u acr', 'u alb kreat', 'u alb krea', 'u albumin kreatinin', 'u acr pomer', 'albumin u kreat', 'albumin u krea', 'malb kreat', 'mikroalbumin kreatinin']],
        'upcr' => ['label' => 'PCR', 'default' => true, 'aliases' => ['upcr', 'prot kreat', 'prot krea', 'bielk kreat', 'bielk krea', 'u pcr', 'u upcr', 'u prot kreat', 'u prot krea', 'u bielk kreat', 'u bielk krea', 'u bielkovina kreatinin', 'cb u kreat', 'cb u krea', 'cb kreat']],
        'uph' => ['label' => 'pH', 'default' => false, 'aliases' => ['u ph', 'us ph']],
        'usg' => ['label' => 'hustota', 'default' => false, 'aliases' => ['u hustota', 'us hustota', 'u specificka hmotnost', 'us specificka hmotnost', 'u sg', 'us sg']],
        'usprot' => ['label' => 'bielkovina', 'default' => false, 'aliases' => ['us proteiny', 'us bielkovina', 'us bielkoviny', 'us protein', 'us prot', 'u proteiny', 'u protein']],
        'uglu' => ['label' => 'glukóza', 'default' => false, 'aliases' => ['u glukoza', 'us glukoza', 'u glu', 'us glu']],
        'uket' => ['label' => 'ketóny', 'default' => false, 'aliases' => ['u ketony', 'us ketony', 'u ket', 'us ket', 'u ketolatky', 'us ketolatky']],
        'ubld' => ['label' => 'krv', 'default' => false, 'aliases' => ['u krv', 'us krv', 'us hemoglobin', 'u hemoglobin', 'us ery', 'us erytrocyty', 'us hb']],
        'ubil' => ['label' => 'bilirubín', 'default' => false, 'aliases' => ['u bilirubin', 'us bilirubin', 'u bilirub', 'us bilirub', 'u bil', 'us bil']],
        'uubg' => ['label' => 'urobilinogén', 'default' => false, 'aliases' => ['u urobilinogen', 'us urobilinogen', 'u ubg', 'us ubg']],
        'unitr' => ['label' => 'nitrity', 'default' => false, 'aliases' => ['u nitrity', 'us nitrity', 'u nit', 'us nit']],
        'uleus' => ['label' => 'leukocyty', 'default' => false, 'aliases' => ['us leuko', 'us leukocyty', 'us leu', 'u leuko']],
        'sedery' => ['label' => 'erytrocyty', 'default' => false, 'aliases' => ['u erytrocyty', 'u ery', 'sed ery', 'sediment ery', 'sediment erytrocyty']],
        'sedleu' => ['label' => 'leukocyty', 'default' => false, 'aliases' => ['u leukocyty', 'u leu', 'sed leu', 'sediment leu', 'sediment leukocyty']],
        'ualb' => ['label' => 'U-albumín', 'default' => false, 'aliases' => ['u alb', 'u albumin', 'malb', 'mikroalbumin', 'u mikroalbumin']],
        'uprot' => ['label' => 'Proteinúria', 'default' => false, 'aliases' => ['u cb', 'u bielkovina', 'u bielkoviny', 'u celkova bielkovina', 'u prot', 'proteinuria', 'u proteinuria']],
        'ukrea' => ['label' => 'U-kreatinín', 'default' => false, 'aliases' => ['u kreatinin', 'u kreat', 'u krea']],
    ];

    return $catalogue;
}

/**
 * Zložený kľúč názvu: malé písmená bez diakritiky, oddeľovače na jednu medzeru.
 */
function labsFoldKey(string $name): string
{
    static $map = [
        'á' => 'a', 'ä' => 'a', 'č' => 'c', 'ď' => 'd', 'é' => 'e', 'ě' => 'e', 'í' => 'i', 'ĺ' => 'l',
        'ľ' => 'l', 'ň' => 'n', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o', 'ŕ' => 'r', 'ř' => 'r', 'š' => 's',
        'ť' => 't', 'ú' => 'u', 'ů' => 'u', 'ü' => 'u', 'ý' => 'y', 'ž' => 'z', 'µ' => 'u', 'β' => 'b',
        // Diferenciál z analyzátora: NEUT% (podiel) a NEUT# (absolútny počet) sa líšia.
        '%' => ' pct ', '#' => ' abs ',
    ];
    $key = strtr(mb_strtolower($name, 'UTF-8'), $map);
    $key = (string) preg_replace('/[^a-z0-9]+/', ' ', $key);

    return trim($key);
}

/**
 * @return array<string, string> zložený alias => kód
 */
function labsAliasIndex(): array
{
    static $index = null;
    if ($index === null) {
        $index = [];
        foreach (labsCatalogue() as $code => $entry) {
            foreach ($entry['aliases'] as $alias) {
                $index[$alias] ??= $code;
            }
        }
    }

    return $index;
}

/**
 * Prevedie názov z výpisu na kód katalógu; predpona alebo prípona vzorky
 * (S-, S_, P-, B-, sérum / U-, U_, dU-, moč, prúžkom) a kód analyzátora
 * na konci (B_Leukocyty WBC, B_Neutrofily NEUT%) sa zohľadnia.
 * Absolútny počet z diferenciálu (NEUT#) ani neznámy názov sa nepriradí (null).
 */
function labsResolveName(string $name): ?string
{
    $key = labsFoldKey($name);
    if ($key === '') {
        return null;
    }
    $index = labsAliasIndex();
    if (isset($index[$key])) {
        return $index[$key];
    }

    $words = explode(' ', $key);
    if (in_array('abs', $words, true)) {
        return null;
    }
    if (count($words) > 1 && end($words) === 'pct') {
        array_pop($words);
    }
    $urine = false;
    $strip = false;
    $bloodPrefixes = ['s', 'p', 'b', 'se', 'ser', 'sp', 'serum', 'plazma', 'krv'];
    $urinePrefixes = ['u', 'du', 'mu', 'moc'];
    if (count($words) > 1 && in_array($words[0], $urinePrefixes, true)) {
        $urine = true;
        array_shift($words);
    } elseif (count($words) > 1 && in_array($words[0], $bloodPrefixes, true)) {
        array_shift($words);
    }

    $bloodSuffixes = [['v', 'sere'], ['v', 'plazme'], ['v', 'krvi'], ['s'], ['p'], ['b'], ['serum'], ['plazma']];
    $urineSuffixes = [['v', 'moci'], ['moc'], ['u'], ['du']];
    $stripSuffixes = [['pruzkom'], ['prouzkem'], ['papierikom'], ['chemicky']];
    foreach ([[$stripSuffixes, true, true], [$urineSuffixes, true, false], [$bloodSuffixes, false, false]] as [$suffixes, $isUrine, $isStrip]) {
        foreach ($suffixes as $suffix) {
            $length = count($suffix);
            if (count($words) > $length && array_slice($words, -$length) === $suffix) {
                $words = array_slice($words, 0, -$length);
                $urine = $urine || $isUrine;
                $strip = $isStrip;
                break 2;
            }
        }
    }

    // Kód analyzátora za slovenským názvom: najprv sa skúsi názov, potom samotný kód.
    $analyzerCode = null;
    $analyzerCodes = ['wbc', 'rbc', 'hgb', 'hct', 'mcv', 'mch', 'mchc', 'rdw', 'plt', 'mpv', 'pdw', 'neut', 'lymph', 'mono', 'eo', 'baso'];
    if (count($words) > 1 && in_array(end($words), $analyzerCodes, true)) {
        $analyzerCode = array_pop($words);
    }

    $base = implode(' ', $words);
    if ($urine) {
        $candidates = $strip ? ['us ' . $base, 'u ' . $base] : ['u ' . $base, 'us ' . $base];
        foreach ($candidates as $candidate) {
            if (isset($index[$candidate])) {
                return $index[$candidate];
            }
        }

        return in_array($index[$base] ?? '', ['uacr', 'upcr'], true) ? $index[$base] : null;
    }

    return $index[$base] ?? ($analyzerCode !== null ? ($index[$analyzerCode] ?? null) : null);
}

/**
 * Kódovania, v ktorých sa text z MS-DOS (CP852) cestou do schránky zvykne
 * nesprávne prečítať, napríklad keď Poznámkový blok otvorí súbor z Nefrisu
 * ako Windows-1250 („Kreatinˇn“ namiesto „Kreatinín“).
 *
 * @return array<string, array{iconv: string, label: string}>
 */
function labsMisreadEncodings(): array
{
    return [
        'cp1250' => ['iconv' => 'CP1250', 'label' => 'Windows-1250'],
        'iso-8859-2' => ['iconv' => 'ISO-8859-2', 'label' => 'ISO-8859-2'],
        'cp1252' => ['iconv' => 'CP1252', 'label' => 'Windows-1252'],
        'iso-8859-1' => ['iconv' => 'ISO-8859-1', 'label' => 'ISO-8859-1'],
        'cp437' => ['iconv' => 'CP437', 'label' => 'CP437 (DOS, US)'],
        'cp850' => ['iconv' => 'CP850', 'label' => 'CP850 (DOS, západná Európa)'],
    ];
}

/**
 * Skóre „slovenskosti“ textu: slovenské písmená plus, iné znaky mimo ASCII
 * a veľké písmeno uprostred slova (KreatinÝn) mínus. Rámčeky DOS sú neutrálne.
 */
function labsTextScore(string $text): int
{
    static $slovak = 'áäčďéíĺľňóôŕšťúýžÁÄČĎÉÍĹĽŇÓÔŔŠŤÚÝŽ';
    $score = 0;
    if (preg_match_all('/[^\x00-\x7F]/u', $text, $matches) > 0) {
        foreach ($matches[0] as $char) {
            if (mb_strpos($slovak, $char, 0, 'UTF-8') !== false) {
                $score += 2;
            } elseif (preg_match('/^[\x{2500}-\x{259F}°µ]$/u', $char) !== 1) {
                $score -= 3;
            }
        }
    }

    return $score - 4 * (int) preg_match_all('/\p{Ll}[ÁÄČĎÉÍĹĽŇÓÔŔŠŤÚÝŽ]\p{Ll}/u', $text);
}

/**
 * Text prečítaný v kódovaní $iconv vráti na pôvodné bajty a dekóduje ako CP852.
 * Znak, ktorý sa v $iconv nedá zapísať, nahradí otáznikom.
 */
function labsReinterpretAsCp852(string $text, string $iconv): ?string
{
    if (!function_exists('iconv')) {
        return null;
    }
    $bytes = '';
    foreach (preg_split('/([^\x00-\x7F])/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY) ?: [] as $piece) {
        if (preg_match('/^[\x00-\x7F]+$/', $piece) === 1) {
            $bytes .= $piece;
            continue;
        }
        $byte = @iconv('UTF-8', $iconv, $piece);
        $bytes .= is_string($byte) && strlen($byte) === 1 ? $byte : '?';
    }
    $decoded = @iconv('CP852', 'UTF-8', $bytes);

    return is_string($decoded) ? $decoded : null;
}

/**
 * Opraví text z MS-DOS (CP852), ktorý sa pred vložením do okna prečítal
 * v inom kódovaní. Režim 'auto' vyberie kódovanie s najlepším skóre a text
 * zmení len vtedy, keď je výsledok zreteľne lepší; 'none' text nechá tak.
 *
 * @return array{text: string, from: ?string}
 */
function labsRepairDosText(string $text, string $mode = 'auto'): array
{
    $encodings = labsMisreadEncodings();
    if ($mode === 'none' || preg_match('/[^\x00-\x7F]/', $text) !== 1) {
        return ['text' => $text, 'from' => null];
    }
    if (isset($encodings[$mode])) {
        $repaired = labsReinterpretAsCp852($text, $encodings[$mode]['iconv']);

        return $repaired === null ? ['text' => $text, 'from' => null] : ['text' => $repaired, 'from' => $mode];
    }

    $bestScore = labsTextScore($text);
    $best = ['text' => $text, 'from' => null];
    foreach ($encodings as $key => $encoding) {
        $repaired = labsReinterpretAsCp852($text, $encoding['iconv']);
        if ($repaired === null) {
            continue;
        }
        $score = labsTextScore($repaired);
        if ($score > $bestScore + 1) {
            $bestScore = $score;
            $best = ['text' => $repaired, 'from' => $key];
        }
    }

    return $best;
}

/**
 * Normalizuje vložený text: konce riadkov, tabulátory na 8-stĺpcové zarážky,
 * rámčekové znaky DOS na medzery, odstráni riadiace znaky.
 */
function labsNormalizeInput(string $text): string
{
    if (str_starts_with($text, "\u{FEFF}")) {
        $text = substr($text, 3);
    }
    $text = str_replace(["\r\n", "\r", "\f"], "\n", $text);
    $text = strtr($text, ["\u{00A0}" => ' ', "\u{00AD}" => '', "\u{2212}" => '-', "\u{2013}" => '-', "\u{2014}" => '-', '¦' => ' ']);
    $text = (string) preg_replace('/[\x{2500}-\x{259F}]/u', ' ', $text);
    $text = (string) preg_replace('/[\x00-\x08\x0B-\x1F\x7F]/u', '', $text);
    // Značka akreditovanej metódy vo výsledkovom liste Synlab („S_Kreatinín (A) 95“).
    $text = (string) preg_replace('/(?<=\s)\(A\)(?=\s)/u', '   ', $text);

    $lines = [];
    foreach (explode("\n", $text) as $line) {
        if (str_contains($line, "\t")) {
            $expanded = '';
            foreach (mb_str_split($line, 1, 'UTF-8') as $char) {
                $expanded .= $char === "\t"
                    ? str_repeat(' ', 8 - (mb_strlen($expanded, 'UTF-8') % 8))
                    : $char;
            }
            $line = $expanded;
        }
        $lines[] = rtrim($line);
    }

    return implode("\n", $lines);
}

/**
 * Nájde dátumy odberu v riadku (dd.mm.rrrr, dd.mm.rr, rrrr-mm-dd).
 *
 * @return list<array{date: string, start: int, length: int}> start/length v znakoch
 */
function labsFindDates(string $line): array
{
    $found = [];
    $patterns = [
        '/(?<![\d.,])(\d{1,2})\.\s?(\d{1,2})\.\s?(\d{4}|\d{2})(?![\d,]|\.\d)/u' => 'dmy',
        '/(?<![\d.,-])(\d{4})-(\d{2})-(\d{2})(?![\d])/u' => 'ymd',
    ];
    $maxYear = (int) date('Y') + 1;
    foreach ($patterns as $pattern => $order) {
        if (preg_match_all($pattern, $line, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE) === false) {
            continue;
        }
        foreach ($matches as $match) {
            if ($order === 'dmy') {
                [$day, $month, $year] = [(int) $match[1][0], (int) $match[2][0], $match[3][0]];
                $year = strlen($year) === 2 ? 2000 + (int) $year : (int) $year;
                if ($year > $maxYear) {
                    $year -= 100;
                }
            } else {
                [$year, $month, $day] = [(int) $match[1][0], (int) $match[2][0], (int) $match[3][0]];
            }
            if ($year < 1980 || $year > $maxYear || !checkdate($month, $day, $year)) {
                continue;
            }
            $found[] = [
                'date' => sprintf('%04d-%02d-%02d', $year, $month, $day),
                'start' => mb_strlen(substr($line, 0, $match[0][1]), 'UTF-8'),
                'length' => mb_strlen($match[0][0], 'UTF-8'),
            ];
        }
    }
    usort($found, static fn (array $a, array $b): int => $a['start'] <=> $b['start']);

    return $found;
}

/**
 * Úprava riadka vo formáte výsledkového listu Synlab, kde príznak stojí medzi
 * hodnotou a rozpätím a neuzavreté rozpätie nemá zátvorky:
 * „2,03 - 2,10 - 2,55“ → „2,03 L 2,10 - 2,55“, „13 + 0 - 10“ → „13 H 0 - 10“,
 * „1,09 < 5,00“ → „1,09 (<5,00)“ a „< 0,068“ za názvom → „<0,068“ (hodnota).
 */
function labsMarkInlineFlags(string $line): string
{
    $number = '\d+(?:[.,]\d+)?';
    $line = (string) preg_replace('/(?<=\d)\s+\+\s+(?=(?:<=|>=|<|>|≤|≥)?\s*\d)/u', ' H ', $line);
    $line = (string) preg_replace('/(?<=\d)\s+-\s+(?=(?:<=|>=|<|>|≤|≥)\s*\d|' . $number . '\s*-\s*\d)/u', ' L ', $line);
    $line = (string) preg_replace('/(?<=\d|\s[HL])\s+(<=|>=|<|>|≤|≥)\s*(' . $number . ')(?![\d.,])/u', ' ($1$2)', $line);

    return (string) preg_replace('/(^|\s)(<=|>=|<|>|≤|≥)\s+(?=\d)/u', '$1$2', $line);
}

/** Nahradí úsek riadku (v znakoch) medzerami, aby ostali zachované stĺpce. */
function labsBlankSpan(string $line, int $start, int $length): string
{
    return mb_substr($line, 0, $start, 'UTF-8') . str_repeat(' ', $length) . mb_substr($line, $start + $length, null, 'UTF-8');
}

/**
 * @return array{value: string, num: ?float, flag: string}|null
 */
function labsParseValueToken(string $token): ?array
{
    if (preg_match('/^(<=|>=|<|>|≤|≥)?([+-]?\d+(?:[.,]\d+)?)(\*|!|HH|LL|H|L|↑|↓)?$/u', $token, $match) === 1) {
        $comparator = strtr($match[1], ['≤' => '<=', '≥' => '>=']);
        $number = str_replace('.', ',', $match[2]);

        return [
            'value' => $comparator . $number,
            'num' => $comparator === '' ? (float) str_replace(',', '.', $match[2]) : null,
            'flag' => labsNormalizeFlag($match[3] ?? ''),
        ];
    }
    $qualitative = labsFoldKey($token);
    if (
        preg_match('/^\+{1,4}$/', $token) === 1
        || preg_match('/^(neg|negat|negativ|negativny|negativna|negativne|pozit|pozitiv|pozitivny|pozitivna|pozitivne|stopy|norm|normal|v norme)$/', $qualitative) === 1
    ) {
        return ['value' => $token, 'num' => null, 'flag' => ''];
    }

    return null;
}

function labsNormalizeFlag(string $flag): string
{
    return match ($flag) {
        'H', 'HH', 'h', 'hh', '↑', '+' => 'H',
        'L', 'LL', 'l', 'll', '↓', '-' => 'L',
        '*', '!' => '*',
        default => '',
    };
}

function labsIsFlagToken(string $token): bool
{
    return preg_match('/^(H|HH|L|LL|h|l|\*|!|↑|↓|\+|-)$/u', $token) === 1;
}

function labsIsUnitToken(string $token): bool
{
    if (preg_match('/^\d/', $token) === 1 && !str_contains($token, '/') && !str_contains($token, '^')) {
        return false;
    }

    return str_contains($token, '/')
        || str_contains($token, '%')
        || str_contains($token, '^')
        || preg_match('/^(fl|pg|s|sek|sec|kpa|mmhg|ratio|index|iu|u|mu|ng|ug|pmol|nmol|umol|mmol|g|mg|e)$/i', $token) === 1;
}

/**
 * Vyhľadá referenčné rozpätia a nahradí ich značkou (súkromný znak Unicode),
 * aby ich čísla parser nepovažoval za hodnoty.
 *
 * @param list<string> $refs naplní nájdenými rozpätiami
 */
function labsExtractRefs(string $line, array &$refs, bool $bracketedOnly): string
{
    $number = '[+-]?\d+(?:[.,]\d+)?';
    $patterns = [
        '/[\(\[]\s*(' . $number . ')\s*(?:-|až|\.\.\.?)\s*(' . $number . ')\s*[\)\]]/u',
        '/[\(\[]\s*(<=|>=|<|>|≤|≥|do|pod|nad)\s*(' . $number . ')\s*[\)\]]/u',
    ];
    if (!$bracketedOnly) {
        $patterns[] = '/(?<![\w,.+-])(' . $number . ')\s*(?:-|až|\.\.\.?)\s*(' . $number . ')(?![\w,.])/u';
    }
    foreach ($patterns as $pattern) {
        $line = (string) preg_replace_callback($pattern, static function (array $match) use (&$refs): string {
            $low = str_replace('.', ',', $match[1]);
            $high = str_replace('.', ',', $match[2]);
            $refs[] = preg_match('/^(<=|>=|<|>|≤|≥|do|pod|nad)$/u', $match[1]) === 1
                ? strtr($match[1], ['≤' => '<=', '≥' => '>=', 'do' => '<=', 'pod' => '<', 'nad' => '>']) . ' ' . $high
                : $low . '-' . $high;
            $marker = "\u{E000}" . (count($refs) - 1);
            $length = mb_strlen($match[0], 'UTF-8');

            return $marker . str_repeat(' ', max(0, $length - mb_strlen($marker, 'UTF-8')));
        }, $line);
    }

    return $line;
}

/**
 * @return list<array{text: string, start: int}>
 */
function labsTokenize(string $line): array
{
    $tokens = [];
    if (preg_match_all('/\S+/u', $line, $matches, PREG_OFFSET_CAPTURE) !== false) {
        foreach ($matches[0] as [$text, $offset]) {
            $tokens[] = ['text' => $text, 'start' => mb_strlen(substr($line, 0, $offset), 'UTF-8')];
        }
    }

    return $tokens;
}

/** Riadky s osobnými údajmi pacienta alebo hlavičkou výpisu sa neparsujú. */
function labsIsHeaderName(string $name): bool
{
    $first = explode(' ', labsFoldKey($name))[0];

    return in_array($first, [
        'meno', 'priezvisko', 'pacient', 'pacientka', 'rc', 'rodne', 'nar', 'narodeny', 'narodena', 'datum', 'poistovna',
        'poist', 'adresa', 'bydlisko', 'lekar', 'mudr', 'ico', 'icp', 'kod', 'tel', 'telefon', 'strana', 'str',
        'ambulancia', 'diagnoza', 'dg', 'odber', 'odobrate', 'prijate', 'vysledok', 'vysledky', 'laboratorium',
        'laboratorne', 'ziadanka', 'cislo', 'vytlacene', 'vytlacil', 'oddelenie', 'psc', 'ulica', 'obec', 'mesto',
    ], true);
}

/**
 * Rozparsuje text výpisu.
 *
 * @return array{
 *     items: list<array{date: ?string, code: string, known: bool, name: string, label: string, value: string, num: ?float, unit: string, ref: string, flag: string}>,
 *     unparsed: list<string>,
 *     unparsed_count: int
 * }
 */
function labsParse(string $text): array
{
    $items = [];
    $unparsed = [];
    $unparsedCount = 0;
    $currentDate = null;
    $columns = [];

    foreach (explode("\n", labsNormalizeInput($text)) as $rawLine) {
        if (trim($rawLine) === '') {
            continue;
        }
        // Rodné číslo alebo dátum narodenia: celý riadok preskočiť, nič z neho nebrať.
        if (
            preg_match('/(?<!\d)\d{6}\s?\/\s?\d{3,4}(?!\d)/', $rawLine) === 1
            || preg_match('/\b(nar|narodeni[ae]|narodený|narodená|dátum nar)\b/iu', $rawLine) === 1
            || preg_match('/rodn[eé]\s+[čc][ií]slo|\bR[ČC]\s*:/iu', $rawLine) === 1
        ) {
            continue;
        }

        $dates = labsFindDates($rawLine);
        $work = $rawLine;
        foreach ($dates as $date) {
            $work = labsBlankSpan($work, $date['start'], $date['length']);
        }
        $work = (string) preg_replace_callback('/(?<![\d:])\d{1,2}:\d{2}(?::\d{2})?(?![\d:])/u', static fn (array $m): string => str_repeat(' ', strlen($m[0])), $work);
        // Dátum tlače, prijatia alebo schválenia nie je dátum odberu.
        if (preg_match('/tla[čc]|prijat|schv[áa]lil|vydan/iu', $rawLine) === 1) {
            $dates = [];
        }

        $refs = [];
        $columnMode = $columns !== [] && count($dates) === 0;
        if (!$columnMode) {
            $work = labsMarkInlineFlags($work);
        }
        $work = labsExtractRefs($work, $refs, $columnMode);
        $tokens = labsTokenize($work);

        $lineItems = $columnMode
            ? labsParseColumnLine($tokens, $refs, $columns)
            : labsParseFlowLine($tokens, $refs, count($dates) === 1 ? $dates[0]['date'] : $currentDate);

        if ($lineItems === []) {
            if (count($dates) >= 2) {
                $columns = array_map(
                    static fn (array $date): array => ['date' => $date['date'], 'center' => $date['start'] + $date['length'] / 2],
                    $dates,
                );
                $currentDate = null;
            } elseif (count($dates) === 1) {
                $currentDate = $dates[0]['date'];
                $columns = [];
            } elseif (preg_match('/\d/', $rawLine) === 1) {
                $unparsedCount++;
                if (count($unparsed) < LABS_MAX_UNPARSED) {
                    $unparsed[] = trim($rawLine);
                }
            }
            continue;
        }
        if (count($dates) === 1) {
            $currentDate = $dates[0]['date'];
            $columns = [];
        }
        array_push($items, ...$lineItems);
    }

    return ['items' => $items, 'unparsed' => $unparsed, 'unparsed_count' => $unparsedCount];
}

/**
 * Bežný riadok: jeden alebo viac parametrov za sebou (názov hodnota jednotka ref príznak).
 *
 * @param list<array{text: string, start: int}> $tokens
 * @param list<string> $refs
 * @return list<array<string, mixed>>
 */
function labsParseFlowLine(array $tokens, array $refs, ?string $date): array
{
    $items = [];
    $count = count($tokens);
    $index = 0;
    while ($index < $count) {
        $nameStart = $index;
        while ($index < $count && (
            labsParseValueToken($tokens[$index]['text']) === null
            || labsIsYearInName($tokens, $index, $nameStart)
        )) {
            $index++;
        }
        if ($index >= $count) {
            break;
        }
        $nameTokens = array_column(array_slice($tokens, $nameStart, $index - $nameStart), 'text');
        $parsedValue = labsParseValueToken($tokens[$index]['text']);
        $index++;
        $name = labsCleanName($nameTokens);
        if ($name === null || $parsedValue === null) {
            continue;
        }

        $unit = '';
        $ref = '';
        $flag = $parsedValue['flag'];
        while ($index < $count) {
            $text = $tokens[$index]['text'];
            $next = $tokens[$index + 1]['text'] ?? null;
            if (str_starts_with($text, "\u{E000}") && $ref === '') {
                $ref = $refs[(int) mb_substr($text, 1, null, 'UTF-8')] ?? '';
            } elseif ($flag === '' && labsIsFlagToken($text) && ($next === null || labsParseValueToken($next) === null)) {
                $flag = labsNormalizeFlag($text);
            } elseif ($unit === '' && labsIsUnitToken($text) && ($next === null || labsParseValueToken($next) === null)) {
                $unit = $text;
                if ($next !== null && preg_match('/^m2$|^m²$/u', $next) === 1) {
                    $unit .= $next;
                    $index++;
                }
            } else {
                break;
            }
            $index++;
        }

        $items[] = labsMakeItem($name, $parsedValue, $unit, $ref, $flag, $date);
    }

    return $items;
}

/**
 * Dĺžka najdlhšieho riadku vstupu v znakoch (konce riadkov LF, CRLF aj CR).
 */
function labsLongestLineChars(string $text): int
{
    $longest = 0;
    foreach (preg_split('/\r\n?|\n/', $text) ?: [] as $line) {
        $longest = max($longest, mb_strlen($line, 'UTF-8'));
    }

    return $longest;
}

/**
 * Rok verzie rovnice v názve („eGFR CKD-EPI 2021 1,25 ml/s“) nie je hodnota.
 *
 * @param list<array{text: string, start: int}> $tokens
 */
function labsIsYearInName(array $tokens, int $index, int $nameStart): bool
{
    $text = $tokens[$index]['text'];
    $next = $tokens[$index + 1]['text'] ?? null;

    return $index > $nameStart
        && preg_match('/^(19|20)\d{2}$/', $text) === 1
        && $next !== null
        && labsParseValueToken($next) !== null;
}

/**
 * Stĺpcový kumulatívny výpis: hodnoty patria k dátumu, pod ktorým stoja.
 *
 * @param list<array{text: string, start: int}> $tokens
 * @param list<string> $refs
 * @param list<array{date: string, center: float}> $columns
 * @return list<array<string, mixed>>
 */
function labsParseColumnLine(array $tokens, array $refs, array $columns): array
{
    $count = count($tokens);
    $index = 0;
    while ($index < $count && labsParseValueToken($tokens[$index]['text']) === null) {
        $index++;
    }
    if ($index === 0 || $index >= $count) {
        return [];
    }
    $nameTokens = array_column(array_slice($tokens, 0, $index), 'text');
    $unit = '';
    // Jednotka môže stáť aj medzi názvom a hodnotami („Urea mmol/l 12,5 11,8“).
    if (count($nameTokens) > 1 && labsIsUnitToken((string) end($nameTokens))) {
        $unit = (string) array_pop($nameTokens);
    }
    $name = labsCleanName($nameTokens);
    if ($name === null) {
        return [];
    }

    $values = [];
    $ref = '';
    for (; $index < $count; $index++) {
        $text = $tokens[$index]['text'];
        $parsedValue = labsParseValueToken($text);
        if ($parsedValue !== null) {
            $values[] = [$parsedValue, $tokens[$index]['start'] + mb_strlen($text, 'UTF-8') / 2];
        } elseif (str_starts_with($text, "\u{E000}")) {
            $ref = $refs[(int) mb_substr($text, 1, null, 'UTF-8')] ?? '';
        } elseif ($values !== [] && labsIsFlagToken($text)) {
            $values[count($values) - 1][0]['flag'] = labsNormalizeFlag($text);
        } elseif ($unit === '' && labsIsUnitToken($text)) {
            $unit = $text;
        }
    }

    $byDate = [];
    foreach ($values as [$parsedValue, $center]) {
        $best = null;
        $bestDistance = PHP_FLOAT_MAX;
        foreach ($columns as $column) {
            $distance = abs($column['center'] - $center);
            if ($distance < $bestDistance) {
                $bestDistance = $distance;
                $best = $column['date'];
            }
        }
        if ($best !== null && !isset($byDate[$best])) {
            $byDate[$best] = $parsedValue;
        }
    }

    $items = [];
    foreach ($byDate as $date => $parsedValue) {
        $items[] = labsMakeItem($name, $parsedValue, $unit, $ref, $parsedValue['flag'], (string) $date);
    }

    return $items;
}

/**
 * @param list<string> $nameTokens
 */
function labsCleanName(array $nameTokens): ?string
{
    if ($nameTokens === [] || count($nameTokens) > 5) {
        return null;
    }
    $name = rtrim(implode(' ', $nameTokens), ':=');
    $name = trim((string) preg_replace('/\.{2,}$/', '', $name));
    if (
        $name === ''
        || mb_strlen($name, 'UTF-8') > 40
        || str_contains($name, "\u{E000}")
        || preg_match('/\p{L}/u', $nameTokens[0]) !== 1
        || labsIsHeaderName($name)
    ) {
        return null;
    }

    return $name;
}

/**
 * @param array{value: string, num: ?float, flag: string} $parsedValue
 * @return array{date: ?string, code: string, known: bool, name: string, label: string, value: string, num: ?float, unit: string, ref: string, flag: string}
 */
function labsMakeItem(string $name, array $parsedValue, string $unit, string $ref, string $flag, ?string $date): array
{
    $code = labsResolveName($name);
    $known = $code !== null;
    if ($flag === '' && $parsedValue['num'] !== null && $ref !== '') {
        $flag = labsFlagFromRef($parsedValue['num'], $ref);
    }

    return [
        'date' => $date,
        'code' => $code ?? 'x:' . labsFoldKey($name),
        'known' => $known,
        'name' => $name,
        'label' => $known ? labsCatalogue()[$code]['label'] : $name,
        'value' => $parsedValue['value'],
        'num' => $parsedValue['num'],
        'unit' => $unit,
        'ref' => $ref,
        'flag' => $flag,
    ];
}

/** Príznak H/L odvodený z referenčného rozpätia, ak ho výpis neuvádza. */
function labsFlagFromRef(float $value, string $ref): string
{
    $toFloat = static fn (string $number): float => (float) str_replace(',', '.', $number);
    if (preg_match('/^([+-]?\d+(?:,\d+)?)-([+-]?\d+(?:,\d+)?)$/', $ref, $match) === 1) {
        $low = $toFloat($match[1]);
        $high = $toFloat($match[2]);
        if ($low <= $high) {
            return $value < $low ? 'L' : ($value > $high ? 'H' : '');
        }
    } elseif (preg_match('/^(<=|<) (\d+(?:,\d+)?)$/', $ref, $match) === 1) {
        $limit = $toFloat($match[2]);

        return ($match[1] === '<' ? $value >= $limit : $value > $limit) ? 'H' : '';
    } elseif (preg_match('/^(>=|>) (\d+(?:,\d+)?)$/', $ref, $match) === 1) {
        $limit = $toFloat($match[2]);

        return ($match[1] === '>' ? $value <= $limit : $value < $limit) ? 'L' : '';
    }

    return '';
}

function labsFormatDate(?string $date, bool $short = false): string
{
    if ($date === null) {
        return '';
    }
    [$year, $month, $day] = explode('-', $date);

    return $day . '.' . $month . '.' . ($short ? substr($year, 2) : $year);
}

/** Číslo s desatinnou čiarkou, bez oddeľovača tisícov. */
function labsNumber(float $value, int $decimals): string
{
    $text = number_format($value, $decimals, ',', '');

    return preg_match('/^-0(,0+)?$/', $text) === 1 ? ltrim($text, '-') : $text;
}

/** Kľúč jednotky na porovnanie: malé písmená bez medzier, µ/mc → u, bez „x“ pred mocninou. */
function labsUnitKey(string $unit): string
{
    $key = mb_strtolower(trim($unit), 'UTF-8');
    $key = strtr($key, ['µ' => 'u', 'μ' => 'u', ',' => '.', '²' => '2']);
    $key = (string) preg_replace('/\s+|\^|\*/u', '', $key);
    $key = (string) preg_replace('/^x(?=\d)/u', '', $key);

    return str_replace(['mcmol', 'mcg'], ['umol', 'ug'], $key);
}

/**
 * Jednotky šablóny a prepočty z iných jednotiek (násobok na jednotku šablóny).
 *
 * @return array<string, array{unit: string, same: list<string>, convert: array<string, float>, decimals: int}>
 */
function labsTemplateUnits(): array
{
    static $units = null;
    if ($units === null) {
        $mmol = static fn (array $convert = [], int $decimals = 2): array => ['unit' => 'mmol/L', 'same' => ['mmol/l'], 'convert' => $convert, 'decimals' => $decimals];
        $units = [
            'krea' => ['unit' => 'mcmol/L', 'same' => ['umol/l'], 'convert' => ['mg/dl' => CREATININE_UMOL_PER_MGDL, 'mmol/l' => 1000.0], 'decimals' => 0],
            'urea' => $mmol([], 1),
            'kmc' => ['unit' => 'mcmol/L', 'same' => ['umol/l'], 'convert' => ['mmol/l' => 1000.0, 'mg/dl' => 59.48], 'decimals' => 0],
            'na' => $mmol(['meq/l' => 1.0], 1),
            'k' => $mmol(['meq/l' => 1.0], 1),
            'cl' => $mmol(['meq/l' => 1.0], 0),
            'ca' => $mmol(['mg/dl' => 0.2495]),
            'p' => $mmol(['mg/dl' => 0.3229]),
            'mg' => $mmol(['mg/dl' => 0.4114, 'meq/l' => 0.5]),
            'hco3' => $mmol(['meq/l' => 1.0], 1),
            'cai' => $mmol(),
            'cacorr' => $mmol(),
            'hb' => ['unit' => 'g/L', 'same' => ['g/l'], 'convert' => ['g/dl' => 10.0], 'decimals' => 0],
            'ery' => ['unit' => 'x10^12/L', 'same' => ['1012/l', 't/l', '10e12/l'], 'convert' => [], 'decimals' => 2],
            'leu' => ['unit' => 'x10^9/L', 'same' => ['109/l', 'g/l', '10e9/l'], 'convert' => [], 'decimals' => 1],
            'tro' => ['unit' => 'x10^9/L', 'same' => ['109/l', 'g/l', '10e9/l'], 'convert' => [], 'decimals' => 0],
            'ferr' => ['unit' => 'mcg/L', 'same' => ['ug/l', 'ng/ml'], 'convert' => [], 'decimals' => 0],
            'tsat' => ['unit' => '%', 'same' => ['%'], 'convert' => [], 'decimals' => 0],
            'crp' => ['unit' => 'mg/L', 'same' => ['mg/l'], 'convert' => ['mg/dl' => 10.0], 'decimals' => 1],
            'alb' => ['unit' => 'g/L', 'same' => ['g/l'], 'convert' => ['g/dl' => 10.0], 'decimals' => 1],
            // PTH 1-84: 1 pmol/L = 9,43 ng/L (pg/mL).
            'pth' => ['unit' => 'pmol/L', 'same' => ['pmol/l'], 'convert' => ['ng/l' => 1 / 9.43, 'pg/ml' => 1 / 9.43], 'decimals' => 1],
            'vitd' => ['unit' => 'nmol/L', 'same' => ['nmol/l'], 'convert' => ['ng/ml' => 2.496, 'ug/l' => 2.496], 'decimals' => 0],
            'uacr' => ['unit' => 'mg/mmol', 'same' => ['mg/mmol'], 'convert' => ['mg/g' => 1 / UACR_MG_G_PER_MG_MMOL], 'decimals' => 1],
            'cysc' => ['unit' => 'mg/L', 'same' => ['mg/l'], 'convert' => [], 'decimals' => 2],
            'fe' => ['unit' => 'mcmol/L', 'same' => ['umol/l'], 'convert' => [], 'decimals' => 1],
            'tibc' => ['unit' => 'mcmol/L', 'same' => ['umol/l'], 'convert' => [], 'decimals' => 1],
            'trf' => ['unit' => 'g/L', 'same' => ['g/l'], 'convert' => [], 'decimals' => 2],
        ];
    }

    return $units;
}

/**
 * Číselná hodnota položky aj s porovnávacím znakom („<2,5“ → ['<', 2.5]).
 *
 * @param array<string, mixed> $item
 * @return array{0: string, 1: ?float}
 */
function labsItemNumber(array $item): array
{
    if (preg_match('/^(<=|>=|<|>)?([+-]?\d+(?:,\d+)?)$/', (string) $item['value'], $match) !== 1) {
        return ['', null];
    }

    return [$match[1], (float) str_replace(',', '.', $match[2])];
}

/**
 * Hodnota položky v jednotke šablóny. Neznámu jednotku neprepočíta, vráti hodnotu
 * s jednotkou z výpisu; 'num' je null pri porovnávacom znaku alebo nečíselnej hodnote.
 *
 * @param array<string, mixed> $item
 * @return array{text: string, num: ?float, unit: string, date: ?string}
 */
function labsTemplateValue(string $code, array $item): array
{
    $spec = labsTemplateUnits()[$code] ?? null;
    $unitKey = labsUnitKey((string) $item['unit']);
    [$comparator, $number] = labsItemNumber($item);
    $result = ['text' => (string) $item['value'], 'num' => $comparator === '' ? $number : null, 'unit' => (string) $item['unit'], 'date' => $item['date']];
    if ($spec === null) {
        return $result;
    }
    if ($unitKey === '' || $unitKey === labsUnitKey($spec['unit']) || in_array($unitKey, $spec['same'], true)) {
        return ['unit' => $spec['unit']] + $result;
    }
    if (isset($spec['convert'][$unitKey]) && $number !== null) {
        $converted = $number * $spec['convert'][$unitKey];

        return [
            'text' => $comparator . labsNumber($converted, $spec['decimals']),
            'num' => $comparator === '' ? $converted : null,
            'unit' => $spec['unit'],
            'date' => $item['date'],
        ];
    }

    return $result;
}

/**
 * Posledná hodnota každého parametra; položka s dátumom má prednosť pred položkou bez dátumu.
 *
 * @param list<array<string, mixed>> $items
 * @return array<string, array<string, mixed>>
 */
function labsLatestByCode(array $items): array
{
    $latest = [];
    foreach ($items as $item) {
        $code = (string) $item['code'];
        $current = $latest[$code] ?? null;
        if ($current === null || ($item['date'] !== null && ($current['date'] === null || $item['date'] > $current['date']))) {
            $latest[$code] = $item;
        }
    }

    return $latest;
}

/** eGFR CKD-EPI 2012 z cystatínu C (Inker LA et al., N Engl J Med 2012;367(1):20-29, PMID 22762315). */
function labsCkdEpi2012Cystatin(float $cystatinMgL, int $ageYears, string $sex): float
{
    $ratio = $cystatinMgL / 0.8;
    $egfr = 133.0 * (min($ratio, 1.0) ** -0.499) * (max($ratio, 1.0) ** -1.328) * (0.996 ** $ageYears);

    return $sex === 'female' ? $egfr * 0.932 : $egfr;
}

/**
 * eGFR v ml/min/1,73 m² z položky eGFR výpisu; jednotku určí podľa „/s“ alebo „/min“,
 * bez jednotky podľa veľkosti hodnoty (pod 5 = ml/s).
 *
 * @param array<string, mixed> $item
 * @return array{comparator: string, ml_min: float}|null
 */
function labsEgfrItemToMlMin(array $item): ?array
{
    [$comparator, $number] = labsItemNumber($item);
    if ($number === null || $number <= 0) {
        return null;
    }
    $unitKey = labsUnitKey((string) $item['unit']);
    $perSecond = str_contains($unitKey, '/s') || ($unitKey === '' && $number < 5.0);

    return ['comparator' => $comparator, 'ml_min' => $perSecond ? egfrMlSToMlMin($number) : $number];
}

/**
 * eGFR zo skupiny položiek jedného odberu: CKD-EPI 2021 z kreatinínu, ak je známy vek
 * a pohlavie, inak hodnota eGFR z výpisu.
 *
 * @param array<string, array<string, mixed>> $byCode
 * @return array{comparator: string, ml_min: float, date: ?string, source: string}|null
 */
function labsEgfrFromItems(array $byCode, ?int $ageYears, ?string $sex): ?array
{
    if (isset($byCode['krea']) && $ageYears !== null && $ageYears >= 18 && in_array($sex, ['female', 'male'], true)) {
        $creatinine = labsTemplateValue('krea', $byCode['krea']);
        if ($creatinine['num'] !== null && $creatinine['num'] > 0 && $creatinine['unit'] === 'mcmol/L') {
            return [
                'comparator' => '',
                'ml_min' => calculatorCkdEpi2021FromCreatinineMgDl($creatinine['num'] / CREATININE_UMOL_PER_MGDL, $ageYears, (string) $sex),
                'date' => $byCode['krea']['date'],
                'source' => 'computed',
            ];
        }
    }
    if (isset($byCode['egfr'])) {
        $egfr = labsEgfrItemToMlMin($byCode['egfr']);
        if ($egfr !== null) {
            return $egfr + ['date' => $byCode['egfr']['date'], 'source' => 'lab'];
        }
    }

    return null;
}

/**
 * Hodnoty eGFR pre riadok šablóny: [ml/s na 2 desatinné miesta, ml/min na celé číslo].
 *
 * @return array{0: string, 1: string}
 */
function labsEgfrPair(string $comparator, float $mlMin): array
{
    return [$comparator . labsNumber(egfrMlMinToMlS($mlMin), 2), $comparator . labsNumber($mlMin, 0)];
}

/**
 * Morfológia erytrocytov podľa MCV a MCH: príznak z výpisu, ak má položka rozpätie,
 * inak hranice 80 až 100 fl a 27 až 33 pg.
 *
 * @param array<string, mixed>|null $mcv
 * @param array<string, mixed>|null $mch
 */
function labsErythrocyteMorphology(?array $mcv, ?array $mch): string
{
    $classify = static function (?array $item, float $low, float $high, string $unit): ?string {
        if ($item === null) {
            return null;
        }
        [$comparator, $number] = labsItemNumber($item);
        if ($number === null || $comparator !== '' || !in_array(labsUnitKey((string) $item['unit']), ['', $unit], true)) {
            return null;
        }
        if ($item['ref'] !== '') {
            return in_array($item['flag'], ['H', 'L'], true) ? $item['flag'] : '';
        }

        return $number < $low ? 'L' : ($number > $high ? 'H' : '');
    };
    $size = $classify($mcv, 80.0, 100.0, 'fl');
    $color = $classify($mch, 27.0, 33.0, 'pg');
    $sizeText = $size === null ? '' : ['L' => 'mikrocyty', 'H' => 'makrocyty', '' => 'normocyty'][$size];
    $colorText = $color === null ? '' : ['L' => 'hypochrómne', 'H' => 'hyperchrómne', '' => 'normochrómne'][$color];
    if ($colorText !== '' && $sizeText !== '') {
        return $colorText . ' ' . $sizeText;
    }

    return $colorText !== '' ? $colorText . ' erytrocyty' : $sizeText;
}

/**
 * Moč chemicky (prúžkom) a sediment v jednom riadku.
 *
 * @param array<string, array<string, mixed>> $latest
 */
function labsUrineText(array $latest): string
{
    $describe = static function (string $code) use ($latest): ?string {
        $item = $latest[$code] ?? null;
        if ($item === null) {
            return null;
        }
        $text = labsCatalogue()[$code]['label'] . ' ' . $item['value'];
        [, $number] = labsItemNumber($item);
        if ($number !== null && !in_array($code, ['uph', 'usg'], true) && $item['unit'] !== '') {
            $text .= preg_match('/^po[čc]et\/(u|µ|μ)l$/iu', (string) $item['unit']) === 1 ? '/ul' : ' ' . $item['unit'];
        }

        return $text;
    };
    $strip = array_values(array_filter(array_map($describe, ['uph', 'usg', 'usprot', 'uglu', 'uket', 'ubld', 'ubil', 'uubg', 'unitr', 'uleus'])));
    $sediment = array_values(array_filter(array_map($describe, ['sedery', 'sedleu'])));
    $parts = [];
    if ($strip !== []) {
        $parts[] = implode(', ', $strip);
    }
    if ($sediment !== []) {
        $parts[] = 'sediment: ' . implode(', ', $sediment);
    }

    return implode('; ', $parts);
}

/**
 * Údaje pre blok „Laboratórne a pomocné vyšetrenia“: posledné hodnoty z výpisu
 * v jednotkách šablóny a odvodené hodnoty. Chýbajúci údaj je null.
 *
 * Kontext: vek a pohlavie (eGFR z kreatinínu a z cystatínu C) a hodnoty z formulára
 * kalkulačky, ktoré sa použijú, keď vo výpise eGFR alebo uACR nie je.
 *
 * @param list<array<string, mixed>> $items
 * @param array{age?: ?int, sex?: ?string, egfr_ml_min?: ?float, uacr_value?: ?float, uacr_unit?: ?string} $context
 * @return array{values: array<string, ?array<string, mixed>>, newest: ?string}
 */
function labsTemplateData(array $items, array $context): array
{
    $latest = labsLatestByCode($items);
    $newest = null;
    foreach ($items as $item) {
        if ($item['date'] !== null && ($newest === null || $item['date'] > $newest)) {
            $newest = $item['date'];
        }
    }
    $age = $context['age'] ?? null;
    $sex = $context['sex'] ?? null;
    $values = [];
    $value = static fn (string $code): ?array => isset($latest[$code]) ? labsTemplateValue($code, $latest[$code]) : null;

    $egfr = labsEgfrFromItems($latest, $age, $sex);
    if ($egfr === null && ($context['egfr_ml_min'] ?? null) !== null) {
        $egfr = ['comparator' => '', 'ml_min' => (float) $context['egfr_ml_min'], 'date' => null, 'source' => 'form'];
    }
    $values['egfr'] = $egfr === null ? null : ['pair' => labsEgfrPair($egfr['comparator'], $egfr['ml_min']), 'text' => '', 'unit' => '', 'date' => $egfr['date']];

    $cystatin = $value('cysc');
    $egfrCys = null;
    if ($cystatin !== null && $cystatin['num'] !== null && $cystatin['num'] > 0 && $cystatin['unit'] === 'mg/L'
        && $age !== null && $age >= 18 && in_array($sex, ['female', 'male'], true)) {
        $egfrCys = ['comparator' => '', 'ml_min' => labsCkdEpi2012Cystatin($cystatin['num'], $age, (string) $sex), 'date' => $cystatin['date']];
    } elseif (isset($latest['egfrcys'])) {
        $converted = labsEgfrItemToMlMin($latest['egfrcys']);
        $egfrCys = $converted === null ? null : $converted + ['date' => $latest['egfrcys']['date']];
    }
    $values['egfrcys'] = $egfrCys === null ? null : ['pair' => labsEgfrPair($egfrCys['comparator'], $egfrCys['ml_min']), 'text' => '', 'unit' => '', 'date' => $egfrCys['date']];

    $values['uacr'] = $value('uacr');
    if ($values['uacr'] === null && ($context['uacr_value'] ?? null) !== null) {
        $uacr = (float) $context['uacr_value'];
        if (($context['uacr_unit'] ?? 'mg_mmol') === 'mg_g') {
            $uacr = uacrMgGToMgMmol($uacr);
        }
        $values['uacr'] = ['text' => labsNumber($uacr, 1), 'num' => $uacr, 'unit' => 'mg/mmol', 'date' => null];
    }

    foreach (['krea', 'urea', 'kmc', 'na', 'k', 'cl', 'ca', 'p', 'mg', 'hco3', 'cai', 'hb', 'ery', 'leu', 'tro', 'ferr', 'crp', 'alb', 'pth', 'vitd'] as $code) {
        $values[$code] = $value($code);
    }
    $values['ph'] = isset($latest['ph']) ? ['text' => (string) $latest['ph']['value'], 'unit' => '', 'date' => $latest['ph']['date']] : null;

    // Korigovaný Ca: hodnota laboratória, inak Ca + 0,02 · (40 - albumín) pri albumíne pod 40 g/L;
    // pri albumíne 40 g/L a viac sa korekcia nerobí a platí nameraný Ca.
    $values['cacorr'] = $value('cacorr');
    $calcium = $values['ca'];
    $albumin = $values['alb'];
    if ($values['cacorr'] === null && $calcium !== null && $albumin !== null && $calcium['num'] !== null && $albumin['num'] !== null
        && $calcium['unit'] === 'mmol/L' && $albumin['unit'] === 'g/L') {
        $values['cacorr'] = [
            'text' => $albumin['num'] < 40.0 ? labsNumber(calculatorCorrectedCalcium($calcium['num'], $albumin['num']), 2) : $calcium['text'],
            'unit' => 'mmol/L',
            'date' => $calcium['date'],
        ];
    }

    // Saturácia transferínu: hodnota laboratória, inak Fe / TIBC, prípadne Fe / (transferín · 25,1).
    $values['tsat'] = $value('tsat');
    $iron = $value('fe');
    if ($values['tsat'] === null && $iron !== null && $iron['num'] !== null && $iron['unit'] === 'mcmol/L') {
        $tibc = $value('tibc');
        $transferrin = $value('trf');
        $capacity = null;
        if ($tibc !== null && $tibc['num'] !== null && $tibc['unit'] === 'mcmol/L') {
            $capacity = $tibc['num'];
        } elseif ($transferrin !== null && $transferrin['num'] !== null && $transferrin['unit'] === 'g/L') {
            $capacity = $transferrin['num'] * 25.1;
        }
        if ($capacity !== null && $capacity > 0) {
            $values['tsat'] = ['text' => labsNumber(100.0 * $iron['num'] / $capacity, 0), 'unit' => '%', 'date' => $iron['date']];
        }
    }

    $values['morphology'] = ['text' => labsErythrocyteMorphology($latest['mcv'] ?? null, $latest['mch'] ?? null), 'unit' => '', 'date' => null];

    $diff = [];
    foreach (['neu', 'lym', 'mono', 'eos', 'baso'] as $code) {
        $item = $latest[$code] ?? null;
        if ($item !== null && (labsUnitKey((string) $item['unit']) === '%' || str_contains((string) $item['name'], '%'))) {
            $diff[] = labsCatalogue()[$code]['label'] . ' ' . $item['value'] . ' %';
        }
    }
    $values['diff'] = ['text' => implode(', ', $diff), 'unit' => '', 'date' => null];

    $values['urine'] = ['text' => labsUrineText($latest), 'unit' => '', 'date' => null];

    // Hodnota zo staršieho odberu nesie svoj dátum.
    foreach ($values as $key => $entry) {
        if ($entry !== null && $entry['date'] !== null && $newest !== null && $entry['date'] < $newest) {
            $values[$key]['note'] = ' (' . labsFormatDate($entry['date']) . ')';
        }
    }

    return ['values' => $values, 'newest' => $newest];
}

/**
 * Blok „Laboratórne a pomocné vyšetrenia“ podľa šablóny (UTF-8, LF). Nerozpoznaný
 * údaj ostáva prázdny na ručné doplnenie, jednotka zostáva v riadku.
 *
 * @param array{values: array<string, ?array<string, mixed>>, newest: ?string} $data
 */
function labsBuildTemplate(array $data): string
{
    $values = $data['values'];
    $text = static function (string $key) use ($values): string {
        $entry = $values[$key] ?? null;

        return $entry === null ? '' : $entry['text'] . ($entry['note'] ?? '');
    };
    $field = static function (string $label, string $key, string $unit) use ($values): string {
        $entry = $values[$key] ?? null;
        $unitText = $entry !== null && $entry['unit'] !== '' ? $entry['unit'] : $unit;
        $valueText = $entry === null ? '' : $entry['text'];
        $note = $entry['note'] ?? '';

        return $label . ': ' . $valueText . ' ' . $unitText . $note;
    };
    $egfr = static function (string $label, string $key) use ($values): string {
        $entry = $values[$key] ?? null;
        [$perSecond, $perMinute] = $entry === null ? ['', ''] : $entry['pair'];

        return $label . ': ' . $perSecond . ' mL/s/1,73m2 | ' . $perMinute . ' mL/min/1,73m2' . ($entry['note'] ?? '');
    };
    $tail = static fn (string $key): string => (string) ($values[$key]['text'] ?? '');

    $lines = [
        'Laboratórne a pomocné vyšetrenia:',
        '',
        $egfr('eGFR (CKD-EPI 2021)', 'egfr'),
        $egfr('eGFR (Cystatín C)', 'egfrcys'),
        $field('uACR', 'uacr', 'mg/mmol'),
        '',
        $field('S-Kreatinín', 'krea', 'mcmol/L'),
        $field('S-Urea (močovina)', 'urea', 'mmol/L'),
        $field('S-Kyselina močová', 'kmc', 'mcmol/L'),
        '',
        'Ionogram:',
        $field('S-Na', 'na', 'mmol/L'),
        $field('S-K', 'k', 'mmol/L'),
        $field('S-Cl', 'cl', 'mmol/L'),
        $field('S-Ca', 'ca', 'mmol/L'),
        $field('S-P', 'p', 'mmol/L'),
        $field('S-Mg', 'mg', 'mmol/L'),
        '',
        'ABR:',
        $field('HCO3-', 'hco3', 'mmol/L') . ' (pH ' . $text('ph') . ')',
        $field('Korigovaný Ca pri hypalbuminémii', 'cacorr', 'mmol/L') . ' | ' . $field('Ionizovaný Ca', 'cai', 'mmol/L'),
        '',
        'Krvný obraz + diff.:',
        $field('Hb', 'hb', 'g/L'),
        $field('Er', 'ery', 'x10^12/L') . '; ' . $tail('morphology'),
        $field('Le', 'leu', 'x10^9/L') . '; ' . $tail('diff'),
        $field('Tr', 'tro', 'x10^9/L'),
        '',
        $field('S-Feritín', 'ferr', 'mcg/L'),
        $field('Saturácia transferínu', 'tsat', '%'),
        '',
        $field('S-CRP', 'crp', 'mg/L'),
        $field('S-Albumín', 'alb', 'g/L'),
        $field('iPTH', 'pth', 'pmol/L'),
        $field('25-OH-vit. D', 'vitd', 'nmol/L'),
        '',
        'Moč chem. + sediment: ' . $tail('urine'),
    ];

    return implode("\n", array_map('rtrim', $lines));
}

/**
 * Hodnoty pre polia kalkulačky z laboratórnych výsledkov: aktuálne eGFR (ml/min),
 * uACR, HbA1c, BMI a staršie eGFR pre slope (najviac 3 odbery, novšie prvé).
 *
 * @param list<array<string, mixed>> $items
 * @return array{
 *     egfr: ?array{ml_min: float, source: string, date: ?string},
 *     uacr: ?array{value: float, unit: string},
 *     hba1c: ?array{value: float, unit: string},
 *     bmi: ?float,
 *     slope: list<array{date: string, ml_min: float}>
 * }
 */
function labsFormValues(array $items, ?int $ageYears, ?string $sex): array
{
    $latest = labsLatestByCode($items);
    $result = ['egfr' => null, 'uacr' => null, 'hba1c' => null, 'bmi' => null, 'slope' => []];

    $egfr = labsEgfrFromItems($latest, $ageYears, $sex);
    if ($egfr !== null && $egfr['comparator'] === '') {
        $result['egfr'] = ['ml_min' => $egfr['ml_min'], 'source' => $egfr['source'], 'date' => $egfr['date']];
    }

    if (isset($latest['uacr'])) {
        [$comparator, $number] = labsItemNumber($latest['uacr']);
        $unitKey = labsUnitKey((string) $latest['uacr']['unit']);
        if ($comparator === '' && $number !== null && $number > 0 && in_array($unitKey, ['', 'mg/mmol', 'mg/g'], true)) {
            $result['uacr'] = ['value' => $number, 'unit' => $unitKey === 'mg/g' ? 'mg_g' : 'mg_mmol'];
        }
    }

    if (isset($latest['hba1c'])) {
        [$comparator, $number] = labsItemNumber($latest['hba1c']);
        $unitKey = labsUnitKey((string) $latest['hba1c']['unit']);
        if ($comparator === '' && $number !== null && $number > 0) {
            $percent = $unitKey === '%' || ($unitKey !== 'mmol/mol' && $number < 20.0);
            $result['hba1c'] = ['value' => $number, 'unit' => $percent ? 'percent' : 'mmol_mol'];
        }
    }

    if (isset($latest['bmi'])) {
        [$comparator, $number] = labsItemNumber($latest['bmi']);
        if ($comparator === '' && $number !== null && $number >= 10.0 && $number <= 80.0) {
            $result['bmi'] = $number;
        }
    }

    // Staršie odbery: eGFR z kreatinínu alebo z výpisu, pre každý dátum zvlášť.
    $byDate = [];
    foreach ($items as $item) {
        if ($item['date'] !== null && in_array($item['code'], ['krea', 'egfr'], true)) {
            $byDate[$item['date']][$item['code']] ??= $item;
        }
    }
    krsort($byDate);
    $currentDate = $result['egfr']['date'] ?? null;
    foreach ($byDate as $date => $group) {
        if ($currentDate === null || $date >= $currentDate) {
            continue;
        }
        $point = labsEgfrFromItems($group, $ageYears, $sex);
        if ($point !== null && $point['comparator'] === '' && $point['ml_min'] <= 200.0) {
            $result['slope'][] = ['date' => (string) $date, 'ml_min' => $point['ml_min']];
        }
        if (count($result['slope']) === 3) {
            break;
        }
    }

    return $result;
}

/**
 * Údaje šablóny, ktoré sa z výpisu ani z formulára nepodarilo zistiť (na ručné doplnenie).
 *
 * @param array{values: array<string, ?array<string, mixed>>, newest: ?string} $data
 * @return list<string>
 */
function labsMissingTemplateLabels(array $data): array
{
    $labels = [
        'egfr' => 'eGFR (CKD-EPI 2021)', 'egfrcys' => 'eGFR (cystatín C)', 'uacr' => 'uACR',
        'krea' => 'kreatinín', 'urea' => 'urea', 'kmc' => 'kyselina močová',
        'na' => 'Na', 'k' => 'K', 'cl' => 'Cl', 'ca' => 'Ca', 'p' => 'P', 'mg' => 'Mg',
        'hco3' => 'HCO3-', 'ph' => 'pH', 'cacorr' => 'korigovaný Ca', 'cai' => 'ionizovaný Ca',
        'hb' => 'Hb', 'ery' => 'Er', 'morphology' => 'morfológia erytrocytov', 'leu' => 'Le', 'diff' => 'diferenciál',
        'tro' => 'Tr', 'ferr' => 'feritín', 'tsat' => 'saturácia transferínu', 'crp' => 'CRP',
        'alb' => 'albumín', 'pth' => 'iPTH', 'vitd' => '25-OH-vit. D', 'urine' => 'moč chemicky a sediment',
    ];
    $missing = [];
    foreach ($labels as $key => $label) {
        $entry = $data['values'][$key] ?? null;
        if ($entry === null || (!isset($entry['pair']) && trim((string) $entry['text']) === '')) {
            $missing[] = $label;
        }
    }

    return $missing;
}
