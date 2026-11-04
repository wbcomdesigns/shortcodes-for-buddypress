# Hooks and Filters

The plugin exposes action and filter hooks around each shortcode's render cycle, plus a few shared helper filters. Every hook below is present in the code.

## Attribute filters

After `shortcode_atts()` merges your attributes with the defaults, each shortcode runs its merged attributes through a filter named after the tag:

| Filter | Passes |
|---|---|
| `activity-listing_attributes` | Final activity attributes array |
| `members-listing_attributes` | Final members attributes array |
| `groups-listing_attributes` | Final groups attributes array |

Use these to change attribute values site-wide regardless of what the page author typed.

## Query filters

These filter the query arguments built from the attributes before BuddyPress runs the loop:

| Filter | Shortcode | Passes |
|---|---|---|
| `activity_shortcode_bash_query` | activity | Activity query args |
| `member_shortcode_bash_query_args` | members | Members query args |
| `group_shortcode_bash_query_args` | groups | Groups query args |

## Template argument filters

These filter the variables passed into the template:

| Filter | Shortcode |
|---|---|
| `activity_shortcode_template_args` | activity |
| `member_shortcode_template_args` | members |
| `group_shortcode_template_args` | groups |

## Output filters

The members and groups shortcodes filter their final HTML string:

| Filter | Shortcode |
|---|---|
| `member_shortcode_output` | members |
| `group_shortcode_output` | groups |

## Action hooks around rendering

| Action | When | Passes |
|---|---|---|
| `before_activity_shortcode_render` | Before the activity listing | `$atts` |
| `activity_shortcode_inside_container` | Inside the activity wrapper, before the loop | `$atts`, `$template_vars` |
| `after_activity_shortcode_render` | After the activity listing | `$template_vars` |
| `before_member_shortcode_render` | Before the members listing | `$atts` |
| `member_shortcode_before_output` | Just before member output starts | `$atts` |
| `member_shortcode_inside_container` | Inside the members wrapper, before the loop | `$atts`, `$template_args` |
| `after_member_shortcode_render` | After the members listing | `$template_args` |
| `before_group_shortcode_render` | Before the groups listing | `$atts` |
| `group_shortcode_inside_container` | Inside the groups wrapper, before the loop | `$atts`, `$template_vars` |
| `after_group_shortcode_render` | After the groups listing | `$template_vars` |

## Asset hooks

| Action | When |
|---|---|
| `before_enqueue_buddypress_shortcode_styles` | Before the plugin enqueues its stylesheet |
| `before_enqueue_buddypress_shortcode_scripts` | Before the plugin enqueues its script |

## Shared helper filters

| Filter | Purpose |
|---|---|
| `bp_shortcode_locate_template` | Filter the resolved template file path |
| `bp_shortcode_is_shortcode_page` | Filter whether the current page counts as a shortcode page (controls asset loading) |
| `bp_shortcode_member_cover` | Filter the member cover-image markup |
| `buddypress_shortcode_elementor_widget_type` | Map a custom shortcode tag to an Elementor widget type for page detection |
| `bp_activity_localized_params` | Filter the data localized to the front-end script (`ajax_url`, `ajax_nonce`) |

## How the Pro plugin extends this

The Pro plugin (`shortcode-for-buddypress-pro`) is a separate, mutually exclusive plugin that hooks these same filters to add custom queries and templates. The Elementor bridge also offers a legacy per-shortcode arguments filter that Pro can use to rewrite the shortcode argument string; if a Pro filter changes that string, the plugin honours it and re-runs the shortcode with those arguments.
