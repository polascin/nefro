<?php

declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/drugs_common.php';

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";

$slug = strtolower(trim((string) ($_GET['slug'] ?? '')));
$drug = null;
if (preg_match('/^[a-z0-9-]{1,120}$/', $slug) === 1) {
    try {
        $drug = dgFetchDrug($pdo, $slug);
    } catch (\PDOException $e) {
        error_log('liek.php fetch error: ' . $e->getMessage());
    }
}

if ($drug === null) {
    http_response_code(404);
}

/** Pomocník: kurátorská sekcia s nadpisom (riadkovanie zachované). */
function dgSection(string $id, string $title, ?string $body): void
{
    if ($body === null || trim($body) === '') {
        return;
    }
    echo '<section class="form-section" aria-labelledby="' . htmlspecialchars($id) . '">';
    echo '<h3 id="' . htmlspecialchars($id) . '">' . htmlspecialchars($title) . '</h3>';
    echo '<p>' . nl2br(htmlspecialchars($body)) . '</p>';
    echo '</section>';
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  if ($drug !== null) {
      $pageTitle = htmlspecialchars((string) $drug['name_sk']) . " — liek v nefrológii | " . $siteName;
      $seoDescription = mb_substr(trim(strip_tags((string) ($drug['mechanism'] ?? $drug['name_sk']))), 0, 200);
      $canonicalUrl = $baseUrl . "liek.php?slug=" . urlencode($slug);
      $structuredData = [
          [
              "@context" => "https://schema.org",
              "@type" => "Drug",
              "name" => (string) $drug['name_sk'],
              "nonProprietaryName" => (string) ($drug['name_intl'] ?? ''),
              "url" => $canonicalUrl,
              "mechanismOfAction" => (string) ($drug['mechanism'] ?? ''),
              "code" => $drug['atc_code'] !== null
                  ? ["@type" => "MedicalCode", "codingSystem" => "ATC", "codeValue" => (string) $drug['atc_code']]
                  : null,
          ],
          [
              "@context" => "https://schema.org",
              "@type" => "BreadcrumbList",
              "itemListElement" => [
                  ["@type" => "ListItem", "position" => 1, "name" => "Domov", "item" => $baseUrl],
                  ["@type" => "ListItem", "position" => 2, "name" => "Lieky", "item" => $baseUrl . "lieky.php"],
                  ["@type" => "ListItem", "position" => 3, "name" => (string) $drug['name_sk'], "item" => $canonicalUrl],
              ],
          ],
      ];
  } else {
      $pageTitle = "Liek sa nenašiel | Lieky | " . $siteName;
      $seoDescription = "Požadovaný liek sa v databáze nenašiel.";
      $canonicalUrl = $baseUrl . "lieky.php";
      $robotsMeta = 'noindex, follow';
  }
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Liek v nefrológii";
    $headerIntro = $drug !== null ? "Detail z kurátorskej databázy" : "";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <?php if ($drug === null): ?>
                <div class="auth-container">
                    <h2>Liek sa nenašiel</h2>
                    <div class="alert alert-error"><p>Požadovaný liek nie je v našej databáze (alebo nie je zverejnený). Skontrolujte odkaz.</p></div>
                    <p class="mt-30"><a href="lieky.php" class="btn-primary">← Späť na zoznam liekov</a></p>
                </div>
            <?php else:
                $synonyms = dgDecodeJsonList($drug['synonyms'] ?? null);
                $sources = dgDecodeJsonList($drug['source_refs'] ?? null);
                $routesLabel = dgRoutesLabel($drug['routes'] ?? null);
                $phaseLabel = dgPhaseLabel($drug['max_phase'] !== null ? (int) $drug['max_phase'] : null);
            ?>
                <article class="auth-container auth-container--wide">
                    <p class="calc-result-detail"><a href="lieky.php">← Lieky</a>
                        <?php if (!empty($drug['category'])): ?> &ensp;&bull;&ensp; <a href="lieky.php?kat=<?= urlencode((string) $drug['category']) ?>"><?= htmlspecialchars(dgCategoryLabel((string) $drug['category'])) ?></a><?php endif; ?>
                    </p>
                    <h2><?= htmlspecialchars((string) $drug['name_sk']) ?></h2>
                    <?php if (!empty($drug['name_intl']) && strcasecmp((string) $drug['name_intl'], (string) $drug['name_sk']) !== 0): ?>
                        <p class="auth-subtitle">INN: <?= htmlspecialchars((string) $drug['name_intl']) ?></p>
                    <?php endif; ?>

                    <div class="info-box">
                        <?php if (!empty($drug['drug_class'])): ?><strong><?= htmlspecialchars((string) $drug['drug_class']) ?></strong><?php endif; ?>
                        <?php if ($phaseLabel !== ''): ?> &ensp;&bull;&ensp; <?= htmlspecialchars($phaseLabel) ?><?php endif; ?>
                        <?php if (!empty($drug['first_approval'])): ?> &ensp;&bull;&ensp; schválený <?= (int) $drug['first_approval'] ?><?php endif; ?>
                        <?php if ($routesLabel !== ''): ?> &ensp;&bull;&ensp; <?= htmlspecialchars($routesLabel) ?><?php endif; ?>
                        <?php if (!empty($drug['atc_code'])): ?> &ensp;&bull;&ensp; ATC <a href="<?= htmlspecialchars(dgAtcUrl((string) $drug['atc_code'])) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars((string) $drug['atc_code']) ?></a><?php endif; ?>
                    </div>

                    <?php if ((int) ($drug['black_box_warning'] ?? 0) === 1 || (int) ($drug['withdrawn'] ?? 0) === 1): ?>
                        <div class="info-box-yellow">
                            <?php if ((int) ($drug['black_box_warning'] ?? 0) === 1): ?><strong>⚠ FDA black box warning</strong> — liek má závažné bezpečnostné upozornenie.<?php endif; ?>
                            <?php if ((int) ($drug['withdrawn'] ?? 0) === 1): ?><br><strong>Stiahnutý z trhu</strong> v niektorých krajinách.<?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Renálne dávkovanie — najdôležitejšia kurátorská sekcia (zvýraznená).
                    if (!empty($drug['renal_dosing'])): ?>
                        <section class="info-box-blue" aria-labelledby="renal-h">
                            <h3 id="renal-h">🫘 Dávkovanie podľa funkcie obličiek</h3>
                            <p><?= nl2br(htmlspecialchars((string) $drug['renal_dosing'])) ?></p>
                        </section>
                    <?php endif; ?>

                    <?php
                    dgSection('mech-h', 'Mechanizmus účinku', $drug['mechanism'] ?? null);
                    dgSection('ind-h', 'Indikácie (nefrologicky relevantné)', $drug['indications'] ?? null);
                    dgSection('nephrotox-h', 'Nefrotoxicita', $drug['nephrotoxicity'] ?? null);
                    dgSection('dial-h', 'Dialyzovateľnosť', $drug['dialyzability'] ?? null);
                    dgSection('warn-h', 'Upozornenia', $drug['warnings'] ?? null);
                    dgSection('mon-h', 'Monitorovanie', $drug['monitoring'] ?? null);
                    dgSection('sknote-h', 'Slovenský kontext', $drug['sk_note'] ?? null);
                    ?>

                    <?php if ($synonyms !== []): ?>
                        <section class="form-section" aria-labelledby="syn-h">
                            <h3 id="syn-h">Obchodné názvy</h3>
                            <p><?= htmlspecialchars(implode(', ', array_slice(array_map('strval', $synonyms), 0, 20))) ?></p>
                        </section>
                    <?php endif; ?>

                    <section class="form-section" aria-labelledby="calc-h">
                        <h3 id="calc-h">Súvisiace kalkulačky</h3>
                        <p>
                            <a href="calculator_egfr.php">eGFR (CKD-EPI)</a> &ensp;&bull;&ensp;
                            <a href="calculator_cg.php">Cockcroft-Gault (CrCl)</a>
                        </p>
                    </section>

                    <div class="info-box-yellow">
                        <strong>Dôležité upozornenie:</strong> informácie sú <strong>orientačné</strong> a
                        <strong>nenahrádzajú</strong> oficiálne SPC, klinický úsudok ani konzultáciu s lekárom
                        či lekárnikom. Dávkovanie pri poruche funkcie obličiek vždy overte v aktuálnom SPC a
                        podľa konkrétneho pacienta.
                    </div>

                    <div class="form-actions">
                        <?php if (!empty($drug['chembl_id'])): ?>
                            <a href="<?= htmlspecialchars(dgChemblUrl((string) $drug['chembl_id'])) ?>" target="_blank" rel="noopener noreferrer" class="btn-primary">ChEMBL ↗</a>
                        <?php endif; ?>
                        <?php foreach ($sources as $src):
                            if (!is_array($src) || empty($src['url']) || empty($src['label'])) { continue; }
                            $u = (string) $src['url'];
                            if (!preg_match('#^https://#', $u)) { continue; }
                        ?>
                            <a href="<?= htmlspecialchars($u) ?>" target="_blank" rel="noopener noreferrer" class="btn-secondary"><?= htmlspecialchars((string) $src['label']) ?> ↗</a>
                        <?php endforeach; ?>
                        <a href="lieky.php" class="btn-secondary">← Späť na zoznam</a>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>
