<?php
/**
 * widget_participating_authors.php
 * ────────────────────────────────────────────────────────────────────────────
 * Bočný widget „Zúčastnení autori". Autora projektu zobrazuje oddelene od
 * pôvodných autorov zdrojových článkov a uvádza celkový počet zúčastnených.
 * Zdieľaný medzi index.php a article.php (jednotná podoba aj počty).
 *
 * Očakáva v scope volajúceho:
 *   $projectAuthors    array<int,array{author:string,articles:int}>  (zo štatistík)
 *   $authorFilterBase  string  základ URL filtra ?autor= ('' na index.php,
 *                              'index.php' na podstránkach ako article.php)
 *
 * Bez priameho prístupu.
 */
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header('HTTP/1.1 403 Forbidden');
    exit('Prístup odmietnutý.');
}

$projectAuthors = isset($projectAuthors) && is_array($projectAuthors) ? $projectAuthors : [];
if ($projectAuthors === []) {
    return;
}
$authorFilterBase = isset($authorFilterBase) ? (string) $authorFilterBase : '';

$participating = splitParticipatingAuthors($projectAuthors);

/** Vykreslí jednu položku autora (odkaz na filter ?autor= + počet článkov). */
$renderAuthorItem = static function (array $authorStat) use ($authorFilterBase): void {
    $authorName = trim((string) ($authorStat['author'] ?? ''));
    if ($authorName === '') {
        return;
    }
    $authorArticles = (int) ($authorStat['articles'] ?? 0);
    ?>
    <li>
      <a href="<?= htmlspecialchars($authorFilterBase, ENT_QUOTES, 'UTF-8') ?>?autor=<?= urlencode(
          $authorName,
      ) ?>#autor-articles-heading"
         class="author-filter-link"
         aria-label="Zobraziť články autora <?= htmlspecialchars(
             $authorName,
             ENT_QUOTES,
             'UTF-8',
         ) ?>">
        <?= htmlspecialchars($authorName, ENT_QUOTES, 'UTF-8') ?>
      </a>
      <strong><?= htmlspecialchars(
          formatProjectArticleCountLabel($authorArticles),
          ENT_QUOTES,
          'UTF-8',
      ) ?></strong>
    </li>
    <?php
};
?>
<div class="project-authors" aria-label="Autori článkov podľa počtu príspevkov">
  <h4>Zúčastnení autori</h4>
  <p class="project-authors__note">
    Vrátane autora projektu a pôvodných autorov zdrojových článkov.
    Spolu&nbsp;<strong><?= htmlspecialchars(
        formatParticipatingAuthorsLabel($participating['total']),
        ENT_QUOTES,
        'UTF-8',
    ) ?></strong>.
  </p>

  <?php if (!empty($participating['project'])): ?>
    <p class="project-authors__group-label">Autor projektu</p>
    <ul>
      <?php foreach ($participating['project'] as $authorStat) {
          $renderAuthorItem($authorStat);
      } ?>
    </ul>
  <?php endif; ?>

  <?php if (!empty($participating['sources'])): ?>
    <p class="project-authors__group-label">Autori zdrojových článkov (<?= count(
        $participating['sources'],
    ) ?>)</p>
    <ul class="expandable-list" data-limit="8">
      <?php foreach ($participating['sources'] as $authorStat) {
          $renderAuthorItem($authorStat);
      } ?>
    </ul>
    <button class="show-more-btn no-print" type="button">Zobraziť viac</button>
  <?php endif; ?>
</div>
