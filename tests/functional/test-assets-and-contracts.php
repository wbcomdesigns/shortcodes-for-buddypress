<?php
/**
 * Functional coverage for asset loading and the public contracts.
 *
 * The load-more bug that started the 3.0.0 cleanup was caused by register,
 * enqueue and localize sitting behind three different conditions, so a page
 * could load the script without ever receiving buddypress_shortcode. These
 * tests pin that down so it cannot regress silently.
 *
 * @package Shortcodes_For_Buddypress
 */

/**
 * Asset enqueue, AJAX surface and Free/Pro contract.
 */
class Test_BPSP_Assets_And_Contracts extends WP_UnitTestCase {

	/**
	 * Put a post carrying the given content into the global $post.
	 *
	 * @param string $content Post content.
	 * @return void
	 */
	private function go_to_post_with( $content ) {
		$post_id = self::factory()->post->create(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_content' => $content,
			)
		);
		$this->go_to( get_permalink( $post_id ) );
		$GLOBALS['post'] = get_post( $post_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		setup_postdata( $GLOBALS['post'] );
	}

	/**
	 * Run the plugin's wp_enqueue_scripts callback.
	 *
	 * @return void
	 */
	private function run_enqueue() {
		$public = new Shortcodes_For_Buddypress_Public( 'shortcodes-for-buddypress', SHORTCODES_FOR_BUDDYPRESS_VERSION );
		$public->enqueue_scripts();
	}

	/**
	 * Every shortcode page gets the script, not just activity-listing.
	 *
	 * @return void
	 */
	public function test_script_is_enqueued_for_every_shortcode() {
		foreach ( array( 'activity-listing', 'members-listing', 'groups-listing' ) as $tag ) {
			wp_dequeue_script( 'shortcodes-for-buddypress' );
			wp_deregister_script( 'shortcodes-for-buddypress' );

			$this->go_to_post_with( "[{$tag}]" );
			$this->run_enqueue();

			$this->assertTrue(
				wp_script_is( 'shortcodes-for-buddypress', 'enqueued' ),
				"Plugin JS was not enqueued on a page containing only [{$tag}]."
			);
		}
	}

	/**
	 * Wherever the script loads, the localized object must exist too.
	 *
	 * @return void
	 */
	public function test_localized_object_accompanies_the_script() {
		$this->go_to_post_with( '[members-listing]' );
		$this->run_enqueue();

		$data = wp_scripts()->get_data( 'shortcodes-for-buddypress', 'data' );

		$this->assertNotEmpty( $data, 'buddypress_shortcode was never localized.' );
		$this->assertStringContainsString( 'ajax_url', (string) $data );
		$this->assertStringContainsString( 'ajax_nonce', (string) $data );
	}

	/**
	 * A page with no shortcode must not load the script.
	 *
	 * @return void
	 */
	public function test_script_is_not_enqueued_without_a_shortcode() {
		wp_dequeue_script( 'shortcodes-for-buddypress' );
		wp_deregister_script( 'shortcodes-for-buddypress' );

		$this->go_to_post_with( 'Just some ordinary prose.' );
		$this->run_enqueue();

		$this->assertFalse(
			wp_script_is( 'shortcodes-for-buddypress', 'enqueued' ),
			'Plugin JS loaded on a page with no shortcode.'
		);
	}

	/**
	 * The live AJAX action is registered.
	 *
	 * @return void
	 */
	public function test_activity_load_ajax_action_is_registered() {
		$this->assertTrue( has_action( 'wp_ajax_bpsp_activities_load' ) !== false );
		$this->assertTrue( has_action( 'wp_ajax_nopriv_bpsp_activities_load' ) !== false );
	}

	/**
	 * The dead members load-more endpoint must stay gone.
	 *
	 * Nothing rendered its button, so it was removed in 3.0.0. If it comes
	 * back, either the button was added (update this test) or dead code was
	 * reintroduced.
	 *
	 * @return void
	 */
	public function test_dead_members_load_more_endpoint_is_absent() {
		$this->assertFalse(
			has_action( 'wp_ajax_bpsh_load_more_members' ),
			'bpsh_load_more_members is registered again but no template renders its button.'
		);
	}

	/**
	 * Only the nouveau template pack ships.
	 *
	 * @return void
	 */
	public function test_only_the_nouveau_template_pack_exists() {
		$templates = SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR . 'templates/';

		$this->assertDirectoryExists( $templates . 'nouveau' );
		$this->assertDirectoryDoesNotExist( $templates . 'legacy' );
		$this->assertDirectoryDoesNotExist( $templates . 'youzify' );
	}

	/**
	 * Template resolution ignores _bp_theme_package_id and lands on nouveau.
	 *
	 * @return void
	 */
	public function test_templates_resolve_to_nouveau_on_any_pack() {
		update_option( '_bp_theme_package_id', 'legacy' );

		$located = bp_shortcode_locate_template( 'activity/bp-shortcodes-activity.php', 'nouveau' );

		$this->assertStringContainsString( 'templates/nouveau/', $located );
		$this->assertFileExists( $located );

		update_option( '_bp_theme_package_id', 'nouveau' );
	}

	/**
	 * The Free/Pro filter seam must keep existing.
	 *
	 * @return void
	 */
	public function test_pro_contract_filters_are_still_applied() {
		$fired = array();
		foreach ( array( 'activity_shortcode_template_args', 'member_shortcode_output', 'group_shortcode_output' ) as $hook ) {
			add_filter(
				$hook,
				static function ( $value ) use ( $hook, &$fired ) {
					$fired[ $hook ] = true;
					return $value;
				}
			);
		}

		do_shortcode( '[activity-listing]' );
		do_shortcode( '[members-listing]' );
		do_shortcode( '[groups-listing]' );

		foreach ( array( 'activity_shortcode_template_args', 'member_shortcode_output', 'group_shortcode_output' ) as $hook ) {
			$this->assertArrayHasKey( $hook, $fired, "Pro contract filter {$hook} no longer fires." );
		}
	}

	/**
	 * Asset helper prefers the built file and never returns a missing path.
	 *
	 * @return void
	 */
	public function test_asset_helper_prefers_the_minified_build() {
		$url = bp_shortcode_asset( 'public/js', 'shortcodes-for-buddypress-public', 'js' );

		$this->assertStringContainsString( 'shortcodes-for-buddypress-public', $url );

		$relative = str_replace( SHORTCODES_FOR_BUDDYPRESS_PLUGIN_URL, '', $url );
		$this->assertFileExists( SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR . $relative, 'Asset helper returned a path that does not exist.' );
	}
}
