<?php

declare(strict_types=1);
/**
 * patient_articles_common.php
 * ────────────────────────────────────────────────────────────────────────────
 * Zdieľané pomôcky pre popularizačné (pacientske) články, category = 'popularne'.
 * Používa sekcia „Pre pacientov" (populars.php) aj landing page dialýzy
 * (dialyza-bratislava.php — podsekcia „Dialýza a stredisko Medimpax").
 */

if (!function_exists('popSkMonths')) {
    /** @return array<int,string> */
    function popSkMonths(): array
    {
        return [
            1 => "januára", 2 => "februára", 3 => "marca", 4 => "apríla",
            5 => "mája", 6 => "júna", 7 => "júla", 8 => "augusta",
            9 => "septembra", 10 => "októbra", 11 => "novembra", 12 => "decembra",
        ];
    }
}

if (!function_exists('popFormatDate')) {
    function popFormatDate(string $datetime, array $months): string
    {
        try {
            $dt = new DateTimeImmutable($datetime, new DateTimeZone(date_default_timezone_get() ?: 'Europe/Bratislava'));
            $dt = $dt->setTimezone(new DateTimeZone(getUserTimezone()));
        } catch (\Throwable) {
            return htmlspecialchars($datetime);
        }
        return (int) $dt->format("j") . ". " . ($months[(int) $dt->format("n")] ?? "") . " " . $dt->format("Y");
    }
}

if (!function_exists('popExcerpt')) {
    function popExcerpt(string $text, int $maxLen = 200): string
    {
        $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, "UTF-8");
        $plain = trim(preg_replace("/\s+/u", " ", strip_tags($decoded)) ?? "");
        if ($plain === "") {
            return "";
        }
        if (mb_strlen($plain) <= $maxLen) {
            return $plain;
        }
        $slice = mb_substr($plain, 0, $maxLen + 1);
        $slice = preg_replace('/\s+\S*$/u', "", $slice) ?? $slice;
        return rtrim($slice, " \t\n\r\0\x0B,.;:-") . "…";
    }
}

if (!function_exists('popFirstImage')) {
    /** Vyberie URL prvého <img> z HTML obsahu článku (pre náhľad karty). */
    function popFirstImage(string $html): string
    {
        if (preg_match('/<img[^>]+src\s*=\s*["\']([^"\']+)["\']/i', $html, $m)) {
            return trim($m[1]);
        }
        return "";
    }
}

if (!function_exists('popRenderCard')) {
    /** Vyrenderuje jednu kartu článku (položka gridu .populars-grid). */
    function popRenderCard(array $art, array $months): void
    {
        $artSlug = htmlspecialchars((string) $art["slug"], ENT_QUOTES);
        $artTitle = htmlspecialchars((string) $art["title"]);
        $artExc = htmlspecialchars(popExcerpt((string) ($art["excerpt"] ?? ($art["content"] ?? "")), 200));
        $artDate = htmlspecialchars(popFormatDate((string) $art["published_at"], $months));
        $artDateIso = htmlspecialchars(substr((string) $art["published_at"], 0, 10));
        $artImg = popFirstImage((string) ($art["content"] ?? ""));
        $artIsTop = !empty($art["is_top"]);
        ?>
        <li class="popular-card">
          <a href="article.php?slug=<?= $artSlug ?>" class="popular-card__link" aria-label="Čítať článok: <?= $artTitle ?>">
            <div class="popular-card__media">
              <?php if ($artImg !== ""): ?>
                <img src="<?= htmlspecialchars($artImg, ENT_QUOTES) ?>" alt="" loading="lazy" decoding="async" class="popular-card__img">
              <?php else: ?>
                <span class="popular-card__placeholder" aria-hidden="true">🩺</span>
              <?php endif; ?>
              <?php if ($artIsTop): ?><span class="popular-card__badge">★ Odporúčané</span><?php endif; ?>
            </div>
            <div class="popular-card__body">
              <h3 class="popular-card__title"><?= $artTitle ?></h3>
              <p class="popular-card__excerpt"><?= $artExc ?></p>
              <div class="popular-card__footer">
                <time class="popular-card__date" datetime="<?= $artDateIso ?>"><?= $artDate ?></time>
                <span class="popular-card__more">Čítať ďalej &rarr;</span>
              </div>
            </div>
          </a>
        </li>
        <?php
    }
}

if (!function_exists('getPopularArticles')) {
    /**
     * Publikované popularizačné články (category = 'popularne') v poradí sekcie.
     * @return array<int,array<string,mixed>>
     */
    function getPopularArticles(\PDO $pdo): array
    {
        try {
            return $pdo->query(
                "SELECT id, title, slug, author, content, excerpt, published_at, is_top
                 FROM articles
                 WHERE is_published = 1 AND category = 'popularne'
                 ORDER BY is_top DESC, sort_order ASC, published_at DESC"
            )->fetchAll();
        } catch (\PDOException $e) {
            error_log("patient_articles_common: chyba načítania článkov: " . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('isMedimpaxPatientArticle')) {
    /**
     * Článok patrí do podsekcie „Dialýza a stredisko Medimpax", ak spomína „Medimpax".
     * Úvod sekcie („pre-pacientov-uvod") sem patrí tiež — a vďaka is_top=1 / sort_order
     * vyjde na prvé miesto podsekcie.
     */
    function isMedimpaxPatientArticle(array $art): bool
    {
        if ((string) ($art["slug"] ?? "") === "pre-pacientov-uvod") {
            return true;
        }
        return stripos((string) ($art["content"] ?? ""), "Medimpax") !== false;
    }
}

if (!function_exists('getMedimpaxPatientArticles')) {
    /**
     * Len články podsekcie „Dialýza a stredisko Medimpax".
     * @return array<int,array<string,mixed>>
     */
    function getMedimpaxPatientArticles(\PDO $pdo): array
    {
        return array_values(array_filter(getPopularArticles($pdo), 'isMedimpaxPatientArticle'));
    }
}
