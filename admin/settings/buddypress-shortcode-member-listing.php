<?php
/**
 * BuddyPress Members Shortcode Settings Page
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
			<h3><?php esc_html_e( 'Members Listing Shortcode', 'shortcodes-for-buddypress' ); ?></h3>
			<p class="wbcom-welcome-description">
				<?php esc_html_e( 'The [members-listing] shortcode allows you to display BuddyPress members directory anywhere on your site with various filtering and display options.', 'shortcodes-for-buddypress' ); ?>
			</p>
		</div>

		<!-- Basic Usage Examples -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Basic Usage Examples', 'shortcodes-for-buddypress' ); ?></h4>
			<div class="wbcom-code-examples">
				<p><code>[members-listing]</code> - <?php esc_html_e( 'Display all members with default settings', 'shortcodes-for-buddypress' ); ?></p>
				<p><code>[members-listing per_page="8" max_members="16"]</code> - <?php esc_html_e( 'Show 8 members per page, max 16 total', 'shortcodes-for-buddypress' ); ?></p>
				<p><code>[members-listing type="active" per_page="5"]</code> - <?php esc_html_e( 'Show 5 most active members', 'shortcodes-for-buddypress' ); ?></p>
				<p><code>[members-listing search_terms="developer"]</code> - <?php esc_html_e( 'Search for members with "developer" keyword', 'shortcodes-for-buddypress' ); ?></p>
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
						<p class="description"><?php esc_html_e( 'Display a title above the members list', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> string</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>title="Our Community Members"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'layout', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Layout style for members display', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Options:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>list</code> - <?php esc_html_e( 'List view with member details', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>grid</code> - <?php esc_html_e( 'Grid view with member cards', 'shortcodes-for-buddypress' ); ?></li>
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
						<p class="description"><?php esc_html_e( 'Number of members to display per page', 'shortcodes-for-buddypress' ); ?></p>
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
						<label><?php esc_html_e( 'max_members', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Maximum total members to retrieve', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer or false (unlimited)</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> false</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>max_members="100"</code></p>
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
						<p class="description"><?php esc_html_e( 'Sort members by different criteria', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Options:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>active</code> - <?php esc_html_e( 'Recently active members', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>newest</code> - <?php esc_html_e( 'Newest registered members', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>alphabetical</code> - <?php esc_html_e( 'Alphabetical by display name', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>random</code> - <?php esc_html_e( 'Random order', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>popular</code> - <?php esc_html_e( 'Most connections/friends', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>online</code> - <?php esc_html_e( 'Currently online members', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> active</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>type="newest"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'member_type', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Filter by specific member type(s)', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> string or comma-separated types</p>
						<p><strong><?php esc_html_e( 'Examples:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>member_type="student"</code> - <?php esc_html_e( 'Single member type', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>member_type="student,teacher"</code> - <?php esc_html_e( 'Multiple member types', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'search_terms', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Search members by keywords (searches display names and profile fields)', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> string</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>search_terms="designer"</code></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- User Selection -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'User Selection', 'shortcodes-for-buddypress' ); ?></h4>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'include', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Include only specific user IDs', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> comma-separated user IDs</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>include="1,5,10,15"</code></p>
						<p class="notice notice-info" style="padding: 10px;"><?php esc_html_e( 'Note: When used, this overrides most other filters', 'shortcodes-for-buddypress' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'exclude', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Exclude specific user IDs from the list', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> comma-separated user IDs</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>exclude="2,3,4"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'user_id', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Limit to specific user ID(s)', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> integer or comma-separated IDs</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>user_id="1,2,3"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'user_ids', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Alternative to user_id for specifying multiple users', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> comma-separated user IDs</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>user_ids="10,20,30,40"</code></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Profile Fields Filtering -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Profile Fields Filtering', 'shortcodes-for-buddypress' ); ?></h4>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'xprofile_query', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Filter members by profile field values', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Format:', 'shortcodes-for-buddypress' ); ?></strong> field_name:value</p>
						<p><strong><?php esc_html_e( 'Examples:', 'shortcodes-for-buddypress' ); ?></strong></p>
						<ul style="margin-left: 20px;">
							<li><code>xprofile_query="City:London"</code> - <?php esc_html_e( 'Members from London', 'shortcodes-for-buddypress' ); ?></li>
							<li><code>xprofile_query="Skills:PHP"</code> - <?php esc_html_e( 'Members with PHP skills', 'shortcodes-for-buddypress' ); ?></li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'meta_key / meta_value', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Filter by user meta data', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>meta_key="department" meta_value="marketing"</code></p>
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
						<p class="description"><?php esc_html_e( 'Fetch additional member data (last activity, friend counts)', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> boolean</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> true</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>populate_extras="false"</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php esc_html_e( 'exclude_admins_mods', 'shortcodes-for-buddypress' ); ?></label>
					</th>
					<td>
						<p class="description"><?php esc_html_e( 'Whether to exclude site admins and moderators', 'shortcodes-for-buddypress' ); ?></p>
						<p><strong><?php esc_html_e( 'Type:', 'shortcodes-for-buddypress' ); ?></strong> boolean (0 or 1)</p>
						<p><strong><?php esc_html_e( 'Default:', 'shortcodes-for-buddypress' ); ?></strong> 0</p>
						<p><strong><?php esc_html_e( 'Example:', 'shortcodes-for-buddypress' ); ?></strong> <code>exclude_admins_mods="1"</code></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Complex Examples -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Complex Examples', 'shortcodes-for-buddypress' ); ?></h4>
			<div class="wbcom-code-examples">
				<p><strong><?php esc_html_e( 'Grid of newest members:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[members-listing type="newest" layout="grid" columns="4" per_page="12"]</code></p>

				<p><strong><?php esc_html_e( 'Active members excluding admins:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[members-listing type="active" exclude_admins_mods="1" per_page="20"]</code></p>

				<p><strong><?php esc_html_e( 'Members by type with search:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[members-listing member_type="premium" search_terms="developer" max_members="50"]</code></p>

				<p><strong><?php esc_html_e( 'Specific users in random order:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[members-listing include="1,5,10,15,20" type="random" layout="grid"]</code></p>

				<p><strong><?php esc_html_e( 'Members from specific location:', 'shortcodes-for-buddypress' ); ?></strong></p>
				<p><code>[members-listing xprofile_query="Location:New York" per_page="15"]</code></p>
			</div>
		</div>

		<!-- Tips & Best Practices -->
		<div class="wbcom-admin-option-wrap">
			<h4><?php esc_html_e( 'Tips & Best Practices', 'shortcodes-for-buddypress' ); ?></h4>
			<ul style="margin-left: 20px;">
				<li><?php esc_html_e( 'Use "max_members" to limit database queries on large sites', 'shortcodes-for-buddypress' ); ?></li>
				<li><?php esc_html_e( 'Grid layout works best with 3-4 columns on desktop', 'shortcodes-for-buddypress' ); ?></li>
				<li><?php esc_html_e( 'Combine "member_type" with other filters for targeted member lists', 'shortcodes-for-buddypress' ); ?></li>
				<li><?php esc_html_e( 'Use "populate_extras=false" for better performance if extra data is not needed', 'shortcodes-for-buddypress' ); ?></li>
				<li><?php esc_html_e( 'The "online" type requires the BuddyPress "Who\'s Online" widget to be active', 'shortcodes-for-buddypress' ); ?></li>
			</ul>
		</div>

	</div>
</div>