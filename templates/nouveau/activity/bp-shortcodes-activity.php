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
	echo '<div id="buddypress" class="bp-dir-hori-nav ' . esc_attr( bp_nouveau_get_container_classes() ) . ' ' . esc_attr( $activity_atts['container_class'] ) . '">';
	if ( bp_has_activities( $activity_atts ) ) {
	}
	bp_nouveau_before_activity_directory_content(); ?>
	
	<input type="hidden" id="activity_filters_objects" data-bp-filter="activity" value="<?php echo esc_attr( $activity_atts['bpsh_query'] ); ?>" />	

	<div class="screen-content">
		<?php bp_nouveau_activity_hook( 'before_directory', 'list' ); ?>
		<div id="activity-stream" class="activity" data-bp-list="activity" data-ajax="false">
		<ul class="activity-list item-list bp-list">
			<?php //bp_get_template_part( 'activity/activity-loop' ); ?>
			<?php
			while ( bp_activities() ) :
				bp_the_activity();
				?>
				<?php buddypress_shortcodes_template('nouveau/activity/buddypress-shortcode-entry.php'); ?>
			<?php endwhile; ?>
		</ul>
	</div>
	</div>
	<?php

	if ( $activity_atts['use_compat'] ) {
		echo '</div>';
	}
}

remove_filter( 'bp_current_component', $current_activity_component );
