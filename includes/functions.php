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

		// check and include file from the stylesheet directory.
		include get_stylesheet_directory() . '/' . $template_name;

	} elseif ( file_exists( get_template_directory() . '/' . $template_name ) ) {

		// check and include file from the template directory.
		include get_template_directory() . '/' . $template_name;

	} else {
		// if file not exists in both stylesheet and template directories then include it from the templates in the plugin directory.
		if ( file_exists( SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR . 'templates/' . $file_name ) ){
			include SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR . 'templates/' . $file_name ;
		} else {
			return false;
		}
	}
}