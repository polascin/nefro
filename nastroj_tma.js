/*
 * nastroj_tma.js — Dátový strom: trombotická mikroangiopatia (TMA) — diferenciálna diagnostika.
 * Vyžaduje nastroj_engine.js (window.NefroDecisionTree), načítaný pred týmto súborom.
 */
(function () {
    'use strict';
    if (!window.NefroDecisionTree) { return; }

    var TMA_TREE = {
        start: 'confirm',
        outcomeNote: 'Záver je orientačný a vychádza zo zadaných odpovedí. TMA je urgentná — pri podozrení na TTP '
            + 'odoberte ADAMTS13 PRED podaním plazmy a nečakajte s plazmaferézou. Definitívne odlíšenie jednotiek '
            + 'stojí na ADAMTS13, komplementovom a STEC vyšetrení a klinickom kontexte (George & Nester NEJM 2014).',
        nodes: {
            confirm: {
                id: 'confirm', kind: 'q', step: 'Krok 1 — Potvrdenie TMA',
                title: 'Sú prítomné znaky trombotickej mikroangiopatie?',
                body: ['TMA = mikroangiopatická hemolytická anémia (MAHA) + trombocytopénia ± orgánové '
                    + 'poškodenie (najmä obličky a mozog) z trombov v mikrocirkulácii.'],
                bullets: [
                    'MAHA: schistocyty v nátere, ↑LDH, ↓haptoglobín, ↑bilirubín a retikulocyty, NEGATÍVNY priamy Coombs (DAT).',
                    'Trombocytopénia (často výrazná); ± akútne poškodenie obličiek, neurologické príznaky, postihnutie srdca.'
                ],
                prompt: 'Sú prítomné MAHA a trombocytopénia?',
                options: [
                    { label: 'Áno — MAHA + trombocytopénia', hint: 'Pokračujte v diferenciálnej diagnostike.', next: 'triage' },
                    { label: 'Nejasné — treba potvrdiť', hint: 'Ako potvrdiť TMA a čo odobrať.', next: 'confirm_workup' }
                ]
            },

            triage: {
                id: 'triage', kind: 'q', step: 'Krok 2 — Klinický kontext',
                title: 'Ktorý klinický kontext dominuje?',
                body: ['Kontext (hnačka, dominancia neurologického vs renálneho postihnutia, spúšťač) '
                    + 'usmerní pravdepodobnú jednotku. Súčasne odoberte ADAMTS13, komplement a STEC.'],
                prompt: 'Vyberte dominujúci kontext:',
                options: [
                    { label: 'Prevažne hematologický ± neurológia, kreatinín nízky/stredný', hint: 'Podozrenie na TTP (ťažký deficit ADAMTS13).', next: 'ttp_assess' },
                    { label: 'Hnačka (často krvavá), dieťa / po enterokolitíde, dominuje AKI', hint: 'STEC-HUS (typický HUS).', next: 'stec_hus' },
                    { label: 'Bez hnačky, dominuje AKI ± relaps / rodinná anamnéza / po transplantácii', hint: 'Podozrenie na komplement-mediovanú aHUS.', next: 'ahus_secondary' },
                    { label: 'Zjavný spúšťač (liek, malignita, ťažká HTN, gravidita/HELLP, sepsa, autoimunita)', hint: 'Sekundárna TMA.', next: 'secondary_tma' }
                ]
            },

            ttp_assess: {
                id: 'ttp_assess', kind: 'q', step: 'TTP — pravdepodobnosť',
                title: 'Aká je pravdepodobnosť ťažkého deficitu ADAMTS13 (skóre PLASMIC)?',
                body: ['Skóre PLASMIC odhaduje pravdepodobnosť ťažkého deficitu ADAMTS13 (TTP) ešte pred výsledkom testu '
                    + 'a pomáha rozhodnúť o okamžitej plazmaferéze. ADAMTS13 odoberte PRED podaním plazmy.'],
                bullets: ['Vysoká pravdepodobnosť TTP = relatívne zachovaná funkcia obličiek, výrazná trombocytopénia (< 30), '
                    + 'hemolýza, bez nádoru/transplantácie, MCV < 90 fl, INR < 1,5, kreatinín < 176,8 µmol/l.'],
                prompt: 'Vyberte pravdepodobnosť:',
                options: [
                    { label: 'Vysoká (PLASMIC 6–7)', hint: 'Liečiť ako TTP — neodkladná plazmaferéza.', next: 'ttp' },
                    { label: 'Nízka/stredná — dominuje AKI', hint: 'Prehodnotiť smerom k (a)HUS / sekundárnej TMA.', next: 'ahus_secondary' }
                ]
            },

            ahus_secondary: {
                id: 'ahus_secondary', kind: 'q', step: 'Renálna TMA — odlíšenie',
                title: 'Vylúčili ste TTP a STEC, alebo je prítomný sekundárny spúšťač?',
                body: ['Renálne dominujúca TMA bez ťažkého deficitu ADAMTS13 a bez STEC svedčí pre komplement-mediovanú '
                    + 'aHUS — ale najprv treba aktívne vylúčiť sekundárne príčiny, ktoré liečime inak.'],
                prompt: 'Vyberte:',
                options: [
                    { label: 'TTP (ADAMTS13 > 10 %) aj STEC vylúčené, bez sekundárneho spúšťača', hint: 'Komplement-mediovaná aHUS pravdepodobná.', next: 'ahus' },
                    { label: 'Identifikovaný sekundárny spúšťač', hint: 'Liek, malignita, HTN, gravidita, sepsa, autoimunita…', next: 'secondary_tma' }
                ]
            },

            // ── Výstupné uzly ──────────────────────────────────────────────
            confirm_workup: {
                id: 'confirm_workup', kind: 'r', severity: 'info',
                category: 'Ako potvrdiť TMA a čo odobrať',
                summary: 'Potvrďte mikroangiopatickú hemolýzu a trombocytopéniu a hneď odoberte kľúčové testy — '
                    + 'výsledky neskôr nasmerujú liečbu, ale liečbu TTP nemožno odkladať.',
                sections: [
                    { heading: 'Potvrdenie MAHA', items: [
                        'Náter periférnej krvi (schistocyty), LDH, haptoglobín, bilirubín, retikulocyty.',
                        'Priamy antiglobulínový test (Coombs) — pri TMA NEGATÍVNY (odlíši autoimunitnú hemolýzu).',
                        'Trombocyty, koagulácia (PT/aPTT, fibrinogén, D-dimér) na odlíšenie DIC.'
                    ] },
                    { heading: 'Cielené testy (odobrať pred liečbou)', items: [
                        'ADAMTS13 aktivita a inhibítor — PRED podaním plazmy/plazmaferézy.',
                        'Komplement (C3, C4, prípadne sC5b-9; genetika a anti-faktor H neskôr), stolica na STEC/Shiga toxín.',
                        'Tehotenský test, autoimunitný panel (ANA, antifosfolipidové protilátky), revízia liekov, posúdenie TK a malignity.'
                    ] }
                ]
            },

            ttp: {
                id: 'ttp', kind: 'r', severity: 'urgent',
                category: 'Trombotická trombocytopenická purpura (TTP)',
                summary: 'Ťažký deficit ADAMTS13 (vrodený alebo autoimunitný) — hematologická urgencia. Bez liečby '
                    + 'vysoká mortalita; plazmaferézu nemožno odkladať.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Výrazná trombocytopénia a MAHA, relatívne zachovaná funkcia obličiek, ± neurologické príznaky, horúčka.',
                        'ADAMTS13 aktivita < 10 % (s inhibítorom pri imunitnej forme) — odobrať PRED plazmou.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Neodkladná plazmaferéza (PLEX) + glukokortikoidy; pri vysokej pravdepodobnosti nečakať na výsledok ADAMTS13.',
                        'Kaplacizumab a rituximab podľa protokolu; doplnenie kyseliny listovej.',
                        'Transfúzia trombocytov LEN pri život ohrozujúcom krvácaní (inak môže zhoršiť trombózu).'
                    ] }
                ],
                links: [
                    { href: 'calculator_plasmic.php', label: 'PLASMIC skóre (pravdepodobnosť TTP)' }
                ]
            },

            stec_hus: {
                id: 'stec_hus', kind: 'r', severity: 'urgent',
                category: 'STEC-HUS (typický hemolyticko-uremický syndróm)',
                summary: 'TMA po infekcii Shiga-toxín produkujúcou E. coli (najčastejšie O157:H7) — typicky u detí po '
                    + 'krvavej hnačke; dominuje akútne poškodenie obličiek. Liečba je prevažne podporná.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Prodróm krvavej hnačky, dominantné AKI; potvrdenie stolicou na STEC / Shiga toxín.',
                        'ADAMTS13 nie je ťažko deficitný; komplement zvyčajne bez kauzálnej mutácie.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Podporná liečba: opatrná hydratácia/manažment objemu, korekcia elektrolytov, dialýza pri indikácii.',
                        'Vyhnúť sa antibiotikám a antimotilikám (môžu zvýšiť uvoľnenie toxínu a riziko HUS).',
                        'U väčšiny detí self-limiting; eculizumab len v selektovaných ťažkých prípadoch (napr. ťažké neurologické postihnutie).'
                    ] }
                ]
            },

            ahus: {
                id: 'ahus', kind: 'r', severity: 'urgent',
                category: 'Atypický HUS (komplement-mediovaná TMA)',
                summary: 'Dysregulácia alternatívnej dráhy komplementu — renálne dominujúca TMA bez ťažkého deficitu '
                    + 'ADAMTS13 a bez STEC. Vysoké riziko recidívy, najmä po transplantácii obličky.',
                sections: [
                    { heading: 'Klinické a laboratórne stopy', items: [
                        'Dominantné AKI, často bez hnačky; rodinná anamnéza, relapsy, spustenie infekciou/graviditou/transplantáciou.',
                        'Vyšetriť komplement (C3/C4, sC5b-9), genetiku regulátorov (CFH, CFI, MCP, C3, CFB) a anti-faktor H protilátky.'
                    ] },
                    { heading: 'Manažment', items: [
                        'Inhibícia terminálneho komplementu (eculizumab/ravulizumab) je liečbou prvej voľby — po vakcinácii proti meningokokom (± antibiotická profylaxia).',
                        'Plazmaferéza ako premostenie (najmä pri anti-faktor H protilátkach, kde pridať imunosupresiu); podporná renálna liečba.'
                    ] }
                ],
                links: [
                    { href: 'article.php?slug=cheatsheet-komplement', label: 'Ťahák: komplement a komplement-mediované choroby' },
                    { href: 'liek.php?slug=eculizumab', label: 'Eculizumab — detail lieku' }
                ]
            },

            secondary_tma: {
                id: 'secondary_tma', kind: 'r', severity: 'warn',
                category: 'Sekundárna TMA (identifikovateľný spúšťač)',
                summary: 'TMA na podklade inej príčiny — kľúčom je rozpoznať a odstrániť/liečiť spúšťač. '
                    + 'Komplementová inhibícia je vyhradená pre vybrané prípady.',
                sections: [
                    { heading: 'Časté spúšťače', items: [
                        'Lieky: kalcineurínové inhibítory (cyklosporín, takrolimus), gemcitabín, inhibítory VEGF, chinín.',
                        'Gravidita/HELLP a preeklampsia; malígna (ťažká) hypertenzia; sepsa/DIC; malignita.',
                        'Autoimunita (SLE, antifosfolipidový syndróm/sklerodermická renálna kríza); TMA po transplantácii; defekt kobalamínu C (u detí).'
                    ] },
                    { heading: 'Manažment', items: [
                        'Liečiť/odstrániť vyvolávajúcu príčinu (vysadiť liek, kontrola TK, pôrod pri HELLP, liečba sepsy/malignity).',
                        'Podporná renálna liečba; pri pretrvávajúcej TMA prehodnotiť aHUS a zvážiť komplementovú inhibíciu (najmä sklerodermická kríza vyžaduje ACEi, nie imunosupresiu).'
                    ] }
                ],
                links: [
                    { href: 'lieky.php?kat=transplant', label: 'Imunosupresíva (CNI) — databáza liekov' }
                ]
            }
        }
    };

    window.NefroDecisionTree.mount('tma-tool', TMA_TREE);
})();
