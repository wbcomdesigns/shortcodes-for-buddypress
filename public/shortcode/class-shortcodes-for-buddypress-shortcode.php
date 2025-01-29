<?php
/**
 * The abstract class for shortcode
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.7.0
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/shortcode
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/shortcode
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
abstract class BPShortCode {

	protected $tag;

	// Array to store instances of subclasses
	private static $instances = array();

	// Constructor to set shortcode tag and register shortcode
	protected function __construct( $tag ) {
		$this->tag = $tag;
		add_shortcode( $this->tag, array( $this, 'handle_shortcode' ) );
	}


	// Abstract method to handle shortcode logic
	abstract public function handle_shortcode( $atts, $content = '');

	// Method to get or create instance of subclass
	public static function get_instance( $tag ) {
		if ( ! isset( self::$instances[ $tag ] ) ) {
			self::$instances[ $tag ] = new static( $tag );
		}
		return self::$instances[ $tag ];
	}

	// Method to render the shortcode
	public function render( $atts, $content = '' ) {
		return $this->handle_shortcode( $atts, $content );
	}

}
