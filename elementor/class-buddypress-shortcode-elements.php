<?php

namespace BPSPElementor;

use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


class BPSP_Elementor_Widgets {

	/**
	 * Instance of BPSP_Elementor_Widgets.
	 *
	 * @since  1.6.1
	 * @var null
	 */
	private static $_instance = null;

	/**
	 * Get instance of BPSP_Elementor_Widgets
	 *
	 * @since  1.6.1
	 * @return BPSP_Elementor_Widgets
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	/**
	 * Setup actions and filters.
	 *
	 * @since  1.6.1
	 */
	private function __construct() {
		// Register category.
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_widget_category' ) );

		// Register widgets.
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );

		// Add svg support.
		// add_filter( 'upload_mimes', array( $this, 'hfe_svg_mime_types' ) ); // PHPCS:Ignore WordPressVIPMinimum.Hooks.RestrictedHooks.upload_mimes
	}

	/**
	 * Register Category
	 *
	 * @since 1.6.1
	 * @param object $this_cat class.
	 */
	public function register_widget_category( $this_cat ) {

		$this_cat->add_category(
			'buddypress-widgets',
			array(
				'title' => __( 'BuddyPress Widgets', 'shortcodes-for-buddypress' ),
				'icon'  => 'fa fa-plug',
			)
		);

		return $this_cat;
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.6.1
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files.
		$this->include_widgets_files();
	
		// Register Widgets.
		Plugin::instance()->widgets_manager->register( new Widgets\Activity() );
		Plugin::instance()->widgets_manager->register( new Widgets\Members() );
		Plugin::instance()->widgets_manager->register( new Widgets\Groups() );
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.6.1
	 * @access public
	 */
	public function include_widgets_files() {
		// $js_files    = $this->get_widget_script();
		$widget_list = $this->get_widget_list();

		if ( ! empty( $widget_list ) ) {
			foreach ( $widget_list as $handle => $data ) {
				require_once plugin_dir_path( __FILE__ ) . 'widgets/class-buddypress-' . $data . '-widget.php';
			}
		}
	}

	/**
	 * Returns Script array.
	 *
	 * @return array()
	 * @since 1.6.1
	 */
	public static function get_widget_list() {
		$widget_list = array(
			'activity',
			'members',
			'groups',
		);

		// if ( bp_is_active( 'groups' ) ) {
		// 	$widget_list[] = 'groups';
		// }

		return $widget_list;
	}

}


/**
 * Initiate the class.
 */
BPSP_Elementor_Widgets::instance();
