import assert from 'node:assert/strict';
import fs from 'node:fs';
import vm from 'node:vm';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

const root = path.dirname(path.dirname(fileURLToPath(import.meta.url)));
const source = fs.readFileSync(path.join(root, 'ui-preferences.js'), 'utf8');
const key = 'nps_cookie_consent';
// Verziu odvádzame priamo zo zdroja, aby test nikdy nedivergoval od `consentVersion`
// v ui-preferences.js (a nepriamo od legal_data.php, s ktorou sa musí zhodovať).
const version = (source.match(/const consentVersion = '([^']+)'/) || [])[1];
assert.ok(version, 'consentVersion sa musí dať prečítať z ui-preferences.js');

function validConsent(timestamp = new Date().toISOString()) {
    return { necessary: true, analytics: true, marketing: true, preferences: false, timestamp, version };
}

function makeContext({
    localValue = null,
    cookieValue = null,
    gpc = false,
    pathname = '/index.php',
    search = '',
} = {}) {
    const storage = new Map();
    if (localValue !== null) storage.set(key, localValue);
    const cookies = new Map();
    if (cookieValue !== null) cookies.set(key, encodeURIComponent(cookieValue));
    const appendedScripts = [];

    const localStorage = {
        getItem: name => storage.has(name) ? storage.get(name) : null,
        setItem: (name, value) => storage.set(name, String(value)),
        removeItem: name => storage.delete(name),
    };
    const document = {
        readyState: 'loading',
        addEventListener() {},
        createElement() { return {}; },
        head: { appendChild(element) { appendedScripts.push(element.src ?? ''); } },
    };
    Object.defineProperty(document, 'cookie', {
        get() {
            return [...cookies.entries()].map(([name, value]) => `${name}=${value}`).join('; ');
        },
        set(value) {
            const [pair, ...attributes] = String(value).split(';');
            const separator = pair.indexOf('=');
            const name = pair.slice(0, separator).trim();
            const encoded = pair.slice(separator + 1);
            if (attributes.some(attribute => attribute.trim().toLowerCase() === 'max-age=0')) {
                cookies.delete(name);
            } else {
                cookies.set(name, encoded);
            }
        },
    });

    const window = {
        location: { pathname, search, protocol: 'https:', hostname: 'nefro.polascin.net' },
        dataLayer: [],
        addEventListener() {},
    };
    const context = vm.createContext({
        window,
        document,
        localStorage,
        navigator: { globalPrivacyControl: gpc },
        URLSearchParams,
        console: { warn() {}, error() {}, log() {} },
        setTimeout,
        clearTimeout,
        gtag(...args) { window.dataLayer.push(args); },
    });
    vm.runInContext(source, context, { filename: 'ui-preferences.js' });
    return { context, storage, cookies, appendedScripts };
}

function read(context) {
    return vm.runInContext('readStoredConsentSync()', context);
}

{
    const payload = validConsent();
    const { context } = makeContext({ localValue: JSON.stringify(payload) });
    assert.equal(read(context).analytics, true, 'platný súhlas sa musí načítať');
}

for (const payload of [
    validConsent(new Date(Date.now() - 366 * 86400000).toISOString()),
    validConsent('nie-je-dátum'),
    { ...validConsent(), version: '2026-01-01' },
    validConsent(new Date(Date.now() + 6 * 60000).toISOString()),
    { ...validConsent(), analytics: 'yes' },
]) {
    const { context, storage } = makeContext({ localValue: JSON.stringify(payload) });
    assert.equal(read(context), null, 'neplatný alebo expirovaný súhlas sa musí odmietnuť');
    assert.equal(storage.has(key), false, 'neplatný localStorage záznam sa musí odstrániť');
}

{
    const payload = validConsent();
    const { context } = makeContext({ localValue: '{', cookieValue: JSON.stringify(payload) });
    assert.equal(read(context).analytics, true, 'platný cookie fallback sa musí použiť');
}

{
    const payload = validConsent();
    const { context } = makeContext({ localValue: JSON.stringify(payload), gpc: true });
    const consent = read(context);
    assert.equal(consent.analytics, true, 'GPC nemení analytický súhlas');
    assert.equal(consent.marketing, false, 'GPC musí vynútiť vypnutý marketing');
}

for (const pathname of [
    '/calculator_history.php',
    '/calculator_result_print.php',
    '/profile_export.php',
]) {
    const payload = validConsent();
    const { context, appendedScripts } = makeContext({
        localValue: JSON.stringify(payload),
        pathname,
    });
    assert.equal(
        vm.runInContext('analyticsSuppressedForPage', context),
        true,
        `analytika musí byť potlačená na ${pathname}`,
    );
    assert.equal(appendedScripts.length, 0, `GA skript sa nesmie načítať na ${pathname}`);
}

for (const search of [
    '?result_id=123',
    '?load_id=123',
    '?compare=1%2C2',
    '?patient_id=abc',
    '?user_email=user%40example.test',
    '?reset-token=secret',
]) {
    const payload = validConsent();
    const { context, appendedScripts } = makeContext({
        localValue: JSON.stringify(payload),
        pathname: '/calculator_ckdpc.php',
        search,
    });
    assert.equal(
        vm.runInContext('analyticsSuppressedForPage', context),
        true,
        `analytika musí byť potlačená pre citlivé query ${search}`,
    );
    assert.equal(appendedScripts.length, 0, `GA skript sa nesmie načítať pre ${search}`);
}

{
    const payload = validConsent();
    const { context, appendedScripts } = makeContext({
        localValue: JSON.stringify(payload),
        pathname: '/calculator_ckdpc.php',
        search: '?calc=egfr&sort=desc',
    });
    assert.equal(
        vm.runInContext('analyticsSuppressedForPage', context),
        false,
        'bežné query parametre nesmú potlačiť analytiku',
    );
    assert.deepEqual(
        appendedScripts,
        ['https://www.googletagmanager.com/gtag/js?id=G-0JT5VMQ61K'],
        'po platnom analytickom súhlase sa GA na bežnej URL načíta',
    );
}

console.log('ui-preferences: všetky testy prešli');
