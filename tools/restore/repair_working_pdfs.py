"""Create new offline working copies; never overwrite any source PDF or backup."""

import argparse
import hashlib
import json
from pathlib import Path
import re
import shutil
from urllib.parse import urljoin

GOVERNANCE = "ai-governance-klinicka-prax-nefrologia.pdf"
EXPECTED_LAUNCHES = {
    GOVERNANCE: 7,
    "automatizovane-podavanie-inzulinu-dm2-dialyza.pdf": 7,
    "cetp-inhibicia-obicetrapib-lipidy-renalna-funkcia.pdf": 6,
    "nizkoenergeticka-dieta-cvicenie-remisia-dm2-reset.pdf": 7,
    "renin-aldosteron-dapagliflozin-spironolakton-hfpef.pdf": 8,
}


def digest(path):
    return hashlib.sha256(path.read_bytes()).hexdigest()


def public_uri(target):
    normalized = target.replace("\\", "/")
    match = re.fullmatch(
        r"(?:(?:[A-Za-z]:)?/)?(?:[^/?#&:\x00-\x20]+/)*"
        r"(img/[a-z0-9-]+\.webp|article\.php\?slug=[a-z0-9-]+)", normalized)
    if not match:
        raise RuntimeError("Unrecognized local link; refusing to guess its public destination.")
    return urljoin("https://nefro.polascin.net/", match[1])



def validate_entries(entries):
    expected = {"pdf/" + name for name in EXPECTED_LAUNCHES}
    expected |= {"img/" + Path(name).stem + ".webp" for name in EXPECTED_LAUNCHES}
    paths = [entry["path"] for entry in entries]
    if len(paths) != len(expected) or set(paths) != expected:
        raise RuntimeError("Expected exactly the ten audited relative asset paths.")


def page_label(page, expected):
    matches = [span for block in page.get_text("dict")["blocks"] for line in block.get("lines", [])
               for span in line["spans"] if span["text"].strip() == expected]
    if len(matches) != 1 or matches[0]["bbox"][1] < 800:
        raise RuntimeError("Expected one page label in the bottom margin.")
    return matches[0]


def compact_governance(document):
    import fitz

    if len(document) != 7 or document[6].get_links() or document[6].get_images():
        raise RuntimeError("Unexpected final page; refusing to remove it.")
    label = page_label(document[6], "7 / 7")
    footer_words = [word for word in document[6].get_text("words") if word[1] < 800]
    if not footer_words or max(word[3] for word in footer_words) > 70:
        raise RuntimeError("The last page contains more than the expected footer.")
    destination = fitz.Rect(40, 781, 555, 805)
    if any(fitz.Rect(word[:4]).intersects(destination) for word in document[5].get_text("words")):
        raise RuntimeError("No safe space for the final note on the preceding page.")
    note = fitz.open()
    note.insert_pdf(document, from_page=6, to_page=6)
    note[0].add_redact_annot(fitz.Rect(label["bbox"]) + (-0.5, -0.5, 0.5, 0.5), fill=False)
    note[0].apply_redactions(images=0, graphics=0)
    # Copy vector text and the separator; preserve the original font and wording.
    document[5].show_pdf_page(destination, note, 0, clip=fitz.Rect(40, 44, 555, 68))
    note.close()
    document.delete_page(6)
    for index in range(6):
        page = document[index]
        label = page_label(page, str(index + 1) + " / 7")
        font = fitz.Font("helv")
        page.add_redact_annot(fitz.Rect(label["bbox"]) + (-0.5, -0.5, 0.5, 0.5), fill=False)
        page.apply_redactions(images=0, graphics=0)
        text = str(index + 1) + " / 6"
        width = font.text_length(text, fontsize=label["size"])
        page.insert_text(((page.rect.width - width) / 2, label["origin"][1]), text,
                         fontname="helv", fontsize=label["size"], color=(0, 0, 0))


def repair(source, output):
    import fitz

    source = source.resolve(strict=True)
    if output.exists() or output.resolve().is_relative_to(source):
        raise RuntimeError("A new output directory outside the source bundle is required.")
    manifest = json.loads((source / "recovery-manifest.json").read_text(encoding="utf-8"))
    entries = manifest["recovery"]["entries"]
    validate_entries(entries)
    manifest_sha = digest(source / "recovery-manifest.json")
    before = {}
    for entry in entries:
        path = source / entry["path"]
        if path.is_symlink() or not path.resolve(strict=True).is_relative_to(source) or digest(path) != entry["sha256"]:
            raise RuntimeError("Source asset failed integrity verification.")
        before[entry["path"]] = entry["sha256"]
    output.mkdir(parents=True)
    results = []
    derived = []
    for entry in entries:
        relative = Path(entry["path"])
        target = output / relative
        target.parent.mkdir(parents=True, exist_ok=True)
        if relative.suffix == ".pdf":
            with fitz.open(source / relative) as document:
                converted = 0
                for page in document:
                    for link in page.get_links():
                        if link["kind"] == fitz.LINK_LAUNCH:
                            uri = public_uri(link["file"])
                            page.update_link({"xref": link["xref"], "kind": fitz.LINK_URI,
                                              "from": link["from"], "uri": uri})
                            converted += 1
                        elif link["kind"] != fitz.LINK_URI or not link["uri"].startswith("https://"):
                            raise RuntimeError("Unexpected annotation; no output was accepted.")
                if converted != EXPECTED_LAUNCHES[relative.name]:
                    raise RuntimeError("Local annotation count differs from the audited baseline.")
                original_pages = len(document)
                if relative.name == GOVERNANCE:
                    compact_governance(document)
                document.save(target, garbage=4, deflate=True)
                results.append({"path": entry["path"], "source_sha256": entry["sha256"],
                                "working_sha256": digest(target), "converted_links": converted,
                                "original_pages": original_pages, "working_pages": len(document)})
        else:
            if relative.parts[0] != "img" or relative.suffix != ".webp":
                raise RuntimeError("Only the five public source illustrations may accompany the PDFs.")
            shutil.copyfile(source / relative, target)
        derived.append({"path": entry["path"], "sha256": digest(target), "bytes": target.stat().st_size,
                        "source_sha256": entry["sha256"]})
    if (digest(source / "recovery-manifest.json") != manifest_sha
            or any(digest(source / relative) != checksum for relative, checksum in before.items())):
        raise RuntimeError("Source changed during repair; no successful repair may be inferred.")
    working_manifest = {"recovery": {"scope": "derived_working_copy_only", "entries": derived},
                        "repair": {"source_assets_unchanged": True, "entries": results,
                                   "limits": ["Separate text, image, annotation and render verification is required.",
                                              "No production or original backup was modified."]}}
    (output / "recovery-manifest.json").write_text(json.dumps(working_manifest, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
    return results


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--source", type=Path, required=True)
    parser.add_argument("--output", type=Path, required=True)
    options = parser.parse_args()
    print(json.dumps(repair(options.source, options.output)))
