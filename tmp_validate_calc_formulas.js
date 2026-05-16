const fs = require('fs');
const path = require('path');
const katex = require('./assets/katex/0.16.11/katex.min.js');
const files = fs.readdirSync('.').filter(f => f.endsWith('.php'));
const lineRegex = /<div[^>]+class=["']calc-formula-line["'][^>]*>([\s\S]*?)<\/div>/gi;
const formulaRegex = /\\\[([\s\S]*?)\\\]|\$\$([\s\S]*?)\$\$|\\\(([\s\S]*?)\\\)|\$([\s\S]*?)\$/g;
let errors = [];
for (const file of files) {
  const text = fs.readFileSync(file, 'utf8');
  let lineMatch;
  while ((lineMatch = lineRegex.exec(text)) !== null) {
    const inner = lineMatch[1];
    const stripped = inner.replace(/<[^>]+>/g, '').trim();
    if (!stripped) continue;
    let match;
    while ((match = formulaRegex.exec(stripped)) !== null) {
      const expr = match[1] || match[2] || match[3] || match[4];
      if (!expr || !expr.trim()) continue;
      try {
        katex.__parse(expr, { displayMode: true });
      } catch (e) {
        errors.push({ file, expr: expr.replace(/\n/g, ' ').slice(0, 300), message: e.toString() });
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