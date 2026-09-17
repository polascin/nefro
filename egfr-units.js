/**
 * Prepínanie jednotky eGFR (ml/min/1,73 m² ⇄ ml/s/1,73 m²).
 *
 * Kalkulačky počítajú v kanonických ml/min/1,73 m²; prepočet zadaných hodnôt
 * robí server. Tento skript len drží formulár konzistentný pri prepnutí
 * jednotky — prepočíta už zadané čísla a aktualizuje popisky.
 */
(function () {
    'use strict';

    var ML_S = 'ml_s';
    var PER_MINUTE = 60;

    function unitLabel(unit) {
        return unit === ML_S ? 'ml/s/1,73 m²' : 'ml/min/1,73 m²';
    }

    function placeholderFor(input, unit) {
        // data-egfr-placeholder="unit" → v poli je ako nápoveda samotná jednotka.
        if (input.dataset.egfrPlaceholder === 'unit') {
            return unitLabel(unit);
        }
        return unit === ML_S ? 'napr. 0,75' : 'napr. 45,2';
    }

    function parseNumber(raw) {
        var n = parseFloat(String(raw).replace(',', '.').trim());
        return isFinite(n) ? n : null;
    }

    function format(value) {
        // ml/s hodnoty sú malé — nechávame tri desatinné miesta.
        return (Math.round(value * 1000) / 1000).toString().replace('.', ',');
    }

    function scopeOf(select) {
        return select.form || document;
    }

    function apply(select, previousUnit) {
        var unit = select.value;
        var scope = scopeOf(select);
        var factor = unit === ML_S ? 1 / PER_MINUTE : PER_MINUTE;

        if (previousUnit !== unit) {
            scope.querySelectorAll('.js-egfr-value').forEach(function (input) {
                var value = parseNumber(input.value);
                if (value !== null) {
                    input.value = format(value * factor);
                }
            });
        }

        scope.querySelectorAll('.js-egfr-unit-label').forEach(function (el) {
            el.textContent = unitLabel(unit);
        });
        scope.querySelectorAll('.js-egfr-value').forEach(function (input) {
            if (input.placeholder) {
                input.placeholder = placeholderFor(input, unit);
            }
        });
    }

    document.querySelectorAll('select[name="egfr_unit"]').forEach(function (select) {
        var previousUnit = select.value;
        select.addEventListener('change', function () {
            apply(select, previousUnit);
            previousUnit = select.value;
        });
    });
})();
