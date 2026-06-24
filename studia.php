<?php

declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/clinical_trials_common.php';

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";

$nct = strtoupper(trim((string) ($_GET['nct'] ?? '')));
$trial = null;
if (preg_match('/^NCT\d{8}$/', $nct) === 1) {
    try {
        $trial = ctFetchTrial($pdo, $nct);
    } catch (\PDOException $e) {
        error_log('studia.php fetch error: ' . $e->getMessage());
    }
}

if ($trial === null) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  if ($trial !== null) {
      $pageTitle = htmlspecialchars((string) $trial['brief_title']) . " | Klinické štúdie | " . $siteName;
      $seoDescription = mb_substr(trim(strip_tags((string) ($trial['brief_summary'] ?? $trial['brief_title']))), 0, 200);
      $canonicalUrl = $baseUrl . "studia.php?nct=" . urlencode($nct);
      $structuredData = [
          [
              "@context" => "https://schema.org",
              "@type" => "MedicalStudy",
              "name" => (string) $trial['brief_title'],
              "url" => $canonicalUrl,
              "sameAs" => ctSourceUrl($nct),
              "studySubject" => (string) ($trial['conditions'] !== null ? implode(', ', ctDecodeJsonList((string) $trial['conditions'])) : ''),
              "sponsor" => ["@type" => "Organization", "name" => (string) ($trial['lead_sponsor'] ?? '')],
          ],
          [
              "@context" => "https://schema.org",
              "@type" => "BreadcrumbList",
              "itemListElement" => [
                  ["@type" => "ListItem", "position" => 1, "name" => "Domov", "item" => $baseUrl],
                  ["@type" => "ListItem", "position" => 2, "name" => "Klinické štúdie", "item" => $baseUrl . "studie.php"],
                  ["@type" => "ListItem", "position" => 3, "name" => (string) $trial['brief_title'], "item" => $canonicalUrl],
              ],
          ],
      ];
  } else {
      $pageTitle = "Štúdia sa nenašla | Klinické štúdie | " . $siteName;
      $seoDescription = "Požadovaná klinická štúdia sa v registri nenašla.";
      $canonicalUrl = $baseUrl . "studie.php";
      $robotsMeta = 'noindex, follow';
  }
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Klinická štúdia";
    $headerIntro = $trial !== null ? "Detail z registra ClinicalTrials.gov" : "";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <?php if ($trial === null): ?>
                <div class="auth-container">
                    <h2>Štúdia sa nenašla</h2>
                    <div class="alert alert-error"><p>Požadovaná štúdia nie je v našom registri (alebo nie je publikovaná). Skontrolujte identifikátor NCT.</p></div>
                    <p class="mt-30"><a href="studie.php" class="btn-primary">← Späť na zoznam štúdií</a></p>
                </div>
            <?php else:
                $conds = ctDecodeJsonList($trial['conditions'] ?? null);
                $interv = ctDecodeJsonList($trial['interventions'] ?? null);
                $countries = ctDecodeJsonList($trial['countries'] ?? null);
            ?>
                <article class="auth-container auth-container--wide">
                    <p class="calc-result-detail"><a href="studie.php">← Klinické štúdie</a>
                        <?php if (!empty($trial['category'])): ?> &ensp;&bull;&ensp; <a href="studie.php?kat=<?= urlencode((string) $trial['category']) ?>"><?= htmlspecialchars(ctCategoryLabel((string) $trial['category'])) ?></a><?php endif; ?>
                    </p>
                    <h2><?= htmlspecialchars((string) $trial['brief_title']) ?></h2>
                    <?php if (!empty($trial['official_title']) && $trial['official_title'] !== $trial['brief_title']): ?>
                        <p class="auth-subtitle"><?= htmlspecialchars((string) $trial['official_title']) ?></p>
                    <?php endif; ?>

                    <div class="info-box">
                        <strong><?= htmlspecialchars(ctStatusLabel($trial['overall_status'] ?? null)) ?></strong>
                        &ensp;&bull;&ensp; <?= htmlspecialchars(ctPhaseLabel($trial['phase'] ?? null)) ?>
                        &ensp;&bull;&ensp; <?= htmlspecialchars((string) ($trial['study_type'] === 'INTERVENTIONAL' ? 'intervenčná' : (string) $trial['study_type'])) ?>
                        &ensp;&bull;&ensp; <abbr title="ClinicalTrials.gov identifikátor"><?= htmlspecialchars($nct) ?></abbr>
                    </div>

                    <?php if (!empty($trial['brief_summary'])): ?>
                        <section class="form-section" aria-labelledby="sum-h">
                            <h3 id="sum-h">Stručný súhrn</h3>
                            <p><?= nl2br(htmlspecialchars((string) $trial['brief_summary'])) ?></p>
                        </section>
                    <?php endif; ?>

                    <section class="form-section" aria-labelledby="meta-h">
                        <h3 id="meta-h">Základné údaje</h3>
                        <table class="tool-table">
                            <caption class="visually-hidden">Základné údaje o štúdii</caption>
                            <tbody>
                                <?php if ($conds !== []): ?>
                                    <tr><th scope="row">Ochorenia</th><td><?= htmlspecialchars(implode(', ', array_map('strval', $conds))) ?></td></tr>
                                <?php endif; ?>
                                <?php if ($interv !== []): ?>
                                    <tr><th scope="row">Intervencie</th><td>
                                        <?php
                                        $parts = [];
                                        foreach ($interv as $iv) {
                                            if (is_array($iv) && !empty($iv['name'])) {
                                                $t = (string) ($iv['type'] ?? '');
                                                $parts[] = ($t !== '' ? htmlspecialchars($t) . ': ' : '') . htmlspecialchars((string) $iv['name']);
                                            }
                                        }
                                        echo implode('<br>', $parts);
                                        ?>
                                    </td></tr>
                                <?php endif; ?>
                                <?php if (!empty($trial['lead_sponsor'])): ?>
                                    <tr><th scope="row">Sponzor</th><td><?= htmlspecialchars((string) $trial['lead_sponsor']) ?></td></tr>
                                <?php endif; ?>
                                <?php if ($trial['enrollment'] !== null): ?>
                                    <tr><th scope="row">Plánovaný počet</th><td><?= (int) $trial['enrollment'] ?></td></tr>
                                <?php endif; ?>
                                <?php if (!empty($trial['start_date'])): ?>
                                    <tr><th scope="row">Začiatok</th><td><?= htmlspecialchars((string) $trial['start_date']) ?></td></tr>
                                <?php endif; ?>
                                <?php if (!empty($trial['completion_date'])): ?>
                                    <tr><th scope="row">Predp. ukončenie (primárne)</th><td><?= htmlspecialchars((string) $trial['completion_date']) ?></td></tr>
                                <?php endif; ?>
                                <?php if ($countries !== []): ?>
                                    <tr><th scope="row">Krajiny</th><td><?= htmlspecialchars(implode(', ', array_map('strval', $countries))) ?></td></tr>
                                <?php endif; ?>
                                <?php if (!empty($trial['last_update_posted'])): ?>
                                    <tr><th scope="row">Posledná aktualizácia</th><td><?= htmlspecialchars((string) $trial['last_update_posted']) ?></td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </section>

                    <div class="info-box-yellow">
                        <strong>Upozornenie:</strong> údaje sú orientačné a podliehajú zmenám. Úplné vstupné/vylučovacie
                        kritériá, kontakty a aktuálny stav nájdete v oficiálnom registri. Tento prehľad
                        <strong>nenahrádza</strong> lekársku konzultáciu.
                    </div>

                    <div class="form-actions">
                        <a href="<?= htmlspecialchars(ctSourceUrl($nct)) ?>" target="_blank" rel="noopener noreferrer" class="btn-primary">Otvoriť na ClinicalTrials.gov</a>
                        <a href="studie.php" class="btn-secondary">← Späť na zoznam</a>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>
