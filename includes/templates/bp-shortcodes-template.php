<div class="bpsh-admin-screen">
    <h3> BuddyPress Shortcodes </h3>
    <div class="bpsh-admin-content">
        BuddyPress Shortcode plugin allows you to embed BuddyPress Activities, BuddyPress Members and Groups in posts/pages using shortcodes.
        <div class="bpsh-admin-shortcode-title"> Activity Shortcodes: </div>
        <div class="bpsh-admin-shortcode">
            <b>[activity-listing]</b>
        </div>
        <div class="bpsh-admin-shortcode-content">
            <p>Here is the way you can specify options</p>
            <p class="bpsh-admin-shortcode">
                <strong>[activity-listing option_name=option_val option_name2=option_val2  and so on]</strong>
            </p>
            <p>The accepted parameters:-</p>
            <ul>
                <li>
                    <strong>title</strong>(string) :- what should be the title of the activities section
                </li>
                <li>
                    <strong>pagination</strong>(int):- 0 or 1(do you want to hide or show the activity pagination at the bottom of the list)
                </li>
                <li>
                    <strong>display_comments</strong>(sting, int):- possible values are threaded|stream|0(use 0 to hide activity comments)
                </li>
                <li>
                    <strong>include</strong>(int|string):- individual activity id or comma separated list of activities, useful in case you want to list specific activities
                </li>
                <li>
                    <strong>exclude</strong>(int|string):-individual activity id or comma separated list of activities, useful in case you want to exclude specific activities from the list
                </li>
                <li>
                    <strong>sort</strong>(string):- ASC|DESC (how to sort the activities in ascending or descending order)
                </li>
                <li>
                    <strong>page</strong> (int):- which page to load, e.g 1st page or 10th page of activity
                </li>
                <li>
                    <strong>per_page</strong>(int):- How many activities per page(default is 5)
                </li>
                <li>
                    <strong>max</strong>(int):- Limit the maximum no. of activities to be included in the list
                </li>
                <li>
                    <strong>scope</strong>(string):-&nbsp;&ndash; pre-built activity filters for a user (possible values are friends/groups/favorites/mentions)
                </li>
                <li>
                    <strong>user_id</strong>(int):- If you want to list a&nbsp;particular&nbsp;user’s activity
                </li>
                <li>
                    <strong>object</strong>(string):-&nbsp;object to filter on e.g. groups, profile, status, friends(what type of activity is this)
                </li>
                <li>
                    <strong>action</strong>(string):-&nbsp;action to filter on e.g. activity_update, new_forum_post, profile_updated(why this activity was created)
                </li>
                <li>
                    <strong>primary_id</strong>(int):-&nbsp;object ID to filter on e.g. a group_id or forum_id or blog_id etc. We will see the use in a minute.
                </li>
                <li>
                    <strong>secondary_id</strong>(int):-&nbsp;secondary object ID to filter on e.g. a post_id(I don’t think you are going to use it)
                </li>
                <li>
                    <strong>search_terms</strong>(String):- In case you want to list the results of activity search
                </li>
                <li>
                    <strong>allow_posting</strong>(int):- If you want to allow users to post. It will include the default activity posting form. It is experimental and may have issues on some of the themes.
                </li>
                <li>
                    <strong>hide_on_activity</strong>(int):- Default 1. Hide/show the shortcode content on activity pages(If you are using it in sidebar and want it to be visible on user/group/site activity page, set it to 0)
                </li>
                <li>
                    <strong>container_class</strong>(string):- Default ‘activity’ . Allows to change the class of the shortcode contents wrapper. If you have the hide_on_activity=0, then please set it to some other value than ‘activity'(May be ‘activities’ or something else). If you do not change it, On the user/group/site activity page, the activity filter will affect the content of the shotrcode. It is suggested to change it if hide_on_activity=0 is set.
                </li>
            </ul>
            <p>We will see some examples in a minute. Before that, I will just like to clarify that you can use the combination of above options to list any type of activity you want.</p>
            <div class="bpsh-admin-shortcode">
                <h3>Examples:-</h3>

                <p><b>[activity-listing user_id=1]</b></p>

                <p><b>[activity-listing per_page=10]</b></p>

                <p><b>[activity-listing search_terms='awesome']</b></p>

                <p><b>[activity-listing object=groups]</b></p>

                <p><b>[activity-listing object=groups primary_id=2]</b></p>
            </div>
            <p>Well guys, It’s up to you to explore the possibilities.</b></p>
        </div>
        <div class="bpsh-admin-shortcode-title"> Members Shortcodes :- </div>
        <div class="bpsh-admin-shortcode">
            <b>[members-listing]</b>
        </div>
        <div class="bpsh-admin-shortcode-title"> Group Shortcodes :- </div>
        <div class="bpsh-admin-shortcode">
            <b>[groups-listing]</b>
        </div>
    </div>
</div>