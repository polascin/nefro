<?php
/**
 * update_articles_proofread2.php
 * ══════════════════════════════════════════════════════════════════════════════
 * Jazyková korektúra článkov v databáze – 2. kolo.
 * Spusti cez SSH:
 *   php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/update_articles_proofread2.php
 * ══════════════════════════════════════════════════════════════════════════════
 *
 * Opravy:
 *  1. ppi-glp1:       nežiadúce → nežiaduce (ŠÚKL/KSSJ: krátke u) — titul + obsah
 *  2. wellness-peptidy: nežiadúce → nežiaduce — obsah (3 výskyty)
 *  3. strava-tuky:    surrogátne → surogátne (slovenská adaptácia: jedno r) — obsah
 *  4. nizkosodovy:    komplexná oprava nového článku — slug, titul, excerpt, obsah
 *     nízkosodíov* → nízkosodíkov*, vyššiosodíový → vyššiosodíkový, Nízko-sodíový → Nízkosodíkový
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

// ── Korekcie ──────────────────────────────────────────────────────────────────

$corrections = [

    // 1. PPI/GLP-1: "nežiadúce" (dlhé ú) → "nežiaduce" (krátke u) — ŠÚKL, KSSJ
    'subezne-uzivanie-ppi-a-glp-1-gastrointestinalne-neziaduce-ucinky' => [
        [
            'field'   => 'title',
            'find'    => 'nežiadúce účinky',
            'replace' => 'nežiaduce účinky',
        ],
        [
            'field'   => 'content',
            'find'    => 'gastrointestinálne nežiadúce účinky a vyššiu potrebu vyšetrení',
            'replace' => 'gastrointestinálne nežiaduce účinky a vyššiu potrebu vyšetrení',
        ],
    ],

    // 2. Wellness peptidy: "nežiadúce" → "nežiaduce" — tri výskyty v obsahu
    'wellness-peptidy-chyba-overenie-bezpecnosti-a-ucinnosti' => [
        [
            'field'   => 'content',
            'find'    => '<h2>Nežiadúce udalosti hlásené v súvislosti s niektorými peptidmi</h2>',
            'replace' => '<h2>Nežiaduce udalosti hlásené v súvislosti s niektorými peptidmi</h2>',
        ],
        [
            'field'   => 'content',
            'find'    => 'vážne nežiadúce udalosti vrátane',
            'replace' => 'vážne nežiaduce udalosti vrátane',
        ],
        [
            'field'   => 'content',
            'find'    => 'potenciálne nežiadúce účinky',
            'replace' => 'potenciálne nežiaduce účinky',
        ],
    ],

    // 3. Strava/tuky: "surrogátne" → "surogátne" (sk. adaptácia latinského surrogatus: jedno r)
    'strava-tuky-kardiovaskularne-riziko-ckd-co-dava-zmysel-praxi' => [
        [
            'field'   => 'content',
            'find'    => 'surrogátne ukazovatele',
            'replace' => 'surogátne ukazovatele',
        ],
    ],

    // 4. Nový článok: slug "nizkosodovy" → "nizkosodikovy" + kompletná jazyková oprava
    //    Identifikujeme starý slug; slug, titul a excerpt sa aktualizujú priamo cez special_updates nižšie.
    'nizkosodovy-dialyzat-a-sodik-v-tkanivach-randomizovana-crossover-studia' => [
        [
            'field'   => 'content',
            'find'    => 'nízkosodíovým a vyšším sodíkovým dialyzátom.',
            'replace' => 'nízkosodíkovým a vyšším sodíkovým dialyzátom.',
        ],
        [
            'field'   => 'content',
            'find'    => 'nízkosodíový dialyzát: 132 mEq/L',
            'replace' => 'nízkosodíkový dialyzát: 132 mEq/L',
        ],
        [
            'field'   => 'content',
            'find'    => 'vyššiosodíový dialyzát: 138 mEq/L',
            'replace' => 'vyššiosodíkový dialyzát: 138 mEq/L',
        ],
        [
            'field'   => 'content',
            'find'    => 'pri nízkosodíovom dialyzáte:',
            'replace' => 'pri nízkosodíkovom dialyzáte:',
        ],
        [
            'field'   => 'content',
            'find'    => 'nízkosodíovom dialyzáte skôr klesali',
            'replace' => 'nízkosodíkovom dialyzáte skôr klesali',
        ],
        [
            'field'   => 'content',
            'find'    => 'Nízko-sodíový dialyzát bol spojený',
            'replace' => 'Nízkosodíkový dialyzát bol spojený',
        ],
        [
            'field'   => 'content',
            'find'    => 'nízkosodíovým a vyšším sodíkovým dialyzátom nevykázali',
            'replace' => 'nízkosodíkovým a vyšším sodíkovým dialyzátom nevykázali',
        ],
        [
            'field'   => 'content',
            'find'    => 'nízkosodíového dialyzátu na tkanivový',
            'replace' => 'nízkosodíkového dialyzátu na tkanivový',
        ],
    ],

];

// Priame aktualizácie polí (slug, titul, excerpt) pre nový článok
$special_updates = [
    'nizkosodovy-dialyzat-a-sodik-v-tkanivach-randomizovana-crossover-studia' => [
        'new_slug'   => 'nizkosodikovy-dialyzat-a-sodik-v-tkanivach-randomizovana-crossover-studia',
        'new_title'  => 'Nízkosodíkový dialyzát a sodík v tkanivách: čo ukázala randomizovaná crossover štúdia',
        'new_excerpt' => 'Randomizovaná crossover štúdia hodnotila vplyv nízkosodíkového dialyzátu (132 mEq/L sodíka) oproti vyššiosodíkovému (138 mEq/L) na tkanivový sodík (koža, sval) meraný pomocou ²³Na MRI. Celkové rozdiely neboli štatisticky významné, no upravené analýzy ukázali asociáciu s poklesom sodíka v koži a zdôraznili úlohu ultrafiltrácie.',
    ],
];

// ── Aplikovanie korekcií (str_replace) ───────────────────────────────────────

$totalFixed   = 0;
$totalSkipped = 0;
$errors       = [];

foreach ($corrections as $slug => $fixes) {
    $stmt = $pdo->prepare('SELECT id, title, content, excerpt FROM articles WHERE slug = :slug LIMIT 1');
    $stmt->execute(['slug' => $slug]);
    $row = $stmt->fetch();

    if (!$row) {
        $errors[] = "Článok nenájdený (slug: $slug)";
        echo "  !! [$slug] — nenájdený v DB\n";
        continue;
    }

    $id      = $row['id'];
    $changed = false;

    foreach ($fixes as $fix) {
        $field    = $fix['field'];
        $find     = $fix['find'];
        $replace  = $fix['replace'];
        $original = $row[$field];

        if (str_contains($original, $find)) {
            $row[$field] = str_replace($find, $replace, $original);
            $changed     = true;
            $label       = mb_strimwidth($find, 0, 60, '…');
            echo "  OK [$slug] $field: '$label'\n";
        } else {
            $label = mb_strimwidth($find, 0, 60, '…');
            echo "  -- [$slug] $field: nenájdené (možno už opravené): '$label'\n";
            $totalSkipped++;
        }
    }

    // Priame polia (slug, title, excerpt) — len ak existuje special_update pre tento slug
    if (isset($special_updates[$slug])) {
        $su = $special_updates[$slug];
        if (isset($su['new_title'])) {
            $row['title'] = $su['new_title'];
            $changed = true;
            echo "  OK [$slug] title: priama aktualizácia\n";
        }
        if (isset($su['new_excerpt'])) {
            $row['excerpt'] = $su['new_excerpt'];
            $changed = true;
            echo "  OK [$slug] excerpt: priama aktualizácia\n";
        }
    }

    if ($changed) {
        try {
            $upd = $pdo->prepare(
                'UPDATE articles SET title = :title, content = :content, excerpt = :excerpt WHERE id = :id'
            );
            $upd->execute([
                'title'   => $row['title'],
                'content' => $row['content'],
                'excerpt' => $row['excerpt'],
                'id'      => $id,
            ]);

            // Ak treba zmeniť aj slug, urobíme to zvlášť
            if (isset($special_updates[$slug]['new_slug'])) {
                $newSlug = $special_updates[$slug]['new_slug'];
                $slugUpd = $pdo->prepare('UPDATE articles SET slug = :slug WHERE id = :id');
                $slugUpd->execute(['slug' => $newSlug, 'id' => $id]);
                echo "  OK [$slug] slug: '$slug' → '$newSlug'\n";
            }

            $totalFixed++;
        } catch (\PDOException $e) {
            $errors[] = "UPDATE zlyhal pre slug=$slug: " . $e->getMessage();
            error_log('update_articles_proofread2 error: ' . $e->getMessage());
        }
    }
}

// ── Výstup ────────────────────────────────────────────────────────────────────

echo "\n";
echo "──────────────────────────────────────────────────────\n";
echo "Korektúra 2 dokončená\n";
echo "──────────────────────────────────────────────────────\n";
echo "Opravených článkov:    $totalFixed\n";
echo "Preskočených korekcií: $totalSkipped (hľadaný text nenájdený)\n";
if (!empty($errors)) {
    echo "\nChyby:\n";
    foreach ($errors as $e) {
        echo "  - $e\n";
    }
}
echo "──────────────────────────────────────────────────────\n\n";
?>
