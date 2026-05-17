<?php
$adminNavItems = [
    'index.php' => 'Domov',
    'admin.php' => 'Administrácia',
    'admin_articles.php' => 'Správa článkov',
];
$currentPage = basename($_SERVER['PHP_SELF']);
$logoutLabel = 'Odhlásiť sa';
if (!empty($_SESSION['username'])) {
    $logoutLabel .= ' (' . htmlspecialchars($_SESSION['username']) . ')';
}
?>
<nav class="main-nav" aria-label="Administrátorská navigácia">
    <div class="container">
        <ul>
            <?php foreach ($adminNavItems as $href => $label): ?>
                <li>
                    <a href="<?= htmlspecialchars($href) ?>" <?= $currentPage === $href ? 'class="active" aria-current="page"' : '' ?>>
                        <?= htmlspecialchars($label) ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li><a href="logout.php"><?= $logoutLabel ?></a></li>
        </ul>
    </div>
</nav>
