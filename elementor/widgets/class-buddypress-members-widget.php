<?php
/**
 * BuddyPress Members Elementor Widget
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
 * BuddyPress Members Elementor Widget Class.
 *
 * @since 1.6.1
 */
class Buddypress_Shortcode_Members_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.6.1
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'buddypress_shortcode_members_widget';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.6.1
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Members List', 'shortcodes-for-buddypress' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.6.1
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-person';
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
	 * Get user roles for Elementor options.
	 *
	 * @since 1.6.1
	 * @return array Array of user roles with role slug as key and role name as value.
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
	 * Get BuddyPress member types to display as Elementor options.
	 *
	 * Retrieves all registered BuddyPress member types and formats them
	 *
	 * @since 1.6.1
	 * @return array Member types.
	 */
	private function get_member_types() {
		$member_types = array( '' => 'All' );
		if ( function_exists( 'bp_get_member_types' ) ) {
			$member_types += bp_get_member_types( array(), 'names' );
		}

		return $member_types;
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
				'label'       => __( 'Per Page', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 20,
				'description' => __( 'How many members display on page.', 'shortcodes-for-buddypress' ),
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
			'sfb_section_style',
			array(
				'label' => __( 'Listing', 'shortcodes-for-buddypress' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		// Remove default border.
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

		// Background control.
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'sfb_list_item_background',
				'label'    => __( 'Background', 'shortcodes-for-buddypress' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} #members-list > li > .list-wrap',
			)
		);

		// Box shadow control.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'sfb_listing_box_shadow',
				'selector' => '{{WRAPPER}} #members-list > li > .list-wrap',
			)
		);

		// Border control.
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'sfb_listing_border',
				'selector' => '{{WRAPPER}} #members-list > li > .list-wrap',
			)
		);

		// Border radius control.
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

		// Margin control.
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

		// Padding control.
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
		$args = apply_filters( 'bp_shortcode_pro_members_element_args', trim( $args ) );
		// Build and render the shortcode.
		$shortcode = '[members-listing ' . $args . ']';
		echo do_shortcode( $shortcode );
	}
}
