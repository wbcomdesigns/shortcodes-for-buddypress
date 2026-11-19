# Frequently Asked Questions

## Does this plugin require BuddyPress?

Yes. BuddyPress must be installed and activated; it is declared as a required plugin. Each shortcode also needs its matching BuddyPress component enabled (Activity, Members, or Groups).

## How many shortcodes does the plugin add?

Three: `[activity-listing]`, `[members-listing]`, and `[groups-listing]`. Each has a matching Elementor widget.

## Do I need Elementor?

No. The shortcodes work anywhere shortcodes are accepted. Elementor is only needed if you prefer to place the widgets visually.

## Can I run the free and Pro plugins together?

No. Shortcode For BuddyPress Pro is a separate, mutually exclusive plugin. If Pro is active, activating this free plugin deactivates itself and shows a notice. Run one or the other.

## What does the Pro plugin add?

The Pro plugin extends the same shortcodes with custom queries and templates. Every shortcode, attribute, and Elementor widget documented here is available in the free plugin.

## Why don't activity comments show?

Comments are intentionally forced off in this version. The `display_comments` attribute exists but the shortcode always sets the activity query's comment display to off, to avoid a BuddyPress compatibility error. Passing `display_comments="true"` has no effect in the current release.

## Why did my [groups-listing] ordering not change?

In BuddyPress, `type` overrides `orderby` and `order`. The shortcode defaults `type` to `alphabetical`. When you set `orderby` or `order` and leave `type` at its default, the shortcode drops the default `type` so your ordering applies. If you also pass an explicit `type=`, that wins, matching BuddyPress.

## How do I change the number of items shown?

Use `per_page`. Defaults are 10 for activity and 20 for members and groups. For example `[members-listing per_page="12"]`.

## How do I show a grid instead of a list?

For members and groups, use `grid="yes"` with `loop_layout="one|two|three|four"`. Use `grid="no"` for a plain list.

## Where is the plugin's admin screen?

Under the shared Wbcom Plugins menu. Its tabs (Overview, Shortcodes, Activities, Members, Groups, Discover) are an informational reference. The plugin has no settings to save.

## Do shortcodes follow my members or groups directory lock?

No, on purpose. A privacy plugin that locks the BuddyPress directories for logged-out visitors does not hide shortcode output, because you choose where each shortcode goes. To keep a listing private, put the shortcode on a page that only logged-in members can open.

## Does it work with BuddyBoss?

Yes. When the BuddyBoss Platform is active, the members and groups listings render through BuddyBoss template variants automatically.

## Where do I get support?

Visit [wbcomdesigns.com](https://wbcomdesigns.com/) for any questions related to the plugin and BuddyPress.
