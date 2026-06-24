/*
 * nastroj_gn.js — Dátový strom: diferenciálna diagnostika glomerulonefritíd (GN).
 * Vyžaduje nastroj_engine.js (window.NefroDecisionTree), načítaný pred týmto súborom.
 */
(function () {
    'use strict';
    if (!window.NefroDecisionTree) { return; }

    var GN_TREE = {
        start: 'pattern',
        outcomeNote: 'Záver je orientačný a vychádza zo zadaných odpovedí. Definitívna diagnóza '
            + 'glomerulonefritídy stojí na renálnej biopsii so svetelnou mikroskopiou, '
            + 'imunofluorescenciou a elektrónovou mikroskopiou; vždy posúďte celkový klinický '
            + 'a sérologický kontext.',
        nodes: {
            pattern: {
                id: 'pattern', kind: 'q', step: 'Krok 1 — Klinický obraz',
                title: 'Aký je dominantný glomerulárny obraz?',
                body: ['Glomerulárne ochorenia tvoria spektrum od nefritického po nefrotický syndróm. '
                    + 'Prvým krokom je zaradiť dominujúci obraz podľa močového sedimentu a veľkosti proteinúrie.'],
                bullets: [
                    'Nefritický: hematúria s dysmorfnými erytrocytmi a erytrocytovými valcami, hypertenzia, pokles GFR, proteinúria zvyčajne < 3,5 g/deň.',
                    'Nefrotický: proteinúria ≥ 3,5 g/deň, hypoalbuminémia, edémy, hyperlipidémia, neaktívny („bland“) sediment.'
                ],
                prompt: 'Vyberte dominujúci obraz:',
                options: [
                    { label: 'Nefritický obraz', hint: 'Hematúria, erytrocytové valce, hypertenzia, pokles GFR.', next: 'nephritic_speed' },
                    { label: 'Nefrotický obraz', hint: 'Proteinúria ≥ 3,5 g, hypoalbuminémia, edémy.', next: 'nephrotic_dm' },
                    { label: 'Zmiešaný / nejasný', hint: 'Nefritické aj nefrotické črty (difúzna proliferatívna lupusová nefritída, MPGN).', next: 'mixed' }
                ]
            },

            nephritic_speed: {
                id: 'nephritic_speed', kind: 'q', step: 'Krok 2 — Tempo progresie',
                title: 'Ako rýchlo sa zhoršuje funkcia obličiek?',
                body: ['Rýchlo progredujúca glomerulonefritída (RPGN) je urgentná — histologicky zodpovedá '
                    + 'polmesiačikom (crescents). Oneskorenie liečby znamená nezvratnú stratu nefrónov.'],
                prompt: 'Tempo vzostupu kreatinínu:',
                options: [
                    { label: 'Rýchle — dni až týždne (RPGN)', hint: 'Pokles GFR o desiatky % počas dní/týždňov, často oligúria.', next: 'rpgn' },
                    { label: 'Stabilné alebo pozvoľné', hint: 'Pokračujte podľa komplementu.', next: 'complement' }
                ]
            },

            rpgn: {
                id: 'rpgn', kind: 'q', step: 'RPGN — imunopatologický vzor',
                title: 'RPGN: ktorý imunologický vzor dominuje?',
                body: ['Polmesiačiková (crescentic) GN má tri základné imunopatologické typy. Urgentne odoberte '
                    + 'kompletnú imunológiu a zvážte bezodkladnú biopsiu — liečbu nemožno odkladať.'],
                bullets: ['Panel: ANCA (MPO/PR3), anti-GBM, ANA/anti-dsDNA, C3/C4, kryoglobulíny, sérológie hepatitíd B/C a HIV, ASLO.'],
                prompt: 'Vyberte vzor:',
                options: [
                    { label: 'Pauci-imunitný — ANCA pozitívny (MPO/PR3)', hint: 'Málo/žiadne imunodepozity; vaskulitída malých ciev.', next: 'rpgn_anca' },
                    { label: 'Anti-GBM (lineárny IF pozdĺž GBM)', hint: 'Často s pľúcnym krvácaním (Goodpastureov syndróm).', next: 'rpgn_antigbm' },
                    { label: 'Imunokomplexový (granulárny IF, často nízky komplement)', hint: 'Lupus, IgA, postinfekčný, kryoglobulinemický.', next: 'rpgn_ic' }
                ]
            },

            complement: {
                id: 'complement', kind: 'q', step: 'Krok 3 — Komplement',
                title: 'Aké sú hladiny komplementu (C3, C4)?',
                body: ['Sérový komplement je klasický rázcestník nefritických glomerulonefritíd — nízke hladiny '
                    + 'výrazne zužujú diferenciálnu diagnostiku.'],
                prompt: 'Hladiny komplementu:',
                options: [
                    { label: 'Nízky C3 a/alebo C4', hint: 'Konzumpcia komplementu.', next: 'low_complement' },
                    { label: 'Normálny komplement', hint: 'IgA, vaskulitídy, hereditárne príčiny.', next: 'normal_complement' }
                ]
            },

            low_complement: {
                id: 'low_complement', kind: 'q', step: 'Nízky komplement — diferenciál',
                title: 'Ktorý klinický kontext sedí najlepšie?',
                body: ['Nefritída s nízkym komplementom — rozlíšte podľa anamnézy, sérológií a vzoru C3 vs C4.'],
                prompt: 'Vyberte kontext:',
                options: [
                    { label: 'Nedávna infekcia (streptokok, koža/dýchacie cesty); izolovane nízke C3', hint: 'C3 sa normalizuje za 6–8 týždňov.', next: 'postinfectious' },
                    { label: 'Multisystémové, ANA / anti-dsDNA pozitívne, nízke C3 aj C4', hint: 'Aktivácia klasickej dráhy.', next: 'lupus' },
                    { label: 'Perzistentne nízke C3, membranoproliferatívny vzor', hint: 'C3 glomerulopatia / MPGN.', next: 'mpgn_c3g' },
                    { label: 'Hepatitída C alebo pozitívne kryoglobulíny, nízke C4', hint: 'Kryoglobulinemická GN.', next: 'cryo' }
                ]
            },

            normal_complement: {
                id: 'normal_complement', kind: 'q', step: 'Normálny komplement — diferenciál',
                title: 'Ktorý obraz dominuje pri normálnom komplemente?',
                body: ['Pri nefritíde s normálnym komplementom dominuje IgA nefropatia; zvážte aj vaskulitídu '
                    + 'malých ciev a hereditárne príčiny izolovanej hematúrie.'],
                prompt: 'Vyberte:',
                options: [
                    { label: 'Synfaryngitická hematúria u mladého dospelého', hint: 'Hematúria súčasne s infekciou horných dýchacích ciest.', next: 'iga' },
                    { label: 'Hmatateľná purpura, bolesti brucha, artralgie', hint: 'IgA vaskulitída (Henoch–Schönlein).', next: 'iga' },
                    { label: 'ANCA pozitívny alebo systémové príznaky vaskulitídy', hint: 'Aj indolentná pauci-imunitná GN.', next: 'rpgn_anca' },
                    { label: 'Izolovaná hematúria, rodinný výskyt alebo porucha sluchu', hint: 'Alportov syndróm, choroba tenkých bazálnych membrán.', next: 'hereditary' }
                ]
            },

            nephrotic_dm: {
                id: 'nephrotic_dm', kind: 'q', step: 'Krok 2 — Kontext nefrotického syndrómu',
                title: 'Sedí obraz diabetickej nefropatie?',
                body: ['Diabetická nefropatia je najčastejšou príčinou nefrotickej proteinúrie u dospelých. '
                    + 'Typicky dlhšie trvajúci diabetes, diabetická retinopatia a postupný vzostup albuminúrie '
                    + 'bez aktívneho sedimentu.'],
                prompt: 'Vyberte:',
                options: [
                    { label: 'Áno — dlhotrvajúci diabetes + retinopatia, bland sediment', hint: 'Typický pomalý priebeh.', next: 'diabetic' },
                    { label: 'Nie / atypický (náhly začiatok, hematúria, bez retinopatie, rýchly pokles GFR)', hint: 'Zvážte primárnu glomerulopatiu — biopsia.', next: 'nephrotic_age' }
                ]
            },

            nephrotic_age: {
                id: 'nephrotic_age', kind: 'q', step: 'Nefrotický — primárne glomerulopatie',
                title: 'Aký je vek a kontext pacienta?',
                body: ['Pri primárnom nefrotickom syndróme pomáha vek a sekundárny kontext. Vždy aktívne '
                    + 'hľadajte sekundárne príčiny (malignita, lieky, infekcie, autoimunita).'],
                prompt: 'Vyberte:',
                options: [
                    { label: 'Dieťa (1–10 r), náhly nefrotický syndróm', hint: 'Najpravdepodobnejšie choroba minimálnych zmien.', next: 'mcd' },
                    { label: 'Dospelý — pozitívny anti-PLA2R alebo membranózny vzor', hint: 'Membranózna nefropatia.', next: 'membranous' },
                    { label: 'Dospelý — fokálna segmentálna skleróza / rizikové faktory FSGS', hint: 'Primárna alebo sekundárna FSGS.', next: 'fsgs' },
                    { label: 'Známky systémového/sekundárneho ochorenia (amyloid, malignita, lieky)', hint: 'Sekundárny nefrotický syndróm.', next: 'secondary_nephrotic' }
                ]
            },

            // ── Výstupné uzly ──────────────────────────────────────────────
            mixed: {
                id: 'mixed', kind: 'r', severity: 'warn',
                category: 'Zmiešaný nefriticko-nefrotický obraz',
                summary: 'Prekrývajúce sa črty (difúzna proliferatívna lupusová nefritída, MPGN, kryoglobulinemická GN) — '
                    + 'postupujte ako pri aktívnej nefritíde: urgentná imunológia a biopsia.',
                sections: [
                    { heading: 'Vyšetrenia', items: [
                        'Kompletná imunológia: ANA, anti-dsDNA, ANCA, anti-GBM, C3/C4, kryoglobulíny, sérológie hepatitíd a HIV.',
                        'Kvantifikácia proteinúrie (UPCR/UACR), albumín, lipidy; posúdenie aktivity sedimentu.',
                        'Renálna biopsia s imunofluorescenciou a elektrónovou mikroskopiou.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Liečba podľa histológie a etiológie; pri aktívnej nefritíde nečakajte zbytočne.',
                        'Antiproteinurická a antihypertenzná liečba (RAAS blokáda), manažment edémov a kardiovaskulárneho rizika.'
                    ] }
                ],
                links: [
                    { href: 'calculator_uacr.php', label: 'UACR a KDIGO klasifikácia' },
                    { href: 'calculator_kfre.php', label: 'KFRE — riziko zlyhania obličiek' }
                ]
            },

            rpgn_anca: {
                id: 'rpgn_anca', kind: 'r', severity: 'urgent',
                category: 'Pauci-imunitná RPGN — ANCA-asociovaná vaskulitída',
                summary: 'Vaskulitída malých ciev (granulomatóza s polyangiitídou, mikroskopická polyangiitída, EGPA) — '
                    + 'urgentná indukčná imunosupresia, čas rozhoduje o renálnej prognóze.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Systémové príznaky: horúčka, úbytok hmotnosti, artralgie; pľúca (hemoptýza), ORL, koža, neuropatia.',
                        'ANCA: anti-MPO (p-ANCA) alebo anti-PR3 (c-ANCA); normálny komplement; aktívny nefritický sediment.'
                    ] },
                    { heading: 'Vyšetrenia', items: [
                        'Bezodkladná renálna biopsia (polmesiačiky, pauci-imunitný vzor v IF).',
                        'RTG/CT hrudníka, posúdenie alveolárneho krvácania; vylúčiť infekciu pred imunosupresiou.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Indukcia: glukokortikoidy + rituximab alebo cyklofosfamid; pri ťažkom priebehu zvážiť plazmaferézu (PEXIVAS — selektívne).',
                        'Avacopan ako súčasť steroid-šetriaceho režimu; profylaxia infekcií; následná udržiavacia liečba.'
                    ] }
                ],
                links: [
                    { href: 'calculator_uacr.php', label: 'UACR a KDIGO klasifikácia' }
                ]
            },

            rpgn_antigbm: {
                id: 'rpgn_antigbm', kind: 'r', severity: 'urgent',
                category: 'Anti-GBM choroba (Goodpastureov syndróm)',
                summary: 'Protilátky proti bazálnej membráne glomerulov — najakútnejšia RPGN. Pri pľúcno-renálnom syndróme '
                    + 'okamžitá liečba; renálne prežitie závisí od rýchlosti začatia.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Anti-GBM protilátky v sére; lineárny IF pozdĺž GBM v biopsii.',
                        'Časté difúzne alveolárne krvácanie (hemoptýza, anémia); ~⅓ je dvojito pozitívna na ANCA.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Urgentná trojkombinácia: plazmaferéza + glukokortikoidy + cyklofosfamid.',
                        'Liečbu začať pri klinickom podozrení (nečakať na všetky výsledky); pri oligoanúrii a 100 % polmesiačikoch je renálne zotavenie nepravdepodobné, no pľúca treba liečiť.'
                    ] }
                ]
            },

            rpgn_ic: {
                id: 'rpgn_ic', kind: 'r', severity: 'urgent',
                category: 'Imunokomplexová RPGN',
                summary: 'Polmesiačiková GN na podklade ukladania imunokomplexov (lupusová nefritída, IgA nefropatia/'
                    + 'vaskulitída, postinfekčná, kryoglobulinemická) — granulárny IF, často nízky komplement.',
                sections: [
                    { heading: 'Vyšetrenia', items: [
                        'Imunológia na určenie podkladu: ANA/anti-dsDNA, C3/C4, kryoglobulíny, sérológie hepatitíd, ASLO, IgA.',
                        'Renálna biopsia s imunofluorescenciou (vzor depozitov rozlíši jednotku).'
                    ] },
                    { heading: 'Manažment', items: [
                        'Liečba základného ochorenia (napr. imunosupresia pri lupusovej nefritíde) plus podporné renoprotektívne opatrenia.',
                        'Pri rýchlej progresii nečakajte — konzultujte nefrológiu a začnite cielenú liečbu.'
                    ] }
                ]
            },

            postinfectious: {
                id: 'postinfectious', kind: 'r', severity: 'warn',
                category: 'Postinfekčná / infekčná glomerulonefritída',
                summary: 'Akútna GN po (alebo počas) infekcie — klasicky poststreptokoková u detí; u dospelých a diabetikov '
                    + 'čoraz častejšie stafylokoková a GN spojená s aktívnou infekciou.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Latencia 1–3 týždne po faryngitíde/impetigu (poststreptokoková); izolovane nízke C3 s normálnym C4.',
                        'ASLO/anti-DNáza B, kultivácie; C3 sa normalizuje do 6–8 týždňov (ak nie, prehodnotiť na MPGN/C3G).'
                    ] },
                    { heading: 'Manažment', items: [
                        'Liečba aktívnej infekcie; podporná liečba (kontrola TK, edémov, soľ a tekutiny).',
                        'U detí výborná prognóza; u dospelých/diabetikov horšia — sledovať reziduálnu proteinúriu a funkciu.'
                    ] }
                ]
            },

            lupus: {
                id: 'lupus', kind: 'r', severity: 'warn',
                category: 'Lupusová nefritída',
                summary: 'Renálne postihnutie pri systémovom lupus erythematosus — trieda (I–VI podľa ISN/RPS) určuje liečbu; '
                    + 'proliferatívne triedy (III/IV) sú aktívne a vyžadujú imunosupresiu.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'ANA, anti-dsDNA (koreluje s aktivitou), nízke C3 aj C4; multisystémové príznaky.',
                        'Sediment a proteinúria podľa triedy; trieda V (membranózna) sa prejavuje nefrotickým syndrómom.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Renálna biopsia na určenie triedy a indexu aktivity/chronicity.',
                        'Indukcia pri III/IV: glukokortikoidy + mykofenolát alebo nízkodávkový cyklofosfamid, často s belimumabom alebo vokloosporínom; hydroxychlorochín u všetkých.'
                    ] }
                ],
                links: [
                    { href: 'calculator_uacr.php', label: 'UACR a KDIGO klasifikácia' }
                ]
            },

            mpgn_c3g: {
                id: 'mpgn_c3g', kind: 'r', severity: 'warn',
                category: 'MPGN / C3 glomerulopatia',
                summary: 'Membranoproliferatívny vzor s perzistentne nízkym C3 — moderne sa delí podľa IF na '
                    + 'imunokomplexovú MPGN vs C3 glomerulopatiu (dráha alternatívneho komplementu).',
                sections: [
                    { heading: 'Vyšetrenia', items: [
                        'Vyšetriť príčinu: infekcie (HCV), monoklonálna gamapatia (najmä u dospelých > 50 r), autoimunita.',
                        'Komplementový panel: C3, C4, C3 nefritický faktor, faktor H/I, membránový atakový komplex (sC5b-9); biopsia s IF a EM.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Liečiť podkladovú príčinu (antivirotiká pri HCV, klon-cielená liečba pri monoklonálnej gamapatii — pozri MGRS).',
                        'Renoprotekcia (RAAS blokáda); pri primárnej C3G individuálne imunosupresia, prípadne anti-C5 v ťažkých prípadoch.'
                    ] }
                ],
                links: [
                    { href: 'calculator_mgrs.php', label: 'MGRS — klasifikácia (renálny význam)' }
                ]
            },

            cryo: {
                id: 'cryo', kind: 'r', severity: 'warn',
                category: 'Kryoglobulinemická glomerulonefritída',
                summary: 'Membranoproliferatívny vzor s kryoglobulínmi a výrazne nízkym C4 — najčastejšie pri chronickej '
                    + 'hepatitíde C (zmiešaná kryoglobulinémia typ II).',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Hmatateľná purpura, artralgie, neuropatia; kryoglobulíny pozitívne, reumatoidný faktor zvýšený, nízke C4.',
                        'Hľadať HCV (a HBV/HIV); pri esenciálnej forme aj lymfoproliferáciu a autoimunitu.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Liečba príčiny: priame antivirotiká pri HCV (kľúčové); pri ťažkom renálnom postihnutí rituximab ± plazmaferéza a glukokortikoidy.'
                    ] }
                ]
            },

            iga: {
                id: 'iga', kind: 'r', severity: 'warn',
                category: 'IgA nefropatia / IgA vaskulitída',
                summary: 'Najčastejšia primárna glomerulonefritída — mezangiálne depozity IgA; IgA vaskulitída (Henoch–Schönlein) '
                    + 'je jej systémová forma s purpurou. Normálny komplement.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Synfaryngitická makrohematúria alebo mikrohematúria s proteinúriou; pri IgA vaskulitíde purpura, artralgie, bolesti brucha.',
                        'Diagnóza biopsiou (IgA-dominantné mezangiálne depozity); riziko progresie podľa proteinúrie, TK a MEST-C skóre.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Základ: optimalizovaná podporná liečba — RAAS blokáda, cieľový TK, SGLT2 inhibítory, životospráva (KDIGO 2024).',
                        'Pri perzistujúcej proteinúrii napriek podpornej liečbe individuálne zvážiť imunosupresiu / cielené terapie (riziko vs prínos).'
                    ] }
                ],
                links: [
                    { href: 'calculator_igan.php', label: 'IgAN Prediction Tool (riziko progresie)' },
                    { href: 'calculator_uacr.php', label: 'UACR a KDIGO klasifikácia' }
                ]
            },

            hereditary: {
                id: 'hereditary', kind: 'r', severity: 'info',
                category: 'Hereditárna / izolovaná hematúria (Alport, tenké membrány)',
                summary: 'Perzistentná glomerulárna hematúria s rodinným výskytom — Alportov syndróm (progresívny, s poruchou '
                    + 'sluchu a očí) alebo choroba tenkých bazálnych membrán (zvyčajne benígna).',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Rodinná anamnéza hematúrie/zlyhania obličiek, senzorineurálna porucha sluchu, očné anomálie (Alport).',
                        'Elektrónová mikroskopia (stenčenie vs lamelovanie GBM); genetické testovanie (COL4A3/4/5).'
                    ] },
                    { heading: 'Manažment', items: [
                        'Alport: včasná RAAS blokáda spomaľuje progresiu; sledovanie funkcie, sluchu a zraku, genetické poradenstvo.',
                        'Tenké bazálne membrány: zvyčajne dobrá prognóza — sledovanie proteinúrie a TK.'
                    ] }
                ]
            },

            diabetic: {
                id: 'diabetic', kind: 'r', severity: 'warn',
                category: 'Diabetická nefropatia (diabetické ochorenie obličiek)',
                summary: 'Najčastejšia príčina nefrotickej proteinúrie a zlyhania obličiek — postupná albuminúria pri '
                    + 'dlhotrvajúcom diabete, zvyčajne s retinopatiou a bez aktívneho sedimentu.',
                sections: [
                    { heading: 'Kedy zvážiť biopsiu (atypický obraz)', items: [
                        'Náhly nefrotický syndróm, aktívny sediment/hematúria, rýchly pokles GFR, neprítomnosť retinopatie alebo krátke trvanie diabetu — zvážte inú/superponovanú glomerulopatiu.'
                    ] },
                    { heading: 'Manažment (piliere)', items: [
                        'RAAS blokáda (ACEi/ARB) titrovaná na maximum, SGLT2 inhibítor, nesteroidný MRA (finerenón) podľa indikácie.',
                        'Glykemická a tlaková kontrola, GLP-1 receptorový agonista pri DM2, manažment lipidov a kardiovaskulárneho rizika.'
                    ] }
                ],
                links: [
                    { href: 'calculator_uacr.php', label: 'UACR a KDIGO klasifikácia' },
                    { href: 'calculator_kfre.php', label: 'KFRE — riziko zlyhania obličiek' }
                ]
            },

            mcd: {
                id: 'mcd', kind: 'r', severity: 'warn',
                category: 'Choroba minimálnych zmien (MCD)',
                summary: 'Najčastejšia príčina nefrotického syndrómu u detí — náhly začiatok, selektívna proteinúria, '
                    + 'svetelná mikroskopia takmer normálna, na EM difúzne stenčenie pedicíl.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Náhly nefrotický syndróm, normálny TK aj funkcia; u detí sa biopsia spravidla nerobí pred liečbou.',
                        'U dospelých vylúčiť sekundárne príčiny (NSA, hematologické malignity — najmä Hodgkin).'
                    ] },
                    { heading: 'Manažment', items: [
                        'Glukokortikoidy (väčšina dobre reaguje); pri častých relapsoch/steroid-dependencii kalcineurínové inhibítory, rituximab.',
                        'Podporná liečba edémov a tromboprofylaxia podľa rizika.'
                    ] }
                ]
            },

            membranous: {
                id: 'membranous', kind: 'r', severity: 'warn',
                category: 'Membranózna nefropatia',
                summary: 'Častá príčina nefrotického syndrómu u dospelých — subepiteliálne imunodepozity; ~70 % primárnych '
                    + 'je anti-PLA2R pozitívnych. Vždy vylúčiť sekundárne príčiny.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Anti-PLA2R (a anti-THSD7A) protilátky; titer koreluje s aktivitou a prognózou.',
                        'Sekundárne príčiny: malignita (skríning podľa veku), lupus (trieda V), infekcie (HBV), lieky (NSA) — aktívne hľadať.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Riziková stratifikácia (proteinúria, funkcia, anti-PLA2R); podporná renoprotekcia u nízkeho rizika.',
                        'Imunosupresia pri strednom/vysokom riziku: rituximab, cyklofosfamid + steroidy (Ponticelli) alebo kalcineurínové inhibítory; antikoagulácia podľa rizika trombózy.'
                    ] }
                ],
                links: [
                    { href: 'calculator_uacr.php', label: 'UACR a KDIGO klasifikácia' }
                ]
            },

            fsgs: {
                id: 'fsgs', kind: 'r', severity: 'warn',
                category: 'Fokálna segmentálna glomeruloskleróza (FSGS)',
                summary: 'Vzor poškodenia podocytov — odlíšiť primárnu (difúzne stenčenie pedicíl, plný nefrotický syndróm) '
                    + 'od sekundárnej/adaptívnej (hyperfiltrácia, redukcia nefrónov, obezita, refluxová nefropatia).',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Primárna: náhly nefrotický syndróm, na EM difúzne stieranie pedicíl; zvážiť suPAR a genetické formy.',
                        'Sekundárna/adaptívna: subnefrotická proteinúria, normálny albumín, fokálne stieranie pedicíl; APOL1 rizikové alely.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Primárna: glukokortikoidy, pri rezistencii kalcineurínové inhibítory; podporná renoprotekcia.',
                        'Sekundárna: liečiť príčinu + RAAS blokáda a SGLT2 inhibítor (imunosupresia spravidla nie je indikovaná).'
                    ] }
                ]
            },

            secondary_nephrotic: {
                id: 'secondary_nephrotic', kind: 'r', severity: 'warn',
                category: 'Sekundárny nefrotický syndróm (amyloidóza, paraproteín, iné)',
                summary: 'Nefrotická proteinúria pri systémovom ochorení — renálna amyloidóza (AL/AA), monoklonálne '
                    + 'gamapatie renálneho významu, malignity, lieky a infekcie.',
                sections: [
                    { heading: 'Vyšetrenia', items: [
                        'Sérové/močové voľné ľahké reťazce a imunofixácia, SPEP/UPEP; pri podozrení na amyloid Kongo červeň v biopsii.',
                        'Skríning malignity a infekcií podľa kontextu; posúdiť postihnutie srdca (amyloid).'
                    ] },
                    { heading: 'Manažment', items: [
                        'Liečba základného ochorenia (klon-cielená liečba pri AL amyloidóze/MGRS; protizápalová pri AA).',
                        'Podporná renoprotekcia a manažment nefrotických komplikácií (edémy, trombóza, dyslipidémia).'
                    ] }
                ],
                links: [
                    { href: 'calculator_mgrs.php', label: 'MGRS — klasifikácia (renálny význam)' },
                    { href: 'calculator_mgus.php', label: 'MGUS — riziková stratifikácia a κ/λ' }
                ]
            }
        }
    };

    window.NefroDecisionTree.mount('gn-tool', GN_TREE);
})();
