<?php

declare(strict_types=1);
/**
 * admin_publication_orders.php — Objednávky publikácií
 * ────────────────────────────────────────────────────────────────────────────
 * Platí sa bankovým prevodom, takže párovanie je ručné: predávajúci vidí
 * platbu vo výpise, nájde objednávku podľa variabilného symbolu a potvrdí ju
 * tu. Potvrdenie zároveň odošle kupujúcemu dodací e-mail s publikáciou
 * v prílohe (čo sa do limitu servera nezmestí, pošle sa odkazom).
 *
 * Prístupový token odkazu sa neukladá — odvodzuje sa HMAC-om z ID objednávky
 * a jej soli (`publicationOrderToken()`), takže dodací e-mail vieme poslať
 * kedykoľvek znova bez toho, aby sme držali použiteľný token v databáze.
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/publications_common.php';

requireAdmin();

const ERROR_ORDER_NOT_FOUND = 'Objednávka nenájdená.';

$actionResult = null;
$actionError  = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!checkFormRateLimit($pdo, 'admin_post_' . basename(__FILE__), getClientIpAddress(), 60, 300)) {
        $actionError = 'Príliš veľa požiadaviek. Skúste to neskôr.';
    } elseif (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $actionError = 'Neplatný CSRF token.';
    } else {
        $action  = (string) ($_POST['action'] ?? '');
        $orderId = (int) ($_POST['order_id'] ?? 0);
        $order   = $orderId > 0 ? findPublicationOrderById($pdo, $orderId) : null;

        if ($order === null) {
            $actionError = ERROR_ORDER_NOT_FOUND;
        } else {
            switch ($action) {
                case 'mark_paid':
                    requireAdminReauth();
                    try {
                        $note = trim((string) ($_POST['payment_note'] ?? ''));
                        if (!markPublicationOrderPaid($pdo, $orderId, $note !== '' ? $note : null)) {
                            $actionError = 'Objednávka už bola označená ako zaplatená.';
                            break;
                        }

                        // Prečítaj znova — potrebujeme paid_at aj access_expires_at
                        // nastavené v UPDATE, inak by e-mail uvádzal nesprávnu platnosť.
                        $order = findPublicationOrderById($pdo, $orderId);
                        if ($order === null) {
                            $actionError = ERROR_ORDER_NOT_FOUND;
                            break;
                        }

                        $delivery = sendPublicationOrderDeliveryEmail($order, publicationOrderToken($order));

                        if (!$delivery['sent']) {
                            $actionResult = 'Objednávka ' . (string) $order['variable_symbol']
                                . ' je označená ako zaplatená, ale dodací e-mail sa NEPODARILO odoslať. '
                                . 'Skúste ho poslať znova tlačidlom „Poslať dodací e-mail“.';
                        } elseif ($delivery['attached'] === []) {
                            $actionResult = 'Objednávka ' . (string) $order['variable_symbol']
                                . ' je zaplatená. Dodací e-mail odoslaný — súbory boli na prílohu '
                                . 'príliš veľké, kupujúci ich stiahne odkazom.';
                        } else {
                            $attached = implode(', ', publicationFormatLabels($delivery['attached']));
                            $actionResult = 'Objednávka ' . (string) $order['variable_symbol']
                                . ' je zaplatená. Dodací e-mail odoslaný s prílohou: ' . $attached
                                . ($delivery['linked'] !== []
                                    ? ' (odkazom: ' . implode(', ', publicationFormatLabels($delivery['linked'])) . ')'
                                    : '') . '.';
                        }

                        logAdminAction($pdo, 'publication_order_paid', 'publication_order', $orderId, [
                            'variable_symbol' => (string) $order['variable_symbol'],
                            'amount_eur'      => (string) $order['amount_eur'],
                            'email_sent'      => $delivery['sent'] ? 1 : 0,
                            'attached'        => implode(',', $delivery['attached']),
                        ]);
                    } catch (\Throwable $e) {
                        error_log('admin_publication_orders mark_paid error: ' . $e->getMessage());
                        $actionError = 'Chyba pri potvrdzovaní platby.';
                    }
                    break;

                case 'resend_delivery':
                    requireAdminReauth();
                    if ((string) $order['status'] !== 'paid') {
                        $actionError = 'Dodací e-mail sa posiela až po potvrdení platby.';
                        break;
                    }
                    try {
                        $delivery = sendPublicationOrderDeliveryEmail($order, publicationOrderToken($order));
                        $actionResult = $delivery['sent']
                            ? 'Dodací e-mail pre ' . (string) $order['variable_symbol'] . ' bol odoslaný znova.'
                            : 'Dodací e-mail sa nepodarilo odoslať — skontrolujte SMTP log.';
                        if (!$delivery['sent']) {
                            $actionError = $actionResult;
                            $actionResult = null;
                        }
                        logAdminAction($pdo, 'publication_order_resend', 'publication_order', $orderId, [
                            'variable_symbol' => (string) $order['variable_symbol'],
                            'email_sent'      => $delivery['sent'] ? 1 : 0,
                        ]);
                    } catch (\Throwable $e) {
                        error_log('admin_publication_orders resend error: ' . $e->getMessage());
                        $actionError = 'Chyba pri odosielaní dodacieho e-mailu.';
                    }
                    break;

                case 'resend_instructions':
                    if ((string) $order['status'] !== 'awaiting_payment') {
                        $actionError = 'Platobné pokyny majú zmysel len pri neuhradenej objednávke.';
                        break;
                    }
                    try {
                        $sent = sendPublicationOrderInstructionsEmail($order, publicationOrderToken($order));
                        if ($sent) {
                            $actionResult = 'Platobné pokyny pre ' . (string) $order['variable_symbol']
                                . ' boli odoslané znova.';
                        } else {
                            $actionError = 'Platobné pokyny sa nepodarilo odoslať — skontrolujte SMTP log.';
                        }
                    } catch (\Throwable $e) {
                        error_log('admin_publication_orders resend_instructions error: ' . $e->getMessage());
                        $actionError = 'Chyba pri odosielaní platobných pokynov.';
                    }
                    break;

                case 'cancel':
                    requireAdminReauth();
                    try {
                        $reason = trim((string) ($_POST['cancel_reason'] ?? ''));
                        if (!cancelPublicationOrder($pdo, $orderId, $reason !== '' ? $reason : 'Zrušené administrátorom.')) {
                            $actionError = 'Objednávka už bola zrušená.';
                            break;
                        }
                        $actionResult = 'Objednávka ' . (string) $order['variable_symbol'] . ' bola zrušená.';
                        logAdminAction($pdo, 'publication_order_cancel', 'publication_order', $orderId, [
                            'variable_symbol' => (string) $order['variable_symbol'],
                            'reason'          => $reason,
                        ]);
                    } catch (\Throwable $e) {
                        error_log('admin_publication_orders cancel error: ' . $e->getMessage());
                        $actionError = 'Chyba pri rušení objednávky.';
                    }
                    break;

                case 'reset_access':
                    // Nová soľ zneplatní starý odkaz a zároveň vynuluje počítadlo —
                    // používa sa, keď kupujúci vyčerpal limit alebo odkaz unikol.
                    requireAdminReauth();
                    try {
                        $pdo->prepare(
                            "UPDATE publication_orders
                             SET token_salt = :salt,
                                 download_count = 0,
                                 access_expires_at = DATE_ADD(NOW(), INTERVAL :days DAY)
                             WHERE id = :id AND status = 'paid'"
                        )->execute([
                            'salt' => bin2hex(random_bytes(16)),
                            'days' => PUBLICATION_ACCESS_DAYS,
                            'id'   => $orderId,
                        ]);

                        $order = findPublicationOrderById($pdo, $orderId);
                        if ($order === null) {
                            $actionError = ERROR_ORDER_NOT_FOUND;
                            break;
                        }

                        $delivery = sendPublicationOrderDeliveryEmail($order, publicationOrderToken($order));
                        $actionResult = 'Prístup pre ' . (string) $order['variable_symbol']
                            . ' bol obnovený (starý odkaz už neplatí). '
                            . ($delivery['sent'] ? 'Nový dodací e-mail odoslaný.' : 'E-mail sa NEPODARILO odoslať.');
                        logAdminAction($pdo, 'publication_order_reset_access', 'publication_order', $orderId, [
                            'variable_symbol' => (string) $order['variable_symbol'],
                        ]);
                    } catch (\Throwable $e) {
                        error_log('admin_publication_orders reset_access error: ' . $e->getMessage());
                        $actionError = 'Chyba pri obnove prístupu.';
                    }
                    break;

                default:
                    $actionError = 'Neznáma akcia.';
            }
        }
    }
}

// ── Filtre a výpis ──────────────────────────────────────────────────────────
$allowedFilters = ['', 'awaiting_payment', 'paid', 'cancelled'];
$filter = (string) ($_GET['status'] ?? '');
if (!in_array($filter, $allowedFilters, true)) {
    $filter = '';
}

$stats = ['total' => 0, 'awaiting_payment' => 0, 'paid' => 0, 'cancelled' => 0, 'revenue' => 0.0];
$orders = [];

try {
    $statsRows = $pdo->query(
        "SELECT status, COUNT(*) AS cnt, COALESCE(SUM(amount_eur), 0) AS total_eur
         FROM publication_orders GROUP BY status"
    )->fetchAll(PDO::FETCH_ASSOC);

    foreach ($statsRows as $row) {
        $status = (string) $row['status'];
        $stats[$status] = (int) $row['cnt'];
        $stats['total'] += (int) $row['cnt'];
        if ($status === 'paid') {
            $stats['revenue'] = (float) $row['total_eur'];
        }
    }

    $sql = "SELECT * FROM publication_orders";
    $params = [];
    if ($filter !== '') {
        $sql .= " WHERE status = :status";
        $params['status'] = $filter;
    }
    $sql .= " ORDER BY created_at DESC LIMIT 500";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    error_log('admin_publication_orders list error: ' . $e->getMessage());
    $actionError = $actionError ?? 'Objednávky sa nepodarilo načítať. Spustili ste už migráciu setup_db.php?';
}

$formatMeta = publicationFormats();
$csrfToken  = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objednávky publikácií – Nefro-projekt Slovensko</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>"></script>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Objednávky publikácií';
    $headerIntro = 'Párovanie platieb a dodanie e-knihy';
    $showLogo = false;
    include_once 'header.php';
    include_once 'admin_menu.php';
    ?>

    <main id="main-content" class="container container--wide admin-page-main" role="main">
        <div class="auth-container auth-container--wide">
            <h2>Objednávky publikácií</h2>
            <p class="auth-subtitle">
                Platby chodia bankovým prevodom. Nájdite objednávku podľa variabilného symbolu
                z výpisu a potvrďte platbu — kupujúcemu sa automaticky odošle dodací e-mail
                s publikáciou v prílohe.
            </p>

            <?php if ($actionResult !== null): ?>
                <div class="alert alert-success"><p><?= htmlspecialchars($actionResult) ?></p></div>
            <?php endif; ?>
            <?php if ($actionError !== null): ?>
                <div class="alert alert-error"><p><?= htmlspecialchars($actionError) ?></p></div>
            <?php endif; ?>

            <div class="admin-stats-grid">
                <?php
                $statItems = [
                    ['label' => 'Celkom', 'value' => (string) $stats['total'], 'filter' => ''],
                    ['label' => 'Čaká na úhradu', 'value' => (string) $stats['awaiting_payment'], 'filter' => 'awaiting_payment'],
                    ['label' => 'Zaplatené', 'value' => (string) $stats['paid'], 'filter' => 'paid'],
                    ['label' => 'Zrušené', 'value' => (string) $stats['cancelled'], 'filter' => 'cancelled'],
                    ['label' => 'Príjem', 'value' => formatPublicationPrice((float) $stats['revenue']), 'filter' => 'paid'],
                ];
                foreach ($statItems as $item):
                    $isActive = $filter === $item['filter'];
                ?>
                    <a href="admin_publication_orders.php<?= $item['filter'] !== '' ? '?status=' . urlencode($item['filter']) : '' ?>"
                       class="admin-stat-card<?= $isActive ? ' admin-stat-card--active' : '' ?>">
                        <span class="admin-stat-card__value"><?= htmlspecialchars($item['value']) ?></span>
                        <span class="admin-stat-card__label"><?= htmlspecialchars($item['label']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if ($orders === []): ?>
                <div class="info-box-gray">
                    <p>Žiadne objednávky<?= $filter !== '' ? ' v tomto stave' : '' ?>.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="pub-orders-table">
                        <caption class="visually-hidden">Zoznam objednávok publikácií</caption>
                        <thead>
                            <tr>
                                <th scope="col">VS</th>
                                <th scope="col">Objednané</th>
                                <th scope="col">Kupujúci</th>
                                <th scope="col">Publikácia a formáty</th>
                                <th scope="col">Suma</th>
                                <th scope="col">Stav</th>
                                <th scope="col">Akcie</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $row): ?>
                            <?php
                            $rowId     = (int) $row['id'];
                            $rowStatus = (string) $row['status'];
                            $rowVs     = (string) $row['variable_symbol'];
                            $rowOrderUrl = $rowVs !== ''
                                ? publicationOrderUrl($rowVs, publicationOrderToken($row))
                                : '';
                            ?>
                            <tr>
                                <td><code><?= htmlspecialchars($rowVs !== '' ? $rowVs : '—') ?></code></td>
                                <td><?= htmlspecialchars(formatUserDateTime((string) $row['created_at'], 'd.m.Y H:i')) ?></td>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars((string) $row['buyer_email'], ENT_QUOTES) ?>"><?= htmlspecialchars((string) $row['buyer_email']) ?></a>
                                    <?php if ((string) $row['buyer_name'] !== ''): ?>
                                        <br><span class="pub-orders-table__sub"><?= htmlspecialchars((string) $row['buyer_name']) ?></span>
                                    <?php endif; ?>
                                    <?php if ((string) $row['buyer_company'] !== ''): ?>
                                        <br><span class="pub-orders-table__sub"><?= htmlspecialchars((string) $row['buyer_company']) ?>
                                        <?php if ((string) $row['buyer_company_id'] !== ''): ?>
                                            (IČO <?= htmlspecialchars((string) $row['buyer_company_id']) ?>)
                                        <?php endif; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars((string) $row['publication_title']) ?>
                                    <br><span class="pub-orders-table__sub"><?= htmlspecialchars(implode(', ', publicationFormatLabels(publicationOrderFormats($row)))) ?></span>
                                </td>
                                <td><?= htmlspecialchars(formatPublicationPrice((float) $row['amount_eur'])) ?></td>
                                <td>
                                    <?php if ($rowStatus === 'paid'): ?>
                                        <span class="pub-status pub-status--paid">zaplatená</span>
                                        <?php if ($row['paid_at'] !== null): ?>
                                            <br><span class="pub-orders-table__sub"><?= htmlspecialchars(formatUserDateTime((string) $row['paid_at'], 'd.m.Y H:i')) ?></span>
                                        <?php endif; ?>
                                        <br><span class="pub-orders-table__sub">stiahnutí: <?= (int) $row['download_count'] ?>/<?= PUBLICATION_DOWNLOAD_MAX ?></span>
                                    <?php elseif ($rowStatus === 'cancelled'): ?>
                                        <span class="pub-status pub-status--cancelled">zrušená</span>
                                    <?php else: ?>
                                        <span class="pub-status pub-status--awaiting">čaká</span>
                                        <?php if ($row['payment_due_at'] !== null): ?>
                                            <br><span class="pub-orders-table__sub">do <?= htmlspecialchars(formatUserDateTime((string) $row['payment_due_at'], 'd.m.Y')) ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ((string) ($row['payment_note'] ?? '') !== ''): ?>
                                        <br><span class="pub-orders-table__sub"><?= htmlspecialchars((string) $row['payment_note']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="pub-orders-table__actions">
                                    <?php if ($rowStatus === 'awaiting_payment'): ?>
                                        <form method="post" class="pub-orders-form">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES) ?>">
                                            <input type="hidden" name="order_id" value="<?= $rowId ?>">
                                            <input type="hidden" name="action" value="mark_paid">
                                            <label class="visually-hidden" for="note_<?= $rowId ?>">Poznámka k platbe</label>
                                            <input type="text" id="note_<?= $rowId ?>" name="payment_note"
                                                   maxlength="500" placeholder="dátum/ref. platby (voliteľné)">
                                            <button type="submit" class="btn-primary">Potvrdiť platbu</button>
                                        </form>
                                        <form method="post" class="pub-orders-form">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES) ?>">
                                            <input type="hidden" name="order_id" value="<?= $rowId ?>">
                                            <input type="hidden" name="action" value="resend_instructions">
                                            <button type="submit" class="btn-secondary">Poslať pokyny znova</button>
                                        </form>
                                        <form method="post" class="pub-orders-form">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES) ?>">
                                            <input type="hidden" name="order_id" value="<?= $rowId ?>">
                                            <input type="hidden" name="action" value="cancel">
                                            <label class="visually-hidden" for="cancel_<?= $rowId ?>">Dôvod zrušenia</label>
                                            <input type="text" id="cancel_<?= $rowId ?>" name="cancel_reason"
                                                   maxlength="500" placeholder="dôvod zrušenia">
                                            <button type="submit" class="btn-danger">Zrušiť</button>
                                        </form>
                                    <?php elseif ($rowStatus === 'paid'): ?>
                                        <form method="post" class="pub-orders-form">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES) ?>">
                                            <input type="hidden" name="order_id" value="<?= $rowId ?>">
                                            <input type="hidden" name="action" value="resend_delivery">
                                            <button type="submit" class="btn-primary">Poslať dodací e-mail</button>
                                        </form>
                                        <form method="post" class="pub-orders-form">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES) ?>">
                                            <input type="hidden" name="order_id" value="<?= $rowId ?>">
                                            <input type="hidden" name="action" value="reset_access">
                                            <button type="submit" class="btn-secondary">Obnoviť prístup</button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($rowOrderUrl !== ''): ?>
                                        <a href="<?= htmlspecialchars($rowOrderUrl, ENT_QUOTES) ?>"
                                           class="btn-outline" target="_blank" rel="noopener noreferrer">Odkaz kupujúceho</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <section class="form-section" aria-labelledby="pub-admin-help-heading">
                <h3 id="pub-admin-help-heading">Poznámky k prevádzke</h3>
                <ul>
                    <li><strong>Veľkosť prílohy.</strong> Súbory majú 22 – 28 MB a v base64 narastú
                        na ~1,37-násobok. Pri potvrdení platby sa priloží len to, čo sa zmestí do
                        limitu, ktorý poštový server ohlási v EHLO (SIZE); zvyšok dostane kupujúci
                        odkazom na stránku objednávky. Čo sa skutočne priložilo, je v hlásení
                        po potvrdení.</li>
                    <li><strong>Súbory na serveri.</strong> Ležia v
                        <code>private/publications/&lt;slug&gt;/</code> a nie sú v gite ani v deployi —
                        po novom vydaní ich treba nahrať cez SFTP/SSH ručne.</li>
                    <li><strong>Obnoviť prístup</strong> vygeneruje novú soľ: starý odkaz z e-mailu
                        prestane fungovať, počítadlo stiahnutí sa vynuluje a kupujúcemu príde
                        nový dodací e-mail.</li>
                </ul>
            </section>

            <p><a href="admin.php" class="btn-secondary">Späť do administrácie</a></p>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
