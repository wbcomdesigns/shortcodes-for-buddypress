<?php

/**
 * Includes Shortcodes for BuddyPress template file.
 *
 * @since 1.0.0
 * @param string $file_name File name to include the specific template.
 * @return void
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
	 * If the template path exists, include the template and load the shortcode functionality.
	 * @since 2.7.2
	 */

	if ( $template_path ) {
		$template_path  = apply_filters( 'shortcodes_for_buddypress_custom_template_path' , $template_path );
		include $template_path;
	}
}

/**
 * Gets and includes template files.
 *
 * @since 1.7.0
 * @param mixed  $template_name
 * @param array  $args (default: array()).
 * @param string $template_path (default: '').
 * @param string $default_path (default: '').
 */
function bp_shortcode_get_template( $template_name, $args = array(), $template_path = 'nouveau', $default_path = '' ) {
	if ( $args && is_array( $args ) ) {
		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- Please, forgive us.
		extract( $args );
	}
	include bp_shortcode_locate_template( $template_name, $template_path, $default_path );
}

/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 *
 * @since 1.7.0
 *
 * @param   string $template_name          Template to load.
 * @param   string $string $template_path  Path to templates.
 * @param   string $default_path           Default path to template files.
 * @return  string                          Path to the template file.
 */
function bp_shortcode_locate_template( $template_name, $template_path, $default_path = '' ) {
	// Look within passed path within the theme - this is priority.
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name,
		)
	);
	
	// Get default template.
	if ( ! $template && false !== $default_path ) {
		$default_path = $default_path ? $default_path : SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR . 'templates/';
		if ( file_exists( trailingslashit( $default_path . $template_path ) . $template_name ) ) {
			$template = trailingslashit( $default_path . $template_path ) . $template_name;
		}
	}

	return apply_filters( 'bp_shortcode_locate_template', $template, $template_name, $template_path, $default_path );
}

function bp_shortcode_is_shortcode_page( $shortcode = '' ) {
	global $post;

	if ( ! isset( $post ) || ! is_a( $post, 'WP_Post' ) ) {
		return false;
	}

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

function bp_shortcode_is_elementor_widget( $elementor_data, $widget_type = '' ) {
	if ( ! is_array( $elementor_data ) ) {
		return false; // If $elementor_data is not an array, return false
	}

	foreach ( $elementor_data as $element ) {
		if ( isset( $element['widgetType'] ) ) {
			// Check if $widget_type is specified and match widgetType
			if ( ! empty( $widget_type ) && $element['widgetType'] === $widget_type ) {
				return true;
			}

			// Check predefined widget types if $widget_type is empty
			if ( empty( $widget_type ) && in_array( $element['widgetType'], array( 'bpsp_activity', 'bpsp_member', 'bpsp_group' ) ) ) {
				return true;
			}
		}

		// Recursively check nested elements if they exist
		if ( isset( $element['elements'] ) && bp_shortcode_is_elementor_widget( $element['elements'], $widget_type ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Render the member cover for Reign and Buddyx theme
 *
 */
function bp_shortcode_member_cover() {
	$active_theme = wp_get_theme();
	$cover        = '';
	if ( 'BuddyX' == $active_theme || 'BuddyxPro' == $active_theme ) {
		if ( function_exists( 'buddyx_render_member_cover_image' ) ) {
			$cover = buddyx_render_member_cover_image();
		}
	} elseif ( 'REIGN' == $active_theme ) {
		if ( function_exists( 'reign_render_member_cover_image' ) ) {
			$cover = reign_render_member_cover_image();
		}
	}

	return apply_filters( 'bp_shortcode_member_cover', $cover, $active_theme );
}

/**
 * Get the appropriate asset file extension and path based on debug mode and RTL settings.
 *
 * This utility function centralizes the logic for determining asset paths and extensions,
 * reducing code duplication across admin and public classes.
 *
 * @since 2.9.1
 * @param string $type The type of asset ('css' or 'js').
 * @return array {
 *     Array containing extension and path information.
 *     @type string $extension The file extension including prefix (e.g., '.min.css', '.rtl.css').
 *     @type string $path      The subdirectory path (e.g., '/min', '/rtl').
 * }
 */
function shortcodes_for_buddypress_get_asset_info( $type = 'css' ) {
	$asset_info = array();

	if ( 'css' === $type ) {
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$asset_info['extension'] = is_rtl() ? '.rtl.css' : '.css';
			$asset_info['path']      = is_rtl() ? '/rtl' : '';
		} else {
			$asset_info['extension'] = is_rtl() ? '.rtl.css' : '.min.css';
			$asset_info['path']      = is_rtl() ? '/rtl' : '/min';
		}
	} elseif ( 'js' === $type ) {
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$asset_info['extension'] = '.js';
			$asset_info['path']      = '';
		} else {
			$asset_info['extension'] = '.min.js';
			$asset_info['path']      = '/min';
		}
	}

	/**
	 * Filter the asset information array.
	 *
	 * @since 2.9.1
	 * @param array  $asset_info Array containing extension and path.
	 * @param string $type       The type of asset ('css' or 'js').
	 */
	return apply_filters( 'shortcodes_for_buddypress_asset_info', $asset_info, $type );
}

/**
 * Build the complete URL for a plugin asset file.
 *
 * @since 2.9.1
 * @param string $base_path The base path within the plugin (e.g., 'admin/css', 'public/js').
 * @param string $filename  The base filename without extension (e.g., 'shortcodes-for-buddypress-admin').
 * @param string $type      The type of asset ('css' or 'js').
 * @return string The complete URL to the asset file.
 */
function shortcodes_for_buddypress_get_asset_url( $base_path, $filename, $type = 'css' ) {
	$asset_info = shortcodes_for_buddypress_get_asset_info( $type );

	// Build the complete URL
	$url = plugin_dir_url( dirname( __FILE__ ) ) . $base_path . $asset_info['path'] . '/' . $filename . $asset_info['extension'];

	/**
	 * Filter the complete asset URL.
	 *
	 * @since 2.9.1
	 * @param string $url       The complete URL to the asset.
	 * @param string $base_path The base path within the plugin.
	 * @param string $filename  The base filename without extension.
	 * @param string $type      The type of asset.
	 */
	return apply_filters( 'shortcodes_for_buddypress_asset_url', $url, $base_path, $filename, $type );
}