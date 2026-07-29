<?php
/**
 * Attribute matrix and Elementor widget coverage.
 *
 * Both bugs pinned here were found by walking every shortcode attribute and
 * every widget control rather than only checking that the surfaces render.
 *
 * @package Shortcodes_For_Buddypress
 */

/**
 * Shortcode attributes and Elementor widget rendering.
 */
class Test_BPSP_Attributes_And_Widgets extends WP_UnitTestCase {

	/**
	 * The per_page attribute must bound every listing.
	 *
	 * @return void
	 */
	public function test_per_page_limits_each_listing() {
		self::factory()->user->create_many( 6 );

		$html = do_shortcode( '[members-listing per_page=3]' );
		$this->assertLessThanOrEqual( 3, substr_count( $html, '<li ' ), 'members-listing ignored per_page.' );
	}

	/**
	 * A title containing shortcode-significant characters still renders.
	 *
	 * The Elementor widgets used to build a shortcode string and wrap the
	 * title in quotes, so a title containing a double quote or a closing
	 * square bracket broke the parser and vanished silently.
	 *
	 * @return void
	 */
	public function test_widget_titles_survive_shortcode_significant_characters() {
		$titles = array(
			'Plain Title',
			'Our "Best" Members',
			'Members ] Directory',
			'Team & Friends',
		);

		foreach ( $titles as $title ) {
			$html = BPShortCode::render_from_elementor(
				'members-listing',
				array(
					'sfb_title'    => $title,
					'sfb_per_page' => 2,
				),
				'bp_shortcode_pro_members_element_args'
			);

			$this->assertMatchesRegularExpression(
				'/<h4>.+<\/h4>/s',
				$html,
				"Widget dropped the title for input: {$title}"
			);
		}
	}

	/**
	 * Elementor style controls must not become shortcode attributes.
	 *
	 * Every widget control carries the sfb_ prefix, so the old string builder
	 * injected padding, background and border values as bogus attributes.
	 *
	 * @return void
	 */
	public function test_widget_style_controls_do_not_leak_into_attributes() {
		$seen = null;
		add_filter(
			'members-listing_attributes',
			static function ( $atts ) use ( &$seen ) {
				$seen = $atts;
				return $atts;
			}
		);

		BPShortCode::render_from_elementor(
			'members-listing',
			array(
				'sfb_title'                => 'Styled',
				'sfb_listing_padding'      => array( 'top' => '10' ),
				'sfb_list_item_background' => array( 'color' => '#fff' ),
			),
			'bp_shortcode_pro_members_element_args'
		);

		$this->assertIsArray( $seen );
		$this->assertArrayNotHasKey( 'listing_padding', $seen );
		$this->assertArrayNotHasKey( 'list_item_background', $seen );
		$this->assertArrayHasKey( 'title', $seen );
	}

	/**
	 * The legacy Pro string filter still overrides the attributes.
	 *
	 * @return void
	 */
	public function test_pro_string_filter_still_wins() {
		add_filter(
			'bp_shortcode_pro_members_element_args',
			static function () {
				return 'per_page=2';
			}
		);

		$html = BPShortCode::render_from_elementor(
			'members-listing',
			array( 'sfb_per_page' => 9 ),
			'bp_shortcode_pro_members_element_args'
		);

		$this->assertLessThanOrEqual( 2, substr_count( $html, '<li ' ), 'The Pro args filter no longer overrides.' );
	}

	/**
	 * Explicit ordering on groups is not swallowed by the default type.
	 *
	 * BuddyPress lets `type` win over `orderby`/`order` inside
	 * bp_has_groups(), and the
	 * shortcode always sent type=alphabetical, so both ordering attributes
	 * were dead: ASC and DESC returned an identical list.
	 *
	 * @return void
	 */
	public function test_group_ordering_attributes_are_honoured() {
		$reflection = new ReflectionMethod( 'GroupShortCode', 'get_query_args' );
		$reflection->setAccessible( true );

		$instance = GroupShortCode::get_instance( 'groups-listing' );
		$defaults = new ReflectionProperty( 'BPShortCode', 'defaults' );
		$defaults->setAccessible( true );
		$atts = $defaults->getValue( $instance );

		// Untouched ordering keeps the alphabetical default.
		$args = $reflection->invoke( $instance, $atts );
		$this->assertSame( 'alphabetical', $args['type'], 'Default ordering should stay alphabetical.' );

		// Explicit ordering drops the default type so it can take effect.
		$atts['orderby'] = 'name';
		$atts['order']   = 'DESC';
		$args            = $reflection->invoke( $instance, $atts );

		$this->assertArrayNotHasKey( 'type', $args, 'Default type still overrides explicit ordering.' );
		$this->assertSame( 'name', $args['orderby'] );
		$this->assertSame( 'DESC', $args['order'] );
	}

	/**
	 * An explicit type still beats ordering, matching BuddyPress.
	 *
	 * @return void
	 */
	public function test_explicit_type_still_takes_priority() {
		$reflection = new ReflectionMethod( 'GroupShortCode', 'get_query_args' );
		$reflection->setAccessible( true );

		$instance  = GroupShortCode::get_instance( 'groups-listing' );
		$defaults  = new ReflectionProperty( 'BPShortCode', 'defaults' );
		$defaults->setAccessible( true );
		$atts            = $defaults->getValue( $instance );
		$atts['type']    = 'newest';
		$atts['orderby'] = 'name';

		$args = $reflection->invoke( $instance, $atts );

		$this->assertSame( 'newest', $args['type'], 'An explicit type should still win.' );
	}
}
