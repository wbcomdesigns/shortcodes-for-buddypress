<?php

namespace BPSPElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

class Members extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.6.1
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'bpsp_member';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.6.1
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Members List', 'shortcodes-for-buddypress' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.6.1
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-person';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.6.1
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'buddypress-widgets' );
	}

	/**
	 * Get User roles to display as elementor options
	 *
	 * @return array
	 */
	private function get_user_roles() {
		global $wp_roles;

		$all_roles = $wp_roles->roles;
		foreach ( $all_roles as $key => $value ) {
			$user_roles[ $key ] = $value['name'];
		}
		return $user_roles;
	}

	/**
	 * Get buddypress member type to display as elementor options
	 *
	 * @return void
	 */
	private function get_member_types() {
		$member_types = array( '' => 'All' );
		if ( function_exists( 'bp_get_member_types' ) ) {
			$member_types += bp_get_member_types( array(), 'names' );
		}

		return $member_types;
	}

	/**
	 * Register Retina Logo controls.
	 *
	 * @since 1.6.1
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Query', 'shortcodes-for-buddypress' ),
			)
		);

		$this->add_control(
			'sfb_title',
			array(
				'label'       => __( 'Title', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Add activity title', 'shortcodes-for-buddypress' ),
			)
		);

		$this->add_control(
			'sfb_per_page',
			array(
				'label'       => __( 'Per Page', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 20,
				'description' => __( 'How many members display on page.', 'shortcodes-for-buddypress' ),
			)
		);

		$this->add_control(
			'go_sfb_pro_notice',
			array(
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => \Shortcodes_For_Buddypress_Public::sfb_go_pro_template(
					array(
						'title'    => __( 'Shortcodes for BuddyPress PRO', 'shortcodes-for-buddypress' ),
						'messages' => array(
							__( 'Power up up your listing with custom queries and templates.', 'shortcodes-for-buddypress' ),
						),
						'link'     => 'https://wbcomdesigns.com/downloads/shortcodes-for-buddypress-pro',
					)
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'sfb_section_style',
			array(
				'label' => __( 'Listing', 'shortcodes-for-buddypress' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'sfb_listing_no_border',
			array(
				'label'     => __( 'View', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::HIDDEN,
				'default'   => '1',
				'selectors' => array(
					'{{WRAPPER}} #members-list' => 'border: 0;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'sfb_list_item_background',
				'label'    => __( 'Background', 'shortcodes-for-buddypress' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} #members-list > li > .list-wrap',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'sfb_listing_box_shadow',
				'selector' => '{{WRAPPER}} #members-list > li > .list-wrap',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'sfb_listing_border',
				'selector' => '{{WRAPPER}} #members-list > li > .list-wrap',
			)
		);

		$this->add_control(
			'sfb_listing_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} #members-list > li > .list-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'sfb_listing_margin',
			array(
				'label'      => __( 'Margin', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #members-list > li > .list-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'sfb_listing_padding',
			array(
				'label'      => __( 'Padding', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #members-list > li > .list-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render Retina Image output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.6.1
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$args     = '';

		if ( isset( $settings['sfb_title'] ) && ! empty( $settings['sfb_title'] ) ) {
			$settings['sfb_title'] = '"' . $settings['sfb_title'] . '"';
		}

		foreach ( $settings as $setting_key => $setting ) {
			if ( false !== strpos( $setting_key, 'sfb_' ) ) {

				if ( is_array( $settings[ $setting_key ] ) && ! empty( $settings[ $setting_key ] ) ) {
					$key   = substr( $setting_key, 4 );
					$args .= $key . '=' . join( ',', $setting ) . ' ';
				} elseif ( ! empty( $settings[ $setting_key ] ) ) {
					$key   = substr( $setting_key, 4 );
					$args .= $key . '=' . $setting . ' ';
				}
			}
		}

		$args      = apply_filters( 'bp_shortcode_pro_members_element_args', trim( $args ) );
		$shortcode = '[members-listing ' . $args . ']';
		echo do_shortcode( $shortcode );

	}


}
