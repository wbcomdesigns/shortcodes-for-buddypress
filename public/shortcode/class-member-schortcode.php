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

	// Method to handle Class A shortcode logic
	public function handle_shortcode( $atts, $content = '' ) {

		// Allow filtering of attributes
		$atts = apply_filters( 'member_shortcode_attributes', $atts );

		// Attributes
		if ( ! empty( $atts ) && array_key_exists( 'exclude_member_role', $atts ) ) {

			if ( strpos( $atts['exclude_member_role'], ',' ) !== false ) {
				$exclude_roles = explode( ',', $atts['exclude_member_role'] );
			} else {
				$exclude_roles = $atts['exclude_member_role'];
			}
			if ( isset( $atts['exclude'] ) && strpos( $atts['exclude'], ',' ) !== false ) {
				$exclude_ids = explode( ',', $atts['exclude'] );
			} else {
				$exclude_ids = array();
			}
			$users_data     = get_users( array( 'role__in' => $exclude_roles ) );
			$uid_collection = array();
			foreach ( $users_data as $key => $users ) {
				$uid_collection[] = $users->ID;
			}
			$u               = array_unique( array_merge( $uid_collection, $exclude_ids ) );
			$atts['exclude'] = rtrim( implode( ',', $u ), ',' );
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
			'populate_extras'     => true,      // Fetch usermeta? Friend count, last active etc.
			'container_class'     => 'members', // default container,
			'loop-layout'         => ! empty( $atts['loop-layout'] ) ? $atts['loop-layout'] : 'three',
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

		// Apply filter to modify query arguments
		$bash_query_args = apply_filters( 'member_shortcode_bash_query_args', $bash_query_args );

		$query = '';
		foreach ( $bash_query_args as $bash_query_key => $bash_query ) {
			$query .= false !== $bash_query && '' !== $bash_query ? '&' . $bash_query_key . '=' . $bash_query : '';
		}

		$template_args = apply_filters( 'member_shortcode_template_args', array(
			'query'  		=> $query,
			'members_atts'	=> $bash_query_args
		));

		$output = '';
		ob_start();
		do_action( 'member_shortcode_before_output', $atts );
		?>
		<div class="members-listing <?php echo esc_attr( $atts['container_class'] ); ?>">
			<?php echo ! empty( $atts['title'] ) ? '<h4>' . esc_html( $atts['title'] ) . '</h4>' : ''; ?>
			<?php do_action( 'member_shortcode_inside_container', $atts, $template_args ); ?>
			<?php if ( function_exists( 'buddypress' ) && buddypress()->buddyboss ) : ?>
				<?php bp_shortcode_get_template( 'members/bb-shortcodes-members.php', $template_args, get_option( '_bp_theme_package_id' ) ); ?>
			<?php else : ?>
				<?php bp_shortcode_get_template( 'members/bp-shortcodes-members.php', $template_args, get_option( '_bp_theme_package_id' ) ); ?>
			<?php endif; ?>	
		</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		do_action( 'after_member_shortcode_render', $template_args );

		// Apply filter to modify output before returning
		return apply_filters( 'member_shortcode_output', $output );
	}

	/**
	 * Get user by role in
	 *
	 * @param array $roles
	 * @return array user's id
	 */
	private function get_role_in_users( $roles ) {
		if ( empty( $roles ) ) {
			return false;
		}

		$users   = get_users( array( 'role__in' => $roles ) );
		$user_id = array();

		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				$user_id[] = $user->ID;
			}
		}

		return apply_filters( 'bp_shortcode_pro_get_users_by_role_in', $user_id );

	}

	/**
	 * Get user ids by role not in
	 *
	 * @param array $roles
	 * @return array user's id
	 */
	private function get_role_not_in_users( $roles ) {
		if ( empty( $roles ) ) {
			return false;
		}

		$users   = get_users( array( 'role__in' => $roles ) );
		$user_id = array();

		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				$user_id[] = $user->ID;
			}
		}

		return apply_filters( 'bp_shortcode_pro_get_users_by_role_not_in', $user_id );

	}
}

MemberShortCode::get_instance( 'members-listing' );
