/**
 * Odoslanie formulára klávesom Enter
 *
 * Tento skript umožňuje používateľom odoslať formuláre stlačením klávesu Enter
 * na vstupných poliach (text, email, heslo a pod.), nie však na textarea
 * prvích, ktoré môžu vyžadovať viaceré riadky.
 */

document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form');
  
  forms.forEach(form => {
  // Počúvanie stlačenia klávesu na vstupných prvkoch formulára
    form.addEventListener('keydown', (event) => {
      // Spracovať iba kláves Enter
      if (event.key !== 'Enter') {
        return;
      }
      
      const target = event.target;
      
      // Odoslanie formulára pri stlačení Enter na vstupných poliach (nie na textarea ani tlačidlách)
      // a nie na viacriadkových textarea prvkoch
      if (target.tagName === 'INPUT' && 
          !target.hasAttribute('data-no-enter-submit') &&
          target.type !== 'submit' &&
          target.type !== 'button' &&
          target.type !== 'reset') {
        
        // Zabrániť predvolenému správaniu (pridanie nového riadku v contenteditable)
        event.preventDefault();
        
        // Odoslať formulár
        form.submit();
      }
    });
  });
});
