<?php
/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @since 3.0.0
 * @version 10.0.0
 */

bp_nouveau_activity_hook( 'before', 'entry' ); ?>

<li class="bps-activity-item">

	<div class="bps-activity-meta">

		<a href="<?php bp_activity_user_link(); ?>">

			<?php bp_activity_avatar( array( 'type' => 'full' ) ); ?>

		</a>

	</div>

	<div class="bps-activity-avatar">

		<div class="bps-activity-header">

			<?php bp_activity_action(); ?>

		</div>

		<?php if ( bp_nouveau_activity_has_content() ) : ?>

			<div class="bps-activity-inner">

				<?php bp_get_template_part( 'activity/type-parts/content',  bp_activity_type_part() ); ?>

			</div>

		<?php endif; ?>

		<?php bp_nouveau_activity_entry_buttons(); ?>

	</div>

</li>

<?php
bp_nouveau_activity_hook( 'after', 'entry' );
