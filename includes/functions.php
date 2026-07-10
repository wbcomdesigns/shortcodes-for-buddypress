<?php
/**
 * Helper functions for the plugin.
 *
 * @since   1.7.0
 * @package Shortcodes_For_BuddyPress
 */

defined( 'ABSPATH' ) || exit;

/**
 * Gets and includes template files.
 *
 * @since 1.7.0
 * @param mixed  $template_name Template name.
 * @param array  $args          Arguments (default: array()).
 * @param string $template_path Template path (default: '').
 * @param string $default_path  Default path (default: '').
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
 * @param   string $template_name  Template to load.
 * @param   string $template_path Path to templates.
 * @param   string $default_path  Default path to template files.
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

/**
 * Check if the current page has a BuddyPress shortcode.
 *
 * @since 1.7.0
 * @param string $shortcode Optional. Shortcode to check for.
 * @return bool
 */
function bp_shortcode_is_shortcode_page( $shortcode = '' ) {
	global $post;

	if ( ! isset( $post ) || ! is_a( $post, 'WP_Post' ) ) {
		return false;
	}

	if ( empty( $shortcode ) ) {
		// Check for default shortcodes if $shortcode is empty.
		$has_shortcode = (
			is_a( $post, 'WP_Post' ) &&
			(
				has_shortcode( $post->post_content, 'activity-listing' ) ||
				has_shortcode( $post->post_content, 'members-listing' ) ||
				has_shortcode( $post->post_content, 'groups-listing' )
			)
		);
	} else {
		// Check for the specified shortcode.
		$has_shortcode = (
			is_a( $post, 'WP_Post' ) &&
			has_shortcode( $post->post_content, $shortcode )
		);
	}

	// Check for Elementor widgets if Elementor is active.
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

/**
 * Check if Elementor data contains a specific widget type.
 *
 * @since 1.7.0
 * @param array  $elementor_data Elementor data array.
 * @param string $widget_type    Widget type to check for.
 * @return bool
 */
function bp_shortcode_is_elementor_widget( $elementor_data, $widget_type = '' ) {
	if ( ! is_array( $elementor_data ) ) {
		return false; // If $elementor_data is not an array, return false.
	}

	foreach ( $elementor_data as $element ) {
		if ( isset( $element['widgetType'] ) ) {
			// Check if $widget_type is specified and match widgetType.
			if ( ! empty( $widget_type ) && $widget_type === $element['widgetType'] ) {
				return true;
			}

			// Check predefined widget types if $widget_type is empty.
			if ( empty( $widget_type ) && in_array( $element['widgetType'], array( 'bpsp_activity', 'bpsp_member', 'bpsp_group' ), true ) ) {
				return true;
			}
		}

		// Recursively check nested elements if they exist.
		if ( isset( $element['elements'] ) && bp_shortcode_is_elementor_widget( $element['elements'], $widget_type ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Render the member cover for Reign and Buddyx theme.
 *
 * @since 1.7.0
 * @return string
 */
function bp_shortcode_member_cover() {
	$active_theme = wp_get_theme()->get( 'Name' );
	$cover        = '';
	if ( 'BuddyX' === $active_theme || 'BuddyxPro' === $active_theme ) {
		if ( function_exists( 'buddyx_render_member_cover_image' ) ) {
			$cover = buddyx_render_member_cover_image();
		}
	} elseif ( 'REIGN' === $active_theme ) {
		if ( function_exists( 'reign_render_member_cover_image' ) ) {
			$cover = reign_render_member_cover_image();
		}
	}

	return apply_filters( 'bp_shortcode_member_cover', $cover, $active_theme );
}

/**
 * Get asset URL for CSS or JS files.
 *
 * Simplified function that handles debug mode, minification, and RTL.
 *
 * @since 1.7.0
 * @param string $path     Path relative to plugin root (e.g., 'admin/css').
 * @param string $filename Base filename without extension.
 * @param string $type     Asset type: 'css' or 'js'.
 * @return string Complete URL to the asset.
 */
function bp_shortcode_asset( $path, $filename, $type = 'css' ) {
	$debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
	$base  = plugin_dir_path( __DIR__ );
	$ext   = ( 'js' === $type ) ? 'js' : 'css';

	/*
	 * Build a preference list and return the first candidate that actually
	 * exists on disk. Minified builds live in a `min/` subfolder and the RTL
	 * stylesheet in a `rtl/` subfolder; the unminified source is the final
	 * fallback so a missing build never 404s.
	 */
	$candidates = array();
	if ( 'css' === $type && is_rtl() ) {
		$candidates[] = $path . '/rtl/' . $filename . '.rtl.' . $ext;
	}
	if ( ! $debug ) {
		$candidates[] = $path . '/min/' . $filename . '.min.' . $ext;
	}
	$candidates[] = $path . '/' . $filename . '.' . $ext;

	$full_path = end( $candidates );
	foreach ( $candidates as $rel ) {
		if ( file_exists( $base . $rel ) ) {
			$full_path = $rel;
			break;
		}
	}

	return plugin_dir_url( __DIR__ ) . $full_path;
}

/**
 * Enqueue a plugin asset (CSS or JS).
 *
 * Wrapper function to simplify asset enqueuing.
 *
 * @since 1.7.0
 * @param string $handle   Unique handle for the asset.
 * @param string $path     Path relative to plugin root.
 * @param string $filename Base filename without extension.
 * @param string $type     Asset type: 'css' or 'js'.
 * @param array  $deps     Dependencies.
 * @param string $version  Version number.
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
