#!/usr/bin/env bash
# First-deploy package (LocalWP → staging/live without SSH): DB with URLs replaced + full site zip + wp-config template.
# Usage: build/package-site.sh https://staging.polygons.gr [noindex]
# Output: _deploy/<host>-<date>/{db.sql,site.zip,wp-config.php}. Upload steps: _playbook core/site-build-rules.md §10.
set -euo pipefail
NEW="${1:?target URL, e.g. https://staging.polygons.gr}"; NOINDEX="${2:-}"
ROOT="$(cd "$(dirname "$0")/.." && pwd)"; PUB="$ROOT/app/public"
source "$ROOT/app/.envrc" >/dev/null 2>&1; cd "$PUB"
OLD="$(wp option get siteurl)"
OUT="$ROOT/_deploy/$(echo "$NEW" | sed 's#https\?://##')-$(date +%F)"; mkdir -p "$OUT" "$ROOT/_backups"
wp --user=1 db export "$ROOT/_backups/$(date +%F-%H%M)-before-package.sql" >/dev/null
# Serialized-safe replace; then the JSON-escaped form Elementor keeps in _elementor_data (\/ is \\/ inside the dump).
wp --user=1 search-replace "$OLD" "$NEW" --all-tables --export="$OUT/db.sql" --report-changed-only
esc() { echo "$1" | sed 's#/#\\\\\\\\/#g'; }
sed -i "s#$(esc "$OLD")#$(esc "$NEW")#g" "$OUT/db.sql"
{
	echo; echo '-- force Elementor (and plugin "custom-*" breakpoint files, e.g. JetBlocks) to regenerate CSS on the server'
	echo "DELETE FROM \`wp_postmeta\` WHERE meta_key='_elementor_css';"
	echo "DELETE FROM \`wp_options\` WHERE option_name IN ('_elementor_global_css','elementor-custom-breakpoints-files');"
	[ "$NOINDEX" = noindex ] && echo "UPDATE \`wp_options\` SET option_value='0' WHERE option_name='blog_public';"
} >> "$OUT/db.sql"
LEFT=$(grep -c "${OLD#*://}" "$OUT/db.sql" || true); echo "leftover old-domain strings: $LEFT"
rm -f "$OUT/site.zip"
zip -qr -9 "$OUT/site.zip" . -x 'wp-config.php' 'local-xdebuginfo.php' 'wp-content/upgrade/*' 'wp-content/debug.log' \
	'wp-content/themes/twentytwentythree/*' 'wp-content/themes/twentytwentyfour/*'
SALTS=$(php -r 'foreach(["AUTH_KEY","SECURE_AUTH_KEY","LOGGED_IN_KEY","NONCE_KEY","AUTH_SALT","SECURE_AUTH_SALT","LOGGED_IN_SALT","NONCE_SALT"] as $k){$c="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#%^&*()-_[]{}<>~+=,.;:/?|";$s="";for($i=0;$i<64;$i++)$s.=$c[random_int(0,strlen($c)-1)];printf("define( %-20s %s );\n","\x27$k\x27,","\x27$s\x27");}')
ENV=$([ "$NOINDEX" = noindex ] && echo staging || echo production)
cat > "$OUT/wp-config.php" <<EOF
<?php
// wp-config για ${NEW} — συμπλήρωσε ΜΟΝΟ τα 3 πεδία της βάσης (Plesk → Databases).
define( 'DB_NAME',     'ΣΥΜΠΛΗΡΩΣΕ_ΟΝΟΜΑ_ΒΑΣΗΣ' );
define( 'DB_USER',     'ΣΥΜΠΛΗΡΩΣΕ_ΧΡΗΣΤΗ_ΒΑΣΗΣ' );
define( 'DB_PASSWORD', 'ΣΥΜΠΛΗΡΩΣΕ_ΚΩΔΙΚΟ_ΒΑΣΗΣ' );
define( 'DB_HOST',     'localhost' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

$SALTS
\$table_prefix = 'wp_';

define( 'WP_ENVIRONMENT_TYPE', '$ENV' );
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );      // wp-content/debug.log
define( 'WP_DEBUG_DISPLAY', false );
define( 'DISALLOW_FILE_EDIT', true );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
EOF
php -l "$OUT/wp-config.php" >/dev/null && ls -lh "$OUT"
