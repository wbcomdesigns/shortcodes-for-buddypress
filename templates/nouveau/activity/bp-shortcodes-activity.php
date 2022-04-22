<?php
global $activity_atts;
add_filter(
	'bp_ajax_querystring',
	function( $qs ) {
		global $activity_atts;
		return $qs .= $activity_atts['bpsh_query'];
	}
);

$current_activity_component = static function () {
	return 'activity';
};

add_filter( 'bp_current_component', $current_activity_component );

/**
 * Fires before the activity directory listing.
 *
 * @since 1.0.0
 */

/**
 * Fires before the activity directory listing.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_directory_activity' );

if ( $activity_atts['use_compat'] ) {
	echo '<div id="buddypress" class="bp-activity-shortcode buddypress-wrap bp-dir-hori-nav ' . esc_attr( $activity_atts['container_class'] ) . '">';
}
	bp_nouveau_before_activity_directory_content(); ?>

	<?php if ( $activity_atts['allow_posting'] == 'true' && is_user_logged_in() ) : ?>

		<?php bp_get_template_part( 'activity/post-form' ); ?>

	<?php endif; ?>
	
	<input type="hidden" id="activity_filters_objects" data-bp-filter="activity" value="<?php echo esc_attr( $activity_atts['bpsh_query'] ); ?>" />
	<?php bp_nouveau_before_activity_directory_content(); ?>

	<div class="screen-content">
		<?php bp_nouveau_activity_hook( 'before_directory', 'list' ); ?>

		<div id="activity-stream" class="activity" data-bp-list="activity" data-ajax="false">
			<?php bp_get_template_part( 'activity/activity-loop' ); ?>
		</div>

		<?php bp_nouveau_after_activity_directory_content(); ?>

	</div>
	<style>
		#buddypress.bp-activity-shortcode .load-more{ display:none}
	</style>
<?php

if ( $activity_atts['use_compat'] ) {
	echo '</div>';
}

remove_filter( 'bp_current_component', $current_activity_component );