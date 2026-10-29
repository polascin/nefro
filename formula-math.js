(function () {
  var SELF = document.currentScript;

  var DELIMITERS = [
    { left: '$$', right: '$$', display: true },
    { left: '$', right: '$', display: false },
    { left: '\\(', right: '\\)', display: false },
    { left: '\\[', right: '\\]', display: true },
  ];

  var RENDER_OPTS = {
    delimiters: DELIMITERS,
    throwOnError: false,
    trust: false,
    maxExpand: 1000,
    maxSize: 50,
    ignoredTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code'],
  };

  function needsRender(root) {
    if (!root || root.querySelector('.katex')) {
      return false;
    }
    var text = root.textContent || '';
    return /\\[\[\(]|\$\$?/.test(text);
  }

  function getAvailableWidth(node) {
    return Math.floor(node.clientWidth || node.getBoundingClientRect().width || 0);
  }

  function getRenderedMathWidth(node) {
    var width = 0;

    node.querySelectorAll('.katex').forEach(function (math) {
      var html = math.querySelector('.katex-html') || math;
      width = Math.max(
        width,
        math.scrollWidth || 0,
        html.scrollWidth || 0,
        math.getBoundingClientRect().width || 0,
        html.getBoundingClientRect().width || 0
      );
    });

    return Math.ceil(width);
  }

  function fitFormulaNode(node) {
    if (!node || !node.querySelector('.katex') || !node.getClientRects().length) {
      return;
    }

    node.style.setProperty('--formula-scale', '1');
    node.classList.remove('calc-formula-line--fitted');

    var availableWidth = getAvailableWidth(node);
    var renderedWidth = getRenderedMathWidth(node);
    var targetWidth = Math.max(1, availableWidth - 6);

    if (!availableWidth || !renderedWidth || renderedWidth <= targetWidth) {
      node.removeAttribute('data-formula-scale');
      return;
    }

    var scale = 1;

    for (var i = 0; i < 4; i += 1) {
      scale = Math.max(0.24, Math.min(scale, scale * (targetWidth / renderedWidth)));
      node.style.setProperty('--formula-scale', scale.toFixed(4));
      renderedWidth = getRenderedMathWidth(node);

      if (renderedWidth <= targetWidth || scale <= 0.24) {
        break;
      }
    }

    var scaleValue = scale.toFixed(3);

    node.style.setProperty('--formula-scale', scaleValue);
    node.classList.add('calc-formula-line--fitted');
    node.setAttribute('data-formula-scale', scaleValue);
  }

  function fitCalcFormulas(root) {
    var scope = root || document;
    scope.querySelectorAll('.calc-formula-line, .calc-formula-vars').forEach(fitFormulaNode);
  }

  function scheduleFormulaFit(root) {
    var run = function () {
      fitCalcFormulas(root);
    };

    if (typeof window.requestAnimationFrame === 'function') {
      window.requestAnimationFrame(function () {
        window.requestAnimationFrame(run);
      });
    } else {
      setTimeout(run, 0);
    }
  }

  function renderCalcFormulas(root) {
    if (!root) {
      return;
    }

    if (typeof renderMathInElement === 'function' && needsRender(root)) {
      renderMathInElement(root, RENDER_OPTS);
    }

    scheduleFormulaFit(root);
  }

  function bindFormulaBoxes() {
    document.querySelectorAll('.calc-formula-box').forEach(function (box) {
      renderCalcFormulas(box);

      if (box.matches('details')) {
        box.addEventListener('toggle', function () {
          if (box.open) {
            renderCalcFormulas(box);
          }
        });
      }

      box.querySelectorAll('details').forEach(function (details) {
        details.addEventListener('toggle', function () {
          if (details.open) {
            renderCalcFormulas(details);
          } else {
            scheduleFormulaFit(details);
          }
        });
      });
    });

    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(function () {
        scheduleFormulaFit(document);
      });
    }

    window.addEventListener('resize', function () {
      scheduleFormulaFit(document);
    });
  }

  function waitForKatex(attempt) {
    if (typeof renderMathInElement === 'function') {
      bindFormulaBoxes();
      return;
    }
    if (attempt >= 40) {
      return;
    }
    setTimeout(function () {
      waitForKatex(attempt + 1);
    }, 50);
  }

  // Hosting (OpenResty na WebSupporte) občas odmietne požiadavku s 429.
  // Skript sa preto po chvíli skúsi načítať znova, inak by vzorce ostali surové.
  function loadScript(src, onload, attempt) {
    var script = document.createElement('script');
    script.src = src;
    script.onload = onload;
    script.onerror = function () {
      script.remove();
      if ((attempt || 0) < 2) {
        setTimeout(function () {
          loadScript(src, onload, (attempt || 0) + 1);
        }, 4000 * ((attempt || 0) + 1));
      }
    };
    document.head.appendChild(script);
  }

  // KaTeX sa sťahuje až tu, nie v <head>: väčšina stránok žiadny vzorec nemá
  // a tri požiadavky navyše sa počítajú do limitu OpenResty na WebSupporte
  // (429 Too Many Requests). Adresy súborov nesie data-katex-* na vlastnom
  // <script> tagu (pozri head_meta.php).
  function ensureKatex(done) {
    if (typeof renderMathInElement === 'function') {
      done();
      return;
    }
    if (!SELF) {
      return;
    }
    var css = SELF.getAttribute('data-katex-css');
    var js = SELF.getAttribute('data-katex-js');
    var autoRender = SELF.getAttribute('data-katex-autorender');
    if (!css || !js || !autoRender) {
      return;
    }
    if (!document.querySelector('link[data-katex-css]')) {
      var link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = css;
      link.setAttribute('data-katex-css', '');
      document.head.appendChild(link);
    }
    loadScript(js, function () {
      loadScript(autoRender, done);
    });
  }

  function init() {
    if (!document.querySelector('.calc-formula-box')) {
      return;
    }
    ensureKatex(function () {
      waitForKatex(0);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
