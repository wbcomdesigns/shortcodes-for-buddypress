<?php

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
 * Get asset URL for CSS or JS files
 *
 * Simplified function that handles debug mode, minification, and RTL
 *
 * @param string $path     Path relative to plugin root (e.g., 'admin/css')
 * @param string $filename Base filename without extension
 * @param string $type     Asset type: 'css' or 'js'
 * @return string Complete URL to the asset
 */
function bp_shortcode_asset( $path, $filename, $type = 'css' ) {
	$debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

	// Simple logic for file extension and path
	if ( 'css' === $type ) {
		$suffix = $debug ? '' : '.min';
		$rtl = is_rtl() ? '.rtl' : '';
		$file = $filename . $rtl . $suffix . '.css';

		// For RTL, check if file exists in rtl subfolder
		if ( is_rtl() && ! $debug ) {
			$full_path = $path . '/rtl/' . $filename . $suffix . '.css';
		} else {
			$full_path = $path . '/' . $file;
		}
	} else {
		$suffix = $debug ? '' : '.min';
		$full_path = $path . '/' . $filename . $suffix . '.js';
	}

	return plugin_dir_url( dirname( __FILE__ ) ) . $full_path;
}

/**
 * Enqueue a plugin asset (CSS or JS)
 *
 * Wrapper function to simplify asset enqueuing
 *
 * @param string $handle   Unique handle for the asset
 * @param string $path     Path relative to plugin root
 * @param string $filename Base filename without extension
 * @param string $type     Asset type: 'css' or 'js'
 * @param array  $deps     Dependencies
 * @param string $version  Version number
 * @return void
 */
function bp_shortcode_enqueue( $handle, $path, $filename, $type = 'css', $deps = array(), $version = SHORTCODES_FOR_BUDDYPRESS_VERSION ) {
	$url = bp_shortcode_asset( $path, $filename, $type );

	if ( 'css' === $type ) {
		wp_enqueue_style( $handle, $url, $deps, $version );
	} else {
		wp_enqueue_script( $handle, $url, $deps, $version, true );
	}
}