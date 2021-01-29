<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}





class Buddypress_Shortcode_Activity_Widget extends Widget_Base {
	
	public function get_name() {
		return 'buddypress_shortcode_activity_widget';
	}

	public function get_title() {
		return esc_html__('Acivity List', 'shortcodes-for-buddypress' );
	}

	public function get_icon() {
		return 'dashicons dashicons-buddicons-buddypress-logo';
	}

	public function get_categories() {
		return [ 'buddypress-widgets' ];
	}
	
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Query', 'shortcodes-for-buddypress' ),
			]
		);
		
		$this->add_control(
			'sfb_title',
			[
				'label'       => __( 'Title', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::TEXT,				
				'description' => __( 'Add activity title', 'shortcodes-for-buddypress' )
			]
		);
		
		$this->add_control(
			'sfb_include',
			[
				'label'       => __( 'Activity Include', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::TEXT,				
				'description' => __( 'pass an activity_id or string of IDs comma-separated', 'shortcodes-for-buddypress' )
			]
		);
		
		$this->add_control(
			'sfb_exclude',
			[
				'label'       => __( 'Activity exclude', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::TEXT,				
				'description' => __( 'pass an activity_id or string of IDs comma-separated', 'shortcodes-for-buddypress' )
			]
		);
		
		$this->add_control(
			'sfb_number',
			[
				'label'       => __( 'Total items', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 20,
				'description' => __( 'How many activity items to get.', 'shortcodes-for-buddypress' )
			]
		);

		$this->add_control(
			'sfb_sort',
			[
				'label'   => __( 'Sort order', 'shortcodes-for-buddypress' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'DESC'        => 'Descending',
					'ASC'  		=> 'Ascending',
				],
				'default' => 'DESC'
			]
		);

		$this->add_control(
			'sfb_search_terms',
			[
				'label'       => __( 'Filter by search term', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => 'Return only activity items that match the search term in content'
			]
		);

		$this->add_control(
			'sfb_object',
			[
				'label'   => __( 'Object Type', 'shortcodes-for-buddypress' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => 'All',
					'groups'  => 'Groups',
					'friends' => 'Friends',
					'profile' => 'Profile',
					'status'  => 'Status',
					'blogs'   => 'Blogs',

				],
				'default' => ''
			]
		);

		$this->add_control(
			'sfb_action',
			[
				'label'       => __( 'Action Filter', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => 'Example: activity_update<br> See action parameter from the filters section from https://codex.buddypress.org/developer/loops-reference/the-activity-stream-loop/'
			]
		);
		
		$this->add_control(
			'sfb_allow_posting',
			[
				'label' 		=> esc_html__( 'Allow Posting', 'shortcodes-for-buddypress' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'default' 		=> 'no',
				'label_on' 		=> esc_html__( 'Show', 'shortcodes-for-buddypress' ),
				'label_off' 	=> esc_html__( 'Hide', 'shortcodes-for-buddypress' ),
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'activity_item_container_section',
			[
				'label' => __( 'Activity Item Container', 'shortcodes-for-buddypress' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'container_background',
				'label'    => __( 'Background', 'shortcodes-for-buddypress' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)',
			]
		);

		$this->add_control(
			'container_border_radius',
			[
				'label'      => __( 'Border Radius', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => __( 'Padding', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'spacing_items',
			[
				'label'     => __( 'Spacing items', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .activity > ul.activity-list > li:not(.load-more)'            => 'margin-top: 0; margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .activity > ul.activity-list > li:last-child' => 'margin-bottom: 0;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'load_more_section',
			[
				'label'      => __( 'Load More Button', 'shortcodes-for-buddypress' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [],
			]
		);

		$this->add_control(
			'base_style',
			[
				'label'     => __( 'Base Style', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::HIDDEN,
				'default'   => '1',
				'selectors' => [
					'{{WRAPPER}} .load-more'   => 'background-color: transparent; border: none; margin: 0;',
					'{{WRAPPER}} .load-newest' => 'background-color: transparent; border: none; margin: 0;',
				],
			]
		);

		$this->add_control(
			'load_more_btn_display_type',
			[
				'label'     => __( 'Display', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'block',
				'options'   => [
					'inline-block' => __( 'Inline', 'shortcodes-for-buddypress' ),
					'block'        => __( 'Block', 'shortcodes-for-buddypress' ),
				],
				'selectors' => [
					'{{WRAPPER}} #buddypress .activity-list .load-more a' => 'display: block;',
				],
			]
		);

		$this->add_responsive_control(
			'load_more_btn_align',
			[
				'label'     => __( 'Alignment', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'shortcodes-for-buddypress' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'shortcodes-for-buddypress' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'shortcodes-for-buddypress' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} #buddypress .activity-list .load-more a' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'load_more_btn_display_type' => 'inline-block',
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'load_more_btn_display_inline_block',
			[
				'label'     => __( 'Base Style', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::HIDDEN,
				'default'   => '1',
				'selectors' => [
					'{{WRAPPER}} #buddypress .activity-list .load-more a' => 'display: inline-block;',
				],
				'condition' => [
					'load_more_btn_display_type' => 'inline-block',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'load_more_btn_typography',
				'label'    => __( 'Typography', 'shortcodes-for-buddypress' ),
				'selector' => '{{WRAPPER}} #buddypress .activity-list .load-more a, {{WRAPPER}} .load-newest a',
			]
		);

		$this->start_controls_tabs( 'load_more_btn_style_tabs' );

		$this->start_controls_tab(
			'load_more_btn_style_normal_tab',
			[
				'label' => __( 'Normal', 'shortcodes-for-buddypress' ),
			]
		);

		$this->add_control(
			'load_more_btn_background',
			[
				'label'     => __( 'Background', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #buddypress .activity-list .load-more a'   => 'background-color: {{VALUE}}',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'load_more_btn_text_color',
			[
				'label'     => __( 'Color', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #buddypress .activity-list .load-more a'   => 'color: {{VALUE}}',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'load_more_btn_style_hover_tab',
			[
				'label' => __( 'Hover', 'shortcodes-for-buddypress' ),
			]
		);

		$this->add_control(
			'load_more_btn_hover_background',
			[
				'label'     => __( 'Background', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #buddypress .activity-list .load-more a:hover'   => 'background-color: {{VALUE}}',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'load_more_btn_hover_text_color',
			[
				'label'     => __( 'Color', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #buddypress .activity-list .load-more a:hover'   => 'color: {{VALUE}}',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'load_more_btn_hover_border',
			[
				'label'     => __( 'Border Color', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #buddypress .activity-list .load-more a:hover'   => 'border-color: {{VALUE}}',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'load_more_btn_hover_shadow',
				'selector' => '{{WRAPPER}} #buddypress .activity-list .load-more a:hover, #buddypress {{WRAPPER}} .load-newest a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'load_more_btn_border',
				'selector'  => '{{WRAPPER}} #buddypress .activity-list .load-more a, {{WRAPPER}} #buddypress .activity-list .load-newest a',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'load_more_btn_border_radius',
			[
				'label'      => __( 'Border Radius', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} #buddypress .activity-list .load-more a'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'load_more_btn_shadow',
				'selector' => '{{WRAPPER}} #buddypress .activity-list .load-more a, {{WRAPPER}} #buddypress .activity-list .load-newest a',
			]
		);

		$this->add_responsive_control(
			'load_more_btn_padding',
			[
				'label'      => __( 'Padding', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} #buddypress .activity-list .load-more a'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} #buddypress .activity-list .load-newest a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		
	}
	
	protected function render() {
	
		$settings = $this->get_settings_for_display();
		
		
		$args = [ 
					'title'  => $settings['sfb_title'],
					'include'  => $settings['sfb_include'],
					'exclude'  => $settings['sfb_exclude'],
					'sort'     => $settings['sfb_sort'],
					'per_page' => $settings['sfb_number'],
					'search_terms' => $settings['sfb_search_terms'],
					'object' => $settings['sfb_object'],
					'action' => $settings['sfb_action'],
					'allow_posting' => ( $settings['sfb_allow_posting'] == 'yes' ) ? 'true': 'false',					
				];

		if ( isset($_REQUEST['action']) && ( $_REQUEST['action'] == 'elementor' || $_REQUEST['action'] == 'elementor_ajax' ) && is_admin() ) {
			$atts = $args;
			$is_nouveau = function_exists( 'bp_nouveau' );
			
			$activity_list_classes = 'activity-list item-list ';

			if ( $is_nouveau ) {
				$activity_list_classes .= ' bp-list';
			}

			$activity_list_classes = apply_filters( 'bpas_activity_list_classes', $activity_list_classes )
			?>

			
			<div id="buddypress" class="buddypress-wrap">
			

			<?php if ( $atts['title'] ) : ?>
				<h3 class="activity-shortcode-title"><?php echo $atts['title']; ?></h3>
			<?php endif; ?>

			<?php if ( $atts['allow_posting'] == 'true' && is_user_logged_in() ) : ?>
			<div class="bpas-post-form-wrapper">
				<?php bp_locate_template( array( 'activity/post-form.php' ), true ); ?>

			</div>
			<?php endif; ?>

			<?php if ( bp_has_activities( $atts ) ) : ?>

				<div class="bpas-shortcode-activities <?php echo esc_attr( $atts['container_class'] ); ?> <?php if ( ! $atts['display_comments'] ) : ?> hide-activity-comments<?php endif; ?> shortcode-activity-stream">

					<ul id="activity-stream" class="<?php echo esc_attr( $activity_list_classes ); ?> ">

						<?php while ( bp_activities() ) : bp_the_activity(); ?>
							<?php bp_get_template_part( 'activity/entry' ); ?>
						<?php endwhile; ?>

						<?php if ( bp_activity_has_more_items() ) : ?>
							<li class="load-more">
								<a href="<?php bp_activity_load_more_link() ?>"><?php _e( 'Load More', 'buddypress' ); ?></a>
							</li>
						<?php endif; ?>
					</ul>

				</div>

			<?php else : ?>
				<div id="message" class="info">
					<p><?php _e( 'Sorry, there was no activity found. Please try a different filter.', 'buddypress' ); ?></p>
				</div>
			<?php endif; ?>
			
			</div>
			<?php
			
			
		} else {
			
			$atts = '';
			foreach( $args as $key=>$val ) {
				if ( $val != '' ) {
					$atts .= $key . '="'.$val.'" ';
				}
			}

			echo do_shortcode('[activity-listing '. $atts.']');
		}
	}
	
}


\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Buddypress_Shortcode_Activity_Widget() );