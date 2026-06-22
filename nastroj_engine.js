/*
 * nastroj_engine.js — Znovupoužiteľný engine rozhodovacieho stromu pre
 * interaktívne nefrologické nástroje (AKI, hyponatrémia, hypokaliémia …).
 *
 * Použitie: na stránku načítajte tento súbor a potom dátový súbor nástroja,
 * ktorý zavolá window.NefroDecisionTree(mountEl, tree).
 *
 * Tvar stromu:
 *   {
 *     start: 'id',
 *     outcomeNote: 'Voliteľná poznámka pod každým záverom.',
 *     nodes: {
 *       id: {
 *         id, kind: 'q', step, title, body:[...], bullets:[...], prompt,
 *         options: [{ label, hint?, next }]
 *       },
 *       id2: {
 *         id, kind: 'r', severity: 'info'|'warn'|'urgent',
 *         category, summary,
 *         sections: [{ heading, items:[...] }],
 *         links: [{ href, label, external? }],
 *         note?  // prepíše tree.outcomeNote pre tento uzol
 *       }
 *     }
 *   }
 *
 * Bez inline štýlov (CSP style-src 'self') — všetko cez triedy v index.css.
 * Bez závislostí, vanilla JS.
 */
(function () {
    'use strict';

    var DEFAULT_NOTE = 'Záver je orientačný a vychádza zo zadaných odpovedí. '
        + 'Vždy posúďte celkový klinický kontext a laboratórium.';

    /**
     * Vytvorí inštanciu rozhodovacieho stromu nad daným kontajnerom.
     * @param {HTMLElement} mount  Kontajner, do ktorého sa vykresľuje.
     * @param {Object} tree        { start, nodes, outcomeNote? }
     */
    function NefroDecisionTree(mount, tree) {
        var historyStack = [];
        var current = tree.start;
        var outcomeNote = tree.outcomeNote || DEFAULT_NOTE;

        function el(tag, className, text) {
            var node = document.createElement(tag);
            if (className) { node.className = className; }
            if (text != null) { node.textContent = text; }
            return node;
        }

        function appendParagraphs(parent, arr) {
            (arr || []).forEach(function (p) {
                parent.appendChild(el('p', 'tool-step__text', p));
            });
        }

        function appendBullets(parent, arr) {
            if (!arr || !arr.length) { return; }
            var ul = el('ul', 'tool-step__list');
            arr.forEach(function (li) {
                ul.appendChild(el('li', null, li));
            });
            parent.appendChild(ul);
        }

        function renderTrail() {
            if (!historyStack.length) { return null; }
            var nav = el('nav', 'tool-trail');
            nav.setAttribute('aria-label', 'Prejdené kroky');
            var ol = el('ol', 'tool-trail__list');
            historyStack.forEach(function (entry) {
                ol.appendChild(el('li', 'tool-trail__item', entry.choice));
            });
            nav.appendChild(ol);
            return nav;
        }

        function makeControls() {
            var wrap = el('div', 'tool-controls no-print');
            if (historyStack.length) {
                var back = el('button', 'btn-secondary tool-btn-back', '← Späť');
                back.type = 'button';
                back.addEventListener('click', function () {
                    var prev = historyStack.pop();
                    current = prev.from;
                    render();
                });
                wrap.appendChild(back);

                var restart = el('button', 'btn-secondary tool-btn-restart', '↺ Začať znova');
                restart.type = 'button';
                restart.addEventListener('click', function () {
                    historyStack = [];
                    current = tree.start;
                    render();
                });
                wrap.appendChild(restart);
            }
            return wrap;
        }

        function renderQuestion(node, container) {
            if (node.step) {
                container.appendChild(el('p', 'tool-step__kicker', node.step));
            }
            var h = el('h3', 'tool-step__title', node.title);
            h.setAttribute('tabindex', '-1');
            container.appendChild(h);

            appendParagraphs(container, node.body);
            appendBullets(container, node.bullets);

            if (node.prompt) {
                container.appendChild(el('p', 'tool-step__prompt', node.prompt));
            }

            var opts = el('div', 'tool-options');
            opts.setAttribute('role', 'group');
            opts.setAttribute('aria-label', node.prompt || node.title);
            node.options.forEach(function (opt) {
                var btn = el('button', 'tool-option');
                btn.type = 'button';
                btn.appendChild(el('span', 'tool-option__label', opt.label));
                if (opt.hint) {
                    btn.appendChild(el('span', 'tool-option__hint', opt.hint));
                }
                btn.addEventListener('click', function () {
                    historyStack.push({ from: node.id, choice: opt.label });
                    current = opt.next;
                    render();
                });
                opts.appendChild(btn);
            });
            container.appendChild(opts);
            return h;
        }

        function renderOutcome(node, container) {
            var sev = node.severity || 'info';
            var banner = el('div', 'tool-outcome tool-outcome--' + sev);

            var badgeText = sev === 'urgent' ? 'Naliehavé'
                : (sev === 'warn' ? 'Pozor' : 'Pravdepodobná kategória');
            banner.appendChild(el('span', 'tool-outcome__badge', badgeText));
            var h = el('h3', 'tool-outcome__title', node.category);
            h.setAttribute('tabindex', '-1');
            banner.appendChild(h);
            if (node.summary) {
                banner.appendChild(el('p', 'tool-outcome__summary', node.summary));
            }
            container.appendChild(banner);

            (node.sections || []).forEach(function (sec) {
                var block = el('div', 'tool-result-section');
                block.appendChild(el('h4', 'tool-result-section__heading', sec.heading));
                appendBullets(block, sec.items);
                container.appendChild(block);
            });

            if (node.links && node.links.length) {
                var linkWrap = el('div', 'tool-result-links no-print');
                linkWrap.appendChild(el('h4', 'tool-result-section__heading', 'Súvisiace nástroje a články'));
                var lul = el('ul', 'tool-step__list');
                node.links.forEach(function (lnk) {
                    var li = el('li');
                    var a = el('a', 'tool-result-link', lnk.label);
                    a.href = lnk.href;
                    if (lnk.external) {
                        a.target = '_blank';
                        a.rel = 'noopener noreferrer';
                    }
                    li.appendChild(a);
                    lul.appendChild(li);
                });
                linkWrap.appendChild(lul);
                container.appendChild(linkWrap);
            }

            container.appendChild(el('p', 'tool-outcome__note', node.note || outcomeNote));
            return h;
        }

        function render() {
            var node = tree.nodes[current];
            mount.innerHTML = '';
            if (!node) { return; }

            var trail = renderTrail();
            if (trail) { mount.appendChild(trail); }

            var container = el('div', 'tool-step');
            var heading;
            if (node.kind === 'r') {
                heading = renderOutcome(node, container);
            } else {
                heading = renderQuestion(node, container);
            }
            mount.appendChild(container);
            mount.appendChild(makeControls());

            // Presun fokus na nadpis kroku (nie pri prvom načítaní)
            if (historyStack.length && heading && typeof heading.focus === 'function') {
                heading.focus();
            }
        }

        render();
    }

    /**
     * Pomocník: po načítaní DOM napojí strom na element s daným id (ak existuje).
     * @param {string} mountId
     * @param {Object} tree
     */
    NefroDecisionTree.mount = function (mountId, tree) {
        function init() {
            var m = document.getElementById(mountId);
            if (m) { NefroDecisionTree(m, tree); }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    };

    window.NefroDecisionTree = NefroDecisionTree;
})();
