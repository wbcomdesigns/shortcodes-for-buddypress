<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName -- Legacy file name.
/**
 * Elementor integration for Shortcodes for BuddyPress.
 *
 * @since   1.6.1
 * @package Shortcodes_For_BuddyPress
 */

namespace BPSPElementor;

use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Widgets manager class.
 *
 * @since 1.6.1
 */
class BPSP_Elementor_Widgets {

	/**
	 * Instance.
	 *
	 * @since 1.6.1
	 * @var null|BPSP_Elementor_Widgets
	 */
	private static $_instance = null;

	/**
	 * Get instance.
	 *
	 * @since 1.6.1
	 * @return BPSP_Elementor_Widgets
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	/**
	 * Constructor.
	 *
	 * @since 1.6.1
	 */
	private function __construct() {
		// Register category.
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_widget_category' ) );

		// Register widgets.
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
	}

	/**
	 * Register widget category.
	 *
	 * @since 1.6.1
	 * @param object $this_cat Categories manager.
	 * @return object
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
	 * Register widgets.
	 *
	 * @since 1.6.1
	 * @return void
	 */
	public function register_widgets() {
		// It is now safe to include Widgets files.
		$this->include_widgets_files();

		// Register widgets.
		Plugin::instance()->widgets_manager->register( new Widgets\Buddypress_Shortcode_Activity_Widget() );
		Plugin::instance()->widgets_manager->register( new Widgets\Buddypress_Shortcode_Members_Widget() );
		Plugin::instance()->widgets_manager->register( new Widgets\Buddypress_Shortcode_Groups_Widget() );
	}

	/**
	 * Include widget files.
	 *
	 * @since 1.6.1
	 * @return void
	 */
	public function include_widgets_files() {
		$widget_list = array(
			'Buddypress_Shortcode_Activity_Widget' => 'activity',
			'Buddypress_Shortcode_Members_Widget'  => 'members',
			'Buddypress_Shortcode_Groups_Widget'   => 'groups',
		);
		if ( ! empty( $widget_list ) ) {
			foreach ( $widget_list as $handle => $data ) {
				require_once plugin_dir_path( __FILE__ ) . 'widgets/class-buddypress-' . $data . '-widget.php';
			}
		}
	}
}


/**
 * Initiate the class.
 */
BPSP_Elementor_Widgets::instance();
