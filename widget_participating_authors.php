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
 *   $authorPickerInline bool   true (predvolene) = výber autora s <datalist>
 *                              všetkých zdrojových autorov; false = len odkaz
 *                              na výber na index.php (datalist má ~2 600 mien
 *                              a ~200 kB HTML, na stránke článku zbytočne)
 *   $authorPickerOpen  bool    otvorí <details> výberu (index.php?autori=1)
 *
 * Bez priameho prístupu.
 */
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header('HTTP/1.1 403 Forbidden');
    exit('Prístup odmietnutý.');
}

$projectAuthors = isset($projectAuthors) && is_array($projectAuthors) ? $projectAuthors : [];
if ($projectAuthors === []) {
    return;
}
$authorFilterBase = isset($authorFilterBase) ? (string) $authorFilterBase : '';
$authorPickerInline = !isset($authorPickerInline) || $authorPickerInline !== false;
$authorPickerOpen = isset($authorPickerOpen) && $authorPickerOpen === true;

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
    <ul>
      <?php foreach (array_slice($participating['sources'], 0, 8) as $authorStat) {
          $renderAuthorItem($authorStat);
      } ?>
    </ul>
    <?php if (count($participating['sources']) > 8 && !$authorPickerInline): ?>
      <p class="project-authors__picker no-print">
        <a href="index.php?autori=1#autori-vyhladanie">Vyhľadať ďalšieho autora</a>
      </p>
    <?php elseif (count($participating['sources']) > 8): ?>
      <details class="project-authors__picker no-print" id="autori-vyhladanie"<?= $authorPickerOpen ? ' open' : '' ?>>
        <summary>Vyhľadať ďalšieho autora</summary>
        <form method="get" action="<?= htmlspecialchars($authorFilterBase !== '' ? $authorFilterBase : 'index.php', ENT_QUOTES, 'UTF-8') ?>#autor-articles-heading">
          <div class="form-group">
            <label for="source-author-choice">Meno autora</label>
            <input class="form-control" type="search" id="source-author-choice" name="autor"
                   list="source-author-options" maxlength="200" required autocomplete="off"
                   placeholder="Začnite písať meno">
            <datalist id="source-author-options">
<?php
            // Jedna položka na riadok bez odsadenia: ~2 600 autorov s odsadením
            // šablóny pridávalo na index.php ~90 kB medzier (Beh 184).
            $authorOptions = [];
            foreach ($participating['sources'] as $authorStat) {
                $authorOptions[] = '<option value="' . htmlspecialchars($authorStat['author'], ENT_QUOTES, 'UTF-8') . '">'
                    . htmlspecialchars(formatProjectArticleCountLabel($authorStat['articles']), ENT_QUOTES, 'UTF-8') . '</option>';
            }
            echo implode("\n", $authorOptions), "\n";
?>
            </datalist>
          </div>
          <button class="btn-primary" type="submit">Zobraziť články autora</button>
        </form>
      </details>
    <?php endif; ?>
  <?php endif; ?>
</div>
