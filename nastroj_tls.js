/*
 * nastroj_tls.js — Dátový strom: syndróm rozpadu nádoru (TLS) — riziko, profylaxia, manažment.
 * Vyžaduje nastroj_engine.js (window.NefroDecisionTree), načítaný pred týmto súborom.
 */
(function () {
    'use strict';
    if (!window.NefroDecisionTree) { return; }

    var TLS_TREE = {
        start: 'mode',
        outcomeNote: 'Záver je orientačný a vychádza zo zadaných odpovedí. Stratifikácia rizika a profylaxia '
            + 'sa riadia typom a náložou nádoru, funkciou obličiek a klinickým kontextom (Cairo–Bishop, '
            + 'Howard NEJM 2011, Coiffier JCO 2008). Vždy posúďte individuálne riziko a aktuálne odporúčania.',
        nodes: {
            mode: {
                id: 'mode', kind: 'q', step: 'Krok 1 — Čo potrebujete?',
                title: 'Posúdiť riziko pred liečbou, alebo manažovať už vzniknutý TLS?',
                body: ['Syndróm rozpadu nádoru (TLS) vzniká pri masívnom rozpade nádorových buniek '
                    + '(spontánne alebo po začatí liečby) — uvoľní sa draslík, fosfát a nukleové kyseliny '
                    + '(→ kyselina močová). Hrozí hyperkaliémia, hyperfosfatémia, hypokalciémia a akútne '
                    + 'poškodenie obličiek (urátová a kalcium-fosfátová nefropatia).'],
                prompt: 'Vyberte situáciu:',
                options: [
                    { label: 'Posúdiť riziko a zvoliť profylaxiu (pred/na začiatku liečby)', hint: 'Stratifikácia podľa nádoru a pacienta.', next: 'risk' },
                    { label: 'Pacient už má laboratórne alebo klinické známky TLS', hint: 'Etablovaný TLS — manažment a indikácie RRT.', next: 'established' }
                ]
            },

            risk: {
                id: 'risk', kind: 'q', step: 'Krok 2 — Typ a nálož nádoru',
                title: 'Aký je typ a nálož nádoru (proliferačná aktivita)?',
                body: ['Najsilnejším prediktorom je proliferačná aktivita a objem nádoru, citlivosť na liečbu '
                    + 'a vstupná hladina kyseliny močovej/LDH.'],
                bullets: [
                    'Vysoké riziko: Burkittov lymfóm, lymfoblastový lymfóm/ALL, agresívne NHL s vysokým LDH, AML s vysokým počtom leukocytov, venetoklax pri CLL s vysokou náložou.',
                    'Stredné riziko: väčšina ostatných agresívnych NHL, AML so strednou náložou, CLL pri cieľenej liečbe.',
                    'Nízke riziko: väčšina solídnych nádorov a indolentných hematologických ochorení.'
                ],
                prompt: 'Vyberte kategóriu:',
                options: [
                    { label: 'Vysoká nálož / vysoko proliferatívne (Burkitt, ALL, vysoký WBC, bulky)', hint: 'Vysoké riziko bez ohľadu na ďalšie faktory.', next: 'high_risk' },
                    { label: 'Stredná', hint: 'Riziko upraví funkcia obličiek a vstupné laboratórne hodnoty.', next: 'rf_intermediate' },
                    { label: 'Nízka (väčšina solídnych nádorov, indolentné)', hint: 'Riziko upravia faktory pacienta.', next: 'rf_low' }
                ]
            },

            rf_intermediate: {
                id: 'rf_intermediate', kind: 'q', step: 'Krok 3 — Rizikové faktory pacienta',
                title: 'Sú prítomné rizikové faktory pacienta?',
                body: ['Pri stredne rizikovom nádore môžu faktory pacienta posunúť riziko nahor.'],
                bullets: ['Predchádzajúca CKD/AKI, vstupná hyperurikémia alebo hyperfosfatémia, dehydratácia/oligúria, výrazne zvýšené LDH, objemný nádor s postihnutím obličiek.'],
                prompt: 'Sú prítomné rizikové faktory?',
                options: [
                    { label: 'Áno — aspoň jeden rizikový faktor', hint: 'Manažovať ako vysoké riziko.', next: 'high_risk' },
                    { label: 'Nie — bez rizikových faktorov', hint: 'Stredné riziko.', next: 'intermediate_risk' }
                ]
            },

            rf_low: {
                id: 'rf_low', kind: 'q', step: 'Krok 3 — Rizikové faktory pacienta',
                title: 'Sú prítomné rizikové faktory pacienta?',
                body: ['Aj pri nízkorizikovom nádore môžu faktory pacienta zvýšiť riziko.'],
                bullets: ['Predchádzajúca CKD/AKI, vstupná hyperurikémia, dehydratácia/oligúria, veľká nádorová masa.'],
                prompt: 'Sú prítomné rizikové faktory?',
                options: [
                    { label: 'Áno — aspoň jeden rizikový faktor', hint: 'Manažovať ako stredné riziko.', next: 'intermediate_risk' },
                    { label: 'Nie — bez rizikových faktorov', hint: 'Nízke riziko.', next: 'low_risk' }
                ]
            },

            // ── Výstupné uzly ──────────────────────────────────────────────
            high_risk: {
                id: 'high_risk', kind: 'r', severity: 'urgent',
                category: 'Vysoké riziko TLS — profylaxia rasburikázou',
                summary: 'Agresívna prevencia: intenzívna hydratácia, rasburikáza a častý laboratórny aj kardiálny '
                    + 'monitoring. Cieľom je predísť urátovej a kalcium-fosfátovej nefropatii.',
                sections: [
                    { heading: 'Profylaxia', items: [
                        'Intenzívna i.v. hydratácia (cieľ vysoká diuréza); do roztokov nepridávať draslík ani kalcium (pokiaľ nie je symptomatická hypokalciémia).',
                        'Rasburikáza (rekombinantná urátoxidáza) — rýchlo rozkladá kyselinu močovú; NEkombinovať s alkalizáciou moču a NEpodávať pri deficite G6PD (skríning u rizikových — riziko hemolýzy a methemoglobinémie).',
                        'Vzorku na kyselinu močovú po odbere uchovať na ľade (rasburikáza degraduje urát aj ex vivo → falošne nízke hodnoty).'
                    ] },
                    { heading: 'Monitorovanie', items: [
                        'Elektrolyty, fosfát, kalcium, kyselina močová a kreatinín každých 6–8 h prvých 24–48 h.',
                        'Kardiálny monitoring (riziko arytmií pri hyperkaliémii); bilancia tekutín a diuréza.'
                    ] },
                    { heading: 'Pri vzniku TLS', items: [
                        'Manažovať hyperkaliémiu, hyperfosfatémiu a hypokalciémiu; pri refraktérnych poruchách alebo oligoanúrii zvážiť dialýzu (pozri vetvu „etablovaný TLS“).'
                    ] }
                ],
                links: [
                    { href: 'calculator_tls.php', label: 'TLS — Cairo–Bishop klasifikácia' },
                    { href: 'liek.php?slug=rasburikaza', label: 'Rasburikáza — detail lieku' }
                ]
            },

            intermediate_risk: {
                id: 'intermediate_risk', kind: 'r', severity: 'warn',
                category: 'Stredné riziko TLS — alopurinol a hydratácia',
                summary: 'Hydratácia a alopurinol s pripravenosťou eskalovať na rasburikázu, ak kyselina močová '
                    + 'stúpa alebo sa rozvinie TLS.',
                sections: [
                    { heading: 'Profylaxia', items: [
                        'Adekvátna i.v. hydratácia s cieľom dobrej diurézy.',
                        'Alopurinol (znižuje tvorbu novej kyseliny močovej; už vytvorený urát nerozkladá) — dávku upraviť podľa funkcie obličiek.',
                        'Pri vzostupe kyseliny močovej, oligúrii alebo vzniku TLS prejsť na rasburikázu.'
                    ] },
                    { heading: 'Monitorovanie', items: [
                        'Elektrolyty, fosfát, kalcium, kyselina močová a kreatinín každých 8–12 h prvých 24–48 h.'
                    ] }
                ],
                links: [
                    { href: 'calculator_tls.php', label: 'TLS — Cairo–Bishop klasifikácia' },
                    { href: 'liek.php?slug=alopurinol', label: 'Alopurinol — detail lieku' }
                ]
            },

            low_risk: {
                id: 'low_risk', kind: 'r', severity: 'info',
                category: 'Nízke riziko TLS — hydratácia a sledovanie',
                summary: 'Dostatočná hydratácia a sledovanie laboratórnych hodnôt; rutinná farmakoprofylaxia '
                    + 'zvyčajne nie je nutná, no sledujte eskaláciu rizika.',
                sections: [
                    { heading: 'Postup', items: [
                        'Zabezpečiť dostatočný príjem tekutín / hydratáciu.',
                        'Sledovať elektrolyty, fosfát, kalcium, kyselinu močovú a kreatinín; alopurinol zvážiť individuálne.',
                        'Pri náraste nádorovej nálože, oligúrii alebo vzostupe kyseliny močovej prehodnotiť na vyššiu rizikovú kategóriu.'
                    ] }
                ],
                links: [
                    { href: 'calculator_tls.php', label: 'TLS — Cairo–Bishop klasifikácia' }
                ]
            },

            established: {
                id: 'established', kind: 'r', severity: 'urgent',
                category: 'Etablovaný TLS — manažment a indikácie dialýzy',
                summary: 'Laboratórny TLS (Cairo–Bishop: ≥ 2 z hyperurikémie, hyperkaliémie, hyperfosfatémie, '
                    + 'hypokalciémie) ± klinický TLS (AKI, arytmia, kŕče). Súčasne korigovať metabolické poruchy '
                    + 'a chrániť obličky.',
                sections: [
                    { heading: 'Potvrdenie a klasifikácia', items: [
                        'Overte kritériá Cairo–Bishop (kalkulačka nižšie) a odlíšte laboratórny vs klinický TLS.',
                        'Vyšetrite elektrolyty, fosfát, kalcium (ionizované), kyselinu močovú, kreatinín, EKG a diurézu.'
                    ] },
                    { heading: 'Metabolický manažment', items: [
                        'Hyperkaliémia: stabilizácia myokardu (kalcium pri EKG zmenách), presun (inzulín/glukóza, β2-agonista), odstránenie (diuréza, výmenné živice, dialýza).',
                        'Hyperfosfatémia: viazače fosfátov, obmedziť prísun; hypokalciémiu korigovať len pri symptómoch (riziko kalcium-fosfátovej precipitácie).',
                        'Hyperurikémia: rasburikáza (ak nie je kontraindikovaná), pokračovať v hydratácii.'
                    ] },
                    { heading: 'Renálna náhrada (RRT)', items: [
                        'Zvážiť pri ťažkej alebo refraktérnej hyperkaliémii, hyperfosfatémii, objemovom preťažení, ťažkej oligo-/anúrii alebo symptomatickej hypokalciémii.',
                        'Včasná konzultácia s nefrológiou; TLS môže vyžadovať intenzívnu (aj kontinuálnu) dialýzu.'
                    ] }
                ],
                links: [
                    { href: 'calculator_tls.php', label: 'TLS — Cairo–Bishop klasifikácia' },
                    { href: 'liek.php?slug=rasburikaza', label: 'Rasburikáza — detail lieku' }
                ]
            }
        }
    };

    window.NefroDecisionTree.mount('tls-tool', TLS_TREE);
})();
