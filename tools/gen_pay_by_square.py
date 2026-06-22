#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Generátor PAY by square QR kódu pre stránku podpory (img/pay-by-square.png).

Formát BY square (verzia 1.2.0) implementovaný presne podľa oficiálnej
referenčnej knižnice `bysquare` (Apache-2.0, Filip Seman) — overené čítaním
zdroja, nie odhadom:

    base32hex( header[2B] + payloadLength[2B, LE] + lzmaBody )
    payload   = CRC32(tab)[4B, LE] + tab.encode("utf-8")
    lzmaBody  = LZMA1(payload, lc=3 lp=0 pb=2, dict=2^17) bez 13-B hlavičky
    header    = [0x02, 0x00]  (BySquareType=0, Version=1.2.0, DocType=0, Reserved=0)

DÔLEŽITÉ — overiteľnosť:
  Skript má zabudovaný self-test, ktorý vlastný výstup DEKÓDUJE rovnakou logikou
  ako referenčný dekodér (rekonštrukcia LZMA hlavičky 0x5D / dict 00 00 02 00 /
  8-B veľkosť) a overí CRC32 aj zhodu IBAN/suma/mena/príjemca. Ak čokoľvek
  nesedí, PNG sa NEzapíše.
  Posledné a rozhodujúce overenie je vždy: NASKENUJ výsledný QR vo svojej
  bankovej aplikácii a skontroluj IBAN a príjemcu pred ostrým nasadením.

Závislosť (lokálne, mimo servera):  python -m pip install segno
Použitie:
  python tools/gen_pay_by_square.py                 # bez sumy (darca zadá sám)
  python tools/gen_pay_by_square.py --amount 25     # s pevnou sumou 25 EUR
  python tools/gen_pay_by_square.py --note "Dar"    # vlastná poznámka
"""
from __future__ import annotations

import argparse
import lzma
import sys
import unicodedata
import zlib
from pathlib import Path

try:  # Slovenská diakritika do akejkoľvek konzoly
    sys.stdout.reconfigure(encoding="utf-8")
except Exception:
    pass

# --- Údaje príjemcu (zhodné s podpora.php) ---------------------------------
IBAN = "SK0311000000002943301908"
BIC = "TATRSKBX"
BENEFICIARY = "MUDr. Ľubomír Polaščín - Nephroctor"
CURRENCY = "EUR"
DEFAULT_NOTE = "Podpora Nefro-projekt Slovensko"
OUT_DEFAULT = Path(__file__).resolve().parent.parent / "img" / "pay-by-square.png"

ALPHABET = "0123456789ABCDEFGHIJKLMNOPQRSTUV"  # base32hex (RFC 4648)


def deburr(text: str) -> str:
    """Odstráni diakritiku (ako referenčný deburr) — banky preferujú ASCII."""
    if not text:
        return text
    nfkd = unicodedata.normalize("NFKD", text)
    return "".join(c for c in nfkd if not unicodedata.combining(c))


def serialize(iban: str, bic: str, beneficiary: str, currency: str,
              amount: str, note: str, variable_symbol: str) -> str:
    """Tab-separated payload podľa poradia polí v špecifikácii (Table 15)."""
    def san(v: str) -> str:
        return (v or "").replace("\t", " ")

    fields = [
        "",                         # invoiceId
        "1",                        # počet platieb
        "1",                        # type = PaymentOrder
        san(amount),                # suma ("" = darca zadá sám)
        san(currency),              # mena
        "",                         # paymentDueDate
        san(variable_symbol),       # variabilný symbol
        "",                         # konštantný symbol
        "",                         # špecifický symbol
        "",                         # originatorsReferenceInformation
        san(deburr(note)),          # poznámka
        "1",                        # počet bankových účtov
        san(iban),                  # IBAN
        san(bic),                   # BIC
        "0",                        # standingOrderExt
        "0",                        # directDebitExt
        san(deburr(beneficiary)),   # príjemca – meno
        "",                         # príjemca – ulica
        "",                         # príjemca – mesto
    ]
    return "\t".join(fields)


def _b32hex_encode(data: bytes) -> str:
    out, buf, bits = [], 0, 0
    for b in data:
        buf = (buf << 8) | b
        bits += 8
        while bits >= 5:
            bits -= 5
            out.append(ALPHABET[(buf >> bits) & 0x1F])
    if bits > 0:
        out.append(ALPHABET[(buf << (5 - bits)) & 0x1F])
    return "".join(out)


def _b32hex_decode(text: str) -> bytes:
    out, buf, bits = bytearray(), 0, 0
    for ch in text.rstrip("="):
        idx = ALPHABET.index(ch)
        buf = (buf << 5) | idx
        bits += 5
        if bits >= 8:
            bits -= 8
            out.append((buf >> bits) & 0xFF)
    return bytes(out)


def encode_qr(tab: str) -> tuple[str, bytes]:
    """tab -> QR reťazec; vracia aj payload (CRC+tab) pre self-test."""
    raw = tab.encode("utf-8")
    crc = zlib.crc32(raw) & 0xFFFFFFFF
    payload = crc.to_bytes(4, "little") + raw

    filt = [{"id": lzma.FILTER_LZMA1, "dict_size": 1 << 17,
             "lc": 3, "lp": 0, "pb": 2,
             "mode": lzma.MODE_NORMAL, "nice_len": 273,
             "mf": lzma.MF_BT4, "depth": 0}]
    alone = lzma.compress(payload, format=lzma.FORMAT_ALONE, filters=filt)
    lzma_body = alone[13:]  # odrež 13-B LZMA-Alone hlavičku

    header = bytes([0x02, 0x00])
    length = len(payload).to_bytes(2, "little")
    return _b32hex_encode(header + length + lzma_body), payload


def decode_qr(qr: str) -> tuple[str, bytes]:
    """Faithful reimplementácia referenčného dekodéra. Vracia (tab, payload).

    Referenčný dekodér (bysquare/lzma1) je *size-driven*: dekóduje presne
    `payloadLength` bajtov a prípadný koncový end-marker ignoruje
    (decoder.js: nowPos64 >= outSize). Python (liblzma) je v tomto prísnejší
    a pri konečnej veľkosti end-marker odmietne, preto rekonštruujeme hlavičku
    s "neznámou veľkosťou" (0xFF…) a dekódujeme cez end-marker — výsledok je
    bajt-identický s tým, čo dostane banka, a hneď ho overíme proti
    deklarovanej dĺžke z hlavičky.
    """
    data = _b32hex_decode(qr)
    version = data[1] & 0x0F
    if version > 0x02:
        raise ValueError(f"Nepodporovaná verzia hlavičky: {version}")
    payload_len = data[2] | (data[3] << 8)
    body = data[4:]
    rebuilt = (bytes([0x5D]) +                       # properties lc3 lp0 pb2
               (1 << 17).to_bytes(4, "little") +      # dict 2^17 -> 00 00 02 00
               b"\xFF" * 8 +                          # neznáma veľkosť -> end-marker
               body)
    payload = lzma.decompress(rebuilt, format=lzma.FORMAT_ALONE)
    if len(payload) != payload_len:
        raise ValueError(
            f"Dĺžka payloadu ({len(payload)}) nesedí s deklarovanou ({payload_len})")
    crc_stored = int.from_bytes(payload[:4], "little")
    tab = payload[4:].decode("utf-8")
    crc_calc = zlib.crc32(payload[4:]) & 0xFFFFFFFF
    if crc_stored != crc_calc:
        raise ValueError("CRC32 nesúhlasí")
    return tab, payload


def main() -> int:
    ap = argparse.ArgumentParser(description="Generuj PAY by square QR (PNG).")
    ap.add_argument("--amount", default="", help="suma v EUR (napr. 25 alebo 25.00); prázdne = bez sumy")
    ap.add_argument("--vs", default="", help="variabilný symbol")
    ap.add_argument("--note", default=DEFAULT_NOTE, help="poznámka pre príjemcu")
    ap.add_argument("--out", default=str(OUT_DEFAULT), help="výstupný PNG súbor")
    ap.add_argument("--scale", type=int, default=8, help="mierka QR modulu (px)")
    args = ap.parse_args()

    amount = args.amount.strip()
    if amount:
        amount = f"{float(amount):.2f}"  # normalizuj na 2 desatinné

    tab = serialize(IBAN, BIC, BENEFICIARY, CURRENCY, amount, args.note, args.vs)
    qr, payload = encode_qr(tab)

    # --- SELF-TEST: dekóduj vlastný výstup a over kľúčové polia -------------
    dec_tab, _ = decode_qr(qr)
    assert dec_tab == tab, "Round-trip: tab payload sa nezhoduje"
    parts = dec_tab.split("\t")
    checks = {
        "IBAN": (parts[12], IBAN),
        "BIC": (parts[13], BIC),
        "mena": (parts[4], CURRENCY),
        "suma": (parts[3], amount),
        "príjemca": (parts[16], deburr(BENEFICIARY)),
    }
    for label, (got, want) in checks.items():
        if got != want:
            raise SystemExit(f"[CHYBA] Self-test ZLYHAL ({label}): {got!r} != {want!r} — PNG NEzapísané")

    # --- Render PNG (až po úspešnom self-teste) ----------------------------
    try:
        import segno
    except ImportError:
        raise SystemExit("Chýba 'segno'. Inštaluj: python -m pip install segno")

    out = Path(args.out)
    out.parent.mkdir(parents=True, exist_ok=True)
    segno.make(qr, error="m").save(str(out), scale=args.scale, border=4)

    # --- Súhrn pre ľudskú kontrolu -----------------------------------------
    print("[OK] Self-test prešiel (round-trip + CRC32 + IBAN/mena/suma/príjemca)")
    print(f"   IBAN     : {parts[12]}")
    print(f"   Príjemca : {parts[16]}")
    print(f"   Mena     : {parts[4]}")
    print(f"   Suma     : {parts[3] or '(neuvedená — darca zadá sám)'}")
    print(f"   VS       : {parts[6] or '(žiadny)'}")
    print(f"   Poznámka : {parts[10]}")
    print(f"   QR dĺžka : {len(qr)} znakov")
    print(f"   PNG      : {out}")
    print("\n[!] Pred ostrým nasadením QR NASKENUJ v bankovej appke a over IBAN aj príjemcu.")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
