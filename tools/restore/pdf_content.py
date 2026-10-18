"""Read-only text comparison; no application configuration or article code is executed."""

import difflib
from datetime import datetime
import hashlib
from html.parser import HTMLParser
import json
from pathlib import PurePosixPath
import re
import shutil
import subprocess
import unicodedata

from probe import quote
from recovery import digest


class ArticleText(HTMLParser):
    blocks = {"p", "div", "h1", "h2", "h3", "h4", "h5", "h6", "li", "ul", "ol",
              "table", "tr", "td", "th", "figure", "figcaption", "br", "hr", "dl", "dt", "dd", "blockquote"}

    def __init__(self):
        super().__init__(convert_charrefs=True)
        self.parts = []
        self.suppressed = 0
        self.lists = []
        self.unsupported_list_types = []

    def handle_starttag(self, tag, attrs):
        values = dict(attrs)
        if tag in {"ol", "ul"}:
            if tag == "ol" and (values.get("type", "1") != "1" or "reversed" in values):
                self.unsupported_list_types.append(values.get("type", "reversed"))
            self.lists.append(int(values.get("start", "1")) - 1 if tag == "ol" else None)
        if tag == "li" and self.lists and self.lists[-1] is not None:
            self.lists[-1] = int(values["value"]) if "value" in values else self.lists[-1] + 1
            self.parts.append(" " + str(self.lists[-1]) + ". ")
        if tag in {"script", "style"}:
            self.suppressed += 1
        if tag in self.blocks and not self.suppressed:
            self.parts.append(" ")

    def handle_endtag(self, tag):
        if tag in {"ol", "ul"} and self.lists:
            self.lists.pop()
        if tag in {"script", "style"}:
            self.suppressed = max(0, self.suppressed - 1)
        if tag in self.blocks and not self.suppressed:
            self.parts.append(" ")

    def handle_data(self, data):
        if not self.suppressed:
            self.parts.append(data)


def canonical(text):
    # Preserve case, accents, mathematical signs, punctuation and every digit.
    return " ".join(unicodedata.normalize("NFC", text).split())


def tokens(text):
    return re.findall(r"\w+|[^\w\s]", canonical(text), flags=re.UNICODE)


def signature(text):
    return hashlib.sha256(text.encode("utf-8")).hexdigest()


def strip_page_numbers(text):
    pages = text.split("\f")
    if not pages[-1].strip():
        pages.pop()
    removed = []
    for index, page in enumerate(pages, 1):
        label = str(index) + "/" + str(len(pages))
        pattern = (r"(?m)^[ \t]*" + str(index) + r"[ \t]*/[ \t]*"
                   + str(len(pages)) + r"[ \t]*\s*\Z")
        if re.search(pattern, page):
            pages[index - 1] = re.sub(pattern, "", page)
            removed.append(label)
    return "\f".join(pages), removed


def differences(expected, actual):
    result = []
    for kind, start, end, other_start, other_end in difflib.SequenceMatcher(
            None, expected, actual, autojunk=False).get_opcodes():
        if kind == "equal":
            continue
        left, right = expected[start:end], actual[other_start:other_end]
        # No raw article excerpts or author names in the machine evidence.
        result.append({"kind": kind, "database_token_range": [start, end],
                       "pdf_token_range": [other_start, other_end],
                       "database_text_sha256": signature(" ".join(left)),
                       "pdf_text_sha256": signature(" ".join(right)),
                       "contains_digits": any(any(c.isdigit() for c in t) for t in left + right),
                       "punctuation_only": all(not any(c.isalnum() for c in t) for t in left + right)})
    return result


def compare(sql, container, databases, bundle):
    bundle = bundle.resolve(strict=True)
    manifest = json.loads((bundle / "recovery-manifest.json").read_text(encoding="utf-8"))
    entries = [entry for entry in manifest["recovery"]["entries"] if entry["path"].endswith(".pdf")]
    if len(entries) != 5 or len({entry["path"] for entry in entries}) != 5:
        raise RuntimeError("Expected exactly five recovered PDFs.")
    executable = shutil.which("pdftotext")
    if not executable:
        raise RuntimeError("pdftotext is required for the full-text comparison.")
    version = subprocess.run([executable, "-v"], check=True, capture_output=True, timeout=10)
    extractor_version = (version.stdout + version.stderr).decode("utf-8", errors="replace").splitlines()[0]
    candidates = []
    for database in databases:
        tables = sql(container, "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA=CONVERT(0x"
                     + database.encode().hex() + " USING utf8mb4)").decode().splitlines()
        if "articles" in tables:
            candidates.append(database)
    if len(candidates) != 1:
        raise RuntimeError("Expected exactly one restored article database.")
    database = candidates[0]
    output = []
    for entry in sorted(entries, key=lambda item: item["path"]):
        relative = PurePosixPath(entry["path"])
        if relative.parts != ("pdf", relative.name) or not re.fullmatch(r"[a-z0-9-]+\.pdf", relative.name):
            raise RuntimeError("Unexpected recovered PDF path.")
        path = bundle.joinpath(*relative.parts)
        if path.is_symlink() or not path.resolve(strict=True).is_relative_to(bundle) or digest(path) != entry["sha256"]:
            raise RuntimeError("Recovered PDF differs from its manifest.")
        rows = sql(container, "SELECT HEX(JSON_OBJECT('title',title,'content',content,'slug',slug,'author',author,'published_at',published_at)) FROM "
                   + quote(database) + ".articles WHERE BINARY pdf_file=0x"
                   + relative.name.encode().hex()).decode().splitlines()
        if len(rows) != 1:
            raise RuntimeError("Expected one database article per recovered PDF.")
        article = json.loads(bytes.fromhex(rows[0]))
        parser = ArticleText()
        parser.feed(article["content"])
        parser.close()
        expected = canonical("".join(parser.parts))
        extracted = subprocess.run([executable, "-raw", "-enc", "UTF-8", str(path), "-"],
                                   check=True, capture_output=True, timeout=60).stdout.decode("utf-8", errors="strict")
        if not extracted.strip() or "\ufffd" in extracted:
            raise RuntimeError("PDF text is empty or contains replacement characters.")
        # Only the expected sequential label at the very end of each page.
        # A fraction or ratio inside an article must never be silently discarded.
        text, page_numbers = strip_page_numbers(extracted)
        text = canonical(text)
        title = canonical(article["title"])
        header = "NEFRO · NEFRO.POLASCIN.NET " + title
        # Metadata is present in some PDF generations. Separate at the first body text,
        # but require all preceding text to be the known header + optional metadata.
        if not text.startswith(header):
            raise RuntimeError("PDF header does not match the restored article title.")
        text = text[len(header):].lstrip()
        metadata_removed = False
        metadata_matches_database = None
        if text.startswith("Autor:"):
            match = re.match(r"Autor: .*?Publikované: \d{2}\.\d{2}\.\d{4}\s+", text)
            if not match:
                raise RuntimeError("Unrecognized PDF metadata; comparison stopped.")
            date = datetime.fromisoformat(article["published_at"]).strftime("%d.%m.%Y")
            expected_meta = canonical("Autor: " + article["author"] + " · Publikované: " + date)
            metadata_matches_database = canonical(match[0]) == expected_meta
            text = text[match.end():]
            metadata_removed = True
        footer = ("Zdroj: https://nefro.polascin.net/article.php?slug=" + article["slug"]
                  + " · Nefro-projekt Slovensko. Obsah má informačný a vzdelávací charakter a nenahrádza konzultáciu s lekárom.")
        if not text.endswith(footer):
            raise RuntimeError("PDF footer does not match the expected source and disclaimer.")
        actual = text[:-len(footer)].rstrip()
        left, right = tokens(expected), tokens(actual)
        changes = differences(left, right)
        output.append({"path": entry["path"], "pdf_sha256": entry["sha256"],
                       "database_html_sha256": signature(article["content"]),
                       "database_visible_text_sha256": signature(expected), "pdf_body_text_sha256": signature(actual),
                       "pdf_pages": extracted.count("\f"), "removed_page_number_lines": page_numbers,
                       "metadata_removed": metadata_removed, "header_and_footer_verified": True,
                       "metadata_matches_database": metadata_matches_database,
                       "unsupported_list_types": parser.unsupported_list_types,
                       "database_tokens": len(left), "pdf_tokens": len(right),
                       "whitespace_normalized_exact_match": expected == actual,
                       "token_match": left == right, "difference_groups": changes})
        if digest(path) != entry["sha256"]:
            raise RuntimeError("PDF changed during comparison.")
    return {"result": "PASS" if all(item["token_match"] and not item["unsupported_list_types"]
                                     and item["metadata_matches_database"] is not False for item in output) else "PARTIAL",
            "method": "NFC and Unicode whitespace normalization; case, accents, digits and punctuation preserved; ordered token diff",
            "pdf_extraction_mode": "pdftotext -raw (content stream order); HTML decimal ordered-list markers included",
            "extractor_version": extractor_version,
            "excluded": ["verified site header and article title", "author/date metadata if present", "anchored page-number lines", "verified source/disclaimer footer", "HTML script/style text"],
            "entries": output,
            "limits": ["Differences are not automatically accepted as layout-only.",
                       "No visual, image, hyperlink destination or formula rendering equivalence is asserted.",
                       "Token equality ignores whitespace placement around punctuation; exact whitespace-normalized equality is also reported."]}
