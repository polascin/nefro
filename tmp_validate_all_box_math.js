const fs = require('fs');
const katex = require('./assets/katex/0.16.11/katex.min.js');
const files = fs.readdirSync('.').filter(f => f.endsWith('.php'));
const boxRegex = /<(?:(?:details|div)[^>]*class=["'][^"']*calc-formula-box[^"']*["'][^>]*>)([\s\S]*?)<\/(?:details|div)>/gi;
const formulaRegex = /\\\[([\s\S]*?)\\\]|\$\$([\s\S]*?)\$\$|\\\(([\s\S]*?)\\\)|\$([\s\S]*?)\$/g;
let errors = [];
for (const file of files) {
  const text = fs.readFileSync(file, 'utf8');
  let match;
  while ((match = boxRegex.exec(text)) !== null) {
    const box = match[1];
    let m;
    while ((m = formulaRegex.exec(box)) !== null) {
      const expr = m[1] || m[2] || m[3] || m[4];
      if (!expr || !expr.trim()) continue;
      try {
        katex.__parse(expr, { displayMode: expr.startsWith('\\[') || expr.startsWith('$$') });
      } catch (e) {
        errors.push({ file, expr: expr.replace(/\n/g, ' ').slice(0,300), message: e.toString() });
        break;
      }
    }
  }
}
if (errors.length) {
  console.error('ERRORS', JSON.stringify(errors, null, 2));
  process.exit(1);
}
console.log('OK');