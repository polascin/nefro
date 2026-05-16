const fs = require('fs');
const katex = require('./assets/katex/0.16.11/katex.min.js');
const phpFiles = fs.readdirSync('.').filter(f => f.endsWith('.php'));
const lineRegex = /<div class="calc-formula-line">([\s\S]*?)<\/div>/g;
const varsRegex = /<div class="calc-formula-vars">([\s\S]*?)<\/div>/g;
const formulasRegex = /\\\[([\s\S]*?)\\\]|\$\$([\s\S]*?)\$\$|\\\(([\s\S]*?)\\\)|\$([^\$]*?)\$/g;
let errors = [];
for (const file of phpFiles) {
  const text = fs.readFileSync(file, 'utf8');
  for (const [label, regex] of [['formula-line', lineRegex], ['formula-vars', varsRegex]]) {
    let match;
    while ((match = regex.exec(text)) !== null) {
      const inner = match[1];
      let fm;
      while ((fm = formulasRegex.exec(inner)) !== null) {
        const expr = fm[1] ?? fm[2] ?? fm[3] ?? fm[4] ?? '';
        if (!expr.trim()) continue;
        try {
          const displayMode = fm[1] !== undefined || fm[2] !== undefined;
          katex.__parse(expr, { displayMode });
        } catch (err) {
          errors.push({ file, label, expr: expr.replace(/\s+/g, ' ').trim(), message: err.toString() });
          break;
        }
      }
    }
  }
}
if (errors.length) {
  console.error('ERRORS', JSON.stringify(errors, null, 2));
  process.exit(1);
}
console.log('OK');
