import os
import re

def replace_in_file(filepath, replacements):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    new_content = content
    for target, replacement in replacements:
        if target not in new_content:
            print(f"Warning: Target not found in {filepath}")
            # Try to find with common variations (spaces, etc)
            pattern = re.escape(target).replace(r'\ ', r'\s+')
            if re.search(pattern, new_content):
                 new_content = re.sub(pattern, replacement, new_content)
                 print(f"Substituted with regex in {filepath}")
            continue
        new_content = new_content.replace(target, replacement)
        print(f"Replaced in {filepath}")
    
    if new_content != content:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)

# EGFR
replace_in_file('d:/OneDrive/www/nefro/calculator_egfr.php', [
    (
        '<code class="calc-formula-line">eGFR = 142 &times; min(S<sub>cr</sub>/&kappa;, 1)<sup>&alpha;</sup> &times; max(S<sub>cr</sub>/&kappa;, 1)<sup>&minus;1.200</sup> &times; 0.9938<sup>Vek</sup> [&times; 1.012 &nbsp;ak&nbsp;&nbsp;&#x2640;]</code>',
        '<div class="calc-formula-line">\\[ \\text{eGFR} = 142 \\times \\min(S_{cr}/\\kappa, 1)^\\alpha \\times \\max(S_{cr}/\\kappa, 1)^{-1.200} \\times 0.9938^{\\text{Vek}} \\times [1.012 \\text{ ak žena}] \\]</div>'
    ),
    (
        '<code class="calc-formula-line">Prepočet: S<sub>cr</sub> [mg/dL] = S<sub>cr</sub> [&micro;mol/L] &divide; 88.4</code>',
        '<div class="calc-formula-line">\\[ S_{cr} [\\text{mg/dL}] = S_{cr} [\\mu\\text{mol/L}] \\div 88.4 \\]</div>'
    ),
    (
        '''<div class="calc-formula-vars">
                            &kappa; = 0.7 (žena) / 0.9 (muž)&ensp;&bull;&ensp;
                            &alpha; = &minus;0.241 (žena) / &minus;0.302 (muž)&ensp;&bull;&ensp;
                            S<sub>cr</sub> = sérový kreatinín v mg/dL
                        </div>''',
        '''<div class="calc-formula-vars">
                            $\\kappa = 0.7 \\text{ (žena)} / 0.9 \\text{ (muž)}$ &bull; 
                            $\\alpha = -0.241 \\text{ (žena)} / -0.302 \\text{ (muž)}$ &bull; 
                            $S_{cr} = \\text{sérový kreatinín [mg/dL]}$
                        </div>'''
    )
])

# CG
replace_in_file('d:/OneDrive/www/nefro/calculator_cg.php', [
    (
        '<code class="calc-formula-line">CrCl = ((140 &minus; Vek) &times; Hmotnosť) / (72 &times; S<sub>cr</sub>) [&times; 0.85 &nbsp;ak&nbsp;&nbsp;&#x2640;]</code>',
        '<div class="calc-formula-line">\\[ \\text{CrCl} = \\frac{(140 - \\text{Vek}) \\times \\text{Hmotnosť}}{72 \\times S_{cr}} \\times [0.85 \\text{ ak žena}] \\]</div>'
    ),
    (
        '''<div class="calc-formula-vars">
                            Vek v rokoch&ensp;&bull;&ensp;
                            Hmotnosť v kg&ensp;&bull;&ensp;
                            S<sub>cr</sub> v mg/dL
                        </div>''',
        '''<div class="calc-formula-vars">
                            $\\text{Vek [roky]}$ &bull; $\\text{Hmotnosť [kg]}$ &bull; $S_{cr} = \\text{sérový kreatinín [mg/dL]}$
                        </div>'''
    )
])

# KFRE
replace_in_file('d:/OneDrive/www/nefro/calculator_kfre.php', [
    (
        '''<code class="calc-formula-line">X = &minus;0.2201&middot;(Vek/10 &minus; 7.036) + 0.2467&middot;(Muž &minus; 0.5642)
    &minus; 0.5567&middot;(eGFR/5 &minus; 7.222) + 0.4510&middot;(ln(UACR) &minus; 5.137)

Riziko(t) = 1 &minus; S<sub>0</sub>(t)<sup>exp(X)</sup> &times; 100 %

S<sub>0</sub>(2 roky) = 0.9832 &nbsp;&nbsp; S<sub>0</sub>(5 rokov) = 0.9240</code>''',
        '''<div class="calc-formula-line">\\[ \\begin{aligned} X = &-0.2201 \\cdot (\\text{Vek}/10 - 7.036) + 0.2467 \\cdot (\\text{Muž} - 0.5642) \\\\ &- 0.5567 \\cdot (\\text{eGFR}/5 - 7.222) + 0.4510 \\cdot (\\ln(\\text{UACR}) - 5.137) \\end{aligned} \\]</div>
                        <div class="calc-formula-line">\\[ \\text{Riziko}(t) = (1 - S_0(t)^{\\exp(X)}) \\times 100\\% \\]</div>
                        <div class="calc-formula-line">\\[ S_0(2 \\text{ roky}) = 0.9832 \\quad S_0(5 \\text{ rokov}) = 0.9240 \\]</div>'''
    ),
    (
        '<code class="calc-formula-line">Prepočet UACR: [mg/g] = [mg/mmol] &times; 8.84</code>',
        '<div class="calc-formula-line">\\[ \\text{UACR [mg/g]} = \\text{UACR [mg/mmol]} \\times 8.84 \\]</div>'
    ),
    (
        '''<div class="calc-formula-vars">
                            Muž = 1, Žena = 0 &ensp;&bull;&ensp; UACR v mg/g &ensp;&bull;&ensp;
                            Cox proportional hazards, North American kohorta &ensp;&bull;&ensp;
                            Zdroj: Tangri N et al. <em>JAMA.</em> 2011;305(15):1553–9.
                        </div>''',
        '''<div class="calc-formula-vars">
                            $\\text{Muž} = 1, \\text{Žena} = 0$ &bull; $\\text{UACR v mg/g}$ &bull;
                            Cox proportional hazards, North American kohorta &bull;
                            Zdroj: Tangri N et al. <em>JAMA.</em> 2011;305(15):1553–9.
                        </div>'''
    )
])

# CA
replace_in_file('d:/OneDrive/www/nefro/calculator_ca.php', [
    (
        '<code class="calc-formula-line">Korigovaný Ca = Nameraný Ca + 0.02 &times; (40 &minus; Albumín)</code>',
        '<div class="calc-formula-line">\\[ \\text{Ca}_{\\text{korig}} = \\text{Ca}_{\\text{nameraný}} + 0.02 \\times (40 - \\text{Albumín}) \\]</div>'
    ),
    (
        '''<div class="calc-formula-vars">
                            Vápnik v mmol/L&ensp;&bull;&ensp;
                            Albumín v g/L (Norma sa uvažuje 40 g/L)
                        </div>''',
        '''<div class="calc-formula-vars">
                            $\\text{Vápnik [mmol/L]}$ &bull; $\\text{Albumín [g/L]}$ (norma uvažovaná $40 \\text{ g/L}$)
                        </div>'''
    )
])

# NA
replace_in_file('d:/OneDrive/www/nefro/calculator_na.php', [
    (
        '<code class="calc-formula-line">TBW = Hmotnosť &times; (0.45 až 0.6 podľa pohlavia a veku)</code>',
        '<div class="calc-formula-line">\\[ \\text{TBW} = \\text{Hmotnosť} \\times (0.45 \\text{ až } 0.6 \\text{ podľa pohlavia a veku}) \\]</div>'
    ),
    (
        '<code class="calc-formula-line">Deficit vody [L] = TBW &times; ((S-Na / Cieľové Na) &minus; 1)</code>',
        '<div class="calc-formula-line">\\[ \\text{Deficit vody [L]} = \\text{TBW} \\times \\left( \\frac{\\text{S-Na}}{\\text{Cieľové Na}} - 1 \\right) \\]</div>'
    ),
    (
        '<code class="calc-formula-line">Adrogue-Madias = (Infúzia Na + Infúzia K &minus; S-Na) / (TBW + 1)</code>',
        '<div class="calc-formula-line">\\[ \\text{Adrogue-Madias} = \\frac{\\text{Infúzia Na} + \\text{Infúzia K} - \\text{S-Na}}{\\text{TBW} + 1} \\]</div>'
    )
])

# AKI
replace_in_file('d:/OneDrive/www/nefro/calculator_aki.php', [
    (
        '<code class="calc-formula-line">FENa = (U<sub>Na</sub> &times; S<sub>Cr</sub>) / (S<sub>Na</sub> &times; U<sub>Cr</sub>) &times; 100 [%]</code>',
        '<div class="calc-formula-line">\\[ \\text{FENa} = \\frac{U_{Na} \\times S_{Cr}}{S_{Na} \\times U_{Cr}} \\times 100\\% \\]</div>'
    ),
    (
        '<code class="calc-formula-line">FEUrea = (U<sub>Urea</sub> &times; S<sub>Cr</sub>) / (S<sub>Urea</sub> &times; U<sub>Cr</sub>) &times; 100 [%]</code>',
        '<div class="calc-formula-line">\\[ \\text{FEUrea} = \\frac{U_{\\text{Urea}} \\times S_{Cr}}{S_{\\text{Urea}} \\times U_{Cr}} \\times 100\\% \\]</div>'
    )
])

# ADPKD
replace_in_file('d:/OneDrive/www/nefro/calculator_adpkd.php', [
    (
        '''<code class="calc-formula-line">HtTKV = TKV [mL] / výška [m]
<br>k = ln(HtTKV / 150) / vek
<br>Triedy: 1A: k<0,015 &nbsp; 1B: 0,015–0,030 &nbsp; 1C: 0,030–0,045 &nbsp; 1D: 0,045–0,060 &nbsp; 1E: k≥0,060</code>''',
        '''<div class="calc-formula-line">\\[ \\text{HtTKV} = \\frac{\\text{TKV [mL]}}{\\text{výška [m]}} \\]</div>
                        <div class="calc-formula-line">\\[ k = \\frac{\\ln(\\text{HtTKV} / 150)}{\\text{vek}} \\]</div>
                        <div class="calc-formula-line">\\[ \\text{Triedy: } 1A: k < 0.015 \\quad 1B: 0.015\\text{--}0.030 \\quad 1C: 0.030\\text{--}0.045 \\quad 1D: 0.045\\text{--}0.060 \\quad 1E: k \\ge 0.060 \\]</div>'''
    )
])

# IgAN
replace_in_file('d:/OneDrive/www/nefro/calculator_igan.php', [
    (
        '''<code class="calc-formula-line">LP = &minus;0.02663·(eGFR&minus;66) + 0.55198·(prot&minus;1.7) + 0.00678·(MAP&minus;96) &minus; 0.23079·(RASB&minus;0.65) &minus; 0.63861·(IS&minus;0.21)
<br>Riziko (5 r.) = 1 &minus; 0.972<sup>exp(LP)</sup> &times; 100&thinsp;%</code>''',
        '''<div class="calc-formula-line">\\[ \\begin{aligned} LP = &-0.02663 \\cdot (\\text{eGFR} - 66) + 0.55198 \\cdot (\\text{prot} - 1.7) + 0.00678 \\cdot (\\text{MAP} - 96) \\\\ &- 0.23079 \\cdot (\\text{RASB} - 0.65) - 0.63861 \\cdot (\\text{IS} - 0.21) \\end{aligned} \\]</div>
                        <div class="calc-formula-line">\\[ \\text{Riziko (5 r.)} = (1 - 0.972^{\\exp(LP)}) \\times 100\\% \\]</div>'''
    )
])

# Acid-Base
replace_in_file('d:/OneDrive/www/nefro/calculator_acidbase.php', [
    (
        '<code class="calc-formula-line">AG = Na &minus; (Cl + HCO3)</code>',
        '<div class="calc-formula-line">\\[ \\text{AG} = \\text{Na} - (\\text{Cl} + \\text{HCO}_3) \\]</div>'
    ),
    (
        '<code class="calc-formula-line">Korig. AG = AG + 0.25 &times; (40 &minus; Albumín)</code>',
        '<div class="calc-formula-line">\\[ \\text{AG}_{\\text{korig}} = \\text{AG} + 0.25 \\times (40 - \\text{Albumín}) \\]</div>'
    ),
    (
        '<code class="calc-formula-line">&Delta; Ratio = (Korig. AG &minus; 12) / (24 &minus; HCO3)</code>',
        '<div class="calc-formula-line">\\[ \\Delta\\text{-Ratio} = \\frac{\\text{AG}_{\\text{korig}} - 12}{24 - \\text{HCO}_3} \\]</div>'
    )
])

# CKD-PC
replace_in_file('d:/OneDrive/www/nefro/calculator_ckdpc.php', [
    (
        '''<code class="calc-formula-line">P = 1 &minus; exp(&minus;exp(&eta;))

&eta; = &beta;<sub>0</sub> + &beta;<sub>1</sub>&middot;Vek + &beta;<sub>2</sub>&middot;muž + &beta;<sub>3</sub>&middot;ln(eGFR) + &beta;<sub>4</sub>&middot;ln(uACR) + &beta;<sub>5</sub>&middot;SBP
    + &beta;<sub>6</sub>&middot;antihyp + &beta;<sub>7</sub>&middot;SZ + &beta;<sub>8</sub>&middot;ICHS + &beta;<sub>9</sub>&middot;FP + &beta;<sub>10</sub>&middot;BMI + &beta;<sub>11</sub>&middot;fajč.
    + [&beta;<sub>12</sub>&middot;HbA1c + &beta;<sub>13</sub>&middot;inzulín + &beta;<sub>14</sub>&middot;PAD] &nbsp;(len pri DM)</code>''',
        '''<div class="calc-formula-line">\\[ P = 1 - \\exp(-\\exp(\\eta)) \\]</div>
                        <div class="calc-formula-line">\\[ \\begin{aligned} \\eta = \\beta_0 &+ \\beta_1 \\cdot \\text{Vek} + \\beta_2 \\cdot \\text{muž} + \\beta_3 \\cdot \\ln(\\text{eGFR}) + \\beta_4 \\cdot \\ln(\\text{uACR}) + \\beta_5 \\cdot \\text{SBP} \\\\ &+ \\beta_6 \\cdot \\text{antihyp} + \\beta_7 \\cdot \\text{SZ} + \\beta_8 \\cdot \\text{ICHS} + \\beta_9 \\cdot \\text{FP} + \\beta_{10} \\cdot \\text{BMI} + \\beta_{11} \\cdot \\text{fajč.} \\\\ &+ [\\beta_{12} \\cdot \\text{HbA1c} + \\beta_{13} \\cdot \\text{inzulín} + \\beta_{14} \\cdot \\text{PAD}] \\text{ (len pri DM)} \\end{aligned} \\]</div>'''
    ),
    (
        '<code class="calc-formula-line">Prepočet UACR: [mg/g] = [mg/mmol] &times; 8.84</code>',
        '<div class="calc-formula-line">\\[ \\text{UACR [mg/g]} = \\text{UACR [mg/mmol]} \\times 8.84 \\]</div>'
    ),
    (
        '''<div class="calc-formula-vars">
                            P = 3-ročné riziko (&ge;40 % pokles eGFR alebo zlyhanie obličiek)&ensp;&bull;&ensp;
                            4 sub-modely: DM / bez DM &times; eGFR &ge;60 / &lt;60&ensp;&bull;&ensp;
                            uACR v mg/g, SBP v mmHg
                        </div>''',
        '''<div class="calc-formula-vars">
                            $P = \\text{3-ročné riziko (}\\ge 40\\% \\text{ pokles eGFR alebo zlyhanie obličiek)}$ &bull;
                            4 sub-modely: DM / bez DM $\\times$ eGFR $\\ge 60$ / $< 60$ &bull;
                            uACR v mg/g, SBP v mmHg
                        </div>'''
    )
])
