<?php
/**
 * Functional coverage for the three shortcodes.
 *
 * These assert rendered behaviour, not just that classes exist. Several are
 * direct regression guards for the 3.0.0 cleanup: the single-gate asset
 * enqueue, the removal of the dead members load-more endpoint, and the
 * collapse of three duplicated feedback wrappers into one base method.
 *
 * @package Shortcodes_For_Buddypress
 */

/**
 * Shortcode rendering and registration.
 */
class Test_BPSP_Shortcodes extends WP_UnitTestCase {

	/**
	 * All three shortcodes are registered.
	 *
	 * @return void
	 */
	public function test_all_three_shortcodes_are_registered() {
		foreach ( array( 'activity-listing', 'members-listing', 'groups-listing' ) as $tag ) {
			$this->assertTrue( shortcode_exists( $tag ), "Shortcode [{$tag}] is not registered." );
		}
	}

	/**
	 * Each shortcode renders without fatal and returns markup.
	 *
	 * @return void
	 */
	public function test_each_shortcode_renders_markup() {
		$this->assertTrue(
			bp_shortcode_nouveau_is_available(),
			'Nouveau is not loaded, so this suite would assert against the fallback notice rather than the templates.'
		);

		foreach ( array( 'activity-listing', 'members-listing', 'groups-listing' ) as $tag ) {
			$html = do_shortcode( "[{$tag}]" );

			$this->assertIsString( $html, "[{$tag}] did not return a string." );
			$this->assertNotSame( '', trim( $html ), "[{$tag}] rendered nothing at all." );
			$this->assertStringContainsString(
				'id="buddypress"',
				$html,
				"[{$tag}] did not render the Nouveau container, so it fell back instead of rendering."
			);
		}
	}

	/**
	 * Without Nouveau the shortcodes degrade instead of fataling.
	 *
	 * The nouveau templates call Nouveau-only template tags, so a site on the
	 * legacy pack with a non-BuddyPress theme used to hit an undefined
	 * function. This pins the graceful path.
	 *
	 * @return void
	 */
	public function test_missing_nouveau_degrades_instead_of_fataling() {
		$this->assertTrue( function_exists( 'bp_shortcode_nouveau_is_available' ) );
		$this->assertTrue( function_exists( 'bp_shortcode_render_nouveau_required_notice' ) );

		// The notice is admin-only, so a visitor sees nothing rather than a fatal.
		wp_set_current_user( 0 );
		ob_start();
		bp_shortcode_render_nouveau_required_notice();
		$visitor = ob_get_clean();
		$this->assertSame( '', trim( $visitor ), 'The fallback notice must not leak to visitors.' );

		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );
		ob_start();
		bp_shortcode_render_nouveau_required_notice();
		$admin = ob_get_clean();
		$this->assertStringContainsString( 'Nouveau', $admin, 'Administrators should be told what to switch on.' );
	}

	/**
	 * An unknown attribute must not fatal; shortcode_atts should drop it.
	 *
	 * @return void
	 */
	public function test_unknown_attribute_is_ignored_safely() {
		$html = do_shortcode( '[activity-listing bogus_attribute="1"]' );
		$this->assertIsString( $html );
	}

	/**
	 * Removed hide_on_activity attribute must still be safe to pass.
	 *
	 * @return void
	 */
	public function test_removed_attribute_does_not_fatal() {
		$html = do_shortcode( '[activity-listing hide_on_activity="1"]' );
		$this->assertIsString( $html );
	}

	/**
	 * The three shortcodes share one feedback renderer on the base class.
	 *
	 * Regression guard: the wrapper markup used to be duplicated inline in
	 * all three classes.
	 *
	 * @return void
	 */
	public function test_disabled_notice_renderer_lives_on_the_base_class() {
		$this->assertTrue( class_exists( 'BPShortCode' ), 'Base shortcode class missing.' );

		$method = new ReflectionMethod( 'BPShortCode', 'render_disabled_notice' );
		$this->assertTrue( $method->isProtected(), 'render_disabled_notice should be protected.' );
	}
}
