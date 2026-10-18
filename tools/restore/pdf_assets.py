"""Offline PDF asset inspection; no URLs are opened and no PDF is modified."""

import hashlib
from html.parser import HTMLParser
import io
from pathlib import Path
from urllib.parse import unquote, urlsplit


class Assets(HTMLParser):
    def __init__(self):
        super().__init__(convert_charrefs=True)
        self.links = []
        self.images = []

    def handle_starttag(self, tag, attrs):
        values = dict(attrs)
        if tag == "a" and values.get("href"):
            self.links.append(values["href"])
        if tag == "img" and values.get("src"):
            self.images.append(values["src"])


def local_target(value):
    """Retain only public route suffixes; never expose a machine's absolute path."""
    value = unquote(value).replace("\\", "/")
    for marker in ("img/", "article.php?"):
        position = value.rfind(marker)
        if position >= 0:
            return value[position:]
    return None


def require_dependencies():
    try:
        import fitz
        from PIL import Image, ImageChops, ImageStat
    except ImportError:
        raise RuntimeError("PDF asset review requires PyMuPDF and Pillow.") from None
    return fitz, Image, ImageChops, ImageStat


def inspect_article(path, bundle, article):
    fitz, Image, ImageChops, ImageStat = require_dependencies()

    parser = Assets()
    parser.feed(article["content"])
    expected_remote = {unquote(value) for value in parser.links if urlsplit(value).scheme in {"http", "https"}}
    footer_url = "https://nefro.polascin.net/article.php?slug=" + article["slug"]
    expected_local = {local_target(value) for value in parser.links if not urlsplit(value).scheme}
    expected_local.discard(None)
    remote = set()
    local = set()
    unknown = 0
    absolute_launches = 0
    link_count = 0
    pages = []
    embedded = {}
    with fitz.open(path) as document:
        for index, page in enumerate(document, 1):
            bounds = page.rect
            words = page.get_text("words")
            outside = sum(1 for word in words if not bounds.contains(fitz.Rect(word[:4])))
            placements = page.get_image_info(xrefs=True)
            pages.append({"page": index, "words": len(words), "words_outside_page": outside,
                          "image_placements": len(placements),
                          "images_outside_page": sum(1 for item in placements if not bounds.contains(fitz.Rect(item["bbox"])))})
            for image in page.get_images(full=True):
                embedded[image[0]] = document.extract_image(image[0])
            for link in page.get_links():
                link_count += 1
                if link["kind"] == fitz.LINK_URI:
                    remote.add(unquote(link["uri"]))
                elif link["kind"] == fitz.LINK_LAUNCH:
                    target = link.get("file", "")
                    absolute_launches += int(target.startswith(("/", "\\")) or (len(target) > 1 and target[1] == ":"))
                    suffix = local_target(target)
                    if suffix:
                        local.add(suffix)
                    else:
                        unknown += 1
                else:
                    unknown += 1
        images = []
        for source in parser.images:
            relative = Path(source)
            candidate = bundle / relative
            if relative.is_absolute() or not candidate.resolve().is_relative_to(bundle) or not candidate.is_file():
                images.append({"source_available": False})
                continue
            original = Image.open(candidate).convert("RGB")
            measurements = []
            for data in embedded.values():
                decoded = Image.open(io.BytesIO(data["image"])).convert("RGB")
                if decoded.size != original.size:
                    continue
                stat = ImageStat.Stat(ImageChops.difference(original, decoded))
                measurements.append({"format": data["ext"], "dimensions": list(decoded.size),
                                     "mean_absolute_RGB_error_0_to_255": round(sum(stat.mean) / 3, 6),
                                     "embedded_stream_sha256": hashlib.sha256(data["image"]).hexdigest()})
            images.append({"source_available": True, "source_sha256": hashlib.sha256(candidate.read_bytes()).hexdigest(),
                           "source_dimensions": list(original.size), "same_dimension_candidates": measurements})
    # The generator prints its source URL as plain text. It does not promise a
    # clickable footer. Accept its optional annotation without requiring one.
    if footer_url in remote:
        expected_remote.add(footer_url)
    mismatch = bool(remote - expected_remote or expected_remote - remote or local - expected_local or expected_local - local or unknown)
    geometry = any(page["words_outside_page"] or page["images_outside_page"] for page in pages)
    incomplete_images = (len(images) != len(embedded) or any(not item["source_available"]
                         or len(item.get("same_dimension_candidates", [])) != 1 for item in images))
    return {"result": "PARTIAL" if absolute_launches or mismatch or geometry or incomplete_images else "PASS",
            "pages": pages, "embedded_images": len(embedded), "images": images,
            "links": {"annotations": link_count, "unique_remote_destinations": len(remote),
                      "expected_remote_destinations": len(expected_remote),
                      "remote_destinations_sha256": hashlib.sha256("\n".join(sorted(remote)).encode()).hexdigest(),
                      "expected_remote_destinations_sha256": hashlib.sha256("\n".join(sorted(expected_remote)).encode()).hexdigest(),
                      "remote_missing": len(expected_remote - remote), "remote_unexpected": len(remote - expected_remote),
                      "unique_local_targets": len(local), "local_missing": len(expected_local - local),
                      "local_unexpected": len(local - expected_local), "unclassified": unknown,
                      "absolute_local_launch_annotations": absolute_launches,
                      "printed_source_footer_is_clickable": footer_url in remote,
                      "destinations_match_article_after_public_suffix_mapping": not mismatch},
            "limits": ["No URL was requested; HTTP availability and redirects are not tested.",
                       "Public suffix matching does not make absolute file launch annotations portable.",
                       "Pixel differences are measured; visual review is separate and no exact image equality is asserted.",
                       "Geometry checks alone do not detect text overlap or table layout defects."]}
