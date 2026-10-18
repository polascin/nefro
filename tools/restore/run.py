"""Offline restore drill. Archived application checks require an explicit opt-in; no remote DB."""

import argparse
import gzip
import hashlib
import io
import json
import os
from pathlib import Path, PurePosixPath
import re
import secrets
import subprocess
import stat
import tarfile
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
        code = re.search(rb"ERROR\s+(\d+)", result.stderr)
        detail = " SQL error " + code[1].decode() if code else ""
        detail += " " + next((item for item in ("cat", "php", "mariadb", "mariadb-dump", "tar") if item in arguments), "")
        if "/checks/application_probe.php" in arguments:
            location = re.search(rb"on line (\d+)", result.stderr)
            detail += " application probe" + (" line " + location[1].decode() if location else "")
        raise RuntimeError("Command failed (" + " ".join(arguments[:2]) + ")" + detail + "; raw output was withheld.")
    return result.stdout


def digest(path):
    with path.open("rb") as stream:
        return hashlib.file_digest(stream, "sha256").hexdigest()


def files_manifest(root):
    if root.is_file():
        result = {}
        with zipfile.ZipFile(root) as archive:
            for item in checked_members(archive):
                if not item.is_dir():
                    with archive.open(item) as stream:
                        result[item.filename.rstrip("/")] = (item.file_size, hashlib.file_digest(stream, "sha256").hexdigest())
        if not result:
            raise RuntimeError("The file backup is empty.")
        return result
    result = {}
    for path in sorted(root.rglob("*")):
        if path.is_symlink():
            raise RuntimeError("Symlinks are not accepted in the file backup.")
        if path.is_file():
            result[path.relative_to(root).as_posix()] = (path.stat().st_size, digest(path))
    if not result:
        raise RuntimeError("The file backup is empty.")
    return result


def checked_members(archive):
    members = archive.infolist()
    if len(members) > 100000 or sum(item.file_size for item in members) > 8 * 1024**3:
        raise RuntimeError("ZIP exceeds the restore size or entry limit.")
    seen = set()
    for item in members:
        path = PurePosixPath(item.filename)
        name = item.filename.rstrip("/")
        mode = item.external_attr >> 16
        if (not name or name == "." or path.is_absolute() or ".." in path.parts
                or "\\" in item.filename or ":" in item.filename
                or any(ord(character) < 32 for character in item.filename)
                or name != path.as_posix() or name in seen
                or stat.S_ISLNK(mode) or (stat.S_IFMT(mode) not in {0, stat.S_IFREG, stat.S_IFDIR})
                or item.flag_bits & 1):
            raise RuntimeError("Unsafe, duplicate, encrypted or special ZIP entry rejected.")
        seen.add(name)
    return members


def directory_manifest(root):
    if root.is_dir():
        return {path.relative_to(root).as_posix() for path in root.rglob("*") if path.is_dir()}
    result = set()
    with zipfile.ZipFile(root) as archive:
        for item in checked_members(archive):
            path = PurePosixPath(item.filename)
            if item.is_dir():
                result.add(path.as_posix())
            result.update(parent.as_posix() for parent in path.parents if parent.as_posix() != ".")
    return result


def validate_formats(root):
    failures = {}
    failed_hashes = []
    checked = 0
    if root.is_file():
        with zipfile.ZipFile(root) as archive:
            for item in checked_members(archive):
                extension = PurePosixPath(item.filename).suffix.lower()
                if not item.is_dir() and extension in {".epub", ".docx", ".odt", ".pdf", ".azw3"}:
                    checked += 1
                    try:
                        with archive.open(item) as stream:
                            if extension in {".epub", ".docx", ".odt"}:
                                # Nested ZIP readers seek repeatedly; buffer one document in RAM.
                                with io.BytesIO(stream.read()) as buffered:
                                    validate_format_stream(extension, buffered, item.file_size)
                            else:
                                validate_format_stream(extension, stream, item.file_size)
                    except (RuntimeError, zipfile.BadZipFile):
                        failures[extension] = failures.get(extension, 0) + 1
                        with archive.open(item) as stream:
                            failed_hashes.append({"format": extension, "bytes": item.file_size,
                                                  "sha256": hashlib.file_digest(stream, "sha256").hexdigest()})
        return {"checked": checked, "failures": failures, "failed_file_sha256": failed_hashes}
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
    with file_path.open("rb") as stream:
        validate_format_stream(file_path.suffix.lower(), stream, file_path.stat().st_size)


def validate_format_stream(suffix, stream, size):
    if suffix in {".epub", ".docx", ".odt"}:
        with zipfile.ZipFile(stream) as archive:
            if len(archive.infolist()) > 100000 or sum(item.file_size for item in archive.infolist()) > 8 * 1024**3:
                raise RuntimeError("Publication archive exceeds format-validation limits.")
            if archive.testzip() is not None:
                raise RuntimeError("A publication archive failed its CRC check.")
            required = {".epub": "META-INF/container.xml", ".docx": "word/document.xml", ".odt": "content.xml"}
            if required[suffix] not in archive.namelist():
                raise RuntimeError("A publication archive is missing required content.")
    elif suffix == ".pdf":
        if stream.read(5) != b"%PDF-":
            raise RuntimeError("Invalid PDF header.")
        stream.seek(max(0, size - 2048))
        if b"%%EOF" not in stream.read():
            raise RuntimeError("Missing PDF end marker.")
    elif suffix == ".azw3":
        stream.seek(60)
        if stream.read(8) != b"BOOKMOBI":
            raise RuntimeError("Invalid AZW3 container header.")


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--files", type=Path, required=True, help="Existing backup directory or ZIP (read only).")
    parser.add_argument("--file-memory-mib", type=int, default=768, help="File restore tmpfs limit, 128..8192 MiB.")
    parser.add_argument("--application-probe", action="store_true", help="Opt in to archived helper, HTTP, reference and TOTP checks in the offline container.")
    parser.add_argument("--pdf-content-bundle", type=Path, help="Compare recovered PDF text against articles in the restored SQL backup.")
    parser.add_argument("--recovery-source", type=Path, help="Read-only source of missing public article assets; never overwrites restored files.")
    parser.add_argument("--recovery-bundle", type=Path, help="New local directory retaining only the supplemental public assets.")
    source = parser.add_mutually_exclusive_group(required=True)
    source.add_argument("--sql", type=Path, help="Existing SQL, SQL.gz or single-SQL ZIP backup; never an app config.")
    source.add_argument("--synthetic-database", action="store_true")
    source.add_argument("--files-only", action="store_true", help="Verify only files; do not start MariaDB.")
    parser.add_argument("--file-image", required=True, help="Locally built integration PHP image; pinned to ID before use.")
    parser.add_argument("--report", type=Path, required=True)
    args = parser.parse_args()
    if args.pdf_content_bundle and not args.sql:
        raise RuntimeError("PDF content comparison requires an existing SQL backup.")
    if args.application_probe and args.synthetic_database:
        raise RuntimeError("Application checks require an existing DB backup or explicit files-only scope.")
    if bool(args.recovery_source) != bool(args.recovery_bundle) or (args.recovery_source and (not args.application_probe or not args.sql)):
        raise RuntimeError("Recovery needs both source and new bundle, an existing SQL backup and the application probe.")
    if args.files.is_symlink():
        raise RuntimeError("Symlink backup roots are not accepted.")
    files = args.files.resolve(strict=True)
    if not files.is_dir() and not (files.is_file() and files.suffix.lower() == ".zip"):
        raise RuntimeError("Expected a regular backup directory or ZIP.")
    if not 128 <= args.file_memory_mib <= 8192:
        raise RuntimeError("File memory limit must be 128..8192 MiB.")
    if args.report.exists():
        raise RuntimeError("Refusing to overwrite an existing report.")
    if args.report.resolve().is_relative_to(files):
        raise RuntimeError("Reports must be written outside the source backup.")
    before = files_manifest(files)
    directories_before = directory_manifest(files)
    archive_hash = digest(files) if files.is_file() else None
    if sum(item[0] for item in before.values()) * 1.15 + 64 * 1024**2 > args.file_memory_mib * 1024**2:
        raise RuntimeError("File backup exceeds the selected tmpfs budget; increase --file-memory-mib explicitly.")
    format_count = validate_formats(files)
    image_id = run(["docker", "image", "inspect", args.file_image, "--format", "{{.Id}}"] ).decode().strip()
    # Resolve everything before containers start. No production configuration is loaded.
    sql_path = args.sql.resolve(strict=True) if args.sql else None
    if sql_path and (not sql_path.is_file() or sql_path.suffix not in {".sql", ".gz", ".zip"}):
        raise RuntimeError("Expected a SQL, gzip SQL or single-SQL ZIP file.")
    sql_hash = digest(sql_path) if sql_path else None
    token = secrets.token_hex(8)
    password = secrets.token_urlsafe(32)
    environment = dict(os.environ, MARIADB_ROOT_PASSWORD=password, MYSQL_PWD=password)
    containers = []
    socket_volume = "nefro-restore-" + token + "-socket" if args.application_probe and not args.files_only else None
    socket_created = False
    started = time.monotonic()

    def create_db(label):
        name = "nefro-restore-" + token + "-" + label
        containers.append(name)
        run(["docker", "run", "--detach", "--name", name,
             "--label", "nefro.restore.run=" + token,
             "--network", "none", "--security-opt", "no-new-privileges:true",
             "--tmpfs", "/var/lib/mysql:rw,nosuid,nodev,size=768m",
             *(["--mount", "type=volume,source=" + socket_volume + ",target=/run/mysqld"] if socket_volume and label == "import" else []),
             "--env", "MARIADB_ROOT_PASSWORD", DB_IMAGE,
             "--skip-networking", "--event-scheduler=OFF", "--local-infile=0"], environment=environment)
        for _ in range(90):
            # The bootstrap socket can accept SQL before entrypoint restarts MariaDB.
            process = subprocess.run(
                ["docker", "exec", name, "cat", "/proc/1/comm"],
                stdout=subprocess.PIPE, stderr=subprocess.DEVNULL, timeout=10, check=False,
            )
            if process.returncode != 0 or process.stdout.strip() != b"mariadbd":
                time.sleep(1)
                continue
            result = subprocess.run(
                ["docker", "exec", "--env", "MYSQL_PWD", name, "mariadb", "-uroot", "--execute", "SELECT 1"],
                env=environment, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL,
                timeout=10, check=False,
            )
            if result.returncode == 0:
                return name
            time.sleep(1)
        raise RuntimeError("Isolated database did not become ready.")

    def sql(container, statement=None, data=None, database=None):
        command = ["docker", "exec", "--interactive", "--env", "MYSQL_PWD", container,
                   "mariadb", "-uroot", "--batch", "--skip-column-names", "--binary-mode=1", "--local-infile=0"]
        if statement is not None:
            command += ["--execute", statement]
        if database is not None:
            command += ["--database", database]
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
        if socket_volume:
            run(["docker", "volume", "create", "--label", "nefro.restore.run=" + token, socket_volume])
            socket_created = True
        # The source is read only; archived code runs only in the optional offline probe.
        file_container = "nefro-restore-" + token + "-files"
        containers.append(file_container)
        run(["docker", "run", "--detach", "--name", file_container,
             "--label", "nefro.restore.run=" + token,
             "--network", "none", "--read-only", "--cap-drop", "ALL",
             "--security-opt", "no-new-privileges:true", "--user", "1000:1000",
             "--tmpfs", f"/restore:rw,nosuid,nodev,noexec,uid=1000,gid=1000,mode=0700,size={args.file_memory_mib}m",
             "--mount", "type=bind,source=" + str(files) + ",target=/input,readonly",
             *(["--mount", "type=bind,source=" + str(Path(__file__).resolve().parent) + ",target=/checks,readonly"] if args.application_probe else []),
             *(["--mount", "type=volume,source=" + socket_volume + ",target=/run/mysqld,readonly"] if socket_volume else []),
             "--entrypoint", "sh", image_id, "-ec",
             ("true" if files.is_file() else "cp -R /input/. /restore/") + "; exec sleep 900"])
        # Wait for the copy before hashing it; no restored content leaves tmpfs.
        for _ in range(600):
            command = run(["docker", "exec", file_container, "cat", "/proc/1/comm"]).strip()
            if command == b"sleep":
                break
            time.sleep(1)
        else:
            raise RuntimeError("Isolated file restore did not finish.")
        if files.is_file():
            # Stream validated ZIP entries as UTF-8 tar: Info-ZIP can recode names.
            process = subprocess.Popen(
                ["docker", "exec", "-i", file_container, "tar", "-xf", "-", "-C", "/restore", "--no-same-owner"],
                stdin=subprocess.PIPE, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL,
            )
            try:
                with zipfile.ZipFile(files) as archive, tarfile.open(fileobj=process.stdin, mode="w|", format=tarfile.PAX_FORMAT) as target:
                    for item in checked_members(archive):
                        entry = tarfile.TarInfo(item.filename.rstrip("/"))
                        entry.mode = 0o700 if item.is_dir() else 0o600
                        entry.type = tarfile.DIRTYPE if item.is_dir() else tarfile.REGTYPE
                        entry.size = 0 if item.is_dir() else item.file_size
                        if item.is_dir():
                            target.addfile(entry)
                        else:
                            with archive.open(item) as content:
                                target.addfile(entry, content)
                process.stdin.close()
                if process.wait(timeout=600):
                    raise RuntimeError("Isolated ZIP extraction failed; raw output was withheld.")
            finally:
                if process.poll() is None:
                    process.kill()
                    process.wait()
        manifest_php = '$root="/restore/"; $out=[]; $dirs=[]; $it=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root,FilesystemIterator::SKIP_DOTS),RecursiveIteratorIterator::SELF_FIRST); foreach($it as $file){$name=substr($file->getPathname(),strlen($root)); if($file->isFile()){$out[$name]=[$file->getSize(),hash_file("sha256",$file->getPathname())];}elseif($file->isDir()){$dirs[]=$name;}} echo json_encode(["files"=>$out,"directories"=>$dirs],JSON_THROW_ON_ERROR);'
        restored = json.loads(run(["docker", "exec", file_container, "php", "-r", manifest_php]))
        restored_files = {name: tuple(value) for name, value in restored["files"].items()}
        if restored_files != before or set(restored["directories"]) != directories_before:
            raise RuntimeError("Restored manifest mismatch: missing_files=%d extra_files=%d changed_files=%d missing_dirs=%d extra_dirs=%d" % (len(before.keys() - restored_files.keys()), len(restored_files.keys() - before.keys()), sum(before[name] != restored_files[name] for name in before.keys() & restored_files.keys()), len(directories_before - set(restored["directories"])), len(set(restored["directories"]) - directories_before)))
        file_elapsed = round(time.monotonic() - started, 3)
        expected = ([], None, None, None)
        schema_hash = None
        if not args.files_only:
            first = create_db("import")
            if sql_path:
                sql(first, "CREATE DATABASE nefro_restore_import CHARACTER SET utf8mb4")
                if sql_path.suffix == ".zip":
                    with zipfile.ZipFile(sql_path) as archive:
                        members = [item for item in archive.infolist() if not item.is_dir()]
                        if len(members) != 1 or not members[0].filename.lower().endswith((".sql", ".sql.gz")):
                            raise RuntimeError("ZIP must contain exactly one SQL or SQL.gz file.")
                        payload = archive.read(members[0])
                        if members[0].filename.lower().endswith(".gz"):
                            payload = gzip.decompress(payload)
                else:
                    opener = gzip.open if sql_path.suffix == ".gz" else open
                    with opener(sql_path, "rb") as stream:
                        payload = stream.read()
                sql(first, data=payload, database="nefro_restore_import")
                del payload
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
        pdf_content = None
        if args.pdf_content_bundle:
            from pdf_content import compare
            pdf_content = compare(sql, first, expected[0], args.pdf_content_bundle)
            if inventory(first) != expected:
                raise RuntimeError("PDF content comparison changed restored application records.")
            pdf_content["database_records_unchanged"] = True
        application = None
        recovery = None
        if args.application_probe:
            from probe import collect, execute
            payload = collect(sql, first, expected[0]) if not args.files_only else {"database_available": False}
            if args.recovery_source:
                from recovery import prepare, apply
                if args.recovery_bundle.resolve().is_relative_to(files) or args.recovery_bundle.resolve() == args.recovery_source.resolve():
                    raise RuntimeError("Recovery output must not replace a source backup or source root.")
                entries = prepare(payload, before, args.recovery_source, args.recovery_bundle, args.file_memory_mib)
                if validate_formats(args.recovery_bundle)["failures"]:
                    raise RuntimeError("Recovery document format validation failed.")
                apply(run, file_container, args.recovery_bundle, entries)
                recovery = {"scope": "additive_working_copy_only", "supplement_count": len(entries),
                            "supplement_bytes": sum(item["bytes"] for item in entries), "entries": entries,
                            "original_restored_files_overwritten": 0, "restored_file_count": len(before) + len(entries)}
            if socket_volume:
                reader_password = secrets.token_hex(24)
                sql(first, "CREATE USER 'restore_reader'@'localhost' IDENTIFIED BY '" + reader_password + "'")
                from probe import quote
                sql(first, "GRANT SELECT ON " + quote(payload["database_name"]) + ".* TO 'restore_reader'@'localhost'")
                payload["reader_password"] = reader_password
            application = execute(run, file_container, payload)
            del payload
            if not args.files_only and inventory(first) != expected:
                raise RuntimeError("Application probe changed restored application records.")
        if (files_manifest(files) != before or directory_manifest(files) != directories_before
                or (archive_hash and digest(files) != archive_hash) or (sql_path and digest(sql_path) != sql_hash)):
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
            "result": "PASS" if (sql_path or args.files_only) and not format_count["failures"] else "PARTIAL",
            "verification_scope": "files_only" if args.files_only else "files_and_database",
            "file_restore": "PASS",
            "file_format_validation": "FAIL" if format_count["failures"] else "PASS",
            "database_round_trip": "NOT_RUN" if args.files_only else "PASS",
            "network_mode": "none", "published_ports": 0,
            "source_mount_read_only": True,
            "database_tcp_and_events_disabled": None if args.files_only else True,
            "restore_containers_removed": True,
            "probe_socket_volume_removed": True if socket_created else None,
            "existing_database_backup_restore_verified": bool(sql_path),
            "database_source": "not_run" if args.files_only else ("existing_backup" if sql_path else "synthetic_fixture_only"),
            "database_backup_sha256": sql_hash,
            "database_tables": expected[1], "database_rows": expected[2],
            "database_inventory_sha256": expected[3],
            "database_schema_sha256": schema_hash,
            "file_count": len(before), "file_bytes": sum(item[0] for item in before.values()),
            "directory_count": len(directories_before), "file_memory_mib": args.file_memory_mib,
            "file_backup_archive_sha256": archive_hash,
            "file_manifest_sha256": hashlib.sha256(json.dumps(before, sort_keys=True).encode()).hexdigest(),
            "format_checks": format_count, "file_restore_seconds": file_elapsed,
            "total_seconds": round(time.monotonic() - started, 3),
            "source_backups_unchanged": True, "file_image_id": image_id,
            "database_image": DB_IMAGE,
            "limits": ["File scope is only the supplied directory or ZIP.", "No application, visual, decryption or full disaster recovery validation."],
        }
        if application is not None:
            report["application_probe"] = application
            if application["result"] != "PASS":
                report["result"] = application["result"]
            report["limits"] = ["Application checks cover only the explicit probe scope; see application_probe.limits.",
                                "No full disaster recovery, common recovery timestamp or external-service validation."]
        if pdf_content is not None:
            report["pdf_content_comparison"] = pdf_content
            if pdf_content["result"] != "PASS":
                report["result"] = pdf_content["result"]
            report["limits"].append("PDF comparison covers extracted text, not visual, image or hyperlink equivalence.")
        if recovery is not None:
            report["recovery_working_copy"] = recovery
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
        if socket_created:
            metadata = run(["docker", "volume", "inspect", socket_volume])
            owner = json.loads(metadata)[0].get("Labels") or {}
            if owner.get("nefro.restore.run") != token:
                cleanup_failed = True
            else:
                result = subprocess.run(["docker", "volume", "rm", socket_volume], stdout=subprocess.DEVNULL,
                                        stderr=subprocess.DEVNULL, timeout=60, check=False)
                cleanup_failed |= result.returncode != 0
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
