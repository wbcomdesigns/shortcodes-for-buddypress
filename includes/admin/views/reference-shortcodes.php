<?php
/**
 * Reference tab: Shortcodes overview (ported from the legacy Welcome +
 * General informational panels). Rendered inside shell.php as a plain
 * informational partial — this plugin saves nothing.
 *
 * @package Shortcodes_For_Buddypress
 * @since   3.0.0
 */

defined( 'ABSPATH' ) || exit;

$bpsp_page_url = admin_url( 'admin.php?page=' . Shortcodes_For_Buddypress_Admin_Panel::MENU_SLUG );

$bpsp_cards = array(
	array(
		'label'    => __( 'Activity Stream', 'shortcodes-for-buddypress' ),
		'tag'      => '[activity-listing]',
		'desc'     => __( 'Display BuddyPress activity streams with filtering, pagination, and posting.', 'shortcodes-for-buddypress' ),
		'features' => array(
			__( 'Real-time activity feeds', 'shortcodes-for-buddypress' ),
			__( 'Comment threading', 'shortcodes-for-buddypress' ),
			__( 'Activity filtering', 'shortcodes-for-buddypress' ),
			__( 'Load more / pagination', 'shortcodes-for-buddypress' ),
		),
		'tab'      => 'activities',
		'doc'      => 'https://docs.wbcomdesigns.com/docs/shortcodes-for-buddypress/activity-listing/',
	),
	array(
		'label'    => __( 'Members Directory', 'shortcodes-for-buddypress' ),
		'tag'      => '[members-listing]',
		'desc'     => __( 'Create custom member directories with advanced filtering and layout options.', 'shortcodes-for-buddypress' ),
		'features' => array(
			__( 'Grid & list layouts', 'shortcodes-for-buddypress' ),
			__( 'Member type filtering', 'shortcodes-for-buddypress' ),
			__( 'Profile field search', 'shortcodes-for-buddypress' ),
			__( 'Online status', 'shortcodes-for-buddypress' ),
		),
		'tab'      => 'members',
		'doc'      => 'https://docs.wbcomdesigns.com/docs/shortcodes-for-buddypress/member-listing/',
	),
	array(
		'label'    => __( 'Groups Listing', 'shortcodes-for-buddypress' ),
		'tag'      => '[groups-listing]',
		'desc'     => __( 'Display groups with privacy controls, member counts, and activity indicators.', 'shortcodes-for-buddypress' ),
		'features' => array(
			__( 'Public / private groups', 'shortcodes-for-buddypress' ),
			__( 'Group type filtering', 'shortcodes-for-buddypress' ),
			__( 'Member count display', 'shortcodes-for-buddypress' ),
			__( 'Activity sorting', 'shortcodes-for-buddypress' ),
		),
		'tab'      => 'groups',
		'doc'      => 'https://docs.wbcomdesigns.com/docs/shortcodes-for-buddypress/group-listing/',
	),
);

$bpsp_use_cases = array(
	array( __( 'Custom Homepage', 'shortcodes-for-buddypress' ), __( 'Latest community activity:', 'shortcodes-for-buddypress' ), '[activity-listing per_page="5" title="Recent Activity"]' ),
	array( __( 'Featured Members', 'shortcodes-for-buddypress' ), __( 'Showcase specific members:', 'shortcodes-for-buddypress' ), '[members-listing include="1,2,3,4" grid="yes"]' ),
	array( __( 'Popular Groups', 'shortcodes-for-buddypress' ), __( 'Most active groups:', 'shortcodes-for-buddypress' ), '[groups-listing type="popular" per_page="6"]' ),
	array( __( 'Member Search', 'shortcodes-for-buddypress' ), __( 'Members by location:', 'shortcodes-for-buddypress' ), '[members-listing xprofile_query="City:London"]' ),
	array( __( 'User Dashboard', 'shortcodes-for-buddypress' ), __( 'Personal activity feed:', 'shortcodes-for-buddypress' ), '[activity-listing scope="just-me" per_page="10"]' ),
	array( __( 'Team Directory', 'shortcodes-for-buddypress' ), __( 'Staff members only:', 'shortcodes-for-buddypress' ), '[members-listing member_type="staff" grid="yes"]' ),
);
?>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Available Shortcodes', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-card__desc"><?php esc_html_e( 'Embed BuddyPress activities, members, and groups anywhere using simple shortcodes or the matching Elementor widgets.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<div class="bpsp-doc-grid">
			<?php foreach ( $bpsp_cards as $bpsp_card ) : ?>
				<div class="bpsp-doc-tile">
					<h5><?php echo esc_html( $bpsp_card['label'] ); ?></h5>
					<code class="bpsp-code-block"><?php echo esc_html( $bpsp_card['tag'] ); ?></code>
					<p><?php echo esc_html( $bpsp_card['desc'] ); ?></p>
					<ul>
						<?php foreach ( $bpsp_card['features'] as $bpsp_feature ) : ?>
							<li><span class="bpsp-status-yes" aria-hidden="true">&#10003;</span> <?php echo esc_html( $bpsp_feature ); ?></li>
						<?php endforeach; ?>
					</ul>
					<div class="bpsp-doc-actions">
						<a href="<?php echo esc_url( $bpsp_page_url . '&tab=' . $bpsp_card['tab'] ); ?>" class="bpsp-btn bpsp-btn-secondary"><?php esc_html_e( 'View Parameters', 'shortcodes-for-buddypress' ); ?></a>
						<a href="<?php echo esc_url( $bpsp_card['doc'] ); ?>" target="_blank" rel="noopener noreferrer" class="bpsp-btn bpsp-btn-secondary"><?php esc_html_e( 'Documentation', 'shortcodes-for-buddypress' ); ?></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Quick Start Guide', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<ol class="bpsp-doc-list">
			<li><strong><?php esc_html_e( 'Choose a shortcode:', 'shortcodes-for-buddypress' ); ?></strong> <?php esc_html_e( 'select activity, members, or groups based on your needs.', 'shortcodes-for-buddypress' ); ?></li>
			<li><strong><?php esc_html_e( 'Add to your page:', 'shortcodes-for-buddypress' ); ?></strong> <?php esc_html_e( 'paste the shortcode into any post, page, or widget area.', 'shortcodes-for-buddypress' ); ?></li>
			<li><strong><?php esc_html_e( 'Customize with parameters:', 'shortcodes-for-buddypress' ); ?></strong> <?php esc_html_e( 'add parameters to control layout, filtering, and pagination.', 'shortcodes-for-buddypress' ); ?></li>
		</ol>
	</div>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Popular Use Cases', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<div class="bpsp-doc-grid">
			<?php foreach ( $bpsp_use_cases as $bpsp_uc ) : ?>
				<div class="bpsp-doc-tile">
					<h5><?php echo esc_html( $bpsp_uc[0] ); ?></h5>
					<p><?php echo esc_html( $bpsp_uc[1] ); ?></p>
					<code class="bpsp-code-block"><?php echo esc_html( $bpsp_uc[2] ); ?></code>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Help & Support', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-card__desc"><?php esc_html_e( 'Documentation is the best place to start. Our team is available through the support center.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<div class="bpsp-doc-actions">
			<a href="https://docs.wbcomdesigns.com/doc_category/shortcodes-for-buddypress/" target="_blank" rel="noopener noreferrer" class="bpsp-btn bpsp-btn-secondary"><span class="dashicons dashicons-book" aria-hidden="true"></span> <?php esc_html_e( 'Read Documentation', 'shortcodes-for-buddypress' ); ?></a>
			<a href="https://wbcomdesigns.com/support/" target="_blank" rel="noopener noreferrer" class="bpsp-btn bpsp-btn-secondary"><span class="dashicons dashicons-sos" aria-hidden="true"></span> <?php esc_html_e( 'Get Support', 'shortcodes-for-buddypress' ); ?></a>
			<a href="https://wbcomdesigns.com/submit-review/" target="_blank" rel="noopener noreferrer" class="bpsp-btn bpsp-btn-secondary"><span class="dashicons dashicons-admin-comments" aria-hidden="true"></span> <?php esc_html_e( 'Send Feedback', 'shortcodes-for-buddypress' ); ?></a>
		</div>
	</div>
</div>
