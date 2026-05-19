/**
 * calculator.js — spoločná JS logika pre všetky kalkulačky
 * Krok 1: Auto-save toggle + localStorage pre hostí
 * Krok 2: Vizualizácia rizika (risk gauge)
 * Krok 3: Porovnanie (odkaz na históriu)
 * Krok 4: Quickfill z profilu
 */
'use strict';

document.addEventListener('DOMContentLoaded', function () {

    // ── 1. AUTO-SAVE TOGGLE ───────────────────────────────────────────────────
    var saveBtn = document.querySelector('button[name="action"][value="save"]');
    var calcBtn = document.querySelector('button[name="action"][value="calculate"]');

    if (calcBtn && saveBtn) {
        // Vytvor toggle kontajner
        var actionsDiv = saveBtn.closest('.form-actions');
        if (actionsDiv) {
            var toggleLabel = document.createElement('label');
            toggleLabel.className = 'calc-autosave-label';
            toggleLabel.title = 'Automaticky uložiť každý výpočet (len pre prihlásených)';
            toggleLabel.innerHTML =
                '<input type="checkbox" id="calc_autosave_toggle" class="calc-autosave-cb"> ' +
                '<span>Auto-uloženie</span>';
            actionsDiv.appendChild(toggleLabel);

            var autoCb = document.getElementById('calc_autosave_toggle');
            // Obnov preferenciu
            autoCb.checked = localStorage.getItem('calc_autosave') === '1';

            autoCb.addEventListener('change', function () {
                localStorage.setItem('calc_autosave', this.checked ? '1' : '0');
            });

            // Pri kliknutí na "Vypočítať" — ak auto-save zapnuté, zmeň action na save
            calcBtn.addEventListener('click', function (e) {
                if (autoCb.checked) {
                    calcBtn.value = 'save';
                    // Obnovíme po odoslaní
                    setTimeout(function () { calcBtn.value = 'calculate'; }, 200);
                }
            });
        }
    }

    // ── 2. VIZUALIZÁCIA RIZIKA — risk gauge ───────────────────────────────────
    // Nájdi všetky elementy s data-risk-value a data-risk-max
    document.querySelectorAll('[data-risk-value]').forEach(function (el) {
        var val = parseFloat(el.dataset.riskValue || '0');
        var max = parseFloat(el.dataset.riskMax || '100');
        var pct = Math.min(100, Math.max(0, (val / max) * 100));

        var gauge = document.createElement('div');
        gauge.className = 'risk-gauge';
        gauge.setAttribute('role', 'meter');
        gauge.setAttribute('aria-valuenow', val);
        gauge.setAttribute('aria-valuemin', '0');
        gauge.setAttribute('aria-valuemax', max);
        gauge.setAttribute('aria-label', el.dataset.riskLabel || 'Riziko');

        var fill = document.createElement('div');
        fill.className = 'risk-gauge__fill';
        fill.style.width = pct.toFixed(1) + '%';

        gauge.appendChild(fill);
        el.appendChild(gauge);
    });

    // ── 3. POROVNANIE — tlačidlo do histórie ──────────────────────────────────
    var resultBlock = document.querySelector('.calculator-result-block');
    var loadId = new URLSearchParams(window.location.search).get('load_id');

    if (resultBlock && loadId) {
        var histBtn = document.createElement('a');
        histBtn.href = 'calculator_history.php';
        histBtn.className = 'btn-secondary';
        histBtn.textContent = 'História výpočtov';
        var actDiv = resultBlock.querySelector('.form-actions');
        if (actDiv) {
            actDiv.appendChild(histBtn);
        }
    }

    // ── 4. QUICKFILL Z PROFILU ────────────────────────────────────────────────
    // Dáta sú dostupné cez window.calcProfileData (generuje calc_subnav.php z DB)
    var profileData = window.calcProfileData || null;

    if (profileData) {
        var sexSel      = document.getElementById('sex');
        var ageFld      = document.getElementById('age_years');
        var bdFld       = document.getElementById('patient_birth_date');
        var fnFld       = document.getElementById('patient_first_name');
        var lnFld       = document.getElementById('patient_last_name');

        var hasFields = sexSel || ageFld || bdFld;
        if (hasFields) {
            var qfBtn = document.createElement('button');
            qfBtn.type = 'button';
            qfBtn.className = 'btn-secondary calc-quickfill-btn';
            qfBtn.textContent = '⚡ Vyplniť z profilu';
            qfBtn.title = 'Predvyplní pohlavie a vek z vášho profilu';

            var firstFormGroup = document.querySelector('.form-section .form-group, .calc-form .form-group');
            if (firstFormGroup) {
                firstFormGroup.parentNode.insertBefore(qfBtn, firstFormGroup);
            }

            qfBtn.addEventListener('click', function () {
                if (sexSel && profileData.sex) {
                    sexSel.value = profileData.sex;
                }
                if (ageFld && profileData.age) {
                    ageFld.value = profileData.age;
                }
                if (bdFld && profileData.birth_date) {
                    bdFld.value = profileData.birth_date;
                }
                if (fnFld && profileData.first_name) {
                    fnFld.value = profileData.first_name;
                }
                if (lnFld && profileData.last_name) {
                    lnFld.value = profileData.last_name;
                }
                qfBtn.textContent = '✓ Vyplnené';
                qfBtn.disabled = true;
                setTimeout(function () {
                    qfBtn.textContent = '⚡ Vyplniť z profilu';
                    qfBtn.disabled = false;
                }, 2000);
            });
        }
    }

    // ── 5. AUTO-VYPLNENIE DÁTUMU NARODENIA Z RODNÉHO ČÍSLA ───────────────────
    (function () {
        function parseRodneCislo(rc) {
            rc = rc.replace(/[\s/]/g, '');
            if (!/^\d{9,10}$/.test(rc)) return null;

            var yy = parseInt(rc.substring(0, 2), 10);
            var mm = parseInt(rc.substring(2, 4), 10);
            var dd = parseInt(rc.substring(4, 6), 10);

            // Korekcia mesiaca: ženy +50, cudzinci +20 alebo +70
            if (mm > 70)      mm -= 70;
            else if (mm > 50) mm -= 50;
            else if (mm > 20) mm -= 20;

            // Storočie: 10-miestne RC vydané od r. 1954
            var year = (rc.length === 10 && yy < 54) ? 2000 + yy : 1900 + yy;

            if (mm < 1 || mm > 12 || dd < 1 || dd > 31) return null;

            return year.toString().padStart(4, '0') + '-' +
                   mm.toString().padStart(2, '0') + '-' +
                   dd.toString().padStart(2, '0');
        }

        var rcInput = document.getElementById('patient_birth_number');
        var bdInput = document.getElementById('patient_birth_date');
        var sexSel2 = document.getElementById('sex');
        var ageInp  = document.getElementById('age_years');

        if (!rcInput || !bdInput) return;

        function onRcChange() {
            var val = rcInput.value.trim();
            var date = parseRodneCislo(val);
            if (!date) return;

            // Vyplniť dátum narodenia len ak je prázdny alebo sa líši
            if (!bdInput.value || bdInput.value !== date) {
                bdInput.value = date;
                bdInput.dispatchEvent(new Event('change', { bubbles: true }));
            }

            // Vyplniť pohlavie z RC (mesiac > 50 = žena)
            if (sexSel2 && !sexSel2.value) {
                var rcMm = parseInt(val.substring(2, 4), 10);
                var isFemale = (rcMm > 50 && rcMm <= 62) || (rcMm > 70 && rcMm <= 82);
                sexSel2.value = isFemale ? 'female' : 'male';
            }

            // Vypočítať vek
            if (ageInp && (!ageInp.value || ageInp.value === '0')) {
                var bd = new Date(date);
                var today = new Date();
                var age = today.getFullYear() - bd.getFullYear();
                var m = today.getMonth() - bd.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < bd.getDate())) age--;
                if (age > 0 && age < 130) ageInp.value = age;
            }
        }

        rcInput.addEventListener('input', onRcChange);
        rcInput.addEventListener('blur',  onRcChange);

        // Spusti aj pri načítaní (ak je RC z histórie načítané)
        if (rcInput.value.trim().length >= 9) onRcChange();
    })();

    // ── LOCALSTORAGE pre neprihlásených ───────────────────────────────────────
    (function () {
        var savedSection = document.querySelector('.calc-saved-results');
        if (!savedSection) return;

        // Zistiť, či je používateľ neprihlásený podľa PHP výstupu sekcie
        var loginMsg = savedSection.querySelector('p');
        var isGuest  = loginMsg && loginMsg.textContent.indexOf('prihlás') !== -1;

        // Kľúč kalkulačky z URL (napr. "calculator_egfr")
        var calcPageKey = window.location.pathname.replace(/.*\//, '').replace('.php', '');

        // Vykresli lokálnu históriu pre neprihlásených
        function renderLocal() {
            var list = [];
            try { list = JSON.parse(localStorage.getItem('calc_local_history') || '[]'); } catch (e) {}
            list = list.filter(function (r) { return r.key === calcPageKey; });

            if (!list.length) {
                if (isGuest && loginMsg) {
                    loginMsg.textContent = 'Pre trvalú históriu sa prihláste. Žiadne lokálne záznamy.';
                }
                return;
            }

            var html = '<p class="calc-local-note">Záznamy uložené len vo vašom prehliadači.'
                + ' Pre trvalú históriu sa <a href="login.php">prihláste</a>.</p>';
            html += '<div class="calc-local-list">';
            list.forEach(function (r, i) {
                var d = new Date(r.timestamp);
                var ds = d.toLocaleDateString('sk-SK') + ' ' + d.toLocaleTimeString('sk-SK', {hour:'2-digit', minute:'2-digit'});
                html += '<div class="calc-local-entry">';
                html += '<div class="calc-local-entry__header"><span class="calc-local-entry__date">' + ds + '</span>'
                    + '<button type="button" class="btn-admin-action btn-admin-action--warn calc-local-del" data-idx="' + i + '">Vymazať</button></div>';
                html += '<div class="calc-local-entry__result">' + r.resultHtml + '</div>';
                html += '</div>';
            });
            html += '</div>';

            savedSection.innerHTML = '<h3>Uložené výsledky</h3>' + html;

            savedSection.querySelectorAll('.calc-local-del').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    try {
                        var all = JSON.parse(localStorage.getItem('calc_local_history') || '[]');
                        // Odstrán záznam s týmto indexom pre daný kľúč
                        var keyList = all.filter(function(r){ return r.key === calcPageKey; });
                        var delTs   = keyList[parseInt(this.dataset.idx, 10)].timestamp;
                        all = all.filter(function(r){ return r.timestamp !== delTs; });
                        localStorage.setItem('calc_local_history', JSON.stringify(all));
                    } catch (e) {}
                    renderLocal();
                });
            });
        }

        // Uložiť výsledok ak je výpočet zobrazený A používateľ je hosť
        var resultBlock = document.querySelector('.calculator-result-block');
        if (resultBlock && isGuest) {
            var formEl   = document.querySelector('form');
            var inputs   = {};
            if (formEl) {
                try {
                    new FormData(formEl).forEach(function (v, k) {
                        if (k !== 'csrf_token' && k !== 'action' && k !== 'js_token') {
                            inputs[k] = v;
                        }
                    });
                } catch (e) {}
            }

            var entry = {
                key:        calcPageKey,
                label:      document.title.split('|')[0].trim(),
                resultHtml: resultBlock.outerHTML,
                inputs:     inputs,
                timestamp:  new Date().toISOString(),
            };

            try {
                var all = JSON.parse(localStorage.getItem('calc_local_history') || '[]');
                all.unshift(entry);
                all = all.slice(0, 50);
                localStorage.setItem('calc_local_history', JSON.stringify(all));
            } catch (e) {}
        }

        // Vždy vykresli lokálnu históriu pre hostí
        if (isGuest) renderLocal();
    })();

});
