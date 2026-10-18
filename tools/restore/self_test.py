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
    runner = Path(__file__).with_name("run.py")
    with tempfile.TemporaryDirectory(prefix="nefro-restore-test-") as temporary:
        root = Path(temporary)
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
