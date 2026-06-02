<?php

declare(strict_types=1);

/**
 * Krížové odkazy medzi právnymi dokumentmi (analóg „Related" v alphagrab).
 * Pred include nastav $legalCurrent na slug aktuálnej stránky, aby sa vynechal.
 */

$legalCurrent = $legalCurrent ?? '';

$legalRelated = [
    'privacy.php' => 'Ochrana osobných údajov',
    'cookies.php' => 'Cookie Policy',
    'terms.php'   => 'Podmienky používania',
];
?>
<nav class="legal-related" aria-label="Súvisiace právne dokumenty">
    <span class="legal-related__label">Súvisiace dokumenty:</span>
    <?php foreach ($legalRelated as $slug => $label): ?>
        <?php if ($slug !== $legalCurrent): ?>
            <a href="<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>" class="legal-related__link"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></a>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>
