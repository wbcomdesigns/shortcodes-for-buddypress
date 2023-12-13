<?php
/**
 * BuddyPress - Groups Loop
 *
 * @since 3.0.0
 * @version 12.0.0
 */

bp_nouveau_before_loop(); ?>
<?php if ( bp_get_current_group_directory_type() ) : ?>
	<p class="bps-current-group-type"><?php bp_current_group_directory_type_message(); ?></p>
<?php endif; ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<ul id="bps-groups-list" class="">

		<?php while ( bp_groups() ) : bp_the_group(); ?>

			<li class="bps-item-entry" id="groud_id_<?php bp_group_id(); ?>">
				<div class="bps-list-wrap">
				<?php
				$active_theme = wp_get_theme(); 
				if( 'BuddyX' == $active_theme || 'BuddyxPro' == $active_theme ){
					buddyx_render_group_cover_image();
				}elseif( 'REIGN' == $active_theme ){
					reign_render_group_cover_image();
				}
				 ?>
					<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
						<div class="bps-item-avatar">
							<a href="<?php bp_group_url(); ?>"><?php bp_group_avatar( bp_nouveau_avatar_args() ); ?></a>
						</div>
					<?php endif; ?>

					<div class="bps-item">

						<div class="bps-item-block">

							<h2 class="bps-list-title bps-groups-title"><?php bp_group_link(); ?></h2>

							<?php if ( bp_nouveau_group_has_meta() ) : ?>

								<p class="bps-item-meta bps-group-details">
									<?php 
									if ( function_exists( 'buddypress' ) && ! isset( buddypress()->buddyboss ) ) {
										bp_nouveau_the_group_meta( array( 'keys' => array( 'status', 'count' ) ) ); 
									}else{
										$meta = bp_nouveau_get_group_meta();
										echo wp_kses_post( $meta['status'] );
									}
									?>
									</p>

							<?php endif; ?>

							<p class="bps-last-activity bps-item-meta">
								<?php
									printf(
										/* translators: %s: last activity timestamp (e.g. "Active 1 hour ago") */
										esc_html__( 'Active %s', 'shortcodes-for-buddypress' ),
										sprintf(
											'<span data-livestamp="%1$s">%2$s</span>',
											bp_core_get_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ),
											esc_html( bp_get_group_last_active() )
										)
									);
								?>
							</p>
						</div>	
						
						<?php if ( function_exists( 'buddypress' ) && isset( buddypress()->buddyboss ) ) { ?>
							<div class="bps-group-members-wrap">
								<?php bb_groups_loop_members(); ?>
							</div>
						<?php } ?>
						<?php bp_nouveau_groups_loop_item(); ?>

					</div>

				</div>

			</li>

		<?php endwhile; ?>

	</ul>

<?php else : ?>

	<?php bp_nouveau_user_feedback( 'groups-loop-none' ); ?>

<?php endif; ?>

<?php
bp_nouveau_after_loop();
