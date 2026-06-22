/*
 * nastroj_hyponatremia.js — Dátový strom: diagnostický algoritmus hyponatrémie.
 * Vyžaduje nastroj_engine.js (window.NefroDecisionTree), načítaný pred týmto súborom.
 */
(function () {
    'use strict';
    if (!window.NefroDecisionTree) { return; }

    var HYPONA_TREE = {
        start: 'tonicity',
        outcomeNote: 'Záver je orientačný a vychádza zo zadaných odpovedí. Vždy posúďte celkový '
            + 'klinický kontext, rýchlosť vzniku a riziko osmotického demyelinizačného syndrómu (ODS) '
            + 'pri korekcii; mnohé hyponatrémie majú zmiešanú etiológiu.',
        nodes: {
            tonicity: {
                id: 'tonicity', kind: 'q', step: 'Krok 1 — Potvrdiť pravú (hypotonickú) hyponatrémiu',
                title: 'Aká je sérová osmolalita?',
                body: ['Hyponatrémia = S-Na < 135 mmol/l. Najprv vylúčime „falošnú" a hypertonickú hyponatrémiu zmeraním sérovej osmolality:'],
                bullets: [
                    'normálna osmolalita (275–295) → pseudohyponatrémia (ťažká hyperlipidémia, paraproteinémia),',
                    'vysoká osmolalita (> 295) → hypertonická (hyperglykémia, manitol) — Na treba korigovať na glykémiu,',
                    'nízka osmolalita (< 275) → pravá hypotonická hyponatrémia.'
                ],
                prompt: 'Vyberte zmeranú sérovú osmolalitu:',
                options: [
                    { label: 'Nízka (< 275 mOsm/kg) — hypotonická', hint: 'Pravá hyponatrémia — pokračujte.', next: 'severity' },
                    { label: 'Normálna alebo vysoká (≥ 275 mOsm/kg)', hint: 'Pseudo- alebo hypertonická hyponatrémia.', next: 'nonhypotonic' }
                ]
            },

            severity: {
                id: 'severity', kind: 'q', step: 'Krok 2 — Závažnosť a rýchlosť vzniku',
                title: 'Má pacient ťažké symptómy hyponatrémie?',
                body: ['Pred etiologickou diagnostikou posúďte naliehavosť. Ťažké symptómy vyžadujú okamžitú liečbu bez ohľadu na príčinu:'],
                bullets: [
                    'ťažké: kŕče, kóma alebo kvalitatívna porucha vedomia, vracanie, kardiorespiračná nestabilita,',
                    'rýchlosť vzniku: akútna (< 48 h) vs chronická — chronická má vyššie riziko ODS pri rýchlej korekcii.'
                ],
                prompt: 'Sú prítomné ťažké (najmä neurologické) symptómy?',
                options: [
                    { label: 'Áno — ťažké symptómy', hint: 'Urgentný stav.', next: 'emergency' },
                    { label: 'Nie — mierne alebo asymptomatické', hint: 'Pokračujte etiologickou diagnostikou.', next: 'volume' }
                ]
            },

            volume: {
                id: 'volume', kind: 'q', step: 'Krok 3 — Posúdiť objemový stav',
                title: 'Aký je objemový (volémický) stav pacienta?',
                body: ['Pri hypotonickej hyponatrémii smeruje diagnostiku klinické posúdenie objemu (turgor, náplň krčných žíl, edémy, ortostáza, bilancia tekutín):'],
                prompt: 'Vyberte objemový stav:',
                options: [
                    { label: 'Hypovolémia (straty tekutín, ortostáza, znížený turgor)', next: 'hypovol_una' },
                    { label: 'Euvolémia (bez edémov a bez známok deplécie)', next: 'euvol' },
                    { label: 'Hypervolémia (edémy, ascites, kongescia)', next: 'hypervolemic' }
                ]
            },

            hypovol_una: {
                id: 'hypovol_una', kind: 'q', step: 'Krok 4 — Hypovolemická: močový sodík',
                title: 'Aký je močový sodík (U-Na)?',
                body: ['Močový sodík odlíši renálne a extrarenálne straty (platí pri neužívaní diuretík):'],
                prompt: 'Vyberte hodnotu U-Na:',
                options: [
                    { label: 'U-Na < 30 mmol/l — extrarenálne straty', hint: 'Obličky správne šetria sodík.', next: 'hypovol_extrarenal' },
                    { label: 'U-Na > 30 mmol/l — renálne straty', hint: 'Strata sodíka obličkami.', next: 'hypovol_renal' }
                ]
            },

            euvol: {
                id: 'euvol', kind: 'q', step: 'Krok 4 — Euvolemická: močová osmolalita',
                title: 'Aká je močová osmolalita (U-osm)?',
                body: ['Pri euvolemickej hyponatrémii najprv vylúčte hypotyreózu a adrenálnu insuficienciu (sekundárny hypokortizolizmus). Močová osmolalita odlíši SIADH od stavov s nízkym príjmom solútov/primárnou polydipsiou:'],
                prompt: 'Vyberte hodnotu U-osm:',
                options: [
                    { label: 'U-osm > 100 mOsm/kg — neadekvátne koncentrovaný moč', hint: 'Pretrvávajúce pôsobenie ADH.', next: 'siadh' },
                    { label: 'U-osm < 100 mOsm/kg — maximálne zriedený moč', hint: 'Potlačené ADH.', next: 'low_solute' }
                ]
            },

            // ── Výstupné uzly ──────────────────────────────────────────────
            nonhypotonic: {
                id: 'nonhypotonic', kind: 'r', severity: 'info',
                category: 'Nehypotonická hyponatrémia (pseudo- alebo hypertonická)',
                summary: 'Nejde o pravú hyponatrémiu — nevyžaduje korekciu vodnej bilancie, ale objasnenie príčiny.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Pseudohyponatrémia (normálna osmolalita): ťažká hyperlipidémia, hyperproteinémia/paraproteinémia — artefakt nepriamej fotometrie.',
                        'Hypertonická (vysoká osmolalita): hyperglykémia, manitol, kontrastné látky — voda sa presúva z buniek do plazmy.'
                    ] },
                    { heading: 'Postup', items: [
                        'Pri hyperglykémii korigujte nameraný Na na glykémiu (Katz/Hillier) — skutočný Na býva normálny.',
                        'Pri pseudohyponatrémii zopakujte meranie priamou iónovo-selektívnou elektródou.',
                        'Liečte vyvolávajúcu príčinu (glykémia, hyperlipidémia, paraproteín).'
                    ] }
                ],
                links: [
                    { href: 'calculator_na.php', label: 'Kalkulačka: korekcia Na na glykémiu (Katz/Hillier)' }
                ]
            },

            emergency: {
                id: 'emergency', kind: 'r', severity: 'urgent',
                category: 'Ťažko symptomatická hyponatrémia — urgentný stav',
                summary: 'Ťažké neurologické symptómy svedčia pre edém mozgu — liečte okamžite hypertonickým roztokom bez ohľadu na etiológiu, súbežne hľadajte príčinu.',
                sections: [
                    { heading: 'Okamžitá liečba', items: [
                        'Hypertonický (3 %) NaCl v bolusoch (napr. 100–150 ml i.v.), podľa potreby opakovať do ústupu ťažkých symptómov.',
                        'Cieľ: rýchle zvýšenie S-Na o 4–6 mmol/l (zvyčajne postačí na ústup symptómov a zníženie edému mozgu).',
                        'Časté kontroly S-Na (á 1–2 h v úvode), monitoring na JIS/monitorovanom lôžku.'
                    ] },
                    { heading: 'Limity korekcie (riziko ODS)', items: [
                        'Neprekročiť ~8–10 mmol/l za 24 h (pri vysokom riziku ODS cieľ ≤ 6–8 mmol/l/24 h).',
                        'Rizikoví: chronická hyponatrémia, alkoholizmus, malnutrícia, hypokaliémia, pokročilá choroba pečene.',
                        'Pri nadmernej korekcii zvážiť opätovné zníženie Na (desmopresín ± 5 % glukóza).'
                    ] },
                    { heading: 'Súbežne', items: [
                        'Po stabilizácii pokračujte etiologickou diagnostikou podľa objemového stavu.'
                    ] }
                ],
                links: [
                    { href: 'calculator_na.php', label: 'Kalkulačka: Adrogue-Madias (plánovanie korekcie Na)' }
                ]
            },

            hypovol_extrarenal: {
                id: 'hypovol_extrarenal', kind: 'r', severity: 'warn',
                category: 'Hypovolemická hyponatrémia — extrarenálne straty (U-Na < 30)',
                summary: 'Strata sodíka a vody mimo obličiek; obličky správne šetria sodík (nízky U-Na).',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Gastrointestinálne straty: vracanie, hnačka.',
                        'Tretí priestor: pankreatitída, popáleniny, ileus.',
                        'Nadmerné potenie, kožné straty.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Doplnenie objemu izotonickým kryštaloidom (0,9 % NaCl).',
                        'Pozor: po doplnení objemu sa „vypne" stimul pre ADH a hrozí rýchla autokorekcia S-Na → riziko ODS; monitorovať a v prípade potreby spomaliť (desmopresín).',
                        'Liečiť vyvolávajúcu príčinu.'
                    ] }
                ],
                links: [
                    { href: 'calculator_na.php', label: 'Kalkulačka porúch sodíka a vody' }
                ]
            },

            hypovol_renal: {
                id: 'hypovol_renal', kind: 'r', severity: 'warn',
                category: 'Hypovolemická hyponatrémia — renálne straty (U-Na > 30)',
                summary: 'Obličky strácajú sodík napriek hypovolémii — hľadajte liekovú, endokrinnú alebo renálnu príčinu.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Diuretiká (najmä tiazidy) — najčastejšia príčina.',
                        'Mineralokortikoidová insuficiencia (Addisonova choroba), soľ-strácajúca nefropatia.',
                        'Cerebrálny soľ-strácajúci syndróm (CSW) pri intrakraniálnej patológii.'
                    ] },
                    { heading: 'Vyšetrenia a manažment', items: [
                        'Vysadiť/prehodnotiť diuretiká; pri podozrení na Addisona ranný kortizol a ACTH-stimulačný test.',
                        'Doplnenie objemu izotonickým roztokom; pri adrenálnej insuficiencii substitúcia hydrokortizónom.',
                        'Odlíšiť CSW od SIADH (pri CSW je pacient hypovolemický) — určuje smer liečby.'
                    ] }
                ],
                links: [
                    { href: 'calculator_na.php', label: 'Kalkulačka porúch sodíka a vody' }
                ]
            },

            siadh: {
                id: 'siadh', kind: 'r', severity: 'warn',
                category: 'SIADH (euvolemická, U-osm > 100, U-Na > 30)',
                summary: 'Syndróm neprimeranej sekrécie ADH — diagnóza per exclusionem po vylúčení hypotyreózy a adrenálnej insuficiencie.',
                sections: [
                    { heading: 'Diagnostické kritériá (Bartter–Schwartz)', items: [
                        'Hypotonická hyponatrémia, U-osm > 100 mOsm/kg, U-Na > 30 mmol/l pri normálnom príjme soli a vody.',
                        'Klinická euvolémia; normálna funkcia obličiek, nadobličiek a štítnej žľazy; bez diuretík.'
                    ] },
                    { heading: 'Časté príčiny', items: [
                        'Malignity (najmä malobunkový karcinóm pľúc), pľúcne ochorenia, CNS poruchy.',
                        'Lieky: SSRI, karbamazepín, antipsychotiká, cyklofosfamid; bolesť, nauzea, pooperačný stav.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Reštrikcia príjmu tekutín (prvá línia).',
                        'Pri nedostatočnom efekte: zvýšený príjem solútov (soľ ± slučkové diuretikum), urea, prípadne vaptány.',
                        'Liečiť vyvolávajúcu príčinu; korigovať pomaly (riziko ODS).'
                    ] }
                ],
                links: [
                    { href: 'calculator_na.php', label: 'Kalkulačka porúch sodíka a vody' }
                ]
            },

            low_solute: {
                id: 'low_solute', kind: 'r', severity: 'warn',
                category: 'Nízky príjem solútov / primárna polydipsia (U-osm < 100)',
                summary: 'Maximálne zriedený moč — ADH je správne potlačené; problém je v nadmernom príjme vody alebo nízkom príjme solútov.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Primárna (psychogénna) polydipsia — nadmerný príjem vody.',
                        '„Beer potomania" a diéta „tea and toast" — nízky príjem solútov obmedzuje vylučovanie voľnej vody.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Pri primárnej polydipsii reštrikcia tekutín; pri nízkom príjme solútov opatrné doplnenie príjmu (soľ, bielkoviny).',
                        'VYSOKÉ riziko rýchlej autokorekcie a ODS: po obmedzení vody sa moč rýchlo zriedi a S-Na môže prudko stúpnuť — prísny monitoring, v prípade potreby spomaliť (desmopresín).'
                    ] }
                ],
                links: [
                    { href: 'calculator_na.php', label: 'Kalkulačka porúch sodíka a vody' }
                ]
            },

            hypervolemic: {
                id: 'hypervolemic', kind: 'r', severity: 'warn',
                category: 'Hypervolemická hyponatrémia (edematózne stavy)',
                summary: 'Nadbytok celkovej telesnej vody prevyšuje nadbytok sodíka — znížený efektívny cirkulujúci objem stimuluje ADH.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Srdcové zlyhávanie, cirhóza pečene, nefrotický syndróm (U-Na zvyčajne < 30).',
                        'Pokročilé chronické ochorenie obličiek (U-Na variabilný; pri diuretikách vyšší).'
                    ] },
                    { heading: 'Manažment', items: [
                        'Reštrikcia príjmu tekutín a sodíka.',
                        'Liečba základného ochorenia; slučkové diuretiká na podporu vylučovania voľnej vody.',
                        'Vaptány vo vybraných prípadoch; korigovať pomaly (riziko ODS).'
                    ] }
                ],
                links: [
                    { href: 'calculator_na.php', label: 'Kalkulačka porúch sodíka a vody' }
                ]
            }
        }
    };

    window.NefroDecisionTree.mount('hyponatremia-tool', HYPONA_TREE);
})();
