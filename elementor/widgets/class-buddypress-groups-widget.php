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

class Buddypress_Shortcode_Groups_Widget extends Widget_Base {

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
		return 'buddypress_shortcode_groups_widget';
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
		return __( 'Groups List', 'shortcodes-for-buddypress' );
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
		return 'eicon-user-circle-o';
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
	 * Get the group types to display as options in widget
	 *
	 * @return void
	 */
	protected function get_group_types() {
		$group_types = array();
		if ( function_exists( 'bp_groups_get_group_types' ) ) {
			$get_group_types = bp_groups_get_group_types( array(), 'objects' );
			$group_types     = array();
			foreach ( $get_group_types as $key => $value ) {
				$group_types[ $key ] = $value->labels['singular_name'];
			}
		}
		return $group_types;
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
				'label'       => __( 'Display Number of Groups', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 20,
				'description' => __( 'How many groups to display per page.', 'shortcodes-for-buddypress' ),
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
							__( 'Power up your listing with custom queries and templates.', 'shortcodes-for-buddypress' ),
						),
						'link'     => 'https://wbcomdesigns.com/downloads/shortcodes-for-buddypress-pro',
					)
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'Listing Groups', 'shortcodes-for-buddypress' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'sfb_list_item_background',
				'label'    => __( 'Background', 'shortcodes-for-buddypress' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap',
			)
		);

		$this->start_controls_tabs( 'tabs_listing_style' );

		$this->start_controls_tab(
			'sfb_tab_listing_normal',
			array(
				'label' => __( 'Normal', 'shortcodes-for-buddypress' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'sfb_listing_box_shadow',
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sfb_tab_listing_hover',
			array(
				'label' => __( 'Hover', 'shortcodes-for-buddypress' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'sfb_listing_box_shadow_hover',
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'sfb_hr_listing',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'sfb_listing_border',
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap',
			)
		);

		$this->add_control(
			'sfb_listing_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} #groups-list > li > .list-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} #groups-list > li > .list-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),

			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'sfb_listing_border_one',
				'selector' => '{{WRAPPER}} #groups-list > li',

			)
		);

		$this->add_control(
			'sfb_listing_border_radius_one',
			array(
				'label'      => esc_html__( 'Border Radius', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} #groups-list > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),

			)
		);

		$this->add_responsive_control(
			'sfb_listing_padding_one',
			array(
				'label'      => __( 'Padding', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #groups-list > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$args = '';

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

		$args      = apply_filters( 'bp_shortcode_groups_element_args', trim( $args ) );
		$shortcode = '[groups-listing ' . $args . ']';
		echo do_shortcode( $shortcode );

	}


}
