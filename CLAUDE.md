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
on any post or page. One template pack: nouveau (with BuddyBoss `bb-` variants inside it).

## Key entry points
- Bootstrap: `shortcodes-for-buddypress.php` (carries `Requires at least: 6.5`,
  `Requires PHP: 8.0`, `Requires Plugins: buddypress`)
- Orchestrator: `includes/class-shortcodes-for-buddypress.php`
- Hook loader: `includes/class-shortcodes-for-buddypress-loader.php`
- Public + AJAX: `public/class-shortcodes-for-buddypress-public.php`
- Shortcode base: `public/shortcode/class-shortcodes-for-buddypress-shortcode.php`

## Admin UI wrapper: NEW card panel (migrated in 3.0.0)
- The old wbcom tab wrapper is GONE. `admin/` now holds only `index.php` + an icon.
- Wired admin = `includes/admin/class-shortcodes-for-buddypress-admin-panel.php`
  (loaded in `includes/class-shortcodes-for-buddypress.php`, ~line 141; registered ~197-198).
  Views in `includes/admin/views/` (hub.php landing at `?page=wbcomplugins`, overview, shortcode reference tabs).
- **No persisted options** - informational panels only. No `register_setting()`.
- All pages gated by `manage_options`; `$_GET['tab']` read via `sanitize_key` + whitelist.
- Menu parent: `wbcomplugins` (shared hub). Cap: `manage_options`.

## Important patterns
- Hooks are collected through a `Loader` then dispatched in `->run()` — do not
  call `add_action` directly in the public/admin classes; register via the loader
  in `define_public_hooks()` / `define_admin_hooks()`.
- Shortcodes are tag-driven: subclass `BPShortCode` (the abstract base), set
  `$this->tag`; the base wires `add_shortcode` and a `{tag}_attributes` filter.
- Every shortcode/widget that calls `bp_is_active()` MUST guard it with
  `function_exists('bp_is_active')` first - the plugin can be on a page while
  BuddyPress is inactive (self-deactivation only runs on admin_init, not front end).
- Build/release via Grunt (see `GRUNT-TASKS.md`) — min + rtl assets are generated.

## Known issues
- RESOLVED: the old `wbcom_addons_cards_links()` nonce-no-cap flag - that file
  (`admin/wbcom/wbcom-admin-settings.php`) and handler were removed in the 3.0.0
  admin migration. Only 1 AJAX handler exists now (`bpsp_activities_load`),
  public-read with a nonce check (no cap needed). The `bpsh_load_more_members`
  endpoint was removed - nothing rendered its button.
- The shortcode base class is `abstract class BPShortCode`
  (`public/shortcode/class-shortcodes-for-buddypress-shortcode.php`), with
  subclasses `ActivityShortCode` / `MemberShortCode` / `GroupShortCode`.
- audit/manifest.json is STALE (still lists the OLD wrapper, 3 AJAX, wrong base
  class). Refresh via `/wp-plugin-onboard --refresh`.

## CSS selectors (for testing/dev)
- Admin tabs: `.wbcom-tabs-section .nav-tab-wrapper .nav-tab`
- Admin header: `#wb_admin_header #wb_admin_nav`
- Shortcode cards: `.wbcom-shortcode-grid .wbcom-shortcode-card`

## Recent changes
| Date | Type | Description | Files |
|---|---|---|---|
| 2026-07-10 | bug-fix | Two RUNTIME bugs the static audit missed (found in-browser). (1) Frontend assets 404'd: bp_shortcode_asset() built public/css/<file>.min.css but the build lives in public/css/min/ (and RTL in rtl/) - rewrote it to prefer min/ then rtl/ then the unminified source, with a file_exists fallback so a missing build never 404s. (2) With the JS finally loading, a crash surfaced: setupEventListeners bound '.bpsh-load-more' (a selector no template renders) to this.handleLoadMore (undefined), so jQuery threw on every page load - removed the dead binding (activity load-more is already wired in setupLoadMore). Rebuilt the min JS. Verified: shortcode page loads styled, zero console errors, load-more intact. | includes/functions.php, public/js/shortcodes-for-buddypress-public.js(+min) |
| 2026-07-10 | audit | Fresh audit + fixes. Fixed a BuddyPress-inactive FATAL: [activity-listing] + [groups-listing] called bp_is_active() unguarded (member shortcode already guarded) - added function_exists guards so they show the disabled notice instead of white-screening. Clamped the two public load-more AJAX per_page/limit to 50 (unbounded before). Removed dead get_user_ids_by_roles(). Replaced 5 em-dashes in overview.php. Added Requires PHP 7.4 + Requires Plugins: buddypress headers + a "More Free Tools" promo section. Corrected this CLAUDE.md (admin is the NEW card panel not the old wrapper; 2 AJAX not 3; base class BPShortCode). manifest.json still needs a refresh. | public/shortcode/class-shortcode-for-activity-listing.php, public/shortcode/class-group-shortcode.php, public/class-shortcodes-for-buddypress-public.php, includes/admin/views/overview.php, readme.txt, CLAUDE.md |
| 2026-06-05 | onboard | Generated audit/ manifest + reports + graph + wppqa baseline | audit/* , CLAUDE.md |
