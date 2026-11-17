<?php
/**
 * Reign layout attribute tests.
 *
 * @package Shortcodes_For_Buddypress
 */

/**
 * On Reign the grid and loop_layout attributes must win over the site layout.
 */
class Test_BPSP_Reign_Layout extends WP_UnitTestCase {

	/**
	 * Classes handed to the template, keyed by listing.
	 *
	 * @var array
	 */
	private $seen = array();

	/**
	 * Switch to a stub theme named REIGN and capture the list classes.
	 *
	 * @return void
	 */
	public function set_up() {
		parent::set_up();

		$dir = get_temp_dir() . 'bpsp-test-themes';
		wp_mkdir_p( $dir . '/reign-theme' );
		file_put_contents( $dir . '/reign-theme/style.css', "/*\nTheme Name: REIGN\n*/\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		file_put_contents( $dir . '/reign-theme/index.php', "<?php\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		register_theme_directory( $dir );
		search_theme_directories( true );
		switch_theme( 'reign-theme' );

		update_option(
			'bp_nouveau_appearance',
			array(
				'members_layout' => 4,
				'groups_layout'  => 4,
			)
		);

		$this->seen = array();
		foreach ( array( 'member', 'group' ) as $type ) {
			add_filter(
				$type . '_shortcode_template_args',
				function ( $args ) use ( $type ) {
					$this->seen[ $type ] = explode( ' ', $args['classes'] );
					return $args;
				}
			);
		}
	}

	/**
	 * Render a listing and return the captured list classes.
	 *
	 * @param string $shortcode Shortcode markup.
	 * @param string $type      member or group.
	 * @return string[]
	 */
	private function classes_for( $shortcode, $type ) {
		do_shortcode( $shortcode );
		$this->assertArrayHasKey( $type, $this->seen, 'The listing did not build its classes.' );
		return $this->seen[ $type ];
	}

	/**
	 * Reign is detected and keeps its card classes.
	 *
	 * @return void
	 */
	public function test_reign_card_classes_are_kept() {
		$this->assertSame( 'REIGN', wp_get_theme()->get( 'Name' ) );
		$this->assertContains( 'rg-member-list', $this->classes_for( '[members-listing]', 'member' ) );
		$this->assertContains( 'rg-group-list', $this->classes_for( '[groups-listing]', 'group' ) );
	}

	/**
	 * Grid="no" renders a list on Reign.
	 *
	 * @return void
	 */
	public function test_grid_no_is_honoured() {
		foreach ( array(
			'members' => 'member',
			'groups'  => 'group',
		) as $tag => $type ) {
			$classes = $this->classes_for( '[' . $tag . '-listing grid="no"]', $type );
			$this->assertNotContains( 'grid', $classes, "$tag grid=no still renders a grid on Reign." );
			$this->assertNotContains( 'four', $classes );
		}
	}

	/**
	 * An explicit loop_layout beats the site layout on Reign.
	 *
	 * @return void
	 */
	public function test_loop_layout_is_honoured() {
		foreach ( array(
			'members' => 'member',
			'groups'  => 'group',
		) as $tag => $type ) {
			$classes = $this->classes_for( '[' . $tag . '-listing grid="yes" loop_layout="two"]', $type );
			$this->assertContains( 'two', $classes, "$tag loop_layout ignored on Reign." );
			$this->assertNotContains( 'four', $classes );
		}
	}

	/**
	 * Without loop_layout, Reign follows the site directory layout, including via Elementor.
	 *
	 * @return void
	 */
	public function test_elementor_without_layout_follows_site_layout() {
		BPShortCode::render_from_elementor( 'members-listing', array( 'sfb_per_page' => 2 ), 'bp_shortcode_pro_members_element_args' );
		$this->assertContains( 'grid', $this->seen['member'] );
		$this->assertContains( 'four', $this->seen['member'] );

		BPShortCode::render_from_elementor( 'groups-listing', array( 'sfb_grid' => 'no' ), 'bp_shortcode_pro_groups_element_args' );
		$this->assertNotContains( 'grid', $this->seen['group'], 'Elementor grid=no ignored on Reign.' );
	}
}
