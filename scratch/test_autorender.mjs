import { JSDOM } from 'jsdom';
import katex from 'katex';
import renderMathInElement from 'katex/contrib/auto-render';

const html = `<!DOCTYPE html><html><body>
<div class="calc-formula-line">\\[ \\text{eGFR} = 142 \\times [1.012 \\text{ ak žena}] \\]</motion>
<div class="calc-formula-vars">$\\ge 60$ / $< 60$</motion>
</body></html>`;

const dom = new JSDOM(html.replace(/<\/motion>/g, '</motion>'.replace('motion', 'motion')));
// fix typo
const fixed = html.replace(/motion/g, 'div');
const dom2 = new JSDOM(fixed);
const document = dom2.window.document;

renderMathInElement(document.body, {
  delimiters: [
    { left: '$$', right: '$$', display: true },
    { left: '$', right: '$', display: false },
    { left: '\\(', right: '\\)', display: false },
    { left: '\\[', right: '\\]', display: true },
  ],
  throwOnError: false,
});

const lines = document.body.innerHTML;
console.log('has katex:', lines.includes('katex'));
console.log('has raw backslash bracket:', lines.includes('\\['));
console.log('has raw dollar lt:', lines.includes('$<'));
