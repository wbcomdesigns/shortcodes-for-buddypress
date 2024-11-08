<?php
/**
 * BP Nouveau - Groups Directory
 *
 * @since 3.0.0
 * @version 3.0.0
 */
global $groups_atts;

?>

<div id="buddypress" class="bp-dir-hori-nav <?php echo esc_attr( $groups_atts['container_class'] ); ?>">
	<div class="screen-content">
		<input type="hidden" data-bp-filter="groups" value="<?php echo esc_attr( $groups_atts['bpsh_query'] ); ?>" />
		<div id="groups-dir-list" class="groups dir-list" data-bp-list="groups" data-ajax="false">
			<?php if ( bp_has_groups( $groups_atts['bpsh_query'] ) ) :
                do_action( 'bp_before_directory_groups_list' ); ?>
                <ul id="youzify-groups-list" class="item-list youzify-card-show-avatar-border youzify-card-avatar-border-circle youzify-card-action-buttons-block youzify-page-btns-border-oval" aria-live="assertive" aria-atomic="true" aria-relevant="all">

                    <?php while ( bp_groups() ) : bp_the_group(); ?>

                        <li <?php bp_group_class(); ?>>

                            <div class="youzify-group-data">

                                <?php
                                    if ( function_exists( 'youzify_get_group_tools' ) ) {
                                        youzify_get_group_tools( bp_get_group_id() );
                                    }
                                    if ( function_exists( 'youzify_groups_directory_group_cover' ) ) {
                                        youzify_groups_directory_group_cover( bp_get_group_id() );
                                    }
                        
                                ?>

                                <div class="item-avatar">
                                    <a href="<?php bp_group_url(); ?>"><?php bp_group_avatar( 'type=full&width=100&height=100' ); ?></a>
                                </div>

                                <div class="item">
                                    <div class="item-title"><?php bp_group_link(); ?></div>
                                    <?php do_action( 'bp_directory_groups_after_group_name' ); ?>
                                    <div class="item-meta">
                                        <div class="group-status">
                                            <?php if ( function_exists( 'youzify_get_group_status' ) ) {
                                                echo youzify_get_group_status( bp_get_group_status() );
                                            }?>

                                        </div>

                                        <span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ); ?>"><?php printf( __( 'Active %s', 'youzify' ), bp_get_group_last_active() ); ?></span>
                                        
                                    </div>

                                    <?php

                                    /**
                                     * Fires inside the listing of an individual group listing item.
                                     *
                                     * @since 1.1.0
                                     */
                                    do_action( 'bp_directory_groups_item' ); ?>

                                </div>

                                <?php
                                    if ( function_exists( 'youzify_get_group_statistics_data' ) ) {
                                        youzify_get_group_statistics_data( bp_get_group_id() );
                                    }
                                ?>

                                <?php do_action( 'youzify_after_bp_directory_groups_actions' ); ?>
                            </div>
                        </li>

                    <?php endwhile; ?>
                    <div class="clear"></div>
                </ul>
                <?php

                /**
                 * Fires after the listing of the groups list.
                 *
                 * @since 1.1.0
                 */
                do_action( 'bp_after_directory_groups_list' ); ?>

                <div id="pag-bottom" class="pagination">

                    <div class="pag-count" id="group-dir-count-bottom">
                        <?php bp_groups_pagination_count(); ?>
                    </div>

                    <?php if ( bp_get_groups_pagination_links() ) : ?>
                    <div class="pagination-links" id="group-dir-pag-bottom">
                        <?php bp_groups_pagination_links(); ?>
                    </div>
                    <?php endif; ?>

                </div>
		    <?php endif; ?>
		</div>
	</div>
</div>
<?php
