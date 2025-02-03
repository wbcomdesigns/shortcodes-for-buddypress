<?php
/**
 * Fires at the top of the members directory template file.
 *
 * @since 1.0.0
 */
?>


<div id="buddypress">

	<div id="members-dir-list" class="members dir-list">

		<?php if ( bp_has_members( $query ) ) : ?>


			<?php

			/**
			 * Fires before the display of the members list.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_before_directory_members_list' );
			?>

			<ul id="members-list" class="item-list" aria-live="assertive" aria-relevant="all">

				<?php
				while ( bp_members() ) :
					bp_the_member();
					?>

					<li <?php bp_member_class(); ?>> 
			
						<div class="item-avatar">

							<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>

						</div>

						<div class="item">
							<div class="item-title">
								<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>

								<?php if ( bp_get_member_latest_update() ) : ?>

									<span class="update"> <?php bp_member_latest_update(); ?></span>

								<?php endif; ?>

							</div>

							<div class="item-meta"><span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_member_last_active( array( 'relative' => false ) ) ); ?>"><?php bp_member_last_active(); ?></span></div>

							<?php

							/**
							 * Fires inside the display of a directory member item.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_directory_members_item' );
							?>
						</div>

						<div class="action">

							<?php

							/**
							 * Fires inside the members action HTML markup to display actions.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_directory_members_actions' );
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
			do_action( 'bp_after_directory_members_list' );
			?>

			<?php bp_member_hidden_fields(); ?>

		<?php else : ?>

			<div id="message" class="info">
				<p><?php esc_html_e( 'Sorry, no members were found.', 'shortcodes-for-buddypress' ); ?></p>
			</div>

		<?php endif; ?>

	</div><!-- #members-dir-list -->

	<?php

	/**
	 * Fires after the display of the members.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_members' );
	?>

</div><!-- #buddypress -->

