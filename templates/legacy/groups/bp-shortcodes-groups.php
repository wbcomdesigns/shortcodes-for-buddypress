<?php
/**
 * Fires at the top of the groups directory template file.
 *
 * @since 1.0.0
 */
/**
 * Fires at the top of the groups directory template file.
 *
 * @since 1.5.0
 */

global $groups_atts;
do_action( 'bp_before_directory_groups_page' ); ?>

<div id="buddypress">

	<div id="groups-dir-list" class="groups dir-list">

		<?php

		/**
		 * Fires before the display of groups from the groups loop.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_groups_loop' );
		?>

		<?php if ( bp_has_groups( $query ) ) : ?>
		
			<?php

			/**
			 * Fires before the listing of the groups list.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_before_directory_groups_list' );
			?>

			<ul id="groups-list" class="item-list" aria-live="assertive" aria-atomic="true" aria-relevant="all">

				<?php
				while ( bp_groups() ) :
					bp_the_group();
					?>

					<li <?php bp_group_class(); ?>>
						<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
							<div class="item-avatar">
								<a href="<?php bp_group_url(); ?>"><?php bp_group_avatar( 'type=thumb&width=50&height=50' ); ?></a>
							</div>
						<?php endif; ?>

						<div class="item">
							<div class="item-title"><?php bp_group_link(); ?></div>
							<div class="item-meta">
								<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ); ?>">
									<?php
									/* translators: %s: last activity timestamp (e.g. "Active 1 hour ago") */
									printf( esc_html__( 'Active %s', 'shortcodes-for-buddypress' ), esc_html( bp_get_group_last_active() ) );
									?>
								</span>
							</div>

							<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

							<?php

							/**
							 * Fires inside the listing of an individual group listing item.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_directory_groups_item' );
							?>

						</div>

						<div class="action">

							<?php

							/**
							 * Fires inside the action section of an individual group listing item.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_directory_groups_actions' );
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
			do_action( 'bp_after_directory_groups_list' );
			?>

			<?php else : ?>

				<div id="message" class="info">
					<p><?php esc_html_e( 'There were no groups found.', 'shortcodes-for-buddypress' ); ?></p>
				</div>

			<?php endif; ?>

			<?php

			/**
			 * Fires after the display of groups from the groups loop.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_after_groups_loop' );
			?>

	</div>



</div>

