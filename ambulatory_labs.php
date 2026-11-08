<?php

declare(strict_types=1);

/**
 * Výber laboratórnych výsledkov z textu Nefrisu (MS-DOS) pre Ambulantnú kalkulačku.
 *
 * Vstup je text vložený zo schránky alebo načítaný zo súboru (dekódovanie CP852
 * robí prehliadač, calculator_ambulatory.js). Parser rozpozná riadky typu
 * „názov hodnota jednotka (referenčné rozpätie) príznak“, dátumy odberov,
 * stĺpcové kumulatívne výpisy (hlavička s viacerými dátumami) aj dva parametre
 * v jednom riadku. Nič sa neukladá ani nezapisuje do logu.
 */

require_once __DIR__ . '/calculator_ambulatory_logic.php';

const LABS_MAX_INPUT_CHARS = 100000;
const LABS_MAX_LINES = 3000;
const LABS_MAX_UNPARSED = 30;

/**
 * Katalóg bežných parametrov v poradí, v akom idú do výstupu.
 * Aliasy sú v zloženom tvare (labsFoldKey). Predpona "u " = vzorka moču.
 *
 * @return array<string, array{label: string, default: bool, aliases: list<string>}>
 */
function labsCatalogue(): array
{
    static $catalogue = [
        'urea' => ['label' => 'Urea', 'default' => true, 'aliases' => ['urea', 'mocovina', 'bun']],
        'krea' => ['label' => 'Kreatinín', 'default' => true, 'aliases' => ['kreatinin', 'kreat', 'krea', 'kreatinin enzymaticky', 'kreatinin jaffe', 'creatinine', 'crea', 'kreatinin idms']],
        'egfr' => ['label' => 'eGFR', 'default' => true, 'aliases' => ['egfr', 'gfr', 'egfr ckd epi', 'ckd epi', 'egfr ckd epi 2021', 'egfr mdrd', 'egfr ckdepi', 'odhad gfr']],
        'cysc' => ['label' => 'Cystatín C', 'default' => false, 'aliases' => ['cystatin c', 'cystatin', 'cys c', 'cysc']],
        'kmc' => ['label' => 'Kys. močová', 'default' => true, 'aliases' => ['kyselina mocova', 'kys mocova', 'k mocova', 'kmc', 'km', 'uric acid', 'ua', 'urat', 'uraty']],
        'na' => ['label' => 'Na', 'default' => true, 'aliases' => ['na', 'natrium', 'sodik', 'sodium']],
        'k' => ['label' => 'K', 'default' => true, 'aliases' => ['k', 'kalium', 'draslik', 'potassium']],
        'cl' => ['label' => 'Cl', 'default' => true, 'aliases' => ['cl', 'chloridy', 'chlorid', 'chloride']],
        'ca' => ['label' => 'Ca', 'default' => true, 'aliases' => ['ca', 'kalcium', 'vapnik', 'ca celk', 'ca celkove', 'ca celkovy', 'kalcium celkove', 'calcium']],
        'cai' => ['label' => 'Ca2+', 'default' => false, 'aliases' => ['ca2', 'ca ion', 'ca ionizovane', 'ca ionizovany', 'ionizovane ca', 'ionizovany vapnik', 'ica', 'ca2 ionizovane']],
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
        'pth' => ['label' => 'PTH', 'default' => true, 'aliases' => ['pth', 'ipth', 'parathormon', 'intaktny pth', 'intakt pth', 'pth intaktny', 'i pth']],
        'vitd' => ['label' => '25-OH vit. D', 'default' => true, 'aliases' => ['25 oh vit d', '25 oh vitamin d', '25ohd', '25 oh d', '25 ohd', 'vit d', 'vitamin d', 'kalcidiol', 'vit d3', 'vitamin d 25 oh', '25 hydroxyvitamin d']],
        'fe' => ['label' => 'Fe', 'default' => false, 'aliases' => ['fe', 'zelezo', 'iron']],
        'tibc' => ['label' => 'TIBC', 'default' => false, 'aliases' => ['tibc', 'celkova vazobna kapacita', 'cvk', 'cvk fe', 'vazobna kapacita fe', 'tvk']],
        'ferr' => ['label' => 'Feritín', 'default' => true, 'aliases' => ['feritin', 'ferritin', 'ferr']],
        'tsat' => ['label' => 'TSAT', 'default' => true, 'aliases' => ['tsat', 'saturacia transferinu', 'sat transferinu', 'sat transf', 'saturacia transf', 'sat tf', 'saturacia']],
        'trf' => ['label' => 'Transferín', 'default' => false, 'aliases' => ['transferin', 'trf', 'tf']],
        'hb' => ['label' => 'Hb', 'default' => true, 'aliases' => ['hb', 'hgb', 'hemoglobin']],
        'hct' => ['label' => 'Hct', 'default' => false, 'aliases' => ['hct', 'htk', 'hematokrit']],
        'ery' => ['label' => 'Ery', 'default' => false, 'aliases' => ['ery', 'erytrocyty', 'rbc']],
        'mcv' => ['label' => 'MCV', 'default' => false, 'aliases' => ['mcv']],
        'leu' => ['label' => 'Leu', 'default' => true, 'aliases' => ['leu', 'leukocyty', 'wbc']],
        'tro' => ['label' => 'Tro', 'default' => true, 'aliases' => ['tro', 'trom', 'trombocyty', 'plt']],
        'inr' => ['label' => 'INR', 'default' => false, 'aliases' => ['inr', 'pt inr', 'quick inr']],
        'ntprobnp' => ['label' => 'NT-proBNP', 'default' => false, 'aliases' => ['nt probnp', 'ntprobnp', 'nt pro bnp']],
        'b2m' => ['label' => 'Beta2-mikroglobulín', 'default' => false, 'aliases' => ['b2 mikroglobulin', 'beta2 mikroglobulin', 'beta 2 mikroglobulin', 'b2m']],
        'uacr' => ['label' => 'ACR', 'default' => true, 'aliases' => ['acr', 'uacr', 'albumin kreatinin', 'alb kreat', 'alb krea', 'albumin kreatinin pomer', 'pomer albumin kreatinin', 'u acr', 'u alb kreat', 'u alb krea', 'u albumin kreatinin', 'u acr pomer']],
        'upcr' => ['label' => 'PCR', 'default' => true, 'aliases' => ['upcr', 'prot kreat', 'prot krea', 'bielk kreat', 'bielk krea', 'u pcr', 'u upcr', 'u prot kreat', 'u prot krea', 'u bielk kreat', 'u bielk krea', 'u bielkovina kreatinin']],
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
 * (S-, P-, B-, sérum / U-, dU-, moč) sa zohľadní. Neznámy názov vráti null.
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
    $urine = false;
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
    foreach ([[$urineSuffixes, true], [$bloodSuffixes, false]] as [$suffixes, $isUrine]) {
        foreach ($suffixes as $suffix) {
            $length = count($suffix);
            if (count($words) > $length && array_slice($words, -$length) === $suffix) {
                $words = array_slice($words, 0, -$length);
                $urine = $urine || $isUrine;
                break 2;
            }
        }
    }

    $base = implode(' ', $words);
    if ($urine) {
        return $index['u ' . $base] ?? (in_array($index[$base] ?? '', ['uacr', 'upcr'], true) ? $index[$base] : null);
    }

    return $index[$base] ?? null;
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
        ) {
            continue;
        }

        $dates = labsFindDates($rawLine);
        $work = $rawLine;
        foreach ($dates as $date) {
            $work = labsBlankSpan($work, $date['start'], $date['length']);
        }
        $work = (string) preg_replace_callback('/(?<![\d:])\d{1,2}:\d{2}(?::\d{2})?(?![\d:])/u', static fn (array $m): string => str_repeat(' ', strlen($m[0])), $work);

        $refs = [];
        $columnMode = $columns !== [] && count($dates) === 0;
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

/**
 * Kódy vybraných parametrov v poradí výstupu.
 *
 * @param list<array<string, mixed>> $items
 * @return array{codes: list<string>, unresolved: list<string>}
 */
function labsSelectCodes(array $items, string $selection, string $customList): array
{
    $present = [];
    foreach ($items as $item) {
        $present[$item['code']] ??= $item;
    }

    if ($selection === 'custom') {
        $labelIndex = [];
        foreach (labsCatalogue() as $catalogueCode => $entry) {
            $labelIndex[labsFoldKey($entry['label'])] = $catalogueCode;
        }
        $codes = [];
        $unresolved = [];
        foreach (preg_split('/[,;\n]+/u', $customList) ?: [] as $token) {
            $token = trim($token);
            if ($token === '') {
                continue;
            }
            $code = labsResolveName($token) ?? $labelIndex[labsFoldKey($token)] ?? 'x:' . labsFoldKey($token);
            if (!isset(labsCatalogue()[$code]) && !isset($present[$code])) {
                $unresolved[] = $token;
                continue;
            }
            if (!in_array($code, $codes, true)) {
                $codes[] = $code;
            }
        }

        return ['codes' => $codes, 'unresolved' => $unresolved];
    }

    $codes = [];
    foreach (labsCatalogue() as $code => $entry) {
        if (isset($present[$code]) && ($selection === 'all' || $entry['default'])) {
            $codes[] = $code;
        }
    }
    if ($selection === 'all') {
        foreach (array_keys($present) as $code) {
            if (!in_array($code, $codes, true)) {
                $codes[] = $code;
            }
        }
    }

    return ['codes' => $codes, 'unresolved' => []];
}

function labsFormatDate(?string $date, bool $short = false): string
{
    if ($date === null) {
        return '';
    }
    [$year, $month, $day] = explode('-', $date);

    return $day . '.' . $month . '.' . ($short ? substr($year, 2) : $year);
}

/**
 * @param array<string, mixed> $item
 * @param array{flags: bool, ref: bool} $options
 */
function labsFormatItemDefault(array $item, array $options, ?string $groupDate): string
{
    $text = $item['label'] . ' ' . $item['value'];
    if ($item['unit'] !== '') {
        $text .= ' ' . $item['unit'];
    }
    if ($options['flags'] && $item['flag'] !== '') {
        $text .= ' ' . $item['flag'];
    }
    $notes = [];
    if ($options['ref'] && $item['ref'] !== '') {
        $notes[] = 'ref. ' . $item['ref'];
    }
    if ($item['date'] !== null && $item['date'] !== $groupDate) {
        $notes[] = labsFormatDate($item['date']);
    }

    return $notes === [] ? $text : $text . ' (' . implode('; ', $notes) . ')';
}

/**
 * Zoskupí vybrané položky podľa odberu.
 *
 * @param list<array<string, mixed>> $items
 * @param list<string> $codes
 * @return list<array{date: ?string, items: list<array<string, mixed>>}>
 */
function labsGroup(array $items, array $codes, string $dates): array
{
    $byDate = [];
    foreach ($items as $item) {
        if (!in_array($item['code'], $codes, true)) {
            continue;
        }
        $key = $item['date'] ?? '';
        $byDate[$key][$item['code']] ??= $item;
    }
    if ($byDate === []) {
        return [];
    }
    // Novšie odbery prvé, bez dátumu na koniec.
    uksort($byDate, static fn (string $a, string $b): int => $a === '' ? 1 : ($b === '' ? -1 : strcmp($b, $a)));
    $order = array_flip($codes);
    $sortItems = static function (array $group) use ($order): array {
        uksort($group, static fn (string $a, string $b): int => $order[$a] <=> $order[$b]);

        return array_values($group);
    };

    $keys = array_keys($byDate);
    $newest = (string) $keys[0];
    $newestDate = $newest === '' ? null : $newest;

    if ($dates === 'latest') {
        return [['date' => $newestDate, 'items' => $sortItems($byDate[$newest])]];
    }
    if ($dates === 'latest_each') {
        $merged = [];
        foreach ($byDate as $group) {
            foreach ($group as $code => $item) {
                $merged[$code] ??= $item;
            }
        }

        return [['date' => $newestDate, 'items' => $sortItems($merged)]];
    }

    $groups = [];
    foreach ($byDate as $key => $group) {
        $groups[] = ['date' => $key === '' ? null : (string) $key, 'items' => $sortItems($group)];
    }

    return $groups;
}

/**
 * Zalomí položky po celých položkách (hodnota sa neoddelí od jednotky);
 * pokračovanie je odsadené dvomi medzerami. Dlhšiu položku zalomí až ambulatoryToDosText.
 *
 * @param list<string> $parts
 */
function labsWrapParts(string $prefix, array $parts, string $separator, int $width): string
{
    $lines = [];
    $line = $prefix;
    $glue = rtrim($separator);
    $count = count($parts);
    foreach ($parts as $index => $part) {
        $piece = $part . ($index < $count - 1 ? $glue : '');
        $lineStart = $line === $prefix || $line === '  ';
        $candidate = $lineStart ? $line . $piece : $line . substr($separator, strlen($glue)) . $piece;
        if (!$lineStart && mb_strlen($candidate, 'UTF-8') > $width) {
            $lines[] = rtrim($line);
            $line = '  ' . $piece;
        } else {
            $line = $candidate;
        }
    }
    $lines[] = rtrim($line);

    return implode("
", $lines);
}

function labsPad(string $text, int $width): string
{
    $length = mb_strlen($text, 'UTF-8');

    return $length >= $width ? $text . ' ' : $text . str_repeat(' ', $width - $length);
}

/**
 * Zostaví výstupný text (UTF-8, LF); do formátu MS-DOS ho prevedie labsBuildOutput.
 *
 * @param list<array<string, mixed>> $items
 * @param array{selection: string, custom_list: string, dates: string, format: string, flags: bool, ref: bool, item_template: string, group_template: string, separator: string, width: int} $options
 * @return array{text: string, unresolved: list<string>, selected: int, note: string}
 */
function labsBuildText(array $items, array $options): array
{
    $selection = labsSelectCodes($items, $options['selection'], $options['custom_list']);
    $codes = $selection['codes'];
    $note = '';

    if ($options['format'] === 'table') {
        $groups = labsGroup($items, $codes, 'all');
        $labelWidth = 16;
        $columnWidth = 10;
        $maxColumns = max(1, intdiv($options['width'] - $labelWidth - 10, $columnWidth));
        if (count($groups) > $maxColumns) {
            $note = 'Zobrazených ' . $maxColumns . ' najnovších odberov z ' . count($groups) . '.';
            $groups = array_slice($groups, 0, $maxColumns);
        }
        $rows = [];
        $units = [];
        $labels = [];
        foreach ($groups as $groupIndex => $group) {
            foreach ($group['items'] as $item) {
                $labels[$item['code']] = $item['label'];
                $units[$item['code']] ??= $item['unit'];
                $cell = $item['value'] . ($options['flags'] && $item['flag'] !== '' ? ' ' . $item['flag'] : '');
                $rows[$item['code']][$groupIndex] = $cell;
            }
        }
        if ($rows === []) {
            return ['text' => '', 'unresolved' => $selection['unresolved'], 'selected' => 0, 'note' => ''];
        }
        $header = labsPad('Parameter', $labelWidth);
        foreach ($groups as $group) {
            $header .= labsPad($group['date'] === null ? 'bez dát.' : labsFormatDate($group['date'], true), $columnWidth);
        }
        $lines = [rtrim($header . 'Jednotka')];
        foreach ($codes as $code) {
            if (!isset($rows[$code])) {
                continue;
            }
            $line = labsPad($labels[$code], $labelWidth);
            foreach (array_keys($groups) as $groupIndex) {
                $line .= labsPad($rows[$code][$groupIndex] ?? '-', $columnWidth);
            }
            $lines[] = rtrim($line . $units[$code]);
        }

        return ['text' => implode("\n", $lines), 'unresolved' => $selection['unresolved'], 'selected' => count($rows), 'note' => $note];
    }

    $groups = labsGroup($items, $codes, $options['dates']);
    $blocks = [];
    $selected = 0;
    $listLabelWidth = 2;
    foreach ($groups as $group) {
        foreach ($group['items'] as $item) {
            $listLabelWidth = max($listLabelWidth, min(24, mb_strlen($item['label'], 'UTF-8') + 2));
        }
    }
    foreach ($groups as $group) {
        $selected = max($selected, count($group['items']));
        $dateText = labsFormatDate($group['date']);
        if ($options['format'] === 'list') {
            $lines = ['Laboratórne výsledky' . ($dateText !== '' ? ' ' . $dateText : '') . ':'];
            foreach ($group['items'] as $item) {
                $value = $item['value'] . ($item['unit'] !== '' ? ' ' . $item['unit'] : '');
                $line = '  ' . labsPad($item['label'], $listLabelWidth) . labsPad($value, 18);
                if ($options['flags'] && $item['flag'] !== '') {
                    $line .= labsPad($item['flag'], 3);
                }
                $notes = [];
                if ($options['ref'] && $item['ref'] !== '') {
                    $notes[] = 'ref. ' . $item['ref'];
                }
                if ($item['date'] !== null && $item['date'] !== $group['date']) {
                    $notes[] = labsFormatDate($item['date']);
                }
                $lines[] = rtrim($line . ($notes === [] ? '' : '(' . implode('; ', $notes) . ')'));
            }
            $blocks[] = implode("\n", $lines);
        } elseif ($options['format'] === 'custom') {
            $parts = [];
            foreach ($group['items'] as $item) {
                $part = strtr($options['item_template'], [
                    '{nazov}' => $item['label'],
                    '{hodnota}' => $item['value'],
                    '{jednotka}' => $item['unit'],
                    '{priznak}' => $options['flags'] ? $item['flag'] : '',
                    '{ref}' => $options['ref'] ? $item['ref'] : '',
                    '{datum}' => labsFormatDate($item['date']),
                ]);
                $part = (string) preg_replace(['/\(\s*\)|\[\s*\]/u', '/ {2,}/u', '/\s+([,;)\]])/u'], ['', ' ', '$1'], $part);
                $parts[] = trim($part);
            }
            $separator = strtr($options['separator'], ['\n' => "\n", '\t' => '    ']);
            $groupHeader = strtr($options['group_template'], ['{datum}' => $dateText, '\n' => "\n"]);
            if ($dateText === '') {
                $groupHeader = (string) preg_replace('/\s+:/u', ':', $groupHeader);
            }
            $blocks[] = str_contains($separator, "
")
                ? $groupHeader . implode($separator, $parts)
                : labsWrapParts($groupHeader, $parts, $separator, $options['width']);
        } else {
            $parts = array_map(
                static fn (array $item): string => labsFormatItemDefault($item, $options, $group['date']),
                $group['items'],
            );
            $blocks[] = labsWrapParts('Lab.' . ($dateText !== '' ? ' ' . $dateText : '') . ': ', $parts, ', ', $options['width']);
        }
    }

    return [
        'text' => implode($options['format'] === 'list' ? "\n\n" : "\n", $blocks),
        'unresolved' => $selection['unresolved'],
        'selected' => $selected,
        'note' => $note,
    ];
}

/**
 * Celý postup: parsovanie, výber, formát a prevod do podoby MS-DOS (CRLF, CP852, šírka riadku).
 *
 * @param array{selection: string, custom_list: string, dates: string, format: string, flags: bool, ref: bool, item_template: string, group_template: string, separator: string, width: int} $options
 * @return array{output: string, parsed: array<string, mixed>, unresolved: list<string>, selected: int, note: string}
 */
function labsBuildOutput(string $input, array $options): array
{
    $parsed = labsParse($input);
    $built = labsBuildText($parsed['items'], $options);

    return [
        'output' => $built['text'] === '' ? '' : ambulatoryToDosText($built['text'], $options['width']),
        'parsed' => $parsed,
        'unresolved' => $built['unresolved'],
        'selected' => $built['selected'],
        'note' => $built['note'],
    ];
}
