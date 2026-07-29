=== Wbcom Designs – Shortcodes & Elementor Widgets For BuddyPress ===
Contributors: vapvarun,wbcomdesigns
Donate link: http://wbcomdesigns.com/donate
Tags: Activity, BuddyPress, Members, Groups, Shortcodes
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.0
Requires Plugins: buddypress
Stable tag: 3.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin generates shortcodes for Listing Activity Streams, Members, and Groups on any website post or page.

== Description ==

This plugin will add an extended feature to BuddyPress. It will use Shortcode for Listing Activity Streams, Members directory, and Groups directory on any post or page within the website.

With our current update, we have added three widgets to display the activity stream, member directory, and group directory using Elementor.

[vimeo https://vimeo.com/554193567 ]

=== THEME - WORDPRESS THEME WITH OUTSTANDING BUDDYPRESS SUPPORT ===
* [FREE BuddyPress Theme: BuddyX](https://wordpress.org/themes/buddyx/) - Offers unique layouts with clean code and easy-to-customise options, giving you a whole new way to visualize BuddyPress.

== Installation ==
This section describes how to install the plugin and get it working.

1. Download the zip file and extract it.
2. Upload this plugin to the `/wp-content/plugins/` directory
3. Activate the plugin through the \'Plugins\' menu.
4. Alternatively, you can use the WordPress Plugin installer from Dashboard->Plugins->Add New to add this plugin
5. Enjoy
If you need more help, please contact us for [Custom Development](https://wbcomdesigns.com/hire-us/).

== Frequently Asked Questions ==

= Does This plugin require BuddyPress =

Yes, it requires BuddyPress installed and activated.

= Where Do I Ask for Support? =

Please visit [wbcomdesigns] (http://wbcomdesigns.com/) for any query related to the plugin and Buddypress.

== Screenshots ==

1. Admin Overview - Shortcode counts, Elementor widget status, and component status at a glance.
2. Admin Shortcodes reference - Every shortcode with parameters, quick-start guide, and example use cases.
3. Frontend [activity-listing] - BuddyPress activity stream embedded on any page with comment, favorite, and share actions.
4. Frontend [members-listing] - Members directory grid with avatars, activity, and Add Friend actions.
5. Frontend [groups-listing] - Groups grid showing public, private, and hidden groups with membership actions.
6. Discover tab - More free community tools from Wbcom Designs.

== More Free Tools from Wbcom Designs ==

Shortcodes let you place BuddyPress activity, members and groups anywhere. These other free tools from Wbcom Designs build out the rest of the community around them, from the theme and network itself to forums, media, events, gamification, directories, jobs, and courses.

* **[BuddyX](https://wbcomdesigns.com/downloads/buddyx-theme/)** - A free, fast community theme for BuddyPress, BuddyBoss and PeepSo with a modern layout and dark mode.
* **[BuddyNext](https://wbcomdesigns.com/downloads/buddynext/)** - Stand up a complete WordPress community with activity streams, member spaces, profiles, direct messaging, and built-in moderation.
* **[Jetonomy](https://wbcomdesigns.com/downloads/jetonomy/)** - Add forums, question-and-answer boards, and idea spaces that stay tidy through trust-based auto-moderation even past 100,000 topics.
* **[Mediaverse](https://wbcomdesigns.com/downloads/mediaverse/)** - Let members build photo and video albums, react, follow each other, and message privately while AI moderation keeps things clean.
* **[Eventonomy](https://wbcomdesigns.com/downloads/eventonomy/)** - Run community events with RSVPs, calendars, and front-end submissions.
* **[WB Gamification](https://wbcomdesigns.com/downloads/wordpress-gamification-plugin/)** - Reward members with points, badges, and leaderboards to keep engagement high.
* **[Listora](https://wbcomdesigns.com/downloads/listora/)** - Publish searchable directories across ten listing types with reviews, maps, and member-submitted entries from the front end.
* **[WP Career Board](https://wbcomdesigns.com/downloads/wp-career-board/)** - Add a job board with front-end listings, applications, and employer profiles.
* **[Learnomy](https://wbcomdesigns.com/downloads/learnomy/)** - Build and sell online courses, auto-grade quizzes, collect payments, and award certificates when learners finish.

== Changelog ==
= 3.0.0 =
* Fix: The [activity-listing] and [groups-listing] shortcodes no longer cause a fatal error on a page when BuddyPress is inactive; they now show the same "enable BuddyPress" notice as the members shortcode.
* Security: Clamped the load-more AJAX per_page and limit values so a public request cannot force an unbounded query.
* Improve: Added Requires PHP and Requires Plugins headers and a "More Free Tools from Wbcom Designs" section.
* Dev: Removed dead code and replaced em-dashes in admin strings.
* Admin UX: Rebuilt the admin screen on the new Wbcom card-panel layout (sidebar nav, dashboard overview, reskinned shortcode reference tabs); removed the legacy Wbcom tab wrapper.
* Code Quality: Fixed all WordPress Coding Standards (WPCS) violations across all PHP files
* Code Quality: Applied inline comment punctuation, Yoda conditions, and proper spacing
* Code Quality: Added missing PHPDoc comments for functions and parameters
* Code Quality: Fixed elseif control structure formatting in Elementor widgets
* Code Quality: Added phpcs:ignore for legacy file naming and class naming conventions
* Code Quality: Fixed all Plugin Check errors (0 errors)

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
