=== Wbcom Designs – Shortcodes & Elementor Widgets For BuddyPress ===
Contributors: vapvarun,wbcomdesigns
Tags: Activity, BuddyPress, Members, Groups, Shortcodes
Requires at least: 6.5
Tested up to: 7.1
Requires PHP: 8.1
Tested with BuddyPress: 14.5.2
Requires Plugins: buddypress
Stable tag: 3.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Show the BuddyPress activity stream, members directory and groups directory on any post or page, with shortcodes or Elementor widgets.

== Description ==

BuddyPress puts activity, members and groups on their own directory pages. This plugin lets you place them anywhere else too: a landing page, a sidebar-free welcome page, or a page built in Elementor.

**Three shortcodes**

* `[activity-listing]` - the activity stream with comments, favorites and load more.
* `[members-listing]` - the members directory with Add Friend and Message buttons, in a grid or a list.
* `[groups-listing]` - the groups directory with Join and Request Membership buttons, filtered to public, private or hidden groups if you like.

Each shortcode accepts attributes for things like the number of items, the title, grid or list layout and filters. The plugin's admin screen lists every attribute with examples.

**Three Elementor widgets**

If Elementor is active, BuddyPress Activity, BuddyPress Members and BuddyPress Groups widgets appear in the editor, with controls that match the shortcode attributes.

The listings render through BuddyPress's own Nouveau templates, so they pick up your theme's BuddyPress styling.

[vimeo https://vimeo.com/554193567 ]

== Installation ==

1. Install and activate BuddyPress.
2. In WordPress, go to Plugins > Add New, search for "Shortcodes for BuddyPress", then install and activate it.
3. Go to WB Plugins > BP Shortcodes to see every shortcode and its attributes.
4. Add `[activity-listing]`, `[members-listing]` or `[groups-listing]` to any page, or use the matching Elementor widget.

== Frequently Asked Questions ==

= Does this plugin require BuddyPress? =

Yes. BuddyPress must be installed and active. WordPress will ask you to activate it first.

= Which BuddyPress components do I need? =

Each shortcode needs its component turned on in Settings > BuddyPress: Activity Streams for `[activity-listing]`, User Groups for `[groups-listing]`. Members is always on. If a component is off, the shortcode shows a notice instead of the listing.

= Do I need Elementor? =

No. The shortcodes work in any editor. The Elementor widgets only appear when Elementor is active.

= Where do I ask for support? =

Please use the [plugin support forum](https://wordpress.org/support/plugin/shortcodes-for-buddypress/).

== Screenshots ==

1. The activity stream on a regular page with [activity-listing].
2. The members directory as a grid with [members-listing].
3. The groups directory with join and membership buttons with [groups-listing].
4. The admin overview: shortcodes, Elementor widgets and BuddyPress component status.
5. The shortcode reference with what each shortcode shows.
6. Every attribute of [members-listing] with examples.

== More from Wbcom Designs ==

* [BuddyX](https://wordpress.org/themes/buddyx/) - free community theme for BuddyPress and BuddyBoss sites.
* [BuddyNext](https://buddynext.com/features/) - a complete community platform for WordPress.
* [Jetonomy](https://jetonomy.org/features/) - modern discussion forums for WordPress.
* [WB Gamification](https://wbcomdesigns.com/downloads/wordpress-gamification-plugin/) - points, badges and leaderboards for your members.

== Changelog ==

= 3.0.2 - November 2026 =

* Improve  - The Activity widget no longer lists Load More Button style controls, because the widget never shows that button.
* Improve  - The Elementor Groups widget now has a Margin control, like the Members widget.
* Fix      - [activity-listing allow_posting="no"] no longer shows the post form, and logged-out visitors never see it.
* Fix      - Group cards in [groups-listing] now show the group's own cover image instead of a member cover.
* Fix      - On the Reign theme, grid="no" and loop_layout on [members-listing] and [groups-listing] are now honoured instead of always showing the site grid.
* Fix      - loop_layout one, two and four on [members-listing] and [groups-listing] now show that many columns on BuddyBoss Platform, and one is a single column on every theme.
* Fix      - On BuddyBoss, the Join button row in [groups-listing] carries the groups-meta class, so theme styling for group buttons applies.
* Fix      - page_arg on [members-listing] and [groups-listing] now changes the page link argument, so two listings on one page paginate separately.
* Fix      - slug on [groups-listing] now limits the list to the groups with those slugs instead of listing every group.
* Fix      - include_member_role with a role nobody holds now lists no members instead of every member.
* Fix      - A search containing an ampersand in [members-listing] or [groups-listing] is no longer cut at the ampersand.
* Fix      - container_class on [activity-listing] is now added to the wrapper.
* Fix      - Elementor Padding and Border Radius controls on the Members, Groups and Activity widgets now apply on the Reign theme, and the Background control on the Activity widget.
* Fix      - Elementor Members and Groups widgets no longer scroll sideways on phones.
* Fix      - A [groups-listing] search containing an ampersand, such as "Hiring & Careers", now finds the group.
* Fix      - The Add Friend and Message buttons in [members-listing] cards are spaced and centered again.
* Fix      - On BuddyBoss, the [groups-listing] list no longer carries a stray "-list" class.
* Fix      - The "please enable the component" notice is now shown to administrators only; visitors see nothing.
* Fix      - Shortcodes and Elementor widgets on regular pages load the Reign, BuddyX and BuddyX Pro BuddyPress layout.
* Security - show_hidden and status="hidden" on [groups-listing] only list hidden groups for site administrators and moderators (users with the bp_moderate capability), so a public page can no longer expose them.
* Dev      - The admin settings view file is renamed so hosting firewalls no longer block the plugin zip.
* Dev      - Added bin/build-release.sh and a .distignore that is the single exclude list for the release zip.

= 3.0.1 - November 2026 =

* Fix      - [members-listing] showed "please enable BuddyPress" on sites with the Extended Profiles component turned off. It now only needs the Members component.
* Fix      - Page links under [members-listing] and [groups-listing] are now centered below the list.
* Security - The three shortcode class files now refuse direct web access.
* Dev      - Requires PHP 8.1 or later. Tested up to WordPress 7.1 and BuddyPress 14.5.2.

= 3.0.0 - July 2026 =

Major release. The admin screen is rebuilt, the Nouveau template pack is now the only pack, and the performance settings screen has been removed. Read the upgrade notice before updating.

* New      - Rebuilt the admin screen on the Wbcom card-panel layout with sidebar navigation, a dashboard overview, and reskinned shortcode reference tabs.
* New      - Added a Discover tab listing other free Wbcom tools.
* New      - Implemented the status attribute on [groups-listing] so you can limit the directory to public, private, or hidden groups.
* Improve  - Rewrote the Elementor widgets for the three shortcodes so their controls match the shortcode attributes.
* Improve  - Reduced the plugin to a single Nouveau template pack; all three shortcodes now render through it on both BuddyPress and BuddyBoss.
* Improve  - Made the admin shortcode reference match the code, so every documented attribute is one the shortcode actually accepts.
* Improve  - Added Requires PHP and Requires Plugins headers so WordPress can enforce the BuddyPress dependency.
* Fix      - The [activity-listing] and [groups-listing] shortcodes no longer cause a fatal error when BuddyPress is inactive; they now show the same "enable BuddyPress" notice as the members shortcode.
* Fix      - Fixed the load-more control on [activity-listing], which could crash or request a missing asset.
* Fix      - Removed the leftover activity posting form that appeared to logged-out visitors.
* Fix      - Fixed Add Friend and Message buttons overlapping in the [members-listing] grid layout.
* Fix      - Fixed the grunt build so the release zip ships the real minified assets and an accurate translation template.
* Security - Clamped the load-more AJAX per_page and limit values so a public request cannot force an unbounded query.
* Dev      - Added bin/local-ci.sh as the blocking gate (PHP lint, coding standards, static analysis, functional tests) and a functional test suite covering the shortcode attribute and widget matrix.
* Dev      - Removed dead code, unused scaffolding, and the duplicated feedback notice.
* Compat   - Tested with WordPress 7.0. The plugin now requires WordPress 6.5 and PHP 8.0.

= 2.9.1 =
* Fix      - Load text domain issue.
* Fix      - Removed redundant functions for activity action wrapper.
* Fix      - Render BuddyBoss video activity in activity listing widget.
* Fix      - BuddyBoss video activity not displaying correctly.

= 2.9.0 =
* Added: Support for shortcode parameter handling in Elementor and Youzify setups.  
* Added: UI support and styling improvements for Reign, BuddyBoss, and Youzify themes.  
* Added: Function to handle default theme class integration (Reign & others).  
* Added: Proper documentation links for shortcode parameters.
* Updated: Group and member listing UIs, pagination, and comment replies with BB Platform.  
* Updated: Code readability with inline comments.  
* Updated: Language strings for better clarity and localization.  
* Updated: CSS/JS loading to occur only when shortcode or widget is active.  
* Updated: Minified JS and CSS files and included RTL support.
* Fixed: Fatal errors on plugin activation, especially with Youzify and Elementor.  
* Fixed: Load more activities not working in Elementor widgets.  
* Fixed: Share functionality in activity shortcodes.  
* Fixed: Link preview in Elementor widgets.  
* Fixed: Shortcode behavior on Youzify-powered pages.  
* Fixed: Spacing and layout issues for group/member count.  
* Fixed: PHP warnings (undefined offset), PHPCS compliance issues, and hard-coded text domain warnings.
* Removed: Obsolete code and files from the Wbcom folder for a cleaner codebase.

= 2.8.0 =
* Fix: Resolved double popup issue with Youzify after scheduling an activity.
* Fix: Addressed issues with scheduling activities in Youzify.
* Fix: Corrected image-related problems in the Youzify plugin.
* Fix: Resolved UI issues with Youzify, including activity and shortcode errors.
* Fix: Ensured scheduled time displays properly with Youzify.
* Fix: Fixed fatal errors related to activity and group listings with Youzify.
* Fix: Resolved PHP deprecation warnings across components.
* Fix: Fixed notification icon and button issues for BuddyPress and BuddyBoss themes.
* Fix: Removed pagination issues in group and member listings with Youzify.
* Fix: Resolved errors when editing activity shortcodes with Elementor.
* Fix: Fixed compatibility issues with rtMedia and Youzify activity listing shortcodes.
* Fix: Corrected spelling and translation errors in multiple components.
* Enhancement: Added Member Elementor widget compatibility with Youzify.
* Enhancement: Integrated display count functionality for rtMedia + Youzify.
* Enhancement: Added filters to modify activity and member listing outputs.
* Enhancement: Improved compatibility for group actions (Manage Groups, Request Membership) in Youzify.
* Enhancement: Enhanced CSS and UI for group and member shortcodes with Elementor.
* Enhancement: Added filters for modifying notifications and group query arguments.
* Enhancement: Added action hooks before and after rendering activity and member shortcodes.
* Enhancement: Added admin notices for missing templates or disabled BuddyPress components.
* General: Improved UI consistency for BuddyBoss and Reign themes.
* General: Enhanced error handling and compatibility for BuddyPress shortcodes.
* General: Added detailed comments for better code readability.
* General: Ensured PHPCS compliance for all plugin files.

= 2.7.1 =
* Fix: (#179)Fixed fatal error call to undefined function bp_nouveau_get_container_classes()
* Fix: Fixed Plugin redirect issue when multi plugin activate the same time
* Fix: Compatibility check with WordPress 6.5.0

= 2.7.0 =
* Fix: Added activity-meta in activity shortcode
* Fix: Update shortcode code flow
* Fix: Updated top banner and Links 
* Fix: Fixed text domain
* Fix: Remove display_comments parameter from activity
* Fix: Managed groups, member shortcode listing
* Fix: Add loop-layout parameters for member and group
* Fix: Member list shortcode UI managed
* Fix: Managed UI activity shortcode

= 2.6.5 =
* Fix: (#175) Issue with WPBakery
* Fix: Deprecated issue
* Fix: PHPCS fixes

= 2.6.4 =
* Fix: Group Shortcode group content length issue
* Fix: (#172) Pagination issue in notification
* Fix: (#168) Activity UI issue
* Fix: (#172) Issue with php 8.2
* Fix: (#170) Issue with BuddyBoss
* Fix: (#169) Page title issue
* Fix: (#167) Pagination is missing in the per_page parameter
* Fix: (#161) Group Listing issue
* Fix: (#162) Page title issue with Buddyx
* Fix: (#106) Shortcode activity page has two stories options
* Update: BuddyPress class for the default theme

= 2.6.3 =
* Fix: (#161) Pagination missing

= 2.6.2 =
* Fix: (#153) Managed shortcode notifications order actions
* Fix: (#151) Fixed error on adding shortcode
* Fix: (#148) Fixed php error while activate free and pro plugins together
* Fix: (#153) Fixed UI of [notifications-listing] shortcode border
* Fix: (#152) Fixed buddyboss notification does not work

= 2.6.1 =
* Fix: (#147) Fixed members and group shortcode notice issue
* Fix: (#150) Fixed pagination is not showing with perpage shortcode
* Fix: (#64)  Fixed knowledge base url issue

= 2.6.0 =
* Fix: Updated Admin wrapper

= 2.5.0 =
* Fix: (#145) Fixed php notices
* Fix: Fixed phpcs issue
* Fix: Update Url of Group Read More

= 2.4.0 =
* Fix: updated widget logic to be used together
* Fix: Group views as per BP l\oop grid column count setting
* Fix: #119 - Comment is navigating to page not count
* Fix:  enqueue admin js and css on plugin page

= 2.3.0 =
* New Feature: Added Widgets for Activity, Member Directory, and Group Directory with Elementor
* Update: Shortcode compatibility upto BuddyPress v7.2.0

= 2.1.0 =
* Fixed #72 - Not working with reign learndash addon

= 2.0.1 =
* BP 5.0.0 compatibility testing

= 2.0.0 =
* Code Rewrite

= 1.0.0 =
* first version.

== Upgrade Notice ==

= 3.0.1 =
Fixes the members shortcode on sites without Extended Profiles. Requires PHP 8.1 or later. Sites on older PHP versions stay on 3.0.0.

= 3.0.0 =
Major release. The Legacy and Youzify template packs have been removed - all shortcodes now render through the Nouveau pack, so custom template overrides placed in the legacy or youzify folders will no longer load. The unused performance settings screen has also been removed. Requires WordPress 6.5 and PHP 8.0.
