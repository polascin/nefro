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
    var profileData = null;
    try {
        var raw = localStorage.getItem('calc_profile_prefill');
        if (raw) profileData = JSON.parse(raw);
    } catch (e) {}

    // Načítaj profil zo servera ak je prítomný meta tag
    var profileMeta = document.querySelector('meta[name="calc-profile"]');
    if (profileMeta) {
        try {
            profileData = JSON.parse(profileMeta.content);
            if (profileData) {
                localStorage.setItem('calc_profile_prefill', JSON.stringify(profileData));
            }
        } catch (e) {}
    }

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

    // ── LOCALSTORAGE pre neprihlásených ───────────────────────────────────────
    // Po zobrazení výsledku uložíme do localStorage (fallback pre hostí)
    var resultBlockLocal = document.querySelector('.calculator-result-block');
    if (resultBlockLocal) {
        var calcKey = document.querySelector('meta[name="calculator-key"]');
        if (calcKey && calcKey.content) {
            var resultData = {
                key:       calcKey.content,
                html:      resultBlockLocal.innerHTML,
                timestamp: new Date().toISOString(),
            };
            try {
                var histList = JSON.parse(localStorage.getItem('calc_local_history') || '[]');
                histList.unshift(resultData);
                histList = histList.slice(0, 20); // max 20 záznamov
                localStorage.setItem('calc_local_history', JSON.stringify(histList));
            } catch (e) {}
        }
    }

});
