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