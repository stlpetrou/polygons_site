#!/bin/sh
# Plesk Git "additional deployment action": copies OUR code from the deployed repo into the site's wp-content.
# Usage (in Plesk): sh deploy/plesk-deploy.sh <path to the site's document root, relative to the repo dir or absolute>
# Atomic per folder: copy to a temp dir, then swap — no request ever sees a half-copied theme.
set -eu
REPO="$(cd "$(dirname "$0")/.." && pwd)"
cd "$REPO"
DOC="${1:?document root, e.g. ../../staging.polygons.gr}"
WPC="$(cd "$DOC" && pwd)/wp-content"
[ -f "$WPC/../wp-config.php" ] || { echo "No wp-config.php next to $WPC — wrong document root?" >&2; exit 1; }
SRC="$REPO/app/public/wp-content"
# Theme
rm -rf "$WPC/themes/.polygons.new" "$WPC/themes/.polygons.old"
cp -R "$SRC/themes/polygons" "$WPC/themes/.polygons.new"
[ -d "$WPC/themes/polygons" ] && mv "$WPC/themes/polygons" "$WPC/themes/.polygons.old"
mv "$WPC/themes/.polygons.new" "$WPC/themes/polygons"
rm -rf "$WPC/themes/.polygons.old"
# mu-plugin (single file; cp to temp + mv is atomic on the same filesystem)
mkdir -p "$WPC/mu-plugins"
cp "$SRC/mu-plugins/polygons-performance.php" "$WPC/mu-plugins/.polygons-performance.php.new"
mv "$WPC/mu-plugins/.polygons-performance.php.new" "$WPC/mu-plugins/polygons-performance.php"
echo "Deployed $(git -C "$REPO" rev-parse --short HEAD 2>/dev/null || echo '?') → $WPC ($(date '+%F %T'))"
