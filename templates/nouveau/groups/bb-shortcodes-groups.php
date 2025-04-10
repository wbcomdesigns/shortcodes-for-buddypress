<?php
/**
 * BuddyBoss - Groups Loop
 *
 * This template can be overridden by copying it to yourtheme/buddypress/groups/groups-loop.php.
 *
 * @since   BuddyPress 3.0.0
 * @version 1.0.0
 *
 * @package BuddyBoss\Core
 */

add_filter( 'bp_get_group_description_excerpt', 'bb_get_group_description_excerpt_view_more', 99, 2 );

bp_nouveau_before_loop();
?>

<div id="buddypress" class="<?php echo esc_attr( bp_nouveau_get_container_classes() ); ?>">
		<div id="groups-dir-list" class="groups dir-list" data-bp-list="groups" data-ajax="false">
<?php
$cover_class        = ! bb_platform_group_element_enable( 'cover-images' ) ? 'bb-cover-disabled' : 'bb-cover-enabled';
$meta_privacy       = ! bb_platform_group_element_enable( 'group-privacy' ) ? 'meta-privacy-hidden' : '';
$meta_group_type    = ! bb_platform_group_element_enable( 'group-type' ) ? 'meta-group-type-hidden' : '';
$group_members      = ! bb_platform_group_element_enable( 'members' ) ? 'group-members-hidden' : '';
$join_button        = ! bb_platform_group_element_enable( 'join-buttons' ) ? 'group-join-button-hidden' : '';
$group_alignment    = bb_platform_group_grid_style( 'left' );
$group_cover_height = function_exists( 'bb_get_group_cover_image_height' ) ? bb_get_group_cover_image_height() : 'small';


if ( bp_has_groups( $query ) ) {
	?>
		<div class="bpsp-group-count">	
			<?php echo bp_get_groups_pagination_count(); ?>
		</div>
		<ul id="groups-list" class="bb-platform-shortcode <?php bp_nouveau_loop_classes(); ?><?php echo esc_attr( ' ' . $cover_class . ' ' . $group_alignment ); ?> <?php echo esc_attr( $classes ); ?>">
			<?php
			while ( bp_groups() ) :
				bp_the_group();

				$bp_group_id = bp_get_group_id();
				?>

					<li <?php bp_group_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php echo esc_attr( $bp_group_id ); ?>" data-bp-item-component="groups">						

						<div class="list-wrap">
						
						<?php
						$active_theme = wp_get_theme()->get( 'Name' );

						// Group Cover Image Rendering.
						if ( ! bp_disable_group_cover_image_uploads() && bb_platform_group_element_enable( 'cover-images' ) ) {
							if ( in_array( $active_theme, [ 'BuddyX', 'BuddyxPro' ], true ) && function_exists( 'buddyx_render_group_cover_image' ) ) {
								buddyx_render_group_cover_image();
							} elseif ( $active_theme === 'REIGN' && function_exists( 'reign_render_group_cover_image' ) ) {
								reign_render_group_cover_image();
							} else {
								$group_cover_image_url = bp_attachments_get_attachment( 'url', array(
									'object_dir' => 'groups',
									'item_id'    => $bp_group_id,
								) );
								$has_default_cover = function_exists( 'bb_attachment_get_cover_image_class' ) ? bb_attachment_get_cover_image_class( $bp_group_id, 'group' ) : '';
								?>
								<div class="bs-group-cover bb-shortcode-group-only only-grid-view <?php echo esc_attr( $has_default_cover . ' cover-' . $group_cover_height ); ?>">
									<a href="<?php bp_group_permalink(); ?>">
										<?php if ( ! empty( $group_cover_image_url ) ) : ?>
											<img src="<?php echo esc_url( $group_cover_image_url ); ?>" alt="Group Cover">
										<?php endif; ?>
									</a>
								</div>
								<?php
							}
						}

						if ( ! bp_disable_group_avatar_uploads() && bb_platform_group_element_enable( 'avatars' ) ) {
							?>
								<div class="item-avatar"><a href="<?php bp_group_permalink(); ?>" class="group-avatar-wrap"><?php bp_group_avatar( bp_nouveau_avatar_args() ); ?></a></div>
								<?php
						}
						?>
							<?php if ( $active_theme === 'REIGN' ) : ?>
							<div class="group-content-wrap">
							<?php endif; ?>
								<div class="item <?php echo esc_attr( $group_members . ' ' . $join_button ); ?>">

									<div class="group-item-wrap">
										<div class="item-block">
											<h2 class="list-title groups-title"><?php bp_group_link(); ?></h2>
											<div class="item-meta-wrap <?php echo esc_attr( bb_platform_group_element_enable( 'last-activity' ) || empty( $meta_privacy ) || empty( $meta_group_type ) ? 'has-meta' : 'meta-hidden' ); ?> ">

											<?php if ( bp_nouveau_group_has_meta() ) { ?>

													<p class="item-meta group-details <?php echo esc_attr( $meta_privacy . ' ' . $meta_group_type ); ?>">
														<?php
														$meta = bp_nouveau_get_group_meta();
														echo wp_kses_post( $meta['status'] );
														?>
													</p>
													<?php
											}

											if ( bb_platform_group_element_enable( 'last-activity' ) ) {
												echo '<p class="last-activity item-meta">' .
												sprintf(
														/* translators: %s = last activity timestamp (e.g. "active 1 hour ago") */
													esc_attr__( 'Active %s', 'shortcodes-for-buddypress' ),
													wp_kses_post( bp_get_group_last_active() )
												) .
												'</p>';
											}
											?>

											</div>
										</div>

										<?php if ( bb_platform_group_element_enable( 'group-descriptions' ) ) { ?>
											<div class="item-desc group-item-desc only-list-view"><?php bp_group_description_excerpt( false, 150 ); ?></div>
										<?php } ?>
									</div>

									<?php bp_nouveau_groups_loop_item(); ?>

									<div class="group-footer-wrap <?php echo esc_attr( $group_members . ' ' . $join_button ); ?>">
										<div class="group-members-wrap">
											<?php bb_groups_loop_members(); ?>
										</div>
										<?php if ( bb_platform_group_element_enable( 'join-buttons' ) ) { ?>
											<div class="groups-loop-buttons footer-button-wrap"><?php bp_nouveau_groups_loop_buttons(); ?></div>
										<?php } ?>
									</div>

								</div>
							<?php if ( $active_theme === 'REIGN' ) : ?>
							</div>
							<?php endif; ?>
						</div>
					</li>

				<?php endwhile; ?>
			</ul>
			
			<?php if ( $groups_atts['per_page'] ) { ?>
			<div class="bp-pagination">
				<div class="bpsp-group-pagination bp-pagination-links bottom">	
					<?php echo wp_kses_post( bp_get_groups_pagination_links() ); ?>
				</div>
			</div>
			<?php } ?>
		<?php
} else {
	bp_nouveau_user_feedback( 'groups-loop-none' );
}
?>
	</div>
</div>
<?php
bp_nouveau_after_loop();

remove_filter( 'bp_get_group_description_excerpt', 'bb_get_group_description_excerpt_view_more', 99, 2 );
