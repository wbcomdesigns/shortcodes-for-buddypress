<?php
/**
 * BuddyPress - Members Loop
 *
 * @since 3.0.0
 * @version 6.0.0
 */
?>

<div id="buddypress" class="<?php echo esc_attr( bp_nouveau_get_container_classes() ); ?>">

	<div id="members-dir-list" class="members dir-list" data-bp-list="members" data-ajax="false">
		
		<?php
		if ( bp_get_current_member_type() ) :
			?>
			<p class="current-member-type"><?php bp_current_member_type_message(); ?></p>
		<?php endif; ?>

		<?php if ( bp_has_members( $query ) ) : ?>
			
			<div class="bpsp-member-count">			
				<?php echo wp_kses_post( bp_get_members_pagination_count() ); ?>
			</div>
			
			<ul id="members-list" class="<?php echo esc_attr( $classes ); ?>" >

			<?php
			while ( bp_members() ) :
				bp_the_member();
				?>

				<li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_member_user_id(); ?>" data-bp-item-component="members">
					<div class="list-wrap">

						<?php bp_shortcode_member_cover(); ?>

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
										<?php bp_nouveau_member_extra_content(); ?>
									</div><!-- .item-extra-content -->
								<?php endif; ?>

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
			
			<?php if ( $members_atts['per_page'] ) { ?>
			<div class="bp-pagination">
				<div class="bpsp-member-pagination bp-pagination-links bottom">			
					<?php echo wp_kses_post( bp_get_members_pagination_links() ); ?>
				</div>
			</div>
			<?php } ?>
			
			<?php
			else :

				bp_nouveau_user_feedback( 'members-loop-none' );

		endif;
			?>
	</div>

</div>
