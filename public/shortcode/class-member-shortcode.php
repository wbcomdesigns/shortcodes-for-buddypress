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
	 * Set default attributes for members shortcode
	 */
	protected function set_defaults() {
		$this->defaults = array(
			'title'               => '',
			'type'                => 'active',
			'page'                => false,
			'per_page'            => 20,
			'max'                 => false,
			'page_arg'            => 'upage',
			'include'             => false,
			'exclude'             => false,
			'user_id'             => false,
			'user_ids'            => false,
			'member_type'         => false,
			'include_member_role' => '',
			'exclude_member_role' => '',
			'member_type__in'     => '',
			'member_type__not_in' => '',
			'search_terms'        => false,
			'xprofile_query'      => false,
			'use_compat'          => function_exists( 'bp_use_theme_compat_with_current_theme' )
				? bp_use_theme_compat_with_current_theme()
				: '',
			'meta_key'            => false,
			'meta_value'          => false,
			'populate_extras'     => false,
			'container_class'     => 'members',
			'grid'                => 'yes',
			'loop_layout'         => 'three',
			'grid_layout'         => 'list',
			'grid_columns'        => 'four',
		);
	}

	/**
	 * Prepare attributes before processing
	 */
	protected function get_final_attributes( $atts ) {
		// Handle role-based includes/excludes first
		$atts = $this->apply_role_filters( $atts );

		// Then apply parent logic
		return parent::get_final_attributes( $atts );
	}

	/**
	 * Output the members listing HTML
	 *
	 * @param array  $atts    Final attributes
	 * @param string $content Shortcode content
	 * @return string HTML output
	 */
	protected function output( $atts, $content = '' ) {

		do_action( 'before_member_shortcode_render', $atts );

		$bash_query_args = array(
			'include'             => $atts['include'],
			'exclude'             => $atts['exclude'],
			'type'                => $atts['type'],
			'page'                => $atts['page'],
			'per_page'            => $atts['per_page'],
			'max'                 => $atts['max'],
			'user_id'             => $atts['user_id'],
			'user_ids'            => $atts['user_ids'],
			'member_type'         => $atts['member_type'],
			'member_type__in'     => $atts['member_type__in'],
			'member_type__not_in' => $atts['member_type__not_in'],
			'search_terms'        => $atts['search_terms'],
			'meta_key'            => $atts['meta_key'],
			'meta_value'          => $atts['meta_value'],
			'populate_extras'     => $atts['populate_extras'],
			'xprofile_query'      => $atts['xprofile_query'],
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

		if ( ! function_exists( 'bp_is_active' ) || ! bp_is_active( 'xprofile' ) ) {
			?>
			<div class="bp-messages-feedback">
				<div class="bp-messages bp-user-messages-feedback">
					<div class="bp-feedback info">
						<span class="bp-icon" aria-hidden="true"></span>
						<p><?php esc_html_e( 'To view members, please enable BuddyPress.', 'shortcodes-for-buddypress' ); ?></p>
					</div>
				</div>
			</div>
			<?php
		} else {
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
		}

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
	 * Apply user role filters to include/exclude
	 *
	 * @param array $atts Shortcode attributes
	 * @return array Modified attributes
	 */
	private function apply_role_filters( $atts ) {
		// Handle exclude by role
		if ( ! empty( $atts['exclude_member_role'] ) ) {
			$role_user_ids = $this->get_users_with_roles( $atts['exclude_member_role'] );
			$existing_ids = $this->convert_to_array( isset( $atts['exclude'] ) ? $atts['exclude'] : '' );

			$atts['exclude'] = $this->combine_ids( $role_user_ids, $existing_ids );
			unset( $atts['exclude_member_role'] );
		}

		// Handle include by role
		if ( ! empty( $atts['include_member_role'] ) ) {
			$role_user_ids = $this->get_users_with_roles( $atts['include_member_role'] );
			$existing_ids = $this->convert_to_array( isset( $atts['include'] ) ? $atts['include'] : '' );

			$atts['include'] = $this->combine_ids( $role_user_ids, $existing_ids );
			unset( $atts['include_member_role'] );
		}

		return $atts;
	}

	/**
	 * Get all users with specific roles
	 *
	 * @param string|array $roles Role names (comma-separated or array)
	 * @return array User IDs
	 */
	private function get_users_with_roles( $roles ) {
		if ( empty( $roles ) ) {
			return array();
		}

		// Convert to array if string
		if ( is_string( $roles ) ) {
			$roles = array_map( 'trim', explode( ',', $roles ) );
		}

		// Query users efficiently
		return get_users( array(
			'role__in' => $roles,
			'fields'   => 'ID',
			'number'   => 9999
		) );
	}

	/**
	 * Convert ID string/array to clean array
	 *
	 * @param string|array $ids IDs as string or array
	 * @return array Array of integer IDs
	 */
	private function convert_to_array( $ids ) {
		if ( empty( $ids ) ) {
			return array();
		}

		if ( is_string( $ids ) ) {
			return array_map( 'intval', explode( ',', $ids ) );
		}

		return array_map( 'intval', (array) $ids );
	}

	/**
	 * Combine two ID arrays into comma-separated string
	 *
	 * @param array $ids1 First set of IDs
	 * @param array $ids2 Second set of IDs
	 * @return string Comma-separated unique IDs
	 */
	private function combine_ids( $ids1, $ids2 ) {
		$merged = array_unique( array_merge( (array) $ids1, (array) $ids2 ) );
		return implode( ',', $merged );
	}
}

MemberShortCode::get_instance( 'members-listing' );
