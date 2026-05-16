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

  function renderCalcFormulas(root) {
    if (typeof renderMathInElement !== 'function' || !root || !needsRender(root)) {
      return;
    }
    renderMathInElement(root, RENDER_OPTS);
  }

  function bindFormulaBoxes() {
    document.querySelectorAll('.calc-formula-box').forEach(function (box) {
      renderCalcFormulas(box);

      box.querySelectorAll('details').forEach(function (details) {
        details.addEventListener('toggle', function () {
          if (details.open) {
            renderCalcFormulas(details);
          }
        });
      });
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
