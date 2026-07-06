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
    var lastResult = null;

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

    function formatNumber(value, decimals) {
        return value.toFixed(decimals).replace('.', ',');
    }

    function twoDigits(value) {
        return String(value).padStart(2, '0');
    }

    function formatDateTime(date) {
        return twoDigits(date.getDate()) + '. ' + twoDigits(date.getMonth() + 1) + '. ' + date.getFullYear()
            + ' ' + twoDigits(date.getHours()) + ':' + twoDigits(date.getMinutes());
    }

    function dateStamp(date) {
        return date.getFullYear() + '-' + twoDigits(date.getMonth() + 1) + '-' + twoDigits(date.getDate());
    }

    function csvCell(value) {
        return '"' + String(value == null ? '' : value).replace(/"/g, '""') + '"';
    }

    function downloadTextFile(filename, content, mimeType) {
        var blob = new Blob([content], { type: mimeType + ';charset=utf-8' });
        var url = URL.createObjectURL(blob);
        var link = document.createElement('a');
        link.href = url;
        link.download = filename;
        link.hidden = true;
        document.body.appendChild(link);
        link.click();
        window.setTimeout(function () {
            URL.revokeObjectURL(url);
            link.remove();
        }, 0);
    }

    function setExportStatus(message) {
        var status = $('dieta-export-status');
        if (status) { status.textContent = message; }
    }

    function buildFilename(result, extension) {
        var kg = Math.round(result.weightKg);
        return 'renalna-dieta-' + kg + 'kg-' + dateStamp(result.createdAt) + '.' + extension;
    }

    function buildSummary(result) {
        var lines = [
            'Plánovač renálnej diéty – vypočítané cieľové denné limity',
            'Vypočítané: ' + formatDateTime(result.createdAt),
            'Klinická kategória: ' + result.categoryLabel,
            'Telesná hmotnosť: ' + Math.round(result.weightKg) + ' kg',
            'Hyperkaliémia: ' + (result.hyperK ? 'áno' : 'nie'),
            'Hyperfosfatémia: ' + (result.hyperP ? 'áno' : 'nie'),
            ''
        ];

        result.rows.forEach(function (row) {
            lines.push(row.name + ': ' + row.value);
            if (row.note) { lines.push('Poznámka: ' + row.note); }
            lines.push('');
        });

        lines.push(result.note);
        return lines.join('\n');
    }

    function buildCsv(result) {
        var rows = [
            ['Plánovač renálnej diéty', ''],
            ['Vypočítané', formatDateTime(result.createdAt)],
            ['Klinická kategória', result.categoryLabel],
            ['Telesná hmotnosť', Math.round(result.weightKg) + ' kg'],
            ['Hyperkaliémia', result.hyperK ? 'áno' : 'nie'],
            ['Hyperfosfatémia', result.hyperP ? 'áno' : 'nie'],
            [],
            ['Parameter', 'Hodnota', 'Poznámka']
        ];

        result.rows.forEach(function (row) {
            rows.push([row.name, row.value, row.note || '']);
        });
        rows.push([]);
        rows.push(['Upozornenie', result.note]);

        return '\ufeff' + rows.map(function (row) {
            return row.map(csvCell).join(';');
        }).join('\r\n');
    }

    function copyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text);
        }

        return new Promise(function (resolve, reject) {
            var textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.setAttribute('readonly', 'readonly');
            textarea.className = 'visually-hidden';
            document.body.appendChild(textarea);
            textarea.select();

            try {
                if (document.execCommand('copy')) {
                    resolve();
                } else {
                    reject(new Error('copy failed'));
                }
            } catch (error) {
                reject(error);
            } finally {
                textarea.remove();
            }
        });
    }

    function makeActionButton(className, text, action) {
        var button = el('button', className, text);
        button.type = 'button';
        if (action) { button.dataset.dietaExport = action; }
        return button;
    }

    function makeRow(name, value, note) {
        var block = el('div', 'tool-result-section');
        block.appendChild(el('h4', 'tool-result-section__heading', name));
        block.appendChild(el('p', 'dieta-result__value', value));
        if (note) { block.appendChild(el('p', 'tool-step__text', note)); }
        return block;
    }

    function createResult(weight, cat, hyperK, hyperP) {
        var rows = [
            {
                name: 'Bielkoviny',
                value: rangeText(cat.proteinLow * weight, cat.proteinHigh * weight, 'g/deň')
                    + '  (' + formatNumber(cat.proteinLow, 2) + '–'
                    + formatNumber(cat.proteinHigh, 2) + ' g/kg/deň)',
                note: cat.proteinNote
            },
            {
                name: 'Energia',
                value: rangeText(ENERGY_LOW * weight, ENERGY_HIGH * weight, 'kcal/deň')
                    + '  (25–35 kcal/kg/deň)',
                note: 'Upravte podľa veku, fyzickej aktivity a cieľovej hmotnosti. Dostatočná energia je '
                    + 'nevyhnutná, aby sa bielkoviny nevyužívali ako zdroj energie (prevencia malnutrície).'
            },
            {
                name: 'Sodík',
                value: '< 2 300 mg/deň (< 100 mmol; ≈ < 5–6 g kuchynskej soli)',
                note: 'Obmedzenie sodíka zlepšuje kontrolu krvného tlaku, objemu a účinok RAAS blokády/diuretík. '
                    + 'Hlavný zdroj je spracovaná strava a pridaná soľ.'
            },
            {
                name: 'Draslík',
                value: hyperK ? '≈ 2 000–3 000 mg/deň (50–75 mmol) — obmedziť' : 'Individualizovať podľa kalémie',
                note: hyperK
                    ? 'Pri hyperkaliémii obmedzte draslík (ovocie/zelenina s vysokým obsahom, sušené plody, '
                        + 'orechy, čokoláda); zvážte aj acidózu, lieky (RAAS, K-šetriace diuretiká) a zápchu.'
                    : 'Rutinné obmedzenie nie je pre všetkých; cieľom je udržať sérový draslík v norme. '
                        + 'Uprednostnite rastlinné zdroje a vlákninu, ak nie je hyperkaliémia.'
            },
            {
                name: 'Fosfor',
                value: hyperP ? '≈ 800–1 000 mg/deň — prísnejšie obmedziť' : '≈ 800–1 000 mg/deň',
                note: 'Prednostne obmedzte anorganický fosfát z aditív (konzervanty, kolové nápoje, tavené syry) — '
                    + 'má vysokú vstrebateľnosť. Pri hyperfosfatémii kombinujte s viazačmi fosfátov a posúďte adherenciu.'
            }
        ];

        return {
            createdAt: new Date(),
            weightKg: weight,
            categoryLabel: cat.label,
            hyperK: hyperK,
            hyperP: hyperP,
            rows: rows,
            note: 'Hodnoty sú orientačné a vychádzajú z populačných odporúčaní (KDOQI 2020). Vždy individualizujte '
                + 'podľa reziduálnej funkcie obličiek, laboratória, komorbidít a nutričného stavu; ideálne v spolupráci '
                + 's renálnym dietológom. Pre bielkoviny použite ideálnu/upravenú telesnú hmotnosť.'
        };
    }

    function appendPrintHeader(out, result) {
        var header = el('div', 'dieta-print-header print-only');
        header.appendChild(el('h2', null, 'Plánovač renálnej diéty — vypočítané limity'));
        header.appendChild(el('p', null,
            'Kategória: ' + result.categoryLabel
            + ' | Hmotnosť: ' + Math.round(result.weightKg) + ' kg'
            + ' | Hyperkaliémia: ' + (result.hyperK ? 'áno' : 'nie')
            + ' | Hyperfosfatémia: ' + (result.hyperP ? 'áno' : 'nie')
            + ' | Vypočítané: ' + formatDateTime(result.createdAt)
        ));
        out.appendChild(header);
    }

    function appendActions(out) {
        var actions = el('div', 'tool-export-actions no-print');
        actions.appendChild(makeActionButton('btn-primary js-print', 'Vytlačiť výsledok'));
        actions.appendChild(makeActionButton('btn-secondary', 'Export CSV', 'csv'));
        actions.appendChild(makeActionButton('btn-secondary', 'Kopírovať súhrn', 'copy'));

        var status = el('span', 'tool-export-status');
        status.id = 'dieta-export-status';
        status.setAttribute('role', 'status');
        status.setAttribute('aria-live', 'polite');
        actions.appendChild(status);
        out.appendChild(actions);
    }

    function renderResult(out, result, shouldFocus) {
        out.innerHTML = '';
        appendPrintHeader(out, result);

        var banner = el('div', 'tool-outcome tool-outcome--info');
        banner.appendChild(el('span', 'tool-outcome__badge', 'Cieľové denné limity'));
        var h = el('h3', 'tool-outcome__title', result.categoryLabel);
        h.setAttribute('tabindex', '-1');
        banner.appendChild(h);
        banner.appendChild(el('p', 'tool-outcome__summary',
            'Orientačné denné ciele pri telesnej hmotnosti ' + Math.round(result.weightKg) + ' kg. '
            + 'Bielkoviny a energia sú prepočítané na hmotnosť; ostatné sú populačné ciele na individualizáciu.'));
        out.appendChild(banner);

        result.rows.forEach(function (row) {
            out.appendChild(makeRow(row.name, row.value, row.note));
        });

        out.appendChild(el('p', 'tool-outcome__note', result.note));
        appendActions(out);

        if (shouldFocus) {
            try { h.focus(); } catch (e) { /* noop */ }
        }
    }

    function handleExport(action) {
        if (!lastResult) { return; }

        if (action === 'csv') {
            downloadTextFile(
                buildFilename(lastResult, 'csv'),
                buildCsv(lastResult),
                'text/csv'
            );
            setExportStatus('CSV bolo pripravené na stiahnutie.');
            return;
        }

        if (action === 'copy') {
            copyText(buildSummary(lastResult))
                .then(function () { setExportStatus('Súhrn je skopírovaný do schránky.'); })
                .catch(function () { setExportStatus('Súhrn sa nepodarilo skopírovať.'); });
        }
    }

    function compute() {
        var out = $('dieta-result');
        var errBox = $('dieta-error');
        out.innerHTML = '';
        errBox.textContent = '';
        lastResult = null;

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

        lastResult = createResult(weight, cat, hyperK, hyperP);
        renderResult(out, lastResult, Boolean(this && this.scrollIntoBtn));
    }

    function init() {
        var out = $('dieta-result');
        if (!out) { return; }
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
        out.addEventListener('click', function (e) {
            var button = e.target.closest('[data-dieta-export]');
            if (!button) { return; }
            handleExport(button.dataset.dietaExport);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
