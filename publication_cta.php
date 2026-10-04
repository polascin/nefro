<?php

declare(strict_types=1);
/**
 * publication_cta.php — propagácia dostupných publikácií (e-knihy).
 *
 * Samostatný include, aby sa ten istý blok dal vložiť na viaceré miesta
 * (domovská stránka pred Odporúčanými článkami, prípadne neskôr aj na konci
 * článku) bez kopírovania markupu.
 *
 * Zdroj pravdy o katalógu je `publications_common.php`. Ak nie je v ponuke
 * žiadna publikácia, blok sa nevykreslí — prázdna reklama je horšia než žiadna.
 *
 * Voliteľne pred include nastav:
 *   $publicationCtaHeadingLevel — 'h2' (default) alebo 'h3', aby nadpis
 *                                 nevybočil z hierarchie hostiteľskej stránky
 */

require_once __DIR__ . '/publications_common.php';

$_pubCtaAvailable = array_values(array_filter(
    publications(),
    static fn (array $p): bool => (bool) $p['is_available']
));

if ($_pubCtaAvailable === []) {
    return;
}

// Propagujeme najnovší zväzok; pri viacerých publikáciách zvyšok pokrýva
// odkaz na katalóg, aby blok neprerástol do druhého zoznamu článkov.
$_pubCtaItem  = $_pubCtaAvailable[0];
$_pubCtaMore  = count($_pubCtaAvailable) - 1;
$_pubCtaLevel = ($publicationCtaHeadingLevel ?? 'h2') === 'h3' ? 'h3' : 'h2';
$_pubCtaUrl   = 'publikacia.php?slug=' . urlencode((string) $_pubCtaItem['slug']);
?>
<section class="publication-cta" aria-labelledby="publication-cta-heading">
  <<?= $_pubCtaLevel ?> id="publication-cta-heading" class="section-heading">Nová publikácia</<?= $_pubCtaLevel ?>>

  <div class="publication-cta__inner">
    <a href="<?= htmlspecialchars($_pubCtaUrl, ENT_QUOTES) ?>" class="publication-cta__cover-link"
       aria-label="Detail publikácie <?= htmlspecialchars((string) $_pubCtaItem['title'], ENT_QUOTES) ?>">
      <img src="<?= htmlspecialchars((string) $_pubCtaItem['cover_small'], ENT_QUOTES) ?>"
           alt="Obálka publikácie <?= htmlspecialchars((string) $_pubCtaItem['title'], ENT_QUOTES) ?>"
           class="publication-cta__cover" width="600" height="900" loading="lazy">
    </a>

    <div class="publication-cta__body">
      <p class="publication-cta__title">
        <a href="<?= htmlspecialchars($_pubCtaUrl, ENT_QUOTES) ?>"><?= htmlspecialchars((string) $_pubCtaItem['title']) ?></a>
      </p>
      <p class="publication-cta__subtitle"><?= htmlspecialchars((string) $_pubCtaItem['subtitle']) ?></p>
      <p class="publication-cta__text"><?= htmlspecialchars((string) $_pubCtaItem['excerpt']) ?></p>

      <ul class="publication-cta__facts">
        <li><strong><?= number_format((int) $_pubCtaItem['articles'], 0, ',', ' ') ?></strong> článkov</li>
        <li><strong><?= number_format((int) $_pubCtaItem['pages'], 0, ',', ' ') ?></strong> strán</li>
        <?php if ((int) $_pubCtaItem['images'] > 0): ?>
          <li><strong><?= number_format((int) $_pubCtaItem['images'], 0, ',', ' ') ?></strong> ilustrácií</li>
        <?php endif; ?>
        <li>jazyk: <strong><?= htmlspecialchars((string) $_pubCtaItem['language']) ?></strong></li>
      </ul>

      <p class="publication-cta__formats">
        <?php foreach (publicationFormatLabels($_pubCtaItem['formats']) as $_pubCtaFormat): ?>
          <span class="pub-format-badge"><?= htmlspecialchars($_pubCtaFormat) ?></span>
        <?php endforeach; ?>
      </p>

      <p class="publication-cta__price">
        <span class="publication-cta__price-main"><?= htmlspecialchars(formatPublicationPrice(PUBLICATION_PRICE_SINGLE)) ?></span>
        <span class="publication-cta__price-note">za jeden formát · všetky formáty
          <strong><?= htmlspecialchars(formatPublicationPrice(PUBLICATION_PRICE_BUNDLE)) ?></strong></span>
      </p>

      <p class="publication-cta__actions">
        <a class="btn-primary" href="<?= htmlspecialchars($_pubCtaUrl, ENT_QUOTES) ?>">Detail a objednávka →</a>
        <?php if ($_pubCtaMore > 0): ?>
          <a class="btn-secondary" href="publikacie.php">Všetky publikácie (<?= $_pubCtaMore + 1 ?>)</a>
        <?php endif; ?>
      </p>

      <p class="publication-cta__note">
        Články na portáli zostávajú voľne dostupné a bez paywallu — publikácia je
        ten istý obsah zoradený, skorigovaný a čitateľný offline. Kúpou podporíte
        ďalšiu tvorbu obsahu.
      </p>
    </div>
  </div>
</section>
