/**
 * patient_autofill.js
 *
 * Automatické vyplňovanie polí pacienta z rodného čísla a dátumu narodenia:
 *   - Vek (age_years) — z dátumu narodenia alebo z RČ
 *   - Pohlavie (sex)  — z RČ (mesiacové číslice)
 *
 * Použitie: vložiť <script src="patient_autofill.js" defer></script>
 * Predpokladá existenciu prvkov: #patient_birth_number, #patient_birth_date,
 * #age_years (voliteľné), #sex (voliteľné).
 */
(function () {
    'use strict';

    /**
     * Vypočíta vek z dátumu vo formáte YYYY-MM-DD.
     * @param {string} dateStr
     * @returns {number|null}
     */
    function ageFromDate(dateStr) {
        if (!dateStr) return null;
        var b = new Date(dateStr), t = new Date();
        var age = t.getFullYear() - b.getFullYear();
        var m = t.getMonth() - b.getMonth();
        if (m < 0 || (m === 0 && t.getDate() < b.getDate())) age--;
        return age >= 0 ? age : null;
    }

    /**
     * Vyplní pole #age_years hodnotou veku, ak existuje.
     * @param {number|null} age
     */
    function fillAge(age) {
        var el = document.getElementById('age_years');
        if (!el || age === null) return;
        el.value = age;
    }

    /**
     * Vyplní select #sex hodnotou 'female' alebo 'male', ak existuje
     * a používateľ ho ešte manuálne nezmenil (hodnota je prázdna alebo 'female' = default).
     * @param {'female'|'male'|null} sex
     */
    function fillSex(sex) {
        var el = document.getElementById('sex');
        if (!el || sex === null) return;
        // Vyplníme vždy — RČ je autoritatívny zdroj pohlavie
        el.value = sex;
        // Vizuálna spätná väzba: krátky highlight
        el.classList.add('autofilled');
        setTimeout(function () { el.classList.remove('autofilled'); }, 1500);
    }

    // ── Registrácia event listenerov ─────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        var bdEl = document.getElementById('patient_birth_date');
        var bnEl = document.getElementById('patient_birth_number');

        // Dátum narodenia → vek
        if (bdEl) {
            bdEl.addEventListener('change', function () {
                fillAge(ageFromDate(this.value));
            });
        }

        // Rodné číslo → vek + pohlavie
        if (bnEl) {
            bnEl.addEventListener('input', function () {
                if (typeof window.Utils === 'undefined' || typeof window.Utils.parseBirthNumber !== 'function') {
                    return;
                }
                var raw = this.value;
                var parsedData = window.Utils.parseBirthNumber(raw);
                if (!parsedData) return;
                if (parsedData.age !== null) fillAge(parsedData.age);
                if (parsedData.sex !== null) fillSex(parsedData.sex);
            });
        }
    });

})();
