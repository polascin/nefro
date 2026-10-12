<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var PDO $pdo */
require_once __DIR__ . '/email_verification.php';
requireAdmin();

$message = '';
$error = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $error = 'Neplatný CSRF token.';
    } else {
        $id = max(0, (int) ($_POST['notice_id'] ?? 0));
        $status = (string) ($_POST['status'] ?? 'reviewing');
        $decision = trim((string) ($_POST['decision'] ?? ''));
        $reason = trim((string) ($_POST['decision_reason'] ?? ''));
        $affectedEmail = trim((string) ($_POST['affected_email'] ?? ''));
        if ($id < 1 || !in_array($status, ['reviewing', 'actioned', 'rejected'], true)
            || mb_strlen($decision) > 100 || mb_strlen($reason) < 10 || mb_strlen($reason) > 5000
            || ($affectedEmail !== '' && filter_var($affectedEmail, FILTER_VALIDATE_EMAIL) === false)
        ) {
            $error = 'Skontrolujte stav, rozhodnutie a odôvodnenie.';
        } else {
            try {
                $pdo->beginTransaction();
                $select = $pdo->prepare('SELECT * FROM content_notices WHERE id = :id FOR UPDATE');
                $select->execute(['id' => $id]);
                $notice = $select->fetch();
                if (!$notice) {
                    throw new RuntimeException('Oznámenie neexistuje.');
                }
                $pdo->prepare(
                    'UPDATE content_notices SET status = :status, decision = :decision,
                     decision_reason = :reason, affected_email = :affected_email,
                     decided_at = NOW(), updated_at = NOW() WHERE id = :id'
                )->execute([
                    'status' => $status,
                    'decision' => $decision,
                    'reason' => $reason,
                    'affected_email' => $affectedEmail !== '' ? $affectedEmail : null,
                    'id' => $id,
                ]);
                logAdminAction($pdo, 'content_notice_decision', 'content_notice', $id, ['status' => $status]);
                $pdo->commit();

                $reporterEmail = (string) ($notice['reporter_email'] ?? '');
                if ($reporterEmail !== '') {
                    $subject = 'Rozhodnutie k oznámeniu obsahu č. ' . $id;
                    $plain = "Stav: {$status}\nRozhodnutie: {$decision}\nOdôvodnenie: {$reason}\n";
                    $html = renderEmailHtmlLayout(
                        '<p><strong>Stav:</strong> ' . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . '</p>'
                        . '<p><strong>Rozhodnutie:</strong> ' . htmlspecialchars($decision, ENT_QUOTES, 'UTF-8') . '</p>'
                        . '<p><strong>Odôvodnenie:</strong><br>' . nl2br(htmlspecialchars($reason, ENT_QUOTES, 'UTF-8')) . '</p>'
                        . '<p>Ak s rozhodnutím nesúhlasíte, môžete požiadať o jeho preskúmanie odpoveďou na tento e-mail alebo využiť dostupný súdny prostriedok nápravy.</p>'
                    );
                    if (!sendViaSmtp($reporterEmail, $subject, $html, getEmailEnvConfig(), 'text/html; charset=UTF-8', $plain)) {
                        error_log('DSA decision email failed for notice_id=' . $id);
                    }
                }
                if ($affectedEmail !== '') {
                    $subject = 'Odôvodnenie rozhodnutia o obsahu č. ' . $id;
                    $plain = "Obsah: {$notice['content_url']}\nOpatrenie: {$decision}\nOdôvodnenie: {$reason}\n";
                    $html = renderEmailHtmlLayout(
                        '<p><strong>Obsah:</strong> ' . htmlspecialchars((string) $notice['content_url'], ENT_QUOTES, 'UTF-8') . '</p>'
                        . '<p><strong>Opatrenie:</strong> ' . htmlspecialchars($decision, ENT_QUOTES, 'UTF-8') . '</p>'
                        . '<p><strong>Odôvodnenie:</strong><br>' . nl2br(htmlspecialchars($reason, ENT_QUOTES, 'UTF-8')) . '</p>'
                        . '<p>Ak s rozhodnutím nesúhlasíte, môžete požiadať o preskúmanie odpoveďou na tento e-mail alebo využiť dostupný súdny prostriedok nápravy.</p>'
                    );
                    if (!sendViaSmtp($affectedEmail, $subject, $html, getEmailEnvConfig(), 'text/html; charset=UTF-8', $plain)) {
                        error_log('DSA affected-user email failed for notice_id=' . $id);
                    }
                }
                $message = 'Rozhodnutie bolo uložené a oznámenie odoslané, ak bol uvedený e-mail.';
            } catch (Throwable $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                error_log('admin_content_notices failed: ' . $e->getMessage());
                $error = 'Rozhodnutie sa nepodarilo uložiť.';
            }
        }
    }
}

$notices = [];
try {
    $notices = $pdo->query('SELECT * FROM content_notices ORDER BY created_at DESC LIMIT 200')->fetchAll();
} catch (PDOException $e) {
    $error = 'Evidencia oznámení zatiaľ nie je dostupná.';
}

$pageTitle = 'Oznámenia obsahu';
include 'header.php';
include 'admin_menu.php';
?>
<main id="main-content" class="container main-content main-content--single-col" role="main">
  <h1>Oznámenia nezákonného obsahu</h1>
  <?php if ($message !== ''): ?><div class="alert alert-success" role="status"><?= htmlspecialchars($message) ?></div><?php endif; ?>
  <?php if ($error !== ''): ?><div class="alert alert-error" role="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <?php foreach ($notices as $notice): $id = (int) $notice['id']; ?>
    <article class="form-card">
      <h2>Oznámenie č. <?= $id ?> · <?= htmlspecialchars((string) $notice['status']) ?></h2>
      <p><a href="<?= htmlspecialchars((string) $notice['content_url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars((string) $notice['content_url']) ?></a></p>
      <p><strong>Právny dôvod:</strong> <?= nl2br(htmlspecialchars((string) $notice['legal_basis'])) ?></p>
      <p><strong>Vysvetlenie:</strong> <?= nl2br(htmlspecialchars((string) $notice['explanation'])) ?></p>
      <p><strong>Oznamovateľ:</strong> <?= htmlspecialchars((string) ($notice['reporter_name'] ?? 'neuvedený')) ?> · <?= htmlspecialchars((string) ($notice['reporter_email'] ?? 'bez kontaktu')) ?></p>
      <form method="post" action="admin_content_notices.php">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
        <input type="hidden" name="notice_id" value="<?= $id ?>">
        <label>Stav <select name="status"><option value="reviewing">Posudzuje sa</option><option value="actioned">Prijaté opatrenie</option><option value="rejected">Zamietnuté</option></select></label>
        <label>Rozhodnutie <input type="text" name="decision" maxlength="100" value="<?= htmlspecialchars((string) ($notice['decision'] ?? '')) ?>"></label>
        <label>Odôvodnenie <textarea name="decision_reason" required minlength="10" maxlength="5000" rows="5"><?= htmlspecialchars((string) ($notice['decision_reason'] ?? '')) ?></textarea></label>
        <label>E-mail dotknutého používateľa <input type="email" name="affected_email" maxlength="254" value="<?= htmlspecialchars((string) ($notice['affected_email'] ?? '')) ?>"></label>
        <button type="submit" class="btn-primary">Uložiť a oznámiť rozhodnutie</button>
      </form>
    </article>
  <?php endforeach; ?>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
