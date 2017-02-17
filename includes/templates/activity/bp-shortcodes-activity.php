<?php
/**
 * BuddyPress Activity templates
 *
 * @since 2.3.0
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
/**
 * Fires before the activity directory listing.
 *
 * @since 1.5.0
 */
do_action('bp_before_directory_activity');

if ($atts['use_compat']) {
    echo '<div id="buddypress">';
}
/**
 * Fires before the activity directory display content.
 *
 * @since 1.2.0
 */
do_action('bp_before_directory_activity_content');
?>

<?php if (is_user_logged_in()) : ?>

    <?php bp_get_template_part('activity/post-form'); ?>

<?php endif; ?>

<div id="template-notices" role="alert" aria-atomic="true">
    <?php
    /**
     * Fires towards the top of template pages for notice display.
     *
     * @since 1.0.0
     */
    do_action('template_notices');
    ?>

</div>

<div class="item-list-tabs no-ajax" id="subnav" aria-label="<?php esc_attr_e('Activity secondary navigation', 'buddypress'); ?>" role="navigation">
    <ul>
        <?php
        /**
         * Fires before the display of the activity syndication options.
         *
         * @since 1.2.0
         */
        do_action('bp_activity_syndication_options');
        ?>

        <li id="activity-filter-select" class="last">
            <label for="activity-filter-by"><?php _e('Show:', 'buddypress'); ?></label>
            <select id="activity-filter-by">
                <option value="-1"><?php _e('&mdash; Everything &mdash;', 'buddypress'); ?></option>

                <?php bp_activity_show_filters(); ?>

                <?php
                /**
                 * Fires inside the select input for activity filter by options.
                 *
                 * @since 1.2.0
                 */
                do_action('bp_activity_filter_options');
                ?>

            </select>
        </li>
    </ul>
</div><!-- .item-list-tabs -->

<?php
/**
 * Fires before the display of the activity list.
 *
 * @since 1.5.0
 */
do_action('bp_before_directory_activity_list');
?>

<div class="activity" aria-live="polite" aria-atomic="true" aria-relevant="all">

    <?php
    /**
     * BuddyPress - Activity Loop
     *
     * @package BuddyPress
     * @subpackage bp-legacy
     */
    /**
     * Fires before the start of the activity loop.
     *
     * @since 1.2.0
     */
    do_action('bp_before_activity_loop');
    ?>

    <?php
    if (!empty($bpsh_query)) {
        $bpsh_query = '&' . $bpsh_query;
    }
    if (bp_has_activities(bp_ajax_querystring('activity').$bpsh_query)) :
        ?>

        <?php if (empty($_POST['page'])) : ?>

            <ul id="activity-stream" class="activity-list item-list">

            <?php endif; ?>

            <?php while (bp_activities()) : bp_the_activity(); ?>

                <?php bp_get_template_part('activity/entry'); ?>

            <?php endwhile; ?>

            <?php if (bp_activity_has_more_items()) : ?>

                <li class="load-more">
                    <a href="<?php bp_activity_load_more_link() ?>"><?php _e('Load More', 'buddypress'); ?></a>
                </li>

            <?php endif; ?>

            <?php if (empty($_POST['page'])) : ?>

            </ul>

        <?php endif; ?>

    <?php else : ?>

        <div id="message" class="info">
            <p><?php _e('Sorry, there was no activity found. Please try a different filter.', 'buddypress'); ?></p>
        </div>

    <?php endif; ?>

    <?php
    /**
     * Fires after the finish of the activity loop.
     *
     * @since 1.2.0
     */
    do_action('bp_after_activity_loop');
    ?>

    <?php if (empty($_POST['page'])) : ?>

        <form action="" name="activity-loop-form" id="activity-loop-form" method="post">

            <?php wp_nonce_field('activity_filter', '_wpnonce_activity_filter'); ?>

        </form>

    <?php endif; ?>


</div><!-- .activity -->

<?php
/**
 * Fires after the display of the activity list.
 *
 * @since 1.5.0
 */
do_action('bp_after_directory_activity_list');
?>

<?php
/**
 * Fires inside and displays the activity directory display content.
 */
do_action('bp_directory_activity_content');
?>

<?php
/**
 * Fires after the activity directory display content.
 *
 * @since 1.2.0
 */
do_action('bp_after_directory_activity_content');
?>

<?php
/**
 * Fires after the activity directory listing.
 *
 * @since 1.5.0
 */
do_action('bp_after_directory_activity');

if ($atts['use_compat']) {
    echo '</div>';
}
