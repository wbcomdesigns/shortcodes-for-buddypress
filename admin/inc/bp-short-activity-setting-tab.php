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
		<th scope="row">[activity-listing]</th>
		<td>
			<p>
				<strong>title</strong>(string) :- What should be the title of the activities section
			</p>
			<p>
				<strong>display_comments</strong>(sting|bool):- How to handle activity comments.<br/>
                    <b>Possible values:</b> - 'threaded' - comments appear in a threaded tree, under their parent items.<br/>
                    - 'stream' - the activity stream is presented in a flat manner, with comments sorted in chronological order alongside other activity items.<br/>
                    - false - don't fetch activity comments at all.<br/>
                    Default: 'threaded'.
			</p>
			<p>
				<strong>include</strong>(array|bool):- Array of exact activity IDs to query. Providing an 'include' array will override all other filters passed in the argument array. When viewing the permalink page for a single activity item, this value defaults to the ID of that item. Otherwise the default is false.
			</p>
			<p>
				<strong>in</strong>(array|bool):- Array of IDs to limit query by (IN). 'in' is intended to be used in conjunction with other filter parameters. Default: false.
			</p>
			<p>
				<strong>exclude</strong>(array|bool):- Array of activity IDs to exclude. Default: false.
			</p>
			<p>
				<strong>sort</strong>(string):- 'ASC' or 'DESC'. Default: 'DESC'.
			</p>
			<p>
				<strong>page</strong> (int):- Which page of results to fetch. Using page=1 without per_page will result in no pagination. Default: 1.
			</p>
			<p>
				<strong>show_hidden</strong>(bool):- Whether to include hidden groups in results. Default: false.
			</p>
			<p>
				<strong>page_args</strong>(int):- String used as a query parameter in pagination links. Default: 'acpage'.
			</p>
			<p>
				<strong>max</strong>(int):- Limit the maximum no. of activities to be included in the list
			</p>
			<p>
				<strong>fields</strong>(string):- Activity fields to retrieve. 'all' to fetch entire activity objects, 'ids' to get only the activity IDs. Default 'all'.
			</p>
			<p>
				<strong>scope</strong>(string):- Use a BuddyPress pre-built filter.
                    <br/>   - 'just-me' retrieves items belonging only to a user; this is equivalent to passing a 'user_id' argument.
                    <br/>   - 'friends' retrieves items belonging to the friends of a user.
                    <br/>   - 'groups' retrieves items belonging to groups to which a user belongs to.
                    <br/>   - 'favorites' retrieves a user's favorited activity items.
                    <br/>   - 'mentions' retrieves items where a user has received an @-mention.
                    <br/>   The default value of 'scope' is set to one of the above if that value appears in the appropriate place in the URL; eg, 'scope' will be 'groups'
                    <br/>   when visiting http://example.com/members/joe/activity/groups/.
                    <br/>   Otherwise defaults to false.
			</p>
			<p>
				<strong>user_id</strong>(int):- If you want to list a&nbsp;particular&nbsp;user’s activity
			</p>
			<p>
				<strong>object</strong>(string):-&nbsp;object to filter on e.g. groups, profile, status, friends(what type of activity is this)
			</p>
			<p>
				<strong>action</strong>(string):-&nbsp;action to filter on e.g. activity_update, new_forum_post, profile_updated(why this activity was created)
			</p>
			<p>
				<strong>primary_id</strong>(int):-&nbsp;object ID to filter on e.g. a group_id or forum_id or blog_id etc. We will see the use in a minute.
			</p>
			<p>
				<strong>secondary_id</strong>(int):-&nbsp;secondary object ID to filter on e.g. a post_id(I don’t think you are going to use it)
			</p>
			<p>
				<strong>search_terms</strong>(String):- In case you want to list the results of activity search
			</p>
			<p>
				<strong>allow_posting</strong>(int):- If you want to allow users to post. It will include the default activity posting form. It is experimental and may have issues on some of the themes.
			</p>
			<p>
				<strong>hide_on_activity</strong>(int):- Default 1. Hide/show the shortcode content on activity pages(If you are using it in sidebar and want it to be visible on user/group/site activity page, set it to 0)
			</p>
			<p>
				<strong>hide_on_activity</strong>(int):- Default 1. Hide/show the shortcode content on activity pages(If you are using it in sidebar and want it to be visible on user/group/site activity page, set it to 0)
			</p>
			<p>
				<strong>container_class</strong>(string):- Default ‘activity’ . Allows to change the class of the shortcode contents wrapper. If you have the hide_on_activity=0, then please set it to some other value than ‘activity'(May be ‘activities’ or something else). If you do not change it, On the user/group/site activity page, the activity filter will affect the content of the shotrcode. It is suggested to change it if hide_on_activity=0 is set.
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">How to use</th>
		<td>
			<p><b>[activity-listing user_id=1]</b></p>
            <p><b>[activity-listing per_page=10]</b></p>
            <p><b>[activity-listing search_terms='awesome']</b></p>
            <p><b>[activity-listing object=groups]</b></p>
            <p><b>[activity-listing object=groups primary_id=2]</b></p>
        </td>
	</tr>
</table>