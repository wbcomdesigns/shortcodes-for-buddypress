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
	 * Handles the shortcode logic and renders the activity stream.
	 *
	 * This method processes the shortcode attributes, prepares the query arguments,
	 * and renders the activity stream using the appropriate template.
	 *
	 * @since 1.7.0
	 * @param array  $atts    Shortcode attributes.
	 * @param string $content Shortcode content.
	 * @return string HTML output of the activity stream.
	 */
	public function handle_shortcode( $atts, $content = '' ) {
		if ( is_admin() && ! wp_doing_ajax() && ! isset( $_GET['elementor-preview'] ) ) {	// phpcs:ignore
			return '';
		}
		// Apply filter to attributes
		$atts = apply_filters( 'activity_shortcode_attributes', $atts );

		// Define and merge shortcode attributes with defaults
		$atts = shortcode_atts(
			array(
			// Display options
			'title'            => '',      // Optional title to display above the activity stream
			'pagination'       => 1,       // Whether to show pagination (1 = yes, 0 = no)
			'load_more'        => 0,       // Whether to use AJAX "Load More" button instead of pagination (1 = yes, 0 = no)
			'display_comments' => 'threaded', // How to display comments: 'threaded', 'flat', or 'false' to hide
			'container_class'  => 'activity', // CSS class for the container element
			'hide_on_activity' => 1,       // Whether to hide this shortcode on BuddyPress activity pages (1 = yes, 0 = no)
			'allow_posting'    => false,   // Whether to show the activity posting form (experimental)
			
			// Activity selection
			'include'          => false,   // Activity IDs to include (comma-separated string or array)
			'exclude'          => false,   // Activity IDs to exclude (comma-separated string or array)
			'in'               => false,   // Only include activities with these IDs (comma-separated string or array)
			
			// Pagination
			'page'             => 1,       // Which page to display
			'per_page'         => 10,      // Number of activities per page
			'max'              => false,   // Maximum number of activities to return in total
			
			// Sorting
			'sort'             => 'DESC',  // Sort order: 'DESC' (newest first) or 'ASC' (oldest first)
			'count_total'      => true,    // Whether to count the total number of activities
			
			// Filtering options
			'scope'            => false,   // Activity scope (e.g., 'all', 'just-me', 'friends', etc.)
			'user_id'          => false,   // Filter by user ID
			'object'           => false,   // Filter by object type (e.g., 'groups', 'profile', 'status', 'friends')
			'action'           => false,   // Filter by action type (e.g., 'activity_update', 'new_forum_post', 'profile_updated')
			'primary_id'       => false,   // Filter by primary object ID (e.g., group_id, forum_id, blog_id)
			'secondary_id'     => false,   // Filter by secondary object ID (e.g., post_id)
			
			// Search options
			'search_terms'     => false,   // Terms to search for in activities
			
			// Theme compatibility
			'use_compat'       => ( function_exists( 'bp_use_theme_compat_with_current_theme' ) ) ? bp_use_theme_compat_with_current_theme() : '',
			),
			$atts
		);


		// Define keys that should be excluded from the activity query but kept for template use
		// These attributes control the display rather than the activity query itself
		$exclude_keys = array( 'allow_posting', 'container_class', 'load_more' );

		// Special handling for BuddyBoss Platform when displaying group activities
		// This sets the scope to 'activity' for proper display in BuddyBoss
		if ( 'groups' === $atts['object'] && bp_is_active( 'groups' ) ) {
			if ( ( function_exists( 'buddypress' ) && isset( buddypress()->buddyboss ) ) ) {
				$atts['scope'] = 'activity';
			}
		}

		// Create the query arguments by filtering the attributes
		// This removes empty values and applies any custom filtering via the hook
		$bash_query = apply_filters(
			'activity_shortcode_bash_query',
			array_filter(
				$atts,
				function( $value, $key ) use ( $exclude_keys ) {
					if ( in_array( $key, $exclude_keys ) ) {
						return true; // Keep these special keys regardless of their value
					}

					// For all other keys, only keep them if they have a value
					return ! empty( $value ) && $value !== false;
				},
				ARRAY_FILTER_USE_BOTH
			)
		);

		// Prepare arguments to pass to the template
		// This includes the query string, pagination limits, and display options
		$template_args = apply_filters( 'activity_shortcode_template_args', array(
			'query'         => build_query( $bash_query ),  // Convert query array to URL parameters
			'limit'         => ! empty( $atts['per_page'] ) ? $atts['per_page'] : 10,  // Items per page
			'activity_atts'	=> $bash_query,  // Pass the full query args for reference
			'allow_posting' => ! empty( $atts['allow_posting'] ) ? $atts['allow_posting'] : false,  // Whether to show posting form
			'load_more'     => ! empty( $atts['load_more'] ) ? $atts['load_more'] : false,  // Whether to use AJAX loading
		));

		// Special handling for Youzify theme compatibility
		// Youzify requires a different structure for the template arguments
		if( class_exists( 'Youzify' )  ){
			$template_args = apply_filters( 'activity_shortcode_template_args', array(
				'query'         => build_query( $bash_query ),
				'limit'         => ! empty( $atts['per_page'] ) ? $atts['per_page'] : 10,
				'activity_atts'	=> $template_args,  // Note: Youzify expects the entire args array here
				'allow_posting' => ! empty( $atts['allow_posting'] ) ? $atts['allow_posting'] : false,
				'load_more'     => ! empty( $atts['load_more'] ) ? $atts['load_more'] : false,
			));
		}

		do_action( 'before_activity_shortcode_render', $atts );

		$output        = '';
		ob_start();
		if ( ! bp_is_active( 'activity' ) ) {
			?>	
			<div class="bp-messages-feedback">
				<div class="bp-messages bp-user-messages-feedback">
					<div class="bp-feedback info">
						<span class="bp-icon" aria-hidden="true"></span>
						<p><?php esc_attr_e( 'To view activities, please enable the activity component.', 'shortcodes-for-buddypress' ); ?></p>
					</div>
				</div>
			</div>
			<?php
		} else {
			?>
			<div class="activity-listing">
				<?php echo ! empty( $atts['title'] ) ? '<h4>' . esc_html( $atts['title'] ) . '</h4>' : ''; ?>
				<?php do_action( 'activity_shortcode_inside_container', $atts, $template_args ); ?>
				<?php if ( function_exists( 'buddypress' ) && buddypress()->buddyboss ) { 
						 bp_shortcode_get_template( 'activity/bp-shortcodes-activity.php', $template_args, get_option( '_bp_theme_package_id' ) );
					 }elseif( class_exists( 'Youzify' ) ){ 
						 bp_shortcode_get_template( 'activity/bp-shortcodes-activity.php', $template_args, 'youzify' ); 
					 }else{ 
						 bp_shortcode_get_template( 'activity/bp-shortcodes-activity.php', $template_args, get_option( '_bp_theme_package_id' ) ); 
				 } ?>	
			</div>
			<?php
		}

		$output = ob_get_contents();
		ob_end_clean();

		do_action( 'after_activity_shortcode_render', $template_args );

		// Apply filter to output before returning
		$output = apply_filters( 'activity_shortcode_output', $output );

		return $output;
	}

	/**
	 * Retrieves user IDs belonging to specific WordPress roles.
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
