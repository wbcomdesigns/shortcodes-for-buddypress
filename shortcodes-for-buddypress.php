<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wbcomdesigns.com/plugins
 * @since             1.0.0
 * @package           Shortcodes_For_Buddypress
 *
 * @wordpress-plugin
 * Plugin Name:       Shortcode For BuddyPress
 * Plugin URI:        https://github.com/wbcomdesigns/shortcodes-for-buddypress
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Wbcom Designs
 * Author URI:        https://wbcomdesigns.com/plugins
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shortcodes-for-buddypress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SHORTCODES_FOR_BUDDYPRESS_VERSION', '1.0.0' );

if ( ! defined( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR' ) ) {
	define( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR', plugin_dir_path(__FILE__) );
}

if ( ! defined( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_URL' ) ) {
	define( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_URL', plugins_url('/', __FILE__) );
}
if ( !defined('SHORTCODES_FOR_BUDDYPRESS_PLUGIN_BASENAME') ) {
	define('SHORTCODES_FOR_BUDDYPRESS_PLUGIN_BASENAME', plugin_basename(__FILE__));
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-shortcodes-for-buddypress-activator.php
 */
function activate_shortcodes_for_buddypress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes-for-buddypress-activator.php';
	Shortcodes_For_Buddypress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-shortcodes-for-buddypress-deactivator.php
 */
function deactivate_shortcodes_for_buddypress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes-for-buddypress-deactivator.php';
	Shortcodes_For_Buddypress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_shortcodes_for_buddypress' );
register_deactivation_hook( __FILE__, 'deactivate_shortcodes_for_buddypress' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes-for-buddypress.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_shortcodes_for_buddypress() {

	$plugin = new Shortcodes_For_Buddypress();
	$plugin->run();

}
run_shortcodes_for_buddypress();
