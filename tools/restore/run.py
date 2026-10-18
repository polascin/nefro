"""Offline restore drill. Never starts application code or connects to a remote DB."""

import argparse
import gzip
import hashlib
import json
import os
from pathlib import Path
import secrets
import subprocess
import time
import zipfile
from datetime import datetime, timezone


DB_IMAGE = "mariadb:11.4.13@sha256:250e1609e93c0e6aecf64bfbab2d84d5e89d2481540fe77447ff6c855c3b1873"
SYSTEM_DATABASES = {"mysql", "sys", "information_schema", "performance_schema"}


def run(arguments, *, data=None, environment=None):
    result = subprocess.run(
        arguments, input=data, stdout=subprocess.PIPE, stderr=subprocess.PIPE,
        env=environment, check=False, timeout=600,
    )
    if result.returncode:
        # Database errors can contain personal data or SQL literals.
        raise RuntimeError("Command failed (" + " ".join(arguments[:2]) + "); raw output was withheld.")
    return result.stdout


def digest(path):
    with path.open("rb") as stream:
        return hashlib.file_digest(stream, "sha256").hexdigest()


def files_manifest(root):
    result = {}
    for path in sorted(root.rglob("*")):
        if path.is_symlink():
            raise RuntimeError("Symlinks are not accepted in the file backup.")
        if path.is_file():
            result[path.relative_to(root).as_posix()] = (path.stat().st_size, digest(path))
    if not result:
        raise RuntimeError("The file backup is empty.")
    return result


def validate_formats(root):
    failures = {}
    failed_hashes = []
    checked = 0
    for path in root.rglob("*"):
        if path.is_file() and path.suffix.lower() in {".epub", ".docx", ".odt", ".pdf", ".azw3"}:
            checked += 1
            try:
                validate_file_format(path)
            except (RuntimeError, zipfile.BadZipFile):
                extension = path.suffix.lower()
                failures[extension] = failures.get(extension, 0) + 1
                failed_hashes.append({"format": extension, "sha256": digest(path)})
    return {"checked": checked, "failures": failures, "failed_file_sha256": failed_hashes}


def validate_file_format(file_path):
    suffix = file_path.suffix.lower()
    if suffix in {".epub", ".docx", ".odt"}:
        with zipfile.ZipFile(file_path) as archive:
            if archive.testzip() is not None:
                raise RuntimeError("A publication archive failed its CRC check.")
            required = {".epub": "META-INF/container.xml", ".docx": "word/document.xml", ".odt": "content.xml"}
            if required[suffix] not in archive.namelist():
                raise RuntimeError("A publication archive is missing required content.")
    elif suffix == ".pdf":
        with file_path.open("rb") as stream:
            if stream.read(5) != b"%PDF-":
                raise RuntimeError("Invalid PDF header.")
            stream.seek(max(0, file_path.stat().st_size - 2048))
            if b"%%EOF" not in stream.read():
                raise RuntimeError("Missing PDF end marker.")
    elif suffix == ".azw3":
        with file_path.open("rb") as stream:
            stream.seek(60)
            if stream.read(8) != b"BOOKMOBI":
                raise RuntimeError("Invalid AZW3 container header.")


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--files", type=Path, required=True, help="Existing backup directory (read only).")
    source = parser.add_mutually_exclusive_group(required=True)
    source.add_argument("--sql", type=Path, help="Existing SQL or SQL.gz backup; never an app config.")
    source.add_argument("--synthetic-database", action="store_true")
    parser.add_argument("--file-image", required=True, help="Locally built integration PHP image; pinned to ID before use.")
    parser.add_argument("--report", type=Path, required=True)
    args = parser.parse_args()
    if args.files.is_symlink():
        raise RuntimeError("Symlink backup roots are not accepted.")
    files = args.files.resolve(strict=True)
    if not files.is_dir() or files.is_symlink():
        raise RuntimeError("Expected a regular backup directory.")
    if args.report.exists():
        raise RuntimeError("Refusing to overwrite an existing report.")
    if args.report.resolve().is_relative_to(files):
        raise RuntimeError("Reports must be written outside the source backup.")
    before = files_manifest(files)
    format_count = validate_formats(files)
    image_id = run(["docker", "image", "inspect", args.file_image, "--format", "{{.Id}}"] ).decode().strip()
    # Resolve everything before containers start. No production configuration is loaded.
    sql_path = args.sql.resolve(strict=True) if args.sql else None
    if sql_path and (not sql_path.is_file() or sql_path.suffix not in {".sql", ".gz"}):
        raise RuntimeError("Expected a SQL or gzip SQL file.")
    sql_hash = digest(sql_path) if sql_path else None
    token = secrets.token_hex(8)
    password = secrets.token_urlsafe(32)
    environment = dict(os.environ, MARIADB_ROOT_PASSWORD=password, MYSQL_PWD=password)
    containers = []
    started = time.monotonic()

    def create_db(label):
        name = "nefro-restore-" + token + "-" + label
        containers.append(name)
        run(["docker", "run", "--detach", "--name", name,
             "--label", "nefro.restore.run=" + token,
             "--network", "none", "--security-opt", "no-new-privileges:true",
             "--tmpfs", "/var/lib/mysql:rw,nosuid,nodev,size=768m",
             "--env", "MARIADB_ROOT_PASSWORD", DB_IMAGE,
             "--skip-networking", "--event-scheduler=OFF", "--local-infile=0"], environment=environment)
        for _ in range(90):
            result = subprocess.run(
                ["docker", "exec", "--env", "MYSQL_PWD", name, "mariadb", "-uroot", "--execute", "SELECT 1"],
                env=environment, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL,
                timeout=10, check=False,
            )
            if result.returncode == 0:
                return name
            time.sleep(1)
        raise RuntimeError("Isolated database did not become ready.")

    def sql(container, statement=None, data=None):
        command = ["docker", "exec", "--interactive", "--env", "MYSQL_PWD", container,
                   "mariadb", "-uroot", "--batch", "--skip-column-names", "--binary-mode=1", "--local-infile=0"]
        if statement is not None:
            command += ["--execute", statement]
        return run(command, data=data, environment=environment)

    def inventory(container):
        flags = sql(container, "SELECT @@skip_networking,@@event_scheduler,@@local_infile").decode().strip()
        if flags != "1\tOFF\t0":
            raise RuntimeError("Database network, event or file-import isolation changed.")
        rows = sql(container, "SELECT TABLE_SCHEMA,TABLE_NAME,TABLE_TYPE FROM information_schema.TABLES ORDER BY TABLE_SCHEMA,TABLE_NAME").decode().splitlines()
        signatures = []
        count = 0
        row_count = 0
        databases = set()
        for row in rows:
            database, table, kind = row.split("\t")
            if database in SYSTEM_DATABASES:
                continue
            databases.add(database)
            quoted = "`" + database.replace("`", "``") + "`.`" + table.replace("`", "``") + "`"
            if kind == "BASE TABLE":
                checks = sql(container, "CHECK TABLE " + quoted).decode().splitlines()
                if not checks or any(not line.endswith("\tstatus\tOK") for line in checks):
                    raise RuntimeError("Restored table integrity check failed.")
                amount = int(sql(container, "SELECT COUNT(*) FROM " + quoted))
                checksum = sql(container, "CHECKSUM TABLE " + quoted + " EXTENDED").decode().strip().split("\t")[-1]
                if checksum == "NULL":
                    raise RuntimeError("Table checksum unavailable.")
                signatures.append([database, table, kind, amount, checksum])
                count += 1
                row_count += amount
            else:
                signatures.append([database, table, kind])
        if not count:
            raise RuntimeError("No application tables were restored.")
        signature = hashlib.sha256(json.dumps(signatures, sort_keys=True).encode()).hexdigest()
        return sorted(databases), count, row_count, signature

    def schema(container, databases):
        content = run(["docker", "exec", "--env", "MYSQL_PWD", container,
                       "mariadb-dump", "-uroot", "--no-data", "--skip-comments",
                       "--routines", "--events", "--databases", *databases], environment=environment)
        return hashlib.sha256(content).hexdigest()

    try:
        # Only the existing file backup is mounted. Restored files are never executed.
        file_container = "nefro-restore-" + token + "-files"
        containers.append(file_container)
        run(["docker", "run", "--detach", "--name", file_container,
             "--label", "nefro.restore.run=" + token,
             "--network", "none", "--read-only", "--cap-drop", "ALL",
             "--security-opt", "no-new-privileges:true", "--user", "1000:1000",
             "--tmpfs", "/restore:rw,nosuid,nodev,noexec,uid=1000,gid=1000,mode=0700,size=768m",
             "--mount", "type=bind,source=" + str(files) + ",target=/input,readonly",
             "--entrypoint", "sh", image_id, "-ec", "cp -R /input/. /restore/; exec sleep 600"])
        # Wait for the copy before hashing it; no restored content leaves tmpfs.
        for _ in range(90):
            command = run(["docker", "exec", file_container, "cat", "/proc/1/comm"]).strip()
            if command == b"sleep":
                break
            time.sleep(1)
        else:
            raise RuntimeError("Isolated file restore did not finish.")
        manifest_php = '$root="/restore/"; $out=[]; $it=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root,FilesystemIterator::SKIP_DOTS)); foreach($it as $file){if($file->isFile()){$out[substr($file->getPathname(),strlen($root))]=[$file->getSize(),hash_file("sha256",$file->getPathname())];}} echo json_encode($out,JSON_THROW_ON_ERROR);'
        restored = json.loads(run(["docker", "exec", file_container, "php", "-r", manifest_php]))
        restored = {name: tuple(value) for name, value in restored.items()}
        if restored != before:
            raise RuntimeError("Restored file content does not match the backup.")
        file_elapsed = round(time.monotonic() - started, 3)
        first = create_db("import")
        if sql_path:
            opener = gzip.open if sql_path.suffix == ".gz" else open
            with opener(sql_path, "rb") as stream:
                sql(first, data=stream.read())
        else:
            sql(first, data=b"CREATE DATABASE nefro_restore_synthetic CHARACTER SET utf8mb4; USE nefro_restore_synthetic; CREATE TABLE users(id INT PRIMARY KEY, label VARCHAR(80)); INSERT INTO users VALUES(1,'synthetic account'); CREATE TABLE articles(id INT PRIMARY KEY, body TEXT); INSERT INTO articles VALUES(1,'synthetic article'); CREATE TABLE calculator_results(id INT PRIMARY KEY, value DECIMAL(10,2)); INSERT INTO calculator_results VALUES(1,42.50);")
        expected = inventory(first)
        schema_hash = schema(first, expected[0])
        dump = run(["docker", "exec", "--env", "MYSQL_PWD", first,
                    "mariadb-dump", "-uroot", "--single-transaction", "--hex-blob",
                    "--routines", "--events", "--databases", *expected[0]], environment=environment)
        second = create_db("restore")
        sql(second, data=dump)
        if inventory(second) != expected:
            raise RuntimeError("Database restore differs from the imported backup.")
        if schema(second, expected[0]) != schema_hash:
            raise RuntimeError("Restored schema, views or stored routines differ.")
        if files_manifest(files) != before or (sql_path and digest(sql_path) != sql_hash):
            raise RuntimeError("Source backup changed during the drill.")
        # Fail if Docker has attached a network or published a port.
        for name in containers:
            info = json.loads(run(["docker", "inspect", name]))[0]
            if info["HostConfig"]["NetworkMode"] != "none" or info["HostConfig"].get("PortBindings"):
                raise RuntimeError("Container isolation verification failed.")
            if name == file_container:
                mounts = info["Mounts"]
                if not any(item["Destination"] == "/input" and not item["RW"] for item in mounts):
                    raise RuntimeError("Source file backup is not mounted read only.")
        report = {
            "timestamp_utc": datetime.now(timezone.utc).isoformat(),
            "result": "PASS" if sql_path and not format_count["failures"] else "PARTIAL",
            "file_restore": "PASS",
            "file_format_validation": "FAIL" if format_count["failures"] else "PASS",
            "database_round_trip": "PASS",
            "network_mode": "none", "published_ports": 0,
            "source_mount_read_only": True,
            "database_tcp_and_events_disabled": True,
            "restore_containers_removed": True,
            "existing_database_backup_restore_verified": bool(sql_path),
            "database_source": "existing_backup" if sql_path else "synthetic_fixture_only",
            "database_backup_sha256": sql_hash,
            "database_tables": expected[1], "database_rows": expected[2],
            "database_inventory_sha256": expected[3],
            "database_schema_sha256": schema_hash,
            "file_count": len(before), "file_bytes": sum(item[0] for item in before.values()),
            "file_manifest_sha256": hashlib.sha256(json.dumps(before, sort_keys=True).encode()).hexdigest(),
            "format_checks": format_count, "file_restore_seconds": file_elapsed,
            "total_seconds": round(time.monotonic() - started, 3),
            "source_backups_unchanged": True, "file_image_id": image_id,
            "database_image": DB_IMAGE,
            "limits": ["File scope is only the supplied directory.", "No application, visual, decryption or full disaster recovery validation."],
        }
        # Publish PASS only after all owned containers and tmpfs data are removed.
    finally:
        cleanup_failed = False
        for name in reversed(containers):
            inspection = subprocess.run(["docker", "inspect", name], stdout=subprocess.PIPE,
                                        stderr=subprocess.DEVNULL, timeout=60, check=False)
            if inspection.returncode != 0:
                cleanup_failed = True
                continue
            owner = json.loads(inspection.stdout)[0]["Config"].get("Labels") or {}
            if owner.get("nefro.restore.run") != token:
                cleanup_failed = True
                continue
            outcome = subprocess.run(["docker", "rm", "--force", name], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL, timeout=60, check=False)
            cleanup_failed |= outcome.returncode != 0
        if cleanup_failed:
            raise RuntimeError("Restore container cleanup failed; no success report was written.")
    args.report.parent.mkdir(parents=True, exist_ok=True)
    with args.report.open("x", encoding="utf-8") as output:
        output.write(json.dumps(report, ensure_ascii=False, indent=2) + "\n")
    print(json.dumps(report, ensure_ascii=False))


if __name__ == "__main__":
    try:
        main()
    except RuntimeError as error:
        raise SystemExit("Restore drill FAILED: " + str(error)) from None
    except (OSError, ValueError, zipfile.BadZipFile, subprocess.TimeoutExpired):
        raise SystemExit("Restore drill FAILED; no successful result may be inferred. Raw data was withheld.")
