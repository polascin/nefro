import katex from 'katex';

const tests = [
  ['eGFR with brackets', String.raw`\text{eGFR} = 142 \times \min(S_{cr}/\kappa, 1)^\alpha \times [1.012 \text{ ak žena}]`, true],
  ['adpkd classes', String.raw`\text{Triedy: } 1A: k < 0.015 \quad 1B: 0.015\text{--}0.030`, true],
  ['aligned', String.raw`\begin{aligned} X = &-0.2201 \cdot (\text{Vek}/10 - 7.036) \\ &- 0.5567 \end{aligned}`, true],
  ['inline lt', String.raw`eGFR \ge 60 / < 60`, false],
  ['percent', String.raw`\text{FENa} = \frac{U_{Na} \times S_{Cr}}{S_{Na} \times U_{Cr}} \times 100\%`, true],
  ['mol/L', String.raw`S_{cr} [\mu\text{mol/L}]`, true],
];

for (const [name, tex, display] of tests) {
  try {
    const html = katex.renderToString(tex, { throwOnError: true, displayMode: display });
    console.log('OK', name);
  } catch (e) {
    console.log('ERR', name, e.message);
  }
}
