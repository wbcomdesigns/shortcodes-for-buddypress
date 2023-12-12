<?php
/**
 * BuddyPress - Members Loop
 *
 * @since 3.0.0
 * @version 6.0.0
 */

bp_nouveau_before_loop(); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="bps-current-member-type"><?php bp_current_member_type_message(); ?></p>
<?php endif; ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<ul id="bps-members-list" class="">

	<?php while ( bp_members() ) : bp_the_member(); ?>

		<li class="bps-item-entry" id="user_id_<?php bp_member_user_id(); ?>">
			<div class="bps-list-wrap">
				
				<div class="bps-item-avatar">
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( bp_nouveau_avatar_args() ); ?></a>
				</div>

				<div class="bps-item">

					<div class="bps-item-block">

						<h2 class="bps-list-title bps-member-name">
							<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
						</h2>

						<?php if ( bp_nouveau_member_has_meta() ) : ?>
							<p class="bps-item-meta bps-last-activity">
								<?php bp_nouveau_member_meta(); ?>
							</p><!-- .item-meta -->
						<?php endif; ?>

						<?php if ( bp_nouveau_member_has_extra_content() ) : ?>
							<div class="bps-item-extra-content">
								<?php bp_nouveau_member_extra_content() ; ?>
							</div><!-- .item-extra-content -->
						<?php endif ; ?>

						
					</div>

				</div><!-- // .item -->
			</div>
		</li>

	<?php endwhile; ?>

	</ul>

<?php
else :

	bp_nouveau_user_feedback( 'members-loop-none' );

endif;
?>

<?php bp_nouveau_after_loop(); ?>
