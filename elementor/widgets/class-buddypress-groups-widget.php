<?php
/**
 * BuddyPress Groups Elementor Widget
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
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * BuddyPress Groups Elementor Widget Class.
 *
 * @since 1.6.1
 */
class Buddypress_Shortcode_Groups_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.6.1
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'buddypress_shortcode_groups_widget';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.6.1
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Groups List', 'shortcodes-for-buddypress' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.6.1
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-user-circle-o';
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
	 * Get script dependencies.
	 *
	 * @since 1.6.1
	 * @return array Script dependencies.
	 */
	public function get_script_depends() {
		return array();
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.6.1
	 * @return array Style dependencies.
	 */
	public function get_style_depends() {
		return array();
	}

	/**
	 * Get group types for Elementor options.
	 *
	 * @since 1.6.1
	 * @return array Group types.
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
	 * Register widget controls.
	 *
	 * @since 1.6.1
	 * @return void
	 */
	protected function register_controls() {
		// Content Section - Query Options.
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Query', 'shortcodes-for-buddypress' ),
			)
		);

		// Title control.
		$this->add_control(
			'sfb_title',
			array(
				'label'       => __( 'Title', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Add activity title', 'shortcodes-for-buddypress' ),
			)
		);

		// Per page control.
		$this->add_control(
			'sfb_per_page',
			array(
				'label'       => __( 'Display Number of Groups', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 20,
				'description' => __( 'How many groups to display per page.', 'shortcodes-for-buddypress' ),
			)
		);

		// Pro version notice.
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

		// Style Section - Listing Appearance.
		$this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'Listing Groups', 'shortcodes-for-buddypress' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		// Background control.
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'sfb_list_item_background',
				'label'    => __( 'Background', 'shortcodes-for-buddypress' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap',
			)
		);

		// Normal/Hover state tabs.
		$this->start_controls_tabs( 'tabs_listing_style' );

		// Normal state tab.
		$this->start_controls_tab(
			'sfb_tab_listing_normal',
			array(
				'label' => __( 'Normal', 'shortcodes-for-buddypress' ),
			)
		);

		// Normal state box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'sfb_listing_box_shadow',
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap',
			)
		);

		$this->end_controls_tab();

		// Hover state tab.
		$this->start_controls_tab(
			'sfb_tab_listing_hover',
			array(
				'label' => __( 'Hover', 'shortcodes-for-buddypress' ),
			)
		);

		// Hover state box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'sfb_listing_box_shadow_hover',
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Divider.
		$this->add_control(
			'sfb_hr_listing',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		// Border control for list item wrapper.
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'sfb_listing_border',
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap',
			)
		);

		// Border radius control for list item wrapper.
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

		// Padding control for list item wrapper.
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

		// Border control for list item.
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'sfb_listing_border_one',
				'selector' => '{{WRAPPER}} #groups-list > li',
			)
		);

		// Border radius control for list item.
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

		// Padding control for list item.
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
	 * Render widget output.
	 *
	 * @since 1.6.1
	 * @return void
	 */
	protected function render() {
		// Get all widget settings.
		$settings = $this->get_settings_for_display();
		$args     = '';

		// Add quotes around title if it exists.
		if ( isset( $settings['sfb_title'] ) && ! empty( $settings['sfb_title'] ) ) {
			$settings['sfb_title'] = '"' . $settings['sfb_title'] . '"';
		}

		// Build shortcode attributes from settings.
		foreach ( $settings as $setting_key => $setting ) {
			// Only process settings that start with 'sfb_'.
			if ( false !== strpos( $setting_key, 'sfb_' ) ) {
				$key = substr( $setting_key, 4 ); // Remove 'sfb_' prefix.
				// Handle array values.
				if ( is_array( $setting ) && ! empty( $setting ) ) {
					// Filter out any nested arrays or objects.
					$flat_values = array();
					foreach ( $setting as $val ) {
						if ( is_scalar( $val ) ) {
							$flat_values[] = $val;
						}
					}
					if ( ! empty( $flat_values ) ) {
						$args .= $key . '=' . implode( ',', $flat_values ) . ' ';
					}
				}
				// Handle non-empty scalar values.
				elseif ( ! empty( $setting ) && is_scalar( $setting ) ) {
					$args .= $key . '=' . $setting . ' ';
				}
			}
		}

		// Allow filtering of shortcode arguments.
		$args = apply_filters( 'bp_shortcode_pro_groups_element_args', trim( $args ) );

		// Build and render the shortcode.
		$shortcode = '[groups-listing ' . $args . ']';
		echo do_shortcode( $shortcode );
	}
}
