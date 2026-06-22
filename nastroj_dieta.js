/*
 * nastroj_dieta.js — Plánovač renálnej diéty: cieľové denné limity živín.
 * Klientsky výpočet (bez servera, bez engine). Limity podľa KDOQI 2020
 * (Nutrition in CKD) a KDIGO. Bez inline štýlov (CSP) — triedy v index.css.
 */
(function () {
    'use strict';

    // Bielkoviny (g/kg/deň) a krátky popis podľa kategórie.
    var CATEGORIES = {
        ckd_nd: {
            label: 'CKD G3–G5 bez dialýzy, bez diabetu',
            proteinLow: 0.55, proteinHigh: 0.60,
            proteinNote: 'Nízkobielkovinová diéta (0,55–0,60 g/kg/deň) u metabolicky stabilného pacienta '
                + 'spomaľuje progresiu. Veľmi nízky príjem (0,28–0,43 g/kg/deň) je možný len s keto-analógmi '
                + 'a pod dohľadom. Nevyhnutný dostatočný energetický príjem (prevencia malnutrície).'
        },
        ckd_nd_dm: {
            label: 'CKD G3–G5 bez dialýzy, s diabetom',
            proteinLow: 0.60, proteinHigh: 0.80,
            proteinNote: 'Pri diabete sa odporúča mierne vyšší príjem (0,6–0,8 g/kg/deň) pre udržanie '
                + 'glykemickej a nutričnej stability.'
        },
        hd: {
            label: 'Hemodialýza (udržiavacia)',
            proteinLow: 1.0, proteinHigh: 1.2,
            proteinNote: 'Dialýza zvyšuje potrebu bielkovín (straty do dialyzátu, katabolizmus) — '
                + '1,0–1,2 g/kg/deň.'
        },
        pd: {
            label: 'Peritoneálna dialýza',
            proteinLow: 1.0, proteinHigh: 1.2,
            proteinNote: 'PD má dodatočné straty bielkovín do dialyzátu — cieľ 1,0–1,2 g/kg/deň '
                + '(často horná hranica). Zohľadnite kalorický príspevok glukózy z dialyzátu.'
        }
    };

    var ENERGY_LOW = 25;   // kcal/kg/deň
    var ENERGY_HIGH = 35;

    function $(id) { return document.getElementById(id); }

    function el(tag, className, text) {
        var node = document.createElement(tag);
        if (className) { node.className = className; }
        if (text != null) { node.textContent = text; }
        return node;
    }

    function rangeText(lo, hi, unit) {
        var l = Math.round(lo);
        var h = Math.round(hi);
        if (l === h) { return l + ' ' + unit; }
        return l + '–' + h + ' ' + unit;
    }

    function makeRow(name, value, note) {
        var block = el('div', 'tool-result-section');
        block.appendChild(el('h4', 'tool-result-section__heading', name));
        block.appendChild(el('p', 'dieta-result__value', value));
        if (note) { block.appendChild(el('p', 'tool-step__text', note)); }
        return block;
    }

    function compute() {
        var out = $('dieta-result');
        var errBox = $('dieta-error');
        out.innerHTML = '';
        errBox.textContent = '';

        var weight = parseFloat(($('dieta-weight').value || '').replace(',', '.'));
        var catKey = $('dieta-category').value;
        var hyperK = $('dieta-hyperk').checked;
        var hyperP = $('dieta-hyperp').checked;
        var cat = CATEGORIES[catKey];

        if (!cat) { errBox.textContent = 'Vyberte klinickú kategóriu.'; return; }
        if (isNaN(weight) || weight < 20 || weight > 250) {
            errBox.textContent = 'Zadajte telesnú hmotnosť v rozsahu 20–250 kg (ideálne ideálnu/upravenú).';
            return;
        }

        var banner = el('div', 'tool-outcome tool-outcome--info');
        banner.appendChild(el('span', 'tool-outcome__badge', 'Cieľové denné limity'));
        var h = el('h3', 'tool-outcome__title', cat.label);
        h.setAttribute('tabindex', '-1');
        banner.appendChild(h);
        banner.appendChild(el('p', 'tool-outcome__summary',
            'Orientačné denné ciele pri telesnej hmotnosti ' + Math.round(weight) + ' kg. '
            + 'Bielkoviny a energia sú prepočítané na hmotnosť; ostatné sú populačné ciele na individualizáciu.'));
        out.appendChild(banner);

        // Bielkoviny
        out.appendChild(makeRow(
            'Bielkoviny',
            rangeText(cat.proteinLow * weight, cat.proteinHigh * weight, 'g/deň')
                + '  (' + cat.proteinLow.toFixed(2).replace('.', ',') + '–'
                + cat.proteinHigh.toFixed(2).replace('.', ',') + ' g/kg/deň)',
            cat.proteinNote
        ));

        // Energia
        out.appendChild(makeRow(
            'Energia',
            rangeText(ENERGY_LOW * weight, ENERGY_HIGH * weight, 'kcal/deň')
                + '  (25–35 kcal/kg/deň)',
            'Upravte podľa veku, fyzickej aktivity a cieľovej hmotnosti. Dostatočná energia je '
                + 'nevyhnutná, aby sa bielkoviny nevyužívali ako zdroj energie (prevencia malnutrície).'
        ));

        // Sodík
        out.appendChild(makeRow(
            'Sodík',
            '< 2 300 mg/deň (< 100 mmol; ≈ < 5–6 g kuchynskej soli)',
            'Obmedzenie sodíka zlepšuje kontrolu krvného tlaku, objemu a účinok RAAS blokády/diuretík. '
                + 'Hlavný zdroj je spracovaná strava a pridaná soľ.'
        ));

        // Draslík
        out.appendChild(makeRow(
            'Draslík',
            hyperK ? '≈ 2 000–3 000 mg/deň (50–75 mmol) — obmedziť' : 'Individualizovať podľa kalémie',
            hyperK
                ? 'Pri hyperkaliémii obmedzte draslík (ovocie/zelenina s vysokým obsahom, sušené plody, '
                    + 'orechy, čokoláda); zvážte aj acidózu, lieky (RAAS, K-šetriace diuretiká) a zápchu.'
                : 'Rutinné obmedzenie nie je pre všetkých; cieľom je udržať sérový draslík v norme. '
                    + 'Uprednostnite rastlinné zdroje a vlákninu, ak nie je hyperkaliémia.'
        ));

        // Fosfor
        out.appendChild(makeRow(
            'Fosfor',
            hyperP ? '≈ 800–1 000 mg/deň — prísnejšie obmedziť' : '≈ 800–1 000 mg/deň',
            'Prednostne obmedzte anorganický fosfát z aditív (konzervanty, kolové nápoje, tavené syry) — '
                + 'má vysokú vstrebateľnosť. Pri hyperfosfatémii kombinujte s viazačmi fosfátov a posúďte adherenciu.'
        ));

        out.appendChild(el('p', 'tool-outcome__note',
            'Hodnoty sú orientačné a vychádzajú z populačných odporúčaní (KDOQI 2020). Vždy individualizujte '
            + 'podľa reziduálnej funkcie obličiek, laboratória, komorbidít a nutričného stavu; ideálne v spolupráci '
            + 's renálnym dietológom. Pre bielkoviny použite ideálnu/upravenú telesnú hmotnosť.'));

        if (this && this.scrollIntoBtn) {
            try { h.focus(); } catch (e) { /* noop */ }
        }
    }

    function init() {
        if (!$('dieta-result')) { return; }
        var ids = ['dieta-weight', 'dieta-category', 'dieta-hyperk', 'dieta-hyperp'];
        ids.forEach(function (id) {
            var node = $(id);
            if (node) { node.addEventListener('input', compute); node.addEventListener('change', compute); }
        });
        var btn = $('dieta-calc-btn');
        if (btn) {
            btn.addEventListener('click', function () { compute.call({ scrollIntoBtn: true }); });
        }
        var form = $('dieta-form');
        if (form) { form.addEventListener('submit', function (e) { e.preventDefault(); compute.call({ scrollIntoBtn: true }); }); }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
