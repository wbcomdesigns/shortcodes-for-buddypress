# Introduction

Shortcodes for BuddyPress (full name "Wbcom Designs - Shortcodes & Elementor Widgets For BuddyPress") lets you embed BuddyPress directories anywhere on your site. It registers three shortcodes and three matching Elementor widgets that render the BuddyPress activity stream, members directory, and groups directory on any post, page, or widget area, not just on the BuddyPress component pages.

## What it does

The plugin exposes three shortcodes:

- `[activity-listing]` renders the sitewide (or filtered) BuddyPress activity stream.
- `[members-listing]` renders the members directory as a grid or list.
- `[groups-listing]` renders the groups directory as a grid or list.

Each shortcode has a matching Elementor widget under the "BuddyPress Widgets" category, so you can drop the same output into an Elementor layout without writing a shortcode by hand.

The listings render through BuddyPress's Nouveau template pack, and the plugin also ships BuddyBoss (`bb-`) template variants used automatically when the BuddyBoss Platform is active.

## Free and Pro

This is the free plugin. A separate Pro plugin, Shortcode For BuddyPress Pro (`shortcode-for-buddypress-pro`), extends the same shortcodes with custom queries and templates.

The free and Pro plugins are mutually exclusive: the main plugin file deactivates itself if the Pro plugin is active, and shows a notice that both cannot run at the same time. There are no Pro-only shortcodes bundled inside this free plugin; Pro adds its behaviour by hooking the same shortcode filters this plugin exposes (see the Developer Guide).

## Requirements

- BuddyPress installed and activated (declared as a required plugin).
- WordPress 6.5 or later.
- PHP 8.0 or later.

Elementor is optional and only needed if you want to use the widgets instead of the raw shortcodes.
