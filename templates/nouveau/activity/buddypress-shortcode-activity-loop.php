<?php
/**
 * BuddyPress - Activity Loop
 *
 * @version 3.1.0
 */

bp_nouveau_before_loop(); ?>

<?php if ( bp_has_activities( bp_ajax_querystring( 'activity' ) ) ) : ?>

	<?php if ( empty( $_POST['page'] ) || 1 === (int) $_POST['page'] ) : ?>
		<ul class="activity-list bps-item-list bp-list">
	<?php endif; ?>

	<?php
	while ( bp_activities() ) :
		bp_the_activity();
	?>
	<?php buddypress_shortcodes_template('nouveau/activity/buddypress-shortcode-entry.php'); ?>

	<?php endwhile; ?>

	<?php if ( empty( $_POST['page'] ) || 1 === (int) $_POST['page'] ) : ?>
		</ul>
	<?php endif; ?>

<?php else : ?>

		<?php bp_nouveau_user_feedback( 'activity-loop-none' ); ?>

<?php endif; ?>

<?php bp_nouveau_after_loop(); ?>
