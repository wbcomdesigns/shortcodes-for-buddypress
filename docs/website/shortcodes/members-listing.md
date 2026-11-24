# [members-listing]

Renders the BuddyPress members directory. Requires the Members component. If it is disabled, administrators see a "please enable BuddyPress" notice and visitors see nothing.

## Basic usage

```
[members-listing]
[members-listing type="newest" per_page="12"]
[members-listing grid="yes" loop_layout="four"]
[members-listing include="1,5,10"]
[members-listing member_type="student" per_page="20"]
```

## Attributes

These are the exact attributes and defaults the shortcode accepts.

| Attribute | Default | Description |
|---|---|---|
| `title` | (empty) | Heading shown above the listing. Empty means no heading. |
| `type` | `active` | Ordering. Standard BuddyPress values include `active`, `newest`, `alphabetical`, `online`, `random`. |
| `page` | `false` | Page number. |
| `per_page` | `20` | Members per page. |
| `max` | `false` | Maximum number of members to return. |
| `page_arg` | `upage` | Query-string argument used for pagination. Give two listings on one page different values so their page links work separately. |
| `include` | `false` | Comma-separated user IDs to include. |
| `exclude` | `false` | Comma-separated user IDs to exclude. |
| `user_id` | `false` | Limit to a user's connections (friends). |
| `user_ids` | `false` | Explicit set of user IDs. |
| `member_type` | `false` | Member type slug to filter by. |
| `include_member_role` | (empty) | Comma-separated WordPress roles; their users are added to `include`. A role nobody holds lists no members. |
| `exclude_member_role` | (empty) | Comma-separated WordPress roles; their users are added to `exclude`. |
| `member_type__in` | (empty) | Comma-separated member types to include. |
| `member_type__not_in` | (empty) | Comma-separated member types to exclude. |
| `search_terms` | `false` | Search keywords. |
| `xprofile_query` | `false` | Extended-profile field query. It is an array, which a shortcode string cannot carry, so set it from the `member_shortcode_bash_query_args` filter. |
| `use_compat` | theme value | Theme-compat flag; defaults to the site's BuddyPress theme-compat setting. |
| `meta_key` | `false` | User meta key to filter by. |
| `meta_value` | `false` | User meta value to filter by. |
| `populate_extras` | `false` | Whether to populate extra member data. |
| `container_class` | `members` | Extra CSS class on the wrapper. |
| `grid` | `yes` | `yes` for a grid layout, `no` for a plain list. |
| `loop_layout` | `three` | Grid columns when `grid="yes"`: `one`, `two`, `three`, or `four`. |

## Notes

- **Role filtering.** `include_member_role` and `exclude_member_role` are resolved into user IDs and merged into `include` / `exclude` before the query runs. They are a convenience specific to this plugin, not native BuddyPress attributes.
- **Reign theme.** When the active theme is Reign, Reign's member-directory card classes are added to the list so it matches the theme's directory styling. `grid="no"` and `loop_layout` are still honoured. When you leave out `loop_layout`, the column count follows the BuddyPress directory layout set for the site, and a `loop_layout` you write always wins.
- **Cover images.** Member cover images are rendered through a theme-aware helper for the BuddyX and Reign themes.
- **BuddyBoss.** When the BuddyBoss Platform is active, the members template switches to the BuddyBoss variant automatically. `loop_layout="one"`, `two` and `four` give that many columns, and `one` is a single column on every theme.
- **Search.** A search term with an ampersand is no longer cut at the ampersand.
