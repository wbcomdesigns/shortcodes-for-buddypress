# BuddyPress Shortcodes - User Guide

## Table of Contents
- [Introduction](#introduction)
- [Installation](#installation)
- [Available Shortcodes](#available-shortcodes)
- [Activity Listing Shortcode](#activity-listing-shortcode)
- [Members Listing Shortcode](#members-listing-shortcode)
- [Groups Listing Shortcode](#groups-listing-shortcode)
- [Advanced Usage](#advanced-usage)
- [Troubleshooting](#troubleshooting)
- [FAQs](#faqs)

## Introduction

BuddyPress Shortcodes plugin allows you to display BuddyPress content anywhere on your WordPress site using simple shortcodes. You can showcase member directories, activity streams, and group listings on any page, post, or widget area that supports shortcodes.

### Key Features
- 🎯 Display BuddyPress content anywhere
- 📱 Responsive and mobile-friendly
- ⚙️ Highly customizable with parameters
- 🎨 Compatible with most themes
- 🚀 Lightweight and performance-optimized

## Installation

### Requirements
- WordPress 5.0 or higher
- BuddyPress 5.0 or higher
- PHP 7.0 or higher

### Installation Steps
1. Upload the plugin files to `/wp-content/plugins/shortcodes-for-buddypress/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Ensure BuddyPress is installed and activated
4. Start using shortcodes in your pages and posts!

## Available Shortcodes

| Shortcode | Description |
|-----------|-------------|
| `[activity-listing]` | Display BuddyPress activity stream |
| `[members-listing]` | Display members directory |
| `[groups-listing]` | Display groups directory |

## Activity Listing Shortcode

Display BuddyPress activity streams anywhere on your site.

### Basic Usage
```
[activity-listing]
```

### Parameters

| Parameter | Default | Description | Options |
|-----------|---------|-------------|---------|
| `title` | (empty) | Add a title above the activity stream | Any text |
| `per_page` | 10 | Number of activities to display | Any number |
| `max` | false | Maximum number of activities to retrieve | Number or false |
| `scope` | false | Activity scope filter | friends, groups, mentions, favorites |
| `user_id` | false | Display activities for specific user | User ID number |
| `object` | false | Filter by activity object | groups, profile, status, friends |
| `action` | false | Filter by specific action | activity_update, new_member, etc. |
| `display_comments` | false | Show activity comments | true, false |
| `allow_posting` | false | Allow posting new activities | true, false |
| `pagination` | 1 | Show pagination | 0 or 1 |
| `load_more` | 0 | Enable load more button | 0 or 1 |
| `hide_on_activity` | 1 | Hide on BuddyPress activity page | 0 or 1 |
| `container_class` | activity | CSS class for container | Any CSS class |

### Examples

#### Display Latest 5 Activities
```
[activity-listing per_page="5"]
```

#### Show Activities with Comments
```
[activity-listing per_page="10" display_comments="true"]
```

#### Display Friend Activities Only
```
[activity-listing scope="friends" per_page="15"]
```

#### Group Activities with Title
```
[activity-listing title="Group Updates" object="groups" per_page="8"]
```

#### Enable Activity Posting
```
[activity-listing allow_posting="true" display_comments="true"]
```

## Members Listing Shortcode

Display a directory of your community members.

### Basic Usage
```
[members-listing]
```

### Parameters

| Parameter | Default | Description | Options |
|-----------|---------|-------------|---------|
| `title` | (empty) | Add a title above members list | Any text |
| `type` | active | Sort members by | active, newest, alphabetical, online, random |
| `per_page` | 20 | Number of members to display | Any number |
| `max` | false | Maximum members to retrieve | Number or false |
| `include` | false | Include specific member IDs | Comma-separated IDs |
| `exclude` | false | Exclude specific member IDs | Comma-separated IDs |
| `member_type` | false | Filter by member type | Member type slug |
| `search_terms` | false | Search members by keyword | Search text |
| `grid` | yes | Display as grid | yes, no |
| `loop_layout` | three | Number of columns in grid | one, two, three, four |
| `container_class` | members | CSS class for container | Any CSS class |

### Examples

#### Display Active Members in 4 Columns
```
[members-listing type="active" grid="yes" loop_layout="four" per_page="12"]
```

#### Show Newest Members
```
[members-listing type="newest" per_page="10"]
```

#### Display Online Members Only
```
[members-listing type="online" per_page="8"]
```

#### Exclude Specific Members
```
[members-listing exclude="1,2,3" per_page="15"]
```

#### Search and Display Members
```
[members-listing search_terms="developer" per_page="20"]
```

## Groups Listing Shortcode

Display BuddyPress groups in various layouts.

### Basic Usage
```
[groups-listing]
```

### Parameters

| Parameter | Default | Description | Options |
|-----------|---------|-------------|---------|
| `title` | (empty) | Add a title above groups list | Any text |
| `type` | alphabetical | Sort groups by | active, newest, alphabetical, popular, random |
| `order` | DESC | Sort order | ASC, DESC |
| `per_page` | 20 | Number of groups to display | Any number |
| `max` | false | Maximum groups to retrieve | Number or false |
| `include` | false | Include specific group IDs | Comma-separated IDs |
| `exclude` | false | Exclude specific group IDs | Comma-separated IDs |
| `user_id` | false | Groups for specific user | User ID |
| `group_type` | false | Filter by group type | Group type slug |
| `search_terms` | false | Search groups by keyword | Search text |
| `show_hidden` | false | Include hidden groups | true, false |
| `grid` | yes | Display as grid | yes, no |
| `loop_layout` | three | Number of columns in grid | one, two, three, four |
| `container_class` | group | CSS class for container | Any CSS class |

### Examples

#### Display Popular Groups
```
[groups-listing type="popular" per_page="6"]
```

#### Show Newest Groups in 2 Columns
```
[groups-listing type="newest" grid="yes" loop_layout="two" per_page="8"]
```

#### Include Hidden Groups
```
[groups-listing show_hidden="true" per_page="10"]
```

#### Search Groups
```
[groups-listing search_terms="photography" per_page="12"]
```

#### Alphabetical Groups List
```
[groups-listing type="alphabetical" order="ASC" per_page="20"]
```

## Advanced Usage

### Multiple Shortcodes on Same Page

You can use multiple shortcodes on the same page without conflicts:

```
<h2>Community Overview</h2>

<h3>Latest Activities</h3>
[activity-listing per_page="5"]

<h3>New Members</h3>
[members-listing type="newest" per_page="6" grid="yes"]

<h3>Popular Groups</h3>
[groups-listing type="popular" per_page="4"]
```

### Using in Widgets

All shortcodes work in WordPress widgets that support shortcodes:

1. Go to **Appearance > Widgets**
2. Add a **Text Widget** or **Custom HTML Widget**
3. Enter your shortcode
4. Save the widget

### Using in Theme Templates

You can use shortcodes directly in your theme files:

```php
<?php echo do_shortcode('[members-listing per_page="10"]'); ?>
```

### Custom Styling

Add custom CSS to style the shortcode output:

```css
/* Custom activity stream styling */
.activity-listing {
    background: #f5f5f5;
    padding: 20px;
    border-radius: 8px;
}

/* Custom members grid */
.members-listing .members-list {
    gap: 20px;
}

/* Custom groups styling */
.groups-listing .groups-list .item-entry {
    border: 1px solid #ddd;
    border-radius: 5px;
}
```

## Troubleshooting

### Shortcode Not Displaying

1. **Check BuddyPress is Active**
   - Go to **Plugins** and ensure BuddyPress is activated
   - Check if the required component (Activity, Members, Groups) is enabled in BuddyPress settings

2. **Clear Cache**
   - Clear your browser cache
   - If using a caching plugin, clear its cache
   - Clear any CDN cache if applicable

3. **Check for Conflicts**
   - Temporarily deactivate other plugins to check for conflicts
   - Switch to a default theme (Twenty Twenty-One) to test

### Styling Issues

1. **Theme Compatibility**
   - Some themes may override BuddyPress styles
   - Add custom CSS to fix specific styling issues
   - Contact your theme developer for BuddyPress compatibility

2. **Grid Layout Not Working**
   - Ensure your theme supports CSS Grid or Flexbox
   - Try different `loop_layout` values
   - Set `grid="no"` for a list layout instead

### Performance Issues

1. **Reduce per_page Value**
   ```
   [activity-listing per_page="5"]
   ```

2. **Use max Parameter**
   ```
   [members-listing per_page="10" max="50"]
   ```

3. **Enable Caching**
   - Use a caching plugin like WP Rocket or W3 Total Cache
   - Enable object caching if available

## FAQs

### Can I use shortcodes in Elementor/Gutenberg?

**Yes!** The shortcodes work with:
- Gutenberg Shortcode Block
- Elementor Shortcode Widget
- WPBakery Page Builder
- Beaver Builder
- Divi Builder

### How do I hide shortcodes on mobile devices?

Use CSS media queries:

```css
@media (max-width: 768px) {
    .activity-listing,
    .members-listing,
    .groups-listing {
        display: none;
    }
}
```

### Can I filter content by user role?

For members listing, you can exclude or include specific user IDs:

```
[members-listing include="1,5,10,15"]
```

### How do I display content for logged-in users only?

Wrap the shortcode in a conditional:

```
[members-only]
[activity-listing per_page="10"]
[/members-only]
```
(Requires a membership plugin that provides such functionality)

### Can I translate the output?

Yes, the plugin is translation-ready. Use plugins like:
- WPML
- Polylang
- Loco Translate

### How do I get support?

1. Check this documentation
2. Visit the [WordPress.org support forum](https://wordpress.org/support/plugin/shortcodes-for-buddypress/)
3. Check the [GitHub repository](https://github.com/wbcomdesigns/shortcodes-for-buddypress)

## Shortcode Builder

Use our visual shortcode builder in the WordPress admin:

1. Go to **WB Plugins > Shortcodes**
2. Select the shortcode type
3. Configure parameters
4. Copy the generated shortcode
5. Paste it anywhere on your site

---

**Version:** 2.9.0
**Last Updated:** December 2024
**Author:** Wbcom Designs