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
	if ( bp_has_activities( $activity_atts ) ) {
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
		<ul class="activity-list item-list bp-list">
			<?php //bp_get_template_part( 'activity/activity-loop' ); ?>
			<?php while ( bp_activities() ) : bp_the_activity(); ?>
						<?php bp_get_template_part( 'activity/entry' ); ?>
					<?php endwhile; ?>
		</ul>
	</div>
		<?php if ( $activity_atts['pagination'] && ! $activity_atts['load_more'] ) : ?>
                    <div class="pagination">
                        <div class="pag-count"><?php bp_activity_pagination_count(); ?></div>
                        <div class="pagination-links"><?php bp_activity_pagination_links(); ?></div>
                    </div>
				<?php endif; ?>
		<?php bp_nouveau_after_activity_directory_content(); ?>

	</div>
<?php

if ( $activity_atts['use_compat'] ) {
	echo '</div>';
}
}

remove_filter( 'bp_current_component', $current_activity_component );