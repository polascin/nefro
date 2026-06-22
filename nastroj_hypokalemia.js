/*
 * nastroj_hypokalemia.js — Dátový strom: diagnostika a manažment hypokaliémie.
 * Vyžaduje nastroj_engine.js (window.NefroDecisionTree), načítaný pred týmto súborom.
 */
(function () {
    'use strict';
    if (!window.NefroDecisionTree) { return; }

    var HYPOK_TREE = {
        start: 'severity',
        outcomeNote: 'Záver je orientačný a vychádza zo zadaných odpovedí. Pri každej hypokaliémii '
            + 'vždy zmerajte a v prípade potreby korigujte magnézium — hypomagneziémia spôsobuje '
            + 'refraktérnu hypokaliémiu. Posúďte celkový klinický kontext, EKG a lieky.',
        nodes: {
            severity: {
                id: 'severity', kind: 'q', step: 'Krok 1 — Závažnosť a naliehavosť',
                title: 'Je hypokaliémia ťažká alebo symptomatická?',
                body: ['Hypokaliémia = S-K < 3,5 mmol/l. Najprv posúďte naliehavosť (závažnosť + EKG + komorbidity):'],
                bullets: [
                    'mierna 3,0–3,4 · stredná 2,5–2,9 · ťažká < 2,5 mmol/l,',
                    'symptómy: svalová slabosť až paralýza, arytmie, rabdomyolýza,',
                    'EKG: oploštené T, U vlny, depresie ST, predĺžené QU; ↑ riziko pri liečbe digoxínom.'
                ],
                prompt: 'Je K < 2,5 mmol/l, prítomné symptómy/EKG zmeny alebo liečba digoxínom?',
                options: [
                    { label: 'Áno — ťažká / symptomatická / EKG zmeny / digoxín', hint: 'Urgentná substitúcia.', next: 'urgent' },
                    { label: 'Nie — mierna, asymptomatická', hint: 'Pokračujte určením mechanizmu.', next: 'shift' }
                ]
            },

            shift: {
                id: 'shift', kind: 'q', step: 'Krok 2 — Transcelulárny presun?',
                title: 'Je prítomná zjavná príčina redistribúcie draslíka do buniek?',
                body: ['Pri transcelulárnom presune je celkový telesný draslík zvyčajne normálny (porucha je prechodná). Typické príčiny:'],
                bullets: [
                    'inzulín (najmä pri liečbe DKA), β2-agonisty (salbutamol), teofylín/kofeínová toxicita,',
                    'akútna alkalóza, refeeding syndróm,',
                    'hypokaliemická periodická paralýza, tyreotoxická periodická paralýza.'
                ],
                prompt: 'Dominuje zjavná príčina redistribúcie?',
                options: [
                    { label: 'Áno — redistribúcia', next: 'shift_out' },
                    { label: 'Nie / neistý — pravdepodobne strata draslíka', hint: 'Určte zdroj straty.', next: 'urine_k' }
                ]
            },

            urine_k: {
                id: 'urine_k', kind: 'q', step: 'Krok 3 — Močový draslík (zdroj straty)',
                title: 'Aký je močový draslík?',
                body: ['Močový draslík (bodové U-K, pomer U-K : U-Cr, prípadne TTKG) odlíši renálnu a extrarenálnu stratu:'],
                prompt: 'Vyberte hodnotu močového draslíka:',
                options: [
                    { label: 'Nízky (U-K < 15 mmol/l, U-K:Cr < 1,5 mmol/mmol)', hint: 'Obličky šetria draslík → extrarenálna strata/nízky príjem.', next: 'extrarenal' },
                    { label: 'Vysoký (U-K > 15–20 mmol/l, U-K:Cr > 1,5)', hint: 'Renálna strata draslíka.', next: 'acidbase' }
                ]
            },

            acidbase: {
                id: 'acidbase', kind: 'q', step: 'Krok 4 — Acidobázický stav (renálna strata)',
                title: 'Aký je acidobázický stav?',
                body: ['Pri renálnej strate draslíka smeruje diagnostiku acidobázický stav:'],
                prompt: 'Vyberte acidobázický stav:',
                options: [
                    { label: 'Metabolická acidóza', hint: 'RTA, DKA, diverzie moču.', next: 'rta' },
                    { label: 'Metabolická alkalóza', hint: 'Posúďte krvný tlak.', next: 'bp' }
                ]
            },

            bp: {
                id: 'bp', kind: 'q', step: 'Krok 5 — Krvný tlak (metabolická alkalóza)',
                title: 'Aký je krvný tlak?',
                body: ['Pri metabolickej alkalóze odlíši krvný tlak mineralokortikoidový nadbytok od ostatných príčin:'],
                prompt: 'Vyberte krvný tlak:',
                options: [
                    { label: 'Hypertenzia', hint: 'Mineralokortikoidový nadbytok.', next: 'mineralocorticoid' },
                    { label: 'Normotenzia / hypotenzia', hint: 'Posúďte močový chlorid.', next: 'urine_cl' }
                ]
            },

            urine_cl: {
                id: 'urine_cl', kind: 'q', step: 'Krok 6 — Močový chlorid (normotenzia)',
                title: 'Aký je močový chlorid?',
                body: ['Pri metabolickej alkalóze s normotenziou rozlišuje močový chlorid chloridom responzívne a rezistentné príčiny:'],
                prompt: 'Vyberte hodnotu močového chloridu:',
                options: [
                    { label: 'Nízky (U-Cl < 20–25 mmol/l) — chloridom responzívna', next: 'cl_responsive' },
                    { label: 'Vysoký (U-Cl > 40 mmol/l) — chloridom rezistentná', next: 'cl_resistant' }
                ]
            },

            // ── Výstupné uzly ──────────────────────────────────────────────
            urgent: {
                id: 'urgent', kind: 'r', severity: 'urgent',
                category: 'Ťažká / symptomatická hypokaliémia — urgentný stav',
                summary: 'Riziko život ohrozujúcich arytmií — substituujte parenterálne pod monitoringom a súbežne hľadajte príčinu.',
                sections: [
                    { heading: 'Okamžitá liečba', items: [
                        'Intravenózna substitúcia KCl pod kontinuálnym EKG monitoringom; periférne zvyčajne max ~10 mmol/h, vyššie rýchlosti len centrálne na monitorovanom lôžku.',
                        'Vyhnúť sa úvodným roztokom s glukózou (stimuluje inzulín → ďalší presun K do buniek).',
                        'Zmerať a korigovať magnézium — bez korekcie Mg je hypokaliémia často refraktérna.',
                        'Časté kontroly kalémie; pozor na rebound hyperkaliémiu, najmä ak ide o redistribúciu.'
                    ] },
                    { heading: 'Pozor', items: [
                        'Pri liečbe digoxínom je nebezpečná aj mierna hypokaliémia (potencuje toxicitu).',
                        'Po stabilizácii pokračujte určením mechanizmu (presun vs renálna/extrarenálna strata).'
                    ] }
                ],
                links: [
                    { href: 'calculator_acidbase.php', label: 'Aniónová medzera a Δ/Δ (acidobáza)' }
                ]
            },

            shift_out: {
                id: 'shift_out', kind: 'r', severity: 'info',
                category: 'Transcelulárny presun (redistribúcia)',
                summary: 'Draslík sa presunul do buniek; celkový telesný draslík býva normálny a porucha je prechodná.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Inzulín (najmä počas liečby diabetickej ketoacidózy), β2-agonisty (salbutamol), teofylín/kofeínová toxicita.',
                        'Akútna alkalóza, refeeding syndróm.',
                        'Hypokaliemická a tyreotoxická periodická paralýza.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Liečiť vyvolávajúcu príčinu (napr. β-bloker pri tyreotoxickej paralýze, korekcia tyreopatie).',
                        'Substituovať opatrne — pri redistribúcii hrozí po doplnení rebound hyperkaliémia.',
                        'Monitorovať kalémiu; zmerať magnézium.'
                    ] }
                ]
            },

            extrarenal: {
                id: 'extrarenal', kind: 'r', severity: 'warn',
                category: 'Extrarenálna strata / nízky príjem (nízky U-K)',
                summary: 'Obličky správne šetria draslík — strata je mimo obličiek alebo je nedostatočný príjem.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Gastrointestinálne straty: hnačka, zneužívanie laxatív, VIPóm, ileostómia.',
                        'Nízky príjem draslíka (málokedy izolovane), profúzne potenie.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Substitúcia draslíka (perorálne pri miernej forme), liečba gastrointestinálnej príčiny.',
                        'Zmerať a korigovať magnézium (časté pri hnačke).',
                        'Pozn.: vracanie spôsobuje stratu K skôr renálne (cez alkalózu a sekundárny hyperaldosteronizmus) — vtedy býva U-K vyšší.'
                    ] }
                ]
            },

            rta: {
                id: 'rta', kind: 'r', severity: 'warn',
                category: 'Renálna strata + metabolická acidóza',
                summary: 'Renálna strata draslíka so súčasnou metabolickou acidózou — typicky renálna tubulárna acidóza alebo ketoacidóza.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Renálna tubulárna acidóza: distálna (typ 1) a proximálna (typ 2).',
                        'Diabetická ketoacidóza (napriek deplécii K býva vstupná kalémia normálna/vysoká, počas liečby prudko klesá).',
                        'Ureterálne diverzie, toluénová toxicita.'
                    ] },
                    { heading: 'Vyšetrenia a manažment', items: [
                        'pH moču, anión-gap (sérum aj moč), glykémia a ketolátky.',
                        'Substitúcia draslíka pred/popri alkalizačnej liečbe pri RTA.',
                        'Liečiť základnú príčinu; zmerať magnézium.'
                    ] }
                ],
                links: [
                    { href: 'calculator_acidbase.php', label: 'Aniónová medzera a Δ/Δ (acidobáza)' }
                ]
            },

            mineralocorticoid: {
                id: 'mineralocorticoid', kind: 'r', severity: 'warn',
                category: 'Mineralokortikoidový nadbytok (alkalóza + hypertenzia)',
                summary: 'Renálna strata draslíka, metabolická alkalóza a hypertenzia svedčia pre nadbytok mineralokortikoidov.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Primárny hyperaldosteronizmus (Connov syndróm) — najčastejší, často podceňovaný.',
                        'Renovaskulárna hypertenzia, Cushingov syndróm, kongenitálna adrenálna hyperplázia.',
                        'Liddleov syndróm; zdanlivý mineralokortikoidový nadbytok (nadmerný príjem sladkého drievka).'
                    ] },
                    { heading: 'Vyšetrenia a manažment', items: [
                        'Pomer aldosterón : renín (ARR) ako skríning hyperaldosteronizmu; zobrazenie nadobličiek.',
                        'Pri Cushingovi kortizolový profil; vysadiť drievko/lieky pri zdanlivom nadbytku.',
                        'Liečba: MRA (spironolaktón/eplerenón) pri hyperaldosteronizme; špecificky pri ostatných jednotkách.'
                    ] }
                ]
            },

            cl_responsive: {
                id: 'cl_responsive', kind: 'r', severity: 'warn',
                category: 'Chloridom responzívna alkalóza (normotenzia, nízky U-Cl)',
                summary: 'Metabolická alkalóza s normotenziou a nízkym močovým chloridom — reaguje na doplnenie objemu a chloridu.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Vracanie alebo nazogastrická drenáž.',
                        'Predošlé (už vysadené) diuretiká.',
                        'Posthyperkapnický stav.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Doplniť objem fyziologickým roztokom (0,9 % NaCl) a substituovať draslík.',
                        'Riešiť vyvolávajúcu príčinu (zastaviť straty); zmerať magnézium.'
                    ] }
                ]
            },

            cl_resistant: {
                id: 'cl_resistant', kind: 'r', severity: 'warn',
                category: 'Chloridom rezistentná alkalóza (normotenzia, vysoký U-Cl)',
                summary: 'Metabolická alkalóza s normotenziou a vysokým močovým chloridom — typicky diuretiká alebo tubulopatie.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Aktuálne užívané diuretiká (slučkové, tiazidy) — najčastejšie.',
                        'Bartterov syndróm (pripomína slučkové diuretiká) a Gitelmanov syndróm (pripomína tiazidy).',
                        'Ťažká deplécia magnézia.'
                    ] },
                    { heading: 'Vyšetrenia a manažment', items: [
                        'Lieková anamnéza (vrátane skrytého užívania), močové elektrolyty, magnézium.',
                        'Pri tubulopatiách substitúcia K a Mg, prípadne K-šetriace diuretiká (amilorid, spironolaktón).',
                        'Vysadiť/upraviť vyvolávajúce diuretiká, ak je to možné.'
                    ] }
                ]
            }
        }
    };

    window.NefroDecisionTree.mount('hypokalemia-tool', HYPOK_TREE);
})();
