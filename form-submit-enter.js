/**
 * Enable form submission by pressing Enter key
 * 
 * This script allows users to submit forms by pressing the Enter key
 * on input fields (text, email, password, etc.), not on textareas
 * which may need multiple lines.
 */

document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form');
  
  forms.forEach(form => {
    // Listen for keydown on input elements within the form
    form.addEventListener('keydown', (event) => {
      // Only process Enter key
      if (event.key !== 'Enter') {
        return;
      }
      
      const target = event.target;
      
      // Submit form if Enter is pressed on input fields (but not textarea or buttons)
      // and not on multi-line textareas
      if (target.tagName === 'INPUT' && 
          !target.hasAttribute('data-no-enter-submit') &&
          target.type !== 'submit' &&
          target.type !== 'button' &&
          target.type !== 'reset') {
        
        // Prevent default behavior (adding newline in contenteditable)
        event.preventDefault();
        
        // Submit the form
        form.submit();
      }
    });
  });
});
