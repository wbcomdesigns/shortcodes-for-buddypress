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
	 * Values BuddyPress accepts for the `type` attribute. Empty = no type check.
	 *
	 * @since 3.0.2
	 * @var string[]
	 */
	protected $allowed_types = array();

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
		$given = (array) $atts;
		$atts  = shortcode_atts( $this->defaults, $given );

		// On Reign an omitted loop_layout follows the site's BuddyPress directory
		// layout, as Reign's own directories do. An explicit value always wins.
		if ( isset( $this->defaults['loop_layout'] ) && ! isset( $given['loop_layout'] ) && $this->is_reign() ) {
			$atts['loop_layout'] = $this->site_loop_layout( $atts['loop_layout'] );
		}

		// Zero, negative, empty or non-numeric per_page means "no limit" to
		// BuddyPress, which listed every row (a 502 on big activity tables).
		// Use the shortcode default instead, capped at 100.
		if ( isset( $this->defaults['per_page'] ) ) {
			$per_page         = is_numeric( $atts['per_page'] ) ? max( 0, (int) $atts['per_page'] ) : 0;
			$atts['per_page'] = min( $per_page ? $per_page : (int) $this->defaults['per_page'], 100 );
		}

		// An unknown type makes BuddyPress drop its filter (every user account
		// instead of active members), so fall back to the default type.
		if ( $this->allowed_types && ! in_array( $atts['type'], $this->allowed_types, true ) ) {
			$atts['type'] = $this->defaults['type'];
		}

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
	 * Whether the active theme is Reign.
	 *
	 * @since 3.0.2
	 * @return bool
	 */
	protected function is_reign() {
		return 'REIGN' === wp_get_theme()->get( 'Name' );
	}

	/**
	 * The site's Nouveau directory layout for this listing, as a column class.
	 *
	 * @since 3.0.2
	 * @param string $fallback Column class used when the site has no layout set.
	 * @return string One of one, two, three, four.
	 */
	protected function site_loop_layout( $fallback ) {
		$appearance = get_option( 'bp_nouveau_appearance' );
		$layout     = is_array( $appearance ) ? (int) ( $appearance[ strtok( $this->tag, '-' ) . '_layout' ] ?? 0 ) : 0;
		$choices    = function_exists( 'bp_nouveau_customizer_grid_choices' ) ? bp_nouveau_customizer_grid_choices( 'classes' ) : array();

		return $choices[ $layout ] ?? $fallback;
	}

	/**
	 * Build the member or group list classes.
	 *
	 * The caller's grid and column classes are always kept. On Reign the
	 * theme's card classes are appended so its directory styling applies.
	 *
	 * @since 3.0.2
	 * @param string[] $classes Base classes including grid and column.
	 * @return string
	 */
	protected function list_classes( $classes ) {
		if ( $this->is_reign() ) {
			global $wbtm_reign_settings;
			$type      = 'members-listing' === $this->tag ? 'member' : 'group';
			$classes[] = 'rg-' . $type . '-list';
			$classes[] = $wbtm_reign_settings['reign_buddyextender'][ $type . '_directory_type' ] ?? 'wbtm-' . $type . '-directory-type-2';
		}

		return implode( ' ', array_filter( $classes ) );
	}

	/**
	 * Echo the "component unavailable" notice.
	 *
	 * All three shortcodes rendered this identical BuddyPress feedback
	 * wrapper inline, differing only in the sentence, so the markup lived in
	 * three places and drifted out of sync whenever one was touched.
	 *
	 * @since 3.0.0
	 * @since 3.0.2 Shown to administrators only.
	 * @param string $message Already-translated, human-readable reason.
	 * @return void
	 */
	protected function render_disabled_notice( $message ) {
		// "Please enable the component" is an instruction for the site owner. Visitors
		// get nothing rather than a message they cannot act on.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
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
	 * Render an Elementor widget through the shortcode.
	 *
	 * Widgets used to build a shortcode string out of their settings and hand
	 * it to do_shortcode(). Any title containing a double quote or a closing
	 * square bracket broke the parser and the title silently vanished, and
	 * because every Elementor control shares the sfb_ prefix the style
	 * controls were injected as bogus attributes too.
	 *
	 * The attributes are now whitelisted against the shortcode's own defaults
	 * and passed as an array, which needs no quoting. The legacy string
	 * filter is still offered first so shortcode-for-buddypress-pro keeps
	 * working: if a filter rewrites the string, that string wins and is run
	 * through do_shortcode() exactly as before.
	 *
	 * @since 3.0.0
	 * @param string $tag         Shortcode tag.
	 * @param array  $settings    Elementor settings (sfb_-prefixed).
	 * @param string $args_filter Legacy string filter name for Pro.
	 * @return string
	 */
	public static function render_from_elementor( $tag, $settings, $args_filter ) {
		$classes = array(
			'activity-listing' => 'ActivityShortCode',
			'members-listing'  => 'MemberShortCode',
			'groups-listing'   => 'GroupShortCode',
		);

		if ( ! isset( $classes[ $tag ] ) || ! class_exists( $classes[ $tag ] ) ) {
			return '';
		}

		$instance = call_user_func( array( $classes[ $tag ], 'get_instance' ), $tag );
		$allowed  = $instance->defaults;

		$atts = array();
		foreach ( (array) $settings as $key => $value ) {
			if ( 0 !== strpos( $key, 'sfb_' ) ) {
				continue;
			}

			$att = substr( $key, 4 );

			// Style controls share the sfb_ prefix but are not attributes.
			if ( ! array_key_exists( $att, $allowed ) ) {
				continue;
			}

			if ( is_array( $value ) ) {
				$flat = array_filter( $value, 'is_scalar' );
				if ( ! empty( $flat ) ) {
					$atts[ $att ] = implode( ',', $flat );
				}
				continue;
			}

			if ( is_scalar( $value ) && '' !== $value ) {
				$atts[ $att ] = $value;
			}
		}

		// Rebuild the legacy string so Pro sees the shape it expects.
		$args = '';
		foreach ( $atts as $att => $value ) {
			$args .= $att . '=' . ( 'title' === $att ? '"' . $value . '"' : $value ) . ' ';
		}
		$args = trim( $args );

		/** This filter is documented in the Pro companion plugin. */
		$filtered = apply_filters( $args_filter, $args );

		if ( $filtered !== $args ) {
			// A Pro filter rewrote the arguments; honour the old contract.
			return do_shortcode( '[' . $tag . ' ' . $filtered . ']' );
		}

		return $instance->render( $atts );
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
