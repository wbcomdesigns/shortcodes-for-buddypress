<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Buddypress_Shortcode_Groups_Widget extends Widget_Base {

	public function get_name() {
		return 'buddypress_shortcode_groups_widget';
	}

	public function get_title() {
		return esc_html__('Groups', 'shortcodes-for-buddypress' );
	}

	public function get_icon() {
		return 'eicon-toggle';
	}

	public function get_categories() {
		return [ 'buddypress-widgets' ];
	}
	
	public function get_group_types(){
		$group_types = array( '' => 'All' );
		if ( function_exists( 'bp_get_group_type' ) ) {
			$get_group_types       = bp_groups_get_group_types( array(), 'objects' );
			foreach( $get_group_types as $key=>$value) {
				$group_types[$key]	= $value->name;
			}
		}		
		
		return $group_types;
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
			'sfb_per_page',
			[
				'label'       => __( 'Per Page', 'shortcodes-for-buddypress' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 20,
				'description' => __( 'How many members display on page.', 'shortcodes-for-buddypress' )
			]
		);
		
		
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Listing Groups', 'stax-buddy-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'sfb_list_item_background',
				'label'    => __( 'Background', 'stax-buddy-builder' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap',
			]
		);

		$this->start_controls_tabs( 'tabs_listing_style' );

		$this->start_controls_tab(
			'sfb_tab_listing_normal',
			[
				'label' => __( 'Normal', 'stax-buddy-builder' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'sfb_listing_box_shadow',
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sfb_tab_listing_hover',
			[
				'label' => __( 'Hover', 'stax-buddy-builder' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'sfb_listing_box_shadow_hover',
				'selector' => '{{WRAPPER}} #groups-list > li > .list-wrap:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'sfb_hr_listing',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'sfb_listing_border',
				'selector'  => '{{WRAPPER}} #groups-list > li > .list-wrap',				
			]
		);

		$this->add_control(
			'sfb_listing_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'stax-buddy-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} #groups-list > li > .list-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'sfb_listing_padding',
			[
				'label'      => __( 'Padding', 'stax-buddy-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} #groups-list > li > .list-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'sfb_listing_border_one',
				'selector'  => '{{WRAPPER}} #groups-list > li',
				
			]
		);

		$this->add_control(
			'sfb_listing_border_radius_one',
			[
				'label'      => esc_html__( 'Border Radius', 'stax-buddy-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} #groups-list > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'sfb_listing_padding_one',
			[
				'label'      => __( 'Padding', 'stax-buddy-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} #groups-list > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->end_controls_section();

	}
	
	protected function render() {

		$settings = $this->get_settings_for_display();
		$current_component = static function () {
			return 'groups';
		};
		$current_component_groups = static function () {
			return true;
		};
		
		add_filter( 'bp_current_component', $current_component );
		add_filter( 'bp_is_current_component', $current_component_groups );
		add_filter( 'groups_get_current_group', $current_component_groups );
		add_filter( 'bp_is_active', $current_component_groups);
		
		$args = [
					'title'  	=> $settings['sfb_title'],	
					'per_page' 	=> $settings['sfb_per_page'],					
					'object' 	=> 'groups',								
				];
				
		if ( isset($_REQUEST['action']) && ( $_REQUEST['action'] == 'elementor' || $_REQUEST['action'] == 'elementor_ajax' ) && is_admin() ) {
			$atts = $args;
			
			add_filter( 'bp_get_groups_pagination_count', '__return_zero' );
			add_filter( 'bp_get_groups_pagination_links', '__return_zero' );
			
			?>
			<div id="buddypress" class="buddypress-wrap bp-dir-hori-nav groups">
			
				<?php if ( $atts['title'] ) : ?>
					<h3 class="activity-shortcode-title"><?php echo $atts['title']; ?></h3>
				<?php endif; ?>
				
				<div class="screen-content">
					<div id="groups-dir-list" class="groups dir-list" data-bp-list="">
						<?php if ( bp_has_groups( $atts ) ) : ?>

							<?php bp_nouveau_pagination( 'top' ); ?>

							<ul id="groups-list" class="<?php bp_nouveau_loop_classes(); ?>">

								<?php while ( bp_groups() ) : bp_the_group(); ?>

									<li <?php bp_group_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups">
										<div class="list-wrap">

											<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
												<div class="item-avatar">
													<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( bp_nouveau_avatar_args() ); ?></a>
												</div>
											<?php endif; ?>

											<div class="item">

												<div class="item-block">

													<h2 class="list-title groups-title"><?php bp_group_link(); ?></h2>

													<?php if ( bp_nouveau_group_has_meta() && function_exists( 'bp_nouveau_the_group_meta' ) ) : ?>

														<p class="item-meta group-details"><?php bp_nouveau_the_group_meta( array( 'keys' => array( 'status', 'count' ) ) ); ?></p>

													<?php endif; ?>

													<p class="last-activity item-meta">
														<?php
															printf(
																/* translators: %s: last activity timestamp (e.g. "Active 1 hour ago") */
																esc_html__( 'Active %s', 'buddypress' ),
																sprintf(
																	'<span data-livestamp="%1$s">%2$s</span>',
																	bp_core_get_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ),
																	esc_html( bp_get_group_last_active() )
																)
															);
														?>
													</p>

												</div>
												<?php if( function_exists('bp_nouveau_group_description_excerpt') ):?>
												<div class="group-desc"><p><?php bp_nouveau_group_description_excerpt(); ?></p></div>
												<?php endif;?>

												<?php bp_nouveau_groups_loop_item(); ?>

												<?php bp_nouveau_groups_loop_buttons(); ?>

											</div>

										</div>

									</li>

								<?php endwhile; ?>

							</ul>

							<?php bp_nouveau_pagination( 'bottom' ); ?>

						<?php else : ?>

							<?php bp_nouveau_user_feedback( 'groups-loop-none' ); ?>

						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
			
			remove_filter( 'bp_get_groups_pagination_count', '__return_zero' );
			remove_filter( 'bp_get_groups_pagination_links', '__return_zero' );
			
		} else {
			$atts = '';
			foreach( $args as $key=>$val ) {
				if ( $val != '' ) {
					$atts .= $key . '="'.$val.'" ';
				}
			}
			
			echo do_shortcode('[groups-listing '. $atts.']');
		}
				
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Buddypress_Shortcode_Groups_Widget() );