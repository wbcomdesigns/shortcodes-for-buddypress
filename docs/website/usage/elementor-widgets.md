# Elementor Widgets

If Elementor is active, the plugin registers three widgets that render the same output as the shortcodes.

## Finding the widgets

Edit any page with Elementor and look for the category "BuddyPress Widgets" in the widget panel:

| Widget | Renders | Internal name |
|---|---|---|
| BuddyPress Activity | Activity stream (`[activity-listing]`) | `buddypress_shortcode_activity_widget` |
| BuddyPress Members | Members directory (`[members-listing]`) | `buddypress_shortcode_members_widget` |
| BuddyPress Groups | Groups directory (`[groups-listing]`) | `buddypress_shortcode_groups_widget` |

Drag a widget onto the canvas to place it.

## Content controls

Each widget's content controls map to the attributes of its shortcode. A control such as Title, Per Page, or Type sets the matching shortcode attribute. Only the widget controls that correspond to a real shortcode attribute are applied; other controls (style controls) do not affect the query.

## Style controls

Each widget also exposes Elementor style controls (for example background and spacing for the item container) under the Style tab. These style the output visually and are separate from the shortcode attributes.

## Pro notice

Each widget shows a "Shortcodes for BuddyPress PRO" notice promoting custom queries and templates available in the separate Pro plugin. It is informational; every content and style control listed above works in the free plugin.

## Preview and detection

The plugin detects its widgets inside a page's Elementor data and loads its CSS and JS on those pages, the same way it does for raw shortcodes. Widgets also render inside the Elementor editor preview.
