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

<li class="bps-activity-item" id="activity-<?php bp_activity_id(); ?>">

	<div class="bps-activity-item-head">
		<div class="bps-activity-avatar bps-item-avatar">
			<a href="<?php bp_activity_user_link(); ?>">
				<?php bp_activity_avatar( array( 'type' => 'full' ) ); ?>
			</a>
		</div>
		<div class="bps-activity-header">
			<?php bp_activity_action(); ?>
		</div>
	</div>

	<div class="bps-activity-content">
		<?php if ( bp_nouveau_activity_has_content() ) : ?>
			<div class="bps-activity-inner">
				<?php 
				if ( function_exists( 'buddypress' ) && ! isset( buddypress()->buddyboss ) ) {
					bp_get_template_part( 'activity/type-parts/content',  bp_activity_type_part() ); 
				} else{
					bp_nouveau_activity_content();
				}
				?>
			</div>
		<?php endif; ?>
	</div>
</li>

<?php
bp_nouveau_activity_hook( 'after', 'entry' );
