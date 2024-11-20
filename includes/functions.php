<?php

/** Includes EDD sell services template file.
 *
 * @since 1.0.0
 * @param string $file_name file name to include the specific template. 
 * @return void.
 */

function shortcodes_for_buddypress_template( $file_name ) {
	
	$template_name = 'shortcodes-for-buddypress/' . $file_name;

	if ( file_exists( get_stylesheet_directory() . '/' . $template_name ) ) {
		$template_path = get_stylesheet_directory() . '/' . $template_name;

	} elseif ( file_exists( get_template_directory() . '/' . $template_name ) ) {
		$template_path = get_template_directory() . '/' . $template_name;

	} else {
		if ( file_exists( SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR . 'templates/' . $file_name ) ){
			$template_path = SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR . 'templates/' . $file_name ;
		} else {
			return false;
		}
	}
	
	/** Apply filter to extend the functionality of template override so that user can use this filter to replace current template path with its own template path.
	 * If template path exist then include the template and list the functionality of shortcode.
	 * @since 2.7.2
	 */
	if ( $template_path ) {
		$template_path  = apply_filters( 'shortcodes_for_buddypress_custom_template_path' , $template_path );
		include $template_path;
	}
}

function bp_shortcode_is_shortcode_page( $shortcode = '' ) {
	global $post;

	if ( empty( $shortcode ) ) {
		// Check for default shortcodes if $shortcode is empty
		$has_shortcode = (
			is_a( $post, 'WP_Post' ) &&
			(
				has_shortcode( $post->post_content, 'activity-listing' ) ||
				has_shortcode( $post->post_content, 'members-listing' ) ||
				has_shortcode( $post->post_content, 'groups-listing' )
			)
		);
	} else {
		// Check for the specified shortcode
		$has_shortcode = (
			is_a( $post, 'WP_Post' ) &&
			has_shortcode( $post->post_content, $shortcode )
		);
	}

	// Check for Elementor widgets if Elementor is active
	if ( ( defined( 'ELEMENTOR_PRO_VERSION' ) || defined( 'ELEMENTOR_VERSION' ) ) && ! empty( $post ) ) {
		$elementor_data         = get_post_meta( $post->ID, '_elementor_data', true );
		$elementor_data_decoded = json_decode( $elementor_data, true );

		if ( ! empty( $elementor_data_decoded ) ) {
			$widget_type = '';

			switch ( $shortcode ) {
				case 'activity-listing':
					$widget_type = 'buddypress_shortcode_activity_widget';
					break;
				case 'members-listing':
					$widget_type = 'buddypress_shortcode_members_widget';
					break;
				case 'groups-listing':
					$widget_type = 'buddypress_shortcode_groups_widget';
					break;
				default:
					$widget_type = apply_filters( 'buddypress_shortcode_elementor_widget_type', $shortcode );
			}

			$has_shortcode = bp_shortcode_is_elementor_widget( $elementor_data_decoded, $widget_type );
		}
	}

	return apply_filters( 'bp_shortcode_is_shortcode_page', $has_shortcode );
}