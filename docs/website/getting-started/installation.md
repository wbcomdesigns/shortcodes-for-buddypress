# Installation and Requirements

## Requirements

| Requirement | Minimum |
|---|---|
| WordPress | 6.5 |
| PHP | 8.0 |
| BuddyPress | Installed and activated (required plugin) |
| Elementor | Optional, only for the widgets |

BuddyPress is declared in the plugin header as a required plugin, so WordPress will prompt you to install and activate it. The activity, members, and groups shortcodes depend on the matching BuddyPress components being enabled. When a component is disabled, the shortcode shows an inline notice instead of a listing rather than causing an error.

## Install from the WordPress dashboard

1. Go to Plugins > Add New.
2. Search for "Shortcodes & Elementor Widgets For BuddyPress" by Wbcom Designs.
3. Click Install Now, then Activate.

## Install by upload

1. Download the plugin ZIP file.
2. Go to Plugins > Add New > Upload Plugin.
3. Choose the ZIP file and click Install Now.
4. Click Activate.

## Manual install

1. Download and extract the ZIP file.
2. Upload the `shortcodes-for-buddypress` folder to `/wp-content/plugins/`.
3. Activate the plugin through the Plugins menu in WordPress.

## Do not run Free and Pro together

If the Pro plugin (Shortcode For BuddyPress Pro) is active, activating this free plugin will deactivate itself and display a notice that the two cannot be active at the same time. Run one or the other, never both.

## After activation

The plugin adds an informational admin area under the shared Wbcom Plugins menu. It has no settings to configure; every shortcode works as soon as the plugin and BuddyPress are active. See Usage to place your first shortcode.
