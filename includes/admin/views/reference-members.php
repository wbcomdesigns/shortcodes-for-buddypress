<?php
/**
 * Reference tab: [members-listing] parameters.
 *
 * Informational documentation panel (ported from the legacy Members
 * settings tab). Rendered inside shell.php — saves nothing.
 *
 * @package Shortcodes_For_Buddypress
 * @since   3.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Members Listing Shortcode', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-card__desc"><?php esc_html_e( 'The [members-listing] shortcode displays a BuddyPress members directory with filtering and display options.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<p><code class="bpsp-code-block">[members-listing]</code> <?php esc_html_e( 'Display all members with default settings.', 'shortcodes-for-buddypress' ); ?></p>
		<p><code class="bpsp-code-block">[members-listing per_page="8" max_members="16"]</code> <?php esc_html_e( 'Show 8 members per page, max 16 total.', 'shortcodes-for-buddypress' ); ?></p>
		<p><code class="bpsp-code-block">[members-listing type="active" per_page="5"]</code> <?php esc_html_e( 'Show the 5 most active members.', 'shortcodes-for-buddypress' ); ?></p>
		<p><code class="bpsp-code-block">[members-listing search_terms="developer"]</code> <?php esc_html_e( 'Search members for "developer".', 'shortcodes-for-buddypress' ); ?></p>
	</div>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Display & Pagination', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<table class="form-table">
		<tr>
			<th scope="row"><code>title</code></th>
			<td><p class="description"><?php esc_html_e( 'Display a title above the members list. Type: string.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>layout</code></th>
			<td><p class="description"><?php esc_html_e( 'Layout style: list (member details) or grid (member cards). Default: list.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>columns</code></th>
			<td><p class="description"><?php esc_html_e( 'Number of columns for grid layout (2-5). Default: 3. Only applies when layout="grid".', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>per_page</code></th>
			<td><p class="description"><?php esc_html_e( 'Members per page. Integer. Default: 20.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>page</code></th>
			<td><p class="description"><?php esc_html_e( 'Which page of results to display. Integer. Default: 1.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>max_members</code></th>
			<td><p class="description"><?php esc_html_e( 'Maximum total members to retrieve. Integer or false (unlimited). Default: false.', 'shortcodes-for-buddypress' ); ?></p></td>
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
				<p class="description"><?php esc_html_e( 'Sort members by criteria. Default: active.', 'shortcodes-for-buddypress' ); ?></p>
				<ul class="bpsp-doc-list">
					<li><code>active</code> — <?php esc_html_e( 'Recently active members', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>newest</code> — <?php esc_html_e( 'Newest registered members', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>alphabetical</code> — <?php esc_html_e( 'Alphabetical by display name', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>random</code> — <?php esc_html_e( 'Random order', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>popular</code> — <?php esc_html_e( 'Most connections/friends', 'shortcodes-for-buddypress' ); ?></li>
					<li><code>online</code> — <?php esc_html_e( 'Currently online members', 'shortcodes-for-buddypress' ); ?></li>
				</ul>
			</td>
		</tr>
		<tr>
			<th scope="row"><code>member_type</code></th>
			<td><p class="description"><?php esc_html_e( 'Filter by member type(s). String or comma-separated, e.g. member_type="student,teacher".', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>search_terms</code></th>
			<td><p class="description"><?php esc_html_e( 'Search members by keywords (display names and profile fields). Type: string.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
	</table>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'User Selection & Profile Fields', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<table class="form-table">
		<tr>
			<th scope="row"><code>include</code></th>
			<td><p class="description"><?php esc_html_e( 'Include only specific user IDs (comma-separated). Overrides most other filters.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>exclude</code></th>
			<td><p class="description"><?php esc_html_e( 'Exclude specific user IDs (comma-separated).', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>user_id</code> / <code>user_ids</code></th>
			<td><p class="description"><?php esc_html_e( 'Limit to specific user ID(s). Integer or comma-separated IDs.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>xprofile_query</code></th>
			<td><p class="description"><?php esc_html_e( 'Filter by profile field values. Format field_name:value, e.g. xprofile_query="City:London".', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>meta_key / meta_value</code></th>
			<td><p class="description"><?php esc_html_e( 'Filter by user meta, e.g. meta_key="department" meta_value="marketing".', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>populate_extras</code></th>
			<td><p class="description"><?php esc_html_e( 'Fetch extra member data (last activity, friend counts). Boolean. Default: true.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><code>exclude_admins_mods</code></th>
			<td><p class="description"><?php esc_html_e( 'Exclude site admins and moderators. Boolean (0 or 1). Default: 0.', 'shortcodes-for-buddypress' ); ?></p></td>
		</tr>
	</table>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Complex Examples', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<p><code class="bpsp-code-block">[members-listing type="newest" layout="grid" columns="4" per_page="12"]</code></p>
		<p><code class="bpsp-code-block">[members-listing type="active" exclude_admins_mods="1" per_page="20"]</code></p>
		<p><code class="bpsp-code-block">[members-listing member_type="premium" search_terms="developer" max_members="50"]</code></p>
		<p><code class="bpsp-code-block">[members-listing include="1,5,10,15,20" type="random" layout="grid"]</code></p>
	</div>
</div>
