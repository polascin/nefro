<?php
declare(strict_types=1);

$p = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.audit.md';
$t = file_get_contents($p);
if ($t === false) {
    fwrite(STDERR, "read fail\n");
    exit(1);
}
$nl = str_contains($t, "\r\n") ? "\r\n" : "\n";
$lines = preg_split("/\r\n|\n/", $t);
$beh103 = '| 2026-09-01 | **Beh 103** (vykonanie `.doaudit.md`; delta od Behu 102: `63f757b` — KFRE predvolená kalibrácia mimo NA podľa Tangri 2016 a výber `kfre_region`; `9e21e0d`/`d7bdbc5`/`8a20bad`/`38166f8` — odborný článok o HF a CKD, konferencia KDIGO 2024). Rozsah podľa kroku 2: nový PHP kód ⇒ plný audit vrátane CSRF/XSS/CSP a §15/§16 na nový článok. **Opravené:** **1× SK-01** — predložka *mimo* s akuzatívom „mimo Severnú Ameriku“ v KFRE UI, Ambulantnej a docblocku `ckd_risk_models.php` → genitív *mimo Severnej Ameriky*. **1× SK/SEO** — `$seoDescription` a header intro ostali na „Tangri 2024“ po oprave vzorca; opravené na Tangri 2011/2016. **1× UX** — tabuľka uložených výsledkov KFRE ukáže kalibráciu, ak je v payloade. Delta inak: CSRF na POST, whitelist `non_na` / `na`, `htmlspecialchars`, `label for=kfre_region`, FilesMatch už má `ckd_risk_models.php`; `kfre_region` nie je PII. **§15:** 12 PMID (esummary) — názvy, ročník/strany a 14 menovaných autorov písacieho výboru sedia; duálna publikácia KI+JACC HF je jedna práca; Crossref KI má 55 mien vrátane Conference Participants (widget správne len 14). Šablóna CLI/admin + UPSERT, `<th scope>`, bez LaTeX/meta-komentárov/`style=`. **§16:** KDIGO PDF 200; PubMed 203; AHA/OUP/NEJM 403 anti-bot; žiadny 404. Interné súvisiace sluggy 200, 0 PHP chýb. **Kontroly:** PHPStan 0 (PHP 8.5.8, `--memory-limit=1G`); PHP lint 428/0; CS-Fixer 0/3 zmenených PHP, 5 CRLF FP na právnych stránkach; JS consent PASS; unit testy 82 PASS; dymový test kódovanie 495 PASS, HTTP časť bez lokálneho servera (známa výnimka); živá kontrola tela úvod, KFRE, Ambulantná, CKD-PC, nový článok, právne, sitemap: 0 PHP chýb, 0 únikov `/data/8/`; 10 knižníc 403; JSON MKCH-10 200 / 1,47 MB; SQL konkatenácia prázdna; `consentVersion` `2026-07-16` zhoda, žiadny nový `localStorage` kľúč; drift pred kolo-1 commitom 0 (`38166f8`). **Otvorené z Behu 97 (bez zmeny):** 11 faktických ODB nálezov a 3 právno-organizačné GDPR body. |';
$beh101 = '| 2026-09-01 | **Beh 101** — Ambulantná kalkulačka: FilesMatch 3 knižníc, KDIGO G4×A1 heatmapa, PHPStan import MKCH-10; kolo 2 `0e71c47` konvergencia. |';

$out = [];
$found101 = false;
$found102 = false;
foreach ($lines as $line) {
    if (str_starts_with($line, '| 2026-09-01 | **Beh 102**')) {
        $out[] = $beh103;
        $found102 = true;
        $out[] = $line;
        continue;
    }
    if (str_starts_with($line, '| 2026-09-01 | **Beh 101**')) {
        $out[] = $beh101;
        $found101 = true;
        continue;
    }
    $out[] = $line;
}
if (!$found102 || !$found101) {
    fwrite(STDERR, "missing rows 102=$found102 101=$found101\n");
    exit(1);
}
$t2 = implode($nl, $out);
$oldFooter = '**Aktualizované:** 2026-09-01 (**Beh 102** — Ambulantná kalkulačka: vek z dátumu/roku narodenia, classifier `birth_*` v logoch/GA, info box že sa neukladá. Detaily v tabuľke História auditov.)';
$newFooter = '**Aktualizované:** 2026-09-01 (**Beh 103** — KFRE: genitív *mimo Severnej Ameriky*, SEO Tangri 2011/2016, kalibrácia v uložených výsledkoch. Detaily v tabuľke História auditov.)';
$t2 = str_replace($oldFooter, $newFooter, $t2);
if (!str_contains($t2, '**Beh 103**') || !str_contains($t2, $newFooter)) {
    fwrite(STDERR, "beh103/footer missing\n");
    exit(1);
}
file_put_contents($p, $t2);
echo "ok lines " . count($out) . " nl=" . ($nl === "\r\n" ? 'CRLF' : 'LF') . "\n";
