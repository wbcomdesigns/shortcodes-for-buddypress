<?php
/**
 * Bp add group type general setting file.
 *
 * @since    1.0.0
 * @author   Wbcom Designs
 * @package  Bp_Add_Group_Types
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $bp_grp_types;
?>
<div class="wbcom-tab-content">
	<div class="wbcom-wrapper-admin">
		<div class="wbcom-admin-title-section">
			<p class="wbcom-welcome-description">
				<?php echo esc_html( 'The "Shortcodes & Elementor Widgets for BuddyPress" plugin allows you to embed BuddyPress Activities, Members, and Groups into posts and pages using shortcodes.' ); ?>
			</p>
		</div>
		<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
			<div class="form-table">
				<div class="wbcom-settings-section-wrap">
					<div class="wbcom-settings-section-options-heading">
						<label for="group_types_search">
							<?php esc_html_e( 'Activities', 'shortcodes-for-buddypress' ); ?>
						</label>
						<span class="bp-shortcode-read-more">
							<p class="description"><?php esc_html_e( 'The BuddyPress Activity shortcode allows you to embed BuddyPress activities into posts and pages. ', 'shortcodes-for-buddypress' ); ?></p>
							<a href="<?php echo esc_attr( 'https://docs.wbcomdesigns.com/docs/shortcodes-for-buddypress/activity-listing/parameters-for-activity-listing/' );?>" class="bpsh_read_more" target="_blank"><?php echo esc_html( ' Read more' ); ?></a>
						</span>
					</div>
					<div class="wbcom-settings-section-options">
						<label class="bupr-switch">
						<p class="description"><?php esc_html_e( '[activity-listing]', 'shortcodes-for-buddypress' ); ?></p>
						</label>
					</div>
				</div>
			</div>
			<div class="form-table">
				<div class="wbcom-settings-section-wrap">
					<div class="wbcom-settings-section-options-heading">
						<label for="group_types_search">
							<?php esc_html_e( 'Members', 'shortcodes-for-buddypress' ); ?>
						</label>
						<span class="bp-shortcode-read-more">
							<p class="description"><?php esc_html_e( 'The BuddyPress Members shortcode allows you to embed BuddyPress members into posts and pages.', 'shortcodes-for-buddypress' ); ?></p>
							<a href="<?php echo esc_attr( 'https://docs.wbcomdesigns.com/docs/shortcodes-for-buddypress/member-listing/parameters-for-member-listing/' );?>" class="bpsh_read_more" target="_blank"><?php echo esc_html( 'Read more' ); ?></a>
						</span>
					</div>
					<div class="wbcom-settings-section-options">
						<label class="bupr-switch">
						<p class="description"><?php esc_html_e( '[members-listing]', 'shortcodes-for-buddypress' ); ?></p>
						</label>
					</div>
				</div>
			</div>
			<div class="form-table">
				<div class="wbcom-settings-section-wrap">
					<div class="wbcom-settings-section-options-heading">
						<label for="group_types_search">
							<?php esc_html_e( 'Groups', 'shortcodes-for-buddypress' ); ?>
						</label>
						<span class="bp-shortcode-read-more">
							<p class="description"><?php esc_html_e( 'The BuddyPress Groups shortcode allows you to embed BuddyPress groups into posts and pages.', 'shortcodes-for-buddypress' ); ?></p>
							<a href="<?php echo esc_attr( 'https://docs.wbcomdesigns.com/docs/shortcodes-for-buddypress/group-listing/parameters-for-group-listing/' );?>" class="bpsh_read_more" target="_blank"><?php echo esc_html( 'Read more' ); ?></a>
						</span>
					</div>
					<div class="wbcom-settings-section-options">
						<label class="bupr-switch">
						<p class="description"><?php esc_html_e( '[groups-listing]', 'shortcodes-for-buddypress' ); ?></p>
						</label>
					</div>
				</div>
			</div>
			<div class="form-table">
				<div class="wbcom-settings-section-wrap">
					<div class="wbcom-settings-section-options-heading">
						<label for="group_types_search">
							<?php esc_html_e( 'User Notification', 'shortcodes-for-buddypress' ); ?>
						</label>
						<span class="bp-shortcode-read-more">
							<p class="description"><?php esc_html_e( 'The BuddyPress Notifications shortcode allows you to embed the BuddyPress notification list into posts and pages.', 'shortcodes-for-buddypress' ); ?></p>
							<a href="<?php echo esc_attr( 'https://docs.wbcomdesigns.com/docs/shortcode-for-buddypress-pro/notification-parameters/what-are-accepted-parameters-for-users-notification-listing-shortcodes/' );?>" class="bpsh_read_more" target="_blank"><?php echo esc_html( 'Read more' ); ?></a>
						</span>
					</div>
					<div class="wbcom-settings-section-options">
						<label class="bupr-switch">
						<p class="description"><?php esc_html_e( '[notifications-listing]', 'shortcodes-for-buddypress' ); ?></p>
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
