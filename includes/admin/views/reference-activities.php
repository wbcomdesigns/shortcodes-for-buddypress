<?php
/**
 * Reference tab: [activity-listing] parameters.
 *
 * Informational documentation panel (ported from the legacy Activities
 * settings tab). Rendered inside shell.php — saves nothing.
 *
 * @package Shortcodes_For_Buddypress
 * @since   3.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Activity Listing Shortcode', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-card__desc"><?php esc_html_e( 'The [activity-listing] shortcode embeds BuddyPress activity streams anywhere on your site.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<p><code class="bpsp-code-block">[activity-listing]</code> <?php esc_html_e( 'Display the default activity stream.', 'shortcodes-for-buddypress' ); ?></p>
		<p><code class="bpsp-code-block">[activity-listing title="Latest Activities" per_page="5"]</code> <?php esc_html_e( 'Show 5 activities with a title.', 'shortcodes-for-buddypress' ); ?></p>
		<p><code class="bpsp-code-block">[activity-listing object="groups" user_id="1"]</code> <?php esc_html_e( 'Show group activities for user 1.', 'shortcodes-for-buddypress' ); ?></p>
		<p><code class="bpsp-code-block">[activity-listing scope="friends" per_page="10"]</code> <?php esc_html_e( 'Show friends activities.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Display & Pagination', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<table class="form-table">
		<tr>
			<th scope="row"><code>title</code></th>
			<td><p class="description"><?php esc_html_e( 'Display a title above the activity list. Type: string.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>pagination</code></th>
			<td><p class="description"><?php esc_html_e( 'Enable/disable pagination links. Boolean (0 or 1). Default: 1.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>load_more</code></th>
			<td><p class="description"><?php esc_html_e( 'Show a "Load More" button instead of pagination. Boolean (0 or 1). Default: 0.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>allow_posting</code></th>
			<td><p class="description"><?php esc_html_e( 'Allow users to post new activities from the shortcode. Boolean. Default: false.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>per_page</code></th>
			<td><p class="description"><?php esc_html_e( 'Number of activities per page. Integer. Default: 10.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>page</code></th>
			<td><p class="description"><?php esc_html_e( 'Which page of results to display. Integer. Default: 1.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>max</code></th>
			<td><p class="description"><?php esc_html_e( 'Maximum total activities to retrieve. Integer or false (unlimited). Default: false.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
	</table>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Filtering', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<table class="form-table">
		<tr>
			<th scope="row"><code>scope</code></th>
			<td>
				<p class="description"><?php esc_html_e( 'Pre-built activity filters.', 'shortcodes-for-buddypress' ); ?></p>
				<ul class="bpsp-doc-list">
					<li><code>just-me</code> — <?php esc_html_e( 'Current user activities only', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>friends</code> — <?php esc_html_e( 'Friends activities', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>groups</code> — <?php esc_html_e( 'Groups the user belongs to', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>favorites</code> — <?php esc_html_e( 'Favorited activities', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>mentions</code> — <?php esc_html_e( '@mentions of current user', 'shortcodes-for-buddypress' ); ?></li>
				</ul>
			</td>
		</tr>
		<tr>
			<th scope="row"><code>user_id</code></th>
			<td><p class="description"><?php esc_html_e( 'Show activities from specific user(s). Integer or comma-separated IDs, e.g. user_id="1,2,3".', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>object</code></th>
			<td>
				<p class="description"><?php esc_html_e( 'Filter by BuddyPress component.', 'shortcodes-for-buddypress' ); ?></p>
				<ul class="bpsp-doc-list">
					<li><code>activity</code> — <?php esc_html_e( 'Status updates', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>groups</code> — <?php esc_html_e( 'Group activities', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>friends</code> — <?php esc_html_e( 'Friendship connections', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>blogs</code> — <?php esc_html_e( 'Blog posts and comments', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>profile</code> — <?php esc_html_e( 'Profile updates', 'shortcodes-for-buddypress' ); ?></li>
				</ul>
			</td>
		</tr>
		<tr>
			<th scope="row"><code>action</code></th>
			<td><p class="description"><?php esc_html_e( 'Filter by activity types, e.g. action="activity_update,new_blog_post".', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>search_terms</code></th>
			<td><p class="description"><?php esc_html_e( 'Search activities by keywords. Type: string.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
	</table>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Advanced', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<table class="form-table">
		<tr>
			<th scope="row"><code>sort</code></th>
			<td><p class="description"><?php esc_html_e( 'Sort order: ASC (oldest first) or DESC (newest first). Default: DESC.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>include</code></th>
			<td><p class="description"><?php esc_html_e( 'Show only specific activity IDs (comma-separated). Overrides all other filters.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>exclude</code></th>
			<td><p class="description"><?php esc_html_e( 'Exclude specific activity IDs (comma-separated).', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>primary_id</code></th>
			<td><p class="description"><?php esc_html_e( 'Filter by item ID (e.g. group ID for group activities). Integer or comma-separated IDs.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
	</table>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Complex Examples', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<p><code class="bpsp-code-block">[activity-listing scope="friends" per_page="15" pagination="1" title="My Friends Activities"]</code></p>
		<p><code class="bpsp-code-block">[activity-listing object="groups" primary_id="1,2,3" per_page="10"]</code></p>
		<p><code class="bpsp-code-block">[activity-listing action="activity_update" load_more="1" per_page="5"]</code></p>
		<p><code class="bpsp-code-block">[activity-listing search_terms="project" user_id="1,5,10" max="20"]</code></p>
	</div>
</div>
