# Plugin: Wbcom Designs – Shortcodes & Elementor Widgets For BuddyPress

> **READ FIRST:** [`audit/manifest.json`](audit/manifest.json) is the canonical inventory — 0 REST endpoints, 3 frontend shortcodes (+1 admin), 3 Elementor widgets, 3 AJAX handlers, 6 admin pages, 0 tables, 0 cron, 0 blocks. Use it before grepping. See also [`audit/FEATURE_AUDIT.md`](audit/FEATURE_AUDIT.md) and [`audit/CODE_FLOWS.md`](audit/CODE_FLOWS.md). Refresh via `/wp-plugin-onboard --refresh` after non-trivial changes.

## Quick reference
- **Main file:** `shortcodes-for-buddypress.php`
- **Version:** `3.0.0`  ·  **Branch:** `3.0.0`
- **Namespace prefix:** `Shortcodes_For_Buddypress` (class prefix; not PSR-4)
- **Text domain:** `shortcodes-for-buddypress`
- **Extends:** none (Free). Pro companion: `shortcode-for-buddypress-pro` (mutually exclusive — main file blocks dual activation).

## What it does
Provides `[activity-listing]`, `[members-listing]`, `[groups-listing]` shortcodes
(and matching Elementor widgets) to embed BuddyPress activity/members/groups loops
on any post or page. Three template packs: legacy, nouveau, youzify.

## Key entry points
- Bootstrap: `shortcodes-for-buddypress.php`
- Orchestrator: `includes/class-shortcodes-for-buddypress.php`
- Hook loader: `includes/class-shortcodes-for-buddypress-loader.php`
- Admin (menu + tabs): `admin/class-shortcodes-for-buddypress-admin.php`
- Public + AJAX: `public/class-shortcodes-for-buddypress-public.php`
- Shortcode base: `public/shortcode/class-shortcodes-for-buddypress-shortcode.php`

## Admin UI wrapper: OLD (legacy tab-based)
- `admin/wbcom/wbcom-admin-settings.php` (class `Wbcom_Admin_Settings`)
- Main page renders a `nav-tab-wrapper` tabbed UI via the WP Settings API.
- **No persisted options** — all five tabs are static informational panels
  (`admin/settings/*.php`). No `register_setting()` anywhere.
- Menu parent: `wbcomplugins` (shared Wbcom top-level menu). Main page slug:
  `shortcodes-for-buddypress`. Cap: `manage_options`.
- Registration: `admin_menu` → `buddypress_shortcodes_add_submenu_page()`;
  `admin_init` → `buddypress_shortcodes_plugin_settings()` (adds the 5 sections).

## Important patterns
- Hooks are collected through a `Loader` then dispatched in `->run()` — do not
  call `add_action` directly in the public/admin classes; register via the loader
  in `define_public_hooks()` / `define_admin_hooks()`.
- Shortcodes are tag-driven: subclass `Shortcodes_For_Buddypress_Shortcode`, set
  `$this->tag`; the base wires `add_shortcode` and a `{tag}_attributes` filter.
- Build/release via Grunt (see `GRUNT-TASKS.md`) — min + rtl assets are generated.

## Known issues (from wppqa baseline 2026-06-05)
See `audit/wppqa-baseline-2026-06-05/SUMMARY.md`.
- `admin/wbcom/wbcom-admin-settings.php:44` — nonce-no-cap (real, LOW): add
  `current_user_can('manage_options')` to `wbcom_addons_cards_links()`.
- 2 further nonce-no-cap flags on the public `nopriv` AJAX handlers are false
  positives (public read endpoints by design).

## CSS selectors (for testing/dev)
- Admin tabs: `.wbcom-tabs-section .nav-tab-wrapper .nav-tab`
- Admin header: `#wb_admin_header #wb_admin_nav`
- Shortcode cards: `.wbcom-shortcode-grid .wbcom-shortcode-card`

## Recent changes
| Date | Type | Description | Files |
|---|---|---|---|
| 2026-06-05 | onboard | Generated audit/ manifest + reports + graph + wppqa baseline | audit/* , CLAUDE.md |
