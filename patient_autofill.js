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
     * Odvodí vek z rodného čísla.
     * @param {string} raw
     * @returns {number|null}
     */
    function ageFromBirthNumber(raw) {
        var d = raw.replace(/[\s\/]/g, '');
        if (!/^\d{9,10}$/.test(d)) return null;
        var yy = +d.slice(0, 2), mm = +d.slice(2, 4), dd = +d.slice(4, 6);
        if (mm >= 71)      mm -= 70; // žena — záložný rozsah
        else if (mm >= 51) mm -= 50; // žena — bežný rozsah
        else if (mm >= 21) mm -= 20; // muž  — záložný rozsah
        if (mm < 1 || mm > 12 || dd < 1 || dd > 31) return null;
        var cy = new Date().getFullYear();
        var yr = (2000 + yy <= cy) ? 2000 + yy : 1900 + yy;
        var ds = yr + '-' + String(mm).padStart(2, '0') + '-' + String(dd).padStart(2, '0');
        return ageFromDate(ds);
    }

    /**
     * Odvodí pohlavie z rodného čísla.
     * @param {string} raw
     * @returns {'female'|'male'|null}
     */
    function sexFromBirthNumber(raw) {
        var d = raw.replace(/[\s\/]/g, '');
        if (!/^\d{9,10}$/.test(d)) return null;
        var mm = +d.slice(2, 4);
        if (mm >= 51 && mm <= 62) return 'female'; // žena — bežný rozsah (+50)
        if (mm >= 71 && mm <= 82) return 'female'; // žena — záložný rozsah (+70)
        if (mm >= 1  && mm <= 12) return 'male';   // muž  — bežný rozsah
        if (mm >= 21 && mm <= 32) return 'male';   // muž  — záložný rozsah (+20)
        return null;
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
                var raw = this.value;
                var age = ageFromBirthNumber(raw);
                var sex = sexFromBirthNumber(raw);
                if (age !== null) fillAge(age);
                if (sex !== null) fillSex(sex);
            });
        }
    });

})();
