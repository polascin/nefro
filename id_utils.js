/**
 * id_utils.js
 * Spoločná utilita pre prácu s rodným číslom (RČ).
 * Poskytuje funkciu na parsovanie RČ a extrakciu dátumu narodenia, veku a pohlavia.
 */
'use strict';

(function (window) {
    if (!window.Utils) {
        window.Utils = {};
    }

    /**
     * Parsovanie slovenského/českého rodného čísla.
     * @param {string} rc - Rodné číslo (9 alebo 10 číslic, môže obsahovať medzery alebo lomku).
     * @returns {object|null} Objekt s dátami { date: 'YYYY-MM-DD', age: number, sex: 'male'|'female' } alebo null pri neplatnom vstupe.
     */
    function parseBirthNumber(rc) {
        if (typeof rc !== 'string') return null;
        const cleanRc = rc.replace(/[\s/]/g, '');
        if (!/^\d{9,10}$/.test(cleanRc)) {
            return null;
        }

        let yy = parseInt(cleanRc.substring(0, 2), 10);
        let mm = parseInt(cleanRc.substring(2, 4), 10);
        let dd = parseInt(cleanRc.substring(4, 6), 10);

        const isFemale = mm > 50;
        const sex = isFemale ? 'female' : 'male';

        // Korekcia mesiaca: ženy +50, cudzinci +20 alebo +70
        if (mm > 70)      mm -= 70;
        else if (mm > 50) mm -= 50;
        else if (mm > 20) mm -= 20;

        // Storočie: dynamicky podľa aktuálneho roka
        const currentYear = new Date().getFullYear();
        let year;
        if (cleanRc.length === 9) {
            // 9-miestne RČ boli vydávané do roku 1953
            year = (yy > (currentYear % 100)) ? 1900 + yy : 2000 + yy;
            if (yy > 53) year = 1800 + yy;
            if (yy <= 53) year = 1900 + yy;
        } else {
            year = (2000 + yy <= currentYear + 1) ? 2000 + yy : 1900 + yy;
        }

        if (mm < 1 || mm > 12 || dd < 1 || dd > 31) return null;

        const birthDateStr = year.toString().padStart(4, '0') + '-' + mm.toString().padStart(2, '0') + '-' + dd.toString().padStart(2, '0');
        const birthDate = new Date(birthDateStr);
        if (birthDate.getFullYear() !== year || birthDate.getMonth() + 1 !== mm || birthDate.getDate() !== dd) return null;

        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;

        if (age < 0 || age > 130) return null;

        return { date: birthDateStr, age: age, sex: sex };
    }

    window.Utils.parseBirthNumber = parseBirthNumber;

})(window);