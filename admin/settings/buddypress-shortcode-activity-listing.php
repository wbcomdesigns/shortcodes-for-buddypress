<?php
/**
 * BuddyPress Activity Shortcode Settings Page
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
			<h3><?php esc_html_e( 'Activity Listing Shortcode', 'shortcodes-for-buddypress' ); ?></h3>
			<p class="wbcom-welcome-description">
				<?php esc_html_e( 'The [activity-listing] shortcode allows you to embed BuddyPress activity streams anywhere in your WordPress site.', 'shortcodes-for-buddypress' ); ?>
			</p>
		</div>

		<!-- Basic Usage Examples -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Basic Usage Examples', 'shortcodes-for-buddypress' ); ?></h4>
			<div class="wbcom-code-examples">
				<p><code>[activity-listing]</code> - <?php esc_html_e( 'Display default activity stream', 'shortcodes-for-buddypress' ); ?></p>
				<p><code>[activity-listing title="Latest Activities" per_page="5"]</code> - <?php esc_html_e( 'Show 5 activities with a title', 'shortcodes-for-buddypress' ); ?></p>
				<p><code>[activity-listing object="groups" user_id="1"]</code> - <?php esc_html_e( 'Show group activities for user 1', 'shortcodes-for-buddypress' ); ?></p>
				<p><code>[activity-listing scope="friends" per_page="10"]</code> - <?php esc_html_e( 'Show friends activities', 'shortcodes-for-buddypress' ); ?></p>
			</div>
		</div>

		<!-- Display Options -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Display Options', 'shortcodes-for-buddypress' ); ?></h4>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'title', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Display a title above the activity list', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> string</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>title="Community Activities"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'pagination', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Enable/disable pagination links', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> boolean (0 or 1)</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> 1</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>pagination="0"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'load_more', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Show "Load More" button instead of pagination', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> boolean (0 or 1)</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> 0</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>load_more="1"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'allow_posting', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Allow users to post new activities from the shortcode', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> boolean (true or false)</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> false</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>allow_posting="true"</code></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Pagination & Limiting -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Pagination & Limiting', 'shortcodes-for-buddypress' ); ?></h4>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'per_page', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Number of activities to show per page', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> 10</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>per_page="20"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'page', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Which page of results to display', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> 1</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>page="2"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'max', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Maximum total activities to retrieve', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer or false (unlimited)</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> false</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>max="50"</code></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Filtering Options -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Filtering Options', 'shortcodes-for-buddypress' ); ?></h4>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'scope', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Pre-built activity filters', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Options:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>just-me</code> - <?php esc_html_e( 'Current user activities only', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>friends</code> - <?php esc_html_e( 'Friends activities', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>groups</code> - <?php esc_html_e( 'Groups user belongs to', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>favorites</code> - <?php esc_html_e( 'Favorited activities', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>mentions</code> - <?php esc_html_e( '@mentions of current user', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>scope="friends"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'user_id', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Show activities from specific user(s)', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer or comma-separated IDs</p>
						<p><strong><?php esc_html_e( 'Examples:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>user_id="1"</code> - <?php esc_html_e( 'Single user', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>user_id="1,2,3"</code> - <?php esc_html_e( 'Multiple users', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'object', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Filter by BuddyPress component', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Common values:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>activity</code> - <?php esc_html_e( 'Status updates', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>groups</code> - <?php esc_html_e( 'Group activities', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>friends</code> - <?php esc_html_e( 'Friendship connections', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>blogs</code> - <?php esc_html_e( 'Blog posts and comments', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>profile</code> - <?php esc_html_e( 'Profile updates', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>object="groups"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'action', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Filter by specific activity types', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Common values:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>activity_update</code> - <?php esc_html_e( 'Status updates', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>new_blog_post</code> - <?php esc_html_e( 'New blog posts', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>new_blog_comment</code> - <?php esc_html_e( 'Blog comments', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>created_group</code> - <?php esc_html_e( 'Group creations', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>joined_group</code> - <?php esc_html_e( 'Group joins', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>friendship_created</code> - <?php esc_html_e( 'New friendships', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>action="activity_update,new_blog_post"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'search_terms', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Search activities by keywords', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> string</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>search_terms="announcement"</code></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Advanced Options -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Advanced Options', 'shortcodes-for-buddypress' ); ?></h4>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'sort', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Sort order of activities', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Options:', 'shortcodes-for-buddypress' ); ?></strong> ASC (oldest first) or DESC (newest first)</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> DESC</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>sort="ASC"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'include', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Show only specific activity IDs', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> comma-separated activity IDs</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>include="1,2,3"</code></p>
						<p class="notice notice-info" style="padding: 10px;"><?php esc_html_e( 'Note: This overrides all other filters', 'shortcodes-for-buddypress' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'exclude', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Exclude specific activity IDs', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> comma-separated activity IDs</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>exclude="10,15,20"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'primary_id', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Filter by item ID (e.g., group ID for group activities)', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer or comma-separated IDs</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>primary_id="5"</code></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Complex Examples -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Complex Examples', 'shortcodes-for-buddypress' ); ?></h4>
			<div class="wbcom-code-examples">
				<p><strong><?php esc_html_e( 'Friends activities with pagination:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[activity-listing scope="friends" per_page="15" pagination="1" title="My Friends Activities"]</code></p>

				<p><strong><?php esc_html_e( 'Group activities for specific groups:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[activity-listing object="groups" primary_id="1,2,3" per_page="10"]</code></p>

				<p><strong><?php esc_html_e( 'Status updates only with load more:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[activity-listing action="activity_update" load_more="1" per_page="5"]</code></p>

				<p><strong><?php esc_html_e( 'Search results with specific users:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[activity-listing search_terms="project" user_id="1,5,10" max="20"]</code></p>
			</div>
		</div>

	</div>
</div>