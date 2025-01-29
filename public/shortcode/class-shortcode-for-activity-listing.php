<?php
/**
 * The shortcode class for activity
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

class ActivityShortCode extends BPShortCode {

	// Method to handle Class A shortcode logic
	public function handle_shortcode( $atts, $content = '' ) {

		// Apply filter to attributes
		$atts = apply_filters( 'activity_shortcode_attributes', $atts );

		// Attributes
		$atts = shortcode_atts(
			array(
			'title'            => '', // title of the section
			'pagination'       => 1, // show or not.
			'load_more'        => 0,
			'display_comments' => 'threaded',
			'include'          => false, // pass an activity_id or string of IDs comma-separated
			'exclude'          => false, // pass an activity_id or string of IDs comma-separated
			'in'               => false, // comma-separated list or array of activity IDs among which to search
			'sort'             => 'DESC', // sort DESC or ASC
			'page'             => 1, // which page to load
			'per_page'         => 10, // how many per page
			'max'              => false, // max number to return
			'count_total'      => true,
			'scope'            => false,
			// Filtering
			'user_id'          => false, // user_id to filter on
			'object'           => false, // object to filter on e.g. groups, profile, status, friends
			'action'           => false, // action to filter on e.g. activity_update, new_forum_post, profile_updated
			'primary_id'       => false, // object ID to filter on e.g. a group_id or forum_id or blog_id etc.
			'secondary_id'     => false, // secondary object ID to filter on e.g. a post_id
						// Searching
			'search_terms'     => false, // specify terms to search on
			'use_compat'       => ( function_exists( 'bp_use_theme_compat_with_current_theme' ) ) ? bp_use_theme_compat_with_current_theme() : '',
			'allow_posting'    => false, // experimental, some of the themes may not support it.
			'container_class'  => 'activity', // default container,
			'hide_on_activity' => 1, // hide on user and group activity pages
			),
			$atts
		);


		$exclude_keys = array( 'allow_posting', 'container_class', 'load_more' );

		if ( 'groups' === $atts['object'] && bp_is_active( 'groups' ) ) {
			if ( ( function_exists( 'buddypress' ) && isset( buddypress()->buddyboss ) ) ) {
				$atts['scope'] = 'activity';
			}
		}

		// Apply filter to the bash query
		$bash_query    = apply_filters(
			'activity_shortcode_bash_query',
			array_filter(
				$atts,
				function( $value, $key ) use ( $exclude_keys ) {
					if ( in_array( $key, $exclude_keys ) ) {
						return true; // Keep the key-value pair (do not filter)
					}

					// Filter by non-empty and non-false values
					return ! empty( $value ) && $value !== false;
				},
				ARRAY_FILTER_USE_BOTH
			)
		);

		$template_args = apply_filters( 'activity_shortcode_template_args', array(
			'query'         => build_query( $bash_query ),
			'limit'         => ! empty( $atts['per_page'] ) ? $atts['per_page'] : 10,
			'activity_atts'	=> $bash_query,
		));

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
				<?php if ( function_exists( 'buddypress' ) && buddypress()->buddyboss ) : ?>
					<?php bp_shortcode_get_template( 'activity/bp-shortcodes-activity.php', $template_args, get_option( '_bp_theme_package_id' ) ); ?>
				<?php else : ?>
					<?php bp_shortcode_get_template( 'activity/bp-shortcodes-activity.php', $template_args, get_option( '_bp_theme_package_id' ) ); ?>
				<?php endif; ?>	
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
	 * Get user ids belonging to a specific role.
	 *
	 * @param string|array $roles list of roles.
	 *
	 * @return array
	 */
	private function get_user_ids_by_roles( $roles ) {

		$invalid_ids = array( 0 );
		if ( empty( $roles ) ) {
			return $invalid_ids;// invalid ids.
		}

		if ( ! is_array( $roles ) ) {
			$roles = explode( ',', $roles );
		}

		// trim space etc.
		$roles = array_map( 'trim', $roles );

		$user_query = new WP_User_Query(
			array(
				'role__in' => $roles,
				'fields'   => 'ID',
			)
		);

		$ids = $user_query->get_results();

		if ( empty( $ids ) ) {
			$ids = $invalid_ids;
		}

		return $ids;
	}
}

ActivityShortCode::get_instance( 'activity-listing' );
