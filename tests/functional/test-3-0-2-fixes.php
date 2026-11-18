<?php
/**
 * Regression tests for the 3.0.2 attribute fixes.
 *
 * @package Shortcodes_For_Buddypress
 */

/**
 * Each test fails on the 3.0.1 code.
 */
class Test_BPSP_3_0_2_Fixes extends WP_UnitTestCase {

	/**
	 * A role nobody holds lists no members (3.0.1 listed everyone).
	 *
	 * @return void
	 */
	public function test_empty_role_lists_no_members() {
		self::factory()->user->create( array( 'role' => 'subscriber' ) );
		$html = do_shortcode( '[members-listing include_member_role="candidate"]' );
		$this->assertStringNotContainsString( 'members-list', str_replace( 'members-listing', '', $html ) );
	}

	/**
	 * The query arguments the groups shortcode sends to BuddyPress.
	 *
	 * The suite has no BuddyPress group tables, so the arguments are captured
	 * from the filter instead of reading rendered rows.
	 *
	 * @param string $atts Shortcode attributes.
	 * @return array
	 */
	private function groups_query_for( $atts ) {
		$captured = array();
		$capture  = function ( $args ) use ( &$captured ) {
			$captured = $args;
			return $args;
		};
		add_filter( 'group_shortcode_bash_query_args', $capture );
		ob_start();
		do_shortcode( "[groups-listing {$atts}]" );
		ob_end_clean();
		remove_filter( 'group_shortcode_bash_query_args', $capture );
		return $captured;
	}

	/**
	 * Hidden groups are not requested for visitors, even when the page asks for them.
	 *
	 * @return void
	 */
	public function test_hidden_groups_are_not_requested_for_visitors() {
		wp_set_current_user( 0 );
		$args = $this->groups_query_for( 'show_hidden="1" status="hidden"' );
		$this->assertArrayNotHasKey( 'show_hidden', $args );
		$this->assertArrayNotHasKey( 'status', $args );
		$this->assertSame( (string) PHP_INT_MAX, $args['include'] );
	}

	/**
	 * Site administrators keep the hidden-group options.
	 *
	 * @return void
	 */
	public function test_administrators_keep_hidden_group_options() {
		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );
		$args = $this->groups_query_for( 'show_hidden="1" status="hidden"' );
		$this->assertTrue( ! empty( $args['show_hidden'] ) );
		$this->assertSame( 'hidden', $args['status'] );
	}

	/**
	 * A search containing an ampersand reaches BuddyPress whole.
	 *
	 * @return void
	 */
	public function test_ampersand_search_is_encoded() {
		$args = $this->groups_query_for( 'search_terms="R&D"' );
		$this->assertSame( 'R&D', $args['search_terms'] );
		$captured = '';
		$capture  = function ( $args ) use ( &$captured ) {
			$captured = $args['query'];
			return $args;
		};
		add_filter( 'group_shortcode_template_args', $capture );
		ob_start();
		do_shortcode( '[groups-listing search_terms="R&D"]' );
		ob_end_clean();
		remove_filter( 'group_shortcode_template_args', $capture );
		$this->assertStringContainsString( 'search_terms=R%26D', $captured );
	}

	/**
	 * The container_class attribute reaches the activity wrapper.
	 *
	 * @return void
	 */
	public function test_activity_container_class_is_applied() {
		$this->assertStringContainsString( 'activity-listing my-cls', do_shortcode( '[activity-listing container_class="my-cls"]' ) );
	}

	/**
	 * The component notice is for administrators only.
	 *
	 * @return void
	 */
	public function test_component_notice_is_admin_only() {
		add_filter(
			'bp_is_active',
			function ( $active, $component = '' ) {
				return 'groups' === $component ? false : $active;
			},
			99,
			2
		);
		wp_set_current_user( 0 );
		$this->assertSame( '', trim( do_shortcode( '[groups-listing]' ) ) );
		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );
		$this->assertStringContainsString( 'enable the group component', do_shortcode( '[groups-listing]' ) );
	}
}
