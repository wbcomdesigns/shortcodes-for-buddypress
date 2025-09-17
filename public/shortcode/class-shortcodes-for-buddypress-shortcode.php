<?php
/**
 * Base shortcode class for BuddyPress shortcodes
 *
 * Provides a clean, extensible foundation for all BuddyPress shortcodes
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/shortcode
 * @since      1.7.0
 */

abstract class BPShortCode {

	/**
	 * Shortcode tag name
	 *
	 * @var string
	 */
	protected $tag;

	/**
	 * Default attributes for the shortcode
	 *
	 * @var array
	 */
	protected $defaults = array();

	/**
	 * Singleton instances
	 *
	 * @var array
	 */
	private static $instances = array();

	/**
	 * Initialize shortcode
	 *
	 * @param string $tag Shortcode tag name
	 */
	protected function __construct( $tag ) {
		$this->tag = $tag;
		$this->register();
		$this->set_defaults();
	}

	/**
	 * Register the shortcode with WordPress
	 */
	protected function register() {
		add_shortcode( $this->tag, array( $this, 'render' ) );
	}

	/**
	 * Set default attributes - override in child classes
	 */
	protected function set_defaults() {
		$this->defaults = array();
	}

	/**
	 * Main render method - handles common logic
	 *
	 * @param array  $atts    Shortcode attributes
	 * @param string $content Shortcode content
	 * @return string Rendered output
	 */
	public function render( $atts = array(), $content = '' ) {
		// Don't render in admin unless it's AJAX or Elementor preview
		if ( $this->is_admin_preview() ) {
			return '';
		}

		// Merge with defaults and filter
		$atts = $this->get_final_attributes( $atts );

		// Let child class handle the actual rendering
		return $this->output( $atts, $content );
	}

	/**
	 * Check if we're in admin (not AJAX or preview mode)
	 *
	 * @return bool
	 */
	protected function is_admin_preview() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Only checking if parameter exists, not processing value
		return is_admin() && ! wp_doing_ajax() && ! isset( $_GET['elementor-preview'] );
	}

	/**
	 * Merge attributes with defaults and apply filters
	 *
	 * @param array $atts Raw attributes
	 * @return array Final attributes
	 */
	protected function get_final_attributes( $atts ) {
		$atts = shortcode_atts( $this->defaults, (array) $atts );
		return apply_filters( $this->tag . '_attributes', $atts );
	}

	/**
	 * Output the shortcode HTML - implement in child classes
	 *
	 * @param array  $atts    Final attributes
	 * @param string $content Shortcode content
	 * @return string HTML output
	 */
	abstract protected function output( $atts, $content = '' );

	/**
	 * Get singleton instance
	 *
	 * @param string $tag Shortcode tag
	 * @return static
	 */
	public static function get_instance( $tag ) {
		$class = get_called_class();
		$key = $class . '_' . $tag;

		if ( ! isset( self::$instances[ $key ] ) ) {
			self::$instances[ $key ] = new static( $tag );
		}

		return self::$instances[ $key ];
	}
}
