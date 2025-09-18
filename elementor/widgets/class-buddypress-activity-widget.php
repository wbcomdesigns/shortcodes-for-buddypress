<?php
/**
 * BuddyPress Activity Elementor Widget
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Elementor/Widgets
 * @since      1.6.1
 */

namespace BPSPElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * BuddyPress Activity Elementor Widget Class.
 *
 * @since 1.6.1
 */
class Buddypress_Shortcode_Activity_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.6.1
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'buddypress_shortcode_activity_widget';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.6.1
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Activity List', 'shortcodes-for-buddypress' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.6.1
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-time-line';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.6.1
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'buddypress-widgets' );
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.6.1
	 * @return void
	 */
	protected function register_controls() {
		// Content Section - Query Options
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Query', 'shortcodes-for-buddypress' ),
			)
		);

		// Title control
		$this->add_control(
			'sfb_title',
			array(
				'label'       => __( 'Title', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Add activity title', 'shortcodes-for-buddypress' ),
			)
		);

		// Number of activities control
		$this->add_control(
			'sfb_per_page',
			array(
				'label'       => __( 'Display Number of Activities', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 20,
				'description' => __( 'How many activity items to display.', 'shortcodes-for-buddypress' ),
			)
		);

		// Pro version notice
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

		// Style Section - Activity Item Container
		$this->start_controls_section(
			'activity_item_container_section',
			array(
				'label' => __( 'Activity Item Container', 'shortcodes-for-buddypress' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		// Background control for activity items
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'container_background',
				'label'    => __( 'Background', 'shortcodes-for-buddypress' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)',
			)
		);

		// Box shadow control for activity items
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)',
			)
		);

		// Border control for activity items
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)',
			)
		);

		// Border radius control for activity items
		$this->add_control(
			'container_border_radius',
			array(
				'label'      => __( 'Border Radius', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// Padding control for activity items
		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => __( 'Padding', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// Spacing between activity items
		$this->add_control(
			'spacing_items',
			array(
				'label'     => __( 'Item Spacing', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)'            => 'margin-top: 0; margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .activity > ul.activity-list > li:last-child' => 'margin-bottom: 0;',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Load More Button
		$this->start_controls_section(
			'load_more_button_section',
			array(
				'label' => __( 'Load More Button', 'shortcodes-for-buddypress' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		// Base style for load more button
		$this->add_control(
			'base_style',
			array(
				'label'     => __( 'Base Style', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::HIDDEN,
				'default'   => '1',
				'selectors' => array(
					'{{WRAPPER}} .load-more'   => 'background-color: transparent; border: none; margin: 0;',
					'{{WRAPPER}} .load-newest' => 'background-color: transparent; border: none; margin: 0;',
				),
			)
		);

		// Display type for load more button (block or inline)
		$this->add_control(
			'load_more_btn_display_type',
			array(
				'label'     => __( 'Display', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'block',
				'options'   => array(
					'inline-block' => __( 'Inline', 'shortcodes-for-buddypress' ),
					'block'        => __( 'Block', 'shortcodes-for-buddypress' ),
				),
				'selectors' => array(
					'{{WRAPPER}} #buddypress .activity-list .load-more a' => 'display: block;',
				),
			)
		);

		// Alignment control for inline load more button
		$this->add_responsive_control(
			'load_more_btn_align',
			array(
				'label'     => __( 'Alignment', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'shortcodes-for-buddypress' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'shortcodes-for-buddypress' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'shortcodes-for-buddypress' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} #buddypress .activity-list .load-more a' => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'load_more_btn_display_type' => 'inline-block',
				),
				'default'   => '',
			)
		);

		// Base style for inline load more button
		$this->add_control(
			'load_more_btn_display_inline_block',
			array(
				'label'     => __( 'Base Style', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::HIDDEN,
				'default'   => '1',
				'selectors' => array(
					'{{WRAPPER}} #buddypress .activity-list .load-more a' => 'display: inline-block;',
				),
				'condition' => array(
					'load_more_btn_display_type' => 'inline-block',
				),
			)
		);

		// Typography control for load more button
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'load_more_btn_typography',
				'label'    => __( 'Typography', 'shortcodes-for-buddypress' ),
				'selector' => '{{WRAPPER}} #buddypress .activity-list .load-more a, {{WRAPPER}} .load-newest a',
			)
		);

		// Normal/Hover state tabs for load more button
		$this->start_controls_tabs( 'load_more_btn_style_tabs' );

		// Normal state tab
		$this->start_controls_tab(
			'load_more_btn_style_normal_tab',
			array(
				'label' => __( 'Normal', 'shortcodes-for-buddypress' ),
			)
		);

		// Normal state background color
		$this->add_control(
			'load_more_btn_background',
			array(
				'label'     => __( 'Background', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} #buddypress .activity-list .load-more a'   => 'background-color: {{VALUE}}',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a' => 'background-color: {{VALUE}}',
				),
			)
		);

		// Normal state text color
		$this->add_control(
			'load_more_btn_text_color',
			array(
				'label'     => __( 'Color', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} #buddypress .activity-list .load-more a'   => 'color: {{VALUE}}',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		// Hover state tab
		$this->start_controls_tab(
			'load_more_btn_style_hover_tab',
			array(
				'label' => __( 'Hover', 'shortcodes-for-buddypress' ),
			)
		);

		// Hover state background color
		$this->add_control(
			'load_more_btn_hover_background',
			array(
				'label'     => __( 'Background', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} #buddypress .activity-list .load-more a:hover'   => 'background-color: {{VALUE}}',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		// Hover state text color
		$this->add_control(
			'load_more_btn_hover_text_color',
			array(
				'label'     => __( 'Color', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} #buddypress .activity-list .load-more a:hover'   => 'color: {{VALUE}}',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		// Hover state border color
		$this->add_control(
			'load_more_btn_hover_border',
			array(
				'label'     => __( 'Border Color', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} #buddypress .activity-list .load-more a:hover'   => 'border-color: {{VALUE}}',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		// Hover state box shadow
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'load_more_btn_hover_shadow',
				'selector' => '{{WRAPPER}} #buddypress .activity-list .load-more a:hover, #buddypress {{WRAPPER}} .load-newest a:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Border control for load more button
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'load_more_btn_border',
				'selector'  => '{{WRAPPER}} #buddypress .activity-list .load-more a, {{WRAPPER}} #buddypress .activity-list .load-newest a',
				'separator' => 'before',
			)
		);

		// Border radius control for load more button
		$this->add_control(
			'load_more_btn_border_radius',
			array(
				'label'      => __( 'Border Radius', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} #buddypress .activity-list .load-more a'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// Box shadow control for load more button
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'load_more_btn_shadow',
				'selector' => '{{WRAPPER}} #buddypress .activity-list .load-more a, {{WRAPPER}} #buddypress .activity-list .load-newest a',
			)
		);

		// Padding control for load more button
		$this->add_responsive_control(
			'load_more_btn_padding',
			array(
				'label'      => __( 'Padding', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #buddypress .activity-list .load-more a'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 *
	 * @since 1.6.1
	 * @return void
	 */
	protected function render() {
		// Get all widget settings
		$settings = $this->get_settings_for_display();
		$args     = '';

		// Add quotes around title if it exists
		if ( isset( $settings['sfb_title'] ) && ! empty( $settings['sfb_title'] ) ) {
			$settings['sfb_title'] = '"' . $settings['sfb_title'] . '"';
		}

		// Special handling for logged-in user activity
		if ( isset( $settings['sfb_loggedin_user_activity'] ) && 'yes' === $settings['sfb_loggedin_user_activity'] ) {
			$settings['sfb_user_id'] = apply_filters( 'bp_shortcode_pro_loggedin_user_activity', bp_loggedin_user_id() );
		}

		// Build shortcode attributes from settings
		foreach ( $settings as $setting_key => $setting ) {
			// Only process settings that start with 'sfb_'
			if ( false !== strpos( $setting_key, 'sfb_' ) ) {
				if ( ! empty( $settings[ $setting_key ] ) ) {
					$key   = substr( $setting_key, 4 ); // Remove 'sfb_' prefix
					$args .= $key . '=' . $setting . ' ';
				}
			}
		}

		// Allow filtering of shortcode arguments
		$args      = apply_filters( 'bp_shortcode_pro_activity_element_args', trim( $args ) );
		
		// Build and render the shortcode
		$shortcode = '[activity-listing ' . $args . ']';
		echo do_shortcode( $shortcode );
	}
}
