<?php
/**
 * Core plugin class file.
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.0.0
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/includes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Core plugin class.
 *
 * @since      1.0.0
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/includes
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Shortcodes_For_Buddypress {

	/**
	 * Plugin loader.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Shortcodes_For_Buddypress_Loader    $loader
	 */
	protected $loader;

	/**
	 * Plugin identifier.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	protected $plugin_name;

	/**
	 * Plugin version.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version
	 */
	protected $version;

	/**
	 * Plugin basename.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_basename
	 */
	protected $plugin_basename;

	/**
	 * Constructor.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->version = defined( 'SHORTCODES_FOR_BUDDYPRESS_VERSION' )
			? SHORTCODES_FOR_BUDDYPRESS_VERSION
			: '1.0.0';

		$this->plugin_name     = 'shortcodes-for-buddypress';
		$this->plugin_basename = SHORTCODES_FOR_BUDDYPRESS_PLUGIN_BASENAME;

		$this->init();
	}

	/**
	 * Initialize components.
	 */
	private function init() {
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load dependencies.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		$plugin_path = plugin_dir_path( __DIR__ );

		// Core classes.
		$this->load_core_classes( $plugin_path );

		// Admin classes.
		$this->load_admin_classes( $plugin_path );

		// Public classes.
		$this->load_public_classes( $plugin_path );

		// Shortcode classes.
		$this->load_shortcode_classes( $plugin_path );

		// Elementor integration.
		if ( did_action( 'elementor/loaded' ) ) {
			require_once $plugin_path . 'elementor/class-buddypress-shortcode-elements.php';
		}

		// Initialize loader.
		$this->loader = new Shortcodes_For_Buddypress_Loader();
	}

	/**
	 * Load core classes.
	 *
	 * @since  1.0.0
	 * @param  string $path Plugin path.
	 * @return void
	 */
	private function load_core_classes( $path ) {
		require_once $path . 'includes/class-shortcodes-for-buddypress-loader.php';
	}

	/**
	 * Load admin classes.
	 *
	 * @since  1.0.0
	 * @param  string $path Plugin path.
	 * @return void
	 */
	private function load_admin_classes( $path ) {
		// Card-panel admin (replaces the legacy Wbcom wrapper as of 3.0.0).
		// The old admin/class-shortcodes-for-buddypress-admin.php +
		// admin/wbcom/ wrapper held only UI-render code (no save handlers,
		// no AJAX, no sanitizer), so they are removed entirely — see
		// references/wbcom-wrapper-migration.md Part 3.
		require_once $path . 'includes/admin/class-shortcodes-for-buddypress-admin-panel.php';
	}

	/**
	 * Load public classes.
	 *
	 * @since  1.0.0
	 * @param  string $path Plugin path.
	 * @return void
	 */
	private function load_public_classes( $path ) {
		require_once $path . 'public/class-shortcodes-for-buddypress-public.php';
	}

	/**
	 * Load shortcode classes.
	 *
	 * @since  1.0.0
	 * @param  string $path Plugin path.
	 * @return void
	 */
	private function load_shortcode_classes( $path ) {
		// Base shortcode class.
		require_once $path . 'public/shortcode/class-shortcodes-for-buddypress-shortcode.php';

		// Individual shortcodes.
		require_once $path . 'public/shortcode/class-shortcode-for-activity-listing.php';
		require_once $path . 'public/shortcode/class-group-shortcode.php';
		require_once $path . 'public/shortcode/class-member-shortcode.php';
	}

	/**
	 * Register admin hooks.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		// New card-panel admin. It owns the menu, enqueue, notice
		// suppression, and tab rendering. Registers its own hooks via
		// register() (not the Loader) so the hub-takeover priority-999
		// hook and in_admin_header ordering match the playbook pattern.
		$panel = new Shortcodes_For_Buddypress_Admin_Panel();
		$panel->register();
	}

	/**
	 * Register public hooks.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Shortcodes_For_Buddypress_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 9 );

		$this->loader->add_filter( 'bp_nouveau_get_search_primary_object', $plugin_public, 'buddypress_shortcodes_bp_nouveau_get_search_primary_object', 10 );
		$this->loader->add_filter( 'body_class', $plugin_public, 'buddypress_shortcodes_body_classes' );

		// Theme BuddyPress CSS on pages that render a shortcode or widget: Reign, BuddyX, BuddyX Pro.
		foreach ( array( 'reign_load_buddypress_assets', 'buddyx_needs_buddypress_assets', 'buddyxpro_needs_buddypress_assets' ) as $theme_filter ) {
			$this->loader->add_filter( $theme_filter, $plugin_public, 'buddypress_shortcode_theme_load_assets' );
		}

		$this->loader->add_filter( 'bp_core_get_js_strings', $plugin_public, 'shortcodes_for_buddypress_activity_localize_scripts', 10, 1 );

		$this->loader->add_filter( 'bp_nouveau_register_scripts', $plugin_public, 'buddypress_shortcodes_bp_nouveau_register_scripts', 20 );

		$this->loader->add_filter( 'bp_core_get_js_strings', $plugin_public, 'buddypress_shortcodes_activity_heartbeat_strings', 20, 1 );
		$this->loader->add_action( 'wp_ajax_bpsp_activities_load', $plugin_public, 'buddypress_shortcodes_load_activities' );
		$this->loader->add_action( 'wp_ajax_nopriv_bpsp_activities_load', $plugin_public, 'buddypress_shortcodes_load_activities' );
		$this->loader->add_filter( 'bp_activity_reshare_action', $plugin_public, 'buddypress_shortcode_enable_share', 10 );
		$this->loader->add_filter( 'bp_after_nouveau_wrapper_parse_args', $plugin_public, 'buddypress_shortcode_filter_activity_action_wrapper', 10 );

		if ( function_exists( 'buddypress' ) && isset( buddypress()->buddyboss ) ) {
			$this->loader->add_filter( 'bb_nouveau_get_activity_entry_bubble_buttons', $plugin_public, 'buddypress_shortcode_activity_entry_bubble_buttons', 10, 2 );
		}
	}

	/**
	 * Run the loader.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Get plugin name.
	 *
	 * @since     1.0.0
	 * @return    string
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Get plugin version.
	 *
	 * @since     1.0.0
	 * @return    string
	 */
	public function get_version() {
		return $this->version;
	}
}
