(function () {
  var DELIMITERS = [
    { left: '$$', right: '$$', display: true },
    { left: '$', right: '$', display: false },
    { left: '\\(', right: '\\)', display: false },
    { left: '\\[', right: '\\]', display: true },
  ];

  function renderCalcFormulas(root) {
    if (typeof renderMathInElement !== 'function' || !root) {
      return;
    }
    renderMathInElement(root, {
      delimiters: DELIMITERS,
      throwOnError: false,
      ignoredTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code'],
    });
  }

  function init() {
    document.querySelectorAll('.calc-formula-box').forEach(function (box) {
      renderCalcFormulas(box);
    });
    document.querySelectorAll('details.calc-formula-box').forEach(function (details) {
      details.addEventListener('toggle', function () {
        if (details.open) {
          renderCalcFormulas(details);
        }
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
