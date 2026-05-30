<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . "/newsletter_notifications.php";

requireAdmin();

$currentAdminId = (int) ($_SESSION["user_id"] ?? 0);
$actionResult = null; // vždy plain text — escapuje sa cez htmlspecialchars() pri výpise
$actionResultLink = null; // voliteľný HTML odkaz, konštruovaný výhradne z in-cast hodnôt (int IDs)
$actionError = null;
$editArticle = null;
$queueSummary = [
    "pending" => 0,
    "failed" => 0,
    "sent" => 0,
    "cancelled" => 0,
    "due_now" => 0,
    "total" => 0,
];
$articleQueueStats = [];
$queueRecent = [];
$queueFilterStatus = strtolower(trim((string) ($_GET["q_status"] ?? "")));
$queueFilterArticleId = max(0, (int) ($_GET["q_article_id"] ?? 0));
$queuePreset = strtolower(trim((string) ($_GET["q_preset"] ?? "")));
$queueAllowedStatuses = ["pending", "failed", "sent", "cancelled"];
if (!in_array($queueFilterStatus, $queueAllowedStatuses, true)) {
    $queueFilterStatus = "";
}
if (!in_array($queuePreset, ["", "unsent", "due_now"], true)) {
    $queuePreset = "";
}
if ($queueFilterStatus !== "") {
    // Pri manuálnom výbere stavu má explicitný filter prednosť pred presetom.
    $queuePreset = "";
}
if ($queueFilterStatus === "" && $queuePreset === "") {
    $queueFilterStatus = "pending";
}

// ── Pomocné funkcie ───────────────────────────────────────────────────────────

/**
 * Generuje URL-friendly slug z titulku článku.
 * Translit. diakritiky, malé písmená, pomlčky namiesto medzier a spec. znakov.
 */
function generateSlug(string $title): string
{
    $map = [
        "á" => "a",
        "ä" => "a",
        "č" => "c",
        "ď" => "d",
        "é" => "e",
        "í" => "i",
        "ĺ" => "l",
        "ľ" => "l",
        "ň" => "n",
        "ó" => "o",
        "ô" => "o",
        "ŕ" => "r",
        "š" => "s",
        "ť" => "t",
        "ú" => "u",
        "ý" => "y",
        "ž" => "z",
        "Á" => "a",
        "Ä" => "a",
        "Č" => "c",
        "Ď" => "d",
        "É" => "e",
        "Í" => "i",
        "Ĺ" => "l",
        "Ľ" => "l",
        "Ň" => "n",
        "Ó" => "o",
        "Ô" => "o",
        "Ŕ" => "r",
        "Š" => "s",
        "Ť" => "t",
        "Ú" => "u",
        "Ý" => "y",
        "Ž" => "z",
    ];
    $title = strtr($title, $map);
    $title = strtolower($title);
    $title = preg_replace("/[^a-z0-9]+/", "-", $title) ?? "";
    $title = trim($title, "-");
    return mb_substr($title, 0, 200);
}

/**
 * Zabezpečí unikátnosť slugu v DB.
 * Ak slug existuje, pripojí -2, -3, atď.
 */
function uniqueSlug(PDO $pdo, string $slug, int $excludeId = 0): string
{
    $base = $slug;
    $n = 2;
    while (true) {
        $stmt = $pdo->prepare(
            "SELECT id FROM articles WHERE slug = :slug AND id != :id LIMIT 1",
        );
        $stmt->execute(["slug" => $slug, "id" => $excludeId]);
        if ($stmt->fetch() === false) {
            return $slug;
        }
        $slug = $base . "-" . $n;
        $n++;
    }
}

function normalizeExcerptText(string $text): string
{
    $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, "UTF-8");
    $stripped = strip_tags($decoded);
    $normalized = preg_replace("/\s+/u", " ", $stripped) ?? $stripped;
    return trim($normalized);
}

function shortenTextAtWordBoundary(string $text, int $maxLen): string
{
    if (mb_strlen($text) <= $maxLen) {
        return $text;
    }
    $slice = mb_substr($text, 0, $maxLen + 1);
    $slice = preg_replace('/\s+\S*$/u', "", $slice) ?? $slice;
    $slice = rtrim($slice, " \t\n\r\0\x0B,.;:-");
    return $slice . "…";
}

function optimizeExcerptForSeo(
    string $excerpt,
    string $content,
    int $maxLen = 220,
): string {
    $candidate = normalizeExcerptText($excerpt);
    if ($candidate === "") {
        $candidate = normalizeExcerptText($content);
    }
    if ($candidate === "") {
        return "";
    }
    return shortenTextAtWordBoundary($candidate, $maxLen);
}

// ── Spracovanie POST akcií ────────────────────────────────────────────────────
if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $postedCsrf = $_POST["csrf_token"] ?? "";
    if (!validateCsrfToken($postedCsrf)) {
        $actionError = "Neplatný CSRF token.";
    } else {
        $action = $_POST["action"] ?? "";

        switch ($action) {
            // ── CREATE ──────────────────────────────────────────────────────
            case "create":
                $title = trim((string) ($_POST["title"] ?? ""));
                $slug = trim((string) ($_POST["slug"] ?? ""));
                $author = trim(
                    (string) ($_POST["author"] ?? "MUDr. Ľubomír Polaščín"),
                );
                $content = trim((string) ($_POST["content"] ?? ""));
                $excerpt = trim((string) ($_POST["excerpt"] ?? ""));
                $pubAt = trim((string) ($_POST["published_at"] ?? ""));
                $isTop = isset($_POST["is_top"]) ? 1 : 0;
                $isPub = isset($_POST["is_published"]) ? 1 : 0;

                $excerpt = optimizeExcerptForSeo($excerpt, $content, 220);

                if ($title === "") {
                    $actionError = "Titulok je povinný.";
                    break;
                }
                if ($content === "") {
                    $actionError = "Obsah článku je povinný.";
                    break;
                }
                if ($excerpt === "") {
                    $actionError =
                        "Perex sa nepodarilo vytvoriť. Doplňte obsah článku alebo perex manuálne.";
                    break;
                }
                if (
                    $pubAt === "" ||
                    !preg_match("/^\d{4}-\d{2}-\d{2}/", $pubAt)
                ) {
                    $actionError = "Dátum publikácie je neplatný.";
                    break;
                }
                // Automatický slug ak prázdny
                if ($slug === "") {
                    $slug = generateSlug($title);
                }
                $slug =
                    preg_replace("/[^a-z0-9\-]/", "", strtolower($slug)) ?? "";
                $slug = uniqueSlug($pdo, $slug);

                try {
                    $stmt = $pdo->prepare(
                        "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
                         VALUES (:title,:slug,:author,:content,:excerpt,:published_at,:is_top,:is_published)",
                    );
                    $stmt->execute([
                        "title" => $title,
                        "slug" => $slug,
                        "author" =>
                            $author !== "" ? $author : "MUDr. Ľubomír Polaščín",
                        "content" => $content,
                        "excerpt" => $excerpt,
                        "published_at" => $pubAt,
                        "is_top" => $isTop,
                        "is_published" => $isPub,
                    ]);
                    $newId = (int) $pdo->lastInsertId();
                    $actionResult = "Článok bol úspešne vytvorený.";
                    $actionResultLink =
                        '<a href="article.php?id=' .
                        $newId .
                        '" target="_blank" rel="noopener">Zobraziť →</a>';

                    if ($isPub === 1) {
                        try {
                            $queuedCount = enqueueArticleNewsletterEmails(
                                $pdo,
                                $newId,
                            );
                            $actionResult .=
                                " Do fronty noviniek bolo zaradených " .
                                $queuedCount .
                                " e-mailov.";
                        } catch (\Throwable $queueError) {
                            error_log(
                                "admin_articles create newsletter enqueue error: " .
                                    $queueError->getMessage(),
                            );
                            $actionResult .=
                                " Článok bol uložený, ale novinky sa nepodarilo zaradiť do fronty.";
                        }
                    }
                } catch (\PDOException $e) {
                    error_log(
                        "admin_articles create error: " . $e->getMessage(),
                    );
                    $actionError = "Chyba pri ukladaní článku.";
                }
                break;

            // ── UPDATE ──────────────────────────────────────────────────────
            case "update":
                $id = (int) ($_POST["article_id"] ?? 0);
                $title = trim((string) ($_POST["title"] ?? ""));
                $slug = trim((string) ($_POST["slug"] ?? ""));
                $author = trim((string) ($_POST["author"] ?? ""));
                $content = trim((string) ($_POST["content"] ?? ""));
                $excerpt = trim((string) ($_POST["excerpt"] ?? ""));
                $pubAt = trim((string) ($_POST["published_at"] ?? ""));
                $isTop = isset($_POST["is_top"]) ? 1 : 0;
                $isPub = isset($_POST["is_published"]) ? 1 : 0;

                $excerpt = optimizeExcerptForSeo($excerpt, $content, 220);

                if ($id <= 0) {
                    $actionError = "Neplatné ID článku.";
                    break;
                }
                if ($title === "") {
                    $actionError = "Titulok je povinný.";
                    break;
                }
                if ($content === "") {
                    $actionError = "Obsah článku je povinný.";
                    break;
                }
                if ($excerpt === "") {
                    $actionError =
                        "Perex sa nepodarilo vytvoriť. Doplňte obsah článku alebo perex manuálne.";
                    break;
                }
                if (
                    $pubAt === "" ||
                    !preg_match("/^\d{4}-\d{2}-\d{2}/", $pubAt)
                ) {
                    $actionError = "Dátum publikácie je neplatný.";
                    break;
                }

                if ($slug === "") {
                    $slug = generateSlug($title);
                }
                $slug =
                    preg_replace("/[^a-z0-9\-]/", "", strtolower($slug)) ?? "";
                $slug = uniqueSlug($pdo, $slug, $id);

                $previousPublished = null;
                try {
                    $prevStmt = $pdo->prepare(
                        "SELECT is_published FROM articles WHERE id = :id LIMIT 1",
                    );
                    $prevStmt->execute(["id" => $id]);
                    $prevRow = $prevStmt->fetch();
                    if (!$prevRow) {
                        $actionError = "Článok nenájdený.";
                        break;
                    }
                    $previousPublished = (int) ($prevRow["is_published"] ?? 0);
                } catch (\PDOException $e) {
                    error_log(
                        "admin_articles update prev state error: " .
                            $e->getMessage(),
                    );
                    $actionError = "Chyba pri načítaní článku.";
                    break;
                }

                try {
                    $stmt = $pdo->prepare(
                        "UPDATE articles SET title=:title, slug=:slug, author=:author, content=:content,
                         excerpt=:excerpt, published_at=:published_at, is_top=:is_top, is_published=:is_published
                         WHERE id=:id",
                    );
                    $stmt->execute([
                        "title" => $title,
                        "slug" => $slug,
                        "author" =>
                            $author !== "" ? $author : "MUDr. Ľubomír Polaščín",
                        "content" => $content,
                        "excerpt" => $excerpt,
                        "published_at" => $pubAt,
                        "is_top" => $isTop,
                        "is_published" => $isPub,
                        "id" => $id,
                    ]);
                    $actionResult = "Článok bol úspešne aktualizovaný.";
                    $actionResultLink =
                        '<a href="article.php?id=' .
                        $id .
                        '" target="_blank" rel="noopener">Zobraziť →</a>';

                    try {
                        if ($previousPublished === 0 && $isPub === 1) {
                            $queuedCount = enqueueArticleNewsletterEmails(
                                $pdo,
                                $id,
                            );
                            $actionResult .=
                                " Do fronty noviniek bolo zaradených " .
                                $queuedCount .
                                " e-mailov.";
                        } elseif ($previousPublished === 1 && $isPub === 0) {
                            $cancelledCount = cancelPendingArticleNewsletter(
                                $pdo,
                                $id,
                            );
                            if ($cancelledCount > 0) {
                                $actionResult .=
                                    " Z fronty noviniek bolo zrušených " .
                                    $cancelledCount .
                                    " čakajúcich e-mailov.";
                            }
                        }
                    } catch (\Throwable $queueError) {
                        error_log(
                            "admin_articles update newsletter queue error: " .
                                $queueError->getMessage(),
                        );
                        $actionResult .=
                            " Aktualizácia prebehla, ale správa fronty noviniek zlyhala.";
                    }
                } catch (\PDOException $e) {
                    error_log(
                        "admin_articles update error: " . $e->getMessage(),
                    );
                    $actionError = "Chyba pri aktualizácii článku.";
                }
                break;

            // ── NEWSLETTER: MANUÁLNE AVÍZO PRE ČLÁNOK ───────────────────
            case "enqueue_newsletter":
                $id = (int) ($_POST["article_id"] ?? 0);
                if ($id <= 0) {
                    $actionError = "Neplatné ID článku.";
                    break;
                }
                try {
                    $result = enqueueArticleNewsletterEmailsNow($pdo, $id);
                    if (($result["total"] ?? 0) > 0) {
                        $actionResult =
                            "Avízo bolo ručne zaradené pre článok. Počet príjemcov vo fronte: " .
                            (int) $result["total"] .
                            ".";
                    } else {
                        $actionError =
                            "Avízo sa nepodarilo zaradiť. Skontrolujte, či je článok zverejnený.";
                    }
                } catch (\Throwable $e) {
                    error_log(
                        "admin_articles enqueue_newsletter error: " .
                            $e->getMessage(),
                    );
                    $actionError = "Chyba pri ručnom zaradení avíza.";
                }
                break;

            // ── NEWSLETTER: ZNOVU ZARADIŤ NEODOSLANÉ ───────────────────
            case "requeue_failed_newsletter":
                $id = (int) ($_POST["article_id"] ?? 0);
                if ($id <= 0) {
                    $actionError = "Neplatné ID článku.";
                    break;
                }
                try {
                    $requeuedCount = requeueFailedArticleNewsletter($pdo, $id);
                    if ($requeuedCount > 0) {
                        $actionResult =
                            "Neodoslané avíza boli znovu zaradené do fronty. Počet: " .
                            $requeuedCount .
                            ".";
                    } else {
                        $actionError =
                            "Pre tento článok neboli nájdené neodoslané avíza na znovuzaradenie.";
                    }
                } catch (\Throwable $e) {
                    error_log(
                        "admin_articles requeue_failed_newsletter error: " .
                            $e->getMessage(),
                    );
                    $actionError = "Chyba pri znovuzaradení neodoslaných avíz.";
                }
                break;

            // ── NEWSLETTER: ODOSLAŤ DUE NOW POLOŽKY ───────────────────
            case "send_newsletter_queue":
                $limit = (int) ($_POST["send_limit"] ?? 50);
                $limit = max(1, min(200, $limit));
                try {
                    $stats    = processArticleNewsletterQueue($pdo, $limit, 5);
                    $subStats = processNlSubQueue($pdo, $limit, 5);
                    $selected  = (int) ($stats["selected"] ?? 0) + (int) ($subStats["selected"] ?? 0);
                    $sent      = (int) ($stats["sent"] ?? 0) + (int) ($subStats["sent"] ?? 0);
                    $failed    = (int) ($stats["failed"] ?? 0) + (int) ($subStats["failed"] ?? 0);
                    $cancelled = (int) ($stats["cancelled"] ?? 0) + (int) ($subStats["cancelled"] ?? 0);
                    $skipped   = (int) ($stats["skipped"] ?? 0) + (int) ($subStats["skipped"] ?? 0);

                    if ($selected === 0) {
                        $actionResult =
                            "Vo fronte nie sú žiadne položky pripravené na odoslanie.";
                    } else {
                        $actionResult =
                            "Odoslanie avíz dokončené. Vybrané: " .
                            $selected .
                            ", odoslané: " .
                            $sent .
                            ", zlyhané: " .
                            $failed .
                            ", zrušené: " .
                            $cancelled .
                            ", preskočené: " .
                            $skipped .
                            ".";
                    }
                } catch (\Throwable $e) {
                    error_log(
                        "admin_articles send_newsletter_queue error: " .
                            $e->getMessage(),
                    );
                    $actionError = "Chyba pri odosielaní avíz.";
                }
                break;

            // ── NEWSLETTER: ZMAZAŤ ČAKAJÚCE ─────────────────────────────
            case "delete_pending_newsletter":
                $articleId = (int) ($_POST["article_id"] ?? 0);
                try {
                    if ($articleId > 0) {
                        $delStmt = $pdo->prepare(
                            "DELETE FROM article_newsletter_queue WHERE status = 'pending' AND article_id = :article_id",
                        );
                        $delStmt->execute(["article_id" => $articleId]);
                    } else {
                        $delStmt = $pdo->prepare(
                            "DELETE FROM article_newsletter_queue WHERE status = 'pending'",
                        );
                        $delStmt->execute();
                    }
                    $deletedCount = $delStmt->rowCount();
                    $actionResult =
                        "Zmazaných " .
                        $deletedCount .
                        " čakajúcich avíz" .
                        ($articleId > 0 ? " pre daný článok" : "") .
                        ".";
                } catch (\PDOException $e) {
                    error_log(
                        "admin_articles delete_pending_newsletter error: " .
                            $e->getMessage(),
                    );
                    $actionError = "Chyba pri mazaní čakajúcich avíz.";
                }
                break;

            // ── TOP TOGGLE ───────────────────────────────────────────────
            case "set_top":
                $id = (int) ($_POST["article_id"] ?? 0);
                $setTop = (int) ($_POST["set_top"] ?? -1);
                if ($id <= 0) {
                    $actionError = "Neplatné ID článku.";
                    break;
                }
                if (!in_array($setTop, [0, 1], true)) {
                    $actionError = "Neplatná hodnota TOP príznaku.";
                    break;
                }
                try {
                    $chk = $pdo->prepare(
                        "SELECT title FROM articles WHERE id = :id LIMIT 1",
                    );
                    $chk->execute(["id" => $id]);
                    $row = $chk->fetch();
                    if (!$row) {
                        $actionError = "Článok nenájdený.";
                        break;
                    }

                    $upd = $pdo->prepare(
                        "UPDATE articles SET is_top = :is_top WHERE id = :id",
                    );
                    $upd->execute(["is_top" => $setTop, "id" => $id]);

                    $titleSafe = htmlspecialchars(
                        (string) ($row["title"] ?? ""),
                    );
                    $actionResult =
                        $setTop === 1
                            ? "Článok „" .
                                $titleSafe .
                                "“ bol označený ako TOP."
                            : "Článok „" .
                                $titleSafe .
                                "“ bol vyradený z TOP sekcie.";
                } catch (\PDOException $e) {
                    error_log(
                        "admin_articles set_top error: " . $e->getMessage(),
                    );
                    $actionError = "Chyba pri zmene TOP príznaku.";
                }
                break;

            // ── MOVE UP ─────────────────────────────────────────────────
            case "move_up":
                $id = (int) ($_POST["article_id"] ?? 0);
                if ($id <= 0) {
                    $actionError = "Neplatné ID článku.";
                    break;
                }
                try {
                    $pdo->beginTransaction();
                    $currentStmt = $pdo->prepare(
                        "SELECT sort_order FROM articles WHERE id = :id",
                    );
                    $currentStmt->execute(["id" => $id]);
                    $current = $currentStmt->fetch();
                    if (!$current) {
                        $pdo->rollBack();
                        $actionError = "Článok nenájdený.";
                        break;
                    }
                    $currentSort = (int) $current["sort_order"];
                    $prevStmt = $pdo->prepare(
                        "SELECT id FROM articles WHERE sort_order < :sort ORDER BY sort_order DESC LIMIT 1",
                    );
                    $prevStmt->execute(["sort" => $currentSort]);
                    $prev = $prevStmt->fetch();
                    if (!$prev) {
                        $pdo->rollBack();
                        $actionError = "Nie je čím ísť vyššie.";
                        break;
                    }
                    $prevId = (int) $prev["id"];
                    $prevSortStmt = $pdo->prepare(
                        "SELECT sort_order FROM articles WHERE id = :id",
                    );
                    $prevSortStmt->execute(["id" => $prevId]);
                    $prevSort = (int) $prevSortStmt->fetch()["sort_order"];
                    $pdo->prepare(
                        "UPDATE articles SET sort_order = :sort WHERE id = :id",
                    )->execute(["sort" => $prevSort, "id" => $id]);
                    $pdo->prepare(
                        "UPDATE articles SET sort_order = :sort WHERE id = :id",
                    )->execute(["sort" => $currentSort, "id" => $prevId]);
                    $pdo->commit();
                    $actionResult = "Článok bol presunutý vyššie.";
                } catch (\PDOException $e) {
                    $pdo->rollBack();
                    error_log(
                        "admin_articles move_up error: " . $e->getMessage(),
                    );
                    $actionError = "Chyba pri presúvaní.";
                }
                break;

            // ── MOVE DOWN ───────────────────────────────────────────────
            case "move_down":
                $id = (int) ($_POST["article_id"] ?? 0);
                if ($id <= 0) {
                    $actionError = "Neplatné ID článku.";
                    break;
                }
                try {
                    $pdo->beginTransaction();
                    $currentStmt = $pdo->prepare(
                        "SELECT sort_order FROM articles WHERE id = :id",
                    );
                    $currentStmt->execute(["id" => $id]);
                    $current = $currentStmt->fetch();
                    if (!$current) {
                        $pdo->rollBack();
                        $actionError = "Článok nenájdený.";
                        break;
                    }
                    $currentSort = (int) $current["sort_order"];
                    $nextStmt = $pdo->prepare(
                        "SELECT id FROM articles WHERE sort_order > :sort ORDER BY sort_order ASC LIMIT 1",
                    );
                    $nextStmt->execute(["sort" => $currentSort]);
                    $next = $nextStmt->fetch();
                    if (!$next) {
                        $pdo->rollBack();
                        $actionError = "Nie je čím ísť nižšie.";
                        break;
                    }
                    $nextId = (int) $next["id"];
                    $nextSortStmt = $pdo->prepare(
                        "SELECT sort_order FROM articles WHERE id = :id",
                    );
                    $nextSortStmt->execute(["id" => $nextId]);
                    $nextSort = (int) $nextSortStmt->fetch()["sort_order"];
                    $pdo->prepare(
                        "UPDATE articles SET sort_order = :sort WHERE id = :id",
                    )->execute(["sort" => $nextSort, "id" => $id]);
                    $pdo->prepare(
                        "UPDATE articles SET sort_order = :sort WHERE id = :id",
                    )->execute(["sort" => $currentSort, "id" => $nextId]);
                    $pdo->commit();
                    $actionResult = "Článok bol presunutý nižšie.";
                } catch (\PDOException $e) {
                    $pdo->rollBack();
                    error_log(
                        "admin_articles move_down error: " . $e->getMessage(),
                    );
                    $actionError = "Chyba pri presúvaní.";
                }
                break;

            // ── DELETE ──────────────────────────────────────────────────────
            case "delete":
                $id = (int) ($_POST["article_id"] ?? 0);
                if ($id <= 0) {
                    $actionError = "Neplatné ID článku.";
                    break;
                }
                try {
                    $chk = $pdo->prepare(
                        "SELECT title FROM articles WHERE id = :id LIMIT 1",
                    );
                    $chk->execute(["id" => $id]);
                    $row = $chk->fetch();
                    if (!$row) {
                        $actionError = "Článok nenájdený.";
                        break;
                    }
                    $pdo->prepare(
                        "DELETE FROM articles WHERE id = :id",
                    )->execute(["id" => $id]);
                    $actionResult =
                        "Článok „" .
                        htmlspecialchars((string) $row["title"]) .
                        '" bol odstránený.';
                } catch (\PDOException $e) {
                    error_log(
                        "admin_articles delete error: " . $e->getMessage(),
                    );
                    $actionError = "Chyba pri mazaní článku.";
                }
                break;
        }
    }
}

// ── Načítanie článku na editáciu (GET) ────────────────────────────────────────
$editId = (int) ($_GET["id"] ?? 0);
if (($_GET["action"] ?? "") === "edit" && $editId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id LIMIT 1");
        $stmt->execute(["id" => $editId]);
        $editArticle = $stmt->fetch() ?: null;
    } catch (\PDOException $e) {
        error_log("admin_articles edit load error: " . $e->getMessage());
    }
}

// ── Načítanie článkov pre zoznam s podporou stránkovania ─────────────────────
$articles = [];
$articlesTotal = 0;
$articleAuthorOptions = [];
$articlesPerPage = 50; // počet článkov na stránku v administračnom zobrazení
$articlesPage = max(1, (int) ($_GET['page'] ?? 1));
$articlesOffset = ($articlesPage - 1) * $articlesPerPage;
try {
    $totalStmt = $pdo->query("SELECT COUNT(*) FROM articles");
    $articlesTotal = (int) $totalStmt->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT id, title, slug, author, published_at, is_top, is_published, created_at, sort_order
         FROM articles ORDER BY is_top DESC, published_at DESC, id DESC LIMIT :limit OFFSET :offset",
    );
    $stmt->bindValue(':limit', $articlesPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $articlesOffset, PDO::PARAM_INT);
    $stmt->execute();
    $articles = $stmt->fetchAll();
    $articlesTotalPages = $articlesPerPage > 0 ? (int) ceil($articlesTotal / $articlesPerPage) : 1;
} catch (\PDOException $e) {
    error_log("admin_articles list error: " . $e->getMessage());
}

try {
    $authorStmt = $pdo->query(
        "SELECT DISTINCT TRIM(author) AS author_name
         FROM articles
         WHERE TRIM(author) <> ''
         ORDER BY author_name ASC",
    );
    $articleAuthorOptions = array_values(
        array_filter(
            array_map(
                static fn ($author): string => trim((string) $author),
                $authorStmt->fetchAll(\PDO::FETCH_COLUMN),
            ),
            static fn (string $author): bool => $author !== "",
        ),
    );
} catch (\PDOException $e) {
    error_log("admin_articles authors list error: " . $e->getMessage());
}

try {
    $queueSummary = getNewsletterQueueSummary($pdo);
    $articleQueueStats = getArticleNewsletterQueueStats($pdo);
    $queueRecent = getNewsletterQueueRecent(
        $pdo,
        30,
        $queueFilterStatus,
        $queueFilterArticleId,
        $queuePreset,
    );
} catch (\Throwable $e) {
    error_log(
        "admin_articles newsletter queue read error: " . $e->getMessage(),
    );
}

// CSRF token: volať AŽ PO spracovaní POST — po rotacíach bude v session nový token,
// ale $csrfToken v PHP získa správnu (aktuálnu) hodnotu pre všetky formuláre na stránke.
$csrfToken = generateCsrfToken();

$pageLastUpdated = date("d.m.Y H:i", filemtime(__FILE__));
$pageTimeZone = date("T") . " (" . date_default_timezone_get() . ")";
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Správa článkov – Nefro-projekt Slovensko</title>
  <meta name="robots" content="noindex, nofollow">
  <script src="theme.js?v=20260509-1&cb=<?= filemtime("theme.js") ?>"></script>
  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime(
      "index.css",
  ) ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
  <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime(
      "ui-preferences.js",
  ) ?>" defer></script>
  <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime(
      "ui-preferences-fallback.js",
  ) ?>" defer></script>
  <script src="nefro-ui.js?v=<?= filemtime('nefro-ui.js') ?>" defer></script>
</head>
<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
  <?php
  $headerTitle = "Správa článkov";
  $headerIntro = "CRUD rozhranie pre správu článkov";
  $showLogo = false;
  include "header.php";
  include 'admin_menu.php';
  ?>

  <main id="main-content" class="container container--wide admin-page-main" role="main">
    <div class="auth-container auth-container--wide">
      <h2>Správa článkov</h2>
      <p class="auth-subtitle">Pridávanie, úprava a mazanie článkov na hlavnej stránke.</p>

      <?php if ($actionResult !== null): ?>
        <div class="alert alert-success"><p>
          <?= htmlspecialchars((string) $actionResult) ?>
          <?php if ($actionResultLink !== null): ?>
            <?= $actionResultLink
              /* $actionResultLink je bezpečný — obsahuje výhradne int ID v href */
              ?>
          <?php endif; ?>
        </p></div>
      <?php endif; ?>
      <?php if ($actionError !== null): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars(
            $actionError,
        ) ?></p></div>
      <?php endif; ?>

      <!-- ── FORMULÁR (pridanie / editácia) ─────────────────────────── -->
      <div class="primary-article">
        <h3><?= $editArticle ? "Upraviť článok" : "Pridať nový článok" ?></h3>

        <form method="POST" action="admin_articles.php" id="articleForm">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
              $csrfToken,
          ) ?>">
          <input type="hidden" name="action"     value="<?= $editArticle
              ? "update"
              : "create" ?>">
          <?php if ($editArticle): ?>
            <input type="hidden" name="article_id" value="<?= (int) $editArticle[
                "id"
            ] ?>">
          <?php endif; ?>

          <div class="article-form-grid">
            <div class="form-row">
              <label for="f_title">Titulok článku <span class="text-error">*</span></label>
              <input type="text" id="f_title" name="title" required maxlength="500"
                     value="<?= htmlspecialchars(
                         (string) ($editArticle["title"] ?? ""),
                     ) ?>"
                     placeholder="Titulok článku">
            </div>

            <div class="form-row">
              <label for="f_slug">Slug (URL identifikátor)</label>
              <input type="text" id="f_slug" name="slug" maxlength="500"
                     value="<?= htmlspecialchars(
                         (string) ($editArticle["slug"] ?? ""),
                     ) ?>"
                     placeholder="napr. moj-clanok-o-nefrologii (nechajte prázdne pre automatické generovanie)">
              <span class="helper-text">Používajte len malé písmená, číslice a pomlčky. Ak necháte prázdne, slug sa vygeneruje automaticky z titulku.</span>
            </div>

            <div class="form-row">
              <label for="f_author">Autor</label>
              <input type="text" id="f_author" name="author" maxlength="255" list="article-author-options"
                     value="<?= htmlspecialchars(
                         (string) ($editArticle["author"] ??
                             "MUDr. Ľubomír Polaščín"),
                     ) ?>">
              <?php if (!empty($articleAuthorOptions)): ?>
                <datalist id="article-author-options">
                  <?php foreach ($articleAuthorOptions as $authorOption): ?>
                    <option value="<?= htmlspecialchars($authorOption, ENT_QUOTES, "UTF-8") ?>"></option>
                  <?php endforeach; ?>
                </datalist>
              <?php endif; ?>
              <span class="helper-text">Používajte konzistentný zápis mena. Podľa tejto hodnoty sa počíta zoznam autorov v sekcii „O projekte“.</span>
            </div>

            <div class="form-row">
              <label for="f_excerpt">Perex / excerpt</label>
              <textarea id="f_excerpt" name="excerpt" rows="3" maxlength="600"
                        placeholder="Krátky úvodný text zobrazovaný v zozname článkov (čistý text, bez HTML)"><?= htmlspecialchars(
                            (string) ($editArticle["excerpt"] ?? ""),
                        ) ?></textarea>
              <span class="helper-text">Čistý text bez HTML. Odporúčaná dĺžka je približne 120 až 220 znakov. Ak perex necháte prázdny, systém ho vygeneruje z obsahu článku.</span>
            </div>

            <div class="form-row">
              <label for="f_content">Obsah článku (HTML) <span class="text-error">*</span></label>
              <textarea id="f_content" name="content" required
                        placeholder="Plný HTML obsah článku (odseky, h3 nadpisy, zoznamy atď.)"><?= htmlspecialchars(
                            (string) ($editArticle["content"] ?? ""),
                        ) ?></textarea>
              <span class="helper-text">Zadajte HTML obsah článku bez obaľujúcich tagov &lt;article&gt;, &lt;header&gt; a &lt;footer&gt;. Tieto sa generujú automaticky.</span>
            </div>

            <div class="form-row">
              <label for="f_published_at">Dátum publikácie <span class="text-error">*</span></label>
              <input type="date" id="f_published_at" name="published_at" required
                     value="<?= htmlspecialchars(
                         substr(
                             (string) ($editArticle["published_at"] ??
                                 date("Y-m-d")),
                             0,
                             10,
                         ),
                     ) ?>">
            </div>

            <div class="form-row-inline">
              <label>
                <input type="checkbox" name="is_top" value="1"
                  <?= !empty($editArticle) && (int) $editArticle["is_top"] === 1
                      ? "checked"
                      : "" ?>>
                ★ Odporúčaný článok (TOP sekcia)
              </label>
              <label>
                <input type="checkbox" name="is_published" value="1"
                  <?= empty($editArticle) ||
                  (int) $editArticle["is_published"] === 1
                      ? "checked"
                      : "" ?>>
                Zverejnený
              </label>
            </div>
          </div>

          <div class="form-actions admin-action-mt">
            <button type="submit" class="btn-primary">
              <?= $editArticle ? "💾 Uložiť zmeny" : "➕ Pridať článok" ?>
            </button>
            <?php if ($editArticle): ?>
              <a href="admin_articles.php" class="btn-secondary-small">Zrušiť editáciu</a>
              <a href="article.php?id=<?= (int) $editArticle[
                  "id"
              ] ?>" target="_blank" class="btn-secondary-small">👁 Zobraziť</a>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <hr class="section-divider">

      <!-- ── NEWSLETTER FRONTA ──────────────────────────────────────── -->
      <div class="primary-article">
        <h3>Fronta e-mailových avíz</h3>
        <p class="helper-text">Automatické notifikácie pre používateľov so súhlasom s novinkami (bez SMS).</p>

        <form method="GET" action="admin_articles.php" class="form-row-inline admin-filter-form">
          <input type="hidden" name="q_preset" value="<?= htmlspecialchars(
              $queuePreset,
          ) ?>">
          <label for="q_status">Stav:</label>
          <select id="q_status" name="q_status" class="form-control admin-select-sm">
            <option value="" <?= $queueFilterStatus === ""
                ? "selected"
                : "" ?>>Všetky</option>
            <option value="pending" <?= $queueFilterStatus === "pending"
                ? "selected"
                : "" ?>>Čakajúce</option>
            <option value="failed" <?= $queueFilterStatus === "failed"
                ? "selected"
                : "" ?>>Neúspešné</option>
            <option value="sent" <?= $queueFilterStatus === "sent"
                ? "selected"
                : "" ?>>Odoslané</option>
            <option value="cancelled" <?= $queueFilterStatus === "cancelled"
                ? "selected"
                : "" ?>>Zrušené</option>
          </select>

          <label for="q_article_id">Článok:</label>
          <select id="q_article_id" name="q_article_id" class="form-control admin-select-md">
            <option value="0">Všetky články</option>
            <?php foreach ($articles as $filterArticle): ?>
              <?php $filterArticleId = (int) ($filterArticle["id"] ?? 0); ?>
              <option value="<?= $filterArticleId ?>" <?= $queueFilterArticleId ===
$filterArticleId
    ? "selected"
    : "" ?>>
                #<?= $filterArticleId ?> — <?= htmlspecialchars(
     (string) ($filterArticle["title"] ?? ""),
 ) ?>
              </option>
            <?php endforeach; ?>
          </select>

          <button type="submit" class="btn-secondary-small">Filtrovať</button>
          <a href="admin_articles.php?q_preset=unsent<?= $queueFilterArticleId >
          0
              ? "&q_article_id=" . $queueFilterArticleId
              : "" ?>" class="btn-secondary-small">Len neodoslané</a>
          <a href="admin_articles.php?q_preset=due_now<?= $queueFilterArticleId >
          0
              ? "&q_article_id=" . $queueFilterArticleId
              : "" ?>" class="btn-secondary-small">Len pripravené</a>
          <a href="admin_articles.php" class="btn-secondary-small">Reset</a>
        </form>

        <?php if ($queuePreset === "unsent"): ?>
          <p class="helper-text admin-helper-neg">Aktívny rýchly filter: len neodoslané (čakajúce + neúspešné).</p>
        <?php elseif ($queuePreset === "due_now"): ?>
          <p class="helper-text admin-helper-neg">Aktívny rýchly filter: len pripravené na odoslanie (čakajúce + neúspešné).</p>
        <?php endif; ?>

        <div class="form-row-inline admin-tag-section">
          <span class="badge-pub">Čakajúce: <?= (int) ($queueSummary[
              "pending"
          ] ?? 0) ?></span>
          <span class="badge-draft">Neúspešné: <?= (int) ($queueSummary[
              "failed"
          ] ?? 0) ?></span>
          <span class="badge-top-sm">Odoslané: <?= (int) ($queueSummary["sent"] ??
              0) ?></span>
          <span class="badge-draft badge-neutral">Zrušené: <?= (int) ($queueSummary[
              "cancelled"
          ] ?? 0) ?></span>
          <span class="badge-pub badge-info">Pripravené: <?= (int) ($queueSummary[
              "due_now"
          ] ?? 0) ?></span>
          <form method="POST" action="admin_articles.php" class="d-inline ml-8"
                data-confirm="Naozaj chcete odoslať avíza pripravené na odoslanie?">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                $csrfToken,
            ) ?>">
            <input type="hidden" name="action" value="send_newsletter_queue">
            <input type="hidden" name="send_limit" value="50">
            <button type="submit" class="btn-secondary-small" title="Odoslať položky z fronty, ktoré sú pripravené na odoslanie">Odoslať</button>
          </form>
          <form method="POST" action="admin_articles.php" class="d-inline ml-8"
                data-confirm="Naozaj chcete natrvalo zmazať všetky čakajúce avíza<?= $queueFilterArticleId > 0 ? ' pre tento článok' : '' ?>?">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                $csrfToken,
            ) ?>">
            <input type="hidden" name="action" value="delete_pending_newsletter">
            <?php if ($queueFilterArticleId > 0): ?>
              <input type="hidden" name="article_id" value="<?= $queueFilterArticleId ?>">
            <?php endif; ?>
            <button type="submit" class="btn-secondary-small btn-danger-sm"
                    title="Natrvalo zmazať čakajúce avíza<?= $queueFilterArticleId > 0 ? ' pre daný článok' : '' ?>"
                    <?= (int) ($queueSummary["pending"] ?? 0) === 0 ? 'disabled' : '' ?>>Zmazať čakajúce</button>
          </form>
        </div>

        <?php if (!empty($queueRecent)): ?>
          <div class="admin-table-overflow">
            <table class="admin-articles-table" aria-label="Posledné položky fronty noviniek">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Článok</th>
                  <th scope="col">Používateľ</th>
                  <th scope="col">Stav</th>
                  <th scope="col">Pokusy</th>
                  <th scope="col">Aktualizované</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($queueRecent as $q): ?>
                  <tr>
                    <td><?= (int) ($q["id"] ?? 0) ?></td>
                    <td><?= htmlspecialchars(
                        (string) ($q["article_title"] ??
                            "#" . (int) ($q["article_id"] ?? 0)),
                    ) ?></td>
                    <td><?= htmlspecialchars(
                        (string) ($q["username"] ?? ($q["email"] ?? "")),
                    ) ?></td>
                    <td><?= htmlspecialchars(
                        strtoupper((string) ($q["status"] ?? "")),
                    ) ?></td>
                    <td><?= (int) ($q["attempts"] ?? 0) ?></td>
                    <td><?= htmlspecialchars(
                        (string) ($q["updated_at"] ?? ""),
                    ) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="calc-result-mt12">Fronta je zatiaľ prázdna.</p>
        <?php endif; ?>
      </div>

      <hr class="section-divider">

      <!-- ── ZOZNAM ČLÁNKOV ──────────────────────────────────────────── -->
      <div class="primary-article">
        <h3>Všetky články (<?= (int) ($articlesTotal ?? count($articles)) ?>)</h3>

        <?php if (empty($articles)): ?>
          <p>Zatiaľ žiadne články. Pridajte prvý vyššie.</p>
        <?php else: ?>
          <div class="overflow-x-auto">
            <table class="admin-articles-table" aria-label="Zoznam článkov">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Poradie</th>
                  <th scope="col">Titulok</th>
                  <th scope="col">Dátum</th>
                  <th scope="col">Stav</th>
                  <th scope="col">Akcie</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $articleCount = count($articles);
                foreach ($articles as $idx => $a):

                    $aId = (int) $a["id"];
                    $aTitle = htmlspecialchars((string) $a["title"]);
                    $aDate = htmlspecialchars(
                        substr((string) $a["published_at"], 0, 10),
                    );
                    $aTop = (int) $a["is_top"] === 1;
                    $aPub = (int) $a["is_published"] === 1;
                    $qStats = $articleQueueStats[$aId] ?? [
                        "pending" => 0,
                        "failed" => 0,
                        "sent" => 0,
                        "cancelled" => 0,
                    ];
                    $isFirst = $idx === 0;
                    $isLast = $idx === $articleCount - 1;
                    ?>
                <tr>
                  <td><?= $aId ?></td>
                  <td class="admin-article-title"><?= $idx +
                      1 ?></td>
                  <td>
                    <a href="article.php?id=<?= $aId ?>" target="_blank"><?= $aTitle ?></a>
                    <?php if (
                        $aTop
                    ): ?><br><span class="badge-top-sm">★ TOP</span><?php endif; ?>
                  </td>
                  <td><?= $aDate ?></td>
                  <td>
                    <?php if ($aPub): ?>
                      <span class="badge-pub">Zverejnený</span>
                    <?php else: ?>
                      <span class="badge-draft">Skrytý</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="admin-article-meta">
                      P: <?= (int) ($qStats["pending"] ?? 0) ?> |
                      F: <?= (int) ($qStats["failed"] ?? 0) ?> |
                      S: <?= (int) ($qStats["sent"] ?? 0) ?>
                    </div>
                    <?php if (!$isFirst): ?>
                      <form method="POST" action="admin_articles.php" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                            $csrfToken,
                        ) ?>">
                        <input type="hidden" name="action" value="move_up">
                        <input type="hidden" name="article_id" value="<?= $aId ?>">
                        <button type="submit" class="btn-secondary-small" title="Hore">▲</button>
                      </form>
                    <?php endif; ?>
                    <?php if (!$isLast): ?>
                      <form method="POST" action="admin_articles.php" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                            $csrfToken,
                        ) ?>">
                        <input type="hidden" name="action" value="move_down">
                        <input type="hidden" name="article_id" value="<?= $aId ?>">
                        <button type="submit" class="btn-secondary-small" title="Dole">▼</button>
                      </form>
                    <?php endif; ?>
                    <form method="POST" action="admin_articles.php" class="d-inline"<?= $aTop
                        ? ' data-confirm="Naozaj chcete vyradiť tento článok z TOP sekcie?"'
                        : "" ?>>
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                          $csrfToken,
                      ) ?>">
                      <input type="hidden" name="action" value="set_top">
                      <input type="hidden" name="article_id" value="<?= $aId ?>">
                      <input type="hidden" name="set_top" value="<?= $aTop
                          ? 0
                          : 1 ?>">
                      <?php if ($aTop): ?>
                        <button type="submit" class="btn-secondary-small" title="Vypnúť TOP pre tento článok">☆ TOP vypnúť</button>
                      <?php else: ?>
                        <button type="submit" class="btn-secondary-small" title="Zapnúť TOP pre tento článok">★ TOP zapnúť</button>
                      <?php endif; ?>
                    </form>
                    <a href="admin_articles.php?action=edit&id=<?= $aId ?>" class="btn-secondary-small">✏️ Upraviť</a>
                    <form method="POST" action="admin_articles.php" class="d-inline">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                          $csrfToken,
                      ) ?>">
                      <input type="hidden" name="action" value="enqueue_newsletter">
                      <input type="hidden" name="article_id" value="<?= $aId ?>">
                      <button type="submit" class="btn-secondary-small" title="Ručne odoslať avízo pre tento článok" <?= $aPub
                          ? ""
                          : "disabled" ?>>📧 Avízo teraz</button>
                    </form>
                    <form method="POST" action="admin_articles.php" class="d-inline">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                          $csrfToken,
                      ) ?>">
                      <input type="hidden" name="action" value="requeue_failed_newsletter">
                      <input type="hidden" name="article_id" value="<?= $aId ?>">
                      <button type="submit" class="btn-secondary-small" title="Znovu zaradiť neodoslané avíza">↻ Neodoslané</button>
                    </form>
                    &nbsp;
                    <form method="POST" action="admin_articles.php" class="d-inline"
                        data-confirm="Naozaj chcete odstrániť tento článok?">
                      <input type="hidden" name="csrf_token"  value="<?= htmlspecialchars(
                          $csrfToken,
                      ) ?>">
                      <input type="hidden" name="action"      value="delete">
                      <input type="hidden" name="article_id"  value="<?= $aId ?>">
                      <button type="submit" class="btn-secondary-small btn-danger-outline">🗑 Zmazať</button>
                    </form>
                  </td>
                </tr>
                <?php
                endforeach;
                ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
                <?php if (!empty($articlesTotalPages) && $articlesTotalPages > 1): ?>
                    <nav class="articles-pagination admin-pagination" aria-label="Stránkovanie článkov">
                        <span class="articles-pagination__label">Stránky:</span>
                        <div class="articles-pagination__links">
                            <?php for ($p = 1; $p <= $articlesTotalPages; $p++): ?>
                                <?php if ($p === $articlesPage): ?>
                                    <span class="articles-page-link is-active" aria-current="page"><?= $p ?></span>
                                <?php else: ?>
                                    <a class="articles-page-link" href="admin_articles.php?page=<?= $p ?>"><?= $p ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </nav>
                <?php endif; ?>
      </div>

    </div><!-- /.auth-container -->
  </main>

  <?php include "footer.php"; ?>

</body>
</html>
