<?php
/**
 * The shortcode class for BuddyPress activity streams
 *
 * This class handles the [activity-listing] shortcode which allows users to embed
 * BuddyPress activity streams on any WordPress post or page.
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.7.0
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/shortcode
 */

/**
 * The ActivityShortCode class.
 *
 * Implements the functionality for the [activity-listing] shortcode which displays
 * BuddyPress activity streams with various filtering and display options.
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/shortcode
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class ActivityShortCode extends BPShortCode {

	/**
	 * Set default attributes for activity shortcode
	 */
	protected function set_defaults() {
		$this->defaults = array(
			// Display options
			'title'            => '',
			'pagination'       => 1,
			'load_more'        => 0,
			'display_comments' => 'false',
			'container_class'  => 'activity',
			'hide_on_activity' => 1,
			'allow_posting'    => false,

			// Activity selection
			'include'          => false,
			'exclude'          => false,
			'in'               => false,

			// Pagination
			'page'             => 1,
			'per_page'         => 10,
			'max'              => false,

			// Sorting
			'sort'             => 'DESC',
			'count_total'      => true,

			// Filtering
			'scope'            => false,
			'user_id'          => false,
			'object'           => false,
			'action'           => false,
			'primary_id'       => false,
			'secondary_id'     => false,

			// Search
			'search_terms'     => false,

			// Theme compatibility
			'use_compat'       => function_exists( 'bp_use_theme_compat_with_current_theme' )
				? bp_use_theme_compat_with_current_theme()
				: '',
		);
	}

	/**
	 * Output the activity stream HTML
	 *
	 * @param array  $atts    Final attributes
	 * @param string $content Shortcode content
	 * @return string HTML output
	 */
	protected function output( $atts, $content = '' ) {
		// Fix BuddyBoss group activities scope
		$atts = $this->fix_buddyboss_groups( $atts );

		// Get activity query args
		$query = $this->get_query_args( $atts );

		// Setup template variables
		$template_vars = $this->get_template_vars( $atts, $query );

		// Generate HTML
		return $this->generate_html( $atts, $template_vars );
	}

	/**
	 * Fix BuddyBoss group activity scope issue
	 *
	 * @param array $atts Shortcode attributes
	 * @return array Fixed attributes
	 */
	private function fix_buddyboss_groups( $atts ) {
		if ( 'groups' === $atts['object'] &&
		     bp_is_active( 'groups' ) &&
		     function_exists( 'buddypress' ) &&
		     isset( buddypress()->buddyboss ) ) {
			$atts['scope'] = 'activity';
		}
		return $atts;
	}

	/**
	 * Get query arguments for activity loop
	 *
	 * @param array $atts Shortcode attributes
	 * @return array Query args for bp_has_activities()
	 */
	private function get_query_args( $atts ) {
		// These are display-only keys, not query parameters
		$exclude_keys = array(
			'allow_posting',
			'container_class',
			'load_more',
			'title',
			'pagination',
			'display_comments',
			'hide_on_activity'
		);

		// Build query args from attributes
		$query_args = array();
		foreach ( $atts as $key => $value ) {
			// Skip display-only keys
			if ( in_array( $key, $exclude_keys ) ) {
				continue;
			}
			// Only include non-empty values
			if ( $value !== false && $value !== '' && $value !== null ) {
				$query_args[ $key ] = $value;
			}
		}

		// Force disable comments to prevent BuddyPress compatibility issues
		// This prevents the get_activity_comments() TypeError
		$query_args['display_comments'] = 'false';

		return apply_filters( 'activity_shortcode_bash_query', $query_args );
	}

	/**
	 * Get template variables for activity display
	 *
	 * @param array $atts  Shortcode attributes
	 * @param array $query Query arguments
	 * @return array Template variables
	 */
	private function get_template_vars( $atts, $query ) {
		$args = array(
			'query'         => http_build_query( $query ),
			'limit'         => ! empty( $atts['per_page'] ) ? $atts['per_page'] : 10,
			'activity_atts' => $query,
			'allow_posting' => (bool) $atts['allow_posting'],
			'load_more'     => (bool) $atts['load_more'],
		);

		// Youzify theme requires different structure
		if ( class_exists( 'Youzify' ) ) {
			$args['activity_atts'] = $args;
		}

		return apply_filters( 'activity_shortcode_template_args', $args );
	}

	/**
	 * Generate the complete HTML output
	 *
	 * @param array $atts Shortcode attributes
	 * @param array $template_vars Template variables
	 * @return string Complete HTML
	 */
	private function generate_html( $atts, $template_vars ) {
		do_action( 'before_activity_shortcode_render', $atts );

		ob_start();

		if ( ! bp_is_active( 'activity' ) ) {
			$this->show_disabled_message();
		} else {
			$this->show_activities( $atts, $template_vars );
		}

		return ob_get_clean();
	}

	/**
	 * Show message when activity component is disabled
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
	 * Show the activity stream content
	 *
	 * @param array $atts Shortcode attributes
	 * @param array $template_vars Template variables
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
	 * Load the activity template file
	 *
	 * @param array $template_vars Template variables
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

		// Add fallback error handling for template loading
		try {
			bp_shortcode_get_template( $template, $template_vars, $theme );
		} catch ( Throwable $e ) {
			// If template loading fails, show a simple fallback
			$this->show_simple_fallback( $template_vars );
		}

		do_action( 'after_activity_shortcode_render', $template_vars );
	}

	/**
	 * Show a simple fallback when template loading fails
	 *
	 * @param array $template_vars Template variables
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

	/**
	 * Get user IDs by WordPress roles
	 *
	 * This method queries the WordPress database to find users with the specified
	 * roles and returns an array of their user IDs. This is useful for filtering
	 * activities by user role rather than individual user IDs.
	 *
	 * @since 1.7.0
	 * @param string|array $roles A comma-separated string or array of WordPress role names.
	 *                            Example: 'administrator,editor' or ['administrator', 'editor']
	 * @return array An array of user IDs. Returns [0] if no users are found or if roles are empty.
	 */
	private function get_user_ids_by_roles( $roles ) {
		// Default return value for invalid/empty results
		$invalid_ids = array( 0 );
		
		// Return default if no roles provided
		if ( empty( $roles ) ) {
			return $invalid_ids;
		}

		// Convert string of roles to array if needed
		if ( ! is_array( $roles ) ) {
			$roles = explode( ',', $roles );
		}

		// Sanitize role names by trimming whitespace
		$roles = array_map( 'trim', $roles );

		// Query WordPress for users with the specified roles
		$user_query = new WP_User_Query(
			array(
				'role__in' => $roles, // Find users with any of these roles
				'fields'   => 'ID',   // Return only user IDs
			)
		);

		// Get the results from the query
		$ids = $user_query->get_results();

		// Return default invalid ID if no users found
		if ( empty( $ids ) ) {
			$ids = $invalid_ids;
		}

		return $ids;
	}
}

ActivityShortCode::get_instance( 'activity-listing' );
