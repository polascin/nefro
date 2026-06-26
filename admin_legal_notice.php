<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/legal_notifications.php';

requireAdmin();

$current = legalNoticeCurrentVersionInfo();
$currentDispatched = $current['version'] !== '' && legalNoticeRunExists($pdo, $current['version']);
$runs = getLegalNoticeOverview($pdo);

$pageLastUpdated = date('d.m.Y H:i', filemtime(__FILE__));
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Právne oznámenia – Nefro-projekt Slovensko</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <script src="nefro-ui.js?v=<?= filemtime('nefro-ui.js') ?>" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Právne oznámenia';
    $headerIntro = 'Upozornenia na zmenu právnych dokumentov';
    $showLogo = false;
    include_once 'header.php';
    include_once 'admin_menu.php';
    ?>

    <main id="main-content" class="container container--wide admin-page-main" role="main">
        <div class="auth-container auth-container--wide">
            <h2>Právne oznámenia o zmenách</h2>
            <p class="auth-subtitle">
                Pri zmene verzie právnych dokumentov (Zásady ochrany osobných údajov, Cookie Policy,
                Podmienky používania) sa všetkým registrovaným členom a anonymným odberateľom odošle
                e-mail s popisom zmien. Odosielanie zabezpečuje <code>legal_notice_worker.php</code>
                (CLI/cron) — táto stránka je len prehľad stavu.
            </p>

            <div class="legal-callout" role="status">
                <p>
                    <strong>Aktuálna verzia dokumentov:</strong>
                    <?= htmlspecialchars($current['version'] !== '' ? $current['version'] : '—') ?>
                    <?php if ($current['effectiveDate'] !== ''): ?>
                        (účinné od <?= htmlspecialchars($current['effectiveDate']) ?>)
                    <?php endif; ?>
                    &ensp;&bull;&ensp;
                    <?php if ($currentDispatched): ?>
                        <strong>Oznámenie už bolo zaradené/odoslané.</strong>
                    <?php else: ?>
                        <strong>Oznámenie pre túto verziu ešte nebolo zaradené</strong> —
                        spustí ho najbližší beh workera.
                    <?php endif; ?>
                </p>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <caption class="visually-hidden">Prehľad odoslaných právnych oznámení podľa verzie</caption>
                    <thead>
                        <tr>
                            <th scope="col">Verzia</th>
                            <th scope="col">Účinné od</th>
                            <th scope="col">Zaradené</th>
                            <th scope="col">Členovia (odoslané / čaká / zlyhalo / spolu)</th>
                            <th scope="col">Odberatelia (odoslané / čaká / zlyhalo / spolu)</th>
                            <th scope="col">Popis zmien</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($runs)): ?>
                        <tr><td colspan="6" class="admin-empty-cell">Zatiaľ neboli odoslané žiadne právne oznámenia.</td></tr>
                    <?php else: ?>
                        <?php foreach ($runs as $run):
                            $us = $run['user_stats'];
                            $ss = $run['sub_stats'];
                            $summary = json_decode((string) ($run['change_summary'] ?? ''), true);
                            if (!is_array($summary)) {
                                $summary = [];
                            }
                        ?>
                        <tr>
                            <td><?= htmlspecialchars((string) $run['legal_version']) ?></td>
                            <td><?= htmlspecialchars((string) ($run['effective_date'] ?? '—')) ?></td>
                            <td><?= htmlspecialchars((string) ($run['dispatched_at'] ?? '—')) ?></td>
                            <td><?= (int) $us['sent'] ?> / <?= (int) $us['pending'] ?> / <?= (int) $us['failed'] ?> / <?= (int) $us['total'] ?></td>
                            <td><?= (int) $ss['sent'] ?> / <?= (int) $ss['pending'] ?> / <?= (int) $ss['failed'] ?> / <?= (int) $ss['total'] ?></td>
                            <td>
                                <?php if (empty($summary)): ?>
                                    —
                                <?php else: ?>
                                    <ul class="legal-change-list">
                                        <?php foreach ($summary as $line): ?>
                                            <li><?= htmlspecialchars((string) $line) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <p class="auth-subtitle">Aktualizované: <?= htmlspecialchars($pageLastUpdated) ?></p>
        </div>
    </main>

    <?php include_once 'footer.php'; ?>
</body>
</html>
