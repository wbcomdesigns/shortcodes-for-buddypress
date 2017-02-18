<?php

/**
 *
 * @link              http://wbcomdesigns.com
 * @since             1.0.0
 * @package           Bp_Shortcodes
 *
 * @wordpress-plugin
 * Plugin Name:       BuddyPress Shortcodes
 * Plugin URI:        http://wbcomdesigns.com
 * Description:       This plugin will add an extended feature to the big name “BuddyPress” that will generate Shortcode for Listing Activity Streams , Members and Groups on any post/page in website.
 * Version:           1.0.0
 * Author:            Wbcom Designs
 * Author URI:        http://wbcomdesigns.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bp-shortcodes
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bp-shortcodes-activator.php
 */
function activate_bp_shortcodes() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-bp-shortcodes-activator.php';
    Bp_Shortcodes_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bp-shortcodes-deactivator.php
 */
function deactivate_bp_shortcodes() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-bp-shortcodes-deactivator.php';
    Bp_Shortcodes_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_bp_shortcodes');
register_deactivation_hook(__FILE__, 'deactivate_bp_shortcodes');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-bp-shortcodes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bp_shortcodes() {

    $plugin = new Bp_Shortcodes();
    $plugin->run();
}

run_bp_shortcodes();
