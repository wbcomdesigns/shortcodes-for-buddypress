<?php
/**
 * BuddyPress - Members Directory Template for Shortcodes
 *
 * This template displays BuddyPress members when used with the
 * [members-listing] shortcode. It's designed to work with the BuddyPress
 * Nouveau template pack and supports various display options.
 *
 * @since   3.0.0
 * @version 6.0.0
 *
 * @package Shortcodes_For_BuddyPress
 */

defined( 'ABSPATH' ) || exit;
?>
<?php
// Main container with BuddyPress classes.
// The bp_nouveau_get_container_classes() function adds appropriate styling classes.
?>
<div id="buddypress" class="<?php echo esc_attr( bp_nouveau_get_container_classes() ); ?>">

	<?php
	// Main members directory container.
	// data-bp-list="members" enables BuddyPress JavaScript functionality.
	?>
	<div id="members-dir-list" class="members dir-list" data-bp-list="members"  data-ajax="false">
		
		<?php
		// Display member type message if a specific member type is being viewed.
		// This shows which category of members is currently being displayed.
		if ( bp_get_current_member_type() ) :
			?>
			<p class="current-member-type"><?php bp_current_member_type_message(); ?></p>
		<?php endif; ?>

		<?php
		// Start the members loop if members are found.
		// The $query variable is passed from the shortcode class.
		if ( bp_has_members( $query ) ) :
			?>
			
			<?php
			// Display the total number of members found.
			// Uses the BuddyPress pagination count function.
			?>
			<div class="bpsp-member-count">
				<?php
				$pagination_count = bp_get_members_pagination_count();
				if ( ! empty( $pagination_count ) ) {
					echo wp_kses_post( $pagination_count );
				}
				?>
			</div>
			
			<?php
			// Members list container.
			// The $classes variable is passed from the shortcode class and controls the layout.
			?>
			<ul id="members-list" class="<?php echo esc_attr( $classes ); ?>" >

			<?php
			// Loop through each member.
			while ( bp_members() ) :
				bp_the_member(); // Set up the current member.
				?>

				<?php
				// Individual member list item.
				// data-bp-item-id and data-bp-item-component are used by BuddyPress JavaScript.
				?>
				<li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_member_user_id(); ?>" data-bp-item-component="members">
					<div class="list-wrap">

						<?php
						// Display member cover image if supported by the theme.
						// Uses a custom function defined in the plugin.
						?>
						<?php bp_shortcode_member_cover(); ?>

						<?php
						// Member avatar section.
						// Links to the member's profile.
						?>
						<div class="item-avatar">
							<a href="<?php bp_member_permalink(); ?>">
								<?php
								$member_avatar = bp_member_avatar( bp_nouveau_avatar_args() );
								if ( ! empty( $member_avatar ) ) {
									echo wp_kses_post( $member_avatar );
								}
								?>
							</a>
						</div>

						<div class="item">

							<div class="item-block">

								<?php
								// Member name with link to profile.
								// bp_member_name() outputs the member's display name.
								?>
								<h2 class="list-title member-name">
									<a href="<?php bp_member_permalink(); ?>">
										<?php
										$member_name = bp_member_name();
										if ( ! empty( $member_name ) ) {
											echo esc_html( $member_name );
										}
										?>
									</a>
								</h2>

								<?php
								// Member meta information (last active, etc.).
								// Only displayed if the member has meta information.
								?>
								<?php if ( bp_nouveau_member_has_meta() ) : ?>
									<p class="item-meta last-activity">
										<?php
										// bp_nouveau_member_meta() echoes directly, no need for wp_kses_post.
										bp_nouveau_member_meta();
										?>
									</p><!-- .item-meta -->
								<?php endif; ?>

								<?php
								// Extra content for the member.
								// Only displayed if the member has extra content.
								?>
								<?php if ( bp_nouveau_member_has_extra_content() ) : ?>
									<div class="item-extra-content">
										<?php bp_nouveau_member_extra_content(); ?>
									</div><!-- .item-extra-content -->
								<?php endif; ?>

								<?php
								// Member action buttons (add friend, send message, etc.).
								// Displays buttons based on the user's relationship with the member.
								?>
								<?php
								bp_nouveau_members_loop_buttons(
									array(
										'container'      => 'ul',
										'button_element' => 'button',
									)
								);
								?>
							</div>

							<?php
							// Member's latest update.
							// Only displayed if the member has a latest update and the layout is not grid.
							?>
							<?php if ( bp_get_member_latest_update() && ! bp_nouveau_loop_is_grid() ) : ?>
								<div class="user-update">
									<?php
									$latest_update = bp_member_latest_update();
									if ( ! empty( $latest_update ) ) :
										?>
										<p class="update"><?php echo esc_html( $latest_update ); ?></p>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</div><!-- // .item -->
					</div>
				</li>

			<?php endwhile; ?>

			</ul>
			
			<?php
			// Pagination section.
			// Only displayed if pagination is enabled in the shortcode.
			?>
			<?php if ( ! empty( $members_atts['per_page'] ) ) : ?>
			<div class="bp-pagination">
				<div class="bpsp-member-pagination bp-pagination-links bottom">
					<?php
					$pagination_links = bp_get_members_pagination_links();
					if ( ! empty( $pagination_links ) ) {
						echo wp_kses_post( $pagination_links );
					}
					?>
				</div>
			</div>
			<?php endif; ?>
			
			<?php
			// Display a message if no members are found.
				// Display empty state with helpful message.
			else :
				$message = __( 'No members were found matching the current criteria.', 'shortcodes-for-buddypress' );

				// Add helpful suggestions based on query.
				if ( ! empty( $query ) ) {
					// If filtering by member type.
					if ( false !== strpos( $query, 'member_type=' ) ) {
						$message .= ' ' . __( 'Try selecting a different member type or removing the filter.', 'shortcodes-for-buddypress' );
					}

					// If searching.
					if ( false !== strpos( $query, 'search_terms=' ) ) {
						$message .= ' ' . __( 'Try using different search terms or browsing all members.', 'shortcodes-for-buddypress' );
					}
				}
				?>
			<div class="bp-feedback info">
				<span class="bp-icon" aria-hidden="true"></span>
				<p><?php echo esc_html( $message ); ?></p>
			</div>
				<?php

		endif;
			?>
	</div>

</div>
