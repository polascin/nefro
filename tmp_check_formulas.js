const fs = require('fs');
const path = require('path');
const katex = require('./assets/katex/0.16.11/katex.min.js');

const files = fs.readdirSync('.').filter(f => f.endsWith('.php'));
const regex = /\\\[([\s\S]*?)\\\]|\$\$([\s\S]*?)\$\$|\$([^\$\n]+?)\$/g;
let errors = [];
for (const file of files) {
  const text = fs.readFileSync(file, 'utf8');
  let match;
  while ((match = regex.exec(text)) !== null) {
    const expr = match[1] || match[2] || match[3];
    if (!expr || !expr.trim()) continue;
    try {
      katex.__parse(expr, { displayMode: Boolean(match[1] || match[2]) });
    } catch (e) {
      errors.push({ file, expr: expr.replace(/\n/g, ' ').slice(0, 300), message: e.toString() });
      break;
    }
  }
}

if (errors.length) {
  console.error('ERRORS', JSON.stringify(errors, null, 2));
  process.exit(1);
} else {
  console.log('OK');
}
