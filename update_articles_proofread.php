<?php
/**
 * update_articles_proofread.php
 * ══════════════════════════════════════════════════════════════════════════════
 * Jazyková korektúra článkov v databáze.
 * Spusti cez SSH:
 *   php /data/.../nefro/update_articles_proofread.php
 * alebo lokálne:
 *   php update_articles_proofread.php
 * ══════════════════════════════════════════════════════════════════════════════
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

// ── Korekcie: [slug => [[field, find, replace], ...]] ─────────────────────────

$corrections = [

    // 1. strava_tuky: "nekajúcnosti" — nezmyselný preklad, navyše nekonzistentný
    'strava-tuky-kardiovaskularne-riziko-ckd-co-dava-zmysel-praxi' => [
        [
            'field'   => 'content',
            'find'    => 'udržanie nekajúcnosti od fajčenia alebo abstinencie od alkoholu',
            'replace' => 'abstinenciu od fajčenia a alkoholu',
        ],
    ],

    // 2. zelenina_ckd: "nízke v draslíku" — doslovný anglicizmus (low in potassium)
    'zelenina-pre-lepsie-zdravie-obliciek-ckd-5-druhov-dietologovia' => [
        [
            'field'   => 'content',
            'find'    => 'bývajú nízke v draslíku a navyše majú aj nižší obsah vody',
            'replace' => 'majú nízky obsah draslíka a navyše aj nižší obsah vody',
        ],
        [
            'field'   => 'content',
            'find'    => 'obličky nemusia zvládať odstraňovať nadbytočný draslík tak efektívne',
            'replace' => 'obličky nemusia dostatočne efektívne odstraňovať nadbytočný draslík',
        ],
    ],

    // 3. glycocalyx: "glycocalyx" bez genitívnej koncovky
    'novy-krvny-test-glycocalyx-detekcia-cievneho-poskodenia' => [
        [
            'field'   => 'content',
            'find'    => 'ktorý zodpovedá stavu glycocalyx v cievnej stene',
            'replace' => 'ktorý zodpovedá stavu glycocalyxu v cievnej stene',
        ],
    ],

    // 4. fibroza_biomarker: nadpis sekcie bol gramaticky obrátený
    'molekularne-zobrazovanie-z-mocu-novy-biomarker-test-fibroza-obliciek' => [
        [
            'field'   => 'content',
            'find'    => '<h2>Čo je nové: biomarkery TG2 a LysAld aktivované v reportéri</h2>',
            'replace' => '<h2>Čo je nové: fluorescenčný reportér aktivovaný biomarkermi TG2 a LysAld</h2>',
        ],
    ],

    // 5. ivzelzo: anglický nadpis + "metód porovnania" namiesto "porovnávacích metód"
    'iv-zelzo-pocas-akutnej-infekcie-realne-data' => [
        [
            'field'   => 'content',
            'find'    => '<h2>Take-home správa na 30 sekúnd</h2>',
            'replace' => '<h2>Záver v 30 sekundách</h2>',
        ],
        [
            'field'   => 'content',
            'find'    => 'metód porovnania znižuje skreslenie',
            'replace' => 'porovnávacích metód znižuje skreslenie',
        ],
    ],

    // 6. covid_oblicky: CKD je stredný rod → "zachytená" → správna forma
    'covid-19-a-zdravie-obliciek-dopad-infekcie-sledovanie' => [
        [
            'field'   => 'content',
            'find'    => 'kým nie je zachytená nálezom v bežných laboratórnych testoch',
            'replace' => 'kým sa nezachytí pri bežných laboratórnych testoch',
        ],
    ],

];

// ── Aplikovanie korekcií ──────────────────────────────────────────────────────

$totalFixed  = 0;
$totalSkipped = 0;
$errors       = [];

foreach ($corrections as $slug => $fixes) {
    // Načítaj aktuálny obsah článku
    $stmt = $pdo->prepare('SELECT id, content, excerpt FROM articles WHERE slug = :slug LIMIT 1');
    $stmt->execute(['slug' => $slug]);
    $row = $stmt->fetch();

    if (!$row) {
        $errors[] = "Článok nenájdený (slug: $slug)";
        continue;
    }

    $id      = $row['id'];
    $changed = false;

    foreach ($fixes as $fix) {
        $field   = $fix['field'];
        $find    = $fix['find'];
        $replace = $fix['replace'];
        $original = $row[$field];

        if (str_contains($original, $find)) {
            $row[$field] = str_replace($find, $replace, $original);
            $changed = true;
            $label = mb_strimwidth($find, 0, 60, '...');
            echo "  OK [$slug] $field: '$label'\n";
        } else {
            echo "  -- [$slug] $field: hladany text nenajdeny (mozno uz opravene)\n";
            $totalSkipped++;
        }
    }

    if ($changed) {
        try {
            $upd = $pdo->prepare(
                'UPDATE articles SET content = :content, excerpt = :excerpt WHERE id = :id'
            );
            $upd->execute([
                'content' => $row['content'],
                'excerpt' => $row['excerpt'],
                'id'      => $id,
            ]);
            $totalFixed++;
        } catch (\PDOException $e) {
            $errors[] = "UPDATE zlyhal pre slug=$slug: " . $e->getMessage();
            error_log('update_articles_proofread error: ' . $e->getMessage());
        }
    }
}

// ── Výstup ────────────────────────────────────────────────────────────────────

echo "\n";
echo "──────────────────────────────────────────────────────\n";
echo "Korektúra dokončená\n";
echo "──────────────────────────────────────────────────────\n";
echo "Opravených článkov:    $totalFixed\n";
echo "Už bolo v poriadku:    $totalSkipped korekcií\n";
if (!empty($errors)) {
    echo "\nChyby:\n";
    foreach ($errors as $e) {
        echo "  - $e\n";
    }
}
echo "──────────────────────────────────────────────────────\n\n";
?>
