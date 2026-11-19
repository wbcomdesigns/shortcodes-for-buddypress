# Troubleshooting

## The listing is missing or shows a "please enable" notice

The matching BuddyPress component is disabled. Administrators see a "please enable" notice; visitors see nothing. Enable it under Settings > BuddyPress > Components:

| Shortcode | Component to enable |
|---|---|
| `[activity-listing]` | Activity |
| `[members-listing]` | Members |
| `[groups-listing]` | Groups |

## An admin-only message asks me to switch on the Nouveau template pack

Since 3.0.0 the shortcodes render through the BuddyPress Nouveau templates. If the site uses the legacy template pack and the Nouveau template functions are unavailable, the listing is replaced by this notice. Only administrators see it. Go to Settings > BuddyPress > Options and select the Nouveau template pack.

## The plugin deactivated itself on activation

The Pro plugin (Shortcode For BuddyPress Pro) is active. The free and Pro plugins cannot run at the same time. Deactivate one of them; the notice names which two are in conflict.

## Nothing renders and there is no notice

- Confirm the shortcode name is spelled exactly: `activity-listing`, `members-listing`, or `groups-listing`.
- Confirm the shortcode is on the front end. Shortcodes do not render inside the WordPress admin (except AJAX and the Elementor preview).
- Confirm BuddyPress is active and the component is enabled.

## Styles look wrong or unstyled

The plugin loads its CSS and JS only on pages it detects as containing a shortcode or one of its Elementor widgets. If you inject the shortcode in a way the detection does not see (for example rendered from an unexpected location), the assets may not enqueue. Place the shortcode directly in the post or page content, or use the Elementor widget.

## Load more does not work on activity

- Confirm you enabled it with `load_more="1"`.
- Load-more uses AJAX with a nonce; a stale page (for example a heavily cached page) can carry an expired nonce. Reload the page.

## Group ordering is ignored

See the ordering note on the `[groups-listing]` reference. Setting `orderby` or `order` while leaving the default `type` lets your ordering apply; an explicit `type=` overrides ordering, matching BuddyPress.

## Activity comments do not appear

This is expected in the current version. Comments are forced off to avoid a BuddyPress compatibility error; the `display_comments` attribute has no effect.

## Reign or BuddyBoss layout differs from BuddyPress

This is intentional. The plugin swaps in Reign's directory classes when the Reign theme is active, and BuddyBoss template variants when the BuddyBoss Platform is active, so listings match the surrounding theme.
