<?php
/**
 * BuddyPress - Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
/**
 * Fires at the top of the members directory template file.
 *
 * @since 1.5.0
 */
do_action('bp_before_directory_members_page');

if ($atts['use_compat']) {
    echo '<div id="buddypress">';
}


/**
 * Fires before the display of the members.
 *
 * @since 1.1.0
 */
do_action('bp_before_directory_members');
?>

<?php
/**
 * Fires before the display of the members content.
 *
 * @since 1.1.0
 */
do_action('bp_before_directory_members_content');
?>

<?php /* Backward compatibility for inline search form. Use template part instead. */ ?>
<?php if (has_filter('bp_directory_members_search_form')) : ?>

    <div id="members-dir-search" class="dir-search" role="search">
        <?php bp_directory_members_search_form(); ?>
    </div><!-- #members-dir-search -->

<?php else: ?>

    <?php bp_get_template_part('common/search/dir-search-form'); ?>

<?php endif; ?>

<?php
/**
 * Fires before the display of the members list tabs.
 *
 * @since 1.8.0
 */
do_action('bp_before_directory_members_tabs');
?>

<form action="" method="post" id="members-directory-form" class="dir-form">

    <div class="item-list-tabs" id="subnav" aria-label="<?php esc_attr_e('Members directory secondary navigation', 'buddypress'); ?>" role="navigation">
        <ul>
            <?php
            /**
             * Fires inside the members directory member sub-types.
             *
             * @since 1.5.0
             */
            do_action('bp_members_directory_member_sub_types');
            ?>

            <li id="members-order-select" class="last filter">
                <label for="bpsh-members-order-by"><?php _e('Order By:', 'buddypress'); ?></label>
                <select id="bpsh-members-order-by">
                    <option value="active"><?php _e('Last Active', 'buddypress'); ?></option>
                    <option value="newest"><?php _e('Newest Registered', 'buddypress'); ?></option>

                    <?php if (bp_is_active('xprofile')) : ?>
                        <option value="alphabetical"><?php _e('Alphabetical', 'buddypress'); ?></option>
                    <?php endif; ?>

                    <?php
                    /**
                     * Fires inside the members directory member order options.
                     *
                     * @since 1.2.0
                     */
                    do_action('bp_members_directory_order_options');
                    ?>
                </select>
            </li>
        </ul>
    </div>

    <h2 class="bp-screen-reader-text"><?php
        /* translators: accessibility text */
        _e('Members directory', 'buddypress');
        ?></h2>

    <div id="members-dir-list" class="members dir-list">
        <?php
        //----------------------------------------------------------------------
        /**
         * Fires before the display of the members loop.
         *
         * @since 1.2.0
         */
        do_action('bp_before_members_loop');
        ?>

        <?php if (bp_get_current_member_type()) : ?>
            <p class="current-member-type"><?php bp_current_member_type_message() ?></p>
        <?php endif;
        ?>

        <?php if (bp_has_members($atts)) : ?>

            <div id="pag-top" class="pagination">

                <div class="pag-count" id="member-dir-count-top">

                    <?php bp_members_pagination_count(); ?>

                </div>

                <div class="pagination-links" id="member-dir-pag-top">

                    <?php bp_members_pagination_links(); ?>

                </div>

            </div>

            <?php
            /**
             * Fires before the display of the members list.
             *
             * @since 1.1.0
             */
            do_action('bp_before_directory_members_list');
            ?>

            <ul id="members-list" class="item-list" aria-live="assertive" aria-relevant="all">

                <?php while (bp_members()) : bp_the_member(); ?>

                    <li <?php bp_member_class(); ?>>
                        <div class="item-avatar">
                            <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
                        </div>

                        <div class="item">
                            <div class="item-title">
                                <a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>

                                <?php if (bp_get_member_latest_update()) : ?>

                                    <span class="update"> <?php bp_member_latest_update(); ?></span>

                                <?php endif; ?>

                            </div>

                            <div class="item-meta"><span class="activity" data-livestamp="<?php bp_core_iso8601_date(bp_get_member_last_active(array('relative' => false))); ?>"><?php bp_member_last_active(); ?></span></div>

                            <?php
                            /**
                             * Fires inside the display of a directory member item.
                             *
                             * @since 1.1.0
                             */
                            do_action('bp_directory_members_item');
                            ?>

                            <?php
                            /*                             * *
                             * If you want to show specific profile fields here you can,
                             * but it'll add an extra query for each member in the loop
                             * (only one regardless of the number of fields you show):
                             *
                             * bp_member_profile_data( 'field=the field name' );
                             */
                            ?>
                        </div>

                        <div class="action">

                            <?php
                            /**
                             * Fires inside the members action HTML markup to display actions.
                             *
                             * @since 1.1.0
                             */
                            do_action('bp_directory_members_actions');
                            ?>

                        </div>

                        <div class="clear"></div>
                    </li>

                <?php endwhile; ?>

            </ul>

            <?php
            /**
             * Fires after the display of the members list.
             *
             * @since 1.1.0
             */
            do_action('bp_after_directory_members_list');
            ?>

            <?php bp_member_hidden_fields(); ?>

            <div id="pag-bottom" class="pagination">

                <div class="pag-count" id="member-dir-count-bottom">

                    <?php bp_members_pagination_count(); ?>

                </div>

                <div class="pagination-links" id="member-dir-pag-bottom">

                    <?php bp_members_pagination_links(); ?>

                </div>

            </div>

        <?php else: ?>

            <div id="message" class="info">
                <p><?php _e("Sorry, no members were found.", 'buddypress'); ?></p>
            </div>

        <?php endif; ?>

        <?php
        /**
         * Fires after the display of the members loop.
         *
         * @since 1.2.0
         */
        do_action('bp_after_members_loop');
        //----------------------------------------------------------------------
        ?>
    </div><!-- #members-dir-list -->

    <?php
    /**
     * Fires and displays the members content.
     *
     * @since 1.1.0
     */
    do_action('bp_directory_members_content');
    ?>

    <?php wp_nonce_field('directory_members', '_wpnonce-member-filter'); ?>

    <?php
    /**
     * Fires after the display of the members content.
     *
     * @since 1.1.0
     */
    do_action('bp_after_directory_members_content');
    ?>

</form><!-- #members-directory-form -->

<?php
/**
 * Fires after the display of the members.
 *
 * @since 1.1.0
 */
do_action('bp_after_directory_members');


if ($atts['use_compat']) {
    echo '</div>';
}

/**
 * Fires at the bottom of the members directory template file.
 *
 * @since 1.5.0
 */
do_action('bp_after_directory_members_page');
//------------------------------------------------------------------------------