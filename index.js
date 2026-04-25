/**
 * Automaticky spočíta obrázky s danou štruktúrou a zobrazí jeden náhodný.
 * @param {string} nameStructure - Štruktúra názvu súboru (napr. 'kdigockd2024_{n}.png'). Značka '{n}' bude nahradená číslom.
 * @param {string} elementId - ID elementu <img>, do ktorého sa má obrázok načítať.
 */
function displayRandomImage(nameStructure, elementId) {
    let count = 0;
    
    function checkNext() {
        const img = new Image();
        const testPath = './img/' + nameStructure.replace('{n}', count);
        
        // Ak sa obrázok načíta, znamená to, že existuje
        img.onload = function() {
            count++;
            checkNext(); // Skontroluj existenciu ďalšieho obrázka v poradí
        };
        
        // Ak nastane chyba (404), znamená to, že sme našli koniec radu a vieme konečný počet
        img.onerror = function() {
            if (count > 0) {
                // Vygenerovanie náhodného čísla n = od 0 po počet obrázkov - 1
                const randomIndex = Math.floor(Math.random() * count);
                const finalPath = './img/' + nameStructure.replace('{n}', randomIndex);
                
                // Zobrazenie vybraného náhodného obrázku v DOM
                const element = document.getElementById(elementId);
                if (element) {
                    element.src = finalPath;
                } else {
                    console.error("Element s ID '" + elementId + "' nebol nájdený.");
                }
            } else {
                console.warn("V priečinku ./img sa nenašli žiadne obrázky vyhovujúce štruktúre " + nameStructure);
            }
        };
        
        // Priradením `src` sa spustí sťahovanie/kontrola obrázka (vyvolá buď onload alebo onerror)
        img.src = testPath;
    }
    
    // Spustenie hľadania obrázkov začínajúc od nuly
    checkNext();
}
