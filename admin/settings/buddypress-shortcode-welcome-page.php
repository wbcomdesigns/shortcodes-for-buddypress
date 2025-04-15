<?php
/**
 * This file is used for rendering and saving plugin welcome settings.
 *
 * @since    1.0.0
 * @author   Wbcom Designs
 * @package  Bp_Add_Group_Types
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-welcome-head">
				<p class="wbcom-welcome-description">
				<?php esc_html_e( 'The Shortcodes for BuddyPress plugin makes it easy to display BuddyPress Activities, Members, and Groups directly on your pages or posts using simple shortcodes or Elementor widgets.', 'shortcodes-for-buddypress' ); ?>
				</p>
		</div><!-- .wbcom-welcome-head -->

		<div class="wbcom-welcome-content">

		<div class="wbcom-welcome-support-info">
			<h3><?php esc_html_e( 'Help &amp; Support Resources', 'shortcodes-for-buddypress' ); ?></h3>
			<p><?php esc_html_e( 'Here are all the resources you may need to get help from us. Documentation is usually the best place to start. Should you require help anytime, our customer care team is available to assist you at the support center.', 'shortcodes-for-buddypress' ); ?></p>

			<div class="wbcom-support-info-wrap">
				<div class="wbcom-support-info-widgets">
					<div class="wbcom-support-inner">
						<h3><span class="dashicons dashicons-book"></span><?php esc_html_e( 'Documentation', 'shortcodes-for-buddypress' ); ?></h3>
						<p><?php esc_html_e( 'Explore our detailed guide on Shortcodes For BuddyPress to understand all the features and how to make the most of them.', 'shortcodes-for-buddypress' ); ?></p>
						<a href="<?php echo esc_url( 'https://docs.wbcomdesigns.com/doc_category/shortcodes-for-buddypress/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Read Documentation', 'shortcodes-for-buddypress' ); ?></a>
					</div>
				</div>

				<div class="wbcom-support-info-widgets">
					<div class="wbcom-support-inner">
						<h3><span class="dashicons dashicons-sos"></span><?php esc_html_e( 'Support Center', 'shortcodes-for-buddypress' ); ?></h3>
						<p><?php esc_html_e( 'Our support team is here to assist you with any questions or issues. Feel free to contact us anytime through our support center.', 'shortcodes-for-buddypress' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/support/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Get Support', 'shortcodes-for-buddypress' ); ?></a>
					</div>
				</div>
				<div class="wbcom-support-info-widgets">
					<div class="wbcom-support-inner">
						<h3><span class="dashicons dashicons-admin-comments"></span><?php esc_html_e( 'Share Your Feedback', 'shortcodes-for-buddypress' ); ?></h3>
						<p><?php esc_html_e( 'We’d love to hear about your experience with the plugin. Your feedback and suggestions help us improve future updates.', 'shortcodes-for-buddypress' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/submit-review/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Send Feedback', 'shortcodes-for-buddypress' ); ?></a>
					</div>
				</div>
			</div>
		</div>
		</div>

	</div><!-- .wbcom-welcome-content -->
</div><!-- .wbcom-welcome-main-wrapper -->
