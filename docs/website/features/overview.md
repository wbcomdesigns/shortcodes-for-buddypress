# Feature Overview

## Three BuddyPress shortcodes

Embed BuddyPress directories on any post or page:

- `[activity-listing]` shows the activity stream, with optional filtering by scope, user, object, action, and search terms.
- `[members-listing]` shows the members directory, with grid or list layout and one to four columns.
- `[groups-listing]` shows the groups directory, with grid or list layout, ordering, and status filtering (public, private, hidden).

See the Shortcode Reference for every attribute and its default.

## Three matching Elementor widgets

Under the Elementor "BuddyPress Widgets" category:

- BuddyPress Activity
- BuddyPress Members
- BuddyPress Groups

Each widget's content controls map to the same attributes as its shortcode, plus Elementor style controls for the container and items. The widgets build on the same rendering code as the shortcodes.

## Grid and list layouts

The members and groups shortcodes support a grid layout (`grid="yes"`) with a column count (`loop_layout="one|two|three|four"`), or a plain list (`grid="no"`).

## Theme compatibility

The plugin renders through the BuddyPress Nouveau template pack and ships BuddyBoss (`bb-`) template variants that are used automatically when the BuddyBoss Platform is active. It also includes specific directory-class handling for the Reign theme and cover-image handling for the BuddyX and Reign themes.

## Load more for activity

The activity listing can use a load-more control (`load_more="1"`) that fetches the next page over AJAX. The request is available to logged-in and logged-out visitors and its page size is clamped server-side.

## Conditional asset loading

Plugin CSS and JS load only on pages that actually contain one of the shortcodes or Elementor widgets, detected from the post content and Elementor data.

## Informational admin area

The plugin adds documentation-only tabs under the shared Wbcom Plugins menu: Overview, Shortcodes, Activities, Members, Groups, and Discover. There are no persisted settings; the tabs are a built-in reference for the shortcodes and their attributes.

## No Pro-only features bundled here

This free plugin contains all three shortcodes and widgets in full. The separate Pro plugin adds custom queries and templates on top of the same shortcodes and is not required for any feature listed above.
