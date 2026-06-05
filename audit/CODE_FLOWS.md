# Code Flows — Shortcodes For BuddyPress (3.0.0)

Source of truth: [`manifest.json`](manifest.json).

## Bootstrap

```
shortcodes-for-buddypress.php
  → guard: deactivate if Pro (shortcode-for-buddypress-pro) active
  → define SHORTCODES_FOR_BUDDYPRESS_VERSION/_DIR/_URL/_BASENAME
  → run_shortcodes_for_buddypress()
      → Shortcodes_For_Buddypress (includes/class-shortcodes-for-buddypress.php)
          → Loader (collects add_action/add_filter, then ->run())
          → define_admin_hooks()  → Shortcodes_For_Buddypress_Admin
          → define_public_hooks() → Shortcodes_For_Buddypress_Public
  → add_action('elementor/elements/categories_registered', …) → buddypress-widgets category
```

## Flow 1 — Frontend shortcode render

```
[activity-listing] / [members-listing] / [groups-listing]
  → Shortcodes_For_Buddypress_Shortcode::render($atts)        (tag-driven base)
  → apply_filters('{tag}_attributes', $atts)
  → do_action('before_{type}_shortcode_render')
  → locate template (legacy | nouveau | youzify)              (bp_shortcode_locate_template)
        chosen via _bp_theme_package_id / Youzify class_exists
  → render BP loop (bp_has_activities / bp_has_members / bp_has_groups)
  → do_action('after_{type}_shortcode_render')
```

Key files: `public/shortcode/*.php`, `templates/{pack}/{type}/*.php`,
`includes/functions.php` (shortcode-page detection, asset gating).

## Flow 2 — AJAX pagination (public, nopriv)

```
JS (public/js) ──POST admin-ajax.php──> action=bpsp_activities_load|bpsh_load_more_members
  → wp_verify_nonce(_, 'bpsp-nonce')                          (no cap — public by design)
  → Public::buddypress_shortcodes_load_activities()  / ::buddypress_shortcode_ajax_load_more_members()
  → BP loop next page → wp_send_json(...) / echo markup
```

## Flow 3 — Admin settings page

```
admin_menu (loader) → Admin::buddypress_shortcodes_add_submenu_page()
   → add_menu_page('wbcomplugins')  [only if not already present]
   → add_submenu_page('shortcodes-for-buddypress')           (main page)
admin_menu @999 → Wbcom_Admin_Settings::wbcom_admin_additional_pages()
   → Our Plugins / Our Themes / Support submenus
admin_init (loader) → Admin::buddypress_shortcodes_plugin_settings()
   → add_settings_section() × 5 tabs (Welcome/General/Activities/Members/Groups)
Render: buddypress_shortcodes_admin_settings_page()
   → do_shortcode('[wbcom_admin_setting_header]')  → tab nav
   → settings_fields($tab); do_settings_sections($tab)
   → tab body = static include from admin/settings/*.php  (NO options saved)
```

## Key files

| Concern | File |
|---|---|
| Bootstrap | `shortcodes-for-buddypress.php` |
| Orchestrator | `includes/class-shortcodes-for-buddypress.php` |
| Hook loader | `includes/class-shortcodes-for-buddypress-loader.php` |
| Helpers / asset gating | `includes/functions.php` |
| Admin (menu + tabs) | `admin/class-shortcodes-for-buddypress-admin.php` |
| Wbcom OLD wrapper | `admin/wbcom/wbcom-admin-settings.php` |
| Public + AJAX | `public/class-shortcodes-for-buddypress-public.php` |
| Shortcode base | `public/shortcode/class-shortcodes-for-buddypress-shortcode.php` |
| Elementor | `elementor/class-buddypress-shortcode-elements.php`, `elementor/widgets/*.php` |

## Permissions

All admin pages: `manage_options`. Frontend shortcodes + AJAX: public (no cap;
visibility follows BuddyPress's own access rules).

## Dependencies

BuddyPress/BuddyBoss (required), Elementor (optional widgets), Youzify (optional pack).
