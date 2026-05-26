(function () {
  var DELIMITERS = [
    { left: '$$', right: '$$', display: true },
    { left: '$', right: '$', display: false },
    { left: '\\(', right: '\\)', display: false },
    { left: '\\[', right: '\\]', display: true },
  ];

  var RENDER_OPTS = {
    delimiters: DELIMITERS,
    throwOnError: false,
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

  function init() {
    waitForKatex(0);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
