"""Exercise the restore drill with synthetic archives and a real MariaDB dump."""

import argparse
import base64
import gzip
import json
import os
from pathlib import Path
import shutil
import stat
import subprocess
import sys
import tempfile
import zipfile


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--file-image", required=True)
    args = parser.parse_args()
    from run import worst_result
    from pdf_assets import Assets, local_target, compare_destinations, image_verdict
    from repair_working_pdfs import public_uri, validate_entries, EXPECTED_LAUNCHES
    if public_uri("/synthetic/private/article.php?slug=related") != "https://nefro.polascin.net/article.php?slug=related":
        raise RuntimeError("Working PDF repair lost a public destination.")
    for target in ("/private/config.ini", "/private/article.php?slug=x&admin=1", "/private/img/../secret.webp"):
        try:
            public_uri(target)
        except RuntimeError:
            pass
        else:
            raise RuntimeError("Working PDF repair accepted an unknown target.")
    paths = ["pdf/" + name for name in EXPECTED_LAUNCHES]
    paths += ["img/" + Path(name).stem + ".webp" for name in EXPECTED_LAUNCHES]
    validate_entries([{"path": path} for path in paths])
    for malicious in ("/absolute.pdf", "../escape.pdf", "pdf/../escape.pdf", paths[1]):
        try:
            validate_entries([{"path": path} for path in [malicious] + paths[1:]])
        except RuntimeError:
            pass
        else:
            raise RuntimeError("Working PDF repair accepted unsafe or duplicate output paths.")
    assets = Assets()
    assets.feed('<a href="https://example.invalid/reference?a=1&amp;b=2">test</a><img src="img/synthetic.webp">')
    if (assets.links != ["https://example.invalid/reference?a=1&b=2"] or assets.images != ["img/synthetic.webp"]
            or local_target("/synthetic/private/path/article.php?slug=synthetic") != "article.php?slug=synthetic"
            or local_target("/synthetic/private/path/img/synthetic.webp") != "img/synthetic.webp"
            or local_target("/synthetic/private/config.ini") is not None):
        raise RuntimeError("PDF destination mapping exposed a private path or lost a target.")
    url = "https://nefro.polascin.net/article.php?slug=synthetic"
    encoded = compare_destinations(["https://example.invalid/?q=a%26b=c"], url,
                                   {"https://example.invalid/?q=a&b=c"}, set())
    repaired = compare_destinations(["article.php?slug=related"], url,
                                    {"https://nefro.polascin.net/article.php?slug=related"}, set())
    if encoded["missing"] != 1 or encoded["unexpected"] != 1 or repaired["missing"] or repaired["unexpected"]:
        raise RuntimeError("PDF comparison conflated encoded parameters or rejected repaired HTTPS links.")
    for error, expected_verdict in [(255, "REQUIRES_VISUAL_REVIEW"), (2, "REQUIRES_VISUAL_REVIEW"), (0, "EXACT_PIXELS")]:
        if image_verdict([{"source_available": True, "same_dimension_candidates": [
                {"mean_absolute_RGB_error_0_to_255": error, "exact_RGB_pixels": error == 0}]}], 1) != expected_verdict:
            raise RuntimeError("PDF image comparison accepted a differing image without visual assessment.")
    if image_verdict([{"source_available": True, "same_dimension_candidates": [
            {"mean_absolute_RGB_error_0_to_255": 0, "exact_RGB_pixels": False}]}], 1) != "REQUIRES_VISUAL_REVIEW":
        raise RuntimeError("Rounded pixel error concealed a non-identical image.")
    # A layout-only PDF difference must never conceal an application failure.
    if (worst_result("PASS", "FAIL", "PARTIAL") != "FAIL"
            or worst_result("PARTIAL", "PASS", "FAIL") != "FAIL"
            or worst_result("PASS", "PARTIAL", "PASS") != "PARTIAL"):
        raise RuntimeError("Restore result aggregation concealed a failed or incomplete check.")
    # A content audit must detect clinically meaningful changes, even when most
    # surrounding prose is identical. It must also retain non-ASCII notation.
    from pdf_content import ArticleText, canonical, differences, tokens, strip_page_numbers
    for left, right in [("eGFR 45,5", "eGFR 45,6"), ("nie je účinný", "je účinný"),
                        ("≥ 30", "> 30"), ("24. 10. 2023", "18. 8. 2025"), ("liečba", "liecba")]:
        if not differences(tokens(left), tokens(right)):
            raise RuntimeError("PDF comparison concealed a meaningful text change.")
    html = ArticleText()
    html.feed("<p>eGFR <strong>45</strong></p><table><tr><td>≥30</td><td>nie</td></tr></table><script>hidden</script><p>účinný&nbsp;liek</p>")
    if canonical("".join(html.parts)) != "eGFR 45 ≥30 nie účinný liek":
        raise RuntimeError("PDF HTML text extraction lost table cells, accents or spacing.")
    pages, removed = strip_page_numbers("ratio\n1/2\nend\n1 / 2\n\fnext\n2/2\n\f")
    if removed != ["1/2", "2/2"] or "ratio\n1/2\nend" not in pages:
        raise RuntimeError("PDF page-label exclusion removed article content.")
    runner = Path(__file__).with_name("run.py")
    with tempfile.TemporaryDirectory(prefix="nefro-restore-test-") as temporary:
        root = Path(temporary)
        from unittest.mock import patch
        from pdf_assets import require_dependencies
        with patch.dict(sys.modules, {"fitz": None}):
            try:
                require_dependencies()
            except RuntimeError:
                pass
            else:
                raise RuntimeError("PDF asset review accepted missing optional dependencies.")
        from types import SimpleNamespace
        from pdf_content import compare
        import hashlib
        text_bundle = root / "pdf-text"
        (text_bundle / "pdf").mkdir(parents=True)
        entries = []
        for name in ("one", "two", "three", "four", "five"):
            raw = b"synthetic PDF input; extraction is mocked only in this control"
            (text_bundle / "pdf" / (name + ".pdf")).write_bytes(raw)
            entries.append({"path": "pdf/" + name + ".pdf", "sha256": hashlib.sha256(raw).hexdigest()})
        (text_bundle / "recovery-manifest.json").write_text(json.dumps({"recovery": {"entries": entries}}), encoding="utf-8")
        article = {"title": "Synthetic article", "content": "<p>eGFR ≥ 30; nie 45.</p>", "slug": "synthetic"}

        def text_sql(container, statement):
            if "information_schema.TABLES" in statement:
                return b"articles\n"
            return json.dumps(article).encode().hex().encode() + b"\n"

        extracted = ("NEFRO · NEFRO.POLASCIN.NET\nSynthetic article\neGFR ≥ 30; nie 45.\n"
                     "Zdroj: https://nefro.polascin.net/article.php?slug=synthetic · Nefro-projekt Slovensko. "
                     "Obsah má informačný a vzdelávací charakter a nenahrádza konzultáciu s lekárom.\n1/1\n\f")
        with patch("pdf_content.shutil.which", return_value="synthetic-pdftotext"), patch(
                "pdf_content.subprocess.run", return_value=SimpleNamespace(stdout=extracted.encode("utf-8"), stderr=b"")):
            if compare(text_sql, "synthetic", ["fixture"], text_bundle)["result"] != "PASS":
                raise RuntimeError("Controlled full-body PDF match failed.")
            article["content"] = "<p>eGFR ≥ 31; nie 45.</p>"
            if compare(text_sql, "synthetic", ["fixture"], text_bundle)["result"] != "PARTIAL":
                raise RuntimeError("Full-body PDF comparison concealed a numeric mismatch.")
            article["title"] = "Different title"
            try:
                compare(text_sql, "synthetic", ["fixture"], text_bundle)
            except RuntimeError:
                pass
            else:
                raise RuntimeError("PDF comparison accepted an unrelated header.")
        files = root / "files"
        files.mkdir()
        (files / "empty").mkdir()
        for extension, entry in [("epub", "META-INF/container.xml"), ("docx", "word/document.xml"), ("odt", "content.xml")]:
            with zipfile.ZipFile(files / ("synthetic." + extension), "w") as archive:
                archive.writestr(entry, "synthetic content")
        (files / "synthetic.pdf").write_bytes(b"%PDF-1.7\nsynthetic fixture\n%%EOF\n")
        (files / "synthetic.azw3").write_bytes(b"\0" * 60 + b"BOOKMOBI")
        backup = root / "fixture.sql.gz"
        with gzip.open(backup, "wb") as stream:
            stream.write("""CREATE DATABASE nefro_restore_fixture CHARACTER SET utf8mb4;
USE nefro_restore_fixture;
CREATE TABLE parents(id INT PRIMARY KEY, label VARCHAR(80));
INSERT INTO parents VALUES(1,'syntetická skúška'),(2,'ďalší riadok');
CREATE TABLE children(id INT PRIMARY KEY, parent_id INT, FOREIGN KEY(parent_id) REFERENCES parents(id));
INSERT INTO children VALUES(1,1);
CREATE VIEW parent_labels AS SELECT label FROM parents;
CREATE PROCEDURE count_parents() SELECT COUNT(*) FROM parents;
CREATE TRIGGER label_insert BEFORE INSERT ON parents FOR EACH ROW SET NEW.label=CONCAT('fixture ',NEW.label);
CREATE EVENT disabled_test ON SCHEDULE EVERY 1 DAY DO INSERT INTO parents VALUES(99,'must not execute');
""".encode("utf-8"))
        report = root / "report.json"
        base = [sys.executable, str(runner), "--files", str(files), "--file-image", args.file_image]
        subprocess.run(base + ["--sql", str(backup), "--report", str(report)], check=True, timeout=300)
        evidence = json.loads(report.read_text(encoding="utf-8"))
        if not (evidence["result"] == "PASS" and evidence["database_tables"] == 2
                and evidence["database_rows"] == 3 and evidence["file_count"] == 5
                and evidence["source_backups_unchanged"]):
            raise RuntimeError("Positive restore control failed.")
        # Exercise the optional application probe with fictitious encrypted records.
        fixture_identity = str(os.getuid()) + ":" + str(os.getgid()) if hasattr(os, "getuid") else "1000:1000"
        subprocess.run(["docker", "run", "--rm", "--network", "none", "--user", fixture_identity,
                        "--mount", "type=bind,source=" + str(root) + ",target=/fixture",
                        "--mount", "type=bind,source=" + str(runner.parent.resolve()) + ",target=/checks,readonly",
                        "--entrypoint", "php", args.file_image, "/checks/probe_fixture.php"], check=True, timeout=60)
        app_report = root / "application.json"
        subprocess.run(base + ["--sql", str(root / "probe.sql"), "--application-probe", "--report", str(app_report)], check=True, timeout=300)
        app = json.loads(app_report.read_text(encoding="utf-8"))["application_probe"]
        if not (app["result"] == "PASS" and app["cryptography"]["decrypted"] == 1
                and app["cryptography"]["wrong_key_rejected"] == 1
                and app["cryptography"]["tampered_rejected"] == 1
                and app["database_read_only_account"] == "PASS" and app["database_http_checks"] == 5
                and app["search_results_branch_verified"]
                and app["public_download_http_checks"] == 23):
            raise RuntimeError("Application restore control failed.")
        (files / "pdf/article.pdf").unlink()
        missing_report = root / "missing-reference.json"
        subprocess.run(base + ["--sql", str(root / "probe.sql"), "--application-probe", "--report", str(missing_report)], check=True, timeout=300)
        app = json.loads(missing_report.read_text(encoding="utf-8"))["application_probe"]
        if not (app["result"] == "FAIL" and app["references"]["article_pdfs"]["missing_or_unsafe"] == 1):
            raise RuntimeError("Missing database/file reference was accepted.")
        donor = root / "donor"
        (donor / "pdf").mkdir(parents=True)
        (donor / "img").mkdir()
        shutil.copyfile(files / "synthetic.pdf", donor / "pdf/article.pdf")
        (donor / "img/recovery.png").write_bytes(base64.b64decode("iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aE1sAAAAASUVORK5CYII="))
        (donor / "must-not-copy.ini").write_text("synthetic unwanted source", encoding="utf-8")
        recovery_sql = root / "recovery.sql"
        recovery_sql.write_bytes((root / "probe.sql").read_bytes().replace(b'<img src="img/fixture.svg">', b'<img src="img/fixture.svg"><img src="img/recovery.png">'))
        recovered_report = root / "recovered.json"
        bundle = root / "recovered-assets"
        subprocess.run(base + ["--sql", str(recovery_sql), "--application-probe", "--recovery-source", str(donor),
                              "--recovery-bundle", str(bundle), "--report", str(recovered_report)], check=True, timeout=300)
        recovered = json.loads(recovered_report.read_text(encoding="utf-8"))
        if not (recovered["result"] == "PASS" and recovered["recovery_working_copy"]["supplement_count"] == 2
                and recovered["recovery_working_copy"]["original_restored_files_overwritten"] == 0
                and not (files / "pdf/article.pdf").exists() and not (files / "img/recovery.png").exists()
                and not (bundle / "must-not-copy.ini").exists() and recovered["source_backups_unchanged"]):
            raise RuntimeError("Additive recovery changed its source or failed consistency checks.")
        from recovery import prepare
        from unittest.mock import patch
        plain_payload = {"article_pdfs": ["pdf/article.pdf"], "article_images": []}
        with patch("recovery.shutil.which", return_value=None):
            plain = prepare(plain_payload, {}, donor, root / "without-git", 768)
        if not (plain[0]["last_source_commit"] is None and plain[0]["matches_git_head_blob"] is None):
            raise RuntimeError("Recovery without optional Git failed.")
        git = shutil.which("git")
        if git:
            nested_repo = root / "source-repository"
            nested_source = nested_repo / "assets"
            (nested_source / "pdf").mkdir(parents=True)
            shutil.copyfile(donor / "pdf/article.pdf", nested_source / "pdf/article.pdf")
            subprocess.run([git, "init", "--quiet", str(nested_repo)], check=True)
            subprocess.run([git, "-C", str(nested_repo), "add", "--", "assets/pdf/article.pdf"], check=True)
            subprocess.run([git, "-C", str(nested_repo), "-c", "user.name=SyntheticFixture", "-c",
                            "user.email=fixture@example.invalid", "commit", "--quiet", "-m", "Synthetic recovery source"], check=True)
            nested = prepare(plain_payload, {}, nested_source, root / "from-git-subdirectory", 768)
            if not (nested[0]["last_source_commit"] and nested[0]["matches_git_head_blob"] is True):
                raise RuntimeError("Recovery Git provenance resolved the wrong directory.")
        for relative in ("../escape.pdf", "/pdf/article.pdf", "img/../escape.png", "img/unwanted.php"):
            rejected_bundle = root / "forbidden-recovery"
            try:
                prepare({"article_pdfs": [relative], "article_images": []}, {}, donor, rejected_bundle, 768)
            except RuntimeError:
                pass
            else:
                raise RuntimeError("Unsafe recovery path was accepted.")
            if rejected_bundle.exists():
                raise RuntimeError("Rejected recovery created an output directory.")
        shutil.copyfile(files / "synthetic.pdf", files / "pdf/article.pdf")
        (files / "private/nefro.env.ini").write_text("DATA_PROTECTION_KEY=wrong-synthetic-fixture-key\n", encoding="utf-8")
        wrong_key_report = root / "wrong-key.json"
        subprocess.run(base + ["--sql", str(root / "probe.sql"), "--application-probe", "--report", str(wrong_key_report)], check=True, timeout=300)
        app = json.loads(wrong_key_report.read_text(encoding="utf-8"))["application_probe"]
        if not (app["result"] == "FAIL" and app["cryptography"]["failed"] == 1
                and app["cryptography"]["decrypted"] == 0):
            raise RuntimeError("Wrong archived key was accepted.")
        (files / "private/nefro.env.ini").write_text("DATA_PROTECTION_KEY=synthetic-restore-fixture-key\n", encoding="utf-8")
        (files / "search.php").unlink()
        endpoint_report = root / "missing-endpoint.json"
        subprocess.run(base + ["--sql", str(root / "probe.sql"), "--application-probe", "--report", str(endpoint_report)], check=True, timeout=300)
        app = json.loads(endpoint_report.read_text(encoding="utf-8"))["application_probe"]
        if not (app["result"] == "FAIL" and app["probe_error_stage"].startswith("missing_required_endpoint_")):
            raise RuntimeError("Missing required application endpoint was accepted.")
        # Remove synthetic application additions before the original five-file tests.
        for path in list(files.iterdir()):
            if path.name not in {"empty", "synthetic.epub", "synthetic.docx", "synthetic.odt", "synthetic.pdf", "synthetic.azw3"}:
                if path.is_dir():
                    if not path.resolve().is_relative_to(root.resolve()):
                        raise RuntimeError("Synthetic cleanup path escaped its temporary workspace.")
                    shutil.rmtree(path)
                else:
                    path.unlink()
        # A corrupt database backup must never produce a successful report.
        invalid = root / "invalid.sql"
        invalid.write_text("THIS IS NOT SQL;\n", encoding="utf-8")
        rejected_report = root / "must-not-exist.json"
        result = subprocess.run(base + ["--sql", str(invalid), "--report", str(rejected_report)],
                                stdout=subprocess.PIPE, stderr=subprocess.PIPE, timeout=300, check=False)
        if result.returncode == 0 or rejected_report.exists():
            raise RuntimeError("Invalid SQL was accepted.")
        # UTF-8 names and empty directories must survive ZIP extraction unchanged.
        unicode_zip = root / "unicode.zip"
        with zipfile.ZipFile(unicode_zip, "w") as archive:
            archive.writestr("prázdny/", b"")
            archive.writestr("údaje/skúška.txt", "syntetická skúška")
        unicode_report = root / "unicode.json"
        subprocess.run([sys.executable, str(runner), "--files", str(unicode_zip),
                        "--files-only", "--file-image", args.file_image,
                        "--report", str(unicode_report)], check=True, timeout=300)
        evidence = json.loads(unicode_report.read_text(encoding="utf-8"))
        if not (evidence["result"] == "PASS" and evidence["verification_scope"] == "files_only"
                and evidence["database_round_trip"] == "NOT_RUN"
                and evidence["database_tables"] is None and evidence["file_count"] == 1
                and evidence["directory_count"] == 2):
            raise RuntimeError("UTF-8 ZIP or files-only control failed.")
        # Invalid source publications must be reported separately from byte recovery.
        (files / "synthetic.epub").write_bytes(b"truncated archive")
        zipped_backup = root / "fixture.zip"
        with zipfile.ZipFile(zipped_backup, "w") as archive:
            archive.writestr("fixture.sql.gz", backup.read_bytes())
        partial = root / "partial.json"
        file_archive = root / "files.zip"
        with zipfile.ZipFile(file_archive, "w") as archive:
            for path in files.rglob("*"):
                archive.write(path, path.relative_to(files).as_posix())
        zip_base = [sys.executable, str(runner), "--files", str(file_archive), "--file-image", args.file_image]
        subprocess.run(zip_base + ["--sql", str(zipped_backup), "--report", str(partial)], check=True, timeout=300)
        evidence = json.loads(partial.read_text(encoding="utf-8"))
        if not (evidence["result"] == "PARTIAL" and evidence["file_restore"] == "PASS"
                and evidence["file_format_validation"] == "FAIL"
                and evidence["format_checks"]["failures"] == {".epub": 1}
                and evidence["directory_count"] == 1 and evidence["file_backup_archive_sha256"]):
            raise RuntimeError("Corrupt publication was not identified.")
        for label in ("traversal", "symlink", "crc"):
            unsafe = root / (label + ".zip")
            with zipfile.ZipFile(unsafe, "w") as archive:
                if label == "traversal":
                    archive.writestr("../escaped.txt", "must not escape")
                elif label == "symlink":
                    item = zipfile.ZipInfo("link")
                    item.create_system = 3
                    item.external_attr = (stat.S_IFLNK | 0o777) << 16
                    archive.writestr(item, "/etc/passwd")
                else:
                    archive.writestr("payload.txt", "known synthetic content")
            if label == "crc":
                data = bytearray(unsafe.read_bytes())
                data[30 + len("payload.txt")] ^= 1
                unsafe.write_bytes(data)
            forbidden_report = root / (label + ".json")
            result = subprocess.run(
                [sys.executable, str(runner), "--files", str(unsafe), "--synthetic-database",
                 "--file-image", args.file_image, "--report", str(forbidden_report)],
                stdout=subprocess.PIPE, stderr=subprocess.PIPE, check=False, timeout=30,
            )
            if result.returncode == 0 or forbidden_report.exists() or (root / "escaped.txt").exists():
                raise RuntimeError("Unsafe or damaged file ZIP was accepted.")
    print("Restore self-test PASS: archives, schema objects, UTF-8, invalid SQL, corrupt EPUB, ZIP security, application HTTP, additive recovery, read-only DB, missing reference and wrong-key rejection.")


if __name__ == "__main__":
    main()
