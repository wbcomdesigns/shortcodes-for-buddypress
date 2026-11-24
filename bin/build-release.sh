#!/usr/bin/env bash
# Build dist/shortcodes-for-buddypress-<version>.zip: local CI, then grunt build (assets, POT,
# copy minus .distignore into build/), then zip build/<slug>/ and check the zip for dev files.
set -euo pipefail
cd "$(dirname "$0")/.."
slug=shortcodes-for-buddypress
main=shortcodes-for-buddypress.php
bin/local-ci.sh --no-unit
[ -d node_modules ] || npm ci
npx grunt build
version=$(grep -m1 '"version"' package.json | grep -oE "[0-9]+\.[0-9]+\.[0-9]+")
[ -f "build/$slug/$main" ] || { echo "grunt build did not produce build/$slug/$main"; exit 1; }
mkdir -p dist
zip="$PWD/dist/$slug-$version.zip"
rm -f "$zip"
# Deflate every entry: a PHP file stored uncompressed trips the store's upload firewall.
( cd build && python3 -I -c 'import os,sys,zipfile
out,top=sys.argv[1],sys.argv[2]
with zipfile.ZipFile(out,"w",zipfile.ZIP_DEFLATED,compresslevel=9) as z:
    for r,d,f in os.walk(top):
        d.sort()
        for n in sorted(f): z.write(os.path.join(r,n))' "$zip" "$slug" )
rm -rf build

# --- WordPress.org folder lock (Wbcom standard - do not edit) ----------------------
entries=$(unzip -Z1 "$zip")   # read the whole list once: no early-exit pipe, safe under pipefail
top=${entries%%/*}
[ "$top" = "$slug" ] || { echo "Zip folder '$top' is not the WordPress.org slug '$slug'"; exit 1; }
grep -qx "$slug/$main" <<<"$entries" || { echo "Main file $slug/$main missing from zip"; exit 1; }
[ "$(LC_ALL=C grep -a -c '<?php' "$zip" || true)" = 0 ] || { echo "Zip has plain-text PHP (upload firewall)"; exit 1; }
# -----------------------------------------------------------------------------------

leaks=$(unzip -Z1 "$zip" | grep -iE "$slug/(audit|bin|docs|tests|node_modules|vendor)/|CLAUDE|\.md$|\.map$|gruntfile|package(-lock)?\.json|composer\.(json|lock)|\.distignore|\.zip$" || true)
[ -z "$leaks" ] || { echo "Zip contains dev files:"; echo "$leaks"; exit 1; }
echo "Built dist/$slug-$version.zip"
