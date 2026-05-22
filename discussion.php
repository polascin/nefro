<?php
declare(strict_types=1);
require_once "auth.php";
require_once "db_config.php";

$isLoggedIn   = isLoggedIn();
$currentUserId = $isLoggedIn ? (int) $_SESSION['user_id'] : 0;

$flash        = popFlashMessage();
$errorMessage = null;

// ── POST: nový príspevok alebo odpoveď (len pre prihlásených) ──────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    $action    = trim((string) ($_POST['action'] ?? ''));
    $csrfToken = (string) ($_POST['csrf_token'] ?? '');

    if (!validateCsrfToken($csrfToken)) {
        $errorMessage = 'Neplatný bezpečnostný token. Obnovte stránku a skúste znova.';
    } elseif (!in_array($action, ['new_post', 'new_reply'], true)) {
        $errorMessage = 'Neplatná akcia.';
    } else {
        // Rate limit: min. 10 sekúnd medzi príspevkami (session-based)
        $lastPost = (int) ($_SESSION['disc_last_post'] ?? 0);
        if ((time() - $lastPost) < 10) {
            $errorMessage = 'Príliš rýchlo. Počkajte prosím chvíľu pred ďalším príspevkom.';
        } else {
            $content  = trim((string) ($_POST['content'] ?? ''));
            $parentId = (int) ($_POST['parent_id'] ?? 0);

            if (mb_strlen($content, 'UTF-8') < 3) {
                $errorMessage = 'Príspevok je príliš krátky (min. 3 znaky).';
            } elseif (mb_strlen($content, 'UTF-8') > 3000) {
                $errorMessage = 'Príspevok je príliš dlhý (max. 3 000 znakov).';
            } else {
                try {
                    if ($action === 'new_reply' && $parentId > 0) {
                        // Overí, že rodičovský príspevok existuje a je top-level
                        $stmtParent = $pdo->prepare(
                            "SELECT id FROM discussion_posts
                             WHERE id = :id AND parent_id IS NULL AND is_deleted = 0
                             LIMIT 1"
                        );
                        $stmtParent->execute(['id' => $parentId]);
                        if (!$stmtParent->fetch()) {
                            $errorMessage = 'Neplatný nadradený príspevok.';
                        } else {
                            $pdo->prepare(
                                "INSERT INTO discussion_posts (parent_id, user_id, content)
                                 VALUES (:parent_id, :user_id, :content)"
                            )->execute([
                                'parent_id' => $parentId,
                                'user_id'   => $currentUserId,
                                'content'   => $content,
                            ]);
                            $_SESSION['disc_last_post'] = time();
                            setFlashMessage('success', 'Vaša odpoveď bola pridaná.');
                            header('Location: discussion.php#post-' . $parentId);
                            exit;
                        }
                    } else {
                        $pdo->prepare(
                            "INSERT INTO discussion_posts (parent_id, user_id, content)
                             VALUES (NULL, :user_id, :content)"
                        )->execute([
                            'user_id' => $currentUserId,
                            'content' => $content,
                        ]);
                        $_SESSION['disc_last_post'] = time();
                        setFlashMessage('success', 'Váš príspevok bol úspešne pridaný.');
                        header('Location: discussion.php');
                        exit;
                    }
                } catch (\PDOException $e) {
                    error_log('discussion.php DB insert error: ' . $e->getMessage());
                    $errorMessage = 'Chyba pri ukladaní príspevku. Skúste to znova.';
                }
            }
        }
    }
}

// ── Načítanie príspevkov s odpoveďami ─────────────────────────────────────
$posts = [];
try {
    $stmtPosts = $pdo->query(
        "SELECT dp.id, dp.content, dp.created_at, dp.user_id,
                TRIM(CONCAT_WS(' ',
                    NULLIF(TRIM(u.title_before), ''),
                    NULLIF(TRIM(u.first_name), ''),
                    NULLIF(TRIM(u.last_name), ''),
                    NULLIF(TRIM(u.title_after), '')
                )) AS display_name,
                u.username, u.avatar_path
         FROM discussion_posts dp
         JOIN users u ON dp.user_id = u.id
         WHERE dp.parent_id IS NULL AND dp.is_deleted = 0
         ORDER BY dp.created_at DESC
         LIMIT 200"
    );
    $posts = $stmtPosts->fetchAll(\PDO::FETCH_ASSOC);

    if (!empty($posts)) {
        $stmtReplies = $pdo->prepare(
            "SELECT dp.id, dp.content, dp.created_at, dp.user_id,
                    TRIM(CONCAT_WS(' ',
                        NULLIF(TRIM(u.title_before), ''),
                        NULLIF(TRIM(u.first_name), ''),
                        NULLIF(TRIM(u.last_name), ''),
                        NULLIF(TRIM(u.title_after), '')
                    )) AS display_name,
                    u.username, u.avatar_path
             FROM discussion_posts dp
             JOIN users u ON dp.user_id = u.id
             WHERE dp.parent_id = :parent_id AND dp.is_deleted = 0
             ORDER BY dp.created_at ASC"
        );
        foreach ($posts as &$post) {
            $stmtReplies->execute(['parent_id' => (int) $post['id']]);
            $post['replies'] = $stmtReplies->fetchAll(\PDO::FETCH_ASSOC);
        }
        unset($post);
    }
} catch (\PDOException $e) {
    error_log('discussion.php load error: ' . $e->getMessage());
}

// ── Page meta ──────────────────────────────────────────────────────────────
$pageTitle      = 'Diskusia | Nefro-projekt Slovensko';
$seoDescription = 'Odborná komunitná diskusia pre prihlásených členov Nefro-projektu Slovensko.';
$canonicalUrl   = 'https://nefro.polascin.net/discussion.php';
$robotsMeta     = 'noindex, nofollow';
$structuredData = [];

// ── Pomocné funkcie ────────────────────────────────────────────────────────
function formatDiscDate(string $datetime): string
{
    $ts = strtotime($datetime);
    if (!$ts) {
        return '';
    }
    $diff = time() - $ts;
    if ($diff < 60) {
        return 'Práve teraz';
    }
    if ($diff < 3600) {
        return (int) ($diff / 60) . ' min. späť';
    }
    if ($diff < 86400) {
        return (int) ($diff / 3600) . ' hod. späť';
    }
    $months = [
        1  => 'januára',  2  => 'februára', 3  => 'marca',
        4  => 'apríla',   5  => 'mája',     6  => 'júna',
        7  => 'júla',     8  => 'augusta',   9  => 'septembra',
        10 => 'októbra',  11 => 'novembra', 12 => 'decembra',
    ];
    return (int) date('j', $ts) . '. ' . ($months[(int) date('n', $ts)] ?? '') . ' ' . date('Y', $ts);
}

function discDisplayName(array $row): string
{
    $name = trim((string) ($row['display_name'] ?? ''));
    if ($name === '') {
        $name = (string) ($row['username'] ?? 'Používateľ');
    }
    return htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
}

function discAvatarSrc(array $row): string
{
    $path = trim((string) ($row['avatar_path'] ?? ''));
    if ($path !== '' && preg_match('/^[a-zA-Z0-9_\-\/\.]+$/', $path) && !str_contains($path, '..')) {
        return htmlspecialchars($path, ENT_QUOTES, 'UTF-8');
    }
    return 'img/default-avatar-light.svg';
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php include 'head_meta.php'; ?>
</head>
<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

  <?php
  $headerTitle = 'Nefro-projekt Slovensko';
  $headerIntro = 'Dynamická renesancia nefrológie: Od molekulárnej biológie po umelú inteligenciu.';
  $showLogo    = true;
  include 'header.php';
  ?>

  <?php
  $navActiveItem = 'discussion.php';
  include 'main_nav.php';
  ?>

  <main id="main-content" class="container main-content" role="main">
    <div class="content-wrapper">
      <div class="disc-page">

        <!-- Uvítacia správa (permanentná) -->
        <div class="disc-welcome" role="banner" aria-label="Uvítanie v diskusii">
          <div class="disc-welcome__icon" aria-hidden="true">💬</div>
          <h1 class="disc-welcome__title">Vitajte v diskusii</h1>
          <p class="disc-welcome__text">
            Toto je priestor pre odbornú diskusiu členov <strong>Nefro-projektu Slovensko</strong>.
            Zdieľajte skúsenosti, otázky a poznatky z nefrológie a príbuzných odborov s kolegami.
          </p>
          <p class="disc-welcome__rules">
            Prosíme o vecnú, odbornú a rešpektujúcu komunikáciu v súlade s etickými zásadami
            medicínskej komunity. Diskusia je určená výhradne pre registrovaných a prihlásených členov.
          </p>
        </div>

        <!-- Flash a chybové správy -->
        <?php if (!empty($flash) && $flash['type'] === 'success'): ?>
        <div class="alert alert-success disc-alert" role="alert" aria-live="polite">
          ✓ <?= htmlspecialchars((string) $flash['message'], ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php endif; ?>

        <?php if ($errorMessage !== null): ?>
        <div class="alert alert-error disc-alert" role="alert" aria-live="assertive">
          <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php endif; ?>

        <?php if (!$isLoggedIn): ?>
        <!-- Výzva na prihlásenie -->
        <div class="disc-login-prompt">
          <p>
            Pre pridávanie príspevkov a odpovedí sa prosím
            <a href="login.php">prihláste</a>
            alebo
            <a href="register.php">zaregistrujte</a>.
          </p>
          <p>Príspevky môžete čítať bez prihlásenia.</p>
        </div>
        <?php else: ?>
        <!-- Formulár nového príspevku -->
        <section class="disc-new-post" aria-labelledby="newPostHeading">
          <h2 class="disc-new-post__title" id="newPostHeading">Nový príspevok</h2>
          <form
            method="post"
            action="discussion.php"
            class="disc-form"
            id="newPostForm"
            autocomplete="off"
          >
            <input type="hidden" name="action" value="new_post">
            <input type="hidden" name="csrf_token"
              value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <div class="disc-form__field">
              <label for="newPostContent" class="disc-form__label">Váš príspevok</label>
              <textarea
                id="newPostContent"
                name="content"
                class="disc-form__textarea"
                rows="4"
                maxlength="3000"
                placeholder="Napíšte svoj príspevok… (max. 3 000 znakov)"
                required
                aria-describedby="newPostCounter"
              ></textarea>
              <div class="disc-form__counter" id="newPostCounter" aria-live="polite">0 / 3 000</div>
            </div>
            <div class="disc-form__actions">
              <button type="submit" class="btn-primary disc-form__submit">Pridať príspevok</button>
            </div>
          </form>
        </section>
        <?php endif; ?>

        <!-- Zoznam príspevkov -->
        <section class="disc-posts" aria-labelledby="discPostsHeading">
          <h2 class="disc-posts__heading" id="discPostsHeading">
            Príspevky
            <?php if (!empty($posts)): ?>
              <span class="disc-posts__count">(<?= count($posts) ?>)</span>
            <?php endif; ?>
          </h2>

          <?php if (empty($posts)): ?>
            <p class="disc-empty">
              Zatiaľ žiadne príspevky. Buďte prvý, kto sa zapojí do diskusie!
            </p>
          <?php else: ?>
            <ol class="disc-post-list" reversed>
              <?php foreach ($posts as $post):
                $postId           = (int) $post['id'];
                $postContent      = htmlspecialchars((string) $post['content'], ENT_QUOTES, 'UTF-8');
                $postDate         = formatDiscDate((string) $post['created_at']);
                $postDateIso      = htmlspecialchars(substr((string) $post['created_at'], 0, 16));
                $postName         = discDisplayName($post);
                $postAvatar       = discAvatarSrc($post);
                $postReplies      = $post['replies'] ?? [];
                $postReplyCount   = count($postReplies);
              ?>
              <li class="disc-post" id="post-<?= $postId ?>">
                <!-- Hlavička príspevku -->
                <div class="disc-post__header">
                  <img
                    src="<?= $postAvatar ?>"
                    alt=""
                    class="disc-post__avatar"
                    width="38"
                    height="38"
                    aria-hidden="true"
                    loading="lazy"
                  >
                  <div class="disc-post__meta">
                    <span class="disc-post__author"><?= $postName ?></span>
                    <time
                      class="disc-post__date"
                      datetime="<?= $postDateIso ?>"
                      title="<?= $postDateIso ?>"
                    ><?= htmlspecialchars($postDate, ENT_QUOTES, 'UTF-8') ?></time>
                  </div>
                  <a href="#post-<?= $postId ?>" class="disc-post__permalink" aria-label="Odkaz na príspevok">#</a>
                </div>

                <!-- Obsah príspevku -->
                <div class="disc-post__body">
                  <?= nl2br($postContent) ?>
                </div>

                <!-- Odpovede -->
                <?php if (!empty($postReplies)): ?>
                <div class="disc-replies" aria-label="Odpovede na príspevok">
                  <?php foreach ($postReplies as $reply):
                    $replyId      = (int) $reply['id'];
                    $replyContent = htmlspecialchars((string) $reply['content'], ENT_QUOTES, 'UTF-8');
                    $replyDate    = formatDiscDate((string) $reply['created_at']);
                    $replyDateIso = htmlspecialchars(substr((string) $reply['created_at'], 0, 16));
                    $replyName    = discDisplayName($reply);
                    $replyAvatar  = discAvatarSrc($reply);
                  ?>
                  <div class="disc-reply" id="reply-<?= $replyId ?>">
                    <div class="disc-post__header">
                      <img
                        src="<?= $replyAvatar ?>"
                        alt=""
                        class="disc-post__avatar disc-post__avatar--sm"
                        width="30"
                        height="30"
                        aria-hidden="true"
                        loading="lazy"
                      >
                      <div class="disc-post__meta">
                        <span class="disc-post__author"><?= $replyName ?></span>
                        <time
                          class="disc-post__date"
                          datetime="<?= $replyDateIso ?>"
                          title="<?= $replyDateIso ?>"
                        ><?= htmlspecialchars($replyDate, ENT_QUOTES, 'UTF-8') ?></time>
                      </div>
                      <a href="#reply-<?= $replyId ?>" class="disc-post__permalink" aria-label="Odkaz na odpoveď">#</a>
                    </div>
                    <div class="disc-post__body">
                      <?= nl2br($replyContent) ?>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Tlačidlo a formulár odpovede (len pre prihlásených) -->
                <?php if ($isLoggedIn): ?>
                <div class="disc-reply-section">
                  <button
                    type="button"
                    class="disc-reply-toggle"
                    aria-expanded="false"
                    aria-controls="reply-form-<?= $postId ?>"
                    data-post-id="<?= $postId ?>"
                  >↩ Odpovedať<?= $postReplyCount > 0 ? ' (' . $postReplyCount . ')' : '' ?></button>

                  <div
                    class="disc-reply-form-wrap"
                    id="reply-form-<?= $postId ?>"
                    hidden
                  >
                    <form
                      method="post"
                      action="discussion.php"
                      class="disc-form disc-form--reply"
                      autocomplete="off"
                    >
                      <input type="hidden" name="action" value="new_reply">
                      <input type="hidden" name="parent_id" value="<?= $postId ?>">
                      <input type="hidden" name="csrf_token"
                        value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                      <div class="disc-form__field">
                        <label for="replyContent-<?= $postId ?>" class="disc-form__label">
                          Vaša odpoveď
                        </label>
                        <textarea
                          id="replyContent-<?= $postId ?>"
                          name="content"
                          class="disc-form__textarea disc-form__textarea--reply"
                          rows="3"
                          maxlength="3000"
                          placeholder="Napíšte odpoveď… (max. 3 000 znakov)"
                          required
                        ></textarea>
                        <div class="disc-form__counter" aria-live="polite">0 / 3 000</div>
                      </div>
                      <div class="disc-form__actions">
                        <button type="submit" class="btn-primary disc-form__submit">Odpovedať</button>
                        <button
                          type="button"
                          class="btn-secondary disc-reply-cancel"
                          data-post-id="<?= $postId ?>"
                        >Zrušiť</button>
                      </div>
                    </form>
                  </div>
                </div>
                <?php endif; ?>

              </li>
              <?php endforeach; ?>
            </ol>
          <?php endif; ?>
        </section>

      </div><!-- .disc-page -->
    </div><!-- .content-wrapper -->
  </main>

  <?php include 'footer.php'; ?>

  <script nonce="<?= htmlspecialchars(getScriptNonce(), ENT_QUOTES, 'UTF-8') ?>">
  (function () {
    'use strict';

    // Čítač znakov pre textarey
    function attachCounter(textarea) {
      var field   = textarea.closest('.disc-form__field');
      var counter = field ? field.querySelector('.disc-form__counter') : null;
      if (!counter) return;
      function update() {
        var len = textarea.value.length;
        counter.textContent = len.toLocaleString('sk') + ' / 3 000';
        counter.classList.toggle('disc-form__counter--warn', len > 2700);
        counter.classList.toggle('disc-form__counter--over', len > 3000);
      }
      textarea.addEventListener('input', update);
      update();
    }
    document.querySelectorAll('.disc-form__textarea').forEach(attachCounter);

    // Zobrazenie/skrytie formulára odpovede
    document.querySelectorAll('.disc-reply-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var postId = btn.dataset.postId;
        var wrap   = document.getElementById('reply-form-' + postId);
        if (!wrap) return;
        var open = wrap.hidden;
        wrap.hidden = !open;
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (open) {
          var ta = wrap.querySelector('textarea');
          if (ta) { ta.focus(); attachCounter(ta); }
        }
      });
    });

    // Zrušenie odpovede
    document.querySelectorAll('.disc-reply-cancel').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var postId  = btn.dataset.postId;
        var wrap    = document.getElementById('reply-form-' + postId);
        var toggle  = document.querySelector('.disc-reply-toggle[data-post-id="' + postId + '"]');
        if (wrap)   { wrap.hidden = true; }
        if (toggle) { toggle.setAttribute('aria-expanded', 'false'); toggle.focus(); }
      });
    });
  })();
  </script>
</body>
</html>
