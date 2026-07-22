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

function makeContext({ localValue = null, cookieValue = null, gpc = false } = {}) {
    const storage = new Map();
    if (localValue !== null) storage.set(key, localValue);
    const cookies = new Map();
    if (cookieValue !== null) cookies.set(key, encodeURIComponent(cookieValue));

    const localStorage = {
        getItem: name => storage.has(name) ? storage.get(name) : null,
        setItem: (name, value) => storage.set(name, String(value)),
        removeItem: name => storage.delete(name),
    };
    const document = {
        readyState: 'loading',
        addEventListener() {},
        createElement() { return {}; },
        head: { appendChild() {} },
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
        location: { pathname: '/index.php', search: '', protocol: 'https:', hostname: 'nefro.polascin.net' },
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
    });
    vm.runInContext(source, context, { filename: 'ui-preferences.js' });
    return { context, storage, cookies };
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

console.log('ui-preferences: všetky testy prešli');
