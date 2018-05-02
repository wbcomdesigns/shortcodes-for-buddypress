<?php
/**
 *
 * This template file is used for fetching desired options page file at admin settings.
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_GET['tab'] ) ) {
	$short_tab = sanitize_text_field( $_GET['tab'] );
} else {
	$short_tab = 'groups';
}

bpshort_include_setting_tabs( $short_tab );

/**
 *
 * Function to select desired file for tab option.
 *
 * @param string $wbbprof_tab The current tab string.
 */
function bpshort_include_setting_tabs( $short_tab ) {

	switch ( $short_tab ) {
		case 'groups':
			include 'bp-short-groups-setting-tab.php';
			break;
		case 'activity':
			include 'bp-short-activity-setting-tab.php';
			break;
		case 'members':
			include 'bp-short-members-setting-tab.php';
			break;
		default:
			include 'bp-short-groups-setting-tab.php';
			break;
	}

}

