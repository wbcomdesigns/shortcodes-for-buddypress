<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName -- Legacy file name.
/**
 * Activity shortcode file.
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.7.0
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/shortcode
 */

/**
 * Activity shortcode class.
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/shortcode
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class ActivityShortCode extends BPShortCode {

	/**
	 * Set default attributes.
	 */
	protected function set_defaults() {
		$this->defaults = array(
			// Display options.
			'title'            => '',
			'pagination'       => 1,
			'load_more'        => 0,
			'display_comments' => 'false',
			'container_class'  => 'activity',
			'hide_on_activity' => 1,
			'allow_posting'    => false,

			// Activity selection.
			'include'          => false,
			'exclude'          => false,
			'in'               => false,

			// Pagination.
			'page'             => 1,
			'per_page'         => 10,
			'max'              => false,

			// Sorting.
			'sort'             => 'DESC',
			'count_total'      => true,

			// Filtering.
			'scope'            => false,
			'user_id'          => false,
			'object'           => false,
			'action'           => false,
			'primary_id'       => false,
			'secondary_id'     => false,

			// Search.
			'search_terms'     => false,

			// Theme compatibility.
			'use_compat'       => function_exists( 'bp_use_theme_compat_with_current_theme' )
				? bp_use_theme_compat_with_current_theme()
				: '',
		);
	}

	/**
	 * Output shortcode HTML.
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Content.
	 * @return string
	 */
	protected function output( $atts, $content = '' ) {
		// Fix BuddyBoss group activities scope.
		$atts = $this->fix_buddyboss_groups( $atts );

		// Get activity query args.
		$query = $this->get_query_args( $atts );

		// Setup template variables.
		$template_vars = $this->get_template_vars( $atts, $query );

		// Generate HTML.
		return $this->generate_html( $atts, $template_vars );
	}

	/**
	 * Fix BuddyBoss groups.
	 *
	 * @param array $atts Attributes.
	 * @return array
	 */
	private function fix_buddyboss_groups( $atts ) {
		if ( 'groups' === $atts['object'] &&
			function_exists( 'bp_is_active' ) &&
			bp_is_active( 'groups' ) &&
			function_exists( 'buddypress' ) &&
			isset( buddypress()->buddyboss ) ) {
			$atts['scope'] = 'activity';
		}
		return $atts;
	}

	/**
	 * Get query arguments.
	 *
	 * @param array $atts Attributes.
	 * @return array
	 */
	private function get_query_args( $atts ) {
		// These are display-only keys, not query parameters.
		$exclude_keys = array(
			'allow_posting',
			'container_class',
			'load_more',
			'title',
			'pagination',
			'display_comments',
			'hide_on_activity',
		);

		// Build query args from attributes.
		$query_args = array();
		foreach ( $atts as $key => $value ) {
			// Skip display-only keys.
			if ( in_array( $key, $exclude_keys, true ) ) {
				continue;
			}
			// Only include non-empty values.
			if ( false !== $value && '' !== $value && null !== $value ) {
				$query_args[ $key ] = $value;
			}
		}

		// Force disable comments to prevent BuddyPress compatibility issues.
		// This prevents the get_activity_comments() TypeError.
		$query_args['display_comments'] = 'false';

		return apply_filters( 'activity_shortcode_bash_query', $query_args );
	}

	/**
	 * Get template variables.
	 *
	 * @param array $atts  Attributes.
	 * @param array $query Query arguments.
	 * @return array
	 */
	private function get_template_vars( $atts, $query ) {
		$args = array(
			'query'         => http_build_query( $query ),
			'limit'         => ! empty( $atts['per_page'] ) ? $atts['per_page'] : 10,
			'activity_atts' => $query,
			'allow_posting' => (bool) $atts['allow_posting'],
			'load_more'     => (bool) $atts['load_more'],
		);

		// Youzify theme requires different structure.
		if ( class_exists( 'Youzify' ) ) {
			$args['activity_atts'] = $args;
		}

		return apply_filters( 'activity_shortcode_template_args', $args );
	}

	/**
	 * Generate HTML.
	 *
	 * @param array $atts Attributes.
	 * @param array $template_vars Template variables.
	 * @return string
	 */
	private function generate_html( $atts, $template_vars ) {
		do_action( 'before_activity_shortcode_render', $atts );

		ob_start();

		if ( ! function_exists( 'bp_is_active' ) || ! bp_is_active( 'activity' ) ) {
			$this->show_disabled_message();
		} else {
			$this->show_activities( $atts, $template_vars );
		}

		return ob_get_clean();
	}

	/**
	 * Show disabled message.
	 */
	private function show_disabled_message() {
		?>
		<div class="bp-messages-feedback">
			<div class="bp-messages bp-user-messages-feedback">
				<div class="bp-feedback info">
					<span class="bp-icon" aria-hidden="true"></span>
					<p><?php esc_html_e( 'To view activities, please enable the activity component.', 'shortcodes-for-buddypress' ); ?></p>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Show activities.
	 *
	 * @param array $atts Attributes.
	 * @param array $template_vars Template variables.
	 */
	private function show_activities( $atts, $template_vars ) {
		?>
		<div class="activity-listing">
			<?php if ( ! empty( $atts['title'] ) ) : ?>
				<h4><?php echo esc_html( $atts['title'] ); ?></h4>
			<?php endif; ?>

			<?php do_action( 'activity_shortcode_inside_container', $atts, $template_vars ); ?>

			<?php $this->load_template( $template_vars ); ?>
		</div>
		<?php
	}

	/**
	 * Load template.
	 *
	 * @param array $template_vars Template variables.
	 */
	private function load_template( $template_vars ) {
		$template = 'activity/bp-shortcodes-activity.php';

		if ( function_exists( 'buddypress' ) && buddypress()->buddyboss ) {
			$theme = get_option( '_bp_theme_package_id' );
		} elseif ( class_exists( 'Youzify' ) ) {
			$theme = 'youzify';
		} else {
			$theme = get_option( '_bp_theme_package_id' );
		}

		// Add fallback error handling for template loading.
		try {
			bp_shortcode_get_template( $template, $template_vars, $theme );
		} catch ( Throwable $e ) {
			// If template loading fails, show a simple fallback.
			$this->show_simple_fallback( $template_vars );
		}

		do_action( 'after_activity_shortcode_render', $template_vars );
	}

	/**
	 * Show fallback.
	 *
	 * @param array $template_vars Template variables.
	 */
	private function show_simple_fallback( $template_vars ) {
		?>
		<div class="activity-listing">
			<div class="bp-feedback info">
				<span class="bp-icon" aria-hidden="true"></span>
				<p><?php esc_html_e( 'Activity listing is temporarily unavailable. Please check back later.', 'shortcodes-for-buddypress' ); ?></p>
			</div>
		</div>
		<?php
	}

}

ActivityShortCode::get_instance( 'activity-listing' );
