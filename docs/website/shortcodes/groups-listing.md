# [groups-listing]

Renders the BuddyPress groups directory. Requires the Groups component. If Groups is disabled, administrators see a "please enable the group component" notice and visitors see nothing.

## Basic usage

```
[groups-listing]
[groups-listing type="popular" per_page="6"]
[groups-listing grid="yes" loop_layout="two"]
[groups-listing status="public"]
[groups-listing orderby="name" order="ASC"]
```

## Attributes

These are the exact attributes and defaults the shortcode accepts.

| Attribute | Default | Description |
|---|---|---|
| `title` | (empty) | Heading shown above the listing. Empty means no heading. |
| `type` | `alphabetical` | Ordering shortcut. Standard values include `active`, `newest`, `alphabetical`, `popular`, `random`. See the ordering note below. |
| `order` | `DESC` | Sort direction, `ASC` or `DESC`, used with `orderby`. |
| `orderby` | `last_activity` | Field to order by, for example `last_activity`, `name`, `date_created`. |
| `page` | `1` | Page number. |
| `per_page` | `20` | Groups per page. |
| `max` | `false` | Maximum number of groups to return. |
| `show_hidden` | `false` | Set to `true` to include hidden groups. Only honoured for site administrators and moderators (users with the `bp_moderate` capability); for everyone else hidden groups stay hidden. |
| `status` | (empty) | Limit to a group status: `public`, `private`, or `hidden`. `hidden` lists nothing for anyone without the `bp_moderate` capability (site administrators and moderators). |
| `page_arg` | `grpage` | Query-string argument used for pagination. Give two listings on one page different values so their page links work separately. |
| `user_id` | `false` | Limit to a user's groups. |
| `slug` | `false` | Limit to one or more groups by slug (comma-separated). A slug that matches no group lists nothing. |
| `search_terms` | `false` | Search keywords. |
| `group_type` | `false` | Group type slug to filter by. |
| `group_type__in` | (empty) | Comma-separated group types to include. |
| `group_type__not_in` | (empty) | Comma-separated group types to exclude. |
| `meta_query` | `false` | Group meta query. It is an array, which a shortcode string cannot carry, so set it from the `group_shortcode_bash_query_args` filter. |
| `use_compat` | theme value | Theme-compat flag; defaults to the site's BuddyPress theme-compat setting. |
| `include` | `false` | Comma-separated group IDs to include. |
| `exclude` | `false` | Comma-separated group IDs to exclude. |
| `parent_id` | `0` | Parent group ID for hierarchical groups. |
| `update_meta_cache` | `true` | Whether to prime the group meta cache. |
| `container_class` | `group` | Extra CSS class on the wrapper. |
| `grid` | `yes` | `yes` for a grid layout, `no` for a plain list. |
| `loop_layout` | `three` | Grid columns when `grid="yes"`: `one`, `two`, `three`, or `four`. |

## Notes

- **Ordering vs type.** Inside BuddyPress, `type` overrides `orderby` and `order`. Because this shortcode defaults `type` to `alphabetical`, a custom `orderby` or `order` would normally be ignored. To fix this, when you set `orderby` or `order` to anything other than the defaults and leave `type` at `alphabetical`, the shortcode drops the default `type` so your ordering applies. An explicit `type=` you pass still takes priority, matching BuddyPress behaviour.
- **`status`.** The `status` attribute (added in 3.0.0) limits the directory to a single group status. It only takes effect when set; empty means all statuses the visitor may see.
- **Reign theme.** When the active theme is Reign, Reign's group-directory card classes are added to the list. `grid="no"` and `loop_layout` are still honoured. When you leave out `loop_layout`, the column count follows the BuddyPress directory layout set for the site, and a `loop_layout` you write always wins.
- **BuddyBoss.** When the BuddyBoss Platform is active, the groups template switches to the BuddyBoss variant automatically. `loop_layout="one"`, `two` and `four` give that many columns, and the Join button row carries the `groups-meta` class so the theme's group button styling applies.
- **Cover images.** Each group card shows the group's own cover image. BuddyX, BuddyX Pro and Reign draw it with their own group cover. No cover shows when group cover uploads are switched off in BuddyPress.
- **Search.** A search term with an ampersand, such as `search_terms="Hiring & Careers"`, finds the group.
- Empty and `false` attributes are stripped before the query runs, so they do not constrain results.
