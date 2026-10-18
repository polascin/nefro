"""Recover only missing public article assets into an additive offline working copy."""

import hashlib
import io
import json
from pathlib import Path, PurePosixPath
import re
import shutil
import subprocess
import tarfile
import unicodedata


def digest(path):
    with path.open("rb") as stream:
        return hashlib.file_digest(stream, "sha256").hexdigest()


def normalized(value):
    return "".join(character for character in unicodedata.normalize("NFKD", value).casefold() if character.isalnum())


def prepare(payload, original, source, bundle, memory_mib):
    source = source.resolve(strict=True)
    if not source.is_dir() or bundle.exists():
        raise RuntimeError("Recovery requires a source directory and a new bundle directory.")
    selected = sorted(set(payload["article_pdfs"] + payload["article_images"]) - set(original))
    planned = []
    total = 0
    for relative in selected:
        path = PurePosixPath(relative)
        if (not re.fullmatch(r"[A-Za-z0-9_./-]+", relative) or path.is_absolute()
                or not path.parts or ".." in path.parts or relative != path.as_posix()
                or not ((path.parts[0] == "pdf" and path.suffix == ".pdf")
                        or (path.parts[0] == "img" and path.suffix.lower() in {".webp", ".png", ".jpg", ".jpeg"}))):
            raise RuntimeError("Recovery accepts only canonical public article PDF/image paths.")
        candidate = source / relative
        if any(parent.is_symlink() for parent in [candidate, *candidate.parents] if parent.is_relative_to(source)):
            raise RuntimeError("Symlink recovery sources are not accepted.")
        if not candidate.is_file() or not candidate.resolve().is_relative_to(source):
            raise RuntimeError("Missing recovery candidate: " + relative)
        total += candidate.stat().st_size
        planned.append((relative, candidate))
    if total > 128 * 1024**2 or (sum(value[0] for value in original.values()) + total) * 1.15 + 64 * 1024**2 > memory_mib * 1024**2:
        raise RuntimeError("Recovery supplements exceed the allowed memory budget.")
    bundle.mkdir(parents=True, exist_ok=False)
    entries = []
    for relative, candidate in planned:
        destination = bundle / relative
        destination.parent.mkdir(parents=True, exist_ok=True)
        expected = digest(candidate)
        with candidate.open("rb") as content, destination.open("xb") as output:
            shutil.copyfileobj(content, output)
        if digest(candidate) != expected or digest(destination) != expected:
            raise RuntimeError("Recovery source changed or its working copy differs.")
        git = shutil.which("git")
        tracked = subprocess.run([git, "-C", str(source), "ls-files", "--error-unmatch", "--", relative],
                                 stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL, check=False) if git else None
        commit = None
        matches_git = None
        if tracked is not None and tracked.returncode == 0:
            history = subprocess.run([git, "-C", str(source), "log", "-1", "--format=%H", "--", relative],
                                     stdout=subprocess.PIPE, stderr=subprocess.DEVNULL, check=False)
            committed = subprocess.run([git, "-C", str(source), "show", "HEAD:./" + relative],
                                       stdout=subprocess.PIPE, stderr=subprocess.DEVNULL, check=False)
            if history.returncode == 0 and committed.returncode == 0:
                commit = history.stdout.decode().strip() or None
                matches_git = hashlib.sha256(committed.stdout).hexdigest() == expected
        text_check = "NOT_RUN"
        title = payload.get("recovery_pdf_titles", {}).get(relative)
        converter = shutil.which("pdftotext")
        if title and converter:
            result = subprocess.run([converter, "-enc", "UTF-8", str(destination), "-"],
                                    stdout=subprocess.PIPE, stderr=subprocess.DEVNULL, timeout=60, check=False)
            text_check = "PASS" if result.returncode == 0 and normalized(title) in normalized(result.stdout.decode("utf-8", errors="strict")) else "FAIL"
            if text_check != "PASS":
                raise RuntimeError("Recovered PDF title does not match its database article: " + relative)
        entries.append({"path": relative, "bytes": destination.stat().st_size, "sha256": expected,
                        "source": "tracked_repository_asset" if commit else "local_article_asset_no_git_provenance",
                        "last_source_commit": commit, "matches_git_head_blob": matches_git,
                        "database_title_in_pdf_text": text_check})
    return entries


def apply(run, container, bundle, entries):
    # The original /restore tree was already checked against the immutable backup.
    # tar -k refuses to overwrite any existing restored file.
    with io.BytesIO() as buffer:
        with tarfile.open(fileobj=buffer, mode="w", format=tarfile.PAX_FORMAT) as archive:
            for entry in entries:
                path = bundle / entry["path"]
                if digest(path) != entry["sha256"]:
                    raise RuntimeError("Recovery bundle changed before use.")
                item = tarfile.TarInfo(entry["path"])
                item.mode = 0o600
                item.size = entry["bytes"]
                with path.open("rb") as content:
                    archive.addfile(item, content)
        run(["docker", "exec", "-i", container, "tar", "-xkf", "-", "-C", "/restore", "--no-same-owner"], data=buffer.getvalue())
    checker = '$items=json_decode(stream_get_contents(STDIN),true,512,JSON_THROW_ON_ERROR);foreach($items as $item){$p="/restore/".$item["path"];if(!is_file($p)||filesize($p)!==$item["bytes"]||hash_file("sha256",$p)!==$item["sha256"]){exit(1);}if(str_starts_with($item["path"],"img/")&&getimagesize($p)===false){exit(2);}}echo "PASS";'
    if run(["docker", "exec", "-i", container, "php", "-r", checker], data=json.dumps(entries).encode()).strip() != b"PASS":
        raise RuntimeError("Recovered asset content or image decoding failed.")
    for entry in entries:
        if digest(bundle / entry["path"]) != entry["sha256"]:
            raise RuntimeError("Recovery bundle changed during use.")
