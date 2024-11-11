<?php
global $activity_atts;

// echo '<pre>';print_r($activity_atts);echo '</pre>';
/**
 * Fires before the activity directory listing.
 *
 * @since 1.5.0
 */

do_action( 'bp_before_directory_activity' );

if ( $activity_atts['use_compat'] ) {
	echo '<div id="buddypress" class="bp-dir-hori-nav ' . esc_attr( $activity_atts['container_class'] ) . '">';
}
if( empty( $atts ) ){
	$atts = array();
}

 ?>
<?php
if ( $activity_atts['allow_posting'] == 'true' && is_user_logged_in() ) :
	bp_get_template_part( 'activity/post-form' );
endif;
?>
<?php do_action( 'before_activity_listing_output', $atts, $activity_atts ); ?>

<?php if ( bp_has_activities( $activity_atts['bpsh_query'] ) ) : ?>
	<div id="activity" class="activity" aria-atomic="true" aria-relevant="all" aria-live="polite">
		<ul id="activity-stream" class="activity-list item-list">
            <?php do_action( 'youzify_before_activity_loop_posts' ); ?>

            <?php while ( bp_activities() ) : bp_the_activity(); ?>

                <?php bp_get_template_part( 'activity/entry' ); ?>

            <?php endwhile; ?>

            <?php if ( bp_activity_has_more_items() ) :?>
                <a href="<?php bp_activity_load_more_link(); ?>"><i class="fas fa-level-down-alt"></i><?php echo esc_html__( 'Load More Posts', 'shortcodes-for-buddypress' ); ?></a>
            <?php endif; ?>
		</ul>
    </div>
<?php else : ?>
    <div id="message" class="info">
		<p><?php echo esc_html__( 'There were no activities found.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
<?php endif; ?>

<?php do_action( 'after_activity_listing_output', $atts, $activity_atts ); ?>

<?php
if ( $activity_atts['use_compat'] ) {
	echo '</div>';
}
