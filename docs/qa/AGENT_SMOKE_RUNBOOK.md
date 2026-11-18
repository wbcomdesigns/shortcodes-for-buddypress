# Agent Smoke Runbook - Shortcodes & Elementor Widgets For BuddyPress

**Audience:** a browser-capable agent with Playwright MCP + WP-CLI Bash access, or a human QA person with the same access.

## How to read this runbook

Each C and E step is a **customer contract**: what the feature promises and what "working" looks like. It does not prescribe selectors or exact calls. Read the code first (`public/shortcode/class-shortcodes-for-buddypress-shortcode.php` for the shared attribute handling and list class builder, `public/shortcode/class-member-shortcode.php`, `class-group-shortcode.php` and `class-shortcode-for-activity-listing.php` for each shortcode, `templates/nouveau/` for the markup, `public/class-shortcodes-for-buddypress-public.php` for assets and the load-more AJAX, `elementor/` for the widgets, `includes/admin/` for the admin panel), pick the mechanism and verify the contract.

D rows are repros of past incidents; the fixture is the contract.

Surfaces: three shortcodes (`[activity-listing]`, `[members-listing]`, `[groups-listing]`), three matching Elementor widgets (Activity List, Members List, Groups List in the BuddyPress Widgets category), one public AJAX action (`bpsp_activities_load`) and the informational admin panel under WB Plugins > BP Shortcodes (`admin.php?page=shortcodes-for-buddypress`, tabs Overview, Shortcodes, Activities, Members, Groups, Discover). No settings, no options written, no tables, no REST, no cron, no blocks, no WP-CLI. Inventory: `audit/manifest.json`.

## Global preconditions

- Working directory: `~/code/shortcodes-for-buddypress`
- Site URL: BuddyPress lane `http://localhost:8312` (`base_url` in `docs/qa/qa-config.json`); BuddyBoss lane `http://localhost:8311` for section E.
- WP-CLI: `wp --path="<lane WP root>" <cmd>`
- Admin auto-login: `?autologin=1`; per-user auto-login: `?autologin=<user_login>`
- Plugin version constant: `SHORTCODES_FOR_BUDDYPRESS_VERSION`
- **Shortcodes for BuddyPress Pro must be inactive.** Pro ships the same class names and its own templates; while it is active the free plugin deactivates itself (see C.pro-active) and every listing is Pro's output, so nothing below tests the free code.
- Requires BuddyPress or BuddyBoss Platform with the Members, Groups and Activity components on. Elementor is needed for the widget rows only.
- Themes: Reign and BuddyX are the primary themes; a Twenty-series theme is the control.
- Personas: `journey_member` (subscriber, logged-in member), `journey_other` (subscriber), the admin, and a logged-out visitor. Seed at least 12 members and 8 groups so a 4-column row fills.
- Pair plugin: none. Pro is a replacement, not an add-on (`pair: null`).

## Output contract

Write one JSON file to `~/code/shortcodes-for-buddypress/docs/qa/.last-smoke-pass.json` with the same shape as the portfolio runbook (`mode`, `release_version`, `ran_at`, `sections` A to F with pass/fail/skipped, `failures`, `debug_log_issues`, `manual_required`, `hard_fails`, `untested`, `coverage`, `layer1_delta`). Every authored row you did not run goes in `untested` with a reason.

## Fixture cleanup (before every walk)

```bash
# Pro off, personas present, fixture pages rebuilt.
wp --path="<lane WP root>" plugin deactivate shortcode-for-buddypress-pro 2>/dev/null
wp --path="<lane WP root>" user create journey_member journey_member@example.com --role=subscriber 2>/dev/null
wp --path="<lane WP root>" user create journey_other journey_other@example.com --role=subscriber 2>/dev/null
wp --path="<lane WP root>" option delete bp_nouveau_appearance   # Reign default-layout rows set it per row
```

Fixture pages (recreate if missing, slugs match `front_routes`):

- `/bpsp-members/`: one `[members-listing per_page="12" grid="yes" loop_layout="X"]` per value X in one, two, three, four, plus one with no `loop_layout` and one with `grid="no"`. One shortcode per page is easier to measure; separate pages are fine.
- `/bpsp-groups/`: the same set with `[groups-listing per_page="8" ...]`.
- `/bpsp-activity/`: `[activity-listing per_page="5" load_more="1"]` and `[activity-listing allow_posting="yes"]`.
- `/bpsp-elementor/`: an Elementor page holding the Members List, Groups List and Activity List widgets.

## Debug log protocol

Enable WP_DEBUG + WP_DEBUG_LOG + WP_DEBUG_DISPLAY=false before Section A. Baseline `wp-content/debug.log`, diff after every section into `debug_log_issues[]`. Any new fatal, warning or notice from this plugin is a failure.

---

## A - Fresh install

### A1 - Activation
**What to verify:** with BuddyPress (or BuddyBoss Platform) active, activation succeeds with no notice and writes no option (there is no activation hook). WB Plugins > BP Shortcodes opens on Overview.

### A2 - BuddyPress missing
**What to verify:** with neither BuddyPress nor BuddyBoss Platform active, the next admin load deactivates the plugin and shows the requirement notice; no fatal. Before that admin load, a front-end page with a shortcode shows the "please enable" notice, not a fatal.

---

## B - Upgrade and uninstall

### B1 - Update from the previous release
**What to verify:** install the previous release zip, build the fixture pages, update to this build: no fatal, every page renders, `SHORTCODES_FOR_BUDDYPRESS_VERSION` reads the new version.

### B2 - Migration resumes after a kill
na: owner policy. The plugin stores nothing, so there is no migration.

### B3 - Deactivate and uninstall
**What to verify:** deactivating leaves the shortcode text showing as plain `[members-listing ...]` on pages (WordPress behaviour); deleting the plugin removes nothing because nothing is stored.

---

## C - Core customer flows

Exercise every UI row at desktop 1440px and mobile 390px.

### C.members.grid
**What to verify:** on `/bpsp-members/`, `loop_layout` one, two, three and four give 1, 2, 3 and 4 cards per row at 1440 (measure the `li` widths against the `ul`, do not eyeball), and no `loop_layout` gives 3. The `ul` carries `grid` plus the column class (`one`, `two`, `three`, `four`) and `bpsp-members-list`; on Reign also `rg-member-list` and `wbtm-member-directory-type-*`.

### C.members.list
**What to verify:** `grid="no"` gives one member per row whatever `loop_layout` says, and the `ul` has no `grid` or column class.

### C.groups.grid / C.groups.list
**What to verify:** the same two rows on `/bpsp-groups/` (`bpsp-groups-list`, and on Reign `rg-group-list` plus `wbtm-group-directory-type-*`). Group cards show the group's own cover image.

### C.mobile
**What to verify:** at 390px every grid is 1 column; between 480px and 598px, three and four drop to 2; no horizontal overflow from the listing itself.

### C.reign-default-layout
**What to verify:** on Reign with BuddyPress, set the site's members directory layout to 4 columns (`wp option update bp_nouveau_appearance '{"members_layout":4,"groups_layout":2}' --format=json`): `[members-listing]` with no `loop_layout` shows 4 columns and `[groups-listing]` shows 2; an explicit `loop_layout` still wins. Delete the option afterwards. On BuddyBoss the setting does not exist, so the default stays three.

### C.attributes
**What to verify:** `per_page="0"`, `"-5"`, `""` and `"abc"` list the default count (20 for members and groups, 10 for activity), `per_page="500"` lists at most 100, and `type="bogus"` lists like the default type (members `active`, groups `alphabetical`). Pagination links sit centered under the list and move between pages.

### C.activity
**What to verify:** `/bpsp-activity/` lists the stream. Load more appends the next page through `bpsp_activities_load` (nonce `bpsp-nonce`); a request with a bad nonce is refused and a `limit` above 50 returns at most 50. `allow_posting="yes"` shows the post form to `journey_member` only; a logged-out visitor and any `allow_posting="no"` never see it.

### C.elementor
**What to verify:** on `/bpsp-elementor/` the three widgets render the same markup as their shortcodes, and the plugin CSS and JS load even though the page content is empty (the `_elementor_data` scan). The free widgets have no grid or layout controls, so the Members and Groups widgets render `grid="yes"` with the default layout (C.reign-default-layout applies). Widgets appear in the editor under BuddyPress Widgets.

### C.components-off
**What to verify:** turning off Activity, Groups or Members makes the matching shortcode show "To view activities, please enable the activity component.", "To view groups, please enable the group component." or "To view members, please enable BuddyPress."; no fatal. `[members-listing]` works with Extended Profiles off.

### C.pro-active
**What to verify:** with Pro installed, activating Pro deactivates the free plugin and the admin shows "... cannot be activated simultaneously. Please deactivate ...". Record the result, then deactivate Pro and reactivate free before any other row.

### C.admin
**What to verify:** as admin, WB Plugins > BP Shortcodes shows Overview, Shortcodes, Activities, Members, Groups and Discover; each tab renders; an unknown `?tab=` falls back to Overview. A subscriber cannot open the page. No tab has a form or saves anything.

---

## CP - Presentation

### CP.theme-fit
**What to verify:** on Reign, BuddyX and a Twenty-series theme, light and dark, 1440 and 390: cards inherit theme styling, column counts match C.members.grid and C.groups.grid, no horizontal overflow at 390px.

### CP.states
**What to verify:** a listing with no results shows BuddyPress's own "no members / no groups / no activity" message, not a blank area; the component-off notices from C.components-off.

### CP.entry-points
**What to verify:** front end (shortcodes, Elementor widgets) and admin (reference panel) are the entry points. There is no data store and no REST surface by design: record REST as `na: owner policy` in `coverage`.

### CP.console-and-assets
**What to verify:** zero JS console errors on every fixture page and the admin panel; the plugin CSS and JS load only on pages with a shortcode or widget; `public/css/min/` files load unless `SCRIPT_DEBUG`, `public/css/rtl/` on RTL.

---

## D - Known-regression guards

| ID | Bug | Fixture + assertion |
|----|-----|---------------------|
| D.bb-loop-layout | On BuddyBoss Platform every loop_layout showed 3 columns at 1440 (the platform's 33.33% grid rule won) | BuddyBoss lane, Reign: two = 2, four = 4, one = 1 per row. |
| D.layout-one | loop_layout="one" shrank cards to content width (5 to 12 per row) on BuddyPress themes | BuddyPress lane, Reign and BuddyX: one = 1 per row. |
| D.reign-grid-no | On Reign grid="no" and loop_layout were ignored | Reign: grid="no" is a list, two is 2 columns. |
| D.bb-groups-meta | BuddyBoss groups button row was classed "-meta" so Reign's group button styling missed it | BuddyBoss lane: the Join row has `groups-meta action`. |
| D.per-page-negative | A negative per_page became a positive count, zero listed every row | per_page -5 and 0 list the default count. |
| D.allow-posting | allow_posting="no" still showed the post form | No form for "no" or for a logged-out visitor. |
| D.bp-off-fatal | Activity and groups shortcodes fataled with BuddyPress inactive | Notice, no fatal. |
| D.assets-404 | Front-end CSS and JS 404'd (wrong min path) and the JS threw on load | Assets 200, zero console errors. |

---

## E - Integrations

### E.buddypress
**What to verify:** on the BuddyPress lane (`http://localhost:8312`, BuddyPress 14.x, Nouveau) every C row works; listings use the `bp-shortcodes-*.php` templates.

### E.buddyboss
**What to verify:** on the BuddyBoss lane (`http://localhost:8311`) every C row works with the `bb-shortcodes-*.php` templates, including D.bb-loop-layout and D.bb-groups-meta.

### E.themes
**What to verify:** Reign and BuddyX on both lanes as in CP.theme-fit. Reign adds its card classes to the list; BuddyX does not.

### E.elementor
**What to verify:** with Elementor active C.elementor passes on both lanes; with Elementor inactive nothing errors and the shortcodes still work.

## E2 - Environment

| Row | Walk | Pass bar |
|---|---|---|
| E2.php-latest | C rows with WP_DEBUG on PHP 8.5 | No deprecations from this plugin |
| E2.scale | 2000+ members and 500+ groups, per_page 100 | Pages render without timeout; per_page never exceeds 100 |
| E2.textdomain | WP_DEBUG on WP 6.7+ | No `_load_textdomain_just_in_time` notice for `shortcodes-for-buddypress` |
| E2.multisite | Network-activate on a BuddyPress multisite | No fatal; listings render on the main site |

## F - Cross-browser, RTL, accessibility

- **F.firefox / F.safari-ios:** add the grid at 390px and the activity load more to `manual_required[]`.
- **F.rtl:** on an RTL locale the grids mirror with the same column counts and no overflow.
- **F.a11y:** listings are `ul`/`li`, pagination links and load more are keyboard reachable with visible focus.
