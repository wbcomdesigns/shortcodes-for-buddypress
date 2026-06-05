# wppqa Baseline — Shortcodes For BuddyPress

- **Date:** 2026-06-05
- **Branch:** 3.0.0
- **Plugin version:** 3.0.0
- **Plugin path:** `wp-content/plugins/shortcodes-for-buddypress`

Run BEFORE manifest generation per onboarding hard rule #6.

## Per-check results

| Check | Passed | Failed | Skipped | Verdict |
|---|---|---|---|---|
| `wppqa_check_plugin_dev_rules` | 6 | 3 | 0 | 3 high-severity nonce-no-cap findings |
| `wppqa_check_rest_js_contract` | 0 | 0 | 1 | Skipped — plugin registers no REST routes |
| `wppqa_check_wiring_completeness` | 0 | 0 | 1 | Skipped — no `includes/admin/` setting keys |

Release-readiness gate (hard rule #6): NOT release-ready while `failed > 0`.

## Findings — plugin-dev-rules (3 high)

All three: `wp_verify_nonce()` present, no paired `current_user_can()`.

### 1. admin/wbcom/wbcom-admin-settings.php:44 — wbcom_addons_cards_links()
- Raw: high. Triaged: LOW (real hygiene gap).
- AJAX action `wp_ajax_wbcom_addons_cards` (logged-in only, no nopriv).
  Sanitizes a posted string and echoes it back, then die. No DB write, no
  privileged read. Nonce gates CSRF; nothing to authorize. Should still add
  `current_user_can('manage_options')` as defense-in-depth.

### 2. public/class-shortcodes-for-buddypress-public.php:303 — buddypress_shortcode_ajax_load_more_members()
- Raw: high. Triaged: FALSE POSITIVE / by design.
- Registered for BOTH wp_ajax_bpsh_load_more_members AND
  wp_ajax_nopriv_bpsh_load_more_members. Paginates the public members
  directory. A capability check would break the logged-out feature.
  Nonce-only is correct for a public read endpoint.

### 3. public/class-shortcodes-for-buddypress-public.php:644 — buddypress_shortcodes_load_activities()
- Raw: high. Triaged: FALSE POSITIVE / by design.
- Registered for BOTH wp_ajax_bpsp_activities_load AND
  wp_ajax_nopriv_bpsp_activities_load. Paginates the public activity stream.
  Public-read by design; nonce-only is correct.

## Net assessment
- 1 of 3 is a real low-severity hygiene gap (#1).
- 2 of 3 are false positives: public nopriv read endpoints where a cap check
  would be a regression. The check does not distinguish nopriv-registered actions.
- No REST surface, no DB tables, no cron, no persisted settings.
