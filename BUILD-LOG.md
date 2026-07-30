# BUILD-LOG — Admin Wrapper Migration (OLD tab wrapper → card panel)

**Plugin:** Wbcom Designs – Shortcodes & Elementor Widgets For BuddyPress
**Slug:** `shortcodes-for-buddypress`  ·  **Branch:** `3.0.0`  ·  **Version:** `3.0.0` (header + `SHORTCODES_FOR_BUDDYPRESS_VERSION` + readme `Stable tag` already aligned; one above highest released tag `v2.9.1`)
**Pattern source:** `buddypress-contact-me` (wbcom-pro) + `references/wbcom-wrapper-migration.md`
**Scope:** UX-only wrapper migration + approved safe fixes. No option/AJAX/nonce/hook/meta renames.

---

## Key plugin fact that shaped the migration

This plugin **persists ZERO settings** — it never calls `register_setting()` (verified: 0 old, 0 new). Its legacy tabs (Welcome / General / Activities / Members / Groups) were **informational documentation panels**, not a settings form. So the new card panel:

- has **no** `register_settings()` / `sanitize_settings()` / `settings_fields()` / `options.php` form,
- has **no** sentinel-guarded merge (Playbook 7.1 — N/A, nothing saves),
- renders every tab as a **plain informational partial** inside the shell,
- adds an **Overview dashboard** summarizing the 3 shortcodes + 3 Elementor widgets + live BuddyPress component status,
- reskins the 5 old doc tabs into 4 card-based reference tabs (the old Welcome + General overview merged into one **Shortcodes** reference tab; Activities / Members / Groups parameter docs each kept).

Because there is no save round-trip and no admin AJAX/data-action buttons, the action-audit (Playbook 12) and the data-loss class of bug are N/A here.

---

## Files DELETED (`git rm -rf`, 24 files)

Legacy Wbcom tab wrapper + ported content + dead admin assets:

- `admin/class-shortcodes-for-buddypress-admin.php` — legacy admin class. Held **only** UI render (`nav-tab-wrapper`), enqueue, and notice-suppression methods. **No** save handlers, AJAX, or sanitizer, so removed entirely per Playbook Part 3 (no reachable non-wrapper logic to retain).
- `admin/wbcom/` (entire dir) — `wbcom-admin-settings.php` (class `Wbcom_Admin_Settings`), `templates/wbcom-{license,plugins,support}-page.php`, `assets/{css,js}/…`. This also removed:
  - the `[wbcom_admin_setting_header]` admin shortcode,
  - the `wbcom_addons_cards` AJAX handler (the **nonce-no-cap LOW finding** — fixed by removal; nothing else referenced it),
  - the "Our Plugins / Our Themes / Support" helper submenus (incl. the dead `wbcom-themes-page` include that 404s in every OLD plugin).
- `admin/settings/buddypress-shortcode-{welcome-page,general-settings,activity-listing,member-listing,groups-listing}.php` — content ported into the new `includes/admin/views/reference-*.php` (one inline `<style>` block in the general-settings panel was dropped; its rules are replaced by token-driven CSS in `assets/css/admin.css`).
- `admin/css/` + `admin/js/` trees (incl. `min/`, `rtl/`, `.map`) — legacy `nav-tab` admin assets, no longer referenced; replaced by `assets/css/admin.css` + `assets/js/admin.js`.

Kept under `admin/`: `admin/index.php` (silence stub) and `admin/image/bp-shortcode-icon-256x256.png` (unreferenced asset, harmless).

Post-delete grep (Playbook 2.1): **zero** functional references to any deleted path/handle/localized object remain in PHP or JS — only two descriptive docblock comments mention the old paths.

## Files CREATED (10)

```
includes/admin/class-shortcodes-for-buddypress-admin-panel.php   # controller
includes/admin/views/shell.php                 # header card + sidebar nav + body (no form branch)
includes/admin/views/hub.php                   # WB Plugins hub landing (takeover + wrapper-slug filter)
includes/admin/views/overview.php              # dashboard: 3 shortcodes + 3 widgets + component status
includes/admin/views/reference-shortcodes.php  # ported Welcome + General overview
includes/admin/views/reference-activities.php  # [activity-listing] parameter docs
includes/admin/views/reference-members.php     # [members-listing] parameter docs
includes/admin/views/reference-groups.php      # [groups-listing] parameter docs
assets/css/admin.css                           # --bpsp-admin-* token system (from contact-me, prefix-swapped) + doc-panel content styles
assets/js/admin.js                             # window.bpspToast() + window.bpspConfirm() + [data-bpsp-confirm] intercept
```

## Files MODIFIED (2)

- `includes/class-shortcodes-for-buddypress.php`
  - `load_admin_classes()` — now requires `includes/admin/class-shortcodes-for-buddypress-admin-panel.php`; dropped the requires for the legacy admin class + `admin/wbcom/wbcom-admin-settings.php`.
  - `define_admin_hooks()` — replaced the 5 Loader-wired legacy UI hooks (`enqueue_styles`, `enqueue_scripts`, `buddypress_shortcodes_add_submenu_page`, `buddypress_shortcodes_plugin_settings`, `wbcom_hide_all_admin_notices_from_setting_page`) with `(new Shortcodes_For_Buddypress_Admin_Panel())->register()`. The panel self-wires `admin_menu`, `admin_menu:999` (hub takeover), `admin_enqueue_scripts`, and `in_admin_header:1`.
- `readme.txt` / `README.txt` (same inode on this case-insensitive FS) — added an Admin UX changelog line under the existing `= 3.0.0 =` section.

---

## Controller summary (`Shortcodes_For_Buddypress_Admin_Panel`)

- `get_tabs()` — single source of truth: `overview` (main) + `shortcodes / activities / members / groups` (group `reference`). Filter `bpsp_admin_tabs`.
- `register()` — `admin_menu` + `admin_menu:999` takeover + `admin_enqueue_scripts` + `in_admin_header:1`. (No `admin_init`/`register_settings` — nothing to register.)
- `add_menu()` — creates `wbcomplugins` hub only if not already present; single `add_submenu_page` for slug `shortcodes-for-buddypress`. Cap `manage_options`.
- `takeover_hub_landing()` @ 999 — reclaims the hub landing render in mixed installs.
- `enqueue_assets()` — screen-scoped via `is_our_screen()`; loads `assets/css/admin.css` + `assets/js/admin.js`, localizes `bpspAdmin.i18n`.
- `is_our_screen()` — matches `/_page_shortcodes-for-buddypress$/` OR `toplevel_page_wbcomplugins`.
- `suppress_foreign_notices()` — `remove_all_actions('admin_notices'|'all_admin_notices')` on our screen only.
- `render_hub()` / `render_page()` — render_page resolves the active tab partial and includes `shell.php`.

Menu slug `shortcodes-for-buddypress` preserved (bookmarks + documented URL stay valid).

---

## Safe fixes applied (brief scope)

1. **Dead `admin/wbcom/` removed** — including the missing `wbcom-themes-page.php` include path. Gone with the directory.
2. **`wbcom_addons_cards` nonce-no-cap (LOW, real)** — the handler was removed entirely with the wrapper (it was only reachable from the deleted wrapper UI), which resolves the finding without adding a now-orphan cap check.
3. **2 public `nopriv` load-more endpoints left AS-IS** (`bpsp_activities_load`, `bpsh_load_more_members`) — false positives, public read by design. Untouched.
4. **Native alert/confirm** — none existed in admin; the new `admin.js` uses the toast/confirm modal helpers only.
5. **Inline `<style>`** in the old general-settings panel — dropped; replaced by token-driven rules in `assets/css/admin.css`.
6. **Version / changelog** — already at 3.0.0 across header + constant + both readmes (one above tag `v2.9.1`); added the Admin UX changelog stub line.
7. **Dual-activation Pro guard** — `shortcode-for-buddypress-pro` guard in the main file left fully intact (2 references, untouched).

---

## Verification

- **`php -l`** — clean on all 9 created/modified PHP files (0 syntax errors).
- **WPCS (wpcs MCP)** — `includes/admin/` directory + modified orchestrator: **No coding standard violations found** (1 fixable alignment warning was fixed).
- **Option-key parity** — 0 old `register_setting` → 0 new. No persisted settings exist, so zero data-loss surface.
- **Dangling-reference grep (Playbook 2.1)** — zero functional refs to deleted wrapper paths/handles/localized objects in PHP or JS.
- **Action-audit (Playbook 12)** — N/A by design: no `data-action`/`wp_ajax`/`admin-ajax` in any view; no orphan selectors/handlers.
- **Inline asset / dialog grep** — no `<style>`/`<script>` in new PHP; no native `alert()`/`confirm()` in JS.
- **Load test (`wp eval`)** — new class loads with no fatal; `get_tabs()` returns all 5 tabs; all 7 view files resolve on disk.
- **CSS prefix sweep** — `grep -c "bcm" assets/css/admin.css` = 0; all selectors/tokens are `bpsp-` / `--bpsp-admin-*`.

### NOT done (per brief constraints)
- No `git commit` / `git push`.
- No plugin activate/deactivate (plugin was and remains **inactive** on this site).
- No DB writes.
- **Browser render check NOT performed** — the plugin is inactive and the brief forbids activating it, so its admin page cannot be loaded in a browser. Standalone `wp eval` load + view-resolution test was used instead as the strongest in-constraint verification. **Recommend an owner browser pass after activation** (Playbook Part 13): hub renders the card grid, each tab renders cards + sidebar, 390px responsive, console + debug.log clean.

---

## TODOs / human eyes

- **Browser smoke after activation** — see above; confirm the card panel renders and the hub takeover behaves in a mixed install with the Pro pair.
- **Pre-existing `.gitignore` change** — the working tree has an unrelated stray edit (`# composer.lock.claude-tmp/`) NOT made by this migration. Left untouched; the owner should revert it before committing.
- **`audit/manifest.json` refresh** — the manifest still lists the old `admin/wbcom/*` wrapper files, the 6 old admin pages, and the `wbcom_addons_cards` AJAX entry. Re-run `/wp-plugin-onboard --refresh` after this lands so the manifest reflects the new card panel.
- **`CLAUDE.md` "Admin UI wrapper" section** — still describes the OLD legacy tab wrapper; update to the new card panel when committing.
- **Build/release (Grunt)** — `assets/css/admin.css` + `assets/js/admin.js` are hand-written, unminified. The Grunt pipeline should generate `min/` + `rtl/` siblings for these at release time (the old `admin/css|js/min|rtl` artifacts were deleted).
