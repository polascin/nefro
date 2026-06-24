<?php

declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/drugs_common.php';

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";

$catLabels = dgCategoryLabels();
$selectedCat = (string) ($_GET['kat'] ?? '');
if ($selectedCat !== '' && !array_key_exists($selectedCat, $catLabels)) {
    $selectedCat = '';
}
$searchQuery = trim((string) ($_GET['q'] ?? ''));
if (mb_strlen($searchQuery) > 100) {
    $searchQuery = mb_substr($searchQuery, 0, 100);
}

$drugs = [];
$counts = [];
$lastSync = null;
try {
    $drugs = dgFetchDrugs($pdo, $selectedCat, $searchQuery);
    $counts = dgCategoryCounts($pdo);
    $lastSync = dgLastSync($pdo);
} catch (\PDOException $e) {
    error_log('lieky.php fetch error: ' . $e->getMessage());
}
$totalCount = array_sum($counts);
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Lieky v nefrológii — databáza | " . $siteName;
  $canonicalUrl = $baseUrl . "lieky.php";
  $seoDescription =
      "Kurátorská databáza liekov relevantných v nefrológii: úprava dávkovania podľa funkcie obličiek, nefrotoxicita, dialyzovateľnosť a upozornenia. Farmakológia z ChEMBL, klinický kontext z SPC (ŠÚKL/EMA).";
  $seoKeywords =
      "lieky, nefrológia, dávkovanie podľa eGFR, nefrotoxicita, dialyzovateľnosť, SGLT2, finerenón, GLP-1, ChEMBL, ŠÚKL, EMA";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => "CollectionPage",
          "name" => "Lieky v nefrológii",
          "description" => $seoDescription,
          "url" => $canonicalUrl,
          "inLanguage" => "sk-SK",
          "isPartOf" => ["@type" => "WebSite", "name" => $siteName, "url" => $baseUrl],
      ],
      [
          "@context" => "https://schema.org",
          "@type" => "BreadcrumbList",
          "itemListElement" => [
              ["@type" => "ListItem", "position" => 1, "name" => "Domov", "item" => $baseUrl],
              ["@type" => "ListItem", "position" => 2, "name" => "Lieky", "item" => $canonicalUrl],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Lieky v nefrológii";
    $headerIntro = "Kurátorská databáza s dôrazom na funkciu obličiek";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <section class="primary-article">
                <h1 class="visually-hidden">Lieky v nefrológii</h1>
                <p>
                    Kurátorský prehľad liekov relevantných v nefrológii — s dôrazom na
                    <strong>úpravu dávkovania podľa funkcie obličiek</strong>, nefrotoxicitu,
                    dialyzovateľnosť a klinické upozornenia. Farmakologické údaje čerpáme
                    z databázy <a href="https://www.ebi.ac.uk/chembl/" target="_blank" rel="noopener noreferrer">ChEMBL</a>
                    (EMBL-EBI); klinický kontext dopĺňame z SPC (ŠÚKL/EMA).
                    <?php if ($lastSync !== null): ?>
                        Posledná synchronizácia farmakológie: <strong><?= htmlspecialchars($lastSync) ?></strong>.
                    <?php endif; ?>
                </p>
                <div class="info-box-yellow">
                    <strong>Dôležité upozornenie:</strong> tieto informácie sú <strong>orientačné</strong>
                    a <strong>nenahrádzajú</strong> oficiálne SPC, klinický úsudok ani konzultáciu
                    s lekárom či lekárnikom. Dávkovanie pri poruche funkcie obličiek vždy overte
                    v aktuálnom SPC a podľa konkrétneho pacienta. Nejde o odporúčanie liečby.
                </div>
            </section>

            <nav class="quick-nav-calculators" aria-label="Filter podľa kategórie">
                <div class="container">
                    <ul class="quick-nav-list">
                        <li>
                            <?php if ($selectedCat === ''): ?>
                                <a href="lieky.php" class="active" aria-current="page">Všetky (<?= (int) $totalCount ?>)</a>
                            <?php else: ?>
                                <a href="lieky.php">Všetky (<?= (int) $totalCount ?>)</a>
                            <?php endif; ?>
                        </li>
                        <?php foreach ($catLabels as $slug => $label): ?>
                            <?php $n = (int) ($counts[$slug] ?? 0); if ($n === 0) { continue; } ?>
                            <li>
                                <?php if ($selectedCat === $slug): ?>
                                    <a href="lieky.php?kat=<?= urlencode($slug) ?>" class="active" aria-current="page"><?= htmlspecialchars($label) ?> (<?= $n ?>)</a>
                                <?php else: ?>
                                    <a href="lieky.php?kat=<?= urlencode($slug) ?>"><?= htmlspecialchars($label) ?> (<?= $n ?>)</a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>

            <section class="form-section" aria-label="Vyhľadávanie v liekoch">
                <form method="GET" action="lieky.php" class="form-grid">
                    <?php if ($selectedCat !== ''): ?>
                        <input type="hidden" name="kat" value="<?= htmlspecialchars($selectedCat) ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="q">Hľadať (názov, trieda, ATC)</label>
                        <input type="search" id="q" name="q" class="form-control" maxlength="100" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="napr. dapagliflozín, ACE inhibítor, A10BK">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Hľadať</button>
                        <?php if ($searchQuery !== '' || $selectedCat !== ''): ?>
                            <a href="lieky.php" class="btn-secondary">Zrušiť filtre</a>
                        <?php endif; ?>
                    </div>
                </form>
            </section>

            <section class="features-section" aria-labelledby="drugs-heading">
                <h2 id="drugs-heading">
                    <?= $selectedCat !== '' ? htmlspecialchars($catLabels[$selectedCat]) : 'Všetky lieky' ?>
                    <span class="calc-result-unit">(<?= count($drugs) ?>)</span>
                </h2>

                <?php if ($drugs === []): ?>
                    <div class="info-box"><p>Pre zvolený filter sa nenašli žiadne lieky. Skúste iný filter alebo
                        <a href="lieky.php">zobrazte všetky</a>.</p></div>
                <?php else: ?>
                    <div class="features-grid calculators-grid">
                        <?php foreach ($drugs as $d):
                            $slug = (string) $d['slug'];
                        ?>
                            <article class="feature-card calculator-card">
                                <h3>
                                    <a href="liek.php?slug=<?= urlencode($slug) ?>"><?= htmlspecialchars((string) $d['name_sk']) ?></a>
                                </h3>
                                <p class="calc-result-detail">
                                    <strong><?= htmlspecialchars(dgCategoryLabel((string) $d['category'])) ?></strong>
                                    <?php if (!empty($d['drug_class'])): ?> &ensp;&bull;&ensp; <?= htmlspecialchars((string) $d['drug_class']) ?><?php endif; ?>
                                    <?php if ((int) ($d['black_box_warning'] ?? 0) === 1): ?> &ensp;&bull;&ensp; <span class="badge-draft" title="FDA black box warning">⚠ Black box</span><?php endif; ?>
                                </p>
                                <?php if (!empty($d['name_intl']) && strcasecmp((string) $d['name_intl'], (string) $d['name_sk']) !== 0): ?>
                                    <p><strong>INN:</strong> <?= htmlspecialchars((string) $d['name_intl']) ?><?php if (!empty($d['atc_code'])): ?> &ensp;&bull;&ensp; ATC <?= htmlspecialchars((string) $d['atc_code']) ?><?php endif; ?></p>
                                <?php elseif (!empty($d['atc_code'])): ?>
                                    <p><strong>ATC:</strong> <?= htmlspecialchars((string) $d['atc_code']) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($d['renal_dosing'])): ?>
                                    <p class="calc-result-detail">🫘 Obsahuje úpravu dávkovania podľa obličiek</p>
                                <?php endif; ?>
                                <a href="liek.php?slug=<?= urlencode($slug) ?>" class="btn-primary">Detail lieku</a>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <div class="info-box-green">
                <strong>Zdroje:</strong> farmakológia — <a href="https://www.ebi.ac.uk/chembl/" target="_blank" rel="noopener noreferrer">ChEMBL</a>
                (EMBL-EBI); klinický kontext a dávkovanie — oficiálne SPC (<a href="https://www.sukl.sk/" target="_blank" rel="noopener noreferrer">ŠÚKL</a>,
                <a href="https://www.ema.europa.eu/" target="_blank" rel="noopener noreferrer">EMA</a>). Údaje sú orientačné a podliehajú zmenám.
            </div>
        </div>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>
