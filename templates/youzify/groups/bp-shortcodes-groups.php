<?php
/**
 * BP Youzify - Groups Directory
 * 
 * Template file to render for Groups Listing Shortcode when Youzify plugin is active along with BuddyPress. 
 * @since 2.7.2
 * 
 */
defined( 'ABSPATH' ) || exit;
?>

<div id="bp-shortcode-groups" class="bp-dir-hori-nav <?php if ( !empty( $groups_atts['container_class'] ) ) { echo esc_attr( $groups_atts['container_class'] ); } ?>">
	<div class="screen-content youzify youzify-directory youzify-groups-directory-page youzify-blue-scheme youzify-tabs-list-gradient">
		<input type="hidden" data-bp-filter="groups" value="<?php if ( !empty( $groups_atts['query'] ) ) { echo esc_attr( $groups_atts['query'] ); } ?>" />
		<div id="groups-dir-list" class="groups dir-list" data-bp-list="groups" data-ajax="false">
			<?php 
                if ( !empty( $groups_atts ) ) {
                    $bp_groups  = bp_has_groups( $groups_atts['query'] );
                } else {
                    $bp_groups  = bp_has_groups( bp_ajax_querystring( 'groups' ) );
                }

            if ( $bp_groups ) :
                do_action( 'bp_before_directory_groups_list' ); ?>
                <ul id="youzify-groups-list" class="item-list youzify-card-show-avatar-border youzify-card-avatar-border-circle youzify-card-action-buttons-block youzify-page-btns-border-oval" aria-live="assertive" aria-atomic="true" aria-relevant="all">

                    <?php while ( bp_groups() ) : bp_the_group(); ?>

                        <li <?php bp_group_class(); ?>>

                            <div class="youzify-show-cover youzify-group-data">

                                <?php
                                    if ( function_exists( 'youzify_get_group_tools' ) ) {
                                        youzify_get_group_tools( bp_get_group_id() );
                                    }
                                    if ( function_exists( 'youzify_groups_directory_group_cover' ) ) {
                                        youzify_groups_directory_group_cover( bp_get_group_id() );
                                    }
                        
                                ?>

                                <a href="<?php bp_group_url(); ?>" class="item-avatar">
                                    <div class="youzify-group-avatar">
                                        <?php
                                        $group_avatar = bp_core_fetch_avatar( array( 'object' => 'group', 'avatar_dir' => 'group-avatars', 'item_id' => bp_get_group_id(), 'width' => '100', 'height' => '100', 'type' => 'full') );
                                        if ( ! empty( $group_avatar ) ) {
                                            echo wp_kses_post( $group_avatar );
                                        }
                                        ?>
                                    </div>
                                </a>

                                <div class="item">
                                    <div class="item-title"><?php bp_group_link(); ?></div>
                                    <?php do_action( 'bp_directory_groups_after_group_name' ); ?>
                                    <div class="item-meta">
                                        <div class="group-status">
                                            <?php if ( function_exists( 'youzify_get_group_status' ) ) {
                                                $group_status = youzify_get_group_status( bp_get_group_status() );
                                                if ( ! empty( $group_status ) ) {
                                                    echo wp_kses_post( $group_status );
                                                }
                                            }?>

                                        </div>
                                    </div>

                                    <?php

                                    /**
                                     * Fires inside the listing of an individual group listing item.
                                     *
                                     * @since 2.7.2
                                     */
                                    do_action( 'bp_directory_groups_item' ); ?>

                                </div>

                                <?php
                                    if ( function_exists( 'youzify_get_group_statistics_data' ) ) {
                                        youzify_get_group_statistics_data( bp_get_group_id() );
                                    }
                                ?>

                                <?php if ( 'on' == youzify_option( 'youzify_enable_gd_cards_actions_buttons', 'on' ) && is_user_logged_in() ) : ?>
                                    <div class="action">
                                        <?php

                                        /** If user is group admin then render Manage Group button else for other members that are not the part of group render Request Membership button.
                                        *  
                                        * @since 2.7.2 
                                        */

                                        if ( groups_is_user_admin( get_current_user_id(), bp_get_group_id() ) ) { ?>
                                            <a href="<?php echo esc_url( bp_get_group_manage_url() ); ?>" class="youzify-manage-group"><i class="fas fa-cogs"></i><?php echo esc_html__( 'Manage Group', 'shortcodes-for-buddypress' ); ?></a>
                                        <?php } else {  do_action( 'bp_directory_groups_actions' ); 
                                        }?>
                                    </div>

                                <?php endif; ?>

                                <?php do_action( 'youzify_after_bp_directory_groups_actions' ); ?>
                            </div>
                        </li>

                    <?php endwhile; ?>
                    <div class="clear"></div>
                </ul>
                <?php

                /**
                 * Fires after the listing of the groups list.
                 * @since 2.7.2
                 */
                do_action( 'bp_after_directory_groups_list' ); ?>
                <div id="pag-bottom" class="pagination">

                    <div class="pag-count" id="group-dir-count-bottom">
                        <?php bp_groups_pagination_count(); ?>
                    </div>

                    <?php if (bp_get_groups_pagination_links()) : ?>
                        <div class="pagination-links" id="group-dir-pag-bottom">
                            <?php bp_groups_pagination_links(); ?>
                        </div>
                    <?php endif; ?>

                </div>
                                
		    <?php else : ?>
                <div id="message" class="info">
                    <p><?php echo esc_html__( 'There were no groups found.', 'shortcodes-for-buddypress' ); ?></p>
                </div>
            <?php  endif; ?>
		</div>
	</div>
</div>
<?php
