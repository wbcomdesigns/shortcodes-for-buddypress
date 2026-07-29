<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName -- Legacy file name.
/**
 * Base shortcode class file.
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/shortcode
 * @since      1.7.0
 */

/**
 * Base shortcode class.
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/shortcode
 * @since      1.7.0
 */
abstract class BPShortCode {

	/**
	 * Shortcode tag.
	 *
	 * @var string
	 */
	protected $tag;

	/**
	 * Default attributes.
	 *
	 * @var array
	 */
	protected $defaults = array();

	/**
	 * Singleton instances.
	 *
	 * @var array
	 */
	private static $instances = array();

	/**
	 * Constructor.
	 *
	 * @param string $tag Shortcode tag.
	 */
	protected function __construct( $tag ) {
		$this->tag = $tag;
		$this->register();
		$this->set_defaults();
	}

	/**
	 * Register shortcode.
	 *
	 * @return void
	 */
	protected function register() {
		add_shortcode( $this->tag, array( $this, 'render' ) );
	}

	/**
	 * Set default attributes.
	 *
	 * @return void
	 */
	protected function set_defaults() {
		$this->defaults = array();
	}

	/**
	 * Render shortcode.
	 *
	 * @param array  $atts    Shortcode attributes.
	 * @param string $content Shortcode content.
	 * @return string
	 */
	public function render( $atts = array(), $content = '' ) {
		// Don't render in admin unless it's AJAX or Elementor preview.
		if ( $this->is_admin_preview() ) {
			return '';
		}

		// Merge with defaults and filter.
		$atts = $this->get_final_attributes( $atts );

		// Let child class handle the actual rendering.
		return $this->output( $atts, $content );
	}

	/**
	 * Check if in admin preview.
	 *
	 * @return bool
	 */
	protected function is_admin_preview() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return is_admin() && ! wp_doing_ajax() && ! isset( $_GET['elementor-preview'] );
	}

	/**
	 * Get final attributes.
	 *
	 * @param array $atts Raw attributes.
	 * @return array
	 */
	protected function get_final_attributes( $atts ) {
		$atts = shortcode_atts( $this->defaults, (array) $atts );
		return apply_filters( $this->tag . '_attributes', $atts );
	}

	/**
	 * Output shortcode HTML.
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Content.
	 * @return string
	 */
	abstract protected function output( $atts, $content = '' );

	/**
	 * Echo the "component unavailable" notice.
	 *
	 * All three shortcodes rendered this identical BuddyPress feedback
	 * wrapper inline, differing only in the sentence, so the markup lived in
	 * three places and drifted out of sync whenever one was touched.
	 *
	 * @since 3.0.0
	 * @param string $message Already-translated, human-readable reason.
	 * @return void
	 */
	protected function render_disabled_notice( $message ) {
		?>
		<div class="bp-messages-feedback">
			<div class="bp-messages bp-user-messages-feedback">
				<div class="bp-feedback info">
					<span class="bp-icon" aria-hidden="true"></span>
					<p><?php echo esc_html( $message ); ?></p>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Get singleton instance.
	 *
	 * @param string $tag Shortcode tag.
	 * @return static
	 */
	public static function get_instance( $tag ) {
		$class = get_called_class();
		$key   = $class . '_' . $tag;

		if ( ! isset( self::$instances[ $key ] ) ) {
			self::$instances[ $key ] = new static( $tag );
		}

		return self::$instances[ $key ];
	}
}
