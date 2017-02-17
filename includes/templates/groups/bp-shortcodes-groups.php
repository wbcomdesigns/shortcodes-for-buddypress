<?php
/**
 * BuddyPress - Groups
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
/**
 * Fires at the top of the groups directory template file.
 *
 * @since 1.5.0
 */
do_action('bp_before_directory_groups_page');

if ($atts['use_compat']) {
    echo '<div id="buddypress">';
}

/**
 * Fires before the display of the groups.
 *
 * @since 1.1.0
 */
do_action('bp_before_directory_groups');
?>

<?php
/**
 * Fires before the display of the groups content.
 *
 * @since 1.1.0
 */
do_action('bp_before_directory_groups_content');
?>

<?php /* Backward compatibility for inline search form. Use template part instead. */ ?>
<?php
require_once plugin_dir_path(dirname(__FILE__)) . 'groups/search.php';
?>
<form action="" method="post" id="groups-directory-form" class="dir-form">

    <div id="template-notices" role="alert" aria-atomic="true">
        <?php
        /** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
        do_action('template_notices');
        ?>

    </div>

    <div class="item-list-tabs" id="subnav" aria-label="<?php esc_attr_e('Groups directory secondary navigation', 'buddypress'); ?>" role="navigation">
        <ul>
            <?php
            /**
             * Fires inside the groups directory group types.
             *
             * @since 1.2.0
             */
            do_action('bp_groups_directory_group_types');
            ?>

            <li id="groups-order-select" class="last filter">

                <label for="groups-order-by"><?php _e('Order By:', 'buddypress'); ?></label>

                <select id="groups-order-by">
                    <option value="active"><?php _e('Last Active', 'buddypress'); ?></option>
                    <option value="popular"><?php _e('Most Members', 'buddypress'); ?></option>
                    <option value="newest"><?php _e('Newly Created', 'buddypress'); ?></option>
                    <option value="alphabetical"><?php _e('Alphabetical', 'buddypress'); ?></option>

                    <?php
                    /**
                     * Fires inside the groups directory group order options.
                     *
                     * @since 1.2.0
                     */
                    do_action('bp_groups_directory_order_options');
                    ?>
                </select>
            </li>
        </ul>
    </div>

    <h2 class="bp-screen-reader-text"><?php
        /* translators: accessibility text */
        _e('Groups directory', 'buddypress');
        ?></h2>

    <div id="groups-dir-list" class="groups dir-list">
        <!---------------------------------------------------------->
        <?php
        /**
         * Fires before the display of groups from the groups loop.
         *
         * @since 1.2.0
         */
        do_action('bp_before_groups_loop');
        ?>

        <?php if (bp_get_current_group_directory_type()) : ?>
            <p class="current-group-type"><?php bp_current_group_directory_type_message() ?></p>
        <?php endif; ?>

        <?php
        if (!empty($inc_atts)) {
            $bpsh_query = '&' . $bpsh_query;
        }
        if (bp_has_groups(bp_ajax_querystring('groups') . $bpsh_query)) :
            ?>

            <div id="pag-top" class="pagination">

                <div class="pag-count" id="group-dir-count-top">

    <?php bp_groups_pagination_count(); ?>

                </div>

                <div class="pagination-links" id="group-dir-pag-top">

    <?php bp_groups_pagination_links(); ?>

                </div>

            </div>

            <?php
            /**
             * Fires before the listing of the groups list.
             *
             * @since 1.1.0
             */
            do_action('bp_before_directory_groups_list');
            ?>

            <ul id="groups-list" class="item-list" aria-live="assertive" aria-atomic="true" aria-relevant="all">

                    <?php while (bp_groups()) : bp_the_group(); ?>

                    <li <?php bp_group_class(); ?>>
        <?php if (!bp_disable_group_avatar_uploads()) : ?>
                            <div class="item-avatar">
                                <a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar('type=thumb&width=50&height=50'); ?></a>
                            </div>
        <?php endif; ?>

                        <div class="item">
                            <div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
                            <div class="item-meta"><span class="activity" data-livestamp="<?php bp_core_iso8601_date(bp_get_group_last_active(0, array('relative' => false))); ?>"><?php printf(__('active %s', 'buddypress'), bp_get_group_last_active()); ?></span></div>

                            <div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

                            <?php
                            /**
                             * Fires inside the listing of an individual group listing item.
                             *
                             * @since 1.1.0
                             */
                            do_action('bp_directory_groups_item');
                            ?>

                        </div>

                        <div class="action">

                            <?php
                            /**
                             * Fires inside the action section of an individual group listing item.
                             *
                             * @since 1.1.0
                             */
                            do_action('bp_directory_groups_actions');
                            ?>

                            <div class="meta">

        <?php bp_group_type(); ?> / <?php bp_group_member_count(); ?>

                            </div>

                        </div>

                        <div class="clear"></div>
                    </li>

    <?php endwhile; ?>

            </ul>

            <?php
            /**
             * Fires after the listing of the groups list.
             *
             * @since 1.1.0
             */
            do_action('bp_after_directory_groups_list');
            ?>

            <div id="pag-bottom" class="pagination">

                <div class="pag-count" id="group-dir-count-bottom">

    <?php bp_groups_pagination_count(); ?>

                </div>

                <div class="pagination-links" id="group-dir-pag-bottom">

    <?php bp_groups_pagination_links(); ?>

                </div>

            </div>

<?php else: ?>

            <div id="message" class="info">
                <p><?php _e('There were no groups found.', 'buddypress'); ?></p>
            </div>

        <?php endif; ?>

        <?php
        /**
         * Fires after the display of groups from the groups loop.
         *
         * @since 1.2.0
         */
        do_action('bp_after_groups_loop');
        ?>
        <!---------------------------------------------------------->
    </div><!--#groups-dir-list -->

    <?php
    /**
     * Fires and displays the group content.
     *
     * @since 1.1.0
     */
    do_action('bp_directory_groups_content');
    ?>

    <?php wp_nonce_field('directory_groups', '_wpnonce-groups-filter'); ?>

    <?php
    /**
     * Fires after the display of the groups content.
     *
     * @since 1.1.0
     */
    do_action('bp_after_directory_groups_content');
    ?>

</form><!-- #groups-directory-form -->

<?php
/**
 * Fires after the display of the groups.
 *
 * @since 1.1.0
 */
do_action('bp_after_directory_groups');

if ($atts['use_compat']) {
    echo '</div>';
}
/**
 * Fires at the bottom of the groups directory template file.
 *
 * @since 1.5.0
 */
do_action('bp_after_directory_groups_page');
