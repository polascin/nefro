<?php
declare(strict_types=1);
// Rýchla podponuka interaktívnych nástrojov (analógia calc_subnav.php).
// $_navCurrent nastavuje main_nav.php pred týmto include.
$_toolSubnavItems = [
    ['file' => 'nastroj_aki.php',          'label' => 'AKI'],
    ['file' => 'nastroj_hyponatremia.php', 'label' => 'Hyponatrémia'],
    ['file' => 'nastroj_hypokalemia.php',  'label' => 'Hypokaliémia'],
    ['file' => 'nastroj_tma.php',          'label' => 'TMA'],
    ['file' => 'nastroj_tls.php',          'label' => 'TLS'],
    ['file' => 'nastroj_gn.php',           'label' => 'GN'],
    ['file' => 'nastroj_dieta.php',        'label' => 'Renálna diéta'],
];
?>
<nav class="quick-nav-calculators" aria-label="Nástroje — rýchla navigácia">
    <div class="container">
        <ul class="quick-nav-list">
            <?php foreach ($_toolSubnavItems as $_item): ?>
                <li>
                    <?php if (isset($_navCurrent) && $_navCurrent === $_item['file']): ?>
                        <a href="<?= htmlspecialchars($_item['file']) ?>" class="active" aria-current="page"><?= htmlspecialchars($_item['label']) ?></a>
                    <?php else: ?>
                        <a href="<?= htmlspecialchars($_item['file']) ?>"><?= htmlspecialchars($_item['label']) ?></a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>
