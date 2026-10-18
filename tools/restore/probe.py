"""Project-specific consistency checks; returned evidence contains aggregates only."""

import json
from html.parser import HTMLParser
from pathlib import PurePosixPath
from urllib.parse import unquote, urlsplit


def quote(value):
    return "`" + value.replace("`", "``") + "`"


class Images(HTMLParser):
    def __init__(self):
        super().__init__()
        self.paths = []
        self.external = 0

    def handle_starttag(self, tag, attrs):
        if tag not in {"img", "source"}:
            return
        values = dict(attrs)
        sources = [values.get("src", "")]
        sources += [part.strip().split(" ")[0] for part in values.get("srcset", "").split(",")]
        for source in sources:
            if not source:
                continue
            parsed = urlsplit(source)
            if parsed.scheme == "data":
                continue
            if parsed.netloc and parsed.hostname != "nefro.polascin.net":
                self.external += 1
                continue
            self.paths.append(unquote(parsed.path).lstrip("/"))


def collect(sql, container, databases):
    candidates = []
    for name in databases:
        tables = set(sql(container, "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA=CONVERT(0x"
                         + name.encode().hex() + " USING utf8mb4)").decode().splitlines())
        if {"articles", "users"} <= tables:
            candidates.append((name, tables))
    if len(candidates) != 1:
        raise RuntimeError("Expected exactly one restored Nefro database for application checks.")
    database, tables = candidates[0]

    def records(table, fields, where=""):
        expression = ",".join("'" + alias + "'," + quote(column) for alias, column in fields.items())
        content = sql(container, "SELECT HEX(JSON_OBJECT(" + expression + ")) FROM "
                      + quote(database) + "." + quote(table) + (" WHERE " + where if where else ""))
        return [json.loads(bytes.fromhex(line)) for line in content.decode().splitlines()]

    articles = records("articles", {"pdf": "pdf_file", "content": "content"})
    images = Images()
    for article in articles:
        images.feed(article["content"] or "")
    result = {
        "database_available": True,
        "database_name": database,
        "article_pdfs": ["pdf/" + PurePosixPath(row["pdf"]).name for row in articles if row["pdf"]],
        "article_images": images.paths,
        "external_images_not_checked": images.external,
        "avatars": [row["path"] for row in records("users", {"path": "avatar_path"}) if row["path"]],
        "archived_avatars": [], "order_files": [],
        "totp": records("users", {"secret": "totp_secret", "storage": "totp_backup_codes", "enabled": "totp_enabled"}),
        "relations": [], "publication_order_records": 0,
    }
    published = sql(container, "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=CONVERT(0x"
                    + database.encode().hex() + " USING utf8mb4) AND TABLE_NAME='articles'").decode().splitlines()
    if {"slug", "is_published"} <= set(published):
        rows = records("articles", {"slug": "slug"}, "is_published=1 LIMIT 1")
        result["published_slug"] = rows[0]["slug"] if rows else None
    if "users_avatar_archive" in tables:
        result["archived_avatars"] = [row["path"] for row in records("users_avatar_archive", {"path": "archived_path"}) if row["path"]]
    if "publication_orders" in tables:
        # Every order refers to a catalog publication; formats are checked against files.
        metadata = sql(container, "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=CONVERT(0x"
                       + database.encode().hex() + " USING utf8mb4) AND TABLE_NAME='publication_orders'").decode().splitlines()
        format_column = next((field for field in ("formats_json", "formats") if field in metadata), None)
        if format_column:
            orders = records("publication_orders", {"slug": "publication_slug", "formats": format_column})
            result["publication_order_records"] = len(orders)
            for order in orders:
                formats = json.loads(order["formats"]) if format_column == "formats_json" else [value.strip() for value in order["formats"].split(",") if value.strip()]
                for extension in formats:
                    result["order_files"].append("private/publications/" + order["slug"] + "/" + order["slug"] + "." + extension)
        else:
            raise RuntimeError("Publication order formats column is unavailable.")
    constraints = sql(container, "SELECT CONSTRAINT_NAME,TABLE_NAME,COLUMN_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME "
                      "FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA=CONVERT(0x" + database.encode().hex()
                      + " USING utf8mb4) AND REFERENCED_TABLE_NAME IS NOT NULL ORDER BY CONSTRAINT_NAME,ORDINAL_POSITION").decode().splitlines()
    groups = {}
    for row in constraints:
        constraint, table, column, parent, target = row.split("\t")
        groups.setdefault((constraint, table, parent), []).append((column, target))
    for (_, table, parent), pairs in groups.items():
        child = quote(database) + "." + quote(table)
        ancestor = quote(database) + "." + quote(parent)
        joined = " AND ".join("c." + quote(column) + "=p." + quote(target) for column, target in pairs)
        nonnull = " AND ".join("c." + quote(column) + " IS NOT NULL" for column, _ in pairs)
        orphaned = int(sql(container, "SELECT COUNT(*) FROM " + child + " c LEFT JOIN " + ancestor
                          + " p ON " + joined + " WHERE " + nonnull + " AND p." + quote(pairs[0][1]) + " IS NULL"))
        result["relations"].append({"orphaned_rows": orphaned})
    return result


def execute(run, file_container, payload):
    evidence = json.loads(run(["docker", "exec", "-i", file_container, "php", "/checks/application_probe.php"],
                              data=json.dumps(payload).encode()))
    evidence["external_images_not_checked"] = payload.get("external_images_not_checked", 0)
    evidence["publication_order_records"] = payload.get("publication_order_records", 0)
    if any(item["orphaned_rows"] for item in evidence["database_relations"]):
        evidence["result"] = "FAIL"
    return evidence
