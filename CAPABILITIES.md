# Capabilities — Shortcodes & Elementor Widgets For BuddyPress

Derived from `audit/manifest.json`. Refresh with `/wp-plugin-onboard --refresh` whenever
the surfaces below change. Read this before planning any new feature so the portfolio
does not rebuild something that already ships.

- **Slug:** `shortcodes-for-buddypress`
- **Version:** 3.0.0
- **Requires:** WordPress 6.5, PHP 8.0, BuddyPress (hard dependency via `Requires Plugins`)
- **Pro companion:** `shortcode-for-buddypress-pro` (mutually exclusive — free deactivates itself when Pro is active)

## What it does

Three BuddyPress shortcodes plus three matching Elementor widgets, and an informational
admin panel. That is the whole product. It deliberately has **no** settings, database
tables, REST API, cron jobs, blocks, or WP-CLI commands.

## Shortcodes

| Tag | Class | Renders |
|-----|-------|---------|
| `[activity-listing]` | `ActivityShortCode` | BuddyPress activity stream |
| `[members-listing]` | `MemberShortCode` | BuddyPress members directory |
| `[groups-listing]` | `GroupShortCode` | BuddyPress groups directory |

All three register through the tag-driven `BPShortCode` singleton base class.
Each shows an "enable BuddyPress" notice instead of fataling when BuddyPress is inactive.

## Elementor widgets

`buddypress_shortcode_activity_widget`, `buddypress_shortcode_members_widget`,
`buddypress_shortcode_groups_widget` — one per shortcode, in `elementor/widgets/`.

## Admin

Two pages under the shared Wbcom hub, both gated on `manage_options`:

- `wbcomplugins` — shared "WB Plugins" hub, registered only when no other Wbcom plugin has already created it.
- `shortcodes-for-buddypress` — "BP Shortcodes" submenu.

Tabs: overview, shortcodes, activities, members, groups, discover. The `tab` query arg is
read via `sanitize_key()` and whitelisted against `get_tabs()`.

## AJAX

| Action | nopriv | Nonce | Purpose |
|--------|--------|-------|---------|
| `bpsp_activities_load` | yes | `bpsp-nonce` | Paginate the public activity stream for load-more. `per_page`/`limit` are clamped so a public request cannot force an unbounded query. |

## BuddyPress integration

Active when BuddyPress (or BuddyBoss) is; every `bp_is_active()` call is
`function_exists()`-guarded. **One template pack only** — `templates/nouveau/`. The legacy
and youzify packs were removed in 3.0.0, so all three shortcodes resolve to nouveau
regardless of `_bp_theme_package_id`; BuddyBoss uses the `bb-*.php` variants inside that pack.

Optional BuddyBoss Platform hooks (`bp_activity_reshare_action`,
`bp_after_nouveau_wrapper_parse_args`, `bb_nouveau_get_activity_entry_bubble_buttons`) are
filtered but never fire on vanilla BuddyPress — an intended no-op, recorded in
`.contract-audit-baseline.json`.

## Storage

None. No options, no custom tables, no post types or taxonomies. `uninstall.php` exists but
has nothing to purge.

## Build and CI

Grunt (`build`, `minify`, `i18n`). POT comes from `wp i18n make-pot` via `shell:makepot` —
the `grunt-wp-i18n` `makepot` task is deliberately unused because it produced a stale POT.

`bin/local-ci.sh` is the gate (php -l, WPCS errors, PHPStan level 5, PHPUnit functional).
GitHub Actions is disabled for this repository, so no workflow is kept in the tree; restore
from commit `a8c295d` if Actions is ever re-enabled.

## Known gaps

- `MemberShortCode::handle_classes()` and `GroupShortCode::get_container_classes()` are parallel Reign layout builders that have drifted (40 vs 56 lines). Consolidating needs a Reign install to verify.
- BuddyBoss-only functions (`bb_*`, `bp_moderation_*`, `bp_is_*_media_support_enabled`, `bp_member_type_*`) are called unguarded inside the `bb-*.php` templates and `buddypress_shortcode_activity_entry_bubble_buttons`. Safe because both are reached only when `buddypress()->buddyboss` is set, but any new call site outside those paths needs a `function_exists` guard.
