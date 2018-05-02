<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table class="form-table">
	<tr>
		<th scope="row">Shortcode</th>
		<th scope="row">Accepted Parameters</th>
	</tr>
	<tr>
		<th scope="row">[groups-listing]</th>
		<td>
			<p>
				<strong>title</strong>(string) :- What should be the title of the groups section.
			</p>
			<p>
				<strong>type</strong>(string):- Shorthand for certain orderby/order combinations. 'newest', 'active', 'popular', 'alphabetical', 'random'. When present, will override orderby and order params. Default: null.
			</p>
			<p>
				<strong>order</strong>(string):- Sort order. 'ASC' or 'DESC'. Default: 'DESC'.
			</p>
			<p>
				<strong>orderby</strong>(string):- Property to sort by. 'date_created', 'last_activity', 'total_member_count', 'name', 'random'. Default: 'last_activity'.
			</p>
			<p>
				<strong>per_page</strong>(int|bool):- Number of items to return per page of results. Default: 20.
			</p>
			<p>
				<strong>page</strong>(int|bool):- Page offset of results to return. Default: 1 (first page of results).
			</p>
			<p>
				<strong>max</strong>(int|bool):- Does NOT affect query. May change the reported number of total groups found, but not the actual number of found groups. Default: false.
			</p>
			<p>
				<strong>show_hidden</strong>(bool):- Whether to include hidden groups in results. Default: false.
			</p>
			<p>
				<strong>page_arg</strong>(string):- Query argument used for pagination. Default: 'grpage'.
			</p>
			<p>
				<strong>slug</strong>(string):- If provided, only the group with the matching slug will be returned. Default: false.
			</p>
			<p>
				<strong>include</strong>(int|string):- Array or comma-separated list of group IDs. Results will be limited to groups within the list. Default: false.
			</p>
			<p>
				<strong>exclude</strong>(int|string):- Array or comma-separated list of group IDs. Results will exclude the listed groups. Default: false.
			</p>
			<p>
				<strong>user_id</strong>(int):- If provided, results will be limited to groups of which the specified user is a member. Default: value of bp_displayed_user_id().
			</p>
			<p>
				<strong>group_type</strong>(array|string):- Array or comma-separated list of group types to limit results to.
			</p>
			<p>
				<strong>member_type__in</strong> (array|string):- Array or comma-separated list of group types to limit results to.
			</p>
			<p>
				<strong>member_type__not_in</strong> (array|string):- Array or comma-separated list of group types that will be excluded from results.
			</p>
			<p>
				<strong>search_terms</strong> (string):- If provided, only groups whose names or descriptions match the search terms will be returned. Default: value of `$_REQUEST['groups_search']` or `$_REQUEST['s']`, if present. Otherwise false.
			</p>
			<p>
				<strong>meta_query</strong> (array):- An array of meta_query conditions.
			</p>
			<p>
				<strong>parent_id</strong> (array|string):- Array or comma-separated list of group IDs. Results will include only child groups of the listed groups. Default: null.
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">How to use</th>
		<td>
			<p><b>[groups-listing user_id=1]</b></p>

            <p><b>[groups-listing per_page=10]</b></p>

            <p><b>[groups-listing search_terms='awesome']</b></p>

            <p><b>[groups-listing exclude='47,50']</b></p>
        </td>
	</tr>
</table>