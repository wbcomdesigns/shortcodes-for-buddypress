# [activity-listing]

Renders the BuddyPress activity stream. Requires the Activity component. If Activity is disabled, administrators see a "please enable the activity component" notice and visitors see nothing.

## Basic usage

```
[activity-listing]
[activity-listing per_page="5" title="Latest activity"]
[activity-listing scope="friends" user_id="12"]
[activity-listing object="groups" per_page="10"]
```

## Attributes

These are the exact attributes and defaults the shortcode accepts.

| Attribute | Default | Description |
|---|---|---|
| `title` | (empty) | Heading shown above the listing. Empty means no heading. |
| `pagination` | `1` | Reserved display flag passed to the template. |
| `load_more` | `0` | Set to `1` to show a load-more control that fetches the next page over AJAX. |
| `display_comments` | `false` | See the note below; comments are forced off in this version. |
| `container_class` | `activity` | Extra CSS class added to the wrapper element. |
| `allow_posting` | `false` | Passed to the template to allow the post form. |
| `include` | `false` | Comma-separated activity IDs to include. |
| `exclude` | `false` | Comma-separated activity IDs to exclude. |
| `in` | `false` | Limit results to a set of activity IDs. |
| `page` | `1` | Page number. |
| `per_page` | `10` | Activities per page. |
| `max` | `false` | Maximum number of activities to return. |
| `sort` | `DESC` | Sort direction, `ASC` or `DESC`. |
| `count_total` | `true` | Whether to count the total for pagination. |
| `scope` | `false` | Activity scope, for example `friends`, `groups`, `mentions`, `favorites`. |
| `user_id` | `false` | Limit to a single user's activity. |
| `object` | `false` | Component object, for example `groups`, `activity`, `profile`. |
| `action` | `false` | Activity action type to filter by. |
| `primary_id` | `false` | Primary item ID filter (for example a group ID). |
| `secondary_id` | `false` | Secondary item ID filter. |
| `search_terms` | `false` | Search keywords. |
| `use_compat` | theme value | Theme-compat flag; defaults to the site's BuddyPress theme-compat setting. |

## Notes

- **Comments are disabled in this version.** Although `display_comments` exists as an attribute, the shortcode forces the activity query's `display_comments` to `false` before running, to avoid a BuddyPress compatibility error. Passing `display_comments="true"` has no effect in the current release.
- **BuddyBoss group activity.** When `object="groups"` and the BuddyBoss Platform is active, the shortcode sets the scope to `activity` internally so BuddyBoss group activity renders correctly.
- **Load more.** With `load_more="1"`, the next page is fetched over AJAX (see the Developer Guide). Server-side the page size is clamped to a safe maximum.
- Display-only attributes (`title`, `container_class`, `load_more`, `pagination`, `allow_posting`, `display_comments`) are not passed to the activity query; the rest become query arguments when set.
