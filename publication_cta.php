<?php

declare(strict_types=1);
/**
 * publication_cta.php — propagácia bezplatných publikácií.
 *
 * Samostatný include, aby sa ten istý blok dal vložiť na viaceré miesta
 * (domovská stránka pred Odporúčanými článkami, prípadne neskôr aj na konci
 * článku) bez kopírovania markupu.
 *
 * Zdroj pravdy o ponuke je `publications_common.php`.
 *
 * Voliteľne pred include nastav:
 *   $publicationCtaHeadingLevel — 'h2' (default) alebo 'h3', aby nadpis
 *                                 nevybočil z hierarchie hostiteľskej stránky
 */

require_once __DIR__ . '/publications_common.php';

$_pubCtaAvailable = freePublications();

if ($_pubCtaAvailable === []) {
    return;
}

$_pubCtaLevel = ($publicationCtaHeadingLevel ?? 'h2') === 'h3' ? 'h3' : 'h2';
?>
<section class="publication-cta" aria-labelledby="publication-cta-heading">
  <<?= $_pubCtaLevel ?> id="publication-cta-heading" class="section-heading">Bezplatne na stiahnutie</<?= $_pubCtaLevel ?>>
  <p class="publication-cta__intro">Nová dvojica publikácií prináša syntézu polroka odbornej tvorby v slovenčine aj angličtine.</p>

  <div class="publication-cta__grid">
    <?php foreach ($_pubCtaAvailable as $_pubCtaItem): ?>
      <article class="publication-cta__inner">
        <a href="<?= htmlspecialchars((string) $_pubCtaItem['file'], ENT_QUOTES) ?>" class="publication-cta__cover-link"
           aria-label="Stiahnuť publikáciu <?= htmlspecialchars((string) $_pubCtaItem['title'], ENT_QUOTES) ?> vo formáte PDF" download>
          <img src="<?= htmlspecialchars((string) $_pubCtaItem['cover_small'], ENT_QUOTES) ?>"
               alt="Obálka publikácie <?= htmlspecialchars((string) $_pubCtaItem['title'], ENT_QUOTES) ?>"
               class="publication-cta__cover" width="909" height="1286" loading="lazy">
        </a>
        <div class="publication-cta__body">
          <p class="publication-cta__eyebrow">PDF · <?= (int) $_pubCtaItem['pages'] ?> strán · <?= htmlspecialchars((string) $_pubCtaItem['language']) ?></p>
          <p class="publication-cta__title"><?= htmlspecialchars((string) $_pubCtaItem['title']) ?></p>
          <p class="publication-cta__text"><?= htmlspecialchars((string) $_pubCtaItem['excerpt']) ?></p>
          <p class="publication-cta__actions">
            <a class="btn-primary" href="<?= htmlspecialchars((string) $_pubCtaItem['file'], ENT_QUOTES) ?>"
               download="<?= htmlspecialchars((string) $_pubCtaItem['download_name'], ENT_QUOTES) ?>">Stiahnuť PDF zadarmo</a>
          </p>
          <div class="free-download-formats" aria-label="Ďalšie formáty na stiahnutie">
            <span class="free-download-formats__label">Ďalšie formáty:</span>
            <?php foreach (array_slice($_pubCtaItem['downloads'], 1) as $_pubCtaDownload): ?>
              <a href="<?= htmlspecialchars((string) $_pubCtaDownload['file'], ENT_QUOTES) ?>"
                 download="<?= htmlspecialchars((string) $_pubCtaDownload['download_name'], ENT_QUOTES) ?>"><?= htmlspecialchars((string) $_pubCtaDownload['label']) ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
  <p class="publication-cta__catalogue-link"><a href="publikacie.php">Pozrieť všetky publikácie</a></p>
</section>
