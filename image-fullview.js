/**
 * image-fullview.js
 * Klik na obsahový obrázok otvorí jeho plnú veľkosť v novom tabe/okne —
 * rovnako ako v sekcii „Náhodný obrázok“. Obsahové <img> v <main> sa obalia
 * do <a target="_blank">, ak už nie sú v odkaze alebo tlačidle.
 */
(function () {
  'use strict';

  function wrap(img) {
    if (!img || img.dataset.fullview === '1') { return; }
    // Preskoč obrázky, ktoré sú už klikateľné (karty, náhodný obrázok, logo…).
    if (img.closest('a, button')) { return; }
    var src = img.currentSrc || img.getAttribute('src');
    if (!src || src.indexOf('data:') === 0) { return; }

    var link = document.createElement('a');
    link.href = src;
    link.target = '_blank';
    link.rel = 'noopener noreferrer';
    link.title = 'Zobraziť obrázok v plnej veľkosti';
    link.className = 'img-fullview-link';

    img.dataset.fullview = '1';
    img.parentNode.insertBefore(link, img);
    link.appendChild(img);
  }

  function init() {
    var imgs = document.querySelectorAll('main img');
    for (var i = 0; i < imgs.length; i++) {
      wrap(imgs[i]);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
