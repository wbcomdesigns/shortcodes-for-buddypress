<?php
/**
 * BuddyPress - Activity Directory Template for Shortcodes
 *
 * This template displays BuddyPress activity streams when used with the
 * [activity-listing] shortcode. It's designed to work with the BuddyPress
 * Nouveau template pack and supports various display options.
 *
 * @since 3.0.0
 * @version 12.0.0
 */
?>
<?php
// Main container with BuddyPress classes
// The bp_nouveau_get_container_classes() function adds appropriate styling classes
?>
<div id="buddypress" class="<?php echo esc_attr( bp_nouveau_get_container_classes() ); ?>">

		<?php
		// Activity posting form section
		// Only displayed if the 'allow_posting' parameter is set to true in the shortcode
		?>
		<?php if ( $allow_posting ) : ?>
			<?php
			// Special handling for BuddyBoss Platform
			// Loads additional scripts needed for the activity form in BuddyBoss
			?>
			<?php if ( function_exists( 'buddypress' ) && isset( buddypress()->buddyboss ) ) : ?>
				<?php
				// Enqueue necessary scripts for the activity posting form
				wp_enqueue_script( 'bp-nouveau-activity-post-form' );
				if ( wp_script_is( 'bp-nouveau-activity-reacted', 'registered' ) ) {
					wp_enqueue_script( 'bp-nouveau-activity-reacted' );
				}

				// If reaction is enabled for activity post or comment then load the template
				if ( function_exists( 'bb_load_reaction_popup_modal_js_template' ) ) {
					bb_load_reaction_popup_modal_js_template();
				}
				?>
			<?php endif; ?>	
			<?php
			// Load the activity posting form template
			bp_get_template_part( 'activity/post-form' );
			?>
		<?php endif; ?>

		<div class="screen-content">
			<?php
			// The search and filters bar is commented out by default
			// Uncomment to add filtering options to the activity stream
			// bp_get_template_part( 'common/search-and-filters-bar' );
			?>

			<?php
			// Hook for plugins to add content before the activity list
			bp_nouveau_activity_hook( 'before_directory', 'list' );
			?>

			<?php
			// Main activity stream container
			// data-bp-list="activity" enables BuddyPress JavaScript functionality
			// data-ajax="false" disables AJAX loading (controlled by shortcode)
			// data-query contains the query string for filtering activities
			?>
			<div id="activity-stream" class="activity" data-bp-list="activity" data-ajax="false" data-query="<?php echo esc_attr($query);?>">

				<?php
				// Before loop hook - used by BuddyPress to set up the activity loop
				bp_nouveau_before_loop();
				?>

				<?php
				// Start the activity loop if activities are found
				if ( bp_has_activities( $query ) ) :
				?>
					
					<ul class="activity-list item-list bp-list">

					<?php
					// Loop through each activity item
					while ( bp_activities() ) :
						bp_the_activity(); // Set up the current activity
						?>

						<?php
						// Load the template for individual activity entries
						bp_get_template_part( 'activity/entry' );
						?>

					<?php endwhile; ?>
					
						<?php
						// "Load More" button section
						// Displayed if:
						// 1. The 'load_more' parameter is true, OR
						// 2. The max number of activities is greater than the per_page value
						?>
						<?php if ( $load_more || ( isset($activity_atts['max']) && $activity_atts['per_page'] ) && $activity_atts['max'] > $activity_atts['per_page'] ) : ?>
						
							<li class="load-more" data-query="<?php echo esc_attr($query);?>">
								<a class="button" id="load-more-activity" href="<?php bp_activity_load_more_link(); ?>" data-limit='<?php echo esc_attr( $activity_atts['per_page'] ); ?>' data-page="2" data-query="<?php echo esc_attr($query);?>"><?php echo esc_html__( 'Load More', 'shortcodes-for-buddypress' ); ?></a>
							</li>
						<?php endif; ?>

					</ul>
						
				<?php
				// Display a message if no activities are found
				else :
				?>

						<?php bp_nouveau_user_feedback( 'activity-loop-none' ); ?>

				<?php endif; ?>

				<?php
				// After loop hook - used by BuddyPress to clean up after the activity loop
				bp_nouveau_after_loop();
				?>

			</div><!-- .activity -->

			<?php
			// Hook for plugins to add content after the activity directory
			bp_nouveau_after_activity_directory_content();
			?>

		</div><!-- // .screen-content -->
	
	<?php
	// Additional hooks for non-BuddyBoss themes
	// BuddyBoss handles this differently, so we only add it for standard BuddyPress
	?>
	<?php if ( function_exists( 'buddypress' ) && ! isset( buddypress()->buddyboss ) ) : ?>
		<?php bp_nouveau_after_directory_page(); ?>
	<?php endif; ?>
</div>
