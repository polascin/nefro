/**
 * Automatické doplnenie PSČ, okresu a kraja po výbere obce z datalistu.
 * Funguje na stránkach register.php a profile.php.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const cityInput    = document.getElementById('city');
        const zipInput     = document.getElementById('zip_code');
        const districtInput = document.getElementById('district');
        const regionInput  = document.getElementById('region');
        const cityDatalist = document.getElementById('city_list');

        if (!cityInput || !cityDatalist) return;

        // Zostavíme mapu: názov obce → {zip, district, region}
        const municipalityMap = {};
        Array.from(cityDatalist.options).forEach(function (opt) {
            const name = opt.value.trim();
            if (name) {
                municipalityMap[name.toLowerCase()] = {
                    zip:      opt.dataset.zip      || '',
                    district: opt.dataset.district || '',
                    region:   opt.dataset.region   || '',
                };
            }
        });

        // Pomocná funkcia — doplní pole len ak je prázdne alebo má rovnakú hodnotu
        function fillIfEmpty(input, value) {
            if (!input) return;
            if (input.value.trim() === '' || input.dataset.autofilled === '1') {
                input.value = value;
                input.dataset.autofilled = value !== '' ? '1' : '0';
            }
        }

        cityInput.addEventListener('change', function () {
            const key  = cityInput.value.trim().toLowerCase();
            const data = municipalityMap[key];
            if (!data) return;

            if (zipInput)      fillIfEmpty(zipInput, data.zip);
            if (districtInput) fillIfEmpty(districtInput, data.district);
            if (regionInput)   fillIfEmpty(regionInput, data.region);
        });

        // Ak používateľ ručne edituje PSČ/okres/kraj, zrušíme autofill príznak
        [zipInput, districtInput, regionInput].forEach(function (inp) {
            if (!inp) return;
            inp.addEventListener('input', function () {
                inp.dataset.autofilled = '0';
            });
        });
    });
})();
