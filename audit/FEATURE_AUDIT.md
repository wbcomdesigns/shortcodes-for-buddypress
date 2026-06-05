# Feature Audit — Shortcodes & Elementor Widgets For BuddyPress

- **Version:** 3.0.0 · **Branch:** 3.0.0 · **Text domain:** `shortcodes-for-buddypress`
- **Generated:** 2026-06-05 by wp-plugin-onboard
- **Source of truth:** [`manifest.json`](manifest.json)

## 1. Frontend shortcodes (primary feature)

| Tag | Handler | Renders |
|---|---|---|
| `[activity-listing]` | `public/shortcode/class-shortcode-for-activity-listing.php` | BuddyPress activity stream |
| `[members-listing]` | `public/shortcode/class-member-shortcode.php` | Members directory |
| `[groups-listing]` | `public/shortcode/class-group-shortcode.php` | Groups directory |

All three derive from the tag-driven base `Shortcodes_For_Buddypress_Shortcode`
(`public/shortcode/class-shortcodes-for-buddypress-shortcode.php`), which calls
`add_shortcode($this->tag, [$this,'render'])` and exposes a per-tag attribute
filter `{tag}_attributes`. Attribute reference: `docs/SHORTCODE-REFERENCE.md`.

Template resolution supports three packs — `legacy`, `nouveau`, `youzify`
(`templates/`), chosen from the active BP theme package and `bp_shortcode_locate_template`.

## 2. Elementor widgets

Custom Elementor category `buddypress-widgets` (registered on
`elementor/elements/categories_registered`, `shortcodes-for-buddypress.php:368`)
with three widgets, each wrapping the matching shortcode:

| Widget | Class | Wraps |
|---|---|---|
| BuddyPress Activity | `elementor/widgets/class-buddypress-activity-widget.php` | `[activity-listing]` |
| BuddyPress Members | `elementor/widgets/class-buddypress-members-widget.php` | `[members-listing]` |
| BuddyPress Groups | `elementor/widgets/class-buddypress-groups-widget.php` | `[groups-listing]` |

## 3. AJAX handlers

| Action | nopriv | Handler | Nonce | Cap | Purpose |
|---|---|---|---|---|---|
| `bpsp_activities_load` | yes | `Public::buddypress_shortcodes_load_activities` | `bpsp-nonce` | none (public read) | Paginate activity stream |
| `bpsh_load_more_members` | yes | `Public::buddypress_shortcode_ajax_load_more_members` | `bpsp-nonce` | none (public read) | Paginate members directory |
| `wbcom_addons_cards` | no | `Wbcom_Admin_Settings::wbcom_addons_cards_links` | `wbcom_admin_setting_nonce` | **none (gap)** | Echo addon-card markup (admin promo) |

## 4. REST endpoints
_None._

## 5. Admin pages / settings

Admin wrapper: **OLD** (legacy tab-based `admin/wbcom/wbcom-admin-settings.php`).

| Page | Slug | Parent | Cap | Source |
|---|---|---|---|---|
| WB Plugins (top-level) | `wbcomplugins` | — | manage_options | admin class:134 |
| General (alias) | `wbcomplugins` | wbcomplugins | manage_options | admin class:135 |
| Shortcodes (main) | `shortcodes-for-buddypress` | wbcomplugins | manage_options | admin class:137 |
| Our Plugins | `wbcom-plugins-page` | wbcomplugins | manage_options | wbcom wrapper:247 |
| Our Themes | `wbcom-themes-page` | wbcomplugins | manage_options | wbcom wrapper:255 |
| Support | `wbcom-support-page` | wbcomplugins | manage_options | wbcom wrapper:263 |

The main "Shortcodes" page renders a five-tab UI via the WP Settings API
(`settings_fields()` + `do_settings_sections()`): Welcome, General, Activities,
Members, Groups. **No `register_setting()` and no persisted options** — every tab
is a static informational/documentation panel (`admin/settings/*.php`). The
plugin stores zero custom options; it only READS BuddyPress/BuddyBoss/WP options
to drive template selection (`_bp_theme_package_id`, `bp_nouveau_appearance`,
`bb_pinned_post`, `active_plugins`).

## 6. Content types
_None._ No CPTs, taxonomies, or DB tables.

## 7. Hooks fired (extension points)

12 actions (render lifecycle: `before/after_{activity,member,group}_shortcode_render`,
`*_inside_container`, `member_shortcode_before_output`, asset-enqueue
`before_enqueue_buddypress_shortcode_{scripts,styles}`, admin
`wbcom_add_header_menu`, `wbcom_add_plugin_license_code`), 3 named filters
(`bp_shortcode_is_shortcode_page`, `bp_shortcode_locate_template`,
`bp_shortcode_member_cover`) + 1 dynamic filter `{tag}_attributes`. None consumed
within the Free plugin (Pro companion `shortcode-for-buddypress-pro` is the likely
consumer — not onboarded here).

## 8. Cron / WP-CLI / Blocks
_None._

## 9. Integrations

- **BuddyPress / BuddyBoss** — hard dependency; activity/members/groups loops.
- **Elementor** — optional; widgets register only when Elementor is active.
- **Youzify** — optional template pack.
- **Pro plugin** — `shortcode-for-buddypress-pro`; main file blocks simultaneous activation.
