#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Generátor QR kódu pre payme.sk odkaz (img/payme-qr.png).

Na rozdiel od PAY by square (tools/gen_pay_by_square.py) je toto jednoduchý
URL QR — zakóduje payme.sk platobný odkaz. Po naskenovaní telefón otvorí payme
stránku, z ktorej darca zaplatí v aplikácii svojej banky (vrátane platby na
telefónne číslo / Viamo).

Self-test: vygenerovaný PNG sa nezávisle dekóduje (OpenCV) a porovná s URL.

Závislosti (lokálne):  python -m pip install segno opencv-python-headless
Použitie:              python tools/gen_payme_qr.py
"""
from __future__ import annotations

import sys
from pathlib import Path

# Musí byť bajt-identické s $paymeUrl v podpora.php.
IBAN = "SK0311000000002943301908"
PAYME_URL = (
    "https://payme.sk/2/q/PME?IBAN=" + IBAN
    + "&AM=0.00&CC=EUR&PI=&MSG=&CN=MUDr.+Lubomir+Polascin"
)
OUT = Path(__file__).resolve().parent.parent / "img" / "payme-qr.png"


def main() -> int:
    try:
        import segno
    except ImportError:
        raise SystemExit("Chýba 'segno'. Inštaluj: python -m pip install segno")

    OUT.parent.mkdir(parents=True, exist_ok=True)
    segno.make(PAYME_URL, error="m").save(str(OUT), scale=8, border=4)

    # Self-test: nezávislé dekódovanie obrázka (ak je OpenCV k dispozícii)
    try:
        import cv2
        data, _, _ = cv2.QRCodeDetector().detectAndDecode(cv2.imread(str(OUT)))
        if data != PAYME_URL:
            raise SystemExit(f"[CHYBA] Dekódovaný QR != URL:\n  {data!r}")
        print("[OK] Self-test prešiel — QR dekóduje na správnu payme.sk URL.")
    except ImportError:
        print("[!] OpenCV nie je nainštalovaný — preskakujem dekódovací self-test.")

    print(f"   URL : {PAYME_URL}")
    print(f"   PNG : {OUT}")
    return 0


if __name__ == "__main__":
    sys.exit(main())
