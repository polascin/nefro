"""Exercise the restore drill with synthetic archives and a real MariaDB dump."""

import argparse
import gzip
import json
from pathlib import Path
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
        # A corrupt database backup must never produce a successful report.
        invalid = root / "invalid.sql"
        invalid.write_text("THIS IS NOT SQL;\n", encoding="utf-8")
        rejected_report = root / "must-not-exist.json"
        result = subprocess.run(base + ["--sql", str(invalid), "--report", str(rejected_report)],
                                stdout=subprocess.PIPE, stderr=subprocess.PIPE, timeout=300, check=False)
        if result.returncode == 0 or rejected_report.exists():
            raise RuntimeError("Invalid SQL was accepted.")
        # Invalid source publications must be reported separately from byte recovery.
        (files / "synthetic.epub").write_bytes(b"truncated archive")
        partial = root / "partial.json"
        subprocess.run(base + ["--sql", str(backup), "--report", str(partial)], check=True, timeout=300)
        evidence = json.loads(partial.read_text(encoding="utf-8"))
        if not (evidence["result"] == "PARTIAL" and evidence["file_restore"] == "PASS"
                and evidence["file_format_validation"] == "FAIL"
                and evidence["format_checks"]["failures"] == {".epub": 1}):
            raise RuntimeError("Corrupt publication was not identified.")
    print("Restore self-test PASS: SQL.gz, Unicode, foreign key, view, routine, trigger, disabled event, five file formats, invalid SQL and corrupt EPUB.")


if __name__ == "__main__":
    main()
