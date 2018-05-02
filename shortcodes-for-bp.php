<?php

/**
 *
 * @link              http://wbcomdesigns.com
 * @since             1.0.0
 * @package           Bp_Shortcodes
 *
 * @wordpress-plugin
 * Plugin Name:       Shortcodes For BuddyPress
 * Description:       This plugin will add an extended feature to the big name “BuddyPress” that will generate Shortcode for Listing Activity Streams, Members and Groups on any post/page in website.
 * Version:           1.0.1
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
if (!defined('BPSH_PLUGIN_BASENAME')) {
    define('BPSH_PLUGIN_BASENAME', plugin_basename(__FILE__));
}
function bpsh_plugin_init() {
    if ( bpsh_check_config() ){
        /**
         * The core plugin class that is used to define internationalization,
         * admin-specific hooks, and public-facing site hooks.
         */
        require plugin_dir_path(__FILE__) . 'includes/class-bp-shortcodes.php';
        run_bp_shortcodes();
    }
}

add_action('bp_loaded', 'bpsh_plugin_init');

function bpsh_check_config(){
    global $bp;
    $config = array(
        'blog_status'    => false, 
        'network_active' => false, 
        'network_status' => true 
    );
    if ( get_current_blog_id() == bp_get_root_blog_id() ) {
        $config['blog_status'] = true;
    }
    
    $network_plugins = get_site_option( 'active_sitewide_plugins', array() );

    // No Network plugins
    if ( empty( $network_plugins ) )

    // Looking for BuddyPress and bp-activity plugin
    $check[] = $bp->basename;
    $check[] = BPSH_PLUGIN_BASENAME;

    // Are they active on the network ?
    $network_active = array_diff( $check, array_keys( $network_plugins ) );
    
    // If result is 1, your plugin is network activated
    // and not BuddyPress or vice & versa. Config is not ok
    if ( count( $network_active ) == 1 )
        $config['network_status'] = false;

    // We need to know if the plugin is network activated to choose the right
    // notice ( admin or network_admin ) to display the warning message.
    $config['network_active'] = isset( $network_plugins[ BPSH_PLUGIN_BASENAME ] );

    // if BuddyPress config is different than bp-activity plugin
    if ( !$config['blog_status'] || !$config['network_status'] ) {

        $warnings = array();
        if ( !bp_core_do_network_admin() && !$config['blog_status'] ) {
            add_action( 'admin_notices', 'bpsh_same_blog' );
            $warnings[] = __( 'Shortcodes For BuddyPress requires to be activated on the blog where BuddyPress is activated.', 'bp-shortcodes' );
        }

        if ( bp_core_do_network_admin() && !$config['network_status'] ) {
            add_action( 'admin_notices', 'bpsh_same_network_config' );
            $warnings[] = __( 'Shortcodes For BuddyPress and BuddyPress need to share the same network configuration.', 'bp-shortcodes' );
        }

        if ( ! empty( $warnings ) ) :
            return false;
        endif;
    }
    return true;
}

function bpsh_same_blog(){
    echo '<div class="error"><p>'
    . esc_html( __( 'Shortcodes For BuddyPress requires to be activated on the blog where BuddyPress is activated.', 'bp-shortcodes' ) )
    . '</p></div>';
}

function bpsh_same_network_config(){
    echo '<div class="error"><p>'
    . esc_html( __( 'Shortcodes For BuddyPress and BuddyPress need to share the same network configuration.', 'bp-shortcodes' ) )
    . '</p></div>';
}

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
