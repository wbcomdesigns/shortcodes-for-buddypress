# BuddyPress Shortcodes - Developer Guide

## Table of Contents
- [Architecture Overview](#architecture-overview)
- [File Structure](#file-structure)
- [Core Classes](#core-classes)
- [Hooks and Filters](#hooks-and-filters)
- [Creating Custom Shortcodes](#creating-custom-shortcodes)
- [Template System](#template-system)
- [AJAX Implementation](#ajax-implementation)
- [Extending the Plugin](#extending-the-plugin)
- [Best Practices](#best-practices)
- [API Reference](#api-reference)

## Architecture Overview

The plugin follows WordPress coding standards and implements an object-oriented architecture with the following key components:

```
┌─────────────────────────────────────┐
│         Main Plugin File            │
│  (shortcodes-for-buddypress.php)    │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│      Core Plugin Class              │
│  (class-shortcodes-for-buddypress)  │
└──────────────┬──────────────────────┘
               │
       ┌───────┴───────┬──────────┐
       ▼               ▼          ▼
┌──────────┐    ┌──────────┐  ┌──────────┐
│  Admin   │    │  Public  │  │ Shortcode│
│  Class   │    │  Class   │  │  Classes │
└──────────┘    └──────────┘  └──────────┘
```

## File Structure

```
shortcodes-for-buddypress/
├── admin/                      # Admin-specific functionality
│   ├── class-shortcodes-for-buddypress-admin.php
│   ├── css/                   # Admin styles
│   ├── js/                    # Admin scripts
│   └── settings/              # Settings page templates
├── includes/                   # Core plugin files
│   ├── class-shortcodes-for-buddypress.php
│   ├── class-shortcodes-for-buddypress-loader.php
│   ├── class-shortcodes-for-buddypress-i18n.php
│   └── functions.php          # Helper functions
├── public/                     # Public-facing functionality
│   ├── class-shortcodes-for-buddypress-public.php
│   ├── shortcode/             # Shortcode implementations
│   │   ├── class-shortcodes-for-buddypress-shortcode.php  # Base class
│   │   ├── class-shortcode-for-activity-listing.php
│   │   ├── class-member-shortcode.php
│   │   └── class-group-shortcode.php
│   ├── css/                   # Public styles
│   └── js/                    # Public scripts
├── templates/                  # Template files
│   ├── nouveau/               # BP Nouveau theme templates
│   └── youzify/              # Youzify theme templates
├── elementor/                  # Elementor widget integration
└── docs/                      # Documentation

```

## Core Classes

### Base Shortcode Class

All shortcodes extend the `BPShortCode` abstract class:

```php
abstract class BPShortCode {
    protected $tag;        // Shortcode tag
    protected $defaults;   // Default attributes

    // Required methods for child classes
    abstract protected function output($atts, $content = '');

    // Common methods
    protected function set_defaults() { }
    protected function get_final_attributes($atts) { }
    public function render($atts = array(), $content = '') { }
}
```

### Implementing a Shortcode

```php
class CustomShortCode extends BPShortCode {

    protected function set_defaults() {
        $this->defaults = array(
            'per_page' => 10,
            'type'     => 'newest'
        );
    }

    protected function output($atts, $content = '') {
        // Your shortcode logic here
        return '<div>Content</div>';
    }
}

// Register the shortcode
CustomShortCode::get_instance('my-shortcode');
```

## Hooks and Filters

### Actions

#### Before Rendering

```php
// Before activity shortcode renders
do_action('before_activity_shortcode_render', $atts);

// Before members shortcode renders
do_action('before_member_shortcode_render', $atts);

// Before groups shortcode renders
do_action('before_group_shortcode_render', $atts);
```

#### After Rendering

```php
// After activity shortcode renders
do_action('after_activity_shortcode_render', $template_vars);

// After members shortcode renders
do_action('after_member_shortcode_render', $template_vars);

// After groups shortcode renders
do_action('after_group_shortcode_render', $template_vars);
```

#### Inside Container

```php
// Inside activity container
do_action('activity_shortcode_inside_container', $atts, $template_vars);

// Inside members container
do_action('member_shortcode_inside_container', $atts, $template_vars);

// Inside groups container
do_action('group_shortcode_inside_container', $atts, $template_vars);
```

### Filters

#### Modify Attributes

```php
// Filter activity attributes
add_filter('activity-listing_attributes', function($atts) {
    $atts['per_page'] = 15; // Override per_page
    return $atts;
});

// Filter members attributes
add_filter('members-listing_attributes', function($atts) {
    $atts['type'] = 'active';
    return $atts;
});

// Filter groups attributes
add_filter('groups-listing_attributes', function($atts) {
    $atts['show_hidden'] = true;
    return $atts;
});
```

#### Modify Query Arguments

```php
// Modify activity query
add_filter('activity_shortcode_bash_query', function($query_args) {
    $query_args['scope'] = 'friends';
    return $query_args;
});

// Modify members query
add_filter('member_shortcode_bash_query_args', function($query_args) {
    $query_args['exclude'] = array(1, 2, 3);
    return $query_args;
});

// Modify groups query
add_filter('group_shortcode_bash_query_args', function($query_args) {
    $query_args['per_page'] = 12;
    return $query_args;
});
```

#### Modify Template Arguments

```php
// Modify activity template vars
add_filter('activity_shortcode_template_args', function($args) {
    $args['custom_var'] = 'value';
    return $args;
});

// Modify members template vars
add_filter('member_shortcode_template_args', function($args) {
    $args['show_online_status'] = true;
    return $args;
});

// Modify groups template vars
add_filter('group_shortcode_template_args', function($args) {
    $args['show_description'] = false;
    return $args;
});
```

#### Modify Output

```php
// Filter final activity output
add_filter('activity_shortcode_output', function($output) {
    return '<div class="custom-wrapper">' . $output . '</div>';
});

// Filter final members output
add_filter('member_shortcode_output', function($output) {
    return str_replace('class="members-list"', 'class="members-list custom"', $output);
});

// Filter final groups output
add_filter('group_shortcode_output', function($output) {
    return $output . '<div class="groups-footer">Custom Footer</div>';
});
```

## Creating Custom Shortcodes

### Step 1: Create Your Shortcode Class

```php
// File: my-custom-shortcode.php

class MyCustomBPShortcode extends BPShortCode {

    /**
     * Set default attributes
     */
    protected function set_defaults() {
        $this->defaults = array(
            'title'       => '',
            'type'        => 'featured',
            'per_page'    => 10,
            'show_avatar' => true,
        );
    }

    /**
     * Output the shortcode content
     */
    protected function output($atts, $content = '') {
        // Fire before action
        do_action('before_my_shortcode_render', $atts);

        // Build query
        $query_args = array(
            'type'     => $atts['type'],
            'per_page' => $atts['per_page'],
        );

        // Apply filters
        $query_args = apply_filters('my_shortcode_query_args', $query_args);

        // Start output buffering
        ob_start();
        ?>
        <div class="my-custom-shortcode">
            <?php if (!empty($atts['title'])) : ?>
                <h3><?php echo esc_html($atts['title']); ?></h3>
            <?php endif; ?>

            <?php if (bp_has_members($query_args)) : ?>
                <ul class="custom-members-list">
                    <?php while (bp_members()) : bp_the_member(); ?>
                        <li>
                            <?php if ($atts['show_avatar']) : ?>
                                <?php bp_member_avatar(); ?>
                            <?php endif; ?>
                            <?php bp_member_name(); ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else : ?>
                <p>No members found.</p>
            <?php endif; ?>
        </div>
        <?php

        $output = ob_get_clean();

        // Fire after action
        do_action('after_my_shortcode_render', $atts);

        // Return filtered output
        return apply_filters('my_shortcode_output', $output, $atts);
    }
}
```

### Step 2: Register Your Shortcode

```php
// In your plugin file or functions.php
add_action('init', function() {
    if (class_exists('BPShortCode')) {
        MyCustomBPShortcode::get_instance('my-custom-listing');
    }
});
```

### Step 3: Use Your Shortcode

```
[my-custom-listing title="Featured Members" per_page="5" show_avatar="true"]
```

## Template System

### Template Loading

The plugin uses a template hierarchy system:

```php
function bp_shortcode_get_template($template, $args = array(), $theme = '') {
    // Template paths in order of priority:
    // 1. Theme override: /wp-content/themes/your-theme/buddypress/shortcodes/
    // 2. Plugin templates by theme: /templates/{$theme}/
    // 3. Plugin default: /templates/nouveau/

    $template_path = bp_shortcode_locate_template($template, $theme);

    if ($template_path) {
        extract($args);
        include($template_path);
    }
}
```

### Overriding Templates

To override a template in your theme:

1. Create directory: `/wp-content/themes/your-theme/buddypress/shortcodes/`
2. Copy template from plugin's `/templates/` directory
3. Modify as needed

Example:
```
your-theme/
└── buddypress/
    └── shortcodes/
        ├── activity/
        │   └── bp-shortcodes-activity.php
        ├── members/
        │   └── bp-shortcodes-members.php
        └── groups/
            └── bp-shortcodes-groups.php
```

## AJAX Implementation

### Loading More Content

The plugin provides AJAX handlers for loading more content:

```javascript
// JavaScript implementation
jQuery(document).ready(function($) {
    $('.load-more-activities').on('click', function(e) {
        e.preventDefault();

        var button = $(this);
        var page = button.data('page');

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'bpsp_activities_load',
                nonce: ajax_object.nonce,
                page: page + 1,
                limit: 10
            },
            success: function(response) {
                if (response.success) {
                    $('.activity-list').append(response.data);
                    button.data('page', page + 1);
                }
            }
        });
    });
});
```

### PHP AJAX Handler

```php
// Add custom AJAX handler
add_action('wp_ajax_my_custom_load_more', 'handle_custom_load_more');
add_action('wp_ajax_nopriv_my_custom_load_more', 'handle_custom_load_more');

function handle_custom_load_more() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'bpsp-nonce')) {
        wp_send_json_error('Security check failed');
    }

    // Get parameters
    $page = isset($_POST['page']) ? intval($_POST['page']) : 2;
    $per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 10;

    // Query content
    if (bp_has_members(array('page' => $page, 'per_page' => $per_page))) {
        ob_start();
        while (bp_members()) : bp_the_member();
            bp_get_template_part('members/members-loop');
        endwhile;
        $content = ob_get_clean();

        wp_send_json_success($content);
    } else {
        wp_send_json_error('No more members');
    }
}
```

## Extending the Plugin

### Adding Custom Parameters

```php
// Add custom parameter support
add_filter('members-listing_attributes', function($atts) {
    // Add default for new parameter
    $atts['custom_param'] = isset($atts['custom_param']) ? $atts['custom_param'] : 'default';
    return $atts;
});

// Use the parameter in query
add_filter('member_shortcode_bash_query_args', function($query_args) {
    if (!empty($query_args['custom_param'])) {
        // Apply custom logic based on parameter
        $query_args['meta_query'] = array(
            array(
                'key' => 'custom_field',
                'value' => $query_args['custom_param']
            )
        );
    }
    return $query_args;
});
```

### Adding Elementor Widget Support

```php
class My_Custom_Elementor_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'bp_custom_shortcode';
    }

    public function get_title() {
        return 'BP Custom Shortcode';
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'Content',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => 'Items Per Page',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 10,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        echo do_shortcode('[my-custom-listing per_page="' . $settings['per_page'] . '"]');
    }
}
```

### Adding Gutenberg Block Support

```javascript
// Register Gutenberg block
wp.blocks.registerBlockType('bp-shortcodes/custom-block', {
    title: 'BP Custom Shortcode',
    icon: 'groups',
    category: 'buddypress',
    attributes: {
        per_page: {
            type: 'number',
            default: 10
        },
        type: {
            type: 'string',
            default: 'active'
        }
    },
    edit: function(props) {
        return wp.element.createElement(
            'div',
            { className: props.className },
            '[members-listing per_page="' + props.attributes.per_page + '" type="' + props.attributes.type + '"]'
        );
    },
    save: function(props) {
        return '[members-listing per_page="' + props.attributes.per_page + '" type="' + props.attributes.type + '"]';
    }
});
```

## Best Practices

### 1. Security

Always sanitize and validate input:

```php
// Sanitize attributes
$per_page = absint($atts['per_page']);
$type = sanitize_text_field($atts['type']);
$search = sanitize_text_field($atts['search_terms']);

// Escape output
echo esc_html($title);
echo esc_attr($class_name);
echo esc_url($link);

// Verify nonces in AJAX
if (!wp_verify_nonce($_POST['nonce'], 'bpsp-nonce')) {
    wp_die('Security check failed');
}
```

### 2. Performance

Optimize queries and caching:

```php
// Use transients for expensive queries
$cache_key = 'bpsp_members_' . md5(serialize($query_args));
$members = get_transient($cache_key);

if (false === $members) {
    $members = bp_has_members($query_args);
    set_transient($cache_key, $members, HOUR_IN_SECONDS);
}

// Limit query results
$query_args['max'] = 100; // Never retrieve more than 100
$query_args['per_page'] = min($atts['per_page'], 50); // Cap at 50
```

### 3. Compatibility

Check for dependencies:

```php
// Check if BuddyPress is active
if (!function_exists('bp_is_active')) {
    return '<p>BuddyPress is required for this shortcode.</p>';
}

// Check component is active
if (!bp_is_active('groups')) {
    return '<p>Groups component must be activated.</p>';
}

// Theme compatibility
$theme = wp_get_theme();
if ('Youzify' === $theme->get('Name')) {
    // Apply Youzify-specific logic
}
```

### 4. Internationalization

Make strings translatable:

```php
// Use proper text domain
__('Members Directory', 'shortcodes-for-buddypress');
_e('No members found', 'shortcodes-for-buddypress');

// With placeholders
sprintf(
    __('Viewing %1$d - %2$d of %3$d members', 'shortcodes-for-buddypress'),
    $start,
    $end,
    $total
);
```

## API Reference

### Global Functions

```php
// Get template path
bp_shortcode_get_template($template, $args, $theme);

// Locate template file
bp_shortcode_locate_template($template, $theme);

// Enqueue assets
bp_shortcode_enqueue($handle, $src, $deps, $ver);

// Get BuddyPress version
bp_shortcode_get_bp_version();

// Check theme compatibility
bp_shortcode_is_theme_compatible($theme_name);
```

### Class Methods

#### BPShortCode Class

```php
// Get singleton instance
public static function get_instance($tag);

// Render shortcode
public function render($atts, $content);

// Get final attributes
protected function get_final_attributes($atts);

// Check admin preview
protected function is_admin_preview();

// Set defaults (override in child)
protected function set_defaults();

// Output content (override in child)
abstract protected function output($atts, $content);
```

### JavaScript API

```javascript
// Trigger activity refresh
BPShortcodes.refreshActivities(container);

// Load more items
BPShortcodes.loadMore(type, args);

// Filter content
BPShortcodes.filterContent(type, filters);

// Events
jQuery(document).on('bpsp:activities:loaded', function(e, data) {
    console.log('Activities loaded', data);
});

jQuery(document).on('bpsp:members:filtered', function(e, filters) {
    console.log('Members filtered', filters);
});
```

## Debugging

### Enable Debug Mode

```php
// In wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// In your code
if (WP_DEBUG) {
    error_log('BuddyPress Shortcode Debug: ' . print_r($atts, true));
}
```

### Common Issues and Solutions

1. **Shortcode not rendering**
   ```php
   // Check shortcode is registered
   global $shortcode_tags;
   var_dump(array_keys($shortcode_tags));
   ```

2. **AJAX not working**
   ```javascript
   // Check nonce
   console.log('Nonce:', ajax_object.nonce);

   // Check AJAX URL
   console.log('AJAX URL:', ajax_object.ajax_url);
   ```

3. **Template not loading**
   ```php
   // Debug template path
   add_filter('bp_shortcode_template_path', function($path) {
       error_log('Template path: ' . $path);
       return $path;
   });
   ```

---

**Version:** 2.9.0
**Last Updated:** December 2024
**Author:** Wbcom Designs
**License:** GPL v2 or later