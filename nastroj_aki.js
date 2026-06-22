/*
 * nastroj_aki.js — Dátový strom: diferenciálna diagnostika AKI.
 * Vyžaduje nastroj_engine.js (window.NefroDecisionTree), načítaný pred týmto súborom.
 */
(function () {
    'use strict';
    if (!window.NefroDecisionTree) { return; }

    var AKI_TREE = {
        start: 'confirm',
        outcomeNote: 'Záver je orientačný a vychádza zo zadaných odpovedí. Vždy posúďte celkový '
            + 'klinický kontext, močový sediment a laboratórium; mnohé AKI majú zmiešanú etiológiu.',
        nodes: {
            confirm: {
                id: 'confirm', kind: 'q', step: 'Krok 1 — Potvrdenie a štádium',
                title: 'Spĺňa pacient kritériá AKI podľa KDIGO?',
                body: ['Akútne poškodenie obličiek (AKI) podľa KDIGO 2012 definujeme prítomnosťou aspoň jedného z kritérií:'],
                bullets: [
                    'vzostup sérového kreatinínu o ≥ 26,5 µmol/l (0,3 mg/dl) počas 48 hodín,',
                    'vzostup sérového kreatinínu na ≥ 1,5-násobok východiskovej hodnoty (známej alebo predpokladanej) počas ostatných 7 dní,',
                    'diuréza < 0,5 ml/kg/h počas ≥ 6 hodín.'
                ],
                prompt: 'Je niektoré z kritérií splnené?',
                options: [
                    { label: 'Áno — AKI potvrdené', hint: 'Pokračujte v diferenciálnej diagnostike (stage 1–3 podľa rozsahu vzostupu SCr a oligúrie).', next: 'obstruction' },
                    { label: 'Nie / zatiaľ nejasné', hint: 'Sledovať a prehodnotiť.', next: 'not_aki' }
                ]
            },

            obstruction: {
                id: 'obstruction', kind: 'q', step: 'Krok 2 — Vylúčiť postrenálnu príčinu',
                title: 'Sú prítomné známky obštrukcie močových ciest?',
                body: ['Postrenálnu (obštrukčnú) príčinu vylučujeme ako prvú, pretože je často rýchlo reverzibilná. Zvážte ju najmä pri:'],
                bullets: [
                    'anúrii alebo kolísavej diuréze,',
                    'hmatnom/distendovanom močovom mechúre, reziduálnom moči,',
                    'jedinej funkčnej obličke, malignite malej panvy, benígnej hyperplázii prostaty, nefrolitiáze.'
                ],
                prompt: 'Potvrdzuje USG hydronefrózu alebo je prítomná retencia moču?',
                options: [
                    { label: 'Áno — obštrukcia / hydronefróza', next: 'postrenal' },
                    { label: 'Nie — USG bez obštrukcie', hint: 'Pokračujte na prerenálnu príčinu.', next: 'prerenal' }
                ]
            },

            prerenal: {
                id: 'prerenal', kind: 'q', step: 'Krok 3 — Posúdiť prerenálnu príčinu',
                title: 'Svedčí obraz pre prerenálnu (hypoperfúznu) príčinu?',
                body: ['Prerenálne AKI vzniká pri zníženej perfúzii obličiek bez štrukturálneho poškodenia (zatiaľ). Typické súvislosti a nálezy:'],
                bullets: [
                    'hypovolémia (krvácanie, hnačka/vracanie, diuretiká), hypotenzia/šok, sepsa,',
                    'srdcové zlyhávanie, cirhóza/hepatorenálny syndróm (znížený efektívny objem),',
                    'lieky: NSA, ACEi/ARB, kalcineurínové inhibítory (zmena intraglomerulárnej hemodynamiky),',
                    'močový nález: nízka FENa (< 1 %), FEUrea < 35 %, U-Na < 20 mmol/l, bland sediment, vysoký pomer urea : kreatinín.'
                ],
                prompt: 'Reaguje funkcia obličiek na korekciu volémie/perfúzie a sedimentu je nevýrazný?',
                options: [
                    { label: 'Áno — pravdepodobne prerenálne', next: 'prerenal_out' },
                    { label: 'Nie / pretrváva napriek korekcii volémie', hint: 'Zvážte intrinsické (renálne) AKI.', next: 'intrinsic' }
                ]
            },

            intrinsic: {
                id: 'intrinsic', kind: 'q', step: 'Krok 4 — Intrinsické (renálne) AKI',
                title: 'Ktorý nález dominuje v močovom sedimente a klinike?',
                body: ['Pri intrinsickom AKI určujeme poškodený kompartment podľa močového sedimentu a sprievodných znakov. Vyberte dominujúci obraz:'],
                prompt: 'Dominujúci nález:',
                options: [
                    { label: 'Špinavohnedé granulárne valce / ischémia alebo nefrotoxín', hint: 'Tubulárne poškodenie.', next: 'atn' },
                    { label: 'Leukocyty, leukocytové valce, eozinofily, vyrážka/horúčka, nový liek', hint: 'Intersticiálny proces.', next: 'ain' },
                    { label: 'Dysmorfné erytrocyty, erytrocytové valce, proteinúria, hypertenzia', hint: 'Nefritický (glomerulárny) obraz.', next: 'gn' },
                    { label: 'Trombocytopénia + hemolýza (schistocyty) / vaskulárny obraz', hint: 'Mikroangiopatia / cievy.', next: 'vascular' }
                ]
            },

            // ── Výstupné uzly ──────────────────────────────────────────────
            not_aki: {
                id: 'not_aki', kind: 'r', severity: 'info',
                category: 'Zatiaľ nespĺňa kritériá AKI',
                summary: 'Kritériá KDIGO momentálne nie sú naplnené — sledujte vývoj a prehodnoťte.',
                sections: [
                    { heading: 'Odporúčaný postup', items: [
                        'Sériovo sledujte sérový kreatinín a diurézu (kritérium môže byť naplnené neskôr).',
                        'Odlíšte akútne zhoršenie od chronického ochorenia obličiek (AKI on CKD) — využite známu východiskovú hodnotu SCr.',
                        'Revidujte nefrotoxické lieky a stav volémie aj preventívne.'
                    ] }
                ],
                links: [
                    { href: 'calculator_egfr.php', label: 'eGFR kalkulačka (CKD-EPI 2021)' },
                    { href: 'calculator_egfr_slope.php', label: 'Rýchlosť poklesu eGFR (Slope)' }
                ]
            },

            postrenal: {
                id: 'postrenal', kind: 'r', severity: 'warn',
                category: 'Postrenálne AKI (obštrukcia)',
                summary: 'Obraz svedčí pre obštrukciu močových ciest — často rýchlo reverzibilná príčina, urgentne riešiť odtok moču.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Benígna hyperplázia prostaty, karcinóm prostaty, malignity malej panvy.',
                        'Obojstranná urolitiáza (alebo litiáza pri jedinej obličke), retroperitoneálna fibróza.',
                        'Neurogénny mechúr, obštrukcia katétra.'
                    ] },
                    { heading: 'Vyšetrenia', items: [
                        'USG obličiek a močového mechúra (hydronefróza, postmikčné rezíduum).',
                        'Zavedenie močového katétra (vylúčiť/odstrániť subvezikálnu obštrukciu).',
                        'CT pri neistote (litiáza, retroperitoneum) — pozor na kontrast pri AKI.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Odstrániť obštrukciu: katéter, nefrostómia alebo ureterálny stent (urologické konzílium).',
                        'Sledovať postobštrukčnú polyúriu a poruchy elektrolytov a volémie.'
                    ] }
                ]
            },

            prerenal_out: {
                id: 'prerenal_out', kind: 'r', severity: 'warn',
                category: 'Prerenálne AKI (hypoperfúzia)',
                summary: 'Funkčné AKI z hypoperfúzie — pri včasnej korekcii reverzibilné, pri pretrvávaní prechádza do ATN.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Hypovolémia (krvácanie, GIT straty, nadmerná diuréza), distribučný/kardiogénny šok, sepsa.',
                        'Srdcové zlyhávanie, cirhóza s hepatorenálnym syndrómom (znížený efektívny arteriálny objem).',
                        'Lieky meniace glomerulárnu hemodynamiku: NSA, ACEi/ARB, kalcineurínové inhibítory.'
                    ] },
                    { heading: 'Vyšetrenia', items: [
                        'FENa < 1 % a FEUrea < 35 % podporujú prerenálnu príčinu (FEUrea je spoľahlivejšia pri diuretikách).',
                        'U-Na < 20 mmol/l, vysoký pomer urea : kreatinín, koncentrovaný moč, bland sediment.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Optimalizovať volémiu a perfúziu (cielená tekutinová liečba podľa stavu — pozor na preťaženie pri srdcovom zlyhávaní/cirhóze).',
                        'Liečiť vyvolávajúcu príčinu (sepsa, krvácanie, srdcové zlyhávanie).',
                        'Dočasne vysadiť/prehodnotiť nefrotoxíny a RAAS blokádu; upraviť dávkovanie liekov podľa funkcie obličiek.'
                    ] }
                ],
                links: [
                    { href: 'calculator_aki.php', label: 'Kalkulačka FENa / FEUrea' }
                ]
            },

            atn: {
                id: 'atn', kind: 'r', severity: 'warn',
                category: 'Akútna tubulárna nekróza (ATN)',
                summary: 'Najčastejšia príčina intrinsického AKI — ischemická, toxická alebo pigmentová.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Ischemická: predĺžená hypoperfúzia/šok (kontinuum s prerenálnym AKI).',
                        'Nefrotoxická: aminoglykozidy, vankomycín, amfotericín B, cisplatina, jódová kontrastná látka.',
                        'Pigmentová: rabdomyolýza (myoglobín), masívna hemolýza (voľný hemoglobín).'
                    ] },
                    { heading: 'Vyšetrenia', items: [
                        'Močový sediment: špinavohnedé granulárne a epitelové valce; FENa býva > 2 %.',
                        'Pri podozrení na rabdomyolýzu kreatínkináza (CK), myoglobinúria; pri hemolýze haptoglobín, LDH.',
                        'Revízia liekov a kontrastných vyšetrení (dávky, hladiny, časová súvislosť).'
                    ] },
                    { heading: 'Manažment', items: [
                        'Podporná liečba: eliminovať noxu, optimalizovať perfúziu, manažment volémie a elektrolytov.',
                        'Vyhnúť sa ďalším nefrotoxínom; pri rabdomyolýze dostatočná hydratácia.',
                        'KRT pri klasických indikáciách (refraktérna hyperkaliémia, ťažká metabolická acidóza, preťaženie tekutinami, urémia).'
                    ] }
                ],
                links: [
                    { href: 'calculator_aki.php', label: 'Kalkulačka FENa / FEUrea' },
                    { href: 'calculator_mehran.php', label: 'Mehran skóre (kontrastom indukované AKI)' },
                    { href: 'article.php?slug=kedy-zacat-krt-pri-aki', label: 'Článok: Kedy začať KRT pri AKI' }
                ]
            },

            ain: {
                id: 'ain', kind: 'r', severity: 'warn',
                category: 'Akútna intersticiálna nefritída (AIN)',
                summary: 'Zápalové poškodenie interstícia, najčastejšie poliekové — kľúčové je rozpoznať a vysadiť vyvolávajúci liek.',
                sections: [
                    { heading: 'Časté príčiny', items: [
                        'Lieky: inhibítory protónovej pumpy, NSA, antibiotiká (betalaktámy, sulfónamidy, rifampicín), inhibítory kontrolných bodov.',
                        'Infekcie a autoimunitné/granulomatózne ochorenia (sarkoidóza, TINU, IgG4-asociované ochorenie).'
                    ] },
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Subfebrílie, vyrážka, artralgie a eozinofília — klasická triáda je však zriedkavá a jej absencia AIN nevylučuje.',
                        'Sterilná pyúria, leukocytové valce, mierna proteinúria; časová súvislosť s nasadením lieku.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Vysadiť pravdepodobný vyvolávajúci liek (základné a často postačujúce opatrenie).',
                        'Pri pretrvávaní/významnom poklese funkcie alebo bioptickom potvrdení zvážiť kortikoidy.',
                        'Biopsia obličky na potvrdenie diagnózy pri neistote.'
                    ] }
                ]
            },

            gn: {
                id: 'gn', kind: 'r', severity: 'urgent',
                category: 'Glomerulárne AKI (nefritický syndróm / RPGN)',
                summary: 'Nefritický obraz môže znamenať rýchlo progredujúcu glomerulonefritídu — naliehavá situácia vyžadujúca promptnú diagnostiku a liečbu.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Dysmorfné erytrocyty a erytrocytové valce, proteinúria, hypertenzia, oligúria, edémy.',
                        'Rýchly vzostup kreatinínu počas dní až týždňov (podozrenie na RPGN).'
                    ] },
                    { heading: 'Urgentné vyšetrenia', items: [
                        'Imunológia: ANA, anti-dsDNA, ANCA (MPO/PR3), anti-GBM, komplement C3/C4, kryoglobulíny, ASLO.',
                        'Sérológie hepatitíd B a C, HIV; kvantifikácia proteinúrie (UACR/UPCR).',
                        'Promptná nefrologická konzultácia a biopsia obličky — pri RPGN bezodkladne.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Liečba podľa etiológie (napr. imunosupresia pri ANCA-asociovanej vaskulitíde, anti-GBM, lupusovej nefritíde).',
                        'Čas je obličkové tkanivo — oneskorenie zhoršuje renálnu prognózu.'
                    ] }
                ],
                links: [
                    { href: 'calculator_uacr.php', label: 'UACR a KDIGO klasifikácia' }
                ]
            },

            vascular: {
                id: 'vascular', kind: 'r', severity: 'urgent',
                category: 'Vaskulárne / mikroangiopatické AKI',
                summary: 'Postihnutie ciev alebo trombotická mikroangiopatia — niektoré jednotky (TTP, aHUS) sú urgentné a hematologicky/nefrologicky liečiteľné.',
                sections: [
                    { heading: 'Diferenciálna diagnostika', items: [
                        'Trombotická mikroangiopatia: TTP, typický a atypický HUS (aHUS).',
                        'Ateroembolická choroba (cholesterolové emboly po angiografii/chirurgii — livedo, eozinofília, oneskorený nástup).',
                        'Trombóza/stenóza renálnej artérie alebo vény, sklerodermická renálna kríza, malígna hypertenzia.'
                    ] },
                    { heading: 'Vyšetrenia', items: [
                        'Krvný náter (schistocyty), trombocyty, LDH, haptoglobín, priamy Coombs (mikroangiopatická hemolýza).',
                        'ADAMTS13 pri podozrení na TTP; komplementový panel pri aHUS; zobrazenie renálnych ciev.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Urgentné: terapeutická výmena plazmy pri TTP, eculizumab pri aHUS.',
                        'Kontrola tlaku a špecifická liečba podľa jednotky; nefrologické a hematologické konzílium.'
                    ] }
                ]
            }
        }
    };

    window.NefroDecisionTree.mount('aki-tool', AKI_TREE);
})();
