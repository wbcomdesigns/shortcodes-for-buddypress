<?php
/**
 * Fires before the activity directory listing.
 *
 * @since 1.0.0
 */
$allow_posting = false;
$load_more = false;	
?>


<div id="buddypress">

	<?php

	/**
	 * Fires before the activity directory display content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_directory_activity_content' );
	?>

	<?php if ( $allow_posting && is_user_logged_in() ) : ?>

		<?php bp_get_template_part( 'activity/post-form' ); ?>

	<?php endif; ?>

	<div id="template-notices" role="alert" aria-atomic="false">
		<?php

		/**
		 * Fires towards the top of template pages for notice display.
		 *
		 * @since 1.0.0
		 */
		do_action( 'template_notices' );
		?>

	</div>
	<?php

	/**
	 * Fires before the display of the activity list.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_before_directory_activity_list' );
	?>

	<div class="activity" aria-live="polite" aria-atomic="false" aria-relevant="all">
		<?php
		/**
		 * Fires before the start of the activity loop.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_activity_loop' );
		?>

		<?php
		// Add error handling for BuddyPress compatibility issues
		$has_activities = false;
		$bp_error = false;

		// Validate and sanitize query before passing to BuddyPress
		$clean_query = '';
		if ( ! empty( $query ) ) {
			// If query is already a string, use it. If array, convert it properly
			if ( is_array( $query ) ) {
				$clean_query = http_build_query( $query );
			} else {
				$clean_query = $query;
			}
		}

		try {
			// Try with clean query first, fallback to basic query if it fails
			if ( ! empty( $clean_query ) ) {
				$has_activities = bp_has_activities( $clean_query );
			} else {
				// Fallback to basic activity query
				$has_activities = bp_has_activities( 'per_page=5' );
			}
		} catch ( TypeError $e ) {
			// Handle BuddyPress version compatibility issues - try basic query
			try {
				$has_activities = bp_has_activities( 'per_page=5' );
			} catch ( Exception $fallback_error ) {
				$has_activities = false;
				$bp_error = 'compatibility';
			}
		} catch ( Error $e ) {
			// Handle other PHP errors - try basic query
			try {
				$has_activities = bp_has_activities( 'per_page=5' );
			} catch ( Exception $fallback_error ) {
				$has_activities = false;
				$bp_error = 'general';
			}
		}

		if ( $has_activities ) :
		?>

			<ul id="activity-stream" class="activity-list item-list">
			
				<?php
				while ( bp_activities() ) :
					bp_the_activity();
					?>

					<?php bp_get_template_part( 'activity/entry' ); ?>
			
				<?php endwhile; ?>

				<?php if ( bp_activity_has_more_items() && false !== $load_more ) : ?>

					<li class="load-more">
						<a href="<?php bp_activity_load_more_link(); ?>"><?php esc_html_e( 'Load More', 'shortcodes-for-buddypress' ); ?></a>
					</li>

				<?php endif; ?>
			
			</ul>
		
		<?php else : ?>
			<?php if ( $bp_error === 'compatibility' ) : ?>
				<div id="message" class="error">
					<p><?php esc_html_e( 'Activity listing is temporarily unavailable due to BuddyPress compatibility issues. Please contact the site administrator.', 'shortcodes-for-buddypress' ); ?></p>
				</div>
			<?php elseif ( $bp_error === 'general' ) : ?>
				<div id="message" class="error">
					<p><?php esc_html_e( 'Activity listing is temporarily unavailable. Please try again later.', 'shortcodes-for-buddypress' ); ?></p>
				</div>
			<?php else : ?>
				<div id="message" class="info">
					<p><?php esc_html_e( 'Sorry, no activities were found. Please try a different filter.', 'shortcodes-for-buddypress' ); ?></p>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<?php

		/**
		 * Fires after the finish of the activity loop.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_activity_loop' );
		?>

	</div><!-- .activity -->

</div>
