<?php
$adminNavItems = [
    'index.php' => 'Domov',
    'admin.php' => 'Administrácia',
    'admin_articles.php' => 'Správa článkov',
    'admin_newsletter.php' => 'Newsletter',
    'admin_discussion.php' => 'Diskusia',
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
            <li>
                <form action="logout.php" method="post" style="display:inline;">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(function_exists('generateCsrfToken') ? generateCsrfToken() : '') ?>">
                    <button type="submit" class="nav-logout-btn"><?= $logoutLabel ?></button>
                </form>
            </li>
        </ul>
    </div>
</nav>
