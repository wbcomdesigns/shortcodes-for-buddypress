#!/usr/bin/env bash
# Build shortcodes-for-buddypress-v<version>.zip: local CI, then grunt build (assets, POT,
# copy minus .distignore, zip), then check the zip for dev files.
set -euo pipefail
cd "$(dirname "$0")/.."
slug=shortcodes-for-buddypress
bin/local-ci.sh --no-unit
[ -d node_modules ] || npm ci
npx grunt build
version=$(grep -m1 '"version"' package.json | grep -oE "[0-9]+\.[0-9]+\.[0-9]+")
zip="$slug-v$version.zip"
leaks=$(unzip -Z1 "$zip" | grep -iE "$slug/(audit|bin|docs|tests|node_modules|vendor)/|CLAUDE|\.md$|\.map$|gruntfile|package(-lock)?\.json|composer\.(json|lock)|\.distignore|\.zip$" || true)
[ -z "$leaks" ] || { echo "Zip contains dev files:"; echo "$leaks"; exit 1; }
unzip -Z1 "$zip" | grep "$slug/$slug.php" >/dev/null || { echo "Zip has no main file"; exit 1; }
echo "Built $zip"
