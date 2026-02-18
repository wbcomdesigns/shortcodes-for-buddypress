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
		$this->set_locale();
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
		$plugin_path = plugin_dir_path( dirname( __FILE__ ) );

		// Core classes
		$this->load_core_classes( $plugin_path );

		// Admin classes
		$this->load_admin_classes( $plugin_path );

		// Public classes
		$this->load_public_classes( $plugin_path );

		// Shortcode classes
		$this->load_shortcode_classes( $plugin_path );

		// Elementor integration
		if ( did_action( 'elementor/loaded' ) ) {
			require_once $plugin_path . 'elementor/class-buddypress-shortcode-elements.php';
		}

		// Initialize loader
		$this->loader = new Shortcodes_For_Buddypress_Loader();
	}

	/**
	 * Load core classes.
	 */
	private function load_core_classes( $path ) {
		require_once $path . 'includes/class-shortcodes-for-buddypress-loader.php';
		require_once $path . 'includes/class-shortcodes-for-buddypress-i18n.php';
	}

	/**
	 * Load admin classes.
	 */
	private function load_admin_classes( $path ) {
		require_once $path . 'admin/class-shortcodes-for-buddypress-admin.php';
		require_once $path . 'admin/wbcom/wbcom-admin-settings.php';
	}

	/**
	 * Load public classes.
	 */
	private function load_public_classes( $path ) {
		require_once $path . 'public/class-shortcodes-for-buddypress-public.php';
	}

	/**
	 * Load shortcode classes.
	 */
	private function load_shortcode_classes( $path ) {
		// Base shortcode class
		require_once $path . 'public/shortcode/class-shortcodes-for-buddypress-shortcode.php';

		// Individual shortcodes
		require_once $path . 'public/shortcode/class-shortcode-for-activity-listing.php';
		require_once $path . 'public/shortcode/class-group-shortcode.php';
		require_once $path . 'public/shortcode/class-member-shortcode.php';
	}

	/**
	 * Set plugin locale.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Shortcodes_For_Buddypress_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register admin hooks.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Shortcodes_For_Buddypress_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'buddypress_shortcodes_add_submenu_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'buddypress_shortcodes_plugin_settings' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wbcom_hide_all_admin_notices_from_setting_page' );
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

		$this->loader->add_filter( 'bp_core_get_js_strings', $plugin_public, 'shortcodes_for_buddypress_activity_localize_scripts', 10, 1 );

		$this->loader->add_filter( 'bp_nouveau_register_scripts', $plugin_public, 'buddypress_shortcodes_bp_nouveau_register_scripts', 20 );

		$this->loader->add_filter( 'bp_core_get_js_strings', $plugin_public, 'buddypress_shortcodes_activity_heartbeat_strings', 20, 1 );
		$this->loader->add_action( 'wp_ajax_bpsp_activities_load', $plugin_public, 'buddypress_shortcodes_load_activities' );
		$this->loader->add_action( 'wp_ajax_nopriv_bpsp_activities_load', $plugin_public, 'buddypress_shortcodes_load_activities' );
		$this->loader->add_filter( 'bp_activity_reshare_action', $plugin_public, 'buddypress_shortcode_enable_share', 10 );
		$this->loader->add_filter( 'bp_after_nouveau_wrapper_parse_args', $plugin_public, 'buddypress_shortcode_filter_activity_action_wrapper', 10 );

		if ( function_exists('buddypress') && isset( buddypress()->buddyboss ) ) {
			$this->loader->add_filter( 'bb_nouveau_get_activity_entry_bubble_buttons', $plugin_public, 'buddypress_shortcode_activity_entry_bubble_buttons', 10, 2 );
		}
		$this->loader->add_action( 'wp_ajax_bpsh_load_more_members', $plugin_public, 'buddypress_shortcode_ajax_load_more_members' );
		$this->loader->add_action( 'wp_ajax_nopriv_bpsh_load_more_members', $plugin_public, 'buddypress_shortcode_ajax_load_more_members' );

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
	 * Get loader instance.
	 *
	 * @since     1.0.0
	 * @return    Shortcodes_For_Buddypress_Loader
	 */
	public function get_loader() {
		return $this->loader;
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
