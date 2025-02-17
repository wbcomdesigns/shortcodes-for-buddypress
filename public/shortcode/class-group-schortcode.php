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

class GroupShortCode extends BPShortCode {

	// Method to handle Class A shortcode logic
	public function handle_shortcode( $atts, $content = '' ) {

		// Apply filter to modify attributes
		$atts = apply_filters( 'group_shortcode_attributes', $atts );

		// Attributes
		$atts = shortcode_atts(
			array(
				'title'              => '',
				'type'               => 'alphabetical', // popular, alphabetical, invites, single-group
				'order'              => 'DESC',
				'orderby'            => 'last_activity',
				'page'               => 1,
				'per_page'           => 20,
				'max'                => false,
				'show_hidden'        => false,
				'page_arg'           => 'grpage',
				'user_id'            => false,
				'slug'               => false,
				'search_terms'       => false,
				'group_type'         => false,
				'group_type__in'     => '',
				'group_type__not_in' => '',
				'meta_query'         => false,
				( function_exists( 'bp_use_theme_compat_with_current_theme' ) ) ? bp_use_theme_compat_with_current_theme() : '',
				'include'            => false,
				'exclude'            => false,
				'parent_id'          => 0,
				'update_meta_cache'  => true,
				'container_class'    => 'group', // default container,
				'grid'               => 'yes', // Display as a grid or list
				'loop_layout'        => 'three', // Columns of group layout. This will work only grid layout
				'container_class'    => 'groups', //(string) Default 'groups' . Allows to change the class of the shortcode contents wrapper.
			),
			$atts
		);

		do_action( 'before_group_shortcode_render', $atts );

		$bash_query_args = array(
			'include'            => $atts['include'],
			'exclude'            => $atts['exclude'],
			'type'               => $atts['type'],
			'page'               => $atts['page'],
			'per_page'           => $atts['per_page'],
			'max'                => $atts['max'],
			'user_id'            => $atts['user_id'],
			'order'              => $atts['order'],
			'orderby'            => $atts['orderby'],
			// 'show_hidden'        => $atts['show_hidden'],
			// 'slug'               => $atts['slug'],
			'group_type'         => $atts['group_type'],
			'group_type__in'     => $atts['group_type__in'],
			'group_type__not_in' => $atts['group_type__not_in'],
			'parent_id'          => $atts['parent_id'],
		);

		// Apply filter to modify query arguments
		$bash_query_args = apply_filters( 'group_shortcode_bash_query_args', $bash_query_args );

		$query = '';
		foreach ( $bash_query_args as $bash_query_key => $bash_query ) {
			$query .= false !== $bash_query && '' !== $bash_query ? '&' . $bash_query_key . '=' . $bash_query : '';
		}

		$template_args = apply_filters( 'group_shortcode_template_args', array(
			'query'  		=> $query,
			'grid'   		=> 'yes' === $atts['grid'] ? 'grid' : '',
			'column' 		=> '' !== $atts['loop_layout'] && 'yes' === $atts['grid'] ? $atts['loop_layout'] : '',
			'groups_atts'   => $bash_query_args,
		));

		$output = '';
		ob_start();
		if ( ! bp_is_active( 'groups' ) ) {
			?>	
			<div class="bp-messages-feedback">
				<div class="bp-messages bp-user-messages-feedback">
					<div class="bp-feedback info">
						<span class="bp-icon" aria-hidden="true"></span>
						<p><?php esc_attr_e( 'To view groups, please enable the group component.', 'shortcodes-for-buddypress' ); ?></p>
					</div>
				</div>
			</div>
			<?php
		} else {
			?>
			<div class="groups-listing <?php echo esc_attr( $atts['container_class'] ); ?>">
				<?php echo ! empty( $atts['title'] ) ? '<h4>' . esc_html( $atts['title'] ) . '</h4>' : ''; ?>
				<?php do_action( 'group_shortcode_inside_container', $atts, $template_args ); ?>

				<?php if ( function_exists( 'buddypress' ) && buddypress()->buddyboss ) { 
						 bp_shortcode_get_template( 'groups/bb-shortcodes-groups.php', $template_args, get_option( '_bp_theme_package_id' ) );
					 }elseif( class_exists( 'Youzify' ) ){ 
						 bp_shortcode_get_template( 'groups/bp-shortcodes-groups.php', $template_args, 'youzify' ); 
					 }else{ 
						 bp_shortcode_get_template( 'groups/bp-shortcodes-groups.php', $template_args, get_option( '_bp_theme_package_id' ) ); 
				 } ?>
			</div>
			<?php
		}
		$output = ob_get_contents();
		ob_end_clean();

		do_action( 'after_group_shortcode_render', $template_args );

		// Apply filter to modify output before returning
		return apply_filters( 'group_shortcode_output', $output );
	}
}

GroupShortCode::get_instance( 'groups-listing' );
