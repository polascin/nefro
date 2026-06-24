<?php

declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/clinical_trials_common.php';

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";

$catLabels = ctCategoryLabels();
$selectedCat = (string) ($_GET['kat'] ?? '');
if ($selectedCat !== '' && !array_key_exists($selectedCat, $catLabels)) {
    $selectedCat = '';
}
$searchQuery = trim((string) ($_GET['q'] ?? ''));
if (mb_strlen($searchQuery) > 100) {
    $searchQuery = mb_substr($searchQuery, 0, 100);
}

$trials = [];
$counts = [];
$lastSync = null;
try {
    $trials = ctFetchTrials($pdo, $selectedCat, $searchQuery);
    $counts = ctCategoryCounts($pdo);
    $lastSync = ctLastSync($pdo);
} catch (\PDOException $e) {
    error_log('studie.php fetch error: ' . $e->getMessage());
}
$totalCount = array_sum($counts);
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Klinické štúdie v nefrológii | " . $siteName;
  $canonicalUrl = $baseUrl . "studie.php";
  $seoDescription =
      "Kurátorský register prebiehajúcich klinických štúdií relevantných pre nefrológiu (CKD, dialýza, transplantácia, glomerulopatie, onkonefrológia). Dáta z oficiálneho registra ClinicalTrials.gov, pravidelne aktualizované.";
  $seoKeywords =
      "klinické štúdie, nefrológia, CKD, dialýza, transplantácia obličky, glomerulonefritída, ClinicalTrials.gov, nábor pacientov, Slovensko";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => "CollectionPage",
          "name" => "Klinické štúdie v nefrológii",
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
              ["@type" => "ListItem", "position" => 2, "name" => "Klinické štúdie", "item" => $canonicalUrl],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Klinické štúdie v nefrológii";
    $headerIntro = "Kurátorský register z ClinicalTrials.gov";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <section class="primary-article">
                <h1 class="visually-hidden">Klinické štúdie v nefrológii</h1>
                <p>
                    Výber <strong>prebiehajúcich (náborových) intervenčných klinických štúdií</strong>
                    relevantných pre nefrológiu. Dáta čerpáme z oficiálneho registra
                    <a href="https://clinicaltrials.gov/" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>
                    (NIH/NLM) a pravidelne ich aktualizujeme.
                    <?php if ($lastSync !== null): ?>
                        Posledná synchronizácia: <strong><?= htmlspecialchars($lastSync) ?></strong>.
                    <?php endif; ?>
                </p>
                <div class="info-box-yellow">
                    <strong>Upozornenie:</strong> register je orientačný a <strong>nenahrádza</strong>
                    konzultáciu s ošetrujúcim lekárom. O účasti v štúdii rozhoduje skúšajúci podľa
                    vstupných kritérií. Aktuálny stav, kritériá a kontakty vždy overte priamo na
                    ClinicalTrials.gov.
                </div>
            </section>

            <nav class="quick-nav-calculators" aria-label="Filter podľa kategórie">
                <div class="container">
                    <ul class="quick-nav-list">
                        <li>
                            <?php if ($selectedCat === ''): ?>
                                <a href="studie.php" class="active" aria-current="page">Všetky (<?= (int) $totalCount ?>)</a>
                            <?php else: ?>
                                <a href="studie.php">Všetky (<?= (int) $totalCount ?>)</a>
                            <?php endif; ?>
                        </li>
                        <?php foreach ($catLabels as $slug => $label): ?>
                            <?php $n = (int) ($counts[$slug] ?? 0); if ($n === 0) { continue; } ?>
                            <li>
                                <?php if ($selectedCat === $slug): ?>
                                    <a href="studie.php?kat=<?= urlencode($slug) ?>" class="active" aria-current="page"><?= htmlspecialchars($label) ?> (<?= $n ?>)</a>
                                <?php else: ?>
                                    <a href="studie.php?kat=<?= urlencode($slug) ?>"><?= htmlspecialchars($label) ?> (<?= $n ?>)</a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>

            <section class="form-section" aria-label="Vyhľadávanie v štúdiách">
                <form method="GET" action="studie.php" class="form-grid">
                    <?php if ($selectedCat !== ''): ?>
                        <input type="hidden" name="kat" value="<?= htmlspecialchars($selectedCat) ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="q">Hľadať (názov, ochorenie, sponzor)</label>
                        <input type="search" id="q" name="q" class="form-control" maxlength="100" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="napr. IgA nefropatia, SGLT2, finerenón">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Hľadať</button>
                        <?php if ($searchQuery !== '' || $selectedCat !== ''): ?>
                            <a href="studie.php" class="btn-secondary">Zrušiť filtre</a>
                        <?php endif; ?>
                    </div>
                </form>
            </section>

            <section class="features-section" aria-labelledby="trials-heading">
                <h2 id="trials-heading">
                    <?= $selectedCat !== '' ? htmlspecialchars($catLabels[$selectedCat]) : 'Všetky štúdie' ?>
                    <span class="calc-result-unit">(<?= count($trials) ?>)</span>
                </h2>

                <?php if ($trials === []): ?>
                    <div class="info-box"><p>Pre zvolený filter sa nenašli žiadne štúdie. Skúste iný filter alebo
                        <a href="studie.php">zobrazte všetky</a>.</p></div>
                <?php else: ?>
                    <div class="features-grid calculators-grid">
                        <?php foreach ($trials as $t):
                            $nct = (string) $t['nct_id'];
                            $conds = ctDecodeJsonList($t['conditions'] ?? null);
                            $countries = ctDecodeJsonList($t['countries'] ?? null);
                        ?>
                            <article class="feature-card calculator-card">
                                <h3>
                                    <a href="studia.php?nct=<?= urlencode($nct) ?>"><?= htmlspecialchars((string) $t['brief_title']) ?></a>
                                </h3>
                                <p class="calc-result-detail">
                                    <strong><?= htmlspecialchars(ctCategoryLabel((string) $t['category'])) ?></strong>
                                    &ensp;&bull;&ensp; <?= htmlspecialchars(ctStatusLabel($t['overall_status'] ?? null)) ?>
                                    &ensp;&bull;&ensp; <?= htmlspecialchars(ctPhaseLabel($t['phase'] ?? null)) ?>
                                    <?php if (!empty($t['sk_note'])): ?> &ensp;&bull;&ensp; <span class="badge-top-sm" title="Obsahuje slovenský kontext">SK kontext</span><?php endif; ?>
                                </p>
                                <?php if ($conds !== []): ?>
                                    <p><strong>Ochorenia:</strong> <?= htmlspecialchars(implode(', ', array_slice(array_map('strval', $conds), 0, 4))) ?><?= count($conds) > 4 ? '…' : '' ?></p>
                                <?php endif; ?>
                                <?php if (!empty($t['lead_sponsor'])): ?>
                                    <p><strong>Sponzor:</strong> <?= htmlspecialchars((string) $t['lead_sponsor']) ?></p>
                                <?php endif; ?>
                                <p class="calc-result-detail">
                                    <?= $t['enrollment'] !== null ? 'Plán. počet: ' . (int) $t['enrollment'] . ' &ensp;&bull;&ensp; ' : '' ?>
                                    <?php if (!empty($t['last_update_posted'])): ?>Aktualizované: <?= htmlspecialchars((string) $t['last_update_posted']) ?><?php endif; ?>
                                    <?php if ($countries !== []): ?> &ensp;&bull;&ensp; <?= htmlspecialchars(implode(', ', array_slice(array_map('strval', $countries), 0, 3))) ?><?= count($countries) > 3 ? '…' : '' ?><?php endif; ?>
                                </p>
                                <a href="studia.php?nct=<?= urlencode($nct) ?>" class="btn-primary">Detail štúdie</a>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <div class="info-box-green">
                <strong>Zdroj:</strong> <a href="https://clinicaltrials.gov/" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>
                (U.S. National Library of Medicine). Register je verejný; uvedené údaje sú orientačné a podliehajú zmenám.
            </div>
        </div>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>
