/**
 * nefro-ui.js — Centralizované UI správanie bez inline handlerv
 * Nefro-projekt Slovensko
 */
'use strict';

// ── 1. Confirm dialógy (náhrada onsubmit="return confirm(...)") ────────────────
document.addEventListener('submit', function (e) {
    var form = e.target.closest('form[data-confirm]');
    if (!form) return;
    if (!window.confirm(form.dataset.confirm)) {
        e.preventDefault();
    }
}, { capture: true });

// ── 2. Print tlačidlá (náhrada onclick="window.print()") ─────────────────────
document.addEventListener('click', function (e) {
    if (e.target.closest('.js-print')) {
        window.print();
    }
});

// ── 3. Toggle visibility na základe select hodnoty (data-toggle-target) ───────
function applyToggleTargets() {
    document.querySelectorAll('[data-toggle-target]').forEach(function (sel) {
        var target = document.getElementById(sel.dataset.toggleTarget);
        if (!target) return;
        target.classList.toggle('d-none', sel.value !== (sel.dataset.toggleValue || '1'));
    });
}
document.addEventListener('change', function (e) {
    var sel = e.target;
    if (!sel.dataset || !sel.dataset.toggleTarget) return;
    var target = document.getElementById(sel.dataset.toggleTarget);
    if (target) {
        target.classList.toggle('d-none', sel.value !== (sel.dataset.toggleValue || '1'));
    }
});

// ── 4. Avatar preview pre register.php (bez PHP hodnôt) ───────────────────────
(function () {
    var preview = document.getElementById('avatarPreview');
    var input   = document.getElementById('avatar');
    // Aktivovať len na register.php (preview nemá data-original-src)
    if (!preview || !input || preview.hasAttribute('data-original-src')) return;

    function updateDefaultAvatar() {
        if (!input.files || !input.files[0]) {
            var theme = document.documentElement.getAttribute('data-theme') || 'light';
            preview.src = theme === 'dark'
                ? 'img/default-avatar-dark.svg'
                : 'img/default-avatar-light.svg';
        }
    }

    input.addEventListener('change', function () {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) { preview.src = e.target.result; };
            reader.readAsDataURL(input.files[0]);
        } else {
            updateDefaultAvatar();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        updateDefaultAvatar();
        new MutationObserver(function (mutations) {
            mutations.forEach(function (m) {
                if (m.attributeName === 'data-theme') updateDefaultAvatar();
            });
        }).observe(document.documentElement, { attributes: true });
    });
})();

// ── 5. Auto-print pre výsledkové stránky (data-auto-print="1" na <body>) ─────
(function () {
    if (document.body && document.body.dataset.autoPrint === '1'
            && !document.querySelector('.alert-error')) {
        window.addEventListener('load', function () { window.print(); });
    }
})();

// ── DOMContentLoaded sekcia ───────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

    // Inicializácia toggle targets (select-controlled visibility)
    applyToggleTargets();

    // ── 6. Password toggle ────────────────────────────────────────────────────
    var passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(function (input, index) {
        if (input.dataset.passwordToggleReady === 'true') return;

        var wrapper = document.createElement('div');
        wrapper.className = 'password-toggle';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        var toggleButton = document.createElement('button');
        toggleButton.type = 'button';
        toggleButton.className = 'password-toggle__button';
        if (!input.id) {
            input.id = 'password-field-' + (index + 1);
        }
        toggleButton.setAttribute('aria-controls', input.id);
        toggleButton.setAttribute('aria-label', 'Zobraziť heslo');
        toggleButton.setAttribute('aria-pressed', 'false');
        toggleButton.textContent = 'Zobraziť';

        toggleButton.addEventListener('click', function () {
            var isVisible = input.type === 'text';
            input.type = isVisible ? 'password' : 'text';
            toggleButton.textContent = isVisible ? 'Zobraziť' : 'Skryť';
            toggleButton.setAttribute('aria-label', isVisible ? 'Zobraziť heslo' : 'Skryť heslo');
            toggleButton.setAttribute('aria-pressed', isVisible ? 'false' : 'true');
        });

        wrapper.appendChild(toggleButton);
        input.dataset.passwordToggleReady = 'true';
    });

    // ── 7. Back-to-top tlačidlo ───────────────────────────────────────────────
    var backToTopBtn = document.getElementById('backToTop');
    if (backToTopBtn) {
        window.addEventListener('scroll', function () {
            backToTopBtn.classList.toggle('is-visible', window.scrollY > 400);
        });
        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ── 8. Hamburger menu ─────────────────────────────────────────────────────
    var menuBtn = document.getElementById('menuToggle');
    var mainNav = document.querySelector('.main-nav ul');
    if (menuBtn && mainNav) {
        menuBtn.addEventListener('click', function () {
            var open = mainNav.classList.toggle('is-open');
            menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    // ── 9. Validácia zhody hesiel (reset_password.php) ────────────────────────
    var resetForm    = document.querySelector('form[action="reset_password.php"]');
    var newPass      = document.getElementById('new_password');
    var newPassConf  = document.getElementById('new_password_confirm');
    if (resetForm && newPass && newPassConf) {
        var validatePasswords = function () {
            var same = newPass.value === newPassConf.value;
            newPassConf.setCustomValidity(same ? '' : 'Heslá sa nezhodujú.');
        };
        newPass.addEventListener('input', validatePasswords);
        newPassConf.addEventListener('input', validatePasswords);
        resetForm.addEventListener('submit', validatePasswords);
    }

    // ── 10. Slug generator + SEO counter (admin_articles.php) ─────────────────
    var titleInput   = document.getElementById('f_title');
    var slugInput    = document.getElementById('f_slug');
    var excerptInput = document.getElementById('f_excerpt');
    if (titleInput && slugInput) {
        var diacriticsMap = {
            'á':'a','ä':'a','č':'c','ď':'d','é':'e','í':'i','ĺ':'l','ľ':'l',
            'ň':'n','ó':'o','ô':'o','ŕ':'r','š':'s','ť':'t','ú':'u','ý':'y','ž':'z'
        };
        titleInput.addEventListener('input', function () {
            if (slugInput.dataset.manualEdit === 'true') return;
            var s = titleInput.value.toLowerCase();
            s = s.replace(/[áäčďéíĺľňóôŕšťúýž]/g, function (c) { return diacriticsMap[c] || c; });
            s = s.replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            slugInput.value = s.substring(0, 200);
        });
        slugInput.addEventListener('input', function () {
            slugInput.dataset.manualEdit = slugInput.value.length > 0 ? 'true' : 'false';
        });
        if (excerptInput) {
            var counter = document.createElement('span');
            counter.className = 'helper-text';
            excerptInput.insertAdjacentElement('afterend', counter);
            var updateCounter = function () {
                var len = excerptInput.value.trim().length;
                var ok  = len >= 120 && len <= 220;
                counter.textContent = 'Dĺžka perexu: ' + len + ' znakov'
                    + (ok ? ' (odporúčané rozmedzie)' : ' (mimo odporúčaného rozmedzia 120-220)');
            };
            excerptInput.addEventListener('input', updateCounter);
            updateCounter();
        }
    }

});
