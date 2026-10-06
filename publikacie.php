<?php

declare(strict_types=1);
/**
 * publikacie.php — Katalóg publikácií
 * ────────────────────────────────────────────────────────────────────────────
 * Rozcestník bezplatných aj rozšírených publikácií. Zdroj pravdy o
 * katalógu je `publications_common.php`.
 *
 * Celý obsah portálu zostáva voľne dostupný — publikácie sú zviazaný,
 * skorigovaný a offline čitateľný výber toho istého obsahu, nie paywall.
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/publications_common.php';

$siteName = 'Nefro-projekt Slovensko';
$baseUrl  = 'https://nefro.polascin.net/';

$catalogue = array_values(array_filter(
    publications(),
    static fn (array $p): bool => (bool) $p['is_available']
));
$freeCatalogue = freePublications();
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle       = 'Publikácie | ' . $siteName;
  $canonicalUrl    = $baseUrl . 'publikacie.php';
  $seoDescription  = 'Bezplatné aj rozšírené e-knihy z portálu Nefro-projekt Slovensko '
      . 'o nefrológii, dialýze a internej medicíne. PDF na priame stiahnutie aj viacformátové vydania.';
  $seoKeywords     = 'nefrológia e-kniha, SK Nefro Báza, publikácie nefrológia, CKD kniha, '
      . 'dialýza e-book, odborná literatúra nefrológia';
  $ogImage         = $baseUrl . ($freeCatalogue[0]['cover_small'] ?? 'img/og-default.jpg');
  $ogImageWidth    = 909;
  $ogImageHeight   = 1286;

  $itemList = [];
  foreach ($freeCatalogue as $publication) {
      $itemList[] = [
          '@type'    => 'ListItem',
          'position' => count($itemList) + 1,
          'url'      => $baseUrl . $publication['file'],
          'name'     => $publication['title'],
      ];
  }
  foreach ($catalogue as $i => $publication) {
      $itemList[] = [
          '@type'    => 'ListItem',
          'position' => count($itemList) + 1,
          'url'      => $baseUrl . 'publikacia.php?slug=' . $publication['slug'],
          'name'     => $publication['title'],
      ];
  }

  $structuredData = [
      [
          '@context'    => 'https://schema.org',
          '@type'       => 'CollectionPage',
          'name'        => 'Publikácie — ' . $siteName,
          'description' => $seoDescription,
          'url'         => $canonicalUrl,
          'inLanguage'  => 'sk-SK',
      ],
      [
          '@context'        => 'https://schema.org',
          '@type'           => 'ItemList',
          'itemListElement' => $itemList,
      ],
      [
          '@context'        => 'https://schema.org',
          '@type'           => 'BreadcrumbList',
          'itemListElement' => [
              ['@type' => 'ListItem', 'position' => 1, 'name' => 'Domov', 'item' => $baseUrl],
              ['@type' => 'ListItem', 'position' => 2, 'name' => 'Publikácie', 'item' => $canonicalUrl],
          ],
      ],
  ];
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Publikácie';
    $headerIntro = 'Odborný obsah portálu v prehľadných e-knihách';
    $showLogo    = false;
    include 'header.php';
    ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">

            <section class="pub-intro">
                <h2>E-knihy z portálu</h2>
                <p class="pub-intro__lead">
                    Články na portáli zostávajú <strong>voľne dostupné a bez paywallu</strong>.
                    Nižšie nájdete bezplatné tematické publikácie na priame stiahnutie aj
                    rozsiahle vydania celého ročníka vo viacerých formátoch.
                </p>
            </section>

            <section class="pub-section pub-section--free" aria-labelledby="pub-free-heading">
                <div class="pub-section__heading">
                    <div>
                        <p class="pub-section__eyebrow">Voľne dostupné</p>
                        <h2 id="pub-free-heading">Bezplatné publikácie</h2>
                    </div>
                    <p>Bez registrácie a objednávky, prednostne v PDF alebo v ďalších formátoch.</p>
                </div>
                <ul class="pub-free-grid">
                    <?php foreach ($freeCatalogue as $publication): ?>
                        <li class="pub-free-card">
                            <a href="<?= htmlspecialchars((string) $publication['file'], ENT_QUOTES) ?>" class="pub-free-card__cover-link" download
                               aria-label="Stiahnuť publikáciu <?= htmlspecialchars((string) $publication['title'], ENT_QUOTES) ?> vo formáte PDF">
                                <img src="<?= htmlspecialchars((string) $publication['cover_small'], ENT_QUOTES) ?>"
                                     alt="Obálka publikácie <?= htmlspecialchars((string) $publication['title'], ENT_QUOTES) ?>"
                                     class="pub-free-card__cover" width="909" height="1286" loading="lazy">
                            </a>
                            <div class="pub-free-card__body">
                                <p class="pub-free-card__meta"><span class="pub-free-badge">Zadarmo</span> PDF · <?= (int) $publication['pages'] ?> strán · <?= htmlspecialchars((string) $publication['language']) ?></p>
                                <h3 class="pub-free-card__title"><?= htmlspecialchars((string) $publication['title']) ?></h3>
                                <p class="pub-free-card__subtitle"><?= htmlspecialchars((string) $publication['subtitle']) ?></p>
                                <p class="pub-free-card__excerpt"><?= htmlspecialchars((string) $publication['excerpt']) ?></p>
                                <p class="pub-free-card__cta"><a href="<?= htmlspecialchars((string) $publication['file'], ENT_QUOTES) ?>" class="btn-primary"
                                   download="<?= htmlspecialchars((string) $publication['download_name'], ENT_QUOTES) ?>">Stiahnuť PDF zadarmo</a></p>
                                <div class="free-download-formats" aria-label="Ďalšie formáty na stiahnutie">
                                    <span class="free-download-formats__label">Ďalšie formáty:</span>
                                    <?php foreach (array_slice($publication['downloads'], 1) as $download): ?>
                                        <a href="<?= htmlspecialchars((string) $download['file'], ENT_QUOTES) ?>"
                                           download="<?= htmlspecialchars((string) $download['download_name'], ENT_QUOTES) ?>"><?= htmlspecialchars((string) $download['label']) ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <section class="pub-section" aria-labelledby="pub-extended-heading">
                <div class="pub-section__heading">
                    <div>
                        <p class="pub-section__eyebrow">Celý ročník</p>
                        <h2 id="pub-extended-heading">Rozšírené vydania</h2>
                    </div>
                    <p>Plné a kompendiálne vydania v slovenčine aj angličtine.</p>
                </div>

            <?php if ($catalogue === []): ?>
                <div class="info-box-gray">
                    <p>Momentálne nie je v ponuke žiadna publikácia. Pripravujeme ďalšie zväzky —
                       o novinkách informujeme v <a href="index.php#kontakt">newsletteri</a>.</p>
                </div>
            <?php else: ?>
                <ul class="pub-catalogue">
                    <?php foreach ($catalogue as $publication): ?>
                        <?php
                        $detailUrl   = 'publikacia.php?slug=' . urlencode((string) $publication['slug']);
                        $formatCodes = $publication['formats'];
                        ?>
                        <li class="pub-card">
                            <a href="<?= htmlspecialchars($detailUrl) ?>" class="pub-card__cover-link"
                               aria-label="Detail publikácie <?= htmlspecialchars((string) $publication['title']) ?>">
                                <img src="<?= htmlspecialchars((string) $publication['cover_small']) ?>"
                                     alt="Obálka publikácie <?= htmlspecialchars((string) $publication['title']) ?>"
                                     class="pub-card__cover" width="600" height="900" loading="lazy">
                            </a>
                            <div class="pub-card__body">
                                <h3 class="pub-card__title">
                                    <a href="<?= htmlspecialchars($detailUrl) ?>"><?= htmlspecialchars((string) $publication['title']) ?></a>
                                </h3>
                                <p class="pub-card__subtitle"><?= htmlspecialchars((string) $publication['subtitle']) ?></p>
                                <p class="pub-card__excerpt"><?= htmlspecialchars((string) $publication['excerpt']) ?></p>

                                <ul class="pub-card__meta">
                                    <li><?= (int) $publication['articles'] ?> článkov</li>
                                    <li><?= number_format((int) $publication['pages'], 0, ',', ' ') ?> strán</li>
                                    <?php /* Kompendium je bez obrázkov — „0 ilustrácií“ by znelo ako chyba. */ ?>
                                    <?php if ((int) $publication['images'] > 0): ?>
                                        <li><?= (int) $publication['images'] ?> ilustrácií</li>
                                    <?php endif; ?>
                                    <li><?= htmlspecialchars((string) $publication['edition']) ?></li>
                                    <li>jazyk: <strong><?= htmlspecialchars((string) $publication['language']) ?></strong></li>
                                </ul>

                                <p class="pub-card__formats">
                                    <span class="pub-card__formats-label">Formáty:</span>
                                    <?php foreach (publicationFormatLabels($formatCodes) as $label): ?>
                                        <span class="pub-format-badge"><?= htmlspecialchars($label) ?></span>
                                    <?php endforeach; ?>
                                </p>

                                <p class="pub-card__price">
                                    <span class="pub-card__price-main"><?= htmlspecialchars(formatPublicationPrice(PUBLICATION_PRICE_SINGLE)) ?></span>
                                    <span class="pub-card__price-note">za jeden formát · všetky formáty
                                        <?= htmlspecialchars(formatPublicationPrice(PUBLICATION_PRICE_BUNDLE)) ?></span>
                                </p>

                                <p class="pub-card__cta">
                                    <a href="<?= htmlspecialchars($detailUrl) ?>" class="btn-primary">Detail a objednávka</a>
                                </p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            </section>

            <section class="form-section" aria-labelledby="pub-ako-heading">
                <h3 id="pub-ako-heading">Ako nákup funguje</h3>
                <ol class="pub-steps">
                    <li>Vyberiete formáty a odošlete objednávku — stačí e-mailová adresa.</li>
                    <li>E-mailom dostanete platobné pokyny s variabilným symbolom a QR kódom.</li>
                    <li>Zaplatíte prevodom, alebo kartou a peňaženkou — Stripe, PayPal, Revolut,
                        Ko-fi, Viamo či kryptomenou.</li>
                    <li>Po potvrdení platby vám publikáciu pošleme e-mailom — súbory, ktoré sa
                        zmestia do prílohy, prídu priamo v nej; objemnejšie stiahnete na stránke
                        objednávky, ktorej odkaz máte v e-maile.</li>
                </ol>
                <div class="info-box-blue">
                    <p><strong>Žiadne platobné údaje na tejto stránke.</strong> Platbu spracúva
                       vaša banka alebo vybraná platobná služba; portál nevidí ani neuchováva
                       čísla kariet a prihlasovacie údaje do internetbankingu. Súbory sú bez DRM.</p>
                </div>
                <p class="pub-legal-link">
                    Podrobnosti o predaji, dodaní a odstúpení od zmluvy:
                    <a href="obchodne-podmienky.php">Obchodné podmienky predaja publikácií</a>.
                </p>
            </section>

        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
