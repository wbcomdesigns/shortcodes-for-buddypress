<?php
/**
 * BuddyPress Shortcodes General Settings Page
 *
 * @since    1.0.0
 * @author   Wbcom Designs
 * @package  Shortcodes_For_Buddypress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="wbcom-tab-content">
	<div class="wbcom-wrapper-admin">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'BuddyPress Shortcodes Overview', 'shortcodes-for-buddypress' ); ?></h3>
			<p class="wbcom-welcome-description">
				<?php esc_html_e( 'Embed BuddyPress Activities, Members, and Groups anywhere on your WordPress site using simple shortcodes. Perfect for creating custom community pages, member directories, and activity feeds.', 'shortcodes-for-buddypress' ); ?>
			</p>
		</div>

		<!-- Available Shortcodes -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Available Shortcodes', 'shortcodes-for-buddypress' ); ?></h4>
			<div class="wbcom-shortcode-grid">
				<!-- Activity Shortcode -->
				<div class="wbcom-shortcode-card">
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<h5><?php esc_html_e( '📊 Activity Stream', 'shortcodes-for-buddypress' ); ?></h5>
							<code class="shortcode-display">[activity-listing]</code>
						</div>
						<div class="wbcom-settings-section-options">
							<p class="description"><?php esc_html_e( 'Display BuddyPress activity streams with filtering, pagination, and posting capabilities.', 'shortcodes-for-buddypress' ); ?></p>
							<div class="shortcode-features">
								<ul>
									<li>✓ <?php esc_html_e( 'Real-time activity feeds', 'shortcodes-for-buddypress' ); ?></li>
									<li>✓ <?php esc_html_e( 'Comment threading', 'shortcodes-for-buddypress' ); ?></li>
									<li>✓ <?php esc_html_e( 'Activity filtering', 'shortcodes-for-buddypress' ); ?></li>
									<li>✓ <?php esc_html_e( 'Load more/pagination', 'shortcodes-for-buddypress' ); ?></li>
								</ul>
							</div>
							<div class="shortcode-actions">
								<a href="?page=shortcodes-for-buddypress&tab=buddypress-shortcode-activities" class="button"><?php esc_html_e( 'View Parameters', 'shortcodes-for-buddypress' ); ?></a>
								<a href="https://docs.wbcomdesigns.com/docs/shortcodes-for-buddypress/activity-listing/" target="_blank" class="button-secondary"><?php esc_html_e( 'Documentation', 'shortcodes-for-buddypress' ); ?></a>
							</div>
						</div>
					</div>
				</div>

				<!-- Members Shortcode -->
				<div class="wbcom-shortcode-card">
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<h5><?php esc_html_e( '👥 Members Directory', 'shortcodes-for-buddypress' ); ?></h5>
							<code class="shortcode-display">[members-listing]</code>
						</div>
						<div class="wbcom-settings-section-options">
							<p class="description"><?php esc_html_e( 'Create custom member directories with advanced filtering and layout options.', 'shortcodes-for-buddypress' ); ?></p>
							<div class="shortcode-features">
								<ul>
									<li>✓ <?php esc_html_e( 'Grid & list layouts', 'shortcodes-for-buddypress' ); ?></li>
									<li>✓ <?php esc_html_e( 'Member type filtering', 'shortcodes-for-buddypress' ); ?></li>
									<li>✓ <?php esc_html_e( 'Profile field search', 'shortcodes-for-buddypress' ); ?></li>
									<li>✓ <?php esc_html_e( 'Online status', 'shortcodes-for-buddypress' ); ?></li>
								</ul>
							</div>
							<div class="shortcode-actions">
								<a href="?page=shortcodes-for-buddypress&tab=buddypress-shortcode-member" class="button"><?php esc_html_e( 'View Parameters', 'shortcodes-for-buddypress' ); ?></a>
								<a href="https://docs.wbcomdesigns.com/docs/shortcodes-for-buddypress/member-listing/" target="_blank" class="button-secondary"><?php esc_html_e( 'Documentation', 'shortcodes-for-buddypress' ); ?></a>
							</div>
						</div>
					</div>
				</div>

				<!-- Groups Shortcode -->
				<div class="wbcom-shortcode-card">
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<h5><?php esc_html_e( '🎯 Groups Listing', 'shortcodes-for-buddypress' ); ?></h5>
							<code class="shortcode-display">[groups-listing]</code>
						</div>
						<div class="wbcom-settings-section-options">
							<p class="description"><?php esc_html_e( 'Display groups with privacy controls, member counts, and activity indicators.', 'shortcodes-for-buddypress' ); ?></p>
							<div class="shortcode-features">
								<ul>
									<li>✓ <?php esc_html_e( 'Public/private groups', 'shortcodes-for-buddypress' ); ?></li>
									<li>✓ <?php esc_html_e( 'Group type filtering', 'shortcodes-for-buddypress' ); ?></li>
									<li>✓ <?php esc_html_e( 'Member count display', 'shortcodes-for-buddypress' ); ?></li>
									<li>✓ <?php esc_html_e( 'Activity sorting', 'shortcodes-for-buddypress' ); ?></li>
								</ul>
							</div>
							<div class="shortcode-actions">
								<a href="?page=shortcodes-for-buddypress&tab=buddypress-shortcode-groups" class="button"><?php esc_html_e( 'View Parameters', 'shortcodes-for-buddypress' ); ?></a>
								<a href="https://docs.wbcomdesigns.com/docs/shortcodes-for-buddypress/group-listing/" target="_blank" class="button-secondary"><?php esc_html_e( 'Documentation', 'shortcodes-for-buddypress' ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Quick Start Guide -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Quick Start Guide', 'shortcodes-for-buddypress' ); ?></h4>
			<div class="wbcom-quick-start">
				<ol>
					<li>
						<strong><?php esc_html_e( 'Choose a shortcode:', 'shortcodes-for-buddypress' ); ?></strong>
						<p><?php esc_html_e( 'Select from activity, members, or groups based on your needs.', 'shortcodes-for-buddypress' ); ?></p>
					</li>
					<li>
						<strong><?php esc_html_e( 'Add to your page:', 'shortcodes-for-buddypress' ); ?></strong>
						<p><?php esc_html_e( 'Paste the shortcode into any post, page, or widget area.', 'shortcodes-for-buddypress' ); ?></p>
					</li>
					<li>
						<strong><?php esc_html_e( 'Customize with parameters:', 'shortcodes-for-buddypress' ); ?></strong>
						<p><?php esc_html_e( 'Add parameters to control layout, filtering, and pagination.', 'shortcodes-for-buddypress' ); ?></p>
					</li>
				</ol>
			</div>
		</div>

		<!-- Popular Use Cases -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Popular Use Cases', 'shortcodes-for-buddypress' ); ?></h4>
			<div class="wbcom-use-cases">
				<div class="use-case-item">
					<h5><?php esc_html_e( '🏠 Custom Homepage', 'shortcodes-for-buddypress' ); ?></h5>
					<p><?php esc_html_e( 'Latest community activity:', 'shortcodes-for-buddypress' ); ?></p>
					<code>[activity-listing per_page="5" title="Recent Activity"]</code>
				</div>
				<div class="use-case-item">
					<h5><?php esc_html_e( '⭐ Featured Members', 'shortcodes-for-buddypress' ); ?></h5>
					<p><?php esc_html_e( 'Showcase specific members:', 'shortcodes-for-buddypress' ); ?></p>
					<code>[members-listing include="1,2,3,4" layout="grid"]</code>
				</div>
				<div class="use-case-item">
					<h5><?php esc_html_e( '🔥 Popular Groups', 'shortcodes-for-buddypress' ); ?></h5>
					<p><?php esc_html_e( 'Most active groups:', 'shortcodes-for-buddypress' ); ?></p>
					<code>[groups-listing type="popular" per_page="6"]</code>
				</div>
				<div class="use-case-item">
					<h5><?php esc_html_e( '🔍 Member Search', 'shortcodes-for-buddypress' ); ?></h5>
					<p><?php esc_html_e( 'Members by location:', 'shortcodes-for-buddypress' ); ?></p>
					<code>[members-listing xprofile_query="City:London"]</code>
				</div>
				<div class="use-case-item">
					<h5><?php esc_html_e( '📱 User Dashboard', 'shortcodes-for-buddypress' ); ?></h5>
					<p><?php esc_html_e( 'Personal activity feed:', 'shortcodes-for-buddypress' ); ?></p>
					<code>[activity-listing scope="just-me" per_page="10"]</code>
				</div>
				<div class="use-case-item">
					<h5><?php esc_html_e( '👥 Team Directory', 'shortcodes-for-buddypress' ); ?></h5>
					<p><?php esc_html_e( 'Staff members only:', 'shortcodes-for-buddypress' ); ?></p>
					<code>[members-listing member_type="staff" layout="grid"]</code>
				</div>
			</div>
		</div>

		<!-- Compatibility Information -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Compatibility', 'shortcodes-for-buddypress' ); ?></h4>
			<div class="wbcom-compatibility-info">
				<table class="compatibility-table">
					<tr>
						<th><?php esc_html_e( 'Component', 'shortcodes-for-buddypress' ); ?></th>
						<th><?php esc_html_e( 'Status', 'shortcodes-for-buddypress' ); ?></th>
						<th><?php esc_html_e( 'Notes', 'shortcodes-for-buddypress' ); ?></th>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'BuddyPress', 'shortcodes-for-buddypress' ); ?></strong></td>
						<td><?php echo bp_is_active( 'activity' ) || bp_is_active( 'members' ) || bp_is_active( 'groups' ) ? '<span style="color: green;">✓ ' . esc_html__( 'Active', 'shortcodes-for-buddypress' ) . '</span>' : '<span style="color: red;">✗ ' . esc_html__( 'Not Active', 'shortcodes-for-buddypress' ) . '</span>'; ?></td>
						<td><?php esc_html_e( 'Required for all shortcodes', 'shortcodes-for-buddypress' ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Activity Component', 'shortcodes-for-buddypress' ); ?></td>
						<td><?php echo bp_is_active( 'activity' ) ? '<span style="color: green;">✓ ' . esc_html__( 'Active', 'shortcodes-for-buddypress' ) . '</span>' : '<span style="color: orange;">○ ' . esc_html__( 'Inactive', 'shortcodes-for-buddypress' ) . '</span>'; ?></td>
						<td><?php esc_html_e( 'Required for [activity-listing]', 'shortcodes-for-buddypress' ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Members Component', 'shortcodes-for-buddypress' ); ?></td>
						<td><?php echo bp_is_active( 'members' ) ? '<span style="color: green;">✓ ' . esc_html__( 'Active', 'shortcodes-for-buddypress' ) . '</span>' : '<span style="color: orange;">○ ' . esc_html__( 'Inactive', 'shortcodes-for-buddypress' ) . '</span>'; ?></td>
						<td><?php esc_html_e( 'Required for [members-listing]', 'shortcodes-for-buddypress' ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Groups Component', 'shortcodes-for-buddypress' ); ?></td>
						<td><?php echo bp_is_active( 'groups' ) ? '<span style="color: green;">✓ ' . esc_html__( 'Active', 'shortcodes-for-buddypress' ) . '</span>' : '<span style="color: orange;">○ ' . esc_html__( 'Inactive', 'shortcodes-for-buddypress' ) . '</span>'; ?></td>
						<td><?php esc_html_e( 'Required for [groups-listing]', 'shortcodes-for-buddypress' ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Theme Compatibility', 'shortcodes-for-buddypress' ); ?></td>
						<td><span style="color: green;">✓ <?php esc_html_e( 'Universal', 'shortcodes-for-buddypress' ); ?></span></td>
						<td><?php esc_html_e( 'Works with Nouveau, Legacy, and custom themes', 'shortcodes-for-buddypress' ); ?></td>
					</tr>
				</table>
			</div>
		</div>

	</div>
</div>

<style>
.wbcom-shortcode-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
	gap: 20px;
	margin-top: 20px;
}
.wbcom-shortcode-card {
	background: #f9f9f9;
	border: 1px solid #ddd;
	border-radius: 5px;
	padding: 15px;
}
.shortcode-display {
	display: block;
	margin: 10px 0;
	padding: 8px;
	background: #fff;
	border: 1px solid #ddd;
	border-radius: 3px;
	font-size: 14px;
}
.shortcode-features ul {
	list-style: none;
	padding: 0;
	margin: 10px 0;
}
.shortcode-features li {
	padding: 3px 0;
	color: #555;
}
.shortcode-actions {
	margin-top: 15px;
}
.shortcode-actions .button {
	margin-right: 10px;
}
.wbcom-use-cases {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
	gap: 15px;
	margin-top: 20px;
}
.use-case-item {
	background: #f7f7f7;
	padding: 15px;
	border-radius: 5px;
	border: 1px solid #e1e1e1;
}
.use-case-item h5 {
	margin-top: 0;
	color: #333;
}
.use-case-item code {
	display: block;
	margin-top: 10px;
	padding: 8px;
	background: #fff;
	border: 1px solid #ddd;
	border-radius: 3px;
	font-size: 12px;
}
.wbcom-quick-start {
	background: #f9f9f9;
	padding: 20px;
	border-radius: 5px;
	margin-top: 20px;
}
.wbcom-quick-start ol {
	margin: 0;
	padding-left: 20px;
}
.wbcom-quick-start li {
	margin-bottom: 15px;
}
.wbcom-quick-start li p {
	margin: 5px 0 0 0;
	color: #666;
}
.compatibility-table {
	width: 100%;
	border-collapse: collapse;
	margin-top: 20px;
}
.compatibility-table th,
.compatibility-table td {
	padding: 10px;
	text-align: left;
	border-bottom: 1px solid #ddd;
}
.compatibility-table th {
	background: #f5f5f5;
	font-weight: 600;
}
</style>