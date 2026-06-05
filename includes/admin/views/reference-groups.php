<?php
/**
 * Reference tab: [groups-listing] parameters.
 *
 * Informational documentation panel (ported from the legacy Groups
 * settings tab). Rendered inside shell.php — saves nothing.
 *
 * @package Shortcodes_For_Buddypress
 * @since   3.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Groups Listing Shortcode', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-card__desc"><?php esc_html_e( 'The [groups-listing] shortcode displays BuddyPress groups with powerful filtering and display options.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<p><code class="bpsp-code-block">[groups-listing]</code> <?php esc_html_e( 'Display all groups with default settings.', 'shortcodes-for-buddypress' ); ?></p>
		<p><code class="bpsp-code-block">[groups-listing per_page="6" type="popular"]</code> <?php esc_html_e( 'Show the 6 most popular groups.', 'shortcodes-for-buddypress' ); ?></p>
		<p><code class="bpsp-code-block">[groups-listing show_hidden="false" per_page="10"]</code> <?php esc_html_e( 'Show only public groups.', 'shortcodes-for-buddypress' ); ?></p>
		<p><code class="bpsp-code-block">[groups-listing search_terms="tech" max="20"]</code> <?php esc_html_e( 'Search for tech-related groups.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Display & Pagination', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<table class="form-table">
		<tr>
			<th scope="row"><code>title</code></th>
			<td><p class="description"><?php esc_html_e( 'Display a title above the groups list. Type: string.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>layout</code></th>
			<td><p class="description"><?php esc_html_e( 'Layout style: list or grid. Default: list.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>columns</code></th>
			<td><p class="description"><?php esc_html_e( 'Number of columns for grid layout (2-5). Default: 3. Only applies when layout="grid".', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>avatar_size</code></th>
			<td><p class="description"><?php esc_html_e( 'Group avatar size: thumb (50px) or full (150px). Default: thumb.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>per_page</code></th>
			<td><p class="description"><?php esc_html_e( 'Groups per page. Integer. Default: 20.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>page</code></th>
			<td><p class="description"><?php esc_html_e( 'Which page of results to display. Integer. Default: 1.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>max</code></th>
			<td><p class="description"><?php esc_html_e( 'Maximum total groups to retrieve. Integer or false (unlimited). Default: false.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
	</table>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Sorting & Filtering', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<table class="form-table">
		<tr>
			<th scope="row"><code>type</code></th>
			<td>
				<p class="description"><?php esc_html_e( 'Sort groups by criteria. Default: active.', 'shortcodes-for-buddypress' ); ?></p>
				<ul class="bpsp-doc-list">
					<li><code>active</code> — <?php esc_html_e( 'Recently active groups', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>newest</code> — <?php esc_html_e( 'Newest created groups', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>alphabetical</code> — <?php esc_html_e( 'Alphabetical by group name', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>random</code> — <?php esc_html_e( 'Random order', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>popular</code> — <?php esc_html_e( 'Most members', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>most_forum_topics</code> — <?php esc_html_e( 'Most forum topics', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>most_forum_posts</code> — <?php esc_html_e( 'Most forum posts', 'shortcodes-for-buddypress' ); ?></li>
				</ul>
			</td>
		</tr>
		<tr>
			<th scope="row"><code>order</code></th>
			<td><p class="description"><?php esc_html_e( 'Sort direction: ASC or DESC. Default: DESC.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>orderby</code></th>
			<td><p class="description"><?php esc_html_e( 'Field to order by: date_created, last_activity, total_member_count, name, random. Default: last_activity.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
	</table>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Selection, Type & Status', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<table class="form-table">
		<tr>
			<th scope="row"><code>user_id</code></th>
			<td><p class="description"><?php esc_html_e( 'Show only groups a specific user belongs to. Integer (user ID).', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>include</code></th>
			<td><p class="description"><?php esc_html_e( 'Include only specific group IDs (comma-separated). Overrides most other filters.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>exclude</code></th>
			<td><p class="description"><?php esc_html_e( 'Exclude specific group IDs (comma-separated).', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>parent_id</code></th>
			<td><p class="description"><?php esc_html_e( 'Show only subgroups of a parent group. Integer. Requires hierarchical groups.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>group_type</code></th>
			<td><p class="description"><?php esc_html_e( 'Filter by group type(s). String or comma-separated, e.g. group_type="team,project".', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>status</code></th>
			<td><p class="description"><?php esc_html_e( 'Filter by privacy: public, private, or hidden.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>show_hidden</code></th>
			<td><p class="description"><?php esc_html_e( 'Whether to show hidden groups. Boolean. Default: false. Users only see hidden groups they belong to.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>search_terms</code></th>
			<td><p class="description"><?php esc_html_e( 'Search groups by keywords (name and description). Type: string.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>meta_query</code></th>
			<td><p class="description"><?php esc_html_e( 'Filter by group meta. Format key:value, e.g. meta_query="location:London".', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
	</table>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Complex Examples', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<p><code class="bpsp-code-block">[groups-listing type="popular" status="public" layout="grid" columns="3" per_page="9"]</code></p>
		<p><code class="bpsp-code-block">[groups-listing user_id="1" type="alphabetical" per_page="15"]</code></p>
		<p><code class="bpsp-code-block">[groups-listing group_type="team" type="newest" max="20"]</code></p>
		<p><code class="bpsp-code-block">[groups-listing meta_query="featured:yes" layout="grid" avatar_size="full"]</code></p>
	</div>
</div>
