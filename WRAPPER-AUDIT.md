# Wrapper Audit — shortcodes-for-buddypress

**Audited:** 2026-06-05
**Branch / Version:** 3.0.0
**Wrapper type:** NEW card-panel (`includes/admin/class-shortcodes-for-buddypress-admin-panel.php`)
**Auditor note:** This plugin persists ZERO settings — all tabs are informational reference panels. The full option-wiring section is N/A by confirmed design.

---

## 1. Controller Class Correctness

**Controller file:** `includes/admin/class-shortcodes-for-buddypress-admin-panel.php`

| Method | Present | Notes |
|---|---|---|
| `get_tabs()` | YES — line 46 | Static; returns 5 tabs (overview + 4 reference); filterable via `bpsp_admin_tabs` |
| `register()` | YES — line 82 | Hooks: `admin_menu`, `admin_menu@999` (hub takeover), `admin_enqueue_scripts`, `in_admin_header:1` |
| `add_menu()` | YES — line 98 | Creates `wbcomplugins` hub if absent; single `add_submenu_page` for slug `shortcodes-for-buddypress` |
| `takeover_hub_landing()` | YES — line 133 | `remove_all_actions('toplevel_page_wbcomplugins')` + re-adds own hub render at priority 999 |
| `enqueue_assets()` | YES — line 148 | Screen-scoped via `is_our_screen()`; loads `assets/css/admin.css` + `assets/js/admin.js`; localizes `bpspAdmin.i18n` |
| `is_our_screen()` | YES — line 207 | Regex `/_page_shortcodes-for-buddypress$/` OR exact `toplevel_page_wbcomplugins` |
| `suppress_foreign_notices()` | YES — line 191 | `remove_all_actions` on `admin_notices` + `all_admin_notices`; screen-gated |
| `render_hub()` | YES — line 220 | Includes `includes/admin/views/hub.php` |
| `render_page()` | YES — line 232 | Resolves active tab via `$_GET['tab']`, maps to view partial, includes `shell.php` |
| `register_settings()` | N/A | Plugin persists zero options — by confirmed design |
| `sanitize_settings()` | N/A | No settings to sanitize — by confirmed design |
| `admin_init` hook | N/A | No `register_setting()` call needed — by confirmed design |

**Verdict: PASS.** All applicable contract methods are present and correct. Missing methods are correctly absent by design.

---

## 2. Path-Constant Resolution

### Primary constants (defined in main plugin file `shortcodes-for-buddypress.php`)

```
Line 65: define( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
Line 69: define( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
```

`__FILE__` here is the main plugin bootstrap at the plugin root. Both constants resolve to the plugin root directory / URL. These are defined before `load_dependencies()` is ever called, so they are always set by the time the admin panel class loads.

### View-include paths in the controller

```php
// render_hub(), render_page(): __DIR__ = includes/admin/
plugin_dir_path( __DIR__ ) . 'admin/views/hub.php'
```

`plugin_dir_path()` on a directory argument strips the trailing path component (treating the directory as a file), returning `includes/`. Appending `'admin/views/hub.php'` gives `includes/admin/views/hub.php` — the correct absolute path. All 7 view files verified to exist at that path.

### Asset URL fallback in `enqueue_assets()`

```php
$base = defined( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_URL' )
    ? SHORTCODES_FOR_BUDDYPRESS_PLUGIN_URL
    : plugins_url( '/', dirname( __DIR__ ) );
```

Primary branch (the constant) is always set and resolves to the plugin root URL — **CORRECT**.

Fallback branch (`plugins_url('/', dirname(__DIR__))`) passes a directory path rather than a file path to `plugins_url()`. WordPress's internal `plugin_basename()` still resolves this correctly to the plugin root (it strips `WP_PLUGIN_DIR` and then `dirname()` of the relative sub-path yields the plugin slug). The fallback is technically correct but uses an unidiomatic directory-not-file argument. This is a LOW hygiene note only; the fallback is unreachable in any normal activation flow.

**Verdict: PASS.** No path resolves to a 404 or an `includes/` sub-path. The ads-plugin blank-body class of bug is not present here.

---

## 3. Wrapper Structure / Gaps

### Required view files

| File | Exists | Role |
|---|---|---|
| `includes/admin/views/shell.php` | YES | Header card + sidebar nav + body slot |
| `includes/admin/views/hub.php` | YES | WB Plugins hub landing dashboard |
| `includes/admin/views/overview.php` | YES | Active tab body: shortcode + widget summary + component status |
| `includes/admin/views/reference-shortcodes.php` | YES | Ported Welcome + General info panels |
| `includes/admin/views/reference-activities.php` | YES | `[activity-listing]` parameter reference |
| `includes/admin/views/reference-members.php` | YES | `[members-listing]` parameter reference |
| `includes/admin/views/reference-groups.php` | YES | `[groups-listing]` parameter reference |

Shell renders: page header (title + version badge), stats-card row (on overview), left sidebar nav built from `get_tabs()`, body that `file_exists`-guards the active partial via `$view_path`. No `<form>` branch — correct for a zero-settings plugin.

### Tab ↔ View map — complete

| Tab slug | view_map entry | View file | Dead link? | Orphan? |
|---|---|---|---|---|
| `overview` | `overview` | `overview.php` | NO | NO |
| `shortcodes` | `reference-shortcodes` | `reference-shortcodes.php` | NO | NO |
| `activities` | `reference-activities` | `reference-activities.php` | NO | NO |
| `members` | `reference-members` | `reference-members.php` | NO | NO |
| `groups` | `reference-groups` | `reference-groups.php` | NO | NO |

No dead nav links. No orphan view files (all 7 files serve a purpose: 5 tab partials + shell + hub).

### Legacy wrapper removal — confirmed clean

| Check | Result |
|---|---|
| `admin/wbcom/` directory | DELETED — not present |
| `admin/settings/` directory | DELETED — not present |
| `admin/class-shortcodes-for-buddypress-admin.php` | DELETED — not present |
| `admin/css/` + `admin/js/` legacy asset dirs | DELETED — not present |
| `[wbcom_admin_setting_header]` shortcode references | ZERO functional refs in PHP |
| `Wbcom_Admin_Settings` class references | ZERO functional refs |
| `wbcom_addons_cards` AJAX handler | ZERO refs (removed with wrapper) |
| `nav-tab-wrapper` + `settings_fields` + `do_settings_sections` calls | ZERO (all in docblock comments only) |
| `wbcom-designs` top-level menu slug | ZERO refs |
| `shared-admin` / `shared_admin` references | ZERO refs |

The only remaining references to deleted paths are two descriptive docblock comments (controller file line 6, orchestrator line 138) that describe what was removed — these are intentional documentation, not dangling functional refs.

---

## 4. Option Wiring

This plugin persists **zero settings** — confirmed by:
- `manifest.json` `settings[]` array: single entry `"key": "(none persisted)"`, explicitly states no `register_setting()` calls
- `BUILD-LOG.md`: "This plugin persists ZERO settings — it never calls `register_setting()` (verified: 0 old, 0 new)"
- Full grep of all PHP for `register_setting`, `settings_fields`, `options.php` → zero hits in any non-deleted file
- No `<form>` elements in any view file; no `admin_init` hook in the controller

**Multi-tab data-loss guard (Playbook 7.1):** N/A — nothing saves to the database.

**Option wiring verdict: N/A — confirmed zero persisted options, correctly implemented.**

---

## 5. Hygiene Checks

### Native alert()/confirm() in admin JS
**PASS.** `assets/js/admin.js` has no `window.alert()` or `window.confirm()`. It exposes `window.bpspToast()` and `window.bpspConfirm()` modal helpers; the `[data-bpsp-confirm]` intercept uses these exclusively.

### Screen-scoped enqueue
**PASS.** `enqueue_assets()` calls `get_current_screen()` and returns early unless `is_our_screen()` matches. Assets load only on `wbcomplugins_page_shortcodes-for-buddypress` and `toplevel_page_wbcomplugins`.

### CSS token system
**PARTIAL PASS / LOW hygiene findings:**

- Token declarations in `:root {}` (lines 17–42) are correctly defined with `--bpsp-admin-*` prefix.
- **8 consumer violations:** `color: #fff` appears on 7 lines (button/badge text) and `color: #92400e` on 1 line (`.bpsp-notice--warn` amber text). These should use `var(--bpsp-admin-white)` and a new `--bpsp-admin-warn-text` token respectively. The token `--bpsp-admin-white: #ffffff` exists but is not consumed at these sites.
- `var()` fallback arguments (e.g., `var(--bpsp-admin-success, #047857)`) are acceptable defensive code.
- **No raw hex outside the token definitions and these 8 consumer sites.**

### Button tap targets
**LOW finding:** `.bpsp-btn` has `min-height: 36px` (line 570). The brief requires ≥ 40 px. These buttons are used as "View Parameters" navigation links in `overview.php` and `reference-shortcodes.php` — touch-reachable interactive targets.

### Sidebar nav-link tap targets
`.bpsp-snav-link` has `padding: 9px 10px` + `font-size: 13px * 1.4 line-height` = approximately 36px computed height; no explicit `min-height` set. Marginally under the 40px threshold.

### Responsive breakpoints
- 1024px: sidebar collapses to horizontal nav row — CORRECT for tablet layout.
- 640px: header stacks, form-table cells block, stats grid single column — CORRECT.
- **480px breakpoint absent.** The brief requires "no broken layout < 480px" and stacking under 480px. The 640px breakpoint already handles most stacking; the gap is that between 481px and 639px the horizontal sidebar nav may wrap awkwardly on very narrow viewports. LOW finding.

### Inline styles in view files
Two `style="margin: 0 ..."` attributes on `<p>` tags in `hub.php` lines 116 and 119. These control body copy spacing inside `.bpsp-card__body`. LOW hygiene — should be utility classes or token-driven margin.

### Dark mode
No `prefers-color-scheme: dark` media query. Not a blocker for an admin-only page (WP admin itself doesn't ship a dark mode), but worth noting as a portfolio-consistency gap.

---

## 6. Severity-Ranked Findings

| # | Severity | Area | Finding | File:line | Suggested fix |
|---|---|---|---|---|---|
| 1 | LOW | CSS | `.bpsp-btn` min-height is 36px; brief requires ≥ 40px tap target | `assets/css/admin.css:570` | Change `min-height: 36px` to `min-height: 40px`; adjust padding if needed |
| 2 | LOW | CSS | `.bpsp-snav-link` has no explicit min-height; computed ~36px (below 40px) | `assets/css/admin.css` (`.bpsp-snav-link` block) | Add `min-height: 40px` |
| 3 | LOW | CSS | 7× `color: #fff` on button/badge text — token `--bpsp-admin-white` exists but not consumed | `assets/css/admin.css:127,173,178,576,584,609,769` | Replace with `color: var(--bpsp-admin-white)` |
| 4 | LOW | CSS | `color: #92400e` on `.bpsp-notice--warn` — no amber-text token defined | `assets/css/admin.css:684` | Add `--bpsp-admin-warn-text: #92400e` to `:root` and consume via token |
| 5 | LOW | CSS | No 480px breakpoint — brief requires stacking under 480px | `assets/css/admin.css` | Add `@media (max-width: 480px)` rule if layout breaks between 480–639px |
| 6 | LOW | HTML | Two inline `style="margin: 0 ..."` attributes in hub.php | `includes/admin/views/hub.php:116,119` | Extract to a CSS class e.g. `.bpsp-about-body-p` |
| 7 | LOW (docblock) | PHP | Shell docblock declares `@var string $view` but `render_page()` sets `$view_slug` not `$view`; no runtime impact | `includes/admin/views/shell.php:10` | Update docblock: `@var string $view_slug` |
| 8 | INFO | JS fallback | `plugins_url('/', dirname(__DIR__))` passes a directory not a file (unidiomatic); resolves correctly at runtime; unreachable in normal activation | `includes/admin/class-shortcodes-for-buddypress-admin-panel.php:156` | Change to `plugins_url('/', __FILE__)` or just drop the fallback since the constant is always set |

No Blockers. No Majors. All findings are LOW or INFO hygiene.

---

## 7. Overall Verdict

**SHIP-CLEAN** (with optional LOW-priority polish before next release)

The migration is structurally correct:

- Controller contract fully implemented for a zero-settings plugin (all N/A methods are correctly absent).
- Path-constant resolution is correct — the ads-plugin blank-body / 404-asset class of bug is not present. View includes and asset URLs both resolve to the plugin root.
- Tab ↔ view map is complete: 5 tabs → 5 partials, all files exist, zero dead links, zero orphan views.
- Legacy wrapper fully removed: `admin/wbcom/`, `admin/settings/`, legacy admin class, legacy CSS/JS trees — all gone with zero dangling functional references.
- Option wiring: zero settings confirmed end-to-end; no `register_setting`, no save handler, no form — all correct.
- Admin JS uses toast/confirm modal helpers; no native `alert()`/`confirm()`.
- Enqueue is screen-scoped.

The 8 findings above are all LOW polish items (tap target 4px short, 8 raw-hex consumer sites, one missing breakpoint, two inline margin attributes, one stale docblock comment, one unidiomatic but correct fallback URL). None is a functional blocker; none risks data loss or a blank page. They should be addressed in the next CSS/HTML polish pass before a public WP.org submission.

**Browser smoke still recommended** after activation (per BUILD-LOG.md): confirm hub card grid renders, each tab renders within the shell, sidebar nav highlights the active tab, 390px viewport shows horizontal nav row, and browser console is clean.
