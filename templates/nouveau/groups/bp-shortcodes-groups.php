<?php
/**
 * BuddyPress - Groups Directory Template for Shortcodes
 *
 * This template displays BuddyPress groups when used with the
 * [groups-listing] shortcode. It's designed to work with the BuddyPress
 * Nouveau template pack and supports various display options.
 *
 * @since 3.0.0
 * @version 12.0.0
 */
defined( 'ABSPATH' ) || exit;

?>
<?php
// Main container with BuddyPress classes
// The bp_nouveau_get_container_classes() function adds appropriate styling classes
?>
<div id="buddypress" class="<?php echo esc_attr( bp_nouveau_get_container_classes() ); ?>">

	<?php
	// Main groups directory container
	// data-bp-list="groups" enables BuddyPress JavaScript functionality
	// data-ajax="false" disables AJAX loading (controlled by shortcode)
	?>
	<div id="groups-dir-list" class="groups dir-list" data-bp-list="groups" data-ajax="false">

		<?php
		// Display group type message if a specific group type is being viewed
		// This shows which category of groups is currently being displayed
		?>
		<?php if ( bp_get_current_group_directory_type() ) : ?>
			<p class="current-group-type"><?php bp_current_group_directory_type_message(); ?></p>
		<?php endif;  ?>

		<?php
		// Start the groups loop if groups are found
		// The $query variable is passed from the shortcode class
		?>
		<?php if ( bp_has_groups( $query ) ) : ?>
		
			<?php
			// Display the total number of groups found
			// Uses the BuddyPress pagination count function
			?>
			<div class="bpsp-group-count">
				<?php
				$pagination_count = bp_get_groups_pagination_count();
				if ( ! empty( $pagination_count ) ) {
					echo wp_kses_post( $pagination_count );
				}
				?>
			</div>

			<?php
			// Groups list container
			// The $classes variable is passed from the shortcode class and controls the layout
			?>
			<ul id="groups-list" class="<?php echo esc_attr( $classes ); ?>">
				<?php
				// Loop through each group
				while ( bp_groups() ) :
					bp_the_group(); // Set up the current group
					?>

					<?php
					// Individual group list item
					// data-bp-item-id and data-bp-item-component are used by BuddyPress JavaScript
					?>
					<li <?php bp_group_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups">
						<div class="list-wrap">

							<?php
							// Display group cover image if supported by the theme
							// Uses a custom function defined in the plugin
							?>
							<?php bp_shortcode_member_cover(); ?>

							<?php
							// Group avatar section
							// Only displayed if group avatars are not disabled in BuddyPress settings
							?>
							<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
								<div class="item-avatar">
									<a href="<?php bp_group_url(); ?>"><?php bp_group_avatar( bp_nouveau_avatar_args() ); ?></a>
								</div>
							<?php endif; ?>

							<div class="item">

								<div class="item-block">

									<?php
									// Group title with link to group
									// bp_group_link() outputs a linked group name
									?>
									<h2 class="list-title groups-title"><?php bp_group_link(); ?></h2>

									<?php
									// Group meta information (status, member count)
									// Only displayed if the group has meta information
									?>
									<?php if ( bp_nouveau_group_has_meta() ) : ?>

										<p class="item-meta group-details"><?php bp_nouveau_the_group_meta( array( 'keys' => array( 'status', 'count' ) ) ); ?></p>

									<?php endif; ?>

									<?php
									// Last activity timestamp
									// Shows when the group was last active
									?>
									<p class="last-activity item-meta">
										<?php
											printf(
												/* translators: %s: last activity timestamp (e.g. "Active 1 hour ago") */
												esc_html__( 'Active %s', 'shortcodes-for-buddypress' ),
												sprintf(
													'<span data-livestamp="%1$s">%2$s</span>',
													esc_attr( bp_core_get_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ) ),
													esc_html( bp_get_group_last_active() )
												)
											);
										?>
									</p>

									<?php
									// Group action buttons (join, leave, etc.)
									// Displays buttons based on the user's relationship with the group
									?>
									<?php bp_nouveau_groups_loop_buttons(); ?>
								</div>

								<?php
								// Group description excerpt
								// Shows a short preview of the group description
								?>
								<div class="group-desc"><p><?php bp_nouveau_group_description_excerpt(); ?></p></div>

								<?php
								// Hook for plugins to add custom content to group items
								?>
								<?php bp_nouveau_groups_loop_item(); ?>

							</div>

						</div>

					</li>

				<?php endwhile; ?>

			</ul>
			
			<?php
			// Pagination section
			// Only displayed if pagination is enabled in the shortcode
			?>
			<?php if ( $groups_atts['per_page'] ) { ?>
			<div class="bp-pagination">
				<div class="bpsp-group-pagination bp-pagination-links bottom">
					<?php
					$pagination_links = bp_get_groups_pagination_links();
					if ( ! empty( $pagination_links ) ) {
						echo wp_kses_post( $pagination_links );
					}
					?>
				</div>
			</div>
			<?php } ?>
			
		<?php
		// Display a message if no groups are found
		else :
		?>

			<?php bp_nouveau_user_feedback( 'groups-loop-none' ); ?>

		<?php endif; ?>

	</div>
</div>
