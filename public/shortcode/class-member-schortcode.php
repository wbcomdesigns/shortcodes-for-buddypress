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
		if ( is_admin() ) {
			return '';
		}
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
		if( 'REIGN' == $active_theme ){
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
}

MemberShortCode::get_instance( 'members-listing' );
