# Shortcodes Overview

The plugin registers exactly three shortcodes. Each is documented on its own page with every attribute it accepts and the real default from the code.

| Shortcode | Renders | Requires component | Reference |
|---|---|---|---|
| `[activity-listing]` | Activity stream | Activity | See [activity-listing] |
| `[members-listing]` | Members directory | Members | See [members-listing] |
| `[groups-listing]` | Groups directory | Groups | See [groups-listing] |

## How attributes are handled

Every shortcode merges the attributes you pass with its defaults using WordPress `shortcode_atts()`, so any attribute not in the list below is discarded. The merged attributes then pass through a filter named after the tag (`activity-listing_attributes`, `members-listing_attributes`, `groups-listing_attributes`) before rendering, which developers can use to change values site-wide. See the Developer Guide.

## Common conventions

- `title` adds an `<h4>` heading above the listing. It is empty by default (no heading).
- `per_page` sets how many items each page shows.
- `container_class` is added to the wrapping element.
- Attributes documented with a default of `false` are optional filters; leave them out to not apply them.
- The members and groups shortcodes share `grid` (yes/no) and `loop_layout` (one, two, three, four) for layout.

## Rendering notes that apply to all three

- Shortcodes do not render inside the WordPress admin (except AJAX and the Elementor preview); they render on the front end.
- If the matching BuddyPress component is disabled, the shortcode outputs a short notice instead of a listing.
- All three render through the BuddyPress Nouveau template pack, with BuddyBoss `bb-` variants used automatically when the BuddyBoss Platform is active.
