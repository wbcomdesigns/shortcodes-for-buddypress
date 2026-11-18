<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName -- Legacy file name.
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

		// Number of activities control.
		$this->add_control(
			'sfb_per_page',
			array(
				'label'       => __( 'Display Number of Activities', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 20,
				'description' => __( 'How many activity items to display.', 'shortcodes-for-buddypress' ),
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

		// Style Section - Activity Item Container.
		$this->start_controls_section(
			'activity_item_container_section',
			array(
				'label' => __( 'Activity Item Container', 'shortcodes-for-buddypress' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		// Background control for activity items.
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'container_background',
				'label'    => __( 'Background', 'shortcodes-for-buddypress' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} #buddypress .activity > ul.activity-list > li:not(.load-more)',
			)
		);

		// Box shadow control for activity items.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} #buddypress .activity > ul.activity-list > li:not(.load-more)',
			)
		);

		// Border control for activity items.
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} #buddypress .activity > ul.activity-list > li:not(.load-more)',
			)
		);

		// Border radius control for activity items.
		$this->add_control(
			'container_border_radius',
			array(
				'label'      => __( 'Border Radius', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} #buddypress .activity > ul.activity-list > li:not(.load-more)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		// Padding control for activity items.
		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => __( 'Padding', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #buddypress .activity > ul.activity-list > li:not(.load-more)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// Spacing between activity items.
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
					'{{WRAPPER}} #buddypress .activity > ul.activity-list > li:not(.load-more)'            => 'margin-top: 0; margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} #buddypress .activity > ul.activity-list > li:last-child' => 'margin-bottom: 0;',
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
		$settings = $this->get_settings_for_display();

		// Logged-in user activity is a convenience toggle that resolves to a
		// concrete user_id attribute.
		if ( isset( $settings['sfb_loggedin_user_activity'] ) && 'yes' === $settings['sfb_loggedin_user_activity'] ) {
			$settings['sfb_user_id'] = apply_filters( 'bp_shortcode_pro_loggedin_user_activity', bp_loggedin_user_id() );
		}

		echo \BPShortCode::render_from_elementor( 'activity-listing', $settings, 'bp_shortcode_pro_activity_element_args' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Shortcode output is escaped by its own templates.
	}
}
