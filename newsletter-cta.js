/*
 * newsletter-cta.js
 * Spoločná logika pre inline odberové formuláre (trieda .newsletter-cta__form).
 * Auto-inicializuje všetky takéto formuláre na stránke. Stavovú správu hľadá
 * v najbližšom rodičovi cez [role="status"], takže nevyžaduje pevné ID.
 */
(function () {
  function initNlForm(form) {
    var msg = form.parentNode ? form.parentNode.querySelector('[role="status"]') : null;
    if (!msg) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var emailInput = form.querySelector('input[type="email"]');
      var btn        = form.querySelector('button[type="submit"]');
      var website    = form.querySelector('input[name="website"]');
      var email      = emailInput ? emailInput.value.trim() : '';
      if (!email || !btn) return;

      var originalLabel = btn.textContent;
      btn.disabled    = true;
      btn.textContent = 'Odosielam…';

      fetch('newsletter_subscribe.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-NPS-Newsletter': '1'
        },
        body: 'email=' + encodeURIComponent(email)
            + '&website=' + encodeURIComponent(website ? website.value : '')
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        msg.textContent = data.message || '';
        msg.hidden    = false;
        if (data.success) {
          form.hidden = true;
        } else {
          btn.disabled    = false;
          btn.textContent = originalLabel;
        }
      })
      .catch(function () {
        msg.textContent = 'Nastala chyba. Skúste to neskôr.';
        msg.hidden      = false;
        btn.disabled    = false;
        btn.textContent = originalLabel;
      });
    });
  }

  var forms = document.querySelectorAll('form.newsletter-cta__form');
  for (var i = 0; i < forms.length; i++) {
    initNlForm(forms[i]);
  }
})();
