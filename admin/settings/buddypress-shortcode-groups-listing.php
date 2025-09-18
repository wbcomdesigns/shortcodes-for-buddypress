<?php
/**
 * BuddyPress Groups Shortcode Settings Page
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
			<h3><?php esc_html_e( 'Groups Listing Shortcode', 'shortcodes-for-buddypress' ); ?></h3>
			<p class="wbcom-welcome-description">
				<?php esc_html_e( 'The [groups-listing] shortcode allows you to display BuddyPress groups anywhere on your site with powerful filtering and display options.', 'shortcodes-for-buddypress' ); ?>
			</p>
		</div>

		<!-- Basic Usage Examples -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Basic Usage Examples', 'shortcodes-for-buddypress' ); ?></h4>
			<div class="wbcom-code-examples">
				<p><code>[groups-listing]</code> - <?php esc_html_e( 'Display all groups with default settings', 'shortcodes-for-buddypress' ); ?></p>
				<p><code>[groups-listing per_page="6" type="popular"]</code> - <?php esc_html_e( 'Show 6 most popular groups', 'shortcodes-for-buddypress' ); ?></p>
				<p><code>[groups-listing show_hidden="false" per_page="10"]</code> - <?php esc_html_e( 'Show only public groups', 'shortcodes-for-buddypress' ); ?></p>
				<p><code>[groups-listing search_terms="tech" max="20"]</code> - <?php esc_html_e( 'Search for tech-related groups', 'shortcodes-for-buddypress' ); ?></p>
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
						<p class="description"><?php esc_html_e( 'Display a title above the groups list', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> string</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>title="Featured Groups"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'layout', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Layout style for groups display', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Options:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>list</code> - <?php esc_html_e( 'List view with group details', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>grid</code> - <?php esc_html_e( 'Grid view with group cards', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> list</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>layout="grid"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'columns', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Number of columns for grid layout', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer (2-5)</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> 3</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>columns="4"</code></p>
						<p class="notice notice-info" style="padding: 10px;"><?php esc_html_e( 'Note: Only applies when layout="grid"', 'shortcodes-for-buddypress' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'avatar_size', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Size of group avatars in pixels', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Options:', 'shortcodes-for-buddypress' ); ?></strong> thumb (50px) or full (150px)</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> thumb</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>avatar_size="full"</code></p>
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
						<p class="description"><?php esc_html_e( 'Number of groups to display per page', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> 20</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>per_page="12"</code></p>
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
						<p class="description"><?php esc_html_e( 'Maximum total groups to retrieve', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer or false (unlimited)</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> false</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>max="50"</code></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Sorting & Filtering -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Sorting & Filtering', 'shortcodes-for-buddypress' ); ?></h4>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'type', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Sort groups by different criteria', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Options:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>active</code> - <?php esc_html_e( 'Recently active groups', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>newest</code> - <?php esc_html_e( 'Newest created groups', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>alphabetical</code> - <?php esc_html_e( 'Alphabetical by group name', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>random</code> - <?php esc_html_e( 'Random order', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>popular</code> - <?php esc_html_e( 'Most members', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>most_forum_topics</code> - <?php esc_html_e( 'Most forum topics', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>most_forum_posts</code> - <?php esc_html_e( 'Most forum posts', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> active</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>type="popular"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'order', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Sort order direction', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Options:', 'shortcodes-for-buddypress' ); ?></strong> ASC or DESC</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> DESC</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>order="ASC"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'orderby', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Field to order results by', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Options:', 'shortcodes-for-buddypress' ); ?></strong> date_created, last_activity, total_member_count, name, random</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> last_activity</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>orderby="name"</code></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Group Selection -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Group Selection', 'shortcodes-for-buddypress' ); ?></h4>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'user_id', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Show only groups that a specific user belongs to', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer (user ID)</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>user_id="1"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'include', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Include only specific group IDs', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> comma-separated group IDs</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>include="1,5,10,15"</code></p>
						<p class="notice notice-info" style="padding: 10px;"><?php esc_html_e( 'Note: When used, this overrides most other filters', 'shortcodes-for-buddypress' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'exclude', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Exclude specific group IDs', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> comma-separated group IDs</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>exclude="2,3,4"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'parent_id', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Show only subgroups of a specific parent group', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer (parent group ID)</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>parent_id="5"</code></p>
						<p class="notice notice-info" style="padding: 10px;"><?php esc_html_e( 'Note: Requires hierarchical groups feature', 'shortcodes-for-buddypress' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Group Type & Status -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Group Type & Status', 'shortcodes-for-buddypress' ); ?></h4>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'group_type', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Filter by specific group type(s)', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> string or comma-separated types</p>
						<p><strong><?php esc_html_e( 'Examples:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>group_type="team"</code> - <?php esc_html_e( 'Single group type', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>group_type="team,project"</code> - <?php esc_html_e( 'Multiple group types', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'status', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Filter by group privacy status', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Options:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>public</code> - <?php esc_html_e( 'Public groups only', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>private</code> - <?php esc_html_e( 'Private groups only', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>hidden</code> - <?php esc_html_e( 'Hidden groups only', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>status="public"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'show_hidden', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Whether to show hidden groups', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> boolean</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> false</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>show_hidden="true"</code></p>
						<p class="notice notice-info" style="padding: 10px;"><?php esc_html_e( 'Note: Users can only see hidden groups they belong to', 'shortcodes-for-buddypress' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Search & Meta -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Search & Meta Filtering', 'shortcodes-for-buddypress' ); ?></h4>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'search_terms', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Search groups by keywords (searches name and description)', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> string</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>search_terms="photography"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'meta_query', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Filter by group meta data', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Format:', 'shortcodes-for-buddypress' ); ?></strong> key:value</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>meta_query="location:London"</code></p>
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
						<label><?php esc_html_e( 'populate_extras', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Fetch additional group data (member count, last activity)', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> boolean</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> true</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>populate_extras="false"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'update_meta_cache', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Pre-fetch group meta data for better performance', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> boolean</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> true</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>update_meta_cache="false"</code></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Complex Examples -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Complex Examples', 'shortcodes-for-buddypress' ); ?></h4>
			<div class="wbcom-code-examples">
				<p><strong><?php esc_html_e( 'Grid of popular public groups:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[groups-listing type="popular" status="public" layout="grid" columns="3" per_page="9"]</code></p>

				<p><strong><?php esc_html_e( 'User\'s groups sorted alphabetically:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[groups-listing user_id="1" type="alphabetical" per_page="15"]</code></p>

				<p><strong><?php esc_html_e( 'Newest groups of specific type:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[groups-listing group_type="team" type="newest" max="20"]</code></p>

				<p><strong><?php esc_html_e( 'Search with specific groups included:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[groups-listing search_terms="development" include="1,2,3" per_page="10"]</code></p>

				<p><strong><?php esc_html_e( 'Active groups excluding certain IDs:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[groups-listing type="active" exclude="5,10,15" show_hidden="false"]</code></p>

				<p><strong><?php esc_html_e( 'Groups with custom meta:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[groups-listing meta_query="featured:yes" layout="grid" avatar_size="full"]</code></p>
			</div>
		</div>

		<!-- Tips & Best Practices -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Tips & Best Practices', 'shortcodes-for-buddypress' ); ?></h4>
			<ul style="margin-left: 20px;">
				<li><?php esc_html_e( 'Use "max" parameter to limit database queries on large sites', 'shortcodes-for-buddypress' ); ?></li>
				<li><?php esc_html_e( 'Grid layout works best with square group avatars', 'shortcodes-for-buddypress' ); ?></li>
				<li><?php esc_html_e( 'Combine "group_type" with "status" for precise filtering', 'shortcodes-for-buddypress' ); ?></li>
				<li><?php esc_html_e( 'Use "populate_extras=false" for better performance when extra data is not needed', 'shortcodes-for-buddypress' ); ?></li>
				<li><?php esc_html_e( 'Hidden groups will only show to members or if "show_hidden=true" with proper permissions', 'shortcodes-for-buddypress' ); ?></li>
				<li><?php esc_html_e( 'The "user_id" parameter is great for creating "My Groups" sections', 'shortcodes-for-buddypress' ); ?></li>
			</ul>
		</div>

	</div>
</div>