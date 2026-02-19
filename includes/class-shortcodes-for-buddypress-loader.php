<?php
/**
 * Plugin loader file.
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.0.0
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/includes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin loader class.
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/includes
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Shortcodes_For_Buddypress_Loader {

	/**
	 * Registered actions.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions
	 */
	protected $actions;

	/**
	 * Registered filters.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters
	 */
	protected $filters;

	/**
	 * Registered shortcodes.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $shortcode
	 */
	protected $shortcode;

	/**
	 * Constructor.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions   = array();
		$this->filters   = array();
		$this->shortcode = array();
	}

	/**
	 * Add action.
	 *
	 * @since    1.0.0
	 * @param    string $hook             Action hook.
	 * @param    object $component        Component object.
	 * @param    string $callback         Callback method.
	 * @param    int    $priority         Priority.
	 * @param    int    $accepted_args    Number of arguments.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add filter.
	 *
	 * @since    1.0.0
	 * @param    string $hook             Filter hook.
	 * @param    object $component        Component object.
	 * @param    string $callback         Callback method.
	 * @param    int    $priority         Priority.
	 * @param    int    $accepted_args    Number of arguments.
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add hook to collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array  $hooks            Hook collection.
	 * @param    string $hook             Hook name.
	 * @param    object $component        Component object.
	 * @param    string $callback         Callback method.
	 * @param    int    $priority         Priority.
	 * @param    int    $accepted_args    Number of arguments.
	 * @return   array
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

		return $hooks;
	}

	/**
	 * Register hooks.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->shortcode as $hook ) {
			add_shortcode( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
	}

	/**
	 * Add shortcode.
	 *
	 * @since    1.0.0
	 * @param    string $hook             Shortcode tag.
	 * @param    object $component        Component object.
	 * @param    string $callback         Callback method.
	 */
	public function add_shortcode( $hook, $component, $callback ) {
		$this->shortcode = $this->add( $this->shortcode, $hook, $component, $callback, '', '' );
	}
}
