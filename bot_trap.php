<?php

declare(strict_types=1);
/**
 * bot_trap.php — honeypot pre crawlery, ktoré ignorujú robots.txt
 * ────────────────────────────────────────────────────────────────────────────
 * Na túto stránku vedie v pätičke odkaz skrytý cez `display:none` (teda
 * neviditeľný aj pre čítačky obrazovky) a robots.txt ju výslovne zakazuje.
 * Bežný návštevník sa sem nedostane; slušný crawler sem nepôjde. Kto sem
 * predsa príde, prezradil, že robots.txt ignoruje — dostane dočasný ban.
 *
 * Overené vyhľadávače sú z pasce vyňaté, aby omyl v ich crawleri nezhodil
 * indexovanie celého webu.
 */

require_once __DIR__ . '/bot_guard.php';

$ip = botGuardClientIp();
$ua = botGuardUserAgent();

$isSearch = $ua !== '' && preg_match(botGuardSearchPattern(), $ua) === 1;
$verified = $isSearch ? botGuardVerifySearchBot($ip, $ua) : null;

if ($verified !== true) {
    botGuardBan($ip, BOT_GUARD_TRAP_BAN, 'honeypot');
} else {
    botGuardLog('honeypot-skip', 'overený vyhľadávač — bez banu');
}

http_response_code(403);
header('Content-Type: text/plain; charset=utf-8');
header('X-Robots-Tag: noindex, nofollow', true);
header('Cache-Control: no-store');
echo "403 — Prístup odmietnutý.\n\n"
    . "Táto adresa je zakázaná v robots.txt a nevedie k žiadnemu obsahu.\n"
    . "Prístup na ňu je považovaný za automatizovaný zber.\n";
