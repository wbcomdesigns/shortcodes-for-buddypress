<?php
/**
 * The shortcode class for members
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

class MemberShortCode extends BPShortCode {

	/**
	 * Optimize query arguments for large communities
	 *
	 * @param array $args Original query arguments
	 * @return array Modified query arguments
	 */
	private function optimize_for_large_community($args) {
		// Check if this is a large community
		$is_large_community = false;
		
		if (function_exists('bp_core_get_active_member_count')) {
			$is_large_community = bp_core_get_active_member_count() > 5000;
		}
		
		// If this is a large community, apply limits
		if ($is_large_community) {
			// Ensure reasonable per_page
			if (!isset($args['per_page']) || $args['per_page'] > 50) {
				$args['per_page'] = 50;
			}
			
			// Force a reasonable max value
			if (!isset($args['max']) || $args['max'] > 250 || $args['max'] === false) {
				$args['max'] = 250;
			}
		}
		
		return $args;
	}

	// Method to handle member shortcode logic
	public function handle_shortcode( $atts, $content = '' ) {
		if ( is_admin() && ! wp_doing_ajax() && ! isset( $_GET['elementor-preview'] ) ) {	// phpcs:ignore
			return '';
		}
		// Allow filtering of attributes
		$atts = apply_filters( 'member_shortcode_attributes', $atts );

		// Attributes
		if ( ! empty( $atts ) && array_key_exists( 'exclude_member_role', $atts ) ) {

			if ( ! empty( $atts['exclude_member_role'] ) ) {
				$exclude_roles = is_string( $atts['exclude_member_role'] ) ? explode( ',', $atts['exclude_member_role'] ) : $atts['exclude_member_role'];
				$users_data    = get_users( array( 'role__in' => $exclude_roles ) );
				$uid_collection = wp_list_pluck( $users_data, 'ID' );
			}

			if ( ! empty( $atts['exclude'] ) ) {
				$exclude_ids = is_string( $atts['exclude'] ) ? explode( ',', $atts['exclude'] ) : $atts['exclude'];
			} else {
				$exclude_ids = array();
			}

			$atts['exclude'] = implode( ',', array_unique( array_merge( $uid_collection, $exclude_ids ) ) );
			unset( $atts['exclude_member_role'] );
		}
		if ( ! empty( $atts ) && array_key_exists( 'include_member_role', $atts ) ) {
			if ( isset( $atts['include'] ) && strpos( $atts['include'], ',' ) !== false ) {
				$exclude_ids = explode( ',', $atts['include'] );
			} else {
				$exclude_ids = array();
			}
			$users_data     = get_users( array( 'role__in' => $exclude_roles ) );
			$uid_collection = array();
			foreach ( $users_data as $key => $users ) {
				$uid_collection[] = $users->ID;
			}
			$u               = array_unique( array_merge( $uid_collection, $exclude_ids ) );
			$atts['include'] = rtrim( implode( ',', $u ), ',' );
			unset( $atts['include_member_role'] );
		}
		
		$atts = shortcode_atts(
			array(
			'title'               => '',
			'type'                => 'active', // Type: active ( default ) | random | newest | popular | online | alphabetical.
			'page'                => false,
			'per_page'            => 20,
			'max'                 => false,
			'page_arg'            => 'upage', // See https://buddypress.trac.wordpress.org/ticket/3679.
			'include'             => false, // Pass a user_id or a list (comma-separated or array) of user_ids to only show these users.
			'exclude'             => false, // Pass a user_id or a list (comma-separated or array) of user_ids to exclude these users.
			'user_id'             => false, // Pass a user_id to only show friends of this user.
			'user_ids'            => false, // Pass a user_id to only show friends of this user.
			'member_type'         => false, // Can be a comma-separated list.
			'include_member_role' => '', // Can be a comma-separated list.
			'exclude_member_role' => '', // Can be a comma-separated list.
			'member_type__in'     => '',
			'member_type__not_in' => '',
			'search_terms'        => false,
			( function_exists( 'bp_use_theme_compat_with_current_theme' ) ) ? bp_use_theme_compat_with_current_theme() : '',
			'meta_key'            => false, // Only return users with this usermeta.
			'meta_value'          => false, // Only return users where the usermeta value matches. Requires meta_key.
			'populate_extras'     => false,      // Fetch usermeta? Friend count, last active etc.
			'container_class'     => 'members', // default container,
			'grid'                => 'yes', // Display pagination on members listing. Default true
			'loop_layout'         => 'three', // Display pagination on members listing. Default true
			),
			$atts
		);

		do_action( 'before_member_shortcode_render', $atts );

		$bash_query_args = array(
			'include'             => $atts['include'],
			'exclude'             => $atts['exclude'],
			'type'                => $atts['type'],
			'page'                => $atts['page'],
			'per_page'            => $atts['per_page'],
			'max'                 => $atts['max'],
			'user_ids'            => $atts['user_ids'],
			'member_type'         => $atts['member_type'],
			'member_type__in'     => $atts['member_type__in'],
			'member_type__not_in' => $atts['member_type__not_in'],
			'meta_key'            => $atts['meta_key'],
			'meta_value'          => $atts['meta_value'],
		);

		if (function_exists('bp_core_get_active_member_count') && bp_core_get_active_member_count() > 5000) {
			$atts = $this->optimize_for_large_community($atts);
		}

		// Apply filter to modify query arguments
		$bash_query_args = apply_filters( 'member_shortcode_bash_query_args', $bash_query_args );

		$query = '';
		foreach ( $bash_query_args as $bash_query_key => $bash_query ) {
			$query .= false !== $bash_query && '' !== $bash_query ? '&' . $bash_query_key . '=' . $bash_query : '';
		}
			$grid   = 'yes' === $atts['grid'] ? 'grid' : '';
			$column = '' !== $atts['loop_layout'] && 'yes' === $atts['grid'] ? $atts['loop_layout'] : '';
		$template_args = apply_filters( 'member_shortcode_template_args', array(
			'query'  		=> $query,
			'grid'   		=> $grid,
			'column' 		=> $column,
			'classes'		=> $this->handle_classes( $grid, $column),
			'members_atts'	=> $bash_query_args
		));

		if( class_exists( 'Youzify' )  ){
			unset($template_args['classes']);
			$template_args = apply_filters( 'member_shortcode_template_args', array(
				'query'  		=> $query,
				'grid'   		=> $grid,
				'column' 		=> $column,
				'members_atts'	=> $template_args
			));
		}

		$output = '';
		ob_start();
		do_action( 'member_shortcode_before_output', $atts );
		?>
		<div class="members-listing <?php echo esc_attr( $atts['container_class'] ); ?>">
			<?php echo ! empty( $atts['title'] ) ? '<h4>' . esc_html( $atts['title'] ) . '</h4>' : ''; ?>
			<?php do_action( 'member_shortcode_inside_container', $atts, $template_args ); ?>
			<?php if ( function_exists( 'buddypress' ) && buddypress()->buddyboss ) { 
						 bp_shortcode_get_template( 'members/bb-shortcodes-members.php', $template_args, get_option( '_bp_theme_package_id' ) );
					 }elseif( class_exists( 'Youzify' ) ){ 
						 bp_shortcode_get_template( 'members/bp-shortcodes-members.php', $template_args, 'youzify' ); 
					 }else{ 
						 bp_shortcode_get_template( 'members/bp-shortcodes-members.php', $template_args, get_option( '_bp_theme_package_id' ) ); 
				 } ?>
		</div>
		<?php
		$output = ob_get_contents();
		
		ob_end_clean();

		do_action( 'after_member_shortcode_render', $template_args );

		// Apply filter to modify output before returning
		return apply_filters( 'member_shortcode_output', $output );
	}


	public function handle_classes( $grid, $column) {
		$classes      = array( 'item-list', 'members-list', 'bp-list', 'bpsp-members-list', $grid, $column);
		$active_theme = wp_get_theme();
		if( 'REIGN' == $active_theme && ! class_exists( 'Youzify' ) ){
			   $classes   = [];
			   $classes[] = 'item-list';
			   $classes[] = 'members-list';
			   $classes[] = 'bp-list';
			   $classes[] = 'rg-member-list';
			   
			   global $wbtm_reign_settings;
			   $classes[] = isset( $wbtm_reign_settings['reign_buddyextender']['member_directory_type'] ) ? $wbtm_reign_settings['reign_buddyextender']['member_directory_type'] : 'wbtm-member-directory-type-2';
		   
			   $bp_nouveau_appearance = get_option( 'bp_nouveau_appearance' );
			   $members_layout        = ( isset( $bp_nouveau_appearance['members_layout'] ) && $bp_nouveau_appearance['members_layout'] != '' ) ? $bp_nouveau_appearance['members_layout'] : '3';
		   
			   if ( function_exists( 'bp_nouveau_customizer_grid_choices' ) ) {
				   $grid_classes = bp_nouveau_customizer_grid_choices( 'classes' );
				   if ( isset( $grid_classes[ $members_layout ] ) ) {
					   $classes = array_merge(
						   $classes,
						   array(
							   'grid',
							   $grid_classes[ $members_layout ],
						   )
					   );
				   }
			   } else {
				   $classes = array_merge(
					   $classes,
					   array(
						   'grid',
						   'three',
					   )
				   );
			   }
		}
		$classes = implode(' ',$classes);
		return $classes;
	}

	/**
	 * Get cached member data with proper invalidation
	 *
	 * @param int $member_id The member ID
	 * @return array Member data
	*/
	private function get_cached_member_data($member_id) {
		// Create cache key
		$cache_key = 'bpsh_member_' . $member_id;
		
		// Try to get from object cache
		$member_data = wp_cache_get($cache_key, 'bpsh_members');
		
		// If not in object cache, try transient
		if (false === $member_data) {
			$member_data = get_transient($cache_key);
		}
		
		// If no cached data, get fresh data
		if (false === $member_data) {
			// Get basic user data
			$user_data = get_userdata($member_id);
			
			if (!$user_data) {
				return false;
			}
			
			$member_data = array(
				'id' => $member_id,
				'name' => $user_data->display_name,
				'url' => bp_core_get_user_domain($member_id),
				'avatar' => bp_core_fetch_avatar(array(
					'item_id' => $member_id,
					'type' => 'full',
					'html' => false
				)),
				'last_activity' => bp_get_user_last_activity($member_id),
			);
			
			// Get member type if available
			if (function_exists('bp_get_member_type')) {
				$member_data['member_type'] = bp_get_member_type($member_id);
			}
			
			// Cache duration based on activity level
			$cache_duration = $this->get_member_cache_duration($member_id);
			
			// Cache the data
			wp_cache_set($cache_key, $member_data, 'bpsh_members', $cache_duration);
			set_transient($cache_key, $member_data, $cache_duration);
		}
		
		return $member_data;
	}

	/**
	 * Determine appropriate cache duration for a member
	 *
	 * @param int $member_id Member ID
	 * @return int Cache duration in seconds
	*/
	private function get_member_cache_duration($member_id) {
		// Check last activity
		$last_activity = bp_get_user_last_activity($member_id);
		
		if (empty($last_activity)) {
			// If no activity, cache longer
			return 30 * MINUTE_IN_SECONDS;
		}
		
		// Convert to timestamp
		$last_activity_time = strtotime($last_activity);
		$current_time = time();
		$time_diff = $current_time - $last_activity_time;
		
		// If active in last hour, short cache
		if ($time_diff < HOUR_IN_SECONDS) {
			return 2 * MINUTE_IN_SECONDS;
		}
		
		// If active in last day, medium cache
		if ($time_diff < DAY_IN_SECONDS) {
			return 5 * MINUTE_IN_SECONDS;
		}
		
		// Less active users, longer cache
		return 15 * MINUTE_IN_SECONDS;
	}
}

MemberShortCode::get_instance( 'members-listing' );
