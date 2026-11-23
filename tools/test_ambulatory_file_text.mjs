// Izolovaná regresia: text zo súboru (PDF, TXT) v Ambulantnej kalkulačke nesmie do poľa
// odosielaného na server preniesť riadky s rodným číslom a označenými osobnými údajmi.
// Vykonáva úsek calculator_ambulatory.js medzi značkami labs-file-text bez prehliadača
// a bez pdf.js; všetky údaje sú syntetické.
import assert from 'node:assert/strict';
import fs from 'node:fs';
import path from 'node:path';
import vm from 'node:vm';
import {fileURLToPath} from 'node:url';

const root = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const source = fs.readFileSync(path.join(root, 'calculator_ambulatory.js'), 'utf8');
const segment = source.match(/\/\/ labs-file-text:start[^\n]*\n([\s\S]+?)\/\/ labs-file-text:end/);
assert.ok(segment, 'úsek labs-file-text sa musí dať nájsť v calculator_ambulatory.js');

const sandbox = {};
vm.runInNewContext(`${segment[1]}\nthis.api = {stripIdentityLines, pdfRows, pdfPageText};`, sandbox);
const {stripIdentityLines, pdfRows, pdfPageText} = sandbox.api;
let checks = 0;
const same = (actual, expected, message) => {
    assert.deepEqual(JSON.parse(JSON.stringify(actual)), expected, message);
    checks++;
};

// 1. Textový výpis: riadky s osobnými údajmi sa vynechajú, dátum odberu a výsledky ostanú.
const txt = stripIdentityLines([
    'Pacient: Testovací Pacient   RČ: 650615/1234',
    'Meno a priezvisko: Testovacia Osoba',
    'Rodné číslo: 7001019999 ZP:24 Odber: 07.09.2026',
    'Bydlisko: Skúšobná 1, Mesto',
    'Poisťovňa: 24',
    'Dátum nar.: 15.06.1965',
    'S-Kreatinín   412   umol/l  (62 - 106)   H',
    'S-Urea        18,4  mmol/l  (2,8 - 8,1)  H',
]);
same(txt.removed, 6, 'počet vynechaných riadkov');
same(txt.lines, [
    'Odber: 07.09.2026',
    'S-Kreatinín   412   umol/l  (62 - 106)   H',
    'S-Urea        18,4  mmol/l  (2,8 - 8,1)  H',
], 'z výpisu ostanú len výsledky a dátum odberu');

// 2. Laboratórne riadky sa nesmú stratiť (falošné poplachy).
const labs = [
    'S_Kreatinín 105 + 44 - 80 umol/l',
    'U_Albumín/kreatinín 12,5 0 - 3 mg/mmol',
    'B_HbA1c (IFCC) 48 20 - 42 mmol/mol',
    'Telefonicky hlásené: nie',
    'WBC 6,12 4,00 - 10,00 10^9/l',
    '08.11.2026',
    'Parathormón intaktný 123456 pg/l',
];
same(stripIdentityLines(labs), {lines: labs, removed: 0}, 'laboratórne riadky ostanú bez zmeny');

// 3. Rodné číslo s lomkou sa rozpozná aj bez označenia, dlhšie číslo nie.
same(stripIdentityLines(['Testovacia Osoba 700101 / 9999']).removed, 1, 'rodné číslo s lomkou');
same(stripIdentityLines(['Vzorka 1234567/1234567']).removed, 0, 'dlhšie číslo nie je rodné číslo');

const item = (str, x, y) => ({str, transform: [8, 0, 0, 8, x, y], height: 8});

// 4. Výsledkový list Synlab: hlavička s pacientom sa vynechá, stĺpce idú za sebou, päta končí výpis.
const synlab = [
    item('Testovacia Osoba', 40, 780), item('Rodné číslo: 7001019999', 300, 780),
    item('Odber: 07.09.2026', 40, 765),
    item('Názov metódy', 40, 740), item('Výsledky', 150, 740), item('Názov metódy', 320, 740), item('Výsledky', 430, 740),
    item('S_Kreatinín', 40, 725), item('105', 150, 725), item('S_Urea', 320, 725), item('7,1', 430, 725),
    item('S_Draslík', 40, 710), item('4,6', 150, 710),
    item('Uvedené výsledky sa týkajú len vzorky', 40, 690),
    item('Testovacia Osoba, Skúšobná 1', 40, 675),
];
const state = {date: null, unrecognized: false, removed: 0};
same(pdfPageText(pdfRows(synlab), state), ['S_Kreatinín 105', 'S_Draslík 4,6', 'S_Urea 7,1'], 'tabuľka Synlab bez hlavičky a päty');
same(state, {date: '07.09.2026', unrecognized: false, removed: 0}, 'dátum odberu z hlavičky Synlab');

// 5. Strana bez hlavičky tabuľky: označené osobné údaje sa vynechajú a stav to oznámi.
const other = [
    item('Pacient: Testovacia Osoba', 40, 780), item('RČ: 700101/9999', 300, 780),
    item('Adresa: Skúšobná 1', 40, 765),
    item('Kreatinín', 40, 740), item('105 umol/l', 150, 740),
];
const otherState = {date: null, unrecognized: false, removed: 0};
same(pdfPageText(pdfRows(other), otherState), ['Kreatinín 105 umol/l'], 'neznáme rozloženie bez riadkov s osobnými údajmi');
same(otherState, {date: null, unrecognized: true, removed: 2}, 'neznáme rozloženie sa oznámi používateľovi');

// 6. Oba vstupy zo súboru musia filtrom prejsť a nápoveda nesmie sľubovať viac, než kód robí.
assert.match(source, /stripIdentityLines\(decoded\.text/, 'text zo súboru TXT musí prejsť filtrom osobných údajov');
assert.match(source, /result\.unrecognized\s*\?/, 'nerozpoznané PDF musí používateľa vyzvať na kontrolu');
const page = fs.readFileSync(path.join(root, 'calculator_ambulatory.php'), 'utf8');
assert.ok(!page.includes('vloží len text výsledkov bez hlavičky s menom a rodným číslom.<'), 'nápoveda nesmie sľubovať vynechanie hlavičky pri každom súbore');
assert.ok(page.includes('Text pred odoslaním skontrolujte.'), 'nápoveda musí vyzvať na kontrolu textu');
checks += 4;

console.log(`Ambulantná kalkulačka, text zo súboru: ${checks} PASS`);
