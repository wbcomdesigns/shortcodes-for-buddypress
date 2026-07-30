<?php
/**
 * PHPUnit bootstrap.
 *
 * Loads the WordPress test library, then BuddyPress, then this plugin.
 * BuddyPress must load first because the shortcode classes register
 * themselves at include time and guard on bp_is_active().
 *
 * @package Shortcodes_For_Buddypress
 */

$bpsp_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $bpsp_tests_dir ) {
	$bpsp_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $bpsp_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find {$bpsp_tests_dir}/includes/functions.php. Run bin/install-wp-tests.sh first." . PHP_EOL; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit( 1 );
}

if ( getenv( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH' ) === false ) {
	$bpsp_polyfills = dirname( __DIR__ ) . '/vendor/yoast/phpunit-polyfills';
	if ( is_dir( $bpsp_polyfills ) ) {
		define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', $bpsp_polyfills );
	}
}

require_once $bpsp_tests_dir . '/includes/functions.php';

/**
 * Load BuddyPress (if available) and then this plugin.
 *
 * @return void
 */
function bpsp_manually_load_plugin() {
	$bp_loader = dirname( __DIR__, 2 ) . '/buddypress/bp-loader.php';
	if ( file_exists( $bp_loader ) ) {
		// Activate every component the shortcodes depend on.
		add_filter(
			'bp_active_components',
			static function ( $components ) {
				foreach ( array( 'activity', 'members', 'groups', 'xprofile' ) as $component ) {
					$components[ $component ] = 1;
				}
				return $components;
			}
		);
		require $bp_loader;

		/*
		 * Load the Nouveau template pack explicitly.
		 *
		 * BuddyPress only loads a pack for a real front-end request, so
		 * without this the shortcodes would fall through to the
		 * "Nouveau required" notice and the suite would assert against a
		 * 66-character string instead of the real templates. Instantiating
		 * BP_Nouveau is safe here because there is no live site to affect.
		 */
		add_action(
			'bp_init',
			static function () {
				if ( function_exists( 'bp_nouveau' ) ) {
					return;
				}
				$nouveau = buddypress()->themes_dir . '/bp-nouveau/buddypress-functions.php';
				if ( file_exists( $nouveau ) ) {
					require_once $nouveau;
				}
			},
			1
		);
	}

	require dirname( __DIR__ ) . '/shortcodes-for-buddypress.php';
}
tests_add_filter( 'muplugins_loaded', 'bpsp_manually_load_plugin' );

require $bpsp_tests_dir . '/includes/bootstrap.php';
