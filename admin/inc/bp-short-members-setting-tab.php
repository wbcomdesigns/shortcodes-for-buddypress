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
		<th scope="row">[members-listing]</th>
		<td>
			<p>
				<strong>title</strong>(string) :- What should be the title of the members section
			</p>
			<p>
				<strong>type</strong>(string):- Sort order. Accepts 'active', 'random', 'newest', 'popular', 'online', 'alphabetical'. Default: 'active'.
			</p>
			<p>
				<strong>per_page</strong>(int|bool):- Number of results per page. Default: 20.
			</p>
			<p>
				<strong>page</strong>(int|bool):- Page of results to display. Default: 1.
			</p>
			<p>
				<strong>max</strong>(int|bool):- Maximum number of results to return. Default: false (unlimited).
			</p>
			<p>
				<strong>include</strong>(array|int|string|bool):- Limit results by a list of user IDs. Accepts an array, a single integer, a comma-separated list of IDs, or false (to disable this limiting). Accepts 'active', 'alphabetical','newest', or 'random'. Default: false.
			</p>
			<p>
				<strong>exclude</strong>(array|int|string|bool):- Exclude users from results by ID. Accepts an array, a single integer, a comma-separated list of IDs, or false (to disable this limiting). Default: false.
			</p>
			<p>
				<strong>user_id</strong>(int):- If provided, results are limited to the friends of the specified user. When on a user's Friends page, defaults to the ID of the displayed user. Otherwise defaults to 0.
			</p>
			<p>
				<strong>member_type</strong>(string):- Can be a comma-separated list. (Note: BuddyPress itself does not register any member types. Plugins and themes can register member types using the bp_register_member_type() or the bp_register_member_types() function.)
			</p>
			<p>
				<strong>include_member_role</strong>(string):- Can be a comma-separated list of members role.
			</p>
			<p>
				<strong>exclude_member_role</strong>(string):- Can be a comma-separated list of members role.
			</p>
			<p>
				<strong>member_type__in</strong> (string):- list only these members type ( Note: This parameter will work when member types exist.)
			</p>
			<p>
				<strong>member_type__not_in</strong> (string):- not list these members type ( Note: This parameter will work when member types exist.)
			</p>
			<p>
				<strong>search_terms</strong> (string):- Limit results by a search term. Default: value of `$_REQUEST['members_search']` or `$_REQUEST['s']`, if present. Otherwise false.
			</p>
			<p>
				<strong>meta_key</strong> (string):- Limit results by the presence of a usermeta key. Default: false.
			</p>
			<p>
				<strong>meta_value</strong> (string):- When used with meta_key, limits results by the a matching usermeta value. Default: false. Requires meta_key.
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">How to use</th>
		<td>
			<p><b>[members-listing user_id=1]</b></p>
            <p><b>[members-listing per_page=10]</b></p>
            <p><b>[members-listing include_member_role='subscriber,author']</b></p>
        </td>
	</tr>
</table>