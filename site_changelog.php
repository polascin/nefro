<?php

declare(strict_types=1);

/**
 * site_changelog.php
 * ════════════════════════════════════════════════════════════════════════════
 * Zoznam zmien portálu mimo článkov — nové kalkulačky, interaktívne nástroje,
 * databázy a úpravy ostatných častí webu. Používa ho týždenný newsletter
 * (newsletter_weekly_digest.php), aby okrem nových článkov avizoval aj to,
 * čo pribudlo v zvyšku portálu.
 *
 * Ako pridať záznam
 * ─────────────────
 * Nový záznam pridaj do toho istého commitu ako samotnú zmenu a do poľa
 * `date` zapíš dátum a čas, kedy zmena išla naživo (formát "Y-m-d H:i").
 * Newsletter posiela záznamy, ktoré padnú do okna od konca posledného behu
 * po teraz — pri samotnom dátume bez času sa berie 00:00, takže spätne
 * dopĺňaný záznam sa už nemusí odoslať.
 *
 * Polia
 * ─────
 *   date        "Y-m-d H:i" (alebo "Y-m-d") — kedy zmena išla naživo
 *   category    kľúč z siteChangelogCategoryLabels(): calculators | tools
 *               | content | portal
 *   title       krátky názov zmeny (bez bodky na konci)
 *   description jedna-dve vety, čo to používateľovi prináša
 *   url         relatívna cesta na portáli (napr. "calculators.php")
 *               alebo prázdne, ak zmena nemá vlastnú stránku
 *
 * Najnovšie záznamy sú hore.
 * ════════════════════════════════════════════════════════════════════════════
 */

if (!function_exists('siteChangelogCategoryLabels')) {
    /**
     * @return array<string, string>
     */
    function siteChangelogCategoryLabels(): array
    {
        return [
            'calculators' => 'Kalkulačky',
            'tools' => 'Interaktívne nástroje',
            'content' => 'Obsah a databázy',
            'portal' => 'Portál a účet',
        ];
    }
}

if (!function_exists('siteChangelogEntries')) {
    /**
     * @return list<array{date: string, category: string, title: string, description: string, url: string}>
     */
    function siteChangelogEntries(): array
    {
        return [
            [
                'date' => '2026-10-04 10:30',
                'category' => 'content',
                'title' => 'Anglické vydanie kompendia',
                'description' => 'Kompendium je od dnes aj v angličtine — 387 článkov ako abstrakt a stručné zhrnutie, syntéza na začiatku každej zo 16 kapitol, 275 strán. Číslovanie je zhodné s anglickým plným vydaním, pri každom článku je odkaz na slovenskú online verziu. Rovnakých päť formátov — PDF, EPUB, Kindle, DOCX a ODT.',
                'url' => 'publikacia.php?slug=sk-nefro-baza-1-kompendium-en',
            ],
            [
                'date' => '2026-10-04 09:30',
                'category' => 'content',
                'title' => 'SK Nefro Báza 1 Kompendium — zhustené vydanie',
                'description' => 'Do katalógu publikácií pribudlo kompendium: 387 odborných článkov spracovaných do abstraktu a štyroch až siedmich kľúčových bodov, k tomu syntéza na začiatku každej zo 16 kapitol. Celý ročník na 261 stranách namiesto 1 745, s číslovaním zhodným s plným vydaním. Rovnakých päť formátov — PDF, EPUB, Kindle, DOCX a ODT.',
                'url' => 'publikacia.php?slug=sk-nefro-baza-1-kompendium',
            ],
            [
                'date' => '2026-10-03 20:00',
                'category' => 'content',
                'title' => 'Anglické vydanie e-knihy SK Nefro Báza 1',
                'description' => 'Do katalógu publikácií pribudol anglický preklad — 387 odborných článkov na 1 782 stranách, rovnako v PDF, EPUB, Kindle, DOCX a ODT. Oproti slovenskému vydaniu neobsahuje 18 popularizačných textov pre pacientov. Pri každom článku je odkaz na jeho slovenskú online verziu.',
                'url' => 'publikacia.php?slug=sk-nefro-baza-1-en',
            ],
            [
                'date' => '2026-10-03 13:53',
                'category' => 'content',
                'title' => 'Publikácie na predaj — e-kniha SK Nefro Báza 1',
                'description' => 'Pribudla sekcia Publikácie s prvým zväzkom SK Nefro Báza 1 — 405 odborných článkov z portálu na 1 745 stranách, v jednom súbore na čítanie offline aj do tlače. Na výber je PDF, EPUB, Kindle (AZW3), DOCX a ODT; jeden formát 7 €, všetky 12 €. Platí sa prevodom alebo kartou a peňaženkou. Články na portáli zostávajú voľne dostupné bez platobnej steny.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-10-03 18:30',
                'category' => 'portal',
                'title' => 'Zásady ochrany údajov doplnené o predaj publikácií',
                'description' => 'Zásady ochrany osobných údajov popisujú spracúvanie objednávok — účely, kategórie údajov, rozlíšené doby uchovávania a platobné služby vrátane ich skutočnej roly. Pridali sme samostatné Obchodné podmienky predaja publikácií.',
                'url' => 'privacy.php',
            ],
            [
                'date' => '2026-09-24 00:38',
                'category' => 'portal',
                'title' => 'Prehľadnejšie oznámenia o právnych zmenách',
                'description' => 'E-mailové oznámenia obsahujú iba zmeny príslušnej verzie právnych dokumentov. Aj pri oneskorenom doručení zostáva zachovaný správny dátum účinnosti a príslušný súhrn zmien.',
                'url' => 'privacy.php',
            ],
            [
                'date' => '2026-09-17 18:11',
                'category' => 'calculators',
                'title' => 'eGFR sa dá zadávať aj v ml/s/1,73 m²',
                'description' => 'Pri každom poli pre eGFR je teraz voľba jednotky — ml/min/1,73 m² alebo ml/s/1,73 m². Prepnutie prepočíta už zadanú hodnotu. Prevodník jednotiek má nový riadok pre eGFR a kalkulačky eGFR ukazujú výsledok v oboch jednotkách.',
                'url' => 'calculators.php',
            ],
            [
                'date' => '2026-09-13 00:00',
                'category' => 'calculators',
                'title' => 'Ambulantná kalkulačka počíta aj z neúplných údajov',
                'description' => 'Kalkulačka vypočíta, čo sa z vyplnených polí dá, a do textu pre správu doplní prehľadnejšie zhrnutie.',
                'url' => 'calculator_ambulatory.php',
            ],
            [
                'date' => '2026-09-01 00:00',
                'category' => 'calculators',
                'title' => 'Ambulantná kalkulačka CKD',
                'description' => 'Komplexný nástroj pre nefrologickú ambulanciu: stagingové zaradenie CKD, prognostické modely a príčina CKD z číselníka MKCH-10 s vlastným textom.',
                'url' => 'calculator_ambulatory.php',
            ],
        ];
    }
}

if (!function_exists('siteChangelogEntriesBetween')) {
    /**
     * Vráti záznamy z okna (since, until] zoradené od najnovšieho.
     *
     * @return list<array{date: string, category: string, title: string, description: string, url: string}>
     */
    function siteChangelogEntriesBetween(string $since, string $until): array
    {
        $sinceTs = strtotime($since);
        $untilTs = strtotime($until);
        if ($sinceTs === false || $untilTs === false) {
            return [];
        }

        $selected = [];
        foreach (siteChangelogEntries() as $entry) {
            $entryTs = strtotime($entry['date']);
            if ($entryTs === false || $entryTs <= $sinceTs || $entryTs > $untilTs) {
                continue;
            }
            $selected[] = $entry;
        }

        usort($selected, static fn (array $a, array $b): int => strtotime($b['date']) <=> strtotime($a['date']));

        return $selected;
    }
}
