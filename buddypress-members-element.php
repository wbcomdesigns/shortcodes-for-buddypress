<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Buddypress_Shortcode_Members_Widget extends Widget_Base {

	public function get_name() {
		return 'buddypress_shortcode_members_widget';
	}

	public function get_title() {
		return esc_html__('Members List', 'shortcodes-for-buddypress' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'buddypress-widgets' ];
	}
	
	public function get_user_roles() {
		global $wp_roles;

		$all_roles = $wp_roles->roles;
		foreach( $all_roles as $key=>$value) {
			$user_roles[$key] = $value['name'];
		}
		return $user_roles;
	}

	public function get_member_types() {
		$member_types = array( '' => 'All' );
		if ( function_exists( 'bp_get_member_types' ) ) {
			$member_types += bp_get_member_types( array(), 'names' );
		}

		return $member_types;
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
		
		$this->add_control(
			'go_sfb_pro_notice',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => \Shortcodes_For_Buddypress_Public::sfb_go_pro_template(
					[
						'title'    => __( 'Shortcodes for BuddyPress PRO', 'shortcodes-for-buddypress' ),
						'messages' => [
							__( 'Power up up your listing with custom queries and templates.', 'shortcodes-for-buddypress' ),
						],
						'link'     => 'https://wbcomdesigns.com/downloads/shortcodes-for-buddypress-pro',
					]
				),
			]
		);
		
		$this->end_controls_section();
		
		
		
		$this->start_controls_section(
			'sfb_section_style',
			[
				'label' => __( 'Listing', 'shortcodes-for-buddypress' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sfb_listing_no_border',
			[
				'label'     => __( 'View', 'shortcodes-for-buddypress' ),
				'type'      => Controls_Manager::HIDDEN,
				'default'   => '1',
				'selectors' => [
					'{{WRAPPER}} #members-list' => 'border: 0;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'sfb_list_item_background',
				'label'    => __( 'Background', 'shortcodes-for-buddypress' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} #members-list > li > .list-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'sfb_listing_box_shadow',
				'selector' => '{{WRAPPER}} #members-list > li > .list-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'sfb_listing_border',
				'selector' => '{{WRAPPER}} #members-list > li > .list-wrap',
			]
		);

		$this->add_control(
			'sfb_listing_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} #members-list > li > .list-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sfb_listing_margin',
			[
				'label'      => __( 'Margin', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} #members-list > li > .list-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sfb_listing_padding',
			[
				'label'      => __( 'Padding', 'shortcodes-for-buddypress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} #members-list > li > .list-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		
	}
	protected function render() {

		$settings = $this->get_settings_for_display();
		$current_component = static function () {
			return 'members';
		};
		
		
		
		add_filter( 'bp_current_component', $current_component );
		

		$args = [
					'title'  	=> $settings['sfb_title'],					
					'per_page' 	=> $settings['sfb_per_page'],					
					'object' 	=> 'members',					
				];
				
		if ( isset($_REQUEST['action']) && ( $_REQUEST['action'] == 'elementor' || $_REQUEST['action'] == 'elementor_ajax' ) && is_admin() ) {
			$atts = $args;
			$current_component_members = static function () {
				return true;
			};
			add_filter( 'bp_is_current_component', $current_component_members );
			add_filter( 'groups_get_current_group', $current_component_members );
			add_filter( 'bp_is_active', $current_component_members);
			
			add_filter( 'bp_members_pagination_count', '__return_zero' );
			add_filter( 'bp_get_members_pagination_links', '__return_zero' );
			?>
			
			<div id="buddypress" class="buddypress-wrap bp-dir-hori-nav members">
				<?php if ( $atts['title'] ) : ?>
					<h3 class="activity-shortcode-title"><?php echo $atts['title']; ?></h3>
				<?php endif; ?>

				<div class="screen-content">
					<div id="members-dir-list" class="members dir-list" data-bp-list="">
						<?php if ( bp_has_members( $atts ) ) : ?>

							<?php bp_nouveau_pagination( 'top' ); ?>

							<ul id="members-list" class="<?php bp_nouveau_loop_classes(); ?>">

							<?php while ( bp_members() ) : bp_the_member(); ?>

								<li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_member_user_id(); ?>" data-bp-item-component="members">
									<div class="list-wrap">

										<div class="item-avatar">
											<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( bp_nouveau_avatar_args() ); ?></a>
										</div>

										<div class="item">

											<div class="item-block">

												<h2 class="list-title member-name">
													<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
												</h2>

												<?php if ( bp_nouveau_member_has_meta() ) : ?>
													<p class="item-meta last-activity">
														<?php bp_nouveau_member_meta(); ?>
													</p><!-- .item-meta -->
												<?php endif; ?>

												<?php if ( bp_nouveau_member_has_extra_content() ) : ?>
													<div class="item-extra-content">
														<?php bp_nouveau_member_extra_content() ; ?>
													</div><!-- .item-extra-content -->
												<?php endif ; ?>

												<?php
												bp_nouveau_members_loop_buttons(
													array(
														'container'      => 'ul',
														'button_element' => 'button',
													)
												);
												?>
											</div>

											<?php if ( bp_get_member_latest_update() && ! bp_nouveau_loop_is_grid() ) : ?>
												<div class="user-update">
													<p class="update"> <?php bp_member_latest_update(); ?></p>
												</div>
											<?php endif; ?>

										</div><!-- // .item -->
									</div>
								</li>

							<?php endwhile; ?>

							</ul>

							<?php bp_nouveau_pagination( 'bottom' ); ?>

						<?php
						else :

							bp_nouveau_user_feedback( 'members-loop-none' );

						endif;
						?>
					</div>	
					
				</div>
			</div>
			
			<?php
			remove_filter( 'bp_members_pagination_count', '__return_zero' );
			remove_filter( 'bp_get_members_pagination_links', '__return_zero' );
		} else {
		
			$atts = '';
			foreach( $args as $key=>$val ) {
				if ( $val != '' ) {
					$atts .= $key . '="'.$val.'" ';
				}
			}
			
			echo do_shortcode('[members-listing '. $atts.']');
		
		}
		remove_filter( 'bp_current_component', $current_component );
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Buddypress_Shortcode_Members_Widget() );