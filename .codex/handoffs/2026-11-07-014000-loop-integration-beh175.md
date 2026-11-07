# Handoff 2026-11-07 01:40: slučka ae (integračná brána) + Beh 175

## Stav
- Slučky ACTIVE (~20 min). main po merge fix + audit; runtime bez zmeny (`83b72b8d`).
- ČAKÁ NA SÚHLAS: 8 odkazov v článkoch (state/TODO.md, Beh 173).

## Hotové
- .gitattributes: tools/integration/** text eol=lf. Brána: Integration 45 PASS, lint 726/0,
  restore self-test PASS (log: scratchpad integration2.log, mimo repa).

## Pasce
- Windows checkout + autocrlf: PHP heredoc so shellom → CRLF → dash zlyhá. Obnova súborov:
  `git ls-files tools/integration | xargs rm -f && git checkout -- tools/integration`.
- Brána trvá ~5 až 8 min; spúšťaj na pozadí.

## Ďalší krok
Obnoviť tools/integration v D:\Dev\nefro (súbežní agenti: len tieto súbory, nič iné).
Články/IgAN/Na/CRRT len so súhlasom.
