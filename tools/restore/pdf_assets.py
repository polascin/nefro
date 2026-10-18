"""Offline PDF asset inspection; no URLs are opened and no PDF is modified."""

import hashlib
from html.parser import HTMLParser
import io
from pathlib import Path
from urllib.parse import urljoin, urlsplit


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
    value = value.replace("\\", "/")
    for marker in ("img/", "article.php?"):
        position = value.rfind(marker)
        if position >= 0:
            return value[position:]
    return None


def compare_destinations(hrefs, article_url, remote, local):
    expected = {urljoin(article_url, value) for value in hrefs}
    supported = {value for value in expected if urlsplit(value).scheme in {"http", "https"}}
    actual = set(remote) | {urljoin("https://nefro.polascin.net/", value) for value in local}
    # A printed source URL is not promised to be clickable by the generator.
    if article_url in actual:
        supported.add(article_url)
    return {"missing": len(supported - actual), "unexpected": len(actual - supported),
            "unsupported_html_targets": len(expected - supported),
            "expected_resolved_destinations": len(supported), "actual_resolved_destinations": len(actual),
            "resolved_destinations_sha256": hashlib.sha256("\n".join(sorted(actual)).encode()).hexdigest(),
            "expected_resolved_destinations_sha256": hashlib.sha256("\n".join(sorted(supported)).encode()).hexdigest()}


def image_verdict(images, embedded_count):
    if len(images) != embedded_count or any(not item["source_available"]
            or len(item.get("same_dimension_candidates", [])) != 1 for item in images):
        return "INCOMPLETE"
    if any(not item["same_dimension_candidates"][0]["exact_RGB_pixels"] for item in images):
        return "REQUIRES_VISUAL_REVIEW"
    return "EXACT_PIXELS"


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
    footer_url = "https://nefro.polascin.net/article.php?slug=" + article["slug"]
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
                    remote.add(link["uri"])
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
                difference = ImageChops.difference(original, decoded)
                stat = ImageStat.Stat(difference)
                measurements.append({"format": data["ext"], "dimensions": list(decoded.size),
                                     "mean_absolute_RGB_error_0_to_255": round(sum(stat.mean) / 3, 6),
                                     "exact_RGB_pixels": difference.getbbox() is None,
                                     "embedded_stream_sha256": hashlib.sha256(data["image"]).hexdigest()})
            images.append({"source_available": True, "source_sha256": hashlib.sha256(candidate.read_bytes()).hexdigest(),
                           "source_dimensions": list(original.size), "same_dimension_candidates": measurements})
    comparison = compare_destinations(parser.links, footer_url, remote, local)
    mismatch = bool(comparison["missing"] or comparison["unexpected"] or comparison["unsupported_html_targets"] or unknown)
    geometry = any(page["words_outside_page"] or page["images_outside_page"] for page in pages)
    verdict = image_verdict(images, len(embedded))
    return {"result": "PARTIAL" if absolute_launches or mismatch or geometry or verdict != "EXACT_PIXELS" else "PASS",
            "pages": pages, "embedded_images": len(embedded), "images": images,
            "image_verification": verdict,
            "links": {"annotations": link_count, "unique_remote_destinations": len(remote),
                      "unique_local_targets": len(local), "unclassified": unknown,
                      "destination_comparison": comparison,
                      "absolute_local_launch_annotations": absolute_launches,
                      "printed_source_footer_is_clickable": footer_url in remote,
                      "destinations_match_article_after_public_suffix_mapping": not mismatch},
            "limits": ["No URL was requested; HTTP availability and redirects are not tested.",
                       "Public suffix matching does not make absolute file launch annotations portable.",
                       "Pixel differences are measured; visual review is separate and no exact image equality is asserted.",
                       "Geometry checks alone do not detect text overlap or table layout defects."]}
